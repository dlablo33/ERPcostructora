@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Movimientos Bancarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Movimientos Bancarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Fila con selector de bancos, fechas, buscar y botón Excel verde -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selector de Cuentas Bancarias -->
                    <div style="display: flex; align-items: center; gap: 10px; flex: 2; min-width: 300px;">
                        <div style="font-weight: 600; color: #083CAE; white-space: nowrap;">Filtrar por Banco:</div>
                        <select id="selectCuenta" style="padding: 8px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 100%; background-color: white;">
                            <option value="0">Todas las cuentas</option>
                            <option value="1">BBVA - 1234 5678 9012 3456</option>
                            <option value="2">Santander - 5678 9012 3456 7890</option>
                            <option value="3">Banamex - 9012 3456 7890 1234</option>
                            <option value="4">HSBC - 3456 7890 1234 5678</option>
                        </select>
                    </div>

                    <!-- Fechas -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <span style="color: #083CAE;">Desde:</span>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div style="display: flex; align-items: center; gap: 5px;">
                            <span style="color: #083CAE;">Hasta:</span>
                            <input type="date" id="fechaFin" value="2026-01-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        
                        <!-- Botón para aplicar filtros -->
                        <button id="btnFiltrar" style="background-color: #2378e1; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: white; font-weight: 500;">
                            <i class="fas fa-filter"></i>
                            <span>Buscar</span>
                        </button>
                    </div>

                    <!-- Buscador y botón Excel verde -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" id="buscador" placeholder="Buscar movimiento..." style="padding: 8px 8px 8px 35px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>

                        <!-- Botón Exportar Excel (verde) -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: #28a745; border: 1px solid #28a745; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: white; font-weight: 500;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: white;"></i>
                                <span>Excel</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 4 CUADROS DE RESUMEN CENTRADOS (Saldo Inicial, Cargos, Abonos, Saldo Final) -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Saldo Inicial -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Inicial</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="saldoInicial">$115,695.54</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Cargos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cargos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalCargos">$24,640.00</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Abonos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Abonos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAbonos">$6,700.00</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Saldo Final -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Final</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="saldoFinal">$133,635.54</div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-exchange-alt" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Movimientos Bancarios -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaMovimientos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Referencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ref. Bancaria</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Origen</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cargos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Abonos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Saldo Final</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Detalles</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumCargos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumAbonos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSaldoFinal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación simple -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;">
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #2378e1;" title="Primera página" id="btnPrimera">
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #2378e1;" title="Página anterior" id="btnAnterior">
                        <i class="fas fa-angle-left"></i>
                    </button>
                    <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;" id="paginaActual">1</span>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #2378e1;" class="pagina-btn" data-pagina="2">2</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #2378e1;" title="Página siguiente" id="btnSiguiente">
                        <i class="fas fa-angle-right"></i>
                    </button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #2378e1;" title="Última página" id="btnUltima">
                        <i class="fas fa-angle-double-right"></i>
                    </button>
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-10 de 20 registros</span>
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
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
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
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Movimientos Bancarios');
        
        // Variables
        let datosOriginales = [];
        let datosFiltrados = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        
        // Datos de ejemplo para Movimientos Bancarios (20 filas)
        const datosMovimientos = [
            // BBVA - Enero 2026
            {
                fecha: '2026-01-02',
                folio: 'MOV-001',
                referencia: 'REF-001',
                ref_bancaria: 'TRX-001',
                origen: 'Depósito',
                descripcion: 'Pago factura F-001',
                cargos: 0.00,
                abonos: 15000.00,
                saldo_final: 60750.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-01-05',
                folio: 'MOV-002',
                referencia: 'REF-002',
                ref_bancaria: 'CHQ-001',
                origen: 'Cheque',
                descripcion: 'Pago a proveedor',
                cargos: 8750.00,
                abonos: 0.00,
                saldo_final: 52000.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-01-08',
                folio: 'MOV-003',
                referencia: 'REF-003',
                ref_bancaria: 'TRX-002',
                origen: 'Transferencia',
                descripcion: 'Pago factura F-002',
                cargos: 0.00,
                abonos: 8750.00,
                saldo_final: 60750.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-01-12',
                folio: 'MOV-004',
                referencia: 'REF-004',
                ref_bancaria: 'TRX-003',
                origen: 'Depósito',
                descripcion: 'Pago factura F-003',
                cargos: 0.00,
                abonos: 5600.00,
                saldo_final: 66350.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-01-15',
                folio: 'MOV-005',
                referencia: 'REF-005',
                ref_bancaria: 'CHQ-002',
                origen: 'Cheque',
                descripcion: 'Pago de nómina',
                cargos: 25000.00,
                abonos: 0.00,
                saldo_final: 41350.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            // Santander - Enero 2026
            {
                fecha: '2026-01-03',
                folio: 'MOV-006',
                referencia: 'REF-006',
                ref_bancaria: 'TRX-004',
                origen: 'Depósito',
                descripcion: 'Pago factura F-004',
                cargos: 0.00,
                abonos: 22400.00,
                saldo_final: 22400.00,
                banco_id: 2,
                banco: 'Santander'
            },
            {
                fecha: '2026-01-07',
                folio: 'MOV-007',
                referencia: 'REF-007',
                ref_bancaria: 'CHQ-003',
                origen: 'Cheque',
                descripcion: 'Pago renta',
                cargos: 15000.00,
                abonos: 0.00,
                saldo_final: 7400.00,
                banco_id: 2,
                banco: 'Santander'
            },
            {
                fecha: '2026-01-14',
                folio: 'MOV-008',
                referencia: 'REF-008',
                ref_bancaria: 'TRX-005',
                origen: 'Transferencia',
                descripcion: 'Pago factura F-005',
                cargos: 0.00,
                abonos: 8900.00,
                saldo_final: 16300.00,
                banco_id: 2,
                banco: 'Santander'
            },
            {
                fecha: '2026-01-21',
                folio: 'MOV-009',
                referencia: 'REF-009',
                ref_bancaria: 'COM-002',
                origen: 'Comisión',
                descripcion: 'Comisión bancaria',
                cargos: 450.00,
                abonos: 0.00,
                saldo_final: 15850.00,
                banco_id: 2,
                banco: 'Santander'
            },
            // Banamex - Enero 2026
            {
                fecha: '2026-01-04',
                folio: 'MOV-010',
                referencia: 'REF-010',
                ref_bancaria: 'TRX-006',
                origen: 'Depósito',
                descripcion: 'Pago factura F-006',
                cargos: 0.00,
                abonos: 32000.00,
                saldo_final: 32000.00,
                banco_id: 3,
                banco: 'Banamex'
            },
            {
                fecha: '2026-01-11',
                folio: 'MOV-011',
                referencia: 'REF-011',
                ref_bancaria: 'CHQ-004',
                origen: 'Cheque',
                descripcion: 'Pago servicios',
                cargos: 8500.00,
                abonos: 0.00,
                saldo_final: 23500.00,
                banco_id: 3,
                banco: 'Banamex'
            },
            {
                fecha: '2026-01-18',
                folio: 'MOV-012',
                referencia: 'REF-012',
                ref_bancaria: 'TRX-007',
                origen: 'Transferencia',
                descripcion: 'Pago factura F-007',
                cargos: 0.00,
                abonos: 12500.00,
                saldo_final: 36000.00,
                banco_id: 3,
                banco: 'Banamex'
            },
            {
                fecha: '2026-01-25',
                folio: 'MOV-013',
                referencia: 'REF-013',
                ref_bancaria: 'COM-003',
                origen: 'Comisión',
                descripcion: 'Comisión bancaria',
                cargos: 380.00,
                abonos: 0.00,
                saldo_final: 35620.00,
                banco_id: 3,
                banco: 'Banamex'
            },
            // HSBC - Enero 2026
            {
                fecha: '2026-01-06',
                folio: 'MOV-014',
                referencia: 'REF-014',
                ref_bancaria: 'TRX-008',
                origen: 'Depósito',
                descripcion: 'Pago factura F-008',
                cargos: 0.00,
                abonos: 18900.00,
                saldo_final: 18900.00,
                banco_id: 4,
                banco: 'HSBC'
            },
            {
                fecha: '2026-01-13',
                folio: 'MOV-015',
                referencia: 'REF-015',
                ref_bancaria: 'CHQ-005',
                origen: 'Cheque',
                descripcion: 'Pago proveedor',
                cargos: 6700.00,
                abonos: 0.00,
                saldo_final: 12200.00,
                banco_id: 4,
                banco: 'HSBC'
            },
            {
                fecha: '2026-01-20',
                folio: 'MOV-016',
                referencia: 'REF-016',
                ref_bancaria: 'TRX-009',
                origen: 'Transferencia',
                descripcion: 'Pago factura F-009',
                cargos: 0.00,
                abonos: 15200.00,
                saldo_final: 27400.00,
                banco_id: 4,
                banco: 'HSBC'
            },
            {
                fecha: '2026-01-27',
                folio: 'MOV-017',
                referencia: 'REF-017',
                ref_bancaria: 'COM-004',
                origen: 'Comisión',
                descripcion: 'Comisión bancaria',
                cargos: 290.00,
                abonos: 0.00,
                saldo_final: 27110.00,
                banco_id: 4,
                banco: 'HSBC'
            },
            // Más movimientos para BBVA - Febrero 2026
            {
                fecha: '2026-02-03',
                folio: 'MOV-018',
                referencia: 'REF-018',
                ref_bancaria: 'TRX-010',
                origen: 'Depósito',
                descripcion: 'Pago factura F-010',
                cargos: 0.00,
                abonos: 22300.00,
                saldo_final: 22300.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-02-10',
                folio: 'MOV-019',
                referencia: 'REF-019',
                ref_bancaria: 'CHQ-006',
                origen: 'Cheque',
                descripcion: 'Pago servicios',
                cargos: 9800.00,
                abonos: 0.00,
                saldo_final: 12500.00,
                banco_id: 1,
                banco: 'BBVA'
            },
            {
                fecha: '2026-02-17',
                folio: 'MOV-020',
                referencia: 'REF-020',
                ref_bancaria: 'TRX-011',
                origen: 'Transferencia',
                descripcion: 'Pago factura F-011',
                cargos: 0.00,
                abonos: 15600.00,
                saldo_final: 28100.00,
                banco_id: 1,
                banco: 'BBVA'
            }
        ];
        
        datosOriginales = [...datosMovimientos];
        datosFiltrados = [...datosOriginales];
        
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
        
        // Función para actualizar los cuadros de resumen
        function actualizarResumen(datos) {
            // Calcular saldo inicial (primer movimiento del período)
            let saldoInicial = 45678.90; // Valor base
            
            // Calcular total de cargos y abonos
            let totalCargos = 0;
            let totalAbonos = 0;
            
            datos.forEach(item => {
                totalCargos += item.cargos || 0;
                totalAbonos += item.abonos || 0;
            });
            
            // Calcular saldo final (saldo inicial + abonos - cargos)
            let saldoFinal = saldoInicial + totalAbonos - totalCargos;
            
            // Si hay datos, podemos usar el último saldo_final
            if (datos.length > 0) {
                saldoFinal = datos[datos.length - 1].saldo_final;
            }
            
            document.getElementById('saldoInicial').textContent = formatCurrency(saldoInicial);
            document.getElementById('totalCargos').textContent = formatCurrency(totalCargos);
            document.getElementById('totalAbonos').textContent = formatCurrency(totalAbonos);
            document.getElementById('saldoFinal').textContent = formatCurrency(saldoFinal);
        }
        
        // Función para calcular totales de la tabla
        function calcularTotales(datos) {
            let totalCargos = 0;
            let totalAbonos = 0;
            let totalSaldoFinal = 0;
            
            datos.forEach(item => {
                totalCargos += item.cargos || 0;
                totalAbonos += item.abonos || 0;
            });
            
            // El saldo final total es el del último movimiento
            if (datos.length > 0) {
                totalSaldoFinal = datos[datos.length - 1].saldo_final;
            }
            
            document.getElementById('sumCargos').textContent = formatCurrency(totalCargos);
            document.getElementById('sumAbonos').textContent = formatCurrency(totalAbonos);
            document.getElementById('sumSaldoFinal').textContent = formatCurrency(totalSaldoFinal);
        }
        
        // Función para aplicar filtros
        function aplicarFiltros() {
            const bancoId = document.getElementById('selectCuenta').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            const busqueda = document.getElementById('buscador').value.toLowerCase();
            
            datosFiltrados = datosOriginales.filter(item => {
                // Filtro por banco
                if (bancoId !== '0' && item.banco_id !== parseInt(bancoId)) {
                    return false;
                }
                
                // Filtro por fecha
                if (fechaInicio && item.fecha < fechaInicio) {
                    return false;
                }
                if (fechaFin && item.fecha > fechaFin) {
                    return false;
                }
                
                // Filtro por búsqueda
                if (busqueda) {
                    return item.folio?.toLowerCase().includes(busqueda) ||
                           item.referencia?.toLowerCase().includes(busqueda) ||
                           item.origen?.toLowerCase().includes(busqueda) ||
                           item.descripcion?.toLowerCase().includes(busqueda) ||
                           item.banco?.toLowerCase().includes(busqueda);
                }
                
                return true;
            });
            
            currentPage = 1;
            cargarTabla(datosFiltrados);
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
                    btn.dataset.pagina = pagina;
                } else {
                    btn.style.display = 'none';
                }
            });
            
            // Actualizar texto de paginación
            const start = total > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
            const end = Math.min(currentPage * rowsPerPage, total);
            document.getElementById('paginacionInfo').textContent = `Mostrando ${start}-${end} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            
            if (!tablaBody) return;
            
            // Actualizar cuadros de resumen
            actualizarResumen(datos);
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumCargos').textContent = '$0.00';
                document.getElementById('sumAbonos').textContent = '$0.00';
                document.getElementById('sumSaldoFinal').textContent = '$0.00';
                
                document.getElementById('paginacionInfo').textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Mostrar todos los items con paginación
            const pageData = getCurrentPageData(datos);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.referencia || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.ref_bancaria || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.origen || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.cargos ? formatCurrency(item.cargos) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.abonos ? formatCurrency(item.abonos) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.saldo_final ? formatCurrency(item.saldo_final) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-folio="${item.folio}"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-folio="${item.folio}"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            // Mostrar pie de tabla con totales
            calcularTotales(datos);
            
            actualizarPaginacion(datos.length);
        }
        
        // Cargar datos iniciales
        cargarTabla(datosMovimientos);
        
        // Event Listeners
        document.getElementById('btnFiltrar')?.addEventListener('click', function() {
            aplicarFiltros();
        });
        
        document.getElementById('selectCuenta')?.addEventListener('change', function() {
            // Auto-aplicar filtros al cambiar banco
            aplicarFiltros();
        });
        
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            // Auto-aplicar filtros al cambiar fecha
            aplicarFiltros();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            // Auto-aplicar filtros al cambiar fecha
            aplicarFiltros();
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaMovimientos', 'MovimientosBancarios');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            aplicarFiltros();
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosFiltrados);
            });
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosFiltrados);
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosFiltrados);
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosFiltrados.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosFiltrados);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosFiltrados.length / rowsPerPage);
            currentPage = totalPages;
            cargarTabla(datosFiltrados);
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
                const folio = e.target.dataset.folio;
                alert(`Ver detalles del movimiento ${folio}`);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const folio = e.target.dataset.folio;
                alert(`Descargar PDF del movimiento ${folio}`);
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