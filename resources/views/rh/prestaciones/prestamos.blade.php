@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Préstamos y Descuentos
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
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar préstamo"
                                    onclick="abrirModalPrestamo()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
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
                            <input type="text" id="buscador" placeholder="Buscar..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Préstamos DINÁMICA -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaPrestamos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_inicio">Fecha de Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="operador">Operador</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="motivo">Motivo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto">Monto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto_descuento">Monto Descuento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="frecuencia">Frecuencia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="monto_restante">Monto Restante</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="gasto">Gasto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPrestamosBody">
                            @forelse($prestamos as $prestamo)
                            <tr data-id="{{ $prestamo->id }}">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @php
                                        $badgeClass = match($prestamo->estatus) {
                                            'Activo' => 'badge-activo',
                                            'Pendiente' => 'badge-pendiente',
                                            'Finalizado' => 'badge-finalizado',
                                            'Cancelado' => 'badge-cancelado',
                                            default => 'badge-activo'
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $prestamo->estatus }}</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $prestamo->folio }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $prestamo->fecha_inicio->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $prestamo->nombre_empleado }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $prestamo->motivo }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($prestamo->monto, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($prestamo->monto_descuento, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $prestamo->numero_pagos }} pagos</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($prestamo->monto_restante, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $prestamo->observaciones ?? '-' }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $prestamo->gasto ?? '-' }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verPrestamo({{ $prestamo->id }})"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarPrestamo({{ $prestamo->id }})"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarPrestamo({{ $prestamo->id }})"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $prestamo->id }})"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay préstamos registrados</p>
                                    <button onclick="abrirModalPrestamo()" style="margin-top: 10px; padding: 8px 20px; background-color: var(--color-primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Registrar primer préstamo
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="12" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">
                                    Cantidad: {{ $prestamos->count() }}
                                </td>
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

