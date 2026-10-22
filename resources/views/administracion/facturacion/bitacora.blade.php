@extends('layouts.navigation')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Bitácora -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Bitácora
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="bitacoraTabs" role="tablist" style="border-bottom: 2px solid #2378e1;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-registros" data-bs-toggle="tab" data-bs-target="#panel-registros" type="button" role="tab"
                            style="color:#2378e1; font-weight:600; border:none; border-bottom:3px solid #2378e1;">
                            <i class="fas fa-clipboard-list"></i> Registros
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-incidencias" data-bs-toggle="tab" data-bs-target="#panel-incidencias" type="button" role="tab"
                            style="color:#6c757d; font-weight:600; border:none;">
                            <i class="fas fa-exclamation-triangle"></i> Incidencias
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-reportes" data-bs-toggle="tab" data-bs-target="#panel-reportes" type="button" role="tab"
                            style="color:#6c757d; font-weight:600; border:none;">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- ================= TAB REGISTROS ================= -->
                    <div class="tab-pane fade show active" id="panel-registros" role="tabpanel">
                        <!-- Barra de herramientas -->
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                                <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                                <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                                <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                <div>
                                    <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                                </div>
                                <div>
                                    <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                                </div>
                                <div>
                                    <select id="filtroTipo" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                        <option value="">Todos los tipos</option>
                                        <option value="actividad">Actividad</option>
                                        <option value="incidencia">Incidencia</option>
                                        <option value="acuerdo">Acuerdo</option>
                                        <option value="nota">Nota</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="filtroEstado" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="en_proceso">En proceso</option>
                                        <option value="completado">Completado</option>
                                        <option value="cerrado">Cerrado</option>
                                    </select>
                                </div>
                                <div>
                                    <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar">
                                        <i class="fas fa-plus" style="color: #083CAE;"></i>
                                    </button>
                                </div>
                                <div>
                                    <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar">
                                        <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                    </button>
                                </div>
                                <div style="position: relative;">
                                    <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                                    <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Mensaje Sin datos -->
                        <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0;" id="sinDatosMensaje">
                            <i class="fas fa-clipboard-list" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                            <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                            <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                        </div>

                        <!-- Loader -->
                        <div id="loaderRegistros" style="display:none; text-align:center; padding:30px;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px; color:#2378e1;"></i>
                            <p style="color:#6c757d; margin-top:10px;">Cargando registros...</p>
                        </div>

                        <!-- Tabla -->
                        <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: none;" id="tablaContainer">
                            <table class="table table-bordered" id="tablaBitacora" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                                <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                    <tr>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="estado">Estado</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="fecha">Fecha</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="hora">Hora</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="tipo">Tipo</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="titulo">Título</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="descripcion">Descripción</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;" draggable="true" data-columna="responsable">Responsable</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white;">Evidencias</th>
                                        <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaBody"></tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <span style="color:#2378e1; font-size:14px;" id="paginacionInfo">Mostrando 0-0 de 0 registros</span>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <button id="btnPagAnt" style="padding: 5px 10px; border: none; background: none; color: #2378e1; cursor:pointer;"><i class="fas fa-angle-left"></i></button>
                                <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                                <button id="btnPagSig" style="padding: 5px 10px; border: none; background: none; color: #2378e1; cursor:pointer;"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB INCIDENCIAS ================= -->
                    <div class="tab-pane fade" id="panel-incidencias" role="tabpanel">
                        <div style="margin-bottom:15px; display:flex; gap:10px; flex-wrap:wrap;">
                            <select id="filtroIncidenciaEstado" style="padding:6px 10px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Todas</option>
                                <option value="abierta">Abiertas</option>
                                <option value="resuelta">Resueltas</option>
                            </select>
                            <select id="filtroIncidenciaPrioridad" style="padding:6px 10px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Todas las prioridades</option>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                                <option value="critica">Crítica</option>
                            </select>
                            <button id="btnRefrescarIncidencias" style="padding:6px 12px; border:1px solid #2378e1; background:white; color:#2378e1; border-radius:4px; cursor:pointer;">
                                <i class="fas fa-sync"></i> Refrescar
                            </button>
                        </div>

                        <div id="loaderIncidencias" style="display:none; text-align:center; padding:30px;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 32px; color:#2378e1;"></i>
                        </div>
                        <div id="incidenciasVacias" style="text-align:center; padding:40px; color:#adb5bd; display:none;">
                            <i class="fas fa-check-circle" style="font-size:48px; color:#ced4da;"></i>
                            <p>No hay incidencias registradas</p>
                        </div>

                        <div id="tablaIncidenciasContainer" class="table-responsive" style="border:1px solid #dee2e6; border-radius:8px;">
                            <table class="table table-bordered" style="width:100%; font-size:13px; margin-bottom:0;">
                                <thead style="background-color:#2378e1; color:white;">
                                    <tr>
                                        <th style="padding:10px;">Fecha</th>
                                        <th style="padding:10px;">Proyecto</th>
                                        <th style="padding:10px;">Título</th>
                                        <th style="padding:10px;">Tipo</th>
                                        <th style="padding:10px;">Prioridad</th>
                                        <th style="padding:10px;">Estatus</th>
                                        <th style="padding:10px;">Acción tomada</th>
                                        <th style="padding:10px; text-align:center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaIncidenciasBody"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ================= TAB REPORTES ================= -->
                    <div class="tab-pane fade" id="panel-reportes" role="tabpanel">
                        <!-- KPIs -->
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:15px; margin-bottom:20px;">
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #2378e1; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Total Entradas</div>
                                <div id="kpiTotalEntradas" style="font-size:26px; font-weight:bold; color:#083CAE;">0</div>
                            </div>
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #28a745; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Actividades</div>
                                <div id="kpiActividades" style="font-size:26px; font-weight:bold; color:#28a745;">0</div>
                            </div>
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #dc3545; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Incidencias Abiertas</div>
                                <div id="kpiIncidenciasAbiertas" style="font-size:26px; font-weight:bold; color:#dc3545;">0</div>
                            </div>
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #17a2b8; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Comentarios</div>
                                <div id="kpiComentarios" style="font-size:26px; font-weight:bold; color:#17a2b8;">0</div>
                            </div>
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #fd7e14; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Imágenes</div>
                                <div id="kpiImagenes" style="font-size:26px; font-weight:bold; color:#fd7e14;">0</div>
                            </div>
                            <div style="background:white; border:1px solid #e9ecef; border-left:4px solid #6c757d; border-radius:6px; padding:15px;">
                                <div style="color:#6c757d; font-size:12px;">Reportes Generados</div>
                                <div id="kpiReportesGen" style="font-size:26px; font-weight:bold; color:#6c757d;">0</div>
                            </div>
                        </div>

                        <!-- Filtros y generar reporte -->
                        <div style="background:#f8f9fa; border-radius:8px; padding:15px; margin-bottom:15px; display:flex; gap:10px; flex-wrap:wrap; align-items:end;">
                            <div>
                                <label style="font-size:12px; color:#6c757d;">Tipo</label>
                                <select id="repTipo" style="display:block; padding:6px 10px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="diario">Diario</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="mensual" selected>Mensual</option>
                                    <option value="personalizado">Personalizado</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:12px; color:#6c757d;">Desde</label>
                                <input type="date" id="repFechaInicio" style="display:block; padding:6px 10px; border:1px solid #ced4da; border-radius:4px;">
                            </div>
                            <div>
                                <label style="font-size:12px; color:#6c757d;">Hasta</label>
                                <input type="date" id="repFechaFin" style="display:block; padding:6px 10px; border:1px solid #ced4da; border-radius:4px;">
                            </div>
                            <button id="btnGenerarReporte" style="padding:8px 16px; background:#2378e1; color:white; border:none; border-radius:4px; cursor:pointer;">
                                <i class="fas fa-plus"></i> Generar reporte
                            </button>
                            <button id="btnExportarReporte" style="padding:8px 16px; background:white; color:#2378e1; border:1px solid #2378e1; border-radius:4px; cursor:pointer;">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>

                        <div id="loaderReportes" style="display:none; text-align:center; padding:30px;">
                            <i class="fas fa-spinner fa-spin" style="font-size:32px; color:#2378e1;"></i>
                        </div>

                        <div id="tablaReportesContainer" class="table-responsive" style="border:1px solid #dee2e6; border-radius:8px;">
                            <table class="table table-bordered" style="width:100%; font-size:13px; margin-bottom:0;">
                                <thead style="background-color:#2378e1; color:white;">
                                    <tr>
                                        <th style="padding:10px;">Título</th>
                                        <th style="padding:10px;">Tipo</th>
                                        <th style="padding:10px;">Desde</th>
                                        <th style="padding:10px;">Hasta</th>
                                        <th style="padding:10px;">Proyecto</th>
                                        <th style="padding:10px;">Generado por</th>
                                        <th style="padding:10px;">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaReportesBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ========================================================= -->
