@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Evidencias - Fotos y Actas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Evidencias - Fotos y Actas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE EVIDENCIAS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Evidencias -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Evidencias</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEvidencias">1,284</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Fotos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Fotos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFotos">1,042</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Actas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Actas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalActas">242</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Tamaño Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tamaño Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalTamanio">3.8 GB</div>
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

                        <!-- Botón Subir Evidencia -->
                        <div>
                            <button id="btnSubir" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Evidencia">
                                <i class="fas fa-cloud-upload-alt"></i> Subir
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

                        <!-- Botón Ver Galería -->
                        <div>
                            <button id="btnGalería" 
                                    style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;"
                                    title="Ver galería de fotos">
                                <i class="fas fa-images"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de vista -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="vista-tab active" data-vista="tabla" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-table"></i> Vista Tabla
                    </button>
                    <button class="vista-tab" data-vista="galeria" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-images"></i> Vista Galería
                    </button>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-images" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin evidencias</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- VISTA TABLA -->
                <div id="vistaTabla" class="vista-content active">
                    <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                        <table class="table table-bordered" id="tablaEvidencias" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Tipo</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="nombre">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Nombre</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Proyecto</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Fecha</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Categoría</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subido_por">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Subido por</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tamanio">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Tamaño</span>
                                            <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                        </div>
                                    </th>
                                    <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="tipo_archivo">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span>Formato</span>
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
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalTamanioFoot">3.8 GB</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalArchivos">1,284 archivos</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- VISTA GALERÍA -->
                <div id="vistaGaleria" class="vista-content" style="display: none;">
                    <!-- Filtros rápidos para galería -->
                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <select id="filtroTipoGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los tipos</option>
                            <option value="foto">Solo Fotos</option>
                            <option value="acta">Solo Actas</option>
                        </select>
                        <select id="filtroCategoriaGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las categorías</option>
                            <option value="avance">Avance de Obra</option>
                            <option value="calidad">Control de Calidad</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="reunion">Reuniones</option>
                            <option value="entrega">Entregas</option>
                        </select>
                        <select id="filtroProyectoGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los proyectos</option>
                            <option value="torre">Torre Norte</option>
                            <option value="puente">Puente Sur</option>
                            <option value="parque">Parque Industrial</option>
                        </select>
                    </div>

                    <!-- Grid de galería -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;" id="galeriaGrid">
                        <!-- Las tarjetas se insertarán dinámicamente con JavaScript -->
                    </div>

                    <!-- Paginación para galería -->
                    <div style="display: flex; justify-content: center; margin-top: 20px;" id="galeriaPaginacion">
                        <div style="display: flex; gap: 5px;">
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">1</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">5</button>
                        </div>
                    </div>
                </div>
                
                <!-- Paginación y botón Crear filtro (solo para vista tabla) -->
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 1,284 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Subir Evidencia -->
<div id="modalSubirEvidencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-cloud-upload-alt"></i> Subir Evidencia</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo <span style="color: #dc3545;">*</span></label>
                <select id="modalTipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="foto">Foto</option>
                    <option value="acta">Acta</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="PRO-2024-001">PRO-2024-001 - Torre Norte</option>
                    <option value="PRO-2024-002">PRO-2024-002 - Puente Sur</option>
                    <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial</option>
                    <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                    <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría</label>
                <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="avance">Avance de Obra</option>
                    <option value="calidad">Control de Calidad</option>
                    <option value="seguridad">Seguridad</option>
                    <option value="reunion">Reunión / Junta</option>
                    <option value="entrega">Entrega de Material</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <input type="text" id="modalDescripcion" placeholder="Breve descripción de la evidencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha</label>
                <input type="date" id="modalFecha" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo <span style="color: #dc3545;">*</span></label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra el archivo aquí o <span style="color: #083CAE; cursor: pointer;" onclick="document.getElementById('fileInput').click()">selecciona</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">Imágenes: JPG, PNG (Max. 10MB) | Documentos: PDF (Max. 20MB)</p>
                    <input type="file" id="fileInput" style="display: none;" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Subir Archivo</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Evidencia -->
