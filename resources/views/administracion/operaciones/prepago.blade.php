@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE !important; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Prepagos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <input type="date" id="fechaInicio" value="{{ $fechaInicio ?? date('Y-m-01') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        <input type="date" id="fechaFin" value="{{ $fechaFin ?? date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">

                        <button id="btnAgregar" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #2378e1; font-size: 16px;" title="Agregar">
                            <i class="fas fa-plus"></i>
                        </button>

                        <button id="btnExcel" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;" title="Exportar todo">
                            <i class="fas fa-file-excel"></i>
                        </button>

                        <button id="btnColumnas" style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;" title="Seleccionar columnas">
                            <i class="fas fa-columns"></i>
                        </button>

                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #2378e1; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje Sin datos -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-hand-holding-usd" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay prepagos para mostrar</p>
                </div>

                <!-- Loading -->
                <div id="loadingTabla" style="text-align:center; padding:40px; display:none;">
                    <i class="fas fa-spinner fa-spin" style="font-size:32px; color:#2378e1;"></i>
                    <p style="color:#6c757d; margin-top:10px;">Cargando prepagos...</p>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPrepagos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Acciones</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: left; background-color: #e9ecef; color: #000000;" colspan="3">Registros: <span id="totalRegistros">0</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
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
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;" title="Primera página">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;" title="Página anterior">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span id="paginaActual" style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;">1</span>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;" title="Página siguiente">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; cursor: pointer; color: #2378e1;" title="Última página">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                        <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1; font-size: 14px;">Mostrando 0-0 de 0 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================ MODAL AGREGAR / EDITAR ============================ -->
<div id="modalPrepago" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:8px; width:100%; max-width:520px; max-height:90vh; overflow-y:auto; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="padding:15px 20px; border-bottom:2px solid #2378e1; display:flex; justify-content:space-between; align-items:center;">
            <h3 id="modalPrepagoTitulo" style="margin:0; color:#083CAE; font-weight:bold;">Agregar Prepago</h3>
            <button type="button" id="btnCerrarModal" style="background:none; border:none; font-size:22px; color:#6c757d; cursor:pointer;">&times;</button>
        </div>
        <form id="formPrepago" style="padding:20px;">
            <input type="hidden" id="prepagoId" name="id">
            
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Proveedor *</label>
                <select id="proveedorId" name="proveedor_id" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; font-size:14px;">
                    <option value="">-- Seleccione proveedor --</option>
                </select>
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Folio (opcional)</label>
                <input type="text" id="folio" name="folio" placeholder="Se generará automáticamente" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; font-size:14px;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Fecha *</label>
                <input type="date" id="fecha" name="fecha" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; font-size:14px;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Monto *</label>
                <input type="number" id="monto" name="monto" step="0.01" min="0.01" required style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; font-size:14px;">
            </div>

            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="3" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; font-size:14px;"></textarea>
            </div>

            <div id="formError" style="display:none; background:#f8d7da; color:#721c24; padding:10px; border-radius:4px; margin-bottom:12px; font-size:13px;"></div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:10px; border-top:1px solid #dee2e6;">
                <button type="button" id="btnCancelarForm" style="padding:8px 16px; background:#6c757d; color:white; border:none; border-radius:4px; cursor:pointer;">Cancelar</button>
                <button type="submit" id="btnGuardarForm" style="padding:8px 16px; background:#2378e1; color:white; border:none; border-radius:4px; cursor:pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================ MODAL VER DETALLE ============================ -->
<div id="modalVer" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:8px; width:100%; max-width:520px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="padding:15px 20px; border-bottom:2px solid #2378e1; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; color:#083CAE; font-weight:bold;">Detalle del Prepago</h3>
            <button type="button" id="btnCerrarVer" style="background:none; border:none; font-size:22px; color:#6c757d; cursor:pointer;">&times;</button>
        </div>
        <div id="verContenido" style="padding:20px;"></div>
        <div style="padding:10px 20px 20px; text-align:right;">
            <button type="button" id="btnCerrarVer2" style="padding:8px 16px; background:#2378e1; color:white; border:none; border-radius:4px; cursor:pointer;">Cerrar</button>
        </div>
    </div>
</div>

<!-- ============================ MODAL COLUMNAS ============================ -->
<div id="modalColumnas" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:8px; width:100%; max-width:400px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="padding:15px 20px; border-bottom:2px solid #2378e1; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; color:#083CAE; font-weight:bold;">Seleccionar columnas</h3>
            <button type="button" id="btnCerrarColumnas" style="background:none; border:none; font-size:22px; color:#6c757d; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:20px;">
            <label style="display:flex; align-items:center; gap:10px; margin-bottom:10px; font-size:14px;">
                <input type="checkbox" class="col-toggle" value="folio" checked> <span>Folio</span>
            </label>
            <label style="display:flex; align-items:center; gap:10px; margin-bottom:10px; font-size:14px;">
                <input type="checkbox" class="col-toggle" value="proveedor" checked> <span>Proveedor</span>
            </label>
            <label style="display:flex; align-items:center; gap:10px; margin-bottom:10px; font-size:14px;">
                <input type="checkbox" class="col-toggle" value="fecha" checked> <span>Fecha</span>
            </label>
            <label style="display:flex; align-items:center; gap:10px; margin-bottom:10px; font-size:14px;">
                <input type="checkbox" class="col-toggle" value="monto" checked> <span>Monto</span>
            </label>
        </div>
        <div style="padding:10px 20px 20px; text-align:right;">
            <button type="button" id="btnAplicarColumnas" style="padding:8px 16px; background:#2378e1; color:white; border:none; border-radius:4px; cursor:pointer;">Aplicar</button>
        </div>
    </div>
</div>

<!-- ============================ MODAL CREAR FILTRO ============================ -->
<div id="modalFiltro" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:8px; width:100%; max-width:500px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="padding:15px 20px; border-bottom:2px solid #2378e1; display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; color:#083CAE; font-weight:bold;">Crear filtro</h3>
            <button type="button" id="btnCerrarFiltro" style="background:none; border:none; font-size:22px; color:#6c757d; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:20px;">
            <p style="font-size:13px; color:#6c757d; margin-bottom:12px;">Ajusta los filtros y presiona Aplicar.</p>
            <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Fecha inicio</label>
            <input type="date" id="filtroFechaInicio" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; margin-bottom:12px;">
            <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Fecha fin</label>
            <input type="date" id="filtroFechaFin" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px; margin-bottom:12px;">
            <label style="display:block; font-size:13px; color:#495057; margin-bottom:4px;">Proveedor (texto)</label>
            <input type="text" id="filtroBuscar" placeholder="Nombre o folio..." style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
        </div>
        <div style="padding:10px 20px 20px; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" id="btnLimpiarFiltro" style="padding:8px 16px; background:#6c757d; color:white; border:none; border-radius:4px; cursor:pointer;">Limpiar</button>
            <button type="button" id="btnAplicarFiltro" style="padding:8px 16px; background:#2378e1; color:white; border:none; border-radius:4px; cursor:pointer;">Aplicar</button>
        </div>
    </div>
</div>

<!-- ============================ TOAST NOTIFICACIONES ============================ -->
<div id="toastContainer" style="position:fixed; top:20px; right:20px; z-index:2000; display:flex; flex-direction:column; gap:10px;"></div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ============ META CSRF (crítico) ============
    // Se crea si el layout no lo tiene, garantizando que siempre exista
    let csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
        csrfMeta = document.createElement('meta');
        csrfMeta.setAttribute('name', 'csrf-token');
        csrfMeta.setAttribute('content', '{{ csrf_token() }}');
        document.head.appendChild(csrfMeta);
    }
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    }

    // ============ CONFIG ============
    const ROUTES = {
        listado:      "{{ route('prepagos.listado') }}",
        proveedores:  "{{ route('prepagos.proveedores') }}",
        store:        "{{ route('prepagos.store') }}",
        base:         "{{ url('prepagos') }}",
        exportExcel:  "{{ route('prepagos.export.excel') }}",
    };

    // ============ ESTADO ============
    let datosOriginales = [];
    let datosFiltrados = [];
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let paginaActual = 1;
    const registrosPorPagina = 8;
    let columnasVisibles = { folio: true, proveedor: true, fecha: true, monto: true };
    let proveedoresCache = null;
    let modoEdicion = false;

    // ============ DOM ============
    const $tablaBody       = document.getElementById('tablaBody');
    const $sinDatos        = document.getElementById('sinDatosMensaje');
    const $tablaContainer  = document.getElementById('tablaContainer');
    const $tablaFoot       = document.getElementById('tablaFoot');
    const $loading         = document.getElementById('loadingTabla');
    const $totalRegistros  = document.getElementById('totalRegistros');
    const $sumMonto        = document.getElementById('sumMonto');
    const $paginacionInfo  = document.getElementById('paginacionInfo');
    const $paginaActual    = document.getElementById('paginaActual');
    const $buscador        = document.getElementById('buscador');
    const $fechaInicio     = document.getElementById('fechaInicio');
    const $fechaFin        = document.getElementById('fechaFin');
    const $textoAgrupar    = document.getElementById('textoAgrupar');
    const $grupoColumnas   = document.getElementById('grupoColumnas');

    // ============ UTILIDADES ============
    function formatCurrency(n) {
        return '$' + Number(n || 0).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    function formatDate(s) {
        if (!s) return '-';
        const d = new Date(s + 'T00:00:00');
        if (isNaN(d)) return s;
        return d.toLocaleDateString('es-MX', { year: 'numeric', month: '2-digit', day: '2-digit' });
    }
    function esc(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function toast(msg, tipo = 'success') {
        const colores = { success: '#28a745', error: '#dc3545', info: '#2378e1', warning: '#ffc107' };
        const iconos  = { success: 'fa-check-circle', error: 'fa-times-circle', info: 'fa-info-circle', warning: 'fa-exclamation-circle' };
        const div = document.createElement('div');
        div.style.cssText = `background:${colores[tipo]}; color:white; padding:12px 20px; border-radius:6px; box-shadow:0 4px 12px rgba(0,0,0,0.2); font-size:14px; display:flex; align-items:center; gap:10px; min-width:250px; animation: slideIn 0.3s ease;`;
        div.innerHTML = `<i class="fas ${iconos[tipo]}"></i><span>${esc(msg)}</span>`;
        document.getElementById('toastContainer').appendChild(div);
        setTimeout(() => { div.style.opacity = '0'; div.style.transition = 'opacity 0.3s'; setTimeout(() => div.remove(), 300); }, 3000);
    }

    /**
     * ⚠️ FETCH CENTRALIZADO
     * - credentials: 'same-origin'  → envía cookies de sesión
     * - X-CSRF-TOKEN dinámico      → evita 419
     * - X-Requested-With           → Laravel responde JSON
     */
    async function fetchJSON(url, options = {}) {
        const method = (options.method || 'GET').toUpperCase();
        const headers = {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCsrfToken(),
            ...(options.headers || {}),
        };
        if (method !== 'GET' && method !== 'HEAD' && !headers['Content-Type']) {
            headers['Content-Type'] = 'application/json';
        }

        const res = await fetch(url, {
            credentials: 'same-origin',
            ...options,
            method,
            headers,
        });

        let data = null;
        const text = await res.text();
        try { data = text ? JSON.parse(text) : null; }
        catch (e) { data = { success: false, message: text || 'Respuesta inválida del servidor' }; }

        if (!res.ok) {
            if (res.status === 419) {
                throw { status: 419, data: { success: false, message: 'Sesión expirada (CSRF). Recarga la página.' } };
            }
            throw { status: res.status, data };
        }
        return data;
    }

    // ============ CARGA DE DATOS ============
    async function cargarDatos(mostrarLoading = true) {
        if (mostrarLoading) {
            $loading.style.display = 'block';
            $tablaContainer.style.display = 'none';
        }
        try {
            const params = new URLSearchParams({
                fecha_inicio: $fechaInicio.value || '',
                fecha_fin: $fechaFin.value || '',
                buscar: $buscador.value.trim(),
            });
            const json = await fetchJSON(`${ROUTES.listado}?${params.toString()}`);
            if (!json.success) throw new Error(json.message || 'Error al cargar');
            datosOriginales = (json.data || []).map(r => ({
                prepago_id: r.prepago_id,
                id: r.id,
                proveedor: r.proveedor,
                fecha: r.fecha,
                monto: Number(r.monto) || 0,
            }));
            datosFiltrados = [...datosOriginales];
            paginaActual = 1;
            cargarTabla(datosFiltrados);
        } catch (err) {
            console.error(err);
            toast(err?.data?.message || err.message || 'Error al cargar prepagos', 'error');
            $sinDatos.style.display = 'block';
            $tablaContainer.style.display = 'none';
        } finally {
            $loading.style.display = 'none';
            $tablaContainer.style.display = 'block';
        }
    }

    // ============ FILTRADO LOCAL (búsqueda) ============
    function filtrarLocal() {
        const t = $buscador.value.toLowerCase().trim();
        if (!t) { datosFiltrados = [...datosOriginales]; }
        else {
            datosFiltrados = datosOriginales.filter(i =>
                (i.proveedor || '').toLowerCase().includes(t) ||
                String(i.prepago_id || '').toLowerCase().includes(t)
            );
        }
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    }

    // ============ AGRUPACIÓN ============
    function generarGrupoId(item, cols) {
        return cols.map(c => {
            if (c === 'folio') return item.prepago_id ?? '';
            if (c === 'proveedor') return item.proveedor ?? '';
            if (c === 'fecha') return item.fecha ?? '';
            if (c === 'monto') return item.monto ?? 0;
            return '';
        }).join('||');
    }

    function agruparDatos(datos, cols) {
        if (!cols.length) return { grupos: [], items: datos };
        const map = new Map();
        datos.forEach(item => {
            const id = generarGrupoId(item, cols);
            if (!map.has(id)) {
                const valor = cols.map(c => {
                    if (c === 'folio') return item.prepago_id ?? 'Sin folio';
                    if (c === 'proveedor') return item.proveedor ?? 'Sin proveedor';
                    if (c === 'fecha') return item.fecha ? formatDate(item.fecha) : 'Sin fecha';
                    if (c === 'monto') return formatCurrency(item.monto || 0);
                    return '';
                }).join(' - ');
                map.set(id, { id, valor, items: [item], totalMonto: item.monto || 0 });
            } else {
                const g = map.get(id);
                g.items.push(item);
                g.totalMonto += item.monto || 0;
            }
        });
        return { grupos: Array.from(map.values()), items: [] };
    }

    function getCurrentPageData(datos) {
        const s = (paginaActual - 1) * registrosPorPagina;
        return datos.slice(s, s + registrosPorPagina);
    }

    function actualizarPaginacion(total) {
        const totalPaginas = Math.max(1, Math.ceil(total / registrosPorPagina));
        $paginaActual.textContent = paginaActual;
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            const p = parseInt(btn.dataset.pagina, 10);
            btn.style.display = p <= totalPaginas ? 'inline-block' : 'none';
            btn.style.fontWeight = p === paginaActual ? 'bold' : 'normal';
        });
        const ini = total > 0 ? (paginaActual - 1) * registrosPorPagina + 1 : 0;
        const fin = Math.min(paginaActual * registrosPorPagina, total);
        $paginacionInfo.textContent = `Mostrando ${ini}-${fin} de ${total} registros`;
    }

    function calcularTotales(datos) {
        const suma = datos.reduce((a, b) => a + (b.monto || 0), 0);
        $totalRegistros.textContent = datos.length;
        $sumMonto.textContent = formatCurrency(suma);
    }

    // ============ RENDER TABLA ============
    function aplicarVisibilidadColumnas() {
        const idx = { folio: 1, proveedor: 2, fecha: 3, monto: 4 };
        for (const col in idx) {
            const n = idx[col];
            const th = document.querySelector(`#tablaPrepagos thead th:nth-child(${n})`);
            const tds = document.querySelectorAll(`#tablaPrepagos tbody tr td:nth-child(${n})`);
            if (th) th.style.display = columnasVisibles[col] ? '' : 'none';
            tds.forEach(td => td.style.display = columnasVisibles[col] ? '' : 'none');
        }
    }

    function cargarTabla(datos) {
        if ($textoAgrupar) $textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';

        const { grupos } = agruparDatos(datos, columnasAgrupadas);
        const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;

        $tablaBody.innerHTML = '';

        if (!datos.length) {
            $sinDatos.style.display = 'block';
            $tablaContainer.style.display = 'none';
            if ($tablaFoot) $tablaFoot.style.display = 'none';
            $totalRegistros.textContent = '0';
            $sumMonto.textContent = formatCurrency(0);
            $paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
            return;
        }

        $sinDatos.style.display = 'none';
        $tablaContainer.style.display = 'block';

        if (hayGrupos) {
            $tablaFoot.style.display = 'none';
            grupos.forEach(g => {
                const tr = document.createElement('tr');
                tr.className = 'fila-grupo';
                tr.dataset.grupoId = g.id;
                if (expandedGroups.has(g.id)) tr.classList.add('expandido');

                const counts = {};
                g.items.forEach(i => { counts[i.proveedor] = (counts[i.proveedor] || 0) + 1; });
                let pred = 'Proveedor', max = 0;
                for (const [k, v] of Object.entries(counts)) if (v > max) { max = v; pred = k; }

                tr.innerHTML = `
                    <td colspan="5" style="border:1px solid #dee2e6; padding:10px 4px; color:#000;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <i class="fas ${expandedGroups.has(g.id) ? 'fa-caret-down' : 'fa-caret-right'}" style="margin-right:8px; color:#2378e1;"></i>
                                <strong style="color:#2378e1;">${esc(g.valor)}</strong>
                                <span style="color:#6c757d; font-size:11px; margin-left:10px;">
                                    (${g.items.length} registros - ${formatCurrency(g.totalMonto)})
                                </span>
                            </div>
                            <span style="background:#2378e1; color:white; padding:3px 10px; border-radius:12px; font-size:11px;">${esc(pred)}</span>
                        </div>
                    </td>`;
                $tablaBody.appendChild(tr);

                if (expandedGroups.has(g.id)) {
                    g.items.forEach(item => $tablaBody.appendChild(filaDetalle(item, true)));
                }
            });
            $paginacionInfo.textContent = `Mostrando ${grupos.length} grupos de ${datos.length} registros`;
        } else {
            $tablaFoot.style.display = 'table-footer-group';
            getCurrentPageData(datos).forEach(item => $tablaBody.appendChild(filaDetalle(item, false)));
            calcularTotales(datos);
            actualizarPaginacion(datos.length);
        }

        aplicarVisibilidadColumnas();
    }

    function filaDetalle(item, esDetalle) {
        const tr = document.createElement('tr');
        tr.className = esDetalle ? 'fila-detalle' : '';
        tr.dataset.id = item.id;
        tr.innerHTML = `
            <td style="border:1px solid #dee2e6; padding:10px 4px; color:#000; ${esDetalle ? 'padding-left:30px;' : ''}">${esc(item.prepago_id || '-')}</td>
            <td style="border:1px solid #dee2e6; padding:10px 4px; color:#000;">${esc(item.proveedor || '-')}</td>
            <td style="border:1px solid #dee2e6; padding:10px 4px; text-align:center; color:#000;">${esc(formatDate(item.fecha))}</td>
            <td style="border:1px solid #dee2e6; padding:10px 4px; text-align:right; color:#000;">${esc(formatCurrency(item.monto))}</td>
            <td style="border:1px solid #dee2e6; padding:10px 4px; background:white; position:sticky; right:0; box-shadow:-2px 0 5px rgba(0,0,0,0.1);">
                <div style="display:flex; gap:8px; justify-content:center;">
                    <i class="fas fa-edit"       data-action="edit"   data-id="${item.id}" style="color:#083CAE; cursor:pointer; font-size:14px;" title="Editar"></i>
                    <i class="fas fa-trash-alt"  data-action="delete" data-id="${item.id}" style="color:#083CAE; cursor:pointer; font-size:14px;" title="Eliminar"></i>
                    <i class="fas fa-eye"        data-action="view"   data-id="${item.id}" style="color:#083CAE; cursor:pointer; font-size:14px;" title="Ver"></i>
                </div>
            </td>`;
        return tr;
    }

    // ============ AGRUPACIÓN UI ============
    function actualizarGrupoColumnas() {
        $grupoColumnas.innerHTML = '';
        if (!columnasAgrupadas.length) {
            if ($textoAgrupar) $textoAgrupar.style.display = 'inline';
        } else {
            if ($textoAgrupar) $textoAgrupar.style.display = 'none';
            const nombres = { folio: 'Folio', proveedor: 'Proveedor', fecha: 'Fecha', monto: 'Monto' };
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.style.cssText = 'display:inline-flex; align-items:center; padding:4px 10px; background:#f0f4ff; border-radius:16px; color:#2378e1; font-size:12px; margin:2px; border:1px solid #2378e1;';
                chip.innerHTML = `${nombres[col] || col} <span class="remover" data-columna="${col}" style="margin-left:6px; cursor:pointer; font-weight:bold;">&times;</span>`;
                $grupoColumnas.appendChild(chip);
            });
        }
        expandedGroups.clear();
        cargarTabla(datosFiltrados);
    }

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            const col = e.target.dataset.columna;
            columnasAgrupadas = columnasAgrupadas.filter(c => c !== col);
            actualizarGrupoColumnas();
        }
    });

    // Drag & drop
    (function setupDnD() {
        const grupo = document.getElementById('grupoAgrupacion');
        document.querySelectorAll('th[draggable="true"]').forEach(th => {
            th.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', th.dataset.columna);
                th.style.opacity = '0.5';
            });
            th.addEventListener('dragend', () => th.style.opacity = '1');
        });
        grupo.addEventListener('dragover', e => { e.preventDefault(); grupo.style.background = 'rgba(35,120,225,0.1)'; });
        grupo.addEventListener('dragleave', () => { grupo.style.background = ''; });
        grupo.addEventListener('drop', e => {
            e.preventDefault(); grupo.style.background = '';
            const col = e.dataTransfer.getData('text/plain');
            if (col && !columnasAgrupadas.includes(col)) {
                columnasAgrupadas.push(col);
                actualizarGrupoColumnas();
            }
        });
    })();

    // Expandir/colapsar grupos
    $tablaBody.addEventListener('click', e => {
        const tr = e.target.closest('.fila-grupo');
        if (!tr) return;
        const id = tr.dataset.grupoId;
        if (expandedGroups.has(id)) expandedGroups.delete(id);
        else expandedGroups.add(id);
        cargarTabla(datosFiltrados);
    });

    // ============ PROVEEDORES ============
    async function cargarProveedores() {
        if (proveedoresCache) return proveedoresCache;
        try {
            const json = await fetchJSON(ROUTES.proveedores);
            proveedoresCache = json.data || [];
            return proveedoresCache;
        } catch (err) {
            toast(err?.data?.message || 'No se pudieron cargar los proveedores', 'error');
            return [];
        }
    }

    // ============ MODAL AGREGAR/EDITAR ============
    const $modalPrepago = document.getElementById('modalPrepago');
    const $formPrepago  = document.getElementById('formPrepago');
    const $modalTitulo  = document.getElementById('modalPrepagoTitulo');
    const $formError    = document.getElementById('formError');

    async function abrirModalCrear() {
        modoEdicion = false;
        $formPrepago.reset();
        document.getElementById('prepagoId').value = '';
        $modalTitulo.textContent = 'Agregar Prepago';
        document.getElementById('fecha').value = new Date().toISOString().slice(0, 10);
        $formError.style.display = 'none';

        const proveedores = await cargarProveedores();
        const sel = document.getElementById('proveedorId');
        sel.innerHTML = '<option value="">-- Seleccione proveedor --</option>';
        proveedores.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id; opt.textContent = p.nombre;
            sel.appendChild(opt);
        });

        $modalPrepago.style.display = 'flex';
    }

    async function abrirModalEditar(id) {
        modoEdicion = true;
        $formError.style.display = 'none';
        try {
            const [json, proveedores] = await Promise.all([
                fetchJSON(`${ROUTES.base}/${id}`),
                cargarProveedores(),
            ]);
            if (!json.success) throw new Error(json.message);
            const d = json.data;

            $formPrepago.reset();
            document.getElementById('prepagoId').value = d.id;
            document.getElementById('folio').value = d.folio || '';
            document.getElementById('fecha').value = d.fecha || '';
            document.getElementById('monto').value = d.monto;
            document.getElementById('observaciones').value = d.observaciones || '';

            const sel = document.getElementById('proveedorId');
            sel.innerHTML = '<option value="">-- Seleccione proveedor --</option>';
            proveedores.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id; opt.textContent = p.nombre;
                if (p.id == d.proveedor_id) opt.selected = true;
                sel.appendChild(opt);
            });

            $modalTitulo.textContent = 'Editar Prepago';
            $modalPrepago.style.display = 'flex';
        } catch (err) {
            toast(err?.data?.message || 'Error al cargar prepago', 'error');
        }
    }

    function cerrarModalPrepago() { $modalPrepago.style.display = 'none'; }
    document.getElementById('btnCerrarModal').onclick = cerrarModalPrepago;
    document.getElementById('btnCancelarForm').onclick = cerrarModalPrepago;

    $formPrepago.addEventListener('submit', async e => {
        e.preventDefault();
        $formError.style.display = 'none';
        const btn = document.getElementById('btnGuardarForm');
        btn.disabled = true; btn.textContent = 'Guardando...';

        const id = document.getElementById('prepagoId').value;
        const payload = {
            proveedor_id: document.getElementById('proveedorId').value,
            folio: document.getElementById('folio').value.trim() || null,
            fecha: document.getElementById('fecha').value,
            monto: parseFloat(document.getElementById('monto').value),
            observaciones: document.getElementById('observaciones').value.trim() || null,
        };

        const url = modoEdicion ? `${ROUTES.base}/${id}` : ROUTES.store;
        const method = modoEdicion ? 'PUT' : 'POST';

        try {
            const json = await fetchJSON(url, {
                method,
                body: JSON.stringify(payload),
            });
            if (!json.success) throw { data: json };
            toast(json.message || 'Guardado correctamente', 'success');
            cerrarModalPrepago();
            await cargarDatos(false);
        } catch (err) {
            const msg = err?.data?.message || err.message || 'Error al guardar';
            let html = `<strong>${esc(msg)}</strong>`;
            if (err?.data?.errors) {
                html += '<ul style="margin:6px 0 0 18px; padding:0;">';
                Object.values(err.data.errors).flat().forEach(m => html += `<li>${esc(m)}</li>`);
                html += '</ul>';
            }
            $formError.innerHTML = html;
            $formError.style.display = 'block';
        } finally {
            btn.disabled = false; btn.textContent = 'Guardar';
        }
    });

    // ============ MODAL VER ============
    const $modalVer = document.getElementById('modalVer');
    document.getElementById('btnCerrarVer').onclick = () => $modalVer.style.display = 'none';
    document.getElementById('btnCerrarVer2').onclick = () => $modalVer.style.display = 'none';

    async function abrirModalVer(id) {
        try {
            const json = await fetchJSON(`${ROUTES.base}/${id}`);
            if (!json.success) throw new Error(json.message);
            const d = json.data;
            document.getElementById('verContenido').innerHTML = `
                <table style="width:100%; font-size:14px; border-collapse:collapse;">
                    <tr><td style="padding:8px; color:#6c757d; width:40%;">Folio</td><td style="padding:8px; font-weight:bold;">${esc(d.folio || '-')}</td></tr>
                    <tr><td style="padding:8px; color:#6c757d;">Proveedor</td><td style="padding:8px;">${esc(d.proveedor || '-')}</td></tr>
                    <tr><td style="padding:8px; color:#6c757d;">Fecha</td><td style="padding:8px;">${esc(formatDate(d.fecha))}</td></tr>
                    <tr><td style="padding:8px; color:#6c757d;">Monto</td><td style="padding:8px; font-weight:bold; color:#2378e1;">${esc(formatCurrency(d.monto))}</td></tr>
                    <tr><td style="padding:8px; color:#6c757d;">Estatus</td><td style="padding:8px;"><span style="background:#28a745; color:white; padding:3px 10px; border-radius:12px; font-size:12px;">${esc(d.estatus || 'activo')}</span></td></tr>
                    <tr><td style="padding:8px; color:#6c757d;">Observaciones</td><td style="padding:8px;">${esc(d.observaciones || '-')}</td></tr>
                </table>`;
            $modalVer.style.display = 'flex';
        } catch (err) {
            toast(err?.data?.message || 'Error al cargar prepago', 'error');
        }
    }

    // ============ ACCIONES DE TABLA ============
    $tablaBody.addEventListener('click', async e => {
        const icon = e.target.closest('i[data-action]');
        if (!icon) return;
        const action = icon.dataset.action;
        const id = icon.dataset.id;

        if (action === 'edit') return abrirModalEditar(id);
        if (action === 'view') return abrirModalVer(id);
        if (action === 'pdf')  return window.open(`${ROUTES.base}/${id}/pdf`, '_blank');
        if (action === 'delete') {
            if (!confirm('¿Está seguro de eliminar este prepago?')) return;
            try {
                const json = await fetchJSON(`${ROUTES.base}/${id}`, { method: 'DELETE' });
                if (!json.success) throw { data: json };
                toast(json.message || 'Eliminado correctamente', 'success');
                await cargarDatos(false);
            } catch (err) {
                toast(err?.data?.message || 'Error al eliminar', 'error');
            }
        }
    });

    // ============ BOTONES TOP ============
    document.getElementById('btnAgregar').onclick = abrirModalCrear;
    document.getElementById('btnExcel').onclick = () => {
        const params = new URLSearchParams({
            fecha_inicio: $fechaInicio.value || '',
            fecha_fin: $fechaFin.value || '',
        });
        window.location.href = `${ROUTES.exportExcel}?${params.toString()}`;
    };

    // ============ MODAL COLUMNAS ============
    const $modalCols = document.getElementById('modalColumnas');
    document.getElementById('btnColumnas').onclick = () => {
        document.querySelectorAll('.col-toggle').forEach(cb => {
            cb.checked = columnasVisibles[cb.value] !== false;
        });
        $modalCols.style.display = 'flex';
    };
    document.getElementById('btnCerrarColumnas').onclick = () => $modalCols.style.display = 'none';
    document.getElementById('btnAplicarColumnas').onclick = () => {
        document.querySelectorAll('.col-toggle').forEach(cb => {
            columnasVisibles[cb.value] = cb.checked;
        });
        aplicarVisibilidadColumnas();
        $modalCols.style.display = 'none';
    };

    // ============ MODAL FILTRO ============
    const $modalFiltro = document.getElementById('modalFiltro');
    document.getElementById('btnCrearFiltro').onclick = () => {
        document.getElementById('filtroFechaInicio').value = $fechaInicio.value;
        document.getElementById('filtroFechaFin').value = $fechaFin.value;
        document.getElementById('filtroBuscar').value = $buscador.value;
        $modalFiltro.style.display = 'flex';
    };
    document.getElementById('btnCerrarFiltro').onclick = () => $modalFiltro.style.display = 'none';
    document.getElementById('btnAplicarFiltro').onclick = () => {
        $fechaInicio.value = document.getElementById('filtroFechaInicio').value;
        $fechaFin.value = document.getElementById('filtroFechaFin').value;
        $buscador.value = document.getElementById('filtroBuscar').value;
        $modalFiltro.style.display = 'none';
        cargarDatos(true);
    };
    document.getElementById('btnLimpiarFiltro').onclick = () => {
        document.getElementById('filtroFechaInicio').value = '';
        document.getElementById('filtroFechaFin').value = '';
        document.getElementById('filtroBuscar').value = '';
    };

    // ============ BÚSQUEDA LOCAL (input) ============
    let searchTimer;
    $buscador.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(filtrarLocal, 250);
    });

    // ============ PAGINACIÓN ============
    document.querySelectorAll('.pagina-btn').forEach(btn => {
        btn.addEventListener('click', () => cambiarPagina(parseInt(btn.dataset.pagina, 10)));
    });
    document.getElementById('btnPrimera').onclick   = () => cambiarPagina(1);
    document.getElementById('btnAnterior').onclick  = () => cambiarPagina(paginaActual - 1);
    document.getElementById('btnSiguiente').onclick = () => cambiarPagina(paginaActual + 1);
    document.getElementById('btnUltima').onclick    = () => cambiarPagina(Math.max(1, Math.ceil(datosFiltrados.length / registrosPorPagina)));

    function cambiarPagina(p) {
        const totalPaginas = Math.max(1, Math.ceil(datosFiltrados.length / registrosPorPagina));
        if (p >= 1 && p <= totalPaginas) {
            paginaActual = p;
            cargarTabla(datosFiltrados);
        }
    }

    // ============ FECHAS ============
    $fechaInicio.addEventListener('change', () => cargarDatos(true));
    $fechaFin.addEventListener('change', () => cargarDatos(true));

    // ============ INICIO ============
    cargarDatos(true);
});
</script>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #2378e1; }
    .semaforo .card-header h2 { color: #2378e1 !important; }
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000 !important; }
    #tablaBody tr:nth-child(odd)  { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    #tablaBody td i { transition: transform 0.2s; font-size: 14px; color: #083CAE; cursor: pointer; }
    #tablaBody td i:hover { transform: scale(1.2); }
    #tablaBody td:last-child { background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1); z-index: 15; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #2378e1; color: #000 !important; }
    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
    .fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
    .fila-grupo:hover { background-color: #e1f0ff !important; }
    .fila-detalle { background-color: #fff; }
    #paginacionContainer button { background: transparent !important; border: none !important; color: #2378e1 !important; cursor: pointer; }
    #paginacionContainer button:hover { opacity: 0.7; }
    #paginacionContainer button i { color: #2378e1 !important; }
    #btnCrearFiltro, #btnCrearFiltro:hover, #btnCrearFiltro:focus { background: transparent !important; border: none !important; box-shadow: none !important; outline: none !important; }
    #btnCrearFiltro i, #btnCrearFiltro span, #paginacionInfo { color: #2378e1 !important; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 768px) {
        input[type="date"], input#buscador { width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection