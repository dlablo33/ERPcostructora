@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-clipboard-list" style="margin-right: 10px;"></i> Requisiciones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="">
                        </div>
                        
                        <div>
                            <select id="filtroEstatus" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="">Todos los estatus</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Activo">Activo</option>
                                <option value="Cotizado">Cotizado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>

                        <div>
                            <select id="filtroArea" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="">Todas las áreas</option>
                                @forelse(($areas ?? []) as $areaItem)
                                    <option value="{{ $areaItem->id }}">{{ $areaItem->nombre }}</option>
                                @empty
                                    <option value="" disabled>Sin áreas registradas</option>
                                @endforelse
                            </select>
                        </div>

                        <div>
                            <select id="filtroProyecto" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="">Todos los proyectos</option>
                                @forelse(($proyectos ?? []) as $proyectoItem)
                                    <option value="{{ $proyectoItem->id }}">{{ $proyectoItem->nombre }}</option>
                                @empty
                                    <option value="" disabled>Sin proyectos registrados</option>
                                @endforelse
                            </select>
                        </div>
                        
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: #083CAE; border: none; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;" 
                                    title="Agregar requisición"
                                    onclick="abrirModalRequisicion()">
                                <i class="fas fa-plus" style="color: white;"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: #083CAE;">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                <span>Excel</span>
                            </button>
                        </div>

                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE; font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar requisición..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid #083CAE; border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Requisiciones -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
                        <thead style="background-color: #083CAE; position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Requisición</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Fecha Requerimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Solicitante</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Área</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Proyecto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Cotizadas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #083CAE; color: white; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="8" style="text-align: center; padding: 40px;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr><td colspan="8" style="padding: 10px; text-align: center;" id="totalRegistros">Total Requisiciones: 0</td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ⭐ MODAL PARA AGREGAR / EDITAR REQUISICIÓN ⭐ -->
<div id="modalAgregar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 12px; width: 850px; max-width: 95%; max-height: 90%; overflow-y: auto; margin: 20px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background: #083CAE; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTitulo">Nueva Requisición</h3>
            <button onclick="cerrarModalAgregar()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <input type="hidden" id="requisicion_id" value="">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Requerimiento *</label>
                    <input type="date" id="fecha_requerimiento" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <!-- ⭐ TICKET #3: Selector de solicitante ⭐ -->
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Solicitante *</label>
                    <select id="solicitante" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Cargando personal...</option>
                    </select>
                    <small style="color: #6c757d; font-size: 11px;" id="solicitanteHint">
                        <i class="fas fa-info-circle"></i> Seleccione un proyecto para filtrar personal
                    </small>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Área *</label>
                    <select id="area_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Seleccionar área</option>
                        @forelse(($areas ?? []) as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @empty
                            <option value="" disabled>Sin áreas registradas</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto</label>
                    <select id="proyecto_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" onchange="cargarPersonalProyecto()">
                        <option value="">Seleccionar proyecto</option>
                        @forelse(($proyectos ?? []) as $proyecto)
                            <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                        @empty
                            <option value="" disabled>Sin proyectos registrados</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estatus</label>
                    <select id="estatus" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Activo">Activo</option>
                        <option value="Cotizado">Cotizado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="observaciones" rows="2" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
            </div>
            
            <hr>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h4 style="margin: 0; color: #083CAE;">Artículos Solicitados</h4>
                <button type="button" id="agregarArticulo" onclick="agregarFilaArticulo()" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-plus"></i> Agregar Artículo
                </button>
            </div>
            
            <div id="articulosContainer" style="max-height: 350px; overflow-y: auto;">
                <!-- Los artículos se cargan dinámicamente -->
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button onclick="cerrarModalAgregar()" style="padding: 10px 24px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" id="btnGuardar" style="padding: 10px 24px; background: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 12px; width: 750px; max-width: 95%; max-height: 90%; overflow-y: auto; margin: 20px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background: #083CAE; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Detalle de Requisición</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;"></div>
        <div style="padding: 15px 20px; text-align: right;">
            <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<!-- ⭐ MODAL SELECTOR DE ARTÍCULOS DEL CATÁLOGO ⭐ -->
<div id="modalSelectorArticulo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; width: 700px; max-width: 95%; max-height: 85%; overflow-y: auto; margin: 20px auto;">
        <div style="background: #083CAE; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Seleccionar Artículo del Catálogo</h3>
            <button onclick="cerrarSelectorArticulo()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <div style="position: relative; margin-bottom: 15px;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                <input type="text" id="buscarArticulo" placeholder="Buscar por nombre, código o descripción..." 
                       style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #ddd; border-radius: 6px;"
                       onkeyup="buscarArticulosCatalogo()">
            </div>
            <div id="listaArticulosCatalogo" style="max-height: 400px; overflow-y: auto;">
                <p style="text-align: center; color: #6c757d; padding: 20px;">
                    <i class="fas fa-spinner fa-spin"></i> Cargando artículos...
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: #083CAE !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .badge-activo { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-cotizado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-cancelado { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; display: inline-block; min-width: 70px; text-align: center; }
    .btn-icon { background: none; border: none; cursor: pointer; font-size: 14px; margin: 0 3px; }
    .spinner-border { display: inline-block; width: 2rem; height: 2rem; border: 0.25em solid #083CAE; border-right-color: transparent; border-radius: 50%; animation: spinner-border 0.75s linear infinite; }
    @keyframes spinner-border { to { transform: rotate(360deg); } }
    input:focus, select:focus, textarea:focus { outline: none; border-color: #083CAE; box-shadow: 0 0 0 2px rgba(8,60,174,0.1); }
    .articulo-card { background: #f9f9f9; padding: 12px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e0e0e0; }
    .articulo-card:hover { background: #eef4ff; }
    .catalogo-item { padding: 12px; border-bottom: 1px solid #eee; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
    .catalogo-item:hover { background: #e8f0fe; }
    .catalogo-item:last-child { border-bottom: none; }
    .stock-badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; }
    .stock-ok { background: #d4edda; color: #155724; }
    .stock-bajo { background: #fff3cd; color: #856404; }
    .stock-cero { background: #f8d7da; color: #721c24; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// ============================================================
// VARIABLES GLOBALES
// ============================================================
const CSRF_TOKEN = '{{ csrf_token() }}';
const BASE_URL = '{{ url("/compras/requisiciones") }}';
let articulosCatalogoCache = [];
let personalCache = [];
let articuloSeleccionadoInput = null;

// ============================================================
// INICIALIZACIÓN
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM cargado, iniciando Requisiciones...');
    console.log('BASE_URL:', BASE_URL);
    
    cargarRequisiciones();
    cargarArticulosCatalogo();
    cargarPersonal();
    
    // Eventos de filtros
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    const filtroEstatus = document.getElementById('filtroEstatus');
    const filtroArea = document.getElementById('filtroArea');
    const filtroProyecto = document.getElementById('filtroProyecto');
    const buscador = document.getElementById('buscador');
    const btnExcel = document.getElementById('btnExcel');
    
    if (fechaInicio) fechaInicio.addEventListener('change', cargarRequisiciones);
    if (fechaFin) fechaFin.addEventListener('change', cargarRequisiciones);
    if (filtroEstatus) filtroEstatus.addEventListener('change', cargarRequisiciones);
    if (filtroArea) filtroArea.addEventListener('change', cargarRequisiciones);
    if (filtroProyecto) filtroProyecto.addEventListener('change', cargarRequisiciones);
    if (buscador) buscador.addEventListener('keyup', cargarRequisiciones);
    if (btnExcel) btnExcel.addEventListener('click', function() { alert('Exportación en desarrollo'); });
});

// ============================================================
// CARGAR REQUISICIONES
// ============================================================
function cargarRequisiciones() {
    const tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><div class="spinner-border"></div><p>Cargando...</p></td></tr>';
    
    let url = BASE_URL + '?';
    const params = [];
    
    const fechaInicioVal = document.getElementById('fechaInicio')?.value;
    const fechaFinVal = document.getElementById('fechaFin')?.value;
    const estatusVal = document.getElementById('filtroEstatus')?.value;
    const areaIdVal = document.getElementById('filtroArea')?.value;
    const proyectoIdVal = document.getElementById('filtroProyecto')?.value;
    const buscarVal = document.getElementById('buscador')?.value;
    
    if (fechaInicioVal) params.push('fecha_inicio=' + encodeURIComponent(fechaInicioVal));
    if (fechaFinVal) params.push('fecha_fin=' + encodeURIComponent(fechaFinVal));
    if (estatusVal) params.push('estatus=' + encodeURIComponent(estatusVal));
    if (areaIdVal) params.push('area_id=' + encodeURIComponent(areaIdVal));
    if (proyectoIdVal) params.push('proyecto_id=' + encodeURIComponent(proyectoIdVal));
    if (buscarVal) params.push('buscar=' + encodeURIComponent(buscarVal));
    
    url += params.join('&');
    
    fetch(url, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        mostrarTabla(data);
        const totalRegistros = document.getElementById('totalRegistros');
        if (totalRegistros) {
            totalRegistros.innerHTML = 'Total Requisiciones: ' + (data.total || (data.data ? data.data.length : 0));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px; color:red;">Error: ' + error.message + '</td></tr>';
        }
    });
}

// ============================================================
// ⭐ TICKET #1: CARGAR CATÁLOGO DE ARTÍCULOS
// ============================================================
function cargarArticulosCatalogo() {
    fetch(BASE_URL + '/articulos', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && Array.isArray(data.data)) {
            articulosCatalogoCache = data.data;
            console.log('✅ Artículos cargados:', articulosCatalogoCache.length);
        } else {
            console.warn('⚠️ No se pudieron cargar artículos');
            articulosCatalogoCache = [];
        }
    })
    .catch(error => {
        console.error('Error al cargar artículos:', error);
        articulosCatalogoCache = [];
    });
}

// ============================================================
// ⭐ TICKET #3: CARGAR PERSONAL PARA SOLICITANTE
// ============================================================
function cargarPersonal(proyectoId = null) {
    let url = BASE_URL + '/personal';
    if (proyectoId) url += '?proyecto_id=' + proyectoId;
    
    const select = document.getElementById('solicitante');
    if (select) {
        select.innerHTML = '<option value="">Cargando personal...</option>';
    }
    
    fetch(url, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && Array.isArray(data.data)) {
            personalCache = data.data;
            console.log('✅ Personal cargado:', personalCache.length);
        } else {
            console.warn('⚠️ No se pudo cargar personal');
            personalCache = [];
        }
        llenarSelectPersonal();
    })
    .catch(error => {
        console.error('Error al cargar personal:', error);
        personalCache = [];
        llenarSelectPersonal();
    });
}

function llenarSelectPersonal(valorSeleccionado = null) {
    const select = document.getElementById('solicitante');
    if (!select) return;
    
    let html = '<option value="">Seleccionar solicitante...</option>';
    
    if (personalCache.length === 0) {
        html += '<option value="" disabled>Sin personal registrado</option>';
    } else {
        personalCache.forEach(p => {
            const selected = (valorSeleccionado && p.nombre === valorSeleccionado) ? 'selected' : '';
            const label = p.puesto ? `${p.nombre} - ${p.puesto}` : p.nombre;
            html += `<option value="${escapeHtml(p.nombre)}" ${selected}>${escapeHtml(label)}</option>`;
        });
    }
    
    select.innerHTML = html;
}

function cargarPersonalProyecto() {
    const proyectoId = document.getElementById('proyecto_id')?.value;
    const hint = document.getElementById('solicitanteHint');
    
    if (proyectoId) {
        if (hint) hint.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando personal del proyecto...';
        cargarPersonal(proyectoId);
        if (hint) hint.innerHTML = '<i class="fas fa-users"></i> Personal del proyecto seleccionado';
    } else {
        cargarPersonal();
        if (hint) hint.innerHTML = '<i class="fas fa-info-circle"></i> Seleccione un proyecto para filtrar personal';
    }
}

// ============================================================
// MOSTRAR TABLA
// ============================================================
function mostrarTabla(data) {
    const items = data.data || [];
    const tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;">No hay requisiciones registradas</td></tr>';
        return;
    }
    
    let html = '';
    items.forEach(req => {
        const estatusClass = {
            'Activo': 'badge-activo',
            'Pendiente': 'badge-pendiente',
            'Cotizado': 'badge-cotizado',
            'Cancelado': 'badge-cancelado'
        }[req.estatus] || 'badge-pendiente';
        
        const fecha = req.fecha_requerimiento ? req.fecha_requerimiento.substring(0, 10) : '';
        
        let areaNombre = 'N/A';
        if (req.area) {
            areaNombre = typeof req.area === 'object' ? (req.area.nombre || 'N/A') : req.area;
        }
        
        let proyectoNombre = 'N/A';
        if (req.proyecto) {
            proyectoNombre = typeof req.proyecto === 'object' ? (req.proyecto.nombre || 'N/A') : req.proyecto;
        }
        
        html += `<tr>
            <td style="text-align: center;"><span class="${estatusClass}">${escapeHtml(req.estatus)}</span></td>
            <td style="text-align: center; font-weight: 500;">${escapeHtml(req.folio)}</td>
            <td style="text-align: center;">${fecha}</td>
            <td>${escapeHtml(req.solicitante)}</td>
            <td>${escapeHtml(areaNombre)}</td>
            <td>${escapeHtml(proyectoNombre)}</td>
            <td style="text-align: center;"><span class="badge-cotizado">${req.cotizadas || 0}</span></td>
            <td style="text-align: center; white-space: nowrap;">
                <i class="fas fa-eye btn-icon" onclick="verRequisicion(${req.id})" style="color: #17a2b8;" title="Ver"></i>
                <i class="fas fa-edit btn-icon" onclick="editarRequisicion(${req.id})" style="color: #083CAE;" title="Editar"></i>
                <i class="fas fa-trash btn-icon" onclick="eliminarRequisicion(${req.id}, '${escapeHtml(req.folio)}')" style="color: #dc3545;" title="Eliminar"></i>
            </td>
        </tr>`;
    });
    tbody.innerHTML = html;
}

// ============================================================
// VER DETALLE
// ============================================================
function verRequisicion(id) {
    fetch(BASE_URL + '/' + id, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(resp => {
        // Maneja ambos formatos: {success, data} o directo
        const req = resp.data || resp;
        
        if (!req || !req.id) {
            alert('No se pudo cargar la requisición');
            return;
        }
        
        let areaNombre = 'N/A';
        if (req.area) areaNombre = typeof req.area === 'object' ? (req.area.nombre || 'N/A') : req.area;
        
        let proyectoNombre = 'N/A';
        if (req.proyecto) proyectoNombre = typeof req.proyecto === 'object' ? (req.proyecto.nombre || 'N/A') : req.proyecto;
        
        let html = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div><strong>Folio:</strong> ${escapeHtml(req.folio)}</div>
                <div><strong>Fecha:</strong> ${req.fecha_requerimiento ? req.fecha_requerimiento.substring(0,10) : 'N/A'}</div>
                <div><strong>Estatus:</strong> ${escapeHtml(req.estatus)}</div>
                <div><strong>Solicitante:</strong> ${escapeHtml(req.solicitante)}</div>
                <div><strong>Área:</strong> ${escapeHtml(areaNombre)}</div>
                <div><strong>Proyecto:</strong> ${escapeHtml(proyectoNombre)}</div>
                <div><strong>Cotizadas:</strong> ${req.cotizadas || 0}</div>
            </div>
            <div style="margin-bottom: 20px;"><strong>Observaciones:</strong><br>${escapeHtml(req.observaciones || 'N/A')}</div>
        `;
        
        if (req.articulos && req.articulos.length > 0) {
            html += `<hr><h4 style="color: #083CAE;">Artículos:</h4>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <thead>
                        <tr style="background: #083CAE; color: white;">
                            <th style="padding: 8px; border: 1px solid #ddd;">Código</th>
                            <th style="padding: 8px; border: 1px solid #ddd;">Descripción</th>
                            <th style="padding: 8px; border: 1px solid #ddd;">Cantidad</th>
                            <th style="padding: 8px; border: 1px solid #ddd;">U.M.</th>
                        </tr>
                    </thead>
                    <tbody>`;
            req.articulos.forEach(a => {
                html += `<tr>
                    <td style="padding: 6px; border: 1px solid #ddd;">${escapeHtml(a.codigo || '-')}</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">${escapeHtml(a.descripcion)}</td>
                    <td style="padding: 6px; border: 1px solid #ddd; text-align: center;">${a.cantidad}</td>
                    <td style="padding: 6px; border: 1px solid #ddd; text-align: center;">${escapeHtml(a.unidad_medida)}</td>
                </tr>`;
            });
            html += '</tbody></table>';
        }
        
        document.getElementById('detalleContenido').innerHTML = html;
        document.getElementById('modalDetalle').style.display = 'flex';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar detalle: ' + error.message);
    });
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
}

// ============================================================
// ⭐ TICKET #2: EDITAR REQUISICIÓN (FUNCIONAL) ⭐
// ============================================================
function editarRequisicion(id) {
    console.log('✏️ Editando requisición:', id);
    
    fetch(BASE_URL + '/' + id, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(resp => {
        // Maneja ambos formatos: {success, data} o directo
        const req = resp.data || resp;
        
        if (!req || !req.id) {
            alert('No se pudo cargar la requisición para editar');
            console.error('Respuesta inesperada:', resp);
            return;
        }
        
        // Cambiar título del modal
        document.getElementById('modalTitulo').textContent = 'Editar Requisición - ' + (req.folio || '');
        document.getElementById('requisicion_id').value = req.id;
        
        // Llenar campos básicos
        document.getElementById('fecha_requerimiento').value = req.fecha_requerimiento ? req.fecha_requerimiento.substring(0, 10) : '';
        document.getElementById('area_id').value = req.area_id || '';
        document.getElementById('proyecto_id').value = req.proyecto_id || '';
        document.getElementById('estatus').value = req.estatus || 'Pendiente';
        document.getElementById('observaciones').value = req.observaciones || '';
        
        // Cargar personal y luego seleccionar el solicitante
        const proyectoId = req.proyecto_id;
        const urlPersonal = proyectoId ? BASE_URL + '/personal?proyecto_id=' + proyectoId : BASE_URL + '/personal';
        
        fetch(urlPersonal, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                personalCache = data.data;
            } else {
                personalCache = [];
            }
            llenarSelectPersonal(req.solicitante);
            
            // Si el solicitante no está en la lista, agregarlo manualmente
            const select = document.getElementById('solicitante');
            if (select && req.solicitante && select.value !== req.solicitante) {
                const opt = document.createElement('option');
                opt.value = req.solicitante;
                opt.textContent = req.solicitante + ' (actual)';
                opt.selected = true;
                select.appendChild(opt);
            }
        })
        .catch(() => {
            llenarSelectPersonal(req.solicitante);
        });
        
        // Limpiar contenedor de artículos
        const container = document.getElementById('articulosContainer');
        container.innerHTML = '';
        
        // Cargar artículos existentes
        if (req.articulos && req.articulos.length > 0) {
            req.articulos.forEach(a => {
                agregarFilaArticulo(a);
            });
        } else {
            agregarFilaArticulo();
        }
        
        // Cambiar botón guardar
        document.getElementById('btnGuardar').innerHTML = '<i class="fas fa-save"></i> Actualizar';
        
        // Mostrar modal
        document.getElementById('modalAgregar').style.display = 'flex';
    })
    .catch(error => {
        console.error('Error al cargar requisición para editar:', error);
        alert('Error al cargar la requisición para editar: ' + error.message);
    });
}

// ============================================================
// ⭐ TICKET #1: AGREGAR FILA DE ARTÍCULO CON SELECTOR ⭐
// ============================================================
function agregarFilaArticulo(articuloExistente = null) {
    const container = document.getElementById('articulosContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'articulo-item articulo-card';
    
    const articuloId = articuloExistente?.articulo_id || '';
    const codigo = articuloExistente?.codigo || '';
    const cantidad = articuloExistente?.cantidad || 1;
    const unidad = articuloExistente?.unidad_medida || 'Pieza';
    const descripcion = articuloExistente?.descripcion || '';
    const observacion = articuloExistente?.observacion || '';
    
    div.innerHTML = `
        <div style="display: grid; grid-template-columns: 2fr 0.7fr 0.8fr 0.3fr; gap: 10px; margin-bottom: 10px;">
            <div style="position: relative;">
                <input type="text" placeholder="Clic para seleccionar del catálogo..." 
                       class="articulo-descripcion" 
                       value="${escapeHtml(descripcion)}"
                       readonly
                       style="width: 100%; padding: 8px 35px 8px 8px; border: 1px solid #ddd; border-radius: 4px; background: white; cursor: pointer;"
                       onclick="abrirSelectorArticulo(this)">
                <i class="fas fa-search" 
                   style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #083CAE; cursor: pointer;"
                   onclick="abrirSelectorArticulo(this.previousElementSibling)"></i>
                <input type="hidden" class="articulo-id" value="${articuloId}">
            </div>
            <input type="number" placeholder="Cantidad" class="articulo-cantidad" 
                   value="${cantidad}" step="0.001" min="0.001"
                   style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <select class="articulo-unidad" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                ${['Pieza','Kilogramo','Litro','Metro','Caja','Paquete','Servicio','Otro'].map(u => 
                    `<option ${u === unidad ? 'selected' : ''}>${u}</option>`
                ).join('')}
            </select>
            <button type="button" class="btn-remove" 
                    style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 4px; cursor: pointer;"
                    onclick="eliminarArticulo(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <input type="text" placeholder="Código (auto)" class="articulo-codigo" 
                   value="${escapeHtml(codigo)}"
                   readonly
                   style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; background: #f0f0f0;">
            <input type="text" placeholder="Observación (opcional)" class="articulo-observacion" 
                   value="${escapeHtml(observacion)}"
                   style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;">
        </div>
    `;
    
    container.appendChild(div);
}

function eliminarArticulo(btn) {
    const container = document.getElementById('articulosContainer');
    if (container && container.children.length > 1) {
        btn.closest('.articulo-item').remove();
    } else {
        alert('Debe haber al menos un artículo');
    }
}

// ============================================================
// ⭐ TICKET #1: SELECTOR DE ARTÍCULOS DEL CATÁLOGO ⭐
// ============================================================
function abrirSelectorArticulo(inputElement) {
    articuloSeleccionadoInput = inputElement;
    document.getElementById('modalSelectorArticulo').style.display = 'flex';
    document.getElementById('buscarArticulo').value = '';
    
    // Si aún no se cargaron, mostrarlas ahora
    if (articulosCatalogoCache.length === 0) {
        const container = document.getElementById('listaArticulosCatalogo');
        container.innerHTML = '<p style="text-align: center; color: #6c757d; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Cargando artículos...</p>';
        
        fetch(BASE_URL + '/articulos', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                articulosCatalogoCache = data.data;
            }
            renderizarArticulosCatalogo(articulosCatalogoCache);
        })
        .catch(error => {
            console.error('Error:', error);
            renderizarArticulosCatalogo([]);
        });
    } else {
        renderizarArticulosCatalogo(articulosCatalogoCache);
    }
    
    setTimeout(() => document.getElementById('buscarArticulo').focus(), 100);
}

function cerrarSelectorArticulo() {
    document.getElementById('modalSelectorArticulo').style.display = 'none';
    articuloSeleccionadoInput = null;
}

function buscarArticulosCatalogo() {
    const term = document.getElementById('buscarArticulo').value.toLowerCase().trim();
    
    if (!term) {
        renderizarArticulosCatalogo(articulosCatalogoCache);
        return;
    }
    
    const filtrados = articulosCatalogoCache.filter(a => {
        const nombre = (a.nombre || '').toLowerCase();
        const codigo = (a.codigo || '').toLowerCase();
        const desc = (a.descripcion || '').toLowerCase();
        return nombre.includes(term) || codigo.includes(term) || desc.includes(term);
    });
    
    renderizarArticulosCatalogo(filtrados);
}

function renderizarArticulosCatalogo(articulos) {
    const container = document.getElementById('listaArticulosCatalogo');
    
    if (!articulos || articulos.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #6c757d; padding: 20px;">No se encontraron artículos en el catálogo</p>';
        return;
    }
    
    let html = '';
    articulos.forEach((a, index) => {
        const stock = parseFloat(a.stock_actual || 0);
        let stockClass = 'stock-cero';
        if (stock > 10) stockClass = 'stock-ok';
        else if (stock > 0) stockClass = 'stock-bajo';
        
        // Usar índice para identificar y guardar el objeto completo en cache
        html += `
            <div class="catalogo-item" onclick="seleccionarArticuloCatalogoPorIndice(${index})">
                <div style="flex: 1;">
                    <div style="font-weight: 600; color: #083CAE;">${escapeHtml(a.nombre || a.descripcion || 'Sin nombre')}</div>
                    <div style="font-size: 11px; color: #6c757d; margin-top: 3px;">
                        ${a.codigo ? '<strong>Código:</strong> ' + escapeHtml(a.codigo) + ' | ' : ''}
                        ${a.unidad_medida ? '<strong>U.M.:</strong> ' + escapeHtml(a.unidad_medida) : ''}
                    </div>
                </div>
                <div style="text-align: right;">
                    <span class="stock-badge ${stockClass}">
                        <i class="fas fa-box"></i> ${stock}
                    </span>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Guardar el array filtrado actual como referencia
    window._articulosFiltradosActuales = articulos;
}

function seleccionarArticuloCatalogoPorIndice(index) {
    const articulos = window._articulosFiltradosActuales || articulosCatalogoCache;
    const articulo = articulos[index];
    if (!articulo) return;
    
    if (!articuloSeleccionadoInput) return;
    
    const input = articuloSeleccionadoInput;
    const card = input.closest('.articulo-item');
    
    if (card) {
        // Llenar descripción
        input.value = articulo.nombre || articulo.descripcion || '';
        
        // Llenar ID oculto
        const idInput = card.querySelector('.articulo-id');
        if (idInput) idInput.value = articulo.id || '';
        
        // Llenar código
        const codigoInput = card.querySelector('.articulo-codigo');
        if (codigoInput && articulo.codigo) codigoInput.value = articulo.codigo;
        
        // Seleccionar unidad de medida
        const unidadSelect = card.querySelector('.articulo-unidad');
        if (unidadSelect && articulo.unidad_medida) {
            let found = false;
            for (let opt of unidadSelect.options) {
                if (opt.value === articulo.unidad_medida) {
                    opt.selected = true;
                    found = true;
                    break;
                }
            }
            if (!found) {
                const opt = document.createElement('option');
                opt.value = articulo.unidad_medida;
                opt.textContent = articulo.unidad_medida;
                opt.selected = true;
                unidadSelect.appendChild(opt);
            }
        }
    }
    
    cerrarSelectorArticulo();
}

// ============================================================
// ABRIR / CERRAR MODAL
// ============================================================
function abrirModalRequisicion() {
    // Resetear formulario
    document.getElementById('modalTitulo').textContent = 'Nueva Requisición';
    document.getElementById('requisicion_id').value = '';
    document.getElementById('fecha_requerimiento').value = new Date().toISOString().split('T')[0];
    document.getElementById('area_id').value = '';
    document.getElementById('proyecto_id').value = '';
    document.getElementById('estatus').value = 'Pendiente';
    document.getElementById('observaciones').value = '';
    document.getElementById('btnGuardar').innerHTML = '<i class="fas fa-save"></i> Guardar';
    
    // Recargar personal general
    cargarPersonal();
    
    // Limpiar artículos
    const container = document.getElementById('articulosContainer');
    container.innerHTML = '';
    agregarFilaArticulo();
    
    document.getElementById('modalAgregar').style.display = 'flex';
}

function cerrarModalAgregar() {
    document.getElementById('modalAgregar').style.display = 'none';
}

// ============================================================
// GUARDAR / ACTUALIZAR
// ============================================================
function guardarRequisicion() {
    const requisicionId = document.getElementById('requisicion_id').value;
    const esEdicion = !!requisicionId;
    
    // Recolectar artículos
    const articulos = [];
    const items = document.querySelectorAll('#articulosContainer .articulo-item');
    
    items.forEach(item => {
        const cantidad = parseFloat(item.querySelector('.articulo-cantidad').value);
        const descripcion = item.querySelector('.articulo-descripcion').value.trim();
        
        if (!isNaN(cantidad) && cantidad > 0 && descripcion !== '') {
            articulos.push({
                articulo_id: item.querySelector('.articulo-id')?.value || null,
                codigo: item.querySelector('.articulo-codigo').value,
                cantidad: cantidad,
                unidad_medida: item.querySelector('.articulo-unidad').value,
                descripcion: descripcion,
                observacion: item.querySelector('.articulo-observacion').value,
                pendiente: true
            });
        }
    });
    
    if (articulos.length === 0) {
        alert('Debe agregar al menos un artículo válido');
        return;
    }
    
    const solicitanteSelect = document.getElementById('solicitante');
    const solicitante = solicitanteSelect.value;
    
    if (!solicitante) {
        alert('Debe seleccionar un solicitante');
        solicitanteSelect.focus();
        return;
    }
    
    const areaId = document.getElementById('area_id').value;
    if (!areaId) {
        alert('Debe seleccionar un área');
        return;
    }
    
    const data = {
        fecha_requerimiento: document.getElementById('fecha_requerimiento').value,
        solicitante: solicitante,
        area_id: areaId,
        proyecto_id: document.getElementById('proyecto_id').value || null,
        estatus: document.getElementById('estatus').value,
        observaciones: document.getElementById('observaciones').value,
        articulos: articulos
    };
    
    const url = esEdicion ? BASE_URL + '/' + requisicionId : BASE_URL;
    const method = esEdicion ? 'PUT' : 'POST';
    
    const btnGuardar = document.getElementById('btnGuardar');
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(resp => {
        if (resp.success) {
            alert('✅ Requisición ' + (esEdicion ? 'actualizada' : 'creada') + ' exitosamente');
            cerrarModalAgregar();
            cargarRequisiciones();
        } else {
            let msg = resp.message || 'Error al guardar';
            if (resp.errors) {
                msg += '\n\n' + Object.values(resp.errors).flat().join('\n');
            }
            alert('❌ ' + msg);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error de conexión: ' + error.message);
    })
    .finally(() => {
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = esEdicion ? '<i class="fas fa-save"></i> Actualizar' : '<i class="fas fa-save"></i> Guardar';
    });
}

// ============================================================
// ELIMINAR
// ============================================================
function eliminarRequisicion(id, folio) {
    if (!confirm('¿Eliminar requisición ' + folio + '?')) return;
    
    fetch(BASE_URL + '/' + id, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Eliminada');
        cargarRequisiciones();
    })
    .catch(error => {
        alert('Error al eliminar: ' + error.message);
    });
}

// ============================================================
// UTILIDADES
// ============================================================
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}

// Cerrar modales con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalAgregar();
        cerrarModalDetalle();
        cerrarSelectorArticulo();
    }
});
</script>

@endsection