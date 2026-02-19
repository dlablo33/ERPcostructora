@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Flujo de Dinero -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Flujo de Dinero
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con filtro de semana -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    
                    <!-- Filtro de Semana a la derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="semana" style="font-weight: 600; color: #083CAE;">Semana:</label>
                        <select id="semana" style="padding: 8px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px; background-color: white;">
                            <option value="1">Semana 1 (01 - 07 Feb 2026)</option>
                            <option value="2">Semana 2 (08 - 14 Feb 2026)</option>
                            <option value="3" selected>Semana 3 (15 - 21 Feb 2026)</option>
                            <option value="4">Semana 4 (22 - 28 Feb 2026)</option>
                            <option value="5">Semana 5 (29 Feb - 06 Mar 2026)</option>
                        </select>

                        <!-- Botón Exportar Excel -->
                        <div>
 <button id="btnExcel" 
        style="background-color: #2CBF1F; border: 1px solid #2CBF1F; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;"
        title="Exportar a Excel">
    <i class="fas fa-file-excel" style="color: white;"></i>
</button>
                        </div>

                        <!-- Botón Columnas -->
 
                    </div>
                </div>

                <!-- Tabla de Flujo de Dinero -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFlujoDinero" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #6B8ACE; color: white; min-width: 250px;">
                                    <span>Cuentas</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Domingo</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Lunes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Martes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Miércoles</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Jueves</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Viernes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Sábado</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 120px;">
                                    <span>Acumulado</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se generan dinámicamente -->
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #e9ecef; font-weight: bold;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalDomingo">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalLunes">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalMartes">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalMiercoles">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalJueves">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalViernes">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalSabado">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAcumulado">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para la semana seleccionada</p>
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
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 8px;
    }
    
    /* Estilo para las filas de cuentas principales */
    .cuenta-principal {
        font-weight: bold;
        background-color: #f8f9fc !important;
        cursor: pointer;
    }
    
    .cuenta-principal:hover {
        background-color: #e9ecef !important;
    }
    
    .cuenta-principal i {
        transition: transform 0.2s;
        color: #6B8ACE;
        margin-right: 8px;
    }
    
    /* Estilo para subcuentas */
    .subcuenta {
        padding-left: 30px !important;
        background-color: #ffffff;
    }
    
    .subcuenta:hover {
        background-color: #f2f2f2;
    }
    
    /* Estilo para las filas alternadas en subcuentas */
    .subcuenta:nth-child(even) {
        background-color: #fafbfc;
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
        
        select {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Flujo de Dinero');
        
        // Datos de flujo de dinero por semana
        const datosFlujoPorSemana = {
            1: { // Semana 1
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', domingo: 5000, lunes: 8500, martes: 3200, miercoles: 4500, jueves: 2800, viernes: 7200, sabado: 1800 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', domingo: 1200, lunes: 800, martes: 1500, miercoles: 600, jueves: 900, viernes: 1100, sabado: 400 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', domingo: 0, lunes: 0, martes: 3000, miercoles: 0, jueves: 2500, viernes: 0, sabado: 0 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', domingo: 0, lunes: 1200, martes: 800, miercoles: 950, jueves: 1100, viernes: 1300, sabado: 0 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', domingo: 0, lunes: 600, martes: 400, miercoles: 500, jueves: 450, viernes: 550, sabado: 0 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', domingo: 0, lunes: 300, martes: 200, miercoles: 350, jueves: 250, viernes: 400, sabado: 0 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', domingo: 0, lunes: 800, martes: 600, miercoles: 700, jueves: 650, viernes: 750, sabado: 0 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', domingo: 0, lunes: 2000, martes: 0, miercoles: 0, jueves: 0, viernes: 0, sabado: 0 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', domingo: 0, lunes: 0, martes: 0, miercoles: 0, jueves: 3500, viernes: 0, sabado: 0 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', domingo: 0, lunes: 0, martes: 2800, miercoles: 0, jueves: 0, viernes: 1500, sabado: 0 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', domingo: 0, lunes: 0, martes: 0, miercoles: 5434, jueves: 0, viernes: 0, sabado: 0 }
                        ]
                    }
                ]
            },
            2: { // Semana 2
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', domingo: 4200, lunes: 7800, martes: 3500, miercoles: 4900, jueves: 3100, viernes: 6800, sabado: 2100 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', domingo: 900, lunes: 1100, martes: 800, miercoles: 1300, jueves: 600, viernes: 950, sabado: 500 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', domingo: 0, lunes: 0, martes: 2000, miercoles: 0, jueves: 1800, viernes: 0, sabado: 2200 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', domingo: 0, lunes: 1100, martes: 750, miercoles: 880, jueves: 1050, viernes: 1250, sabado: 0 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', domingo: 0, lunes: 550, martes: 380, miercoles: 480, jueves: 420, viernes: 520, sabado: 0 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', domingo: 0, lunes: 280, martes: 190, miercoles: 320, jueves: 230, viernes: 380, sabado: 0 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', domingo: 0, lunes: 750, martes: 580, miercoles: 680, jueves: 620, viernes: 720, sabado: 0 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', domingo: 0, lunes: 2000, martes: 0, miercoles: 0, jueves: 0, viernes: 0, sabado: 0 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', domingo: 0, lunes: 0, martes: 0, miercoles: 0, jueves: 3200, viernes: 0, sabado: 0 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', domingo: 0, lunes: 0, martes: 2100, miercoles: 0, jueves: 0, viernes: 1800, sabado: 0 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', domingo: 0, lunes: 0, martes: 0, miercoles: 5230, jueves: 0, viernes: 0, sabado: 0 }
                        ]
                    }
                ]
            },
            3: { // Semana 3
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', domingo: 5500, lunes: 9200, martes: 3800, miercoles: 5200, jueves: 3400, viernes: 8100, sabado: 2500 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', domingo: 1500, lunes: 1200, martes: 900, miercoles: 1400, jueves: 800, viernes: 1300, sabado: 600 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', domingo: 0, lunes: 0, martes: 3500, miercoles: 0, jueves: 2800, viernes: 0, sabado: 1900 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', domingo: 0, lunes: 1350, martes: 820, miercoles: 1020, jueves: 1250, viernes: 1450, sabado: 0 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', domingo: 0, lunes: 680, martes: 420, miercoles: 550, jueves: 480, viernes: 620, sabado: 0 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', domingo: 0, lunes: 350, martes: 220, miercoles: 380, jueves: 280, viernes: 420, sabado: 0 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', domingo: 0, lunes: 880, martes: 650, miercoles: 750, jueves: 700, viernes: 820, sabado: 0 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', domingo: 0, lunes: 2000, martes: 0, miercoles: 0, jueves: 0, viernes: 0, sabado: 0 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', domingo: 0, lunes: 0, martes: 0, miercoles: 0, jueves: 3800, viernes: 0, sabado: 0 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', domingo: 0, lunes: 0, martes: 3200, miercoles: 0, jueves: 0, viernes: 2100, sabado: 0 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', domingo: 0, lunes: 0, martes: 0, miercoles: 5434, jueves: 0, viernes: 0, sabado: 0 }
                        ]
                    }
                ]
            },
            4: { // Semana 4
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', domingo: 4800, lunes: 8900, martes: 3600, miercoles: 5100, jueves: 3200, viernes: 7900, sabado: 2300 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', domingo: 1300, lunes: 1000, martes: 850, miercoles: 1250, jueves: 750, viernes: 1150, sabado: 550 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', domingo: 0, lunes: 0, martes: 2800, miercoles: 0, jueves: 2200, viernes: 0, sabado: 1700 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', domingo: 0, lunes: 1250, martes: 780, miercoles: 980, jueves: 1150, viernes: 1350, sabado: 0 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', domingo: 0, lunes: 620, martes: 400, miercoles: 520, jueves: 450, viernes: 580, sabado: 0 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', domingo: 0, lunes: 320, martes: 210, miercoles: 350, jueves: 260, viernes: 400, sabado: 0 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', domingo: 0, lunes: 820, martes: 620, miercoles: 720, jueves: 670, viernes: 780, sabado: 0 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', domingo: 0, lunes: 2000, martes: 0, miercoles: 0, jueves: 0, viernes: 0, sabado: 0 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', domingo: 0, lunes: 0, martes: 0, miercoles: 0, jueves: 3500, viernes: 0, sabado: 0 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', domingo: 0, lunes: 0, martes: 2900, miercoles: 0, jueves: 0, viernes: 1900, sabado: 0 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', domingo: 0, lunes: 0, martes: 0, miercoles: 5134, jueves: 0, viernes: 0, sabado: 0 }
                        ]
                    }
                ]
            },
            5: { // Semana 5
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', domingo: 5200, lunes: 8600, martes: 3400, miercoles: 4800, jueves: 3000, viernes: 7500, sabado: 2000 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', domingo: 1100, lunes: 900, martes: 700, miercoles: 1100, jueves: 650, viernes: 1000, sabado: 450 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', domingo: 0, lunes: 0, martes: 2500, miercoles: 0, jueves: 2000, viernes: 0, sabado: 1500 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', domingo: 0, lunes: 1150, martes: 710, miercoles: 910, jueves: 1080, viernes: 1280, sabado: 0 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', domingo: 0, lunes: 580, martes: 360, miercoles: 490, jueves: 410, viernes: 540, sabado: 0 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', domingo: 0, lunes: 300, martes: 180, miercoles: 310, jueves: 240, viernes: 360, sabado: 0 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', domingo: 0, lunes: 760, martes: 560, miercoles: 660, jueves: 610, viernes: 720, sabado: 0 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', domingo: 0, lunes: 2000, martes: 0, miercoles: 0, jueves: 0, viernes: 0, sabado: 0 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', domingo: 0, lunes: 0, martes: 0, miercoles: 0, jueves: 3300, viernes: 0, sabado: 0 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', domingo: 0, lunes: 0, martes: 2600, miercoles: 0, jueves: 0, viernes: 1700, sabado: 0 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', domingo: 0, lunes: 0, martes: 0, miercoles: 4934, jueves: 0, viernes: 0, sabado: 0 }
                        ]
                    }
                ]
            }
        };

        // Variables globales
        let semanaActual = 3;
        
        // Elementos del DOM
        const selectSemana = document.getElementById('semana');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        
        // Elementos de totales
        const totalDomingo = document.getElementById('totalDomingo');
        const totalLunes = document.getElementById('totalLunes');
        const totalMartes = document.getElementById('totalMartes');
        const totalMiercoles = document.getElementById('totalMiercoles');
        const totalJueves = document.getElementById('totalJueves');
        const totalViernes = document.getElementById('totalViernes');
        const totalSabado = document.getElementById('totalSabado');
        const totalAcumulado = document.getElementById('totalAcumulado');

        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Función para calcular acumulado de una subcuenta
        function calcularAcumulado(subcuenta) {
            return (subcuenta.domingo || 0) + 
                   (subcuenta.lunes || 0) + 
                   (subcuenta.martes || 0) + 
                   (subcuenta.miercoles || 0) + 
                   (subcuenta.jueves || 0) + 
                   (subcuenta.viernes || 0) + 
                   (subcuenta.sabado || 0);
        }

        // Estado de expansión de cuentas (TODAS RETRAÍDAS POR DEFECTO)
        let datosExpandidos = {
            1: false, // Ingresos retraído
            2: false  // Egresos retraído
        };

        // Función para alternar expansión de cuenta principal
        function toggleExpand(cuentaId) {
            datosExpandidos[cuentaId] = !datosExpandidos[cuentaId];
            cargarTabla();
        }

        // Función para cargar la tabla
        function cargarTabla() {
            const semanaData = datosFlujoPorSemana[semanaActual];
            
            if (!semanaData || !semanaData.cuentas || semanaData.cuentas.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaBody.innerHTML = '';
                return;
            }

            sinDatosMensaje.style.display = 'none';
            tablaBody.innerHTML = '';

            let totales = {
                domingo: 0, lunes: 0, martes: 0, miercoles: 0, 
                jueves: 0, viernes: 0, sabado: 0, acumulado: 0
            };

            semanaData.cuentas.forEach(cuenta => {
                // Calcular totales de la cuenta principal
                let totalCuentaDomingo = 0, totalCuentaLunes = 0, totalCuentaMartes = 0;
                let totalCuentaMiercoles = 0, totalCuentaJueves = 0, totalCuentaViernes = 0;
                let totalCuentaSabado = 0, totalCuentaAcumulado = 0;

                cuenta.subcuentas.forEach(sub => {
                    totalCuentaDomingo += sub.domingo || 0;
                    totalCuentaLunes += sub.lunes || 0;
                    totalCuentaMartes += sub.martes || 0;
                    totalCuentaMiercoles += sub.miercoles || 0;
                    totalCuentaJueves += sub.jueves || 0;
                    totalCuentaViernes += sub.viernes || 0;
                    totalCuentaSabado += sub.sabado || 0;
                    totalCuentaAcumulado += calcularAcumulado(sub);
                });

                // Fila de cuenta principal (expandible/colapsable)
                const rowPrincipal = document.createElement('tr');
                rowPrincipal.className = 'cuenta-principal';
                rowPrincipal.setAttribute('data-cuenta-id', cuenta.id);
                
                const icono = datosExpandidos[cuenta.id] ? 'fa-chevron-down' : 'fa-chevron-right';
                
                rowPrincipal.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; font-weight: bold;">
                        <i class="fas ${icono}" style="margin-right: 8px; color: #6B8ACE;"></i>
                        ${cuenta.codigo} - ${cuenta.nombre}
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaDomingo)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaLunes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaMartes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaMiercoles)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaJueves)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaViernes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaSabado)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; font-weight: bold;">${formatCurrency(totalCuentaAcumulado)}</td>
                `;
                
                rowPrincipal.addEventListener('click', (e) => {
                    // Evitar que el click en el icono dispare dos veces
                    if (e.target.classList.contains('fas')) {
                        toggleExpand(cuenta.id);
                    } else {
                        toggleExpand(cuenta.id);
                    }
                });
                
                tablaBody.appendChild(rowPrincipal);

                // Agregar subcuentas si está expandido
                if (datosExpandidos[cuenta.id]) {
                    cuenta.subcuentas.forEach(sub => {
                        const subAcumulado = calcularAcumulado(sub);
                        
                        const rowSub = document.createElement('tr');
                        rowSub.className = 'subcuenta';
                        rowSub.innerHTML = `
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; padding-left: 35px;">${sub.codigo} - ${sub.nombre}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.domingo || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.lunes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.martes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.miercoles || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.jueves || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.viernes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.sabado || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(subAcumulado)}</td>
                        `;
                        tablaBody.appendChild(rowSub);
                    });
                }

                // Acumular totales generales
                totales.domingo += totalCuentaDomingo;
                totales.lunes += totalCuentaLunes;
                totales.martes += totalCuentaMartes;
                totales.miercoles += totalCuentaMiercoles;
                totales.jueves += totalCuentaJueves;
                totales.viernes += totalCuentaViernes;
                totales.sabado += totalCuentaSabado;
                totales.acumulado += totalCuentaAcumulado;
            });

            // Actualizar totales en el pie de tabla
            totalDomingo.textContent = formatCurrency(totales.domingo);
            totalLunes.textContent = formatCurrency(totales.lunes);
            totalMartes.textContent = formatCurrency(totales.martes);
            totalMiercoles.textContent = formatCurrency(totales.miercoles);
            totalJueves.textContent = formatCurrency(totales.jueves);
            totalViernes.textContent = formatCurrency(totales.viernes);
            totalSabado.textContent = formatCurrency(totales.sabado);
            totalAcumulado.textContent = formatCurrency(totales.acumulado);
        }

        // Event Listeners
        selectSemana.addEventListener('change', function() {
            semanaActual = parseInt(selectSemana.value);
            cargarTabla();
        });

        btnExcel.addEventListener('click', function() {
            alert('Exportar a Excel - Funcionalidad en desarrollo');
        });

        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });

        // Cargar datos iniciales
        cargarTabla();
    });
</script>
@endsection