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
                                @php $areas = App\Models\Area::all(); @endphp
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select id="filtroProyecto" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="">Todos los proyectos</option>
                                @php $proyectos = App\Models\Proyecto::all(); @endphp
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
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
                            <tr><td colspan="8" style="text-align: center; padding: 40px;">Cargando...<td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr><td colspan="8" style="padding: 10px; text-align: center;" id="totalRegistros">Total Requisiciones: 0<td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR REQUISICIÓN -->
<div id="modalAgregar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 12px; width: 750px; max-width: 95%; max-height: 90%; overflow-y: auto; margin: 20px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="background: #083CAE; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Nueva Requisición</h3>
            <button onclick="cerrarModalAgregar()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Requerimiento *</label>
                    <input type="date" id="fecha_requerimiento" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Solicitante *</label>
                    <input type="text" id="solicitante" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;" placeholder="Nombre del solicitante">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Área *</label>
                    <select id="area_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Seleccionar área</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto</label>
                    <select id="proyecto_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Seleccionar proyecto</option>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                        @endforeach
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
                <button type="button" id="agregarArticulo" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">+ Agregar Artículo</button>
            </div>
            
            <div id="articulosContainer" style="max-height: 300px; overflow-y: auto;">
                <div class="articulo-item" style="background: #f9f9f9; padding: 12px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e0e0e0;">
                    <div style="display: grid; grid-template-columns: 1fr 0.5fr 0.5fr 0.2fr; gap: 10px; margin-bottom: 10px;">
                        <input type="text" placeholder="Código" class="articulo-codigo" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <input type="number" placeholder="Cantidad" class="articulo-cantidad" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;" value="1" step="0.001">
                        <select class="articulo-unidad" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option>Pieza</option><option>Kilogramo</option><option>Litro</option><option>Metro</option><option>Caja</option>
                        </select>
                        <button type="button" class="btn-remove" style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Descripción del artículo *" class="articulo-descripcion" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px;">
                    <input type="text" placeholder="Observación (opcional)" class="articulo-observacion" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button onclick="cerrarModalAgregar()" style="padding: 10px 24px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRequisicion()" style="padding: 10px 24px; background: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 12px; width: 700px; max-width: 95%; max-height: 90%; overflow-y: auto; margin: 20px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
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
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



<script>
// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, iniciando...');
    cargarRequisiciones();
    
    // Eventos de filtros
    var fechaInicio = document.getElementById('fechaInicio');
    var fechaFin = document.getElementById('fechaFin');
    var filtroEstatus = document.getElementById('filtroEstatus');
    var filtroArea = document.getElementById('filtroArea');
    var filtroProyecto = document.getElementById('filtroProyecto');
    var buscador = document.getElementById('buscador');
    var btnExcel = document.getElementById('btnExcel');
    var btnAgregarArticulo = document.getElementById('agregarArticulo');
    
    if (fechaInicio) fechaInicio.addEventListener('change', cargarRequisiciones);
    if (fechaFin) fechaFin.addEventListener('change', cargarRequisiciones);
    if (filtroEstatus) filtroEstatus.addEventListener('change', cargarRequisiciones);
    if (filtroArea) filtroArea.addEventListener('change', cargarRequisiciones);
    if (filtroProyecto) filtroProyecto.addEventListener('change', cargarRequisiciones);
    if (buscador) buscador.addEventListener('keyup', cargarRequisiciones);
    if (btnExcel) btnExcel.addEventListener('click', function() { alert('Exportación en desarrollo'); });
    if (btnAgregarArticulo) btnAgregarArticulo.addEventListener('click', agregarFilaArticulo);
    
    // Eliminar primer artículo
    var primerRemove = document.querySelector('#articulosContainer .btn-remove');
    if (primerRemove) {
        primerRemove.addEventListener('click', function() { eliminarArticulo(this); });
    }
});

