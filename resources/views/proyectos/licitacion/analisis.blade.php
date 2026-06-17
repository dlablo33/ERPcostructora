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
                <!-- 4 CUADROS DE ANÁLISIS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total APUs</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAPUs">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="activos">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Revisar</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porRevisar">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Actualizados</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="actualizados">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar" id="iconoAgrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 30px;"></div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <button id="btnNuevo" style="background-color: #083CAE; color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px;" title="Nuevo APU">
                                <i class="fas fa-plus-circle"></i> Nuevo APU
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnComparar" style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;" title="Comparar APUs">
                                <i class="fas fa-balance-scale"></i>
                                Comparar
                            </button>
                        </div>
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
                        <span style="background-color: white; color: #083CAE; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-todos">0</span>
                    </button>
                    <button class="categoria-tab" data-categoria="materiales" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-box"></i> Materiales
                        <span style="background-color: #2378e1; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-materiales">0</span>
                    </button>
                    <button class="categoria-tab" data-categoria="mano_obra" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-users"></i> Mano de Obra
                        <span style="background-color: #28a745; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-mano_obra">0</span>
                    </button>
                    <button class="categoria-tab" data-categoria="maquinaria" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-tractor"></i> Maquinaria
                        <span style="background-color: #ffc107; color: #856404; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-maquinaria">0</span>
                    </button>
                    <button class="categoria-tab" data-categoria="subcontratos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-handshake"></i> Subcontratos
                        <span style="background-color: #dc3545; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-subcontratos">0</span>
                    </button>
                    <button class="categoria-tab" data-categoria="indirectos" style="padding: 12px 25px; background-color: #e9ecef; color: #495057; border: none; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-chart-pie"></i> Indirectos
                        <span style="background-color: #6c757d; color: white; border-radius: 10px; padding: 2px 8px; margin-left: 5px; font-size: 11px;" id="count-indirectos">0</span>
                    </button>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando análisis...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
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
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="codigo">Código</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="concepto">Concepto</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">Categoría</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="materiales">Materiales</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="mano_obra">Mano de Obra</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="maquinaria">Maquinaria</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subcontratos">Subcontratos</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">Precio Unitario</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estado">Estado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
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
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px;">
                    <div style="visibility: hidden;"></div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button id="btnPrimera" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-left"></i></button>
                        <button id="btnAnterior" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-left"></i></button>
                        <span id="paginaActual" style="padding: 5px 12px; background-color: #2378e1; color: white; border-radius: 4px;">1</span>
                        <span id="totalPaginas" style="margin-left: 5px; color: #6c757d;">de 1</span>
                        <button id="btnSiguiente" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-right"></i></button>
                        <button id="btnUltima" style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1;"><i class="fas fa-angle-double-right"></i></button>
                        <span id="paginacionInfo" style="margin-left: 10px; color: #2378e1;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Nuevo APU -->
<div id="modalNuevo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-plus-circle"></i> Nuevo Análisis de Precio Unitario</h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <form id="formAPU">
            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Código <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="modalCodigo" name="codigo" placeholder="Ej: MAT-001, MOB-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Categoría <span style="color: #dc3545;">*</span></label>
                        <select id="modalCategoria" name="categoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
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
                    <input type="text" id="modalConcepto" name="concepto" placeholder="Descripción del concepto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Unidad <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="modalUnidad" name="unidad" placeholder="Ej: m³, kg, jor, hr, m², %" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Estado</label>
                        <select id="modalEstado" name="estado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
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
                            <input type="number" id="modalMateriales" name="costo_materiales" placeholder="0.00" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mano de Obra</label>
                            <input type="number" id="modalManoObra" name="costo_mano_obra" placeholder="0.00" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Maquinaria</label>
                            <input type="number" id="modalMaquinaria" name="costo_maquinaria" placeholder="0.00" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Subcontratos</label>
                            <input type="number" id="modalSubcontratos" name="costo_subcontratos" placeholder="0.00" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
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
                    <textarea id="modalObservaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales..."></textarea>
                </div>
            </div>

            <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelar" style="padding: 10px 20px; background-color: #f8f9fa; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar APU</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-calculator"></i> Detalle de Análisis
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;" id="detalleContent">
            <!-- Contenido cargado dinámicamente -->
        </div>
    </div>
