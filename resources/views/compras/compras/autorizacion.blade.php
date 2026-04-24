@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-check-double"></i> Autorización de Cotizaciones
                </h2>
                <p class="text-center text-muted mb-0" style="font-size: 12px;">Seleccione la mejor cotización por artículo</p>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="font-size: 12px; font-weight: 600;">Folio</label>
                        <input type="text" id="filtroFolio" class="form-control" placeholder="Buscar por folio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600;">Proyecto</label>
                        <select id="filtroProyecto" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos los proyectos</option>
                            @if(isset($proyectos) && $proyectos->count() > 0)
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600;">Estatus</label>
                        <select id="filtroEstatus" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="En_Cotizacion">Pendientes de Autorizar</option>
                            <option value="Cotizada">Ya Autorizadas</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" class="btn btn-primary" style="background-color: var(--color-primary); color: white; border: none; padding: 8px 20px; border-radius: 4px; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Tabla de Requisiciones para Autorizar -->
                <div class="table-responsive" style="overflow-x: auto; border: 1px solid #dee2e6; border-radius: 4px;">
                    <table class="table table-bordered" style="width: 100%; font-size: 12px; margin-bottom: 0;">
                        <thead style="background-color: var(--color-primary); color: white;">
                            <tr>
                                <th style="padding: 10px;">Folio</th>
                                <th style="padding: 10px;">Fecha</th>
                                <th style="padding: 10px;">Proyecto</th>
                                <th style="padding: 10px;">Solicitante</th>
                                <th style="padding: 10px;">Artículos</th>
                                <th style="padding: 10px;">Cotizados</th>
                                <th style="padding: 10px;">Estatus</th>
                                <th style="padding: 10px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisiciones as $req)
                            @php
                                $totalArticulos = $req->articulos->count();
                                $cotizados = $req->articulos->where('cotizada', true)->count();
                                $porcentaje = $totalArticulos > 0 ? round(($cotizados / $totalArticulos) * 100) : 0;
                            @endphp
                            <tr>
                                <td style="padding: 10px;"><strong>{{ $req->folio }}</strong></td>
                                <td style="padding: 10px;">{{ $req->fecha_requerimiento ? date('d/m/Y', strtotime($req->fecha_requerimiento)) : '-' }}</td>
                                <td style="padding: 10px;">{{ $req->proyecto->nombre ?? '-' }}</td>
                                <td style="padding: 10px;">{{ $req->solicitante }}</td>
                                <td style="padding: 10px; text-align: center;">{{ $totalArticulos }}</td>
                                <td style="padding: 10px;">
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span>{{ $cotizados }}/{{ $totalArticulos }}</span>
                                        <div style="flex: 1; background-color: #e9ecef; border-radius: 4px; height: 6px;">
                                            <div style="width: {{ $porcentaje }}%; background-color: #28a745; border-radius: 4px; height: 6px;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 10px;">
                                    @if($req->estatus_cotizacion == 'En_Cotizacion')
                                        <span class="badge" style="background-color: #17a2b8; color: white;">Pendiente Autorización</span>
                                    @elseif($req->estatus_cotizacion == 'Cotizada')
                                        <span class="badge" style="background-color: #28a745; color: white;">Autorizada</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px;">
                                        @if($req->estatus_cotizacion == 'En_Cotizacion')
                                            <button class="btn-autorizar btn-sm" data-id="{{ $req->id }}" data-folio="{{ $req->folio }}" style="background-color: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 11px;">
                                                <i class="fas fa-check-circle"></i> Seleccionar Cotizaciones
                                            </button>
                                        @endif
                                        <button class="btn-ver-historial btn-sm" data-id="{{ $req->id }}" data-folio="{{ $req->folio }}" style="background-color: #17a2b8; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 11px;">
                                            <i class="fas fa-history"></i> Ver Historial
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay requisiciones con cotizaciones pendientes de autorizar</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA SELECCIONAR COTIZACIÓN POR ARTÍCULO -->
<div id="modalSeleccionarCotizacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1100px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloSeleccionar">Seleccionar Cotización</h3>
            <button onclick="cerrarModalSeleccionar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="contenidoSeleccionar" style="padding: 20px;">
            Cargando...
        </div>
    </div>
</div>

