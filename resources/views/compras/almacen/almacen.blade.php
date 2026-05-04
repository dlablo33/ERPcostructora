@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Almacén por Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Selector de obra y filtros -->
                <div style="display: grid; grid-template-columns: 3fr 1fr 1fr auto; gap: 10px; margin-bottom: 20px; align-items: flex-end;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Obra</label>
                        <select id="filtroObra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas las obras</option>
                            @isset($proyectos)
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Categoría</label>
                        <select id="filtroCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Familia</label>
                        <select id="filtroFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas</option>
                        </select>
                    </div>
                    <div>
                        <button id="btnFiltrar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>

                <!-- KPIs -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Total Artículos</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiTotalArticulos">0</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Valor Inventario</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiValorInventario">$0</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Bajo Mínimo</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiBajoMinimo">0</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Crítico</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiCritico">0</div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span id="obraSeleccionada" style="background-color: #e8f0fe; color: var(--color-primary); padding: 4px 12px; border-radius: 20px; font-size: 12px;">Todas las obras</span>
                        <button id="btnAgregar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Agregar material">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button id="btnExcel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Exportar Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button id="btnColumnas" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Seleccionar columnas" onclick="toggleColumnSelector()">
                            <i class="fas fa-columns"></i>
                        </button>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 30px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Selector de columnas (oculto) -->
                <div id="columnSelector" style="display: none; position: absolute; right: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 400px; overflow-y: auto; padding: 10px;">
                    <div style="font-weight: bold; color: var(--color-primary); margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #dee2e6;">Seleccionar Columnas</div>
                    <div id="columnasLista"></div>
                </div>

                <!-- Tabla -->
                <div class="table-container">
                    <table class="table" id="tablaInventario">
                        <thead style="background-color: var(--color-primary);">
                            <tr id="encabezadosTabla">
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="codigo">Código</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="categoria">Categoría</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="familia">Familia</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="cantidad">Cantidad</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="costo">Costo Unit.</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="importe">Importe</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="minimo">Mínimo</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="maximo">Máximo</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="12" style="text-align: center;">Cargando...</td></tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; text-align: right;">Totales:</td>
                                <td id="totalCantidad" style="padding: 10px; text-align: right;">0</td>
                                <td style="padding: 10px;"></td>
                                <td style="padding: 10px;"></td>
                                <td id="totalImporte" style="padding: 10px; text-align: right; font-weight: bold;">$0</td>
                                <td colspan="3" style="padding: 10px; text-align: center;">Total Artículos: <span id="totalArticulos">0</span></td>
                                <td style="padding: 10px;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 13px; color: #6c757d;">Mostrando <span id="inicioRegistro">0</span> - <span id="finRegistro">0</span> de <span id="totalRegistros">0</span> artículos</span>
                        <select id="registrosPorPagina" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button class="page-btn" id="btnPrimera" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-angle-double-left"></i>
                        </button>
                        <button class="page-btn" id="btnAnterior" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <span style="min-width: 40px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;" id="paginaActual">1</span>
                        <span style="font-size: 13px; color: #6c757d;">de <span id="totalPaginas">1</span></span>
                        <button class="page-btn" id="btnSiguiente" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button class="page-btn" id="btnUltima" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
                
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR MATERIAL -->
<div id="modalMaterial" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Agregar Material a Obra</h3>
            <button onclick="cerrarModalMaterial()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Obra *</label>
                    <select id="modalObra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Código *</label>
                    <input type="text" id="modalCodigo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="ART-001">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Descripción *</label>
                    <input type="text" id="modalDescripcion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del artículo">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad *</label>
                    <input type="number" step="0.001" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="1">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Unidad</label>
                    <input type="text" id="modalUnidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Pieza">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Costo Unitario</label>
                    <input type="number" step="0.01" id="modalCostoUnitario" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Mínimo</label>
                    <input type="number" id="modalMinimo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Máximo</label>
                    <input type="number" id="modalMaximo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalMaterial()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarMaterial()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background-color: white; width: 100%; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table th:last-child, .table td:last-child { position: sticky !important; right: 0 !important; z-index: 35 !important; box-shadow: -2px 0 5px rgba(0,0,0,0.1) !important; }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    [draggable="true"] { cursor: grab; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-weight: bold; color: var(--color-primary); }
    @media (max-width: 768px) { .table-container { max-height: 400px; } .table td { padding: 8px 4px; font-size: 12px; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let paginaActual = 1;
let registrosPorPagina = 10;
let totalRegistros = 0;
let columnasAgrupadas = [];

document.addEventListener('DOMContentLoaded', function() {
    cargarInventario();
    cargarFiltros();
    configurarEventos();
    configurarDragDrop();
});

async function cargarInventario() {
    const proyectoId = document.getElementById('filtroObra').value;
    const categoria = document.getElementById('filtroCategoria').value;
    const familia = document.getElementById('filtroFamilia').value;
    const busqueda = document.getElementById('buscador').value;
    
    let url = `/inventario/api/inventario-por-obra?page=${paginaActual}&per_page=${registrosPorPagina}`;
    if (proyectoId && proyectoId !== 'todas') url += `&proyecto_id=${proyectoId}`;
    if (categoria && categoria !== 'todas') url += `&categoria=${encodeURIComponent(categoria)}`;
    if (familia && familia !== 'todas') url += `&familia=${encodeURIComponent(familia)}`;
    if (busqueda) url += `&search=${encodeURIComponent(busqueda)}`;
    
    try {
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success) {
            renderizarTabla(data.data);
            actualizarPaginacion(data.current_page, data.last_page, data.total);
            if (data.kpis) actualizarKPIs(data.kpis);
        } else {
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function cargarFiltros() {
    try {
        const response = await fetch('/inventario/api/filtros-catalogos');
        const data = await response.json();
        if (data.success) {
            const categoriaSelect = document.getElementById('filtroCategoria');
            const familiaSelect = document.getElementById('filtroFamilia');
            
            if (data.categorias && data.categorias.length > 0) {
                categoriaSelect.innerHTML = '<option value="todas">Todas</option>';
                data.categorias.forEach(cat => {
                    categoriaSelect.innerHTML += `<option value="${cat.nombre}">${cat.nombre}</option>`;
                });
            }
            if (data.familias && data.familias.length > 0) {
                familiaSelect.innerHTML = '<option value="todas">Todas</option>';
                data.familias.forEach(fam => {
                    familiaSelect.innerHTML += `<option value="${fam.nombre}">${fam.nombre}</option>`;
                });
            }
        }
    } catch (error) {
        console.error('Error cargando filtros:', error);
    }
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    let totalCantidad = 0;
    let totalImporte = 0;
    
    if (!data || !data.length) {
        tbody.innerHTML = '<tr><td colspan="12" style="text-align: center;">No hay datos registrados</td></tr>';
        document.getElementById('totalCantidad').textContent = '0';
        document.getElementById('totalImporte').textContent = '$0';
        document.getElementById('totalArticulos').textContent = '0';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach(item => {
        const cantidad = parseFloat(item.cantidad) || 0;
        const costo = parseFloat(item.costo) || 0;
        const importe = parseFloat(item.importe) || 0;
        const minimo = parseFloat(item.minimo) || 0;
        const maximo = parseFloat(item.maximo) || 0;
        
        totalCantidad += cantidad;
        totalImporte += importe;
        
        let badgeStyle = '', badgeText = '';
        if (item.estatus === 'Crítico') {
            badgeStyle = 'background-color: #dc3545; color: white;';
            badgeText = 'Crítico';
        } else if (item.estatus === 'Bajo') {
            badgeStyle = 'background-color: #ffc107; color: #212529;';
            badgeText = 'Bajo';
        } else {
            badgeStyle = 'background-color: #28a745; color: white;';
            badgeText = 'Normal';
        }
        
        const row = tbody.insertRow();
        row.insertCell(0).innerHTML = `<strong>${escapeHtml(item.codigo) || '---'}</strong>`;
        row.insertCell(1).innerHTML = escapeHtml(item.descripcion) || '---';
        row.insertCell(2).innerHTML = escapeHtml(item.categoria) || '---';
        row.insertCell(3).innerHTML = escapeHtml(item.familia) || '---';
        row.insertCell(4).innerHTML = `<span style="${item.estatus === 'Crítico' ? 'color:#dc3545;font-weight:bold' : (item.estatus === 'Bajo' ? 'color:#ffc107;font-weight:bold' : '')}">${cantidad}</span>`;
        row.insertCell(5).innerHTML = escapeHtml(item.unidad) || '---';
        row.insertCell(6).innerHTML = `$${costo.toFixed(2)}`;
        row.insertCell(7).innerHTML = `<strong>$${importe.toFixed(2)}</strong>`;
        row.insertCell(8).innerHTML = minimo;
        row.insertCell(9).innerHTML = maximo;
        row.insertCell(10).innerHTML = `<span style="${badgeStyle} padding: 3px 10px; border-radius: 20px; font-size: 11px;">${badgeText}</span>`;
        row.insertCell(11).innerHTML = `
            <i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
            <i class="fas fa-edit" onclick="editarMaterial(${item.id})" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;"></i>
            <i class="fas fa-history" onclick="verHistorial(${item.id})" style="color: #6c757d; margin: 0 5px; cursor: pointer;"></i>
        `;
    });
    
    document.getElementById('totalCantidad').textContent = totalCantidad;
    document.getElementById('totalImporte').textContent = `$${totalImporte.toFixed(2)}`;
    document.getElementById('totalArticulos').textContent = data.length;
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function actualizarPaginacion(currentPage, lastPage, total) {
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('totalPaginas').textContent = lastPage;
    document.getElementById('totalRegistros').textContent = total;
    
    const inicio = ((currentPage - 1) * registrosPorPagina) + 1;
    const fin = Math.min(currentPage * registrosPorPagina, total);
    document.getElementById('inicioRegistro').textContent = total > 0 ? inicio : 0;
    document.getElementById('finRegistro').textContent = fin;
    
    document.getElementById('btnPrimera').disabled = currentPage === 1;
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === lastPage;
    document.getElementById('btnUltima').disabled = currentPage === lastPage;
}

function actualizarKPIs(kpis) {
    if (kpis) {
        document.getElementById('kpiTotalArticulos').textContent = kpis.total_articulos || 0;
        document.getElementById('kpiValorInventario').textContent = `$${(kpis.valor_inventario || 0).toFixed(2)}`;
        document.getElementById('kpiBajoMinimo').textContent = kpis.bajo_minimo || 0;
        document.getElementById('kpiCritico').textContent = kpis.critico || 0;
    }
}

function configurarEventos() {
    document.getElementById('btnFiltrar').addEventListener('click', () => { paginaActual = 1; cargarInventario(); });
    document.getElementById('buscador').addEventListener('input', () => { paginaActual = 1; cargarInventario(); });
    document.getElementById('btnPrimera').addEventListener('click', () => { paginaActual = 1; cargarInventario(); });
    document.getElementById('btnAnterior').addEventListener('click', () => { if (paginaActual > 1) { paginaActual--; cargarInventario(); } });
    document.getElementById('btnSiguiente').addEventListener('click', () => { paginaActual++; cargarInventario(); });
    document.getElementById('btnUltima').addEventListener('click', async () => {
        const response = await fetch(`/inventario/api/inventario-por-obra?per_page=${registrosPorPagina}`);
        const data = await response.json();
        if (data.success) paginaActual = data.last_page;
        cargarInventario();
    });
    document.getElementById('registrosPorPagina').addEventListener('change', (e) => {
        registrosPorPagina = parseInt(e.target.value);
        paginaActual = 1;
        cargarInventario();
    });
    document.getElementById('btnAgregar').addEventListener('click', abrirModalMaterial);
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar a Excel en desarrollo'));
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Crear filtro personalizado'));
}

function configurarDragDrop() {
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
            e.target.style.opacity = '0.5';
        }
    });
    document.addEventListener('dragend', (e) => { if (e.target.tagName === 'TH') e.target.style.opacity = '1'; });
    
    const grupo = document.getElementById('grupoAgrupacion');
    if (grupo) {
        grupo.addEventListener('dragover', (e) => { e.preventDefault(); e.dataTransfer.dropEffect = 'copy'; });
        grupo.addEventListener('drop', (e) => {
            e.preventDefault();
            const columna = e.dataTransfer.getData('text/plain');
            if (columna && !columnasAgrupadas.includes(columna)) {
                columnasAgrupadas.push(columna);
                actualizarGrupoColumnas();
            }
        });
    }
}

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    const texto = document.getElementById('textoAgrupar');
    if (!container) return;
    container.innerHTML = '';
    if (columnasAgrupadas.length === 0) {
        if (texto) texto.style.display = 'inline';
    } else {
        if (texto) texto.style.display = 'none';
        columnasAgrupadas.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
            container.appendChild(chip);
        });
    }
}

