@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-hand-holding-usd"></i> Factoraje
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ESTADÍSTICAS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Total Solicitudes</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold;" id="totalSolicitudes">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #ffc107; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Solicitados</div>
                            <div style="color: #ffc107; font-size: 36px; font-weight: bold;" id="totalSolicitados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #17a2b8; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Autorizados</div>
                            <div style="color: #17a2b8; font-size: 36px; font-weight: bold;" id="totalAutorizados">0</div>
                        </div>
                    </div>
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #28a745; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px;">Monto Total</div>
                            <div style="color: #28a745; font-size: 36px; font-weight: bold;" id="montoTotal">$0.00</div>
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
                            <input type="date" id="fechaInicio" class="form-control" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" class="form-control" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <button id="btnAgregar" class="btn btn-primary" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" class="btn btn-success" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div>
                            <button id="btnColumnas" class="btn btn-secondary" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer;">
                                <i class="fas fa-columns"></i> Columnas
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="buscador" class="form-control" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
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
                    <i class="fas fa-hand-holding-usd" style="font-size: 64px; color: #dee2e6;"></i>
                    <h3 style="color: #6c757d;">No hay solicitudes de factoraje</h3>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;" id="tablaContainer">
                    <table class="table table-bordered table-hover" id="tablaFactoraje" style="width: 100%; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background-color: #083CAE; color: white; z-index: 10;">
                            <tr>
                                <th style="padding: 12px 6px; text-align: center;">Folio</th>
                                <th style="padding: 12px 6px; text-align: center;">Fecha</th>
                                <th style="padding: 12px 6px;">Cliente</th>
                                <th style="padding: 12px 6px;">Factor</th>
                                <th style="padding: 12px 6px; text-align: right;">Monto Factura</th>
                                <th style="padding: 12px 6px; text-align: right;">Anticipo</th>
                                <th style="padding: 12px 6px; text-align: right;">Comisión</th>
                                <th style="padding: 12px 6px; text-align: right;">Monto Recibir</th>
                                <th style="padding: 12px 6px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 6px; text-align: center; position: sticky; right: 0; background-color: #083CAE; z-index: 20;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot style="position: sticky; bottom: 0; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; text-align: right;">TOTALES:</td>
                                <td style="padding: 10px; text-align: right;" id="sumMonto">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumAnticipo">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumComision">$0.00</td>
                                <td style="padding: 10px; text-align: right;" id="sumRecibir">$0.00</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" class="btn btn-link" style="background: transparent; border: none; color: #083CAE; cursor: pointer;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button id="btnPrimeraPagina" class="btn btn-sm" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button id="btnAnteriorPagina" class="btn btn-sm" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span style="padding: 5px 12px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaActual">1</span>
                        <span id="paginacionInfo" style="color: #666; font-size: 12px;">Mostrando 0-0 de 0 registros</span>
                        <button id="btnSiguientePagina" class="btn btn-sm" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button id="btnUltimaPagina" class="btn btn-sm" style="border: none; background: none; color: #083CAE; cursor: pointer;">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVA SOLICITUD -->
<div id="modalNuevaSolicitud" style="display: none; position: fixed; z-index: 10001; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow-y: auto;">
    <div style="background-color: white; margin: 3% auto; width: 95%; max-width: 900px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-plus-circle" style="font-size: 24px; margin-right: 10px;"></i>
                <span style="font-size: 20px; font-weight: bold;">Nueva Solicitud de Factoraje</span>
            </div>
            <button id="cerrarModal" style="background: none; border: none; color: white; font-size: 32px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 25px; max-height: 70vh; overflow-y: auto;">
            <form id="formNuevaSolicitud">
                @csrf
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Factor Financiero *</label>
                        <select id="factor_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar factor...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente *</label>
                        <select id="contacto_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Seleccionar cliente...</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Solicitud *</label>
                        <input type="date" id="fecha_solicitud" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Porcentaje Anticipo (%)</label>
                        <input type="number" id="porcentaje_anticipo" class="form-control" step="0.01" value="85" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Facturas a Factorar *</label>
                        <div id="facturasContainer" style="border: 1px solid #ddd; border-radius: 6px; padding: 10px; max-height: 200px; overflow-y: auto;">
                            <div id="facturasList"></div>
                            <div id="noFacturasMsg" style="text-align: center; padding: 20px; color: #999;">
                                Seleccione un cliente para ver facturas disponibles
                            </div>
                        </div>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                            <h4 style="margin: 0 0 10px 0; color: #083CAE;">Resumen de la Solicitud</h4>
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                                <div><strong>Monto Total Facturas:</strong> <span id="resumenMontoFacturas">$0.00</span></div>
                                <div><strong>Anticipo:</strong> <span id="resumenAnticipo">$0.00</span></div>
                                <div><strong>Comisión:</strong> <span id="resumenComision">$0.00</span></div>
                                <div><strong>IVA Comisión:</strong> <span id="resumenIVAComision">$0.00</span></div>
                                <div><strong>Total Recibir:</strong> <span id="resumenTotalRecibir" style="color: #28a745; font-weight: bold;">$0.00</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                        <textarea id="observaciones" class="form-control" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                    </div>
                </div>
            </form>
        </div>
        
        <div style="padding: 20px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px;">
            <button id="btnCancelar" class="btn btn-secondary" style="background-color: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer;">
                <i class="fas fa-save"></i> Guardar Solicitud
            </button>
        </div>
    </div>
