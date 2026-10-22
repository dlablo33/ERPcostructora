@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Licitaciones Activas -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Licitaciones Activas
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE LICITACIONES -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalLicitaciones">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Proceso</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="enProceso">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Adjudicadas</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="adjudicadas">0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Por Vencer</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="porVencer">0</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px;" title="Arrastra una columna aquí para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" 
                             style="display: flex; gap: 5px; flex-wrap: wrap; min-height: 32px; min-width: 200px; padding: 4px 8px; border: 2px dashed #ced4da; border-radius: 6px; background-color: #f8f9fa; align-items: center; transition: all 0.2s;"
                             ondragover="event.preventDefault(); this.style.borderColor='#2378e1'; this.style.backgroundColor='#e7f0ff';"
                             ondragleave="this.style.borderColor='#ced4da'; this.style.backgroundColor='#f8f9fa';"
                             ondrop="handleDropGroup(event)">
                        </div>
                        <button id="btnLimpiarAgrupacion" style="display: none; background: #dc3545; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; cursor: pointer; font-size: 11px; line-height: 1;" title="Quitar agrupación">×</button>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;" title="Fecha publicación desde">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;" title="Fecha publicación hasta">
                        </div>
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Licitación">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar a Excel">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnFiltrar" style="background-color: white; border: 1px solid #ffc107; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #ffc107;" title="Filtros avanzados">
                                <i class="fas fa-filter"></i>
                                Filtrar
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar licitación..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Panel de filtros avanzados (oculto por defecto) -->
                <div id="panelFiltros" style="display: none; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Estado</label>
                            <select id="filtroEstado" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Adjudicada">Adjudicada</option>
                                <option value="No Adjudicada">No Adjudicada</option>
                                <option value="Por Vencer">Por Vencer</option>
                                <option value="Vencida">Vencida</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Cliente</label>
                            <select id="filtroCliente" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Responsable</label>
                            <select id="filtroResponsable" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Participación</label>
                            <select id="filtroParticipa" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todas</option>
                                <option value="1">Solo participantes</option>
                                <option value="0">Solo no participantes</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Monto mín.</label>
                            <input type="number" id="filtroMontoMin" placeholder="0" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Monto máx.</label>
                            <input type="number" id="filtroMontoMax" placeholder="1000000" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: #495057;">Ordenar por</label>
                            <select id="filtroOrden" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="created_at|desc">Más recientes</option>
                                <option value="fecha_cierre|asc">Cierre próximo</option>
                                <option value="monto_estimado|desc">Mayor monto</option>
                                <option value="monto_estimado|asc">Menor monto</option>
                                <option value="no_licitacion|asc">No. Licitación</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 12px;">
                        <button id="btnLimpiarFiltros" style="padding: 6px 14px; background-color: #f8f9fa; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer; font-size: 13px;">Limpiar</button>
                        <button id="btnAplicarFiltros" style="padding: 6px 14px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">Aplicar filtros</button>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando licitaciones...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-contract" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin licitaciones</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Licitaciones -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaLicitaciones" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr id="tablaHeaderRow">
                                <th draggable="true" data-column="no_licitacion" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">No. Licitación</th>
                                <th draggable="true" data-column="nombre" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Nombre / Descripción</th>
                                <th draggable="true" data-column="cliente" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Cliente / Dependencia</th>
                                <th draggable="true" data-column="fecha_publicacion" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Fecha Publicación</th>
                                <th draggable="true" data-column="fecha_cierre" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Fecha Cierre</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">Días Restantes</th>
                                <th draggable="true" data-column="monto_estimado" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Monto Estimado</th>
                                <th draggable="true" data-column="responsable" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Responsable</th>
                                <th draggable="true" data-column="estado" style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0; cursor: grab;" title="Arrastra para agrupar">Estado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="totalMonto">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="3"></td>
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

