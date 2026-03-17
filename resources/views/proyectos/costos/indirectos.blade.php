@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Costos Indirectos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Costos Indirectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE COSTOS INDIRECTOS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Costos Indirectos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Indirectos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalIndirectos">$3,720,000</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Personal Técnico -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Personal Técnico</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPersonal">$1,420,000</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Administración de Obra -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Admón. Obra</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAdmin">$890,000</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Seguridad e Higiene -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Seguridad</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalSeguridad">$520,000</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con agrupación y botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación discreto en la esquina izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;">
                            <!-- Aquí se mostrarán las columnas agrupadas -->
                        </div>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Date Inicio -->
                        <div>
                            <input type="date" id="fechaInicio" value="2026-02-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-02-28" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Agregar Costo -->
                        <div>
                            <button id="btnAgregarCosto" 
                                    style="background-color: #28a745; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;"
                                    title="Agregar nuevo costo indirecto">
                                <i class="fas fa-plus-circle"></i> Agregar Costo
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div>
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-tools" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Costos Indirectos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaCostosIndirectos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <!-- PRIMERA FILA DE ENCABEZADOS -->
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proyecto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Categoría</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="concepto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Concepto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proveedor">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proveedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="rfc">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>RFC</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="factura">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factura</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="iva">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="forma_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus_pago">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="observaciones">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Observaciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Acciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente con JavaScript -->
                        </tbody>
                        <!-- Fila de totales -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold; display: table-footer-group;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="8">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación y botón Crear filtro -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Crear filtro (izquierda) - SIN FONDO -->
                    <button id="btnCrearFiltro" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-filter" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Crear filtro</span>
                    </button>
                    
                    <!-- Controles de paginación (derecha) - AZUL Y SIN FONDO -->
                    <div style="display: flex; align-items: center; gap: 5px; background: transparent; background-color: transparent;">
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Primera página" id="btnPrimera">
                            <i class="fas fa-angle-double-left" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página anterior" id="btnAnterior">
                            <i class="fas fa-angle-left" style="color: #2378e1;"></i>
                        </button>
                        <span style="padding: 5px 10px; background-color: #2378e1; color: white; border-radius: 4px; font-size: 14px;" id="paginaActual">1</span>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="2">2</button>
                        <button class="pagina-btn" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" data-pagina="3">3</button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 30 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Agregar Costo Indirecto -->
<div id="modalAgregarCosto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus-circle"></i> Agregar Costo Indirecto
            </h3>
            <button id="btnCerrarModalAgregar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formAgregarCosto">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proyecto <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="campoProyecto" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto</option>
                            <option value="Torre Norte"> Torre Norte Corporativa</option>
                            <option value="Hospital Regional"> Hospital Regional</option>
                            <option value="Parque Industrial"> Parque Industrial Norte</option>
                            <option value="Puente Sur"> Puente Vehicular Sur</option>
                            <option value="Urbanización Los Álamos"> Urbanización Los Álamos</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Categoría <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="campoCategoria" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar categoría</option>
                            <option value="Personal Técnico"> Personal Técnico</option>
                            <option value="Administración"> Administración de Obra</option>
                            <option value="Seguridad"> Seguridad e Higiene</option>
                            <option value="Servicios"> Servicios Generales</option>
                            <option value="Herramienta"> Herramienta y Equipo</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Concepto <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" id="campoConcepto" required placeholder="Ej. Residente de Obra, Energía Eléctrica, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="date" id="campoFecha" required value="2026-03-01" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proveedor
                        </label>
                        <input type="text" id="campoProveedor" placeholder="Nombre del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            RFC
                        </label>
                        <input type="text" id="campoRFC" placeholder="RFC del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Factura
                        </label>
                        <input type="text" id="campoFactura" placeholder="Número de factura" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Descripción
                    </label>
                    <textarea id="campoDescripcion" rows="2" placeholder="Descripción detallada del concepto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Subtotal <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="campoSubtotal" required step="0.01" min="0" value="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            IVA
                        </label>
                        <input type="number" id="campoIva" step="0.01" min="0" value="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Total
                        </label>
                        <input type="number" id="campoTotal" step="0.01" min="0" value="0.00" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Forma de Pago
                        </label>
                        <select id="campoFormaPago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Transferencia">Transferencia</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha de Pago
                        </label>
                        <input type="date" id="campoFechaPago" value="2026-03-15" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Estatus de Pago
                    </label>
                    <select id="campoEstatusPago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="Pagado"> Pagado</option>
                        <option value="Pendiente"> Pendiente</option>
                        <option value="Programado"> Programado</option>
                        <option value="Vencido"> Vencido</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Observaciones
                    </label>
                    <textarea id="campoObservaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarAgregar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                        Cancelar
                    </button>
                    <button type="submit" style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Guardar Costo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Costo Indirecto -->
