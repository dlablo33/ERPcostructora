@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 28px; text-align: center;">
                    Pólizas Contables
                </h1>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div><input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;"></div>
                        <div><input type="date" id="fechaFin" value="2026-01-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;"></div>
                        
                        <div>
                            <select id="filtroProyecto" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                                <option value="">Todos los proyectos</option>
                            </select>
                        </div>
                        
                        <div><button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; cursor: pointer; color: #083CAE;"><i class="fas fa-plus"></i></button></div>
                        <div><button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; color: #083CAE;"><i class="fas fa-file-excel"></i> Excel</button></div>
                        <div><button id="btnColumnas" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; color: #083CAE;"><i class="fas fa-columns"></i> Columnas</button></div>
                        <div style="position: relative;"><i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i><input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;"></div>
                    </div>
                </div>

                <!-- Tabla de Pólizas -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaPolizas" style="width: 100%; margin-bottom: 0; font-size: 13px;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="width: 40px; text-align: center;"><i class="fas fa-check-circle"></i></th>
                                <th style="width: 90px;">Folio</th>
                                <th style="width: 100px;">Estatus</th>
                                <th style="width: 95px;">Fecha</th>
                                <th style="min-width: 220px;">Descripción</th>
                                <th style="width: 110px;">Origen</th>
                                <th style="width: 95px;">Folio Origen</th>
                                <th style="width: 70px;">Tipo</th>
                                <th style="width: 80px;">Carta Porte</th>
                                <th style="width: 130px;">Proyecto</th>
                                <th style="width: 115px; text-align: right;">Cargos</th>
                                <th style="width: 115px; text-align: right;">Abonos</th>
                                <th style="width: 70px; text-align: center; position: sticky; right: 0; background-color: #2378e1; z-index: 30;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="13" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...<\/td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="10" style="text-align: right;">TOTALES:</td>
                                <td id="totalCargos" style="text-align: right;">$0.00<\/td>
                                <td id="totalAbonos" style="text-align: right;">$0.00<\/td>
                                <td style="text-align: right;">&nbsp;<\/td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div id="paginacionContainer" style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 10px;">
                    <button class="btn-pagina" data-page="first" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                    <button class="btn-pagina" data-page="prev" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                    <span id="paginaActual" style="background-color: #2378e1; color: white; padding: 5px 10px; border-radius: 4px;">1</span>
                    <span>de</span>
                    <span id="totalPaginas">1</span>
                    <button class="btn-pagina" data-page="next" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                    <button class="btn-pagina" data-page="last" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-right"></i></button>
                    <span id="paginacionInfo" style="color: #2378e1;">Mostrando 0-0 de 0 registros</span>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR PÓLIZA -->
