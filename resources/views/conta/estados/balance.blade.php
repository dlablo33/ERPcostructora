@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Balance General -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #2378e1; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Balance General
                    </h2>
                    <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #6c757d; font-size: 14px;">Al día de:</span>
                        <select id="mesSelector" style="padding: 6px 12px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; background-color: white; color: #2378e1; font-weight: 500;">
                            <option value="Enero 2026">Enero 2026</option>
                            <option value="Febrero 2026" selected>Febrero 2026</option>
                            <option value="Marzo 2026">Marzo 2026</option>
                            <option value="Abril 2026">Abril 2026</option>
                            <option value="Mayo 2026">Mayo 2026</option>
                            <option value="Junio 2026">Junio 2026</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Mensaje "Sin datos" centrado (oculto por defecto) -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-balance-scale" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
                </div>

                <!-- Tabla de Balance General -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <table class="table table-bordered" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 10; background-color: #2378e1;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #2378e1; color: white; width: 120px;">Num. Cuenta</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #2378e1; color: white;">Cuenta</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #2378e1; color: white; width: 150px;">Saldo Final</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 10; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="2" style="border: 1px solid #dee2e6; padding: 12px 8px; background-color: #e9ecef; font-weight: bold;">TOTAL PASIVO + CAPITAL</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalGeneral">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Leyenda de colores -->
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
    
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #2378e1;
        border-radius: 8px 8px 0 0;
    }
    
    .semaforo .card-header h2 {
        color: #2378e1 !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
    }
    
    /* ============================================
       ESTILOS DE TABLA
       ============================================ */
    .table {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 12px 8px;
        color: #000000;
        transition: background-color 0.2s ease;
    }
    
    /* ============================================
       ESTILOS PARA FILAS EXPANDIBLES
       ============================================ */
    .fila-expandible {
        cursor: pointer;
        background-color: #f0f4ff !important;
        font-weight: bold;
        border-left: 3px solid #2378e1;
    }
    
    .fila-expandible:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-expandible i {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #2378e1;
        margin-right: 8px;
        cursor: pointer;
        font-size: 12px;
    }
    
    .fila-expandible i.fa-chevron-right {
        transform: rotate(0deg);
    }
    
    .fila-expandible i.fa-chevron-down {
        transform: rotate(90deg);
    }
    
    /* ============================================
       ESTILOS PARA SUBCUENTAS POR NIVEL
       ============================================ */
    /* Nivel 1 (Subcuentas directas) */
    .subcuenta-nivel1 {
        background-color: #ffffff;
    }
    
    .subcuenta-nivel1 td:first-child {
        padding-left: 40px !important;
    }
    
    .subcuenta-nivel1:hover {
        background-color: #f2f2f2;
    }
    
    /* Nivel 2 */
    .subcuenta-nivel2 {
        background-color: #f9f9f9;
    }
    
    .subcuenta-nivel2 td:first-child {
        padding-left: 60px !important;
    }
    
    .subcuenta-nivel2:hover {
        background-color: #f0f0f0;
    }
    
    /* Nivel 3 */
    .subcuenta-nivel3 {
        background-color: #f5f5f5;
    }
    
    .subcuenta-nivel3 td:first-child {
        padding-left: 80px !important;
    }
    
    .subcuenta-nivel3:hover {
        background-color: #eaeaea;
    }
    
    /* Nivel 4 */
    .subcuenta-nivel4 {
        background-color: #f2f2f2;
    }
    
    .subcuenta-nivel4 td:first-child {
        padding-left: 100px !important;
    }
    
    .subcuenta-nivel4:hover {
        background-color: #e5e5e5;
    }
    
    /* Nivel 5 */
    .subcuenta-nivel5 {
        background-color: #efefef;
    }
    
    .subcuenta-nivel5 td:first-child {
        padding-left: 120px !important;
    }
    
    /* ============================================
       ESTILOS PARA NÚMEROS NEGATIVOS
       ============================================ */
    .texto-negativo {
        color: #dc3545 !important;
        font-weight: 500;
    }
    
    /* ============================================
       ESTILOS PARA EL PIE DE TABLA
       ============================================ */
    tfoot td {
        background-color: #e9ecef !important;
        border-top: 2px solid #2378e1;
        color: #000000 !important;
        font-weight: bold;
        font-size: 13px;
    }
    
    /* ============================================
       ESTILOS PARA EL SELECTOR DE MES
       ============================================ */
    #mesSelector {
        padding: 8px 16px;
        border: 2px solid #2378e1;
        border-radius: 6px;
        font-size: 14px;
        background-color: white;
        color: #2378e1;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    #mesSelector:hover {
        background-color: #2378e1;
        color: white;
    }
    
    #mesSelector:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(35, 120, 225, 0.3);
    }
    
    /* ============================================
       ESTILOS PARA LA BARRA DE SCROLL
       ============================================ */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #2378e1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #1a5bbf;
    }
    
    /* ============================================
       ESTILOS RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        select {
            width: 100% !important;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .semaforo .card-header div {
            flex-direction: column;
            gap: 10px;
        }
        
        .semaforo .card-header h2 {
            font-size: 18px;
        }
    }
    
    /* ============================================
       ESTILOS PARA IMPRESIÓN
       ============================================ */
    @media print {
        .table-responsive {
            max-height: none;
            overflow: visible;
        }
        
        tfoot {
            position: static;
        }
        
        thead {
            position: static;
        }
        
        #mesSelector {
            display: none;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // BALANCE GENERAL - SISTEMA CONTABLE
    // VERSIÓN: 2.0.0
    // FECHA: 2026
    // DESARROLLADO PARA: SEMAFORO FINANCIERO
    // ============================================

    (function() {
        'use strict';
        
        // ============================================
        // CONFIGURACIÓN GLOBAL
        // ============================================
        const CONFIG = {
            ANIO_ACTUAL: 2026,
            MESES_DISPONIBLES: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            FORMATO_MONEDA: 'en-US',
            DECIMALES: 2,
            SEPARADOR_MILES: ',',
            SIMBOLO_MONEDA: '$'
        };
        
        // ============================================
        // ESTADO DE LA APLICACIÓN
        // ============================================
        const EstadoApp = {
            expandedCuentas: new Set(), // Inicialmente vacío (todo contraído)
            mesActual: 'Febrero 2026',
            datosCargados: false,
            totalRegistros: 0
        };
        
        // ============================================
        // ESTRUCTURA DE DATOS - NIVEL 1 (CUENTAS PRINCIPALES)
        // ============================================
        
        /**
         * Datos para Febrero 2026 - Estructura completa de 5 niveles
         * @type {Array}
         */
        const datosFebrero = [
            // ========================================
            // CUENTA 100 - ACTIVO
            // ========================================
            {
                numero: '100',
                nombre: 'ACTIVO',
                saldo: 76034.60,
                expandible: true,
                subcuentas: [
                    // ========================================
                    // NIVEL 2 - ACTIVO CIRCULANTE
                    // ========================================
                    { 
                        numero: '110',
                        nombre: 'ACTIVO CIRCULANTE',
                        saldo: 45000.00,
                        expandible: true,
                        subcuentas: [
                            // NIVEL 3 - EFECTIVO
                            {
                                numero: '111',
                                nombre: 'EFECTIVO Y EQUIVALENTES',
                                saldo: 15000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '111-01', nombre: 'Caja chica', saldo: 5000.00 },
                                    { numero: '111-02', nombre: 'Bancos', saldo: 8000.00 },
                                    { numero: '111-03', nombre: 'Inversiones temporales', saldo: 2000.00 }
                                ]
                            },
                            // NIVEL 3 - CUENTAS POR COBRAR
                            {
                                numero: '112',
                                nombre: 'CUENTAS POR COBRAR',
                                saldo: 18000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '112-01', nombre: 'Clientes', saldo: 12000.00 },
                                    { numero: '112-02', nombre: 'Deudores diversos', saldo: 4000.00 },
                                    { numero: '112-03', nombre: 'Funcionarios y empleados', saldo: 2000.00 }
                                ]
                            },
                            // NIVEL 3 - INVENTARIOS
                            {
                                numero: '113',
                                nombre: 'INVENTARIOS',
                                saldo: 12000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '113-01', nombre: 'Materia prima', saldo: 5000.00 },
                                    { numero: '113-02', nombre: 'Producción en proceso', saldo: 3000.00 },
                                    { numero: '113-03', nombre: 'Producto terminado', saldo: 4000.00 }
                                ]
                            }
                        ]
                    },
                    // ========================================
                    // NIVEL 2 - ACTIVO NO CIRCULANTE
                    // ========================================
                    { 
                        numero: '120',
                        nombre: 'ACTIVO NO CIRCULANTE',
                        saldo: 31034.60,
                        expandible: true,
                        subcuentas: [
                            // NIVEL 3 - PROPIEDAD, PLANTA Y EQUIPO
                            {
                                numero: '121',
                                nombre: 'PROPIEDAD, PLANTA Y EQUIPO',
                                saldo: 25000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '121-01', nombre: 'Terrenos', saldo: 10000.00 },
                                    { numero: '121-02', nombre: 'Edificios', saldo: 8000.00 },
                                    { numero: '121-03', nombre: 'Maquinaria y equipo', saldo: 5000.00 },
                                    { numero: '121-04', nombre: 'Equipo de transporte', saldo: 2000.00 }
                                ]
                            },
                            // NIVEL 3 - ACTIVOS INTANGIBLES
                            {
                                numero: '122',
                                nombre: 'ACTIVOS INTANGIBLES',
                                saldo: 6034.60,
                                expandible: true,
                                subcuentas: [
                                    { numero: '122-01', nombre: 'Patentes', saldo: 2000.00 },
                                    { numero: '122-02', nombre: 'Marcas', saldo: 1500.00 },
                                    { numero: '122-03', nombre: 'Licencias', saldo: 2534.60 }
                                ]
                            }
                        ]
                    }
                ]
            },
            
            // ========================================
            // CUENTA 200 - PASIVO
            // ========================================
            {
                numero: '200',
                nombre: 'PASIVO',
                saldo: 129050.26,
                expandible: true,
                subcuentas: [
                    // ========================================
                    // NIVEL 2 - PASIVO CIRCULANTE
                    // ========================================
                    { 
                        numero: '210',
                        nombre: 'PASIVO CIRCULANTE',
                        saldo: 89050.26,
                        expandible: true,
                        subcuentas: [
                            // NIVEL 3 - PROVEEDORES
                            {
                                numero: '211',
                                nombre: 'PROVEEDORES',
                                saldo: 35000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '211-01', nombre: 'Proveedores nacionales', saldo: 25000.00 },
                                    { numero: '211-02', nombre: 'Proveedores internacionales', saldo: 10000.00 }
                                ]
                            },
                            // NIVEL 3 - ACREEDORES
                            {
                                numero: '212',
                                nombre: 'ACREEDORES DIVERSOS',
                                saldo: 29050.26,
                                expandible: true,
                                subcuentas: [
                                    { numero: '212-01', nombre: 'Acreedores bancarios', saldo: 15000.00 },
                                    { numero: '212-02', nombre: 'Acreedores comerciales', saldo: 14050.26 }
                                ]
                            },
                            // NIVEL 3 - IMPUESTOS
                            {
                                numero: '213',
                                nombre: 'IMPUESTOS POR PAGAR',
                                saldo: 25000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '213-01', nombre: 'ISR por pagar', saldo: 15000.00 },
                                    { numero: '213-02', nombre: 'IVA por pagar', saldo: 8000.00 },
                                    { numero: '213-03', nombre: 'IMSS por pagar', saldo: 2000.00 }
                                ]
                            }
                        ]
                    },
                    // ========================================
                    // NIVEL 2 - PASIVO NO CIRCULANTE
                    // ========================================
                    { 
                        numero: '220',
                        nombre: 'PASIVO NO CIRCULANTE',
                        saldo: 40000.00,
                        expandible: true,
                        subcuentas: [
                            // NIVEL 3 - PRÉSTAMOS BANCARIOS
                            {
                                numero: '221',
                                nombre: 'PRÉSTAMOS BANCARIOS',
                                saldo: 30000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '221-01', nombre: 'Préstamo corto plazo', saldo: 10000.00 },
                                    { numero: '221-02', nombre: 'Préstamo largo plazo', saldo: 20000.00 }
                                ]
                            },
                            // NIVEL 3 - OBLIGACIONES
                            {
                                numero: '222',
                                nombre: 'OBLIGACIONES POR PAGAR',
                                saldo: 10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '222-01', nombre: 'Obligaciones laborales', saldo: 6000.00 },
                                    { numero: '222-02', nombre: 'Obligaciones fiscales', saldo: 4000.00 }
                                ]
                            }
                        ]
                    }
                ]
            },
            
            // ========================================
            // CUENTA 300 - CAPITAL CONTABLE
            // ========================================
            {
                numero: '300',
                nombre: 'CAPITAL CONTABLE',
                saldo: -53015.66,
                expandible: true,
                subcuentas: [
                    // ========================================
                    // NIVEL 2 - CAPITAL SOCIAL
                    // ========================================
                    { 
                        numero: '310',
                        nombre: 'CAPITAL SOCIAL',
                        saldo: -30000.00,
                        expandible: true,
                        subcuentas: [
                            // NIVEL 3 - CAPITAL FIJO
                            {
                                numero: '311',
                                nombre: 'CAPITAL FIJO',
                                saldo: -15000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '311-01', nombre: 'Capital fundacional', saldo: -10000.00 },
                                    { numero: '311-02', nombre: 'Aportaciones socios', saldo: -5000.00 }
                                ]
                            },
                            // NIVEL 3 - CAPITAL VARIABLE
                            {
                                numero: '312',
                                nombre: 'CAPITAL VARIABLE',
                                saldo: -10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '312-01', nombre: 'Aportaciones adicionales', saldo: -6000.00 },
                                    { numero: '312-02', nombre: 'Reinversiones', saldo: -4000.00 }
                                ]
                            },
                            // NIVEL 3 - APORTACIONES FUTURAS
                            {
                                numero: '313',
                                nombre: 'APORTACIONES FUTURAS',
                                saldo: -5000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '313-01', nombre: 'Compromisos socios', saldo: -3000.00 },
                                    { numero: '313-02', nombre: 'Pendientes capitalizar', saldo: -2000.00 }
                                ]
                            }
                        ]
                    },
                    // ========================================
                    // NIVEL 2 - RESERVAS
                    // ========================================
                    { 
                        numero: '320',
                        nombre: 'RESERVAS DE CAPITAL',
                        saldo: -10000.00,
                        expandible: true,
                        subcuentas: [
                            { numero: '321', nombre: 'Reserva legal', saldo: -5000.00 },
                            { numero: '322', nombre: 'Reserva voluntaria', saldo: -3000.00 },
                            { numero: '323', nombre: 'Reserva para reinversión', saldo: -2000.00 }
                        ]
                    },
                    // ========================================
                    // NIVEL 2 - RESULTADOS
                    // ========================================
                    { 
                        numero: '330',
                        nombre: 'RESULTADOS ACUMULADOS',
                        saldo: -13015.66,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '331',
                                nombre: 'UTILIDADES ACUMULADAS',
                                saldo: 5000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '331-01', nombre: 'Utilidades 2024', saldo: 2000.00 },
                                    { numero: '331-02', nombre: 'Utilidades 2025', saldo: 3000.00 }
                                ]
                            },
                            {
                                numero: '332',
                                nombre: 'PÉRDIDAS ACUMULADAS',
                                saldo: -15000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '332-01', nombre: 'Pérdidas 2024', saldo: -8000.00 },
                                    { numero: '332-02', nombre: 'Pérdidas 2025', saldo: -7000.00 }
                                ]
                            },
                            {
                                numero: '333',
                                nombre: 'RESULTADO DEL EJERCICIO',
                                saldo: -3015.66,
                                expandible: true,
                                subcuentas: [
                                    { numero: '333-01', nombre: 'Utilidad del periodo', saldo: 0.00 },
                                    { numero: '333-02', nombre: 'Pérdida del periodo', saldo: -3015.66 }
                                ]
                            }
                        ]
                    }
                ]
            }
        ];

        // ============================================
        // DATOS PARA ENERO 2026
        // ============================================
        const datosEnero = [
            // ACTIVO - ENERO
            {
                numero: '100',
                nombre: 'ACTIVO',
                saldo: 75000.00,
                expandible: true,
                subcuentas: [
                    { 
                        numero: '110',
                        nombre: 'ACTIVO CIRCULANTE',
                        saldo: 44000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '111',
                                nombre: 'EFECTIVO Y EQUIVALENTES',
                                saldo: 14000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '111-01', nombre: 'Caja chica', saldo: 4800.00 },
                                    { numero: '111-02', nombre: 'Bancos', saldo: 7800.00 },
                                    { numero: '111-03', nombre: 'Inversiones temporales', saldo: 1400.00 }
                                ]
                            },
                            {
                                numero: '112',
                                nombre: 'CUENTAS POR COBRAR',
                                saldo: 17500.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '112-01', nombre: 'Clientes', saldo: 11500.00 },
                                    { numero: '112-02', nombre: 'Deudores diversos', saldo: 4000.00 },
                                    { numero: '112-03', nombre: 'Funcionarios y empleados', saldo: 2000.00 }
                                ]
                            },
                            {
                                numero: '113',
                                nombre: 'INVENTARIOS',
                                saldo: 12500.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '113-01', nombre: 'Materia prima', saldo: 5200.00 },
                                    { numero: '113-02', nombre: 'Producción en proceso', saldo: 3200.00 },
                                    { numero: '113-03', nombre: 'Producto terminado', saldo: 4100.00 }
                                ]
                            }
                        ]
                    },
                    { 
                        numero: '120',
                        nombre: 'ACTIVO NO CIRCULANTE',
                        saldo: 31000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '121',
                                nombre: 'PROPIEDAD, PLANTA Y EQUIPO',
                                saldo: 25000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '121-01', nombre: 'Terrenos', saldo: 10000.00 },
                                    { numero: '121-02', nombre: 'Edificios', saldo: 8000.00 },
                                    { numero: '121-03', nombre: 'Maquinaria y equipo', saldo: 5000.00 },
                                    { numero: '121-04', nombre: 'Equipo de transporte', saldo: 2000.00 }
                                ]
                            },
                            {
                                numero: '122',
                                nombre: 'ACTIVOS INTANGIBLES',
                                saldo: 6000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '122-01', nombre: 'Patentes', saldo: 2000.00 },
                                    { numero: '122-02', nombre: 'Marcas', saldo: 1500.00 },
                                    { numero: '122-03', nombre: 'Licencias', saldo: 2500.00 }
                                ]
                            }
                        ]
                    }
                ]
            },
            // PASIVO - ENERO
            {
                numero: '200',
                nombre: 'PASIVO',
                saldo: 125000.00,
                expandible: true,
                subcuentas: [
                    { 
                        numero: '210',
                        nombre: 'PASIVO CIRCULANTE',
                        saldo: 86000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '211',
                                nombre: 'PROVEEDORES',
                                saldo: 34000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '211-01', nombre: 'Proveedores nacionales', saldo: 24000.00 },
                                    { numero: '211-02', nombre: 'Proveedores internacionales', saldo: 10000.00 }
                                ]
                            },
                            {
                                numero: '212',
                                nombre: 'ACREEDORES DIVERSOS',
                                saldo: 28000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '212-01', nombre: 'Acreedores bancarios', saldo: 14000.00 },
                                    { numero: '212-02', nombre: 'Acreedores comerciales', saldo: 14000.00 }
                                ]
                            },
                            {
                                numero: '213',
                                nombre: 'IMPUESTOS POR PAGAR',
                                saldo: 24000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '213-01', nombre: 'ISR por pagar', saldo: 14000.00 },
                                    { numero: '213-02', nombre: 'IVA por pagar', saldo: 8000.00 },
                                    { numero: '213-03', nombre: 'IMSS por pagar', saldo: 2000.00 }
                                ]
                            }
                        ]
                    },
                    { 
                        numero: '220',
                        nombre: 'PASIVO NO CIRCULANTE',
                        saldo: 39000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '221',
                                nombre: 'PRÉSTAMOS BANCARIOS',
                                saldo: 29000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '221-01', nombre: 'Préstamo corto plazo', saldo: 9000.00 },
                                    { numero: '221-02', nombre: 'Préstamo largo plazo', saldo: 20000.00 }
                                ]
                            },
                            {
                                numero: '222',
                                nombre: 'OBLIGACIONES POR PAGAR',
                                saldo: 10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '222-01', nombre: 'Obligaciones laborales', saldo: 6000.00 },
                                    { numero: '222-02', nombre: 'Obligaciones fiscales', saldo: 4000.00 }
                                ]
                            }
                        ]
                    }
                ]
            },
            // CAPITAL CONTABLE - ENERO
            {
                numero: '300',
                nombre: 'CAPITAL CONTABLE',
                saldo: -50000.00,
                expandible: true,
                subcuentas: [
                    { 
                        numero: '310',
                        nombre: 'CAPITAL SOCIAL',
                        saldo: -30000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '311',
                                nombre: 'CAPITAL FIJO',
                                saldo: -15000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '311-01', nombre: 'Capital fundacional', saldo: -10000.00 },
                                    { numero: '311-02', nombre: 'Aportaciones socios', saldo: -5000.00 }
                                ]
                            },
                            {
                                numero: '312',
                                nombre: 'CAPITAL VARIABLE',
                                saldo: -10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '312-01', nombre: 'Aportaciones adicionales', saldo: -6000.00 },
                                    { numero: '312-02', nombre: 'Reinversiones', saldo: -4000.00 }
                                ]
                            },
                            {
                                numero: '313',
                                nombre: 'APORTACIONES FUTURAS',
                                saldo: -5000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '313-01', nombre: 'Compromisos socios', saldo: -3000.00 },
                                    { numero: '313-02', nombre: 'Pendientes capitalizar', saldo: -2000.00 }
                                ]
                            }
                        ]
                    },
                    { 
                        numero: '320',
                        nombre: 'RESERVAS DE CAPITAL',
                        saldo: -10000.00,
                        expandible: true,
                        subcuentas: [
                            { numero: '321', nombre: 'Reserva legal', saldo: -5000.00 },
                            { numero: '322', nombre: 'Reserva voluntaria', saldo: -3000.00 },
                            { numero: '323', nombre: 'Reserva para reinversión', saldo: -2000.00 }
                        ]
                    },
                    { 
                        numero: '330',
                        nombre: 'RESULTADOS ACUMULADOS',
                        saldo: -10000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '331',
                                nombre: 'UTILIDADES ACUMULADAS',
                                saldo: 5000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '331-01', nombre: 'Utilidades 2024', saldo: 2000.00 },
                                    { numero: '331-02', nombre: 'Utilidades 2025', saldo: 3000.00 }
                                ]
                            },
                            {
                                numero: '332',
                                nombre: 'PÉRDIDAS ACUMULADAS',
                                saldo: -15000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '332-01', nombre: 'Pérdidas 2024', saldo: -8000.00 },
                                    { numero: '332-02', nombre: 'Pérdidas 2025', saldo: -7000.00 }
                                ]
                            }
                        ]
                    }
                ]
            }
        ];

        // ============================================
        // DATOS PARA MARZO 2026
        // ============================================
        const datosMarzo = JSON.parse(JSON.stringify(datosFebrero));
        // Modificar algunos valores para marzo
        datosMarzo[0].saldo = 77000.00;
        datosMarzo[0].subcuentas[0].saldo = 46000.00;
        datosMarzo[1].saldo = 130000.00;
        datosMarzo[1].subcuentas[0].saldo = 90000.00;
        datosMarzo[2].saldo = -53000.00;

        // ============================================
        // DATOS PARA ABRIL 2026
        // ============================================
        const datosAbril = JSON.parse(JSON.stringify(datosFebrero));
        datosAbril[0].saldo = 78500.00;
        datosAbril[0].subcuentas[0].saldo = 47500.00;
        datosAbril[1].saldo = 131500.00;
        datosAbril[1].subcuentas[0].saldo = 91500.00;
        datosAbril[2].saldo = -53000.00;

        // ============================================
        // DATOS PARA MAYO 2026
        // ============================================
        const datosMayo = JSON.parse(JSON.stringify(datosFebrero));
        datosMayo[0].saldo = 79200.00;
        datosMayo[0].subcuentas[0].saldo = 48200.00;
        datosMayo[1].saldo = 132800.00;
        datosMayo[1].subcuentas[0].saldo = 92800.00;
        datosMayo[2].saldo = -53600.00;

        // ============================================
        // DATOS PARA JUNIO 2026
        // ============================================
        const datosJunio = JSON.parse(JSON.stringify(datosFebrero));
        datosJunio[0].saldo = 80100.00;
        datosJunio[0].subcuentas[0].saldo = 49100.00;
        datosJunio[1].saldo = 134200.00;
        datosJunio[1].subcuentas[0].saldo = 94200.00;
        datosJunio[2].saldo = -54100.00;

        // ============================================
        // MAPEO DE DATOS POR MES
        // ============================================
        const DATOS_POR_MES = {
            'Enero 2026': datosEnero,
            'Febrero 2026': datosFebrero,
            'Marzo 2026': datosMarzo,
            'Abril 2026': datosAbril,
            'Mayo 2026': datosMayo,
            'Junio 2026': datosJunio
        };

        // ============================================
        // FUNCIONES DE UTILIDAD
        // ============================================

        /**
         * Formatea un número a moneda
         * @param {number} valor - El valor a formatear
         * @returns {string} Valor formateado como moneda
         */
        function formatearMoneda(valor) {
            if (valor === null || valor === undefined || isNaN(valor)) {
                return '$0.00';
            }
            
            const signo = valor < 0 ? '-' : '';
            const valorAbsoluto = Math.abs(valor);
            
            // Formatear con separadores de miles
            const partes = valorAbsoluto.toFixed(2).split('.');
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            
            return signo + '$' + partes.join('.');
        }

        /**
         * Obtiene los datos según el mes seleccionado
         * @param {string} mes - El mes seleccionado
         * @returns {Array} Datos del mes correspondiente
         */
        function obtenerDatosMes(mes) {
            return DATOS_POR_MES[mes] || datosFebrero;
        }

        /**
         * Alterna la expansión de una cuenta
         * @param {string} numeroCuenta - Número de la cuenta
         * @param {Event} event - Evento del clic
         */
        function toggleExpand(numeroCuenta, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            if (EstadoApp.expandedCuentas.has(numeroCuenta)) {
                EstadoApp.expandedCuentas.delete(numeroCuenta);
            } else {
                EstadoApp.expandedCuentas.add(numeroCuenta);
            }
            
            cargarTabla();
        }

        /**
         * Genera las filas de la tabla recursivamente
         * @param {Array} datos - Datos a procesar
         * @param {number} nivel - Nivel actual de profundidad
         * @returns {Object} Filas generadas y totales
         */
        function generarFilas(datos, nivel = 0) {
            let filas = [];
            let totalPasivo = 0;
            let totalCapital = 0;
            
            datos.forEach(cuenta => {
                // Determinar si es expandible
                const esExpandible = cuenta.subcuentas && cuenta.subcuentas.length > 0;
                const estaExpandida = EstadoApp.expandedCuentas.has(cuenta.numero);
                
                // Crear objeto de fila
                const fila = {
                    numero: cuenta.numero,
                    nombre: cuenta.nombre,
                    saldo: cuenta.saldo,
                    nivel: nivel,
                    esExpandible: esExpandible,
                    estaExpandida: estaExpandida
                };
                
                filas.push(fila);
                
                // Calcular totales para el pie de página
                if (cuenta.numero === '200' && nivel === 0) {
                    totalPasivo = cuenta.saldo;
                }
                if (cuenta.numero === '300' && nivel === 0) {
                    totalCapital = cuenta.saldo;
                }
                
                // Si está expandida y tiene subcuentas, procesarlas
                if (esExpandible && estaExpandida && cuenta.subcuentas && nivel < 5) {
                    const subResultado = generarFilas(cuenta.subcuentas, nivel + 1);
                    filas = filas.concat(subResultado.filas);
                }
            });
            
            return { filas, totalPasivo, totalCapital };
        }

        /**
         * Carga y renderiza la tabla
         */
        function cargarTabla() {
            const tbody = document.getElementById('tablaBody');
            if (!tbody) return;
            
            const mesSeleccionado = document.getElementById('mesSelector').value;
            EstadoApp.mesActual = mesSeleccionado;
            
            const datosCompletos = obtenerDatosMes(mesSeleccionado);
            const { filas, totalPasivo, totalCapital } = generarFilas(datosCompletos);
            
            EstadoApp.totalRegistros = filas.length;
            
            // Limpiar tbody
            tbody.innerHTML = '';
            
            // Verificar si hay datos
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            if (sinDatosMensaje) {
                if (filas.length === 0) {
                    sinDatosMensaje.style.display = 'block';
                    document.getElementById('totalGeneral').textContent = formatearMoneda(0);
                    return;
                } else {
                    sinDatosMensaje.style.display = 'none';
                }
            }
            
            // Generar HTML de las filas
            filas.forEach(fila => {
                const tr = document.createElement('tr');
                
                // Asignar clases según el nivel
                if (fila.nivel === 0) {
                    tr.className = 'fila-expandible';
                } else {
                    tr.className = `subcuenta-nivel${fila.nivel}`;
                }
                
                // Calcular padding izquierdo
                const paddingLeft = (fila.nivel * 20) + 8;
                
                // Crear celda de número de cuenta
                const tdNumero = document.createElement('td');
                tdNumero.style.border = '1px solid #dee2e6';
                tdNumero.style.padding = `12px 8px 12px ${paddingLeft}px`;
                tdNumero.style.color = '#000000';
                
                // Si es expandible, mostrar icono
                if (fila.esExpandible) {
                    const icono = document.createElement('i');
                    icono.className = `fas ${fila.estaExpandida ? 'fa-chevron-down' : 'fa-chevron-right'}`;
                    icono.style.marginRight = '8px';
                    icono.style.color = '#2378e1';
                    icono.style.cursor = 'pointer';
                    
                    // Evento para el icono
                    icono.addEventListener('click', (e) => toggleExpand(fila.numero, e));
                    
                    tdNumero.appendChild(icono);
                    tdNumero.appendChild(document.createTextNode(' ' + fila.numero));
                } else {
                    tdNumero.textContent = fila.numero;
                }
                
                // Crear celda de nombre
                const tdNombre = document.createElement('td');
                tdNombre.style.border = '1px solid #dee2e6';
                tdNombre.style.padding = '12px 8px';
                tdNombre.style.color = '#000000';
                tdNombre.textContent = fila.nombre;
                
                // Crear celda de saldo
                const tdSaldo = document.createElement('td');
                tdSaldo.style.border = '1px solid #dee2e6';
                tdSaldo.style.padding = '12px 8px';
                tdSaldo.style.textAlign = 'right';
                tdSaldo.style.color = fila.saldo < 0 ? '#dc3545' : '#000000';
                tdSaldo.textContent = formatearMoneda(fila.saldo);
                
                // Aplicar negritas al nivel 0
                if (fila.nivel === 0) {
                    tdNumero.style.fontWeight = 'bold';
                    tdNombre.style.fontWeight = 'bold';
                    tdSaldo.style.fontWeight = 'bold';
                }
                
                tr.appendChild(tdNumero);
                tr.appendChild(tdNombre);
                tr.appendChild(tdSaldo);
                
                tbody.appendChild(tr);
            });
            
            // Actualizar total general (Pasivo + Capital)
            const totalGeneral = totalPasivo + totalCapital;
            const totalGeneralElement = document.getElementById('totalGeneral');
            if (totalGeneralElement) {
                totalGeneralElement.textContent = formatearMoneda(totalGeneral);
            }
            
            EstadoApp.datosCargados = true;
        }

        // ============================================
        // INICIALIZACIÓN
        // ============================================
        
        // Cargar datos iniciales (todo contraído porque expandedCuentas está vacío)
        cargarTabla();
        
        // Event listener para cambio de mes
        const mesSelector = document.getElementById('mesSelector');
        if (mesSelector) {
            mesSelector.addEventListener('change', function(e) {
                e.preventDefault();
                // Limpiar expansiones al cambiar de mes
                EstadoApp.expandedCuentas.clear();
                cargarTabla();
            });
        }
        
        // Log de inicialización
        console.log('✅ Balance General inicializado correctamente');
        console.log('📊 Versión: 2.0.0');
        console.log('📅 Estado inicial: Contraído');
        
    })();
</script>
@endsection