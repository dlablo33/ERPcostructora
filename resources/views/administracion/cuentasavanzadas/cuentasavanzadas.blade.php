@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-white-50 text-white-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #ffffff; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 28px; text-align: center;">
                    <i class="fas fa-cogs"></i> Catálogos Adminitracion
                </h1>
                <p style="text-align: center; color: #f4f6f9; margin-top: 5px;">Administración de monedas, tipos de cambio, bancos, métodos de pago, tipos de ingreso/egreso y categorías de gastos</p>
            </div>

            <div class="card-body p-4">
                <!-- Pestañas de navegación -->
                <ul class="nav nav-tabs" id="catalogosTab" role="tablist" style="border-bottom: 2px solid #083CAE; margin-bottom: 20px;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="monedas-tab" data-bs-toggle="tab" data-bs-target="#monedas" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-coins"></i> Monedas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tipos-cambio-tab" data-bs-toggle="tab" data-bs-target="#tipos-cambio" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-exchange-alt"></i> Tipos de Cambio
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bancos-tab" data-bs-toggle="tab" data-bs-target="#bancos" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-university"></i> Bancos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="metodos-pago-tab" data-bs-toggle="tab" data-bs-target="#metodos-pago" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-credit-card"></i> Métodos de Pago
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tipos-ingreso-tab" data-bs-toggle="tab" data-bs-target="#tipos-ingreso" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-arrow-up"></i> Tipos de Ingreso
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tipos-egreso-tab" data-bs-toggle="tab" data-bs-target="#tipos-egreso" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-arrow-down"></i> Tipos de Egreso
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categorias-gasto-tab" data-bs-toggle="tab" data-bs-target="#categorias-gasto" type="button" role="tab" style="color: #083CAE; font-weight: 600;">
                            <i class="fas fa-tags"></i> Categorías de Gasto
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content" id="catalogosTabContent">
                    
                    <!-- ==================== MONEDAS ==================== -->
                    <div class="tab-pane fade show active" id="monedas" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-coins"></i> Monedas</h3>
                            <button class="btn btn-primary" onclick="abrirModalMoneda()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nueva Moneda
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaMonedas">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Símbolo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyMonedas">
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== TIPOS DE CAMBIO ==================== -->
                    <div class="tab-pane fade" id="tipos-cambio" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-exchange-alt"></i> Tipos de Cambio</h3>
                            <button class="btn btn-primary" onclick="abrirModalTipoCambio()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nuevo Tipo de Cambio
                            </button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Fecha:</label>
                                <input type="date" id="filtroFechaTC" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button class="btn btn-info form-control" onclick="filtrarTiposCambio()">Filtrar</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaTiposCambio">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Moneda Origen</th>
                                        <th>Moneda Destino</th>
                                        <th>Tasa</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyTiposCambio">
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== BANCOS ==================== -->
                    <div class="tab-pane fade" id="bancos" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-university"></i> Bancos</h3>
                            <button class="btn btn-primary" onclick="abrirModalBanco()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nuevo Banco
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaBancos">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Código</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyBancos">
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== MÉTODOS DE PAGO ==================== -->
                    <div class="tab-pane fade" id="metodos-pago" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-credit-card"></i> Métodos de Pago</h3>
                            <button class="btn btn-primary" onclick="abrirModalMetodoPago()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nuevo Método de Pago
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaMetodosPago">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyMetodosPago">
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== TIPOS DE INGRESO ==================== -->
                    <div class="tab-pane fade" id="tipos-ingreso" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-arrow-up"></i> Tipos de Ingreso</h3>
                            <button class="btn btn-primary" onclick="abrirModalTipoIngreso()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nuevo Tipo de Ingreso
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaTiposIngreso">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyTiposIngreso">
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== TIPOS DE EGRESO ==================== -->
                    <div class="tab-pane fade" id="tipos-egreso" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-arrow-down"></i> Tipos de Egreso</h3>
                            <button class="btn btn-primary" onclick="abrirModalTipoEgreso()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nuevo Tipo de Egreso
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaTiposEgreso">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyTiposEgreso">
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ==================== CATEGORÍAS DE GASTO ==================== -->
                    <div class="tab-pane fade" id="categorias-gasto" role="tabpanel">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;"><i class="fas fa-tags"></i> Categorías de Gasto</h3>
                            <button class="btn btn-primary" onclick="abrirModalCategoriaGasto()" style="background-color: #083CAE; border: none;">
                                <i class="fas fa-plus"></i> Nueva Categoría
                            </button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Filtrar por Tipo de Egreso:</label>
                                <select id="filtroTipoEgreso" class="form-control" onchange="filtrarCategoriasGasto()">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaCategoriasGasto">
                                <thead style="background-color: #2378e1; color: white;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Tipo de Egreso</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyCategoriasGasto">
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Monedas -->
<div class="modal fade" id="modalMoneda" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-coins"></i> Moneda</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMoneda">
                    <input type="hidden" id="moneda_id">
                    <div class="mb-3">
                        <label>Código <span class="text-danger">*</span></label>
                        <input type="text" id="moneda_codigo" class="form-control" maxlength="3" required>
                        <small class="text-muted">Ej: MXN, USD, EUR</small>
                    </div>
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="moneda_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Símbolo <span class="text-danger">*</span></label>
                        <input type="text" id="moneda_simbolo" class="form-control" maxlength="5" required>
                        <small class="text-muted">Ej: $, US$, €</small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="moneda_activa" class="form-check-input" checked>
                            <label class="form-check-label">Activa</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarMoneda()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Tipos de Cambio -->
