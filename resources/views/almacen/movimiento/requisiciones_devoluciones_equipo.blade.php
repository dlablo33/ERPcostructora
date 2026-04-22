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
                        <button id="btnExportar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-file-excel"></i> Exportar
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
                                <tr><td colspan="10" style="text-align: center;">Cargando...<\/td></tr>
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
                                    <th>Horómetro/Km Salida</th>
                                    <th>Condición Salida</th>
                                    <th>Fecha Devolución</th>
                                    <th>Condición Devolución</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDevoluciones">
                                <tr><td colspan="11" style="text-align: center;">Cargando...<\/td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacionDevoluciones" style="margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA REQUISICIÓN -->
<div id="modalRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 550px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Nueva Requisición de Activo</h3>
            <button onclick="cerrarModalRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="reqProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proyecto</option>
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha Requerida <span style="color: red;">*</span></label>
                    <input type="date" id="reqFechaRequerida" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d', strtotime('+3 days')) }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Activo <span style="color: red;">*</span></label>
                    <select id="reqActivo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar activo</option>
                        @isset($activos)
                            @foreach($activos as $activo)
                                <option value="{{ $activo->id }}">{{ $activo->codigo }} - {{ $activo->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad</label>
                    <input type="number" id="reqCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="1">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Solicitante <span style="color: red;">*</span></label>
                    <input type="text" id="reqSolicitante" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del solicitante">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Área</label>
                    <input type="text" id="reqArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Área que solicita">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Prioridad <span style="color: red;">*</span></label>
                    <select id="reqPrioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Baja">🟢 Baja</option>
                        <option value="Media" selected>🟡 Media</option>
                        <option value="Alta">🟠 Alta</option>
                        <option value="Urgente">🔴 Urgente</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Motivo <span style="color: red;">*</span></label>
                    <textarea id="reqMotivo" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Motivo de la requisición..."></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="reqObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AUTORIZAR REQUISICIÓN -->
<div id="modalAutorizar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 450px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Autorizar Requisición</h3>
            <button onclick="cerrarModalAutorizar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <p>¿Está seguro de autorizar la requisición <strong id="autorizarFolio"></strong>?</p>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                <textarea id="autorizarObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalAutorizar()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarAutorizar()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;">Autorizar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL RECHAZAR REQUISICIÓN -->
<div id="modalRechazar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 450px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Rechazar Requisición</h3>
            <button onclick="cerrarModalRechazar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <p>¿Está seguro de rechazar la requisición <strong id="rechazarFolio"></strong>?</p>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600;">Motivo <span style="color: red;">*</span></label>
                <textarea id="rechazarMotivo" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Motivo del rechazo..."></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalRechazar()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarRechazar()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #dc3545; color: white; cursor: pointer;">Rechazar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REGISTRAR SALIDA (ASIGNACIÓN) -->
<div id="modalSalida" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Registrar Salida / Asignación</h3>
            <button onclick="cerrarModalSalida()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="salidaRequisicionId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Responsable <span style="color: red;">*</span></label>
                    <input type="text" id="salidaResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Quién recibe el activo">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha Salida <span style="color: red;">*</span></label>
                    <input type="date" id="salidaFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div id="divHorometro" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Horómetro (Horas)</label>
                    <input type="number" step="0.1" id="salidaHorometro" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.0">
                </div>
                <div id="divKilometraje" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Kilometraje (Km)</label>
                    <input type="number" step="0.1" id="salidaKilometraje" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.0">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Condición <span style="color: red;">*</span></label>
                    <select id="salidaCondicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Excelente">Excelente</option>
                        <option value="Bueno" selected>Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="salidaObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalSalida()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarSalida()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Registrar Salida</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REGISTRAR DEVOLUCIÓN -->
<div id="modalDevolver" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Registrar Devolución</h3>
            <button onclick="cerrarModalDevolver()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="devolverAsignacionId">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha Devolución <span style="color: red;">*</span></label>
                    <input type="date" id="devolverFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Condición <span style="color: red;">*</span></label>
                    <select id="devolverCondicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Excelente">Excelente</option>
                        <option value="Bueno" selected>Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                        <option value="Danado">Dañado</option>
                    </select>
                </div>
                <div id="divDevolverHorometro" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Horómetro (Horas)</label>
                    <input type="number" step="0.1" id="devolverHorometro" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.0">
                </div>
                <div id="divDevolverKilometraje" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Kilometraje (Km)</label>
                    <input type="number" step="0.1" id="devolverKilometraje" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.0">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Reporte de Daños</label>
                    <textarea id="devolverReporteDanos" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa los daños si los hubiera..."></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Costo de Reparación</label>
                    <input type="number" step="0.01" id="devolverCostoReparacion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="devolverObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalDevolver()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarDevolucion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;">Registrar Devolución</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
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
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let currentPageRequisiciones = 1, currentPageDevoluciones = 1;
let perPageRequisiciones = 10, perPageDevoluciones = 10;
let totalPagesRequisiciones = 1, totalPagesDevoluciones = 1;
let requisicionSeleccionada = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarRequisiciones();
    cargarDevoluciones();
    configurarEventos();
});

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
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTablaRequisiciones(response.data);
                totalPagesRequisiciones = response.last_page;
                actualizarPaginacion('requisiciones', response.current_page, response.last_page);
            } else {
                document.getElementById('tbodyRequisiciones').innerHTML = '<tr><td colspan="10" style="text-align: center;">Error: ' + (response.message || 'Error desconocido') + '<\/td><\/tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyRequisiciones').innerHTML = '<td><td colspan="10" style="text-align: center;">Error de conexión: ' + error.message + '<\/td><\/tr>';
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
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTablaDevoluciones(response.data);
                totalPagesDevoluciones = response.last_page;
                actualizarPaginacion('devoluciones', response.current_page, response.last_page);
            } else {
                document.getElementById('tbodyDevoluciones').innerHTML = '<tr><td colspan="11" style="text-align: center;">Error: ' + (response.message || 'Error desconocido') + '<\/td><\/tr>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tbodyDevoluciones').innerHTML = '<tr><td colspan="11" style="text-align: center;">Error de conexión: ' + error.message + '<\/td><\/tr>';
        });
}

