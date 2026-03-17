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
                <!-- 4 CUADROS DE REPORTES CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Fotos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Fotos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalFotos">1,284</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Reportes del Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Reportes del Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="reportesMes">18</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Proyectos Activos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Proyectos Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="proyectosActivos">6</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Tamaño Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Tamaño Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="tamanoTotal">3.8 GB</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            <option value="torre" selected>🏢 Torre Norte Corporativa</option>
                            <option value="puente">🌉 Puente Vehicular Sur</option>
                            <option value="parque">🏭 Parque Industrial Norte</option>
                            <option value="hospital">🏥 Hospital Regional</option>
                            <option value="planta">💧 Planta de Tratamiento</option>
                            <option value="urbanizacion">🏘️ Urbanización Los Álamos</option>
                        </select>

                        <select id="selectorCategoria" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                            <option value="">Todas las categorías</option>
                            <option value="avance">Avance de Obra</option>
                            <option value="calidad">Control de Calidad</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="reunion">Reuniones / Juntas</option>
                            <option value="entrega">Entregas de Material</option>
                        </select>

                        <!-- Selector de fecha -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="2026-03-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="2026-03-31" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Subir Fotos -->
                        <div>
                            <button id="btnSubir" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Fotos">
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

                        <!-- Botón Vista Galería -->
                        <div>
                            <button id="btnGalería" 
                                    style="background-color: white; border: 1px solid #28a745; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #28a745;"
                                    title="Ver galería">
                                <i class="fas fa-th-large"></i>
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

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-images" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin fotos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- VISTA GALERÍA -->
                <div id="vistaGaleria" class="vista-content active">
                    <!-- Grid de galería -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;" id="galeriaGrid">
                        <!-- Foto 1 - Torre Norte -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=300&fit=crop" alt="Avance de cimentación" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(8,60,174,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Avance
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Cimentación</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">15/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Torre Norte Corporativa</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Avance de cimentación en sector norte. Colado de zapatas.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Juan Pérez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" title="Ver" onclick="verFoto('foto1')"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" title="Descargar" onclick="descargarFoto('foto1')"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;" title="Editar" onclick="editarFoto('foto1')"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 2 - Puente Sur -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&h=300&fit=crop" alt="Instalación de trabes" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(255,193,7,0.8); color: #856404; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Estructura
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Instalación de Trabes</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">14/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Puente Vehicular Sur</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Instalación de trabes de acero en claros 3 y 4.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> María García</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 3 - Parque Industrial -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop" alt="Nivelación de terreno" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(40,167,69,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Terracerías
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Nivelación de Terreno</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">12/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Parque Industrial Norte</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Trabajos de nivelación para nave industrial.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Carlos Rodríguez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 4 - Hospital Regional -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop" alt="Estructura" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(8,60,174,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Estructura
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Columnas y Losas</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">10/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Hospital Regional</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Colado de columnas en nivel 3.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Ana Martínez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 5 - Planta Tratamiento -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop" alt="Equipo instalado" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(23,162,184,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Instalaciones
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Equipo de Bombeo</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">08/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Planta de Tratamiento</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Instalación de equipo de bombeo principal.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Luis Ramírez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 6 - Urbanización -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop" alt="Pavimentación" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(255,193,7,0.8); color: #856404; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Pavimentos
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Pavimentación</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">05/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Urbanización Los Álamos</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Trabajos de pavimentación en calle principal.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Sofía Castro</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 7 - Reunión de obra -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop" alt="Reunión de obra" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(108,117,125,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Reunión
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Junta de Avance</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">07/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Todos los proyectos</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Reunión semanal de coordinación.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Juan Pérez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 8 - Control de calidad -->
                        <div class="galeria-card" style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop" alt="Prueba de calidad" style="width: 100%; height: 100%; object-fit: cover;">
                                <span style="position: absolute; top: 10px; right: 10px; background-color: rgba(40,167,69,0.8); color: white; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    <i class="fas fa-tag"></i> Calidad
                                </span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-weight: 600; font-size: 16px;">Prueba de Concreto</span>
                                    <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">06/03/2026</span>
                                </div>
                                <div style="font-size: 13px; color: #495057; margin-bottom: 5px;">Torre Norte</div>
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Prueba de revenimiento del concreto.</div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 12px; color: #6c757d;"><i class="fas fa-user"></i> Carlos Rodríguez</span>
                                    <div style="display: flex; gap: 10px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; font-size: 16px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación para galería -->
                    <div style="display: flex; justify-content: center; margin-top: 20px;" id="galeriaPaginacion">
                        <div style="display: flex; gap: 5px;">
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">1</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button class="galeria-pagina-btn" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                        </div>
                    </div>
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
                            <tbody>
                                <tr>
                                    <td style="padding: 12px;"><img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=50&h=50&fit=crop" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"></td>
                                    <td style="padding: 12px;">Cimentación</td>
                                    <td style="padding: 12px;">Torre Norte</td>
                                    <td style="padding: 12px;">15/03/2026</td>
                                    <td style="padding: 12px;">Avance</td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;">2.4 MB</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=50&h=50&fit=crop" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"></td>
                                    <td style="padding: 12px;">Instalación de Trabes</td>
                                    <td style="padding: 12px;">Puente Sur</td>
                                    <td style="padding: 12px;">14/03/2026</td>
                                    <td style="padding: 12px;">Estructura</td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;">3.1 MB</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px;"><img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=50&h=50&fit=crop" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"></td>
                                    <td style="padding: 12px;">Nivelación de Terreno</td>
                                    <td style="padding: 12px;">Parque Industrial</td>
                                    <td style="padding: 12px;">12/03/2026</td>
                                    <td style="padding: 12px;">Terracerías</td>
                                    <td style="padding: 12px;">Carlos Rodríguez</td>
                                    <td style="padding: 12px;">2.8 MB</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- VISTA REPORTES AGRUPADOS -->
                <div id="vistaReportes" class="vista-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                        <!-- Reporte Torre Norte -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                            <div style="background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                                <h5 style="margin: 0; color: #083CAE;"><i class="fas fa-building"></i> Torre Norte</h5>
                                <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">12 fotos</span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 15px; overflow-x: auto; padding-bottom: 5px;">
                                    <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 12px; color: #6c757d;">Última foto: 15/03/2026</span>
                                    <button style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 4px 12px; border-radius: 4px; cursor: pointer;">Ver reporte</button>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte Puente Sur -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                            <div style="background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                                <h5 style="margin: 0; color: #083CAE;"><i class="fas fa-bridge"></i> Puente Sur</h5>
                                <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">8 fotos</span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 15px; overflow-x: auto; padding-bottom: 5px;">
                                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 12px; color: #6c757d;">Última foto: 14/03/2026</span>
                                    <button style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 4px 12px; border-radius: 4px; cursor: pointer;">Ver reporte</button>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte Parque Industrial -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                            <div style="background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                                <h5 style="margin: 0; color: #083CAE;"><i class="fas fa-industry"></i> Parque Industrial</h5>
                                <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">15 fotos</span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 15px; overflow-x: auto; padding-bottom: 5px;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 12px; color: #6c757d;">Última foto: 12/03/2026</span>
                                    <button style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 4px 12px; border-radius: 4px; cursor: pointer;">Ver reporte</button>
                                </div>
                            </div>
                        </div>

                        <!-- Reporte Hospital -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                            <div style="background-color: #f8f9fa; padding: 15px; border-bottom: 2px solid #083CAE; display: flex; justify-content: space-between; align-items: center;">
                                <h5 style="margin: 0; color: #083CAE;"><i class="fas fa-hospital"></i> Hospital Regional</h5>
                                <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px;">10 fotos</span>
                            </div>
                            <div style="padding: 15px;">
                                <div style="display: flex; gap: 10px; margin-bottom: 15px; overflow-x: auto; padding-bottom: 5px;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=100&h=80&fit=crop" style="width: 100px; height: 80px; border-radius: 4px; object-fit: cover;">
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 12px; color: #6c757d;">Última foto: 10/03/2026</span>
                                    <button style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 4px 12px; border-radius: 4px; cursor: pointer;">Ver reporte</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Paginación y botón Crear filtro (para vista lista) -->
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
                        <span style="margin-left: 5px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-8 de 24 fotos</span>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Subir Fotos -->
<div id="modalSubir" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-cloud-upload-alt"></i> Subir Fotos</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="torre">Torre Norte Corporativa</option>
                    <option value="puente">Puente Vehicular Sur</option>
                    <option value="parque">Parque Industrial Norte</option>
                    <option value="hospital">Hospital Regional</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría</label>
                <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="avance">Avance de Obra</option>
                    <option value="calidad">Control de Calidad</option>
                    <option value="seguridad">Seguridad</option>
                    <option value="reunion">Reunión / Junta</option>
                    <option value="entrega">Entrega de Material</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <input type="text" id="modalDescripcion" placeholder="Breve descripción de la foto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha</label>
                <input type="date" id="modalFecha" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fotos <span style="color: #dc3545;">*</span></label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 30px; text-align: center; background-color: #f8f9fa;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #6c757d; margin-bottom: 15px;"></i>
                    <p style="margin: 0 0 10px; font-size: 14px;">Arrastra las fotos aquí o haz clic para seleccionar</p>
                    <button style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 20px; cursor: pointer;">Seleccionar archivos</button>
                    <p style="font-size: 11px; color: #6c757d; margin-top: 10px;">JPG, PNG hasta 10MB por foto</p>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Subir Fotos</button>
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
    
    /* Pestañas */
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
    
    /* Galería */
    .galeria-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .galeria-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .galeria-card img {
        transition: transform 0.3s ease;
    }
    
    .galeria-card:hover img {
        transform: scale(1.05);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Reportes Fotográficos');
        
        // Variables
        let currentPage = 1;
        
        // Elementos del DOM
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorCategoria = document.getElementById('selectorCategoria');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const btnSubir = document.getElementById('btnSubir');
        const btnExcel = document.getElementById('btnExcel');
        const btnGaleria = document.getElementById('btnGalería');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const buscador = document.getElementById('buscador');
        
        // Pestañas
        const vistaTabs = document.querySelectorAll('.vista-tab');
        const vistaContents = document.querySelectorAll('.vista-content');
        
        // Modal
        const modalSubir = document.getElementById('modalSubir');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        
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
            });
        });
        
        // Event Listeners
        selectorProyecto.addEventListener('change', function() {
            console.log('Filtrando por proyecto:', this.value);
        });
        
        selectorCategoria.addEventListener('change', function() {
            console.log('Filtrando por categoría:', this.value);
        });
        
        fechaInicio.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        fechaFin.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        buscador.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
        });
        
        // Botones de acción
        btnSubir.addEventListener('click', function() {
            modalSubir.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        btnGaleria.addEventListener('click', function() {
            // Cambiar a pestaña de galería
            document.querySelector('[data-vista="galeria"]').click();
        });
        
        btnCrearFiltro.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        // Paginación
        function cambiarPagina(delta) {
            currentPage += delta;
            if (currentPage < 1) currentPage = 1;
            if (currentPage > 4) currentPage = 4;
            document.getElementById('paginaActual').textContent = currentPage;
        }
        
        btnPrimera.addEventListener('click', () => {
            currentPage = 1;
            document.getElementById('paginaActual').textContent = currentPage;
        });
        
        btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        
        btnUltima.addEventListener('click', () => {
            currentPage = 4;
            document.getElementById('paginaActual').textContent = currentPage;
        });
        
        // Paginación de galería
        document.querySelectorAll('.galeria-pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.galeria-pagina-btn').forEach(b => {
                    b.style.backgroundColor = 'white';
                    b.style.color = '#495057';
                    b.style.border = '1px solid #dee2e6';
                });
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                this.style.border = 'none';
            });
        });
        
        // Modal
        function cerrarModal() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModal.addEventListener('click', cerrarModal);
        btnCancelar.addEventListener('click', cerrarModal);
        
        btnGuardar.addEventListener('click', function() {
            const proyecto = document.getElementById('modalProyecto').value;
            if (!proyecto) {
                alert('Por favor seleccione un proyecto');
                return;
            }
            alert('Fotos subidas correctamente');
            cerrarModal();
        });
        
        window.addEventListener('click', function(event) {
            if (event.target === modalSubir) {
                cerrarModal();
            }
        });
        
        // Funciones para acciones de fotos
        window.verFoto = function(fotoId) {
            alert('Ver foto: ' + fotoId);
        };
        
        window.descargarFoto = function(fotoId) {
            alert('Descargando foto...');
        };
        
        window.editarFoto = function(fotoId) {
            alert('Editar información de la foto');
        };
    });
</script>
@endsection