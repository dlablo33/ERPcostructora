@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estados de Flujo de Efectivo -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Estados de Flujo de Efectivo
                    </h2>
                    <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="color: #6c757d; font-size: 14px;">Período:</span>
                            <select id="periodoSelector" style="padding: 6px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; background-color: white; color: #083CAE; font-weight: 500;">
                                <option value="Ene-Mar 2026">Ene-Mar 2026</option>
                                <option value="Abr-Jun 2026">Abr-Jun 2026</option>
                                <option value="Jul-Sep 2026">Jul-Sep 2026</option>
                                <option value="Oct-Dic 2026" selected>Oct-Dic 2026</option>
                                <option value="Anual 2026">Anual 2026</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Resumen de Efectivo - ARRIBA con fondo blanco y margen azul -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
                    <!-- Saldo Inicial -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-coins" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Saldo Inicial</span>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="resumenInicial">$12,450,000</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Flujo Neto -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-arrow-trend-up" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Flujo Neto del Período</span>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="resumenFlujo">+$1,245,890</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Saldo Final -->
                    <div style="background-color: white; border: 2px solid #083CAE; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 48px; height: 48px; background-color: #f0f4ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #083CAE;">
                                <i class="fas fa-wallet" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <span style="font-size: 13px; color: #6c757d; font-weight: 400;">Saldo Final</span>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="resumenFinal">$13,695,890</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div style="display: flex; gap: 10px;">
                        <button id="btnExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="Exportar a Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button id="btnPDF" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="Exportar a PDF">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                        <button id="btnImprimir" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" title="Imprimir">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                    <div style="background-color: #f0f4ff; padding: 8px 20px; border-radius: 20px; border-left: 3px solid #083CAE;">
                        <span style="font-size: 14px; color: #083CAE; font-weight: 600;">Flujo Neto del Período: </span>
                        <span style="font-size: 16px; color: #083CAE; font-weight: 700;" id="flujoNeto">$+1,245,890</span>
                    </div>
                </div>

                <!-- Tabla de Flujo de Efectivo -->
                <div style="width: 100%; overflow-x: auto; margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="background-color: #083CAE;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: left; background-color: #083CAE; color: white; width: 300px;">Concepto</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Período Actual</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Período Anterior</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #083CAE; color: white; width: 150px;">Variación</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; background-color: #e9ecef; font-weight: bold;">INCREMENTO/DISMINUCIÓN NETA DE EFECTIVO</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalActual">$1,245,890</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAnterior">$987,650</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 15px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalVariacion">+$258,240</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Leyenda -->
                <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #083CAE; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Sección Principal</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #e3f2fd; border: 1px solid #083CAE; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Subsección</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <div style="width: 12px; height: 12px; background-color: #f5f5f5; border: 1px solid #dee2e6; border-radius: 2px;"></div>
                        <span style="font-size: 11px; color: #6c757d;">Partida</span>
                    </div>
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
       ESTILOS DE BOTONES
       ============================================ */
    #btnExcel, #btnPDF, #btnImprimir {
        background-color: #2CBF1F;
        color: white;
        border: none;
        border-radius: 4px;
        width: 36px;
        height: 36px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #btnExcel:hover, #btnPDF:hover, #btnImprimir:hover {
        background-color: #22991a;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    #btnExcel:active, #btnPDF:active, #btnImprimir:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    /* ============================================
       ESTILOS DE TABLA
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
        padding: 12px 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 13px;
        padding: 10px 15px;
        color: #000000;
    }
    
    /* Estilo para secciones principales */
    .seccion-principal {
        background-color: #f0f4ff !important;
        font-weight: 600;
        border-top: 2px solid #083CAE;
    }
    
    .seccion-principal td:first-child {
        font-weight: 700;
        color: #083CAE;
    }
    
    /* Estilo para subsecciones */
    .subseccion {
        background-color: #e3f2fd !important;
    }
    
    .subseccion td:first-child {
        padding-left: 30px !important;
        font-weight: 500;
    }
    
    /* Estilo para partidas individuales */
    .partida {
        background-color: #ffffff;
    }
    
    .partida td:first-child {
        padding-left: 50px !important;
    }
    
    /* Estilo para totales de sección */
    .total-seccion {
        background-color: #f5f5f5 !important;
        font-weight: 600;
        border-top: 1px dashed #083CAE;
        border-bottom: 1px dashed #083CAE;
    }
    
    .total-seccion td {
        font-weight: 600;
    }
    
    /* Estilo para números positivos/negativos */
    .texto-positivo {
        color: #2CBF1F !important;
        font-weight: 500;
    }
    
    .texto-negativo {
        color: #dc3545 !important;
        font-weight: 500;
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
        font-size: 13px;
    }
    
    /* ============================================
       ESTILOS PARA EL SELECTOR DE PERÍODO
       ============================================ */
    #periodoSelector {
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
    
    #periodoSelector:hover {
        background-color: #083CAE;
        color: white;
    }
    
    #periodoSelector:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.3);
    }
    
    /* ============================================
       ESTILOS PARA TARJETAS DE RESUMEN - Fondo blanco, margen azul
       ============================================ */
    .resumen-card {
        transition: transform 0.2s ease;
    }
    
    .resumen-card:hover {
        transform: translateY(-2px);
    }
    
    /* ============================================
       ESTILOS PARA LA BARRA DE SCROLL
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
        
        .table td, .table th {
            padding: 8px 10px;
            font-size: 11px;
        }
        
        .resumen-card {
            padding: 10px;
        }
        
        /* Ajuste para las cards en responsive */
        div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // ESTADOS DE FLUJO DE EFECTIVO
    // VERSIÓN: 1.0.0
    // FECHA: 2026
    // ============================================

    (function() {
        'use strict';
        
        // ============================================
        // CONFIGURACIÓN GLOBAL
        // ============================================
        const CONFIG = {
            PERIODOS: ['Ene-Mar 2026', 'Abr-Jun 2026', 'Jul-Sep 2026', 'Oct-Dic 2026', 'Anual 2026'],
            FORMATO_MONEDA: 'en-US',
            DECIMALES: 0,
            SEPARADOR_MILES: ',',
            SIMBOLO_MONEDA: '$'
        };
        
        // ============================================
        // ESTADO DE LA APLICACIÓN
        // ============================================
        const EstadoApp = {
            periodoActual: 'Oct-Dic 2026',
            saldoInicial: 12450000,
            datosCargados: false
        };
        
        // ============================================
        // DATOS DE FLUJO DE EFECTIVO
        // ============================================
        
        /**
         * Datos para Oct-Dic 2026
         */
        const datosOctDic2026 = [
            // ========================================
            // ACTIVIDADES DE OPERACIÓN
            // ========================================
            {
                concepto: 'ACTIVIDADES DE OPERACIÓN',
                esSeccion: true,
                periodoActual: 0,
                periodoAnterior: 0,
                variacion: 0
            },
            {
                concepto: 'Cobro a clientes',
                esPartida: true,
                periodoActual: 8500000,
                periodoAnterior: 8200000,
                variacion: 300000
            },
            {
                concepto: 'Pago a proveedores',
                esPartida: true,
                periodoActual: -3200000,
                periodoAnterior: -3100000,
                variacion: -100000
            },
            {
                concepto: 'Pago de nómina',
                esPartida: true,
                periodoActual: -1850000,
                periodoAnterior: -1820000,
                variacion: -30000
            },
            {
                concepto: 'Pago de impuestos',
                esPartida: true,
                periodoActual: -950000,
                periodoAnterior: -920000,
                variacion: -30000
            },
            {
                concepto: 'Otros ingresos de operación',
                esPartida: true,
                periodoActual: 450000,
                periodoAnterior: 420000,
                variacion: 30000
            },
            {
                concepto: 'Otros gastos de operación',
                esPartida: true,
                periodoActual: -380000,
                periodoAnterior: -350000,
                variacion: -30000
            },
            {
                concepto: 'Flujo neto de operación',
                esTotal: true,
                periodoActual: 2470000,
                periodoAnterior: 2330000,
                variacion: 140000
            },
            
            // ========================================
            // ACTIVIDADES DE INVERSIÓN
            // ========================================
            {
                concepto: 'ACTIVIDADES DE INVERSIÓN',
                esSeccion: true,
                periodoActual: 0,
                periodoAnterior: 0,
                variacion: 0
            },
            {
                concepto: 'Venta de activo fijo',
                esPartida: true,
                periodoActual: 850000,
                periodoAnterior: 600000,
                variacion: 250000
            },
            {
                concepto: 'Compra de maquinaria',
                esPartida: true,
                periodoActual: -1200000,
                periodoAnterior: -800000,
                variacion: -400000
            },
            {
                concepto: 'Compra de equipo de transporte',
                esPartida: true,
                periodoActual: -450000,
                periodoAnterior: -350000,
                variacion: -100000
            },
            {
                concepto: 'Compra de software',
                esPartida: true,
                periodoActual: -180000,
                periodoAnterior: -150000,
                variacion: -30000
            },
            {
                concepto: 'Inversiones temporales',
                esPartida: true,
                periodoActual: -500000,
                periodoAnterior: -400000,
                variacion: -100000
            },
            {
                concepto: 'Flujo neto de inversión',
                esTotal: true,
                periodoActual: -1480000,
                periodoAnterior: -1100000,
                variacion: -380000
            },
            
            // ========================================
            // ACTIVIDADES DE FINANCIAMIENTO
            // ========================================
            {
                concepto: 'ACTIVIDADES DE FINANCIAMIENTO',
                esSeccion: true,
                periodoActual: 0,
                periodoAnterior: 0,
                variacion: 0
            },
            {
                concepto: 'Préstamos bancarios',
                esPartida: true,
                periodoActual: 1500000,
                periodoAnterior: 1000000,
                variacion: 500000
            },
            {
                concepto: 'Aportaciones de capital',
                esPartida: true,
                periodoActual: 800000,
                periodoAnterior: 600000,
                variacion: 200000
            },
            {
                concepto: 'Pago de préstamos',
                esPartida: true,
                periodoActual: -950000,
                periodoAnterior: -800000,
                variacion: -150000
            },
            {
                concepto: 'Pago de dividendos',
                esPartida: true,
                periodoActual: -250000,
                periodoAnterior: -200000,
                variacion: -50000
            },
            {
                concepto: 'Pago de intereses',
                esPartida: true,
                periodoActual: -320000,
                periodoAnterior: -280000,
                variacion: -40000
            },
            {
                concepto: 'Flujo neto de financiamiento',
                esTotal: true,
                periodoActual: 780000,
                periodoAnterior: 520000,
                variacion: 260000
            },
            
            // ========================================
            // EFECTO NETO EN EFECTIVO
            // ========================================
            {
                concepto: 'EFECTO NETO EN EFECTIVO',
                esSeccion: true,
                periodoActual: 0,
                periodoAnterior: 0,
                variacion: 0
            },
            {
                concepto: 'Incremento/Disminución neta de efectivo',
                esTotal: true,
                periodoActual: 1770000,
                periodoAnterior: 1750000,
                variacion: 20000
            },
            {
                concepto: 'Efectivo al inicio del período',
                esPartida: true,
                periodoActual: 12450000,
                periodoAnterior: 11800000,
                variacion: 650000
            },
            {
                concepto: 'Efectivo al final del período',
                esTotal: true,
                periodoActual: 14220000,
                periodoAnterior: 13550000,
                variacion: 670000
            }
        ];

        /**
         * Datos para otros períodos (simplificados con variaciones)
         */
        const datosEneMar2026 = JSON.parse(JSON.stringify(datosOctDic2026));
        const datosAbrJun2026 = JSON.parse(JSON.stringify(datosOctDic2026));
        const datosJulSep2026 = JSON.parse(JSON.stringify(datosOctDic2026));
        const datosAnual2026 = JSON.parse(JSON.stringify(datosOctDic2026));

        // Ajustar valores para Ene-Mar 2026
        datosEneMar2026.forEach(item => {
            if (!item.esSeccion) {
                item.periodoActual = Math.round(item.periodoActual * 0.85);
                item.periodoAnterior = Math.round(item.periodoAnterior * 0.82);
                item.variacion = item.periodoActual - item.periodoAnterior;
            }
        });

        // Ajustar valores para Abr-Jun 2026
        datosAbrJun2026.forEach(item => {
            if (!item.esSeccion) {
                item.periodoActual = Math.round(item.periodoActual * 0.92);
                item.periodoAnterior = Math.round(item.periodoAnterior * 0.88);
                item.variacion = item.periodoActual - item.periodoAnterior;
            }
        });

        // Ajustar valores para Jul-Sep 2026
        datosJulSep2026.forEach(item => {
            if (!item.esSeccion) {
                item.periodoActual = Math.round(item.periodoActual * 0.96);
                item.periodoAnterior = Math.round(item.periodoAnterior * 0.94);
                item.variacion = item.periodoActual - item.periodoAnterior;
            }
        });

        // Ajustar valores para Anual 2026 (suma de trimestres aproximada)
        datosAnual2026.forEach(item => {
            if (!item.esSeccion) {
                item.periodoActual = Math.round(item.periodoActual * 3.8);
                item.periodoAnterior = Math.round(item.periodoAnterior * 3.6);
                item.variacion = item.periodoActual - item.periodoAnterior;
            }
        });

        // ============================================
        // MAPEO DE DATOS POR PERÍODO
        // ============================================
        const DATOS_POR_PERIODO = {
            'Ene-Mar 2026': datosEneMar2026,
            'Abr-Jun 2026': datosAbrJun2026,
            'Jul-Sep 2026': datosJulSep2026,
            'Oct-Dic 2026': datosOctDic2026,
            'Anual 2026': datosAnual2026
        };

        // ============================================
        // FUNCIONES DE UTILIDAD
        // ============================================

        /**
         * Formatea un número a moneda
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
         * Formatea variación con signo
         */
        function formatearVariacion(valor) {
            if (valor === null || valor === undefined || isNaN(valor)) {
                return '$0';
            }
            
            const signo = valor > 0 ? '+' : (valor < 0 ? '-' : '');
            const valorAbsoluto = Math.abs(valor);
            const formateado = Math.round(valorAbsoluto).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            
            return signo + '$' + formateado;
        }

        /**
         * Obtiene los datos según el período seleccionado
         */
        function obtenerDatosPeriodo(periodo) {
            return JSON.parse(JSON.stringify(DATOS_POR_PERIODO[periodo] || datosOctDic2026));
        }

        /**
         * Carga la tabla con los datos del período seleccionado
         */
        function cargarTabla() {
            const tbody = document.getElementById('tablaBody');
            if (!tbody) return;
            
            const periodoSeleccionado = document.getElementById('periodoSelector').value;
            EstadoApp.periodoActual = periodoSeleccionado;
            
            const datosCompletos = obtenerDatosPeriodo(periodoSeleccionado);
            
            tbody.innerHTML = '';
            
            // Generar filas
            datosCompletos.forEach((item, index) => {
                const tr = document.createElement('tr');
                
                if (item.esSeccion) {
                    tr.className = 'seccion-principal';
                } else if (item.esTotal) {
                    tr.className = 'total-seccion';
                } else {
                    tr.className = 'partida';
                }
                
                // Aplicar clase especial para subsecciones (conceptos con mayúsculas pero no sección)
                if (!item.esSeccion && !item.esTotal && item.concepto === item.concepto.toUpperCase() && item.concepto.length > 5) {
                    tr.className = 'subseccion';
                }
                
                // Determinar clase para el valor de variación
                const variacionClass = item.variacion > 0 ? 'texto-positivo' : (item.variacion < 0 ? 'texto-negativo' : '');
                
                tr.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 8px 15px;">${item.concepto}</td>
                    <td style="border: 1px solid #dee2e6; padding: 8px 15px; text-align: right; ${item.periodoActual < 0 ? 'color: #dc3545;' : ''}">${formatearMoneda(item.periodoActual)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 8px 15px; text-align: right; ${item.periodoAnterior < 0 ? 'color: #dc3545;' : ''}">${formatearMoneda(item.periodoAnterior)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 8px 15px; text-align: right; ${variacionClass}" class="${variacionClass}">${formatearVariacion(item.variacion)}</td>
                `;
                
                tbody.appendChild(tr);
            });
            
            // Actualizar totales del pie
            const flujoNeto = datosCompletos.find(item => item.concepto === 'Incremento/Disminución neta de efectivo');
            if (flujoNeto) {
                document.getElementById('totalActual').textContent = formatearMoneda(flujoNeto.periodoActual);
                document.getElementById('totalAnterior').textContent = formatearMoneda(flujoNeto.periodoAnterior);
                document.getElementById('totalVariacion').textContent = formatearVariacion(flujoNeto.variacion);
                document.getElementById('totalVariacion').className = flujoNeto.variacion > 0 ? 'texto-positivo' : (flujoNeto.variacion < 0 ? 'texto-negativo' : '');
                
                document.getElementById('flujoNeto').textContent = (flujoNeto.periodoActual > 0 ? '+' : '') + formatearMoneda(flujoNeto.periodoActual);
                document.getElementById('flujoNeto').style.color = '#083CAE';
            }
            
            // Actualizar resumen
            const efectivoInicial = datosCompletos.find(item => item.concepto === 'Efectivo al inicio del período');
            const efectivoFinal = datosCompletos.find(item => item.concepto === 'Efectivo al final del período');
            
            if (efectivoInicial) {
                document.getElementById('resumenInicial').textContent = formatearMoneda(efectivoInicial.periodoActual);
                EstadoApp.saldoInicial = efectivoInicial.periodoActual;
            }
            
            if (efectivoFinal) {
                document.getElementById('resumenFinal').textContent = formatearMoneda(efectivoFinal.periodoActual);
            }
            
            if (flujoNeto) {
                document.getElementById('resumenFlujo').textContent = (flujoNeto.periodoActual > 0 ? '+' : '') + formatearMoneda(flujoNeto.periodoActual);
            }
            
            EstadoApp.datosCargados = true;
        }

        // ============================================
        // INICIALIZACIÓN Y EVENTOS
        // ============================================
        
        // Cargar datos iniciales
        cargarTabla();
        
        // Evento para cambio de período
        document.getElementById('periodoSelector').addEventListener('change', function(e) {
            e.preventDefault();
            cargarTabla();
        });
        
        // Eventos de botones
        document.getElementById('btnExcel').addEventListener('click', function() {
            alert('Funcionalidad: Exportar a Excel');
        });
        
        document.getElementById('btnPDF').addEventListener('click', function() {
            alert('Funcionalidad: Exportar a PDF');
        });
        
        document.getElementById('btnImprimir').addEventListener('click', function() {
            alert('Funcionalidad: Imprimir');
        });
        
        console.log('✅ Estados de Flujo de Efectivo inicializado correctamente');
        console.log('📊 Versión: 1.0.0');
        
    })();
</script>
@endsection