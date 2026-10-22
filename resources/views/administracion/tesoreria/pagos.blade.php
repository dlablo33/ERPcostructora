@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Pagos
                </h2>
            </div>

            <div class="card-body p-4">

                {{-- ✅ FIX Ticket #1: Cards de resumen --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #2378e1 0%, #083CAE 100%); color: white;">
                            <div class="card-body d-flex justify-content-between align-items-center p-4">
                                <div>
                                    <div style="font-size: 12px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px;">Total Registros</div>
                                    <div style="font-size: 28px; font-weight: 700; margin-top: 4px;" id="statTotal">{{ $estadisticas['total'] ?? 0 }}</div>
                                </div>
                                <i class="fas fa-list" style="font-size: 36px; opacity: 0.35;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white;">
                            <div class="card-body d-flex justify-content-between align-items-center p-4">
                                <div>
                                    <div style="font-size: 12px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px;">Completados</div>
                                    <div style="font-size: 28px; font-weight: 700; margin-top: 4px;" id="statCompletados">{{ $estadisticas['completados'] ?? 0 }}</div>
                                </div>
                                <i class="fas fa-check-circle" style="font-size: 36px; opacity: 0.35;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fd7e14 0%, #c6610a 100%); color: white;">
                            <div class="card-body d-flex justify-content-between align-items-center p-4">
                                <div>
                                    <div style="font-size: 12px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px;">Pendientes</div>
                                    <div style="font-size: 28px; font-weight: 700; margin-top: 4px;" id="statPendientes">{{ $estadisticas['pendientes'] ?? 0 }}</div>
                                </div>
                                <i class="fas fa-clock" style="font-size: 36px; opacity: 0.35;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #6c757d 0%, #343a40 100%); color: white;">
                            <div class="card-body d-flex justify-content-between align-items-center p-4">
                                <div>
                                    <div style="font-size: 12px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px;">Monto Total</div>
                                    <div style="font-size: 24px; font-weight: 700; margin-top: 4px;" id="statMonto">${{ number_format($estadisticas['total_monto'] ?? 0, 2) }}</div>
                                </div>
                                <i class="fas fa-dollar-sign" style="font-size: 36px; opacity: 0.35;"></i>
                            </div>
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
                        <div>
                            <label style="font-size: 11px; color: #6c757d; display: block;">Desde</label>
                            <input type="date" id="fechaInicio" class="form-control" style="width: 140px;">
                        </div>
                        <div>
                            <label style="font-size: 11px; color: #6c757d; display: block;">Hasta</label>
                            <input type="date" id="fechaFin" class="form-control" style="width: 140px;">
                        </div>
                        <div style="padding-top: 18px;">
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px;" title="Nuevo Pago"><i class="fas fa-plus" style="color: #2378e1;"></i></button>
                        </div>
                        <div style="padding-top: 18px;">
                            <button id="btnLayout" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; color: #083CAE;"><i class="fas fa-file-invoice"></i> Generar Layout</button>
                        </div>
                        <div style="padding-top: 18px;">
                            <button id="btnExcel" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px;"><i class="fas fa-file-excel" style="color: #2378e1;"></i> Excel</button>
                        </div>
                        <div style="padding-top: 18px;">
                            <button id="btnLimpiarFiltros" style="background-color: white; border: 1px solid #dc3545; border-radius: 4px; padding: 8px 12px; color: #dc3545;" title="Limpiar todos los filtros"><i class="fas fa-times-circle"></i> Limpiar</button>
                        </div>
                        <div style="position: relative; padding-top: 18px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 60%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; width: 220px;">
                        </div>
                    </div>
                </div>

                <!-- Contador de seleccionados -->
                <div id="seleccionInfo" style="display: none; background-color: #e8f0fe; border: 1px solid #2378e1; border-radius: 6px; padding: 8px 12px; margin-bottom: 10px; font-size: 13px; color: #083CAE;">
                    <i class="fas fa-check-square"></i> <strong id="seleccionados">0</strong> pago(s) seleccionado(s) — <a href="javascript:void(0)" onclick="limpiarSeleccion()" style="color: #083CAE; text-decoration: underline;">Limpiar selección</a>
                </div>

                <!-- Tabla de Pagos CON FILTROS POR COLUMNA -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPagos" style="width: 100%; font-size: 12px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th style="width:30px; text-align:center;">
                                    <input type="checkbox" id="chkTodos" title="Seleccionar todos">
                                </th>
                                <th draggable="true" data-columna="folio">Folio</th>
                                <th draggable="true" data-columna="fecha_pago">Fecha</th>
                                <th draggable="true" data-columna="proveedor">Proveedor</th>
                                <th draggable="true" data-columna="concepto">Concepto</th>
                                <th draggable="true" data-columna="monto">Monto</th>
                                <th draggable="true" data-columna="metodo_pago">Método Pago</th>
                                <th draggable="true" data-columna="estatus">Estatus</th>
                                <th draggable="true" data-columna="factura">Factura</th>
                                <th style="position: sticky; right: 0; background-color: #2378e1;">Acciones</th>
                            </tr>
                            <tr id="filtrosFila" style="background-color: #f0f4ff;">
                                <td style="background-color: #f0f4ff;"></td>


                                </td>
                                <td style="background-color: #f0f4ff; padding: 4px;">
                                </td>
                                <td style="background-color: #f0f4ff; padding: 4px;"></td>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="10" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="5" style="text-align: center;">Totales:</td>
                                <td style="text-align: right;" id="sumMonto">$0.00</td>
                                <td colspan="4"></td>
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

<!-- ============================= -->
<!-- Modal para Pago (Crear/Editar) -->
<!-- ============================= -->
<div class="modal fade" id="modalPago" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-money-bill-wave"></i> <span id="modalPagoTitulo">Nuevo Pago</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPago">
                    <input type="hidden" id="pago_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fecha Pago <span class="text-danger">*</span></label>
                            <input type="date" id="fecha_pago" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Bancaria <span class="text-danger">*</span></label>
                            <select id="cuenta_bancaria_id" class="form-control" required>
                                <option value="">Seleccionar cuenta...</option>
                                @foreach($cuentasBancarias ?? [] as $cuenta)
                                    <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Proveedor</label>
                            <select id="proveedor_id" class="form-control">
                                <option value="">Seleccionar proveedor...</option>
                                @foreach($proveedores ?? [] as $proveedor)
                                    <option value="{{ $proveedor->id }}"
                                        data-codigo-sat-id="{{ $proveedor->codigo_sat_default_id }}"
                                        data-codigo-sat-nombre="{{ $proveedor->codigoSatDefault?->nombre_cuenta ?? '' }}">
                                        {{ $proveedor->nombre }} - {{ $proveedor->rfc }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="abrirModalProveedor()" style="font-size: 11px;">+ Nuevo Proveedor</button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Proyecto</label>
                            <select id="proyecto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Monto <span class="text-danger">*</span></label>
                            <input type="number" id="monto" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Moneda <span class="text-danger">*</span></label>
                            <select id="moneda_id" class="form-control" required>
                                <option value="">Seleccionar moneda...</option>
                                @foreach($monedas ?? [] as $moneda)
                                    <option value="{{ $moneda->id }}">{{ $moneda->nombre }} ({{ $moneda->simbolo }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tipo de Egreso <span class="text-danger">*</span></label>
                            <select id="tipo_egreso_id" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                @foreach($tiposEgreso ?? [] as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Categoría de Gasto</label>
                            <select id="categoria_gasto_id" class="form-control">
                                <option value="">Primero seleccione un tipo de egreso</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Método de Pago <span class="text-danger">*</span></label>
                            <select id="metodo_pago_id" class="form-control" required>
                                <option value="">Seleccionar método...</option>
                                @foreach($metodosPago ?? [] as $metodo)
                                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Número de Factura</label>
                            <select id="factura" class="form-control">
                                <option value="">Sin factura / Manual</option>
                            </select>
                            <small class="form-text text-muted" id="factura_info">
                                <i class="fas fa-info-circle"></i> Selecciona un proveedor para cargar sus facturas
                            </small>
                        </div>
                    </div>

                    <div class="mb-3" id="factura_manual_wrap" style="display:none;">
                        <label>Factura (captura manual)</label>
                        <input type="text" id="factura_manual" class="form-control" placeholder="Ej: A-12345">
                    </div>

                    {{-- ✅ FIX Ticket #5: Relacionar factura (UUID, monto, fecha) --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>UUID Factura (CFDI)</label>
                            <input type="text" id="factura_uuid" class="form-control" placeholder="Ej: 12345678-ABCD-...">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Monto Factura</label>
                            <input type="number" id="factura_monto" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fecha Factura</label>
                            <input type="date" id="factura_fecha" class="form-control">
                        </div>
                    </div>

                    <!-- Código SAT -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Código SAT</label>
                            <select id="codigo_sat_id" class="form-control">
                                <option value="">Seleccionar código SAT...</option>
                                @foreach($codigosSatGastos ?? [] as $codigo)
                                    <option value="{{ $codigo->id }}"
                                        data-codigo="{{ $codigo->codigo_agrupador }}"
                                        data-nombre="{{ $codigo->nombre_cuenta }}"
                                        data-tipo="{{ $codigo->tipo }}">
                                        {{ $codigo->codigo_agrupador }} - {{ $codigo->nombre_cuenta }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted" id="codigo_sat_info">
                                <i class="fas fa-info-circle"></i> Al seleccionar un proveedor se cargará el código sugerido
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Referencia</label>
                            <input type="text" id="referencia" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Referencia Bancaria</label>
                            <input type="text" id="referencia_bancaria" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Concepto <span class="text-danger">*</span></label>
                        <textarea id="concepto" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="aplicar_ahora" class="form-check-input" checked>
                        <label class="form-check-label">Aplicar pago inmediatamente (actualizar saldo)</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnGuardarPago" class="btn btn-primary" onclick="guardarPago()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================= -->
<!-- Modal para Proveedor (rápido) -->
<!-- ============================= -->
<div class="modal fade" id="modalProveedor" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-truck"></i> Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formProveedor">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="prov_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>RFC</label>
                        <input type="text" id="prov_rfc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="prov_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" id="prov_telefono" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Contacto</label>
                        <input type="text" id="prov_contacto" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProveedorRapido()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ FIX Ticket #3: Modal para ver detalle --}}
<div class="modal fade" id="modalVerPago" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle del Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="verPagoBody">
                <div class="text-center text-muted">
                    <i class="fas fa-spinner fa-spin"></i> Cargando...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================= -->
<!-- Modal Generar Layout -->
<!-- ============================= -->
<div class="modal fade" id="modalLayout" tabindex="-1" style="z-index: 99999 !important;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-file-invoice"></i> Generar Layout de Pagos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" style="font-size: 13px;">
                    <i class="fas fa-info-circle"></i> Se generará un layout con los <strong id="layoutNumPagos">0</strong> pago(s) seleccionado(s).
                </div>
                <div class="mb-3">
                    <label>Fecha del Layout <span class="text-danger">*</span></label>
                    <input type="date" id="layout_fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label>Cuenta Bancaria <span class="text-danger">*</span></label>
                    <select id="layout_cuenta_bancaria_id" class="form-control" required>
                        <option value="">Seleccionar cuenta...</option>
                        @foreach($cuentasBancarias ?? [] as $cuenta)
                            <option value="{{ $cuenta->id }}">{{ $cuenta->banco->nombre ?? 'Sin banco' }} - {{ $cuenta->numero_cuenta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Referencia</label>
                    <input type="text" id="layout_referencia" class="form-control" value="TEST" placeholder="Ej: TEST, PAGO-NOMINA...">
                </div>
                <div class="mb-3">
                    <label>Tipo de Cambio</label>
                    <input type="number" id="layout_tipo_cambio" class="form-control" step="0.0001" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnConfirmarLayout" class="btn btn-primary" style="background-color: #083CAE;">
                    <i class="fas fa-check"></i> Generar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    .table th { background-color: #2378e1 !important; color: white; font-size: 12px; padding: 10px 4px; white-space: nowrap; }
    .table td { font-size: 12px; padding: 10px 4px; white-space: nowrap; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    #tablaBody tr.row-selected { background-color: #d4e4ff !important; }
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .badge-procesado { background-color: #2378e1; color: white; }
    .badge-completado { background-color: #28a745; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    .badge-rechazado { background-color: #dc3545; color: white; }
    .action-icons i { font-size: 14px; cursor: pointer; margin: 0 3px; }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    .fa-check-circle { color: #28a745; }
    .fa-file-pdf { color: #dc3545; }
    .fa-print { color: #6c757d; }
    [draggable="true"] { cursor: grab; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; }
    .modal { z-index: 99999 !important; }
    .modal-backdrop { z-index: 99990 !important; }
    .detalle-label { font-weight: 600; color: #083CAE; width: 180px; }
    .chk-pago { cursor: pointer; width: 16px; height: 16px; }
    #filtrosFila input, #filtrosFila select { border: 1px solid #2378e1 !important; border-radius: 3px; }
    #filtrosFila input:focus, #filtrosFila select:focus { outline: 2px solid #083CAE; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

let datosOriginales = [];
let datosFiltrados = [];
let currentPage = 1;
let rowsPerPage = 8;
let filtrosActivos = {}; // { columna: valor }

// =============================
// Helpers
// =============================
function formatCurrency(amount) {
    return '$' + Number(amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    if (isNaN(date)) return dateString;
    return date.toLocaleDateString('es-MX');
}

function getBadgeClass(estatus) {
    const badges = {
        'pendiente': 'badge-pendiente',
        'procesado': 'badge-procesado',
        'completado': 'badge-completado',
        'cancelado': 'badge-cancelado',
        'rechazado': 'badge-rechazado'
    };
    return badges[estatus] || 'badge-pendiente';
}

function getEstatusTexto(estatus) {
    const textos = {
        'pendiente': 'Pendiente',
        'procesado': 'Procesado',
        'completado': 'Completado',
        'cancelado': 'Cancelado',
        'rechazado': 'Rechazado'
    };
    return textos[estatus] || estatus;
}

function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}

// =============================
// Notificaciones
// =============================
function mostrarNotificacion(mensaje, tipo = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} position-fixed top-0 end-0 m-3 shadow`;
    alertDiv.style.zIndex = '999999';
    alertDiv.style.minWidth = '320px';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3500);
}

// =============================
// FILTROS
// =============================
function aplicarFiltros() {
    // Combinar filtros de columna + filtros de fecha + búsqueda global
    const busqueda = (document.getElementById('buscador')?.value || '').toLowerCase().trim();
    const fechaIni = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';

    datosFiltrados = datosOriginales.filter(item => {
        // 1) Filtros de columna
        for (const [col, val] of Object.entries(filtrosActivos)) {
            if (!val) continue;

            if (col === 'monto') {
                const numVal = parseFloat(val);
                if (!isNaN(numVal) && Number(item.monto) !== numVal) return false;
            } else if (col === 'fecha_pago') {
                // Comparación exacta de fecha
                const itemFecha = item.fecha_pago ? String(item.fecha_pago).split('T')[0] : '';
                if (itemFecha !== val) return false;
            } else if (col === 'estatus') {
                if (String(item.estatus).toLowerCase() !== String(val).toLowerCase()) return false;
            } else {
                const itemVal = String(item[col] || '').toLowerCase();
                if (!itemVal.includes(String(val).toLowerCase())) return false;
            }
        }

        // 2) Filtros de fecha (rango general)
        if (fechaIni || fechaFin) {
            const itemFecha = item.fecha_pago ? String(item.fecha_pago).split('T')[0] : '';
            if (fechaIni && itemFecha < fechaIni) return false;
            if (fechaFin && itemFecha > fechaFin) return false;
        }

        // 3) Búsqueda global
        if (busqueda) {
            const hay = (
                (item.folio || '').toLowerCase().includes(busqueda) ||
                (item.proveedor || '').toLowerCase().includes(busqueda) ||
                (item.concepto || '').toLowerCase().includes(busqueda) ||
                (item.factura || '').toLowerCase().includes(busqueda) ||
                (item.metodo_pago || '').toLowerCase().includes(busqueda) ||
                (item.estatus || '').toLowerCase().includes(busqueda)
            );
            if (!hay) return false;
        }

        return true;
    });

    currentPage = 1;
    cargarTabla(datosFiltrados);
}

function onFiltroColChange(e) {
    const col = e.target.getAttribute('data-col');
    const val = e.target.value;
    if (val) {
        filtrosActivos[col] = val;
    } else {
        delete filtrosActivos[col];
    }
    aplicarFiltros();
}

function limpiarFiltros() {
    filtrosActivos = {};
    document.querySelectorAll('.filtro-col').forEach(f => f.value = '');
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    document.getElementById('buscador').value = '';
    datosFiltrados = [...datosOriginales];
    currentPage = 1;
    cargarTabla(datosFiltrados);
}

// =============================
// Categorías por Tipo de Egreso
// =============================
function cargarCategoriasPorTipoEgreso(categoriaSeleccionada = null) {
    const tipoEgresoId = document.getElementById('tipo_egreso_id').value;
    const categoriaSelect = document.getElementById('categoria_gasto_id');
    if (!categoriaSelect) return;

    if (!tipoEgresoId) {
        categoriaSelect.innerHTML = '<option value="">Primero seleccione un tipo de egreso</option>';
        return;
    }

    categoriaSelect.innerHTML = '<option value="">Cargando categorías...</option>';

    fetch(`/admin/api/categorias-por-tipo-egreso/${tipoEgresoId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(data => {
        categoriaSelect.innerHTML = '<option value="">Seleccionar categoría...</option>';
        if (!Array.isArray(data) || data.length === 0) {
            categoriaSelect.innerHTML += '<option value="" disabled>No hay categorías disponibles</option>';
        } else {
            data.forEach(cat => {
                const selected = (categoriaSeleccionada && String(categoriaSeleccionada) === String(cat.id)) ? 'selected' : '';
                categoriaSelect.innerHTML += `<option value="${cat.id}" ${selected}>${escapeHtml(cat.nombre)}</option>`;
            });
        }
    })
    .catch(error => {
        console.error('Error categorías:', error);
        categoriaSelect.innerHTML = '<option value="">Error al cargar categorías</option>';
    });
}

// =============================
// Código SAT sugerido
// =============================
function cargarCodigoSatSugerido() {
    const proveedorId = document.getElementById('proveedor_id').value;
    const codigoSatSelect = document.getElementById('codigo_sat_id');
    const infoSpan = document.getElementById('codigo_sat_info');
    if (!codigoSatSelect || !infoSpan) return;

    if (!proveedorId) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona un proveedor para cargar el código SAT sugerido';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
        return;
    }

    infoSpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando código SAT sugerido...';

    fetch(`/admin/api/pagos/codigo-sat-sugerido/${proveedorId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.codigo_sat_id) {
            codigoSatSelect.value = data.codigo_sat_id;
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT sugerido: ${escapeHtml(data.codigo_sat_codigo)} - ${escapeHtml(data.codigo_sat_nombre)}`;
            infoSpan.classList.remove('text-muted', 'text-warning', 'text-danger');
            infoSpan.classList.add('text-success');
        } else {
            infoSpan.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Este proveedor no tiene código SAT por defecto. Selecciona uno manualmente.';
            infoSpan.classList.remove('text-muted', 'text-success', 'text-danger');
            infoSpan.classList.add('text-warning');
        }
    })
    .catch(error => {
        console.error('Error SAT sugerido:', error);
        infoSpan.innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i> Error al cargar código SAT sugerido';
        infoSpan.classList.remove('text-muted', 'text-success', 'text-warning');
        infoSpan.classList.add('text-danger');
    });
}

// =============================
// Facturas del proveedor (select "Número de Factura")
// =============================
function cargarFacturasProveedor(preseleccionarId = null, folioBuscado = null) {
    const proveedorId = document.getElementById('proveedor_id')?.value;
    const select = document.getElementById('factura');
    const info = document.getElementById('factura_info');
    const wrap = document.getElementById('factura_manual_wrap');
    if (!select) return;

    // Reset
    select.innerHTML = '<option value="">Sin factura / Manual</option>';
    if (wrap) wrap.style.display = 'none';
    if (info) {
        info.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona un proveedor para cargar sus facturas';
        info.classList.remove('text-success', 'text-warning', 'text-danger');
        info.classList.add('text-muted');
    }

    if (!proveedorId) return;

    if (info) info.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando facturas...';

    fetch(`/admin/api/proveedores/${proveedorId}/facturas`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(res => {
        const facturas = res.data || [];
        let encontradaId = null;

        facturas.forEach(f => {
            const opt = document.createElement('option');
            opt.value = f.id;
            opt.setAttribute('data-folio', f.folio || '');
            opt.setAttribute('data-uuid', f.uuid || '');
            opt.setAttribute('data-monto', f.monto || '');
            opt.setAttribute('data-fecha', f.fecha || '');
            opt.textContent = `${f.folio} — $${Number(f.monto || 0).toFixed(2)} (${f.fecha || 'sin fecha'})`;
            select.appendChild(opt);

            if (preseleccionarId && String(preseleccionarId) === String(f.id)) {
                encontradaId = f.id;
            }
            if (folioBuscado && f.folio === folioBuscado) {
                encontradaId = f.id;
            }
        });

        const optManual = document.createElement('option');
        optManual.value = '__manual__';
        optManual.textContent = 'Otra (captura manual)...';
        select.appendChild(optManual);

        if (info) {
            if (facturas.length === 0) {
                info.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Este proveedor no tiene facturas registradas. Puedes capturar una manualmente.';
                info.classList.remove('text-muted', 'text-success');
                info.classList.add('text-warning');
            } else {
                info.innerHTML = `<i class="fas fa-check-circle text-success"></i> ${facturas.length} factura(s) encontrada(s)`;
                info.classList.remove('text-muted', 'text-warning', 'text-danger');
                info.classList.add('text-success');
            }
        }

        if (encontradaId) {
            select.value = encontradaId;
            aplicarFacturaSeleccionada(encontradaId);
        } else if (folioBuscado) {
            // El folio no está en catálogo → manual
            select.value = '__manual__';
            if (wrap) wrap.style.display = 'block';
            document.getElementById('factura_manual').value = folioBuscado;
        }
    })
    .catch(err => {
        console.error(err);
        if (info) {
            info.innerHTML = '<i class="fas fa-times-circle text-danger"></i> Error al cargar facturas';
            info.classList.remove('text-muted', 'text-success', 'text-warning');
            info.classList.add('text-danger');
        }
    });
}

function aplicarFacturaSeleccionada(facturaId) {
    const select = document.getElementById('factura');
    const opt = Array.from(select.options).find(o => o.value === String(facturaId));
    if (!opt) return;

    const uuid  = opt.getAttribute('data-uuid') || '';
    const monto = opt.getAttribute('data-monto') || '';
    const fecha = opt.getAttribute('data-fecha') || '';

    document.getElementById('factura_uuid').value  = uuid;
    document.getElementById('factura_monto').value = monto ? Number(monto).toFixed(2) : '';
    document.getElementById('factura_fecha').value = fecha ? String(fecha).split('T')[0] : '';
}

function onFacturaSelectChange() {
    const select = document.getElementById('factura');
    const val = select.value;
    const wrap = document.getElementById('factura_manual_wrap');

    if (val === '__manual__') {
        if (wrap) wrap.style.display = 'block';
        document.getElementById('factura_uuid').value = '';
        document.getElementById('factura_monto').value = '';
        document.getElementById('factura_fecha').value = '';
        document.getElementById('factura_manual')?.focus();
    } else if (val === '') {
        if (wrap) wrap.style.display = 'none';
        document.getElementById('factura_uuid').value = '';
        document.getElementById('factura_monto').value = '';
        document.getElementById('factura_fecha').value = '';
    } else {
        if (wrap) wrap.style.display = 'none';
        aplicarFacturaSeleccionada(val);
    }
}

// =============================
// Cargar Pagos (grid)
// =============================
function cargarPagos() {
    fetch('/admin/api/pagos', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin'
    })
    .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(res => {
        const data = Array.isArray(res) ? res : (res.data || []);

        datosOriginales = data.map(d => ({
            id: d.id,
            folio: d.folio || '-',
            fecha_pago: d.fecha_pago,
            proveedor: d.proveedor?.nombre || d.proveedor_nombre || d.proveedor || '-',
            proveedor_id: d.proveedor_id || null,
            concepto: d.concepto || '-',
            monto: parseFloat(d.monto) || 0,
            metodo_pago: d.metodo_pago?.nombre || d.metodo_pago || '-',
            metodo_pago_id: d.metodo_pago_id || null,
            estatus: d.estatus || 'pendiente',
            factura: d.factura || '-',
            factura_uuid: d.factura_uuid || null,
            factura_monto: d.factura_monto || null,
            factura_fecha: d.factura_fecha || null,
            codigo_sat_id: d.codigo_sat_id || null,
            codigo_sat: d.codigo_sat || null,
            tipo_egreso_id: d.tipo_egreso_id || null,
            categoria_gasto_id: d.categoria_gasto_id || null,
            proyecto_id: d.proyecto_id || null,
            cuenta_bancaria_id: d.cuenta_bancaria_id || null,
            moneda_id: d.moneda_id || null,
            referencia: d.referencia || '',
            referencia_bancaria: d.referencia_bancaria || '',
            observaciones: d.observaciones || ''
        }));

        datosFiltrados = [...datosOriginales];
        aplicarFiltros();

        const stats = res.stats || {
            total: datosOriginales.length,
            completados: datosOriginales.filter(x => x.estatus === 'completado').length,
            pendientes: datosOriginales.filter(x => x.estatus === 'pendiente').length,
            total_monto: datosOriginales.reduce((s, x) => s + x.monto, 0)
        };

        const elTotal = document.getElementById('statTotal');
        const elComp = document.getElementById('statCompletados');
        const elPend = document.getElementById('statPendientes');
        const elMonto = document.getElementById('statMonto');

        if (elTotal) elTotal.textContent = stats.total;
        if (elComp) elComp.textContent = stats.completados;
        if (elPend) elPend.textContent = stats.pendientes;
        if (elMonto) elMonto.textContent = formatCurrency(stats.total_monto);
    })
    .catch(error => {
        console.error('Error cargando pagos:', error);
        const tablaBody = document.getElementById('tablaBody');
        if (tablaBody) {
            tablaBody.innerHTML = '<tr><td colspan="10" style="color:red; text-align:center;">Error al cargar datos: ' + escapeHtml(error.message) + '</td></tr>';
        }
        mostrarNotificacion('Error al cargar datos: ' + error.message, 'danger');
    });
}

// =============================
// Abrir modal Pago (nuevo)
// =============================
function abrirModalPago() {
    document.getElementById('modalPagoTitulo').textContent = 'Nuevo Pago';
    document.getElementById('pago_id').value = '';
    document.getElementById('fecha_pago').value = new Date().toISOString().split('T')[0];
    document.getElementById('cuenta_bancaria_id').value = '';
    document.getElementById('proveedor_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('tipo_egreso_id').value = '';
    document.getElementById('categoria_gasto_id').innerHTML = '<option value="">Primero seleccione un tipo de egreso</option>';
    document.getElementById('metodo_pago_id').value = '';
    document.getElementById('moneda_id').value = '';
    document.getElementById('monto').value = '';
    document.getElementById('concepto').value = '';
    document.getElementById('referencia').value = '';
    document.getElementById('referencia_bancaria').value = '';
    document.getElementById('factura_uuid').value = '';
    document.getElementById('factura_monto').value = '';
    document.getElementById('factura_fecha').value = '';
    document.getElementById('observaciones').value = '';
    document.getElementById('aplicar_ahora').checked = true;
    document.getElementById('codigo_sat_id').value = '';

    // Reset select de factura
    const selFactura = document.getElementById('factura');
    if (selFactura) selFactura.innerHTML = '<option value="">Sin factura / Manual</option>';
    const wrapManual = document.getElementById('factura_manual_wrap');
    if (wrapManual) wrapManual.style.display = 'none';
    const inputManual = document.getElementById('factura_manual');
    if (inputManual) inputManual.value = '';
    const infoFactura = document.getElementById('factura_info');
    if (infoFactura) {
        infoFactura.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona un proveedor para cargar sus facturas';
        infoFactura.classList.remove('text-success', 'text-warning', 'text-danger');
        infoFactura.classList.add('text-muted');
    }

    const infoSpan = document.getElementById('codigo_sat_info');
    if (infoSpan) {
        infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Al seleccionar un proveedor se cargará el código sugerido';
        infoSpan.classList.remove('text-success', 'text-warning', 'text-danger');
        infoSpan.classList.add('text-muted');
    }

    new bootstrap.Modal(document.getElementById('modalPago')).show();
}

// =============================
// Abrir modal Proveedor
// =============================
function abrirModalProveedor() {
    document.getElementById('prov_nombre').value = '';
    document.getElementById('prov_rfc').value = '';
    document.getElementById('prov_email').value = '';
    document.getElementById('prov_telefono').value = '';
    document.getElementById('prov_contacto').value = '';
    new bootstrap.Modal(document.getElementById('modalProveedor')).show();
}

function guardarProveedorRapido() {
    const data = {
        nombre: document.getElementById('prov_nombre').value,
        rfc: document.getElementById('prov_rfc').value,
        email: document.getElementById('prov_email').value,
        telefono: document.getElementById('prov_telefono').value,
        contacto: document.getElementById('prov_contacto').value,
        activo: true
    };

    if (!data.nombre) {
        mostrarNotificacion('El nombre del proveedor es obligatorio', 'warning');
        return;
    }

    fetch('/admin/api/proveedores', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion('Proveedor creado exitosamente', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalProveedor')).hide();
            cargarProveedores(result.data?.id);
        } else {
            mostrarNotificacion(result.message || 'Error al guardar proveedor', 'danger');
        }
    })
    .catch(() => mostrarNotificacion('Error al guardar proveedor', 'danger'));
}

function cargarProveedores(seleccionarId = null) {
    fetch('/admin/api/proveedores', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(data => {
        const list = Array.isArray(data) ? data : (data.data || []);
        const select = document.getElementById('proveedor_id');
        select.innerHTML = '<option value="">Seleccionar proveedor...</option>';
        list.forEach(prov => {
            const selected = (seleccionarId && String(seleccionarId) === String(prov.id)) ? 'selected' : '';
            select.innerHTML += `<option value="${prov.id}" ${selected} data-codigo-sat-id="${prov.codigo_sat_default_id || ''}">${escapeHtml(prov.nombre)} - ${escapeHtml(prov.rfc || 'Sin RFC')}</option>`;
        });
        if (seleccionarId) {
            cargarCodigoSatSugerido();
            cargarFacturasProveedor();
        }
    });
}

// =============================
// Editar Pago
// =============================
function editarPago(id) {
    fetch(`/admin/api/pagos/${id}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(res => {
        const pago = res.data || res;

        document.getElementById('modalPagoTitulo').textContent = 'Editar Pago';
        document.getElementById('pago_id').value = pago.id;
        document.getElementById('fecha_pago').value = pago.fecha_pago;
        document.getElementById('cuenta_bancaria_id').value = pago.cuenta_bancaria_id;
        document.getElementById('proveedor_id').value = pago.proveedor_id || '';
        document.getElementById('proyecto_id').value = pago.proyecto_id || '';
        document.getElementById('tipo_egreso_id').value = pago.tipo_egreso_id;
        document.getElementById('metodo_pago_id').value = pago.metodo_pago_id;
        document.getElementById('moneda_id').value = pago.moneda_id;
        document.getElementById('monto').value = pago.monto;
        document.getElementById('concepto').value = pago.concepto || '';
        document.getElementById('referencia').value = pago.referencia || '';
        document.getElementById('referencia_bancaria').value = pago.referencia_bancaria || '';
        document.getElementById('factura_uuid').value = pago.factura_uuid || '';
        document.getElementById('factura_monto').value = pago.factura_monto || '';
        document.getElementById('factura_fecha').value = pago.factura_fecha ? String(pago.factura_fecha).split('T')[0] : '';
        document.getElementById('observaciones').value = pago.observaciones || '';
        document.getElementById('aplicar_ahora').checked = false;
        document.getElementById('codigo_sat_id').value = pago.codigo_sat_id || '';

        if (pago.tipo_egreso_id) {
            cargarCategoriasPorTipoEgreso(pago.categoria_gasto_id);
        }

        // Cargar facturas del proveedor y preseleccionar por folio
        if (pago.proveedor_id) {
            cargarFacturasProveedor(null, pago.factura);
        } else {
            const selFactura = document.getElementById('factura');
            if (selFactura) selFactura.innerHTML = '<option value="">Sin factura / Manual</option>';
            document.getElementById('factura_manual').value = pago.factura || '';
            document.getElementById('factura_manual_wrap').style.display = pago.factura ? 'block' : 'none';
        }

        const codigoSatSelect = document.getElementById('codigo_sat_id');
        const selectedOption = codigoSatSelect.options[codigoSatSelect.selectedIndex];
        const infoSpan = document.getElementById('codigo_sat_info');
        if (selectedOption && selectedOption.value && infoSpan) {
            const codigo = selectedOption.getAttribute('data-codigo') || '';
            const nombre = selectedOption.getAttribute('data-nombre') || '';
            infoSpan.innerHTML = `<i class="fas fa-check-circle text-success"></i> Código SAT seleccionado: ${escapeHtml(codigo)} - ${escapeHtml(nombre)}`;
            infoSpan.classList.remove('text-muted', 'text-warning');
            infoSpan.classList.add('text-success');
        } else if (infoSpan) {
            infoSpan.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona un código SAT para este pago';
        }

        new bootstrap.Modal(document.getElementById('modalPago')).show();
    })
    .catch(err => {
        console.error(err);
        mostrarNotificacion('Error al cargar el pago', 'danger');
    });
}

// =============================
// Guardar Pago (crear/editar)
// =============================
function guardarPago() {
    const id = document.getElementById('pago_id').value;

    // Resolver valor de factura
    const selFactura = document.getElementById('factura');
    let valorFactura = null;
    if (selFactura) {
        if (selFactura.value === '__manual__') {
            valorFactura = document.getElementById('factura_manual').value || null;
        } else if (selFactura.value === '') {
            valorFactura = null;
        } else {
            const opt = selFactura.options[selFactura.selectedIndex];
            valorFactura = opt.getAttribute('data-folio') || null;
        }
    }

    const data = {
        fecha_pago: document.getElementById('fecha_pago').value,
        cuenta_bancaria_id: document.getElementById('cuenta_bancaria_id').value,
        proveedor_id: document.getElementById('proveedor_id').value || null,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        tipo_egreso_id: document.getElementById('tipo_egreso_id').value,
        categoria_gasto_id: document.getElementById('categoria_gasto_id').value || null,
        metodo_pago_id: document.getElementById('metodo_pago_id').value,
        moneda_id: document.getElementById('moneda_id').value,
        monto: document.getElementById('monto').value,
        concepto: document.getElementById('concepto').value,
        referencia: document.getElementById('referencia').value,
        referencia_bancaria: document.getElementById('referencia_bancaria').value,
        factura: valorFactura,
        factura_uuid: document.getElementById('factura_uuid').value || null,
        factura_monto: document.getElementById('factura_monto').value || null,
        factura_fecha: document.getElementById('factura_fecha').value || null,
        observaciones: document.getElementById('observaciones').value,
        aplicar_ahora: document.getElementById('aplicar_ahora').checked,
        codigo_sat_id: document.getElementById('codigo_sat_id').value || null
    };

    // Validaciones mínimas del lado cliente
    if (!data.fecha_pago) { mostrarNotificacion('Seleccione una fecha', 'warning'); return; }
    if (!data.cuenta_bancaria_id) { mostrarNotificacion('Seleccione una cuenta bancaria', 'warning'); return; }
    if (!data.tipo_egreso_id) { mostrarNotificacion('Seleccione un tipo de egreso', 'warning'); return; }
    if (!data.metodo_pago_id) { mostrarNotificacion('Seleccione un método de pago', 'warning'); return; }
    if (!data.moneda_id) { mostrarNotificacion('Seleccione una moneda', 'warning'); return; }
    if (!data.monto || parseFloat(data.monto) <= 0) { mostrarNotificacion('Ingrese un monto válido', 'warning'); return; }
    if (!data.concepto) { mostrarNotificacion('Ingrese un concepto', 'warning'); return; }
    if (!data.proveedor_id) { mostrarNotificacion('Seleccione un proveedor', 'warning'); return; }

    const url = id ? `/admin/api/pagos/${id}` : '/admin/api/pagos';
    const method = id ? 'PUT' : 'POST';

    const btn = document.getElementById('btnGuardarPago');
    if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...'; }

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
    .then(r => r.json().then(body => ({ status: r.status, body })))
    .then(({ status, body }) => {
        if (body.success) {
            mostrarNotificacion(body.message || 'Guardado exitosamente', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalPago')).hide();
            cargarPagos();
        } else {
            let msg = body.message || 'Error al guardar';
            if (body.errors) {
                const detalles = Object.values(body.errors).flat().join('<br>');
                msg += '<br><small>' + detalles + '</small>';
            }
            mostrarNotificacion(msg, 'danger');
        }
    })
    .catch(error => {
        console.error(error);
        mostrarNotificacion('Error al guardar: ' + error.message, 'danger');
    })
    .finally(() => {
        if (btn) { btn.disabled = false; btn.innerHTML = 'Guardar'; }
    });
}

// =============================
// Eliminar Pago
// =============================
function eliminarPago(id) {
    if (!confirm('¿Eliminar este pago?')) return;

    fetch(`/admin/api/pagos/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            cargarPagos();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(() => mostrarNotificacion('Error al eliminar', 'danger'));
}

// =============================
// Aplicar Pago
// =============================
function aplicarPago(id) {
    if (!confirm('¿Aplicar este pago? Se actualizará el saldo de la cuenta bancaria.')) return;

    fetch(`/admin/api/pagos/${id}/aplicar`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            cargarPagos();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(() => mostrarNotificacion('Error al aplicar pago', 'danger'));
}

// =============================
// Ver detalle en MODAL
// =============================
function verDetalle(id) {
    const body = document.getElementById('verPagoBody');
    body.innerHTML = '<div class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
    new bootstrap.Modal(document.getElementById('modalVerPago')).show();

    fetch(`/admin/api/pagos/${id}`, {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    })
    .then(r => r.json())
    .then(res => {
        const p = res.data || res;
        body.innerHTML = `
            <table class="table table-sm table-striped">
                <tbody>
                    <tr><th class="detalle-label">Folio</th><td>${escapeHtml(p.folio)}</td></tr>
                    <tr><th class="detalle-label">Fecha</th><td>${formatDate(p.fecha_pago)}</td></tr>
                    <tr><th class="detalle-label">Proveedor</th><td>${escapeHtml(p.proveedor?.nombre || p.proveedor_nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">RFC</th><td>${escapeHtml(p.proveedor?.rfc || p.proveedor_rfc || '-')}</td></tr>
                    <tr><th class="detalle-label">Proyecto</th><td>${escapeHtml(p.proyecto?.nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">Tipo de Egreso</th><td>${escapeHtml(p.tipo_egreso?.nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">Categoría</th><td>${escapeHtml(p.categoria_gasto?.nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">Método de Pago</th><td>${escapeHtml(p.metodo_pago?.nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">Moneda</th><td>${escapeHtml(p.moneda?.nombre || '-')}</td></tr>
                    <tr><th class="detalle-label">Monto</th><td><strong>${formatCurrency(p.monto)}</strong></td></tr>
                    <tr><th class="detalle-label">Concepto</th><td>${escapeHtml(p.concepto)}</td></tr>
                    <tr><th class="detalle-label">Factura</th><td>${escapeHtml(p.factura || '-')}</td></tr>
                    <tr><th class="detalle-label">UUID Factura</th><td>${escapeHtml(p.factura_uuid || '-')}</td></tr>
                    <tr><th class="detalle-label">Monto Factura</th><td>${p.factura_monto ? formatCurrency(p.factura_monto) : '-'}</td></tr>
                    <tr><th class="detalle-label">Fecha Factura</th><td>${p.factura_fecha ? formatDate(p.factura_fecha) : '-'}</td></tr>
                    <tr><th class="detalle-label">Código SAT</th><td>${escapeHtml(p.codigo_sat?.codigo_agrupador || '-')} - ${escapeHtml(p.codigo_sat?.nombre_cuenta || '-')}</td></tr>
                    <tr><th class="detalle-label">Referencia</th><td>${escapeHtml(p.referencia || '-')}</td></tr>
                    <tr><th class="detalle-label">Referencia Bancaria</th><td>${escapeHtml(p.referencia_bancaria || '-')}</td></tr>
                    <tr><th class="detalle-label">Observaciones</th><td>${escapeHtml(p.observaciones || '-')}</td></tr>
                    <tr><th class="detalle-label">Estatus</th><td><span class="badge ${getBadgeClass(p.estatus)}">${getEstatusTexto(p.estatus)}</span></td></tr>
                </tbody>
            </table>
        `;
    })
    .catch(err => {
        console.error(err);
        body.innerHTML = '<div class="alert alert-danger">Error al cargar el detalle</div>';
    });
}

// =============================
// Exportar Excel
// =============================
function exportarExcel() {
    const tabla = document.getElementById('tablaPagos');
    const html = tabla.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'pagos.xls';
    link.click();
}

// =============================
// Render tabla con paginación
// =============================
function cargarTabla(datos) {
    const tablaBody = document.getElementById('tablaBody');
    if (!tablaBody) return;

    if (!datos || datos.length === 0) {
        tablaBody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No hay registros</td></tr>';
        document.getElementById('sumMonto').textContent = formatCurrency(0);
        actualizarPaginacion(0);
        actualizarSeleccionInfo();
        return;
    }

    const start = (currentPage - 1) * rowsPerPage;
    const pageData = datos.slice(start, start + rowsPerPage);
    const totalMonto = datos.reduce((s, x) => s + x.monto, 0);

    tablaBody.innerHTML = pageData.map(item => `
        <tr data-id="${item.id}">
            <td style="text-align:center;"><input type="checkbox" class="chk-pago" value="${item.id}"></td>
            <td>${escapeHtml(item.folio)}</td>
            <td>${formatDate(item.fecha_pago)}</td>
            <td>${escapeHtml(item.proveedor)}</td>
            <td>${escapeHtml(item.concepto)}</td>
            <td style="text-align:right;">${formatCurrency(item.monto)}</td>
            <td>${escapeHtml(item.metodo_pago)}</td>
            <td><span class="badge ${getBadgeClass(item.estatus)}">${getEstatusTexto(item.estatus)}</span></td>
            <td>${escapeHtml(item.factura)}</td>
            <td style="position:sticky;right:0;background:white;">
                <div class="action-icons">
                    <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver"></i>
                    <i class="fas fa-edit" onclick="editarPago(${item.id})" title="Editar"></i>
                    <i class="fas fa-trash-alt" onclick="eliminarPago(${item.id})" title="Eliminar"></i>
                    ${item.estatus === 'pendiente' ? `<i class="fas fa-check-circle" onclick="aplicarPago(${item.id})" title="Aplicar"></i>` : ''}
                </div>
            </td>
        </tr>
    `).join('');

    document.getElementById('sumMonto').textContent = formatCurrency(totalMonto);
    actualizarPaginacion(datos.length);

    document.querySelectorAll('.chk-pago').forEach(chk => {
        chk.checked = pagosSeleccionados.has(Number(chk.value));
        if (chk.checked) chk.closest('tr').classList.add('row-selected');
        chk.addEventListener('change', onChkPagoChange);
    });

    actualizarSeleccionInfo();
    actualizarChkTodos();
}

function actualizarPaginacion(total) {
    const totalPages = Math.max(1, Math.ceil(total / rowsPerPage));
    if (currentPage > totalPages) currentPage = totalPages;

    document.getElementById('paginaActual').textContent = currentPage;
    const desde = total === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1;
    const hasta = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginacionInfo').textContent = `Mostrando ${desde}-${hasta} de ${total} registros`;
}

function generarPDF(id) {
    mostrarNotificacion('Generando PDF...', 'info');
    window.open(`/admin/api/pagos/${id}/pdf`, '_blank');
}

function imprimir(id) {
    window.open(`/admin/api/pagos/${id}/print`, '_blank');
}

// =============================
// LAYOUT DE PAGOS - Selección y generación
// =============================
const pagosSeleccionados = new Set();

function onChkPagoChange(e) {
    const id = Number(e.target.value);
    if (e.target.checked) {
        pagosSeleccionados.add(id);
        e.target.closest('tr').classList.add('row-selected');
    } else {
        pagosSeleccionados.delete(id);
        e.target.closest('tr').classList.remove('row-selected');
    }
    actualizarSeleccionInfo();
    actualizarChkTodos();
}

function actualizarSeleccionInfo() {
    const info = document.getElementById('seleccionInfo');
    const span = document.getElementById('seleccionados');
    if (!info || !span) return;

    if (pagosSeleccionados.size > 0) {
        info.style.display = 'block';
        span.textContent = pagosSeleccionados.size;
    } else {
        info.style.display = 'none';
    }
}

function actualizarChkTodos() {
    const chkTodos = document.getElementById('chkTodos');
    if (!chkTodos) return;

    const chks = document.querySelectorAll('.chk-pago');
    if (chks.length === 0) {
        chkTodos.checked = false;
        chkTodos.indeterminate = false;
        return;
    }

    const total = chks.length;
    const marcados = Array.from(chks).filter(c => c.checked).length;

    chkTodos.checked = marcados === total;
    chkTodos.indeterminate = marcados > 0 && marcados < total;
}

function limpiarSeleccion() {
    pagosSeleccionados.clear();
    document.querySelectorAll('.chk-pago').forEach(c => {
        c.checked = false;
        c.closest('tr').classList.remove('row-selected');
    });
    actualizarSeleccionInfo();
    actualizarChkTodos();
}

function abrirModalLayout() {
    if (pagosSeleccionados.size === 0) {
        mostrarNotificacion('Selecciona al menos un pago (marca las casillas)', 'warning');
        return;
    }

    document.getElementById('layoutNumPagos').textContent = pagosSeleccionados.size;
    document.getElementById('layout_fecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('layout_referencia').value = 'TEST';
    document.getElementById('layout_tipo_cambio').value = 1;

    const ids = Array.from(pagosSeleccionados);
    const cuentas = ids.map(id => datosOriginales.find(x => x.id === id)?.cuenta_bancaria_id).filter(Boolean);
    const cuentaUnica = cuentas.length > 0 && cuentas.every(c => c === cuentas[0]) ? cuentas[0] : '';
    document.getElementById('layout_cuenta_bancaria_id').value = cuentaUnica || '';

    new bootstrap.Modal(document.getElementById('modalLayout')).show();
}

function confirmarLayout() {
    const fecha = document.getElementById('layout_fecha').value;
    const cuentaId = document.getElementById('layout_cuenta_bancaria_id').value;
    const referencia = document.getElementById('layout_referencia').value;
    const tipoCambio = parseFloat(document.getElementById('layout_tipo_cambio').value) || 1;

    if (!fecha) { mostrarNotificacion('Selecciona una fecha', 'warning'); return; }
    if (!cuentaId) { mostrarNotificacion('Selecciona una cuenta bancaria', 'warning'); return; }
    if (pagosSeleccionados.size === 0) { mostrarNotificacion('No hay pagos seleccionados', 'warning'); return; }

    const btn = document.getElementById('btnConfirmarLayout');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';

    fetch('/admin/api/layouts/generar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
            fecha: fecha,
            cuenta_bancaria_id: cuentaId,
            referencia: referencia,
            tipo_cambio: tipoCambio,
            pago_ids: Array.from(pagosSeleccionados)
        })
    })
    .then(r => r.json().then(body => ({ status: r.status, body })))
    .then(({ status, body }) => {
        if (body.success) {
            mostrarNotificacion('Layout generado. Abriendo documento...', 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalLayout')).hide();
            limpiarSeleccion();

            setTimeout(() => {
                window.open(`/admin/layouts/${body.data.id}/ver`, '_blank');
            }, 400);
        } else {
            let msg = body.message || 'Error al generar layout';
            if (body.errors) {
                const detalles = Object.values(body.errors).flat().join('<br>');
                msg += '<br><small>' + detalles + '</small>';
            }
            mostrarNotificacion(msg, 'danger');
        }
    })
    .catch(err => {
        console.error(err);
        mostrarNotificacion('Error al generar layout: ' + err.message, 'danger');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check"></i> Generar';
    });
}

// =============================
// Event listeners
// =============================
document.getElementById('tipo_egreso_id')?.addEventListener('change', () => cargarCategoriasPorTipoEgreso());
document.getElementById('proveedor_id')?.addEventListener('change', () => {
    cargarCodigoSatSugerido();
    cargarFacturasProveedor();
});
document.getElementById('factura')?.addEventListener('change', onFacturaSelectChange);
document.getElementById('btnAgregar')?.addEventListener('click', abrirModalPago);
document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
document.getElementById('btnLayout')?.addEventListener('click', abrirModalLayout);
document.getElementById('btnConfirmarLayout')?.addEventListener('click', confirmarLayout);
document.getElementById('btnLimpiarFiltros')?.addEventListener('click', limpiarFiltros);

document.getElementById('chkTodos')?.addEventListener('change', e => {
    const chks = document.querySelectorAll('.chk-pago');
    chks.forEach(c => {
        c.checked = e.target.checked;
        const id = Number(c.value);
        if (e.target.checked) {
            pagosSeleccionados.add(id);
            c.closest('tr').classList.add('row-selected');
        } else {
            pagosSeleccionados.delete(id);
            c.closest('tr').classList.remove('row-selected');
        }
    });
    actualizarSeleccionInfo();
});

// Filtros por columna
document.querySelectorAll('.filtro-col').forEach(f => {
    const eventName = f.tagName === 'SELECT' || f.type === 'date' ? 'change' : 'input';
    f.addEventListener(eventName, onFiltroColChange);
});

// Fechas generales
document.getElementById('fechaInicio')?.addEventListener('change', aplicarFiltros);
document.getElementById('fechaFin')?.addEventListener('change', aplicarFiltros);

// Buscador global
document.getElementById('buscador')?.addEventListener('input', aplicarFiltros);

// Paginación
document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarTabla(datosFiltrados); });
document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTabla(datosFiltrados); } });
document.getElementById('btnSiguiente')?.addEventListener('click', () => {
    const total = Math.ceil(datosFiltrados.length / rowsPerPage);
    if (currentPage < total) { currentPage++; cargarTabla(datosFiltrados); }
});
document.getElementById('btnUltima')?.addEventListener('click', () => {
    currentPage = Math.max(1, Math.ceil(datosFiltrados.length / rowsPerPage));
    cargarTabla(datosFiltrados);
});

document.addEventListener('DOMContentLoaded', () => {
    cargarPagos();
});
</script>
@endsection