<!-- Modal para Agregar Licitación -->
<div id="modalAgregarLicitacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-plus-circle"></i> Nueva Licitación</h3>
            <button id="btnCerrarModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <form id="formLicitacion">
            <div style="padding: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">No. Licitación <span style="color: #dc3545;">*</span></label>
                        <input type="text" id="modalNoLicitacion" name="no_licitacion" placeholder="Ej: LIC-2026-001" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cliente/Dependencia <span style="color: #dc3545;">*</span></label>
                        <select id="modalCliente" name="cliente_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                            <option value="">Cargando clientes...</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nombre / Descripción <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="modalNombre" name="nombre" placeholder="Descripción de la licitación" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Publicación <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaPublicacion" name="fecha_publicacion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Fecha Cierre <span style="color: #dc3545;">*</span></label>
                        <input type="date" id="modalFechaCierre" name="fecha_cierre" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Monto Estimado <span style="color: #dc3545;">*</span></label>
                        <input type="number" id="modalMonto" name="monto_estimado" placeholder="0.00" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Moneda</label>
                        <select id="modalMoneda" name="moneda" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="MXN">MXN - Peso Mexicano</option>
                            <option value="USD">USD - Dólar Americano</option>
                            <option value="EUR">EUR - Euro</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Responsable</label>
                    <select id="modalResponsable" name="responsable_id" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar responsable...</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" name="observaciones" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Notas adicionales..."></textarea>
                </div>
            </div>

            <div style="padding: 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" id="btnCancelar" style="padding: 10px 20px; background-color: #f8f9fa; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" id="btnGuardar" style="padding: 10px 20px; background-color: #083CAE; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar Licitación</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Ver Detalle -->
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #083CAE 0%, #052a6b 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;" id="modalVerTitulo">
                <i class="fas fa-file-contract"></i> Detalle de Licitación
            </h3>
            <button id="btnCerrarVerModal" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="detalleContent"></div>
    </div>
</div>

