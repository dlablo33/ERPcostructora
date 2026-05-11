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
                <!-- 4 CUADROS DE FACTURACIÓN -->
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
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-layer-group" style="color: #083CAE; font-size: 14px;"></i>
                        <span style="color: #6c757d; font-size: 12px;">Arrastra columna para agrupar</span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div>
                            <button id="btnColumnas" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-columns"></i> Columnas
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
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
                    <i class="fas fa-file-invoice" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay facturas</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFacturacion" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px; text-align: center;">Serie</th>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px;">Cliente</th>
                                <th style="padding: 12px 6px;">RFC</th>
                                <th style="padding: 12px 6px; text-align: center;">Moneda</th>
                                <th style="padding: 12px 6px; text-align: right;">Subtotal</th>
                                <th style="padding: 12px 6px; text-align: right;">IVA</th>
                                <th style="padding: 12px 6px; text-align: right;">Total</th>
                                <th style="padding: 12px 6px; text-align: right;">Total MXN</th>
                                <th style="padding: 12px 6px;">UUID</th>
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
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: transparent; border: none; color: #083CAE; cursor: pointer;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
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

<!-- MODAL NUEVA FACTURA -->
<div id="modalNuevaFactura" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 1300px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Nueva Factura</span>
            </div>
            <button id="cerrarModal" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <form id="formNuevaFactura">
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                
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
                    
                    <div style="grid-column: span 3;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                        <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                    </div>
                </div>
                
                <!-- Sección de Conceptos -->
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3 style="margin: 0; color: #083CAE;">Conceptos / Partidas</h3>
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
                                    <th style="padding: 12px; text-align: right;">Importe</th>
                                    <th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaConceptos">
                                <tr id="filaConceptoVacia">
                                    <td colspan="6" style="padding: 40px; text-align: center; color: #999;">
                                        <i class="fas fa-info-circle"></i> No hay conceptos agregados
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 20px; border-radius: 8px; margin-top: 20px;">
                        <div style="display: flex; justify-content: flex-end; gap: 30px;">
                            <div style="text-align: right;">
                                <div style="color: #666; font-size: 14px;">Subtotal:</div>
                                <div style="font-size: 22px; font-weight: bold;" id="resumenSubtotal">$0.00</div>
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
<div id="modalConcepto" style="display: none; position: fixed; z-index: 10002; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: white; margin: 10% auto; width: 90%; max-width: 550px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 id="modalConceptoTitulo" style="margin: 0;">Agregar Concepto</h3>
        </div>
        <div style="padding: 25px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código / Clave Prod:</label>
                <input type="text" id="conceptoCodigo" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción *:</label>
                <textarea id="conceptoDescripcion" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cantidad *:</label>
                <input type="number" id="conceptoCantidad" step="0.01" value="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Valor Unitario *:</label>
                <input type="number" id="conceptoValorUnitario" step="0.01" value="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelarConcepto" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button type="button" id="btnGuardarConcepto" style="background-color: #083CAE; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 20000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; text-align: center;">
        <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
        <p style="margin-top: 15px;">Procesando...</p>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-activa { background-color: #d4edda; color: #155724; }
    .badge-pagada { background-color: #fff3cd; color: #856404; }
    .badge-cancelada { background-color: #f8d7da; color: #721c24; }
    .badge-pendiente { background-color: #d1ecf1; color: #0c5460; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(3, 1fr)"] { grid-template-columns: 1fr !important; }
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
        return date.toLocaleDateString('es-MX');
    } catch(e) { return dateString; }
}

function getBadgeClass(estatus) {
    const map = { 'activa': 'badge-activa', 'pagada': 'badge-pagada', 'cancelada': 'badge-cancelada' };
    return map[estatus?.toLowerCase()] || 'badge-pendiente';
}

function getEstatusDisplay(estatus) {
    const map = { 'activa': 'Activa', 'pagada': 'Pagada', 'cancelada': 'Cancelada' };
    return map[estatus?.toLowerCase()] || 'Pendiente';
}

function showLoading(show) {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = show ? 'flex' : 'none';
}

function showError(msg) { 
    Swal.fire({ icon: 'error', title: 'Error', text: msg, confirmButtonColor: '#083CAE' }); 
}

function showSuccess(msg) { 
    Swal.fire({ icon: 'success', title: 'Éxito', text: msg, confirmButtonColor: '#083CAE', timer: 3000, showConfirmButton: false }); 
}

// ============================================
// CARGA DE DATOS
// ============================================
function cargarDatos() {
    showLoading(true);
    
    fetch('/facturacion/data')
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosFacturacion = response.data;
                datosFiltrados = [...datosFacturacion];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosFacturacion = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, activas: 0, pagadas: 0, canceladas: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosFacturacion = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, activas: 0, pagadas: 0, canceladas: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalFacturas').textContent = stats.total || 0;
    document.getElementById('totalActivas').textContent = stats.activas || 0;
    document.getElementById('totalPagadas').textContent = stats.pagadas || 0;
    document.getElementById('totalCanceladas').textContent = stats.canceladas || 0;
}

function calcularTotales(datos) {
    let subtotal = 0, iva = 0, total = 0, totalMXN = 0;
    datos.forEach(item => {
        subtotal += parseFloat(item.subtotal || 0);
        iva += parseFloat(item.iva || 0);
        total += parseFloat(item.total || 0);
        totalMXN += parseFloat(item.total_mxn || item.total || 0);
    });
    document.getElementById('sumSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('sumIva').textContent = formatCurrency(iva);
    document.getElementById('sumTotal').textContent = formatCurrency(total);
    document.getElementById('sumTotalMXN').textContent = formatCurrency(totalMXN);
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
        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${getBadgeClass(item.estatus_texto || item.estatus)}">${getEstatusDisplay(item.estatus_texto || item.estatus)}</span></td>
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
                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer;" title="Editar" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-code" style="color: #17a2b8; cursor: pointer;" title="XML" data-id="${item.factura_id}"></i>
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    // Event listeners para acciones - CON URLs CORRECTAS
    document.querySelectorAll('.fa-eye').forEach(el => {
        el.addEventListener('click', () => verFactura(el.dataset.id));
    });
    document.querySelectorAll('.fa-edit').forEach(el => {
        el.addEventListener('click', () => editarFactura(el.dataset.id));
    });
    document.querySelectorAll('.fa-file-pdf').forEach(el => {
        el.addEventListener('click', () => {
            const id = el.dataset.id;
            window.open(`/facturacion/${id}/pdf`, '_blank');
        });
    });
    document.querySelectorAll('.fa-file-code').forEach(el => {
        el.addEventListener('click', () => {
            const id = el.dataset.id;
            window.open(`/facturacion/${id}/xml`, '_blank');
        });
    });
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

function verFactura(id) {
    fetch(`/facturacion/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const factura = data.data;
                let conceptosHtml = '<table style="width:100%; margin-top:10px;"><tr><th>Descripción</th><th>Cantidad</th><th>Valor Unitario</th><th>Importe</th></tr>';
                if (data.conceptos && data.conceptos.length > 0) {
                    data.conceptos.forEach(c => {
                        conceptosHtml += `<tr>
                            <td>${c.descripcion}</td>
                            <td style="text-align:right">${c.cantidad}</td>
                            <td style="text-align:right">${formatCurrency(c.valor_unitario)}</td>
                            <td style="text-align:right">${formatCurrency(c.importe)}</td>
                        </tr>`;
                    });
                }
                conceptosHtml += '</table>';
                
                Swal.fire({
                    title: `Factura ${factura.serie}-${factura.folio}`,
                    html: `<div style="text-align:left;">
                        <p><strong>Cliente:</strong> ${factura.cliente_nombre}</p>
                        <p><strong>RFC:</strong> ${factura.cliente_rfc}</p>
                        <p><strong>Fecha:</strong> ${formatDate(factura.fecha)}</p>
                        <p><strong>Moneda:</strong> ${factura.cat_monedas_clave || 'MXN'}</p>
                        <p><strong>Subtotal:</strong> ${formatCurrency(factura.subtotal)}</p>
                        <p><strong>IVA:</strong> ${formatCurrency(factura.iva)}</p>
                        <p><strong>Total:</strong> ${formatCurrency(factura.total)}</p>
                        <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(factura.estatus_texto)}">${getEstatusDisplay(factura.estatus_texto)}</span></p>
                        <hr><strong>Conceptos:</strong>${conceptosHtml}
                    </div>`,
                    width: '800px',
                    confirmButtonColor: '#083CAE'
                });
            } else {
                showError('No se pudo cargar la factura');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error al cargar la factura');
        });
}

function editarFactura(id) {
    window.location.href = `/facturacion/${id}/edit`;
}

// ============================================
// MODALES
// ============================================
function abrirModalNuevaFactura() {
    const modal = document.getElementById('modalNuevaFactura');
    if (!modal) return;
    
    document.getElementById('formNuevaFactura').reset();
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
}

function cargarCombos() {
    // Proyectos
    fetch('/api/proyectos/activos')
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('proyecto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
                data.forEach(p => select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`);
            }
        }).catch(e => console.error('Error proyectos:', e));
    
    // Clientes
    fetch('/api/contactos')
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('contacto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                data.forEach(c => select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`);
            }
        }).catch(e => console.error('Error clientes:', e));
    
    // Series
    fetch('/api/series/activas')
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('cat_serie_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar serie...</option>';
                data.forEach(s => {
                    select.innerHTML += `<option value="${s.cat_serie_id}" data-folio-actual="${s.folio_actual || 0}">${s.serie} - ${s.descripcion}</option>`;
                });
                select.onchange = function() {
                    const opt = this.options[this.selectedIndex];
                    if (this.value) {
                        const fa = parseInt(opt.dataset.folioActual) || 0;
                        document.getElementById('folio').value = String(fa + 1).padStart(6, '0');
                    }
                };
            }
        }).catch(e => console.error('Error series:', e));
    
    // Usos CFDI
    fetch('/api/sat/uso-cfdi').then(r => r.json()).then(data => {
        const select = document.getElementById('uso_cfdi');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar uso...</option>';
            data.forEach(u => select.innerHTML += `<option value="${u.clave}">${u.clave} - ${u.descripcion}</option>`);
        }
    }).catch(e => console.error('Error usos:', e));
    
    // Formas de pago
    fetch('/api/sat/formas-pago').then(r => r.json()).then(data => {
        const select = document.getElementById('forma_pago');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar forma...</option>';
            data.forEach(f => select.innerHTML += `<option value="${f.clave}">${f.clave} - ${f.descripcion}</option>`);
        }
    }).catch(e => console.error('Error formas:', e));
    
    // Métodos de pago
    fetch('/api/sat/metodos-pago').then(r => r.json()).then(data => {
        const select = document.getElementById('metodo_pago');
        if (select && Array.isArray(data)) {
            select.innerHTML = '<option value="">Seleccionar método...</option>';
            data.forEach(m => select.innerHTML += `<option value="${m.clave}">${m.clave} - ${m.descripcion}</option>`);
        }
    }).catch(e => console.error('Error métodos:', e));
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
        document.getElementById('conceptoCantidad').value = conceptos[index].cantidad;
        document.getElementById('conceptoValorUnitario').value = conceptos[index].valorUnitario;
    } else {
        document.getElementById('modalConceptoTitulo').textContent = 'Agregar Concepto';
        document.getElementById('conceptoCodigo').value = '';
        document.getElementById('conceptoDescripcion').value = '';
        document.getElementById('conceptoCantidad').value = '1';
        document.getElementById('conceptoValorUnitario').value = '0';
    }
    modal.style.display = 'block';
}

