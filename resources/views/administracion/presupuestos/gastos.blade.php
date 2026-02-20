@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Gastos Fijos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Gastos Fijos
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
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay gastos fijos para mostrar</p>
                </div>

                <!-- Tabla de Gastos Fijos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaGastosFijos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="id_gasto_fijo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>ID Gasto Fijo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proveedor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proveedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_inicio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Inicio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_fin">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Fin</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta_flujo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Flujo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uso_cfdi">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Uso CFDI</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="metodo_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="forma_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="importe">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Importe</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="10">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumImporte">$0.00</td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-8 de 8 registros</span>
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
    
    .badge-activo {
        background-color: #28a745;
        color: white;
    }
    
    .badge-inactivo {
        background-color: #6c757d;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-cancelado {
        background-color: #dc3545;
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
        console.log('DOM completamente cargado - Gastos Fijos');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let paginaActual = 1;
        const registrosPorPagina = 8;
        
        // Datos de ejemplo para Gastos Fijos
        const datosGastosFijos = [
            {
                gasto_fijo_id: 'GF-001',
                contacto: 'Servicios Corporativos',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-12-31',
                descripcion: 'Renta de oficinas corporativas',
                cuenta_flujo_dinero: 'CFD-001',
                satcat_uso_cfdi_clave: 'G01',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 45000.00
            },
            {
                gasto_fijo_id: 'GF-002',
                contacto: 'Teléfonos de México',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-06-30',
                descripcion: 'Servicio de internet y telefonía',
                cuenta_flujo_dinero: 'CFD-002',
                satcat_uso_cfdi_clave: 'G02',
                satcat_metodos_pago_clave: 'PUE',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 3500.00
            },
            {
                gasto_fijo_id: 'GF-003',
                contacto: 'CFE',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-03-31',
                descripcion: 'Servicio de energía eléctrica',
                cuenta_flujo_dinero: 'CFD-003',
                satcat_uso_cfdi_clave: 'G03',
                satcat_metodos_pago_clave: 'PUE',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 8500.00
            },
            {
                gasto_fijo_id: 'GF-004',
                contacto: 'Servicio de Agua',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-12-31',
                descripcion: 'Servicio de agua potable',
                cuenta_flujo_dinero: 'CFD-004',
                satcat_uso_cfdi_clave: 'G01',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 2800.00
            },
            {
                gasto_fijo_id: 'GF-005',
                contacto: 'Mantenimiento Industrial',
                fecha_inicio: '2026-02-01',
                fecha_fin: '2026-07-31',
                descripcion: 'Contrato de mantenimiento preventivo',
                cuenta_flujo_dinero: 'CFD-005',
                satcat_uso_cfdi_clave: 'G02',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 12500.00
            },
            {
                gasto_fijo_id: 'GF-006',
                contacto: 'Software Solutions',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-12-31',
                descripcion: 'Licencias de software anuales',
                cuenta_flujo_dinero: 'CFD-006',
                satcat_uso_cfdi_clave: 'G03',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 23000.00
            },
            {
                gasto_fijo_id: 'GF-007',
                contacto: 'Seguros Empresariales',
                fecha_inicio: '2026-03-01',
                fecha_fin: '2027-02-28',
                descripcion: 'Seguro de responsabilidad civil',
                cuenta_flujo_dinero: 'CFD-007',
                satcat_uso_cfdi_clave: 'G01',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 18700.00
            },
            {
                gasto_fijo_id: 'GF-008',
                contacto: 'Vigilancia y Seguridad',
                fecha_inicio: '2026-01-15',
                fecha_fin: '2026-07-15',
                descripcion: 'Servicio de vigilancia',
                cuenta_flujo_dinero: 'CFD-008',
                satcat_uso_cfdi_clave: 'G02',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Inactivo',
                importe: 15600.00
            },
            {
                gasto_fijo_id: 'GF-009',
                contacto: 'Limpieza Profesional',
                fecha_inicio: '2026-02-01',
                fecha_fin: '2026-08-31',
                descripcion: 'Servicio de limpieza',
                cuenta_flujo_dinero: 'CFD-009',
                satcat_uso_cfdi_clave: 'G03',
                satcat_metodos_pago_clave: 'PUE',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 9800.00
            },
            {
                gasto_fijo_id: 'GF-010',
                contacto: 'Arrendadora de Equipos',
                fecha_inicio: '2026-01-01',
                fecha_fin: '2026-12-31',
                descripcion: 'Renta de equipo de cómputo',
                cuenta_flujo_dinero: 'CFD-010',
                satcat_uso_cfdi_clave: 'G01',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 11200.00
            },
            {
                gasto_fijo_id: 'GF-011',
                contacto: 'Publicidad y Mercadotecnia',
                fecha_inicio: '2026-03-01',
                fecha_fin: '2026-05-31',
                descripcion: 'Campaña publicitaria trimestral',
                cuenta_flujo_dinero: 'CFD-011',
                satcat_uso_cfdi_clave: 'G02',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Activo',
                importe: 25000.00
            },
            {
                gasto_fijo_id: 'GF-012',
                contacto: 'Capacitación Empresarial',
                fecha_inicio: '2026-04-01',
                fecha_fin: '2026-06-30',
                descripcion: 'Programa de capacitación',
                cuenta_flujo_dinero: 'CFD-012',
                satcat_uso_cfdi_clave: 'G03',
                satcat_metodos_pago_clave: 'PPD',
                satcat_formas_pago_clave: 'Transferencia',
                estatus_txt: 'Pendiente',
                importe: 18500.00
            }
        ];

        datosOriginales = [...datosGastosFijos];
        let datosFiltrados = [...datosGastosFijos];
        
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
        const sumImporte = document.getElementById('sumImporte');
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
            if (estatus === 'Activo') return 'badge-activo';
            if (estatus === 'Inactivo') return 'badge-inactivo';
            if (estatus === 'Pendiente') return 'badge-pendiente';
            if (estatus === 'Cancelado') return 'badge-cancelado';
            return 'badge-pendiente';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'id_gasto_fijo': return item.gasto_fijo_id || 'Sin ID';
                    case 'proveedor': return item.contacto || 'Sin proveedor';
                    case 'fecha_inicio': return item.fecha_inicio || 'Sin fecha';
                    case 'fecha_fin': return item.fecha_fin || 'Sin fecha';
                    case 'descripcion': return item.descripcion || 'Sin descripción';
                    case 'cuenta_flujo': return item.cuenta_flujo_dinero || 'Sin cuenta';
                    case 'uso_cfdi': return item.satcat_uso_cfdi_clave || 'Sin uso';
                    case 'metodo_pago': return item.satcat_metodos_pago_clave || 'Sin método';
                    case 'forma_pago': return item.satcat_formas_pago_clave || 'Sin forma';
                    case 'estatus': return item.estatus_txt || 'Sin estatus';
                    case 'importe': return item.importe ? item.importe.toString() : '0';
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
                            case 'id_gasto_fijo': return item.gasto_fijo_id || 'Sin ID';
                            case 'proveedor': return item.contacto || 'Sin proveedor';
                            case 'fecha_inicio': return item.fecha_inicio ? formatDate(item.fecha_inicio) : 'Sin fecha';
                            case 'fecha_fin': return item.fecha_fin ? formatDate(item.fecha_fin) : 'Sin fecha';
                            case 'descripcion': return item.descripcion || 'Sin descripción';
                            case 'cuenta_flujo': return item.cuenta_flujo_dinero || 'Sin cuenta';
                            case 'uso_cfdi': return item.satcat_uso_cfdi_clave || 'Sin uso';
                            case 'metodo_pago': return item.satcat_metodos_pago_clave || 'Sin método';
                            case 'forma_pago': return item.satcat_formas_pago_clave || 'Sin forma';
                            case 'estatus': return item.estatus_txt || 'Sin estatus';
                            case 'importe': return item.importe || 0;
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalImporte: item.importe || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalImporte += item.importe || 0;
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
            let sumaImporte = 0;
            
            datos.forEach(item => {
                sumaImporte += item.importe || 0;
            });
            
            totalRegistros.textContent = datos.length;
            sumImporte.textContent = formatCurrency(sumaImporte);
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
                sumImporte.textContent = formatCurrency(0);
                
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
                    if (estatusPredominante === 'Activo') badgeClass = 'badge-activo';
                    else if (estatusPredominante === 'Inactivo') badgeClass = 'badge-inactivo';
                    else if (estatusPredominante === 'Cancelado') badgeClass = 'badge-cancelado';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="12">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Importe: ${formatCurrency(grupo.totalImporte)})
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
                            if (item.estatus_txt === 'Activo') itemBadgeClass = 'badge-activo';
                            else if (item.estatus_txt === 'Inactivo') itemBadgeClass = 'badge-inactivo';
                            else if (item.estatus_txt === 'Cancelado') itemBadgeClass = 'badge-cancelado';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.gasto_fijo_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contacto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_inicio ? formatDate(item.fecha_inicio) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_fin ? formatDate(item.fecha_fin) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo_dinero || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_uso_cfdi_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_metodos_pago_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_formas_pago_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <span class="badge ${itemBadgeClass}">${item.estatus_txt || '-'}</span>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.importe ? formatCurrency(item.importe) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.gasto_fijo_id}"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.gasto_fijo_id}"></i>
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.gasto_fijo_id}"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.gasto_fijo_id}"></i>
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
                    if (item.estatus_txt === 'Activo') badgeClass = 'badge-activo';
                    else if (item.estatus_txt === 'Inactivo') badgeClass = 'badge-inactivo';
                    else if (item.estatus_txt === 'Cancelado') badgeClass = 'badge-cancelado';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.gasto_fijo_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contacto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_inicio ? formatDate(item.fecha_inicio) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_fin ? formatDate(item.fecha_fin) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo_dinero || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_uso_cfdi_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_metodos_pago_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_formas_pago_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <span class="badge ${badgeClass}">${item.estatus_txt || '-'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.importe ? formatCurrency(item.importe) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.gasto_fijo_id}"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.gasto_fijo_id}"></i>
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.gasto_fijo_id}"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.gasto_fijo_id}"></i>
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
                        'id_gasto_fijo': 'ID Gasto Fijo',
                        'proveedor': 'Proveedor',
                        'fecha_inicio': 'Fecha Inicio',
                        'fecha_fin': 'Fecha Fin',
                        'descripcion': 'Descripción',
                        'cuenta_flujo': 'Cuenta Flujo',
                        'uso_cfdi': 'Uso CFDI',
                        'metodo_pago': 'Método Pago',
                        'forma_pago': 'Forma de Pago',
                        'estatus': 'Estatus',
                        'importe': 'Importe'
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
                    item.gasto_fijo_id?.toLowerCase().includes(termino) ||
                    item.contacto?.toLowerCase().includes(termino) ||
                    item.descripcion?.toLowerCase().includes(termino) ||
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
            alert('Agregar Gasto Fijo - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            exportTableToExcel('tablaGastosFijos', 'GastosFijos');
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
                alert(`Editar Gasto Fijo ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-trash-alt')) {
                const id = e.target.getAttribute('data-id');
                if (confirm(`¿Está seguro de eliminar el gasto fijo ID: ${id}?`)) {
                    alert(`Eliminar Gasto Fijo ID: ${id} - Funcionalidad en desarrollo`);
                }
            } else if (e.target.classList.contains('fa-eye')) {
                const id = e.target.getAttribute('data-id');
                alert(`Ver detalles de Gasto Fijo ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar PDF - Gasto Fijo ID: ${id} - Funcionalidad en desarrollo`);
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