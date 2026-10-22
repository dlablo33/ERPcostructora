@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Depósitos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Depósitos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DEPÓSITOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Total Depósitos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalDepositos">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Aplicados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalAplicados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Pendientes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalPendientes">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">En Proceso</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalProceso">0</div>
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
                        <div><button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px;" onclick="abrirModalDeposito()"><i class="fas fa-plus" style="color: #083CAE;"></i></button></div>
                        <div><button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;" onclick="exportarExcel()"><i class="fas fa-file-excel" style="color: #083CAE;"></i> Excel</button></div>
                        <div><button id="btnColumnas" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-columns" style="color: #083CAE;"></i> Columnas</button></div>
                        <div style="position: relative;"><i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i><input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;"></div>
                    </div>
                </div>

                <!-- Tabla de Depósitos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaDepositos" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th draggable="true" data-columna="folio" class="col-folio">Folio</th>
                                <th draggable="true" data-columna="fecha" class="col-fecha">Fecha</th>
                                <th draggable="true" data-columna="banco" class="col-banco">Banco</th>
                                <th draggable="true" data-columna="cuenta" class="col-cuenta">Cuenta</th>
                                <th draggable="true" data-columna="monto" class="col-monto">Monto</th>
                                <th draggable="true" data-columna="concepto" class="col-concepto">Concepto</th>
                                <th draggable="true" data-columna="tipo_ingreso" class="col-tipo_ingreso">Tipo Ingreso</th>
                                <th draggable="true" data-columna="estatus" class="col-estatus">Estatus</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="9" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;" id="tablaFooter">
                            <tr>
                                <td colspan="4" style="text-align: center;">Totales:</td>
                                <td style="text-align: right;" id="sumMonto">$0.00</td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; flex-wrap: wrap; gap: 10px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #2378e1;"><i class="fas fa-filter"></i> Crear filtro</button>
                    <div style="display: flex; align-items: center; gap: 5px; flex-wrap: wrap;">
                        <button id="btnPrimera" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="background-color: #2378e1; color: white; padding: 5px 10px; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="background: none; border: none; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1; margin-left: 10px;">Mostrando 0-0 de 0 registros</span>
                        <select id="rowsPerPage" onchange="cambiarFilasPorPagina(this.value)" 
                                style="margin-left: 10px; padding: 4px 8px; border: 1px solid #2378e1; border-radius: 4px; color: #2378e1; background: white;">
                            <option value="5">5 por página</option>
                            <option value="10" selected>10 por página</option>
                            <option value="15">15 por página</option>
                            <option value="20">20 por página</option>
                            <option value="50">50 por página</option>
                            <option value="100">100 por página</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================================ -->