function cargarRequisiciones() {
    console.log('Cargando requisiciones...');
    var tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><div class="spinner-border"></div><p>Cargando...</p></td></tr>';
    
    var url = '/compras/requisiciones?';
    var params = [];
    
    var fechaInicio = document.getElementById('fechaInicio');
    var fechaFin = document.getElementById('fechaFin');
    var filtroEstatus = document.getElementById('filtroEstatus');
    var filtroArea = document.getElementById('filtroArea');
    var filtroProyecto = document.getElementById('filtroProyecto');
    var buscador = document.getElementById('buscador');
    
    var fechaInicioVal = fechaInicio ? fechaInicio.value : '';
    var fechaFinVal = fechaFin ? fechaFin.value : '';
    var estatusVal = filtroEstatus ? filtroEstatus.value : '';
    var areaIdVal = filtroArea ? filtroArea.value : '';
    var proyectoIdVal = filtroProyecto ? filtroProyecto.value : '';
    var buscarVal = buscador ? buscador.value : '';
    
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
    .then(function(response) { return response.json(); })
    .then(function(data) {
        console.log('Datos recibidos:', data);
        mostrarTabla(data);
        var totalRegistros = document.getElementById('totalRegistros');
        if (totalRegistros) {
            totalRegistros.innerHTML = 'Total Requisiciones: ' + (data.total || (data.data ? data.data.length : 0));
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px; color:red;">Error: ' + error.message + '</td></tr>';
        }
    });
}

function mostrarTabla(data) {
    var items = data.data || [];
    var tbody = document.getElementById('tablaBody');
    if (!tbody) return;
    
    if (items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;">No hay requisiciones registradas</td></tr>';
        return;
    }
    
    var html = '';
    for (var i = 0; i < items.length; i++) {
        var req = items[i];
        var estatusClass = '';
        if (req.estatus === 'Activo') estatusClass = 'badge-activo';
        else if (req.estatus === 'Pendiente') estatusClass = 'badge-pendiente';
        else if (req.estatus === 'Cotizado') estatusClass = 'badge-cotizado';
        else estatusClass = 'badge-cancelado';
        
        var fecha = req.fecha_requerimiento ? req.fecha_requerimiento.substring(0,10) : '';
        var areaNombre = 'N/A';
        if (req.area) {
            if (typeof req.area === 'object') {
                areaNombre = req.area.nombre || 'N/A';
            } else {
                areaNombre = req.area;
            }
        }
        
        var proyectoNombre = 'N/A';
        if (req.proyecto) {
            if (typeof req.proyecto === 'object') {
                proyectoNombre = req.proyecto.nombre || 'N/A';
            } else {
                proyectoNombre = req.proyecto;
            }
        }
        
        html += '<tr>' +
            '<td style="text-align: center;"><span class="' + estatusClass + '">' + req.estatus + '</span></td>' +
            '<td style="text-align: center; font-weight: 500;">' + req.folio + '</td>' +
            '<td style="text-align: center;">' + fecha + '</td>' +
            '<td>' + req.solicitante + '</td>' +
            '<td>' + areaNombre + '</td>' +
            '<td>' + proyectoNombre + '</td>' +
            '<td style="text-align: center;"><span class="badge-cotizado">' + req.cotizadas + '</span></td>' +
            '<td style="text-align: center;">' +
                '<i class="fas fa-eye btn-icon" onclick="verRequisicion(' + req.id + ')" style="color: #17a2b8; cursor: pointer;"></i> ' +
                '<i class="fas fa-edit btn-icon" onclick="editarRequisicion(' + req.id + ')" style="color: #083CAE; cursor: pointer;"></i> ' +
                '<i class="fas fa-trash btn-icon" onclick="eliminarRequisicion(' + req.id + ', \'' + req.folio + '\')" style="color: #dc3545; cursor: pointer;"></i>' +
            '</td>' +
        '<\/tr>';
    }
    tbody.innerHTML = html;
}

