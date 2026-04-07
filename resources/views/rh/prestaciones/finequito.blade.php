@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Finiquitos y Liquidaciones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-signature" style="margin-right: 10px;"></i> Finiquitos y Liquidaciones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Procesos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ $totalProcesos ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Pendientes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">{{ $pendientes ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Autorizados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ $autorizados ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #17a2b8; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Pagados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ $pagados ?? 0 }}</div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" title="Nuevo finiquito/liquidación" onclick="abrirModalFiniquito()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>
                        <div style="position: relative;">
                            <button id="btnColumnas" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);" onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, RFC, folio..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Finiquitos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaFiniquitos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="tipo">Tipo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_baja">Fecha Baja</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias_vacaciones">Días Vac.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="prima_vacacional">Prima Vac.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="aguinaldo">Aguinaldo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="indemnizacion">Indemnización</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Total</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaFiniquitosBody">
                            @forelse($finiquitos as $finiquito)
                            <tr data-id="{{ $finiquito->id }}">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $finiquito->folio }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $finiquito->nombre_empleado }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @if($finiquito->tipo == 'finiquito')
                                    <span class="badge-finiquito">Finiquito</span>
                                    @else
                                    <span class="badge-liquidacion">Liquidación</span>
                                    @endif
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $finiquito->fecha_baja->format('d/m/Y') }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $finiquito->dias_vacaciones }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($finiquito->prima_vacacional, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($finiquito->aguinaldo, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${{ number_format($finiquito->indemnizacion, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">${{ number_format($finiquito->total, 2) }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @php
                                        $badgeClass = match($finiquito->estatus) {
                                            'Pendiente' => 'badge-pendiente',
                                            'Autorizado' => 'badge-autorizado',
                                            'Pagado' => 'badge-pagado',
                                            'Cancelado' => 'badge-cancelado',
                                            default => 'badge-pendiente'
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $finiquito->estatus }}</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $finiquito->id }})" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarFiniquito({{ $finiquito->id }})" title="Editar"></i>
                                    @if($finiquito->estatus == 'Pendiente')
                                    <i class="fas fa-check-circle" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="autorizarFiniquito({{ $finiquito->id }})" title="Autorizar"></i>
                                    @endif
                                    @if($finiquito->estatus == 'Autorizado')
                                    <i class="fas fa-money-bill-wave" style="color: #28a745; margin: 0 5px; cursor: pointer;" onclick="registrarPago({{ $finiquito->id }})" title="Registrar pago"></i>
                                    @endif
                                    <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $finiquito->id }})" title="Generar PDF"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarFiniquito({{ $finiquito->id }})" title="Eliminar"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No hay finiquitos o liquidaciones registrados</p>
                                    <button onclick="abrirModalFiniquito()" style="margin-top: 10px; padding: 8px 20px; background-color: var(--color-primary); color: white; border: none; border-radius: 4px; cursor: pointer;">Registrar primer finiquito</button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="8" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total General:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">${{ number_format($finiquitos->sum('total'), 2) }}</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $finiquitos->count() }} procesos</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
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

