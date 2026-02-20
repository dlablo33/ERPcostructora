@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Notas de Crédito -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Notas de Crédito
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE NOTAS DE CRÉDITO CENTRADOS CON NÚMEROS EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFacturas">8</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalActivas">5</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pagadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPagadas">2</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Timbrado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Timbrado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalTimbradas">8</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación discreto en la esquina izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-02-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Notas de Crédito -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaNotasCredito" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_creacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Creación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="serie">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Serie</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cliente">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cliente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="rfc">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>RFC</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="moneda">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="iva">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="riva">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>R.IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="risr">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>R.ISR</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_timbrado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Timbrado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uso_cfdi">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Uso CFDI</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="forma_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="metodo_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uuid">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>UUID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="emisor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Emisor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
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
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="7">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRiva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRisr">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="8"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPrimera">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnAnterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-8 de 8 registros</span>
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
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
        color: #000000 !important;
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
    
    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
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
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-activa {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pagada {
        background-color: #ffc107;
        color: black;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
    }
    
    /* Estilos para agrupación de columnas */
    [draggable="true"] {
        cursor: grab;
    }
    
    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }
    
    #grupoAgrupacion {
        position: relative;
    }
    
    #grupoColumnas {
        display: inline-flex;
        align-items: center;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #f0f4ff;
        border-radius: 16px;
        color: #2378e1;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #2378e1;
    }
    
    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #2378e1;
    }
    
    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }
    
    /* Estilo para filas de grupo */
    .fila-grupo {
        background-color: #f0f7ff !important;
        font-weight: 500;
        cursor: pointer;
    }
    
    .fila-grupo:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-grupo td:first-child i {
        transition: transform 0.2s;
        margin-right: 8px;
    }
    
    .fila-grupo:not(.expandido) td:first-child i {
        transform: rotate(-90deg);
    }
    
    .fila-detalle {
        background-color: #ffffff;
    }
    
    .fila-detalle td {
        border-top: none !important;
    }
    
    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo cuando se está arrastrando sobre el área de grupo */
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Todos los elementos dentro del contenedor también sin fondo */
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    /* Excepción para los spans que deben tener fondo azul */
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
    /* Estilos para los botones de paginación */
    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }
    
    #paginacionContainer button:hover {
        opacity: 0.7;
    }
    
    #paginacionContainer button i {
        color: #2378e1 !important;
    }
    
    /* Estilo específico para btnCrearFiltro */
    #btnCrearFiltro,
    #btnCrearFiltro:hover,
    #btnCrearFiltro:focus,
    #btnCrearFiltro:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnCrearFiltro i,
    #btnCrearFiltro span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"] {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        div[style*="position: relative"] {
            width: 100%;
        }
        
        input#buscador {
            width: 100% !important;
        }
        
        #paginacionContainer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Notas de Crédito');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Notas de Crédito (8 filas)
        const datosNotasCredito = [
            {
                estatus: 'Activa',
                created_at: '2026-01-15 10:30:00',
                folio: 1001,
                serie: 'NC',
                cliente: 'Maquiladora Industrial',
                rfc: 'MII880101ABC',
                cat_monedas_clave: 'MXN',
                subtotal: 5000.00,
                iva: 800.00,
                riva: 0.00,
                risr: 0.00,
                total: 5800.00,
                fecha_timbrado: '2026-01-15 10:35:00',
                satcat_uso_cfdi_clave: 'G01',
                satcat_formas_pago_clave: 'Transferencia',
                satcat_metodos_pago_clave: 'PPD',
                uuid: 'ABC123DEF456GHI789',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por devolución'
            },
            {
                estatus: 'Pagada',
                created_at: '2026-01-14 09:15:00',
                folio: 1002,
                serie: 'NC',
                cliente: 'Cartones del Norte',
                rfc: 'CND890202XYZ',
                cat_monedas_clave: 'MXN',
                subtotal: 3500.00,
                iva: 560.00,
                riva: 0.00,
                risr: 0.00,
                total: 4060.00,
                fecha_timbrado: '2026-01-14 09:20:00',
                satcat_uso_cfdi_clave: 'G03',
                satcat_formas_pago_clave: 'Cheque',
                satcat_metodos_pago_clave: 'PUE',
                uuid: 'DEF456GHI789JKL012',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por descuento'
            },
            {
                estatus: 'Activa',
                created_at: '2026-01-13 14:20:00',
                folio: 1003,
                serie: 'NC',
                cliente: 'Transportes del Bajío',
                rfc: 'TBA890123XYZ',
                cat_monedas_clave: 'MXN',
                subtotal: 2800.00,
                iva: 448.00,
                riva: 0.00,
                risr: 0.00,
                total: 3248.00,
                fecha_timbrado: '2026-01-13 14:25:00',
                satcat_uso_cfdi_clave: 'G02',
                satcat_formas_pago_clave: 'Efectivo',
                satcat_metodos_pago_clave: 'PUE',
                uuid: 'GHI789JKL012MNO345',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por ajuste'
            },
            {
                estatus: 'Cancelada',
                created_at: '2026-01-12 11:45:00',
                folio: 1004,
                serie: 'NC',
                cliente: 'Logística Monterrey',
                rfc: 'LMN890456ABC',
                cat_monedas_clave: 'MXN',
                subtotal: 4200.00,
                iva: 672.00,
                riva: 0.00,
                risr: 0.00,
                total: 4872.00,
                fecha_timbrado: '2026-01-12 11:50:00',
                satcat_uso_cfdi_clave: 'G01',
                satcat_formas_pago_clave: 'Transferencia',
                satcat_metodos_pago_clave: 'PPD',
                uuid: 'JKL012MNO345PQR678',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito cancelada'
            },
            {
                estatus: 'Pagada',
                created_at: '2026-01-11 09:30:00',
                folio: 1005,
                serie: 'NC',
                cliente: 'Comercializadora del Sur',
                rfc: 'CDS890123DEF',
                cat_monedas_clave: 'USD',
                subtotal: 300.00,
                iva: 48.00,
                riva: 0.00,
                risr: 0.00,
                total: 348.00,
                fecha_timbrado: '2026-01-11 09:35:00',
                satcat_uso_cfdi_clave: 'G03',
                satcat_formas_pago_clave: 'Cheque',
                satcat_metodos_pago_clave: 'PUE',
                uuid: 'MNO345PQR678STU901',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito en USD'
            },
            {
                estatus: 'Activa',
                created_at: '2026-01-10 16:15:00',
                folio: 1006,
                serie: 'NC',
                cliente: 'Papelera del Pacífico',
                rfc: 'PDP890123GHI',
                cat_monedas_clave: 'MXN',
                subtotal: 6500.00,
                iva: 1040.00,
                riva: 0.00,
                risr: 0.00,
                total: 7540.00,
                fecha_timbrado: '2026-01-10 16:20:00',
                satcat_uso_cfdi_clave: 'G02',
                satcat_formas_pago_clave: 'Transferencia',
                satcat_metodos_pago_clave: 'PPD',
                uuid: 'PQR678STU901VWX234',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por devolución parcial'
            },
            {
                estatus: 'Activa',
                created_at: '2026-01-09 13:40:00',
                folio: 1007,
                serie: 'NC',
                cliente: 'Ferrocarriles Nacionales',
                rfc: 'FCN890123JKL',
                cat_monedas_clave: 'MXN',
                subtotal: 1800.00,
                iva: 288.00,
                riva: 0.00,
                risr: 0.00,
                total: 2088.00,
                fecha_timbrado: '2026-01-09 13:45:00',
                satcat_uso_cfdi_clave: 'G01',
                satcat_formas_pago_clave: 'Efectivo',
                satcat_metodos_pago_clave: 'PUE',
                uuid: 'STU901VWX234YZA567',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por ajuste menor'
            },
            {
                estatus: 'Cancelada',
                created_at: '2026-01-08 10:00:00',
                folio: 1008,
                serie: 'NC',
                cliente: 'Minería del Norte',
                rfc: 'MDN890123MNO',
                cat_monedas_clave: 'MXN',
                subtotal: 9200.00,
                iva: 1472.00,
                riva: 0.00,
                risr: 0.00,
                total: 10672.00,
                fecha_timbrado: '2026-01-08 10:05:00',
                satcat_uso_cfdi_clave: 'G03',
                satcat_formas_pago_clave: 'Transferencia',
                satcat_metodos_pago_clave: 'PPD',
                uuid: 'VWX234YZA567BCD890',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito cancelada por error'
            }
        ];
        
        datosOriginales = [...datosNotasCredito];
        totalRows = datosOriginales.length;
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX') + ' ' + date.toLocaleTimeString('es-MX', {hour: '2-digit', minute:'2-digit'});
        }
        
        // Función para formatear fecha sin hora
        function formatShortDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const totalFacturas = datos.length;
            const activas = datos.filter(d => d.estatus === 'Activa').length;
            const pagadas = datos.filter(d => d.estatus === 'Pagada').length;
            const timbradas = datos.filter(d => d.fecha_timbrado).length;
            
            document.getElementById('totalFacturas').textContent = totalFacturas;
            document.getElementById('totalActivas').textContent = activas;
            document.getElementById('totalPagadas').textContent = pagadas;
            document.getElementById('totalTimbradas').textContent = timbradas;
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'estatus': return item.estatus || 'Sin estatus';
                    case 'fecha_creacion': return item.created_at || 'Sin fecha';
                    case 'folio': return item.folio ? item.folio.toString() : 'Sin folio';
                    case 'serie': return item.serie || 'Sin serie';
                    case 'cliente': return item.cliente || 'Sin cliente';
                    case 'rfc': return item.rfc || 'Sin RFC';
                    case 'moneda': return item.cat_monedas_clave || 'Sin moneda';
                    case 'subtotal': return item.subtotal ? item.subtotal.toString() : '0';
                    case 'iva': return item.iva ? item.iva.toString() : '0';
                    case 'riva': return item.riva ? item.riva.toString() : '0';
                    case 'risr': return item.risr ? item.risr.toString() : '0';
                    case 'total': return item.total ? item.total.toString() : '0';
                    case 'fecha_timbrado': return item.fecha_timbrado || 'Sin fecha';
                    case 'uso_cfdi': return item.satcat_uso_cfdi_clave || 'Sin uso';
                    case 'forma_pago': return item.satcat_formas_pago_clave || 'Sin forma';
                    case 'metodo_pago': return item.satcat_metodos_pago_clave || 'Sin método';
                    case 'uuid': return item.uuid || 'Sin UUID';
                    case 'emisor': return item.empresa_emisor || 'Sin emisor';
                    case 'descripcion': return item.cat_tipos_servicios_descripcion || 'Sin descripción';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'estatus': return item.estatus || 'Sin estatus';
                            case 'fecha_creacion': return item.created_at ? formatDate(item.created_at) : 'Sin fecha';
                            case 'folio': return item.folio || 'Sin folio';
                            case 'serie': return item.serie || 'Sin serie';
                            case 'cliente': return item.cliente || 'Sin cliente';
                            case 'rfc': return item.rfc || 'Sin RFC';
                            case 'moneda': return item.cat_monedas_clave || 'Sin moneda';
                            case 'subtotal': return item.subtotal || 0;
                            case 'iva': return item.iva || 0;
                            case 'riva': return item.riva || 0;
                            case 'risr': return item.risr || 0;
                            case 'total': return item.total || 0;
                            case 'fecha_timbrado': return item.fecha_timbrado ? formatDate(item.fecha_timbrado) : 'Sin fecha';
                            case 'uso_cfdi': return item.satcat_uso_cfdi_clave || 'Sin uso';
                            case 'forma_pago': return item.satcat_formas_pago_clave || 'Sin forma';
                            case 'metodo_pago': return item.satcat_metodos_pago_clave || 'Sin método';
                            case 'uuid': return item.uuid || 'Sin UUID';
                            case 'emisor': return item.empresa_emisor || 'Sin emisor';
                            case 'descripcion': return item.cat_tipos_servicios_descripcion || 'Sin descripción';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalSubtotal: item.subtotal || 0,
                        totalIva: item.iva || 0,
                        totalRiva: item.riva || 0,
                        totalRisr: item.risr || 0,
                        totalGeneral: item.total || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalSubtotal += item.subtotal || 0;
                    grupo.totalIva += item.iva || 0;
                    grupo.totalRiva += item.riva || 0;
                    grupo.totalRisr += item.risr || 0;
                    grupo.totalGeneral += item.total || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalSubtotal = 0;
            let totalIva = 0;
            let totalRiva = 0;
            let totalRisr = 0;
            let totalGeneral = 0;
            
            datos.forEach(item => {
                totalSubtotal += item.subtotal || 0;
                totalIva += item.iva || 0;
                totalRiva += item.riva || 0;
                totalRisr += item.risr || 0;
                totalGeneral += item.total || 0;
            });
            
            document.getElementById('sumSubtotal').textContent = formatCurrency(totalSubtotal);
            document.getElementById('sumIva').textContent = formatCurrency(totalIva);
            document.getElementById('sumRiva').textContent = formatCurrency(totalRiva);
            document.getElementById('sumRisr').textContent = formatCurrency(totalRisr);
            document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            document.getElementById('paginaActual').textContent = currentPage;
            
            // Mostrar/ocultar botones de página según sea necesario
            document.querySelectorAll('.pagina-btn').forEach(btn => {
                const pagina = parseInt(btn.dataset.pagina);
                if (pagina <= totalPages) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });
            
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            // Actualizar contadores de los cuadros
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumSubtotal').textContent = '$0.00';
                document.getElementById('sumIva').textContent = '$0.00';
                document.getElementById('sumRiva').textContent = '$0.00';
                document.getElementById('sumRisr').textContent = '$0.00';
                document.getElementById('sumTotal').textContent = '$0.00';
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    // Determinar el estatus predominante en el grupo
                    const estatusCounts = {};
                    grupo.items.forEach(item => {
                        estatusCounts[item.estatus] = (estatusCounts[item.estatus] || 0) + 1;
                    });
                    
                    let estatusPredominante = 'Activa';
                    let maxCount = 0;
                    for (const [estatus, count] of Object.entries(estatusCounts)) {
                        if (count > maxCount) {
                            maxCount = count;
                            estatusPredominante = estatus;
                        }
                    }
                    
                    let badgeClass = 'badge-activa';
                    if (estatusPredominante === 'Pagada') badgeClass = 'badge-pagada';
                    else if (estatusPredominante === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="20">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Subtotal: ${formatCurrency(grupo.totalSubtotal)} - IVA: ${formatCurrency(grupo.totalIva)} - Total: ${formatCurrency(grupo.totalGeneral)})
                                    </span>
                                </div>
                                <span class="badge ${badgeClass}" style="margin-right: 10px;">${estatusPredominante}</span>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            // Badge para cada item
                            let itemBadgeClass = 'badge-activa';
                            if (item.estatus === 'Pagada') itemBadgeClass = 'badge-pagada';
                            else if (item.estatus === 'Cancelada') itemBadgeClass = 'badge-cancelada';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;"><span class="badge ${itemBadgeClass}">${item.estatus || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.created_at ? formatDate(item.created_at) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.folio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_monedas_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.riva ? formatCurrency(item.riva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.risr ? formatCurrency(item.risr) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fecha_timbrado ? formatDate(item.fecha_timbrado) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_uso_cfdi_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_formas_pago_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_metodos_pago_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.uuid || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.empresa_emisor || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_tipos_servicios_descripcion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                        <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = datos.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-activa';
                    if (item.estatus === 'Pagada') badgeClass = 'badge-pagada';
                    else if (item.estatus === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.estatus || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.created_at ? formatDate(item.created_at) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.folio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_monedas_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.riva ? formatCurrency(item.riva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.risr ? formatCurrency(item.risr) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fecha_timbrado ? formatDate(item.fecha_timbrado) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_uso_cfdi_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_formas_pago_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.satcat_metodos_pago_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.uuid || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.empresa_emisor || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_tipos_servicios_descripcion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                calcularTotales(datos);
                
                actualizarPaginacion(datos.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'estatus': 'Estatus',
                        'fecha_creacion': 'Fecha Creación',
                        'folio': 'Folio',
                        'serie': 'Serie',
                        'cliente': 'Cliente',
                        'rfc': 'RFC',
                        'moneda': 'Moneda',
                        'subtotal': 'Subtotal',
                        'iva': 'IVA',
                        'riva': 'R.IVA',
                        'risr': 'R.ISR',
                        'total': 'Total',
                        'fecha_timbrado': 'Fecha Timbrado',
                        'uso_cfdi': 'Uso CFDI',
                        'forma_pago': 'Forma de Pago',
                        'metodo_pago': 'Método de Pago',
                        'uuid': 'UUID',
                        'emisor': 'Emisor',
                        'descripcion': 'Descripción'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTabla(datosOriginales);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTabla(datosOriginales);
            }
        });
        
        // Cargar datos iniciales
        cargarTabla(datosNotasCredito);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Agregar Nota de Crédito - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaNotasCredito', 'NotasCredito');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosNotasCredito.filter(item => 
                item.cliente?.toLowerCase().includes(busqueda) ||
                item.rfc?.toLowerCase().includes(busqueda) ||
                item.serie?.toLowerCase().includes(busqueda) ||
                item.estatus?.toLowerCase().includes(busqueda) ||
                item.uuid?.toLowerCase().includes(busqueda) ||
                item.folio?.toString().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosOriginales);
            });
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            currentPage = totalPages;
            cargarTabla(datosOriginales);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-edit')) {
                alert('Editar Nota de Crédito - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar esta nota de crédito?')) {
                    alert('Eliminar Nota de Crédito - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-file-code')) {
                alert('Descargar XML - Funcionalidad en desarrollo');
            }
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
    });
</script>
@endsection