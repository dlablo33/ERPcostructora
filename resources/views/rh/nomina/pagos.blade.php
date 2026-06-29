@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Pagos de Nómina
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar pago de nómina"
                                    onclick="abrirModalPagoNomina()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por folio, observaciones..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Pagos de Nómina -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaPagosNomina" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_pago">Fecha Pago</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodo_inicio">Fecha Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodo_fin">Fecha Fin</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado_nombre">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nominas ?? [] as $nomina)
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $nomina->folio }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $nomina->fecha_pago ? $nomina->fecha_pago->format('d/m/Y') : '-' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $nomina->periodo_inicio ? $nomina->periodo_inicio->format('d/m/Y') : '-' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $nomina->periodo_fin ? $nomina->periodo_fin->format('d/m/Y') : '-' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">
                                    {{ $nomina->empleado_nombre ?? 'Sin nombre' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @php
                                        $estatusColors = [
                                            'Pagada' => '#28a745',
                                            'Pendiente' => '#ffc107',
                                            'Cancelada' => '#dc3545',
                                            'Calculada' => '#17a2b8',
                                        ];
                                        $color = $estatusColors[$nomina->estatus] ?? '#6c757d';
                                    @endphp
                                    <span style="background-color: {{ $color }}; color: {{ $nomina->estatus === 'Pendiente' ? '#212529' : 'white' }}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center;">
                                        {{ $nomina->estatus ?? 'Pendiente' }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $nomina->id }})"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarNomina({{ $nomina->id }})"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarNomina({{ $nomina->id }})"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $nomina->id }})"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding: 30px; text-align: center; color: #6c757d;">
                                    <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                                    No hay pagos de nómina registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">
                                    Total Pagos: {{ $nominas->total() ?? 0 }}
                                    @if(isset($estadisticas))
                                    | Total Pagado: ${{ number_format($estadisticas['monto_pagado'] ?? 0, 2) }}
                                    | Total General: ${{ number_format($estadisticas['total_monto'] ?? 0, 2) }}
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(isset($nominas) && method_exists($nominas, 'links'))
                <div style="margin-top: 15px; display: flex; justify-content: center;">
                    {{ $nominas->links() }}
                </div>
                @endif

                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA NUEVO PAGO DE NÓMINA -->
<div id="modalPagoNomina" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Nuevo Pago de Nómina</h3>
            <button onclick="cerrarModalPagoNomina()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <form id="formPagoNomina" style="padding: 20px;">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado *</label>
                    <select id="empleado_id" name="empleado_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="">Seleccione un empleado</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Período *</label>
                    <select id="periodo_tipo" name="periodo_tipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="Semanal">Semanal</option>
                        <option value="Quincenal" selected>Quincenal</option>
                        <option value="Mensual">Mensual</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días Trabajados *</label>
                    <input type="number" id="dias_trabajados" name="dias_trabajados" value="15" min="1" max="31" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicio *</label>
                    <input type="date" id="periodo_inicio" name="periodo_inicio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Fin *</label>
                    <input type="date" id="periodo_fin" name="periodo_fin" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Sueldo Diario *</label>
                    <input type="number" id="sueldo_diario" name="sueldo_diario" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Neto a Pagar</label>
                    <input type="number" id="neto_pagar" name="neto_pagar" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus *</label>
                    <select id="estatus" name="estatus" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagada">Pagada</option>
                        <option value="Calculada">Calculada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Pago</label>
                    <input type="date" id="fecha_pago" name="fecha_pago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones del pago..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="cerrarModalPagoNomina()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    /* Estilos generales */
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }
    
    /* Tabla */
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
        min-width: 900px;
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
    
    /* Filas alternadas */
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    /* Columna de acciones fija */
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
    
    /* Iconos de acción */
    .table td:last-child i {
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    /* Drag & drop */
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
    
    /* Modal */
    #modalPagoNomina {
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
    
    /* Responsive */
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
        
        #modalPagoNomina > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalPagoNomina div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Actualizar grupo de columnas
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

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());
    
    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        if (selector.style.display === 'block') {
            cargarColumnas();
        }
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    function cargarColumnas() {
        const columnas = [
            { field: 'folio', caption: 'Folio' },
            { field: 'fecha_pago', caption: 'Fecha Pago' },
            { field: 'periodo_inicio', caption: 'Fecha Inicio' },
            { field: 'periodo_fin', caption: 'Fecha Fin' },
            { field: 'empleado_nombre', caption: 'Empleado' },
            { field: 'estatus', caption: 'Estatus' }
        ];
        const lista = document.getElementById('columnasLista');
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

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => {
        alert('Funcionalidad de filtro en desarrollo');
    });

    document.getElementById('btnExcel').addEventListener('click', function() {
        window.location.href = "#";
    });

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.trim();
        if (termino.length > 2 || termino.length === 0) {
            const url = new URL(window.location.href);
            if (termino) {
                url.searchParams.set('buscar', termino);
            } else {
                url.searchParams.delete('buscar');
            }
            window.location.href = url.toString();
        }
    });
});

