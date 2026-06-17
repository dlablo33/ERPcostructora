@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Licitaciones Activas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Licitaciones Activas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE LICITACIONES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalLicitaciones">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Proceso</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="enProceso">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Adjudicadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="adjudicadas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Vencer</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porVencer">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Licitación">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnFiltrar" style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;" title="Filtros avanzados">
                                <i class="fas fa-filter"></i>
                                Filtrar
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar licitación..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando licitaciones...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-contract" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin licitaciones</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Licitaciones -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaLicitaciones" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">No. Licitación</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Nombre / Descripción</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Cliente / Dependencia</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Fecha Publicación</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Fecha Cierre</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Días Restantes</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Monto Estimado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Responsable</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Estado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                    <div style="visibility: hidden;"></div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar Licitación - CORREGIDO -->
<div id="modalAgregarLicitacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-plus-circle"></i> Nueva Licitación</h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <form id="formLicitacion">
            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Licitación <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="modalNoLicitacion" name="no_licitacion" placeholder="Ej: LIC-2026-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente/Dependencia <span style="color: #dc3545;">*</span></label>
                        <select id="modalCliente" name="cliente_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="">Cargando clientes...</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre / Descripción <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="modalNombre" name="nombre" placeholder="Descripción de la licitación" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Publicación <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaPublicacion" name="fecha_publicacion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Cierre <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaCierre" name="fecha_cierre" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Monto Estimado <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalMonto" name="monto_estimado" placeholder="0.00" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Moneda</label>
                        <select id="modalMoneda" name="moneda" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="MXN">MXN - Peso Mexicano</option>
                            <option value="USD">USD - Dólar Americano</option>
                            <option value="EUR">EUR - Euro</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                    <select id="modalResponsable" name="responsable_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar responsable...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales..."></textarea>
                </div>
            </div>

            <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelar" style="padding: 10px 20px; background-color: #f8f9fa; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Licitación</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Ver Detalle - CORREGIDO -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-file-contract"></i> Detalle de Licitación
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="detalleContent"></div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    .badge-estado { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; font-weight: 600; }
    .badge-proceso { background-color: #cce5ff; color: #0d6efd; }
    .badge-adjudicada { background-color: #d4edda; color: #28a745; }
    .badge-por-vencer { background-color: #fff3cd; color: #ffc107; }
    .badge-vencida { background-color: #f8d7da; color: #dc3545; }
    .badge-no-adjudicada { background-color: #e2e3e5; color: #6c757d; }
    .badge-participa { background-color: #083CAE; color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; margin-left: 5px; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    
    /* Toast notifications */
    .toast-notification { 
        position: fixed; 
        bottom: 20px; 
        right: 20px; 
        z-index: 100000; 
        animation: slideIn 0.3s ease; 
        background-color: #28a745; 
        color: white; 
        padding: 12px 20px; 
        border-radius: 8px; 
        margin-bottom: 10px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); 
        font-size: 14px; 
    }
    .toast-notification.error { background-color: #dc3545; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { 
        from { transform: translateX(100%); opacity: 0; } 
        to { transform: translateX(0); opacity: 1; } 
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        #modalAgregarLicitacion > div,
        #modalVerDetalle > div {
            width: 95%;
            margin: 10px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/licitaciones';
    let currentPage = 1;
    let totalPages = 1;
    let currentFilters = {
        busqueda: '',
        estado: '',
        fecha_inicio: '',
        fecha_fin: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarLicitaciones() {
        mostrarLoading(true);
        
        try {
            const params = new URLSearchParams(currentFilters);
            const url = `${API_BASE}?${params.toString()}`;
            console.log('Cargando desde:', url);
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 200)}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                renderizarTabla(data);
                actualizarPaginacion(pagination);
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar las licitaciones', 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    async function cargarClientes() {
        try {
            const response = await fetch(`${API_BASE}/clientes`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            const select = document.getElementById('modalCliente');
            
            if (result.success && result.data && result.data.length > 0) {
                select.innerHTML = '<option value="">Seleccionar cliente...</option>';
                result.data.forEach(cliente => {
                    select.innerHTML += `<option value="${cliente.id}">${cliente.nombre}</option>`;
                });
            } else {
                select.innerHTML = '<option value="">No hay clientes disponibles</option>';
            }
        } catch (error) {
            console.error('Error cargando clientes:', error);
            const select = document.getElementById('modalCliente');
            select.innerHTML = '<option value="">Error al cargar clientes</option>';
        }
    }

    async function cargarResponsables() {
        try {
            const response = await fetch(`${API_BASE}/responsables`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            const select = document.getElementById('modalResponsable');
            
            if (result.success && result.data && result.data.length > 0) {
                select.innerHTML = '<option value="">Seleccionar responsable...</option>';
                result.data.forEach(responsable => {
                    const nombre = responsable.nombre_completo || responsable.nombre || 'Sin nombre';
                    select.innerHTML += `<option value="${responsable.id}">${nombre}</option>`;
                });
            } else {
                select.innerHTML = '<option value="">No hay responsables disponibles</option>';
            }
        } catch (error) {
            console.error('Error cargando responsables:', error);
            const select = document.getElementById('modalResponsable');
            select.innerHTML = '<option value="">Error al cargar responsables</option>';
        }
    }

    // ============================================
    // RENDERIZADO
    // ============================================

    function renderizarTabla(licitaciones) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if (!licitaciones || licitaciones.length === 0) {
            tbody.innerHTML = '';
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        
        tbody.innerHTML = licitaciones.map(licitacion => `
            <tr>
                <td style="padding: 10px 4px;">
                    ${licitacion.no_licitacion || 'N/A'}
                    ${licitacion.participa ? '<span class="badge-participa">Participamos</span>' : ''}
                </td>
                <td style="padding: 10px 4px;">${licitacion.nombre || '-'}</td>
                <td style="padding: 10px 4px;">${licitacion.nombre_cliente || licitacion.cliente?.razon_social || '-'}</td>
                <td style="padding: 10px 4px; text-align: center;">${formatDate(licitacion.fecha_publicacion)}</td>
                <td style="padding: 10px 4px; text-align: center;">${formatDate(licitacion.fecha_cierre)}</td>
                <td style="padding: 10px 4px; text-align: center; color: ${getDiasColor(licitacion.dias_restantes)}; font-weight: 600;">
                    ${licitacion.dias_restantes || 0} días
                </td>
                <td style="padding: 10px 4px; text-align: right;">${formatCurrency(licitacion.monto_estimado)}</td>
                <td style="padding: 10px 4px;">${licitacion.nombre_responsable || licitacion.responsable?.nombre || '-'}</td>
                <td style="padding: 10px 4px;">
                    <span class="badge-estado ${getEstadoBadgeClass(licitacion.estado)}">${licitacion.estado || 'En Proceso'}</span>
                </td>
                <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${licitacion.id})"></i>
                        ${!licitacion.participa && licitacion.estado !== 'Vencida' && licitacion.estado !== 'Adjudicada' ? 
                            `<i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Participar" onclick="confirmarParticipacion(${licitacion.id})"></i>` : ''}
                    </div>
                </td>
            </tr>
        `).join('');
        
        const totalMonto = licitaciones.reduce((sum, l) => sum + parseFloat(l.monto_estimado || 0), 0);
        document.getElementById('totalMonto').textContent = formatCurrency(totalMonto);
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalLicitaciones').textContent = stats.total || 0;
        document.getElementById('enProceso').textContent = stats.en_proceso || 0;
        document.getElementById('adjudicadas').textContent = stats.adjudicadas || 0;
        document.getElementById('porVencer').textContent = stats.por_vencer || 0;
    }

    function actualizarPaginacion(pagination) {
        if (!pagination) return;
        document.getElementById('paginaActual').textContent = pagination.current_page || 1;
        document.getElementById('totalPaginas').textContent = `de ${pagination.last_page || 1}`;
        document.getElementById('paginacionInfo').textContent = 
            `Mostrando ${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    }

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function formatCurrency(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function getDiasColor(dias) {
        if (dias < 0) return '#dc3545';
        if (dias <= 7) return '#dc3545';
        if (dias <= 15) return '#ffc107';
        return '#28a745';
    }

    function getEstadoBadgeClass(estado) {
        const badges = {
            'En Proceso': 'badge-proceso',
            'Adjudicada': 'badge-adjudicada',
            'Por Vencer': 'badge-por-vencer',
            'Vencida': 'badge-vencida',
            'No Adjudicada': 'badge-no-adjudicada'
        };
        return badges[estado] || 'badge-proceso';
    }

    function mostrarLoading(show) {
        const spinner = document.getElementById('loadingSpinner');
        const tablaContainer = document.getElementById('tablaContainer');
        if (spinner) spinner.style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = 'toast-notification';
        if (tipo === 'error') notificacion.classList.add('error');
        if (tipo === 'warning') notificacion.classList.add('warning');
        notificacion.innerHTML = `<i class="fas ${tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.verDetalle = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const l = result.data;
                const content = `
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 12px; color: #6c757d;">No. Licitación</div>
                        <div style="font-size: 20px; font-weight: 700; color: #083CAE;">${l.no_licitacion}</div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Nombre / Descripción</div>
                        <div style="font-size: 16px; font-weight: 600;">${l.nombre || '-'}</div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div><div style="color: #6c757d; font-size: 12px;">Cliente</div><div>${l.nombre_cliente || '-'}</div></div>
                        <div><div style="color: #6c757d; font-size: 12px;">Responsable</div><div>${l.nombre_responsable || '-'}</div></div>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Publicación</div>
                            <div style="font-size: 15px;">${formatDate(l.fecha_publicacion)}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Cierre</div>
                            <div style="font-size: 15px;">${formatDate(l.fecha_cierre)}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Días Restantes</div>
                            <div style="font-size: 15px; color: ${getDiasColor(l.dias_restantes)};">${l.dias_restantes} días</div>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Monto Estimado</div>
                        <div style="font-size: 24px; font-weight: 700; color: #083CAE;">${formatCurrency(l.monto_estimado)}</div>
                    </div>
                    ${l.observaciones ? `
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">${l.observaciones}</div>
                    </div>` : ''}
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalVer()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                document.getElementById('detalleContent').innerHTML = content;
                abrirModalVer();
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.confirmarParticipacion = async function(id) {
        if (!confirm('¿Desea confirmar su participación en esta licitación?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/${id}/participar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message, 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al confirmar participación', 'error');
        }
    };

    function abrirModalVer() {
        const modal = document.getElementById('modalVerDetalle');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    window.cerrarModalVer = function() {
        const modal = document.getElementById('modalVerDetalle');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    async function exportarExcel() {
        try {
            const params = new URLSearchParams(currentFilters);
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = ['No. Licitación', 'Nombre', 'Cliente', 'Fecha Publicación', 'Fecha Cierre', 'Días', 'Monto', 'Responsable', 'Estado'];
                const rows = result.data.map(l => [
                    l.no_licitacion, l.nombre, l.nombre_cliente, formatDate(l.fecha_publicacion),
                    formatDate(l.fecha_cierre), l.dias_restantes, l.monto_estimado, l.nombre_responsable, l.estado
                ]);
                const csvContent = [headers, ...rows].map(row => row.join(',')).join('\n');
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `licitaciones_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    async function crearLicitacion(event) {
        event.preventDefault();
        
        const formData = new FormData();
        formData.append('no_licitacion', document.getElementById('modalNoLicitacion').value);
        formData.append('nombre', document.getElementById('modalNombre').value);
        formData.append('cliente_id', document.getElementById('modalCliente').value);
        formData.append('fecha_publicacion', document.getElementById('modalFechaPublicacion').value);
        formData.append('fecha_cierre', document.getElementById('modalFechaCierre').value);
        formData.append('monto_estimado', document.getElementById('modalMonto').value);
        formData.append('moneda', document.getElementById('modalMoneda').value);
        formData.append('responsable_id', document.getElementById('modalResponsable').value || '');
        formData.append('observaciones', document.getElementById('modalObservaciones').value || '');
        
        try {
            const response = await fetch(API_BASE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cerrarModalAgregar();
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message || 'Error al crear', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al crear la licitación', 'error');
        }
    }

    function abrirModalAgregar() {
        const modal = document.getElementById('modalAgregarLicitacion');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Establecer fechas por defecto
        const hoy = new Date();
        const unMesDespues = new Date();
        unMesDespues.setMonth(hoy.getMonth() + 1);
        
        document.getElementById('modalFechaPublicacion').value = hoy.toISOString().split('T')[0];
        document.getElementById('modalFechaCierre').value = unMesDespues.toISOString().split('T')[0];
    }

    function cerrarModalAgregar() {
        const modal = document.getElementById('modalAgregarLicitacion');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formLicitacion')?.reset();
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    function inicializarEventos() {
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarLicitaciones(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarLicitaciones(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarLicitaciones(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarLicitaciones(); }
        });
        
        document.getElementById('buscador')?.addEventListener('input', (e) => {
            currentFilters.busqueda = e.target.value;
            currentFilters.page = 1;
            cargarLicitaciones();
        });
        
        document.getElementById('fechaInicio')?.addEventListener('change', (e) => {
            currentFilters.fecha_inicio = e.target.value;
            currentFilters.page = 1;
            cargarLicitaciones();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', (e) => {
            currentFilters.fecha_fin = e.target.value;
            currentFilters.page = 1;
            cargarLicitaciones();
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', abrirModalAgregar);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCerrarVerModal')?.addEventListener('click', cerrarModalVer);
        document.getElementById('formLicitacion')?.addEventListener('submit', crearLicitacion);
        
        window.addEventListener('click', (event) => {
            const modalAgregar = document.getElementById('modalAgregarLicitacion');
            const modalVer = document.getElementById('modalVerDetalle');
            if (event.target === modalAgregar) cerrarModalAgregar();
            if (event.target === modalVer) cerrarModalVer();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        const hoy = new Date();
        const seisMesesAtras = new Date();
        seisMesesAtras.setMonth(hoy.getMonth() - 6);
        
        document.getElementById('fechaInicio').value = seisMesesAtras.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
        
        currentFilters.fecha_inicio = document.getElementById('fechaInicio').value;
        currentFilters.fecha_fin = document.getElementById('fechaFin').value;
        
        cargarClientes();
        cargarResponsables();
        cargarLicitaciones();
        inicializarEventos();
    });
</script>
@endsection