@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Centros de Costos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Centros de Costos
                </h2>
            </div>

            <div class="card-body p-4">
                @php
                    $estadisticas = $estadisticas ?? (object)['total_centros' => 0, 'centros_activos' => 0, 'centros_inactivos' => 0, 'presupuesto_total' => 0];
                    $tiposProyecto = $tiposProyecto ?? collect();
                    $estadosDisponibles = $estadosDisponibles ?? collect();
                    $responsablesList = $responsablesList ?? collect();
                    $proyectos = $proyectos ?? collect();
                    $jerarquia = $jerarquia ?? collect();
                    $distribucionTipos = $distribucionTipos ?? collect();
                    $topCentros = $topCentros ?? collect();
                    $ultimosMovimientos = $ultimosMovimientos ?? collect();
                    $totalPresupuestoGeneral = $totalPresupuestoGeneral ?? 0;
                    $totalEjercido = $totalEjercido ?? 0;
                    $totalDisponible = $totalDisponible ?? 0;
                    $filtroTipo = $filtroTipo ?? '';
                    $filtroEstado = $filtroEstado ?? '';
                    $filtroResponsable = $filtroResponsable ?? '';
                    $search = $search ?? '';
                @endphp

                <!-- 4 CUADROS DE CENTROS DE COSTOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Centros</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="totalCentros">{{ $estadisticas->total_centros ?? 0 }}</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Centros Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="centrosActivos">{{ $estadisticas->centros_activos ?? 0 }}</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Centros Inactivos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold;" id="centrosInactivos">{{ $estadisticas->centros_inactivos ?? 0 }}</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; text-align: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Presupuesto Total</div>
                            <div style="color: #000000; font-size: 28px; font-weight: bold;" id="presupuestoTotal">${{ number_format($estadisticas->presupuesto_total ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con filtros y botones -->
                <form method="GET" action="{{ route('conta.centros') }}" id="filtrosForm">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                            <div>
                                <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Tipo:</span>
                                <select name="tipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                                    <option value="">Todos</option>
                                    @foreach($tiposProyecto as $tipo)
                                        <option value="{{ $tipo }}" {{ $filtroTipo == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Estado:</span>
                                <select name="estado" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 130px;">
                                    <option value="">Todos</option>
                                    @foreach($estadosDisponibles as $estado)
                                        <option value="{{ $estado }}" {{ $filtroEstado == $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Responsable:</span>
                                <select name="responsable" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 180px;">
                                    <option value="">Todos</option>
                                    @foreach($responsablesList as $responsable)
                                        <option value="{{ $responsable->id }}" {{ $filtroResponsable == $responsable->id ? 'selected' : '' }}>{{ $responsable->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <button type="submit" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer;">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('conta.centros') }}" style="background-color: #6c757d; color: white; border-radius: 4px; padding: 8px 16px; text-decoration: none; display: inline-block;">
                                <i class="fas fa-undo"></i> Limpiar
                            </a>
                            <a href="{{ route('conta.centros.exportar', request()->all()) }}" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 8px 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                            <div style="position: relative;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                                <input type="text" name="search" placeholder="Buscar centro..." value="{{ $search }}" style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Pestañas de vista -->
                <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                    <button class="tab-button active" data-tab="lista" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-list" style="margin-right: 8px;"></i> Lista de Centros
                    </button>
                    <button class="tab-button" data-tab="jerarquia" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-sitemap" style="margin-right: 8px;"></i> Vista Jerárquica
                    </button>
                    <button class="tab-button" data-tab="presupuesto" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-chart-pie" style="margin-right: 8px;"></i> Presupuestos
                    </button>
                </div>

                <!-- CONTENIDO: Lista de Centros -->
                <div id="tab-lista" class="tab-content" style="display: block;">
                    @if($proyectos->count() == 0)
                    <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px;">
                        <i class="fas fa-folder-open" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                        <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                        <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay centros de costos para mostrar</p>
                    </div>
                    @else
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 500px;">
                        <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="padding: 12px 10px; text-align: left;">Código</th>
                                    <th style="padding: 12px 10px; text-align: left;">Nombre del Centro</th>
                                    <th style="padding: 12px 10px; text-align: left;">Tipo</th>
                                    <th style="padding: 12px 10px; text-align: left;">Responsable</th>
                                    <th style="padding: 12px 10px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px 10px; text-align: right;">Ejercido</th>
                                    <th style="padding: 12px 10px; text-align: right;">Disponible</th>
                                    <th style="padding: 12px 10px; text-align: center;">%</th>
                                    <th style="padding: 12px 10px; text-align: center;">Estado</th>
                                    <th style="padding: 12px 10px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proyectos as $proyecto)
                                <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">
                                    <td style="padding: 10px;"><strong>{{ $proyecto->codigo }}</strong></td>
                                    <td style="padding: 10px;">{{ $proyecto->nombre }}</td>
                                    <td style="padding: 10px;">{{ $proyecto->tipo ?? '-' }}</td>
                                    <td style="padding: 10px;">{{ $proyecto->responsable_nombre ?? 'No asignado' }}</td>
                                    <td style="padding: 10px; text-align: right;">{{ $proyecto->presupuesto_formateado }}</td>
                                    <td style="padding: 10px; text-align: right;">{{ $proyecto->ejercido_formateado }}</td>
                                    <td style="padding: 10px; text-align: right;">{{ $proyecto->disponible_formateado }}</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: {{ $proyecto->porcentaje }}%; height: 100%; background-color: {{ $proyecto->barra_color }};"></div>
                                        </div>
                                        {{ $proyecto->porcentaje }}%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge {{ $proyecto->badge_class }}">{{ ucfirst($proyecto->estado ?? 'Desconocido') }}</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" data-id="{{ $proyecto->id }}" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" data-id="{{ $proyecto->id }}" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" data-id="{{ $proyecto->id }}" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <!-- CONTENIDO: Vista Jerárquica -->
                <div id="tab-jerarquia" class="tab-content" style="display: none;">
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                        <div style="margin-bottom: 20px;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-sitemap mr-2"></i> Estructura por Tipo de Proyecto
                            </h4>
                            <p style="color: #6c757d; font-size: 13px; margin-bottom: 20px;">
                                Agrupación de proyectos por categoría
                            </p>
                        </div>

                        @foreach($jerarquia as $grupo)
                        <div style="margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; padding: 12px 15px; background-color: #2378e1; color: white; border-radius: 8px; font-weight: bold;">
                                <i class="fas fa-folder mr-3"></i>
                                <span>{{ $grupo->tipo_proyecto ?? 'Sin clasificar' }}</span>
                                <span style="margin-left: auto; font-size: 12px; background-color: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px;">
                                    {{ $grupo->cantidad }} proyectos - {{ $grupo->presupuesto_formateado }}
                                </span>
                            </div>
                            <div style="margin-left: 25px; margin-top: 10px;">
                                @foreach($grupo->proyectos as $proyecto)
                                <div style="display: flex; align-items: center; padding: 8px 15px; background-color: #f8f9fa; margin-bottom: 5px; border-left: 3px solid #28a745; border-radius: 0 5px 5px 0;">
                                    <i class="fas fa-project-diagram mr-3" style="color: #6c757d;"></i>
                                    <span><strong>{{ $proyecto->codigo }}</strong> - {{ $proyecto->nombre }}</span>
                                    <span style="margin-left: auto; font-size: 12px; color: #083CAE;">{{ $proyecto->presupuesto_formateado }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- CONTENIDO: Presupuestos -->
                <div id="tab-presupuesto" class="tab-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <!-- Gráfico de distribución -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-chart-pie mr-2"></i> Distribución por Tipo
                            </h4>
                            <div>
                                @foreach($distribucionTipos as $tipo)
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <div style="width: 120px; font-size: 13px;">{{ $tipo->tipo_proyecto ?? 'Sin clasificar' }}</div>
                                    <div style="flex: 1; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 10px;">
                                        <div style="width: {{ $tipo->porcentaje }}%; height: 100%; background-color: #2378e1; border-radius: 10px;"></div>
                                    </div>
                                    <div style="width: 100px; text-align: right; font-size: 13px; font-weight: 600;">{{ $tipo->total_formateado }}</div>
                                </div>
                                @endforeach
                            </div>
                            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                                <div style="display: flex; justify-content: space-between; font-weight: 700; color: #083CAE;">
                                    <span>Presupuesto Total:</span>
                                    <span>${{ number_format($totalPresupuestoGeneral, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                    <span>Ejercido:</span>
                                    <span class="text-danger">${{ number_format($totalEjercido, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-weight: 600;">
                                    <span>Disponible:</span>
                                    <span class="text-success">${{ number_format($totalDisponible, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Top 5 Centros -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-chart-line mr-2"></i> Top 5 Centros por Presupuesto
                            </h4>
                            <table style="width: 100%; font-size: 13px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #dee2e6;">
                                        <th style="padding: 8px; text-align: left;">Centro</th>
                                        <th style="padding: 8px; text-align: right;">Presupuesto</th>
                                        <th style="padding: 8px; text-align: right;">Ejercido</th>
                                        <th style="padding: 8px; text-align: right;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topCentros as $centro)
                                    <tr>
                                        <td style="padding: 8px;">{{ $centro->codigo }} - {{ $centro->nombre }}</td>
                                        <td style="padding: 8px; text-align: right;">{{ $centro->presupuesto_formateado }}</td>
                                        <td style="padding: 8px; text-align: right;">{{ $centro->ejercido_formateado ?? '$0.00' }}</td>
                                        <td style="padding: 8px; text-align: right;">{{ $centro->porcentaje ?? 0 }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla de movimientos por centro -->
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; margin-top: 20px;">
                        <div style="background-color: #f1f5f9; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin: 0;">
                                <i class="fas fa-exchange-alt mr-2"></i> Últimos Movimientos
                            </h4>
                        </div>
                        @if($ultimosMovimientos->count() > 0)
                        <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="padding: 12px 10px; text-align: left;">Fecha</th>
                                    <th style="padding: 12px 10px; text-align: left;">Centro de Costos</th>
                                    <th style="padding: 12px 10px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px 10px; text-align: right;">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosMovimientos as $mov)
                                <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#f8f9fa' : '#ffffff' }};">
                                    <td style="padding: 10px;">{{ $mov->fecha_formateada }}</td>
                                    <td style="padding: 10px;">{{ $mov->centro_codigo }} - {{ $mov->centro_nombre }}</td>
                                    <td style="padding: 10px;">{{ $mov->concepto ?? '-' }}</td>
                                    <td style="padding: 10px; text-align: right;">{{ $mov->monto_formateado }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="padding: 30px; text-align: center; color: #6c757d;">
                            <i class="fas fa-info-circle"></i> No hay movimientos registrados
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 10px;">
                    <span style="color: #6c757d; font-size: 14px;">Mostrando {{ $proyectos->count() }} centros</span>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
    }
    
    .badge-inactivo {
        background-color: #dc3545;
        color: white;
    }
    
    .tab-button {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin-bottom: -2px;
    }
    
    .tab-button:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .tab-button.active {
        background-color: #083CAE !important;
        color: white !important;
        border-color: #083CAE;
    }
    
    .fa-eye:hover, .fa-edit:hover, .fa-chart-line:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    
    .fa-eye:hover { color: #0056b3 !important; }
    .fa-edit:hover { color: #e0a800 !important; }
    .fa-chart-line:hover { color: #117a8b !important; }
    
    @media (max-width: 768px) {
        [style*="flex: 0 1 calc(25% - 15px)"] {
            flex: 0 1 calc(50% - 15px) !important;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        input, select {
            width: 100% !important;
        }
        
        #buscador {
            width: 100% !important;
        }
        
        table {
            font-size: 11px;
        }
        
        td, th {
            padding: 6px !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Centros de Costos');
        
        // Manejo de pestañas
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function showTab(tabId) {
            tabContents.forEach(content => {
                content.style.display = 'none';
            });
            tabButtons.forEach(button => {
                button.classList.remove('active');
                button.style.backgroundColor = '#e9ecef';
                button.style.color = '#495057';
            });
            document.getElementById(`tab-${tabId}`).style.display = 'block';
            const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
            activeButton.classList.add('active');
            activeButton.style.backgroundColor = '#083CAE';
            activeButton.style.color = 'white';
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.dataset.tab;
                showTab(tabId);
            });
        });

        // Auto-submit cuando cambian los filtros
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('change', () => document.getElementById('filtrosForm').submit());
        });
        
        // Buscador con debounce
        const buscador = document.querySelector('input[name="search"]');
        if (buscador) {
            let timeout;
            buscador.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => document.getElementById('filtrosForm').submit(), 500);
            });
        }
        
        // Acciones de iconos
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver detalle del centro');
            });
        });
        
        document.querySelectorAll('.fa-edit').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Editar centro');
            });
        });
        
        document.querySelectorAll('.fa-chart-line').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver movimientos del centro');
            });
        });
    });
</script>
@endsection