@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Almacén por Obra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Almacén por Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Selector de obra y filtros -->
                <div style="display: grid; grid-template-columns: 3fr 1fr 1fr auto; gap: 10px; margin-bottom: 20px; align-items: flex-end;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Obra</label>
                        <select id="filtroObra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas las obras</option>
                            <option value="TRC001" selected>TRC001 - Torre Residencial Cumbres</option>
                            <option value="PAC002">PAC002 - Puente Av. Constitución</option>
                            <option value="CIA003">CIA003 - Complejo Industrial Apodaca</option>
                            <option value="RHR004">RHR004 - Hospital Regional</option>
                            <option value="VPS005">VPS005 - Vialidad Periférico Sur</option>
                            <option value="PGA006">PGA006 - Plaza Galerías Monterrey</option>
                            <option value="CCM007">CCM007 - Centro Comercial Metropolitano</option>
                            <option value="UAN008">UAN008 - Unidad Habitacional Anáhuac</option>
                            <option value="PIR009">PIR009 - Parque Industrial Roble</option>
                            <option value="EST010">EST010 - Estadio Universitario</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Categoría</label>
                        <select id="filtroCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas</option>
                            <option value="Materiales">Materiales</option>
                            <option value="Herramientas">Herramientas</option>
                            <option value="Equipo">Equipo</option>
                            <option value="Consumibles">Consumibles</option>
                            <option value="Electricidad">Electricidad</option>
                            <option value="Plomería">Plomería</option>
                            <option value="Pinturas">Pinturas</option>
                            <option value="Seguridad">Seguridad</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 3px;">Familia</label>
                        <select id="filtroFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="todas">Todas</option>
                            <option value="Concreto">Concreto</option>
                            <option value="Acero">Acero</option>
                            <option value="Mampostería">Mampostería</option>
                            <option value="Eléctricas">Eléctricas</option>
                            <option value="Andamios">Andamios</option>
                            <option value="Protección">Protección</option>
                            <option value="Maquinaria">Maquinaria</option>
                            <option value="Tuberías">Tuberías</option>
                            <option value="Cableado">Cableado</option>
                            <option value="Pinturas">Pinturas</option>
                            <option value="Adhesivos">Adhesivos</option>
                            <option value="Fijaciones">Fijaciones</option>
                        </select>
                    </div>
                    <div>
                        <button id="btnFiltrar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                    </div>
                </div>

                <!-- KPIs - Resumen de la obra (centrados, borde azul, texto negro) -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Total Artículos</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiTotalArticulos">12,847</div>
                       
                    </div>
                    
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Valor Inventario</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiValorInventario">$2,845,600</div>
                        
                    </div>
                    
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Bajo Mínimo</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiBajoMinimo">15</div>
                        
                    </div>
                    
                    <div style="border: 2px solid var(--color-primary); border-radius: 4px; padding: 15px 0; background-color: white; text-align: center;">
                        <div style="font-size: 14px; font-weight: 500; color: #000000; margin-bottom: 5px;">Crítico</div>
                        <div style="font-size: 32px; font-weight: bold; color: #000000;" id="kpiCritico">7</div>
                    
                    </div>
                </div>

                <!-- Barra de herramientas con grupo de agrupación -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación (drag & drop) -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span id="obraSeleccionada" style="background-color: #e8f0fe; color: var(--color-primary); padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            TRC001 - Torre Cumbres
                        </span>
                        <button id="btnAgregar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Agregar material">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button id="btnExcel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Exportar Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button id="btnColumnas" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary);" title="Seleccionar columnas" onclick="toggleColumnSelector()">
                            <i class="fas fa-columns"></i>
                        </button>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 30px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Selector de columnas (oculto) -->
                <div id="columnSelector" style="display: none; position: absolute; right: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 250px; max-height: 400px; overflow-y: auto; padding: 10px;">
                    <div style="font-weight: bold; color: var(--color-primary); margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid #dee2e6;">Seleccionar Columnas</div>
                    <div id="columnasLista"></div>
                </div>

                <!-- Tabla de Almacén por Obra -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaInventario" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 1300px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr id="encabezadosTabla">
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="codigo">Código</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="categoria">Categoría</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="familia">Familia</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="cantidad">Cantidad</th>
                                <th style="padding: 12px 8px; color: white; text-align: left;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="costo">Costo Unit.</th>
                                <th style="padding: 12px 8px; color: white; text-align: right;" draggable="true" data-columna="importe">Importe</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="minimo">Mínimo</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="maximo">Máximo</th>
                                <th style="padding: 12px 8px; color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Los datos se cargarán vía JavaScript -->
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="4" style="padding: 10px; border-top: 2px solid var(--color-primary); text-align: right;">Totales:</td>
                                <td id="totalCantidad" style="padding: 10px; border-top: 2px solid var(--color-primary); text-align: right;">0</td>
                                <td style="padding: 10px; border-top: 2px solid var(--color-primary);"></td>
                                <td style="padding: 10px; border-top: 2px solid var(--color-primary);"></td>
                                <td id="totalImporte" style="padding: 10px; border-top: 2px solid var(--color-primary); text-align: right; font-weight: bold;">$0</td>
                                <td colspan="3" style="padding: 10px; border-top: 2px solid var(--color-primary); text-align: center;">Total Artículos: <span id="totalArticulos">0</span></td>
                                <td style="padding: 10px; border-top: 2px solid var(--color-primary); position: sticky; right: 0; background-color: #e9ecef; box-shadow: -2px 0 5px rgba(0,0,0,0.1);"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación (izquierda inferior) -->
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 13px; color: #6c757d;">Mostrando <span id="inicioRegistro">1</span> - <span id="finRegistro">10</span> de <span id="totalRegistros">50</span> artículos</span>
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
                        <span style="font-size: 13px; color: #6c757d;">de <span id="totalPaginas">5</span></span>
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnSiguiente" title="Página siguiente">
                            <i class="fas fa-angle-right"></i>
                        </button>
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid var(--color-primary); border-radius: 4px; background: transparent; cursor: pointer; color: var(--color-primary);" id="btnUltima" title="Última página">
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR MATERIAL -->
<div id="modalMaterial" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;">Agregar Material a Obra</h3>
            <button onclick="cerrarModalMaterial()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Obra</label>
                    <select id="modalObra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="TRC001">TRC001 - Torre Residencial Cumbres</option>
                        <option value="PAC002">PAC002 - Puente Av. Constitución</option>
                        <option value="CIA003">CIA003 - Complejo Industrial Apodaca</option>
                        <option value="RHR004">RHR004 - Hospital Regional</option>
                        <option value="VPS005">VPS005 - Vialidad Periférico Sur</option>
                        <option value="PGA006">PGA006 - Plaza Galerías Monterrey</option>
                        <option value="CCM007">CCM007 - Centro Comercial Metropolitano</option>
                        <option value="UAN008">UAN008 - Unidad Habitacional Anáhuac</option>
                        <option value="PIR009">PIR009 - Parque Industrial Roble</option>
                        <option value="EST010">EST010 - Estadio Universitario</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Código</label>
                    <input type="text" id="modalCodigo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="CEM-001">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" id="modalDescripcion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Cemento Gris 50kg">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Categoría</label>
                    <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Materiales</option>
                        <option>Herramientas</option>
                        <option>Equipo</option>
                        <option>Consumibles</option>
                        <option>Electricidad</option>
                        <option>Plomería</option>
                        <option>Pinturas</option>
                        <option>Seguridad</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Familia</label>
                    <select id="modalFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Concreto</option>
                        <option>Acero</option>
                        <option>Mampostería</option>
                        <option>Eléctricas</option>
                        <option>Andamios</option>
                        <option>Protección</option>
                        <option>Maquinaria</option>
                        <option>Tuberías</option>
                        <option>Cableado</option>
                        <option>Pinturas</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cantidad</label>
                    <input type="number" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="1">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Unidad</label>
                    <select id="modalUnidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Sacos</option>
                        <option>Piezas</option>
                        <option>Pares</option>
                        <option>Metros</option>
                        <option>Litros</option>
                        <option>Kilogramos</option>
                        <option>Cajas</option>
                        <option>Juegos</option>
                    </select>
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Costo Unitario</label>
                    <input type="number" id="modalCosto" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Mínimo</label>
                    <input type="number" id="modalMinimo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Máximo</label>
                    <input type="number" id="modalMaximo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="0">
                </div>
                
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalMaterial()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarMaterial()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
        border-radius: 8px;
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
        font-size: 13px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: left;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 13px;
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
    
    .table td:last-child i.fa-trash,
    .table td:last-child i.fa-file-pdf {
        color: #dc3545;
    }
    
    .table td:last-child i.fa-history {
        color: #6c757d;
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
    
    .drag-over .grupo-columnas {
        background-color: rgba(8,60,174,0.1);
        border-radius: 4px;
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
    #modalMaterial {
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
        
        div[style*="grid-template-columns: 3fr 1fr 1fr auto"] {
            grid-template-columns: 1fr 1fr !important;
        }
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 12px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        #modalMaterial > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalMaterial div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de ejemplo ampliados (50 artículos)
    const datosInventario = [
        // Materiales
        { codigo: 'CEM-001', descripcion: 'Cemento Gris 50kg', categoria: 'Materiales', familia: 'Concreto', cantidad: 350, unidad: 'Sacos', costo: 185.50, importe: 64925, minimo: 200, maximo: 500, estatus: 'Normal' },
        { codigo: 'CEM-002', descripcion: 'Cemento Blanco 25kg', categoria: 'Materiales', familia: 'Concreto', cantidad: 120, unidad: 'Sacos', costo: 210.00, importe: 25200, minimo: 80, maximo: 200, estatus: 'Normal' },
        { codigo: 'CEM-003', descripcion: 'Cemento Mortero 50kg', categoria: 'Materiales', familia: 'Concreto', cantidad: 180, unidad: 'Sacos', costo: 175.00, importe: 31500, minimo: 150, maximo: 300, estatus: 'Normal' },
        { codigo: 'CEM-004', descripcion: 'Cemento de Alta Resistencia', categoria: 'Materiales', familia: 'Concreto', cantidad: 45, unidad: 'Sacos', costo: 320.00, importe: 14400, minimo: 30, maximo: 100, estatus: 'Bajo' },
        
        { codigo: 'VAR-001', descripcion: 'Varilla Corrugada 3/8"', categoria: 'Materiales', familia: 'Acero', cantidad: 120, unidad: 'Piezas', costo: 145.20, importe: 17424, minimo: 150, maximo: 400, estatus: 'Crítico' },
        { codigo: 'VAR-002', descripcion: 'Varilla Corrugada 1/2"', categoria: 'Materiales', familia: 'Acero', cantidad: 85, unidad: 'Piezas', costo: 210.50, importe: 17892.50, minimo: 100, maximo: 300, estatus: 'Crítico' },
        { codigo: 'VAR-003', descripcion: 'Varilla Corrugada 5/8"', categoria: 'Materiales', familia: 'Acero', cantidad: 60, unidad: 'Piezas', costo: 320.00, importe: 19200, minimo: 50, maximo: 150, estatus: 'Normal' },
        { codigo: 'VAR-004', descripcion: 'Varilla Lisa 3/8"', categoria: 'Materiales', familia: 'Acero', cantidad: 200, unidad: 'Piezas', costo: 125.00, importe: 25000, minimo: 150, maximo: 400, estatus: 'Normal' },
        { codigo: 'VAR-005', descripcion: 'Malla Electrosoldada 6x6', categoria: 'Materiales', familia: 'Acero', cantidad: 35, unidad: 'Piezas', costo: 450.00, importe: 15750, minimo: 30, maximo: 80, estatus: 'Normal' },
        
        { codigo: 'BLK-001', descripcion: 'Block Hueco 15x20x40', categoria: 'Materiales', familia: 'Mampostería', cantidad: 850, unidad: 'Piezas', costo: 12.50, importe: 10625, minimo: 500, maximo: 1000, estatus: 'Bajo' },
        { codigo: 'BLK-002', descripcion: 'Block Macizo 10x20x40', categoria: 'Materiales', familia: 'Mampostería', cantidad: 600, unidad: 'Piezas', costo: 10.80, importe: 6480, minimo: 400, maximo: 800, estatus: 'Normal' },
        { codigo: 'BLK-003', descripcion: 'Block Macizo 15x20x40', categoria: 'Materiales', familia: 'Mampostería', cantidad: 450, unidad: 'Piezas', costo: 14.20, importe: 6390, minimo: 300, maximo: 600, estatus: 'Normal' },
        { codigo: 'BLK-004', descripcion: 'Tabique Rojo', categoria: 'Materiales', familia: 'Mampostería', cantidad: 1200, unidad: 'Piezas', costo: 3.50, importe: 4200, minimo: 800, maximo: 2000, estatus: 'Normal' },
        { codigo: 'BLK-005', descripcion: 'Tabicón 10x20x40', categoria: 'Materiales', familia: 'Mampostería', cantidad: 900, unidad: 'Piezas', costo: 8.75, importe: 7875, minimo: 600, maximo: 1500, estatus: 'Normal' },
        
        // Herramientas
        { codigo: 'HERR-001', descripcion: 'Taladro Percutor 1/2"', categoria: 'Herramientas', familia: 'Eléctricas', cantidad: 15, unidad: 'Piezas', costo: 1250.00, importe: 18750, minimo: 10, maximo: 20, estatus: 'Normal' },
        { codigo: 'HERR-002', descripcion: 'Pulidora Angular 4 1/2"', categoria: 'Herramientas', familia: 'Eléctricas', cantidad: 12, unidad: 'Piezas', costo: 890.00, importe: 10680, minimo: 8, maximo: 15, estatus: 'Normal' },
        { codigo: 'HERR-003', descripcion: 'Rotomartillo SDS', categoria: 'Herramientas', familia: 'Eléctricas', cantidad: 7, unidad: 'Piezas', costo: 2300.00, importe: 16100, minimo: 5, maximo: 12, estatus: 'Bajo' },
        { codigo: 'HERR-004', descripcion: 'Sierra Circular 7 1/4"', categoria: 'Herramientas', familia: 'Eléctricas', cantidad: 8, unidad: 'Piezas', costo: 1850.00, importe: 14800, minimo: 5, maximo: 10, estatus: 'Normal' },
        { codigo: 'HERR-005', descripcion: 'Martillo Demoledor', categoria: 'Herramientas', familia: 'Eléctricas', cantidad: 3, unidad: 'Piezas', costo: 4500.00, importe: 13500, minimo: 2, maximo: 5, estatus: 'Normal' },
        
        { codigo: 'HERR-006', descripcion: 'Juego de Llaves', categoria: 'Herramientas', familia: 'Manuales', cantidad: 25, unidad: 'Juegos', costo: 350.00, importe: 8750, minimo: 15, maximo: 30, estatus: 'Normal' },
        { codigo: 'HERR-007', descripcion: 'Carretilla 6.5 ft³', categoria: 'Herramientas', familia: 'Manuales', cantidad: 18, unidad: 'Piezas', costo: 1250.00, importe: 22500, minimo: 10, maximo: 25, estatus: 'Normal' },
        { codigo: 'HERR-008', descripcion: 'Pico y Pala', categoria: 'Herramientas', familia: 'Manuales', cantidad: 30, unidad: 'Piezas', costo: 280.00, importe: 8400, minimo: 20, maximo: 40, estatus: 'Normal' },
        { codigo: 'HERR-009', descripcion: 'Nivel Láser', categoria: 'Herramientas', familia: 'Precisión', cantidad: 5, unidad: 'Piezas', costo: 1850.00, importe: 9250, minimo: 3, maximo: 8, estatus: 'Normal' },
        
        // Equipo
        { codigo: 'EQP-001', descripcion: 'Andamio Metálico 3m', categoria: 'Equipo', familia: 'Andamios', cantidad: 8, unidad: 'Piezas', costo: 3450.00, importe: 27600, minimo: 5, maximo: 15, estatus: 'Normal' },
        { codigo: 'EQP-002', descripcion: 'Andamio Metálico 5m', categoria: 'Equipo', familia: 'Andamios', cantidad: 6, unidad: 'Piezas', costo: 5200.00, importe: 31200, minimo: 4, maximo: 10, estatus: 'Normal' },
        { codigo: 'EQP-003', descripcion: 'Andamio Colgante', categoria: 'Equipo', familia: 'Andamios', cantidad: 4, unidad: 'Piezas', costo: 7800.00, importe: 31200, minimo: 2, maximo: 6, estatus: 'Normal' },
        
        { codigo: 'EQP-004', descripcion: 'Revolvedora 1 saco', categoria: 'Equipo', familia: 'Maquinaria', cantidad: 3, unidad: 'Piezas', costo: 12500.00, importe: 37500, minimo: 2, maximo: 5, estatus: 'Bajo' },
        { codigo: 'EQP-005', descripcion: 'Compactadora', categoria: 'Equipo', familia: 'Maquinaria', cantidad: 2, unidad: 'Piezas', costo: 18500.00, importe: 37000, minimo: 1, maximo: 3, estatus: 'Crítico' },
        { codigo: 'EQP-006', descripcion: 'Vibrador de Concreto', categoria: 'Equipo', familia: 'Maquinaria', cantidad: 5, unidad: 'Piezas', costo: 4500.00, importe: 22500, minimo: 3, maximo: 8, estatus: 'Normal' },
        
        // Consumibles
        { codigo: 'CON-001', descripcion: 'Guantes de Seguridad', categoria: 'Consumibles', familia: 'Protección', cantidad: 450, unidad: 'Pares', costo: 45.00, importe: 20250, minimo: 200, maximo: 500, estatus: 'Normal' },
        { codigo: 'CON-002', descripcion: 'Casco de Seguridad', categoria: 'Consumibles', familia: 'Protección', cantidad: 120, unidad: 'Piezas', costo: 85.00, importe: 10200, minimo: 50, maximo: 200, estatus: 'Normal' },
        { codigo: 'CON-003', descripcion: 'Lentes de Seguridad', categoria: 'Consumibles', familia: 'Protección', cantidad: 200, unidad: 'Pares', costo: 35.00, importe: 7000, minimo: 100, maximo: 300, estatus: 'Normal' },
        { codigo: 'CON-004', descripcion: 'Arnés de Seguridad', categoria: 'Consumibles', familia: 'Protección', cantidad: 25, unidad: 'Piezas', costo: 350.00, importe: 8750, minimo: 15, maximo: 40, estatus: 'Normal' },
        { codigo: 'CON-005', descripcion: 'Tapones Auditivos', categoria: 'Consumibles', familia: 'Protección', cantidad: 300, unidad: 'Pares', costo: 12.00, importe: 3600, minimo: 150, maximo: 500, estatus: 'Normal' },
        
        // Electricidad
        { codigo: 'ELE-001', descripcion: 'Cable THW #12', categoria: 'Electricidad', familia: 'Cableado', cantidad: 500, unidad: 'Metros', costo: 8.50, importe: 4250, minimo: 300, maximo: 800, estatus: 'Normal' },
        { codigo: 'ELE-002', descripcion: 'Cable THW #10', categoria: 'Electricidad', familia: 'Cableado', cantidad: 350, unidad: 'Metros', costo: 12.00, importe: 4200, minimo: 200, maximo: 500, estatus: 'Normal' },
        { codigo: 'ELE-003', descripcion: 'Cable THW #8', categoria: 'Electricidad', familia: 'Cableado', cantidad: 200, unidad: 'Metros', costo: 18.50, importe: 3700, minimo: 150, maximo: 400, estatus: 'Normal' },
        
        { codigo: 'ELE-004', descripcion: 'Interruptor Sencillo', categoria: 'Electricidad', familia: 'Accesorios', cantidad: 80, unidad: 'Piezas', costo: 25.00, importe: 2000, minimo: 50, maximo: 150, estatus: 'Normal' },
        { codigo: 'ELE-005', descripcion: 'Contacto Doble', categoria: 'Electricidad', familia: 'Accesorios', cantidad: 60, unidad: 'Piezas', costo: 35.00, importe: 2100, minimo: 40, maximo: 100, estatus: 'Normal' },
        
        // Plomería
        { codigo: 'PLO-001', descripcion: 'Tubo PVC 2"', categoria: 'Plomería', familia: 'Tuberías', cantidad: 150, unidad: 'Piezas', costo: 45.00, importe: 6750, minimo: 100, maximo: 250, estatus: 'Normal' },
        { codigo: 'PLO-002', descripcion: 'Tubo PVC 4"', categoria: 'Plomería', familia: 'Tuberías', cantidad: 80, unidad: 'Piezas', costo: 85.00, importe: 6800, minimo: 50, maximo: 150, estatus: 'Normal' },
        { codigo: 'PLO-003', descripcion: 'Codo PVC 2"', categoria: 'Plomería', familia: 'Conexiones', cantidad: 200, unidad: 'Piezas', costo: 8.00, importe: 1600, minimo: 150, maximo: 300, estatus: 'Normal' },
        
        // Pinturas
        { codigo: 'PIN-001', descripcion: 'Pintura Vinílica Blanca', categoria: 'Pinturas', familia: 'Vinílicas', cantidad: 80, unidad: 'Galones', costo: 120.00, importe: 9600, minimo: 50, maximo: 150, estatus: 'Normal' },
        { codigo: 'PIN-002', descripcion: 'Pintura Esmalte', categoria: 'Pinturas', familia: 'Esmaltes', cantidad: 40, unidad: 'Galones', costo: 180.00, importe: 7200, minimo: 30, maximo: 80, estatus: 'Normal' },
        { codigo: 'PIN-003', descripcion: 'Impermeabilizante', categoria: 'Pinturas', familia: 'Impermeabilizantes', cantidad: 60, unidad: 'Galones', costo: 250.00, importe: 15000, minimo: 40, maximo: 100, estatus: 'Normal' },
        { codigo: 'PIN-004', descripcion: 'Thinner', categoria: 'Pinturas', familia: 'Solventes', cantidad: 45, unidad: 'Litros', costo: 45.00, importe: 2025, minimo: 30, maximo: 80, estatus: 'Normal' }
    ];

    // Variables de paginación
    let paginaActual = 1;
    let registrosPorPagina = 10;
    let datosFiltrados = [...datosInventario];
    let columnasAgrupadas = [];
    
    // Función para obtener badge de estatus
    function getBadgeEstatus(estatus, cantidad, minimo) {
        if (estatus === 'Crítico' || (minimo && cantidad < minimo * 0.5)) {
            return '<span style="background-color: #dc3545; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px;">Crítico</span>';
        } else if (estatus === 'Bajo' || (minimo && cantidad < minimo)) {
            return '<span style="background-color: #ffc107; color: #212529; padding: 3px 10px; border-radius: 20px; font-size: 11px;">Bajo</span>';
        } else {
            return '<span style="background-color: #28a745; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px;">Normal</span>';
        }
    }
    
    // Función para renderizar tabla
    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');
        const inicio = (paginaActual - 1) * registrosPorPagina;
        const fin = Math.min(inicio + registrosPorPagina, datosFiltrados.length);
        const pageData = datosFiltrados.slice(inicio, fin);
        
        let html = '';
        let totalCantidad = 0;
        let totalImporte = 0;
        
        pageData.forEach(item => {
            totalCantidad += item.cantidad;
            totalImporte += item.importe;
            
            const badge = getBadgeEstatus(item.estatus, item.cantidad, item.minimo);
            
            html += `<tr>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; font-weight: 500;">${item.codigo}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6;">${item.descripcion}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6;">${item.categoria}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6;">${item.familia}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: right; ${item.estatus === 'Crítico' ? 'color: #dc3545; font-weight: bold;' : (item.estatus === 'Bajo' ? 'color: #ffc107; font-weight: bold;' : '')}">${item.cantidad}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6;">${item.unidad}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: right;">$${item.costo.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: right; font-weight: bold;">$${item.importe.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: center;">${item.minimo}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: center;">${item.maximo}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; text-align: center;">${badge}</td>
                <td style="padding: 10px 8px; border-bottom: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle ${item.codigo}')" title="Ver"></i>
                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarMaterial('${item.codigo}')" title="Editar"></i>
                    <i class="fas fa-history" style="color: #6c757d; margin: 0 5px; cursor: pointer;" onclick="alert('Historial ${item.codigo}')" title="Historial"></i>
                </td>
            </tr>`;
        });
        
        tbody.innerHTML = html;
        
        // Actualizar totales
        document.getElementById('totalCantidad').textContent = totalCantidad;
        document.getElementById('totalImporte').textContent = '$' + totalImporte.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById('totalArticulos').textContent = datosFiltrados.length;
        
        // Actualizar KPIs
        const totalArticulos = datosFiltrados.reduce((sum, item) => sum + item.cantidad, 0);
        const valorInventario = datosFiltrados.reduce((sum, item) => sum + item.importe, 0);
        const bajoMinimo = datosFiltrados.filter(item => item.estatus === 'Bajo' || item.cantidad < item.minimo).length;
        const critico = datosFiltrados.filter(item => item.estatus === 'Crítico' || (item.minimo && item.cantidad < item.minimo * 0.5)).length;
        
        document.getElementById('kpiTotalArticulos').textContent = totalArticulos;
        document.getElementById('kpiValorInventario').textContent = '$' + valorInventario.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById('kpiBajoMinimo').textContent = bajoMinimo;
        document.getElementById('kpiCritico').textContent = critico;
        
        // Actualizar paginación
        document.getElementById('inicioRegistro').textContent = datosFiltrados.length > 0 ? inicio + 1 : 0;
        document.getElementById('finRegistro').textContent = fin;
        document.getElementById('totalRegistros').textContent = datosFiltrados.length;
        
        const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
        document.getElementById('paginaActual').textContent = paginaActual;
        document.getElementById('totalPaginas').textContent = totalPaginas;
        
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
    
    // Función de filtrado
    function aplicarFiltros() {
        const obra = document.getElementById('filtroObra').value;
        const categoria = document.getElementById('filtroCategoria').value;
        const familia = document.getElementById('filtroFamilia').value;
        const busqueda = document.getElementById('buscador').value.toLowerCase();
        
        datosFiltrados = datosInventario.filter(item => {
            let cumple = true;
            
            if (categoria !== 'todas' && item.categoria !== categoria) cumple = false;
            if (familia !== 'todas' && item.familia !== familia) cumple = false;
            
            if (busqueda) {
                const texto = `${item.codigo} ${item.descripcion} ${item.categoria} ${item.familia}`.toLowerCase();
                if (!texto.includes(busqueda)) cumple = false;
            }
            
            // Actualizar nombre de obra mostrada
            if (obra !== 'todas') {
                const obras = {
                    'TRC001': 'Torre Cumbres',
                    'PAC002': 'Puente Constitución',
                    'CIA003': 'Complejo Apodaca',
                    'RHR004': 'Hospital Regional',
                    'VPS005': 'Periférico Sur',
                    'PGA006': 'Plaza Galerías',
                    'CCM007': 'Centro Comercial',
                    'UAN008': 'Unidad Anáhuac',
                    'PIR009': 'Parque Roble',
                    'EST010': 'Estadio'
                };
                document.getElementById('obraSeleccionada').textContent = obra + ' - ' + (obras[obra] || '');
            } else {
                document.getElementById('obraSeleccionada').textContent = 'Todas las obras';
            }
            
            return cumple;
        });
        
        paginaActual = 1;
        renderizarTabla();
    }
    
    // Event listeners para filtros
    document.getElementById('btnFiltrar').addEventListener('click', aplicarFiltros);
    document.getElementById('buscador').addEventListener('input', function() {
        aplicarFiltros();
    });
    
    // Drag & drop para agrupación
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
            e.target.style.opacity = '0.5';
        }
    });
    
    document.addEventListener('dragend', (e) => {
        if (e.target.tagName === 'TH') {
            e.target.style.opacity = '1';
        }
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        document.getElementById('grupoAgrupacion').classList.add('drag-over');
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragleave', () => {
        document.getElementById('grupoAgrupacion').classList.remove('drag-over');
    });

    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        document.getElementById('grupoAgrupacion').classList.remove('drag-over');
        
        const columna = e.dataTransfer.getData('text/plain');
        
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
        }
    });

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
    
    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'codigo', caption: 'Código' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'categoria', caption: 'Categoría' },
                { field: 'familia', caption: 'Familia' },
                { field: 'cantidad', caption: 'Cantidad' },
                { field: 'unidad', caption: 'Unidad' },
                { field: 'costo', caption: 'Costo Unit.' },
                { field: 'importe', caption: 'Importe' },
                { field: 'minimo', caption: 'Mínimo' },
                { field: 'maximo', caption: 'Máximo' },
                { field: 'estatus', caption: 'Estatus' }
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
    
    // Modal
    window.abrirModalMaterial = function() {
        document.getElementById('modalMaterial').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalMaterial = function() {
        document.getElementById('modalMaterial').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarMaterial = function() {
        alert('Material agregado correctamente');
        cerrarModalMaterial();
    };
    
    window.editarMaterial = function(codigo) {
        alert('Editar material ' + codigo);
    };
    
    document.getElementById('btnAgregar').addEventListener('click', abrirModalMaterial);
    
    document.getElementById('modalMaterial').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalMaterial();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalMaterial();
        }
    });
    
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar a Excel'));
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Crear filtro personalizado'));
    
    // Inicializar
    renderizarTabla();
});
</script>
@endsection