</div>

<!-- MODAL DETALLES -->
<div id="modalDetalles" style="display: none; position: fixed; z-index: 10002; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: white; margin: 5% auto; width: 90%; max-width: 700px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #083CAE 0%, #0a4bc9 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 id="detalleTitulo" style="margin: 0;">Detalles de Solicitud</h3>
        </div>
        <div style="padding: 25px;" id="detalleContenido">
            <!-- Contenido dinámico -->
        </div>
        <div style="padding: 20px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCerrarDetalles" class="btn btn-secondary" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Cerrar</button>
            <button id="btnAutorizar" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Autorizar</button>
            <button id="btnRechazar" class="btn btn-danger" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Rechazar</button>
            <button id="btnLiquidar" class="btn btn-warning" style="background-color: #ffc107; color: #333; border: none; padding: 10px 20px; border-radius: 6px;">Liquidar</button>
        </div>
    </div>
</div>

<!-- MODAL LIQUIDACIÓN -->
<div id="modalLiquidacion" style="display: none; position: fixed; z-index: 10003; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: white; margin: 15% auto; width: 90%; max-width: 500px; border-radius: 12px;">
        <div style="background: linear-gradient(135deg, #ffc107 0%, #ffca28 100%); color: #333; padding: 15px 20px; border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0;">Liquidar Factoraje</h3>
        </div>
        <div style="padding: 25px;">
            <div class="form-group mb-3">
                <label>Fecha de Liquidación *</label>
                <input type="date" id="fecha_liquidacion" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div class="form-group mb-3">
                <label>Referencia de Pago</label>
                <input type="text" id="referencia_pago" class="form-control" placeholder="Número de transferencia, cheque, etc." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
        </div>
        <div style="padding: 20px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarLiquidacion" class="btn btn-secondary" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Cancelar</button>
            <button id="btnConfirmarLiquidacion" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px;">Confirmar Liquidación</button>
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
    
    .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
    .badge-solicitado { background-color: #ffc107; color: #333; }
    .badge-autorizado { background-color: #17a2b8; color: white; }
    .badge-liquidado { background-color: #28a745; color: white; }
    .badge-rechazado { background-color: #dc3545; color: white; }
    .badge-vencido { background-color: #6c757d; color: white; }
    
    .table td { padding: 10px 6px; vertical-align: middle; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e3f2fd; }
    
    .factura-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee; cursor: pointer; }
    .factura-item:hover { background-color: #f0f7ff; }
    .factura-item.selected { background-color: #e3f2fd; border-left: 3px solid #083CAE; }
    
    @media (max-width: 768px) {
        div[style*="grid-template-columns: repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }
    }

    /* Agrega esto al final del bloque <style> */
.factura-no-disponible {
    opacity: 0.6;
    cursor: not-allowed;
    background-color: #f8f9fa;
}

.factura-no-disponible:hover {
    background-color: #f8f9fa !important;
}

.text-danger {
    color: #dc3545;
    font-size: 11px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let datosFactoraje = [];
let datosFiltrados = [];
let currentPage = 1;
const rowsPerPage = 10;
let facturasDisponibles = [];
let facturasSeleccionadas = [];
let solicitudActualId = null;

// Mapa de estatus
const ESTATUS = {
    SOLICITADO: 1,
    AUTORIZADO: 2,
    LIQUIDADO: 3,
    RECHAZADO: 4,
    VENCIDO: 5
};

// ============================================
// UTILIDADES
// ============================================
function formatCurrency(amount) {
    if (amount === null || amount === undefined) amount = 0;
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(amount);
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
    const map = {
        [ESTATUS.SOLICITADO]: 'badge-solicitado',
        [ESTATUS.AUTORIZADO]: 'badge-autorizado',
        [ESTATUS.LIQUIDADO]: 'badge-liquidado',
        [ESTATUS.RECHAZADO]: 'badge-rechazado',
        [ESTATUS.VENCIDO]: 'badge-vencido'
    };
    return map[estatus] || 'badge-solicitado';
}

function getEstatusDisplay(estatus) {
    const map = {
        [ESTATUS.SOLICITADO]: 'Solicitado',
        [ESTATUS.AUTORIZADO]: 'Autorizado',
        [ESTATUS.LIQUIDADO]: 'Liquidado',
        [ESTATUS.RECHAZADO]: 'Rechazado',
        [ESTATUS.VENCIDO]: 'Vencido'
    };
    return map[estatus] || 'Solicitado';
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
    
    fetch('/factoraje/data?' + params.toString())
        .then(response => response.json())
        .then(response => {
            if (response.success && response.data) {
                datosFactoraje = response.data;
                datosFiltrados = [...datosFactoraje];
                actualizarContadores(response.stats);
                cargarTabla();
            } else {
                datosFactoraje = [];
                datosFiltrados = [];
                actualizarContadores({ total: 0, solicitados: 0, autorizados: 0, monto_total: 0 });
                cargarTabla();
            }
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            datosFactoraje = [];
            datosFiltrados = [];
            actualizarContadores({ total: 0, solicitados: 0, autorizados: 0, monto_total: 0 });
            cargarTabla();
            showLoading(false);
        });
}

function actualizarContadores(stats) {
    document.getElementById('totalSolicitudes').textContent = stats.total || 0;
    document.getElementById('totalSolicitados').textContent = stats.solicitados || 0;
    document.getElementById('totalAutorizados').textContent = stats.autorizados || 0;
    document.getElementById('montoTotal').textContent = formatCurrency(stats.monto_total || 0);
}

function calcularTotales(datos) {
    let monto = 0, anticipo = 0, comision = 0, recibir = 0;
    datos.forEach(item => {
        monto += parseFloat(item.monto_factura || 0);
        anticipo += parseFloat(item.monto_anticipo || 0);
        comision += parseFloat(item.total_comision || 0);
        recibir += parseFloat(item.monto_recibir || 0);
    });
    document.getElementById('sumMonto').textContent = formatCurrency(monto);
    document.getElementById('sumAnticipo').textContent = formatCurrency(anticipo);
    document.getElementById('sumComision').textContent = formatCurrency(comision);
    document.getElementById('sumRecibir').textContent = formatCurrency(recibir);
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
            <td style="padding: 10px 6px; text-align: center;"><strong>${item.folio || '-'}</strong></td>
            <td style="padding: 10px 6px; text-align: center;">${formatDate(item.fecha_solicitud)}</td>
            <td style="padding: 10px 6px;">${item.cliente_nombre || '-'}</td>
            <td style="padding: 10px 6px;">${item.factor_nombre || '-'}</td>
            <td style="padding: 10px 6px; text-align: right;"><strong>${formatCurrency(item.monto_factura)}</strong></td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.monto_anticipo)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.total_comision)}</td>
            <td style="padding: 10px 6px; text-align: right;">${formatCurrency(item.monto_recibir)}</td>
            <td style="padding: 10px 6px; text-align: center;"><span class="badge ${badgeClass}">${estatusDisplay}</span></td>
            <td style="padding: 10px 6px; text-align: center; background: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver detalles" data-id="${item.solicitud_id}"></i>
                    ${item.estatus === ESTATUS.SOLICITADO ? `<i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 16px;" title="Eliminar" data-id="${item.solicitud_id}"></i>` : ''}
                </div>
            </td>
        `;
    });
    
    calcularTotales(datosFiltrados);
    actualizarPaginacion(datosFiltrados.length);
    
    document.querySelectorAll('.fa-eye').forEach(el => el.addEventListener('click', () => verDetalles(el.dataset.id)));
    document.querySelectorAll('.fa-trash-alt').forEach(el => el.addEventListener('click', () => eliminarSolicitud(el.dataset.id)));
}

function actualizarPaginacion(total) {
    const totalPages = Math.ceil(total / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage + 1;
    const end = Math.min(currentPage * rowsPerPage, total);
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('paginacionInfo').textContent = `Mostrando ${total === 0 ? 0 : start}-${end} de ${total} registros`;
}

// ============================================
// CRUD DE SOLICITUDES
// ============================================
function abrirModalNuevaSolicitud() {
    const modal = document.getElementById('modalNuevaSolicitud');
    if (!modal) return;
    
    document.getElementById('formNuevaSolicitud').reset();
    facturasSeleccionadas = [];
    facturasDisponibles = [];
    document.getElementById('facturasList').innerHTML = '';
    document.getElementById('noFacturasMsg').style.display = 'block';
    document.getElementById('noFacturasMsg').innerHTML = 'Seleccione un cliente para ver facturas disponibles';
    actualizarResumen();
    
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_solicitud').value = hoy;
    
    cargarFactores();
    cargarClientesConFacturas();
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function cerrarModalSolicitud() {
    const modal = document.getElementById('modalNuevaSolicitud');
    if (modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
}

function cargarFactores() {
    fetch('/factoraje/factores')
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('factor_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar factor...</option>';
                data.forEach(f => {
                    select.innerHTML += `<option value="${f.factor_id}" data-anticipo="${f.porcentaje_anticipo_default}" data-comision="${f.comision_default}">${f.nombre} - Anticipo: ${f.porcentaje_anticipo_default}%</option>`;
                });
                
                select.onchange = function() {
                    const opt = this.options[this.selectedIndex];
                    if (opt && opt.dataset.anticipo) {
                        document.getElementById('porcentaje_anticipo').value = opt.dataset.anticipo;
                        actualizarResumen();
                    }
                };
            }
        }).catch(e => console.error('Error factores:', e));
}

function cargarClientesConFacturas() {
    fetch('/factoraje/clientes-con-facturas')
        .then(r => r.json())
        .then(data => {
            const select = document.getElementById('contacto_id');
            if (select && Array.isArray(data)) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                data.forEach(c => {
                    select.innerHTML += `<option value="${c.contacto_id}">${c.razon_social} ${c.rfc ? '- ' + c.rfc : ''}</option>`;
                });
                select.onchange = function() {
                    if (this.value) cargarFacturasDisponibles(this.value);
                    else {
                        facturasDisponibles = [];
                        mostrarFacturasDisponibles();
                    }
                };
            }
        }).catch(e => console.error('Error clientes:', e));
}

function cargarFacturasDisponibles(clienteId) {
    if (!clienteId) return;
    
    showLoading(true);
    fetch(`/factoraje/facturas-disponibles?cliente_id=${clienteId}`)
        .then(r => r.json())
        .then(data => {
            // Marcar facturas que ya están en proceso
            facturasDisponibles = (Array.isArray(data) ? data : []).map(f => ({
                ...f,
                en_factoraje: false // Por defecto, la consulta SQL ya excluye las que están en proceso
            }));
            mostrarFacturasDisponibles();
            showLoading(false);
        })
        .catch(error => {
            console.error('Error:', error);
            facturasDisponibles = [];
            mostrarFacturasDisponibles();
            showLoading(false);
        });
}

function mostrarFacturasDisponibles() {
    const container = document.getElementById('facturasList');
    const noMsg = document.getElementById('noFacturasMsg');
    
    if (!container) return;
    
    if (!facturasDisponibles || facturasDisponibles.length === 0) {
        container.innerHTML = '';
        noMsg.style.display = 'block';
        noMsg.innerHTML = 'No hay facturas disponibles para este cliente';
        return;
    }
    
    noMsg.style.display = 'none';
    
    let html = '';
    facturasDisponibles.forEach(f => {
        const isSelected = facturasSeleccionadas.some(s => s.factura_id === f.factura_id);
        const montoFactura = f.saldo_real || f.total;
        const estaEnProceso = f.en_factoraje || false;
        
        // Determinar clase CSS adicional si está en proceso
        const claseAdicional = estaEnProceso ? 'factura-no-disponible' : '';
        const onclickAction = !estaEnProceso ? `onclick='toggleFactura(${JSON.stringify(f)})'` : '';
        
        html += `
            <div class="factura-item ${isSelected ? 'selected' : ''} ${claseAdicional}" 
                 data-factura-id="${f.factura_id}" 
                 ${onclickAction}
                 style="${estaEnProceso ? 'opacity: 0.6; cursor: not-allowed; background-color: #f8f9fa;' : ''}">
                <div>
                    <strong>${f.serie || ''}${f.serie ? '-' : ''}${f.folio}</strong><br>
                    <small>Fecha: ${formatDate(f.fecha)} | Saldo: ${formatCurrency(montoFactura)}</small>
                    ${estaEnProceso ? '<br><small class="text-danger">⚠️ En proceso de factoraje</small>' : ''}
                </div>
                <div><strong>${formatCurrency(montoFactura)}</strong></div>
            </div>
        `;
    });
    container.innerHTML = html;
}

function toggleFactura(factura) {
    // Verificar si la factura ya está en proceso
    if (factura.en_factoraje) {
        Swal.fire({
            icon: 'warning',
            title: 'Factura no disponible',
            text: `La factura ${factura.serie || ''}${factura.serie ? '-' : ''}${factura.folio} ya está en proceso de factoraje o ya fue factorizada.`,
            confirmButtonColor: '#083CAE'
        });
        return;
    }
    
    const index = facturasSeleccionadas.findIndex(f => f.factura_id === factura.factura_id);
    const montoFactura = factura.saldo_real || factura.total;
    
    if (index === -1) {
        facturasSeleccionadas.push({ 
            factura_id: factura.factura_id, 
            monto: montoFactura 
        });
    } else {
        facturasSeleccionadas.splice(index, 1);
    }
    
    // Actualizar UI
    const items = document.querySelectorAll('.factura-item');
    items.forEach(item => {
        if (parseInt(item.dataset.facturaId) === factura.factura_id) {
            if (index === -1) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        }
    });
    
    actualizarResumen();
}

function actualizarResumen() {
    const montoTotal = facturasSeleccionadas.reduce((sum, f) => sum + (parseFloat(f.monto) || 0), 0);
    const porcentajeAnticipo = parseFloat(document.getElementById('porcentaje_anticipo').value) || 85;
    const anticipo = montoTotal * (porcentajeAnticipo / 100);
    const comision = montoTotal * 0.03;
    const ivaComision = comision * 0.16;
    const totalRecibir = anticipo - comision - ivaComision;
    
    document.getElementById('resumenMontoFacturas').textContent = formatCurrency(montoTotal);
    document.getElementById('resumenAnticipo').textContent = formatCurrency(anticipo);
    document.getElementById('resumenComision').textContent = formatCurrency(comision);
    document.getElementById('resumenIVAComision').textContent = formatCurrency(ivaComision);
    document.getElementById('resumenTotalRecibir').textContent = formatCurrency(totalRecibir);
}

function guardarSolicitud() {
    const factorId = document.getElementById('factor_id').value;
    const contactoId = document.getElementById('contacto_id').value;
    const fechaSolicitud = document.getElementById('fecha_solicitud').value;
    const porcentajeAnticipo = parseFloat(document.getElementById('porcentaje_anticipo').value) || 85;
    const observaciones = document.getElementById('observaciones').value;
    
    if (!factorId || !contactoId || !fechaSolicitud) {
        showError('Por favor complete todos los campos obligatorios');
        return;
    }
    
    if (facturasSeleccionadas.length === 0) {
        showError('Por favor seleccione al menos una factura');
        return;
    }
    
    const montoTotal = facturasSeleccionadas.reduce((sum, f) => sum + (parseFloat(f.monto) || 0), 0);
    
    const data = {
        factor_id: parseInt(factorId),
        contacto_id: parseInt(contactoId),
        fecha_solicitud: fechaSolicitud,
        monto_factura: montoTotal,
        porcentaje_anticipo: porcentajeAnticipo,
        observaciones: observaciones,
        facturas: facturasSeleccionadas.map(f => ({ factura_id: f.factura_id, monto: f.monto }))
    };
    
    showLoading(true);
    
    fetch('/factoraje/solicitud', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        showLoading(false);
        if (result.success) {
            showSuccess('Solicitud creada exitosamente');
            cerrarModalSolicitud();
            cargarDatos();
        } else {
            showError(result.message || 'Error al crear la solicitud');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showError('Error de conexión al servidor');
    });
}

function verDetalles(id) {
    fetch(`/factoraje/solicitud/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarDetalles(data.data, data.facturas);
            } else {
                showError('No se pudieron cargar los detalles');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error al cargar detalles');
        });
}

function mostrarDetalles(solicitud, facturas) {
    const modal = document.getElementById('modalDetalles');
    const contenido = document.getElementById('detalleContenido');
    solicitudActualId = solicitud.solicitud_id;
    
    let facturasHtml = '';
    if (facturas && facturas.length > 0) {
        facturasHtml = '<div style="margin-top:10px;"><strong>Facturas Factoradas:</strong><br><table style="width:100%; margin-top:5px;"><thead><tr><th>Factura</th><th>Monto</th><th>Pagada al Cliente</th></tr></thead><tbody>';
        facturas.forEach(f => {
            facturasHtml += `<tr><td>${f.serie || ''}${f.serie ? '-' : ''}${f.folio}</td><td>${formatCurrency(f.monto_factura)}</td><td>${f.pagada_cliente ? 'Sí' : 'No'}</td></tr>`;
        });
        facturasHtml += '</tbody></table></div>';
    } else {
        facturasHtml = '<p>No hay facturas asociadas</p>';
    }
    
    contenido.innerHTML = `
        <div style="display: grid; gap: 12px;">
            <div><strong>Folio:</strong> ${solicitud.folio || '-'}</div>
            <div><strong>Fecha Solicitud:</strong> ${formatDate(solicitud.fecha_solicitud)}</div>
            <div><strong>Cliente:</strong> ${solicitud.contacto?.razon_social || '-'}</div>
            <div><strong>Factor:</strong> ${solicitud.factor?.nombre || '-'}</div>
            <div><strong>Monto Factura:</strong> ${formatCurrency(solicitud.monto_factura)}</div>
            <div><strong>Anticipo (${solicitud.porcentaje_anticipo}%):</strong> ${formatCurrency(solicitud.monto_anticipo)}</div>
            <div><strong>Comisión:</strong> ${formatCurrency(solicitud.comision)}</div>
            <div><strong>IVA Comisión:</strong> ${formatCurrency(solicitud.iva_comision)}</div>
            <div><strong>Total Comisión:</strong> ${formatCurrency(solicitud.total_comision)}</div>
            <div><strong>Monto a Recibir:</strong> <span style="color:#28a745; font-weight:bold;">${formatCurrency(solicitud.monto_recibir)}</span></div>
            <div><strong>Fecha Vencimiento:</strong> ${formatDate(solicitud.fecha_vencimiento_factoraje)}</div>
            <div><strong>Estatus:</strong> <span class="badge ${getBadgeClass(solicitud.estatus)}">${getEstatusDisplay(solicitud.estatus)}</span></div>
            <div><strong>Observaciones:</strong> ${solicitud.observaciones || 'Ninguna'}</div>
            ${facturasHtml}
        </div>
    `;
    
    // Mostrar/ocultar botones según estatus - USANDO NÚMEROS DIRECTAMENTE
    const btnAutorizar = document.getElementById('btnAutorizar');
    const btnRechazar = document.getElementById('btnRechazar');
    const btnLiquidar = document.getElementById('btnLiquidar');
    
    // Asegurar que los botones existan
    if (btnAutorizar && btnRechazar && btnLiquidar) {
        const estatus = parseInt(solicitud.estatus);
        
        // Ocultar todos primero
        btnAutorizar.style.display = 'none';
        btnRechazar.style.display = 'none';
        btnLiquidar.style.display = 'none';
        
        // Mostrar según estatus
        if (estatus === 1) { // Solicitado
            btnAutorizar.style.display = 'inline-block';
            btnRechazar.style.display = 'inline-block';
            console.log('Mostrando botones Autorizar y Rechazar para solicitud:', solicitud.folio);
        } else if (estatus === 2) { // Autorizado
            btnRechazar.style.display = 'inline-block';
            btnLiquidar.style.display = 'inline-block';
            console.log('Mostrando botones Rechazar y Liquidar para solicitud:', solicitud.folio);
        } else {
            console.log('No se muestran botones de acción para estatus:', estatus);
        }
    } else {
        console.error('No se encontraron los botones en el DOM');
    }
    
    modal.style.display = 'block';
}

function cerrarDetalles() {
    document.getElementById('modalDetalles').style.display = 'none';
    solicitudActualId = null;
}

// Modal de liquidación
let liquidacionSolicitudId = null;

function abrirModalLiquidacion(id) {
    liquidacionSolicitudId = id;
    document.getElementById('fecha_liquidacion').value = new Date().toISOString().split('T')[0];
    document.getElementById('referencia_pago').value = '';
    document.getElementById('modalLiquidacion').style.display = 'block';
}

function cerrarModalLiquidacion() {
    document.getElementById('modalLiquidacion').style.display = 'none';
    liquidacionSolicitudId = null;
}

function confirmarLiquidacion() {
    const fechaLiquidacion = document.getElementById('fecha_liquidacion').value;
    const referenciaPago = document.getElementById('referencia_pago').value;
    
    if (!fechaLiquidacion) {
        showError('La fecha de liquidación es obligatoria');
        return;
    }
    
    showLoading(true);
    
    fetch(`/factoraje/solicitud/${liquidacionSolicitudId}/liquidar`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ 
            fecha_liquidacion: fechaLiquidacion,
            referencia_pago: referenciaPago 
        })
    })
    .then(response => response.json())
    .then(result => {
        showLoading(false);
        if (result.success) {
            showSuccess('Factoraje liquidado correctamente');
            cerrarModalLiquidacion();
            cerrarDetalles();
            cargarDatos();
        } else {
            showError(result.message || 'Error al liquidar');
        }
    })
    .catch(error => {
        showLoading(false);
        console.error('Error:', error);
        showError('Error de conexión al servidor');
    });
}

