@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Recibos de Nómina (Timbrados) -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-invoice" style="margin-right: 10px;"></i> Recibos de Nómina (Timbrados)
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de nómina -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Total Recibos -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background: linear-gradient(135deg, #2378e1, #1a5fc7); width: 100%; text-align: center; box-shadow: 0 2px 8px rgba(35, 120, 225, 0.3);">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Recibos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ number_format($kpis['total'] ?? 0) }}</div>
                    </div>

                    <!-- Por Timbrar -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background: linear-gradient(135deg, #ffc107, #f8a100); width: 100%; text-align: center; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Por Timbrar</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;">{{ number_format($kpis['por_timbrar'] ?? 0) }}</div>
                    </div>

                    <!-- Timbrados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background: linear-gradient(135deg, #28a745, #1e7e34); width: 100%; text-align: center; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Timbrados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ number_format($kpis['timbrados'] ?? 0) }}</div>
                    </div>

                    <!-- Cancelados -->
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background: linear-gradient(135deg, #dc3545, #b02a37); width: 100%; text-align: center; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Cancelados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;">{{ number_format($kpis['cancelados'] ?? 0) }}</div>
                    </div>
                </div>

                <!-- Filtros de período -->
                <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 5px; background-color: #f8f9fa; padding: 5px 10px; border-radius: 4px; border: 1px solid #dee2e6;">
                        <i class="fas fa-calendar-alt" style="color: var(--color-primary); font-size: 14px;"></i>
                        <span style="font-size: 13px; font-weight: 500;">Período:</span>
                        <span style="font-size: 13px;">{{ $filtros['periodo'] ?? 'Todos' }}</span>
                    </div>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach($periodos ?? [] as $periodo)
                            <a href="{{ route('rh.recibos', ['periodo' => $periodo]) }}" 
                               class="filtro-periodo" 
                               style="background-color: {{ ($filtros['periodo'] ?? '') == $periodo ? 'var(--color-primary)' : 'transparent' }}; 
                                      color: {{ ($filtros['periodo'] ?? '') == $periodo ? 'white' : 'var(--color-primary)' }}; 
                                      border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-block;">
                                {{ $periodo }}
                            </a>
                        @endforeach
                    </div>
                    
                    <div style="margin-left: auto; display: flex; gap: 10px;">
                        <select id="filtroAnio" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                            <option value="">Año</option>
                            @foreach($anios ?? [] as $anio)
                                <option value="{{ $anio }}" {{ ($filtros['anio'] ?? '') == $anio ? 'selected' : '' }}>{{ $anio }}</option>
                            @endforeach
                        </select>
                        <select id="filtroEstatus" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                            <option value="">Todos los estatus</option>
                            <option value="Timbrado" {{ ($filtros['estatus_timbrado'] ?? '') == 'Timbrado' ? 'selected' : '' }}>Timbrado</option>
                            <option value="Por Timbrar" {{ ($filtros['estatus_timbrado'] ?? '') == 'Por Timbrar' ? 'selected' : '' }}>Por Timbrar</option>
                            <option value="Cancelado" {{ ($filtros['estatus_timbrado'] ?? '') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                            <option value="Error" {{ ($filtros['estatus_timbrado'] ?? '') == 'Error' ? 'selected' : '' }}>Error</option>
                        </select>
                    </div>
                </div>

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
                        <!-- Botón Generar Recibos -->
                        <div>
                            <button id="btnGenerar" 
                                    style="background-color: #17a2b8; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;"
                                    onclick="abrirModalGenerar()">
                                <i class="fas fa-plus-circle"></i> Generar
                            </button>
                        </div>

                        <!-- Botón Timbrar Seleccionados -->
                        <div>
                            <button id="btnTimbrar" 
                                    style="background-color: #28a745; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;">
                                <i class="fas fa-certificate"></i> Timbrar
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar por empleado, RFC, folio..." value="{{ $filtros['buscar'] ?? '' }}" style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Recibos de Nómina -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaRecibos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1300px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 5%;">
                                    <input type="checkbox" id="seleccionarTodos" style="accent-color: white;">
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="folio" onclick="ordenarPor('folio')">
                                    Folio <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="uuid">UUID</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="empleado_nombre" onclick="ordenarPor('empleado_nombre')">
                                    Empleado <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="rfc" onclick="ordenarPor('rfc')">
                                    RFC <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="periodo" onclick="ordenarPor('periodo')">
                                    Período <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="fecha_pago" onclick="ordenarPor('fecha_pago')">
                                    Fecha Pago <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="total_percepciones" onclick="ordenarPor('total_percepciones')">
                                    Percepciones <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="total_deducciones" onclick="ordenarPor('total_deducciones')">
                                    Deducciones <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer; font-weight: bold;" draggable="true" data-columna="neto_pagar" onclick="ordenarPor('neto_pagar')">
                                    Neto <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="estatus_timbrado" onclick="ordenarPor('estatus_timbrado')">
                                    Estatus Timbrado <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; cursor: pointer;" draggable="true" data-columna="fecha_timbrado" onclick="ordenarPor('fecha_timbrado')">
                                    Fecha Timbrado <i class="fas fa-sort" style="font-size: 10px; margin-left: 3px;"></i>
                                </th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recibos ?? [] as $recibo)
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <input type="checkbox" class="seleccionar-recibo" value="{{ $recibo->id }}" style="accent-color: var(--color-primary);">
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500; color: var(--color-primary);">
                                    {{ $recibo->folio }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-family: monospace; font-size: 10px;">
                                    {{ $recibo->uuid ? $recibo->uuid_corto : '—' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">{{ $recibo->empleado_nombre }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $recibo->rfc }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">{{ $recibo->periodo }}</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $recibo->fecha_pago ? $recibo->fecha_pago->format('d/m/Y') : '-' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; color: #28a745;">
                                    ${{ number_format($recibo->total_percepciones, 2) }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; color: #dc3545;">
                                    ${{ number_format($recibo->total_deducciones, 2) }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right; font-weight: bold; color: var(--color-primary);">
                                    ${{ number_format($recibo->neto_pagar, 2) }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: {{ $recibo->estatus_color }}; 
                                                 color: {{ $recibo->estatus_text_color }}; 
                                                 padding: 4px 8px; border-radius: 3px; 
                                                 font-size: 11px; display: inline-block; min-width: 80px;">
                                        <i class="fas {{ $recibo->estatus_icono }}" style="font-size: 10px; margin-right: 3px;"></i>
                                        {{ $recibo->estatus_timbrado }}
                                    </span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-size: 11px;">
                                    {{ $recibo->fecha_timbrado ? $recibo->fecha_timbrado->format('d/m/Y H:i') : '—' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center; min-width: 120px;">
                                    <!-- Ver -->
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="verRecibo({{ $recibo->id }})" title="Ver recibo"></i>
                                    
                                    @if($recibo->estatus_timbrado === 'Timbrado')
                                        <!-- PDF -->
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="descargarPDF({{ $recibo->id }})" title="Descargar PDF"></i>
                                        <!-- Enviar correo -->
                                        <i class="fas fa-envelope" style="color: var(--color-primary); margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="enviarCorreo({{ $recibo->id }})" title="Enviar por correo"></i>
                                        <!-- Cancelar timbrado -->
                                        <i class="fas fa-undo-alt" style="color: #ffc107; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="cancelarTimbrado({{ $recibo->id }})" title="Cancelar timbrado"></i>
                                    @elseif($recibo->estatus_timbrado === 'Por Timbrar')
                                        <!-- Timbrar -->
                                        <i class="fas fa-certificate" style="color: #28a745; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="timbrarRecibo({{ $recibo->id }})" title="Timbrar"></i>
                                        <!-- Editar -->
                                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="editarRecibo({{ $recibo->id }})" title="Editar"></i>
                                        <!-- Eliminar -->
                                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="eliminarRecibo({{ $recibo->id }})" title="Eliminar"></i>
                                    @elseif($recibo->estatus_timbrado === 'Cancelado')
                                        <!-- PDF -->
                                        <i class="fas fa-file-pdf" style="color: #dc3545; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="descargarPDF({{ $recibo->id }})" title="Descargar PDF"></i>
                                        <!-- Re-timbrar -->
                                        <i class="fas fa-redo-alt" style="color: #28a745; margin: 0 3px; cursor: pointer; font-size: 14px;" onclick="retimbrarRecibo({{ $recibo->id }})" title="Re-timbrar"></i>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" style="padding: 40px 20px; text-align: center; color: #6c757d;">
                                    <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 15px; color: #dee2e6;"></i>
                                    <div style="font-size: 16px; font-weight: 500;">No hay recibos de nómina registrados</div>
                                    <div style="font-size: 13px; margin-top: 5px;">Genera recibos desde las nóminas existentes</div>
                                    <button onclick="abrirModalGenerar()" style="margin-top: 15px; padding: 8px 25px; background: var(--color-primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        <i class="fas fa-plus-circle"></i> Generar Recibos
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="7" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Totales:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef; color: #28a745;">
                                    ${{ number_format($kpis['total_percepciones'] ?? 0, 2) }}
                                </td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef; color: #dc3545;">
                                    ${{ number_format($kpis['total_deducciones'] ?? 0, 2) }}
                                </td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right; background-color: #e9ecef; font-weight: bold; color: var(--color-primary);">
                                    ${{ number_format($kpis['total_neto'] ?? 0, 2) }}
                                </td>
                                <td colspan="2" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;">
                                    Total Recibos: {{ $recibos instanceof \Illuminate\Pagination\LengthAwarePaginator ? $recibos->total() : $recibos->count() }}
@if($recibos->count() > 0)
<span style="margin-left: 15px; font-size: 11px; color: #6c757d;">
    @if($recibos instanceof \Illuminate\Pagination\LengthAwarePaginator)
        ({{ $recibos->firstItem() ?? 0 }} - {{ $recibos->lastItem() ?? 0 }} de {{ $recibos->total() }})
    @else
        (Mostrando {{ $recibos->count() }} registros)
    @endif
</span>
@endif
                                </td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(isset($recibos) && method_exists($recibos, 'links'))
                <div style="margin-top: 15px; display: flex; justify-content: center;">
                    {{ $recibos->appends(request()->query())->links() }}
                </div>
                @endif

                <!-- Crear filtro y resumen -->
                <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; gap: 20px; font-size: 12px;">
                        <span><strong style="color: #28a745;">✓ Timbrados:</strong> {{ number_format($resumenEstatus['timbrados'] ?? 0) }}</span>
                        <span><strong style="color: #ffc107;">⏱ Por Timbrar:</strong> {{ number_format($resumenEstatus['por_timbrar'] ?? 0) }}</span>
                        <span><strong style="color: #dc3545;">✗ Cancelados:</strong> {{ number_format($resumenEstatus['cancelados'] ?? 0) }}</span>
                        <span><strong style="color: var(--color-primary);">Total Neto:</strong> ${{ number_format($kpis['total_neto'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ============================================ -->
<!-- MODAL GENERAR RECIBOS -->
<!-- ============================================ -->
<div id="modalGenerar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">
                <i class="fas fa-plus-circle"></i> Generar Recibos de Nómina
            </h3>
            <button onclick="cerrarModalGenerar()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Contenido -->
        <div style="padding: 20px;">
            <p style="font-size: 13px; color: #6c757d; margin-bottom: 15px;">
                Selecciona las nóminas pagadas para generar sus recibos de nómina timbrados.
            </p>
            
            <div style="margin-bottom: 15px;">
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" id="buscarNominas" placeholder="Buscar nómina..." style="flex: 1; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                    <button onclick="cargarNominasDisponibles()" style="padding: 8px 20px; background: var(--color-primary); color: white; border: none; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                
                <div style="border: 1px solid #dee2e6; border-radius: 4px; max-height: 300px; overflow-y: auto;">
                    <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0;">
                            <tr>
                                <th style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6; width: 5%;">
                                    <input type="checkbox" id="seleccionarTodasNominas" onchange="toggleTodasNominas()">
                                </th>
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #dee2e6;">Folio</th>
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #dee2e6;">Empleado</th>
                                <th style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6;">Neto</th>
                                <th style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">Fecha Pago</th>
                            </tr>
                        </thead>
                        <tbody id="listaNominas">
                            <tr>
                                <td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">
                                    <i class="fas fa-spinner fa-spin"></i> Cargando nóminas disponibles...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                <span style="font-size: 13px; color: #6c757d;">
                    <strong id="contadorSeleccionadas">0</strong> nómina(s) seleccionada(s)
                </span>
                <button onclick="seleccionarTodasNominas()" style="background: transparent; border: none; color: var(--color-primary); cursor: pointer; font-size: 12px;">
                    <i class="fas fa-check-double"></i> Seleccionar todas
                </button>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <button onclick="cerrarModalGenerar()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="generarRecibos()" id="btnGenerarRecibos" style="padding: 8px 25px; border: none; border-radius: 4px; background: #28a745; color: white; cursor: pointer;">
                    <i class="fas fa-file-invoice"></i> Generar Recibos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL VER RECIBO -->
<!-- ============================================ -->
<div id="modalVerRecibo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalReciboTitle">Recibo de Nómina</h3>
            <button onclick="cerrarModalVerRecibo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Contenido del recibo -->
        <div id="modalReciboContent" style="padding: 20px;">
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <i class="fas fa-spinner fa-spin" style="font-size: 40px;"></i>
                <p style="margin-top: 10px;">Cargando recibo...</p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL EDITAR RECIBO -->
<!-- ============================================ -->
<div id="modalEditarRecibo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">
                <i class="fas fa-edit"></i> Editar Recibo
            </h3>
            <button onclick="cerrarModalEditarRecibo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <form id="formEditarRecibo">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_recibo_id" name="id">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado</label>
                        <input type="text" id="edit_empleado_nombre" name="empleado_nombre" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">RFC</label>
                        <input type="text" id="edit_rfc" name="rfc" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; text-transform: uppercase;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">CURP</label>
                        <input type="text" id="edit_curp" name="curp" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; text-transform: uppercase;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Puesto</label>
                        <input type="text" id="edit_puesto" name="puesto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Área</label>
                        <input type="text" id="edit_area" name="area" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Percepciones</label>
                        <input type="number" id="edit_total_percepciones" name="total_percepciones" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Deducciones</label>
                        <input type="number" id="edit_total_deducciones" name="total_deducciones" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Neto</label>
                        <input type="number" id="edit_neto_pagar" name="neto_pagar" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                        <textarea id="edit_observaciones" name="observaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="cerrarModalEditarRecibo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 8px 25px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
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
        min-width: 1300px;
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
    
    /* Alineaciones específicas */
    .table td:nth-child(1),
    .table td:nth-child(2),
    .table td:nth-child(3),
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(7),
    .table td:nth-child(11),
    .table td:nth-child(12) {
        text-align: center;
    }
    
    .table td:nth-child(4) {
        text-align: left;
    }
    
    .table td:nth-child(8),
    .table td:nth-child(9),
    .table td:nth-child(10) {
        text-align: right;
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
        margin: 0 3px;
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
    #modalGenerar,
    #modalVerRecibo,
    #modalEditarRecibo {
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
        
        div[style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .table-container {
            max-height: 500px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 2px;
            font-size: 12px;
        }
        
        .table td:last-child {
            min-width: 80px;
        }
        
        #modalGenerar > div,
        #modalVerRecibo > div,
        #modalEditarRecibo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // ============================================
    // SELECCIONAR TODOS LOS RECIBOS
    // ============================================
    document.getElementById('seleccionarTodos').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.seleccionar-recibo');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
    
    // ============================================
    // DRAG & DROP PARA AGRUPACIÓN
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

    // ============================================
    // SELECTOR DE COLUMNAS
    // ============================================
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'uuid', caption: 'UUID' },
                { field: 'empleado_nombre', caption: 'Empleado' },
                { field: 'rfc', caption: 'RFC' },
                { field: 'periodo', caption: 'Período' },
                { field: 'fecha_pago', caption: 'Fecha Pago' },
                { field: 'total_percepciones', caption: 'Percepciones' },
                { field: 'total_deducciones', caption: 'Deducciones' },
                { field: 'neto_pagar', caption: 'Neto' },
                { field: 'estatus_timbrado', caption: 'Estatus Timbrado' },
                { field: 'fecha_timbrado', caption: 'Fecha Timbrado' }
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
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // ============================================
    // FILTROS
    // ============================================
    document.getElementById('filtroAnio').addEventListener('change', function() {
        aplicarFiltros();
    });
    
    document.getElementById('filtroEstatus').addEventListener('change', function() {
        aplicarFiltros();
    });
    
    function aplicarFiltros() {
        const anio = document.getElementById('filtroAnio').value;
        const estatus = document.getElementById('filtroEstatus').value;
        const buscar = document.getElementById('buscador').value;
        
        let url = new URL(window.location.href);
        if (anio) url.searchParams.set('anio', anio);
        else url.searchParams.delete('anio');
        
        if (estatus) url.searchParams.set('estatus_timbrado', estatus);
        else url.searchParams.delete('estatus_timbrado');
        
        if (buscar) url.searchParams.set('buscar', buscar);
        else url.searchParams.delete('buscar');
        
        window.location.href = url.toString();
    }

    // ============================================
    // BUSCADOR
    // ============================================
    document.getElementById('buscador').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            aplicarFiltros();
        }
    });

    // ============================================
    // ORDENAMIENTO
    // ============================================
    window.ordenarPor = function(columna) {
        const url = new URL(window.location.href);
        const sortActual = url.searchParams.get('sort_by');
        const orderActual = url.searchParams.get('sort_order');
        
        if (sortActual === columna) {
            url.searchParams.set('sort_order', orderActual === 'asc' ? 'desc' : 'asc');
        } else {
            url.searchParams.set('sort_by', columna);
            url.searchParams.set('sort_order', 'asc');
        }
        
        window.location.href = url.toString();
    };

    // ============================================
    // BOTONES PRINCIPALES
    // ============================================
    document.getElementById('btnCrearFiltro').addEventListener('click', () => {
        alert('Funcionalidad de filtro avanzado en desarrollo');
    });

    document.getElementById('btnExcel').addEventListener('click', function() {
        let url = "{{ route('rh.recibos.exportar') }}";
        const params = new URLSearchParams(window.location.search);
        if (params.toString()) {
            url += '?' + params.toString();
        }
        window.location.href = url;
    });

    // ============================================
    // TIMBRAR SELECCIONADOS
    // ============================================
    document.getElementById('btnTimbrar').addEventListener('click', function() {
        const seleccionados = document.querySelectorAll('.seleccionar-recibo:checked');
        if (seleccionados.length === 0) {
            alert('⚠️ Selecciona al menos un recibo para timbrar');
            return;
        }
        
        // Verificar que todos los seleccionados estén "Por Timbrar"
        let error = false;
        seleccionados.forEach(cb => {
            const row = cb.closest('tr');
            const estatusCell = row.querySelector('td:nth-child(11)');
            if (estatusCell && !estatusCell.textContent.includes('Por Timbrar')) {
                error = true;
            }
        });
        
        if (error) {
            alert('⚠️ Solo se pueden timbrar recibos con estatus "Por Timbrar"');
            return;
        }
        
        if (!confirm(`¿Timbrar ${seleccionados.length} recibo(s)?`)) return;
        
        const ids = Array.from(seleccionados).map(cb => cb.value);
        
        fetch("{{ route('rh.recibos.timbrar') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
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
            alert('❌ Error al timbrar: ' + error.message);
        });
    });

    // ============================================
    // FUNCIONES DE ACCIONES
    // ============================================
    window.verRecibo = function(id) {
        const modal = document.getElementById('modalVerRecibo');
        const content = document.getElementById('modalReciboContent');
        const title = document.getElementById('modalReciboTitle');
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        content.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <i class="fas fa-spinner fa-spin" style="font-size: 40px;"></i>
                <p style="margin-top: 10px;">Cargando recibo...</p>
            </div>
        `;
        
        fetch("{{ route('rh.recibos.show', '') }}/" + id, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const r = data.data;
                title.textContent = `Recibo de Nómina - ${r.folio}`;
                
                content.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e9ecef; padding-bottom: 15px;">
                        <div>
                            <div style="font-size: 20px; font-weight: bold; color: var(--color-primary);">RECIBO DE NÓMINA</div>
                            <div style="font-size: 12px; color: #6c757d;">Folio Fiscal: ${r.uuid || 'No timbrado'}</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="background-color: ${r.estatus_color}; color: ${r.estatus_text_color}; padding: 4px 12px; border-radius: 3px; font-size: 12px;">
                                ${r.estatus_timbrado}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Datos del Empleado</h4>
                            <table style="width: 100%; font-size: 12px;">
                                <tr><td style="padding: 4px 0; color: #6c757d;">Nombre:</td><td style="padding: 4px 0; font-weight: 500;">${r.empleado_nombre}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">RFC:</td><td style="padding: 4px 0;">${r.rfc}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">CURP:</td><td style="padding: 4px 0;">${r.curp || '—'}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">NSS:</td><td style="padding: 4px 0;">${r.nss || '—'}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Puesto:</td><td style="padding: 4px 0;">${r.puesto || '—'}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Área:</td><td style="padding: 4px 0;">${r.area || '—'}</td></tr>
                            </table>
                        </div>
                        <div>
                            <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Datos del Período</h4>
                            <table style="width: 100%; font-size: 12px;">
                                <tr><td style="padding: 4px 0; color: #6c757d;">Período:</td><td style="padding: 4px 0;">${r.periodo}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Pago:</td><td style="padding: 4px 0;">${r.fecha_pago_formateada}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Inicio:</td><td style="padding: 4px 0;">${r.fecha_inicio ? new Date(r.fecha_inicio).toLocaleDateString('es-MX') : '—'}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Fecha Fin:</td><td style="padding: 4px 0;">${r.fecha_fin ? new Date(r.fecha_fin).toLocaleDateString('es-MX') : '—'}</td></tr>
                                <tr><td style="padding: 4px 0; color: #6c757d;">Días Pagados:</td><td style="padding: 4px 0;">${r.dias_pagados}</td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Percepciones</h4>
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Concepto</th>
                                    <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Sueldo</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$${r.total_percepciones ? r.total_percepciones.toFixed(2) : '0.00'}</td></tr>
                                <tr style="background-color: #f8f9fa; font-weight: bold;">
                                    <td style="padding: 8px; border: 1px solid #dee2e6;">Total Percepciones</td>
                                    <td style="padding: 8px; text-align: right; border: 1px solid #dee2e6; color: #28a745;">$${r.total_percepciones ? r.total_percepciones.toFixed(2) : '0.00'}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 14px; font-weight: bold; color: var(--color-primary); margin: 0 0 10px 0;">Deducciones</h4>
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th style="padding: 8px; text-align: left; border: 1px solid #dee2e6;">Concepto</th>
                                    <th style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td style="padding: 8px; border: 1px solid #dee2e6;">Deducciones</td><td style="padding: 8px; text-align: right; border: 1px solid #dee2e6;">$${r.total_deducciones ? r.total_deducciones.toFixed(2) : '0.00'}</td></tr>
                                <tr style="background-color: #f8f9fa; font-weight: bold;">
                                    <td style="padding: 8px; border: 1px solid #dee2e6;">Total Deducciones</td>
                                    <td style="padding: 8px; text-align: right; border: 1px solid #dee2e6; color: #dc3545;">$${r.total_deducciones ? r.total_deducciones.toFixed(2) : '0.00'}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="background-color: #e9ecef; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 16px; font-weight: bold;">NETO A PAGAR</span>
                            <span style="font-size: 24px; font-weight: bold; color: var(--color-primary);">$${r.neto_pagar ? r.neto_pagar.toFixed(2) : '0.00'}</span>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalVerRecibo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
                        ${r.estatus_timbrado === 'Timbrado' ? `
                            <button onclick="descargarPDF(${r.id})" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                                <i class="fas fa-file-pdf"></i> Descargar PDF
                            </button>
                        ` : ''}
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #dc3545;">
                        <i class="fas fa-exclamation-circle" style="font-size: 40px;"></i>
                        <p style="margin-top: 10px;">${data.message || 'Error al cargar el recibo'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #dc3545;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 40px;"></i>
                    <p style="margin-top: 10px;">Error al cargar el recibo: ${error.message}</p>
                </div>
            `;
        });
    };

    window.descargarPDF = function(id) {
        window.open("{{ route('rh.recibos.pdf', '') }}/" + id, '_blank');
    };

    window.enviarCorreo = function(id) {
        if (!confirm('¿Enviar este recibo por correo electrónico?')) return;
        
        fetch("{{ route('rh.recibos.enviar', '') }}/" + id, {
            method: 'POST',
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
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al enviar correo: ' + error.message);
        });
    };

    window.cancelarTimbrado = function(id) {
        const motivo = prompt('Motivo de cancelación:');
        if (!motivo) return;
        
        if (!confirm('¿Cancelar el timbrado de este recibo?')) return;
        
        fetch("{{ route('rh.recibos.cancelar', '') }}/" + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ motivo: motivo })
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
            alert('❌ Error al cancelar timbrado: ' + error.message);
        });
    };

    window.retimbrarRecibo = function(id) {
        if (!confirm('¿Re-timbrar este recibo?')) return;
        
        fetch("{{ route('rh.recibos.retimbrar', '') }}/" + id, {
            method: 'POST',
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
            alert('❌ Error al re-timbrar: ' + error.message);
        });
    };

    window.timbrarRecibo = function(id) {
        if (!confirm('¿Timbrar este recibo?')) return;
        
        fetch("{{ route('rh.recibos.timbrar') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: [id] })
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
            alert('❌ Error al timbrar: ' + error.message);
        });
    };

    window.editarRecibo = function(id) {
        fetch("{{ route('rh.recibos.show', '') }}/" + id, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const r = data.data;
                document.getElementById('edit_recibo_id').value = r.id;
                document.getElementById('edit_empleado_nombre').value = r.empleado_nombre || '';
                document.getElementById('edit_rfc').value = r.rfc || '';
                document.getElementById('edit_curp').value = r.curp || '';
                document.getElementById('edit_puesto').value = r.puesto || '';
                document.getElementById('edit_area').value = r.area || '';
                document.getElementById('edit_total_percepciones').value = r.total_percepciones || 0;
                document.getElementById('edit_total_deducciones').value = r.total_deducciones || 0;
                document.getElementById('edit_neto_pagar').value = r.neto_pagar || 0;
                document.getElementById('edit_observaciones').value = r.observaciones || '';
                
                document.getElementById('modalEditarRecibo').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            } else {
                alert('❌ Error al cargar el recibo: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al cargar el recibo: ' + error.message);
        });
    };

    window.eliminarRecibo = function(id) {
        if (!confirm('¿Eliminar este recibo? Esta acción no se puede deshacer.')) return;
        
        fetch("{{ route('rh.recibos.destroy', '') }}/" + id, {
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
    };

    // ============================================
    // MODALES
    // ============================================
    
    // Modal Generar
    window.abrirModalGenerar = function() {
        document.getElementById('modalGenerar').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        cargarNominasDisponibles();
    };

    window.cerrarModalGenerar = function() {
        document.getElementById('modalGenerar').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    function cargarNominasDisponibles() {
    const buscar = document.getElementById('buscarNominas').value;
    const tbody = document.getElementById('listaNominas');
    
    tbody.innerHTML = `
        <tr>
            <td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">
                <i class="fas fa-spinner fa-spin"></i> Cargando nóminas disponibles...
            </td>
        </tr>
    `;
    
    let url = "{{ route('rh.recibos.nominas') }}";
    if (buscar) url += '?buscar=' + encodeURIComponent(buscar);
    
    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">
                            <i class="fas fa-inbox" style="font-size: 24px; display: block; margin-bottom: 5px;"></i>
                            No hay nóminas disponibles para generar recibos
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = data.data.map(n => {
                // ✅ CONVERTIR A NÚMERO ANTES DE USAR toFixed()
                const neto = parseFloat(n.neto_pagar) || 0;
                const fechaPago = n.fecha_pago ? new Date(n.fecha_pago).toLocaleDateString('es-MX') : '—';
                
                return `
                    <tr>
                        <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">
                            <input type="checkbox" class="seleccionar-nomina" value="${n.id}" onchange="actualizarContadorNominas()">
                        </td>
                        <td style="padding: 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">${n.folio || '—'}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #dee2e6;">${n.empleado_nombre || '—'}</td>
                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #dee2e6; font-weight: bold;">$${neto.toFixed(2)}</td>
                        <td style="padding: 8px; text-align: center; border-bottom: 1px solid #dee2e6;">${fechaPago}</td>
                    </tr>
                `;
            }).join('');
            
            actualizarContadorNominas();
        } else {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="padding: 20px; text-align: center; color: #dc3545;">
                        <i class="fas fa-exclamation-circle"></i> ${data.message || 'Error al cargar nóminas'}
                    </td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="padding: 20px; text-align: center; color: #dc3545;">
                    <i class="fas fa-exclamation-triangle"></i> Error al cargar nóminas: ${error.message}
                </td>
            </tr>
        `;
    });
}

    window.actualizarContadorNominas = function() {
        const seleccionadas = document.querySelectorAll('.seleccionar-nomina:checked').length;
        document.getElementById('contadorSeleccionadas').textContent = seleccionadas;
    };

    window.toggleTodasNominas = function() {
        const checked = document.getElementById('seleccionarTodasNominas').checked;
        document.querySelectorAll('.seleccionar-nomina').forEach(cb => cb.checked = checked);
        actualizarContadorNominas();
    };

    window.seleccionarTodasNominas = function() {
        document.querySelectorAll('.seleccionar-nomina').forEach(cb => cb.checked = true);
        document.getElementById('seleccionarTodasNominas').checked = true;
        actualizarContadorNominas();
    };

    window.generarRecibos = function() {
        const seleccionadas = document.querySelectorAll('.seleccionar-nomina:checked');
        if (seleccionadas.length === 0) {
            alert('⚠️ Selecciona al menos una nómina');
            return;
        }
        
        if (!confirm(`¿Generar recibos para ${seleccionadas.length} nómina(s)?`)) return;
        
        const ids = Array.from(seleccionadas).map(cb => cb.value);
        const btn = document.getElementById('btnGenerarRecibos');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        
        fetch("{{ route('rh.recibos.generar') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nomina_ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-file-invoice"></i> Generar Recibos';
            
            if (data.success) {
                alert('✅ ' + data.message);
                cerrarModalGenerar();
                location.reload();
            } else {
                alert('❌ Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-file-invoice"></i> Generar Recibos';
            alert('❌ Error al generar recibos: ' + error.message);
        });
    };

    document.getElementById('buscarNominas').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            cargarNominasDisponibles();
        }
    });

    // Modal Ver Recibo
    window.cerrarModalVerRecibo = function() {
        document.getElementById('modalVerRecibo').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Modal Editar Recibo
    window.cerrarModalEditarRecibo = function() {
        document.getElementById('modalEditarRecibo').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    document.getElementById('formEditarRecibo').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_recibo_id').value;
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        fetch("{{ route('rh.recibos.update', '') }}/" + id, {
            method: 'PUT',
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
                cerrarModalEditarRecibo();
                location.reload();
            } else {
                alert('❌ Error: ' + (data.message || 'Error al actualizar'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al actualizar: ' + error.message);
        });
    });

    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalGenerar();
            cerrarModalVerRecibo();
            cerrarModalEditarRecibo();
        }
    });

    // Cerrar modales al hacer clic fuera
    document.querySelectorAll('#modalGenerar, #modalVerRecibo, #modalEditarRecibo').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'modalGenerar') cerrarModalGenerar();
                else if (this.id === 'modalVerRecibo') cerrarModalVerRecibo();
                else if (this.id === 'modalEditarRecibo') cerrarModalEditarRecibo();
            }
        });
    });
});
</script>
@endsection