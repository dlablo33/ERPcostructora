@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Configuración de Contabilidad -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Configuración de Contabilidad
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Contenedor principal con dos columnas -->
                <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px; min-height: 600px;">
                    <!-- Columna Izquierda - Pestañas verticales -->
                    <div style="background-color: #f8f9fa; border-radius: 12px; padding: 15px; border: 1px solid #dee2e6;">
                        <!-- Pestaña: Datos Generales -->
                        <div id="tab-datos-generales" class="tab-vertical" style="padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #495057; cursor: pointer; transition: all 0.3s ease;" onclick="showTab('datos-generales')">
                            <i class="fas fa-database" style="margin-right: 10px; color: #6c757d;"></i> Datos Generales
                        </div>
                        
                        <!-- Pestaña: Cuentas por defecto (activa por defecto) -->
                        <div id="tab-cuentas-defecto" class="tab-vertical active" style="background-color: #083CAE; color: white; padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-weight: 600; font-size: 14px; cursor: pointer;" onclick="showTab('cuentas-defecto')">
                            <i class="fas fa-book" style="margin-right: 10px;"></i> Cuentas por defecto
                        </div>
                        
                        <!-- Pestaña: Estados de resultados -->
                        <div id="tab-estados-resultados" class="tab-vertical" style="padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #495057; cursor: pointer; transition: all 0.3s ease;" onclick="showTab('estados-resultados')">
                            <i class="fas fa-chart-line" style="margin-right: 10px; color: #6c757d;"></i> Estados de resultados
                        </div>
                        
                        <!-- Pestaña: Estados de resultados de contabilidad -->
                        <div id="tab-estados-contabilidad" class="tab-vertical" style="padding: 12px 15px; border-radius: 8px; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #495057; cursor: pointer; transition: all 0.3s ease;" onclick="showTab('estados-contabilidad')">
                            <i class="fas fa-calculator" style="margin-right: 10px; color: #6c757d;"></i> Estados de resultados de contabilidad
                        </div>
                    </div>

                    <!-- Columna Derecha - Contenido de las pestañas -->
                    
                    <!-- ============================================ -->
                    <!-- CONTENIDO: DATOS GENERALES (TODOS LOS MÓDULOS) -->
                    <!-- ============================================ -->
                    <div id="content-datos-generales" class="tab-content" style="display: none;">
                        <div style="background-color: white; border-radius: 12px; padding: 25px; border: 1px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <!-- Título de la sección -->
                            <div style="border-bottom: 2px solid #083CAE; padding-bottom: 15px; margin-bottom: 25px;">
                                <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">
                                    <i class="fas fa-database" style="margin-right: 10px;"></i> Datos Generales
                                </h3>
                            </div>

                            <!-- MÓDULO 1: FACTURAS -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('facturas')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-facturas" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-file-invoice" style="margin-right: 8px; color: #083CAE;"></i> Facturas
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-facturas" style="display: none; padding: 25px; background-color: white;">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Facturas</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Cliente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Cliente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="101-05-01">101-05-01 - Clientes nacionales</option>
                                                <option value="101-05-02">101-05-02 - Clientes extranjeros</option>
                                                <option value="101-05-03">101-05-03 - Clientes gobierno</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Producto / Servicio (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Producto / Servicio</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="401-01-01">401-01-01 - Ventas y/o servicios gravados a la tasa general</option>
                                                <option value="401-01-02">401-01-02 - Ventas exentas</option>
                                                <option value="401-01-03">401-01-03 - Ventas tasa 0%</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Descuento (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Descuento</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="402-01-01">402-01-01 - BONIFICACIONES</option>
                                                <option value="402-01-02">402-01-02 - Descuentos comerciales</option>
                                                <option value="402-01-03">402-01-03 - Descuentos por volumen</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion IVA (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Retencion ISR (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Retencion ISR</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-04">201-16-04 - Impuestos retenidos de ISR por servicios profesionales</option>
                                                <option value="201-16-05">201-16-05 - ISR retenido por pagar</option>
                                                <option value="201-16-06">201-16-06 - ISR retenido asimilados</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 2: DEPOSITOS -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('depositos')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-depositos" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: #083CAE;"></i> Depositos
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-depositos" style="display: none; padding: 25px; background-color: white;">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Depositos</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Cliente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Cliente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="101-05-01">101-05-01 - Clientes nacionales</option>
                                                <option value="101-05-02">101-05-02 - Clientes extranjeros</option>
                                                <option value="101-05-03">101-05-03 - Clientes gobierno</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA Trasladado (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Trasladado</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado</option>
                                                <option value="201-09-02">201-09-02 - IVA por pagar</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Concepto General (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Concepto General</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="500-001">500-001 - Ingresos generales</option>
                                                <option value="500-002">500-002 - Otros ingresos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Banco (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Banco</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="101-001">101-001 - Banco Nacional</option>
                                                <option value="101-002">101-002 - Banco Internacional</option>
                                                <option value="101-003">101-003 - Banco Regional</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion IVA 1 (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Retencion IVA 2 (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA (adicional)</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar (adicional)</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 3: CHEQUES Y TRANSFERENCIAS -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('cheques')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-cheques" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-money-check-alt" style="margin-right: 8px; color: #083CAE;"></i> Cheques y Transferencias
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-cheques" style="display: none; padding: 25px; background-color: white;">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Cheques y Transferencias</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Proveedor General (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Proveedor General</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-001">201-001 - Proveedores nacionales</option>
                                                <option value="201-002">201-002 - Proveedores extranjeros</option>
                                                <option value="201-003">201-003 - Proveedores varios</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Gasto Concepto (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Gasto Concepto</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="601-001">601-001 - Gastos generales</option>
                                                <option value="601-002">601-002 - Gastos operativos</option>
                                                <option value="601-003">601-003 - Gastos administrativos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA Acreditable (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Acreditable</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-03">201-09-03 - IVA acreditable</option>
                                                <option value="201-09-04">201-09-04 - IVA por acreditar</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Retencion IVA 1 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion ISR Servicios 1 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion ISR Servicios</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-04">201-16-04 - Impuestos retenidos de ISR por servicios profesionales</option>
                                                <option value="201-16-05">201-16-05 - ISR retenido por pagar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Banco (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Banco</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="101-001">101-001 - Banco Nacional</option>
                                                <option value="101-002">101-002 - Banco Internacional</option>
                                                <option value="101-003">101-003 - Banco Regional</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion IVA 2 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA (adicional)</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar (adicional)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion ISR Servicios 2 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion ISR Servicios</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-04">201-16-04 - Impuestos retenidos de ISR por servicios profesionales (adicional)</option>
                                                <option value="201-16-05">201-16-05 - ISR retenido por pagar (adicional)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Liquidacion (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Liquidacion</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="602-001">602-001 - Liquidaciones</option>
                                                <option value="602-002">602-002 - Finiquitos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Prepagos (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Prepagos</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="103-001">103-001 - Prepagos</option>
                                                <option value="103-002">103-002 - Anticipos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Sueldos (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Sueldos</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="603-001">603-001 - Sueldos y salarios</option>
                                                <option value="603-002">603-002 - Sueldos administrativos</option>
                                                <option value="603-003">603-003 - Sueldos operativos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Reposición de Gastos (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Reposición de Gastos</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="604-001">604-001 - Reposición de gastos</option>
                                                <option value="604-002">604-002 - Gastos por comprobar</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 4: CUENTAS POR PAGAR -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('cuentas-pagar')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-cuentas-pagar" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-credit-card" style="margin-right: 8px; color: #083CAE;"></i> Cuentas por Pagar
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-cuentas-pagar" style="display: none; padding: 25px; background-color: white;">
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Cuentas por Pagar</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Proveedor Generico (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Proveedor Generico</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-001">201-001 - Proveedores nacionales</option>
                                                <option value="201-002">201-002 - Proveedores extranjeros</option>
                                                <option value="201-003">201-003 - Proveedores varios</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Gasto (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Gasto</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="601-001">601-001 - Gastos generales</option>
                                                <option value="601-002">601-002 - Gastos operativos</option>
                                                <option value="601-003">601-003 - Gastos administrativos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Descuento (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Descuento</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="402-01-01">402-01-01 - BONIFICACIONES</option>
                                                <option value="402-01-02">402-01-02 - Descuentos comerciales</option>
                                                <option value="402-01-03">402-01-03 - Descuentos por volumen</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente 1 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion IVA (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Impuestos retenidos de IVA</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido por pagar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion ISR (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion ISR</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-04">201-16-04 - Impuestos retenidos de ISR por servicios profesionales</option>
                                                <option value="201-16-05">201-16-05 - ISR retenido por pagar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Almacen Pendiente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Almacen Pendiente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-001">120-001 - Almacén pendiente</option>
                                                <option value="120-002">120-002 - Inventario en tránsito</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Proveedor (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Proveedor</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-004">201-004 - Proveedores varios</option>
                                                <option value="201-005">201-005 - Proveedores servicios</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente 2 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado (adicional)</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado (adicional)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 5: ENTRADAS ALMACEN -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('entradas-almacen')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-entradas-almacen" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-warehouse" style="margin-right: 8px; color: #083CAE;"></i> Entradas Almacen
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-entradas-almacen" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Entradas Almacen</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Almacen (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Almacen</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-001">120-001 - Almacén general</option>
                                                <option value="120-002">120-002 - Almacén refacciones</option>
                                                <option value="120-003">120-003 - Almacén consumibles</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Proveedor Pendiente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Proveedor Pendiente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-006">201-006 - Proveedores pendientes</option>
                                                <option value="201-007">201-007 - Cuentas por pagar pendientes</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Almacen (CPP) - Cargo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Almacen (CPP)</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-004">120-004 - Almacén CPP</option>
                                                <option value="120-005">120-005 - Inventario en proceso</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Proveedor (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Proveedor</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-001">201-001 - Proveedores nacionales</option>
                                                <option value="201-002">201-002 - Proveedores extranjeros</option>
                                                <option value="201-003">201-003 - Proveedores varios</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA Pendiente 1 (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado no cobrado</option>
                                                <option value="201-09-02">201-09-02 - IVA acreditable no pagado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pendiente 2 (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-03">201-09-03 - IVA acreditable</option>
                                                <option value="201-09-04">201-09-04 - IVA por pagar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 6: SALIDAS ALMACEN -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('salidas-almacen')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-salidas-almacen" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-sign-out-alt" style="margin-right: 8px; color: #083CAE;"></i> Salidas Almacen
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-salidas-almacen" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Salidas Almacen</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Costo Mercancia (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Costo Mercancia</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="601-001">601-001 - Costo de ventas</option>
                                                <option value="601-002">601-002 - Costo de mercancía vendida</option>
                                                <option value="601-003">601-003 - Costo de producción</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Almacen (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Almacen</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-001">120-001 - Almacén general</option>
                                                <option value="120-002">120-002 - Almacén refacciones</option>
                                                <option value="120-003">120-003 - Almacén consumibles</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 7: AJUSTE ALMACEN -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('ajuste-almacen')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-ajuste-almacen" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-balance-scale" style="margin-right: 8px; color: #083CAE;"></i> Ajuste Almacen
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-ajuste-almacen" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Ajuste Almacen</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Entrada (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Entrada</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-001">120-001 - Almacén general</option>
                                                <option value="120-002">120-002 - Almacén refacciones</option>
                                                <option value="120-003">120-003 - Almacén consumibles</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Salida (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Salida</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="120-001">120-001 - Almacén general</option>
                                                <option value="120-002">120-002 - Almacén refacciones</option>
                                                <option value="120-003">120-003 - Almacén consumibles</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 8: ISR -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('isr')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-isr" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-calculator" style="margin-right: 8px; color: #083CAE;"></i> ISR
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-isr" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto ISR</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Pago ISR Provisional (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Pago ISR Provisional</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="220-001">220-001 - ISR por pagar</option>
                                                <option value="220-002">220-002 - ISR provisional</option>
                                                <option value="220-003">220-003 - Pago provisional ISR</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- ISR Provisional Por Pagar (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">ISR Provisional Por Pagar</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="220-001">220-001 - ISR por pagar</option>
                                                <option value="220-002">220-002 - ISR provisional</option>
                                                <option value="220-003">220-003 - Pago provisional ISR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 9: IVA -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('iva')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-iva" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-percent" style="margin-right: 8px; color: #083CAE;"></i> IVA
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-iva" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto IVA</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- IVA Cobrado (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Cobrado</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA trasladado</option>
                                                <option value="201-09-02">201-09-02 - IVA cobrado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Pagado (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pagado</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-03">201-09-03 - IVA acreditable</option>
                                                <option value="201-09-04">201-09-04 - IVA pagado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Favor (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Favor</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-05">201-09-05 - IVA a favor</option>
                                                <option value="201-09-06">201-09-06 - Saldo a favor IVA</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA Por Pagar (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Por Pagar</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-07">201-09-07 - IVA por pagar</option>
                                                <option value="201-09-08">201-09-08 - IVA causado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA Retenido (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">IVA Retenido</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - IVA retenido</option>
                                                <option value="201-16-11">201-16-11 - Retenciones IVA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 10: ISN -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('isn')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-isn" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-file-invoice-dollar" style="margin-right: 8px; color: #083CAE;"></i> ISN
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-isn" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto ISN</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- ISN Por Pagar (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">ISN Por Pagar</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="220-004">220-004 - ISN por pagar</option>
                                                <option value="220-005">220-005 - Impuesto sobre nóminas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Gastos ISN (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Gastos ISN</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="603-004">603-004 - Gastos ISN</option>
                                                <option value="603-005">603-005 - Impuesto sobre nóminas</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 11: NOTAS DE CREDITO -->
                            <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('notas-credito')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-notas-credito" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-file-invoice" style="margin-right: 8px; color: #083CAE;"></i> Notas de Credito
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-notas-credito" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Notas de Credito</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Cliente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Cliente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="101-05-01">101-05-01 - Clientes nacionales</option>
                                                <option value="101-05-02">101-05-02 - Clientes extranjeros</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Producto / Servicio (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Producto / Servicio</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="401-01-01">401-01-01 - Ventas</option>
                                                <option value="401-01-02">401-01-02 - Devoluciones</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Descuento (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Descuento</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="402-01-01">402-01-01 - Bonificaciones</option>
                                                <option value="402-01-02">402-01-02 - Descuentos</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Retencion IVA (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-10">201-16-10 - Retención IVA</option>
                                                <option value="201-16-11">201-16-11 - IVA retenido</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Retencion ISR (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Retencion ISR</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-16-04">201-16-04 - Retención ISR</option>
                                                <option value="201-16-05">201-16-05 - ISR retenido</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IVA Pendiente (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA Pendiente</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-01">201-09-01 - IVA pendiente</option>
                                                <option value="201-09-02">201-09-02 - IVA no cobrado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-03">201-09-03 - IVA</option>
                                                <option value="201-09-04">201-09-04 - IVA trasladado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MÓDULO 12: LIQUIDACIONES -->
                            <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <div onclick="toggleModule('liquidaciones')" style="background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border-bottom: 1px solid #dee2e6;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <i class="fas fa-chevron-right" id="icon-liquidaciones" style="color: #083CAE; font-size: 14px;"></i>
                                        <span style="font-weight: 600; color: #333; font-size: 16px;">
                                            <i class="fas fa-hand-holding-usd" style="margin-right: 8px; color: #083CAE;"></i> Liquidaciones
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="content-liquidaciones" style="display: none; padding: 25px; background-color: white;">
                                    <!-- Encabezados de columnas -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px; padding: 12px 15px; background-color: #f1f5f9; border-radius: 8px; font-weight: 700; color: #083CAE;">
                                        <div>Concepto Liquidaciones</div>
                                        <div style="text-align: center;">Cargo</div>
                                        <div style="text-align: center;">Abono</div>
                                    </div>

                                    <!-- Sueldo (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Sueldo</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="603-001">603-001 - Sueldos</option>
                                                <option value="603-002">603-002 - Salarios</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Propio (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Propio</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="605-001">605-001 - Diesel propio</option>
                                                <option value="605-002">605-002 - Combustible propio</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Efectivo (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Efectivo</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="605-003">605-003 - Diesel efectivo</option>
                                                <option value="605-004">605-004 - Combustible efectivo</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Credito (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Credito</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="605-005">605-005 - Diesel crédito</option>
                                                <option value="605-006">605-006 - Combustible crédito</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Prepago (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Prepago</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="103-003">103-003 - Prepago diesel</option>
                                                <option value="605-007">605-007 - Diesel prepagado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Casetas Efectivo (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Casetas Efectivo</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="606-001">606-001 - Casetas efectivo</option>
                                                <option value="606-002">606-002 - Peaje efectivo</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Casetas Prepago (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Casetas Prepago</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="103-004">103-004 - Prepago casetas</option>
                                                <option value="606-003">606-003 - Casetas prepagadas</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Casetas Credito (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Casetas Credito</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="606-004">606-004 - Casetas crédito</option>
                                                <option value="606-005">606-005 - Peaje crédito</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Propio (Cargo) - segundo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Propio</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="605-001">605-001 - Diesel propio</option>
                                                <option value="605-002">605-002 - Combustible propio</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Prepago (Cargo) - segundo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Prepago</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="103-003">103-003 - Prepago diesel</option>
                                                <option value="605-007">605-007 - Diesel prepagado</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Diesel Credito (Cargo) - segundo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Diesel Credito</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="605-005">605-005 - Diesel crédito</option>
                                                <option value="605-006">605-006 - Combustible crédito</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Casetas Prepago (Cargo) - segundo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Casetas Prepago</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="103-004">103-004 - Prepago casetas</option>
                                                <option value="606-003">606-003 - Casetas prepagadas</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Casetas Credito (Cargo) - segundo -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Casetas Credito</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="606-004">606-004 - Casetas crédito</option>
                                                <option value="606-005">606-005 - Peaje crédito</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- IVA (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IVA</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="201-09-03">201-09-03 - IVA</option>
                                                <option value="201-09-04">201-09-04 - IVA acreditable</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Operador (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Operador</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="107-001">107-001 - Operadores</option>
                                                <option value="107-002">107-002 - Conductores</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>

                                    <!-- Sueldos por Pagar (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Sueldos por Pagar</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="202-001">202-001 - Sueldos por pagar</option>
                                                <option value="202-002">202-002 - Nómina por pagar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- IMSS (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">IMSS</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="202-003">202-003 - IMSS por pagar</option>
                                                <option value="202-004">202-004 - Cuotas IMSS</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Infonavit (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Infonavit</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="202-005">202-005 - Infonavit por pagar</option>
                                                <option value="202-006">202-006 - Aportaciones Infonavit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Otras Deducciones (Abono) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center; margin-bottom: 12px;">
                                        <div style="font-weight: 500; color: #495057;">Otras Deducciones</div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="202-007">202-007 - Deducciones varias</option>
                                                <option value="202-008">202-008 - Otras deducciones</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Gastos Comprobados (Cargo) -->
                                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; align-items: center;">
                                        <div style="font-weight: 500; color: #495057;">Gastos Comprobados</div>
                                        <div>
                                            <select style="width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 13px; background-color: white;">
                                                <option value="607-001">607-001 - Gastos comprobados</option>
                                                <option value="607-002">607-002 - Gastos con factura</option>
                                            </select>
                                        </div>
                                        <div style="text-align: center; color: #adb5bd; font-style: italic;">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- CONTENIDO: CUENTAS POR DEFECTO -->
                    <!-- ============================================ -->
                    <div id="content-cuentas-defecto" class="tab-content" style="display: block;">
                        <div style="background-color: white; border-radius: 12px; padding: 25px; border: 1px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <!-- Título de la sección -->
                            <div style="border-bottom: 2px solid #083CAE; padding-bottom: 15px; margin-bottom: 25px;">
                                <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">
                                    <i class="fas fa-book" style="margin-right: 10px;"></i> Cuentas por defecto
                                </h3>
                            </div>

                            <!-- Tabla de 2 columnas: Módulo y Cuenta contable -->
                            <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <!-- Encabezado de la tabla -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr; background-color: #f1f5f9; padding: 15px 20px; font-weight: 700; color: #083CAE; border-bottom: 2px solid #083CAE;">
                                    <div>Módulo</div>
                                    <div>Cuenta contable</div>
                                </div>

                                <!-- Filas de la tabla -->
                                <div style="padding: 5px 0;">
                                    <!-- Facturas -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Facturas</div>
                                        <div style="font-family: monospace;">101-05-01 - Clientes nacionales</div>
                                    </div>

                                    <!-- Depositos -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Depositos</div>
                                        <div style="font-family: monospace;">101-001 - Banco Nacional</div>
                                    </div>

                                    <!-- Cheques y Transferencias -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Cheques y Transferencias</div>
                                        <div style="font-family: monospace;">201-001 - Proveedores nacionales</div>
                                    </div>

                                    <!-- Cuentas por Pagar -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Cuentas por Pagar</div>
                                        <div style="font-family: monospace;">201-001 - Proveedores nacionales</div>
                                    </div>

                                    <!-- Entradas Almacen -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Entradas Almacen</div>
                                        <div style="font-family: monospace;">120-001 - Almacén general</div>
                                    </div>

                                    <!-- Salidas Almacen -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Salidas Almacen</div>
                                        <div style="font-family: monospace;">601-001 - Costo de ventas</div>
                                    </div>

                                    <!-- Ajuste Almacen -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Ajuste Almacen</div>
                                        <div style="font-family: monospace;">120-001 - Almacén general</div>
                                    </div>

                                    <!-- ISR -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">ISR</div>
                                        <div style="font-family: monospace;">220-001 - ISR por pagar</div>
                                    </div>

                                    <!-- IVA -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">IVA</div>
                                        <div style="font-family: monospace;">201-09-01 - IVA trasladado</div>
                                    </div>

                                    <!-- ISN -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">ISN</div>
                                        <div style="font-family: monospace;">220-004 - ISN por pagar</div>
                                    </div>

                                    <!-- Notas de Credito -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px; border-bottom: 1px solid #dee2e6;">
                                        <div style="font-weight: 500;">Notas de Credito</div>
                                        <div style="font-family: monospace;">101-05-01 - Clientes nacionales</div>
                                    </div>

                                    <!-- Liquidaciones -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; padding: 12px 20px;">
                                        <div style="font-weight: 500;">Liquidaciones</div>
                                        <div style="font-family: monospace;">603-001 - Sueldos</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón para editar (opcional) -->
                            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                                <button onclick="alert('Editar cuentas por defecto')" style="background-color: transparent; border: 1px solid #083CAE; color: #083CAE; padding: 8px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-edit"></i> Editar configuración
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- CONTENIDO: ESTADOS DE RESULTADOS -->
                    <!-- ============================================ -->
                    <div id="content-estados-resultados" class="tab-content" style="display: none;">
                        <div style="background-color: white; border-radius: 12px; padding: 25px; border: 1px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <!-- Título de la sección -->
                            <div style="border-bottom: 2px solid #083CAE; padding-bottom: 15px; margin-bottom: 25px;">
                                <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">
                                    <i class="fas fa-chart-line" style="margin-right: 10px;"></i> Estados de resultados
                                </h3>
                            </div>

                            <!-- Selectores de dos columnas -->
                            <div style="margin-bottom: 30px; background-color: #f8f9fa; padding: 25px; border-radius: 12px; border: 1px solid #dee2e6;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                    <!-- Columna izquierda: Estado de Resultado -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-chart-pie" style="margin-right: 5px;"></i> Estado de Resultado
                                        </label>
                                        <select id="selector-estado" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar concepto</option>
                                            <option value="sueldos-operadores">Sueldos Operadores</option>
                                            <option value="rastreo">Rastreo Satelital y Monitoreo</option>
                                            <option value="mantenimiento-preventivo">Mantenimiento Preventivo</option>
                                            <option value="llantas">Llantas</option>
                                            <option value="gasolina">Gasolina y Mtto. Utilitarios</option>
                                            <option value="indirectos">Indirectos Operadores</option>
                                            <option value="otros-gastos">Otros Gastos Admon.</option>
                                            <option value="arrendamiento">Arrendamiento</option>
                                            <option value="depreciacion">Depreciación</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Columna derecha: Cuenta Contable -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-book" style="margin-right: 5px;"></i> Cuenta Contable
                                        </label>
                                        <select id="selector-cuenta" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar cuenta</option>
                                            <option value="101-01-03">101-01-03 - ACTIVO A CORTO PLAZO PRUEBA</option>
                                            <option value="101-02-01">101-02-01 - Bancos nacionales</option>
                                            <option value="501-06">501-06 - Mano de obra directa</option>
                                            <option value="601-56">601-56 - Mantenimiento y conservación</option>
                                            <option value="603-56-01">603-56-01 - Mantenimiento y conservación</option>
                                            <option value="101-18-01">101-18-01 - IVA acreditable pagado</option>
                                            <option value="603-82-01">603-82-01 - Otros gastos de administración</option>
                                            <option value="101-03-02">101-03-02 - Inversiones en fideicomisos</option>
                                            <option value="604-56-01">604-56-01 - Mantenimiento y conservación</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Botón de agregar -->
                                <div style="display: flex; justify-content: flex-end;">
                                    <button onclick="agregarConcepto()" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>

                            <!-- Lista de elementos agregados -->
                            <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <!-- Encabezado -->
                                <div style="background-color: #f1f5f9; padding: 15px 20px; font-weight: 700; color: #083CAE; border-bottom: 2px solid #083CAE;">
                                    <div>Conceptos configurados</div>
                                </div>

                                <!-- Lista de conceptos con formato estado arriba / cuenta abajo -->
                                <div id="lista-conceptos" style="padding: 15px;">
                                    <!-- Sueldos Operadores -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Sueldos Operadores
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            101-01-03 - ACTIVO A CORTO PLAZO PRUEBA
                                        </div>
                                    </div>

                                    <!-- Bancos nacionales (solo cuenta) -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #6c757d; font-size: 15px; font-style: italic;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px; color: #6c757d;"></i> (cuenta sin concepto)
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            101-02-01 - Bancos nacionales
                                        </div>
                                    </div>

                                    <!-- ACTIVO A CORTO PLAZO PRUEBA (solo cuenta) -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #6c757d; font-size: 15px; font-style: italic;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px; color: #6c757d;"></i> (cuenta sin concepto)
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            101-01-03 - ACTIVO A CORTO PLAZO PRUEBA
                                        </div>
                                    </div>

                                    <!-- Rastreo Satelital y Monitoreo -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Rastreo Satelital y Monitoreo
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            501-06 - Mano de obra directa
                                        </div>
                                    </div>

                                    <!-- Mantenimiento Preventivo -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Mantenimiento Preventivo
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            601-56 - Mantenimiento y conservación
                                        </div>
                                    </div>

                                    <!-- Llantas -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Llantas
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            601-56 - Mantenimiento y conservación
                                        </div>
                                    </div>

                                    <!-- Gasolina y Mtto. Utilitarios -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Gasolina y Mtto. Utilitarios
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            603-56-01 - Mantenimiento y conservación
                                        </div>
                                    </div>

                                    <!-- Indirectos Operadores -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Indirectos Operadores
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            101-18-01 - IVA acreditable pagado
                                        </div>
                                    </div>

                                    <!-- Otros Gastos Admon. -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Otros Gastos Admon.
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            603-82-01 - Otros gastos de administración
                                        </div>
                                    </div>

                                    <!-- Arrendamiento -->
                                    <div class="concepto-item" style="margin-bottom: 20px; border-bottom: 1px solid #e9ecef; padding-bottom: 15px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Arrendamiento
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            101-03-02 - Inversiones en fideicomisos
                                        </div>
                                    </div>

                                    <!-- Depreciación -->
                                    <div class="concepto-item" style="margin-bottom: 0;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                            <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                                                <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> Depreciación
                                            </div>
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
                                        </div>
                                        <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                                            604-56-01 - Mantenimiento y conservación
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- CONTENIDO: ESTADOS DE RESULTADOS DE CONTABILIDAD -->
                    <!-- ============================================ -->
                    <div id="content-estados-contabilidad" class="tab-content" style="display: none;">
                        <div style="background-color: white; border-radius: 12px; padding: 25px; border: 1px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <!-- Título de la sección -->
                            <div style="border-bottom: 2px solid #083CAE; padding-bottom: 15px; margin-bottom: 25px;">
                                <h3 style="color: #083CAE; font-size: 20px; font-weight: bold; margin: 0;">
                                    <i class="fas fa-calculator" style="margin-right: 10px;"></i> Estados de resultados de contabilidad
                                </h3>
                            </div>

                            <!-- Selectores de 5 columnas para agregar -->
                            <div style="margin-bottom: 30px; background-color: #f8f9fa; padding: 25px; border-radius: 12px; border: 1px solid #dee2e6;">
                                <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 20px;">
                                    <!-- Columna 1: De -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-arrow-right" style="margin-right: 5px;"></i> De
                                        </label>
                                        <select id="selector-de" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar</option>
                                            <option value="INGRESOS">INGRESOS</option>
                                            <option value="GASTOS GENERALES">GASTOS GENERALES</option>
                                            <option value="COSTOS">COSTOS</option>
                                            <option value="OTROS">OTROS</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Columna 2: Para -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Para
                                        </label>
                                        <select id="selector-para" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar</option>
                                            <option value="VENTAS">VENTAS</option>
                                            <option value="UTILIDAD OPERATIVA">UTILIDAD OPERATIVA</option>
                                            <option value="COSTO VENTA">COSTO VENTA</option>
                                        </select>
                                    </div>

                                    <!-- Columna 3: Cuenta Contable Inicio -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-play" style="margin-right: 5px;"></i> Cuenta Contable Inicio
                                        </label>
                                        <select id="selector-cuenta-inicio" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar cuenta</option>
                                            <option value="401-01">401-01 - Ventas y/o servicios gravados a la tasa general</option>
                                            <option value="501-01">501-01 - Costo de venta</option>
                                            <option value="601-01">601-01 - Gastos generales</option>
                                            <option value="403-05">403-05 - Ingresos por condonación de adeudo</option>
                                            <option value="614-10">614-10 - Amortización de otros activos diferidos</option>
                                        </select>
                                    </div>

                                    <!-- Columna 4: Cuenta Contable Final -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-flag-checkered" style="margin-right: 5px;"></i> Cuenta Contable Final
                                        </label>
                                        <select id="selector-cuenta-final" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar cuenta</option>
                                            <option value="403-05">403-05 - Ingresos por condonación de adeudo</option>
                                            <option value="614-10">614-10 - Amortización de otros activos diferidos</option>
                                            <option value="401-01">401-01 - Ventas y/o servicios gravados a la tasa general</option>
                                            <option value="501-01">501-01 - Costo de venta</option>
                                        </select>
                                    </div>

                                    <!-- Columna 5: Tipo -->
                                    <div>
                                        <label style="display: block; font-weight: 600; color: #083CAE; margin-bottom: 8px; font-size: 14px;">
                                            <i class="fas fa-tag" style="margin-right: 5px;"></i> Tipo
                                        </label>
                                        <select id="selector-tipo" style="width: 100%; padding: 12px 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; background-color: white;">
                                            <option value="">Seleccionar tipo</option>
                                            <option value="Sumar">Sumar</option>
                                            <option value="Restar">Restar</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Botón de agregar -->
                                <div style="display: flex; justify-content: flex-end;">
                                    <button onclick="agregarConceptoContabilidad()" style="background-color: #2CBF1F; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de elementos configurados -->
                            <div style="border: 1px solid #dee2e6; border-radius: 12px; overflow: hidden;">
                                <!-- Encabezado de la tabla de 5 columnas -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr 2fr 2fr 1fr 0.5fr; background-color: #f1f5f9; padding: 15px 20px; font-weight: 700; color: #083CAE; border-bottom: 2px solid #083CAE;">
                                    <div>De</div>
                                    <div>Para</div>
                                    <div>Cuenta Contable Inicio</div>
                                    <div>Cuenta Contable Final</div>
                                    <div>Tipo</div>
                                    <div></div>
                                </div>

                                <!-- Filas de datos -->
                                <div id="lista-conceptos-contabilidad" style="padding: 5px 0;">
                                    <!-- INGRESOS → VENTAS -->
                                    <div class="concepto-contabilidad-item" style="display: grid; grid-template-columns: 1fr 1fr 2fr 2fr 1fr 0.5fr; padding: 15px 20px; border-bottom: 1px solid #dee2e6; align-items: center;">
                                        <div style="font-weight: 500;">INGRESOS</div>
                                        <div>VENTAS</div>
                                        <div style="font-family: monospace;">401-01 - Ventas y/o servicios gravados a la tasa general</div>
                                        <div style="font-family: monospace;">403-05 - Ingresos por condonación de adeudo</div>
                                        <div><span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Sumar</span></div>
                                        <div style="text-align: right;">
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConceptoContabilidad(this)" title="Eliminar"></i>
                                        </div>
                                    </div>

                                    <!-- GASTOS GENERALES → UTILIDAD OPERATIVA -->
                                    <div class="concepto-contabilidad-item" style="display: grid; grid-template-columns: 1fr 1fr 2fr 2fr 1fr 0.5fr; padding: 15px 20px; border-bottom: 1px solid #dee2e6; align-items: center;">
                                        <div style="font-weight: 500;">GASTOS GENERALES</div>
                                        <div>UTILIDAD OPERATIVA</div>
                                        <div style="font-family: monospace;">501-01 - Costo de venta</div>
                                        <div style="font-family: monospace;">614-10 - Amortización de otros activos diferidos</div>
                                        <div><span style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Restar</span></div>
                                        <div style="text-align: right;">
                                            <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConceptoContabilidad(this)" title="Eliminar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    .tab-vertical {
        transition: all 0.3s ease;
    }

    .tab-vertical:hover:not(.active) {
        background-color: #e9ecef !important;
        transform: translateX(5px);
    }

    .tab-vertical.active {
        background-color: #083CAE !important;
        color: white !important;
        box-shadow: 0 4px 8px rgba(8, 60, 174, 0.2);
    }

    .tab-vertical.active i {
        color: white !important;
    }

    select {
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
    }

    select:hover {
        border-color: #083CAE !important;
        box-shadow: 0 2px 4px rgba(8, 60, 174, 0.1);
    }

    select:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.2);
    }

    [onclick*="toggleModule"] {
        transition: background-color 0.3s ease;
    }

    [onclick*="toggleModule"]:hover {
        background-color: #e9ecef !important;
    }

    .concepto-item {
        transition: background-color 0.2s ease;
    }

    .concepto-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .concepto-contabilidad-item {
        transition: background-color 0.2s ease;
    }

    .concepto-contabilidad-item:hover {
        background-color: #f8f9fa;
    }

    .fa-trash-alt:hover {
        color: #c82333 !important;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        [style*="grid-template-columns: 250px 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
        
        [style*="grid-template-columns: 2fr 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
        
        [style*="grid-template-columns: repeat(5, 1fr)"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
        
        [style*="grid-template-columns: 1fr 1fr 2fr 2fr 1fr 0.5fr"] {
            grid-template-columns: 1fr !important;
            gap: 10px;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });

        document.querySelectorAll('.tab-vertical').forEach(tab => {
            tab.classList.remove('active');
            tab.style.backgroundColor = 'transparent';
            tab.style.color = '#495057';
            if (tab.querySelector('i')) {
                tab.querySelector('i').style.color = '#6c757d';
            }
        });

        document.getElementById(`content-${tabId}`).style.display = 'block';

        const activeTab = document.getElementById(`tab-${tabId}`);
        if (activeTab) {
            activeTab.classList.add('active');
            activeTab.style.backgroundColor = '#083CAE';
            activeTab.style.color = 'white';
            if (activeTab.querySelector('i')) {
                activeTab.querySelector('i').style.color = 'white';
            }
        }
    }

    function toggleModule(moduleId) {
        const content = document.getElementById(`content-${moduleId}`);
        const icon = document.getElementById(`icon-${moduleId}`);
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.className = 'fas fa-chevron-down';
        } else {
            content.style.display = 'none';
            icon.className = 'fas fa-chevron-right';
        }
    }

    // Función para agregar concepto desde los selectores (Estados de resultados)
    function agregarConcepto() {
        const selectorEstado = document.getElementById('selector-estado');
        const selectorCuenta = document.getElementById('selector-cuenta');
        
        const estado = selectorEstado.options[selectorEstado.selectedIndex]?.text;
        const cuenta = selectorCuenta.options[selectorCuenta.selectedIndex]?.text;
        
        if (!estado || estado === 'Seleccionar concepto') {
            alert('Por favor selecciona un concepto de Estado de Resultado');
            return;
        }
        
        if (!cuenta || cuenta === 'Seleccionar cuenta') {
            alert('Por favor selecciona una Cuenta Contable');
            return;
        }
        
        // Crear nuevo elemento en la lista
        const listaConceptos = document.getElementById('lista-conceptos');
        const nuevoItem = document.createElement('div');
        nuevoItem.className = 'concepto-item';
        nuevoItem.style.marginBottom = '20px';
        nuevoItem.style.borderBottom = '1px solid #e9ecef';
        nuevoItem.style.paddingBottom = '15px';
        
        nuevoItem.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                <div style="font-weight: 600; color: #083CAE; font-size: 15px;">
                    <i class="fas fa-tag" style="margin-right: 8px; font-size: 12px;"></i> ${estado}
                </div>
                <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConcepto(this)" title="Eliminar"></i>
            </div>
            <div style="font-family: monospace; background-color: #f8f9fa; padding: 10px 15px; border-radius: 6px; color: #495057; font-size: 13px; margin-left: 20px;">
                ${cuenta}
            </div>
        `;
        
        listaConceptos.appendChild(nuevoItem);
        
        // Resetear selectores
        selectorEstado.value = '';
        selectorCuenta.value = '';
        
        alert(`Concepto agregado: ${estado} → ${cuenta}`);
    }

    // Función para eliminar concepto (Estados de resultados)
    function eliminarConcepto(element) {
        if (confirm('¿Estás seguro de eliminar este concepto?')) {
            const item = element.closest('.concepto-item');
            item.remove();
        }
    }

    // Función para agregar concepto en la pestaña de contabilidad
    function agregarConceptoContabilidad() {
        const selectorDe = document.getElementById('selector-de');
        const selectorPara = document.getElementById('selector-para');
        const selectorCuentaInicio = document.getElementById('selector-cuenta-inicio');
        const selectorCuentaFinal = document.getElementById('selector-cuenta-final');
        const selectorTipo = document.getElementById('selector-tipo');
        
        const de = selectorDe.options[selectorDe.selectedIndex]?.text;
        const para = selectorPara.options[selectorPara.selectedIndex]?.text;
        const cuentaInicio = selectorCuentaInicio.options[selectorCuentaInicio.selectedIndex]?.text;
        const cuentaFinal = selectorCuentaFinal.options[selectorCuentaFinal.selectedIndex]?.text;
        const tipo = selectorTipo.options[selectorTipo.selectedIndex]?.text;
        
        if (!de || de === 'Seleccionar') {
            alert('Por favor selecciona un valor para "De"');
            return;
        }
        
        if (!para || para === 'Seleccionar') {
            alert('Por favor selecciona un valor para "Para"');
            return;
        }
        
        if (!cuentaInicio || cuentaInicio === 'Seleccionar cuenta') {
            alert('Por favor selecciona una Cuenta Contable de Inicio');
            return;
        }
        
        if (!cuentaFinal || cuentaFinal === 'Seleccionar cuenta') {
            alert('Por favor selecciona una Cuenta Contable Final');
            return;
        }
        
        if (!tipo || tipo === 'Seleccionar tipo') {
            alert('Por favor selecciona un Tipo');
            return;
        }
        
        // Determinar color según tipo
        const colorTipo = tipo === 'Sumar' ? '#28a745' : '#dc3545';
        
        // Crear nuevo elemento en la lista
        const listaConceptos = document.getElementById('lista-conceptos-contabilidad');
        const nuevoItem = document.createElement('div');
        nuevoItem.className = 'concepto-contabilidad-item';
        nuevoItem.style.display = 'grid';
        nuevoItem.style.gridTemplateColumns = '1fr 1fr 2fr 2fr 1fr 0.5fr';
        nuevoItem.style.padding = '15px 20px';
        nuevoItem.style.borderBottom = '1px solid #dee2e6';
        nuevoItem.style.alignItems = 'center';
        
        nuevoItem.innerHTML = `
            <div style="font-weight: 500;">${de}</div>
            <div>${para}</div>
            <div style="font-family: monospace;">${cuentaInicio}</div>
            <div style="font-family: monospace;">${cuentaFinal}</div>
            <div><span style="background-color: ${colorTipo}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">${tipo}</span></div>
            <div style="text-align: right;">
                <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" onclick="eliminarConceptoContabilidad(this)" title="Eliminar"></i>
            </div>
        `;
        
        listaConceptos.appendChild(nuevoItem);
        
        // Resetear selectores
        selectorDe.value = '';
        selectorPara.value = '';
        selectorCuentaInicio.value = '';
        selectorCuentaFinal.value = '';
        selectorTipo.value = '';
        
        alert(`Concepto agregado: ${de} → ${para}`);
    }

    // Función para eliminar concepto de contabilidad
    function eliminarConceptoContabilidad(element) {
        if (confirm('¿Estás seguro de eliminar este concepto?')) {
            const item = element.closest('.concepto-contabilidad-item');
            item.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar Cuentas por defecto por defecto (activa)
        showTab('cuentas-defecto');
        
        // Inicializar todos los módulos de Datos Generales contraídos
        const modules = [
            'facturas', 'depositos', 'cheques', 'cuentas-pagar', 
            'entradas-almacen', 'salidas-almacen', 'ajuste-almacen', 'isr',
            'iva', 'isn', 'notas-credito', 'liquidaciones'
        ];
        modules.forEach(module => {
            const content = document.getElementById(`content-${module}`);
            const icon = document.getElementById(`icon-${module}`);
            if (content && icon) {
                content.style.display = 'none';
                icon.className = 'fas fa-chevron-right';
            }
        });
    });
</script>
@endsection