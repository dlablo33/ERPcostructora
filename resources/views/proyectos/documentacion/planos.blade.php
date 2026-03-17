@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Contratos y Planos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Contratos y Planos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE DOCUMENTOS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Contratos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Contratos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalContratos">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Total Planos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Planos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPlanos">156</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Contratos Vigentes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Contratos Vigentes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="contratosVigentes">18</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Planos Aprobados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Planos Aprobados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="planosAprobados">98</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                            <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                            <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                            <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                            <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                            <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                        </select>

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los tipos</option>
                            <option value="contrato">Contratos</option>
                            <option value="plano">Planos</option>
                        </select>

                        <select id="selectorEstado" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los estados</option>
                            <option value="vigente">Vigente</option>
                            <option value="revision">En Revisión</option>
                            <option value="aprobado">Aprobado</option>
                            <option value="vencido">Vencido</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Subir Documento -->
                        <div>
                            <button id="btnSubirDocumento" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Subir Documento">
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

                        <!-- Botón Vista para Planos -->
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px; display: none;" id="vistaPlanosControls">
                            <button id="btnVistaTabla" class="vista-btn active" style="padding: 6px 12px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-table"></i>
                            </button>
                            <button id="btnVistaGaleria" class="vista-btn" style="padding: 6px 12px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar documento..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de secciones -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="documentos-tab active" data-tab="contratos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-file-signature"></i> Contratos
                        <span style="background-color: #28a745; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">24</span>
                    </button>
                    <button class="documentos-tab" data-tab="planos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-draw-polygon"></i> Planos
                        <span style="background-color: #17a2b8; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">156</span>
                    </button>
                    <button class="documentos-tab" data-tab="historial" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-history"></i> Historial de Versiones
                    </button>
                </div>

                <!-- SECCIÓN 1: CONTRATOS (Vista Tabla) -->
                <div id="tab-contratos" class="documentos-content active">
                    <!-- Vista de Tabla para Contratos -->
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
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CON-2024-001</strong></td>
                                        <td style="padding: 12px;">Torre Norte Corporativa</td>
                                        <td style="padding: 12px;">Inmobiliaria del Sur</td>
                                        <td style="padding: 12px;">15/01/2024</td>
                                        <td style="padding: 12px;">15/12/2024</td>
                                        <td style="padding: 12px; text-align: right;">$45,500,000</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Vigente</span></td>
                                        <td style="padding: 12px;">v2.0</td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>
                                        </td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver contrato" onclick="verContrato('CON-2024-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" title="Descargar" onclick="descargarDocumento('CON-2024-001')"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Ver historial" onclick="verHistorial('CON-2024-001')"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CON-2024-002</strong></td>
                                        <td style="padding: 12px;">Puente Vehicular Sur</td>
                                        <td style="padding: 12px;">Gobierno Regional</td>
                                        <td style="padding: 12px;">01/02/2024</td>
                                        <td style="padding: 12px;">30/11/2024</td>
                                        <td style="padding: 12px; text-align: right;">$28,750,000</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Vigente</span></td>
                                        <td style="padding: 12px;">v1.0</td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>
                                        </td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verContrato('CON-2024-002')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CON-2024-003</strong></td>
                                        <td style="padding: 12px;">Parque Industrial Norte</td>
                                        <td style="padding: 12px;">Constructora ABC</td>
                                        <td style="padding: 12px;">10/03/2024</td>
                                        <td style="padding: 12px;">10/03/2025</td>
                                        <td style="padding: 12px; text-align: right;">$52,300,000</td>
                                        <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En Revisión</span></td>
                                        <td style="padding: 12px;">v2.1</td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>
                                        </td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verContrato('CON-2024-003')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CON-2023-004</strong></td>
                                        <td style="padding: 12px;">Hospital Regional</td>
                                        <td style="padding: 12px;">Ministerio de Salud</td>
                                        <td style="padding: 12px;">01/09/2023</td>
                                        <td style="padding: 12px;">30/04/2024</td>
                                        <td style="padding: 12px; text-align: right;">$78,900,000</td>
                                        <td style="padding: 12px;"><span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px;">Vencido</span></td>
                                        <td style="padding: 12px;">v1.0</td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>
                                        </td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verContrato('CON-2023-004')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>CON-2024-005</strong></td>
                                        <td style="padding: 12px;">Planta Tratamiento</td>
                                        <td style="padding: 12px;">Minera del Norte</td>
                                        <td style="padding: 12px;">15/01/2024</td>
                                        <td style="padding: 12px;">15/10/2024</td>
                                        <td style="padding: 12px; text-align: right;">$34,200,000</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Vigente</span></td>
                                        <td style="padding: 12px;">v1.2</td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 16px;"></i>
                                        </td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verContrato('CON-2024-005')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; margin: 0 5px;"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">5</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-5 de 24 contratos</span>
                    </div>
                </div>

                <!-- SECCIÓN 2: PLANOS (Con opciones de visualización) -->
                <div id="tab-planos" class="documentos-content" style="display: none;">
                    <!-- Filtros de planos -->
                    <div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <select id="filtroDisciplina" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las disciplinas</option>
                            <option value="arquitectura">Arquitectura</option>
                            <option value="estructura">Estructura</option>
                            <option value="instalaciones">Instalaciones</option>
                            <option value="electricas">Eléctricas</option>
                            <option value="hidraulicas">Hidráulicas</option>
                        </select>
                        <select id="filtroRevision" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todas las revisiones</option>
                            <option value="aprobado">Aprobado</option>
                            <option value="revision">En Revisión</option>
                            <option value="pendiente">Pendiente</option>
                        </select>
                        <select id="filtroProyectoPlanos" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                            <option value="">Todos los proyectos</option>
                            <option value="torre">Torre Norte</option>
                            <option value="puente">Puente Sur</option>
                            <option value="parque">Parque Industrial</option>
                        </select>
                    </div>

                    <!-- Vista de planos (Galería) -->
                    <div id="vistaGaleriaPlanos" style="display: block;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <!-- Plano 1 - Arquitectura -->
                            <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer;" onclick="verPlanoAmpliado('A-001')">
                                    <!-- Simulación de vista previa del plano -->
                                    <svg width="100%" height="100%" viewBox="0 0 300 200" style="background-color: white;">
                                        <!-- Cuadrícula de fondo -->
                                        <rect width="300" height="200" fill="#f8f9fa"/>
                                        <line x1="0" y1="0" x2="300" y2="200" stroke="#dee2e6" stroke-width="0.5"/>
                                        <line x1="300" y1="0" x2="0" y2="200" stroke="#dee2e6" stroke-width="0.5"/>
                                        <!-- Elementos del plano -->
                                        <rect x="50" y="30" width="80" height="60" fill="none" stroke="#083CAE" stroke-width="2"/>
                                        <rect x="150" y="30" width="80" height="60" fill="none" stroke="#083CAE" stroke-width="2"/>
                                        <rect x="100" y="100" width="100" height="40" fill="none" stroke="#28a745" stroke-width="2"/>
                                        <circle cx="150" cy="70" r="15" fill="none" stroke="#ffc107" stroke-width="2"/>
                                        <text x="20" y="180" fill="#083CAE" font-size="10">A-001 - Planta Arquitectónica</text>
                                    </svg>
                                    <!-- Badge de estado -->
                                    <span style="position: absolute; top: 10px; right: 10px; background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Aprobado</span>
                                </div>
                                <div style="padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 16px;">A-001</span>
                                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Rev. 3</span>
                                    </div>
                                    <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">Planta Arquitectónica</div>
                                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Proyecto: Torre Norte</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; color: #6c757d;">15/03/2026</span>
                                        <div style="display: flex; gap: 10px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlanoAmpliado('A-001')" title="Ver plano"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarPlano('A-001')" title="Descargar"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('A-001')" title="Historial"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plano 2 - Estructural -->
                            <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer;" onclick="verPlanoAmpliado('E-001')">
                                    <svg width="100%" height="100%" viewBox="0 0 300 200" style="background-color: white;">
                                        <rect width="300" height="200" fill="#f8f9fa"/>
                                        <!-- Elementos estructurales -->
                                        <line x1="30" y1="30" x2="270" y2="30" stroke="#083CAE" stroke-width="3"/>
                                        <line x1="30" y1="30" x2="30" y2="170" stroke="#083CAE" stroke-width="3"/>
                                        <line x1="270" y1="30" x2="270" y2="170" stroke="#083CAE" stroke-width="3"/>
                                        <line x1="30" y1="170" x2="270" y2="170" stroke="#083CAE" stroke-width="3"/>
                                        <line x1="30" y1="100" x2="270" y2="100" stroke="#28a745" stroke-width="2" stroke-dasharray="5,5"/>
                                        <line x1="150" y1="30" x2="150" y2="170" stroke="#28a745" stroke-width="2" stroke-dasharray="5,5"/>
                                        <circle cx="150" cy="100" r="10" fill="none" stroke="#ffc107" stroke-width="2"/>
                                        <text x="20" y="190" fill="#083CAE" font-size="10">E-001 - Cimentación</text>
                                    </svg>
                                    <span style="position: absolute; top: 10px; right: 10px; background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">En Revisión</span>
                                </div>
                                <div style="padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 16px;">E-001</span>
                                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Rev. 2</span>
                                    </div>
                                    <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">Plano de Cimentación</div>
                                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Proyecto: Puente Sur</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; color: #6c757d;">14/03/2026</span>
                                        <div style="display: flex; gap: 10px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlanoAmpliado('E-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarPlano('E-001')"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('E-001')"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plano 3 - Instalación Eléctrica -->
                            <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer;" onclick="verPlanoAmpliado('I-001')">
                                    <svg width="100%" height="100%" viewBox="0 0 300 200" style="background-color: white;">
                                        <rect width="300" height="200" fill="#f8f9fa"/>
                                        <!-- Símbolos eléctricos -->
                                        <circle cx="50" cy="50" r="10" fill="#ffc107" stroke="#856404" stroke-width="1"/>
                                        <text x="45" y="55" fill="#856404" font-size="8">⚡</text>
                                        <circle cx="150" cy="50" r="10" fill="#ffc107" stroke="#856404" stroke-width="1"/>
                                        <circle cx="250" cy="50" r="10" fill="#ffc107" stroke="#856404" stroke-width="1"/>
                                        <line x1="50" y1="50" x2="150" y2="50" stroke="#083CAE" stroke-width="2"/>
                                        <line x1="150" y1="50" x2="250" y2="50" stroke="#083CAE" stroke-width="2"/>
                                        <rect x="120" y="120" width="60" height="30" fill="none" stroke="#28a745" stroke-width="2"/>
                                        <text x="140" y="140" fill="#28a745" font-size="8">Tablero</text>
                                        <text x="20" y="190" fill="#083CAE" font-size="10">I-001 - Instalación Eléctrica</text>
                                    </svg>
                                    <span style="position: absolute; top: 10px; right: 10px; background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Aprobado</span>
                                </div>
                                <div style="padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 16px;">I-001</span>
                                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Rev. 1</span>
                                    </div>
                                    <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">Instalación Eléctrica</div>
                                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Proyecto: Hospital Regional</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; color: #6c757d;">12/03/2026</span>
                                        <div style="display: flex; gap: 10px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlanoAmpliado('I-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarPlano('I-001')"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('I-001')"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plano 4 - Instalación Hidráulica -->
                            <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer;" onclick="verPlanoAmpliado('H-001')">
                                    <svg width="100%" height="100%" viewBox="0 0 300 200" style="background-color: white;">
                                        <rect width="300" height="200" fill="#f8f9fa"/>
                                        <!-- Tuberías -->
                                        <path d="M30 80 L130 80 L130 140 L230 140" stroke="#0d6efd" stroke-width="3" fill="none"/>
                                        <circle cx="80" cy="80" r="8" fill="#0d6efd" opacity="0.3"/>
                                        <circle cx="180" cy="140" r="8" fill="#0d6efd" opacity="0.3"/>
                                        <circle cx="80" cy="80" r="4" fill="#0d6efd"/>
                                        <circle cx="180" cy="140" r="4" fill="#0d6efd"/>
                                        <text x="50" y="60" fill="#0d6efd" font-size="8">Tubería principal</text>
                                        <text x="20" y="190" fill="#083CAE" font-size="10">H-001 - Instalación Hidráulica</text>
                                    </svg>
                                    <span style="position: absolute; top: 10px; right: 10px; background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">En Revisión</span>
                                </div>
                                <div style="padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 16px;">H-001</span>
                                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Rev. 2</span>
                                    </div>
                                    <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">Instalación Hidráulica</div>
                                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Proyecto: Parque Industrial</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; color: #6c757d;">10/03/2026</span>
                                        <div style="display: flex; gap: 10px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlanoAmpliado('H-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarPlano('H-001')"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('H-001')"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plano 5 - Detalles Constructivos -->
                            <div class="plano-card" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <div style="height: 200px; background-color: #f8f9fa; position: relative; cursor: pointer;" onclick="verPlanoAmpliado('D-001')">
                                    <svg width="100%" height="100%" viewBox="0 0 300 200" style="background-color: white;">
                                        <rect width="300" height="200" fill="#f8f9fa"/>
                                        <!-- Detalle constructivo -->
                                        <rect x="100" y="50" width="100" height="80" fill="none" stroke="#083CAE" stroke-width="2"/>
                                        <line x1="150" y1="50" x2="150" y2="130" stroke="#083CAE" stroke-width="1" stroke-dasharray="3,3"/>
                                        <line x1="100" y1="90" x2="200" y2="90" stroke="#083CAE" stroke-width="1" stroke-dasharray="3,3"/>
                                        <circle cx="150" cy="90" r="15" fill="none" stroke="#28a745" stroke-width="2"/>
                                        <text x="145" y="95" fill="#28a745" font-size="8">Ø</text>
                                        <text x="20" y="180" fill="#083CAE" font-size="10">D-001 - Detalles Constructivos</text>
                                    </svg>
                                    <span style="position: absolute; top: 10px; right: 10px; background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Aprobado</span>
                                </div>
                                <div style="padding: 15px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 600; font-size: 16px;">D-001</span>
                                        <span style="background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Rev. 4</span>
                                    </div>
                                    <div style="font-size: 14px; color: #495057; margin-bottom: 5px;">Detalles Constructivos</div>
                                    <div style="font-size: 12px; color: #6c757d; margin-bottom: 10px;">Proyecto: Torre Norte</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; color: #6c757d;">08/03/2026</span>
                                        <div style="display: flex; gap: 10px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 16px;" onclick="verPlanoAmpliado('D-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; font-size: 16px;" onclick="descargarPlano('D-001')"></i>
                                            <i class="fas fa-history" style="color: #ffc107; cursor: pointer; font-size: 16px;" onclick="verHistorial('D-001')"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vista de Tabla para Planos (alternativa) -->
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
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;">A-001</td>
                                        <td style="padding: 12px;">Planta Arquitectónica</td>
                                        <td style="padding: 12px;">Arquitectura</td>
                                        <td style="padding: 12px;">Torre Norte</td>
                                        <td style="padding: 12px;">Rev.3</td>
                                        <td style="padding: 12px;">15/03/2026</td>
                                        <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Aprobado</span></td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verPlanoAmpliado('A-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="descargarPlano('A-001')"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;">E-001</td>
                                        <td style="padding: 12px;">Cimentación</td>
                                        <td style="padding: 12px;">Estructura</td>
                                        <td style="padding: 12px;">Puente Sur</td>
                                        <td style="padding: 12px;">Rev.2</td>
                                        <td style="padding: 12px;">14/03/2026</td>
                                        <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">En Revisión</span></td>
                                        <td style="padding: 12px;">
                                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" onclick="verPlanoAmpliado('E-001')"></i>
                                            <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin: 0 5px;" onclick="descargarPlano('E-001')"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación para planos -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">2</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">3</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">4</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">5</button>
                            <button class="btn-paginacion" style="padding: 5px 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        <span style="color: #6c757d; font-size: 13px;">Mostrando 1-5 de 156 planos</span>
                    </div>
                </div>

                <!-- SECCIÓN 3: HISTORIAL DE VERSIONES -->
                <div id="tab-historial" class="documentos-content" style="display: none;">
                    <!-- Selector de documento -->
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center; flex-wrap: wrap;">
                        <div style="min-width: 300px;">
                            <select id="selectorDocumento" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                                <option value="">Seleccionar documento...</option>
                                <option value="CON-2024-001">CON-2024-001 - Contrato Torre Norte</option>
                                <option value="A-001">A-001 - Planta Arquitectónica</option>
                                <option value="E-001">E-001 - Plano de Cimentación</option>
                            </select>
                        </div>
                        <div>
                            <button id="btnVerHistorial" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 10px 20px; cursor: pointer;">
                                <i class="fas fa-history"></i> Ver historial
                            </button>
                        </div>
                    </div>

                    <!-- Línea de tiempo de versiones -->
                    <div id="timelineVersiones" style="position: relative; padding-left: 30px;">
                        <!-- Línea vertical -->
                        <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #083CAE; opacity: 0.3;"></div>

                        <!-- Versión 2.0 -->
                        <div style="position: relative; margin-bottom: 25px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 600;">v2.0</span>
                                        <span style="margin-left: 10px; font-weight: 600;">Actual</span>
                                    </div>
                                    <span style="color: #6c757d;">15/03/2026 10:30</span>
                                </div>
                                <p style="margin: 10px 0 0; font-size: 13px;">
                                    Se actualizaron las especificaciones técnicas de cimentación según revisión estructural.
                                </p>
                                <div style="margin-top: 10px; display: flex; gap: 15px;">
                                    <span style="font-size: 12px;"><i class="fas fa-user"></i> Juan Pérez</span>
                                    <span style="font-size: 12px;"><i class="fas fa-file-pdf"></i> 2.4 MB</span>
                                </div>
                                <div style="margin-top: 10px; display: flex; gap: 10px;">
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;" onclick="descargarVersion('CON-2024-001', 'v2.0')"></i>
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verVersion('CON-2024-001', 'v2.0')"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Versión 1.5 -->
                        <div style="position: relative; margin-bottom: 25px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #ffc107; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px; font-weight: 600;">v1.5</span>
                                    </div>
                                    <span style="color: #6c757d;">10/03/2026 14:15</span>
                                </div>
                                <p style="margin: 10px 0 0; font-size: 13px;">
                                    Revisión de planos estructurales, correcciones menores.
                                </p>
                                <div style="margin-top: 10px; display: flex; gap: 15px;">
                                    <span style="font-size: 12px;"><i class="fas fa-user"></i> María García</span>
                                    <span style="font-size: 12px;"><i class="fas fa-file-pdf"></i> 2.1 MB</span>
                                </div>
                                <div style="margin-top: 10px; display: flex; gap: 10px;">
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;" onclick="descargarVersion('CON-2024-001', 'v1.5')"></i>
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verVersion('CON-2024-001', 'v1.5')"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Versión 1.0 -->
                        <div style="position: relative; margin-bottom: 25px;">
                            <div style="position: absolute; left: -30px; top: 0; width: 30px; height: 30px; background-color: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-file"></i>
                            </div>
                            <div style="margin-left: 20px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 600;">v1.0</span>
                                    </div>
                                    <span style="color: #6c757d;">05/03/2026 09:00</span>
                                </div>
                                <p style="margin: 10px 0 0; font-size: 13px;">
                                    Versión inicial del documento.
                                </p>
                                <div style="margin-top: 10px; display: flex; gap: 15px;">
                                    <span style="font-size: 12px;"><i class="fas fa-user"></i> Carlos Rodríguez</span>
                                    <span style="font-size: 12px;"><i class="fas fa-file-pdf"></i> 2.0 MB</span>
                                </div>
                                <div style="margin-top: 10px; display: flex; gap: 10px;">
                                    <i class="fas fa-download" style="color: #28a745; cursor: pointer;" onclick="descargarVersion('CON-2024-001', 'v1.0')"></i>
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verVersion('CON-2024-001', 'v1.0')"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Subir Documento -->
<div id="modalSubirDocumento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-cloud-upload-alt"></i> Subir Nuevo Documento</h3>
            <button id="btnCerrarModalSubir" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
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
                    <option value="">Seleccionar...</option>
                    <option value="PRO-2024-001">PRO-2024-001 - Torre Norte</option>
                    <option value="PRO-2024-002">PRO-2024-002 - Puente Sur</option>
                    <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Número/Identificador <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalNumeroDoc" placeholder="Ej: CON-2024-001, A-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <input type="text" id="modalDescripcionDoc" placeholder="Breve descripción del documento" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Versión</label>
                <input type="text" id="modalVersionDoc" placeholder="v1.0" value="v1.0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha del Documento</label>
                <input type="date" id="modalFechaDoc" value="2026-03-11" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo <span style="color: #dc3545;">*</span></label>
                <div style="border: 2px dashed #ced4da; border-radius: 4px; padding: 20px; text-align: center; background-color: #f8f9fa;">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #6c757d; margin-bottom: 10px;"></i>
                    <p style="margin: 0; font-size: 14px;">Arrastra el archivo aquí o <span style="color: #083CAE; cursor: pointer;" onclick="document.getElementById('fileInput').click()">selecciona</span></p>
                    <p style="font-size: 11px; color: #6c757d; margin: 5px 0 0;">PDF, DWG, DXF (Max. 50MB)</p>
                    <input type="file" id="fileInput" style="display: none;">
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarSubir" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnSubirArchivo" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Subir Documento</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Contrato -->
<div id="modalVerContrato" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 900px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalContratoTitulo">
                <i class="fas fa-file-contract"></i> Contrato CON-2024-001
            </h3>
            <button id="btnCerrarModalContrato" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Encabezado del contrato -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">Número de Contrato</div>
                    <div style="font-size: 24px; font-weight: 700; color: #083CAE;" id="contratoNumero">CON-2024-001</div>
                </div>
                <div>
                    <span style="background-color: #28a745; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="contratoEstadoBadge">Vigente</span>
                </div>
            </div>

            <!-- Información del contrato en tarjetas -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Proyecto</div>
                    <div style="font-size: 14px; font-weight: 600;" id="contratoProyecto">Torre Norte Corporativa</div>
                </div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">Cliente</div>
                    <div style="font-size: 14px; font-weight: 600;" id="contratoCliente">Inmobiliaria del Sur</div>
                </div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                    <div style="color: #6c757d; font-size: 11px; text-transform: uppercase;">RFC Cliente</div>
                    <div style="font-size: 14px;" id="contratoRFC">ISU890101ABC</div>
                </div>
            </div>

            <!-- Fechas y montos -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha de Firma</div>
                    <div style="font-size: 15px; font-weight: 600;" id="contratoFirma">15/01/2024</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha de Inicio</div>
                    <div style="font-size: 15px;" id="contratoInicio">15/01/2024</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Fecha de Fin</div>
                    <div style="font-size: 15px;" id="contratoFin">15/12/2024</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Días de Ejecución</div>
                    <div style="font-size: 15px; font-weight: 600;" id="contratoDuracion">335 días</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Monto Total</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="contratoMonto">$45,500,000</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Anticipo (30%)</div>
                    <div style="font-size: 16px;" id="contratoAnticipo">$13,650,000</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Saldo por Ejercer</div>
                    <div style="font-size: 16px;" id="contratoSaldo">$31,850,000</div>
                </div>
            </div>

            <!-- Responsables -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px;">
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Por el Contratante</div>
                    <div><span style="color: #6c757d;">Representante:</span> Lic. Roberto Méndez</div>
                    <div><span style="color: #6c757d;">Cargo:</span> Gerente de Proyectos</div>
                    <div><span style="color: #6c757d;">Email:</span> r.mendez@inmobiliariadelsur.com</div>
                </div>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <div style="color: #083CAE; font-weight: 600; margin-bottom: 10px;">Por el Contratista</div>
                    <div><span style="color: #6c757d;">Representante:</span> Ing. Juan Pérez</div>
                    <div><span style="color: #6c757d;">Cargo:</span> Director de Proyectos</div>
                    <div><span style="color: #6c757d;">Email:</span> j.perez@constructora.com</div>
                </div>
            </div>

            <!-- Descripción y alcance -->
            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 16px; color: #083CAE; margin: 0 0 10px 0;">Descripción y Alcance</h4>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <p style="margin: 0; font-size: 14px; line-height: 1.6;" id="contratoDescripcion">
                        Construcción de Torre Norte Corporativa de 25 niveles, incluyendo cimentación profunda, 
                        estructura de concreto, fachada, instalaciones eléctricas, hidrosanitarias y acabados. 
                        El proyecto incluye 3 niveles de estacionamiento subterráneo y áreas comunes.
                    </p>
                </div>
            </div>

            <!-- Condiciones y cláusulas -->
            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 16px; color: #083CAE; margin: 0 0 10px 0;">Condiciones y Cláusulas</h4>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 15px;">
                    <div style="margin-bottom: 10px;">
                        <strong>Forma de Pago:</strong> <span id="contratoFormaPago">Anticipo + Estimaciones mensuales</span>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Plazo de Pago:</strong> <span id="contratoPlazoPago">30 días posteriores a estimación</span>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Penalizaciones:</strong> <span id="contratoPenalizaciones">0.5% por día de retraso hasta 10% del contrato</span>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Garantías:</strong> <span id="contratoGarantias">Fianza de cumplimiento 20%</span>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <strong>Vigencia:</strong> <span id="contratoVigencia">15/01/2024 - 15/12/2024</span>
                    </div>
                </div>
            </div>

            <!-- Versiones y documentos -->
            <div style="margin-bottom: 25px;">
                <h4 style="font-size: 16px; color: #083CAE; margin: 0 0 10px 0;">Versiones del Documento</h4>
                <div style="border: 1px solid #dee2e6; border-radius: 6px; overflow: hidden;">
                    <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="padding: 10px; text-align: left;">Versión</th>
                                <th style="padding: 10px; text-align: left;">Fecha</th>
                                <th style="padding: 10px; text-align: left;">Cambios</th>
                                <th style="padding: 10px; text-align: left;">Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px;">v2.0</td>
                                <td style="padding: 10px;">15/03/2026</td>
                                <td style="padding: 10px;">Actualización de especificaciones</td>
                                <td style="padding: 10px;"><i class="fas fa-file-pdf" style="color: #dc3545;"></i></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px;">v1.5</td>
                                <td style="padding: 10px;">10/03/2026</td>
                                <td style="padding: 10px;">Revisión de alcance</td>
                                <td style="padding: 10px;"><i class="fas fa-file-pdf" style="color: #dc3545;"></i></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px;">v1.0</td>
                                <td style="padding: 10px;">15/01/2024</td>
                                <td style="padding: 10px;">Versión inicial</td>
                                <td style="padding: 10px;"><i class="fas fa-file-pdf" style="color: #dc3545;"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <button style="padding: 10px 20px; background-color: white; border: 1px solid #ffc107; color: #ffc107; border-radius: 4px; cursor: pointer;" onclick="alert('Editar contrato')">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarDocumento('CON-2024-001')">
                    <i class="fas fa-download"></i> Descargar PDF
                </button>
                <button style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalContrato()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Plano Ampliado -->
<div id="modalVerPlano" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 1000px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalPlanoTitulo">
                <i class="fas fa-draw-polygon"></i> Plano A-001 - Planta Arquitectónica
            </h3>
            <button id="btnCerrarModalPlano" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px; text-align: center;">
            <!-- Vista ampliada del plano -->
            <svg width="100%" height="500" viewBox="0 0 800 500" style="border: 1px solid #dee2e6; background-color: #f8f9fa;">
                <!-- Cuadrícula de fondo -->
                <rect width="800" height="500" fill="#f8f9fa"/>
                <line x1="0" y1="0" x2="800" y2="500" stroke="#dee2e6" stroke-width="0.5"/>
                <line x1="800" y1="0" x2="0" y2="500" stroke="#dee2e6" stroke-width="0.5"/>
                <!-- Elementos del plano (versión ampliada) -->
                <rect x="150" y="80" width="200" height="150" fill="none" stroke="#083CAE" stroke-width="3"/>
                <rect x="450" y="80" width="200" height="150" fill="none" stroke="#083CAE" stroke-width="3"/>
                <rect x="250" y="250" width="300" height="120" fill="none" stroke="#28a745" stroke-width="3"/>
                <circle cx="400" cy="180" r="40" fill="none" stroke="#ffc107" stroke-width="3"/>
                <text x="380" y="190" fill="#ffc107" font-size="14">Núcleo</text>
                <text x="200" y="400" fill="#083CAE" font-size="12">Escala 1:100</text>
                <text x="500" y="400" fill="#083CAE" font-size="12">Fecha: 15/03/2026</text>
            </svg>
            
            <!-- Información del plano -->
            <div style="display: flex; justify-content: center; gap: 30px; margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                <div><span style="color: #6c757d;">Revisión:</span> <strong>Rev. 3</strong></div>
                <div><span style="color: #6c757d;">Disciplina:</span> <strong>Arquitectura</strong></div>
                <div><span style="color: #6c757d;">Proyecto:</span> <strong>Torre Norte</strong></div>
                <div><span style="color: #6c757d;">Formato:</span> <strong>DWG / PDF</strong></div>
            </div>

            <div style="display: flex; justify-content: center; gap: 15px;">
                <button style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarPlano('A-001')">
                    <i class="fas fa-download"></i> Descargar DWG
                </button>
                <button style="padding: 8px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="descargarPlano('A-001')">
                    <i class="fas fa-download"></i> Descargar PDF
                </button>
                <button style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalPlano()">
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
    
    /* Pestañas */
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
    
    .btn-paginacion {
        transition: all 0.3s ease;
    }
    
    .btn-paginacion:hover {
        background-color: #e9ecef !important;
    }
    
    /* Galería de planos */
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
        
        .documentos-tab {
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
        console.log('DOM completamente cargado - Contratos y Planos');
        
        // Elementos del DOM
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorTipo = document.getElementById('selectorTipo');
        const selectorEstado = document.getElementById('selectorEstado');
        const filtroDisciplina = document.getElementById('filtroDisciplina');
        const filtroRevision = document.getElementById('filtroRevision');
        const filtroProyectoPlanos = document.getElementById('filtroProyectoPlanos');
        const btnSubirDocumento = document.getElementById('btnSubirDocumento');
        const btnExcel = document.getElementById('btnExcel');
        const btnVistaTabla = document.getElementById('btnVistaTabla');
        const btnVistaGaleria = document.getElementById('btnVistaGaleria');
        const vistaGaleriaPlanos = document.getElementById('vistaGaleriaPlanos');
        const vistaTablaPlanos = document.getElementById('vistaTablaPlanos');
        const vistaPlanosControls = document.getElementById('vistaPlanosControls');
        const btnVerHistorial = document.getElementById('btnVerHistorial');
        const selectorDocumento = document.getElementById('selectorDocumento');
        const buscador = document.getElementById('buscador');
        
        // Elementos de pestañas
        const documentTabs = document.querySelectorAll('.documentos-tab');
        const documentContents = document.querySelectorAll('.documentos-content');
        
        // Elementos del modal de subida
        const modalSubir = document.getElementById('modalSubirDocumento');
        const btnCerrarModal = document.getElementById('btnCerrarModalSubir');
        const btnCancelarSubir = document.getElementById('btnCancelarSubir');
        const btnSubirArchivo = document.getElementById('btnSubirArchivo');
        const fileInput = document.getElementById('fileInput');
        
        // Elementos del modal de contrato
        const modalContrato = document.getElementById('modalVerContrato');
        const btnCerrarModalContrato = document.getElementById('btnCerrarModalContrato');
        
        // Elementos del modal de plano
        const modalPlano = document.getElementById('modalVerPlano');
        const btnCerrarModalPlano = document.getElementById('btnCerrarModalPlano');
        
        // Cambio de pestañas
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
                
                // Mostrar/ocultar controles de vista según la pestaña
                if (index === 1) { // Pestaña de planos
                    vistaPlanosControls.style.display = 'flex';
                } else {
                    vistaPlanosControls.style.display = 'none';
                }
            });
        });
        
        // Cambio entre vista tabla y galería para planos
        btnVistaTabla.addEventListener('click', function() {
            btnVistaTabla.classList.add('active');
            btnVistaTabla.style.backgroundColor = '#083CAE';
            btnVistaTabla.style.color = 'white';
            btnVistaGaleria.classList.remove('active');
            btnVistaGaleria.style.backgroundColor = 'transparent';
            btnVistaGaleria.style.color = '#495057';
            vistaGaleriaPlanos.style.display = 'none';
            vistaTablaPlanos.style.display = 'block';
        });
        
        btnVistaGaleria.addEventListener('click', function() {
            btnVistaGaleria.classList.add('active');
            btnVistaGaleria.style.backgroundColor = '#083CAE';
            btnVistaGaleria.style.color = 'white';
            btnVistaTabla.classList.remove('active');
            btnVistaTabla.style.backgroundColor = 'transparent';
            btnVistaTabla.style.color = '#495057';
            vistaGaleriaPlanos.style.display = 'block';
            vistaTablaPlanos.style.display = 'none';
        });
        
        // Event Listeners para filtros
        selectorProyecto.addEventListener('change', function() {
            console.log('Filtrando por proyecto:', this.value);
        });
        
        selectorTipo.addEventListener('change', function() {
            console.log('Filtrando por tipo:', this.value);
        });
        
        selectorEstado.addEventListener('change', function() {
            console.log('Filtrando por estado:', this.value);
        });
        
        if (filtroDisciplina) {
            filtroDisciplina.addEventListener('change', function() {
                console.log('Filtrando planos por disciplina:', this.value);
            });
        }
        
        if (filtroRevision) {
            filtroRevision.addEventListener('change', function() {
                console.log('Filtrando planos por revisión:', this.value);
            });
        }
        
        if (filtroProyectoPlanos) {
            filtroProyectoPlanos.addEventListener('change', function() {
                console.log('Filtrando planos por proyecto:', this.value);
            });
        }
        
        buscador.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
        });
        
        // Botones de acción
        btnSubirDocumento.addEventListener('click', function() {
            modalSubir.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        
        btnExcel.addEventListener('click', function() {
            alert('Exportando a Excel...');
        });
        
        btnVerHistorial.addEventListener('click', function() {
            const doc = selectorDocumento.value;
            if (doc) {
                alert('Mostrando historial de ' + doc);
            } else {
                alert('Por favor seleccione un documento');
            }
        });
        
        // Modal de subida
        function cerrarModalSubida() {
            modalSubir.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        btnCerrarModal.addEventListener('click', cerrarModalSubida);
        btnCancelarSubir.addEventListener('click', cerrarModalSubida);
        
        btnSubirArchivo.addEventListener('click', function() {
            const tipo = document.getElementById('modalTipoDoc').value;
            const proyecto = document.getElementById('modalProyectoDoc').value;
            const numero = document.getElementById('modalNumeroDoc').value;
            
            if (!tipo || !proyecto || !numero) {
                alert('Por favor complete los campos requeridos');
                return;
            }
            
            alert('Documento subido correctamente');
            cerrarModalSubida();
        });
        
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                console.log('Archivo seleccionado:', this.files[0].name);
            }
        });
        
        // Modal de contrato
        window.verContrato = function(id) {
            document.getElementById('modalContratoTitulo').innerHTML = `<i class="fas fa-file-contract"></i> Contrato ${id}`;
            modalContrato.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        function cerrarModalContrato() {
            modalContrato.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalContrato = cerrarModalContrato;
        
        btnCerrarModalContrato.addEventListener('click', cerrarModalContrato);
        
        // Modal de plano ampliado
        window.verPlanoAmpliado = function(id) {
            document.getElementById('modalPlanoTitulo').innerHTML = `<i class="fas fa-draw-polygon"></i> Plano ${id} - Vista ampliada`;
            modalPlano.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        function cerrarModalPlano() {
            modalPlano.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalPlano = cerrarModalPlano;
        
        btnCerrarModalPlano.addEventListener('click', cerrarModalPlano);
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalSubir) {
                cerrarModalSubida();
            }
            if (event.target === modalContrato) {
                cerrarModalContrato();
            }
            if (event.target === modalPlano) {
                cerrarModalPlano();
            }
        });
        
        // Funciones globales para acciones
        window.descargarDocumento = function(id) {
            alert('Descargando documento ' + id);
        };
        
        window.descargarPlano = function(id) {
            alert('Descargando plano ' + id);
        };
        
        window.verHistorial = function(id) {
            alert('Ver historial de ' + id);
        };
        
        window.descargarVersion = function(doc, version) {
            alert('Descargando ' + doc + ' versión ' + version);
        };
        
        window.verVersion = function(doc, version) {
            alert('Viendo ' + doc + ' versión ' + version);
        };
        
        // Paginación
        document.querySelectorAll('.btn-paginacion').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.querySelector('i')) {
                    document.querySelectorAll('.btn-paginacion').forEach(b => {
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
    });
</script>
@endsection