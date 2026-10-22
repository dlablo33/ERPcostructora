@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-tools"></i> Requisición y Devolución de Activos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Inicio</label>
                        <input type="date" id="fechaInicio" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-01') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Fecha Fin</label>
                        <input type="date" id="fechaFin" class="form-control" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Proyecto</label>
                        <select id="filtroProyecto" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los proyectos</option>
                            @isset($proyectos)
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Estatus</label>
                        <select id="filtroEstatus" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                            <option value="Asignada">Asignada</option>
                            <option value="Devuelta">Devuelta</option>
                            <option value="Activa">Activa (asignación)</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
                    <div>
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button id="btnNuevaRequisicion" onclick="abrirModalRequisicion()" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Requisición
                        </button>
                        
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-btn active" onclick="switchTab('requisiciones')" id="tabRequisiciones" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-clipboard-list"></i> Requisiciones
                    </button>
                    <button class="tab-btn" onclick="switchTab('devoluciones')" id="tabDevoluciones" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-undo-alt"></i> Devoluciones / Asignaciones
                    </button>
                </div>

                <!-- Panel Requisiciones -->
                <div id="panelRequisiciones" style="display: block;">
                    <div class="table-container">
                        <table class="table" id="tablaRequisiciones">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Solicitante</th>
                                    <th>Activo</th>
                                    <th>Cantidad</th>
                                    <th>Fecha Requerida</th>
                                    <th>Prioridad</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRequisiciones">
                                <tr><td colspan="10" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacionRequisiciones" style="margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;"></div>
                </div>

                <!-- Panel Devoluciones/Asignaciones -->
                <div id="panelDevoluciones" style="display: none;">
                    <div class="table-container">
                        <table class="table" id="tablaDevoluciones">
                            <thead>
                                <tr>
                                    <th>Folio Requisición</th>
                                    <th>Fecha Salida</th>
                                    <th>Proyecto</th>
                                    <th>Responsable</th>
                                    <th>Activo</th>
                                    <th style="text-align: right;">Horómetro/Km Salida</th>
                                    <th>Condición Salida</th>
                                    <th>Fecha Devolución</th>
                                    <th>Condición Devolución</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDevoluciones">
                                <tr><td colspan="11" style="text-align: center;">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacionDevoluciones" style="margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;"></div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- MODAL NUEVA REQUISICIÓN --}}
<div id="modalRequisicion" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 620px;">
        <div class="modal-header">
            <h3>Nueva Requisición de Activo</h3>
            <button onclick="cerrarModalRequisicion()" class="modal-close">✕</button>
        </div>
        <div class="modal-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label class="form-label">Proyecto <span style="color: red;">*</span></label>
                    <select id="reqProyecto" class="form-input" onchange="cargarPersonasProyecto('req')">
                        <option value="">Seleccionar proyecto</option>
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label class="form-label">Fecha Requerida <span style="color: red;">*</span></label>
                    <input type="date" id="reqFechaRequerida" class="form-input" value="{{ date('Y-m-d', strtotime('+3 days')) }}">
                </div>
                <div>
                    <label class="form-label">Activo <span style="color: red;">*</span></label>
                    <select id="reqActivo" class="form-input">
                        <option value="">Seleccionar activo</option>
                        @isset($activos)
                            @foreach($activos as $activo)
                                <option value="{{ $activo->id }}">{{ $activo->codigo }} - {{ $activo->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label class="form-label">Cantidad</label>
                    <input type="number" id="reqCantidad" class="form-input" value="1" min="1">
                </div>

                <div>
                    <label class="form-label">Solicitante <span style="color: red;">*</span></label>
                    <select id="reqSolicitante" class="form-input" onchange="autocompletarArea('req')" disabled>
                        <option value="">Primero seleccione un proyecto</option>
                    </select>
                    <small id="reqSolicitanteHint" style="color: #6c757d; font-size: 11px;"></small>
                </div>

                <div>
                    <label class="form-label">Área</label>
                    <input type="text" id="reqArea" class="form-input" placeholder="Escriba o autocompletar">
                </div>

                <div>
                    <label class="form-label">Prioridad <span style="color: red;">*</span></label>
                    <select id="reqPrioridad" class="form-input">
                        <option value="Baja">🟢 Baja</option>
                        <option value="Media" selected>🟡 Media</option>
                        <option value="Alta">🟠 Alta</option>
                        <option value="Urgente">🔴 Urgente</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Motivo <span style="color: red;">*</span></label>
                    <textarea id="reqMotivo" rows="2" class="form-input" placeholder="Motivo de la requisición..."></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Observaciones</label>
                    <textarea id="reqObservaciones" rows="2" class="form-input" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModalRequisicion()" class="btn-secondary">Cancelar</button>
                <button onclick="guardarRequisicion()" class="btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AUTORIZAR -->
<div id="modalAutorizar" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 450px;">
        <div class="modal-header">
            <h3>Autorizar Requisición</h3>
            <button onclick="cerrarModalAutorizar()" class="modal-close">✕</button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de autorizar la requisición <strong id="autorizarFolio"></strong>?</p>
            <div style="margin-bottom: 15px;">
                <label class="form-label">Observaciones</label>
                <textarea id="autorizarObservaciones" rows="3" class="form-input" placeholder="Observaciones..."></textarea>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModalAutorizar()" class="btn-secondary">Cancelar</button>
                <button onclick="confirmarAutorizar()" class="btn-success">Autorizar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL RECHAZAR -->
<div id="modalRechazar" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 450px;">
        <div class="modal-header">
            <h3>Rechazar Requisición</h3>
            <button onclick="cerrarModalRechazar()" class="modal-close">✕</button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de rechazar la requisición <strong id="rechazarFolio"></strong>?</p>
            <div style="margin-bottom: 15px;">
                <label class="form-label">Motivo <span style="color: red;">*</span></label>
                <textarea id="rechazarMotivo" rows="3" class="form-input" placeholder="Motivo del rechazo..."></textarea>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModalRechazar()" class="btn-secondary">Cancelar</button>
                <button onclick="confirmarRechazar()" class="btn-danger">Rechazar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL REGISTRAR SALIDA --}}
