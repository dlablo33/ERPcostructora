@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Créditos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Créditos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>

                    <!-- Botones derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #2378e1; font-size: 16px;" title="Agregar">
                                <i class="fas fa-plus" style="color: #2378e1;"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel"
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #2378e1;"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnColumnas"
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #2378e1;"></i>
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Sin datos -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-credit-card" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay créditos para mostrar</p>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaCreditos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="no_credito">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Crédito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="entidad_financiera">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Entidad Financiera</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="pendiente">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Pendiente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto_capital">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto Capital</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="restante_capital">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Restante Capital</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="parcialidad_actual">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Parcialidad Actual</span>
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
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="2">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumPendiente">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMontoCapital">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumRestanteCapital">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                    <button id="btnCrearFiltro" style="background: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>

                    <div style="display: flex; align-items: center; gap: 5px;">
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

<!-- ============ MODAL CREAR / EDITAR CRÉDITO ============ -->
<div id="modalCredito" class="modal-custom" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 700px; width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background-color: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px;" id="modalCreditoTitulo">Nuevo Crédito</h3>
            <button id="cerrarModalCredito" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <form id="formCredito" style="padding: 20px;">
            <input type="hidden" id="creditoId" name="id">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">No. Crédito *</label>
                    <input type="text" id="numero_credito" name="numero_credito" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Banco *</label>
                    <select id="banco_id" name="banco_id" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="">-- Selecciona --</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Fecha *</label>
                    <input type="date" id="fecha" name="fecha" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Parcialidad Actual *</label>
                    <input type="text" id="parcialidad_actual" name="parcialidad_actual" placeholder="Ej. 1/24" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Monto Total *</label>
                    <input type="number" step="0.01" id="monto_total" name="monto_total" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Monto Pendiente *</label>
                    <input type="number" step="0.01" id="monto_pendiente" name="monto_pendiente" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Monto Capital *</label>
                    <input type="number" step="0.01" id="monto_capital" name="monto_capital" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Restante Capital *</label>
                    <input type="number" step="0.01" id="monto_capital_restante" name="monto_capital_restante" required style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Tasa Interés (%)</label>
                    <input type="number" step="0.01" id="tasa_interes" name="tasa_interes" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                <div>
                    <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Plazo (meses)</label>
                    <input type="number" id="plazo_meses" name="plazo_meses" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
            </div>

            <div style="margin-top: 15px;">
                <label style="display:block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #333;">Notas</label>
                <textarea id="notas" name="notas" rows="3" style="width: 100%; padding: 8px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;"></textarea>
            </div>

            <div id="erroresFormulario" style="display:none; margin-top: 15px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 4px; padding: 10px; color: #991b1b; font-size: 13px;"></div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" id="cancelarFormCredito" style="padding: 8px 16px; border: 1px solid #ced4da; background: white; border-radius: 4px; cursor: pointer; font-size: 14px;">Cancelar</button>
                <button type="submit" style="padding: 8px 16px; border: none; background: #2378e1; color: white; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MODAL VER DETALLE CRÉDITO ============ -->
<div id="modalVer" class="modal-custom" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 750px; width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background-color: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px;">Detalle del Crédito</h3>
            <button id="cerrarModalVer" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <div id="contenidoVer" style="padding: 20px; font-size: 14px; color: #333;"></div>
    </div>
</div>

<!-- ============ MODAL PARCIALIDADES (CRUD completo) ============ -->
<div id="modalParcialidades" class="modal-custom" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 1000px; width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background-color: #2378e1; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 5;">
            <h3 style="margin: 0; font-size: 18px;" id="tituloParcialidades">Parcialidades</h3>
            <button id="cerrarModalParcialidades" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <div id="contenidoParcialidades" style="padding: 20px; font-size: 13px; color: #333;"></div>
    </div>
