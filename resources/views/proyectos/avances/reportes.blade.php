@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Reportes Fotográficos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-camera-retro" style="margin-right: 10px;"></i>
                    Reportes Fotográficos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE REPORTES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Fotos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFotos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Reportes del Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="reportesMes">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Proyectos Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="proyectosActivos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tamaño Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="tamanoTotal">0 MB</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtro de Proyectos - Dropdown con checkboxes -->
                        <div style="position: relative; min-width: 200px;" id="proyectoFilterContainer">
                            <button type="button" id="btnFiltroProyectos" style="width: 100%; padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px; display: flex; justify-content: space-between; align-items: center; min-height: 38px;">
                                <span id="filtroProyectosLabel">Todos los proyectos</span>
                                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 12px;"></i>
                            </button>
                            
                            <div id="filtroProyectosDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ced4da; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 280px; overflow: hidden; padding: 8px 0; margin-top: 2px;">
                                <div style="padding: 0 12px 8px 12px; border-bottom: 1px solid #e9ecef;">
                                    <input type="text" id="filtroProyectosBuscar" placeholder="Buscar proyecto..." style="width: 100%; padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                </div>
                                <div id="filtroProyectosLista" style="max-height: 180px; overflow-y: auto; padding: 8px 0;">
                                    <!-- Los checkboxes se cargarán dinámicamente -->
                                </div>
                                <div style="padding: 8px 12px; border-top: 1px solid #e9ecef; display: flex; gap: 10px; flex-wrap: wrap;">
                                    <button id="btnSeleccionarTodos" style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 12px; font-weight: 600;">Seleccionar todos</button>
                                    <button id="btnDeseleccionarTodos" style="background: none; border: none; color: #6c757d; cursor: pointer; font-size: 12px;">Deseleccionar todos</button>
                                    <button id="btnCerrarFiltro" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 12px; margin-left: auto;">Cerrar</button>
                                </div>
                            </div>
                        </div>

                        <select id="selectorCategoria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="todos">Todas las categorías</option>
                            <option value="avance">📈 Avance de Obra</option>
                            <option value="calidad">✅ Control de Calidad</option>
                            <option value="seguridad">⛑️ Seguridad</option>
                            <option value="reunion">👥 Reuniones / Juntas</option>
                            <option value="entrega">🚚 Entregas de Material</option>
                            <option value="instalaciones">🔌 Instalaciones</option>
                            <option value="estructura">🏗️ Estructura</option>
                            <option value="terracerias">⛰️ Terracerías</option>
                            <option value="pavimentos">🛣️ Pavimentos</option>
                        </select>

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnSubir" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Fotos">
                                <i class="fas fa-cloud-upload-alt"></i> Subir
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnGaleria" style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;" title="Ver galería">
                                <i class="fas fa-th-large"></i>
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
                    <button class="vista-tab active" data-vista="galeria" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-th-large"></i> Galería de Fotos
                    </button>
                    <button class="vista-tab" data-vista="lista" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Vista Lista
                    </button>
                    <button class="vista-tab" data-vista="reportes" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-folder"></i> Reportes Agrupados
                    </button>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando fotos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-images" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin fotos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- VISTA GALERÍA -->
                <div id="vistaGaleria" class="vista-content active">
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;" id="galeriaGrid">
                        <!-- Las fotos se cargarán dinámicamente -->
                    </div>
                    <div id="galeriaPaginacion" style="display: flex; justify-content: center; margin-top: 20px;"></div>
                </div>

                <!-- VISTA LISTA -->
                <div id="vistaLista" class="vista-content" style="display: none;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px;">Foto</th>
                                    <th style="padding: 12px;">Nombre</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Categoría</th>
                                    <th style="padding: 12px;">Subido por</th>
                                    <th style="padding: 12px;">Tamaño</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listaBody">
                                <!-- Las filas se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VISTA REPORTES AGRUPADOS -->
                <div id="vistaReportes" class="vista-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;" id="reportesGrid">
                        <!-- Los reportes se cargarán dinámicamente -->
                    </div>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                    <div style="visibility: hidden;"></div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Subir Fotos -->
