@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Presupuesto Mensual -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Presupuesto Mensual
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación discreto en la esquina izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>

                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #2378e1; font-size: 16px;" title="Agregar">
                                <i class="fas fa-plus" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel"
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas"
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay presupuestos mensuales para mostrar</p>
                </div>

                <!-- Tabla de Presupuesto Mensual -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPresupuestoMensual" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="mes">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Mes</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="anio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Año</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="observaciones">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Observaciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Acciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="4">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>

                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPrimera">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnAnterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-8 de 12 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================================================ -->
<!-- MODAL: CREAR / EDITAR PRESUPUESTO                             -->
<!-- ============================================================ -->
<div id="modalFormulario" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 100%; max-width: 500px; margin: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px;" id="modalFormTitulo">Agregar Presupuesto</h3>
            <button type="button" id="btnCerrarModalForm" style="background: transparent; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <form id="formPresupuesto" style="padding: 20px;">
            <input type="hidden" id="presupuestoId" value="">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600; font-size: 14px;">Mes <span style="color: red;">*</span></label>
                <select id="formMes" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    <option value="">Seleccione un mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600; font-size: 14px;">Año <span style="color: red;">*</span></label>
                <input type="number" id="formAnio" required min="2000" max="2100" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600; font-size: 14px;">Monto <span style="color: red;">*</span></label>
                <input type="number" id="formMonto" required min="0" step="0.01" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; color: #333; font-weight: 600; font-size: 14px;">Observaciones</label>
                <textarea id="formObservaciones" rows="3" maxlength="500" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
            </div>

            <div id="formError" style="display: none; background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 13px;"></div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" id="btnCancelarForm" style="padding: 8px 18px; border: 1px solid #ced4da; background: white; border-radius: 4px; cursor: pointer; color: #333;">Cancelar</button>
                <button type="submit" id="btnGuardarForm" style="padding: 8px 18px; border: none; background: #2378e1; color: white; border-radius: 4px; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: VER DETALLE                                            -->
<!-- ============================================================ -->
<div id="modalVer" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 100%; max-width: 500px; margin: 20px;">
        <div style="background: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px;">Detalle del Presupuesto</h3>
            <button type="button" id="btnCerrarModalVer" style="background: transparent; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px; font-size: 14px;">
            <div style="margin-bottom: 12px;"><strong style="color: #2378e1;">Folio:</strong> <span id="verId"></span></div>
            <div style="margin-bottom: 12px;"><strong style="color: #2378e1;">Mes:</strong> <span id="verMes"></span></div>
            <div style="margin-bottom: 12px;"><strong style="color: #2378e1;">Año:</strong> <span id="verAnio"></span></div>
            <div style="margin-bottom: 12px;"><strong style="color: #2378e1;">Monto:</strong> <span id="verMonto"></span></div>
            <div style="margin-bottom: 12px;"><strong style="color: #2378e1;">Observaciones:</strong> <span id="verObservaciones"></span></div>
        </div>
        <div style="padding: 0 20px 20px; text-align: right;">
            <button type="button" id="btnCerrarModalVer2" style="padding: 8px 18px; border: none; background: #2378e1; color: white; border-radius: 4px; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: COLUMNAS                                               -->
<!-- ============================================================ -->
<div id="modalColumnas" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 100%; max-width: 400px; margin: 20px;">
        <div style="background: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px;">Seleccionar Columnas</h3>
            <button type="button" id="btnCerrarModalColumnas" style="background: transparent; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px;" id="listaColumnas">
            <label style="display: block; margin-bottom: 10px; cursor: pointer;"><input type="checkbox" class="chk-columna" data-columna="folio" checked> Folio</label>
            <label style="display: block; margin-bottom: 10px; cursor: pointer;"><input type="checkbox" class="chk-columna" data-columna="mes" checked> Mes</label>
            <label style="display: block; margin-bottom: 10px; cursor: pointer;"><input type="checkbox" class="chk-columna" data-columna="anio" checked> Año</label>
            <label style="display: block; margin-bottom: 10px; cursor: pointer;"><input type="checkbox" class="chk-columna" data-columna="monto" checked> Monto</label>
            <label style="display: block; margin-bottom: 10px; cursor: pointer;"><input type="checkbox" class="chk-columna" data-columna="observaciones" checked> Observaciones</label>
        </div>
        <div style="padding: 0 20px 20px; text-align: right;">
            <button type="button" id="btnAplicarColumnas" style="padding: 8px 18px; border: none; background: #2378e1; color: white; border-radius: 4px; cursor: pointer;">Aplicar</button>
        </div>
    </div>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #2378e1;
    }

    .semaforo .card-header h2 {
        color: #2378e1 !important;
    }

    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }

    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
        color: #000000 !important;
    }

    /* Estilo para las filas alternadas */
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }

    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
        cursor: pointer;
    }

    #tablaBody td i:hover {
        transform: scale(1.2);
    }

    /* Estilo para el filtro en encabezados */
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }

    .table th i:hover {
        opacity: 1;
    }

    /* Columna de acciones fija */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }

    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #2378e1;
        color: #000000 !important;
    }

    /* Estilos para agrupación de columnas */
    [draggable="true"] {
        cursor: grab;
    }

    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }

    #grupoAgrupacion {
        position: relative;
    }

    #grupoColumnas {
        display: inline-flex;
        align-items: center;
    }

    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #f0f4ff;
        border-radius: 16px;
        color: #2378e1;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #2378e1;
    }

    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #2378e1;
    }

    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }

    /* Estilo para filas de grupo */
    .fila-grupo {
        background-color: #f0f7ff !important;
        font-weight: 500;
        cursor: pointer;
    }

    .fila-grupo:hover {
        background-color: #e1f0ff !important;
    }

    .fila-grupo td:first-child i {
        transition: transform 0.2s;
        margin-right: 8px;
    }

    .fila-grupo:not(.expandido) td:first-child i {
        transform: rotate(-90deg);
    }

    .fila-detalle {
        background-color: #ffffff;
    }

    .fila-detalle td {
        border-top: none !important;
    }

    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }

    /* Estilo cuando se está arrastrando sobre el área de grupo */
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }

    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }

    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }

    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }

    #paginacionContainer button:hover {
        opacity: 0.7;
    }

    #paginacionContainer button:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    #paginacionContainer button i {
        color: #2378e1 !important;
    }

    #btnCrearFiltro,
    #btnCrearFiltro:hover,
    #btnCrearFiltro:focus,
    #btnCrearFiltro:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    #btnCrearFiltro i,
    #btnCrearFiltro span {
        color: #2378e1 !important;
    }

    #paginacionInfo {
        color: #2378e1 !important;
    }

    /* Columnas ocultas */
    .col-oculta {
        display: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }

        input[type="date"], select {
            width: 100% !important;
        }

        button {
            width: 100%;
        }

        div[style*="position: relative"] {
            width: 100%;
        }

        input#buscador {
            width: 100% !important;
        }

        #paginacionContainer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    console.log('Presupuesto Mensual - inicializado');

    // ================= CONFIG =================
    const RUTAS = {
        listar: "{{ url('presupuesto-mensual/listar') }}",
        base:   "{{ url('presupuesto-mensual') }}",
        excel:  "{{ url('presupuesto-mensual/exportar/excel') }}",
    };
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MESES = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    // ================= ESTADO =================
    const state = {
        page: 1,
        perPage: 8,
        buscar: '',
        fechaInicio: document.getElementById('fechaInicio').value,
        fechaFin: document.getElementById('fechaFin').value,
        columnasAgrupadas: [],
        expandedGroups: new Set(),
        columnasVisibles: ['folio','mes','anio','monto','observaciones'],
        datos: [],
        total: 0,
        lastPage: 1,
        sumaMonto: 0,
    };

    // ================= HELPERS =================
    const $ = (id) => document.getElementById(id);
    const money = (n) => '$' + Number(n || 0).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    function toggleModal(id, show) {
        const el = $(id);
        if (el) el.style.display = show ? 'flex' : 'none';
    }

    async function apiFetch(url, options = {}) {
        const opts = {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                ...(options.body ? { 'Content-Type': 'application/json' } : {}),
                ...(options.headers || {}),
            },
            ...options,
        };
        const res = await fetch(url, opts);
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data.message || ('Error HTTP ' + res.status));
        return data;
    }

    // ================= LISTAR =================
    async function cargarDatos() {
        try {
            const params = new URLSearchParams({
                page: state.page,
                por_pagina: state.perPage,
                fecha_inicio: state.fechaInicio,
                fecha_fin: state.fechaFin,
            });
            if (state.buscar) params.append('buscar', state.buscar);

            const resp = await apiFetch(RUTAS.listar + '?' + params.toString());
            state.datos = resp.data || [];
            state.total = resp.total || 0;
            state.lastPage = resp.last_page || 1;
            state.sumaMonto = resp.suma_monto || 0;

            renderTabla();
            renderPaginacion(resp);
        } catch (e) {
            console.error('Error cargando datos:', e);
            state.datos = [];
            renderTabla();
            alert('No se pudieron cargar los datos: ' + e.message);
        }
    }

    // ================= RENDER TABLA =================
    function renderTabla() {
        const tbody = $('tablaBody');
        tbody.innerHTML = '';

        if (!state.datos.length) {
            $('sinDatosMensaje').style.display = 'block';
            $('tablaContainer').style.display = 'none';
            $('tablaFoot').style.display = 'none';
            $('totalRegistros').textContent = '0';
            $('sumMonto').textContent = money(0);
            return;
        }
        $('sinDatosMensaje').style.display = 'none';
        $('tablaContainer').style.display = 'block';

        if (state.columnasAgrupadas.length > 0) {
            renderAgrupado(tbody);
            $('tablaFoot').style.display = 'none';
        } else {
            renderPlano(tbody);
            $('tablaFoot').style.display = 'table-footer-group';
            $('totalRegistros').textContent = state.total;
            $('sumMonto').textContent = money(state.sumaMonto);
        }
        aplicarColumnasVisibles();
    }

    function renderPlano(tbody) {
        state.datos.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td data-col="folio" style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.presupuesto_mensual_id ?? '-'}</td>
                <td data-col="mes" style="border: 1px solid #dee2e6; padding: 10px 4px;">${MESES[item.mes] || '-'}</td>
                <td data-col="anio" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align:center;">${item.anio ?? '-'}</td>
                <td data-col="monto" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align:right;">${money(item.monto)}</td>
                <td data-col="observaciones" style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.observaciones ?? '-'}</td>
                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-edit" data-action="edit" data-id="${item.presupuesto_mensual_id}" title="Editar"></i>
                        <i class="fas fa-trash-alt" data-action="delete" data-id="${item.presupuesto_mensual_id}" title="Eliminar"></i>
                        <i class="fas fa-eye" data-action="view" data-id="${item.presupuesto_mensual_id}" title="Ver detalles"></i>
                        <i class="fas fa-file-pdf" data-action="pdf" data-id="${item.presupuesto_mensual_id}" title="PDF"></i>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderAgrupado(tbody) {
        const grupos = new Map();
        state.datos.forEach(item => {
            const key = state.columnasAgrupadas.map(c => {
                switch (c) {
                    case 'folio': return item.presupuesto_mensual_id;
                    case 'mes': return MESES[item.mes];
                    case 'anio': return item.anio;
                    case 'monto': return item.monto;
                    case 'observaciones': return item.observaciones || '';
                    default: return '';
                }
            }).join('||');

            if (!grupos.has(key)) {
                const valor = state.columnasAgrupadas.map(c => {
                    switch (c) {
                        case 'folio': return item.presupuesto_mensual_id;
                        case 'mes': return MESES[item.mes];
                        case 'anio': return item.anio;
                        case 'monto': return money(item.monto);
                        case 'observaciones': return item.observaciones || 'Sin observaciones';
                        default: return '';
                    }
                }).join(' - ');
                grupos.set(key, { id: key, valor, items: [], total: 0 });
            }
            const g = grupos.get(key);
            g.items.push(item);
            g.total += Number(item.monto) || 0;
        });

        grupos.forEach(g => {
            const expandido = state.expandedGroups.has(g.id);
            const tr = document.createElement('tr');
            tr.className = 'fila-grupo' + (expandido ? ' expandido' : '');
            tr.dataset.grupoId = g.id;
            tr.innerHTML = `
                <td colspan="6" style="border: 1px solid #dee2e6; padding: 10px 4px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <i class="fas fa-caret-right" style="color:#2378e1;margin-right:8px;"></i>
                            <strong style="color:#2378e1;">${g.valor}</strong>
                            <span style="color:#6c757d;font-size:11px;margin-left:10px;">
                                (${g.items.length} registros - Total: ${money(g.total)})
                            </span>
                        </div>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);

            if (expandido) {
                g.items.forEach(item => {
                    const dtr = document.createElement('tr');
                    dtr.className = 'fila-detalle';
                    dtr.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; padding-left:30px;">${item.presupuesto_mensual_id ?? '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${MESES[item.mes] || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align:center;">${item.anio ?? '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align:right;">${money(item.monto)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.observaciones ?? '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background:white;position:sticky;right:0;box-shadow:-2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display:flex;gap:8px;justify-content:center;">
                                <i class="fas fa-edit" data-action="edit" data-id="${item.presupuesto_mensual_id}"></i>
                                <i class="fas fa-trash-alt" data-action="delete" data-id="${item.presupuesto_mensual_id}"></i>
                                <i class="fas fa-eye" data-action="view" data-id="${item.presupuesto_mensual_id}"></i>
                                <i class="fas fa-file-pdf" data-action="pdf" data-id="${item.presupuesto_mensual_id}"></i>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(dtr);
                });
            }
        });
    }

    function aplicarColumnasVisibles() {
        document.querySelectorAll('#tablaPresupuestoMensual thead th[data-columna]').forEach(th => {
            th.classList.toggle('col-oculta', !state.columnasVisibles.includes(th.dataset.columna));
        });
        document.querySelectorAll('#tablaBody td[data-col]').forEach(td => {
            td.classList.toggle('col-oculta', !state.columnasVisibles.includes(td.dataset.col));
        });
    }

    // ================= PAGINACIÓN =================
    function renderPaginacion(resp) {
        $('paginaActual').textContent = resp.current_page || 1;
        $('paginacionInfo').textContent = `Mostrando ${resp.from || 0}-${resp.to || 0} de ${resp.total || 0} registros`;
        $('btnPrimera').disabled = state.page <= 1;
        $('btnAnterior').disabled = state.page <= 1;
        $('btnSiguiente').disabled = state.page >= state.lastPage;
        $('btnUltima').disabled = state.page >= state.lastPage;

        // Los botones 2 y 3 hardcodeados en el diseño: mostrar/ocultar según total de páginas
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            const p = parseInt(btn.dataset.pagina, 10);
            btn.style.display = p <= state.lastPage ? 'inline-block' : 'none';
        });
    }

    function cambiarPagina(p) {
        if (p < 1 || p > state.lastPage) return;
        state.page = p;
        cargarDatos();
    }

    // ================= MODAL FORM (crear/editar) =================
    function abrirModalForm(data = null) {
        $('formError').style.display = 'none';
        $('formError').textContent = '';
        if (data) {
            $('modalFormTitulo').textContent = 'Editar Presupuesto';
            $('presupuestoId').value = data.presupuesto_mensual_id;
            $('formMes').value = data.mes;
            $('formAnio').value = data.anio;
            $('formMonto').value = data.monto;
            $('formObservaciones').value = data.observaciones || '';
        } else {
            $('modalFormTitulo').textContent = 'Agregar Presupuesto';
            $('presupuestoId').value = '';
            $('formMes').value = '';
            $('formAnio').value = new Date().getFullYear();
            $('formMonto').value = '';
            $('formObservaciones').value = '';
        }
        toggleModal('modalFormulario', true);
    }

    async function guardarForm(e) {
        e.preventDefault();
        const id = $('presupuestoId').value;
        const body = {
            mes: parseInt($('formMes').value, 10),
            anio: parseInt($('formAnio').value, 10),
            monto: parseFloat($('formMonto').value),
            observaciones: $('formObservaciones').value || null,
        };
        if (!body.mes || !body.anio || isNaN(body.monto)) {
            $('formError').textContent = 'Complete todos los campos obligatorios.';
            $('formError').style.display = 'block';
            return;
        }

        $('btnGuardarForm').disabled = true;
        $('btnGuardarForm').textContent = 'Guardando...';
        try {
            const url = id ? `${RUTAS.base}/${id}` : RUTAS.base;
            const method = id ? 'PUT' : 'POST';
            const resp = await apiFetch(url, { method, body: JSON.stringify(body) });
            if (!resp.success) throw new Error(resp.message || 'Error al guardar');
            toggleModal('modalFormulario', false);
            cargarDatos();
        } catch (err) {
            $('formError').textContent = err.message;
            $('formError').style.display = 'block';
        } finally {
            $('btnGuardarForm').disabled = false;
            $('btnGuardarForm').textContent = 'Guardar';
        }
    }

    // ================= VER =================
    async function verPresupuesto(id) {
        try {
            const resp = await apiFetch(`${RUTAS.base}/${id}`);
            if (!resp.success) throw new Error(resp.message);
            const d = resp.data;
            $('verId').textContent = d.presupuesto_mensual_id;
            $('verMes').textContent = MESES[d.mes] || d.mes;
            $('verAnio').textContent = d.anio;
            $('verMonto').textContent = money(d.monto);
            $('verObservaciones').textContent = d.observaciones || '-';
            toggleModal('modalVer', true);
        } catch (e) { alert('Error: ' + e.message); }
    }

    // ================= EDITAR =================
    async function editarPresupuesto(id) {
        try {
            const resp = await apiFetch(`${RUTAS.base}/${id}`);
            if (!resp.success) throw new Error(resp.message);
            abrirModalForm(resp.data);
        } catch (e) { alert('Error: ' + e.message); }
    }

    // ================= ELIMINAR =================
    async function eliminarPresupuesto(id) {
        if (!confirm(`¿Eliminar el presupuesto con folio ${id}?`)) return;
        try {
            const resp = await apiFetch(`${RUTAS.base}/${id}`, { method: 'DELETE' });
            if (!resp.success) throw new Error(resp.message);
            if (state.datos.length === 1 && state.page > 1) state.page--;
            cargarDatos();
        } catch (e) { alert('Error: ' + e.message); }
    }

    // ================= PDF =================
    function descargarPDF(id) {
        window.open(`${RUTAS.base}/${id}/pdf`, '_blank');
    }

    // ================= EXCEL =================
    function exportarExcel() {
        const params = new URLSearchParams({
            fecha_inicio: state.fechaInicio,
            fecha_fin: state.fechaFin,
        });
        if (state.buscar) params.append('buscar', state.buscar);
        window.location.href = `${RUTAS.excel}?${params.toString()}`;
    }

    // ================= DELEGACIÓN DE EVENTOS EN TABLA =================
    $('tablaBody').addEventListener('click', function (e) {
        const icon = e.target.closest('i[data-action]');
        if (icon) {
            const id = icon.dataset.id;
            const action = icon.dataset.action;
            if (action === 'edit') editarPresupuesto(id);
            else if (action === 'delete') eliminarPresupuesto(id);
            else if (action === 'view') verPresupuesto(id);
            else if (action === 'pdf') descargarPDF(id);
            return;
        }
        // Expansión de grupo
        const grupoRow = e.target.closest('.fila-grupo');
        if (grupoRow) {
            const gid = grupoRow.dataset.grupoId;
            if (state.expandedGroups.has(gid)) state.expandedGroups.delete(gid);
            else state.expandedGroups.add(gid);
            renderTabla();
        }
    });

    // ================= AGRUPACIÓN =================
    function actualizarChips() {
        const cont = $('grupoColumnas');
        cont.innerHTML = '';
        if (!state.columnasAgrupadas.length) {
            $('textoAgrupar').style.display = 'inline';
            return;
        }
        $('textoAgrupar').style.display = 'none';
        const nombres = { folio:'Folio', mes:'Mes', anio:'Año', monto:'Monto', observaciones:'Observaciones' };
        state.columnasAgrupadas.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${nombres[col] || col} <span class="remover" data-col="${col}">&times;</span>`;
            cont.appendChild(chip);
        });
    }

    document.querySelectorAll('th[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', th.dataset.columna);
            th.style.opacity = '0.5';
        });
        th.addEventListener('dragend', () => th.style.opacity = '1');
    });

    const grupoAgrupacion = $('grupoAgrupacion');
    grupoAgrupacion.addEventListener('dragover', e => {
        e.preventDefault();
        grupoAgrupacion.classList.add('drag-over');
    });
    grupoAgrupacion.addEventListener('dragleave', () => grupoAgrupacion.classList.remove('drag-over'));
    grupoAgrupacion.addEventListener('drop', e => {
        e.preventDefault();
        grupoAgrupacion.classList.remove('drag-over');
        const col = e.dataTransfer.getData('text/plain');
        if (col && !state.columnasAgrupadas.includes(col)) {
            state.columnasAgrupadas.push(col);
            state.expandedGroups.clear();
            actualizarChips();
            renderTabla();
        }
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            const col = e.target.dataset.col;
            state.columnasAgrupadas = state.columnasAgrupadas.filter(c => c !== col);
            state.expandedGroups.clear();
            actualizarChips();
            renderTabla();
        }
    });

    // ================= FILTROS =================
    let debounceTimer = null;
    $('buscador').addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            state.buscar = this.value.trim();
            state.page = 1;
            cargarDatos();
        }, 350);
    });

    $('fechaInicio').addEventListener('change', function () {
        state.fechaInicio = this.value;
        state.page = 1;
        cargarDatos();
    });
    $('fechaFin').addEventListener('change', function () {
        state.fechaFin = this.value;
        state.page = 1;
        cargarDatos();
    });

    $('btnCrearFiltro').addEventListener('click', function () {
        state.buscar = '';
        state.fechaInicio = "{{ date('Y-m-01') }}";
        state.fechaFin = "{{ date('Y-m-d') }}";
        state.page = 1;
        $('buscador').value = '';
        $('fechaInicio').value = state.fechaInicio;
        $('fechaFin').value = state.fechaFin;
        cargarDatos();
    });

    // ================= BOTONES BARRA =================
    $('btnAgregar').addEventListener('click', () => abrirModalForm());
    $('btnExcel').addEventListener('click', exportarExcel);

    // ================= MODAL COLUMNAS =================
    $('btnColumnas').addEventListener('click', () => toggleModal('modalColumnas', true));
    $('btnCerrarModalColumnas').addEventListener('click', () => toggleModal('modalColumnas', false));
    $('btnAplicarColumnas').addEventListener('click', () => {
        const cols = [];
        document.querySelectorAll('.chk-columna').forEach(chk => {
            if (chk.checked) cols.push(chk.dataset.columna);
        });
        if (!cols.length) { alert('Debes seleccionar al menos una columna.'); return; }
        state.columnasVisibles = cols;
        toggleModal('modalColumnas', false);
        aplicarColumnasVisibles();
    });

    // ================= MODALES: CERRAR =================
    $('btnCerrarModalForm').addEventListener('click', () => toggleModal('modalFormulario', false));
    $('btnCancelarForm').addEventListener('click', () => toggleModal('modalFormulario', false));
    $('formPresupuesto').addEventListener('submit', guardarForm);

    $('btnCerrarModalVer').addEventListener('click', () => toggleModal('modalVer', false));
    $('btnCerrarModalVer2').addEventListener('click', () => toggleModal('modalVer', false));

    ['modalFormulario','modalVer','modalColumnas'].forEach(id => {
        $(id).addEventListener('click', function (e) {
            if (e.target === this) toggleModal(id, false);
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            toggleModal('modalFormulario', false);
            toggleModal('modalVer', false);
            toggleModal('modalColumnas', false);
        }
    });

    // ================= PAGINACIÓN BOTONES =================
    $('btnPrimera').addEventListener('click', () => cambiarPagina(1));
    $('btnAnterior').addEventListener('click', () => cambiarPagina(state.page - 1));
    $('btnSiguiente').addEventListener('click', () => cambiarPagina(state.page + 1));
    $('btnUltima').addEventListener('click', () => cambiarPagina(state.lastPage));
    document.querySelectorAll('.pagina-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            cambiarPagina(parseInt(this.dataset.pagina, 10));
        });
    });

    // ================= ICONOS FILTRO EN TH =================
    document.querySelectorAll('th .fa-filter').forEach(icon => {
        icon.addEventListener('click', e => {
            e.stopPropagation();
            const col = icon.closest('th').dataset.columna;
            const nombres = { folio:'Folio', mes:'Mes', anio:'Año', monto:'Monto', observaciones:'Observaciones' };
            const val = prompt(`Filtrar por ${nombres[col] || col}:`);
            if (val !== null && val.trim() !== '') {
                $('buscador').value = val.trim();
                state.buscar = val.trim();
                state.page = 1;
                cargarDatos();
            }
        });
    });

    // ================= INIT =================
    actualizarChips();
    cargarDatos();
});
</script>
@endsection