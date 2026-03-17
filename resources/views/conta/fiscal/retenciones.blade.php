@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Retenciones - ISR e IVA -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Retenciones - ISR e IVA
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtro mensual y botón de descarga - TODO A LA DERECHA -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 30px; gap: 15px; flex-wrap: wrap;">
                    <!-- Filtro de mes y año -->
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div style="font-weight: 600; color: #083CAE; font-size: 15px;">Período:</div>
                        <div style="display: flex; border: 1px solid #083CAE; border-radius: 8px; overflow: hidden;">
                            <select id="mes" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 120px; border-right: 1px solid #dee2e6;">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <select id="anio" style="padding: 10px 15px; border: none; font-size: 14px; background-color: white; width: 100px;">
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026" selected>2026</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón de descarga verde -->
                    <button id="btnDescargar" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-download"></i> Descargar Reporte
                    </button>
                </div>

                <!-- Tarjetas de resumen de retenciones -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <!-- Total ISR Retenido -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-percent" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total ISR Retenido</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;">$45,230.50</div>
                            </div>
                        </div>
                    </div>

                    <!-- Total IVA Retenido -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #e6f2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chart-line" style="color: #083CAE; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total IVA Retenido</div>
                                <div style="font-size: 20px; font-weight: bold; color: #083CAE;">$12,875.32</div>
                            </div>
                        </div>
                    </div>

                    <!-- Proveedores con Retención -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #fff3cd; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users" style="color: #856404; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Proveedores</div>
                                <div style="font-size: 20px; font-weight: bold; color: #856404;">24 proveedores</div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Operaciones -->
                    <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; background-color: #d4edda; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-invoice" style="color: #155724; font-size: 24px;"></i>
                            </div>
                            <div>
                                <div style="font-size: 13px; color: #6c757d; margin-bottom: 5px;">Total Operaciones</div>
                                <div style="font-size: 20px; font-weight: bold; color: #155724;">87 facturas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestañas de retenciones -->
                <div style="border-bottom: 2px solid #dee2e6; margin-bottom: 20px; display: flex; gap: 5px;">
                    <button class="tab-button active" data-tab="isr" style="background-color: #083CAE; color: white; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-percent" style="margin-right: 8px;"></i> Retenciones ISR
                    </button>
                    <button class="tab-button" data-tab="iva" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-chart-line" style="margin-right: 8px;"></i> Retenciones IVA
                    </button>
                    <button class="tab-button" data-tab="resumen" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; font-size: 14px; font-weight: 600; border-radius: 8px 8px 0 0; cursor: pointer;">
                        <i class="fas fa-clipboard-list" style="margin-right: 8px;"></i> Resumen
                    </button>
                </div>

                <!-- CONTENIDO: Retenciones ISR -->
                <div id="tab-isr" class="tab-content" style="display: block;">
                    <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <!-- Encabezados de tabla -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                            <div>Razón Social / RFC</div>
                            <div>Proveedor</div>
                            <div style="text-align: right;">Subtotal</div>
                            <div style="text-align: right;">Tasa ISR</div>
                            <div style="text-align: right;">ISR Retenido</div>
                            <div style="text-align: center;">Acciones</div>
                        </div>

                        <!-- Cuerpo de la tabla ISR -->
                        <div style="padding: 5px 0;">
                            <!-- Fila 1 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                                <div>
                                    <div style="font-weight: 500;">Constructora del Norte S.A. de C.V.</div>
                                    <div style="font-size: 11px; color: #6c757d;">CNO851203HDF</div>
                                </div>
                                <div>PROV-001</div>
                                <div style="text-align: right; font-family: monospace;">$45,230.50</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$4,523.05</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 2 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                                <div>
                                    <div style="font-weight: 500;">Servicios Integrales de Logística</div>
                                    <div style="font-size: 11px; color: #6c757d;">SIL970512ABC</div>
                                </div>
                                <div>PROV-002</div>
                                <div style="text-align: right; font-family: monospace;">$18,500.00</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$1,850.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 3 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                                <div>
                                    <div style="font-weight: 500;">Consultoría y Asesoría Empresarial</div>
                                    <div style="font-size: 11px; color: #6c757d;">CAE880104XYZ</div>
                                </div>
                                <div>PROV-004</div>
                                <div style="text-align: right; font-family: monospace;">$12,000.00</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$1,200.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 4 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                                <div>
                                    <div style="font-weight: 500;">Arrendadora de Maquinaria Pesada</div>
                                    <div style="font-size: 11px; color: #6c757d;">AMP901234JKL</div>
                                </div>
                                <div>PROV-008</div>
                                <div style="text-align: right; font-family: monospace;">$42,000.00</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$4,200.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 5 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                                <div>
                                    <div style="font-weight: 500;">Servicios de Limpieza Industrial</div>
                                    <div style="font-size: 11px; color: #6c757d;">SLI750908MNO</div>
                                </div>
                                <div>PROV-009</div>
                                <div style="text-align: right; font-family: monospace;">$5,600.00</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$560.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO: Retenciones IVA -->
                <div id="tab-iva" class="tab-content" style="display: none;">
                    <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <!-- Encabezados de tabla -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                            <div>Razón Social / RFC</div>
                            <div>Proveedor</div>
                            <div style="text-align: right;">Subtotal</div>
                            <div style="text-align: right;">Tasa IVA</div>
                            <div style="text-align: right;">IVA Retenido</div>
                            <div style="text-align: center;">Acciones</div>
                        </div>

                        <!-- Cuerpo de la tabla IVA -->
                        <div style="padding: 5px 0;">
                            <!-- Fila 1 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                                <div>
                                    <div style="font-weight: 500;">Proveedora de Materiales y Equipos</div>
                                    <div style="font-size: 11px; color: #6c757d;">PME760512QWE</div>
                                </div>
                                <div>PROV-003</div>
                                <div style="text-align: right; font-family: monospace;">$32,150.75</div>
                                <div style="text-align: right;">8%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$2,572.06</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 2 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                                <div>
                                    <div style="font-weight: 500;">Servicios de Transporte y Carga</div>
                                    <div style="font-size: 11px; color: #6c757d;">STC830921RTY</div>
                                </div>
                                <div>PROV-006</div>
                                <div style="text-align: right; font-family: monospace;">$23,800.00</div>
                                <div style="text-align: right;">16%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$3,808.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 3 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #ffffff;">
                                <div>
                                    <div style="font-weight: 500;">Proveedora de Alimentos y Bebidas</div>
                                    <div style="font-size: 11px; color: #6c757d;">PAB950401UIO</div>
                                </div>
                                <div>PROV-007</div>
                                <div style="text-align: right; font-family: monospace;">$9,850.25</div>
                                <div style="text-align: right;">8%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$788.02</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>

                            <!-- Fila 4 -->
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; align-items: center; background-color: #f8f9fa;">
                                <div>
                                    <div style="font-weight: 500;">Distribuidora de Material Eléctrico</div>
                                    <div style="font-size: 11px; color: #6c757d;">DME880214ASD</div>
                                </div>
                                <div>PROV-010</div>
                                <div style="text-align: right; font-family: monospace;">$28,450.00</div>
                                <div style="text-align: right;">16%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600; color: #083CAE;">$4,552.00</div>
                                <div style="text-align: center;">
                                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; margin: 0 5px;" title="Ver detalle"></i>
                                    <i class="fas fa-file-pdf" style="color: #dc3545; cursor: pointer; margin: 0 5px;" title="Descargar PDF"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO: Resumen -->
                <div id="tab-resumen" class="tab-content" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <!-- Gráfico ISR -->
                        <div style="border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-percent" style="margin-right: 8px;"></i> Distribución ISR por Proveedor
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Constructora del Norte</span>
                                        <span style="font-size: 13px; font-weight: 600;">$4,523.05</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 35%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Arrendadora de Maquinaria</span>
                                        <span style="font-size: 13px; font-weight: 600;">$4,200.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 32%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Servicios Integrales</span>
                                        <span style="font-size: 13px; font-weight: 600;">$1,850.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 14%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Consultoría Empresarial</span>
                                        <span style="font-size: 13px; font-weight: 600;">$1,200.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 9%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Limpieza Industrial</span>
                                        <span style="font-size: 13px; font-weight: 600;">$560.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 4%; height: 8px; background-color: #083CAE; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico IVA -->
                        <div style="border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; background-color: white;">
                            <h4 style="color: #083CAE; font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                                <i class="fas fa-chart-line" style="margin-right: 8px;"></i> Distribución IVA por Proveedor
                            </h4>
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Material Eléctrico</span>
                                        <span style="font-size: 13px; font-weight: 600;">$4,552.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 40%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Transporte y Carga</span>
                                        <span style="font-size: 13px; font-weight: 600;">$3,808.00</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 33%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Materiales y Equipos</span>
                                        <span style="font-size: 13px; font-weight: 600;">$2,572.06</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 22%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="font-size: 13px;">Alimentos y Bebidas</span>
                                        <span style="font-size: 13px; font-weight: 600;">$788.02</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background-color: #e9ecef; border-radius: 4px;">
                                        <div style="width: 7%; height: 8px; background-color: #28a745; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de resumen -->
                    <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; background-color: #6B8ACE; padding: 15px 20px; font-weight: 700; color: white; border-bottom: 2px solid #083CAE;">
                            <div>Concepto</div>
                            <div style="text-align: right;">Base</div>
                            <div style="text-align: right;">Tasa</div>
                            <div style="text-align: right;">Retención</div>
                            <div style="text-align: right;">% del Total</div>
                        </div>
                        <div style="padding: 5px 0;">
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff;">
                                <div style="font-weight: 500;">ISR - Servicios Profesionales</div>
                                <div style="text-align: right; font-family: monospace;">$123,330.50</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600;">$12,333.05</div>
                                <div style="text-align: right;">27.3%</div>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                <div style="font-weight: 500;">ISR - Arrendamiento</div>
                                <div style="text-align: right; font-family: monospace;">$42,000.00</div>
                                <div style="text-align: right;">10%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600;">$4,200.00</div>
                                <div style="text-align: right;">9.3%</div>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff;">
                                <div style="font-weight: 500;">IVA - Tasa 16%</div>
                                <div style="text-align: right; font-family: monospace;">$52,250.00</div>
                                <div style="text-align: right;">16%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600;">$8,360.00</div>
                                <div style="text-align: right;">18.5%</div>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa;">
                                <div style="font-weight: 500;">IVA - Tasa 8%</div>
                                <div style="text-align: right; font-family: monospace;">$42,001.00</div>
                                <div style="text-align: right;">8%</div>
                                <div style="text-align: right; font-family: monospace; font-weight: 600;">$3,360.08</div>
                                <div style="text-align: right;">7.4%</div>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; padding: 12px 20px; background-color: #e9ecef; font-weight: 700;">
                                <div style="color: #083CAE;">TOTALES</div>
                                <div style="text-align: right; font-family: monospace;">$217,581.50</div>
                                <div style="text-align: right;"></div>
                                <div style="text-align: right; font-family: monospace;">$28,253.13</div>
                                <div style="text-align: right;">100%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->

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

    /* Estilo para los encabezados de tabla */
    [style*="background-color: #6B8ACE"] {
        transition: background-color 0.2s ease;
        letter-spacing: 0.3px;
    }

    /* Estilo para filas alternadas */
    [style*="background-color: #f8f9fa"] {
        transition: background-color 0.2s ease;
    }

    [style*="background-color: #ffffff"]:hover,
    [style*="background-color: #f8f9fa"]:hover {
        background-color: #e3f2fd !important;
        cursor: default;
    }

    /* Estilo para el botón de descarga */
    #btnDescargar {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(44, 191, 31, 0.2);
    }

    #btnDescargar:hover {
        background-color: #249e1a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 191, 31, 0.3);
    }

    #btnDescargar:active {
        transform: translateY(0);
    }

    /* Estilo para selects */
    select {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    select:hover {
        border-color: #2CBF1F !important;
    }

    select:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 2px rgba(8, 60, 174, 0.2);
    }

    /* Estilo para números en monospace */
    [style*="font-family: monospace"] {
        font-size: 13px;
    }

    /* Estilo para tarjetas */
    [style*="grid-template-columns: repeat(4, 1fr)"] > div {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    [style*="grid-template-columns: repeat(4, 1fr)"] > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
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
    .fa-eye:hover, .fa-file-pdf:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }

    .fa-eye:hover {
        color: #0056b3 !important;
    }

    .fa-file-pdf:hover {
        color: #b02a37 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        [style*="grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
        
        [style*="grid-template-columns: repeat(4, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="display: flex; justify-content: flex-end"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        .semaforo .card-header h2 {
            font-size: 18px !important;
        }
        
        [style*="padding: 12px 20px"] {
            padding: 10px !important;
        }
        
        /* Ajustar el filtro en móvil */
        [style*="display: flex; gap: 15px; align-items: center"] {
            width: 100%;
            justify-content: space-between;
        }
        
        [style*="display: flex; border: 1px solid #083CAE; border-radius: 8px; overflow: hidden"] {
            flex: 1;
        }
        
        #btnDescargar {
            width: 100%;
            justify-content: center;
        }
        
        .tab-button {
            flex: 1;
            text-align: center;
            padding: 10px !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnDescargar = document.getElementById('btnDescargar');
        const mes = document.getElementById('mes');
        const anio = document.getElementById('anio');
        
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

        // Mostrar ISR por defecto
        showTab('isr');

        // Evento para el botón de descarga
        btnDescargar.addEventListener('click', function() {
            const mesSel = mes.options[mes.selectedIndex].text;
            const anioSel = anio.value;
            
            // Simular descarga
            alert(`Descargando reporte de retenciones para ${mesSel} ${anioSel}...`);
            
            // Crear contenido de ejemplo para el archivo
            const contenido = `REPORTE DE RETENCIONES - ISR e IVA\n`;
            const contenido2 = `Período: ${mesSel} ${anioSel}\n`;
            const contenido3 = `Generado: ${new Date().toLocaleString()}\n`;
            const contenido4 = `Total ISR Retenido: $45,230.50\n`;
            const contenido5 = `Total IVA Retenido: $12,875.32\n`;
            
            console.log('Reporte generado:', contenido + contenido2 + contenido3 + contenido4 + contenido5);
            
            // Feedback visual
            btnDescargar.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btnDescargar.style.transform = 'scale(1)';
            }, 200);
        });

        // Evento para cambio de período (simulado)
        [mes, anio].forEach(select => {
            select.addEventListener('change', function() {
                const mesSel = mes.options[mes.selectedIndex].text;
                const anioSel = anio.value;
                console.log(`Cambiando a período: ${mesSel} ${anioSel}`);
            });
        });
    });
</script>
@endsection