@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2 shadow-sm">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 28px; text-align: center;">
                     Registro de Cuentas Bancarias
                </h1>
            </div>

            <div class="card-body p-4" style="background-color: white;">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-primary" onclick="abrirModalCuenta()" style="background-color: #083CAE; border: none;">
                            <i class="fas fa-plus"></i> Nueva Cuenta Bancaria
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

                <!-- Tabla de Cuentas Bancarias -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaCuentas" style="width: 100%; font-size: 13px; background-color: white;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th>Banco</th>
                                <th>Número de Cuenta</th>
                                <th>CLABE</th>
                                <th>Titular</th>
                                <th>Moneda</th>
                                <th>Tipo</th>
                                <th>Cuenta Contable</th>
                                <th>Saldo Inicial</th>
                                <th>Saldo Actual</th>
                                <th>Proyecto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyCuentas">
                            <tr>
                                <td colspan="12" style="text-align: center;">Cargando...<\/td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Cuenta Bancaria -->
<div class="modal fade" id="modalCuenta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #083CAE; color: white;">
                <h5 class="modal-title"><i class="fas fa-university"></i> Cuenta Bancaria</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCuenta">
                    <input type="hidden" id="cuenta_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Banco <span class="text-danger">*</span></label>
                            <select id="banco_id" class="form-control" required>
                                <option value="">Seleccionar banco...</option>
                                @foreach($bancos ?? [] as $banco)
                                    <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                @endforeach
                            </select>
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
                            <label>Número de Cuenta <span class="text-danger">*</span></label>
                            <input type="text" id="numero_cuenta" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CLABE</label>
                            <input type="text" id="clabe" class="form-control" maxlength="18">
                            <small class="text-muted">18 dígitos</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Titular <span class="text-danger">*</span></label>
                            <input type="text" id="titular" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tipo de Cuenta</label>
                            <select id="tipo_cuenta" class="form-control">
                                <option value="cheques">Cheques</option>
                                <option value="ahorros">Ahorros</option>
                                <option value="inversion">Inversión</option>
                                <option value="credito">Crédito</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Proyecto (opcional)</label>
                            <select id="proyecto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Cuenta Contable</label>
                            <select id="cuenta_contable_id" class="form-control">
                                <option value="">Seleccionar cuenta contable...</option>
                                @foreach($cuentasContables ?? [] as $cuentaContable)
                                    <option value="{{ $cuentaContable->id }}">{{ $cuentaContable->codigo }} - {{ $cuentaContable->nombre }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Cuenta contable asociada para movimientos</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Saldo Inicial</label>
                            <input type="number" id="saldo_inicial" class="form-control" step="0.01" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check" style="margin-top: 35px;">
                                <input type="checkbox" id="activa" class="form-check-input" checked>
                                <label class="form-check-label">Cuenta Activa</label>
                            </div>
                        </div>
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

<style>
    .btn-primary { background-color: #083CAE; border-color: #083CAE; }
    .btn-primary:hover { background-color: #062d82; border-color: #062d82; }
    .btn-info { background-color: #17a2b8; border-color: #17a2b8; color: white; }
    .btn-info:hover { background-color: #138496; border-color: #138496; color: white; }
    .badge-active { background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
    .badge-inactive { background-color: #dc3545; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; }
    .action-icons i { font-size: 16px; cursor: pointer; margin: 0 5px; transition: opacity 0.3s; }
    .action-icons i:hover { opacity: 0.7; }
    .fa-edit { color: #ffc107; }
    .fa-trash-alt { color: #dc3545; }
    .fa-eye { color: #17a2b8; }
    #tablaCuentas tbody tr:hover { background-color: #f5f5f5; cursor: pointer; }
    .card {
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    .table th {
        font-weight: 600;
        font-size: 12px;
    }
    .table td {
        vertical-align: middle;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function mostrarNotificacion(mensaje, tipo) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

function cargarCuentas() {
    fetch('/api/cuentas-bancarias', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.getElementById('tbodyCuentas');
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="12" style="text-align: center;">No hay cuentas bancarias registradas<\/td></tr>';
            return;
        }
        tbody.innerHTML = data.map(cuenta => `
            <tr>
                <td>${cuenta.banco?.nombre || '-'}</td>
                <td>${cuenta.numero_cuenta}</td>
                <td>${cuenta.clabe || '-'}</td>
                <td>${cuenta.titular}</td>
                <td>${cuenta.moneda?.simbolo || cuenta.moneda?.codigo || '-'}</td>
                <td>${cuenta.tipo_cuenta ? cuenta.tipo_cuenta.toUpperCase() : '-'}</td>
                <td>${cuenta.cuenta_contable ? cuenta.cuenta_contable.codigo + ' - ' + cuenta.cuenta_contable.nombre : '-'}</td>
                <td>$${Number(cuenta.saldo_inicial).toLocaleString()}</td>
                <td style="font-weight: bold; color: ${Number(cuenta.saldo_actual) >= 0 ? '#28a745' : '#dc3545'};">$${Number(cuenta.saldo_actual).toLocaleString()}</td>
                <td>${cuenta.proyecto?.nombre || '-'}</td>
                <td><span class="badge ${cuenta.activa ? 'badge-active' : 'badge-inactive'}">${cuenta.activa ? 'Activa' : 'Inactiva'}</span></td>
                <td class="action-icons">
                    <i class="fas fa-edit" onclick="editarCuenta(${cuenta.id})" title="Editar"></i>
                    <i class="fas fa-trash-alt" onclick="eliminarCuenta(${cuenta.id})" title="Eliminar"></i>
                    <i class="fas fa-eye" onclick="verCuenta(${cuenta.id})" title="Ver"></i>
                    <i class="fas fa-sync-alt" onclick="actualizarSaldoCuenta(${cuenta.id})" title="Actualizar saldo" style="color: #083CAE;"></i>
                </td>
            </tr>
        `).join('');
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('tbodyCuentas').innerHTML = '<tr><td colspan="12" style="text-align: center; color: red;">Error al cargar datos<\/td></tr>';
    });
}

// Función para actualizar saldo de una cuenta específica
function actualizarSaldoCuenta(cuentaId) {
    fetch(`/api/cuentas-bancarias/${cuentaId}/actualizar-saldo`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion(result.message, 'success');
            cargarCuentas(); // Recargar la tabla
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al actualizar saldo', 'danger');
    });
}

function abrirModalCuenta() {
    document.getElementById('cuenta_id').value = '';
    document.getElementById('numero_cuenta').value = '';
    document.getElementById('clabe').value = '';
    document.getElementById('titular').value = '';
    document.getElementById('saldo_inicial').value = '0';
    document.getElementById('tipo_cuenta').value = 'cheques';
    document.getElementById('activa').checked = true;
    document.getElementById('banco_id').value = '';
    document.getElementById('moneda_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('cuenta_contable_id').value = '';
    new bootstrap.Modal(document.getElementById('modalCuenta')).show();
}

function editarCuenta(id) {
    fetch(`/api/cuentas-bancarias/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            document.getElementById('cuenta_id').value = cuenta.id;
            document.getElementById('banco_id').value = cuenta.banco_id;
            document.getElementById('moneda_id').value = cuenta.moneda_id;
            document.getElementById('numero_cuenta').value = cuenta.numero_cuenta;
            document.getElementById('clabe').value = cuenta.clabe || '';
            document.getElementById('titular').value = cuenta.titular;
            document.getElementById('tipo_cuenta').value = cuenta.tipo_cuenta || 'cheques';
            document.getElementById('proyecto_id').value = cuenta.proyecto_id || '';
            document.getElementById('cuenta_contable_id').value = cuenta.cuenta_contable_id || '';
            document.getElementById('saldo_inicial').value = cuenta.saldo_inicial;
            document.getElementById('activa').checked = cuenta.activa;
            new bootstrap.Modal(document.getElementById('modalCuenta')).show();
        });
}

function verCuenta(id) {
    fetch(`/api/cuentas-bancarias/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            mostrarNotificacion(`
Banco: ${cuenta.banco?.nombre}
Número: ${cuenta.numero_cuenta}
CLABE: ${cuenta.clabe || 'N/A'}
Titular: ${cuenta.titular}
Moneda: ${cuenta.moneda?.nombre}
Tipo: ${cuenta.tipo_cuenta || 'N/A'}
Cuenta Contable: ${cuenta.cuenta_contable?.codigo || 'N/A'} - ${cuenta.cuenta_contable?.nombre || 'N/A'}
Proyecto: ${cuenta.proyecto?.nombre || 'Ninguno'}
Saldo Inicial: $${Number(cuenta.saldo_inicial).toLocaleString()}
Saldo Actual: $${Number(cuenta.saldo_actual).toLocaleString()}
Estado: ${cuenta.activa ? 'Activa' : 'Inactiva'}`, 'info');
        });
}

function guardarCuenta() {
    const id = document.getElementById('cuenta_id').value;
    const data = {
        banco_id: document.getElementById('banco_id').value,
        moneda_id: document.getElementById('moneda_id').value,
        numero_cuenta: document.getElementById('numero_cuenta').value,
        clabe: document.getElementById('clabe').value,
        titular: document.getElementById('titular').value,
        tipo_cuenta: document.getElementById('tipo_cuenta').value,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        cuenta_contable_id: document.getElementById('cuenta_contable_id').value || null,
        saldo_inicial: document.getElementById('saldo_inicial').value,
        activa: document.getElementById('activa').checked
    };
    
    const url = id ? `/api/cuentas-bancarias/${id}` : '/api/cuentas-bancarias';
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
            bootstrap.Modal.getInstance(document.getElementById('modalCuenta')).hide();
            cargarCuentas();
        } else {
            mostrarNotificacion(result.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar', 'danger');
    });
}

function eliminarCuenta(id) {
    if (confirm('¿Está seguro de eliminar esta cuenta bancaria?')) {
        fetch(`/api/cuentas-bancarias/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarCuentas();
            } else {
                mostrarNotificacion(result.message, 'danger');
            }
        });
    }
}

function exportarExcel() {
    const tabla = document.getElementById('tablaCuentas');
    const html = tabla.outerHTML;
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'cuentas_bancarias.xls';
    link.click();
    mostrarNotificacion('Exportando a Excel...', 'success');
}

document.getElementById('buscador').addEventListener('keyup', function() {
    const termino = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tbodyCuentas tr');
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(termino) ? '' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    cargarCuentas();
});
</script>
@endsection