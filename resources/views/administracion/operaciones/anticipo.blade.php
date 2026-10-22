@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Anticipos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Anticipos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>

                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
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

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-hand-holding-usd" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay anticipos para mostrar</p>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaAnticipos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="forma_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cuenta_bancaria">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Bancaria</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="referencia">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Referencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="ref_bancaria">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ref. Bancaria</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto_pesos">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto Pesos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto_restante">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto Restante</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="moneda">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_cambio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo de Cambio</span>
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
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="8">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMontoPesos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMontoRestante">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>

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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================ -->
<!-- MODAL CREAR / EDITAR ANTICIPO -->
<!-- ============================ -->
<div id="modalAnticipo" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background-color: white; border-radius: 8px; max-width: 700px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="background-color: #2378e1; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; font-size: 18px;" id="modalAnticipoTitulo">Nuevo Anticipo</h3>
            <button id="btnCerrarModal" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
        </div>

        <form id="formAnticipo" style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <input type="hidden" id="anticipoId" name="anticipo_id">

            <div style="grid-column: span 2;">
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Proveedor *</label>
                <select id="proveedorId" name="proveedor_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></select>
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Cuenta Bancaria</label>
                <select id="cuentaBancariaId" name="cuenta_bancaria_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></select>
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Moneda *</label>
                <select id="monedaId" name="moneda_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></select>
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Forma de Pago *</label>
                <select id="formaPago" name="forma_pago" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></select>
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Fecha *</label>
                <input type="date" id="fecha" name="fecha" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Referencia *</label>
                <input type="text" id="referencia" name="referencia" required maxlength="100" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Ref. Bancaria</label>
                <input type="text" id="referenciaBancaria" name="referencia_bancaria" maxlength="100" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Monto *</label>
                <input type="number" step="0.01" min="0.01" id="monto" name="monto" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Tipo de Cambio</label>
                <input type="number" step="0.0001" min="0.0001" id="tipoCambio" name="tipo_cambio" value="1" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div>
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Estatus *</label>
                <select id="estatus" name="estatus" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></select>
            </div>

            <div style="grid-column: span 2;">
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Descripción</label>
                <textarea id="descripcion" name="descripcion" maxlength="500" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
            </div>

            <div style="grid-column: span 2; display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="button" id="btnCancelarModal" style="padding: 8px 20px; border: 1px solid #6c757d; background-color: white; color: #6c757d; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                <button type="submit" id="btnGuardarAnticipo" style="padding: 8px 20px; border: none; background-color: #2378e1; color: white; border-radius: 4px; cursor: pointer; font-size: 14px;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================ -->
<!-- MODAL LIQUIDAR ANTICIPO      -->
<!-- ============================ -->
<div id="modalLiquidar" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background-color: white; border-radius: 8px; max-width: 500px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="background-color: #17a2b8; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; font-size: 18px;">Liquidar Anticipo</h3>
            <button id="btnCerrarLiquidar" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
        </div>

        <form id="formLiquidar" style="padding: 20px;">
            <input type="hidden" id="liquidarAnticipoId">

            <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; font-size: 13px;">
                <div><strong>Folio:</strong> <span id="liquidarFolio">-</span></div>
                <div><strong>Proveedor:</strong> <span id="liquidarProveedor">-</span></div>
                <div><strong>Monto original:</strong> <span id="liquidarMonto">-</span></div>
                <div><strong>Monto restante:</strong> <span id="liquidarRestante" style="color: #dc3545; font-weight: bold;">-</span></div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Monto a liquidar *</label>
                <input type="number" step="0.01" min="0.01" id="montoLiquidar" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 13px; font-weight: 600; color: #495057; display: block; margin-bottom: 5px;">Observaciones</label>
                <textarea id="observacionesLiquidar" maxlength="500" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelarLiquidar" style="padding: 8px 20px; border: 1px solid #6c757d; background-color: white; color: #6c757d; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                <button type="submit" id="btnGuardarLiquidar" style="padding: 8px 20px; border: none; background-color: #17a2b8; color: white; border-radius: 4px; cursor: pointer; font-size: 14px;">Liquidar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================ -->
