@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- CFDI -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    CFDI
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE CFDI CENTRADOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pagadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Timbrado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Timbrado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con botón Crear filtro -->
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
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de CFDI -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: none;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaCFDI" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="serie">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Serie</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cfdi">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>CFDI</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="receptor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Receptor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uuid">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>UUID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Comprobante Total</span>
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
                    </table>
                </div>
                
                <!-- Paginación y botón Crear filtro - CORREGIDO -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;">1</span>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;">2</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
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
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-activa {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pagada {
        background-color: #ffc107;
        color: black;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
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
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN - VERSIÓN FINAL */
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
        console.log('DOM completamente cargado - CFDI');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        
        // Datos de ejemplo
        const datosCFDI = [
            {
                comprobanteSerie: 'A',
                comprobanteFolio: '1001',
                comprobanteFecha: '2026-01-15',
                receptorNombre: 'Maquiladora Industrial',
                estatus_txt: 'Activa',
                timbrefiscaldigitalUUID: 'ABC123DEF456GHI789',
                comprobanteTotal: 11600.00
            },
            {
                comprobanteSerie: 'B',
                comprobanteFolio: '1002',
                comprobanteFecha: '2026-01-14',
                receptorNombre: 'Cartones del Norte',
                estatus_txt: 'Pagada',
                timbrefiscaldigitalUUID: 'DEF456GHI789JKL012',
                comprobanteTotal: 9860.00
            },
            {
                comprobanteSerie: 'A',
                comprobanteFolio: '1003',
                comprobanteFecha: '2026-01-13',
                receptorNombre: 'Transportes del Bajío',
                estatus_txt: 'Cancelada',
                timbrefiscaldigitalUUID: 'GHI789JKL012MNO345',
                comprobanteTotal: 6032.00
            },
            {
                comprobanteSerie: 'B',
                comprobanteFolio: '1004',
                comprobanteFecha: '2026-01-12',
                receptorNombre: 'Logística Monterrey',
                estatus_txt: 'Activa',
                timbrefiscaldigitalUUID: 'JKL012MNO345PQR678',
                comprobanteTotal: 17248.00
            },
            {
                comprobanteSerie: 'A',
                comprobanteFolio: '1005',
                comprobanteFecha: '2026-01-11',
                receptorNombre: 'Comercializadora del Sur',
                estatus_txt: 'Pagada',
                timbrefiscaldigitalUUID: 'MNO345PQR678STU901',
                comprobanteTotal: 580.00
            },
            {
                comprobanteSerie: 'A',
                comprobanteFolio: '1006',
                comprobanteFecha: '2026-01-10',
                receptorNombre: 'Comercializadora del Sur',
                estatus_txt: 'Activa',
                timbrefiscaldigitalUUID: 'PQR678STU901VWX234',
                comprobanteTotal: 12500.00
            },
            {
                comprobanteSerie: 'B',
                comprobanteFolio: '1007',
                comprobanteFecha: '2026-01-09',
                receptorNombre: 'Maquiladora Industrial',
                estatus_txt: 'Pagada',
                timbrefiscaldigitalUUID: 'STU901VWX234YZA567',
                comprobanteTotal: 8900.00
            }
        ];
        
        datosOriginales = [...datosCFDI];
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'serie': return item.comprobanteSerie || 'Sin serie';
                    case 'cfdi': return item.comprobanteFolio || 'Sin folio';
                    case 'fecha': return item.comprobanteFecha || 'Sin fecha';
                    case 'receptor': return item.receptorNombre || 'Sin receptor';
                    case 'estatus': return item.estatus_txt || 'Sin estatus';
                    case 'uuid': return item.timbrefiscaldigitalUUID || 'Sin UUID';
                    case 'total': return item.comprobanteTotal ? item.comprobanteTotal.toString() : '0';
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
                            case 'serie': return item.comprobanteSerie || 'Sin serie';
                            case 'cfdi': return item.comprobanteFolio || 'Sin folio';
                            case 'fecha': return item.comprobanteFecha || 'Sin fecha';
                            case 'receptor': return item.receptorNombre || 'Sin receptor';
                            case 'estatus': return item.estatus_txt || 'Sin estatus';
                            case 'uuid': return item.timbrefiscaldigitalUUID || 'Sin UUID';
                            case 'total': return item.comprobanteTotal || 0;
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        total: item.comprobanteTotal || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.total += item.comprobanteTotal || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const paginacionContainer = document.getElementById('paginacionContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
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
                paginacionContainer.style.display = 'none';
                
                document.querySelectorAll('.custom-card div:last-child').forEach((el, index) => {
                    if (index < 4) el.textContent = '0';
                });
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            paginacionContainer.style.display = 'flex';
            
            // Actualizar contadores
            const totalFacturas = datos.length;
            const activas = datos.filter(d => d.estatus_txt === 'Activa').length;
            const pagadas = datos.filter(d => d.estatus_txt === 'Pagada').length;
            const timbradas = datos.filter(d => d.estatus_txt === 'Activa' || d.estatus_txt === 'Pagada').length;
            
            document.querySelectorAll('.custom-card div:last-child').forEach((el, index) => {
                if (index === 0) el.textContent = totalFacturas;
                else if (index === 1) el.textContent = activas;
                else if (index === 2) el.textContent = pagadas;
                else if (index === 3) el.textContent = timbradas;
            });
            
            if (hayGrupos) {
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    // Determinar el estatus predominante en el grupo (para el badge)
                    const estatusCounts = {};
                    grupo.items.forEach(item => {
                        estatusCounts[item.estatus_txt] = (estatusCounts[item.estatus_txt] || 0) + 1;
                    });
                    
                    let estatusPredominante = 'Activa';
                    let maxCount = 0;
                    for (const [estatus, count] of Object.entries(estatusCounts)) {
                        if (count > maxCount) {
                            maxCount = count;
                            estatusPredominante = estatus;
                        }
                    }
                    
                    let badgeClass = 'badge-activa';
                    if (estatusPredominante === 'Pagada') badgeClass = 'badge-pagada';
                    else if (estatusPredominante === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="8">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Total: ${formatCurrency(grupo.total)})
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
                            let itemBadgeClass = 'badge-activa';
                            if (item.estatus_txt === 'Pagada') itemBadgeClass = 'badge-pagada';
                            else if (item.estatus_txt === 'Cancelada') itemBadgeClass = 'badge-cancelada';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.comprobanteSerie || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.comprobanteFolio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.comprobanteFecha || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.receptorNombre || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <span class="badge ${itemBadgeClass}">${item.estatus_txt || '-'}</span>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px; color: #000000;">${item.timbrefiscaldigitalUUID || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.comprobanteTotal ? formatCurrency(item.comprobanteTotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                        <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
            } else {
                // Mostrar todos los items sin agrupar
                datos.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-activa';
                    if (item.estatus_txt === 'Pagada') badgeClass = 'badge-pagada';
                    else if (item.estatus_txt === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.comprobanteSerie || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.comprobanteFolio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.comprobanteFecha || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.receptorNombre || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <span class="badge ${badgeClass}">${item.estatus_txt || '-'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px; color: #000000;">${item.timbrefiscaldigitalUUID || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.comprobanteTotal ? formatCurrency(item.comprobanteTotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
            }
            
            if (paginacionInfo) {
                const totalRegistros = datos.length;
                const mostrando = hayGrupos ? grupos.length : datos.length;
                paginacionInfo.textContent = `Mostrando ${mostrando} de ${totalRegistros} registros`;
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
                        'serie': 'Serie',
                        'cfdi': 'CFDI',
                        'fecha': 'Fecha',
                        'receptor': 'Receptor',
                        'estatus': 'Estatus',
                        'uuid': 'UUID',
                        'total': 'Total'
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
        cargarTabla(datosCFDI);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners existentes
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
            // Aquí iría la lógica de filtrado por fecha
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
            // Aquí iría la lógica de filtrado por fecha
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Agregar CFDI - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaCFDI', 'CFDI');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosCFDI.filter(item => 
                item.comprobanteSerie?.toLowerCase().includes(busqueda) ||
                item.comprobanteFolio?.toLowerCase().includes(busqueda) ||
                item.receptorNombre?.toLowerCase().includes(busqueda) ||
                item.estatus_txt?.toLowerCase().includes(busqueda) ||
                item.timbrefiscaldigitalUUID?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
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
                alert('Editar CFDI - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar este CFDI?')) {
                    alert('Eliminar CFDI - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-file-code')) {
                alert('Descargar XML - Funcionalidad en desarrollo');
            }
        });
        
        // Paginación (simulada)
        document.querySelectorAll('#paginacionContainer button:not(#btnCrearFiltro)').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('active') && !this.closest('span')) {
                    alert('Cambiar de página - Funcionalidad en desarrollo');
                }
            });
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