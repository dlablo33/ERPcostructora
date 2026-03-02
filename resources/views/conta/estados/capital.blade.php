@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Presupuestos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Presupuestos
                    </h2>
                    <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #083CAE; font-size: 14px;">Año:</span>
                        <select id="anioSelector" style="padding: 6px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; background-color: white; color: #083CAE; font-weight: 500;">
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                            <option value="2027">2027</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Mensaje de edición -->

                <!-- Mensaje "Sin datos" centrado (oculto por defecto) -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #083CAE; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el año seleccionado</p>
                </div>

                <!-- Tabla de Presupuestos - Completa en la página -->
                <div style="width: 100%; overflow-x: auto; margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; border-collapse: collapse;">
                        <thead style="background-color: #083CAE;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #083CAE; color: white; width: 200px;">Categoría</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Ene</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Feb</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Mar</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Abr</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">May</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Jun</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Jul</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Ago</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Sep</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Oct</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Nov</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 90px;">Dic</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 110px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente con inputs editables -->
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; background-color: #e9ecef; font-weight: bold;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalEne">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalFeb">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalMar">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAbr">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalMay">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalJun">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalJul">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAgo">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalSep">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalOct">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalNov">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalDic">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAnualFoot">$0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Botones de acción en la parte inferior -->
                <div style="display: flex; justify-content: flex-start; gap: 15px; margin-top: 20px;">
                    <!-- Botón Guardar -->
                    <button id="btnGuardar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 10px 25px; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-save"></i>
                        Guardar Cambios
                    </button>
                    
                    <!-- Botón Cancelar -->
                    <button id="btnCancelar" style="background-color: #dc3545; color: white; border: none; border-radius: 4px; padding: 10px 25px; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>

                <!-- Leyenda -->
                <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">

                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* ============================================
       ESTILOS GENERALES
       ============================================ */
    * {
        box-sizing: border-box;
    }
    
    body {
        overflow-y: auto;
    }
    
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
        border-radius: 8px 8px 0 0;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
    }
    
    /* ============================================
       ESTILOS DE BOTONES INFERIORES
       ============================================ */
    #btnGuardar {
        background-color: #2CBF1F;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 25px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #btnGuardar:hover {
        background-color: #22991a;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    #btnGuardar:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    #btnCancelar {
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 25px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #btnCancelar:hover {
        background-color: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    #btnCancelar:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    /* ============================================
       ESTILOS DE TABLA Y INPUTS EDITABLES
       ============================================ */
    .table {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;
    }
    
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #083CAE !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 5px 8px;
        color: #000000;
    }
    
    /* Estilo para inputs editables */
    .input-presupuesto {
        width: 85px;
        border: 1px solid #ced4da;
        border-radius: 3px;
        padding: 6px 4px;
        font-size: 11px;
        text-align: right;
        background-color: white;
        transition: all 0.2s ease;
    }
    
    .input-presupuesto:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    .input-presupuesto:hover {
        border-color: #083CAE;
    }
    
    /* Estilo para celdas de total (no editables) */
    .total-fila {
        font-weight: 600;
        padding: 8px;
        text-align: right;
        background-color: #f8f9fa;
    }
    
    /* Estilo para filas de categorías principales */
    .categoria-principal {
        background-color: #f0f4ff !important;
    }
    
    .categoria-principal td:first-child {
        font-weight: 600;
    }
    
    /* Estilo para subcategorías */
    .subcategoria {
        background-color: #ffffff;
    }
    
    .subcategoria td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo para separador de secciones */
    .separador-seccion {
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        border-bottom: 2px solid #083CAE;
    }
    
    .separador-seccion td {
        background-color: #e9ecef !important;
        font-weight: 600;
        color: #083CAE !important;
    }
    
    /* Hover en filas */
    tbody tr:hover td {
        background-color: #f5f5f5 !important;
    }
    
    /* ============================================
       ESTILOS PARA EL PIE DE TABLA
       ============================================ */
    tfoot td {
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
        font-weight: bold;
        font-size: 12px;
    }
    
    /* ============================================
       ESTILOS PARA EL SELECTOR DE AÑO
       ============================================ */
    #anioSelector {
        padding: 8px 16px;
        border: 2px solid #083CAE;
        border-radius: 6px;
        font-size: 14px;
        background-color: white;
        color: #083CAE;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    #anioSelector:hover {
        background-color: #083CAE;
        color: white;
    }
    
    #anioSelector:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.3);
    }
    
    /* ============================================
       ESTILOS PARA LA BARRA DE SCROLL HORIZONTAL
       ============================================ */
    ::-webkit-scrollbar {
        height: 10px;
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #062b7c;
    }
    
    /* ============================================
       ESTILOS RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        select {
            width: 100% !important;
        }
        
        .semaforo .card-header div {
            flex-direction: column;
            gap: 10px;
        }
        
        .semaforo .card-header h2 {
            font-size: 18px;
        }
        
        #btnGuardar, #btnCancelar {
            padding: 8px 15px;
            font-size: 12px;
        }
        
        .input-presupuesto {
            width: 70px;
            padding: 4px 2px;
            font-size: 10px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // PRESUPUESTOS - SISTEMA CONTABLE
    // VERSIÓN: 3.0.0
    // FECHA: 2026
    // CARACTERÍSTICAS: TABLA COMPLETA, CAMPOS EDITABLES
    // ============================================

    (function() {
        'use strict';
        
        // ============================================
        // CONFIGURACIÓN GLOBAL
        // ============================================
        const CONFIG = {
            ANIO_ACTUAL: 2026,
            MESES: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            FORMATO_MONEDA: 'en-US',
            DECIMALES: 0,
            SEPARADOR_MILES: ',',
            SIMBOLO_MONEDA: '$'
        };
        
        // ============================================
        // ESTADO DE LA APLICACIÓN
        // ============================================
        const EstadoApp = {
            anioActual: '2026',
            datosOriginales: null,
            datosEditados: null,
            datosCargados: false
        };
        
        // ============================================
        // DATOS DE PRESUPUESTOS
        // ============================================
        
        /**
         * Datos para 2026 - Presupuestos por categoría
         * @type {Array}
         */
        const datos2026 = [
            // ========================================
            // SECCIÓN: ESTADO DE RESULTADOS
            // ========================================
            {
                categoria: 'Estado de Resultados',
                esSeccion: true,
                enero: 0, febrero: 0, marzo: 0, abril: 0, mayo: 0, junio: 0,
                julio: 0, agosto: 0, septiembre: 0, octubre: 0, noviembre: 0, diciembre: 0
            },
            
            // ========================================
            // SECCIÓN: COMBUSTIBLES
            // ========================================
            {
                categoria: 'Diesel',
                esPrincipal: true,
                enero: 450000, febrero: 455000, marzo: 460000, abril: 458000, 
                mayo: 462000, junio: 465000, julio: 470000, agosto: 468000,
                septiembre: 465000, octubre: 460000, noviembre: 455000, diciembre: 450000
            },
            {
                categoria: 'Urea',
                esPrincipal: true,
                enero: 25000, febrero: 25200, marzo: 25500, abril: 25300,
                mayo: 25800, junio: 26000, julio: 26200, agosto: 26100,
                septiembre: 25900, octubre: 25700, noviembre: 25500, diciembre: 25000
            },
            
            // ========================================
            // SECCIÓN: OPERADORES
            // ========================================
            {
                categoria: 'Sueldos Operadores',
                esPrincipal: true,
                enero: 320000, febrero: 320000, marzo: 322000, abril: 322000,
                mayo: 324000, junio: 324000, julio: 326000, agosto: 326000,
                septiembre: 328000, octubre: 328000, noviembre: 330000, diciembre: 330000
            },
            {
                categoria: 'Gastos de Viaje Operadores',
                enero: 45000, febrero: 46000, marzo: 47000, abril: 48000,
                mayo: 49000, junio: 50000, julio: 51000, agosto: 52000,
                septiembre: 53000, octubre: 54000, noviembre: 55000, diciembre: 56000
            },
            {
                categoria: 'Casetas',
                enero: 85000, febrero: 86000, marzo: 87000, abril: 88000,
                mayo: 89000, junio: 90000, julio: 91000, agosto: 92000,
                septiembre: 93000, octubre: 94000, noviembre: 95000, diciembre: 96000
            },
            {
                categoria: 'Rastreo Satelital y Monitoreo',
                enero: 18000, febrero: 18000, marzo: 18200, abril: 18200,
                mayo: 18400, junio: 18400, julio: 18600, agosto: 18600,
                septiembre: 18800, octubre: 18800, noviembre: 19000, diciembre: 19000
            },
            
            // ========================================
            // SECCIÓN: MANTENIMIENTO
            // ========================================
            {
                categoria: 'Sueldos Mtto.',
                esPrincipal: true,
                enero: 185000, febrero: 185000, marzo: 186000, abril: 186000,
                mayo: 187000, junio: 187000, julio: 188000, agosto: 188000,
                septiembre: 189000, octubre: 189000, noviembre: 190000, diciembre: 190000
            },
            {
                categoria: 'Mantenimiento Preventivo',
                enero: 75000, febrero: 78000, marzo: 80000, abril: 82000,
                mayo: 85000, junio: 88000, julio: 90000, agosto: 92000,
                septiembre: 95000, octubre: 98000, noviembre: 100000, diciembre: 105000
            },
            {
                categoria: 'Mantenimiento Correctivo',
                enero: 45000, febrero: 48000, marzo: 52000, abril: 55000,
                mayo: 58000, junio: 62000, julio: 65000, agosto: 68000,
                septiembre: 72000, octubre: 75000, noviembre: 78000, diciembre: 82000
            },
            {
                categoria: 'Talleres Externos',
                enero: 35000, febrero: 36000, marzo: 37000, abril: 38000,
                mayo: 39000, junio: 40000, julio: 41000, agosto: 42000,
                septiembre: 43000, octubre: 44000, noviembre: 45000, diciembre: 46000
            },
            {
                categoria: 'Llantas',
                enero: 120000, febrero: 0, marzo: 125000, abril: 0,
                mayo: 130000, junio: 0, julio: 135000, agosto: 0,
                septiembre: 140000, octubre: 0, noviembre: 145000, diciembre: 0
            },
            
            // ========================================
            // SECCIÓN: ADMINISTRACIÓN
            // ========================================
            {
                categoria: 'Sueldos',
                esPrincipal: true,
                enero: 420000, febrero: 420000, marzo: 423000, abril: 423000,
                mayo: 426000, junio: 426000, julio: 429000, agosto: 429000,
                septiembre: 432000, octubre: 432000, noviembre: 435000, diciembre: 435000
            },
            {
                categoria: 'Cuotas Patronales Admon.',
                enero: 115000, febrero: 115000, marzo: 116000, abril: 116000,
                mayo: 117000, junio: 117000, julio: 118000, agosto: 118000,
                septiembre: 119000, octubre: 119000, noviembre: 120000, diciembre: 120000
            },
            {
                categoria: 'Gasolina y Mtto. Utilitarios',
                enero: 28000, febrero: 28500, marzo: 29000, abril: 29500,
                mayo: 30000, junio: 30500, julio: 31000, agosto: 31500,
                septiembre: 32000, octubre: 32500, noviembre: 33000, diciembre: 33500
            },
            {
                categoria: 'Servicios',
                enero: 95000, febrero: 95000, marzo: 96000, abril: 96000,
                mayo: 97000, junio: 97000, julio: 98000, agosto: 98000,
                septiembre: 99000, octubre: 99000, noviembre: 100000, diciembre: 100000
            },
            {
                categoria: 'Renta y Vigilancia',
                enero: 110000, febrero: 110000, marzo: 111000, abril: 111000,
                mayo: 112000, junio: 112000, julio: 113000, agosto: 113000,
                septiembre: 114000, octubre: 114000, noviembre: 115000, diciembre: 115000
            },
            {
                categoria: 'Sistemas Y Mtto. Computo',
                enero: 42000, febrero: 42000, marzo: 43000, abril: 43000,
                mayo: 44000, junio: 44000, julio: 45000, agosto: 45000,
                septiembre: 46000, octubre: 46000, noviembre: 47000, diciembre: 47000
            },
            {
                categoria: 'Otros Gastos Admon.',
                enero: 38000, febrero: 38000, marzo: 39000, abril: 39000,
                mayo: 40000, junio: 40000, julio: 41000, agosto: 41000,
                septiembre: 42000, octubre: 42000, noviembre: 43000, diciembre: 43000
            },
            
            // ========================================
            // SECCIÓN: GASTOS FINANCIEROS
            // ========================================
            {
                categoria: 'Intereses Por Financiamiento',
                esPrincipal: true,
                enero: 85000, febrero: 84000, marzo: 83000, abril: 82000,
                mayo: 81000, junio: 80000, julio: 79000, agosto: 78000,
                septiembre: 77000, octubre: 76000, noviembre: 75000, diciembre: 74000
            },
            {
                categoria: 'Utilidad o Perdida Cambiaria',
                enero: -15000, febrero: -12000, marzo: -10000, abril: -8000,
                mayo: -6000, junio: -4000, julio: -2000, agosto: 0,
                septiembre: 2000, octubre: 4000, noviembre: 6000, diciembre: 8000
            },
            
            // ========================================
            // SECCIÓN: SEGUROS Y SINIESTROS
            // ========================================
            {
                categoria: 'Seguros',
                esPrincipal: true,
                enero: 120000, febrero: 120000, marzo: 120000, abril: 120000,
                mayo: 120000, junio: 120000, julio: 120000, agosto: 120000,
                septiembre: 120000, octubre: 120000, noviembre: 120000, diciembre: 120000
            },
            {
                categoria: 'Siniestros',
                enero: 50000, febrero: 45000, marzo: 40000, abril: 35000,
                mayo: 30000, junio: 25000, julio: 20000, agosto: 15000,
                septiembre: 10000, octubre: 5000, noviembre: 0, diciembre: 0
            },
            {
                categoria: 'Deducibles Siniestros',
                enero: 15000, febrero: 14000, marzo: 13000, abril: 12000,
                mayo: 11000, junio: 10000, julio: 9000, agosto: 8000,
                septiembre: 7000, octubre: 6000, noviembre: 5000, diciembre: 4000
            },
            
            // ========================================
            // SECCIÓN: OTROS GASTOS
            // ========================================
            {
                categoria: 'Gastos de Viaje',
                enero: 35000, febrero: 36000, marzo: 37000, abril: 38000,
                mayo: 39000, junio: 40000, julio: 41000, agosto: 42000,
                septiembre: 43000, octubre: 44000, noviembre: 45000, diciembre: 46000
            },
            {
                categoria: 'Multas',
                enero: 8000, febrero: 7500, marzo: 7000, abril: 6500,
                mayo: 6000, junio: 5500, julio: 5000, agosto: 4500,
                septiembre: 4000, octubre: 3500, noviembre: 3000, diciembre: 2500
            },
            {
                categoria: 'Costo Exportación',
                enero: 250000, febrero: 260000, marzo: 270000, abril: 280000,
                mayo: 290000, junio: 300000, julio: 310000, agosto: 320000,
                septiembre: 330000, octubre: 340000, noviembre: 350000, diciembre: 360000
            },
            {
                categoria: 'Otros Gastos Transportación',
                enero: 45000, febrero: 46000, marzo: 47000, abril: 48000,
                mayo: 49000, junio: 50000, julio: 51000, agosto: 52000,
                septiembre: 53000, octubre: 54000, noviembre: 55000, diciembre: 56000
            },
            
            // ========================================
            // SECCIÓN: DEPRECIACIÓN
            // ========================================
            {
                categoria: 'Arrendamiento',
                esPrincipal: true,
                enero: 180000, febrero: 180000, marzo: 180000, abril: 180000,
                mayo: 180000, junio: 180000, julio: 180000, agosto: 180000,
                septiembre: 180000, octubre: 180000, noviembre: 180000, diciembre: 180000
            },
            {
                categoria: 'Depreciación',
                enero: 320000, febrero: 320000, marzo: 320000, abril: 320000,
                mayo: 320000, junio: 320000, julio: 320000, agosto: 320000,
                septiembre: 320000, octubre: 320000, noviembre: 320000, diciembre: 320000
            },
            
            // ========================================
            // SECCIÓN: CUOTAS PATRONALES
            // ========================================
            {
                categoria: 'Cuotas Patronales Mtto.',
                esPrincipal: true,
                enero: 75000, febrero: 75000, marzo: 76000, abril: 76000,
                mayo: 77000, junio: 77000, julio: 78000, agosto: 78000,
                septiembre: 79000, octubre: 79000, noviembre: 80000, diciembre: 80000
            },
            {
                categoria: 'Gasolina y Mtto. Utilitarios (2)',
                enero: 28000, febrero: 28500, marzo: 29000, abril: 29500,
                mayo: 30000, junio: 30500, julio: 31000, agosto: 31500,
                septiembre: 32000, octubre: 32500, noviembre: 33000, diciembre: 33500
            },
            {
                categoria: 'Otros Gastos Mtto.',
                enero: 25000, febrero: 26000, marzo: 27000, abril: 28000,
                mayo: 29000, junio: 30000, julio: 31000, agosto: 32000,
                septiembre: 33000, octubre: 34000, noviembre: 35000, diciembre: 36000
            },
            
            // ========================================
            // SECCIÓN: OTROS COSTOS
            // ========================================
            {
                categoria: 'Otros Costos De Operacion',
                esPrincipal: true,
                enero: 185000, febrero: 187000, marzo: 190000, abril: 192000,
                mayo: 195000, junio: 197000, julio: 200000, agosto: 202000,
                septiembre: 205000, octubre: 207000, noviembre: 210000, diciembre: 212000
            },
            {
                categoria: 'Gastos Estados Resultados Default',
                enero: 95000, febrero: 96000, marzo: 97000, abril: 98000,
                mayo: 99000, junio: 100000, julio: 101000, agosto: 102000,
                septiembre: 103000, octubre: 104000, noviembre: 105000, diciembre: 106000
            },
            {
                categoria: 'Adicionales',
                enero: 65000, febrero: 66000, marzo: 67000, abril: 68000,
                mayo: 69000, junio: 70000, julio: 71000, agosto: 72000,
                septiembre: 73000, octubre: 74000, noviembre: 75000, diciembre: 76000
            },
            {
                categoria: 'Indirectos Operadores',
                enero: 48000, febrero: 49000, marzo: 50000, abril: 51000,
                mayo: 52000, junio: 53000, julio: 54000, agosto: 55000,
                septiembre: 56000, octubre: 57000, noviembre: 58000, diciembre: 59000
            }
        ];

        // ============================================
        // DATOS PARA 2025 Y 2027
        // ============================================
        const datos2025 = JSON.parse(JSON.stringify(datos2026));
        const datos2027 = JSON.parse(JSON.stringify(datos2026));
        
        // Ajustar valores para 2025 (5% menos)
        datos2025.forEach(item => {
            if (!item.esSeccion) {
                ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'].forEach(mes => {
                    if (item[mes] !== undefined) {
                        item[mes] = Math.round(item[mes] * 0.95);
                    }
                });
            }
        });

        // Ajustar valores para 2027 (5% más)
        datos2027.forEach(item => {
            if (!item.esSeccion) {
                ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'].forEach(mes => {
                    if (item[mes] !== undefined) {
                        item[mes] = Math.round(item[mes] * 1.05);
                    }
                });
            }
        });

        // ============================================
        // MAPEO DE DATOS POR AÑO
        // ============================================
        const DATOS_POR_ANIO = {
            '2025': datos2025,
            '2026': datos2026,
            '2027': datos2027
        };

        // ============================================
        // FUNCIONES DE UTILIDAD
        // ============================================

        /**
         * Formatea un número a moneda sin decimales
         */
        function formatearMoneda(valor) {
            if (valor === null || valor === undefined || isNaN(valor)) {
                return '$0';
            }
            
            const signo = valor < 0 ? '-' : '';
            const valorAbsoluto = Math.abs(valor);
            const formateado = Math.round(valorAbsoluto).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            
            return signo + '$' + formateado;
        }

        /**
         * Parsea un string de moneda a número
         */
        function parsearMoneda(valor) {
            if (!valor) return 0;
            const numero = valor.toString().replace(/[$,]/g, '');
            return parseFloat(numero) || 0;
        }

        /**
         * Obtiene los datos según el año seleccionado
         */
        function obtenerDatosAnio(anio) {
            return JSON.parse(JSON.stringify(DATOS_POR_ANIO[anio] || datos2026));
        }

        /**
         * Calcula el total anual para una categoría
         */
        function calcularTotalAnual(item) {
            return (item.enero || 0) + (item.febrero || 0) + (item.marzo || 0) + 
                   (item.abril || 0) + (item.mayo || 0) + (item.junio || 0) + 
                   (item.julio || 0) + (item.agosto || 0) + (item.septiembre || 0) + 
                   (item.octubre || 0) + (item.noviembre || 0) + (item.diciembre || 0);
        }

        /**
         * Actualiza los totales en el pie de tabla
         */
        function actualizarTotales() {
            let totalesMensuales = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            let totalAnualGeneral = 0;
            
            const filas = document.querySelectorAll('#tablaBody tr:not(.separador-seccion)');
            
            filas.forEach(fila => {
                for (let i = 1; i <= 12; i++) {
                    const input = fila.cells[i]?.querySelector('input');
                    if (input) {
                        const valor = parsearMoneda(input.value);
                        totalesMensuales[i-1] += valor;
                    }
                }
            });
            
            totalAnualGeneral = totalesMensuales.reduce((a, b) => a + b, 0);
            
            document.getElementById('totalEne').textContent = formatearMoneda(totalesMensuales[0]);
            document.getElementById('totalFeb').textContent = formatearMoneda(totalesMensuales[1]);
            document.getElementById('totalMar').textContent = formatearMoneda(totalesMensuales[2]);
            document.getElementById('totalAbr').textContent = formatearMoneda(totalesMensuales[3]);
            document.getElementById('totalMay').textContent = formatearMoneda(totalesMensuales[4]);
            document.getElementById('totalJun').textContent = formatearMoneda(totalesMensuales[5]);
            document.getElementById('totalJul').textContent = formatearMoneda(totalesMensuales[6]);
            document.getElementById('totalAgo').textContent = formatearMoneda(totalesMensuales[7]);
            document.getElementById('totalSep').textContent = formatearMoneda(totalesMensuales[8]);
            document.getElementById('totalOct').textContent = formatearMoneda(totalesMensuales[9]);
            document.getElementById('totalNov').textContent = formatearMoneda(totalesMensuales[10]);
            document.getElementById('totalDic').textContent = formatearMoneda(totalesMensuales[11]);
            document.getElementById('totalAnualFoot').textContent = formatearMoneda(totalAnualGeneral);
        }

        /**
         * Actualiza el total de una fila específica
         */
        function actualizarTotalFila(fila) {
            let total = 0;
            for (let i = 1; i <= 12; i++) {
                const input = fila.cells[i]?.querySelector('input');
                if (input) {
                    total += parsearMoneda(input.value);
                }
            }
            const totalCell = fila.cells[13];
            if (totalCell) {
                totalCell.textContent = formatearMoneda(total);
            }
        }

        /**
         * Carga la tabla con los datos del año seleccionado
         */
        function cargarTabla() {
            const tbody = document.getElementById('tablaBody');
            if (!tbody) return;
            
            const anioSeleccionado = document.getElementById('anioSelector').value;
            EstadoApp.anioActual = anioSeleccionado;
            
            const datosCompletos = obtenerDatosAnio(anioSeleccionado);
            EstadoApp.datosOriginales = JSON.parse(JSON.stringify(datosCompletos));
            EstadoApp.datosEditados = datosCompletos;
            
            tbody.innerHTML = '';
            
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            if (sinDatosMensaje) {
                if (datosCompletos.length === 0) {
                    sinDatosMensaje.style.display = 'block';
                    return;
                } else {
                    sinDatosMensaje.style.display = 'none';
                }
            }
            
            // Generar filas con inputs editables
            datosCompletos.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.dataset.index = index;
                
                if (item.esSeccion) {
                    tr.className = 'separador-seccion';
                } else if (item.esPrincipal) {
                    tr.className = 'categoria-principal';
                } else {
                    tr.className = 'subcategoria';
                }
                
                const total = calcularTotalAnual(item);
                
                let html = `<td style="border: 1px solid #dee2e6; padding: 8px; ${item.esSeccion ? 'color: #083CAE; font-weight: 600;' : ''}">${item.categoria}</td>`;
                
                // Generar inputs para cada mes
                const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                
                meses.forEach(mes => {
                    if (item.esSeccion) {
                        html += `<td style="border: 1px solid #dee2e6; padding: 8px; text-align: right;"></td>`;
                    } else {
                        const valor = item[mes] || 0;
                        html += `<td style="border: 1px solid #dee2e6; padding: 4px;">
                            <input type="text" class="input-presupuesto" value="${formatearMoneda(valor)}" data-mes="${mes}" data-categoria="${item.categoria}" data-index="${index}">
                        </td>`;
                    }
                });
                
                // Columna de total
                if (item.esSeccion) {
                    html += `<td style="border: 1px solid #dee2e6; padding: 8px; text-align: right; font-weight: 600;"></td>`;
                } else {
                    html += `<td style="border: 1px solid #dee2e6; padding: 8px; text-align: right; font-weight: 600;" class="total-fila">${formatearMoneda(total)}</td>`;
                }
                
                tr.innerHTML = html;
                tbody.appendChild(tr);
            });
            
            // Agregar event listeners a los inputs
            document.querySelectorAll('.input-presupuesto').forEach(input => {
                input.addEventListener('input', function(e) {
                    let valor = this.value.replace(/[$,]/g, '');
                    if (valor === '' || isNaN(valor)) valor = '0';
                    this.value = formatearMoneda(parseFloat(valor));
                    
                    const fila = this.closest('tr');
                    actualizarTotalFila(fila);
                    actualizarTotales();
                });
                
                input.addEventListener('blur', function() {
                    if (this.value === '' || this.value === '$0') {
                        this.value = '$0';
                    }
                });
            });
            
            actualizarTotales();
        }

        /**
         * Guarda los cambios
         */
        function guardarCambios() {
            const cambios = [];
            document.querySelectorAll('#tablaBody tr:not(.separador-seccion)').forEach(fila => {
                const categoria = fila.cells[0].textContent;
                const valores = {};
                
                for (let i = 1; i <= 12; i++) {
                    const input = fila.cells[i]?.querySelector('input');
                    if (input) {
                        const mes = input.dataset.mes;
                        valores[mes] = parsearMoneda(input.value);
                    }
                }
                
                cambios.push({
                    categoria: categoria,
                    valores: valores
                });
            });
            
            console.log('Cambios guardados:', cambios);
            alert('✅ Cambios guardados correctamente');
            
            // Actualizar datos originales
            EstadoApp.datosOriginales = JSON.parse(JSON.stringify(EstadoApp.datosEditados));
        }

        /**
         * Cancela los cambios y restaura los valores originales
         */
        function cancelarCambios() {
            if (confirm('¿Estás seguro de que deseas cancelar los cambios?')) {
                cargarTabla();
                alert('✖️ Cambios cancelados');
            }
        }

        // ============================================
        // INICIALIZACIÓN Y EVENTOS
        // ============================================
        
        // Cargar datos iniciales
        cargarTabla();
        
        // Evento para cambio de año
        document.getElementById('anioSelector').addEventListener('change', function(e) {
            e.preventDefault();
            if (confirm('¿Cambiar de año? Se perderán los cambios no guardados.')) {
                cargarTabla();
            } else {
                this.value = EstadoApp.anioActual;
            }
        });
        
        // Evento para botón Guardar
        document.getElementById('btnGuardar').addEventListener('click', function() {
            guardarCambios();
        });
        
        // Evento para botón Cancelar
        document.getElementById('btnCancelar').addEventListener('click', function() {
            cancelarCambios();
        });
        
        console.log('✅ Presupuestos inicializado correctamente');
        console.log('📊 Versión: 3.0.0 - Tabla completa');
        
    })();
</script>
@endsection