<!-- MODAL VER DETALLES (NUEVO)   -->
<!-- ============================ -->
<div id="modalDetalles" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.55); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background-color: white; border-radius: 10px; max-width: 640px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0,0,0,0.35);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #2378e1 100%); color: white; padding: 18px 22px; display: flex; justify-content: space-between; align-items: center; border-radius: 10px 10px 0 0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-file-invoice-dollar" style="font-size: 22px; opacity: 0.9;"></i>
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Detalle del Anticipo</h3>
                    <span style="font-size: 12px; opacity: 0.85;" id="detFolioHeader">-</span>
                </div>
            </div>
            <button id="btnCerrarDetalles" style="background: rgba(255,255,255,0.15); border: none; color: white; font-size: 20px; cursor: pointer; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <div style="padding: 22px;">
            <!-- Header: proveedor + estatus + monto -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; padding-bottom: 18px; border-bottom: 1px solid #e9ecef; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Proveedor</div>
                    <div style="font-size: 17px; font-weight: 600; color: #212529; margin-top: 4px;" id="detProveedor">-</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Estatus</div>
                    <div style="margin-top: 6px;"><span id="detEstatus" class="badge">-</span></div>
                </div>
            </div>

            <!-- Montos destacados -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 18px 0;">
                <div style="padding: 14px; border-radius: 8px; background-color: #f0f7ff; border-left: 4px solid #2378e1;">
                    <div style="font-size: 11px; color: #2378e1; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Monto Original</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE; margin-top: 4px;" id="detMonto">$0.00</div>
                    <div style="font-size: 11px; color: #6c757d; margin-top: 2px;" id="detMoneda">-</div>
                </div>
                <div style="padding: 14px; border-radius: 8px; background-color: #fff4e6; border-left: 4px solid #fd7e14;">
                    <div style="font-size: 11px; color: #fd7e14; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Monto Restante</div>
                    <div style="font-size: 20px; font-weight: 700; color: #d9530f; margin-top: 4px;" id="detRestante">$0.00</div>
                    <div style="font-size: 11px; color: #6c757d; margin-top: 2px;" id="detTipoCambio">-</div>
                </div>
            </div>

            <!-- Grid de datos -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px;">
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Fecha</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px;" id="detFecha">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Forma de Pago</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px;" id="detFormaPago">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Referencia</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px;" id="detReferencia">-</div>
                </div>
                <div>
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Ref. Bancaria</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px;" id="detRefBancaria">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Cuenta Bancaria</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px;" id="detCuenta">-</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Descripción</div>
                    <div style="font-size: 14px; color: #212529; margin-top: 3px; padding: 10px; background-color: #f8f9fa; border-radius: 6px; line-height: 1.5;" id="detDescripcion">-</div>
                </div>
            </div>
        </div>

        <div style="padding: 15px 22px; background-color: #f8f9fa; border-top: 1px solid #e9ecef; display: flex; justify-content: flex-end; gap: 10px; border-radius: 0 0 10px 10px;">
            <button type="button" id="btnCerrarDetallesFooter" style="padding: 8px 20px; border: 1px solid #6c757d; background-color: white; color: #6c757d; border-radius: 4px; cursor: pointer; font-size: 14px;">Cerrar</button>
            <button type="button" id="btnDetallesPdf" style="padding: 8px 20px; border: none; background-color: #2378e1; color: white; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
        </div>
    </div>
</div>

