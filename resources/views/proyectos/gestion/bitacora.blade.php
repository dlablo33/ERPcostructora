@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Bitácora de Obra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Bitácora de Obra
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y controles principales -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Selector de proyecto -->
                        <div>
                            <select id="selectorProyecto" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 250px;">
                                <option value="">Todos los proyectos</option>
                                <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                                <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                                <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                                <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                                <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                                <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
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
                            <input type="date" id="fechaInicio" value="2026-03-01" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <span style="color: #6c757d;">a</span>
                            <input type="date" id="fechaFin" value="2026-03-31" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>

                        <!-- Botones de acción -->
                        <button id="btnNuevaEntrada" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
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

                <!-- Resumen de bitácora -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-alt" style="color: #083CAE;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Total Entradas</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;">248</div>
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
                                <div style="font-size: 24px; font-weight: bold; color: #28a745;">156</div>
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
                                <div style="font-size: 24px; font-weight: bold; color: #ffc107;">42</div>
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
                                <div style="font-size: 24px; font-weight: bold; color: #dc3545;">18</div>
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

                <!-- SECCIÓN 1: REGISTROS DE BITÁCORA -->
                <div id="tab-registros" class="bitacora-content active">
                    <!-- Filtros rápidos -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos los responsables</option>
                                <option value="juan">Juan Pérez</option>
                                <option value="maria">María García</option>
                                <option value="carlos">Carlos Rodríguez</option>
                                <option value="ana">Ana Martínez</option>
                            </select>
                            <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
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

                    <!-- Lista de entradas de bitácora -->
                    <div class="timeline" style="position: relative; padding-left: 30px;">
                        <!-- Línea de tiempo vertical -->
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>
                        
                        <!-- Entrada 1 -->
                        <div class="timeline-item" style="position: relative; margin-bottom: 30px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #083CAE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; z-index: 2;">
                                <i class="fas fa-sun"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                        <span style="background-color: #083CAE; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">PRO-2024-001</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-calendar"></i> 10/03/2026</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-clock"></i> 08:30 hrs</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="fas fa-user"></i> Juan Pérez</span>
                                    </div>
                                    <div>
                                        <span style="background-color: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Actividad</span>
                                    </div>
                                </div>
                                
                                <h4 style="font-size: 16px; font-weight: 600; color: #083CAE; margin: 0 0 10px 0;">Inicio de Cimentación - Torre Norte</h4>
                                
                                <p style="font-size: 14px; color: #495057; line-height: 1.6; margin-bottom: 15px;">
                                    Se iniciaron los trabajos de cimentación en el sector norte de la torre. Se realizó la excavación de 5 pozos para zapatas corridas. 
                                    El personal trabajó sin incidentes. Se requiere supervisión adicional para el colado programado para mañana.
                                </p>
                                
                                <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                                    <div style="font-size: 13px;">
                                        <strong style="color: #083CAE;">Personal:</strong> 12 obreros, 2 operadores
                                    </div>
                                    <div style="font-size: 13px;">
                                        <strong style="color: #083CAE;">Maquinaria:</strong> 1 retroexcavadora, 2 camiones
                                    </div>
                                    <div style="font-size: 13px;">
                                        <strong style="color: #083CAE;">Material:</strong> 20m³ concreto
                                    </div>
                                </div>
                                
                                <div style="display: flex; gap: 15px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                                    <button style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button style="background: none; border: none; color: #28a745; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-check-circle"></i> Cerrar
                                    </button>
                                    <button style="background: none; border: none; color: #ffc107; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-flag"></i> Marcar
                                    </button>
                                    <button style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </div>
                                
                                <!-- Comentarios -->
                                <div style="margin-top: 15px; background-color: #f8f9fa; border-radius: 4px; padding: 10px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                        <i class="fas fa-comment" style="color: #6c757d;"></i>
                                        <span style="font-weight: 600; font-size: 13px;">Comentarios (2)</span>
                                    </div>
                                    <div style="margin-left: 25px;">
                                        <div style="margin-bottom: 8px;">
                                            <span style="font-weight: 600; font-size: 12px;">María García:</span>
                                            <span style="font-size: 12px; color: #495057;"> Revisar especificaciones técnicas antes del colado.</span>
                                            <span style="font-size: 11px; color: #6c757d; margin-left: 10px;">10:45 hrs</span>
                                        </div>
                                        <div>
                                            <span style="font-weight: 600; font-size: 12px;">Carlos Rodríguez:</span>
                                            <span style="font-size: 12px; color: #495057;"> Confirmado, ya se solicitó la revisión.</span>
                                            <span style="font-size: 11px; color: #6c757d; margin-left: 10px;">11:20 hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Entrada 2 (Incidencia) -->
                        <div class="timeline-item" style="position: relative; margin-bottom: 30px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; z-index: 2;">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                        <span style="background-color: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">PRO-2024-002</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-calendar"></i> 10/03/2026</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-clock"></i> 14:15 hrs</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="fas fa-user"></i> María García</span>
                                    </div>
                                    <div>
                                        <span style="background-color: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Incidencia</span>
                                    </div>
                                </div>
                                
                                <h4 style="font-size: 16px; font-weight: 600; color: #dc3545; margin: 0 0 10px 0;">Falla mecánica en retroexcavadora</h4>
                                
                                <p style="font-size: 14px; color: #495057; line-height: 1.6; margin-bottom: 15px;">
                                    La retroexcavadora #RE-023 presentó falla en el sistema hidráulico durante los trabajos de excavación. 
                                    Se detuvieron las actividades en el sector sur. Se solicitó servicio de mantenimiento de emergencia.
                                </p>
                                
                                <div style="background-color: white; border-left: 3px solid #dc3545; padding: 10px; margin-bottom: 15px;">
                                    <strong style="font-size: 13px; color: #dc3545;">Acción tomada:</strong>
                                    <p style="font-size: 12px; margin: 5px 0 0 0;">Se contactó al taller mecánico. Tiempo estimado de reparación: 4 horas.</p>
                                </div>
                                
                                <div style="display: flex; gap: 15px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #ffc107;">
                                    <button style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button style="background: none; border: none; color: #28a745; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-check-circle"></i> Resolver
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Entrada 3 -->
                        <div class="timeline-item" style="position: relative; margin-bottom: 30px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; z-index: 2;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                        <span style="background-color: #28a745; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">PRO-2024-003</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-calendar"></i> 09/03/2026</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="far fa-clock"></i> 17:30 hrs</span>
                                        <span style="color: #6c757d; font-size: 13px;"><i class="fas fa-user"></i> Ana Martínez</span>
                                    </div>
                                    <div>
                                        <span style="background-color: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Actividad</span>
                                    </div>
                                </div>
                                
                                <h4 style="font-size: 16px; font-weight: 600; color: #28a745; margin: 0 0 10px 0;">Revisión de calidad - Estructuras metálicas</h4>
                                
                                <p style="font-size: 14px; color: #495057; line-height: 1.6; margin-bottom: 15px;">
                                    Se realizó la inspección de las estructuras metálicas recibidas para el parque industrial. 
                                    Todas las piezas cumplen con las especificaciones técnicas. Se autoriza el inicio del montaje para mañana.
                                </p>
                                
                                <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                                    <div style="font-size: 13px;">
                                        <strong style="color: #28a745;">Resultado:</strong> Aprobado
                                    </div>
                                    <div style="font-size: 13px;">
                                        <strong style="color: #28a745;">Lote:</strong> EM-2026-089
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
                        <div style="display: flex; gap: 5px;">
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">5</button>
                            <button style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-3 de 248 entradas</span>
                    </div>
                </div>

                <!-- SECCIÓN 2: INCIDENCIAS -->
                <div id="tab-incidencias" class="bitacora-content" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #083CAE; font-size: 18px; margin: 0;">
                            <i class="fas fa-exclamation-triangle"></i> Incidencias Reportadas
                        </h3>
                        <button style="padding: 8px 15px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-plus"></i> Reportar Incidencia
                        </button>
                    </div>

                    <!-- Tabla de incidencias -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1000px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dc3545;">
                                <tr>
                                    <th style="padding: 12px;">ID</th>
                                    <th style="padding: 12px;">Proyecto</th>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px;">Descripción</th>
                                    <th style="padding: 12px;">Responsable</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Prioridad</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>INC-001</strong></td>
                                    <td style="padding: 12px;">PRO-2024-002</td>
                                    <td style="padding: 12px;">10/03/2026</td>
                                    <td style="padding: 12px;">Mecánica</td>
                                    <td style="padding: 12px;">Falla en retroexcavadora</td>
                                    <td style="padding: 12px;">María García</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px;">Alta</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #fff3cd;">
                                    <td style="padding: 12px;"><strong>INC-002</strong></td>
                                    <td style="padding: 12px;">PRO-2024-001</td>
                                    <td style="padding: 12px;">09/03/2026</td>
                                    <td style="padding: 12px;">Personal</td>
                                    <td style="padding: 12px;">Falta de personal especializado</td>
                                    <td style="padding: 12px;">Juan Pérez</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En proceso</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                        <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>INC-003</strong></td>
                                    <td style="padding: 12px;">PRO-2024-005</td>
                                    <td style="padding: 12px;">08/03/2026</td>
                                    <td style="padding: 12px;">Material</td>
                                    <td style="padding: 12px;">Retraso en entrega de materiales</td>
                                    <td style="padding: 12px;">Luis Ramírez</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Resuelto</span></td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Media</span></td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: EVIDENCIA FOTOGRÁFICA -->
                <div id="tab-fotografias" class="bitacora-content" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="color: #083CAE; font-size: 18px; margin: 0;">
                            <i class="fas fa-images"></i> Galería de Evidencias
                        </h3>
                        <button style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-upload"></i> Subir Fotos
                        </button>
                    </div>

                    <!-- Filtros de galería -->
                    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                        <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001">PRO-2024-001 - Torre Norte</option>
                            <option value="PRO-2024-002">PRO-2024-002 - Puente Sur</option>
                        </select>
                        <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las fechas</option>
                            <option value="hoy">Hoy</option>
                            <option value="semana">Esta semana</option>
                            <option value="mes">Este mes</option>
                        </select>
                    </div>

                    <!-- Grid de fotos -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        <!-- Foto 1 -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white;">
                            <div style="height: 150px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%); background-size: 20px 20px;">
                                <i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>
                            </div>
                            <div style="padding: 10px;">
                                <div style="font-weight: 600; font-size: 13px;">Cimentación Norte</div>
                                <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">PRO-2024-001 • 10/03/2026</div>
                                <div style="display: flex; gap: 10px;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 2 -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white;">
                            <div style="height: 150px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%); background-size: 20px 20px;">
                                <i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>
                            </div>
                            <div style="padding: 10px;">
                                <div style="font-weight: 600; font-size: 13px;">Instalación de Trabes</div>
                                <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">PRO-2024-002 • 09/03/2026</div>
                                <div style="display: flex; gap: 10px;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 3 -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white;">
                            <div style="height: 150px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%); background-size: 20px 20px;">
                                <i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>
                            </div>
                            <div style="padding: 10px;">
                                <div style="font-weight: 600; font-size: 13px;">Estructuras Metálicas</div>
                                <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">PRO-2024-003 • 09/03/2026</div>
                                <div style="display: flex; gap: 10px;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Foto 4 -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white;">
                            <div style="height: 150px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; background-image: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%); background-size: 20px 20px;">
                                <i class="fas fa-image" style="font-size: 48px; color: #adb5bd;"></i>
                            </div>
                            <div style="padding: 10px;">
                                <div style="font-weight: 600; font-size: 13px;">Revisión de Calidad</div>
                                <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">PRO-2024-001 • 08/03/2026</div>
                                <div style="display: flex; gap: 10px;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 4: REPORTES -->
                <div id="tab-reportes" class="bitacora-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Reporte de actividades -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Reporte de Actividades
                            </h4>
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                                <span style="color: #6c757d;">Gráfico de actividades por proyecto</span>
                            </div>
                        </div>

                        <!-- Reporte de incidencias -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #dc3545; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-exclamation-triangle"></i> Incidencias por Tipo
                            </h4>
                            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                                <span style="color: #6c757d;">Gráfico de incidencias</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reporte resumen -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-file-alt"></i> Resumen de Bitácora - Marzo 2026
                        </h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Total de entradas</div>
                                <div style="font-size: 24px; font-weight: bold; color: #083CAE;">248</div>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Actividades</div>
                                <div style="font-size: 24px; font-weight: bold; color: #28a745;">156</div>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Incidencias</div>
                                <div style="font-size: 24px; font-weight: bold; color: #dc3545;">42</div>
                            </div>
                        </div>
                        <div style="border-top: 1px solid #dee2e6; padding-top: 15px;">
                            <button style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
                                <i class="fas fa-download"></i> Descargar Reporte Completo
                            </button>
                            <button style="padding: 8px 15px; background-color: white; border: 1px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-envelope"></i> Enviar por Correo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nueva Entrada de Bitácora -->
