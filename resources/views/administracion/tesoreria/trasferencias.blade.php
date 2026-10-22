@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Pagos a Proveedores -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cheques / Transferencias
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
<!-- MODAL DE PAGO A PROVEEDOR -->
<!-- ============================================ -->
<div class="modal fade" id="modalPagoProveedor" tabindex="-1" aria-labelledby="modalPagoProveedorLabel" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content payment-modal-content">
            
            <!-- HEADER -->
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
            
            <!-- BODY -->
            <div class="modal-body payment-modal-body">
                <form id="formPagoProveedor">
                    <input type="hidden" id="pago_id">
                    <input type="hidden" id="facturas_aplicadas_json" value="[]">
                    
                    <!-- SECCIÓN 1: DATOS DEL PAGO -->
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
                                    <input type="number" id="monto" class="payment-input" step="0.01" required placeholder="$0.00">
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Moneda <span class="text-danger">*</span></label>
                                    <select id="moneda_id" class="payment-select form-select" required>
                                        <option value="">Seleccionar moneda...</option>
                                        @foreach($monedas ?? [] as $moneda)
                                            <option value="{{ $moneda->id }}" {{ $moneda->codigo === 'MXN' ? 'selected' : '' }}>
                                                {{ $moneda->codigo }} - {{ $moneda->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Referencia</label>
                                    <input type="text" id="referencia" class="payment-input" placeholder="Ej: REF-001">
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Referencia Bancaria</label>
                                    <input type="text" id="referencia_bancaria" class="payment-input" placeholder="Ej: TRF-123456">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SECCIÓN 2: ORIGEN DEL PAGO -->
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
                                <div class="payment-field">
                                    <label class="payment-label">RFC</label>
                                    <input type="text" id="rfc" class="payment-input payment-input-readonly" readonly>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Proyecto</label>
                                    <select id="proyecto_id" class="payment-select form-select">
                                        <option value="">Ninguno</option>
                                        @foreach($proyectos ?? [] as $proyecto)
                                            <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                    
                    <!-- SECCIÓN 3: APLICACIÓN DEL PAGO -->
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
                    
                    <!-- SECCIÓN 4: DETALLE ADICIONAL -->
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
            
            <!-- FOOTER -->
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
            
            <!-- HEADER -->
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
            
            <!-- BODY -->
            <div class="modal-body payment-modal-body">
                <!-- Tarjetas de resumen -->
                <div class="summary-cards summary-cards-apply">
                    <div class="summary-card summary-card-proveedor">
                        <div class="summary-card-header">
                            <i class="fas fa-user-tie summary-icon"></i>
                            <span class="summary-card-title">Proveedor: <span id="proveedorNombreFacturas">-</span></span>
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
                                <span class="summary-value summary-value-info" id="totalAplicadoFacturas">Aplicado: $0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Diferencia</span>
                                <span class="summary-value" id="diferenciaFacturas">Diferencia: $0.00</span>
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
            
            <!-- FOOTER -->
            <div class="modal-footer payment-modal-footer">
                <button type="button" class="btn btn-secondary btn-payment-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-payment-save" onclick="confirmarAplicacionFacturas()">
                    <i class="fas fa-check"></i> Aplicar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL PARA VER DETALLE DEL PAGO -->
<!-- ============================================ -->
<div class="modal fade" id="modalVerDetalle" tabindex="-1" aria-hidden="true" style="z-index: 100001 !important;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:16px; border:none;">
            <div class="modal-header" style="background:#F8FAFC; border-bottom:1px solid #E9ECF0; padding:20px 28px;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="width:44px; height:44px; background:#083CAE; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:18px;">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h5 style="margin:0; font-weight:700; color:#1A2332;">Detalle del Pago</h5>
                        <small style="color:#6B7A8F;">Información completa del movimiento</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:24px 28px; background:#F5F7FB;" id="modalVerDetalleBody">
                <div style="text-align:center; padding:40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size:32px; color:#083CAE;"></i>
                    <p style="margin-top:15px; color:#6B7A8F;">Cargando información...</p>
                </div>
            </div>
            <div class="modal-footer" style="background:white; border-top:1px solid #E9ECF0; padding:14px 28px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px; padding:10px 24px;">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* ESTILOS DEL MODAL */
/* ============================================ */
.payment-modal-content {
    border: none;
    border-radius: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    background: #F5F7FB;
    overflow: hidden;
}

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

.payment-modal-body {
    padding: 24px 32px 8px 32px;
    background: #F5F7FB;
}

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

.summary-value-danger { color: #DC3545; }
.summary-value-warning { color: #F59E0B; }
.summary-value-primary { color: #083CAE; }
.summary-value-success { color: #28A745; }
.summary-value-info { color: #17A2B8; }

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
.btn-payment-save:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* Badges */
.badge-activo { background: #FFC107; color: #000; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
.badge-completado { background: #28A745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
.badge-cancelado { background: #DC3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
.badge-pendiente { background: #6C757D; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }

.action-icons i {
    cursor: pointer;
    margin: 0 4px;
    font-size: 14px;
    color: #083CAE;
    transition: all 0.2s;
}
.action-icons i:hover {
    color: #0A4BC9;
    transform: scale(1.15);
}

.monto-aplicar-input {
    height: 36px !important;
    padding: 0 10px !important;
    border: 2px solid #E2E6EA !important;
    border-radius: 8px !important;
    font-size: 13px !important;
    width: 120px !important;
    text-align: right !important;
}
.monto-aplicar-input:focus {
    outline: none !important;
    border-color: #083CAE !important;
    box-shadow: 0 0 0 3px rgba(8,60,174,0.08) !important;
}

/* Responsive */
@media (max-width: 992px) {
    .payment-modal-header { padding: 18px 20px; flex-wrap: wrap; }
    .payment-modal-body { padding: 16px 16px 4px 16px; }
    .payment-row { grid-template-columns: 1fr 1fr; }
    .summary-cards { grid-template-columns: 1fr; }
    .summary-card-body { grid-template-columns: 1fr 1fr 1fr; }
    .application-totals { grid-template-columns: 1fr 1fr; }
    .payment-modal-footer { padding: 12px 20px; flex-wrap: wrap; justify-content: center; }
}

@media (max-width: 768px) {
    .payment-row { grid-template-columns: 1fr; gap: 10px; }
    .summary-card-body { grid-template-columns: 1fr 1fr; }
    .application-totals { grid-template-columns: 1fr; gap: 8px; }
    .section-body { padding: 14px 16px; }
    .payment-input, .payment-select { height: 44px; font-size: 13px; }
    .payment-table thead th, .payment-table tbody td { padding: 8px 10px; font-size: 12px; }
    .payment-table-container { max-height: 180px; }
}

@media (max-width: 576px) {
    .payment-header-icon { width: 40px; height: 40px; font-size: 16px; }
    .summary-card-body { grid-template-columns: 1fr; gap: 6px; }
    .summary-value { font-size: 18px; }
    .payment-table-actions { flex-wrap: wrap; }
    .btn-table-action { font-size: 11px; padding: 4px 10px; }
    .payment-modal-footer { flex-direction: column-reverse; }
    .btn-payment-cancel, .btn-payment-save { width: 100%; justify-content: center; }
}

/* Select2 override */
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

/* Detalle modal */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #E9ECF0;
    margin-bottom: 20px;
}
.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.detail-label {
    font-size: 11px;
    color: #8A9AAE;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}
.detail-value {
    font-size: 14px;
    color: #1A2332;
    font-weight: 500;
}
.detail-section {
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #E9ECF0;
    margin-bottom: 15px;
}
.detail-section-title {
    font-size: 14px;
    font-weight: 700;
    color: #083CAE;
    margin: 0 0 15px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #E9ECF0;
}
.detail-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.detail-table thead th {
    background: #F8FAFC;
    padding: 10px;
    text-align: left;
    font-weight: 600;
    color: #4A5A6E;
    font-size: 11px;
    text-transform: uppercase;
    border-bottom: 2px solid #E9ECF0;
}
.detail-table tbody td {
    padding: 10px;
    border-bottom: 1px solid #F1F3F5;
    color: #1A2332;
}
.detail-table tbody tr:last-child td {
    border-bottom: none;
}

/* Icono PDF individual */
.action-icons .icon-pdf {
    color: #DC3545 !important;
}
.action-icons .icon-pdf:hover {
    color: #C82333 !important;
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

let facturasProveedor = [];
let montoPagoActual = 0;
let proveedorSeleccionadoId = null;
let aplicacionesFacturas = {};

// ============================================
// UTILIDADES
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
    
    fetch(url, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
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
        document.getElementById('tablaBody').innerHTML = '<tr><td colspan="13" style="color:red; text-align:center;">Error al cargar datos: ' + error.message + '</td></tr>';
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
// TABLA (CON BOTÓN PDF INDIVIDUAL POR FILA)
// ============================================
function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="13" style="text-align: center;">No hay registros</td></tr>';
        document.getElementById('sumMonto').textContent = formatCurrency(0);
        document.getElementById('sumMontoRestante').textContent = formatCurrency(0);
        actualizarPaginacion(0);
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
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                        <i class="fas fa-file-pdf icon-pdf" onclick="descargarPdfIndividual(${item.id})" title="Descargar comprobante PDF"></i>
                        <i class="fas fa-edit" onclick="editarPagoProveedor(${item.id})" title="Editar"></i>
                        ${item.estatus === 'activo' ? `<i class="fas fa-check-circle" onclick="aplicarPagoProveedor(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-trash-alt" onclick="eliminarPagoProveedor(${item.id})" title="Eliminar"></i>
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
    const totalPages = Math.ceil(total / rowsPerPage) || 1;
    document.getElementById('paginaActual').textContent = currentPage;
    const start = Math.min((currentPage - 1) * rowsPerPage + 1, total);
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total > 0 ? start : 0}-${end} de ${total} registros`;
}

// ============================================
// MODAL PRINCIPAL - ABRIR
// ============================================
function abrirModalPago() {
    debugLog('Abriendo modal de pago a proveedor');
    
    const modal = document.getElementById('modalPagoProveedor');
    if (!modal) {
        console.error('Modal no encontrado');
        return;
    }
    
    // Resetear todos los campos
    document.getElementById('pago_id').value = '';
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('forma_pago').value = 'transferencia';
    document.getElementById('facturas_aplicadas_json').value = '[]';
    
    aplicacionesFacturas = {};
    facturasProveedor = [];
    montoPagoActual = 0;
    
    // Resetear select2
    const proveedorSelect = document.getElementById('proveedor_select');
    if (proveedorSelect) {
        proveedorSelect.value = '';
        if ($(proveedorSelect).data('select2')) {
            $(proveedorSelect).val(null).trigger('change');
        }
    }
    
    document.getElementById('proveedor_nombre').value = '';
    document.getElementById('rfc').value = '';
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('moneda_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('referencia_bancaria').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('codigo_sat_id').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    
    document.getElementById('resumenFacturasAplicadas').style.display = 'none';
    
    const infoSpan = document.getElementById('codigo_sat_info');
    infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT para este pago';
    infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
    infoSpan.classList.add('text-muted');
    
    // Limpiar tabla preview
    document.getElementById('tablaFacturasPreviewBody').innerHTML = 
        `<tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
            <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
            Selecciona un proveedor para ver sus facturas
        </td></tr>`;
    
    // Resetear totales
    document.getElementById('appTotalPago').textContent = '$0.00';
    document.getElementById('appTotalAplicado').textContent = '$0.00';
    document.getElementById('appDiferencia').textContent = '$0.00';
    document.getElementById('summaryVencido').textContent = '$0.00';
    document.getElementById('summaryPorVencer').textContent = '$0.00';
    document.getElementById('summaryTotal').textContent = '$0.00';
    
    // Cambiar título
    document.getElementById('modalTitle').textContent = 'Nuevo Pago a Proveedor';
    
    new bootstrap.Modal(modal).show();
}

function cargarFacturasProveedor() {
    const proveedorSelect = document.getElementById('proveedor_select');
    if (!proveedorSelect) return;
    
    const selectedOption = proveedorSelect.options[proveedorSelect.selectedIndex];
    
    if (!proveedorSelect.value) {
        document.getElementById('proveedor_nombre').value = '';
        document.getElementById('rfc').value = '';
        facturasProveedor = [];
        renderizarPreviewFacturas();
        return;
    }
    
    const nombre = selectedOption?.getAttribute('data-nombre') || '';
    const rfc = selectedOption?.getAttribute('data-rfc') || '';
    
    document.getElementById('proveedor_nombre').value = nombre;
    document.getElementById('rfc').value = rfc;
    
    cargarFacturasProveedorParaAplicar(proveedorSelect.value);
}

// ============================================
// EDITAR
// ============================================
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
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(item => {
        debugLog('Datos del registro:', item);
        
        if (item.error) throw new Error(item.error);
        
        // Poblar campos básicos
        document.getElementById('pago_id').value = item.id || '';
        document.getElementById('fecha').value = item.fecha || '';
        document.getElementById('forma_pago').value = item.forma_pago || 'transferencia';
        document.getElementById('cuenta_bancaria_id').value = item.cuenta_bancaria_id || '';
        document.getElementById('moneda_id').value = item.moneda_id || '';
        document.getElementById('monto').value = item.monto || '';
        document.getElementById('referencia').value = item.referencia || '';
        document.getElementById('referencia_bancaria').value = item.referencia_bancaria || '';
        document.getElementById('proyecto_id').value = item.proyecto_id || '';
        document.getElementById('descripcion').value = item.descripcion || '';
        document.getElementById('observaciones').value = item.observaciones || '';
        document.getElementById('codigo_sat_id').value = item.codigo_sat_id || '';
        document.getElementById('aplicar_ahora').checked = false;
        document.getElementById('proveedor_nombre').value = item.proveedor || '';
        document.getElementById('rfc').value = item.rfc || '';
        
        // Poblar select2 de proveedor
        const proveedorSelect = document.getElementById('proveedor_select');
        if (proveedorSelect && item.proveedor_id) {
            $(proveedorSelect).val(String(item.proveedor_id)).trigger('change.select2');
        }
        
        // Cargar facturas del proveedor para preview
        if (item.proveedor_id) {
            cargarFacturasProveedorParaAplicar(item.proveedor_id);
        }
        
        // Restaurar facturas aplicadas
        if (item.facturas_aplicadas && typeof item.facturas_aplicadas === 'object') {
            aplicacionesFacturas = {};
            Object.keys(item.facturas_aplicadas).forEach(fid => {
                aplicacionesFacturas[fid] = parseFloat(item.facturas_aplicadas[fid]) || 0;
            });
            document.getElementById('facturas_aplicadas_json').value = JSON.stringify(
                Object.entries(aplicacionesFacturas).map(([id, monto]) => ({
                    factura_id: parseInt(id),
                    monto: parseFloat(monto)
                }))
            );
            
            const totalAplicado = Object.values(aplicacionesFacturas).reduce((a, b) => a + b, 0);
            if (totalAplicado > 0) {
                document.getElementById('resumenFacturasAplicadas').style.display = 'block';
                document.getElementById('resumenFacturasTexto').innerHTML = 
                    `<strong>${Object.keys(aplicacionesFacturas).length} factura(s) aplicadas. Total: ${formatCurrency(totalAplicado)}</strong>`;
                document.getElementById('appTotalAplicado').textContent = formatCurrency(totalAplicado);
                document.getElementById('appDiferencia').textContent = formatCurrency((item.monto || 0) - totalAplicado);
            }
        }
        
        // Actualizar info del código SAT
        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOptionSat = codigoSatSelect?.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOptionSat && selectedOptionSat.value && infoSpan) {
            const codigo = selectedOptionSat.getAttribute('data-codigo') || '';
            const nombre = selectedOptionSat.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT: ${codigo} - ${nombre}`;
            infoSpan.classList.remove('text-muted');
            infoSpan.classList.add('text-success');
        }
        
        // Actualizar totales de aplicación
        montoPagoActual = parseFloat(item.monto) || 0;
        document.getElementById('appTotalPago').textContent = formatCurrency(montoPagoActual);
        
        // Cambiar título
        document.getElementById('modalTitle').textContent = 'Editar Pago a Proveedor';
        
        // Abrir modal
        new bootstrap.Modal(document.getElementById('modalPagoProveedor')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar datos para editar: ' + error.message, 'danger');
    });
}

// ============================================
// GUARDAR
// ============================================
function guardarPagoProveedor() {
    const id = document.getElementById('pago_id').value;
    const codigoSatId = document.getElementById('codigo_sat_id').value;
    
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
        aplicar_ahora: document.getElementById('aplicar_ahora').checked,
        codigo_sat_id: codigoSatId,
        proveedor_id: proveedorSelect.value,
        facturas_aplicadas: facturasAplicadas,
    };
    
    const url = id ? `/admin/api/cheques-transferencias/${id}` : '/admin/api/cheques-transferencias';
    const method = id ? 'PUT' : 'POST';
    
    const btn = document.getElementById('btnGuardarModal');
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
        
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalPagoProveedor'))?.hide();
            cargarChequesTransferencias();
        } else {
            mostrarNotificacion(result.message || 'Error al guardar', 'danger');
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
    });
}

// ============================================
// ELIMINAR / APLICAR
// ============================================
function eliminarPagoProveedor(id) {
    if (confirm('¿Eliminar este pago?')) {
        fetch(`/admin/api/cheques-transferencias/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
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
        fetch(`/admin/api/cheques-transferencias/${id}/aplicar`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
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

// ============================================
// VER DETALLE
// ============================================
function verDetalle(id) {
    debugLog('Ver detalle ID: ' + id);
    
    const modal = new bootstrap.Modal(document.getElementById('modalVerDetalle'));
    document.getElementById('modalVerDetalleBody').innerHTML = `
        <div style="text-align:center; padding:40px;">
            <i class="fas fa-spinner fa-spin" style="font-size:32px; color:#083CAE;"></i>
            <p style="margin-top:15px; color:#6B7A8F;">Cargando información...</p>
        </div>
    `;
    modal.show();
    
    fetch(`/admin/api/cheques-transferencias/${id}`, {
        headers: { 
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP ' + response.status);
        return response.json();
    })
    .then(item => {
        debugLog('Detalle recibido:', item);
        
        if (item.error) throw new Error(item.error);
        
        let facturasHtml = '';
        if (item.facturas_detalle && item.facturas_detalle.length > 0) {
            facturasHtml = `
                <div class="detail-section">
                    <h4 class="detail-section-title">
                        <i class="fas fa-receipt"></i> Facturas Aplicadas (${item.facturas_detalle.length})
                    </h4>
                    <table class="detail-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th style="text-align:right;">Total</th>
                                <th style="text-align:right;">Aplicado</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${item.facturas_detalle.map(f => `
                                <tr>
                                    <td><strong>${escapeHtml(f.folio)}</strong></td>
                                    <td>${formatDate(f.fecha)}</td>
                                    <td style="text-align:right;">${formatCurrency(f.total)}</td>
                                    <td style="text-align:right; color:#28A745; font-weight:600;">${formatCurrency(f.monto_aplicado)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            facturasHtml = `
                <div class="detail-section">
                    <h4 class="detail-section-title">
                        <i class="fas fa-receipt"></i> Facturas Aplicadas
                    </h4>
                    <p style="color:#8A9AAE; margin:0;">No hay facturas aplicadas a este pago.</p>
                </div>
            `;
        }
        
        const estatusTexto = getEstatusTexto(item.estatus);
        const estatusColor = item.estatus === 'activo' ? '#FFC107' : 
                            item.estatus === 'completado' ? '#28A745' : '#DC3545';
        
        const html = `
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Folio</span>
                    <span class="detail-value">${escapeHtml(item.folio) || '-'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Estatus</span>
                    <span class="detail-value">
                        <span style="background:${estatusColor}; color:${item.estatus === 'activo' ? '#000' : '#fff'}; padding:3px 10px; border-radius:6px; font-size:12px; font-weight:600;">
                            ${estatusTexto}
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Proveedor</span>
                    <span class="detail-value">${escapeHtml(item.proveedor) || '-'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">RFC</span>
                    <span class="detail-value">${escapeHtml(item.rfc) || '-'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Forma de Pago</span>
                    <span class="detail-value">${item.forma_pago === 'cheque' ? 'Cheque' : 'Transferencia'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Fecha</span>
                    <span class="detail-value">${formatDate(item.fecha)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Cuenta Bancaria</span>
                    <span class="detail-value">${item.cuenta_bancaria?.numero_cuenta || '-'} ${item.cuenta_bancaria?.banco ? '(' + item.cuenta_bancaria.banco + ')' : ''}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Moneda</span>
                    <span class="detail-value">${item.moneda?.simbolo || '-'} ${item.moneda?.nombre || ''}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Proyecto</span>
                    <span class="detail-value">${item.proyecto?.nombre || 'N/A'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Referencia</span>
                    <span class="detail-value">${escapeHtml(item.referencia) || '-'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Referencia Bancaria</span>
                    <span class="detail-value">${escapeHtml(item.referencia_bancaria) || '-'}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Código SAT</span>
                    <span class="detail-value">${item.codigo_sat?.codigo_agrupador || '-'} ${item.codigo_sat?.nombre_cuenta ? '- ' + item.codigo_sat.nombre_cuenta : ''}</span>
                </div>
            </div>
            
            <div class="detail-section" style="background:linear-gradient(135deg, #083CAE 0%, #0A4BC9 100%); color:white;">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
                    <div>
                        <div style="font-size:11px; opacity:0.8; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Monto Total</div>
                        <div style="font-size:24px; font-weight:700; margin-top:4px;">${formatCurrency(item.monto)}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; opacity:0.8; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Monto Aplicado</div>
                        <div style="font-size:24px; font-weight:700; margin-top:4px;">${formatCurrency(item.monto_aplicado)}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; opacity:0.8; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Monto Restante</div>
                        <div style="font-size:24px; font-weight:700; margin-top:4px;">${formatCurrency(item.monto_restante)}</div>
                    </div>
                </div>
            </div>
            
            ${item.descripcion ? `
                <div class="detail-section">
                    <h4 class="detail-section-title"><i class="fas fa-pen"></i> Concepto</h4>
                    <p style="margin:0; color:#4A5A6E;">${escapeHtml(item.descripcion)}</p>
                </div>
            ` : ''}
            
            ${item.observaciones ? `
                <div class="detail-section">
                    <h4 class="detail-section-title"><i class="fas fa-comment"></i> Observaciones</h4>
                    <p style="margin:0; color:#4A5A6E;">${escapeHtml(item.observaciones)}</p>
                </div>
            ` : ''}
            
            ${facturasHtml}
        `;
        
        document.getElementById('modalVerDetalleBody').innerHTML = html;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('modalVerDetalleBody').innerHTML = `
            <div style="text-align:center; padding:40px; color:#DC3545;">
                <i class="fas fa-exclamation-triangle" style="font-size:32px;"></i>
                <p style="margin-top:15px;">Error al cargar el detalle: ${error.message}</p>
            </div>
        `;
    });
}

// ============================================
// APLICACIÓN A FACTURAS
// ============================================
function abrirAplicacionFacturas() {
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
    proveedorSeleccionadoId = proveedorId;
    
    document.getElementById('proveedorNombreFacturas').textContent = proveedorNombre;
    document.getElementById('montoPagoFacturas').textContent = formatCurrency(monto);
    document.getElementById('totalAplicadoFacturas').textContent = 'Aplicado: $0.00';
    document.getElementById('diferenciaFacturas').textContent = `Diferencia: ${formatCurrency(monto)}`;
    document.getElementById('diferenciaFacturas').className = 'summary-value';
    
    document.getElementById('tablaFacturasBody').innerHTML = 
        '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Cargando facturas...</td></tr>';
    
    new bootstrap.Modal(document.getElementById('modalAplicarFacturas')).show();
    
    cargarFacturasProveedorParaAplicar(proveedorId);
}

function cargarFacturasProveedorParaAplicar(proveedorId) {
    debugLog('Cargando facturas del proveedor ID: ' + proveedorId);
    
    if (!proveedorId) return;
    
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
            
            document.getElementById('saldoVencido').textContent = formatCurrency(totales.vencido);
            document.getElementById('saldoPorVencer').textContent = formatCurrency(totales.por_vencer);
            document.getElementById('saldoTotal').textContent = formatCurrency(totales.total);
            
            document.getElementById('summaryVencido').textContent = formatCurrency(totales.vencido);
            document.getElementById('summaryPorVencer').textContent = formatCurrency(totales.por_vencer);
            document.getElementById('summaryTotal').textContent = formatCurrency(totales.total);
            
            renderizarPreviewFacturas();
            
            const modalAplicar = document.getElementById('modalAplicarFacturas');
            if (modalAplicar && modalAplicar.classList.contains('show')) {
                renderizarTablaFacturas();
            }
        } else {
            mostrarNotificacion(result.message || 'Error al cargar facturas', 'danger');
        }
    })
    .catch(error => {
        console.error('Error cargando facturas:', error);
        document.getElementById('tablaFacturasBody').innerHTML = 
            '<tr><td colspan="8" style="color:red; text-align:center;">Error al cargar facturas: ' + error.message + '</td></tr>';
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
                <td><strong>${escapeHtml(factura.folio)}</strong></td>
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
            <i class="fas fa-ellipsis-h"></i> Y ${facturasProveedor.length - 5} factura(s) más.
        </td></tr>`;
    }
    
    tbody.innerHTML = html;
}

function renderizarTablaFacturas() {
    const tbody = document.getElementById('tablaFacturasBody');
    if (!tbody) return;
    
    if (!facturasProveedor || facturasProveedor.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>Este proveedor no tiene facturas pendientes</td></tr>';
        document.getElementById('totalSaldoPendiente').textContent = '$0.00';
        document.getElementById('totalMontoAplicar').textContent = '$0.00';
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
                <td><strong>${escapeHtml(factura.folio)}</strong></td>
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
    
    document.getElementById('totalSaldoPendiente').textContent = formatCurrency(totalSaldo);
    document.getElementById('totalMontoAplicar').textContent = formatCurrency(totalAplicado);
    
    const diffFinal = montoPagoActual - totalAplicado;
    const difElement = document.getElementById('diferenciaFacturas');
    difElement.textContent = `Diferencia: ${formatCurrency(diffFinal)}`;
    
    if (Math.abs(diffFinal) < 0.01) {
        difElement.className = 'summary-value summary-value-success';
    } else if (diffFinal > 0) {
        difElement.className = 'summary-value summary-value-warning';
    } else {
        difElement.className = 'summary-value summary-value-danger';
    }
    
    document.getElementById('totalAplicadoFacturas').textContent = `Aplicado: ${formatCurrency(totalAplicado)}`;
    document.getElementById('appTotalAplicado').textContent = formatCurrency(totalAplicado);
    document.getElementById('appDiferencia').textContent = formatCurrency(diffFinal);
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
    aplicacionesFacturas = {};
    renderizarTablaFacturas();
}

function confirmarAplicacionFacturas() {
    const totalAplicado = Object.values(aplicacionesFacturas).reduce((a, b) => a + b, 0);
    
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
    
    document.getElementById('facturas_aplicadas_json').value = JSON.stringify(facturasAplicadas);
    
    const resumenDiv = document.getElementById('resumenFacturasAplicadas');
    resumenDiv.style.display = 'block';
    
    const resumenTexto = facturasAplicadas.map(f => {
        const factura = facturasProveedor.find(fc => fc.id === f.factura_id);
        return `${factura?.folio || 'F-' + f.factura_id}: ${formatCurrency(f.monto)}`;
    }).join('<br>');
    
    document.getElementById('resumenFacturasTexto').innerHTML = resumenTexto + 
        `<br><strong>Total aplicado: ${formatCurrency(totalAplicado)}</strong>`;
    
    document.getElementById('appTotalAplicado').textContent = formatCurrency(totalAplicado);
    document.getElementById('appDiferencia').textContent = formatCurrency(montoPagoActual - totalAplicado);
    
    bootstrap.Modal.getInstance(document.getElementById('modalAplicarFacturas'))?.hide();
    
    mostrarNotificacion(`Se aplicarán ${formatCurrency(totalAplicado)} a ${facturasAplicadas.length} factura(s)`, 'success');
}

// ============================================
// NOTIFICACIONES
// ============================================
function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '999999';
    alertDiv.style.minWidth = '300px';
    alertDiv.style.maxWidth = '500px';
    alertDiv.style.whiteSpace = 'pre-line';
    alertDiv.style.boxShadow = '0 8px 24px rgba(0,0,0,0.15)';
    alertDiv.style.borderRadius = '10px';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}

// ============================================
// EXPORTAR EXCEL
// ============================================
function exportarExcel() {
    const tabla = document.getElementById('tablaChequesTransferencias').cloneNode(true);
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tabla.outerHTML);
    link.download = 'pagos_proveedores.xls';
    link.click();
}

// ============================================
// DESCARGAR PDF (LISTADO COMPLETO CON FILTROS)
// ============================================
function descargarPdf() {
    debugLog('Generando PDF con filtros activos...');
    
    const params = new URLSearchParams();
    
    const fechaInicio = document.getElementById('fechaInicio')?.value;
    const fechaFin = document.getElementById('fechaFin')?.value;
    const proveedorId = document.getElementById('filtroProveedor')?.value;
    const buscar = document.getElementById('buscador')?.value;
    
    if (fechaInicio) params.append('fecha_inicio', fechaInicio);
    if (fechaFin) params.append('fecha_fin', fechaFin);
    if (proveedorId) params.append('proveedor_id', proveedorId);
    if (buscar) params.append('buscar', buscar);
    
    const url = '/admin/api/cheques-transferencias/pdf' + (params.toString() ? '?' + params.toString() : '');
    
    window.open(url, '_blank');
}

// ============================================
// DESCARGAR PDF INDIVIDUAL (COMPROBANTE POR FILA) ⬅️ NUEVO
// ============================================
function descargarPdfIndividual(id) {
    if (!id) {
        mostrarNotificacion('ID de transferencia no válido', 'warning');
        return;
    }
    
    debugLog('Descargando PDF individual de transferencia ID: ' + id);
    
    const url = `/admin/api/cheques-transferencias/${id}/pdf`;
    
    window.open(url, '_blank');
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

// Actualizar totales cuando cambia el monto
document.getElementById('monto')?.addEventListener('input', function() {
    const monto = parseFloat(this.value) || 0;
    montoPagoActual = monto;
    document.getElementById('appTotalPago').textContent = formatCurrency(monto);
    document.getElementById('montoPagoFacturas').textContent = formatCurrency(monto);
    
    const totalAplicado = Object.values(aplicacionesFacturas).reduce((a, b) => a + b, 0);
    document.getElementById('appDiferencia').textContent = formatCurrency(monto - totalAplicado);
});

// Actualizar info del código SAT al cambiar
document.getElementById('codigo_sat_id')?.addEventListener('change', function() {
    const infoSpan = document.getElementById('codigo_sat_info');
    if (this.value) {
        const option = this.options[this.selectedIndex];
        const codigo = option.getAttribute('data-codigo') || '';
        const nombre = option.getAttribute('data-nombre') || '';
        infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT: ${codigo} - ${nombre}`;
        infoSpan.classList.remove('text-muted');
        infoSpan.classList.add('text-success');
    } else {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT para este pago';
        infoSpan.classList.remove('text-success');
        infoSpan.classList.add('text-muted');
    }
});
</script>
@endsection