function cambiarEstatus(nuevoEstatus) {
    if (!solicitudActualId) return;
    
    // 2 = Autorizar, 3 = Liquidar, 4 = Rechazar
    if (nuevoEstatus === 3) { // Liquidar
        abrirModalLiquidacion(solicitudActualId);
        return;
    }
    
    let titulo = '', mensaje = '', url = '';
    if (nuevoEstatus === 2) {
        titulo = '¿Autorizar solicitud?';
        mensaje = '¿Está seguro de autorizar esta solicitud de factoraje?';
        url = `/factoraje/solicitud/${solicitudActualId}/autorizar`;
    } else if (nuevoEstatus === 4) {
        titulo = '¿Rechazar solicitud?';
        mensaje = '¿Está seguro de rechazar esta solicitud de factoraje?';
        url = `/factoraje/solicitud/${solicitudActualId}/rechazar`;
    } else {
        return;
    }
    
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#083CAE',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading(true);
            
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.success) {
                    showSuccess('Estatus actualizado correctamente');
                    cerrarDetalles();
                    cargarDatos();
                } else {
                    showError(result.message || 'Error al actualizar estatus');
                }
            })
            .catch(error => {
                showLoading(false);
                console.error('Error:', error);
                showError('Error de conexión al servidor');
            });
        }
    });
}