<div id="modalSubir" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-cloud-upload-alt"></i> Subir Fotos</h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formSubirFotos" enctype="multipart/form-data">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select id="modalProyecto" name="proyecto_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                        <option value="">Seleccionar proyecto...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría</label>
                    <select id="modalCategoria" name="categoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="avance">📈 Avance de Obra</option>
                        <option value="calidad">✅ Control de Calidad</option>
                        <option value="seguridad">⛑️ Seguridad</option>
                        <option value="reunion">👥 Reunión / Junta</option>
                        <option value="entrega">🚚 Entrega de Material</option>
                        <option value="instalaciones">🔌 Instalaciones</option>
                        <option value="estructura">🏗️ Estructura</option>
                        <option value="terracerias">⛰️ Terracerías</option>
                        <option value="pavimentos">🛣️ Pavimentos</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título</label>
                    <input type="text" id="modalTitulo" name="titulo" placeholder="Título de la foto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                    <textarea id="modalDescripcion" name="descripcion" rows="2" placeholder="Descripción detallada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha</label>
                    <input type="date" id="modalFecha" name="fecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fotos <span style="color: #dc3545;">*</span></label>
                    <div id="dropzone" style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa; cursor: pointer; transition: border-color 0.3s;">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #6c757d; margin-bottom: 15px;"></i>
                        <p style="margin: 0 0 10px; font-size: 14px;">Arrastra las fotos aquí o haz clic para seleccionar</p>
                        <p style="font-size: 11px; color: #6c757d; margin-top: 5px;">JPG, PNG, GIF hasta 10MB por foto</p>
                        <input type="file" id="modalArchivos" name="archivos[]" accept="image/*" multiple style="display: none;">
                        <button type="button" id="btnSeleccionarArchivos" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer; margin-top: 10px;">Seleccionar archivos</button>
                    </div>
                    <div id="listaArchivos" style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px;"></div>
                </div>
            </form>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-save"></i> Subir Fotos
            </button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Foto -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-image"></i> <span id="modalTituloDetalle">Detalle de Foto</span>
            </h3>
            <button id="btnCerrarModalDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="modalContenidoDetalle"></div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }
    
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-avance { background-color: #cce5ff; color: #0d6efd; }
    .badge-calidad { background-color: #d4edda; color: #28a745; }
    .badge-seguridad { background-color: #fff3cd; color: #856404; }
    .badge-reunion { background-color: #e2e3e5; color: #6c757d; }
    .badge-entrega { background-color: #d1ecf1; color: #0c5460; }
    .badge-instalaciones { background-color: #ffe5d0; color: #fd7e14; }
    .badge-estructura { background-color: #e0d4f5; color: #6f42c1; }
    .badge-terracerias { background-color: #d4f5e6; color: #20c997; }
    .badge-pavimentos { background-color: #f5d4e6; color: #e83e8c; }
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-archivado { background-color: #e2e3e5; color: #6c757d; }
    
    .vista-tab { transition: all 0.3s ease; }
    .vista-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .vista-tab.active { background-color: #083CAE !important; color: white !important; }
    .vista-content { animation: fadeIn 0.3s ease; }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    
    .galeria-card { transition: transform 0.2s, box-shadow 0.2s; }
    .galeria-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .galeria-card img { transition: transform 0.3s ease; width: 100%; height: 200px; object-fit: cover; }
    .galeria-card:hover img { transform: scale(1.03); }
    
    #dropzone.dragover { border-color: #083CAE; background-color: #f0f4ff; }
    
    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    #filtroProyectosDropdown { min-width: 250px; }
    #filtroProyectosLista label { display: flex; align-items: center; padding: 4px 12px; cursor: pointer; font-size: 13px; transition: background 0.2s; }
    #filtroProyectosLista label:hover { background-color: #f0f4ff; }
    #filtroProyectosLista input[type="checkbox"] { margin-right: 8px; cursor: pointer; }
    
    .preview-image { position: relative; display: inline-block; }
    .preview-image img { width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6; }
    .preview-image .remove-file { position: absolute; top: -6px; right: -6px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
    
    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalSubir > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
        .vista-tab { padding: 8px 12px !important; font-size: 12px !important; }
        #reportesGrid { grid-template-columns: 1fr !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/reportes-fotograficos';
    let currentPage = 1;
    let totalPages = 1;
    let currentView = 'galeria';
    let proyectosLista = [];
    let archivosSeleccionados = [];
    
    let currentFilters = {
        busqueda: '',
        proyecto_id: [],
        categoria: 'todos',
        fecha_inicio: '',
        fecha_fin: '',
        page: 1,
        per_page: 12
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarFotos() {
        mostrarLoading(true);
        
        try {
            if (!currentFilters.fecha_inicio) {
                const hoy = new Date();
                const seisMesesAtras = new Date();
                seisMesesAtras.setMonth(hoy.getMonth() - 6);
                currentFilters.fecha_inicio = seisMesesAtras.toISOString().split('T')[0];
                currentFilters.fecha_fin = hoy.toISOString().split('T')[0];
                document.getElementById('fechaInicio').value = currentFilters.fecha_inicio;
                document.getElementById('fechaFin').value = currentFilters.fecha_fin;
            }
            
            const proyectosSeleccionados = getProyectosSeleccionados();
            currentFilters.proyecto_id = proyectosSeleccionados;
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('categoria', currentFilters.categoria || 'todos');
            params.append('fecha_inicio', currentFilters.fecha_inicio || '');
            params.append('fecha_fin', currentFilters.fecha_fin || '');
            params.append('page', currentFilters.page || 1);
            params.append('per_page', currentFilters.per_page || 12);
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
            const url = `${API_BASE}?${params.toString()}`;
            console.log('Cargando desde:', url);
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 200)}`);
            }
            
            const result = await response.json();
            console.log('Resultado:', result);
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                actualizarConteosCategorias(result.conteos_categorias);
                
                if (currentView === 'galeria') {
                    renderizarGaleria(data);
                } else if (currentView === 'lista') {
                    renderizarLista(data);
                } else if (currentView === 'reportes') {
                    renderizarReportes(data);
                }
                
                actualizarPaginacion(pagination);
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar las fotos: ' + error.message, 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    // ============================================
    // FILTRO DE PROYECTOS
    // ============================================

    function getProyectosSeleccionados() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked');
        const selected = [];
        checkboxes.forEach(cb => {
            if (cb.value) {
                selected.push(cb.value);
            }
        });
        return selected;
    }

    function actualizarLabelProyectos() {
        const total = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').length;
        const selected = getProyectosSeleccionados().length;
        const label = document.getElementById('filtroProyectosLabel');
        
        if (selected === 0 || selected === total) {
            label.textContent = 'Todos los proyectos';
        } else {
            label.textContent = `${selected} proyecto${selected > 1 ? 's' : ''} seleccionado${selected > 1 ? 's' : ''}`;
        }
    }

    function toggleDropdown() {
        const dropdown = document.getElementById('filtroProyectosDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function cerrarDropdown() {
        document.getElementById('filtroProyectosDropdown').style.display = 'none';
    }

    function renderizarCheckboxesProyectos(proyectos) {
        const lista = document.getElementById('filtroProyectosLista');
        lista.innerHTML = '';
        
        if (!proyectos || proyectos.length === 0) {
            lista.innerHTML = '<div style="padding: 8px 12px; color: #6c757d; font-size: 13px;">No hay proyectos disponibles</div>';
            return;
        }
        
        const selected = getProyectosSeleccionados();
        
        proyectos.forEach(proyecto => {
            const checked = selected.includes(String(proyecto.id)) ? 'checked' : '';
            const label = document.createElement('label');
            label.innerHTML = `
                <input type="checkbox" value="${proyecto.id}" ${checked}>
                <span>${proyecto.nombre}</span>
            `;
            lista.appendChild(label);
        });
        
        actualizarLabelProyectos();
    }

    function filtrarProyectosLista(busqueda) {
        const labels = document.querySelectorAll('#filtroProyectosLista label');
        const term = busqueda.toLowerCase().trim();
        
        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            label.style.display = text.includes(term) ? 'flex' : 'none';
        });
    }

    function seleccionarTodosProyectos() {
        const todosVisibles = document.querySelectorAll('#filtroProyectosLista label:not([style*="display: none"])');
        todosVisibles.forEach(label => {
            const cb = label.querySelector('input[type="checkbox"]');
            if (cb) cb.checked = true;
        });
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function deseleccionarTodosProyectos() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function aplicarFiltroProyectos() {
        currentFilters.page = 1;
        cargarFotos();
    }

    // ============================================
    // CATÁLOGOS
    // ============================================

    async function cargarCatalogos() {
        try {
            const proyectosResp = await fetch(`${API_BASE}/catalogos/proyectos`, {
                headers: { 'Accept': 'application/json' }
            });
            const proyectosResult = await proyectosResp.json();
            
            if (proyectosResult.success) {
                const select = document.getElementById('modalProyecto');
                const options = proyectosResult.data.map(p => 
                    `<option value="${p.id}">${p.nombre}</option>`
                ).join('');
                select.innerHTML = `<option value="">Seleccionar proyecto...</option>${options}`;
                
                proyectosLista = proyectosResult.data;
                renderizarCheckboxesProyectos(proyectosLista);
            }
        } catch (error) {
            console.error('Error cargando catálogos:', error);
        }
    }

    // ============================================
    // RENDERIZADO - GALERÍA
    // ============================================

    function renderizarGaleria(fotos) {
        const grid = document.getElementById('galeriaGrid');
        const sinDatos = document.getElementById('sinDatosMensaje');
        
        if (!fotos || fotos.length === 0) {
            grid.innerHTML = '';
            sinDatos.style.display = 'block';
            document.getElementById('galeriaPaginacion').style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        document.getElementById('galeriaPaginacion').style.display = 'flex';
        
        grid.innerHTML = fotos.map(foto => `
            <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                    <img src="${foto.url || 'https://via.placeholder.com/400x300/e9ecef/6c757d?text=Sin+Imagen'}" alt="${foto.titulo}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://via.placeholder.com/400x300/e9ecef/6c757d?text=Error'">
                    <span style="position: absolute; top: 10px; right: 10px; background-color: ${foto.categoria_color || '#083CAE'}; color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                        <i class="fas ${foto.categoria_icono || 'fa-tag'}"></i> ${foto.categoria_nombre || 'Sin categoría'}
                    </span>
                </div>
                <div style="padding: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-weight: 600; font-size: 16px;">${foto.titulo || 'Sin título'}</span>
                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">${foto.fecha_formateada || '-'}</span>
                    </div>
                    <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">${foto.proyecto?.nombre || 'Sin proyecto'}</div>
                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">${foto.descripcion || 'Sin descripción'}</div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> ${foto.responsable_nombre || 'Sistema'}</span>
                        <div style="display: flex; gap: 10px;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver" onclick="verDetalle(${foto.id})"></i>
                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" title="Descargar" onclick="descargarFoto(${foto.id})"></i>
                            <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;" title="Editar" onclick="editarFoto(${foto.id})"></i>
                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 16px;" title="Eliminar" onclick="eliminarFoto(${foto.id})"></i>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // ============================================
    // RENDERIZADO - LISTA
    // ============================================

    function renderizarLista(fotos) {
        const tbody = document.getElementById('listaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        
        if (!fotos || fotos.length === 0) {
            tbody.innerHTML = '';
            sinDatos.style.display = 'block';
            return;
        }
        
        sinDatos.style.display = 'none';
        
        tbody.innerHTML = fotos.map(foto => `
            <tr>
                <td style="padding: 12px;">
                    <img src="${foto.url || 'https://via.placeholder.com/50x50/e9ecef/6c757d?text=No'}" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/50x50/e9ecef/6c757d?text=Error'">
                </td>
                <td style="padding: 12px;">${foto.titulo || '-'}</td>
                <td style="padding: 12px;">${foto.proyecto?.nombre || '-'}</td>
                <td style="padding: 12px;">${foto.fecha_formateada || '-'}</td>
                <td style="padding: 12px;"><span class="badge ${foto.categoria_badge || 'badge-categoria'}">${foto.categoria_nombre || '-'}</span></td>
                <td style="padding: 12px;">${foto.responsable_nombre || '-'}</td>
                <td style="padding: 12px;">${foto.tamanio_formateado || '-'}</td>
                <td style="padding: 12px;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verDetalle(${foto.id})"></i>
                    <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="descargarFoto(${foto.id})"></i>
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; margin: 0 5px;" onclick="eliminarFoto(${foto.id})"></i>
                </td>
            </tr>
        `).join('');
    }

    // ============================================
    // RENDERIZADO - REPORTES AGRUPADOS
    // ============================================

    function renderizarReportes(fotos) {
        const grid = document.getElementById('reportesGrid');
        const sinDatos = document.getElementById('sinDatosMensaje');
        
        if (!fotos || fotos.length === 0) {
            grid.innerHTML = '';
            sinDatos.style.display = 'block';
            return;
        }
        
        sinDatos.style.display = 'none';
        
        // Agrupar por proyecto
        const grupos = {};
        fotos.forEach(foto => {
            const key = foto.proyecto_id;
            if (!grupos[key]) {
                grupos[key] = {
                    proyecto: foto.proyecto,
                    fotos: []
                };
            }
            grupos[key].fotos.push(foto);
        });
        
        grid.innerHTML = Object.values(grupos).map(grupo => `
            <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                <div style="background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                    <h5 style="margin: 0; color: #083CAE;">
                        <i class="fas fa-building"></i> ${grupo.proyecto?.nombre || 'Sin proyecto'}
                    </h5>
                    <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">${grupo.fotos.length} fotos</span>
                </div>
                <div style="padding: 15px;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; overflow-x: auto; padding-bottom: 5px;">
                        ${grupo.fotos.slice(0, 5).map(foto => `
                            <img src="${foto.url || 'https://via.placeholder.com/100x80/e9ecef/6c757d?text=No'}" 
                                 style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover; cursor: pointer;" 
                                 onclick="verDetalle(${foto.id})"
                                 onerror="this.src='https://via.placeholder.com/100x80/e9ecef/6c757d?text=Error'">
                        `).join('')}
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 12px; color: #6c757d;">Última foto: ${grupo.fotos[0]?.fecha_formateada || '-'}</span>
                        <button style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 4px 12px; border-radius: 4px; cursor: pointer;" onclick="verReporte(${grupo.proyecto?.id})">Ver reporte</button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // ============================================
    // ESTADÍSTICAS Y PAGINACIÓN
    // ============================================

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalFotos').textContent = stats.total_fotos || 0;
        document.getElementById('reportesMes').textContent = stats.reportes_mes || 0;
        document.getElementById('proyectosActivos').textContent = stats.proyectos_activos || 0;
        document.getElementById('tamanoTotal').textContent = stats.tamano_total || '0 MB';
    }

    function actualizarConteosCategorias(conteos) {
        if (!conteos) return;
        // Los conteos se actualizan en las pestañas
    }

    function actualizarPaginacion(pagination) {
        if (!pagination) return;
        document.getElementById('paginaActual').textContent = pagination.current_page || 1;
        document.getElementById('totalPaginas').textContent = `de ${pagination.last_page || 1}`;
        document.getElementById('paginacionInfo').textContent = 
            `Mostrando ${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    }

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function formatCurrency(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function mostrarLoading(show) {
        document.getElementById('loadingSpinner').style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.verDetalle = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const foto = result.data;
                document.getElementById('modalTituloDetalle').textContent = foto.titulo || 'Detalle de Foto';
                
                const contenido = `
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="${foto.url || 'https://via.placeholder.com/600x400/e9ecef/6c757d?text=Sin+Imagen'}" 
                             style="max-width: 100%; max-height: 400px; border-radius: 8px; object-fit: contain;" 
                             onerror="this.src='https://via.placeholder.com/600x400/e9ecef/6c757d?text=Error'">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Título</div>
                            <div style="font-size: 16px; font-weight: 600;">${foto.titulo || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                            <div style="font-size: 16px;">${foto.proyecto?.nombre || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                            <div style="font-size: 16px;"><span class="badge ${foto.categoria_badge || 'badge-categoria'}">${foto.categoria_nombre || '-'}</span></div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                            <div style="font-size: 16px;">${foto.fecha_formateada || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Responsable</div>
                            <div style="font-size: 16px;">${foto.responsable_nombre || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Tamaño</div>
                            <div style="font-size: 16px;">${foto.tamanio_formateado || '-'}</div>
                        </div>
                    </div>
                    ${foto.descripcion ? `
                    <div style="margin-top: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 14px;">${foto.descripcion}</div>
                    </div>` : ''}
                    ${foto.observaciones ? `
                    <div style="margin-top: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 14px;">${foto.observaciones}</div>
                    </div>` : ''}
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                        <button onclick="descargarFoto(${foto.id})" style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-download"></i> Descargar
                        </button>
                        <button onclick="cerrarModalDetalle()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('modalContenidoDetalle').innerHTML = contenido;
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.descargarFoto = function(id) {
        window.open(`${API_BASE}/${id}/descargar`, '_blank');
    };

    window.editarFoto = function(id) {
        mostrarNotificacion('Funcionalidad de edición en desarrollo', 'warning');
    };

    window.eliminarFoto = function(id) {
        if (!confirm('¿Está seguro de eliminar esta foto?')) return;
        
        fetch(`${API_BASE}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarFotos();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar', 'error');
            }
        })
        .catch(error => {
            mostrarNotificacion('Error al eliminar la foto', 'error');
        });
    };

    window.verReporte = function(proyectoId) {
        // Cambiar filtro al proyecto y recargar
        document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').forEach(cb => {
            cb.checked = cb.value == proyectoId;
        });
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
        // Cambiar a vista galería
        document.querySelector('[data-vista="galeria"]').click();
    };

    function cerrarModalDetalle() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    async function exportarExcel() {
        try {
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('categoria', currentFilters.categoria || 'todos');
            params.append('fecha_inicio', currentFilters.fecha_inicio || '');
            params.append('fecha_fin', currentFilters.fecha_fin || '');
            
            const proyectos = getProyectosSeleccionados();
            if (proyectos.length > 0) {
                proyectos.forEach(id => params.append('proyecto_id[]', id));
            }
            
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = result.data.headers || [];
                const rows = result.data.rows || [];
                
                if (headers.length === 0 || rows.length === 0) {
                    mostrarNotificacion('No hay datos para exportar', 'warning');
                    return;
                }
                
                const csvContent = [headers.join(','), ...rows.map(row => row.join(','))].join('\n');
                const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `ReportesFotograficos_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // FORMULARIO - SUBIR FOTOS
    // ============================================

    function manejarSeleccionArchivos(files) {
        archivosSeleccionados = Array.from(files);
        actualizarVistaPrevia();
    }

    function actualizarVistaPrevia() {
        const container = document.getElementById('listaArchivos');
        container.innerHTML = '';
        
        archivosSeleccionados.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-image';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <button class="remove-file" onclick="removerArchivo(${index})">&times;</button>
                    <div style="font-size: 10px; color: #6c757d; text-align: center; max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${file.name}</div>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removerArchivo = function(index) {
        archivosSeleccionados.splice(index, 1);
        actualizarVistaPrevia();
        // Actualizar input file
        const dt = new DataTransfer();
        archivosSeleccionados.forEach(file => dt.items.add(file));
        document.getElementById('modalArchivos').files = dt.files;
    };

    function abrirModalSubir() {
        document.getElementById('modalSubir').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('formSubirFotos').reset();
        archivosSeleccionados = [];
        document.getElementById('listaArchivos').innerHTML = '';
        
        const hoy = new Date();
        document.getElementById('modalFecha').value = hoy.toISOString().split('T')[0];
    }

    function cerrarModalSubir() {
        document.getElementById('modalSubir').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        const hoy = new Date();
        const seisMesesAtras = new Date();
        seisMesesAtras.setMonth(hoy.getMonth() - 6);
        document.getElementById('fechaInicio').value = seisMesesAtras.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
        currentFilters.fecha_inicio = document.getElementById('fechaInicio').value;
        currentFilters.fecha_fin = document.getElementById('fechaFin').value;
        
        cargarCatalogos();
        cargarFotos();
        
        // Eventos del dropdown de proyectos
        document.getElementById('btnFiltroProyectos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });
        
        document.getElementById('btnCerrarFiltro')?.addEventListener('click', function(e) {
            e.stopPropagation();
            cerrarDropdown();
        });
        
        document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            seleccionarTodosProyectos();
        });
        
        document.getElementById('btnDeseleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            deseleccionarTodosProyectos();
        });
        
        document.getElementById('filtroProyectosBuscar')?.addEventListener('input', function(e) {
            e.stopPropagation();
            filtrarProyectosLista(this.value);
        });
        
        document.getElementById('filtroProyectosLista')?.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                actualizarLabelProyectos();
                aplicarFiltroProyectos();
            }
        });
        
        document.addEventListener('click', function(e) {
            const container = document.getElementById('proyectoFilterContainer');
            if (container && !container.contains(e.target)) {
                cerrarDropdown();
            }
        });
        
        // Pestañas
        document.querySelectorAll('.vista-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.vista-tab').forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                currentView = this.dataset.vista;
                
                document.querySelectorAll('.vista-content').forEach(content => {
                    content.style.display = 'none';
                });
                
                const target = document.getElementById(`vista${currentView.charAt(0).toUpperCase() + currentView.slice(1)}`);
                if (target) {
                    target.style.display = currentView === 'galeria' ? 'block' : 'block';
                }
                
                currentFilters.page = 1;
                cargarFotos();
            });
        });
        
        // Filtros
        document.getElementById('selectorCategoria')?.addEventListener('change', function() {
            currentFilters.categoria = this.value;
            currentFilters.page = 1;
            cargarFotos();
        });
        
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            currentFilters.fecha_inicio = this.value;
            currentFilters.page = 1;
            cargarFotos();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            currentFilters.fecha_fin = this.value;
            currentFilters.page = 1;
            cargarFotos();
        });
        
        document.getElementById('buscador')?.addEventListener('input', function() {
            currentFilters.busqueda = this.value;
            currentFilters.page = 1;
            cargarFotos();
        });
        
        // Botones principales
        document.getElementById('btnSubir')?.addEventListener('click', abrirModalSubir);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnGaleria')?.addEventListener('click', function() {
            document.querySelector('[data-vista="galeria"]').click();
        });
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarFotos(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarFotos(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarFotos(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarFotos(); }
        });
        
        // Modal Subir
        document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModalSubir);
        document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalSubir);
        document.getElementById('btnCerrarModalDetalle')?.addEventListener('click', cerrarModalDetalle);
        
        // Dropzone
        const dropzone = document.getElementById('dropzone');
        dropzone?.addEventListener('click', function() {
            document.getElementById('modalArchivos').click();
        });
        
        dropzone?.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        dropzone?.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        dropzone?.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                manejarSeleccionArchivos(files);
            }
        });
        
        document.getElementById('btnSeleccionarArchivos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('modalArchivos').click();
        });
        
        document.getElementById('modalArchivos')?.addEventListener('change', function() {
            if (this.files.length > 0) {
                manejarSeleccionArchivos(this.files);
            }
        });
        
        // ============================================
        // SUBMIT FORMULARIO - CORREGIDO
        // ============================================
        document.getElementById('btnGuardar')?.addEventListener('click', async function() {
            const form = document.getElementById('formSubirFotos');
            
            if (archivosSeleccionados.length === 0) {
                mostrarNotificacion('Debe seleccionar al menos una foto', 'error');
                return;
            }
            
            // Crear FormData manualmente para evitar duplicados
            const formData = new FormData();
            formData.append('proyecto_id', document.getElementById('modalProyecto').value);
            formData.append('categoria', document.getElementById('modalCategoria').value);
            formData.append('titulo', document.getElementById('modalTitulo').value || '');
            formData.append('descripcion', document.getElementById('modalDescripcion').value || '');
            formData.append('fecha', document.getElementById('modalFecha').value || '');
            
            // Agregar cada archivo seleccionado
            archivosSeleccionados.forEach(file => {
                formData.append('archivos[]', file);
            });
            
            try {
                const response = await fetch(API_BASE, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await response.json();
                
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalSubir();
                    cargarFotos();
                } else {
                    mostrarNotificacion(result.message || 'Error al subir fotos', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarNotificacion('Error al subir las fotos', 'error');
            }
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(e) {
            const modalSubir = document.getElementById('modalSubir');
            const modalDetalle = document.getElementById('modalVerDetalle');
            
            if (e.target === modalSubir) cerrarModalSubir();
            if (e.target === modalDetalle) cerrarModalDetalle();
        });
    });
</script>
@endsection