function renderizarTablaRequisiciones(data) {
    const tbody = document.getElementById('tbodyRequisiciones');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No hay requisiciones registradas<\/td><\/tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach(item => {
        const prioridadClass = item.prioridad === 'Alta' ? 'badge-alta' : (item.prioridad === 'Media' ? 'badge-media' : (item.prioridad === 'Urgente' ? 'badge-urgente' : 'badge-baja'));
        let estatusClass = '';
        if (item.estatus === 'Pendiente') estatusClass = 'badge-pendiente';
        else if (item.estatus === 'Aprobada') estatusClass = 'badge-aprobada';
        else if (item.estatus === 'Rechazada') estatusClass = 'badge-rechazada';
        else if (item.estatus === 'Asignada') estatusClass = 'badge-asignada';
        else if (item.estatus === 'Devuelta') estatusClass = 'badge-devuelta';
        else estatusClass = 'badge-pendiente';
        
        let acciones = `<i class="fas fa-eye" onclick="verDetalleRequisicion(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Ver detalle"></i>`;
        
        if (item.estatus === 'Pendiente') {
            acciones += `<i class="fas fa-check-circle" onclick="abrirModalAutorizar(${item.id}, '${item.folio}')" style="color: #28a745; cursor: pointer; margin: 0 3px;" title="Autorizar"></i>`;
            acciones += `<i class="fas fa-times-circle" onclick="abrirModalRechazar(${item.id}, '${item.folio}')" style="color: #dc3545; cursor: pointer; margin: 0 3px;" title="Rechazar"></i>`;
        }
        if (item.estatus === 'Aprobada') {
            acciones += `<i class="fas fa-truck" onclick="abrirModalSalida(${item.id})" style="color: #17a2b8; cursor: pointer; margin: 0 3px;" title="Registrar Salida"></i>`;
        }
        
        tbody.innerHTML += `
            <tr>
                <td><strong>${item.folio || 'N/A'}</strong></td>
                <td>${item.fecha_requisicion || 'N/A'}</td>
                <td>${item.proyecto_nombre || 'N/A'}</td>
                <td>${item.solicitante || 'N/A'}</td>
                <td>${item.activo_nombre || 'N/A'}<br><small>${item.activo_codigo || ''}</small></td>
                <td>${item.cantidad || 0}</td>
                <td>${item.fecha_requerida || 'N/A'}</td>
                <td><span class="${prioridadClass}">${item.prioridad || 'Media'}</span></td>
                <td><span class="${estatusClass}">${item.estatus || 'Pendiente'}</span></td>
                <td>${acciones}</td>
            </tr>
        `;
    });
}

