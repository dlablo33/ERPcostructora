@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cartera de Proyectos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Cartera de Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE PROYECTOS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Proyectos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Proyectos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalProyectos">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalActivos">12</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Completados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Completados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalCompletados">6</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: En Riesgo -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Riesgo</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEnRiesgo">3</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación discreto en la esquina izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Proyecto">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar proyecto..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-project-diagram" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay proyectos para mostrar</p>
                </div>

                <!-- Tabla de Proyectos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaProyectos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <!-- ENCABEZADOS DE PROYECTOS -->
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="codigo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Código</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proyecto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cliente">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cliente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="responsable">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Responsable</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="prioridad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Prioridad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_inicio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Inicio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_fin">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Fin</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="duracion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Duración (días)</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="avance">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Avance</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="presupuesto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Presupuesto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="ejecutado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ejecutado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="desviacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Desviación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="ubicacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ubicación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="contrato">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Contrato</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="facturado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Facturado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="pendiente_cobro">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Pendiente Cobro</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Acciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente con JavaScript -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="10">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumPresupuesto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumEjecutado">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="promDesviacion">0%</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="5"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <span style="margin-left: 5px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 24 registros</span>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
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
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
        color: #000000 !important;
    }
    
    /* Estilo para las filas alternadas */
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
        cursor: pointer;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBody td i:hover {
        transform: scale(1.2);
    }
    
    /* Estilo para el filtro en encabezados */
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }
    
    .table th i:hover {
        opacity: 1;
    }
    
    /* Columna de acciones fija */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
    }
    
    .badge-en-curso {
        background-color: #2378e1;
        color: white;
    }
    
    .badge-completado {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-en-riesgo {
        background-color: #ffc107;
        color: black;
    }
    
    .badge-retrasado {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    /* Prioridades */
    .prioridad-alta {
        background-color: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 11px;
    }
    
    .prioridad-media {
        background-color: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 11px;
    }
    
    .prioridad-baja {
        background-color: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 11px;
    }
    
    /* Progress bar mini */
    .progress-mini {
        width: 80px;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        display: inline-block;
        margin-right: 5px;
    }
    
    .progress-mini-fill {
        height: 100%;
        border-radius: 4px;
    }
    
    .progress-mini-fill.success { background-color: #28a745; }
    .progress-mini-fill.warning { background-color: #ffc107; }
    .progress-mini-fill.danger { background-color: #dc3545; }
    .progress-mini-fill.primary { background-color: #2378e1; }
    
    /* Valores positivos/negativos */
    .valor-positivo {
        color: #28a745 !important;
        font-weight: 600;
    }
    
    .valor-negativo {
        color: #dc3545 !important;
        font-weight: 600;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
    }
    
    /* Estilos para agrupación de columnas */
    [draggable="true"] {
        cursor: grab;
    }
    
    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }
    
    #grupoAgrupacion {
        position: relative;
    }
    
    #grupoColumnas {
        display: inline-flex;
        align-items: center;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #f0f4ff;
        border-radius: 16px;
        color: #2378e1;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #2378e1;
    }
    
    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #2378e1;
    }
    
    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }
    
    /* Estilo para filas de grupo */
    .fila-grupo {
        background-color: #f0f7ff !important;
        font-weight: 500;
        cursor: pointer;
    }
    
    .fila-grupo:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-grupo td:first-child i {
        transition: transform 0.2s;
        margin-right: 8px;
    }
    
    .fila-grupo:not(.expandido) td:first-child i {
        transform: rotate(-90deg);
    }
    
    .fila-detalle {
        background-color: #ffffff;
    }
    
    .fila-detalle td {
        border-top: none !important;
    }
    
    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo cuando se está arrastrando sobre el área de grupo */
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Todos los elementos dentro del contenedor también sin fondo */
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    /* Excepción para los spans que deben tener fondo azul */
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
    /* Estilos para los botones de paginación */
    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }
    
    #paginacionContainer button:hover {
        opacity: 0.7;
    }
    
    #paginacionContainer button i {
        color: #2378e1 !important;
    }
    
    /* Estilo específico para btnCrearFiltro */
    #btnCrearFiltro,
    #btnCrearFiltro:hover,
    #btnCrearFiltro:focus,
    #btnCrearFiltro:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnCrearFiltro i,
    #btnCrearFiltro span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"] {
            width: 100% !important;
        }
        
        button {
            width: 100%;
        }
        
        div[style*="position: relative"] {
            width: 100%;
        }
        
        input#buscador {
            width: 100% !important;
        }
        
        #paginacionContainer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Cartera de Proyectos');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // DATOS DE EJEMPLO PARA PROYECTOS (24 proyectos)
        const datosProyectos = [
            // Proyecto 1
            {
                codigo: 'PRO-2024-001',
                proyecto: 'Torre Norte Corporativa',
                cliente: 'Inmobiliaria del Sur',
                responsable: 'Juan Pérez',
                estado: 'En Curso',
                prioridad: 'Alta',
                fecha_inicio: '2024-01-15',
                fecha_fin: '2024-12-15',
                duracion: 335,
                avance: 65,
                presupuesto: 45500000,
                ejecutado: 29575000,
                desviacion: 2.5,
                tipo: 'Construcción',
                ubicacion: 'Monterrey, NL',
                contrato: 'CON-2024-001',
                facturado: 29575000,
                pendiente_cobro: 0
            },
            // Proyecto 2
            {
                codigo: 'PRO-2024-002',
                proyecto: 'Puente Vehicular Sur',
                cliente: 'Gobierno Regional',
                responsable: 'María García',
                estado: 'En Riesgo',
                prioridad: 'Alta',
                fecha_inicio: '2024-02-01',
                fecha_fin: '2024-11-30',
                duracion: 303,
                avance: 35,
                presupuesto: 28750000,
                ejecutado: 11500000,
                desviacion: -8.2,
                tipo: 'Infraestructura',
                ubicacion: 'Guadalajara, Jal',
                contrato: 'CON-2024-002',
                facturado: 11500000,
                pendiente_cobro: 0
            },
            // Proyecto 3
            {
                codigo: 'PRO-2024-003',
                proyecto: 'Parque Industrial Norte',
                cliente: 'Constructora ABC',
                responsable: 'Carlos Rodríguez',
                estado: 'Activo',
                prioridad: 'Media',
                fecha_inicio: '2024-03-10',
                fecha_fin: '2025-03-10',
                duracion: 365,
                avance: 25,
                presupuesto: 52300000,
                ejecutado: 13075000,
                desviacion: 1.2,
                tipo: 'Industrial',
                ubicacion: 'Saltillo, Coah',
                contrato: 'CON-2024-003',
                facturado: 13075000,
                pendiente_cobro: 0
            },
            // Proyecto 4
            {
                codigo: 'PRO-2023-004',
                proyecto: 'Hospital Regional',
                cliente: 'Ministerio de Salud',
                responsable: 'Ana Martínez',
                estado: 'Completado',
                prioridad: 'Baja',
                fecha_inicio: '2023-09-01',
                fecha_fin: '2024-04-30',
                duracion: 242,
                avance: 100,
                presupuesto: 78900000,
                ejecutado: 76533000,
                desviacion: 3.0,
                tipo: 'Salud',
                ubicacion: 'Tijuana, BC',
                contrato: 'CON-2023-004',
                facturado: 78900000,
                pendiente_cobro: 0
            },
            // Proyecto 5
            {
                codigo: 'PRO-2024-005',
                proyecto: 'Planta Tratamiento',
                cliente: 'Minera del Norte',
                responsable: 'Juan Pérez',
                estado: 'Retrasado',
                prioridad: 'Alta',
                fecha_inicio: '2024-01-15',
                fecha_fin: '2024-10-15',
                duracion: 274,
                avance: 45,
                presupuesto: 34200000,
                ejecutado: 18810000,
                desviacion: -15.3,
                tipo: 'Industrial',
                ubicacion: 'Zacatecas, Zac',
                contrato: 'CON-2024-005',
                facturado: 18810000,
                pendiente_cobro: 0
            },
            // Proyecto 6
            {
                codigo: 'PRO-2024-006',
                proyecto: 'Urbanización Los Álamos',
                cliente: 'Inmobiliaria del Sur',
                responsable: 'María García',
                estado: 'Activo',
                prioridad: 'Media',
                fecha_inicio: '2024-02-20',
                fecha_fin: '2025-08-20',
                duracion: 547,
                avance: 15,
                presupuesto: 67800000,
                ejecutado: 10170000,
                desviacion: 0.5,
                tipo: 'Urbanización',
                ubicacion: 'Querétaro, Qro',
                contrato: 'CON-2024-006',
                facturado: 10170000,
                pendiente_cobro: 0
            },
            // Proyecto 7
            {
                codigo: 'PRO-2024-007',
                proyecto: 'Centro Comercial Plaza',
                cliente: 'Grupo GICSA',
                responsable: 'Luis Ramírez',
                estado: 'En Curso',
                prioridad: 'Media',
                fecha_inicio: '2024-04-05',
                fecha_fin: '2025-06-05',
                duracion: 426,
                avance: 30,
                presupuesto: 89200000,
                ejecutado: 26760000,
                desviacion: 1.8,
                tipo: 'Comercial',
                ubicacion: 'Puebla, Pue',
                contrato: 'CON-2024-007',
                facturado: 26760000,
                pendiente_cobro: 0
            },
            // Proyecto 8
            {
                codigo: 'PRO-2024-008',
                proyecto: 'Planta Solar',
                cliente: 'CFE',
                responsable: 'Sofía Castro',
                estado: 'En Riesgo',
                prioridad: 'Alta',
                fecha_inicio: '2024-03-15',
                fecha_fin: '2024-12-15',
                duracion: 275,
                avance: 40,
                presupuesto: 124000000,
                ejecutado: 49600000,
                desviacion: -5.7,
                tipo: 'Energía',
                ubicacion: 'Hermosillo, Son',
                contrato: 'CON-2024-008',
                facturado: 49600000,
                pendiente_cobro: 0
            },
            // Proyecto 9
            {
                codigo: 'PRO-2023-009',
                proyecto: 'Puerto Seco',
                cliente: 'Grupo México',
                responsable: 'Miguel Torres',
                estado: 'Completado',
                prioridad: 'Baja',
                fecha_inicio: '2023-10-10',
                fecha_fin: '2024-05-10',
                duracion: 213,
                avance: 100,
                presupuesto: 45600000,
                ejecutado: 44232000,
                desviacion: 3.0,
                tipo: 'Logística',
                ubicacion: 'Nuevo Laredo, Tamps',
                contrato: 'CON-2023-009',
                facturado: 45600000,
                pendiente_cobro: 0
            },
            // Proyecto 10
            {
                codigo: 'PRO-2024-010',
                proyecto: 'Hotel Playa',
                cliente: 'Grupo Posadas',
                responsable: 'Diana Flores',
                estado: 'Activo',
                prioridad: 'Media',
                fecha_inicio: '2024-05-20',
                fecha_fin: '2025-11-20',
                duracion: 549,
                avance: 10,
                presupuesto: 156000000,
                ejecutado: 15600000,
                desviacion: 0.2,
                tipo: 'Turismo',
                ubicacion: 'Cancún, QR',
                contrato: 'CON-2024-010',
                facturado: 15600000,
                pendiente_cobro: 0
            },
            // Proyecto 11
            {
                codigo: 'PRO-2024-011',
                proyecto: 'Acueducto',
                cliente: 'CONAGUA',
                responsable: 'Roberto Sánchez',
                estado: 'En Curso',
                prioridad: 'Alta',
                fecha_inicio: '2024-02-28',
                fecha_fin: '2025-02-28',
                duracion: 366,
                avance: 55,
                presupuesto: 93400000,
                ejecutado: 51370000,
                desviacion: 2.3,
                tipo: 'Hidráulico',
                ubicacion: 'Mexicali, BC',
                contrato: 'CON-2024-011',
                facturado: 51370000,
                pendiente_cobro: 0
            },
            // Proyecto 12
            {
                codigo: 'PRO-2024-012',
                proyecto: 'Universidad',
                cliente: 'SEP',
                responsable: 'Laura Gómez',
                estado: 'Activo',
                prioridad: 'Media',
                fecha_inicio: '2024-06-01',
                fecha_fin: '2026-05-31',
                duracion: 730,
                avance: 5,
                presupuesto: 245000000,
                ejecutado: 12250000,
                desviacion: 0.0,
                tipo: 'Educación',
                ubicacion: 'Mérida, Yuc',
                contrato: 'CON-2024-012',
                facturado: 12250000,
                pendiente_cobro: 0
            },
            // Proyecto 13
            {
                codigo: 'PRO-2023-013',
                proyecto: 'Carretera',
                cliente: 'SCT',
                responsable: 'Pedro Hernández',
                estado: 'Completado',
                prioridad: 'Baja',
                fecha_inicio: '2023-08-15',
                fecha_fin: '2024-02-15',
                duracion: 184,
                avance: 100,
                presupuesto: 67800000,
                ejecutado: 66444000,
                desviacion: 2.0,
                tipo: 'Vialidad',
                ubicacion: 'Durango, Dgo',
                contrato: 'CON-2023-013',
                facturado: 67800000,
                pendiente_cobro: 0
            },
            // Proyecto 14
            {
                codigo: 'PRO-2024-014',
                proyecto: 'Parque Eólico',
                cliente: 'Iberdrola',
                responsable: 'Javier Ruiz',
                estado: 'En Riesgo',
                prioridad: 'Alta',
                fecha_inicio: '2024-01-20',
                fecha_fin: '2025-01-20',
                duracion: 366,
                avance: 38,
                presupuesto: 189000000,
                ejecutado: 71820000,
                desviacion: -7.5,
                tipo: 'Energía',
                ubicacion: 'Oaxaca, Oax',
                contrato: 'CON-2024-014',
                facturado: 71820000,
                pendiente_cobro: 0
            },
            // Proyecto 15
            {
                codigo: 'PRO-2024-015',
                proyecto: 'Puerto Deportivo',
                cliente: 'Grupo Vidanta',
                responsable: 'Ana Martínez',
                estado: 'Activo',
                prioridad: 'Media',
                fecha_inicio: '2024-07-10',
                fecha_fin: '2026-01-10',
                duracion: 549,
                avance: 8,
                presupuesto: 312000000,
                ejecutado: 24960000,
                desviacion: 0.3,
                tipo: 'Turismo',
                ubicacion: 'Los Cabos, BCS',
                contrato: 'CON-2024-015',
                facturado: 24960000,
                pendiente_cobro: 0
            }
        ];
        
        // Completar hasta 24 proyectos
        for (let i = 16; i <= 24; i++) {
            let estado = 'Activo';
            if (i % 3 === 0) estado = 'En Curso';
            if (i % 4 === 0) estado = 'Completado';
            if (i % 5 === 0) estado = 'En Riesgo';
            
            let prioridad = 'Media';
            if (i % 3 === 0) prioridad = 'Alta';
            if (i % 4 === 0) prioridad = 'Baja';
            
            let presupuesto = 15000000 + (i * 2500000);
            let avance = Math.floor(Math.random() * 100);
            
            datosProyectos.push({
                codigo: `PRO-2024-${String(i).padStart(3, '0')}`,
                proyecto: `Proyecto Demo ${i}`,
                cliente: `Cliente Demo ${i}`,
                responsable: `Responsable ${i}`,
                estado: estado,
                prioridad: prioridad,
                fecha_inicio: '2024-01-01',
                fecha_fin: '2024-12-31',
                duracion: 365,
                avance: avance,
                presupuesto: presupuesto,
                ejecutado: presupuesto * (avance / 100),
                desviacion: (Math.random() * 10 - 5).toFixed(1),
                tipo: 'General',
                ubicacion: 'México',
                contrato: `CON-2024-${String(i).padStart(3, '0')}`,
                facturado: presupuesto * (avance / 100),
                pendiente_cobro: 0
            });
        }
        
        datosOriginales = [...datosProyectos];
        totalRows = datosOriginales.length;
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear porcentaje
        function formatPercent(value) {
            return value.toFixed(1) + '%';
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para obtener clase de badge según estado
        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'Activo': return 'badge-activo';
                case 'En Curso': return 'badge-en-curso';
                case 'Completado': return 'badge-completado';
                case 'En Riesgo': return 'badge-en-riesgo';
                case 'Retrasado': return 'badge-retrasado';
                default: return 'badge-pendiente';
            }
        }
        
        // Función para obtener clase de prioridad
        function getPrioridadClass(prioridad) {
            switch(prioridad) {
                case 'Alta': return 'prioridad-alta';
                case 'Media': return 'prioridad-media';
                case 'Baja': return 'prioridad-baja';
                default: return 'prioridad-media';
            }
        }
        
        // Función para obtener clase de progreso
        function getProgressClass(avance) {
            if (avance >= 75) return 'success';
            if (avance >= 50) return 'primary';
            if (avance >= 25) return 'warning';
            return 'danger';
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const totalProyectos = datos.length;
            const activos = datos.filter(d => d.estado === 'Activo').length;
            const completados = datos.filter(d => d.estado === 'Completado').length;
            const enRiesgo = datos.filter(d => d.estado === 'En Riesgo').length;
            
            document.getElementById('totalProyectos').textContent = totalProyectos;
            document.getElementById('totalActivos').textContent = activos;
            document.getElementById('totalCompletados').textContent = completados;
            document.getElementById('totalEnRiesgo').textContent = enRiesgo;
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'estado': return item.estado || 'Sin estado';
                    case 'prioridad': return item.prioridad || 'Sin prioridad';
                    case 'responsable': return item.responsable || 'Sin responsable';
                    case 'tipo': return item.tipo || 'Sin tipo';
                    case 'ubicacion': return item.ubicacion || 'Sin ubicación';
                    case 'cliente': return item.cliente || 'Sin cliente';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'estado': return item.estado || 'Sin estado';
                            case 'prioridad': return item.prioridad || 'Sin prioridad';
                            case 'responsable': return item.responsable || 'Sin responsable';
                            case 'tipo': return item.tipo || 'Sin tipo';
                            case 'ubicacion': return item.ubicacion || 'Sin ubicación';
                            case 'cliente': return item.cliente || 'Sin cliente';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalPresupuesto: item.presupuesto || 0,
                        totalEjecutado: item.ejecutado || 0,
                        totalFacturado: item.facturado || 0,
                        totalPendiente: item.pendiente_cobro || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalPresupuesto += item.presupuesto || 0;
                    grupo.totalEjecutado += item.ejecutado || 0;
                    grupo.totalFacturado += item.facturado || 0;
                    grupo.totalPendiente += item.pendiente_cobro || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalPresupuesto = 0;
            let totalEjecutado = 0;
            let sumaDesviacion = 0;
            let countDesviacion = 0;
            
            datos.forEach(item => {
                totalPresupuesto += item.presupuesto || 0;
                totalEjecutado += item.ejecutado || 0;
                if (item.desviacion !== undefined) {
                    sumaDesviacion += item.desviacion;
                    countDesviacion++;
                }
            });
            
            const promedioDesviacion = countDesviacion > 0 ? sumaDesviacion / countDesviacion : 0;
            
            document.getElementById('sumPresupuesto').textContent = formatCurrency(totalPresupuesto);
            document.getElementById('sumEjecutado').textContent = formatCurrency(totalEjecutado);
            document.getElementById('promDesviacion').textContent = promedioDesviacion.toFixed(1) + '%';
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            document.getElementById('paginaActual').textContent = currentPage;
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            // Actualizar contadores de los cuadros
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumPresupuesto').textContent = '$0.00';
                document.getElementById('sumEjecutado').textContent = '$0.00';
                document.getElementById('promDesviacion').textContent = '0%';
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="19">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} proyectos - Presupuesto: ${formatCurrency(grupo.totalPresupuesto)} - Ejecutado: ${formatCurrency(grupo.totalEjecutado)})
                                    </span>
                                </div>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;"><strong>${item.codigo || '-'}</strong></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${getEstadoBadgeClass(item.estado)}">${item.estado || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="${getPrioridadClass(item.prioridad)}">${item.prioridad || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_inicio)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_fin)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; text-align: center;">${item.duracion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                    <div style="display: flex; align-items: center;">
                                        <div class="progress-mini">
                                            <div class="progress-mini-fill ${getProgressClass(item.avance)}" style="width: ${item.avance}%"></div>
                                        </div>
                                        ${item.avance}%
                                    </div>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.presupuesto ? formatCurrency(item.presupuesto) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.ejecutado ? formatCurrency(item.ejecutado) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; ${item.desviacion >= 0 ? 'valor-positivo' : 'valor-negativo'}">${item.desviacion ? formatPercent(item.desviacion) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.ubicacion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contrato || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.facturado ? formatCurrency(item.facturado) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.pendiente_cobro ? formatCurrency(item.pendiente_cobro) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver avance"></i>
                                        <i class="fas fa-file-invoice" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Facturas"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = datos.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} proyectos`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><strong>${item.codigo || '-'}</strong></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${getEstadoBadgeClass(item.estado)}">${item.estado || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="${getPrioridadClass(item.prioridad)}">${item.prioridad || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_inicio)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_fin)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; text-align: center;">${item.duracion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <div style="display: flex; align-items: center;">
                                <div class="progress-mini">
                                    <div class="progress-mini-fill ${getProgressClass(item.avance)}" style="width: ${item.avance}%"></div>
                                </div>
                                ${item.avance}%
                            </div>
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.presupuesto ? formatCurrency(item.presupuesto) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.ejecutado ? formatCurrency(item.ejecutado) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; ${item.desviacion >= 0 ? 'valor-positivo' : 'valor-negativo'}">${item.desviacion ? formatPercent(item.desviacion) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.ubicacion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.contrato || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.facturado ? formatCurrency(item.facturado) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.pendiente_cobro ? formatCurrency(item.pendiente_cobro) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                <i class="fas fa-chart-line" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver avance"></i>
                                <i class="fas fa-file-invoice" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Facturas"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                calcularTotales(datos);
                
                actualizarPaginacion(datos.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'estado': 'Estado',
                        'prioridad': 'Prioridad',
                        'responsable': 'Responsable',
                        'tipo': 'Tipo',
                        'ubicacion': 'Ubicación',
                        'cliente': 'Cliente'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTabla(datosOriginales);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                // Solo permitir agrupar por columnas que tengan sentido agrupar
                const columnasAgrupables = ['estado', 'prioridad', 'responsable', 'tipo', 'ubicacion', 'cliente'];
                
                if (columna && columnasAgrupables.includes(columna) && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                } else if (!columnasAgrupables.includes(columna)) {
                    alert('Solo se puede agrupar por: Estado, Prioridad, Responsable, Tipo, Ubicación o Cliente');
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTabla(datosOriginales);
            }
        });
        
        // Cargar datos iniciales
        cargarTabla(datosProyectos);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
            mostrarNotificacion('Filtro de fecha aplicado', 'info');
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
            mostrarNotificacion('Filtro de fecha aplicado', 'info');
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            mostrarNotificacion('Crear filtro - Funcionalidad en desarrollo', 'info');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            mostrarNotificacion('Agregar nuevo proyecto - Funcionalidad en desarrollo', 'info');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaProyectos', 'Cartera_Proyectos');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            mostrarNotificacion('Selector de Columnas - Funcionalidad en desarrollo', 'info');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosProyectos.filter(item => 
                item.codigo?.toLowerCase().includes(busqueda) ||
                item.proyecto?.toLowerCase().includes(busqueda) ||
                item.cliente?.toLowerCase().includes(busqueda) ||
                item.responsable?.toLowerCase().includes(busqueda) ||
                item.estado?.toLowerCase().includes(busqueda) ||
                item.tipo?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            currentPage = totalPages;
            cargarTabla(datosOriginales);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                mostrarNotificacion('Filtro de columna - Funcionalidad en desarrollo', 'info');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                const fila = e.target.closest('tr');
                const codigo = fila?.cells[0]?.textContent || 'desconocido';
                mostrarNotificacion(`Ver detalles del proyecto ${codigo}`, 'info');
            } else if (e.target.classList.contains('fa-edit')) {
                mostrarNotificacion('Editar proyecto - Funcionalidad en desarrollo', 'info');
            } else if (e.target.classList.contains('fa-chart-line')) {
                mostrarNotificacion('Ver avance del proyecto - Funcionalidad en desarrollo', 'info');
            } else if (e.target.classList.contains('fa-file-invoice')) {
                mostrarNotificacion('Ver facturas del proyecto - Funcionalidad en desarrollo', 'info');
            }
        });
        
        // Clic en fila para ver detalles
        document.addEventListener('click', function(e) {
            const fila = e.target.closest('tr');
            if (fila && !fila.classList.contains('fila-grupo') && !e.target.closest('i')) {
                const codigo = fila.cells[0]?.textContent || 'desconocido';
                mostrarNotificacion(`Vista rápida del proyecto ${codigo}`, 'info');
            }
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
            
            mostrarNotificacion('Exportando a Excel...', 'success');
        }
        
        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo) {
            // Crear elemento de notificación
            const notificacion = document.createElement('div');
            notificacion.style.position = 'fixed';
            notificacion.style.top = '20px';
            notificacion.style.right = '20px';
            notificacion.style.padding = '12px 20px';
            notificacion.style.backgroundColor = tipo === 'success' ? '#28a745' : '#17a2b8';
            notificacion.style.color = 'white';
            notificacion.style.borderRadius = '4px';
            notificacion.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
            notificacion.style.zIndex = '9999';
            notificacion.style.fontSize = '14px';
            notificacion.style.animation = 'fadeIn 0.3s';
            notificacion.textContent = mensaje;
            
            document.body.appendChild(notificacion);
            
            setTimeout(() => {
                notificacion.remove();
            }, 3000);
        }
    });
</script>
@endsection