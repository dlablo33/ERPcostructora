@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Reasignación de Gastos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Reasignación de Gastos
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
                    <i class="fas fa-exchange-alt" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay gastos para reasignar</p>
                </div>

                <!-- Tabla de Reasignación de Gastos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaReasignacionGastos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_movimiento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Movimiento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="operador">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Operador</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="empresa">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Empresa</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_gasto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo Gasto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="gasto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Gasto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="carta_porte">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Carta Porte</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Unidad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="viaje">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Viaje</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="moneda">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total_mxn">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total MXN</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="layout">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Layout</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="transferencia">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Transferencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="prestamo_id">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Préstamo ID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="no_cuenta">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Cuenta</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="creado_por">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Creado por</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="12">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotalMXN">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="7"></td>
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
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-aprobado {
        background-color: #28a745;
        color: white;
    }
    
    .badge-rechazado {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-procesado {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-cancelado {
        background-color: #6c757d;
        color: white;
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Reasignación de Gastos');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let paginaActual = 1;
        const registrosPorPagina = 8;
        
        // Datos de ejemplo para Reasignación de Gastos (sin cliente y usuario)
        const datosReasignacionGastos = [
            {
                anticipo_concepto_id: 1001,
                estatus_txt: 'Pendiente',
                fecha: '2026-02-01',
                plantilla: 'Juan Pérez',
                plantilla_empresa: 'Transportes del Bajío',
                tipo_gasto: 'Combustible',
                descripcion: 'Gasto de combustible',
                descripcion_anticipo: 'Anticipo para combustible',
                carta_porte_id: 'CP-001',
                numero_unidad: 'U-001',
                viaje_id: 'VIA-001',
                moneda: 'MXN',
                suma_concepto_conver: 2500.00,
                suma_concepto: 2500.00,
                pago_layout_id: 'LAY-001',
                folio_transferencia: 'TRF-001',
                prestamo_descuento_id: null,
                cuenta_banco: '1234-5678-9012-3456',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1002,
                estatus_txt: 'Aprobado',
                fecha: '2026-02-02',
                plantilla: 'María López',
                plantilla_empresa: 'Logística Monterrey',
                tipo_gasto: 'Caseta',
                descripcion: 'Pago de casetas',
                descripcion_anticipo: 'Anticipo para casetas',
                carta_porte_id: 'CP-002',
                numero_unidad: 'U-002',
                viaje_id: 'VIA-002',
                moneda: 'MXN',
                suma_concepto_conver: 850.00,
                suma_concepto: 850.00,
                pago_layout_id: 'LAY-002',
                folio_transferencia: 'TRF-002',
                prestamo_descuento_id: null,
                cuenta_banco: '5678-1234-5678-1234',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1003,
                estatus_txt: 'Procesado',
                fecha: '2026-02-03',
                plantilla: 'Carlos Rodríguez',
                plantilla_empresa: 'Autotransportes Mexicanos',
                tipo_gasto: 'Mantenimiento',
                descripcion: 'Mantenimiento preventivo',
                descripcion_anticipo: 'Anticipo para mantenimiento',
                carta_porte_id: 'CP-003',
                numero_unidad: 'U-003',
                viaje_id: 'VIA-003',
                moneda: 'MXN',
                suma_concepto_conver: 3200.00,
                suma_concepto: 3200.00,
                pago_layout_id: 'LAY-003',
                folio_transferencia: 'TRF-003',
                prestamo_descuento_id: null,
                cuenta_banco: '4321-8765-4321-8765',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1004,
                estatus_txt: 'Pendiente',
                fecha: '2026-02-04',
                plantilla: 'Ana Martínez',
                plantilla_empresa: 'Ferrocarriles Nacionales',
                tipo_gasto: 'Viáticos',
                descripcion: 'Viáticos para operador',
                descripcion_anticipo: 'Anticipo para viáticos',
                carta_porte_id: 'CP-004',
                numero_unidad: 'U-004',
                viaje_id: 'VIA-004',
                moneda: 'MXN',
                suma_concepto_conver: 1800.00,
                suma_concepto: 1800.00,
                pago_layout_id: 'LAY-004',
                folio_transferencia: 'TRF-004',
                prestamo_descuento_id: null,
                cuenta_banco: '2468-1357-2468-1357',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1005,
                estatus_txt: 'Rechazado',
                fecha: '2026-02-05',
                plantilla: 'Roberto Sánchez',
                plantilla_empresa: 'Cervecería del Centro',
                tipo_gasto: 'Refacciones',
                descripcion: 'Compra de refacciones',
                descripcion_anticipo: 'Anticipo para refacciones',
                carta_porte_id: 'CP-005',
                numero_unidad: 'U-005',
                viaje_id: 'VIA-005',
                moneda: 'USD',
                suma_concepto_conver: 450.00,
                suma_concepto: 9000.00,
                pago_layout_id: 'LAY-005',
                folio_transferencia: 'TRF-005',
                prestamo_descuento_id: null,
                cuenta_banco: '1357-2468-1357-2468',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1006,
                estatus_txt: 'Aprobado',
                fecha: '2026-02-06',
                plantilla: 'Laura Gómez',
                plantilla_empresa: 'Papelera del Pacífico',
                tipo_gasto: 'Llantas',
                descripcion: 'Compra de llantas',
                descripcion_anticipo: 'Anticipo para llantas',
                carta_porte_id: 'CP-006',
                numero_unidad: 'U-006',
                viaje_id: 'VIA-006',
                moneda: 'MXN',
                suma_concepto_conver: 5600.00,
                suma_concepto: 5600.00,
                pago_layout_id: 'LAY-006',
                folio_transferencia: 'TRF-006',
                prestamo_descuento_id: null,
                cuenta_banco: '7890-1234-7890-1234',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1007,
                estatus_txt: 'Cancelado',
                fecha: '2026-02-07',
                plantilla: 'Pedro Hernández',
                plantilla_empresa: 'Minería del Norte',
                tipo_gasto: 'Otros',
                descripcion: 'Gastos varios',
                descripcion_anticipo: 'Anticipo para gastos varios',
                carta_porte_id: 'CP-007',
                numero_unidad: 'U-007',
                viaje_id: 'VIA-007',
                moneda: 'MXN',
                suma_concepto_conver: 2300.00,
                suma_concepto: 2300.00,
                pago_layout_id: 'LAY-007',
                folio_transferencia: 'TRF-007',
                prestamo_descuento_id: null,
                cuenta_banco: '4567-8901-4567-8901',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1008,
                estatus_txt: 'Procesado',
                fecha: '2026-02-08',
                plantilla: 'Javier Ruiz',
                plantilla_empresa: 'Comercializadora del Sur',
                tipo_gasto: 'Combustible',
                descripcion: 'Gasto de combustible',
                descripcion_anticipo: 'Anticipo para combustible',
                carta_porte_id: 'CP-008',
                numero_unidad: 'U-008',
                viaje_id: 'VIA-008',
                moneda: 'MXN',
                suma_concepto_conver: 3450.00,
                suma_concepto: 3450.00,
                pago_layout_id: 'LAY-008',
                folio_transferencia: 'TRF-008',
                prestamo_descuento_id: null,
                cuenta_banco: '1122-3344-5566-7788',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1009,
                estatus_txt: 'Pendiente',
                fecha: '2026-02-09',
                plantilla: 'Sofía Castro',
                plantilla_empresa: 'Transportes Unidos',
                tipo_gasto: 'Caseta',
                descripcion: 'Pago de casetas',
                descripcion_anticipo: 'Anticipo para casetas',
                carta_porte_id: 'CP-009',
                numero_unidad: 'U-009',
                viaje_id: 'VIA-009',
                moneda: 'MXN',
                suma_concepto_conver: 920.00,
                suma_concepto: 920.00,
                pago_layout_id: 'LAY-009',
                folio_transferencia: 'TRF-009',
                prestamo_descuento_id: null,
                cuenta_banco: '9988-7766-5544-3322',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1010,
                estatus_txt: 'Aprobado',
                fecha: '2026-02-10',
                plantilla: 'Miguel Torres',
                plantilla_empresa: 'Distribuidora de Papel',
                tipo_gasto: 'Mantenimiento',
                descripcion: 'Mantenimiento correctivo',
                descripcion_anticipo: 'Anticipo para mantenimiento',
                carta_porte_id: 'CP-010',
                numero_unidad: 'U-010',
                viaje_id: 'VIA-010',
                moneda: 'MXN',
                suma_concepto_conver: 4300.00,
                suma_concepto: 4300.00,
                pago_layout_id: 'LAY-010',
                folio_transferencia: 'TRF-010',
                prestamo_descuento_id: null,
                cuenta_banco: '1472-5836-9258-1472',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1011,
                estatus_txt: 'Pendiente',
                fecha: '2026-02-11',
                plantilla: 'Diana Flores',
                plantilla_empresa: 'Servicios Logísticos Integrales',
                tipo_gasto: 'Viáticos',
                descripcion: 'Viáticos para operador',
                descripcion_anticipo: 'Anticipo para viáticos',
                carta_porte_id: 'CP-011',
                numero_unidad: 'U-011',
                viaje_id: 'VIA-011',
                moneda: 'MXN',
                suma_concepto_conver: 2100.00,
                suma_concepto: 2100.00,
                pago_layout_id: 'LAY-011',
                folio_transferencia: 'TRF-011',
                prestamo_descuento_id: null,
                cuenta_banco: '3698-5214-7896-3214',
                created_by: 'Sistema'
            },
            {
                anticipo_concepto_id: 1012,
                estatus_txt: 'Procesado',
                fecha: '2026-02-12',
                plantilla: 'Luis Ramírez',
                plantilla_empresa: 'Transportes Express',
                tipo_gasto: 'Refacciones',
                descripcion: 'Compra de refacciones',
                descripcion_anticipo: 'Anticipo para refacciones',
                carta_porte_id: 'CP-012',
                numero_unidad: 'U-012',
                viaje_id: 'VIA-012',
                moneda: 'MXN',
                suma_concepto_conver: 1800.00,
                suma_concepto: 1800.00,
                pago_layout_id: 'LAY-012',
                folio_transferencia: 'TRF-012',
                prestamo_descuento_id: null,
                cuenta_banco: '7531-9513-7531-9513',
                created_by: 'Sistema'
            }
        ];

        datosOriginales = [...datosReasignacionGastos];
        let datosFiltrados = [...datosReasignacionGastos];
        
        // Elementos del DOM
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnAgregar = document.getElementById('btnAgregar');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const buscador = document.getElementById('buscador');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const tablaFoot = document.getElementById('tablaFoot');
        const totalRegistros = document.getElementById('totalRegistros');
        const sumTotal = document.getElementById('sumTotal');
        const sumTotalMXN = document.getElementById('sumTotalMXN');
        const paginacionInfo = document.getElementById('paginacionInfo');
        const textoAgrupar = document.getElementById('textoAgrupar');
        
        // Elementos de paginación
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit' });
        }
        
        // Función para obtener la clase del badge según estatus
        function getBadgeClass(estatus) {
            if (estatus === 'Pendiente') return 'badge-pendiente';
            if (estatus === 'Aprobado') return 'badge-aprobado';
            if (estatus === 'Rechazado') return 'badge-rechazado';
            if (estatus === 'Procesado') return 'badge-procesado';
            if (estatus === 'Cancelado') return 'badge-cancelado';
            return 'badge-pendiente';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'folio': return item.anticipo_concepto_id ? item.anticipo_concepto_id.toString() : 'Sin folio';
                    case 'estatus': return item.estatus_txt || 'Sin estatus';
                    case 'fecha_movimiento': return item.fecha || 'Sin fecha';
                    case 'operador': return item.plantilla || 'Sin operador';
                    case 'empresa': return item.plantilla_empresa || 'Sin empresa';
                    case 'tipo_gasto': return item.tipo_gasto || 'Sin tipo';
                    case 'gasto': return item.descripcion || 'Sin gasto';
                    case 'descripcion': return item.descripcion_anticipo || 'Sin descripción';
                    case 'carta_porte': return item.carta_porte_id || 'Sin CP';
                    case 'unidad': return item.numero_unidad || 'Sin unidad';
                    case 'viaje': return item.viaje_id || 'Sin viaje';
                    case 'moneda': return item.moneda || 'Sin moneda';
                    case 'total': return item.suma_concepto_conver ? item.suma_concepto_conver.toString() : '0';
                    case 'total_mxn': return item.suma_concepto ? item.suma_concepto.toString() : '0';
                    case 'layout': return item.pago_layout_id || 'Sin layout';
                    case 'transferencia': return item.folio_transferencia || 'Sin transferencia';
                    case 'prestamo_id': return item.prestamo_descuento_id ? item.prestamo_descuento_id.toString() : 'Sin préstamo';
                    case 'no_cuenta': return item.cuenta_banco || 'Sin cuenta';
                    case 'creado_por': return item.created_by || 'Sin creador';
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
                            case 'folio': return item.anticipo_concepto_id || 'Sin folio';
                            case 'estatus': return item.estatus_txt || 'Sin estatus';
                            case 'fecha_movimiento': return item.fecha ? formatDate(item.fecha) : 'Sin fecha';
                            case 'operador': return item.plantilla || 'Sin operador';
                            case 'empresa': return item.plantilla_empresa || 'Sin empresa';
                            case 'tipo_gasto': return item.tipo_gasto || 'Sin tipo';
                            case 'gasto': return item.descripcion || 'Sin gasto';
                            case 'descripcion': return item.descripcion_anticipo || 'Sin descripción';
                            case 'carta_porte': return item.carta_porte_id || 'Sin CP';
                            case 'unidad': return item.numero_unidad || 'Sin unidad';
                            case 'viaje': return item.viaje_id || 'Sin viaje';
                            case 'moneda': return item.moneda || 'Sin moneda';
                            case 'total': return item.suma_concepto_conver || 0;
                            case 'total_mxn': return item.suma_concepto || 0;
                            case 'layout': return item.pago_layout_id || 'Sin layout';
                            case 'transferencia': return item.folio_transferencia || 'Sin transferencia';
                            case 'prestamo_id': return item.prestamo_descuento_id || 'Sin préstamo';
                            case 'no_cuenta': return item.cuenta_banco || 'Sin cuenta';
                            case 'creado_por': return item.created_by || 'Sin creador';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalSuma: item.suma_concepto_conver || 0,
                        totalMXN: item.suma_concepto || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalSuma += item.suma_concepto_conver || 0;
                    grupo.totalMXN += item.suma_concepto || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (paginaActual - 1) * registrosPorPagina;
            const end = start + registrosPorPagina;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPaginas = Math.ceil(total / registrosPorPagina);
            paginaActualSpan.textContent = paginaActual;
            
            // Mostrar/ocultar botones de página según sea necesario
            document.querySelectorAll('.pagina-btn').forEach(btn => {
                const pagina = parseInt(btn.dataset.pagina);
                if (pagina <= totalPaginas) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });
            
            const inicio = total > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
            const fin = Math.min(paginaActual * registrosPorPagina, total);
            paginacionInfo.textContent = `Mostrando ${inicio}-${fin} de ${total} registros`;
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let sumaTotal = 0;
            let sumaTotalMXN = 0;
            
            datos.forEach(item => {
                sumaTotal += item.suma_concepto_conver || 0;
                sumaTotalMXN += item.suma_concepto || 0;
            });
            
            totalRegistros.textContent = datos.length;
            sumTotal.textContent = formatCurrency(sumaTotal);
            sumTotalMXN.textContent = formatCurrency(sumaTotalMXN);
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            if (!tablaBody) return;
            
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
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                totalRegistros.textContent = '0';
                sumTotal.textContent = formatCurrency(0);
                sumTotalMXN.textContent = formatCurrency(0);
                
                paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
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
                    
                    // Determinar el estatus predominante en el grupo
                    const estatusCounts = {};
                    grupo.items.forEach(item => {
                        estatusCounts[item.estatus_txt] = (estatusCounts[item.estatus_txt] || 0) + 1;
                    });
                    
                    let estatusPredominante = 'Pendiente';
                    let maxCount = 0;
                    for (const [estatus, count] of Object.entries(estatusCounts)) {
                        if (count > maxCount) {
                            maxCount = count;
                            estatusPredominante = estatus;
                        }
                    }
                    
                    let badgeClass = 'badge-pendiente';
                    if (estatusPredominante === 'Aprobado') badgeClass = 'badge-aprobado';
                    else if (estatusPredominante === 'Rechazado') badgeClass = 'badge-rechazado';
                    else if (estatusPredominante === 'Procesado') badgeClass = 'badge-procesado';
                    else if (estatusPredominante === 'Cancelado') badgeClass = 'badge-cancelado';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="20">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Total: ${formatCurrency(grupo.totalSuma)} - Total MXN: ${formatCurrency(grupo.totalMXN)})
                                    </span>
                                </div>
                                <span class="badge ${badgeClass}" style="margin-right: 10px;">${estatusPredominante}</span>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            // Badge para cada item
                            let itemBadgeClass = 'badge-pendiente';
                            if (item.estatus_txt === 'Aprobado') itemBadgeClass = 'badge-aprobado';
                            else if (item.estatus_txt === 'Rechazado') itemBadgeClass = 'badge-rechazado';
                            else if (item.estatus_txt === 'Procesado') itemBadgeClass = 'badge-procesado';
                            else if (item.estatus_txt === 'Cancelado') itemBadgeClass = 'badge-cancelado';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.anticipo_concepto_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <span class="badge ${itemBadgeClass}">${item.estatus_txt || '-'}</span>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.plantilla || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.plantilla_empresa || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_gasto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion_anticipo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.carta_porte_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.numero_unidad || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.viaje_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.moneda || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.suma_concepto_conver ? formatCurrency(item.suma_concepto_conver) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.suma_concepto ? formatCurrency(item.suma_concepto) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.pago_layout_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_transferencia || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.prestamo_descuento_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_banco || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.created_by || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.anticipo_concepto_id}"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.anticipo_concepto_id}"></i>
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.anticipo_concepto_id}"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.anticipo_concepto_id}"></i>
                                        <i class="fas fa-exchange-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Reasignar" data-id="${item.anticipo_concepto_id}"></i>
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
                
                pageData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-pendiente';
                    if (item.estatus_txt === 'Aprobado') badgeClass = 'badge-aprobado';
                    else if (item.estatus_txt === 'Rechazado') badgeClass = 'badge-rechazado';
                    else if (item.estatus_txt === 'Procesado') badgeClass = 'badge-procesado';
                    else if (item.estatus_txt === 'Cancelado') badgeClass = 'badge-cancelado';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.anticipo_concepto_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                            <span class="badge ${badgeClass}">${item.estatus_txt || '-'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.plantilla || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.plantilla_empresa || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_gasto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion_anticipo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.carta_porte_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.numero_unidad || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.viaje_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.moneda || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.suma_concepto_conver ? formatCurrency(item.suma_concepto_conver) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.suma_concepto ? formatCurrency(item.suma_concepto) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.pago_layout_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_transferencia || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.prestamo_descuento_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_banco || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.created_by || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.anticipo_concepto_id}"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.anticipo_concepto_id}"></i>
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.anticipo_concepto_id}"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.anticipo_concepto_id}"></i>
                                <i class="fas fa-exchange-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Reasignar" data-id="${item.anticipo_concepto_id}"></i>
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
                        'folio': 'Folio',
                        'estatus': 'Estatus',
                        'fecha_movimiento': 'Fecha Movimiento',
                        'operador': 'Operador',
                        'empresa': 'Empresa',
                        'tipo_gasto': 'Tipo Gasto',
                        'gasto': 'Gasto',
                        'descripcion': 'Descripción',
                        'carta_porte': 'Carta Porte',
                        'unidad': 'Unidad',
                        'viaje': 'Viaje',
                        'moneda': 'Moneda',
                        'total': 'Total',
                        'total_mxn': 'Total MXN',
                        'layout': 'Layout',
                        'transferencia': 'Transferencia',
                        'prestamo_id': 'Préstamo ID',
                        'no_cuenta': 'No. Cuenta',
                        'creado_por': 'Creado por'
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
            cargarTabla(datosFiltrados);
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
                cargarTabla(datosFiltrados);
            }
        });
        
        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            const termino = buscador.value.toLowerCase().trim();
            
            if (termino === '') {
                datosFiltrados = [...datosOriginales];
            } else {
                datosFiltrados = datosOriginales.filter(item => 
                    item.anticipo_concepto_id?.toString().includes(termino) ||
                    item.plantilla?.toLowerCase().includes(termino) ||
                    item.plantilla_empresa?.toLowerCase().includes(termino) ||
                    item.descripcion?.toLowerCase().includes(termino) ||
                    item.descripcion_anticipo?.toLowerCase().includes(termino) ||
                    item.estatus_txt?.toLowerCase().includes(termino)
                );
            }
            
            paginaActual = 1;
            cargarTabla(datosFiltrados);
        }
        
        // Función para cambiar de página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                cargarTabla(datosFiltrados);
            }
        }
        
        // Cargar datos iniciales
        cargarTabla(datosOriginales);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        btnCrearFiltro.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        btnAgregar.addEventListener('click', function() {
            alert('Agregar Gasto - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            exportTableToExcel('tablaReasignacionGastos', 'ReasignacionGastos');
        });
        
        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        buscador.addEventListener('input', filtrarPorBusqueda);
        
        // Eventos de paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                cambiarPagina(parseInt(this.dataset.pagina));
            });
        });
        
        btnPrimera.addEventListener('click', () => cambiarPagina(1));
        btnAnterior.addEventListener('click', () => cambiarPagina(paginaActual - 1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(paginaActual + 1));
        btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(datosFiltrados.length / registrosPorPagina)));
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-edit')) {
                const id = e.target.getAttribute('data-id');
                alert(`Editar Gasto ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-trash-alt')) {
                const id = e.target.getAttribute('data-id');
                if (confirm(`¿Está seguro de eliminar el gasto ID: ${id}?`)) {
                    alert(`Eliminar Gasto ID: ${id} - Funcionalidad en desarrollo`);
                }
            } else if (e.target.classList.contains('fa-eye')) {
                const id = e.target.getAttribute('data-id');
                alert(`Ver detalles de Gasto ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar PDF - Gasto ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-exchange-alt')) {
                const id = e.target.getAttribute('data-id');
                alert(`Reasignar Gasto ID: ${id} - Funcionalidad en desarrollo`);
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