<!-- MODAL PARA NUEVO/EDITAR PRÉSTAMO -->
<div id="modalPrestamo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTitulo">Nuevo Préstamo</h3>
            <button onclick="cerrarModalPrestamo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <form id="formPrestamo" onsubmit="return false;">
            <div style="padding: 20px;">
                <input type="hidden" id="prestamo_id" name="id">
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus *</label>
                        <select id="estatus" name="estatus" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Activo">Activo</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Inicio *</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado*</label>
                        <select id="plantilla_id" name="plantilla_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Seleccionar Empleado</option>
                            @foreach($empleados as $empleado)
                            <option value="{{ $empleado->plantilla_id }}">
                                {{ $empleado->nombre_completo }} - {{ $empleado->puesto_nombre ?? 'Sin puesto' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motivo *</label>
                        <input type="text" id="motivo" name="motivo" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Motivo del préstamo">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Monto *</label>
                        <input type="number" id="monto" name="monto" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onchange="calcularMontoRestante()" onkeyup="calcularMontoRestante()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Monto Descuento *</label>
                        <input type="number" id="monto_descuento" name="monto_descuento" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onchange="calcularMontoRestante()" onkeyup="calcularMontoRestante()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Número de Pagos *</label>
                        <input type="number" id="numero_pagos" name="numero_pagos" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="10" onchange="calcularMontoRestante()" onkeyup="calcularMontoRestante()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Frecuencia *</label>
                        <select id="frecuencia" name="frecuencia" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Semanal">Semanal</option>
                            <option value="Quincenal">Quincenal</option>
                            <option value="Mensual">Mensual</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Monto Restante *</label>
                        <input type="number" id="monto_restante" name="monto_restante" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" readonly>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Gasto (Anticipo)</label>
                        <input type="text" id="gasto" name="gasto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="ANT-001">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalPrestamo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" onclick="guardarPrestamo()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
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

    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
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
        min-width: 1400px;
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
        min-width: 60px;
        text-align: center;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    
    .badge-finalizado {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
        text-align: center;
    }
    
    .badge-cancelado {
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 60px;
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
    
    #modalPrestamo {
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
        
        #modalPrestamo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalPrestamo div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Configuración CSRF para Laravel
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

// Variables globales
let columnasAgrupadas = [];

// ============================================
// FUNCIONES DEL MODAL
// ============================================

function abrirModalPrestamo(id = null) {
    const modal = document.getElementById('modalPrestamo');
    const titulo = document.getElementById('modalTitulo');
    
    if (id) {
        titulo.textContent = 'Editar Préstamo';
        cargarPrestamo(id);
    } else {
        titulo.textContent = 'Nuevo Préstamo';
        document.getElementById('formPrestamo').reset();
        document.getElementById('prestamo_id').value = '';
        document.getElementById('fecha_inicio').value = new Date().toISOString().split('T')[0];
        calcularMontoRestante();
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalPrestamo() {
    document.getElementById('modalPrestamo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function calcularMontoRestante() {
    const monto = parseFloat(document.getElementById('monto').value) || 0;
    const montoDescuento = parseFloat(document.getElementById('monto_descuento').value) || 0;
    const numeroPagos = parseInt(document.getElementById('numero_pagos').value) || 1;
    
    // El monto restante es el monto total menos lo que ya se ha descontado
    // En un nuevo préstamo, aún no se han realizado descuentos
    const montoRestante = monto;
    document.getElementById('monto_restante').value = montoRestante.toFixed(2);
}

// ============================================
// FUNCIONES CRUD
// ============================================

async function guardarPrestamo() {
    const id = document.getElementById('prestamo_id').value;
    // CORREGIDO: Usar la ruta correcta con el prefijo rh
    const url = id ? `/rh/prestamos/${id}` : '/rh/prestamos';
    const method = id ? 'PUT' : 'POST';
    
    const formData = {
        estatus: document.getElementById('estatus').value,
        fecha_inicio: document.getElementById('fecha_inicio').value,
        plantilla_id: document.getElementById('plantilla_id').value,
        motivo: document.getElementById('motivo').value,
        monto: document.getElementById('monto').value,
        monto_descuento: document.getElementById('monto_descuento').value,
        numero_pagos: document.getElementById('numero_pagos').value,
        frecuencia: document.getElementById('frecuencia').value,
        monto_restante: document.getElementById('monto_restante').value,
        gasto: document.getElementById('gasto').value,
        observaciones: document.getElementById('observaciones').value
    };
    
    // Validaciones básicas
    if (!formData.plantilla_id) {
        alert('Por favor seleccione un operador');
        return;
    }
    
    if (!formData.motivo) {
        alert('Por favor ingrese el motivo del préstamo');
        return;
    }
    
    if (parseFloat(formData.monto) <= 0) {
        alert('El monto debe ser mayor a 0');
        return;
    }
    
    if (parseFloat(formData.monto_descuento) <= 0) {
        alert('El monto de descuento debe ser mayor a 0');
        return;
    }
    
    if (parseInt(formData.numero_pagos) <= 0) {
        alert('El número de pagos debe ser mayor a 0');
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
            cerrarModalPrestamo();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el préstamo');
    }
}

async function cargarPrestamo(id) {
    try {
        // CORREGIDO: Usar la ruta correcta con el prefijo rh
        const response = await fetch(`/rh/prestamos/${id}`);
        const prestamo = await response.json();
        
        document.getElementById('prestamo_id').value = prestamo.id;
        document.getElementById('estatus').value = prestamo.estatus;
        document.getElementById('fecha_inicio').value = prestamo.fecha_inicio.split('T')[0];
        document.getElementById('plantilla_id').value = prestamo.plantilla_id;
        document.getElementById('motivo').value = prestamo.motivo;
        document.getElementById('monto').value = prestamo.monto;
        document.getElementById('monto_descuento').value = prestamo.monto_descuento;
        document.getElementById('numero_pagos').value = prestamo.numero_pagos;
        document.getElementById('frecuencia').value = prestamo.frecuencia;
        document.getElementById('monto_restante').value = prestamo.monto_restante;
        document.getElementById('gasto').value = prestamo.gasto || '';
        document.getElementById('observaciones').value = prestamo.observaciones || '';
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los datos del préstamo');
    }
}

function verPrestamo(id) {
    // Implementar vista de detalle
    window.open(`/rh/prestamos/${id}`, '_blank');
}

function editarPrestamo(id) {
    abrirModalPrestamo(id);
}

async function eliminarPrestamo(id) {
    if (!confirm('¿Está seguro de eliminar este préstamo? Esta acción no se puede deshacer.')) {
        return;
    }
    
    try {
        // CORREGIDO: Usar la ruta correcta con el prefijo rh
        const response = await fetch(`/rh/prestamos/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
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
        alert('Error al eliminar el préstamo');
    }
}

function generarPDF(id) {
    window.open(`/rh/prestamos/${id}/pdf`, '_blank');
}

// ============================================
// FUNCIONES DE INTERFAZ (Filtros, búsqueda, etc.)
// ============================================

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

window.toggleColumnSelector = function() {
    const selector = document.getElementById('columnSelector');
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    
    if (selector.style.display === 'block') {
        const columnas = [
            { field: 'estatus', caption: 'Estatus' },
            { field: 'folio', caption: 'Folio' },
            { field: 'fecha_inicio', caption: 'Fecha de Inicio' },
            { field: 'operador', caption: 'Operador' },
            { field: 'motivo', caption: 'Motivo' },
            { field: 'monto', caption: 'Monto' },
            { field: 'monto_descuento', caption: 'Monto Descuento' },
            { field: 'frecuencia', caption: 'Frecuencia' },
            { field: 'monto_restante', caption: 'Monto Restante' },
            { field: 'observaciones', caption: 'Observaciones' },
            { field: 'gasto', caption: 'Gasto' }
        ];
        
        const lista = document.getElementById('columnasLista');
        lista.innerHTML = columnas.map(col => `
            <div style="padding: 5px 0; display: flex; align-items: center;">
                <input type="checkbox" 
                       id="chk_${col.field}"
                       data-columna="${col.field}"
                       checked
                       style="margin-right: 8px; accent-color: var(--color-primary);"
                       onchange="toggleColumna('${col.field}', this.checked)">
                <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
            </div>
        `).join('');
    }
};

window.cerrarColumnSelector = function() {
    document.getElementById('columnSelector').style.display = 'none';
};

function toggleColumna(columna, visible) {
    const ths = document.querySelectorAll(`th[data-columna="${columna}"]`);
    const tds = document.querySelectorAll(`td[data-columna="${columna}"]`);
    
    ths.forEach(th => th.style.display = visible ? '' : 'none');
    tds.forEach(td => td.style.display = visible ? '' : 'none');
}

// Búsqueda en tiempo real
document.getElementById('buscador')?.addEventListener('input', function(e) {
    const termino = e.target.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaPrestamosBody tr');
    
    filas.forEach(fila => {
        if (fila.querySelector('td')) {
            const texto = fila.innerText.toLowerCase();
            fila.style.display = texto.includes(termino) ? '' : 'none';
        }
    });
});

// Drag & drop para agrupar
document.addEventListener('dragstart', (e) => {
    if (e.target.tagName === 'TH' && e.target.draggable) {
        e.dataTransfer.setData('text/plain', e.target.dataset.columna);
    }
});

document.getElementById('grupoAgrupacion')?.addEventListener('dragover', (e) => e.preventDefault());

document.getElementById('grupoAgrupacion')?.addEventListener('drop', (e) => {
    e.preventDefault();
    const columna = e.dataTransfer.getData('text/plain');
    if (columna && !columnasAgrupadas.includes(columna)) {
        columnasAgrupadas.push(columna);
        actualizarGrupoColumnas();
        console.log('Agrupar por:', columna);
    }
});

// Botón Excel - CORREGIDO
document.getElementById('btnExcel')?.addEventListener('click', async () => {
    try {
        const response = await fetch('/rh/prestamos/export/excel');
        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'prestamos.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        } else {
            const error = await response.json();
            alert('Error al exportar a Excel: ' + (error.message || 'Error desconocido'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al exportar a Excel');
    }
});

// Botón Crear filtro
document.getElementById('btnCrearFiltro')?.addEventListener('click', () => {
    alert('Funcionalidad de filtros avanzados en desarrollo');
});

// Cerrar selector al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
        const selector = document.getElementById('columnSelector');
        if (selector) selector.style.display = 'none';
    }
});

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalPrestamo();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalPrestamo')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalPrestamo();
    }
});

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    actualizarGrupoColumnas();
    calcularMontoRestante();
});
</script>
@endsection