<div id="modalEditarCosto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-edit"></i> Editar Costo Indirecto
            </h3>
            <button id="btnCerrarModalEditar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formEditarCosto">
                <input type="hidden" id="editIndex">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proyecto <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="editProyecto" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto</option>
                            <option value="Torre Norte"> Torre Norte Corporativa</option>
                            <option value="Hospital Regional"> Hospital Regional</option>
                            <option value="Parque Industrial"> Parque Industrial Norte</option>
                            <option value="Puente Sur"> Puente Vehicular Sur</option>
                            <option value="Urbanización Los Álamos"> Urbanización Los Álamos</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Categoría <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="editCategoria" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar categoría</option>
                            <option value="Personal Técnico"> Personal Técnico</option>
                            <option value="Administración"> Administración de Obra</option>
                            <option value="Seguridad"> Seguridad e Higiene</option>
                            <option value="Servicios"> Servicios Generales</option>
                            <option value="Herramienta">Herramienta y Equipo</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Concepto <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" id="editConcepto" required placeholder="Ej. Residente de Obra, Energía Eléctrica, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="date" id="editFecha" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proveedor
                        </label>
                        <input type="text" id="editProveedor" placeholder="Nombre del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            RFC
                        </label>
                        <input type="text" id="editRFC" placeholder="RFC del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Factura
                        </label>
                        <input type="text" id="editFactura" placeholder="Número de factura" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Descripción
                    </label>
                    <textarea id="editDescripcion" rows="2" placeholder="Descripción detallada del concepto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Subtotal <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="editSubtotal" required step="0.01" min="0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            IVA
                        </label>
                        <input type="number" id="editIva" step="0.01" min="0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Total
                        </label>
                        <input type="number" id="editTotal" step="0.01" min="0" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Forma de Pago
                        </label>
                        <select id="editFormaPago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Transferencia">Transferencia</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha de Pago
                        </label>
                        <input type="date" id="editFechaPago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Estatus de Pago
                    </label>
                    <select id="editEstatusPago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                        <option value="Pagado"> Pagado</option>
                        <option value="Pendiente"> Pendiente</option>
                        <option value="Programado"> Programado</option>
                        <option value="Vencido"> Vencido</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Observaciones
                    </label>
                    <textarea id="editObservaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #dee2e6; padding-top: 20px;">
                    <button type="button" id="btnCancelarEditar" style="padding: 8px 20px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                        Cancelar
                    </button>
                    <button type="submit" style="padding: 8px 20px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-save"></i> Actualizar Costo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Costo -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 80vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #2378e1 0%, #1a5cb0 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i> <span id="modalTitulo">Detalle de Costo Indirecto</span>
            </h3>
            <button id="btnCerrarModalDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;" id="modalContenidoDetalle">
            <!-- Contenido dinámico -->
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
    
    /* Estilo para las filas alternadas */
    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    #tablaBody tr:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
        margin: 0 3px;
    }
    
    #tablaBody td i:hover {
        transform: scale(1.2);
    }
    
    /* Estilo para el filtro en encabezados */
    .table th i {
        opacity: 0.7;
        transition: opacity 0.2s;
        color: white;
    }
    
    .table th i:hover {
        opacity: 1;
    }
    
    /* Columna de acciones fija */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-pagado {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pendiente {
        background-color: #ffc107;
        color: black;
    }
    
    .badge-programado {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-vencido {
        background-color: #dc3545;
        color: white;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
    }
    
    /* Estilos para agrupación de columnas */
    [draggable="true"] {
        cursor: grab;
    }
    
    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }
    
    #grupoAgrupacion {
        position: relative;
    }
    
    #grupoColumnas {
        display: inline-flex;
        align-items: center;
    }
    
    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #f0f4ff;
        border-radius: 16px;
        color: #2378e1;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #2378e1;
    }
    
    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #2378e1;
    }
    
    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }
    
    /* Estilo para filas de grupo */
    .fila-grupo {
        background-color: #f0f7ff !important;
        font-weight: 500;
        cursor: pointer;
    }
    
    .fila-grupo:hover {
        background-color: #e1f0ff !important;
    }
    
    .fila-grupo td:first-child i {
        transition: transform 0.2s;
        margin-right: 8px;
    }
    
    .fila-grupo:not(.expandido) td:first-child i {
        transform: rotate(-90deg);
    }
    
    .fila-detalle {
        background-color: #ffffff;
    }
    
    .fila-detalle td {
        border-top: none !important;
    }
    
    .fila-detalle td:first-child {
        padding-left: 30px !important;
    }
    
    /* Estilo cuando se está arrastrando sobre el área de grupo */
    .drag-over #grupoColumnas {
        background-color: rgba(35, 120, 225, 0.1);
        border-radius: 4px;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    
    /* ESTILOS CORREGIDOS PARA PAGINACIÓN */
    #paginacionContainer {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Todos los elementos dentro del contenedor también sin fondo */
    #paginacionContainer * {
        background: transparent !important;
        background-color: transparent !important;
    }
    
    /* Excepción para los spans que deben tener fondo azul */
    #paginacionContainer span[style*="background-color"] {
        background-color: #2378e1 !important;
    }
    
    /* Estilos para los botones de paginación */
    #paginacionContainer button {
        background: transparent !important;
        border: none !important;
        color: #2378e1 !important;
        cursor: pointer;
    }
    
    #paginacionContainer button:hover {
        opacity: 0.7;
    }
    
    #paginacionContainer button i {
        color: #2378e1 !important;
    }
    
    /* Estilo específico para btnCrearFiltro */
    #btnCrearFiltro,
    #btnCrearFiltro:hover,
    #btnCrearFiltro:focus,
    #btnCrearFiltro:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnCrearFiltro i,
    #btnCrearFiltro span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"] {
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
        
        #paginacionContainer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Costos Indirectos');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        
        // Datos de ejemplo para Costos Indirectos (30 filas)
        const datosCostosIndirectos = [
            // Torre Norte - Personal Técnico
            {
                proyecto: 'Torre Norte',
                categoria: 'Personal Técnico',
                concepto: 'Residente de Obra',
                fecha: '2026-02-15',
                proveedor: 'Juan Pérez García',
                rfc: 'PEGJ850101XXX',
                factura: 'F-1001',
                descripcion: 'Honorarios residente de obra - febrero 2026',
                subtotal: 125000.00,
                iva: 20000.00,
                total: 145000.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: 'Incluye prestaciones'
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Personal Técnico',
                concepto: 'Supervisor de Obra',
                fecha: '2026-02-15',
                proveedor: 'María López Sánchez',
                rfc: 'LOSM850202XXX',
                factura: 'F-1002',
                descripcion: 'Honorarios supervisor de obra - febrero 2026',
                subtotal: 98000.00,
                iva: 15680.00,
                total: 113680.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Personal Técnico',
                concepto: 'Topógrafo',
                fecha: '2026-02-15',
                proveedor: 'Carlos Rodríguez',
                rfc: 'RODC850303XXX',
                factura: 'F-1003',
                descripcion: 'Servicios topografía - febrero 2026',
                subtotal: 42000.00,
                iva: 6720.00,
                total: 48720.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Administración',
                concepto: 'Almacenista',
                fecha: '2026-02-15',
                proveedor: 'Ana Martínez',
                rfc: 'MAAA850404XXX',
                factura: 'F-1004',
                descripcion: 'Honorarios almacenista - febrero 2026',
                subtotal: 32000.00,
                iva: 5120.00,
                total: 37120.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Administración',
                concepto: 'Auxiliar Administrativo',
                fecha: '2026-02-15',
                proveedor: 'Luis Ramírez',
                rfc: 'RAGL850505XXX',
                factura: 'F-1005',
                descripcion: 'Honorarios auxiliar administrativo - febrero 2026',
                subtotal: 28000.00,
                iva: 4480.00,
                total: 32480.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Seguridad',
                concepto: 'Señalización',
                fecha: '2026-02-10',
                proveedor: 'Seguridad Industrial SA',
                rfc: 'SIN850606XXX',
                factura: 'F-1006',
                descripcion: 'Señalamientos preventivos y restrictivos',
                subtotal: 18500.00,
                iva: 2960.00,
                total: 21460.00,
                forma_pago: 'Cheque',
                fecha_pago: '2026-02-20',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Seguridad',
                concepto: 'Equipo de Protección',
                fecha: '2026-02-05',
                proveedor: 'Protección Total',
                rfc: 'PRO850707XXX',
                factura: 'F-1007',
                descripcion: 'Cascos, arneses, lentes, guantes',
                subtotal: 22400.00,
                iva: 3584.00,
                total: 25984.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-15',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Servicios',
                concepto: 'Energía Eléctrica',
                fecha: '2026-02-20',
                proveedor: 'CFE',
                rfc: 'CFE850808XXX',
                factura: 'F-1008',
                descripcion: 'Consumo energía eléctrica febrero 2026',
                subtotal: 18500.00,
                iva: 2960.00,
                total: 21460.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-03-05',
                estatus_pago: 'Pendiente',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Servicios',
                concepto: 'Agua Potable',
                fecha: '2026-02-20',
                proveedor: 'JAPAC',
                rfc: 'JAP850909XXX',
                factura: 'F-1009',
                descripcion: 'Consumo agua febrero 2026',
                subtotal: 5200.00,
                iva: 832.00,
                total: 6032.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-03-10',
                estatus_pago: 'Programado',
                observaciones: ''
            },
            {
                proyecto: 'Torre Norte',
                categoria: 'Herramienta',
                concepto: 'Herramienta Menor',
                fecha: '2026-02-12',
                proveedor: 'Ferretería Industrial',
                rfc: 'FIN851010XXX',
                factura: 'F-1010',
                descripcion: 'Herramientas manuales y consumibles',
                subtotal: 18500.00,
                iva: 2960.00,
                total: 21460.00,
                forma_pago: 'Efectivo',
                fecha_pago: '2026-02-12',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            
            // Hospital Regional - Personal Técnico
            {
                proyecto: 'Hospital Regional',
                categoria: 'Personal Técnico',
                concepto: 'Residente de Obra',
                fecha: '2026-02-15',
                proveedor: 'Roberto Sánchez',
                rfc: 'SARO851111XXX',
                factura: 'F-1011',
                descripcion: 'Honorarios residente de obra - febrero 2026',
                subtotal: 145000.00,
                iva: 23200.00,
                total: 168200.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Personal Técnico',
                concepto: 'Supervisor de Obra',
                fecha: '2026-02-15',
                proveedor: 'Laura Gómez',
                rfc: 'GOAL851212XXX',
                factura: 'F-1012',
                descripcion: 'Honorarios supervisor de obra - febrero 2026',
                subtotal: 112000.00,
                iva: 17920.00,
                total: 129920.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Personal Técnico',
                concepto: 'Topógrafo',
                fecha: '2026-02-15',
                proveedor: 'Javier Ruiz',
                rfc: 'RUIJ851313XXX',
                factura: 'F-1013',
                descripcion: 'Servicios topografía - febrero 2026',
                subtotal: 48000.00,
                iva: 7680.00,
                total: 55680.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Personal Técnico',
                concepto: 'Inspector de Calidad',
                fecha: '2026-02-15',
                proveedor: 'Sofía Castro',
                rfc: 'CASS851414XXX',
                factura: 'F-1014',
                descripcion: 'Control de calidad - febrero 2026',
                subtotal: 42000.00,
                iva: 6720.00,
                total: 48720.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Administración',
                concepto: 'Almacenista',
                fecha: '2026-02-15',
                proveedor: 'Miguel Torres',
                rfc: 'TORN851515XXX',
                factura: 'F-1015',
                descripcion: 'Honorarios almacenista - febrero 2026',
                subtotal: 35000.00,
                iva: 5600.00,
                total: 40600.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Administración',
                concepto: 'Auxiliar Administrativo',
                fecha: '2026-02-15',
                proveedor: 'Diana Flores',
                rfc: 'FOLD851616XXX',
                factura: 'F-1016',
                descripcion: 'Honorarios auxiliar administrativo - febrero 2026',
                subtotal: 32000.00,
                iva: 5120.00,
                total: 37120.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Seguridad',
                concepto: 'Señalización',
                fecha: '2026-02-12',
                proveedor: 'Seguridad Integral',
                rfc: 'SII851717XXX',
                factura: 'F-1017',
                descripcion: 'Señalamientos obra',
                subtotal: 28000.00,
                iva: 4480.00,
                total: 32480.00,
                forma_pago: 'Cheque',
                fecha_pago: '2026-02-25',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Seguridad',
                concepto: 'Equipo de Protección',
                fecha: '2026-02-08',
                proveedor: 'Equipos de Seguridad',
                rfc: 'EQS851818XXX',
                factura: 'F-1018',
                descripcion: 'EPP para personal',
                subtotal: 32500.00,
                iva: 5200.00,
                total: 37700.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-20',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Servicios',
                concepto: 'Energía Eléctrica',
                fecha: '2026-02-22',
                proveedor: 'CFE',
                rfc: 'CFE851919XXX',
                factura: 'F-1019',
                descripcion: 'Consumo energía eléctrica febrero 2026',
                subtotal: 28500.00,
                iva: 4560.00,
                total: 33060.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-03-08',
                estatus_pago: 'Pendiente',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Servicios',
                concepto: 'Agua Potable',
                fecha: '2026-02-22',
                proveedor: 'JAPAC',
                rfc: 'JAP852020XXX',
                factura: 'F-1020',
                descripcion: 'Consumo agua febrero 2026',
                subtotal: 8200.00,
                iva: 1312.00,
                total: 9512.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-03-10',
                estatus_pago: 'Programado',
                observaciones: ''
            },
            {
                proyecto: 'Hospital Regional',
                categoria: 'Herramienta',
                concepto: 'Herramienta Menor',
                fecha: '2026-02-14',
                proveedor: 'Ferretería Nacional',
                rfc: 'FEN852121XXX',
                factura: 'F-1021',
                descripcion: 'Herramientas y accesorios',
                subtotal: 22500.00,
                iva: 3600.00,
                total: 26100.00,
                forma_pago: 'Efectivo',
                fecha_pago: '2026-02-14',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            
            // Parque Industrial
            {
                proyecto: 'Parque Industrial',
                categoria: 'Personal Técnico',
                concepto: 'Residente de Obra',
                fecha: '2026-02-15',
                proveedor: 'Pedro Hernández',
                rfc: 'HEPE852222XXX',
                factura: 'F-1022',
                descripcion: 'Honorarios residente de obra - febrero 2026',
                subtotal: 98000.00,
                iva: 15680.00,
                total: 113680.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Parque Industrial',
                categoria: 'Personal Técnico',
                concepto: 'Supervisor de Obra',
                fecha: '2026-02-15',
                proveedor: 'Carmen López',
                rfc: 'LOCA852323XXX',
                factura: 'F-1023',
                descripcion: 'Honorarios supervisor de obra - febrero 2026',
                subtotal: 82000.00,
                iva: 13120.00,
                total: 95120.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Parque Industrial',
                categoria: 'Administración',
                concepto: 'Almacenista',
                fecha: '2026-02-15',
                proveedor: 'Jorge Núñez',
                rfc: 'NUGJ852424XXX',
                factura: 'F-1024',
                descripcion: 'Honorarios almacenista - febrero 2026',
                subtotal: 28000.00,
                iva: 4480.00,
                total: 32480.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Parque Industrial',
                categoria: 'Seguridad',
                concepto: 'Equipo de Protección',
                fecha: '2026-02-10',
                proveedor: 'Seguridad Ocupacional',
                rfc: 'SOC852525XXX',
                factura: 'F-1025',
                descripcion: 'EPP para personal',
                subtotal: 18500.00,
                iva: 2960.00,
                total: 21460.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-20',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Parque Industrial',
                categoria: 'Servicios',
                concepto: 'Energía Eléctrica',
                fecha: '2026-02-21',
                proveedor: 'CFE',
                rfc: 'CFE852626XXX',
                factura: 'F-1026',
                descripcion: 'Consumo energía eléctrica febrero 2026',
                subtotal: 22500.00,
                iva: 3600.00,
                total: 26100.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-03-07',
                estatus_pago: 'Pendiente',
                observaciones: ''
            },
            {
                proyecto: 'Parque Industrial',
                categoria: 'Herramienta',
                concepto: 'Herramienta Menor',
                fecha: '2026-02-11',
                proveedor: 'Ferretería Industrial',
                rfc: 'FIN852727XXX',
                factura: 'F-1027',
                descripcion: 'Herramientas manuales',
                subtotal: 16500.00,
                iva: 2640.00,
                total: 19140.00,
                forma_pago: 'Efectivo',
                fecha_pago: '2026-02-11',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            
            // Puente Sur
            {
                proyecto: 'Puente Sur',
                categoria: 'Personal Técnico',
                concepto: 'Residente de Obra',
                fecha: '2026-02-15',
                proveedor: 'Ricardo Castro',
                rfc: 'CARF852828XXX',
                factura: 'F-1028',
                descripcion: 'Honorarios residente de obra - febrero 2026',
                subtotal: 85000.00,
                iva: 13600.00,
                total: 98600.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Puente Sur',
                categoria: 'Personal Técnico',
                concepto: 'Supervisor de Obra',
                fecha: '2026-02-15',
                proveedor: 'Patricia Vargas',
                rfc: 'VAPP852929XXX',
                factura: 'F-1029',
                descripcion: 'Honorarios supervisor de obra - febrero 2026',
                subtotal: 72000.00,
                iva: 11520.00,
                total: 83520.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-28',
                estatus_pago: 'Pagado',
                observaciones: ''
            },
            {
                proyecto: 'Puente Sur',
                categoria: 'Seguridad',
                concepto: 'Equipo de Protección',
                fecha: '2026-02-09',
                proveedor: 'Protección Civil',
                rfc: 'PRC853030XXX',
                factura: 'F-1030',
                descripcion: 'EPP para personal',
                subtotal: 12500.00,
                iva: 2000.00,
                total: 14500.00,
                forma_pago: 'Transferencia',
                fecha_pago: '2026-02-18',
                estatus_pago: 'Pagado',
                observaciones: ''
            }
        ];
        
        datosOriginales = [...datosCostosIndirectos];
        totalRows = datosOriginales.length;
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const totalIndirectos = datos.reduce((sum, item) => sum + item.total, 0);
            const totalPersonal = datos.filter(item => item.categoria === 'Personal Técnico').reduce((sum, item) => sum + item.total, 0);
            const totalAdmin = datos.filter(item => item.categoria === 'Administración').reduce((sum, item) => sum + item.total, 0);
            const totalSeguridad = datos.filter(item => item.categoria === 'Seguridad').reduce((sum, item) => sum + item.total, 0);
            
            document.getElementById('totalIndirectos').textContent = '$' + (totalIndirectos / 1000000).toFixed(1) + 'M';
            document.getElementById('totalPersonal').textContent = '$' + (totalPersonal / 1000000).toFixed(1) + 'M';
            document.getElementById('totalAdmin').textContent = '$' + (totalAdmin / 1000000).toFixed(1) + 'M';
            document.getElementById('totalSeguridad').textContent = '$' + (totalSeguridad / 1000000).toFixed(1) + 'M';
        }
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            return dateString;
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'proyecto': return item.proyecto || 'Sin proyecto';
                    case 'categoria': return item.categoria || 'Sin categoría';
                    case 'concepto': return item.concepto || 'Sin concepto';
                    case 'estatus_pago': return item.estatus_pago || 'Sin estatus';
                    default: return '';
                }
            }).join('||');
        }
        
        // Función para agrupar datos por columnas seleccionadas
        function agruparDatos(datos, columnas) {
            if (columnas.length === 0) return { grupos: [], items: datos };
            
            const gruposMap = new Map();
            
            datos.forEach(item => {
                const grupoId = generarGrupoId(item, columnas);
                
                if (!gruposMap.has(grupoId)) {
                    // Crear un nuevo grupo
                    const valorGrupo = columnas.map(col => {
                        switch(col) {
                            case 'proyecto': return item.proyecto || 'Sin proyecto';
                            case 'categoria': return item.categoria || 'Sin categoría';
                            case 'concepto': return item.concepto || 'Sin concepto';
                            case 'estatus_pago': return item.estatus_pago || 'Sin estatus';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalSubtotal: item.subtotal || 0,
                        totalIva: item.iva || 0,
                        totalGeneral: item.total || 0
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalSubtotal += item.subtotal || 0;
                    grupo.totalIva += item.iva || 0;
                    grupo.totalGeneral += item.total || 0;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalSubtotal = 0;
            let totalIva = 0;
            let totalGeneral = 0;
            
            datos.forEach(item => {
                totalSubtotal += item.subtotal || 0;
                totalIva += item.iva || 0;
                totalGeneral += item.total || 0;
            });
            
            document.getElementById('sumSubtotal').textContent = formatCurrency(totalSubtotal);
            document.getElementById('sumIva').textContent = formatCurrency(totalIva);
            document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
        }
        
        // Función para obtener datos de la página actual
        function getCurrentPageData(datos) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            return datos.slice(start, end);
        }
        
        // Función para actualizar la paginación
        function actualizarPaginacion(total) {
            const totalPages = Math.ceil(total / rowsPerPage);
            document.getElementById('paginaActual').textContent = currentPage;
            document.getElementById('paginacionInfo').textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const tablaContainer = document.getElementById('tablaContainer');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
            const textoAgrupar = document.getElementById('textoAgrupar');
            const tablaFoot = document.getElementById('tablaFoot');
            
            if (!tablaBody) return;
            
            // Actualizar contadores de los cuadros
            actualizarContadores(datos);
            
            // Ocultar texto de agrupar si hay columnas agrupadas
            if (textoAgrupar) {
                textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
            }
            
            // Aplicar agrupación si hay columnas seleccionadas
            const { grupos } = agruparDatos(datos, columnasAgrupadas);
            const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumSubtotal').textContent = '$0.00';
                document.getElementById('sumIva').textContent = '$0.00';
                document.getElementById('sumTotal').textContent = '$0.00';
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            if (hayGrupos) {
                // Ocultar pie de tabla cuando hay grupos
                if (tablaFoot) tablaFoot.style.display = 'none';
                
                // Mostrar grupos
                grupos.forEach(grupo => {
                    const grupoRow = document.createElement('tr');
                    grupoRow.className = 'fila-grupo';
                    grupoRow.dataset.grupoId = grupo.id;
                    
                    if (expandedGroups.has(grupo.id)) {
                        grupoRow.classList.add('expandido');
                    }
                    
                    grupoRow.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="16">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Subtotal: ${formatCurrency(grupo.totalSubtotal)} - Total: ${formatCurrency(grupo.totalGeneral)})
                                    </span>
                                </div>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(grupoRow);
                    
                    // Mostrar items del grupo si está expandido
                    if (expandedGroups.has(grupo.id)) {
                        grupo.items.forEach(item => {
                            const detalleRow = document.createElement('tr');
                            detalleRow.className = 'fila-detalle';
                            
                            // Badge para estatus de pago
                            let badgeClass = 'badge-pendiente';
                            if (item.estatus_pago === 'Pagado') badgeClass = 'badge-pagado';
                            else if (item.estatus_pago === 'Programado') badgeClass = 'badge-programado';
                            else if (item.estatus_pago === 'Vencido') badgeClass = 'badge-vencido';
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.categoria || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proveedor || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factura || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_pago)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.estatus_pago || '-'}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalleCosto(${JSON.stringify(item).replace(/"/g, '&quot;')}, event)"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarCosto(${JSON.stringify(item).replace(/"/g, '&quot;')}, event)"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarCosto(event)"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                    </div>
                                </td>
                            `;
                            
                            tablaBody.appendChild(detalleRow);
                        });
                    }
                });
                
                if (paginacionInfo) {
                    const totalRegistros = datos.length;
                    const mostrando = grupos.length;
                    paginacionInfo.textContent = `Mostrando ${mostrando} grupos de ${totalRegistros} registros`;
                }
            } else {
                // Mostrar todos los items sin agrupar (con paginación)
                const pageData = getCurrentPageData(datos);
                
                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    
                    // Badge para estatus de pago
                    let badgeClass = 'badge-pendiente';
                    if (item.estatus_pago === 'Pagado') badgeClass = 'badge-pagado';
                    else if (item.estatus_pago === 'Programado') badgeClass = 'badge-programado';
                    else if (item.estatus_pago === 'Vencido') badgeClass = 'badge-vencido';
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.categoria || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proveedor || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rfc || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.factura || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.descripcion || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.total ? formatCurrency(item.total) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.forma_pago || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${formatDate(item.fecha_pago)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge ${badgeClass}">${item.estatus_pago || '-'}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.observaciones || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick='verDetalleCosto(${JSON.stringify(item)}, event)'></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick='editarCosto(${JSON.stringify(item)}, event)'></i>
                                <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarCosto(event)"></i>
                                <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con totales
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                calcularTotales(datos);
                
                actualizarPaginacion(datos.length);
            }
        }
        
        // Función para actualizar la visualización de columnas agrupadas
        function actualizarGrupoColumnas() {
            const grupoContainer = document.getElementById('grupoColumnas');
            const textoAgrupar = document.getElementById('textoAgrupar');
            
            if (!grupoContainer) return;
            
            grupoContainer.innerHTML = '';
            
            if (columnasAgrupadas.length === 0) {
                if (textoAgrupar) textoAgrupar.style.display = 'inline';
            } else {
                if (textoAgrupar) textoAgrupar.style.display = 'none';
                
                columnasAgrupadas.forEach(col => {
                    const nombreColumna = {
                        'proyecto': 'Proyecto',
                        'categoria': 'Categoría',
                        'concepto': 'Concepto',
                        'estatus_pago': 'Estatus Pago'
                    }[col] || col;
                    
                    const chip = document.createElement('span');
                    chip.className = 'columna-agrupada';
                    chip.innerHTML = `
                        ${nombreColumna}
                        <span class="remover" data-columna="${col}">&times;</span>
                    `;
                    grupoContainer.appendChild(chip);
                });
            }
            
            // Limpiar grupos expandidos al cambiar agrupación
            expandedGroups.clear();
            
            // Recargar tabla con nueva agrupación
            cargarTabla(datosOriginales);
        }
        
        // Configurar drag and drop
        function setupDragAndDrop() {
            const encabezados = document.querySelectorAll('th[draggable="true"]');
            const grupoAgrupacion = document.getElementById('grupoAgrupacion');
            
            encabezados.forEach(th => {
                th.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', th.dataset.columna);
                    e.dataTransfer.effectAllowed = 'copy';
                    th.style.opacity = '0.5';
                });
                
                th.addEventListener('dragend', (e) => {
                    th.style.opacity = '1';
                });
            });
            
            grupoAgrupacion.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                grupoAgrupacion.classList.add('drag-over');
            });
            
            grupoAgrupacion.addEventListener('dragleave', () => {
                grupoAgrupacion.classList.remove('drag-over');
            });
            
            grupoAgrupacion.addEventListener('drop', (e) => {
                e.preventDefault();
                grupoAgrupacion.classList.remove('drag-over');
                
                const columna = e.dataTransfer.getData('text/plain');
                
                if (columna && !columnasAgrupadas.includes(columna)) {
                    columnasAgrupadas.push(columna);
                    actualizarGrupoColumnas();
                }
            });
            
            // Event listener para remover columnas (usando delegación)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remover')) {
                    const columna = e.target.dataset.columna;
                    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                    actualizarGrupoColumnas();
                }
            });
        }
        
        // Event listener para expandir/colapsar grupos
        document.addEventListener('click', function(e) {
            const filaGrupo = e.target.closest('.fila-grupo');
            if (filaGrupo) {
                const grupoId = filaGrupo.dataset.grupoId;
                const icono = filaGrupo.querySelector('i');
                
                if (expandedGroups.has(grupoId)) {
                    expandedGroups.delete(grupoId);
                    filaGrupo.classList.remove('expandido');
                    if (icono) icono.className = 'fas fa-caret-right';
                } else {
                    expandedGroups.add(grupoId);
                    filaGrupo.classList.add('expandido');
                    if (icono) icono.className = 'fas fa-caret-down';
                }
                
                // Recargar tabla para mostrar/ocultar detalles
                cargarTabla(datosOriginales);
            }
        });
        
        // Cargar datos iniciales
        cargarTabla(datosCostosIndirectos);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregarCosto')?.addEventListener('click', function() {
            abrirModalAgregar();
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaCostosIndirectos', 'CostosIndirectos');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosCostosIndirectos.filter(item => 
                item.proyecto?.toLowerCase().includes(busqueda) ||
                item.categoria?.toLowerCase().includes(busqueda) ||
                item.concepto?.toLowerCase().includes(busqueda) ||
                item.proveedor?.toLowerCase().includes(busqueda) ||
                item.factura?.toLowerCase().includes(busqueda) ||
                item.estatus_pago?.toLowerCase().includes(busqueda)
            );
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Paginación
        document.querySelectorAll('.pagina-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.pagina);
                cargarTabla(datosOriginales);
            });
        });
        
        document.getElementById('btnAnterior')?.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnPrimera')?.addEventListener('click', function() {
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        document.getElementById('btnSiguiente')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                cargarTabla(datosOriginales);
            }
        });
        
        document.getElementById('btnUltima')?.addEventListener('click', function() {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            currentPage = totalPages;
            cargarTabla(datosOriginales);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
        
        // Modal Agregar Costo
        const modalAgregar = document.getElementById('modalAgregarCosto');
        const btnCerrarAgregar = document.getElementById('btnCerrarModalAgregar');
        const btnCancelarAgregar = document.getElementById('btnCancelarAgregar');
        
        function abrirModalAgregar() {
            // Limpiar formulario
            document.getElementById('formAgregarCosto').reset();
            document.getElementById('campoSubtotal').value = '0.00';
            document.getElementById('campoIva').value = '0.00';
            document.getElementById('campoTotal').value = '0.00';
            document.getElementById('campoFecha').value = '2026-03-01';
            document.getElementById('campoFechaPago').value = '2026-03-15';
            
            modalAgregar.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function cerrarModalAgregar() {
            modalAgregar.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarAgregar) {
            btnCerrarAgregar.addEventListener('click', cerrarModalAgregar);
        }
        
        if (btnCancelarAgregar) {
            btnCancelarAgregar.addEventListener('click', cerrarModalAgregar);
        }
        
        // Calcular total automáticamente
        document.getElementById('campoSubtotal')?.addEventListener('input', calcularTotal);
        document.getElementById('campoIva')?.addEventListener('input', calcularTotal);
        
        function calcularTotal() {
            const subtotal = parseFloat(document.getElementById('campoSubtotal').value) || 0;
            const iva = parseFloat(document.getElementById('campoIva').value) || 0;
            const total = subtotal + iva;
            document.getElementById('campoTotal').value = total.toFixed(2);
        }
        
        // Guardar nuevo costo
        document.getElementById('formAgregarCosto')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nuevoCosto = {
                proyecto: document.getElementById('campoProyecto').value,
                categoria: document.getElementById('campoCategoria').value,
                concepto: document.getElementById('campoConcepto').value,
                fecha: document.getElementById('campoFecha').value,
                proveedor: document.getElementById('campoProveedor').value || '-',
                rfc: document.getElementById('campoRFC').value || '-',
                factura: document.getElementById('campoFactura').value || '-',
                descripcion: document.getElementById('campoDescripcion').value || '-',
                subtotal: parseFloat(document.getElementById('campoSubtotal').value) || 0,
                iva: parseFloat(document.getElementById('campoIva').value) || 0,
                total: parseFloat(document.getElementById('campoTotal').value) || 0,
                forma_pago: document.getElementById('campoFormaPago').value,
                fecha_pago: document.getElementById('campoFechaPago').value,
                estatus_pago: document.getElementById('campoEstatusPago').value,
                observaciones: document.getElementById('campoObservaciones').value || '-'
            };
            
            datosCostosIndirectos.push(nuevoCosto);
            datosOriginales = [...datosCostosIndirectos];
            cargarTabla(datosOriginales);
            cerrarModalAgregar();
            
            alert('Costo indirecto agregado correctamente');
        });
        
        // Modal Editar Costo
        const modalEditar = document.getElementById('modalEditarCosto');
        const btnCerrarEditar = document.getElementById('btnCerrarModalEditar');
        const btnCancelarEditar = document.getElementById('btnCancelarEditar');
        
        window.editarCosto = function(item, event) {
            if (event) event.stopPropagation();
            
            // Llenar formulario con datos del item
            document.getElementById('editProyecto').value = item.proyecto;
            document.getElementById('editCategoria').value = item.categoria;
            document.getElementById('editConcepto').value = item.concepto;
            document.getElementById('editFecha').value = item.fecha;
            document.getElementById('editProveedor').value = item.proveedor;
            document.getElementById('editRFC').value = item.rfc;
            document.getElementById('editFactura').value = item.factura;
            document.getElementById('editDescripcion').value = item.descripcion;
            document.getElementById('editSubtotal').value = item.subtotal;
            document.getElementById('editIva').value = item.iva;
            document.getElementById('editTotal').value = item.total;
            document.getElementById('editFormaPago').value = item.forma_pago;
            document.getElementById('editFechaPago').value = item.fecha_pago;
            document.getElementById('editEstatusPago').value = item.estatus_pago;
            document.getElementById('editObservaciones').value = item.observaciones;
            
            // Guardar índice para actualizar
            const index = datosCostosIndirectos.findIndex(c => 
                c.proyecto === item.proyecto && 
                c.concepto === item.concepto && 
                c.factura === item.factura
            );
            document.getElementById('editIndex').value = index;
            
            modalEditar.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        function cerrarModalEditar() {
            modalEditar.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarEditar) {
            btnCerrarEditar.addEventListener('click', cerrarModalEditar);
        }
        
        if (btnCancelarEditar) {
            btnCancelarEditar.addEventListener('click', cerrarModalEditar);
        }
        
        // Calcular total en edición
        document.getElementById('editSubtotal')?.addEventListener('input', calcularTotalEditar);
        document.getElementById('editIva')?.addEventListener('input', calcularTotalEditar);
        
        function calcularTotalEditar() {
            const subtotal = parseFloat(document.getElementById('editSubtotal').value) || 0;
            const iva = parseFloat(document.getElementById('editIva').value) || 0;
            const total = subtotal + iva;
            document.getElementById('editTotal').value = total.toFixed(2);
        }
        
        // Actualizar costo
        document.getElementById('formEditarCosto')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const index = parseInt(document.getElementById('editIndex').value);
            if (index >= 0) {
                datosCostosIndirectos[index] = {
                    proyecto: document.getElementById('editProyecto').value,
                    categoria: document.getElementById('editCategoria').value,
                    concepto: document.getElementById('editConcepto').value,
                    fecha: document.getElementById('editFecha').value,
                    proveedor: document.getElementById('editProveedor').value || '-',
                    rfc: document.getElementById('editRFC').value || '-',
                    factura: document.getElementById('editFactura').value || '-',
                    descripcion: document.getElementById('editDescripcion').value || '-',
                    subtotal: parseFloat(document.getElementById('editSubtotal').value) || 0,
                    iva: parseFloat(document.getElementById('editIva').value) || 0,
                    total: parseFloat(document.getElementById('editTotal').value) || 0,
                    forma_pago: document.getElementById('editFormaPago').value,
                    fecha_pago: document.getElementById('editFechaPago').value,
                    estatus_pago: document.getElementById('editEstatusPago').value,
                    observaciones: document.getElementById('editObservaciones').value || '-'
                };
                
                datosOriginales = [...datosCostosIndirectos];
                cargarTabla(datosOriginales);
                cerrarModalEditar();
                
                alert('Costo indirecto actualizado correctamente');
            }
        });
        
        // Modal Ver Detalle
        const modalDetalle = document.getElementById('modalVerDetalle');
        const btnCerrarDetalle = document.getElementById('btnCerrarModalDetalle');
        
        window.verDetalleCosto = function(item, event) {
            if (event) event.stopPropagation();
            
            document.getElementById('modalTitulo').textContent = `${item.concepto} - ${item.proyecto}`;
            
            // Badge para estatus de pago
            let badgeClass = 'badge-pendiente';
            if (item.estatus_pago === 'Pagado') badgeClass = 'badge-pagado';
            else if (item.estatus_pago === 'Programado') badgeClass = 'badge-programado';
            else if (item.estatus_pago === 'Vencido') badgeClass = 'badge-vencido';
            
            const contenido = `
                <div style="margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.proyecto}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.categoria}</div>
                        </div>
                    </div>
                </div>
                
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 11px;">Subtotal</div>
                            <div style="font-size: 18px; font-weight: 700;">${formatCurrency(item.subtotal)}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 11px;">IVA</div>
                            <div style="font-size: 18px; font-weight: 700;">${formatCurrency(item.iva)}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 11px;">Total</div>
                            <div style="font-size: 24px; font-weight: 700; color: #28a745;">${formatCurrency(item.total)}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 11px;">Estatus</div>
                            <div><span class="badge ${badgeClass}">${item.estatus_pago}</span></div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                    <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                        ${item.descripcion}
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">Proveedor</div>
                        <div style="font-size: 14px;">${item.proveedor}</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">RFC</div>
                        <div style="font-size: 14px;">${item.rfc}</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">Factura</div>
                        <div style="font-size: 14px;">${item.factura}</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                        <div style="font-size: 14px;">${formatDate(item.fecha)}</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">Forma de Pago</div>
                        <div style="font-size: 14px;">${item.forma_pago}</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 12px;">Fecha de Pago</div>
                        <div style="font-size: 14px;">${formatDate(item.fecha_pago)}</div>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                    <div style="font-size: 14px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                        ${item.observaciones}
                    </div>
                </div>
                
                <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px;">
                    <div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">Documentos</div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <span style="background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-file-pdf" style="color: #dc3545;"></i> factura-${item.factura}.pdf
                        </span>
                        <span style="background-color: #e9ecef; padding: 8px 12px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-file-image" style="color: #28a745;"></i> comprobante-pago.jpg
                        </span>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContenidoDetalle').innerHTML = contenido;
            modalDetalle.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        if (btnCerrarDetalle) {
            btnCerrarDetalle.addEventListener('click', function() {
                modalDetalle.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === modalAgregar) cerrarModalAgregar();
            if (event.target === modalEditar) cerrarModalEditar();
            if (event.target === modalDetalle) {
                modalDetalle.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        window.eliminarCosto = function(event) {
            if (event) event.stopPropagation();
            if (confirm('¿Está seguro de eliminar este costo indirecto?')) {
                alert('Funcionalidad de eliminar en desarrollo');
            }
        };
    });
</script>
@endsection