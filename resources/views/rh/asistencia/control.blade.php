@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Control de Horarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Control de Horarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIs - Indicadores de asistencia -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #2378e1; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Total Empleados</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;" id="totalEmpleados">{{ $totalEmpleados ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #28a745; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">En Horario</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;" id="presentes">{{ $presentes ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #ffc107; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #212529; margin-bottom: 3px;">Retardos</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: #212529;" id="retardos">{{ $retardos ?? 0 }}</div>
                    </div>
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 12px 0; background-color: #dc3545; width: 100%; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: white; margin-bottom: 3px;">Ausentes</div>
                        <div style="font-size: 32px; font-weight: bold; line-height: 1.2; color: white;" id="ausentes">{{ $ausentes ?? 0 }}</div>
                    </div>
                </div>

                <!-- Filtros rápidos de fecha -->
                <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 5px; background-color: #f8f9fa; padding: 5px 10px; border-radius: 4px; border: 1px solid #dee2e6;">
                        <i class="fas fa-calendar-alt" style="color: var(--color-primary); font-size: 14px;"></i>
                        <span style="font-size: 13px; font-weight: 500;">Fecha:</span>
                        <span style="font-size: 13px;" id="fechaSeleccionada">{{ \Carbon\Carbon::parse($fecha ?? date('Y-m-d'))->format('d/m/Y') }}</span>
                    </div>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="filtro-fecha" data-fecha="hoy" style="background-color: {{ $fecha == date('Y-m-d') ? 'var(--color-primary)' : 'transparent' }}; color: {{ $fecha == date('Y-m-d') ? 'white' : 'var(--color-primary)' }}; border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Hoy</button>
                        <button class="filtro-fecha" data-fecha="ayer" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Ayer</button>
                        <button class="filtro-fecha" data-fecha="semana" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Esta semana</button>
                        <button class="filtro-fecha" data-fecha="mes" style="background-color: transparent; color: var(--color-primary); border: 1px solid var(--color-primary); padding: 5px 15px; border-radius: 20px; font-size: 12px; cursor: pointer;">Este mes</button>
                    </div>
                    
                    <div style="margin-left: auto; display: flex; gap: 10px;">
                        <div style="position: relative;">
                            <i class="fas fa-calendar" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="date" id="fechaInicio" value="{{ $fecha }}" style="padding: 6px 6px 6px 30px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                        </div>
                        <button id="btnFiltrar" style="background-color: var(--color-primary); color: white; border: none; padding: 6px 15px; border-radius: 4px; font-size: 12px; cursor: pointer;">Filtrar</button>
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
                            <label style="font-size: 12px; color: #6c757d;">Mostrar:</label>
                            <select id="perPage" style="padding: 5px 8px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 12px;">
                                <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        
                        <div>
                            <button id="btnRegistrar" 
                                    style="background-color: var(--color-primary); border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: white;"
                                    onclick="abrirModalRegistroHorario()">
                                <i class="fas fa-clock"></i> Registrar
                            </button>
                        </div>

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
                            <input type="text" id="buscador" placeholder="Buscar por empleado..." value="{{ $search ?? '' }}" style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Control de Horarios -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaHorarios" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1200px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="empleado">Empleado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="puesto">Puesto</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="entrada">Entrada</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="salida">Salida</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="horas">Horas</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 35;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @forelse($registros ?? [] as $registro)
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">
                                    <strong>{{ $registro['empleado_nombre'] ?? 'N/A' }}</strong>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $registro['puesto'] ?? 'N/A' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ \Carbon\Carbon::parse($registro['fecha'])->format('d/m/Y') }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $registro['hora_entrada'] ?? '---' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    {{ $registro['hora_salida'] ?? '---' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;">
                                    {{ $registro['horas_trabajadas'] ?? '0' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    @php
                                        $estado = $registro['estado'] ?? 'ausente';
                                        $badgeClass = '';
                                        $badgeText = '';
                                        switch($estado) {
                                            case 'presente':
                                                $badgeClass = 'badge-presente';
                                                $badgeText = 'Presente';
                                                break;
                                            case 'retardo':
                                                $badgeClass = 'badge-retardo';
                                                $badgeText = 'Retardo';
                                                break;
                                            case 'justificado':
                                                $badgeClass = 'badge-justificado';
                                                $badgeText = 'Justificado';
                                                break;
                                            default:
                                                $badgeClass = 'badge-ausente';
                                                $badgeText = 'Ausente';
                                        }
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">
                                    {{ $registro['observaciones'] ?? '---' }}
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; text-align: center;">
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarRegistro({{ $registro['id'] }})" title="Editar registro"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarRegistro({{ $registro['id'] }})" title="Eliminar registro"></i>
                                    <i class="fas fa-history" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verHistorial({{ $registro['id'] }})" title="Ver historial"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-calendar-alt" style="font-size: 48px; color: #dee2e6; margin-bottom: 15px; display: block;"></i>
                                    No hay registros de asistencia para la fecha seleccionada
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="8" style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: right;">Total Registros:</td>
                                <td style="padding: 12px 8px; border: 1px solid #dee2e6; text-align: center; background-color: #e9ecef;" id="totalRegistros">{{ $total ?? 0 }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(isset($paginador) && $paginador && $paginador->lastPage() > 1)
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div style="font-size: 12px; color: #6c757d;">
                        Mostrando {{ $paginador->firstItem() }} a {{ $paginador->lastItem() }} de {{ $paginador->total() }} registros
                    </div>
                    <div>
                        {{ $paginador->appends(['fecha' => $fecha, 'per_page' => $perPage, 'search' => $search ?? ''])->links() }}
                    </div>
                </div>
                @endif
                
                <!-- Resumen -->
                <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; gap: 20px; font-size: 12px;">
                        <span><strong style="color: #28a745;">✓ En horario:</strong> <span id="resumenPresentes">{{ $presentes ?? 0 }}</span></span>
                        <span><strong style="color: #ffc107;">⚠ Retardos:</strong> <span id="resumenRetardos">{{ $retardos ?? 0 }}</span></span>
                        <span><strong style="color: #dc3545;">✗ Ausentes:</strong> <span id="resumenAusentes">{{ $ausentes ?? 0 }}</span></span>
                        <span><strong style="color: #17a2b8;">📋 Justificados:</strong> <span id="resumenJustificados">{{ $justificados ?? 0 }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA REGISTRO DE ENTRADA/SALIDA -->
<div id="modalRegistroHorario" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Registrar Entrada/Salida</h3>
            <button onclick="cerrarModalRegistroHorario()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 48px; color: var(--color-primary); margin-bottom: 10px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="font-size: 24px; font-weight: bold; color: var(--color-primary);" id="horaActual">--:--:--</div>
                <div style="font-size: 14px; color: #6c757d;" id="fechaActual">--/--/----</div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Empleado *</label>
                    <select id="empleadoId" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar empleado</option>
                        @foreach($empleados ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Tipo de Registro *</label>
                    <div style="display: flex; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro" value="entrada" checked> Entrada
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro" value="salida"> Salida
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="radio" name="tipoRegistro" value="ambos"> Ambos
                        </label>
                    </div>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hora *</label>
                    <input type="time" id="registroHora" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="registroObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalRegistroHorario()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarRegistro()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR REGISTRO -->
<div id="modalEditarRegistro" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 500px;">
        <div style="background: var(--color-primary); padding: 15px 20px; display: flex; justify-content: space-between;">
            <h3 style="color: white; margin: 0;">Editar Registro</h3>
            <button onclick="cerrarModalEditar()" style="background: none; border: none; color: white; font-size: 20px;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="editId">
            <div>
                <label>Hora Entrada</label>
                <input type="time" id="editHoraEntrada" style="width:100%; padding:8px;">
            </div>
            <div style="margin-top: 10px;">
                <label>Hora Salida</label>
                <input type="time" id="editHoraSalida" style="width:100%; padding:8px;">
            </div>
            <div style="margin-top: 10px;">
                <label>Estado</label>
                <select id="editEstado" style="width:100%; padding:8px;">
                    <option value="presente">Presente</option>
                    <option value="retardo">Retardo</option>
                    <option value="ausente">Ausente</option>
                    <option value="justificado">Justificado</option>
                </select>
            </div>
            <div style="margin-top: 10px;">
                <label>Observaciones</label>
                <textarea id="editObservaciones" rows="3" style="width:100%; padding:8px;"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalEditar()" style="padding: 8px 20px; background: white; border: 1px solid #ced4da;">Cancelar</button>
                <button onclick="actualizarRegistro()" style="padding: 8px 20px; background: var(--color-primary); color: white; border: none;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
    }

    .badge-presente { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-retardo { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-ausente { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    .badge-justificado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px; text-align: center; }
    
    .table td:last-child i { margin: 0 5px; cursor: pointer; }
    .table td:last-child i:hover { transform: scale(1.2); }
    .table td:last-child i.fa-edit, .table td:last-child i.fa-history { color: var(--color-primary); }
    .table td:last-child i.fa-trash { color: #dc3545; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; }
    
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 12px; background-color: #e8f0fe; border-radius: 4px; color: var(--color-primary); font-size: 11px; border: 1px solid var(--color-primary); margin-right: 5px; }
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-weight: bold; }
    
    .filtro-fecha { transition: all 0.2s; }
    .filtro-fecha:hover { transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    
    /* Estilos para la paginación */
    .pagination {
        display: inline-flex;
        gap: 5px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .pagination li {
        display: inline-block;
    }
    
    .pagination li a, .pagination li span {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 12px;
        color: var(--color-primary);
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination li a:hover {
        background-color: #e8f0fe;
        border-color: var(--color-primary);
    }
    
    .pagination li.active span {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }
    
    .pagination li.disabled span {
        color: #6c757d;
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    
    #modalRegistroHorario, #modalEditarRegistro { display: none; align-items: center; justify-content: center; }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .hide-mobile { display: none !important; }
        div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
        .table-container { max-height: 500px; }
        .table td { padding: 8px 4px; font-size: 11px; }
        .table td:last-child i { margin: 0 3px; font-size: 12px; }
        .pagination li a, .pagination li span { padding: 4px 8px; font-size: 10px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let registros = @json($registros ?? []);
let empleados = @json($empleados ?? []);
let fechaActual = '{{ $fecha ?? date("Y-m-d") }}';
let perPage = {{ $perPage ?? 10 }};
let searchTerm = '{{ $search ?? '' }}';

function formatearFecha(fechaISO) {
    if (!fechaISO) return '';
    const f = new Date(fechaISO);
    return `${f.getDate().toString().padStart(2,'0')}/${(f.getMonth()+1).toString().padStart(2,'0')}/${f.getFullYear()}`;
}

// Actualizar hora en tiempo real
function actualizarHora() {
    const ahora = new Date();
    const hora = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    const segundos = ahora.getSeconds().toString().padStart(2, '0');
    const horaElement = document.getElementById('horaActual');
    if (horaElement) horaElement.textContent = `${hora}:${minutos}:${segundos}`;
    
    const fechaElement = document.getElementById('fechaActual');
    if (fechaElement) {
        const dia = ahora.getDate().toString().padStart(2, '0');
        const mes = (ahora.getMonth() + 1).toString().padStart(2, '0');
        const año = ahora.getFullYear();
        fechaElement.textContent = `${dia}/${mes}/${año}`;
    }
}

setInterval(actualizarHora, 1000);
actualizarHora();

// Guardar registro
async function guardarRegistro() {
    const empleadoId = document.getElementById('empleadoId').value;
    const tipoRegistro = document.querySelector('input[name="tipoRegistro"]:checked').value;
    const hora = document.getElementById('registroHora').value;
    const observaciones = document.getElementById('registroObservaciones').value;
    
    if (!empleadoId) {
        alert('Por favor seleccione un empleado');
        return;
    }
    if (!hora) {
        alert('Por favor seleccione una hora');
        return;
    }
    
    try {
        const response = await fetch('/rh/control/registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                empleado_id: empleadoId,
                tipo_registro: tipoRegistro,
                hora: hora,
                observaciones: observaciones
            })
        });
        
        const data = await response.json();
        if (data.success) {
            alert(data.message);
            cerrarModalRegistroHorario();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al guardar: ' + error.message);
    }
}

// Editar registro
function editarRegistro(id) {
    const registro = registros.find(r => r.id === id);
    if (registro) {
        document.getElementById('editId').value = id;
        document.getElementById('editHoraEntrada').value = registro.hora_entrada || '';
        document.getElementById('editHoraSalida').value = registro.hora_salida || '';
        document.getElementById('editEstado').value = registro.estado || 'ausente';
        document.getElementById('editObservaciones').value = registro.observaciones || '';
        document.getElementById('modalEditarRegistro').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

async function actualizarRegistro() {
    const id = document.getElementById('editId').value;
    const data = {
        hora_entrada: document.getElementById('editHoraEntrada').value,
        hora_salida: document.getElementById('editHoraSalida').value,
        estado: document.getElementById('editEstado').value,
        observaciones: document.getElementById('editObservaciones').value
    };
    
    try {
        const response = await fetch(`/rh/control/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        if (result.success) {
            alert('Registro actualizado correctamente');
            cerrarModalEditar();
            location.reload();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al actualizar');
    }
}

async function eliminarRegistro(id) {
    if (confirm('¿Está seguro de eliminar este registro?')) {
        try {
            const response = await fetch(`/rh/control/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            if (result.success) {
                alert('Registro eliminado correctamente');
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar');
        }
    }
}

function verHistorial(id) {
    alert('Historial de registro ID: ' + id);
}

// Filtros de fecha
function cargarPorFecha(fecha) {
    const url = new URL(window.location.href);
    url.searchParams.set('fecha', fecha);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

document.querySelectorAll('.filtro-fecha').forEach(btn => {
    btn.addEventListener('click', function() {
        const tipo = this.dataset.fecha;
        let fecha = new Date();
        
        switch(tipo) {
            case 'hoy':
                break;
            case 'ayer':
                fecha.setDate(fecha.getDate() - 1);
                break;
            case 'semana':
                fecha.setDate(fecha.getDate() - 7);
                break;
            case 'mes':
                fecha.setMonth(fecha.getMonth() - 1);
                break;
        }
        
        const fechaStr = fecha.toISOString().split('T')[0];
        cargarPorFecha(fechaStr);
    });
});

document.getElementById('btnFiltrar')?.addEventListener('click', function() {
    const fechaInicio = document.getElementById('fechaInicio').value;
    if (fechaInicio) {
        cargarPorFecha(fechaInicio);
    }
});

// Selector de cantidad de registros por página
document.getElementById('perPage')?.addEventListener('change', function(e) {
    const perPage = e.target.value;
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
});

// Buscador con debounce
let searchTimeout;
document.getElementById('buscador')?.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const term = e.target.value;
    
    searchTimeout = setTimeout(() => {
        const url = new URL(window.location.href);
        if (term) {
            url.searchParams.set('search', term);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }, 500);
});

// Modales
function abrirModalRegistroHorario() {
    document.getElementById('registroHora').value = new Date().toTimeString().slice(0, 5);
    document.getElementById('modalRegistroHorario').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalRegistroHorario() {
    document.getElementById('modalRegistroHorario').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalEditar() {
    document.getElementById('modalEditarRegistro').style.display = 'none';
    document.body.style.overflow = 'auto';
}

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
            const columnas = ['empleado', 'puesto', 'fecha', 'entrada', 'salida', 'horas', 'estatus', 'observaciones'];
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
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalRegistroHorario();
        cerrarModalEditar();
    }
});

document.getElementById('modalRegistroHorario')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalRegistroHorario();
});

document.getElementById('modalEditarRegistro')?.addEventListener('click', function(e) {
    if (e.target === this) cerrarModalEditar();
});
</script>
@endsection