function verRequisicion(id) {
    fetch('/compras/requisiciones/' + id)
        .then(function(response) { return response.json(); })
        .then(function(req) {
            var areaNombre = 'N/A';
            if (req.area) {
                if (typeof req.area === 'object') {
                    areaNombre = req.area.nombre || 'N/A';
                } else {
                    areaNombre = req.area;
                }
            }
            
            var proyectoNombre = 'N/A';
            if (req.proyecto) {
                if (typeof req.proyecto === 'object') {
                    proyectoNombre = req.proyecto.nombre || 'N/A';
                } else {
                    proyectoNombre = req.proyecto;
                }
            }
            
            var html = '<div style="margin-bottom: 10px;"><strong>Folio:</strong> ' + req.folio + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Fecha:</strong> ' + (req.fecha_requerimiento ? req.fecha_requerimiento.substring(0,10) : 'N/A') + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Estatus:</strong> ' + req.estatus + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Solicitante:</strong> ' + req.solicitante + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Área:</strong> ' + areaNombre + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Proyecto:</strong> ' + proyectoNombre + '</div>' +
                '<div style="margin-bottom: 10px;"><strong>Cotizadas:</strong> ' + req.cotizadas + '</div>' +
                '<div><strong>Observaciones:</strong> ' + (req.observaciones || 'N/A') + '</div>';
            
            if (req.articulos && req.articulos.length > 0) {
                html += '<hr><h4>Artículos:</h4><ul>';
                for (var i = 0; i < req.articulos.length; i++) {
                    html += '<li>' + req.articulos[i].descripcion + ' - ' + req.articulos[i].cantidad + ' ' + req.articulos[i].unidad_medida + '</li>';
                }
                html += '</ul>';
            }
            
            var detalleContenido = document.getElementById('detalleContenido');
            var modalDetalle = document.getElementById('modalDetalle');
            if (detalleContenido) detalleContenido.innerHTML = html;
            if (modalDetalle) modalDetalle.style.display = 'flex';
        });
}

function eliminarRequisicion(id, folio) {
    if (confirm('¿Eliminar requisición ' + folio + '?')) {
        fetch('/compras/requisiciones/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            alert(data.message || 'Eliminada');
            cargarRequisiciones();
        });
    }
}

function editarRequisicion(id) {
    alert('Edición en desarrollo para ID: ' + id);
}

