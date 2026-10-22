@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice"></i> Facturación
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                <i class="fas fa-file-invoice"></i> Facturas
                            </div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalFacturas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                <i class="fas fa-check-circle"></i> Activas
                            </div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalActivas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                <i class="fas fa-money-bill-wave"></i> Pagadas
                            </div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalPagadas">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #dc3545; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">
                                <i class="fas fa-ban"></i> Canceladas
                            </div>
                            <div style="color: #dc3545; font-size: 36px; font-weight: bold;" id="totalCanceladas">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;"></div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div><input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"></div>
                        <div><input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;"></div>
                        <div>
                            <button id="btnAgregar" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnCatalogoSeries" style="background-color: #17a2b8; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-list"></i> Series
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div>
                            <button id="btnLimpiarFiltros" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-eraser"></i> Limpiar filtros
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
                        </div>
                    </div>
                </div>

                <div id="loadingIndicator" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p>Cargando datos...</p>
                </div>

                <div id="sinDatosMensaje" style="text-align: center; padding: 60px; background: #f8f9fa; border-radius: 8px; display: none;">
                    <i class="fas fa-file-invoice" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay facturas</h3>
                </div>

                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFacturacion" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th data-sort="estatus_texto" style="padding: 10px 6px; text-align: center; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                        <span>Estatus</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="fecha" style="padding: 10px 6px; text-align: center; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                        <span>Fecha</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="serie" style="padding: 10px 6px; text-align: center; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                        <span>Serie</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="folio" style="padding: 10px 6px; text-align: center; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                        <span>Folio</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="cliente_nombre" style="padding: 10px 6px; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;gap:4px;">
                                        <span>Cliente</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="cliente_rfc" style="padding: 10px 6px; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;gap:4px;">
                                        <span>RFC</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="moneda" style="padding: 10px 6px; text-align: center; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                        <span>Moneda</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="subtotal" style="padding: 10px 6px; text-align: right; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                                        <span>Subtotal</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="iva" style="padding: 10px 6px; text-align: right; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                                        <span>IVA</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="total" style="padding: 10px 6px; text-align: right; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                                        <span>Total</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th data-sort="total_mxn" style="padding: 10px 6px; text-align: right; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;">
                                        <span>Total MXN</span>
                                        <span class="sort-indicator" style="font-size:10px;opacity:0.7;">⇅</span>
                                    </div>
                                </th>
                                <th style="padding: 10px 6px; cursor: pointer; user-select: none;">
                                    <div style="display:flex;align-items:center;gap:4px;"><span>UUID</span></div>
                                </th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 10px; text-align: right;"><strong>TOTALES:</strong></td>
                                <td style="padding: 10px; text-align: right;" id="sumSubtotal">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumIva">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumTotal">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumTotalMXN">$0.00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #083CAE; cursor: pointer;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button id="btnPrimeraPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnteriorPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <span style="padding: 5px 12px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaActual">1</span>
                        <span id="paginacionInfo" style="color: #666; font-size: 12px;">Mostrando 0-0 de 0 registros</span>
                        <button id="btnSiguientePagina" style="border: none; background: none; color: #083CAE; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltimaPagina" style="border: none; background: none; color: #083CAE; cursor: pointer;"><i class="fas fa-angle-double-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA FACTURA -->
<div id="modalNuevaFactura" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 1300px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;" id="tituloModalFactura">Nueva Factura</span>
            </div>
            <button id="cerrarModal" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>

        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <form id="formNuevaFactura">
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                <input type="hidden" id="factura_id_edicion" value="">

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto</label>
                        <select id="proyecto_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar proyecto...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente *</label>
                        <select id="contacto_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar cliente...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Serie *</label>
                        <select id="cat_serie_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar serie...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Folio</label>
                        <input type="text" id="folio" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #f5f5f5;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha *</label>
                        <input type="date" id="fecha" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Vencimiento</label>
                        <input type="date" id="fecha_vencimiento" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Moneda *</label>
                        <select id="moneda" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="MXN">MXN - Peso Mexicano</option>
                            <option value="USD">USD - Dólar Americano</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Cambio</label>
                        <input type="number" id="tipo_cambio" step="0.0001" value="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Comprobante *</label>
                        <select id="tipo_comprobante" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="I">I - Ingreso</option>
                            <option value="E">E - Egreso (Nota de Crédito)</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Uso CFDI *</label>
                        <select id="uso_cfdi" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar uso...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Forma de Pago *</label>
                        <select id="forma_pago" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar forma...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Método de Pago *</label>
                        <select id="metodo_pago" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar método...</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nota de Venta (opcional)</label>
                        <select id="nota_venta_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Sin nota de venta</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">
                            Re-factura de (opcional)
                            <span title="Solo se puede re-facturar una factura cancelada sin re-factura previa" style="cursor:help;color:#17a2b8;">&#9432;</span>
                        </label>
                        <select id="factura_origen_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Ninguna</option>
                        </select>
                    </div>
                    <div style="grid-column: span 3;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                        <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                    </div>
                </div>

                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 15px 0; color: #083CAE;">Retenciones</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Retención IVA</label>
                            <input type="number" id="retencion_iva" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Retención ISR</label>
                            <input type="number" id="retencion_isr" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Retención Garantía</label>
                            <input type="number" id="retencion_garantia" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                    </div>
                </div>

                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3 style="margin: 0; color: #083CAE;">Conceptos / Partidas</h3>
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="btnCargarEstimaciones" style="background-color: #083CAE; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer;">
                                <i class="fas fa-list-check"></i> Cargar Estimaciones Pendientes
                            </button>
                            <button type="button" id="btnAgregarConcepto" style="background-color: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer;">
                                <i class="fas fa-plus"></i> Agregar Concepto
                            </button>
                        </div>
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
                            <div style="text-align: right;">
                                <div style="color: #666; font-size: 14px;">Retenciones:</div>
                                <div style="font-size: 22px; font-weight: bold; color: #dc3545;" id="resumenRetenciones">$0.00</div>
                            </div>
                            <div style="text-align: right; padding-left: 30px; border-left: 2px solid #ccc;">
                                <div style="color: #666; font-size: 14px;">Total:</div>
                                <div style="font-size: 28px; font-weight: bold; color: #083CAE;" id="resumenTotal">$0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button id="btnCancelar" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarFactura" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar
            </button>
            <button id="btnTimbrar" style="background-color: #ffc107; color: #333; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-stamp"></i> Guardar y Timbrar
            </button>
        </div>
    </div>
</div>

<!-- MODAL CONCEPTO -->
<div id="modalConcepto" style="display: none; position: fixed; z-index: 10002; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 6% auto; width: 90%; max-width: 650px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 id="modalConceptoTitulo" style="margin: 0;">Agregar Concepto</h3>
        </div>
        <div style="padding: 25px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código / Clave Prod:</label>
                    <input type="text" id="conceptoCodigo" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Clave Producto/Servicio SAT:</label>
                    <select id="conceptoProductoSat" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="84111500">84111500 - Servicios de contabilidad</option>
                    </select>
                </div>
                <div style="grid-column: span 2; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción *:</label>
                    <textarea id="conceptoDescripcion" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                </div>
                <div style="grid-column: span 2; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones por concepto:</label>
                    <textarea id="conceptoObservaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cantidad *:</label>
                    <input type="number" id="conceptoCantidad" step="0.01" value="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Unidad de Medida SAT:</label>
                    <select id="conceptoUnidadSat" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="ACT">ACT - Actividad</option>
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

<!-- MODAL ESTIMACIONES -->
<div id="modalEstimacionesPendientes" style="display: none; position: fixed; z-index: 10003; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.75); overflow-y: auto;">
    <div style="background-color: white; margin: 3% auto; width: 95%; max-width: 1100px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-list-check" style="font-size: 22px; margin-right: 10px;"></i>
                <span style="font-size: 18px; font-weight: bold;">Estimaciones Pendientes de Facturar</span>
                <div id="modalEstimacionesProyecto" style="font-size: 13px; opacity: 0.9; margin-top: 4px;"></div>
            </div>
            <button id="cerrarModalEstimaciones" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px 25px; max-height: 65vh; overflow-y: auto;">
            <div id="loadingEstimaciones" style="display: none; text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 40px; color: #083CAE;"></i>
                <p style="margin-top: 15px; color: #666;">Cargando estimaciones...</p>
            </div>
            <div id="sinEstimaciones" style="display: none; text-align: center; padding: 50px;">
                <i class="fas fa-check-circle" style="font-size: 56px; color: #28a745;"></i>
                <h3 style="color: #666; margin-top: 15px;">Sin pendientes</h3>
                <p style="color: #999;">Todas las estimaciones de este proyecto ya están facturadas</p>
            </div>
            <div id="listaPartidasEstimaciones"></div>
        </div>
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div style="font-size: 16px;">
                <span style="color: #666;">Total seleccionado:</span>
                <strong id="totalSeleccionadoEstimaciones" style="color: #083CAE; font-size: 22px; margin-left: 8px;">$0.00</strong>
            </div>
            <div style="display: flex; gap: 12px;">
                <button id="btnCancelarEstimaciones" type="button" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button id="btnAgregarEstimacionesSeleccionadas" type="button" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-plus-circle"></i> Agregar Conceptos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CATÁLOGO DE SERIES -->
