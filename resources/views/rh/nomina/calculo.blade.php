@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cálculo de Nómina -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cálculo de Nómina
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de nómina -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Nóminas</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;" id="totalNominas">{{ $totalNominas ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Pagado</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;" id="totalPagado">${{ number_format($totalPagado ?? 0, 2) }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Pendientes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;" id="pendientes">{{ $totalPendiente ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #17a2b8; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Período Actual</div>
                        <div style="font-size: 14px; font-weight: bold; line-height: 1.2; color: white;" id="periodoActual">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
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
                            <select id="periodoTipo" style="padding: 8px 12px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px; background-color: white; color: var(--color-primary);">
                                <option value="quincenal" {{ ($periodo_tipo ?? 'quincenal') == 'quincenal' ? 'selected' : '' }}>Quincenal</option>
                                <option value="semanal" {{ ($periodo_tipo ?? 'quincenal') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            </select>
                        </div>
                        
                        <div>
                            <button id="btnCalcular" 
                                    style="background-color: var(--color-primary); border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;">
                                <i class="fas fa-calculator"></i> Calcular Nómina
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-columns"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por folio, empleado..." value="{{ $search ?? '' }}" style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Cálculo de Nómina -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaCalculoNomina" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1200px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodicidad">Periodicidad</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodo_inicio">Inicio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="periodo_fin">Fin</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="dias">Días</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="total">Neto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @if(isset($nominas) && $nominas->count() > 0)
                                @foreach($nominas as $nomina)
                                <tr data-id="{{ $nomina->id }}">
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;"><strong>{{ $nomina->folio }}</strong></td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $nomina->empleado_nombre }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        <span class="badge-periodo {{ $nomina->periodo_tipo }}">{{ ucfirst($nomina->periodo_tipo) }}</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($nomina->periodo_inicio)->format('d/m/Y') }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ \Carbon\Carbon::parse($nomina->periodo_fin)->format('d/m/Y') }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $nomina->dias_trabajados }}/{{ $nomina->periodo_tipo == 'semanal' ? 7 : 15 }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold;">${{ number_format($nomina->neto_pagar, 2) }}</td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                        @php
                                            $estatusClass = '';
                                            $estatusText = '';
                                            switch($nomina->estatus) {
                                                case 'Pagada':
                                                    $estatusClass = 'badge-pagada';
                                                    $estatusText = 'Pagada';
                                                    break;
                                                case 'Calculada':
                                                    $estatusClass = 'badge-calculada';
                                                    $estatusText = 'Calculada';
                                                    break;
                                                case 'Cancelada':
                                                    $estatusClass = 'badge-cancelada';
                                                    $estatusText = 'Cancelada';
                                                    break;
                                                default:
                                                    $estatusClass = 'badge-pendiente';
                                                    $estatusText = 'Pendiente';
                                            }
                                        @endphp
                                        <span class="{{ $estatusClass }}">{{ $estatusText }}</span>
                                    </td>
                                    <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; text-align: center;">
                                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verDetalle({{ $nomina->id }})" title="Ver detalle"></i>
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEstatus({{ $nomina->id }})" title="Cambiar estatus"></i>
                                        <i class="fas fa-print" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="imprimirRecibo({{ $nomina->id }})" title="Imprimir recibo"></i>
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="generarPDF({{ $nomina->id }})" title="Generar PDF"></i>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-calculator" style="font-size: 48px; color: #dee2e6; margin-bottom: 15px; display: block;"></i>
                                        No hay cálculos de nómina registrados
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="6" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total General:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef;" id="totalSuma">${{ number_format(isset($nominas) ? $nominas->sum('neto_pagar') : 0, 2) }}</td>
                                <td colspan="2" style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(isset($nominas) && $nominas && method_exists($nominas, 'lastPage') && $nominas->lastPage() > 1)
                <div id="paginacionContainer" style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div style="font-size: 12px; color: #6c757d;">
                        Mostrando {{ $nominas->firstItem() }} a {{ $nominas->lastItem() }} de {{ $nominas->total() }} registros
                    </div>
                    <div>
                        {{ $nominas->appends(['search' => $search ?? '', 'periodo_tipo' => $periodo_tipo ?? 'quincenal'])->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA CALCULAR NÓMINA -->
<div id="modalCalculoNomina" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Calcular Nómina</h3>
            <button onclick="cerrarModalCalculoNomina()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo de Período *</label>
                <div style="display: flex; gap: 15px;">
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="radio" name="periodo_tipo_modal" value="quincenal" checked onchange="actualizarFechasPeriodo()"> Quincenal
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="radio" name="periodo_tipo_modal" value="semanal" onchange="actualizarFechasPeriodo()"> Semanal
                    </label>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha de Referencia</label>
                <input type="date" id="fechaReferencia" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="actualizarFechasPeriodo()">
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Inicio *</label>
                    <input type="date" id="periodoInicio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Fecha Fin *</label>
                    <input type="date" id="periodoFin" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Seleccionar Empleados</label>
                <div style="border: 1px solid #ced4da; border-radius: 4px; max-height: 250px; overflow-y: auto;">
                    <div style="padding: 10px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                        <label style="display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" id="seleccionarTodos" onchange="toggleSeleccionarTodos()"> Seleccionar todos
                        </label>
                    </div>
                    <div id="listaEmpleados">
                        @foreach($empleados ?? [] as $emp)
                        <div style="padding: 8px 12px; border-bottom: 1px solid #eee; display: flex; align-items: center;">
                            <input type="checkbox" class="empleado-checkbox" value="{{ $emp->plantilla_id }}" style="margin-right: 10px;">
                            <label style="flex: 1; cursor: pointer;">
                                <strong>{{ $emp->nombre_completo }}</strong> - {{ $emp->puesto ? $emp->puesto->nombre : ($emp->puesto_nombre ?? 'N/A') }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalCalculoNomina()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button id="btnCalcularNomina" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Calcular</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA CAMBIAR ESTATUS -->
<div id="modalCambiarEstatus" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 400px;">
        <div style="background: var(--color-primary); padding: 15px 20px; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;">Cambiar Estatus</h3>
            <button onclick="cerrarModalEstatus()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="estatusNominaId">
            <div style="margin-bottom: 15px;">
                <label>Estatus</label>
                <select id="nuevoEstatus" style="width:100%; padding:8px;">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Calculada">Calculada</option>
                    <option value="Pagada">Pagada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            <div style="margin-bottom: 15px; display: none;" id="fechaPagoDiv">
                <label>Fecha de Pago</label>
                <input type="date" id="fechaPago" style="width:100%; padding:8px;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="cerrarModalEstatus()" style="padding: 8px 20px; background: white; border: 1px solid #ced4da;">Cancelar</button>
                <button onclick="guardarEstatus()" style="padding: 8px 20px; background: var(--color-primary); color: white; border: none;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
    }

    .badge-periodo { padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; }
    .badge-periodo.semanal { background-color: #17a2b8; color: white; }
    .badge-periodo.quincenal { background-color: #6c757d; color: white; }
    
    .badge-pagada { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-calculada { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-pendiente { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-cancelada { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    
    .table td:last-child i { margin: 0 5px; cursor: pointer; }
    .table td:last-child i:hover { transform: scale(1.2); }
    .table td:last-child i.fa-eye, .table td:last-child i.fa-edit, .table td:last-child i.fa-print { color: var(--color-primary); }
    .table td:last-child i.fa-file-pdf { color: #dc3545; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; }
    
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); margin-right: 5px; }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-weight: bold; }
    
    .pagination { display: inline-flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
    .pagination li { display: inline-block; }
    .pagination li a, .pagination li span { padding: 6px 12px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px; color: var(--color-primary); text-decoration: none; }
    .pagination li a:hover { background-color: #e8f0fe; }
    .pagination li.active span { background-color: var(--color-primary); border-color: var(--color-primary); color: white; }
    
    #modalCalculoNomina, #modalCambiarEstatus { display: none; align-items: center; justify-content: center; }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .hide-mobile { display: none !important; }
        div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
        .table-container { max-height: 500px; }
        .table td { padding: 8px 4px; font-size: 11px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let empleados = @json($empleados ?? []);
    let calculandoNomina = false;
    let actualizandoEstatus = false;
    let searchTimeout;

    function formatearFecha(fechaISO) {
        if (!fechaISO) return '';
        const f = new Date(fechaISO);
        return `${f.getDate().toString().padStart(2,'0')}/${(f.getMonth()+1).toString().padStart(2,'0')}/${f.getFullYear()}`;
    }

    // Calcular fechas según período
    function actualizarFechasPeriodo() {
        const tipo = document.querySelector('input[name="periodo_tipo_modal"]:checked').value;
        const fechaRef = document.getElementById('fechaReferencia').value;
        const fecha = new Date(fechaRef);
        let inicio, fin;
        
        if (tipo === 'semanal') {
            const dia = fecha.getDay();
            const diffLunes = dia === 0 ? 6 : dia - 1;
            inicio = new Date(fecha);
            inicio.setDate(fecha.getDate() - diffLunes);
            fin = new Date(inicio);
            fin.setDate(inicio.getDate() + 6);
        } else {
            const dia = fecha.getDate();
            if (dia <= 15) {
                inicio = new Date(fecha.getFullYear(), fecha.getMonth(), 1);
                fin = new Date(fecha.getFullYear(), fecha.getMonth(), 15);
            } else {
                inicio = new Date(fecha.getFullYear(), fecha.getMonth(), 16);
                fin = new Date(fecha.getFullYear(), fecha.getMonth() + 1, 0);
            }
        }
        
        document.getElementById('periodoInicio').value = inicio.toISOString().split('T')[0];
        document.getElementById('periodoFin').value = fin.toISOString().split('T')[0];
    }

    function toggleSeleccionarTodos() {
        const todos = document.getElementById('seleccionarTodos').checked;
        document.querySelectorAll('.empleado-checkbox').forEach(cb => cb.checked = todos);
    }

    async function calcularNomina() {
        if (calculandoNomina) {
            alert('Ya se está procesando un cálculo. Por favor espera.');
            return;
        }
        
        const periodoTipo = document.querySelector('input[name="periodo_tipo_modal"]:checked').value;
        const periodoInicio = document.getElementById('periodoInicio').value;
        const periodoFin = document.getElementById('periodoFin').value;
        const empleadosSeleccionados = Array.from(document.querySelectorAll('.empleado-checkbox:checked')).map(cb => cb.value);
        
        if (!periodoInicio || !periodoFin) {
            alert('Seleccione un período válido');
            return;
        }
        
        if (empleadosSeleccionados.length === 0) {
            alert('Seleccione al menos un empleado');
            return;
        }
        
        calculandoNomina = true;
        const botonCalcular = document.getElementById('btnCalcularNomina');
        const textoOriginal = botonCalcular ? botonCalcular.innerHTML : 'Calcular';
        
        try {
            if (botonCalcular) {
                botonCalcular.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calculando...';
                botonCalcular.disabled = true;
            }
            
            // Usar la ruta POST que ya existe en tu controlador
            const response = await fetch('/rh/nomina/calcular', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    periodo_tipo: periodoTipo,
                    periodo_inicio: periodoInicio,
                    periodo_fin: periodoFin,
                    empleados: empleadosSeleccionados
                })
            });
            
            const data = await response.json();
            if (data.success) {
                alert(data.message);
                cerrarModalCalculoNomina();
                // Recargar la página para mostrar los nuevos cálculos
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Error al calcular nómina'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al calcular nómina');
        } finally {
            calculandoNomina = false;
            if (botonCalcular) {
                botonCalcular.innerHTML = textoOriginal;
                botonCalcular.disabled = false;
            }
        }
    }

    function verDetalle(id) {
        window.open(`/rh/nomina/${id}`, '_blank');
    }

    function editarEstatus(id) {
        const nominaElement = document.querySelector(`tr[data-id="${id}"]`);
        if (nominaElement) {
            const estatusSpan = nominaElement.querySelector('td:nth-child(8) span');
            const estatusActual = estatusSpan ? estatusSpan.innerText : 'Pendiente';
            
            document.getElementById('estatusNominaId').value = id;
            document.getElementById('nuevoEstatus').value = estatusActual;
            document.getElementById('fechaPago').value = '';
            
            const fechaPagoDiv = document.getElementById('fechaPagoDiv');
            if (fechaPagoDiv) {
                fechaPagoDiv.style.display = estatusActual === 'Pagada' ? 'block' : 'none';
            }
            
            document.getElementById('modalCambiarEstatus').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            document.getElementById('nuevoEstatus').onchange = function() {
                if (fechaPagoDiv) {
                    fechaPagoDiv.style.display = this.value === 'Pagada' ? 'block' : 'none';
                }
            };
        }
    }

    async function guardarEstatus() {
        if (actualizandoEstatus) {
            return;
        }
        
        const id = document.getElementById('estatusNominaId').value;
        const estatus = document.getElementById('nuevoEstatus').value;
        const fechaPago = document.getElementById('fechaPago').value;
        
        actualizandoEstatus = true;
        
        try {
            const response = await fetch(`/rh/nomina/${id}/estatus`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ estatus, fecha_pago: fechaPago })
            });
            
            const data = await response.json();
            if (data.success) {
                alert('Estatus actualizado correctamente');
                cerrarModalEstatus();
                // Recargar la página para mostrar los cambios
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Error al actualizar estatus'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al actualizar estatus');
        } finally {
            actualizandoEstatus = false;
        }
    }

    function imprimirRecibo(id) {
        window.open(`/rh/nomina/${id}/print`, '_blank');
    }

    function generarPDF(id) {
        window.open(`/rh/nomina/${id}/pdf`, '_blank');
    }

    // Modales
    function abrirModalCalculoNomina() {
        actualizarFechasPeriodo();
        document.getElementById('modalCalculoNomina').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalCalculoNomina() {
        document.getElementById('modalCalculoNomina').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalEstatus() {
        document.getElementById('modalCambiarEstatus').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Buscador con recarga
    document.getElementById('buscador')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const term = e.target.value;
            const url = new URL(window.location.href);
            if (term) url.searchParams.set('search', term);
            else url.searchParams.delete('search');
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    });

    // Selector de período con recarga
    document.getElementById('periodoTipo')?.addEventListener('change', function(e) {
        const url = new URL(window.location.href);
        url.searchParams.set('periodo_tipo', e.target.value);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });

    // Drag & drop y columnas
    document.addEventListener('DOMContentLoaded', function() {
        let columnasAgrupadas = [];
        
        function actualizarGrupoColumnas() {
            const container = document.getElementById('grupoColumnas');
            const texto = document.getElementById('textoAgrupar');
            if (container) container.innerHTML = '';
            if (texto) {
                texto.style.display = columnasAgrupadas.length === 0 ? 'inline' : 'none';
            }
            if (container) {
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
            if (selector) {
                selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
                if (selector.style.display === 'block') {
                    const columnas = ['folio', 'empleado', 'periodicidad', 'periodo_inicio', 'periodo_fin', 'dias', 'total', 'estatus'];
                    const lista = document.getElementById('columnasLista');
                    if (lista) {
                        lista.innerHTML = columnas.map(col => `
                            <div style="padding: 5px 0; display: flex; align-items: center;">
                                <input type="checkbox" id="chk_${col}" data-columna="${col}" checked style="margin-right: 8px;">
                                <label style="font-size: 12px;">${col.replace('_', ' ').toUpperCase()}</label>
                            </div>
                        `).join('');
                    }
                }
            }
        };
        
        window.cerrarColumnSelector = function() {
            const selector = document.getElementById('columnSelector');
            if (selector) selector.style.display = 'none';
        };
        
        document.addEventListener('click', function(e) {
            const btnColumnas = document.getElementById('btnColumnas');
            const columnSelector = document.getElementById('columnSelector');
            if (btnColumnas && columnSelector && !e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
                columnSelector.style.display = 'none';
            }
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', () => {
            alert('Funcionalidad de exportación a Excel en desarrollo');
        });
        
        // Botón calcular
        document.getElementById('btnCalcular')?.addEventListener('click', abrirModalCalculoNomina);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalCalculoNomina();
            cerrarModalEstatus();
        }
    });

    document.getElementById('modalCalculoNomina')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalCalculoNomina();
    });

    document.getElementById('modalCambiarEstatus')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalEstatus();
    });
</script>
@endsection