@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Pagos a Proveedores -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cheques / Trasferencias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RESUMEN -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Total Pagos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalRegistrosCard">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Pendientes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalActivos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Aplicados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCompletados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Cancelados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCancelados">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div><input type="date" id="fechaInicio" class="form-control" style="width: 140px;"></div>
                        <div><input type="date" id="fechaFin" class="form-control" style="width: 140px;"></div>
                        <div>
                            <select id="filtroProveedor" class="form-control" style="width: 180px;" onchange="cargarChequesTransferencias()">
                                <option value="">Todos los proveedores</option>
                                @foreach($proveedores ?? [] as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px;" onclick="abrirModalPago()"><i class="fas fa-plus" style="color: #083CAE;"></i></button></div>
                        <div><button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;" onclick="exportarExcel()"><i class="fas fa-file-excel" style="color: #083CAE;"></i> Excel</button></div>
                        <div><button id="btnColumnas" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-columns" style="color: #083CAE;"></i> Columnas</button></div>
                        <div style="position: relative;"><i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i><input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;"></div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaChequesTransferencias" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="folio">Folio</th>
                                <th draggable="true" data-columna="proveedor">Proveedor</th>
                                <th draggable="true" data-columna="forma_pago">Forma de Pago</th>
                                <th draggable="true" data-columna="cuenta">Cuenta Bancaria</th>
                                <th draggable="true" data-columna="fecha">Fecha</th>
                                <th draggable="true" data-columna="referencia">Referencia</th>
                                <th draggable="true" data-columna="ref_bancaria">Referencia Bancaria</th>
                                <th draggable="true" data-columna="monto">Monto</th>
                                <th draggable="true" data-columna="monto_restante">Monto Restante</th>
                                <th draggable="true" data-columna="moneda">Moneda</th>
                                <th draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="13" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="8" style="text-align: center;">Totales:</td>
                                <td style="text-align: right;" id="sumMonto">$0.00</td>
                                <td style="text-align: right;" id="sumMontoRestante">$0.00</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #2378e1;"><i class="fas fa-filter"></i> Crear filtro</button>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="background-color: #2378e1; color: white; padding: 5px 10px; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1; margin-left: 10px;">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================================ -->
<!-- MODAL DE PAGO A PROVEEDOR - REDISEÑADO -->
<!-- ============================================ -->
<div class="modal fade" id="modalPagoProveedor" tabindex="-1" aria-labelledby="modalPagoProveedorLabel" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content payment-modal-content">
            
            <!-- ========== HEADER ========== -->
            <div class="modal-header payment-modal-header">
                <div class="payment-header-left">
                    <div class="payment-header-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="payment-header-info">
                        <h5 class="modal-title payment-modal-title" id="modalTitle">Nuevo Pago a Proveedor</h5>
                        <p class="payment-subtitle">Registra un pago y aplícalo al proveedor correspondiente.</p>
                    </div>
                </div>
                <button type="button" class="btn-close payment-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- ========== BODY ========== -->
            <div class="modal-body payment-modal-body">
                <form id="formPagoProveedor">
                    <input type="hidden" id="pago_id">
                    <input type="hidden" id="facturas_aplicadas_json" value="[]">
                    
                    <!-- ======================================== -->
                    <!-- SECCIÓN 1: DATOS DEL PAGO -->
                    <!-- ======================================== -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-credit-card section-icon"></i>
                            <span class="section-title">Datos del Pago</span>
                        </div>
                        <div class="section-body">
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Fecha <span class="text-danger">*</span></label>
                                    <input type="date" id="fecha" class="payment-input" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Cuenta Bancaria <span class="text-danger">*</span></label>
                                    <select id="cuenta_bancaria_id" class="payment-select form-select" required>
                                        <option value="">Seleccionar cuenta...</option>
                                        @foreach($cuentasBancarias ?? [] as $cuenta)
                                            <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Monto <span class="text-danger">*</span></label>
                                    <input type="number" id="monto" class="payment-input" step="0.01" required onchange="actualizarResumenFacturas()" placeholder="$0.00">
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field payment-field-full">
                                    <label class="payment-label">Referencia Bancaria</label>
                                    <input type="text" id="referencia_bancaria" class="payment-input" placeholder="Ej: TRF-123456">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ======================================== -->
                    <!-- SECCIÓN 2: ORIGEN DEL PAGO -->
                    <!-- ======================================== -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-building section-icon"></i>
                            <span class="section-title">Origen del Pago</span>
                        </div>
                        <div class="section-body">
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Proveedor <span class="text-danger">*</span></label>
                                    <select id="proveedor_select" class="payment-select form-select select2" required style="width: 100%;" onchange="cargarFacturasProveedor()">
                                        <option value="">Seleccionar proveedor...</option>
                                        @foreach($proveedores ?? [] as $proveedor)
                                            <option value="{{ $proveedor->id }}" 
                                                data-nombre="{{ $proveedor->nombre }}"
                                                data-rfc="{{ $proveedor->rfc ?? '' }}">
                                                {{ $proveedor->nombre }} - {{ $proveedor->rfc ?? 'Sin RFC' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Razón Social</label>
                                    <input type="text" id="proveedor_nombre" class="payment-input payment-input-readonly" readonly>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">RFC</label>
                                    <input type="text" id="rfc" class="payment-input payment-input-readonly" readonly>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Proyecto</label>
                                    <select id="proyecto_id" class="payment-select form-select">
                                        <option value="">Ninguno</option>
                                        @foreach($proyectos ?? [] as $proyecto)
                                            <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Código SAT <span class="text-danger">*</span></label>
                                    <select id="codigo_sat_id" class="payment-select form-select" required>
                                        <option value="">Seleccionar código SAT...</option>
                                        @foreach($codigosSatGastos ?? [] as $codigo)
                                            <option value="{{ $codigo->id }}" 
                                                data-codigo="{{ $codigo->codigo_agrupador }}"
                                                data-nombre="{{ $codigo->nombre_cuenta }}">
                                                {{ $codigo->codigo_agrupador }} - {{ $codigo->nombre_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="payment-hint" id="codigo_sat_info">
                                        <i class="fas fa-info-circle"></i> Selecciona el código SAT para este pago
                                    </small>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Forma de Pago <span class="text-danger">*</span></label>
                                    <select id="forma_pago" class="payment-select form-select" required>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ======================================== -->
                    <!-- SECCIÓN 3: APLICACIÓN DEL PAGO -->
                    <!-- ======================================== -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-receipt section-icon"></i>
                            <span class="section-title">Aplicación del Pago</span>
                        </div>
                        <div class="section-body">
                            <!-- Tarjetas de resumen -->
                            <div class="summary-cards">
                                <div class="summary-card">
                                    <div class="summary-card-header">
                                        <i class="fas fa-user-tie summary-icon"></i>
                                        <span class="summary-card-title">Proveedor</span>
                                    </div>
                                    <div class="summary-card-body">
                                        <div class="summary-item">
                                            <span class="summary-label">Saldo vencido</span>
                                            <span class="summary-value summary-value-danger" id="summaryVencido">$0.00</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Saldo por vencer</span>
                                            <span class="summary-value summary-value-warning" id="summaryPorVencer">$0.00</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Total pendiente</span>
                                            <span class="summary-value summary-value-primary" id="summaryTotal">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="summary-card summary-card-actions">
                                    <div class="summary-card-header">
                                        <i class="fas fa-magic summary-icon"></i>
                                        <span class="summary-card-title">Aplicación Automática</span>
                                    </div>
                                    <div class="summary-card-body">
                                        <p class="summary-text">Aplica el monto del pago a las facturas más antiguas primero.</p>
                                        <button type="button" class="btn-summary-action" onclick="abrirAplicacionFacturas()">
                                            <i class="fas fa-receipt"></i> Aplicar a Facturas
                                        </button>
                                        <div id="resumenFacturasAplicadas" class="summary-resumen" style="display: none;">
                                            <div class="summary-resumen-alert">
                                                <strong>Facturas seleccionadas:</strong>
                                                <span id="resumenFacturasTexto">Ninguna</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tabla de facturas (preview) -->
                            <div class="payment-table-wrapper">
                                <div class="payment-table-header">
                                    <span class="payment-table-title">Facturas del Proveedor</span>
                                    <button type="button" class="btn-table-action" onclick="abrirAplicacionFacturas()">
                                        <i class="fas fa-edit"></i> Seleccionar Facturas
                                    </button>
                                </div>
                                <div class="payment-table-container" id="facturasTableContainer">
                                    <table class="payment-table" id="tablaFacturasPreview">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">#</th>
                                                <th>Factura</th>
                                                <th>Fecha</th>
                                                <th>Vencimiento</th>
                                                <th style="text-align: right;">Total</th>
                                                <th style="text-align: right;">Saldo pendiente</th>
                                                <th style="text-align: right;">Monto aplicar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaFacturasPreviewBody">
                                            <tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                                                <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                                                Selecciona un proveedor para ver sus facturas
                                            </td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Totales de aplicación -->
                            <div class="application-totals">
                                <div class="application-total-item">
                                    <span class="application-total-label">Monto del pago</span>
                                    <span class="application-total-value" id="appTotalPago">$0.00</span>
                                </div>
                                <div class="application-total-item">
                                    <span class="application-total-label">Total aplicado</span>
                                    <span class="application-total-value" id="appTotalAplicado">$0.00</span>
                                </div>
                                <div class="application-total-item">
                                    <span class="application-total-label">Diferencia</span>
                                    <span class="application-total-value" id="appDiferencia">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ======================================== -->
                    <!-- SECCIÓN 4: DETALLE ADICIONAL -->
                    <!-- ======================================== -->
                    <div class="payment-section payment-section-last">
                        <div class="section-header">
                            <i class="fas fa-pen section-icon"></i>
                            <span class="section-title">Detalle Adicional</span>
                        </div>
                        <div class="section-body">
                            <div class="payment-row">
                                <div class="payment-field payment-field-full">
                                    <label class="payment-label">Concepto</label>
                                    <input type="text" id="descripcion" class="payment-input" placeholder="Ej: Pago de factura F-001">
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field payment-field-full">
                                    <label class="payment-label">Observaciones</label>
                                    <textarea id="observaciones" class="payment-textarea" rows="2" placeholder="Notas adicionales sobre este pago..."></textarea>
                                </div>
                            </div>
                            <div class="payment-row payment-row-switch">
                                <div class="payment-field payment-field-switch">
                                    <div class="payment-switch-container">
                                        <span class="payment-switch-label">Aplicar inmediatamente</span>
                                        <div class="payment-switch">
                                            <input type="checkbox" id="aplicar_ahora" class="payment-switch-input" checked>
                                            <label class="payment-switch-slider" for="aplicar_ahora"></label>
                                        </div>
                                        <span class="payment-switch-hint">El pago afectará saldos y reportes al guardar.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- ========== FOOTER ========== -->
            <div class="modal-footer payment-modal-footer">
                <button type="button" class="btn btn-secondary btn-payment-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-payment-save" onclick="guardarPagoProveedor()" id="btnGuardarModal">
                    <i class="fas fa-save"></i> Guardar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL PARA APLICAR FACTURAS DE PROVEEDOR -->
<!-- ============================================ -->
<div class="modal fade" id="modalAplicarFacturas" tabindex="-1" aria-hidden="true" style="z-index: 100000 !important;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content payment-modal-content">
            
            <!-- ========== HEADER ========== -->
            <div class="modal-header payment-modal-header">
                <div class="payment-header-left">
                    <div class="payment-header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="payment-header-info">
                        <h5 class="modal-title payment-modal-title">Aplicar Pago a Facturas de Proveedor</h5>
                        <p class="payment-subtitle">Selecciona las facturas que deseas pagar con este pago.</p>
                    </div>
                </div>
                <button type="button" class="btn-close payment-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- ========== BODY ========== -->
            <div class="modal-body payment-modal-body">
                <!-- Tarjetas de resumen -->
                <div class="summary-cards summary-cards-apply">
                    <div class="summary-card summary-card-proveedor">
                        <div class="summary-card-header">
                            <i class="fas fa-user-tie summary-icon"></i>
                            <span class="summary-card-title">Proveedor</span>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-item">
                                <span class="summary-label">Saldo vencido</span>
                                <span class="summary-value summary-value-danger" id="saldoVencido">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Saldo por vencer</span>
                                <span class="summary-value summary-value-warning" id="saldoPorVencer">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total pendiente</span>
                                <span class="summary-value summary-value-primary" id="saldoTotal">$0.00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-card summary-card-pago">
                        <div class="summary-card-header">
                            <i class="fas fa-hand-holding-usd summary-icon"></i>
                            <span class="summary-card-title">Pago</span>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-item">
                                <span class="summary-label">Monto del pago</span>
                                <span class="summary-value summary-value-success" id="montoPagoFacturas">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total aplicado</span>
                                <span class="summary-value summary-value-info" id="totalAplicadoFacturas">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Diferencia</span>
                                <span class="summary-value" id="diferenciaFacturas">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla de facturas -->
                <div class="payment-table-wrapper">
                    <div class="payment-table-header">
                        <span class="payment-table-title">Facturas del Proveedor</span>
                        <div class="payment-table-actions">
                            <button type="button" class="btn-table-action" onclick="aplicarAutomatico()">
                                <i class="fas fa-magic"></i> Aplicar automáticamente
                            </button>
                            <button type="button" class="btn-table-action btn-table-action-success" onclick="aplicarTodo()">
                                <i class="fas fa-check-double"></i> Aplicar todo
                            </button>
                            <button type="button" class="btn-table-action btn-table-action-danger" onclick="limpiarAplicaciones()">
                                <i class="fas fa-eraser"></i> Limpiar
                            </button>
                        </div>
                    </div>
                    <div class="payment-table-container">
                        <table class="payment-table" id="tablaFacturasAplicar">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Factura</th>
                                    <th>Fecha</th>
                                    <th>Vencimiento</th>
                                    <th style="text-align: right;">Total</th>
                                    <th style="text-align: right;">Saldo pendiente</th>
                                    <th style="text-align: right; min-width: 140px;">Monto a aplicar</th>
                                    <th style="text-align: center; width: 40px;">Todo</th>
                                </tr>
                            </thead>
                            <tbody id="tablaFacturasBody">
                                <tr><td colspan="8" style="text-align: center; padding: 40px; color: #6c757d;">
                                    <i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                    Seleccione un proveedor para ver sus facturas
                                </td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right; font-weight: 600;">Totales:</td>
                                    <td id="totalSaldoPendiente" style="text-align: right; font-weight: 600;">$0.00</td>
                                    <td id="totalMontoAplicar" style="text-align: right; font-weight: 600;">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- ========== FOOTER ========== -->
            <div class="modal-footer payment-modal-footer">
                <button type="button" class="btn btn-secondary btn-payment-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-payment-save" onclick="confirmarAplicacionFacturas()">
                    <i class="fas fa-check"></i> Aplicar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* ESTILOS DEL MODAL - REDISEÑO PROFESIONAL */
/* ============================================ */

/* ----- MODAL PRINCIPAL ----- */
.payment-modal-content {
    border: none;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    background: #F5F7FB;
    overflow: hidden;
}

/* ----- HEADER ----- */
.payment-modal-header {
    background: #FFFFFF;
    border-bottom: 1px solid #E9ECF0;
    padding: 24px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 18px 18px 0 0;
}

.payment-header-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

.payment-header-icon {
    width: 52px;
    height: 52px;
    background: #083CAE;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    flex-shrink: 0;
}

.payment-modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #1A2332;
    margin: 0;
}

.payment-subtitle {
    font-size: 14px;
    color: #6B7A8F;
    margin: 2px 0 0 0;
}

.payment-btn-close {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #F1F3F5;
    opacity: 1;
    transition: all 0.2s;
}
.payment-btn-close:hover {
    background: #E9ECF0;
    transform: rotate(90deg);
}

/* ----- BODY ----- */
.payment-modal-body {
    padding: 24px 32px 8px 32px;
    background: #F5F7FB;
}

/* ----- SECCIONES ----- */
.payment-section {
    background: #FFFFFF;
    border-radius: 16px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border: 1px solid #E9ECF0;
    overflow: hidden;
    transition: box-shadow 0.2s;
}
.payment-section:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}
.payment-section-last {
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 24px;
    background: #F8FAFC;
    border-bottom: 1px solid #E9ECF0;
}

.section-icon {
    color: #083CAE;
    font-size: 16px;
    width: 28px;
    height: 28px;
    background: #E8F0FE;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    color: #1A2332;
}

.section-body {
    padding: 20px 24px;
}

/* ----- ROWS Y FIELDS ----- */
.payment-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 16px 24px;
    margin-bottom: 12px;
}
.payment-row:last-child {
    margin-bottom: 0;
}

.payment-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.payment-field-full {
    grid-column: 1 / -1;
}

.payment-label {
    font-size: 13px;
    font-weight: 500;
    color: #4A5A6E;
    letter-spacing: 0.3px;
}

.payment-input,
.payment-select {
    height: 48px;
    padding: 0 16px;
    border: 2px solid #E2E6EA;
    border-radius: 10px;
    font-size: 14px;
    color: #1A2332;
    background: #FFFFFF;
    transition: all 0.25s ease;
    width: 100%;
    font-family: inherit;
}

.payment-input:focus,
.payment-select:focus {
    outline: none;
    border-color: #083CAE;
    box-shadow: 0 0 0 4px rgba(8,60,174,0.08);
}

.payment-input::placeholder {
    color: #AAB5C5;
}

.payment-input-readonly {
    background: #F5F7FB;
    color: #4A5A6E;
    cursor: not-allowed;
}

.payment-select {
    appearance: auto;
    -webkit-appearance: auto;
}

.payment-textarea {
    padding: 12px 16px;
    border: 2px solid #E2E6EA;
    border-radius: 10px;
    font-size: 14px;
    color: #1A2332;
    background: #FFFFFF;
    transition: all 0.25s ease;
    width: 100%;
    font-family: inherit;
    resize: vertical;
    min-height: 60px;
}
.payment-textarea:focus {
    outline: none;
    border-color: #083CAE;
    box-shadow: 0 0 0 4px rgba(8,60,174,0.08);
}

.payment-hint {
    font-size: 12px;
    color: #8A9AAE;
    margin-top: 4px;
}
.payment-hint i {
    margin-right: 4px;
}

/* ----- SWITCH ----- */
.payment-switch-container {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    padding: 6px 0;
}

.payment-switch-label {
    font-size: 14px;
    font-weight: 500;
    color: #1A2332;
}

.payment-switch {
    position: relative;
    width: 48px;
    height: 26px;
    flex-shrink: 0;
}

.payment-switch-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.payment-switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #D1D8E0;
    border-radius: 26px;
    transition: 0.3s;
}

.payment-switch-slider::before {
    content: "";
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: 0.3s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

.payment-switch-input:checked + .payment-switch-slider {
    background: #083CAE;
}

.payment-switch-input:checked + .payment-switch-slider::before {
    transform: translateX(22px);
}

.payment-switch-hint {
    font-size: 13px;
    color: #8A9AAE;
}

.payment-row-switch {
    display: block;
}
.payment-field-switch {
    width: 100%;
}

/* ----- TARJETAS DE RESUMEN ----- */
.summary-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.summary-card {
    background: #F8FAFC;
    border-radius: 14px;
    border: 1px solid #E9ECF0;
    padding: 18px 22px;
    transition: all 0.2s;
}

.summary-card:hover {
    border-color: #D1D8E0;
}

.summary-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}

.summary-icon {
    color: #083CAE;
    font-size: 16px;
    width: 28px;
    height: 28px;
    background: #E8F0FE;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.summary-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #1A2332;
}

.summary-card-body {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 8px;
}

.summary-item {
    display: flex;
    flex-direction: column;
}

.summary-label {
    font-size: 11px;
    color: #8A9AAE;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.summary-value {
    font-size: 20px;
    font-weight: 700;
    color: #1A2332;
    letter-spacing: -0.3px;
}

.summary-value-danger {
    color: #DC3545;
}
.summary-value-warning {
    color: #F59E0B;
}
.summary-value-primary {
    color: #083CAE;
}
.summary-value-success {
    color: #28A745;
}
.summary-value-info {
    color: #17A2B8;
}

.summary-card-actions .summary-card-body {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.summary-text {
    font-size: 13px;
    color: #6B7A8F;
    margin: 0;
}

.btn-summary-action {
    background: #083CAE;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-summary-action:hover {
    background: #0A4BC9;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(8,60,174,0.25);
}
.btn-summary-action:active {
    transform: translateY(0);
}

.summary-resumen {
    margin-top: 8px;
    width: 100%;
}
.summary-resumen-alert {
    background: #E8F0FE;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
    color: #1A2332;
    border: 1px solid #D1E0F8;
}
.summary-resumen-alert strong {
    color: #083CAE;
}

/* ----- TABLA DE FACTURAS ----- */
.payment-table-wrapper {
    margin-top: 4px;
}

.payment-table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 4px 12px 0;
    flex-wrap: wrap;
    gap: 10px;
}

.payment-table-title {
    font-size: 14px;
    font-weight: 600;
    color: #1A2332;
}

.payment-table-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-table-action {
    background: #F1F3F5;
    color: #4A5A6E;
    border: 1px solid #E2E6EA;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-table-action:hover {
    background: #E8ECF0;
    border-color: #D1D8E0;
}
.btn-table-action-success {
    background: #E8F5E9;
    border-color: #A5D6A7;
    color: #2E7D32;
}
.btn-table-action-success:hover {
    background: #C8E6C9;
}
.btn-table-action-danger {
    background: #FFEBEE;
    border-color: #EF9A9A;
    color: #C62828;
}
.btn-table-action-danger:hover {
    background: #FFCDD2;
}

.payment-table-container {
    max-height: 240px;
    overflow-y: auto;
    border: 1px solid #E9ECF0;
    border-radius: 12px;
    background: white;
}

.payment-table-container::-webkit-scrollbar {
    width: 6px;
}
.payment-table-container::-webkit-scrollbar-track {
    background: #F5F7FB;
    border-radius: 3px;
}
.payment-table-container::-webkit-scrollbar-thumb {
    background: #D1D8E0;
    border-radius: 3px;
}
.payment-table-container::-webkit-scrollbar-thumb:hover {
    background: #BCC4D0;
}

.payment-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.payment-table thead th {
    background: #F8FAFC;
    color: #4A5A6E;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 14px;
    border-bottom: 2px solid #E9ECF0;
    text-align: left;
    position: sticky;
    top: 0;
    z-index: 2;
}

.payment-table tbody td {
    padding: 10px 14px;
    border-bottom: 1px solid #F1F3F5;
    color: #1A2332;
    vertical-align: middle;
}

.payment-table tbody tr:hover td {
    background: #F8FAFC;
}
.payment-table tbody tr:last-child td {
    border-bottom: none;
}

.payment-table .table-danger td {
    background: #FFF5F5;
}
.payment-table .table-danger:hover td {
    background: #FFEBEE;
}

/* ----- TOTALES DE APLICACIÓN ----- */
.application-totals {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
    padding: 16px 20px;
    background: #F8FAFC;
    border-radius: 12px;
    border: 1px solid #E9ECF0;
}

.application-total-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0;
}