<!-- MODAL DE DEPÓSITO - REDISEÑADO -->
<!-- ============================================ -->
<div class="modal fade" id="modalDeposito" tabindex="-1" aria-labelledby="modalDepositoLabel" aria-hidden="true" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content payment-modal-content">
            
            <!-- ========== HEADER ========== -->
            <div class="modal-header payment-modal-header">
                <div class="payment-header-left">
                    <div class="payment-header-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="payment-header-info">
                        <h5 class="modal-title payment-modal-title" id="modalTitle">Nuevo Depósito</h5>
                        <p class="payment-subtitle">Registra un ingreso bancario y aplícalo al cliente correspondiente.</p>
                    </div>
                </div>
                <button type="button" class="btn-close payment-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- ========== BODY ========== -->
            <div class="modal-body payment-modal-body">
                <form id="formDeposito">
                    <input type="hidden" id="deposito_id">
                    <input type="hidden" id="facturas_aplicadas_json" value="[]">
                    
                    <!-- SECCIÓN 1: DATOS DEL DEPÓSITO -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-credit-card section-icon"></i>
                            <span class="section-title">Datos del Depósito</span>
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
                                            <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }} ({{ $cuenta->moneda->simbolo ?? '' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Monto <span class="text-danger">*</span></label>
                                    <input type="number" id="monto" class="payment-input" step="0.01" required placeholder="$0.00">
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field payment-field-full">
                                    <label class="payment-label">Referencia Bancaria</label>
                                    <input type="text" id="referencia" class="payment-input" placeholder="Ej: TRF-123456">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SECCIÓN 2: ORIGEN DEL INGRESO -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-building section-icon"></i>
                            <span class="section-title">Origen del Ingreso</span>
                        </div>
                        <div class="section-body">
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Tipo de Ingreso <span class="text-danger">*</span></label>
                                    <select id="tipo_ingreso_id" class="payment-select form-select" required>
                                        <option value="">Seleccionar tipo...</option>
                                        @foreach($tiposIngreso ?? [] as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">Cliente / Razón Social <span class="text-danger">*</span></label>
                                    <select id="cliente_select" class="payment-select form-select select2" style="width: 100%;">
                                        <option value="">Seleccionar cliente...</option>
                                        @foreach($clientes ?? [] as $cliente)
                                            <option value="{{ $cliente->id }}" 
                                                data-nombre="{{ $cliente->nombre }}"
                                                data-rfc="{{ $cliente->rfc ?? '' }}">
                                                {{ $cliente->nombre }} - {{ $cliente->rfc ?? 'Sin RFC' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Razón Social</label>
                                    <input type="text" id="cliente_nombre" class="payment-input payment-input-readonly" readonly>
                                </div>
                                <div class="payment-field">
                                    <label class="payment-label">RFC</label>
                                    <input type="text" id="cliente_rfc" class="payment-input payment-input-readonly" readonly>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field">
                                    <label class="payment-label">Proyecto (opcional)</label>
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
                                        @foreach($codigosSatIngresos ?? [] as $codigo)
                                            <option value="{{ $codigo->id }}" 
                                                data-codigo="{{ $codigo->codigo_agrupador }}"
                                                data-nombre="{{ $codigo->nombre_cuenta }}"
                                                data-tipo="{{ $codigo->tipo }}">
                                                {{ $codigo->codigo_agrupador }} - {{ $codigo->nombre_cuenta }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="payment-hint" id="codigo_sat_info">
                                        <i class="fas fa-info-circle"></i> Selecciona el código SAT que corresponde a este ingreso
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SECCIÓN 3: APLICACIÓN DEL DEPÓSITO -->
                    <div class="payment-section">
                        <div class="section-header">
                            <i class="fas fa-receipt section-icon"></i>
                            <span class="section-title">Aplicación del Depósito</span>
                        </div>
                        <div class="section-body">
                            <div class="summary-cards">
                                <div class="summary-card">
                                    <div class="summary-card-header">
                                        <i class="fas fa-user-tie summary-icon"></i>
                                        <span class="summary-card-title">Cliente</span>
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
                                        <p class="summary-text">Aplica el monto del depósito a las facturas más antiguas primero.</p>
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
                            
                            <div class="payment-table-wrapper">
                                <div class="payment-table-header">
                                    <span class="payment-table-title">Facturas del Cliente</span>
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
                                                Selecciona un cliente para ver sus facturas
                                            </td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="application-totals">
                                <div class="application-total-item">
                                    <span class="application-total-label">Monto del depósito</span>
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
                                    <label class="payment-label">Concepto <span class="text-danger">*</span></label>
                                    <input type="text" id="concepto" class="payment-input" placeholder="Ej: Pago de factura F-001" required>
                                </div>
                            </div>
                            <div class="payment-row">
                                <div class="payment-field payment-field-full">
                                    <label class="payment-label">Observaciones</label>
                                    <textarea id="observaciones" class="payment-textarea" rows="2" placeholder="Notas adicionales sobre este depósito..."></textarea>
                                </div>
                            </div>
                            <div class="payment-row payment-row-switch">
                                <div class="payment-field payment-field-switch">
                                    <div class="payment-switch-container">
                                        <span class="payment-switch-label">Aplicar depósito inmediatamente</span>
                                        <div class="payment-switch">
                                            <input type="checkbox" id="aplicar_ahora" class="payment-switch-input" checked>
                                            <label class="payment-switch-slider" for="aplicar_ahora"></label>
                                        </div>
                                        <span class="payment-switch-hint">El depósito afectará saldos y reportes al guardar.</span>
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
                <button type="button" class="btn btn-primary btn-payment-save" onclick="guardarDeposito()" id="btnGuardarModal">
                    <i class="fas fa-save"></i> Guardar Depósito
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL PARA APLICAR FACTURAS DE CLIENTE -->
<!-- ============================================ -->
<div class="modal fade" id="modalAplicarFacturas" tabindex="-1" aria-hidden="true" style="z-index: 100000 !important;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content payment-modal-content">
            
            <div class="modal-header payment-modal-header">
                <div class="payment-header-left">
                    <div class="payment-header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="payment-header-info">
                        <h5 class="modal-title payment-modal-title">Aplicar Depósito a Facturas de Cliente</h5>
                        <p class="payment-subtitle">Selecciona las facturas a las que deseas aplicar este depósito.</p>
                    </div>
                </div>
                <button type="button" class="btn-close payment-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body payment-modal-body">
                <div class="summary-cards summary-cards-apply">
                    <div class="summary-card summary-card-cliente">
                        <div class="summary-card-header">
                            <i class="fas fa-user-tie summary-icon"></i>
                            <span class="summary-card-title">Cliente</span>
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
                    
                    <div class="summary-card summary-card-deposito">
                        <div class="summary-card-header">
                            <i class="fas fa-hand-holding-usd summary-icon"></i>
                            <span class="summary-card-title">Depósito</span>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-item">
                                <span class="summary-label">Monto del depósito</span>
                                <span class="summary-value summary-value-success" id="montoDepositoFacturas">$0.00</span>
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
                
                <div class="payment-table-wrapper">
                    <div class="payment-table-header">
                        <span class="payment-table-title">Facturas del Cliente</span>
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
                                    Seleccione un cliente para ver sus facturas
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
            
            <div class="modal-footer payment-modal-footer">
                <button type="button" class="btn btn-secondary btn-payment-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-payment-save" onclick="confirmarAplicacionFacturas()">
                    <i class="fas fa-check"></i> Aplicar Depósito
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================ */
/* ESTILOS DEL MODAL - REDISEÑO PROFESIONAL */
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
.btn-payment-save:active {
    transform: translateY(0) !important;
}
.btn-payment-save:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
}

@media (max-width: 992px) {
    .payment-modal-header { padding: 18px 20px; flex-wrap: wrap; }
    .payment-modal-body { padding: 16px 16px 4px 16px; }
    .payment-row { grid-template-columns: 1fr 1fr; }
    .summary-cards { grid-template-columns: 1fr; }
    .summary-card-body { grid-template-columns: 1fr 1fr 1fr; }
    .application-totals { grid-template-columns: 1fr 1fr; }
    .payment-modal-footer { padding: 12px 20px; flex-wrap: wrap; justify-content: center; }
    .btn-payment-cancel, .btn-payment-save { flex: 1; justify-content: center; min-width: 120px; }
}

@media (max-width: 768px) {
    .payment-header-left { flex-wrap: wrap; }
    .payment-modal-title { font-size: 18px; }
    .payment-subtitle { font-size: 13px; }
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

.badge.bg-danger {
    background: #DC3545 !important;
    color: white !important;
    font-size: 10px !important;
    padding: 3px 8px !important;
    border-radius: 6px !important;
    font-weight: 600 !important;
}

/* Estilos para la tabla principal de depósitos */
.custom-card { transition: transform 0.2s; }
.custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
.table th { background-color: #2378e1 !important; color: white; font-size: 12px; padding: 10px 4px; white-space: nowrap; }
.table td { font-size: 12px; padding: 10px 4px; white-space: nowrap; }
#tablaBody tr:nth-child(odd) { background-color: #ffffff; }
#tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
#tablaBody tr:hover { background-color: #e0e0e0; }
.badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
.badge-aplicado { background-color: #28a745; color: white; }
.badge-pendiente { background-color: #fd7e14; color: white; }
.badge-rechazado { background-color: #dc3545; color: white; }
.badge-proceso { background-color: #17a2b8; color: white; }
.action-icons i { font-size: 14px; cursor: pointer; margin: 0 3px; transition: transform 0.15s; }
.action-icons i:hover { transform: scale(1.2); }
.fa-eye { color: #17a2b8; }
.fa-edit { color: #ffc107; }
.fa-trash-alt { color: #dc3545; }
.fa-check-circle { color: #28a745; }
.fa-file-pdf { color: #dc3545; }
[draggable="true"] { cursor: grab; }
.columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background-color: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
.columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-weight: bold; }
.fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
.fila-detalle td:first-child { padding-left: 30px !important; }
tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; }
.modal { z-index: 99999 !important; }
.modal-backdrop { z-index: 99990 !important; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '<?php echo csrf_token(); ?>';

// ============================================
// VARIABLES GLOBALES
// ============================================
let columnasAgrupadas = [];
let expandedGroups = new Set();
let datosOriginales = [];
let currentPage = 1;
let rowsPerPage = 10;

// Columnas disponibles y visibles
const todasLasColumnas = [
    { key: 'folio', label: 'Folio' },
    { key: 'fecha', label: 'Fecha' },
    { key: 'banco', label: 'Banco' },
    { key: 'cuenta', label: 'Cuenta' },
    { key: 'monto', label: 'Monto' },
    { key: 'concepto', label: 'Concepto' },
    { key: 'tipo_ingreso', label: 'Tipo Ingreso' },
    { key: 'estatus', label: 'Estatus' }
];
let columnasVisibles = todasLasColumnas.map(c => c.key);

// Variables para aplicación de facturas
let facturasCliente = [];
let montoDepositoActual = 0;
let clienteSeleccionadoId = null;
let aplicacionesFacturas = {};

// ============================================
// FUNCIONES DE FORMATO
// ============================================
function formatCurrency(amount) {
    const num = parseFloat(amount);
    if (isNaN(num)) return '$0.00';
    return '$' + num.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '-';
        return date.toLocaleDateString('es-MX');
    } catch (e) {
        return dateString;
    }
}

function getBadgeClass(estatus) {
    if (estatus === 'aplicado') return 'badge-aplicado';
    if (estatus === 'pendiente') return 'badge-pendiente';
    if (estatus === 'rechazado') return 'badge-rechazado';
    if (estatus === 'proceso') return 'badge-proceso';
    return 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    if (estatus === 'aplicado') return 'Aplicado';
    if (estatus === 'pendiente') return 'Pendiente';
    if (estatus === 'rechazado') return 'Rechazado';
    if (estatus === 'proceso') return 'Proceso';
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
    debugLog('Inicializando módulo de Depósitos');
    
    $('#cliente_select').select2({
        dropdownParent: $('#modalDeposito'),
        placeholder: 'Buscar cliente...',
        allowClear: true,
        width: '100%'
    });
    
    // Aplicar columnas visibles al inicio
    aplicarVisibilidadColumnas();
    
    // ✅ Inicializar rango de fechas por defecto (mes actual)
    inicializarRangoFechas();
    
    debugLog('Select2 inicializado');
    cargarDepositos();
});

// ============================================
// RANGO DE FECHAS POR DEFECTO
// ============================================
function inicializarRangoFechas() {
    const fechaInicioInput = document.getElementById('fechaInicio');
    const fechaFinInput = document.getElementById('fechaFin');
    
    // Si ya tienen valor (ej. recarga con parámetros), respetarlos
    if (fechaInicioInput?.value && fechaFinInput?.value) {
        debugLog('Rango de fechas ya definido:', { 
            inicio: fechaInicioInput.value, 
            fin: fechaFinInput.value 
        });
        return;
    }
    
    const hoy = new Date();
    
    // Opción A: Mes actual (recomendado para contabilidad)
    const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    const ultimoDiaMes = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
    
    // Opción B (alternativa): Últimos 30 días
    // const hace30Dias = new Date(hoy);
    // hace30Dias.setDate(hoy.getDate() - 30);
    
    const formatYMD = (d) => {
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const dd = String(d.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    };
    
    if (fechaInicioInput) fechaInicioInput.value = formatYMD(primerDiaMes);
    if (fechaFinInput)    fechaFinInput.value    = formatYMD(ultimoDiaMes);
    
    debugLog('Rango de fechas inicializado:', {
        inicio: fechaInicioInput?.value,
        fin: fechaFinInput?.value
    });
}

// ============================================
// VISIBILIDAD DE COLUMNAS
// ============================================
function aplicarVisibilidadColumnas() {
    // Crear o actualizar el <style> dinámico
    let styleEl = document.getElementById('columnasVisibilityStyle');
    if (!styleEl) {
        styleEl = document.createElement('style');
        styleEl.id = 'columnasVisibilityStyle';
        document.head.appendChild(styleEl);
    }
    
    // Todas las columnas disponibles
    const todasKeys = todasLasColumnas.map(c => c.key);
    
    // Generar reglas CSS para ocultar las columnas NO visibles (th y td)
    let css = '';
    todasKeys.forEach(key => {
        if (!columnasVisibles.includes(key)) {
            css += `#tablaDepositos th.col-${key}, #tablaDepositos td.col-${key} { display: none !important; }\n`;
        }
    });
    styleEl.innerHTML = css;
    
    // Actualizar colspans del footer
    actualizarFooterColspan();
}

function actualizarFooterColspan() {
    const tfoot = document.getElementById('tablaFooter');
    if (!tfoot) return;
    
    const tr = tfoot.querySelector('tr');
    if (!tr) return;
    
    const montoActual = document.getElementById('sumMonto')?.textContent || '$0.00';
    
    // Columnas del orden de la tabla
    const ordenColumnas = ['folio', 'fecha', 'banco', 'cuenta', 'monto', 'concepto', 'tipo_ingreso', 'estatus'];
    const indexMonto = ordenColumnas.indexOf('monto');
    
    // Contar visibles antes y después de monto
    const visiblesAntes = ordenColumnas.slice(0, indexMonto).filter(c => columnasVisibles.includes(c)).length;
    const visiblesDespues = ordenColumnas.slice(indexMonto + 1).filter(c => columnasVisibles.includes(c)).length;
    
    // Reconstruir footer
    tr.innerHTML = `
        <td colspan="${visiblesAntes}" style="text-align: center;">Totales:</td>
        <td style="text-align: right;" id="sumMonto">${montoActual}</td>
        <td colspan="${visiblesDespues}"></td>
    `;
}

function abrirModalColumnas() {
    const html = `
        <div class="modal fade" id="modalColumnas" tabindex="-1" style="z-index: 100001;">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 16px; border: none;">
                    <div class="modal-header" style="background: #083CAE; color: white; border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title"><i class="fas fa-columns"></i> Seleccionar Columnas</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding: 24px;">
                        <p class="text-muted" style="font-size: 13px;">Selecciona las columnas que deseas mostrar en la tabla.</p>
                        <div class="form-check mb-3 pb-3" style="border-bottom: 1px solid #E9ECF0;">
                            <input class="form-check-input" type="checkbox" id="checkTodasColumnas" ${columnasVisibles.length === todasLasColumnas.length ? 'checked' : ''}>
                            <label class="form-check-label fw-bold" for="checkTodasColumnas" style="cursor: pointer;">
                                Seleccionar todas
                            </label>
                        </div>
                        ${todasLasColumnas.map(col => `
                            <div class="form-check mb-2">
                                <input class="form-check-input columna-check" type="checkbox" 
                                       value="${col.key}" id="col_${col.key}"
                                       ${columnasVisibles.includes(col.key) ? 'checked' : ''}
                                       style="cursor: pointer;">
                                <label class="form-check-label" for="col_${col.key}" style="cursor: pointer;">
                                    ${col.label}
                                </label>
                            </div>
                        `).join('')}
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #E9ECF0;">
                        <button type="button" class="btn btn-secondary btn-payment-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-payment-save" onclick="aplicarColumnasSeleccionadas()">
                            <i class="fas fa-check"></i> Aplicar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('modalColumnas')?.remove();
    document.body.insertAdjacentHTML('beforeend', html);
    
    const modal = new bootstrap.Modal(document.getElementById('modalColumnas'));
    modal.show();
    
    document.getElementById('checkTodasColumnas')?.addEventListener('change', function() {
        document.querySelectorAll('.columna-check').forEach(cb => {
            cb.checked = this.checked;
        });
    });
}

function aplicarColumnasSeleccionadas() {
    const seleccionadas = [];
    document.querySelectorAll('.columna-check:checked').forEach(cb => {
        seleccionadas.push(cb.value);
    });
    
    if (seleccionadas.length === 0) {
        mostrarNotificacion('Debe seleccionar al menos una columna', 'warning');
        return;
    }
    
    columnasVisibles = seleccionadas;
    
    // Aplicar CSS (th y td)
    aplicarVisibilidadColumnas();
    
    // Re-renderizar tabla para asegurar que el tbody use las clases correctas
    cargarTabla(datosOriginales);
    
    bootstrap.Modal.getInstance(document.getElementById('modalColumnas'))?.hide();
    mostrarNotificacion('Columnas actualizadas correctamente', 'success');
}

// ============================================
// CARGA DE DATOS
// ============================================
function cargarDepositos() {
    debugLog('Cargando datos...');
    
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    
    let url = '/admin/api/depositos?';
    if (fechaInicio) url += 'fecha_inicio=' + fechaInicio + '&';
    if (fechaFin) url += 'fecha_fin=' + fechaFin + '&';
    
    debugLog('URL: ' + url);
    
    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        debugLog('Datos recibidos: ' + data.length + ' registros');
        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio,
            fecha: d.fecha,
            banco: d.cuenta_bancaria?.banco?.nombre || '-',
            cuenta: d.cuenta_bancaria?.numero_cuenta || '-',
            monto: parseFloat(d.monto) || 0,
            concepto: d.concepto,
            tipo_ingreso: d.tipo_ingreso?.nombre || '-',
            estatus: d.estatus
        }));
        cargarTabla(datosOriginales);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('tablaBody').innerHTML = '<tr><td colspan="9" style="color:red; text-align:center;">Error al cargar datos: ' + error.message + '</td></tr>';
        mostrarNotificacion('Error al cargar datos: ' + error.message, 'danger');
    });
}

function actualizarContadores(datos) {
    document.getElementById('totalDepositos').textContent = datos.length;
    document.getElementById('totalAplicados').textContent = datos.filter(d => d.estatus === 'aplicado').length;
    document.getElementById('totalPendientes').textContent = datos.filter(d => d.estatus === 'pendiente').length;
    document.getElementById('totalProceso').textContent = datos.filter(d => d.estatus === 'proceso').length;
}

function generarGrupoId(item, columnas) {
    return columnas.map(col => item[col] || 'Sin dato').join('||');
}

function agruparDatos(datos, columnas) {
    if (columnas.length === 0) return { grupos: [], items: datos };
    const gruposMap = new Map();
    datos.forEach(item => {
        const grupoId = generarGrupoId(item, columnas);
        if (!gruposMap.has(grupoId)) {
            gruposMap.set(grupoId, { 
                id: grupoId, 
                valor: columnas.map(col => item[col] || 'Sin dato').join(' - '), 
                items: [item], 
                totalMonto: parseFloat(item.monto) || 0 
            });
        } else {
            const grupo = gruposMap.get(grupoId);
            grupo.items.push(item);
            grupo.totalMonto += parseFloat(item.monto) || 0;
        }
    });
    return { grupos: Array.from(gruposMap.values()), items: [] };
}

function getCurrentPageData(datos) {
    const start = (currentPage - 1) * rowsPerPage;
    return datos.slice(start, start + rowsPerPage);
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage) || 1;
    if (currentPage > totalPages) currentPage = totalPages;
    
    document.getElementById('paginaActual').textContent = currentPage;
    const inicio = total === 0 ? 0 : Math.min((currentPage - 1) * rowsPerPage + 1, total);
    const fin = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginacionInfo').textContent = `Mostrando ${inicio}-${fin} de ${total} registros`;
}

function calcularTotales(datos) {
    let totalMonto = 0;
    datos.forEach(item => {
        const monto = parseFloat(item.monto);
        if (!isNaN(monto)) {
            totalMonto += monto;
        }
    });
    const sumMontoEl = document.getElementById('sumMonto');
    if (sumMontoEl) {
        sumMontoEl.textContent = formatCurrency(totalMonto);
    }
}

function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    const textoAgrupar = document.getElementById('textoAgrupar');
    
    // Aplicar visibilidad de columnas (CSS dinámico)
    aplicarVisibilidadColumnas();
    
    actualizarContadores(datos);
    if (textoAgrupar) textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
    
    const { grupos } = agruparDatos(datos, columnasAgrupadas);
    const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
    tablaBody.innerHTML = '';
    
    if (datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay depósitos registrados</td></tr>';
        calcularTotales(datos);
        actualizarPaginacion(0);
        return;
    }
    
    if (hayGrupos) {
        grupos.forEach(grupo => {
            const grupoRow = document.createElement('tr');
            grupoRow.className = 'fila-grupo';
            grupoRow.dataset.grupoId = grupo.id;
            if (expandedGroups.has(grupo.id)) grupoRow.classList.add('expandido');
            grupoRow.innerHTML = `<td colspan="9"><div style="display: flex; justify-content: space-between;"><div><i class="fas fa-caret-${expandedGroups.has(grupo.id) ? 'down' : 'right'}"></i> <strong>${grupo.valor}</strong> <span style="color:#6c757d;">(${grupo.items.length} registros - Total: ${formatCurrency(grupo.totalMonto)})</span></div></div></td>`;
            tablaBody.appendChild(grupoRow);
            
            if (expandedGroups.has(grupo.id)) {
                grupo.items.forEach(item => {
                    const detalleRow = document.createElement('tr');
                    detalleRow.className = 'fila-detalle';
                    detalleRow.innerHTML = `
                        <td class="col-folio" style="padding-left:30px;">${item.folio || '-'}</td>
                        <td class="col-fecha">${formatDate(item.fecha)}</td>
                        <td class="col-banco">${item.banco || '-'}</td>
                        <td class="col-cuenta">${item.cuenta || '-'}</td>
                        <td class="col-monto" style="text-align:right;">${formatCurrency(item.monto)}</td>
                        <td class="col-concepto">${item.concepto || '-'}</td>
                        <td class="col-tipo_ingreso">${item.tipo_ingreso || '-'}</td>
                        <td class="col-estatus"><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                        <td style="position:sticky;right:0;background:white;">
                            <div class="action-icons">
                                <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                                <i class="fas fa-edit" onclick="editarDeposito(${item.id})" title="Editar"></i>
                                <i class="fas fa-trash-alt" onclick="eliminarDeposito(${item.id})" title="Eliminar"></i>
                                ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarDeposito(${item.id})" title="Aplicar"></i>` : ''}
                                <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="Generar PDF"></i>
                            </div>
                        </td>
                    `;
                    tablaBody.appendChild(detalleRow);
                });
            }
        });
    } else {
        const pageData = getCurrentPageData(datos);
        pageData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="col-folio">${item.folio || '-'}</td>
                <td class="col-fecha">${formatDate(item.fecha)}</td>
                <td class="col-banco">${item.banco || '-'}</td>
                <td class="col-cuenta">${item.cuenta || '-'}</td>
                <td class="col-monto" style="text-align:right;">${formatCurrency(item.monto)}</td>
                <td class="col-concepto">${item.concepto || '-'}</td>
                <td class="col-tipo_ingreso">${item.tipo_ingreso || '-'}</td>
                <td class="col-estatus"><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
                <td style="position:sticky;right:0;background:white;">
                    <div class="action-icons">
                        <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                        <i class="fas fa-edit" onclick="editarDeposito(${item.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarDeposito(${item.id})" title="Eliminar"></i>
                        ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarDeposito(${item.id})" title="Aplicar"></i>` : ''}
                        <i class="fas fa-file-pdf" onclick="generarPDF(${item.id})" title="Generar PDF"></i>
                    </div>
                </td>
            `;
            tablaBody.appendChild(row);
        });
        calcularTotales(datos);
        actualizarPaginacion(datos.length);
    }
}

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    container.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
        document.getElementById('textoAgrupar').style.display = 'inline';
    } else {
        document.getElementById('textoAgrupar').style.display = 'none';
        columnasAgrupadas.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${col.charAt(0).toUpperCase() + col.slice(1)}<span class="remover" data-columna="${col}">&times;</span>`;
            container.appendChild(chip);
        });
    }
    expandedGroups.clear();
    cargarTabla(datosOriginales);
}

function setupDragAndDrop() {
    document.querySelectorAll('th[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', e => e.dataTransfer.setData('text/plain', th.dataset.columna));
        th.addEventListener('dragend', e => th.style.opacity = '1');
    });
    const grupoAgrupacion = document.getElementById('grupoAgrupacion');
    if (grupoAgrupacion) {
        grupoAgrupacion.addEventListener('dragover', e => e.preventDefault());
        grupoAgrupacion.addEventListener('drop', e => {
            e.preventDefault();
            const columna = e.dataTransfer.getData('text/plain');
            if (columna && !columnasAgrupadas.includes(columna)) {
                columnasAgrupadas.push(columna);
                actualizarGrupoColumnas();
            }
        });
    }
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            columnasAgrupadas = columnasAgrupadas.filter(c => c !== e.target.dataset.columna);
            actualizarGrupoColumnas();
        }
    });
}

document.addEventListener('click', e => {
    const filaGrupo = e.target.closest('.fila-grupo');
    if (filaGrupo) {
        const grupoId = filaGrupo.dataset.grupoId;
        if (expandedGroups.has(grupoId)) expandedGroups.delete(grupoId);
        else expandedGroups.add(grupoId);
        cargarTabla(datosOriginales);
    }
});

// ============================================
// FUNCIONES DEL MODAL - DEPÓSITOS
// ============================================
function abrirModalDeposito() {
    debugLog('Abriendo modal de depósito');
    
    const modal = document.getElementById('modalDeposito');
    if (!modal) {
        console.error('Modal no encontrado');
        mostrarNotificacion('Error: Modal no encontrado', 'danger');
        return;
    }
    
    document.getElementById('deposito_id').value = '';
    document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('tipo_ingreso_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('concepto').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    document.getElementById('facturas_aplicadas_json').value = '[]';
    
    const clienteSelect = document.getElementById('cliente_select');
    if (clienteSelect) {
        clienteSelect.value = '';
        if ($(clienteSelect).data('select2')) {
            $(clienteSelect).val('').trigger('change');
        }
    }
    document.getElementById('cliente_nombre').value = '';
    document.getElementById('cliente_rfc').value = '';
    document.getElementById('codigo_sat_id').value = '';
    
    const infoSpan = document.getElementById('codigo_sat_info');
    if (infoSpan) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el código SAT que corresponde a este ingreso';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
    }
    
    const previewBody = document.getElementById('tablaFacturasPreviewBody');
    if (previewBody) {
        previewBody.innerHTML = 
            `<tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                Selecciona un cliente para ver sus facturas
            </td></tr>`;
    }
    
    ['appTotalPago', 'appTotalAplicado', 'appDiferencia', 'summaryVencido', 'summaryPorVencer', 'summaryTotal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = '$0.00';
    });
    
    const resumenDiv = document.getElementById('resumenFacturasAplicadas');
    if (resumenDiv) resumenDiv.style.display = 'none';
    
    // Reiniciar variables
    facturasCliente = [];
    aplicacionesFacturas = {};
    montoDepositoActual = 0;
    
    new bootstrap.Modal(modal).show();
}

function cargarCliente() {
    const clienteSelect = document.getElementById('cliente_select');
    if (!clienteSelect) return;
    
    const selectedOption = clienteSelect.options[clienteSelect.selectedIndex];
    
    if (!clienteSelect.value) {
        document.getElementById('cliente_nombre').value = '';
        document.getElementById('cliente_rfc').value = '';
        return;
    }
    
    const nombre = selectedOption?.getAttribute('data-nombre') || '';
    const rfc = selectedOption?.getAttribute('data-rfc') || '';
    
    document.getElementById('cliente_nombre').value = nombre;
    document.getElementById('cliente_rfc').value = rfc;
}

function editarDeposito(id) {
    debugLog('Editando depósito ID: ' + id);
    
    fetch(`/admin/api/depositos/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(deposito => {
        debugLog('Datos del depósito:', deposito);
        
        document.getElementById('deposito_id').value = deposito.id;
        document.getElementById('fecha').value = deposito.fecha;
        document.getElementById('cuenta_bancaria_id').value = deposito.cuenta_bancaria_id;
        document.getElementById('proyecto_id').value = deposito.proyecto_id || '';
        document.getElementById('tipo_ingreso_id').value = deposito.tipo_ingreso_id;
        document.getElementById('monto').value = deposito.monto;
        document.getElementById('referencia').value = deposito.referencia || '';
        document.getElementById('concepto').value = deposito.concepto;
        document.getElementById('observaciones').value = deposito.observaciones || '';
        document.getElementById('aplicar_ahora').checked = false;
        document.getElementById('codigo_sat_id').value = deposito.codigo_sat_id || '';
        
        // Cargar cliente si existe
        if (deposito.contacto_id) {
            const clienteSelect = document.getElementById('cliente_select');
            $(clienteSelect).val(deposito.contacto_id).trigger('change');
            cargarCliente();
        }
        
        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOption = codigoSatSelect.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOption && selectedOption.value) {
            const codigo = selectedOption.getAttribute('data-codigo') || '';
            const nombre = selectedOption.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT seleccionado: ${codigo} - ${nombre}`;
            infoSpan.classList.remove('text-muted');
            infoSpan.classList.add('text-success');
        }
        
        // Cargar facturas aplicadas si existen
        if (deposito.facturas_aplicadas && Object.keys(deposito.facturas_aplicadas).length > 0) {
            const resumenDiv = document.getElementById('resumenFacturasAplicadas');
            if (resumenDiv) {
                resumenDiv.style.display = 'block';
                const totalAplicado = Object.values(deposito.facturas_aplicadas).reduce((a, b) => a + parseFloat(b), 0);
                document.getElementById('resumenFacturasTexto').innerHTML = 
                    `<strong>${Object.keys(deposito.facturas_aplicadas).length} factura(s) aplicadas. Total: ${formatCurrency(totalAplicado)}</strong>`;
            }
            
            const facturasArray = Object.entries(deposito.facturas_aplicadas).map(([id, monto]) => ({
                factura_id: parseInt(id),
                monto: parseFloat(monto)
            }));
            document.getElementById('facturas_aplicadas_json').value = JSON.stringify(facturasArray);
        }
        
        const modal = document.getElementById('modalDeposito');
        if (modal) {
            new bootstrap.Modal(modal).show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar datos para editar', 'danger');
    });
}

function guardarDeposito() {
    const id = document.getElementById('deposito_id').value;
    const codigoSatId = document.getElementById('codigo_sat_id').value;
    
    if (!codigoSatId) {
        mostrarNotificacion('Por favor seleccione un código SAT', 'warning');
        return;
    }
    
    let facturasAplicadas = [];
    try {
        const jsonValue = document.getElementById('facturas_aplicadas_json')?.value;
        if (jsonValue && jsonValue !== '[]') {
            facturasAplicadas = JSON.parse(jsonValue);
        }
    } catch (e) {
        facturasAplicadas = [];
    }
    
    const data = {
        fecha: document.getElementById('fecha').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        tipo_ingreso_id: document.getElementById('tipo_ingreso_id').value,
        monto: document.getElementById('monto').value,
        referencia: document.getElementById('referencia').value,
        concepto: document.getElementById('concepto').value,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora').checked,
        codigo_sat_id: codigoSatId,
        cliente_id: document.getElementById('cliente_select').value || null,
        facturas_aplicadas: facturasAplicadas
    };
    
    const url = id ? `/admin/api/depositos/${id}` : '/admin/api/depositos';
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
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
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
                const modal = document.getElementById('modalDeposito');
                if (modal) {
                    bootstrap.Modal.getInstance(modal)?.hide();
                }
                cargarDepositos();
            } else {
                mostrarNotificacion(result.message || 'Error al guardar', 'danger');
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            console.error('Error:', error);
            mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
        });
    }
}

function eliminarDeposito(id) {
    if (confirm('¿Eliminar este depósito?')) {
        fetch(`/admin/api/depositos/${id}`, {
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
                cargarDepositos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al eliminar', 'danger'));
    }
}

function aplicarDeposito(id) {
    if (confirm('¿Aplicar este depósito? Se creará un movimiento bancario.')) {
        fetch(`/admin/api/depositos/${id}/aplicar`, {
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
                cargarDepositos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        })
        .catch(error => mostrarNotificacion('Error al aplicar', 'danger'));
    }
}

// ============================================
// VER DETALLE DEL DEPÓSITO
// ============================================
function verDetalle(id) {
    fetch(`/admin/api/depositos/${id}/detalle`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            const d = result.data.deposito;
            const facturas = result.data.facturas || [];
            const mov = result.data.movimiento_bancario;
            
            let facturasHtml = '';
            if (facturas.length > 0) {
                facturasHtml = `
                    <h6 style="margin-top: 20px; color: #083CAE; font-weight: 600;">
                        <i class="fas fa-receipt"></i> Facturas Aplicadas (${facturas.length})
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size: 12px; margin-top: 10px;">
                            <thead style="background: #083CAE; color: white;">
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha</th>
                                    <th>Vencimiento</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Saldo</th>
                                    <th class="text-end">Aplicado</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${facturas.map(f => `
                                    <tr>
                                        <td>${f.folio || 'F-' + f.factura_id}</td>
                                        <td>${formatDate(f.fecha)}</td>
                                        <td>${formatDate(f.fecha_vencimiento)}</td>
                                        <td class="text-end">${formatCurrency(f.total)}</td>
                                        <td class="text-end">${formatCurrency(f.saldo_disponible)}</td>
                                        <td class="text-end" style="color: #28A745; font-weight: 600;">${formatCurrency(f.monto_aplicado)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            }
            
            const modalHtml = `
                <div class="modal fade" id="modalDetalleDeposito" tabindex="-1" style="z-index: 100002;">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content" style="border-radius: 16px; border: none;">
                            <div class="modal-header" style="background: #083CAE; color: white; border-radius: 16px 16px 0 0; padding: 20px 24px;">
                                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalle del Depósito ${d.folio}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 24px;">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Folio</small>
                                            <strong style="font-size: 16px;">${d.folio}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Estatus</small>
                                            <span class="badge ${getBadgeClass(d.estatus)}">${getEstatusTexto(d.estatus)}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Fecha</small>
                                            <strong>${formatDate(d.fecha)}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #E8F0FE; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Monto</small>
                                            <strong style="font-size: 22px; color: #083CAE;">${formatCurrency(d.monto)}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Monto Aplicado</small>
                                            <strong style="font-size: 18px; color: #28A745;">${formatCurrency(d.monto_aplicado)}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Banco / Cuenta</small>
                                            <strong>${d.cuenta_bancaria?.banco || 'N/A'}</strong>
                                            <small class="text-muted d-block">${d.cuenta_bancaria?.numero_cuenta || 'N/A'}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Cliente</small>
                                            <strong>${d.contacto?.razon_social || 'N/A'}</strong>
                                            <small class="text-muted d-block">RFC: ${d.contacto?.rfc || 'N/A'}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Tipo Ingreso</small>
                                            <strong>${d.tipo_ingreso?.nombre || 'N/A'}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Código SAT</small>
                                            <strong>${d.codigo_sat?.codigo_agrupador || 'N/A'}</strong>
                                            <small class="text-muted d-block">${d.codigo_sat?.nombre_cuenta || ''}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Proyecto</small>
                                            <strong>${d.proyecto?.nombre || 'N/A'}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Concepto</small>
                                            <strong>${d.concepto}</strong>
                                        </div>
                                    </div>
                                    ${d.observaciones ? `
                                    <div class="col-12">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Observaciones</small>
                                            <span>${d.observaciones}</span>
                                        </div>
                                    </div>
                                    ` : ''}
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Referencia</small>
                                            <strong>${d.referencia || 'N/A'}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3" style="background: #F5F7FB; border-radius: 10px;">
                                            <small class="text-muted d-block" style="font-size: 11px; text-transform: uppercase; font-weight: 600;">Creado por</small>
                                            <strong>${d.creador?.name || 'Sistema'}</strong>
                                        </div>
                                    </div>
                                </div>
                                ${facturasHtml}
                                ${mov ? `
                                    <div class="alert alert-info mt-3" style="font-size: 13px; border-radius: 10px;">
                                        <i class="fas fa-exchange-alt"></i> <strong>Movimiento Bancario Asociado:</strong> 
                                        ID #${mov.id} - ${formatCurrency(mov.monto)} - ${formatDate(mov.fecha)}
                                    </div>
                                ` : ''}
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #E9ECF0;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="generarPDF(${d.id})">
                                    <i class="fas fa-file-pdf"></i> Generar PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('modalDetalleDeposito')?.remove();
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            new bootstrap.Modal(document.getElementById('modalDetalleDeposito')).show();
        } else {
            mostrarNotificacion(result.message || 'Error al cargar detalle', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al cargar detalle: ' + error.message, 'danger');
    });
}

// ============================================
// GENERAR PDF
// ============================================
function generarPDF(id) {
    mostrarNotificacion('Generando PDF...', 'info');
    
    fetch(`/admin/api/depositos/${id}/pdf`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            const d = result.data;
            
            let facturasHtml = '';
            if (d.facturas && d.facturas.length > 0) {
                const totalAplicado = d.facturas.reduce((sum, f) => sum + parseFloat(f.monto_aplicado || 0), 0);
                facturasHtml = `
                    <h3 style="margin-top: 30px; color: #083CAE; border-bottom: 2px solid #083CAE; padding-bottom: 8px;">Facturas Aplicadas</h3>
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 15px;">
                        <thead>
                            <tr style="background: #083CAE; color: white;">
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Folio</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Fecha</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Vencimiento</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Saldo</th>
                                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Aplicado</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${d.facturas.map(f => `
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;">${f.folio || 'F-' + f.factura_id}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">${formatDate(f.fecha)}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">${formatDate(f.fecha_vencimiento)}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">${formatCurrency(f.total)}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">${formatCurrency(f.saldo_disponible)}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right; color: #28A745; font-weight: 600;">${formatCurrency(f.monto_aplicado)}</td>
                                </tr>
                            `).join('')}
                            <tr style="background: #F5F7FB; font-weight: bold;">
                                <td colspan="5" style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total Aplicado:</td>
                                <td style="padding: 10px; border: 1px solid #ddd; text-align: right; color: #28A745;">${formatCurrency(totalAplicado)}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
            }
            
            const ventana = window.open('', '_blank');
            ventana.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Depósito ${d.folio}</title>
                    <style>
                        * { box-sizing: border-box; }
                        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 40px; color: #333; margin: 0; }
                        .header { text-align: center; border-bottom: 3px solid #083CAE; padding-bottom: 20px; margin-bottom: 30px; }
                        .header h1 { color: #083CAE; margin: 0; font-size: 28px; }
                        .header p { color: #6B7A8F; margin: 5px 0 0 0; }
                        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
                        .info-item { padding: 12px; background: #F5F7FB; border-radius: 8px; border-left: 3px solid #083CAE; }
                        .info-label { font-size: 11px; color: #6B7A8F; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
                        .info-value { font-size: 14px; font-weight: 600; color: #1A2332; margin-top: 4px; }
                        .monto-total { font-size: 32px; font-weight: 700; color: #083CAE; text-align: center; padding: 24px; background: #E8F0FE; border-radius: 10px; margin: 20px 0; }
                        .footer { margin-top: 50px; text-align: center; font-size: 11px; color: #8A9AAE; border-top: 1px solid #ddd; padding-top: 15px; }
                        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
                        .badge-aplicado { background: #28a745; color: white; }
                        .badge-pendiente { background: #fd7e14; color: white; }
                        @media print {
                            body { padding: 20px; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Comprobante de Depósito</h1>
                        <p>Folio: <strong>${d.folio}</strong></p>
                    </div>
                    
                    <div class="monto-total">
                        ${d.moneda || 'MXN'} ${formatCurrency(d.monto)}
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Fecha</div>
                            <div class="info-value">${formatDate(d.fecha)}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estatus</div>
                            <div class="info-value"><span class="badge badge-${d.estatus}">${d.estatus.toUpperCase()}</span></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Banco</div>
                            <div class="info-value">${d.banco}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Cuenta</div>
                            <div class="info-value">${d.numero_cuenta}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Cliente</div>
                            <div class="info-value">${d.cliente}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">RFC</div>
                            <div class="info-value">${d.rfc}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tipo de Ingreso</div>
                            <div class="info-value">${d.tipo_ingreso}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Código SAT</div>
                            <div class="info-value">${d.codigo_sat}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Proyecto</div>
                            <div class="info-value">${d.proyecto}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Referencia</div>
                            <div class="info-value">${d.referencia || 'N/A'}</div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div class="info-label">Concepto</div>
                        <div style="padding: 12px; background: #F5F7FB; border-radius: 8px; margin-top: 6px; border-left: 3px solid #083CAE;">${d.concepto}</div>
                    </div>
                    
                    ${d.observaciones ? `
                    <div style="margin-bottom: 20px;">
                        <div class="info-label">Observaciones</div>
                        <div style="padding: 12px; background: #F5F7FB; border-radius: 8px; margin-top: 6px;">${d.observaciones}</div>
                    </div>
                    ` : ''}
                    
                    ${facturasHtml}
                    
                    <div class="footer">
                        Generado por <strong>${d.creado_por}</strong> el ${formatDate(d.fecha_creacion)}<br>
                        Este documento es un comprobante interno de depósito.
                    </div>
                    
                    <div class="no-print" style="text-align: center; margin-top: 30px;">
                        <button onclick="window.print()" style="background: #083CAE; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                            🖨️ Imprimir / Guardar PDF
                        </button>
                    </div>
                </body>
                </html>
            `);
            ventana.document.close();
            
            setTimeout(() => {
                ventana.focus();
            }, 500);
        } else {
            mostrarNotificacion(result.message || 'Error al generar PDF', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al generar PDF: ' + error.message, 'danger');
    });
}

function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '999999';
    alertDiv.style.minWidth = '300px';
    alertDiv.style.maxWidth = '500px';
    alertDiv.style.whiteSpace = 'pre-line';
    alertDiv.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}

function exportarExcel() {
    const tabla = document.getElementById('tablaDepositos').cloneNode(true);
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tabla.outerHTML);
    link.download = 'depositos_' + new Date().toISOString().split('T')[0] + '.xls';
    link.click();
}

// ============================================
// APLICACIÓN A FACTURAS DE CLIENTE
// ============================================
function abrirAplicacionFacturas() {
    const clienteSelect = document.getElementById('cliente_select');
    if (!clienteSelect || !clienteSelect.value) {
        mostrarNotificacion('Por favor seleccione un cliente primero', 'warning');
        return;
    }
    
    const selectedOption = clienteSelect.options[clienteSelect.selectedIndex];
    const clienteId = clienteSelect.value;
    const monto = parseFloat(document.getElementById('monto')?.value) || 0;
    
    if (monto <= 0) {
        mostrarNotificacion('Por favor ingrese un monto válido', 'warning');
        return;
    }
    
    montoDepositoActual = monto;
    aplicacionesFacturas = {};
    clienteSeleccionadoId = clienteId;
    
    const montoDepositoFacturas = document.getElementById('montoDepositoFacturas');
    const totalAplicadoFacturas = document.getElementById('totalAplicadoFacturas');
    const diferenciaFacturas = document.getElementById('diferenciaFacturas');
    
    if (montoDepositoFacturas) montoDepositoFacturas.textContent = formatCurrency(monto);
    if (totalAplicadoFacturas) totalAplicadoFacturas.textContent = '$0.00';
    if (diferenciaFacturas) {
        diferenciaFacturas.textContent = formatCurrency(monto);
        diferenciaFacturas.className = 'summary-value';
    }
    
    const tablaBody = document.getElementById('tablaFacturasBody');
    if (tablaBody) {
        tablaBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Cargando facturas...</td></tr>';
    }
    
    const modal = document.getElementById('modalAplicarFacturas');
    if (modal) {
        new bootstrap.Modal(modal).show();
    }
    
    cargarFacturasCliente(clienteId);
}

function cargarFacturasCliente(clienteId) {
    if (!clienteId) {
        const tablaBody = document.getElementById('tablaFacturasBody');
        if (tablaBody) {
            tablaBody.innerHTML = '<tr><td colspan="8" style="text-align: center;">Seleccione un cliente para ver sus facturas</td></tr>';
        }
        return;
    }
    
    fetch(`/admin/api/depositos/clientes/${clienteId}/facturas-pendientes`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            facturasCliente = result.data || [];
            const totales = result.totales || { vencido: 0, por_vencer: 0, total: 0 };
            
            ['saldoVencido', 'summaryVencido'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = formatCurrency(totales.vencido);
            });
            ['saldoPorVencer', 'summaryPorVencer'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = formatCurrency(totales.por_vencer);
            });
            ['saldoTotal', 'summaryTotal'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = formatCurrency(totales.total);
            });
            
            renderizarPreviewFacturas();
            renderizarTablaFacturas();
        } else {
            mostrarNotificacion(result.message || 'Error al cargar facturas', 'danger');
        }
    })
    .catch(error => {
        console.error('Error cargando facturas:', error);
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
    
    if (!facturasCliente || facturasCliente.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
            <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
            Este cliente no tiene facturas pendientes
        </td></tr>`;
        return;
    }
    
    let html = '';
    facturasCliente.slice(0, 5).forEach((factura, index) => {
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
    
    if (facturasCliente.length > 5) {
        html += `<tr><td colspan="7" style="text-align: center; color: #8A9AAE; font-size: 12px; padding: 10px;">
            <i class="fas fa-ellipsis-h"></i> Y ${facturasCliente.length - 5} factura(s) más. Haz clic en "Seleccionar Facturas" para ver todas.
        </td></tr>`;
    }
    
    tbody.innerHTML = html;
}

function renderizarTablaFacturas() {
    const tbody = document.getElementById('tablaFacturasBody');
    if (!tbody) return;
    
    if (!facturasCliente || facturasCliente.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: #6c757d;"><i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>Este cliente no tiene facturas pendientes</td></tr>';
        return;
    }
    
    let html = '';
    let totalSaldo = 0;
    let totalAplicado = 0;
    
    facturasCliente.forEach((factura, index) => {
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
    
    const diffFinal = montoDepositoActual - totalAplicado;
    if (diferenciaFacturas) {
        diferenciaFacturas.textContent = formatCurrency(diffFinal);
        if (Math.abs(diffFinal) < 0.01) {
            diferenciaFacturas.className = 'summary-value summary-value-success';
        } else if (diffFinal > 0) {
            diferenciaFacturas.className = 'summary-value summary-value-warning';
        } else {
            diferenciaFacturas.className = 'summary-value summary-value-danger';
        }
    }
    
    if (totalAplicadoFacturas) totalAplicadoFacturas.textContent = formatCurrency(totalAplicado);
    if (appTotalAplicado) appTotalAplicado.textContent = formatCurrency(totalAplicado);
    if (appDiferencia) appDiferencia.textContent = formatCurrency(diffFinal);
    
    renderizarPreviewFacturas();
}

function actualizarMontoAplicar(facturaId, valor) {
    const monto = parseFloat(valor) || 0;
    const factura = facturasCliente.find(f => f.id === facturaId);
    
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
    const factura = facturasCliente.find(f => f.id === facturaId);
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
    if (!facturasCliente || facturasCliente.length === 0) {
        mostrarNotificacion('No hay facturas para aplicar', 'warning');
        return;
    }
    
    aplicacionesFacturas = {};
    
    const facturasOrdenadas = [...facturasCliente].sort((a, b) => {
        if (!a.fecha_vencimiento) return 1;
        if (!b.fecha_vencimiento) return -1;
        return new Date(a.fecha_vencimiento) - new Date(b.fecha_vencimiento);
    });
    
    let montoRestante = montoDepositoActual;
    
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
    if (!facturasCliente || facturasCliente.length === 0) {
        mostrarNotificacion('No hay facturas para aplicar', 'warning');
        return;
    }
    
    aplicacionesFacturas = {};
    
    let montoRestante = montoDepositoActual;
    const facturasOrdenadas = [...facturasCliente].sort((a, b) => {
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
    
    const facturasJsonInput = document.getElementById('facturas_aplicadas_json');
    if (facturasJsonInput) {
        facturasJsonInput.value = JSON.stringify(facturasAplicadas);
    }
    
    const resumenDiv = document.getElementById('resumenFacturasAplicadas');
    if (resumenDiv) {
        resumenDiv.style.display = 'block';
        
        const resumenTexto = facturasAplicadas.map(f => {
            const factura = facturasCliente.find(fc => fc.id === f.factura_id);
            return `${factura?.folio || 'F-' + f.factura_id}: ${formatCurrency(f.monto)}`;
        }).join('<br>');
        
        document.getElementById('resumenFacturasTexto').innerHTML = resumenTexto + 
            `<br><strong>Total aplicado: ${formatCurrency(totalAplicado)}</strong>`;
    }
    
    const appTotalAplicado = document.getElementById('appTotalAplicado');
    const appDiferencia = document.getElementById('appDiferencia');
    if (appTotalAplicado) appTotalAplicado.textContent = formatCurrency(totalAplicado);
    if (appDiferencia) appDiferencia.textContent = formatCurrency(montoDepositoActual - totalAplicado);
    
    const modal = document.getElementById('modalAplicarFacturas');
    if (modal) {
        bootstrap.Modal.getInstance(modal)?.hide();
    }
    
    mostrarNotificacion(`Se aplicarán ${formatCurrency(totalAplicado)} a ${facturasAplicadas.length} factura(s)`, 'success');
}

// ============================================
// CAMBIO DE FILAS POR PÁGINA
// ============================================
function cambiarFilasPorPagina(cantidad) {
    rowsPerPage = parseInt(cantidad);
    currentPage = 1;
    cargarTabla(datosOriginales);
}

// ============================================
// EVENT LISTENERS
// ============================================
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosOriginales); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if(currentPage > 1) { currentPage--; cargarTabla(datosOriginales); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => { 
    const total = Math.ceil(datosOriginales.length / rowsPerPage); 
    if(currentPage < total) { currentPage++; cargarTabla(datosOriginales); } 
});
document.getElementById('btnUltima')?.addEventListener('click', () => { 
    currentPage = Math.ceil(datosOriginales.length / rowsPerPage) || 1; 
    cargarTabla(datosOriginales); 
});

document.getElementById('buscador')?.addEventListener('input', e => {
    const busqueda = e.target.value.toLowerCase();
    const filtrados = datosOriginales.filter(item => 
        item.folio?.toLowerCase().includes(busqueda) ||
        item.banco?.toLowerCase().includes(busqueda) ||
        item.concepto?.toLowerCase().includes(busqueda) ||
        item.estatus?.toLowerCase().includes(busqueda)
    );
    currentPage = 1;
    cargarTabla(filtrados);
});

document.getElementById('fechaInicio')?.addEventListener('change', () => cargarDepositos());
document.getElementById('fechaFin')?.addEventListener('change', () => cargarDepositos());
document.getElementById('btnCrearFiltro')?.addEventListener('click', () => alert('Filtro - En desarrollo'));
document.getElementById('btnColumnas')?.addEventListener('click', abrirModalColumnas);

document.getElementById('monto')?.addEventListener('input', function() {
    const monto = parseFloat(this.value) || 0;
    const appTotalPago = document.getElementById('appTotalPago');
    const montoDepositoFacturas = document.getElementById('montoDepositoFacturas');
    if (appTotalPago) appTotalPago.textContent = formatCurrency(monto);
    if (montoDepositoFacturas) montoDepositoFacturas.textContent = formatCurrency(monto);
    montoDepositoActual = monto;
});

document.addEventListener('DOMContentLoaded', () => {
    setupDragAndDrop();
    cargarDepositos();
});

document.getElementById('cliente_select')?.addEventListener('change', cargarCliente);
</script>
@endsection