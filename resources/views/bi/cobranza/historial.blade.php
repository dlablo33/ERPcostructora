@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Historial de Pagos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                
                    Historial de Pagos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE KPI's PRINCIPALES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Cobrado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetallePago('Total Cobrado', '$86.5M', 'Últimos 12 meses')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Cobrado</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$86.5M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Pagos del Mes -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetallePago('Pagos del Mes', '$12.8M', '8 pagos recibidos')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagos del Mes</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$12.8M</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pago Promedio -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetallePago('Pago Promedio', '$342K', 'Por transacción')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pago Promedio</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">$342K</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Días Promedio Pago -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px; cursor: pointer;" onclick="verDetallePago('Días Promedio Pago', '38 días', '+3 días vs objetivo')">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Días Promedio Pago</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;">38 días</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas (solo filtros) -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                    <!-- Selectores de filtro -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <select id="selectorPeriodo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="mes">Este mes</option>
                                <option value="trimestre" selected>Este trimestre</option>
                                <option value="semestre">Este semestre</option>
                                <option value="año">Este año</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los proyectos</option>
                                <option value="torre" selected> Torre Norte Corporativa</option>
                                <option value="puente"> Puente Vehicular Sur</option>
                                <option value="parque"> Parque Industrial Norte</option>
                                <option value="hospital"> Hospital Regional</option>
                                <option value="planta"> Planta de Tratamiento</option>
                                <option value="urbanizacion"> Urbanización Los Álamos</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorCliente" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 200px;">
                                <option value="">Todos los clientes</option>
                                <option value="gobierno" selected> Gobierno Regional</option>
                                <option value="inmobiliaria"> Inmobiliaria del Norte</option>
                                <option value="constructora"> Constructora ABC</option>
                                <option value="empresas">Empresas López</option>
                                <option value="desarrollos"> Desarrollos del Sur</option>
                            </select>
                        </div>

                        <div>
                            <select id="selectorMetodoPago" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                                <option value="">Todos los métodos</option>
                                <option value="transferencia" selected> Transferencia</option>
                                <option value="cheque"> Cheque</option>
                                <option value="efectivo"> Efectivo</option>
                                <option value="tarjeta"> Tarjeta</option>
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
                        <input type="text" id="buscador" placeholder="Buscar pago, factura..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 250px;">
                    </div>
                </div>

                <!-- GRÁFICOS PRINCIPALES -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Evolución de Pagos -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; cursor: pointer;" onclick="verDetalleGrafico('Evolución de Pagos - 1er Trimestre 2026')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-line"></i> Evolución de Pagos - 1er Trimestre 2026
                            <i class="fas fa-search-plus" style="float: right; font-size: 14px; color: #6c757d;"></i>
                        </h4>
                        <div style="height: 200px; display: flex; align-items: flex-end; gap: 30px; justify-content: center;">
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 100px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Enero</div>
                                <div style="font-size: 12px; color: #083CAE;">$8.2M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 130px; background: linear-gradient(to top, #083CAE, #2378e1); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Febrero</div>
                                <div style="font-size: 12px; color: #083CAE;">$10.5M</div>
                            </div>
                            <div style="text-align: center; width: 80px;">
                                <div style="height: 160px; background: linear-gradient(to top, #28a745, #34ce57); width: 50px; margin: 0 auto; border-radius: 4px 4px 0 0;"></div>
                                <div style="margin-top: 5px; font-weight: 600;">Marzo</div>
                                <div style="font-size: 12px; color: #28a745;">$12.8M</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #083CAE; margin-right: 5px;"></span> 2025</span>
                            <span style="font-size: 12px; display: flex; align-items: center;"><span style="display: inline-block; width: 12px; height: 12px; background-color: #28a745; margin-right: 5px;"></span> 2026</span>
                        </div>
                    </div>

                    <!-- Pagos por Método -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; cursor: pointer;" onclick="verDetalleGrafico('Pagos por Método')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 16px;">
                            <i class="fas fa-chart-pie"></i> Pagos por Método
                            <i class="fas fa-search-plus" style="float: right; font-size: 14px; color: #6c757d;"></i>
                        </h4>
                        <div style="margin-top: 20px;">
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #083CAE; border-radius: 50%; margin-right: 5px;"></span> Transferencia</span>
                                    <span style="font-size: 13px; font-weight: 600;">$58.2M (67%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 67%; height: 6px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #28a745; border-radius: 50%; margin-right: 5px;"></span> Cheque</span>
                                    <span style="font-size: 13px; font-weight: 600;">$18.5M (21%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 21%; height: 6px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #ffc107; border-radius: 50%; margin-right: 5px;"></span> Efectivo</span>
                                    <span style="font-size: 13px; font-weight: 600;">$6.8M (8%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 8%; height: 6px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;"><span style="display: inline-block; width: 10px; height: 10px; background-color: #17a2b8; border-radius: 50%; margin-right: 5px;"></span> Tarjeta</span>
                                    <span style="font-size: 13px; font-weight: 600;">$3.0M (4%)</span>
                                </div>
                                <div style="width: 100%; height: 6px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 4%; height: 6px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA DE GRÁFICOS -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <!-- Top Clientes Pagadores -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Top Clientes Pagadores')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-trophy"></i> Top Clientes Pagadores
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #083CAE; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Gobierno Regional</div>
                                    <div style="font-size: 11px; color: #6c757d;">12 pagos</div>
                                </div>
                                <div style="font-weight: 600;">$28.5M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #6c757d; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">2</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Inmobiliaria del Norte</div>
                                    <div style="font-size: 11px; color: #6c757d;">8 pagos</div>
                                </div>
                                <div style="font-weight: 600;">$18.2M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #cd7f32; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">3</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Constructora ABC</div>
                                    <div style="font-size: 11px; color: #6c757d;">6 pagos</div>
                                </div>
                                <div style="font-weight: 600;">$12.8M</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="background-color: #e9ecef; color: #495057; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">4</span>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">Empresas López</div>
                                    <div style="font-size: 11px; color: #6c757d;">5 pagos</div>
                                </div>
                                <div style="font-weight: 600;">$8.6M</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagos por Proyecto -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px; cursor: pointer;" onclick="verDetalleGrafico('Pagos por Proyecto')">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-chart-bar"></i> Pagos por Proyecto
                            <i class="fas fa-search-plus" style="float: right; font-size: 12px; color: #6c757d;"></i>
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Torre Norte</span>
                                    <span style="font-size: 13px; font-weight: 600;">$28.5M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 100%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Hospital Regional</span>
                                    <span style="font-size: 13px; font-weight: 600;">$22.4M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 78%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Parque Industrial</span>
                                    <span style="font-size: 13px; font-weight: 600;">$18.2M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 64%; height: 8px; background-color: #ffc107; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Puente Sur</span>
                                    <span style="font-size: 13px; font-weight: 600;">$12.6M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 44%; height: 8px; background-color: #fd7e14; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                    <span style="font-size: 13px;">Urb. Los Álamos</span>
                                    <span style="font-size: 13px; font-weight: 600;">$4.8M</span>
                                </div>
                                <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                    <div style="width: 17%; height: 8px; background-color: #17a2b8; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Últimos Pagos -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 15px;">
                        <h4 style="color: #083CAE; margin: 0 0 15px 0; font-size: 15px;">
                            <i class="fas fa-clock"></i> Últimos Pagos
                        </h4>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-095', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FAC-2026-095</div>
                                    <div style="font-size: 11px; color: #6c757d;">Hace 2 horas • Gobierno Regional</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$2,850,000</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-092', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FAC-2026-092</div>
                                    <div style="font-size: 11px; color: #6c757d;">Ayer • Constructora ABC</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$950,000</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-089', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FAC-2026-089</div>
                                    <div style="font-size: 11px; color: #6c757d;">Hace 2 días • Inmobiliaria del Norte</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$1,800,000</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-086', event)">
                                <div style="background-color: #17a2b8; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FAC-2026-086</div>
                                    <div style="font-size: 11px; color: #6c757d;">Hace 3 días • Empresas López</div>
                                </div>
                                <div style="font-weight: 600; color: #17a2b8;">$1,200,000</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-082', event)">
                                <div style="background-color: #28a745; width: 8px; height: 8px; border-radius: 50%;"></div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 13px;">FAC-2026-082</div>
                                    <div style="font-size: 11px; color: #6c757d;">Hace 5 días • Desarrollos del Sur</div>
                                </div>
                                <div style="font-weight: 600; color: #28a745;">$2,200,000</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE HISTORIAL DE PAGOS -->
                <div class="table-responsive" style="border: 1px solid #dee2e6; border-radius: 12px; max-height: 400px; overflow-y: auto; margin-top: 20px;">
                    <table class="table" style="width: 100%; font-size: 13px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 12px 8px; text-align: left;">Fecha</th>
                                <th style="padding: 12px 8px; text-align: left;">Factura</th>
                                <th style="padding: 12px 8px; text-align: left;">Cliente</th>
                                <th style="padding: 12px 8px; text-align: left;">Proyecto</th>
                                <th style="padding: 12px 8px; text-align: right;">Monto</th>
                                <th style="padding: 12px 8px; text-align: left;">Método</th>
                                <th style="padding: 12px 8px; text-align: left;">Referencia</th>
                                <th style="padding: 12px 8px; text-align: center;">Estatus</th>
                                <th style="padding: 12px 8px; text-align: center;">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-095')">
                                <td style="padding: 10px 8px;">2026-03-31</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-095</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,850,000</td>
                                <td style="padding: 10px 8px;">Transferencia</td>
                                <td style="padding: 10px 8px;">REF-12345</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-095', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-092')">
                                <td style="padding: 10px 8px;">2026-03-30</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-092</td>
                                <td style="padding: 10px 8px;">Constructora ABC</td>
                                <td style="padding: 10px 8px;">Parque Industrial</td>
                                <td style="padding: 10px 8px; text-align: right;">$950,000</td>
                                <td style="padding: 10px 8px;">Cheque</td>
                                <td style="padding: 10px 8px;">CHE-5678</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-092', event)"></i>
                                </td>
                            </tr>
                            <tr style="cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-089')">
                                <td style="padding: 10px 8px;">2026-03-29</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-089</td>
                                <td style="padding: 10px 8px;">Inmobiliaria del Norte</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,800,000</td>
                                <td style="padding: 10px 8px;">Transferencia</td>
                                <td style="padding: 10px 8px;">REF-23456</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-089', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-086')">
                                <td style="padding: 10px 8px;">2026-03-28</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-086</td>
                                <td style="padding: 10px 8px;">Empresas López</td>
                                <td style="padding: 10px 8px;">Torre Norte</td>
                                <td style="padding: 10px 8px; text-align: right;">$1,200,000</td>
                                <td style="padding: 10px 8px;">Transferencia</td>
                                <td style="padding: 10px 8px;">REF-34567</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Pendiente</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-086', event)"></i>
                                </td>
                            </tr>
                            <tr style="cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-082')">
                                <td style="padding: 10px 8px;">2026-03-26</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-082</td>
                                <td style="padding: 10px 8px;">Desarrollos del Sur</td>
                                <td style="padding: 10px 8px;">Puente Sur</td>
                                <td style="padding: 10px 8px; text-align: right;">$2,200,000</td>
                                <td style="padding: 10px 8px;">Cheque</td>
                                <td style="padding: 10px 8px;">CHE-6789</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-082', event)"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-078')">
                                <td style="padding: 10px 8px;">2026-03-24</td>
                                <td style="padding: 10px 8px; font-weight: 600;">FAC-2026-078</td>
                                <td style="padding: 10px 8px;">Gobierno Regional</td>
                                <td style="padding: 10px 8px;">Hospital Regional</td>
                                <td style="padding: 10px 8px; text-align: right;">$3,500,000</td>
                                <td style="padding: 10px 8px;">Transferencia</td>
                                <td style="padding: 10px 8px;">REF-45678</td>
                                <td style="padding: 10px 8px; text-align: center;"><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></td>
                                <td style="padding: 10px 8px; text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer;" onclick="verDetallePagoIndividual('Pago FAC-2026-078', event)"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totales y Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div style="display: flex; gap: 30px;">
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Total Período:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">$12.8M</span>
                        </div>
                        <div>
                            <span style="color: #6c757d; font-size: 13px;">Pagos Registrados:</span>
                            <span style="font-weight: 600; font-size: 16px; margin-left: 10px;">8</span>
                        </div>
                    </div>
                    <div style="color: #6c757d; font-size: 13px;">
                        Mostrando 1-6 de 156 pagos
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

<!-- Modal para Ver Detalle de Pago -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i> <span id="modalTitulo">Detalle del Pago</span>
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
        console.log('Historial de Pagos cargado - Solo vista');
        
        // Filtros (solo para visualización)
        const periodoSelect = document.getElementById('selectorPeriodo');
        if (periodoSelect) {
            periodoSelect.addEventListener('change', function() {
                console.log('Filtrando por período:', this.value);
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
        
        const metodoSelect = document.getElementById('selectorMetodoPago');
        if (metodoSelect) {
            metodoSelect.addEventListener('change', function() {
                console.log('Filtrando por método:', this.value);
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
        
        // Cerrar modal
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
    
    // Función para ver detalle de pago (KPIs)
    function verDetallePago(titulo, valor, descripcion) {
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
                <h4 style="color: #083CAE; margin-bottom: 15px;">Desglose por Período</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Marzo 2026</span>
                        <span style="font-weight: 600;">$12.8M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Febrero 2026</span>
                        <span style="font-weight: 600;">$10.5M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Enero 2026</span>
                        <span style="font-weight: 600;">$8.2M</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Diciembre 2025</span>
                        <span style="font-weight: 600;">$7.5M</span>
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
                <div style="height: 250px; display: flex; align-items: flex-end; gap: 20px; justify-content: center; margin: 20px 0;">
                    <div style="text-align: center;">
                        <div style="height: 160px; width: 50px; background: #083CAE; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Ene</div>
                        <div>$8.2M</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="height: 200px; width: 50px; background: #083CAE; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Feb</div>
                        <div>$10.5M</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="height: 240px; width: 50px; background: #28a745; border-radius: 4px 4px 0 0;"></div>
                        <div style="margin-top: 5px;">Mar</div>
                        <div>$12.8M</div>
                    </div>
                </div>
                <p style="text-align: center; color: #6c757d;">Datos actualizados al 31/03/2026</p>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    // Función para ver detalle de pago individual
    function verDetallePagoIndividual(pago, event) {
        if (event) {
            event.stopPropagation();
        }
        
        const modal = document.getElementById('modalVerDetalle');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalContenido = document.getElementById('modalContenido');
        
        modalTitulo.textContent = pago;
        
        modalContenido.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Factura</div>
                    <div style="font-size: 18px; font-weight: 600;">FAC-2026-095</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Monto</div>
                    <div style="font-size: 20px; font-weight: 700; color: #28a745;">$2,850,000</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Cliente</div>
                    <div style="font-size: 14px; font-weight: 600;">Gobierno Regional</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                    <div style="font-size: 14px; font-weight: 600;">Hospital Regional</div>
                </div>
            </div>
            
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Fecha de Pago</div>
                        <div style="font-size: 14px;">2026-03-31</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Método de Pago</div>
                        <div style="font-size: 14px;">Transferencia Bancaria</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Referencia</div>
                        <div style="font-size: 14px;">REF-12345</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Estatus</div>
                        <div><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">Confirmado</span></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Banco Origen</div>
                <div style="font-size: 14px;">Banco Nacional de México</div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Cuenta Destino</div>
                <div style="font-size: 14px;">**** **** **** 1234 - Constructora ABC</div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <div style="color: #6c757d; font-size: 12px;">Concepto</div>
                <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                    Pago factura FAC-2026-095 correspondiente a estimación de avance #8 del Hospital Regional
                </div>
            </div>
            
            <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Comprobante</div>
                <div style="display: flex; gap: 10px;">
                    <span style="background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-size: 12px;">
                        <i class="fas fa-file-pdf" style="color: #dc3545;"></i> comprobante-pago-095.pdf
                    </span>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
</script>
@endsection