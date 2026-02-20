@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Facturas Proveedores -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Facturas Proveedores
                </h2>
            </div>

            <div class="card-body p-4">
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
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #2378e1; font-size: 16px;" title="Agregar">
                                <i class="fas fa-plus" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay facturas de proveedores para mostrar</p>
                </div>

                <!-- Tabla de Facturas Proveedores -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFacturasProveedores" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_comprobante">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo Comprobante</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proveedor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proveedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="programacion_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Programación Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="entrada_almacen">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Entrada de Almacén</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uuid">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>UUID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_vencimiento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Vencimiento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="expedicion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Expedición</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="uso_cfdi">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Uso CFDI</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="metodo_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="forma_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="moneda">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_cambio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo Cambio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="dias_credito">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Días Crédito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="observaciones">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Observaciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descuento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descuento</span>
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
                                        <span>R IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="risr">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>ISR</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total_mxn">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total MXN</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="abonos">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Abonos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="saldo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Saldo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="transferencia">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Transferencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_trans">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Transferencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="poliza">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Póliza</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta_resultados">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Edo. Resultados</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="orden_compra">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Orden Compra</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="orden_servicio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Orden Servicio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta_flujo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Flujo Dinero</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="gasto_fijo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Gasto Fijo</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="19">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumDescuento">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRiva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRisr">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotalMxn">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumAbonos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSaldo">$0.00</td>
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
        border-bottom: 2px solid #2378e1;
    }
    
    .semaforo .card-header h2 {
        color: #2378e1 !important;
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
        cursor: pointer;
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
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-pagada {
        background-color: #28a745;
        color: white;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-vencida {
        background-color: #dc3545;
        color: white;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #2378e1;
        color: #000000 !important;
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
        
        input[type="date"], select {
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
        console.log('DOM completamente cargado - Facturas Proveedores');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let paginaActual = 1;
        const registrosPorPagina = 8;
        
        // Datos de ejemplo para Facturas Proveedores
        const datosFacturasProveedores = [
            {
                factura_cxp_id: 1,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pendiente',
                serie: 'F',
                folio: '1001',
                contacto: 'Transportes del Bajío',
                fecha: '2026-02-01',
                programacion_pago_id: 'PP-001',
                almacen_entrada_id: 'EA-001',
                UUID: 'ABC123DEF456GHI789',
                fecha_vencimiento: '2026-03-01',
                lugar_expedicion: 'Monterrey',
                uso_cfdi: 'G01',
                metodo_pago: 'PPD',
                forma_pago: 'Transferencia',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Factura de servicios de transporte',
                subtotal: 125800.00,
                descuento: 0.00,
                iva: 20128.00,
                riva: 0.00,
                risr: 0.00,
                total: 145928.00,
                total_mxn: 145928.00,
                pago_parcial: 0.00,
                saldo: 145928.00,
                cheque_transferencia_id: null,
                fecha_trans: null,
                polizas_contables_id: 'POL-001',
                cuenta_edo_resultados: '6000-01',
                orden_compra_id: 'OC-001',
                folio_orden: 'OS-001',
                cuenta_flujo_dinero: 'CFD-001',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 2,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pagada',
                serie: 'F',
                folio: '1002',
                contacto: 'Logística Monterrey',
                fecha: '2026-02-02',
                programacion_pago_id: 'PP-002',
                almacen_entrada_id: 'EA-002',
                UUID: 'DEF456GHI789JKL012',
                fecha_vencimiento: '2026-03-02',
                lugar_expedicion: 'Guadalajara',
                uso_cfdi: 'G03',
                metodo_pago: 'PUE',
                forma_pago: 'Cheque',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Pago de facturas de materiales',
                subtotal: 87500.00,
                descuento: 0.00,
                iva: 14000.00,
                riva: 0.00,
                risr: 0.00,
                total: 101500.00,
                total_mxn: 101500.00,
                pago_parcial: 101500.00,
                saldo: 0.00,
                cheque_transferencia_id: 'CT-002',
                fecha_trans: '2026-02-15',
                polizas_contables_id: 'POL-002',
                cuenta_edo_resultados: '6000-02',
                orden_compra_id: 'OC-002',
                folio_orden: 'OS-002',
                cuenta_flujo_dinero: 'CFD-002',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 3,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pendiente',
                serie: 'F',
                folio: '1003',
                contacto: 'Autotransportes Mexicanos',
                fecha: '2026-02-03',
                programacion_pago_id: 'PP-003',
                almacen_entrada_id: 'EA-003',
                UUID: 'GHI789JKL012MNO345',
                fecha_vencimiento: '2026-03-03',
                lugar_expedicion: 'CDMX',
                uso_cfdi: 'G02',
                metodo_pago: 'PPD',
                forma_pago: 'Transferencia',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Servicios de flete',
                subtotal: 62300.00,
                descuento: 0.00,
                iva: 9968.00,
                riva: 0.00,
                risr: 0.00,
                total: 72268.00,
                total_mxn: 72268.00,
                pago_parcial: 0.00,
                saldo: 72268.00,
                cheque_transferencia_id: null,
                fecha_trans: null,
                polizas_contables_id: 'POL-003',
                cuenta_edo_resultados: '6000-03',
                orden_compra_id: 'OC-003',
                folio_orden: 'OS-003',
                cuenta_flujo_dinero: 'CFD-003',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 4,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pagada',
                serie: 'F',
                folio: '1004',
                contacto: 'Ferrocarriles Nacionales',
                fecha: '2026-02-04',
                programacion_pago_id: 'PP-004',
                almacen_entrada_id: 'EA-004',
                UUID: 'JKL012MNO345PQR678',
                fecha_vencimiento: '2026-03-04',
                lugar_expedicion: 'Querétaro',
                uso_cfdi: 'G01',
                metodo_pago: 'PUE',
                forma_pago: 'Transferencia',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Pago de servicios ferroviarios',
                subtotal: 158200.00,
                descuento: 0.00,
                iva: 25312.00,
                riva: 0.00,
                risr: 0.00,
                total: 183512.00,
                total_mxn: 183512.00,
                pago_parcial: 158200.00,
                saldo: 25312.00,
                cheque_transferencia_id: 'CT-004',
                fecha_trans: '2026-02-16',
                polizas_contables_id: 'POL-004',
                cuenta_edo_resultados: '6000-04',
                orden_compra_id: 'OC-004',
                folio_orden: 'OS-004',
                cuenta_flujo_dinero: 'CFD-004',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 5,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Cancelada',
                serie: 'F',
                folio: '1005',
                contacto: 'Cervecería del Centro',
                fecha: '2026-02-05',
                programacion_pago_id: null,
                almacen_entrada_id: null,
                UUID: 'MNO345PQR678STU901',
                fecha_vencimiento: '2026-03-05',
                lugar_expedicion: 'Puebla',
                uso_cfdi: 'G03',
                metodo_pago: 'PPD',
                forma_pago: 'Cheque',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Cancelado por error',
                subtotal: 93400.00,
                descuento: 0.00,
                iva: 14944.00,
                riva: 0.00,
                risr: 0.00,
                total: 108344.00,
                total_mxn: 108344.00,
                pago_parcial: 0.00,
                saldo: 108344.00,
                cheque_transferencia_id: null,
                fecha_trans: null,
                polizas_contables_id: null,
                cuenta_edo_resultados: '6000-05',
                orden_compra_id: 'OC-005',
                folio_orden: 'OS-005',
                cuenta_flujo_dinero: 'CFD-005',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 6,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pendiente',
                serie: 'F',
                folio: '1006',
                contacto: 'Papelera del Pacífico',
                fecha: '2026-02-06',
                programacion_pago_id: 'PP-006',
                almacen_entrada_id: 'EA-006',
                UUID: 'PQR678STU901VWX234',
                fecha_vencimiento: '2026-03-06',
                lugar_expedicion: 'Toluca',
                uso_cfdi: 'G02',
                metodo_pago: 'PPD',
                forma_pago: 'Transferencia',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Compra de materiales',
                subtotal: 45600.00,
                descuento: 0.00,
                iva: 7296.00,
                riva: 0.00,
                risr: 0.00,
                total: 52896.00,
                total_mxn: 52896.00,
                pago_parcial: 0.00,
                saldo: 52896.00,
                cheque_transferencia_id: null,
                fecha_trans: null,
                polizas_contables_id: 'POL-006',
                cuenta_edo_resultados: '6000-06',
                orden_compra_id: 'OC-006',
                folio_orden: 'OS-006',
                cuenta_flujo_dinero: 'CFD-006',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 7,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Pagada',
                serie: 'F',
                folio: '1007',
                contacto: 'Minería del Norte',
                fecha: '2026-02-07',
                programacion_pago_id: 'PP-007',
                almacen_entrada_id: 'EA-007',
                UUID: 'STU901VWX234YZA567',
                fecha_vencimiento: '2026-03-07',
                lugar_expedicion: 'Zacatecas',
                uso_cfdi: 'G01',
                metodo_pago: 'PUE',
                forma_pago: 'Transferencia',
                cat_monedas_clave: 'USD',
                tipo_cambio: 20.50,
                dias_credito: 30,
                observaciones: 'Pago en USD',
                subtotal: 120000.00,
                descuento: 0.00,
                iva: 19200.00,
                riva: 0.00,
                risr: 0.00,
                total: 139200.00,
                total_mxn: 2853600.00,
                pago_parcial: 139200.00,
                saldo: 0.00,
                cheque_transferencia_id: 'CT-007',
                fecha_trans: '2026-02-17',
                polizas_contables_id: 'POL-007',
                cuenta_edo_resultados: '6000-07',
                orden_compra_id: 'OC-007',
                folio_orden: 'OS-007',
                cuenta_flujo_dinero: 'CFD-007',
                gasto_fijo_id: null
            },
            {
                factura_cxp_id: 8,
                tipo_comprobante_txt: 'Factura',
                estatus: 'Cancelada',
                serie: 'F',
                folio: '1008',
                contacto: 'Comercializadora del Sur',
                fecha: '2026-02-08',
                programacion_pago_id: null,
                almacen_entrada_id: null,
                UUID: 'VWX234YZA567BCD890',
                fecha_vencimiento: '2026-03-08',
                lugar_expedicion: 'Oaxaca',
                uso_cfdi: 'G03',
                metodo_pago: 'PPD',
                forma_pago: 'Cheque',
                cat_monedas_clave: 'MXN',
                tipo_cambio: 1.00,
                dias_credito: 30,
                observaciones: 'Cancelado por duplicidad',
                subtotal: 25000.00,
                descuento: 0.00,
                iva: 4000.00,
                riva: 0.00,
                risr: 0.00,
                total: 29000.00,
                total_mxn: 29000.00,
                pago_parcial: 0.00,
                saldo: 29000.00,
                cheque_transferencia_id: null,
                fecha_trans: null,
                polizas_contables_id: null,
                cuenta_edo_resultados: '6000-08',
                orden_compra_id: 'OC-008',
                folio_orden: 'OS-008',
                cuenta_flujo_dinero: 'CFD-008',
                gasto_fijo_id: null
            }
        ];

        datosOriginales = [...datosFacturasProveedores];
        let datosFiltrados = [...datosFacturasProveedores];
        
        // Elementos del DOM
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnAgregar = document.getElementById('btnAgregar');
        const btnExcel = document.getElementById('btnExcel');
        const btnColumnas = document.getElementById('btnColumnas');
        const buscador = document.getElementById('buscador');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const tablaFoot = document.getElementById('tablaFoot');
        const totalRegistros = document.getElementById('totalRegistros');
        const paginacionInfo = document.getElementById('paginacionInfo');
        const textoAgrupar = document.getElementById('textoAgrupar');
        
        // Elementos de totales
        const sumSubtotal = document.getElementById('sumSubtotal');
        const sumDescuento = document.getElementById('sumDescuento');
        const sumIva = document.getElementById('sumIva');
        const sumRiva = document.getElementById('sumRiva');
        const sumRisr = document.getElementById('sumRisr');
        const sumTotal = document.getElementById('sumTotal');
        const sumTotalMxn = document.getElementById('sumTotalMxn');
        const sumAbonos = document.getElementById('sumAbonos');
        const sumSaldo = document.getElementById('sumSaldo');
        
        // Elementos de paginación
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit' });
        }
        
        // Función para obtener la clase del badge según estatus
        function getBadgeClass(estatus) {
            if (estatus === 'Pendiente') return 'badge-pendiente';
            if (estatus === 'Pagada') return 'badge-pagada';
            if (estatus === 'Cancelada') return 'badge-cancelada';
            if (estatus === 'Vencida') return 'badge-vencida';
            return 'badge-pendiente';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'tipo_comprobante': return item.tipo_comprobante_txt || 'Sin tipo';
                    case 'estatus': return item.estatus || 'Sin estatus';
                    case 'serie': return item.serie || 'Sin serie';
                    case 'folio': return item.folio || 'Sin folio';
                    case 'proveedor': return item.contacto || 'Sin proveedor';
                    case 'fecha': return item.fecha || 'Sin fecha';
                    case 'programacion_pago': return item.programacion_pago_id || 'Sin PP';
                    case 'entrada_almacen': return item.almacen_entrada_id || 'Sin EA';
                    case 'uuid': return item.UUID || 'Sin UUID';
                    case 'fecha_vencimiento': return item.fecha_vencimiento || 'Sin fecha';
                    case 'expedicion': return item.lugar_expedicion || 'Sin expedición';
                    case 'uso_cfdi': return item.uso_cfdi || 'Sin uso';
                    case 'metodo_pago': return item.metodo_pago || 'Sin método';
                    case 'forma_pago': return item.forma_pago || 'Sin forma';
                    case 'moneda': return item.cat_monedas_clave || 'Sin moneda';
                    case 'tipo_cambio': return item.tipo_cambio ? item.tipo_cambio.toString() : '0';
                    case 'dias_credito': return item.dias_credito ? item.dias_credito.toString() : '0';
                    case 'observaciones': return item.observaciones || 'Sin obs';
                    case 'subtotal': return item.subtotal ? item.subtotal.toString() : '0';
                    case 'descuento': return item.descuento ? item.descuento.toString() : '0';
                    case 'iva': return item.iva ? item.iva.toString() : '0';
                    case 'riva': return item.riva ? item.riva.toString() : '0';
                    case 'risr': return item.risr ? item.risr.toString() : '0';
                    case 'total': return item.total ? item.total.toString() : '0';
                    case 'total_mxn': return item.total_mxn ? item.total_mxn.toString() : '0';
                    case 'abonos': return item.pago_parcial ? item.pago_parcial.toString() : '0';
                    case 'saldo': return item.saldo ? item.saldo.toString() : '0';
                    case 'transferencia': return item.cheque_transferencia_id || 'Sin trans';
                    case 'fecha_trans': return item.fecha_trans || 'Sin fecha';
                    case 'poliza': return item.polizas_contables_id || 'Sin póliza';
                    case 'cuenta_resultados': return item.cuenta_edo_resultados || 'Sin cuenta';
                    case 'orden_compra': return item.orden_compra_id || 'Sin OC';
                    case 'orden_servicio': return item.folio_orden || 'Sin OS';
                    case 'cuenta_flujo': return item.cuenta_flujo_dinero || 'Sin CFD';
                    case 'gasto_fijo': return item.gasto_fijo_id || 'Sin gasto';
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
                            case 'tipo_comprobante': return item.tipo_comprobante_txt || 'Sin tipo';
                            case 'estatus': return item.estatus || 'Sin estatus';
                            case 'serie': return item.serie || 'Sin serie';
                            case 'folio': return item.folio || 'Sin folio';
                            case 'proveedor': return item.contacto || 'Sin proveedor';
                            case 'fecha': return item.fecha ? formatDate(item.fecha) : 'Sin fecha';
                            case 'programacion_pago': return item.programacion_pago_id || 'Sin PP';
                            case 'entrada_almacen': return item.almacen_entrada_id || 'Sin EA';
                            case 'uuid': return item.UUID ? item.UUID.substring(0, 8) + '...' : 'Sin UUID';
                            case 'fecha_vencimiento': return item.fecha_vencimiento ? formatDate(item.fecha_vencimiento) : 'Sin fecha';
                            case 'expedicion': return item.lugar_expedicion || 'Sin expedición';
                            case 'uso_cfdi': return item.uso_cfdi || 'Sin uso';
                            case 'metodo_pago': return item.metodo_pago || 'Sin método';
                            case 'forma_pago': return item.forma_pago || 'Sin forma';
                            case 'moneda': return item.cat_monedas_clave || 'Sin moneda';
                            case 'tipo_cambio': return item.tipo_cambio || 0;
                            case 'dias_credito': return item.dias_credito || 0;
                            case 'observaciones': return item.observaciones || 'Sin obs';
                            case 'subtotal': return item.subtotal || 0;
                            case 'descuento': return item.descuento || 0;
                            case 'iva': return item.iva || 0;
                            case 'riva': return item.riva || 0;
                            case 'risr': return item.risr || 0;
                            case 'total': return item.total || 0;
                            case 'total_mxn': return item.total_mxn || 0;
                            case 'abonos': return item.pago_parcial || 0;
                            case 'saldo': return item.saldo || 0;
                            case 'transferencia': return item.cheque_transferencia_id || 'Sin trans';
                            case 'fecha_trans': return item.fecha_trans ? formatDate(item.fecha_trans) : 'Sin fecha';
                            case 'poliza': return item.polizas_contables_id || 'Sin póliza';
                            case 'cuenta_resultados': return item.cuenta_edo_resultados || 'Sin cuenta';
                            case 'orden_compra': return item.orden_compra_id || 'Sin OC';
                            case 'orden_servicio': return item.folio_orden || 'Sin OS';
                            case 'cuenta_flujo': return item.cuenta_flujo_dinero || 'Sin CFD';
                            case 'gasto_fijo': return item.gasto_fijo_id || 'Sin gasto';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalSubtotal: item.subtotal || 0,
                        totalDescuento: item.descuento || 0,
                        totalIva: item.iva || 0,
                        totalRiva: item.riva || 0,
                        totalRisr: item.risr || 0,
                        totalGeneral: item.total || 0,
                        totalMxn: item.total_mxn || 0,
                        totalAbonos: item.pago_parcial || 0,
                        totalSaldo: item.saldo || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalSubtotal += item.subtotal || 0;
                    grupo.totalDescuento += item.descuento || 0;
                    grupo.totalIva += item.iva || 0;
                    grupo.totalRiva += item.riva || 0;
                    grupo.totalRisr += item.risr || 0;
                    grupo.totalGeneral += item.total || 0;
                    grupo.totalMxn += item.total_mxn || 0;
                    grupo.totalAbonos += item.pago_parcial || 0;
                    grupo.totalSaldo += item.saldo || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (paginaActual - 1) * registrosPorPagina;
            const end = start + registrosPorPagina;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPaginas = Math.ceil(total / registrosPorPagina);
            paginaActualSpan.textContent = paginaActual;
            
            // Mostrar/ocultar botones de página según sea necesario
            document.querySelectorAll('.pagina-btn').forEach(btn => {
                const pagina = parseInt(btn.dataset.pagina);
                if (pagina <= totalPaginas) {
                    btn.style.display = 'inline-block';
                } else {
                    btn.style.display = 'none';
                }
            });
            
            const inicio = total > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
            const fin = Math.min(paginaActual * registrosPorPagina, total);
            paginacionInfo.textContent = `Mostrando ${inicio}-${fin} de ${total} registros`;
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let sumaSubtotal = 0;
            let sumaDescuento = 0;
            let sumaIva = 0;
            let sumaRiva = 0;
            let sumaRisr = 0;
            let sumaTotal = 0;
            let sumaTotalMxn = 0;
            let sumaAbonos = 0;
            let sumaSaldo = 0;
            
            datos.forEach(item => {
                sumaSubtotal += item.subtotal || 0;
                sumaDescuento += item.descuento || 0;
                sumaIva += item.iva || 0;
                sumaRiva += item.riva || 0;
                sumaRisr += item.risr || 0;
                sumaTotal += item.total || 0;
                sumaTotalMxn += item.total_mxn || 0;
                sumaAbonos += item.pago_parcial || 0;
                sumaSaldo += item.saldo || 0;
            });
            
            totalRegistros.textContent = datos.length;
            sumSubtotal.textContent = formatCurrency(sumaSubtotal);
            sumDescuento.textContent = formatCurrency(sumaDescuento);
            sumIva.textContent = formatCurrency(sumaIva);
            sumRiva.textContent = formatCurrency(sumaRiva);
            sumRisr.textContent = formatCurrency(sumaRisr);
            sumTotal.textContent = formatCurrency(sumaTotal);
            sumTotalMxn.textContent = formatCurrency(sumaTotalMxn);
            sumAbonos.textContent = formatCurrency(sumaAbonos);
            sumSaldo.textContent = formatCurrency(sumaSaldo);
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            if (!tablaBody) return;
            
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
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                totalRegistros.textContent = '0';
                sumSubtotal.textContent = formatCurrency(0);
                sumDescuento.textContent = formatCurrency(0);
                sumIva.textContent = formatCurrency(0);
                sumRiva.textContent = formatCurrency(0);
                sumRisr.textContent = formatCurrency(0);
                sumTotal.textContent = formatCurrency(0);
                sumTotalMxn.textContent = formatCurrency(0);
                sumAbonos.textContent = formatCurrency(0);
                sumSaldo.textContent = formatCurrency(0);
                
                paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
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
                    if (estatusPredominante === 'Pagada') badgeClass = 'badge-pagada';
                    else if (estatusPredominante === 'Cancelada') badgeClass = 'badge-cancelada';
                    else if (estatusPredominante === 'Vencida') badgeClass = 'badge-vencida';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="37">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Subtotal: ${formatCurrency(grupo.totalSubtotal)} - Total: ${formatCurrency(grupo.totalGeneral)} - Saldo: ${formatCurrency(grupo.totalSaldo)})
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
                            if (item.estatus === 'Pagada') itemBadgeClass = 'badge-pagada';
                            else if (item.estatus === 'Cancelada') itemBadgeClass = 'badge-cancelada';
                            else if (item.estatus === 'Vencida') itemBadgeClass = 'badge-vencida';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.tipo_comprobante_txt || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <span class="badge ${itemBadgeClass}">${item.estatus || '-'}</span>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contacto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.programacion_pago_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.almacen_entrada_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.UUID ? item.UUID.substring(0, 8) + '...' : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_vencimiento ? formatDate(item.fecha_vencimiento) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.lugar_expedicion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.uso_cfdi || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_monedas_clave || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.tipo_cambio ? item.tipo_cambio.toFixed(2) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.dias_credito || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.riva ? formatCurrency(item.riva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.risr ? formatCurrency(item.risr) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total_mxn ? formatCurrency(item.total_mxn) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.pago_parcial ? formatCurrency(item.pago_parcial) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.saldo ? formatCurrency(item.saldo) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cheque_transferencia_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_trans ? formatDate(item.fecha_trans) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.polizas_contables_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_edo_resultados || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.orden_compra_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_orden || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo_dinero || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.gasto_fijo_id || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.factura_cxp_id}"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.factura_cxp_id}"></i>
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.factura_cxp_id}"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.factura_cxp_id}"></i>
                                        <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML" data-id="${item.factura_cxp_id}"></i>
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
                
                pageData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-pendiente';
                    if (item.estatus === 'Pagada') badgeClass = 'badge-pagada';
                    else if (item.estatus === 'Cancelada') badgeClass = 'badge-cancelada';
                    else if (item.estatus === 'Vencida') badgeClass = 'badge-vencida';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo_comprobante_txt || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                            <span class="badge ${badgeClass}">${item.estatus || '-'}</span>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.serie || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contacto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.programacion_pago_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.almacen_entrada_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; font-size: 10px;">${item.UUID ? item.UUID.substring(0, 8) + '...' : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_vencimiento ? formatDate(item.fecha_vencimiento) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.lugar_expedicion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.uso_cfdi || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.metodo_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cat_monedas_clave || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.tipo_cambio ? item.tipo_cambio.toFixed(2) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.dias_credito || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.descuento ? formatCurrency(item.descuento) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.riva ? formatCurrency(item.riva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.risr ? formatCurrency(item.risr) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total_mxn ? formatCurrency(item.total_mxn) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.pago_parcial ? formatCurrency(item.pago_parcial) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.saldo ? formatCurrency(item.saldo) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cheque_transferencia_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha_trans ? formatDate(item.fecha_trans) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.polizas_contables_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_edo_resultados || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.orden_compra_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.folio_orden || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cuenta_flujo_dinero || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.gasto_fijo_id || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" data-id="${item.factura_cxp_id}"></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" data-id="${item.factura_cxp_id}"></i>
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles" data-id="${item.factura_cxp_id}"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF" data-id="${item.factura_cxp_id}"></i>
                                <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML" data-id="${item.factura_cxp_id}"></i>
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
                        'tipo_comprobante': 'Tipo Comprobante',
                        'estatus': 'Estatus',
                        'serie': 'Serie',
                        'folio': 'Folio',
                        'proveedor': 'Proveedor',
                        'fecha': 'Fecha',
                        'programacion_pago': 'Programación Pago',
                        'entrada_almacen': 'Entrada Almacén',
                        'uuid': 'UUID',
                        'fecha_vencimiento': 'Fecha Vencimiento',
                        'expedicion': 'Expedición',
                        'uso_cfdi': 'Uso CFDI',
                        'metodo_pago': 'Método Pago',
                        'forma_pago': 'Forma Pago',
                        'moneda': 'Moneda',
                        'tipo_cambio': 'Tipo Cambio',
                        'dias_credito': 'Días Crédito',
                        'observaciones': 'Observaciones',
                        'subtotal': 'Subtotal',
                        'descuento': 'Descuento',
                        'iva': 'IVA',
                        'riva': 'R IVA',
                        'risr': 'ISR',
                        'total': 'Total',
                        'total_mxn': 'Total MXN',
                        'abonos': 'Abonos',
                        'saldo': 'Saldo',
                        'transferencia': 'Transferencia',
                        'fecha_trans': 'Fecha Transferencia',
                        'poliza': 'Póliza',
                        'cuenta_resultados': 'Cuenta Resultados',
                        'orden_compra': 'Orden Compra',
                        'orden_servicio': 'Orden Servicio',
                        'cuenta_flujo': 'Cuenta Flujo',
                        'gasto_fijo': 'Gasto Fijo'
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
            cargarTabla(datosFiltrados);
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
                cargarTabla(datosFiltrados);
            }
        });
        
        // Función para filtrar por búsqueda
        function filtrarPorBusqueda() {
            const termino = buscador.value.toLowerCase().trim();
            
            if (termino === '') {
                datosFiltrados = [...datosOriginales];
            } else {
                datosFiltrados = datosOriginales.filter(item => 
                    item.contacto?.toLowerCase().includes(termino) ||
                    item.folio?.toLowerCase().includes(termino) ||
                    item.serie?.toLowerCase().includes(termino) ||
                    item.UUID?.toLowerCase().includes(termino) ||
                    item.observaciones?.toLowerCase().includes(termino) ||
                    item.estatus?.toLowerCase().includes(termino)
                );
            }
            
            paginaActual = 1;
            cargarTabla(datosFiltrados);
        }
        
        // Función para cambiar de página
        function cambiarPagina(nuevaPagina) {
            const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
            if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
                paginaActual = nuevaPagina;
                cargarTabla(datosFiltrados);
            }
        }
        
        // Cargar datos iniciales
        cargarTabla(datosOriginales);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        btnCrearFiltro.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        btnAgregar.addEventListener('click', function() {
            alert('Agregar Factura de Proveedor - Funcionalidad en desarrollo');
        });
        
        btnExcel.addEventListener('click', function() {
            exportTableToExcel('tablaFacturasProveedores', 'FacturasProveedores');
        });
        
        btnColumnas.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        buscador.addEventListener('input', filtrarPorBusqueda);
        
        // Eventos de paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                cambiarPagina(parseInt(this.dataset.pagina));
            });
        });
        
        btnPrimera.addEventListener('click', () => cambiarPagina(1));
        btnAnterior.addEventListener('click', () => cambiarPagina(paginaActual - 1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(paginaActual + 1));
        btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(datosFiltrados.length / registrosPorPagina)));
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-edit')) {
                const id = e.target.getAttribute('data-id');
                alert(`Editar Factura ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-trash-alt')) {
                const id = e.target.getAttribute('data-id');
                if (confirm(`¿Está seguro de eliminar la factura ID: ${id}?`)) {
                    alert(`Eliminar Factura ID: ${id} - Funcionalidad en desarrollo`);
                }
            } else if (e.target.classList.contains('fa-eye')) {
                const id = e.target.getAttribute('data-id');
                alert(`Ver detalles de Factura ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-file-pdf')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar PDF - Factura ID: ${id} - Funcionalidad en desarrollo`);
            } else if (e.target.classList.contains('fa-file-code')) {
                const id = e.target.getAttribute('data-id');
                alert(`Descargar XML - Factura ID: ${id} - Funcionalidad en desarrollo`);
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