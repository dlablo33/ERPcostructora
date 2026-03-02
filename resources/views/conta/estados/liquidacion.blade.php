@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Estado de Resultados de Liquidación -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Estado de Resultados de Liquidación
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros superiores - Texto arriba, cuadro abajo -->
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
                    <!-- Grupo izquierda: Coordinadores, Unidades, Operadores -->
                    <div style="display: flex; gap: 25px; flex-wrap: wrap;">
                        <!-- Coordinadores -->
                        <div style="min-width: 180px;">
                            <div style="font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px;">COORDINADORES</div>
                            <select id="coordinador" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <option value="1">Juan Pérez</option>
                                <option value="2">María García</option>
                                <option value="3">Carlos López</option>
                                <option value="4">Ana Martínez</option>
                                <option value="5">Roberto Sánchez</option>
                            </select>
                        </div>

                        <!-- Unidades -->
                        <div style="min-width: 180px;">
                            <div style="font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px;">UNIDADES</div>
                            <select id="unidad" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <option value="U001">Unidad 001 (ABC-123)</option>
                                <option value="U002">Unidad 002 (XYZ-789)</option>
                                <option value="U003">Unidad 003 (DEF-456)</option>
                                <option value="U004">Unidad 004 (GHI-012)</option>
                                <option value="U005">Unidad 005 (JKL-345)</option>
                            </select>
                        </div>

                        <!-- Operadores -->
                        <div style="min-width: 180px;">
                            <div style="font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px;">OPERADORES</div>
                            <select id="operador" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <option value="1">Pedro Sánchez</option>
                                <option value="2">Luis Rodríguez</option>
                                <option value="3">Jorge Hernández</option>
                                <option value="4">Miguel Torres</option>
                                <option value="5">Fernando Gómez</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grupo derecha: Fechas y botón filtro -->
                    <div style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                        <!-- Fecha Inicio -->
                        <div style="min-width: 150px;">
                            <div style="font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px;">FECHA INICIO</div>
                            <input type="date" id="fechaInicio" value="2026-02-01" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                        </div>

                        <!-- Fecha Fin -->
                        <div style="min-width: 150px;">
                            <div style="font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 5px;">FECHA FIN</div>
                            <input type="date" id="fechaFin" value="2026-02-28" style="width: 100%; padding: 10px 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                        </div>

                        <!-- Botón Filtro verde -->
                        <div>
                            <button id="btnFiltro" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; height: 42px; box-shadow: 0 2px 4px rgba(44,191,31,0.3);">
                                <i class="fas fa-filter"></i> FILTRAR
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KPIs superiores con datos dinámicos -->
                <div style="display: flex; gap: 60px; margin-bottom: 30px; padding: 15px 0;">
                    <div id="kmsContainer">
                        <div style="font-size: 14px; color: #6c757d;">Kms.</div>
                        <div id="kmsValue" style="font-size: 28px; font-weight: bold;">2,547.32</div>
                    </div>
                    <div id="unidadesContainer">
                        <div style="font-size: 14px; color: #6c757d;">No. Unidades</div>
                        <div id="unidadesValue" style="font-size: 28px; font-weight: bold;">12</div>
                    </div>
                    <div id="rendimientoContainer">
                        <div style="font-size: 14px; color: #6c757d;">Rendimiento</div>
                        <div id="rendimientoValue" style="font-size: 28px; font-weight: bold;">8.45</div>
                    </div>
                </div>

                <!-- Tabla de resultados con datos dinámicos -->
                <div style="width: 100%; border: 1px solid #e9ecef; border-radius: 12px; padding: 20px; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <!-- Encabezados de métricas con fondo gris #f1f5f9 -->
                    <div style="display: flex; justify-content: flex-end; gap: 30px; margin-bottom: 15px; padding: 10px 20px; background-color: #f1f5f9; border-radius: 8px;">
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>% / Vta.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Ing. / Km.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Ing. / Uni.</strong></div>
                    </div>

                    <!-- Total Ingresos -->
                    <div id="ingresosRow" style="display: flex; align-items: center; padding: 12px 0; border-top: 2px solid #dee2e6;">
                        <div style="flex: 1; font-size: 16px;"><strong>Total Ingresos</strong></div>
                        <div id="ingresosMonto" style="min-width: 120px; text-align: right; font-size: 16px; font-weight: bold;">$45,230.50</div>
                        <div style="display: flex; gap: 30px; min-width: 300px; justify-content: flex-end;">
                            <div id="ingresosPct" style="min-width: 80px; text-align: right;">100.00%</div>
                            <div id="ingresosKm" style="min-width: 80px; text-align: right;">17.76</div>
                            <div id="ingresosUni" style="min-width: 80px; text-align: right;">3,769.21</div>
                        </div>
                    </div>

                    <!-- Encabezados de métricas Egresos con fondo gris #f1f5f9 -->
                    <div style="display: flex; justify-content: flex-end; gap: 30px; margin-top: 20px; margin-bottom: 15px; padding: 10px 20px; background-color: #f1f5f9; border-radius: 8px;">
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>% / Vta.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Cto. / Km.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Cto. / Uni.</strong></div>
                    </div>

                    <!-- Total Egresos -->
                    <div id="egresosRow" style="display: flex; align-items: center; padding: 12px 0; border-top: 2px solid #dee2e6;">
                        <div style="flex: 1; font-size: 16px;"><strong>Total Egresos</strong></div>
                        <div id="egresosMonto" style="min-width: 120px; text-align: right; font-size: 16px; font-weight: bold;">$32,890.25</div>
                        <div style="display: flex; gap: 30px; min-width: 300px; justify-content: flex-end;">
                            <div id="egresosPct" style="min-width: 80px; text-align: right;">72.72%</div>
                            <div id="egresosKm" style="min-width: 80px; text-align: right;">12.91</div>
                            <div id="egresosUni" style="min-width: 80px; text-align: right;">2,740.85</div>
                        </div>
                    </div>

                    <!-- Gastos ordinarios / extraordinarios (título) -->
                    <div style="margin-top: 20px; margin-bottom: 10px;">
                        <strong style="font-size: 15px;">Gastos ordinarios / extraordinarios</strong>
                    </div>

                    <!-- Encabezados de métricas Gastos con fondo gris #f1f5f9 -->
                    <div style="display: flex; justify-content: flex-end; gap: 30px; margin-bottom: 15px; padding: 10px 20px; background-color: #f1f5f9; border-radius: 8px;">
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>% / Vta.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Cto. / Km.</strong></div>
                        <div style="text-align: right; min-width: 80px; color: #333; font-size: 13px;"><strong>Cto. / Uni.</strong></div>
                    </div>

                    <!-- Total Gastos ordinarios / extraordinarios -->
                    <div id="gastosRow" style="display: flex; align-items: center; padding: 12px 0; border-top: 1px solid #dee2e6;">
                        <div style="flex: 1; font-size: 15px;">Total Gastos ordinarios / extraordinarios</div>
                        <div id="gastosMonto" style="min-width: 120px; text-align: right;">$5,432.18</div>
                        <div style="display: flex; gap: 30px; min-width: 300px; justify-content: flex-end;">
                            <div id="gastosPct" style="min-width: 80px; text-align: right;">12.01%</div>
                            <div id="gastosKm" style="min-width: 80px; text-align: right;">2.13</div>
                            <div id="gastosUni" style="min-width: 80px; text-align: right;">452.68</div>
                        </div>
                    </div>

                    <!-- Bonos/Descuentos -->
                    <div id="bonosRow" style="display: flex; align-items: center; padding: 12px 0;">
                        <div style="flex: 1; font-size: 15px;">Bonos/Descuentos</div>
                        <div id="bonosMonto" style="min-width: 120px; text-align: right;">$1,200.00</div>
                        <div style="min-width: 300px;"></div>
                    </div>

                    <!-- Total Egresos -->
                    <div id="totalEgresosRow" style="display: flex; align-items: center; padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                        <div style="flex: 1; font-size: 15px;">Total Egresos</div>
                        <div id="totalEgresosMonto" style="min-width: 120px; text-align: right;">$34,090.25</div>
                        <div style="min-width: 300px;"></div>
                    </div>

                    <!-- Utilidad con métricas -->
                    <div style="margin-top: 15px;">
                        <div style="display: flex; align-items: center; padding: 12px 0;">
                            <div style="flex: 1;"><strong style="font-size: 18px;">Utilidad</strong></div>
                            <div style="min-width: 120px; text-align: right;"><strong style="font-size: 18px;" id="utilidadMonto">$11,140.25</strong></div>
                            <div style="display: flex; gap: 30px; min-width: 300px; justify-content: flex-end;">
                                <div style="min-width: 80px; text-align: right;"><strong>% / Vta.</strong></div>
                                <div style="min-width: 80px; text-align: right;"><strong>Cto. / Km.</strong></div>
                                <div style="min-width: 80px; text-align: right;"><strong>Cto. / Uni.</strong></div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 30px; padding-right: 20px;">
                            <div id="utilidadPct" style="min-width: 80px; text-align: right;">24.63%</div>
                            <div id="utilidadKm" style="min-width: 80px; text-align: right;">4.37</div>
                            <div id="utilidadUni" style="min-width: 80px; text-align: right;">928.35</div>
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
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }

    /* Estilos para los cuadros de filtro */
    select, input[type="date"] {
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: white;
    }

    select:hover, input[type="date"]:hover {
        border-color: #2CBF1F !important;
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.1);
    }

    select:focus, input[type="date"]:focus {
        outline: none;
        border-color: #2CBF1F;
        box-shadow: 0 0 0 3px rgba(44, 191, 31, 0.2);
    }

    /* Estilo para el botón Filtro */
    #btnFiltro {
        transition: all 0.3s ease;
    }

    #btnFiltro:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(44, 191, 31, 0.4) !important;
    }

    #btnFiltro:active {
        transform: translateY(0);
    }

    /* Estilo para los encabezados grises */
    [style*="background-color: #f1f5f9"] {
        transition: background-color 0.2s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        [style*="justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }

        [style*="display: flex; gap: 60px"] {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const btnFiltro = document.getElementById('btnFiltro');
        
        // Elementos de filtros
        const coordinador = document.getElementById('coordinador');
        const unidad = document.getElementById('unidad');
        const operador = document.getElementById('operador');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');

        // Elementos de KPIs
        const kmsValue = document.getElementById('kmsValue');
        const unidadesValue = document.getElementById('unidadesValue');
        const rendimientoValue = document.getElementById('rendimientoValue');

        // Elementos de tabla
        const ingresosMonto = document.getElementById('ingresosMonto');
        const ingresosPct = document.getElementById('ingresosPct');
        const ingresosKm = document.getElementById('ingresosKm');
        const ingresosUni = document.getElementById('ingresosUni');

        const egresosMonto = document.getElementById('egresosMonto');
        const egresosPct = document.getElementById('egresosPct');
        const egresosKm = document.getElementById('egresosKm');
        const egresosUni = document.getElementById('egresosUni');

        const gastosMonto = document.getElementById('gastosMonto');
        const gastosPct = document.getElementById('gastosPct');
        const gastosKm = document.getElementById('gastosKm');
        const gastosUni = document.getElementById('gastosUni');

        const bonosMonto = document.getElementById('bonosMonto');
        const totalEgresosMonto = document.getElementById('totalEgresosMonto');
        const utilidadMonto = document.getElementById('utilidadMonto');
        const utilidadPct = document.getElementById('utilidadPct');
        const utilidadKm = document.getElementById('utilidadKm');
        const utilidadUni = document.getElementById('utilidadUni');

        // Función para generar números aleatorios
        function randomNumber(min, max, decimals = 2) {
            const num = Math.random() * (max - min) + min;
            return decimals === 0 ? Math.round(num) : Number(num.toFixed(decimals));
        }

        // Función para formatear moneda
        function formatCurrency(value) {
            return '$' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Función para actualizar datos con valores aleatorios
        function actualizarDatos() {
            // Obtener valores de filtros para contexto
            const coordinadorSel = coordinador.options[coordinador.selectedIndex]?.text || 'No seleccionado';
            const unidadSel = unidad.options[unidad.selectedIndex]?.text || 'No seleccionado';
            const operadorSel = operador.options[operador.selectedIndex]?.text || 'No seleccionado';
            const inicio = fechaInicio.value;
            const fin = fechaFin.value;

            console.log('Filtros aplicados:', { coordinadorSel, unidadSel, operadorSel, inicio, fin });

            // Generar KPIs aleatorios
            const kms = randomNumber(1500, 3500, 2);
            const numUnidades = randomNumber(8, 18, 0);
            const rendimiento = randomNumber(6.5, 10.5, 2);

            kmsValue.textContent = kms.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            unidadesValue.textContent = numUnidades;
            rendimientoValue.textContent = rendimiento.toFixed(2);

            // Generar ingresos aleatorios
            const ingresos = randomNumber(35000, 55000, 2);
            ingresosMonto.textContent = formatCurrency(ingresos);
            ingresosPct.textContent = '100.00%';
            ingresosKm.textContent = (ingresos / kms).toFixed(2);
            ingresosUni.textContent = (ingresos / numUnidades).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Generar egresos aleatorios (65-80% de ingresos)
            const egresosPctaje = randomNumber(65, 80, 2);
            const egresos = ingresos * (egresosPctaje / 100);
            egresosMonto.textContent = formatCurrency(egresos);
            egresosPct.textContent = egresosPctaje.toFixed(2) + '%';
            egresosKm.textContent = (egresos / kms).toFixed(2);
            egresosUni.textContent = (egresos / numUnidades).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Generar gastos ordinarios (10-20% de ingresos)
            const gastosPctaje = randomNumber(8, 18, 2);
            const gastos = ingresos * (gastosPctaje / 100);
            gastosMonto.textContent = formatCurrency(gastos);
            gastosPct.textContent = gastosPctaje.toFixed(2) + '%';
            gastosKm.textContent = (gastos / kms).toFixed(2);
            gastosUni.textContent = (gastos / numUnidades).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Generar bonos/descuentos
            const bonos = randomNumber(500, 2500, 2);
            bonosMonto.textContent = formatCurrency(bonos);

            // Calcular total egresos (egresos + bonos)
            const totalEgresosCalc = egresos + bonos;
            totalEgresosMonto.textContent = formatCurrency(totalEgresosCalc);

            // Calcular utilidad (ingresos - totalEgresosCalc)
            const utilidadCalc = ingresos - totalEgresosCalc;
            const utilidadPctaje = (utilidadCalc / ingresos * 100).toFixed(2);
            const utilidadKmCalc = (utilidadCalc / kms).toFixed(2);
            const utilidadUniCalc = (utilidadCalc / numUnidades).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            utilidadMonto.textContent = formatCurrency(utilidadCalc);
            utilidadPct.textContent = utilidadPctaje + '%';
            utilidadKm.textContent = utilidadKmCalc;
            utilidadUni.textContent = utilidadUniCalc;

            // Mostrar mensaje de actualización
            const timestamp = new Date().toLocaleTimeString();
            console.log(`✅ Datos actualizados: ${timestamp}`);
        }

        // Evento del botón Filtrar
        btnFiltro.addEventListener('click', function(e) {
            e.preventDefault();
            actualizarDatos();
            
            // Feedback visual
            btnFiltro.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnFiltro.style.transform = 'scale(1)';
            }, 200);
        });

        // Actualización inicial
        actualizarDatos();
    });
</script>
@endsection