<!-- MODAL NUEVA ENTRADA                                       -->
<!-- ========================================================= -->
<div class="modal fade" id="modalNuevaEntrada" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:#083CAE; color:white;">
        <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Nueva entrada de bitácora</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formNuevaEntrada">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Proyecto *</label>
              <select class="form-select" name="proyecto_id" id="nuevoProyecto" required></select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tipo *</label>
              <select class="form-select" name="tipo" id="nuevoTipo" required>
                <option value="actividad">Actividad</option>
                <option value="incidencia">Incidencia</option>
                <option value="acuerdo">Acuerdo</option>
                <option value="nota">Nota</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha *</label>
              <input type="date" class="form-control" name="fecha" id="nuevoFecha" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Hora *</label>
              <input type="time" class="form-control" name="hora" id="nuevoHora" required>
            </div>
            <div class="col-12">
              <label class="form-label">Título *</label>
              <input type="text" class="form-control" name="titulo" id="nuevoTitulo" maxlength="255" required>
            </div>
            <div class="col-12">
              <label class="form-label">Descripción *</label>
              <textarea class="form-control" name="descripcion" id="nuevoDescripcion" rows="3" required></textarea>
            </div>

            <!-- Responsable = SELECTOR real -->
            <div class="col-md-6">
              <label class="form-label">Responsable *</label>
              <select class="form-select" name="responsable_id" id="nuevoResponsable" required></select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Personal</label>
              <input type="text" class="form-control" name="personal" id="nuevoPersonal">
            </div>
            <div class="col-md-6">
              <label class="form-label">Maquinaria</label>
              <input type="text" class="form-control" name="maquinaria" id="nuevoMaquinaria">
            </div>
            <div class="col-md-6">
              <label class="form-label">Materiales</label>
              <input type="text" class="form-control" name="materiales" id="nuevoMateriales">
            </div>

            <!-- Campos incidencia -->
            <div class="col-12 tipo-incidencia-fields" style="display:none;">
              <hr>
              <h6 style="color:#dc3545;"><i class="fas fa-exclamation-triangle"></i> Datos de la incidencia</h6>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Tipo de incidencia *</label>
                  <select class="form-select" name="tipo_incidencia" id="nuevoTipoInc">
                    <option value="mecanica">Mecánica</option>
                    <option value="personal">Personal</option>
                    <option value="material">Material</option>
                    <option value="seguridad">Seguridad</option>
                    <option value="clima">Clima</option>
                    <option value="otros">Otros</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Prioridad *</label>
                  <select class="form-select" name="prioridad" id="nuevoPrioridad">
                    <option value="baja">Baja</option>
                    <option value="media" selected>Media</option>
                    <option value="alta">Alta</option>
                    <option value="critica">Crítica</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="form-label">Acción tomada</label>
                  <textarea class="form-control" name="accion_tomada" id="nuevoAccion" rows="2"></textarea>
                </div>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label">Imágenes (máx 10MB c/u)</label>
              <input type="file" class="form-control" name="imagenes[]" id="nuevasImagenes" multiple accept="image/*">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn" id="btnGuardarEntrada" style="background:#083CAE; color:white;">
          <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ========================================================= -->