<div id="modalPoliza" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; overflow-y: auto;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 1000px; max-height: 90%; overflow-y: auto; margin: 20px;">
        <div style="padding: 20px; border-bottom: 2px solid #083CAE;">
            <h2 id="modalTitulo" style="color: #083CAE; margin: 0;">Nueva Póliza</h2>
            <button id="btnCerrarModal" style="float: right; background: none; border: none; font-size: 24px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <form id="formPoliza">
                @csrf
                <input type="hidden" id="poliza_id" name="poliza_id">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div><label style="font-weight: 600; margin-bottom: 5px; display: block;">Fecha *</label><input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></div>
                    <div><label style="font-weight: 600; margin-bottom: 5px; display: block;">Origen</label>
                        <select id="origen" name="origen" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Facturación">Facturación</option>
                            <option value="Gastos">Gastos</option>
                            <option value="Cuentas por Pagar">Cuentas por Pagar</option>
                            <option value="Nómina">Nómina</option>
                            <option value="Contabilidad">Contabilidad</option>
                            <option value="Proyectos">Proyectos</option>
                            <option value="Ajustes">Ajustes</option>
                        </select>
                    </div>
                    <div><label style="font-weight: 600; margin-bottom: 5px; display: block;">Folio Origen</label><input type="text" id="origen_id" name="origen_id" placeholder="Ej: FAC-001" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></div>
                    <div><label style="font-weight: 600; margin-bottom: 5px; display: block;">Proyecto</label>
                        <select id="proyecto_id" name="proyecto_id" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Sin proyecto</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 20px;"><label style="font-weight: 600; margin-bottom: 5px; display: block;">Descripción *</label><textarea id="descripcion" name="descripcion" rows="2" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea></div>
                <h3 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-list-ol"></i> Movimientos Contables</h3>
                <div class="table-responsive" style="margin-bottom: 20px;">
                    <table class="table table-bordered" id="tablaMovimientos" style="font-size: 13px;">
                        <thead style="background-color: #083CAE; color: white;">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Cuenta Contable</th>
                                <th style="width: 150px;">Debe</th>
                                <th style="width: 150px;">Haber</th>
                                <th>Descripción</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="movimientosBody"></tbody>
                        <tfoot>
                            <tr><td colspan="6"><button type="button" id="btnAgregarMovimiento" class="btn" style="background-color: #28a745; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar Movimiento</button><\/td></tr>
                            <tr style="background-color: #e9ecef; font-weight: bold;">
                                <td colspan="2" style="text-align: right;">TOTALES:<\/td>
                                <td id="totalDebe" style="text-align: right;">$0.00<\/td>
                                <td id="totalHaber" style="text-align: right;">$0.00<\/td>
                                <td id="diferencia" style="text-align: right; color: green;">Balanceado: $0.00<\/td>
                                <td><\/td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" id="btnCancelarModal" class="btn" style="background-color: #6c757d; color: white; border: none; padding: 10px 25px; border-radius: 4px; cursor: pointer;">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn" style="background-color: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 4px; cursor: pointer;">Guardar Póliza</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="modalEliminar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 10000; justify-content: center; align-items: center;">
    <div style="background-color: white; border-radius: 8px; padding: 25px; width: 400px; max-width: 90%;">
        <h3 style="color: #083CAE; margin-bottom: 15px;">Confirmar eliminación</h3>
        <p>¿Está seguro de que desea eliminar esta póliza?</p>
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
            <button id="btnCancelarEliminar" style="background-color: #6c757d; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnConfirmarEliminar" style="background-color: #dc3545; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">Eliminar</button>
        </div>
    </div>
</div>

<!-- Modal selector de columnas -->
<div id="modalColumnas" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 10001; justify-content: center; align-items: center;">
    <div style="background-color: white; border-radius: 8px; padding: 25px; width: 400px; max-width: 90%;">
        <h3 style="color: #083CAE; margin-bottom: 15px;">Seleccionar Columnas</h3>
        <div id="listaColumnas"></div>
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
            <button id="btnCerrarColumnas" style="background-color: #6c757d; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">Cerrar</button>
            <button id="btnAplicarColumnas" style="background-color: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer;">Aplicar</button>
        </div>
    </div>
</div>

