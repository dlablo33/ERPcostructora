@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Pendiente de Facturar -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Pendiente de Facturar
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Por Facturar Total -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleKPI('Por Facturar Total', '$42.3M', '15 proyectos pendientes')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Facturar Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$42.3M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Avance por Facturar -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleKPI('Avance por Facturar', '$18.6M', '8 estimaciones de avance')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Avance por Facturar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$18.6M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Anticipos Pendientes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleKPI('Anticipos Pendientes', '$8.7M', '4 contratos con anticipo')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Anticipos Pendientes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$8.7M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Facturas por Emitir -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetalleKPI('Facturas por Emitir', '24', '12 vencen esta semana')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas por Emitir</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">24</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas (solo filtros) -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores de filtro -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 180px;">
                                <option value="">Todos los tipos</option>
                                <option value="avance" selected>📊 Estimación de Avance</option>
                                <option value="anticipo">💰 Anticipo</option>
                                <option value="adicional">➕ Obra Adicional</option>
                                <option value="penalizacion">⚠️ Penalización</option>
                                <option value="ajuste">🔄 Ajuste de Contrato</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                <option value="torre" selected>🏢 Torre Norte Corporativa</option>
                                <option value="puente">🌉 Puente Vehicular Sur</option>
                                <option value="parque">🏭 Parque Industrial Norte</option>
                                <option value="hospital">🏥 Hospital Regional</option>
                                <option value="planta">💧 Planta de Tratamiento</option>
                                <option value="urbanizacion">🏘️ Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorCliente" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los clientes</option>
                                <option value="gobierno" selected>🏛️ Gobierno Regional</option>
                                <option value="inmobiliaria">🏢 Inmobiliaria del Norte</option>
                                <option value="constructora">🏗️ Constructora ABC</option>
                                <option value="empresas">🏭 Empresas López</option>
                                <option value="desarrollos">🏘️ Desarrollos del Sur</option>
                            </select>
                        </div>

                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-03-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                    </div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar concepto, proyecto..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 250px;">
                    </div>
                </div>

                <!-- GRÁFICOS PRINCIPALES -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Pendiente por Proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; cursor: pointer;" onclick="verDetalleGrafico('Pendiente por Proyecto')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-bar"></i> Pendiente de Facturar por Proyecto
                            <i class="fas fa-search-plus" style="float: right; font-size: 14px; color: #6c757d;"></i>
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 15px; justify-content: center;">
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 140px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Torre</div>
                                <div style="font-size: 10px;">$14.2M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 110px; background: linear-gradient(to top, #28a745, #34ce57); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Hospital</div>
                                <div style="font-size: 10px;">$11.5M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 80px; background: linear-gradient(to top, #ffc107, #ffdb6e); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Parque</div>
                                <div style="font-size: 10px;">$8.2M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 60px; background: linear-gradient(to top, #fd7e14, #ff9f4b); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Puente</div>
                                <div style="font-size: 10px;">$5.8M</div>
                            </div>
                            <div style="text-align: center; width: 70px;">
                                <div style="height: 40px; background: linear-gradient(to top, #17a2b8, #5fc1d1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-size: 11px;">Urb.</div>
                                <div style="font-size: 10px;">$2.6M</div>
                            </div>
                        </div>
                    </div>

                    <!-- Distribución por Tipo -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; cursor: pointer;" onclick="verDetalleGrafico('Distribución por Tipo')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-pie"></i> Por Tipo de Concepto
                            <i class="fas fa-search-plus" style="float: right; font-size: 14px; color: #6c757d;"></i>
                        </h4>
                        <div style="margin-top: 20px;">
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #083CAE; border-radius: 50%; margin-right: 5px;"></span> Estimaciones</span>
                                    <span style="font-size: 13px; font-weight: 600;">$18.6M (44%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 44%; height: 6px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #28a745; border-radius: 50%; margin-right: 5px;"></span> Anticipos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$8.7M (21%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 21%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Obras Adicionales</span>
                                    <span style="font-size: 13px; font-weight: 600;">$7.2M (17%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 17%; height: 6px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #fd7e14; border-radius: 50%; margin-right: 5px;"></span> Ajustes</span>
                                    <span style="font-size: 13px; font-weight: 600;">$4.8M (11%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 11%; height: 6px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #dc3545; border-radius: 50%; margin-right: 5px;"></span> Penalizaciones</span>
                                    <span style="font-size: 13px; font-weight: 600;">$3.0M (7%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 7%; height: 6px; background-color: #dc3545; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Por Cliente -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Pendiente por Cliente')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-building"></i> Pendiente por Cliente
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Gobierno Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">$15.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Inmobiliaria del Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12.4M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 78%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Constructora ABC</span>
                                    <span style="font-size: 13px; font-weight: 600;">$8.2M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 52%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Empresas López</span>
                                    <span style="font-size: 13px; font-weight: 600;">$5.9M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 37%; height: 8px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos a Vencer -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Próximos a Vencer')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-exclamation-triangle"></i> Próximos a Vencer (7 días)
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Estimación #8 - Torre Norte', event)">
                                <span style="background-color: #dc3545; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Estimación #8 - Torre Norte</div>
                                    <div style="font-size: 11px; color: #6c757d;">Vence mañana • $2.8M</div>
                                </div>
                                <span style="background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px;">Urgente</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Anticipo - Hospital Regional', event)">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">2</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Anticipo - Hospital</div>
                                    <div style="font-size: 11px; color: #6c757d;">Vence en 3 días • $1.5M</div>
                                </div>
                                <span style="background-color: #ffc107; color: #856404; padding: 2px 6px; border-radius: 4px; font-size: 10px;">Próximo</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetalleConcepto('Obra Adicional #2 - Parque Industrial', event)">
                                <span style="background-color: #ffc107; color: #856404; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">3</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Obra Adicional #2 - Parque</div>
                                    <div style="font-size: 11px; color: #6c757d;">Vence en 5 días • $980K</div>
                                </div>
                                <span style="background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px;">Programado</span>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen por Mes -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Vencimientos por Mes')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-calendar-alt"></i> Vencimientos por Mes
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">Abril 2026</span>
                                <span style="font-weight: 600; color: #dc3545;">$18.2M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">Mayo 2026</span>
                                <span style="font-weight: 600; color: #ffc107;">$12.5M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">Junio 2026</span>
                                <span style="font-weight: 600; color: #28a745;">$8.7M</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px;">Julio 2026+</span>
                                <span style="font-weight: 600; color: #17a2b8;">$2.9M</span>
                            </div>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 13px; font-weight: 600;">Total</span>
                                    <span style="font-size: 13px; font-weight: 600;">$42.3M</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE PENDIENTES -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Concepto</th>
                                <th style="padding: 12px 8px; text-align: left;">Tipo</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: right;">Monto</th>
                                <th style="padding: 12px 8px; text-align: center;">Fecha Estimación</th>
                                <th style="padding: 12px 8px; text-align: center;">Fecha Límite</th>
                                <th style="padding: 12px 8px; text-align: center;">Días</th>
                                <th style="padding: 12px 8px; text-align: center;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Estimación #8 - Torre Norte')">
                                <td style="padding: 10px 8px; font-weight: 600;">Estimación #8</td>
                                <td style="padding: 10px 8px;">📊 Avance</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-15</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-30</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #dc3545; font-weight: 600;">1 día</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Estimación #8 - Torre Norte', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Anticipo Contractual - Hospital Regional')">
                                <td style="padding: 10px 8px; font-weight: 600;">Anticipo Contractual</td>
                                <td style="padding: 10px 8px;">💰 Anticipo</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,500,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-10</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-02</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #ffc107; font-weight: 600;">4 días</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Anticipo Contractual - Hospital Regional', event)"></i>
                                </td>
                            </tr>
                            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Obra Adicional #2 - Parque Industrial')">
                                <td style="padding: 10px 8px; font-weight: 600;">Obra Adicional #2</td>
                                <td style="padding: 10px 8px;">➕ Adicional</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px; text-align: right;">$980,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-12</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-05</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #ffc107; font-weight: 600;">7 días</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Obra Adicional #2 - Parque Industrial', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Ajuste de Precios - Puente Sur')">
                                <td style="padding: 10px 8px; font-weight: 600;">Ajuste de Precios</td>
                                <td style="padding: 10px 8px;">🔄 Ajuste</td>
                                <td style="padding: 10px 8px;">Puente Sur</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,200,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-08</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-08</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #28a745; font-weight: 600;">10 días</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Ajuste de Precios - Puente Sur', event)"></i>
                                </td>
                            </tr>
                            <tr style="cursor: pointer;" onclick="verDetalleConcepto('Penalización por Retraso - Urbanización Los Álamos')">
                                <td style="padding: 10px 8px; font-weight: 600;">Penalización por Retraso</td>
                                <td style="padding: 10px 8px;">⚠️ Penalización</td>
                                <td style="padding: 10px 8px;">Urbanización Los Álamos</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$450,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-05</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-10</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #28a745; font-weight: 600;">12 días</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Penalización por Retraso - Urbanización Los Álamos', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetalleConcepto('Estimación #5 - Torre Norte')">
                                <td style="padding: 10px 8px; font-weight: 600;">Estimación #5</td>
                                <td style="padding: 10px 8px;">📊 Avance</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,850,000</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-03-01</td>
                                <td style="padding: 10px 8px; text-align: center;">2026-04-15</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="color: #28a745; font-weight: 600;">17 días</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetalleConcepto('Estimación #5 - Torre Norte', event)"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totales -->
                <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
                    <div style="display: flex; gap: 30px;">
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Pendiente:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">$42.3M</span>
                        </div>
                    </div>
                </div>

                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 10px;">
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

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i> <span id="modalTitulo">Detalle del Concepto</span>
            </h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;" id="modalContenido">
            <!-- Contenido dinámico -->
        </div>
    </div>
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
    
    /* Cursor pointer para filas clickeables */
    tbody tr {
        cursor: pointer;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="grid-template-columns: 1fr 1fr 1fr"] {
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
        console.log('Pendiente de Facturar cargado - Solo vista');
        
        // Filtros (solo para visualización)
        const tipoSelect = document.getElementById('selectorTipo');
        if (tipoSelect) {
            tipoSelect.addEventListener('change', function() {
                console.log('Filtrando por tipo:', this.value);
            });
        }
        
        const proyectoSelect = document.getElementById('selectorProyecto');
        if (proyectoSelect) {
            proyectoSelect.addEventListener('change', function() {
                console.log('Filtrando por proyecto:', this.value);
            });
        }
        
        const clienteSelect = document.getElementById('selectorCliente');
        if (clienteSelect) {
            clienteSelect.addEventListener('change', function() {
                console.log('Filtrando por cliente:', this.value);
            });
        }
        
        // Buscador
        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    console.log('Buscando: ' + this.value);
                }
            });
        }
    });
    
    // Función para ver detalle de KPI
    function verDetalleKPI(titulo, valor, descripcion) {
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = titulo;
        
        modalContenido.innerHTML = `
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-size: 48px; font-weight: bold; color: #083CAE;">${valor}</div>
                <div style="font-size: 16px; color: #6c757d; margin-top: 10px;">${descripcion}</div>
            </div>
            <div style="border-top: 1px solid #dee2e6; padding-top: 20px;">
                <h4 style="color: #083CAE; margin-bottom: 15px;">Desglose</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Torre Norte</span>
                        <span style="font-weight: 600;">$14.2M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Hospital Regional</span>
                        <span style="font-weight: 600;">$11.5M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Parque Industrial</span>
                        <span style="font-weight: 600;">$8.2M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Puente Sur</span>
                        <span style="font-weight: 600;">$5.8M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Urbanización Los Álamos</span>
                        <span style="font-weight: 600;">$2.6M</span>
                    </div>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Función para ver detalle de gráfico
    function verDetalleGrafico(titulo) {
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = titulo;
        
        modalContenido.innerHTML = `
            <div style="margin-bottom: 20px;">
                <p style="color: #6c757d;">Vista detallada del gráfico</p>
                <div style="height: 200px; display: flex; align-items: flex-end; gap: 20px; justify-content: center; margin: 20px 0;">
                    <div style="text-align: center;">
                        <div style="height: 140px; width: 40px; background: #083CAE; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Torre</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="height: 110px; width: 40px; background: #28a745; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Hosp.</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="height: 80px; width: 40px; background: #ffc107; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Parq.</div>
                    </div>
                </div>
                <p style="text-align: center; color: #6c757d;">Datos actualizados al 31/03/2026</p>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Función para ver detalle de concepto
    function verDetalleConcepto(concepto, event) {
        if (event) {
            event.stopPropagation();
        }
        
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = concepto;
        
        modalContenido.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Tipo</div>
                    <div style="font-size: 16px; font-weight: 600;">📊 Estimación de Avance</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Monto</div>
                    <div style="font-size: 20px; font-weight: 700; color: #28a745;">$2,850,000</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                    <div style="font-size: 14px; font-weight: 600;">Torre Norte Corporativa</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Cliente</div>
                    <div style="font-size: 14px; font-weight: 600;">Inmobiliaria del Norte</div>
                </div>
            </div>
            
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Fecha Estimación</div>
                        <div style="font-size: 14px;">2026-03-15</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Fecha Límite</div>
                        <div style="font-size: 14px;">2026-03-30</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Días Restantes</div>
                        <div style="font-size: 16px; font-weight: 600; color: #dc3545;">1 día</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Estado</div>
                        <div><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Urgente</span></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                    Estimación de avance correspondiente al mes de marzo 2026. Incluye obra civil, instalaciones y acabados.
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Documentos Relacionados</div>
                <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                    <li>Estimación #8 - PDF</li>
                    <li>Reporte de Avance - Marzo 2026</li>
                    <li>Generador de Obra</li>
                </ul>
            </div>
            
            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Historial de Cambios</div>
                <div style="font-size: 12px;">
                    <div>2026-03-15: Creada por Juan Pérez</div>
                    <div>2026-03-16: Enviada a revisión</div>
                    <div>2026-03-18: Aprobada por cliente</div>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Cerrar modal
    document.addEventListener('DOMContentLoaded', function() {
        const btnCerrar = document.getElementById('btnCerrarModal');
        const modal = document.getElementById('modalVerDetalle');
        
        if (btnCerrar) {
            btnCerrar.addEventListener('click', function() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
@endsection