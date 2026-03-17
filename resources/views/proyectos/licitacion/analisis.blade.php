@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Análisis de Precios Unitarios -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    
                    Análisis de Precios Unitarios
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE ANÁLISIS CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total APUs -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total APUs</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAPUs">245</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="activos">189</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Por Revisar -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Revisar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porRevisar">42</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Actualizados -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Actualizados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="actualizados">156</div>
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
                            <input type="date" id="fechaInicio" value="2026-01-01" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Date Fin -->
                        <div>
                            <input type="date" id="fechaFin" value="2026-12-31" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>

                        <!-- Botón Nuevo APU -->
                        <div>
                            <button id="btnNuevo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Nuevo APU">
                                <i class="fas fa-plus-circle"></i> Nuevo APU
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

                        <!-- Botón Comparar -->
                        <div>
                            <button id="btnComparar" 
                                    style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;"
                                    title="Comparar APUs">
                                <i class="fas fa-balance-scale"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Pestañas de categorías -->
                <div style="display: flex; gap: 2px; margin-bottom: 20px; border-bottom: 2px solid #083CAE; overflow-x: auto; white-space: nowrap;">
                    <button class="categoria-tab active" data-categoria="todos" style="padding: 12px 25px; background-color: #083CAE; color: white; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-list"></i> Todos
                        <span style="background-color: white; color: #083CAE; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">245</span>
                    </button>
                    <button class="categoria-tab" data-categoria="materiales" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-box"></i> Materiales
                        <span style="background-color: #2378e1; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">86</span>
                    </button>
                    <button class="categoria-tab" data-categoria="mano_obra" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Mano de Obra
                        <span style="background-color: #28a745; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">54</span>
                    </button>
                    <button class="categoria-tab" data-categoria="maquinaria" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tractor"></i> Maquinaria
                        <span style="background-color: #ffc107; color: #856404; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">42</span>
                    </button>
                    <button class="categoria-tab" data-categoria="subcontratos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-handshake"></i> Subcontratos
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">38</span>
                    </button>
                    <button class="categoria-tab" data-categoria="indirectos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-pie"></i> Indirectos
                        <span style="background-color: #6c757d; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;">25</span>
                    </button>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-calculator" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin análisis</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay precios unitarios para mostrar</p>
                </div>

                <!-- Tabla de Análisis de Precios Unitarios -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaAPUs" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="codigo">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Código</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="concepto">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Concepto</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Categoría</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Unidad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="materiales">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Materiales</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="mano_obra">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Mano de Obra</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="maquinaria">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Maquinaria</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subcontratos">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subcontratos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Precio Unitario</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estado">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estado</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="4">Promedios:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="promMateriales">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="promManoObra">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="promMaquinaria">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="promSubcontratos">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="promTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="2"></td>
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
                        <span style="margin-left: 10px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-10 de 245 registros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nuevo APU -->