<div id="modalNuevaEntrada" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nueva Entrada de Bitácora</h3>
            <button id="btnCerrarModalEntrada" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proyecto...</option>
                        <option value="PRO-2024-001">PRO-2024-001 - Torre Norte</option>
                        <option value="PRO-2024-002">PRO-2024-002 - Puente Sur</option>
                        <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo <span style="color: #dc3545;">*</span></label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="actividad">Actividad</option>
                        <option value="incidencia">Incidencia</option>
                        <option value="acuerdo">Acuerdo</option>
                        <option value="nota">Nota General</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha <span style="color: #dc3545;">*</span></label>
                    <input type="date" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Hora</label>
                    <input type="time" value="08:00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="juan">Juan Pérez</option>
                        <option value="maria">María García</option>
                        <option value="carlos">Carlos Rodríguez</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Título / Actividad <span style="color: #dc3545;">*</span></label>
                <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Inicio de cimentación">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción detallada <span style="color: #dc3545;">*</span></label>
                <textarea rows="4" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Describa las actividades realizadas, incidentes, acuerdos, etc."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Personal</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 12 obreros">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Maquinaria</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 2 retroexcavadoras">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Materiales</label>
                    <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 20m³ concreto">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Adjuntar imágenes</label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra imágenes aquí o <span style="color: #083CAE; cursor: pointer;">selecciona archivos</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">JPG, PNG hasta 10MB</p>
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarEntrada" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Entrada</button>
        </div>
    </div>
