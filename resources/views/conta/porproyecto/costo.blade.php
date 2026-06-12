@extends('layouts.navigation')

@section('content')
<div class="content-wrapper" style="min-height: 100vh; background-color: #f8f9fa;">
    <section class="content">
        <div class="container-fluid py-4">
            <!-- Costos por Obra -->
            <div class="semaforo card">
                <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                    <div style="display: flex; justify-content: center; align-items: center; position: relative;">
                        <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                            Costos por Obra
                        </h2>
                        <div style="position: absolute; right: 0; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #083CAE; font-size: 14px;">Obra:</span>
                            <select id="obraSelect" style="padding: 6px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; background-color: white; color: #083CAE; font-weight: 500; width: 250px;">
                                <option value="">-- Seleccione una obra --</option>
                                @foreach($obras as $obra)
                                    <option value="{{ $obra->id }}" {{ $proyectoId == $obra->id ? 'selected' : '' }}>
                                        {{ $obra->codigo }} - {{ $obra->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Formulario único -->
                    <form method="GET" action="{{ route('conta.costo') }}" id="filtrosForm">
                        <input type="hidden" name="proyecto_id" id="hiddenProyectoId" value="{{ $proyectoId }}">
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <span style="font-size: 13px; color: #6c757d;">Fecha inicio:</span>
                                    <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background-color: white;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <span style="font-size: 13px; color: #6c757d;">Fecha fin:</span>
                                    <input type="date" name="fecha_fin" value="{{ $fechaFin }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background-color: white;">
                                </div>
                                <button type="submit" id="btnConsultar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-search"></i> Consultar
                                </button>
                                <a href="{{ route('conta.costo') }}" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-undo"></i> Limpiar
                                </a>
                            </div>
                            
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('conta.costo.exportar', request()->all()) }}" id="btnExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Exportar a Excel">
                                    <i class="fas fa-file-excel"></i>
                                </a>
                                <button id="btnPDF" type="button" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Exportar a PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Información de la obra seleccionada -->
                    <div style="margin-bottom: 25px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <i class="fas fa-hard-hat" style="color: #083CAE; font-size: 24px;"></i>
                                <div>
                                    <span style="font-weight: bold; color: #083CAE; font-size: 16px;" id="obraNombre">{{ $obraSeleccionada->nombre ?? 'Seleccione una obra' }}</span>
                                    <span style="color: #6c757d; font-size: 12px; display: block;">
                                        Código: {{ $obraSeleccionada->codigo ?? '-' }} | 
                                        Cliente: {{ $obraSeleccionada->cliente_nombre ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 20px;">
                                <div style="text-align: right;">
                                    <div style="font-size: 11px; color: #6c757d;">Presupuesto Original</div>
                                    <div style="font-size: 16px; font-weight: bold; color: #083CAE;">${{ number_format($presupuestoOriginal, 2) }}</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 11px; color: #6c757d;">Avance Físico</div>
                                    <div style="font-size: 16px; font-weight: bold; color: #28a745;">{{ $avanceFisico }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de costos - 4 cuadros -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Costo Directo</div>
                            <div style="font-size: 20px; font-weight: bold;">${{ number_format($costoDirecto, 2) }}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Indirectos</div>
                            <div style="font-size: 20px; font-weight: bold;">${{ number_format($indirectos, 2) }}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Costo Real</div>
                            <div style="font-size: 20px; font-weight: bold;">${{ number_format($costoReal, 2) }}</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Variación</div>
                            <div style="font-size: 20px; font-weight: bold; color: {{ $variacion >= 0 ? '#28a745' : '#dc3545' }};">{{ $variacionPrefijo }}${{ number_format(abs($variacion), 2) }}</div>
                        </div>
                    </div>

                    <!-- Pestañas -->
                    <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                        <button class="tab-button active" data-tab="apu" type="button" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                            <i class="fas fa-calculator" style="margin-right: 8px;"></i> Análisis de Precios Unitarios
                        </button>
                        <button class="tab-button" data-tab="insumos" type="button" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                            <i class="fas fa-cubes" style="margin-right: 8px;"></i> Explosión de Insumos
                        </button>
                    </div>

                    <!-- Tabla de APU -->
                    <div id="tab-apu" class="tab-content" style="display: block;">
                        @if($conceptos->count() == 0)
                        <div style="text-align: center; padding: 40px; background-color: #f8f9fa; border-radius: 8px;">
                            <i class="fas fa-info-circle" style="font-size: 48px; color: #ced4da;"></i>
                            <p style="margin-top: 15px; color: #6c757d;">No hay conceptos registrados para esta obra</p>
                        </div>
                        @else
                        <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 450px;">
                            <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #2378e1;">
                                    <tr>
                                        <th style="padding: 12px 8px; color: white; text-align: left;">Código</th>
                                        <th style="padding: 12px 8px; color: white; text-align: left;">Concepto</th>
                                        <th style="padding: 12px 8px; color: white; text-align: center;">Unidad</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">Cantidad</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">P.U.</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conceptos as $concepto)
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">{{ $concepto->codigo }}</td>
                                        <td style="padding: 10px;">{{ $concepto->concepto }}</td>
                                        <td style="padding: 10px; text-align: center;">{{ $concepto->unidad }}</td>
                                        <td style="padding: 10px; text-align: right;">{{ $concepto->cantidad_formateada }}</td>
                                        <td style="padding: 10px; text-align: right;">{{ $concepto->pu_formateado }}</td>
                                        <td style="padding: 10px; text-align: right;">{{ $concepto->importe_formateado }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background-color: #e9ecef;">
                                    <tr>
                                        <td colspan="5" style="padding: 12px 8px; text-align: right; font-weight: bold;">TOTAL COSTO DIRECTO:</td>
                                        <td style="padding: 12px 8px; text-align: right; font-weight: bold;">${{ number_format($totalCostoDirecto, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                    </div>

                    <!-- Tabla de Insumos -->
                    <div id="tab-insumos" class="tab-content" style="display: none;">
                        @if($insumos->count() == 0)
                        <div style="text-align: center; padding: 40px; background-color: #f8f9fa; border-radius: 8px;">
                            <i class="fas fa-info-circle" style="font-size: 48px; color: #ced4da;"></i>
                            <p style="margin-top: 15px; color: #6c757d;">No hay insumos registrados para esta obra</p>
                            <p style="font-size: 12px; color: #adb5bd;">Nota: Se requiere la tabla proyecto_partida_insumos para esta funcionalidad</p>
                        </div>
                        @else
                        <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 450px;">
                            <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; background-color: #2378e1;">
                                    <tr>
                                        <th style="padding: 12px 8px; color: white; text-align: left;">Código</th>
                                        <th style="padding: 12px 8px; color: white; text-align: left;">Insumo</th>
                                        <th style="padding: 12px 8px; color: white; text-align: center;">Unidad</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">Cant. Presup.</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">Cant. Real</th>
                                        <th style="padding: 12px 8px; color: white; text-align: right;">Variación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($insumos as $insumo)
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">{{ $insumo->codigo }}</td>
                                        <td style="padding: 10px;">{{ $insumo->insumo }}</td>
                                        <td style="padding: 10px; text-align: center;">{{ $insumo->unidad }}</td>
                                        <td style="padding: 10px; text-align: right;">{{ $insumo->cantidad_presupuestada_formateada }}</td>
                                        <td style="padding: 10px; text-align: right;">{{ $insumo->cantidad_real_formateada }}</td>
                                        <td style="padding: 10px; text-align: right;" class="{{ $insumo->variacion_clase }}">{{ $insumo->variacion_formateada }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- Programa de Suministros -->
                        <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; font-size: 15px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-truck mr-2"></i> Programa de Suministros
                            </h4>
                            <form method="GET" action="{{ route('conta.costo') }}" id="programaForm" style="display: inline;">
                                <input type="hidden" name="proyecto_id" value="{{ $proyectoId }}">
                                <input type="hidden" name="fecha_inicio" value="{{ $fechaInicio }}">
                                <input type="hidden" name="fecha_fin" value="{{ $fechaFin }}">
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <input type="date" name="programa_inicio" value="{{ request('programa_inicio', date('Y-m-01')) }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                    <input type="date" name="programa_fin" value="{{ request('programa_fin', date('Y-m-t')) }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                    <button type="submit" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                        <i class="fas fa-calendar-alt mr-2"></i> Generar Programa
                                    </button>
                                </div>
                            </form>
                            
                            @if($programaSuministros->count() > 0)
                            <div style="margin-top: 20px;">
                                <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background-color: #e9ecef;">
                                            <th style="padding: 8px; text-align: left;">Código</th>
                                            <th style="padding: 8px; text-align: left;">Insumo</th>
                                            <th style="padding: 8px; text-align: center;">Unidad</th>
                                            <th style="padding: 8px; text-align: right;">Cantidad Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($programaSuministros as $item)
                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                            <td style="padding: 6px;">{{ $item->codigo }}</td>
                                            <td style="padding: 6px;">{{ $item->insumo }}</td>
                                            <td style="padding: 6px; text-align: center;">{{ $item->unidad }}</td>
                                            <td style="padding: 6px; text-align: right;">{{ $item->cantidad_formateada }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Nota al pie -->
                    <div style="margin-top: 20px; font-size: 11px; color: #6c757d; text-align: center; border-top: 1px solid #dee2e6; padding-top: 15px;">
                        <i class="fas fa-info-circle" style="color: #083CAE;"></i>
                        Costos correspondientes al período del {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                        @if($obraSeleccionada)
                        - Obra: {{ $obraSeleccionada->nombre ?? '' }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
        border-radius: 8px 8px 0 0;
    }
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .semaforo.card {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border: none;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .card-body {
        padding: 25px;
    }
    
    .tab-button {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin-bottom: -2px;
    }
    
    .tab-button:hover:not(.active) {
        background-color: #d3d9e0 !important;
        transform: translateY(-2px);
    }
    
    .tab-button.active {
        background-color: #083CAE !important;
        color: white !important;
        border-color: #083CAE;
    }
    
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(8, 60, 174, 0.15) !important;
    }
    
    #btnConsultar, #btnExcel, #btnPDF {
        transition: all 0.3s ease;
    }
    
    #btnConsultar:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #btnExcel:hover, #btnPDF:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        white-space: nowrap;
    }
    
    td {
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e3f2fd !important;
    }
    
    tfoot td {
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        font-weight: bold;
    }
    
    select, input[type="date"] {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    select:hover, input[type="date"]:hover {
        border-color: #2CBF1F !important;
    }
    
    select:focus, input[type="date"]:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #0a4ad0;
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="display: flex; justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .tab-button {
            flex: 1;
            text-align: center;
            padding: 10px !important;
            font-size: 12px !important;
        }
        
        [style*="position: absolute; right: 0"] {
            position: static !important;
            margin-top: 10px;
        }
        
        .semaforo .card-header div {
            flex-direction: column;
        }
        
        [style*="min-width: 250px"] {
            min-width: 100% !important;
        }
        
        #btnConsultar, #btnExcel, #btnPDF {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Costos por Obra - Inicializado correctamente');
        
        const form = document.getElementById('filtrosForm');
        const obraSelect = document.getElementById('obraSelect');
        const hiddenProyectoId = document.getElementById('hiddenProyectoId');
        const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
        const fechaFin = document.querySelector('input[name="fecha_fin"]');
        
        // Al cambiar la obra, actualizar el hidden y enviar el formulario
        if (obraSelect) {
            obraSelect.addEventListener('change', function() {
                // Actualizar el hidden con el valor seleccionado
                hiddenProyectoId.value = this.value;
                // Enviar el formulario
                form.submit();
            });
        }
        
        // Auto-submit al cambiar fechas
        if (fechaInicio) {
            fechaInicio.addEventListener('change', function() {
                form.submit();
            });
        }
        
        if (fechaFin) {
            fechaFin.addEventListener('change', function() {
                form.submit();
            });
        }
        
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
            const activeTab = document.getElementById(`tab-${tabId}`);
            if (activeTab) activeTab.style.display = 'block';
            const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
                activeButton.style.backgroundColor = '#083CAE';
                activeButton.style.color = 'white';
            }
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.dataset.tab;
                showTab(tabId);
            });
        });

        // Mostrar APU por defecto
        showTab('apu');

        // Botón PDF (simulación)
        document.getElementById('btnPDF')?.addEventListener('click', function() {
            alert('Exportando costos de obra a PDF...');
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });
    });
</script>
@endsection