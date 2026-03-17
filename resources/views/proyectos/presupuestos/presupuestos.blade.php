@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Presupuestos por Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Presupuestos por Proyecto
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y controles principales -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Selector de proyecto -->
                        <div>
                            <select id="selectorProyecto" style="padding: 10px 15px; border: 1px solid #ced4da; border-radius: 8px; font-size: 14px; min-width: 300px;">
                                <option value="">Seleccionar proyecto...</option>
                                <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                                <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                                <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                                <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                                <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                                <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <!-- Selector de versión de presupuesto -->
                        <div style="display: flex; gap: 5px; background-color: #e9ecef; padding: 4px; border-radius: 8px;">
                            <button class="version-btn active" data-version="original" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                Original
                            </button>
                            <button class="version-btn" data-version="modificado" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                Modificado
                            </button>
                            <button class="version-btn" data-version="ejecutado" style="padding: 8px 15px; background-color: transparent; color: #495057; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
                                Ejecutado
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Botones de acción -->
                        <button id="btnNuevoPresupuesto" style="padding: 8px 15px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-plus"></i> Nuevo Presupuesto
                        </button>
                        <button id="btnComparar" style="padding: 8px 15px; background-color: white; border: 1px solid #083CAE; color: #083CAE; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-balance-scale"></i> Comparar
                        </button>
                        <button id="btnExportar" style="padding: 8px 15px; background-color: white; border: 1px solid #28a745; color: #28a745; border-radius: 4px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-file-excel"></i> Exportar
                        </button>
                    </div>
                </div>

                <!-- Información del proyecto seleccionado -->
                <div id="infoProyecto" style="background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px; padding: 25px; margin-bottom: 25px; color: white;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                        <div>
                            <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Proyecto seleccionado</div>
                            <h3 style="font-size: 24px; font-weight: 600; margin: 0;">PRO-2024-001 - Torre Norte Corporativa</h3>
                            <div style="display: flex; gap: 20px; margin-top: 10px; flex-wrap: wrap;">
                                <span><i class="fas fa-user-tie"></i> Responsable: Juan Pérez</span>
                                <span><i class="fas fa-calendar"></i> Inicio: 15/01/2024</span>
                                <span><i class="fas fa-calendar-check"></i> Fin: 15/12/2024</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 14px; opacity: 0.9;">Presupuesto Total</div>
                            <div style="font-size: 36px; font-weight: 700;">$45,500,000</div>
                            <div style="font-size: 14px; margin-top: 5px;">MXN</div>
                        </div>
                    </div>
                </div>

                <!-- Resumen de presupuesto -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #e8f0fe; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-invoice" style="color: #083CAE;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Presupuesto Original</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;">$45,500,000</div>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-edit" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Modificado</div>
                                <div style="font-size: 20px; font-weight: bold; color: #ffc107;">$47,250,000</div>
                            </div>
                        </div>
                        <div style="font-size: 11px; color: #28a745; margin-top: 5px;">+3.8% vs original</div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Ejecutado</div>
                                <div style="font-size: 20px; font-weight: bold; color: #28a745;">$29,575,000</div>
                            </div>
                        </div>
                        <div style="font-size: 11px; color: #ffc107; margin-top: 5px;">65% del total</div>
                    </div>

                    <div class="resumen-card" style="background: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 40px; height: 40px; background-color: #f8d7da; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="color: #dc3545;"></i>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #6c757d;">Desviación</div>
                                <div style="font-size: 20px; font-weight: bold; color: #dc3545;">$1,750,000</div>
                            </div>
                        </div>
                        <div style="font-size: 11px; color: #dc3545; margin-top: 5px;">-3.8% por debajo</div>
                    </div>
                </div>

                <!-- Pestañas de secciones de presupuesto -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="presupuesto-tab active" data-tab="conceptos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Conceptos
                    </button>
                    <button class="presupuesto-tab" data-tab="categorias" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tags"></i> Por Categorías
                    </button>
                    <button class="presupuesto-tab" data-tab="variaciones" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-line"></i> Variaciones
                    </button>
                    <button class="presupuesto-tab" data-tab="flujo" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-calendar-alt"></i> Flujo de Efectivo
                    </button>
                    <button class="presupuesto-tab" data-tab="documentos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-file-pdf"></i> Documentos
                    </button>
                </div>

                <!-- SECCIÓN 1: CONCEPTOS DEL PRESUPUESTO -->
                <div id="tab-conceptos" class="presupuesto-content active">
                    <!-- Barra de herramientas -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todas las categorías</option>
                                <option value="materiales">Materiales</option>
                                <option value="mano-obra">Mano de Obra</option>
                                <option value="maquinaria">Maquinaria</option>
                                <option value="subcontratos">Subcontratos</option>
                                <option value="indirectos">Indirectos</option>
                            </select>
                            <select style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Ver todos</option>
                                <option value="con-desviacion">Con desviación</option>
                                <option value="completados">Completados</option>
                                <option value="pendientes">Pendientes</option>
                            </select>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" placeholder="Buscar concepto..." style="padding: 8px 8px 8px 35px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; width: 250px;">
                        </div>
                    </div>

                    <!-- Tabla de conceptos -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1200px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px; text-align: left;">Código</th>
                                    <th style="padding: 12px; text-align: left;">Concepto</th>
                                    <th style="padding: 12px; text-align: left;">Categoría</th>
                                    <th style="padding: 12px; text-align: right;">Cantidad</th>
                                    <th style="padding: 12px; text-align: left;">Unidad</th>
                                    <th style="padding: 12px; text-align: right;">P. Unitario</th>
                                    <th style="padding: 12px; text-align: right;">Importe</th>
                                    <th style="padding: 12px; text-align: right;">Ejecutado</th>
                                    <th style="padding: 12px; text-align: right;">Pendiente</th>
                                    <th style="padding: 12px; text-align: center;">% Avance</th>
                                    <th style="padding: 12px; text-align: center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>01.01.001</strong></td>
                                    <td style="padding: 12px;">Excavación para cimentación</td>
                                    <td style="padding: 12px;">Materiales</td>
                                    <td style="padding: 12px; text-align: right;">450</td>
                                    <td style="padding: 12px;">m³</td>
                                    <td style="padding: 12px; text-align: right;">$850</td>
                                    <td style="padding: 12px; text-align: right;">$382,500</td>
                                    <td style="padding: 12px; text-align: right;">$325,125</td>
                                    <td style="padding: 12px; text-align: right;">$57,375</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 85%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            85%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                    <td style="padding: 12px;"><strong>01.02.001</strong></td>
                                    <td style="padding: 12px;">Acero de refuerzo (fy=4200 kg/cm²)</td>
                                    <td style="padding: 12px;">Materiales</td>
                                    <td style="padding: 12px; text-align: right;">25,000</td>
                                    <td style="padding: 12px;">kg</td>
                                    <td style="padding: 12px; text-align: right;">$32</td>
                                    <td style="padding: 12px; text-align: right;">$800,000</td>
                                    <td style="padding: 12px; text-align: right;">$560,000</td>
                                    <td style="padding: 12px; text-align: right;">$240,000</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 70%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            70%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>01.03.001</strong></td>
                                    <td style="padding: 12px;">Concreto premezclado f'c=250 kg/cm²</td>
                                    <td style="padding: 12px;">Materiales</td>
                                    <td style="padding: 12px; text-align: right;">650</td>
                                    <td style="padding: 12px;">m³</td>
                                    <td style="padding: 12px; text-align: right;">$2,450</td>
                                    <td style="padding: 12px; text-align: right;">$1,592,500</td>
                                    <td style="padding: 12px; text-align: right;">$1,115,000</td>
                                    <td style="padding: 12px; text-align: right;">$477,500</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 70%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            70%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8d7da;">
                                    <td style="padding: 12px;"><strong>02.01.001</strong></td>
                                    <td style="padding: 12px;">Mano de obra - Cimentación</td>
                                    <td style="padding: 12px;">Mano de Obra</td>
                                    <td style="padding: 12px; text-align: right;">850</td>
                                    <td style="padding: 12px;">jor</td>
                                    <td style="padding: 12px; text-align: right;">$650</td>
                                    <td style="padding: 12px; text-align: right;">$552,500</td>
                                    <td style="padding: 12px; text-align: right;">$358,400</td>
                                    <td style="padding: 12px; text-align: right;">$194,100</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 45%; height: 6px; background-color: #dc3545; border-radius: 3px;"></div>
                                            </div>
                                            45%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>03.01.001</strong></td>
                                    <td style="padding: 12px;">Retroexcavadora (135 hp)</td>
                                    <td style="padding: 12px;">Maquinaria</td>
                                    <td style="padding: 12px; text-align: right;">180</td>
                                    <td style="padding: 12px;">hr</td>
                                    <td style="padding: 12px; text-align: right;">$950</td>
                                    <td style="padding: 12px; text-align: right;">$171,000</td>
                                    <td style="padding: 12px; text-align: right;">$171,000</td>
                                    <td style="padding: 12px; text-align: right;">$0</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 100%; height: 6px; background-color: #28a745; border-radius: 3px;"></div>
                                            </div>
                                            100%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                    <td style="padding: 12px;"><strong>04.01.001</strong></td>
                                    <td style="padding: 12px;">Instalación eléctrica</td>
                                    <td style="padding: 12px;">Subcontratos</td>
                                    <td style="padding: 12px; text-align: right;">1</td>
                                    <td style="padding: 12px;">global</td>
                                    <td style="padding: 12px; text-align: right;">$850,000</td>
                                    <td style="padding: 12px; text-align: right;">$850,000</td>
                                    <td style="padding: 12px; text-align: right;">$340,000</td>
                                    <td style="padding: 12px; text-align: right;">$510,000</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <div style="width: 60px; height: 6px; background-color: #e9ecef; border-radius: 3px;">
                                                <div style="width: 40%; height: 6px; background-color: #ffc107; border-radius: 3px;"></div>
                                            </div>
                                            40%
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                        <i class="fas fa-copy" style="color: #6c757d; cursor: pointer; margin: 0 3px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="6" style="padding: 12px; text-align: right;">Totales:</td>
                                    <td style="padding: 12px; text-align: right;">$4,348,500</td>
                                    <td style="padding: 12px; text-align: right;">$2,869,525</td>
                                    <td style="padding: 12px; text-align: right;">$1,478,975</td>
                                    <td style="padding: 12px; text-align: center;">66%</td>
                                    <td style="padding: 12px;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Nota de pie -->
                    <div style="margin-top: 15px; font-size: 12px; color: #6c757d;">
                        <i class="fas fa-info-circle"></i> Mostrando 6 de 45 conceptos. <a href="#" style="color: #083CAE;">Ver todos</a>
                    </div>
                </div>

                <!-- SECCIÓN 2: POR CATEGORÍAS -->
                <div id="tab-categorias" class="presupuesto-content" style="display: none;">
                    <!-- Gráficos y resumen por categoría -->
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-chart-pie"></i> Distribución por Categoría
                            </h4>
                            <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                                <div style="text-align: center;">
                                    <i class="fas fa-chart-pie" style="font-size: 48px; color: #adb5bd; margin-bottom: 10px;"></i>
                                    <p style="color: #6c757d;">Gráfico de pastel - Distribución del presupuesto</p>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-percent"></i> Porcentajes por Categoría
                            </h4>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Materiales</span>
                                    <span style="font-size: 13px; font-weight: 600;">$2,775,000 (45%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 45%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Mano de Obra</span>
                                    <span style="font-size: 13px; font-weight: 600;">$1,242,500 (20%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 20%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Maquinaria</span>
                                    <span style="font-size: 13px; font-weight: 600;">$465,000 (8%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 8%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Subcontratos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$1,366,000 (22%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 22%; height: 8px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span style="font-size: 13px;">Indirectos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$310,000 (5%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 5%; height: 8px; background-color: #6c757d; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla resumen por categorías -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px;">Categoría</th>
                                    <th style="padding: 12px; text-align: right;">Presupuesto</th>
                                    <th style="padding: 12px; text-align: right;">Ejecutado</th>
                                    <th style="padding: 12px; text-align: right;">Pendiente</th>
                                    <th style="padding: 12px; text-align: center;">% Ejecución</th>
                                    <th style="padding: 12px; text-align: center;">% del Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>Materiales</strong></td>
                                    <td style="padding: 12px; text-align: right;">$2,775,000</td>
                                    <td style="padding: 12px; text-align: right;">$1,940,125</td>
                                    <td style="padding: 12px; text-align: right;">$834,875</td>
                                    <td style="padding: 12px; text-align: center;">70%</td>
                                    <td style="padding: 12px; text-align: center;">45%</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>Mano de Obra</strong></td>
                                    <td style="padding: 12px; text-align: right;">$1,242,500</td>
                                    <td style="padding: 12px; text-align: right;">$647,400</td>
                                    <td style="padding: 12px; text-align: right;">$595,100</td>
                                    <td style="padding: 12px; text-align: center;">52%</td>
                                    <td style="padding: 12px; text-align: center;">20%</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>Maquinaria</strong></td>
                                    <td style="padding: 12px; text-align: right;">$465,000</td>
                                    <td style="padding: 12px; text-align: right;">$342,000</td>
                                    <td style="padding: 12px; text-align: right;">$123,000</td>
                                    <td style="padding: 12px; text-align: center;">74%</td>
                                    <td style="padding: 12px; text-align: center;">8%</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>Subcontratos</strong></td>
                                    <td style="padding: 12px; text-align: right;">$1,366,000</td>
                                    <td style="padding: 12px; text-align: right;">$592,000</td>
                                    <td style="padding: 12px; text-align: right;">$774,000</td>
                                    <td style="padding: 12px; text-align: center;">43%</td>
                                    <td style="padding: 12px; text-align: center;">22%</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>Indirectos</strong></td>
                                    <td style="padding: 12px; text-align: right;">$310,000</td>
                                    <td style="padding: 12px; text-align: right;">$162,000</td>
                                    <td style="padding: 12px; text-align: right;">$148,000</td>
                                    <td style="padding: 12px; text-align: center;">52%</td>
                                    <td style="padding: 12px; text-align: center;">5%</td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td style="padding: 12px;">Totales</td>
                                    <td style="padding: 12px; text-align: right;">$6,158,500</td>
                                    <td style="padding: 12px; text-align: right;">$3,683,525</td>
                                    <td style="padding: 12px; text-align: right;">$2,474,975</td>
                                    <td style="padding: 12px; text-align: center;">60%</td>
                                    <td style="padding: 12px; text-align: center;">100%</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 3: VARIACIONES -->
                <div id="tab-variaciones" class="presupuesto-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Variación Neta</div>
                            <div style="font-size: 28px; font-weight: bold; color: #dc3545;">-$243,500</div>
                            <div style="font-size: 12px; margin-top: 5px;">vs presupuesto original</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Número de cambios</div>
                            <div style="font-size: 28px; font-weight: bold; color: #083CAE;">12</div>
                            <div style="font-size: 12px; margin-top: 5px;">8 aprobados, 4 pendientes</div>
                        </div>
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <div style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">Impacto en plazo</div>
                            <div style="font-size: 28px; font-weight: bold; color: #ffc107;">+15 días</div>
                            <div style="font-size: 12px; margin-top: 5px;">extensión estimada</div>
                        </div>
                    </div>

                    <!-- Tabla de variaciones -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 1000px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px;">No. Cambio</th>
                                    <th style="padding: 12px;">Fecha</th>
                                    <th style="padding: 12px;">Concepto</th>
                                    <th style="padding: 12px;">Tipo</th>
                                    <th style="padding: 12px; text-align: right;">Monto</th>
                                    <th style="padding: 12px;">Estado</th>
                                    <th style="padding: 12px;">Aprobado por</th>
                                    <th style="padding: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>VO-001</strong></td>
                                    <td style="padding: 12px;">15/02/2024</td>
                                    <td style="padding: 12px;">Aumento en volumen de concreto</td>
                                    <td style="padding: 12px;">Volumétrico</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$125,000</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Aprobado</span></td>
                                    <td style="padding: 12px;">Cliente</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin-left: 10px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>VO-002</strong></td>
                                    <td style="padding: 12px;">28/02/2024</td>
                                    <td style="padding: 12px;">Cambio en especificación de acero</td>
                                    <td style="padding: 12px;">Técnico</td>
                                    <td style="padding: 12px; text-align: right; color: #dc3545;">-$45,000</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Aprobado</span></td>
                                    <td style="padding: 12px;">Supervisor</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin-left: 10px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #fff3cd;">
                                    <td style="padding: 12px;"><strong>VO-003</strong></td>
                                    <td style="padding: 12px;">05/03/2024</td>
                                    <td style="padding: 12px;">Trabajos adicionales en cimentación</td>
                                    <td style="padding: 12px;">Extra</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$210,000</td>
                                    <td style="padding: 12px;"><span style="background-color: #ffc107; color: #856404; padding: 4px 8px; border-radius: 4px;">Pendiente</span></td>
                                    <td style="padding: 12px;">-</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                        <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin-left: 10px;"></i>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;"><strong>VO-004</strong></td>
                                    <td style="padding: 12px;">12/03/2024</td>
                                    <td style="padding: 12px;">Ajuste en partida de acabados</td>
                                    <td style="padding: 12px;">Deductivo</td>
                                    <td style="padding: 12px; text-align: right; color: #dc3545;">-$78,500</td>
                                    <td style="padding: 12px;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px;">Aprobado</span></td>
                                    <td style="padding: 12px;">Cliente</td>
                                    <td style="padding: 12px;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;"></i>
                                        <i class="fas fa-download" style="color: #28a745; cursor: pointer; margin-left: 10px;"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 4: FLUJO DE EFECTIVO -->
                <div id="tab-flujo" class="presupuesto-content" style="display: none;">
                    <!-- Gráfico de flujo -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Proyección de Flujo de Efectivo
                        </h4>
                        <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 4px;">
                            <div style="text-align: center;">
                                <i class="fas fa-chart-line" style="font-size: 48px; color: #adb5bd; margin-bottom: 10px;"></i>
                                <p style="color: #6c757d;">Gráfico de flujo de efectivo - Ingresos vs Egresos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de flujo mensual -->
                    <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 8px;">
                        <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse; min-width: 800px;">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #083CAE;">
                                <tr>
                                    <th style="padding: 12px;">Mes</th>
                                    <th style="padding: 12px; text-align: right;">Ingreso Proyectado</th>
                                    <th style="padding: 12px; text-align: right;">Ingreso Real</th>
                                    <th style="padding: 12px; text-align: right;">Egreso Proyectado</th>
                                    <th style="padding: 12px; text-align: right;">Egreso Real</th>
                                    <th style="padding: 12px; text-align: right;">Flujo Neto</th>
                                    <th style="padding: 12px; text-align: right;">Saldo Acumulado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;">Enero 2024</td>
                                    <td style="padding: 12px; text-align: right;">$3,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$3,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$2,800,000</td>
                                    <td style="padding: 12px; text-align: right;">$2,650,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$850,000</td>
                                    <td style="padding: 12px; text-align: right;">$850,000</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                    <td style="padding: 12px;">Febrero 2024</td>
                                    <td style="padding: 12px; text-align: right;">$4,200,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,200,000</td>
                                    <td style="padding: 12px; text-align: right;">$3,600,000</td>
                                    <td style="padding: 12px; text-align: right;">$3,750,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$450,000</td>
                                    <td style="padding: 12px; text-align: right;">$1,300,000</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;">Marzo 2024</td>
                                    <td style="padding: 12px; text-align: right;">$4,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,200,000</td>
                                    <td style="padding: 12px; text-align: right;">$3,800,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,100,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$100,000</td>
                                    <td style="padding: 12px; text-align: right;">$1,400,000</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                    <td style="padding: 12px;">Abril 2024</td>
                                    <td style="padding: 12px; text-align: right;">$4,800,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,500,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,100,000</td>
                                    <td style="padding: 12px; text-align: right;">$4,300,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$200,000</td>
                                    <td style="padding: 12px; text-align: right;">$1,600,000</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px;">Mayo 2024</td>
                                    <td style="padding: 12px; text-align: right;">$5,000,000</td>
                                    <td style="padding: 12px; text-align: right;">-</td>
                                    <td style="padding: 12px; text-align: right;">$4,300,000</td>
                                    <td style="padding: 12px; text-align: right;">-</td>
                                    <td style="padding: 12px; text-align: right;">-</td>
                                    <td style="padding: 12px; text-align: right;">-</td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td style="padding: 12px;">Totales</td>
                                    <td style="padding: 12px; text-align: right;">$22,000,000</td>
                                    <td style="padding: 12px; text-align: right;">$16,400,000</td>
                                    <td style="padding: 12px; text-align: right;">$18,600,000</td>
                                    <td style="padding: 12px; text-align: right;">$14,800,000</td>
                                    <td style="padding: 12px; text-align: right; color: #28a745;">+$1,600,000</td>
                                    <td style="padding: 12px; text-align: right;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- SECCIÓN 5: DOCUMENTOS -->
                <div id="tab-documentos" class="presupuesto-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                        <!-- Documentos de presupuesto -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-file-invoice"></i> Documentos de Presupuesto
                            </h4>
                            <div style="border-bottom: 1px solid #dee2e6; padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">Presupuesto_Original_v1.pdf</div>
                                    <div style="font-size: 11px; color: #6c757d;">2.4 MB • 15/01/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                            <div style="border-bottom: 1px solid #dee2e6; padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-excel" style="color: #28a745; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">Analisis_Precios_Unitarios.xlsx</div>
                                    <div style="font-size: 11px; color: #6c757d;">1.8 MB • 15/01/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                            <div style="padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-word" style="color: #0d6efd; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">Memoria_Descriptiva.docx</div>
                                    <div style="font-size: 11px; color: #6c757d;">856 KB • 20/01/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                        </div>

                        <!-- Órdenes de cambio -->
                        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px;">
                            <h4 style="color: #ffc107; margin: 0 0 15px 0; font-size: 16px;">
                                <i class="fas fa-exchange-alt"></i> Órdenes de Cambio
                            </h4>
                            <div style="border-bottom: 1px solid #dee2e6; padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">OC-001_Cimentacion.pdf</div>
                                    <div style="font-size: 11px; color: #6c757d;">1.2 MB • 15/02/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                            <div style="border-bottom: 1px solid #dee2e6; padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">OC-002_Acero.pdf</div>
                                    <div style="font-size: 11px; color: #6c757d;">954 KB • 28/02/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                            <div style="padding: 10px 0; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 20px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600;">OC-003_Adicionales.pdf</div>
                                    <div style="font-size: 11px; color: #6c757d;">1.5 MB • 05/03/2024</div>
                                </div>
                                <i class="fas fa-download" style="color: #083CAE; cursor: pointer;"></i>
                                <i class="fas fa-eye" style="color: #6c757d; cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Cargar documento -->
                    <div style="border: 2px dashed #ced4da; border-radius: 8px; padding: 30px; text-align: center; background-color: #f8f9fa;">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #083CAE; margin-bottom: 15px;"></i>
                        <h4 style="font-size: 16px; margin-bottom: 10px;">Cargar nuevo documento</h4>
                        <p style="font-size: 13px; color: #6c757d; margin-bottom: 15px;">Arrastra archivos aquí o haz clic para seleccionar</p>
                        <input type="file" id="fileInput" style="display: none;">
                        <button onclick="document.getElementById('fileInput').click()" style="padding: 10px 25px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            <i class="fas fa-upload"></i> Seleccionar archivo
                        </button>
                        <p style="font-size: 11px; color: #6c757d; margin-top: 10px;">PDF, Excel, Word, DWG (Max. 25MB)</p>
                    </div>
                </div>

                <!-- Notas adicionales -->
                <div style="margin-top: 25px; background-color: #e8f0fe; border-left: 4px solid #083CAE; border-radius: 4px; padding: 15px;">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <i class="fas fa-info-circle" style="color: #083CAE; font-size: 20px;"></i>
                        <div>
                            <strong style="color: #083CAE;">Notas del presupuesto:</strong>
                            <p style="margin: 5px 0 0 0; font-size: 13px; color: #495057;">
                                Este presupuesto incluye 3 órdenes de cambio aprobadas. El monto original se ha modificado de $45,500,000 a $47,250,000. 
                                Se recomienda revisar las partidas con desviación significativa (Mano de obra y Subcontratos).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nuevo Presupuesto -->
<div id="modalNuevoPresupuesto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nuevo Presupuesto</h3>
            <button id="btnCerrarModalPresupuesto" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Proyecto <span style="color: #dc3545;">*</span></label>
                <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="">Seleccionar proyecto...</option>
                    <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                    <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                    <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipo de Presupuesto</label>
                <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    <option value="original">Original</option>
                    <option value="modificado">Modificado</option>
                    <option value="complementario">Complementario</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Versión</label>
                <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: v2.0">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha de elaboración</label>
                    <input type="date" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Moneda</label>
                    <select style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="MXN">MXN - Peso Mexicano</option>
                        <option value="USD">USD - Dólar Americano</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                <textarea rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción del presupuesto..."></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Archivo base</label>
                <div style="border: 1px solid #ced4da; border-radius: 4px; padding: 10px;">
                    <input type="file" id="archivoPresupuesto">
                </div>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarPresupuesto" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Crear Presupuesto</button>
        </div>
    </div>
</div>

<style>
    .version-btn, .presupuesto-tab {
        transition: all 0.3s ease;
    }
    
    .version-btn:hover, .presupuesto-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .version-btn.active, .presupuesto-tab.active {
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
    
    .presupuesto-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Estilos para tablas */
    .table td, .table th {
        vertical-align: middle;
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
        
        .version-btn, .presupuesto-tab {
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        
        #selectorProyecto {
            min-width: 100%;
        }
        
        #infoProyecto {
            padding: 15px !important;
        }
        
        #infoProyecto h3 {
            font-size: 18px !important;
        }
        
        #infoProyecto div[style*="font-size: 36px"] {
            font-size: 24px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Presupuestos por Proyecto');
        
        // Elementos del DOM
        const versionBtns = document.querySelectorAll('.version-btn');
        const presupuestoTabs = document.querySelectorAll('.presupuesto-tab');
        const presupuestoContents = document.querySelectorAll('.presupuesto-content');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const infoProyecto = document.getElementById('infoProyecto');
        const btnNuevoPresupuesto = document.getElementById('btnNuevoPresupuesto');
        const btnComparar = document.getElementById('btnComparar');
        const btnExportar = document.getElementById('btnExportar');
        const modalNuevoPresupuesto = document.getElementById('modalNuevoPresupuesto');
        const btnCerrarModalPresupuesto = document.getElementById('btnCerrarModalPresupuesto');
        const btnCancelarPresupuesto = document.getElementById('btnCancelarPresupuesto');
        
        // Datos de proyectos (simulados)
        const proyectosData = {
            'PRO-2024-001': {
                nombre: 'Torre Norte Corporativa',
                responsable: 'Juan Pérez',
                inicio: '15/01/2024',
                fin: '15/12/2024',
                presupuesto: 45500000
            },
            'PRO-2024-002': {
                nombre: 'Puente Vehicular Sur',
                responsable: 'María García',
                inicio: '01/02/2024',
                fin: '30/11/2024',
                presupuesto: 28750000
            },
            'PRO-2024-003': {
                nombre: 'Parque Industrial Norte',
                responsable: 'Carlos Rodríguez',
                inicio: '10/03/2024',
                fin: '10/03/2025',
                presupuesto: 52300000
            }
        };
        
        // Cambiar versión de presupuesto
        versionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                versionBtns.forEach(b => {
                    b.classList.remove('active');
                    b.style.backgroundColor = 'transparent';
                    b.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                alert(`Cambiando a vista: ${this.textContent.trim()}`);
            });
        });
        
        // Cambiar entre pestañas de presupuesto
        presupuestoTabs.forEach((tab, index) => {
            tab.addEventListener('click', function() {
                presupuestoTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                presupuestoContents.forEach(content => content.style.display = 'none');
                presupuestoContents[index].style.display = 'block';
            });
        });
        
        // Selector de proyecto
        if (selectorProyecto) {
            selectorProyecto.addEventListener('change', function() {
                const proyectoId = this.value;
                
                if (proyectoId && proyectosData[proyectoId]) {
                    const proy = proyectosData[proyectoId];
                    infoProyecto.style.display = 'block';
                    infoProyecto.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                            <div>
                                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Proyecto seleccionado</div>
                                <h3 style="font-size: 24px; font-weight: 600; margin: 0;">${proyectoId} - ${proy.nombre}</h3>
                                <div style="display: flex; gap: 20px; margin-top: 10px; flex-wrap: wrap;">
                                    <span><i class="fas fa-user-tie"></i> Responsable: ${proy.responsable}</span>
                                    <span><i class="fas fa-calendar"></i> Inicio: ${proy.inicio}</span>
                                    <span><i class="fas fa-calendar-check"></i> Fin: ${proy.fin}</span>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 14px; opacity: 0.9;">Presupuesto Total</div>
                                <div style="font-size: 36px; font-weight: 700;">$${proy.presupuesto.toLocaleString()}</div>
                                <div style="font-size: 14px; margin-top: 5px;">MXN</div>
                            </div>
                        </div>
                    `;
                } else {
                    infoProyecto.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                            <div>
                                <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Proyecto seleccionado</div>
                                <h3 style="font-size: 24px; font-weight: 600; margin: 0;">Seleccione un proyecto</h3>
                                <div style="margin-top: 10px;">Elija un proyecto de la lista para ver su presupuesto</div>
                            </div>
                        </div>
                    `;
                }
            });
        }
        
        // Modal nuevo presupuesto
        if (btnNuevoPresupuesto) {
            btnNuevoPresupuesto.addEventListener('click', function() {
                modalNuevoPresupuesto.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        function cerrarModalPresupuesto() {
            modalNuevoPresupuesto.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModalPresupuesto) {
            btnCerrarModalPresupuesto.addEventListener('click', cerrarModalPresupuesto);
        }
        
        if (btnCancelarPresupuesto) {
            btnCancelarPresupuesto.addEventListener('click', cerrarModalPresupuesto);
        }
        
        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalNuevoPresupuesto) {
                cerrarModalPresupuesto();
            }
        });
        
        // Botón comparar
        if (btnComparar) {
            btnComparar.addEventListener('click', function() {
                alert('Función de comparación de presupuestos');
            });
        }
        
        // Botón exportar
        if (btnExportar) {
            btnExportar.addEventListener('click', function() {
                alert('Exportando presupuesto a Excel...');
            });
        }
        
        // Acciones en conceptos
        document.querySelectorAll('#tab-conceptos .fa-eye, #tab-conceptos .fa-edit, #tab-conceptos .fa-copy').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-eye')) {
                    alert('Ver detalle del concepto');
                } else if (this.classList.contains('fa-edit')) {
                    alert('Editar concepto');
                } else if (this.classList.contains('fa-copy')) {
                    alert('Duplicar concepto');
                }
            });
        });
        
        // Acciones en variaciones
        document.querySelectorAll('#tab-variaciones .fa-eye, #tab-variaciones .fa-download, #tab-variaciones .fa-edit').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-eye')) {
                    alert('Ver detalle de orden de cambio');
                } else if (this.classList.contains('fa-download')) {
                    alert('Descargando documento...');
                } else if (this.classList.contains('fa-edit')) {
                    alert('Editar orden de cambio');
                }
            });
        });
        
        // Acciones en documentos
        document.querySelectorAll('#tab-documentos .fa-download, #tab-documentos .fa-eye').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('fa-download')) {
                    alert('Descargando archivo...');
                } else if (this.classList.contains('fa-eye')) {
                    alert('Vista previa del archivo');
                }
            });
        });
        
        // File input
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    alert(`Archivo seleccionado: ${this.files[0].name}`);
                }
            });
        }
        
        // Inicializar info proyecto (oculto hasta selección)
        infoProyecto.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <div style="font-size: 14px; opacity: 0.9; margin-bottom: 5px;">Proyecto seleccionado</div>
                    <h3 style="font-size: 24px; font-weight: 600; margin: 0;">Seleccione un proyecto</h3>
                    <div style="margin-top: 10px;">Elija un proyecto de la lista para ver su presupuesto</div>
                </div>
            </div>
        `;
    });
</script>
@endsection