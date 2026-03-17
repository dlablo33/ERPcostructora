@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cobranza por Día -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cobranza por Día
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE COBRANZA CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Cobranza Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Cobranza Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="cobranzaTotal">$188,250.00</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Días con Cobro -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Días con Cobro</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="diasCobro">7</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Promedio por Día -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Promedio por Día</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="promedioDia">$26,892.86</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Facturas Cobradas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas Cobradas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="facturasCobradas">24</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con filtros -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Título de la sección -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-hand-holding-usd" style="color: #083CAE; font-size: 24px;"></i>
                        <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">Cobranza</h3>
                    </div>
                    
                    <!-- Filtros de fecha -->
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <div>
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Fecha inicio:</span>
                            <input type="date" id="fechaInicio" value="2025-08-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                        </div>

                        <div>
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Fecha fin:</span>
                            <input type="date" id="fechaFin" value="2026-02-28" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar cliente..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-money-bill-wave" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros de cobranza para mostrar</p>
                </div>

                <!-- Lista de Cobranza por Día (Acordeón) -->
                <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);" id="cobranzaContainer">
                    <!-- Encabezado de la lista -->
                    <div style="background-color: #f1f5f9; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;">
                                <i class="fas fa-calendar-alt mr-2"></i> Días con Cobranza
                            </div>
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;" id="totalCobranzaDisplay">
                                Total: $188,250.00
                            </div>
                        </div>
                    </div>

                    <!-- Lista de días (acordeón) -->
                    <div id="listaDias" style="padding: 10px 0;">
                        <!-- Día 1: 2026-02-19 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2026-02-19</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$100,000.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #e9ecef;">
                                            <td style="padding: 10px;">DEP-001</td>
                                            <td style="padding: 10px;">Constructora del Norte</td>
                                            <td style="padding: 10px;">FAC-001</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$45,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$45,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #e9ecef;">
                                            <td style="padding: 10px;">DEP-002</td>
                                            <td style="padding: 10px;">Servicios Integrales</td>
                                            <td style="padding: 10px;">FAC-002</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$35,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$35,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;">DEP-003</td>
                                            <td style="padding: 10px;">Arrendadora de Maquinaria</td>
                                            <td style="padding: 10px;">FAC-003</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$20,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$20,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$100,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$100,000.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 2: 2026-02-10 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2026-02-10</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$24,640.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #e9ecef;">
                                            <td style="padding: 10px;">DEP-004</td>
                                            <td style="padding: 10px;">Proveedora de Materiales</td>
                                            <td style="padding: 10px;">FAC-004</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$12,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$12,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;">DEP-005</td>
                                            <td style="padding: 10px;">Consultoría Empresarial</td>
                                            <td style="padding: 10px;">FAC-005</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$12,640.00</td>
                                            <td style="padding: 10px; text-align: right;">$12,640.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$24,640.00</td>
                                            <td style="padding: 10px; text-align: right;">$24,640.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 3: 2026-01-30 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2026-01-30</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$10.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;">DEP-006</td>
                                            <td style="padding: 10px;">Servicios de Limpieza</td>
                                            <td style="padding: 10px;">FAC-006</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$10.00</td>
                                            <td style="padding: 10px; text-align: right;">$10.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$10.00</td>
                                            <td style="padding: 10px; text-align: right;">$10.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 4: 2025-10-03 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2025-10-03</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$1,600.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;">DEP-007</td>
                                            <td style="padding: 10px;">Distribuidora de Material</td>
                                            <td style="padding: 10px;">FAC-007</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,600.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,600.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,600.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,600.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 5: 2025-09-30 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2025-09-30</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$1,000.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;">DEP-008</td>
                                            <td style="padding: 10px;">Transportes del Bajío</td>
                                            <td style="padding: 10px;">FAC-008</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$1,000.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 6: 2025-09-19 -->
                        <div class="dia-item" style="border-bottom: 1px solid #dee2e6;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2025-09-19</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$11,000.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;">DEP-009</td>
                                            <td style="padding: 10px;">Logística Monterrey</td>
                                            <td style="padding: 10px;">FAC-009</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$11,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$11,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$11,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$11,000.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Día 7: 2025-08-12 -->
                        <div class="dia-item" style="border-bottom: none;">
                            <div class="dia-header" onclick="toggleDia(this)" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; cursor: pointer; background-color: #ffffff; transition: background-color 0.2s;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-chevron-right" style="color: #083CAE; font-size: 16px; transition: transform 0.3s;"></i>
                                    <span style="font-weight: 600; color: #083CAE; font-size: 16px;">2025-08-12</span>
                                    <span style="color: #6c757d; font-size: 14px;">Total del Día:</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 30px;">
                                    <span style="font-weight: 600; color: #000000; font-size: 16px;">$0.00 USD</span>
                                    <span style="font-weight: 700; color: #083CAE; font-size: 18px;">$50,000.00 MXN</span>
                                </div>
                            </div>
                            <div class="dia-content" style="display: none; padding: 0 20px 20px 50px; background-color: #f8f9fa;">
                                <!-- Tabla de detalles del día -->
                                <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #dee2e6;">
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Depósito</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Cliente</th>
                                            <th style="padding: 10px; text-align: left; color: #083CAE; font-weight: 600;">Factura</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">USD</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">MXN</th>
                                            <th style="padding: 10px; text-align: right; color: #083CAE; font-weight: 600;">Venta MXN</th>
                                            <th style="padding: 10px; text-align: center; color: #083CAE; font-weight: 600;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px;">DEP-010</td>
                                            <td style="padding: 10px;">Constructora del Norte</td>
                                            <td style="padding: 10px;">FAC-010</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$30,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$30,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px;">DEP-011</td>
                                            <td style="padding: 10px;">Servicios Integrales</td>
                                            <td style="padding: 10px;">FAC-011</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$20,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$20,000.00</td>
                                            <td style="padding: 10px; text-align: center;">
                                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="PDF"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #e9ecef; font-weight: bold;">
                                            <td colspan="3" style="padding: 10px; text-align: right;">Totales:</td>
                                            <td style="padding: 10px; text-align: right;">$0.00</td>
                                            <td style="padding: 10px; text-align: right;">$50,000.00</td>
                                            <td style="padding: 10px; text-align: right;">$50,000.00</td>
                                            <td style="padding: 10px;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pie de lista con totales globales -->
                    <div style="background-color: #e9ecef; padding: 15px 20px; border-top: 2px solid #083CAE;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="font-weight: 700; color: #083CAE; font-size: 16px;">
                                <i class="fas fa-chart-line mr-2"></i> Resumen Global
                            </div>
                            <div style="display: flex; gap: 40px;">
                                <div style="text-align: right;">
                                    <div style="font-size: 13px; color: #6c757d;">Total USD</div>
                                    <div style="font-weight: 700; color: #000000; font-size: 18px;">$0.00</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 13px; color: #6c757d;">Total MXN</div>
                                    <div style="font-weight: 700; color: #083CAE; font-size: 18px;">$188,250.00</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 13px; color: #6c757d;">Ventas MXN</div>
                                    <div style="font-weight: 700; color: #083CAE; font-size: 18px;">$188,250.00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paginación (si es necesaria) -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <span style="color: #6c757d; font-size: 14px;">Mostrando 7 días</span>
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
    
    /* Estilos para el acordeón */
    .dia-header {
        transition: background-color 0.2s;
    }
    
    .dia-header:hover {
        background-color: #f1f5f9 !important;
    }
    
    .dia-header i.fa-chevron-right {
        transition: transform 0.3s;
    }
    
    .dia-header.expandido i.fa-chevron-right {
        transform: rotate(90deg);
    }
    
    .dia-content {
        transition: all 0.3s ease;
    }
    
    /* Estilos de tabla */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    th {
        background-color: #f8f9fa;
        color: #083CAE;
        font-weight: 600;
        padding: 10px;
        border-bottom: 2px solid #083CAE;
    }
    
    td {
        padding: 8px 10px;
        border-bottom: 1px solid #e9ecef;
    }
    
    tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    
    tfoot td {
        font-weight: 600;
        background-color: #e9ecef;
    }
    
    /* Estilo para el botón Excel */
    #btnExcel {
        transition: all 0.3s ease;
    }
    
    #btnExcel:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Estilo para inputs de fecha */
    input[type="date"] {
        transition: all 0.3s ease;
    }
    
    input[type="date"]:hover {
        border-color: #2CBF1F !important;
    }
    
    input[type="date"]:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    /* Estilo para iconos de acción */
    .fa-eye:hover, .fa-file-pdf:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    
    .fa-eye:hover {
        color: #0056b3 !important;
    }
    
    .fa-file-pdf:hover {
        color: #b02a37 !important;
    }
    
    /* Estilo para botones de paginación */
    .page-btn {
        transition: all 0.2s;
    }
    
    .page-btn:hover:not(:disabled) {
        background-color: #e9ecef !important;
        transform: translateY(-2px);
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        [style*="flex: 0 1 calc(25% - 15px)"] {
            flex: 0 1 calc(50% - 15px) !important;
        }
        
        [style*="display: flex; justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        [style*="display: flex; align-items: center; gap: 15px; flex-wrap: wrap"] {
            width: 100%;
        }
        
        input[type="date"] {
            width: 100% !important;
        }
        
        #buscador {
            width: 100% !important;
        }
        
        .dia-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
        
        .dia-header > div:last-child {
            width: 100%;
            justify-content: space-between !important;
        }
        
        table {
            font-size: 11px;
        }
        
        td, th {
            padding: 5px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Cobranza por Día');
        
        // Función para toggle del acordeón
        window.toggleDia = function(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('i.fa-chevron-right');
            
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                header.classList.add('expandido');
            } else {
                content.style.display = 'none';
                header.classList.remove('expandido');
            }
        };
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
            // Aquí se podría filtrar los datos
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
            // Aquí se podría filtrar los datos
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando cobranza a Excel...');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            console.log('Buscando:', busqueda);
            // Aquí se podría filtrar la lista
        });
        
        // Acciones de los iconos
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                alert('Ver detalle de depósito - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            }
        });
    });
</script>
@endsection