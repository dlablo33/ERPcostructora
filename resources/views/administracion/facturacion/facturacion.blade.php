@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Facturacion -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Facturación
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE FACTURACIÓN CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFacturas">30</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalActivas">12</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pagadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPagadas">10</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Canceladas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Canceladas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalCanceladas">8</div>
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

                <!-- Tabla de Facturación -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFacturacion" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <!-- PRIMERA FILA DE ENCABEZADOS (1-20) -->
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_timbrado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Timbrado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="serie">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Serie</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="viajes">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Viajes</span>
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="folio_carga">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio Carga</span>
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
                                        <span>Forma Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="metodo_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_revision">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Revisión</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_vencimiento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Vencimiento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="moneda">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="iva">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="retencion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Retención</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descuento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descuento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <!-- SEGUNDA FILA DE ENCABEZADOS (21-42) -->
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total_mxn">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total MXN</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uuid">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>UUID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="idccp">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IdCCP</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion_adicional">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción Adicional</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="poliza">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Póliza</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="notas_credito">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Notas de Crédito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="contrarecibo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Contra-Recibo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_ult_deposito">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Ult. Depósito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="depositos">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Depósitos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="factura_relacionada">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factura Relacionada</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="operador">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Operador</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Unidad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_ult_bitacora">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Ult. Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="ult_comentario">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ult. Comentario Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="observaciones">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Observaciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_prog_cobro">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Prog. Cobro</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="bitacora">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="factoraje">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factoraje</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta_flujo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Flujo Dinero</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_cancelacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Cancelación</span>
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
                            <!-- Las filas se insertarán dinámicamente con JavaScript -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="16">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRetencion">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumDescuento">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotalMXN">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="18"></td>
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
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior">
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 30 registros</span>
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
    
    .badge-timbrada {
        background-color: #17a2b8;
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
        console.log('DOM completamente cargado - Facturación');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Facturación (30 filas)
        const datosFacturacion = [
            // Fila 1
            {
                estatus: 'Activa',
                fecha_creacion: '2026-01-15 10:30',
                fecha_timbrado: '2026-01-15 10:35',
                serie: 'A',
                folio: '1001',
                viajes: '3',
                cliente: 'Maquiladora Industrial',
                rfc: 'MII880101ABC',
                folio_carga: 'CAR-2026-001',
                uso_cfdi: 'G01',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-15',
                fecha_revision: '2026-01-16',
                fecha_vencimiento: '2026-02-14',
                moneda: 'MXN',
                subtotal: 10000.00,
                iva: 1600.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 11600.00,
                total_mxn: 11600.00,
                uuid: 'ABC123DEF456GHI789',
                idccp: 'CCP-001',
                descripcion_adicional: '-',
                poliza: 'POL-2026-001',
                notas_credito: '-',
                contrarecibo: 'CR-001',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Juan Pérez',
                unidad: 'U-001',
                fecha_ult_bitacora: '2026-01-16',
                ult_comentario: 'Factura procesada',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-01',
                bitacora: 'BIT-001',
                factoraje: '-',
                cuenta_flujo: 'CFD-001',
                fecha_cancelacion: '-'
            },
            // Fila 2
            {
                estatus: 'Pagada',
                fecha_creacion: '2026-01-14 09:15',
                fecha_timbrado: '2026-01-14 09:20',
                serie: 'B',
                folio: '1002',
                viajes: '2',
                cliente: 'Cartones del Norte',
                rfc: 'CND890202XYZ',
                folio_carga: 'CAR-2026-002',
                uso_cfdi: 'G03',
                forma_pago: 'Cheque',
                metodo_pago: 'PUE',
                fecha: '2026-01-14',
                fecha_revision: '2026-01-15',
                fecha_vencimiento: '2026-02-13',
                moneda: 'MXN',
                subtotal: 8500.00,
                iva: 1360.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 9860.00,
                total_mxn: 9860.00,
                uuid: 'DEF456GHI789JKL012',
                idccp: 'CCP-002',
                descripcion_adicional: '-',
                poliza: 'POL-2026-002',
                notas_credito: '-',
                contrarecibo: 'CR-002',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'María López',
                unidad: 'U-002',
                fecha_ult_bitacora: '2026-01-15',
                ult_comentario: 'Factura pagada',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-002',
                factoraje: '-',
                cuenta_flujo: 'CFD-002',
                fecha_cancelacion: '-'
            },
            // Fila 3
            {
                estatus: 'Cancelada',
                fecha_creacion: '2026-01-13 14:20',
                fecha_timbrado: '2026-01-13 14:25',
                serie: 'A',
                folio: '1003',
                viajes: '1',
                cliente: 'Transportes del Bajío',
                rfc: 'TBA890123XYZ',
                folio_carga: 'CAR-2026-003',
                uso_cfdi: 'G02',
                forma_pago: 'Efectivo',
                metodo_pago: 'PUE',
                fecha: '2026-01-13',
                fecha_revision: '2026-01-14',
                fecha_vencimiento: '2026-02-12',
                moneda: 'MXN',
                subtotal: 5200.00,
                iva: 832.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 6032.00,
                total_mxn: 6032.00,
                uuid: 'GHI789JKL012MNO345',
                idccp: 'CCP-003',
                descripcion_adicional: '-',
                poliza: 'POL-2026-003',
                notas_credito: '-',
                contrarecibo: 'CR-003',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Carlos Rodríguez',
                unidad: 'U-003',
                fecha_ult_bitacora: '2026-01-14',
                ult_comentario: 'Factura cancelada por error',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-003',
                factoraje: '-',
                cuenta_flujo: 'CFD-003',
                fecha_cancelacion: '2026-01-20'
            },
            // Fila 4
            {
                estatus: 'Activa',
                fecha_creacion: '2026-01-12 11:45',
                fecha_timbrado: '2026-01-12 11:50',
                serie: 'B',
                folio: '1004',
                viajes: '4',
                cliente: 'Logística Monterrey',
                rfc: 'LMN890456ABC',
                folio_carga: 'CAR-2026-004',
                uso_cfdi: 'G01',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-12',
                fecha_revision: '2026-01-13',
                fecha_vencimiento: '2026-02-11',
                moneda: 'MXN',
                subtotal: 15300.00,
                iva: 2448.00,
                retencion: 0.00,
                descuento: 500.00,
                total: 17248.00,
                total_mxn: 17248.00,
                uuid: 'JKL012MNO345PQR678',
                idccp: 'CCP-004',
                descripcion_adicional: '-',
                poliza: 'POL-2026-004',
                notas_credito: '-',
                contrarecibo: 'CR-004',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Ana Martínez',
                unidad: 'U-004',
                fecha_ult_bitacora: '2026-01-13',
                ult_comentario: 'Factura con descuento aplicado',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-05',
                bitacora: 'BIT-004',
                factoraje: '-',
                cuenta_flujo: 'CFD-004',
                fecha_cancelacion: '-'
            },
            // Fila 5
            {
                estatus: 'Pagada',
                fecha_creacion: '2026-01-11 09:30',
                fecha_timbrado: '2026-01-11 09:35',
                serie: 'A',
                folio: '1005',
                viajes: '2',
                cliente: 'Comercializadora del Sur',
                rfc: 'CDS890123DEF',
                folio_carga: 'CAR-2026-005',
                uso_cfdi: 'G03',
                forma_pago: 'Cheque',
                metodo_pago: 'PUE',
                fecha: '2026-01-11',
                fecha_revision: '2026-01-12',
                fecha_vencimiento: '2026-02-10',
                moneda: 'USD',
                subtotal: 500.00,
                iva: 80.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 580.00,
                total_mxn: 11600.00,
                uuid: 'MNO345PQR678STU901',
                idccp: 'CCP-005',
                descripcion_adicional: '-',
                poliza: 'POL-2026-005',
                notas_credito: '-',
                contrarecibo: 'CR-005',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Roberto Sánchez',
                unidad: 'U-005',
                fecha_ult_bitacora: '2026-01-12',
                ult_comentario: 'Factura en USD pagada',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-005',
                factoraje: '-',
                cuenta_flujo: 'CFD-005',
                fecha_cancelacion: '-'
            },
            // Fila 6
            {
                estatus: 'Activa',
                fecha_creacion: '2026-01-10 16:15',
                fecha_timbrado: '2026-01-10 16:20',
                serie: 'B',
                folio: '1006',
                viajes: '3',
                cliente: 'Papelera del Pacífico',
                rfc: 'PDP890123GHI',
                folio_carga: 'CAR-2026-006',
                uso_cfdi: 'G02',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-10',
                fecha_revision: '2026-01-11',
                fecha_vencimiento: '2026-02-09',
                moneda: 'MXN',
                subtotal: 12800.00,
                iva: 2048.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 14848.00,
                total_mxn: 14848.00,
                uuid: 'PQR678STU901VWX234',
                idccp: 'CCP-006',
                descripcion_adicional: '-',
                poliza: 'POL-2026-006',
                notas_credito: '-',
                contrarecibo: 'CR-006',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Laura Gómez',
                unidad: 'U-006',
                fecha_ult_bitacora: '2026-01-11',
                ult_comentario: 'Factura procesada correctamente',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-08',
                bitacora: 'BIT-006',
                factoraje: '-',
                cuenta_flujo: 'CFD-006',
                fecha_cancelacion: '-'
            },
            // Fila 7
            {
                estatus: 'Pagada',
                fecha_creacion: '2026-01-09 13:40',
                fecha_timbrado: '2026-01-09 13:45',
                serie: 'A',
                folio: '1007',
                viajes: '1',
                cliente: 'Ferrocarriles Nacionales',
                rfc: 'FCN890123JKL',
                folio_carga: 'CAR-2026-007',
                uso_cfdi: 'G01',
                forma_pago: 'Efectivo',
                metodo_pago: 'PUE',
                fecha: '2026-01-09',
                fecha_revision: '2026-01-10',
                fecha_vencimiento: '2026-02-08',
                moneda: 'MXN',
                subtotal: 7200.00,
                iva: 1152.00,
                retencion: 0.00,
                descuento: 200.00,
                total: 8152.00,
                total_mxn: 8152.00,
                uuid: 'STU901VWX234YZA567',
                idccp: 'CCP-007',
                descripcion_adicional: '-',
                poliza: 'POL-2026-007',
                notas_credito: '-',
                contrarecibo: 'CR-007',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Pedro Hernández',
                unidad: 'U-007',
                fecha_ult_bitacora: '2026-01-10',
                ult_comentario: 'Factura pagada con descuento',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-007',
                factoraje: '-',
                cuenta_flujo: 'CFD-007',
                fecha_cancelacion: '-'
            },
            // Fila 8
            {
                estatus: 'Activa',
                fecha_creacion: '2026-01-08 10:00',
                fecha_timbrado: '2026-01-08 10:05',
                serie: 'B',
                folio: '1008',
                viajes: '5',
                cliente: 'Minería del Norte',
                rfc: 'MDN890123MNO',
                folio_carga: 'CAR-2026-008',
                uso_cfdi: 'G03',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-08',
                fecha_revision: '2026-01-09',
                fecha_vencimiento: '2026-02-07',
                moneda: 'MXN',
                subtotal: 22500.00,
                iva: 3600.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 26100.00,
                total_mxn: 26100.00,
                uuid: 'VWX234YZA567BCD890',
                idccp: 'CCP-008',
                descripcion_adicional: '-',
                poliza: 'POL-2026-008',
                notas_credito: '-',
                contrarecibo: 'CR-008',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Javier Ruiz',
                unidad: 'U-008',
                fecha_ult_bitacora: '2026-01-09',
                ult_comentario: 'Factura de minería procesada',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-10',
                bitacora: 'BIT-008',
                factoraje: '-',
                cuenta_flujo: 'CFD-008',
                fecha_cancelacion: '-'
            },
            // Fila 9
            {
                estatus: 'Cancelada',
                fecha_creacion: '2026-01-07 12:30',
                fecha_timbrado: '2026-01-07 12:35',
                serie: 'A',
                folio: '1009',
                viajes: '2',
                cliente: 'Autotransportes Mexicanos',
                rfc: 'ATM890123PQR',
                folio_carga: 'CAR-2026-009',
                uso_cfdi: 'G02',
                forma_pago: 'Cheque',
                metodo_pago: 'PUE',
                fecha: '2026-01-07',
                fecha_revision: '2026-01-08',
                fecha_vencimiento: '2026-02-06',
                moneda: 'MXN',
                subtotal: 9800.00,
                iva: 1568.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 11368.00,
                total_mxn: 11368.00,
                uuid: 'YZA567BCD890EFG123',
                idccp: 'CCP-009',
                descripcion_adicional: '-',
                poliza: 'POL-2026-009',
                notas_credito: '-',
                contrarecibo: 'CR-009',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Sofía Castro',
                unidad: 'U-009',
                fecha_ult_bitacora: '2026-01-08',
                ult_comentario: 'Cancelada por error en datos',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-009',
                factoraje: '-',
                cuenta_flujo: 'CFD-009',
                fecha_cancelacion: '2026-01-15'
            },
            // Fila 10
            {
                estatus: 'Activa',
                fecha_creacion: '2026-01-06 15:45',
                fecha_timbrado: '2026-01-06 15:50',
                serie: 'B',
                folio: '1010',
                viajes: '3',
                cliente: 'Cervecería del Centro',
                rfc: 'CDC890123STU',
                folio_carga: 'CAR-2026-010',
                uso_cfdi: 'G01',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-06',
                fecha_revision: '2026-01-07',
                fecha_vencimiento: '2026-02-05',
                moneda: 'MXN',
                subtotal: 18200.00,
                iva: 2912.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 21112.00,
                total_mxn: 21112.00,
                uuid: 'BCD890EFG123HIJ456',
                idccp: 'CCP-010',
                descripcion_adicional: '-',
                poliza: 'POL-2026-010',
                notas_credito: '-',
                contrarecibo: 'CR-010',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Miguel Torres',
                unidad: 'U-010',
                fecha_ult_bitacora: '2026-01-07',
                ult_comentario: 'Factura de cervecería procesada',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-15',
                bitacora: 'BIT-010',
                factoraje: '-',
                cuenta_flujo: 'CFD-010',
                fecha_cancelacion: '-'
            },
            // Fila 11
            {
                estatus: 'Pendiente',
                fecha_creacion: '2026-01-05 08:20',
                fecha_timbrado: '2026-01-05 08:25',
                serie: 'A',
                folio: '1011',
                viajes: '2',
                cliente: 'Textiles del Valle',
                rfc: 'TDV890123UVW',
                folio_carga: 'CAR-2026-011',
                uso_cfdi: 'G03',
                forma_pago: 'Transferencia',
                metodo_pago: 'PPD',
                fecha: '2026-01-05',
                fecha_revision: '2026-01-06',
                fecha_vencimiento: '2026-02-04',
                moneda: 'MXN',
                subtotal: 6500.00,
                iva: 1040.00,
                retencion: 0.00,
                descuento: 0.00,
                total: 7540.00,
                total_mxn: 7540.00,
                uuid: 'EFG123HIJ456KLM789',
                idccp: 'CCP-011',
                descripcion_adicional: '-',
                poliza: 'POL-2026-011',
                notas_credito: '-',
                contrarecibo: 'CR-011',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Diana Flores',
                unidad: 'U-011',
                fecha_ult_bitacora: '2026-01-06',
                ult_comentario: 'Factura pendiente de pago',
                observaciones: '-',
                fecha_prog_cobro: '2026-02-20',
                bitacora: 'BIT-011',
                factoraje: '-',
                cuenta_flujo: 'CFD-011',
                fecha_cancelacion: '-'
            },
            // Fila 12
            {
                estatus: 'Pagada',
                fecha_creacion: '2026-01-04 13:10',
                fecha_timbrado: '2026-01-04 13:15',
                serie: 'B',
                folio: '1012',
                viajes: '4',
                cliente: 'Productos Químicos',
                rfc: 'PQE890123XYZ',
                folio_carga: 'CAR-2026-012',
                uso_cfdi: 'G02',
                forma_pago: 'Cheque',
                metodo_pago: 'PUE',
                fecha: '2026-01-04',
                fecha_revision: '2026-01-05',
                fecha_vencimiento: '2026-02-03',
                moneda: 'MXN',
                subtotal: 14300.00,
                iva: 2288.00,
                retencion: 0.00,
                descuento: 300.00,
                total: 16288.00,
                total_mxn: 16288.00,
                uuid: 'HIJ456KLM789NOP012',
                idccp: 'CCP-012',
                descripcion_adicional: '-',
                poliza: 'POL-2026-012',
                notas_credito: '-',
                contrarecibo: 'CR-012',
                fecha_ult_deposito: '-',
                depositos: '-',
                factura_relacionada: '-',
                operador: 'Luis Ramírez',
                unidad: 'U-012',
                fecha_ult_bitacora: '2026-01-05',
                ult_comentario: 'Factura pagada',
                observaciones: '-',
                fecha_prog_cobro: '-',
                bitacora: 'BIT-012',
                factoraje: '-',
                cuenta_flujo: 'CFD-012',
                fecha_cancelacion: '-'
            }
        ];
        
        datosOriginales = [...datosFacturacion];
        totalRows = datosOriginales.length;
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            return dateString;
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const totalFacturas = datos.length;
            const activas = datos.filter(d => d.estatus === 'Activa').length;
            const pagadas = datos.filter(d => d.estatus === 'Pagada').length;
            const canceladas = datos.filter(d => d.estatus === 'Cancelada').length;
            
            document.getElementById('totalFacturas').textContent = totalFacturas;
            document.getElementById('totalActivas').textContent = activas;
            document.getElementById('totalPagadas').textContent = pagadas;
            document.getElementById('totalCanceladas').textContent = canceladas;
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'estatus': return item.estatus || 'Sin estatus';
                    case 'fecha_creacion': return item.fecha_creacion || 'Sin fecha';
                    case 'fecha_timbrado': return item.fecha_timbrado || 'Sin fecha';
                    case 'serie': return item.serie || 'Sin serie';
                    case 'folio': return item.folio || 'Sin folio';
                    case 'viajes': return item.viajes || '0';
                    case 'cliente': return item.cliente || 'Sin cliente';
                    case 'rfc': return item.rfc || 'Sin RFC';
                    case 'folio_carga': return item.folio_carga || 'Sin folio';
                    case 'uso_cfdi': return item.uso_cfdi || 'Sin uso';
                    case 'forma_pago': return item.forma_pago || 'Sin forma';
                    case 'metodo_pago': return item.metodo_pago || 'Sin método';
                    case 'fecha': return item.fecha || 'Sin fecha';
                    case 'fecha_revision': return item.fecha_revision || 'Sin fecha';
                    case 'fecha_vencimiento': return item.fecha_vencimiento || 'Sin fecha';
                    case 'moneda': return item.moneda || 'Sin moneda';
                    case 'subtotal': return item.subtotal ? item.subtotal.toString() : '0';
                    case 'iva': return item.iva ? item.iva.toString() : '0';
                    case 'retencion': return item.retencion ? item.retencion.toString() : '0';
                    case 'descuento': return item.descuento ? item.descuento.toString() : '0';
                    case 'total': return item.total ? item.total.toString() : '0';
                    case 'total_mxn': return item.total_mxn ? item.total_mxn.toString() : '0';
                    case 'uuid': return item.uuid || 'Sin UUID';
                    case 'idccp': return item.idccp || 'Sin CCP';
                    case 'descripcion_adicional': return item.descripcion_adicional || 'Sin descripción';
                    case 'poliza': return item.poliza || 'Sin póliza';
                    case 'notas_credito': return item.notas_credito || 'Sin notas';
                    case 'contrarecibo': return item.contrarecibo || 'Sin CR';
                    case 'fecha_ult_deposito': return item.fecha_ult_deposito || 'Sin fecha';
                    case 'depositos': return item.depositos || 'Sin depósitos';
                    case 'factura_relacionada': return item.factura_relacionada || 'Sin relación';
                    case 'operador': return item.operador || 'Sin operador';
                    case 'unidad': return item.unidad || 'Sin unidad';
                    case 'fecha_ult_bitacora': return item.fecha_ult_bitacora || 'Sin fecha';
                    case 'ult_comentario': return item.ult_comentario || 'Sin comentario';
                    case 'observaciones': return item.observaciones || 'Sin observaciones';
                    case 'fecha_prog_cobro': return item.fecha_prog_cobro || 'Sin fecha';
                    case 'bitacora': return item.bitacora || 'Sin bitácora';
                    case 'factoraje': return item.factoraje || 'Sin factoraje';
                    case 'cuenta_flujo': return item.cuenta_flujo || 'Sin cuenta';
                    case 'fecha_cancelacion': return item.fecha_cancelacion || 'Sin fecha';
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
                            case 'fecha_creacion': return item.fecha_creacion || 'Sin fecha';
                            case 'fecha_timbrado': return item.fecha_timbrado || 'Sin fecha';
                            case 'serie': return item.serie || 'Sin serie';
                            case 'folio': return item.folio || 'Sin folio';
                            case 'viajes': return item.viajes || '0';
                            case 'cliente': return item.cliente || 'Sin cliente';
                            case 'rfc': return item.rfc || 'Sin RFC';
                            case 'folio_carga': return item.folio_carga || 'Sin folio';
                            case 'uso_cfdi': return item.uso_cfdi || 'Sin uso';
                            case 'forma_pago': return item.forma_pago || 'Sin forma';
                            case 'metodo_pago': return item.metodo_pago || 'Sin método';
                            case 'fecha': return item.fecha || 'Sin fecha';
                            case 'fecha_revision': return item.fecha_revision || 'Sin fecha';
                            case 'fecha_vencimiento': return item.fecha_vencimiento || 'Sin fecha';
                            case 'moneda': return item.moneda || 'Sin moneda';
                            case 'subtotal': return item.subtotal || 0;
                            case 'iva': return item.iva || 0;
                            case 'retencion': return item.retencion || 0;
                            case 'descuento': return item.descuento || 0;
                            case 'total': return item.total || 0;
                            case 'total_mxn': return item.total_mxn || 0;
                            case 'uuid': return item.uuid || 'Sin UUID';
                            case 'idccp': return item.idccp || 'Sin CCP';
                            case 'descripcion_adicional': return item.descripcion_adicional || 'Sin descripción';
                            case 'poliza': return item.poliza || 'Sin póliza';
                            case 'notas_credito': return item.notas_credito || 'Sin notas';
                            case 'contrarecibo': return item.contrarecibo || 'Sin CR';
                            case 'fecha_ult_deposito': return item.fecha_ult_deposito || 'Sin fecha';
                            case 'depositos': return item.depositos || 'Sin depósitos';
                            case 'factura_relacionada': return item.factura_relacionada || 'Sin relación';
                            case 'operador': return item.operador || 'Sin operador';
                            case 'unidad': return item.unidad || 'Sin unidad';
                            case 'fecha_ult_bitacora': return item.fecha_ult_bitacora || 'Sin fecha';
                            case 'ult_comentario': return item.ult_comentario || 'Sin comentario';
                            case 'observaciones': return item.observaciones || 'Sin observaciones';
                            case 'fecha_prog_cobro': return item.fecha_prog_cobro || 'Sin fecha';
                            case 'bitacora': return item.bitacora || 'Sin bitácora';
                            case 'factoraje': return item.factoraje || 'Sin factoraje';
                            case 'cuenta_flujo': return item.cuenta_flujo || 'Sin cuenta';
                            case 'fecha_cancelacion': return item.fecha_cancelacion || 'Sin fecha';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalSubtotal: item.subtotal || 0,
                        totalIva: item.iva || 0,
                        totalRetencion: item.retencion || 0,
                        totalDescuento: item.descuento || 0,
                        totalGeneral: item.total || 0,
                        totalMXN: item.total_mxn || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalSubtotal += item.subtotal || 0;
                    grupo.totalIva += item.iva || 0;
                    grupo.totalRetencion += item.retencion || 0;
                    grupo.totalDescuento += item.descuento || 0;
                    grupo.totalGeneral += item.total || 0;
                    grupo.totalMXN += item.total_mxn || 0;
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
            let totalRetencion = 0;
            let totalDescuento = 0;
            let totalGeneral = 0;
            let totalMXN = 0;
            
            datos.forEach(item => {
                totalSubtotal += item.subtotal || 0;
                totalIva += item.iva || 0;
                totalRetencion += item.retencion || 0;
                totalDescuento += item.descuento || 0;
                totalGeneral += item.total || 0;
                totalMXN += item.total_mxn || 0;
            });
            
            document.getElementById('sumSubtotal').textContent = formatCurrency(totalSubtotal);
            document.getElementById('sumIva').textContent = formatCurrency(totalIva);
            document.getElementById('sumRetencion').textContent = formatCurrency(totalRetencion);
            document.getElementById('sumDescuento').textContent = formatCurrency(totalDescuento);
            document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
            document.getElementById('sumTotalMXN').textContent = formatCurrency(totalMXN);
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
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
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
                document.getElementById('sumRetencion').textContent = '$0.00';
                document.getElementById('sumDescuento').textContent = '$0.00';
                document.getElementById('sumTotal').textContent = '$0.00';
                document.getElementById('sumTotalMXN').textContent = '$0.00';
                
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
                    
                    let estatusPredominante = 'Pendiente';
                    let maxCount = 0;
                    for (const [estatus, count] of Object.entries(estatusCounts)) {
                        if (count > maxCount) {
                            maxCount = count;
                            estatusPredominante = estatus;
                        }
                    }
                    
                    let badgeClass = 'badge-pendiente';
                    if (estatusPredominante === 'Activa') badgeClass = 'badge-activa';
                    else if (estatusPredominante === 'Pagada') badgeClass = 'badge-pagada';
                    else if (estatusPredominante === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="42">
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
                            let itemBadgeClass = 'badge-pendiente';
                            if (item.estatus === 'Activa') itemBadgeClass = 'badge-activa';
                            else if (item.estatus === 'Pagada') itemBadgeClass = 'badge-pagada';
                            else if (item.estatus === 'Cancelada') itemBadgeClass = 'badge-cancelada';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;"><span class="badge ${itemBadgeClass}">${item.estatus || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_creacion)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_timbrado)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.viajes || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_carga || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.uso_cfdi || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_revision)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_vencimiento)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.moneda || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.retencion ? formatCurrency(item.retencion) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total_mxn ? formatCurrency(item.total_mxn) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.uuid || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.idccp || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion_adicional || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.poliza || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.notas_credito || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contrarecibo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_ult_deposito)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.depositos || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factura_relacionada || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.operador || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.unidad || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_ult_bitacora)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.ult_comentario || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_prog_cobro)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.bitacora || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factoraje || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_cancelacion)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
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
                    
                    let badgeClass = 'badge-pendiente';
                    if (item.estatus === 'Activa') badgeClass = 'badge-activa';
                    else if (item.estatus === 'Pagada') badgeClass = 'badge-pagada';
                    else if (item.estatus === 'Cancelada') badgeClass = 'badge-cancelada';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.estatus || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_creacion)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_timbrado)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.viajes || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_carga || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.uso_cfdi || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_revision)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_vencimiento)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.moneda || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.retencion ? formatCurrency(item.retencion) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total_mxn ? formatCurrency(item.total_mxn) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.uuid || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.idccp || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion_adicional || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.poliza || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.notas_credito || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contrarecibo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_ult_deposito)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.depositos || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factura_relacionada || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.operador || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.unidad || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_ult_bitacora)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.ult_comentario || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_prog_cobro)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.bitacora || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factoraje || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_cancelacion)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
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
                        'fecha_timbrado': 'Fecha Timbrado',
                        'serie': 'Serie',
                        'folio': 'Folio',
                        'viajes': 'Viajes',
                        'cliente': 'Cliente',
                        'rfc': 'RFC',
                        'folio_carga': 'Folio Carga',
                        'uso_cfdi': 'Uso CFDI',
                        'forma_pago': 'Forma Pago',
                        'metodo_pago': 'Método Pago',
                        'fecha': 'Fecha',
                        'fecha_revision': 'Fecha Revisión',
                        'fecha_vencimiento': 'Fecha Vencimiento',
                        'moneda': 'Moneda',
                        'subtotal': 'Subtotal',
                        'iva': 'IVA',
                        'retencion': 'Retención',
                        'descuento': 'Descuento',
                        'total': 'Total',
                        'total_mxn': 'Total MXN',
                        'uuid': 'UUID',
                        'idccp': 'IdCCP',
                        'descripcion_adicional': 'Descripción Adicional',
                        'poliza': 'Póliza',
                        'notas_credito': 'Notas de Crédito',
                        'contrarecibo': 'Contra-Recibo',
                        'fecha_ult_deposito': 'Fecha Ult. Depósito',
                        'depositos': 'Depósitos',
                        'factura_relacionada': 'Factura Relacionada',
                        'operador': 'Operador',
                        'unidad': 'No. Unidad',
                        'fecha_ult_bitacora': 'Fecha Ult. Bitácora',
                        'ult_comentario': 'Ult. Comentario Bitácora',
                        'observaciones': 'Observaciones',
                        'fecha_prog_cobro': 'Fecha Prog. Cobro',
                        'bitacora': 'Bitácora',
                        'factoraje': 'Factoraje',
                        'cuenta_flujo': 'Cuenta Flujo Dinero',
                        'fecha_cancelacion': 'Fecha Cancelación'
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
        cargarTabla(datosFacturacion);
        
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
            alert('Agregar Factura - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaFacturacion', 'Facturacion');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosFacturacion.filter(item => 
                item.folio?.toLowerCase().includes(busqueda) ||
                item.cliente?.toLowerCase().includes(busqueda) ||
                item.rfc?.toLowerCase().includes(busqueda) ||
                item.estatus?.toLowerCase().includes(busqueda) ||
                item.operador?.toLowerCase().includes(busqueda) ||
                item.unidad?.toLowerCase().includes(busqueda)
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
                alert('Editar Factura - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar esta factura?')) {
                    alert('Eliminar Factura - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-alt')) {
                alert('Documentar Factura - Funcionalidad en desarrollo');
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