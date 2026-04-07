@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Justificaciones y Permisos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;" 
                                    onclick="abrirModalJustificacion()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, tipo..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white;">
                    <table class="table" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_inicio">Fecha Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_fin">Fecha Fin</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias">Días</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="justificante">Justificante</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @if(isset($justificaciones) && $justificaciones->count() > 0)
                                @forelse($justificaciones as $item)
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><strong>{{ $item->folio }}</strong></td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $item->empleado_nombre }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $item->tipo }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $item->dias }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        @if($item->estatus == 'Aprobado')
                                            <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px;">Aprobado</span>
                                        @elseif($item->estatus == 'Pendiente')
                                            <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px;">Pendiente</span>
                                        @else
                                            <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px;">Rechazado</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        @if($item->tiene_justificante)
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 18px; cursor: pointer;" onclick="verJustificante({{ $item->id }})"></i>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $item->id }})"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRegistro({{ $item->id }})"></i>
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarRegistro({{ $item->id }})"></i>
                                        <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="imprimirRegistro({{ $item->id }})"></i>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px;">No hay registros de justificaciones y permisos</td>
                                </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px;">No hay registros de justificaciones y permisos</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(isset($justificaciones) && method_exists($justificaciones, 'links'))
                <div style="margin-top: 15px;">
                    {{ $justificaciones->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA JUSTIFICACIÓN -->
<div id="modalJustificacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;">Nueva Justificación / Permiso</h3>
            <button onclick="cerrarModalJustificacion()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="nuevoFolio" style="width: 100%; padding: 8px; background: #e9ecef;" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo *</label>
                    <select id="nuevoTipo" style="width: 100%; padding: 8px;">
                        <option value="">Seleccionar</option>
                        <option value="Permiso Médico">Permiso Médico</option>
                        <option value="Permiso Personal">Permiso Personal</option>
                        <option value="Permiso de Estudios">Permiso de Estudios</option>
                        <option value="Permiso por Luto">Permiso por Luto</option>
                        <option value="Incapacidad">Incapacidad</option>
                        <option value="Justificante de Retardo">Justificante de Retardo</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado *</label>
                    <select id="nuevoEmpleado" style="width: 100%; padding: 8px;">
                        <option value="">Seleccionar empleado</option>
                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicio *</label>
                    <input type="date" id="nuevaFechaInicio" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Fin *</label>
                    <input type="date" id="nuevaFechaFin" style="width: 100%; padding: 8px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días</label>
                    <input type="number" id="nuevosDias" style="width: 100%; padding: 8px; background: #e9ecef;" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="nuevoEstatus" style="width: 100%; padding: 8px;">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motivo</label>
                    <textarea id="nuevoMotivo" rows="3" style="width: 100%; padding: 8px;"></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Justificante</label>
                    <input type="file" id="nuevoJustificante" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalJustificacion()" style="padding: 8px 20px; background: white; border: 1px solid #ced4da; cursor: pointer;">Cancelar</button>
                <button onclick="guardarJustificacion()" style="padding: 8px 20px; background: var(--color-primary); color: white; border: none; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VER DETALLE -->
<div id="modalVerJustificacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px;">
        <div style="background: var(--color-primary); padding: 15px 20px; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;">Detalle de Justificación/Permiso</h3>
            <button onclick="cerrarModalVer()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;" id="detalleContenido"></div>
        <div style="padding: 20px; text-align: right;">
            <button onclick="cerrarModalVer()" style="padding: 8px 20px; background: white; border: 1px solid #ced4da; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div id="modalEditarJustificacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px;">
        <div style="background: var(--color-primary); padding: 15px 20px; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;">Editar Justificación / Permiso</h3>
            <button onclick="cerrarModalEditar()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="editId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div><label>Folio</label><input type="text" id="editFolio" style="width:100%; padding:8px; background:#e9ecef;" readonly></div>
                <div><label>Tipo</label>
                    <select id="editTipo" style="width:100%; padding:8px;">
                        <option value="Permiso Médico">Permiso Médico</option>
                        <option value="Permiso Personal">Permiso Personal</option>
                        <option value="Permiso de Estudios">Permiso de Estudios</option>
                        <option value="Permiso por Luto">Permiso por Luto</option>
                        <option value="Incapacidad">Incapacidad</option>
                        <option value="Justificante de Retardo">Justificante de Retardo</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div style="grid-column:span 2"><label>Empleado</label>
                    <select id="editEmpleado" style="width:100%; padding:8px;">
                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label>Fecha Inicio</label><input type="date" id="editFechaInicio" style="width:100%; padding:8px;"></div>
                <div><label>Fecha Fin</label><input type="date" id="editFechaFin" style="width:100%; padding:8px;"></div>
                <div><label>Días</label><input type="number" id="editDias" style="width:100%; padding:8px; background:#e9ecef;" readonly></div>
                <div><label>Estatus</label>
                    <select id="editEstatus" style="width:100%; padding:8px;">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </div>
                <div style="grid-column:span 2"><label>Motivo</label><textarea id="editMotivo" rows="3" style="width:100%; padding:8px;"></textarea></div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalEditar()" style="padding: 8px 20px; background: white; border: 1px solid #ced4da; cursor: pointer;">Cancelar</button>
                <button onclick="actualizarJustificacion()" style="padding: 8px 20px; background: var(--color-primary); color: white; border: none; cursor: pointer;">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table td:last-child i { margin: 0 5px; cursor: pointer; }
    .table td:last-child i:hover { transform: scale(1.2); }
    .table td:last-child i.fa-edit, .table td:last-child i.fa-eye, .table td:last-child i.fa-print { color: var(--color-primary); }
    .table td:last-child i.fa-trash { color: #dc3545; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); margin-right: 5px; }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-weight: bold; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let empleados = @json($empleados);
let justificacionesData = @json($justificaciones->items());

function formatearFecha(fechaISO) {
    if (!fechaISO) return '';
    const f = new Date(fechaISO);
    return `${f.getDate().toString().padStart(2,'0')}/${(f.getMonth()+1).toString().padStart(2,'0')}/${f.getFullYear()}`;
}

function calcularDias(fechaInicio, fechaFin) {
    if (!fechaInicio || !fechaFin) return 0;
    const inicio = new Date(fechaInicio), fin = new Date(fechaFin);
    return Math.ceil(Math.abs(fin - inicio) / (1000*60*60*24)) + 1;
}

async function verDetalle(id) {
    try {
        const res = await fetch(`/rh/justificantes/${id}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const r = await res.json();
        const badge = r.estatus === 'Aprobado' ? '<span style="background:#28a745;color:white;padding:4px 8px;border-radius:3px;">Aprobado</span>' :
                     (r.estatus === 'Pendiente' ? '<span style="background:#ffc107;color:#212529;padding:4px 8px;border-radius:3px;">Pendiente</span>' :
                      '<span style="background:#dc3545;color:white;padding:4px 8px;border-radius:3px;">Rechazado</span>');
        document.getElementById('detalleContenido').innerHTML = `
            <div style="margin-bottom: 10px;"><strong>Folio:</strong> ${r.folio}</div>
            <div style="margin-bottom: 10px;"><strong>Empleado:</strong> ${r.empleado_nombre}</div>
            <div style="margin-bottom: 10px;"><strong>Tipo:</strong> ${r.tipo}</div>
            <div style="margin-bottom: 10px;"><strong>Estatus:</strong> ${badge}</div>
            <div style="margin-bottom: 10px;"><strong>Fecha Inicio:</strong> ${formatearFecha(r.fecha_inicio)}</div>
            <div style="margin-bottom: 10px;"><strong>Fecha Fin:</strong> ${formatearFecha(r.fecha_fin)}</div>
            <div style="margin-bottom: 10px;"><strong>Días:</strong> ${r.dias}</div>
            <div style="margin-bottom: 10px;"><strong>Motivo:</strong> ${r.motivo || 'Sin motivo'}</div>
        `;
        document.getElementById('modalVerJustificacion').style.display = 'flex';
    } catch(e) { alert('Error al cargar detalle'); }
}

async function editarRegistro(id) {
    try {
        const res = await fetch(`/rh/justificantes/${id}`);
        const r = await res.json();
        document.getElementById('editId').value = r.id;
        document.getElementById('editFolio').value = r.folio;
        document.getElementById('editTipo').value = r.tipo;
        document.getElementById('editFechaInicio').value = r.fecha_inicio;
        document.getElementById('editFechaFin').value = r.fecha_fin;
        document.getElementById('editDias').value = r.dias;
        document.getElementById('editEstatus').value = r.estatus;
        document.getElementById('editMotivo').value = r.motivo || '';
        document.getElementById('editEmpleado').value = r.empleado_id;
        document.getElementById('modalEditarJustificacion').style.display = 'flex';
        
        document.getElementById('editFechaInicio').onchange = () => {
            const inicio = document.getElementById('editFechaInicio').value;
            const fin = document.getElementById('editFechaFin').value;
            if(inicio && fin) document.getElementById('editDias').value = calcularDias(inicio, fin);
        };
        document.getElementById('editFechaFin').onchange = () => {
            const inicio = document.getElementById('editFechaInicio').value;
            const fin = document.getElementById('editFechaFin').value;
            if(inicio && fin) document.getElementById('editDias').value = calcularDias(inicio, fin);
        };
    } catch(e) { alert('Error al cargar'); }
}

async function actualizarJustificacion() {
    const id = document.getElementById('editId').value;
    const data = {
        tipo: document.getElementById('editTipo').value,
        empleado_id: document.getElementById('editEmpleado').value,
        empleado_nombre: empleados.find(e => e.id == document.getElementById('editEmpleado').value)?.nombre,
        fecha_inicio: document.getElementById('editFechaInicio').value,
        fecha_fin: document.getElementById('editFechaFin').value,
        estatus: document.getElementById('editEstatus').value,
        motivo: document.getElementById('editMotivo').value
    };
    try {
        const res = await fetch(`/rh/justificantes/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(data)
        });
        const r = await res.json();
        if(r.success) location.reload();
        else alert(r.message);
    } catch(e) { alert('Error al actualizar'); }
}

async function eliminarRegistro(id) {
    if(confirm('¿Eliminar este registro?')) {
        const res = await fetch(`/rh/justificantes/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const r = await res.json();
        if(r.success) location.reload();
        else alert(r.message);
    }
}

function imprimirRegistro(id) { window.open(`/rh/justificantes/${id}/print`, '_blank'); }
function verJustificante(id) { window.open(`/rh/justificantes/${id}/justificante`, '_blank'); }

async function guardarJustificacion() {
    const tipo = document.getElementById('nuevoTipo').value;
    const empleadoId = document.getElementById('nuevoEmpleado').value;
    const fechaInicio = document.getElementById('nuevaFechaInicio').value;
    const fechaFin = document.getElementById('nuevaFechaFin').value;
    const estatus = document.getElementById('nuevoEstatus').value;
    const motivo = document.getElementById('nuevoMotivo').value;
    
    if (!tipo || !empleadoId || !fechaInicio || !fechaFin) {
        alert('Por favor complete todos los campos obligatorios');
        return;
    }
    
    const emp = empleados.find(e => e.id == empleadoId);
    if (!emp) {
        alert('Empleado no encontrado');
        return;
    }
    
    const dias = calcularDias(fechaInicio, fechaFin);
    
    const formData = new FormData();
    formData.append('tipo', tipo);
    formData.append('empleado_id', empleadoId);
    formData.append('empleado_nombre', emp.nombre);
    formData.append('fecha_inicio', fechaInicio);
    formData.append('fecha_fin', fechaFin);
    formData.append('dias', dias);
    formData.append('estatus', estatus);
    formData.append('motivo', motivo);
    
    const file = document.getElementById('nuevoJustificante').files[0];
    if (file) {
        formData.append('justificante', file);
    }
    
    try {
        const response = await fetch('/rh/justificantes', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Justificación guardada exitosamente');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Error desconocido'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar: ' + error.message);
    }
}

function abrirModalJustificacion() {
    const maxFolio = justificacionesData.length > 0 ? Math.max(...justificacionesData.map(j => parseInt(j.folio.replace('JP-','')))) : 1000;
    document.getElementById('nuevoFolio').value = 'JP-' + (maxFolio + 1);
    document.getElementById('nuevoTipo').value = '';
    document.getElementById('nuevoEmpleado').value = '';
    document.getElementById('nuevaFechaInicio').value = '';
    document.getElementById('nuevaFechaFin').value = '';
    document.getElementById('nuevoEstatus').value = 'Pendiente';
    document.getElementById('nuevoMotivo').value = '';
    document.getElementById('nuevosDias').value = '';
    document.getElementById('nuevoJustificante').value = '';
    
    document.getElementById('nuevaFechaInicio').onchange = () => {
        const inicio = document.getElementById('nuevaFechaInicio').value;
        const fin = document.getElementById('nuevaFechaFin').value;
        if(inicio && fin) document.getElementById('nuevosDias').value = calcularDias(inicio, fin);
    };
    document.getElementById('nuevaFechaFin').onchange = () => {
        const inicio = document.getElementById('nuevaFechaInicio').value;
        const fin = document.getElementById('nuevaFechaFin').value;
        if(inicio && fin) document.getElementById('nuevosDias').value = calcularDias(inicio, fin);
    };
    document.getElementById('modalJustificacion').style.display = 'flex';
}

function cerrarModalJustificacion() { document.getElementById('modalJustificacion').style.display = 'none'; }
function cerrarModalVer() { document.getElementById('modalVerJustificacion').style.display = 'none'; }
function cerrarModalEditar() { document.getElementById('modalEditarJustificacion').style.display = 'none'; }

// Buscador
document.getElementById('buscador')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#tablaBody tr');
    let count = 0;
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        if(text.includes(term)) { row.style.display = ''; count++; }
        else row.style.display = 'none';
    });
});

// Cerrar modales con ESC
document.addEventListener('keydown', e => { if(e.key === 'Escape') { cerrarModalJustificacion(); cerrarModalVer(); cerrarModalEditar(); } });

// Drag & drop y selector de columnas
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        container.innerHTML = '';
        if(columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }
    
    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };
    
    document.addEventListener('dragstart', (e) => {
        if(e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });
    
    const grupoAgrupacion = document.getElementById('grupoAgrupacion');
    if(grupoAgrupacion) {
        grupoAgrupacion.addEventListener('dragover', (e) => e.preventDefault());
        grupoAgrupacion.addEventListener('drop', (e) => {
            e.preventDefault();
            const columna = e.dataTransfer.getData('text/plain');
            if(columna && !columnasAgrupadas.includes(columna)) {
                columnasAgrupadas.push(columna);
                actualizarGrupoColumnas();
            }
        });
    }
    
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        if(selector.style.display === 'block') {
            const columnas = ['folio', 'empleado', 'tipo', 'fecha_inicio', 'fecha_fin', 'dias', 'estatus', 'justificante'];
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" id="chk_${col}" data-columna="${col}" checked style="margin-right: 8px;">
                    <label style="font-size: 12px;">${col.replace('_',' ').toUpperCase()}</label>
                </div>
            `).join('');
        }
    };
    
    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };
    
    document.addEventListener('click', function(e) {
        if(!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });
    
    document.getElementById('btnExcel')?.addEventListener('click', () => alert('Exportar a Excel - Total: ' + justificacionesData.length));
});
</script>
@endsection