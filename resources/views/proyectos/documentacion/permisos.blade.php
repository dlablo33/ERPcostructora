@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Permisos y Licencias -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Permisos y Licencias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE PERMISOS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Permisos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Permisos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPermisos">42</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Vigentes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Vigentes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="vigentes">28</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Por Vencer -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Vencer</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porVencer">8</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Vencidos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Vencidos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="vencidos">6</div>
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
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Permiso">
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
                            <input type="text" id="buscador" placeholder="Buscar permiso..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-clipboard-check" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Permisos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPermisos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proyecto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="autoridad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Autoridad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="oficio">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Oficio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="emision">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Emisión</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="vencimiento">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Vencimiento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="dias">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Días Restantes</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="responsable">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Responsable</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="status">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="8">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="resumenStatus">28 Vigentes · 8 Próx · 6 Vencidos</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
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
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPrimera">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnAnterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 42 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Ver Detalle de Permiso -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clipboard-check"></i> Detalle del Permiso
            </h3>
            <button id="btnCerrarDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tipo de Permiso</div>
                    <div style="font-size: 16px; font-weight: 600;" id="detalleTipo">Licencia de Construcción</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">No. Oficio</div>
                    <div style="font-size: 16px; font-weight: 600;" id="detalleOficio">LIC-MTY-2024-001</div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 14px;" id="detalleProyecto">Torre Norte Corporativa</div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Autoridad Emisora</div>
                <div style="font-size: 14px;" id="detalleAutoridad">Municipio de Monterrey</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha de Emisión</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleEmision">15/01/2024</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha de Vencimiento</div>
                    <div style="font-size: 14px; font-weight: 600;" id="detalleVencimiento">15/01/2025</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Responsable</div>
                    <div style="font-size: 14px;" id="detalleResponsable">Juan Pérez</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Días Restantes</div>
                    <div style="font-size: 14px; font-weight: 600; color: #28a745;" id="detalleDias">45 días</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Status</div>
                <div style="font-size: 14px;" id="detalleStatus"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Vigente</span></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="detalleDescripcion">
                    Permiso de construcción para torre de 25 niveles.
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documento Adjunto</div>
                <div style="display: flex; align-items: center; gap: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px;">
                    <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 20px;"></i>
                    <span style="flex: 1; font-size: 13px;">Licencia_Construccion.pdf</span>
                    <i class="fas fa-download" style="color: #083CAE; cursor: pointer;" onclick="descargarPermiso()"></i>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer;" onclick="renovarPermiso()">
                    <i class="fas fa-sync-alt"></i> Renovar
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalDetalle()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
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
    
    /* Badges para status */
    .badge-status {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-vigente {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-por-vencer {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-vencido {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-tramite {
        background-color: #cce5ff;
        color: #0d6efd;
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
        console.log('DOM completamente cargado - Permisos y Licencias');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Permisos
        const datosPermisos = [
            {
                tipo: 'Licencia de Construcción',
                proyecto: 'Torre Norte Corporativa',
                proyectoId: 'PRO-2024-001',
                autoridad: 'Municipio de Monterrey',
                oficio: 'LIC-MTY-2024-001',
                emision: '2024-01-15',
                vencimiento: '2025-01-15',
                dias: 45,
                responsable: 'Juan Pérez',
                status: 'Vigente',
                descripcion: 'Permiso de construcción para torre de 25 niveles'
            },
            {
                tipo: 'Impacto Ambiental',
                proyecto: 'Puente Vehicular Sur',
                proyectoId: 'PRO-2024-002',
                autoridad: 'SEMARNAT',
                oficio: 'SEM-2024-0892',
                emision: '2024-02-01',
                vencimiento: '2025-02-01',
                dias: 92,
                responsable: 'María García',
                status: 'Vigente',
                descripcion: 'Manifestación de impacto ambiental aprobada'
            },
            {
                tipo: 'Uso de Suelo',
                proyecto: 'Parque Industrial Norte',
                proyectoId: 'PRO-2024-003',
                autoridad: 'Municipio de Saltillo',
                oficio: 'US-SALT-2024-003',
                emision: '2024-03-10',
                vencimiento: '2025-03-10',
                dias: 120,
                responsable: 'Carlos Rodríguez',
                status: 'Vigente',
                descripcion: 'Autorización de uso de suelo industrial'
            },
            {
                tipo: 'Factibilidad Eléctrica',
                proyecto: 'Hospital Regional',
                proyectoId: 'PRO-2024-004',
                autoridad: 'CFE',
                oficio: 'CFE-2024-1567',
                emision: '2023-09-01',
                vencimiento: '2024-09-01',
                dias: 15,
                responsable: 'Ana Martínez',
                status: 'Por Vencer',
                descripcion: 'Factibilidad de suministro eléctrico'
            },
            {
                tipo: 'Factibilidad de Agua',
                proyecto: 'Planta Tratamiento',
                proyectoId: 'PRO-2024-005',
                autoridad: 'CONAGUA',
                oficio: 'CNA-2024-089',
                emision: '2024-01-15',
                vencimiento: '2025-01-15',
                dias: 45,
                responsable: 'Luis Ramírez',
                status: 'Vigente',
                descripcion: 'Factibilidad de agua potable'
            },
            {
                tipo: 'Protección Civil',
                proyecto: 'Urbanización Los Álamos',
                proyectoId: 'PRO-2024-006',
                autoridad: 'Protección Civil Estatal',
                oficio: 'PC-2023-0456',
                emision: '2023-06-10',
                vencimiento: '2024-06-10',
                dias: -5,
                responsable: 'Sofía Castro',
                status: 'Vencido',
                descripcion: 'Dictamen de protección civil'
            },
            {
                tipo: 'Vialidad',
                proyecto: 'Puente Vehicular Sur',
                proyectoId: 'PRO-2024-002',
                autoridad: 'Secretaría de Comunicaciones',
                oficio: 'SCT-2024-023',
                emision: '2024-02-20',
                vencimiento: '2025-02-20',
                dias: 110,
                responsable: 'María García',
                status: 'Vigente',
                descripcion: 'Permiso de afectación vial'
            },
            {
                tipo: 'Licencia Ambiental Única',
                proyecto: 'Parque Industrial Norte',
                proyectoId: 'PRO-2024-003',
                autoridad: 'SEMARNAT',
                oficio: 'LAU-2024-156',
                emision: '2024-04-05',
                vencimiento: '2025-04-05',
                dias: 140,
                responsable: 'Carlos Rodríguez',
                status: 'Vigente',
                descripcion: 'Licencia ambiental única'
            }
        ];
        
        datosOriginales = [...datosPermisos];
        totalRows = datosOriginales.length;
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const total = datos.length;
            const vig = datos.filter(d => d.status === 'Vigente').length;
            const prox = datos.filter(d => d.status === 'Por Vencer').length;
            const ven = datos.filter(d => d.status === 'Vencido').length;
            
            document.getElementById('totalPermisos').textContent = total;
            document.getElementById('vigentes').textContent = vig;
            document.getElementById('porVencer').textContent = prox;
            document.getElementById('vencidos').textContent = ven;
            
            document.getElementById('resumenStatus').textContent = `${vig} Vigentes · ${prox} Próx · ${ven} Vencidos`;
        }
        
        // Función para obtener clase de badge según status
        function getStatusBadgeClass(status) {
            switch(status) {
                case 'Vigente': return 'badge-vigente';
                case 'Por Vencer': return 'badge-por-vencer';
                case 'Vencido': return 'badge-vencido';
                default: return 'badge-tramite';
            }
        }
        
        // Función para obtener color de días restantes
        function getDiasColor(dias) {
            if (dias < 0) return '#dc3545';
            if (dias <= 30) return '#ffc107';
            return '#28a745';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'tipo': return item.tipo || 'Sin tipo';
                    case 'proyecto': return item.proyecto || 'Sin proyecto';
                    case 'autoridad': return item.autoridad || 'Sin autoridad';
                    case 'status': return item.status || 'Sin status';
                    case 'responsable': return item.responsable || 'Sin responsable';
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
                            case 'tipo': return item.tipo || 'Sin tipo';
                            case 'proyecto': return item.proyecto || 'Sin proyecto';
                            case 'autoridad': return item.autoridad || 'Sin autoridad';
                            case 'status': return item.status || 'Sin status';
                            case 'responsable': return item.responsable || 'Sin responsable';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item]
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
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
            const paginacionInfo = document.getElementById('paginacionInfo');
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
                    
                    // Determinar el status predominante en el grupo
                    const statusCounts = {};
                    grupo.items.forEach(item => {
                        statusCounts[item.status] = (statusCounts[item.status] || 0) + 1;
                    });
                    
                    let statusPredominante = 'Vigente';
                    let maxCount = 0;
                    for (const [status, count] of Object.entries(statusCounts)) {
                        if (count > maxCount) {
                            maxCount = count;
                            statusPredominante = status;
                        }
                    }
                    
                    let badgeClass = 'badge-vigente';
                    if (statusPredominante === 'Por Vencer') badgeClass = 'badge-por-vencer';
                    else if (statusPredominante === 'Vencido') badgeClass = 'badge-vencido';
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="10">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros)
                                    </span>
                                </div>
                                <span class="badge-status ${badgeClass}" style="margin-right: 10px;">${statusPredominante}</span>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            let badgeClass = 'badge-vigente';
                            if (item.status === 'Por Vencer') badgeClass = 'badge-por-vencer';
                            else if (item.status === 'Vencido') badgeClass = 'badge-vencido';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.tipo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.autoridad || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.oficio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.emision)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.vencimiento)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${getDiasColor(item.dias)}; font-weight: 600;">${item.dias} días</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-status ${badgeClass}">${item.status || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetallePermiso('${item.oficio}')"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarPermiso('${item.oficio}')"></i>
                                        <i class="fas fa-sync-alt" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Renovar" onclick="renovarPermiso('${item.oficio}')"></i>
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
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    let badgeClass = 'badge-vigente';
                    if (item.status === 'Por Vencer') badgeClass = 'badge-por-vencer';
                    else if (item.status === 'Vencido') badgeClass = 'badge-vencido';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.tipo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.autoridad || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.oficio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.emision)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.vencimiento)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${getDiasColor(item.dias)}; font-weight: 600;">${item.dias} días</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-status ${badgeClass}">${item.status || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetallePermiso('${item.oficio}')"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarPermiso('${item.oficio}')"></i>
                                <i class="fas fa-sync-alt" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Renovar" onclick="renovarPermiso('${item.oficio}')"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                
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
                        'tipo': 'Tipo',
                        'proyecto': 'Proyecto',
                        'autoridad': 'Autoridad',
                        'status': 'Status',
                        'responsable': 'Responsable'
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
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
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
        cargarTabla(datosPermisos);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Agregar Permiso - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaPermisos', 'Permisos');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosPermisos.filter(item => 
                item.tipo?.toLowerCase().includes(busqueda) ||
                item.proyecto?.toLowerCase().includes(busqueda) ||
                item.autoridad?.toLowerCase().includes(busqueda) ||
                item.oficio?.toLowerCase().includes(busqueda) ||
                item.responsable?.toLowerCase().includes(busqueda) ||
                item.status?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosOriginales);
            });
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
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Funciones para acciones
        window.verDetallePermiso = function(oficio) {
            const permiso = datosPermisos.find(p => p.oficio === oficio);
            if (permiso) {
                document.getElementById('detalleTipo').textContent = permiso.tipo;
                document.getElementById('detalleOficio').textContent = permiso.oficio;
                document.getElementById('detalleProyecto').textContent = permiso.proyecto;
                document.getElementById('detalleAutoridad').textContent = permiso.autoridad;
                document.getElementById('detalleEmision').textContent = formatDate(permiso.emision);
                document.getElementById('detalleVencimiento').textContent = formatDate(permiso.vencimiento);
                document.getElementById('detalleResponsable').textContent = permiso.responsable;
                document.getElementById('detalleDias').textContent = permiso.dias + ' días';
                document.getElementById('detalleDias').style.color = getDiasColor(permiso.dias);
                
                const statusSpan = document.getElementById('detalleStatus').querySelector('span');
                statusSpan.textContent = permiso.status;
                statusSpan.className = `badge-status ${getStatusBadgeClass(permiso.status)}`;
                
                document.getElementById('detalleDescripcion').textContent = permiso.descripcion;
            }
            
            document.getElementById('modalVerDetalle').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.descargarPermiso = function(oficio) {
            alert('Descargando permiso ' + oficio);
        };
        
        window.renovarPermiso = function(oficio) {
            if (confirm('¿Desea solicitar la renovación de este permiso?')) {
                alert('Solicitud de renovación enviada para ' + oficio);
            }
        };
        
        function cerrarModalDetalle() {
            document.getElementById('modalVerDetalle').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalDetalle = cerrarModalDetalle;
        
        document.getElementById('btnCerrarDetalle')?.addEventListener('click', cerrarModalDetalle);
        
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('modalVerDetalle');
            if (event.target === modal) {
                cerrarModalDetalle();
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
        }
    });
</script>
@endsection