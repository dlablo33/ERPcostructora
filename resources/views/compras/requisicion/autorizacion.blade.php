@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Autorización de Requisiciones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Autorización de Requisiciones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación (izquierda) -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Grupo derecho: filtros y botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtros de fecha -->
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-d') }}">
                        </div>
                        
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar requisición"
                                    onclick="abrirModalRequisicion()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
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
                            <input type="text" id="buscador" placeholder="Buscar requisición..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Autorización de Requisiciones -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaAutorizacionRequisiciones" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="requisicion">Requisición</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="fecha">Fecha Requisición</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 20%;" draggable="true" data-columna="solicitante">Solicitante</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="cotizadas">Cotizadas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: var(--color-primary);"></i>
                                    <p style="margin-top: 10px;">Cargando requisiciones...</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Requisiciones: 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR REQUISICIÓN -->
<div id="modalRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Nueva Requisición</h3>
            <button onclick="cerrarModalRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="color: var(--color-primary); font-size: 15px; margin: 0 0 15px 0;">
                    <i class="fas fa-info-circle"></i> General
                </h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Fecha Req.</label>
                        <input type="date" id="modalFechaReq" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Responsable</label>
                        <input type="text" id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre del solicitante">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Área</label>
                        <select id="modalArea" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Seleccionar área</option>
                            @isset($areas)
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
            </div>
            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4 style="color: var(--color-primary); font-size: 15px; margin: 0;">
                        <i class="fas fa-box"></i> Artículos Solicitados
                    </h4>
                    <button type="button" id="btnAgregarArticulo" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer; font-size: 12px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-plus"></i> Agregar Artículo
                    </button>
                </div>
                
                <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Código</th>
                                <th style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">Cantidad</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Unidad Medida</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Descripción</th>
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #dee2e6;">Observación</th>
                                <th style="padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6;">Pendiente</th>
                                <th style="padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6;"></th>
                            </tr>
                        </thead>
                        <tbody id="tablaArticulosRequisicion">
                            <tr class="fila-articulo">
                                <td style="padding: 8px;"><input type="text" class="art-codigo" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Código"></td>
                                <td style="padding: 8px;"><input type="number" class="art-cantidad" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; text-align: right;" value="1"></td>
                                <td style="padding: 8px;">
                                    <select class="art-unidad" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option>Pieza</option><option>Kilogramo</option><option>Litro</option><option>Metro</option><option>Caja</option>
                                    </select>
                                </td>
                                <td style="padding: 8px;"><input type="text" class="art-descripcion" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción"></td>
                                <td style="padding: 8px;"><input type="text" class="art-observacion" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observación"></td>
                                <td style="padding: 8px; text-align: center;"><input type="checkbox" class="art-pendiente" style="accent-color: var(--color-primary);" checked></td>
                                <td style="padding: 8px; text-align: center;"><i class="fas fa-trash" style="color: #dc3545; cursor: pointer;" onclick="this.closest('tr').remove()"></i></td>
                             </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA AUTORIZAR REQUISICIÓN -->
<div id="modalAutorizarRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Autorizar Requisición</h3>
            <button onclick="cerrarModalAutorizarRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <div style="padding: 20px;">
            <p style="margin-bottom: 15px; font-size: 14px;">¿Está seguro de autorizar la requisición <strong id="requisicionAutorizar">REQ-001</strong>?</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                <textarea id="modalObservacionesAutorizar" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones (opcional)..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalAutorizarRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarAutorizarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;">
                    <i class="fas fa-check-circle"></i> Autorizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA RECHAZAR REQUISICIÓN -->