<!-- Modal para Rechazar -->
<div id="modalRechazar" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 500px; position: relative; z-index: 100000;">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white;"><i class="fas fa-times-circle"></i> Rechazar Licitación</h3>
            <button id="btnCerrarRechazar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <p style="color: #6c757d; margin-bottom: 12px;">Indica el motivo por el cual no se ganó esta licitación:</p>
            <textarea id="motivoRechazo" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Precio fuera de rango, no cumplimos requisitos técnicos..."></textarea>
            <input type="hidden" id="rechazarId">
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button id="btnCancelarRechazo" style="padding: 8px 18px; background-color: #f8f9fa; border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; cursor: pointer;">Cancelar</button>
            <button id="btnConfirmarRechazo" style="padding: 8px 18px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Rechazar</button>
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
    .badge-proceso { background-color: #cce5ff; color: #0d6efd; }
    .badge-adjudicada { background-color: #d4edda; color: #28a745; }
    .badge-por-vencer { background-color: #fff3cd; color: #ffc107; }
    .badge-vencida { background-color: #f8d7da; color: #dc3545; }
    .badge-no-adjudicada { background-color: #e2e3e5; color: #6c757d; }
    .badge-rechazada { background-color: #f5c6cb; color: #721c24; }
    .badge-participa { background-color: #083CAE; color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; margin-left: 5px; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    
    /* Grupo de agrupación */
    #grupoColumnas.drag-over {
        border-color: #2378e1 !important;
        background-color: #e7f0ff !important;
    }
    
    .chip-agrupacion {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background-color: #2378e1;
        color: white;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 600;
    }
    .chip-agrupacion button {
        background: rgba(255,255,255,0.3);
        border: none;
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        cursor: pointer;
        font-size: 11px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Grupo fila agrupada */
    .grupo-header-row {
        background-color: #e7f0ff !important;
        font-weight: 700;
        color: #083CAE;
    }
    .grupo-header-row td {
        padding: 8px 12px !important;
        border-top: 2px solid #2378e1 !important;
    }
    
    /* Toast notifications */
    .toast-notification { 
        position: fixed; 
        bottom: 20px; 
        right: 20px; 
        z-index: 100000; 
        animation: slideIn 0.3s ease; 
        background-color: #28a745; 
        color: white; 
        padding: 12px 20px; 
        border-radius: 8px; 
        margin-bottom: 10px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); 
        font-size: 14px; 
    }
    .toast-notification.error { background-color: #dc3545; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { 
        from { transform: translateX(100%); opacity: 0; } 
        to { transform: translateX(0); opacity: 1; } 
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        #modalAgregarLicitacion > div,
        #modalVerDetalle > div,
        #modalRechazar > div {
            width: 95%;
            margin: 10px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/licitaciones';
    let currentPage = 1;
    let totalPages = 1;
    let debounceTimer = null;
    let agrupacionActual = null; // { columna, etiqueta }

    let currentFilters = {
        busqueda: '',
        estado: '',
        fecha_inicio: '',
        fecha_fin: '',
        cliente_id: '',
        responsable_id: '',
        participa: '',
        monto_min: '',
        monto_max: '',
        sort_by: 'created_at',
        sort_dir: 'desc',
        group_by: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarLicitaciones() {
        mostrarLoading(true);
        
        try {
            // Limpiar parámetros vacíos para no enviarlos
            const params = new URLSearchParams();
            Object.entries(currentFilters).forEach(([key, value]) => {
                if (value !== '' && value !== null && value !== undefined) {
                    params.append(key, value);
                }
            });
            
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
            
            if (result.success) {
                const data = result.data.data || [];
                const pagination = result.data;
                
                actualizarEstadisticas(result.estadisticas);
                renderizarTabla(data, result.agrupado, result.group_by);
                actualizarPaginacion(pagination);
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar las licitaciones', 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    async function cargarClientes() {
        try {
            const response = await fetch(`${API_BASE}/clientes`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            const select = document.getElementById('modalCliente');
            const filtroCliente = document.getElementById('filtroCliente');
            
            if (result.success && result.data && result.data.length > 0) {
                let options = '<option value="">Seleccionar cliente...</option>';
                let optionsFiltro = '<option value="">Todos</option>';
                
                result.data.forEach(cliente => {
                    options += `<option value="${cliente.id}">${cliente.nombre}</option>`;
                    optionsFiltro += `<option value="${cliente.id}">${cliente.nombre}</option>`;
                });
                
                select.innerHTML = options;
                filtroCliente.innerHTML = optionsFiltro;
            } else {
                select.innerHTML = '<option value="">No hay clientes disponibles</option>';
            }
        } catch (error) {
            console.error('Error cargando clientes:', error);
            document.getElementById('modalCliente').innerHTML = '<option value="">Error al cargar clientes</option>';
        }
    }

    async function cargarResponsables() {
        try {
            const response = await fetch(`${API_BASE}/responsables`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            const select = document.getElementById('modalResponsable');
            const filtroResp = document.getElementById('filtroResponsable');
            
            if (result.success && result.data && result.data.length > 0) {
                let options = '<option value="">Seleccionar responsable...</option>';
                let optionsFiltro = '<option value="">Todos</option>';
                
                result.data.forEach(responsable => {
                    const nombre = responsable.nombre_completo || responsable.nombre || 'Sin nombre';
                    options += `<option value="${responsable.id}">${nombre}</option>`;
                    optionsFiltro += `<option value="${responsable.id}">${nombre}</option>`;
                });
                
                select.innerHTML = options;
                filtroResp.innerHTML = optionsFiltro;
            } else {
                select.innerHTML = '<option value="">No hay responsables disponibles</option>';
            }
        } catch (error) {
            console.error('Error cargando responsables:', error);
            document.getElementById('modalResponsable').innerHTML = '<option value="">Error al cargar responsables</option>';
        }
    }

    // ============================================
    // RENDERIZADO
    // ============================================

    function renderizarTabla(licitaciones, agrupado, groupBy) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        
        if ((!licitaciones || licitaciones.length === 0) && (!agrupado || agrupado.length === 0)) {
            tbody.innerHTML = '';
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            return;
        }
        
        sinDatos.style.display = 'none';
        tablaContainer.style.display = 'block';
        
        let html = '';
        let totalMonto = 0;
        
        if (agrupado && agrupado.length > 0) {
            // Renderizar agrupado
            agrupado.forEach(grupo => {
                const items = grupo.items || [];
                const montoGrupo = parseFloat(grupo.monto_total || 0);
                totalMonto += montoGrupo;
                
                html += `
                    <tr class="grupo-header-row">
                        <td colspan="10" style="text-align: left;">
                            <i class="fas fa-folder-open" style="margin-right: 6px;"></i>
                            <strong>${grupo.grupo || 'Sin valor'}</strong>
                            <span style="margin-left: 10px; color: #6c757d; font-weight: normal;">
                                (${grupo.total} ${grupo.total === 1 ? 'registro' : 'registros'} · ${formatCurrency(montoGrupo)})
                            </span>
                        </td>
                    </tr>
                `;
                
                items.forEach(licitacion => {
                    html += renderFilaLicitacion(licitacion);
                });
            });
        } else {
            // Renderizar normal
            licitaciones.forEach(licitacion => {
                totalMonto += parseFloat(licitacion.monto_estimado || 0);
                html += renderFilaLicitacion(licitacion);
            });
        }
        
        tbody.innerHTML = html;
        document.getElementById('totalMonto').textContent = formatCurrency(totalMonto);
    }

    function renderFilaLicitacion(licitacion) {
        // ✅ CORREGIDO: El check de participar se muestra siempre que NO participe y no esté en estados finales
        const estadosFinales = ['Vencida', 'Adjudicada', 'No Adjudicada', 'Rechazada', 'Cancelada'];
        const puedeParticipar = !licitacion.participa && !estadosFinales.includes(licitacion.estado);
        
        // ✅ CORREGIDO: Si participa y NO está adjudicada, mostrar botones Ganar / Rechazar
        const puedeGanar = licitacion.participa && !['Adjudicada', 'No Adjudicada', 'Rechazada'].includes(licitacion.estado);
        
        let acciones = `
            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${licitacion.id})"></i>
        `;
        
        if (puedeParticipar) {
            acciones += `
                <i class="fas fa-check-circle" style="color: #28a745; cursor: pointer; font-size: 14px;" title="Participar" onclick="confirmarParticipacion(${licitacion.id})"></i>
            `;
        }
        
        if (puedeGanar) {
            acciones += `
                <i class="fas fa-trophy" style="color: #ffc107; cursor: pointer; font-size: 14px;" title="Marcar como Ganadora" onclick="marcarGanadora(${licitacion.id})"></i>
                <i class="fas fa-times-circle" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Marcar como Rechazada" onclick="abrirModalRechazar(${licitacion.id})"></i>
            `;
        }
        
        return `
            <tr>
                <td style="padding: 10px 4px;">
                    ${licitacion.no_licitacion || 'N/A'}
                    ${licitacion.participa ? '<span class="badge-participa">Participamos</span>' : ''}
                </td>
                <td style="padding: 10px 4px;">${licitacion.nombre || '-'}</td>
                <td style="padding: 10px 4px;">${licitacion.nombre_cliente || licitacion.cliente?.razon_social || '-'}</td>
                <td style="padding: 10px 4px; text-align: center;">${formatDate(licitacion.fecha_publicacion)}</td>
                <td style="padding: 10px 4px; text-align: center;">${formatDate(licitacion.fecha_cierre)}</td>
                <td style="padding: 10px 4px; text-align: center; color: ${getDiasColor(licitacion.dias_restantes)}; font-weight: 600;">
                    ${licitacion.dias_restantes || 0} días
                </td>
                <td style="padding: 10px 4px; text-align: right;">${formatCurrency(licitacion.monto_estimado)}</td>
                <td style="padding: 10px 4px;">${licitacion.nombre_responsable || licitacion.responsable?.nombre || '-'}</td>
                <td style="padding: 10px 4px;">
                    <span class="badge-estado ${getEstadoBadgeClass(licitacion.estado)}">${licitacion.estado || 'En Proceso'}</span>
                </td>
                <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        ${acciones}
                    </div>
                </td>
            </tr>
        `;
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalLicitaciones').textContent = stats.total || 0;
        document.getElementById('enProceso').textContent = stats.en_proceso || 0;
        document.getElementById('adjudicadas').textContent = stats.adjudicadas || 0;
        document.getElementById('porVencer').textContent = stats.por_vencer || 0;
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

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function formatCurrency(amount) {
        return '$' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function getDiasColor(dias) {
        if (dias < 0) return '#dc3545';
        if (dias <= 7) return '#dc3545';
        if (dias <= 15) return '#ffc107';
        return '#28a745';
    }

    function getEstadoBadgeClass(estado) {
        const badges = {
            'En Proceso': 'badge-proceso',
            'Adjudicada': 'badge-adjudicada',
            'Por Vencer': 'badge-por-vencer',
            'Vencida': 'badge-vencida',
            'No Adjudicada': 'badge-no-adjudicada',
            'Rechazada': 'badge-rechazada',
            'Cancelada': 'badge-no-adjudicada'
        };
        return badges[estado] || 'badge-proceso';
    }

    function mostrarLoading(show) {
        const spinner = document.getElementById('loadingSpinner');
        if (spinner) spinner.style.display = show ? 'block' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = 'toast-notification';
        if (tipo === 'error') notificacion.classList.add('error');
        if (tipo === 'warning') notificacion.classList.add('warning');
        notificacion.innerHTML = `<i class="fas ${tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // ✅ DRAG & DROP PARA AGRUPACIÓN
    // ============================================

    function inicializarDragAndDrop() {
        const headers = document.querySelectorAll('#tablaHeaderRow th[draggable="true"]');
        
        headers.forEach(th => {
            th.addEventListener('dragstart', (e) => {
                const columna = th.getAttribute('data-column');
                const etiqueta = th.textContent.trim();
                e.dataTransfer.setData('text/plain', columna);
                e.dataTransfer.setData('text/label', etiqueta);
                e.dataTransfer.effectAllowed = 'copy';
                th.style.opacity = '0.5';
            });
            
            th.addEventListener('dragend', (e) => {
                th.style.opacity = '1';
                document.getElementById('grupoColumnas').style.borderColor = '#ced4da';
                document.getElementById('grupoColumnas').style.backgroundColor = '#f8f9fa';
            });
        });
    }

    window.handleDropGroup = function(event) {
        event.preventDefault();
        const columna = event.dataTransfer.getData('text/plain');
        const etiqueta = event.dataTransfer.getData('text/label');
        
        if (!columna) return;
        
        // Resetear estilos
        const dropZone = document.getElementById('grupoColumnas');
        dropZone.style.borderColor = '#ced4da';
        dropZone.style.backgroundColor = '#f8f9fa';
        
        // Establecer agrupación
        agrupacionActual = { columna, etiqueta };
        currentFilters.group_by = columna;
        currentFilters.page = 1;
        
        // Renderizar chip
        renderizarChipAgrupacion();
        
        // Recargar datos
        cargarLicitaciones();
    };

    function renderizarChipAgrupacion() {
        const grupoColumnas = document.getElementById('grupoColumnas');
        const textoAgrupar = document.getElementById('textoAgrupar');
        const btnLimpiar = document.getElementById('btnLimpiarAgrupacion');
        
        if (agrupacionActual) {
            grupoColumnas.innerHTML = `
                <span class="chip-agrupacion">
                    <i class="fas fa-layer-group"></i>
                    ${agrupacionActual.etiqueta}
                    <button onclick="quitarAgrupacion()" title="Quitar">×</button>
                </span>
            `;
            textoAgrupar.style.display = 'none';
            btnLimpiar.style.display = 'flex';
            btnLimpiar.style.alignItems = 'center';
            btnLimpiar.style.justifyContent = 'center';
        } else {
            grupoColumnas.innerHTML = '';
            textoAgrupar.style.display = 'inline';
            btnLimpiar.style.display = 'none';
        }
    }

    window.quitarAgrupacion = function() {
        agrupacionActual = null;
        currentFilters.group_by = '';
        currentFilters.page = 1;
        renderizarChipAgrupacion();
        cargarLicitaciones();
    };

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
                    <div style="margin-bottom: 20px;">
                        <div style="font-size: 12px; color: #6c757d;">No. Licitación</div>
                        <div style="font-size: 20px; font-weight: 700; color: #083CAE;">${l.no_licitacion}</div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Nombre / Descripción</div>
                        <div style="font-size: 16px; font-weight: 600;">${l.nombre || '-'}</div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div><div style="color: #6c757d; font-size: 12px;">Cliente</div><div>${l.nombre_cliente || '-'}</div></div>
                        <div><div style="color: #6c757d; font-size: 12px;">Responsable</div><div>${l.nombre_responsable || '-'}</div></div>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Publicación</div>
                            <div style="font-size: 15px;">${formatDate(l.fecha_publicacion)}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Cierre</div>
                            <div style="font-size: 15px;">${formatDate(l.fecha_cierre)}</div>
                        </div>
                        <div style="border: 1px solid #dee2e6; border-radius: 6px; padding: 12px;">
                            <div style="color: #6c757d; font-size: 11px;">Días Restantes</div>
                            <div style="font-size: 15px; color: ${getDiasColor(l.dias_restantes)};">${l.dias_restantes} días</div>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Monto Estimado</div>
                        <div style="font-size: 24px; font-weight: 700; color: #083CAE;">${formatCurrency(l.monto_estimado)} ${l.moneda || 'MXN'}</div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Estado</div>
                        <span class="badge-estado ${getEstadoBadgeClass(l.estado)}">${l.estado || 'En Proceso'}</span>
                        ${l.participa ? '<span class="badge-participa" style="margin-left: 8px;">Participamos</span>' : ''}
                    </div>
                    ${l.observaciones ? `
                    <div style="margin-bottom: 20px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; white-space: pre-wrap;">${l.observaciones}</div>
                    </div>` : ''}
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalVer()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                document.getElementById('detalleContent').innerHTML = content;
                abrirModalVer();
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    // ✅ Confirmar participación (marca el check y cambia estado a "En Proceso")
    window.confirmarParticipacion = async function(id) {
        if (!confirm('¿Desea confirmar su participación en esta licitación?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/${id}/participar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message || 'Participación confirmada', 'success');
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message || 'Error al confirmar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al confirmar participación', 'error');
        }
    };

    // ✅ Marcar como ganadora (Adjudicada)
    window.marcarGanadora = async function(id) {
        if (!confirm('¿Confirmas que esta licitación fue GANADA / ADJUDICADA?')) return;
        
        try {
            const response = await fetch(`${API_BASE}/${id}/ganar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message || 'Licitación marcada como Adjudicada', 'success');
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message || 'Error al marcar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al marcar como ganadora', 'error');
        }
    };

    // ✅ Abrir modal de rechazo
    window.abrirModalRechazar = function(id) {
        document.getElementById('rechazarId').value = id;
        document.getElementById('motivoRechazo').value = '';
        document.getElementById('modalRechazar').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.cerrarModalRechazar = function() {
        document.getElementById('modalRechazar').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // ✅ Confirmar rechazo
    async function confirmarRechazo() {
        const id = document.getElementById('rechazarId').value;
        const motivo = document.getElementById('motivoRechazo').value.trim();
        
        if (!id) return;
        
        try {
            const response = await fetch(`${API_BASE}/${id}/rechazar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ motivo })
            });
            const result = await response.json();
            
            if (result.success) {
                mostrarNotificacion(result.message || 'Licitación rechazada', 'success');
                cerrarModalRechazar();
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message || 'Error al rechazar', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al rechazar la licitación', 'error');
        }
    }

    function abrirModalVer() {
        document.getElementById('modalVerDetalle').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    window.cerrarModalVer = function() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    async function exportarExcel() {
        try {
            const params = new URLSearchParams();
            Object.entries(currentFilters).forEach(([key, value]) => {
                if (value !== '' && value !== null && value !== undefined && key !== 'page') {
                    params.append(key, value);
                }
            });
            
            const response = await fetch(`${API_BASE}/exportar?${params.toString()}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                const headers = ['No. Licitación', 'Nombre', 'Cliente', 'Fecha Publicación', 'Fecha Cierre', 'Días', 'Monto', 'Responsable', 'Estado'];
                const rows = result.data.map(l => [
                    l.no_licitacion, l.nombre, l.nombre_cliente, formatDate(l.fecha_publicacion),
                    formatDate(l.fecha_cierre), l.dias_restantes, l.monto_estimado, l.nombre_responsable, l.estado
                ]);
                const csvContent = [headers, ...rows].map(row => 
                    row.map(cell => `"${String(cell ?? '').replace(/"/g, '""')}"`).join(',')
                ).join('\n');
                
                const blob = new Blob(['\ufeff' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `licitaciones_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    async function crearLicitacion(event) {
        event.preventDefault();
        
        const formData = new FormData();
        formData.append('no_licitacion', document.getElementById('modalNoLicitacion').value);
        formData.append('nombre', document.getElementById('modalNombre').value);
        formData.append('cliente_id', document.getElementById('modalCliente').value);
        formData.append('fecha_publicacion', document.getElementById('modalFechaPublicacion').value);
        formData.append('fecha_cierre', document.getElementById('modalFechaCierre').value);
        formData.append('monto_estimado', document.getElementById('modalMonto').value);
        formData.append('moneda', document.getElementById('modalMoneda').value);
        formData.append('responsable_id', document.getElementById('modalResponsable').value || '');
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
                cerrarModalAgregar();
                cargarLicitaciones();
            } else {
                mostrarNotificacion(result.message || 'Error al crear', 'error');
            }
        } catch (error) {
            mostrarNotificacion('Error al crear la licitación', 'error');
        }
    }

    function abrirModalAgregar() {
        document.getElementById('modalAgregarLicitacion').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        const hoy = new Date();
        const unMesDespues = new Date();
        unMesDespues.setMonth(hoy.getMonth() + 1);
        
        document.getElementById('modalFechaPublicacion').value = hoy.toISOString().split('T')[0];
        document.getElementById('modalFechaCierre').value = unMesDespues.toISOString().split('T')[0];
    }

    function cerrarModalAgregar() {
        document.getElementById('modalAgregarLicitacion').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formLicitacion')?.reset();
    }

    // ============================================
    // ✅ FILTROS AVANZADOS
    // ============================================

    function togglePanelFiltros() {
        const panel = document.getElementById('panelFiltros');
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    }

    function aplicarFiltros() {
        currentFilters.estado = document.getElementById('filtroEstado').value;
        currentFilters.cliente_id = document.getElementById('filtroCliente').value;
        currentFilters.responsable_id = document.getElementById('filtroResponsable').value;
        currentFilters.participa = document.getElementById('filtroParticipa').value;
        currentFilters.monto_min = document.getElementById('filtroMontoMin').value;
        currentFilters.monto_max = document.getElementById('filtroMontoMax').value;
        
        const orden = document.getElementById('filtroOrden').value.split('|');
        currentFilters.sort_by = orden[0];
        currentFilters.sort_dir = orden[1];
        
        currentFilters.page = 1;
        cargarLicitaciones();
        
        mostrarNotificacion('Filtros aplicados', 'success');
    }

    function limpiarFiltros() {
        document.getElementById('filtroEstado').value = '';
        document.getElementById('filtroCliente').value = '';
        document.getElementById('filtroResponsable').value = '';
        document.getElementById('filtroParticipa').value = '';
        document.getElementById('filtroMontoMin').value = '';
        document.getElementById('filtroMontoMax').value = '';
        document.getElementById('filtroOrden').value = 'created_at|desc';
        
        currentFilters.estado = '';
        currentFilters.cliente_id = '';
        currentFilters.responsable_id = '';
        currentFilters.participa = '';
        currentFilters.monto_min = '';
        currentFilters.monto_max = '';
        currentFilters.sort_by = 'created_at';
        currentFilters.sort_dir = 'desc';
        currentFilters.page = 1;
        
        cargarLicitaciones();
        mostrarNotificacion('Filtros limpiados', 'success');
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    function inicializarEventos() {
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarLicitaciones(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarLicitaciones(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarLicitaciones(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarLicitaciones(); }
        });
        
        // ✅ Buscador con debounce (evita múltiples peticiones)
        document.getElementById('buscador')?.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                currentFilters.busqueda = e.target.value.trim();
                currentFilters.page = 1;
                cargarLicitaciones();
            }, 400);
        });
        
        // ✅ Filtros de fecha (con debounce)
        document.getElementById('fechaInicio')?.addEventListener('change', (e) => {
            currentFilters.fecha_inicio = e.target.value;
            currentFilters.page = 1;
            cargarLicitaciones();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', (e) => {
            currentFilters.fecha_fin = e.target.value;
            currentFilters.page = 1;
            cargarLicitaciones();
        });
        
        // Botones principales
        document.getElementById('btnAgregar')?.addEventListener('click', abrirModalAgregar);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnFiltrar')?.addEventListener('click', togglePanelFiltros);
        
        // Filtros avanzados
        document.getElementById('btnAplicarFiltros')?.addEventListener('click', aplicarFiltros);
        document.getElementById('btnLimpiarFiltros')?.addEventListener('click', limpiarFiltros);
        
        // Modales
        document.getElementById('btnCerrarModal')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCancelar')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCerrarVerModal')?.addEventListener('click', cerrarModalVer);
        document.getElementById('btnCerrarRechazar')?.addEventListener('click', cerrarModalRechazar);
        document.getElementById('btnCancelarRechazo')?.addEventListener('click', cerrarModalRechazar);
        document.getElementById('btnConfirmarRechazo')?.addEventListener('click', confirmarRechazo);
        document.getElementById('formLicitacion')?.addEventListener('submit', crearLicitacion);
        
        // Limpiar agrupación
        document.getElementById('btnLimpiarAgrupacion')?.addEventListener('click', quitarAgrupacion);
        
        // Cerrar modales al hacer click fuera
        window.addEventListener('click', (event) => {
            const modales = [
                'modalAgregarLicitacion',
                'modalVerDetalle',
                'modalRechazar'
            ];
            modales.forEach(id => {
                const modal = document.getElementById(id);
                if (event.target === modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
        
        // ✅ Inicializar drag & drop
        inicializarDragAndDrop();
    }

    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        // Establecer fechas por defecto (últimos 6 meses)
        const hoy = new Date();
        const seisMesesAtras = new Date();
        seisMesesAtras.setMonth(hoy.getMonth() - 6);
        
        document.getElementById('fechaInicio').value = seisMesesAtras.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
        
        currentFilters.fecha_inicio = document.getElementById('fechaInicio').value;
        currentFilters.fecha_fin = document.getElementById('fechaFin').value;
        
        // Cargar datos iniciales
        cargarClientes();
        cargarResponsables();
        cargarLicitaciones();
        inicializarEventos();
    });
</script>
@endsection