// ===== FUNCIONES DE ACCIONES =====
function verDetalle(id) {
    window.location.href = "#" + id;
}

function editarNomina(id) {
    alert('Editar nómina ID: ' + id);
    // Aquí se implementaría la edición
}

function eliminarNomina(id) {
    if (!confirm('¿Estás seguro de eliminar este pago de nómina?')) return;
    
    fetch("#" + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al eliminar: ' + error.message);
    });
}

function generarPDF(id) {
    fetch("#" + id, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            if (data.data && data.data.url_download) {
                window.open(data.data.url_download, '_blank');
            }
        } else {
            alert('❌ Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al generar PDF: ' + error.message);
    });
}

// ===== FUNCIONES DEL MODAL =====
function abrirModalPagoNomina() {
    document.getElementById('modalPagoNomina').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    cargarEmpleados();
    establecerFechas();
}

function cerrarModalPagoNomina() {
    document.getElementById('modalPagoNomina').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('formPagoNomina').reset();
}

function cargarEmpleados() {
    fetch("#", {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('empleado_id');
            if (select) {
                select.innerHTML = '<option value="">Seleccione un empleado</option>' +
                    data.data.map(emp => 
                        `<option value="${emp.plantilla_id}">
                            ${emp.nombre_completo} - ${emp.rfc || ''} - ${emp.puesto || 'Sin puesto'}
                        </option>`
                    ).join('');
            }
        } else {
            console.error('Error cargando empleados:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function establecerFechas() {
    const hoy = new Date();
    const inicio = new Date(hoy);
    inicio.setDate(1);
    const fin = new Date(hoy);
    fin.setDate(15);
    
    document.getElementById('periodo_inicio').value = inicio.toISOString().split('T')[0];
    document.getElementById('periodo_fin').value = fin.toISOString().split('T')[0];
    document.getElementById('fecha_pago').value = hoy.toISOString().split('T')[0];
}

// Cargar sueldo al seleccionar empleado
document.getElementById('empleado_id').addEventListener('change', function() {
    const empleadoId = this.value;
    if (empleadoId) {
        // Buscar el empleado en la lista cargada
        fetch("#", {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const empleado = data.data.find(e => e.plantilla_id == empleadoId);
                if (empleado && empleado.sueldo_diario) {
                    document.getElementById('sueldo_diario').value = empleado.sueldo_diario;
                    calcularNeto();
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

// Calcular neto automáticamente
function calcularNeto() {
    const sueldoDiario = parseFloat(document.getElementById('sueldo_diario').value) || 0;
    const dias = parseInt(document.getElementById('dias_trabajados').value) || 0;
    const neto = sueldoDiario * dias;
    document.getElementById('neto_pagar').value = neto.toFixed(2);
}

document.getElementById('sueldo_diario').addEventListener('input', calcularNeto);
document.getElementById('dias_trabajados').addEventListener('input', calcularNeto);

// Enviar formulario
document.getElementById('formPagoNomina').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    fetch("#", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            cerrarModalPagoNomina();
            location.reload();
        } else {
            alert('❌ Error: ' + (data.message || 'Error al guardar'));
            if (data.errors) {
                console.error('Errores de validación:', data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al guardar: ' + error.message);
    });
});

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalPagoNomina();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalPagoNomina').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalPagoNomina();
    }
});
</script>
@endsection