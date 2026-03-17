@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Catálogo de Artículos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Catálogo de Artículos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación (izquierda) -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Grupo derecho: botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar artículo"
                                    onclick="abrirModalArticulo()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 250px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar artículo..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Catálogo de Artículos -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaArticulos" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1600px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 5%;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 5%;" draggable="true" data-columna="id">ID</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="familia">Familia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="subfamilia">Subfamilia</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="codigo">Código</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="numero_parte">Número Parte</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 6%;" draggable="true" data-columna="ubicacion">Ubicación</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 4%;" draggable="true" data-columna="minimo">Mínimo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 4%;" draggable="true" data-columna="maximo">Máximo</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 5%;" draggable="true" data-columna="reorden">Reorden</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 6%;" draggable="true" data-columna="unidad">Unidad Medida</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 8%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Los datos se cargarán vía JavaScript con paginación -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación y botón Crear filtro (lado izquierdo el botón, lado derecho la paginación) -->
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <!-- Botón Crear filtro (izquierda) -->
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
                    <!-- Paginación (derecha) -->
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 13px; color: #6c757d;">Mostrando <span id="inicioRegistro">1</span> - <span id="finRegistro">10</span> de <span id="totalRegistros">25</span></span>
                            <select id="registrosPorPagina" style="padding: 5px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnPrimera" title="Primera página">
                                <i class="fas fa-angle-double-left"></i>
                            </button>
                            <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnAnterior" title="Página anterior">
                                <i class="fas fa-angle-left"></i>
                            </button>
                            <span style="min-width: 40px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;" id="paginaActual">1</span>
                            <span style="font-size: 13px; color: #6c757d;">de <span id="totalPaginas">3</span></span>
                            <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnSiguiente" title="Página siguiente">
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnUltima" title="Última página">
                                <i class="fas fa-angle-double-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR ARTÍCULO -->