<div id="modalRechazarRequisicion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Rechazar Requisición</h3>
            <button onclick="cerrarModalRechazarRequisicion()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <div style="padding: 20px;">
            <p style="margin-bottom: 15px; font-size: 14px;">¿Está seguro de rechazar la requisición <strong id="requisicionRechazar">REQ-001</strong>?</p>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motivo de rechazo <span style="color: #dc3545;">*</span></label>
                <textarea id="modalMotivoRechazo" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Indique el motivo del rechazo..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalRechazarRequisicion()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="confirmarRechazarRequisicion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: #dc3545; color: white; cursor: pointer;">
                    <i class="fas fa-times-circle"></i> Rechazar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        max-height: 500px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
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
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
    }
    
    .table td:last-child {
        background-color: white !important;
        text-align: center !important;
    }
    
    tbody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }
    
    tbody tr:hover td:last-child {
        background-color: #e8f0fe !important;
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
    
    .table td:last-child i.fa-check-circle {
        color: #28a745;
    }
    
    .table td:last-child i.fa-times-circle {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-undo-alt,
    .table td:last-child i.fa-redo-alt {
        color: #ffc107;
    }
    
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-activo, .badge-autorizada {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-cancelado, .badge-rechazada {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    
    .badge-cotizadas {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 30px;
        text-align: center;
    }
    
    .badge-sin-cotizar {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 30px;
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
    
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }
    
    #modalRequisicion, #modalAutorizarRequisicion, #modalRechazarRequisicion {
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        
        #modalRequisicion > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalRequisicion div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        #modalRequisicion table {
            font-size: 11px;
        }
        
        #modalRequisicion input[type="text"],
        #modalRequisicion input[type="number"],
        #modalRequisicion select {
            font-size: 11px;
            padding: 4px;
        }
        
        #modalAutorizarRequisicion > div, #modalRechazarRequisicion > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Variable global para almacenar el ID de requisición seleccionada
let requisicionSeleccionadaId = null;
let requisicionSeleccionadaFolio = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarRequisiciones();
    configurarEventos();
});

// Cargar requisiciones vía AJAX
function cargarRequisiciones() {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const busqueda = document.getElementById('buscador')?.value || '';
    
    let url = "{{ route('compras.autorizacion.get-data') }}";
    url += `?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}&search=${encodeURIComponent(busqueda)}`;
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            renderizarTabla(response.data);
            actualizarTotal(response.data.length);
        } else {
            console.error('Error:', response.message);
            mostrarError('Error al cargar datos: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarError('Error de conexión al cargar los datos');
    });
}

