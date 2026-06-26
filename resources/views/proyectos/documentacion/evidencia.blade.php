@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Evidencias - Fotos y Actas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-images" style="margin-right: 10px;"></i>
                    Evidencias - Fotos y Actas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE EVIDENCIAS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Evidencias</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEvidencias">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Fotos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFotos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Actas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalActas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tamaño Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalTamanio">0 MB</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos ?? [] as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-d', strtotime('-30 days')) }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-d') }}" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <div>
                            <button id="btnSubir" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Evidencia">
                                <i class="fas fa-cloud-upload-alt"></i> Subir
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnGaleria" style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;" title="Ver galería de fotos">
                                <i class="fas fa-images"></i>
                            </button>
                        </div>

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

                <!-- Loader -->
                <div id="loaderContainer" style="text-align: center; padding: 40px 20px; display: none;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p style="color: #6c757d; margin-top: 10px;">Cargando datos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-images" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin evidencias</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Mensaje de Error -->
                <div style="text-align: center; padding: 40px 20px; background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; margin: 20px 0; display: none;" id="errorMensaje">
                    <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ffc107; margin-bottom: 15px;"></i>
                    <h3 style="color: #856404; font-size: 18px; margin: 0;">Error al cargar datos</h3>
                    <p style="color: #856404; font-size: 14px; margin-top: 5px;" id="errorTexto">Ocurrió un error al cargar los datos</p>
                    <button onclick="cargarTodosLosDatos()" style="margin-top: 10px; padding: 8px 20px; background-color: #ffc107; border: none; border-radius: 4px; cursor: pointer; color: #856404; font-weight: 600;">
                        <i class="fas fa-sync-alt"></i> Reintentar
                    </button>
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
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 30px; color: #6c757d;">
                                        <i class="fas fa-spinner fa-spin"></i> Cargando evidencias...
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalTamanioFoot">0 MB</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" id="totalArchivos">0 archivos</td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- VISTA GALERÍA -->
                <div id="vistaGaleria" class="vista-content" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <select id="filtroTipoGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los tipos</option>
                            <option value="foto">Solo Fotos</option>
                            <option value="acta">Solo Actas</option>
                        </select>
                        <select id="filtroCategoriaGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias ?? [] as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <select id="filtroProyectoGaleria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los proyectos</option>
                            @foreach($proyectos ?? [] as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;" id="galeriaGrid">
                        <div style="text-align: center; padding: 40px; color: #6c757d; grid-column: 1 / -1;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i>
                            <p style="margin-top: 10px;">Cargando galería...</p>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; margin-top: 20px;" id="galeriaPaginacion">
                        <div style="display: flex; gap: 5px;">
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;" data-pagina="1">1</button>
                        </div>
                    </div>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
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
                    @foreach($proyectos ?? [] as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría</label>
                <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    @foreach($categorias ?? [] as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalNombre" placeholder="Nombre de la evidencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <textarea id="modalDescripcion" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción detallada..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha</label>
                <input type="date" id="modalFecha" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo <span style="color: #dc3545;">*</span></label>
                <div id="dropZone" style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa; cursor: pointer;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra el archivo aquí o <span style="color: #083CAE; cursor: pointer;">selecciona</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">Imágenes: JPG, PNG (Max. 10MB) | Documentos: PDF (Max. 20MB)</p>
                    <input type="file" id="fileInput" style="display: none;" accept=".jpg,.jpeg,.png,.pdf">
                    <div id="fileInfo" style="display: none; margin-top: 10px; padding: 10px; background-color: #e9ecef; border-radius: 4px;">
                        <i class="fas fa-file" style="color: #083CAE;"></i>
                        <span id="fileName" style="margin-left: 8px;"></span>
                        <span id="fileSize" style="margin-left: 15px; color: #6c757d;"></span>
                        <button id="btnRemoveFile" style="margin-left: 15px; background: none; border: none; color: #dc3545; cursor: pointer;">&times;</button>
                    </div>
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
            <div id="vistaPreviaContenedor" style="text-align: center; margin-bottom: 20px; background-color: #f8f9fa; border-radius: 8px; padding: 20px; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #083CAE;"></i>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Nombre</div>
                    <div style="font-size: 16px; font-weight: 600;" id="verNombre">-</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tipo</div>
                    <div style="font-size: 14px;" id="verTipo">-</div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                <div style="font-size: 14px;" id="verProyecto">-</div>
            </div>

            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                <div style="font-size: 14px;" id="verCategoria">-</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                    <div style="font-size: 14px;" id="verFecha">-</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tamaño</div>
                    <div style="font-size: 14px;" id="verTamanio">-</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Subido por</div>
                <div style="font-size: 14px;" id="verSubidoPor">-</div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="verDescripcion">-</div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button id="btnDescargarEvidencia" style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-download"></i> Descargar
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalVer()">Cerrar</button>
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
    
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }
    
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    #tablaBody td i:hover {
        transform: scale(1.2);
    }
    
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }
    
    .table th i:hover {
        opacity: 1;
    }
    
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
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
    
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }
    
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
    
    .badge-estado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
    }
    
    .spinner-border {
        display: inline-block;
        width: 3rem;
        height: 3rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }
    
    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
    
    .drag-over {
        border-color: #083CAE !important;
        background-color: #f0f4ff !important;
    }
    
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        select {
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
        
        .vista-tab {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 DOM cargado - Evidencias');
        
        // Variables globales
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRegistros = 0;
        let galeriaPage = 1;
        let galeriaRowsPerPage = 12;
        let totalGaleria = 0;
        let datosEvidencias = [];
        let datosGaleria = [];
        let columnasAgrupadas = [];
        let expandedGroups = new Set();

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE CARGA DE DATOS
        // ════════════════════════════════════════════════════════════════

        async function cargarTodosLosDatos() {
            mostrarLoader(true);
            ocultarErrores();
            
            try {
                await Promise.all([
                    cargarResumen(),
                    cargarLista(),
                    cargarGaleria()
                ]);
                mostrarLoader(false);
            } catch (error) {
                console.error('❌ Error al cargar datos:', error);
                mostrarError('Error al cargar los datos: ' + error.message);
                mostrarLoader(false);
            }
        }

        async function cargarResumen() {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const fechaInicio = document.getElementById('fechaInicio').value;
                const fechaFin = document.getElementById('fechaFin').value;
                
                let url = '/proyectos/evidencias-api/resumen';
                const params = new URLSearchParams();
                if (proyectoId) params.append('proyecto_id', proyectoId);
                if (fechaInicio) params.append('fecha_inicio', fechaInicio);
                if (fechaFin) params.append('fecha_fin', fechaFin);
                if (params.toString()) url += '?' + params.toString();
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar resumen');
                
                const data = await response.json();
                
                document.getElementById('totalEvidencias').textContent = data.total_evidencias || 0;
                document.getElementById('totalFotos').textContent = data.total_fotos || 0;
                document.getElementById('totalActas').textContent = data.total_actas || 0;
                document.getElementById('totalTamanio').textContent = data.total_tamanio || '0 MB';
                document.getElementById('totalTamanioFoot').textContent = data.total_tamanio || '0 MB';
                document.getElementById('totalArchivos').textContent = (data.total_evidencias || 0) + ' archivos';
                
            } catch (error) {
                console.error('❌ Error en resumen:', error);
                throw error;
            }
        }

        async function cargarLista(page = 1) {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const search = document.getElementById('buscador').value;
                const fechaInicio = document.getElementById('fechaInicio').value;
                const fechaFin = document.getElementById('fechaFin').value;
                
                let url = `/proyectos/evidencias-api/listar?per_page=${rowsPerPage}&page=${page}`;
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                if (search) url += `&search=${encodeURIComponent(search)}`;
                if (fechaInicio) url += `&fecha_inicio=${fechaInicio}`;
                if (fechaFin) url += `&fecha_fin=${fechaFin}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar evidencias');
                
                const data = await response.json();
                datosEvidencias = data.data || [];
                totalRegistros = data.pagination?.total || 0;
                currentPage = data.pagination?.current_page || 1;
                
                renderizarTabla(datosEvidencias);
                actualizarPaginacion(data.pagination);
                
            } catch (error) {
                console.error('❌ Error en lista:', error);
                throw error;
            }
        }

        async function cargarGaleria(page = 1) {
            try {
                const proyectoId = document.getElementById('filtroProyectoGaleria').value;
                const categoriaId = document.getElementById('filtroCategoriaGaleria').value;
                const tipo = document.getElementById('filtroTipoGaleria').value;
                const search = document.getElementById('buscador').value;
                
                let url = `/proyectos/evidencias-api/galeria?per_page=${galeriaRowsPerPage}&page=${page}`;
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                if (categoriaId) url += `&categoria_id=${categoriaId}`;
                if (tipo) url += `&tipo=${tipo}`;
                if (search) url += `&search=${encodeURIComponent(search)}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar galería');
                
                const data = await response.json();
                datosGaleria = data.data || [];
                totalGaleria = data.pagination?.total || 0;
                galeriaPage = data.pagination?.current_page || 1;
                
                renderizarGaleria(datosGaleria);
                actualizarPaginacionGaleria(data.pagination);
                
            } catch (error) {
                console.error('❌ Error en galería:', error);
                throw error;
            }
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE RENDERIZADO
        // ════════════════════════════════════════════════════════════════

        function renderizarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatos = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            
            if (!tablaBody) return;
            
            if (!datos || datos.length === 0) {
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay evidencias registradas
                        </td>
                    </tr>
                `;
                sinDatos.style.display = 'block';
                tablaContainer.style.display = 'none';
                return;
            }
            
            sinDatos.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            let html = '';
            
            if (hayGrupos) {
                grupos.forEach(grupo => {
                    const isExpanded = expandedGroups.has(grupo.id);
                    
                    html += `
                        <tr class="fila-grupo ${isExpanded ? 'expandido' : ''}" data-grupo-id="${grupo.id}">
                            <td colspan="9" style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <i class="fas fa-caret-${isExpanded ? 'down' : 'right'}" style="margin-right: 8px; color: #2378e1;"></i>
                                        <strong style="color: #2378e1;">${grupo.valor}</strong>
                                        <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                            (${grupo.items.length} archivos)
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                    
                    if (isExpanded) {
                        grupo.items.forEach(item => {
                            html += `
                                <tr class="fila-detalle">
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
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver" onclick="verEvidencia(${item.id})"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarEvidencia(${item.id})"></i>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarEvidencia(${item.id})"></i>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                });
            } else {
                datos.forEach(item => {
                    html += `
                        <tr>
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
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver" onclick="verEvidencia(${item.id})"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Descargar" onclick="descargarEvidencia(${item.id})"></i>
                                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarEvidencia(${item.id})"></i>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }
            
            tablaBody.innerHTML = html;
        }

        function renderizarGaleria(datos) {
            const container = document.getElementById('galeriaGrid');
            const sinDatos = document.getElementById('sinDatosMensaje');
            
            if (!container) return;
            
            if (!datos || datos.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #6c757d; grid-column: 1 / -1;">
                        <i class="fas fa-inbox" style="font-size: 32px;"></i>
                        <p style="margin-top: 10px;">No hay fotos en la galería</p>
                    </div>
                `;
                sinDatos.style.display = 'block';
                return;
            }
            
            sinDatos.style.display = 'none';
            
            let html = '';
            datos.forEach(item => {
                const esFoto = item.tipo === 'foto';
                const badgeClass = esFoto ? 'badge-foto' : 'badge-acta';
                const badgeText = esFoto ? '📷 Foto' : '📄 Acta';
                
                html += `
                    <div class="galeria-card" style="position: relative; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer; display: flex; align-items: center; justify-content: center; overflow: hidden;" onclick="verEvidencia(${item.id})">
                            ${esFoto && item.miniatura_url ? 
                                `<img src="${item.miniatura_url}" alt="${item.nombre}" style="width: 100%; height: 100%; object-fit: cover;">` :
                                `<div style="text-align: center; padding: 20px;">
                                    <i class="fas ${esFoto ? 'fa-image' : 'fa-file-pdf'}" style="font-size: 48px; color: ${esFoto ? '#28a745' : '#dc3545'};"></i>
                                    <div style="margin-top: 10px; font-size: 14px; font-weight: 600; color: ${esFoto ? '#28a745' : '#dc3545'};">${item.nombre || 'Sin nombre'}</div>
                                </div>`
                            }
                            <span class="tipo-badge ${badgeClass}" style="position: absolute; top: 10px; right: 10px; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; color: white;">${badgeText}</span>
                        </div>
                        <div style="padding: 12px;">
                            <div style="font-weight: 600; font-size: 14px; margin-bottom: 5px;">${item.nombre || 'Sin nombre'}</div>
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">${item.proyecto || 'Sin proyecto'}</div>
                            <div style="font-size: 11px; color: #6c757d; margin-bottom: 10px;">${item.fecha || 'N/A'} • ${item.tamanio || '0 B'}</div>
                            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver" onclick="verEvidencia(${item.id})"></i>
                                <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" title="Descargar" onclick="descargarEvidencia(${item.id})"></i>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE UTILIDAD
        // ════════════════════════════════════════════════════════════════

        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }

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

        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
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

        function mostrarLoader(mostrar) {
            const loader = document.getElementById('loaderContainer');
            if (loader) loader.style.display = mostrar ? 'block' : 'none';
        }

        function mostrarError(mensaje) {
            const errorDiv = document.getElementById('errorMensaje');
            const errorText = document.getElementById('errorTexto');
            if (errorDiv && errorText) {
                errorText.textContent = mensaje || 'Ocurrió un error al cargar los datos';
                errorDiv.style.display = 'block';
            }
        }

        function ocultarErrores() {
            const errorDiv = document.getElementById('errorMensaje');
            if (errorDiv) errorDiv.style.display = 'none';
        }

        function actualizarPaginacion(pagination) {
            if (!pagination) return;
            
            const total = pagination.total || 0;
            const perPage = pagination.per_page || 10;
            const current = pagination.current_page || 1;
            const last = pagination.last_page || 1;
            
            const inicio = ((current - 1) * perPage) + 1;
            const fin = Math.min(current * perPage, total);
            
            document.getElementById('paginaActual').textContent = current;
            document.getElementById('paginacionInfo').textContent = 
                total > 0 ? `Mostrando ${inicio}-${fin} de ${total} registros` : 'Mostrando 0-0 de 0 registros';
            
            const pageButtons = document.querySelectorAll('.pagina-btn');
            pageButtons.forEach(btn => {
                const page = parseInt(btn.dataset.pagina);
                btn.style.backgroundColor = page === current ? '#2378e1' : 'transparent';
                btn.style.color = page === current ? 'white' : '#2378e1';
            });
        }

        function actualizarPaginacionGaleria(pagination) {
            if (!pagination) return;
            
            const total = pagination.total || 0;
            const perPage = pagination.per_page || 12;
            const current = pagination.current_page || 1;
            const last = pagination.last_page || 1;
            
            const buttons = document.querySelectorAll('.galeria-pagina-btn');
            buttons.forEach(btn => {
                const page = parseInt(btn.dataset.pagina);
                btn.style.backgroundColor = page === current ? '#083CAE' : 'white';
                btn.style.color = page === current ? 'white' : '#495057';
            });
            
            // Crear botones dinámicamente si es necesario
            const container = document.getElementById('galeriaPaginacion');
            if (last > 1 && buttons.length === 0) {
                let btnHtml = '<div style="display: flex; gap: 5px;">';
                for (let i = 1; i <= Math.min(last, 5); i++) {
                    btnHtml += `
                        <button class="galeria-pagina-btn" data-pagina="${i}" style="padding: 5px 10px; background-color: ${i === current ? '#083CAE' : 'white'}; color: ${i === current ? 'white' : '#495057'}; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">${i}</button>
                    `;
                }
                btnHtml += '</div>';
                container.innerHTML = btnHtml;
                
                document.querySelectorAll('.galeria-pagina-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const page = parseInt(this.dataset.pagina);
                        galeriaPage = page;
                        cargarGaleria(page);
                    });
                });
            }
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE ACCIONES
        // ════════════════════════════════════════════════════════════════

        window.verEvidencia = async function(id) {
            try {
                const response = await fetch(`/proyectos/evidencias-api/${id}`);
                if (!response.ok) throw new Error('Error al cargar detalle');
                
                const data = await response.json();
                
                document.getElementById('modalVerTitulo').innerHTML = `
                    <i class="fas ${data.tipo === 'foto' ? 'fa-image' : 'fa-file-pdf'}"></i> ${data.tipo === 'foto' ? 'Ver Foto' : 'Ver Acta'}
                `;
                document.getElementById('verNombre').textContent = data.nombre || '-';
                document.getElementById('verTipo').textContent = data.tipo === 'foto' ? 'Foto' : 'Acta';
                document.getElementById('verProyecto').textContent = data.proyecto || '-';
                document.getElementById('verCategoria').textContent = data.categoria || '-';
                document.getElementById('verFecha').textContent = data.fecha || '-';
                document.getElementById('verTamanio').textContent = data.tamanio || '-';
                document.getElementById('verSubidoPor').textContent = data.subido_por || '-';
                document.getElementById('verDescripcion').textContent = data.descripcion || 'Sin descripción';
                
                // Vista previa
                const contenedor = document.getElementById('vistaPreviaContenedor');
                if (data.tipo === 'foto' && data.archivo_url) {
                    contenedor.innerHTML = `<img src="${data.archivo_url}" style="max-width: 100%; max-height: 400px; border-radius: 4px; object-fit: contain;">`;
                } else if (data.tipo === 'acta') {
                    contenedor.innerHTML = `
                        <div style="text-align: center;">
                            <i class="fas fa-file-pdf" style="font-size: 64px; color: #dc3545; margin-bottom: 10px;"></i>
                            <p>Vista previa de PDF</p>
                            <small style="color: #6c757d;">${data.archivo_nombre || data.nombre}</small>
                        </div>
                    `;
                } else {
                    contenedor.innerHTML = `
                        <div style="text-align: center;">
                            <i class="fas fa-file" style="font-size: 64px; color: #6c757d; margin-bottom: 10px;"></i>
                            <p>No hay vista previa disponible</p>
                        </div>
                    `;
                }
                
                // Botón descargar
                const btnDescargar = document.getElementById('btnDescargarEvidencia');
                btnDescargar.onclick = function() {
                    descargarEvidencia(id);
                };
                
                document.getElementById('modalVerEvidencia').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
            } catch (error) {
                console.error('❌ Error al cargar detalle:', error);
                alert('Error al cargar el detalle de la evidencia');
            }
        };

        window.descargarEvidencia = function(id) {
            window.open(`/proyectos/evidencias-api/descargar/${id}`, '_blank');
        };

        window.eliminarEvidencia = async function(id) {
            if (!confirm('¿Está seguro de eliminar esta evidencia?')) return;
            
            try {
                const response = await fetch(`/proyectos/evidencias-api/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('✅ Evidencia eliminada correctamente');
                    cargarTodosLosDatos();
                } else {
                    alert('❌ Error: ' + (data.message || 'Error al eliminar'));
                }
            } catch (error) {
                console.error('❌ Error al eliminar:', error);
                alert('Error al eliminar la evidencia');
            }
        };

        function cerrarModalVer() {
            document.getElementById('modalVerEvidencia').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.cerrarModalVer = cerrarModalVer;

        // ════════════════════════════════════════════════════════════════
        // EVENT LISTENERS
        // ════════════════════════════════════════════════════════════════

        // Pestañas
        const vistaTabs = document.querySelectorAll('.vista-tab');
        const vistaContents = document.querySelectorAll('.vista-content');

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
                
                if (index === 1) {
                    cargarGaleria(1);
                }
            });
        });

        // Filtros
        document.getElementById('selectorProyecto')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        document.getElementById('fechaFin')?.addEventListener('change', function() {
            currentPage = 1;
            cargarTodosLosDatos();
        });

        document.getElementById('filtroTipoGaleria')?.addEventListener('change', function() {
            galeriaPage = 1;
            cargarGaleria(1);
        });

        document.getElementById('filtroCategoriaGaleria')?.addEventListener('change', function() {
            galeriaPage = 1;
            cargarGaleria(1);
        });

        document.getElementById('filtroProyectoGaleria')?.addEventListener('change', function() {
            galeriaPage = 1;
            cargarGaleria(1);
        });

        let searchTimeout;
        document.getElementById('buscador')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                cargarLista(1);
                cargarGaleria(1);
            }, 500);
        });

        // Botones
        document.getElementById('btnSubir')?.addEventListener('click', function() {
            document.getElementById('modalSubirEvidencia').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        document.getElementById('btnExcel')?.addEventListener('click', function() {
            const params = new URLSearchParams({
                proyecto_id: document.getElementById('selectorProyecto').value,
                fecha_inicio: document.getElementById('fechaInicio').value,
                fecha_fin: document.getElementById('fechaFin').value
            });
            window.open(`/proyectos/evidencias-api/exportar/excel?${params.toString()}`, '_blank');
        });

        document.getElementById('btnGaleria')?.addEventListener('click', function() {
            document.querySelector('[data-vista="galeria"]').click();
        });

        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });

        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage = 1;
                cargarLista(1);
            }
        });

        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarLista(currentPage);
            }
        });

        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const lastPage = Math.ceil(totalRegistros / rowsPerPage);
            if (currentPage < lastPage) {
                currentPage++;
                cargarLista(currentPage);
            }
        });

        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const lastPage = Math.ceil(totalRegistros / rowsPerPage);
            if (currentPage < lastPage) {
                currentPage = lastPage;
                cargarLista(currentPage);
            }
        });

        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = parseInt(this.dataset.pagina);
                if (page !== currentPage) {
                    currentPage = page;
                    cargarLista(page);
                }
            });
        });

        // Modal Subir
        const modalSubir = document.getElementById('modalSubirEvidencia');
        document.getElementById('btnCerrarModal')?.addEventListener('click', function() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        document.getElementById('btnCancelar')?.addEventListener('click', function() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        // Drag and drop
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        dropZone?.addEventListener('click', function() {
            fileInput.click();
        });

        dropZone?.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        dropZone?.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
        });

        dropZone?.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                fileInput.files = e.dataTransfer.files;
                mostrarInfoArchivo(file);
            }
        });

        fileInput?.addEventListener('change', function() {
            if (this.files.length > 0) {
                mostrarInfoArchivo(this.files[0]);
            }
        });

        document.getElementById('btnRemoveFile')?.addEventListener('click', function() {
            fileInput.value = '';
            fileInfo.style.display = 'none';
        });

        function mostrarInfoArchivo(file) {
            const size = (file.size / 1024 / 1024).toFixed(2);
            fileName.textContent = file.name;
            fileSize.textContent = size + ' MB';
            fileInfo.style.display = 'block';
        }

        document.getElementById('btnGuardar')?.addEventListener('click', async function() {
            const tipo = document.getElementById('modalTipo').value;
            const proyectoId = document.getElementById('modalProyecto').value;
            const categoriaId = document.getElementById('modalCategoria').value;
            const nombre = document.getElementById('modalNombre').value;
            const descripcion = document.getElementById('modalDescripcion').value;
            const fecha = document.getElementById('modalFecha').value;
            const file = fileInput.files[0];

            if (!tipo || !proyectoId || !nombre || !file) {
                alert('❌ Por favor complete todos los campos requeridos');
                return;
            }

            const formData = new FormData();
            formData.append('tipo', tipo);
            formData.append('proyecto_id', proyectoId);
            if (categoriaId) formData.append('categoria_id', categoriaId);
            formData.append('nombre', nombre);
            if (descripcion) formData.append('descripcion', descripcion);
            formData.append('fecha', fecha);
            formData.append('archivo', file);

            try {
                const response = await fetch('/proyectos/evidencias-api/subir', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Evidencia subida correctamente');
                    modalSubir.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    cargarTodosLosDatos();
                } else {
                    alert('❌ Error: ' + (result.message || 'Error al subir la evidencia'));
                }
            } catch (error) {
                console.error('❌ Error al subir:', error);
                alert('Error al subir la evidencia');
            }
        });

        // Cerrar modales con click fuera
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('modalSubirEvidencia')) {
                document.getElementById('modalSubirEvidencia').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            if (event.target === document.getElementById('modalVerEvidencia')) {
                cerrarModalVer();
            }
        });

        // Drag and drop para agrupación
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
                        cargarLista(currentPage);
                    }
                });
            }
            
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                    cargarLista(currentPage);
                }
            });
        }

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
            
            expandedGroups.clear();
        }

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
                
                cargarLista(currentPage);
            }
        });

        // Cargar datos iniciales
        cargarTodosLosDatos();
        setupDragAndDrop();

        // Exponer funciones globales
        window.cargarTodosLosDatos = cargarTodosLosDatos;
        window.cargarLista = cargarLista;
        window.cargarGaleria = cargarGaleria;
    });
</script>
@endsection