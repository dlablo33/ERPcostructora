@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Costos Directos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Costos Directos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE COSTOS DIRECTOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Directos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalDirectos">$0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Materiales</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalMateriales">$0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Mano de Obra</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalManoObra">$0</div>
                        </div>
                    </div>
                    
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Maquinaria</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalMaquinaria">$0</div>
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
                        <!-- Filtro de Proyectos - Dropdown con checkboxes -->
                        <div style="position: relative; min-width: 220px;" id="proyectoFilterContainer">
                            <button type="button" id="btnFiltroProyectos" style="width: 100%; padding: 6px 12px; border: 1px solid #ced4da; border-radius: 4px; background-color: white; cursor: pointer; font-size: 14px; display: flex; justify-content: space-between; align-items: center; min-height: 38px;">
                                <span id="filtroProyectosLabel">Todos los proyectos</span>
                                <i class="fas fa-chevron-down" style="color: #6c757d; font-size: 12px;"></i>
                            </button>
                            
                            <div id="filtroProyectosDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ced4da; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; max-height: 280px; overflow: hidden; padding: 8px 0; margin-top: 2px;">
                                <div style="padding: 0 12px 8px 12px; border-bottom: 1px solid #e9ecef;">
                                    <input type="text" id="filtroProyectosBuscar" placeholder="Buscar proyecto..." style="width: 100%; padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                </div>
                                <div id="filtroProyectosLista" style="max-height: 180px; overflow-y: auto; padding: 8px 0;">
                                    <!-- Los checkboxes se cargarán dinámicamente -->
                                </div>
                                <div style="padding: 8px 12px; border-top: 1px solid #e9ecef; display: flex; gap: 10px; flex-wrap: wrap;">
                                    <button id="btnSeleccionarTodos" style="background: none; border: none; color: #083CAE; cursor: pointer; font-size: 12px; font-weight: 600;">Seleccionar todos</button>
                                    <button id="btnDeseleccionarTodos" style="background: none; border: none; color: #6c757d; cursor: pointer; font-size: 12px;">Deseleccionar todos</button>
                                    <button id="btnCerrarFiltro" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 12px; margin-left: auto;">Cerrar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <input type="date" id="fechaInicio" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <input type="date" id="fechaFin" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                        </div>
                        <div>
                            <button id="btnAgregarCosto" style="background-color: #28a745; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;" title="Agregar nuevo costo directo">
                                <i class="fas fa-plus-circle"></i> Agregar Costo
                            </button>
                        </div>
                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Exportar todo">
                                <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                                Exportar
                            </button>
                        </div>
                        <div>
                            <button id="btnColumnas" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;" title="Seleccionar columnas">
                                <i class="fas fa-columns" style="color: #083CAE;"></i>
                            </button>
                        </div>
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Loading -->
                <div id="loadingSpinner" style="text-align: center; padding: 40px; display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #083CAE;"></i>
                    <p style="margin-top: 10px; color: #6c757d;">Cargando costos...</p>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-hard-hat" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Costos Directos -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaCostosDirectos" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proyecto">Proyecto</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="categoria">Categoría</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="concepto">Concepto</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha">Fecha</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="proveedor">Proveedor/Empleado</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="rfc">RFC</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="factura">Factura/Recibo</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="descripcion">Descripción</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="unidad">Unidad</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="cantidad">Cantidad</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="precio_unitario">Precio Unit.</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="subtotal">Subtotal</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="iva">IVA</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="total">Total</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="fecha_pago">Fecha Pago</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="estatus_pago">Estatus Pago</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;" draggable="true" data-columna="observaciones">Observaciones</th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="11">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSubtotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumIva">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef; color: #000000;" colspan="3"></td>
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

<!-- Modal para Agregar Costo Directo -->
<div id="modalAgregarCosto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus-circle"></i> Agregar Costo Directo
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
                        <select id="campoProyecto" name="proyecto_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Categoría <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="campoCategoria" name="categoria" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar categoría</option>
                            <option value="materiales">📦 Materiales</option>
                            <option value="mano_obra">👷 Mano de Obra</option>
                            <option value="maquinaria">🚜 Maquinaria</option>
                            <option value="subcontratos">🤝 Subcontratos</option>
                            <option value="equipos">🔧 Equipos</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Concepto <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" id="campoConcepto" name="concepto" required placeholder="Ej. Concreto premezclado, Armado de acero, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="date" id="campoFecha" name="fecha" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proveedor/Empleado
                        </label>
                        <select id="campoProveedor" name="proveedor_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proveedor</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            RFC
                        </label>
                        <input type="text" id="campoRFC" name="rfc" placeholder="RFC del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Factura/Recibo
                        </label>
                        <input type="text" id="campoFactura" name="factura" placeholder="Número de factura o recibo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Descripción
                    </label>
                    <textarea id="campoDescripcion" name="descripcion" rows="2" placeholder="Descripción detallada del concepto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Unidad
                        </label>
                        <select id="campoUnidad" name="unidad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Pieza">Pieza</option>
                            <option value="Metro">Metro</option>
                            <option value="Metro2">Metro²</option>
                            <option value="Metro3">Metro³</option>
                            <option value="Kilogramo">Kilogramo</option>
                            <option value="Tonelada">Tonelada</option>
                            <option value="Litro">Litro</option>
                            <option value="Hora">Hora</option>
                            <option value="Día">Día</option>
                            <option value="Jornada">Jornada</option>
                            <option value="Global">Global</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Cantidad <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="campoCantidad" name="cantidad" step="0.01" min="0" value="1.00" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Precio Unitario <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="campoPrecioUnitario" name="precio_unitario" step="0.01" min="0" value="0.00" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Subtotal
                        </label>
                        <input type="number" id="campoSubtotal" step="0.01" min="0" value="0.00" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            IVA
                        </label>
                        <input type="number" id="campoIva" name="iva" step="0.01" min="0" value="0.00" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
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
                            Fecha de Pago
                        </label>
                        <input type="date" id="campoFechaPago" name="fecha_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Estatus de Pago
                        </label>
                        <select id="campoEstatusPago" name="estatus_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="pagado">Pagado</option>
                            <option value="pendiente" selected> Pendiente</option>
                            <option value="programado">Programado</option>
                            <option value="vencido"> Vencido</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Observaciones
                    </label>
                    <textarea id="campoObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
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

