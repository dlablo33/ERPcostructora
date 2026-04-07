@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Tabla de Sueldos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Mostrar mensajes de éxito/error -->
                @if(session('success'))
                    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar tabla de sueldos"
                                    onclick="abrirModalTablaSueldos()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." value="{{ request('search') }}" style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Sueldos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaSueldos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_ejecuto">Fecha Ejecutó</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_inicial">Fecha Inicial</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_final">Fecha Final</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cantidad">Cantidad Registros</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto">Monto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaSueldosBody">
                            @forelse($tablaSueldos as $sueldo)
                            <tr data-id="{{ $sueldo->id }}">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $sueldo->folio }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($sueldo->fecha_ejecuto)->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($sueldo->fecha_inicial)->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($sueldo->fecha_final)->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ number_format($sueldo->cantidad_registros) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($sueldo->monto, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span class="badge-{{ strtolower($sueldo->estatus) }}">
                                        {{ $sueldo->estatus }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $sueldo->id }})" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRegistro({{ $sueldo->id }})" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarRegistro({{ $sueldo->id }}, '{{ $sueldo->folio }}')" title="Eliminar"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $sueldo->id }})" title="Generar PDF"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-inbox" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay registros de tablas de sueldos</p>
                                    <button onclick="abrirModalTablaSueldos()" class="btn btn-primary" style="margin-top: 10px; background-color: var(--color-primary); color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Crear primera tabla</button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="8" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">
                                    Total registros: {{ $tablaSueldos->total() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $tablaSueldos->appends(request()->query())->links() }}
                </div>
                
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA NUEVA/EDICIÓN DE TABLA DE SUELDOS -->
<div id="modalTablaSueldos" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 id="modalTitle" style="color: white; margin: 0; font-size: 18px;">Nueva Tabla de Sueldos</h3>
            <button onclick="cerrarModalTablaSueldos()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <form id="formTablaSueldos" method="POST" style="padding: 20px;">
            @csrf
            <input type="hidden" id="record_id" name="record_id">
            <input type="hidden" id="_method" name="_method">
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Folio *</label>
                    <input type="text" id="folio" name="folio" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="FOL-001">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Ejecutó *</label>
                    <input type="date" id="fecha_ejecuto" name="fecha_ejecuto" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicial *</label>
                    <input type="date" id="fecha_inicial" name="fecha_inicial" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Final *</label>
                    <input type="date" id="fecha_final" name="fecha_final" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad Registros *</label>
                    <input type="number" id="cantidad_registros" name="cantidad_registros" required min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="25">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Monto *</label>
                    <input type="number" step="0.01" id="monto" name="monto" required min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="45678.50">
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus *</label>
                    <select id="estatus" name="estatus" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="cerrarModalTablaSueldos()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DE DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100001; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 80vh; overflow-y: auto; position: relative;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Detalle de Registro</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;">
            <!-- Aquí se carga el detalle vía JS -->
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        min-width: 1000px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        vertical-align: middle;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
    }
    
    .table td:last-child {
        background-color: white !important;
        text-align: center !important;
    }
    
    tbody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }
    
    tbody tr:hover td:last-child {
        background-color: #e8f0fe !important;
    }
    
    .table td:last-child i {
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-cancelado {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-finalizado {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    [draggable="true"] {
        cursor: grab;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background-color: #e8f0fe;
        border-radius: 4px;
        color: var(--color-primary);
        font-size: 11px;
        border: 1px solid var(--color-primary);
    }
    
    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: var(--color-primary);
    }
    
    #modalTablaSueldos, #modalDetalle {
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Paginación */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        color: var(--color-primary);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .pagination .page-link:hover {
        background-color: var(--color-primary);
        color: white;
    }
    
    .pagination .active .page-link {
        background-color: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }
    
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        .table-container {
            max-height: 500px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalTablaSueldos > div,
        #modalDetalle > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
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

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    const grupoAgrupacion = document.getElementById('grupoAgrupacion');
    if (grupoAgrupacion) {
        grupoAgrupacion.addEventListener('dragover', (e) => e.preventDefault());
        grupoAgrupacion.addEventListener('drop', (e) => {
            e.preventDefault();
            const columna = e.dataTransfer.getData('text/plain');
            if (columna && !columnasAgrupadas.includes(columna)) {
                columnasAgrupadas.push(columna);
                actualizarGrupoColumnas();
            }
        });
    }

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'fecha_ejecuto', caption: 'Fecha Ejecutó' },
                { field: 'fecha_inicial', caption: 'Fecha Inicial' },
                { field: 'fecha_final', caption: 'Fecha Final' },
                { field: 'cantidad', caption: 'Cantidad Registros' },
                { field: 'monto', caption: 'Monto' },
                { field: 'estatus', caption: 'Estatus' }
            ];
            
            const lista = document.getElementById('columnasLista');
            if (lista) {
                lista.innerHTML = columnas.map(col => `
                    <div style="padding: 5px 0; display: flex; align-items: center;">
                        <input type="checkbox" 
                               id="chk_${col.field}"
                               data-columna="${col.field}"
                               checked
                               style="margin-right: 8px; accent-color: var(--color-primary);">
                        <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                    </div>
                `).join('');
            }
        }
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            const selector = document.getElementById('columnSelector');
            if (selector) selector.style.display = 'none';
        }
    });

    // Botón Excel
    document.getElementById('btnExcel')?.addEventListener('click', async () => {
        try {
            const searchValue = document.getElementById('buscador')?.value || '';
            const response = await fetch('{{ route("rh.nomina.sueldos.export") }}?search=' + encodeURIComponent(searchValue));
            const data = await response.json();
            if (data.success) {
                alert('Exportación preparada. Próximamente disponible.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al exportar');
        }
    });

    // Botón Crear Filtro
    document.getElementById('btnCrearFiltro')?.addEventListener('click', () => {
        alert('Funcionalidad de filtro en desarrollo');
    });

    // Buscador
    const buscador = document.getElementById('buscador');
    let timeoutId;
    buscador?.addEventListener('input', function(e) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            const termino = e.target.value;
            const url = new URL(window.location.href);
            if (termino) {
                url.searchParams.set('search', termino);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        }, 500);
    });

    // Formulario de guardar/actualizar
    const form = document.getElementById('formTablaSueldos');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const recordId = document.getElementById('record_id').value;
            const isEdit = recordId && recordId !== '';
            
            let url;
            let method;
            
            if (isEdit) {
                url = `{{ route("rh.nomina.sueldos.update", "") }}/${recordId}`;
                method = 'POST';
                formData.append('_method', 'PUT');
            } else {
                url = '{{ route("rh.nomina.sueldos.store") }}';
                method = 'POST';
            }
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    cerrarModalTablaSueldos();
                    location.reload();
                } else {
                    alert(data.message || 'Error al guardar');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al guardar el registro');
            }
        });
    }
});

