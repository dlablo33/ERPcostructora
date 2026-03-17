@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Libro Mayor -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Libro Mayor
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Título principal -->
                <h1 style="color: #000000; font-size: 28px; font-weight: bold; margin-bottom: 20px; text-align: left;">
                    Libro Mayor
                </h1>

                <!-- Filtros a la derecha - Múltiples opciones -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-bottom: 25px; flex-wrap: wrap;">
                    <!-- Fecha inicio -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha inicio:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                            <input type="date" id="dateStart" value="2026-01-01" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                        </div>
                    </div>

                    <!-- Fecha fin -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Fecha fin:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white;">
                            <input type="date" id="dateEnd" value="2026-03-31" style="border: none; background: transparent; font-size: 14px; outline: none; width: 140px;">
                        </div>
                    </div>

                    <!-- Nivel de cuentas -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Nivel:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 120px;">
                            <select id="nivelCuentas" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                <option value="todos" selected>Todos</option>
                                <option value="1">Nivel 1 (Activo/Pasivo)</option>
                                <option value="2">Nivel 2 (Cuentas principales)</option>
                                <option value="3">Nivel 3 (Subcuentas)</option>
                                <option value="4">Nivel 4 (Detalle)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón Buscar -->
                    <button id="buttonBusqueda" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-search"></i> Buscar
                    </button>

                    <!-- Botón Excel -->
                    <button id="buttonExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>

                    <!-- Botón PDF -->
                    <button id="buttonPDF" style="background-color: #dc3545; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>

                <!-- Segunda línea de filtros -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Tipo de cuenta -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Tipo cuenta:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 150px;">
                            <select id="tipoCuenta" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                <option value="todos" selected>Todos</option>
                                <option value="activo">Activo</option>
                                <option value="pasivo">Pasivo</option>
                                <option value="capital">Capital</option>
                                <option value="ingresos">Ingresos</option>
                                <option value="egresos">Egresos</option>
                                <option value="costos">Costos</option>
                            </select>
                        </div>
                    </div>

                    <!-- Con movimientos -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Mostrar:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 150px;">
                            <select id="mostrar" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                <option value="todas" selected>Todas las cuentas</option>
                                <option value="conMovimiento">Solo con movimiento</option>
                                <option value="sinMovimiento">Solo sin movimiento</option>
                                <option value="saldos">Solo con saldo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ordenamiento -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 600; color: #083CAE; font-size: 14px;">Ordenar por:</span>
                        <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px; background-color: white; min-width: 150px;">
                            <select id="ordenarPor" style="border: none; background: transparent; font-size: 14px; width: 100%; outline: none;">
                                <option value="codigo_asc">Código (ascendente)</option>
                                <option value="codigo_desc">Código (descendente)</option>
                                <option value="nombre_asc">Nombre (A-Z)</option>
                                <option value="nombre_desc">Nombre (Z-A)</option>
                                <option value="saldo_asc">Saldo (menor a mayor)</option>
                                <option value="saldo_desc">Saldo (mayor a menor)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Línea divisoria -->
                <hr style="border: 1px solid #dee2e6; margin: 20px 0;">

                <!-- Resumen general -->
                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 12px; color: #6c757d;">Total Cuentas</div>
                        <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="totalCuentas">156</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 12px; color: #6c757d;">Con Movimiento</div>
                        <div style="font-size: 22px; font-weight: bold; color: #28a745;" id="conMovimiento">89</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 12px; color: #6c757d;">Sin Movimiento</div>
                        <div style="font-size: 22px; font-weight: bold; color: #dc3545;" id="sinMovimiento">67</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 12px; color: #6c757d;">Suma Debe</div>
                        <div style="font-size: 18px; font-weight: bold; color: #000000;" id="sumaDebe">$2,345,678</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 12px; color: #6c757d;">Suma Haber</div>
                        <div style="font-size: 18px; font-weight: bold; color: #000000;" id="sumaHaber">$2,345,678</div>
                    </div>
                </div>

                <!-- Información del período -->
                <div style="margin-bottom: 15px; padding: 10px 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-building" style="color: #083CAE;"></i>
                            <span style="font-weight: 600; color: #083CAE; font-size: 16px;">Empresa DEMO</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-calendar-alt" style="color: #083CAE;"></i>
                            <span id="periodoInfo">Del 01/01/2026 al 31/03/2026</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-balance-scale" style="color: #083CAE;"></i>
                            <span>Balanza de Comprobación</span>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Libro Mayor -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 600px;">
                    <table class="table table-bancos" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: center;" rowspan="2">Código</th>
                                <th style="padding: 12px 8px; text-align: left;" rowspan="2">Nombre de la Cuenta</th>
                                <th style="padding: 12px 8px; text-align: center;" rowspan="2">Tipo</th>
                                <th style="padding: 12px 8px; text-align: center;" rowspan="2">Nivel</th>
                                <th style="padding: 12px 8px; text-align: center;" colspan="2">Saldos Iniciales</th>
                                <th style="padding: 12px 8px; text-align: center;" colspan="2">Movimientos</th>
                                <th style="padding: 12px 8px; text-align: center;" colspan="2">Saldos Finales</th>
                            </tr>
                            <tr>
                                <th style="padding: 8px; text-align: right;">Deudor</th>
                                <th style="padding: 8px; text-align: right;">Acreedor</th>
                                <th style="padding: 8px; text-align: right;">Debe</th>
                                <th style="padding: 8px; text-align: right;">Haber</th>
                                <th style="padding: 8px; text-align: right;">Deudor</th>
                                <th style="padding: 8px; text-align: right;">Acreedor</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- ACTIVO -->
                            <tr style="background-color: #e3f2fd; font-weight: bold;">
                                <td colspan="10" style="padding: 8px 15px;">ACTIVO</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">101-01-01</td>
                                <td style="padding: 8px;">Caja y efectivo</td>
                                <td style="padding: 8px; text-align: center;">Activo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">150,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">85,000.00</td>
                                <td style="padding: 8px; text-align: right;">42,000.00</td>
                                <td style="padding: 8px; text-align: right;">193,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">101-02-01</td>
                                <td style="padding: 8px;">Bancos nacionales</td>
                                <td style="padding: 8px; text-align: center;">Activo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">850,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">320,000.00</td>
                                <td style="padding: 8px; text-align: right;">275,000.00</td>
                                <td style="padding: 8px; text-align: right;">895,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">101-05-01</td>
                                <td style="padding: 8px;">Clientes nacionales</td>
                                <td style="padding: 8px; text-align: center;">Activo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">420,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">180,000.00</td>
                                <td style="padding: 8px; text-align: right;">95,000.00</td>
                                <td style="padding: 8px; text-align: right;">505,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">101-15-01</td>
                                <td style="padding: 8px;">Inventario</td>
                                <td style="padding: 8px; text-align: center;">Activo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">620,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">230,000.00</td>
                                <td style="padding: 8px; text-align: right;">185,000.00</td>
                                <td style="padding: 8px; text-align: right;">665,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>

                            <!-- PASIVO -->
                            <tr style="background-color: #fff3e0; font-weight: bold;">
                                <td colspan="10" style="padding: 8px 15px;">PASIVO</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">201-01-01</td>
                                <td style="padding: 8px;">Proveedores nacionales</td>
                                <td style="padding: 8px; text-align: center;">Pasivo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">380,000.00</td>
                                <td style="padding: 8px; text-align: right;">145,000.00</td>
                                <td style="padding: 8px; text-align: right;">210,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">445,000.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">201-07-01</td>
                                <td style="padding: 8px;">IVA trasladado</td>
                                <td style="padding: 8px; text-align: center;">Pasivo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">28,500.00</td>
                                <td style="padding: 8px; text-align: right;">28,500.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">201-13-01</td>
                                <td style="padding: 8px;">IVA por pagar</td>
                                <td style="padding: 8px; text-align: center;">Pasivo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">45,000.00</td>
                                <td style="padding: 8px; text-align: right;">18,500.00</td>
                                <td style="padding: 8px; text-align: right;">22,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">48,500.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">201-16-04</td>
                                <td style="padding: 8px;">Retenciones ISR</td>
                                <td style="padding: 8px; text-align: center;">Pasivo</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">12,500.00</td>
                                <td style="padding: 8px; text-align: right;">4,200.00</td>
                                <td style="padding: 8px; text-align: right;">6,800.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">15,100.00</td>
                            </tr>

                            <!-- CAPITAL -->
                            <tr style="background-color: #e8f5e9; font-weight: bold;">
                                <td colspan="10" style="padding: 8px 15px;">CAPITAL</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">301-02-01</td>
                                <td style="padding: 8px;">Capital social</td>
                                <td style="padding: 8px; text-align: center;">Capital</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">1,000,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">1,000,000.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">304-01-01</td>
                                <td style="padding: 8px;">Utilidad ejercicios anteriores</td>
                                <td style="padding: 8px; text-align: center;">Capital</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">350,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">350,000.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">305-01-01</td>
                                <td style="padding: 8px;">Utilidad del ejercicio</td>
                                <td style="padding: 8px; text-align: center;">Capital</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">187,500.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">187,500.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>

                            <!-- INGRESOS -->
                            <tr style="background-color: #f3e5f5; font-weight: bold;">
                                <td colspan="10" style="padding: 8px 15px;">INGRESOS</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">401-01-01</td>
                                <td style="padding: 8px;">Ventas</td>
                                <td style="padding: 8px; text-align: center;">Ingresos</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">520,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">520,000.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">401-38-02</td>
                                <td style="padding: 8px;">Ingresos varios</td>
                                <td style="padding: 8px; text-align: center;">Ingresos</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">15,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">15,000.00</td>
                            </tr>

                            <!-- COSTOS Y GASTOS -->
                            <tr style="background-color: #ffebee; font-weight: bold;">
                                <td colspan="10" style="padding: 8px 15px;">COSTOS Y GASTOS</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">501-01</td>
                                <td style="padding: 8px;">Costo de ventas</td>
                                <td style="padding: 8px; text-align: center;">Costos</td>
                                <td style="padding: 8px; text-align: center;">2</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">312,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">312,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">601-01-01</td>
                                <td style="padding: 8px;">Sueldos y salarios</td>
                                <td style="padding: 8px; text-align: center;">Gastos</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">185,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">185,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">601-48-01</td>
                                <td style="padding: 8px;">Combustibles</td>
                                <td style="padding: 8px; text-align: center;">Gastos</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">42,500.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">42,500.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 8px;">601-56</td>
                                <td style="padding: 8px;">Mantenimiento</td>
                                <td style="padding: 8px; text-align: center;">Gastos</td>
                                <td style="padding: 8px; text-align: center;">2</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">28,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">28,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">603-82-01</td>
                                <td style="padding: 8px;">Gastos administrativos</td>
                                <td style="padding: 8px; text-align: center;">Gastos</td>
                                <td style="padding: 8px; text-align: center;">3</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">95,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                                <td style="padding: 8px; text-align: right;">95,000.00</td>
                                <td style="padding: 8px; text-align: right;">0.00</td>
                            </tr>
                        </tbody>
                        <tfoot style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 12px 8px; text-align: right;">TOTALES</td>
                                <td style="padding: 12px 8px; text-align: right;">2,040,000.00</td>
                                <td style="padding: 12px 8px; text-align: right;">1,787,500.00</td>
                                <td style="padding: 12px 8px; text-align: right;">1,355,200.00</td>
                                <td style="padding: 12px 8px; text-align: right;">1,199,300.00</td>
                                <td style="padding: 12px 8px; text-align: right;">2,008,000.00</td>
                                <td style="padding: 12px 8px; text-align: right;">2,378,600.00</td>
                            </tr>
                            <tr style="background-color: #d4edda;">
                                <td colspan="4" style="padding: 12px 8px; text-align: right;">VERIFICACIÓN</td>
                                <td style="padding: 12px 8px; text-align: right;" colspan="2">Sumas Debe/Haber</td>
                                <td style="padding: 12px 8px; text-align: right;" colspan="2">$2,554,500.00</td>
                                <td style="padding: 12px 8px; text-align: right;" colspan="2">$2,554,500.00 ✓</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Panel de resumen y paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <span style="color: #6c757d; font-size: 14px;" id="paginacionInfo">Mostrando 1-15 de 156 cuentas</span>
                        <div style="display: flex; gap: 10px;">
                            <span style="color: #6c757d; font-size: 14px;">Total Debe:</span>
                            <span style="font-weight: bold; color: #28a745;" id="totalDebe">$2,040,000.00</span>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <span style="color: #6c757d; font-size: 14px;">Total Haber:</span>
                            <span style="font-weight: bold; color: #dc3545;" id="totalHaber">$1,787,500.00</span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 5px;" id="paginacionBotones">
                        <button class="page-btn" data-page="prev" disabled style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: not-allowed; color: #6c757d;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="page-btn active" data-page="1" style="padding: 6px 12px; border: 1px solid #083CAE; background: #083CAE; color: white; border-radius: 4px;">1</button>
                        <button class="page-btn" data-page="2" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                        <button class="page-btn" data-page="3" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">3</button>
                        <button class="page-btn" data-page="4" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">4</button>
                        <button class="page-btn" data-page="5" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">5</button>
                        <button class="page-btn" data-page="next" style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Gráfico de composición -->
                <div style="margin-top: 30px; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin: 0;">
                            <i class="fas fa-chart-pie mr-2"></i> Composición del Balance
                        </h4>
                        <div style="display: flex; gap: 10px;">
                            <button class="grafico-btn active" data-tipo="balance" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 4px 12px; font-size: 12px; cursor: pointer;">Balance</button>
                            <button class="grafico-btn" data-tipo="resultados" style="background-color: #e9ecef; color: #495057; border: none; border-radius: 4px; padding: 4px 12px; font-size: 12px; cursor: pointer;">Resultados</button>
                        </div>
                    </div>
                    <div style="display: flex; gap: 30px; align-items: center;">
                        <!-- Gráfico de pastel simplificado -->
                        <div style="width: 200px; height: 200px; border-radius: 50%; background: conic-gradient(#083CAE 0% 45%, #28a745 45% 65%, #dc3545 65% 85%, #ffc107 85% 100%); box-shadow: 0 4px 8px rgba(0,0,0,0.1);"></div>
                        
                        <!-- Leyenda -->
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 16px; height: 16px; background-color: #083CAE; border-radius: 4px;"></div>
                                <span style="font-size: 13px;">Activo (45%) - $2,258,000</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 16px; height: 16px; background-color: #28a745; border-radius: 4px;"></div>
                                <span style="font-size: 13px;">Pasivo (20%) - $508,600</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 16px; height: 16px; background-color: #dc3545; border-radius: 4px;"></div>
                                <span style="font-size: 13px;">Capital (20%) - $1,870,000</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <div style="width: 16px; height: 16px; background-color: #ffc107; border-radius: 4px;"></div>
                                <span style="font-size: 13px;">Ingresos/Gastos (15%) - $1,180,000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exportación rápida -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                    <button class="export-btn" data-formato="csv" style="background-color: #17a2b8; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; cursor: pointer;">
                        <i class="fas fa-file-csv"></i> CSV
                    </button>
                    <button class="export-btn" data-formato="json" style="background-color: #6f42c1; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; cursor: pointer;">
                        <i class="fas fa-code"></i> JSON
                    </button>
                    <button class="export-btn" data-formato="print" style="background-color: #343a40; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; cursor: pointer;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>

                <!-- Nota al pie -->
                <div style="margin-top: 20px; font-size: 11px; color: #6c757d; text-align: center; border-top: 1px solid #dee2e6; padding-top: 15px;">
                    <i class="fas fa-info-circle" style="color: #083CAE;"></i>
                    Libro Mayor correspondiente al período del 01/01/2026 al 31/03/2026 - Empresa DEMO
                    <br>
                    <span style="font-size: 10px;">Las sumas de Debe y Haber deben ser iguales para garantizar la partida doble</span>
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
    
    /* Estilos de tabla */
    .table-bancos {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-bancos th {
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        white-space: nowrap;
    }
    
    .table-bancos tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .table-bancos tbody tr:hover {
        background-color: #e3f2fd !important;
    }
    
    .table-bancos td {
        padding: 8px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .table-bancos tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
    }
    
    /* Estilo para números */
    td:nth-child(5), td:nth-child(6), td:nth-child(7), td:nth-child(8), td:nth-child(9), td:nth-child(10) {
        font-family: monospace;
        text-align: right;
    }
    
    /* Estilo para el botón Buscar */
    #buttonBusqueda {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(8, 60, 174, 0.2);
    }
    
    #buttonBusqueda:hover {
        background-color: #0a4ad0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(8, 60, 174, 0.3);
    }
    
    /* Estilo para botones Excel y PDF */
    #buttonExcel, #buttonPDF {
        transition: all 0.3s ease;
    }
    
    #buttonExcel:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #buttonPDF:hover {
        background-color: #c82333 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    
    /* Estilo para inputs y selects */
    input[type="date"], select {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    input[type="date"]:hover, select:hover {
        border-color: #2CBF1F !important;
    }
    
    input[type="date"]:focus, select:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    /* Estilo para los contenedores de filtros */
    [style*="border: 1px solid #ced4da"] {
        background-color: white;
        transition: border-color 0.2s;
    }
    
    [style*="border: 1px solid #ced4da"]:hover {
        border-color: #083CAE !important;
    }
    
    /* Estilo para botones de paginación */
    .page-btn {
        transition: all 0.2s;
    }
    
    .page-btn:not(:disabled):not(.active):hover {
        background-color: #e9ecef !important;
        transform: translateY(-2px);
    }
    
    .page-btn.active {
        background-color: #083CAE !important;
        border-color: #083CAE !important;
        color: white !important;
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Estilo para botones de gráfico */
    .grafico-btn {
        transition: all 0.2s;
    }
    
    .grafico-btn:hover {
        filter: brightness(0.9);
    }
    
    .grafico-btn.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="display: flex; justify-content: flex-end"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        [style*="display: flex; align-items: center; gap: 10px"] {
            width: 100%;
            justify-content: space-between;
        }
        
        #buttonBusqueda, #buttonExcel, #buttonPDF {
            width: 100%;
            justify-content: center;
        }
        
        [style*="display: flex; justify-content: space-between"] {
            flex-direction: column;
            gap: 15px;
        }
        
        input[type="date"] {
            width: 100% !important;
        }
        
        #paginacionBotones {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        [style*="display: flex; gap: 30px; align-items: center"] {
            flex-direction: column;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Libro Mayor');
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$ ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Event Listeners
        document.getElementById('buttonBusqueda').addEventListener('click', function() {
            const fechaInicio = document.getElementById('dateStart').value;
            const fechaFin = document.getElementById('dateEnd').value;
            const nivel = document.getElementById('nivelCuentas').value;
            const tipo = document.getElementById('tipoCuenta').value;
            const mostrar = document.getElementById('mostrar').value;
            
            alert(`Buscando...\n` +
                  `Período: ${fechaInicio} a ${fechaFin}\n` +
                  `Nivel: ${nivel}\n` +
                  `Tipo: ${tipo}\n` +
                  `Mostrar: ${mostrar}`);
            
            // Feedback visual
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        document.getElementById('buttonExcel').addEventListener('click', function() {
            alert('Exportando Libro Mayor a Excel...');
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        document.getElementById('buttonPDF').addEventListener('click', function() {
            alert('Generando PDF del Libro Mayor...');
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        // Eventos para botones de paginación
        document.querySelectorAll('.page-btn[data-page]').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.hasAttribute('disabled')) return;
                
                const page = this.dataset.page;
                alert(`Cambiando a página ${page}`);
                
                // Actualizar botón activo
                document.querySelectorAll('.page-btn').forEach(b => {
                    b.classList.remove('active');
                    b.style.backgroundColor = 'white';
                    b.style.color = '#083CAE';
                    if (b.classList.contains('active')) {
                        b.style.backgroundColor = '#083CAE';
                        b.style.color = 'white';
                    }
                });
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
            });
        });

        // Eventos para botones de exportación
        document.querySelectorAll('.export-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const formato = this.dataset.formato;
                alert(`Exportando a formato ${formato.toUpperCase()}...`);
                this.style.transform = 'scale(0.95)';
                setTimeout(() => this.style.transform = 'scale(1)', 200);
            });
        });

        // Eventos para botones de gráfico
        document.querySelectorAll('.grafico-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.grafico-btn').forEach(b => {
                    b.style.backgroundColor = '#e9ecef';
                    b.style.color = '#495057';
                });
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                const tipo = this.dataset.tipo;
                console.log('Cambiando gráfico a:', tipo);
                // Aquí se actualizaría el gráfico
            });
        });
    });
</script>
@endsection