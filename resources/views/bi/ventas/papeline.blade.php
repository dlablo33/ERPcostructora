@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Pipeline de Ventas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-funnel-dollar" style="margin-right: 10px;"></i>
                    Pipeline de Ventas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Oportunidades Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Oportunidades Activas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">86</div>
                            <div style="font-size: 12px; color: #28a745; margin-top: 2px;"><i class="fas fa-arrow-up"></i> +12 vs mes ant</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Valor Total Pipeline -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Valor Total Pipeline</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$245.8M</div>
                            <div style="font-size: 12px; color: #28a745; margin-top: 2px;"><i class="fas fa-arrow-up"></i> +18.3% vs mes ant</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Ponderado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pipeline Ponderado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$98.3M</div>
                            <div style="font-size: 12px; color: #28a745; margin-top: 2px;">40% probabilidad</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Ciclo Promedio -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Ciclo Promedio</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">45 días</div>
                            <div style="font-size: 12px; color: #28a745; margin-top: 2px;"><i class="fas fa-arrow-down"></i> -5 días vs mes ant</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorEtapa" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                                <option value="">Todas las etapas</option>
                                <option value="prospeccion">🔍 Prospección</option>
                                <option value="contacto" selected>📞 Primer Contacto</option>
                                <option value="calificacion">📋 Calificación</option>
                                <option value="propuesta">📄 Propuesta</option>
                                <option value="negociacion">🤝 Negociación</option>
                                <option value="cierre">✅ Cierre</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorVendedor" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                                <option value="">Todos los vendedores</option>
                                <option value="juan" selected>👤 Juan Pérez</option>
                                <option value="maria">👩 María García</option>
                                <option value="carlos">👨 Carlos López</option>
                                <option value="ana">👩 Ana Martínez</option>
                                <option value="roberto">👨 Roberto Sánchez</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProbabilidad" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="">Probabilidad</option>
                                <option value="25">25% - Baja</option>
                                <option value="50">50% - Media</option>
                                <option value="75">75% - Alta</option>
                                <option value="90">90% - Muy Alta</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <!-- Botón Nueva Oportunidad -->
                        <div>
                            <button id="btnNueva" 
                                    style="background-color: #083CAE; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;">
                                <i class="fas fa-plus"></i> Nueva Oportunidad
                            </button>
                        </div>

                        <!-- Botón Vista Kanban -->
                        <div>
                            <button id="btnKanban" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;">
                                <i class="fas fa-columns"></i> Vista Kanban
                            </button>
                        </div>

                        <!-- Botón Exportar -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar oportunidad, cliente..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- VISUALIZACIÓN DEL PIPELINE (KANBAN) -->
                <div style="margin-bottom: 20px;">
                    <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                        <i class="fas fa-funnel-dollar"></i> Pipeline por Etapa
                    </h4>
                    
                    <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; overflow-x: auto; padding-bottom: 10px;">
                        <!-- Etapa 1: Prospección -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #6c757d; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">🔍 Prospección</span>
                                <span style="background-color: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px;">12</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Constructora ABC</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Parque Industrial</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$2.8M</span>
                                        <span style="background-color: #ffc107; color: #856404; padding: 2px 6px; border-radius: 12px; font-size: 10px;">20%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 15/03</span>
                                        <span><i class="far fa-user"></i> Juan P.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Gobierno Regional</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Hospital</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$4.5M</span>
                                        <span style="background-color: #ffc107; color: #856404; padding: 2px 6px; border-radius: 12px; font-size: 10px;">20%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 14/03</span>
                                        <span><i class="far fa-user"></i> María G.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Inmobiliaria Norte</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Torre Norte</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$1.2M</span>
                                        <span style="background-color: #ffc107; color: #856404; padding: 2px 6px; border-radius: 12px; font-size: 10px;">15%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 13/03</span>
                                        <span><i class="far fa-user"></i> Carlos L.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>

                        <!-- Etapa 2: Primer Contacto -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #17a2b8; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">📞 Primer Contacto</span>
                                <span style="background-color: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px;">18</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Desarrollos del Sur</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Puente Sur</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$3.2M</span>
                                        <span style="background-color: #fd7e14; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">30%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 12/03</span>
                                        <span><i class="far fa-user"></i> Ana M.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Grupo Industrial</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Parque Industrial</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$5.1M</span>
                                        <span style="background-color: #fd7e14; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">35%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 11/03</span>
                                        <span><i class="far fa-user"></i> Juan P.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>

                        <!-- Etapa 3: Calificación -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #ffc107; color: #856404; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">📋 Calificación</span>
                                <span style="background-color: rgba(0,0,0,0.1); padding: 2px 8px; border-radius: 12px;">15</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Empresas López</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Torre Norte</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$2.1M</span>
                                        <span style="background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">45%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 10/03</span>
                                        <span><i class="far fa-user"></i> María G.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Constructora del Valle</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Planta Tratamiento</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$3.8M</span>
                                        <span style="background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">50%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 09/03</span>
                                        <span><i class="far fa-user"></i> Roberto S.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>

                        <!-- Etapa 4: Propuesta -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #fd7e14; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">📄 Propuesta</span>
                                <span style="background-color: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px;">14</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Hospital Regional</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Equipamiento</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$6.2M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">65%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 08/03</span>
                                        <span><i class="far fa-user"></i> Ana M.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Urbanizadora Los Álamos</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Viviendas</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$4.5M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">70%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 07/03</span>
                                        <span><i class="far fa-user"></i> Carlos L.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>

                        <!-- Etapa 5: Negociación -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #28a745; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">🤝 Negociación</span>
                                <span style="background-color: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px;">11</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Gobierno Estatal</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Hospital Regional</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$8.5M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">85%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 06/03</span>
                                        <span><i class="far fa-user"></i> Juan P.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Inmobiliaria Centro</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Torre Norte</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$3.2M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">80%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 05/03</span>
                                        <span><i class="far fa-user"></i> María G.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>

                        <!-- Etapa 6: Cierre -->
                        <div style="min-width: 180px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                            <div style="background-color: #083CAE; color: white; padding: 10px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">✅ Cierre</span>
                                <span style="background-color: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px;">8</span>
                            </div>
                            <div style="padding: 10px; min-height: 300px;">
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Constructora Moderna</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Parque Industrial</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$2.9M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">95%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 04/03</span>
                                        <span><i class="far fa-user"></i> Ana M.</span>
                                    </div>
                                </div>
                                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    <div style="font-weight: 600; font-size: 13px;">Empresas del Sur</div>
                                    <div style="font-size: 11px; color: #6c757d; margin: 5px 0;">Puente Sur</div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600;">$4.1M</span>
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 12px; font-size: 10px;">90%</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 10px; color: #6c757d;">
                                        <span><i class="far fa-calendar"></i> 03/03</span>
                                        <span><i class="far fa-user"></i> Roberto S.</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 10px; border-top: 1px solid #dee2e6; text-align: center;">
                                <span style="color: #083CAE; font-size: 12px; cursor: pointer;"><i class="fas fa-plus"></i> Agregar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICO DE PIPELINE -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Valor por Etapa -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-bar"></i> Valor del Pipeline por Etapa
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 60px; background-color: #6c757d; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Prospec.</div>
                                <div style="font-size: 10px;">$8.5M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 80px; background-color: #17a2b8; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Contacto</div>
                                <div style="font-size: 10px;">$12.3M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 100px; background-color: #ffc107; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Calif.</div>
                                <div style="font-size: 10px;">$18.5M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 130px; background-color: #fd7e14; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Propuesta</div>
                                <div style="font-size: 10px;">$24.2M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 110px; background-color: #28a745; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Negoc.</div>
                                <div style="font-size: 10px;">$20.8M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 70px; background-color: #083CAE; width: 40px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Cierre</div>
                                <div style="font-size: 10px;">$15.2M</div>
                            </div>
                        </div>
                    </div>

                    <!-- Distribución por Vendedor -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-user-tie"></i> Pipeline por Vendedor
                        </h4>
                        <div style="margin-top: 15px;">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <div style="width: 100px; font-size: 13px;">Juan Pérez</div>
                                <div style="flex: 1; height: 8px; background-color: #e9ecef; border-radius: 4px; margin: 0 10px;">
                                    <div style="width: 85%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                                <div style="font-weight: 600; font-size: 13px;">$42.5M</div>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <div style="width: 100px; font-size: 13px;">María García</div>
                                <div style="flex: 1; height: 8px; background-color: #e9ecef; border-radius: 4px; margin: 0 10px;">
                                    <div style="width: 72%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                                <div style="font-weight: 600; font-size: 13px;">$36.2M</div>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <div style="width: 100px; font-size: 13px;">Carlos López</div>
                                <div style="flex: 1; height: 8px; background-color: #e9ecef; border-radius: 4px; margin: 0 10px;">
                                    <div style="width: 68%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                                <div style="font-weight: 600; font-size: 13px;">$34.1M</div>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <div style="width: 100px; font-size: 13px;">Ana Martínez</div>
                                <div style="flex: 1; height: 8px; background-color: #e9ecef; border-radius: 4px; margin: 0 10px;">
                                    <div style="width: 62%; height: 8px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                                <div style="font-weight: 600; font-size: 13px;">$31.8M</div>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 100px; font-size: 13px;">Roberto Sánchez</div>
                                <div style="flex: 1; height: 8px; background-color: #e9ecef; border-radius: 4px; margin: 0 10px;">
                                    <div style="width: 55%; height: 8px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                                <div style="font-weight: 600; font-size: 13px;">$27.4M</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE OPORTUNIDADES -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Oportunidad</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: center;">Etapa</th>
                                <th style="padding: 12px 8px; text-align: center;">Prob.</th>
                                <th style="padding: 12px 8px; text-align: right;">Valor</th>
                                <th style="padding: 12px 8px; text-align: right;">Ponderado</th>
                                <th style="padding: 12px 8px; text-align: center;">Vendedor</th>
                                <th style="padding: 12px 8px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-045</td>
                                <td style="padding: 10px 8px;">Gobierno Estatal</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Negociación</span></td>
                                <td style="padding: 10px 8px; text-align: center;">85%</td>
                                <td style="padding: 10px 8px; text-align: right;">$8,500,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$7,225,000</td>
                                <td style="padding: 10px 8px; text-align: center;">Juan P.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-042</td>
                                <td style="padding: 10px 8px;">Constructora Moderna</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #083CAE; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Cierre</span></td>
                                <td style="padding: 10px 8px; text-align: center;">95%</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,900,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$2,755,000</td>
                                <td style="padding: 10px 8px; text-align: center;">Ana M.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-038</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px;">Equipamiento</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Propuesta</span></td>
                                <td style="padding: 10px 8px; text-align: center;">65%</td>
                                <td style="padding: 10px 8px; text-align: right;">$6,200,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$4,030,000</td>
                                <td style="padding: 10px 8px; text-align: center;">Ana M.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-035</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Calificación</span></td>
                                <td style="padding: 10px 8px; text-align: center;">45%</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,100,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$945,000</td>
                                <td style="padding: 10px 8px; text-align: center;">María G.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-032</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px;">Puente Sur</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Primer Contacto</span></td>
                                <td style="padding: 10px 8px; text-align: center;">30%</td>
                                <td style="padding: 10px 8px; text-align: right;">$3,200,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$960,000</td>
                                <td style="padding: 10px 8px; text-align: center;">Ana M.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; font-weight: 600;">OP-2026-028</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Prospección</span></td>
                                <td style="padding: 10px 8px; text-align: center;">20%</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,800,000</td>
                                <td style="padding: 10px 8px; text-align: right; font-weight: 600;">$560,000</td>
                                <td style="padding: 10px 8px; text-align: center;">Juan P.</td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-edit" style="color: #ffc107; cursor: pointer; margin: 0 3px;"></i>
                                    <i class="fas fa-arrow-right" style="color: #28a745; cursor: pointer; margin: 0 3px;"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totales del Pipeline -->
                <div style="display: flex; justify-content: flex-end; gap: 30px; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 8px;">
                    <div>
                        <span style="color: #6c757d; font-size: 13px;">Total Pipeline:</span>
                        <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">$245.8M</span>
                    </div>
                    <div>
                        <span style="color: #6c757d; font-size: 13px;">Pipeline Ponderado:</span>
                        <span style="font-weight: 600; font-size: 16px; margin-left: 10px; color: #28a745;">$98.3M</span>
                    </div>
                    <div>
                        <span style="color: #6c757d; font-size: 13px;">Oportunidades:</span>
                        <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">86</span>
                    </div>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 86 oportunidades
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Anterior</button>
                        <button style="padding: 5px 10px; border: 1px solid #083CAE; background-color: #083CAE; color: white; border-radius: 4px; cursor: pointer;">1</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">2</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">3</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">4</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">5</button>
                        <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer;">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
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
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        color: #000000 !important;
    }
    
    /* Estilo para las filas alternadas */
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    tbody tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    td i {
        transition: transform 0.2s;
        cursor: pointer;
    }
    
    td i:hover {
        transform: scale(1.2);
    }
    
    /* Estilo para las tarjetas Kanban */
    #etapasContainer {
        scrollbar-width: thin;
        scrollbar-color: #083CAE #f1f1f1;
    }
    
    #etapasContainer::-webkit-scrollbar {
        height: 8px;
    }
    
    #etapasContainer::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #etapasContainer::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }
    
    #etapasContainer::-webkit-scrollbar-thumb:hover {
        background: #052a6b;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        .custom-card {
            min-width: 100% !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Pipeline de Ventas cargado');
        
        // Botones principales
        document.getElementById('btnNueva')?.addEventListener('click', function() {
            alert('Crear nueva oportunidad');
        });
        
        document.getElementById('btnKanban')?.addEventListener('click', function() {
            alert('Cambiando a vista Kanban');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            alert('Exportando pipeline a Excel...');
        });
        
        // Acciones de tabla
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Ver detalle de oportunidad');
            });
        });
        
        document.querySelectorAll('.fa-edit').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Editar oportunidad');
            });
        });
        
        document.querySelectorAll('.fa-arrow-right').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Avanzar oportunidad a siguiente etapa');
            });
        });
        
        // Agregar oportunidad en Kanban
        document.querySelectorAll('div[style*="text-align: center;"] span').forEach(span => {
            if (span.textContent.includes('Agregar')) {
                span.addEventListener('click', function() {
                    alert('Agregar nueva oportunidad a esta etapa');
                });
            }
        });
        
        // Filtros
        const etapaSelect = document.getElementById('selectorEtapa');
        if (etapaSelect) {
            etapaSelect.addEventListener('change', function() {
                console.log('Filtrando por etapa:', this.value);
            });
        }
        
        const vendedorSelect = document.getElementById('selectorVendedor');
        if (vendedorSelect) {
            vendedorSelect.addEventListener('change', function() {
                console.log('Filtrando por vendedor:', this.value);
            });
        }
        
        const probSelect = document.getElementById('selectorProbabilidad');
        if (probSelect) {
            probSelect.addEventListener('change', function() {
                console.log('Filtrando por probabilidad:', this.value);
            });
        }
        
        // Buscador
        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    alert('Buscando: ' + this.value);
                }
            });
        }
    });
</script>
@endsection