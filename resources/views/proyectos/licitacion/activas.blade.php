@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Licitaciones Activas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Licitaciones Activas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE LICITACIONES CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Licitaciones -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalLicitaciones">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: En Proceso -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Proceso</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="enProceso">15</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Adjudicadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Adjudicadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="adjudicadas">6</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Por Vencer -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Vencer</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porVencer">8</div>
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
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Licitación">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Filtrar -->
                        <div>
                            <button id="btnFiltrar" 
                                    style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;"
                                    title="Filtros avanzados">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar licitación..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-contract" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin licitaciones</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Licitaciones -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaLicitaciones" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="no_licitacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Licitación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="nombre">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Nombre / Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cliente">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cliente / Dependencia</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_publicacion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Publicación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_cierre">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Cierre</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="dias_restantes">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Días Restantes</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="monto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto Estimado</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalMonto">$285,500,000</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="3"></td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 24 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar Licitación -->
<div id="modalAgregarLicitacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nueva Licitación</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Licitación <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="modalNoLicitacion" placeholder="Ej: LIC-2026-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente/Dependencia <span style="color: #dc3545;">*</span></label>
                    <select id="modalCliente" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="gobierno">Gobierno del Estado</option>
                        <option value="municipio">Municipio de Monterrey</option>
                        <option value="semarnat">SEMARNAT</option>
                        <option value="cfe">CFE</option>
                        <option value="conagua">CONAGUA</option>
                        <option value="privado">Empresa Privada</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre / Descripción <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalNombre" placeholder="Descripción de la licitación" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Publicación</label>
                    <input type="date" id="modalFechaPublicacion" value="2026-03-01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Cierre</label>
                    <input type="date" id="modalFechaCierre" value="2026-04-15" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Monto Estimado</label>
                <input type="text" id="modalMonto" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                <select id="modalResponsable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="Juan Pérez">Juan Pérez</option>
                    <option value="María García">María García</option>
                    <option value="Carlos Rodríguez">Carlos Rodríguez</option>
                    <option value="Ana Martínez">Ana Martínez</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Documentos</label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra los archivos aquí o <span style="color: #083CAE; cursor: pointer;" onclick="document.getElementById('fileInput').click()">selecciona</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">PDF, DOC, XLS (Max. 25MB)</p>
                    <input type="file" id="fileInput" style="display: none;" multiple>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Licitación</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Licitación -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-file-contract"></i> Detalle de Licitación
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Encabezado -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">No. Licitación</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="verNoLicitacion">LIC-2026-001</div>
                </div>
                <div>
                    <span style="background-color: #28a745; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="verEstado">En Proceso</span>
                </div>
            </div>

            <!-- Información principal -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Nombre / Descripción</div>
                <div style="font-size: 16px; font-weight: 600;" id="verNombre">Construcción de Puente Vehicular</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Cliente / Dependencia</div>
                    <div style="font-size: 14px;" id="verCliente">Gobierno del Estado</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Responsable</div>
                    <div style="font-size: 14px;" id="verResponsable">Juan Pérez</div>
                </div>
            </div>

            <!-- Fechas -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Publicación</div>
                    <div style="font-size: 15px; font-weight: 600;" id="verFechaPublicacion">01/03/2026</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Fecha Cierre</div>
                    <div style="font-size: 15px; font-weight: 600;" id="verFechaCierre">15/04/2026</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px;">Días Restantes</div>
                    <div style="font-size: 15px; font-weight: 600; color: #28a745;" id="verDias">35 días</div>
                </div>
            </div>

            <!-- Monto -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Monto Estimado</div>
                <div style="font-size: 24px; font-weight: 700; color: #083CAE;" id="verMonto">$28,500,000</div>
            </div>

            <!-- Observaciones -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="verObservaciones">
                    Proyecto de infraestructura vial para conectar zonas industriales.
                </div>
            </div>

            <!-- Documentos -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documentos Adjuntos</div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                        <span style="font-size: 13px;">Convocatoria.pdf</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                    <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 8px 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-excel" style="color: #28a745;"></i>
                        <span style="font-size: 13px;">Bases.xlsx</span>
                        <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                    </div>
                </div>
            </div>

            <!-- Historial de movimientos -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Historial de Movimientos</div>
                <div style="border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                    <div style="display: flex; gap: 10px; padding: 5px 0; border-bottom: 1px dashed #dee2e6;">
                        <span style="color: #6c757d; font-size: 11px;">15/03/2026</span>
                        <span style="font-size: 12px;">Se recibieron 3 solicitudes de aclaración</span>
                    </div>
                    <div style="display: flex; gap: 10px; padding: 5px 0; border-bottom: 1px dashed #dee2e6;">
                        <span style="color: #6c757d; font-size: 11px;">10/03/2026</span>
                        <span style="font-size: 12px;">Junta de aclaraciones realizada</span>
                    </div>
                    <div style="display: flex; gap: 10px; padding: 5px 0;">
                        <span style="color: #6c757d; font-size: 11px;">01/03/2026</span>
                        <span style="font-size: 12px;">Licitación publicada</span>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="participarLicitacion()">
                    <i class="fas fa-check-circle"></i> Participar
                </button>
                <button style="padding: 8px 15px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer;" onclick="editarLicitacion()">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalVer()">
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
    
    /* Badges para estado */
    .badge-estado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-proceso {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-adjudicada {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-por-vencer {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-vencida {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-participando {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    /* Badge para participación */
    .badge-participa {
        background-color: #083CAE;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: 5px;
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
        console.log('DOM completamente cargado - Licitaciones Activas');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Licitaciones
        const datosLicitaciones = [
            {
                no_licitacion: 'LIC-2026-001',
                nombre: 'Construcción de Puente Vehicular en Av. Constitución',
                cliente: 'Gobierno del Estado',
                fecha_publicacion: '2026-03-01',
                fecha_cierre: '2026-04-15',
                dias: 35,
                monto: 28500000,
                responsable: 'Juan Pérez',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Proyecto de infraestructura vial para conectar zonas industriales',
                documentos: ['Convocatoria.pdf', 'Bases.xlsx']
            },
            {
                no_licitacion: 'LIC-2026-002',
                nombre: 'Rehabilitación de Red de Agua Potable - Sector Norte',
                cliente: 'CONAGUA',
                fecha_publicacion: '2026-02-15',
                fecha_cierre: '2026-03-30',
                dias: 19,
                monto: 12400000,
                responsable: 'María García',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Sustitución de 5km de tubería',
                documentos: ['Convocatoria.pdf', 'Especificaciones.pdf']
            },
            {
                no_licitacion: 'LIC-2026-003',
                nombre: 'Construcción de Parque Industrial Fase 2',
                cliente: 'Fideicomiso de Desarrollo',
                fecha_publicacion: '2026-01-10',
                fecha_cierre: '2026-02-28',
                dias: -11,
                monto: 45800000,
                responsable: 'Carlos Rodríguez',
                estado: 'Vencida',
                participa: false,
                observaciones: 'Segunda etapa del parque industrial',
                documentos: ['Convocatoria.pdf', 'Planos.dwg']
            },
            {
                no_licitacion: 'LIC-2026-004',
                nombre: 'Suministro de Equipo Médico - Hospital Regional',
                cliente: 'Secretaría de Salud',
                fecha_publicacion: '2026-03-05',
                fecha_cierre: '2026-04-20',
                dias: 40,
                monto: 18500000,
                responsable: 'Ana Martínez',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Equipamiento para nueva ala hospitalaria',
                documentos: ['Convocatoria.pdf', 'Especificaciones.pdf']
            },
            {
                no_licitacion: 'LIC-2026-005',
                nombre: 'Mantenimiento de Red Eléctrica Zona Sur',
                cliente: 'CFE',
                fecha_publicacion: '2026-02-20',
                fecha_cierre: '2026-03-25',
                dias: 14,
                monto: 8900000,
                responsable: 'Juan Pérez',
                estado: 'En Proceso',
                participa: false,
                observaciones: 'Mantenimiento preventivo y correctivo',
                documentos: ['Convocatoria.pdf']
            },
            {
                no_licitacion: 'LIC-2026-006',
                nombre: 'Construcción de Planta de Tratamiento',
                cliente: 'CONAGUA',
                fecha_publicacion: '2026-01-05',
                fecha_cierre: '2026-02-20',
                dias: -18,
                monto: 62500000,
                responsable: 'María García',
                estado: 'Vencida',
                participa: true,
                observaciones: 'Planta para tratamiento de aguas residuales',
                documentos: ['Convocatoria.pdf', 'Estudio_Impacto.pdf']
            },
            {
                no_licitacion: 'LIC-2026-007',
                nombre: 'Edificación de Centro Comunitario',
                cliente: 'Municipio de Monterrey',
                fecha_publicacion: '2026-03-10',
                fecha_cierre: '2026-04-25',
                dias: 45,
                monto: 15200000,
                responsable: 'Carlos Rodríguez',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Centro comunitario con áreas deportivas',
                documentos: ['Convocatoria.pdf', 'Planos.pdf']
            },
            {
                no_licitacion: 'LIC-2026-008',
                nombre: 'Pavimentación de Vialidades',
                cliente: 'Gobierno del Estado',
                fecha_publicacion: '2026-02-01',
                fecha_cierre: '2026-03-15',
                dias: 4,
                monto: 21300000,
                responsable: 'Ana Martínez',
                estado: 'Por Vencer',
                participa: true,
                observaciones: 'Pavimentación de 8km en zona norte',
                documentos: ['Convocatoria.pdf', 'Presupuesto.xlsx']
            },
            {
                no_licitacion: 'LIC-2026-009',
                nombre: 'Impermeabilización de Escuelas',
                cliente: 'SEP',
                fecha_publicacion: '2026-02-25',
                fecha_cierre: '2026-03-20',
                dias: 9,
                monto: 5600000,
                responsable: 'Juan Pérez',
                estado: 'Por Vencer',
                participa: false,
                observaciones: 'Trabajos en 15 escuelas',
                documentos: ['Convocatoria.pdf']
            },
            {
                no_licitacion: 'LIC-2026-010',
                nombre: 'Estudio de Impacto Ambiental',
                cliente: 'SEMARNAT',
                fecha_publicacion: '2026-03-12',
                fecha_cierre: '2026-04-30',
                dias: 50,
                monto: 3450000,
                responsable: 'María García',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Para proyecto de desarrollo turístico',
                documentos: ['Convocatoria.pdf', 'Terminos.pdf']
            },
            {
                no_licitacion: 'LIC-2026-011',
                nombre: 'Construcción de Módulo Deportivo',
                cliente: 'Municipio de Saltillo',
                fecha_publicacion: '2026-02-10',
                fecha_cierre: '2026-03-05',
                dias: -6,
                monto: 18700000,
                responsable: 'Carlos Rodríguez',
                estado: 'Vencida',
                participa: false,
                observaciones: 'Canchas y áreas recreativas',
                documentos: ['Convocatoria.pdf', 'Planos.pdf']
            },
            {
                no_licitacion: 'LIC-2026-012',
                nombre: 'Sistema de Riego Agrícola',
                cliente: 'SAGARPA',
                fecha_publicacion: '2026-03-08',
                fecha_cierre: '2026-04-22',
                dias: 42,
                monto: 22400000,
                responsable: 'Ana Martínez',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Sistema para 200 hectáreas',
                documentos: ['Convocatoria.pdf', 'Especificaciones.pdf']
            },
            {
                no_licitacion: 'LIC-2026-013',
                nombre: 'Remodelación de Oficinas Gubernamentales',
                cliente: 'Gobierno del Estado',
                fecha_publicacion: '2026-01-20',
                fecha_cierre: '2026-03-01',
                dias: -10,
                monto: 14200000,
                responsable: 'Juan Pérez',
                estado: 'Adjudicada',
                participa: true,
                observaciones: 'Adjudicada a nuestra empresa',
                documentos: ['Convocatoria.pdf', 'Contrato.pdf']
            },
            {
                no_licitacion: 'LIC-2026-014',
                nombre: 'Alumbrado Público LED',
                cliente: 'Municipio de Monterrey',
                fecha_publicacion: '2026-03-15',
                fecha_cierre: '2026-04-29',
                dias: 49,
                monto: 9800000,
                responsable: 'María García',
                estado: 'En Proceso',
                participa: true,
                observaciones: 'Sustitución de 500 luminarias',
                documentos: ['Convocatoria.pdf', 'Especificaciones.pdf']
            }
        ];
        
        datosOriginales = [...datosLicitaciones];
        totalRows = datosOriginales.length;
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const total = datos.length;
            const enProceso = datos.filter(d => d.estado === 'En Proceso').length;
            const adjudicadas = datos.filter(d => d.estado === 'Adjudicada').length;
            const porVencer = datos.filter(d => d.dias > 0 && d.dias <= 15).length;
            
            document.getElementById('totalLicitaciones').textContent = total;
            document.getElementById('enProceso').textContent = enProceso;
            document.getElementById('adjudicadas').textContent = adjudicadas;
            document.getElementById('porVencer').textContent = porVencer;
            
            // Calcular monto total
            let totalMonto = 0;
            datos.forEach(d => {
                totalMonto += d.monto;
            });
            document.getElementById('totalMonto').textContent = formatCurrency(totalMonto);
        }
        
        // Función para obtener clase de badge según estado
        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'En Proceso': return 'badge-proceso';
                case 'Adjudicada': return 'badge-adjudicada';
                case 'Por Vencer': return 'badge-por-vencer';
                case 'Vencida': return 'badge-vencida';
                default: return 'badge-proceso';
            }
        }
        
        // Función para obtener color de días restantes
        function getDiasColor(dias) {
            if (dias < 0) return '#dc3545';
            if (dias <= 7) return '#dc3545';
            if (dias <= 15) return '#ffc107';
            return '#28a745';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'cliente': return item.cliente || 'Sin cliente';
                    case 'responsable': return item.responsable || 'Sin responsable';
                    case 'estado': return item.estado || 'Sin estado';
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
                            case 'cliente': return item.cliente || 'Sin cliente';
                            case 'responsable': return item.responsable || 'Sin responsable';
                            case 'estado': return item.estado || 'Sin estado';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalMonto: item.monto || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalMonto += item.monto || 0;
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
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="10">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} licitaciones - Total: ${formatCurrency(grupo.totalMonto)})
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
                            
                            let badgeClass = getEstadoBadgeClass(item.estado);
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">
                                    ${item.no_licitacion}
                                    ${item.participa ? '<span class="badge-participa">Participo</span>' : ''}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha_publicacion)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha_cierre)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${getDiasColor(item.dias)}; font-weight: 600;">${item.dias} días</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrency(item.monto)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-estado ${badgeClass}">${item.estado || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.no_licitacion}')"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar bases" onclick="descargarBases('${item.no_licitacion}')"></i>
                                        <i class="fas fa-check-circle" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Participar" onclick="participar('${item.no_licitacion}')"></i>
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
                    
                    let badgeClass = getEstadoBadgeClass(item.estado);
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            ${item.no_licitacion}
                            ${item.participa ? '<span class="badge-participa">Participo</span>' : ''}
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.cliente || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha_publicacion)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha_cierre)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: ${getDiasColor(item.dias)}; font-weight: 600;">${item.dias} días</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrency(item.monto)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.responsable || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-estado ${badgeClass}">${item.estado || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.no_licitacion}')"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar bases" onclick="descargarBases('${item.no_licitacion}')"></i>
                                <i class="fas fa-check-circle" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Participar" onclick="participar('${item.no_licitacion}')"></i>
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
                        'cliente': 'Cliente',
                        'responsable': 'Responsable',
                        'estado': 'Estado'
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
            
            if (grupoAgrupacion) {
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
            }
            
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
        cargarTabla(datosLicitaciones);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Elementos del DOM para botones
        const btnAgregar = document.getElementById('btnAgregar');
        const btnExcel = document.getElementById('btnExcel');
        const btnFiltrar = document.getElementById('btnFiltrar');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const buscador = document.getElementById('buscador');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        
        // Elementos del modal de agregar
        const modalAgregar = document.getElementById('modalAgregarLicitacion');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        const fileInput = document.getElementById('fileInput');
        
        // Elementos del modal de ver detalle
        const modalVer = document.getElementById('modalVerDetalle');
        const btnCerrarVerModal = document.getElementById('btnCerrarVerModal');
        
        // Event Listeners
        if (buscador) {
            buscador.addEventListener('input', function(e) {
                const busqueda = e.target.value.toLowerCase();
                const datosFiltrados = datosLicitaciones.filter(item => 
                    item.no_licitacion?.toLowerCase().includes(busqueda) ||
                    item.nombre?.toLowerCase().includes(busqueda) ||
                    item.cliente?.toLowerCase().includes(busqueda) ||
                    item.responsable?.toLowerCase().includes(busqueda)
                );
                datosOriginales = datosFiltrados;
                currentPage = 1;
                cargarTabla(datosOriginales);
            });
        }
        
        if (fechaInicio) {
            fechaInicio.addEventListener('change', function() {
                console.log('Fecha inicio:', this.value);
            });
        }
        
        if (fechaFin) {
            fechaFin.addEventListener('change', function() {
                console.log('Fecha fin:', this.value);
            });
        }
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTabla(datosOriginales);
            }
        }
        
        if (btnPrimera) {
            btnPrimera.addEventListener('click', () => {
                if (datosOriginales.length > 0) {
                    currentPage = 1;
                    cargarTabla(datosOriginales);
                }
            });
        }
        
        if (btnAnterior) {
            btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        }
        
        if (btnSiguiente) {
            btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        }
        
        if (btnUltima) {
            btnUltima.addEventListener('click', () => {
                if (datosOriginales.length > 0) {
                    currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                    cargarTabla(datosOriginales);
                }
            });
        }
        
        // Botones de acción
        if (btnAgregar) {
            btnAgregar.addEventListener('click', () => {
                modalAgregar.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (btnExcel) {
            btnExcel.addEventListener('click', () => {
                exportTableToExcel('tablaLicitaciones', 'Licitaciones');
            });
        }
        
        if (btnFiltrar) {
            btnFiltrar.addEventListener('click', () => {
                alert('Filtros avanzados - Funcionalidad en desarrollo');
            });
        }
        
        if (btnCrearFiltro) {
            btnCrearFiltro.addEventListener('click', () => {
                alert('Crear filtro - Funcionalidad en desarrollo');
            });
        }
        
        // Modal de agregar
        function cerrarModalAgregar() {
            modalAgregar.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModal) {
            btnCerrarModal.addEventListener('click', cerrarModalAgregar);
        }
        
        if (btnCancelar) {
            btnCancelar.addEventListener('click', cerrarModalAgregar);
        }
        
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => {
                const noLicitacion = document.getElementById('modalNoLicitacion')?.value;
                const cliente = document.getElementById('modalCliente')?.value;
                const nombre = document.getElementById('modalNombre')?.value;
                
                if (!noLicitacion || !cliente || !nombre) {
                    alert('Por favor complete los campos requeridos');
                    return;
                }
                
                alert('Licitación guardada correctamente');
                cerrarModalAgregar();
            });
        }
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    console.log('Archivos seleccionados:', this.files.length);
                }
            });
        }
        
        // Funciones para acciones
        window.verDetalle = function(noLicitacion) {
            const licitacion = datosLicitaciones.find(l => l.no_licitacion === noLicitacion);
            if (licitacion) {
                document.getElementById('modalVerTitulo').innerHTML = `<i class="fas fa-file-contract"></i> Detalle de Licitación ${noLicitacion}`;
                document.getElementById('verNoLicitacion').textContent = licitacion.no_licitacion;
                document.getElementById('verNombre').textContent = licitacion.nombre;
                document.getElementById('verCliente').textContent = licitacion.cliente;
                document.getElementById('verResponsable').textContent = licitacion.responsable;
                document.getElementById('verFechaPublicacion').textContent = formatDate(licitacion.fecha_publicacion);
                document.getElementById('verFechaCierre').textContent = formatDate(licitacion.fecha_cierre);
                document.getElementById('verDias').textContent = licitacion.dias + ' días';
                document.getElementById('verDias').style.color = getDiasColor(licitacion.dias);
                document.getElementById('verMonto').textContent = formatCurrency(licitacion.monto);
                document.getElementById('verObservaciones').textContent = licitacion.observaciones;
                
                const estadoSpan = document.getElementById('verEstado');
                estadoSpan.textContent = licitacion.estado;
                estadoSpan.className = '';
                estadoSpan.classList.add(getEstadoBadgeClass(licitacion.estado));
            }
            
            modalVer.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.descargarBases = function(noLicitacion) {
            alert('Descargando bases de la licitación ' + noLicitacion);
        };
        
        window.participar = function(noLicitacion) {
            if (confirm('¿Desea confirmar su participación en esta licitación?')) {
                alert('Participación confirmada para ' + noLicitacion);
            }
        };
        
        window.participarLicitacion = function() {
            participar(document.getElementById('verNoLicitacion').textContent);
        };
        
        window.editarLicitacion = function() {
            alert('Editar licitación - Funcionalidad en desarrollo');
        };
        
        function cerrarModalVer() {
            modalVer.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalVer = cerrarModalVer;
        
        if (btnCerrarVerModal) {
            btnCerrarVerModal.addEventListener('click', cerrarModalVer);
        }
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalAgregar) {
                cerrarModalAgregar();
            }
            if (event.target === modalVer) {
                cerrarModalVer();
            }
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
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