</div>

<style>
    .semaforo .card-header { background-color: #f4f6f9; border-bottom: 2px solid #083CAE; }
    .semaforo .card-header h2 { color: #083CAE !important; }
    .custom-card { transition: transform 0.2s, box-shadow 0.2s; height: 100%; }
    .custom-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important; border-color: #083CAE !important; }
    .table th { white-space: nowrap; font-size: 12px; background-color: #2378e1 !important; color: white; font-weight: 600; padding: 10px 4px; }
    .table td { white-space: nowrap; font-size: 12px; padding: 10px 4px; color: #000000 !important; }
    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover { background-color: #e0e0e0; }
    
    .badge-estado { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; font-weight: 600; }
    .badge-activo { background-color: #d4edda; color: #28a745; }
    .badge-revision { background-color: #fff3cd; color: #ffc107; }
    .badge-inactivo { background-color: #f8d7da; color: #dc3545; }
    
    .badge-categoria { font-size: 11px; padding: 4px 8px; border-radius: 4px; display: inline-block; font-weight: 600; }
    .badge-materiales { background-color: #cce5ff; color: #0d6efd; }
    .badge-mano-obra { background-color: #d4edda; color: #28a745; }
    .badge-maquinaria { background-color: #fff3cd; color: #856404; }
    .badge-subcontratos { background-color: #f8d7da; color: #dc3545; }
    .badge-indirectos { background-color: #e2e3e5; color: #6c757d; }
    
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    
    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    .categoria-tab { transition: all 0.3s ease; }
    .categoria-tab:hover { opacity: 0.9; transform: translateY(-2px); }
    .categoria-tab.active { background-color: #083CAE !important; color: white !important; }
    
    /* Estilos para agrupación de columnas */
    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
    .columna-agrupada { display: inline-flex; align-items: center; padding: 4px 10px; background-color: #f0f4ff; border-radius: 16px; color: #2378e1; font-size: 12px; margin: 2px; border: 1px solid #2378e1; }
    .columna-agrupada .remover { margin-left: 6px; cursor: pointer; font-size: 14px; font-weight: bold; color: #2378e1; }
    .columna-agrupada .remover:hover { opacity: 0.7; }
    
    .fila-grupo { background-color: #f0f7ff !important; font-weight: 500; cursor: pointer; }
    .fila-grupo:hover { background-color: #e1f0ff !important; }
    .fila-grupo td:first-child i { transition: transform 0.2s; margin-right: 8px; }
    .fila-grupo:not(.expandido) td:first-child i { transform: rotate(-90deg); }
    .fila-detalle { background-color: #ffffff; }
    .fila-detalle td { border-top: none !important; }
    .fila-detalle td:first-child { padding-left: 30px !important; }
    
    .drag-over #grupoColumnas { background-color: rgba(35, 120, 225, 0.1); border-radius: 4px; }
    
    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalNuevo > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/apu';
    let currentPage = 1;
    let totalPages = 1;
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let filtroCategoriaActual = 'todos';
    
    let currentFilters = {
        busqueda: '',
        categoria: 'todos',
        estado: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarAPUs() {
        mostrarLoading(true);
        
        try {
            const params = new URLSearchParams(currentFilters);
            const url = `${API_BASE}?${params.toString()}`;
            console.log('Cargando desde:', url);
            
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText.substring(0, 200)}`);
            }
            
            const result = await response.json();
            console.log('Resultado:', result);
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                actualizarConteosCategorias(result.conteos_categorias);
                renderizarTabla(data, result.promedios);
                actualizarPaginacion(pagination);
                
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los análisis: ' + error.message, 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    // ============================================
    // RENDERIZADO
    // ============================================

    function renderizarTabla(apus, promedios) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const textoAgrupar = document.getElementById('textoAgrupar');
        
        if (!tbody) return;
        
        // Actualizar promedios en el footer
        if (promedios) {
            document.getElementById('promMateriales').textContent = formatCurrency(promedios.materiales || 0);
            document.getElementById('promManoObra').textContent = formatCurrency(promedios.mano_obra || 0);
            document.getElementById('promMaquinaria').textContent = formatCurrency(promedios.maquinaria || 0);
            document.getElementById('promSubcontratos').textContent = formatCurrency(promedios.subcontratos || 0);
            document.getElementById('promTotal').textContent = formatCurrency(promedios.total || 0);
        }
        
        // Ocultar texto de agrupar si hay columnas agrupadas
        if (textoAgrupar) {
            textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
        }
        
        // Aplicar agrupación si hay columnas seleccionadas
        const { grupos } = agruparDatos(apus, columnasAgrupadas);
        const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
        
        tbody.innerHTML = '';
        
        if (!apus || apus.length === 0) {
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        
        if (hayGrupos) {
            document.getElementById('tablaFoot').style.display = 'none';
            
            grupos.forEach(grupo => {
                const grupoRow = document.createElement('tr');
                grupoRow.className = 'fila-grupo';
                grupoRow.dataset.grupoId = grupo.id;
                
                if (expandedGroups.has(grupo.id)) {
                    grupoRow.classList.add('expandido');
                }
                
                grupoRow.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;" colspan="11">
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
                tbody.appendChild(grupoRow);
                
                if (expandedGroups.has(grupo.id)) {
                    grupo.items.forEach(item => {
                        tbody.appendChild(crearFilaDetalle(item));
                    });
                }
            });
        } else {
            document.getElementById('tablaFoot').style.display = 'table-footer-group';
            
            // Paginación
            const start = (currentPage - 1) * currentFilters.per_page;
            const end = start + currentFilters.per_page;
            const pageData = apus.slice(start, end);
            
            pageData.forEach(item => {
                tbody.appendChild(crearFila(item));
            });
        }
    }

    function crearFila(item) {
        const row = document.createElement('tr');
        const categoriaBadge = getCategoriaBadgeClass(item.categoria);
        const estadoBadge = getEstadoBadgeClass(item.estado);
        
        row.innerHTML = `
            <td style="padding: 10px 4px;">${item.codigo || '-'}</td>
            <td style="padding: 10px 4px;">${item.concepto || '-'}</td>
            <td style="padding: 10px 4px;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
            <td style="padding: 10px 4px; text-align: center;">${item.unidad || '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_materiales)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_mano_obra)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_maquinaria)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_subcontratos)}</td>
            <td style="padding: 10px 4px; text-align: right; font-weight: 600; color: #083CAE;">${formatCurrency(item.costo_total)}</td>
            <td style="padding: 10px 4px;"><span class="badge-estado ${estadoBadge}">${item.estado_nombre}</span></td>
            <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAPU(${item.id})"></i>
                    <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarAPU(${item.id})"></i>
                </div>
            </td>
        `;
        return row;
    }

    function crearFilaDetalle(item) {
        const row = document.createElement('tr');
        row.className = 'fila-detalle';
        const categoriaBadge = getCategoriaBadgeClass(item.categoria);
        const estadoBadge = getEstadoBadgeClass(item.estado);
        
        row.innerHTML = `
            <td style="padding: 10px 4px; padding-left: 30px;">${item.codigo || '-'}</td>
            <td style="padding: 10px 4px;">${item.concepto || '-'}</td>
            <td style="padding: 10px 4px;"><span class="badge-categoria ${categoriaBadge}">${item.categoria_nombre}</span></td>
            <td style="padding: 10px 4px; text-align: center;">${item.unidad || '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_materiales)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_mano_obra)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_maquinaria)}</td>
            <td style="padding: 10px 4px; text-align: right;">${formatCurrency(item.costo_subcontratos)}</td>
            <td style="padding: 10px 4px; text-align: right; font-weight: 600; color: #083CAE;">${formatCurrency(item.costo_total)}</td>
            <td style="padding: 10px 4px;"><span class="badge-estado ${estadoBadge}">${item.estado_nombre}</span></td>
            <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarAPU(${item.id})"></i>
                    <i class="fas fa-copy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Duplicar" onclick="duplicarAPU(${item.id})"></i>
                </div>
            </td>
        `;
        return row;
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalAPUs').textContent = stats.total || 0;
        document.getElementById('activos').textContent = stats.activos || 0;
        document.getElementById('porRevisar').textContent = stats.revision || 0;
        document.getElementById('actualizados').textContent = (stats.activos || 0) + (stats.revision || 0);
    }

    function actualizarConteosCategorias(conteos) {
        if (!conteos) return;
        document.getElementById('count-todos').textContent = conteos.todos || 0;
        document.getElementById('count-materiales').textContent = conteos.materiales || 0;
        document.getElementById('count-mano_obra').textContent = conteos.mano_obra || 0;
        document.getElementById('count-maquinaria').textContent = conteos.maquinaria || 0;
        document.getElementById('count-subcontratos').textContent = conteos.subcontratos || 0;
        document.getElementById('count-indirectos').textContent = conteos.indirectos || 0;
    }

    function actualizarPaginacion(pagination) {
        if (!pagination) return;
        document.getElementById('paginaActual').textContent = pagination.current_page || 1;
        document.getElementById('totalPaginas').textContent = `de ${pagination.last_page || 1}`;
        document.getElementById('paginacionInfo').textContent = 
            `Mostrando ${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    }

    // ============================================
    // FUNCIONES AUXILIARES
    // ============================================

    function formatCurrency(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function getCategoriaBadgeClass(categoria) {
        const badges = {
            'materiales': 'badge-materiales',
            'mano_obra': 'badge-mano-obra',
            'maquinaria': 'badge-maquinaria',
            'subcontratos': 'badge-subcontratos',
            'indirectos': 'badge-indirectos'
        };
        return badges[categoria] || 'badge-categoria';
    }

    function getEstadoBadgeClass(estado) {
        const badges = {
            'activo': 'badge-activo',
            'revision': 'badge-revision',
            'inactivo': 'badge-inactivo'
        };
        return badges[estado] || 'badge-estado';
    }

    function mostrarLoading(show) {
        document.getElementById('loadingSpinner').style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        notificacion.innerHTML = `<i class="fas ${tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // AGRUPACIÓN
    // ============================================

    function generarGrupoId(item, columnas) {
        return columnas.map(col => {
            switch(col) {
                case 'categoria': return item.categoria_nombre || 'Sin categoría';
                case 'estado': return item.estado_nombre || 'Sin estado';
                default: return '';
            }
        }).join('||');
    }

    function agruparDatos(datos, columnas) {
        if (columnas.length === 0 || !datos) return { grupos: [], items: datos || [] };
        
        const gruposMap = new Map();
        
        datos.forEach(item => {
            const grupoId = generarGrupoId(item, columnas);
            
            if (!gruposMap.has(grupoId)) {
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
                    totalGeneral: item.costo_total || 0
                });
            } else {
                const grupo = gruposMap.get(grupoId);
                grupo.items.push(item);
                grupo.totalGeneral += item.costo_total || 0;
            }
        });
        
        return {
            grupos: Array.from(gruposMap.values()),
            items: []
        };
    }

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
                chip.innerHTML = `${nombreColumna} <span class="remover" data-columna="${col}">&times;</span>`;
                grupoContainer.appendChild(chip);
            });
        }
        
        expandedGroups.clear();
        cargarAPUs();
    }

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
        
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remover')) {
                const columna = e.target.dataset.columna;
                columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
                actualizarGrupoColumnas();
            }
        });
    }

    // ============================================
    // ACCIONES
    // ============================================

    window.verDetalle = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const l = result.data;
                const content = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <div style="font-size: 12px; color: #6c757d;">Código</div>
                            <div style="font-size: 20px; font-weight: 700; color: #083CAE;">${l.codigo}</div>
                        </div>
                        <div>
                            <span class="badge-estado ${getEstadoBadgeClass(l.estado)}" style="font-size: 14px; padding: 6px 15px;">${l.estado_nombre}</span>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Concepto</div>
                        <div style="font-size: 16px; font-weight: 600;">${l.concepto || '-'}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                            <div style="font-size: 14px;"><span class="badge-categoria ${getCategoriaBadgeClass(l.categoria)}">${l.categoria_nombre}</span></div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Unidad</div>
                            <div style="font-size: 14px;">${l.unidad || '-'}</div>
                        </div>
                    </div>
                    
                    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 15px 0; font-size: 14px; color: #083CAE;">Desglose de Costos</h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Materiales</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(l.costo_materiales)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Mano de Obra</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(l.costo_mano_obra)}</div>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px;">
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Maquinaria</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(l.costo_maquinaria)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Subcontratos</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(l.costo_subcontratos)}</div>
                            </div>
                        </div>
                        
                        <div style="border-top: 1px solid #dee2e6; margin: 15px 0 10px;"></div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600;">Precio Unitario</span>
                            <span style="font-size: 24px; font-weight: 700; color: #083CAE;">${formatCurrency(l.costo_total)}</span>
                        </div>
                    </div>
                    
                    ${l.observaciones ? `
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;">${l.observaciones}</div>
                    </div>` : ''}
                    
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalVer()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                document.getElementById('detalleContent').innerHTML = content;
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.editarAPU = function(id) {
        mostrarNotificacion('Funcionalidad en desarrollo: Editar APU', 'warning');
    };

    window.duplicarAPU = async function(id) {
        if (!confirm('¿Desea duplicar este análisis?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/${id}/duplicar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarAPUs();
            } else {
                mostrarNotificacion(result.message || 'Error al duplicar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al duplicar el análisis', 'error');
        }
    };

    function cerrarModalVer() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    async function exportarExcel() {
        try {
            const params = new URLSearchParams(currentFilters);
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = result.data.headers || [];
                const rows = result.data.rows || [];
                
                if (headers.length === 0 || rows.length === 0) {
                    mostrarNotificacion('No hay datos para exportar', 'warning');
                    return;
                }
                
                const csvContent = [headers.join(','), ...rows.map(row => row.join(','))].join('\n');
                const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `APUs_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // FORMULARIO - CREAR APU
    // ============================================

    function calcularTotalModal() {
        const materiales = parseFloat(document.getElementById('modalMateriales')?.value) || 0;
        const manoObra = parseFloat(document.getElementById('modalManoObra')?.value) || 0;
        const maquinaria = parseFloat(document.getElementById('modalMaquinaria')?.value) || 0;
        const subcontratos = parseFloat(document.getElementById('modalSubcontratos')?.value) || 0;
        
        const total = materiales + manoObra + maquinaria + subcontratos;
        document.getElementById('modalTotal').textContent = formatCurrency(total);
    }

    async function guardarAPU(event) {
        event.preventDefault();
        
        const formData = new FormData();
        formData.append('codigo', document.getElementById('modalCodigo').value);
        formData.append('concepto', document.getElementById('modalConcepto').value);
        formData.append('categoria', document.getElementById('modalCategoria').value);
        formData.append('unidad', document.getElementById('modalUnidad').value);
        formData.append('costo_materiales', document.getElementById('modalMateriales').value || 0);
        formData.append('costo_mano_obra', document.getElementById('modalManoObra').value || 0);
        formData.append('costo_maquinaria', document.getElementById('modalMaquinaria').value || 0);
        formData.append('costo_subcontratos', document.getElementById('modalSubcontratos').value || 0);
        formData.append('estado', document.getElementById('modalEstado').value || 'activo');
        formData.append('observaciones', document.getElementById('modalObservaciones').value || '');
        
        try {
            const response = await fetch(API_BASE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cerrarModalNuevo();
                cargarAPUs();
            } else {
                mostrarNotificacion(result.message || 'Error al guardar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al guardar el análisis', 'error');
        }
    }

    function abrirModalNuevo() {
        document.getElementById('modalNuevo').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('formAPU').reset();
        document.getElementById('modalTotal').textContent = '$0.00';
        
        // Generar código sugerido
        const fecha = new Date();
        const año = fecha.getFullYear();
        const count = document.getElementById('totalAPUs').textContent || '0';
        const nuevoCodigo = `APU-${año}-${String(parseInt(count) + 1).padStart(4, '0')}`;
        document.getElementById('modalCodio').value = nuevoCodigo;
    }

    function cerrarModalNuevo() {
        document.getElementById('modalNuevo').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formAPU').reset();
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    function inicializarEventos() {
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarAPUs(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarAPUs(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarAPUs(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarAPUs(); }
        });
        
        // Búsqueda
        document.getElementById('buscador')?.addEventListener('input', (e) => {
            currentFilters.busqueda = e.target.value;
            currentFilters.page = 1;
            cargarAPUs();
        });
        
        // Fechas
        document.getElementById('fechaInicio')?.addEventListener('change', (e) => {
            currentFilters.fecha_inicio = e.target.value;
            currentFilters.page = 1;
            cargarAPUs();
        });
        document.getElementById('fechaFin')?.addEventListener('change', (e) => {
            currentFilters.fecha_fin = e.target.value;
            currentFilters.page = 1;
            cargarAPUs();
        });
        
        // Botones principales
        document.getElementById('btnNuevo')?.addEventListener('click', abrirModalNuevo);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnComparar')?.addEventListener('click', () => {
            mostrarNotificacion('Funcionalidad en desarrollo: Comparar APUs', 'warning');
        });
        
        // Modal - Nuevo APU
        document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModalNuevo);
        document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalNuevo);
        document.getElementById('formAPU')?.addEventListener('submit', guardarAPU);
        
        // Modal - Ver Detalle
        document.getElementById('btnCerrarVerModal')?.addEventListener('click', cerrarModalVer);
        
        // Cálculo automático del total
        ['modalMateriales', 'modalManoObra', 'modalMaquinaria', 'modalSubcontratos'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', calcularTotalModal);
        });
        
        // Pestañas de categoría
        document.querySelectorAll('.categoria-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.categoria-tab').forEach(t => {
                    t.classList.remove('active');
                    t.style.backgroundColor = '#e9ecef';
                    t.style.color = '#495057';
                });
                
                this.classList.add('active');
                this.style.backgroundColor = '#083CAE';
                this.style.color = 'white';
                
                filtroCategoriaActual = this.dataset.categoria;
                currentFilters.categoria = filtroCategoriaActual;
                currentFilters.page = 1;
                cargarAPUs();
            });
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', (event) => {
            const modalNuevo = document.getElementById('modalNuevo');
            const modalVer = document.getElementById('modalVerDetalle');
            if (event.target === modalNuevo) cerrarModalNuevo();
            if (event.target === modalVer) cerrarModalVer();
        });
        
        // Expandir/colapsar grupos
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
                cargarAPUs();
            }
        });
    }

    // ============================================
    // INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        // Configurar fechas por defecto
        const hoy = new Date();
        const seisMesesAtras = new Date();
        seisMesesAtras.setMonth(hoy.getMonth() - 6);
        
        document.getElementById('fechaInicio').value = seisMesesAtras.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
        
        // Inicializar
        setupDragAndDrop();
        inicializarEventos();
        cargarAPUs();
    });
</script>
@endsection