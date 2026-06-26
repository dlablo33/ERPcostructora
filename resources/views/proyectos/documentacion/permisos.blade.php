@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Contratos y Planos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-file-contract" style="margin-right: 10px;"></i>
                    Contratos y Planos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DOCUMENTOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Contratos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalContratos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Planos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPlanos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Contratos Vigentes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="contratosVigentes">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Planos Aprobados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="planosAprobados">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            @foreach($proyectos ?? [] as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los tipos</option>
                            <option value="contrato">Contratos</option>
                            <option value="plano">Planos</option>
                        </select>

                        <select id="selectorEstado" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="Vigente">Vigente</option>
                            <option value="En Revisión">En Revisión</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Vencido">Vencido</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <button id="btnSubirDocumento" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Documento">
                                <i class="fas fa-cloud-upload-alt"></i> Subir
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px; display: none;" id="vistaPlanosControls">
                            <button id="btnVistaTabla" class="vista-btn active" style="padding: 6px 12px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-table"></i>
                            </button>
                            <button id="btnVistaGaleria" class="vista-btn" style="padding: 6px 12px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar documento..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="documentos-tab active" data-tab="contratos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-file-signature"></i> Contratos
                        <span style="background-color: #28a745; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="badgeContratos">0</span>
                    </button>
                    <button class="documentos-tab" data-tab="planos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-draw-polygon"></i> Planos
                        <span style="background-color: #17a2b8; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="badgePlanos">0</span>
                    </button>
                    <button class="documentos-tab" data-tab="historial" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-history"></i> Historial de Versiones
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
                    <i class="fas fa-file-contract" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay documentos registrados</p>
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

                <!-- SECCIÓN CONTRATOS -->
                <div id="tab-contratos" class="documentos-content active">
                    <div id="vistaTablaContratos" style="display: block;">
                        <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">No. Contrato</th>
                                        <th style="padding: 12px;">Proyecto</th>
                                        <th style="padding: 12px;">Cliente</th>
                                        <th style="padding: 12px;">Fecha Firma</th>
                                        <th style="padding: 12px;">Fecha Vencimiento</th>
                                        <th style="padding: 12px;">Monto</th>
                                        <th style="padding: 12px;">Estado</th>
                                        <th style="padding: 12px;">Versión</th>
                                        <th style="padding: 12px;">Archivo</th>
                                        <th style="padding: 12px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaContratosBody">
                                    <tr>
                                        <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">
                                            <i class="fas fa-spinner fa-spin"></i> Cargando contratos...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; flex-wrap: wrap;">
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-paginacion-contratos" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaContratosActual">1</span>
                            <button class="btn-paginacion-contratos" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;" id="infoContratos">Mostrando 0-0 de 0 contratos</span>
                    </div>
                </div>

                <!-- SECCIÓN PLANOS -->
                <div id="tab-planos" class="documentos-content" style="display: none;">
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <select id="filtroDisciplina" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las disciplinas</option>
                            <option value="Arquitectura">Arquitectura</option>
                            <option value="Estructura">Estructura</option>
                            <option value="Instalaciones">Instalaciones</option>
                            <option value="Eléctricas">Eléctricas</option>
                            <option value="Hidráulicas">Hidráulicas</option>
                        </select>
                        <select id="filtroRevision" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las revisiones</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="En Revisión">En Revisión</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                    </div>

                    <div id="vistaGaleriaPlanos" style="display: block;">
                        <div id="galeriaPlanos" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <div style="text-align: center; padding: 40px; color: #6c757d; grid-column: 1 / -1;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i>
                                <p style="margin-top: 10px;">Cargando planos...</p>
                            </div>
                        </div>
                    </div>

                    <div id="vistaTablaPlanos" style="display: none;">
                        <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                            <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px;">No. Plano</th>
                                        <th style="padding: 12px;">Nombre</th>
                                        <th style="padding: 12px;">Disciplina</th>
                                        <th style="padding: 12px;">Proyecto</th>
                                        <th style="padding: 12px;">Revisión</th>
                                        <th style="padding: 12px;">Fecha</th>
                                        <th style="padding: 12px;">Estado</th>
                                        <th style="padding: 12px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaPlanosBody">
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                                            <i class="fas fa-spinner fa-spin"></i> Cargando planos...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; flex-wrap: wrap;">
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-paginacion-planos" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;" id="paginaPlanosActual">1</span>
                            <button class="btn-paginacion-planos" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;" id="infoPlanos">Mostrando 0-0 de 0 planos</span>
                    </div>
                </div>

                <!-- SECCIÓN HISTORIAL -->
                <div id="tab-historial" class="documentos-content" style="display: none;">
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                        <div style="min-width: 300px;">
                            <select id="selectorDocumento" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar documento...</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnVerHistorial" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 10px 20px; cursor: pointer;">
                                <i class="fas fa-history"></i> Ver historial
                            </button>
                        </div>
                    </div>

                    <div id="timelineVersiones" style="position: relative; padding-left: 30px; min-height: 100px;">
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-info-circle" style="font-size: 32px;"></i>
                            <p style="margin-top: 10px;">Seleccione un documento para ver su historial de versiones</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Subir Documento ACTUALIZADO CON CAMPOS PARA NUEVO DOCUMENTO -->
<div id="modalSubirDocumento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-cloud-upload-alt"></i> Subir Archivo a Documento</h3>
            <button id="btnCerrarModalSubir" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <!-- CAMPO OCULTO PARA EL ID DEL DOCUMENTO EXISTENTE -->
            <input type="hidden" id="modalDocumentoIdHidden" value="">
            <input type="hidden" id="modalProyectoIdHidden" value="">
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Documento <span style="color: #dc3545;">*</span></label>
                <select id="modalTipoDoc" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="contrato">Contrato</option>
                    <option value="plano">Plano</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select id="modalProyectoDoc" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar proyecto...</option>
                    @foreach($proyectos ?? [] as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Documento Existente (opcional)</label>
                <select id="modalDocumentoId" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar documento existente...</option>
                </select>
                <small style="color: #6c757d; font-size: 11px;">Si selecciona un documento existente, se actualizará. Si no, se creará uno nuevo.</small>
            </div>

            <hr style="margin: 15px 0; border: 1px dashed #dee2e6;">

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Número/Identificador <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalNumeroDoc" placeholder="Ej: CON-2024-001, A-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                <small style="color: #6c757d; font-size: 11px;">Si es un documento nuevo, se creará con este número.</small>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre/Descripción <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalNombreDoc" placeholder="Nombre descriptivo del documento" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Disciplina (solo para planos)</label>
                <select id="modalDisciplinaDoc" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar...</option>
                    <option value="Arquitectura">Arquitectura</option>
                    <option value="Estructura">Estructura</option>
                    <option value="Instalaciones">Instalaciones</option>
                    <option value="Eléctricas">Eléctricas</option>
                    <option value="Hidráulicas">Hidráulicas</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha del Documento</label>
                    <input type="date" id="modalFechaDoc" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Versión</label>
                    <input type="text" id="modalVersionDoc" placeholder="v1.0" value="v1.0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción de Cambios</label>
                <textarea id="modalCambiosDoc" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa los cambios de esta versión..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo <span style="color: #dc3545;">*</span></label>
                <div id="dropZone" style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa; cursor: pointer;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra el archivo aquí o <span style="color: #083CAE; cursor: pointer;">selecciona</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">PDF, DWG, DXF, JPG, PNG (Max. 50MB)</p>
                    <input type="file" id="fileInput" style="display: none;" accept=".pdf,.dwg,.dxf,.jpg,.jpeg,.png">
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
            <button id="btnCancelarSubir" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnSubirArchivo" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Subir Archivo</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Contrato -->
<div id="modalVerContrato" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 900px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalContratoTitulo">
                <i class="fas fa-file-contract"></i> Detalle de Contrato
            </h3>
            <button id="btnCerrarModalContrato" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="contratoDetalleContent">
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #083CAE;"></i>
                <p style="margin-top: 10px;">Cargando detalle del contrato...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Plano -->
<div id="modalVerPlano" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 1000px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalPlanoTitulo">
                <i class="fas fa-draw-polygon"></i> Detalle de Plano
            </h3>
            <button id="btnCerrarModalPlano" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="planoDetalleContent">
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #083CAE;"></i>
                <p style="margin-top: 10px;">Cargando detalle del plano...</p>
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
    
    .documentos-tab {
        transition: all 0.3s ease;
    }
    
    .documentos-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .documentos-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .documentos-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .btn-paginacion-contratos,
    .btn-paginacion-planos {
        transition: all 0.3s ease;
    }
    
    .btn-paginacion-contratos:hover,
    .btn-paginacion-planos:hover {
        background-color: #e9ecef !important;
    }
    
    .plano-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .plano-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .vista-btn {
        transition: all 0.3s ease;
    }
    
    .vista-btn:hover {
        background-color: #e9ecef;
    }
    
    .vista-btn.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .badge-estado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-vigente {
        background-color: #28a745;
        color: white;
    }
    
    .badge-en-revision {
        background-color: #ffc107;
        color: #856404;
    }
    
    .badge-aprobado {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #6c757d;
        color: white;
    }
    
    .badge-vencido {
        background-color: #dc3545;
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
    
    hr {
        border: 1px dashed #dee2e6;
        margin: 15px 0;
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
        
        .documentos-tab {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 DOM cargado - Contratos y Planos');
        
        // Variables globales
        let currentPageContratos = 1;
        let currentPagePlanos = 1;
        let rowsPerPageContratos = 10;
        let rowsPerPagePlanos = 12;
        let totalContratos = 0;
        let totalPlanos = 0;

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE CARGA DE DATOS
        // ════════════════════════════════════════════════════════════════

        async function cargarTodosLosDatos() {
            mostrarLoader(true);
            ocultarErrores();
            
            try {
                await Promise.all([
                    cargarResumen(),
                    cargarContratos(),
                    cargarPlanos()
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
                
                let url = '/proyectos/documentos-api/resumen';
                const params = new URLSearchParams();
                if (proyectoId) params.append('proyecto_id', proyectoId);
                if (params.toString()) url += '?' + params.toString();
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar resumen');
                
                const data = await response.json();
                
                document.getElementById('totalContratos').textContent = data.total_contratos || 0;
                document.getElementById('totalPlanos').textContent = data.total_planos || 0;
                document.getElementById('contratosVigentes').textContent = data.contratos_vigentes || 0;
                document.getElementById('planosAprobados').textContent = data.planos_aprobados || 0;
                
                document.getElementById('badgeContratos').textContent = data.total_contratos || 0;
                document.getElementById('badgePlanos').textContent = data.total_planos || 0;
                
            } catch (error) {
                console.error('❌ Error en resumen:', error);
                throw error;
            }
        }

        async function cargarContratos(page = 1) {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const estado = document.getElementById('selectorEstado').value;
                const search = document.getElementById('buscador').value;
                
                let url = `/proyectos/documentos-api/contratos?per_page=${rowsPerPageContratos}&page=${page}`;
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                if (estado) url += `&estado=${estado}`;
                if (search) url += `&search=${encodeURIComponent(search)}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar contratos');
                
                const data = await response.json();
                const contratos = data.data || [];
                totalContratos = data.pagination?.total || 0;
                currentPageContratos = data.pagination?.current_page || 1;
                
                renderizarTablaContratos(contratos);
                actualizarPaginacionContratos(data.pagination);
                
            } catch (error) {
                console.error('❌ Error en contratos:', error);
                throw error;
            }
        }

        async function cargarPlanos(page = 1) {
            try {
                const proyectoId = document.getElementById('selectorProyecto').value;
                const disciplina = document.getElementById('filtroDisciplina').value;
                const estado = document.getElementById('filtroRevision').value;
                const search = document.getElementById('buscador').value;
                
                let url = `/proyectos/documentos-api/planos?per_page=${rowsPerPagePlanos}&page=${page}`;
                if (proyectoId) url += `&proyecto_id=${proyectoId}`;
                if (disciplina) url += `&disciplina=${disciplina}`;
                if (estado) url += `&estado=${estado}`;
                if (search) url += `&search=${encodeURIComponent(search)}`;
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Error al cargar planos');
                
                const data = await response.json();
                const planos = data.data || [];
                totalPlanos = data.pagination?.total || 0;
                currentPagePlanos = data.pagination?.current_page || 1;
                
                renderizarGaleriaPlanos(planos);
                renderizarTablaPlanos(planos);
                actualizarPaginacionPlanos(data.pagination);
                
            } catch (error) {
                console.error('❌ Error en planos:', error);
                throw error;
            }
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE RENDERIZADO
        // ════════════════════════════════════════════════════════════════

        function renderizarTablaContratos(datos) {
            const tbody = document.getElementById('tablaContratosBody');
            const sinDatos = document.getElementById('sinDatosMensaje');
            
            if (!tbody) return;
            
            if (!datos || datos.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay contratos registrados
                        </td>
                    </tr>
                `;
                sinDatos.style.display = 'block';
                return;
            }
            
            sinDatos.style.display = 'none';
            
            let html = '';
            datos.forEach(item => {
                const estadoClass = getEstadoBadgeClass(item.estado);
                const tieneDoc = item.tiene_documento;
                
                html += `
                    <tr>
                        <td style="padding: 12px;"><strong>${item.no_contrato || '-'}</strong></td>
                        <td style="padding: 12px;">${item.proyecto || '-'}</td>
                        <td style="padding: 12px;">${item.cliente || '-'}</td>
                        <td style="padding: 12px;">${item.fecha_firma || '-'}</td>
                        <td style="padding: 12px;">${item.fecha_fin || '-'}</td>
                        <td style="padding: 12px; text-align: right;">${item.monto_formateado || '$0'}</td>
                        <td style="padding: 12px;">
                            <span class="badge-estado ${estadoClass}">${item.estado || 'N/A'}</span>
                        </td>
                        <td style="padding: 12px;">${item.version || 'v1.0'}</td>
                        <td style="padding: 12px;">
                            ${tieneDoc ? '<i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>' : '<i class="fas fa-file" style="color: #6c757d; font-size: 16px;"></i>'}
                        </td>
                        <td style="padding: 12px;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verContrato(${item.id})" title="Ver detalle"></i>
                            ${tieneDoc ? `<i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="descargarDocumento(${item.id}, 'contrato')" title="Descargar"></i>` : ''}
                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;" onclick="verHistorial('contrato', ${item.id})" title="Ver historial"></i>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        function renderizarGaleriaPlanos(datos) {
            const container = document.getElementById('galeriaPlanos');
            const sinDatos = document.getElementById('sinDatosMensaje');
            
            if (!container) return;
            
            if (!datos || datos.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #6c757d; grid-column: 1 / -1;">
                        <i class="fas fa-inbox" style="font-size: 32px;"></i>
                        <p style="margin-top: 10px;">No hay planos registrados</p>
                    </div>
                `;
                sinDatos.style.display = 'block';
                return;
            }
            
            sinDatos.style.display = 'none';
            
            const coloresDisciplina = {
                'Arquitectura': '#083CAE',
                'Estructura': '#dc3545',
                'Instalaciones': '#17a2b8',
                'Eléctricas': '#ffc107',
                'Hidráulicas': '#28a745'
            };
            
            let html = '';
            datos.forEach(item => {
                const estadoClass = getEstadoBadgeClass(item.estado);
                const color = coloresDisciplina[item.disciplina] || '#6c757d';
                const tieneDoc = item.tiene_documento;
                
                html += `
                    <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="verPlano(${item.id})">
                            <div style="text-align: center; padding: 20px;">
                                <i class="fas fa-draw-polygon" style="font-size: 48px; color: ${color};"></i>
                                <div style="margin-top: 10px; font-size: 14px; font-weight: 600; color: ${color};">${item.no_plano || 'N/A'}</div>
                                <div style="font-size: 12px; color: #6c757d;">${item.disciplina || 'Sin disciplina'}</div>
                            </div>
                            <span style="position: absolute; top: 10px; right: 10px;" class="badge-estado ${estadoClass}">${item.estado || 'Pendiente'}</span>
                            ${item.tiene_miniatura ? '<span style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.5); color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;"><i class="fas fa-image"></i></span>' : ''}
                        </div>
                        <div style="padding: 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-weight: 600; font-size: 16px;">${item.no_plano || 'N/A'}</span>
                                <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">${item.revision || 'Rev.0'}</span>
                            </div>
                            <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">${item.nombre || 'Sin nombre'}</div>
                            <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">${item.proyecto || 'Sin proyecto'}</div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 12px; color: #6c757d;">${item.fecha || 'N/A'}</span>
                                <div style="display: flex; gap: 10px;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlano(${item.id})" title="Ver detalle"></i>
                                    ${tieneDoc ? `<i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarDocumento(${item.id}, 'plano')" title="Descargar"></i>` : ''}
                                    <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('plano', ${item.id})" title="Historial"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function renderizarTablaPlanos(datos) {
            const tbody = document.getElementById('tablaPlanosBody');
            
            if (!tbody) return;
            
            if (!datos || datos.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #6c757d;">
                            <i class="fas fa-inbox"></i> No hay planos registrados
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            datos.forEach(item => {
                const estadoClass = getEstadoBadgeClass(item.estado);
                const tieneDoc = item.tiene_documento;
                
                html += `
                    <tr>
                        <td style="padding: 12px;"><strong>${item.no_plano || '-'}</strong></td>
                        <td style="padding: 12px;">${item.nombre || '-'}</td>
                        <td style="padding: 12px;">${item.disciplina || '-'}</td>
                        <td style="padding: 12px;">${item.proyecto || '-'}</td>
                        <td style="padding: 12px;">${item.revision || 'Rev.0'}</td>
                        <td style="padding: 12px;">${item.fecha || '-'}</td>
                        <td style="padding: 12px;">
                            <span class="badge-estado ${estadoClass}">${item.estado || 'Pendiente'}</span>
                        </td>
                        <td style="padding: 12px;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verPlano(${item.id})" title="Ver detalle"></i>
                            ${tieneDoc ? `<i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="descargarDocumento(${item.id}, 'plano')" title="Descargar"></i>` : ''}
                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;" onclick="verHistorial('plano', ${item.id})" title="Historial"></i>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE UTILIDAD
        // ════════════════════════════════════════════════════════════════

        function actualizarPaginacionContratos(pagination) {
            if (!pagination) return;
            
            const total = pagination.total || 0;
            const perPage = pagination.per_page || 10;
            const current = pagination.current_page || 1;
            const last = pagination.last_page || 1;
            
            const inicio = ((current - 1) * perPage) + 1;
            const fin = Math.min(current * perPage, total);
            
            document.getElementById('paginaContratosActual').textContent = current;
            document.getElementById('infoContratos').textContent = 
                total > 0 ? `Mostrando ${inicio}-${fin} de ${total} contratos` : 'Mostrando 0-0 de 0 contratos';
        }

        function actualizarPaginacionPlanos(pagination) {
            if (!pagination) return;
            
            const total = pagination.total || 0;
            const perPage = pagination.per_page || 12;
            const current = pagination.current_page || 1;
            const last = pagination.last_page || 1;
            
            const inicio = ((current - 1) * perPage) + 1;
            const fin = Math.min(current * perPage, total);
            
            document.getElementById('paginaPlanosActual').textContent = current;
            document.getElementById('infoPlanos').textContent = 
                total > 0 ? `Mostrando ${inicio}-${fin} de ${total} planos` : 'Mostrando 0-0 de 0 planos';
        }

        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'Vigente': return 'badge-vigente';
                case 'Aprobado': return 'badge-aprobado';
                case 'En Revisión': return 'badge-en-revision';
                case 'Pendiente': return 'badge-pendiente';
                case 'Vencido': return 'badge-vencido';
                default: return 'badge-pendiente';
            }
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

        // ════════════════════════════════════════════════════════════════
        // FUNCIONES DE ACCIONES
        // ════════════════════════════════════════════════════════════════

        window.verContrato = async function(id) {
            try {
                const response = await fetch(`/proyectos/documentos-api/contrato/${id}`);
                if (!response.ok) throw new Error('Error al cargar detalle');
                
                const data = await response.json();
                
                document.getElementById('modalContratoTitulo').innerHTML = `
                    <i class="fas fa-file-contract"></i> Contrato ${data.no_contrato || 'N/A'}
                `;
                
                const estadoClass = getEstadoBadgeClass(data.estado);
                
                let html = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap;">
                        <div>
                            <div style="font-size: 12px; color: #6c757d;">Número de Contrato</div>
                            <div style="font-size: 24px; font-weight: 700; color: #083CAE;">${data.no_contrato || 'N/A'}</div>
                        </div>
                        <div>
                            <span class="badge-estado ${estadoClass}" style="font-size: 14px; padding: 8px 20px;">${data.estado || 'N/A'}</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Proyecto</div>
                            <div style="font-size: 14px; font-weight: 600;">${data.proyecto || 'N/A'}</div>
                        </div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Cliente</div>
                            <div style="font-size: 14px; font-weight: 600;">${data.cliente || 'N/A'}</div>
                        </div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">RFC Cliente</div>
                            <div style="font-size: 14px;">${data.rfc_cliente || 'N/A'}</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha de Firma</div>
                            <div style="font-size: 15px; font-weight: 600;">${data.fecha_firma || 'N/A'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha de Inicio</div>
                            <div style="font-size: 15px;">${data.fecha_inicio || 'N/A'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha de Fin</div>
                            <div style="font-size: 15px;">${data.fecha_fin || 'N/A'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Días Restantes</div>
                            <div style="font-size: 15px; font-weight: 600;">${data.dias_restantes || 0} días</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Monto Total</div>
                            <div style="font-size: 20px; font-weight: 700; color: #083CAE;">${data.monto_formateado || '$0'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Anticipo (${data.anticipo_porcentaje || 0}%)</div>
                            <div style="font-size: 16px;">${data.anticipo_formateado || '$0'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Saldo por Ejercer</div>
                            <div style="font-size: 16px;">${data.saldo_formateado || '$0'}</div>
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <h4 style="font-size: 16px; color: #083CAE; margin: 0 0 10px 0;">Descripción</h4>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6;">${data.descripcion || 'Sin descripción'}</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Responsables del Contrato</div>
                            <div><span style="color: #6c757d;">Contratante:</span> ${data.responsable_contratante || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Cargo:</span> ${data.cargo_contratante || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Email:</span> ${data.email_contratante || 'N/A'}</div>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                                <span style="color: #6c757d;">Contratista:</span> ${data.responsable_contratista || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Cargo:</span> ${data.cargo_contratista || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Email:</span> ${data.email_contratista || 'N/A'}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Condiciones</div>
                            <div><span style="color: #6c757d;">Forma de Pago:</span> ${data.forma_pago || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Plazo de Pago:</span> ${data.plazo_pago || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Versión:</span> ${data.version || 'v1.0'}</div>
                            <div><span style="color: #6c757d;">Creado por:</span> ${data.created_by || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Fecha creación:</span> ${data.created_at || 'N/A'}</div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        ${data.documento_path ? `<button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarDocumento(${data.id}, 'contrato')"><i class="fas fa-download"></i> Descargar PDF</button>` : ''}
                        <button style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalContrato()">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('contratoDetalleContent').innerHTML = html;
                document.getElementById('modalVerContrato').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
            } catch (error) {
                console.error('❌ Error al cargar detalle:', error);
                alert('Error al cargar el detalle del contrato');
            }
        };

        window.verPlano = async function(id) {
            try {
                const response = await fetch(`/proyectos/documentos-api/plano/${id}`);
                if (!response.ok) throw new Error('Error al cargar detalle');
                
                const data = await response.json();
                
                document.getElementById('modalPlanoTitulo').innerHTML = `
                    <i class="fas fa-draw-polygon"></i> Plano ${data.no_plano || 'N/A'} - ${data.nombre || 'Sin nombre'}
                `;
                
                const estadoClass = getEstadoBadgeClass(data.estado);
                
                let html = `
                    <div style="text-align: center; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 40px; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                            <div style="text-align: center;">
                                <i class="fas fa-draw-polygon" style="font-size: 80px; color: #083CAE;"></i>
                                <div style="margin-top: 15px; font-size: 24px; font-weight: 700; color: #083CAE;">${data.no_plano || 'N/A'}</div>
                                <div style="font-size: 16px; color: #6c757d;">${data.nombre || 'Sin nombre'}</div>
                                <div style="margin-top: 10px;">
                                    <span class="badge-estado ${estadoClass}" style="font-size: 14px; padding: 6px 16px;">${data.estado || 'Pendiente'}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Disciplina</div>
                            <div style="font-size: 14px; font-weight: 600;">${data.disciplina || 'N/A'}</div>
                        </div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Revisión</div>
                            <div style="font-size: 14px; font-weight: 600;">${data.revision || 'Rev.0'}</div>
                        </div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Formato</div>
                            <div style="font-size: 14px;">${data.formato || 'N/A'}</div>
                        </div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Tamaño</div>
                            <div style="font-size: 14px;">${data.tamanio_formateado || '0 B'}</div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                            <div style="font-size: 15px; font-weight: 600;">${data.fecha || 'N/A'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha Aprobación</div>
                            <div style="font-size: 15px;">${data.fecha_aprobacion || 'N/A'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Escala</div>
                            <div style="font-size: 15px;">${data.escala || 'N/A'}</div>
                        </div>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <h4 style="font-size: 16px; color: #083CAE; margin: 0 0 10px 0;">Descripción</h4>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6;">${data.descripcion || 'Sin descripción'}</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Información del Proyecto</div>
                            <div><span style="color: #6c757d;">Proyecto:</span> ${data.proyecto || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Creado por:</span> ${data.creador || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Última revisión:</span> ${data.ultima_revision_por || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Aprobado por:</span> ${data.aprobado_por || 'N/A'}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                            <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Información Adicional</div>
                            <div><span style="color: #6c757d;">Subdisciplina:</span> ${data.subdisciplina || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Versión actual:</span> ${data.version_actual ? data.version_actual.version : 'N/A'}</div>
                            <div><span style="color: #6c757d;">Fecha creación:</span> ${data.created_at || 'N/A'}</div>
                            <div><span style="color: #6c757d;">Última actualización:</span> ${data.updated_at || 'N/A'}</div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                        ${data.documento_path ? `<button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarDocumento(${data.id}, 'plano')"><i class="fas fa-download"></i> Descargar ${data.formato || 'PDF'}</button>` : ''}
                        <button style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalPlano()">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('planoDetalleContent').innerHTML = html;
                document.getElementById('modalVerPlano').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
            } catch (error) {
                console.error('❌ Error al cargar detalle:', error);
                alert('Error al cargar el detalle del plano');
            }
        };

        window.descargarDocumento = function(id, tipo) {
            window.open(`/proyectos/documentos-api/descargar/${id}?tipo=${tipo}`, '_blank');
        };

        window.verHistorial = async function(tipo, id) {
            try {
                document.querySelectorAll('.documentos-tab').forEach(tab => {
                    tab.classList.remove('active');
                    tab.style.backgroundColor = '#e9ecef';
                    tab.style.color = '#495057';
                });
                document.querySelector('[data-tab="historial"]').classList.add('active');
                document.querySelector('[data-tab="historial"]').style.backgroundColor = '#083CAE';
                document.querySelector('[data-tab="historial"]').style.color = 'white';
                
                document.querySelectorAll('.documentos-content').forEach(content => content.style.display = 'none');
                document.getElementById('tab-historial').style.display = 'block';
                
                const response = await fetch(`/proyectos/documentos-api/versiones?tipo=${tipo}&id=${id}`);
                if (!response.ok) throw new Error('Error al cargar historial');
                
                const data = await response.json();
                const versiones = data.data || [];
                
                const container = document.getElementById('timelineVersiones');
                
                if (!versiones || versiones.length === 0) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-info-circle" style="font-size: 32px;"></i>
                            <p style="margin-top: 10px;">No hay versiones registradas para este documento</p>
                        </div>
                    `;
                    return;
                }
                
                let html = '<div style="position: relative; padding-left: 30px;">';
                html += '<div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>';
                
                versiones.forEach((version, index) => {
                    const isActual = version.es_actual;
                    const icon = isActual ? 'fa-check' : (index === 0 ? 'fa-file' : 'fa-pencil-alt');
                    const color = isActual ? '#28a745' : (index === 0 ? '#6c757d' : '#ffc107');
                    
                    html += `
                        <div style="position: relative; margin-bottom: 25px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas ${icon}"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="background-color: ${color}; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 600;">${version.version || 'N/A'}</span>
                                        ${isActual ? '<span style="margin-left: 10px; font-weight: 600; color: #28a745;">Actual</span>' : ''}
                                    </div>
                                    <span style="color: #6c757d;">${version.fecha_version || 'N/A'}</span>
                                </div>
                                <p style="margin: 10px 0 0; font-size: 13px;">${version.cambios || 'Sin cambios registrados'}</p>
                                <div style="margin-top: 10px; display: flex; gap: 15px;">
                                    <span style="font-size: 12px;"><i class="fas fa-user"></i> ${version.usuario || 'N/A'}</span>
                                    <span style="font-size: 12px;"><i class="fas fa-file"></i> ${version.tamanio_formateado || '0 B'}</span>
                                </div>
                                <div style="margin-top: 10px; display: flex; gap: 10px;">
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;" onclick="descargarVersion(${version.id})"></i>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
                
            } catch (error) {
                console.error('❌ Error al cargar historial:', error);
                document.getElementById('timelineVersiones').innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #dc3545;">
                        <i class="fas fa-exclamation-circle" style="font-size: 32px;"></i>
                        <p style="margin-top: 10px;">Error al cargar el historial</p>
                    </div>
                `;
            }
        };

        window.descargarVersion = function(id) {
            window.open(`/proyectos/documentos-api/version/${id}/descargar`, '_blank');
        };

        window.cerrarModalContrato = function() {
            document.getElementById('modalVerContrato').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        window.cerrarModalPlano = function() {
            document.getElementById('modalVerPlano').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        // ════════════════════════════════════════════════════════════════
        // EVENT LISTENERS
        // ════════════════════════════════════════════════════════════════

        const documentTabs = document.querySelectorAll('.documentos-tab');
        const documentContents = document.querySelectorAll('.documentos-content');
        const vistaPlanosControls = document.getElementById('vistaPlanosControls');

        documentTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                documentTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                documentContents.forEach(content => content.style.display = 'none');
                documentContents[index].style.display = 'block';
                
                if (index === 1) {
                    vistaPlanosControls.style.display = 'flex';
                } else {
                    vistaPlanosControls.style.display = 'none';
                }
            });
        });

        // Filtros
        document.getElementById('selectorProyecto')?.addEventListener('change', function() {
            cargarTodosLosDatos();
        });

        document.getElementById('selectorEstado')?.addEventListener('change', function() {
            cargarContratos(1);
        });

        document.getElementById('filtroDisciplina')?.addEventListener('change', function() {
            cargarPlanos(1);
        });

        document.getElementById('filtroRevision')?.addEventListener('change', function() {
            cargarPlanos(1);
        });

        let searchTimeout;
        document.getElementById('buscador')?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                cargarContratos(1);
                cargarPlanos(1);
            }, 500);
        });

        // Botones
        document.getElementById('btnSubirDocumento')?.addEventListener('click', function() {
            // Resetear formulario
            document.getElementById('modalTipoDoc').value = '';
            document.getElementById('modalDocumentoId').innerHTML = '<option value="">Seleccionar documento existente...</option>';
            document.getElementById('modalDocumentoIdHidden').value = '';
            document.getElementById('modalProyectoDoc').value = '';
            document.getElementById('modalProyectoIdHidden').value = '';
            document.getElementById('modalNumeroDoc').value = '';
            document.getElementById('modalNombreDoc').value = '';
            document.getElementById('modalDisciplinaDoc').value = '';
            document.getElementById('modalFechaDoc').value = '{{ date('Y-m-d') }}';
            document.getElementById('modalVersionDoc').value = 'v1.0';
            document.getElementById('modalCambiosDoc').value = '';
            fileInput.value = '';
            fileInfo.style.display = 'none';
            
            document.getElementById('modalSubirDocumento').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        document.getElementById('btnExcel')?.addEventListener('click', function() {
            const tipo = document.getElementById('selectorTipo').value || 'contratos';
            window.open(`/proyectos/documentos-api/exportar/excel?tipo=${tipo}`, '_blank');
        });

        // Vista de planos
        document.getElementById('btnVistaTabla')?.addEventListener('click', function() {
            document.getElementById('btnVistaTabla').classList.add('active');
            document.getElementById('btnVistaTabla').style.backgroundColor = '#083CAE';
            document.getElementById('btnVistaTabla').style.color = 'white';
            document.getElementById('btnVistaGaleria').classList.remove('active');
            document.getElementById('btnVistaGaleria').style.backgroundColor = 'transparent';
            document.getElementById('btnVistaGaleria').style.color = '#495057';
            document.getElementById('vistaGaleriaPlanos').style.display = 'none';
            document.getElementById('vistaTablaPlanos').style.display = 'block';
        });

        document.getElementById('btnVistaGaleria')?.addEventListener('click', function() {
            document.getElementById('btnVistaGaleria').classList.add('active');
            document.getElementById('btnVistaGaleria').style.backgroundColor = '#083CAE';
            document.getElementById('btnVistaGaleria').style.color = 'white';
            document.getElementById('btnVistaTabla').classList.remove('active');
            document.getElementById('btnVistaTabla').style.backgroundColor = 'transparent';
            document.getElementById('btnVistaTabla').style.color = '#495057';
            document.getElementById('vistaGaleriaPlanos').style.display = 'block';
            document.getElementById('vistaTablaPlanos').style.display = 'none';
        });

        // Paginación
        document.querySelector('.btn-paginacion-contratos:first-child')?.addEventListener('click', function() {
            if (currentPageContratos > 1) {
                cargarContratos(currentPageContratos - 1);
            }
        });

        document.querySelector('.btn-paginacion-contratos:last-child')?.addEventListener('click', function() {
            const lastPage = Math.ceil(totalContratos / rowsPerPageContratos);
            if (currentPageContratos < lastPage) {
                cargarContratos(currentPageContratos + 1);
            }
        });

        document.querySelector('.btn-paginacion-planos:first-child')?.addEventListener('click', function() {
            if (currentPagePlanos > 1) {
                cargarPlanos(currentPagePlanos - 1);
            }
        });

        document.querySelector('.btn-paginacion-planos:last-child')?.addEventListener('click', function() {
            const lastPage = Math.ceil(totalPlanos / rowsPerPagePlanos);
            if (currentPagePlanos < lastPage) {
                cargarPlanos(currentPagePlanos + 1);
            }
        });

        // Historial
        document.getElementById('btnVerHistorial')?.addEventListener('click', function() {
            const value = document.getElementById('selectorDocumento').value;
            if (value) {
                const [tipo, id] = value.split('_');
                verHistorial(tipo, id);
            } else {
                alert('Por favor seleccione un documento');
            }
        });

        // ════════════════════════════════════════════════════════════════
        // MODAL SUBIR DOCUMENTO - FUNCIONALIDAD COMPLETA
        // ════════════════════════════════════════════════════════════════

        const modalSubir = document.getElementById('modalSubirDocumento');
        const btnCerrarModal = document.getElementById('btnCerrarModalSubir');
        const btnCancelar = document.getElementById('btnCancelarSubir');

        function cerrarModalSubir() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        btnCerrarModal?.addEventListener('click', cerrarModalSubir);
        btnCancelar?.addEventListener('click', cerrarModalSubir);

        // Cargar documentos existentes al cambiar tipo o proyecto
        document.getElementById('modalTipoDoc')?.addEventListener('change', cargarDocumentosExistentes);
        document.getElementById('modalProyectoDoc')?.addEventListener('change', cargarDocumentosExistentes);

        function cargarDocumentosExistentes() {
            const tipo = document.getElementById('modalTipoDoc').value;
            const proyectoId = document.getElementById('modalProyectoDoc').value;
            const selector = document.getElementById('modalDocumentoId');
            const hiddenInput = document.getElementById('modalDocumentoIdHidden');
            
            selector.innerHTML = '<option value="">Seleccionar documento existente...</option>';
            hiddenInput.value = '';
            
            if (!tipo || !proyectoId) {
                return;
            }
            
            const url = tipo === 'contrato' 
                ? `/proyectos/documentos-api/contratos?per_page=100&proyecto_id=${proyectoId}` 
                : `/proyectos/documentos-api/planos?per_page=100&proyecto_id=${proyectoId}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const documentos = data.data || [];
                    
                    if (documentos.length === 0) {
                        selector.innerHTML = '<option value="">No hay documentos disponibles en este proyecto</option>';
                        return;
                    }
                    
                    documentos.forEach(doc => {
                        const option = document.createElement('option');
                        option.value = doc.id;
                        if (tipo === 'contrato') {
                            option.textContent = `${doc.no_contrato} - ${doc.proyecto} (${doc.estado})`;
                        } else {
                            option.textContent = `${doc.no_plano} - ${doc.nombre} (${doc.estado})`;
                        }
                        selector.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('❌ Error al cargar documentos:', error);
                    selector.innerHTML = '<option value="">Error al cargar documentos</option>';
                });
        }

        // Sincronizar selector con hidden input
        document.getElementById('modalDocumentoId')?.addEventListener('change', function() {
            document.getElementById('modalDocumentoIdHidden').value = this.value;
        });

        // Drag and drop para subir archivos
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

        // ✅ SUBIR ARCHIVO - FUNCIÓN PRINCIPAL
        document.getElementById('btnSubirArchivo')?.addEventListener('click', async function() {
            const tipo = document.getElementById('modalTipoDoc').value;
            const documentoId = document.getElementById('modalDocumentoIdHidden').value || document.getElementById('modalDocumentoId').value;
            const proyectoId = document.getElementById('modalProyectoDoc').value;
            const noDocumento = document.getElementById('modalNumeroDoc').value;
            const nombre = document.getElementById('modalNombreDoc').value;
            const disciplina = document.getElementById('modalDisciplinaDoc').value;
            const fecha = document.getElementById('modalFechaDoc').value;
            const version = document.getElementById('modalVersionDoc').value || 'v1.0';
            const cambios = document.getElementById('modalCambiosDoc').value || 'Subida de archivo';
            const file = fileInput.files[0];

            console.log('📋 DATOS DEL FORMULARIO:');
            console.log('  - Tipo:', tipo);
            console.log('  - Documento ID:', documentoId || 'Nuevo');
            console.log('  - Proyecto ID:', proyectoId);
            console.log('  - Número Documento:', noDocumento);
            console.log('  - Nombre:', nombre);
            console.log('  - Disciplina:', disciplina);
            console.log('  - Fecha:', fecha);
            console.log('  - Versión:', version);
            console.log('  - Cambios:', cambios);
            console.log('  - Archivo:', file ? file.name : '❌ NINGUNO');

            // Validaciones
            if (!tipo) {
                alert('❌ Por favor seleccione un tipo de documento');
                return;
            }

            if (!proyectoId) {
                alert('❌ Por favor seleccione un proyecto');
                return;
            }

            if (!noDocumento) {
                alert('❌ Por favor ingrese el número/identificador del documento');
                return;
            }

            if (!nombre) {
                alert('❌ Por favor ingrese el nombre/descripción del documento');
                return;
            }

            if (!file) {
                alert('❌ Por favor seleccione un archivo');
                return;
            }

            // Crear FormData
            const formData = new FormData();
            formData.append('tipo', tipo);
            if (documentoId && documentoId !== '') {
                formData.append('id', documentoId.toString());
            }
            formData.append('proyecto_id', proyectoId);
            formData.append('no_documento', noDocumento);
            formData.append('nombre', nombre);
            if (disciplina) formData.append('disciplina', disciplina);
            formData.append('fecha', fecha);
            formData.append('version', version);
            formData.append('cambios', cambios);
            formData.append('archivo', file);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            try {
                const response = await fetch('/proyectos/documentos-api/subir', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: formData
                });

                const result = await response.json();
                console.log('📥 Respuesta:', result);

                if (result.success) {
                    alert('✅ Documento subido correctamente');
                    cerrarModalSubir();
                    cargarTodosLosDatos();
                } else {
                    alert('❌ Error: ' + (result.message || 'Error al subir el documento'));
                }
            } catch (error) {
                console.error('❌ Error al subir documento:', error);
                alert('❌ Error al subir el documento: ' + error.message);
            }
        });

        // Cerrar modales con click fuera
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('modalSubirDocumento')) {
                cerrarModalSubir();
            }
            if (event.target === document.getElementById('modalVerContrato')) {
                window.cerrarModalContrato();
            }
            if (event.target === document.getElementById('modalVerPlano')) {
                window.cerrarModalPlano();
            }
        });

        // Cargar datos iniciales
        cargarTodosLosDatos();

        // Exponer funciones globales
        window.cargarTodosLosDatos = cargarTodosLosDatos;
        window.cargarContratos = cargarContratos;
        window.cargarPlanos = cargarPlanos;
    });
</script>
@endsection