<!-- MODAL VER DETALLE (ojo 👁)                                -->
<!-- ========================================================= -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:#083CAE; color:white;">
        <h5 class="modal-title"><i class="fas fa-eye"></i> Detalle de la entrada</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detalleContenido"></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- ========================================================= -->
<!-- MODAL RESOLVER INCIDENCIA (check ✅)                      -->
<!-- ========================================================= -->
<div class="modal fade" id="modalResolverIncidencia" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#28a745; color:white;">
        <h5 class="modal-title"><i class="fas fa-check-circle"></i> Resolver incidencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="resolverIncidenciaId">
        <div class="mb-3">
          <label class="form-label">Acción tomada *</label>
          <textarea class="form-control" id="resolverAccion" rows="4" placeholder="Describe la acción realizada para resolver la incidencia..." required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Evidencias de la resolución (opcional)</label>
          <input type="file" class="form-control" id="resolverEvidencias" multiple accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-success" id="btnConfirmarResolver"><i class="fas fa-check"></i> Resolver</button>
      </div>
    </div>
  </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }

    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    #tablaBody td i { transition: transform 0.2s; font-size: 14px; color: #083CAE; }
    #tablaBody td i:hover { transform: scale(1.2); }
    #tablaBody td:last-child { background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1); z-index: 15; }

    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-pendiente  { background-color: #fd7e14; color: white; }
    .badge-en_proceso { background-color: #17a2b8; color: white; }
    .badge-completado { background-color: #28a745; color: white; }
    .badge-cerrado    { background-color: #6c757d; color: white; }

    .badge-tipo-actividad  { background-color:#007bff; color:white; }
    .badge-tipo-incidencia { background-color:#dc3545; color:white; }
    .badge-tipo-acuerdo    { background-color:#6f42c1; color:white; }
    .badge-tipo-nota       { background-color:#6c757d; color:white; }

    .badge-prio-baja    { background-color:#28a745; color:white; }
    .badge-prio-media   { background-color:#ffc107; color:#000; }
    .badge-prio-alta    { background-color:#fd7e14; color:white; }
    .badge-prio-critica { background-color:#dc3545; color:white; }

    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
    .columna-agrupada { display:inline-flex; align-items:center; padding:4px 10px; background-color:#f0f4ff; border-radius:16px; color:#2378e1; font-size:12px; margin:2px; border:1px solid #2378e1; }
    .columna-agrupada .remover { margin-left:6px; cursor:pointer; font-size:14px; font-weight:bold; color:#2378e1; }

    .nav-tabs .nav-link.active { color:#2378e1 !important; border-bottom:3px solid #2378e1 !important; background:transparent !important; }

    /* Consistencia visual con otros módulos para textarea/inputs */
    #resolverAccion, #formNuevaEntrada .form-control, #formNuevaEntrada .form-select {
        border:1px solid #ced4da; border-radius:6px; padding:8px 12px; font-size:14px;
        transition: border-color .2s, box-shadow .2s;
    }
    #resolverAccion:focus, #formNuevaEntrada .form-control:focus, #formNuevaEntrada .form-select:focus {
        border-color:#2378e1; box-shadow:0 0 0 3px rgba(35,120,225,0.15); outline:none;
    }

    @media (max-width: 768px) {
        input[type="date"], #buscador { width: 100% !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS (para los modales y tabs) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    'use strict';

    // =============================================================
    // HELPERS
    // =============================================================
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    const API = '/api/bitacora';

    async function apiFetch(url, options = {}) {
        const opts = {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {})
            },
            credentials: 'same-origin',
            ...options
        };
        const r = await fetch(url, opts);
        const text = await r.text();
        let data;
        try { data = text ? JSON.parse(text) : {}; }
        catch (e) { throw new Error('Respuesta inválida del servidor'); }
        if (!r.ok) throw Object.assign(new Error(data.message || 'Error en la petición'), { data, status: r.status });
        return data;
    }

    function formatDate(d) {
        if (!d) return '-';
        try { return new Date(d + 'T00:00:00').toLocaleDateString('es-MX'); }
        catch { return d; }
    }

    function badgeEstado(e) {
        const map = { pendiente:'badge-pendiente', en_proceso:'badge-en_proceso', completado:'badge-completado', cerrado:'badge-cerrado' };
        const label = (e || '').replace('_', ' ');
        return `<span class="badge ${map[e] || 'badge-cerrado'}">${label || '-'}</span>`;
    }

    function badgeTipo(t) {
        const map = { actividad:'badge-tipo-actividad', incidencia:'badge-tipo-incidencia', acuerdo:'badge-tipo-acuerdo', nota:'badge-tipo-nota' };
        return `<span class="badge ${map[t] || 'badge-tipo-nota'}">${t || '-'}</span>`;
    }

    function badgePrioridad(p) {
        const map = { baja:'badge-prio-baja', media:'badge-prio-media', alta:'badge-prio-alta', critica:'badge-prio-critica' };
        return `<span class="badge ${map[p] || 'badge-prio-media'}">${p || '-'}</span>`;
    }

    function escapeHtml(s) {
        if (s === null || s === undefined) return '';
        return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }

    // =============================================================
    // ESTADO
    // =============================================================
    const state = {
        entries: [],
        page: 1,
        lastPage: 1,
        perPage: 10,
        total: 0,
        filtros: { fecha_inicio:'', fecha_fin:'', tipo:'', estado:'', search:'' },
        columnasAgrupadas: [],
        expandedGroups: new Set(),
        proyectos: [],
        responsables: [],
    };

    // =============================================================
    // CARGA REGISTROS
    // =============================================================
    async function cargarRegistros(page = 1) {
        const cont = document.getElementById('tablaContainer');
        const loader = document.getElementById('loaderRegistros');
        const empty = document.getElementById('sinDatosMensaje');

        loader.style.display = 'block';
        cont.style.display = 'none';
        empty.style.display = 'none';

        try {
            const qs = new URLSearchParams({
                page,
                per_page: state.perPage,
                ...Object.fromEntries(Object.entries(state.filtros).filter(([,v]) => v))
            });
            const res = await apiFetch(`${API}/entries?${qs.toString()}`);
            state.entries = res.data || [];
            state.total = res.total || 0;
            state.page = res.current_page || 1;
            state.lastPage = res.last_page || 1;

            if (!state.entries.length) {
                empty.style.display = 'block';
                document.getElementById('paginacionInfo').textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            renderTabla();
            cont.style.display = 'block';
            actualizarPaginacion();
        } catch (err) {
            console.error(err);
            alert('Error al cargar registros: ' + err.message);
            empty.style.display = 'block';
        } finally {
            loader.style.display = 'none';
        }
    }

    function actualizarPaginacion() {
        document.getElementById('paginaActual').textContent = state.page;
        const from = (state.page - 1) * state.perPage + 1;
        const to = Math.min(state.page * state.perPage, state.total);
        document.getElementById('paginacionInfo').textContent = `Mostrando ${from}-${to} de ${state.total} registros`;
        document.getElementById('btnPagAnt').disabled = state.page <= 1;
        document.getElementById('btnPagSig').disabled = state.page >= state.lastPage;
    }

    // =============================================================
    // AGRUPACIÓN DRAG & DROP
    // =============================================================
    function renderChipsAgrupacion() {
        const cont = document.getElementById('grupoColumnas');
        const txt = document.getElementById('textoAgrupar');
        cont.innerHTML = '';
        if (!state.columnasAgrupadas.length) { txt.style.display = 'inline'; return; }
        txt.style.display = 'none';
        const nombres = { estado:'Estado', fecha:'Fecha', hora:'Hora', tipo:'Tipo', titulo:'Título', descripcion:'Descripción', responsable:'Responsable' };
        state.columnasAgrupadas.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${nombres[col] || col} <span class="remover" data-col="${col}">&times;</span>`;
            cont.appendChild(chip);
        });
    }

    document.addEventListener('click', e => {
        if (e.target.classList.contains('remover')) {
            const col = e.target.dataset.col;
            state.columnasAgrupadas = state.columnasAgrupadas.filter(c => c !== col);
            renderChipsAgrupacion();
            renderTabla();
        }
    });

    function setupDragAndDrop() {
        document.querySelectorAll('th[draggable="true"]').forEach(th => {
            th.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', th.dataset.columna);
                th.style.opacity = '0.5';
            });
            th.addEventListener('dragend', () => th.style.opacity = '1');
        });
        const grupo = document.getElementById('grupoAgrupacion');
        grupo.addEventListener('dragover', e => { e.preventDefault(); });
        grupo.addEventListener('drop', e => {
            e.preventDefault();
            const col = e.dataTransfer.getData('text/plain');
            if (col && !state.columnasAgrupadas.includes(col)) {
                state.columnasAgrupadas.push(col);
                renderChipsAgrupacion();
                renderTabla();
            }
        });
    }

    function generarGrupoId(item) {
        return state.columnasAgrupadas.map(c => item[c] || '∅').join('||');
    }

    // =============================================================
    // RENDER TABLA
    // =============================================================
    function renderTabla() {
        const tbody = document.getElementById('tablaBody');
        tbody.innerHTML = '';

        const rows = state.columnasAgrupadas.length ? agrupar(state.entries) : state.entries.map(e => ({ tipo:'item', data:e }));

        rows.forEach(r => {
            if (r.tipo === 'grupo') {
                const expanded = state.expandedGroups.has(r.id);
                const tr = document.createElement('tr');
                tr.style.background = '#f0f7ff';
                tr.style.cursor = 'pointer';
                tr.innerHTML = `
                    <td colspan="9" style="padding:10px;">
                        <i class="fas fa-caret-${expanded?'down':'right'}" style="color:#2378e1; margin-right:8px;"></i>
                        <strong style="color:#2378e1;">${escapeHtml(r.valor)}</strong>
                        <span style="color:#6c757d; font-size:11px; margin-left:10px;">(${r.items.length} registros)</span>
                    </td>`;
                tr.addEventListener('click', () => {
                    if (expanded) state.expandedGroups.delete(r.id);
                    else state.expandedGroups.add(r.id);
                    renderTabla();
                });
                tbody.appendChild(tr);
                if (expanded) r.items.forEach(i => tbody.appendChild(filaItem(i, true)));
            } else {
                tbody.appendChild(filaItem(r.data, false));
            }
        });
    }

    function agrupar(items) {
        const map = new Map();
        items.forEach(it => {
            const id = generarGrupoId(it);
            if (!map.has(id)) {
                const valor = state.columnasAgrupadas.map(c => it[c] ?? 'Sin valor').join(' - ');
                map.set(id, { tipo:'grupo', id, valor, items:[it] });
            } else {
                map.get(id).items.push(it);
            }
        });
        return Array.from(map.values());
    }

    function filaItem(item, enGrupo) {
        const tr = document.createElement('tr');
        const inc = item.incidencia;
        const acciones = `
            <div style="display:flex; gap:8px; justify-content:center;">
                ${inc && !inc.resuelta_en
                    ? `<i class="fas fa-check-circle" style="color:#28a745; cursor:pointer;" title="Resolver incidencia" data-accion="resolver" data-id="${inc.id}"></i>`
                    : ''}
                <i class="fas fa-eye" style="color:#083CAE; cursor:pointer;" title="Ver detalle" data-accion="ver" data-id="${item.id}"></i>
                <i class="fas fa-trash-alt" style="color:#dc3545; cursor:pointer;" title="Eliminar" data-accion="eliminar" data-id="${item.id}"></i>
            </div>`;

        const pad = enGrupo ? 'padding-left:30px;' : '';
        tr.innerHTML = `
            <td style="border:1px solid #dee2e6; ${pad}">${badgeEstado(item.estado)}</td>
            <td style="border:1px solid #dee2e6;">${formatDate(item.fecha)}</td>
            <td style="border:1px solid #dee2e6;">${item.hora ? item.hora.substring(0,5) : '-'}</td>
            <td style="border:1px solid #dee2e6;">${badgeTipo(item.tipo)}</td>
            <td style="border:1px solid #dee2e6;">${escapeHtml(item.titulo || '-')}</td>
            <td style="border:1px solid #dee2e6; max-width:300px; overflow:hidden; text-overflow:ellipsis;" title="${escapeHtml(item.descripcion)}">${escapeHtml(item.descripcion || '-')}</td>
            <td style="border:1px solid #dee2e6;">${escapeHtml(item.responsable || item.responsable_user?.name || '-')}</td>
            <td style="border:1px solid #dee2e6; text-align:center;">
                <i class="fas fa-image" style="color:#2378e1;"></i> ${item.evidencias_count || 0}
                &nbsp;<i class="fas fa-comments" style="color:#2378e1;"></i> ${item.comentarios_count || 0}
            </td>
            <td style="border:1px solid #dee2e6; background:white; position:sticky; right:0;">${acciones}</td>
        `;
        return tr;
    }

    // =============================================================
    // ACCIONES DE LA TABLA
    // =============================================================
    document.getElementById('tablaBody').addEventListener('click', async e => {
        const el = e.target.closest('[data-accion]');
        if (!el) return;
        const accion = el.dataset.accion;
        const id = el.dataset.id;

        if (accion === 'ver')        abrirDetalle(id);
        if (accion === 'resolver')   abrirResolver(id);
        if (accion === 'eliminar')   eliminarEntrada(id);
    });

    // =============================================================
    // VER DETALLE (ojo 👁)
    // =============================================================
    async function abrirDetalle(id) {
        const body = document.getElementById('detalleContenido');
        body.innerHTML = '<div style="text-align:center; padding:30px;"><i class="fas fa-spinner fa-spin" style="font-size:28px; color:#2378e1;"></i></div>';
        new bootstrap.Modal(document.getElementById('modalDetalle')).show();

        try {
            const res = await apiFetch(`${API}/entries/${id}`);
            const d = res.data;
            const inc = d.incidencia;
            const evidencias = (d.evidencias || []).map(ev => `
                <div style="display:inline-block; margin:5px;">
                    <img src="/storage/${ev.ruta}" alt="${escapeHtml(ev.nombre_original)}" style="width:120px; height:120px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                </div>
            `).join('') || '<p style="color:#adb5bd;">Sin evidencias</p>';

            const comentarios = (d.comentarios || []).map(c => `
                <div style="border-left:3px solid #2378e1; padding:8px 12px; margin-bottom:8px; background:#f8f9fa; border-radius:4px;">
                    <div style="font-size:12px; color:#6c757d;">
                        <strong>${escapeHtml(c.usuario?.name || 'Usuario')}</strong> · ${new Date(c.created_at).toLocaleString('es-MX')}
                    </div>
                    <div>${escapeHtml(c.comentario)}</div>
                </div>
            `).join('') || '<p style="color:#adb5bd;">Sin comentarios</p>';

            body.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6"><strong>Proyecto:</strong> ${escapeHtml(d.proyecto_id)}</div>
                    <div class="col-md-6"><strong>Estado:</strong> ${badgeEstado(d.estado)}</div>
                    <div class="col-md-6"><strong>Tipo:</strong> ${badgeTipo(d.tipo)}</div>
                    <div class="col-md-6"><strong>Fecha:</strong> ${formatDate(d.fecha)} ${d.hora ? d.hora.substring(0,5) : ''}</div>
                    <div class="col-12"><strong>Título:</strong> ${escapeHtml(d.titulo)}</div>
                    <div class="col-12"><strong>Descripción:</strong><br>${escapeHtml(d.descripcion).replace(/\n/g,'<br>')}</div>
                    <div class="col-md-6"><strong>Responsable:</strong> ${escapeHtml(d.responsable || d.responsable_user?.name || '-')}</div>
                    <div class="col-md-6"><strong>Personal:</strong> ${escapeHtml(d.personal || '-')}</div>
                    <div class="col-md-6"><strong>Maquinaria:</strong> ${escapeHtml(d.maquinaria || '-')}</div>
                    <div class="col-md-6"><strong>Materiales:</strong> ${escapeHtml(d.materiales || '-')}</div>

                    ${inc ? `
                    <div class="col-12">
                        <hr>
                        <h6 style="color:#dc3545;"><i class="fas fa-exclamation-triangle"></i> Incidencia</h6>
                        <div class="row g-2">
                            <div class="col-md-4"><strong>Tipo:</strong> ${escapeHtml(inc.tipo_incidencia)}</div>
                            <div class="col-md-4"><strong>Prioridad:</strong> ${badgePrioridad(inc.prioridad)}</div>
                            <div class="col-md-4"><strong>Resuelta:</strong> ${inc.resuelta_en ? '✅ '+new Date(inc.resuelta_en).toLocaleString('es-MX') : '❌ Pendiente'}</div>
                            <div class="col-12"><strong>Acción tomada:</strong><br>${escapeHtml(inc.accion_tomada || '-')}</div>
                        </div>
                    </div>` : ''}

                    <div class="col-12">
                        <hr>
                        <h6 style="color:#2378e1;"><i class="fas fa-images"></i> Evidencias</h6>
                        <div>${evidencias}</div>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h6 style="color:#2378e1;"><i class="fas fa-comments"></i> Comentarios</h6>
                        <div>${comentarios}</div>
                    </div>
                </div>
            `;
        } catch (err) {
            body.innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(err.message)}</div>`;
        }
    }

    // =============================================================
    // RESOLVER INCIDENCIA (check ✅)
    // =============================================================
    function abrirResolver(incidenciaId) {
        document.getElementById('resolverIncidenciaId').value = incidenciaId;
        document.getElementById('resolverAccion').value = '';
        document.getElementById('resolverEvidencias').value = '';
        new bootstrap.Modal(document.getElementById('modalResolverIncidencia')).show();
    }

    document.getElementById('btnConfirmarResolver').addEventListener('click', async () => {
        const id = document.getElementById('resolverIncidenciaId').value;
        const accion = document.getElementById('resolverAccion').value.trim();
        const files = document.getElementById('resolverEvidencias').files;

        if (accion.length < 5) {
            alert('La acción tomada debe tener al menos 5 caracteres.');
            return;
        }

        const fd = new FormData();
        fd.append('_method', 'PUT');
        fd.append('accion_tomada', accion);
        for (let i = 0; i < files.length; i++) fd.append('evidencias[]', files[i]);

        const btn = document.getElementById('btnConfirmarResolver');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

        try {
            await apiFetch(`${API}/incidencias/${id}/resolve`, { method: 'POST', body: fd });
            bootstrap.Modal.getInstance(document.getElementById('modalResolverIncidencia')).hide();
            alert('✅ Incidencia resuelta correctamente');
            cargarRegistros(state.page);
            if (document.getElementById('panel-incidencias').classList.contains('active')) {
                cargarIncidencias();
            }
        } catch (err) {
            console.error(err);
            const errores = err.data?.errors ? Object.values(err.data.errors).flat().join('\n') : err.message;
            alert('❌ Error al resolver la incidencia:\n' + errores);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> Resolver';
        }
    });

    // =============================================================
    // ELIMINAR
    // =============================================================
    async function eliminarEntrada(id) {
        if (!confirm('¿Está seguro de eliminar este registro? También se eliminarán incidencias, comentarios y evidencias asociadas.')) return;
        try {
            await apiFetch(`${API}/entries/${id}`, { method: 'DELETE' });
            alert('Registro eliminado');
            cargarRegistros(state.page);
            if (document.getElementById('panel-incidencias').classList.contains('active')) {
                cargarIncidencias();
            }
        } catch (err) {
            alert('Error al eliminar: ' + err.message);
        }
    }

    // =============================================================
    // NUEVA ENTRADA
    // =============================================================
    document.getElementById('btnAgregar').addEventListener('click', async () => {
        await cargarCatalogos();
        document.getElementById('formNuevaEntrada').reset();
        const now = new Date();
        document.getElementById('nuevoFecha').value = now.toISOString().slice(0,10);
        document.getElementById('nuevoHora').value = now.toTimeString().slice(0,5);
        document.querySelector('.tipo-incidencia-fields').style.display = 'none';
        new bootstrap.Modal(document.getElementById('modalNuevaEntrada')).show();
    });

    document.getElementById('nuevoTipo').addEventListener('change', e => {
        document.querySelector('.tipo-incidencia-fields').style.display = (e.target.value === 'incidencia') ? 'block' : 'none';
    });

    async function cargarCatalogos() {
        // Proyectos
        if (!state.proyectos.length) {
            try {
                const r = await apiFetch(`${API}/proyectos`);
                state.proyectos = r.data || [];
            } catch (e) { state.proyectos = []; }
        }
        const selProy = document.getElementById('nuevoProyecto');
        selProy.innerHTML = '<option value="">-- Seleccione --</option>' +
            state.proyectos.map(p => `<option value="${escapeHtml(p.id)}">${escapeHtml(p.nombre)}</option>`).join('');

        // Responsables (usuarios + empleados)
        if (!state.responsables.length) {
            try {
                const r = await apiFetch(`${API}/responsables`);
                state.responsables = r.data || [];
            } catch (e) { state.responsables = []; }
        }
        const selResp = document.getElementById('nuevoResponsable');
        selResp.innerHTML = '<option value="">-- Seleccione --</option>' +
            state.responsables.map(u => {
                const val = (u.tipo === 'usuario') ? u.id : '';
                const label = `${u.nombre}${u.email ? ' · '+u.email : ''}${u.tipo === 'empleado' ? ' (empleado)' : ''}`;
                return `<option value="${val}" ${u.tipo !== 'usuario' ? 'disabled' : ''}>${escapeHtml(label)}</option>`;
            }).join('');
    }

    document.getElementById('btnGuardarEntrada').addEventListener('click', async () => {
        const form = document.getElementById('formNuevaEntrada');
        if (!form.checkValidity()) { form.reportValidity(); return; }

        const fd = new FormData(form);
        const files = document.getElementById('nuevasImagenes').files;
        for (let i = 0; i < files.length; i++) fd.append('imagenes[]', files[i]);

        const btn = document.getElementById('btnGuardarEntrada');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

        try {
            await apiFetch(`${API}/entries`, { method: 'POST', body: fd });
            bootstrap.Modal.getInstance(document.getElementById('modalNuevaEntrada')).hide();
            alert('✅ Entrada creada');
            cargarRegistros(1);
        } catch (err) {
            const errores = err.data?.errors ? Object.values(err.data.errors).flat().join('\n') : err.message;
            alert('❌ Error al guardar:\n' + errores);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Guardar';
        }
    });

    // =============================================================
    // INCIDENCIAS (TAB)
    // =============================================================
    async function cargarIncidencias() {
        const loader = document.getElementById('loaderIncidencias');
        const vacio  = document.getElementById('incidenciasVacias');
        const cont   = document.getElementById('tablaIncidenciasContainer');
        const tbody  = document.getElementById('tablaIncidenciasBody');

        loader.style.display = 'block';
        cont.style.display = 'none';
        vacio.style.display = 'none';

        try {
            const qs = new URLSearchParams();
            const estado = document.getElementById('filtroIncidenciaEstado').value;
            const prio   = document.getElementById('filtroIncidenciaPrioridad').value;
            if (estado) qs.set('estado', estado);
            if (prio)   qs.set('prioridad', prio);

            const res = await apiFetch(`${API}/incidencias?${qs.toString()}`);
            const items = res.data || [];
            tbody.innerHTML = '';

            if (!items.length) { vacio.style.display = 'block'; return; }

            items.forEach(inc => {
                const entry = inc.bitacora_entry || {};
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding:8px;">${entry.fecha ? formatDate(entry.fecha) : '-'}</td>
                    <td style="padding:8px;">${escapeHtml(entry.proyecto_id || '-')}</td>
                    <td style="padding:8px;">${escapeHtml(entry.titulo || '-')}</td>
                    <td style="padding:8px;">${escapeHtml(inc.tipo_incidencia || '-')}</td>
                    <td style="padding:8px;">${badgePrioridad(inc.prioridad)}</td>
                    <td style="padding:8px;">
                        ${inc.resuelta_en
                            ? '<span class="badge badge-completado">Resuelta</span>'
                            : '<span class="badge badge-pendiente">Abierta</span>'}
                    </td>
                    <td style="padding:8px; max-width:250px; overflow:hidden; text-overflow:ellipsis;">${escapeHtml(inc.accion_tomada || '-')}</td>
                    <td style="padding:8px; text-align:center;">
                        ${!inc.resuelta_en
                            ? `<i class="fas fa-check-circle" style="color:#28a745; cursor:pointer; margin-right:8px;" title="Resolver" data-accion="resolver" data-id="${inc.id}"></i>`
                            : ''}
                        <i class="fas fa-eye" style="color:#083CAE; cursor:pointer;" title="Ver" data-accion="ver-entry" data-id="${entry.id}"></i>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            cont.style.display = 'block';
        } catch (err) {
            console.error(err);
            alert('Error al cargar incidencias: ' + err.message);
        } finally {
            loader.style.display = 'none';
        }
    }

    document.getElementById('tablaIncidenciasBody').addEventListener('click', e => {
        const el = e.target.closest('[data-accion]');
        if (!el) return;
        if (el.dataset.accion === 'resolver') abrirResolver(el.dataset.id);
        if (el.dataset.accion === 'ver-entry') abrirDetalle(el.dataset.id);
    });

    document.getElementById('filtroIncidenciaEstado').addEventListener('change', cargarIncidencias);
    document.getElementById('filtroIncidenciaPrioridad').addEventListener('change', cargarIncidencias);
    document.getElementById('btnRefrescarIncidencias').addEventListener('click', cargarIncidencias);

    // =============================================================
    // REPORTES (TAB)
    // =============================================================
    async function cargarResumenReportes() {
        try {
            const res = await apiFetch(`${API}/reportes/resumen`);
            const d = res.data || {};
            document.getElementById('kpiTotalEntradas').textContent        = d.total_entradas ?? 0;
            document.getElementById('kpiActividades').textContent          = d.total_actividades ?? 0;
            document.getElementById('kpiIncidenciasAbiertas').textContent  = d.incidencias_abiertas ?? 0;
            document.getElementById('kpiComentarios').textContent          = d.total_comentarios ?? 0;
            document.getElementById('kpiImagenes').textContent             = d.total_imagenes ?? 0;
            document.getElementById('kpiReportesGen').textContent          = d.reportes_generados ?? 0;
        } catch (err) { console.error('Resumen reportes:', err); }
    }

    async function cargarReportes() {
        const tbody = document.getElementById('tablaReportesBody');
        const loader = document.getElementById('loaderReportes');
        tbody.innerHTML = '';
        loader.style.display = 'block';

        try {
            const res = await apiFetch(`${API}/reportes`);
            const items = res.data || [];
            if (!items.length) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#adb5bd;">No hay reportes generados</td></tr>';
                return;
            }
            tbody.innerHTML = items.map(r => `
                <tr>
                    <td style="padding:8px;">${escapeHtml(r.titulo || '-')}</td>
                    <td style="padding:8px;">${escapeHtml(r.tipo || '-')}</td>
                    <td style="padding:8px;">${formatDate(r.fecha_inicio)}</td>
                    <td style="padding:8px;">${formatDate(r.fecha_fin)}</td>
                    <td style="padding:8px;">${escapeHtml(r.proyecto?.nombre || r.proyecto_id || '-')}</td>
                    <td style="padding:8px;">${escapeHtml(r.generador?.name || '-')}</td>
                    <td style="padding:8px;">${r.created_at ? new Date(r.created_at).toLocaleString('es-MX') : '-'}</td>
                </tr>
            `).join('');
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="7" style="color:#dc3545; padding:20px;">Error: ${escapeHtml(err.message)}</td></tr>`;
        } finally {
            loader.style.display = 'none';
        }
    }

    document.getElementById('btnGenerarReporte').addEventListener('click', async () => {
        const tipo = document.getElementById('repTipo').value;
        const fi = document.getElementById('repFechaInicio').value;
        const ff = document.getElementById('repFechaFin').value;
        if (!fi || !ff) { alert('Selecciona el rango de fechas'); return; }

        try {
            await apiFetch(`${API}/reportes/generar`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tipo_reporte: tipo, fecha_inicio: fi, fecha_fin: ff })
            });
            alert('✅ Reporte generado');
            cargarReportes();
            cargarResumenReportes();
        } catch (err) {
            const errores = err.data?.errors ? Object.values(err.data.errors).flat().join('\n') : err.message;
            alert('❌ ' + errores);
        }
    });

    document.getElementById('btnExportarReporte').addEventListener('click', () => {
        const fi = document.getElementById('repFechaInicio').value;
        const ff = document.getElementById('repFechaFin').value;
        const qs = new URLSearchParams();
        if (fi) qs.set('fecha_inicio', fi);
        if (ff) qs.set('fecha_fin', ff);
        window.open(`{{ route('bitacora.print') }}?${qs.toString()}`, '_blank');
    });

    // =============================================================
    // TABS
    // =============================================================
    document.getElementById('tab-incidencias').addEventListener('shown.bs.tab', () => {
        cargarIncidencias();
    });
    document.getElementById('tab-reportes').addEventListener('shown.bs.tab', () => {
        cargarResumenReportes();
        cargarReportes();
        // Default fechas
        const hoy = new Date();
        const inicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        document.getElementById('repFechaInicio').value = inicio.toISOString().slice(0,10);
        document.getElementById('repFechaFin').value = hoy.toISOString().slice(0,10);
    });

    document.querySelectorAll('.nav-tabs .nav-link').forEach(btn => {
        btn.addEventListener('shown.bs.tab', e => {
            document.querySelectorAll('.nav-tabs .nav-link').forEach(b => {
                b.style.color = '#6c757d';
                b.style.borderBottom = 'none';
            });
            e.target.style.color = '#2378e1';
            e.target.style.borderBottom = '3px solid #2378e1';
        });
    });

    // =============================================================
    // FILTROS Y BUSCADOR
    // =============================================================
    document.getElementById('fechaInicio').addEventListener('change', e => { state.filtros.fecha_inicio = e.target.value; cargarRegistros(1); });
    document.getElementById('fechaFin').addEventListener('change', e => { state.filtros.fecha_fin = e.target.value; cargarRegistros(1); });
    document.getElementById('filtroTipo').addEventListener('change', e => { state.filtros.tipo = e.target.value; cargarRegistros(1); });
    document.getElementById('filtroEstado').addEventListener('change', e => { state.filtros.estado = e.target.value; cargarRegistros(1); });

    let searchTimer;
    document.getElementById('buscador').addEventListener('input', e => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            state.filtros.search = e.target.value.trim();
            cargarRegistros(1);
        }, 400);
    });

    document.getElementById('btnPagAnt').addEventListener('click', () => { if (state.page > 1) cargarRegistros(state.page - 1); });
    document.getElementById('btnPagSig').addEventListener('click', () => { if (state.page < state.lastPage) cargarRegistros(state.page + 1); });

    // =============================================================
    // EXPORTAR EXCEL (simple client-side)
    // =============================================================
    document.getElementById('btnExcel').addEventListener('click', () => {
        const tabla = document.getElementById('tablaBitacora');
        if (!tabla) return;
        const html = tabla.outerHTML;
        const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'Bitacora.xls';
        a.click();
    });

    // =============================================================
    // INIT
    // =============================================================    document.addEventListener('DOMContentLoaded', () => {
        setupDragAndDrop();
        cargarRegistros(1);
    });

})();
</script>

@endsection