{{-- resources/views/administracion/cuentascontables/index.blade.php --}}
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
                                <td colspan="8" style="text-align: center;">Cargando...<\/td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Cuenta Contable -->
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

function getBadgeTipo(tipo) {
    const badges = {
        'activo': 'badge-activo',
        'pasivo': 'badge-pasivo',
        'capital': 'badge-capital',
        'ingreso': 'badge-ingreso',
        'gasto': 'badge-gasto',
        'costo': 'badge-costo'
    };
    return badges[tipo] || 'badge-secondary';
}

function cargarCuentas() {
    fetch('/api/cuentas-contables')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tbodyCuentas');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay cuentas registradas</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(cuenta => `
                <tr>
                    <td><strong>${cuenta.codigo}</strong></td>
                    <td>${cuenta.nombre}</td>
                    <td><span class="badge ${getBadgeTipo(cuenta.tipo)}">${cuenta.tipo.toUpperCase()}</span></td>
                    <td>${cuenta.naturaleza === 'deudora' ? 'Deudora' : 'Acreedora'}</td>
                    <td>${cuenta.nivel_texto || 'Nivel ' + cuenta.nivel}</td>
                    <td>${cuenta.auxiliar ? '<i class="fas fa-check-circle" style="color: #28a745;"></i> Sí' : '<i class="fas fa-times-circle" style="color: #dc3545;"></i> No'}</td>
                    <td><span class="badge ${cuenta.activa ? 'badge-active' : 'badge-inactive'}">${cuenta.activa ? 'Activa' : 'Inactiva'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarCuenta(${cuenta.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarCuenta(${cuenta.id})" title="Eliminar"></i>
                        <i class="fas fa-eye" onclick="verCuenta(${cuenta.id})" title="Ver"></i>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyCuentas').innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Error al cargar datos</td></tr>';
        });
}

function cargarCuentasPadre() {
    fetch('/api/cuentas-contables-padre')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('codigo_padre');
            select.innerHTML = '<option value="">Ninguna (Cuenta principal)</option>';
            data.forEach(cuenta => {
                const prefix = '—'.repeat((cuenta.nivel || 1) - 1);
                select.innerHTML += `<option value="${cuenta.codigo}">${prefix} ${cuenta.codigo} - ${cuenta.nombre}</option>`;
            });
        });
}

function abrirModalCuenta() {
    document.getElementById('cuenta_id').value = '';
    document.getElementById('codigo').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('tipo').value = '';
    document.getElementById('naturaleza').value = '';
    document.getElementById('nivel').value = '1';
    document.getElementById('auxiliar').checked = false;
    document.getElementById('activa').checked = true;
    document.getElementById('descripcion').value = '';
    cargarCuentasPadre();
    new bootstrap.Modal(document.getElementById('modalCuenta')).show();
}

function editarCuenta(id) {
    fetch(`/api/cuentas-contables/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            document.getElementById('cuenta_id').value = cuenta.id;
            document.getElementById('codigo').value = cuenta.codigo;
            document.getElementById('nombre').value = cuenta.nombre;
            document.getElementById('tipo').value = cuenta.tipo;
            document.getElementById('naturaleza').value = cuenta.naturaleza;
            document.getElementById('nivel').value = cuenta.nivel;
            document.getElementById('auxiliar').checked = cuenta.auxiliar;
            document.getElementById('activa').checked = cuenta.activa;
            document.getElementById('descripcion').value = cuenta.descripcion || '';
            cargarCuentasPadre();
            setTimeout(() => {
                document.getElementById('codigo_padre').value = cuenta.codigo_padre;
            }, 500);
            new bootstrap.Modal(document.getElementById('modalCuenta')).show();
        });
}

function verCuenta(id) {
    fetch(`/api/cuentas-contables/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            const badgeTipo = getBadgeTipo(cuenta.tipo);
            alert(`
Código: ${cuenta.codigo}
Nombre: ${cuenta.nombre}
Tipo: ${cuenta.tipo.toUpperCase()}
Naturaleza: ${cuenta.naturaleza === 'deudora' ? 'Deudora' : 'Acreedora'}
Nivel: ${cuenta.nivel_texto || 'Nivel ' + cuenta.nivel}
Auxiliar: ${cuenta.auxiliar ? 'Sí' : 'No'}
Estado: ${cuenta.activa ? 'Activa' : 'Inactiva'}
Descripción: ${cuenta.descripcion || 'Sin descripción'}
            `);
        });
}

function guardarCuenta() {
    const id = document.getElementById('cuenta_id').value;
    const data = {
        codigo: document.getElementById('codigo').value,
        nombre: document.getElementById('nombre').value,
        tipo: document.getElementById('tipo').value,
        naturaleza: document.getElementById('naturaleza').value,
        codigo_padre: document.getElementById('codigo_padre').value || null,
        nivel: document.getElementById('nivel').value,
        auxiliar: document.getElementById('auxiliar').checked,
        activa: document.getElementById('activa').checked,
        descripcion: document.getElementById('descripcion').value
    };
    
    const url = id ? `/api/cuentas-contables/${id}` : '/api/cuentas-contables';
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
    if (confirm('¿Está seguro de eliminar esta cuenta contable?')) {
        fetch(`/api/cuentas-contables/${id}`, {
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
    link.download = 'cuentas_contables.xls';
    link.click();
    mostrarNotificacion('Exportando a Excel...', 'success');
}

// Buscador
document.getElementById('buscador').addEventListener('keyup', function() {
    const termino = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tbodyCuentas tr');
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(termino) ? '' : 'none';
    });
});

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    cargarCuentas();
});
</script>
@endsection