<div id="modalSalida" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 550px;">
        <div class="modal-header">
            <h3>Registrar Salida / Asignación</h3>
            <button onclick="cerrarModalSalida()" class="modal-close">✕</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="salidaRequisicionId">
            <input type="hidden" id="salidaProyectoId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="grid-column: span 2;">
                    <label class="form-label">Responsable <span style="color: red;">*</span></label>
                    <select id="salidaResponsable" class="form-input" disabled>
                        <option value="">Cargando personas...</option>
                    </select>
                    <small id="salidaResponsableHint" style="color: #6c757d; font-size: 11px;"></small>
                </div>
                <div>
                    <label class="form-label">Fecha Salida <span style="color: red;">*</span></label>
                    <input type="date" id="salidaFecha" class="form-input" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="form-label">Condición <span style="color: red;">*</span></label>
                    <select id="salidaCondicion" class="form-input">
                        <option value="Excelente">Excelente</option>
                        <option value="Bueno" selected>Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                    </select>
                </div>
                <div id="divHorometro" style="display: none;">
                    <label class="form-label">Horómetro (Horas)</label>
                    <input type="number" step="0.1" id="salidaHorometro" class="form-input" placeholder="0.0">
                </div>
                <div id="divKilometraje" style="display: none;">
                    <label class="form-label">Kilometraje (Km)</label>
                    <input type="number" step="0.1" id="salidaKilometraje" class="form-input" placeholder="0.0">
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Observaciones</label>
                    <textarea id="salidaObservaciones" rows="2" class="form-input" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModalSalida()" class="btn-secondary">Cancelar</button>
                <button onclick="guardarSalida()" class="btn-primary">Registrar Salida</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REGISTRAR DEVOLUCIÓN -->
<div id="modalDevolver" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Registrar Devolución</h3>
            <button onclick="cerrarModalDevolver()" class="modal-close">✕</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="devolverAsignacionId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label class="form-label">Fecha Devolución <span style="color: red;">*</span></label>
                    <input type="date" id="devolverFecha" class="form-input" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="form-label">Condición <span style="color: red;">*</span></label>
                    <select id="devolverCondicion" class="form-input">
                        <option value="Excelente">Excelente</option>
                        <option value="Bueno" selected>Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                        <option value="Danado">Dañado</option>
                    </select>
                </div>
                <div id="divDevolverHorometro" style="display: none;">
                    <label class="form-label">Horómetro (Horas)</label>
                    <input type="number" step="0.1" id="devolverHorometro" class="form-input" placeholder="0.0">
                </div>
                <div id="divDevolverKilometraje" style="display: none;">
                    <label class="form-label">Kilometraje (Km)</label>
                    <input type="number" step="0.1" id="devolverKilometraje" class="form-input" placeholder="0.0">
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Reporte de Daños</label>
                    <textarea id="devolverReporteDanos" rows="2" class="form-input" placeholder="Describa los daños si los hubiera..."></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Costo de Reparación</label>
                    <input type="number" step="0.01" id="devolverCostoReparacion" class="form-input" placeholder="0.00">
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Observaciones</label>
                    <textarea id="devolverObservaciones" rows="2" class="form-input" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="cerrarModalDevolver()" class="btn-secondary">Cancelar</button>
                <button onclick="guardarDevolucion()" class="btn-success">Registrar Devolución</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETALLE (requisición y devolución) --}}
