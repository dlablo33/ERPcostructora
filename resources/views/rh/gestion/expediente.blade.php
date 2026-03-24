@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Incidencias -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Incidencias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros adicionales -->
                <div style="display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-size: 12px; font-weight: 600;">Filtrar por estatus:</label>
                        <select id="filtroEstatus" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                            <option value="">Todos</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                            <option value="Resuelta">Resuelta</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-size: 12px; font-weight: 600;">Fecha desde:</label>
                        <input type="date" id="filtroFechaDesde" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-size: 12px; font-weight: 600;">Fecha hasta:</label>
                        <input type="date" id="filtroFechaHasta" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                    </div>
                    <div>
                        <button id="btnAplicarFiltros" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 6px 15px; cursor: pointer; font-size: 12px;">
                            <i class="fas fa-search"></i> Aplicar
                        </button>
                        <button id="btnLimpiarFiltros" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 6px 15px; cursor: pointer; font-size: 12px;">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Selector de registros por página -->
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <label style="font-size: 12px;">Mostrar:</label>
                            <select id="perPage" style="padding: 6px 8px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>

                        <!-- Botón Agregar -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;" 
                                    title="Agregar incidencia">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Incidencias -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaIncidencias" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr id="encabezadosTabla">
                                <th draggable="true" data-columna="incidencia_id" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">ID</th>
                                <th draggable="true" data-columna="estatus" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Estatus</th>
                                <th draggable="true" data-columna="empleado" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Empleado</th>
                                <th draggable="true" data-columna="tipo" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Tipo Incidencia</th>
                                <th draggable="true" data-columna="descripcion" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Descripción</th>
                                <th draggable="true" data-columna="fecha" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: var(--color-primary);"></i>
                                    <p style="margin-top: 10px;">Cargando incidencias...</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr id="totalesFooter">
                                <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">
                                    Total: <span id="totalRegistros">0</span> | 
                                    Pendientes: <span id="totalPendientes">0</span> | 
                                    Aprobadas: <span id="totalAprobadas">0</span> | 
                                    Rechazadas: <span id="totalRechazadas">0</span> | 
                                    Resueltas: <span id="totalResueltas">0</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
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

                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro avanzado
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR INCIDENCIA -->
<div id="modalIncidencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTitulo">
                    <i class="fas fa-exclamation-triangle"></i> Nueva Incidencia
                </h3>
                <button onclick="cerrarModalIncidencia()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; font-size: 18px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <form id="formIncidencia" onsubmit="event.preventDefault(); guardarIncidencia();">
            @csrf
            <input type="hidden" id="modalIncidenciaId" value="">

            <div style="padding: 25px;">
                <!-- Empleado -->
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Empleado *</label>
                    <select id="modalPlantillaId" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="">-- Seleccionar empleado --</option>
                    </select>
                </div>

                <!-- Tipo de Incidencia -->
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Tipo de Incidencia *</label>
                    <select id="modalCatTipoIncidenciaId" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="">-- Seleccionar tipo --</option>
                    </select>
                </div>

                <!-- Fecha de Incidencia -->
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Fecha de Incidencia *</label>
                    <input type="date" id="modalFechaIncidencia" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>

                <!-- Descripción -->
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Descripción *</label>
                    <textarea id="modalDescripcion" rows="4" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa la incidencia..." required></textarea>
                </div>

                <!-- Estatus (solo para edición) -->
                <div style="margin-bottom: 15px; display: none;" id="campoEstatus">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusIncidencia" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobada">Aprobada</option>
                        <option value="Rechazada">Rechazada</option>
                        <option value="Resuelta">Resuelta</option>
                    </select>
                </div>

                <!-- Comentarios de resolución (solo para edición) -->
                <div style="margin-bottom: 15px; display: none;" id="campoComentarios">
                    <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Comentarios de Resolución</label>
                    <textarea id="modalComentariosResolucion" rows="3" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Comentarios sobre la resolución..."></textarea>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalIncidencia()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 30px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PARA VER DETALLE DE INCIDENCIA -->
