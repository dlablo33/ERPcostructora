{{-- resources/views/administracion/cuentasavanzadas/registrocuenta.blade.php --}}
@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 28px; text-align: center;">
                    Registro de Cuentas Contables
                </h1>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-primary" onclick="abrirModalCuenta()" style="background-color: #083CAE; border: none;">
                            <i class="fas fa-plus"></i> Nueva Cuenta
                        </button>
                        <button class="btn btn-info" onclick="exportarExcel()" style="background-color: #2CBF1F; border: none;">
                            <i class="fas fa-file-excel"></i>
                        </button>
                    </div>
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar cuenta..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 250px;">
                    </div>
                </div>

                <!-- Tabla de Cuentas Contables -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaCuentas" style="width: 100%; font-size: 13px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Naturaleza</th>
                                <th>Nivel</th>
                                <th>¿Auxiliar?</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyCuentas">
                            <tr>
                                <td colspan="8" style="text-align: center;">Cargando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================= -->
<!-- Modal para Crear/Editar Cuenta -->
<!-- ============================= -->
<div class="modal fade" id="modalCuenta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-book"></i> Cuenta Contable</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCuenta">
                    <input type="hidden" id="cuenta_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Código <span class="text-danger">*</span></label>
                            <input type="text" id="codigo" class="form-control" required>
                            <small class="text-muted">Ej: 1-01-001</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="nombre" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tipo <span class="text-danger">*</span></label>
                            <select id="tipo" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="activo">Activo</option>
                                <option value="pasivo">Pasivo</option>
                                <option value="capital">Capital</option>
                                <option value="ingreso">Ingreso</option>
                                <option value="gasto">Gasto</option>
                                <option value="costo">Costo</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Naturaleza <span class="text-danger">*</span></label>
                            <select id="naturaleza" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="deudora">Deudora</option>
                                <option value="acreedora">Acreedora</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Padre</label>
                            <select id="codigo_padre" class="form-control">
                                <option value="">Ninguna (Cuenta principal)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nivel <span class="text-danger">*</span></label>
                            <select id="nivel" class="form-control" required>
                                <option value="1">1 - Principal</option>
                                <option value="2">2 - Subcuenta</option>
                                <option value="3">3 - Auxiliar</option>
                                <option value="4">4 - Detalle</option>
                                <option value="5">5 - Analítico</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="auxiliar" class="form-check-input">
                                <label class="form-check-label">¿Es cuenta auxiliar?</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="activa" class="form-check-input" checked>
                                <label class="form-check-label">Activa</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCuenta()" style="background-color: #083CAE;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================= -->
<!-- Modal para VER Cuenta (alineado al sistema) -->
<!-- ============================= -->
<div class="modal fade" id="modalVerCuenta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Ver Cuenta Contable</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formVerCuenta">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Código</label>
                            <input type="text" id="ver_codigo" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" id="ver_nombre" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tipo</label>
                            <input type="text" id="ver_tipo" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Naturaleza</label>
                            <input type="text" id="ver_naturaleza" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Padre</label>
                            <input type="text" id="ver_padre" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nivel</label>
                            <input type="text" id="ver_nivel" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>¿Es cuenta auxiliar?</label>
                            <input type="text" id="ver_auxiliar" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Estado</label>
                            <input type="text" id="ver_estado" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea id="ver_descripcion" class="form-control" rows="3" readonly></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
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
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-pasivo {
        background-color: #dc3545;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-capital {
        background-color: #17a2b8;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-ingreso {
        background-color: #28a745;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-gasto {
        background-color: #ffc107;
        color: #000;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
    }
    .badge-costo {
        background-color: #6c757d;
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
    #tablaCuentas tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- ⚠️ CACHE BUSTING: fuerza al navegador a recargar el JS cuando cambie el archivo --}}
<script src="{{ asset('js/cuentas-contables.js') }}?v={{ filemtime(public_path('js/cuentas-contables.js')) }}"></script>
@endsection