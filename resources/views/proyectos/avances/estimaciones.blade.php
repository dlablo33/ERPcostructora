@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estimaciones de Obra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Estimaciones de Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RESUMEN -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Estimaciones</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalEstimaciones">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Monto Devengado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="montoDevengado">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Facturado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="montoFacturado">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">% Cobro</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="porcentajeCobro">0%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="filtroProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                            </select>
                        </div>
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; cursor: pointer; color: #083CAE;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; color: #083CAE;">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p>Cargando datos...</p>
                </div>

                <!-- Sin datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 40px; background: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; display: none;">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da;"></i>
                    <h3 style="color: #6c757d;">Sin datos</h3>
                    <p>No hay estimaciones para mostrar</p>
                </div>

                <!-- Tabla de Estimaciones -->
                <div class="table-responsive" id="tablaContainer" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; display: none;">
                    <table class="table table-bordered table-hover" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Proyecto</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Partida</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Fecha</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Avance %</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Cantidad Ejecutada</th>
                                <th style="text-align: right; vertical-align: middle; padding: 12px 8px;">Monto Devengado</th>
                                <th style="text-align: right; vertical-align: middle; padding: 12px 8px;">Facturado</th>
                                <th style="text-align: right; vertical-align: middle; padding: 12px 8px;">Por Cobrar</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">% Cobro</th>
                                <th style="text-align: center; vertical-align: middle; padding: 12px 8px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="background-color: #e9ecef; font-weight: bold; position: sticky; bottom: 0;"></tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <button id="btnCrearFiltro" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-filter"></i> Crear filtro</button>
                    <div style="display: flex; gap: 5px;">
                        <button id="btnPrimera" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <button id="btnSiguiente" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="background: none; border: none; color: #2378e1; cursor: pointer;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="color: #2378e1;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar/Editar Estimación -->
<div id="modalEstimacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(3px);">
    <div style="background: white; border-radius: 12px; width: 90%; max-width: 650px; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.4); position: relative; z-index: 100000;">
        <div style="padding: 20px; border-bottom: 2px solid #083CAE; background: #f8f9fa; border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> <span id="modalTitulo">Nueva Estimación</span></h3>
        </div>
        <div style="padding: 25px;">
            <input type="hidden" id="modalId">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select id="modalProyecto" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; background: white;">
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Partida <span style="color: #dc3545;">*</span></label>
                <select id="modalPartida" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; background: white;">
                    <option value="">Primero seleccione un proyecto</option>
                </select>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Fecha <span style="color: #dc3545;">*</span></label>
                <input type="date" id="modalFecha" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Avance Porcentaje (%) <span style="color: #dc3545;">*</span></label>
                <input type="number" id="modalAvance" step="0.01" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px;" placeholder="0-100">
                <small id="avanceAnteriorMsg" style="color:#6c757d; font-size: 12px; display: block; margin-top: 5px;"></small>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Cantidad Ejecutada</label>
                <input type="number" id="modalCantidad" step="0.01" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width:100%; padding: 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px;"></textarea>
            </div>
        </div>
        <div style="padding: 20px 25px; border-top: 1px solid #dee2e6; text-align: right; background: #f8f9fa; border-radius: 0 0 12px 12px;">
            <button id="btnCancelarModal" style="padding: 10px 25px; background: white; border: 1px solid #6c757d; border-radius: 6px; margin-right: 10px; cursor: pointer; font-size: 14px;">Cancelar</button>
            <button id="btnGuardarModal" style="padding: 10px 25px; background: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">Guardar</button>
        </div>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    
    .table th { 
        white-space: nowrap; 
        font-size: 13px; 
        background-color: #2378e1 !important; 
        color: white; 
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    
    .table td { 
        font-size: 13px; 
        padding: 10px 8px; 
        color: #333;
        vertical-align: middle;
    }
    
    .table td:first-child { font-weight: 500; }
    .table td:nth-child(2) { font-weight: 500; }
    .table td:nth-child(6), 
    .table td:nth-child(7), 
    .table td:nth-child(8) { text-align: right !important; font-weight: 500; }
    
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f8f9fa; }
    #tablaBody tr:hover { background-color: #e8f0fe; }
    
    tfoot td { 
        font-weight: bold; 
        background-color: #e9ecef !important; 
        border-top: 2px solid #083CAE;
        padding: 12px 8px;
    }
    
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }
    
    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        margin: 0 4px;
        transition: transform 0.2s;
    }
    
    .btn-icon:hover {
        transform: scale(1.1);
    }
    
    .btn-edit { color: #083CAE; }
    .btn-delete { color: #dc3545; }
    
    /* Estilo para el semáforo de avance */
    .semaforo-verde { color: #28a745; font-weight: bold; }
    .semaforo-amarillo { color: #ffc107; font-weight: bold; }
    .semaforo-rojo { color: #dc3545; font-weight: bold; }
    
    @media (max-width: 768px) {
        select, input, button { width: 100% !important; margin-top: 5px; }
        .table th, .table td { font-size: 11px; padding: 6px 4px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let datosOriginales = [];
    let currentPage = 1;
    let rowsPerPage = 15;
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let proyectosList = [];

    // ==========================================
    // FUNCIONES AUXILIARES
    // ==========================================
    function formatCurrency(amount) {
        if (amount >= 1000000) return '$' + (amount / 1000000).toFixed(1) + 'M';
        if (amount >= 1000) return '$' + (amount / 1000).toFixed(1) + 'K';
        return '$' + parseFloat(amount).toFixed(2);
    }
    
    function formatCurrencyFull(amount) {
        return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        let date = new Date(dateString);
        return date.toLocaleDateString('es-MX');
    }
    
    function getSemaforoClass(avance) {
        if (avance >= 75) return 'semaforo-verde';
        if (avance >= 50) return 'semaforo-amarillo';
        return 'semaforo-rojo';
    }

    // ==========================================
    // CARGAR PROYECTOS
    // ==========================================
    async function cargarProyectos() {
        try {
            const response = await fetch('/estimaciones/api/proyectos');
            const result = await response.json();
            if (result.success) {
                proyectosList = result.data;
                const selectProyecto = document.getElementById('filtroProyecto');
                const modalProyecto = document.getElementById('modalProyecto');
                
                selectProyecto.innerHTML = '<option value="">Todos los proyectos</option>';
                modalProyecto.innerHTML = '<option value="">Seleccionar...</option>';
                
                proyectosList.forEach(p => {
                    selectProyecto.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                    modalProyecto.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                });
            }
        } catch (error) {
            console.error('Error cargando proyectos:', error);
        }
    }

    // ==========================================
    // CARGAR PARTIDAS POR PROYECTO
    // ==========================================
    async function cargarPartidasPorProyecto(proyectoId) {
        if (!proyectoId) {
            document.getElementById('modalPartida').innerHTML = '<option value="">Primero seleccione un proyecto</option>';
            return;
        }
        try {
            const response = await fetch(`/estimaciones/api/partidas/${proyectoId}`);
            const result = await response.json();
            if (result.success) {
                const select = document.getElementById('modalPartida');
                select.innerHTML = '<option value="">Seleccionar partida...</option>';
                result.data.forEach(p => {
                    select.innerHTML += `<option value="${p.id}" data-importe="${p.importe}" data-unidad="${p.unidad}">${p.codigo} - ${p.nombre} (${formatCurrencyFull(p.importe)})</option>`;
                });
            }
        } catch (error) {
            console.error('Error cargando partidas:', error);
        }
    }

    // ==========================================
    // CARGAR ESTIMACIONES
    // ==========================================
    async function cargarEstimaciones() {
        const loading = document.getElementById('loadingSpinner');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const container = document.getElementById('tablaContainer');
        
        loading.style.display = 'block';
        
        try {
            const params = new URLSearchParams();
            const proyectoId = document.getElementById('filtroProyecto').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            const search = document.getElementById('buscador').value;
            
            if (proyectoId) params.append('proyecto_id', proyectoId);
            if (fechaInicio) params.append('fecha_inicio', fechaInicio);
            if (fechaFin) params.append('fecha_fin', fechaFin);
            if (search) params.append('search', search);
            
            const response = await fetch(`/estimaciones/api/detalle?${params.toString()}`);
            const result = await response.json();
            
            loading.style.display = 'none';
            
            if (result.success && result.data && result.data.length > 0) {
                datosOriginales = result.data;
                actualizarResumen(result.total);
                renderTabla(result.data);
                container.style.display = 'block';
                sinDatos.style.display = 'none';
            } else {
                container.style.display = 'none';
                sinDatos.style.display = 'block';
                document.getElementById('totalEstimaciones').textContent = '0';
                document.getElementById('montoDevengado').textContent = '$0.00';
                document.getElementById('montoFacturado').textContent = '$0.00';
                document.getElementById('porcentajeCobro').textContent = '0%';
            }
        } catch (error) {
            loading.style.display = 'none';
            console.error('Error cargando estimaciones:', error);
            container.style.display = 'none';
            sinDatos.style.display = 'block';
        }
    }
    
    function actualizarResumen(total) {
        const totalDevengado = total?.devengado || 0;
        const totalFacturado = total?.facturado || 0;
        const pctCobro = totalDevengado > 0 ? (totalFacturado / totalDevengado * 100) : 0;
        
        document.getElementById('totalEstimaciones').textContent = datosOriginales.length;
        document.getElementById('montoDevengado').textContent = formatCurrency(totalDevengado);
        document.getElementById('montoFacturado').textContent = formatCurrency(totalFacturado);
        document.getElementById('porcentajeCobro').textContent = pctCobro.toFixed(1) + '%';
    }
    
    function renderTabla(datos) {
        const tbody = document.getElementById('tablaBody');
        const tfoot = document.getElementById('tablaFoot');
        
        const start = (currentPage - 1) * rowsPerPage;
        const pageData = datos.slice(start, start + rowsPerPage);
        
        if (pageData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" style="text-align: center;">No hay datos disponibles</td></tr>';
            tfoot.innerHTML = '';
            return;
        }
        
        tbody.innerHTML = pageData.map(item => {
            const semaforoClass = getSemaforoClass(item.avance_porcentaje || 0);
            return `
            <tr>
                <td style="text-align: left;">${item.proyecto || '-'}</td>
                <td style="text-align: left;">${item.partida_codigo || '-'}<br><small style="color:#666;">${item.partida_nombre || ''}</small></td>
                <td style="text-align: center;">${formatDate(item.fecha)}</td>
                <td style="text-align: center;">
                    <span class="${semaforoClass}">${item.avance_porcentaje || 0}%</span>
                    ${item.avance_periodo > 0 ? `<small style="color:#28a745;"> (+${item.avance_periodo}%)</small>` : ''}
                </td>
                <td style="text-align: center;">${item.cantidad_ejecutada || '-'} ${item.unidad || ''}</td>
                <td style="text-align: right;"><strong>${formatCurrencyFull(item.monto_devengado || 0)}</strong></td>
                <td style="text-align: right;">${formatCurrencyFull(item.monto_facturado || 0)}</td>
                <td style="text-align: right;"><span style="color: ${item.cuenta_por_cobrar > 0 ? '#dc3545' : '#28a745'};">${formatCurrencyFull(item.cuenta_por_cobrar || 0)}</span></td>
                <td style="text-align: center;">
                    <div style="width: 60px; display: inline-block; background: #e9ecef; border-radius: 10px;">
                        <div style="width: ${item.porcentaje_cobro || 0}%; background: #28a745; color: white; font-size: 10px; border-radius: 10px; text-align: center;">${item.porcentaje_cobro || 0}%</div>
                    </div>
                </td>
                <td style="text-align: center;">
                    <i class="fas fa-edit btn-icon btn-edit" onclick="editarEstimacion(${item.id})" title="Editar"></i>
                    <i class="fas fa-trash-alt btn-icon btn-delete" onclick="eliminarEstimacion(${item.id})" title="Eliminar"></i>
                </td>
             </tr>
            `;
        }).join('');
        
        let totalDevengado = datos.reduce((s,i) => s + (i.monto_devengado || 0), 0);
        let totalFacturado = datos.reduce((s,i) => s + (i.monto_facturado || 0), 0);
        let totalPorCobrar = datos.reduce((s,i) => s + (i.cuenta_por_cobrar || 0), 0);
        let pctCobroTotal = totalDevengado > 0 ? (totalFacturado / totalDevengado * 100) : 0;
        
        tfoot.innerHTML = `<tr style="background:#e9ecef; font-weight:bold">
            <td colspan="5" style="text-align: center;"><strong>TOTALES</strong></td>
            <td style="text-align: right;"><strong>${formatCurrencyFull(totalDevengado)}</strong></td>
            <td style="text-align: right;"><strong>${formatCurrencyFull(totalFacturado)}</strong></td>
            <td style="text-align: right;"><strong>${formatCurrencyFull(totalPorCobrar)}</strong></td>
            <td style="text-align: center;"><strong>${pctCobroTotal.toFixed(1)}%</strong></td>
            <td></td>
         </tr>`;
        
        actualizarPaginacion(datos.length);
    }
    
    function actualizarPaginacion(total) {
        const totalPages = Math.ceil(total / rowsPerPage);
        document.getElementById('paginaActual').textContent = currentPage;
        document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage-1)*rowsPerPage+1, total)}-${Math.min(currentPage*rowsPerPage, total)} de ${total}`;
        document.getElementById('btnPrimera').disabled = currentPage === 1;
        document.getElementById('btnAnterior').disabled = currentPage === 1;
        document.getElementById('btnSiguiente').disabled = currentPage === totalPages;
        document.getElementById('btnUltima').disabled = currentPage === totalPages;
    }

    // ==========================================
    // CRUD ESTIMACIONES
    // ==========================================
    window.editarEstimacion = async function(id) {
        try {
            const response = await fetch(`/estimaciones/api/${id}`);
            const result = await response.json();
            if (result.success) {
                const data = result.data;
                document.getElementById('modalId').value = data.id;
                document.getElementById('modalProyecto').value = data.proyecto_id;
                await cargarPartidasPorProyecto(data.proyecto_id);
                setTimeout(() => {
                    document.getElementById('modalPartida').value = data.partida_id;
                }, 100);
                document.getElementById('modalFecha').value = data.fecha;
                document.getElementById('modalAvance').value = data.avance_porcentaje;
                document.getElementById('modalCantidad').value = data.cantidad_ejecutada || '';
                document.getElementById('modalObservaciones').value = data.observaciones || '';
                document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-edit"></i> Editar Estimación';
                
                if (data.avance_anterior > 0) {
                    document.getElementById('avanceAnteriorMsg').innerHTML = `Avance anterior: ${data.avance_anterior}% | Avance del período: ${data.avance_periodo}%`;
                } else {
                    document.getElementById('avanceAnteriorMsg').innerHTML = '';
                }
                
                document.getElementById('modalEstimacion').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            console.error('Error cargando estimación:', error);
            alert('Error al cargar la estimación');
        }
    };
    
    window.eliminarEstimacion = async function(id) {
        if (!confirm('¿Está seguro de eliminar esta estimación?')) return;
        try {
            const response = await fetch(`/estimaciones/api/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const result = await response.json();
            if (result.success) {
                cargarEstimaciones();
                alert('Estimación eliminada correctamente');
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error eliminando estimación:', error);
            alert('Error al eliminar la estimación');
        }
    };
    
    async function guardarEstimacion() {
        const id = document.getElementById('modalId').value;
        const data = {
            proyecto_id: document.getElementById('modalProyecto').value,
            partida_id: document.getElementById('modalPartida').value,
            fecha: document.getElementById('modalFecha').value,
            avance_porcentaje: parseFloat(document.getElementById('modalAvance').value),
            cantidad_ejecutada: parseFloat(document.getElementById('modalCantidad').value) || null,
            observaciones: document.getElementById('modalObservaciones').value
        };
        
        if (!data.proyecto_id || !data.partida_id || !data.fecha || isNaN(data.avance_porcentaje)) {
            alert('Complete los campos requeridos (*)');
            return;
        }
        
        if (data.avance_porcentaje < 0 || data.avance_porcentaje > 100) {
            alert('El avance debe estar entre 0 y 100%');
            return;
        }
        
        try {
            const url = id ? `/estimaciones/api/${id}` : '/estimaciones/api';
            const method = id ? 'PUT' : 'POST';
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                cerrarModal();
                cargarEstimaciones();
                alert(id ? 'Estimación actualizada correctamente' : 'Estimación creada correctamente');
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Error guardando estimación:', error);
            alert('Error al guardar la estimación');
        }
    }
    
    function cerrarModal() {
        document.getElementById('modalEstimacion').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('modalId').value = '';
        document.getElementById('modalProyecto').value = '';
        document.getElementById('modalPartida').innerHTML = '<option value="">Primero seleccione un proyecto</option>';
        document.getElementById('modalFecha').value = '';
        document.getElementById('modalAvance').value = '';
        document.getElementById('modalCantidad').value = '';
        document.getElementById('modalObservaciones').value = '';
        document.getElementById('avanceAnteriorMsg').innerHTML = '';
        document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-plus-circle"></i> Nueva Estimación';
    }

    // ==========================================
    // EVENTOS
    // ==========================================
    document.getElementById('filtroProyecto').addEventListener('change', () => cargarEstimaciones());
    document.getElementById('fechaInicio').addEventListener('change', () => cargarEstimaciones());
    document.getElementById('fechaFin').addEventListener('change', () => cargarEstimaciones());
    document.getElementById('buscador').addEventListener('input', () => cargarEstimaciones());
    document.getElementById('btnAgregar').addEventListener('click', () => {
        cerrarModal();
        document.getElementById('modalEstimacion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });
    document.getElementById('btnExcel').addEventListener('click', () => {
        const params = new URLSearchParams();
        if (document.getElementById('filtroProyecto').value) params.append('proyecto_id', document.getElementById('filtroProyecto').value);
        if (document.getElementById('fechaInicio').value) params.append('fecha_inicio', document.getElementById('fechaInicio').value);
        if (document.getElementById('fechaFin').value) params.append('fecha_fin', document.getElementById('fechaFin').value);
        window.open(`/estimaciones/exportar?${params.toString()}`, '_blank');
    });
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Filtro avanzado en desarrollo'));
    
    // Modal
    document.getElementById('btnCancelarModal').addEventListener('click', cerrarModal);
    document.getElementById('btnGuardarModal').addEventListener('click', guardarEstimacion);
    document.getElementById('modalProyecto').addEventListener('change', (e) => {
        cargarPartidasPorProyecto(e.target.value);
    });
    
    // Paginación
    document.getElementById('btnPrimera').addEventListener('click', () => { currentPage = 1; renderTabla(datosOriginales); });
    document.getElementById('btnAnterior').addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderTabla(datosOriginales); } });
    document.getElementById('btnSiguiente').addEventListener('click', () => { const max = Math.ceil(datosOriginales.length / rowsPerPage); if (currentPage < max) { currentPage++; renderTabla(datosOriginales); } });
    document.getElementById('btnUltima').addEventListener('click', () => { currentPage = Math.ceil(datosOriginales.length / rowsPerPage); renderTabla(datosOriginales); });
    
    // Fechas por defecto
    const hoy = new Date();
    const primerDia = new Date(hoy.getFullYear(), 0, 1);
    document.getElementById('fechaInicio').value = primerDia.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
    
    // Inicializar
    cargarProyectos();
    cargarEstimaciones();
});
</script>
@endsection