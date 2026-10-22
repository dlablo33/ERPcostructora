/**
 * Cuentas Contables - JS separado para evitar caché del navegador
 */
(function() {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    /* ============================
       Notificaciones
       ============================ */
    function mostrarNotificacion(mensaje, tipo) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 3000);
    }

    /* ============================
       Helpers de badges
       ============================ */
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

    /* ============================
       Fetch con credentials
       ============================ */
    function fetchJSON(url, options = {}) {
        return fetch(url, {
            ...options,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {})
            },
            credentials: 'same-origin'
        });
    }

    /* ============================
       Cargar listado
       ============================ */
    function cargarCuentas() {
        fetchJSON('/api/cuentas-contables')
        .then(async response => {
            const text = await response.text();
            console.log('📡 status:', response.status);
            console.log('📦 body (primeros 300):', text.substring(0, 300));

            if (!response.ok) {
                throw new Error(`HTTP ${response.status} - ${text.substring(0, 150)}`);
            }
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Respuesta no es JSON. Recibido: ' + text.substring(0, 150));
            }
        })
        .then(data => {
            let cuentas = data;
            if (data && !Array.isArray(data) && Array.isArray(data.data)) {
                cuentas = data.data;
            }

            const tbody = document.getElementById('tbodyCuentas');
            if (!Array.isArray(cuentas) || cuentas.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center;">No hay cuentas registradas</td></tr>';
                return;
            }

            tbody.innerHTML = cuentas.map(cuenta => {
                const tipo       = cuenta.tipo       || null;
                const naturaleza = cuenta.naturaleza || null;
                const nivel      = cuenta.nivel      != null ? cuenta.nivel : null;
                const auxiliar   = cuenta.auxiliar === true || cuenta.auxiliar === 1 || cuenta.auxiliar === '1';
                const activa     = cuenta.activa === true || cuenta.activa === 1 || cuenta.activa === '1';

                const badgeTipo = tipo
                    ? `<span class="badge ${getBadgeTipo(tipo)}">${String(tipo).toUpperCase()}</span>`
                    : '—';

                const natTexto = naturaleza === 'deudora'
                    ? 'Deudora'
                    : naturaleza === 'acreedora'
                        ? 'Acreedora'
                        : '—';

                return `
                <tr>
                    <td><strong>${cuenta.codigo || ''}</strong></td>
                    <td>${cuenta.nombre || ''}</td>
                    <td>${badgeTipo}</td>
                    <td>${natTexto}</td>
                    <td>${nivel != null ? 'Nivel ' + nivel : '—'}</td>
                    <td>${auxiliar ? '<i class="fas fa-check-circle" style="color: #28a745;"></i> Sí' : '<i class="fas fa-times-circle" style="color: #dc3545;"></i> No'}</td>
                    <td><span class="badge ${activa ? 'badge-active' : 'badge-inactive'}">${activa ? 'Activa' : 'Inactiva'}</span></td>
                    <td class="action-icons">
                        <i class="fas fa-edit" onclick="editarCuenta(${cuenta.id})" title="Editar"></i>
                        <i class="fas fa-trash-alt" onclick="eliminarCuenta(${cuenta.id})" title="Eliminar"></i>
                        <i class="fas fa-eye" onclick="verCuenta(${cuenta.id})" title="Ver"></i>
                    </td>
                </tr>
                `;
            }).join('');
        })
        .catch(error => {
            console.error('❌ Error cargando cuentas:', error);
            document.getElementById('tbodyCuentas').innerHTML =
                `<tr><td colspan="8" style="text-align: center; color: red;">Error al cargar datos: ${error.message}</td></tr>`;
        });
    }

    /* ============================
       Cargar cuentas padre
       ============================ */
    function cargarCuentasPadre() {
        fetchJSON('/api/cuentas-contables-padre')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('codigo_padre');
            select.innerHTML = '<option value="">Ninguna (Cuenta principal)</option>';
            let cuentas = data;
            if (data && !Array.isArray(data) && Array.isArray(data.data)) {
                cuentas = data.data;
            }
            if (Array.isArray(cuentas)) {
                cuentas.forEach(cuenta => {
                    const prefix = '—'.repeat((cuenta.nivel || 1) - 1);
                    select.innerHTML += `<option value="${cuenta.codigo}">${prefix} ${cuenta.codigo} - ${cuenta.nombre}</option>`;
                });
            }
        })
        .catch(error => console.error('Error cargando cuentas padre:', error));
    }

    /* ============================
       Abrir modal Crear
       ============================ */
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
        document.getElementById('codigo_padre').value = '';
        cargarCuentasPadre();
        new bootstrap.Modal(document.getElementById('modalCuenta')).show();
    }

    /* ============================
       Editar
       ============================ */
    function editarCuenta(id) {
        fetchJSON(`/api/cuentas-contables/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            document.getElementById('cuenta_id').value = cuenta.id;
            document.getElementById('codigo').value = cuenta.codigo;
            document.getElementById('nombre').value = cuenta.nombre;
            document.getElementById('tipo').value = cuenta.tipo;
            document.getElementById('naturaleza').value = cuenta.naturaleza;
            document.getElementById('nivel').value = cuenta.nivel;
            document.getElementById('auxiliar').checked = !!cuenta.auxiliar;
            document.getElementById('activa').checked = !!cuenta.activa;
            document.getElementById('descripcion').value = cuenta.descripcion || '';

            cargarCuentasPadre();
            setTimeout(() => {
                document.getElementById('codigo_padre').value = cuenta.codigo_padre || '';
            }, 400);

            new bootstrap.Modal(document.getElementById('modalCuenta')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('No se pudo cargar la cuenta', 'danger');
        });
    }

    /* ============================
       Ver
       ============================ */
    function verCuenta(id) {
        fetchJSON(`/api/cuentas-contables/${id}`)
        .then(response => response.json())
        .then(cuenta => {
            const tipoTexto = (cuenta.tipo || '')
                .charAt(0).toUpperCase() + (cuenta.tipo || '').slice(1).toLowerCase();

            const padreTexto = cuenta.codigo_padre
                ? `${cuenta.codigo_padre} - ${cuenta.padre_nombre || ''}`.trim()
                : 'Ninguna (cuenta principal)';

            document.getElementById('ver_codigo').value       = cuenta.codigo || '';
            document.getElementById('ver_nombre').value       = cuenta.nombre || '';
            document.getElementById('ver_tipo').value         = tipoTexto || '—';
            document.getElementById('ver_naturaleza').value   = cuenta.naturaleza === 'deudora' ? 'Deudora' : (cuenta.naturaleza === 'acreedora' ? 'Acreedora' : '—');
            document.getElementById('ver_padre').value        = padreTexto;
            document.getElementById('ver_nivel').value        = cuenta.nivel != null ? 'Nivel ' + cuenta.nivel : '—';
            document.getElementById('ver_auxiliar').value     = cuenta.auxiliar ? 'Sí' : 'No';
            document.getElementById('ver_estado').value       = cuenta.activa ? 'Activa' : 'Inactiva';
            document.getElementById('ver_descripcion').value  = cuenta.descripcion || 'Sin descripción';

            new bootstrap.Modal(document.getElementById('modalVerCuenta')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('No se pudo cargar el detalle', 'danger');
        });
    }

    /* ============================
       Guardar
       ============================ */
    function guardarCuenta() {
        const id = document.getElementById('cuenta_id').value;
        const data = {
            codigo:       document.getElementById('codigo').value.trim(),
            nombre:       document.getElementById('nombre').value.trim(),
            tipo:         document.getElementById('tipo').value,
            naturaleza:   document.getElementById('naturaleza').value,
            codigo_padre: document.getElementById('codigo_padre').value || null,
            nivel:        parseInt(document.getElementById('nivel').value, 10),
            auxiliar:     document.getElementById('auxiliar').checked,
            activa:       document.getElementById('activa').checked,
            descripcion:  document.getElementById('descripcion').value
        };

        if (!data.codigo || !data.nombre || !data.tipo || !data.naturaleza) {
            mostrarNotificacion('Complete los campos obligatorios', 'warning');
            return;
        }

        const url    = id ? `/api/cuentas-contables/${id}` : '/api/cuentas-contables';
        const method = id ? 'PUT' : 'POST';

        fetchJSON(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const result = await response.json().catch(() => ({}));
            if (!response.ok) {
                mostrarNotificacion(result.message || `Error HTTP ${response.status}`, 'danger');
                return;
            }
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                bootstrap.Modal.getInstance(document.getElementById('modalCuenta')).hide();
                cargarCuentas();
            } else {
                mostrarNotificacion(result.message || 'No se pudo guardar', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error de conexión al guardar', 'danger');
        });
    }

    /* ============================
       Eliminar
       ============================ */
    function eliminarCuenta(id) {
        if (!confirm('¿Está seguro de eliminar esta cuenta contable?')) return;

        fetchJSON(`/api/cuentas-contables/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(async response => {
            const result = await response.json().catch(() => ({}));
            if (!response.ok) {
                mostrarNotificacion(result.message || 'No se pudo eliminar', 'danger');
                return;
            }
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarCuentas();
            } else {
                mostrarNotificacion(result.message || 'No se pudo eliminar', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error de conexión al eliminar', 'danger');
        });
    }

    /* ============================
       Exportar Excel
       ============================ */
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

    /* ============================
       Exponer funciones al window
       ============================ */
    window.abrirModalCuenta = abrirModalCuenta;
    window.editarCuenta      = editarCuenta;
    window.verCuenta         = verCuenta;
    window.guardarCuenta     = guardarCuenta;
    window.eliminarCuenta    = eliminarCuenta;
    window.exportarExcel     = exportarExcel;
    window.cargarCuentas     = cargarCuentas;

    /* ============================
       Buscador + Init
       ============================ */
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('keyup', function () {
                const termino = this.value.toLowerCase();
                document.querySelectorAll('#tbodyCuentas tr').forEach(fila => {
                    fila.style.display = fila.textContent.toLowerCase().includes(termino) ? '' : 'none';
                });
            });
        }
        cargarCuentas();
    });
})();