@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-chart-line"></i> Notas de Venta
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Total Notas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold;" id="totalVentas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Facturadas</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalFacturas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Completadas</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalCompletadas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #17a2b8; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Monto Facturado</div>
                            <div style="color: #17a2b8; font-size: 36px; font-weight: bold;" id="montoTotal">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-receipt" style="color: #083CAE; font-size: 14px;"></i>
                        <span style="color: #6c757d; font-size: 12px;">Notas de venta y su vínculo con facturación</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;" title="Nueva Nota">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div>
                            <button id="btnLimpiarFiltros" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-eraser"></i> Limpiar
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="buscador" placeholder="Buscar folio, cliente, RFC..." style="padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingIndicator" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p>Cargando datos...</p>
                </div>

                <!-- Sin datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 60px; background: #f8f9fa; border-radius: 8px; display: none;">
                    <i class="fas fa-receipt" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay notas de venta</h3>
                    <p style="color: #999;">Usa el botón <strong>+</strong> para crear la primera</p>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaVentas" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px;">Cliente</th>
                                <th style="padding: 12px 6px;">RFC</th>
                                <th style="padding: 12px 6px; text-align: right;">Subtotal</th>
                                <th style="padding: 12px 6px; text-align: right;">Descuento</th>
                                <th style="padding: 12px 6px; text-align: right;">IVA</th>
                                <th style="padding: 12px 6px; text-align: right;">Total</th>
                                <th style="padding: 12px 6px; text-align: center;">Facturada</th>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; text-align: right;"><strong>TOTALES:</strong></td>
                                <td style="padding: 10px; text-align: right;" id="sumSubtotal">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumDescuento">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumIva">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumTotal">$0.00</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div></div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button id="btnPrimeraPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button id="btnAnteriorPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span style="padding: 5px 12px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaActual">1</span>
                        <span id="paginacionInfo" style="color: #666; font-size: 12px;">Mostrando 0-0 de 0 registros</span>
                        <button id="btnSiguientePagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button id="btnUltimaPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA / EDITAR NOTA -->
<div id="modalNota" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 1200px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">

        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-receipt" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;" id="tituloModalNota">Nueva Nota de Venta</span>
            </div>
            <button id="cerrarModalNota" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>

        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
            <input type="hidden" id="nota_id_edicion" value="">

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente *</label>
                    <select id="contacto_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Seleccionar cliente...</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto (opcional)</label>
                    <select id="proyecto_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Sin proyecto</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha *</label>
                    <input type="date" id="fecha" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="grid-column: span 3;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                    <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                </div>
            </div>

            <!-- Conceptos -->
            <div style="border-top: 2px solid #e0e0e0; padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="margin: 0; color: #083CAE;">Conceptos</h3>
                    <button type="button" id="btnAgregarConcepto" style="background-color: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer;">
                        <i class="fas fa-plus"></i> Agregar Concepto
                    </button>
                </div>

                <div style="border: 1px solid #ddd; border-radius: 8px; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f5f5f5;">
                            <tr>
                                <th style="padding: 12px; text-align: left;">Código</th>
                                <th style="padding: 12px; text-align: left;">Descripción</th>
                                <th style="padding: 12px; text-align: right;">Cantidad</th>
                                <th style="padding: 12px; text-align: right;">Valor Unitario</th>
                                <th style="padding: 12px; text-align: right;">Descuento</th>
                                <th style="padding: 12px; text-align: right;">Importe</th>
                                <th style="padding: 12px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaConceptos">
                            <tr id="filaConceptoVacia">
                                <td colspan="7" style="padding: 40px; text-align: center; color: #999;">
                                    <i class="fas fa-info-circle"></i> No hay conceptos agregados
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 20px; border-radius: 8px; margin-top: 20px;">
                    <div style="display: flex; justify-content: flex-end; gap: 30px; flex-wrap: wrap;">
                        <div style="text-align: right;">
                            <div style="color: #666; font-size: 14px;">Subtotal:</div>
                            <div style="font-size: 22px; font-weight: bold;" id="resumenSubtotal">$0.00</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="color: #666; font-size: 14px;">Descuento:</div>
                            <div style="font-size: 22px; font-weight: bold; color: #dc3545;" id="resumenDescuento">$0.00</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="color: #666; font-size: 14px;">IVA (16%):</div>
                            <div style="font-size: 22px; font-weight: bold;" id="resumenIVA">$0.00</div>
                        </div>
                        <div style="text-align: right; padding-left: 30px; border-left: 2px solid #ccc;">
                            <div style="color: #666; font-size: 14px;">Total:</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="resumenTotal">$0.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button id="btnCancelarNota" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarNota" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>
