@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Conciliación Bancaria -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #6B8ACE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Conciliación Bancaria
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con filtros -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    
                    <!-- Filtros izquierda -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="cuentaBancaria" style="font-weight: 600; color: #6B8ACE;">Cuenta:</label>
                        <select id="cuentaBancaria" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; min-width: 250px; background-color: white;">
                            <option value="0">Todas las cuentas</option>
                            <option value="1" selected>Principal (1234-5678-9012-3456) - Banamex</option>
                            <option value="2">Secundaria (9876-5432-1098-7654) - BBVA</option>
                            <option value="3">Ahorros (5678-1234-5678-1234) - Santander</option>
                            <option value="4">Nóminas (4321-8765-4321-8765) - HSBC</option>
                        </select>

                        <label for="mesConciliacion" style="font-weight: 600; color: #6B8ACE; margin-left: 10px;">Mes:</label>
                        <select id="mesConciliacion" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 120px; background-color: white;">
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
                            <option value="12" selected>Diciembre</option>
                        </select>

                        <label for="anioConciliacion" style="font-weight: 600; color: #6B8ACE;">Año:</label>
                        <select id="anioConciliacion" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 100px; background-color: white;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>
                    </div>

                    <!-- Botones derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Consultar -->
                        <div>
                            <button id="btnConsultar" style="background-color: #6B8ACE; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;">
                                <i class="fas fa-search"></i> Consultar
                            </button>
                        </div>

                        <!-- Botón Nueva Conciliación -->
                        <div>
                            <button id="btnNuevo" style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #6B8ACE;">
                                <i class="fas fa-plus"></i> Nueva
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #6B8ACE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #6B8ACE;"></i>
                            </button>
                        </div>

                        <!-- Botón Columnas -->
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
                </div>

                <!-- Resumen de Conciliación -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Sistema</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalSistema">$1,245,750.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Banco</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalBanco">$1,245,750.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Conciliado</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalConciliado">$1,245,750.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pendiente</div>
                            <div style="color: #6B8ACE; font-size: 24px; font-weight: bold; line-height: 1.2;" id="totalPendiente">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay conciliaciones para los filtros seleccionados</p>
                </div>

                <!-- Tabla de Conciliaciones -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaConciliaciones" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0; width: 50px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>ID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta</span>
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
                                        <span>Mes</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Año</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total Sistema</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total Banco</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Conciliado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Pendiente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumTotalSistema">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumTotalBanco">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumConciliado">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumPendiente">$0.00</td>
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
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-6 de 12 registros</span>
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
    
    .badge-conciliado {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-diferencia {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-proceso {
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
        div[style*="justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"], select {
            width: 100% !important;
            min-width: 100% !important;
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
        console.log('DOM completamente cargado - Conciliación Bancaria');
        
        // Datos ficticios para Conciliación Bancaria
        const datosConciliaciones = [
            {
                id: 1,
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                fecha: '2026-12-01',
                mes: 'Diciembre',
                mes_num: 12,
                anio: 2026,
                total_sistema: 245750.00,
                total_banco: 245750.00,
                total_conciliado: 245750.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 2,
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                fecha: '2026-11-01',
                mes: 'Noviembre',
                mes_num: 11,
                anio: 2026,
                total_sistema: 238500.00,
                total_banco: 238500.00,
                total_conciliado: 238500.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 3,
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                fecha: '2026-12-01',
                mes: 'Diciembre',
                mes_num: 12,
                anio: 2026,
                total_sistema: 187250.00,
                total_banco: 187250.00,
                total_conciliado: 187250.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 4,
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                fecha: '2026-11-01',
                mes: 'Noviembre',
                mes_num: 11,
                anio: 2026,
                total_sistema: 175800.00,
                total_banco: 175800.00,
                total_conciliado: 175800.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 5,
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                fecha: '2026-12-01',
                mes: 'Diciembre',
                mes_num: 12,
                anio: 2026,
                total_sistema: 125400.00,
                total_banco: 125400.00,
                total_conciliado: 125400.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 6,
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                fecha: '2026-11-01',
                mes: 'Noviembre',
                mes_num: 11,
                anio: 2026,
                total_sistema: 118900.00,
                total_banco: 118900.00,
                total_conciliado: 118900.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 7,
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                fecha: '2026-12-01',
                mes: 'Diciembre',
                mes_num: 12,
                anio: 2026,
                total_sistema: 312600.00,
                total_banco: 312600.00,
                total_conciliado: 312600.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 8,
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                fecha: '2026-11-01',
                mes: 'Noviembre',
                mes_num: 11,
                anio: 2026,
                total_sistema: 298400.00,
                total_banco: 298400.00,
                total_conciliado: 298400.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 9,
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                fecha: '2026-10-01',
                mes: 'Octubre',
                mes_num: 10,
                anio: 2026,
                total_sistema: 232100.00,
                total_banco: 232100.00,
                total_conciliado: 232100.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 10,
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                fecha: '2026-10-01',
                mes: 'Octubre',
                mes_num: 10,
                anio: 2026,
                total_sistema: 168500.00,
                total_banco: 168500.00,
                total_conciliado: 168500.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 11,
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                fecha: '2026-10-01',
                mes: 'Octubre',
                mes_num: 10,
                anio: 2026,
                total_sistema: 112300.00,
                total_banco: 112300.00,
                total_conciliado: 112300.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            },
            {
                id: 12,
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                fecha: '2026-10-01',
                mes: 'Octubre',
                mes_num: 10,
                anio: 2026,
                total_sistema: 285600.00,
                total_banco: 285600.00,
                total_conciliado: 285600.00,
                total_pendiente: 0.00,
                estatus: 'Conciliado'
            }
        ];
        
        // Variables globales
        let movimientosOriginales = [...datosConciliaciones];
        let movimientosFiltrados = [...datosConciliaciones];
        let paginaActual = 1;
        const registrosPorPagina = 10;
        
        // Elementos del DOM
        const selectCuenta = document.getElementById('cuentaBancaria');
        const selectMes = document.getElementById('mesConciliacion');
        const selectAnio = document.getElementById('anioConciliacion');
        const btnConsultar = document.getElementById('btnConsultar');
        const btnNuevo = document.getElementById('btnNuevo');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const buscador = document.getElementById('buscador');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const totalRegistros = document.getElementById('totalRegistros');
        const sumTotalSistema = document.getElementById('sumTotalSistema');
        const sumTotalBanco = document.getElementById('sumTotalBanco');
        const sumConciliado = document.getElementById('sumConciliado');
        const sumPendiente = document.getElementById('sumPendiente');
        const totalSistema = document.getElementById('totalSistema');
        const totalBanco = document.getElementById('totalBanco');
        const totalConciliado = document.getElementById('totalConciliado');
        const totalPendiente = document.getElementById('totalPendiente');
        const paginacionInfo = document.getElementById('paginacionInfo');
        const paginacionContainer = document.getElementById('paginacionContainer');
        
        // Función para formatear números como moneda
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
            if (estatus === 'Conciliado') return 'badge-conciliado';
            if (estatus === 'Pendiente') return 'badge-pendiente';
            if (estatus === 'Diferencia') return 'badge-diferencia';
            if (estatus === 'En Proceso') return 'badge-proceso';
            return 'badge-pendiente';
        }
        
        // Función para filtrar datos
        function filtrarDatos() {
            const cuentaId = parseInt(selectCuenta.value);
            const mes = parseInt(selectMes.value);
            const anio = parseInt(selectAnio.value);
            const termino = buscador.value.toLowerCase().trim();
            
            // Aplicar filtros
            let datosFiltrados = datosConciliaciones.filter(item => {
                // Filtro por cuenta
                if (cuentaId !== 0 && item.cuenta_id !== cuentaId) return false;
                
                // Filtro por mes
                if (item.mes_num !== mes) return false;
                
                // Filtro por año
                if (item.anio !== anio) return false;
                
                return true;
            });
            
            // Aplicar búsqueda si hay término
            if (termino !== '') {
                datosFiltrados = datosFiltrados.filter(item => 
                    item.cuenta_nombre?.toLowerCase().includes(termino) ||
                    item.mes?.toLowerCase().includes(termino) ||
                    item.estatus?.toLowerCase().includes(termino)
                );
            }
            
            movimientosOriginales = [...datosFiltrados];
            movimientosFiltrados = [...datosFiltrados];
            paginaActual = 1;
            
            // Actualizar totales
            actualizarTotalesResumen(datosFiltrados);
            aplicarPaginacionYMostrar();
        }
        
        // Función para actualizar los totales del resumen
        function actualizarTotalesResumen(datos) {
            let sumaSistema = 0;
            let sumaBanco = 0;
            let sumaConciliado = 0;
            let sumaPendiente = 0;
            
            datos.forEach(item => {
                sumaSistema += item.total_sistema || 0;
                sumaBanco += item.total_banco || 0;
                sumaConciliado += item.total_conciliado || 0;
                sumaPendiente += item.total_pendiente || 0;
            });
            
            totalSistema.textContent = formatCurrency(sumaSistema);
            totalBanco.textContent = formatCurrency(sumaBanco);
            totalConciliado.textContent = formatCurrency(sumaConciliado);
            totalPendiente.textContent = formatCurrency(sumaPendiente);
        }
        
        // Función para aplicar paginación
        function aplicarPaginacionYMostrar() {
            const inicio = (paginaActual - 1) * registrosPorPagina;
            const fin = inicio + registrosPorPagina;
            const movimientosPagina = movimientosFiltrados.slice(inicio, fin);
            
            mostrarTabla(movimientosPagina);
            actualizarPaginacion();
        }
        
        // Función para cambiar de página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(movimientosFiltrados.length / registrosPorPagina);
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                aplicarPaginacionYMostrar();
            }
        }
        
        // Función para actualizar los controles de paginación
        function actualizarPaginacion() {
            const totalPaginas = Math.ceil(movimientosFiltrados.length / registrosPorPagina);
            const inicio = (paginaActual - 1) * registrosPorPagina + 1;
            const fin = Math.min(paginaActual * registrosPorPagina, movimientosFiltrados.length);
            
            paginacionInfo.textContent = `Mostrando ${movimientosFiltrados.length > 0 ? inicio : 0}-${fin} de ${movimientosFiltrados.length} registros`;
            
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
        function mostrarTabla(movimientos) {
            if (!tablaBody) return;
            
            tablaBody.innerHTML = '';
            
            if (movimientos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                totalRegistros.textContent = '0';
                sumTotalSistema.textContent = formatCurrency(0);
                sumTotalBanco.textContent = formatCurrency(0);
                sumConciliado.textContent = formatCurrency(0);
                sumPendiente.textContent = formatCurrency(0);
                
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Calcular totales de la página actual
            let sumaSistema = 0;
            let sumaBanco = 0;
            let sumaConciliado = 0;
            let sumaPendiente = 0;
            
            movimientos.forEach(item => {
                sumaSistema += item.total_sistema || 0;
                sumaBanco += item.total_banco || 0;
                sumaConciliado += item.total_conciliado || 0;
                sumaPendiente += item.total_pendiente || 0;
            });
            
            totalRegistros.textContent = movimientos.length;
            sumTotalSistema.textContent = formatCurrency(sumaSistema);
            sumTotalBanco.textContent = formatCurrency(sumaBanco);
            sumConciliado.textContent = formatCurrency(sumaConciliado);
            sumPendiente.textContent = formatCurrency(sumaPendiente);
            
            // Generar filas
            movimientos.forEach((item, index) => {
                const row = document.createElement('tr');
                const badgeClass = getBadgeClass(item.estatus);
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${(paginaActual - 1) * registrosPorPagina + index + 1}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">
                        <span style="background-color: #6B8ACE; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">${item.cuenta_nombre}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${item.mes}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${item.anio}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.total_sistema)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.total_banco)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.total_conciliado)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.total_pendiente)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <span class="badge ${badgeClass}">${item.estatus}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.id}"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.id}"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Descargar PDF" data-id="${item.id}"></i>
                            <i class="fas fa-check-circle" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Conciliar" data-id="${item.id}"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
        }
        
        // Event Listeners
        btnConsultar.addEventListener('click', filtrarDatos);
        
        btnNuevo.addEventListener('click', function() {
            alert('Nueva Conciliación - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportar a Excel - Funcionalidad en desarrollo');
        });
        
        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        buscador.addEventListener('input', filtrarDatos);
        
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
                alert(`Ver detalles de conciliación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-edit')) {
                const id = e.target.getAttribute('data-id');
                alert(`Editar conciliación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar PDF - Conciliación ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-check-circle')) {
                const id = e.target.getAttribute('data-id');
                alert(`Procesar conciliación ID: ${id} - Funcionalidad en desarrollo`);
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
        btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(movimientosFiltrados.length / registrosPorPagina)));
        
        // Cargar datos iniciales
        filtrarDatos();
    });
</script>
@endsection