<!-- MODAL DETALLE COTIZACIÓN -->
<div id="modalDetalleCotizacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 80vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Detalle de Cotización</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="contenidoDetalle" style="padding: 20px;">
            Cargando...
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .btn-primary { background-color: var(--color-primary) !important; }
    .table th, .table td { vertical-align: middle; }
    .btn-sm { font-size: 11px; padding: 6px 12px; cursor: pointer; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let currentRequisicionId = null;

document.addEventListener('DOMContentLoaded', function() {
    configurarEventos();
});

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', function() {
        aplicarFiltros();
    });
    
    document.getElementById('filtroFolio')?.addEventListener('keyup', aplicarFiltros);
    document.getElementById('filtroProyecto')?.addEventListener('change', aplicarFiltros);
    document.getElementById('filtroEstatus')?.addEventListener('change', aplicarFiltros);
    
    document.querySelectorAll('.btn-autorizar').forEach(btn => {
        btn.addEventListener('click', function() {
            const requisicionId = this.dataset.id;
            const folio = this.dataset.folio;
            abrirModalSeleccionar(requisicionId, folio);
        });
    });
    
    document.querySelectorAll('.btn-ver-historial').forEach(btn => {
        btn.addEventListener('click', function() {
            const requisicionId = this.dataset.id;
            const folio = this.dataset.folio;
            verHistorialRequisicion(requisicionId, folio);
        });
    });
}

function aplicarFiltros() {
    const folio = document.getElementById('filtroFolio')?.value || '';
    const proyecto = document.getElementById('filtroProyecto')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    
    const url = new URL(window.location.href);
    if (folio) url.searchParams.set('folio', folio);
    if (proyecto) url.searchParams.set('proyecto', proyecto);
    if (estatus) url.searchParams.set('estatus_cotizacion', estatus);
    
    window.location.href = url.toString();
}

// ==================== MODAL SELECTOR DE COTIZACIONES ====================
async function abrirModalSeleccionar(requisicionId, folio) {
    currentRequisicionId = requisicionId;
    const modal = document.getElementById('modalSeleccionarCotizacion');
    const contenido = document.getElementById('contenidoSeleccionar');
    
    document.getElementById('modalTituloSeleccionar').innerHTML = `Seleccionar Cotizaciones - Requisición ${folio}`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    contenido.innerHTML = '<div style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Cargando artículos...</div>';
    
    try {
        const response = await fetch(`/compras/cotizaciones/articulos/${requisicionId}`);
        const result = await response.json();
        
        if (result.success && result.data) {
            renderizarSelector(result.data);
        } else {
            contenido.innerHTML = '<div style="text-align: center; color: red;">Error al cargar artículos</div>';
        }
    } catch (error) {
        console.error('Error:', error);
        contenido.innerHTML = '<div style="text-align: center; color: red;">Error de conexión: ' + error.message + '</div>';
    }
}