<div id="modalVerEvidencia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 900px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-image"></i> Ver Evidencia
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Contenedor para vista previa -->
            <div id="vistaPreviaContenedor" style="text-align: center; margin-bottom: 20px; background-color: #f8f9fa; border-radius: 8px; padding: 20px; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <!-- Aquí se insertará la vista previa dinámicamente con imágenes reales de Unsplash -->
                <img id="vistaPreviaImagen" src="" style="max-width: 100%; max-height: 300px; border-radius: 4px; display: none;">
                <div id="vistaPreviaPDF" style="display: none; text-align: center;">
                    <i class="fas fa-file-pdf" style="font-size: 64px; color: #dc3545; margin-bottom: 10px;"></i>
                    <p>Vista previa de PDF</p>
                </div>
                <i class="fas fa-image" style="font-size: 64px; color: #adb5bd; display: none;" id="iconoVistaPrevia"></i>
            </div>

            <!-- Información de la evidencia -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Nombre</div>
                    <div style="font-size: 16px; font-weight: 600;" id="verNombre">Avance de Obra - Torre Norte</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tipo</div>
                    <div style="font-size: 14px;" id="verTipo">Foto</div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 14px;" id="verProyecto">Torre Norte Corporativa</div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                <div style="font-size: 14px;" id="verCategoria">Avance de Obra</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                    <div style="font-size: 14px;" id="verFecha">11/03/2026</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tamaño</div>
                    <div style="font-size: 14px;" id="verTamanio">2.4 MB</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Subido por</div>
                <div style="font-size: 14px;" id="verSubidoPor">Juan Pérez - 11/03/2026 10:30</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="verDescripcion">
                    Avance de cimentación en sector norte. Se aprecia el colado de zapatas.
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarEvidencia()">
                    <i class="fas fa-download"></i> Descargar
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
    
    /* Estilos para pestañas */
    .vista-tab {
        transition: all 0.3s ease;
    }
    
    .vista-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .vista-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .vista-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Estilos para tarjetas de galería */
    .galeria-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background-color: white;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .galeria-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .galeria-card .tipo-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        color: white;
    }
    
    .badge-foto {
        background-color: #28a745;
    }
    
    .badge-acta {
        background-color: #ffc107;
        color: #856404;
    }
    
    /* Estilos para imágenes de ejemplo */
    .ejemplo-imagen {
        width: 100%;
        height: 150px;
        object-fit: cover;
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
        console.log('DOM completamente cargado - Evidencias');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Variables para galería
        let galeriaPage = 1;
        let galeriaRowsPerPage = 12;
        
        // Elementos del DOM
        const tablaBody = document.getElementById('tablaBody');
        const tablaContainer = document.getElementById('tablaContainer');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const textoAgrupar = document.getElementById('textoAgrupar');
        const tablaFoot = document.getElementById('tablaFoot');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnSubir = document.getElementById('btnSubir');
        const btnExcel = document.getElementById('btnExcel');
        const btnGaleria = document.getElementById('btnGalería');
        const buscador = document.getElementById('buscador');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        
        // Elementos de paginación
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        const paginacionInfo = document.getElementById('paginacionInfo');
        
        // Elementos de pestañas
        const vistaTabs = document.querySelectorAll('.vista-tab');
        const vistaContents = document.querySelectorAll('.vista-content');
        
        // Elementos de galería
        const galeriaGrid = document.getElementById('galeriaGrid');
        const filtroTipoGaleria = document.getElementById('filtroTipoGaleria');
        const filtroCategoriaGaleria = document.getElementById('filtroCategoriaGaleria');
        const filtroProyectoGaleria = document.getElementById('filtroProyectoGaleria');
        
        // Elementos del modal de subida
        const modalSubir = document.getElementById('modalSubirEvidencia');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        const fileInput = document.getElementById('fileInput');
        
        // Elementos del modal de ver
        const modalVer = document.getElementById('modalVerEvidencia');
        const btnCerrarVerModal = document.getElementById('btnCerrarVerModal');
        
        // URLs de imágenes de ejemplo (Unsplash)
        const imagenesEjemplo = [
            'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop'
        ];
        
        // Datos de ejemplo para evidencias con imágenes reales
        const datosEvidencias = [
            {
                tipo: 'foto',
                tipo_icono: 'fa-image',
                tipo_color: '#28a745',
                nombre: 'Avance de Cimentación - Torre Norte',
                proyecto: 'Torre Norte Corporativa',
                proyectoId: 'PRO-2024-001',
                fecha: '2026-03-11',
                categoria: 'Avance de Obra',
                subido_por: 'Juan Pérez',
                tamanio: '2.4 MB',
                tipo_archivo: 'JPG',
                descripcion: 'Avance de cimentación en sector norte. Se aprecia el colado de zapatas.',
                archivo: 'foto1.jpg',
                imagen: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=300&h=200&fit=crop',
                imagen_grande: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=800&h=600&fit=crop'
            },
            {
                tipo: 'acta',
                tipo_icono: 'fa-file-pdf',
                tipo_color: '#dc3545',
                nombre: 'Acta de Reunión - Estructuras',
                proyecto: 'Torre Norte Corporativa',
                proyectoId: 'PRO-2024-001',
                fecha: '2026-03-10',
                categoria: 'Reunión',
                subido_por: 'María García',
                tamanio: '1.2 MB',
                tipo_archivo: 'PDF',
                descripcion: 'Acta de reunión semanal de avance de estructuras. Acuerdos y pendientes.',
                archivo: 'acta1.pdf',
                imagen: ''
            },
            {
                tipo: 'foto',
                tipo_icono: 'fa-image',
                tipo_color: '#28a745',
                nombre: 'Instalación de Trabes - Puente Sur',
                proyecto: 'Puente Vehicular Sur',
                proyectoId: 'PRO-2024-002',
                fecha: '2026-03-09',
                categoria: 'Avance de Obra',
                subido_por: 'Carlos Rodríguez',
                tamanio: '3.1 MB',
                tipo_archivo: 'PNG',
                descripcion: 'Instalación de trabes de acero en claros 3 y 4.',
                archivo: 'foto2.jpg',
                imagen: 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=300&h=200&fit=crop',
                imagen_grande: 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop'
            },
            {
                tipo: 'acta',
                tipo_icono: 'fa-file-pdf',
                tipo_color: '#dc3545',
                nombre: 'Acta de Calidad - Acero',
                proyecto: 'Parque Industrial Norte',
                proyectoId: 'PRO-2024-003',
                fecha: '2026-03-08',
                categoria: 'Control de Calidad',
                subido_por: 'Ana Martínez',
                tamanio: '0.8 MB',
                tipo_archivo: 'PDF',
                descripcion: 'Acta de aceptación de acero de refuerzo. Lote 2345.',
                archivo: 'acta2.pdf',
                imagen: ''
            },
            {
                tipo: 'foto',
                tipo_icono: 'fa-image',
                tipo_color: '#28a745',
                nombre: 'Prueba de Carga - Pilas',
                proyecto: 'Puente Vehicular Sur',
                proyectoId: 'PRO-2024-002',
                fecha: '2026-03-07',
                categoria: 'Pruebas',
                subido_por: 'Luis Ramírez',
                tamanio: '4.2 MB',
                tipo_archivo: 'JPG',
                descripcion: 'Realizando prueba de carga en pilas 5 y 6.',
                archivo: 'foto3.jpg',
                imagen: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
                imagen_grande: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop'
            },
            {
                tipo: 'acta',
                tipo_icono: 'fa-file-pdf',
                tipo_color: '#dc3545',
                nombre: 'Acta de Seguridad',
                proyecto: 'Hospital Regional',
                proyectoId: 'PRO-2024-004',
                fecha: '2026-03-06',
                categoria: 'Seguridad',
                subido_por: 'Sofía Castro',
                tamanio: '1.5 MB',
                tipo_archivo: 'PDF',
                descripcion: 'Acta de inspección de seguridad semanal. Sin incidentes.',
                archivo: 'acta3.pdf',
                imagen: ''
            },
            {
                tipo: 'foto',
                tipo_icono: 'fa-image',
                tipo_color: '#28a745',
                nombre: 'Colado de Losas - Nivel 3',
                proyecto: 'Hospital Regional',
                proyectoId: 'PRO-2024-004',
                fecha: '2026-03-05',
                categoria: 'Avance de Obra',
                subido_por: 'Miguel Torres',
                tamanio: '2.8 MB',
                tipo_archivo: 'JPG',
                descripcion: 'Colado de losa de entrepiso nivel 3.',
                archivo: 'foto4.jpg',
                imagen: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
                imagen_grande: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop'
            },
            {
                tipo: 'acta',
                tipo_icono: 'fa-file-pdf',
                tipo_color: '#dc3545',
                nombre: 'Acta de Entrega - Material',
                proyecto: 'Planta Tratamiento',
                proyectoId: 'PRO-2024-005',
                fecha: '2026-03-04',
                categoria: 'Entrega de Material',
                subido_por: 'Pedro Hernández',
                tamanio: '0.9 MB',
                tipo_archivo: 'PDF',
                descripcion: 'Acta de recepción de tubería y conexiones.',
                archivo: 'acta4.pdf',
                imagen: ''
            },
            {
                tipo: 'foto',
                tipo_icono: 'fa-image',
                tipo_color: '#28a745',
                nombre: 'Excavación - Parque Industrial',
                proyecto: 'Parque Industrial Norte',
                proyectoId: 'PRO-2024-003',
                fecha: '2026-03-03',
                categoria: 'Avance de Obra',
                subido_por: 'Roberto Sánchez',
                tamanio: '3.5 MB',
                tipo_archivo: 'JPG',
                descripcion: 'Trabajos de excavación para cimentación de nave industrial.',
                archivo: 'foto5.jpg',
                imagen: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=300&h=200&fit=crop',
                imagen_grande: 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop'
            }
        ];
        
        datosOriginales = [...datosEvidencias];
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
            const fotos = datos.filter(d => d.tipo === 'foto').length;
            const actas = datos.filter(d => d.tipo === 'acta').length;
            
            // Calcular tamaño total aproximado
            let totalMB = 0;
            datos.forEach(d => {
                const size = parseFloat(d.tamanio);
                if (!isNaN(size)) totalMB += size;
            });
            
            let tamañoTexto = '';
            if (totalMB > 1024) {
                tamañoTexto = (totalMB / 1024).toFixed(1) + ' GB';
            } else {
                tamañoTexto = totalMB.toFixed(1) + ' MB';
            }
            
            document.getElementById('totalEvidencias').textContent = total;
            document.getElementById('totalFotos').textContent = fotos;
            document.getElementById('totalActas').textContent = actas;
            document.getElementById('totalTamanio').textContent = tamañoTexto;
            document.getElementById('totalTamanioFoot').textContent = tamañoTexto;
            document.getElementById('totalArchivos').textContent = total + ' archivos';
        }
        
        // Función para obtener ícono según tipo de archivo
        function getFileIcon(tipo_archivo) {
            if (tipo_archivo === 'PDF') return 'fa-file-pdf';
            if (tipo_archivo === 'JPG' || tipo_archivo === 'PNG') return 'fa-image';
            return 'fa-file';
        }
        
        // Función para obtener color según tipo
        function getFileColor(tipo_archivo) {
            if (tipo_archivo === 'PDF') return '#dc3545';
            if (tipo_archivo === 'JPG' || tipo_archivo === 'PNG') return '#28a745';
            return '#6c757d';
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'tipo': return item.tipo || 'Sin tipo';
                    case 'proyecto': return item.proyecto || 'Sin proyecto';
                    case 'categoria': return item.categoria || 'Sin categoría';
                    case 'subido_por': return item.subido_por || 'Sin responsable';
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
                            case 'tipo': return item.tipo === 'foto' ? 'Foto' : 'Acta';
                            case 'proyecto': return item.proyecto || 'Sin proyecto';
                            case 'categoria': return item.categoria || 'Sin categoría';
                            case 'subido_por': return item.subido_por || 'Sin responsable';
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
            paginaActualSpan.textContent = currentPage;
            paginacionInfo.textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            if (!tablaBody) return;
            
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
            
            // Actualizar contadores
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
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
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="9">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} archivos)
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">
                                    <i class="fas ${item.tipo_icono}" style="color: ${item.tipo_color}; margin-right: 5px;"></i>
                                    ${item.tipo === 'foto' ? 'Foto' : 'Acta'}
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.categoria || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.subido_por || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.tamanio || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.tipo_archivo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver" onclick="verEvidencia('${item.archivo}')"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarEvidencia('${item.archivo}')"></i>
                                        <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarEvidencia('${item.archivo}')"></i>
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
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                            <i class="fas ${item.tipo_icono}" style="color: ${item.tipo_color}; margin-right: 5px;"></i>
                            ${item.tipo === 'foto' ? 'Foto' : 'Acta'}
                        </td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.categoria || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.subido_por || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.tamanio || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.tipo_archivo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver" onclick="verEvidencia('${item.archivo}')"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarEvidencia('${item.archivo}')"></i>
                                <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarEvidencia('${item.archivo}')"></i>
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
        
        // Función para cargar galería
        function cargarGaleria(datos) {
            if (!galeriaGrid) return;
            
            galeriaGrid.innerHTML = '';
            
            const start = (galeriaPage - 1) * galeriaRowsPerPage;
            const end = start + galeriaRowsPerPage;
            const pageData = datos.slice(start, end);
            
            pageData.forEach(item => {
                const card = document.createElement('div');
                card.className = 'galeria-card';
                card.style.position = 'relative';
                
                if (item.tipo === 'foto') {
                    card.innerHTML = `
                        <img src="${item.imagen}" alt="${item.nombre}" style="width: 100%; height: 150px; object-fit: cover;">
                        <span class="tipo-badge badge-foto">
                            📷 Foto
                        </span>
                        <div style="padding: 12px;">
                            <div style="font-weight: 600; font-size: 14px; margin-bottom: 5px;">${item.nombre}</div>
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">${item.proyecto}</div>
                            <div style="font-size: 11px; color: #6c757d; margin-bottom: 10px;">${formatDate(item.fecha)} • ${item.tamanio}</div>
                            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver" onclick="verEvidencia('${item.archivo}')"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" title="Descargar" onclick="descargarEvidencia('${item.archivo}')"></i>
                            </div>
                        </div>
                    `;
                } else {
                    card.innerHTML = `
                        <div style="height: 150px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%); background-size: 20px 20px;">
                            <i class="fas fa-file-pdf" style="font-size: 48px; color: #dc3545;"></i>
                        </div>
                        <span class="tipo-badge badge-acta">
                            📄 Acta
                        </span>
                        <div style="padding: 12px;">
                            <div style="font-weight: 600; font-size: 14px; margin-bottom: 5px;">${item.nombre}</div>
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">${item.proyecto}</div>
                            <div style="font-size: 11px; color: #6c757d; margin-bottom: 10px;">${formatDate(item.fecha)} • ${item.tamanio}</div>
                            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver" onclick="verEvidencia('${item.archivo}')"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" title="Descargar" onclick="descargarEvidencia('${item.archivo}')"></i>
                            </div>
                        </div>
                    `;
                }
                
                galeriaGrid.appendChild(card);
            });
        }
        
        // Función para filtrar datos
        function filtrarDatos() {
            let datosFiltrados = [...datosEvidencias];
            
            // Filtrar por búsqueda
            const busqueda = buscador?.value.toLowerCase() || '';
            if (busqueda) {
                datosFiltrados = datosFiltrados.filter(item => 
                    item.nombre?.toLowerCase().includes(busqueda) ||
                    item.proyecto?.toLowerCase().includes(busqueda) ||
                    item.categoria?.toLowerCase().includes(busqueda) ||
                    item.subido_por?.toLowerCase().includes(busqueda)
                );
            }
            
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        }
        
        // Función para filtrar galería
        function filtrarGaleria() {
            let datosFiltrados = [...datosEvidencias];
            
            const tipo = filtroTipoGaleria?.value || '';
            if (tipo) {
                datosFiltrados = datosFiltrados.filter(item => item.tipo === tipo);
            }
            
            const categoria = filtroCategoriaGaleria?.value || '';
            if (categoria) {
                datosFiltrados = datosFiltrados.filter(item => item.categoria?.toLowerCase().includes(categoria));
            }
            
            const proyecto = filtroProyectoGaleria?.value || '';
            if (proyecto) {
                if (proyecto === 'torre') {
                    datosFiltrados = datosFiltrados.filter(item => item.proyectoId === 'PRO-2024-001');
                } else if (proyecto === 'puente') {
                    datosFiltrados = datosFiltrados.filter(item => item.proyectoId === 'PRO-2024-002');
                } else if (proyecto === 'parque') {
                    datosFiltrados = datosFiltrados.filter(item => item.proyectoId === 'PRO-2024-003');
                }
            }
            
            galeriaPage = 1;
            cargarGaleria(datosFiltrados);
        }
        
        // Event Listeners
        if (buscador) {
            buscador.addEventListener('input', filtrarDatos);
        }
        
        if (filtroTipoGaleria) {
            filtroTipoGaleria.addEventListener('change', filtrarGaleria);
        }
        
        if (filtroCategoriaGaleria) {
            filtroCategoriaGaleria.addEventListener('change', filtrarGaleria);
        }
        
        if (filtroProyectoGaleria) {
            filtroProyectoGaleria.addEventListener('change', filtrarGaleria);
        }
        
        // Cambio de pestañas
        vistaTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                vistaTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                vistaContents.forEach(content => content.style.display = 'none');
                vistaContents[index].style.display = 'block';
                
                if (index === 1) { // Vista galería
                    filtrarGaleria();
                }
            });
        });
        
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
        if (btnSubir) {
            btnSubir.addEventListener('click', () => {
                modalSubir.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (btnExcel) {
            btnExcel.addEventListener('click', () => {
                exportTableToExcel('tablaEvidencias', 'Evidencias');
            });
        }
        
        if (btnGaleria) {
            btnGaleria.addEventListener('click', () => {
                // Cambiar a pestaña de galería
                document.querySelector('[data-vista="galeria"]').click();
            });
        }
        
        if (btnCrearFiltro) {
            btnCrearFiltro.addEventListener('click', () => {
                alert('Crear filtro - Funcionalidad en desarrollo');
            });
        }
        
        if (fechaInicio) {
            fechaInicio.addEventListener('change', () => {
                console.log('Fecha inicio:', fechaInicio.value);
            });
        }
        
        if (fechaFin) {
            fechaFin.addEventListener('change', () => {
                console.log('Fecha fin:', fechaFin.value);
            });
        }
        
        // Modal de subida
        function cerrarModalSubida() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModal) {
            btnCerrarModal.addEventListener('click', cerrarModalSubida);
        }
        
        if (btnCancelar) {
            btnCancelar.addEventListener('click', cerrarModalSubida);
        }
        
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => {
                const tipo = document.getElementById('modalTipo')?.value;
                const proyecto = document.getElementById('modalProyecto')?.value;
                
                if (!tipo || !proyecto) {
                    alert('Por favor complete los campos requeridos');
                    return;
                }
                
                alert('Archivo subido correctamente');
                cerrarModalSubida();
            });
        }
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    console.log('Archivo seleccionado:', this.files[0].name);
                }
            });
        }
        
        // Modal de ver evidencia
        window.verEvidencia = function(archivo) {
            const evidencia = datosEvidencias.find(e => e.archivo === archivo);
            if (evidencia) {
                document.getElementById('modalVerTitulo').innerHTML = `<i class="fas ${evidencia.tipo_icono}"></i> ${evidencia.tipo === 'foto' ? 'Ver Foto' : 'Ver Acta'}`;
                document.getElementById('verNombre').textContent = evidencia.nombre;
                document.getElementById('verTipo').textContent = evidencia.tipo === 'foto' ? 'Foto' : 'Acta';
                document.getElementById('verProyecto').textContent = evidencia.proyecto;
                document.getElementById('verCategoria').textContent = evidencia.categoria;
                document.getElementById('verFecha').textContent = formatDate(evidencia.fecha);
                document.getElementById('verTamanio').textContent = evidencia.tamanio;
                document.getElementById('verSubidoPor').textContent = evidencia.subido_por + ' - ' + formatDate(evidencia.fecha) + ' 10:30';
                document.getElementById('verDescripcion').textContent = evidencia.descripcion;
                
                // Vista previa
                const contenedor = document.getElementById('vistaPreviaContenedor');
                if (evidencia.tipo === 'foto' && evidencia.imagen_grande) {
                    contenedor.innerHTML = `<img src="${evidencia.imagen_grande}" style="max-width: 100%; max-height: 300px; border-radius: 4px;">`;
                } else {
                    contenedor.innerHTML = `
                        <div style="text-align: center;">
                            <i class="fas fa-file-pdf" style="font-size: 64px; color: #dc3545; margin-bottom: 10px;"></i>
                            <p>Vista previa de PDF</p>
                            <small style="color: #6c757d;">${evidencia.archivo}</small>
                        </div>
                    `;
                }
            }
            
            modalVer.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.descargarEvidencia = function(archivo) {
            alert('Descargando archivo: ' + archivo);
        };
        
        window.eliminarEvidencia = function(archivo) {
            if (confirm('¿Está seguro de eliminar esta evidencia?')) {
                alert('Evidencia eliminada: ' + archivo);
            }
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
            if (event.target === modalSubir) {
                cerrarModalSubida();
            }
            if (event.target === modalVer) {
                cerrarModalVer();
            }
        });
        
        // Paginación de galería
        document.querySelectorAll('.galeria-pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.galeria-pagina-btn').forEach(b => {
                    b.style.backgroundColor = 'white';
                    b.style.color = '#495057';
                });
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                galeriaPage = parseInt(this.textContent);
                filtrarGaleria();
            });
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', () => alert('Filtro de columna - Funcionalidad en desarrollo'));
        });
        
        // Configurar drag and drop para agrupación
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
                        'categoria': 'Categoría',
                        'subido_por': 'Subido por'
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
        
        // Inicializar
        cargarTabla(datosEvidencias);
        setupDragAndDrop();
        
        // Inicializar contadores
        actualizarContadores(datosEvidencias);
    });
</script>
@endsection