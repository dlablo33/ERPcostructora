@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Programación de Pagos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #6B8ACE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Programación de Pagos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    
                    <!-- Date Inicio -->
                    <div>
                        <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                    </div>

                    <!-- Date Fin -->
                    <div>
                        <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                    </div>

                    <!-- Botón Crear filtro -->
                    <div>
                        <button id="btnCrearFiltro" style="background-color: #6B8ACE; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;">
                            <i class="fas fa-filter"></i> Crear filtro
                        </button>
                    </div>

                    <!-- Botón Agregar (+) -->
                    <div>
                        <button id="btnAgregar" style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #6B8ACE; font-size: 16px;" title="Agregar">
                            <i class="fas fa-plus" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Botón Exportar Excel -->
                    <div>
                        <button id="btnExcel" 
                                style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #6B8ACE;"
                                title="Exportar todo">
                            <i class="fas fa-file-excel" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Botón Seleccionar Columnas -->
                    <div>
                        <button id="btnColumnas" 
                                style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #6B8ACE;"
                                title="Seleccionar columnas">
                            <i class="fas fa-columns" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6B8ACE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 200px;">
                    </div>
                </div>

                <!-- Cuadros de resumen -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Programado</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalProgramado">$1,245,750.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pendientes</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalPendiente">$845,320.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagados</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalPagado">$400,430.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Programaciones</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalProgramaciones">24</div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay programaciones de pago para los filtros seleccionados</p>
                </div>

                <!-- Tabla de Programación de Pagos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaProgramacionPagos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>ID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proveedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Saldo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Est. Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
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
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef;" colspan="5">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumSaldo">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef;" colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;" id="paginacionContainer">
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Primera página"><i class="fas fa-angle-double-left"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Página anterior"><i class="fas fa-angle-left"></i></button>
                    <span style="padding: 5px 10px; background-color: #6B8ACE; color: white; border-radius: 4px;">1</span>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;">2</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;">3</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Página siguiente"><i class="fas fa-angle-right"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Última página"><i class="fas fa-angle-double-right"></i></button>
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-8 de 24 registros</span>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #6B8ACE;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(107, 138, 206, 0.15) !important;
        border-color: #6B8ACE !important;
    }
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #6B8ACE !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }
    
    /* Todas las columnas usan el mismo color #6B8ACE */
    .table th:last-child {
        background-color: #6B8ACE !important;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
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
    
    /* Estilo para los iconos de acción - SOLO ESTO MANTIENE EL AZUL ORIGINAL */
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
    
    .badge-programado {
        background-color: #6B8ACE;
        color: white;
    }
    
    .badge-pagado {
        background-color: #28a745;
        color: white;
    }
    
    .badge-cancelado {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-parcial {
        background-color: #17a2b8;
        color: white;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #6B8ACE;
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
        
        .custom-card {
            min-width: 100% !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Programación de Pagos');
        
        // Datos de ejemplo para Programación de Pagos
        const datosProgramacionPagos = [
            {
                id: 1,
                estatus: 'Programado',
                fecha: '2026-02-01',
                proveedor: 'Transportes del Bajío',
                descripcion: 'Pago de facturas de transporte - Múltiples facturas',
                monto: 125800.00,
                saldo: 45800.00,
                fecha_estimada: '2026-02-15'
            },
            {
                id: 2,
                estatus: 'Pendiente',
                fecha: '2026-02-02',
                proveedor: 'Logística Monterrey',
                descripcion: 'Programación quincenal de pagos',
                monto: 87500.00,
                saldo: 87500.00,
                fecha_estimada: '2026-02-18'
            },
            {
                id: 3,
                estatus: 'Pagado',
                fecha: '2026-02-03',
                proveedor: 'Autotransportes Mexicanos',
                descripcion: 'Pago de servicios de flete',
                monto: 62300.00,
                saldo: 0.00,
                fecha_estimada: '2026-02-10'
            },
            {
                id: 4,
                estatus: 'Programado',
                fecha: '2026-02-04',
                proveedor: 'Ferrocarriles Nacionales',
                descripcion: 'Pago de facturas pendientes',
                monto: 158200.00,
                saldo: 158200.00,
                fecha_estimada: '2026-02-20'
            },
            {
                id: 5,
                estatus: 'Parcial',
                fecha: '2026-02-05',
                proveedor: 'Cervecería del Centro',
                descripcion: 'Pago parcial de servicios',
                monto: 93400.00,
                saldo: 33400.00,
                fecha_estimada: '2026-02-12'
            },
            {
                id: 6,
                estatus: 'Cancelado',
                fecha: '2026-02-06',
                proveedor: 'Papelera del Pacífico',
                descripcion: 'Cancelado por solicitud del proveedor',
                monto: 45600.00,
                saldo: 45600.00,
                fecha_estimada: '2026-02-14'
            },
            {
                id: 7,
                estatus: 'Programado',
                fecha: '2026-02-07',
                proveedor: 'Minería del Norte',
                descripcion: 'Pago de servicios mineros',
                monto: 212500.00,
                saldo: 212500.00,
                fecha_estimada: '2026-02-22'
            },
            {
                id: 8,
                estatus: 'Pagado',
                fecha: '2026-02-08',
                proveedor: 'Comercializadora del Sur',
                descripcion: 'Pago de facturas de materiales',
                monto: 78500.00,
                saldo: 0.00,
                fecha_estimada: '2026-02-05'
            },
            {
                id: 9,
                estatus: 'Pendiente',
                fecha: '2026-02-09',
                proveedor: 'Transportes Unidos',
                descripcion: 'Programación de pagos semanal',
                monto: 112300.00,
                saldo: 112300.00,
                fecha_estimada: '2026-02-19'
            },
            {
                id: 10,
                estatus: 'Programado',
                fecha: '2026-02-10',
                proveedor: 'Distribuidora de Papel',
                descripcion: 'Pago de servicios de distribución',
                monto: 67300.00,
                saldo: 67300.00,
                fecha_estimada: '2026-02-16'
            },
            {
                id: 11,
                estatus: 'Parcial',
                fecha: '2026-02-11',
                proveedor: 'Maquiladora Industrial',
                descripcion: 'Pago parcial de facturas',
                monto: 156700.00,
                saldo: 56700.00,
                fecha_estimada: '2026-02-17'
            },
            {
                id: 12,
                estatus: 'Pagado',
                fecha: '2026-02-12',
                proveedor: 'Cartones del Norte',
                descripcion: 'Pago de servicios de empaque',
                monto: 34200.00,
                saldo: 0.00,
                fecha_estimada: '2026-02-08'
            }
        ];

        // Variables globales
        let datosOriginales = [...datosProgramacionPagos];
        let datosFiltrados = [...datosProgramacionPagos];
        let paginaActual = 1;
        const registrosPorPagina = 10;
        
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
        const totalRegistros = document.getElementById('totalRegistros');
        const sumMonto = document.getElementById('sumMonto');
        const sumSaldo = document.getElementById('sumSaldo');
        const paginacionInfo = document.getElementById('paginacionInfo');
        const paginacionContainer = document.getElementById('paginacionContainer');
        
        // Elementos de cuadros de resumen
        const totalProgramado = document.getElementById('totalProgramado');
        const totalPendiente = document.getElementById('totalPendiente');
        const totalPagado = document.getElementById('totalPagado');
        const totalProgramaciones = document.getElementById('totalProgramaciones');
        
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
            if (estatus === 'Programado') return 'badge-programado';
            if (estatus === 'Pendiente') return 'badge-pendiente';
            if (estatus === 'Pagado') return 'badge-pagado';
            if (estatus === 'Cancelado') return 'badge-cancelado';
            if (estatus === 'Parcial') return 'badge-parcial';
            return 'badge-pendiente';
        }
        
        // Función para actualizar cuadros de resumen
        function actualizarResumen(datos) {
            let totalProgramadoValor = 0;
            let totalPendienteValor = 0;
            let totalPagadoValor = 0;
            
            datos.forEach(item => {
                if (item.estatus === 'Programado' || item.estatus === 'Pendiente' || item.estatus === 'Parcial') {
                    totalProgramadoValor += item.monto;
                }
                
                if (item.estatus === 'Pendiente' || item.estatus === 'Parcial') {
                    totalPendienteValor += item.saldo;
                }
                
                if (item.estatus === 'Pagado') {
                    totalPagadoValor += item.monto;
                }
            });
            
            totalProgramado.textContent = formatCurrency(totalProgramadoValor);
            totalPendiente.textContent = formatCurrency(totalPendienteValor);
            totalPagado.textContent = formatCurrency(totalPagadoValor);
            totalProgramaciones.textContent = datos.length;
        }
        
        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            const termino = buscador.value.toLowerCase().trim();
            
            if (termino === '') {
                datosFiltrados = [...datosOriginales];
            } else {
                datosFiltrados = datosOriginales.filter(item => 
                    item.proveedor?.toLowerCase().includes(termino) ||
                    item.descripcion?.toLowerCase().includes(termino) ||
                    item.estatus?.toLowerCase().includes(termino)
                );
            }
            
            paginaActual = 1;
            actualizarResumen(datosFiltrados);
            aplicarPaginacionYMostrar();
        }
        
        // Función para aplicar paginación
        function aplicarPaginacionYMostrar() {
            const inicio = (paginaActual - 1) * registrosPorPagina;
            const fin = inicio + registrosPorPagina;
            const datosPagina = datosFiltrados.slice(inicio, fin);
            
            mostrarTabla(datosPagina);
            actualizarPaginacion();
        }
        
        // Función para cambiar de página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                aplicarPaginacionYMostrar();
            }
        }
        
        // Función para actualizar los controles de paginación
        function actualizarPaginacion() {
            const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
            const inicio = (paginaActual - 1) * registrosPorPagina + 1;
            const fin = Math.min(paginaActual * registrosPorPagina, datosFiltrados.length);
            
            paginacionInfo.textContent = `Mostrando ${datosFiltrados.length > 0 ? inicio : 0}-${fin} de ${datosFiltrados.length} registros`;
            
            // Actualizar botones de paginación
            while (paginacionContainer.children.length > 7) {
                paginacionContainer.removeChild(paginacionContainer.children[2]);
            }
            
            const spanPagina = paginacionContainer.querySelector('span');
            
            for (let i = 1; i <= Math.min(5, totalPaginas); i++) {
                if (i === 1) {
                    spanPagina.textContent = i;
                    spanPagina.style.backgroundColor = i === paginaActual ? '#6B8ACE' : 'transparent';
                    spanPagina.style.color = i === paginaActual ? 'white' : '#6B8ACE';
                } else {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.style.padding = '5px 10px';
                    btn.style.border = '1px solid #dee2e6';
                    btn.style.backgroundColor = i === paginaActual ? '#6B8ACE' : 'white';
                    btn.style.borderRadius = '4px';
                    btn.style.cursor = 'pointer';
                    btn.style.color = i === paginaActual ? 'white' : '#6B8ACE';
                    btn.addEventListener('click', () => cambiarPagina(i));
                    paginacionContainer.insertBefore(btn, paginacionContainer.children[paginacionContainer.children.length - 2]);
                }
            }
        }
        
        // Función para mostrar la tabla
        function mostrarTabla(datos) {
            if (!tablaBody) return;
            
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                totalRegistros.textContent = '0';
                sumMonto.textContent = formatCurrency(0);
                sumSaldo.textContent = formatCurrency(0);
                
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Calcular totales de la página actual
            let sumaMonto = 0;
            let sumaSaldo = 0;
            
            datos.forEach(item => {
                sumaMonto += item.monto || 0;
                sumaSaldo += item.saldo || 0;
            });
            
            totalRegistros.textContent = datos.length;
            sumMonto.textContent = formatCurrency(sumaMonto);
            sumSaldo.textContent = formatCurrency(sumaSaldo);
            
            // Generar filas
            datos.forEach((item, index) => {
                const row = document.createElement('tr');
                const badgeClass = getBadgeClass(item.estatus);
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${(paginaActual - 1) * registrosPorPagina + index + 1}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <span class="badge ${badgeClass}">${item.estatus}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proveedor}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.descripcion}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.monto)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.saldo)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha_estimada)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.id}"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.id}"></i>
                            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.id}"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.id}"></i>
                            <i class="fas fa-credit-card" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Procesar pago" data-id="${item.id}"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
        }
        
        // Event Listeners
        btnCrearFiltro.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        btnAgregar.addEventListener('click', function() {
            alert('Agregar Programación de Pago - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportar a Excel - Funcionalidad en desarrollo');
        });
        
        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        buscador.addEventListener('input', filtrarPorBusqueda);
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Delegación de eventos para acciones
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                const id = e.target.getAttribute('data-id');
                alert(`Ver detalles de programación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-edit')) {
                const id = e.target.getAttribute('data-id');
                alert(`Editar programación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-trash-alt')) {
                const id = e.target.getAttribute('data-id');
                if (confirm(`¿Está seguro de eliminar la programación ID: ${id}?`)) {
                    alert(`Eliminar programación ID: ${id} - Funcionalidad en desarrollo`);
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar PDF - Programación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-credit-card')) {
                const id = e.target.getAttribute('data-id');
                alert(`Procesar pago - Programación ID: ${id} - Funcionalidad en desarrollo`);
            }
        });
        
        // Paginación
        const btnPrimera = paginacionContainer.querySelector('button[title="Primera página"]');
        const btnAnterior = paginacionContainer.querySelector('button[title="Página anterior"]');
        const btnSiguiente = paginacionContainer.querySelector('button[title="Página siguiente"]');
        const btnUltima = paginacionContainer.querySelector('button[title="Última página"]');
        
        btnPrimera.addEventListener('click', () => cambiarPagina(1));
        btnAnterior.addEventListener('click', () => cambiarPagina(paginaActual - 1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(paginaActual + 1));
        btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(datosFiltrados.length / registrosPorPagina)));
        
        // Cargar datos iniciales
        actualizarResumen(datosOriginales);
        mostrarTabla(datosOriginales.slice(0, registrosPorPagina));
    });
</script>
@endsection