</div>

<!-- MODAL CONCEPTO -->
<div id="modalConcepto" style="display: none; position: fixed; z-index: 10002; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 6% auto; width: 90%; max-width: 600px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 id="modalConceptoTitulo" style="margin: 0;">Agregar Concepto</h3>
        </div>
        <div style="padding: 25px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código:</label>
                    <input type="text" id="conceptoCodigo" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Clave SAT:</label>
                    <select id="conceptoProductoSat" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="84111500">84111500 - Servicios de contabilidad</option>
                        <option value="80111600">80111600 - Servicios de construcción</option>
                        <option value="01010101">01010101 - No existe en el catálogo</option>
                    </select>
                </div>
                <div style="grid-column: span 2; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción *:</label>
                    <textarea id="conceptoDescripcion" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                </div>
                <div style="grid-column: span 2; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones:</label>
                    <textarea id="conceptoObservaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cantidad *:</label>
                    <input type="number" id="conceptoCantidad" step="0.01" value="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Unidad SAT:</label>
                    <select id="conceptoUnidadSat" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="ACT">ACT - Actividad</option>
                        <option value="H87">H87 - Pieza</option>
                        <option value="E48">E48 - Unidad de servicio</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Valor Unitario *:</label>
                    <input type="number" id="conceptoValorUnitario" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descuento ($):</label>
                    <input type="number" id="conceptoDescuento" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelarConcepto" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button type="button" id="btnGuardarConcepto" style="background-color: #083CAE; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 30000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; text-align: center;">
        <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
        <p style="margin-top: 15px;">Procesando...</p>
    </div>
</div>

