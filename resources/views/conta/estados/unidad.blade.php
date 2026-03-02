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
                <!-- Filtros y botón Excel - Todo a la derecha -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-bottom: 25px;">
                    <!-- Filtro Unidad de Negocio -->
                    <select id="unidadNegocio" style="padding: 6px 10px; border: 1px solid #083CAE; border-radius: 4px; font-size: 13px; background-color: white; width: 150px;">
                        <option value="local">Local</option>
                        <option value="regional">Regional</option>
                        <option value="foraneo">Foráneo</option>
                        <option value="importacion">Importación</option>
                        <option value="refrigerado">Refrigerado</option>
                        <option value="materiales">Materiales Peligrosos</option>
                        <option value="volumetrico">Volumétrico</option>
                    </select>

                    <!-- Filtro Año-Mes combinado -->
                    <div style="display: flex; border: 1px solid #083CAE; border-radius: 4px; overflow: hidden;">
                        <select id="mes" style="padding: 6px 10px; border: none; font-size: 13px; background-color: white; width: 100px; border-right: 1px solid #dee2e6;">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <select id="anio" style="padding: 6px 10px; border: none; font-size: 13px; background-color: white; width: 80px;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>
                    </div>

                    <!-- Botón Excel verde - Solo icono -->
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

                <!-- Contenido Pestaña Estado de Resultados -->
                <div id="tab-resultados" class="tab-content" style="display: block;">
                    <!-- Cards de KPIs - 4 arriba, 4 abajo - Fondo transparente -->
                    <div style="margin-bottom: 30px;">
                        <!-- Primera fila - 4 cards con fondo transparente -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 15px;">
                            <!-- Total Unidades - Número azul -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">TOTAL UNIDADES</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">171</div>
                            </div>

                            <!-- Unidades U.Negocio - Número azul -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">UNIDADES U.NEGOCIO</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">11</div>
                            </div>

                            <!-- Unidades Usadas - Número azul -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">UNIDADES USADAS</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">37</div>
                            </div>

                            <!-- % Unidades Usadas - Número verde -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">% UNIDADES USADAS</div>
                                <div style="font-size: 32px; font-weight: bold; color: #28a745;">336.36%</div>
                            </div>
                        </div>

                        <!-- Segunda fila - 4 cards con fondo transparente -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <!-- Km Totales - Número verde -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">KM TOTALES</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">337,253.04</div>
                            </div>

                            <!-- Km U.Negocio - Número verde -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">KM U.NEGOCIO</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">59,354.70</div>
                            </div>

                            <!-- Km Liquidados - Número azul -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">KM LIQUIDADOS</div>
                                <div style="font-size: 32px; font-weight: bold; color: #007bff;">3,392.00</div>
                            </div>

                            <!-- % Km Liquidados - Número azul -->
                            <div style="background-color: transparent; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">% KM LIQUIDADOS</div>
                                <div style="font-size: 32px; font-weight: bold; color: #28a745;">5.71%</div>
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
                                    <th style="padding: 12px 15px; text-align: right;">km</th>
                                    <th style="padding: 12px 15px; text-align: right;">Unidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- LOCAL -->
                                <tr style="background-color: #e3f2fd; font-weight: bold;">
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6;">LOCAL</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;">97,568.50</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;">100.00</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;"></td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;"></td>
                                </tr>
                                
                                <!-- Plataforma Sencillo -->
                                <tr style="background-color: #f5f5f5;">
                                    <td style="padding: 12px 15px; padding-left: 30px; border-bottom: 1px solid #dee2e6;">Plataforma Sencillo</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;">97,568.50</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;">100.00</td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;"></td>
                                    <td style="padding: 12px 15px; text-align: right; border-bottom: 1px solid #dee2e6;"></td>
                                </tr>

                                <!-- Costo Directo de Operación -->
                                <tr style="background-color: #fff3e0;">
                                    <td style="padding: 12px 15px; font-weight: 600; color: #d32f2f;">Costo Directo de Operación</td>
                                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">46,552.49</td>
                                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">47.71</td>
                                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">0.14</td>
                                    <td style="padding: 12px 15px; text-align: right; font-weight: 600; color: #d32f2f;">4,232.04</td>
                                </tr>

                                <!-- Combustible -->
                                <tr>
                                    <td style="padding: 12px 15px; padding-left: 30px;">Combustible</td>
                                    <td style="padding: 12px 15px; text-align: right;">8,105.25</td>
                                    <td style="padding: 12px 15px; text-align: right;">17.41</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.14</td>
                                    <td style="padding: 12px 15px; text-align: right;">13,337.38</td>
                                </tr>

                                <!-- Casetas -->
                                <tr>
                                    <td style="padding: 12px 15px; padding-left: 30px;">Casetas</td>
                                    <td style="padding: 12px 15px; text-align: right;">12,917.24</td>
                                    <td style="padding: 12px 15px; text-align: right;">27.75</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.22</td>
                                    <td style="padding: 12px 15px; text-align: right;">1,174.29</td>
                                </tr>

                                <!-- Sueldos Operadores -->
                                <tr>
                                    <td style="padding: 12px 15px; padding-left: 30px;">Sueldos Operadores</td>
                                    <td style="padding: 12px 15px; text-align: right;">22,630.00</td>
                                    <td style="padding: 12px 15px; text-align: right;">48.61</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.38</td>
                                    <td style="padding: 12px 15px; text-align: right;">2,057.27</td>
                                </tr>

                                <!-- Gastos de Viaje Operadores -->
                                <tr>
                                    <td style="padding: 12px 15px; padding-left: 30px;">Gastos de Viaje Operadores</td>
                                    <td style="padding: 12px 15px; text-align: right;">2,900.00</td>
                                    <td style="padding: 12px 15px; text-align: right;">6.23</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.05</td>
                                    <td style="padding: 12px 15px; text-align: right;">263.64</td>
                                </tr>

                                <!-- Urea -->
                                <tr>
                                    <td style="padding: 12px 15px; padding-left: 30px;">Urea</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right;">0.00</td>
                                </tr>

                                <!-- Utilidad (fila destacada) -->
                                <tr style="background-color: #c8e6c9; font-weight: bold;">
                                    <td style="padding: 12px 15px; color: #2e7d32;">Utilidad</td>
                                    <td style="padding: 12px 15px; text-align: right; color: #2e7d32;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right; color: #2e7d32;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right; color: #2e7d32;">0.00</td>
                                    <td style="padding: 12px 15px; text-align: right; color: #2e7d32;">0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totales y resumen -->
                    <div style="display: flex; justify-content: flex-end; margin-top: 20px; gap: 20px;">

                    </div>
                </div>

                <!-- Contenido Pestaña Configuración - Alineado a la izquierda -->
                <div id="tab-configuracion" class="tab-content" style="display: none;">
                    <div style="max-width: 600px;">
                        <!-- Lista de configuraciones alineada a la izquierda -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <!-- Mantenimiento -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; cursor: pointer;" class="config-item" data-categoria="mantenimiento">
                                <span style="font-size: 16px; font-weight: 500; color: #333;">Mantenimiento</span>
                                <span style="color: #083CAE; font-size: 20px; font-weight: bold;">+</span>
                            </div>

                            <!-- Costos Variables -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; cursor: pointer;" class="config-item" data-categoria="costos">
                                <span style="font-size: 16px; font-weight: 500; color: #333;">Costos Variables</span>
                                <span style="color: #083CAE; font-size: 20px; font-weight: bold;">+</span>
                            </div>

                            <!-- Gastos Fijos -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; cursor: pointer;" class="config-item" data-categoria="gastos">
                                <span style="font-size: 16px; font-weight: 500; color: #333;">Gastos Fijos</span>
                                <span style="color: #083CAE; font-size: 20px; font-weight: bold;">+</span>
                            </div>

                            <!-- Costo Integral de Financiamiento -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; cursor: pointer;" class="config-item" data-categoria="financiamiento">
                                <span style="font-size: 16px; font-weight: 500; color: #333;">Costo Integral de Financiamiento</span>
                                <span style="color: #083CAE; font-size: 20px; font-weight: bold;">+</span>
                            </div>
                        </div>

                        <!-- Botón Guardar alineado a la izquierda -->
                        <div style="margin-top: 30px;">
                            <button id="btnGuardarConfig" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 12px 50px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                Guardar
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
    
    .semaforo .card-header h2 {
        color: #083CAE !important;
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

    /* Estilos para la tabla */
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

    /* Estilos para los números */
    .text-right {
        text-align: right;
    }

    /* Animación para los cards */
    [style*="grid-template-columns"] > div {
        transition: transform 0.3s ease;
    }

    [style*="grid-template-columns"] > div:hover {
        transform: translateY(-3px);
    }

    /* Estilo para items de configuración */
    .config-item {
        transition: all 0.3s ease;
    }

    .config-item:hover {
        background-color: #f8f9fa !important;
        padding-left: 25px !important;
    }

    .config-item:active {
        background-color: #e9ecef !important;
    }

    /* Estilo para el botón Guardar */
    #btnGuardarConfig {
        transition: all 0.3s ease;
    }

    #btnGuardarConfig:hover {
        background-color: #0a4ad0 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8, 60, 174, 0.3);
    }

    #btnGuardarConfig:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 768px) {
        [style*="justify-content: flex-end"] {
            flex-wrap: wrap;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        [style*="max-width: 600px"] {
            max-width: 100% !important;
        }
    }

    /* Estilo para el botón Excel */
    #btnExcel {
        transition: all 0.3s ease;
    }

    #btnExcel:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }

    #btnExcel:active {
        transform: translateY(0);
    }

    /* Estilo para los números en los cards */
    [style*="font-size: 32px"] {
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Mostrar resultados por defecto
        showTab('resultados');

        // Evento para filtros - actualización automática al cambiar
        const filtros = ['unidadNegocio', 'mes', 'anio'];
        filtros.forEach(filtroId => {
            document.getElementById(filtroId).addEventListener('change', function() {
                actualizarDatos();
            });
        });

        // Función para actualizar datos según filtros
        function actualizarDatos() {
            const unidad = document.getElementById('unidadNegocio').value;
            const mes = document.getElementById('mes').value;
            const anio = document.getElementById('anio').value;
            
            const unidadNombre = document.getElementById('unidadNegocio').options[document.getElementById('unidadNegocio').selectedIndex].text;
            const mesNombre = document.getElementById('mes').options[document.getElementById('mes').selectedIndex].text;
            
            console.log(`Actualizando datos para: ${unidadNombre} - ${mesNombre} ${anio}`);
        }

        // Evento del botón Excel
        document.getElementById('btnExcel').addEventListener('click', function() {
            alert('Exportando a Excel...');
        });

        // Eventos para items de configuración
        document.querySelectorAll('.config-item').forEach(item => {
            item.addEventListener('click', function() {
                const categoria = this.dataset.categoria;
                const signo = this.querySelector('span:last-child');
                
                // Aquí puedes implementar la lógica para expandir/contraer
                console.log(`Configuración de ${this.querySelector('span:first-child').textContent}`);
                
                // Ejemplo de cómo cambiar el signo (opcional)
                if (signo.textContent === '+') {
                    signo.textContent = '−';
                } else {
                    signo.textContent = '+';
                }
            });
        });

        // Evento del botón Guardar
        document.getElementById('btnGuardarConfig').addEventListener('click', function() {
            alert('Configuración guardada exitosamente');
        });
    });
</script>
@endsection