// Funciones globales
function abrirModalTablaSueldos(recordId = null) {
    const modal = document.getElementById('modalTablaSueldos');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('formTablaSueldos');
    
    if (form) form.reset();
    document.getElementById('record_id').value = '';
    document.getElementById('_method')?.remove();
    title.textContent = 'Nueva Tabla de Sueldos';
    
    if (recordId) {
        title.textContent = 'Editar Tabla de Sueldos';
        cargarRegistro(recordId);
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalTablaSueldos() {
    document.getElementById('modalTablaSueldos').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

async function cargarRegistro(id) {
    try {
        const response = await fetch(`{{ route("rh.nomina.sueldos.show", "") }}/${id}`);
        const data = await response.json();
        
        if (data.success) {
            const record = data.data;
            document.getElementById('record_id').value = record.id;
            document.getElementById('folio').value = record.folio;
            document.getElementById('fecha_ejecuto').value = record.fecha_ejecuto.split(' ')[0];
            document.getElementById('fecha_inicial').value = record.fecha_inicial.split(' ')[0];
            document.getElementById('fecha_final').value = record.fecha_final.split(' ')[0];
            document.getElementById('cantidad_registros').value = record.cantidad_registros;
            document.getElementById('monto').value = record.monto;
            document.getElementById('estatus').value = record.estatus;
            document.getElementById('observaciones').value = record.observaciones || '';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar el registro');
    }
}

async function verDetalle(id) {
    try {
        const response = await fetch(`{{ route("rh.nomina.sueldos.show", "") }}/${id}`);
        const data = await response.json();
        
        if (data.success) {
            const record = data.data;
            const contenido = `
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Folio:</strong>
                    <p>${record.folio}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Fecha Ejecutó:</strong>
                    <p>${new Date(record.fecha_ejecuto).toLocaleDateString()}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Período:</strong>
                    <p>${new Date(record.fecha_inicial).toLocaleDateString()} - ${new Date(record.fecha_final).toLocaleDateString()}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Cantidad Registros:</strong>
                    <p>${new Intl.NumberFormat().format(record.cantidad_registros)}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Monto:</strong>
                    <p>${new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(record.monto)}</p>
                </div>
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Estatus:</strong>
                    <p><span class="badge-${record.estatus.toLowerCase()}">${record.estatus}</span></p>
                </div>
                ${record.observaciones ? `
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Observaciones:</strong>
                    <p>${record.observaciones}</p>
                </div>
                ` : ''}
                <div style="margin-bottom: 15px;">
                    <strong style="color: var(--color-primary);">Creado:</strong>
                    <p>${new Date(record.created_at).toLocaleString()}</p>
                </div>
            `;
            
            document.getElementById('detalleContenido').innerHTML = contenido;
            document.getElementById('modalDetalle').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar el detalle');
    }
}

function editarRegistro(id) {
    abrirModalTablaSueldos(id);
}

async function eliminarRegistro(id, folio) {
    if (confirm(`¿Está seguro de eliminar el registro "${folio}"?`)) {
        try {
            const response = await fetch(`{{ route("rh.nomina.sueldos.destroy", "") }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message || 'Error al eliminar');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar el registro');
        }
    }
}

function generarPDF(id) {
    alert(`Funcionalidad de PDF en desarrollo para el registro ${id}`);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalTablaSueldos();
        cerrarModalDetalle();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalTablaSueldos')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalTablaSueldos();
    }
});

document.getElementById('modalDetalle')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalDetalle();
    }
});
</script>
@endsection