<div id="modalSeries" style="display: none; position: fixed; z-index: 10004; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.75); overflow-y: auto;">
    <div style="background-color: white; margin: 5% auto; width: 90%; max-width: 900px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-list" style="font-size: 22px; margin-right: 10px;"></i>
                <span style="font-size: 18px; font-weight: bold;">Catálogo de Series</span>
            </div>
            <button id="cerrarModalSeries" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px 25px;">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                <button id="btnNuevaSerie" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-plus"></i> Nueva Serie
                </button>
            </div>
            <div style="border: 1px solid #ddd; border-radius: 8px; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead style="background-color: #083CAE; color: white;">
                        <tr>
                            <th style="padding: 12px; text-align: left;">Serie</th>
                            <th style="padding: 12px; text-align: left;">Descripción</th>
                            <th style="padding: 12px; text-align: center;">Tipo</th>
                            <th style="padding: 12px; text-align: right;">Folio Actual</th>
                            <th style="padding: 12px; text-align: right;">Folio Final</th>
                            <th style="padding: 12px; text-align: center;">Activo</th>
                            <th style="padding: 12px; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaSeriesBody">
                        <tr><td colspan="7" style="padding: 30px; text-align: center; color: #999;">Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FORM SERIE -->
<div id="modalFormSerie" style="display: none; position: fixed; z-index: 10005; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8);">
    <div style="background-color: white; margin: 10% auto; width: 90%; max-width: 500px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 id="modalSerieTitulo" style="margin: 0;">Nueva Serie</h3>
        </div>
        <div style="padding: 25px;">
            <input type="hidden" id="serie_id_edicion" value="">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Serie *:</label>
                <input type="text" id="serie_input" maxlength="10" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción *:</label>
                <input type="text" id="serie_descripcion" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo Comprobante *:</label>
                <select id="serie_tipo" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="I">I - Ingreso</option>
                    <option value="E">E - Egreso</option>
                    <option value="T">T - Traslado</option>
                    <option value="P">P - Pago</option>
                </select>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Folio Actual:</label>
                    <input type="number" id="serie_folio_actual" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Folio Final:</label>
                    <input type="number" id="serie_folio_final" value="999999" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelarFormSerie" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button type="button" id="btnGuardarSerie" style="background-color: #083CAE; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Guardar</button>
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
    .badge-timbrada  { background-color: #d4edda; color: #155724; }
    .badge-pagada    { background-color: #fff3cd; color: #856404; }
    .badge-cancelada { background-color: #f8d7da; color: #721c24; }
    .badge-pendiente { background-color: #d1ecf1; color: #0c5460; }
    .badge-timbrando { background-color: #e2d9f3; color: #4b2e83; }
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    thead th.sortable-asc .sort-indicator { color: #ffc107; opacity: 1; }
    thead th.sortable-desc .sort-indicator { color: #ffc107; opacity: 1; }
    thead th.sortable-asc .sort-indicator::before { content: "▲"; }
    thead th.sortable-desc .sort-indicator::before { content: "▼"; }
    .factura-detalle-wrap { text-align: left; font-family: 'Segoe UI', Tahoma, sans-serif; color: #333; }
    .factura-detalle-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; padding: 20px 22px; background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); border-radius: 12px; color: white; margin-bottom: 20px; }
    .factura-detalle-header .folio { font-size: 24px; font-weight: bold; letter-spacing: 0.5px; line-height: 1.2; }
    .factura-detalle-header .folio small { display: block; font-size: 12px; font-weight: 400; opacity: 0.85; margin-top: 2px; }
    .factura-detalle-header .estatus-badge { padding: 6px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); }
    .factura-detalle-info { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .factura-detalle-card { background: #f8f9fa; border-left: 4px solid #083CAE; border-radius: 8px; padding: 14px 18px; }
    .factura-detalle-card h4 { margin: 0 0 10px 0; color: #083CAE; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
    .factura-detalle-card p { margin: 4px 0; font-size: 13px; color: #333; display: flex; justify-content: space-between; gap: 10px; }
    .factura-detalle-card p strong { color: #555; font-weight: 600; }
    .factura-detalle-card p span { text-align: right; color: #000; font-weight: 600; }
    .factura-detalle-conceptos-title { color: #083CAE; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin: 20px 0 10px 0; padding-bottom: 6px; border-bottom: 2px solid #e3e8f0; }
    .factura-detalle-tabla { width: 100%; border-collapse: collapse; font-size: 12px; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .factura-detalle-tabla thead { background: #083CAE; color: white; }
    .factura-detalle-tabla thead th { padding: 10px 8px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; }
    .factura-detalle-tabla tbody td { padding: 10px 8px; border-bottom: 1px solid #eef0f4; vertical-align: top; }
    .factura-detalle-tabla tbody tr:nth-child(even) { background: #f9fafc; }
    .factura-detalle-tabla tbody tr:hover { background: #eaf1fb; }
    .factura-detalle-tabla .text-right { text-align: right; }
    .factura-detalle-tabla .obs-concepto { display: block; color: #777; font-size: 11px; margin-top: 4px; font-style: italic; }
    .factura-detalle-totales { margin-top: 18px; background: #f8f9fa; border-radius: 10px; padding: 16px 20px; display: flex; flex-direction: column; gap: 6px; }
    .factura-detalle-totales .row { display: flex; justify-content: space-between; font-size: 13px; padding: 4px 0; color: #555; }
    .factura-detalle-totales .row.detalle-extra { color: #dc3545; }
    .factura-detalle-totales .row.total-final { border-top: 2px solid #083CAE; margin-top: 6px; padding-top: 10px; font-size: 18px; font-weight: bold; color: #083CAE; }
    .factura-detalle-totales .row.total-final span { font-size: 22px; }
    .factura-detalle-uuid { background: #eef4fb; border-left: 4px solid #17a2b8; border-radius: 8px; padding: 12px 16px; margin-top: 18px; font-size: 12px; }
    .factura-detalle-uuid strong { color: #0c5460; display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
    .factura-detalle-uuid code { color: #083CAE; font-family: 'Courier New', monospace; word-break: break-all; font-size: 12px; }
    .factura-detalle-obs { background: #fff9e6; border-left: 4px solid #ffc107; border-radius: 8px; padding: 12px 16px; margin-top: 16px; font-size: 12px; }
    .factura-detalle-obs strong { color: #856404; display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
    .factura-detalle-obs p { margin: 0; color: #555; white-space: pre-wrap; }
    .factura-detalle-refactura { background: #e7f3ff; border-left: 4px solid #17a2b8; border-radius: 8px; padding: 12px 16px; margin-top: 16px; font-size: 12px; }
    .factura-detalle-refactura strong { color: #0c5460; display: block; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
    .factura-detalle-refactura p { margin: 0; color: #555; }
    .factura-detalle-actions { display: flex; gap: 10px; margin-top: 18px; justify-content: flex-end; }
    .factura-detalle-actions button { border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 12px; }
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(3, 1fr)"] { grid-template-columns: 1fr !important; }
        div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        .factura-detalle-info { grid-template-columns: 1fr; }
        .factura-detalle-header { flex-direction: column; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let datosFacturacion = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;
let conceptos = [];
let editandoConceptoIndex = -1;
let modoEdicionFactura = false;
let sortState = { field: null, direction: null };
let columnFilters = {};

function apiBase() { return ''; }

// ============================================
// UTILIDADES
// ============================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) amount = 0;
    return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function formatDate(dateString) {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        return date.toLocaleDateString('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric' });
    } catch(e) { return dateString; }
}

function normalizarEstatus(estatus) {
    if (estatus === null || estatus === undefined) return 'pendiente';
    const porNumero = { 1: 'pendiente', 10: 'timbrando', 19: 'timbrada', 21: 'cancelada' };
    if (typeof estatus === 'number' || (!isNaN(parseInt(estatus)) && String(estatus).trim() !== '')) {
        const num = parseInt(estatus);
        if (porNumero[num]) return porNumero[num];
    }
    const s = String(estatus).toLowerCase().trim();
    return s || 'pendiente';
}

function getBadgeClass(estatus) {
    const map = { 'timbrada': 'badge-timbrada', 'pagada': 'badge-pagada', 'cancelada': 'badge-cancelada', 'timbrando': 'badge-timbrando', 'pendiente': 'badge-pendiente' };
    return map[normalizarEstatus(estatus)] || 'badge-pendiente';
}

function getEstatusDisplay(estatus) {
    const map = { 'timbrada': 'Timbrada', 'pagada': 'Pagada', 'cancelada': 'Cancelada', 'timbrando': 'Timbrando', 'pendiente': 'Pendiente' };
    return map[normalizarEstatus(estatus)] || 'Pendiente';
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

// ============================================
// CARGA DE DATOS
// ============================================
function cargarDatos(filtros = {}) {
    showLoading(true);
    const params = new URLSearchParams();
    if (filtros.fecha_inicio) params.append('fecha_inicio', filtros.fecha_inicio);
    if (filtros.fecha_fin)    params.append('fecha_fin', filtros.fecha_fin);
    if (filtros.search)       params.append('search', filtros.search);

    fetchJSON(apiBase() + '/facturacion/data?' + params.toString())
        .then(response => {
            if (response.success && response.data) {
                datosFacturacion = response.data;
                datosFiltrados = [...datosFacturacion];
                actualizarContadores(response.stats);
            } else {
                datosFacturacion = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, activas: 0, pagadas: 0, canceladas: 0 });
            }
            aplicarFiltrosColumnas();
            showLoading(false);
        })
        .catch(error => {
            console.error('Error cargarDatos:', error);
            datosFacturacion = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, activas: 0, pagadas: 0, canceladas: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalFacturas').textContent   = stats.total      || 0;
    document.getElementById('totalActivas').textContent     = stats.activas    || 0;
    document.getElementById('totalPagadas').textContent     = stats.pagadas    || 0;
    document.getElementById('totalCanceladas').textContent  = stats.canceladas || 0;
}

function calcularTotales(datos) {
    let subtotal = 0, iva = 0, total = 0, totalMXN = 0;
    datos.forEach(item => {
        subtotal += parseFloat(item.subtotal || 0);
        iva      += parseFloat(item.iva || 0);
        total    += parseFloat(item.total || 0);
        totalMXN += parseFloat(item.total_mxn || item.total || 0);
    });
    document.getElementById('sumSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('sumIva').textContent      = formatCurrency(iva);
    document.getElementById('sumTotal').textContent    = formatCurrency(total);
    document.getElementById('sumTotalMXN').textContent = formatCurrency(totalMXN);
}

// ============================================
// FILTROS
// ============================================
function aplicarFiltrosColumnas() {
    let base = [...datosFacturacion];
    for (const campo in columnFilters) {
        const valor = columnFilters[campo];
        if (!valor) continue;
        const valorLower = String(valor).toLowerCase();
        base = base.filter(row => {
            let cellVal = row[campo];
            if (campo === 'estatus_texto') cellVal = row.estatus_texto || normalizarEstatus(row.estatus);
            else if (campo === 'moneda') cellVal = row.cat_monedas_clave || row.moneda || '';
            else if (campo === 'total_mxn') cellVal = row.total_mxn || row.total || 0;
            if (cellVal === null || cellVal === undefined) return false;
            return String(cellVal).toLowerCase().includes(valorLower);
        });
    }
    if (sortState.field) {
        const dir = sortState.direction === 'desc' ? -1 : 1;
        const field = sortState.field;
        base.sort((a, b) => {
            let va = a[field], vb = b[field];
            if (field === 'estatus_texto') {
                const order = { 'pendiente': 0, 'timbrando': 1, 'timbrada': 2, 'cancelada': 3, 'pagada': 4 };
                va = order[a.estatus_texto || normalizarEstatus(a.estatus)] ?? 99;
                vb = order[b.estatus_texto || normalizarEstatus(b.estatus)] ?? 99;
            } else if (field === 'moneda') {
                va = a.cat_monedas_clave || a.moneda || '';
                vb = b.cat_monedas_clave || b.moneda || '';
            } else if (field === 'total_mxn') {
                va = parseFloat(a.total_mxn || a.total || 0);
                vb = parseFloat(b.total_mxn || b.total || 0);
            } else if (['subtotal', 'iva', 'total'].includes(field)) {
                va = parseFloat(a[field] || 0); vb = parseFloat(b[field] || 0);
            } else if (field === 'fecha' || field === 'fecha_vencimiento') {
                va = a[field] ? new Date(a[field]).getTime() : 0;
                vb = b[field] ? new Date(b[field]).getTime() : 0;
            } else {
                va = String(va || '').toLowerCase(); vb = String(vb || '').toLowerCase();
            }
            if (va < vb) return -1 * dir;
            if (va > vb) return 1 * dir;
            return 0;
        });
    }
    datosFiltrados = base;
    currentPage = 1;
    cargarTabla();
    actualizarIndicadoresSort();
}

function actualizarIndicadoresSort() {
    document.querySelectorAll('thead th[data-sort]').forEach(th => {
        th.classList.remove('sortable-asc', 'sortable-desc');
        if (th.dataset.sort === sortState.field) {
            th.classList.add(sortState.direction === 'asc' ? 'sortable-asc' : 'sortable-desc');
        }
    });
}

function inicializarFiltrosEncabezados() {
    document.querySelectorAll('thead th[data-sort]').forEach(th => {
        th.addEventListener('click', (e) => {
            if (e.target.classList.contains('th-filter')) return;
            const field = th.dataset.sort;
            if (sortState.field === field) {
                if (sortState.direction === 'asc') sortState.direction = 'desc';
                else if (sortState.direction === 'desc') { sortState.field = null; sortState.direction = null; }
            } else {
                sortState.field = field;
                sortState.direction = 'asc';
            }
            aplicarFiltrosColumnas();
        });
    });
}

function limpiarFiltros() {
    columnFilters = {};
    sortState = { field: null, direction: null };
    document.querySelectorAll('.th-filter').forEach(el => el.value = '');
    document.getElementById('buscador').value = '';
    datosFiltrados = [...datosFacturacion];
    currentPage = 1;
    cargarTabla();
    actualizarIndicadoresSort();
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
        const estatusNum = parseInt(item.estatus);

        // Botones según estatus
        const btnTimbrar = (estatusNum === 1 || estatusNum === 10)
            ? `<i class="fas fa-stamp" style="color: #28a745; cursor: pointer;" title="Timbrar" data-id="${item.factura_id}"></i>` : '';
        const btnCancelar = (estatusNum === 19)
            ? `<i class="fas fa-ban" style="color: #dc3545; cursor: pointer;" title="Cancelar" data-id="${item.factura_id}"></i>` : '';
        const btnEditar = (estatusNum !== 19 && estatusNum !== 21)
            ? `<i class="fas fa-edit" style="color: #ffc107; cursor: pointer;" title="Editar" data-id="${item.factura_id}"></i>` : '';

        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${getBadgeClass(estatusTexto)}">${getEstatusDisplay(estatusTexto)}</span></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 6px;">${item.serie || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px;">${item.cliente_nombre || '-'}</td>
            <td style="padding: 10px 6px;">${item.cliente_rfc || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;">${item.moneda || 'MXN'}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.subtotal)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.iva)}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.total)}</strong></td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.total_mxn || item.total)}</td>
            <td style="padding: 10px 6px; font-size: 10px;">${item.uuid ? item.uuid.substring(0, 16) + '...' : '-'}</td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.factura_id}"></i>
                    ${btnEditar}
                    ${btnTimbrar}
                    ${btnCancelar}
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-code" style="color: #17a2b8; cursor: pointer;" title="XML" data-id="${item.factura_id}"></i>
                </div>
            </td>
        `;
    });

    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);

    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verFactura(el.dataset.id)));
    document.querySelectorAll('.fa-edit').forEach(el => el.addEventListener('click', () => editarFactura(el.dataset.id)));
    document.querySelectorAll('.fa-stamp').forEach(el => el.addEventListener('click', () => timbrarFacturaDesdeTabla(el.dataset.id)));
    document.querySelectorAll('.fa-ban').forEach(el => el.addEventListener('click', () => cancelarFactura(el.dataset.id)));
    document.querySelectorAll('.fa-file-pdf').forEach(el => el.addEventListener('click', () => window.open(apiBase() + `/facturacion/${el.dataset.id}/pdf`, '_blank')));
    document.querySelectorAll('.fa-file-code').forEach(el => el.addEventListener('click', () => window.open(apiBase() + `/facturacion/${el.dataset.id}/xml`, '_blank')));
}

function actualizarPaginacion(total) {
    const start = total === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${start}-${end} de ${total} registros`;
}

// ============================================
// VER DETALLE
// ============================================
function verFactura(id) {
    fetchJSON(apiBase() + `/facturacion/${id}`)
        .then(data => {
            if (!data.success) { showError(data.message || 'No se pudo cargar la factura'); return; }
            const f = data.data;
            const estatusTexto = f.estatus_texto || normalizarEstatus(f.estatus);
            const estatusNum = parseInt(f.estatus);

            let conceptosHtml = '';
            if (data.conceptos && data.conceptos.length > 0) {
                conceptosHtml = `<table class="factura-detalle-tabla"><thead><tr>
                    <th style="width:45%">Descripción</th>
                    <th class="text-right" style="width:10%">Cant.</th>
                    <th class="text-right" style="width:15%">V. Unit.</th>
                    <th class="text-right" style="width:15%">Desc.</th>
                    <th class="text-right" style="width:15%">Importe</th>
                </tr></thead><tbody>`;
                data.conceptos.forEach(c => {
                    const obs = c.observaciones ? `<span class="obs-concepto">${c.observaciones}</span>` : '';
                    conceptosHtml += `<tr>
                        <td>${c.descripcion || '-'}${obs}</td>
                        <td class="text-right">${parseFloat(c.cantidad || 0).toFixed(2)}</td>
                        <td class="text-right">${formatCurrency(c.valor_unitario)}</td>
                        <td class="text-right">${formatCurrency(c.descuento)}</td>
                        <td class="text-right"><strong>${formatCurrency((c.importe || 0) - (c.descuento || 0))}</strong></td>
                    </tr>`;
                });
                conceptosHtml += `</tbody></table>`;
            } else {
                conceptosHtml = `<div style="padding:20px;text-align:center;color:#999;background:#f8f9fa;border-radius:8px;">Sin conceptos registrados</div>`;
            }

            let descuentoRow = '';
            if (parseFloat(f.descuento || 0) > 0) descuentoRow = `<div class="row detalle-extra"><span>Descuento:</span><span>-${formatCurrency(f.descuento)}</span></div>`;
            let retencionesRows = '';
            if (parseFloat(f.retencion_iva || 0) > 0)      retencionesRows += `<div class="row detalle-extra"><span>Retención IVA:</span><span>-${formatCurrency(f.retencion_iva)}</span></div>`;
            if (parseFloat(f.retencion_isr || 0) > 0)      retencionesRows += `<div class="row detalle-extra"><span>Retención ISR:</span><span>-${formatCurrency(f.retencion_isr)}</span></div>`;
            if (parseFloat(f.retencion_garantia || 0) > 0) retencionesRows += `<div class="row detalle-extra"><span>Retención Garantía:</span><span>-${formatCurrency(f.retencion_garantia)}</span></div>`;

            const uuidHtml = f.uuid ? `<div class="factura-detalle-uuid"><strong>UUID / Timbre Fiscal Digital</strong><code>${f.uuid}</code></div>` : '';
            const obsHtml = f.observaciones ? `<div class="factura-detalle-obs"><strong>Observaciones</strong><p>${f.observaciones}</p></div>` : '';

            let refacturaHtml = '';
            if (f.factura_origen_id) {
                refacturaHtml = `<div class="factura-detalle-refactura">
                    <strong><i class="fas fa-sync-alt"></i> Re-factura</strong>
                    <p>Esta factura sustituye a la factura original <b>#${f.factura_origen_id}</b>.</p>
                </div>`;
            }

            let extraHtml = '';
            if (f.nota_venta_folio || f.nota_venta_id) extraHtml += `<p><strong>Nota de Venta:</strong> <span>${f.nota_venta_folio || f.nota_venta_id}</span></p>`;

            // Botones de acción en el detalle
            let botonesHtml = '';
            if (estatusNum === 19) {
                botonesHtml = `<div class="factura-detalle-actions">
                    <button onclick="cancelarFactura(${f.factura_id})" style="background-color:#dc3545;color:white;">
                        <i class="fas fa-ban"></i> Cancelar factura
                    </button>
                </div>`;
            } else if (estatusNum === 1 || estatusNum === 10) {
                botonesHtml = `<div class="factura-detalle-actions">
                    <button onclick="timbrarFacturaDesdeTabla(${f.factura_id})" style="background-color:#28a745;color:white;">
                        <i class="fas fa-stamp"></i> Timbrar factura
                    </button>
                </div>`;
            }

            const html = `<div class="factura-detalle-wrap">
                <div class="factura-detalle-header">
                    <div><div class="folio">${f.serie || ''}-${f.folio || ''}<small>Comprobante tipo ${f.tipo_comprobante === 'E' ? 'Egreso (NC)' : 'Ingreso'}</small></div></div>
                    <div style="text-align:right;">
                        <div class="estatus-badge">${getEstatusDisplay(estatusTexto)}</div>
                        <div style="font-size:12px;margin-top:8px;opacity:0.9;">Fecha: ${formatDate(f.fecha)}</div>
                    </div>
                </div>
                <div class="factura-detalle-info">
                    <div class="factura-detalle-card">
                        <h4><i class="fas fa-user"></i> Cliente</h4>
                        <p><strong>Razón Social:</strong> <span>${f.cliente_nombre || '-'}</span></p>
                        <p><strong>RFC:</strong> <span>${f.cliente_rfc || '-'}</span></p>
                        <p><strong>Uso CFDI:</strong> <span>${f.satcat_uso_cfdi_clave || 'G01'}</span></p>
                    </div>
                    <div class="factura-detalle-card">
                        <h4><i class="fas fa-file-invoice-dollar"></i> Datos de Factura</h4>
                        <p><strong>Método de Pago:</strong> <span>${f.satcat_metodos_pago_clave || 'PUE'}</span></p>
                        <p><strong>Forma de Pago:</strong> <span>${f.satcat_formas_pago_clave || '01'}</span></p>
                        <p><strong>Moneda:</strong> <span>${f.cat_monedas_clave || 'MXN'}${(f.tipo_cambio && f.tipo_cambio != 1) ? ' (TC ' + f.tipo_cambio + ')' : ''}</span></p>
                        ${f.fecha_vencimiento ? `<p><strong>Vencimiento:</strong> <span>${formatDate(f.fecha_vencimiento)}</span></p>` : ''}
                        ${extraHtml}
                    </div>
                </div>
                <div class="factura-detalle-conceptos-title"><i class="fas fa-list"></i> Conceptos</div>
                ${conceptosHtml}
                <div class="factura-detalle-totales">
                    <div class="row"><span>Subtotal:</span><span>${formatCurrency(f.subtotal)}</span></div>
                    ${descuentoRow}
                    <div class="row"><span>IVA (16%):</span><span>${formatCurrency(f.iva)}</span></div>
                    ${retencionesRows}
                    <div class="row total-final"><span>Total:</span><span>${formatCurrency(f.total)}</span></div>
                </div>
                ${refacturaHtml}
                ${uuidHtml}
                ${obsHtml}
                ${botonesHtml}
            </div>`;

            Swal.fire({
                title: false, html: html, width: '900px', showCloseButton: true, showConfirmButton: false, padding: '1.2em',
                didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
            });
        })
        .catch(error => {
            console.error('Error verFactura:', error);
            showError('Error al cargar la factura: ' + error.message);
        });
}

// ============================================
// TIMBRAR
// ============================================
function timbrarFacturaDesdeTabla(id) {
    Swal.fire({
        title: '¿Timbrar factura?',
        html: 'Se enviará al PAC para generar el CFDI con timbre fiscal digital.<br><br><b>Esto consume un timbre.</b>',
        icon: 'question', showCancelButton: true, confirmButtonColor: '#28a745', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, timbrar', cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(result => {
        if (!result.isConfirmed) return;
        showLoading(true);
        fetchJSON(apiBase() + `/facturacion/${id}/timbrar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.getElementById('csrf_token').value }
        })
        .then(data => {
            showLoading(false);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Factura timbrada',
                    html: `UUID: <code>${data.uuid}</code>`,
                    confirmButtonColor: '#083CAE',
                    didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
                });
                cargarDatos(getFiltrosActuales());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de timbrado',
                    html: `<div style="text-align:left;font-size:13px;">${data.message}</div>`,
                    confirmButtonColor: '#083CAE',
                    didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
                });
            }
        })
        .catch(err => { showLoading(false); console.error(err); showError('Error al timbrar: ' + err.message); });
    });
}

// ============================================
// CANCELAR
// ============================================
function cancelarFactura(id) {
    Swal.fire({
        title: '¿Cancelar factura?',
        html: `
            <p style="text-align:left;">Esta acción cancelará el CFDI ante el SAT.<br><b>Es irreversible.</b></p>
            <p style="text-align:left;margin-top:12px;font-weight:600;">Motivo SAT:</p>
            <select id="swal-motivo-sat" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;">
                <option value="02" selected>02 - Comprobante con errores sin relación</option>
                <option value="01">01 - Comprobante con errores con relación</option>
                <option value="03">03 - No se llevó a cabo la operación</option>
                <option value="04">04 - Operación nominativa relacionada en factura global</option>
            </select>
            <div id="swal-folio-sust-wrap" style="display:none;margin-top:12px;">
                <p style="text-align:left;font-weight:600;">Folio de sustitución (UUID):</p>
                <input id="swal-folio-sust" type="text" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;" placeholder="UUID de la factura que sustituye">
            </div>
            <p style="text-align:left;margin-top:12px;font-weight:600;">Motivo (texto libre):</p>
            <textarea id="swal-motivo" rows="2" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;" placeholder="Describe el motivo..."></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No',
        didOpen: () => {
            Swal.getContainer().style.zIndex = '40000';
            const sel = document.getElementById('swal-motivo-sat');
            const wrap = document.getElementById('swal-folio-sust-wrap');
            sel.addEventListener('change', () => {
                wrap.style.display = sel.value === '01' ? 'block' : 'none';
            });
        },
        preConfirm: () => {
            const motivoSat = document.getElementById('swal-motivo-sat').value;
            const motivo = document.getElementById('swal-motivo').value.trim();
            const folioSust = document.getElementById('swal-folio-sust')?.value.trim() || null;

            if (!motivo) {
                Swal.showValidationMessage('Debes indicar el motivo de cancelación');
                return false;
            }
            if (motivoSat === '01' && !folioSust) {
                Swal.showValidationMessage('Motivo 01 requiere folio de sustitución');
                return false;
            }
            return { motivo, motivo_sat: motivoSat, folio_sustitucion: folioSust };
        }
    }).then(result => {
        if (!result.isConfirmed) return;
        showLoading(true);
        fetchJSON(apiBase() + `/facturacion/${id}/cancelar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.getElementById('csrf_token').value },
            body: JSON.stringify(result.value)
        })
        .then(data => {
            showLoading(false);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Factura cancelada',
                    html: `Código SAT: <b>${data.codigo}</b>`,
                    confirmButtonColor: '#083CAE',
                    didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
                });
                cargarDatos(getFiltrosActuales());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cancelar',
                    html: `<div style="text-align:left;font-size:13px;">${data.message}</div>`,
                    confirmButtonColor: '#083CAE',
                    didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
                });
            }
        })
        .catch(err => { showLoading(false); console.error(err); showError('Error al cancelar: ' + err.message); });
    });
}

// ============================================
// EDITAR
// ============================================
function editarFactura(id) {
    fetchJSON(apiBase() + `/facturacion/${id}`)
        .then(data => {
            if (!data.success) { showError('No se pudo cargar la factura'); return; }
            const f = data.data;
            if (parseInt(f.estatus) === 19) { showError('No se puede editar una factura timbrada'); return; }
            if (parseInt(f.estatus) === 21) { showError('No se puede editar una factura cancelada'); return; }

            modoEdicionFactura = true;
            document.getElementById('tituloModalFactura').textContent = 'Editar Factura ' + (f.serie || '') + '-' + (f.folio || '');
            document.getElementById('factura_id_edicion').value = f.factura_id;

            cargarCombos().then(() => {
                document.getElementById('proyecto_id').value = f.proyecto_id || '';
                document.getElementById('contacto_id').value = f.contacto_id || '';
                document.getElementById('cat_serie_id').value = f.cat_serie_id || '';
                document.getElementById('folio').value = f.folio || '';
                document.getElementById('fecha').value = (f.fecha || '').substring(0, 10);
                document.getElementById('fecha_vencimiento').value = (f.fecha_vencimiento || '').substring(0, 10);
                document.getElementById('moneda').value = f.cat_monedas_clave || 'MXN';
                document.getElementById('tipo_cambio').value = f.tipo_cambio || 1;
                document.getElementById('tipo_comprobante').value = f.tipo_comprobante || 'I';
                document.getElementById('uso_cfdi').value = f.satcat_uso_cfdi_clave || '';
                document.getElementById('forma_pago').value = f.satcat_formas_pago_clave || '';
                document.getElementById('metodo_pago').value = f.satcat_metodos_pago_clave || '';
                document.getElementById('observaciones').value = f.observaciones || '';
                document.getElementById('retencion_iva').value = f.retencion_iva || 0;
                document.getElementById('retencion_isr').value = f.retencion_isr || 0;
                document.getElementById('retencion_garantia').value = f.retencion_garantia || 0;
                document.getElementById('nota_venta_id').value = f.nota_venta_id || '';
                document.getElementById('factura_origen_id').value = f.factura_origen_id || '';

                conceptos = (data.conceptos || []).map(c => ({
                    codigo: c.satcat_clave_productos_clave || '',
                    descripcion: c.descripcion,
                    observaciones: c.observaciones || '',
                    cantidad: parseFloat(c.cantidad),
                    valorUnitario: parseFloat(c.valor_unitario),
                    descuento: parseFloat(c.descuento || 0),
                    importe: parseFloat(c.importe),
                    estimacion_id: c.estimacion_id,
                    partida_id: c.partida_id,
                    productoSat: c.satcat_clave_productos_clave || '84111500',
                    unidadSat: c.satcat_unidades_clave || 'ACT'
                }));
                actualizarTablaConceptos();
                actualizarResumen();

                document.getElementById('modalNuevaFactura').style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        })
        .catch(err => { console.error(err); showError('Error al cargar la factura: ' + err.message); });
}

// ============================================
// MODALES
// ============================================
function abrirModalNuevaFactura() {
    const modal = document.getElementById('modalNuevaFactura');
    if (!modal) return;
    modoEdicionFactura = false;
    document.getElementById('tituloModalFactura').textContent = 'Nueva Factura';
    document.getElementById('factura_id_edicion').value = '';
    document.getElementById('formNuevaFactura').reset();
    document.getElementById('tipo_comprobante').value = 'I';
    document.getElementById('retencion_iva').value = 0;
    document.getElementById('retencion_isr').value = 0;
    document.getElementById('retencion_garantia').value = 0;
    conceptos = [];
    editandoConceptoIndex = -1;
    actualizarTablaConceptos();
    actualizarResumen();
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;
    cargarCombos();
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModalFactura() {
    const modal = document.getElementById('modalNuevaFactura');
    if (modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
    modoEdicionFactura = false;
}

function cargarCombos() {
    const promises = [];

    promises.push(fetchJSON(apiBase() + '/api/proyectos/activos').then(data => {
        const select = document.getElementById('proyecto_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
            data.forEach(p => select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`);
        }
    }).catch(e => console.error('Error proyectos:', e)));

    promises.push(fetchJSON(apiBase() + '/api/contactos').then(data => {
        const select = document.getElementById('contacto_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar cliente...</option>';
            data.forEach(c => select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`);
            select.onchange = function() { recargarNotasYRefacturas(this.value); };
        }
    }).catch(e => console.error('Error clientes:', e)));

    promises.push(fetchJSON(apiBase() + '/api/series/activas').then(data => {
        const select = document.getElementById('cat_serie_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar serie...</option>';
            data.forEach(s => {
                select.innerHTML += `<option value="${s.cat_serie_id}" data-folio-actual="${s.folio_actual || 0}">${s.serie} - ${s.descripcion}</option>`;
            });
            select.onchange = function() {
                if (modoEdicionFactura) return;
                const opt = this.options[this.selectedIndex];
                if (this.value) {
                    const fa = parseInt(opt.dataset.folioActual) || 0;
                    document.getElementById('folio').value = String(fa + 1).padStart(6, '0');
                }
            };
        }
    }).catch(e => console.error('Error series:', e)));

    promises.push(fetchJSON(apiBase() + '/api/sat/uso-cfdi').then(data => {
        const select = document.getElementById('uso_cfdi');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar uso...</option>';
            data.forEach(u => select.innerHTML += `<option value="${u.clave}">${u.clave} - ${u.descripcion}</option>`);
        }
    }).catch(e => console.error('Error usos:', e)));

    promises.push(fetchJSON(apiBase() + '/api/sat/formas-pago').then(data => {
        const select = document.getElementById('forma_pago');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar forma...</option>';
            data.forEach(f => select.innerHTML += `<option value="${f.clave}">${f.clave} - ${f.descripcion}</option>`);
        }
    }).catch(e => console.error('Error formas:', e)));

    promises.push(fetchJSON(apiBase() + '/api/sat/metodos-pago').then(data => {
        const select = document.getElementById('metodo_pago');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar método...</option>';
            data.forEach(m => select.innerHTML += `<option value="${m.clave}">${m.clave} - ${m.descripcion}</option>`);
        }
    }).catch(e => console.error('Error métodos:', e)));

    promises.push(fetchJSON(apiBase() + '/api/sat/claves-producto-servicio').then(data => {
        const select = document.getElementById('conceptoProductoSat');
        if (select && Array.isArray(data)) {
            select.innerHTML = '';
            data.forEach(c => select.innerHTML += `<option value="${c.clave}">${c.clave} - ${c.descripcion}</option>`);
        }
    }).catch(e => console.error('Error producto SAT:', e)));

    promises.push(fetchJSON(apiBase() + '/api/sat/claves-unidad-medida').then(data => {
        const select = document.getElementById('conceptoUnidadSat');
        if (select && Array.isArray(data)) {
            select.innerHTML = '';
            data.forEach(c => select.innerHTML += `<option value="${c.clave}">${c.clave} - ${c.descripcion}</option>`);
        }
    }).catch(e => console.error('Error unidad SAT:', e)));

    promises.push(fetchJSON(apiBase() + '/api/notas-venta/disponibles').then(data => {
        const select = document.getElementById('nota_venta_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Sin nota de venta</option>';
            data.forEach(nv => select.innerHTML += `<option value="${nv.id}" data-folio="${nv.folio || ''}">${nv.folio || nv.id} - ${nv.cliente_nombre || ''} (${formatCurrency(nv.total)})</option>`);
            select.onchange = function() { if (this.value) clonarConceptosNotaVenta(this.value); };
        }
    }).catch(e => console.error('Error notas venta:', e)));

    promises.push(fetchJSON(apiBase() + '/api/facturas-para-refactura').then(data => {
        const select = document.getElementById('factura_origen_id');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Ninguna</option>';
            data.forEach(f => {
                select.innerHTML += `<option value="${f.factura_id}">${f.serie || ''}-${f.folio} | ${f.cliente_nombre || ''} | ${formatCurrency(f.total)} | CANCELADA</option>`;
            });
            select.onchange = function() { if (this.value) clonarFacturaOrigen(this.value); };
        }
    }).catch(e => console.error('Error facturas refactura:', e)));

    return Promise.all(promises);
}

function recargarNotasYRefacturas(contactoId) {
    const qs = contactoId ? ('?contacto_id=' + contactoId) : '';
    fetchJSON(apiBase() + '/api/notas-venta/disponibles' + qs)
        .then(data => {
            const select = document.getElementById('nota_venta_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Sin nota de venta</option>';
                data.forEach(nv => select.innerHTML += `<option value="${nv.id}" data-folio="${nv.folio || ''}">${nv.folio || nv.id} - ${nv.cliente_nombre || ''} (${formatCurrency(nv.total)})</option>`);
            }
        }).catch(e => console.error('Error notas venta (onchange):', e));

    fetchJSON(apiBase() + '/api/facturas-para-refactura' + qs)
        .then(data => {
            const select = document.getElementById('factura_origen_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Ninguna</option>';
                data.forEach(f => select.innerHTML += `<option value="${f.factura_id}">${f.serie || ''}-${f.folio} | ${f.cliente_nombre || ''} | ${formatCurrency(f.total)} | CANCELADA</option>`);
            }
        }).catch(e => console.error('Error facturas refactura (onchange):', e));
}

function clonarFacturaOrigen(origenId) {
    Swal.fire({
        title: '¿Cargar datos de la factura origen?',
        html: 'Se copiarán cliente, conceptos y montos de la factura seleccionada.<br>Podrás editarlos antes de guardar.',
        icon: 'question', showCancelButton: true, confirmButtonColor: '#083CAE', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, cargar', cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(res => {
        if (!res.isConfirmed) { document.getElementById('factura_origen_id').value = ''; return; }
        fetchJSON(apiBase() + `/facturacion/${origenId}`)
            .then(data => {
                if (!data.success) { showError('No se pudo cargar la factura origen'); return; }
                const f = data.data;
                if (f.contacto_id) document.getElementById('contacto_id').value = f.contacto_id;
                if (f.proyecto_id) document.getElementById('proyecto_id').value = f.proyecto_id;
                document.getElementById('moneda').value = f.cat_monedas_clave || 'MXN';
                document.getElementById('tipo_cambio').value = f.tipo_cambio || 1;
                document.getElementById('uso_cfdi').value = f.satcat_uso_cfdi_clave || 'G01';
                document.getElementById('forma_pago').value = f.satcat_formas_pago_clave || '01';
                document.getElementById('metodo_pago').value = f.satcat_metodos_pago_clave || 'PUE';
                document.getElementById('tipo_comprobante').value = f.tipo_comprobante || 'I';
                document.getElementById('retencion_iva').value = f.retencion_iva || 0;
                document.getElementById('retencion_isr').value = f.retencion_isr || 0;
                document.getElementById('retencion_garantia').value = f.retencion_garantia || 0;
                document.getElementById('observaciones').value =
                    (f.observaciones || '') + (f.observaciones ? '\n\n' : '') +
                    `[Re-factura de ${f.serie || ''}-${f.folio}]`;

                conceptos = (data.conceptos || []).map(c => ({
                    codigo: c.satcat_clave_productos_clave || '',
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
                showSuccess('Datos de la factura origen cargados. Revisa y guarda.');
            })
            .catch(err => { console.error('Error clonar factura:', err); showError('Error al cargar factura origen: ' + err.message); });
    });
}

function clonarConceptosNotaVenta(notaId) {
    fetchJSON(apiBase() + `/api/notas-venta/${notaId}`)
        .then(data => {
            if (!data.success) return;
            Swal.fire({
                title: '¿Cargar conceptos de la nota?',
                text: `Se agregarán ${(data.conceptos || []).length} concepto(s) de ${data.data.folio}.`,
                icon: 'question', showCancelButton: true, confirmButtonColor: '#083CAE', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cargar', cancelButtonText: 'No',
                didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
            }).then(res => {
                if (!res.isConfirmed) return;
                (data.conceptos || []).forEach(c => {
                    conceptos.push({
                        codigo: c.codigo || c.satcat_clave_productos_clave || '',
                        descripcion: c.descripcion,
                        observaciones: c.observaciones || '',
                        cantidad: parseFloat(c.cantidad),
                        valorUnitario: parseFloat(c.valor_unitario),
                        descuento: parseFloat(c.descuento || 0),
                        importe: parseFloat(c.importe),
                        productoSat: c.satcat_clave_productos_clave || '84111500',
                        unidadSat: c.satcat_unidades_clave || 'ACT'
                    });
                });
                actualizarTablaConceptos();
                actualizarResumen();
                showSuccess(`${(data.conceptos || []).length} concepto(s) importados`);
            });
        }).catch(e => console.error('Error cargar conceptos NV:', e));
}

// ============================================
// CONCEPTOS
// ============================================
function abrirModalConcepto(index = -1) {
    const modal = document.getElementById('modalConcepto');
    if (!modal) return;
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
    modal.style.display = 'block';
}

function cerrarModalConcepto() { document.getElementById('modalConcepto').style.display = 'none'; }

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

    const concepto = { codigo, descripcion, observaciones, cantidad, valorUnitario, descuento, importe: cantidad * valorUnitario, productoSat, unidadSat };

    if (editandoConceptoIndex >= 0) {
        concepto.estimacion_id = conceptos[editandoConceptoIndex].estimacion_id;
        concepto.partida_id = conceptos[editandoConceptoIndex].partida_id;
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
        const badgeEstimacion = c.estimacion_id ? `<span style="background:#d4edda; color:#155724; padding:2px 6px; border-radius:10px; font-size:10px; margin-left:6px;">EST #${c.estimacion_id}</span>` : '';
        html += `<tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">${c.codigo || '-'}</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                ${c.descripcion} ${badgeEstimacion}
                ${c.observaciones ? '<br><small style="color:#888;">' + c.observaciones + '</small>' : ''}
            </td>
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
        title: '¿Eliminar concepto?', text: `¿Deseas eliminar "${conceptos[index].descripcion}"?`,
        icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(result => {
        if (result.isConfirmed) {
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
    const baseGravable = subtotal - descuentoTotal;
    const iva = baseGravable * 0.16;
    const retIva = parseFloat(document.getElementById('retencion_iva').value) || 0;
    const retIsr = parseFloat(document.getElementById('retencion_isr').value) || 0;
    const retGar = parseFloat(document.getElementById('retencion_garantia').value) || 0;
    const retenciones = retIva + retIsr + retGar;
    const total = baseGravable + iva - retenciones;
    document.getElementById('resumenSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('resumenDescuento').textContent = formatCurrency(descuentoTotal);
    document.getElementById('resumenIVA').textContent = formatCurrency(iva);
    document.getElementById('resumenRetenciones').textContent = formatCurrency(retenciones);
    document.getElementById('resumenTotal').textContent = formatCurrency(total);
}

function aplicarFiltros() {
    const busq = (document.getElementById('buscador').value || '').toLowerCase().trim();
    if (!busq) { aplicarFiltrosColumnas(); return; }
    let base = [...datosFacturacion];
    for (const campo in columnFilters) {
        const valor = columnFilters[campo];
        if (!valor) continue;
        const v = String(valor).toLowerCase();
        base = base.filter(row => {
            let cellVal = row[campo];
            if (campo === 'estatus_texto') cellVal = row.estatus_texto || normalizarEstatus(row.estatus);
            else if (campo === 'moneda') cellVal = row.cat_monedas_clave || row.moneda || '';
            else if (campo === 'total_mxn') cellVal = row.total_mxn || row.total || 0;
            if (cellVal === null || cellVal === undefined) return false;
            return String(cellVal).toLowerCase().includes(v);
        });
    }
    base = base.filter(f =>
        (f.cliente_nombre || '').toLowerCase().includes(busq) ||
        (f.cliente_rfc || '').toLowerCase().includes(busq) ||
        (f.folio || '').toString().toLowerCase().includes(busq) ||
        (f.serie || '').toLowerCase().includes(busq) ||
        (f.uuid || '').toLowerCase().includes(busq)
    );
    if (sortState.field) {
        const dir = sortState.direction === 'desc' ? -1 : 1;
        const field = sortState.field;
        base.sort((a, b) => {
            let va = a[field], vb = b[field];
            if (['subtotal','iva','total'].includes(field)) { va = parseFloat(va||0); vb = parseFloat(vb||0); }
            else if (field === 'total_mxn') { va = parseFloat(a.total_mxn||a.total||0); vb = parseFloat(b.total_mxn||b.total||0); }
            else if (field === 'fecha') { va = a.fecha ? new Date(a.fecha).getTime() : 0; vb = b.fecha ? new Date(b.fecha).getTime() : 0; }
            else { va = String(va||'').toLowerCase(); vb = String(vb||'').toLowerCase(); }
            if (va < vb) return -1 * dir;
            if (va > vb) return 1 * dir;
            return 0;
        });
    }
    datosFiltrados = base;
    currentPage = 1;
    cargarTabla();
}

function getFiltrosActuales() {
    return { fecha_inicio: document.getElementById('fechaInicio').value, fecha_fin: document.getElementById('fechaFin').value };
}

// ============================================
// GUARDAR FACTURA
// ============================================
function guardarFactura(timbrar = false) {
    const contacto_id = document.getElementById('contacto_id').value;
    const cat_serie_id = document.getElementById('cat_serie_id').value;
    const uso_cfdi = document.getElementById('uso_cfdi').value;
    const forma_pago = document.getElementById('forma_pago').value;
    const metodo_pago = document.getElementById('metodo_pago').value;

    if (!contacto_id) { showError('Seleccione un cliente'); return; }
    if (!cat_serie_id) { showError('Seleccione una serie'); return; }
    if (!uso_cfdi) { showError('Seleccione un uso de CFDI'); return; }
    if (!forma_pago) { showError('Seleccione una forma de pago'); return; }
    if (!metodo_pago) { showError('Seleccione un método de pago'); return; }
    if (conceptos.length === 0) { showError('Agregue al menos un concepto'); return; }

    showLoading(true);

    const notaVentaSelect = document.getElementById('nota_venta_id');
    const notaVentaOpt = notaVentaSelect.options[notaVentaSelect.selectedIndex];

    const data = {
        contacto_id: parseInt(contacto_id),
        cat_serie_id: parseInt(cat_serie_id),
        proyecto_id: document.getElementById('proyecto_id').value || null,
        fecha: document.getElementById('fecha').value,
        fecha_vencimiento: document.getElementById('fecha_vencimiento').value || null,
        moneda: document.getElementById('moneda').value,
        tipo_cambio: parseFloat(document.getElementById('tipo_cambio').value) || 1,
        tipo_comprobante: document.getElementById('tipo_comprobante').value,
        satcat_uso_cfdi_clave: uso_cfdi,
        satcat_formas_pago_clave: forma_pago,
        satcat_metodos_pago_clave: metodo_pago,
        observaciones: document.getElementById('observaciones').value,
        retencion_iva: parseFloat(document.getElementById('retencion_iva').value) || 0,
        retencion_isr: parseFloat(document.getElementById('retencion_isr').value) || 0,
        retencion_garantia: parseFloat(document.getElementById('retencion_garantia').value) || 0,
        nota_venta_id: notaVentaSelect.value || null,
        nota_venta_folio: (notaVentaSelect.value && notaVentaOpt) ? (notaVentaOpt.dataset.folio || null) : null,
        factura_origen_id: document.getElementById('factura_origen_id').value || null,
        conceptos: conceptos.map(c => ({
            codigo: c.codigo || null, descripcion: c.descripcion, observaciones: c.observaciones || null,
            cantidad: c.cantidad, valorUnitario: c.valorUnitario, descuento: c.descuento || 0, importe: c.importe,
            producto_sat: c.productoSat || '84111500', unidad_sat: c.unidadSat || 'ACT',
            estimacion_id: c.estimacion_id || null, partida_id: c.partida_id || null
        })),
        timbrar: timbrar
    };

    const facturaId = document.getElementById('factura_id_edicion').value;
    const url = (modoEdicionFactura && facturaId) ? (apiBase() + `/api/facturas/${facturaId}`) : (apiBase() + '/api/facturas');
    const method = (modoEdicionFactura && facturaId) ? 'PUT' : 'POST';

    fetchJSON(url, {
        method: method,
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.getElementById('csrf_token').value },
        body: JSON.stringify(data)
    })
    .then(resp => {
        showLoading(false);
        if (resp.success) {
            if (resp.timbrado === false && resp.timbrado_error) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Factura guardada, pero no timbrada',
                    html: `<p style="text-align:left;">La factura quedó en estado <b>pendiente</b>.</p>
                           <p style="text-align:left;margin-top:10px;font-size:13px;color:#666;">
                           <b>Error del PAC:</b><br>${resp.timbrado_error}</p>
                           <p style="text-align:left;margin-top:10px;">Puedes reintentar el timbrado desde la tabla con el ícono <i class="fas fa-stamp" style="color:#28a745;"></i></p>`,
                    confirmButtonColor: '#083CAE',
                    didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
                });
            } else {
                showSuccess(timbrar ? 'Factura timbrada correctamente' : 'Factura guardada correctamente');
            }
            cerrarModalFactura();
            cargarDatos(getFiltrosActuales());
        } else {
            showError(resp.message || 'Error al guardar');
        }
    })
    .catch(err => { showLoading(false); console.error(err); showError('Error al guardar: ' + err.message); });
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { showError('No hay datos para exportar'); return; }
    let csv = 'Estatus,Fecha,Serie,Folio,Cliente,RFC,Moneda,Subtotal,IVA,Total,Total MXN,UUID\n';
    datosFiltrados.forEach(i => {
        csv += `${getEstatusDisplay(i.estatus_texto || i.estatus)},${formatDate(i.fecha)},${i.serie || '-'},${i.folio || '-'},"${i.cliente_nombre || '-'}",${i.cliente_rfc || '-'},${i.moneda || 'MXN'},${i.subtotal || 0},${i.iva || 0},${i.total || 0},${i.total_mxn || i.total || 0},${i.uuid || '-'}\n`;
    });
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `facturas_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

// ============================================
// ESTIMACIONES
// ============================================
let datosEstimacionesPendientes = [];
function abrirModalEstimaciones() {
    const proyectoId = document.getElementById('proyecto_id').value;
    if (!proyectoId) { showError('Primero selecciona un proyecto en el formulario'); return; }
    const proyectoSelect = document.getElementById('proyecto_id');
    document.getElementById('modalEstimacionesProyecto').textContent = proyectoSelect.options[proyectoSelect.selectedIndex].text;
    document.getElementById('modalEstimacionesPendientes').style.display = 'block';
    document.body.style.overflow = 'hidden';
    cargarEstimacionesPendientes(proyectoId);
}
function cerrarModalEstimaciones() {
    document.getElementById('modalEstimacionesPendientes').style.display = 'none';
    document.body.style.overflow = 'auto';
    datosEstimacionesPendientes = [];
}
function cargarEstimacionesPendientes(proyectoId) {
    const loading = document.getElementById('loadingEstimaciones');
    const sinDatos = document.getElementById('sinEstimaciones');
    const lista = document.getElementById('listaPartidasEstimaciones');
    loading.style.display = 'block';
    sinDatos.style.display = 'none';
    lista.innerHTML = '';
    fetchJSON(apiBase() + `/estimaciones/api/pendientes-facturar/${proyectoId}`)
        .then(response => {
            loading.style.display = 'none';
            if (!response.success || !response.data || response.data.length === 0) {
                sinDatos.style.display = 'block';
                datosEstimacionesPendientes = [];
                actualizarTotalSeleccionado();
                return;
            }
            datosEstimacionesPendientes = response.data;
            renderListaEstimaciones(response.data);
            actualizarTotalSeleccionado();
        })
        .catch(err => { console.error(err); loading.style.display = 'none'; showError('Error al cargar las estimaciones pendientes'); });
}
function renderListaEstimaciones(partidas) {
    const contenedor = document.getElementById('listaPartidasEstimaciones');
    let html = '';
    partidas.forEach((partida, idxP) => {
        html += `
            <div style="border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 15px; overflow: hidden;">
                <div style="background-color: #f4f6f9; padding: 12px 18px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <input type="checkbox" class="chk-partida" data-idx="${idxP}" id="chkPartida_${idxP}" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 10px; cursor: pointer;">
                        <label for="chkPartida_${idxP}" style="cursor: pointer; font-weight: 600; color: #083CAE;">${partida.partida_codigo} - ${partida.partida_nombre}</label>
                        <span style="color: #6c757d; font-size: 12px; margin-left: 10px;">(${partida.unidad || 's/u'})</span>
                    </div>
                    <div style="text-align: right; font-size: 12px;">
                        <div>Importe: <strong>${formatCurrency(partida.importe_partida)}</strong></div>
                        <div style="color: #28a745;">Devengado: <strong>${formatCurrency(partida.monto_devengado_total)}</strong></div>
                        <div style="color: #dc3545;">Pendiente: <strong>${formatCurrency(partida.monto_pendiente)}</strong></div>
                    </div>
                </div>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead style="background-color: #fafafa;"><tr>
                        <th style="padding: 8px; text-align: center; width: 40px;"></th>
                        <th style="padding: 8px; text-align: center;">Fecha</th>
                        <th style="padding: 8px; text-align: center;">Avance %</th>
                        <th style="padding: 8px; text-align: right;">Devengado</th>
                        <th style="padding: 8px; text-align: right;">Ya Facturado</th>
                        <th style="padding: 8px; text-align: right;">Pendiente</th>
                    </tr></thead><tbody>
        `;
        partida.estimaciones.forEach((est, idxE) => {
            const disabled = est.monto_pendiente <= 0.01;
            html += `<tr style="${disabled ? 'background:#f8f9fa; opacity:0.6;' : ''}">
                <td style="padding: 8px; text-align: center;"><input type="checkbox" class="chk-estimacion" data-partida-idx="${idxP}" data-estimacion-idx="${idxE}" id="chkEst_${idxP}_${idxE}" ${disabled ? 'disabled' : ''} style="width: 16px; height: 16px; cursor: pointer;"></td>
                <td style="padding: 8px; text-align: center;">${formatDate(est.fecha)}</td>
                <td style="padding: 8px; text-align: center;">${est.avance_porcentaje}% <small style="color:#28a745;">(+${est.avance_periodo}%)</small></td>
                <td style="padding: 8px; text-align: right;">${formatCurrency(est.monto_devengado)}</td>
                <td style="padding: 8px; text-align: right; color: #6c757d;">${formatCurrency(est.monto_facturado)}</td>
                <td style="padding: 8px; text-align: right; color: #dc3545; font-weight: 600;">${formatCurrency(est.monto_pendiente)}</td>
            </tr>`;
        });
        html += `</tbody></table></div>`;
    });
    contenedor.innerHTML = html;
    contenedor.querySelectorAll('.chk-partida').forEach(chk => {
        chk.addEventListener('change', (e) => {
            const idxP = e.target.dataset.idx;
            const marcado = e.target.checked;
            contenedor.querySelectorAll(`.chk-estimacion[data-partida-idx="${idxP}"]`).forEach(chkE => {
                if (!chkE.disabled) chkE.checked = marcado;
            });
            actualizarTotalSeleccionado();
        });
    });
    contenedor.querySelectorAll('.chk-estimacion').forEach(chk => chk.addEventListener('change', actualizarTotalSeleccionado));
}
function actualizarTotalSeleccionado() {
    let total = 0;
    document.querySelectorAll('.chk-estimacion:checked').forEach(chk => {
        const idxP = parseInt(chk.dataset.partidaIdx);
        const idxE = parseInt(chk.dataset.estimacionIdx);
        const est = datosEstimacionesPendientes[idxP]?.estimaciones?.[idxE];
        if (est) total += est.monto_pendiente;
    });
    document.getElementById('totalSeleccionadoEstimaciones').textContent = formatCurrency(total);
}
function agregarEstimacionesSeleccionadas() {
    const seleccionadas = [];
    document.querySelectorAll('.chk-estimacion:checked').forEach(chk => {
        const idxP = parseInt(chk.dataset.partidaIdx);
        const idxE = parseInt(chk.dataset.estimacionIdx);
        const partida = datosEstimacionesPendientes[idxP];
        const est = partida?.estimaciones?.[idxE];
        if (partida && est) seleccionadas.push({ partida, est });
    });
    if (seleccionadas.length === 0) { showError('Selecciona al menos una estimación'); return; }
    seleccionadas.forEach(({ partida, est }) => {
        const valorSinIva = est.monto_pendiente / 1.16;
        conceptos.push({
            codigo: partida.partida_codigo,
            descripcion: `Estimación ${formatDate(est.fecha)} - ${partida.partida_codigo} ${partida.partida_nombre} (Avance ${est.avance_porcentaje}%)`,
            observaciones: '', cantidad: 1,
            valorUnitario: parseFloat(valorSinIva.toFixed(2)), descuento: 0,
            importe: parseFloat(valorSinIva.toFixed(2)),
            productoSat: '84111500', unidadSat: 'ACT',
            estimacion_id: est.estimacion_id, partida_id: partida.partida_id
        });
    });
    actualizarTablaConceptos();
    actualizarResumen();
    cerrarModalEstimaciones();
    showSuccess(`${seleccionadas.length} concepto(s) agregado(s) desde estimaciones`);
}

// ============================================
// CATÁLOGO DE SERIES
// ============================================
function abrirModalSeries() {
    document.getElementById('modalSeries').style.display = 'block';
    document.body.style.overflow = 'hidden';
    cargarSeriesCatalogo();
}
function cerrarModalSeries() {
    document.getElementById('modalSeries').style.display = 'none';
    document.body.style.overflow = 'auto';
}
function cargarSeriesCatalogo() {
    const tbody = document.getElementById('tablaSeriesBody');
    tbody.innerHTML = '<tr><td colspan="7" style="padding: 30px; text-align: center; color: #999;"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>';
    fetchJSON(apiBase() + '/api/series/catalogo')
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="padding: 30px; text-align: center; color: #999;">Sin series registradas</td></tr>';
                return;
            }
            tbody.innerHTML = '';
            data.forEach(s => {
                tbody.innerHTML += `
                    <tr>
                        <td style="padding: 10px;"><strong>${s.serie}</strong></td>
                        <td style="padding: 10px;">${s.descripcion}</td>
                        <td style="padding: 10px; text-align: center;">${s.cat_tipo_comprobante || 'I'}</td>
                        <td style="padding: 10px; text-align: right;">${s.folio_actual}</td>
                        <td style="padding: 10px; text-align: right;">${s.folio_final}</td>
                        <td style="padding: 10px; text-align: center;">${s.activo ? '✅' : '❌'}</td>
                        <td style="padding: 10px; text-align: center;">
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin-right: 10px;" onclick='editarSerie(${JSON.stringify(s).replace(/'/g, "&#39;")})'></i>
                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;" onclick="eliminarSerie(${s.cat_serie_id})"></i>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error('Error series:', err);
            tbody.innerHTML = `<tr><td colspan="7" style="padding:30px;text-align:center;color:#dc3545;">Error al cargar series: ${err.message}</td></tr>`;
        });
}
function abrirFormSerie(serie = null) {
    document.getElementById('modalFormSerie').style.display = 'block';
    if (serie) {
        document.getElementById('modalSerieTitulo').textContent = 'Editar Serie';
        document.getElementById('serie_id_edicion').value = serie.cat_serie_id;
        document.getElementById('serie_input').value = serie.serie;
        document.getElementById('serie_descripcion').value = serie.descripcion;
        document.getElementById('serie_tipo').value = serie.cat_tipo_comprobante || 'I';
        document.getElementById('serie_folio_actual').value = serie.folio_actual;
        document.getElementById('serie_folio_final').value = serie.folio_final;
    } else {
        document.getElementById('modalSerieTitulo').textContent = 'Nueva Serie';
        document.getElementById('serie_id_edicion').value = '';
        document.getElementById('serie_input').value = '';
        document.getElementById('serie_descripcion').value = '';
        document.getElementById('serie_tipo').value = 'I';
        document.getElementById('serie_folio_actual').value = 0;
        document.getElementById('serie_folio_final').value = 999999;
    }
}
function cerrarFormSerie() { document.getElementById('modalFormSerie').style.display = 'none'; }
function guardarSerie() {
    const id = document.getElementById('serie_id_edicion').value;
    const data = {
        serie: document.getElementById('serie_input').value,
        descripcion: document.getElementById('serie_descripcion').value,
        cat_tipo_comprobante: document.getElementById('serie_tipo').value,
        folio_actual: parseInt(document.getElementById('serie_folio_actual').value) || 0,
        folio_final: parseInt(document.getElementById('serie_folio_final').value) || 999999,
        activo: true
    };
    if (!data.serie || !data.descripcion) { showError('Serie y descripción son obligatorias'); return; }
    const url = id ? (apiBase() + `/api/series/catalogo/${id}`) : (apiBase() + '/api/series/catalogo');
    const method = id ? 'PUT' : 'POST';
    fetchJSON(url, {
        method,
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.getElementById('csrf_token').value },
        body: JSON.stringify(data)
    })
    .then(resp => {
        if (resp.success) { showSuccess('Serie guardada'); cerrarFormSerie(); cargarSeriesCatalogo(); }
        else showError(resp.message || 'Error al guardar');
    })
    .catch(err => { console.error(err); showError('Error al guardar serie: ' + err.message); });
}
function editarSerie(serie) { abrirFormSerie(serie); }
function eliminarSerie(id) {
    Swal.fire({
        title: '¿Eliminar serie?', text: 'Se marcará como inactiva.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Sí, eliminar',
        didOpen: () => { Swal.getContainer().style.zIndex = '40000'; }
    }).then(res => {
        if (!res.isConfirmed) return;
        fetchJSON(apiBase() + `/api/series/catalogo/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.getElementById('csrf_token').value }
        })
        .then(() => { showSuccess('Serie eliminada'); cargarSeriesCatalogo(); })
        .catch(err => { console.error(err); showError('Error al eliminar: ' + err.message); });
    });
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const hoy = new Date();
    const hace30 = new Date();
    hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];

    inicializarFiltrosEncabezados();
    cargarDatos(getFiltrosActuales());

    document.getElementById('btnAgregar').addEventListener('click', abrirModalNuevaFactura);
    document.getElementById('btnExcel').addEventListener('click', exportToExcel);
    document.getElementById('btnCatalogoSeries').addEventListener('click', abrirModalSeries);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);
    document.getElementById('btnCrearFiltro').addEventListener('click', () => showSuccess('Filtros avanzados en desarrollo'));

    document.getElementById('fechaInicio').addEventListener('change', () => { currentPage = 1; cargarDatos(getFiltrosActuales()); });
    document.getElementById('fechaFin').addEventListener('change', () => { currentPage = 1; cargarDatos(getFiltrosActuales()); });
    document.getElementById('buscador').addEventListener('input', aplicarFiltros);

    document.getElementById('btnPrimeraPagina').addEventListener('click', () => { currentPage = 1; cargarTabla(); });
    document.getElementById('btnAnteriorPagina').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTabla(); } });
    document.getElementById('btnSiguientePagina').addEventListener('click', () => { const max = Math.ceil(datosFiltrados.length / rowsPerPage); if (currentPage < max) { currentPage++; cargarTabla(); } });
    document.getElementById('btnUltimaPagina').addEventListener('click', () => { currentPage = Math.ceil(datosFiltrados.length / rowsPerPage); cargarTabla(); });

    document.getElementById('cerrarModal').addEventListener('click', cerrarModalFactura);
    document.getElementById('btnCancelar').addEventListener('click', cerrarModalFactura);
    document.getElementById('btnGuardarFactura').addEventListener('click', () => guardarFactura(false));
    document.getElementById('btnTimbrar').addEventListener('click', () => guardarFactura(true));
    document.getElementById('btnAgregarConcepto').addEventListener('click', () => abrirModalConcepto());
    document.getElementById('btnCargarEstimaciones').addEventListener('click', abrirModalEstimaciones);

    document.getElementById('retencion_iva').addEventListener('input', actualizarResumen);
    document.getElementById('retencion_isr').addEventListener('input', actualizarResumen);
    document.getElementById('retencion_garantia').addEventListener('input', actualizarResumen);

    document.getElementById('btnGuardarConcepto').addEventListener('click', guardarConcepto);
    document.getElementById('btnCancelarConcepto').addEventListener('click', cerrarModalConcepto);

    document.getElementById('cerrarModalEstimaciones').addEventListener('click', cerrarModalEstimaciones);
    document.getElementById('btnCancelarEstimaciones').addEventListener('click', cerrarModalEstimaciones);
    document.getElementById('btnAgregarEstimacionesSeleccionadas').addEventListener('click', agregarEstimacionesSeleccionadas);

    document.getElementById('cerrarModalSeries').addEventListener('click', cerrarModalSeries);
    document.getElementById('btnNuevaSerie').addEventListener('click', () => abrirFormSerie());
    document.getElementById('btnCancelarFormSerie').addEventListener('click', cerrarFormSerie);
    document.getElementById('btnGuardarSerie').addEventListener('click', guardarSerie);

    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalNuevaFactura')) cerrarModalFactura();
        if (e.target === document.getElementById('modalConcepto')) cerrarModalConcepto();
        if (e.target === document.getElementById('modalEstimacionesPendientes')) cerrarModalEstimaciones();
        if (e.target === document.getElementById('modalSeries')) cerrarModalSeries();
        if (e.target === document.getElementById('modalFormSerie')) cerrarFormSerie();
    });
});
</script>

@endsection