// Renderizar tabla
function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    
    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;">No hay requisiciones para mostrar</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        if (index % 2 === 1) row.style.backgroundColor = '#f8f9fa';
        
        let estatusBadge = '';
        let acciones = '';
        
        switch (item.estatus) {
            case 'Pendiente':
                estatusBadge = '<span class="badge-pendiente">Pendiente</span>';
                acciones = `
                    <i class="fas fa-check-circle" onclick="autorizarRequisicion(${item.id}, '${item.folio}')" title="Autorizar"></i>
                    <i class="fas fa-times-circle" onclick="rechazarRequisicion(${item.id}, '${item.folio}')" title="Rechazar"></i>
                    <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                `;
                break;
            case 'Activo':
                estatusBadge = '<span class="badge-activo">Autorizada</span>';
                acciones = `
                    <i class="fas fa-undo-alt" onclick="revertirAutorizacion(${item.id}, '${item.folio}')" title="Revertir autorización"></i>
                    <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                `;
                break;
            case 'Cancelado':
                estatusBadge = '<span class="badge-cancelado">Rechazada</span>';
                acciones = `
                    <i class="fas fa-redo-alt" onclick="reabrirRequisicion(${item.id}, '${item.folio}')" title="Reabrir"></i>
                    <i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>
                `;
                break;
            default:
                estatusBadge = `<span class="badge-pendiente">${item.estatus || 'Pendiente'}</span>`;
                acciones = `<i class="fas fa-eye" onclick="verDetalle(${item.id})" title="Ver detalle"></i>`;
        }
        
        let cotizadasBadge = '';
        if (item.cotizadas > 0) {
            cotizadasBadge = `<span class="badge-cotizadas">${item.cotizadas_texto || item.cotizadas}</span>`;
        } else {
            cotizadasBadge = `<span class="badge-sin-cotizar">0</span>`;
        }
        
        row.innerHTML = `
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${estatusBadge}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">${escapeHtml(item.folio)}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.fecha_requerimiento}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${escapeHtml(item.solicitante)}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${cotizadasBadge}</td>
            <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: ${index % 2 === 1 ? '#f8f9fa' : 'white'}; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                ${acciones}
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function actualizarTotal(total) {
    const tfoot = document.querySelector('#tablaAutorizacionRequisiciones tfoot');
    if (tfoot) {
        tfoot.innerHTML = `
            <tr>
                <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">
                    Total Requisiciones: ${total}
                 </td>
            </tr>
        `;
    }
}

function mostrarError(mensaje) {
    console.error(mensaje);
    // Puedes implementar un toast notification aquí
    if (!mensaje.includes('No hay requisiciones')) {
        alert('Error: ' + mensaje);
    }
}

function configurarEventos() {
    const buscador = document.getElementById('buscador');
    if (buscador) {
        buscador.addEventListener('input', debounce(function() {
            cargarRequisiciones();
        }, 500));
    }
    
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    if (fechaInicio) fechaInicio.addEventListener('change', () => cargarRequisiciones());
    if (fechaFin) fechaFin.addEventListener('change', () => cargarRequisiciones());
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ========== FUNCIONES DE MODALES ==========

window.abrirModalRequisicion = function() {
    document.getElementById('modalRequisicion').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.cerrarModalRequisicion = function() {
    document.getElementById('modalRequisicion').style.display = 'none';
    document.body.style.overflow = 'auto';
};

window.guardarRequisicion = function() {
    alert('Funcionalidad en desarrollo - Conecte con RequisicionController');
    cerrarModalRequisicion();
};

window.autorizarRequisicion = function(id, folio) {
    requisicionSeleccionadaId = id;
    requisicionSeleccionadaFolio = folio;
    document.getElementById('requisicionAutorizar').textContent = folio;
    document.getElementById('modalObservacionesAutorizar').value = '';
    document.getElementById('modalAutorizarRequisicion').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.cerrarModalAutorizarRequisicion = function() {
    document.getElementById('modalAutorizarRequisicion').style.display = 'none';
    document.body.style.overflow = 'auto';
};

window.confirmarAutorizarRequisicion = function() {
    const observaciones = document.getElementById('modalObservacionesAutorizar').value;
    const id = requisicionSeleccionadaId;
    
    fetch(`/compras/autorizacion-requisiciones/${id}/autorizar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ observaciones: observaciones })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalAutorizarRequisicion();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al autorizar la requisición');
    });
};

