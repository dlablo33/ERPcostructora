@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Centros de Costos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Centros de Costos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE CENTROS DE COSTOS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Centros -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Centros</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalCentros">24</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Centros Activos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Centros Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="centrosActivos">18</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Centros Inactivos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Centros Inactivos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="centrosInactivos">6</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Presupuesto Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Presupuesto Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="presupuestoTotal">$12.5M</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con filtros y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Filtros izquierda -->
                    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <div>
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Tipo:</span>
                            <select id="filtroTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                                <option value="">Todos</option>
                                <option value="proyecto">Proyecto</option>
                                <option value="departamento">Departamento</option>
                                <option value="obra">Obra</option>
                                <option value="sucursal">Sucursal</option>
                            </select>
                        </div>

                        <div>
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Estado:</span>
                            <select id="filtroEstado" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 130px;">
                                <option value="">Todos</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div>
                            <span style="font-weight: 600; color: #083CAE; font-size: 14px; margin-right: 5px;">Responsable:</span>
                            <select id="filtroResponsable" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 150px;">
                                <option value="">Todos</option>
                                <option value="juan">Juan Pérez</option>
                                <option value="maria">María García</option>
                                <option value="carlos">Carlos López</option>
                                <option value="ana">Ana Martínez</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Botones derecha -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Nuevo Centro -->

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: #2CBF1F !important; border: 1px solid #ffffff; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #ffffff;"></i>
                            </button>
                        </div>

                        <!-- Botón Reporte -->
                        <div>
                            <button id="btnReporte" 
                                    style="background-color: #2CBF1F !important; border: 1px solid #ffffff; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Generar Reporte">
                                <i class="fas fa-chart-bar" style="color: #ffffff;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar centro..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de vista -->
                <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                    <button class="tab-button active" data-tab="lista" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-list" style="margin-right: 8px;"></i> Lista de Centros
                    </button>
                    <button class="tab-button" data-tab="jerarquia" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-sitemap" style="margin-right: 8px;"></i> Vista Jerárquica
                    </button>
                    <button class="tab-button" data-tab="presupuesto" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-chart-pie" style="margin-right: 8px;"></i> Presupuestos
                    </button>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-sitemap" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay centros de costos para mostrar</p>
                </div>

                <!-- CONTENIDO: Lista de Centros -->
                <div id="tab-lista" class="tab-content" style="display: block;">
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 500px;">
                        <table class="table table-bordered" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="padding: 12px 10px; text-align: left;">Código</th>
                                    <th style="padding: 12px 10px; text-align: left;">Nombre del Centro</th>
                                    <th style="padding: 12px 10px; text-align: left;">Tipo</th>
                                    <th style="padding: 12px 10px; text-align: left;">Responsable</th>
                                    <th style="padding: 12px 10px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px 10px; text-align: right;">Ejercido</th>
                                    <th style="padding: 12px 10px; text-align: right;">Disponible</th>
                                    <th style="padding: 12px 10px; text-align: center;">%</th>
                                    <th style="padding: 12px 10px; text-align: center;">Estado</th>
                                    <th style="padding: 12px 10px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Proyectos de Construcción -->
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;"><strong>CC-001</strong></td>
                                    <td style="padding: 10px;">Edificio Corporativo Reforma</td>
                                    <td style="padding: 10px;">Proyecto</td>
                                    <td style="padding: 10px;">Juan Pérez</td>
                                    <td style="padding: 10px; text-align: right;">$2,500,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$1,875,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$625,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 75%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        75%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;"><strong>CC-002</strong></td>
                                    <td style="padding: 10px;">Puente Vehicular Norte</td>
                                    <td style="padding: 10px;">Proyecto</td>
                                    <td style="padding: 10px;">María García</td>
                                    <td style="padding: 10px; text-align: right;">$3,800,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$2,280,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$1,520,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 60%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        60%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;"><strong>CC-003</strong></td>
                                    <td style="padding: 10px;">Urbanización Los Pinos</td>
                                    <td style="padding: 10px;">Proyecto</td>
                                    <td style="padding: 10px;">Carlos López</td>
                                    <td style="padding: 10px; text-align: right;">$5,200,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$4,160,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$1,040,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 80%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        80%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                
                                <!-- Departamentos -->
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;"><strong>CC-004</strong></td>
                                    <td style="padding: 10px;">Departamento de Operaciones</td>
                                    <td style="padding: 10px;">Departamento</td>
                                    <td style="padding: 10px;">Ana Martínez</td>
                                    <td style="padding: 10px; text-align: right;">$850,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$637,500.00</td>
                                    <td style="padding: 10px; text-align: right;">$212,500.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 75%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        75%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;"><strong>CC-005</strong></td>
                                    <td style="padding: 10px;">Departamento de Administración</td>
                                    <td style="padding: 10px;">Departamento</td>
                                    <td style="padding: 10px;">Roberto Sánchez</td>
                                    <td style="padding: 10px; text-align: right;">$620,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$403,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$217,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 65%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        65%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;"><strong>CC-006</strong></td>
                                    <td style="padding: 10px;">Departamento de Ventas</td>
                                    <td style="padding: 10px;">Departamento</td>
                                    <td style="padding: 10px;">Laura Gómez</td>
                                    <td style="padding: 10px; text-align: right;">$450,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$360,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$90,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 80%; height: 100%; background-color: #ffc107;"></div>
                                        </div>
                                        80%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>

                                <!-- Obras específicas -->
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;"><strong>CC-007</strong></td>
                                    <td style="padding: 10px;">Obra - Remodelación Centro</td>
                                    <td style="padding: 10px;">Obra</td>
                                    <td style="padding: 10px;">Pedro Hernández</td>
                                    <td style="padding: 10px; text-align: right;">$780,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$702,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$78,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 90%; height: 100%; background-color: #dc3545;"></div>
                                        </div>
                                        90%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;"><strong>CC-008</strong></td>
                                    <td style="padding: 10px;">Obra - Parque Industrial</td>
                                    <td style="padding: 10px;">Obra</td>
                                    <td style="padding: 10px;">Javier Ruiz</td>
                                    <td style="padding: 10px; text-align: right;">$1,200,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$840,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$360,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 70%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        70%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>

                                <!-- Sucursales -->
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;"><strong>CC-009</strong></td>
                                    <td style="padding: 10px;">Sucursal Monterrey</td>
                                    <td style="padding: 10px;">Sucursal</td>
                                    <td style="padding: 10px;">Sofía Castro</td>
                                    <td style="padding: 10px; text-align: right;">$950,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$475,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$475,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 50%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        50%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;"><strong>CC-010</strong></td>
                                    <td style="padding: 10px;">Sucursal Guadalajara</td>
                                    <td style="padding: 10px;">Sucursal</td>
                                    <td style="padding: 10px;">Miguel Torres</td>
                                    <td style="padding: 10px; text-align: right;">$1,100,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$385,000.00</td>
                                    <td style="padding: 10px; text-align: right;">$715,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <div style="width: 60px; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 auto; overflow: hidden;">
                                            <div style="width: 35%; height: 100%; background-color: #28a745;"></div>
                                        </div>
                                        35%
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-activo">Activo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>

                                <!-- Centros inactivos -->
                                <tr style="background-color: #ffffff; opacity: 0.7;">
                                    <td style="padding: 10px;"><strong>CC-011</strong></td>
                                    <td style="padding: 10px;">Proyecto Antiguo - Cerrado</td>
                                    <td style="padding: 10px;">Proyecto</td>
                                    <td style="padding: 10px;">-</td>
                                    <td style="padding: 10px; text-align: right;">$0.00</td>
                                    <td style="padding: 10px; text-align: right;">$1,200,000.00</td>
                                    <td style="padding: 10px; text-align: right;">-$1,200,000.00</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <span style="color: #dc3545;">Cerrado</span>
                                    </td>
                                    <td style="padding: 10px; text-align: center;"><span class="badge badge-inactivo">Inactivo</span></td>
                                    <td style="padding: 10px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 5px;" title="Editar"></i>
                                        <i class="fas fa-chart-line" style="color: #17a2b8; cursor: pointer; margin: 0 5px;" title="Ver movimientos"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 5px;" title="Duplicar"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CONTENIDO: Vista Jerárquica -->
                <div id="tab-jerarquia" class="tab-content" style="display: none;">
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                        <div style="margin-bottom: 20px;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-sitemap mr-2"></i> Estructura de Centros de Costos
                            </h4>
                            <p style="color: #6c757d; font-size: 13px; margin-bottom: 20px;">
                                Vista jerárquica de la organización por centros de costos
                            </p>
                        </div>

                        <!-- Nivel 1: Corporativo -->
                        <div style="margin-left: 0; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; padding: 12px 15px; background-color: #2378e1; color: white; border-radius: 8px; font-weight: bold;">
                                <i class="fas fa-building mr-3"></i>
                                <span>Corporativo (CC-000)</span>
                                <span style="margin-left: auto; font-size: 12px; background-color: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px;">$12,450,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 2: Direcciones -->
                        <div style="margin-left: 30px; margin-bottom: 10px; margin-top: 10px;">
                            <div style="display: flex; align-items: center; padding: 10px 15px; background-color: #e9ecef; border-left: 4px solid #083CAE; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-user-tie mr-3" style="color: #083CAE;"></i>
                                <span style="font-weight: 600;">Dirección de Operaciones</span>
                                <span style="margin-left: auto; font-size: 12px; color: #083CAE;">$5,800,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 3: Proyectos bajo Dirección de Operaciones -->
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-hard-hat mr-3" style="color: #6c757d;"></i>
                                <span>Edificio Corporativo Reforma (CC-001)</span>
                                <span style="margin-left: auto; font-size: 12px;">$2,500,000.00</span>
                            </div>
                        </div>
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-hard-hat mr-3" style="color: #6c757d;"></i>
                                <span>Puente Vehicular Norte (CC-002)</span>
                                <span style="margin-left: auto; font-size: 12px;">$3,800,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 2: Dirección de Administración -->
                        <div style="margin-left: 30px; margin-bottom: 10px; margin-top: 20px;">
                            <div style="display: flex; align-items: center; padding: 10px 15px; background-color: #e9ecef; border-left: 4px solid #083CAE; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-user-tie mr-3" style="color: #083CAE;"></i>
                                <span style="font-weight: 600;">Dirección de Administración</span>
                                <span style="margin-left: auto; font-size: 12px; color: #083CAE;">$2,420,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 3: Departamentos bajo Administración -->
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-users mr-3" style="color: #6c757d;"></i>
                                <span>Departamento de Administración (CC-005)</span>
                                <span style="margin-left: auto; font-size: 12px;">$620,000.00</span>
                            </div>
                        </div>
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-users mr-3" style="color: #6c757d;"></i>
                                <span>Departamento de Ventas (CC-006)</span>
                                <span style="margin-left: auto; font-size: 12px;">$450,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 2: Dirección Regional -->
                        <div style="margin-left: 30px; margin-bottom: 10px; margin-top: 20px;">
                            <div style="display: flex; align-items: center; padding: 10px 15px; background-color: #e9ecef; border-left: 4px solid #083CAE; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-user-tie mr-3" style="color: #083CAE;"></i>
                                <span style="font-weight: 600;">Dirección Regional</span>
                                <span style="margin-left: auto; font-size: 12px; color: #083CAE;">$2,050,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 3: Sucursales -->
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-store mr-3" style="color: #6c757d;"></i>
                                <span>Sucursal Monterrey (CC-009)</span>
                                <span style="margin-left: auto; font-size: 12px;">$950,000.00</span>
                            </div>
                        </div>
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-store mr-3" style="color: #6c757d;"></i>
                                <span>Sucursal Guadalajara (CC-010)</span>
                                <span style="margin-left: auto; font-size: 12px;">$1,100,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 2: Proyectos Especiales -->
                        <div style="margin-left: 30px; margin-bottom: 10px; margin-top: 20px;">
                            <div style="display: flex; align-items: center; padding: 10px 15px; background-color: #e9ecef; border-left: 4px solid #083CAE; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-user-tie mr-3" style="color: #083CAE;"></i>
                                <span style="font-weight: 600;">Proyectos Especiales</span>
                                <span style="margin-left: auto; font-size: 12px; color: #083CAE;">$2,180,000.00</span>
                            </div>
                        </div>

                        <!-- Nivel 3: Obras especiales -->
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-tools mr-3" style="color: #6c757d;"></i>
                                <span>Obra - Remodelación Centro (CC-007)</span>
                                <span style="margin-left: auto; font-size: 12px;">$780,000.00</span>
                            </div>
                        </div>
                        <div style="margin-left: 60px; margin-bottom: 5px;">
                            <div style="display: flex; align-items: center; padding: 8px 15px; background-color: white; border-left: 2px solid #6c757d;">
                                <i class="fas fa-tools mr-3" style="color: #6c757d;"></i>
                                <span>Obra - Parque Industrial (CC-008)</span>
                                <span style="margin-left: auto; font-size: 12px;">$1,200,000.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO: Presupuestos -->
                <div id="tab-presupuesto" class="tab-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <!-- Gráfico de distribución -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-chart-pie mr-2"></i> Distribución por Tipo
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <div style="width: 100px; font-size: 13px;">Proyectos</div>
                                    <div style="flex: 1; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 10px;">
                                        <div style="width: 55%; height: 100%; background-color: #2378e1; border-radius: 10px;"></div>
                                    </div>
                                    <div style="width: 80px; text-align: right; font-size: 13px; font-weight: 600;">$6.5M</div>
                                </div>
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <div style="width: 100px; font-size: 13px;">Departamentos</div>
                                    <div style="flex: 1; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 10px;">
                                        <div style="width: 25%; height: 100%; background-color: #28a745; border-radius: 10px;"></div>
                                    </div>
                                    <div style="width: 80px; text-align: right; font-size: 13px; font-weight: 600;">$2.9M</div>
                                </div>
                                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <div style="width: 100px; font-size: 13px;">Obras</div>
                                    <div style="flex: 1; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 10px;">
                                        <div style="width: 15%; height: 100%; background-color: #ffc107; border-radius: 10px;"></div>
                                    </div>
                                    <div style="width: 80px; text-align: right; font-size: 13px; font-weight: 600;">$1.8M</div>
                                </div>
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 100px; font-size: 13px;">Sucursales</div>
                                    <div style="flex: 1; height: 20px; background-color: #e9ecef; border-radius: 10px; margin: 0 10px;">
                                        <div style="width: 18%; height: 100%; background-color: #17a2b8; border-radius: 10px;"></div>
                                    </div>
                                    <div style="width: 80px; text-align: right; font-size: 13px; font-weight: 600;">$2.1M</div>
                                </div>
                            </div>
                            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                                <div style="display: flex; justify-content: space-between; font-weight: 700; color: #083CAE;">
                                    <span>Presupuesto Total:</span>
                                    <span>$12,500,000.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                    <span>Ejercido:</span>
                                    <span class="text-danger">$8,237,500.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-weight: 600;">
                                    <span>Disponible:</span>
                                    <span class="text-success">$4,262,500.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de presupuestos por centro -->
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-chart-line mr-2"></i> Top 5 Centros por Presupuesto
                            </h4>
                            <table style="width: 100%; font-size: 13px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #dee2e6;">
                                        <th style="padding: 8px; text-align: left;">Centro</th>
                                        <th style="padding: 8px; text-align: right;">Presupuesto</th>
                                        <th style="padding: 8px; text-align: right;">Ejercido</th>
                                        <th style="padding: 8px; text-align: right;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 8px;">Urbanización Los Pinos</td>
                                        <td style="padding: 8px; text-align: right;">$5,200,000</td>
                                        <td style="padding: 8px; text-align: right;">$4,160,000</td>
                                        <td style="padding: 8px; text-align: right;">80%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px;">Puente Vehicular Norte</td>
                                        <td style="padding: 8px; text-align: right;">$3,800,000</td>
                                        <td style="padding: 8px; text-align: right;">$2,280,000</td>
                                        <td style="padding: 8px; text-align: right;">60%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px;">Edificio Corporativo</td>
                                        <td style="padding: 8px; text-align: right;">$2,500,000</td>
                                        <td style="padding: 8px; text-align: right;">$1,875,000</td>
                                        <td style="padding: 8px; text-align: right;">75%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px;">Sucursal Guadalajara</td>
                                        <td style="padding: 8px; text-align: right;">$1,100,000</td>
                                        <td style="padding: 8px; text-align: right;">$385,000</td>
                                        <td style="padding: 8px; text-align: right;">35%</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px;">Sucursal Monterrey</td>
                                        <td style="padding: 8px; text-align: right;">$950,000</td>
                                        <td style="padding: 8px; text-align: right;">$475,000</td>
                                        <td style="padding: 8px; text-align: right;">50%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabla de movimientos por centro -->
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; margin-top: 20px;">
                        <div style="background-color: #f1f5f9; padding: 15px 20px; border-bottom: 2px solid #083CAE;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin: 0;">
                                <i class="fas fa-exchange-alt mr-2"></i> Últimos Movimientos
                            </h4>
                        </div>
                        <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #2378e1; color: white;">
                                <tr>
                                    <th style="padding: 12px 10px; text-align: left;">Fecha</th>
                                    <th style="padding: 12px 10px; text-align: left;">Centro de Costos</th>
                                    <th style="padding: 12px 10px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px 10px; text-align: right;">Monto</th>
                                    <th style="padding: 12px 10px; text-align: center;">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;">2026-03-15</td>
                                    <td style="padding: 10px;">Edificio Corporativo</td>
                                    <td style="padding: 10px;">Pago a proveedor materiales</td>
                                    <td style="padding: 10px; text-align: right;">$45,230.50</td>
                                    <td style="padding: 10px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px;">Gasto</span></td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;">2026-03-14</td>
                                    <td style="padding: 10px;">Puente Vehicular</td>
                                    <td style="padding: 10px;">Nómina trabajadores</td>
                                    <td style="padding: 10px; text-align: right;">$18,500.00</td>
                                    <td style="padding: 10px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px;">Gasto</span></td>
                                </tr>
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;">2026-03-13</td>
                                    <td style="padding: 10px;">Urbanización Los Pinos</td>
                                    <td style="padding: 10px;">Renta de maquinaria</td>
                                    <td style="padding: 10px; text-align: right;">$32,150.75</td>
                                    <td style="padding: 10px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px;">Gasto</span></td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="padding: 10px;">2026-03-12</td>
                                    <td style="padding: 10px;">Sucursal Monterrey</td>
                                    <td style="padding: 10px;">Pago de servicios</td>
                                    <td style="padding: 10px; text-align: right;">$12,000.00</td>
                                    <td style="padding: 10px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px;">Gasto</span></td>
                                </tr>
                                <tr style="background-color: #ffffff;">
                                    <td style="padding: 10px;">2026-03-11</td>
                                    <td style="padding: 10px;">Departamento de Ventas</td>
                                    <td style="padding: 10px;">Gastos de viaje</td>
                                    <td style="padding: 10px; text-align: right;">$5,600.00</td>
                                    <td style="padding: 10px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px;">Gasto</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 20px; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">3</button>
                        <button class="page-btn" style="padding: 5px 10px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; color: #083CAE;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <span style="color: #6c757d; font-size: 14px;">Mostrando 1-10 de 24 centros</span>
                </div>
            </div>
        </div>
    </section>
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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #2378e1 !important;
        color: white;
        font-weight: 600;
        padding: 12px 10px;
        white-space: nowrap;
    }
    
    td {
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    
    /* Badges */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    
    .badge-activo {
        background-color: #28a745;
        color: white;
    }
    
    .badge-inactivo {
        background-color: #dc3545;
        color: white;
    }
    
    /* Estilo para pestañas */
    .tab-button {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin-bottom: -2px;
    }
    
    .tab-button:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .tab-button.active {
        background-color: #083CAE !important;
        color: white !important;
        border-color: #083CAE;
    }
    
    /* Estilo para iconos de acción */
    .fa-eye:hover, .fa-edit:hover, .fa-chart-line:hover, .fa-copy:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    
    .fa-eye:hover { color: #0056b3 !important; }
    .fa-edit:hover { color: #e0a800 !important; }
    .fa-chart-line:hover { color: #117a8b !important; }
    .fa-copy:hover { color: #545b62 !important; }
    
    /* Estilo para el botón Nuevo */
    #btnNuevo {
        transition: all 0.3s ease;
    }
    
    #btnNuevo:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }
    
    #btnNuevo:active {
        transform: translateY(0);
    }
    
    /* Estilo para botones de paginación */
    .page-btn {
        transition: all 0.2s;
    }
    
    .page-btn:hover:not(:disabled) {
        background-color: #e9ecef !important;
        transform: translateY(-2px);
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        [style*="flex: 0 1 calc(25% - 15px)"] {
            flex: 0 1 calc(50% - 15px) !important;
        }
        
        [style*="display: flex; justify-content: space-between"] {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        input[type="date"], select {
            width: 100% !important;
        }
        
        #buscador {
            width: 100% !important;
        }
        
        table {
            font-size: 11px;
        }
        
        td, th {
            padding: 6px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Centros de Costos');
        
        // Manejo de pestañas
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function showTab(tabId) {
            tabContents.forEach(content => {
                content.style.display = 'none';
            });

            tabButtons.forEach(button => {
                button.classList.remove('active');
                button.style.backgroundColor = '#e9ecef';
                button.style.color = '#495057';
            });

            document.getElementById(`tab-${tabId}`).style.display = 'block';

            const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
            activeButton.classList.add('active');
            activeButton.style.backgroundColor = '#083CAE';
            activeButton.style.color = 'white';
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.dataset.tab;
                showTab(tabId);
            });
        });

        // Mostrar lista por defecto
        showTab('lista');

        // Event Listeners
        document.getElementById('btnNuevo')?.addEventListener('click', function() {
            alert('Nuevo Centro de Costos - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando centros de costos a Excel...');
        });
        
        document.getElementById('btnReporte')?.addEventListener('click', function() {
            alert('Generando reporte de centros de costos...');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            console.log('Buscando:', busqueda);
            // Aquí se podría filtrar la tabla
        });
        
        // Filtros
        document.getElementById('filtroTipo')?.addEventListener('change', function() {
            console.log('Filtro tipo:', this.value);
        });
        
        document.getElementById('filtroEstado')?.addEventListener('change', function() {
            console.log('Filtro estado:', this.value);
        });
        
        document.getElementById('filtroResponsable')?.addEventListener('change', function() {
            console.log('Filtro responsable:', this.value);
        });
        
        // Acciones de los iconos
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                alert('Ver detalle del centro de costos');
            } else if (e.target.classList.contains('fa-edit')) {
                alert('Editar centro de costos');
            } else if (e.target.classList.contains('fa-chart-line')) {
                alert('Ver movimientos del centro');
            } else if (e.target.classList.contains('fa-copy')) {
                alert('Duplicar centro de costos');
            }
        });
    });
</script>
@endsection