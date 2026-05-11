@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Notas de Crédito -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice"></i> Notas de Crédito
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE NOTAS DE CRÉDITO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalNotas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Timbradas</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="totalTimbradas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pendientes</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalPendientes">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #dc3545; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Canceladas</div>
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
                    <h3 style="color: #6c757d;">No hay notas de crédito</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaNotasCredito" style="width: 100%; font-size: 12px;">
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
                                <th style="padding: 12px 6px;">Factura Relacionada</th>
                                <th style="padding: 12px 6px;">Motivo</th>
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
                                <td colspan="4"></td>
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

<!-- MODAL NUEVA NOTA DE CRÉDITO -->
<div id="modalNuevaNota" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 2% auto; width: 95%; max-width: 800px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Nueva Nota de Crédito</span>
            </div>
            <button id="cerrarModal" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <form id="formNuevaNota">
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
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
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Factura Relacionada *</label>
                        <select id="factura_relacionada_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar factura...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Serie *</label>
                        <select id="cat_serie_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar serie...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha *</label>
                        <input type="date" id="fecha" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Moneda</label>
                        <select id="moneda" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="MXN">MXN - Peso Mexicano</option>
                            <option value="USD">USD - Dólar Americano</option>
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Motivo de la Nota de Crédito *</label>
                        <textarea id="motivo" rows="2" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" placeholder="Ej: Devolución de mercancía, Descuento, Ajuste de precio, etc."></textarea>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                        <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" placeholder="Observaciones adicionales (opcional)"></textarea>
                    </div>
                </div>
                
                <!-- Información de la factura seleccionada -->
                <div id="infoSaldoFactura" style="display: none;"></div>
                
                <!-- Conceptos de la factura (SOLO LECTURA) -->
                <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; margin-top: 20px;">
                    <h3 style="margin: 0 0 15px 0; color: #083CAE;">
                        <i class="fas fa-list"></i> Conceptos de la factura original
                    </h3>
                    <div style="border: 1px solid #ddd; border-radius: 8px; overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background-color: #f5f5f5;">
                                <tr>
                                    <th style="padding: 12px; text-align: left;">Código</th>
                                    <th style="padding: 12px; text-align: left;">Descripción</th>
                                    <th style="padding: 12px; text-align: right;">Cantidad</th>
                                    <th style="padding: 12px; text-align: right;">Valor Unitario</th>
                                    <th style="padding: 12px; text-align: right;">Importe</th>
                                </tr>
                            </thead>
                            <tbody id="tablaConceptosFactura">
                                <tr id="filaConceptoVacia">
                                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                                        <i class="fas fa-info-circle"></i> Seleccione una factura para ver sus conceptos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Totales de la nota -->
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 20px; border-radius: 8px; margin-top: 20px;">
                        <div style="display: flex; justify-content: flex-end; gap: 30px; flex-wrap: wrap;">
                            <div style="text-align: right;">
                                <div style="color: #666; font-size: 14px;">Monto acreditar:</div>
                                <div style="font-size: 22px; font-weight: bold; color: #28a745;" id="resumenTotal">$0.00</div>
                            </div>
                            <div style="text-align: right; padding-left: 30px; border-left: 2px solid #ccc;">
                                <div style="color: #666; font-size: 14px;">Saldo restante:</div>
                                <div style="font-size: 22px; font-weight: bold; color: #083CAE;" id="saldoRestante">$0.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button id="btnCancelar" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardarNota" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar
            </button>
            <button id="btnTimbrar" style="background-color: #ffc107; color: #333; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-stamp"></i> Guardar y Timbrar
            </button>
        </div>
    </div>
</div>