<div class="modal fade" id="modalTipoCambio" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Tipo de Cambio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTipoCambio">
                    <input type="hidden" id="tipocambio_id">
                    <div class="mb-3">
                        <label>Moneda Origen <span class="text-danger">*</span></label>
                        <select id="tipocambio_origen" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <label>Moneda Destino <span class="text-danger">*</span></label>
                        <select id="tipocambio_destino" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <label>Tasa <span class="text-danger">*</span></label>
                        <input type="number" id="tipocambio_tasa" class="form-control" step="0.0001" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha <span class="text-danger">*</span></label>
                        <input type="date" id="tipocambio_fecha" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTipoCambio()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Bancos -->
<div class="modal fade" id="modalBanco" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-university"></i> Banco</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formBanco">
                    <input type="hidden" id="banco_id">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="banco_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Código</label>
                        <input type="text" id="banco_codigo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="banco_activo" class="form-check-input" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarBanco()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Métodos de Pago -->
<div class="modal fade" id="modalMetodoPago" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-credit-card"></i> Método de Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formMetodoPago">
                    <input type="hidden" id="metodopago_id">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="metodopago_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="metodopago_descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="metodopago_activo" class="form-check-input" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarMetodoPago()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Tipos de Ingreso -->
<div class="modal fade" id="modalTipoIngreso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-arrow-up"></i> Tipo de Ingreso</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTipoIngreso">
                    <input type="hidden" id="tipoingreso_id">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="tipoingreso_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="tipoingreso_descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="tipoingreso_activo" class="form-check-input" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTipoIngreso()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Tipos de Egreso -->
<div class="modal fade" id="modalTipoEgreso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-arrow-down"></i> Tipo de Egreso</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTipoEgreso">
                    <input type="hidden" id="tipoegreso_id">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="tipoegreso_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="tipoegreso_descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="tipoegreso_activo" class="form-check-input" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTipoEgreso()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Categorías de Gasto -->