<div id="modalArticulo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloArticulo">Nuevo Artículo</h3>
            <button onclick="cerrarModalArticulo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">ID</label>
                    <input type="text" id="modalIdArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="ART-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Familia</label>
                    <select id="modalFamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar familia</option>
                        <option>Herramientas</option>
                        <option>Materiales</option>
                        <option>Equipo</option>
                        <option>Consumibles</option>
                        <option>Seguridad</option>
                        <option>Electricidad</option>
                        <option>Plomería</option>
                        <option>Pinturas</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Subfamilia</label>
                    <select id="modalSubfamiliaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar subfamilia</option>
                        <option>Eléctricas</option>
                        <option>Manuales</option>
                        <option>Hidráulicas</option>
                        <option>Neumáticas</option>
                        <option>Construcción</option>
                        <option>Acero</option>
                        <option>Madera</option>
                        <option>Cableado</option>
                        <option>Tuberías</option>
                        <option>Protección Personal</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="HERR-001">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Número de Parte</label>
                    <input type="text" id="modalNumeroParteArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="TLD-1001">
                </div>
                <div style="grid-column: span 3;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" id="modalDescripcionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción completa del artículo">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Ubicación</label>
                    <input type="text" id="modalUbicacionArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="A-12">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Mínimo</label>
                    <input type="number" id="modalMinimoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Máximo</label>
                    <input type="number" id="modalMaximoArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Punto Reorden</label>
                    <input type="number" id="modalReordenArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Unidad de Medida</label>
                    <select id="modalUnidadArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Seleccionar unidad</option>
                        <option>Pieza</option>
                        <option>Kilogramo</option>
                        <option>Litro</option>
                        <option>Metro</option>
                        <option>Caja</option>
                        <option>Paquete</option>
                        <option>Juego</option>
                        <option>Tonelada</option>
                        <option>Galón</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cuenta Contable</label>
                    <input type="text" id="modalCuentaArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1150-01-001">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalArticulo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarArticulo()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
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
        max-height: 500px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
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
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .table td:last-child i:hover {
        transform: scale(1.2);
    }
    
    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }
    
    .table td:last-child i.fa-trash {
        color: #dc3545;
    }
    
    /* Badges de estatus */
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-inactivo {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
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
    
    /* Scroll personalizado */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }
    
    /* Modal */
    #modalArticulo {
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
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalArticulo > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalArticulo div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;"] {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }
        
        div[style*="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;"] {
            width: 100%;
            justify-content: space-between;
        }
        
        div[style*="display: flex; align-items: center; gap: 5px;"] {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    let paginaActual = 1;
    let registrosPorPagina = 10;
    let datosArticulos = [];
    let datosFiltrados = [];
    
    // Generar datos de ejemplo (25 artículos)
    function generarDatosArticulos() {
        const familias = ['Herramientas', 'Materiales', 'Equipo', 'Consumibles', 'Seguridad', 'Electricidad', 'Plomería', 'Pinturas'];
        const subfamilias = {
            'Herramientas': ['Eléctricas', 'Manuales', 'Hidráulicas', 'Neumáticas'],
            'Materiales': ['Construcción', 'Acero', 'Madera'],
            'Equipo': ['Maquinaria', 'Andamios', 'Revolvedoras'],
            'Consumibles': ['Oficina', 'Limpieza', 'General'],
            'Seguridad': ['Protección Personal', 'Señalización', 'Emergencia'],
            'Electricidad': ['Cableado', 'Interruptores', 'Iluminación'],
            'Plomería': ['Tuberías', 'Conexiones', 'Herramientas'],
            'Pinturas': ['Vinílicas', 'Esmaltes', 'Impermeabilizantes']
        };
        const ubicaciones = ['A-01', 'A-02', 'B-01', 'B-02', 'C-01', 'C-02', 'D-01', 'E-01', 'F-01', 'G-01'];
        const unidades = ['Pieza', 'Kilogramo', 'Litro', 'Metro', 'Caja', 'Paquete', 'Juego', 'Tonelada', 'Galón'];
        
        const datos = [];
        
        for (let i = 1; i <= 25; i++) {
            const familia = familias[Math.floor(Math.random() * familias.length)];
            const subfamiliaOptions = subfamilias[familia] || ['General'];
            const subfamilia = subfamiliaOptions[Math.floor(Math.random() * subfamiliaOptions.length)];
            const estatus = Math.random() > 0.2 ? 'Activo' : 'Inactivo'; // 80% activos
            
            datos.push({
                id: i,
                estatus: estatus,
                estatus_txt: estatus,
                familia: familia,
                subfamilia: subfamilia,
                codigo: `ART-${String(i).padStart(3, '0')}`,
                descripcion: `Artículo de ejemplo ${i} - ${subfamilia} - ${familia}`,
                numero_parte: `NP-${String(Math.floor(Math.random() * 1000)).padStart(4, '0')}`,
                ubicacion: ubicaciones[Math.floor(Math.random() * ubicaciones.length)],
                minimo: Math.floor(Math.random() * 20) + 5,
                maximo: Math.floor(Math.random() * 100) + 50,
                reorden: Math.floor(Math.random() * 30) + 10,
                unidad: unidades[Math.floor(Math.random() * unidades.length)],
                cuenta_contable: `1150-${String(i).padStart(2, '0')}-${String(i).padStart(3, '0')}`
            });
        }
        
        return datos;
    }
    
    datosArticulos = generarDatosArticulos();
    datosFiltrados = [...datosArticulos];
    
    // Función para renderizar tabla con paginación
    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');
        const inicio = (paginaActual - 1) * registrosPorPagina;
        const fin = Math.min(inicio + registrosPorPagina, datosFiltrados.length);
        const pageData = datosFiltrados.slice(inicio, fin);
        
        let html = '';
        
        pageData.forEach(item => {
            const badgeColor = item.estatus === 'Activo' ? '#28a745' : '#ffc107';
            const badgeTextColor = item.estatus === 'Activo' ? 'white' : '#212529';
            
            html += `<tr>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                    <span style="background-color: ${badgeColor}; color: ${badgeTextColor}; padding: 4px 8px; border-radius: 3px; font-size: 11px; display: inline-block; min-width: 70px;">${item.estatus}</span>
                </td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">${item.id}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.familia}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.subfamilia}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.codigo}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">${item.descripcion}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.numero_parte}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.ubicacion}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${item.minimo}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${item.maximo}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">${item.reorden}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.unidad}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">${item.cuenta_contable}</td>
                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle ${item.codigo}')" title="Ver detalle"></i>
                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarArticulo(${item.id})" title="Editar"></i>
                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar artículo?')) alert('Artículo eliminado')" title="Eliminar"></i>
                </td>
            </tr>`;
        });
        
        tbody.innerHTML = html;
        
        // Actualizar información de paginación
        document.getElementById('inicioRegistro').textContent = datosFiltrados.length > 0 ? inicio + 1 : 0;
        document.getElementById('finRegistro').textContent = fin;
        document.getElementById('totalRegistros').textContent = datosFiltrados.length;
        
        const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
        document.getElementById('paginaActual').textContent = paginaActual;
        document.getElementById('totalPaginas').textContent = totalPaginas;
        
        // Actualizar estado de botones de paginación
        document.getElementById('btnPrimera').disabled = paginaActual === 1;
        document.getElementById('btnAnterior').disabled = paginaActual === 1;
        document.getElementById('btnSiguiente').disabled = paginaActual === totalPaginas;
        document.getElementById('btnUltima').disabled = paginaActual === totalPaginas;
    }
    
    // Eventos de paginación
    document.getElementById('btnPrimera').addEventListener('click', () => {
        paginaActual = 1;
        renderizarTabla();
    });
    
    document.getElementById('btnAnterior').addEventListener('click', () => {
        if (paginaActual > 1) {
            paginaActual--;
            renderizarTabla();
        }
    });
    
    document.getElementById('btnSiguiente').addEventListener('click', () => {
        const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
        if (paginaActual < totalPaginas) {
            paginaActual++;
            renderizarTabla();
        }
    });
    
    document.getElementById('btnUltima').addEventListener('click', () => {
        const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
        paginaActual = totalPaginas;
        renderizarTabla();
    });
    
    document.getElementById('registrosPorPagina').addEventListener('change', function() {
        registrosPorPagina = parseInt(this.value);
        paginaActual = 1;
        renderizarTabla();
    });
    
    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        
        if (termino.length === 0) {
            datosFiltrados = [...datosArticulos];
        } else {
            datosFiltrados = datosArticulos.filter(item => 
                item.codigo.toLowerCase().includes(termino) ||
                item.descripcion.toLowerCase().includes(termino) ||
                item.familia.toLowerCase().includes(termino) ||
                item.subfamilia.toLowerCase().includes(termino) ||
                item.numero_parte.toLowerCase().includes(termino) ||
                item.ubicacion.toLowerCase().includes(termino) ||
                item.cuenta_contable.toLowerCase().includes(termino)
            );
        }
        
        paginaActual = 1;
        renderizarTabla();
    });
    
    // Función para abrir modal de nuevo artículo
    window.abrirModalArticulo = function() {
        document.getElementById('modalTituloArticulo').textContent = 'Nuevo Artículo';
        document.getElementById('modalEstatusArticulo').value = 'Activo';
        document.getElementById('modalIdArticulo').value = '';
        document.getElementById('modalFamiliaArticulo').value = 'Seleccionar familia';
        document.getElementById('modalSubfamiliaArticulo').value = 'Seleccionar subfamilia';
        document.getElementById('modalCodigoArticulo').value = '';
        document.getElementById('modalNumeroParteArticulo').value = '';
        document.getElementById('modalDescripcionArticulo').value = '';
        document.getElementById('modalUbicacionArticulo').value = '';
        document.getElementById('modalMinimoArticulo').value = '';
        document.getElementById('modalMaximoArticulo').value = '';
        document.getElementById('modalReordenArticulo').value = '';
        document.getElementById('modalUnidadArticulo').value = 'Seleccionar unidad';
        document.getElementById('modalCuentaArticulo').value = '';
        document.getElementById('modalArticulo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar artículo
    window.editarArticulo = function(id) {
        const articulo = datosArticulos.find(a => a.id === id);
        if (!articulo) return;
        
        document.getElementById('modalTituloArticulo').textContent = 'Editar Artículo ' + articulo.codigo;
        document.getElementById('modalEstatusArticulo').value = articulo.estatus;
        document.getElementById('modalIdArticulo').value = articulo.id;
        document.getElementById('modalFamiliaArticulo').value = articulo.familia;
        document.getElementById('modalSubfamiliaArticulo').value = articulo.subfamilia;
        document.getElementById('modalCodigoArticulo').value = articulo.codigo;
        document.getElementById('modalNumeroParteArticulo').value = articulo.numero_parte;
        document.getElementById('modalDescripcionArticulo').value = articulo.descripcion;
        document.getElementById('modalUbicacionArticulo').value = articulo.ubicacion;
        document.getElementById('modalMinimoArticulo').value = articulo.minimo;
        document.getElementById('modalMaximoArticulo').value = articulo.maximo;
        document.getElementById('modalReordenArticulo').value = articulo.reorden;
        document.getElementById('modalUnidadArticulo').value = articulo.unidad;
        document.getElementById('modalCuentaArticulo').value = articulo.cuenta_contable;
        document.getElementById('modalArticulo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalArticulo = function() {
        document.getElementById('modalArticulo').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarArticulo = function() {
        const codigo = document.getElementById('modalCodigoArticulo').value;
        const descripcion = document.getElementById('modalDescripcionArticulo').value;
        
        if (!codigo || !descripcion) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        alert(`Artículo ${codigo} guardado correctamente`);
        cerrarModalArticulo();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalArticulo();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalArticulo').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalArticulo();
        }
    });
    
    // Funciones de agrupación y selector de columnas
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
            alert('Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'estatus', caption: 'Estatus' },
                { field: 'id', caption: 'ID' },
                { field: 'familia', caption: 'Familia' },
                { field: 'subfamilia', caption: 'Subfamilia' },
                { field: 'codigo', caption: 'Código' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'numero_parte', caption: 'Número Parte' },
                { field: 'ubicacion', caption: 'Ubicación' },
                { field: 'minimo', caption: 'Mínimo' },
                { field: 'maximo', caption: 'Máximo' },
                { field: 'reorden', caption: 'Reorden' },
                { field: 'unidad', caption: 'Unidad Medida' },
                { field: 'cuenta_contable', caption: 'Cuenta Contable' }
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
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar catálogo a Excel'));

    // Renderizar tabla inicial
    renderizarTabla();
});
</script>
@endsection