<div id="modalVerIncidencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0;"><i class="fas fa-eye"></i> Detalle de Incidencia</h3>
                <button onclick="cerrarModalVer()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div style="padding: 25px;" id="detalleIncidenciaContenido"></div>
    </div>
</div>

<!-- MODAL PARA CAMBIAR ESTATUS DE INCIDENCIA -->
<div id="modalCambiarEstatus" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 450px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0;"><i class="fas fa-exchange-alt"></i> Cambiar Estatus</h3>
                <button onclick="cerrarModalCambiarEstatus()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div style="padding: 25px;">
            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Incidencia ID: <span id="estatusIncidenciaId" style="color: var(--color-primary);"></span></label>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Estatus Actual</label>
                <input type="text" id="estatusActual" readonly style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Nuevo Estatus *</label>
                <select id="nuevoEstatus" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                    <option value="Resuelta">Resuelta</option>
                </select>
            </div>
            <div style="margin-bottom: 15px; display: none;" id="campoComentarioResolucion">
                <label style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 5px;">Comentarios de Resolución</label>
                <textarea id="comentarioResolucion" rows="3" style="width:100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Agregar comentarios sobre la resolución..."></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="cerrarModalCambiarEstatus()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button type="button" onclick="actualizarEstatus()" style="padding: 8px 30px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notificación -->
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
    :root {
        --color-primary: #083CAE;
    }

    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 800px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        vertical-align: middle;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
        background-color: white !important;
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
    }
    
    .table td:last-child i {
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-exchange-alt {
        color: #17a2b8;
    }
    
    .table td:last-child i.fa-exchange-alt:hover {
        color: #0f6e8c;
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    
    .badge-inactivo {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    
    [draggable="true"] {
        cursor: grab;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background-color: #e8f0fe;
        border-radius: 4px;
        color: var(--color-primary);
        font-size: 11px;
        border: 1px solid var(--color-primary);
    }
    
    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: var(--color-primary);
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let datosIncidencias = [];
let datosFiltrados = [];
let columnasAgrupadas = [];
let columnasVisibles = ['incidencia_id', 'estatus', 'empleado', 'tipo', 'descripcion', 'fecha'];
let paginaActual = 1;
let registrosPorPagina = 10;
let totalRegistros = 0;
let modoAgrupado = false;
let datosAgrupados = [];
let incidenciaIdActual = null;

// Configuración de columnas
const columnas = [
    { field: 'incidencia_id', caption: 'ID', visible: true, type: 'number' },
    { field: 'estatus', caption: 'Estatus', visible: true, type: 'badge' },
    { field: 'empleado', caption: 'Empleado', visible: true },
    { field: 'tipo', caption: 'Tipo Incidencia', visible: true },
    { field: 'descripcion', caption: 'Descripción', visible: true },
    { field: 'fecha', caption: 'Fecha', visible: true, type: 'date' }
];

function mostrarNotificacion(tipo, mensaje) {
    const n = document.getElementById('notification');
    const h = document.getElementById('notificationHeader');
    const colores = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
    h.style.backgroundColor = colores[tipo] || colores.info;
    document.getElementById('notificationIcon').className = `fas fa-${tipo === 'success' ? 'check-circle' : tipo === 'error' ? 'times-circle' : tipo === 'warning' ? 'exclamation-triangle' : 'info-circle'}`;
    document.getElementById('notificationTitle').textContent = { success: 'Éxito', error: 'Error', warning: 'Advertencia', info: 'Información' }[tipo];
    document.getElementById('notificationMessage').textContent = mensaje;
    n.style.display = 'block';
    setTimeout(() => n.style.display = 'none', 3000);
}

function formatearValor(valor, tipo) {
    if (!valor && valor !== 0) return '-';
    
    if (typeof valor === 'object' && valor !== null) {
        if (valor.nombre_completo) return valor.nombre_completo;
        if (valor.nombre) {
            if (valor.apellido_paterno) {
                return `${valor.nombre} ${valor.apellido_paterno} ${valor.apellido_materno || ''}`;
            }
            return valor.nombre;
        }
        if (valor.descripcion) return valor.descripcion;
        if (valor.toString && valor.toString() === '[object Object]') return '-';
        return JSON.stringify(valor);
    }
    
    if (tipo === 'badge') {
        const badges = {
            'Pendiente': '<span class="badge-pendiente">Pendiente</span>',
            'Aprobada': '<span class="badge-activo">Aprobada</span>',
            'Rechazada': '<span class="badge-inactivo">Rechazada</span>',
            'Resuelta': '<span class="badge-activo">Resuelta</span>'
        };
        return badges[valor] || `<span class="badge-pendiente">${valor}</span>`;
    }
    if (tipo === 'date' && valor) {
        try {
            return new Date(valor).toLocaleDateString('es-MX');
        } catch { return valor; }
    }
    return valor;
}

function cargarIncidencias() {
    const params = new URLSearchParams();
    const buscar = document.getElementById('buscador')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    const fechaDesde = document.getElementById('filtroFechaDesde')?.value || '';
    const fechaHasta = document.getElementById('filtroFechaHasta')?.value || '';
    
    if (buscar) params.append('buscar', buscar);
    if (estatus) params.append('estatus', estatus);
    if (fechaDesde) params.append('fecha_desde', fechaDesde);
    if (fechaHasta) params.append('fecha_hasta', fechaHasta);
    
    const url = `/api/incidencias/datagrid?${params.toString()}`;
    
    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                datosIncidencias = data.data || [];
                datosIncidencias = datosIncidencias.map(inc => ({
                    ...inc,
                    empleado: inc.empleado || { nombre_completo: inc.empleado_nombre || '-' },
                    tipo: inc.tipo_incidencia || inc.tipo || { nombre: inc.tipo_nombre || '-' },
                    fecha: inc.fecha_incidencia || inc.fecha
                }));
                datosFiltrados = [...datosIncidencias];
                totalRegistros = datosIncidencias.length;
                
                document.getElementById('totalRegistros').textContent = data.total || datosIncidencias.length;
                document.getElementById('totalPendientes').textContent = data.pendientes || 0;
                document.getElementById('totalAprobadas').textContent = data.aprobadas || 0;
                document.getElementById('totalRechazadas').textContent = data.rechazadas || 0;
                document.getElementById('totalResueltas').textContent = data.resueltas || 0;
                
                renderizarTabla();
                actualizarPaginacion();
            } else {
                mostrarNotificacion('error', data.message || 'Error al cargar datos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error de conexión');
        });
}

function cargarEmpleados() {
    fetch('/api/plantilla/datagrid', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data) {
                const select = document.getElementById('modalPlantillaId');
                select.innerHTML = '<option value="">-- Seleccionar empleado --</option>';
                data.data.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.plantilla_id;
                    option.textContent = emp.nombre_completo;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error cargando empleados:', error));
}

function cargarTiposIncidencia() {
    fetch('/api/cat-tipos-incidencias/activos', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data) {
                const select = document.getElementById('modalCatTipoIncidenciaId');
                select.innerHTML = '<option value="">-- Seleccionar tipo --</option>';
                data.data.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.cat_tipo_incidencia_id;
                    option.textContent = tipo.nombre;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error cargando tipos:', error));
}

function renderizarTabla() {
    const tbody = document.getElementById('tablaBody');
    let datosMostrar = datosFiltrados;
    
    if (columnasAgrupadas.length) {
        const grupos = {};
        datosFiltrados.forEach(item => {
            let valor = item[columnasAgrupadas[0]] || 'Sin especificar';
            if (typeof valor === 'object') {
                valor = valor.nombre || valor.nombre_completo || 'Sin especificar';
            }
            if (!grupos[valor]) grupos[valor] = [];
            grupos[valor].push(item);
        });
        datosAgrupados = Object.entries(grupos).map(([v, i]) => ({ valor: v, items: i, count: i.length }));
        datosMostrar = datosAgrupados;
        modoAgrupado = true;
        totalRegistros = datosAgrupados.length;
    } else {
        modoAgrupado = false;
        totalRegistros = datosFiltrados.length;
    }
    
    const inicio = (paginaActual - 1) * registrosPorPagina;
    const pagina = datosMostrar.slice(inicio, inicio + registrosPorPagina);
    
    if (!pagina.length) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding:40px;"><i class="fas fa-info-circle" style="font-size:24px; margin-bottom:10px; display:block;"></i>No hay incidencias registradas</td></tr>`;
        actualizarPaginacion();
        return;
    }
    
    let html = '';
    
    if (modoAgrupado) {
        pagina.forEach(grupo => {
            html += `<tr style="background:#e3f2fd; font-weight:bold;"><td colspan="7" style="padding:10px 8px;"><i class="fas fa-folder-open"></i> ${columnasAgrupadas[0]}: ${grupo.valor} (${grupo.count} registros)</td></tr>`;
            grupo.items.forEach(item => {
                html += '<tr>';
                columnas.filter(c => columnasVisibles.includes(c.field)).forEach(c => {
                    let valor = item[c.field];
                    if (c.field === 'empleado' && typeof valor === 'object' && valor !== null) {
                        valor = valor.nombre_completo || valor.nombre || '-';
                    }
                    if (c.field === 'tipo' && typeof valor === 'object' && valor !== null) {
                        valor = valor.nombre || '-';
                    }
                    html += `<td style="padding:10px 8px;">${formatearValor(valor, c.type)}</td>`;
                });
                html += `<td style="padding:10px 8px; text-align:center; position: sticky; right: 0; background-color: white;">
                            <i class="fas fa-eye" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="verIncidencia(${item.incidencia_id})" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="editarIncidencia(${item.incidencia_id})" title="Editar"></i>
                            <i class="fas fa-exchange-alt" style="color:#17a2b8; margin:0 5px; cursor:pointer;" onclick="abrirModalCambiarEstatus(${item.incidencia_id}, '${item.estatus}')" title="Cambiar estatus"></i>
                            <i class="fas fa-trash" style="color:#dc3545; margin:0 5px; cursor:pointer;" onclick="eliminarIncidencia(${item.incidencia_id})" title="Eliminar"></i>
                          </td>`;
                html += '</tr>';
            });
        });
    } else {
        pagina.forEach(item => {
            html += '<tr>';
            columnas.filter(c => columnasVisibles.includes(c.field)).forEach(c => {
                let valor = item[c.field];
                if (c.field === 'empleado' && typeof valor === 'object' && valor !== null) {
                    valor = valor.nombre_completo || valor.nombre || '-';
                }
                if (c.field === 'tipo' && typeof valor === 'object' && valor !== null) {
                    valor = valor.nombre || '-';
                }
                html += `<td style="padding:10px 8px;">${formatearValor(valor, c.type)}</td>`;
            });
            html += `<td style="padding:10px 8px; text-align:center; position: sticky; right: 0; background-color: white;">
                        <i class="fas fa-eye" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="verIncidencia(${item.incidencia_id})" title="Ver detalle"></i>
                        <i class="fas fa-edit" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="editarIncidencia(${item.incidencia_id})" title="Editar"></i>
                        <i class="fas fa-exchange-alt" style="color:#17a2b8; margin:0 5px; cursor:pointer;" onclick="abrirModalCambiarEstatus(${item.incidencia_id}, '${item.estatus}')" title="Cambiar estatus"></i>
                        <i class="fas fa-trash" style="color:#dc3545; margin:0 5px; cursor:pointer;" onclick="eliminarIncidencia(${item.incidencia_id})" title="Eliminar"></i>
                      </td>`;
            html += '</tr>';
        });
    }
    
    tbody.innerHTML = html;
    actualizarPaginacion();
}

function actualizarPaginacion() {
    const total = Math.ceil(totalRegistros / registrosPorPagina);
    const desde = totalRegistros === 0 ? 0 : (paginaActual - 1) * registrosPorPagina + 1;
    const hasta = Math.min(paginaActual * registrosPorPagina, totalRegistros);
    
    document.getElementById('desde').textContent = desde;
    document.getElementById('hasta').textContent = hasta;
    document.getElementById('total').textContent = totalRegistros;
    document.getElementById('paginaActual').textContent = paginaActual;
    document.getElementById('prevPage').disabled = paginaActual === 1;
    document.getElementById('nextPage').disabled = paginaActual === total || total === 0;
}

function cambiarPagina(dir) {
    const total = Math.ceil(totalRegistros / registrosPorPagina);
    if (dir === 'prev' && paginaActual > 1) paginaActual--;
    else if (dir === 'next' && paginaActual < total) paginaActual++;
    renderizarTabla();
}

function cambiarRegistrosPorPagina() {
    registrosPorPagina = parseInt(document.getElementById('perPage').value);
    paginaActual = 1;
    renderizarTabla();
}

function aplicarFiltros() {
    cargarIncidencias();
}

function limpiarFiltros() {
    document.getElementById('filtroEstatus').value = '';
    document.getElementById('filtroFechaDesde').value = '';
    document.getElementById('filtroFechaHasta').value = '';
    document.getElementById('buscador').value = '';
    cargarIncidencias();
}

function guardarIncidencia() {
    const id = document.getElementById('modalIncidenciaId').value;
    const formData = new FormData();
    
    formData.append('plantilla_id', document.getElementById('modalPlantillaId').value);
    formData.append('cat_tipo_incidencia_id', document.getElementById('modalCatTipoIncidenciaId').value);
    formData.append('fecha_incidencia', document.getElementById('modalFechaIncidencia').value);
    formData.append('descripcion', document.getElementById('modalDescripcion').value);
    formData.append('_token', document.querySelector('input[name="_token"]')?.value || '');
    
    if (id) {
        formData.append('_method', 'PUT');
        formData.append('estatus', document.getElementById('modalEstatusIncidencia').value);
        formData.append('comentarios_resolucion', document.getElementById('modalComentariosResolucion').value);
    }
    
    const url = id ? `/api/incidencias/${id}` : '/api/incidencias';
    
    fetch(url, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('success', data.message || 'Incidencia guardada exitosamente');
            cerrarModalIncidencia();
            cargarIncidencias();
        } else {
            mostrarNotificacion('error', data.message || 'Error al guardar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('error', 'Error de conexión');
    });
}

function verIncidencia(id) {
    fetch(`/api/incidencias/${id}`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const inc = data.data;
                const getBadge = (estatus) => {
                    const badges = {
                        'Pendiente': '<span class="badge-pendiente">Pendiente</span>',
                        'Aprobada': '<span class="badge-activo">Aprobada</span>',
                        'Rechazada': '<span class="badge-inactivo">Rechazada</span>',
                        'Resuelta': '<span class="badge-activo">Resuelta</span>'
                    };
                    return badges[estatus] || estatus;
                };
                
                document.getElementById('detalleIncidenciaContenido').innerHTML = `
                    <div style="background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:15px;">
                        <h4 style="color:var(--color-primary); margin:0 0 10px 0;">Información General</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div><strong>ID:</strong> ${inc.incidencia_id}</div>
                            <div><strong>Estatus:</strong> ${getBadge(inc.estatus)}</div>
                            <div><strong>Empleado:</strong> ${inc.empleado?.nombre_completo || inc.empleado?.nombre || '-'}</div>
                            <div><strong>Tipo:</strong> ${inc.tipo_incidencia?.nombre || '-'}</div>
                            <div><strong>Fecha:</strong> ${inc.fecha_incidencia ? new Date(inc.fecha_incidencia).toLocaleDateString('es-MX') : '-'}</div>
                            <div><strong>Descripción:</strong> ${inc.descripcion || '-'}</div>
                        </div>
                    </div>
                    ${inc.autorizador ? `
                    <div style="background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:15px;">
                        <h4 style="color:var(--color-primary); margin:0 0 10px 0;">Autorización</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div><strong>Autorizado por:</strong> ${inc.autorizador?.nombre_completo || '-'}</div>
                            <div><strong>Fecha autorización:</strong> ${inc.fecha_autorizacion ? new Date(inc.fecha_autorizacion).toLocaleDateString('es-MX') : '-'}</div>
                        </div>
                    </div>
                    ` : ''}
                    ${inc.comentarios_resolucion ? `
                    <div style="background:#f8f9fa; padding:15px; border-radius:8px;">
                        <h4 style="color:var(--color-primary); margin:0 0 10px 0;">Comentarios de Resolución</h4>
                        <div>${inc.comentarios_resolucion}</div>
                        <div><strong>Fecha resolución:</strong> ${inc.fecha_resolucion ? new Date(inc.fecha_resolucion).toLocaleDateString('es-MX') : '-'}</div>
                    </div>
                    ` : ''}
                `;
                document.getElementById('modalVerIncidencia').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => mostrarNotificacion('error', 'Error al cargar detalle'));
}

function editarIncidencia(id) {
    fetch(`/api/incidencias/${id}`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const inc = data.data;
                document.getElementById('modalIncidenciaId').value = inc.incidencia_id;
                document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Incidencia';
                document.getElementById('modalPlantillaId').value = inc.plantilla_id;
                document.getElementById('modalCatTipoIncidenciaId').value = inc.cat_tipo_incidencia_id;
                document.getElementById('modalFechaIncidencia').value = inc.fecha_incidencia;
                document.getElementById('modalDescripcion').value = inc.descripcion;
                document.getElementById('modalEstatusIncidencia').value = inc.estatus;
                document.getElementById('modalComentariosResolucion').value = inc.comentarios_resolucion || '';
                document.getElementById('campoEstatus').style.display = 'block';
                document.getElementById('campoComentarios').style.display = 'block';
                document.getElementById('modalIncidencia').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => mostrarNotificacion('error', 'Error al cargar datos'));
}

function eliminarIncidencia(id) {
    if (confirm('¿Estás seguro de eliminar esta incidencia?')) {
        fetch(`/api/incidencias/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', 'Incidencia eliminada');
                cargarIncidencias();
            } else {
                mostrarNotificacion('error', data.message || 'Error al eliminar');
            }
        })
        .catch(error => mostrarNotificacion('error', 'Error de conexión'));
    }
}

function abrirModalNuevaIncidencia() {
    document.getElementById('formIncidencia').reset();
    document.getElementById('modalIncidenciaId').value = '';
    document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-exclamation-triangle"></i> Nueva Incidencia';
    document.getElementById('campoEstatus').style.display = 'none';
    document.getElementById('campoComentarios').style.display = 'none';
    document.getElementById('modalFechaIncidencia').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalIncidencia').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalIncidencia() {
    document.getElementById('modalIncidencia').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalVer() {
    document.getElementById('modalVerIncidencia').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function abrirModalCambiarEstatus(id, estatusActual) {
    incidenciaIdActual = id;
    document.getElementById('estatusIncidenciaId').textContent = id;
    document.getElementById('estatusActual').value = estatusActual;
    document.getElementById('nuevoEstatus').value = estatusActual;
    
    document.getElementById('campoComentarioResolucion').style.display = 'none';
    document.getElementById('modalCambiarEstatus').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalCambiarEstatus() {
    document.getElementById('modalCambiarEstatus').style.display = 'none';
    document.body.style.overflow = 'auto';
    incidenciaIdActual = null;
}

function actualizarEstatus() {
    if (!incidenciaIdActual) return;
    
    const nuevoEstatus = document.getElementById('nuevoEstatus').value;
    const comentarios = document.getElementById('comentarioResolucion').value;
    
    const formData = new FormData();
    formData.append('estatus', nuevoEstatus);
    if (comentarios) {
        formData.append('comentarios_resolucion', comentarios);
    }
    if (nuevoEstatus === 'Resuelta') {
        formData.append('fecha_resolucion', new Date().toISOString().split('T')[0]);
    }
    formData.append('_method', 'PUT');
    formData.append('_token', document.querySelector('input[name="_token"]')?.value || '');
    
    fetch(`/api/incidencias/${incidenciaIdActual}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('success', `Estatus actualizado a "${nuevoEstatus}"`);
            cerrarModalCambiarEstatus();
            cargarIncidencias();
        } else {
            mostrarNotificacion('error', data.message || 'Error al actualizar estatus');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('error', 'Error de conexión');
    });
}

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
    paginaActual = 1;
    renderizarTabla();
}

function removerColumna(columna) {
    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
    actualizarGrupoColumnas();
}

function toggleColumnSelector() {
    const selector = document.getElementById('columnSelector');
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    if (selector.style.display === 'block') {
        const lista = document.getElementById('columnasLista');
        lista.innerHTML = columnas.map(col => `
            <div style="padding:5px 0; display:flex; align-items:center;">
                <input type="checkbox" id="chk_${col.field}" data-columna="${col.field}" 
                    ${columnasVisibles.includes(col.field) ? 'checked' : ''}
                    onchange="toggleColumna('${col.field}', this.checked)"
                    style="margin-right:8px; accent-color:var(--color-primary);">
                <label for="chk_${col.field}" style="font-size:12px;">${col.caption}</label>
            </div>
        `).join('');
    }
}

function toggleColumna(columna, visible) {
    if (visible && !columnasVisibles.includes(columna)) {
        columnasVisibles.push(columna);
    } else if (!visible && columnasVisibles.includes(columna)) {
        columnasVisibles = columnasVisibles.filter(c => c !== columna);
    }
    renderizarTabla();
}

function cerrarColumnSelector() {
    document.getElementById('columnSelector').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    cargarIncidencias();
    cargarEmpleados();
    cargarTiposIncidencia();
    
    document.getElementById('perPage').addEventListener('change', cambiarRegistrosPorPagina);
    document.getElementById('prevPage').addEventListener('click', () => cambiarPagina('prev'));
    document.getElementById('nextPage').addEventListener('click', () => cambiarPagina('next'));
    document.getElementById('btnAplicarFiltros').addEventListener('click', aplicarFiltros);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);
    document.getElementById('btnAgregar').addEventListener('click', abrirModalNuevaIncidencia);
    document.getElementById('btnExcel').addEventListener('click', () => mostrarNotificacion('info', 'Exportando a Excel...'));
    document.getElementById('btnCrearFiltro').addEventListener('click', () => mostrarNotificacion('info', 'Filtros avanzados en desarrollo'));
    
    document.getElementById('buscador').addEventListener('input', aplicarFiltros);
    document.getElementById('filtroEstatus').addEventListener('change', aplicarFiltros);
    document.getElementById('filtroFechaDesde').addEventListener('change', aplicarFiltros);
    document.getElementById('filtroFechaHasta').addEventListener('change', aplicarFiltros);
    
    // Mostrar/ocultar campo de comentarios según el estatus seleccionado
    document.getElementById('nuevoEstatus').addEventListener('change', function() {
        if (this.value === 'Resuelta') {
            document.getElementById('campoComentarioResolucion').style.display = 'block';
        } else {
            document.getElementById('campoComentarioResolucion').style.display = 'none';
        }
    });
    
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });
    
    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalIncidencia();
            cerrarModalVer();
            cerrarModalCambiarEstatus();
        }
    });
    
    document.getElementById('modalIncidencia').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalIncidencia();
    });
    
    document.getElementById('modalVerIncidencia').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalVer();
    });
    
    document.getElementById('modalCambiarEstatus').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalCambiarEstatus();
    });
});
</script>
@endsection