@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estados de Resultados General -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Estados de Resultados General
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtro superior: Año y Mes -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 30px; gap: 15px;">
                    <div style="font-weight: 600; color: #083CAE; font-size: 15px;">Año y Mes:</div>
                    <div style="display: flex; border: 1px solid #083CAE; border-radius: 8px; overflow: hidden;">
                        <select id="mes" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 120px; border-right: 1px solid #dee2e6;">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <select id="anio" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 100px;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>
                    </div>
                    <button id="btnConsultar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-search"></i> CONSULTAR
                    </button>
                </div>

                <!-- KPIs superiores -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; color: #6c757d; margin-bottom: 5px;">No. Unidades</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;">11</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; color: #6c757d; margin-bottom: 5px;">Kilometros.</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;">0.00</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; color: #6c757d; margin-bottom: 5px;">Litros.</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;">250</div>
                    </div>
                    <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; color: #6c757d; margin-bottom: 5px;">Rendimiento</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;">0</div>
                    </div>
                </div>

                <!-- Contenedor principal con dos columnas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Columna Izquierda -->
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <!-- Cuadro Ingresos -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; margin-bottom: 15px; padding: 10px; background-color: #f1f5f9; border-radius: 8px; text-align: center;">
                                <div style="font-size: 12px;"><strong>Concepto</strong></div>
                                <div style="font-size: 12px;"><strong>Monto</strong></div>
                                <div style="font-size: 12px;"><strong>% / Vta.</strong></div>
                                <div style="font-size: 12px;"><strong>Ing. / Km.</strong></div>
                                <div style="font-size: 12px;"><strong>Ing. / Uni.</strong></div>
                                <div style="font-size: 12px;"><strong>Iva</strong></div>
                                <div style="font-size: 12px;"><strong>Total</strong></div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 14px; text-align: left;">Ingresos</div>
                                <div style="text-align: right; color: #000000;">593,100.00</div>
                                <div style="text-align: right; color: #000000;">100.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">53,918.18</div>
                                <div style="text-align: right; color: #000000;">94,840.00</div>
                                <div style="text-align: right; color: #000000; font-weight: 500;">687,940.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 8px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 14px; text-align: left;">Otros Ingresos</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 12px 0; background-color: #e8f4fd; border-radius: 8px; margin-top: 5px;">
                                <div style="font-size: 15px; font-weight: bold; padding-left: 10px; text-align: left;">Total Ingresos</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">593,100.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">100.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">0.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">53,918.18</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">94,840.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">687,940.00</div>
                            </div>
                        </div>

                        <!-- Cuadro Egresos Directos -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; margin-bottom: 15px; padding: 10px; background-color: #f1f5f9; border-radius: 8px; text-align: center;">
                                <div style="font-size: 12px;"><strong>Concepto</strong></div>
                                <div style="font-size: 12px;"><strong>Monto</strong></div>
                                <div style="font-size: 12px;"><strong>% / Vta.</strong></div>
                                <div style="font-size: 12px;"><strong>Cto. / Km.</strong></div>
                                <div style="font-size: 12px;"><strong>Cto. / Uni.</strong></div>
                                <div style="font-size: 12px;"><strong>Iva</strong></div>
                                <div style="font-size: 12px;"><strong>Total</strong></div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Diesel</div>
                                <div style="text-align: right; color: #000000;">6,220.00</div>
                                <div style="text-align: right; color: #000000;">1.05</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">565.45</div>
                                <div style="text-align: right; color: #000000;">867.20</div>
                                <div style="text-align: right; color: #000000;">7,087.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Urea</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Sueldos</div>
                                <div style="text-align: right; color: #000000;">66,006.40</div>
                                <div style="text-align: right; color: #000000;">11.13</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">6,000.58</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">66,006.40</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Casetas</div>
                                <div style="text-align: right; color: #000000;">100.00</div>
                                <div style="text-align: right; color: #000000;">0.02</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">9.09</div>
                                <div style="text-align: right; color: #000000;">16.00</div>
                                <div style="text-align: right; color: #000000;">116.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Gastos</div>
                                <div style="text-align: right; color: #000000;">3,900.00</div>
                                <div style="text-align: right; color: #000000;">0.66</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">354.55</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">3,900.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Adicionales</div>
                                <div style="text-align: right; color: #000000;">4,141.60</div>
                                <div style="text-align: right; color: #000000;">0.70</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">376.51</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">4,142.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">Permisionarios</div>
                                <div style="text-align: right; color: #000000;">57,000.00</div>
                                <div style="text-align: right; color: #000000;">9.61</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">5,181.82</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">57,000.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr; gap: 5px; align-items: center; padding: 12px 0; background-color: #fff3e0; border-radius: 8px; margin-top: 5px;">
                                <div style="font-size: 15px; font-weight: bold; padding-left: 10px; text-align: left;">Total Egresos</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">137,368.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">23.16</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">0.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">12,488.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">883.20</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">138,251.40</div>
                            </div>
                        </div>

                        <!-- Cuadro Indirecto (sin cambios, ya estaba bien) -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="font-weight: bold; font-size: 16px; margin-bottom: 15px; color: #083CAE;">Indirecto</div>
                            
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; padding: 8px; background-color: #f1f5f9; border-radius: 8px; margin-bottom: 10px; font-size: 12px; text-align: center;">
                                <div style="text-align: left;">Concepto</div>
                                <div style="text-align: right;">Monto</div>
                                <div style="text-align: right;">%</div>
                                <div style="text-align: right;">/Uni</div>
                            </div>

                            <div style="max-height: 200px; overflow-y: auto;">
                                <!-- ... (mantener el mismo contenido) ... -->
                                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                    <div style="font-size: 12px; text-align: left;">Costo Indirecto de Mantenimiento</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                </div>
                                <!-- ... resto de los items ... -->
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha -->
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <!-- Gastos de Transportacion, Administracion, Financieros -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; padding: 8px; background-color: #f1f5f9; border-radius: 8px; margin-bottom: 10px; font-size: 12px; text-align: center;">
                                <div style="text-align: left;">Concepto</div>
                                <div style="text-align: right;">Monto</div>
                                <div style="text-align: right;">%</div>
                                <div style="text-align: right;">/Uni</div>
                            </div>

                            <div style="max-height: 300px; overflow-y: auto;">
                                <!-- Gastos de Transportacion -->
                                <div style="font-weight: 600; margin-top: 10px; margin-bottom: 5px; color: #495057; text-align: left;">Gastos de Transportacion</div>
                                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                    <div style="font-size: 12px; padding-left: 10px; text-align: left;">Rastreo Satelital y Monitoreo</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                    <div style="text-align: right; color: #000000;">0.00</div>
                                </div>
                                <!-- ... resto de items ... -->
                            </div>
                        </div>

                        <!-- Gastos ordinarios / extraordinarios -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="font-weight: bold; font-size: 16px; margin-bottom: 10px; color: #083CAE; text-align: left;">Gastos ordinarios / extraordinarios</div>
                            
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 8px; background-color: #f1f5f9; border-radius: 8px; margin-bottom: 10px; font-size: 12px; text-align: center;">
                                <div style="text-align: left;">Concepto</div>
                                <div style="text-align: right;">Monto</div>
                                <div style="text-align: right;">% / Vta.</div>
                                <div style="text-align: right;">Cto./Km.</div>
                                <div style="text-align: right;">Cto./Uni.</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">COMIDAS</div>
                                <div style="text-align: right; color: #000000;">1,600.00</div>
                                <div style="text-align: right; color: #000000;">0.27</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">145.45</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">COMISIONES</div>
                                <div style="text-align: right; color: #000000;">600.00</div>
                                <div style="text-align: right; color: #000000;">0.10</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">54.55</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">FEDERALES</div>
                                <div style="text-align: right; color: #000000;">1,000.00</div>
                                <div style="text-align: right; color: #000000;">0.17</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">90.91</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">HOTEL</div>
                                <div style="text-align: right; color: #000000;">250.00</div>
                                <div style="text-align: right; color: #000000;">0.04</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">22.73</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">TALACHAS</div>
                                <div style="text-align: right; color: #000000;">150.00</div>
                                <div style="text-align: right; color: #000000;">0.03</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">13.64</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 6px 0; border-bottom: 1px solid #dee2e6;">
                                <div style="font-size: 13px; text-align: left;">VIATICOS</div>
                                <div style="text-align: right; color: #000000;">300.00</div>
                                <div style="text-align: right; color: #000000;">0.05</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">27.27</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: center; padding: 12px 0; background-color: #f0f7ff; border-radius: 8px; margin-top: 5px;">
                                <div style="font-size: 14px; font-weight: bold; padding-left: 10px; text-align: left;">Total Gastos ordinarios / extraordinarios</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">3,900.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">0.66</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">0.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">354.55</div>
                            </div>
                        </div>

                        <!-- Bonos/Descuentos y Resultados -->
                        <div style="background-color: white; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-align: left;">Bonos/Descuentos</div>
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <span>(+) Bonos</span>
                                        <span style="font-weight: 500; color: #000000;">30,400.00</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <span>(-) Descuentos</span>
                                        <span style="font-weight: 500; color: #000000;">27,358.40</span>
                                    </div>
                                </div>
                            </div>

                            <div style="font-weight: bold; font-size: 16px; margin-bottom: 15px; color: #083CAE; text-align: left;">Resultados</div>
                            
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 8px; background-color: #f1f5f9; border-radius: 8px; margin-bottom: 10px; font-size: 12px; text-align: center;">
                                <div style="text-align: left;">Concepto</div>
                                <div style="text-align: right;">Monto</div>
                                <div style="text-align: right;">(Ing./Cto.)/KM.</div>
                                <div style="text-align: right;">(Ing./Cto.)/Uni.</div>
                                <div style="text-align: right;">% Utlidad.</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Ingresos</div>
                                <div style="text-align: right; color: #000000;">593,100.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">53,918.18</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Costos Directos</div>
                                <div style="text-align: right; color: #000000;">137,368.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">12,488.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Costo Indirecto de Mantenimiento</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Gastos de Transportacion</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Gastos de Administracion</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Gastos Financieros</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Gastos Estados Resultados Default</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 5px 0; border-bottom: 1px solid #f0f0f0;">
                                <div style="text-align: left;">Depreciación</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                                <div style="text-align: right; color: #000000;">0.00</div>
                            </div>

                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; padding: 12px 0; background-color: #e8f4fd; border-radius: 8px; margin-top: 10px;">
                                <div style="font-weight: bold; padding-left: 10px; text-align: left;">Utilidades</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">455,732.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">0.00</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">41,430.18</div>
                                <div style="text-align: right; font-weight: bold; color: #000000;">76.84</div>
                            </div>
                        </div>
                    </div>
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

    /* Estilos para los cuadros */
    [style*="background-color: white"] {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    [style*="background-color: white"]:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    /* Estilo para el botón Consultar */
    #btnConsultar {
        transition: all 0.3s ease;
    }

    #btnConsultar:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }

    /* Estilo para scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        [style*="grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }

    /* Asegurar que todos los números sean negros */
    [style*="text-align: right"] {
        color: #000000 !important;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnConsultar = document.getElementById('btnConsultar');
        const mes = document.getElementById('mes');
        const anio = document.getElementById('anio');

        btnConsultar.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            alert(`Consultando datos para: ${mesSel} ${anioSel}`);
            console.log('Filtros aplicados:', { mes: mesSel, anio: anioSel });
            
            // Feedback visual
            btnConsultar.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnConsultar.style.transform = 'scale(1)';
            }, 200);
        });
    });
</script>
@endsection