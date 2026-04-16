@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Presupuesto de Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Presupuesto de Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE RESUMEN -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Presupuesto Total</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="totalPresupuesto">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Ejecutado</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="ejecutado">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Por Ejecutar</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="porEjecutar">$0.00</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase;">Avance Global</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="avanceGlobal">0%</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 350px;">
                            <option value="">Cargando proyectos...</option>
                        </select>
                        
                        <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                            <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                            <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorSeccion" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todas las secciones</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="vista-btn active" data-vista="proyecto" style="padding: 6px 12px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-building"></i> Por Proyecto
                            </button>
                            <button class="vista-btn" data-vista="partidas" style="padding: 6px 12px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-list"></i> Por Partidas
                            </button>
                        </div>

                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; cursor: pointer; color: #083CAE;" title="Agregar Partida">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                        </div>

                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar partida..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Info Proyecto -->
                <div id="infoProyecto" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                            <div style="font-weight: 600; color: #083CAE; font-size: 18px;" id="proyectoNombre">-</div>
                            <div style="font-size: 13px; color: #495057;" id="proyectoTipo">-</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Cliente</div>
                            <div style="font-weight: 500;" id="proyectoCliente">-</div>
                            <div style="font-size: 12px; color: #6c757d;" id="proyectoClienteRFC">-</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fechas</div>
                            <div style="font-weight: 500;" id="proyectoFechas">-</div>
                            <div style="font-size: 12px; color: #6c757d;" id="proyectoDuracion">-</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Ubicación</div>
                            <div style="font-weight: 500;" id="proyectoUbicacion">-</div>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando datos...</p>
                </div>

                <!-- Mensaje Sin Datos -->
                <div id="sinDatosMensaje" style="text-align: center; padding: 40px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; display: none;">
                    <i class="fas fa-calculator" style="font-size: 48px; color: #ced4da;"></i>
                    <h3 style="color: #6c757d;">Sin datos</h3>
                    <p style="color: #adb5bd;">No hay partidas para mostrar</p>
                </div>

                <!-- VISTA POR PROYECTO -->
                <div id="vistaProyecto" class="vista-content active">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-chart-pie"></i> Distribución por Categoría</h4>
                            <div id="distribucionCategorias"></div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-chart-line"></i> Avance por Categoría</h4>
                            <div id="avanceCategorias"></div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                            <h4 style="color: #083CAE; margin-bottom: 15px;"><i class="fas fa-chart-bar"></i> Métricas Clave</h4>
                            <div id="metricasClave"></div>
                        </div>
                    </div>

                    <div style="background-color: white; border: 1px solid #e0e0e0; border-radius: 12px; overflow-x: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="background-color: #083CAE; padding: 16px 24px;">
                            <h5 style="margin: 0; color: white; font-weight: 600;">
                                <i class="fas fa-chart-simple" style="margin-right: 8px;"></i> 
                                Resumen por Secciones
                                <span style="font-size: 12px; font-weight: normal; opacity: 0.9; margin-left: 10px;">Haz clic en cualquier fila para ver los detalles</span>
                            </h5>
                        </div>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 800px;">
                                <thead style="position: sticky; top: 0; z-index: 10;">
                                    <tr style="background-color: #083CAE; color: white;">
                                        <th style="width: 40px; padding: 14px 12px; text-align: center; font-weight: 600;"></th>
                                        <th style="padding: 14px 12px; text-align: left; font-weight: 600;">Sección</th>
                                        <th style="padding: 14px 12px; text-align: right; font-weight: 600;">Presupuesto</th>
                                        <th style="padding: 14px 12px; text-align: right; font-weight: 600;">Ejecutado</th>
                                        <th style="padding: 14px 12px; text-align: right; font-weight: 600;">Pendiente</th>
                                        <th style="padding: 14px 12px; text-align: center; font-weight: 600;">Avance</th>
                                        <th style="padding: 14px 12px; text-align: center; font-weight: 600;">Partidas</th>
                                    </tr>
                                </thead>
                                <tbody id="resumenSeccionesBody"></tbody>
                                <tfoot id="resumenSeccionesFoot" style="background-color: #f8f9fc; border-top: 2px solid #e0e0e0;"></tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- VISTA POR PARTIDAS -->
                <div id="vistaPartidas" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 600px; overflow-y: auto;">
                        <table class="table table-bordered" style="width: 100%; font-size: 12px;">
                            <thead style="position: sticky; top: 0; background-color: #083CAE; color: white;">
                                <tr>
                                    <th>Sección</th>
                                    <th>Código</th>
                                    <th>Partida</th>
                                    <th>Categoría</th>
                                    <th>Unidad</th>
                                    <th>Cantidad Presupuestada</th>
                                    <th>Cantidad Ejecutada</th>
                                    <th>P.U.</th>
                                    <th>Importe</th>
                                    <th>Ejecutado</th>
                                    <th>Pendiente</th>
                                    <th>% Avance</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyPartidas"></tbody>
                            <tfoot id="tablaFootPartidas" style="background-color: #e9ecef; font-weight: bold;"></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Partida -->