<style>
    .swal2-container { z-index: 40000 !important; }
    .swal2-popup { z-index: 40001 !important; }

    .custom-card { transition: transform 0.2s, box-shadow 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }

    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-abierta    { background-color: #d1ecf1; color: #0c5460; }
    .badge-facturada  { background-color: #d4edda; color: #155724; }
    .badge-cancelada  { background-color: #f8d7da; color: #721c24; }
    .badge-facturada-yes { background-color: #28a745; color: white; }
    .badge-facturada-no  { background-color: #e9ecef; color: #6c757d; }

    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }

    /* Modal Ver detalle */
    .nota-detalle-wrap { text-align: left; font-family: 'Segoe UI', Tahoma, sans-serif; color: #333; }
    .nota-detalle-header {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;
        padding: 20px 22px; background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%);
        border-radius: 12px; color: white; margin-bottom: 20px;
    }
    .nota-detalle-header .folio { font-size: 24px; font-weight: bold; line-height: 1.2; }
    .nota-detalle-header .folio small { display: block; font-size: 12px; font-weight: 400; opacity: 0.85; margin-top: 2px; }
    .nota-detalle-header .estatus-badge {
        padding: 6px 16px; border-radius: 20px; font-weight: 600; font-size: 13px;
        background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4);
    }
    .nota-detalle-info { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .nota-detalle-card { background: #f8f9fa; border-left: 4px solid #083CAE; border-radius: 8px; padding: 14px 18px; }
    .nota-detalle-card h4 { margin: 0 0 10px 0; color: #083CAE; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
    .nota-detalle-card p { margin: 4px 0; font-size: 13px; display: flex; justify-content: space-between; gap: 10px; }
    .nota-detalle-card p strong { color: #555; font-weight: 600; }
    .nota-detalle-card p span { text-align: right; color: #000; font-weight: 600; }
    .nota-detalle-tabla { width: 100%; border-collapse: collapse; font-size: 12px; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .nota-detalle-tabla thead { background: #083CAE; color: white; }
    .nota-detalle-tabla thead th { padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; }
    .nota-detalle-tabla tbody td { padding: 10px 8px; border-bottom: 1px solid #eef0f4; vertical-align: top; }
    .nota-detalle-tabla tbody tr:nth-child(even) { background: #f9fafc; }
    .nota-detalle-tabla tbody tr:hover { background: #eaf1fb; }
    .nota-detalle-tabla .text-right { text-align: right; }
    .nota-detalle-totales { margin-top: 18px; background: #f8f9fa; border-radius: 10px; padding: 16px 20px; display: flex; flex-direction: column; gap: 6px; }
    .nota-detalle-totales .row { display: flex; justify-content: space-between; font-size: 13px; padding: 4px 0; color: #555; }
    .nota-detalle-totales .row.detalle-extra { color: #dc3545; }
    .nota-detalle-totales .row.total-final { border-top: 2px solid #083CAE; margin-top: 6px; padding-top: 10px; font-size: 18px; font-weight: bold; color: #083CAE; }
    .nota-detalle-totales .row.total-final span { font-size: 22px; }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(3, 1fr)"] { grid-template-columns: 1fr !important; }
        div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        .nota-detalle-info { grid-template-columns: 1fr; }
        .nota-detalle-header { flex-direction: column; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================================
// VARIABLES GLOBALES
// ============================================================
let datosNotas = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;
let conceptos = [];
let editandoConceptoIndex = -1;
let modoEdicionNota = false;

function apiBase() { return ''; }

// ============================================================
// UTILIDADES
// ============================================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) amount = 0;
    return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function formatDate(dateString) {
    if (!dateString) return '-';
    try {
        const d = new Date(dateString);
        if (isNaN(d.getTime())) return dateString;
        return d.toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric' });
    } catch(e) { return dateString; }
}

function normalizarEstatus(estatus) {
    if (estatus === null || estatus === undefined) return 'abierta';
    const porNumero = { 1: 'abierta', 19: 'facturada', 21: 'cancelada' };
    const num = parseInt(estatus);
    if (!isNaN(num) && porNumero[num]) return porNumero[num];
    const s = String(estatus).toLowerCase().trim();
    return s || 'abierta';
}

function getBadgeClass(estatus) {
    const map = {
        'abierta':   'badge-abierta',
        'facturada': 'badge-facturada',
        'cancelada': 'badge-cancelada'
    };
    return map[normalizarEstatus(estatus)] || 'badge-abierta';
}

function getEstatusDisplay(estatus) {
    const map = {
        'abierta':   'Abierta',
        'facturada': 'Facturada',
        'cancelada': 'Cancelada'
    };
    return map[normalizarEstatus(estatus)] || 'Abierta';
}

function showLoading(show) {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = show ? 'flex' : 'none';
}

function showError(msg) {
    Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonColor: '#083CAE',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; } });
}

function showSuccess(msg) {
    Swal.fire({ icon: 'success', title: 'Éxito', text: msg, confirmButtonColor: '#083CAE', timer: 3000,
        showConfirmButton: false, didOpen: () => { Swal.getContainer().style.zIndex = '40000'; } });
}

function fetchJSON(url, options = {}) {
    const opts = Object.assign({ headers: { 'Accept': 'application/json' } }, options);
    opts.headers = Object.assign({ 'Accept': 'application/json' }, options.headers || {});
    return fetch(url, opts).then(response => {
        if (!response.ok) throw new Error(`HTTP ${response.status} ${response.statusText}`);
        const ct = response.headers.get('content-type') || '';
        if (!ct.includes('application/json')) {
            return response.text().then(t => { throw new Error('Respuesta no es JSON: ' + t.substring(0, 200)); });
        }
        return response.json();
    });
}

// ============================================================
// CARGA DE DATOS
// ============================================================
function cargarDatos() {
    showLoading(true);

    const params = new URLSearchParams();
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busqueda = document.getElementById('buscador').value;

    if (fi) params.append('fecha_inicio', fi);
    if (ff) params.append('fecha_fin', ff);
    if (busqueda) params.append('search', busqueda);

    fetchJSON(apiBase() + '/notas-venta/data?' + params.toString())
        .then(response => {
            if (response.success && response.data) {
                datosNotas = response.data;
                datosFiltrados = [...datosNotas];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosNotas = [];
                datosFiltrados = [];
                actualizarContadores({ total_ventas: 0, total_facturas: 0, ventas_completadas: 0, total_ingresos: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error cargarDatos NV:', error);
            datosNotas = [];
            datosFiltrados = [];
            actualizarContadores({ total_ventas: 0, total_facturas: 0, ventas_completadas: 0, total_ingresos: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalVentas').textContent = stats.total_ventas || 0;
    document.getElementById('totalFacturas').textContent = stats.total_facturas || 0;
    document.getElementById('totalCompletadas').textContent = stats.ventas_completadas || 0;
    document.getElementById('montoTotal').textContent = formatCurrency(stats.total_ingresos || 0);
}

function calcularTotales(datos) {
    let subtotal = 0, descuento = 0, iva = 0, total = 0;
    datos.forEach(item => {
        subtotal  += parseFloat(item.subtotal  || 0);
        descuento += parseFloat(item.descuento || 0);
        iva       += parseFloat(item.iva       || 0);
        total     += parseFloat(item.total     || 0);
    });
    document.getElementById('sumSubtotal').textContent  = formatCurrency(subtotal);
    document.getElementById('sumDescuento').textContent = formatCurrency(descuento);
    document.getElementById('sumIva').textContent       = formatCurrency(iva);
    document.getElementById('sumTotal').textContent     = formatCurrency(total);
}

function cargarTabla() {
    const tbody = document.getElementById('tablaBody');
    const sinDatos = document.getElementById('sinDatosMensaje');
    const tablaContainer = document.getElementById('tablaContainer');

    if (!tbody) return;

    if (datosFiltrados.length === 0) {
        sinDatos.style.display = 'block';
        tablaContainer.style.display = 'none';
        calcularTotales([]);
        actualizarPaginacion(0);
        return;
    }

    sinDatos.style.display = 'none';
    tablaContainer.style.display = 'block';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageData = datosFiltrados.slice(start, end);

    tbody.innerHTML = '';

    pageData.forEach(item => {
        const row = tbody.insertRow();
        const estatusTexto = item.estatus_texto || normalizarEstatus(item.estatus);
        const badgeFacturada = item.facturada
            ? '<span class="badge badge-facturada-yes">Sí</span>'
            : '<span class="badge badge-facturada-no">No</span>';

        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 6px;">${item.cliente_nombre || '-'}</td>
            <td style="padding: 10px 6px;">${item.cliente_rfc || '-'}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.subtotal)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.descuento)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.iva)}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.total)}</strong></td>
            <td style="padding: 10px 6px; text-align: center;">${badgeFacturada}</td>
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${getBadgeClass(estatusTexto)}">${getEstatusDisplay(estatusTexto)}</span></td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.id}"></i>
                    ${!item.facturada ? `<i class="fas fa-edit" style="color: #ffc107; cursor: pointer;" title="Editar" data-id="${item.id}"></i>` : ''}
                    ${!item.facturada ? `<i class="fas fa-file-invoice" style="color: #28a745; cursor: pointer;" title="Facturar" data-id="${item.id}"></i>` : ''}
                    ${!item.facturada ? `<i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;" title="Eliminar" data-id="${item.id}"></i>` : ''}
                </div>
            </td>
        `;
    });

    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);

    document.querySelectorAll('.fa-eye').forEach(el =>
        el.addEventListener('click', () => verNota(el.dataset.id)));
    document.querySelectorAll('.fa-edit').forEach(el =>
        el.addEventListener('click', () => editarNota(el.dataset.id)));
    document.querySelectorAll('.fa-file-invoice').forEach(el =>
        el.addEventListener('click', () => facturarNota(el.dataset.id)));
    document.querySelectorAll('.fa-trash-alt').forEach(el =>
        el.addEventListener('click', () => eliminarNota(el.dataset.id)));
}

function actualizarPaginacion(total) {
    const start = total === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${start}-${end} de ${total} registros`;
}

// ============================================================
// VER DETALLE
// ============================================================
function verNota(id) {
    fetchJSON(apiBase() + `/api/notas-venta/${id}`)
        .then(data => {
            if (!data.success) { showError(data.message || 'No se pudo cargar la nota'); return; }
            const n = data.data;
            const estatusTexto = n.estatus_texto || normalizarEstatus(n.estatus);

            let conceptosHtml = '';
            if (data.conceptos && data.conceptos.length > 0) {
                conceptosHtml = `<table class="nota-detalle-tabla"><thead><tr>
                    <th style="width:50%">Descripción</th>
                    <th class="text-right" style="width:10%">Cant.</th>
                    <th class="text-right" style="width:20%">V. Unit.</th>
                    <th class="text-right" style="width:20%">Importe</th>
                </tr></thead><tbody>`;
                data.conceptos.forEach(c => {
                    const obs = c.observaciones ? `<span style="display:block;color:#777;font-size:11px;font-style:italic;margin-top:4px;">${c.observaciones}</span>` : '';
                    conceptosHtml += `<tr>
                        <td>${c.descripcion || '-'}${obs}</td>
                        <td class="text-right">${parseFloat(c.cantidad || 0).toFixed(2)}</td>
                        <td class="text-right">${formatCurrency(c.valor_unitario)}</td>
                        <td class="text-right"><strong>${formatCurrency((c.importe || 0) - (c.descuento || 0))}</strong></td>
                    </tr>`;
                });
                conceptosHtml += `</tbody></table>`;
            } else {
                conceptosHtml = `<div style="padding:20px;text-align:center;color:#999;background:#f8f9fa;border-radius:8px;">Sin conceptos</div>`;
            }

            let descuentoRow = '';
            if (parseFloat(n.descuento || 0) > 0) descuentoRow = `<div class="row detalle-extra"><span>Descuento:</span><span>-${formatCurrency(n.descuento)}</span></div>`;
            const obsHtml = n.observaciones ? `<div style="background:#fff9e6;border-left:4px solid #ffc107;border-radius:8px;padding:12px 16px;margin-top:16px;font-size:12px;"><strong style="display:block;color:#856404;margin-bottom:4px;font-size:11px;text-transform:uppercase;">Observaciones</strong><p style="margin:0;color:#555;white-space:pre-wrap;">${n.observaciones}</p></div>` : '';
            const facturaHtml = n.facturada && n.factura_id ? `<div style="background:#eef4fb;border-left:4px solid #17a2b8;border-radius:8px;padding:12px 16px;margin-top:12px;font-size:12px;"><strong style="color:#0c5460;display:block;margin-bottom:4px;font-size:11px;text-transform:uppercase;">Factura generada</strong><span style="color:#083CAE;font-weight:bold;">Factura #${n.factura_id}</span></div>` : '';

            const html = `<div class="nota-detalle-wrap">
                <div class="nota-detalle-header">
                    <div>
                        <div class="folio">${n.folio || ''}<small>Nota de venta</small></div>
                    </div>
                    <div style="text-align:right;">
                        <div class="estatus-badge">${getEstatusDisplay(estatusTexto)}</div>
                        <div style="font-size:12px;margin-top:8px;opacity:0.9;">Fecha: ${formatDate(n.fecha)}</div>
                    </div>
                </div>
                <div class="nota-detalle-info">
                    <div class="nota-detalle-card">
                        <h4><i class="fas fa-user"></i> Cliente</h4>
                        <p><strong>Razón Social:</strong> <span>${n.cliente_nombre || '-'}</span></p>
                        <p><strong>RFC:</strong> <span>${n.cliente_rfc || '-'}</span></p>
                    </div>
                    <div class="nota-detalle-card">
                        <h4><i class="fas fa-check-circle"></i> Estado</h4>
                        <p><strong>Facturada:</strong> <span>${n.facturada ? 'Sí' : 'No'}</span></p>
                        <p><strong>Estatus:</strong> <span>${getEstatusDisplay(estatusTexto)}</span></p>
                    </div>
                </div>
                <div style="color:#083CAE;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin:20px 0 10px 0;padding-bottom:6px;border-bottom:2px solid #e3e8f0;"><i class="fas fa-list"></i> Conceptos</div>
                ${conceptosHtml}
                <div class="nota-detalle-totales">
                    <div class="row"><span>Subtotal:</span><span>${formatCurrency(n.subtotal)}</span></div>
                    ${descuentoRow}
                    <div class="row"><span>IVA (16%):</span><span>${formatCurrency(n.iva)}</span></div>
                    <div class="row total-final"><span>Total:</span><span>${formatCurrency(n.total)}</span></div>
                </div>
                ${facturaHtml}
                ${obsHtml}
            </div>`;

            Swal.fire({
                title: false, html: html, width: '850px', showCloseButton: true, showConfirmButton: false, padding: '1.2em',
                didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
            });
        })
        .catch(error => { console.error('Error verNota:', error); showError('Error al cargar la nota: ' + error.message); });
}

// ============================================================
// EDITAR NOTA
// ============================================================
function editarNota(id) {
    fetchJSON(apiBase() + `/api/notas-venta/${id}`)
        .then(data => {
            if (!data.success) { showError('No se pudo cargar la nota'); return; }
            const n = data.data;
            if (n.facturada) { showError('No se puede editar una nota ya facturada'); return; }

            modoEdicionNota = true;
            document.getElementById('tituloModalNota').textContent = 'Editar Nota ' + (n.folio || '');
            document.getElementById('nota_id_edicion').value = n.id;

            cargarCombos().then(() => {
                document.getElementById('contacto_id').value = n.contacto_id || '';
                document.getElementById('proyecto_id').value = n.proyecto_id || '';
                document.getElementById('fecha').value = (n.fecha || '').substring(0, 10);
                document.getElementById('observaciones').value = n.observaciones || '';

                conceptos = (data.conceptos || []).map(c => ({
                    codigo: c.codigo || '',
                    descripcion: c.descripcion,
                    observaciones: c.observaciones || '',
                    cantidad: parseFloat(c.cantidad),
                    valorUnitario: parseFloat(c.valor_unitario),
                    descuento: parseFloat(c.descuento || 0),
                    importe: parseFloat(c.importe),
                    productoSat: c.satcat_clave_productos_clave || '84111500',
                    unidadSat: c.satcat_unidades_clave || 'ACT'
                }));
                actualizarTablaConceptos();
                actualizarResumen();

                document.getElementById('modalNota').style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        })
        .catch(err => { console.error(err); showError('Error al cargar la nota: ' + err.message); });
}

// ============================================================
// FACTURAR NOTA (redirige a facturación)
// ============================================================
function facturarNota(id) {
    Swal.fire({
        title: '¿Facturar esta nota de venta?',
        text: 'Serás redirigido al módulo de facturación con la nota precargada.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, facturar',
        cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(result => {
        if (!result.isConfirmed) return;
        // Redirige a /facturacion con query string para precargar la nota
        window.location.href = apiBase() + '/facturacion?nota_venta_id=' + id;
    });
}

// ============================================================
// ELIMINAR
// ============================================================
function eliminarNota(id) {
    Swal.fire({
        title: '¿Eliminar nota de venta?',
        text: 'La nota se marcará como cancelada.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(res => {
        if (!res.isConfirmed) return;
        fetchJSON(apiBase() + `/api/notas-venta/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.getElementById('csrf_token').value }
        })
        .then(data => {
            if (data.success) { showSuccess('Nota eliminada'); cargarDatos(); }
            else showError(data.message || 'Error al eliminar');
        })
        .catch(err => { console.error(err); showError('Error al eliminar: ' + err.message); });
    });
}

// ============================================================
// MODAL NUEVA / EDITAR
// ============================================================
function abrirModalNota() {
    modoEdicionNota = false;
    document.getElementById('tituloModalNota').textContent = 'Nueva Nota de Venta';
    document.getElementById('nota_id_edicion').value = '';
    document.getElementById('contacto_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('observaciones').value = '';
    conceptos = [];
    editandoConceptoIndex = -1;
    actualizarTablaConceptos();
    actualizarResumen();

    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;

    cargarCombos();
    document.getElementById('modalNota').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModalNota() {
    document.getElementById('modalNota').style.display = 'none';
    document.body.style.overflow = 'auto';
    modoEdicionNota = false;
}

function cargarCombos() {
    const promises = [];

    promises.push(fetchJSON(apiBase() + '/api/contactos').then(data => {
        const select = document.getElementById('contacto_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar cliente...</option>';
            data.forEach(c => select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`);
        }
    }).catch(e => console.error('Error clientes:', e)));

    promises.push(fetchJSON(apiBase() + '/api/proyectos/activos').then(data => {
        const select = document.getElementById('proyecto_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Sin proyecto</option>';
            data.forEach(p => select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`);
        }
    }).catch(e => console.error('Error proyectos:', e)));

    return Promise.all(promises);
}

// ============================================================
// CONCEPTOS
// ============================================================
function abrirModalConcepto(index = -1) {
    editandoConceptoIndex = index;

    if (index >= 0 && conceptos[index]) {
        document.getElementById('modalConceptoTitulo').textContent = 'Editar Concepto';
        document.getElementById('conceptoCodigo').value = conceptos[index].codigo || '';
        document.getElementById('conceptoDescripcion').value = conceptos[index].descripcion;
        document.getElementById('conceptoObservaciones').value = conceptos[index].observaciones || '';
        document.getElementById('conceptoCantidad').value = conceptos[index].cantidad;
        document.getElementById('conceptoValorUnitario').value = conceptos[index].valorUnitario;
        document.getElementById('conceptoDescuento').value = conceptos[index].descuento || 0;
        document.getElementById('conceptoProductoSat').value = conceptos[index].productoSat || '84111500';
        document.getElementById('conceptoUnidadSat').value = conceptos[index].unidadSat || 'ACT';
    } else {
        document.getElementById('modalConceptoTitulo').textContent = 'Agregar Concepto';
        document.getElementById('conceptoCodigo').value = '';
        document.getElementById('conceptoDescripcion').value = '';
        document.getElementById('conceptoObservaciones').value = '';
        document.getElementById('conceptoCantidad').value = '1';
        document.getElementById('conceptoValorUnitario').value = '0';
        document.getElementById('conceptoDescuento').value = '0';
    }
    document.getElementById('modalConcepto').style.display = 'block';
}

function cerrarModalConcepto() {
    document.getElementById('modalConcepto').style.display = 'none';
}

function guardarConcepto() {
    const descripcion = document.getElementById('conceptoDescripcion').value.trim();
    const observaciones = document.getElementById('conceptoObservaciones').value.trim();
    const cantidad = parseFloat(document.getElementById('conceptoCantidad').value);
    const valorUnitario = parseFloat(document.getElementById('conceptoValorUnitario').value);
    const descuento = parseFloat(document.getElementById('conceptoDescuento').value) || 0;
    const codigo = document.getElementById('conceptoCodigo').value.trim();
    const productoSat = document.getElementById('conceptoProductoSat').value;
    const unidadSat = document.getElementById('conceptoUnidadSat').value;

    if (!descripcion) { showError('La descripción es obligatoria'); return; }
    if (isNaN(cantidad) || cantidad <= 0) { showError('La cantidad debe ser mayor a 0'); return; }
    if (isNaN(valorUnitario) || valorUnitario < 0) { showError('El valor unitario no puede ser negativo'); return; }
    if (descuento > (cantidad * valorUnitario)) { showError('El descuento no puede ser mayor al importe'); return; }

    const concepto = {
        codigo, descripcion, observaciones, cantidad, valorUnitario,
        descuento, importe: cantidad * valorUnitario, productoSat, unidadSat
    };

    if (editandoConceptoIndex >= 0) {
        conceptos[editandoConceptoIndex] = concepto;
        showSuccess('Concepto actualizado');
    } else {
        conceptos.push(concepto);
        showSuccess('Concepto agregado');
    }

    actualizarTablaConceptos();
    actualizarResumen();
    cerrarModalConcepto();
}

function actualizarTablaConceptos() {
    const tbody = document.getElementById('tablaConceptos');
    if (!tbody) return;

    if (conceptos.length === 0) {
        tbody.innerHTML = `<tr id="filaConceptoVacia"><td colspan="7" style="padding: 40px; text-align: center; color: #999;"><i class="fas fa-info-circle"></i> No hay conceptos agregados</td></tr>`;
        return;
    }

    let html = '';
    for (let i = 0; i < conceptos.length; i++) {
        const c = conceptos[i];
        html += `<tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">${c.codigo || '-'}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">${c.descripcion}${c.observaciones ? '<br><small style="color:#888;">' + c.observaciones + '</small>' : ''}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${c.cantidad.toFixed(2)}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${formatCurrency(c.valorUnitario)}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${formatCurrency(c.descuento || 0)}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;"><strong>${formatCurrency(c.importe - (c.descuento || 0))}</strong></td>
            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin-right: 15px; font-size: 16px;" onclick="abrirModalConcepto(${i})"></i>
                <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 16px;" onclick="eliminarConcepto(${i})"></i>
            </td>
        </tr>`;
    }
    tbody.innerHTML = html;
}

function eliminarConcepto(index) {
    Swal.fire({
        title: '¿Eliminar concepto?',
        text: `¿Deseas eliminar "${conceptos[index].descripcion}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(res => {
        if (res.isConfirmed) {
            conceptos.splice(index, 1);
            actualizarTablaConceptos();
            actualizarResumen();
            showSuccess('Concepto eliminado');
        }
    });
}

function actualizarResumen() {
    let subtotal = 0, descuentoTotal = 0;
    for (let i = 0; i < conceptos.length; i++) {
        subtotal += conceptos[i].importe;
        descuentoTotal += (conceptos[i].descuento || 0);
    }
    const base = subtotal - descuentoTotal;
    const iva = base * 0.16;
    const total = base + iva;

    document.getElementById('resumenSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('resumenDescuento').textContent = formatCurrency(descuentoTotal);
    document.getElementById('resumenIVA').textContent = formatCurrency(iva);
    document.getElementById('resumenTotal').textContent = formatCurrency(total);
}

// ============================================================
// GUARDAR NOTA
// ============================================================
function guardarNota() {
    const contacto_id = document.getElementById('contacto_id').value;
    const fecha = document.getElementById('fecha').value;

    if (!contacto_id) { showError('Seleccione un cliente'); return; }
    if (!fecha) { showError('Seleccione una fecha'); return; }
    if (conceptos.length === 0) { showError('Agregue al menos un concepto'); return; }

    showLoading(true);

    const data = {
        contacto_id: parseInt(contacto_id),
        proyecto_id: document.getElementById('proyecto_id').value || null,
        fecha: fecha,
        observaciones: document.getElementById('observaciones').value,
        conceptos: conceptos.map(c => ({
            codigo: c.codigo || null,
            descripcion: c.descripcion,
            observaciones: c.observaciones || null,
            cantidad: c.cantidad,
            valor_unitario: c.valorUnitario,
            descuento: c.descuento || 0,
            producto_sat: c.productoSat || '84111500',
            unidad_sat: c.unidadSat || 'ACT'
        }))
    };

    const notaId = document.getElementById('nota_id_edicion').value;
    const url = (modoEdicionNota && notaId) ? (apiBase() + `/api/notas-venta/${notaId}`) : (apiBase() + '/api/notas-venta');
    const method = (modoEdicionNota && notaId) ? 'PUT' : 'POST';

    fetchJSON(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.getElementById('csrf_token').value
        },
        body: JSON.stringify(data)
    })
    .then(resp => {
        showLoading(false);
        if (resp.success) {
            showSuccess(modoEdicionNota ? 'Nota actualizada' : 'Nota creada correctamente');
            cerrarModalNota();
            cargarDatos();
        } else {
            showError(resp.message || 'Error al guardar');
        }
    })
    .catch(err => {
        showLoading(false);
        console.error('Error guardarNota:', err);
        showError('Error al guardar: ' + err.message);
    });
}

// ============================================================
// EXPORTAR
// ============================================================
function exportToExcel() {
    if (datosFiltrados.length === 0) { showError('No hay datos para exportar'); return; }
    let csv = 'Folio,Fecha,Cliente,RFC,Subtotal,Descuento,IVA,Total,Facturada,Estatus\n';
    datosFiltrados.forEach(i => {
        csv += `${i.folio || '-'},${formatDate(i.fecha)},"${i.cliente_nombre || '-'}",${i.cliente_rfc || '-'},${i.subtotal || 0},${i.descuento || 0},${i.iva || 0},${i.total || 0},${i.facturada ? 'Sí' : 'No'},${getEstatusDisplay(i.estatus_texto || i.estatus)}\n`;
    });
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `notas_venta_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

// ============================================================
// FILTROS
// ============================================================
function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = (document.getElementById('buscador').value || '').toLowerCase().trim();

    let filtrados = [...datosNotas];
    if (fi) filtrados = filtrados.filter(f => (f.fecha || '') >= fi);
    if (ff) filtrados = filtrados.filter(f => (f.fecha || '') <= ff);
    if (busq) filtrados = filtrados.filter(f =>
        (f.cliente_nombre || '').toLowerCase().includes(busq) ||
        (f.cliente_rfc || '').toLowerCase().includes(busq) ||
        (f.folio || '').toLowerCase().includes(busq)
    );

    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

function limpiarFiltros() {
    document.getElementById('fechaInicio').value = '';
    document.getElementById('fechaFin').value = '';
    document.getElementById('buscador').value = '';
    datosFiltrados = [...datosNotas];
    currentPage = 1;
    cargarTabla();
}

// ============================================================
// INICIALIZACIÓN
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de Notas de Venta');

    const hoy = new Date();
    const hace30 = new Date();
    hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];

    cargarDatos();

    document.getElementById('btnAgregar').addEventListener('click', abrirModalNota);
    document.getElementById('btnExcel').addEventListener('click', exportToExcel);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);

    document.getElementById('fechaInicio').addEventListener('change', aplicarFiltros);
    document.getElementById('fechaFin').addEventListener('change', aplicarFiltros);
    document.getElementById('buscador').addEventListener('input', aplicarFiltros);

    document.getElementById('btnPrimeraPagina').addEventListener('click', () => { currentPage = 1; cargarTabla(); });
    document.getElementById('btnAnteriorPagina').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTabla(); } });
    document.getElementById('btnSiguientePagina').addEventListener('click', () => { const max = Math.ceil(datosFiltrados.length / rowsPerPage); if (currentPage < max) { currentPage++; cargarTabla(); } });
    document.getElementById('btnUltimaPagina').addEventListener('click', () => { currentPage = Math.ceil(datosFiltrados.length / rowsPerPage); cargarTabla(); });

    // Modal nueva nota
    document.getElementById('cerrarModalNota').addEventListener('click', cerrarModalNota);
    document.getElementById('btnCancelarNota').addEventListener('click', cerrarModalNota);
    document.getElementById('btnGuardarNota').addEventListener('click', guardarNota);
    document.getElementById('btnAgregarConcepto').addEventListener('click', () => abrirModalConcepto());

    // Modal concepto
    document.getElementById('btnGuardarConcepto').addEventListener('click', guardarConcepto);
    document.getElementById('btnCancelarConcepto').addEventListener('click', cerrarModalConcepto);

    // Cierre click fuera
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalNota')) cerrarModalNota();
        if (e.target === document.getElementById('modalConcepto')) cerrarModalConcepto();
    });
});
</script>

@endsection