<!-- Modal para Editar Costo Directo -->
<div id="modalEditarCosto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-edit"></i> Editar Costo Directo
            </h3>
            <button id="btnCerrarModalEditar" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div style="padding: 20px;">
            <form id="formEditarCosto">
                <input type="hidden" id="editId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proyecto <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="editProyecto" name="proyecto_id" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proyecto</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Categoría <span style="color: #dc3545;">*</span>
                        </label>
                        <select id="editCategoria" name="categoria" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar categoría</option>
                            <option value="materiales"> Materiales</option>
                            <option value="mano_obra"> Mano de Obra</option>
                            <option value="maquinaria"> Maquinaria</option>
                            <option value="subcontratos"> Subcontratos</option>
                            <option value="equipos"> Equipos</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Concepto <span style="color: #dc3545;">*</span>
                    </label>
                    <input type="text" id="editConcepto" name="concepto" required placeholder="Ej. Concreto premezclado, Armado de acero, etc." style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Fecha <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="date" id="editFecha" name="fecha" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Proveedor/Empleado
                        </label>
                        <select id="editProveedor" name="proveedor_id" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="">Seleccionar proveedor</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            RFC
                        </label>
                        <input type="text" id="editRFC" name="rfc" placeholder="RFC del proveedor" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Factura/Recibo
                        </label>
                        <input type="text" id="editFactura" name="factura" placeholder="Número de factura o recibo" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Descripción
                    </label>
                    <textarea id="editDescripcion" name="descripcion" rows="2" placeholder="Descripción detallada del concepto" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Unidad
                        </label>
                        <select id="editUnidad" name="unidad" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="Pieza">Pieza</option>
                            <option value="Metro">Metro</option>
                            <option value="Metro2">Metro²</option>
                            <option value="Metro3">Metro³</option>
                            <option value="Kilogramo">Kilogramo</option>
                            <option value="Tonelada">Tonelada</option>
                            <option value="Litro">Litro</option>
                            <option value="Hora">Hora</option>
                            <option value="Día">Día</option>
                            <option value="Jornada">Jornada</option>
                            <option value="Global">Global</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Cantidad <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="editCantidad" name="cantidad" step="0.01" min="0" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Precio Unitario <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="number" id="editPrecioUnitario" name="precio_unitario" step="0.01" min="0" required style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Subtotal
                        </label>
                        <input type="number" id="editSubtotal" step="0.01" min="0" readonly style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; background-color: #e9ecef;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            IVA
                        </label>
                        <input type="number" id="editIva" name="iva" step="0.01" min="0" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
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
                            Fecha de Pago
                        </label>
                        <input type="date" id="editFechaPago" name="fecha_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                            Estatus de Pago
                        </label>
                        <select id="editEstatusPago" name="estatus_pago" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px;">
                            <option value="pagado"> Pagado</option>
                            <option value="pendiente"> Pendiente</option>
                            <option value="programado"> Programado</option>
                            <option value="vencido">Vencido</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #495057;">
                        Observaciones
                    </label>
                    <textarea id="editObservaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales" style="width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; resize: vertical;"></textarea>
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
<div id="modalVerDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 99999; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 90%; max-width: 700px; max-height: 80vh; overflow-y: auto; position: relative; z-index: 100000; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <div style="padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #2378e1 0%, #1a5cb0 100%); border-radius: 12px 12px 0 0;">
            <h3 style="margin: 0; color: white; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-info-circle"></i> <span id="modalTitulo">Detalle de Costo Directo</span>
            </h3>
            <button id="btnCerrarModalDetalle" style="background: rgba(255,255,255,0.2); border: none; font-size: 20px; cursor: pointer; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 20px;" id="modalContenidoDetalle"></div>
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
    
    .badge { font-size: 11px; font-weight: 600; padding: 4px 8px; display: inline-block; border-radius: 3px; }
    .badge-pagado { background-color: #28a745; color: white; }
    .badge-pendiente { background-color: #ffc107; color: black; }
    .badge-programado { background-color: #17a2b8; color: white; }
    .badge-vencido { background-color: #dc3545; color: white; }
    
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    
    .toast-notification { position: fixed; bottom: 20px; right: 20px; z-index: 100000; animation: slideIn 0.3s ease; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 14px; }
    .toast-notification.success { background-color: #28a745; color: white; }
    .toast-notification.error { background-color: #dc3545; color: white; }
    .toast-notification.warning { background-color: #ffc107; color: #333; }
    
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
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
    
    /* Estilo para el dropdown de proyectos */
    #filtroProyectosDropdown {
        min-width: 250px;
    }
    #filtroProyectosLista label {
        display: flex;
        align-items: center;
        padding: 4px 12px;
        cursor: pointer;
        font-size: 13px;
        transition: background 0.2s;
    }
    #filtroProyectosLista label:hover {
        background-color: #f0f4ff;
    }
    #filtroProyectosLista input[type="checkbox"] {
        margin-right: 8px;
        cursor: pointer;
    }
    #filtroProyectosLista .item-count {
        color: #6c757d;
        font-size: 11px;
        margin-left: auto;
    }
    
    @media (max-width: 768px) {
        input[type="date"] { width: 100% !important; }
        input#buscador { width: 100% !important; }
        #proyectoFilterContainer { min-width: 100% !important; }
        #filtroProyectosDropdown { min-width: 100% !important; }
        #paginacionContainer { flex-direction: column; align-items: flex-start; }
        #modalAgregarCosto > div, #modalEditarCosto > div, #modalVerDetalle > div { width: 95%; margin: 10px; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    const API_BASE = '/proyectos/costos-directos';
    let currentPage = 1;
    let totalPages = 1;
    let columnasAgrupadas = [];
    let expandedGroups = new Set();
    let proyectosLista = [];
    
    let currentFilters = {
        busqueda: '',
        proyecto_id: [],
        categoria: 'todos',
        estatus_pago: '',
        fecha_inicio: '',
        fecha_fin: '',
        page: 1,
        per_page: 10
    };

    // ============================================
    // FUNCIONES PRINCIPALES
    // ============================================

    async function cargarCostos() {
        mostrarLoading(true);
        
        try {
            if (!currentFilters.fecha_inicio) {
                const hoy = new Date();
                const seisMesesAtras = new Date();
                seisMesesAtras.setMonth(hoy.getMonth() - 6);
                currentFilters.fecha_inicio = seisMesesAtras.toISOString().split('T')[0];
                currentFilters.fecha_fin = hoy.toISOString().split('T')[0];
                document.getElementById('fechaInicio').value = currentFilters.fecha_inicio;
                document.getElementById('fechaFin').value = currentFilters.fecha_fin;
            }
            
            const proyectosSeleccionados = getProyectosSeleccionados();
            currentFilters.proyecto_id = proyectosSeleccionados;
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('categoria', currentFilters.categoria || 'todos');
            params.append('estatus_pago', currentFilters.estatus_pago || '');
            params.append('fecha_inicio', currentFilters.fecha_inicio || '');
            params.append('fecha_fin', currentFilters.fecha_fin || '');
            params.append('page', currentFilters.page || 1);
            params.append('per_page', currentFilters.per_page || 10);
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
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
                renderizarTabla(data);
                calcularTotales(data);
                actualizarPaginacion(pagination);
                
                currentPage = pagination.current_page || 1;
                totalPages = pagination.last_page || 1;
            } else {
                mostrarNotificacion(result.message || 'Error al cargar datos', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar los costos: ' + error.message, 'error');
        } finally {
            mostrarLoading(false);
        }
    }

    // ============================================
    // FILTRO DE PROYECTOS - DROPDOWN CON CHECKBOXES
    // ============================================

    function getProyectosSeleccionados() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked');
        const selected = [];
        checkboxes.forEach(cb => {
            if (cb.value) {
                selected.push(cb.value);
            }
        });
        return selected;
    }

    function actualizarLabelProyectos() {
        const total = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]').length;
        const selected = getProyectosSeleccionados().length;
        const label = document.getElementById('filtroProyectosLabel');
        
        if (selected === 0) {
            label.textContent = 'Todos los proyectos';
        } else if (selected === total) {
            label.textContent = 'Todos los proyectos';
        } else {
            const count = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]:checked').length;
            label.textContent = `${count} proyecto${count > 1 ? 's' : ''} seleccionado${count > 1 ? 's' : ''}`;
        }
    }

    function toggleDropdown() {
        const dropdown = document.getElementById('filtroProyectosDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function cerrarDropdown() {
        document.getElementById('filtroProyectosDropdown').style.display = 'none';
    }

    function renderizarCheckboxesProyectos(proyectos) {
        const lista = document.getElementById('filtroProyectosLista');
        lista.innerHTML = '';
        
        if (!proyectos || proyectos.length === 0) {
            lista.innerHTML = '<div style="padding: 8px 12px; color: #6c757d; font-size: 13px;">No hay proyectos disponibles</div>';
            return;
        }
        
        const selected = getProyectosSeleccionados();
        
        proyectos.forEach(proyecto => {
            const checked = selected.includes(String(proyecto.id)) ? 'checked' : '';
            const label = document.createElement('label');
            label.innerHTML = `
                <input type="checkbox" value="${proyecto.id}" ${checked}>
                <span>${proyecto.nombre}</span>
            `;
            lista.appendChild(label);
        });
        
        actualizarLabelProyectos();
    }

    function filtrarProyectosLista(busqueda) {
        const labels = document.querySelectorAll('#filtroProyectosLista label');
        const term = busqueda.toLowerCase().trim();
        
        labels.forEach(label => {
            const text = label.textContent.toLowerCase();
            label.style.display = text.includes(term) ? 'flex' : 'none';
        });
    }

    function seleccionarTodosProyectos() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]');
        const visibles = document.querySelectorAll('#filtroProyectosLista label[style*="display: none"]');
        const todosVisibles = document.querySelectorAll('#filtroProyectosLista label:not([style*="display: none"])');
        
        // Seleccionar solo los visibles
        todosVisibles.forEach(label => {
            const cb = label.querySelector('input[type="checkbox"]');
            if (cb) cb.checked = true;
        });
        
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function deseleccionarTodosProyectos() {
        const checkboxes = document.querySelectorAll('#filtroProyectosLista input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
        actualizarLabelProyectos();
        aplicarFiltroProyectos();
    }

    function aplicarFiltroProyectos() {
        currentFilters.page = 1;
        cargarCostos();
    }

    // ============================================
    // CATÁLOGOS PARA SELECTS EN MODALES
    // ============================================

    async function cargarCatalogos() {
        try {
            const proyectosResp = await fetch(`${API_BASE}/catalogos/proyectos`, {
                headers: { 'Accept': 'application/json' }
            });
            const proyectosResult = await proyectosResp.json();
            
            if (proyectosResult.success) {
                const selectAgregar = document.getElementById('campoProyecto');
                const selectEditar = document.getElementById('editProyecto');
                const options = proyectosResult.data.map(p => 
                    `<option value="${p.id}">${p.nombre}</option>`
                ).join('');
                selectAgregar.innerHTML = `<option value="">Seleccionar proyecto</option>${options}`;
                selectEditar.innerHTML = `<option value="">Seleccionar proyecto</option>${options}`;
                
                // Guardar lista para el filtro
                proyectosLista = proyectosResult.data;
                renderizarCheckboxesProyectos(proyectosLista);
            }
            
            const proveedoresResp = await fetch(`${API_BASE}/catalogos/proveedores`, {
                headers: { 'Accept': 'application/json' }
            });
            const proveedoresResult = await proveedoresResp.json();
            
            if (proveedoresResult.success) {
                const selectAgregar = document.getElementById('campoProveedor');
                const selectEditar = document.getElementById('editProveedor');
                const options = proveedoresResult.data.map(p => 
                    `<option value="${p.id}">${p.nombre} ${p.rfc ? '- ' + p.rfc : ''}</option>`
                ).join('');
                selectAgregar.innerHTML = `<option value="">Seleccionar proveedor</option>${options}`;
                selectEditar.innerHTML = `<option value="">Seleccionar proveedor</option>${options}`;
            }
        } catch (error) {
            console.error('Error cargando catálogos:', error);
        }
    }

    // ============================================
    // RENDERIZADO
    // ============================================

    function renderizarTabla(costos) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const tablaContainer = document.getElementById('tablaContainer');
        const textoAgrupar = document.getElementById('textoAgrupar');
        
        if (!tbody) return;
        
        if (textoAgrupar) {
            textoAgrupar.style.display = columnasAgrupadas.length > 0 ? 'none' : 'inline';
        }
        
        const { grupos } = agruparDatos(costos, columnasAgrupadas);
        const hayGrupos = grupos.length > 0 && columnasAgrupadas.length > 0;
        
        tbody.innerHTML = '';
        
        if (!costos || costos.length === 0) {
            sinDatos.style.display = 'block';
            tablaContainer.style.display = 'none';
            document.getElementById('tablaFoot').style.display = 'none';
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
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;" colspan="18">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <i class="fas fa-caret-right" style="margin-right: 8px; color: #2378e1;"></i>
                                <strong style="color: #2378e1;">${grupo.valor}</strong>
                                <span style="color: #6c757d; font-size: 11px; margin-left: 10px;">
                                    (${grupo.items.length} registros - Total: ${formatCurrency(grupo.totalGeneral)})
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
            
            costos.forEach(item => {
                tbody.appendChild(crearFila(item));
            });
        }
    }

    function crearFila(item) {
        const row = document.createElement('tr');
        const badgeClass = getEstatusBadge(item.estatus_pago);
        
        const cantidad = parseFloat(item.cantidad) || 0;
        const precioUnitario = parseFloat(item.precio_unitario) || 0;
        const subtotal = parseFloat(item.subtotal) || 0;
        const iva = parseFloat(item.iva) || 0;
        const total = parseFloat(item.total) || 0;
        
        row.innerHTML = `
            <td style="padding: 10px 4px;">${item.proyecto?.nombre || '-'}</td>
            <td style="padding: 10px 4px;">${item.categoria_nombre || '-'}</td>
            <td style="padding: 10px 4px;">${item.concepto || '-'}</td>
            <td style="padding: 10px 4px;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 4px;">${item.nombre_proveedor || '-'}</td>
            <td style="padding: 10px 4px;">${item.rfc || '-'}</td>
            <td style="padding: 10px 4px;">${item.factura || '-'}</td>
            <td style="padding: 10px 4px;">${item.descripcion || '-'}</td>
            <td style="padding: 10px 4px;">${item.unidad || '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${cantidad ? cantidad.toFixed(2) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${precioUnitario ? formatCurrency(precioUnitario) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${subtotal ? formatCurrency(subtotal) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${iva ? formatCurrency(iva) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right; font-weight: 600; color: #083CAE;">${total ? formatCurrency(total) : '-'}</td>
            <td style="padding: 10px 4px;">${formatDate(item.fecha_pago)}</td>
            <td style="padding: 10px 4px;"><span class="badge ${badgeClass}">${item.estatus_nombre || '-'}</span></td>
            <td style="padding: 10px 4px;">${item.observaciones || '-'}</td>
            <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarCosto(${item.id})"></i>
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarCosto(${item.id})"></i>
                </div>
            </td>
        `;
        return row;
    }

    function crearFilaDetalle(item) {
        const row = document.createElement('tr');
        row.className = 'fila-detalle';
        const badgeClass = getEstatusBadge(item.estatus_pago);
        
        const cantidad = parseFloat(item.cantidad) || 0;
        const precioUnitario = parseFloat(item.precio_unitario) || 0;
        const subtotal = parseFloat(item.subtotal) || 0;
        const iva = parseFloat(item.iva) || 0;
        const total = parseFloat(item.total) || 0;
        
        row.innerHTML = `
            <td style="padding: 10px 4px; padding-left: 30px;">${item.proyecto?.nombre || '-'}</td>
            <td style="padding: 10px 4px;">${item.categoria_nombre || '-'}</td>
            <td style="padding: 10px 4px;">${item.concepto || '-'}</td>
            <td style="padding: 10px 4px;">${formatDate(item.fecha)}</td>
            <td style="padding: 10px 4px;">${item.nombre_proveedor || '-'}</td>
            <td style="padding: 10px 4px;">${item.rfc || '-'}</td>
            <td style="padding: 10px 4px;">${item.factura || '-'}</td>
            <td style="padding: 10px 4px;">${item.descripcion || '-'}</td>
            <td style="padding: 10px 4px;">${item.unidad || '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${cantidad ? cantidad.toFixed(2) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${precioUnitario ? formatCurrency(precioUnitario) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${subtotal ? formatCurrency(subtotal) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right;">${iva ? formatCurrency(iva) : '-'}</td>
            <td style="padding: 10px 4px; text-align: right; font-weight: 600; color: #083CAE;">${total ? formatCurrency(total) : '-'}</td>
            <td style="padding: 10px 4px;">${formatDate(item.fecha_pago)}</td>
            <td style="padding: 10px 4px;"><span class="badge ${badgeClass}">${item.estatus_nombre || '-'}</span></td>
            <td style="padding: 10px 4px;">${item.observaciones || '-'}</td>
            <td style="padding: 10px 4px; background-color: white; position: sticky; right: 0;">
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle" onclick="verDetalle(${item.id})"></i>
                    <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar" onclick="editarCosto(${item.id})"></i>
                    <i class="fas fa-trash-alt" style="color: #dc3545; cursor: pointer; font-size: 14px;" title="Eliminar" onclick="eliminarCosto(${item.id})"></i>
                </div>
            </td>
        `;
        return row;
    }

    function actualizarEstadisticas(stats) {
        if (!stats) return;
        document.getElementById('totalDirectos').textContent = formatCurrency(stats.total_directos || 0);
        document.getElementById('totalMateriales').textContent = formatCurrency(stats.total_materiales || 0);
        document.getElementById('totalManoObra').textContent = formatCurrency(stats.total_mano_obra || 0);
        document.getElementById('totalMaquinaria').textContent = formatCurrency(stats.total_maquinaria || 0);
    }

    function calcularTotales(costos) {
        let totalSubtotal = 0, totalIva = 0, totalGeneral = 0;
        costos.forEach(item => {
            totalSubtotal += parseFloat(item.subtotal) || 0;
            totalIva += parseFloat(item.iva) || 0;
            totalGeneral += parseFloat(item.total) || 0;
        });
        document.getElementById('sumSubtotal').textContent = formatCurrency(totalSubtotal);
        document.getElementById('sumIva').textContent = formatCurrency(totalIva);
        document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
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

    function formatDate(dateString) {
        if (!dateString) return '-';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        } catch {
            return '-';
        }
    }

    function getEstatusBadge(estatus) {
        const badges = {
            'pagado': 'badge-pagado',
            'pendiente': 'badge-pendiente',
            'programado': 'badge-programado',
            'vencido': 'badge-vencido'
        };
        return badges[estatus] || 'badge-pendiente';
    }

    function mostrarLoading(show) {
        document.getElementById('loadingSpinner').style.display = show ? 'flex' : 'none';
    }

    function mostrarNotificacion(mensaje, tipo = 'success') {
        const notificacion = document.createElement('div');
        notificacion.className = `toast-notification ${tipo}`;
        const icono = tipo === 'success' ? 'fa-check-circle' : tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        notificacion.innerHTML = `<i class="fas ${icono}"></i> ${mensaje}`;
        document.body.appendChild(notificacion);
        setTimeout(() => notificacion.remove(), 3000);
    }

    // ============================================
    // AGRUPACIÓN
    // ============================================

    function generarGrupoId(item, columnas) {
        return columnas.map(col => {
            switch(col) {
                case 'proyecto': return item.proyecto?.nombre || 'Sin proyecto';
                case 'categoria': return item.categoria_nombre || 'Sin categoría';
                case 'estatus_pago': return item.estatus_nombre || 'Sin estatus';
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
                        case 'proyecto': return item.proyecto?.nombre || 'Sin proyecto';
                        case 'categoria': return item.categoria_nombre || 'Sin categoría';
                        case 'estatus_pago': return item.estatus_nombre || 'Sin estatus';
                        default: return '';
                    }
                }).join(' - ');
                
                gruposMap.set(grupoId, {
                    id: grupoId,
                    valor: valorGrupo,
                    items: [item],
                    totalGeneral: parseFloat(item.total || 0)
                });
            } else {
                const grupo = gruposMap.get(grupoId);
                grupo.items.push(item);
                grupo.totalGeneral += parseFloat(item.total || 0);
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
                    'proyecto': 'Proyecto',
                    'categoria': 'Categoría',
                    'estatus_pago': 'Estatus Pago'
                }[col] || col;
                
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${nombreColumna} <span class="remover" data-columna="${col}">&times;</span>`;
                grupoContainer.appendChild(chip);
            });
        }
        
        expandedGroups.clear();
        cargarCostos();
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
                const item = result.data;
                const badgeClass = getEstatusBadge(item.estatus_pago);
                
                document.getElementById('modalTitulo').textContent = `${item.concepto} - ${item.proyecto?.nombre || 'Sin proyecto'}`;
                
                const contenido = `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proyecto</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.proyecto?.nombre || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Categoría</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.categoria_nombre}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Concepto</div>
                            <div style="font-size: 16px; font-weight: 600;">${item.concepto}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha</div>
                            <div style="font-size: 16px;">${formatDate(item.fecha)}</div>
                        </div>
                    </div>
                    
                    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Cantidad</div>
                                <div style="font-size: 16px; font-weight: 600;">${item.cantidad} ${item.unidad || ''}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Precio Unitario</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(item.precio_unitario)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Subtotal</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(item.subtotal)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">IVA</div>
                                <div style="font-size: 16px; font-weight: 600;">${formatCurrency(item.iva)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Total</div>
                                <div style="font-size: 24px; font-weight: 700; color: #28a745;">${formatCurrency(item.total)}</div>
                            </div>
                            <div>
                                <div style="color: #6c757d; font-size: 11px;">Estatus</div>
                                <div><span class="badge ${badgeClass}">${item.estatus_nombre}</span></div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Proveedor</div>
                            <div style="font-size: 14px;">${item.nombre_proveedor || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">RFC</div>
                            <div style="font-size: 14px;">${item.rfc || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Factura</div>
                            <div style="font-size: 14px;">${item.factura || '-'}</div>
                        </div>
                        <div>
                            <div style="color: #6c757d; font-size: 12px;">Fecha de Pago</div>
                            <div style="font-size: 14px;">${formatDate(item.fecha_pago)}</div>
                        </div>
                    </div>
                    
                    ${item.descripcion ? `
                    <div style="margin-bottom: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Descripción</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;">${item.descripcion}</div>
                    </div>` : ''}
                    
                    ${item.observaciones ? `
                    <div style="margin-bottom: 15px;">
                        <div style="color: #6c757d; font-size: 12px;">Observaciones</div>
                        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; font-size: 13px;">${item.observaciones}</div>
                    </div>` : ''}
                    
                    <div style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 15px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button onclick="cerrarModalDetalle()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
                    </div>
                `;
                
                document.getElementById('modalContenidoDetalle').innerHTML = contenido;
                document.getElementById('modalVerDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el detalle', 'error');
        }
    };

    window.editarCosto = async function(id) {
        try {
            const response = await fetch(`${API_BASE}/${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();
            
            if (result.success) {
                const item = result.data;
                
                document.getElementById('editId').value = item.id;
                document.getElementById('editProyecto').value = item.proyecto_id || '';
                document.getElementById('editCategoria').value = item.categoria || '';
                document.getElementById('editConcepto').value = item.concepto || '';
                document.getElementById('editFecha').value = item.fecha || '';
                document.getElementById('editProveedor').value = item.proveedor_id || '';
                document.getElementById('editRFC').value = item.rfc || '';
                document.getElementById('editFactura').value = item.factura || '';
                document.getElementById('editDescripcion').value = item.descripcion || '';
                document.getElementById('editUnidad').value = item.unidad || '';
                document.getElementById('editCantidad').value = item.cantidad || 0;
                document.getElementById('editPrecioUnitario').value = item.precio_unitario || 0;
                document.getElementById('editSubtotal').value = item.subtotal || 0;
                document.getElementById('editIva').value = item.iva || 0;
                document.getElementById('editTotal').value = item.total || 0;
                document.getElementById('editFechaPago').value = item.fecha_pago || '';
                document.getElementById('editEstatusPago').value = item.estatus_pago || 'pendiente';
                document.getElementById('editObservaciones').value = item.observaciones || '';
                
                document.getElementById('modalEditarCosto').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        } catch (error) {
            mostrarNotificacion('Error al cargar el costo para editar', 'error');
        }
    };

    window.eliminarCosto = function(id) {
        if (!confirm('¿Está seguro de eliminar este costo directo?')) return;
        
        fetch(`${API_BASE}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                mostrarNotificacion(result.message, 'success');
                cargarCostos();
            } else {
                mostrarNotificacion(result.message || 'Error al eliminar', 'error');
            }
        })
        .catch(error => {
            mostrarNotificacion('Error al eliminar el costo', 'error');
        });
    };

    function cerrarModalDetalle() {
        document.getElementById('modalVerDetalle').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    async function exportarExcel() {
        try {
            const proyectosSeleccionados = getProyectosSeleccionados();
            
            const params = new URLSearchParams();
            params.append('busqueda', currentFilters.busqueda || '');
            params.append('categoria', currentFilters.categoria || 'todos');
            params.append('estatus_pago', currentFilters.estatus_pago || '');
            params.append('fecha_inicio', currentFilters.fecha_inicio || '');
            params.append('fecha_fin', currentFilters.fecha_fin || '');
            
            if (proyectosSeleccionados.length > 0) {
                proyectosSeleccionados.forEach(id => {
                    params.append('proyecto_id[]', id);
                });
            }
            
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
                link.download = `CostosDirectos_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(link.href);
                mostrarNotificacion('Exportación completada', 'success');
            }
        } catch (error) {
            mostrarNotificacion('Error al exportar', 'error');
        }
    }

    // ============================================
    // FORMULARIO - CREAR/EDITAR COSTO
    // ============================================

    function calcularSubtotal(campoCantidad, campoPrecio, campoSubtotal) {
        const cantidad = parseFloat(document.getElementById(campoCantidad).value) || 0;
        const precio = parseFloat(document.getElementById(campoPrecio).value) || 0;
        const subtotal = cantidad * precio;
        document.getElementById(campoSubtotal).value = subtotal.toFixed(2);
        calcularTotal(campoSubtotal, 'campoIva', 'campoTotal');
    }

    function calcularTotal(campoSubtotal, campoIva, campoTotal) {
        const subtotal = parseFloat(document.getElementById(campoSubtotal).value) || 0;
        const iva = parseFloat(document.getElementById(campoIva).value) || 0;
        const total = subtotal + iva;
        document.getElementById(campoTotal).value = total.toFixed(2);
    }

    function calcularSubtotalEditar() {
        const cantidad = parseFloat(document.getElementById('editCantidad').value) || 0;
        const precio = parseFloat(document.getElementById('editPrecioUnitario').value) || 0;
        const subtotal = cantidad * precio;
        document.getElementById('editSubtotal').value = subtotal.toFixed(2);
        calcularTotalEditar();
    }

    function calcularTotalEditar() {
        const subtotal = parseFloat(document.getElementById('editSubtotal').value) || 0;
        const iva = parseFloat(document.getElementById('editIva').value) || 0;
        const total = subtotal + iva;
        document.getElementById('editTotal').value = total.toFixed(2);
    }

    function abrirModalAgregar() {
        document.getElementById('modalAgregarCosto').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('formAgregarCosto').reset();
        document.getElementById('campoSubtotal').value = '0.00';
        document.getElementById('campoIva').value = '0.00';
        document.getElementById('campoTotal').value = '0.00';
        document.getElementById('campoCantidad').value = '1.00';
        document.getElementById('campoPrecioUnitario').value = '0.00';
        
        const hoy = new Date();
        document.getElementById('campoFecha').value = hoy.toISOString().split('T')[0];
        document.getElementById('campoFechaPago').value = hoy.toISOString().split('T')[0];
    }

    function cerrarModalAgregar() {
        document.getElementById('modalAgregarCosto').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function cerrarModalEditar() {
        document.getElementById('modalEditarCosto').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // ============================================
    // EVENTOS E INICIALIZACIÓN
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - API_BASE:', API_BASE);
        
        const hoy = new Date();
        const seisMesesAtras = new Date();
        seisMesesAtras.setMonth(hoy.getMonth() - 6);
        document.getElementById('fechaInicio').value = seisMesesAtras.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];
        currentFilters.fecha_inicio = document.getElementById('fechaInicio').value;
        currentFilters.fecha_fin = document.getElementById('fechaFin').value;
        
        setupDragAndDrop();
        cargarCatalogos();
        cargarCostos();
        
        // Eventos del dropdown de proyectos
        document.getElementById('btnFiltroProyectos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });
        
        document.getElementById('btnCerrarFiltro')?.addEventListener('click', function(e) {
            e.stopPropagation();
            cerrarDropdown();
        });
        
        document.getElementById('btnSeleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            seleccionarTodosProyectos();
        });
        
        document.getElementById('btnDeseleccionarTodos')?.addEventListener('click', function(e) {
            e.stopPropagation();
            deseleccionarTodosProyectos();
        });
        
        document.getElementById('filtroProyectosBuscar')?.addEventListener('input', function(e) {
            e.stopPropagation();
            filtrarProyectosLista(this.value);
        });
        
        // Delegación de eventos para checkboxes
        document.getElementById('filtroProyectosLista')?.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                actualizarLabelProyectos();
                aplicarFiltroProyectos();
            }
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            const container = document.getElementById('proyectoFilterContainer');
            if (container && !container.contains(e.target)) {
                cerrarDropdown();
            }
        });
        
        // Eventos de búsqueda y filtros
        document.getElementById('buscador')?.addEventListener('input', (e) => {
            currentFilters.busqueda = e.target.value;
            currentFilters.page = 1;
            cargarCostos();
        });
        
        document.getElementById('fechaInicio')?.addEventListener('change', (e) => {
            currentFilters.fecha_inicio = e.target.value;
            currentFilters.page = 1;
            cargarCostos();
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', (e) => {
            currentFilters.fecha_fin = e.target.value;
            currentFilters.page = 1;
            cargarCostos();
        });
        
        // Botones principales
        document.getElementById('btnAgregarCosto')?.addEventListener('click', abrirModalAgregar);
        document.getElementById('btnExcel')?.addEventListener('click', exportarExcel);
        document.getElementById('btnColumnas')?.addEventListener('click', () => {
            mostrarNotificacion('Selector de columnas en desarrollo', 'warning');
        });
        
        // Paginación
        document.getElementById('btnPrimera')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = 1; cargarCostos(); }
        });
        document.getElementById('btnAnterior')?.addEventListener('click', () => {
            if (currentPage > 1) { currentFilters.page = currentPage - 1; cargarCostos(); }
        });
        document.getElementById('btnSiguiente')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = currentPage + 1; cargarCostos(); }
        });
        document.getElementById('btnUltima')?.addEventListener('click', () => {
            if (currentPage < totalPages) { currentFilters.page = totalPages; cargarCostos(); }
        });
        
        // Modales
        document.getElementById('btnCerrarModalAgregar')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCancelarAgregar')?.addEventListener('click', cerrarModalAgregar);
        document.getElementById('btnCerrarModalEditar')?.addEventListener('click', cerrarModalEditar);
        document.getElementById('btnCancelarEditar')?.addEventListener('click', cerrarModalEditar);
        document.getElementById('btnCerrarModalDetalle')?.addEventListener('click', cerrarModalDetalle);
        
        // Cálculo automático
        document.getElementById('campoCantidad')?.addEventListener('input', function() {
            calcularSubtotal('campoCantidad', 'campoPrecioUnitario', 'campoSubtotal');
        });
        document.getElementById('campoPrecioUnitario')?.addEventListener('input', function() {
            calcularSubtotal('campoCantidad', 'campoPrecioUnitario', 'campoSubtotal');
        });
        document.getElementById('campoIva')?.addEventListener('input', function() {
            calcularTotal('campoSubtotal', 'campoIva', 'campoTotal');
        });
        
        document.getElementById('editCantidad')?.addEventListener('input', calcularSubtotalEditar);
        document.getElementById('editPrecioUnitario')?.addEventListener('input', calcularSubtotalEditar);
        document.getElementById('editIva')?.addEventListener('input', calcularTotalEditar);
        
        // Submit forms
        document.getElementById('formAgregarCosto')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(API_BASE, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalAgregar();
                    cargarCostos();
                } else {
                    mostrarNotificacion(result.message || 'Error al guardar', 'error');
                }
            })
            .catch(error => {
                mostrarNotificacion('Error al guardar el costo', 'error');
            });
        });
        
        document.getElementById('formEditarCosto')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const formData = new FormData(this);
            
            fetch(`${API_BASE}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarNotificacion(result.message, 'success');
                    cerrarModalEditar();
                    cargarCostos();
                } else {
                    mostrarNotificacion(result.message || 'Error al actualizar', 'error');
                }
            })
            .catch(error => {
                mostrarNotificacion('Error al actualizar el costo', 'error');
            });
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', (event) => {
            const modalAgregar = document.getElementById('modalAgregarCosto');
            const modalEditar = document.getElementById('modalEditarCosto');
            const modalVer = document.getElementById('modalVerDetalle');
            
            if (event.target === modalAgregar) cerrarModalAgregar();
            if (event.target === modalEditar) cerrarModalEditar();
            if (event.target === modalVer) cerrarModalDetalle();
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
                cargarCostos();
            }
        });
    });
</script>
@endsection