<!-- MODAL PARA NUEVO/EDITAR FINIQUITO/LIQUIDACIÓN -->
<div id="modalFiniquito" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTitulo">Nuevo Finiquito / Liquidación</h3>
            <button onclick="cerrarModalFiniquito()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <form id="formFiniquito" onsubmit="return false;">
            <div style="padding: 20px;">
                <input type="hidden" id="finiquito_id" name="id">
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo *</label>
                        <select id="tipo" name="tipo" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="cambiarTipo()">
                            <option value="finiquito">Finiquito</option>
                            <option value="liquidacion">Liquidación</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                        <select id="estatus" name="estatus" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="Pendiente">Pendiente</option>
                            <option value="Autorizado">Autorizado</option>
                            <option value="Pagado">Pagado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado *</label>
                        <select id="plantilla_id" name="plantilla_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="cargarDatosEmpleado()">
                            <option value="">Seleccionar empleado</option>
                            @foreach($empleados as $empleado)
                            <option value="{{ $empleado->plantilla_id }}" 
                                    data-fecha-ingreso="{{ $empleado->fecha_ingreso ? $empleado->fecha_ingreso->format('Y-m-d') : '' }}"
                                    data-sueldo-diario="{{ $empleado->sueldo_diario ?? 0 }}"
                                    data-rfc="{{ $empleado->rfc ?? '' }}">
                                {{ $empleado->nombre_completo }} - {{ $empleado->puesto_nombre ?? 'Sin puesto' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Baja *</label>
                        <input type="date" id="fecha_baja" name="fecha_baja" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="calcularAntiguedad()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Ingreso</label>
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" readonly style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Salario Diario *</label>
                        <input type="number" id="salario_diario" name="salario_diario" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="250.00" onchange="calcularTotal()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Salario Integrado</label>
                        <input type="number" id="salario_integrado" name="salario_integrado" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="275.00" readonly>
                    </div>
                </div>
                
                <h4 style="color: var(--color-primary); margin: 20px 0 15px; font-size: 15px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px;">Conceptos a Liquidar</h4>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Días de Vacaciones</label>
                        <input type="number" id="dias_vacaciones" name="dias_vacaciones" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="12" onchange="calcularTotal()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Prima Vacacional ($)</label>
                        <input type="number" id="prima_vacacional" name="prima_vacacional" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onchange="calcularTotal()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Aguinaldo ($)</label>
                        <input type="number" id="aguinaldo" name="aguinaldo" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onchange="calcularTotal()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Indemnización ($)</label>
                        <input type="number" id="indemnizacion" name="indemnizacion" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00" onchange="calcularTotal()">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Motivo de Baja</label>
                        <input type="text" id="motivo_baja" name="motivo_baja" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Renuncia voluntaria">
                    </div>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 4px; margin-top: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 16px; font-weight: bold;">TOTAL ESTIMADO:</span>
                        <span style="font-size: 24px; font-weight: bold; color: var(--color-primary);" id="totalEstimado">$0.00</span>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalFiniquito()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" onclick="guardarFiniquito()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .badge-finiquito { background-color: #6f42c1; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-liquidacion { background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px; text-align: center; }
    .badge-autorizado { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px; text-align: center; }
    .badge-pagado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px; text-align: center; }
    .badge-cancelado { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 80px; text-align: center; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1400px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table th:last-child, .table td:last-child { position: sticky !important; right: 0 !important; z-index: 35 !important; box-shadow: -2px 0 5px rgba(0,0,0,0.1) !important; }
    .table td:last-child i { margin: 0 5px; cursor: pointer; transition: transform 0.2s; }
    .table td:last-child i:hover { transform: scale(1.2); }
    #modalFiniquito { display: none; align-items: center; justify-content: center; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-50px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 768px) { .hide-mobile { display: none !important; } .table-container { max-height: 500px; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
let columnasAgrupadas = [];

function cambiarTipo() {
    const tipo = document.getElementById('tipo').value;
    console.log('Tipo seleccionado:', tipo);
}

function cargarDatosEmpleado() {
    const select = document.getElementById('plantilla_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.value) {
        const fechaIngreso = selectedOption.getAttribute('data-fecha-ingreso');
        const sueldoDiario = selectedOption.getAttribute('data-sueldo-diario');
        const rfc = selectedOption.getAttribute('data-rfc');
        
        console.log('Datos del empleado:', { fechaIngreso, sueldoDiario, rfc });
        
        // Cargar fecha de ingreso
        if (fechaIngreso && fechaIngreso !== '') {
            document.getElementById('fecha_ingreso').value = fechaIngreso;
        } else {
            document.getElementById('fecha_ingreso').value = '';
        }
        
        // Cargar sueldo diario
        if (sueldoDiario && parseFloat(sueldoDiario) > 0) {
            document.getElementById('salario_diario').value = sueldoDiario;
            const salarioIntegrado = parseFloat(sueldoDiario) * 1.0452;
            document.getElementById('salario_integrado').value = salarioIntegrado.toFixed(2);
        }
        
        calcularAntiguedad();
        calcularTotal();
    }
}

function calcularAntiguedad() {
    const fechaIngreso = document.getElementById('fecha_ingreso').value;
    const fechaBaja = document.getElementById('fecha_baja').value;
    
    if (fechaIngreso && fechaBaja) {
        const ingreso = new Date(fechaIngreso);
        const baja = new Date(fechaBaja);
        
        if (ingreso <= baja) {
            const diffTime = Math.abs(baja - ingreso);
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            const diffYears = diffDays / 365.25;
            
            const years = Math.floor(diffYears);
            const months = Math.floor((diffYears - years) * 12);
            
            let antiguedadTexto = '';
            if (years > 0) antiguedadTexto += `${years} año${years !== 1 ? 's' : ''}`;
            if (months > 0) antiguedadTexto += `${antiguedadTexto ? ' ' : ''}${months} mes${months !== 1 ? 'es' : ''}`;
            if (antiguedadTexto === '') antiguedadTexto = 'Menos de 1 mes';
            
            console.log('Antigüedad calculada:', antiguedadTexto);
            
            // Calcular días de vacaciones según antigüedad (ejemplo)
            let diasVacaciones = 6; // base
            if (years >= 1) diasVacaciones = 8;
            if (years >= 2) diasVacaciones = 10;
            if (years >= 3) diasVacaciones = 12;
            if (years >= 4) diasVacaciones = 14;
            if (years >= 5) diasVacaciones = 16;
            
            document.getElementById('dias_vacaciones').value = diasVacaciones;
            
            // Calcular prima vacacional (25% del salario de los días de vacaciones)
            const salarioDiario = parseFloat(document.getElementById('salario_diario').value) || 0;
            const primaVacacional = (salarioDiario * diasVacaciones) * 0.25;
            document.getElementById('prima_vacacional').value = primaVacacional.toFixed(2);
        }
    }
}

function calcularTotal() {
    const salarioDiario = parseFloat(document.getElementById('salario_diario').value) || 0;
    const diasVacaciones = parseFloat(document.getElementById('dias_vacaciones').value) || 0;
    const primaVacacional = parseFloat(document.getElementById('prima_vacacional').value) || 0;
    const aguinaldo = parseFloat(document.getElementById('aguinaldo').value) || 0;
    const indemnizacion = parseFloat(document.getElementById('indemnizacion').value) || 0;
    
    const vacaciones = salarioDiario * diasVacaciones;
    const total = vacaciones + primaVacacional + aguinaldo + indemnizacion;
    
    document.getElementById('totalEstimado').textContent = '$' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return total;
}

function abrirModalFiniquito(id = null) {
    const modal = document.getElementById('modalFiniquito');
    const titulo = document.getElementById('modalTitulo');
    
    if (id) {
        titulo.textContent = 'Editar Finiquito / Liquidación';
        cargarFiniquito(id);
    } else {
        titulo.textContent = 'Nuevo Finiquito / Liquidación';
        document.getElementById('formFiniquito').reset();
        document.getElementById('finiquito_id').value = '';
        document.getElementById('fecha_baja').value = new Date().toISOString().split('T')[0];
        calcularTotal();
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalFiniquito() {
    document.getElementById('modalFiniquito').style.display = 'none';
    document.body.style.overflow = 'auto';
}

async function guardarFiniquito() {
    const id = document.getElementById('finiquito_id').value;
    const url = id ? `/rh/finiquito/${id}` : '/rh/finiquito';
    const method = id ? 'PUT' : 'POST';
    
    const total = calcularTotal();
    
    const formData = {
        plantilla_id: document.getElementById('plantilla_id').value,
        tipo: document.getElementById('tipo').value,
        fecha_baja: document.getElementById('fecha_baja').value,
        fecha_ingreso: document.getElementById('fecha_ingreso').value,
        salario_diario: document.getElementById('salario_diario').value,
        salario_integrado: document.getElementById('salario_integrado').value,
        dias_vacaciones: document.getElementById('dias_vacaciones').value,
        prima_vacacional: document.getElementById('prima_vacacional').value,
        aguinaldo: document.getElementById('aguinaldo').value,
        indemnizacion: document.getElementById('indemnizacion').value,
        total: total,
        estatus: document.getElementById('estatus').value,
        observaciones: document.getElementById('observaciones').value,
        motivo_baja: document.getElementById('motivo_baja').value
    };
    
    if (!formData.plantilla_id) {
        alert('Por favor seleccione un empleado');
        return;
    }
    
    if (!formData.fecha_baja) {
        alert('Por favor seleccione la fecha de baja');
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
            cerrarModalFiniquito();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar el registro');
    }
}

async function cargarFiniquito(id) {
    try {
        const response = await fetch(`/rh/finiquito/${id}`);
        const finiquito = await response.json();
        
        document.getElementById('finiquito_id').value = finiquito.id;
        document.getElementById('plantilla_id').value = finiquito.plantilla_id;
        document.getElementById('tipo').value = finiquito.tipo;
        document.getElementById('fecha_baja').value = finiquito.fecha_baja.split('T')[0];
        document.getElementById('fecha_ingreso').value = finiquito.fecha_ingreso ? finiquito.fecha_ingreso.split('T')[0] : '';
        document.getElementById('salario_diario').value = finiquito.salario_diario;
        document.getElementById('salario_integrado').value = finiquito.salario_integrado;
        document.getElementById('dias_vacaciones').value = finiquito.dias_vacaciones;
        document.getElementById('prima_vacacional').value = finiquito.prima_vacacional;
        document.getElementById('aguinaldo').value = finiquito.aguinaldo;
        document.getElementById('indemnizacion').value = finiquito.indemnizacion;
        document.getElementById('estatus').value = finiquito.estatus;
        document.getElementById('observaciones').value = finiquito.observaciones || '';
        document.getElementById('motivo_baja').value = finiquito.motivo_baja || '';
        
        calcularTotal();
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los datos');
    }
}

async function autorizarFiniquito(id) {
    if (!confirm('¿Autorizar este finiquito/liquidación?')) return;
    
    try {
        const response = await fetch(`/rh/finiquito/${id}/autorizar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
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
        alert('Error al autorizar');
    }
}

function registrarPago(id) {
    const fechaPago = prompt('Ingrese la fecha de pago (YYYY-MM-DD):', new Date().toISOString().split('T')[0]);
    if (fechaPago) {
        confirmarPago(id, fechaPago);
    }
}

async function confirmarPago(id, fechaPago) {
    try {
        const response = await fetch(`/rh/finiquito/${id}/pago`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ fecha_pago: fechaPago })
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
        alert('Error al registrar pago');
    }
}

function editarFiniquito(id) {
    abrirModalFiniquito(id);
}

async function eliminarFiniquito(id) {
    if (!confirm('¿Está seguro de eliminar este finiquito/liquidación?')) return;
    
    try {
        const response = await fetch(`/rh/finiquito/${id}`, {
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
        alert('Error al eliminar');
    }
}

function verDetalle(id) {
    window.open(`/rh/finiquito/${id}`, '_blank');
}

function generarPDF(id) {
    window.open(`/rh/finiquito/${id}/pdf`, '_blank');
}

// Búsqueda en tiempo real
document.getElementById('buscador')?.addEventListener('input', function(e) {
    const termino = e.target.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaFiniquitosBody tr');
    
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
        const response = await fetch('/rh/finiquito/export/excel');
        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `finiquitos_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al exportar');
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalFiniquito();
    }
});

document.getElementById('modalFiniquito')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalFiniquito();
});

// Drag & drop para agrupar columnas
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
    }
});

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
            { field: 'folio', caption: 'Folio' }, { field: 'empleado', caption: 'Empleado' },
            { field: 'tipo', caption: 'Tipo' }, { field: 'fecha_baja', caption: 'Fecha Baja' },
            { field: 'dias_vacaciones', caption: 'Días Vac.' }, { field: 'prima_vacacional', caption: 'Prima Vac.' },
            { field: 'aguinaldo', caption: 'Aguinaldo' }, { field: 'indemnizacion', caption: 'Indemnización' },
            { field: 'total', caption: 'Total' }, { field: 'estatus', caption: 'Estatus' }
        ];
        const lista = document.getElementById('columnasLista');
        lista.innerHTML = columnas.map(col => `
            <div style="padding: 5px 0; display: flex; align-items: center;">
                <input type="checkbox" id="chk_${col.field}" data-columna="${col.field}" checked style="margin-right: 8px;">
                <label style="font-size: 12px;">${col.caption}</label>
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

document.getElementById('btnCrearFiltro')?.addEventListener('click', () => alert('Funcionalidad de filtros en desarrollo'));

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    actualizarGrupoColumnas();
    document.getElementById('fecha_baja').value = new Date().toISOString().split('T')[0];
});
</script>
@endsection