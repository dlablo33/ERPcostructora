@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estados de Cuenta Bancarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #6B8ACE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Estados de Cuenta Bancarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con selector de cuenta y fechas -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    
                    <!-- Selector de Cuenta Bancaria (lado izquierdo) -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="cuentaBancaria" style="font-weight: 600; color: #6B8ACE;">Cuenta Bancaria:</label>
                        <select id="cuentaBancaria" style="padding: 8px 12px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; min-width: 300px; background-color: white;">
                            <option value="0" selected>Todas las cuentas</option>
                            <option value="1">Principal (1234-5678-9012-3456) - Banamex</option>
                            <option value="2">Secundaria (9876-5432-1098-7654) - BBVA</option>
                            <option value="3">Ahorros (5678-1234-5678-1234) - Santander</option>
                            <option value="4">Nóminas (4321-8765-4321-8765) - HSBC</option>
                        </select>
                    </div>

                    <!-- Filtros de fecha y botones (lado derecho) -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-01-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Consultar -->
                        <div>
                            <button id="btnConsultar" style="background-color: #6B8ACE; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;">
                                <i class="fas fa-search"></i> Consultar
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
                            <input type="text" id="buscador" placeholder="Buscar en movimientos..." style="padding: 8px 8px 8px 35px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 220px;">
                        </div>
                    </div>
                </div>

                <!-- CUADROS DE SALDOS (mismo estilo que los recuadros de estadísticas) -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Saldo Inicial -->
                    <div style="flex: 0 1 calc(50% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Inicial</div>
                            <div style="color: #6B8ACE; font-size: 28px; font-weight: bold; line-height: 1.2;" id="saldoInicial">$408,250.00</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Saldo Final -->
                    <div style="flex: 0 1 calc(50% - 15px); min-width: 200px;">
                        <div class="custom-card" style="border: 2px solid #6B8ACE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Saldo Final</div>
                            <div style="color: #6B8ACE; font-size: 28px; font-weight: bold; line-height: 1.2;" id="saldoFinal">$529,250.00</div>
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay movimientos para el período seleccionado</p>
                </div>

                <!-- Tabla de Estados de Cuenta -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaEstadoCuenta" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0; width: 50px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>ID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0; width: 80px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
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
                                        <span>Tipo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Referencia</span>
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
                                        <span>Depósitos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Retiros</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Saldo</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef;" colspan="7">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="totalDepositos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="totalRetiros">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="totalSaldo">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef;" colspan="1"></td>
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
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-10 de 25 registros</span>
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
    
    /* Estilo para badges de estatus o tipo */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-deposito {
        background-color: #28a745;
        color: white;
    }
    
    .badge-retiro {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-traspaso {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-transferencia {
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
        console.log('DOM completamente cargado - Estados de Cuenta Bancarios');
        
        // Datos ficticios completos para Estados de Cuenta Bancarios con cuenta asignada
        const datosEstadoCuenta = [
            {
                id: 1,
                fecha: '2026-01-02',
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                tipo: 'Depósito',
                folio: 'DEP-001',
                referencia: 'REF-001',
                descripcion: 'Pago de factura FAC-001 - Cliente: Maquiladora Industrial',
                depositos: 25000.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1001
            },
            {
                id: 2,
                fecha: '2026-01-03',
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                tipo: 'Retiro',
                folio: 'RET-001',
                referencia: 'REF-002',
                descripcion: 'Pago a proveedor Transportes del Bajío',
                depositos: 0,
                retiros: 8500.00,
                saldo: 0,
                origen_id: 4,
                origen_folio: 2001
            },
            {
                id: 3,
                fecha: '2026-01-05',
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                tipo: 'Transferencia',
                folio: 'TRAS-001',
                referencia: 'REF-003',
                descripcion: 'Transferencia a cuenta secundaria',
                depositos: 0,
                retiros: 15000.00,
                saldo: 0,
                origen_id: 2,
                origen_folio: 3001
            },
            {
                id: 4,
                fecha: '2026-01-07',
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                tipo: 'Depósito',
                folio: 'DEP-002',
                referencia: 'REF-004',
                descripcion: 'Pago de factura FAC-002 - Cliente: Cartones del Norte',
                depositos: 18750.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1002
            },
            {
                id: 5,
                fecha: '2026-01-08',
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                tipo: 'Traspaso',
                folio: 'TRASP-001',
                referencia: 'REF-005',
                descripcion: 'Traspaso entre cuentas propias',
                depositos: 0,
                retiros: 12000.00,
                saldo: 0,
                origen_id: 2,
                origen_folio: 4001
            },
            {
                id: 6,
                fecha: '2026-01-10',
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                tipo: 'Depósito',
                folio: 'DEP-003',
                referencia: 'REF-006',
                descripcion: 'Pago de factura FAC-003 - Cliente: Logística Monterrey',
                depositos: 32200.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1003
            },
            {
                id: 7,
                fecha: '2026-01-12',
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                tipo: 'Retiro',
                folio: 'RET-002',
                referencia: 'REF-007',
                descripcion: 'Pago de nómina quincenal',
                depositos: 0,
                retiros: 45000.00,
                saldo: 0,
                origen_id: 4,
                origen_folio: 2002
            },
            {
                id: 8,
                fecha: '2026-01-15',
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                tipo: 'Depósito',
                folio: 'DEP-004',
                referencia: 'REF-008',
                descripcion: 'Pago de factura FAC-004 - Cliente: Comercializadora del Sur',
                depositos: 15600.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1004
            },
            {
                id: 9,
                fecha: '2026-01-16',
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                tipo: 'Transferencia',
                folio: 'TRAS-002',
                referencia: 'REF-009',
                descripcion: 'Transferencia a proveedor Papelera del Pacífico',
                depositos: 0,
                retiros: 22300.00,
                saldo: 0,
                origen_id: 4,
                origen_folio: 3002
            },
            {
                id: 10,
                fecha: '2026-01-18',
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                tipo: 'Depósito',
                folio: 'DEP-005',
                referencia: 'REF-010',
                descripcion: 'Pago de factura FAC-005 - Cliente: Ferrocarriles Nacionales',
                depositos: 42500.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1005
            },
            {
                id: 11,
                fecha: '2026-01-20',
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                tipo: 'Retiro',
                folio: 'RET-003',
                referencia: 'REF-011',
                descripcion: 'Pago de servicios (luz, agua, internet)',
                depositos: 0,
                retiros: 12500.00,
                saldo: 0,
                origen_id: 4,
                origen_folio: 2003
            },
            {
                id: 12,
                fecha: '2026-01-22',
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                tipo: 'Traspaso',
                folio: 'TRASP-002',
                referencia: 'REF-012',
                descripcion: 'Traspaso a cuenta de ahorros',
                depositos: 0,
                retiros: 30000.00,
                saldo: 0,
                origen_id: 2,
                origen_folio: 4002
            },
            {
                id: 13,
                fecha: '2026-01-25',
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                tipo: 'Depósito',
                folio: 'DEP-006',
                referencia: 'REF-013',
                descripcion: 'Pago de factura FAC-006 - Cliente: Cervecería del Centro',
                depositos: 28900.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1006
            },
            {
                id: 14,
                fecha: '2026-01-27',
                cuenta_id: 4,
                cuenta_nombre: 'Nóminas',
                tipo: 'Retiro',
                folio: 'RET-004',
                referencia: 'REF-014',
                descripcion: 'Pago de impuestos (IVA, ISR)',
                depositos: 0,
                retiros: 18500.00,
                saldo: 0,
                origen_id: 4,
                origen_folio: 2004
            },
            {
                id: 15,
                fecha: '2026-01-29',
                cuenta_id: 1,
                cuenta_nombre: 'Principal',
                tipo: 'Depósito',
                folio: 'DEP-007',
                referencia: 'REF-015',
                descripcion: 'Pago de factura FAC-007 - Cliente: Autotransportes Mexicanos',
                depositos: 31200.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1007
            },
            {
                id: 16,
                fecha: '2026-01-30',
                cuenta_id: 3,
                cuenta_nombre: 'Ahorros',
                tipo: 'Transferencia',
                folio: 'TRAS-003',
                referencia: 'REF-016',
                descripcion: 'Transferencia a cuenta de nóminas',
                depositos: 0,
                retiros: 25000.00,
                saldo: 0,
                origen_id: 2,
                origen_folio: 3003
            },
            {
                id: 17,
                fecha: '2026-01-31',
                cuenta_id: 2,
                cuenta_nombre: 'Secundaria',
                tipo: 'Depósito',
                folio: 'DEP-008',
                referencia: 'REF-017',
                descripcion: 'Pago de factura FAC-008 - Cliente: Minería del Norte',
                depositos: 35750.00,
                retiros: 0,
                saldo: 0,
                origen_id: 3,
                origen_folio: 1008
            }
        ];
        
        // Saldo inicial por cuenta (ficticio)
        const saldosIniciales = {
            0: 408250.00, // Todas las cuentas (suma de todas)
            1: 125750.00, // Principal
            2: 87500.00,  // Secundaria
            3: 45000.00,  // Ahorros
            4: 150000.00  // Nóminas
        };
        
        // Variables globales
        let movimientosOriginales = [...datosEstadoCuenta];
        let movimientosFiltrados = [...datosEstadoCuenta];
        let saldoInicialValor = 408250.00;
        let paginaActual = 1;
        const registrosPorPagina = 10;
        
        // Elementos del DOM
        const selectCuenta = document.getElementById('cuentaBancaria');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnConsultar = document.getElementById('btnConsultar');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const buscador = document.getElementById('buscador');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const totalRegistros = document.getElementById('totalRegistros');
        const totalDepositos = document.getElementById('totalDepositos');
        const totalRetiros = document.getElementById('totalRetiros');
        const totalSaldo = document.getElementById('totalSaldo');
        const saldoInicialSpan = document.getElementById('saldoInicial');
        const saldoFinalSpan = document.getElementById('saldoFinal');
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
        
        // Función para determinar la clase del badge según el tipo
        function getBadgeClass(tipo) {
            tipo = tipo?.toLowerCase() || '';
            if (tipo.includes('depósito') || tipo.includes('deposito')) return 'badge-deposito';
            if (tipo.includes('retiro')) return 'badge-retiro';
            if (tipo.includes('traspaso')) return 'badge-traspaso';
            if (tipo.includes('transferencia')) return 'badge-transferencia';
            return 'badge-deposito';
        }
        
        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            const termino = buscador.value.toLowerCase().trim();
            
            if (termino === '') {
                movimientosFiltrados = [...movimientosOriginales];
            } else {
                movimientosFiltrados = movimientosOriginales.filter(item => 
                    item.tipo?.toLowerCase().includes(termino) ||
                    item.folio?.toLowerCase().includes(termino) ||
                    item.referencia?.toLowerCase().includes(termino) ||
                    item.descripcion?.toLowerCase().includes(termino) ||
                    item.fecha?.includes(termino) ||
                    item.cuenta_nombre?.toLowerCase().includes(termino)
                );
            }
            
            paginaActual = 1;
            aplicarPaginacionYMostrar();
        }
        
        // Función para filtrar por fechas
        function filtrarPorFechas() {
            const inicio = new Date(fechaInicio.value);
            const fin = new Date(fechaFin.value);
            
            if (!inicio || !fin) return;
            
            movimientosFiltrados = movimientosOriginales.filter(item => {
                const fechaItem = new Date(item.fecha);
                return fechaItem >= inicio && fechaItem <= fin;
            });
            
            paginaActual = 1;
            aplicarPaginacionYMostrar();
        }
        
        // Función para cambiar de cuenta
        function cambiarCuenta() {
            const cuentaId = parseInt(selectCuenta.value);
            
            if (cuentaId === 0) {
                // Todas las cuentas
                movimientosOriginales = [...datosEstadoCuenta];
                saldoInicialValor = saldosIniciales[0];
            } else {
                // Filtrar por cuenta específica
                movimientosOriginales = datosEstadoCuenta.filter(item => item.cuenta_id === cuentaId);
                saldoInicialValor = saldosIniciales[cuentaId];
            }
            
            // Aplicar filtro de fechas actual
            filtrarPorFechas();
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
            const botones = paginacionContainer.querySelectorAll('button');
            const spanPagina = paginacionContainer.querySelector('span');
            
            // Limpiar botones existentes excepto los de navegación
            while (paginacionContainer.children.length > 7) {
                paginacionContainer.removeChild(paginacionContainer.children[2]);
            }
            
            // Agregar botones de páginas
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
                totalDepositos.textContent = formatCurrency(0);
                totalRetiros.textContent = formatCurrency(0);
                totalSaldo.textContent = formatCurrency(0);
                saldoFinalSpan.textContent = formatCurrency(saldoInicialValor);
                saldoInicialSpan.textContent = formatCurrency(saldoInicialValor);
                
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Calcular saldo acumulado
            let saldoAcumulado = saldoInicialValor;
            const movimientosConSaldo = movimientos.map(mov => {
                saldoAcumulado = saldoAcumulado + (mov.depositos || 0) - (mov.retiros || 0);
                return { ...mov, saldo: saldoAcumulado };
            });
            
            // Calcular totales
            let sumaDepositos = 0;
            let sumaRetiros = 0;
            
            movimientosConSaldo.forEach(item => {
                sumaDepositos += item.depositos || 0;
                sumaRetiros += item.retiros || 0;
            });
            
            const ultimoSaldo = movimientosConSaldo.length > 0 ? movimientosConSaldo[movimientosConSaldo.length - 1].saldo : saldoInicialValor;
            
            totalRegistros.textContent = movimientos.length;
            totalDepositos.textContent = formatCurrency(sumaDepositos);
            totalRetiros.textContent = formatCurrency(sumaRetiros);
            totalSaldo.textContent = formatCurrency(ultimoSaldo);
            saldoFinalSpan.textContent = formatCurrency(ultimoSaldo);
            saldoInicialSpan.textContent = formatCurrency(saldoInicialValor);
            
            // Generar filas de la tabla
            movimientosConSaldo.forEach((item, index) => {
                const row = document.createElement('tr');
                
                const badgeClass = getBadgeClass(item.tipo);
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${(paginaActual - 1) * registrosPorPagina + index + 1}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">
                        <span style="background-color: #6B8ACE; color: white; padding: 3px 6px; border-radius: 3px; font-size: 11px;">${item.cuenta_nombre || '-'}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <span class="badge ${badgeClass}">${item.tipo || '-'}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.folio || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.referencia || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.descripcion || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.depositos ? formatCurrency(item.depositos) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.retiros ? formatCurrency(item.retiros) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; font-weight: bold;">${formatCurrency(item.saldo)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" data-origen-id="${item.origen_id || 0}" data-id="${item.origen_folio || 0}" data-descripcion="${item.descripcion}"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Descargar PDF" data-folio="${item.folio}"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
        }
        
        // Función para ver detalle del movimiento
        function verDetalleMovimiento(origenId, id, descripcion) {
            alert(`Detalle del movimiento:\nOrigen: ${origenId === '3' ? 'Depósito' : origenId === '4' ? 'Retiro/Transferencia' : 'Traspaso'}\nID: ${id}\nDescripción: ${descripcion}\n\n(Funcionalidad en desarrollo)`);
        }
        
        // Event Listeners
        btnConsultar.addEventListener('click', function() {
            filtrarPorFechas();
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportar a Excel - Funcionalidad en desarrollo');
        });
        
        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        buscador.addEventListener('input', filtrarPorBusqueda);
        
        selectCuenta.addEventListener('change', cambiarCuenta);
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Delegación de eventos para los iconos de acción
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                const origenId = e.target.getAttribute('data-origen-id');
                const id = e.target.getAttribute('data-id');
                const descripcion = e.target.getAttribute('data-descripcion');
                verDetalleMovimiento(origenId, id, descripcion);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const folio = e.target.getAttribute('data-folio');
                alert(`Descargar PDF - Folio: ${folio} (Funcionalidad en desarrollo)`);
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
        
        // Cargar datos iniciales (Todas las cuentas)
        cambiarCuenta();
    });
</script>
@endsection