<div id="modalPartida" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6;">
            <h3 style="margin: 0; color: #083CAE;"><span id="modalTitulo">Agregar Partida</span></h3>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="modalPartidaId">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div><label>Sección</label><input type="text" id="modalSeccion" class="form-control" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                <div><label>Código *</label><input type="text" id="modalCodigo" class="form-control" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                <div><label>Categoría *</label>
                    <select id="modalCategoria" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                        <option value="materiales">Materiales</option>
                        <option value="mano_obra">Mano de Obra</option>
                        <option value="maquinaria">Maquinaria</option>
                        <option value="subcontratos">Subcontratos</option>
                        <option value="indirectos">Indirectos</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:15px"><label>Descripción *</label><input type="text" id="modalNombre" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:15px; margin-bottom:15px">
                <div><label>Unidad</label><input type="text" id="modalUnidad" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                <div><label>Cantidad</label><input type="number" id="modalCantidad" step="0.01" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                <div><label>Precio Unitario</label><input type="number" id="modalPrecioUnitario" step="0.01" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                <div><label>Importe</label><div id="modalImporte" style="background:#f8f9fa; padding:8px; border:1px solid #ced4da; border-radius:4px;">$0.00</div></div>
            </div>
        </div>
        <div style="padding:20px; border-top:1px solid #dee2e6; text-align:right">
            <button id="btnCancelarModal" style="padding:8px 20px; background:white; border:1px solid #6c757d; border-radius:4px; margin-right:10px; cursor:pointer;">Cancelar</button>
            <button id="btnGuardarModal" style="padding:8px 20px; background:#083CAE; color:white; border:none; border-radius:4px; cursor:pointer;">Guardar</button>
        </div>
    </div>
</div>