function eliminarSolicitud(id) {
    Swal.fire({
        title: '¿Eliminar solicitud?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading(true);
            
            fetch(`/factoraje/solicitud/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.success) {
                    showSuccess('Solicitud eliminada correctamente');
                    cargarDatos();
                } else {
                    showError(result.message || 'Error al eliminar la solicitud');
                }
            })
            .catch(error => {
                showLoading(false);
                console.error('Error:', error);
                showError('Error de conexión al servidor');
            });
        }
    });
}

function exportarExcel() {
    const params = new URLSearchParams();
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busqueda = document.getElementById('buscador').value;
    
    if (fi) params.append('fecha_inicio', fi);
    if (ff) params.append('fecha_fin', ff);
    if (busqueda) params.append('search', busqueda);
    
    window.location.href = `/factoraje/excel?${params.toString()}`;
}

function configurarColumnas() {
    Swal.fire({
        title: 'Configurar Columnas',
        html: `
            <div style="text-align: left;">
                <label><input type="checkbox" id="colFolio" checked> Folio</label><br>
                <label><input type="checkbox" id="colFecha" checked> Fecha</label><br>
                <label><input type="checkbox" id="colCliente" checked> Cliente</label><br>
                <label><input type="checkbox" id="colFactor" checked> Factor</label><br>
                <label><input type="checkbox" id="colMonto" checked> Monto Factura</label><br>
                <label><input type="checkbox" id="colAnticipo" checked> Anticipo</label><br>
                <label><input type="checkbox" id="colComision" checked> Comisión</label><br>
                <label><input type="checkbox" id="colRecibir" checked> Monto Recibir</label><br>
                <label><input type="checkbox" id="colEstatus" checked> Estatus</label><br>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Aplicar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            Swal.fire('Funcionalidad en desarrollo', 'Selector de columnas próximamente', 'info');
        }
    });
}