function cerrarModalConcepto() {
    document.getElementById('modalConcepto').style.display = 'none';
}

function guardarConcepto() {
    const descripcion = document.getElementById('conceptoDescripcion').value.trim();
    const cantidad = parseFloat(document.getElementById('conceptoCantidad').value);
    const valorUnitario = parseFloat(document.getElementById('conceptoValorUnitario').value);
    const codigo = document.getElementById('conceptoCodigo').value.trim();
    
    if (!descripcion) { 
        showError('La descripción es obligatoria'); 
        return; 
    }
    if (isNaN(cantidad) || cantidad <= 0) { 
        showError('La cantidad debe ser mayor a 0'); 
        return; 
    }
    if (isNaN(valorUnitario) || valorUnitario < 0) { 
        showError('El valor unitario no puede ser negativo'); 
        return; 
    }
    
    const concepto = {
        codigo: codigo,
        descripcion: descripcion,
        cantidad: cantidad,
        valorUnitario: valorUnitario,
        importe: cantidad * valorUnitario
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
        tbody.innerHTML = `<tr id="filaConceptoVacia"><td colspan="6" style="padding: 40px; text-align: center; color: #999;"><i class="fas fa-info-circle"></i> No hay conceptos agregados<\/td><\/tr>`;
        return;
    }
    
    let html = '';
    for (let i = 0; i < conceptos.length; i++) {
        const c = conceptos[i];
        html += `<tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">${c.codigo || '-'}<\/td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">${c.descripcion}<\/td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${c.cantidad.toFixed(2)}<\/td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${formatCurrency(c.valorUnitario)}<\/td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;"><strong>${formatCurrency(c.importe)}<\/strong><\/td>
            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; margin-right: 15px; font-size: 16px;" onclick="abrirModalConcepto(${i})"><\/i>
                <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 16px;" onclick="eliminarConcepto(${i})"><\/i>
            <\/td>
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
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            conceptos.splice(index, 1);
            actualizarTablaConceptos();
            actualizarResumen();
            showSuccess('Concepto eliminado');
        }
    });
}

function actualizarResumen() {
    let subtotal = 0;
    for (let i = 0; i < conceptos.length; i++) {
        subtotal += conceptos[i].importe;
    }
    const iva = subtotal * 0.16;
    const total = subtotal + iva;
    
    document.getElementById('resumenSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('resumenIVA').textContent = formatCurrency(iva);
    document.getElementById('resumenTotal').textContent = formatCurrency(total);
}

function guardarFactura(timbrar = false) {
    const contacto_id = document.getElementById('contacto_id').value;
    const cat_serie_id = document.getElementById('cat_serie_id').value;
    const uso_cfdi = document.getElementById('uso_cfdi').value;
    const forma_pago = document.getElementById('forma_pago').value;
    const metodo_pago = document.getElementById('metodo_pago').value;
    
    if (!contacto_id) { 
        showError('Seleccione un cliente'); 
        return; 
    }
    if (!cat_serie_id) { 
        showError('Seleccione una serie'); 
        return; 
    }
    if (!uso_cfdi) { 
        showError('Seleccione un uso de CFDI'); 
        return; 
    }
    if (!forma_pago) { 
        showError('Seleccione una forma de pago'); 
        return; 
    }
    if (!metodo_pago) { 
        showError('Seleccione un método de pago'); 
        return; 
    }
    if (conceptos.length === 0) { 
        showError('Agregue al menos un concepto'); 
        return; 
    }
    
    showLoading(true);
    
    const data = {
        contacto_id: parseInt(contacto_id),
        cat_serie_id: parseInt(cat_serie_id),
        proyecto_id: document.getElementById('proyecto_id').value || null,
        fecha: document.getElementById('fecha').value,
        fecha_vencimiento: document.getElementById('fecha_vencimiento').value || null,
        moneda: document.getElementById('moneda').value,
        tipo_cambio: parseFloat(document.getElementById('tipo_cambio').value) || 1,
        satcat_uso_cfdi_clave: uso_cfdi,
        satcat_formas_pago_clave: forma_pago,
        satcat_metodos_pago_clave: metodo_pago,
        observaciones: document.getElementById('observaciones').value,
        conceptos: conceptos,
        timbrar: timbrar
    };
    
    fetch('/api/facturas', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.getElementById('csrf_token').value 
        },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            showSuccess(timbrar ? 'Factura timbrada correctamente' : 'Factura guardada correctamente');
            cerrarModalFactura();
            cargarDatos();
        } else { 
            showError(data.message || 'Error al guardar'); 
        }
    })
    .catch(err => { 
        showLoading(false); 
        console.error(err);
        showError('Error al guardar la factura'); 
    });
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { 
        showError('No hay datos para exportar'); 
        return; 
    }
    let csv = 'Estatus,Fecha,Serie,Folio,Cliente,RFC,Moneda,Subtotal,IVA,Total,Total MXN,UUID\n';
    datosFiltrados.forEach(i => {
        csv += `${getEstatusDisplay(i.estatus)},${formatDate(i.fecha)},${i.serie || '-'},${i.folio || '-'},"${i.cliente_nombre || '-'}",${i.cliente_rfc || '-'},${i.moneda || 'MXN'},${i.subtotal || 0},${i.iva || 0},${i.total || 0},${i.total_mxn || i.total || 0},${i.uuid || '-'}\n`;
    });
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `facturas_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = document.getElementById('buscador').value.toLowerCase();
    let filtrados = [...datosFacturacion];
    if (fi) filtrados = filtrados.filter(f => f.fecha >= fi);
    if (ff) filtrados = filtrados.filter(f => f.fecha <= ff);
    if (busq) filtrados = filtrados.filter(f => (f.cliente_nombre || '').toLowerCase().includes(busq) || (f.cliente_rfc || '').toLowerCase().includes(busq) || (f.folio || '').toString().includes(busq));
    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de facturación');
    
    cargarDatos();
    
    const hoy = new Date();
    const hace30 = new Date(); 
    hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
    
    document.getElementById('btnAgregar').addEventListener('click', abrirModalNuevaFactura);
    document.getElementById('btnExcel').addEventListener('click', exportToExcel);
    document.getElementById('btnCrearFiltro').addEventListener('click', () => showSuccess('Filtros avanzados en desarrollo'));
    document.getElementById('btnColumnas').addEventListener('click', () => showSuccess('Selector de columnas en desarrollo'));
    
    document.getElementById('fechaInicio').addEventListener('change', aplicarFiltros);
    document.getElementById('fechaFin').addEventListener('change', aplicarFiltros);
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
    document.getElementById('btnGuardarConcepto').addEventListener('click', guardarConcepto);
    document.getElementById('btnCancelarConcepto').addEventListener('click', cerrarModalConcepto);
    
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalNuevaFactura')) cerrarModalFactura();
        if (e.target === document.getElementById('modalConcepto')) cerrarModalConcepto();
    });
});
</script>

@endsection