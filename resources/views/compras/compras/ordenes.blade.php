@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-shopping-cart"></i> Órdenes para Cotizar
                </h2>
                <p class="text-center text-muted mb-0" style="font-size: 12px;">Requisiciones autorizadas pendientes de cotización</p>
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
                            @foreach($proyectos ?? [] as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 12px; font-weight: 600;">Estatus Cotización</label>
                        <select id="filtroEstatus" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="Pendiente">Sin Cotizar</option>
                            <option value="En_Cotizacion">En Proceso (con cotizaciones)</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" class="btn btn-primary" style="background-color: var(--color-primary); color: white; border: none; padding: 8px 20px; border-radius: 4px; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Tabla de Requisiciones -->
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
                                    @if($req->estatus_cotizacion == 'Pendiente' || !$req->estatus_cotizacion)
                                        <span class="badge" style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 4px;">Pendiente</span>
                                    @elseif($req->estatus_cotizacion == 'En_Cotizacion')
                                        <span class="badge" style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px;">En Cotización</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px;">
                                        <button class="btn-ver-articulos btn-sm" data-id="{{ $req->id }}" data-folio="{{ $req->folio }}" style="background-color: var(--color-primary); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 11px;">
                                            <i class="fas fa-list"></i> Ver Artículos
                                        </button>
                                    </div>
                                </td>
                             </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay requisiciones autorizadas pendientes de cotizar</p>
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

<!-- MODAL DE ARTÍCULOS PARA COTIZAR -->
<div id="modalArticulos" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1200px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloArticulos">Artículos para Cotizar</h3>
            <button onclick="cerrarModalArticulos()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="contenidoArticulos" style="padding: 20px;">
            Cargando...
        </div>
    </div>
</div>

<!-- MODAL PARA COTIZAR UN ARTÍCULO -->
<div id="modalCotizarArticulo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Cotizar Artículo</h3>
            <button onclick="cerrarModalCotizarArticulo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <form id="formCotizarArticulo">
                @csrf
                <input type="hidden" id="requisicion_articulo_id" name="requisicion_articulo_id">
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Artículo</label>
                    <div id="infoArticulo" style="margin-top: 5px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; font-size: 13px;"></div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Proveedor *</label>
                    <select id="proveedor_id" name="proveedor_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} - {{ $proveedor->rfc }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Precio Unitario *</label>
                    <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                    <small style="color: #6c757d;">Total estimado: <span id="totalEstimado">$0.00</span></small>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Tiempo Entrega (días)</label>
                    <input type="number" id="tiempo_entrega" name="tiempo_entrega" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 15">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Condiciones de Pago</label>
                    <input type="text" id="condiciones_pago" name="condiciones_pago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 30 días, Contado">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600;">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>

                <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-weight: bold;">Subtotal:</span>
                        <span id="subtotalDisplay">$0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-weight: bold;">IVA (16%):</span>
                        <span id="ivaDisplay">$0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 16px; color: var(--color-primary);">
                        <span style="font-weight: bold;">TOTAL:</span>
                        <span id="totalDisplay" style="font-weight: bold;">$0.00</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalCotizarArticulo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                        <i class="fas fa-save"></i> Guardar Cotización
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
    .btn-primary { background-color: var(--color-primary) !important; }
    .table th, .table td { vertical-align: middle; }
    .cotizacion-existente { background-color: #d4edda !important; }
    .btn-sm { font-size: 11px; padding: 6px 12px; cursor: pointer; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let cantidadActual = 0;

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
    
    document.querySelectorAll('.btn-ver-articulos').forEach(btn => {
        btn.addEventListener('click', function() {
            const requisicionId = this.dataset.id;
            const folio = this.dataset.folio;
            verArticulosRequisicion(requisicionId, folio);
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

// ==================== ARTÍCULOS PARA COTIZAR ====================
async function verArticulosRequisicion(requisicionId, folio) {
    const modal = document.getElementById('modalArticulos');
    const contenido = document.getElementById('contenidoArticulos');
    
    document.getElementById('modalTituloArticulos').innerHTML = `Artículos para Cotizar - Requisición ${folio}`;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    contenido.innerHTML = '<div style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Cargando artículos...</div>';
    
    try {
        const response = await fetch(`/compras/cotizaciones/articulos/${requisicionId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success && result.data) {
            renderizarArticulos(result.data, requisicionId);
        } else {
            contenido.innerHTML = '<div style="text-align: center; color: red;">Error al cargar artículos: ' + (result.message || '') + '</div>';
        }
    } catch (error) {
        console.error('Error:', error);
        contenido.innerHTML = '<div style="text-align: center; color: red;">Error de conexión: ' + error.message + '</div>';
    }
}

function renderizarArticulos(data, requisicionId) {
    const contenido = document.getElementById('contenidoArticulos');
    
    if (!data.articulos || data.articulos.length === 0) {
        contenido.innerHTML = '<div style="text-align: center; color: #6c757d;">No hay artículos en esta requisición</div>';
        return;
    }
    
    let html = `
        <div style="overflow-x: auto;">
            <table class="table table-bordered" style="width: 100%; font-size: 12px;">
                <thead style="background-color: var(--color-primary); color: white;">
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Mejor Precio</th>
                        <th>Total Estimado</th>
                        <th>Cotizaciones</th>
                        <th>Estatus</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    data.articulos.forEach(art => {
        const mejorPrecio = art.mejor_precio;
        const totalEstimado = mejorPrecio ? (parseFloat(mejorPrecio) * art.cantidad).toFixed(2) : null;
        const yaCotizado = art.cotizada;
        
        html += `
            <tr class="${yaCotizado ? 'cotizacion-existente' : ''}">
                <td style="padding: 8px;">${art.codigo || '-'}</td>
                <td style="padding: 8px; max-width: 250px;">${art.descripcion || '-'}</td>
                <td style="padding: 8px; text-align: center;">${art.cantidad}</td>
                <td style="padding: 8px; text-align: center;">${art.unidad_medida || 'Pza'}</td>
                <td style="padding: 8px; text-align: right; font-weight: bold;">
                    ${mejorPrecio ? '$' + mejorPrecio : '-'}
                </td>
                <td style="padding: 8px; text-align: right;">
                    ${totalEstimado ? '$' + totalEstimado : '-'}
                </td>
                <td style="padding: 8px; text-align: center;">
                    ${art.cotizaciones_count > 0 
                        ? `<span class="badge" style="background-color: #17a2b8; color: white;">${art.cotizaciones_count} cotizaciones</span>`
                        : '<span class="badge" style="background-color: #6c757d; color: white;">Sin cotizaciones</span>'
                    }
                </td>
                <td style="padding: 8px;">
                    ${yaCotizado 
                        ? '<span class="badge" style="background-color: #28a745; color: white;">Cotizado</span>'
                        : '<span class="badge" style="background-color: #ffc107; color: #212529;">Sin Cotizar</span>'
                    }
                </td>
                <td style="padding: 8px; text-align: center;">
                    <button class="btn-cotizar-articulo" 
                            data-id="${art.id}"
                            data-codigo="${art.codigo || ''}"
                            data-descripcion="${art.descripcion || ''}"
                            data-cantidad="${art.cantidad}"
                            data-unidad="${art.unidad_medida || 'Pza'}"
                            style="background-color: var(--color-primary); color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 11px;">
                        <i class="fas fa-file-invoice"></i> ${yaCotizado ? 'Ver Cotizaciones' : 'Cotizar'}
                    </button>
                </td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
        <div style="margin-top: 15px; text-align: right;">
            <button onclick="cerrarModalArticulos()" class="btn btn-secondary" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
        </div>
    `;
    
    contenido.innerHTML = html;
    
    document.querySelectorAll('.btn-cotizar-articulo').forEach(btn => {
        btn.addEventListener('click', function() {
            const cantidad = parseFloat(this.dataset.cantidad);
            abrirModalCotizarArticulo({
                id: this.dataset.id,
                codigo: this.dataset.codigo,
                descripcion: this.dataset.descripcion,
                cantidad: cantidad,
                unidad: this.dataset.unidad
            });
        });
    });
}

function abrirModalCotizarArticulo(articulo) {
    cantidadActual = articulo.cantidad;
    
    document.getElementById('requisicion_articulo_id').value = articulo.id;
    document.getElementById('infoArticulo').innerHTML = `
        <strong>${articulo.codigo || 'Sin código'}</strong><br>
        ${articulo.descripcion}<br>
        <span style="color: #6c757d;">Cantidad: ${articulo.cantidad} ${articulo.unidad}</span>
    `;
    document.getElementById('proveedor_id').value = '';
    document.getElementById('precio_unitario').value = '';
    document.getElementById('tiempo_entrega').value = '';
    document.getElementById('condiciones_pago').value = '';
    document.getElementById('observaciones').value = '';
    
    document.getElementById('totalEstimado').innerHTML = '$0.00';
    document.getElementById('subtotalDisplay').innerHTML = '$0.00';
    document.getElementById('ivaDisplay').innerHTML = '$0.00';
    document.getElementById('totalDisplay').innerHTML = '$0.00';
    
    document.getElementById('modalCotizarArticulo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

document.getElementById('precio_unitario').addEventListener('input', function() {
    const precio = parseFloat(this.value) || 0;
    const cantidad = cantidadActual;
    const subtotal = precio * cantidad;
    const iva = subtotal * 0.16;
    const total = subtotal + iva;
    
    document.getElementById('totalEstimado').innerHTML = `$${total.toFixed(2)}`;
    document.getElementById('subtotalDisplay').innerHTML = `$${subtotal.toFixed(2)}`;
    document.getElementById('ivaDisplay').innerHTML = `$${iva.toFixed(2)}`;
    document.getElementById('totalDisplay').innerHTML = `$${total.toFixed(2)}`;
});

document.getElementById('formCotizarArticulo').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const proveedorId = document.getElementById('proveedor_id').value;
    if (!proveedorId) {
        alert('❌ Por favor seleccione un proveedor');
        return;
    }
    
    const precio = document.getElementById('precio_unitario').value;
    if (!precio || precio <= 0) {
        alert('❌ Por favor ingrese un precio válido');
        return;
    }
    
    const data = {
        requisicion_articulo_id: document.getElementById('requisicion_articulo_id').value,
        proveedor_id: proveedorId,
        precio_unitario: parseFloat(precio),
        tiempo_entrega_dias: document.getElementById('tiempo_entrega').value || null,
        condiciones_pago: document.getElementById('condiciones_pago').value || null,
        observaciones: document.getElementById('observaciones').value || null
    };
    
    const btnSubmit = this.querySelector('button[type="submit"]');
    const textoOriginal = btnSubmit.innerHTML;
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btnSubmit.disabled = true;
    
    try {
        const response = await fetch('/compras/cotizaciones', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            cerrarModalCotizarArticulo();
            cerrarModalArticulos();
            location.reload();
        } else {
            alert('❌ Error: ' + (result.message || 'No se pudo guardar la cotización'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error de conexión: ' + error.message);
    } finally {
        btnSubmit.innerHTML = textoOriginal;
        btnSubmit.disabled = false;
    }
});

function cerrarModalArticulos() {
    document.getElementById('modalArticulos').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalCotizarArticulo() {
    document.getElementById('modalCotizarArticulo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalArticulos();
        cerrarModalCotizarArticulo();
    }
});

document.getElementById('modalArticulos')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalArticulos();
});

document.getElementById('modalCotizarArticulo')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalCotizarArticulo();
});
</script>
@endsection