// ============================================
// FILTROS Y PAGINACIÓN
// ============================================
function aplicarFiltros() {
    const fi = document.getElementById('fechaInicio').value;
    const ff = document.getElementById('fechaFin').value;
    const busqueda = document.getElementById('buscador').value;
    
    let filtered = [...datosFactoraje];
    
    if (fi) filtered = filtered.filter(item => item.fecha_solicitud >= fi);
    if (ff) filtered = filtered.filter(item => item.fecha_solicitud <= ff);
    if (busqueda) {
        const searchLower = busqueda.toLowerCase();
        filtered = filtered.filter(item => 
            (item.folio && item.folio.toLowerCase().includes(searchLower)) ||
            (item.cliente_nombre && item.cliente_nombre.toLowerCase().includes(searchLower)) ||
            (item.factor_nombre && item.factor_nombre.toLowerCase().includes(searchLower))
        );
    }
    
    datosFiltrados = filtered;
    currentPage = 1;
    cargarTabla();
}

function cambiarPagina(direccion) {
    const totalPages = Math.ceil(datosFiltrados.length / rowsPerPage);
    
    if (direccion === 'primera') currentPage = 1;
    else if (direccion === 'anterior') currentPage = Math.max(1, currentPage - 1);
    else if (direccion === 'siguiente') currentPage = Math.min(totalPages, currentPage + 1);
    else if (direccion === 'ultima') currentPage = totalPages;
    
    cargarTabla();
}