window.removerColumna = function(columna) {
    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
    actualizarGrupoColumnas();
};

window.toggleColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    if (!selector) return;
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    if (selector.style.display === 'block') {
        const columnas = [
            { field: 'codigo', caption: 'Código' },
            { field: 'descripcion', caption: 'Descripción' },
            { field: 'categoria', caption: 'Categoría' },
            { field: 'familia', caption: 'Familia' },
            { field: 'cantidad', caption: 'Cantidad' },
            { field: 'unidad', caption: 'Unidad' },
            { field: 'costo', caption: 'Costo Unit.' },
            { field: 'importe', caption: 'Importe' },
            { field: 'minimo', caption: 'Mínimo' },
            { field: 'maximo', caption: 'Máximo' },
            { field: 'estatus', caption: 'Estatus' }
        ];
        const lista = document.getElementById('columnasLista');
        if (lista) {
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0;">
                    <input type="checkbox" id="chk_${col.field}" data-columna="${col.field}" checked style="margin-right: 8px;">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    }
};

window.abrirModalMaterial = function() { 
    const modal = document.getElementById('modalMaterial');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
};

window.cerrarModalMaterial = function() { 
    const modal = document.getElementById('modalMaterial');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
};

window.guardarMaterial = async function() {
    const data = {
        proyecto_id: document.getElementById('modalObra')?.value,
        articulo_id: null,
        cantidad_inicial: parseFloat(document.getElementById('modalCantidad')?.value) || 0,
        almacen_id: 1,
        cantidad_minima: parseFloat(document.getElementById('modalMinimo')?.value) || 0,
        cantidad_maxima: parseFloat(document.getElementById('modalMaximo')?.value) || 0,
        costo_inicial: parseFloat(document.getElementById('modalCostoUnitario')?.value) || 0,
        observaciones: document.getElementById('modalObservaciones')?.value || ''
    };
    
    if (!data.proyecto_id) {
        alert('Seleccione una obra');
        return;
    }
    
    try {
        const articuloResponse = await fetch('/inventario/api/articulos/buscar-o-crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
            body: JSON.stringify({
                codigo: document.getElementById('modalCodigo')?.value,
                descripcion: document.getElementById('modalDescripcion')?.value,
                unidad_medida: document.getElementById('modalUnidad')?.value
            })
        });
        const articuloData = await articuloResponse.json();
        if (articuloData.success && articuloData.data.id) {
            data.articulo_id = articuloData.data.id;
            const response = await fetch('/inventario/api/inventario', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                alert('Material agregado correctamente');
                cerrarModalMaterial();
                cargarInventario();
            } else {
                alert('Error: ' + (result.message || 'Error desconocido'));
            }
        } else {
            alert('Error al crear/buscar el artículo');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    }
};

window.verDetalle = function(id) { alert('Ver detalle ID: ' + id); };
window.editarMaterial = function(id) { alert('Editar material ID: ' + id); };
window.verHistorial = function(id) { alert('Historial ID: ' + id); };

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') cerrarModalMaterial(); });
document.getElementById('modalMaterial')?.addEventListener('click', (e) => { if (e.target === document.getElementById('modalMaterial')) cerrarModalMaterial(); });
</script>
@endsection