function renderizarTablaDevoluciones(data) {
    const tbody = document.getElementById('tbodyDevoluciones');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align: center;">No hay asignaciones registradas<\/td><\/tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach(item => {
        let estatusClass = '';
        if (item.estatus === 'Activa') estatusClass = 'badge-asignada';
        else if (item.estatus === 'Devuelta') estatusClass = 'badge-devuelta';
        else estatusClass = 'badge-pendiente';
        
        let acciones = `<i class="fas fa-eye" onclick="verDetalleAsignacion(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;" title="Ver detalle"></i>`;
        
        if (item.estatus === 'Activa') {
            acciones += `<i class="fas fa-undo-alt" onclick="abrirModalDevolver(${item.id})" style="color: #28a745; cursor: pointer; margin: 0 3px;" title="Registrar Devolución"></i>`;
        }
        
        tbody.innerHTML += `
            <tr>
                <td>${item.folio_requisicion || '---'}</td>
                <td>${item.fecha_salida || 'N/A'}</td>
                <td>${item.proyecto_nombre || 'N/A'}</td>
                <td>${item.responsable_asignado || 'N/A'}</td>
                <td>${item.activo_nombre || 'N/A'}<br><small>${item.activo_codigo || ''}</small></td>
                <td>${item.valor_salida || '---'} ${item.unidad_medida || ''}</td>
                <td>${item.condicion_salida || '---'}</td>
                <td>${item.fecha_devolucion || '---'}</td>
                <td>${item.condicion_devolucion || '---'}</td>
                <td><span class="${estatusClass}">${item.estatus || 'Activa'}</span></td>
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
            let html = `<button class="page-btn" onclick="cambiarPaginaRequisiciones(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>Anterior</button>`;
            html += `<span style="margin: 0 10px;">Página ${currentPage} de ${lastPage}</span>`;
            html += `<button class="page-btn" onclick="cambiarPaginaRequisiciones(${currentPage + 1})" ${currentPage >= lastPage ? 'disabled' : ''}>Siguiente</button>`;
            container.innerHTML = html;
        }
    } else {
        currentPageDevoluciones = currentPage;
        const container = document.getElementById('paginacionDevoluciones');
        if (container) {
            let html = `<button class="page-btn" onclick="cambiarPaginaDevoluciones(${currentPage - 1})" ${currentPage <= 1 ? 'disabled' : ''}>Anterior</button>`;
            html += `<span style="margin: 0 10px;">Página ${currentPage} de ${lastPage}</span>`;
            html += `<button class="page-btn" onclick="cambiarPaginaDevoluciones(${currentPage + 1})" ${currentPage >= lastPage ? 'disabled' : ''}>Siguiente</button>`;
            container.innerHTML = html;
        }
    }
}

function cambiarPaginaRequisiciones(page) { if (page >= 1 && page <= totalPagesRequisiciones) { currentPageRequisiciones = page; cargarRequisiciones(); } }
function cambiarPaginaDevoluciones(page) { if (page >= 1 && page <= totalPagesDevoluciones) { currentPageDevoluciones = page; cargarDevoluciones(); } }

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        currentPageRequisiciones = 1;
        currentPageDevoluciones = 1;
        cargarRequisiciones();
        cargarDevoluciones();
    });
    document.getElementById('btnExportar')?.addEventListener('click', () => alert('Exportación en desarrollo'));
}

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