<!-- MODAL PARA MONTO A CREDITAR -->
<div id="modalMonto" style="display: none; position: fixed; z-index: 10003; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: white; margin: 15% auto; width: 90%; max-width: 450px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0;">Monto a Creditar</h3>
        </div>
        <div style="padding: 25px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Monto acreditar *</label>
                <input type="number" id="montoACreditar" step="0.01" min="0" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <small id="maxMontoMsg" style="color: #6c757d;"></small>
            </div>
            <div class="info-monto" style="background: #e3f2fd; padding: 10px; border-radius: 6px; margin-bottom: 15px;">
                <small><strong>Saldo disponible:</strong> <span id="saldoDisponibleSpan">$0.00</span></small>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button id="btnCancelarMonto" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Cancelar</button>
                <button id="btnAplicarMonto" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Aplicar</button>
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
    .badge-timbrada { background-color: #28a745; color: white; }
    .badge-pendiente { background-color: #ffc107; color: #333; }
    .badge-cancelada { background-color: #dc3545; color: white; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    
    .info-saldo {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        border-left: 4px solid #28a745;
    }
    
    .btn-credito {
        background-color: #083CAE;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        margin-right: 10px;
    }
    
    .btn-credito:hover {
        background-color: #0a4bc9;
    }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let datosNotas = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;
let facturaSeleccionada = null;
let saldoDisponible = 0;
let totalFactura = 0;
let totalNotasAplicadas = 0;

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
    const map = { 19: 'badge-timbrada', 1: 'badge-pendiente', 21: 'badge-cancelada' };
    return map[estatus] || 'badge-pendiente';
}

function getEstatusDisplay(estatus) {
    const map = { 19: 'Timbrada', 1: 'Pendiente', 21: 'Cancelada' };
    return map[estatus] || 'Pendiente';
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
    
    const params = new URLSearchParams();
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busqueda = document.getElementById('buscador').value;
    
    if (fi) params.append('fecha_inicio', fi);
    if (ff) params.append('fecha_fin', ff);
    if (busqueda) params.append('search', busqueda);
    
    fetch('/notas-credito/data?' + params.toString())
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosNotas = response.data;
                datosFiltrados = [...datosNotas];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosNotas = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, timbradas: 0, pendientes: 0, canceladas: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosNotas = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, timbradas: 0, pendientes: 0, canceladas: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalNotas').textContent = stats.total || 0;
    document.getElementById('totalTimbradas').textContent = stats.timbradas || 0;
    document.getElementById('totalPendientes').textContent = stats.pendientes || 0;
    document.getElementById('totalCanceladas').textContent = stats.canceladas || 0;
}

function calcularTotales(datos) {
    let subtotal = 0, iva = 0, total = 0;
    datos.forEach(item => {
        subtotal += parseFloat(item.subtotal || 0);
        iva += parseFloat(item.iva || 0);
        total += parseFloat(item.total || 0);
    });
    document.getElementById('sumSubtotal').textContent = formatCurrency(Math.abs(subtotal));
    document.getElementById('sumIva').textContent = formatCurrency(Math.abs(iva));
    document.getElementById('sumTotal').textContent = formatCurrency(Math.abs(total));
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
        const badgeClass = getBadgeClass(item.estatus);
        const estatusDisplay = getEstatusDisplay(item.estatus);
        
        row.innerHTML = `
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${badgeClass}">${estatusDisplay}</span></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 6px;">${item.serie || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px;">${item.cliente_nombre || '-'}</td>
            <td style="padding: 10px 6px;">${item.cliente_rfc || '-'}</td>
            <td style="padding: 10px 6px; text-align: center;">${item.moneda || 'MXN'}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(Math.abs(item.subtotal || 0))}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(Math.abs(item.iva || 0))}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(Math.abs(item.total || 0))}</strong></td>
            <td style="padding: 10px 6px;">${item.factura_relacionada_serie ? item.factura_relacionada_serie + '-' + item.factura_relacionada_folio : '-'}</td>
            <td style="padding: 10px 6px; max-width: 200px; white-space: normal;">${item.motivo_nota_credito || '-'}</td>
            <td style="padding: 10px 6px; font-size: 10px;">${item.uuid ? item.uuid.substring(0, 16) + '...' : '-'}</td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" title="Ver" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer;" title="PDF" data-id="${item.factura_id}"></i>
                    <i class="fas fa-file-code" style="color: #17a2b8; cursor: pointer;" title="XML" data-id="${item.factura_id}"></i>
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer;" title="Eliminar" data-id="${item.factura_id}"></i>
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verNota(el.dataset.id)));
    document.querySelectorAll('.fa-file-pdf').forEach(el => el.addEventListener('click', () => window.open(`/notas-credito/${el.dataset.id}/pdf`, '_blank')));
    document.querySelectorAll('.fa-file-code').forEach(el => el.addEventListener('click', () => showSuccess('XML en desarrollo')));
    document.querySelectorAll('.fa-trash-alt').forEach(el => el.addEventListener('click', () => eliminarNota(el.dataset.id)));
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

function verNota(id) {
    fetch(`/notas-credito/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const facturaInfo = data.data.info_factura || {};
                Swal.fire({
                    title: `Nota de Crédito ${data.data.serie}-${data.data.folio}`,
                    html: `<div style="text-align:left;">
                        <p><strong>Cliente:</strong> ${data.data.cliente_nombre}</p>
                        <p><strong>RFC:</strong> ${data.data.cliente_rfc}</p>
                        <p><strong>Fecha:</strong> ${formatDate(data.data.fecha)}</p>
                        <p><strong>Motivo:</strong> ${data.data.motivo_nota_credito}</p>
                        <p><strong>Factura Relacionada:</strong> ${data.data.factura_relacionada_serie}-${data.data.factura_relacionada_folio || '-'}</p>
                        <p><strong>Subtotal:</strong> ${formatCurrency(Math.abs(data.data.subtotal))}</p>
                        <p><strong>IVA:</strong> ${formatCurrency(Math.abs(data.data.iva))}</p>
                        <p><strong>Total:</strong> ${formatCurrency(Math.abs(data.data.total))}</p>
                        <p><strong>Estatus:</strong> <span class="badge ${getBadgeClass(data.data.estatus)}">${getEstatusDisplay(data.data.estatus)}</span></p>
                    </div>`,
                    width: '500px',
                    confirmButtonColor: '#083CAE'
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

function eliminarNota(id) {
    Swal.fire({
        title: '¿Eliminar nota de crédito?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/notas-credito/${id}`, { 
                method: 'DELETE', 
                headers: { 'X-CSRF-TOKEN': document.getElementById('csrf_token').value } 
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Nota de crédito eliminada');
                        cargarDatos();
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => showError('Error al eliminar'));
        }
    });
}

// ============================================
// MODALES
// ============================================
function abrirModalNuevaNota() {
    const modal = document.getElementById('modalNuevaNota');
    if (!modal) return;
    
    document.getElementById('formNuevaNota').reset();
    facturaSeleccionada = null;
    saldoDisponible = 0;
    totalFactura = 0;
    totalNotasAplicadas = 0;
    document.getElementById('resumenTotal').textContent = formatCurrency(0);
    document.getElementById('saldoRestante').textContent = formatCurrency(0);
    document.getElementById('infoSaldoFactura').style.display = 'none';
    document.getElementById('tablaConceptosFactura').innerHTML = `
        <tr id="filaConceptoVacia">
            <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                <i class="fas fa-info-circle"></i> Seleccione una factura para ver sus conceptos
            <\/td>
        <\/tr>
    `;
    
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;
    
    cargarCombos();
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModalNota() {
    const modal = document.getElementById('modalNuevaNota');
    if (modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
}

function abrirModalMonto() {
    if (!facturaSeleccionada) {
        showError('Primero seleccione una factura');
        return;
    }
    
    const modal = document.getElementById('modalMonto');
    if (!modal) return;
    
    document.getElementById('montoACreditar').value = '';
    document.getElementById('saldoDisponibleSpan').innerHTML = formatCurrency(saldoDisponible);
    document.getElementById('maxMontoMsg').innerHTML = `Máximo: ${formatCurrency(saldoDisponible)}`;
    modal.style.display = 'block';
}

function cerrarModalMonto() {
    const modal = document.getElementById('modalMonto');
    if (modal) modal.style.display = 'none';
}

function aplicarMonto() {
    let monto = parseFloat(document.getElementById('montoACreditar').value);
    
    if (isNaN(monto) || monto <= 0) {
        showError('Ingrese un monto válido');
        return;
    }
    
    if (monto > saldoDisponible) {
        showError(`El monto no puede exceder el saldo disponible (${formatCurrency(saldoDisponible)})`);
        return;
    }
    
    if (monto > totalFactura) {
        showError(`El monto (${formatCurrency(monto)}) no puede exceder el total de la factura (${formatCurrency(totalFactura)})`);
        return;
    }
    
    // Verificar que el saldo restante no sea negativo
    const nuevoSaldoRestante = saldoDisponible - monto;
    if (nuevoSaldoRestante < 0) {
        showError(`El monto (${formatCurrency(monto)}) excede el saldo disponible (${formatCurrency(saldoDisponible)})`);
        return;
    }
    
    document.getElementById('resumenTotal').textContent = formatCurrency(monto);
    document.getElementById('saldoRestante').textContent = formatCurrency(nuevoSaldoRestante);
    cerrarModalMonto();
    
    showSuccess(`Monto acreditar: ${formatCurrency(monto)}`);
}

function cargarCombos() {
    // Proyectos
    fetch('/api/proyectos/activos')
        .then(r => r.json()).then(data => {
            const select = document.getElementById('proyecto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
                data.forEach(p => select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`);
            }
        }).catch(e => console.error('Error proyectos:', e));
    
    // Clientes
    fetch('/api/contactos')
        .then(r => r.json()).then(data => {
            const select = document.getElementById('contacto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                data.forEach(c => {
                    select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`;
                });
                select.onchange = function() { cargarFacturasRelacionadas(this.value); };
            }
        }).catch(e => console.error('Error clientes:', e));
    
    // Series para notas de crédito
    fetch('/api/series-nota-credito')
        .then(r => r.json()).then(data => {
            const select = document.getElementById('cat_serie_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar serie...</option>';
                data.forEach(s => {
                    select.innerHTML += `<option value="${s.cat_serie_id}">${s.serie} - ${s.descripcion}</option>`;
                });
            }
        }).catch(e => console.error('Error series:', e));
}

function cargarFacturasRelacionadas(clienteId) {
    const selectFactura = document.getElementById('factura_relacionada_id');
    if (!clienteId) {
        selectFactura.innerHTML = '<option value="">Primero seleccione un cliente...</option>';
        return;
    }
    
    showLoading(true);
    fetch(`/api/facturas-para-nota-credito?cliente_id=${clienteId}`)
        .then(r => r.json())
        .then(data => {
            if (selectFactura) {
                if (Array.isArray(data) && data.length > 0) {
                    selectFactura.innerHTML = '<option value="">Seleccionar factura...</option>';
                    data.forEach(f => {
                        const saldoMostrar = f.saldo_restante || f.saldo_disponible || f.total;
                        selectFactura.innerHTML += `<option value="${f.factura_id}" 
                            data-total="${f.total}"
                            data-saldo="${saldoMostrar}"
                            data-cliente="${f.cliente_nombre}">
                            ${f.serie}-${f.folio} | ${f.cliente_nombre} | 
                            Total: $${parseFloat(f.total).toFixed(2)} | 
                            Saldo: $${parseFloat(saldoMostrar).toFixed(2)}
                        </option>`;
                    });
                    
                    selectFactura.onchange = function() {
                        const option = this.options[this.selectedIndex];
                        if (this.value) {
                            const total = parseFloat(option.dataset.total);
                            const saldo = parseFloat(option.dataset.saldo);
                            const cliente = option.dataset.cliente;
                            cargarDetalleFactura(this.value, total, saldo, cliente);
                        }
                    };
                } else {
                    selectFactura.innerHTML = '<option value="">No hay facturas disponibles con saldo pendiente</option>';
                }
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            selectFactura.innerHTML = '<option value="">Error al cargar facturas</option>';
            showLoading(false);
        });
}

function cargarDetalleFactura(facturaId, total, saldo, cliente) {
    showLoading(true);
    
    // Guardar datos de la factura
    facturaSeleccionada = facturaId;
    totalFactura = total;
    saldoDisponible = saldo;
    
    // Obtener detalles de la factura incluyendo conceptos
    fetch(`/facturacion/${facturaId}`)
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Calcular notas aplicadas
                totalNotasAplicadas = totalFactura - saldoDisponible;
                
                // Mostrar información del saldo
                const infoDiv = document.getElementById('infoSaldoFactura');
                const porcentajeRestante = (saldoDisponible / totalFactura) * 100;
                const colorBarra = porcentajeRestante > 30 ? '#28a745' : (porcentajeRestante > 10 ? '#ffc107' : '#dc3545');
                
                infoDiv.style.display = 'block';
                infoDiv.innerHTML = `
                    <div class="info-saldo">
                        <strong>Factura seleccionada:</strong><br>
                        <strong>Cliente:</strong> ${cliente}<br>
                        <strong>Total factura:</strong> ${formatCurrency(totalFactura)}<br>
                        <strong>Notas aplicadas:</strong> ${formatCurrency(totalNotasAplicadas)}<br>
                        <strong>Saldo disponible:</strong> <span style="color: #28a745; font-weight: bold;">${formatCurrency(saldoDisponible)}</span>
                        <div style="margin-top: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                            <div style="width: ${porcentajeRestante}%; background: ${colorBarra}; height: 8px;"></div>
                        </div>
                        <small>${porcentajeRestante.toFixed(1)}% del saldo original disponible</small>
                        <div style="margin-top: 10px;">
                            <button type="button" onclick="abrirModalMonto()" class="btn-credito" style="font-size: 12px; padding: 6px 12px;">
                                <i class="fas fa-dollar-sign"></i> Especificar monto acreditar (Máx: ${formatCurrency(saldoDisponible)})
                            </button>
                        </div>
                    </div>
                `;
                
                // Mostrar conceptos de la factura (solo lectura)
                const tbodyConceptos = document.getElementById('tablaConceptosFactura');
                if (data.conceptos && data.conceptos.length > 0) {
                    let html = '';
                    for (let i = 0; i < data.conceptos.length; i++) {
                        const concepto = data.conceptos[i];
                        const cantidad = parseFloat(concepto.cantidad) || 0;
                        const valorUnitario = parseFloat(concepto.valor_unitario) || 0;
                        const importe = parseFloat(concepto.importe) || 0;
                        
                        html += `<tr>
                            <td style="padding: 10px;">${concepto.codigo || '-'}</td>
                            <td style="padding: 10px;">${concepto.descripcion || '-'}</td>
                            <td style="padding: 10px; text-align: right;">${cantidad.toFixed(2)}</td>
                            <td style="padding: 10px; text-align: right;">${formatCurrency(valorUnitario)}</td>
                            <td style="padding: 10px; text-align: right;">${formatCurrency(importe)}</td>
                        </tr>`;
                    }
                    tbodyConceptos.innerHTML = html;
                } else {
                    tbodyConceptos.innerHTML = `
                        <tr>
                            <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                                <i class="fas fa-info-circle"></i> La factura no tiene conceptos registrados
                            </td>
                        </tr>
                    `;
                }
                
                // Actualizar totales
                document.getElementById('resumenTotal').textContent = formatCurrency(0);
                document.getElementById('saldoRestante').textContent = formatCurrency(saldoDisponible);
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            showLoading(false);
            showError('Error al cargar los detalles de la factura');
        });
}

function guardarNota(timbrar = false) {
    // Verificar que todos los elementos existan
    const contacto_id_elem = document.getElementById('contacto_id');
    const cat_serie_id_elem = document.getElementById('cat_serie_id');
    const factura_relacionada_id_elem = document.getElementById('factura_relacionada_id');
    const motivo_elem = document.getElementById('motivo');
    const resumenTotal_elem = document.getElementById('resumenTotal');
    const proyecto_id_elem = document.getElementById('proyecto_id');
    const fecha_elem = document.getElementById('fecha');
    const moneda_elem = document.getElementById('moneda');
    const observaciones_elem = document.getElementById('observaciones');
    const csrf_token_elem = document.getElementById('csrf_token');
    
    // Validar elementos requeridos
    if (!contacto_id_elem || !cat_serie_id_elem || !factura_relacionada_id_elem || !motivo_elem || !resumenTotal_elem) {
        showError('Error: Elementos del formulario no encontrados');
        return;
    }
    
    const contacto_id = contacto_id_elem.value;
    const cat_serie_id = cat_serie_id_elem.value;
    const factura_relacionada_id = factura_relacionada_id_elem.value;
    const motivo = motivo_elem.value?.trim() || '';
    const montoTexto = resumenTotal_elem.textContent;
    const monto = parseFloat(montoTexto.replace(/[^0-9.-]+/g, ''));
    
    if (!contacto_id) { 
        showError('Seleccione un cliente'); 
        return; 
    }
    if (!cat_serie_id) { 
        showError('Seleccione una serie'); 
        return; 
    }
    if (!factura_relacionada_id) { 
        showError('Seleccione una factura relacionada'); 
        return; 
    }
    if (!motivo) { 
        showError('Escriba el motivo de la nota de crédito'); 
        return; 
    }
    if (!monto || monto <= 0) { 
        showError('Especifique el monto a acreditar usando el botón "Especificar monto acreditar"');
        return; 
    }
    
    if (monto > saldoDisponible) {
        showError(`El monto (${formatCurrency(monto)}) excede el saldo disponible (${formatCurrency(saldoDisponible)}). El máximo permitido es ${formatCurrency(saldoDisponible)}`);
        return;
    }
    
    if (monto > totalFactura) {
        showError(`El monto (${formatCurrency(monto)}) no puede exceder el total de la factura (${formatCurrency(totalFactura)})`);
        return;
    }
    
    showLoading(true);
    
    // Crear un concepto único para la nota de crédito
    const conceptos = [{
        codigo: '001',
        descripcion: `Nota de crédito por: ${motivo.substring(0, 100)}`,
        cantidad: 1,
        valorUnitario: monto,
        importe: monto
    }];
    
    const data = {
        contacto_id: parseInt(contacto_id),
        cat_serie_id: parseInt(cat_serie_id),
        factura_relacionada_id: parseInt(factura_relacionada_id),
        proyecto_id: proyecto_id_elem?.value || null,
        fecha: fecha_elem?.value || new Date().toISOString().split('T')[0],
        moneda: moneda_elem?.value || 'MXN',
        motivo: motivo,
        observaciones: observaciones_elem?.value || '',
        conceptos: conceptos,
        timbrar: timbrar
    };
    
    fetch('/api/notas-credito', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': csrf_token_elem?.value || '',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(data => {
        showLoading(false);
        if (data.success) {
            const mensaje = timbrar ? 'Nota de crédito timbrada correctamente' : 'Nota de crédito guardada correctamente';
            showSuccess(mensaje);
            cerrarModalNota();
            cargarDatos();
        } else { 
            showError(data.message || 'Error al guardar'); 
        }
    })
    .catch(err => { 
        showLoading(false); 
        console.error('Error:', err);
        showError('Error al guardar la nota de crédito: ' + (err.message || 'Error desconocido')); 
    });
}

function exportToExcel() {
    if (datosFiltrados.length === 0) { 
        showError('No hay datos para exportar'); 
        return; 
    }
    
    let csv = 'Estatus,Fecha,Serie,Folio,Cliente,RFC,Moneda,Subtotal,IVA,Total,Factura Relacionada,Motivo,UUID\n';
    datosFiltrados.forEach(i => {
        csv += `${getEstatusDisplay(i.estatus)},`;
        csv += `${formatDate(i.fecha)},`;
        csv += `${i.serie || '-'},`;
        csv += `${i.folio || '-'},`;
        csv += `"${i.cliente_nombre || '-'}",`;
        csv += `${i.cliente_rfc || '-'},`;
        csv += `${i.moneda || 'MXN'},`;
        csv += `${Math.abs(i.subtotal || 0)},`;
        csv += `${Math.abs(i.iva || 0)},`;
        csv += `${Math.abs(i.total || 0)},`;
        csv += `${i.factura_relacionada_serie || '-'}-${i.factura_relacionada_folio || '-'},`;
        csv += `"${i.motivo_nota_credito || '-'}",`;
        csv += `${i.uuid || '-'}\n`;
    });
    
    const blob = new Blob(["\uFEFF" + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `notas_credito_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    URL.revokeObjectURL(link.href);
    showSuccess('Exportación completada');
}

function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busq = document.getElementById('buscador').value.toLowerCase();
    
    let filtrados = [...datosNotas];
    
    if (fi) {
        filtrados = filtrados.filter(f => f.fecha >= fi);
    }
    if (ff) {
        filtrados = filtrados.filter(f => f.fecha <= ff);
    }
    if (busq) {
        filtrados = filtrados.filter(f => 
            (f.cliente_nombre || '').toLowerCase().includes(busq) ||
            (f.cliente_rfc || '').toLowerCase().includes(busq) ||
            (f.folio || '').toString().includes(busq) ||
            (f.motivo_nota_credito || '').toLowerCase().includes(busq)
        );
    }
    
    datosFiltrados = filtrados;
    currentPage = 1;
    cargarTabla();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de notas de crédito');
    
    cargarDatos();
    
    const hoy = new Date();
    const hace30 = new Date(); 
    hace30.setDate(hoy.getDate() - 30);
    document.getElementById('fechaInicio').value = hace30.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
    
    // Botones principales
    document.getElementById('btnAgregar').addEventListener('click', abrirModalNuevaNota);
    document.getElementById('btnExcel').addEventListener('click', exportToExcel);
    document.getElementById('btnCrearFiltro').addEventListener('click', () => showSuccess('Filtros avanzados en desarrollo'));
    document.getElementById('btnColumnas').addEventListener('click', () => showSuccess('Selector de columnas en desarrollo'));
    
    // Filtros
    document.getElementById('fechaInicio').addEventListener('change', aplicarFiltros);
    document.getElementById('fechaFin').addEventListener('change', aplicarFiltros);
    document.getElementById('buscador').addEventListener('input', aplicarFiltros);
    
    // Paginación
    document.getElementById('btnPrimeraPagina').addEventListener('click', () => { currentPage = 1; cargarTabla(); });
    document.getElementById('btnAnteriorPagina').addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarTabla(); } });
    document.getElementById('btnSiguientePagina').addEventListener('click', () => { const max = Math.ceil(datosFiltrados.length / rowsPerPage); if (currentPage < max) { currentPage++; cargarTabla(); } });
    document.getElementById('btnUltimaPagina').addEventListener('click', () => { currentPage = Math.ceil(datosFiltrados.length / rowsPerPage); cargarTabla(); });
    
    // Modales
    document.getElementById('cerrarModal').addEventListener('click', cerrarModalNota);
    document.getElementById('btnCancelar').addEventListener('click', cerrarModalNota);
    document.getElementById('btnGuardarNota').addEventListener('click', () => guardarNota(false));
    document.getElementById('btnTimbrar').addEventListener('click', () => guardarNota(true));
    document.getElementById('btnCancelarMonto').addEventListener('click', cerrarModalMonto);
    document.getElementById('btnAplicarMonto').addEventListener('click', aplicarMonto);
    
    // Cerrar modales al hacer clic fuera
    window.addEventListener('click', (e) => {
        if (e.target === document.getElementById('modalNuevaNota')) cerrarModalNota();
        if (e.target === document.getElementById('modalMonto')) cerrarModalMonto();
    });
});
</script>

@endsection