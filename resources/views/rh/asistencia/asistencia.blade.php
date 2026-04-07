@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Hoja de Asistencias -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Hoja de Asistencias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Selector de fecha y boton para registrar asistencias masivas -->
                <div style="display: flex; gap: 10px; margin-bottom: 20px; align-items: flex-end; flex-wrap: wrap; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div>
                        <label style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 5px;">Fecha para registrar asistencias</label>
                        <input type="date" id="fechaRegistroMasivo" style="padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
                    </div>
                    <div>
                        <button id="btnRegistrarMasivo" style="background: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-check-double"></i> Registrar Asistencia Masiva
                        </button>
                    </div>
                </div>

                <!-- Filtros rapidos -->
                <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; align-items: flex-end;">
                    <div>
                        <label style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 5px;">Fecha Inicio</label>
                        <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 5px;">Fecha Fin</label>
                        <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; color: #6c757d; display: block; margin-bottom: 5px;">Estatus</label>
                        <select id="filtroEstatus" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos</option>
                            <option value="Activo">Activo</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Justificado">Justificado</option>
                            <option value="Falta">Falta</option>
                            <option value="Retardo">Retardo</option>
                        </select>
                    </div>
                    <div>
                        <button id="btnFiltrar" style="background: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 6px 20px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                    <div>
                        <button id="btnLimpiarFiltros" style="background: #6c757d; color: white; border: none; border-radius: 4px; padding: 6px 20px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-undo"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aqui para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="exportarExcel()">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">X</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <div style="position: relative; min-width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, folio..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Asistencias -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaAsistencias" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="hora_entrada">Entrada</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="hora_salida">Salida</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                             </tr>
                        </thead>
                        <tbody id="tablaBody">
                             <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: var(--color-primary);"></i>
                                    <p style="margin-top: 10px; color: #6c757d;">Cargando datos...</p>
                                 </td>
                             </tr>
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                             <tr>
                                <td colspan="8" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">
                                    Total Asistencias: <span id="totalAsistencias">0</span> | 
                                    Activos: <span id="totalActivos" style="color: #28a745;">0</span> | 
                                    Pendientes: <span id="totalPendientes" style="color: #ffc107;">0</span> | 
                                    Faltas: <span id="totalFaltas" style="color: #dc3545;">0</span> | 
                                    Retardos: <span id="totalRetardos" style="color: #fd7e14;">0</span>
                                 </td>
                             </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginacion -->
                <div id="paginacion" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                    <div style="font-size: 13px; color: #6c757d;">
                        Mostrando <span id="desde">0</span> a <span id="hasta">0</span> de <span id="total">0</span> registros
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button id="prevPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" disabled>Anterior</button>
                        <span id="paginaActual" style="padding: 6px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                        <button id="nextPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;">Siguiente</button>
                    </div>
                </div>
                
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA REGISTRO MASIVO DE ASISTENCIA -->
<div id="modalRegistroMasivo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10;">
            <h3 style="color: white; margin: 0; font-size: 18px;">
                <i class="fas fa-check-double"></i> Registrar Asistencias - <span id="modalFechaMostrar"></span>
            </h3>
            <button onclick="cerrarModalRegistroMasivo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">X</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 20px; padding: 10px; background: #e8f0fe; border-radius: 8px;">
                <p style="margin: 0; font-size: 13px;"><i class="fas fa-info-circle"></i> Marca con ✓ los empleados que asistieron. Los que no se marquen quedaran como "Pendiente".</p>
            </div>
            
            <div id="sinEmpleadosMsg" style="display: none; text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px;">
                <i class="fas fa-users-slash" style="font-size: 48px; color: #6c757d;"></i>
                <p style="margin-top: 15px; color: #6c757d;">No tiene empleados a cargo para registrar asistencias.</p>
                <p style="font-size: 12px; color: #999;">Contacte al administrador para asignarle empleados.</p>
            </div>
            
            <div id="tablaEmpleadosContainer" style="overflow-x: auto; display: none;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center; width: 50px;">
                                <input type="checkbox" id="seleccionarTodos" onchange="toggleSeleccionarTodos(this)">
                            </th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Empleado</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Area</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Puesto</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Hora Entrada</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Hora Salida</th>
                        </tr>
                    </thead>
                    <tbody id="listaEmpleadosMasivo"></tbody>
                </table>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="cerrarModalRegistroMasivo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button type="button" id="btnGuardarMasivo" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;" onclick="guardarAsistenciasMasivas()">
                    <i class="fas fa-save"></i> Guardar Asistencias
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR ASISTENCIA INDIVIDUAL -->
<div id="modalAsistencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 550px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTitulo">Editar Asistencia</h3>
            <button onclick="cerrarModalAsistencia()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">X</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formAsistencia" onsubmit="event.preventDefault(); guardarAsistenciaIndividual();">
                @csrf
                <input type="hidden" id="asistenciaId" value="">
                <input type="hidden" id="empleadoIdEdit" value="">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado</label>
                        <input type="text" id="empleadoNombre" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #f8f9fa;" readonly>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha</label>
                        <input type="date" id="fechaEdit" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required readonly>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hora Entrada</label>
                            <input type="time" id="horaEntradaEdit" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                        
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hora Salida</label>
                            <input type="time" id="horaSalidaEdit" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                        <textarea id="observacionesEdit" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                        <select id="estatusEdit" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="Activo">Activo</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Justificado">Justificado</option>
                            <option value="Falta">Falta</option>
                            <option value="Retardo">Retardo</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalAsistencia()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 450px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Detalle de Asistencia</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">X</button>
        </div>
        <div style="padding: 20px;" id="detalleContenido"></div>
    </div>