function abrirModalRequisicion() {
    document.getElementById('reqProyecto').value = '';
    document.getElementById('reqFechaRequerida').value = new Date(Date.now() + 3*24*60*60*1000).toISOString().split('T')[0];
    document.getElementById('reqActivo').value = '';
    document.getElementById('reqCantidad').value = '1';
    document.getElementById('reqSolicitante').value = '';
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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
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

function verDetalleRequisicion(id) {
    fetch(`/almacen/api/requisiciones-activos/${id}`)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                const r = response.data;
                let detalles = `REQUISICIÓN ${r.folio}\n`;
                detalles += `Proyecto: ${r.proyecto_nombre}\n`;
                detalles += `Activo: ${r.activo_nombre} (${r.activo_codigo})\n`;
                detalles += `Cantidad: ${r.cantidad}\n`;
                detalles += `Solicitante: ${r.solicitante}\n`;
                detalles += `Área: ${r.area || 'N/A'}\n`;
                detalles += `Fecha Requerida: ${r.fecha_requerida}\n`;
                detalles += `Prioridad: ${r.prioridad}\n`;
                detalles += `Estatus: ${r.estatus}\n`;
                detalles += `Motivo: ${r.motivo}\n`;
                if (r.observaciones) detalles += `Observaciones: ${r.observaciones}\n`;
                if (r.motivo_rechazo) detalles += `Motivo Rechazo: ${r.motivo_rechazo}\n`;
                alert(detalles);
            } else {
                alert('Error: ' + response.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar detalle');
        });
}

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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ observaciones: observaciones })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalAutorizar();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    });
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
    if (!motivo) {
        alert('El motivo es obligatorio');
        return;
    }
    fetch(`/almacen/api/requisiciones-activos/${requisicionSeleccionada}/rechazar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ motivo: motivo })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalRechazar();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    });
}

function abrirModalSalida(requisicionId) {
    document.getElementById('salidaRequisicionId').value = requisicionId;
    document.getElementById('salidaResponsable').value = '';
    document.getElementById('salidaFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('salidaHorometro').value = '';
    document.getElementById('salidaKilometraje').value = '';
    document.getElementById('salidaCondicion').value = 'Bueno';
    document.getElementById('salidaObservaciones').value = '';
    
    document.getElementById('divHorometro').style.display = 'none';
    document.getElementById('divKilometraje').style.display = 'none';
    
    document.getElementById('modalSalida').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalSalida() {
    document.getElementById('modalSalida').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarSalida() {
    const responsable = document.getElementById('salidaResponsable').value.trim();
    if (!responsable) {
        alert('El responsable es obligatorio');
        return;
    }
    
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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalSalida();
            cargarRequisiciones();
            cargarDevoluciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    });
}

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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalDevolver();
            cargarRequisiciones();
            cargarDevoluciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    });
}

function verDetalleAsignacion(id) {
    alert('Función en desarrollo - Detalle de asignación ID: ' + id);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        cerrarModalRequisicion();
        cerrarModalAutorizar();
        cerrarModalRechazar();
        cerrarModalSalida();
        cerrarModalDevolver();
    }
});

['modalRequisicion', 'modalAutorizar', 'modalRechazar', 'modalSalida', 'modalDevolver'].forEach(modalId => {
    document.getElementById(modalId)?.addEventListener('click', (e) => {
        if (e.target === this) {
            const closeFn = {
                'modalRequisicion': cerrarModalRequisicion,
                'modalAutorizar': cerrarModalAutorizar,
                'modalRechazar': cerrarModalRechazar,
                'modalSalida': cerrarModalSalida,
                'modalDevolver': cerrarModalDevolver
            }[modalId];
            if (closeFn) closeFn();
        }
    });
});
</script>
@endsection