<style>
    .custom-card { transition: transform 0.2s; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8,60,174,0.15); }
    
    .badge-categoria { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; }
    .badge-materiales { background: #cce5ff; color: #0d6efd; }
    .badge-mano_obra { background: #d4edda; color: #155724; }
    .badge-maquinaria { background: #fff3cd; color: #856404; }
    .badge-subcontratos { background: #f8d7da; color: #721c24; }
    .badge-indirectos { background: #e9ecef; color: #495057; }
    
    .progress-mini { width: 60px; height: 6px; background: #e9ecef; border-radius: 3px; display: inline-block; margin-right: 5px; }
    .progress-mini-fill { height: 100%; border-radius: 3px; }
    .progress-mini-fill.success { background: #28a745; }
    .progress-mini-fill.warning { background: #ff8c00; }
    .progress-mini-fill.danger { background: #dc3545; }
    
    .vista-btn { transition: all 0.3s; cursor: pointer; }
    .vista-btn.active { background-color: #083CAE !important; color: white !important; }
    
    .fila-seccion { cursor: pointer; transition: all 0.2s ease; border-bottom: 1px solid #f0f0f0; }
    .fila-seccion:hover { background-color: #e8f0fe !important; }
    .fila-seccion.expandida { background-color: #e8f0fe !important; border-left: 3px solid #083CAE; }
    .fila-seccion td { padding: 12px 8px; vertical-align: middle; }
    
    .texto-ejecutado { color: #00A86B !important; font-weight: 600 !important; }
    .texto-pendiente { color: #FF6B00 !important; font-weight: 600 !important; }
    
    .mini-header { background-color: #2378e1 !important; color: white !important; font-weight: 600 !important; font-size: 11px !important; padding: 8px 6px !important; }
    .mini-header th { background-color: #2378e1 !important; color: white !important; font-weight: 600; font-size: 11px; padding: 8px 6px; text-align: center; }
    .mini-header th:first-child { padding-left: 40px; text-align: left; }
    
    .fila-partida { background-color: #ffffff; border-bottom: 1px solid #f0f0f0; }
    .fila-partida:hover { background-color: #f8f9fc !important; }
    .fila-partida td { padding: 10px 6px; vertical-align: middle; font-size: 12px; }
    
    .icono-expandir { transition: transform 0.2s ease; display: inline-block; color: #083CAE; font-size: 12px; }
    .icono-expandir.rotado { transform: rotate(90deg); }
    
    .badge-partidas { display: inline-block; background-color: #e9ecef; color: #495057; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .texto-avance { font-weight: 600; font-size: 12px; }
    
    @media (max-width: 768px) { 
        select, input, button { width:100% !important; } 
        .fila-partida td { padding: 6px 3px; font-size: 10px; }
        .mini-header th { font-size: 9px; padding: 5px 3px; }
        .badge-categoria { font-size: 9px; padding: 2px 5px; }
        table { min-width: 700px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentProjectId = null;
    let seccionesExpandidas = new Set();
    let proyectosList = [];
    let partidasPorSeccion = {};

    function formatCurrencyFull(amount) {
        return '$' + parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    function getCategoriaBadge(categoria) {
        const classes = { materiales:'badge-materiales', mano_obra:'badge-mano_obra', maquinaria:'badge-maquinaria', subcontratos:'badge-subcontratos', indirectos:'badge-indirectos' };
        const labels = { materiales:'Materiales', mano_obra:'Mano Obra', maquinaria:'Maquinaria', subcontratos:'Subcontratos', indirectos:'Indirectos' };
        return `<span class="badge-categoria ${classes[categoria] || ''}">${labels[categoria] || categoria}</span>`;
    }
    
    function getProgressClass(avance) {
        if (avance >= 75) return 'success';
        if (avance >= 50) return 'warning';
        return 'danger';
    }

    // Cargar proyectos
    async function cargarProyectos() {
        try {
            const response = await fetch('/api/proyectos');
            const data = await response.json();
            proyectosList = data.data || [];
            const select = document.getElementById('selectorProyecto');
            select.innerHTML = '<option value="">Seleccionar proyecto...</option>';
            proyectosList.forEach(p => {
                select.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
            });
            if (proyectosList.length > 0) {
                select.value = proyectosList[0].id;
                currentProjectId = proyectosList[0].id;
                await cargarPresupuesto(currentProjectId);
                await cargarResumenSecciones(currentProjectId);
                await cargarPartidas(currentProjectId);
            }
        } catch (error) {
            console.error('Error cargando proyectos:', error);
        }
    }

    // Cargar presupuesto
    async function cargarPresupuesto(proyectoId) {
        try {
            const response = await fetch(`/api/proyectos/${proyectoId}/presupuesto`);
            const result = await response.json();
            if (result.success) {
                const p = result.proyecto;
                document.getElementById('totalPresupuesto').textContent = formatCurrencyFull(p.presupuesto_total);
                document.getElementById('ejecutado').textContent = formatCurrencyFull(p.ejecutado_total);
                document.getElementById('porEjecutar').textContent = formatCurrencyFull(p.pendiente_total);
                document.getElementById('avanceGlobal').textContent = p.avance_global + '%';
                
                document.getElementById('proyectoNombre').textContent = p.nombre;
                document.getElementById('proyectoTipo').textContent = p.tipo_proyecto || '-';
                document.getElementById('proyectoCliente').textContent = p.cliente_nombre || '-';
                document.getElementById('proyectoClienteRFC').textContent = p.cliente_rfc || '-';
                document.getElementById('proyectoFechas').textContent = (p.fecha_inicio || '-') + ' - ' + (p.fecha_fin || '-');
                document.getElementById('proyectoUbicacion').textContent = p.ubicacion || '-';
                
                const cats = result.categorias;
                let distHtml = '';
                let avanceHtml = '';
                let colores = { materiales:'#2378e1', mano_obra:'#28a745', maquinaria:'#ff8c00', subcontratos:'#17a2b8', indirectos:'#6c757d' };
                for (let [key, data] of Object.entries(cats)) {
                    let pct = data.presupuesto > 0 ? (data.presupuesto / p.presupuesto_total * 100).toFixed(1) : 0;
                    distHtml += `<div style="margin-bottom:10px"><div style="display:flex; justify-content:space-between"><span>${data.nombre}</span><span>${formatCurrencyFull(data.presupuesto)} (${pct}%)</span></div>
                        <div style="width:100%; height:8px; background:#e9ecef; border-radius:4px"><div style="width:${pct}%; height:8px; background:${colores[key]}; border-radius:4px"></div></div></div>`;
                    avanceHtml += `<div style="margin-bottom:10px"><div style="display:flex; justify-content:space-between"><span>${data.nombre}</span><span>${data.avance}%</span></div>
                        <div style="width:100%; height:8px; background:#e9ecef; border-radius:4px"><div style="width:${data.avance}%; height:8px; background:${data.avance>=75?'#28a745':'#ff8c00'}; border-radius:4px"></div></div></div>`;
                }
                document.getElementById('distribucionCategorias').innerHTML = distHtml;
                document.getElementById('avanceCategorias').innerHTML = avanceHtml;
                
                document.getElementById('metricasClave').innerHTML = `
                    <div><div style="color:#6c757d; font-size:12px">Presupuesto Total</div><div style="font-size:22px; font-weight:700; color:#083CAE">${formatCurrencyFull(p.presupuesto_total)}</div></div>
                    <div style="margin-top:15px"><div style="color:#6c757d; font-size:12px">Partidas Activas</div><div style="font-size:22px; font-weight:700; color:#083CAE">${p.partidas_activas || 0}</div></div>
                    <div style="margin-top:15px"><div style="color:#6c757d; font-size:12px">Ejecutado vs Presupuesto</div><div style="font-size:22px; font-weight:700; color:${p.avance_global >= 75 ? '#00A86B' : (p.avance_global >= 50 ? '#FF6B00' : '#dc3545')}">${p.avance_global}%</div></div>`;
            }
        } catch (error) {
            console.error('Error cargando presupuesto:', error);
        }
    }

    // Cargar partidas de una sección
    async function cargarPartidasDeSeccion(seccion) {
        if (partidasPorSeccion[seccion]) {
            return partidasPorSeccion[seccion];
        }
        
        try {
            const response = await fetch(`/api/proyectos/${currentProjectId}/partidas-por-seccion/${encodeURIComponent(seccion)}`);
            const result = await response.json();
            if (result.success) {
                partidasPorSeccion[seccion] = result.data;
                return result.data;
            }
            return [];
        } catch (error) {
            console.error(`Error cargando partidas de sección ${seccion}:`, error);
            return [];
        }
    }

    // Toggle sección
    window.toggleSeccion = async function(seccion) {
        if (seccionesExpandidas.has(seccion)) {
            seccionesExpandidas.delete(seccion);
        } else {
            seccionesExpandidas.add(seccion);
            await cargarPartidasDeSeccion(seccion);
        }
        await renderResumenSecciones();
    };

    // Render resumen secciones
    async function renderResumenSecciones() {
        try {
            const response = await fetch(`/api/proyectos/${currentProjectId}/resumen-seccion`);
            const result = await response.json();
            
            if (result.success) {
                let html = '';
                let totalPresupuesto = 0, totalEjecutado = 0, totalPartidasCount = 0;
                
                for (let [seccion, data] of Object.entries(result.data)) {
                    totalPresupuesto += data.presupuesto;
                    totalEjecutado += data.ejecutado;
                    totalPartidasCount += data.partidas;
                    
                    const progressClass = data.avance >= 75 ? 'success' : (data.avance >= 50 ? 'warning' : 'danger');
                    const estaExpandida = seccionesExpandidas.has(seccion);
                    
                    html += `
                        <tr class="fila-seccion ${estaExpandida ? 'expandida' : ''}" onclick="toggleSeccion('${seccion.replace(/'/g, "\\'")}')">
                            <td style="text-align: center;"><i class="fas fa-chevron-right icono-expandir ${estaExpandida ? 'rotado' : ''}"></i></td>
                            <td style="font-weight: 600; color: #2c3e50;">${seccion}</td>
                            <td style="text-align: right; font-weight: 500;">${formatCurrencyFull(data.presupuesto)}</td>
                            <td style="text-align: right; color: #00A86B; font-weight: 600;">${formatCurrencyFull(data.ejecutado)}</td>
                            <td style="text-align: right; color: #FF6B00; font-weight: 600;">${formatCurrencyFull(data.pendiente)}</td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <div class="progress-mini"><div class="progress-mini-fill ${progressClass}" style="width: ${data.avance}%"></div></div>
                                    <span class="texto-avance" style="color: ${progressClass === 'success' ? '#00A86B' : (progressClass === 'warning' ? '#FF6B00' : '#dc3545')};">${data.avance}%</span>
                                </div>
                            </td>
                            <td style="text-align: center;"><span class="badge-partidas">${data.partidas}</span></td>
                        </tr>
                    `;
                    
                    if (estaExpandida && partidasPorSeccion[seccion] && partidasPorSeccion[seccion].length > 0) {
                        html += `
                            <tr class="mini-header">
                                <td colspan="2" style="padding-left: 40px;">Código / Partida</td>
                                <td style="text-align: center;">Categoría</td>
                                <td style="text-align: center;">Unidad</td>
                                <td style="text-align: center;">Cantidad</td>
                                <td style="text-align: center;">P.U.</td>
                                <td style="text-align: center;">Importe</td>
                                <td style="text-align: center;">Ejecutado</td>
                                <td style="text-align: center;">Pendiente</td>
                                <td style="text-align: center;">Avance</td>
                                <td style="text-align: center;">Acciones</td>
                              </tr>
                        `;
                        
                        const partidas = partidasPorSeccion[seccion];
                        partidas.forEach(partida => {
                            const progressClassPartida = partida.avance >= 75 ? 'success' : (partida.avance >= 50 ? 'warning' : 'danger');
                            html += `
                                <tr class="fila-partida">
                                    <td style="padding-left: 40px;"><code style="background: #f5f5f5; padding: 2px 6px; border-radius: 4px;">${partida.codigo}</code></td>
                                    <td><strong>${partida.nombre}</strong></td>
                                    <td style="text-align: center;">${getCategoriaBadge(partida.categoria)}</td>
                                    <td style="text-align: center;">${partida.unidad || '-'}</td>
                                    <td style="text-align: right;">${parseFloat(partida.cantidad).toFixed(2)}</td>
                                    <td style="text-align: right;">${formatCurrencyFull(partida.precio_unitario)}</td>
                                    <td style="text-align: right; font-weight: 600; color: #083CAE;">${formatCurrencyFull(partida.importe)}</td>
                                    <td style="text-align: right; color: #00A86B; font-weight: 600;">${formatCurrencyFull(partida.ejecutado)}</td>
                                    <td style="text-align: right; color: #FF6B00; font-weight: 600;">${formatCurrencyFull(partida.pendiente)}</td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div class="progress-mini"><div class="progress-mini-fill ${progressClassPartida}" style="width: ${partida.avance}%"></div></div>
                                            <span style="font-size: 11px;">${partida.avance}%</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <i class="fas fa-edit" onclick="event.stopPropagation(); editarPartida(${partida.id})" style="cursor:pointer; margin:0 5px; color:#083CAE;"></i>
                                        <i class="fas fa-trash" onclick="event.stopPropagation(); eliminarPartida(${partida.id})" style="cursor:pointer; margin:0 5px; color:#dc3545;"></i>
                                    </td>
                                  </tr>
                            `;
                        });
                    }
                }
                
                document.getElementById('resumenSeccionesBody').innerHTML = html;
                document.getElementById('resumenSeccionesFoot').innerHTML = `
                    <tr style="background-color: #f8f9fc;">
                        <td colspan="2" style="padding: 12px; font-weight: 700;">TOTALES</td>
                        <td style="padding: 12px; text-align: right; font-weight: 700;">${formatCurrencyFull(totalPresupuesto)}</td>
                        <td style="padding: 12px; text-align: right; font-weight: 700;">${formatCurrencyFull(totalEjecutado)}</td>
                        <td style="padding: 12px; text-align: right; font-weight: 700;">${formatCurrencyFull(totalPresupuesto - totalEjecutado)}</td>
                        <td style="padding: 12px; text-align: center; font-weight: 700;">${totalPresupuesto > 0 ? Math.round(totalEjecutado / totalPresupuesto * 100) : 0}%</td>
                        <td style="padding: 12px; text-align: center; font-weight: 700;">${totalPartidasCount}</td>
                      </tr>
                `;
            }
        } catch (error) {
            console.error('Error renderizando resumen:', error);
        }
    }
    
    async function cargarResumenSecciones(proyectoId) {
        currentProjectId = proyectoId;
        partidasPorSeccion = {};
        seccionesExpandidas.clear();
        await renderResumenSecciones();
    }

    // Cargar partidas (vista detalle)
    async function cargarPartidas(proyectoId) {
        if (!proyectoId) return;
        
        try {
            const response = await fetch(`/api/proyectos/${proyectoId}/partidas`);
            const result = await response.json();
            
            if (result.success && result.data) {
                renderTablaPartidas(result.data);
                if (result.data.length === 0) {
                    document.getElementById('sinDatosMensaje').style.display = 'block';
                } else {
                    document.getElementById('sinDatosMensaje').style.display = 'none';
                }
            } else {
                document.getElementById('sinDatosMensaje').style.display = 'block';
            }
        } catch (error) {
            console.error('Error cargando partidas:', error);
            document.getElementById('sinDatosMensaje').style.display = 'block';
        }
    }
    
    function renderTablaPartidas(partidas) {
        const tbody = document.getElementById('tablaBodyPartidas');
        const tfoot = document.getElementById('tablaFootPartidas');
        
        if (!partidas || partidas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="13" style="text-align: center;">No hay partidas para mostrar</td></tr>';
            tfoot.innerHTML = '';
            return;
        }
        
        tbody.innerHTML = partidas.map(item => {
            const progressClass = getProgressClass(item.avance);
            return `
                <tr>
                    <td>${item.seccion || '-'}</td>
                    <td><code style="background:#f5f5f5; padding:2px 6px; border-radius:4px;">${item.codigo}</code></td>
                    <td><strong>${item.nombre}</strong></td>
                    <td style="text-align: center;">${getCategoriaBadge(item.categoria)}</td>
                    <td style="text-align: center;">${item.unidad}</td>
                    <td style="text-align: right;">${parseFloat(item.cantidad).toFixed(2)}</td>
                    <td style="text-align: right; font-weight: 600;">${parseFloat(item.cantidad_ejecutada || 0).toFixed(2)}</td>
                    <td style="text-align: right;">${formatCurrencyFull(item.precio_unitario)}</td>
                    <td style="text-align: right; font-weight: 600; color: #083CAE;">${formatCurrencyFull(item.importe)}</td>
                    <td style="text-align: right; color: #00A86B; font-weight: 600;">${formatCurrencyFull(item.ejecutado)}</td>
                    <td style="text-align: right; color: #FF6B00; font-weight: 600;">${formatCurrencyFull(item.pendiente)}</td>
                    <td style="text-align: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="progress-mini"><div class="progress-mini-fill ${progressClass}" style="width: ${item.avance}%"></div></div>
                            <span style="font-size: 11px;">${item.avance}%</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <i class="fas fa-edit" onclick="editarPartida(${item.id})" style="cursor:pointer; margin:0 5px; color:#083CAE;"></i>
                        <i class="fas fa-trash" onclick="eliminarPartida(${item.id})" style="cursor:pointer; margin:0 5px; color:#dc3545;"></i>
                    </td>
                </tr>
            `;
        }).join('');
        
        let totalImporte = partidas.reduce((s,i)=>s+i.importe,0);
        let totalEjecutado = partidas.reduce((s,i)=>s+i.ejecutado,0);
        let totalCantidadPresupuestada = partidas.reduce((s,i)=>s+parseFloat(i.cantidad),0);
        let totalCantidadEjecutada = partidas.reduce((s,i)=>s+parseFloat(i.cantidad_ejecutada || 0),0);
        
        tfoot.innerHTML = `<tr>
            <td colspan="5" style="text-align: center;"><strong>TOTALES</strong></td>
            <td style="text-align: right;"><strong>${totalCantidadPresupuestada.toFixed(2)}</strong></td>
            <td style="text-align: right;"><strong>${totalCantidadEjecutada.toFixed(2)}</strong></td>
            <td colspan="2"></td>
            <td style="text-align: right;"><strong>${formatCurrencyFull(totalEjecutado)}</strong></td>
            <td style="text-align: right;"><strong>${formatCurrencyFull(totalImporte - totalEjecutado)}</strong></td>
            <td style="text-align: center;"><strong>${totalImporte>0 ? Math.round(totalEjecutado/totalImporte*100) : 0}%</strong></td>
            <td></td>
        </tr>`;
    }

    // CRUD Partidas
    window.editarPartida = async function(id) {
        try {
            const response = await fetch(`/api/proyectos/${currentProjectId}/partidas/${id}`);
            const result = await response.json();
            if (result.success) {
                const p = result.data;
                document.getElementById('modalPartidaId').value = p.id;
                document.getElementById('modalCodigo').value = p.codigo;
                document.getElementById('modalNombre').value = p.nombre;
                document.getElementById('modalSeccion').value = p.seccion || '';
                document.getElementById('modalCategoria').value = p.categoria;
                document.getElementById('modalUnidad').value = p.unidad;
                document.getElementById('modalCantidad').value = p.cantidad;
                document.getElementById('modalPrecioUnitario').value = p.precio_unitario;
                document.getElementById('modalTitulo').textContent = 'Editar Partida';
                document.getElementById('modalPartida').style.display = 'flex';
                calcularImporteModal();
            }
        } catch (error) { console.error(error); }
    };
    
    window.eliminarPartida = async function(id) {
        if (!confirm('¿Eliminar esta partida?')) return;
        try {
            const response = await fetch(`/api/proyectos/${currentProjectId}/partidas/${id}`, { 
                method: 'DELETE', 
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } 
            });
            const result = await response.json();
            if (result.success) {
                await cargarPresupuesto(currentProjectId);
                await cargarResumenSecciones(currentProjectId);
                await cargarPartidas(currentProjectId);
            } else {
                alert(result.message);
            }
        } catch (error) { console.error(error); }
    };
    
    function calcularImporteModal() {
        const cantidad = parseFloat(document.getElementById('modalCantidad').value) || 0;
        const pu = parseFloat(document.getElementById('modalPrecioUnitario').value) || 0;
        document.getElementById('modalImporte').textContent = formatCurrencyFull(cantidad * pu);
    }
    
    async function guardarPartida() {
        const id = document.getElementById('modalPartidaId').value;
        const data = {
            codigo: document.getElementById('modalCodigo').value,
            nombre: document.getElementById('modalNombre').value,
            seccion: document.getElementById('modalSeccion').value,
            categoria: document.getElementById('modalCategoria').value,
            unidad: document.getElementById('modalUnidad').value,
            cantidad: parseFloat(document.getElementById('modalCantidad').value) || 0,
            precio_unitario: parseFloat(document.getElementById('modalPrecioUnitario').value) || 0
        };
        if (!data.codigo || !data.nombre) { alert('Complete código y nombre'); return; }
        
        try {
            const url = id ? `/api/proyectos/${currentProjectId}/partidas/${id}` : `/api/proyectos/${currentProjectId}/partidas`;
            const method = id ? 'PUT' : 'POST';
            const response = await fetch(url, {
                method, 
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById('modalPartida').style.display = 'none';
                await cargarPresupuesto(currentProjectId);
                await cargarResumenSecciones(currentProjectId);
                await cargarPartidas(currentProjectId);
            } else {
                alert(result.message);
            }
        } catch (error) { console.error(error); }
    }

    // Eventos
    document.getElementById('selectorProyecto').addEventListener('change', async (e) => {
        if (e.target.value) {
            currentProjectId = e.target.value;
            partidasPorSeccion = {};
            seccionesExpandidas.clear();
            await cargarPresupuesto(currentProjectId);
            await cargarResumenSecciones(currentProjectId);
            await cargarPartidas(currentProjectId);
        }
    });
    
    document.getElementById('btnAgregar').addEventListener('click', () => {
        document.getElementById('modalPartidaId').value = '';
        document.getElementById('modalCodigo').value = '';
        document.getElementById('modalNombre').value = '';
        document.getElementById('modalSeccion').value = '';
        document.getElementById('modalCategoria').value = 'materiales';
        document.getElementById('modalUnidad').value = '';
        document.getElementById('modalCantidad').value = '';
        document.getElementById('modalPrecioUnitario').value = '';
        document.getElementById('modalTitulo').textContent = 'Agregar Partida';
        document.getElementById('modalPartida').style.display = 'flex';
        calcularImporteModal();
    });
    
    document.getElementById('btnExcel').addEventListener('click', () => {
        if (currentProjectId) window.open(`/api/proyectos/${currentProjectId}/exportar-excel`, '_blank');
    });
    
    document.getElementById('btnCancelarModal').addEventListener('click', () => document.getElementById('modalPartida').style.display = 'none');
    document.getElementById('btnGuardarModal').addEventListener('click', guardarPartida);
    document.getElementById('modalCantidad').addEventListener('input', calcularImporteModal);
    document.getElementById('modalPrecioUnitario').addEventListener('input', calcularImporteModal);
    
    // Vistas
    document.querySelectorAll('.vista-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.vista-btn').forEach(b => { 
                b.classList.remove('active'); 
                b.style.backgroundColor = 'transparent'; 
                b.style.color = '#495057'; 
            });
            this.classList.add('active'); 
            this.style.backgroundColor = '#083CAE'; 
            this.style.color = 'white';
            document.getElementById('vistaProyecto').style.display = this.dataset.vista === 'proyecto' ? 'block' : 'none';
            document.getElementById('vistaPartidas').style.display = this.dataset.vista === 'partidas' ? 'block' : 'none';
            
            if (this.dataset.vista === 'proyecto') {
                renderResumenSecciones();
            } else {
                cargarPartidas(currentProjectId);
            }
        });
    });
    
    // Inicializar
    cargarProyectos();
});
</script>
@endsection