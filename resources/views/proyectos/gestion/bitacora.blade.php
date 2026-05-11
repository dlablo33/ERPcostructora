@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Bitácora de Obra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-book"></i> Bitácora de Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y controles principales -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Selector de proyecto -->
                        <div>
                            <select id="selectorProyecto" class="form-select" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 250px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto['id'] }}">{{ $proyecto['id'] }} - {{ $proyecto['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selector de tipo de bitácora -->
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="tipo-bitacora-btn active" data-tipo="diaria" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-calendar-day"></i> Diaria
                            </button>
                            <button class="tipo-bitacora-btn" data-tipo="semanal" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-calendar-week"></i> Semanal
                            </button>
                            <button class="tipo-bitacora-btn" data-tipo="mensual" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                <i class="fas fa-calendar-alt"></i> Mensual
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Rango de fechas -->
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-t') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>

                        <!-- Botones de acción -->
                        <button id="btnNuevaEntrada" class="btn-nueva" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-plus"></i> Nueva Entrada
                        </button>
                        <button id="btnExportarPDF" style="padding: 8px 15px; background-color: white; border: 1px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </button>
                        <button id="btnImprimir" style="padding: 8px 15px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>

                <!-- Resumen de bitácora - DINÁMICO -->
                <div class="resumen-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-alt" style="color: #083CAE;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Total Entradas</div>
                                <div class="total-entradas" style="font-size: 24px; font-weight: bold; color: #083CAE;">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Actividades</div>
                                <div class="total-actividades" style="font-size: 24px; font-weight: bold; color: #28a745;">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Incidencias</div>
                                <div class="total-incidencias" style="font-size: 24px; font-weight: bold; color: #ffc107;">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #f8d7da; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock" style="color: #dc3545;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Pendientes</div>
                                <div class="total-pendientes" style="font-size: 24px; font-weight: bold; color: #dc3545;">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones de bitácora -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE;">
                    <button class="bitacora-tab active" data-tab="registros" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Registros de Bitácora
                    </button>
                    <button class="bitacora-tab" data-tab="incidencias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-circle"></i> Incidencias
                    </button>
                    <button class="bitacora-tab" data-tab="fotografias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-camera"></i> Evidencia Fotográfica
                    </button>
                    <button class="bitacora-tab" data-tab="reportes" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Reportes
                    </button>
                </div>

                <!-- SECCIÓN 1: REGISTROS DE BITÁCORA - DINÁMICO -->
                <div id="tab-registros" class="bitacora-content active">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <select id="filtroResponsable" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos los responsables</option>
                            </select>
                            <select id="filtroTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos los tipos</option>
                                <option value="actividad">Actividad</option>
                                <option value="incidencia">Incidencia</option>
                                <option value="acuerdo">Acuerdo</option>
                                <option value="nota">Nota</option>
                            </select>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" id="buscadorBitacora" placeholder="Buscar en bitácora..." style="padding: 8px 8px 8px 35px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; width: 250px;">
                        </div>
                    </div>

                    <!-- Lista de entradas de bitácora (timeline) -->
                    <div id="bitacora-timeline" class="timeline" style="position: relative; padding-left: 30px;">
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>
                        <div id="entries-loading" class="text-center py-5" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p>Cargando entradas...</p>
                        </div>
                        <div id="entries-container"></div>
                    </div>

                    <!-- Paginación -->
                    <div id="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;"></div>
                </div>

                <!-- SECCIÓN 2: INCIDENCIAS - DINÁMICO -->
                <div id="tab-incidencias" class="bitacora-content" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #083CAE; font-size: 18px; margin: 0;">
                            <i class="fas fa-exclamation-triangle"></i> Incidencias Reportadas
                        </h3>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1000px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dc3545;">
                                <tr><th style="padding: 12px;">Código</th><th style="padding: 12px;">Proyecto</th><th style="padding: 12px;">Fecha</th><th style="padding: 12px;">Tipo</th><th style="padding: 12px;">Descripción</th><th style="padding: 12px;">Prioridad</th><th style="padding: 12px;">Estado</th><th style="padding: 12px;">Acciones</th></tr>
                            </thead>
                            <tbody id="incidencias-table-body">
                                <tr><td colspan="8" class="text-center">Cargando incidencias...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="incidencias-pagination" class="mt-3"></div>
                </div>

                <!-- SECCIÓN 3: EVIDENCIA FOTOGRÁFICA - DINÁMICO -->
                <div id="tab-fotografias" class="bitacora-content" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #083CAE; font-size: 18px; margin: 0;">
                            <i class="fas fa-images"></i> Galería de Evidencias
                        </h3>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <select id="galeriaFiltroProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los proyectos</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto['id'] }}">{{ $proyecto['id'] }} - {{ $proyecto['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="galeria-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        <div class="text-center py-5">Cargando imágenes...</div>
                    </div>
                </div>

                <!-- SECCIÓN 4: REPORTES - DINÁMICO -->
                <div id="tab-reportes" class="bitacora-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0;"><i class="fas fa-chart-pie"></i> Actividades por Proyecto</h4>
                            <canvas id="actividadesChart" height="200"></canvas>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #dc3545; margin: 0 0 15px 0;"><i class="fas fa-chart-bar"></i> Incidencias por Prioridad</h4>
                            <canvas id="incidenciasChart" height="200"></canvas>
                        </div>
                    </div>
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0;"><i class="fas fa-chart-line"></i> Evolución de Actividades</h4>
                        <canvas id="evolucionChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nueva Entrada de Bitácora -->
<div id="modalNuevaEntrada" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <form id="formNuevaEntrada" enctype="multipart/form-data">
            <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nueva Entrada de Bitácora</h3>
                <button type="button" id="btnCerrarModalEntrada" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
            </div>
            
            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                        <select name="proyecto_id" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Seleccionar proyecto...</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto['id'] }}">{{ $proyecto['id'] }} - {{ $proyecto['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo <span style="color: #dc3545;">*</span></label>
                        <select name="tipo" id="tipoEntrada" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="actividad">Actividad</option>
                            <option value="incidencia">Incidencia</option>
                            <option value="acuerdo">Acuerdo</option>
                            <option value="nota">Nota General</option>
                        </select>
                    </div>
                </div>

                <div id="camposIncidencia" style="display: none; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Incidencia</label>
                        <select name="tipo_incidencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="mecanica">Mecánica</option>
                            <option value="personal">Personal</option>
                            <option value="material">Material</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="clima">Clima</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Prioridad</label>
                        <select name="prioridad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                            <option value="critica">Crítica</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha <span style="color: #dc3545;">*</span></label>
                        <input type="date" name="fecha" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hora</label>
                        <input type="time" name="hora" value="{{ date('H:i') }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                        <input type="text" name="responsable" value="{{ auth()->user()->name }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título <span style="color: #dc3545;">*</span></label>
                    <input type="text" name="titulo" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Inicio de cimentación">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción <span style="color: #dc3545;">*</span></label>
                    <textarea name="descripcion" rows="4" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
                </div>

                <div id="campoAccionTomada" style="display: none; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Acción Tomada</label>
                    <textarea name="accion_tomada" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Personal</label>
                        <input type="text" name="personal" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 12 obreros">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Maquinaria</label>
                        <input type="text" name="maquinaria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 2 retroexcavadoras">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Materiales</label>
                        <input type="text" name="materiales" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 20m³ concreto">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Adjuntar imágenes</label>
                    <input type="file" name="imagenes[]" multiple accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelarEntrada" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Entrada</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para ver imagen -->
<div id="modalImagen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); z-index: 1001; align-items: center; justify-content: center;">
    <span id="cerrarModalImagen" style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; cursor: pointer;">&times;</span>
    <img id="modalImagenSrc" style="max-width: 90%; max-height: 90%; margin: auto; display: block;">
</div>

<style>
    .vista-btn, .tipo-bitacora-btn, .bitacora-tab { transition: all 0.3s ease; }
    .vista-btn:hover, .tipo-bitacora-btn:hover, .bitacora-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .vista-btn.active, .tipo-bitacora-btn.active, .bitacora-tab.active { background-color: #083CAE !important; color: white !important; }
    .resumen-card { transition: transform 0.2s; cursor: pointer; }
    .resumen-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .bitacora-content { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .timeline-item { transition: transform 0.2s; margin-bottom: 30px; position: relative; }
    .timeline-item:hover { transform: translateX(5px); }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    ::-webkit-scrollbar-thumb { background: #083CAE; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #052a6b; }
    .btn-accion { background: none; border: none; cursor: pointer; padding: 5px; margin: 0 3px; }
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    .badge-actividad { background-color: #d4edda; color: #155724; }
    .badge-incidencia { background-color: #f8d7da; color: #721c24; }
    .badge-acuerdo { background-color: #fff3cd; color: #856404; }
    .badge-nota { background-color: #d1ecf1; color: #0c5460; }
    @media (max-width: 768px) {
        .timeline { padding-left: 15px; }
        .timeline-item > div:first-child { left: -15px !important; width: 20px !important; height: 20px !important; font-size: 10px !important; }
        .timeline-item > div:last-child { margin-left: 10px !important; padding: 15px !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let currentPage = 1;
let currentFilters = {};

$(document).ready(function() {
    cargarEntradas();
    cargarIncidencias();
    cargarEvidencias();
    cargarEstadisticas();
    cargarGraficos();

    $('#tipoEntrada').on('change', function() {
        if ($(this).val() === 'incidencia') {
            $('#camposIncidencia, #campoAccionTomada').show();
        } else {
            $('#camposIncidencia, #campoAccionTomada').hide();
        }
    });

    $('#selectorProyecto, #filtroResponsable, #filtroTipo').on('change', function() { aplicarFiltros(); });
    $('#fechaInicio, #fechaFin').on('change', function() { aplicarFiltros(); });
    $('#buscadorBitacora').on('keyup', debounce(function() { aplicarFiltros(); }, 500));

    $('.tipo-bitacora-btn').on('click', function() {
        $('.tipo-bitacora-btn').removeClass('active').css({backgroundColor: 'transparent', color: '#495057'});
        $(this).addClass('active').css({backgroundColor: '#083CAE', color: 'white'});
        aplicarFiltros();
    });

    $('.bitacora-tab').on('click', function() {
        const tab = $(this).data('tab');
        $('.bitacora-tab').removeClass('active').css({backgroundColor: '#e9ecef', color: '#495057'});
        $(this).addClass('active').css({backgroundColor: '#083CAE', color: 'white'});
        $('.bitacora-content').hide();
        $('#tab-' + tab).show();
        if (tab === 'reportes') cargarGraficos();
        if (tab === 'incidencias') cargarIncidencias();
        if (tab === 'fotografias') cargarEvidencias();
    });

    $('#btnNuevaEntrada').on('click', () => $('#modalNuevaEntrada').css('display', 'flex'));
    $('#btnCerrarModalEntrada, #btnCancelarEntrada').on('click', () => $('#modalNuevaEntrada').hide());

    $('#formNuevaEntrada').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: '/api/bitacora/entries',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    alert('Entrada creada exitosamente');
                    $('#modalNuevaEntrada').hide();
                    $('#formNuevaEntrada')[0].reset();
                    cargarEntradas();
                    cargarEstadisticas();
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) alert(Object.values(errors).flat().join('\n'));
                else alert('Error al crear la entrada');
            }
        });
    });

    $('#btnExportarPDF').on('click', function() {
        const params = new URLSearchParams({
            proyecto_id: $('#selectorProyecto').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val()
        });
        window.open(`/bitacora/export-pdf?${params.toString()}`, '_blank');
    });

    $('#btnImprimir').on('click', () => window.print());

    $('#cerrarModalImagen, #modalImagen').on('click', function(e) {
        if (e.target === this) $('#modalImagen').hide();
    });
});

function aplicarFiltros() {
    currentFilters = {
        proyecto_id: $('#selectorProyecto').val(),
        fecha_inicio: $('#fechaInicio').val(),
        fecha_fin: $('#fechaFin').val(),
        responsable: $('#filtroResponsable').val(),
        tipo: $('#filtroTipo').val(),
        search: $('#buscadorBitacora').val()
    };
    currentPage = 1;
    cargarEntradas();
    cargarEstadisticas();
}

function cargarEntradas() {
    $('#entries-loading').show();
    $('#entries-container').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Cargando...</p></div>');
    
    $.ajax({
        url: '/api/bitacora/entries',
        method: 'GET',
        data: { ...currentFilters, page: currentPage, per_page: 10 },
        success: function(response) {
            if (response.success) {
                renderizarEntradas(response.data);
                renderizarPaginacion(response);
            }
        },
        error: function() {
            $('#entries-container').html('<div class="alert alert-danger">Error al cargar las entradas</div>');
        },
        complete: function() {
            $('#entries-loading').hide();
        }
    });
}

function renderizarEntradas(entries) {
    if (!entries || entries.length === 0) {
        $('#entries-container').html('<div class="text-center py-5"><i class="fas fa-inbox fa-3x text-muted"></i><p class="mt-2">No hay entradas registradas</p></div>');
        return;
    }

    let html = '';
    entries.forEach(entry => {
        const color = entry.tipo === 'actividad' ? '#083CAE' : (entry.tipo === 'incidencia' ? '#dc3545' : (entry.tipo === 'acuerdo' ? '#ffc107' : '#17a2b8'));
        const icono = entry.tipo === 'actividad' ? 'fa-check-circle' : (entry.tipo === 'incidencia' ? 'fa-exclamation-triangle' : (entry.tipo === 'acuerdo' ? 'fa-handshake' : 'fa-sticky-note'));
        
        html += `
            <div class="timeline-item" data-id="${entry.id}">
                <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; z-index: 2;">
                    <i class="fas ${icono}"></i>
                </div>
                <div style="margin-left: 20px; background-color: ${entry.tipo === 'incidencia' ? '#fff3cd' : 'white'}; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                            <span style="background-color: ${color}; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">${escapeHtml(entry.proyecto_id)}</span>
                            <span style="color: #6c757d; font-size: 13px;"><i class="far fa-calendar"></i> ${formatDate(entry.fecha)}</span>
                            <span style="color: #6c757d; font-size: 13px;"><i class="far fa-clock"></i> ${entry.hora}</span>
                            <span style="color: #6c757d; font-size: 13px;"><i class="fas fa-user"></i> ${escapeHtml(entry.responsable)}</span>
                        </div>
                        <span class="badge badge-${entry.tipo}">${entry.tipo}</span>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: ${color}; margin: 0 0 10px 0;">${escapeHtml(entry.titulo)}</h4>
                    <p style="font-size: 14px; color: #495057; line-height: 1.6; margin-bottom: 15px;">${escapeHtml(entry.descripcion)}</p>
                    <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                        ${entry.personal ? `<div style="font-size: 13px;"><strong>Personal:</strong> ${escapeHtml(entry.personal)}</div>` : ''}
                        ${entry.maquinaria ? `<div style="font-size: 13px;"><strong>Maquinaria:</strong> ${escapeHtml(entry.maquinaria)}</div>` : ''}
                        ${entry.materiales ? `<div style="font-size: 13px;"><strong>Material:</strong> ${escapeHtml(entry.materiales)}</div>` : ''}
                    </div>
                    <div style="display: flex; gap: 15px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        <button class="btn-accion" onclick="editarEntrada(${entry.id})" style="color: #083CAE;"><i class="fas fa-edit"></i> Editar</button>
                        ${entry.tipo === 'incidencia' ? `<button class="btn-accion" onclick="resolverIncidencia(${entry.id})" style="color: #28a745;"><i class="fas fa-check-circle"></i> Resolver</button>` : ''}
                        <button class="btn-accion" onclick="eliminarEntrada(${entry.id})" style="color: #dc3545;"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </div>
                    <div style="margin-top: 15px; background-color: #f8f9fa; border-radius: 4px; padding: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-comment" style="color: #6c757d;"></i>
                            <span style="font-weight: 600; font-size: 13px;">Comentarios (${entry.comentarios?.length || 0})</span>
                        </div>
                        <div id="comentarios-${entry.id}" style="margin-left: 25px;">
                            ${renderizarComentarios(entry.comentarios)}
                        </div>
                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <input type="text" id="comentario-${entry.id}" class="form-control" placeholder="Escribe un comentario..." style="flex: 1; padding: 5px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px;">
                            <button class="btn-comentar" onclick="agregarComentario(${entry.id})" style="background-color: #083CAE; color: white; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer;">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    $('#entries-container').html(html);
}

function renderizarComentarios(comentarios) {
    if (!comentarios || comentarios.length === 0) return '<p class="text-muted" style="font-size: 12px;">No hay comentarios</p>';
    return comentarios.map(c => `
        <div style="margin-bottom: 8px;">
            <span style="font-weight: 600; font-size: 12px;">${escapeHtml(c.usuario?.name || 'Usuario')}:</span>
            <span style="font-size: 12px; color: #495057;"> ${escapeHtml(c.comentario)}</span>
            <span style="font-size: 11px; color: #6c757d; margin-left: 10px;">${formatDateTime(c.created_at)}</span>
        </div>
    `).join('');
}

function renderizarPaginacion(data) {
    if (data.last_page <= 1) {
        $('#pagination-container').empty();
        return;
    }
    
    let html = '<div style="display: flex; gap: 5px; align-items: center;">';
    html += `<button class="pagination-btn" onclick="cambiarPagina(${data.current_page - 1})" ${data.current_page === 1 ? 'disabled' : ''} style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;"><i class="fas fa-chevron-left"></i></button>`;
    
    for (let i = 1; i <= data.last_page; i++) {
        if (i === 1 || i === data.last_page || (i >= data.current_page - 2 && i <= data.current_page + 2)) {
            html += `<button class="pagination-btn" onclick="cambiarPagina(${i})" style="padding: 5px 10px; background-color: ${i === data.current_page ? '#083CAE' : 'white'}; color: ${i === data.current_page ? 'white' : '#495057'}; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">${i}</button>`;
        } else if (i === data.current_page - 3 || i === data.current_page + 3) {
            html += '<span style="padding: 5px;">...</span>';
        }
    }
    
    html += `<button class="pagination-btn" onclick="cambiarPagina(${data.current_page + 1})" ${data.current_page === data.last_page ? 'disabled' : ''} style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;"><i class="fas fa-chevron-right"></i></button>`;
    html += `<span style="color: #6c757d; font-size: 13px; margin-left: 15px;">Mostrando ${((data.current_page - 1) * data.per_page) + 1} - ${Math.min(data.current_page * data.per_page, data.total)} de ${data.total} entradas</span>`;
    html += '</div>';
    
    $('#pagination-container').html(html);
}

function cambiarPagina(page) {
    if (page < 1) return;
    currentPage = page;
    cargarEntradas();
}

function cargarIncidencias() {
    $.ajax({
        url: '/api/bitacora/incidencias',
        method: 'GET',
        data: { proyecto_id: $('#selectorProyecto').val() },
        success: function(response) {
            if (response.success && response.data) {
                renderizarIncidencias(response.data);
            }
        }
    });
}

function renderizarIncidencias(incidencias) {
    if (!incidencias || incidencias.length === 0) {
        $('#incidencias-table-body').html('<tr><td colspan="8" class="text-center">No hay incidencias registradas</td></tr>');
        return;
    }
    
    let html = '';
    incidencias.forEach(inc => {
        const prioridadColor = inc.prioridad === 'critica' ? '#dc3545' : (inc.prioridad === 'alta' ? '#fd7e14' : (inc.prioridad === 'media' ? '#ffc107' : '#28a745'));
        html += `<tr style="border-bottom: 1px solid #dee2e6;">
            <td style="padding: 12px;"><strong>${escapeHtml(inc.codigo)}</strong></td>
            <td style="padding: 12px;">${escapeHtml(inc.bitacora_entry?.proyecto_id || '-')}</td>
            <td style="padding: 12px;">${formatDate(inc.created_at)}</td>
            <td style="padding: 12px;">${escapeHtml(inc.tipo_incidencia)}</td>
            <td style="padding: 12px;">${escapeHtml(inc.bitacora_entry?.titulo || '-')}</td>
            <td style="padding: 12px;"><span style="background-color: ${prioridadColor}; color: white; padding: 4px 8px; border-radius: 4px;">${inc.prioridad}</span></td>
            <td style="padding: 12px;"><span style="background-color: ${inc.resuelta_en ? '#28a745' : '#ffc107'}; color: ${inc.resuelta_en ? 'white' : '#856404'}; padding: 4px 8px; border-radius: 4px;">${inc.resuelta_en ? 'Resuelta' : 'Pendiente'}</span></td>
            <td style="padding: 12px;">
                <i class="fas fa-eye btn-accion" onclick="verDetalleIncidencia(${inc.id})" style="color: #083CAE; margin: 0 5px;"></i>
                ${!inc.resuelta_en ? `<i class="fas fa-check-circle btn-accion" onclick="resolverIncidencia(${inc.bitacora_entry_id})" style="color: #28a745; margin: 0 5px;"></i>` : ''}
            </td>
        </tr>`;
    });
    $('#incidencias-table-body').html(html);
}

function cargarEvidencias() {
    $.ajax({
        url: '/api/bitacora/evidencias',
        method: 'GET',
        data: { proyecto_id: $('#galeriaFiltroProyecto').val() },
        success: function(response) {
            if (response.success && response.data) {
                renderizarEvidencias(response.data);
            }
        }
    });
}

function renderizarEvidencias(evidencias) {
    if (!evidencias || evidencias.length === 0) {
        $('#galeria-container').html('<div class="text-center py-5"><i class="fas fa-images fa-3x text-muted"></i><p class="mt-2">No hay evidencias fotográficas</p></div>');
        return;
    }
    
    let html = '';
    evidencias.forEach(ev => {
        const imageUrl = ev.url ? ev.url : '/storage/' + ev.ruta;
        html += `<div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white;">
            <div style="height: 150px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="verImagen('${imageUrl}')">
                <img src="${imageUrl}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://placehold.co/200x150?text=Sin+Imagen'">
            </div>
            <div style="padding: 10px;">
                <div style="font-weight: 600; font-size: 13px;">${escapeHtml(ev.nombre_original)}</div>
                <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">${formatDate(ev.created_at)}</div>
                <div style="display: flex; gap: 10px;">
                    <i class="fas fa-eye btn-accion" onclick="verImagen('${imageUrl}')" style="color: #083CAE;"></i>
                    <i class="fas fa-download btn-accion" onclick="descargarImagen('${imageUrl}', '${ev.nombre_original}')" style="color: #28a745;"></i>
                    <i class="fas fa-trash btn-accion" onclick="eliminarImagen(${ev.id})" style="color: #dc3545;"></i>
                </div>
            </div>
        </div>`;
    });
    $('#galeria-container').html(html);
}

function cargarEstadisticas() {
    $.ajax({
        url: '/api/bitacora/estadisticas',
        method: 'GET',
        data: {
            proyecto_id: $('#selectorProyecto').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val()
        },
        success: function(response) {
            if (response.success && response.data) {
                $('.total-entradas').text(response.data.total || 0);
                $('.total-actividades').text(response.data.actividades || 0);
                $('.total-incidencias').text(response.data.incidencias || 0);
                $('.total-pendientes').text(response.data.pendientes || 0);
            }
        }
    });
}

function cargarGraficos() {
    $.ajax({
        url: '/api/bitacora/estadisticas',
        method: 'GET',
        data: {
            proyecto_id: $('#selectorProyecto').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val()
        },
        success: function(response) {
            if (response.success && response.data) {
                const porProyecto = response.data.por_proyecto || [];
                const proyectos = porProyecto.map(p => p.proyecto_id);
                const totales = porProyecto.map(p => p.total);
                
                if (window.actividadesChart) window.actividadesChart.destroy();
                if (window.incidenciasChart) window.incidenciasChart.destroy();
                
                const ctx1 = document.getElementById('actividadesChart').getContext('2d');
                window.actividadesChart = new Chart(ctx1, {
                    type: 'pie',
                    data: { labels: proyectos, datasets: [{ data: totales, backgroundColor: ['#083CAE', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d'] }] }
                });
                
                if (window.evolucionChart) window.evolucionChart.destroy();
                const ctx3 = document.getElementById('evolucionChart').getContext('2d');
                window.evolucionChart = new Chart(ctx3, {
                    type: 'line',
                    data: { labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'], datasets: [{ label: 'Actividades', data: [12, 19, 15, 17, 14, 18], borderColor: '#083CAE', tension: 0.4 }] }
                });
            }
        }
    });
}

function agregarComentario(entryId) {
    const comentario = $(`#comentario-${entryId}`).val();
    if (!comentario.trim()) return;
    
    $.ajax({
        url: `/api/bitacora/entries/${entryId}/comments`,
        method: 'POST',
        data: { comentario: comentario },
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function() {
            $(`#comentario-${entryId}`).val('');
            cargarEntradas();
        },
        error: function() {
            alert('Error al agregar comentario');
        }
    });
}

function eliminarEntrada(id) {
    if (!confirm('¿Estás seguro de eliminar esta entrada?')) return;
    
    $.ajax({
        url: `/api/bitacora/entries/${id}`,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function() {
            cargarEntradas();
            cargarEstadisticas();
        },
        error: function() {
            alert('Error al eliminar la entrada');
        }
    });
}

function resolverIncidencia(entryId) {
    const accion = prompt('Describa la acción tomada para resolver esta incidencia:');
    if (!accion) return;
    
    $.ajax({
        url: `/api/bitacora/incidencias/${entryId}/resolve`,
        method: 'PUT',
        data: { accion_tomada: accion },
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function() {
            cargarEntradas();
            cargarIncidencias();
            cargarEstadisticas();
        },
        error: function() {
            alert('Error al resolver la incidencia');
        }
    });
}

function verImagen(url) {
    $('#modalImagenSrc').attr('src', url);
    $('#modalImagen').show();
}

function descargarImagen(url, nombre) {
    const link = document.createElement('a');
    link.href = url;
    link.download = nombre;
    link.click();
}

function eliminarImagen(id) {
    if (!confirm('¿Eliminar esta imagen?')) return;
    
    $.ajax({
        url: `/api/bitacora/images/${id}`,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function() {
            cargarEvidencias();
        },
        error: function() {
            alert('Error al eliminar la imagen');
        }
    });
}

function verDetalleIncidencia(id) {
    alert('Detalles de incidencia - Funcionalidad en desarrollo');
}

function editarEntrada(id) {
    alert('Editar entrada - Funcionalidad en desarrollo');
}

function formatDate(date) {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleDateString('es-ES');
}

function formatDateTime(date) {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleString('es-ES');
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => { clearTimeout(timeout); func(...args); };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection