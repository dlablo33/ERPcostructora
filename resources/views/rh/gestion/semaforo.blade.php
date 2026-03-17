@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Semáforo de Documentos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Semáforo de Documentos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- KPIS - CON ALTURA REDUCIDA A 2/3 -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px; width: 100%;">
                    <!-- Vigentes -->
                    <div class="kpi-card vigente">
                        <div class="kpi-titulo">Vigentes</div>
                        <div class="kpi-numero">5</div>
                    </div>

                    <!-- Por Vencer -->
                    <div class="kpi-card por-vencer">
                        <div class="kpi-titulo">Por Vencer</div>
                        <div class="kpi-numero">3</div>
                    </div>

                    <!-- Vencidos -->
                    <div class="kpi-card vencido">
                        <div class="kpi-titulo">Vencidos</div>
                        <div class="kpi-numero">7</div>
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
                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 45px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="width: 100%; padding: 8px 8px 8px 35px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Documentos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaDocumentos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 900px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;">Id</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 27%;">Nombre</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;">Tipo Documento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 18%;">Fecha Vencimiento</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 12%;">Días</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">205</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">LUIS GARZA PEREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">LICENCIA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/12/2023</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-816</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">206</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MARIA FERNANDA RAMOS</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PASAPORTE</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/05/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vigente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #28a745; font-weight: bold;">70</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">207</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CARLOS ALBERTO MENDOZA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CURP</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">30/03/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Por Vencer</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #ffc107; font-weight: bold;">24</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">208</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ANA SOFIA MARTINEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">LICENCIA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/01/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Por Vencer</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #ffc107; font-weight: bold;">-1</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">209</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">JOSE LUIS TORRES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">RFC</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/11/2023</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vencido</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #dc3545; font-weight: bold;">-102</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">210</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PATRICIA RAMIREZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PASAPORTE</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">18/06/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vigente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #28a745; font-weight: bold;">104</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">211</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">ROBERTO CASTILLO</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CURP</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/02/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Por Vencer</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #ffc107; font-weight: bold;">35</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">212</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">LAURA CRISTINA FLORES</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">LICENCIA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">25/07/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vigente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #28a745; font-weight: bold;">141</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">213</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FERNANDO GONZALEZ</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">RFC</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">01/01/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Por Vencer</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #ffc107; font-weight: bold;">-4</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">214</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MIGUEL ANGEL HERRERA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PASAPORTE</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">12/08/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">Vigente</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; color: #28a745; font-weight: bold;">159</td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-weight: bold; font-size: 13px;">Cantidad: 10</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
        
        /* ===== VARIABLES PARA AJUSTAR ALTURA DE CUADROS ===== */
        --kpi-padding-vertical: 13px;  /* Controla la altura (2/3 de 20px ≈ 13px) */
        --kpi-font-size-titulo: 16px;   /* Tamaño del texto del título */
        --kpi-font-size-numero: 42px;    /* Tamaño del número */
        --kpi-margin-bottom: 5px;        /* Espacio entre título y número */
    }

    /* Estilos generales */
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }
    
    /* ===== ESTILOS DE CUADROS KPI ===== */
    .kpi-card {
        border: 2px solid var(--color-primary);
        border-radius: 4px;
        padding: var(--kpi-padding-vertical) 0;
        width: 100%;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .kpi-card.vigente {
        background-color: #28a745;
    }
    
    .kpi-card.por-vencer {
        background-color: #ffc107;
    }
    
    .kpi-card.vencido {
        background-color: #dc3545;
    }
    
    .kpi-titulo {
        font-size: var(--kpi-font-size-titulo);
        font-weight: 500;
        margin-bottom: var(--kpi-margin-bottom);
    }
    
    .kpi-card.vigente .kpi-titulo,
    .kpi-card.vencido .kpi-titulo {
        color: white;
    }
    
    .kpi-card.por-vencer .kpi-titulo {
        color: #212529;
    }
    
    .kpi-numero {
        font-size: var(--kpi-font-size-numero);
        font-weight: bold;
        line-height: 1.2;
    }
    
    .kpi-card.vigente .kpi-numero,
    .kpi-card.vencido .kpi-numero {
        color: white;
    }
    
    .kpi-card.por-vencer .kpi-numero {
        color: #212529;
    }
    
    /* KPIs - Grid de 3 columnas iguales */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
        width: 100%;
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
        min-width: 900px;
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
        text-align: center;
        vertical-align: middle;
    }
    
    /* Filas alternadas */
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:hover {
        background-color: #e8f0fe;
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
    
    /* Estatus badges */
    .badge-estatus {
        display: inline-block;
        min-width: 70px;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
        text-align: center;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        .kpi-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .badge-estatus {
            min-width: 60px;
            padding: 3px 4px;
            font-size: 10px;
        }
        
        /* Ajustes responsive para KPI */
        .kpi-card {
            --kpi-padding-vertical: 10px;
            --kpi-font-size-titulo: 14px;
            --kpi-font-size-numero: 36px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Actualizar grupo de columnas
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

    // Drag & drop
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

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'id', caption: 'Id' },
                { field: 'nombre', caption: 'Nombre' },
                { field: 'documento', caption: 'Tipo Documento' },
                { field: 'fecha', caption: 'Fecha de Vencimiento' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'dias', caption: 'Días' }
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

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando:', termino);
    });
});
</script>
@endsection