<style>
    .form-control:focus { outline: none; border-color: #083CAE; box-shadow: 0 0 0 2px rgba(8,60,174,0.2); }
    .btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 3px; display: inline-block; }
    .badge-registrado { background-color: #17a2b8; color: white; }
    .badge-contabilizado { background-color: #28a745; color: white; }
    .badge-cancelado { background-color: #dc3545; color: white; }
    .verificado-cuadro { width: 16px; height: 16px; display: inline-block; border-radius: 3px; }
    .verificado-verde { background-color: #28a745; }
    .verificado-rojo { background-color: #dc3545; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd !important; cursor: pointer; }
    .btn-pagina:hover { opacity: 0.7; }
    .table-responsive { overflow-x: auto; }
    .table th, .table td { white-space: nowrap; }
    .cuenta-select { width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; }
    .debe-input, .haber-input { text-align: right; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // ============================================
    // VARIABLES GLOBALES
    // ============================================
    let datosOriginales = [];
    let paginaActual = 1;
    let registrosPorPagina = 15;
    let polizaAEliminar = null;
    let contadorMovimientos = 0;
    let cuentasLista = [];
    let proyectosLista = [];
    
    // ============================================
    // FUNCIONES DE UTILIDAD
    // ============================================
    function formatCurrency(amount) {
        if (amount === undefined || amount === null || isNaN(amount)) return '$0.00';
        return '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('es-MX');
    }
    
    function getBadgeClass(estatus) {
        if (!estatus) return 'badge-registrado';
        switch(estatus) {
            case 'Contabilizado': return 'badge-contabilizado';
            case 'Cancelado': return 'badge-cancelado';
            default: return 'badge-registrado';
        }
    }
    
    // ============================================
    // CARGAR CUENTAS CONTABLES
    // ============================================
    async function cargarCuentas() {
        try {
            const response = await fetch('/api/cuentas-contables');
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            if (data.success && data.data && data.data.length > 0) {
                cuentasLista = data.data;
                console.log('Cuentas cargadas:', cuentasLista.length);
            } else {
                cuentasLista = [];
            }
        } catch (error) {
            console.error('Error cargando cuentas:', error);
            cuentasLista = [];
        }
    }
    
    // ============================================
    // CARGAR PROYECTOS
    // ============================================
    async function cargarProyectos() {
        try {
            const response = await fetch('/api/proyectos/lista');
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            
            if (data.success && data.data) {
                proyectosLista = data.data;
                console.log('Proyectos cargados:', proyectosLista.length);
            } else {
                proyectosLista = [];
            }
            
            const selectFiltro = document.getElementById('filtroProyecto');
            const selectModal = document.getElementById('proyecto_id');
            
            if (selectFiltro) {
                selectFiltro.innerHTML = '<option value="">Todos los proyectos</option>';
                proyectosLista.forEach(proyecto => {
                    selectFiltro.innerHTML += `<option value="${proyecto.id}">${proyecto.codigo} - ${proyecto.nombre}</option>`;
                });
            }
            
            if (selectModal) {
                selectModal.innerHTML = '<option value="">Sin proyecto</option>';
                proyectosLista.forEach(proyecto => {
                    selectModal.innerHTML += `<option value="${proyecto.id}">${proyecto.codigo} - ${proyecto.nombre}</option>`;
                });
            }
            
        } catch (error) {
            console.error('Error cargando proyectos:', error);
            proyectosLista = [];
        }
    }
    
    function getCuentasSelectOptions(selectedId = null) {
        let html = '<option value="">Seleccione una cuenta...</option>';
        if (cuentasLista && cuentasLista.length > 0) {
            cuentasLista.forEach(cuenta => {
                const selected = (selectedId == cuenta.id) ? 'selected' : '';
                html += `<option value="${cuenta.id}" ${selected}>${cuenta.codigo} - ${cuenta.nombre}</option>`;
            });
        } else {
            html += '<option value="" disabled>No hay cuentas registradas</option>';
        }
        return html;
    }
    
    // ============================================
    // MOVIMIENTOS
    // ============================================
    function agregarFilaMovimiento(cuentaId = null, debe = 0, haber = 0, descripcion = '') {
        contadorMovimientos++;
        const tbody = document.getElementById('movimientosBody');
        const newRow = document.createElement('tr');
        newRow.className = 'movimiento-fila';
        newRow.innerHTML = `
            <td style="text-align: center;">${contadorMovimientos}<\/td>
            <td><select class="cuenta-select form-control" style="width: 100%; padding: 6px;">${getCuentasSelectOptions(cuentaId)}</select><\/td>
            <td><input type="number" step="0.01" class="debe-input form-control" value="${debe}" style="text-align: right; padding: 6px;"><\/td>
            <td><input type="number" step="0.01" class="haber-input form-control" value="${haber}" style="text-align: right; padding: 6px;"><\/td>
            <td><input type="text" class="descripcion-input form-control" value="${descripcion.replace(/"/g, '&quot;')}" placeholder="Descripción" style="width: 100%; padding: 6px;"><\/td>
            <td style="text-align: center;">
                <button type="button" class="btn-eliminar-movimiento" style="background: none; border: none; color: #dc3545; cursor: pointer;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            <\/td>
        `;
        
        newRow.querySelector('.debe-input').addEventListener('input', calcularTotales);
        newRow.querySelector('.haber-input').addEventListener('input', calcularTotales);
        
        tbody.appendChild(newRow);
        calcularTotales();
    }
    
    function eliminarFilaMovimiento(btn) {
        const fila = btn.closest('.movimiento-fila');
        const tbody = document.getElementById('movimientosBody');
        if (tbody.children.length > 1) {
            fila.remove();
            Array.from(tbody.children).forEach((row, idx) => {
                row.querySelector('td:first-child').textContent = idx + 1;
            });
            contadorMovimientos = tbody.children.length;
            calcularTotales();
        } else {
            alert('Debe haber al menos un movimiento');
        }
    }
    
    function calcularTotales() {
        let totalDebe = 0, totalHaber = 0;
        document.querySelectorAll('.debe-input').forEach(input => { totalDebe += parseFloat(input.value) || 0; });
        document.querySelectorAll('.haber-input').forEach(input => { totalHaber += parseFloat(input.value) || 0; });
        const diferencia = totalDebe - totalHaber;
        
        document.getElementById('totalDebe').textContent = formatCurrency(totalDebe);
        document.getElementById('totalHaber').textContent = formatCurrency(totalHaber);
        const diferenciaSpan = document.getElementById('diferencia');
        if (Math.abs(diferencia) < 0.01) {
            diferenciaSpan.style.color = 'green';
            diferenciaSpan.innerHTML = `✅ Balanceado: ${formatCurrency(totalDebe)}`;
        } else {
            diferenciaSpan.style.color = 'red';
            diferenciaSpan.innerHTML = `⚠️ Desbalanceado: Diferencia ${formatCurrency(diferencia)}`;
        }
    }
    
    // ============================================
    // MODAL
    // ============================================
    function abrirModal(modo, data = null) {
        const modal = document.getElementById('modalPoliza');
        const titulo = document.getElementById('modalTitulo');
        
        document.getElementById('formPoliza').reset();
        document.getElementById('poliza_id').value = '';
        document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('origen').value = 'Facturación';
        document.getElementById('origen_id').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('proyecto_id').value = '';
        
        const tbody = document.getElementById('movimientosBody');
        tbody.innerHTML = '';
        contadorMovimientos = 0;
        agregarFilaMovimiento();
        
        if (modo === 'editar' && data) {
            titulo.textContent = 'Editar Póliza';
            document.getElementById('poliza_id').value = data.poliza_contable_id;
            document.getElementById('fecha').value = data.fecha;
            document.getElementById('origen').value = data.origen;
            document.getElementById('origen_id').value = data.folio_origen;
            document.getElementById('descripcion').value = data.descripcion;
            document.getElementById('proyecto_id').value = data.proyecto_id || '';
        } else {
            titulo.textContent = 'Nueva Póliza';
        }
        
        modal.style.display = 'flex';
        calcularTotales();
    }
    
    function cerrarModal() {
        document.getElementById('modalPoliza').style.display = 'none';
    }
    
    // ============================================
    // CRUD DE PÓLIZAS
    // ============================================
    async function guardarPoliza() {
        let totalDebe = 0, totalHaber = 0;
        document.querySelectorAll('.debe-input').forEach(input => { totalDebe += parseFloat(input.value) || 0; });
        document.querySelectorAll('.haber-input').forEach(input => { totalHaber += parseFloat(input.value) || 0; });
        const diferencia = totalDebe - totalHaber;
        
        if (Math.abs(diferencia) > 0.01) {
            alert('La póliza no está balanceada. Los cargos deben ser igual a los abonos.');
            return;
        }
        
        const movimientos = [];
        document.querySelectorAll('.movimiento-fila').forEach(fila => {
            const cuentaId = fila.querySelector('.cuenta-select').value;
            if (cuentaId) {
                movimientos.push({
                    cuenta_contable_id: cuentaId,
                    debe: parseFloat(fila.querySelector('.debe-input').value) || 0,
                    haber: parseFloat(fila.querySelector('.haber-input').value) || 0,
                    descripcion: fila.querySelector('.descripcion-input').value || ''
                });
            }
        });
        
        if (movimientos.length === 0) {
            alert('Agregue al menos un movimiento');
            return;
        }
        
        const polizaId = document.getElementById('poliza_id').value;
        const url = polizaId ? `/conta/poliza/${polizaId}` : '/conta/poliza';
        const data = {
            fecha: document.getElementById('fecha').value,
            origen: document.getElementById('origen').value,
            origen_id: document.getElementById('origen_id').value,
            descripcion: document.getElementById('descripcion').value,
            proyecto_id: document.getElementById('proyecto_id').value || null,
            total_debe: totalDebe,
            total_haber: totalHaber,
            movimientos: movimientos,
            _token: document.querySelector('meta[name="csrf-token"]').content,
            _method: polizaId ? 'PUT' : 'POST'
        };
        
        try {
            const response = await fetch(url, { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': data._token }, 
                body: JSON.stringify(data) 
            });
            const result = await response.json();
            if (result.success) {
                alert(polizaId ? 'Póliza actualizada exitosamente' : 'Póliza guardada exitosamente');
                cerrarModal();
                cargarDatos();
            } else {
                alert('Error: ' + (result.message || 'Error desconocido'));
            }
        } catch (error) {
            alert('Error al guardar: ' + error.message);
        }
    }
    
    async function cargarDatos() {
        const fechaInicio = document.getElementById('fechaInicio').value;
        const fechaFin = document.getElementById('fechaFin').value;
        const proyectoId = document.getElementById('filtroProyecto')?.value || '';
        
        let url = `/conta/poliza/data?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
        if (proyectoId && proyectoId !== '') {
            url += `&proyecto_id=${proyectoId}`;
        }
        
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            
            if (data.success) {
                datosOriginales = data.data || [];
                console.log('Datos cargados:', datosOriginales.length);
                paginaActual = 1;
                renderizarTabla();
            } else {
                console.error('Error en respuesta:', data);
                datosOriginales = [];
                renderizarTabla();
            }
        } catch (error) {
            console.error('Error cargando datos:', error);
            document.getElementById('tablaBody').innerHTML = '<tr><td colspan="13" style="text-align: center; padding: 40px; color: red;">Error al cargar datos: ' + error.message + '<\/td><\/tr>';
        }
    }
    
    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');
        if (!tbody) return;
        
        const start = (paginaActual - 1) * registrosPorPagina;
        const end = start + registrosPorPagina;
        const datosPagina = datosOriginales.slice(start, end);
        const totalPaginas = Math.ceil(datosOriginales.length / registrosPorPagina);
        
        if (datosOriginales.length === 0) {
            tbody.innerHTML = '<tr><td colspan="13" style="text-align: center; padding: 40px;">No hay datos disponibles<\/td><\/tr>';
            document.getElementById('totalCargos').textContent = '$0.00';
            document.getElementById('totalAbonos').textContent = '$0.00';
            actualizarPaginacion(0, totalPaginas);
            return;
        }
        
        let totalCargosGlobal = 0, totalAbonosGlobal = 0, html = '';
        
        datosPagina.forEach(poliza => {
            const cargo = parseFloat(poliza.monto_cargo) || 0;
            const abono = parseFloat(poliza.monto_abono) || 0;
            
            totalCargosGlobal += cargo;
            totalAbonosGlobal += abono;
            
            const badgeClass = getBadgeClass(poliza.estatus);
            const verificadoClass = poliza.verificado ? 'verificado-verde' : 'verificado-rojo';
            const folio = poliza.folio || '-';
            const descripcion = poliza.descripcion || '-';
            const origen = poliza.origen || '-';
            const folioOrigen = poliza.folio_origen || '-';
            const tipo = poliza.tipo_poliza || 'diario';
            const cartaPorte = poliza.carta_porte_id || '-';
            const proyecto = poliza.proyecto_nombre || poliza.proyecto || '-';
            
            html += `<tr>
                <td style="text-align: center;"><div class="verificado-cuadro ${verificadoClass}"></div><\/td>
                <td><strong>${folio}<\/strong><\/td>
                <td><span class="badge ${badgeClass}">${poliza.estatus || 'Registrado'}</span><\/td>
                <td>${formatDate(poliza.fecha)}<\/td>
                <td>${descripcion}<\/td>
                <td>${origen}<\/td>
                <td>${folioOrigen}<\/td>
                <td>${tipo}<\/td>
                <td>${cartaPorte}<\/td>
                <td>${proyecto}<\/td>
                <td style="text-align: right; font-weight: bold; color: #2e7d32;">${formatCurrency(cargo)}<\/td>
                <td style="text-align: right; font-weight: bold; color: #c62828;">${formatCurrency(abono)}<\/td>
                <td style="text-align: center;">
                    <i class="fas fa-edit" onclick="abrirModalEditar(${poliza.poliza_contable_id})" style="color: #083CAE; cursor: pointer; margin-right: 8px;" title="Editar"></i>
                    <i class="fas fa-trash-alt" onclick="mostrarModalEliminar(${poliza.poliza_contable_id})" style="color: #dc3545; cursor: pointer;" title="Eliminar"></i>
                <\/td>
            <\/tr>`;
        });
        
        tbody.innerHTML = html;
        document.getElementById('totalCargos').textContent = formatCurrency(totalCargosGlobal);
        document.getElementById('totalAbonos').textContent = formatCurrency(totalAbonosGlobal);
        actualizarPaginacion(datosOriginales.length, totalPaginas);
    }
    
    function actualizarPaginacion(totalRegistros, totalPaginas) {
        const start = (paginaActual - 1) * registrosPorPagina + 1;
        const end = Math.min(paginaActual * registrosPorPagina, totalRegistros);
        document.getElementById('paginaActual').textContent = paginaActual;
        document.getElementById('totalPaginas').textContent = totalPaginas || 1;
        document.getElementById('paginacionInfo').textContent = totalRegistros > 0 ? `Mostrando ${start}-${end} de ${totalRegistros} registros` : 'Mostrando 0-0 de 0 registros';
    }
    
    async function abrirModalEditar(id) {
        try {
            const response = await fetch(`/conta/poliza/${id}`);
            const data = await response.json();
            if (data.success) {
                const poliza = data.poliza;
                abrirModal('editar', {
                    poliza_contable_id: poliza.poliza_contable_id,
                    fecha: poliza.fecha,
                    origen: poliza.origen,
                    folio_origen: poliza.origen_id,
                    descripcion: poliza.descripcion,
                    proyecto_id: poliza.proyecto_id
                });
                if (data.movimientos && data.movimientos.length > 0) {
                    const tbody = document.getElementById('movimientosBody');
                    tbody.innerHTML = '';
                    contadorMovimientos = 0;
                    data.movimientos.forEach(mov => {
                        agregarFilaMovimiento(mov.cuenta_contable_id, mov.debe, mov.haber, mov.descripcion);
                    });
                }
            }
        } catch (error) {
            alert('Error al cargar la póliza: ' + error.message);
        }
    }
    
    function mostrarModalEliminar(id) {
        polizaAEliminar = id;
        document.getElementById('modalEliminar').style.display = 'flex';
    }
    
    async function eliminarPoliza() {
        if (!polizaAEliminar) return;
        try {
            const response = await fetch(`/conta/poliza/${polizaAEliminar}`, { 
                method: 'DELETE', 
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } 
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById('modalEliminar').style.display = 'none';
                cargarDatos();
                alert('Póliza eliminada exitosamente');
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Error al eliminar: ' + error.message);
        }
    }
    
    // ============================================
    // EVENTOS
    // ============================================
    document.getElementById('btnAgregar')?.addEventListener('click', () => abrirModal('nueva'));
    document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModal);
    document.getElementById('btnCancelarModal')?.addEventListener('click', cerrarModal);
    document.getElementById('btnAgregarMovimiento')?.addEventListener('click', () => agregarFilaMovimiento());
    document.getElementById('formPoliza')?.addEventListener('submit', (e) => { e.preventDefault(); guardarPoliza(); });
    document.getElementById('btnCancelarEliminar')?.addEventListener('click', () => document.getElementById('modalEliminar').style.display = 'none');
    document.getElementById('btnConfirmarEliminar')?.addEventListener('click', eliminarPoliza);
    document.getElementById('fechaInicio')?.addEventListener('change', cargarDatos);
    document.getElementById('fechaFin')?.addEventListener('change', cargarDatos);
    document.getElementById('filtroProyecto')?.addEventListener('change', () => {
        paginaActual = 1;
        cargarDatos();
    });
    document.getElementById('btnExcel')?.addEventListener('click', () => {
        const proyectoId = document.getElementById('filtroProyecto')?.value || '';
        let url = `/conta/poliza/excel?fecha_inicio=${document.getElementById('fechaInicio').value}&fecha_fin=${document.getElementById('fechaFin').value}`;
        if (proyectoId) url += `&proyecto_id=${proyectoId}`;
        window.location.href = url;
    });
    document.getElementById('btnColumnas')?.addEventListener('click', () => {
        alert('Selector de columnas en desarrollo');
    });
    
    document.querySelectorAll('.btn-pagina').forEach(btn => {
        btn.addEventListener('click', function() {
            const totalPaginas = Math.ceil(datosOriginales.length / registrosPorPagina);
            switch(this.dataset.page) {
                case 'first': paginaActual = 1; break;
                case 'prev': if (paginaActual > 1) paginaActual--; break;
                case 'next': if (paginaActual < totalPaginas) paginaActual++; break;
                case 'last': paginaActual = totalPaginas; break;
            }
            renderizarTabla();
        });
    });
    
    // Buscador
    let timeoutBuscador;
    const buscador = document.getElementById('buscador');
    if (buscador) {
        buscador.addEventListener('input', function(e) {
            clearTimeout(timeoutBuscador);
            timeoutBuscador = setTimeout(() => {
                const busqueda = e.target.value.toLowerCase();
                if (!busqueda) { 
                    cargarDatos(); 
                } else {
                    const filtrados = datosOriginales.filter(item => 
                        (item.descripcion?.toLowerCase() || '').includes(busqueda) ||
                        (item.origen?.toLowerCase() || '').includes(busqueda) ||
                        (item.folio_origen?.toLowerCase() || '').includes(busqueda) ||
                        (item.estatus?.toLowerCase() || '').includes(busqueda)
                    );
                    datosOriginales = filtrados;
                    paginaActual = 1;
                    renderizarTabla();
                }
            }, 300);
        });
    }
    
    // Inicializar
    async function inicializar() {
        await cargarCuentas();
        await cargarProyectos();
        await cargarDatos();
    }
    
    inicializar();
    
    window.abrirModalEditar = abrirModalEditar;
    window.mostrarModalEliminar = mostrarModalEliminar;
</script>
@endsection