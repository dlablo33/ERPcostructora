@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Ventas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Ventas
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
                            <input type="date" id="fechaInicio" value="2026-01-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-02-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar todo">
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
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Ventas -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaVentas" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cliente">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cliente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="producto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Producto/Servicio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cantidad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cantidad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="precio_unitario">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Precio Unit.</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descuento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descuento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="iva">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="metodo_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="vendedor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Vendedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="4">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumCantidad">0</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumPrecio">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumDescuento">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="4"></td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 45 registros</span>
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
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-completada {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-proceso {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-entregada {
        background-color: #28a745;
        color: white;
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
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Ventas');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Ventas (45 filas)
        const datosVentas = [
            {
                folio: 'V-001',
                fecha: '2026-01-15',
                cliente: 'Maquiladora Industrial',
                producto: 'Servicio de transporte',
                cantidad: 3,
                precio_unitario: 3500.00,
                descuento: 0.00,
                subtotal: 10500.00,
                iva: 1680.00,
                total: 12180.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Juan Pérez',
                estatus: 'Completada'
            },
            {
                folio: 'V-002',
                fecha: '2026-01-14',
                cliente: 'Cartones del Norte',
                producto: 'Mantenimiento',
                cantidad: 2,
                precio_unitario: 4200.00,
                descuento: 200.00,
                subtotal: 8200.00,
                iva: 1312.00,
                total: 9312.00,
                metodo_pago: 'Cheque',
                vendedor: 'María López',
                estatus: 'Pendiente'
            },
            {
                folio: 'V-003',
                fecha: '2026-01-13',
                cliente: 'Transportes del Bajío',
                producto: 'Refacciones',
                cantidad: 5,
                precio_unitario: 1200.00,
                descuento: 0.00,
                subtotal: 6000.00,
                iva: 960.00,
                total: 6960.00,
                metodo_pago: 'Efectivo',
                vendedor: 'Carlos Rodríguez',
                estatus: 'Completada'
            },
            {
                folio: 'V-004',
                fecha: '2026-01-12',
                cliente: 'Logística Monterrey',
                producto: 'Servicio express',
                cantidad: 4,
                precio_unitario: 3800.00,
                descuento: 500.00,
                subtotal: 14700.00,
                iva: 2352.00,
                total: 16552.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Ana Martínez',
                estatus: 'Proceso'
            },
            {
                folio: 'V-005',
                fecha: '2026-01-11',
                cliente: 'Comercializadora del Sur',
                producto: 'Consultoría',
                cantidad: 1,
                precio_unitario: 8500.00,
                descuento: 0.00,
                subtotal: 8500.00,
                iva: 1360.00,
                total: 9860.00,
                metodo_pago: 'Cheque',
                vendedor: 'Roberto Sánchez',
                estatus: 'Cancelada'
            },
            {
                folio: 'V-006',
                fecha: '2026-01-10',
                cliente: 'Papelera del Pacífico',
                producto: 'Insumos',
                cantidad: 10,
                precio_unitario: 450.00,
                descuento: 200.00,
                subtotal: 4300.00,
                iva: 688.00,
                total: 4788.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Laura Gómez',
                estatus: 'Completada'
            },
            {
                folio: 'V-007',
                fecha: '2026-01-09',
                cliente: 'Ferrocarriles Nacionales',
                producto: 'Mantenimiento',
                cantidad: 2,
                precio_unitario: 5600.00,
                descuento: 0.00,
                subtotal: 11200.00,
                iva: 1792.00,
                total: 12992.00,
                metodo_pago: 'Efectivo',
                vendedor: 'Pedro Hernández',
                estatus: 'Entregada'
            },
            {
                folio: 'V-008',
                fecha: '2026-01-08',
                cliente: 'Minería del Norte',
                producto: 'Equipo',
                cantidad: 1,
                precio_unitario: 15000.00,
                descuento: 1000.00,
                subtotal: 14000.00,
                iva: 2240.00,
                total: 16240.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Javier Ruiz',
                estatus: 'Pendiente'
            },
            {
                folio: 'V-009',
                fecha: '2026-01-07',
                cliente: 'Autotransportes Mexicanos',
                producto: 'Refacciones',
                cantidad: 8,
                precio_unitario: 800.00,
                descuento: 0.00,
                subtotal: 6400.00,
                iva: 1024.00,
                total: 7424.00,
                metodo_pago: 'Cheque',
                vendedor: 'Sofía Castro',
                estatus: 'Completada'
            },
            {
                folio: 'V-010',
                fecha: '2026-01-06',
                cliente: 'Cervecería del Centro',
                producto: 'Servicio',
                cantidad: 3,
                precio_unitario: 2900.00,
                descuento: 0.00,
                subtotal: 8700.00,
                iva: 1392.00,
                total: 10092.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Miguel Torres',
                estatus: 'Proceso'
            },
            {
                folio: 'V-011',
                fecha: '2026-01-05',
                cliente: 'Textiles del Valle',
                producto: 'Insumos',
                cantidad: 15,
                precio_unitario: 320.00,
                descuento: 300.00,
                subtotal: 4500.00,
                iva: 720.00,
                total: 4920.00,
                metodo_pago: 'Efectivo',
                vendedor: 'Diana Flores',
                estatus: 'Completada'
            },
            {
                folio: 'V-012',
                fecha: '2026-01-04',
                cliente: 'Productos Químicos',
                producto: 'Mantenimiento',
                cantidad: 2,
                precio_unitario: 4800.00,
                descuento: 0.00,
                subtotal: 9600.00,
                iva: 1536.00,
                total: 11136.00,
                metodo_pago: 'Transferencia',
                vendedor: 'Luis Ramírez',
                estatus: 'Cancelada'
            },
            {
                folio: 'V-013',
                fecha: '2026-01-03',
                cliente: 'Maquiladora Industrial',
                producto: 'Equipo',
                cantidad: 1,
                precio_unitario: 22500.00,
                descuento: 1500.00,
                subtotal: 21000.00,
                iva: 3360.00,
                total: 24360.00,
                metodo_pago: 'Cheque',
                vendedor: 'Juan Pérez',
                estatus: 'Completada'
            },
            {
                folio: 'V-014',
                fecha: '2026-01-02',
                cliente: 'Cartones del Norte',
                producto: 'Servicio',
                cantidad: 4,
                precio_unitario: 2100.00,
                descuento: 0.00,
                subtotal: 8400.00,
                iva: 1344.00,
                total: 9744.00,
                metodo_pago: 'Transferencia',
                vendedor: 'María López',
                estatus: 'Pendiente'
            },
            {
                folio: 'V-015',
                fecha: '2026-01-01',
                cliente: 'Transportes del Bajío',
                producto: 'Refacciones',
                cantidad: 6,
                precio_unitario: 950.00,
                descuento: 0.00,
                subtotal: 5700.00,
                iva: 912.00,
                total: 6612.00,
                metodo_pago: 'Efectivo',
                vendedor: 'Carlos Rodríguez',
                estatus: 'Entregada'
            }
        ];
        
        // Añadir más ventas hasta llegar a 45
        for (let i = 16; i <= 45; i++) {
            const estatuses = ['Completada', 'Pendiente', 'Proceso', 'Entregada', 'Cancelada'];
            const clientes = ['Maquiladora Industrial', 'Cartones del Norte', 'Transportes del Bajío', 'Logística Monterrey', 'Comercializadora del Sur', 'Papelera del Pacífico', 'Ferrocarriles Nacionales', 'Minería del Norte', 'Autotransportes Mexicanos', 'Cervecería del Centro'];
            const vendedores = ['Juan Pérez', 'María López', 'Carlos Rodríguez', 'Ana Martínez', 'Roberto Sánchez', 'Laura Gómez', 'Pedro Hernández', 'Javier Ruiz', 'Sofía Castro', 'Miguel Torres'];
            const productos = ['Servicio', 'Mantenimiento', 'Refacciones', 'Equipo', 'Insumos', 'Consultoría'];
            
            datosVentas.push({
                folio: `V-${i.toString().padStart(3, '0')}`,
                fecha: `2025-12-${Math.floor(Math.random() * 20) + 1}`,
                cliente: clientes[Math.floor(Math.random() * clientes.length)],
                producto: productos[Math.floor(Math.random() * productos.length)],
                cantidad: Math.floor(Math.random() * 10) + 1,
                precio_unitario: Math.floor(Math.random() * 5000) + 500,
                descuento: Math.random() > 0.7 ? Math.floor(Math.random() * 1000) : 0,
                metodo_pago: ['Transferencia', 'Cheque', 'Efectivo'][Math.floor(Math.random() * 3)],
                vendedor: vendedores[Math.floor(Math.random() * vendedores.length)],
                estatus: estatuses[Math.floor(Math.random() * estatuses.length)]
            });
            
            // Calcular subtotal, iva y total
            const lastIndex = datosVentas.length - 1;
            const item = datosVentas[lastIndex];
            item.subtotal = (item.cantidad * item.precio_unitario) - item.descuento;
            item.iva = item.subtotal * 0.16;
            item.total = item.subtotal + item.iva;
        }
        
        datosOriginales = [...datosVentas];
        totalRows = datosOriginales.length;
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'folio': return item.folio || 'Sin folio';
                    case 'fecha': return item.fecha || 'Sin fecha';
                    case 'cliente': return item.cliente || 'Sin cliente';
                    case 'producto': return item.producto || 'Sin producto';
                    case 'cantidad': return item.cantidad ? item.cantidad.toString() : '0';
                    case 'precio_unitario': return item.precio_unitario ? item.precio_unitario.toString() : '0';
                    case 'descuento': return item.descuento ? item.descuento.toString() : '0';
                    case 'subtotal': return item.subtotal ? item.subtotal.toString() : '0';
                    case 'iva': return item.iva ? item.iva.toString() : '0';
                    case 'total': return item.total ? item.total.toString() : '0';
                    case 'metodo_pago': return item.metodo_pago || 'Sin método';
                    case 'vendedor': return item.vendedor || 'Sin vendedor';
                    case 'estatus': return item.estatus || 'Sin estatus';
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
                            case 'folio': return item.folio || 'Sin folio';
                            case 'fecha': return item.fecha ? formatDate(item.fecha) : 'Sin fecha';
                            case 'cliente': return item.cliente || 'Sin cliente';
                            case 'producto': return item.producto || 'Sin producto';
                            case 'cantidad': return item.cantidad || 0;
                            case 'precio_unitario': return item.precio_unitario || 0;
                            case 'descuento': return item.descuento || 0;
                            case 'subtotal': return item.subtotal || 0;
                            case 'iva': return item.iva || 0;
                            case 'total': return item.total || 0;
                            case 'metodo_pago': return item.metodo_pago || 'Sin método';
                            case 'vendedor': return item.vendedor || 'Sin vendedor';
                            case 'estatus': return item.estatus || 'Sin estatus';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalCantidad: item.cantidad || 0,
                        totalPrecio: item.precio_unitario || 0,
                        totalDescuento: item.descuento || 0,
                        totalSubtotal: item.subtotal || 0,
                        totalIva: item.iva || 0,
                        totalGeneral: item.total || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalCantidad += item.cantidad || 0;
                    grupo.totalPrecio += item.precio_unitario || 0;
                    grupo.totalDescuento += item.descuento || 0;
                    grupo.totalSubtotal += item.subtotal || 0;
                    grupo.totalIva += item.iva || 0;
                    grupo.totalGeneral += item.total || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalCantidad = 0;
            let totalPrecio = 0;
            let totalDescuento = 0;
            let totalSubtotal = 0;
            let totalIva = 0;
            let totalGeneral = 0;
            
            datos.forEach(item => {
                totalCantidad += item.cantidad || 0;
                totalPrecio += item.precio_unitario || 0;
                totalDescuento += item.descuento || 0;
                totalSubtotal += item.subtotal || 0;
                totalIva += item.iva || 0;
                totalGeneral += item.total || 0;
            });
            
            document.getElementById('sumCantidad').textContent = totalCantidad;
            document.getElementById('sumPrecio').textContent = formatCurrency(totalPrecio);
            document.getElementById('sumDescuento').textContent = formatCurrency(totalDescuento);
            document.getElementById('sumSubtotal').textContent = formatCurrency(totalSubtotal);
            document.getElementById('sumIva').textContent = formatCurrency(totalIva);
            document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
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
            
            // Mostrar/ocultar botones de página según sea necesario
            document.querySelectorAll('.pagina-btn').forEach(btn => {
                const pagina = parseInt(btn.dataset.pagina);
                if (pagina <= totalPages) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });
            
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
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
                
                // Resetear totales
                document.getElementById('sumCantidad').textContent = '0';
                document.getElementById('sumPrecio').textContent = '$0.00';
                document.getElementById('sumDescuento').textContent = '$0.00';
                document.getElementById('sumSubtotal').textContent = '$0.00';
                document.getElementById('sumIva').textContent = '$0.00';
                document.getElementById('sumTotal').textContent = '$0.00';
                
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
                    
                    // Determinar el estatus predominante en el grupo
                    const estatusCounts = {};
                    grupo.items.forEach(item => {
                        estatusCounts[item.estatus] = (estatusCounts[item.estatus] || 0) + 1;
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
                    if (estatusPredominante === 'Completada' || estatusPredominante === 'Entregada') badgeClass = 'badge-completada';
                    else if (estatusPredominante === 'Cancelada') badgeClass = 'badge-cancelada';
                    else if (estatusPredominante === 'Proceso') badgeClass = 'badge-proceso';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="14">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Subtotal: ${formatCurrency(grupo.totalSubtotal)} - IVA: ${formatCurrency(grupo.totalIva)} - Total: ${formatCurrency(grupo.totalGeneral)})
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
                            if (item.estatus === 'Completada' || item.estatus === 'Entregada') itemBadgeClass = 'badge-completada';
                            else if (item.estatus === 'Cancelada') itemBadgeClass = 'badge-cancelada';
                            else if (item.estatus === 'Proceso') itemBadgeClass = 'badge-proceso';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.folio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.producto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cantidad || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.precio_unitario ? formatCurrency(item.precio_unitario) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.vendedor || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <span class="badge ${itemBadgeClass}">${item.estatus || '-'}</span>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                        <i class="fas fa-print" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Imprimir"></i>
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
                    
                    let badgeClass = 'badge-pendiente';
                    if (item.estatus === 'Completada' || item.estatus === 'Entregada') badgeClass = 'badge-completada';
                    else if (item.estatus === 'Cancelada') badgeClass = 'badge-cancelada';
                    else if (item.estatus === 'Proceso') badgeClass = 'badge-proceso';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.producto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cantidad || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.precio_unitario ? formatCurrency(item.precio_unitario) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.vendedor || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <span class="badge ${badgeClass}">${item.estatus || '-'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                <i class="fas fa-print" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Imprimir"></i>
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
                        'fecha': 'Fecha',
                        'cliente': 'Cliente',
                        'producto': 'Producto/Servicio',
                        'cantidad': 'Cantidad',
                        'precio_unitario': 'Precio Unit.',
                        'descuento': 'Descuento',
                        'subtotal': 'Subtotal',
                        'iva': 'IVA',
                        'total': 'Total',
                        'metodo_pago': 'Método Pago',
                        'vendedor': 'Vendedor',
                        'estatus': 'Estatus'
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
        cargarTabla(datosVentas);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Agregar Venta - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaVentas', 'Ventas');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosVentas.filter(item => 
                item.folio?.toLowerCase().includes(busqueda) ||
                item.cliente?.toLowerCase().includes(busqueda) ||
                item.producto?.toLowerCase().includes(busqueda) ||
                item.vendedor?.toLowerCase().includes(busqueda) ||
                item.estatus?.toLowerCase().includes(busqueda)
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
            if (e.target.classList.contains('fa-edit')) {
                alert('Editar Venta - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar esta venta?')) {
                    alert('Eliminar Venta - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-print')) {
                alert('Imprimir Venta - Funcionalidad en desarrollo');
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