<!-- ============================ -->
<!-- TOAST DE NOTIFICACIONES      -->
<!-- ============================ -->
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 10px;"></div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #2378e1; }
    .semaforo .card-header h2 { color: #2378e1 !important; }
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    #tablaBody td i { transition: transform 0.2s; font-size: 14px; color: #083CAE; cursor: pointer; }
    #tablaBody td i:hover { transform: scale(1.2); }
    .table th i { opacity: 0.7; transition: opacity 0.2s; color: white; }
    .table th i:hover { opacity: 1; }
    #tablaBody td:last-child { background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1); z-index: 15; }
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-pendiente { background-color: #fd7e14; color: white; }
    .badge-aprobado { background-color: #28a745; color: white; }
    .badge-rechazado { background-color: #dc3545; color: white; }
    .badge-liquidado { background-color: #17a2b8; color: white; }
    .badge-cancelado { background-color: #6c757d; color: white; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; color: #000000 !important; }
    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
    #grupoAgrupacion { position: relative; }
    #grupoColumnas { display: inline-flex; align-items: center; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background-color: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
    .columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-size: 14px; font-weight: bold; color: #2378e1; }
    .columna-agrupada .remover:hover { opacity: 0.7; }
    .fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
    .fila-grupo:hover { background-color: #e1f0ff !important; }
    .fila-grupo td:first-child i { transition: transform 0.2s; margin-right: 8px; }
    .fila-grupo:not(.expandido) td:first-child i { transform: rotate(-90deg); }
    .fila-detalle { background-color: #ffffff; }
    .fila-detalle td { border-top: none !important; }
    .fila-detalle td:first-child { padding-left: 30px !important; }
    .drag-over #grupoColumnas { background-color: rgba(35, 120, 225, 0.1); border-radius: 4px; }
    #paginacionContainer { background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important; }
    #paginacionContainer * { background: transparent !important; background-color: transparent !important; }
    #paginacionContainer span[style*="background-color"] { background-color: #2378e1 !important; }
    #paginacionContainer button { background: transparent !important; border: none !important; color: #2378e1 !important; cursor: pointer; }
    #paginacionContainer button:hover { opacity: 0.7; }
    #paginacionContainer button i { color: #2378e1 !important; }
    #btnCrearFiltro, #btnCrearFiltro:hover, #btnCrearFiltro:focus, #btnCrearFiltro:active { background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important; outline: none !important; }
    #btnCrearFiltro i, #btnCrearFiltro span { color: #2378e1 !important; }
    #paginacionInfo { color: #2378e1 !important; }
    /* Toast */
    .toast-item { padding: 12px 20px; border-radius: 6px; color: white; font-size: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease; display: flex; align-items: center; gap: 10px; min-width: 260px; }
    .toast-success { background-color: #28a745; }
    .toast-error { background-color: #dc3545; }
    .toast-info { background-color: #17a2b8; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    /* Icono liquidar deshabilitado */
    .accion-deshabilitada { opacity: 0.25; cursor: not-allowed !important; }
    .accion-deshabilitada:hover { transform: none !important; }
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] { justify-content: center !important; }
        input[type="date"], select { width: 100% !important; }
        button { width: 100%; }
        div[style*="position: relative"] { width: 100%; }
        input#buscador { width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #formAnticipo { grid-template-columns: 1fr !important; }
        #modalDetalles > div > div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ============================
    // CONFIGURACIÓN
    // ============================
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const ROUTES = {
        listar:    '{{ route("anticipos.listar") }}',
        store:     '{{ route("anticipos.store") }}',
        show:      '{{ route("anticipos.show", ":id") }}',
        update:    '{{ route("anticipos.update", ":id") }}',
        destroy:   '{{ route("anticipos.destroy", ":id") }}',
        pdf:       '{{ route("anticipos.pdf", ":id") }}',
        liquidar:  '{{ route("anticipos.liquidar", ":id") }}',
        excel:     '{{ route("anticipos.exportar.excel") }}',
        catalogos: '{{ route("anticipos.catalogos") }}',
    };
    const ruta = (name, id = null) => ROUTES[name].replace(':id', id);

    // ============================
    // ESTADO
    // ============================
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let datosOriginales = [];
    let datosFiltrados = [];
    let paginaActual = 1;
    const registrosPorPagina = 8;
    let catalogosCargados = false;

    // ============================
    // DOM
    // ============================
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
    const sumMontoPesos = document.getElementById('sumMontoPesos');
    const sumMontoRestante = document.getElementById('sumMontoRestante');
    const paginacionInfo = document.getElementById('paginacionInfo');
    const textoAgrupar = document.getElementById('textoAgrupar');
    const btnPrimera = document.getElementById('btnPrimera');
    const btnAnterior = document.getElementById('btnAnterior');
    const btnSiguiente = document.getElementById('btnSiguiente');
    const btnUltima = document.getElementById('btnUltima');
    const paginaActualSpan = document.getElementById('paginaActual');

    // Modales
    const modalAnticipo = document.getElementById('modalAnticipo');
    const modalTitulo = document.getElementById('modalAnticipoTitulo');
    const formAnticipo = document.getElementById('formAnticipo');
    const anticipoIdInput = document.getElementById('anticipoId');

    const modalLiquidar = document.getElementById('modalLiquidar');
    const formLiquidar = document.getElementById('formLiquidar');

    const modalDetalles = document.getElementById('modalDetalles');
    let detallesPdfId = null;

    // ============================
    // HELPERS
    // ============================
    const formatCurrency = (amount) => {
        const num = Number(amount) || 0;
        return '$' + num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    };
    const formatDate = (dateString) => {
        if (!dateString) return '-';
        const d = new Date(dateString + 'T00:00:00');
        return d.toLocaleDateString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit' });
    };
    const badgeClass = (estatus) => ({
        'Aprobado':  'badge-aprobado',
        'Pendiente': 'badge-pendiente',
        'Rechazado': 'badge-rechazado',
        'Liquidado': 'badge-liquidado',
        'Cancelado': 'badge-cancelado',
    }[estatus] || 'badge-pendiente');

    // ✅ Regla de negocio: cuándo se puede liquidar
    const puedeLiquidarse = (item) => {
        if (!item) return false;
        const estatus = (item.estatus || '').toLowerCase();
        if (estatus === 'liquidado' || estatus === 'cancelado' || estatus === 'rechazado') return false;
        return Number(item.monto_restante) > 0;
    };

    const showToast = (message, type = 'success') => {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
        toast.innerHTML = `<i class="fas fa-${icon}"></i><span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    };

    const fetchJSON = async (url, options = {}) => {
        const res = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {}),
            },
            ...options,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw { status: res.status, data };
        return data;
    };

    // ============================
    // CARGAR CATÁLOGOS
    // ============================
    const cargarCatalogos = async () => {
        if (catalogosCargados) return;
        try {
            const res = await fetchJSON(ruta('catalogos'));
            const { proveedores, cuentas, monedas, formas_pago, estatus } = res;

            const selProveedor = document.getElementById('proveedorId');
            selProveedor.innerHTML = '<option value="">-- Seleccione --</option>' +
                proveedores.map(p => `<option value="${p.id}">${p.nombre}${p.rfc ? ' (' + p.rfc + ')' : ''}</option>`).join('');

            const selCuenta = document.getElementById('cuentaBancariaId');
            selCuenta.innerHTML = '<option value="">-- Sin cuenta --</option>' +
                cuentas.map(c => `<option value="${c.id}">${c.numero_formateado || c.numero_cuenta} - ${c.banco}</option>`).join('');

            const selMoneda = document.getElementById('monedaId');
            selMoneda.innerHTML = '<option value="">-- Seleccione --</option>' +
                monedas.map(m => `<option value="${m.id}">${m.codigo} - ${m.nombre}</option>`).join('');

            const selForma = document.getElementById('formaPago');
            selForma.innerHTML = formas_pago.map(f => `<option value="${f}">${f}</option>`).join('');

            const selEstatus = document.getElementById('estatus');
            selEstatus.innerHTML = estatus.map(e => `<option value="${e}">${e}</option>`).join('');

            catalogosCargados = true;
        } catch (err) {
            console.error(err);
            showToast('Error al cargar catálogos', 'error');
        }
    };

    // ============================
    // LISTAR
    // ============================
    const cargarDatos = async () => {
        try {
            const params = new URLSearchParams({
                fecha_inicio: fechaInicio.value || '',
                fecha_fin:    fechaFin.value || '',
            });
            const res = await fetchJSON(ruta('listar') + '?' + params.toString());
            datosOriginales = res.data || [];
            datosFiltrados = [...datosOriginales];
            paginaActual = 1;
            cargarTabla(datosFiltrados);
        } catch (err) {
            console.error(err);
            showToast('Error al cargar anticipos', 'error');
        }
    };

    // ============================
    // AGRUPACIÓN
    // ============================
    const generarGrupoId = (item, columnas) => columnas.map(col => {
        switch (col) {
            case 'estatus':        return item.estatus || '';
            case 'folio':          return item.anticipo_id || '';
            case 'proveedor':      return item.proveedor || '';
            case 'forma_pago':     return item.forma_pago || '';
            case 'cuenta_bancaria':return item.cuenta_bancaria || '';
            case 'fecha':          return item.fecha || '';
            case 'referencia':     return item.referencia || '';
            case 'ref_bancaria':   return item.referencia_bancaria || '';
            case 'monto_pesos':    return String(item.monto || 0);
            case 'monto_restante': return String(item.monto_restante || 0);
            case 'moneda':         return item.moneda || '';
            case 'tipo_cambio':    return String(item.tipo_cambio || 0);
            case 'descripcion':    return item.descripcion || '';
            default: return '';
        }
    }).join('||');

    const agruparDatos = (datos, columnas) => {
        if (!columnas.length) return { grupos: [] };
        const map = new Map();
        datos.forEach(item => {
            const id = generarGrupoId(item, columnas);
            if (!map.has(id)) {
                const valor = columnas.map(col => {
                    switch (col) {
                        case 'estatus': return item.estatus;
                        case 'folio': return item.anticipo_id;
                        case 'proveedor': return item.proveedor;
                        case 'forma_pago': return item.forma_pago;
                        case 'cuenta_bancaria': return item.cuenta_bancaria;
                        case 'fecha': return formatDate(item.fecha);
                        case 'referencia': return item.referencia;
                        case 'ref_bancaria': return item.referencia_bancaria;
                        case 'monto_pesos': return formatCurrency(item.monto);
                        case 'monto_restante': return formatCurrency(item.monto_restante);
                        case 'moneda': return item.moneda;
                        case 'tipo_cambio': return item.tipo_cambio;
                        case 'descripcion': return item.descripcion;
                        default: return '';
                    }
                }).join(' - ');
                map.set(id, { id, valor, items: [item], totalMonto: Number(item.monto) || 0, totalRestante: Number(item.monto_restante) || 0 });
            } else {
                const g = map.get(id);
                g.items.push(item);
                g.totalMonto += Number(item.monto) || 0;
                g.totalRestante += Number(item.monto_restante) || 0;
            }
        });
        return { grupos: Array.from(map.values()) };
    };

    const getCurrentPageData = (datos) => {
        const start = (paginaActual - 1) * registrosPorPagina;
        return datos.slice(start, start + registrosPorPagina);
    };

    const actualizarPaginacion = (total) => {
        const totalPaginas = Math.ceil(total / registrosPorPagina) || 1;
        paginaActualSpan.textContent = paginaActual;
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            const p = parseInt(btn.dataset.pagina);
            btn.style.display = p <= totalPaginas ? 'inline-block' : 'none';
        });
        const inicio = total > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, total);
        paginacionInfo.textContent = `Mostrando ${inicio}-${fin} de ${total} registros`;
    };

    const calcularTotales = (datos) => {
        const sumaM = datos.reduce((s, i) => s + (Number(i.monto) || 0), 0);
        const sumaR = datos.reduce((s, i) => s + (Number(i.monto_restante) || 0), 0);
        totalRegistros.textContent = datos.length;
        sumMontoPesos.textContent = formatCurrency(sumaM);
        sumMontoRestante.textContent = formatCurrency(sumaR);
    };

    // ============================
    // RENDERIZAR ACCIONES
    // ============================
    const renderAcciones = (item) => {
        // ✅ Arreglo 1: ocultar "Liquidar" si ya está liquidado / cancelado / sin restante
        const mostrarLiquidar = puedeLiquidarse(item);
        const liquidarBtn = mostrarLiquidar
            ? `<i class="fas fa-check-circle" style="color: #083CAE; cursor: pointer;" title="Liquidar" data-action="liquidar" data-id="${item.anticipo_id}"></i>`
            : `<i class="fas fa-check-circle accion-deshabilitada" title="Ya liquidado" style="color: #6c757d;"></i>`;

        return `
            <div style="display: flex; gap: 8px; justify-content: center;">
                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer;" title="Editar" data-action="editar" data-id="${item.anticipo_id}"></i>
                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer;" title="Eliminar" data-action="eliminar" data-id="${item.anticipo_id}"></i>
                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver detalles" data-action="ver" data-id="${item.anticipo_id}"></i>
                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer;" title="PDF" data-action="pdf" data-id="${item.anticipo_id}"></i>
                ${liquidarBtn}
            </div>`;
    };

    const renderFilaItem = (item, esDetalle = false) => `
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; ${esDetalle ? 'padding-left:30px;' : ''}">
            <span class="badge ${badgeClass(item.estatus)}">${item.estatus || '-'}</span>
        </td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.anticipo_id || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.proveedor || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.forma_pago || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.cuenta_bancaria || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center;">${formatDate(item.fecha)}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.referencia || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.referencia_bancaria || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.monto)}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${formatCurrency(item.monto_restante)}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.moneda || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${Number(item.tipo_cambio || 0).toFixed(2)}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.descripcion || '-'}</td>
        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">${renderAcciones(item)}</td>`;

    const cargarTabla = (datos) => {
        if (textoAgrupar) textoAgrupar.style.display = columnasAgrupadas.length ? 'none' : 'inline';

        const { grupos } = agruparDatos(datos, columnasAgrupadas);
        const hayGrupos = columnasAgrupadas.length > 0;
        tablaBody.innerHTML = '';

        if (datos.length === 0) {
            sinDatosMensaje.style.display = 'block';
            tablaContainer.style.display = 'none';
            if (tablaFoot) tablaFoot.style.display = 'none';
            paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
            return;
        }
        sinDatosMensaje.style.display = 'none';
        tablaContainer.style.display = 'block';

        if (hayGrupos) {
            if (tablaFoot) tablaFoot.style.display = 'none';
            grupos.forEach(grupo => {
                const tr = document.createElement('tr');
                tr.className = 'fila-grupo' + (expandedGroups.has(grupo.id) ? ' expandido' : '');
                tr.dataset.grupoId = grupo.id;
                const counts = {};
                grupo.items.forEach(i => counts[i.estatus] = (counts[i.estatus] || 0) + 1);
                const estatusPred = Object.entries(counts).sort((a, b) => b[1] - a[1])[0]?.[0] || 'Pendiente';
                tr.innerHTML = `
                    <td colspan="14" style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                <strong style="color: #2378e1;">${grupo.valor}</strong>
                                <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                    (${grupo.items.length} registros - Monto: ${formatCurrency(grupo.totalMonto)} - Restante: ${formatCurrency(grupo.totalRestante)})
                                </span>
                            </div>
                            <span class="badge ${badgeClass(estatusPred)}" style="margin-right: 10px;">${estatusPred}</span>
                        </div>
                    </td>`;
                tablaBody.appendChild(tr);
                if (expandedGroups.has(grupo.id)) {
                    grupo.items.forEach(item => {
                        const det = document.createElement('tr');
                        det.className = 'fila-detalle';
                        det.innerHTML = renderFilaItem(item, true);
                        tablaBody.appendChild(det);
                    });
                }
            });
            paginacionInfo.textContent = `Mostrando ${grupos.length} grupos de ${datos.length} registros`;
        } else {
            if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
            const pageData = getCurrentPageData(datos);
            pageData.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = renderFilaItem(item);
                tablaBody.appendChild(tr);
            });
            calcularTotales(datos);
            actualizarPaginacion(datos.length);
        }
    };

    // ============================
    // AGRUPACIÓN UI
    // ============================
    const actualizarGrupoColumnas = () => {
        const cont = document.getElementById('grupoColumnas');
        cont.innerHTML = '';
        if (!columnasAgrupadas.length) {
            textoAgrupar.style.display = 'inline';
        } else {
            textoAgrupar.style.display = 'none';
            const nombres = {
                estatus: 'Estatus', folio: 'Folio', proveedor: 'Proveedor',
                forma_pago: 'Forma de Pago', cuenta_bancaria: 'Cuenta Bancaria',
                fecha: 'Fecha', referencia: 'Referencia', ref_bancaria: 'Ref. Bancaria',
                monto_pesos: 'Monto', monto_restante: 'Restante',
                moneda: 'Moneda', tipo_cambio: 'T.C.', descripcion: 'Descripción',
            };
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${nombres[col] || col}<span class="remover" data-columna="${col}">&times;</span>`;
                cont.appendChild(chip);
            });
        }
        expandedGroups.clear();
        cargarTabla(datosFiltrados);
    };

    // ============================
    // DRAG & DROP
    // ============================
    document.querySelectorAll('th[draggable="true"]').forEach(th => {
        th.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', th.dataset.columna);
            th.style.opacity = '0.5';
        });
        th.addEventListener('dragend', () => th.style.opacity = '1');
    });
    const grupoAgr = document.getElementById('grupoAgrupacion');
    grupoAgr.addEventListener('dragover', e => { e.preventDefault(); grupoAgr.classList.add('drag-over'); });
    grupoAgr.addEventListener('dragleave', () => grupoAgr.classList.remove('drag-over'));
    grupoAgr.addEventListener('drop', e => {
        e.preventDefault();
        grupoAgr.classList.remove('drag-over');
        const col = e.dataTransfer.getData('text/plain');
        if (col && !columnasAgrupadas.includes(col)) {
            columnasAgrupadas.push(col);
            actualizarGrupoColumnas();
        }
    });
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            columnasAgrupadas = columnasAgrupadas.filter(c => c !== e.target.dataset.columna);
            actualizarGrupoColumnas();
        }
        if (e.target.closest('.fila-grupo')) {
            const tr = e.target.closest('.fila-grupo');
            const id = tr.dataset.grupoId;
            if (expandedGroups.has(id)) expandedGroups.delete(id);
            else expandedGroups.add(id);
            cargarTabla(datosFiltrados);
        }
    });

    // ============================
    // BUSCADOR Y PAGINACIÓN
    // ============================
    const filtrarBusqueda = () => {
        const term = buscador.value.toLowerCase().trim();
        datosFiltrados = !term ? [...datosOriginales] : datosOriginales.filter(i =>
            (i.proveedor || '').toLowerCase().includes(term) ||
            (i.referencia || '').toLowerCase().includes(term) ||
            (i.referencia_bancaria || '').toLowerCase().includes(term) ||
            (i.descripcion || '').toLowerCase().includes(term) ||
            (i.estatus || '').toLowerCase().includes(term) ||
            String(i.anticipo_id || '').includes(term)
        );
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    };
    buscador.addEventListener('input', filtrarBusqueda);

    const cambiarPagina = (n) => {
        const totalP = Math.ceil(datosFiltrados.length / registrosPorPagina);
        if (n >= 1 && n <= totalP) {
            paginaActual = n;
            cargarTabla(datosFiltrados);
        }
    };
    document.querySelectorAll('.pagina-btn').forEach(b => b.addEventListener('click', () => cambiarPagina(parseInt(b.dataset.pagina))));
    btnPrimera.addEventListener('click', () => cambiarPagina(1));
    btnAnterior.addEventListener('click', () => cambiarPagina(paginaActual - 1));
    btnSiguiente.addEventListener('click', () => cambiarPagina(paginaActual + 1));
    btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(datosFiltrados.length / registrosPorPagina)));

    // ============================
    // MODAL CREAR / EDITAR
    // ============================
    const abrirModal = async (modo, id = null) => {
        await cargarCatalogos();
        formAnticipo.reset();
        anticipoIdInput.value = '';

        if (modo === 'editar') {
            modalTitulo.textContent = 'Editar Anticipo';
            try {
                const res = await fetchJSON(ruta('show', id));
                const d = res.data;
                anticipoIdInput.value = d.id;
                document.getElementById('proveedorId').value = d.proveedor_id || '';
                document.getElementById('cuentaBancariaId').value = d.cuenta_bancaria_id || '';
                document.getElementById('monedaId').value = d.moneda_id || '';
                document.getElementById('formaPago').value = d.forma_pago || '';
                document.getElementById('fecha').value = d.fecha || '';
                document.getElementById('referencia').value = d.referencia || '';
                document.getElementById('referenciaBancaria').value = d.referencia_bancaria || '';
                document.getElementById('monto').value = d.monto || '';
                document.getElementById('tipoCambio').value = d.tipo_cambio || 1;
                document.getElementById('estatus').value = d.estatus || 'Pendiente';
                document.getElementById('descripcion').value = d.descripcion || '';
            } catch (err) {
                console.error(err);
                showToast('Error al cargar el anticipo', 'error');
                return;
            }
        } else {
            modalTitulo.textContent = 'Nuevo Anticipo';
            document.getElementById('fecha').value = new Date().toISOString().slice(0, 10);
            document.getElementById('estatus').value = 'Pendiente';
        }
        modalAnticipo.style.display = 'flex';
    };

    const cerrarModal = () => modalAnticipo.style.display = 'none';

    btnAgregar.addEventListener('click', () => abrirModal('crear'));
    document.getElementById('btnCerrarModal').addEventListener('click', cerrarModal);
    document.getElementById('btnCancelarModal').addEventListener('click', cerrarModal);
    modalAnticipo.addEventListener('click', e => { if (e.target === modalAnticipo) cerrarModal(); });

    formAnticipo.addEventListener('submit', async e => {
        e.preventDefault();
        const id = anticipoIdInput.value;
        const payload = {
            proveedor_id:        document.getElementById('proveedorId').value,
            cuenta_bancaria_id:  document.getElementById('cuentaBancariaId').value || null,
            moneda_id:           document.getElementById('monedaId').value,
            forma_pago:          document.getElementById('formaPago').value,
            fecha:               document.getElementById('fecha').value,
            referencia:          document.getElementById('referencia').value,
            referencia_bancaria: document.getElementById('referenciaBancaria').value || null,
            monto:               parseFloat(document.getElementById('monto').value),
            tipo_cambio:         parseFloat(document.getElementById('tipoCambio').value) || 1,
            estatus:             document.getElementById('estatus').value,
            descripcion:         document.getElementById('descripcion').value || null,
        };

        const btn = document.getElementById('btnGuardarAnticipo');
        btn.disabled = true;
        btn.textContent = 'Guardando...';

        try {
            const url = id ? ruta('update', id) : ruta('store');
            const method = id ? 'PUT' : 'POST';
            const res = await fetchJSON(url, { method, body: JSON.stringify(payload) });
            showToast(res.message || 'Guardado correctamente', 'success');
            cerrarModal();
            await cargarDatos();
        } catch (err) {
            console.error(err);
            const msg = err.data?.message || 'Error al guardar';
            const errors = err.data?.errors
                ? Object.values(err.data.errors).flat().join(' | ')
                : '';
            showToast(msg + (errors ? ': ' + errors : ''), 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Guardar';
        }
    });

    // ============================
    // MODAL LIQUIDAR
    // ============================
    const abrirLiquidar = async (id) => {
        try {
            const res = await fetchJSON(ruta('show', id));
            const d = res.data;
            if (!puedeLiquidarse(d)) {
                showToast('Este anticipo ya no puede liquidarse (liquidado, cancelado o sin saldo).', 'info');
                return;
            }
            document.getElementById('liquidarAnticipoId').value = d.id;
            document.getElementById('liquidarFolio').textContent = d.folio || '-';
            document.getElementById('liquidarProveedor').textContent = d.proveedor || '-';
            document.getElementById('liquidarMonto').textContent = formatCurrency(d.monto);
            document.getElementById('liquidarRestante').textContent = formatCurrency(d.monto_restante);
            document.getElementById('montoLiquidar').value = d.monto_restante;
            document.getElementById('montoLiquidar').max = d.monto_restante;
            document.getElementById('observacionesLiquidar').value = '';
            modalLiquidar.style.display = 'flex';
        } catch (err) {
            console.error(err);
            showToast('Error al cargar el anticipo', 'error');
        }
    };

    const cerrarLiquidar = () => modalLiquidar.style.display = 'none';
    document.getElementById('btnCerrarLiquidar').addEventListener('click', cerrarLiquidar);
    document.getElementById('btnCancelarLiquidar').addEventListener('click', cerrarLiquidar);
    modalLiquidar.addEventListener('click', e => { if (e.target === modalLiquidar) cerrarLiquidar(); });

    formLiquidar.addEventListener('submit', async e => {
        e.preventDefault();
        const id = document.getElementById('liquidarAnticipoId').value;
        const payload = {
            monto_liquidar: parseFloat(document.getElementById('montoLiquidar').value),
            observaciones:  document.getElementById('observacionesLiquidar').value || null,
        };
        const btn = document.getElementById('btnGuardarLiquidar');
        btn.disabled = true;
        btn.textContent = 'Liquidando...';
        try {
            const res = await fetchJSON(ruta('liquidar', id), { method: 'POST', body: JSON.stringify(payload) });
            showToast(res.message || 'Liquidación registrada', 'success');
            cerrarLiquidar();
            await cargarDatos();
        } catch (err) {
            console.error(err);
            showToast(err.data?.message || 'Error al liquidar', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Liquidar';
        }
    });

    // ============================
    // ✅ MODAL VER DETALLES (arreglado visualmente)
    // ============================
    const abrirDetalles = async (id) => {
        try {
            const res = await fetchJSON(ruta('show', id));
            const d = res.data;
            detallesPdfId = d.id;

            document.getElementById('detFolioHeader').textContent = d.folio || 'Folio ' + d.id;
            document.getElementById('detProveedor').textContent = d.proveedor || '-';

            const estatusEl = document.getElementById('detEstatus');
            estatusEl.textContent = d.estatus || '-';
            estatusEl.className = 'badge ' + badgeClass(d.estatus);

            document.getElementById('detMonto').textContent = formatCurrency(d.monto);
            document.getElementById('detRestante').textContent = formatCurrency(d.monto_restante);
            document.getElementById('detMoneda').textContent = (d.moneda || 'MXN');
            document.getElementById('detTipoCambio').textContent = 'T.C. ' + Number(d.tipo_cambio || 1).toFixed(2);

            document.getElementById('detFecha').textContent = formatDate(d.fecha);
            document.getElementById('detFormaPago').textContent = d.forma_pago || '-';
            document.getElementById('detReferencia').textContent = d.referencia || '-';
            document.getElementById('detRefBancaria').textContent = d.referencia_bancaria || '-';
            document.getElementById('detCuenta').textContent = d.cuenta_bancaria || '-';
            document.getElementById('detDescripcion').textContent = d.descripcion || 'Sin descripción';

            modalDetalles.style.display = 'flex';
        } catch (err) {
            console.error(err);
            showToast('Error al cargar los detalles', 'error');
        }
    };

    const cerrarDetalles = () => { modalDetalles.style.display = 'none'; detallesPdfId = null; };
    document.getElementById('btnCerrarDetalles').addEventListener('click', cerrarDetalles);
    document.getElementById('btnCerrarDetallesFooter').addEventListener('click', cerrarDetalles);
    modalDetalles.addEventListener('click', e => { if (e.target === modalDetalles) cerrarDetalles(); });
    document.getElementById('btnDetallesPdf').addEventListener('click', () => {
        if (detallesPdfId) window.open(ruta('pdf', detallesPdfId), '_blank');
    });

    // ============================
    // ACCIONES DE LA TABLA
    // ============================
    document.addEventListener('click', async e => {
        const icon = e.target.closest('i[data-action]');
        if (!icon) return;
        const action = icon.dataset.action;
        const id = icon.dataset.id;

        if (action === 'editar') {
            abrirModal('editar', id);
        } else if (action === 'eliminar') {
            if (!confirm(`¿Está seguro de eliminar el anticipo ID ${id}?`)) return;
            try {
                const res = await fetchJSON(ruta('destroy', id), { method: 'DELETE' });
                showToast(res.message || 'Eliminado correctamente', 'success');
                await cargarDatos();
            } catch (err) {
                showToast(err.data?.message || 'Error al eliminar', 'error');
            }
        } else if (action === 'pdf') {
            window.open(ruta('pdf', id), '_blank');
        } else if (action === 'liquidar') {
            abrirLiquidar(id);
        } else if (action === 'ver') {
            abrirDetalles(id);
        }
    });

    // ============================
    // EXCEL
    // ============================
    btnExcel.addEventListener('click', () => {
        const params = new URLSearchParams({
            fecha_inicio: fechaInicio.value || '',
            fecha_fin: fechaFin.value || '',
        });
        window.location.href = ruta('excel') + '?' + params.toString();
    });

    // ============================
    // FILTROS POR FECHA
    // ============================
    fechaInicio.addEventListener('change', () => { paginaActual = 1; cargarDatos(); });
    fechaFin.addEventListener('change', () => { paginaActual = 1; cargarDatos(); });

    // ============================
    // OTROS BOTONES
    // ============================
    btnCrearFiltro.addEventListener('click', () => showToast('Crear filtro - próximamente', 'info'));
    btnColumnas.addEventListener('click', () => showToast('Selector de columnas - próximamente', 'info'));
    document.querySelectorAll('.table th i.fa-filter').forEach(ic => {
        ic.addEventListener('click', () => showToast('Filtro de columna - próximamente', 'info'));
    });

    // ============================
    // INICIALIZAR
    // ============================
    cargarDatos();
});
</script>
@endsection