</div>

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
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; color: #000000 !important; }
    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
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
    #paginacionContainer { background: transparent !important; border: none !important; }
    #paginacionContainer button { background: transparent !important; border: none !important; color: #2378e1 !important; cursor: pointer; }
    #paginacionContainer button:hover { opacity: 0.7; }
    #paginacionContainer button i { color: #2378e1 !important; }
    #btnCrearFiltro, #btnCrearFiltro:hover, #btnCrearFiltro:focus, #btnCrearFiltro:active { background: transparent !important; border: none !important; box-shadow: none !important; outline: none !important; }
    #paginacionInfo { color: #2378e1 !important; }
    .modal-custom.mostrar { display: flex !important; }
    /* Parcialidades tabla interna */
    #contenidoParcialidades table th { background-color: #2378e1; color: white; font-weight: 600; }
    #contenidoParcialidades table td { color: #000 !important; }
    @media (max-width: 768px) {
        input[type="date"], select { width: 100% !important; }
        button { width: 100%; }
        input#buscador { width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/* ============================================================
 *  CRÉDITOS - JS CON LLAMADAS AJAX REALES
 * ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM cargado - Créditos (AJAX + Parcialidades CRUD)');

    /* ---------- Configuración ---------- */
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content
        || '{{ csrf_token() }}';

    const ROUTES = {
        listar:               '{{ route("creditos.listar") }}',
        bancos:               '{{ route("creditos.bancos") }}',
        crear:                '{{ route("creditos.crear") }}',
        editar:               (id) => `{{ url('creditos') }}/${id}/editar`,
        actualizar:           (id) => `{{ url('creditos') }}/${id}/actualizar`,
        eliminar:             (id) => `{{ url('creditos') }}/${id}/eliminar`,
        ver:                  (id) => `{{ url('creditos') }}/${id}/ver`,
        parcialidades:        (id) => `{{ url('creditos') }}/${id}/parcialidades`,
        crearParcialidad:     (id) => `{{ url('creditos') }}/${id}/parcialidades`,
        actualizarParcialidad:(cid, pid) => `{{ url('creditos') }}/${cid}/parcialidades/${pid}`,
        eliminarParcialidad:  (cid, pid) => `{{ url('creditos') }}/${cid}/parcialidades/${pid}`,
        pdf:                  (id) => `{{ url('creditos') }}/${id}/pdf`,
        exportar:             '{{ route("creditos.exportar") }}',
    };

    /* ---------- Estado ---------- */
    let columnasAgrupadas = [];
    let expandedGroups    = new Set();
    let datosOriginales   = [];
    let datosFiltrados    = [];
    let paginaActual      = 1;
    const registrosPorPagina = 8;
    let bancosCache       = [];

    // Estado del modal parcialidades
    let creditoParcialidadesActual = null;
    let parcialidadEditando        = null;   // null = crear
    let parcialidadesCache         = [];

    /* ---------- Referencias DOM ---------- */
    const fechaInicio      = document.getElementById('fechaInicio');
    const fechaFin         = document.getElementById('fechaFin');
    const btnCrearFiltro   = document.getElementById('btnCrearFiltro');
    const btnAgregar       = document.getElementById('btnAgregar');
    const btnExcel         = document.getElementById('btnExcel');
    const btnColumnas      = document.getElementById('btnColumnas');
    const buscador         = document.getElementById('buscador');
    const tablaBody        = document.getElementById('tablaBody');
    const sinDatosMensaje  = document.getElementById('sinDatosMensaje');
    const tablaContainer   = document.getElementById('tablaContainer');
    const tablaFoot        = document.getElementById('tablaFoot');
    const totalRegistros   = document.getElementById('totalRegistros');
    const sumMonto         = document.getElementById('sumMonto');
    const sumPendiente     = document.getElementById('sumPendiente');
    const sumMontoCapital  = document.getElementById('sumMontoCapital');
    const sumRestanteCapital = document.getElementById('sumRestanteCapital');
    const paginacionInfo   = document.getElementById('paginacionInfo');
    const textoAgrupar     = document.getElementById('textoAgrupar');

    const btnPrimera   = document.getElementById('btnPrimera');
    const btnAnterior  = document.getElementById('btnAnterior');
    const btnSiguiente = document.getElementById('btnSiguiente');
    const btnUltima    = document.getElementById('btnUltima');
    const paginaActualSpan = document.getElementById('paginaActual');

    /* ---------- Modales ---------- */
    const modalCredito        = document.getElementById('modalCredito');
    const modalCreditoTitulo  = document.getElementById('modalCreditoTitulo');
    const formCredito         = document.getElementById('formCredito');
    const cerrarModalCredito  = document.getElementById('cerrarModalCredito');
    const cancelarFormCredito = document.getElementById('cancelarFormCredito');
    const erroresFormulario   = document.getElementById('erroresFormulario');

    const modalVer            = document.getElementById('modalVer');
    const cerrarModalVer      = document.getElementById('cerrarModalVer');
    const contenidoVer        = document.getElementById('contenidoVer');

    const modalParcialidades  = document.getElementById('modalParcialidades');
    const cerrarModalParcialidades = document.getElementById('cerrarModalParcialidades');
    const contenidoParcialidades   = document.getElementById('contenidoParcialidades');
    const tituloParcialidades      = document.getElementById('tituloParcialidades');

    /* ---------- Helpers ---------- */
    function formatCurrency(amount) {
        const n = Number(amount) || 0;
        return '$' + n.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    function formatDate(dateString) {
        if (!dateString) return '-';
        const d = new Date(dateString);
        if (isNaN(d)) return dateString;
        return d.toLocaleDateString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit' });
    }
    function escapeHtml(str) {
        return String(str ?? '').replace(/[&<>"']/g, s => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
        }[s]));
    }
    function abrirModal(m)  { m.classList.add('mostrar'); m.style.display = 'flex'; }
    function cerrarModal(m) { m.classList.remove('mostrar'); m.style.display = 'none'; }

    async function apiFetch(url, options = {}) {
        const headers = {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            ...(options.headers || {})
        };
        if (options.body && !(options.body instanceof FormData)) {
            headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(options.body);
        }
        const res = await fetch(url, { ...options, headers });
        let json = null;
        try { json = await res.json(); } catch (e) { json = null; }
        return { ok: res.ok, status: res.status, data: json };
    }

    /* ---------- Bancos ---------- */
    async function cargarBancos() {
        const { ok, data } = await apiFetch(ROUTES.bancos);
        if (ok && data?.success) {
            bancosCache = data.data || [];
            const select = document.getElementById('banco_id');
            select.innerHTML = '<option value="">-- Selecciona --</option>' +
                bancosCache.map(b => `<option value="${b.id}">${escapeHtml(b.nombre)}${b.codigo ? ' (' + escapeHtml(b.codigo) + ')' : ''}</option>`).join('');
        }
    }

    /* ---------- Créditos (backend) ---------- */
    async function cargarCreditos() {
        const params = new URLSearchParams({
            fecha_inicio: fechaInicio.value || '',
            fecha_fin:    fechaFin.value || '',
            buscar:       buscador.value.trim(),
        });
        const { ok, data } = await apiFetch(`${ROUTES.listar}?${params.toString()}`);
        if (!ok || !data?.success) {
            datosOriginales = [];
            datosFiltrados  = [];
        } else {
            datosOriginales = data.data || [];
            datosFiltrados  = [...datosOriginales];
        }
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    }

    /* ---------- Agrupación ---------- */
    function generarGrupoId(item, columnas) {
        return columnas.map(col => {
            switch (col) {
                case 'no_credito':         return item.numero || 'Sin número';
                case 'entidad_financiera': return item.entidad_financiera || 'Sin entidad';
                case 'fecha':              return item.fecha || 'Sin fecha';
                case 'monto':              return item.monto_total ? item.monto_total.toString() : '0';
                case 'pendiente':          return item.monto_pendiente ? item.monto_pendiente.toString() : '0';
                case 'monto_capital':      return item.monto_capital ? item.monto_capital.toString() : '0';
                case 'restante_capital':   return item.monto_capital_restante ? item.monto_capital_restante.toString() : '0';
                case 'parcialidad_actual': return item.parcialidad_actual || '0/0';
                default: return '';
            }
        }).join('||');
    }

    function agruparDatos(datos, columnas) {
        if (columnas.length === 0) return { grupos: [], items: datos };
        const gruposMap = new Map();
        datos.forEach(item => {
            const grupoId = generarGrupoId(item, columnas);
            if (!gruposMap.has(grupoId)) {
                const valorGrupo = columnas.map(col => {
                    switch (col) {
                        case 'no_credito':         return item.numero || 'Sin número';
                        case 'entidad_financiera': return item.entidad_financiera || 'Sin entidad';
                        case 'fecha':              return item.fecha ? formatDate(item.fecha) : 'Sin fecha';
                        case 'monto':              return item.monto_total || 0;
                        case 'pendiente':          return item.monto_pendiente || 0;
                        case 'monto_capital':      return item.monto_capital || 0;
                        case 'restante_capital':   return item.monto_capital_restante || 0;
                        case 'parcialidad_actual': return item.parcialidad_actual || '0/0';
                        default: return '';
                    }
                }).join(' - ');
                gruposMap.set(grupoId, {
                    id: grupoId, valor: valorGrupo, items: [item],
                    totalMonto: item.monto_total || 0,
                    totalPendiente: item.monto_pendiente || 0,
                    totalMontoCapital: item.monto_capital || 0,
                    totalRestanteCapital: item.monto_capital_restante || 0,
                });
            } else {
                const g = gruposMap.get(grupoId);
                g.items.push(item);
                g.totalMonto += item.monto_total || 0;
                g.totalPendiente += item.monto_pendiente || 0;
                g.totalMontoCapital += item.monto_capital || 0;
                g.totalRestanteCapital += item.monto_capital_restante || 0;
            }
        });
        return { grupos: Array.from(gruposMap.values()), items: [] };
    }

    function getCurrentPageData(datos) {
        const start = (paginaActual - 1) * registrosPorPagina;
        return datos.slice(start, start + registrosPorPagina);
    }

    function actualizarPaginacion(total) {
        const totalPaginas = Math.ceil(total / registrosPorPagina) || 1;
        paginaActualSpan.textContent = paginaActual;
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.style.display = parseInt(btn.dataset.pagina) <= totalPaginas ? 'inline-block' : 'none';
        });
        const inicio = total > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, total);
        paginacionInfo.textContent = `Mostrando ${inicio}-${fin} de ${total} registros`;
    }

    function calcularTotales(datos) {
        let sMonto = 0, sPend = 0, sCap = 0, sRest = 0;
        datos.forEach(i => {
            sMonto += i.monto_total || 0;
            sPend  += i.monto_pendiente || 0;
            sCap   += i.monto_capital || 0;
            sRest  += i.monto_capital_restante || 0;
        });
        totalRegistros.textContent      = datos.length;
        sumMonto.textContent            = formatCurrency(sMonto);
        sumPendiente.textContent        = formatCurrency(sPend);
        sumMontoCapital.textContent     = formatCurrency(sCap);
        sumRestanteCapital.textContent  = formatCurrency(sRest);
    }

    /* ---------- Render tabla principal ---------- */
    function cargarTabla(datos) {
        if (!tablaBody) return;

        if (textoAgrupar) textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';

        const { grupos } = agruparDatos(datos, columnasAgrupadas);
        const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;

        tablaBody.innerHTML = '';

        if (datos.length === 0) {
            sinDatosMensaje.style.display = 'block';
            tablaContainer.style.display = 'none';
            if (tablaFoot) tablaFoot.style.display = 'none';
            totalRegistros.textContent = '0';
            sumMonto.textContent = sumPendiente.textContent = sumMontoCapital.textContent = sumRestanteCapital.textContent = formatCurrency(0);
            paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
            return;
        }

        sinDatosMensaje.style.display = 'none';
        tablaContainer.style.display = 'block';

        if (hayGrupos) {
            if (tablaFoot) tablaFoot.style.display = 'none';
            grupos.forEach(grupo => {
                const row = document.createElement('tr');
                row.className = 'fila-grupo' + (expandedGroups.has(grupo.id) ? ' expandido' : '');
                row.dataset.grupoId = grupo.id;

                const entidadCounts = {};
                grupo.items.forEach(i => {
                    const k = i.entidad_financiera || 'Sin entidad';
                    entidadCounts[k] = (entidadCounts[k] || 0) + 1;
                });
                let entidadPred = 'Entidad', max = 0;
                for (const [k, v] of Object.entries(entidadCounts)) if (v > max) { max = v; entidadPred = k; }

                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="9">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                <strong style="color: #2378e1;">${escapeHtml(grupo.valor)}</strong>
                                <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                    (${grupo.items.length} registros - Monto: ${formatCurrency(grupo.totalMonto)} - Pendiente: ${formatCurrency(grupo.totalPendiente)})
                                </span>
                            </div>
                            <span class="badge" style="background-color: #2378e1; color: white; margin-right: 10px;">${escapeHtml(entidadPred)}</span>
                        </div>
                    </td>`;
                tablaBody.appendChild(row);

                if (expandedGroups.has(grupo.id)) {
                    grupo.items.forEach(item => {
                        const det = document.createElement('tr');
                        det.className = 'fila-detalle';
                        det.innerHTML = `
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${escapeHtml(item.numero || '-')}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${escapeHtml(item.entidad_financiera || '-')}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_total ? formatCurrency(item.monto_total) : '-'}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_pendiente ? formatCurrency(item.monto_pendiente) : '-'}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_capital ? formatCurrency(item.monto_capital) : '-'}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_capital_restante ? formatCurrency(item.monto_capital_restante) : '-'}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${escapeHtml(item.parcialidad_actual || '-')}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <i class="fas fa-edit" title="Editar" data-action="editar" data-id="${item.credito_id}"></i>
                                    <i class="fas fa-trash-alt" title="Eliminar" data-action="eliminar" data-id="${item.credito_id}"></i>
                                    <i class="fas fa-eye" title="Ver detalle" data-action="ver" data-id="${item.credito_id}"></i>
                                    <i class="fas fa-file-pdf" title="PDF" data-action="pdf" data-id="${item.credito_id}"></i>
                                    <i class="fas fa-calendar-alt" title="Parcialidades" data-action="parcialidades" data-id="${item.credito_id}"></i>
                                </div>
                            </td>`;
                        tablaBody.appendChild(det);
                    });
                }
            });
            paginacionInfo.textContent = `Mostrando ${grupos.length} grupos de ${datos.length} registros`;
        } else {
            const pageData = getCurrentPageData(datos);
            pageData.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${escapeHtml(item.numero || '-')}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${escapeHtml(item.entidad_financiera || '-')}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_total ? formatCurrency(item.monto_total) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_pendiente ? formatCurrency(item.monto_pendiente) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_capital ? formatCurrency(item.monto_capital) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.monto_capital_restante ? formatCurrency(item.monto_capital_restante) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${escapeHtml(item.parcialidad_actual || '-')}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-edit" title="Editar" data-action="editar" data-id="${item.credito_id}"></i>
                            <i class="fas fa-trash-alt" title="Eliminar" data-action="eliminar" data-id="${item.credito_id}"></i>
                            <i class="fas fa-eye" title="Ver detalle" data-action="ver" data-id="${item.credito_id}"></i>
                            <i class="fas fa-calendar-alt" title="Parcialidades" data-action="parcialidades" data-id="${item.credito_id}"></i>
                        </div>
                    </td>`;
                tablaBody.appendChild(row);
            });

            if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
            calcularTotales(datos);
            actualizarPaginacion(datos.length);
        }
    }

    /* ---------- Chips agrupación ---------- */
    function actualizarGrupoColumnas() {
        const grupoContainer = document.getElementById('grupoColumnas');
        if (!grupoContainer) return;
        grupoContainer.innerHTML = '';

        if (columnasAgrupadas.length === 0) {
            if (textoAgrupar) textoAgrupar.style.display = 'inline';
        } else {
            if (textoAgrupar) textoAgrupar.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const nombre = {
                    'no_credito':'No. Crédito','entidad_financiera':'Entidad Financiera',
                    'fecha':'Fecha','monto':'Monto','pendiente':'Pendiente',
                    'monto_capital':'Monto Capital','restante_capital':'Restante Capital',
                    'parcialidad_actual':'Parcialidad Actual'
                }[col] || col;
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${nombre}<span class="remover" data-columna="${col}">&times;</span>`;
                grupoContainer.appendChild(chip);
            });
        }
        expandedGroups.clear();
        cargarTabla(datosFiltrados);
    }

    /* ---------- Drag & drop ---------- */
    function setupDragAndDrop() {
        document.querySelectorAll('th[draggable="true"]').forEach(th => {
            th.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', th.dataset.columna);
                e.dataTransfer.effectAllowed = 'copy';
                th.style.opacity = '0.5';
            });
            th.addEventListener('dragend', () => { th.style.opacity = '1'; });
        });

        const grupoAgrupacion = document.getElementById('grupoAgrupacion');
        grupoAgrupacion.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
            grupoAgrupacion.classList.add('drag-over');
        });
        grupoAgrupacion.addEventListener('dragleave', () => grupoAgrupacion.classList.remove('drag-over'));
        grupoAgrupacion.addEventListener('drop', (e) => {
            e.preventDefault();
            grupoAgrupacion.classList.remove('drag-over');
            const col = e.dataTransfer.getData('text/plain');
            if (col && !columnasAgrupadas.includes(col)) {
                columnasAgrupadas.push(col);
                actualizarGrupoColumnas();
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remover')) {
                columnasAgrupadas = columnasAgrupadas.filter(c => c !== e.target.dataset.columna);
                actualizarGrupoColumnas();
            }
        });
    }

    /* ---------- Expandir grupo ---------- */
    document.addEventListener('click', function (e) {
        const fila = e.target.closest('.fila-grupo');
        if (!fila) return;
        const id = fila.dataset.grupoId;
        const icono = fila.querySelector('i');
        if (expandedGroups.has(id)) {
            expandedGroups.delete(id);
            fila.classList.remove('expandido');
            if (icono) icono.className = 'fas fa-caret-right';
        } else {
            expandedGroups.add(id);
            fila.classList.add('expandido');
            if (icono) icono.className = 'fas fa-caret-down';
        }
        cargarTabla(datosFiltrados);
    });

    /* ---------- Búsqueda local ---------- */
    function filtrarPorBusqueda() {
        const t = buscador.value.toLowerCase().trim();
        if (t === '') {
            datosFiltrados = [...datosOriginales];
        } else {
            datosFiltrados = datosOriginales.filter(item =>
                (item.numero || '').toLowerCase().includes(t) ||
                (item.entidad_financiera || '').toLowerCase().includes(t) ||
                (item.parcialidad_actual || '').toLowerCase().includes(t)
            );
        }
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    }

    /* ---------- Paginación ---------- */
    function cambiarPagina(p) {
        const total = Math.ceil(datosFiltrados.length / registrosPorPagina);
        if (p >= 1 && p <= total) {
            paginaActual = p;
            cargarTabla(datosFiltrados);
        }
    }

    /* ============================================================
     *  MODAL CRÉDITO (crear / editar)
     * ============================================================ */
    function resetFormCredito() {
        formCredito.reset();
        document.getElementById('creditoId').value = '';
        erroresFormulario.style.display = 'none';
        erroresFormulario.innerHTML = '';
    }

    function abrirModalCrear() {
        resetFormCredito();
        modalCreditoTitulo.textContent = 'Nuevo Crédito';
        document.getElementById('fecha').value = new Date().toISOString().split('T')[0];
        abrirModal(modalCredito);
    }

    async function abrirModalEditar(id) {
        resetFormCredito();
        const { ok, data } = await apiFetch(ROUTES.editar(id));
        if (!ok || !data?.success) { alert('No se pudo cargar el crédito'); return; }
        const c = data.data;
        modalCreditoTitulo.textContent = 'Editar Crédito';
        document.getElementById('creditoId').value = c.id;
        document.getElementById('numero_credito').value = c.numero_credito || '';
        document.getElementById('banco_id').value = c.banco_id || '';
        document.getElementById('fecha').value = c.fecha ? String(c.fecha).split('T')[0] : '';
        document.getElementById('parcialidad_actual').value = c.parcialidad_actual || '';
        document.getElementById('monto_total').value = c.monto_total || '';
        document.getElementById('monto_pendiente').value = c.monto_pendiente || '';
        document.getElementById('monto_capital').value = c.monto_capital || '';
        document.getElementById('monto_capital_restante').value = c.monto_capital_restante || '';
        document.getElementById('tasa_interes').value = c.tasa_interes || '';
        document.getElementById('plazo_meses').value = c.plazo_meses || '';
        document.getElementById('notas').value = c.notas || '';
        abrirModal(modalCredito);
    }

    formCredito.addEventListener('submit', async function (e) {
        e.preventDefault();
        const id = document.getElementById('creditoId').value;
        const payload = {
            numero_credito:         document.getElementById('numero_credito').value.trim(),
            banco_id:               document.getElementById('banco_id').value,
            fecha:                  document.getElementById('fecha').value,
            parcialidad_actual:     document.getElementById('parcialidad_actual').value.trim(),
            monto_total:            document.getElementById('monto_total').value,
            monto_pendiente:        document.getElementById('monto_pendiente').value,
            monto_capital:          document.getElementById('monto_capital').value,
            monto_capital_restante: document.getElementById('monto_capital_restante').value,
            tasa_interes:           document.getElementById('tasa_interes').value || null,
            plazo_meses:            document.getElementById('plazo_meses').value || null,
            notas:                  document.getElementById('notas').value || null,
        };

        const url    = id ? ROUTES.actualizar(id) : ROUTES.crear;
        const method = id ? 'PUT' : 'POST';

        const { ok, data } = await apiFetch(url, { method, body: payload });

        if (!ok || !data?.success) {
            let html = data?.message || 'Error al guardar';
            if (data?.errors) {
                html += '<ul style="margin:6px 0 0 18px;">' +
                    Object.values(data.errors).flat().map(m => `<li>${escapeHtml(m)}</li>`).join('') +
                    '</ul>';
            }
            erroresFormulario.innerHTML = html;
            erroresFormulario.style.display = 'block';
            return;
        }

        cerrarModal(modalCredito);
        await cargarCreditos();
    });

    /* ---------- Eliminar ---------- */
    async function eliminarCredito(id) {
        if (!confirm(`¿Eliminar el crédito ID ${id}? Esta acción no se puede deshacer.`)) return;
        const { ok, data } = await apiFetch(ROUTES.eliminar(id), { method: 'DELETE' });
        if (!ok || !data?.success) { alert(data?.message || 'Error al eliminar'); return; }
        await cargarCreditos();
    }

    /* ---------- Ver detalle ---------- */
    async function verCredito(id) {
        const { ok, data } = await apiFetch(ROUTES.ver(id));
        if (!ok || !data?.success) { alert('No se pudo cargar el crédito'); return; }
        const c = data.data;

        const parc = (c.parcialidades || []).map(p => `
            <tr>
                <td style="padding:6px;border:1px solid #ddd;text-align:center;">${p.numero}</td>
                <td style="padding:6px;border:1px solid #ddd;">${formatDate(p.fecha_vencimiento)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(p.monto)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(p.capital)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(p.interes)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:center;">${p.estado}</td>
            </tr>`).join('') || `<tr><td colspan="6" style="text-align:center;padding:12px;color:#888;">Sin parcialidades registradas</td></tr>`;

        contenidoVer.innerHTML = `
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;margin-bottom:15px;">
                <div><b>No. Crédito:</b> ${escapeHtml(c.numero_credito)}</div>
                <div><b>Banco:</b> ${escapeHtml(c.entidad_financiera)}</div>
                <div><b>Fecha:</b> ${formatDate(c.fecha)}</div>
                <div><b>Parcialidad Actual:</b> ${escapeHtml(c.parcialidad_actual)}</div>
                <div><b>Monto Total:</b> ${formatCurrency(c.monto_total)}</div>
                <div><b>Pendiente:</b> ${formatCurrency(c.monto_pendiente)}</div>
                <div><b>Capital:</b> ${formatCurrency(c.monto_capital)}</div>
                <div><b>Restante Capital:</b> ${formatCurrency(c.monto_capital_restante)}</div>
                <div><b>Tasa Interés:</b> ${c.tasa_interes || 0}%</div>
                <div><b>Plazo:</b> ${c.plazo_meses || '-'} meses</div>
            </div>
            <div style="margin-bottom:10px;"><b>Notas:</b> ${escapeHtml(c.notas || '-')}</div>
            <h4 style="margin:10px 0 6px;color:#2378e1;">Parcialidades</h4>
            <table style="width:100%;border-collapse:collapse;font-size:12px;">
                <thead>
                    <tr style="background:#2378e1;color:white;">
                        <th style="padding:6px;border:1px solid #ddd;">#</th>
                        <th style="padding:6px;border:1px solid #ddd;">Vencimiento</th>
                        <th style="padding:6px;border:1px solid #ddd;">Monto</th>
                        <th style="padding:6px;border:1px solid #ddd;">Capital</th>
                        <th style="padding:6px;border:1px solid #ddd;">Interés</th>
                        <th style="padding:6px;border:1px solid #ddd;">Estado</th>
                    </tr>
                </thead>
                <tbody>${parc}</tbody>
            </table>`;
        abrirModal(modalVer);
    }

    /* ============================================================
     *  MODAL PARCIALIDADES (CRUD completo)
     * ============================================================ */
    async function verParcialidades(id) {
        creditoParcialidadesActual = id;
        parcialidadEditando = null;
        await refrescarModalParcialidades();
        abrirModal(modalParcialidades);
    }

    async function refrescarModalParcialidades() {
        const { ok, data } = await apiFetch(ROUTES.parcialidades(creditoParcialidadesActual));
        if (!ok || !data?.success) { alert('No se pudieron cargar las parcialidades'); return; }
        const c = data.data;
        parcialidadesCache = c.parcialidades || [];

        const numeroSiguiente = parcialidadEditando
            ? parcialidadEditando.numero
            : (parcialidadesCache.length ? Math.max(...parcialidadesCache.map(p => p.numero)) + 1 : 1);

        const p = parcialidadEditando || {};
        const esEdicion = !!parcialidadEditando;

        tituloParcialidades.textContent = `Parcialidades - ${c.numero_credito}`;

        const filas = parcialidadesCache.map(x => `
            <tr data-pid="${x.id}">
                <td style="padding:6px;border:1px solid #ddd;text-align:center;">${x.numero}</td>
                <td style="padding:6px;border:1px solid #ddd;">${formatDate(x.fecha_vencimiento)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(x.monto)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(x.capital)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(x.interes)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:right;">${formatCurrency(x.saldo)}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:center;">
                    <span style="padding:2px 6px;border-radius:10px;font-size:11px;background:${
                        x.estado === 'pagada'  ? '#d1fae5' :
                        x.estado === 'vencida' ? '#fee2e2' :
                        x.estado === 'parcial' ? '#fef3c7' : '#e5e7eb'
                    };">${x.estado}</span>
                </td>
                <td style="padding:6px;border:1px solid #ddd;text-align:center;">${x.fecha_pago ? formatDate(x.fecha_pago) : '-'}</td>
                <td style="padding:6px;border:1px solid #ddd;text-align:center;white-space:nowrap;">
                    <i class="fas fa-edit" style="color:#083CAE;cursor:pointer;margin-right:8px;" title="Editar" data-parc-action="editar" data-pid="${x.id}"></i>
                    <i class="fas fa-trash-alt" style="color:#dc2626;cursor:pointer;" title="Eliminar" data-parc-action="eliminar" data-pid="${x.id}"></i>
                </td>
            </tr>
        `).join('') || `<tr><td colspan="9" style="text-align:center;padding:12px;color:#888;">Sin parcialidades registradas</td></tr>`;

        contenidoParcialidades.innerHTML = `
            <div style="background:#f8f9fa;border:1px solid #dee2e6;border-radius:6px;padding:12px;margin-bottom:15px;">
                <h4 style="margin:0 0 10px;color:#2378e1;font-size:14px;">
                    ${esEdicion ? 'Editar parcialidad #' + p.numero : 'Agregar parcialidad'}
                </h4>
                <div id="errorParcialidad" style="display:none;background:#fee2e2;border:1px solid #fecaca;border-radius:4px;padding:8px;color:#991b1b;font-size:12px;margin-bottom:10px;"></div>
                <form id="formParcialidad" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;align-items:end;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;"># Parcialidad *</label>
                        <input type="number" min="1" name="numero" value="${numeroSiguiente}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Fecha Venc. *</label>
                        <input type="date" name="fecha_vencimiento" value="${p.fecha_vencimiento ? String(p.fecha_vencimiento).split('T')[0] : ''}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Monto *</label>
                        <input type="number" step="0.01" min="0" name="monto" value="${p.monto ?? ''}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Capital *</label>
                        <input type="number" step="0.01" min="0" name="capital" value="${p.capital ?? ''}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Interés *</label>
                        <input type="number" step="0.01" min="0" name="interes" value="${p.interes ?? ''}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Saldo *</label>
                        <input type="number" step="0.01" min="0" name="saldo" value="${p.saldo ?? ''}" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Estado *</label>
                        <select name="estado" required style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                            ${['pendiente','pagada','vencida','parcial'].map(e =>
                                `<option value="${e}" ${p.estado === e ? 'selected' : ''}>${e}</option>`
                            ).join('')}
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Fecha Pago</label>
                        <input type="date" name="fecha_pago" value="${p.fecha_pago ? String(p.fecha_pago).split('T')[0] : ''}" style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:600;color:#333;">Notas</label>
                        <input type="text" name="notas" value="${escapeHtml(p.notas || '')}" style="width:100%;padding:6px;border:1px solid #ced4da;border-radius:4px;font-size:13px;">
                    </div>
                    <div style="display:flex;gap:6px;grid-column:1/-1;justify-content:flex-end;margin-top:5px;">
                        ${esEdicion ? `<button type="button" id="cancelarEdicionParc" style="padding:7px 14px;background:#e5e7eb;color:#333;border:none;border-radius:4px;font-size:13px;cursor:pointer;">Cancelar</button>` : ''}
                        <button type="submit" style="padding:7px 16px;background:#2378e1;color:white;border:none;border-radius:4px;font-size:13px;font-weight:600;cursor:pointer;">
                            ${esEdicion ? 'Actualizar' : 'Agregar parcialidad'}
                        </button>
                    </div>
                </form>
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:12px;">
                <thead>
                    <tr style="background:#2378e1;color:white;">
                        <th style="padding:6px;border:1px solid #ddd;">#</th>
                        <th style="padding:6px;border:1px solid #ddd;">Vencimiento</th>
                        <th style="padding:6px;border:1px solid #ddd;">Monto</th>
                        <th style="padding:6px;border:1px solid #ddd;">Capital</th>
                        <th style="padding:6px;border:1px solid #ddd;">Interés</th>
                        <th style="padding:6px;border:1px solid #ddd;">Saldo</th>
                        <th style="padding:6px;border:1px solid #ddd;">Estado</th>
                        <th style="padding:6px;border:1px solid #ddd;">Pagada</th>
                        <th style="padding:6px;border:1px solid #ddd;">Acciones</th>
                    </tr>
                </thead>
                <tbody>${filas}</tbody>
            </table>
        `;

        // Submit del form
        document.getElementById('formParcialidad').addEventListener('submit', async (e) => {
            e.preventDefault();
            const f = e.target;
            const payload = {
                numero:            parseInt(f.numero.value, 10),
                fecha_vencimiento: f.fecha_vencimiento.value,
                fecha_pago:        f.fecha_pago.value || null,
                monto:             parseFloat(f.monto.value),
                capital:           parseFloat(f.capital.value),
                interes:           parseFloat(f.interes.value),
                saldo:             parseFloat(f.saldo.value),
                estado:            f.estado.value,
                notas:             f.notas.value || null,
            };

            const url    = esEdicion
                ? ROUTES.actualizarParcialidad(creditoParcialidadesActual, p.id)
                : ROUTES.crearParcialidad(creditoParcialidadesActual);
            const method = esEdicion ? 'PUT' : 'POST';

            const resp = await apiFetch(url, { method, body: payload });
            if (!resp.ok || !resp.data?.success) {
                const errDiv = document.getElementById('errorParcialidad');
                let html = resp.data?.message || 'Error';
                if (resp.data?.errors) {
                    html += '<ul style="margin:4px 0 0 16px;">' +
                        Object.values(resp.data.errors).flat().map(m => `<li>${escapeHtml(m)}</li>`).join('') +
                        '</ul>';
                }
                errDiv.innerHTML = html;
                errDiv.style.display = 'block';
                return;
            }

            parcialidadEditando = null;
            await refrescarModalParcialidades();
            await cargarCreditos();
        });

        // Cancelar edición
        const cancelar = document.getElementById('cancelarEdicionParc');
        if (cancelar) {
            cancelar.addEventListener('click', () => {
                parcialidadEditando = null;
                refrescarModalParcialidades();
            });
        }

        // Acciones editar/eliminar
        contenidoParcialidades.querySelectorAll('[data-parc-action]').forEach(icon => {
            icon.addEventListener('click', async () => {
                const pid    = icon.dataset.pid;
                const action = icon.dataset.parcAction;

                if (action === 'editar') {
                    const parcialidad = parcialidadesCache.find(x => String(x.id) === String(pid));
                    parcialidadEditando = parcialidad || null;
                    await refrescarModalParcialidades();
                } else if (action === 'eliminar') {
                    if (!confirm(`¿Eliminar la parcialidad #${pid}?`)) return;
                    const resp = await apiFetch(
                        ROUTES.eliminarParcialidad(creditoParcialidadesActual, pid),
                        { method: 'DELETE' }
                    );
                    if (!resp.ok || !resp.data?.success) {
                        alert(resp.data?.message || 'Error al eliminar');
                        return;
                    }
                    await refrescarModalParcialidades();
                    await cargarCreditos();
                }
            });
        });
    }

    /* ---------- PDF ---------- */
    function descargarPdf(id) {
        window.open(ROUTES.pdf(id), '_blank');
    }

    /* ---------- Delegación de acciones de fila ---------- */
    document.addEventListener('click', function (e) {
        const icon = e.target.closest('i[data-action]');
        if (!icon) return;
        const action = icon.dataset.action;
        const id     = icon.dataset.id;

        if (action === 'editar')        abrirModalEditar(id);
        else if (action === 'eliminar') eliminarCredito(id);
        else if (action === 'ver')      verCredito(id);
        else if (action === 'pdf')      descargarPdf(id);
        else if (action === 'parcialidades') verParcialidades(id);
    });

    /* ============================================================
     *  UI principal
     * ============================================================ */
    btnAgregar.addEventListener('click', abrirModalCrear);

    btnExcel.addEventListener('click', function () {
        const params = new URLSearchParams({
            fecha_inicio: fechaInicio.value || '',
            fecha_fin:    fechaFin.value || '',
        });
        window.open(`${ROUTES.exportar}?${params.toString()}`, '_blank');
    });

    btnColumnas.addEventListener('click', function () {
        const cols = ['No. Crédito','Entidad Financiera','Fecha','Monto','Pendiente','Monto Capital','Restante Capital','Parcialidad Actual'];
        alert('Columnas disponibles:\n- ' + cols.join('\n- ') + '\n\n(Funcionalidad de ocultar/mostrar en próxima iteración)');
    });

    btnCrearFiltro.addEventListener('click', cargarCreditos);
    buscador.addEventListener('input', filtrarPorBusqueda);
    fechaInicio.addEventListener('change', cargarCreditos);
    fechaFin.addEventListener('change', cargarCreditos);

    document.querySelectorAll('.pagina-btn').forEach(btn =>
        btn.addEventListener('click', () => cambiarPagina(parseInt(btn.dataset.pagina)))
    );
    btnPrimera.addEventListener('click', () => cambiarPagina(1));
    btnAnterior.addEventListener('click', () => cambiarPagina(paginaActual - 1));
    btnSiguiente.addEventListener('click', () => cambiarPagina(paginaActual + 1));
    btnUltima.addEventListener('click', () => cambiarPagina(Math.ceil(datosFiltrados.length / registrosPorPagina)));

    document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
        icon.addEventListener('click', function () {
            alert('Filtro de columna - Próxima iteración');
        });
    });

    /* ---------- Cerrar modales ---------- */
    cerrarModalCredito.addEventListener('click', () => cerrarModal(modalCredito));
    cancelarFormCredito.addEventListener('click', () => cerrarModal(modalCredito));
    cerrarModalVer.addEventListener('click', () => cerrarModal(modalVer));
    cerrarModalParcialidades.addEventListener('click', () => {
        parcialidadEditando = null;
        creditoParcialidadesActual = null;
        cerrarModal(modalParcialidades);
    });
    [modalCredito, modalVer, modalParcialidades].forEach(m => {
        m.addEventListener('click', (e) => {
            if (e.target === m) {
                if (m === modalParcialidades) {
                    parcialidadEditando = null;
                    creditoParcialidadesActual = null;
                }
                cerrarModal(m);
            }
        });
    });

    /* ---------- Inicialización ---------- */
    (async function init() {
        await cargarBancos();
        await cargarCreditos();
        setupDragAndDrop();
    })();
});
</script>
@endsection