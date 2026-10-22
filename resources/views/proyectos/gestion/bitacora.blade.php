@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-book"></i> Bitácora de Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y controles -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorProyecto" class="form-select" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 250px;">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto['id'] }}">{{ $proyecto['id'] }} - {{ $proyecto['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

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
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <input type="date" id="fechaInicio" value="{{ date('Y-m-01') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="{{ date('Y-m-t') }}" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>

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

                <!-- Resumen -->
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

                <!-- Tabs -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE;">
                    <button class="bitacora-tab active" data-tab="registros" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Registros
                    </button>
                    <button class="bitacora-tab" data-tab="incidencias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-exclamation-circle"></i> Incidencias
                    </button>
                    <button class="bitacora-tab" data-tab="fotografias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-camera"></i> Evidencia
                    </button>
                    <button class="bitacora-tab" data-tab="reportes" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-bar"></i> Reportes
                    </button>
                </div>

                <!-- REGISTROS -->
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

                    <div id="bitacora-timeline" class="timeline" style="position: relative; padding-left: 30px;">
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>
                        <div id="entries-loading" class="text-center py-5" style="display: none;">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p>Cargando entradas...</p>
                        </div>
                        <div id="entries-container"></div>
                    </div>

                    <div id="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;"></div>
                </div>

                <!-- INCIDENCIAS -->
                <div id="tab-incidencias" class="bitacora-content" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #083CAE; font-size: 18px; margin: 0;">
                            <i class="fas fa-exclamation-triangle"></i> Incidencias Reportadas
                        </h3>
                        <button id="btnRefrescarIncidencias" style="padding: 8px 15px; background: white; border: 1px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-size: 13px;">
                            <i class="fas fa-sync"></i> Refrescar
                        </button>
                    </div>

                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1000px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dc3545;">
                                <tr>
                                    <th style="padding: 12px;">Código</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="incidencias-table-body">
                                <tr><td colspan="8" class="text-center">Cargando incidencias...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOTOGRAFÍAS -->
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

                <!-- REPORTES -->
                <div id="tab-reportes" class="bitacora-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 20px;">
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #083CAE; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Total Entradas</div>
                            <div id="repKpiTotal" style="font-size: 26px; font-weight: bold; color: #083CAE;">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #28a745; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Actividades</div>
                            <div id="repKpiActividades" style="font-size: 26px; font-weight: bold; color: #28a745;">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #dc3545; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Incidencias Abiertas</div>
                            <div id="repKpiIncAbiertas" style="font-size: 26px; font-weight: bold; color: #dc3545;">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #17a2b8; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Comentarios</div>
                            <div id="repKpiComentarios" style="font-size: 26px; font-weight: bold; color: #17a2b8;">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #fd7e14; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Imágenes</div>
                            <div id="repKpiImagenes" style="font-size: 26px; font-weight: bold; color: #fd7e14;">0</div>
                        </div>
                        <div style="background: white; border: 1px solid #e9ecef; border-left: 4px solid #6c757d; border-radius: 6px; padding: 15px;">
                            <div style="color: #6c757d; font-size: 12px;">Reportes Generados</div>
                            <div id="repKpiReportes" style="font-size: 26px; font-weight: bold; color: #6c757d;">0</div>
                        </div>
                    </div>

                    <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; align-items: end;">
                        <div>
                            <label style="font-size: 12px; color: #6c757d; display: block;">Tipo</label>
                            <select id="repTipo" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                <option value="diario">Diario</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual" selected>Mensual</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 12px; color: #6c757d; display: block;">Desde</label>
                            <input type="date" id="repFechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="font-size: 12px; color: #6c757d; display: block;">Hasta</label>
                            <input type="date" id="repFechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                        <button id="btnGenerarReporte" style="padding: 8px 16px; background: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-plus"></i> Generar reporte
                        </button>
                        <button id="btnImprimirReporte" style="padding: 8px 16px; background: white; color: #083CAE; border: 1px solid #083CAE; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0;"><i class="fas fa-chart-pie"></i> Registros por Tipo</h4>
                            <div style="position: relative; height: 220px;">
                                <canvas id="actividadesChart"></canvas>
                            </div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #dc3545; margin: 0 0 15px 0;"><i class="fas fa-chart-bar"></i> Incidencias por Estado</h4>
                            <div style="position: relative; height: 220px;">
                                <canvas id="incidenciasChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0;"><i class="fas fa-file-alt"></i> Reportes Generados</h4>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Título</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Tipo</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Desde</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Hasta</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Generado por</th>
                                        <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaReportesBody">
                                    <tr><td colspan="6" style="padding: 20px; text-align: center; color: #adb5bd;">Cargando reportes...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================== MODAL NUEVA ENTRADA ========================== -->
<div id="modalNuevaEntrada" class="bitacora-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <form id="formNuevaEntrada" enctype="multipart/form-data" onsubmit="return false;">
            <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nueva Entrada de Bitácora</h3>
                <button type="button" class="btn-cerrar-modal" data-modal="modalNuevaEntrada" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #6c757d; line-height: 1;">&times;</button>
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
                        <input type="text" name="responsable" value="{{ auth()->user()->name ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
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
                <button type="button" class="btn-cerrar-modal" data-modal="modalNuevaEntrada" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" id="btnGuardarEntrada" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Entrada</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================== MODAL RESOLVER INCIDENCIA ========================== -->
<div id="modalResolverIncidencia" class="bitacora-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1002; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 550px;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: #28a745; border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-check-circle"></i> Resolver Incidencia</h3>
            <button type="button" class="btn-cerrar-modal" data-modal="modalResolverIncidencia" style="background: none; border: none; font-size: 24px; cursor: pointer; color: white; line-height: 1;">&times;</button>
        </div>

        <div style="padding: 20px;">
            <input type="hidden" id="resolverIncidenciaId">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Acción tomada <span style="color: #dc3545;">*</span> <small style="color:#6c757d;">(mín. 5 caracteres)</small></label>
                <textarea id="resolverAccion" rows="4" minlength="5" placeholder="Describe la acción realizada para resolver la incidencia..." style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; font-family: inherit; resize: vertical;"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Evidencias de la resolución (opcional)</label>
                <input type="file" id="resolverEvidencias" multiple accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 6px;">
            </div>
        </div>

        <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" class="btn-cerrar-modal" data-modal="modalResolverIncidencia" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button type="button" id="btnConfirmarResolver" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                <i class="fas fa-check"></i> Resolver
            </button>
        </div>
    </div>
</div>

<!-- ========================== MODAL VER DETALLE ========================== -->
<div id="modalDetalle" class="bitacora-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1003; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: #083CAE; border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-eye"></i> Detalle de la entrada</h3>
            <button type="button" class="btn-cerrar-modal" data-modal="modalDetalle" style="background: none; border: none; font-size: 24px; cursor: pointer; color: white; line-height: 1;">&times;</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;"></div>
    </div>
</div>

<!-- ========================== MODAL EDITAR ENTRADA ========================== -->
<div id="modalEditarEntrada" class="bitacora-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1004; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <form id="formEditarEntrada" onsubmit="return false;">
            <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: #ffc107; border-radius: 8px 8px 0 0;">
                <h3 style="margin: 0; color: #000;"><i class="fas fa-edit"></i> Editar Entrada</h3>
                <button type="button" class="btn-cerrar-modal" data-modal="modalEditarEntrada" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #000; line-height: 1;">&times;</button>
            </div>
            <div style="padding: 20px;">
                <input type="hidden" id="editId">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título *</label>
                    <input type="text" id="editTitulo" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estado *</label>
                    <select id="editEstado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="pendiente">Pendiente</option>
                        <option value="en_proceso">En proceso</option>
                        <option value="completado">Completado</option>
                        <option value="cerrado">Cerrado</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción *</label>
                    <textarea id="editDescripcion" rows="4" required style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"></textarea>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Personal</label>
                        <input type="text" id="editPersonal" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Maquinaria</label>
                        <input type="text" id="editMaquinaria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Materiales</label>
                        <input type="text" id="editMateriales" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                </div>
            </div>
            <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-cerrar-modal" data-modal="modalEditarEntrada" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" id="btnGuardarEdicion" style="padding: 10px 20px; background-color: #ffc107; color: #000; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal ver imagen -->
<div id="modalImagen" class="bitacora-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); z-index: 1005; align-items: center; justify-content: center;">
    <span id="cerrarModalImagen" style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; cursor: pointer; line-height: 1;">&times;</span>
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

    /* ✨ FIX: botones de cerrar modal con hover claro */
    .btn-cerrar-modal:hover { opacity: 0.7; }

    /* ✨ Toast */
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }
    .bitacora-toast {
        position: fixed; top: 20px; right: 20px; z-index: 99999;
        padding: 14px 22px; border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.18);
        font-size: 14px; font-weight: 500; color: white;
        display: flex; align-items: center; gap: 10px;
        animation: slideIn 0.3s ease-out;
        max-width: 400px;
    }
    .bitacora-toast.success { background: #28a745; }
    .bitacora-toast.error   { background: #dc3545; }
    .bitacora-toast.info    { background: #17a2b8; }

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
// ============================================================
// UTILIDADES
// ============================================================
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

function mostrarToast(msg, tipo = 'success', duracion = 2800) {
    const div = document.createElement('div');
    div.className = `bitacora-toast ${tipo}`;
    const iconos = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle' };
    div.innerHTML = `<i class="fas ${iconos[tipo] || iconos.info}"></i><span>${escapeHtml(msg)}</span>`;
    document.body.appendChild(div);
    setTimeout(() => {
        div.style.opacity = '0';
        div.style.transition = 'opacity 0.3s';
        setTimeout(() => div.remove(), 300);
    }, duracion);
}

// ✨ Helper para abrir/cerrar modales
function abrirModal(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'flex';
}
function cerrarModal(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
}
function cerrarTodosLosModales() {
    document.querySelectorAll('.bitacora-modal').forEach(m => m.style.display = 'none');
}

// ============================================================
// VARIABLES GLOBALES
// ============================================================
let currentPage = 1;
let currentFilters = {};

$(document).ready(function() {
    cargarEntradas();
    cargarIncidencias();
    cargarEvidencias();
    cargarEstadisticas();

    // ✨ FIX: Delegación de eventos para todos los botones "X" y "Cancelar"
    $(document).on('click', '.btn-cerrar-modal', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const modalId = $(this).data('modal');
        if (modalId) cerrarModal(modalId);
    });

    // ✨ FIX: Cerrar modal al hacer clic en el overlay (fondo oscuro)
    $(document).on('click', '.bitacora-modal', function(e) {
        if (e.target === this) {
            cerrarModal(this.id);
        }
    });

    // ✨ FIX: Cerrar modal con tecla ESC
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            cerrarTodosLosModales();
        }
    });

    // Modal imagen: cerrar con X
    $('#cerrarModalImagen').on('click', function(e) {
        e.stopPropagation();
        cerrarModal('modalImagen');
    });

    // Mostrar/ocultar campos de incidencia
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
        if (tab === 'reportes')    { cargarReportes(); cargarResumenReportes(); cargarGraficos(); }
        if (tab === 'incidencias') cargarIncidencias();
        if (tab === 'fotografias') cargarEvidencias();
    });

    // ==========================================================
    // NUEVA ENTRADA
    // ==========================================================
    $('#btnNuevaEntrada').on('click', () => abrirModal('modalNuevaEntrada'));

    $('#formNuevaEntrada').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const btn = $('#btnGuardarEntrada');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '/api/bitacora/entries',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            success: function(response) {
                if (response.success) {
                    mostrarToast('Entrada creada exitosamente', 'success');
                    cerrarModal('modalNuevaEntrada');
                    $('#formNuevaEntrada')[0].reset();
                    cargarEntradas();
                    cargarEstadisticas();
                } else {
                    mostrarToast(response.message || 'Error al crear la entrada', 'error');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) mostrarToast(Object.values(errors).flat().join(' | '), 'error', 5000);
                else mostrarToast(xhr.responseJSON?.message || 'Error al crear la entrada', 'error', 5000);
            },
            complete: function() {
                btn.prop('disabled', false).html('Guardar Entrada');
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

    // ==========================================================
    // RESOLVER INCIDENCIA
    // ==========================================================
    $('#btnConfirmarResolver').on('click', function() {
        const id = $('#resolverIncidenciaId').val();
        const accion = $('#resolverAccion').val().trim();
        const files = document.getElementById('resolverEvidencias').files;

        if (!id) {
            mostrarToast('No se pudo identificar la incidencia', 'error');
            return;
        }
        if (accion.length < 5) {
            mostrarToast('La acción tomada debe tener al menos 5 caracteres.', 'error');
            $('#resolverAccion').focus();
            return;
        }

        const fd = new FormData();
        fd.append('accion_tomada', accion);
        for (let i = 0; i < files.length; i++) {
            fd.append('evidencias[]', files[i]);
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: `/api/bitacora/incidencias/${id}/resolve`,
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            success: function(response) {
                if (response.success) {
                    cerrarModal('modalResolverIncidencia');
                    mostrarToast('Incidencia resuelta correctamente', 'success');
                    cargarEntradas();
                    cargarIncidencias();
                    cargarEstadisticas();
                } else {
                    mostrarToast(response.message || 'Error al resolver', 'error');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) mostrarToast(Object.values(errors).flat().join(' | '), 'error', 5000);
                else mostrarToast(xhr.responseJSON?.message || 'Error al resolver la incidencia', 'error', 5000);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fas fa-check"></i> Resolver');
            }
        });
    });

    // ==========================================================
    // EDITAR ENTRADA
    // ==========================================================
    $('#formEditarEntrada').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        const payload = {
            titulo:      $('#editTitulo').val().trim(),
            descripcion: $('#editDescripcion').val().trim(),
            estado:      $('#editEstado').val(),
            personal:    $('#editPersonal').val().trim() || null,
            maquinaria:  $('#editMaquinaria').val().trim() || null,
            materiales:  $('#editMateriales').val().trim() || null,
        };

        if (!payload.titulo || !payload.descripcion) {
            mostrarToast('Título y descripción son obligatorios', 'error');
            return;
        }

        const btn = $('#btnGuardarEdicion');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: `/api/bitacora/entries/${id}`,
            method: 'PUT',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            success: function(response) {
                if (response.success) {
                    cerrarModal('modalEditarEntrada');
                    mostrarToast('Entrada actualizada', 'success');
                    cargarEntradas();
                } else {
                    mostrarToast(response.message || 'Error al actualizar', 'error');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) mostrarToast(Object.values(errors).flat().join(' | '), 'error', 5000);
                else mostrarToast(xhr.responseJSON?.message || 'Error al actualizar', 'error', 5000);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar cambios');
            }
        });
    });

    // ==========================================================
    // REPORTES
    // ==========================================================
    $('#btnGenerarReporte').on('click', function() {
        const tipo = $('#repTipo').val();
        const fi = $('#repFechaInicio').val();
        const ff = $('#repFechaFin').val();
        if (!fi || !ff) { mostrarToast('Selecciona el rango de fechas', 'error'); return; }

        $.ajax({
            url: '/api/bitacora/reportes/generar',
            method: 'POST',
            data: JSON.stringify({ tipo_reporte: tipo, fecha_inicio: fi, fecha_fin: ff }),
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            success: function() {
                mostrarToast('Reporte generado', 'success');
                cargarReportes();
                cargarResumenReportes();
            },
            error: function(xhr) {
                mostrarToast(xhr.responseJSON?.message || 'Error al generar reporte', 'error');
            }
        });
    });

    $('#btnImprimirReporte').on('click', function() {
        const fi = $('#repFechaInicio').val();
        const ff = $('#repFechaFin').val();
        const qs = new URLSearchParams();
        if (fi) qs.set('fecha_inicio', fi);
        if (ff) qs.set('fecha_fin', ff);
        window.open(`{{ url('/bitacora/print') }}?${qs.toString()}`, '_blank');
    });

    $('#btnRefrescarIncidencias').on('click', cargarIncidencias);
    $('#galeriaFiltroProyecto').on('change', cargarEvidencias);
});

