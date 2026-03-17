@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Diario General -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Diario General
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DIARIO GENERAL CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Pólizas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Pólizas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPolizas">156</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Pólizas del Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pólizas del Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="polizasMes">28</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Total Cargos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Cargos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalCargos">$2,345,678</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Total Abonos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Abonos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAbonos">$2,345,678</div>
                        </div>
                    </div>
                </div>

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
                        <!-- Filtros de fecha -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-03-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div>
                            <input type="date" id="fechaFin" value="2026-03-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Nueva Póliza -->
                        <div>
                            <button id="btnNuevo" style="background-color: #2CBF1F; border: 1px solid #2CBF1F; border-radius: 4px; padding: 8px 16px; display: flex; align-items: center; gap: 5px; cursor: pointer; color: white; font-size: 14px; font-weight: 600;" title="Nueva Póliza">
                                <i class="fas fa-plus" style="color: white;"></i> Nueva
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-book" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay movimientos en el diario general para mostrar</p>
                </div>

                <!-- Tabla de Diario General -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaDiario" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="poliza">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Póliza</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="nombre_cuenta">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Nombre Cuenta</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="concepto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Concepto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cargo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cargo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="abono">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Abono</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo</span>
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
                            <!-- Las filas se insertarán dinámicamente con JavaScript -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="5">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumCargos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumAbonos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="2"></td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 30 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
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
    
    /* Estilo para badges de tipo */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-ingreso {
        background-color: #28a745;
        color: white;
    }
    
    .badge-egreso {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-diario {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-ajuste {
        background-color: #ffc107;
        color: black;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
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
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Todos los elementos dentro del contenedor también sin fondo */
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    /* Excepción para los spans que deben tener fondo azul */
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
    /* Estilos para los botones de paginación */
    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }
    
    #paginacionContainer button:hover {
        opacity: 0.7;
    }
    
    #paginacionContainer button i {
        color: #2378e1 !important;
    }
    
    /* Estilo específico para btnCrearFiltro */
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
    
    /* Estilo para el botón Nueva Póliza */
    #btnNuevo {
        transition: all 0.3s ease;
    }
    
    #btnNuevo:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #btnNuevo:active {
        transform: translateY(0);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"] {
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
        
        [style*="flex: 0 1 calc(25% - 15px)"] {
            flex: 0 1 calc(50% - 15px) !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Diario General');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Diario General (30 registros)
        const datosDiario = [
            // Pólizas de Ingreso
            {
                fecha: '2026-03-15',
                poliza: 'I-001',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-001-2026',
                cargo: 45230.50,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-03-14',
                poliza: 'I-002',
                cuenta: '110-002',
                nombre_cuenta: 'Clientes',
                concepto: 'Cobro a Constructora del Norte',
                cargo: 18500.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-03-13',
                poliza: 'I-003',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-003-2026',
                cargo: 32150.75,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-03-12',
                poliza: 'I-004',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-004-2026',
                cargo: 42000.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-03-10',
                poliza: 'I-005',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-005-2026',
                cargo: 67890.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            // Pólizas de Egreso
            {
                fecha: '2026-03-09',
                poliza: 'E-001',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Servicios de Transporte',
                cargo: 0.00,
                abono: 23800.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-03-08',
                poliza: 'E-002',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Distribuidora Eléctrica',
                cargo: 0.00,
                abono: 28450.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-03-05',
                poliza: 'E-003',
                cuenta: '210-002',
                nombre_cuenta: 'Servicios Profesionales',
                concepto: 'Pago a Consultoría Empresarial',
                cargo: 0.00,
                abono: 12000.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-03-04',
                poliza: 'E-004',
                cuenta: '210-003',
                nombre_cuenta: 'Servicios Varios',
                concepto: 'Pago a Servicios de Limpieza',
                cargo: 0.00,
                abono: 5600.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-03-03',
                poliza: 'E-005',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Constructora del Norte',
                cargo: 0.00,
                abono: 52340.00,
                tipo: 'Egreso'
            },
            // Pólizas de Diario
            {
                fecha: '2026-03-02',
                poliza: 'D-001',
                cuenta: '510-001',
                nombre_cuenta: 'Gastos Administrativos',
                concepto: 'Registro de gastos de oficina',
                cargo: 12300.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-03-02',
                poliza: 'D-001',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Registro de gastos de oficina',
                cargo: 0.00,
                abono: 12300.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-03-01',
                poliza: 'D-002',
                cuenta: '520-001',
                nombre_cuenta: 'Gastos de Operación',
                concepto: 'Registro de gastos operativos',
                cargo: 18750.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-03-01',
                poliza: 'D-002',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Registro de gastos operativos',
                cargo: 0.00,
                abono: 18750.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-28',
                poliza: 'D-003',
                cuenta: '530-001',
                nombre_cuenta: 'Gastos de Personal',
                concepto: 'Registro de nómina',
                cargo: 35600.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-28',
                poliza: 'D-003',
                cuenta: '210-003',
                nombre_cuenta: 'Acreedores Varios',
                concepto: 'Registro de nómina',
                cargo: 0.00,
                abono: 35600.00,
                tipo: 'Diario'
            },
            // Más pólizas de Ingreso
            {
                fecha: '2026-02-27',
                poliza: 'I-006',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-014-2026',
                cargo: 29800.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-02-26',
                poliza: 'I-007',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-015-2026',
                cargo: 32450.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            // Más pólizas de Egreso
            {
                fecha: '2026-02-25',
                poliza: 'E-006',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Distribuidora Eléctrica',
                cargo: 0.00,
                abono: 21900.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-02-24',
                poliza: 'E-007',
                cuenta: '210-002',
                nombre_cuenta: 'Servicios Profesionales',
                concepto: 'Pago a Consultoría Empresarial',
                cargo: 0.00,
                abono: 8900.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-02-23',
                poliza: 'E-008',
                cuenta: '210-003',
                nombre_cuenta: 'Servicios Varios',
                concepto: 'Pago a Servicios de Limpieza',
                cargo: 0.00,
                abono: 4300.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-02-22',
                poliza: 'E-009',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Constructora del Norte',
                cargo: 0.00,
                abono: 56780.00,
                tipo: 'Egreso'
            },
            // Más pólizas de Diario
            {
                fecha: '2026-02-21',
                poliza: 'D-004',
                cuenta: '540-001',
                nombre_cuenta: 'Gastos de Mantenimiento',
                concepto: 'Registro de mantenimiento',
                cargo: 15600.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-21',
                poliza: 'D-004',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Registro de mantenimiento',
                cargo: 0.00,
                abono: 15600.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-20',
                poliza: 'D-005',
                cuenta: '550-001',
                nombre_cuenta: 'Gastos de Materiales',
                concepto: 'Registro de compra de materiales',
                cargo: 27800.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-20',
                poliza: 'D-005',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Registro de compra de materiales',
                cargo: 0.00,
                abono: 27800.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-19',
                poliza: 'D-006',
                cuenta: '560-001',
                nombre_cuenta: 'Gastos de Rentas',
                concepto: 'Registro de renta de maquinaria',
                cargo: 38900.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-19',
                poliza: 'D-006',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Registro de renta de maquinaria',
                cargo: 0.00,
                abono: 38900.00,
                tipo: 'Diario'
            },
            // Registros adicionales para completar 30
            {
                fecha: '2026-02-18',
                poliza: 'I-008',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Pago de factura FAC-023-2026',
                cargo: 41250.00,
                abono: 0.00,
                tipo: 'Ingreso'
            },
            {
                fecha: '2026-02-17',
                poliza: 'E-010',
                cuenta: '210-001',
                nombre_cuenta: 'Proveedores',
                concepto: 'Pago a Servicios de Transporte',
                cargo: 0.00,
                abono: 18700.00,
                tipo: 'Egreso'
            },
            {
                fecha: '2026-02-16',
                poliza: 'D-007',
                cuenta: '570-001',
                nombre_cuenta: 'Gastos Varios',
                concepto: 'Registro de gastos varios',
                cargo: 32400.00,
                abono: 0.00,
                tipo: 'Diario'
            },
            {
                fecha: '2026-02-16',
                poliza: 'D-007',
                cuenta: '110-001',
                nombre_cuenta: 'Bancos Nacionales',
                concepto: 'Registro de gastos varios',
                cargo: 0.00,
                abono: 32400.00,
                tipo: 'Diario'
            }
        ];
        
        datosOriginales = [...datosDiario];
        totalRows = datosOriginales.length;
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString + 'T12:00:00');
            return date.toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const totalPolizas = [...new Set(datos.map(d => d.poliza))].length;
            const fechaInicio = new Date(document.getElementById('fechaInicio').value + 'T12:00:00');
            const fechaFin = new Date(document.getElementById('fechaFin').value + 'T12:00:00');
            
            const polizasMes = datos.filter(d => {
                const fecha = new Date(d.fecha + 'T12:00:00');
                return fecha >= fechaInicio && fecha <= fechaFin;
            }).length;
            
            const totalCargos = datos.reduce((sum, d) => sum + d.cargo, 0);
            const totalAbonos = datos.reduce((sum, d) => sum + d.abono, 0);
            
            document.getElementById('totalPolizas').textContent = totalPolizas;
            document.getElementById('polizasMes').textContent = polizasMes;
            document.getElementById('totalCargos').textContent = formatCurrency(totalCargos);
            document.getElementById('totalAbonos').textContent = formatCurrency(totalAbonos);
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'fecha': return item.fecha || 'Sin fecha';
                    case 'poliza': return item.poliza || 'Sin póliza';
                    case 'cuenta': return item.cuenta || 'Sin cuenta';
                    case 'nombre_cuenta': return item.nombre_cuenta || 'Sin nombre';
                    case 'concepto': return item.concepto || 'Sin concepto';
                    case 'cargo': return item.cargo ? item.cargo.toString() : '0';
                    case 'abono': return item.abono ? item.abono.toString() : '0';
                    case 'tipo': return item.tipo || 'Sin tipo';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'fecha': return formatDate(item.fecha) || 'Sin fecha';
                            case 'poliza': return item.poliza || 'Sin póliza';
                            case 'cuenta': return item.cuenta || 'Sin cuenta';
                            case 'nombre_cuenta': return item.nombre_cuenta || 'Sin nombre';
                            case 'concepto': return item.concepto || 'Sin concepto';
                            case 'cargo': return item.cargo || 0;
                            case 'abono': return item.abono || 0;
                            case 'tipo': return item.tipo || 'Sin tipo';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalCargos: item.cargo || 0,
                        totalAbonos: item.abono || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalCargos += item.cargo || 0;
                    grupo.totalAbonos += item.abono || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalCargos = 0;
            let totalAbonos = 0;
            
            datos.forEach(item => {
                totalCargos += item.cargo || 0;
                totalAbonos += item.abono || 0;
            });
            
            document.getElementById('sumCargos').textContent = formatCurrency(totalCargos);
            document.getElementById('sumAbonos').textContent = formatCurrency(totalAbonos);
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            document.getElementById('paginaActual').textContent = currentPage;
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            // Actualizar contadores de los cuadros
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumCargos').textContent = '$0.00';
                document.getElementById('sumAbonos').textContent = '$0.00';
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="9">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} movimientos - Cargos: ${formatCurrency(grupo.totalCargos)} - Abonos: ${formatCurrency(grupo.totalAbonos)})
                                    </span>
                                </div>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            let badgeClass = 'badge-diario';
                            if (item.tipo === 'Ingreso') badgeClass = 'badge-ingreso';
                            else if (item.tipo === 'Egreso') badgeClass = 'badge-egreso';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${formatDate(item.fecha)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.poliza || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre_cuenta || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cargo ? formatCurrency(item.cargo) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.abono ? formatCurrency(item.abono) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.tipo || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = datos.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-diario';
                    if (item.tipo === 'Ingreso') badgeClass = 'badge-ingreso';
                    else if (item.tipo === 'Egreso') badgeClass = 'badge-egreso';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.poliza || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre_cuenta || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cargo ? formatCurrency(item.cargo) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.abono ? formatCurrency(item.abono) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.tipo || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                calcularTotales(datos);
                
                actualizarPaginacion(datos.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'fecha': 'Fecha',
                        'poliza': 'Póliza',
                        'cuenta': 'Cuenta',
                        'nombre_cuenta': 'Nombre Cuenta',
                        'concepto': 'Concepto',
                        'cargo': 'Cargo',
                        'abono': 'Abono',
                        'tipo': 'Tipo'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTabla(datosOriginales);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTabla(datosOriginales);
            }
        });
        
        // Cargar datos iniciales
        cargarTabla(datosDiario);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnNuevo')?.addEventListener('click', function() {
            alert('Nueva Póliza - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaDiario', 'Diario_General');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosDiario.filter(item => 
                item.poliza?.toLowerCase().includes(busqueda) ||
                item.cuenta?.toLowerCase().includes(busqueda) ||
                item.nombre_cuenta?.toLowerCase().includes(busqueda) ||
                item.concepto?.toLowerCase().includes(busqueda) ||
                item.tipo?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosOriginales);
            });
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            currentPage = totalPages;
            cargarTabla(datosOriginales);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                alert('Ver movimiento - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-edit')) {
                alert('Editar movimiento - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar este movimiento?')) {
                    alert('Eliminar movimiento - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            }
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
    });
</script>
@endsection