</div>

<style>
    .vista-btn, .tipo-bitacora-btn, .bitacora-tab {
        transition: all 0.3s ease;
    }
    
    .vista-btn:hover, .tipo-bitacora-btn:hover, .bitacora-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .vista-btn.active, .tipo-bitacora-btn.active, .bitacora-tab.active {
        background-color: #083CAE !important;
        color: white !important;
    }
    
    .resumen-card {
        transition: transform 0.2s;
    }
    
    .resumen-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .bitacora-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .timeline-item {
        transition: transform 0.2s;
    }
    
    .timeline-item:hover {
        transform: translateX(5px);
    }
    
    /* Estilos para la galería */
    [class*="grid-template-columns"] {
        transition: all 0.3s ease;
    }
    
    /* Scrollbar personalizada */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #052a6b;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .resumen-card {
            min-width: 100%;
        }
        
        .vista-btn, .tipo-bitacora-btn, .bitacora-tab {
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        
        #selectorProyecto {
            min-width: 100%;
        }
        
        .timeline {
            padding-left: 15px;
        }
        
        .timeline-item > div:first-child {
            left: -15px !important;
            width: 20px !important;
            height: 20px !important;
            font-size: 10px !important;
        }
        
        .timeline-item > div:last-child {
            margin-left: 10px !important;
            padding: 15px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Bitácora de Obra');
        
        // Elementos del DOM
        const tipoBitacoraBtns = document.querySelectorAll('.tipo-bitacora-btn');
        const bitacoraTabs = document.querySelectorAll('.bitacora-tab');
        const bitacoraContents = document.querySelectorAll('.bitacora-content');
        const btnNuevaEntrada = document.getElementById('btnNuevaEntrada');
        const modalNuevaEntrada = document.getElementById('modalNuevaEntrada');
        const btnCerrarModalEntrada = document.getElementById('btnCerrarModalEntrada');
        const btnCancelarEntrada = document.getElementById('btnCancelarEntrada');
        const btnExportarPDF = document.getElementById('btnExportarPDF');
        const btnImprimir = document.getElementById('btnImprimir');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const buscadorBitacora = document.getElementById('buscadorBitacora');
        
        // Cambiar tipo de bitácora (Diaria/Semanal/Mensual)
        tipoBitacoraBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tipoBitacoraBtns.forEach(b => {
                    b.classList.remove('active');
                    b.style.backgroundColor = 'transparent';
                    b.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                alert(`Cambiando a vista ${this.textContent.trim()}`);
            });
        });
        
        // Cambiar entre pestañas de bitácora
        bitacoraTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                bitacoraTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                bitacoraContents.forEach(content => content.style.display = 'none');
                bitacoraContents[index].style.display = 'block';
            });
        });
        
        // Modal nueva entrada
        if (btnNuevaEntrada) {
            btnNuevaEntrada.addEventListener('click', function() {
                modalNuevaEntrada.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        function cerrarModalEntrada() {
            modalNuevaEntrada.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModalEntrada) {
            btnCerrarModalEntrada.addEventListener('click', cerrarModalEntrada);
        }
        
        if (btnCancelarEntrada) {
            btnCancelarEntrada.addEventListener('click', cerrarModalEntrada);
        }
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalNuevaEntrada) {
                cerrarModalEntrada();
            }
        });
        
        // Exportar PDF
        if (btnExportarPDF) {
            btnExportarPDF.addEventListener('click', function() {
                alert('Generando PDF de la bitácora...');
            });
        }
        
        // Imprimir
        if (btnImprimir) {
            btnImprimir.addEventListener('click', function() {
                window.print();
            });
        }
        
        // Selector de proyecto
        if (selectorProyecto) {
            selectorProyecto.addEventListener('change', function() {
                alert(`Filtrando bitácora por: ${this.value || 'Todos los proyectos'}`);
            });
        }
        
        // Fechas
        if (fechaInicio && fechaFin) {
            fechaInicio.addEventListener('change', function() {
                console.log('Fecha inicio:', this.value);
            });
            
            fechaFin.addEventListener('change', function() {
                console.log('Fecha fin:', this.value);
            });
        }
        
        // Buscador
        if (buscadorBitacora) {
            buscadorBitacora.addEventListener('input', function(e) {
                const busqueda = e.target.value.toLowerCase();
                console.log('Buscando:', busqueda);
                // Aquí iría la lógica de filtrado
            });
        }
        
        // Acciones en las entradas de bitácora
        document.querySelectorAll('.fa-edit, .fa-check-circle, .fa-flag, .fa-trash-alt, .fa-eye').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-edit')) {
                    alert('Editar entrada de bitácora');
                } else if (this.classList.contains('fa-check-circle')) {
                    alert('Marcar como completado');
                } else if (this.classList.contains('fa-flag')) {
                    alert('Marcar entrada');
                } else if (this.classList.contains('fa-trash-alt')) {
                    if (confirm('¿Está seguro de eliminar esta entrada?')) {
                        alert('Entrada eliminada');
                    }
                } else if (this.classList.contains('fa-eye')) {
                    alert('Ver detalles');
                }
            });
        });
        
        // Acciones en incidencias
        document.querySelectorAll('#tab-incidencias .fa-eye, #tab-incidencias .fa-check-circle').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-eye')) {
                    alert('Ver detalles de incidencia');
                } else if (this.classList.contains('fa-check-circle')) {
                    alert('Marcar incidencia como resuelta');
                }
            });
        });
        
        // Acciones en galería
        document.querySelectorAll('#tab-fotografias .fa-eye, #tab-fotografias .fa-download, #tab-fotografias .fa-trash').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-eye')) {
                    alert('Ver imagen ampliada');
                } else if (this.classList.contains('fa-download')) {
                    alert('Descargando imagen...');
                } else if (this.classList.contains('fa-trash')) {
                    if (confirm('¿Eliminar esta imagen?')) {
                        alert('Imagen eliminada');
                    }
                }
            });
        });
        
        // Botones de paginación
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.querySelector('.fa-chevron-left')) {
                    console.log('Página anterior');
                } else if (this.querySelector('.fa-chevron-right')) {
                    console.log('Página siguiente');
                } else {
                    document.querySelectorAll('.pagination-btn').forEach(b => {
                        if (!b.querySelector('i')) {
                            b.style.backgroundColor = 'white';
                            b.style.color = '#495057';
                        }
                    });
                    this.style.backgroundColor = '#083CAE';
                    this.style.color = 'white';
                }
            });
        });
        
        // Botones de reportes
        document.querySelectorAll('#tab-reportes button').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.textContent.includes('Descargar')) {
                    alert('Descargando reporte...');
                } else if (this.textContent.includes('Enviar')) {
                    alert('Enviando reporte por correo...');
                }
            });
        });
        
        // Inicializar tooltips (simulados)
        const tooltips = document.querySelectorAll('[title]');
        tooltips.forEach(el => {
            el.addEventListener('mouseenter', function(e) {
                // Simulación de tooltip
            });
        });
    });
</script>
@endsection