function abrirModalRequisicion() {
    var modal = document.getElementById('modalAgregar');
    if (modal) modal.style.display = 'flex';
    
    var fechaInput = document.getElementById('fecha_requerimiento');
    if (fechaInput) fechaInput.value = new Date().toISOString().split('T')[0];
    
    var solicitanteInput = document.getElementById('solicitante');
    if (solicitanteInput) solicitanteInput.value = '';
    
    var areaSelect = document.getElementById('area_id');
    if (areaSelect) areaSelect.value = '';
    
    var proyectoSelect = document.getElementById('proyecto_id');
    if (proyectoSelect) proyectoSelect.value = '';
    
    var observacionesTextarea = document.getElementById('observaciones');
    if (observacionesTextarea) observacionesTextarea.value = '';
    
    var estatusSelect = document.getElementById('estatus');
    if (estatusSelect) estatusSelect.value = 'Pendiente';
    
    var container = document.getElementById('articulosContainer');
    if (container) {
        while (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
        var primerArticulo = container.children[0];
        if (primerArticulo) {
            var codigoInput = primerArticulo.querySelector('.articulo-codigo');
            var cantidadInput = primerArticulo.querySelector('.articulo-cantidad');
            var descripcionInput = primerArticulo.querySelector('.articulo-descripcion');
            var observacionInput = primerArticulo.querySelector('.articulo-observacion');
            if (codigoInput) codigoInput.value = '';
            if (cantidadInput) cantidadInput.value = '1';
            if (descripcionInput) descripcionInput.value = '';
            if (observacionInput) observacionInput.value = '';
        }
    }
}

function cerrarModalAgregar() {
    var modal = document.getElementById('modalAgregar');
    if (modal) modal.style.display = 'none';
}

function cerrarModalDetalle() {
    var modal = document.getElementById('modalDetalle');
    if (modal) modal.style.display = 'none';
}

function guardarRequisicion() {
    var articulos = [];
    var items = document.querySelectorAll('#articulosContainer .articulo-item');
    
    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        var cantidad = parseFloat(item.querySelector('.articulo-cantidad').value);
        var descripcion = item.querySelector('.articulo-descripcion').value.trim();
        
        if (!isNaN(cantidad) && cantidad > 0 && descripcion !== '') {
            articulos.push({
                codigo: item.querySelector('.articulo-codigo').value,
                cantidad: cantidad,
                unidad_medida: item.querySelector('.articulo-unidad').value,
                descripcion: descripcion,
                observacion: item.querySelector('.articulo-observacion').value,
                pendiente: true
            });
        }
    }
    
    if (articulos.length === 0) {
        alert('Debe agregar al menos un artículo válido');
        return;
    }
    
    var areaSelect = document.getElementById('area_id');
    var areaId = areaSelect ? areaSelect.value : '';
    var areaNombre = areaSelect && areaSelect.selectedIndex !== -1 ? areaSelect.options[areaSelect.selectedIndex].text : '';
    var proyectoId = document.getElementById('proyecto_id') ? document.getElementById('proyecto_id').value : null;
    
    var data = {
        fecha_requerimiento: document.getElementById('fecha_requerimiento') ? document.getElementById('fecha_requerimiento').value : '',
        solicitante: document.getElementById('solicitante') ? document.getElementById('solicitante').value : '',
        area_id: areaId,
        area: areaNombre,
        proyecto_id: proyectoId,
        estatus: document.getElementById('estatus') ? document.getElementById('estatus').value : 'Pendiente',
        observaciones: document.getElementById('observaciones') ? document.getElementById('observaciones').value : '',
        articulos: articulos
    };
    
    if (!data.solicitante || !data.area_id) {
        alert('Complete los campos obligatorios');
        return;
    }
    
    fetch('/compras/requisiciones', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            alert('✅ Requisición creada');
            cerrarModalAgregar();
            cargarRequisiciones();
        } else {
            alert('❌ ' + data.message);
        }
    });
}

function agregarFilaArticulo() {
    var container = document.getElementById('articulosContainer');
    if (!container) return;
    
    var nuevoArticulo = document.createElement('div');
    nuevoArticulo.className = 'articulo-item';
    nuevoArticulo.style.cssText = 'background: #f9f9f9; padding: 12px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e0e0e0;';
    nuevoArticulo.innerHTML = '<div style="display: grid; grid-template-columns: 1fr 0.5fr 0.5fr 0.2fr; gap: 10px; margin-bottom: 10px;">' +
        '<input type="text" placeholder="Código" class="articulo-codigo" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">' +
        '<input type="number" placeholder="Cantidad" class="articulo-cantidad" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;" value="1" step="0.001">' +
        '<select class="articulo-unidad" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">' +
            '<option>Pieza</option><option>Kilogramo</option><option>Litro</option><option>Metro</option><option>Caja</option>' +
        '</select>' +
        '<button type="button" class="btn-remove" style="background: #dc3545; color: white; border: none; padding: 8px; border-radius: 4px; cursor: pointer;">' +
            '<i class="fas fa-trash"></i>' +
        '</button>' +
    '</div>' +
    '<input type="text" placeholder="Descripción del artículo *" class="articulo-descripcion" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px;">' +
    '<input type="text" placeholder="Observación (opcional)" class="articulo-observacion" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">';
    container.appendChild(nuevoArticulo);
    
    var btnRemove = nuevoArticulo.querySelector('.btn-remove');
    if (btnRemove) {
        btnRemove.addEventListener('click', function() { eliminarArticulo(this); });
    }
}

function eliminarArticulo(btn) {
    var container = document.getElementById('articulosContainer');
    if (container && container.children.length > 1) {
        btn.closest('.articulo-item').remove();
    } else {
        alert('Debe haber al menos un artículo');
    }
}
</script>

@endsection