// ============================================================
// ENTRADAS
// ============================================================
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
    $('#entries-container').html('');

    $.ajax({
        url: '/api/bitacora/entries',
        method: 'GET',
        data: { ...currentFilters, page: currentPage, per_page: 10, _t: Date.now() },
        headers: { 'Accept': 'application/json' },
        success: function(response) {
            if (response.success) {
                renderizarEntradas(response.data);
                renderizarPaginacion(response);
            } else {
                $('#entries-container').html('<div class="alert alert-danger">Error al cargar las entradas</div>');
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

        // ✨ FIX DEFINITIVO: usar incidencia_id del backend SIN fallback
        const incId = entry.incidencia_id;                  // puede ser null
        const incAbierta = entry.incidencia_abierta === true;
        const puedeResolver = entry.tipo === 'incidencia' && incId && incAbierta;

        // ✨ Mostrar aviso si es incidencia pero no se recibió incidencia_id
        const avisoSinId = (entry.tipo === 'incidencia' && !incId);

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
                            <span style="color: #6c757d; font-size: 13px;"><i class="far fa-clock"></i> ${(entry.hora || '').substring(0,5)}</span>
                            <span style="color: #6c757d; font-size: 13px;"><i class="fas fa-user"></i> ${escapeHtml(entry.responsable || '-')}</span>
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
                    <div style="display: flex; gap: 15px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6; flex-wrap: wrap;">
                        <button class="btn-accion" onclick="verDetalleEntrada(${entry.id})" style="color: #083CAE;"><i class="fas fa-eye"></i> Ver</button>
                        <button class="btn-accion" onclick="editarEntrada(${entry.id})" style="color: #ffc107;"><i class="fas fa-edit"></i> Editar</button>
                        ${puedeResolver
                            ? `<button class="btn-accion" onclick="abrirResolverIncidencia(${incId})" style="color: #28a745;"><i class="fas fa-check-circle"></i> Resolver</button>`
                            : ''}
                        ${avisoSinId
                            ? `<span style="font-size: 11px; color: #dc3545; align-self: center;"><i class="fas fa-exclamation-circle"></i> Sin ID de incidencia</span>`
                            : ''}
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

// ============================================================
// INCIDENCIAS
// ============================================================
function cargarIncidencias() {
    $.ajax({
        url: '/api/bitacora/incidencias',
        method: 'GET',
        data: { proyecto_id: $('#selectorProyecto').val(), _t: Date.now() },
        headers: { 'Accept': 'application/json' },
        success: function(response) {
            if (response.success && response.data) {
                renderizarIncidencias(response.data);
            }
        }
    });
}

function renderizarIncidencias(incidencias) {
    if (!incidencias || incidencias.length === 0) {
        $('#incidencias-table-body').html('<tr><td colspan="8" class="text-center" style="padding:20px;">No hay incidencias registradas</td></tr>');
        return;
    }

    let html = '';
    incidencias.forEach(inc => {
        const prioridadColor = inc.prioridad === 'critica' ? '#dc3545' : (inc.prioridad === 'alta' ? '#fd7e14' : (inc.prioridad === 'media' ? '#ffc107' : '#28a745'));
        html += `<tr style="border-bottom: 1px solid #dee2e6;">
            <td style="padding: 12px;"><strong>${escapeHtml(inc.codigo || ('#'+inc.id))}</strong></td>
            <td style="padding: 12px;">${escapeHtml(inc.bitacora_entry?.proyecto_id || '-')}</td>
            <td style="padding: 12px;">${formatDate(inc.created_at)}</td>
            <td style="padding: 12px;">${escapeHtml(inc.tipo_incidencia || '-')}</td>
            <td style="padding: 12px;">${escapeHtml(inc.bitacora_entry?.titulo || '-')}</td>
            <td style="padding: 12px;"><span style="background-color: ${prioridadColor}; color: white; padding: 4px 8px; border-radius: 4px;">${inc.prioridad || '-'}</span></td>
            <td style="padding: 12px;"><span style="background-color: ${inc.resuelta_en ? '#28a745' : '#ffc107'}; color: ${inc.resuelta_en ? 'white' : '#856404'}; padding: 4px 8px; border-radius: 4px;">${inc.resuelta_en ? 'Resuelta' : 'Pendiente'}</span></td>
            <td style="padding: 12px;">
                <i class="fas fa-eye btn-accion" onclick="verDetalleEntrada(${inc.bitacora_entry_id})" style="color: #083CAE; margin: 0 5px; cursor:pointer;" title="Ver detalle"></i>
                ${!inc.resuelta_en ? `<i class="fas fa-check-circle btn-accion" onclick="abrirResolverIncidencia(${inc.id})" style="color: #28a745; margin: 0 5px; cursor:pointer;" title="Resolver"></i>` : ''}
            </td>
        </tr>`;
    });
    $('#incidencias-table-body').html(html);
}

// ============================================================
// EVIDENCIAS
// ============================================================
function cargarEvidencias() {
    $.ajax({
        url: '/api/bitacora/evidencias',
        method: 'GET',
        data: { proyecto_id: $('#galeriaFiltroProyecto').val(), _t: Date.now() },
        headers: { 'Accept': 'application/json' },
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
                    <i class="fas fa-eye btn-accion" onclick="verImagen('${imageUrl}')" style="color: #083CAE; cursor:pointer;"></i>
                    <i class="fas fa-download btn-accion" onclick="descargarImagen('${imageUrl}', '${ev.nombre_original}')" style="color: #28a745; cursor:pointer;"></i>
                    <i class="fas fa-trash btn-accion" onclick="eliminarImagen(${ev.id})" style="color: #dc3545; cursor:pointer;"></i>
                </div>
            </div>
        </div>`;
    });
    $('#galeria-container').html(html);
}

// ============================================================
// ESTADÍSTICAS Y GRÁFICOS
// ============================================================
function cargarEstadisticas() {
    $.ajax({
        url: '/api/bitacora/estadisticas',
        method: 'GET',
        data: {
            proyecto_id: $('#selectorProyecto').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val()
        },
        headers: { 'Accept': 'application/json' },
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

function cargarResumenReportes() {
    $.ajax({
        url: '/api/bitacora/reportes/resumen',
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        success: function(res) {
            const d = res.data || {};
            $('#repKpiTotal').text(d.total_entradas ?? 0);
            $('#repKpiActividades').text(d.total_actividades ?? 0);
            $('#repKpiIncAbiertas').text(d.incidencias_abiertas ?? 0);
            $('#repKpiComentarios').text(d.total_comentarios ?? 0);
            $('#repKpiImagenes').text(d.total_imagenes ?? 0);
            $('#repKpiReportes').text(d.reportes_generados ?? 0);
        },
        error: function() {
            $.ajax({
                url: '/api/bitacora/estadisticas',
                method: 'GET',
                headers: { 'Accept': 'application/json' },
                success: function(r) {
                    if (r.success && r.data) {
                        $('#repKpiTotal').text(r.data.total ?? 0);
                        $('#repKpiActividades').text(r.data.actividades ?? 0);
                        $('#repKpiIncAbiertas').text(r.data.incidencias ?? 0);
                        $('#repKpiComentarios').text(0);
                        $('#repKpiImagenes').text(0);
                        $('#repKpiReportes').text(0);
                    }
                }
            });
        }
    });
}

function cargarReportes() {
    $.ajax({
        url: '/api/bitacora/reportes',
        method: 'GET',
        data: { _t: Date.now() },
        headers: { 'Accept': 'application/json' },
        success: function(res) {
            console.log('📄 Reportes response:', res);

            // ✨ El backend puede devolver:
            //   - { success: true, data: [...] }       (paginado)
            //   - { success: true, data: { data: [...] } } (Laravel paginate)
            //   - { success: true, data: [] }          (vacío)
            let items = [];
            if (Array.isArray(res.data)) {
                items = res.data;
            } else if (res.data && Array.isArray(res.data.data)) {
                items = res.data.data;
            } else if (Array.isArray(res)) {
                items = res;
            }

            const $tbody = $('#tablaReportesBody');

            if (!items.length) {
                $tbody.html('<tr><td colspan="6" style="padding:20px; text-align:center; color:#adb5bd;">No hay reportes generados todavía. Usa "Generar reporte".</td></tr>');
                return;
            }

            $tbody.html(items.map(r => `
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 10px;">${escapeHtml(r.titulo || '-')}</td>
                    <td style="padding: 10px;">${escapeHtml(r.tipo || '-')}</td>
                    <td style="padding: 10px;">${formatDate(r.fecha_inicio)}</td>
                    <td style="padding: 10px;">${formatDate(r.fecha_fin)}</td>
                    <td style="padding: 10px;">${escapeHtml(r.generador?.name || r.generador || '-')}</td>
                    <td style="padding: 10px;">${r.created_at ? formatDateTime(r.created_at) : '-'}</td>
                </tr>
            `).join(''));
        },
        error: function(xhr) {
            console.error('❌ Error cargar reportes:', xhr);
            $('#tablaReportesBody').html(`<tr><td colspan="6" style="padding:20px; text-align:center; color:#dc3545;">
                Error al cargar reportes: ${escapeHtml(xhr.responseJSON?.message || xhr.statusText || 'Error desconocido')}
            </td></tr>`);
        }
    });
}

function cargarGraficos() {
    console.log('🎨 Iniciando cargarGraficos...');

    // ✨ Verificar que Chart.js esté disponible
    if (typeof Chart === 'undefined') {
        console.error('❌ Chart.js NO está cargado. Verifica el orden de los <script>.');
        return;
    }

    $.ajax({
        url: '/api/bitacora/estadisticas',
        method: 'GET',
        data: {
            proyecto_id: $('#selectorProyecto').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val(),
            _t: Date.now()
        },
        headers: { 'Accept': 'application/json' },
        success: function(response) {
            console.log('📊 Estadísticas response:', response);

            if (!response.success || !response.data) {
                console.warn('⚠️ Sin datos para gráficos');
                return;
            }
            const d = response.data;

            // ============================================
            // 1) DOUGHNUT: Registros por tipo
            // ============================================
            const porTipo = Array.isArray(d.por_tipo) ? d.por_tipo : [];
            const labelsTipo = porTipo.map(p => p.tipo || 'N/A');
            const dataTipo = porTipo.map(p => Number(p.total) || 0);

            const canvas1 = document.getElementById('actividadesChart');
            console.log('🎯 canvas1:', canvas1, 'visible:', canvas1 ? canvas1.offsetWidth + 'x' + canvas1.offsetHeight : 'N/A');

            if (canvas1) {
                // Destruir instancia previa de forma segura
                if (window.actividadesChart && typeof window.actividadesChart.destroy === 'function') {
                    try { window.actividadesChart.destroy(); } catch (e) { console.warn('destroy actividadesChart:', e); }
                }
                window.actividadesChart = null;

                try {
                    window.actividadesChart = new Chart(canvas1.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: labelsTipo.length ? labelsTipo : ['Sin datos'],
                            datasets: [{
                                data: dataTipo.length && dataTipo.some(v => v > 0) ? dataTipo : [1],
                                backgroundColor: ['#083CAE', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            return ctx.label + ': ' + ctx.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    console.log('✅ actividadesChart creado');
                } catch (e) {
                    console.error('❌ Error creando actividadesChart:', e);
                }
            } else {
                console.error('❌ No se encontró el canvas #actividadesChart');
            }

            // ============================================
            // 2) BAR: Registros por estado
            // ============================================
            const porEstado = Array.isArray(d.por_estado) ? d.por_estado : [];
            const labelsEstado = porEstado.map(p => (p.estado || 'N/A').replace('_', ' '));
            const dataEstado = porEstado.map(p => Number(p.total) || 0);

            const canvas2 = document.getElementById('incidenciasChart');
            console.log('🎯 canvas2:', canvas2, 'visible:', canvas2 ? canvas2.offsetWidth + 'x' + canvas2.offsetHeight : 'N/A');

            if (canvas2) {
                if (window.incidenciasChart && typeof window.incidenciasChart.destroy === 'function') {
                    try { window.incidenciasChart.destroy(); } catch (e) { console.warn('destroy incidenciasChart:', e); }
                }
                window.incidenciasChart = null;

                try {
                    window.incidenciasChart = new Chart(canvas2.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labelsEstado.length ? labelsEstado : ['Sin datos'],
                            datasets: [{
                                label: 'Registros',
                                data: dataEstado.length ? dataEstado : [0],
                                backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#6c757d', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, ticks: { precision: 0, stepSize: 1 } }
                            }
                        }
                    });
                    console.log('✅ incidenciasChart creado');
                } catch (e) {
                    console.error('❌ Error creando incidenciasChart:', e);
                }
            } else {
                console.error('❌ No se encontró el canvas #incidenciasChart');
            }
        },
        error: function(xhr) {
            console.error('❌ Error cargar gráficos:', xhr.status, xhr.responseText);
        }
    });
}

// ============================================================
// ACCIONES
// ============================================================
function agregarComentario(entryId) {
    const comentario = $(`#comentario-${entryId}`).val();
    if (!comentario.trim()) return;

    $.ajax({
        url: `/api/bitacora/entries/${entryId}/comments`,
        method: 'POST',
        data: JSON.stringify({ comentario: comentario }),
        contentType: 'application/json',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        success: function() {
            $(`#comentario-${entryId}`).val('');
            cargarEntradas();
        },
        error: function() {
            mostrarToast('Error al agregar comentario', 'error');
        }
    });
}

function eliminarEntrada(id) {
    if (!confirm('¿Estás seguro de eliminar esta entrada? También se eliminarán incidencias, comentarios y evidencias.')) return;

    $.ajax({
        url: `/api/bitacora/entries/${id}`,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        success: function() {
            mostrarToast('Registro eliminado', 'success');
            cargarEntradas();
            cargarEstadisticas();
            cargarIncidencias();
        },
        error: function() {
            mostrarToast('Error al eliminar la entrada', 'error');
        }
    });
}

// ✨ Abre el modal de resolución validando que tenga ID
function abrirResolverIncidencia(incidenciaId) {
    if (!incidenciaId || incidenciaId === 'undefined' || incidenciaId === 'null' || incidenciaId === 0) {
        mostrarToast('No se pudo identificar la incidencia a resolver. Contacta al administrador.', 'error', 4000);
        console.error('❌ abrirResolverIncidencia: incidenciaId inválido', incidenciaId);
        return;
    }
    $('#resolverIncidenciaId').val(incidenciaId);
    $('#resolverAccion').val('');
    $('#resolverEvidencias').val('');
    abrirModal('modalResolverIncidencia');
}

// ✨ Ver detalle funcional
function verDetalleEntrada(entryId) {
    const $body = $('#detalleContenido');
    $body.html('<div style="text-align:center; padding:30px;"><i class="fas fa-spinner fa-spin" style="font-size:28px; color:#083CAE;"></i></div>');
    abrirModal('modalDetalle');

    $.ajax({
        url: `/api/bitacora/entries/${entryId}`,
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        success: function(res) {
            const d = res.data || {};

            let inc = null;
            if (Array.isArray(d.incidencia) && d.incidencia.length) {
                inc = d.incidencia.find(i => !i.resuelta_en) || d.incidencia[0];
            } else if (d.incidencia && typeof d.incidencia === 'object') {
                inc = d.incidencia;
            }

            const evidencias = (d.evidencias || []).map(ev => `
                <div style="display:inline-block; margin:5px;">
                    <img src="/storage/${ev.ruta}" alt="${escapeHtml(ev.nombre_original)}" style="width:120px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;" onerror="this.style.display='none'">
                </div>
            `).join('') || '<p style="color:#adb5bd;">Sin evidencias</p>';

            const comentarios = (d.comentarios || []).map(c => `
                <div style="border-left:3px solid #083CAE; padding:8px 12px; margin-bottom:8px; background:#f8f9fa; border-radius:4px;">
                    <div style="font-size:12px; color:#6c757d;">
                        <strong>${escapeHtml(c.usuario?.name || 'Usuario')}</strong> · ${formatDateTime(c.created_at)}
                    </div>
                    <div>${escapeHtml(c.comentario)}</div>
                </div>
            `).join('') || '<p style="color:#adb5bd;">Sin comentarios</p>';

            $body.html(`
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div><strong>Proyecto:</strong> ${escapeHtml(d.proyecto_id || '-')}</div>
                    <div><strong>Estado:</strong> ${escapeHtml(d.estado || '-')}</div>
                    <div><strong>Tipo:</strong> <span class="badge badge-${d.tipo}">${escapeHtml(d.tipo || '-')}</span></div>
                    <div><strong>Fecha:</strong> ${formatDate(d.fecha)} ${(d.hora || '').substring(0,5)}</div>
                    <div style="grid-column: 1 / -1;"><strong>Título:</strong> ${escapeHtml(d.titulo || '-')}</div>
                    <div style="grid-column: 1 / -1;"><strong>Descripción:</strong><br>${escapeHtml(d.descripcion || '-').replace(/\n/g,'<br>')}</div>
                    <div><strong>Responsable:</strong> ${escapeHtml(d.responsable || '-')}</div>
                    <div><strong>Personal:</strong> ${escapeHtml(d.personal || '-')}</div>
                    <div><strong>Maquinaria:</strong> ${escapeHtml(d.maquinaria || '-')}</div>
                    <div><strong>Materiales:</strong> ${escapeHtml(d.materiales || '-')}</div>

                    ${inc ? `
                    <div style="grid-column: 1 / -1; border-top:1px solid #dee2e6; padding-top:15px;">
                        <h4 style="color:#dc3545; margin:0 0 10px 0;"><i class="fas fa-exclamation-triangle"></i> Incidencia #${inc.id}</h4>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div><strong>Tipo:</strong> ${escapeHtml(inc.tipo_incidencia || '-')}</div>
                            <div><strong>Prioridad:</strong> ${escapeHtml(inc.prioridad || '-')}</div>
                            <div style="grid-column: 1 / -1;"><strong>Resuelta:</strong> ${inc.resuelta_en ? '✅ '+formatDateTime(inc.resuelta_en) : '❌ Pendiente'}</div>
                            <div style="grid-column: 1 / -1;"><strong>Acción tomada:</strong><br>${escapeHtml(inc.accion_tomada || '-')}</div>
                        </div>
                    </div>` : ''}

                    <div style="grid-column: 1 / -1; border-top:1px solid #dee2e6; padding-top:15px;">
                        <h4 style="color:#083CAE; margin:0 0 10px 0;"><i class="fas fa-images"></i> Evidencias</h4>
                        <div>${evidencias}</div>
                    </div>

                    <div style="grid-column: 1 / -1; border-top:1px solid #dee2e6; padding-top:15px;">
                        <h4 style="color:#083CAE; margin:0 0 10px 0;"><i class="fas fa-comments"></i> Comentarios</h4>
                        <div>${comentarios}</div>
                    </div>
                </div>
            `);
        },
        error: function(xhr) {
            $body.html(`<div style="padding:20px; background:#f8d7da; color:#721c24; border-radius:6px;">
                <i class="fas fa-exclamation-triangle"></i> No se pudo cargar el detalle: ${escapeHtml(xhr.responseJSON?.message || 'Error')}
            </div>`);
        }
    });
}

// ✨ Editar entrada funcional
function editarEntrada(id) {
    $.ajax({
        url: `/api/bitacora/entries/${id}`,
        method: 'GET',
        headers: { 'Accept': 'application/json' },
        success: function(res) {
            const d = res.data || {};
            $('#editId').val(d.id);
            $('#editTitulo').val(d.titulo || '');
            $('#editDescripcion').val(d.descripcion || '');
            $('#editEstado').val(d.estado || 'pendiente');
            $('#editPersonal').val(d.personal || '');
            $('#editMaquinaria').val(d.maquinaria || '');
            $('#editMateriales').val(d.materiales || '');
            abrirModal('modalEditarEntrada');
        },
        error: function() {
            mostrarToast('Error al cargar la entrada', 'error');
        }
    });
}

function verImagen(url) {
    $('#modalImagenSrc').attr('src', url);
    abrirModal('modalImagen');
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
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        success: function() {
            mostrarToast('Imagen eliminada', 'success');
            cargarEvidencias();
        },
        error: function() {
            mostrarToast('Error al eliminar la imagen', 'error');
        }
    });
}

// ============================================================
// UTILIDADES
// ============================================================
function formatDate(date) {
    if (!date) return '-';
    try {
        const d = new Date(date + (date.length === 10 ? 'T00:00:00' : ''));
        return d.toLocaleDateString('es-MX');
    } catch { return date; }
}

function formatDateTime(date) {
    if (!date) return '-';
    try { return new Date(date).toLocaleString('es-MX'); }
    catch { return date; }
}

function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = String(text);
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