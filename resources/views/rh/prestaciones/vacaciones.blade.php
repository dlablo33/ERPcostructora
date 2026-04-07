@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Registro de Vacaciones
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
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar registro de vacaciones"
                                    onclick="abrirModalVacaciones()">
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

                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, folio..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Vacaciones DINÁMICA -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaVacaciones" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_inicio">Fecha Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_fin">Fecha Fin</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias">Días</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaVacacionesBody">
                            @forelse($vacaciones as $vacacion)
                            <tr data-id="{{ $vacacion->id }}">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $vacacion->folio }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $vacacion->nombre_empleado }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $vacacion->fecha_inicio->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $vacacion->fecha_fin->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">{{ $vacacion->dias }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @php
                                        $badgeClass = match($vacacion->estatus) {
                                            'Programado' => 'badge-programado',
                                            'En curso' => 'badge-curso',
                                            'Finalizado' => 'badge-finalizado',
                                            'Cancelado' => 'badge-cancelado',
                                            default => 'badge-programado'
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $vacacion->estatus }}</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verVacacion({{ $vacacion->id }})"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarVacacion({{ $vacacion->id }})"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarVacacion({{ $vacacion->id }})"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $vacacion->id }})"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay registros de vacaciones</p>
                                    <button onclick="abrirModalVacaciones()" style="margin-top: 10px; padding: 8px 20px; background-color: var(--color-primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Registrar primeras vacaciones
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total Registros:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;" id="totalRegistros">{{ $vacaciones->count() }}</td>
                            </tr>
                        </tfoot>
                    </table>
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

<!-- MODAL PARA NUEVO/EDITAR VACACIONES -->
<div id="modalVacaciones" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTitulo">Nuevo Registro de Vacaciones</h3>
            <button onclick="cerrarModalVacaciones()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <form id="formVacaciones" onsubmit="return false;">
            <div style="padding: 20px;">
                <input type="hidden" id="vacacion_id" name="id">
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado *</label>
                        <select id="plantilla_id" name="plantilla_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Seleccionar empleado</option>
                            @foreach($empleados as $empleado)
                            <option value="{{ $empleado->plantilla_id }}">
                                {{ $empleado->nombre_completo }} - {{ $empleado->puesto_nombre ?? 'Sin puesto' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicio *</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="calcularDias()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Fin *</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="calcularDias()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días *</label>
                        <input type="number" id="dias" name="dias" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0" readonly>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus *</label>
                        <select id="estatus" name="estatus" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Programado">Programado</option>
                            <option value="En curso">En curso</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalVacaciones()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" onclick="guardarVacacion()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
    }
    
    .badge-programado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-curso { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-finalizado { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-cancelado { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; font-size: 12px; white-space: nowrap; text-align: center; font-weight: 600; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; font-size: 12px; vertical-align: middle; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    
    .table th:last-child, .table td:last-child { position: sticky !important; right: 0 !important; z-index: 35 !important; box-shadow: -2px 0 5px rgba(0,0,0,0.1) !important; }
    .table td:last-child i { margin: 0 5px; font-size: 14px; cursor: pointer; transition: transform 0.2s; }
    .table td:last-child i:hover { transform: scale(1.2); }
    .table td:last-child i.fa-edit, .table td:last-child i.fa-eye { color: var(--color-primary); }
    .table td:last-child i.fa-trash, .table td:last-child i.fa-file-pdf { color: #dc3545; }
    
    [draggable="true"] { cursor: grab; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-size: 12px; font-weight: bold; color: var(--color-primary); }
    
    #modalVacaciones { display: none; align-items: center; justify-content: center; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-50px); } to { opacity: 1; transform: translateY(0); } }
    
    @media (max-width: 768px) { .hide-mobile { display: none !important; } .table-container { max-height: 500px; } .table td { padding: 8px 4px; font-size: 11px; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
let columnasAgrupadas = [];

function calcularDias() {
    const inicio = document.getElementById('fecha_inicio').value;
    const fin = document.getElementById('fecha_fin').value;
    
    if (inicio && fin) {
        const fechaInicio = new Date(inicio);
        const fechaFin = new Date(fin);
        const diffTime = Math.abs(fechaFin - fechaInicio);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        document.getElementById('dias').value = diffDays;
    }
}

function abrirModalVacaciones(id = null) {
    const modal = document.getElementById('modalVacaciones');
    const titulo = document.getElementById('modalTitulo');
    
    if (id) {
        titulo.textContent = 'Editar Registro de Vacaciones';
        cargarVacacion(id);
    } else {
        titulo.textContent = 'Nuevo Registro de Vacaciones';
        document.getElementById('formVacaciones').reset();
        document.getElementById('vacacion_id').value = '';
        document.getElementById('dias').value = '';
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalVacaciones() {
    document.getElementById('modalVacaciones').style.display = 'none';
    document.body.style.overflow = 'auto';
}

async function guardarVacacion() {
    const id = document.getElementById('vacacion_id').value;
    const url = id ? `/rh/vacaciones/${id}` : '/rh/vacaciones';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        plantilla_id: document.getElementById('plantilla_id').value,
        fecha_inicio: document.getElementById('fecha_inicio').value,
        fecha_fin: document.getElementById('fecha_fin').value,
        dias: document.getElementById('dias').value,
        estatus: document.getElementById('estatus').value,
        observaciones: document.getElementById('observaciones').value
    };
    
    if (!formData.plantilla_id) {
        alert('Por favor seleccione un empleado');
        return;
    }
    
    if (!formData.fecha_inicio || !formData.fecha_fin) {
        alert('Por favor seleccione las fechas');
        return;
    }
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(data.message);
            cerrarModalVacaciones();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el registro');
    }
}

async function cargarVacacion(id) {
    try {
        const response = await fetch(`/rh/vacaciones/${id}`);
        const vacacion = await response.json();
        
        document.getElementById('vacacion_id').value = vacacion.id;
        document.getElementById('plantilla_id').value = vacacion.plantilla_id;
        document.getElementById('fecha_inicio').value = vacacion.fecha_inicio.split('T')[0];
        document.getElementById('fecha_fin').value = vacacion.fecha_fin.split('T')[0];
        document.getElementById('dias').value = vacacion.dias;
        document.getElementById('estatus').value = vacacion.estatus;
        document.getElementById('observaciones').value = vacacion.observaciones || '';
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los datos');
    }
}

function verVacacion(id) {
    window.open(`/rh/vacaciones/${id}`, '_blank');
}

function editarVacacion(id) {
    abrirModalVacaciones(id);
}

async function eliminarVacacion(id) {
    if (!confirm('¿Está seguro de eliminar este registro de vacaciones?')) return;
    
    try {
        const response = await fetch(`/rh/vacaciones/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al eliminar el registro');
    }
}

function generarPDF(id) {
    window.open(`/rh/vacaciones/${id}/pdf`, '_blank');
}

// Búsqueda en tiempo real
document.getElementById('buscador')?.addEventListener('input', function(e) {
    const termino = e.target.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaVacacionesBody tr');
    
    filas.forEach(fila => {
        if (fila.querySelector('td')) {
            const texto = fila.innerText.toLowerCase();
            fila.style.display = texto.includes(termino) ? '' : 'none';
        }
    });
});

// Botón Excel
document.getElementById('btnExcel')?.addEventListener('click', async () => {
    try {
        const response = await fetch('/rh/vacaciones/export/excel');
        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `vacaciones_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al exportar');
    }
});

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') cerrarModalVacaciones(); });
document.getElementById('modalVacaciones')?.addEventListener('click', function(e) { if (e.target === this) cerrarModalVacaciones(); });
</script>
@endsection