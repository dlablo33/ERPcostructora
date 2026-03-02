@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Balanza de Comprobación -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                    <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                        Balanza de Comprobación
                    </h2>
                    <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 10px;">
                        <span style="color: #083CAE; font-size: 14px;">Al día de:</span>
                        <select id="mesSelector" style="padding: 6px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; background-color: white; color: #083CAE; font-weight: 500;">
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
                <!-- Barra de botones superior -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <!-- Título o espacio vacío a la izquierda -->
                    <div></div>
                    
                    <!-- Botones de la derecha - Solo iconos -->
                    <div style="display: flex; gap: 8px;">
                        <!-- Botón Expandir por niveles -->
                        <button id="btnExpandir" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Expandir por niveles">
                            <i class="fas fa-plus"></i>
                        </button>
                        
                        <!-- Botón Contraer por niveles -->
                        <button id="btnContraer" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Contraer por niveles">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                        <!-- Botón Excel -->
                        <button id="btnExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Exportar a Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        
                        <!-- Botón Catálogo -->
                        <button id="btnCatalogo" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Descargar catálogo">
                            <i class="fas fa-download"></i>
                        </button>
                        
                        <!-- Botón Balanza -->
                        <button id="btnBalanza" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Ver balanza">
                            <i class="fas fa-file-alt"></i>
                            <i class="fas fa-arrow-right" style="font-size: 10px; margin-left: -3px;"></i>
                        </button>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado (oculto por defecto) -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #083CAE; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-balance-scale" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para el período seleccionado</p>
                </div>

                <!-- Tabla de Balanza de Comprobación -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 550px; overflow-y: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <table class="table table-bordered" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 10; background-color: #083CAE;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #083CAE; color: white; width: 100px;">Num. Cuenta</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #083CAE; color: white;">Cuenta</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: center; background-color: #083CAE; color: white; width: 90px;">Naturaleza</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 130px;">Saldo Inicial</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 110px;">Cargos</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 110px;">Abonos</th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #083CAE; color: white; width: 130px;">Saldo Final</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 10; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="3" style="border: 1px solid #dee2e6; padding: 12px 8px; background-color: #e9ecef; font-weight: bold; text-align: right;">TOTALES</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalSaldoInicial">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalCargos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalAbonos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #e9ecef; font-weight: bold;" id="totalSaldoFinal">$0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Indicador de nivel actual -->
                <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                    <div style="background-color: #f0f4ff; padding: 5px 15px; border-radius: 20px; border-left: 3px solid #083CAE;">
                        <span style="font-size: 12px; color: #083CAE; font-weight: 600;" id="nivelActual">Nivel 0 / 5</span>
                    </div>
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
        border-bottom: 2px solid #083CAE;
        border-radius: 8px 8px 0 0;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
    }
    
    /* ============================================
       ESTILOS DE BOTONES - Solo iconos
       ============================================ */
    #btnExpandir, #btnContraer, #btnExcel, #btnCatalogo, #btnBalanza {
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
    
    #btnExpandir:hover, #btnContraer:hover, #btnExcel:hover, #btnCatalogo:hover, #btnBalanza:hover {
        background-color: #22991a;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    #btnExpandir:active, #btnContraer:active, #btnExcel:active, #btnCatalogo:active, #btnBalanza:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    /* Estilo especial para el botón Balanza con dos iconos */
    #btnBalanza {
        position: relative;
    }
    
    #btnBalanza i.fa-arrow-right {
        font-size: 10px;
        margin-left: -3px;
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
        padding: 12px 8px;
        color: #000000;
        transition: background-color 0.2s ease;
    }
    
    /* ============================================
       ESTILOS PARA NATURALEZA DE CUENTAS
       ============================================ */
    .naturaleza-deudora {
        background-color: #d4edda !important;
        color: #155724 !important;
        font-weight: 600;
        text-align: center;
    }
    
    .naturaleza-acreedora {
        background-color: #fff3cd !important;
        color: #856404 !important;
        font-weight: 600;
        text-align: center;
    }
    
    /* ============================================
       ESTILOS PARA FILAS EXPANDIBLES
       ============================================ */
    .fila-expandible {
        cursor: pointer;
        background-color: #f0f4ff !important;
        font-weight: bold;
        border-left: 3px solid #083CAE;
    }
    
    .fila-expandible:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-expandible i {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #083CAE;
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
    .subcuenta-nivel1 {
        background-color: #ffffff;
    }
    
    .subcuenta-nivel1 td:first-child {
        padding-left: 40px !important;
    }
    
    .subcuenta-nivel1:hover {
        background-color: #f2f2f2;
    }
    
    .subcuenta-nivel2 {
        background-color: #f9f9f9;
    }
    
    .subcuenta-nivel2 td:first-child {
        padding-left: 60px !important;
    }
    
    .subcuenta-nivel2:hover {
        background-color: #f0f0f0;
    }
    
    .subcuenta-nivel3 {
        background-color: #f5f5f5;
    }
    
    .subcuenta-nivel3 td:first-child {
        padding-left: 80px !important;
    }
    
    .subcuenta-nivel3:hover {
        background-color: #eaeaea;
    }
    
    .subcuenta-nivel4 {
        background-color: #f2f2f2;
    }
    
    .subcuenta-nivel4 td:first-child {
        padding-left: 100px !important;
    }
    
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
        border-top: 2px solid #083CAE;
        color: #000000 !important;
        font-weight: bold;
        font-size: 13px;
    }
    
    /* ============================================
       ESTILOS PARA EL SELECTOR DE MES
       ============================================ */
    #mesSelector {
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
    
    #mesSelector:hover {
        background-color: #083CAE;
        color: white;
    }
    
    #mesSelector:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.3);
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
        background: #083CAE;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #062b7c;
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
        
        #btnExpandir, #btnContraer, #btnExcel, #btnCatalogo, #btnBalanza {
            width: 32px;
            height: 32px;
            font-size: 14px;
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
        
        #mesSelector, #btnExpandir, #btnContraer, #btnExcel, #btnCatalogo, #btnBalanza {
            display: none;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // BALANZA DE COMPROBACIÓN - SISTEMA CONTABLE
    // VERSIÓN: 3.0.0 - TABLA DESPLEGABLE
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
            expandedCuentas: new Set(['100', '200', '300', '400', '500', '600', '700', '800']), // Expandidas por defecto
            mesActual: 'Febrero 2026',
            datosCargados: false,
            totalRegistros: 0,
            nivelExpandido: 0
        };
        
        // ============================================
        // ESTRUCTURA DE DATOS (MANTENIENDO TUS DATOS)
        // ============================================
        const datosFebrero = [
            {
                numero: '100',
                nombre: 'ACTIVO',
                naturaleza: 'Deudora',
                saldoInicial: 58671349.70,
                cargos: -21360.00,
                abonos: 193581.60,
                saldoFinal: 58456408.10,
                expandible: true,
                subcuentas: [
                    {
                        numero: '110',
                        nombre: 'ACTIVO CIRCULANTE',
                        naturaleza: 'Deudora',
                        saldoInicial: 35000000.00,
                        cargos: -10000.00,
                        abonos: 120000.00,
                        saldoFinal: 34870000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '111',
                                nombre: 'EFECTIVO Y EQUIVALENTES',
                                naturaleza: 'Deudora',
                                saldoInicial: 12000000.00,
                                cargos: -5000.00,
                                abonos: 45000.00,
                                saldoFinal: 11950000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '111-01', nombre: 'Caja chica', naturaleza: 'Deudora', saldoInicial: 500000.00, cargos: -1000.00, abonos: 5000.00, saldoFinal: 494000.00 },
                                    { numero: '111-02', nombre: 'Bancos', naturaleza: 'Deudora', saldoInicial: 10000000.00, cargos: -3000.00, abonos: 30000.00, saldoFinal: 9970000.00 },
                                    { numero: '111-03', nombre: 'Inversiones temporales', naturaleza: 'Deudora', saldoInicial: 1500000.00, cargos: -1000.00, abonos: 10000.00, saldoFinal: 1490000.00 }
                                ]
                            },
                            {
                                numero: '112',
                                nombre: 'CUENTAS POR COBRAR',
                                naturaleza: 'Deudora',
                                saldoInicial: 15000000.00,
                                cargos: -3000.00,
                                abonos: 50000.00,
                                saldoFinal: 14947000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '112-01', nombre: 'Clientes', naturaleza: 'Deudora', saldoInicial: 10000000.00, cargos: -2000.00, abonos: 35000.00, saldoFinal: 9965000.00 },
                                    { numero: '112-02', nombre: 'Deudores diversos', naturaleza: 'Deudora', saldoInicial: 3000000.00, cargos: -500.00, abonos: 10000.00, saldoFinal: 2989500.00 },
                                    { numero: '112-03', nombre: 'Funcionarios y empleados', naturaleza: 'Deudora', saldoInicial: 2000000.00, cargos: -500.00, abonos: 5000.00, saldoFinal: 1994500.00 }
                                ]
                            },
                            {
                                numero: '113',
                                nombre: 'INVENTARIOS',
                                naturaleza: 'Deudora',
                                saldoInicial: 8000000.00,
                                cargos: -2000.00,
                                abonos: 25000.00,
                                saldoFinal: 7973000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '113-01', nombre: 'Materia prima', naturaleza: 'Deudora', saldoInicial: 3000000.00, cargos: -1000.00, abonos: 10000.00, saldoFinal: 2989000.00 },
                                    { numero: '113-02', nombre: 'Producción en proceso', naturaleza: 'Deudora', saldoInicial: 2000000.00, cargos: -500.00, abonos: 8000.00, saldoFinal: 1991500.00 },
                                    { numero: '113-03', nombre: 'Producto terminado', naturaleza: 'Deudora', saldoInicial: 3000000.00, cargos: -500.00, abonos: 7000.00, saldoFinal: 2992500.00 }
                                ]
                            }
                        ]
                    },
                    {
                        numero: '120',
                        nombre: 'ACTIVO NO CIRCULANTE',
                        naturaleza: 'Deudora',
                        saldoInicial: 23671349.70,
                        cargos: -11360.00,
                        abonos: 73581.60,
                        saldoFinal: 23586408.10,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '121',
                                nombre: 'PROPIEDAD, PLANTA Y EQUIPO',
                                naturaleza: 'Deudora',
                                saldoInicial: 20000000.00,
                                cargos: -10000.00,
                                abonos: 60000.00,
                                saldoFinal: 19930000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '121-01', nombre: 'Terrenos', naturaleza: 'Deudora', saldoInicial: 8000000.00, cargos: -4000.00, abonos: 20000.00, saldoFinal: 7976000.00 },
                                    { numero: '121-02', nombre: 'Edificios', naturaleza: 'Deudora', saldoInicial: 6000000.00, cargos: -3000.00, abonos: 20000.00, saldoFinal: 5977000.00 },
                                    { numero: '121-03', nombre: 'Maquinaria y equipo', naturaleza: 'Deudora', saldoInicial: 4000000.00, cargos: -2000.00, abonos: 15000.00, saldoFinal: 3983000.00 },
                                    { numero: '121-04', nombre: 'Equipo de transporte', naturaleza: 'Deudora', saldoInicial: 2000000.00, cargos: -1000.00, abonos: 5000.00, saldoFinal: 1994000.00 }
                                ]
                            },
                            {
                                numero: '122',
                                nombre: 'ACTIVOS INTANGIBLES',
                                naturaleza: 'Deudora',
                                saldoInicial: 3671349.70,
                                cargos: -1360.00,
                                abonos: 13581.60,
                                saldoFinal: 3656408.10,
                                expandible: true,
                                subcuentas: [
                                    { numero: '122-01', nombre: 'Patentes', naturaleza: 'Deudora', saldoInicial: 1500000.00, cargos: -500.00, abonos: 5000.00, saldoFinal: 1494500.00 },
                                    { numero: '122-02', nombre: 'Marcas', naturaleza: 'Deudora', saldoInicial: 1200000.00, cargos: -400.00, abonos: 4000.00, saldoFinal: 1195600.00 },
                                    { numero: '122-03', nombre: 'Licencias', naturaleza: 'Deudora', saldoInicial: 971349.70, cargos: -460.00, abonos: 4581.60, saldoFinal: 966308.10 }
                                ]
                            }
                        ]
                    }
                ]
            },
            {
                numero: '200',
                nombre: 'PASIVO',
                naturaleza: 'Acreedora',
                saldoInicial: 3840900.30,
                cargos: 3945.94,
                abonos: 47600.00,
                saldoFinal: 3884554.36,
                expandible: true,
                subcuentas: [
                    {
                        numero: '210',
                        nombre: 'PASIVO CIRCULANTE',
                        naturaleza: 'Acreedora',
                        saldoInicial: 2500000.00,
                        cargos: 2500.00,
                        abonos: 30000.00,
                        saldoFinal: 2527500.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '211',
                                nombre: 'PROVEEDORES',
                                naturaleza: 'Acreedora',
                                saldoInicial: 1200000.00,
                                cargos: 1200.00,
                                abonos: 15000.00,
                                saldoFinal: 1213800.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '211-01', nombre: 'Proveedores nacionales', naturaleza: 'Acreedora', saldoInicial: 800000.00, cargos: 800.00, abonos: 10000.00, saldoFinal: 809200.00 },
                                    { numero: '211-02', nombre: 'Proveedores internacionales', naturaleza: 'Acreedora', saldoInicial: 400000.00, cargos: 400.00, abonos: 5000.00, saldoFinal: 404600.00 }
                                ]
                            },
                            {
                                numero: '212',
                                nombre: 'ACREEDORES DIVERSOS',
                                naturaleza: 'Acreedora',
                                saldoInicial: 800000.00,
                                cargos: 800.00,
                                abonos: 10000.00,
                                saldoFinal: 809200.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '212-01', nombre: 'Acreedores bancarios', naturaleza: 'Acreedora', saldoInicial: 400000.00, cargos: 400.00, abonos: 5000.00, saldoFinal: 404600.00 },
                                    { numero: '212-02', nombre: 'Acreedores comerciales', naturaleza: 'Acreedora', saldoInicial: 400000.00, cargos: 400.00, abonos: 5000.00, saldoFinal: 404600.00 }
                                ]
                            },
                            {
                                numero: '213',
                                nombre: 'IMPUESTOS POR PAGAR',
                                naturaleza: 'Acreedora',
                                saldoInicial: 500000.00,
                                cargos: 500.00,
                                abonos: 5000.00,
                                saldoFinal: 504500.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '213-01', nombre: 'ISR por pagar', naturaleza: 'Acreedora', saldoInicial: 250000.00, cargos: 250.00, abonos: 2500.00, saldoFinal: 252250.00 },
                                    { numero: '213-02', nombre: 'IVA por pagar', naturaleza: 'Acreedora', saldoInicial: 150000.00, cargos: 150.00, abonos: 1500.00, saldoFinal: 151350.00 },
                                    { numero: '213-03', nombre: 'IMSS por pagar', naturaleza: 'Acreedora', saldoInicial: 100000.00, cargos: 100.00, abonos: 1000.00, saldoFinal: 100900.00 }
                                ]
                            }
                        ]
                    },
                    {
                        numero: '220',
                        nombre: 'PASIVO NO CIRCULANTE',
                        naturaleza: 'Acreedora',
                        saldoInicial: 1340900.30,
                        cargos: 1445.94,
                        abonos: 17600.00,
                        saldoFinal: 1357054.36,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '221',
                                nombre: 'PRÉSTAMOS BANCARIOS',
                                naturaleza: 'Acreedora',
                                saldoInicial: 900000.00,
                                cargos: 900.00,
                                abonos: 12000.00,
                                saldoFinal: 911100.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '221-01', nombre: 'Préstamo corto plazo', naturaleza: 'Acreedora', saldoInicial: 300000.00, cargos: 300.00, abonos: 4000.00, saldoFinal: 303700.00 },
                                    { numero: '221-02', nombre: 'Préstamo largo plazo', naturaleza: 'Acreedora', saldoInicial: 600000.00, cargos: 600.00, abonos: 8000.00, saldoFinal: 607400.00 }
                                ]
                            },
                            {
                                numero: '222',
                                nombre: 'OBLIGACIONES POR PAGAR',
                                naturaleza: 'Acreedora',
                                saldoInicial: 440900.30,
                                cargos: 545.94,
                                abonos: 5600.00,
                                saldoFinal: 445954.36,
                                expandible: true,
                                subcuentas: [
                                    { numero: '222-01', nombre: 'Obligaciones laborales', naturaleza: 'Acreedora', saldoInicial: 220900.30, cargos: 272.94, abonos: 2800.00, saldoFinal: 223427.36 },
                                    { numero: '222-02', nombre: 'Obligaciones fiscales', naturaleza: 'Acreedora', saldoInicial: 220000.00, cargos: 273.00, abonos: 2800.00, saldoFinal: 222527.00 }
                                ]
                            }
                        ]
                    }
                ]
            },
            {
                numero: '300',
                nombre: 'CAPITAL CONTABLE',
                naturaleza: 'Acreedora',
                saldoInicial: -25000.00,
                cargos: 0.00,
                abonos: 0.00,
                saldoFinal: -25000.00,
                expandible: true,
                subcuentas: [
                    {
                        numero: '310',
                        nombre: 'CAPITAL SOCIAL',
                        naturaleza: 'Acreedora',
                        saldoInicial: -20000.00,
                        cargos: 0.00,
                        abonos: 0.00,
                        saldoFinal: -20000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '311',
                                nombre: 'CAPITAL FIJO',
                                naturaleza: 'Acreedora',
                                saldoInicial: -10000.00,
                                cargos: 0.00,
                                abonos: 0.00,
                                saldoFinal: -10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '311-01', nombre: 'Capital fundacional', naturaleza: 'Acreedora', saldoInicial: -6000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -6000.00 },
                                    { numero: '311-02', nombre: 'Aportaciones socios', naturaleza: 'Acreedora', saldoInicial: -4000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -4000.00 }
                                ]
                            },
                            {
                                numero: '312',
                                nombre: 'CAPITAL VARIABLE',
                                naturaleza: 'Acreedora',
                                saldoInicial: -10000.00,
                                cargos: 0.00,
                                abonos: 0.00,
                                saldoFinal: -10000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '312-01', nombre: 'Aportaciones adicionales', naturaleza: 'Acreedora', saldoInicial: -6000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -6000.00 },
                                    { numero: '312-02', nombre: 'Reinversiones', naturaleza: 'Acreedora', saldoInicial: -4000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -4000.00 }
                                ]
                            }
                        ]
                    },
                    {
                        numero: '320',
                        nombre: 'RESERVAS DE CAPITAL',
                        naturaleza: 'Acreedora',
                        saldoInicial: -5000.00,
                        cargos: 0.00,
                        abonos: 0.00,
                        saldoFinal: -5000.00,
                        expandible: true,
                        subcuentas: [
                            { numero: '321', nombre: 'Reserva legal', naturaleza: 'Acreedora', saldoInicial: -3000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -3000.00 },
                            { numero: '322', nombre: 'Reserva voluntaria', naturaleza: 'Acreedora', saldoInicial: -2000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -2000.00 }
                        ]
                    }
                ]
            },
            {
                numero: '400',
                nombre: 'INGRESOS',
                naturaleza: 'Acreedora',
                saldoInicial: 56324274.22,
                cargos: 0.00,
                abonos: -70000.00,
                saldoFinal: 56254274.22,
                expandible: true,
                subcuentas: [
                    {
                        numero: '410',
                        nombre: 'INGRESOS OPERATIVOS',
                        naturaleza: 'Acreedora',
                        saldoInicial: 50000000.00,
                        cargos: 0.00,
                        abonos: -60000.00,
                        saldoFinal: 49940000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '411',
                                nombre: 'VENTAS',
                                naturaleza: 'Acreedora',
                                saldoInicial: 40000000.00,
                                cargos: 0.00,
                                abonos: -50000.00,
                                saldoFinal: 39950000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '411-01', nombre: 'Venta de productos', naturaleza: 'Acreedora', saldoInicial: 30000000.00, cargos: 0.00, abonos: -30000.00, saldoFinal: 29970000.00 },
                                    { numero: '411-02', nombre: 'Venta de servicios', naturaleza: 'Acreedora', saldoInicial: 10000000.00, cargos: 0.00, abonos: -20000.00, saldoFinal: 9980000.00 }
                                ]
                            },
                            {
                                numero: '412',
                                nombre: 'OTROS INGRESOS',
                                naturaleza: 'Acreedora',
                                saldoInicial: 10000000.00,
                                cargos: 0.00,
                                abonos: -10000.00,
                                saldoFinal: 9990000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '412-01', nombre: 'Ingresos por servicios', naturaleza: 'Acreedora', saldoInicial: 6000000.00, cargos: 0.00, abonos: -6000.00, saldoFinal: 5994000.00 },
                                    { numero: '412-02', nombre: 'Ingresos varios', naturaleza: 'Acreedora', saldoInicial: 4000000.00, cargos: 0.00, abonos: -4000.00, saldoFinal: 3996000.00 }
                                ]
                            }
                        ]
                    },
                    {
                        numero: '420',
                        nombre: 'INGRESOS NO OPERATIVOS',
                        naturaleza: 'Acreedora',
                        saldoInicial: 6324274.22,
                        cargos: 0.00,
                        abonos: -10000.00,
                        saldoFinal: 6314274.22,
                        expandible: true,
                        subcuentas: [
                            { numero: '421', nombre: 'Productos financieros', naturaleza: 'Acreedora', saldoInicial: 3000000.00, cargos: 0.00, abonos: -5000.00, saldoFinal: 2995000.00 },
                            { numero: '422', nombre: 'Ingresos extraordinarios', naturaleza: 'Acreedora', saldoInicial: 3324274.22, cargos: 0.00, abonos: -5000.00, saldoFinal: 3319274.22 }
                        ]
                    }
                ]
            },
            {
                numero: '500',
                nombre: 'COSTOS',
                naturaleza: 'Deudora',
                saldoInicial: -14318.97,
                cargos: 0.00,
                abonos: 0.00,
                saldoFinal: -14318.97,
                expandible: true,
                subcuentas: [
                    {
                        numero: '510',
                        nombre: 'COSTO DE VENTAS',
                        naturaleza: 'Deudora',
                        saldoInicial: -10000.00,
                        cargos: 0.00,
                        abonos: 0.00,
                        saldoFinal: -10000.00,
                        expandible: true,
                        subcuentas: [
                            { numero: '511', nombre: 'Costo de mercancías vendidas', naturaleza: 'Deudora', saldoInicial: -7000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -7000.00 },
                            { numero: '512', nombre: 'Costo de servicios', naturaleza: 'Deudora', saldoInicial: -3000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -3000.00 }
                        ]
                    },
                    {
                        numero: '520',
                        nombre: 'OTROS COSTOS',
                        naturaleza: 'Deudora',
                        saldoInicial: -4318.97,
                        cargos: 0.00,
                        abonos: 0.00,
                        saldoFinal: -4318.97,
                        expandible: true,
                        subcuentas: [
                            { numero: '521', nombre: 'Costos indirectos', naturaleza: 'Deudora', saldoInicial: -2318.97, cargos: 0.00, abonos: 0.00, saldoFinal: -2318.97 },
                            { numero: '522', nombre: 'Costos de distribución', naturaleza: 'Deudora', saldoInicial: -2000.00, cargos: 0.00, abonos: 0.00, saldoFinal: -2000.00 }
                        ]
                    }
                ]
            },
            {
                numero: '600',
                nombre: 'GASTOS',
                naturaleza: 'Deudora',
                saldoInicial: 1511807.29,
                cargos: 187650.00,
                abonos: 0.00,
                saldoFinal: 1699457.29,
                expandible: true,
                subcuentas: [
                    {
                        numero: '610',
                        nombre: 'GASTOS DE OPERACIÓN',
                        naturaleza: 'Deudora',
                        saldoInicial: 1000000.00,
                        cargos: 100000.00,
                        abonos: 0.00,
                        saldoFinal: 1100000.00,
                        expandible: true,
                        subcuentas: [
                            {
                                numero: '611',
                                nombre: 'GASTOS ADMINISTRATIVOS',
                                naturaleza: 'Deudora',
                                saldoInicial: 600000.00,
                                cargos: 60000.00,
                                abonos: 0.00,
                                saldoFinal: 660000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '611-01', nombre: 'Sueldos administrativos', naturaleza: 'Deudora', saldoInicial: 300000.00, cargos: 30000.00, abonos: 0.00, saldoFinal: 330000.00 },
                                    { numero: '611-02', nombre: 'Rentas', naturaleza: 'Deudora', saldoInicial: 150000.00, cargos: 15000.00, abonos: 0.00, saldoFinal: 165000.00 },
                                    { numero: '611-03', nombre: 'Servicios generales', naturaleza: 'Deudora', saldoInicial: 150000.00, cargos: 15000.00, abonos: 0.00, saldoFinal: 165000.00 }
                                ]
                            },
                            {
                                numero: '612',
                                nombre: 'GASTOS DE VENTA',
                                naturaleza: 'Deudora',
                                saldoInicial: 400000.00,
                                cargos: 40000.00,
                                abonos: 0.00,
                                saldoFinal: 440000.00,
                                expandible: true,
                                subcuentas: [
                                    { numero: '612-01', nombre: 'Sueldos de ventas', naturaleza: 'Deudora', saldoInicial: 200000.00, cargos: 20000.00, abonos: 0.00, saldoFinal: 220000.00 },
                                    { numero: '612-02', nombre: 'Publicidad', naturaleza: 'Deudora', saldoInicial: 120000.00, cargos: 12000.00, abonos: 0.00, saldoFinal: 132000.00 },
                                    { numero: '612-03', nombre: 'Comisiones', naturaleza: 'Deudora', saldoInicial: 80000.00, cargos: 8000.00, abonos: 0.00, saldoFinal: 88000.00 }
                                ]
                            }
                        ]
                    },
                    {
                        numero: '620',
                        nombre: 'GASTOS FINANCIEROS',
                        naturaleza: 'Deudora',
                        saldoInicial: 511807.29,
                        cargos: 87650.00,
                        abonos: 0.00,
                        saldoFinal: 599457.29,
                        expandible: true,
                        subcuentas: [
                            { numero: '621', nombre: 'Intereses bancarios', naturaleza: 'Deudora', saldoInicial: 300000.00, cargos: 50000.00, abonos: 0.00, saldoFinal: 350000.00 },
                            { numero: '622', nombre: 'Comisiones bancarias', naturaleza: 'Deudora', saldoInicial: 150000.00, cargos: 30000.00, abonos: 0.00, saldoFinal: 180000.00 },
                            { numero: '623', nombre: 'Gastos por fluctuación cambiaria', naturaleza: 'Deudora', saldoInicial: 61807.29, cargos: 7650.00, abonos: 0.00, saldoFinal: 69457.29 }
                        ]
                    }
                ]
            },
            {
                numero: '700',
                nombre: 'RESULTADO INTEGRAL DE FINANCIAMIENTO',
                naturaleza: 'Deudora',
                saldoInicial: 0.00,
                cargos: 0.00,
                abonos: 0.00,
                saldoFinal: 0.00,
                expandible: true,
                subcuentas: [
                    { numero: '710', nombre: 'Intereses a favor', naturaleza: 'Acreedora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 },
                    { numero: '720', nombre: 'Intereses a cargo', naturaleza: 'Deudora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 },
                    { numero: '730', nombre: 'Utilidad cambiaria', naturaleza: 'Acreedora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 },
                    { numero: '740', nombre: 'Pérdida cambiaria', naturaleza: 'Deudora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 }
                ]
            },
            {
                numero: '800',
                nombre: 'CUENTAS DE ORDEN',
                naturaleza: 'Deudora',
                saldoInicial: 0.00,
                cargos: 0.00,
                abonos: 0.00,
                saldoFinal: 0.00,
                expandible: true,
                subcuentas: [
                    { numero: '810', nombre: 'Valores ajenos', naturaleza: 'Deudora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 },
                    { numero: '820', nombre: 'Contratos celebrados', naturaleza: 'Deudora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 },
                    { numero: '830', nombre: 'Juicios pendientes', naturaleza: 'Deudora', saldoInicial: 0.00, cargos: 0.00, abonos: 0.00, saldoFinal: 0.00 }
                ]
            }
        ];

        // ============================================
        // DATOS PARA OTROS MESES
        // ============================================
        const datosEnero = JSON.parse(JSON.stringify(datosFebrero));
        const datosMarzo = JSON.parse(JSON.stringify(datosFebrero));
        const datosAbril = JSON.parse(JSON.stringify(datosFebrero));
        const datosMayo = JSON.parse(JSON.stringify(datosFebrero));
        const datosJunio = JSON.parse(JSON.stringify(datosFebrero));
        
        // Modificaciones para enero
        datosEnero[0].saldoInicial = 58000000.00;
        datosEnero[0].cargos = -20000.00;
        datosEnero[0].abonos = 190000.00;
        datosEnero[0].saldoFinal = 57810000.00;
        datosEnero[1].saldoInicial = 3800000.00;
        datosEnero[1].cargos = 3800.00;
        datosEnero[1].abonos = 46000.00;
        datosEnero[1].saldoFinal = 3842200.00;
        datosEnero[2].saldoInicial = -24000.00;
        datosEnero[2].saldoFinal = -24000.00;
        datosEnero[3].saldoInicial = 56000000.00;
        datosEnero[3].abonos = -68000.00;
        datosEnero[3].saldoFinal = 55932000.00;

        // Modificaciones para marzo
        datosMarzo[0].saldoInicial = 59000000.00;
        datosMarzo[0].cargos = -22000.00;
        datosMarzo[0].abonos = 195000.00;
        datosMarzo[0].saldoFinal = 58803000.00;
        datosMarzo[1].saldoInicial = 3880000.00;
        datosMarzo[1].cargos = 4000.00;
        datosMarzo[1].abonos = 48000.00;
        datosMarzo[1].saldoFinal = 3924000.00;

        // Modificaciones para abril
        datosAbril[0].saldoInicial = 59200000.00;
        datosAbril[0].cargos = -22500.00;
        datosAbril[0].abonos = 197000.00;
        datosAbril[0].saldoFinal = 59004500.00;
        datosAbril[1].saldoInicial = 3900000.00;
        datosAbril[1].cargos = 4100.00;
        datosAbril[1].abonos = 49000.00;
        datosAbril[1].saldoFinal = 3945900.00;

        // Modificaciones para mayo
        datosMayo[0].saldoInicial = 59500000.00;
        datosMayo[0].cargos = -23000.00;
        datosMayo[0].abonos = 200000.00;
        datosMayo[0].saldoFinal = 59287000.00;
        datosMayo[1].saldoInicial = 3920000.00;
        datosMayo[1].cargos = 4200.00;
        datosMayo[1].abonos = 50000.00;
        datosMayo[1].saldoFinal = 3967800.00;

        // Modificaciones para junio
        datosJunio[0].saldoInicial = 59800000.00;
        datosJunio[0].cargos = -23500.00;
        datosJunio[0].abonos = 203000.00;
        datosJunio[0].saldoFinal = 59579500.00;
        datosJunio[1].saldoInicial = 3950000.00;
        datosJunio[1].cargos = 4300.00;
        datosJunio[1].abonos = 51000.00;
        datosJunio[1].saldoFinal = 3995700.00;

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

        function formatearMoneda(valor) {
            if (valor === null || valor === undefined || isNaN(valor)) {
                return '$0.00';
            }
            
            const signo = valor < 0 ? '-' : '';
            const valorAbsoluto = Math.abs(valor);
            
            const partes = valorAbsoluto.toFixed(2).split('.');
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            
            return signo + '$' + partes.join('.');
        }

        function obtenerDatosMes(mes) {
            return DATOS_POR_MES[mes] || datosFebrero;
        }

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

        function recolectarCuentasPorNivel(datos, nivelMaximo, nivelActual = 0) {
            let cuentas = [];
            
            datos.forEach(cuenta => {
                if (nivelActual < nivelMaximo && cuenta.subcuentas && cuenta.subcuentas.length > 0) {
                    cuentas.push(cuenta.numero);
                    const subCuentas = recolectarCuentasPorNivel(cuenta.subcuentas, nivelMaximo, nivelActual + 1);
                    cuentas = cuentas.concat(subCuentas);
                }
            });
            
            return cuentas;
        }

        function expandirHastaNivel(nivel) {
            const mesSeleccionado = document.getElementById('mesSelector').value;
            const datosCompletos = obtenerDatosMes(mesSeleccionado);
            
            EstadoApp.expandedCuentas.clear();
            
            const cuentasAExpandir = recolectarCuentasPorNivel(datosCompletos, nivel);
            cuentasAExpandir.forEach(cuenta => EstadoApp.expandedCuentas.add(cuenta));
            
            EstadoApp.nivelExpandido = nivel;
            document.getElementById('nivelActual').textContent = `Nivel ${nivel} / 5`;
            
            cargarTabla();
        }

        function contraerHastaNivel(nivel) {
            const mesSeleccionado = document.getElementById('mesSelector').value;
            const datosCompletos = obtenerDatosMes(mesSeleccionado);
            
            EstadoApp.expandedCuentas.clear();
            
            if (nivel > 0) {
                const cuentasAExpandir = recolectarCuentasPorNivel(datosCompletos, nivel);
                cuentasAExpandir.forEach(cuenta => EstadoApp.expandedCuentas.add(cuenta));
            }
            
            EstadoApp.nivelExpandido = nivel;
            document.getElementById('nivelActual').textContent = `Nivel ${nivel} / 5`;
            
            cargarTabla();
        }

        function generarFilas(datos, nivel = 0) {
            let filas = [];
            let totalSaldoInicial = 0;
            let totalCargos = 0;
            let totalAbonos = 0;
            let totalSaldoFinal = 0;
            
            datos.forEach(cuenta => {
                const esExpandible = cuenta.subcuentas && cuenta.subcuentas.length > 0;
                const estaExpandida = EstadoApp.expandedCuentas.has(cuenta.numero);
                
                const fila = {
                    numero: cuenta.numero,
                    nombre: cuenta.nombre,
                    naturaleza: cuenta.naturaleza,
                    saldoInicial: cuenta.saldoInicial,
                    cargos: cuenta.cargos,
                    abonos: cuenta.abonos,
                    saldoFinal: cuenta.saldoFinal,
                    nivel: nivel,
                    esExpandible: esExpandible,
                    estaExpandida: estaExpandida
                };
                
                filas.push(fila);
                
                if (nivel === 0) {
                    totalSaldoInicial += cuenta.saldoInicial;
                    totalCargos += cuenta.cargos;
                    totalAbonos += cuenta.abonos;
                    totalSaldoFinal += cuenta.saldoFinal;
                }
                
                if (esExpandible && estaExpandida && cuenta.subcuentas && nivel < 5) {
                    const subResultado = generarFilas(cuenta.subcuentas, nivel + 1);
                    filas = filas.concat(subResultado.filas);
                }
            });
            
            return { filas, totalSaldoInicial, totalCargos, totalAbonos, totalSaldoFinal };
        }

        function cargarTabla() {
            const tbody = document.getElementById('tablaBody');
            if (!tbody) return;
            
            const mesSeleccionado = document.getElementById('mesSelector').value;
            EstadoApp.mesActual = mesSeleccionado;
            
            const datosCompletos = obtenerDatosMes(mesSeleccionado);
            const { filas, totalSaldoInicial, totalCargos, totalAbonos, totalSaldoFinal } = generarFilas(datosCompletos);
            
            EstadoApp.totalRegistros = filas.length;
            
            tbody.innerHTML = '';
            
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            if (sinDatosMensaje) {
                if (filas.length === 0) {
                    sinDatosMensaje.style.display = 'block';
                    document.getElementById('totalSaldoInicial').textContent = formatearMoneda(0);
                    document.getElementById('totalCargos').textContent = formatearMoneda(0);
                    document.getElementById('totalAbonos').textContent = formatearMoneda(0);
                    document.getElementById('totalSaldoFinal').textContent = formatearMoneda(0);
                    return;
                } else {
                    sinDatosMensaje.style.display = 'none';
                }
            }
            
            filas.forEach(fila => {
                const tr = document.createElement('tr');
                
                if (fila.nivel === 0) {
                    tr.className = 'fila-expandible';
                } else {
                    tr.className = `subcuenta-nivel${fila.nivel}`;
                }
                
                const paddingLeft = (fila.nivel * 20) + 8;
                
                const tdNumero = document.createElement('td');
                tdNumero.style.border = '1px solid #dee2e6';
                tdNumero.style.padding = `12px 8px 12px ${paddingLeft}px`;
                tdNumero.style.color = '#000000';
                
                if (fila.esExpandible) {
                    const icono = document.createElement('i');
                    icono.className = `fas ${fila.estaExpandida ? 'fa-chevron-down' : 'fa-chevron-right'}`;
                    icono.style.marginRight = '8px';
                    icono.style.color = '#083CAE';
                    icono.style.cursor = 'pointer';
                    
                    icono.addEventListener('click', (e) => toggleExpand(fila.numero, e));
                    
                    tdNumero.appendChild(icono);
                    tdNumero.appendChild(document.createTextNode(' ' + fila.numero));
                } else {
                    tdNumero.textContent = fila.numero;
                }
                
                const tdNombre = document.createElement('td');
                tdNombre.style.border = '1px solid #dee2e6';
                tdNombre.style.padding = '12px 8px';
                tdNombre.style.color = '#000000';
                tdNombre.textContent = fila.nombre;
                
                const tdNaturaleza = document.createElement('td');
                tdNaturaleza.style.border = '1px solid #dee2e6';
                tdNaturaleza.style.padding = '12px 8px';
                tdNaturaleza.style.textAlign = 'center';
                tdNaturaleza.className = fila.naturaleza === 'Deudora' ? 'naturaleza-deudora' : 'naturaleza-acreedora';
                tdNaturaleza.textContent = fila.naturaleza;
                
                const tdSaldoInicial = document.createElement('td');
                tdSaldoInicial.style.border = '1px solid #dee2e6';
                tdSaldoInicial.style.padding = '12px 8px';
                tdSaldoInicial.style.textAlign = 'right';
                tdSaldoInicial.style.color = fila.saldoInicial < 0 ? '#dc3545' : '#000000';
                tdSaldoInicial.textContent = formatearMoneda(fila.saldoInicial);
                
                const tdCargos = document.createElement('td');
                tdCargos.style.border = '1px solid #dee2e6';
                tdCargos.style.padding = '12px 8px';
                tdCargos.style.textAlign = 'right';
                tdCargos.style.color = fila.cargos < 0 ? '#dc3545' : '#000000';
                tdCargos.textContent = formatearMoneda(fila.cargos);
                
                const tdAbonos = document.createElement('td');
                tdAbonos.style.border = '1px solid #dee2e6';
                tdAbonos.style.padding = '12px 8px';
                tdAbonos.style.textAlign = 'right';
                tdAbonos.style.color = fila.abonos < 0 ? '#dc3545' : '#000000';
                tdAbonos.textContent = formatearMoneda(fila.abonos);
                
                const tdSaldoFinal = document.createElement('td');
                tdSaldoFinal.style.border = '1px solid #dee2e6';
                tdSaldoFinal.style.padding = '12px 8px';
                tdSaldoFinal.style.textAlign = 'right';
                tdSaldoFinal.style.color = fila.saldoFinal < 0 ? '#dc3545' : '#000000';
                tdSaldoFinal.textContent = formatearMoneda(fila.saldoFinal);
                
                if (fila.nivel === 0) {
                    tdNumero.style.fontWeight = 'bold';
                    tdNombre.style.fontWeight = 'bold';
                    tdNaturaleza.style.fontWeight = 'bold';
                    tdSaldoInicial.style.fontWeight = 'bold';
                    tdCargos.style.fontWeight = 'bold';
                    tdAbonos.style.fontWeight = 'bold';
                    tdSaldoFinal.style.fontWeight = 'bold';
                }
                
                tr.appendChild(tdNumero);
                tr.appendChild(tdNombre);
                tr.appendChild(tdNaturaleza);
                tr.appendChild(tdSaldoInicial);
                tr.appendChild(tdCargos);
                tr.appendChild(tdAbonos);
                tr.appendChild(tdSaldoFinal);
                
                tbody.appendChild(tr);
            });
            
            document.getElementById('totalSaldoInicial').textContent = formatearMoneda(totalSaldoInicial);
            document.getElementById('totalCargos').textContent = formatearMoneda(totalCargos);
            document.getElementById('totalAbonos').textContent = formatearMoneda(totalAbonos);
            document.getElementById('totalSaldoFinal').textContent = formatearMoneda(totalSaldoFinal);
            
            EstadoApp.datosCargados = true;
        }

        // ============================================
        // INICIALIZACIÓN Y EVENTOS
        // ============================================
        
        // Cargar datos iniciales con expansión de nivel 1
        expandirHastaNivel(1);
        
        const mesSelector = document.getElementById('mesSelector');
        if (mesSelector) {
            mesSelector.addEventListener('change', function(e) {
                e.preventDefault();
                expandirHastaNivel(1);
            });
        }
        
        const btnExpandir = document.getElementById('btnExpandir');
        if (btnExpandir) {
            let contadorClicks = 0;
            btnExpandir.addEventListener('click', function() {
                contadorClicks = (contadorClicks % 5) + 1;
                expandirHastaNivel(contadorClicks);
            });
        }
        
        const btnContraer = document.getElementById('btnContraer');
        if (btnContraer) {
            let contadorClicks = 5;
            btnContraer.addEventListener('click', function() {
                contadorClicks = contadorClicks > 0 ? contadorClicks - 1 : 0;
                contraerHastaNivel(contadorClicks);
                if (contadorClicks === 0) {
                    contadorClicks = 5;
                }
            });
        }
        
        const btnExcel = document.getElementById('btnExcel');
        if (btnExcel) {
            btnExcel.addEventListener('click', function() {
                alert('Funcionalidad de exportación a Excel - En desarrollo');
            });
        }
        
        const btnCatalogo = document.getElementById('btnCatalogo');
        if (btnCatalogo) {
            btnCatalogo.addEventListener('click', function() {
                alert('Funcionalidad de descarga de catálogo - En desarrollo');
            });
        }
        
        const btnBalanza = document.getElementById('btnBalanza');
        if (btnBalanza) {
            btnBalanza.addEventListener('click', function() {
                alert('Funcionalidad de balanza - En desarrollo');
            });
        }
        
        console.log('✅ Balanza de Comprobación inicializada correctamente');
        console.log('📊 Versión: 3.0.0 - Tabla desplegable');
        console.log('📅 Estado inicial: Expandido hasta nivel 1');
        
    })();
</script>
@endsection