<div id="modalNuevo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #083CAE;"><i class="fas fa-plus-circle"></i> Nuevo Análisis de Precio Unitario</h3>
            <button id="btnCerrarModal" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #6c757d;">&times;</button>
        </div>
        
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="modalCodigo" placeholder="Ej: MAT-001, MOB-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría <span style="color: #dc3545;">*</span></label>
                    <select id="modalCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar...</option>
                        <option value="materiales">Materiales</option>
                        <option value="mano_obra">Mano de Obra</option>
                        <option value="maquinaria">Maquinaria</option>
                        <option value="subcontratos">Subcontratos</option>
                        <option value="indirectos">Indirectos</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Concepto <span style="color: #dc3545;">*</span></label>
                <input type="text" id="modalConcepto" placeholder="Descripción del concepto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Unidad</label>
                    <input type="text" id="modalUnidad" placeholder="Ej: m³, kg, jor, hr" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estado</label>
                    <select id="modalEstado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="activo">Activo</option>
                        <option value="revision">En Revisión</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>

            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                <h4 style="margin: 0 0 15px 0; font-size: 14px; color: #083CAE;">Desglose de Costos</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Materiales</label>
                        <input type="text" id="modalMateriales" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mano de Obra</label>
                        <input type="text" id="modalManoObra" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Maquinaria</label>
                        <input type="text" id="modalMaquinaria" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Subcontratos</label>
                        <input type="text" id="modalSubcontratos" placeholder="$0.00" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                    </div>
                </div>
                
                <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; margin-top: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 600;">Total</span>
                        <span style="font-size: 18px; font-weight: 700; color: #083CAE;" id="modalTotal">$0.00</span>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                <textarea id="modalObservaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales..."></textarea>
            </div>
        </div>

        <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelar" style="padding: 10px 20px; background-color: white; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar APU</button>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 8px 8px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-calculator"></i> Detalle de Análisis
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <!-- Encabezado -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 12px; color: #6c757d;">Código</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="verCodigo">MAT-001</div>
                </div>
                <div>
                    <span style="background-color: #28a745; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;" id="verEstado">Activo</span>
                </div>
            </div>

            <!-- Información principal -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Concepto</div>
                <div style="font-size: 16px; font-weight: 600;" id="verConcepto">Concreto premezclado f'c=250 kg/cm²</div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                    <div style="font-size: 14px;" id="verCategoria">Materiales</div>
                </div>
                <div>
                    <div style="color: #6c757d; font-size: 12px;">Unidad</div>
                    <div style="font-size: 14px;" id="verUnidad">m³</div>
                </div>
            </div>

            <!-- Desglose de costos -->
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin: 0 0 15px 0; font-size: 14px; color: #083CAE;">Desglose de Costos</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Materiales</div>
                        <div style="font-size: 16px; font-weight: 600;" id="verMateriales">$0.00</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Mano de Obra</div>
                        <div style="font-size: 16px; font-weight: 600;" id="verManoObra">$0.00</div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Maquinaria</div>
                        <div style="font-size: 16px; font-weight: 600;" id="verMaquinaria">$0.00</div>
                    </div>
                    <div>
                        <div style="color: #6c757d; font-size: 11px;">Subcontratos</div>
                        <div style="font-size: 16px; font-weight: 600;" id="verSubcontratos">$0.00</div>
                    </div>
                </div>
                
                <div style="border-top: 1px solid #dee2e6; margin: 15px 0 10px;"></div>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 600;">Precio Unitario</span>
                    <span style="font-size: 24px; font-weight: 700; color: #083CAE;" id="verTotal">$2,450.00</span>
                </div>
            </div>

            <!-- Observaciones -->
            <div style="margin-bottom: 20px;">
                <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;" id="verObservaciones">
                    Incluye entrega en obra, bombeo y vibrado.
                </div>
            </div>

            <!-- Botones de acción -->
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="editarAPU()">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button style="padding: 8px 15px; background-color: #ffc107; color: #856404; border: none; border-radius: 4px; cursor: pointer;" onclick="duplicarAPU()">
                    <i class="fas fa-copy"></i> Duplicar
                </button>
                <button style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;" onclick="cerrarModalVer()">
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
    
    /* Badges para categorías */
    .badge-categoria {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-materiales {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-mano-obra {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-maquinaria {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-subcontratos {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-indirectos {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    /* Badges para estado */
    .badge-estado {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }
    
    .badge-activo {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-revision {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-inactivo {
        background-color: #f8d7da;
        color: #dc3545;
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
    
    /* Pestañas de categoría */
    .categoria-tab {
        transition: all 0.3s ease;
    }
    
    .categoria-tab:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }
    
    .categoria-tab.active {
        background-color: #083CAE !important;
        color: white !important;
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
        console.log('DOM completamente cargado - Análisis de Precios Unitarios');
        
        // Variables para agrupación
        let columnasAgrupadas = [];
        let expandedGroups = new Set();
        let datosOriginales = [];
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalRows = 0;
        let filtroCategoriaActual = 'todos';
        
        // Datos de ejemplo para Análisis de Precios Unitarios
        const datosAPUs = [
            {
                codigo: 'MAT-001',
                concepto: 'Concreto premezclado f\'c=250 kg/cm²',
                categoria: 'materiales',
                categoria_nombre: 'Materiales',
                unidad: 'm³',
                materiales: 2200,
                mano_obra: 150,
                maquinaria: 100,
                subcontratos: 0,
                total: 2450,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Incluye entrega en obra, bombeo y vibrado'
            },
            {
                codigo: 'MAT-002',
                concepto: 'Acero de refuerzo fy=4200 kg/cm²',
                categoria: 'materiales',
                categoria_nombre: 'Materiales',
                unidad: 'kg',
                materiales: 28,
                mano_obra: 4,
                maquinaria: 0,
                subcontratos: 0,
                total: 32,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Acero grado 42, incluye cortes y dobleces'
            },
            {
                codigo: 'MOB-001',
                concepto: 'Albañil (mano de obra)',
                categoria: 'mano_obra',
                categoria_nombre: 'Mano de Obra',
                unidad: 'jor',
                materiales: 0,
                mano_obra: 650,
                maquinaria: 0,
                subcontratos: 0,
                total: 650,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Jornal de 8 horas incluye prestaciones'
            },
            {
                codigo: 'MOB-002',
                concepto: 'Ayudante general',
                categoria: 'mano_obra',
                categoria_nombre: 'Mano de Obra',
                unidad: 'jor',
                materiales: 0,
                mano_obra: 450,
                maquinaria: 0,
                subcontratos: 0,
                total: 450,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Apoyo en labores generales'
            },
            {
                codigo: 'MAQ-001',
                concepto: 'Retroexcavadora',
                categoria: 'maquinaria',
                categoria_nombre: 'Maquinaria',
                unidad: 'hr',
                materiales: 0,
                mano_obra: 120,
                maquinaria: 830,
                subcontratos: 0,
                total: 950,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Operador incluido'
            },
            {
                codigo: 'MAQ-002',
                concepto: 'Camión de volteo 7m³',
                categoria: 'maquinaria',
                categoria_nombre: 'Maquinaria',
                unidad: 'viaje',
                materiales: 0,
                mano_obra: 80,
                maquinaria: 920,
                subcontratos: 0,
                total: 1000,
                estado: 'revision',
                estado_nombre: 'En Revisión',
                observaciones: 'Pendiente actualización de tarifas'
            },
            {
                codigo: 'SUB-001',
                concepto: 'Instalación eléctrica',
                categoria: 'subcontratos',
                categoria_nombre: 'Subcontratos',
                unidad: 'm²',
                materiales: 0,
                mano_obra: 0,
                maquinaria: 0,
                subcontratos: 850,
                total: 850,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Incluye materiales y mano de obra'
            },
            {
                codigo: 'SUB-002',
                concepto: 'Impermeabilización',
                categoria: 'subcontratos',
                categoria_nombre: 'Subcontratos',
                unidad: 'm²',
                materiales: 0,
                mano_obra: 0,
                maquinaria: 0,
                subcontratos: 120,
                total: 120,
                estado: 'inactivo',
                estado_nombre: 'Inactivo',
                observaciones: 'Proveedor temporalmente no disponible'
            },
            {
                codigo: 'IND-001',
                concepto: 'Gastos administrativos',
                categoria: 'indirectos',
                categoria_nombre: 'Indirectos',
                unidad: '%',
                materiales: 0,
                mano_obra: 0,
                maquinaria: 0,
                subcontratos: 0,
                total: 50,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Porcentaje sobre costo directo'
            },
            {
                codigo: 'IND-002',
                concepto: 'Utilidad',
                categoria: 'indirectos',
                categoria_nombre: 'Indirectos',
                unidad: '%',
                materiales: 0,
                mano_obra: 0,
                maquinaria: 0,
                subcontratos: 0,
                total: 75,
                estado: 'activo',
                estado_nombre: 'Activo',
                observaciones: 'Margen de utilidad esperado'
            }
        ];
        
        datosOriginales = [...datosAPUs];
        totalRows = datosOriginales.length;
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para obtener clase de badge según categoría
        function getCategoriaBadgeClass(categoria) {
            switch(categoria) {
                case 'materiales': return 'badge-materiales';
                case 'mano_obra': return 'badge-mano-obra';
                case 'maquinaria': return 'badge-maquinaria';
                case 'subcontratos': return 'badge-subcontratos';
                case 'indirectos': return 'badge-indirectos';
                default: return 'badge-categoria';
            }
        }
        
        // Función para obtener clase de badge según estado
        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'activo': return 'badge-activo';
                case 'revision': return 'badge-revision';
                case 'inactivo': return 'badge-inactivo';
                default: return 'badge-activo';
            }
        }
        
        // Función para actualizar contadores de los cuadros
        function actualizarContadores(datos) {
            const total = datos.length;
            const activos = datos.filter(d => d.estado === 'activo').length;
            const porRevisar = datos.filter(d => d.estado === 'revision').length;
            const actualizados = datos.filter(d => d.estado === 'activo' || d.estado === 'revision').length;
            
            document.getElementById('totalAPUs').textContent = total;
            document.getElementById('activos').textContent = activos;
            document.getElementById('porRevisar').textContent = porRevisar;
            document.getElementById('actualizados').textContent = actualizados;
            
            // Calcular promedios
            let sumMateriales = 0, sumManoObra = 0, sumMaquinaria = 0, sumSubcontratos = 0, sumTotal = 0;
            datos.forEach(d => {
                sumMateriales += d.materiales;
                sumManoObra += d.mano_obra;
                sumMaquinaria += d.maquinaria;
                sumSubcontratos += d.subcontratos;
                sumTotal += d.total;
            });
            
            const count = datos.length;
            document.getElementById('promMateriales').textContent = formatCurrency(sumMateriales / count);
            document.getElementById('promManoObra').textContent = formatCurrency(sumManoObra / count);
            document.getElementById('promMaquinaria').textContent = formatCurrency(sumMaquinaria / count);
            document.getElementById('promSubcontratos').textContent = formatCurrency(sumSubcontratos / count);
            document.getElementById('promTotal').textContent = formatCurrency(sumTotal / count);
        }
        
        // Función para generar un ID único para el grupo
        function generarGrupoId(item, columnas) {
            return columnas.map(col => {
                switch(col) {
                    case 'categoria': return item.categoria_nombre || 'Sin categoría';
                    case 'estado': return item.estado_nombre || 'Sin estado';
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
                            case 'categoria': return item.categoria_nombre || 'Sin categoría';
                            case 'estado': return item.estado_nombre || 'Sin estado';
                            default: return '';
                        }
                    }).join(' - ');
                    
                    gruposMap.set(grupoId, {
                        id: grupoId,
                        valor: valorGrupo,
                        items: [item],
                        totalMateriales: item.materiales,
                        totalManoObra: item.mano_obra,
                        totalMaquinaria: item.maquinaria,
                        totalSubcontratos: item.subcontratos,
                        totalGeneral: item.total
                    });
                } else {
                    const grupo = gruposMap.get(grupoId);
                    grupo.items.push(item);
                    grupo.totalMateriales += item.materiales;
                    grupo.totalManoObra += item.mano_obra;
                    grupo.totalMaquinaria += item.maquinaria;
                    grupo.totalSubcontratos += item.subcontratos;
                    grupo.totalGeneral += item.total;
                }
            });
            
            return {
                grupos: Array.from(gruposMap.values()),
                items: []
            };
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
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;" colspan="11">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                    <strong style="color: #2378e1;">${grupo.valor}</strong>
                                    <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                        (${grupo.items.length} registros - Promedio: ${formatCurrency(grupo.totalGeneral / grupo.items.length)})
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
                            
                            let categoriaBadge = getCategoriaBadgeClass(item.categoria);
                            let estadoBadge = getEstadoBadgeClass(item.estado);
                            
                            detalleRow.innerHTML = `
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000; padding-left: 30px;">${item.codigo || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.unidad || '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.materiales ? formatCurrency(item.materiales) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.mano_obra ? formatCurrency(item.mano_obra) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.maquinaria ? formatCurrency(item.maquinaria) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subcontratos ? formatCurrency(item.subcontratos) : '-'}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000; font-weight: 600;">${formatCurrency(item.total)}</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-estado ${estadoBadge}">${item.estado_nombre}</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.codigo}')"></i>
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAPU('${item.codigo}')"></i>
                                        <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarAPU('${item.codigo}')"></i>
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
                    
                    let categoriaBadge = getCategoriaBadgeClass(item.categoria);
                    let estadoBadge = getEstadoBadgeClass(item.estado);
                    
                    row.innerHTML = `
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.codigo || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.concepto || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; color: #000000;">${item.unidad || '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.materiales ? formatCurrency(item.materiales) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.mano_obra ? formatCurrency(item.mano_obra) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.maquinaria ? formatCurrency(item.maquinaria) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${item.subcontratos ? formatCurrency(item.subcontratos) : '-'}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000; font-weight: 600;">${formatCurrency(item.total)}</td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-estado ${estadoBadge}">${item.estado_nombre}</span></td>
                        <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle('${item.codigo}')"></i>
                                <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAPU('${item.codigo}')"></i>
                                <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarAPU('${item.codigo}')"></i>
                            </div>
                        </td>
                    `;
                    
                    tablaBody.appendChild(row);
                });
                
                // Mostrar pie de tabla con promedios
                if (tablaFoot) tablaFoot.style.display = 'table-footer-group';
                
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
                        'categoria': 'Categoría',
                        'estado': 'Estado'
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
            
            if (grupoAgrupacion) {
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
            }
            
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
        cargarTabla(datosAPUs);
        
        // Configurar drag and drop
        setupDragAndDrop();
        
        // Elementos del DOM para botones
        const categoriaTabs = document.querySelectorAll('.categoria-tab');
        const btnNuevo = document.getElementById('btnNuevo');
        const btnExcel = document.getElementById('btnExcel');
        const btnComparar = document.getElementById('btnComparar');
        const btnCrearFiltro = document.getElementById('btnCrearFiltro');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const buscador = document.getElementById('buscador');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        
        // Elementos del modal de nuevo
        const modalNuevo = document.getElementById('modalNuevo');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnCancelar = document.getElementById('btnCancelar');
        const btnGuardar = document.getElementById('btnGuardar');
        
        // Elementos del modal de ver detalle
        const modalVer = document.getElementById('modalVerDetalle');
        const btnCerrarVerModal = document.getElementById('btnCerrarVerModal');
        
        // Pestañas de categoría
        categoriaTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                categoriaTabs.forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                filtroCategoriaActual = this.dataset.categoria;
                
                let datosFiltrados = datosAPUs;
                if (filtroCategoriaActual !== 'todos') {
                    datosFiltrados = datosAPUs.filter(item => item.categoria === filtroCategoriaActual);
                }
                
                datosOriginales = datosFiltrados;
                currentPage = 1;
                cargarTabla(datosOriginales);
            });
        });
        
        // Event Listeners
        if (buscador) {
            buscador.addEventListener('input', function(e) {
                const busqueda = e.target.value.toLowerCase();
                let datosBase = datosAPUs;
                
                if (filtroCategoriaActual !== 'todos') {
                    datosBase = datosAPUs.filter(item => item.categoria === filtroCategoriaActual);
                }
                
                const datosFiltrados = datosBase.filter(item => 
                    item.codigo?.toLowerCase().includes(busqueda) ||
                    item.concepto?.toLowerCase().includes(busqueda) ||
                    item.categoria_nombre?.toLowerCase().includes(busqueda) ||
                    item.estado_nombre?.toLowerCase().includes(busqueda)
                );
                
                datosOriginales = datosFiltrados;
                currentPage = 1;
                cargarTabla(datosOriginales);
            });
        }
        
        if (fechaInicio) {
            fechaInicio.addEventListener('change', function() {
                console.log('Fecha inicio:', this.value);
            });
        }
        
        if (fechaFin) {
            fechaFin.addEventListener('change', function() {
                console.log('Fecha fin:', this.value);
            });
        }
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTabla(datosOriginales);
            }
        }
        
        if (btnPrimera) {
            btnPrimera.addEventListener('click', () => {
                if (datosOriginales.length > 0) {
                    currentPage = 1;
                    cargarTabla(datosOriginales);
                }
            });
        }
        
        if (btnAnterior) {
            btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        }
        
        if (btnSiguiente) {
            btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        }
        
        if (btnUltima) {
            btnUltima.addEventListener('click', () => {
                if (datosOriginales.length > 0) {
                    currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                    cargarTabla(datosOriginales);
                }
            });
        }
        
        // Botones de acción
        if (btnNuevo) {
            btnNuevo.addEventListener('click', () => {
                modalNuevo.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (btnExcel) {
            btnExcel.addEventListener('click', () => {
                exportTableToExcel('tablaAPUs', 'Analisis_Precios_Unitarios');
            });
        }
        
        if (btnComparar) {
            btnComparar.addEventListener('click', () => {
                alert('Comparar análisis - Funcionalidad en desarrollo');
            });
        }
        
        if (btnCrearFiltro) {
            btnCrearFiltro.addEventListener('click', () => {
                alert('Crear filtro - Funcionalidad en desarrollo');
            });
        }
        
        // Modal de nuevo
        function cerrarModalNuevo() {
            modalNuevo.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        if (btnCerrarModal) {
            btnCerrarModal.addEventListener('click', cerrarModalNuevo);
        }
        
        if (btnCancelar) {
            btnCancelar.addEventListener('click', cerrarModalNuevo);
        }
        
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => {
                const codigo = document.getElementById('modalCodigo')?.value;
                const concepto = document.getElementById('modalConcepto')?.value;
                const categoria = document.getElementById('modalCategoria')?.value;
                
                if (!codigo || !concepto || !categoria) {
                    alert('Por favor complete los campos requeridos');
                    return;
                }
                
                alert('Análisis guardado correctamente');
                cerrarModalNuevo();
            });
        }
        
        // Cálculo automático de total en modal
        function calcularTotalModal() {
            const materiales = parseFloat(document.getElementById('modalMateriales')?.value.replace(/[^0-9.-]+/g, '')) || 0;
            const manoObra = parseFloat(document.getElementById('modalManoObra')?.value.replace(/[^0-9.-]+/g, '')) || 0;
            const maquinaria = parseFloat(document.getElementById('modalMaquinaria')?.value.replace(/[^0-9.-]+/g, '')) || 0;
            const subcontratos = parseFloat(document.getElementById('modalSubcontratos')?.value.replace(/[^0-9.-]+/g, '')) || 0;
            
            const total = materiales + manoObra + maquinaria + subcontratos;
            document.getElementById('modalTotal').textContent = formatCurrency(total);
        }
        
        ['modalMateriales', 'modalManoObra', 'modalMaquinaria', 'modalSubcontratos'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', calcularTotalModal);
        });
        
        // Funciones para acciones
        window.verDetalle = function(codigo) {
            const apu = datosAPUs.find(a => a.codigo === codigo);
            if (apu) {
                document.getElementById('modalVerTitulo').innerHTML = `<i class="fas fa-calculator"></i> Detalle de Análisis`;
                document.getElementById('verCodigo').textContent = apu.codigo;
                document.getElementById('verConcepto').textContent = apu.concepto;
                document.getElementById('verCategoria').textContent = apu.categoria_nombre;
                document.getElementById('verUnidad').textContent = apu.unidad;
                document.getElementById('verMateriales').textContent = formatCurrency(apu.materiales);
                document.getElementById('verManoObra').textContent = formatCurrency(apu.mano_obra);
                document.getElementById('verMaquinaria').textContent = formatCurrency(apu.maquinaria);
                document.getElementById('verSubcontratos').textContent = formatCurrency(apu.subcontratos);
                document.getElementById('verTotal').textContent = formatCurrency(apu.total);
                document.getElementById('verObservaciones').textContent = apu.observaciones;
                
                const estadoSpan = document.getElementById('verEstado');
                estadoSpan.textContent = apu.estado_nombre;
                estadoSpan.className = '';
                estadoSpan.classList.add(getEstadoBadgeClass(apu.estado));
            }
            
            modalVer.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };
        
        window.editarAPU = function(codigo) {
            alert('Editar análisis ' + codigo + ' - Funcionalidad en desarrollo');
        };
        
        window.duplicarAPU = function(codigo) {
            alert('Duplicar análisis ' + codigo + ' - Funcionalidad en desarrollo');
        };
        
        function cerrarModalVer() {
            modalVer.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        window.cerrarModalVer = cerrarModalVer;
        
        if (btnCerrarVerModal) {
            btnCerrarVerModal.addEventListener('click', cerrarModalVer);
        }
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === modalNuevo) {
                cerrarModalNuevo();
            }
            if (event.target === modalVer) {
                cerrarModalVer();
            }
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
    });
</script>
@endsection