function renderizarSelector(data) {
    const contenido = document.getElementById('contenidoSeleccionar');
    
    if (!data.articulos || data.articulos.length === 0) {
        contenido.innerHTML = '<div style="text-align: center;">No hay artículos en esta requisición</div>';
        return;
    }
    
    let html = `
        <div style="margin-bottom: 15px; text-align: right;">
            <button id="btnConfirmarTodas" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                <i class="fas fa-check-double"></i> Confirmar y Autorizar Todas las Selecciones
            </button>
        </div>
    `;
    
    data.articulos.forEach(articulo => {
        const tieneCotizaciones = articulo.cotizaciones.length > 0;
        const yaSeleccionada = articulo.cotizacion_seleccionada !== null;
        
        html += `
            <div style="margin-bottom: 25px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                <div style="background-color: #e9ecef; padding: 10px 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>${articulo.codigo || 'Sin código'}</strong> - ${articulo.descripcion}
                            <span style="margin-left: 15px; font-size: 11px;">Cantidad: ${articulo.cantidad} ${articulo.unidad_medida}</span>
                        </div>
                        ${yaSeleccionada ? '<span class="badge" style="background-color: #28a745; color: white;">Ya Seleccionada</span>' : ''}
                    </div>
                </div>
                <div style="padding: 15px; overflow-x: auto;">
        `;
        
        if (!tieneCotizaciones) {
            html += `<p style="color: #6c757d; text-align: center;">No hay cotizaciones para este artículo</p>`;
        } else {
            html += `
                <table class="table table-bordered" style="width: 100%; font-size: 11px;">
                    <thead style="background-color: #e9ecef;">
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Proveedor</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>IVA (16%)</th>
                            <th>Total</th>
                            <th>Tiempo Entrega</th>
                            <th>Condiciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            articulo.cotizaciones.forEach(cot => {
                // Convertir valores a números
                const precioUnitario = parseFloat(cot.precio_unitario) || 0;
                const cantidad = parseFloat(articulo.cantidad) || 0;
                const subtotal = precioUnitario * cantidad;
                const iva = subtotal * 0.16;
                const total = subtotal + iva;
                const isSelected = articulo.cotizacion_seleccionada && articulo.cotizacion_seleccionada.id === cot.id;
                
                html += `
                    <tr style="${isSelected ? 'background-color: #d4edda;' : ''}">
                        <td style="text-align: center;">
                            <input type="radio" name="cotizacion_${articulo.id}" value="${cot.id}" data-proveedor="${cot.proveedor_nombre}" ${isSelected ? 'checked' : ''}>
                        </td>
                        <td><strong>${cot.proveedor_nombre}</strong></td>
                        <td style="text-align: right;">$${precioUnitario.toFixed(2)}</td>
                        <td style="text-align: right;">$${subtotal.toFixed(2)}</td>
                        <td style="text-align: right;">$${iva.toFixed(2)}</td>
                        <td style="text-align: right; font-weight: bold;">$${total.toFixed(2)}</td>
                        <td style="text-align: center;">${cot.tiempo_entrega_dias || '-'} días</td>
                        <td style="text-align: center;">${cot.condiciones_pago || '-'}</td>
                    </table>
                `;
            });
            
            html += `
                    </tbody>
                </table>
            `;
        }
        
        html += `</div></div>`;
    });
    
    contenido.innerHTML = html;
    
    document.getElementById('btnConfirmarTodas')?.addEventListener('click', function() {
        confirmarTodasSelecciones();
    });
}

function confirmarTodasSelecciones() {
    const selecciones = [];
    const radios = document.querySelectorAll('#contenidoSeleccionar input[type="radio"]:checked');
    
    radios.forEach(radio => {
        selecciones.push({
            cotizacion_id: radio.value,
            proveedor: radio.dataset.proveedor
        });
    });
    
    if (selecciones.length === 0) {
        alert('❌ No ha seleccionado ninguna cotización');
        return;
    }
    
    if (!confirm(`¿Confirmar ${selecciones.length} cotización(es) seleccionada(s) y autorizar la requisición?`)) {
        return;
    }
    
    procesarSelecciones(selecciones);
}

async function procesarSelecciones(selecciones) {
    const btnConfirmar = document.getElementById('btnConfirmarTodas');
    const textoOriginal = btnConfirmar.innerHTML;
    btnConfirmar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando selecciones...';
    btnConfirmar.disabled = true;
    
    let successCount = 0;
    let errorCount = 0;
    
    // Primero seleccionar todas las cotizaciones
    for (const seleccion of selecciones) {
        try {
            const response = await fetch(`/compras/cotizaciones/seleccionar/${seleccion.cotizacion_id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                successCount++;
            } else {
                errorCount++;
                console.error('Error seleccionando:', result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            errorCount++;
        }
    }
    
    if (successCount === 0) {
        alert(`❌ Error: No se pudo seleccionar ninguna cotización`);
        btnConfirmar.innerHTML = textoOriginal;
        btnConfirmar.disabled = false;
        return;
    }
    
    // Luego autorizar la requisición completa
    btnConfirmar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Autorizando requisición...';
    
    try {
        const response = await fetch(`/compras/cotizaciones/autorizar-todas/${currentRequisicionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(`✅ Éxito:\n- ${successCount} cotizaciones seleccionadas\n- Requisición autorizada correctamente`);
            cerrarModalSeleccionar();
            location.reload();
        } else {
            alert(`⚠️ Parcial:\n- ${successCount} cotizaciones seleccionadas\n- ❌ Error al autorizar requisición: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`⚠️ Parcial:\n- ${successCount} cotizaciones seleccionadas\n- ❌ Error al autorizar requisición`);
    }
    
    btnConfirmar.innerHTML = textoOriginal;
    btnConfirmar.disabled = false;
}

// ==================== HISTORIAL ====================
async function verHistorialRequisicion(requisicionId, folio) {
    const modal = document.getElementById('modalSeleccionarCotizacion');
    const contenido = document.getElementById('contenidoSeleccionar');
    
    document.getElementById('modalTituloSeleccionar').innerHTML = `Historial de Cotizaciones - Requisición ${folio}`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    contenido.innerHTML = '<div style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Cargando historial...</div>';
    
    try {
        const response = await fetch(`/compras/cotizaciones/articulos/${requisicionId}`);
        const result = await response.json();
        
        if (result.success && result.data) {
            renderizarHistorial(result.data);
        } else {
            contenido.innerHTML = '<div style="text-align: center; color: red;">Error al cargar historial</div>';
        }
    } catch (error) {
        console.error('Error:', error);
        contenido.innerHTML = '<div style="text-align: center; color: red;">Error de conexión: ' + error.message + '</div>';
    }
}

function renderizarHistorial(data) {
    const contenido = document.getElementById('contenidoSeleccionar');
    
    if (!data.articulos || data.articulos.length === 0) {
        contenido.innerHTML = '<div style="text-align: center;">No hay artículos en esta requisición</div>';
        return;
    }
    
    let html = '<div style="text-align: right; margin-bottom: 15px;"><button onclick="cerrarModalSeleccionar()" class="btn btn-secondary" style="padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button></div>';
    
    data.articulos.forEach(articulo => {
        html += `
            <div style="margin-bottom: 25px; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                <div style="background-color: var(--color-primary); color: white; padding: 10px 15px;">
                    <strong>${articulo.codigo || 'Sin código'}</strong> - ${articulo.descripcion}
                    <span class="badge" style="background-color: ${articulo.cotizada ? '#28a745' : '#ffc107'}; color: ${articulo.cotizada ? 'white' : '#212529'}; margin-left: 10px;">
                        ${articulo.cotizada ? 'Cotizado' : 'Sin Cotizar'}
                    </span>
                    <span style="margin-left: 15px;">Cantidad: ${articulo.cantidad} ${articulo.unidad_medida}</span>
                </div>
                <div style="padding: 15px; overflow-x: auto;">
        `;
        
        if (articulo.cotizaciones.length === 0) {
            html += `<p style="text-align: center;">No hay cotizaciones para este artículo</p>`;
        } else {
            html += `
                <table class="table table-bordered" style="width: 100%; font-size: 11px;">
                    <thead style="background-color: #e9ecef;">
                        <tr>
                            <th>Proveedor</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>IVA</th>
                            <th>Total</th>
                            <th>Tiempo Entrega</th>
                            <th>Condiciones</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            articulo.cotizaciones.forEach(cot => {
                // Convertir valores a números de forma segura
                let precioUnitario = 0;
                if (cot.precio_unitario !== null && cot.precio_unitario !== undefined) {
                    precioUnitario = parseFloat(cot.precio_unitario);
                    if (isNaN(precioUnitario)) precioUnitario = 0;
                }
                
                let cantidad = 0;
                if (articulo.cantidad !== null && articulo.cantidad !== undefined) {
                    cantidad = parseFloat(articulo.cantidad);
                    if (isNaN(cantidad)) cantidad = 0;
                }
                
                const subtotal = precioUnitario * cantidad;
                const iva = subtotal * 0.16;
                const total = subtotal + iva;
                
                let estatusBadge = '';
                if (cot.estatus == 'Seleccionada') estatusBadge = '<span class="badge" style="background-color: #28a745; color: white;">SELECCIONADA</span>';
                else if (cot.estatus == 'Pendiente') estatusBadge = '<span class="badge" style="background-color: #ffc107; color: #212529;">Pendiente</span>';
                else estatusBadge = '<span class="badge" style="background-color: #dc3545; color: white;">Rechazada</span>';
                
                html += `
                    <tr>
                        <td><strong>${cot.proveedor_nombre || '-'}</strong></td>
                        <td style="text-align: right;">$${precioUnitario.toFixed(2)}</td>
                        <td style="text-align: right;">$${subtotal.toFixed(2)}</td>
                        <td style="text-align: right;">$${iva.toFixed(2)}</td>
                        <td style="text-align: right; font-weight: bold;">$${total.toFixed(2)}</td>
                        <td style="text-align: center;">${cot.tiempo_entrega_dias || '-'} días</td>
                        <td style="text-align: center;">${cot.condiciones_pago || '-'}</td>
                        <td style="text-align: center;">${estatusBadge}</td>
                        <td style="text-align: center;">${cot.fecha || '-'}</td>
                    </tr>
                `;
            });
            
            html += `
                    </tbody>
                </table>
            `;
        }
        
        if (articulo.cotizacion_seleccionada) {
            const sel = articulo.cotizacion_seleccionada;
            let precioSel = 0;
            if (sel.precio_unitario !== null && sel.precio_unitario !== undefined) {
                precioSel = parseFloat(sel.precio_unitario);
                if (isNaN(precioSel)) precioSel = 0;
            }
            html += `<div style="margin-top: 10px; padding: 8px; background-color: #d4edda; border-radius: 4px;">
                <strong>✓ Cotización Seleccionada:</strong> ${sel.proveedor_nombre || '-'} - $${precioSel.toFixed(2)}
            </div>`;
        }
        
        html += `</div></div>`;
    });
    
    contenido.innerHTML = html;
}

// ==================== FUNCIONES DE CIERRE ====================
function cerrarModalSeleccionar() {
    document.getElementById('modalSeleccionarCotizacion').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalleCotizacion').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalSeleccionar();
        cerrarModalDetalle();
    }
});

document.getElementById('modalSeleccionarCotizacion')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalSeleccionar();
});

document.getElementById('modalDetalleCotizacion')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalDetalle();
});
</script>
@endsection