window.rechazarRequisicion = function(id, folio) {
    requisicionSeleccionadaId = id;
    requisicionSeleccionadaFolio = folio;
    document.getElementById('requisicionRechazar').textContent = folio;
    document.getElementById('modalMotivoRechazo').value = '';
    document.getElementById('modalRechazarRequisicion').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.cerrarModalRechazarRequisicion = function() {
    document.getElementById('modalRechazarRequisicion').style.display = 'none';
    document.body.style.overflow = 'auto';
};

window.confirmarRechazarRequisicion = function() {
    const motivo = document.getElementById('modalMotivoRechazo').value;
    
    if (!motivo.trim()) {
        alert('⚠️ Por favor indique el motivo del rechazo');
        return;
    }
    
    const id = requisicionSeleccionadaId;
    
    fetch(`/compras/autorizacion-requisiciones/${id}/rechazar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ motivo: motivo })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalRechazarRequisicion();
            cargarRequisiciones();
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al rechazar la requisición');
    });
};

// =====================================================================
window.verDetalle = function(id) {
    // Mostrar loading
    const loadingMsg = document.createElement('div');
    loadingMsg.id = 'detalleLoading';
    loadingMsg.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 100001; display: flex; align-items: center; justify-content: center;">
            <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: var(--color-primary);"></i>
                <p style="margin-top: 10px;">Cargando detalles...</p>
            </div>
        </div>
    `;
    document.body.appendChild(loadingMsg);
    
    fetch(`/compras/autorizacion-requisiciones/${id}/detalle`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(response => {
        // Remover loading
        document.getElementById('detalleLoading')?.remove();
        
        if (response.success) {
            mostrarModalDetalle(response.data);
        } else {
            alert('❌ Error al cargar detalle: ' + response.message);
        }
    })
    .catch(error => {
        document.getElementById('detalleLoading')?.remove();
        console.error('Error:', error);
        alert('❌ Error al cargar el detalle');
    });
};

// Función para mostrar modal de detalle con estilos
function mostrarModalDetalle(data) {
    // Crear modal
    const modal = document.createElement('div');
    modal.id = 'modalDetalleRequisicion';
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 100002;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    `;
    
    // Determinar color según estatus
    let estatusColor = '';
    let estatusIcono = '';
    let estatusBg = '';
    switch (data.estatus) {
        case 'Pendiente':
            estatusColor = '#ffc107';
            estatusIcono = 'fa-clock';
            estatusBg = '#fff3cd';
            break;
        case 'Activo':
            estatusColor = '#28a745';
            estatusIcono = 'fa-check-circle';
            estatusBg = '#d4edda';
            break;
        case 'Cancelado':
            estatusColor = '#dc3545';
            estatusIcono = 'fa-times-circle';
            estatusBg = '#f8d7da';
            break;
        default:
            estatusColor = '#6c757d';
            estatusIcono = 'fa-question-circle';
            estatusBg = '#e9ecef';
    }
    
    // Construir HTML de artículos
    let articulosHtml = '';
    data.articulos.forEach((art, idx) => {
        articulosHtml += `
            <div style="border-bottom: 1px solid #e9ecef; padding: 12px; ${idx % 2 === 0 ? 'background-color: #f8f9fa;' : ''}">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="flex: 1;">
                        <strong style="color: var(--color-primary);">${idx + 1}. ${escapeHtml(art.descripcion)}</strong>
                        ${art.codigo ? `<span style="font-size: 11px; color: #6c757d; margin-left: 8px;">(${escapeHtml(art.codigo)})</span>` : ''}
                    </div>
                    <span style="background-color: #17a2b8; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: bold;">
                        ${art.cantidad} ${art.unidad_medida}
                    </span>
                </div>
                ${art.observacion ? `<div style="font-size: 11px; color: #6c757d; margin-top: 5px;"><i class="fas fa-comment"></i> ${escapeHtml(art.observacion)}</div>` : ''}
                <div style="display: flex; gap: 15px; margin-top: 5px; font-size: 11px;">
                    <span><i class="fas fa-box"></i> Pendiente: ${art.pendiente ? 'Sí' : 'No'}</span>
                    ${art.cantidad_surtida > 0 ? `<span><i class="fas fa-check"></i> Surtido: ${art.cantidad_surtida}</span>` : ''}
                </div>
            </div>
        `;
    });
    
    modal.innerHTML = `
        <div style="background-color: white; border-radius: 12px; width: 95%; max-width: 700px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideInUp 0.3s ease;">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, var(--color-primary), #052c6e); padding: 20px 25px; border-radius: 12px 12px 0 0; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="margin: 0; font-size: 20px;">
                            <i class="fas fa-file-alt"></i> Requisición ${escapeHtml(data.folio)}
                        </h3>
                        <p style="margin: 5px 0 0; opacity: 0.9; font-size: 12px;">
                            <i class="fas fa-calendar-alt"></i> ${data.fecha_requerimiento}
                        </p>
                    </div>
                    <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div style="padding: 20px 25px;">
                <!-- Información general -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
                    <div style="background-color: #f8f9fa; padding: 12px; border-radius: 8px; border-left: 4px solid var(--color-primary);">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Solicitante</div>
                        <div style="font-weight: 600; font-size: 14px;"><i class="fas fa-user"></i> ${escapeHtml(data.solicitante)}</div>
                    </div>
                    <div style="background-color: #f8f9fa; padding: 12px; border-radius: 8px; border-left: 4px solid var(--color-primary);">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Área</div>
                        <div style="font-weight: 600; font-size: 14px;"><i class="fas fa-building"></i> ${escapeHtml(data.area)}</div>
                    </div>
                    ${data.proyecto ? `
                    <div style="background-color: #f8f9fa; padding: 12px; border-radius: 8px; border-left: 4px solid var(--color-primary);">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Proyecto</div>
                        <div style="font-weight: 600; font-size: 14px;"><i class="fas fa-project-diagram"></i> ${escapeHtml(data.proyecto)}</div>
                    </div>
                    ` : ''}
                    <div style="background-color: ${estatusBg}; padding: 12px; border-radius: 8px; border-left: 4px solid ${estatusColor};">
                        <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Estatus</div>
                        <div style="font-weight: 600; font-size: 14px; color: ${estatusColor};">
                            <i class="fas ${estatusIcono}"></i> ${data.estatus}
                        </div>
                    </div>
                </div>
                
                <!-- Observaciones generales -->
                ${data.observaciones ? `
                <div style="background-color: #e8f0fe; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                    <div style="font-size: 12px; font-weight: 600; color: var(--color-primary); margin-bottom: 5px;">
                        <i class="fas fa-comment-dots"></i> Observaciones
                    </div>
                    <div style="font-size: 13px;">${escapeHtml(data.observaciones)}</div>
                </div>
                ` : ''}
                
                <!-- Artículos -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h4 style="color: var(--color-primary); margin: 0; font-size: 16px;">
                            <i class="fas fa-boxes"></i> Artículos Solicitados
                        </h4>
                        <span style="background-color: #e9ecef; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                            <i class="fas fa-cubes"></i> Total: ${data.articulos.length}
                        </span>
                    </div>
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        ${articulosHtml || '<div style="padding: 20px; text-align: center;">No hay artículos registrados</div>'}
                    </div>
                </div>
                
                <!-- Información de autorización -->
                ${data.fecha_aprobacion ? `
                <div style="background-color: #d4edda; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                    <div style="font-size: 12px; font-weight: 600; color: #155724; margin-bottom: 5px;">
                        <i class="fas fa-check-circle"></i> Autorización
                    </div>
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                        <span><i class="fas fa-user-check"></i> Aprobado por: ${escapeHtml(data.aprobado_por)}</span>
                        <span><i class="fas fa-calendar-check"></i> Fecha: ${data.fecha_aprobacion}</span>
                    </div>
                </div>
                ` : ''}
                
                <!-- Motivo de rechazo -->
                ${data.motivo_rechazo ? `
                <div style="background-color: #f8d7da; padding: 12px; border-radius: 8px; border-left: 4px solid #dc3545;">
                    <div style="font-size: 12px; font-weight: 600; color: #721c24; margin-bottom: 5px;">
                        <i class="fas fa-ban"></i> Motivo de Rechazo
                    </div>
                    <div style="font-size: 13px; color: #721c24;">${escapeHtml(data.motivo_rechazo)}</div>
                </div>
                ` : ''}
            </div>
            
            <!-- Footer -->
            <div style="padding: 15px 25px; border-top: 1px solid #dee2e6; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end;">
                <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: none; border-radius: 6px; background-color: var(--color-primary); color: white; cursor: pointer; font-size: 13px;">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

// Función para cerrar modal de detalle
function cerrarModalDetalle() {
    const modal = document.getElementById('modalDetalleRequisicion');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}
// =====================================================================

window.revertirAutorizacion = function(id, folio) {
    if (confirm(`¿Está seguro de revertir la autorización de la requisición ${folio}?\nEsta acción la regresará a estado PENDIENTE.`)) {
        fetch(`/compras/autorizacion-requisiciones/${id}/revertir`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert('✅ ' + response.message);
                cargarRequisiciones();
            } else {
                alert('❌ Error: ' + response.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al revertir la autorización');
        });
    }
};

window.reabrirRequisicion = function(id, folio) {
    if (confirm(`¿Está seguro de reabrir la requisición ${folio}?\nEsta acción la regresará a estado PENDIENTE.`)) {
        fetch(`/compras/autorizacion-requisiciones/${id}/reabrir`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                alert('✅ ' + response.message);
                cargarRequisiciones();
            } else {
                alert('❌ Error: ' + response.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al reabrir la requisición');
        });
    }
};

// Funciones de UI adicionales
document.getElementById('btnAgregarArticulo')?.addEventListener('click', function() {
    const tbody = document.getElementById('tablaArticulosRequisicion');
    if (tbody) {
        const newRow = document.createElement('tr');
        newRow.className = 'fila-articulo';
        newRow.innerHTML = `
            <td style="padding: 8px;"><input type="text" class="art-codigo" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Código"></td>
            <td style="padding: 8px;"><input type="number" class="art-cantidad" style="width: 80px; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; text-align: right;" value="1"></td>
            <td style="padding: 8px;">
                <select class="art-unidad" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option>Pieza</option><option>Kilogramo</option><option>Litro</option><option>Metro</option><option>Caja</option>
                </select>
            </td>
            <td style="padding: 8px;"><input type="text" class="art-descripcion" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción"></td>
            <td style="padding: 8px;"><input type="text" class="art-observacion" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observación"></td>
            <td style="padding: 8px; text-align: center;"><input type="checkbox" class="art-pendiente" style="accent-color: var(--color-primary);" checked></td>
            <td style="padding: 8px; text-align: center;"><i class="fas fa-trash" style="color: #dc3545; cursor: pointer;" onclick="this.closest('tr').remove()"></i></td>
        `;
        tbody.appendChild(newRow);
    }
});

document.getElementById('btnExcel')?.addEventListener('click', () => {
    window.location.href = "{{ route('compras.autorizacion.exportar') }}";
});

document.getElementById('btnCrearFiltro')?.addEventListener('click', () => {
    alert('Funcionalidad de filtro avanzado en desarrollo');
});

// Funciones de agrupación y selector de columnas
function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    const texto = document.getElementById('textoAgrupar');
    
    if (container && texto) {
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
}

let columnasAgrupadas = [];

window.removerColumna = function(columna) {
    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
    actualizarGrupoColumnas();
};

// Drag & drop
document.addEventListener('dragstart', (e) => {
    if (e.target.tagName === 'TH' && e.target.draggable) {
        e.dataTransfer.setData('text/plain', e.target.dataset.columna);
    }
});

const grupoAgrupacion = document.getElementById('grupoAgrupacion');
if (grupoAgrupacion) {
    grupoAgrupacion.addEventListener('dragover', (e) => e.preventDefault());
    grupoAgrupacion.addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            alert('Agrupando por: ' + columna);
        }
    });
}

// Selector de columnas
window.toggleColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    if (selector) {
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'estatus', caption: 'Estatus' },
                { field: 'requisicion', caption: 'Requisición' },
                { field: 'fecha', caption: 'Fecha Requisición' },
                { field: 'solicitante', caption: 'Solicitante' },
                { field: 'cotizadas', caption: 'Cotizadas' }
            ];
            
            const lista = document.getElementById('columnasLista');
            if (lista) {
                lista.innerHTML = columnas.map(col => `
                    <div style="padding: 5px 0; display: flex; align-items: center;">
                        <input type="checkbox" 
                               id="chk_${col.field}"
                               data-columna="${col.field}"
                               checked
                               style="margin-right: 8px; accent-color: var(--color-primary);">
                        <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                    </div>
                `).join('');
            }
        }
    }
};

window.cerrarColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    if (selector) selector.style.display = 'none';
};

// Cerrar selector al hacer clic fuera
document.addEventListener('click', function(e) {
    const btnColumnas = document.getElementById('btnColumnas');
    const columnSelector = document.getElementById('columnSelector');
    if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector') && columnSelector) {
        columnSelector.style.display = 'none';
    }
});

// Cerrar modales con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalRequisicion();
        cerrarModalAutorizarRequisicion();
        cerrarModalRechazarRequisicion();
    }
});

// Cerrar modales al hacer clic fuera
document.getElementById('modalRequisicion')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalRequisicion();
});
document.getElementById('modalAutorizarRequisicion')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalAutorizarRequisicion();
});
document.getElementById('modalRechazarRequisicion')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalRechazarRequisicion();
});
</script>
@endsection