</div>

<!-- Notificacion -->
<div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000000; min-width: 300px; background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease; overflow: hidden;">
    <div id="notificationHeader" style="padding: 15px 20px; font-weight: bold; display: flex; align-items: center; gap: 10px;">
        <i id="notificationIcon" class="fas"></i>
        <span id="notificationTitle"></span>
    </div>
    <div id="notificationBody" style="padding: 15px 20px; border-top: 1px solid #eee;">
        <span id="notificationMessage"></span>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background: white; width: 100%; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; font-size: 12px; white-space: nowrap; text-align: center; font-weight: 600; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; font-size: 12px; vertical-align: middle; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table th:last-child, .table td:last-child { position: sticky !important; right: 0 !important; z-index: 35 !important; box-shadow: -2px 0 5px rgba(0,0,0,0.1) !important; }
    .badge-activo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-justificado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-falta { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-retardo { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-size: 12px; font-weight: bold; color: var(--color-primary); }
    #modalAsistencia, #modalDetalle, #modalRegistroMasivo { display: none; align-items: center; justify-content: center; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-50px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 768px) { .hide-mobile { display: none !important; } .table-container { max-height: 500px; } .table td { padding: 8px 4px; font-size: 11px; } #modalAsistencia > div, #modalDetalle > div, #modalRegistroMasivo > div { width: 100%; height: 100%; max-height: 100vh; border-radius: 0; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let datosAsistencias = [];
let empleadosACargo = [];
let paginaActual = 1;
let registrosPorPagina = 10;
let columnasAgrupadas = [];
let cargando = false;

document.addEventListener('DOMContentLoaded', function() {
    cargarDatos();
    cargarEmpleadosACargo();
    
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fechaRegistroMasivo').value = hoy;
    
    document.getElementById('buscador').addEventListener('input', function() { paginaActual = 1; cargarDatos(); });
    document.getElementById('btnFiltrar').addEventListener('click', function() { paginaActual = 1; cargarDatos(); });
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);
    document.getElementById('btnCrearFiltro').addEventListener('click', () => mostrarNotificacion('info', 'Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', exportarExcel);
    document.getElementById('prevPage').addEventListener('click', () => cambiarPagina('prev'));
    document.getElementById('nextPage').addEventListener('click', () => cambiarPagina('next'));
    document.getElementById('btnRegistrarMasivo').addEventListener('click', abrirModalRegistroMasivo);
});

function cargarEmpleadosACargo() {
    if (cargando) return;
    cargando = true;
    
    fetch('/api/asistencias/empleados-a-cargo', {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            empleadosACargo = data.data;
        } else {
            empleadosACargo = [];
        }
        cargando = false;
    })
    .catch(error => {
        empleadosACargo = [];
        cargando = false;
    });
}

