@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Flujo de Dinero Mensual -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Flujo de Dinero Mensual
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas con filtro de rango de meses (solo 2 selects) -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    
                    <!-- Filtros a la derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="periodoInicio" style="font-weight: 600; color: #2378e1;">Desde:</label>
                        <select id="periodoInicio" style="padding: 8px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 140px; background-color: white;">
                            <option value="2024-1">Ene 2024</option>
                            <option value="2024-2">Feb 2024</option>
                            <option value="2024-3">Mar 2024</option>
                            <option value="2024-4">Abr 2024</option>
                            <option value="2024-5">May 2024</option>
                            <option value="2024-6">Jun 2024</option>
                            <option value="2024-7">Jul 2024</option>
                            <option value="2024-8">Ago 2024</option>
                            <option value="2024-9">Sep 2024</option>
                            <option value="2024-10">Oct 2024</option>
                            <option value="2024-11">Nov 2024</option>
                            <option value="2024-12">Dic 2024</option>
                            <option value="2025-1">Ene 2025</option>
                            <option value="2025-2">Feb 2025</option>
                            <option value="2025-3">Mar 2025</option>
                            <option value="2025-4">Abr 2025</option>
                            <option value="2025-5">May 2025</option>
                            <option value="2025-6">Jun 2025</option>
                            <option value="2025-7">Jul 2025</option>
                            <option value="2025-8">Ago 2025</option>
                            <option value="2025-9">Sep 2025</option>
                            <option value="2025-10">Oct 2025</option>
                            <option value="2025-11">Nov 2025</option>
                            <option value="2025-12">Dic 2025</option>
                            <option value="2026-1">Ene 2026</option>
                            <option value="2026-2" selected>Feb 2026</option>
                            <option value="2026-3">Mar 2026</option>
                            <option value="2026-4">Abr 2026</option>
                            <option value="2026-5">May 2026</option>
                            <option value="2026-6">Jun 2026</option>
                            <option value="2026-7">Jul 2026</option>
                            <option value="2026-8">Ago 2026</option>
                            <option value="2026-9">Sep 2026</option>
                            <option value="2026-10">Oct 2026</option>
                            <option value="2026-11">Nov 2026</option>
                            <option value="2026-12">Dic 2026</option>
                        </select>

                        <label for="periodoFin" style="font-weight: 600; color: #2378e1;">Hasta:</label>
                        <select id="periodoFin" style="padding: 8px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 140px; background-color: white;">
                            <option value="2024-1">Ene 2024</option>
                            <option value="2024-2">Feb 2024</option>
                            <option value="2024-3">Mar 2024</option>
                            <option value="2024-4">Abr 2024</option>
                            <option value="2024-5">May 2024</option>
                            <option value="2024-6">Jun 2024</option>
                            <option value="2024-7">Jul 2024</option>
                            <option value="2024-8">Ago 2024</option>
                            <option value="2024-9">Sep 2024</option>
                            <option value="2024-10">Oct 2024</option>
                            <option value="2024-11">Nov 2024</option>
                            <option value="2024-12">Dic 2024</option>
                            <option value="2025-1">Ene 2025</option>
                            <option value="2025-2">Feb 2025</option>
                            <option value="2025-3">Mar 2025</option>
                            <option value="2025-4">Abr 2025</option>
                            <option value="2025-5">May 2025</option>
                            <option value="2025-6">Jun 2025</option>
                            <option value="2025-7">Jul 2025</option>
                            <option value="2025-8">Ago 2025</option>
                            <option value="2025-9">Sep 2025</option>
                            <option value="2025-10">Oct 2025</option>
                            <option value="2025-11">Nov 2025</option>
                            <option value="2025-12">Dic 2025</option>
                            <option value="2026-1">Ene 2026</option>
                            <option value="2026-2">Feb 2026</option>
                            <option value="2026-3" selected>Mar 2026</option>
                            <option value="2026-4">Abr 2026</option>
                            <option value="2026-5">May 2026</option>
                            <option value="2026-6">Jun 2026</option>
                            <option value="2026-7">Jul 2026</option>
                            <option value="2026-8">Ago 2026</option>
                            <option value="2026-9">Sep 2026</option>
                            <option value="2026-10">Oct 2026</option>
                            <option value="2026-11">Nov 2026</option>
                            <option value="2026-12">Dic 2026</option>
                        </select>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #2378e1;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Flujo de Dinero Mensual -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFlujoDineroMensual" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr id="encabezadosDinamicos">
                                <!-- Los encabezados se generan dinámicamente -->
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se generan dinámicamente -->
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr id="totalesDinamicos">
                                <!-- Los totales se generan dinámicamente -->
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
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
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(35, 120, 225, 0.15) !important;
        border-color: #2378e1 !important;
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
        color: #000000 !important;
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
        color: #2378e1;
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
        border-top: 2px solid #2378e1;
        color: #000000 !important;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        select, input[type="date"] {
            width: 100% !important;
            margin-bottom: 10px;
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
        console.log('DOM completamente cargado - Flujo de Dinero Mensual');
        
        // Datos de flujo de dinero por mes
        const datosFlujoPorMes = {
            '2026-1': { // Enero 2026
                mes: 'Enero',
                anio: 2026,
                mesAbr: 'Ene',
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 185000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 28400.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 52000.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 68500.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 32400.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 18900.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 42300.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 15600.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 38000.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-2': { // Febrero 2026
                mes: 'Febrero',
                anio: 2026,
                mesAbr: 'Feb',
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 192000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 31200.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 48500.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 71200.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 35600.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 20300.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 45800.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 16800.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 42500.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-3': { // Marzo 2026
                mes: 'Marzo',
                anio: 2026,
                mesAbr: 'Mar',
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 210000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 35600.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 51200.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 75400.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 37800.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 21500.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 48700.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 18200.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 46800.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-4': { // Abril 2026
                mes: 'Abril',
                anio: 2026,
                mesAbr: 'Abr',
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 198000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 29800.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 50300.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 73200.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 36700.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 20900.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 47200.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 17500.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 44600.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            },
            '2026-5': { // Mayo 2026
                mes: 'Mayo',
                anio: 2026,
                mesAbr: 'May',
                cuentas: [
                    {
                        id: 1,
                        codigo: '100-00',
                        nombre: 'Ingresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 101, codigo: '101-00', nombre: 'Cobranza', total: 215000.00 },
                            { id: 102, codigo: '102-00', nombre: 'Otros Ingresos', total: 32400.00 },
                            { id: 103, codigo: '103-00', nombre: 'Traspasos Entre Ctas. Entradas', total: 53400.00 }
                        ]
                    },
                    {
                        id: 2,
                        codigo: '200-00',
                        nombre: 'Egresos',
                        esPrincipal: true,
                        subcuentas: [
                            { id: 201, codigo: '201-00', nombre: 'Costos Operativos', total: 78300.00 },
                            { id: 202, codigo: '202-00', nombre: 'Costos Indirectos Operación', total: 38900.00 },
                            { id: 203, codigo: '203-00', nombre: 'Costos Indirectos Mantenimiento', total: 22400.00 },
                            { id: 204, codigo: '204-00', nombre: 'Gastos Administrativos', total: 49500.00 },
                            { id: 205, codigo: '205-00', nombre: 'Arrendamientos', total: 40000.00 },
                            { id: 206, codigo: '206-00', nombre: 'Impuestos', total: 18900.00 },
                            { id: 207, codigo: '207-00', nombre: 'Traspasos Entre Ctas. Salidas', total: 48700.00 },
                            { id: 299, codigo: '299-00', nombre: 'Gastos 50 Flujo', total: 5434.00 }
                        ]
                    }
                ]
            }
        };

        // Datos acumulados anuales (hasta mayo)
        const datosAcumulados = {
            '101-00': 1000000.00, // Cobranza
            '102-00': 157400.00,  // Otros Ingresos
            '103-00': 255400.00, // Traspasos Entradas
            '201-00': 366600.00, // Costos Operativos
            '202-00': 181400.00, // Costos Indirectos Operación
            '203-00': 104000.00,  // Costos Indirectos Mantenimiento
            '204-00': 232500.00, // Gastos Administrativos
            '205-00': 200000.00, // Arrendamientos
            '206-00': 87900.00,  // Impuestos
            '207-00': 216600.00, // Traspasos Salidas
            '299-00': 27170.00   // Gastos 50 Flujo
        };

        // Variables globales
        let periodoInicio = '2026-2'; // Febrero 2026
        let periodoFin = '2026-3'; // Marzo 2026
        
        // Elementos del DOM
        const selectPeriodoInicio = document.getElementById('periodoInicio');
        const selectPeriodoFin = document.getElementById('periodoFin');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const encabezadosDinamicos = document.getElementById('encabezadosDinamicos');
        const totalesDinamicos = document.getElementById('totalesDinamicos');

        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
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

        // Función para obtener los meses en el rango
        function obtenerMesesEnRango() {
            const [anioInicio, mesInicio] = periodoInicio.split('-').map(Number);
            const [anioFin, mesFin] = periodoFin.split('-').map(Number);
            
            const meses = [];
            
            // Crear fechas para inicio y fin
            const fechaInicio = new Date(anioInicio, mesInicio - 1, 1);
            const fechaFin = new Date(anioFin, mesFin - 1, 1);
            
            // Si la fecha fin es menor que la fecha inicio, intercambiar
            if (fechaFin < fechaInicio) {
                // Intercambiar valores
                [periodoInicio, periodoFin] = [periodoFin, periodoInicio];
                selectPeriodoInicio.value = periodoInicio;
                selectPeriodoFin.value = periodoFin;
                
                const [nuevoAnioInicio, nuevoMesInicio] = periodoInicio.split('-').map(Number);
                const [nuevoAnioFin, nuevoMesFin] = periodoFin.split('-').map(Number);
                
                fechaInicio.setFullYear(nuevoAnioInicio, nuevoMesInicio - 1, 1);
                fechaFin.setFullYear(nuevoAnioFin, nuevoMesFin - 1, 1);
            }
            
            // Iterar desde la fecha inicio hasta la fecha fin
            let fechaActual = new Date(fechaInicio);
            
            while (fechaActual <= fechaFin) {
                const mes = fechaActual.getMonth() + 1;
                const anio = fechaActual.getFullYear();
                meses.push({ mes, anio, clave: `${anio}-${mes}` });
                
                // Avanzar al siguiente mes
                fechaActual.setMonth(fechaActual.getMonth() + 1);
            }
            
            return meses;
        }

        // Función para generar encabezados dinámicos
        function generarEncabezados(meses) {
            let html = '<th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #2378e1; color: white; min-width: 300px;">Cuentas</th>';
            
            meses.forEach(mes => {
                const mesData = datosFlujoPorMes[mes.clave];
                const nombreMes = mesData ? mesData.mesAbr : 'N/A';
                html += `<th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 120px;">${nombreMes} ${mes.anio}</th>`;
            });
            
            html += '<th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; min-width: 150px;">Acumulado</th>';
            
            encabezadosDinamicos.innerHTML = html;
        }

        // Función para generar totales dinámicos
        function generarTotales(meses, totalesPorMes, totalAcumuladoValor) {
            let html = '<td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #e9ecef; font-weight: bold; color: #000000;">TOTALES</td>';
            
            meses.forEach(mes => {
                const total = totalesPorMes[mes.clave] || 0;
                html += `<td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold; color: #000000;">${formatCurrency(total)}</td>`;
            });
            
            html += `<td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold; color: #000000;">${formatCurrency(totalAcumuladoValor)}</td>`;
            
            totalesDinamicos.innerHTML = html;
        }

        // Función para cargar la tabla
        function cargarTabla() {
            const mesesEnRango = obtenerMesesEnRango();
            
            if (mesesEnRango.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaBody.innerHTML = '';
                encabezadosDinamicos.innerHTML = '';
                totalesDinamicos.innerHTML = '';
                return;
            }

            // Generar encabezados dinámicos
            generarEncabezados(mesesEnRango);

            // Recopilar datos de todos los meses en el rango
            const datosCombinados = {};
            const totalesPorMes = {};
            let hayDatos = false;
            
            mesesEnRango.forEach(({ mes, anio, clave }) => {
                const mesData = datosFlujoPorMes[clave];
                totalesPorMes[clave] = 0;
                
                if (mesData && mesData.cuentas) {
                    hayDatos = true;
                    mesData.cuentas.forEach(cuenta => {
                        if (!datosCombinados[cuenta.id]) {
                            datosCombinados[cuenta.id] = {
                                id: cuenta.id,
                                codigo: cuenta.codigo,
                                nombre: cuenta.nombre,
                                subcuentas: {}
                            };
                        }
                        
                        cuenta.subcuentas.forEach(sub => {
                            if (!datosCombinados[cuenta.id].subcuentas[sub.codigo]) {
                                datosCombinados[cuenta.id].subcuentas[sub.codigo] = {
                                    codigo: sub.codigo,
                                    nombre: sub.nombre,
                                    meses: {}
                                };
                            }
                            datosCombinados[cuenta.id].subcuentas[sub.codigo].meses[clave] = sub.total || 0;
                            totalesPorMes[clave] += sub.total || 0;
                        });
                    });
                }
            });

            if (!hayDatos) {
                sinDatosMensaje.style.display = 'block';
                tablaBody.innerHTML = '';
                return;
            }

            sinDatosMensaje.style.display = 'none';
            tablaBody.innerHTML = '';

            let totalAcumuladoValor = 0;

            // Convertir el objeto combinado a un array y ordenar por ID
            const cuentasCombinadas = Object.values(datosCombinados).sort((a, b) => a.id - b.id);

            cuentasCombinadas.forEach(cuenta => {
                // Calcular total de la cuenta principal para cada mes y acumulado
                const totalesCuenta = {};
                let totalCuentaAcumulado = 0;

                const subcuentasArray = Object.values(cuenta.subcuentas);
                
                mesesEnRango.forEach(({ clave }) => {
                    totalesCuenta[clave] = 0;
                });
                
                subcuentasArray.forEach(sub => {
                    mesesEnRango.forEach(({ clave }) => {
                        totalesCuenta[clave] += sub.meses[clave] || 0;
                    });
                    totalCuentaAcumulado += datosAcumulados[sub.codigo] || 0;
                });

                // Fila de cuenta principal (expandible/colapsable)
                const rowPrincipal = document.createElement('tr');
                rowPrincipal.className = 'cuenta-principal';
                rowPrincipal.setAttribute('data-cuenta-id', cuenta.id);
                
                const icono = datosExpandidos[cuenta.id] ? 'fa-chevron-down' : 'fa-chevron-right';
                
                let celdasHTML = `<td style="border: 1px solid #dee2e6; padding: 12px 8px; font-weight: bold; color: #000000;">
                                    <i class="fas ${icono}" style="margin-right: 8px; color: #2378e1;"></i>
                                    ${cuenta.codigo} - ${cuenta.nombre}
                                </td>`;
                
                mesesEnRango.forEach(({ clave }) => {
                    celdasHTML += `<td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; color: #000000;">${formatCurrency(totalesCuenta[clave])}</td>`;
                });
                
                celdasHTML += `<td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; font-weight: bold; color: #000000;">${formatCurrency(totalCuentaAcumulado)}</td>`;
                
                rowPrincipal.innerHTML = celdasHTML;
                
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
                    subcuentasArray.sort((a, b) => a.codigo.localeCompare(b.codigo)).forEach(sub => {
                        const subAcumulado = datosAcumulados[sub.codigo] || 0;
                        
                        let subCeldasHTML = `<td style="border: 1px solid #dee2e6; padding: 10px 8px; padding-left: 35px; color: #000000;">${sub.codigo} - ${sub.nombre}</td>`;
                        
                        mesesEnRango.forEach(({ clave }) => {
                            subCeldasHTML += `<td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right; color: #000000;">${formatCurrency(sub.meses[clave] || 0)}</td>`;
                        });
                        
                        subCeldasHTML += `<td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right; color: #000000;">${formatCurrency(subAcumulado)}</td>`;
                        
                        const rowSub = document.createElement('tr');
                        rowSub.className = 'subcuenta';
                        rowSub.innerHTML = subCeldasHTML;
                        tablaBody.appendChild(rowSub);
                    });
                }

                // Acumular totales generales
                totalAcumuladoValor += totalCuentaAcumulado;
            });

            // Generar totales dinámicos
            generarTotales(mesesEnRango, totalesPorMes, totalAcumuladoValor);
        }

        // Event Listeners
        function aplicarFiltros() {
            periodoInicio = selectPeriodoInicio.value;
            periodoFin = selectPeriodoFin.value;
            cargarTabla();
        }

        selectPeriodoInicio.addEventListener('change', aplicarFiltros);
        selectPeriodoFin.addEventListener('change', aplicarFiltros);

        btnExcel.addEventListener('click', function() {
            exportTableToExcel('tablaFlujoDineroMensual', 'FlujoDineroMensual');
        });

        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
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

        // Cargar datos iniciales
        cargarTabla();
    });
</script>
@endsection