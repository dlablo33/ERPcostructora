@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estado de Resultados por Unidad de Negocio -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h1 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 28px; text-align: center;">
                    Estado de Resultados por Unidad de Negocio
                </h1>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y botón Excel -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-bottom: 25px; flex-wrap: wrap;">
                    <!-- Filtro Unidad de Negocio - MÚLTIPLE -->
                    <div style="position: relative;">
                        <button id="btnSeleccionarUnidades" type="button" class="btn" style="background-color: #083CAE; color: white; border: none; padding: 6px 15px; border-radius: 4px;">
                            <i class="fas fa-check-square"></i> Unidades de Negocio 
                            <span id="unidadesCount" class="badge" style="background-color: #ffc107; color: #333; margin-left: 5px;">0</span>
                        </button>
                        <div id="panelUnidades" class="dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 8px; width: 320px; max-height: 420px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top: 5px;">
                            <div style="padding: 12px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                <div style="display: flex; gap: 10px;">
                                    <button id="btnSeleccionarTodasUnidades" type="button" class="btn btn-sm" style="background-color: #28a745; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                        <i class="fas fa-check-double"></i> Todas
                                    </button>
                                    <button id="btnLimpiarUnidades" type="button" class="btn btn-sm" style="background-color: #6c757d; color: white; border: none; padding: 5px 12px; border-radius: 4px;">
                                        <i class="fas fa-times"></i> Ninguna
                                    </button>
                                </div>
                            </div>
                            <div id="listaUnidades" style="padding: 10px; max-height: 320px; overflow-y: auto;">
                                @foreach($unidades as $unidad)
                                    <div class="checkbox-item" style="margin-bottom: 8px; padding: 6px; border-radius: 6px;">
                                        <label style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                                            <input type="checkbox" class="unidad-checkbox" value="{{ $unidad->cat_unidad_negocio_id }}" 
                                                data-clave="{{ $unidad->clave }}"
                                                data-nombre="{{ $unidad->descripcion }}"
                                                {{ in_array($unidad->cat_unidad_negocio_id, $unidadesSeleccionadas) ? 'checked' : '' }}
                                                style="margin-right: 10px;">
                                            <span style="font-size: 12px;">
                                                <strong>{{ $unidad->clave }}</strong> - {{ $unidad->descripcion }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Filtro Año-Mes combinado -->
                    <div style="display: flex; border: 1px solid #083CAE; border-radius: 4px; overflow: hidden;">
                        <select id="mes" style="padding: 6px 10px; border: none; font-size: 13px; background-color: white; width: 120px; border-right: 1px solid #dee2e6;">
                            @foreach($meses as $num => $nombre)
                                <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <select id="anio" style="padding: 6px 10px; border: none; font-size: 13px; background-color: white; width: 90px;">
                            @foreach($aniosDisponibles as $year)
                                <option value="{{ $year }}" {{ $anio == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón Excel -->
                    <button id="btnExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>

                <!-- Pestañas -->
                <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                    <button class="tab-button active" data-tab="resultados" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-chart-line" style="margin-right: 8px;"></i>Estado de Resultados
                    </button>
                    <button class="tab-button" data-tab="configuracion" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-cog" style="margin-right: 8px;"></i>Configuración
                    </button>
                </div>

                <!-- ============================================ -->
                <!-- PESTAÑA: ESTADO DE RESULTADOS -->
                <!-- ============================================ -->
                <div id="tab-resultados" class="tab-content" style="display: block;">
                    <!-- Indicador de carga -->
                    <div id="loadingIndicator" style="display: none; text-align: center; padding: 20px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #083CAE;"></i> Cargando datos...
                    </div>

                    <!-- Cards de KPIs - Enfocados en Construcción -->
                    <div id="kpisContainer" style="margin-bottom: 30px;">
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 15px;">
                            <div style="background-color: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">PROYECTOS ACTIVOS</div>
                                <div id="totalProyectos" style="font-size: 28px; font-weight: bold; color: #007bff;">0</div>
                            </div>
                            <div style="background-color: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">PRESUPUESTO TOTAL</div>
                                <div id="presupuestoTotal" style="font-size: 28px; font-weight: bold; color: #007bff;">$0</div>
                            </div>
                            <div style="background-color: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">AVANCE PROMEDIO</div>
                                <div id="avancePromedio" style="font-size: 28px; font-weight: bold; color: #28a745;">0%</div>
                            </div>
                            <div style="background-color: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">MARGEN DE UTILIDAD</div>
                                <div id="margenUtilidad" style="font-size: 28px; font-weight: bold; color: #17a2b8;">0%</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Estado de Resultados -->
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto;">
                        <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="padding: 12px 15px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px 15px; text-align: right;">Monto</th>
                                    <th style="padding: 12px 15px; text-align: right;">%</th>
                                    <th style="padding: 12px 15px; text-align: right;">Presupuestado</th>
                                    <th style="padding: 12px 15px; text-align: right;">Variación</th>
                                </tr>
                            </thead>
                            <tbody id="tablaResultadosBody">
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-info-circle"></i> Seleccione una unidad de negocio y período para ver datos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- PESTAÑA: CONFIGURACIÓN -->
                <!-- ============================================ -->
                <div id="tab-configuracion" class="tab-content" style="display: none;">
                    <div style="max-width: 900px;">
                        <!-- Selector de Unidad -->
                        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                            <label style="font-weight: 600;">Unidad de Negocio:</label>
                            <select id="configUnidadSelect" style="padding: 8px 15px; border: 1px solid #083CAE; border-radius: 4px; min-width: 200px;">
                                <option value="">Seleccione una unidad</option>
                                @foreach($unidades as $unidad)
                                    <option value="{{ $unidad->cat_unidad_negocio_id }}">{{ $unidad->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Contenedor de Configuración -->
                        <div id="configContenido">
                            <div style="text-align: center; padding: 40px; color: #6c757d;">
                                <i class="fas fa-info-circle"></i> Seleccione una unidad de negocio para configurar sus conceptos
                            </div>
                        </div>
                        
                        <!-- Botón Guardar -->
                        <div style="margin-top: 30px; text-align: center;">
                            <button id="btnGuardarConfigGlobal" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 12px 50px; font-size: 16px; font-weight: 600; cursor: pointer;">
                                Guardar Configuración
                            </button>
                        </div>
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
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th {
        background-color: #2378e1;
        color: white;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .table td {
        border: 1px solid #dee2e6;
    }
    
    .table tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    
    .text-right {
        text-align: right;
    }
    
    .checkbox-item:hover {
        background-color: #e8f0fe;
    }
    
    .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
    }
    
    #btnExcel, #btnGuardarConfigGlobal {
        transition: all 0.3s ease;
    }
    
    #btnExcel:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #btnGuardarConfigGlobal:hover {
        background-color: #0a4ad0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 60, 174, 0.3);
    }
    
    /* Estilos para la configuración */
    .config-header {
        transition: all 0.3s ease;
    }
    
    .config-header:hover {
        background-color: #e9ecef !important;
    }
    
    .config-body {
        border-top: 1px solid #dee2e6;
    }
    
    .config-porcentaje {
        transition: all 0.2s ease;
    }
    
    .config-porcentaje:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }
    
    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // MANEJO DE PESTAÑAS
        // ============================================
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
            if (activeButton) {
                activeButton.classList.add('active');
                activeButton.style.backgroundColor = '#083CAE';
                activeButton.style.color = 'white';
            }
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                showTab(this.dataset.tab);
            });
        });

        showTab('resultados');

        // ============================================
        // PANEL DE UNIDADES DE NEGOCIO
        // ============================================
        const btnSeleccionarUnidades = document.getElementById('btnSeleccionarUnidades');
        const panelUnidades = document.getElementById('panelUnidades');
        
        if (btnSeleccionarUnidades) {
            btnSeleccionarUnidades.addEventListener('click', function(e) {
                e.stopPropagation();
                panelUnidades.style.display = panelUnidades.style.display === 'none' ? 'block' : 'none';
            });
        }
        
        document.addEventListener('click', function(event) {
            if (panelUnidades && btnSeleccionarUnidades) {
                if (!panelUnidades.contains(event.target) && !btnSeleccionarUnidades.contains(event.target)) {
                    panelUnidades.style.display = 'none';
                }
            }
        });
        
        function actualizarContadorUnidades() {
            const checkboxes = document.querySelectorAll('.unidad-checkbox:checked');
            const count = checkboxes.length;
            const countSpan = document.getElementById('unidadesCount');
            if (countSpan) {
                countSpan.textContent = count;
                countSpan.style.backgroundColor = count > 0 ? '#28a745' : '#ffc107';
            }
        }
        
        document.getElementById('btnSeleccionarTodasUnidades')?.addEventListener('click', function() {
            document.querySelectorAll('.unidad-checkbox').forEach(cb => cb.checked = true);
            actualizarContadorUnidades();
            if (panelUnidades) panelUnidades.style.display = 'none';
            cargarDatos();
        });
        
        document.getElementById('btnLimpiarUnidades')?.addEventListener('click', function() {
            document.querySelectorAll('.unidad-checkbox').forEach(cb => cb.checked = false);
            actualizarContadorUnidades();
            if (panelUnidades) panelUnidades.style.display = 'none';
            cargarDatos();
        });
        
        document.querySelectorAll('.unidad-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                actualizarContadorUnidades();
                cargarDatos();
            });
        });
        
        actualizarContadorUnidades();
        
        // ============================================
        // FUNCIÓN PARA CARGAR DATOS
        // ============================================
        function cargarDatos() {
            const checkboxes = document.querySelectorAll('.unidad-checkbox:checked');
            const unidades = Array.from(checkboxes).map(cb => cb.value).join(',');
            const mes = document.getElementById('mes').value;
            const anio = document.getElementById('anio').value;
            
            const loadingIndicator = document.getElementById('loadingIndicator');
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            
            fetch(`/conta/unidad/data?anio=${anio}&mes=${mes}&unidades=${unidades}`)
                .then(response => response.json())
                .then(data => {
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    
                    if (data.success) {
                        // Actualizar KPIs de Construcción
                        document.getElementById('totalProyectos').textContent = data.kpis.total_proyectos || 0;
                        document.getElementById('presupuestoTotal').textContent = data.kpis.presupuesto_total ? '$' + formatNumber(data.kpis.presupuesto_total) : '$0';
                        document.getElementById('avancePromedio').textContent = (data.kpis.avance_promedio || 0).toFixed(2) + '%';
                        
                        // Calcular margen de utilidad
                        const utilidad = data.resultados.utilidad || 0;
                        const totalIngresos = data.total_ingresos || 0;
                        const margen = totalIngresos > 0 ? (utilidad / totalIngresos) * 100 : 0;
                        document.getElementById('margenUtilidad').textContent = margen.toFixed(2) + '%';
                        
                        actualizarTabla(data);
                    } else {
                        console.error('Error:', data.message);
                        document.getElementById('tablaResultadosBody').innerHTML = `
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #dc3545;">
                                    <i class="fas fa-exclamation-triangle"></i> Error: ${data.message || 'No se pudieron cargar los datos'}
                                <\/td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    console.error('Error:', error);
                    document.getElementById('tablaResultadosBody').innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #dc3545;">
                                <i class="fas fa-exclamation-triangle"></i> Error al conectar con el servidor
                            <\/td>
                        </tr>
                    `;
                });
        }
        
        function formatNumber(value) {
            if (value === undefined || value === null) return '0';
            return Math.round(value).toLocaleString('en-US');
        }
        
        function actualizarTabla(data) {
            const tbody = document.getElementById('tablaResultadosBody');
            const totalIngresos = data.total_ingresos || 0;
            const resultados = data.resultados;
            
            if (!resultados || (resultados.gastos && resultados.gastos.length === 0 && totalIngresos === 0)) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px;">
                            <i class="fas fa-info-circle"></i> No hay datos para el período seleccionado
                        <\/td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            
            // INGRESOS TOTALES
            html += `
                <tr style="background-color: #e3f2fd; font-weight: bold;">
                    <td style="padding: 12px 15px;">INGRESOS TOTALES<\/td>
                    <td style="padding: 12px 15px; text-align: right;">$${formatNumber(totalIngresos)}<\/td>
                    <td style="padding: 12px 15px; text-align: right;">100.00%<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                </tr>
            `;
            
            // COSTO DIRECTO DE OPERACIÓN (TOTAL GASTOS)
            const totalGastos = resultados.total_gastos || 0;
            const porcentajeGastos = totalIngresos > 0 ? (totalGastos / totalIngresos) * 100 : 0;
            
            html += `
                <tr style="background-color: #fff3e0;">
                    <td style="padding: 12px 15px; font-weight: 600; color: #d32f2f;">COSTO DIRECTO DE OPERACIÓN<\/td>
                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">$${formatNumber(totalGastos)}<\/td>
                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">${porcentajeGastos.toFixed(2)}%<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                </tr>
            `;
            
            // DETALLE DE GASTOS - Agrupados por categoría
            if (resultados.gastos && resultados.gastos.length > 0) {
                // Materiales directos primero
                const materiales = resultados.gastos.filter(g => g.concepto === 'Materiales Directos' || g.codigo === '501.01');
                const otrosGastos = resultados.gastos.filter(g => g.concepto !== 'Materiales Directos' && g.codigo !== '501.01');
                
                materiales.forEach(gasto => {
                    const porcentaje = totalIngresos > 0 ? (gasto.monto / totalIngresos) * 100 : 0;
                    html += `
                        <tr>
                            <td style="padding: 12px 15px; padding-left: 30px;">${gasto.concepto}<\/td>
                            <td style="padding: 12px 15px; text-align: right;">$${formatNumber(gasto.monto)}<\/td>
                            <td style="padding: 12px 15px; text-align: right;">${porcentaje.toFixed(2)}%<\/td>
                            <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                            <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                        </tr>
                    `;
                });
                
                // Mano de obra
                otrosGastos.forEach(gasto => {
                    const porcentaje = totalIngresos > 0 ? (gasto.monto / totalIngresos) * 100 : 0;
                    html += `
                        <tr>
                            <td style="padding: 12px 15px; padding-left: 30px;">${gasto.concepto}<\/td>
                            <td style="padding: 12px 15px; text-align: right;">$${formatNumber(gasto.monto)}<\/td>
                            <td style="padding: 12px 15px; text-align: right;">${porcentaje.toFixed(2)}%<\/td>
                            <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                            <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                        <tr>
                    `;
                });
            }
            
            // UTILIDAD
            const utilidad = resultados.utilidad || 0;
            const utilidadClass = utilidad >= 0 ? '#2e7d32' : '#d32f2f';
            const utilidadBg = utilidad >= 0 ? '#c8e6c9' : '#ffcdd2';
            const porcentajeUtilidad = totalIngresos > 0 ? (utilidad / totalIngresos) * 100 : 0;
            
            html += `
                <tr style="background-color: ${utilidadBg}; font-weight: bold;">
                    <td style="padding: 12px 15px; color: ${utilidadClass};">UTILIDAD DEL EJERCICIO<\/td>
                    <td style="padding: 12px 15px; text-align: right; color: ${utilidadClass};">$${formatNumber(utilidad)}<\/td>
                    <td style="padding: 12px 15px; text-align: right; color: ${utilidadClass};">${porcentajeUtilidad.toFixed(2)}%<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                    <td style="padding: 12px 15px; text-align: right;">&nbsp;<\/td>
                </tr>
            `;
            
            tbody.innerHTML = html;
        }
        
        // ============================================
        // EVENTOS DE FILTROS
        // ============================================
        const mesSelect = document.getElementById('mes');
        const anioSelect = document.getElementById('anio');
        
        if (mesSelect) mesSelect.addEventListener('change', cargarDatos);
        if (anioSelect) anioSelect.addEventListener('change', cargarDatos);
        
        // ============================================
        // BOTÓN EXPORTAR EXCEL
        // ============================================
        const btnExcel = document.getElementById('btnExcel');
        if (btnExcel) {
            btnExcel.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.unidad-checkbox:checked');
                const unidades = Array.from(checkboxes).map(cb => cb.value).join(',');
                const mes = document.getElementById('mes').value;
                const anio = document.getElementById('anio').value;
                window.location.href = `/conta/unidad/excel?anio=${anio}&mes=${mes}&unidades=${unidades}`;
            });
        }
        
        // ============================================
        // CONFIGURACIÓN
        // ============================================
        const configUnidadSelect = document.getElementById('configUnidadSelect');
        
        function cargarConfiguracion() {
            const unidadId = configUnidadSelect.value;
            if (!unidadId) {
                document.getElementById('configContenido').innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #6c757d;">
                        <i class="fas fa-info-circle"></i> Seleccione una unidad de negocio para configurar sus conceptos
                    </div>
                `;
                return;
            }
            
            fetch(`/conta/unidad/config?unidad_id=${unidadId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderConfiguracion(data);
                    }
                });
        }
        
        function renderConfiguracion(data) {
            const container = document.getElementById('configContenido');
            const categorias = {};
            
            data.conceptos.forEach(concepto => {
                if (!categorias[concepto.categoria]) {
                    categorias[concepto.categoria] = [];
                }
                categorias[concepto.categoria].push(concepto);
            });
            
            const nombresCategoria = {
                'costos_variables': 'Costos Variables de Construcción',
                'gastos_fijos': 'Gastos Fijos',
                'financiamiento': 'Financiamiento',
                'mantenimiento': 'Mantenimiento'
            };
            
            let html = '<div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">';
            
            for (const [categoria, conceptos] of Object.entries(categorias)) {
                const categoriaNombre = nombresCategoria[categoria] || categoria;
                const itemId = `categoria-${categoria}`;
                
                html += `
                    <div style="border-bottom: 1px solid #dee2e6;">
                        <div class="config-header" data-target="${itemId}" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background-color: #f8f9fa; cursor: pointer;">
                            <span style="font-size: 16px; font-weight: 600; color: #083CAE;">${categoriaNombre}</span>
                            <span style="color: #083CAE; font-size: 20px; font-weight: bold;">+</span>
                        </div>
                        <div id="${itemId}" class="config-body" style="display: none; padding: 15px 20px; background-color: white;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #dee2e6;">
                                        <th style="text-align: left; padding: 8px;">Código SAT</th>
                                        <th style="text-align: left; padding: 8px;">Concepto</th>
                                        <th style="text-align: right; padding: 8px;">Porcentaje (%)</th>
                                        <th style="text-align: center; padding: 8px;">Activo</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;
                
                conceptos.forEach(concepto => {
                    const porcentaje = data.configuraciones[concepto.id] || 0;
                    const checked = concepto.activo ? 'checked' : '';
                    html += `
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td style="padding: 8px;"><code>${concepto.codigo_sat}</code></td>
                            <td style="padding: 8px;">${concepto.nombre_concepto}</td>
                            <td style="padding: 8px; text-align: right;">
                                <input type="number" class="config-porcentaje" data-concepto="${concepto.id}" value="${porcentaje}" step="0.01" style="width: 80px; text-align: right; padding: 4px; border: 1px solid #dee2e6; border-radius: 4px;">
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                <input type="checkbox" class="config-activo" data-concepto="${concepto.id}" ${checked}>
                            </td>
                        </table>
                    `;
                });
                
                html += `
                                </tbody>
                            </table>
                            <div style="margin-top: 15px;">
                                <button class="btn-agregar-concepto" data-categoria="${categoria}" style="background-color: #28a745; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer;">
                                    <i class="fas fa-plus"></i> Agregar Concepto
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            html += '</div>';
            container.innerHTML = html;
            
            // Eventos de expansión
            document.querySelectorAll('.config-header').forEach(header => {
                header.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const targetId = this.dataset.target;
                    const body = document.getElementById(targetId);
                    const icon = this.querySelector('span:last-child');
                    
                    if (body.style.display === 'none') {
                        body.style.display = 'block';
                        icon.textContent = '−';
                    } else {
                        body.style.display = 'none';
                        icon.textContent = '+';
                    }
                });
            });
            
            // Eventos para agregar concepto
            document.querySelectorAll('.btn-agregar-concepto').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const categoria = this.dataset.categoria;
                    mostrarModalAgregarConcepto(categoria);
                });
            });
        }
        
        function mostrarModalAgregarConcepto(categoria) {
            const nombre = prompt('Ingrese el nombre del concepto:');
            if (!nombre) return;
            
            const codigoSat = prompt('Ingrese el código SAT asociado (ej: 501.01 para Materiales, 511.02 para Mano de Obra):');
            if (!codigoSat) return;
            
            fetch('/conta/unidad/concepto/guardar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    categoria: categoria,
                    codigo_sat: codigoSat,
                    nombre_concepto: nombre
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cargarConfiguracion();
                    alert('Concepto agregado exitosamente');
                }
            });
        }
        
        // Guardar configuración
        document.getElementById('btnGuardarConfigGlobal').addEventListener('click', function() {
            const unidadId = configUnidadSelect.value;
            if (!unidadId) {
                alert('Seleccione una unidad de negocio primero');
                return;
            }
            
            const configuraciones = {};
            document.querySelectorAll('.config-porcentaje').forEach(input => {
                const conceptoId = input.dataset.concepto;
                configuraciones[conceptoId] = parseFloat(input.value) || 0;
            });
            
            fetch('/conta/unidad/config/guardar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    unidad_id: unidadId,
                    configuraciones: configuraciones
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Configuración guardada exitosamente');
                }
            });
        });
        
        if (configUnidadSelect) {
            configUnidadSelect.addEventListener('change', cargarConfiguracion);
        }
        
        // ============================================
        // CARGAR DATOS INICIALES
        // ============================================
        cargarDatos();
    });
</script>
@endsection