.application-total-label {
    font-size: 13px;
    color: #6B7A8F;
    font-weight: 500;
}

.application-total-value {
    font-size: 18px;
    font-weight: 700;
    color: #1A2332;
}

/* ----- FOOTER ----- */
.payment-modal-footer {
    background: #FFFFFF;
    border-top: 1px solid #E9ECF0;
    padding: 16px 32px;
    border-radius: 0 0 18px 18px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-payment-cancel {
    background: #F1F3F5 !important;
    color: #4A5A6E !important;
    border: none !important;
    padding: 10px 28px !important;
    border-radius: 10px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.25s !important;
}
.btn-payment-cancel:hover {
    background: #E8ECF0 !important;
}

.btn-payment-save {
    background: #083CAE !important;
    color: white !important;
    border: none !important;
    padding: 10px 28px !important;
    border-radius: 10px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.25s !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
}
.btn-payment-save:hover {
    background: #0A4BC9 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 16px rgba(8,60,174,0.25) !important;
}
.btn-payment-save:active {
    transform: translateY(0) !important;
}
.btn-payment-save:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* ----- RESPONSIVE ----- */
@media (max-width: 992px) {
    .payment-modal-header {
        padding: 18px 20px;
        flex-wrap: wrap;
    }
    .payment-modal-body {
        padding: 16px 16px 4px 16px;
    }
    .payment-row {
        grid-template-columns: 1fr 1fr;
    }
    .summary-cards {
        grid-template-columns: 1fr;
    }
    .summary-card-body {
        grid-template-columns: 1fr 1fr 1fr;
    }
    .application-totals {
        grid-template-columns: 1fr 1fr;
    }
    .payment-modal-footer {
        padding: 12px 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .btn-payment-cancel,
    .btn-payment-save {
        flex: 1;
        justify-content: center;
        min-width: 120px;
    }
}

@media (max-width: 768px) {
    .payment-header-left {
        flex-wrap: wrap;
    }
    .payment-modal-title {
        font-size: 18px;
    }
    .payment-subtitle {
        font-size: 13px;
    }
    .payment-row {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .summary-card-body {
        grid-template-columns: 1fr 1fr;
    }
    .application-totals {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .section-body {
        padding: 14px 16px;
    }
    .payment-input,
    .payment-select {
        height: 44px;
        font-size: 13px;
    }
    .payment-table thead th,
    .payment-table tbody td {
        padding: 8px 10px;
        font-size: 12px;
    }
    .payment-table-container {
        max-height: 180px;
    }
    .payment-modal-content .modal-dialog {
        margin: 8px;
    }
}

@media (max-width: 576px) {
    .payment-header-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    .summary-card-body {
        grid-template-columns: 1fr;
        gap: 6px;
    }
    .summary-value {
        font-size: 18px;
    }
    .payment-table-actions {
        flex-wrap: wrap;
    }
    .btn-table-action {
        font-size: 11px;
        padding: 4px 10px;
    }
    .payment-modal-footer {
        flex-direction: column-reverse;
    }
    .btn-payment-cancel,
    .btn-payment-save {
        width: 100%;
        justify-content: center;
    }
}

/* Override para select2 dentro del modal */
.select2-container--default .select2-selection--single {
    height: 48px !important;
    border: 2px solid #E2E6EA !important;
    border-radius: 10px !important;
    padding: 0 16px !important;
    display: flex !important;
    align-items: center !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 44px !important;
    color: #1A2332 !important;
    font-size: 14px !important;
}
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #083CAE !important;
    box-shadow: 0 0 0 4px rgba(8,60,174,0.08) !important;
}
.select2-dropdown {
    border-radius: 10px !important;
    border-color: #E2E6EA !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #E8F0FE !important;
    color: #083CAE !important;
}

/* Estilos para inputs de monto en tabla */
.monto-aplicar-input {
    height: 36px !important;
    padding: 0 10px !important;
    border: 2px solid #E2E6EA !important;
    border-radius: 8px !important;
    font-size: 13px !important;
    width: 120px !important;
    text-align: right !important;
    transition: all 0.2s !important;
}
.monto-aplicar-input:focus {
    outline: none !important;
    border-color: #083CAE !important;
    box-shadow: 0 0 0 3px rgba(8,60,174,0.08) !important;
}

/* Badge de vencida en tabla */
.badge.bg-danger {
    background: #DC3545 !important;
    color: white !important;
    font-size: 10px !important;
    padding: 3px 8px !important;
    border-radius: 6px !important;
    font-weight: 600 !important;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '<?php echo csrf_token(); ?>';

let columnasAgrupadas = [];
let expandedGroups = new Set();
let datosOriginales = [];
let currentPage = 1;
let rowsPerPage = 5;

// Variables para aplicación de facturas
let facturasProveedor = [];
let montoPagoActual = 0;
let proveedorSeleccionadoId = null;
let aplicacionesFacturas = {};

// ============================================
// FUNCIONES DE FORMATO
// ============================================
function formatCurrency(amount) {
    if (amount === undefined || amount === null) amount = 0;
    return '$' + Number(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-MX');
    } catch (e) {
        return dateString;
    }
}

function getBadgeClass(estatus) {
    if (estatus === 'activo') return 'badge-activo';
    if (estatus === 'completado') return 'badge-completado';
    if (estatus === 'cancelado') return 'badge-cancelado';
    return 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    if (estatus === 'activo') return 'Pendiente';
    if (estatus === 'completado') return 'Aplicado';
    if (estatus === 'cancelado') return 'Cancelado';
    return estatus || 'Pendiente';
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function debugLog(message, data) {
    console.log('🔍 [DEBUG]', message, data || '');
}

// ============================================
// INICIALIZACIÓN
// ============================================
$(document).ready(function() {
    debugLog('Inicializando módulo de Pagos a Proveedores');
    
    $('#proveedor_select').select2({
        dropdownParent: $('#modalPagoProveedor'),
        placeholder: 'Buscar proveedor...',
        allowClear: true,
        width: '100%'
    });
    
    debugLog('Select2 inicializado');
    cargarChequesTransferencias();
});

// ============================================
// CARGA DE DATOS
// ============================================
function cargarChequesTransferencias() {
    debugLog('Cargando datos...');
    
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const proveedorId = document.getElementById('filtroProveedor').value;
    
    let url = '/admin/api/cheques-transferencias?';
    if (fechaInicio) url += 'fecha_inicio=' + fechaInicio + '&';
    if (fechaFin) url += 'fecha_fin=' + fechaFin + '&';
    if (proveedorId) url += 'proveedor_id=' + proveedorId + '&';
    
    debugLog('URL: ' + url);
    
    fetch(url, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
        debugLog('Respuesta HTTP: ' + response.status);
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.json();
    })
    .then(data => {
        debugLog('Datos recibidos: ' + data.length + ' registros');
        if (data.error) throw new Error(data.error);
        datosOriginales = data;
        actualizarContadores(data);
        cargarTabla(data);
    })
    .catch(error => {
        console.error('Error:', error);
        debugLog('ERROR: ' + error.message);
        document.getElementById('tablaBody').innerHTML = '<tr><td colspan="13" style="color:red; text-align:center;">Error al cargar datos: ' + error.message + '<br><small>Revisa la consola para más detalles</small></td></tr>';
        mostrarNotificacion('Error al cargar datos: ' + error.message, 'danger');
    });
}

function actualizarContadores(datos) {
    document.getElementById('totalRegistrosCard').textContent = datos.length;
    document.getElementById('totalActivos').textContent = datos.filter(d => d.estatus === 'activo').length;
    document.getElementById('totalCompletados').textContent = datos.filter(d => d.estatus === 'completado').length;
    document.getElementById('totalCancelados').textContent = datos.filter(d => d.estatus === 'cancelado').length;
}

// ============================================
// TABLA
// ============================================
function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="13" style="text-align: center;">No hay registros</td></tr>';
        document.getElementById('sumMonto').textContent = formatCurrency(0);
        document.getElementById('sumMontoRestante').textContent = formatCurrency(0);
        return;
    }
    
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = datos.slice(start, start + rowsPerPage);
    let totalMonto = 0, totalMontoRestante = 0;
    
    tablaBody.innerHTML = pageData.map(item => {
        totalMonto += item.monto || 0;
        totalMontoRestante += item.monto_restante || 0;
        return `
            <tr>
                <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                <td>${item.folio || '-'}</td>
                <td>${escapeHtml(item.proveedor) || '-'}</td>
                <td>${item.forma_pago || '-'}</td>
                <td>${item.cuenta || '-'}</td>
                <td>${formatDate(item.fecha)}</td>
                <td>${item.referencia || '-'}</td>
                <td>${item.referencia_bancaria || '-'}</td>
                <td style="text-align:right;">${formatCurrency(item.monto)}</td>
                <td style="text-align:right;">${formatCurrency(item.monto_restante)}</td>
                <td>${item.moneda || '-'}</td>
                <td>${item.descripcion || '-'}</td>
                <td style="position:sticky;right:0;background:white;">
                    <div class="action-icons">
                        <i class="fas fa-edit" onclick="editarPagoProveedor(${item.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarPagoProveedor(${item.id})" title="Eliminar"></i>
                        ${item.estatus === 'activo' ? `<i class="fas fa-check-circle" onclick="aplicarPagoProveedor(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver"></i>
                        <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="PDF"></i>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    
    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
    document.getElementById('sumMontoRestante').textContent = formatCurrency(totalMontoRestante);
    actualizarPaginacion(datos.length);
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    document.getElementById('paginaActual').textContent = currentPage;
    const start = Math.min((currentPage - 1) * rowsPerPage + 1, total);
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginacionInfo').textContent = `Mostrando ${start}-${end} de ${total} registros`;
}

// ============================================
// MODAL PRINCIPAL - ABRIR
// ============================================
function abrirModalPago() {
    debugLog('Abriendo modal de pago a proveedor');
    
    // Verificar que el modal existe
    const modal = document.getElementById('modalPagoProveedor');
    if (!modal) {
        console.error('Modal no encontrado');
        mostrarNotificacion('Error: Modal no encontrado', 'danger');
        return;
    }
    
    // Verificar que los elementos existen antes de usarlos
    const pagoId = document.getElementById('pago_id');
    const fecha = document.getElementById('fecha');
    const formaPago = document.getElementById('forma_pago');
    const facturasJson = document.getElementById('facturas_aplicadas_json');
    const proveedorSelect = document.getElementById('proveedor_select');
    const proveedorNombre = document.getElementById('proveedor_nombre');
    const rfc = document.getElementById('rfc');
    const cuentaBancaria = document.getElementById('cuenta_bancaria_id');
    const moneda = document.getElementById('moneda_id');
    const monto = document.getElementById('monto');
    const referencia = document.getElementById('referencia');
    const referenciaBancaria = document.getElementById('referencia_bancaria');
    const proyecto = document.getElementById('proyecto_id');
    const descripcion = document.getElementById('descripcion');
    const observaciones = document.getElementById('observaciones');
    const codigoSat = document.getElementById('codigo_sat_id');
    const aplicarAhora = document.getElementById('aplicar_ahora');
    const resumenDiv = document.getElementById('resumenFacturasAplicadas');
    const infoSpan = document.getElementById('codigo_sat_info');
    
    if (pagoId) pagoId.value = '';
    if (fecha) fecha.value = new Date().toISOString().split('T')[0];
    if (formaPago) formaPago.value = 'transferencia';
    if (facturasJson) facturasJson.value = '[]';
    
    aplicacionesFacturas = {};
    facturasProveedor = [];
    
    if (proveedorSelect) {
        proveedorSelect.value = '';
        if (proveedorSelect.select2) {
            proveedorSelect.select2('val', '');
        }
    }
    
    if (proveedorNombre) proveedorNombre.value = '';
    if (rfc) rfc.value = '';
    if (cuentaBancaria) cuentaBancaria.value = '';
    if (moneda) moneda.value = '';
    if (monto) monto.value = '';
    if (referencia) referencia.value = '';
    if (referenciaBancaria) referenciaBancaria.value = '';
    if (proyecto) proyecto.value = '';
    if (descripcion) descripcion.value = '';
    if (observaciones) observaciones.value = '';
    if (codigoSat) codigoSat.value = '';
    if (aplicarAhora) aplicarAhora.checked = true;
    
    if (resumenDiv) resumenDiv.style.display = 'none';
    
    if (infoSpan) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT para este pago';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
    }
    
    // Limpiar tabla de preview
    const previewBody = document.getElementById('tablaFacturasPreviewBody');
    if (previewBody) {
        previewBody.innerHTML = 
            `<tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                Selecciona un proveedor para ver sus facturas
            </td></tr>`;
    }
    
    // Reiniciar totales de aplicación
    const appTotalPago = document.getElementById('appTotalPago');
    const appTotalAplicado = document.getElementById('appTotalAplicado');
    const appDiferencia = document.getElementById('appDiferencia');
    const summaryVencido = document.getElementById('summaryVencido');
    const summaryPorVencer = document.getElementById('summaryPorVencer');
    const summaryTotal = document.getElementById('summaryTotal');
    
    if (appTotalPago) appTotalPago.textContent = '$0.00';
    if (appTotalAplicado) appTotalAplicado.textContent = '$0.00';
    if (appDiferencia) appDiferencia.textContent = '$0.00';
    if (summaryVencido) summaryVencido.textContent = '$0.00';
    if (summaryPorVencer) summaryPorVencer.textContent = '$0.00';
    if (summaryTotal) summaryTotal.textContent = '$0.00';
    
    // Cargar códigos SAT de gastos
    cargarCodigosSat('G');
    
    // Abrir el modal usando Bootstrap
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
}

function cargarCodigosSat(tipo) {
    debugLog('Cargando códigos SAT tipo: ' + tipo);
    
    fetch(`/admin/api/codigos-sat?tipo=${tipo}`, {
        headers: { 
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(result => {
        debugLog('Códigos SAT recibidos: ' + (result.data ? result.data.length : 0));
        if (result.success) {
            const select = document.getElementById('codigo_sat_id');
            if (select) {
                select.innerHTML = '<option value="">Seleccionar código SAT...</option>';
                if (result.data) {
                    result.data.forEach(codigo => {
                        select.innerHTML += `<option value="${codigo.id}" data-codigo="${codigo.codigo_agrupador}" data-nombre="${codigo.nombre_cuenta}">${codigo.codigo_agrupador} - ${codigo.nombre_cuenta}</option>`;
                    });
                }
            }
        }
    })
    .catch(error => {
        console.error('Error cargando códigos SAT:', error);
        debugLog('ERROR cargando códigos SAT: ' + error.message);
    });
}

function cargarFacturasProveedor() {
    const proveedorSelect = document.getElementById('proveedor_select');
    if (!proveedorSelect) return;
    
    const selectedOption = proveedorSelect.options[proveedorSelect.selectedIndex];
    
    if (!proveedorSelect.value) {
        document.getElementById('proveedor_nombre').value = '';
        document.getElementById('rfc').value = '';
        return;
    }
    
    const nombre = selectedOption?.getAttribute('data-nombre') || '';
    const rfc = selectedOption?.getAttribute('data-rfc') || '';
    
    document.getElementById('proveedor_nombre').value = nombre;
    document.getElementById('rfc').value = rfc;
}

function editarPagoProveedor(id) {
    debugLog('Editando pago ID: ' + id);
    
    fetch(`/admin/api/cheques-transferencias/${id}`, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(item => {
        debugLog('Datos del registro:', item);
        
        document.getElementById('pago_id').value = item.id;
        document.getElementById('fecha').value = item.fecha;
        document.getElementById('forma_pago').value = item.forma_pago;
        
        const proveedorSelect = document.getElementById('proveedor_select');
        if (proveedorSelect && item.proveedor_id) {
            proveedorSelect.value = item.proveedor_id;
            if (proveedorSelect.select2) {
                proveedorSelect.select2('val', item.proveedor_id);
            }
            cargarFacturasProveedor();
        }
        
        document.getElementById('cuenta_bancaria_id').value = item.cuenta_bancaria_id;
        document.getElementById('moneda_id').value = item.moneda_id;
        document.getElementById('monto').value = item.monto;
        document.getElementById('referencia').value = item.referencia || '';
        document.getElementById('referencia_bancaria').value = item.referencia_bancaria || '';
        document.getElementById('proyecto_id').value = item.proyecto_id || '';
        document.getElementById('descripcion').value = item.descripcion || '';
        document.getElementById('observaciones').value = item.observaciones || '';
        document.getElementById('codigo_sat_id').value = item.codigo_sat_id || '';
        document.getElementById('aplicar_ahora').checked = false;
        
        if (item.facturas_aplicadas && Object.keys(item.facturas_aplicadas).length > 0) {
            const resumenDiv = document.getElementById('resumenFacturasAplicadas');
            if (resumenDiv) {
                resumenDiv.style.display = 'block';
                const totalAplicado = Object.values(item.facturas_aplicadas).reduce((a, b) => a + b, 0);
                document.getElementById('resumenFacturasTexto').innerHTML = 
                    `<strong>${Object.keys(item.facturas_aplicadas).length} factura(s) aplicadas. Total: ${formatCurrency(totalAplicado)}</strong>`;
            }
        }
        
        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOptionSat = codigoSatSelect?.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOptionSat && selectedOptionSat.value && infoSpan) {
            const codigo = selectedOptionSat.getAttribute('data-codigo') || '';
            const nombre = selectedOptionSat.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT seleccionado: ${codigo} - ${nombre}`;
            infoSpan.classList.remove('text-muted');
            infoSpan.classList.add('text-success');
        }
        
        const modal = document.getElementById('modalPagoProveedor');
        if (modal) {
            new bootstrap.Modal(modal).show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        debugLog('ERROR al editar: ' + error.message);
        mostrarNotificacion('Error al cargar datos para editar', 'danger');
    });
}

function guardarPagoProveedor() {
    const id = document.getElementById('pago_id').value;
    const codigoSatId = document.getElementById('codigo_sat_id').value;
    
    debugLog('Guardando pago... ID: ' + id);
    
    if (!codigoSatId) {
        mostrarNotificacion('Por favor seleccione un código SAT', 'warning');
        return;
    }
    
    const proveedorSelect = document.getElementById('proveedor_select');
    if (!proveedorSelect || !proveedorSelect.value) {
        mostrarNotificacion('Por favor seleccione un proveedor', 'warning');
        return;
    }
    
    let facturasAplicadas = [];
    try {
        const jsonValue = document.getElementById('facturas_aplicadas_json').value;
        if (jsonValue && jsonValue !== '[]') {
            facturasAplicadas = JSON.parse(jsonValue);
            debugLog('Facturas aplicadas: ' + facturasAplicadas.length);
        }
    } catch (e) {
        facturasAplicadas = [];
    }
    
    const data = {
        fecha: document.getElementById('fecha').value,
        forma_pago: document.getElementById('forma_pago').value,
        proveedor: document.getElementById('proveedor_nombre').value,
        rfc: document.getElementById('rfc').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        moneda_id: document.getElementById('moneda_id').value,
        monto: document.getElementById('monto').value,
        referencia: document.getElementById('referencia').value,
        referencia_bancaria: document.getElementById('referencia_bancaria').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        descripcion: document.getElementById('descripcion').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora') ? document.getElementById('aplicar_ahora').checked : false,
        codigo_sat_id: codigoSatId,
        proveedor_id: proveedorSelect.value,
        facturas_aplicadas: facturasAplicadas,
    };
    
    debugLog('Datos a guardar:', data);
    
    const url = id ? `/admin/api/cheques-transferencias/${id}` : '/admin/api/cheques-transferencias';
    const method = id ? 'PUT' : 'POST';
    
    const btn = document.getElementById('btnGuardarModal');
    if (btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            debugLog('Respuesta del servidor:', result);
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                const modal = document.getElementById('modalPagoProveedor');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                cargarChequesTransferencias();
            } else {
                mostrarNotificacion(result.message || 'Error al guardar', 'danger');
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            console.error('Error:', error);
            debugLog('ERROR: ' + error.message);
            mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
        });
    }
}

function eliminarPagoProveedor(id) {
    if (confirm('¿Eliminar este pago?')) {
        debugLog('Eliminando pago ID: ' + id);
        
        fetch(`/admin/api/cheques-transferencias/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarChequesTransferencias();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al eliminar', 'danger'));
    }
}

function aplicarPagoProveedor(id) {
    if (confirm('¿Aplicar este pago? Se actualizará el saldo de la cuenta bancaria.')) {
        debugLog('Aplicando pago ID: ' + id);
        
        fetch(`/admin/api/cheques-transferencias/${id}/aplicar`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarChequesTransferencias();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al aplicar', 'danger'));
    }
}

function verDetalle(id) {
    debugLog('Ver detalle ID: ' + id);
    
    fetch(`/admin/api/cheques-transferencias/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(item => {
        const codigoSatNombre = item.codigo_sat?.codigo_agrupador + ' - ' + item.codigo_sat?.nombre_cuenta || 'No asignado';
        const facturasInfo = item.facturas_aplicadas ? 
            '\n📄 Facturas aplicadas: ' + Object.keys(item.facturas_aplicadas).length : '';
        
        mostrarNotificacion(`
📄 Folio: ${item.folio}
🏢 Proveedor: ${item.proveedor}
💳 Forma de Pago: ${item.forma_pago === 'cheque' ? 'Cheque' : 'Transferencia'}
💰 Monto: ${formatCurrency(item.monto)}
💵 Monto Restante: ${formatCurrency(item.monto_restante)}
📅 Fecha: ${formatDate(item.fecha)}
🏷️ Código SAT: ${codigoSatNombre}
${facturasInfo}
📝 Descripción: ${item.descripcion || 'N/A'}`, 'info');
    })
    .catch(error => mostrarNotificacion('Error al cargar detalle', 'danger'));
}

function generarPDF(id) {
    mostrarNotificacion('Generando PDF...', 'info');
}

function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '99999';
    alertDiv.style.minWidth = '300px';
    alertDiv.style.maxWidth = '500px';
    alertDiv.style.whiteSpace = 'pre-line';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}

function exportarExcel() {
    const tabla = document.getElementById('tablaChequesTransferencias').cloneNode(true);
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tabla.outerHTML);
    link.download = 'pagos_proveedores.xls';
    link.click();
}

// ============================================
// APLICACIÓN A FACTURAS DE PROVEEDOR
// ============================================
function abrirAplicacionFacturas() {
    debugLog('Abriendo modal de aplicación a facturas de proveedor');
    
    const proveedorSelect = document.getElementById('proveedor_select');
    if (!proveedorSelect || !proveedorSelect.value) {
        mostrarNotificacion('Por favor seleccione un proveedor primero', 'warning');
        return;
    }
    
    const selectedOption = proveedorSelect.options[proveedorSelect.selectedIndex];
    const proveedorId = proveedorSelect.value;
    const proveedorNombre = selectedOption?.getAttribute('data-nombre') || 'Proveedor';
    const monto = parseFloat(document.getElementById('monto')?.value) || 0;
    
    if (monto <= 0) {
        mostrarNotificacion('Por favor ingrese un monto válido', 'warning');
        return;
    }
    
    montoPagoActual = monto;
    aplicacionesFacturas = {};
    proveedorSeleccionadoId = proveedorId;
    
    const proveedorNombreFacturas = document.getElementById('proveedorNombreFacturas');
    const montoPagoFacturas = document.getElementById('montoPagoFacturas');
    const totalAplicadoFacturas = document.getElementById('totalAplicadoFacturas');
    const diferenciaFacturas = document.getElementById('diferenciaFacturas');
    
    if (proveedorNombreFacturas) proveedorNombreFacturas.textContent = proveedorNombre;
    if (montoPagoFacturas) montoPagoFacturas.textContent = formatCurrency(monto);
    if (totalAplicadoFacturas) totalAplicadoFacturas.textContent = 'Aplicado: $0.00';
    if (diferenciaFacturas) diferenciaFacturas.textContent = `Diferencia: ${formatCurrency(monto)}`;
    
    const tablaBody = document.getElementById('tablaFacturasBody');
    if (tablaBody) {
        tablaBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Cargando facturas...</td></tr>';
    }
    
    const modal = document.getElementById('modalAplicarFacturas');
    if (modal) {
        new bootstrap.Modal(modal).show();
    }
    
    cargarFacturasProveedorParaAplicar(proveedorId);
}

function cargarFacturasProveedorParaAplicar(proveedorId) {
    debugLog('Cargando facturas del proveedor ID: ' + proveedorId);
    
    if (!proveedorId) {
        const tablaBody = document.getElementById('tablaFacturasBody');
        if (tablaBody) {
            tablaBody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Seleccione un proveedor para ver sus facturas</td></tr>';
        }
        return;
    }
    
    fetch(`/admin/api/proveedores/${proveedorId}/facturas-pendientes`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(result => {
        debugLog('Facturas recibidas:', result);
        
        if (result.success) {
            facturasProveedor = result.data || [];
            const totales = result.totales || { vencido: 0, por_vencer: 0, total: 0 };
            
            const saldoVencido = document.getElementById('saldoVencido');
            const saldoPorVencer = document.getElementById('saldoPorVencer');
            const saldoTotal = document.getElementById('saldoTotal');
            
            if (saldoVencido) saldoVencido.textContent = formatCurrency(totales.vencido);
            if (saldoPorVencer) saldoPorVencer.textContent = formatCurrency(totales.por_vencer);
            if (saldoTotal) saldoTotal.textContent = formatCurrency(totales.total);
            
            // Actualizar tarjetas de resumen en el modal principal
            const summaryVencido = document.getElementById('summaryVencido');
            const summaryPorVencer = document.getElementById('summaryPorVencer');
            const summaryTotal = document.getElementById('summaryTotal');
            
            if (summaryVencido) summaryVencido.textContent = formatCurrency(totales.vencido);
            if (summaryPorVencer) summaryPorVencer.textContent = formatCurrency(totales.por_vencer);
            if (summaryTotal) summaryTotal.textContent = formatCurrency(totales.total);
            
            // Actualizar preview de facturas en el modal principal
            renderizarPreviewFacturas();
            renderizarTablaFacturas();
        } else {
            mostrarNotificacion(result.message || 'Error al cargar facturas', 'danger');
        }
    })
    .catch(error => {
        console.error('Error cargando facturas:', error);
        debugLog('ERROR cargando facturas: ' + error.message);
        const tablaBody = document.getElementById('tablaFacturasBody');
        if (tablaBody) {
            tablaBody.innerHTML = '<tr><td colspan="8" style="color:red; text-align:center;">Error al cargar facturas</td></tr>';
        }
        mostrarNotificacion('Error al cargar facturas: ' + error.message, 'danger');
    });
}

function renderizarPreviewFacturas() {
    const tbody = document.getElementById('tablaFacturasPreviewBody');
    if (!tbody) return;
    
    if (!facturasProveedor || facturasProveedor.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
            <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
            Este proveedor no tiene facturas pendientes
        </td></tr>`;
        return;
    }
    
    let html = '';
    facturasProveedor.slice(0, 5).forEach((factura, index) => {
        const saldo = parseFloat(factura.saldo_disponible) || 0;
        const isVencida = factura.fecha_vencimiento && new Date(factura.fecha_vencimiento) < new Date();
        
        html += `
            <tr class="${isVencida ? 'table-danger' : ''}">
                <td>${index + 1}</td>
                <td><strong>${factura.folio || 'F-' + factura.id}</strong></td>
                <td>${formatDate(factura.fecha)}</td>
                <td>${formatDate(factura.fecha_vencimiento)} ${isVencida ? '<span class="badge bg-danger">Vencida</span>' : ''}</td>
                <td style="text-align: right;">${formatCurrency(factura.total)}</td>
                <td style="text-align: right;">${formatCurrency(saldo)}</td>
                <td style="text-align: right;">${formatCurrency(aplicacionesFacturas[factura.id] || 0)}</td>
            </tr>
        `;
    });
    
    if (facturasProveedor.length > 5) {
        html += `<tr><td colspan="7" style="text-align: center; color: #8A9AAE; font-size: 12px;">
            <i class="fas fa-ellipsis-h"></i> Y ${facturasProveedor.length - 5} factura(s) más. Haz clic en "Seleccionar Facturas" para ver todas.
        </td></tr>`;
    }
    
    tbody.innerHTML = html;
}

function renderizarTablaFacturas() {
    const tbody = document.getElementById('tablaFacturasBody');
    if (!tbody) return;
    
    if (!facturasProveedor || facturasProveedor.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>Este proveedor no tiene facturas pendientes</td></tr>';
        return;
    }
    
    let html = '';
    let totalSaldo = 0;
    let totalAplicado = 0;
    
    facturasProveedor.forEach((factura, index) => {
        const saldo = parseFloat(factura.saldo_disponible) || 0;
        const montoAplicado = aplicacionesFacturas[factura.id] || 0;
        totalSaldo += saldo;
        totalAplicado += montoAplicado;
        
        const isVencida = factura.fecha_vencimiento && new Date(factura.fecha_vencimiento) < new Date();
        
        html += `
            <tr class="${isVencida ? 'table-danger' : ''}">
                <td>${index + 1}</td>
                <td><strong>${factura.folio || 'F-' + factura.id}</strong></td>
                <td>${formatDate(factura.fecha)}</td>
                <td>${formatDate(factura.fecha_vencimiento)} ${isVencida ? '<span class="badge bg-danger">Vencida</span>' : ''}</td>
                <td style="text-align: right;">${formatCurrency(factura.total)}</td>
                <td style="text-align: right;">${formatCurrency(saldo)}</td>
                <td style="text-align: right;">
                    <input type="number" 
                           class="monto-aplicar-input" 
                           data-factura-id="${factura.id}"
                           value="${montoAplicado > 0 ? montoAplicado.toFixed(2) : ''}"
                           min="0" 
                           max="${saldo}"
                           step="0.01"
                           onchange="actualizarMontoAplicar(${factura.id}, this.value)"
                           onfocus="this.select()">
                </td>
                <td style="text-align: center;">
                    <button class="btn btn-sm btn-outline-success" onclick="aplicarTotalFactura(${factura.id})" title="Aplicar todo el saldo">
                        <i class="fas fa-check-double"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    const totalSaldoPendiente = document.getElementById('totalSaldoPendiente');
    const totalMontoAplicar = document.getElementById('totalMontoAplicar');
    const diferenciaFacturas = document.getElementById('diferenciaFacturas');
    const totalAplicadoFacturas = document.getElementById('totalAplicadoFacturas');
    const appTotalAplicado = document.getElementById('appTotalAplicado');
    const appDiferencia = document.getElementById('appDiferencia');
    
    if (totalSaldoPendiente) totalSaldoPendiente.textContent = formatCurrency(totalSaldo);
    if (totalMontoAplicar) totalMontoAplicar.textContent = formatCurrency(totalAplicado);
    
    const diffFinal = montoPagoActual - totalAplicado;
    if (diferenciaFacturas) {
        diferenciaFacturas.textContent = `Diferencia: ${formatCurrency(diffFinal)}`;
        if (Math.abs(diffFinal) < 0.01) {
            diferenciaFacturas.className = 'badge bg-success';
        } else if (diffFinal > 0) {
            diferenciaFacturas.className = 'badge bg-warning';
        } else {
            diferenciaFacturas.className = 'badge bg-danger';
        }
    }
    
    if (totalAplicadoFacturas) totalAplicadoFacturas.textContent = `Aplicado: ${formatCurrency(totalAplicado)}`;
    if (appTotalAplicado) appTotalAplicado.textContent = formatCurrency(totalAplicado);
    if (appDiferencia) appDiferencia.textContent = formatCurrency(diffFinal);
    
    // Actualizar preview
    renderizarPreviewFacturas();
}

function actualizarMontoAplicar(facturaId, valor) {
    const monto = parseFloat(valor) || 0;
    const factura = facturasProveedor.find(f => f.id === facturaId);
    
    if (!factura) return;
    
    const saldoMaximo = parseFloat(factura.saldo_disponible) || 0;
    
    if (monto > saldoMaximo) {
        mostrarNotificacion('El monto no puede exceder el saldo disponible', 'warning');
        const input = document.querySelector(`.monto-aplicar-input[data-factura-id="${facturaId}"]`);
        if (input) input.value = saldoMaximo.toFixed(2);
        aplicacionesFacturas[facturaId] = saldoMaximo;
    } else if (monto < 0) {
        const input = document.querySelector(`.monto-aplicar-input[data-factura-id="${facturaId}"]`);
        if (input) input.value = 0;
        aplicacionesFacturas[facturaId] = 0;
    } else {
        aplicacionesFacturas[facturaId] = monto;
    }
    
    renderizarTablaFacturas();
}

function aplicarTotalFactura(facturaId) {
    const factura = facturasProveedor.find(f => f.id === facturaId);
    if (!factura) return;
    
    const saldo = parseFloat(factura.saldo_disponible) || 0;
    const input = document.querySelector(`.monto-aplicar-input[data-factura-id="${facturaId}"]`);
    
    if (input) {
        input.value = saldo.toFixed(2);
        aplicacionesFacturas[facturaId] = saldo;
        renderizarTablaFacturas();
    }
}

function aplicarAutomatico() {
    debugLog('Aplicando automáticamente...');
    
    if (!facturasProveedor || facturasProveedor.length === 0) {
        mostrarNotificacion('No hay facturas para aplicar', 'warning');
        return;
    }
    
    aplicacionesFacturas = {};
    
    const facturasOrdenadas = [...facturasProveedor].sort((a, b) => {
        if (!a.fecha_vencimiento) return 1;
        if (!b.fecha_vencimiento) return -1;
        return new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento);
    });
    
    let montoRestante = montoPagoActual;
    
    for (const factura of facturasOrdenadas) {
        if (montoRestante <= 0.01) break;
        
        const saldo = parseFloat(factura.saldo_disponible) || 0;
        const aplicar = Math.min(saldo, montoRestante);
        
        if (aplicar > 0.01) {
            aplicacionesFacturas[factura.id] = aplicar;
            montoRestante -= aplicar;
        }
    }
    
    renderizarTablaFacturas();
    mostrarNotificacion('Aplicación automática completada', 'success');
}

function aplicarTodo() {
    debugLog('Aplicando todo...');
    
    if (!facturasProveedor || facturasProveedor.length === 0) {
        mostrarNotificacion('No hay facturas para aplicar', 'warning');
        return;
    }
    
    aplicacionesFacturas = {};
    
    let montoRestante = montoPagoActual;
    const facturasOrdenadas = [...facturasProveedor].sort((a, b) => {
        if (!a.fecha_vencimiento) return 1;
        if (!b.fecha_vencimiento) return -1;
        return new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento);
    });
    
    for (const factura of facturasOrdenadas) {
        if (montoRestante <= 0.01) break;
        
        const saldo = parseFloat(factura.saldo_disponible) || 0;
        const aplicar = Math.min(saldo, montoRestante);
        
        if (aplicar > 0.01) {
            aplicacionesFacturas[factura.id] = aplicar;
            montoRestante -= aplicar;
        }
    }
    
    renderizarTablaFacturas();
}

function limpiarAplicaciones() {
    debugLog('Limpiando aplicaciones');
    aplicacionesFacturas = {};
    renderizarTablaFacturas();
}

function confirmarAplicacionFacturas() {
    const totalAplicado = Object.values(aplicacionesFacturas).reduce((a, b) => a + b, 0);
    
    debugLog('Confirmando aplicación: ' + formatCurrency(totalAplicado));
    
    if (totalAplicado < 0.01) {
        mostrarNotificacion('No se ha aplicado ningún monto a las facturas', 'warning');
        return;
    }
    
    const facturasAplicadas = Object.entries(aplicacionesFacturas)
        .filter(([id, monto]) => monto > 0.01)
        .map(([id, monto]) => ({
            factura_id: parseInt(id),
            monto: parseFloat(monto.toFixed(2))
        }));
    
    debugLog('Facturas a aplicar:', facturasAplicadas);
    
    document.getElementById('facturas_aplicadas_json').value = JSON.stringify(facturasAplicadas);
    
    const resumenDiv = document.getElementById('resumenFacturasAplicadas');
    if (resumenDiv) {
        resumenDiv.style.display = 'block';
        
        const resumenTexto = facturasAplicadas.map(f => {
            const factura = facturasProveedor.find(fc => fc.id === f.factura_id);
            return `${factura?.folio || 'F-' + f.factura_id}: ${formatCurrency(f.monto)}`;
        }).join('<br>');
        
        document.getElementById('resumenFacturasTexto').innerHTML = resumenTexto + 
            `<br><strong>Total aplicado: ${formatCurrency(totalAplicado)}</strong>`;
    }
    
    // Actualizar totales en el modal principal
    const appTotalAplicado = document.getElementById('appTotalAplicado');
    const appDiferencia = document.getElementById('appDiferencia');
    if (appTotalAplicado) appTotalAplicado.textContent = formatCurrency(totalAplicado);
    if (appDiferencia) appDiferencia.textContent = formatCurrency(montoPagoActual - totalAplicado);
    
    const modal = document.getElementById('modalAplicarFacturas');
    if (modal) {
        bootstrap.Modal.getInstance(modal)?.hide();
    }
    
    mostrarNotificacion(`Se aplicarán ${formatCurrency(totalAplicado)} a ${facturasAplicadas.length} factura(s)`, 'success');
}

function actualizarResumenFacturas() {
    const facturasJson = document.getElementById('facturas_aplicadas_json').value;
    if (facturasJson && facturasJson !== '[]') {
        try {
            const facturas = JSON.parse(facturasJson);
            const total = facturas.reduce((sum, f) => sum + f.monto, 0);
            if (total > 0) {
                const resumenDiv = document.getElementById('resumenFacturasAplicadas');
                if (resumenDiv) {
                    resumenDiv.style.display = 'block';
                    document.getElementById('resumenFacturasTexto').innerHTML = 
                        `<strong>${facturas.length} factura(s) seleccionadas. Total: ${formatCurrency(total)}</strong>`;
                }
                const appTotalAplicado = document.getElementById('appTotalAplicado');
                const appDiferencia = document.getElementById('appDiferencia');
                if (appTotalAplicado) appTotalAplicado.textContent = formatCurrency(total);
                if (appDiferencia) appDiferencia.textContent = formatCurrency(montoPagoActual - total);
            }
        } catch (e) {}
    }
}

// ============================================
// EVENT LISTENERS
// ============================================
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => { const total = Math.ceil(datosOriginales.length / rowsPerPage); if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } });
document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); cargarTabla(datosOriginales); });

document.getElementById('buscador')?.addEventListener('input', e => {
    const busqueda = e.target.value.toLowerCase();
    const filtrados = datosOriginales.filter(item => 
        item.proveedor?.toLowerCase().includes(busqueda) ||
        item.folio?.toLowerCase().includes(busqueda) ||
        item.descripcion?.toLowerCase().includes(busqueda)
    );
    currentPage = 1;
    cargarTabla(filtrados);
});

document.getElementById('fechaInicio')?.addEventListener('change', cargarChequesTransferencias);
document.getElementById('fechaFin')?.addEventListener('change', cargarChequesTransferencias);
document.getElementById('filtroProveedor')?.addEventListener('change', cargarChequesTransferencias);

// Actualizar totales cuando cambia el monto
document.getElementById('monto')?.addEventListener('input', function() {
    const monto = parseFloat(this.value) || 0;
    const appTotalPago = document.getElementById('appTotalPago');
    const montoPagoFacturas = document.getElementById('montoPagoFacturas');
    if (appTotalPago) appTotalPago.textContent = formatCurrency(monto);
    if (montoPagoFacturas) montoPagoFacturas.textContent = formatCurrency(monto);
    montoPagoActual = monto;
    actualizarResumenFacturas();
    renderizarTablaFacturas();
});

document.addEventListener('DOMContentLoaded', () => {
    debugLog('DOM completamente cargado');
    cargarChequesTransferencias();
});
</script>
@endsection