function guardarFiltro() {
    Swal.fire({
        title: 'Guardar Filtro',
        input: 'text',
        inputLabel: 'Nombre del filtro',
        inputPlaceholder: 'Ej: Facturas pendientes',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: (nombre) => {
            if (!nombre) {
                Swal.showValidationMessage('Ingrese un nombre para el filtro');
                return false;
            }
            const filtro = {
                nombre: nombre,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value,
                busqueda: document.getElementById('buscador').value
            };
            
            const filtros = JSON.parse(localStorage.getItem('factoraje_filtros') || '[]');
            filtros.push(filtro);
            localStorage.setItem('factoraje_filtros', JSON.stringify(filtros));
            
            Swal.fire('Filtro guardado', `Filtro "${nombre}" guardado exitosamente`, 'success');
        }
    });
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarDatos();
    
    // Event listeners
    document.getElementById('btnAgregar')?.addEventListener('click', abrirModalNuevaSolicitud);
    document.getElementById('cerrarModal')?.addEventListener('click', cerrarModalSolicitud);
    document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalSolicitud);
    document.getElementById('btnGuardar')?.addEventListener('click', guardarSolicitud);
    document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
    document.getElementById('btnColumnas')?.addEventListener('click', configurarColumnas);
    document.getElementById('btnCrearFiltro')?.addEventListener('click', guardarFiltro);
    
    document.getElementById('btnPrimeraPagina')?.addEventListener('click', () => cambiarPagina('primera'));
    document.getElementById('btnAnteriorPagina')?.addEventListener('click', () => cambiarPagina('anterior'));
    document.getElementById('btnSiguientePagina')?.addEventListener('click', () => cambiarPagina('siguiente'));
    document.getElementById('btnUltimaPagina')?.addEventListener('click', () => cambiarPagina('ultima'));
    
    document.getElementById('fechaInicio')?.addEventListener('change', aplicarFiltros);
    document.getElementById('fechaFin')?.addEventListener('change', aplicarFiltros);
    document.getElementById('buscador')?.addEventListener('input', aplicarFiltros);
    
    // Botones del modal de detalles
    document.getElementById('btnCerrarDetalles')?.addEventListener('click', cerrarDetalles);
    document.getElementById('btnAutorizar')?.addEventListener('click', () => cambiarEstatus(ESTATUS.AUTORIZADO));
    document.getElementById('btnRechazar')?.addEventListener('click', () => cambiarEstatus(ESTATUS.RECHAZADO));
    document.getElementById('btnLiquidar')?.addEventListener('click', () => cambiarEstatus(ESTATUS.LIQUIDADO));
    
    // Botones del modal de liquidación
    document.getElementById('btnCancelarLiquidacion')?.addEventListener('click', cerrarModalLiquidacion);
    document.getElementById('btnConfirmarLiquidacion')?.addEventListener('click', confirmarLiquidacion);
    
    // Porcentaje anticipo
    document.getElementById('porcentaje_anticipo')?.addEventListener('input', actualizarResumen);
});
</script>
@endsection