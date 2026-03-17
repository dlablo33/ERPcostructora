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
                                <option value="OB-001" selected>OB-001 - Edificio Corporativo Reforma</option>
                                <option value="OB-002">OB-002 - Puente Vehicular Norte</option>
                                <option value="OB-003">OB-003 - Urbanización Los Pinos</option>
                                <option value="OB-004">OB-004 - Remodelación Centro</option>
                                <option value="OB-005">OB-005 - Parque Industrial</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Barra de botones superior -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                        <!-- Fechas a la izquierda -->
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <span style="font-size: 13px; color: #6c757d;">Fecha inicio:</span>
                                <input type="date" id="dateStart" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background-color: white;">
                            </div>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <span style="font-size: 13px; color: #6c757d;">Fecha fin:</span>
                                <input type="date" id="dateEnd" value="2026-03-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background-color: white;">
                            </div>
                            <button id="btnConsultar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; padding: 6px 15px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-search"></i> Consultar
                            </button>
                        </div>
                        
                        <!-- Botones de la derecha -->
                        <div style="display: flex; gap: 8px;">
                            <button id="btnExcel" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Exportar a Excel">
                                <i class="fas fa-file-excel"></i>
                            </button>
                            <button id="btnPDF" style="background-color: #2CBF1F; color: white; border: none; border-radius: 4px; width: 36px; height: 36px; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Exportar a PDF">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Información de la obra seleccionada -->
                    <div style="margin-bottom: 25px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <i class="fas fa-hard-hat" style="color: #083CAE; font-size: 24px;"></i>
                                <div>
                                    <span style="font-weight: bold; color: #083CAE; font-size: 16px;" id="obraNombre">Edificio Corporativo Reforma</span>
                                    <span style="color: #6c757d; font-size: 12px; display: block;">Código: OB-001 | Cliente: Constructora del Norte S.A. de C.V.</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 20px;">
                                <div style="text-align: right;">
                                    <div style="font-size: 11px; color: #6c757d;">Presupuesto Original</div>
                                    <div style="font-size: 16px; font-weight: bold; color: #083CAE;">$2,500,000.00</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 11px; color: #6c757d;">Avance Físico</div>
                                    <div style="font-size: 16px; font-weight: bold; color: #28a745;">75%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de costos - 4 cuadros -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Costo Directo</div>
                            <div style="font-size: 20px; font-weight: bold;">$1,875,000</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Indirectos</div>
                            <div style="font-size: 20px; font-weight: bold;">$312,500</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Costo Real</div>
                            <div style="font-size: 20px; font-weight: bold;">$1,702,350</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #083CAE; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">Variación</div>
                            <div style="font-size: 20px; font-weight: bold;">+$172,650</div>
                        </div>
                    </div>

                    <!-- Pestañas -->
                    <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                        <button class="tab-button active" data-tab="apu" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                            <i class="fas fa-calculator" style="margin-right: 8px;"></i> Análisis de Precios Unitarios
                        </button>
                        <button class="tab-button" data-tab="insumos" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                            <i class="fas fa-cubes" style="margin-right: 8px;"></i> Explosión de Insumos
                        </button>
                    </div>

                    <!-- Tabla de APU -->
                    <div id="tab-apu" class="tab-content" style="display: block;">
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
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">C-001</td>
                                        <td style="padding: 10px;">Excavación para cimentación</td>
                                        <td style="padding: 10px; text-align: center;">m³</td>
                                        <td style="padding: 10px; text-align: right;">450.00</td>
                                        <td style="padding: 10px; text-align: right;">$208.69</td>
                                        <td style="padding: 10px; text-align: right;">$93,910.50</td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">C-002</td>
                                        <td style="padding: 10px;">Cimentación de concreto armado</td>
                                        <td style="padding: 10px; text-align: center;">m³</td>
                                        <td style="padding: 10px; text-align: right;">320.00</td>
                                        <td style="padding: 10px; text-align: right;">$3,207.09</td>
                                        <td style="padding: 10px; text-align: right;">$1,026,268.80</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">C-003</td>
                                        <td style="padding: 10px;">Muro de tabique rojo</td>
                                        <td style="padding: 10px; text-align: center;">m²</td>
                                        <td style="padding: 10px; text-align: right;">1,250.00</td>
                                        <td style="padding: 10px; text-align: right;">$433.41</td>
                                        <td style="padding: 10px; text-align: right;">$541,762.50</td>
                                    </tr>
                                </tbody>
                                <tfoot style="background-color: #e9ecef;">
                                    <tr>
                                        <td colspan="5" style="padding: 12px 8px; text-align: right; font-weight: bold;">TOTAL COSTO DIRECTO:</td>
                                        <td style="padding: 12px 8px; text-align: right; font-weight: bold;">$1,661,941.80</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla de Insumos -->
                    <div id="tab-insumos" class="tab-content" style="display: none;">
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
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">MAT-001</td>
                                        <td style="padding: 10px;">Cemento gris</td>
                                        <td style="padding: 10px; text-align: center;">ton</td>
                                        <td style="padding: 10px; text-align: right;">85.50</td>
                                        <td style="padding: 10px; text-align: right;">82.30</td>
                                        <td style="padding: 10px; text-align: right; color: #28a745;">-3.20</td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">MAT-002</td>
                                        <td style="padding: 10px;">Varilla 3/8"</td>
                                        <td style="padding: 10px; text-align: center;">ton</td>
                                        <td style="padding: 10px; text-align: right;">42.00</td>
                                        <td style="padding: 10px; text-align: right;">44.50</td>
                                        <td style="padding: 10px; text-align: right; color: #dc3545;">+2.50</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px;">MO-001</td>
                                        <td style="padding: 10px;">Albañil (FSR 1.6825)</td>
                                        <td style="padding: 10px; text-align: center;">jor</td>
                                        <td style="padding: 10px; text-align: right;">320.00</td>
                                        <td style="padding: 10px; text-align: right;">305.00</td>
                                        <td style="padding: 10px; text-align: right; color: #28a745;">-15.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Programa de Suministros -->
                        <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <h4 style="color: #083CAE; font-size: 15px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-truck mr-2"></i> Programa de Suministros
                            </h4>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <input type="date" value="2026-03-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <input type="date" value="2026-03-31" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <button style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 20px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                    <i class="fas fa-calendar-alt mr-2"></i> Generar Programa
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 15px;">
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-3 de 45 conceptos</span>
                        <div style="display: flex; gap: 5px;">
                            <button class="page-btn" disabled style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; color: #6c757d; cursor: not-allowed;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="page-btn active" style="padding: 6px 12px; border: 1px solid #083CAE; background: #083CAE; color: white; border-radius: 4px;">1</button>
                            <button class="page-btn" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                            <button class="page-btn" style="padding: 6px 12px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">3</button>
                            <button class="page-btn" style="padding: 6px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Nota al pie -->
                    <div style="margin-top: 20px; font-size: 11px; color: #6c757d; text-align: center; border-top: 1px solid #dee2e6; padding-top: 15px;">
                        <i class="fas fa-info-circle" style="color: #083CAE;"></i>
                        Costos correspondientes al período del 01/01/2026 al 31/03/2026 - Obra: Edificio Corporativo Reforma
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
    
    /* Estilo para pestañas */
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
    
    /* Estilo para cuadros de resumen */
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(8, 60, 174, 0.15) !important;
    }
    
    /* Estilo para botones */
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
    
    /* Estilo para tabla */
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
    
    /* Estilo para selects e inputs */
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
    
    /* Estilo para botones de paginación */
    .page-btn {
        transition: all 0.2s;
    }
    
    .page-btn:not(:disabled):not(.active):hover {
        background-color: #e9ecef !important;
        transform: translateY(-2px);
    }
    
    .page-btn.active {
        background-color: #083CAE !important;
        border-color: #083CAE !important;
        color: white !important;
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Scrollbar personalizada */
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
    
    /* Responsive */
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

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Costos por Obra - Inicializado correctamente');
        
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

        // Mostrar APU por defecto
        showTab('apu');

        // Event Listeners
        document.getElementById('btnConsultar').addEventListener('click', function() {
            const obraSelect = document.getElementById('obraSelect');
            const obraText = obraSelect.options[obraSelect.selectedIndex].text;
            const fechaInicio = document.getElementById('dateStart').value;
            const fechaFin = document.getElementById('dateEnd').value;
            
            alert(`Consultando costos para:\nObra: ${obraText}\nPeríodo: ${fechaInicio} al ${fechaFin}`);
            
            // Feedback visual
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        document.getElementById('btnExcel').addEventListener('click', function() {
            alert('Exportando costos de obra a Excel...');
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        document.getElementById('btnPDF').addEventListener('click', function() {
            alert('Exportando costos de obra a PDF...');
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 200);
        });

        // Cambio de obra
        document.getElementById('obraSelect').addEventListener('change', function() {
            const obraText = this.options[this.selectedIndex].text;
            document.getElementById('obraNombre').textContent = obraText.split(' - ')[1] || obraText;
        });
    });
</script>
@endsection