function cargarDatos() {
    if (cargando) return;
    cargando = true;
    
    const params = new URLSearchParams();
    if (document.getElementById('fechaInicio').value) params.append('fecha_inicio', document.getElementById('fechaInicio').value);
    if (document.getElementById('fechaFin').value) params.append('fecha_fin', document.getElementById('fechaFin').value);
    if (document.getElementById('filtroEstatus').value) params.append('estatus', document.getElementById('filtroEstatus').value);
    if (document.getElementById('buscador').value) params.append('buscar', document.getElementById('buscador').value);
    
    const tbody = document.getElementById('tablaBody');
    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i><p>Cargando datos...</p></td></tr>';
    
    fetch(`/api/asistencias?${params.toString()}`, {
        headers: { 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            datosAsistencias = data.data.asistencias || [];
            renderizarTabla();
            actualizarTotales(data.data);
        } else {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #dc3545;"></i><p>Error: ' + (data.message || 'Error desconocido') + '</p></td></tr>';
        }
        cargando = false;
    })
    .catch(error => {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #dc3545;"></i><p>Error de conexion</p></td></tr>';
        cargando = false;
    });
}

function renderizarTabla() {
    const tbody = document.getElementById('tablaBody');
    const inicio = (paginaActual - 1) * registrosPorPagina;
    const fin = inicio + registrosPorPagina;
    const paginaDatos = datosAsistencias.slice(inicio, fin);
    
    if (paginaDatos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-info-circle" style="font-size: 24px;"></i><p>No hay registros de asistencia</p></div>';
        document.getElementById('desde').textContent = '0';
        document.getElementById('hasta').textContent = '0';
        document.getElementById('total').textContent = '0';
        return;
    }
    
    let html = '';
    paginaDatos.forEach((asistencia, index) => {
        const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';
        let estatusBadge = '';
        switch(asistencia.estatus) {
            case 'Activo': estatusBadge = '<span class="badge-activo">Activo</span>'; break;
            case 'Pendiente': estatusBadge = '<span class="badge-pendiente">Pendiente</span>'; break;
            case 'Justificado': estatusBadge = '<span class="badge-justificado">Justificado</span>'; break;
            case 'Falta': estatusBadge = '<span class="badge-falta">Falta</span>'; break;
            case 'Retardo': estatusBadge = '<span class="badge-retardo">Retardo</span>'; break;
            default: estatusBadge = `<span class="badge-pendiente">${asistencia.estatus}</span>`;
        }
        
        const nombreEmpleado = asistencia.nombre_persona || asistencia.empleado || '-';
        
        html += `
            <tr ${bgColor}>
                <td style="text-align: center;">${asistencia.folio || '-'} 
                <td style="text-align: left;">${nombreEmpleado} 
                <td style="text-align: center;">${asistencia.fecha || '-'} 
                <td style="text-align: center;">${asistencia.hora_entrada || '-'} 
                <td style="text-align: center;">${asistencia.hora_salida || '-'} 
                <td style="text-align: left;">${asistencia.observaciones || '-'} 
                <td style="text-align: center;">${estatusBadge} 
                <td style="text-align: center;">
                    <i class="fas fa-eye" onclick="verAsistencia(${asistencia.id})" title="Ver detalle"></i>
                    <i class="fas fa-edit" onclick="editarAsistencia(${asistencia.id})" title="Editar"></i>
                    <i class="fas fa-trash" onclick="eliminarAsistencia(${asistencia.id})" title="Eliminar"></i>
                 
              </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    const total = datosAsistencias.length;
    const desde = total === 0 ? 0 : (paginaActual - 1) * registrosPorPagina + 1;
    const hasta = Math.min(paginaActual * registrosPorPagina, total);
    
    document.getElementById('desde').textContent = desde;
    document.getElementById('hasta').textContent = hasta;
    document.getElementById('total').textContent = total;
    document.getElementById('paginaActual').textContent = paginaActual;
    document.getElementById('prevPage').disabled = paginaActual === 1;
    document.getElementById('nextPage').disabled = paginaActual >= Math.ceil(total / registrosPorPagina);
}

function actualizarTotales(data) {
    document.getElementById('totalAsistencias').textContent = data.totalAsistencias || 0;
    document.getElementById('totalActivos').textContent = data.asistenciasActivas || 0;
    document.getElementById('totalPendientes').textContent = data.asistenciasPendientes || 0;
    document.getElementById('totalFaltas').textContent = data.asistenciasFaltas || 0;
    document.getElementById('totalRetardos').textContent = data.asistenciasRetardos || 0;
}

function limpiarFiltros() {
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    document.getElementById('filtroEstatus').value = '';
    document.getElementById('buscador').value = '';
    paginaActual = 1;
    cargarDatos();
}

function cambiarPagina(direccion) {
    const totalPaginas = Math.ceil(datosAsistencias.length / registrosPorPagina);
    if (direccion === 'prev' && paginaActual > 1) paginaActual--;
    if (direccion === 'next' && paginaActual < totalPaginas) paginaActual++;
    renderizarTabla();
}

function mostrarNotificacion(tipo, mensaje) {
    const notification = document.getElementById('notification');
    const header = document.getElementById('notificationHeader');
    const icon = document.getElementById('notificationIcon');
    const title = document.getElementById('notificationTitle');
    const body = document.getElementById('notificationMessage');
    
    const config = {
        success: { bg: '#28a745', icon: 'fa-check-circle', title: 'Exito' },
        error: { bg: '#dc3545', icon: 'fa-times-circle', title: 'Error' },
        warning: { bg: '#ffc107', icon: 'fa-exclamation-triangle', title: 'Advertencia' },
        info: { bg: '#17a2b8', icon: 'fa-info-circle', title: 'Informacion' }
    };
    
    const cfg = config[tipo] || config.info;
    header.style.backgroundColor = cfg.bg;
    header.style.color = tipo === 'warning' ? '#212529' : 'white';
    icon.className = `fas ${cfg.icon}`;
    title.textContent = cfg.title;
    body.textContent = mensaje;
    notification.style.display = 'block';
    setTimeout(() => notification.style.display = 'none', 3000);
}

function abrirModalRegistroMasivo() {
    const fecha = document.getElementById('fechaRegistroMasivo').value;
    
    if (!fecha) {
        mostrarNotificacion('warning', 'Seleccione una fecha para registrar asistencias');
        return;
    }
    
    if (empleadosACargo.length === 0) {
        mostrarNotificacion('info', 'Cargando empleados a cargo...');
        
        fetch('/api/asistencias/empleados-a-cargo', {
            headers: { 
                'Accept': 'application/json', 
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                empleadosACargo = data.data;
                abrirModalConEmpleados(fecha);
            } else {
                mostrarNotificacion('error', 'No se pudieron cargar los empleados a cargo');
                document.getElementById('sinEmpleadosMsg').style.display = 'block';
                document.getElementById('tablaEmpleadosContainer').style.display = 'none';
                document.getElementById('btnGuardarMasivo').style.display = 'none';
                document.getElementById('modalFechaMostrar').textContent = fecha;
                document.getElementById('modalRegistroMasivo').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => {
            mostrarNotificacion('error', 'Error de conexion');
        });
        return;
    }
    
    abrirModalConEmpleados(fecha);
}

function abrirModalConEmpleados(fecha) {
    if (empleadosACargo.length === 0) {
        document.getElementById('sinEmpleadosMsg').style.display = 'block';
        document.getElementById('tablaEmpleadosContainer').style.display = 'none';
        document.getElementById('btnGuardarMasivo').style.display = 'none';
        document.getElementById('modalFechaMostrar').textContent = fecha;
        document.getElementById('modalRegistroMasivo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        return;
    }
    
    document.getElementById('sinEmpleadosMsg').style.display = 'none';
    document.getElementById('tablaEmpleadosContainer').style.display = 'block';
    document.getElementById('btnGuardarMasivo').style.display = 'inline-block';
    document.getElementById('modalFechaMostrar').textContent = fecha;
    
    const tbody = document.getElementById('listaEmpleadosMasivo');
    let html = '';
    empleadosACargo.forEach(emp => {
        html += `
            <tr>
                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                    <input type="checkbox" class="check-empleado" data-id="${emp.id}" data-nombre="${emp.nombre_completo}">
                 </td>
                <td style="padding: 10px; border: 1px solid #dee2e6;">${emp.nombre_completo}</td>
                <td style="padding: 10px; border: 1px solid #dee2e6;">${emp.area || '-'}</td>
                <td style="padding: 10px; border: 1px solid #dee2e6;">${emp.puesto || '-'}</td>
                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                    <input type="time" class="hora-entrada" data-id="${emp.id}" value="09:00" style="padding: 4px 8px; border: 1px solid #ced4da; border-radius: 4px; width: 100px;">
                </td>
                <td style="padding: 10px; border: 1px solid #dee2e6; text-align: center;">
                    <input type="time" class="hora-salida" data-id="${emp.id}" value="18:00" style="padding: 4px 8px; border: 1px solid #ced4da; border-radius: 4px; width: 100px;">
                </td>
              </tr>
        `;
    });
    tbody.innerHTML = html;
    
    document.getElementById('modalRegistroMasivo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function toggleSeleccionarTodos(checkbox) {
    const checkboxes = document.querySelectorAll('.check-empleado');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
}

function cerrarModalRegistroMasivo() {
    document.getElementById('modalRegistroMasivo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarAsistenciasMasivas() {
    const fecha = document.getElementById('fechaRegistroMasivo').value;
    const checkboxes = document.querySelectorAll('.check-empleado:checked');
    
    if (checkboxes.length === 0) {
        mostrarNotificacion('warning', 'Seleccione al menos un empleado');
        return;
    }
    
    const asistencias = [];
    checkboxes.forEach(cb => {
        const empleadoId = cb.getAttribute('data-id');
        const horaEntrada = document.querySelector(`.hora-entrada[data-id="${empleadoId}"]`).value;
        const horaSalida = document.querySelector(`.hora-salida[data-id="${empleadoId}"]`).value;
        
        asistencias.push({
            plantilla_id: empleadoId,
            fecha: fecha,
            hora_entrada: horaEntrada,
            hora_salida: horaSalida,
            estatus: 'Activo'
        });
    });
    
    mostrarNotificacion('info', `Guardando ${asistencias.length} asistencias...`);
    
    fetch('/api/asistencias/masivo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ asistencias: asistencias })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('success', data.message);
            cerrarModalRegistroMasivo();
            cargarDatos();
        } else {
            mostrarNotificacion('error', data.message || 'Error al guardar asistencias');
        }
    })
    .catch(error => {
        mostrarNotificacion('error', 'Error de conexion al servidor');
    });
}

function abrirModalAsistencia(id = null) {
    document.getElementById('modalTitulo').textContent = id ? 'Editar Asistencia' : 'Nueva Asistencia';
    document.getElementById('asistenciaId').value = id || '';
    
    if (id) {
        fetch(`/api/asistencias/${id}`, { 
            headers: { 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            } 
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('asistenciaId').value = data.data.id;
                document.getElementById('empleadoIdEdit').value = data.data.plantilla_id;
                document.getElementById('empleadoNombre').value = data.data.nombre_persona || data.data.empleado || '';
                document.getElementById('fechaEdit').value = data.data.fecha;
                document.getElementById('horaEntradaEdit').value = data.data.hora_entrada || '';
                document.getElementById('horaSalidaEdit').value = data.data.hora_salida || '';
                document.getElementById('observacionesEdit').value = data.data.observaciones || '';
                document.getElementById('estatusEdit').value = data.data.estatus;
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    document.getElementById('modalAsistencia').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalAsistencia() {
    document.getElementById('modalAsistencia').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function guardarAsistenciaIndividual() {
    const id = document.getElementById('asistenciaId').value;
    const data = {
        plantilla_id: document.getElementById('empleadoIdEdit').value,
        fecha: document.getElementById('fechaEdit').value,
        hora_entrada: document.getElementById('horaEntradaEdit').value,
        hora_salida: document.getElementById('horaSalidaEdit').value,
        observaciones: document.getElementById('observacionesEdit').value,
        estatus: document.getElementById('estatusEdit').value
    };
    
    const url = id ? `/api/asistencias/${id}` : '/api/asistencias';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('success', data.message);
            cerrarModalAsistencia();
            cargarDatos();
        } else {
            mostrarNotificacion('error', data.message || 'Error al guardar');
        }
    })
    .catch(error => {
        mostrarNotificacion('error', 'Error de conexion');
    });
}

function verAsistencia(id) {
    fetch(`/api/asistencias/${id}`, { 
        headers: { 
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        } 
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const a = data.data;
            let estatusBadge = '';
            switch(a.estatus) {
                case 'Activo': estatusBadge = '<span class="badge-activo">Activo</span>'; break;
                case 'Pendiente': estatusBadge = '<span class="badge-pendiente">Pendiente</span>'; break;
                case 'Justificado': estatusBadge = '<span class="badge-justificado">Justificado</span>'; break;
                case 'Falta': estatusBadge = '<span class="badge-falta">Falta</span>'; break;
                case 'Retardo': estatusBadge = '<span class="badge-retardo">Retardo</span>'; break;
                default: estatusBadge = a.estatus;
            }
            
            const nombreEmpleado = a.nombre_persona || a.empleado || '-';
            
            document.getElementById('detalleContenido').innerHTML = `
                <div style="display: grid; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Folio:</strong> <span>${a.folio || '-'}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Empleado:</strong> <span>${nombreEmpleado}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Fecha:</strong> <span>${a.fecha || '-'}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Hora Entrada:</strong> <span>${a.hora_entrada || '-'}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Hora Salida:</strong> <span>${a.hora_salida || '-'}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Observaciones:</strong> <span>${a.observaciones || '-'}</span></div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 8px;"><strong>Estatus:</strong> <span>${estatusBadge}</span></div>
                    <div style="display: flex; justify-content: space-between;"><strong>Registrado por:</strong> <span>${a.registrado_por || '-'}</span></div>
                </div>
            `;
            document.getElementById('modalDetalle').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    })
    .catch(error => console.error('Error:', error));
}

function editarAsistencia(id) { cerrarModalDetalle(); abrirModalAsistencia(id); }

function eliminarAsistencia(id) {
    if (confirm('Esta seguro de eliminar esta asistencia?')) {
        fetch(`/api/asistencias/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', data.message);
                cargarDatos();
            } else {
                mostrarNotificacion('error', data.message || 'Error al eliminar');
            }
        })
        .catch(error => {
            mostrarNotificacion('error', 'Error de conexion');
        });
    }
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function exportarExcel() {
    mostrarNotificacion('info', 'Generando archivo Excel...');
    const buscar = document.getElementById('buscador').value;
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const estatus = document.getElementById('filtroEstatus').value;
    
    let url = '/rh/asistencia/exportar-excel?';
    if (buscar) url += `buscar=${encodeURIComponent(buscar)}&`;
    if (fechaInicio) url += `fecha_inicio=${fechaInicio}&`;
    if (fechaFin) url += `fecha_fin=${fechaFin}&`;
    if (estatus) url += `estatus=${estatus}&`;
    
    window.open(url, '_blank');
    setTimeout(() => mostrarNotificacion('success', 'Descargando archivo Excel...'), 1000);
}