<div class="modal fade" id="modalCategoriaGasto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-tags"></i> Categoría de Gasto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCategoriaGasto">
                    <input type="hidden" id="categoriagasto_id">
                    <div class="mb-3">
                        <label>Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="categoriagasto_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="categoriagasto_descripcion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tipo de Egreso <span class="text-danger">*</span></label>
                        <select id="categoriagasto_tipo_egreso_id" class="form-control" required></select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" id="categoriagasto_activo" class="form-check-input" checked>
                            <label class="form-check-label">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCategoriaGasto()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        border: none;
        color: #FFFFFF;
        padding: 10px 20px;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link:hover {
        color: #083CAE;
        border-bottom: 2px solid #083CAE;
    }
    .nav-tabs .nav-link.active {
        color: #083CAE;
        background: none;
        border-bottom: 2px solid #083CAE;
    }
    .table th {
        background-color: #2378e1 !important;
        color: white;
    }
    .btn-primary {
        background-color: #083CAE;
        border-color: #083CAE;
    }
    .btn-primary:hover {
        background-color: #062d82;
        border-color: #062d82;
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
        color: white;
    }
    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: white;
    }
    .badge-active {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-inactive {
        background-color: #dc3545;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .action-icons i {
        font-size: 16px;
        cursor: pointer;
        margin: 0 5px;
        transition: opacity 0.3s;
    }
    .action-icons i:hover {
        opacity: 0.7;
    }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    .fa-sync-alt { color: #083CAE; }
</style>

<!-- Bootstrap JS y dependencias -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Variable para almacenar el token CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

// ==================== FUNCIONES GENERALES ====================
function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// ==================== MONEDAS ====================
function cargarMonedas() {
    fetch('/api/monedas')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyMonedas');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No hay monedas registradas</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(moneda => `
                <tr>
                    <td>${moneda.codigo}</td>
                    <td>${moneda.nombre}</td>
                    <td>${moneda.simbolo}</td>
                    <td><span class="badge ${moneda.activa ? 'badge-active' : 'badge-inactive'}">${moneda.activa ? 'Activa' : 'Inactiva'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarMoneda(${moneda.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarMoneda(${moneda.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyMonedas').innerHTML = '<tr><td colspan="5" style="text-align: center; color: red;">Error al cargar datos</td></tr>';
        });
}

function abrirModalMoneda() {
    document.getElementById('moneda_id').value = '';
    document.getElementById('moneda_codigo').value = '';
    document.getElementById('moneda_nombre').value = '';
    document.getElementById('moneda_simbolo').value = '';
    document.getElementById('moneda_activa').checked = true;
    new bootstrap.Modal(document.getElementById('modalMoneda')).show();
}

function editarMoneda(id) {
    fetch(`/api/monedas/${id}`)
        .then(response => response.json())
        .then(moneda => {
            document.getElementById('moneda_id').value = moneda.id;
            document.getElementById('moneda_codigo').value = moneda.codigo;
            document.getElementById('moneda_nombre').value = moneda.nombre;
            document.getElementById('moneda_simbolo').value = moneda.simbolo;
            document.getElementById('moneda_activa').checked = moneda.activa;
            new bootstrap.Modal(document.getElementById('modalMoneda')).show();
        });
}

function guardarMoneda() {
    const id = document.getElementById('moneda_id').value;
    const data = {
        codigo: document.getElementById('moneda_codigo').value,
        nombre: document.getElementById('moneda_nombre').value,
        simbolo: document.getElementById('moneda_simbolo').value,
        activa: document.getElementById('moneda_activa').checked
    };
    
    const url = id ? `/api/monedas/${id}` : '/api/monedas';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalMoneda')).hide();
            cargarMonedas();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarMoneda(id) {
    if (confirm('¿Está seguro de eliminar esta moneda?')) {
        fetch(`/api/monedas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarMonedas();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== TIPOS DE CAMBIO ====================
function cargarSelectMonedas(selectId) {
    fetch('/api/monedas')
        .then(response => response.json())
        .then(monedas => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Seleccionar...</option>' + 
                monedas.filter(m => m.activa).map(m => `<option value="${m.id}">${m.nombre} (${m.codigo})</option>`).join('');
        });
}

function cargarTiposCambio() {
    const fecha = document.getElementById('filtroFechaTC').value;
    let url = '/api/tipos-cambio';
    if (fecha) url += `?fecha=${fecha}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyTiposCambio');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No hay tipos de cambio registrados</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(tc => `
                <tr>
                    <td>${tc.moneda_origen?.nombre || '-'} (${tc.moneda_origen?.codigo || '-'})</td>
                    <td>${tc.moneda_destino?.nombre || '-'} (${tc.moneda_destino?.codigo || '-'})</td>
                    <td>${parseFloat(tc.tasa).toFixed(4)}</td>
                    <td>${tc.fecha}</td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarTipoCambio(${tc.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarTipoCambio(${tc.id})" title="Eliminar"></i>
                    </td>
                </table>
            `).join('');
        });
}

function filtrarTiposCambio() {
    cargarTiposCambio();
}

function abrirModalTipoCambio() {
    cargarSelectMonedas('tipocambio_origen');
    cargarSelectMonedas('tipocambio_destino');
    document.getElementById('tipocambio_id').value = '';
    document.getElementById('tipocambio_tasa').value = '';
    document.getElementById('tipocambio_fecha').value = new Date().toISOString().split('T')[0];
    new bootstrap.Modal(document.getElementById('modalTipoCambio')).show();
}

function editarTipoCambio(id) {
    fetch(`/api/tipos-cambio/${id}`)
        .then(response => response.json())
        .then(tc => {
            cargarSelectMonedas('tipocambio_origen', tc.moneda_origen_id);
            cargarSelectMonedas('tipocambio_destino', tc.moneda_destino_id);
            document.getElementById('tipocambio_id').value = tc.id;
            document.getElementById('tipocambio_tasa').value = tc.tasa;
            document.getElementById('tipocambio_fecha').value = tc.fecha;
            new bootstrap.Modal(document.getElementById('modalTipoCambio')).show();
        });
}

function guardarTipoCambio() {
    const id = document.getElementById('tipocambio_id').value;
    const data = {
        moneda_origen_id: document.getElementById('tipocambio_origen').value,
        moneda_destino_id: document.getElementById('tipocambio_destino').value,
        tasa: document.getElementById('tipocambio_tasa').value,
        fecha: document.getElementById('tipocambio_fecha').value
    };
    
    const url = id ? `/api/tipos-cambio/${id}` : '/api/tipos-cambio';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalTipoCambio')).hide();
            cargarTiposCambio();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarTipoCambio(id) {
    if (confirm('¿Está seguro de eliminar este tipo de cambio?')) {
        fetch(`/api/tipos-cambio/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarTiposCambio();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== BANCOS ====================
function cargarBancos() {
    fetch('/api/bancos')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyBancos');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay bancos registrados</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(banco => `
                <tr>
                    <td>${banco.nombre}</td>
                    <td>${banco.codigo || '-'}</td>
                    <td><span class="badge ${banco.activo ? 'badge-active' : 'badge-inactive'}">${banco.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarBanco(${banco.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarBanco(${banco.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        });
}

function abrirModalBanco() {
    document.getElementById('banco_id').value = '';
    document.getElementById('banco_nombre').value = '';
    document.getElementById('banco_codigo').value = '';
    document.getElementById('banco_activo').checked = true;
    new bootstrap.Modal(document.getElementById('modalBanco')).show();
}

function editarBanco(id) {
    fetch(`/api/bancos/${id}`)
        .then(response => response.json())
        .then(banco => {
            document.getElementById('banco_id').value = banco.id;
            document.getElementById('banco_nombre').value = banco.nombre;
            document.getElementById('banco_codigo').value = banco.codigo || '';
            document.getElementById('banco_activo').checked = banco.activo;
            new bootstrap.Modal(document.getElementById('modalBanco')).show();
        });
}

function guardarBanco() {
    const id = document.getElementById('banco_id').value;
    const data = {
        nombre: document.getElementById('banco_nombre').value,
        codigo: document.getElementById('banco_codigo').value,
        activo: document.getElementById('banco_activo').checked
    };
    
    const url = id ? `/api/bancos/${id}` : '/api/bancos';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalBanco')).hide();
            cargarBancos();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarBanco(id) {
    if (confirm('¿Está seguro de eliminar este banco?')) {
        fetch(`/api/bancos/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarBancos();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== MÉTODOS DE PAGO ====================
function cargarMetodosPago() {
    fetch('/api/metodos-pago')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyMetodosPago');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay métodos de pago registrados</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(mp => `
                <tr>
                    <td>${mp.nombre}</td>
                    <td>${mp.descripcion || '-'}</td>
                    <td><span class="badge ${mp.activo ? 'badge-active' : 'badge-inactive'}">${mp.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarMetodoPago(${mp.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarMetodoPago(${mp.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        });
}

function abrirModalMetodoPago() {
    document.getElementById('metodopago_id').value = '';
    document.getElementById('metodopago_nombre').value = '';
    document.getElementById('metodopago_descripcion').value = '';
    document.getElementById('metodopago_activo').checked = true;
    new bootstrap.Modal(document.getElementById('modalMetodoPago')).show();
}

function editarMetodoPago(id) {
    fetch(`/api/metodos-pago/${id}`)
        .then(response => response.json())
        .then(mp => {
            document.getElementById('metodopago_id').value = mp.id;
            document.getElementById('metodopago_nombre').value = mp.nombre;
            document.getElementById('metodopago_descripcion').value = mp.descripcion || '';
            document.getElementById('metodopago_activo').checked = mp.activo;
            new bootstrap.Modal(document.getElementById('modalMetodoPago')).show();
        });
}

function guardarMetodoPago() {
    const id = document.getElementById('metodopago_id').value;
    const data = {
        nombre: document.getElementById('metodopago_nombre').value,
        descripcion: document.getElementById('metodopago_descripcion').value,
        activo: document.getElementById('metodopago_activo').checked
    };
    
    const url = id ? `/api/metodos-pago/${id}` : '/api/metodos-pago';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalMetodoPago')).hide();
            cargarMetodosPago();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarMetodoPago(id) {
    if (confirm('¿Está seguro de eliminar este método de pago?')) {
        fetch(`/api/metodos-pago/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarMetodosPago();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== TIPOS DE INGRESO ====================
function cargarTiposIngreso() {
    fetch('/api/tipos-ingreso')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyTiposIngreso');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay tipos de ingreso registrados</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(ti => `
                <tr>
                    <td>${ti.nombre}</td>
                    <td>${ti.descripcion || '-'}</td>
                    <td><span class="badge ${ti.activo ? 'badge-active' : 'badge-inactive'}">${ti.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarTipoIngreso(${ti.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarTipoIngreso(${ti.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        });
}

function abrirModalTipoIngreso() {
    document.getElementById('tipoingreso_id').value = '';
    document.getElementById('tipoingreso_nombre').value = '';
    document.getElementById('tipoingreso_descripcion').value = '';
    document.getElementById('tipoingreso_activo').checked = true;
    new bootstrap.Modal(document.getElementById('modalTipoIngreso')).show();
}

function editarTipoIngreso(id) {
    fetch(`/api/tipos-ingreso/${id}`)
        .then(response => response.json())
        .then(ti => {
            document.getElementById('tipoingreso_id').value = ti.id;
            document.getElementById('tipoingreso_nombre').value = ti.nombre;
            document.getElementById('tipoingreso_descripcion').value = ti.descripcion || '';
            document.getElementById('tipoingreso_activo').checked = ti.activo;
            new bootstrap.Modal(document.getElementById('modalTipoIngreso')).show();
        });
}

function guardarTipoIngreso() {
    const id = document.getElementById('tipoingreso_id').value;
    const data = {
        nombre: document.getElementById('tipoingreso_nombre').value,
        descripcion: document.getElementById('tipoingreso_descripcion').value,
        activo: document.getElementById('tipoingreso_activo').checked
    };
    
    const url = id ? `/api/tipos-ingreso/${id}` : '/api/tipos-ingreso';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalTipoIngreso')).hide();
            cargarTiposIngreso();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarTipoIngreso(id) {
    if (confirm('¿Está seguro de eliminar este tipo de ingreso?')) {
        fetch(`/api/tipos-ingreso/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarTiposIngreso();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== TIPOS DE EGRESO ====================
function cargarTiposEgreso() {
    fetch('/api/tipos-egreso')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyTiposEgreso');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No hay tipos de egreso registrados</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(te => `
                <tr>
                    <td>${te.nombre}</td>
                    <td>${te.descripcion || '-'}</td>
                    <td><span class="badge ${te.activo ? 'badge-active' : 'badge-inactive'}">${te.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarTipoEgreso(${te.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarTipoEgreso(${te.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        });
}

function abrirModalTipoEgreso() {
    document.getElementById('tipoegreso_id').value = '';
    document.getElementById('tipoegreso_nombre').value = '';
    document.getElementById('tipoegreso_descripcion').value = '';
    document.getElementById('tipoegreso_activo').checked = true;
    new bootstrap.Modal(document.getElementById('modalTipoEgreso')).show();
}

function editarTipoEgreso(id) {
    fetch(`/api/tipos-egreso/${id}`)
        .then(response => response.json())
        .then(te => {
            document.getElementById('tipoegreso_id').value = te.id;
            document.getElementById('tipoegreso_nombre').value = te.nombre;
            document.getElementById('tipoegreso_descripcion').value = te.descripcion || '';
            document.getElementById('tipoegreso_activo').checked = te.activo;
            new bootstrap.Modal(document.getElementById('modalTipoEgreso')).show();
        });
}

function guardarTipoEgreso() {
    const id = document.getElementById('tipoegreso_id').value;
    const data = {
        nombre: document.getElementById('tipoegreso_nombre').value,
        descripcion: document.getElementById('tipoegreso_descripcion').value,
        activo: document.getElementById('tipoegreso_activo').checked
    };
    
    const url = id ? `/api/tipos-egreso/${id}` : '/api/tipos-egreso';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalTipoEgreso')).hide();
            cargarTiposEgreso();
            cargarSelectTiposEgreso(); // Recargar select para categorías
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarTipoEgreso(id) {
    if (confirm('¿Está seguro de eliminar este tipo de egreso?')) {
        fetch(`/api/tipos-egreso/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarTiposEgreso();
                cargarSelectTiposEgreso();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== CATEGORÍAS DE GASTO ====================
function cargarSelectTiposEgreso() {
    fetch('/api/tipos-egreso')
        .then(response => response.json())
        .then(tipos => {
            const select = document.getElementById('categoriagasto_tipo_egreso_id');
            select.innerHTML = '<option value="">Seleccionar...</option>' + 
                tipos.filter(t => t.activo).map(t => `<option value="${t.id}">${t.nombre}</option>`).join('');
            
            // También cargar el filtro
            const filtro = document.getElementById('filtroTipoEgreso');
            filtro.innerHTML = '<option value="">Todos</option>' + 
                tipos.map(t => `<option value="${t.id}">${t.nombre}</option>`).join('');
        });
}

function cargarCategoriasGasto() {
    const tipoEgresoId = document.getElementById('filtroTipoEgreso').value;
    let url = '/api/categorias-gasto';
    if (tipoEgresoId) url += `?tipo_egreso_id=${tipoEgresoId}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyCategoriasGasto');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No hay categorías registradas</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(cat => `
                <tr>
                    <td>${cat.nombre}</td>
                    <td>${cat.descripcion || '-'}</td>
                    <td>${cat.tipo_egreso?.nombre || '-'}</td>
                    <td><span class="badge ${cat.activo ? 'badge-active' : 'badge-inactive'}">${cat.activo ? 'Activo' : 'Inactivo'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarCategoriaGasto(${cat.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarCategoriaGasto(${cat.id})" title="Eliminar"></i>
                    </td>
                </tr>
            `).join('');
        });
}

function filtrarCategoriasGasto() {
    cargarCategoriasGasto();
}

function abrirModalCategoriaGasto() {
    cargarSelectTiposEgreso();
    document.getElementById('categoriagasto_id').value = '';
    document.getElementById('categoriagasto_nombre').value = '';
    document.getElementById('categoriagasto_descripcion').value = '';
    document.getElementById('categoriagasto_activo').checked = true;
    new bootstrap.Modal(document.getElementById('modalCategoriaGasto')).show();
}

function editarCategoriaGasto(id) {
    fetch(`/api/categorias-gasto/${id}`)
        .then(response => response.json())
        .then(cat => {
            cargarSelectTiposEgreso();
            setTimeout(() => {
                document.getElementById('categoriagasto_id').value = cat.id;
                document.getElementById('categoriagasto_nombre').value = cat.nombre;
                document.getElementById('categoriagasto_descripcion').value = cat.descripcion || '';
                document.getElementById('categoriagasto_tipo_egreso_id').value = cat.tipo_egreso_id;
                document.getElementById('categoriagasto_activo').checked = cat.activo;
                new bootstrap.Modal(document.getElementById('modalCategoriaGasto')).show();
            }, 500);
        });
}

function guardarCategoriaGasto() {
    const id = document.getElementById('categoriagasto_id').value;
    const data = {
        nombre: document.getElementById('categoriagasto_nombre').value,
        descripcion: document.getElementById('categoriagasto_descripcion').value,
        tipo_egreso_id: document.getElementById('categoriagasto_tipo_egreso_id').value,
        activo: document.getElementById('categoriagasto_activo').checked
    };
    
    const url = id ? `/api/categorias-gasto/${id}` : '/api/categorias-gasto';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('modalCategoriaGasto')).hide();
            cargarCategoriasGasto();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    });
}

function eliminarCategoriaGasto(id) {
    if (confirm('¿Está seguro de eliminar esta categoría?')) {
        fetch(`/api/categorias-gasto/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarCategoriasGasto();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

// ==================== INICIALIZACIÓN ====================
document.addEventListener('DOMContentLoaded', function() {
    // Cargar todos los datos
    cargarMonedas();
    cargarTiposCambio();
    cargarBancos();
    cargarMetodosPago();
    cargarTiposIngreso();
    cargarTiposEgreso();
    cargarSelectTiposEgreso();
    cargarCategoriasGasto();
});
</script>
@endsection