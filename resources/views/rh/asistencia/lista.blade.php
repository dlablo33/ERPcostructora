@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Lista de Asistencia -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Lista de Asistencia por Día
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel"></i>
                                
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns"></i>
                                
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por fecha..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;">Resumen</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @if(isset($listas) && $listas->count() > 0)
                                @foreach($listas as $lista)
                                @php
                                    $fecha = $lista->fecha;
                                    $total = $lista->total_empleados;
                                    $presentes = $lista->presentes;
                                    $retardos = $lista->retardos;
                                    $ausentes = $lista->ausentes;
                                    $fechaFormateada = \Carbon\Carbon::parse($fecha)->format('d/m/Y');
                                    $nombreDia = \Carbon\Carbon::parse($fecha)->translatedFormat('l');
                                @endphp
                                <tr>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <strong>{{ $fechaFormateada }}</strong><br>
                                        <small style="color: #6c757d;">{{ $nombreDia }}</small>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: center;">
                                            <span style="background-color: #e9ecef; padding: 2px 8px; border-radius: 3px;">Total: {{ $total }}</span>
                                            <span style="background-color: #d4edda; color: #155724; padding: 2px 8px; border-radius: 3px;">Presentes: {{ $presentes }}</span>
                                            <span style="background-color: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 3px;">Retardos: {{ $retardos }}</span>
                                            <span style="background-color: #f8d7da; color: #721c24; padding: 2px 8px; border-radius: 3px;">Ausentes: {{ $ausentes }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalleDia('{{ $fecha }}')" title="Ver detalle"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDFDia('{{ $fecha }}')" title="Generar PDF"></i>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 40px;">No hay registros de asistencia</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="2" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;" id="totalRegistros">
                                    Total Días: {{ isset($listas) ? $listas->count() : 0 }}
                                </td>
                                <td style="padding: 10px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA VER DETALLE DEL DÍA -->
<div id="modalDetalleDia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1000px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;" id="modalDetalleTitulo">Detalle de Asistencia</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div id="detalleAsistenciaContent"></div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
                <button id="btnExportarDetalle" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-file-excel"></i> Exportar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
    }

    .table td:last-child i {
        margin: 0 5px;
        cursor: pointer;
        font-size: 14px;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-file-pdf {
        color: #dc3545;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
    }
    
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
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
        margin-right: 5px;
    }
    
    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-weight: bold;
    }
    
    .tabla-detalle {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .tabla-detalle th {
        background-color: #e9ecef;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        font-weight: 600;
    }
    
    .tabla-detalle td {
        padding: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;
    }
    
    .tabla-detalle tr:hover {
        background-color: #f8f9fa;
    }
    
    .estado-presente {
        color: #28a745;
        font-weight: 600;
    }
    
    .estado-retardo {
        color: #fd7e14;
        font-weight: 600;
    }
    
    .estado-ausente {
        color: #dc3545;
        font-weight: 600;
    }
    
    .estado-justificado {
        color: #17a2b8;
        font-weight: 600;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let listas = @json($listas ?? []);

function formatearFecha(fechaISO) {
    if (!fechaISO) return '';
    const f = new Date(fechaISO);
    return `${f.getDate().toString().padStart(2,'0')}/${(f.getMonth()+1).toString().padStart(2,'0')}/${f.getFullYear()}`;
}

function formatearHora(hora) {
    if (!hora) return '---';
    return hora;
}

async function verDetalleDia(fecha) {
    try {
        const response = await fetch(`/rh/lista/${fecha}`);
        const data = await response.json();
        
        if (data.success) {
            const fechaFormateada = formatearFecha(data.fecha);
            document.getElementById('modalDetalleTitulo').innerHTML = `Detalle de Asistencia - ${fechaFormateada} (Folio: ${data.folio})`;
            
            const content = document.getElementById('detalleAsistenciaContent');
            content.innerHTML = `
                <div style="margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
                    <strong>Resumen:</strong> Total: ${data.resumen.total} | Presentes: ${data.resumen.presentes} | Retardos: ${data.resumen.retardos} | Ausentes: ${data.resumen.ausentes} | Justificados: ${data.resumen.justificados}
                </div>
                <table class="tabla-detalle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Empleado</th>
                            <th>Puesto</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.detalles.map((d, idx) => `
                            <tr>
                                <td>${idx + 1}</td>
                                <td><strong>${d.empleado_nombre}</strong></td>
                                <td>${d.puesto || 'N/A'}</td>
                                <td>${formatearHora(d.hora_entrada)}</td>
                                <td>${formatearHora(d.hora_salida)}</td>
                                <td class="estado-${d.estado}">${d.estado.toUpperCase()}</td>
                                <td>${d.observaciones || '---'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            
            document.getElementById('modalDetalleDia').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        } else {
            alert('Error: ' + (data.message || 'No se pudo cargar el detalle'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar el detalle');
    }
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalleDia').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function generarPDFDia(fecha) {
    const fechaFormateada = formatearFecha(fecha);
    alert(`Generando reporte PDF para el día ${fechaFormateada}`);
}

// Buscador
document.getElementById('buscador')?.addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#tablaBody tr');
    let count = 0;
    rows.forEach(row => {
        if (row.cells && row.cells[0]) {
            const text = row.cells[0].innerText.toLowerCase();
            if (text.includes(term)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        }
    });
    document.getElementById('totalRegistros').innerHTML = `Total Días: ${count}`;
});

// Drag & drop y columnas
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
    
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        if (selector.style.display === 'block') {
            const columnas = ['fecha', 'resumen'];
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" id="chk_${col}" data-columna="${col}" checked style="margin-right: 8px;">
                    <label style="font-size: 12px;">${col.toUpperCase()}</label>
                </div>
            `).join('');
        }
    };
    
    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });
    
    document.getElementById('btnExcel')?.addEventListener('click', () => alert('Exportar a Excel'));
    document.getElementById('btnCrearFiltro')?.addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExportarDetalle')?.addEventListener('click', () => alert('Exportar detalle a Excel'));
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalDetalle();
    }
});

document.getElementById('modalDetalleDia')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalDetalle();
});
</script>
@endsection