document.querySelectorAll('[draggable="true"]').forEach(th => {
    th.addEventListener('dragstart', (e) => e.dataTransfer.setData('text/plain', e.target.dataset.columna));
});

document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
    e.preventDefault();
    const columna = e.dataTransfer.getData('text/plain');
    if (columna && !columnasAgrupadas.includes(columna)) {
        columnasAgrupadas.push(columna);
        actualizarGrupoColumnas();
        mostrarNotificacion('info', 'Agrupando por: ' + columna);
    }
});

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    const texto = document.getElementById('textoAgrupar');
    container.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
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

window.toggleColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    if (selector.style.display === 'block') {
        const columnas = ['folio', 'empleado', 'fecha', 'hora_entrada', 'hora_salida', 'observaciones', 'estatus'];
        const lista = document.getElementById('columnasLista');
        lista.innerHTML = columnas.map(col => `
            <div style="padding: 5px 0;">
                <input type="checkbox" id="chk_${col}" data-columna="${col}" checked style="margin-right: 8px; accent-color: var(--color-primary);" onchange="toggleColumna('${col}', this.checked)">
                <label for="chk_${col}" style="font-size: 12px;">${col.charAt(0).toUpperCase() + col.slice(1)}</label>
            </div>
        `).join('');
    }
};