<div id="modalDetalle" class="modal-overlay" style="display: none;">
    <div class="modal-box" style="max-width: 650px;">
        <div class="modal-header">
            <h3 id="detalleTitulo">Detalle</h3>
            <button onclick="cerrarModalDetalle()" class="modal-close">✕</button>
        </div>
        <div class="modal-body" id="detalleContenido">
            Cargando...
        </div>
        <div class="modal-footer">
            <button onclick="cerrarModalDetalle()" class="btn-secondary">Cerrar</button>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; vertical-align: top; }
    .table td:nth-child(5) { white-space: nowrap; }
    .table td.num-right { text-align: right; white-space: nowrap; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }

    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-aprobada { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-rechazada { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-asignada { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-devuelta { background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; display: inline-block; }
    .badge-alta { background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 10px; font-size: 9px; }
    .badge-media { background-color: #ffc107; color: #212529; padding: 2px 6px; border-radius: 10px; font-size: 9px; }
    .badge-baja { background-color: #28a745; color: white; padding: 2px 6px; border-radius: 10px; font-size: 9px; }
    .badge-urgente { background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 10px; font-size: 9px; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .text-muted { color: #adb5bd; font-style: italic; }

    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center; }
    .modal-box { background-color: white; border-radius: 8px; width: 95%; max-height: 90vh; overflow-y: auto; }
    .modal-header { background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { color: white; margin: 0; font-size: 18px; }
    .modal-close { background: none; border: none; color: white; font-size: 20px; cursor: pointer; }
    .modal-body { padding: 20px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; color: #495057; }
    .form-input { width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; }
    .btn-primary { padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer; }
    .btn-secondary { padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer; }
    .btn-success { padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer; }
    .btn-danger { padding: 8px 20px; border: none; border-radius: 4px; background: #dc3545; color: white; cursor: pointer; }

    .detalle-grid { display: grid; grid-template-columns: 160px 1fr; gap: 8px 15px; font-size: 13px; }
    .detalle-grid .label { font-weight: 600; color: #6c757d; }
    .detalle-grid .value { color: #212529; word-break: break-word; }
    .detalle-seccion { margin-top: 18px; padding-top: 12px; border-top: 1px dashed #dee2e6; }
    .detalle-seccion h4 { color: var(--color-primary); font-size: 14px; margin: 0 0 10px 0; }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
        .detalle-grid { grid-template-columns: 1fr; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
/* =========================================================
 *  ESTADO GLOBAL
 * ========================================================= */
let currentPageRequisiciones = 1, currentPageDevoluciones = 1;
let perPageRequisiciones = 10, perPageDevoluciones = 10;
let totalPagesRequisiciones = 1, totalPagesDevoluciones = 1;
let requisicionSeleccionada = null;

const personasCache = {};

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content
    || '{{ csrf_token() }}';

/* Helpers */
function esc(s) {
    if (s === null || s === undefined || s === '') return '<span class="text-muted">—</span>';
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}
function escRaw(s) {
    if (s === null || s === undefined || s === '') return '';
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

/* =========================================================
 *  INIT
 * ========================================================= */
document.addEventListener('DOMContentLoaded', function() {
    cargarRequisiciones();
    cargarDevoluciones();
    configurarEventos();
});

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        currentPageRequisiciones = 1;
        currentPageDevoluciones = 1;
        cargarRequisiciones();
        cargarDevoluciones();
    });
    document.getElementById('btnExportar')?.addEventListener('click', () => alert('Exportación en desarrollo'));
    document.getElementById('filtroProyecto')?.addEventListener('change', () => {
        currentPageRequisiciones = 1; currentPageDevoluciones = 1;
        cargarRequisiciones(); cargarDevoluciones();
    });
    document.getElementById('filtroEstatus')?.addEventListener('change', () => {
        currentPageRequisiciones = 1; currentPageDevoluciones = 1;
        cargarRequisiciones(); cargarDevoluciones();
    });
}

/* =========================================================
 *  LISTADOS
 * ========================================================= */
function cargarRequisiciones() {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';

    let url = `/almacen/api/requisiciones-activos?page=${currentPageRequisiciones}&per_page=${perPageRequisiciones}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    if (estatus) url += `&estatus=${estatus}`;

    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (response.success) {
                renderizarTablaRequisiciones(response.data);
                totalPagesRequisiciones = response.last_page;
                actualizarPaginacion('requisiciones', response.current_page, response.last_page);
            } else {
                document.getElementById('tbodyRequisiciones').innerHTML =
                    '<tr><td colspan="10" style="text-align: center;">Error: ' + escRaw(response.message || 'Desconocido') + '</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyRequisiciones').innerHTML =
                '<tr><td colspan="10" style="text-align: center;">Error de conexión: ' + escRaw(error.message) + '</td></tr>';
        });
}

function cargarDevoluciones() {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';

    let url = `/almacen/api/devoluciones-activos?page=${currentPageDevoluciones}&per_page=${perPageDevoluciones}`;
    if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
    if (fechaFin) url += `&fecha_fin=${fechaFin}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    if (estatus) url += `&estatus=${estatus}`;

    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (response.success) {
                renderizarTablaDevoluciones(response.data);
                totalPagesDevoluciones = response.last_page;
                actualizarPaginacion('devoluciones', response.current_page, response.last_page);
            } else {
                document.getElementById('tbodyDevoluciones').innerHTML =
                    '<tr><td colspan="11" style="text-align: center;">Error: ' + escRaw(response.message || 'Desconocido') + '</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyDevoluciones').innerHTML =
                '<tr><td colspan="11" style="text-align: center;">Error de conexión: ' + escRaw(error.message) + '</td></tr>';
        });
}

function renderizarTablaRequisiciones(data) {
    const tbody = document.getElementById('tbodyRequisiciones');
    if (!data || !data.length) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No hay requisiciones registradas</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    data.forEach(item => {
        const prioridadClass = item.prioridad === 'Alta' ? 'badge-alta'
            : item.prioridad === 'Media' ? 'badge-media'
            : item.prioridad === 'Urgente' ? 'badge-urgente' : 'badge-baja';

        let estatusClass = 'badge-pendiente';
        if (item.estatus === 'Aprobada') estatusClass = 'badge-aprobada';
        else if (item.estatus === 'Rechazada') estatusClass = 'badge-rechazada';
        else if (item.estatus === 'Asignada') estatusClass = 'badge-asignada';
        else if (item.estatus === 'Devuelta') estatusClass = 'badge-devuelta';

        let acciones = `<i class="fas fa-eye" onclick="verDetalleRequisicion(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Ver detalle"></i>`;

        if (item.estatus === 'Pendiente') {
            acciones += `<i class="fas fa-check-circle" onclick="abrirModalAutorizar(${item.id}, '${escRaw(item.folio)}')" style="color: #28a745; cursor: pointer; margin: 0 3px;" title="Autorizar"></i>`;
            acciones += `<i class="fas fa-times-circle" onclick="abrirModalRechazar(${item.id}, '${escRaw(item.folio)}')" style="color: #dc3545; cursor: pointer; margin: 0 3px;" title="Rechazar"></i>`;
        }
        if (item.estatus === 'Aprobada') {
            const proyectoFallback = item.proyecto_id
                || document.getElementById('filtroProyecto')?.value
                || '';
            acciones += `<i class="fas fa-truck" onclick="abrirModalSalida(${item.id}, '${proyectoFallback}')" style="color: #17a2b8; cursor: pointer; margin: 0 3px;" title="Registrar Salida"></i>`;
        }

        tbody.innerHTML += `
            <tr>
                <td><strong>${esc(item.folio)}</strong></td>
                <td>${esc(item.fecha_requisicion)}</td>
                <td>${esc(item.proyecto_nombre)}</td>
                <td>${esc(item.solicitante)}</td>
                <td>${esc(item.activo_nombre)}${item.activo_codigo ? `<br><small>${escRaw(item.activo_codigo)}</small>` : ''}</td>
                <td>${item.cantidad || 0}</td>
                <td>${esc(item.fecha_requerida)}</td>
                <td><span class="${prioridadClass}">${esc(item.prioridad || 'Media')}</span></td>
                <td><span class="${estatusClass}">${esc(item.estatus || 'Pendiente')}</span></td>
                <td>${acciones}</td>
            </tr>
        `;
    });
}

function renderizarTablaDevoluciones(data) {
    const tbody = document.getElementById('tbodyDevoluciones');
    if (!data || !data.length) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align: center;">No hay asignaciones registradas</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    data.forEach(item => {
        let estatusClass = 'badge-pendiente';
        if (item.estatus === 'Activa') estatusClass = 'badge-asignada';
        else if (item.estatus === 'Devuelta') estatusClass = 'badge-devuelta';

        let acciones = `<i class="fas fa-eye" onclick="verDetalleAsignacion(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Ver detalle"></i>`;
        if (item.estatus === 'Activa') {
            acciones += `<i class="fas fa-undo-alt" onclick="abrirModalDevolver(${item.id})" style="color: #28a745; cursor: pointer; margin: 0 3px;" title="Registrar Devolución"></i>`;
        }

        // Fallback para el folio (si viene null/vacío)
        const folio = item.folio_requisicion
            ? `<strong>${escRaw(item.folio_requisicion)}</strong>`
            : '<span class="text-muted">sin folio</span>';

        // Valor de salida con unidad
        let valorSalida = '<span class="text-muted">—</span>';
        if (item.valor_salida !== null && item.valor_salida !== undefined && item.valor_salida !== '') {
            valorSalida = escRaw(item.valor_salida) + (item.unidad_medida ? ' ' + escRaw(item.unidad_medida) : '');
        }

        tbody.innerHTML += `
            <tr>
                <td>${folio}</td>
                <td>${esc(item.fecha_salida)}</td>
                <td>${esc(item.proyecto_nombre)}</td>
                <td>${esc(item.responsable_asignado)}</td>
                <td>
                    ${esc(item.activo_nombre)}
                    ${item.activo_codigo ? `<br><small>${escRaw(item.activo_codigo)}</small>` : ''}
                </td>
                <td class="num-right">${valorSalida}</td>
                <td>${esc(item.condicion_salida)}</td>
                <td>${esc(item.fecha_devolucion)}</td>
                <td>${esc(item.condicion_devolucion)}</td>
                <td><span class="${estatusClass}">${esc(item.estatus || 'Activa')}</span></td>
                <td>${acciones}</td>
            </tr>
        `;
    });
}

function actualizarPaginacion(tipo, currentPage, lastPage) {
    if (tipo === 'requisiciones') {
        currentPageRequisiciones = currentPage;
        const container = document.getElementById('paginacionRequisiciones');
        if (container) {
            container.innerHTML =
                `<button class="page-btn" onclick="cambiarPaginaRequisiciones(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>Anterior</button>` +
                `<span style="margin: 0 10px;">Página ${currentPage} de ${lastPage}</span>` +
                `<button class="page-btn" onclick="cambiarPaginaRequisiciones(${currentPage + 1})" ${currentPage >= lastPage ? 'disabled' : ''}>Siguiente</button>`;
        }
    } else {
        currentPageDevoluciones = currentPage;
        const container = document.getElementById('paginacionDevoluciones');
        if (container) {
            container.innerHTML =
                `<button class="page-btn" onclick="cambiarPaginaDevoluciones(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>Anterior</button>` +
                `<span style="margin: 0 10px;">Página ${currentPage} de ${lastPage}</span>` +
                `<button class="page-btn" onclick="cambiarPaginaDevoluciones(${currentPage + 1})" ${currentPage >= lastPage ? 'disabled' : ''}>Siguiente</button>`;
        }
    }
}

function cambiarPaginaRequisiciones(page) { if (page >= 1 && page <= totalPagesRequisiciones) { currentPageRequisiciones = page; cargarRequisiciones(); } }
function cambiarPaginaDevoluciones(page) { if (page >= 1 && page <= totalPagesDevoluciones) { currentPageDevoluciones = page; cargarDevoluciones(); } }

/* =========================================================
 *  TABS
 * ========================================================= */
window.switchTab = function(tab) {
    const panelRequisiciones = document.getElementById('panelRequisiciones');
    const panelDevoluciones = document.getElementById('panelDevoluciones');
    const tabRequisiciones = document.getElementById('tabRequisiciones');
    const tabDevoluciones = document.getElementById('tabDevoluciones');

    if (tab === 'requisiciones') {
        panelRequisiciones.style.display = 'block';
        panelDevoluciones.style.display = 'none';
        tabRequisiciones.style.backgroundColor = 'var(--color-primary)';
        tabRequisiciones.style.color = 'white';
        tabDevoluciones.style.backgroundColor = '#e9ecef';
        tabDevoluciones.style.color = '#495057';
        cargarRequisiciones();
    } else {
        panelRequisiciones.style.display = 'none';
        panelDevoluciones.style.display = 'block';
        tabDevoluciones.style.backgroundColor = 'var(--color-primary)';
        tabDevoluciones.style.color = 'white';
        tabRequisiciones.style.backgroundColor = '#e9ecef';
        tabRequisiciones.style.color = '#495057';
        cargarDevoluciones();
    }
};

/* =========================================================
 *  PERSONAS DEL PROYECTO
 * ========================================================= */
function cargarPersonasProyecto(contexto, proyectoIdPreseleccionado) {
    const selectProyecto = document.getElementById(contexto + 'Proyecto');
    const selectPersona = document.getElementById(contexto === 'req' ? 'reqSolicitante' : 'salidaResponsable');
    const hint = document.getElementById(contexto === 'req' ? 'reqSolicitanteHint' : 'salidaResponsableHint');

    const proyectoId = proyectoIdPreseleccionado || selectProyecto?.value;

    if (!proyectoId) {
        selectPersona.innerHTML = '<option value="">Primero seleccione un proyecto</option>';
        selectPersona.disabled = true;
        if (hint) hint.textContent = '';
        return;
    }

    if (personasCache[proyectoId]) {
        pintarPersonas(selectPersona, hint, personasCache[proyectoId]);
        return;
    }

    selectPersona.innerHTML = '<option value="">Cargando...</option>';
    selectPersona.disabled = true;

    fetch(`/almacen/api/proyectos/${proyectoId}/personas`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (!response.success) throw new Error(response.message || 'Error');
            personasCache[proyectoId] = response.data;
            pintarPersonas(selectPersona, hint, response.data);
        })
        .catch(error => {
            console.error(error);
            selectPersona.innerHTML = '<option value="">Error al cargar</option>';
            selectPersona.disabled = true;
            if (hint) hint.textContent = 'No se pudieron cargar las personas.';
        });
}

function pintarPersonas(select, hint, data) {
    const usuarios = data.usuarios || [];
    const personal = data.personal || [];

    let html = '<option value="">Seleccionar...</option>';

    if (usuarios.length) {
        html += '<optgroup label="Usuarios del sistema">';
        usuarios.forEach(u => {
            html += `<option value="${escRaw(u.nombre)}" data-area="${escRaw(u.area || '')}">${escRaw(u.nombre)}${u.area ? ' — ' + escRaw(u.area) : ''}</option>`;
        });
        html += '</optgroup>';
    }
    if (personal.length) {
        html += '<optgroup label="Personal del proyecto">';
        personal.forEach(p => {
            html += `<option value="${escRaw(p.nombre)}" data-area="${escRaw(p.area || '')}">${escRaw(p.nombre)}${p.area ? ' — ' + escRaw(p.area) : ''}${p.puesto ? ' (' + escRaw(p.puesto) + ')' : ''}</option>`;
        });
        html += '</optgroup>';
    }

    select.innerHTML = html;
    select.disabled = false;
    if (hint) {
        hint.textContent = `${usuarios.length} usuario(s) y ${personal.length} personal del proyecto.`;
    }
}

function autocompletarArea(contexto) {
    const selectPersona = document.getElementById(contexto === 'req' ? 'reqSolicitante' : 'salidaResponsable');
    const inputArea = document.getElementById(contexto === 'req' ? 'reqArea' : null);
    if (!selectPersona || !inputArea) return;

    const opt = selectPersona.options[selectPersona.selectedIndex];
    const areaDetectada = opt?.dataset?.area || '';

    if (areaDetectada) {
        inputArea.value = areaDetectada;
    }
}

/* =========================================================
 *  MODAL NUEVA REQUISICIÓN
 * ========================================================= */
function abrirModalRequisicion() {
    document.getElementById('reqProyecto').value = '';
    document.getElementById('reqFechaRequerida').value = new Date(Date.now() + 3*24*60*60*1000).toISOString().split('T')[0];
    document.getElementById('reqActivo').value = '';
    document.getElementById('reqCantidad').value = '1';
    document.getElementById('reqSolicitante').innerHTML = '<option value="">Primero seleccione un proyecto</option>';
    document.getElementById('reqSolicitante').disabled = true;
    document.getElementById('reqSolicitanteHint').textContent = '';
    document.getElementById('reqArea').value = '';
    document.getElementById('reqPrioridad').value = 'Media';
    document.getElementById('reqMotivo').value = '';
    document.getElementById('reqObservaciones').value = '';
    document.getElementById('modalRequisicion').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalRequisicion() {
    document.getElementById('modalRequisicion').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarRequisicion() {
    const proyectoId = document.getElementById('reqProyecto').value;
    const activoId = document.getElementById('reqActivo').value;
    const solicitante = document.getElementById('reqSolicitante').value.trim();
    const motivo = document.getElementById('reqMotivo').value.trim();

    if (!proyectoId || !activoId || !solicitante || !motivo) {
        alert('Por favor complete los campos obligatorios');
        return;
    }

    const data = {
        proyecto_id: proyectoId,
        activo_id: activoId,
        fecha_requerida: document.getElementById('reqFechaRequerida').value,
        cantidad: document.getElementById('reqCantidad').value,
        solicitante: solicitante,
        area: document.getElementById('reqArea').value,
        prioridad: document.getElementById('reqPrioridad').value,
        motivo: motivo,
        observaciones: document.getElementById('reqObservaciones').value
    };

    fetch('/almacen/api/requisiciones-activos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalRequisicion();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al guardar la requisición');
    });
}

/* =========================================================
 *  VER DETALLE REQUISICIÓN
 * ========================================================= */
function verDetalleRequisicion(id) {
    document.getElementById('detalleTitulo').textContent = 'Detalle de Requisición';
    document.getElementById('detalleContenido').innerHTML = 'Cargando...';
    document.getElementById('modalDetalle').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    fetch(`/almacen/api/requisiciones-activos/${id}`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (!response.success) throw new Error(response.message || 'Error');
            const r = response.data;
            const a = r.asignacion;

            const fmt = (v) => (v === null || v === undefined || v === '') ? '<span class="text-muted">—</span>' : escRaw(v);

            let html = '<div class="detalle-grid">';
            html += `<div class="label">Folio:</div><div class="value"><strong>${fmt(r.folio)}</strong></div>`;
            html += `<div class="label">Fecha Requisición:</div><div class="value">${fmt(r.fecha_requisicion)}</div>`;
            html += `<div class="label">Fecha Requerida:</div><div class="value">${fmt(r.fecha_requerida)}</div>`;
            html += `<div class="label">Proyecto:</div><div class="value">${fmt(r.proyecto_nombre)}</div>`;
            html += `<div class="label">Solicitante:</div><div class="value">${fmt(r.solicitante)}</div>`;
            html += `<div class="label">Área:</div><div class="value">${fmt(r.area)}</div>`;
            html += `<div class="label">Activo:</div><div class="value">${fmt(r.activo_nombre)} ${r.activo_codigo ? `<small>(${escRaw(r.activo_codigo)})</small>` : ''}</div>`;
            html += `<div class="label">Cantidad:</div><div class="value">${r.cantidad || 0}</div>`;
            html += `<div class="label">Prioridad:</div><div class="value">${fmt(r.prioridad || 'Media')}</div>`;
            html += `<div class="label">Estatus:</div><div class="value"><strong>${fmt(r.estatus || 'Pendiente')}</strong></div>`;
            html += `<div class="label">Motivo:</div><div class="value">${fmt(r.motivo)}</div>`;
            if (r.observaciones) html += `<div class="label">Observaciones:</div><div class="value">${escRaw(r.observaciones)}</div>`;
            if (r.motivo_rechazo) html += `<div class="label">Motivo Rechazo:</div><div class="value" style="color:#dc3545;">${escRaw(r.motivo_rechazo)}</div>`;
            html += '</div>';

            if (a) {
                html += '<div class="detalle-seccion"><h4><i class="fas fa-truck"></i> Datos de Salida</h4><div class="detalle-grid">';
                html += `<div class="label">Fecha Salida:</div><div class="value">${fmt(a.fecha_salida)}</div>`;
                html += `<div class="label">Responsable:</div><div class="value">${fmt(a.responsable_asignado)}</div>`;
                html += `<div class="label">Condición Salida:</div><div class="value">${fmt(a.condicion_salida)}</div>`;
                if (a.horometro_salida) html += `<div class="label">Horómetro Salida:</div><div class="value">${escRaw(a.horometro_salida)}</div>`;
                if (a.kilometraje_salida) html += `<div class="label">Kilometraje Salida:</div><div class="value">${escRaw(a.kilometraje_salida)}</div>`;
                if (a.observaciones_salida) html += `<div class="label">Observaciones:</div><div class="value">${escRaw(a.observaciones_salida)}</div>`;
                html += '</div></div>';

                if (a.estatus === 'Devuelta') {
                    html += '<div class="detalle-seccion"><h4><i class="fas fa-undo-alt"></i> Datos de Devolución</h4><div class="detalle-grid">';
                    html += `<div class="label">Fecha Devolución:</div><div class="value">${fmt(a.fecha_devolucion)}</div>`;
                    html += `<div class="label">Condición:</div><div class="value">${fmt(a.condicion_devolucion)}</div>`;
                    if (a.reporte_danos) html += `<div class="label">Reporte Daños:</div><div class="value" style="color:#dc3545;">${escRaw(a.reporte_danos)}</div>`;
                    if (a.costo_reparacion) html += `<div class="label">Costo Reparación:</div><div class="value">$${escRaw(a.costo_reparacion)}</div>`;
                    if (a.observaciones_devolucion) html += `<div class="label">Observaciones:</div><div class="value">${escRaw(a.observaciones_devolucion)}</div>`;
                    html += '</div></div>';
                }
            }

            document.getElementById('detalleContenido').innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('detalleContenido').innerHTML =
                '<div style="color:#dc3545;">Error al cargar el detalle: ' + escRaw(error.message) + '</div>';
        });
}

/* =========================================================
 *  VER DETALLE ASIGNACIÓN / DEVOLUCIÓN
 * ========================================================= */
function verDetalleAsignacion(id) {
    document.getElementById('detalleTitulo').textContent = 'Detalle de Asignación / Devolución';
    document.getElementById('detalleContenido').innerHTML = 'Cargando...';
    document.getElementById('modalDetalle').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    fetch(`/almacen/api/devoluciones-activos/${id}`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (!response.success) throw new Error(response.message || 'Error');
            const d = response.data;

            const fmt = (v) => (v === null || v === undefined || v === '') ? '<span class="text-muted">—</span>' : escRaw(v);

            let html = '<div class="detalle-grid">';
            html += `<div class="label">Folio Requisición:</div><div class="value"><strong>${fmt(d.folio_requisicion)}</strong></div>`;
            html += `<div class="label">Proyecto:</div><div class="value">${fmt(d.proyecto_nombre)}</div>`;
            html += `<div class="label">Activo:</div><div class="value">${fmt(d.activo_nombre)} ${d.activo_codigo ? `<small>(${escRaw(d.activo_codigo)})</small>` : ''}</div>`;
            if (d.motivo_requisicion) html += `<div class="label">Motivo Requisición:</div><div class="value">${escRaw(d.motivo_requisicion)}</div>`;
            html += `<div class="label">Estatus:</div><div class="value"><strong>${fmt(d.estatus || 'Activa')}</strong></div>`;
            html += '</div>';

            html += '<div class="detalle-seccion"><h4><i class="fas fa-truck"></i> Datos de Salida</h4><div class="detalle-grid">';
            html += `<div class="label">Fecha Salida:</div><div class="value">${fmt(d.fecha_salida)}</div>`;
            html += `<div class="label">Responsable:</div><div class="value">${fmt(d.responsable_asignado)}</div>`;
            html += `<div class="label">Condición Salida:</div><div class="value">${fmt(d.condicion_salida)}</div>`;
            if (d.horometro_salida) html += `<div class="label">Horómetro Salida:</div><div class="value">${escRaw(d.horometro_salida)}</div>`;
            if (d.kilometraje_salida) html += `<div class="label">Kilometraje Salida:</div><div class="value">${escRaw(d.kilometraje_salida)}</div>`;
            if (d.observaciones_salida) html += `<div class="label">Observaciones:</div><div class="value">${escRaw(d.observaciones_salida)}</div>`;
            html += '</div></div>';

            if (d.estatus === 'Devuelta') {
                html += '<div class="detalle-seccion"><h4><i class="fas fa-undo-alt"></i> Datos de Devolución</h4><div class="detalle-grid">';
                html += `<div class="label">Fecha Devolución:</div><div class="value">${fmt(d.fecha_devolucion)}</div>`;
                html += `<div class="label">Condición:</div><div class="value">${fmt(d.condicion_devolucion)}</div>`;
                if (d.horometro_devolucion) html += `<div class="label">Horómetro Dev.:</div><div class="value">${escRaw(d.horometro_devolucion)}</div>`;
                if (d.kilometraje_devolucion) html += `<div class="label">Kilometraje Dev.:</div><div class="value">${escRaw(d.kilometraje_devolucion)}</div>`;
                if (d.reporte_danos) html += `<div class="label">Reporte Daños:</div><div class="value" style="color:#dc3545;">${escRaw(d.reporte_danos)}</div>`;
                if (d.costo_reparacion) html += `<div class="label">Costo Reparación:</div><div class="value">$${escRaw(d.costo_reparacion)}</div>`;
                if (d.observaciones_devolucion) html += `<div class="label">Observaciones:</div><div class="value">${escRaw(d.observaciones_devolucion)}</div>`;
                html += '</div></div>';
            }

            document.getElementById('detalleContenido').innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('detalleContenido').innerHTML =
                '<div style="color:#dc3545;">Error al cargar el detalle: ' + escRaw(error.message) + '</div>';
        });
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

/* =========================================================
 *  AUTORIZAR / RECHAZAR
 * ========================================================= */
function abrirModalAutorizar(id, folio) {
    requisicionSeleccionada = id;
    document.getElementById('autorizarFolio').textContent = folio;
    document.getElementById('autorizarObservaciones').value = '';
    document.getElementById('modalAutorizar').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function cerrarModalAutorizar() {
    document.getElementById('modalAutorizar').style.display = 'none';
    document.body.style.overflow = 'auto';
}
function confirmarAutorizar() {
    const observaciones = document.getElementById('autorizarObservaciones').value;
    fetch(`/almacen/api/requisiciones-activos/${requisicionSeleccionada}/autorizar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ observaciones })
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalAutorizar();
            cargarRequisiciones();
        } else alert('❌ Error: ' + response.message);
    })
    .catch(e => alert('❌ Error: ' + e.message));
}

function abrirModalRechazar(id, folio) {
    requisicionSeleccionada = id;
    document.getElementById('rechazarFolio').textContent = folio;
    document.getElementById('rechazarMotivo').value = '';
    document.getElementById('modalRechazar').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function cerrarModalRechazar() {
    document.getElementById('modalRechazar').style.display = 'none';
    document.body.style.overflow = 'auto';
}
function confirmarRechazar() {
    const motivo = document.getElementById('rechazarMotivo').value.trim();
    if (!motivo) { alert('El motivo es obligatorio'); return; }
    fetch(`/almacen/api/requisiciones-activos/${requisicionSeleccionada}/rechazar`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ motivo })
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalRechazar();
            cargarRequisiciones();
        } else alert('❌ Error: ' + response.message);
    })
    .catch(e => alert('❌ Error: ' + e.message));
}

/* =========================================================
 *  SALIDA
 * ========================================================= */
function abrirModalSalida(requisicionId, proyectoId) {
    document.getElementById('salidaRequisicionId').value = requisicionId;
    document.getElementById('salidaProyectoId').value = proyectoId || '';
    document.getElementById('salidaFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('salidaHorometro').value = '';
    document.getElementById('salidaKilometraje').value = '';
    document.getElementById('salidaCondicion').value = 'Bueno';
    document.getElementById('salidaObservaciones').value = '';

    document.getElementById('divHorometro').style.display = 'none';
    document.getElementById('divKilometraje').style.display = 'none';

    const selectResp = document.getElementById('salidaResponsable');
    selectResp.innerHTML = '<option value="">Cargando...</option>';
    selectResp.disabled = true;

    document.getElementById('modalSalida').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    const pid = proyectoId
        || document.getElementById('filtroProyecto')?.value
        || '';

    if (pid && pid !== 'undefined' && pid !== 'null' && pid !== '') {
        cargarPersonasProyectoSalida(pid);
    } else {
        // Fallback: pedir el detalle y sacar proyecto_id
        fetch(`/almacen/api/requisiciones-activos/${requisicionId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(resp => {
            const pidReal = resp?.data?.proyecto_id;
            if (pidReal) {
                document.getElementById('salidaProyectoId').value = pidReal;
                cargarPersonasProyectoSalida(pidReal);
            } else {
                selectResp.innerHTML = '<option value="">No se pudo determinar el proyecto.</option>';
            }
        })
        .catch(err => {
            console.error(err);
            selectResp.innerHTML = '<option value="">Error al cargar responsables.</option>';
        });
    }
}

function cargarPersonasProyectoSalida(proyectoId) {
    const selectResp = document.getElementById('salidaResponsable');
    const hint = document.getElementById('salidaResponsableHint');

    if (personasCache[proyectoId]) {
        pintarPersonasSalida(selectResp, hint, personasCache[proyectoId]);
        return;
    }

    fetch(`/almacen/api/proyectos/${proyectoId}/personas`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(response => {
            if (!response.success) throw new Error(response.message || 'Error');
            personasCache[proyectoId] = response.data;
            pintarPersonasSalida(selectResp, hint, response.data);
        })
        .catch(error => {
            console.error(error);
            selectResp.innerHTML = '<option value="">Error al cargar</option>';
            selectResp.disabled = true;
            hint.textContent = 'No se pudieron cargar las personas.';
        });
}

function pintarPersonasSalida(select, hint, data) {
    const usuarios = data.usuarios || [];
    const personal = data.personal || [];

    let html = '<option value="">Seleccionar responsable...</option>';

    if (usuarios.length) {
        html += '<optgroup label="Usuarios del sistema">';
        usuarios.forEach(u => {
            html += `<option value="${escRaw(u.nombre)}" data-area="${escRaw(u.area || '')}">${escRaw(u.nombre)}${u.area ? ' — ' + escRaw(u.area) : ''}</option>`;
        });
        html += '</optgroup>';
    }
    if (personal.length) {
        html += '<optgroup label="Personal del proyecto">';
        personal.forEach(p => {
            html += `<option value="${escRaw(p.nombre)}" data-area="${escRaw(p.area || '')}">${escRaw(p.nombre)}${p.area ? ' — ' + escRaw(p.area) : ''}${p.puesto ? ' (' + escRaw(p.puesto) + ')' : ''}</option>`;
        });
        html += '</optgroup>';
    }

    select.innerHTML = html;
    select.disabled = false;
    if (hint) {
        hint.textContent = `${usuarios.length} usuario(s) y ${personal.length} personal del proyecto.`;
    }
}

function cerrarModalSalida() {
    document.getElementById('modalSalida').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarSalida() {
    const responsable = document.getElementById('salidaResponsable').value.trim();
    if (!responsable) { alert('El responsable es obligatorio'); return; }

    const data = {
        requisicion_id: document.getElementById('salidaRequisicionId').value,
        responsable_asignado: responsable,
        fecha_salida: document.getElementById('salidaFecha').value,
        condicion_salida: document.getElementById('salidaCondicion').value,
        horometro_salida: document.getElementById('salidaHorometro').value || null,
        kilometraje_salida: document.getElementById('salidaKilometraje').value || null,
        observaciones_salida: document.getElementById('salidaObservaciones').value
    };

    fetch('/almacen/api/devoluciones-activos/salida', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalSalida();
            cargarRequisiciones();
            cargarDevoluciones();
        } else alert('❌ Error: ' + response.message);
    })
    .catch(e => alert('❌ Error: ' + e.message));
}

/* =========================================================
 *  DEVOLUCIÓN
 * ========================================================= */
function abrirModalDevolver(asignacionId) {
    document.getElementById('devolverAsignacionId').value = asignacionId;
    document.getElementById('devolverFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('devolverCondicion').value = 'Bueno';
    document.getElementById('devolverHorometro').value = '';
    document.getElementById('devolverKilometraje').value = '';
    document.getElementById('devolverReporteDanos').value = '';
    document.getElementById('devolverCostoReparacion').value = '';
    document.getElementById('devolverObservaciones').value = '';

    document.getElementById('divDevolverHorometro').style.display = 'none';
    document.getElementById('divDevolverKilometraje').style.display = 'none';

    document.getElementById('modalDevolver').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalDevolver() {
    document.getElementById('modalDevolver').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarDevolucion() {
    const asignacionId = document.getElementById('devolverAsignacionId').value;
    const condicion = document.getElementById('devolverCondicion').value;
    const reporteDanos = document.getElementById('devolverReporteDanos').value;

    if (condicion === 'Danado' && !reporteDanos) {
        alert('Cuando la condición es Dañado, debe especificar el reporte de daños');
        return;
    }

    const data = {
        fecha_devolucion: document.getElementById('devolverFecha').value,
        condicion_devolucion: condicion,
        horometro_devolucion: document.getElementById('devolverHorometro').value || null,
        kilometraje_devolucion: document.getElementById('devolverKilometraje').value || null,
        reporte_danos: reporteDanos,
        costo_reparacion: document.getElementById('devolverCostoReparacion').value || null,
        observaciones_devolucion: document.getElementById('devolverObservaciones').value
    };

    fetch(`/almacen/api/devoluciones-activos/${asignacionId}/devolver`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalDevolver();
            cargarRequisiciones();
            cargarDevoluciones();
        } else alert('❌ Error: ' + response.message);
    })
    .catch(e => alert('❌ Error: ' + e.message));
}

/* =========================================================
 *  UTILIDADES
 * ========================================================= */
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModalRequisicion();
        cerrarModalAutorizar();
        cerrarModalRechazar();
        cerrarModalSalida();
        cerrarModalDevolver();
        cerrarModalDetalle();
    }
});

['modalRequisicion', 'modalAutorizar', 'modalRechazar', 'modalSalida', 'modalDevolver', 'modalDetalle'].forEach(modalId => {
    const el = document.getElementById(modalId);
    if (!el) return;
    el.addEventListener('click', (e) => {
        if (e.target !== el) return;
        const closeFn = {
            'modalRequisicion': cerrarModalRequisicion,
            'modalAutorizar': cerrarModalAutorizar,
            'modalRechazar': cerrarModalRechazar,
            'modalSalida': cerrarModalSalida,
            'modalDevolver': cerrarModalDevolver,
            'modalDetalle': cerrarModalDetalle
        }[modalId];
        if (closeFn) closeFn();
    });
});
</script>
@endsection