window.toggleColumna = function(columna, visible) {
    const indices = { folio: 0, empleado: 1, fecha: 2, hora_entrada: 3, hora_salida: 4, observaciones: 5, estatus: 6 };
    const index = indices[columna];
    if (index !== undefined) {
        document.querySelectorAll(`#tablaAsistencias th:nth-child(${index + 1}), #tablaAsistencias td:nth-child(${index + 1})`)
            .forEach(celda => celda.style.display = visible ? '' : 'none');
    }
};

window.cerrarColumnSelector = () => document.getElementById('columnSelector').style.display = 'none';

document.addEventListener('click', (e) => {
    if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
        document.getElementById('columnSelector').style.display = 'none';
    }
});

document.addEventListener('keydown', (e) => { 
    if (e.key === 'Escape') { 
        cerrarModalAsistencia(); 
        cerrarModalDetalle();
        cerrarModalRegistroMasivo();
    } 
});

document.getElementById('modalAsistencia').addEventListener('click', (e) => { if (e.target === e.currentTarget) cerrarModalAsistencia(); });
document.getElementById('modalDetalle').addEventListener('click', (e) => { if (e.target === e.currentTarget) cerrarModalDetalle(); });
document.getElementById('modalRegistroMasivo').addEventListener('click', (e) => { if (e.target === e.currentTarget) cerrarModalRegistroMasivo(); });
</script>
@endsection