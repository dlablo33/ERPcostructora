@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-exchange-alt"></i> Entradas y Salidas de Almacén
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros y Buscador -->
                <div style="background-color: #f8f9fa; border: 1px solid #e3e6ea; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; align-items: end;">
                        <div>
                            <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 4px;">
                                <i class="fas fa-calendar-alt"></i> Fecha Inicio
                            </label>
                            <input type="date" id="fechaInicio" class="form-control" style="width: 100%; padding: 7px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;" value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 4px;">
                                <i class="fas fa-calendar-alt"></i> Fecha Fin
                            </label>
                            <input type="date" id="fechaFin" class="form-control" style="width: 100%; padding: 7px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;" value="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 4px;">
                                <i class="fas fa-project-diagram"></i> Proyecto
                            </label>
                            <select id="filtroProyecto" style="width: 100%; padding: 7px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <option value="">Todos los proyectos</option>
                                @isset($proyectos)
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d; margin-bottom: 4px;">
                                <i class="fas fa-search"></i> Buscar
                            </label>
                            <div style="position: relative;">
                                <input type="text" id="filtroBusqueda" placeholder="Folio, artículo, solicitante..." style="width: 100%; padding: 7px 30px 7px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px;">
                                <i class="fas fa-search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 12px;"></i>
                            </div>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer; flex: 1; font-size: 12px; font-weight: 600;">
                                <i class="fas fa-sync-alt"></i> Filtrar
                            </button>
                            <button id="btnLimpiarFiltros" title="Limpiar filtros" style="background-color: white; color: #6c757d; border: 1px solid #ced4da; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-eraser"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pestañas -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-btn active" onclick="switchTab('entradas')" id="tabEntradas" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-down" style="color: #28a745; margin-right: 5px;"></i> Entradas
                    </button>
                    <button class="tab-btn" onclick="switchTab('salidas')" id="tabSalidas" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-arrow-up" style="color: #dc3545; margin-right: 5px;"></i> Salidas
                    </button>
                </div>

                <!-- Panel Entradas -->
                <div id="panelEntradas" style="display: block;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarEntrada" class="btn-agregar" onclick="abrirModalMovimiento('entrada')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Entrada
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaEntradas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unit.</th>
                                    <th>Importe</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyEntradas">
                                <tr><td colspan="12" style="text-align: center; padding: 30px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraEntrada" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorEntrada" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualEntrada">1</span> de <span id="totalPaginasEntrada">1</span></span>
                        <button class="page-btn" id="btnSiguienteEntrada" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaEntrada" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaEntrada" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                <!-- Panel Salidas -->
                <div id="panelSalidas" style="display: none;">
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                        <button id="btnAgregarSalida" class="btn-agregar" onclick="abrirModalMovimiento('salida')" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 15px; cursor: pointer; color: var(--color-primary);">
                            <i class="fas fa-plus"></i> Nueva Salida
                        </button>
                        
                    </div>

                    <div class="table-container">
                        <table class="table" id="tablaSalidas">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Proyecto</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unit.</th>
                                    <th>Importe</th>
                                    <th>Almacén</th>
                                    <th>Referencia</th>
                                    <th>Solicitante</th>
                                    <th>Observaciones</th>
                                    <th>Registrado por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodySalidas">
                                <tr><td colspan="13" style="text-align: center; padding: 30px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        <button class="page-btn" id="btnPrimeraSalida" disabled><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" id="btnAnteriorSalida" disabled><i class="fas fa-angle-left"></i></button>
                        <span>Página <span id="paginaActualSalida">1</span> de <span id="totalPaginasSalida">1</span></span>
                        <button class="page-btn" id="btnSiguienteSalida" disabled><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" id="btnUltimaSalida" disabled><i class="fas fa-angle-double-right"></i></button>
                        <select id="porPaginaSalida" style="padding: 5px; border-radius: 4px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA MOVIMIENTO (ENTRADA/SALIDA) -->
<div id="modalMovimiento" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 650px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTituloMovimiento">Nuevo Movimiento</h3>
            <button onclick="cerrarModalMovimiento()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="movimientoTipo">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div id="divOrigenEntrada" style="grid-column: span 2; display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Origen de la Entrada <span style="color: red;">*</span></label>
                    <select id="modalOrigenEntrada" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="manual">📝 Entrada Manual</option>
                        <option value="compra">🛒 De Compra Autorizada</option>
                        <option value="devolucion">🔄 Devolución de obra</option>
                    </select>
                </div>

                <div id="panelCompra" style="display: none; grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Seleccionar Orden de Compra <span style="color: red;">*</span></label>
                    <select id="modalCompra" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Cargando compras pendientes...</option>
                    </select>
                    <button type="button" id="btnVerArticulosCompra" style="margin-top: 8px; background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 6px 12px; font-size: 12px; cursor: pointer;">
                        <i class="fas fa-boxes"></i> Ver artículos de esta compra
                    </button>
                </div>

                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto <span style="color: red;">*</span></label>
                    <select id="modalProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar proyecto</option>
                        @isset($proyectos)
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha <span style="color: red;">*</span></label>
                    <input type="date" id="modalFecha" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Artículo <span style="color: red;">*</span></label>
                    <select id="modalArticulo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar artículo</option>
                        @isset($articulos)
                            @foreach($articulos as $articulo)
                                <option value="{{ $articulo->id }}">{{ $articulo->codigo }} - {{ $articulo->descripcion }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Almacén <span style="color: red;">*</span></label>
                    <select id="modalAlmacen" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar almacén</option>
                        @isset($almacenes)
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->codigo }} - {{ $almacen->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cantidad <span style="color: red;">*</span></label>
                    <input type="number" step="0.001" id="modalCantidad" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div id="divCosto" style="display: none;">
                    <label style="font-size: 13px; font-weight: 600;">Costo Unitario</label>
                    <input type="number" step="0.01" id="modalCosto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;" readonly placeholder="Se carga automáticamente">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Referencia</label>
                    <input type="text" id="modalReferencia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Factura, orden, etc.">
                </div>
                <div id="divSolicitante" style="display: none; grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Solicitante</label>
                    <input type="text" id="modalSolicitante" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre de quien solicita">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="modalObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalMovimiento()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarMovimiento()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER ARTÍCULOS DE LA COMPRA (MÚLTIPLES) -->
<div id="modalArticulosCompra" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100001; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 950px; max-height: 85vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;"><i class="fas fa-boxes"></i> Artículos de la Orden de Compra</h3>
            <button onclick="cerrarModalArticulos()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <div id="infoCompraResumen" style="background-color: #e8f0fe; border-radius: 8px; padding: 12px; margin-bottom: 20px;"></div>
            
            <div class="table-container">
                <table class="table" id="tablaArticulosCompra">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" id="seleccionarTodosArticulos" style="transform: scale(1.2);"></th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th style="text-align: center;">Pendiente</th>
                            <th style="text-align: center;">Costo Unit.</th>
                            <th style="text-align: center;">Importe</th>
                            <th style="text-align: center; min-width: 100px;">A Recibir</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody id="tablaArticulosCompraBody">
                        <tr><td colspan="9" style="text-align: center;">Seleccione una compra primero</td></tr>
                    </tbody>
                    <tfoot style="background-color: #e9ecef; font-weight: bold;">
                        <tr>
                            <td colspan="4" style="text-align: right;">Totales:</td>
                            <td id="totalPendienteCompra" style="text-align: center;">0</td>
                            <td style="text-align: center;">---</td>
                            <td id="totalImporteCompra" style="text-align: center;">$0</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalArticulos()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button id="btnRegistrarRecepcionMultiple" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                    <i class="fas fa-save"></i> Registrar Recepción
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE DEL MOVIMIENTO (MEJORADO) -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 100002; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 12px; width: 95%; max-width: 720px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <!-- Header dinámico -->
        <div id="detalleHeader" style="padding: 20px 25px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, var(--color-primary), #1a5fdc);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div id="detalleIconoHeader" style="width: 45px; height: 45px; border-radius: 50%; background-color: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div>
                    <h3 style="color: white; margin: 0; font-size: 18px;" id="detalleTituloTipo">Movimiento #0</h3>
                    <small style="color: rgba(255,255,255,0.8); font-size: 12px;" id="detalleSubtitulo">Detalle del movimiento</small>
                </div>
            </div>
            <button onclick="cerrarModalDetalle()" style="background: rgba(255,255,255,0.15); border: none; color: white; font-size: 18px; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">✕</button>
        </div>

        <!-- Contenido -->
        <div style="padding: 25px;">
            <!-- Badge de tipo + Fecha -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <span id="detalleBadgeTipo" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700;">-</span>
                <span style="color: #6c757d; font-size: 13px;">
                    <i class="fas fa-clock"></i> <span id="detalleFecha">-</span>
                </span>
            </div>

            <!-- Grid de información principal -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 12px 15px; border-left: 3px solid var(--color-primary);">
                    <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        <i class="fas fa-project-diagram"></i> Proyecto
                    </div>
                    <div style="font-size: 14px; font-weight: 600; color: #212529;" id="detalleProyecto">-</div>
                </div>
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 12px 15px; border-left: 3px solid #17a2b8;">
                    <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">
                        <i class="fas fa-warehouse"></i> Almacén
                    </div>
                    <div style="font-size: 14px; font-weight: 600; color: #212529;" id="detalleAlmacen">-</div>
                </div>
            </div>

            <!-- Artículo -->
            <div style="background-color: #e8f0fe; border-radius: 8px; padding: 15px; margin-bottom: 20px; border-left: 4px solid var(--color-primary);">
                <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">
                    <i class="fas fa-box"></i> Artículo
                </div>
                <div style="font-size: 15px; font-weight: 700; color: #083CAE;" id="detalleArticuloCodigo">-</div>
                <div style="font-size: 13px; color: #495057; margin-top: 2px;" id="detalleArticuloDescripcion">-</div>
            </div>

            <!-- Cantidades y costos -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;">
                <div style="text-align: center; background-color: #fff; border: 1px solid #e3e6ea; border-radius: 8px; padding: 15px;">
                    <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Cantidad</div>
                    <div style="font-size: 20px; font-weight: 700; color: #083CAE;" id="detalleCantidad">0</div>
                    <div style="font-size: 11px; color: #6c757d;" id="detalleUnidad">-</div>
                </div>
                <div style="text-align: center; background-color: #fff; border: 1px solid #e3e6ea; border-radius: 8px; padding: 15px;">
                    <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Costo Unit.</div>
                    <div style="font-size: 20px; font-weight: 700; color: #28a745;" id="detalleCosto">$0.00</div>
                    <div style="font-size: 11px; color: #6c757d;">por unidad</div>
                </div>
                <div style="text-align: center; background-color: #fff; border: 1px solid #e3e6ea; border-radius: 8px; padding: 15px;">
                    <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Importe</div>
                    <div style="font-size: 20px; font-weight: 700; color: #ff6b00;" id="detalleImporte">$0.00</div>
                    <div style="font-size: 11px; color: #6c757d;">total</div>
                </div>
            </div>

            <!-- Stock antes/después -->
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <div style="font-size: 12px; font-weight: 700; color: #495057; margin-bottom: 12px; text-transform: uppercase;">
                    <i class="fas fa-chart-line"></i> Movimiento de Stock
                </div>
                <div style="display: flex; align-items: center; justify-content: space-around;">
                    <div style="text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; margin-bottom: 4px;">ANTES</div>
                        <div style="font-size: 22px; font-weight: 700; color: #6c757d;" id="detalleCantidadAntes">0</div>
                    </div>
                    <div style="font-size: 24px; color: var(--color-primary);">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; margin-bottom: 4px;">DESPUÉS</div>
                        <div style="font-size: 22px; font-weight: 700; color: var(--color-primary);" id="detalleCantidadDespues">0</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 11px; color: #6c757d; margin-bottom: 4px;">DIFERENCIA</div>
                        <div style="font-size: 22px; font-weight: 700;" id="detalleDiferencia">0</div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div style="border-top: 1px solid #e3e6ea; padding-top: 18px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 3px;">
                            <i class="fas fa-file-alt"></i> Referencia
                        </div>
                        <div style="font-size: 13px; color: #212529;" id="detalleReferencia">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 3px;">
                            <i class="fas fa-user"></i> Solicitante
                        </div>
                        <div style="font-size: 13px; color: #212529;" id="detalleSolicitante">-</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 3px;">
                            <i class="fas fa-comment"></i> Observaciones
                        </div>
                        <div style="font-size: 13px; color: #212529; background-color: #f8f9fa; padding: 10px; border-radius: 6px; min-height: 20px;" id="detalleObservaciones">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 3px;">
                            <i class="fas fa-user-check"></i> Registrado por
                        </div>
                        <div style="font-size: 13px; color: #212529;" id="detalleCreadoPor">-</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; margin-bottom: 3px;">
                            <i class="fas fa-hashtag"></i> ID Movimiento
                        </div>
                        <div style="font-size: 13px; color: #212529; font-weight: 600;" id="detalleId">-</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="padding: 15px 25px; background-color: #f8f9fa; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #e3e6ea;">
            <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 6px; background: white; cursor: pointer; font-weight: 600; font-size: 13px; color: #495057;">
                <i class="fas fa-times"></i> Cerrar
            </button>
            <button onclick="imprimirDetalle()" style="padding: 8px 20px; border: none; border-radius: 6px; background: var(--color-primary); color: white; cursor: pointer; font-weight: 600; font-size: 13px;">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; z-index: 10; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; vertical-align: middle; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; transition: background-color 0.15s; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .page-btn:not(:disabled):hover { background-color: var(--color-primary); color: white; }
    .btn-agregar:hover, .btn-excel:hover { background-color: var(--color-primary) !important; color: white !important; }
    .cantidad-recibir { width: 100px; text-align: center; }
    .cantidad-recibir input { width: 100%; padding: 5px; text-align: center; }
    .badge-pendiente { background-color: #ffc107; color: #212529; padding: 2px 8px; border-radius: 20px; font-size: 11px; }
    
    /* Botón de acción ver detalle */
    .btn-ver-detalle {
        background-color: #e8f0fe;
        color: var(--color-primary);
        border: 1px solid #c9dcf7;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }
    .btn-ver-detalle:hover {
        background-color: var(--color-primary);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(8,60,174,0.25);
    }
    
    /* Badges de tipo de movimiento en tabla */
    .badge-tipo {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-entrada { background-color: #d4edda; color: #155724; }
    .badge-salida { background-color: #f8d7da; color: #721c24; }
    
    @media (max-width: 768px) { 
        div[style*="grid-template-columns: repeat(5, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; }
        div[style*="grid-template-columns: repeat(3, 1fr)"] { grid-template-columns: 1fr !important; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let movimientoTipo = 'entrada';
let currentPageEntrada = 1, currentPageSalida = 1;
let perPageEntrada = 10, perPageSalida = 10;
let articulosCompraData = [];
let compraSeleccionadaId = null;
let movimientoDetalleActual = null;

document.addEventListener('DOMContentLoaded', function() {
    cargarMovimientos('entrada');
    cargarMovimientos('salida');
    configurarEventos();
    
    const origenSelect = document.getElementById('modalOrigenEntrada');
    if (origenSelect) {
        origenSelect.addEventListener('change', function() {
            const panelCompra = document.getElementById('panelCompra');
            const divCosto = document.getElementById('divCosto');
            const campoReferencia = document.getElementById('modalReferencia');
            const selectArticulo = document.getElementById('modalArticulo');
            
            if (this.value === 'compra') {
                panelCompra.style.display = 'block';
                divCosto.style.display = 'block';
                campoReferencia.placeholder = 'Se asigna automáticamente';
                campoReferencia.readOnly = true;
                selectArticulo.disabled = true;
                selectArticulo.value = '';
                cargarComprasPendientes();
            } else {
                panelCompra.style.display = 'none';
                divCosto.style.display = 'none';
                campoReferencia.placeholder = 'Factura, orden, etc.';
                campoReferencia.readOnly = false;
                selectArticulo.disabled = false;
                document.getElementById('modalCosto').value = '';
            }
        });
    }
    
    document.getElementById('btnVerArticulosCompra')?.addEventListener('click', function() {
        const compraSelect = document.getElementById('modalCompra');
        const compraId = compraSelect.value;
        if (!compraId) {
            alert('⚠️ Seleccione una orden de compra primero');
            return;
        }
        abrirModalArticulosCompra(compraId);
    });
    
    document.getElementById('seleccionarTodosArticulos')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('#tablaArticulosCompraBody .chk-articulo-compra');
        checkboxes.forEach(chk => chk.checked = this.checked);
    });
    
    document.getElementById('btnRegistrarRecepcionMultiple')?.addEventListener('click', registrarRecepcionMultiple);
});

function cargarMovimientos(tipo) {
    const fechaInicio = document.getElementById('fechaInicio')?.value || '';
    const fechaFin = document.getElementById('fechaFin')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    const search = document.getElementById('filtroBusqueda')?.value || '';
    const currentPage = tipo === 'entrada' ? currentPageEntrada : currentPageSalida;
    const perPage = tipo === 'entrada' ? perPageEntrada : perPageSalida;
    
    let url = `/inventario/api/movimientos?tipo=${tipo === 'entrada' ? 'Entrada' : 'Salida'}&page=${currentPage}&per_page=${perPage}`;
    if (fechaInicio) url += `&fecha_inicio=${encodeURIComponent(fechaInicio)}`;
    if (fechaFin) url += `&fecha_fin=${encodeURIComponent(fechaFin)}`;
    if (proyectoId) url += `&proyecto_id=${encodeURIComponent(proyectoId)}`;
    if (search) url += `&search=${encodeURIComponent(search)}`;
    
    const tbody = document.getElementById(`tablaBody${tipo === 'entrada' ? 'Entradas' : 'Salidas'}`);
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="${tipo === 'entrada' ? '12' : '13'}" style="text-align: center; padding: 30px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>`;
    }
    
    fetch(url)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                renderizarTabla(tipo, response.data);
                actualizarPaginacion(tipo, response.current_page, response.last_page, response.total);
            } else {
                tbody.innerHTML = `<tr><td colspan="${tipo === 'entrada' ? '12' : '13'}" style="text-align: center; padding: 30px; color: #dc3545;">Error: ${response.message || 'Desconocido'}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="${tipo === 'entrada' ? '12' : '13'}" style="text-align: center; padding: 30px; color: #dc3545;">Error de conexión</td></tr>`;
        });
}

function renderizarTabla(tipo, data) {
    const tbody = document.getElementById(`tablaBody${tipo === 'entrada' ? 'Entradas' : 'Salidas'}`);
    const colspan = tipo === 'entrada' ? 12 : 13;
    
    if (!data || !data.length) {
        tbody.innerHTML = `<tr><td colspan="${colspan}" style="text-align: center; padding: 40px; color: #6c757d;">
            <i class="fas fa-inbox" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
            No hay movimientos registrados con los filtros actuales
        </td></tr>`;
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const row = tbody.insertRow();
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        
        // ID
        row.insertCell(0).innerHTML = `<strong style="color: var(--color-primary);">#${item.id}</strong>`;
        
        // Fecha
        row.insertCell(1).innerHTML = `<i class="far fa-clock" style="color:#6c757d; margin-right:4px;"></i>${item.fecha_movimiento}`;
        
        // Proyecto
        row.insertCell(2).innerHTML = item.proyecto_nombre 
            ? `<div style="font-weight:600; font-size:12px;">${item.proyecto_codigo || ''}</div><div style="font-size:11px; color:#6c757d;">${item.proyecto_nombre}</div>`
            : '---';
        
        // Artículo
        row.insertCell(3).innerHTML = `<div style="font-weight:600; color: var(--color-primary); font-size:12px;">${item.articulo_codigo || '---'}</div><div style="font-size:11px; color:#6c757d; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="${item.articulo_descripcion || ''}">${item.articulo_descripcion || ''}</div>`;
        
        // Cantidad
        row.insertCell(4).innerHTML = `<span style="font-weight:700; color:#083CAE;">${item.cantidad}</span> <small style="color:#6c757d;">${item.unidad_medida || ''}</small>`;
        
        // Costo Unit
        row.insertCell(5).innerHTML = item.costo_unitario ? `$${parseFloat(item.costo_unitario).toFixed(2)}` : '---';
        
        // Importe
        row.insertCell(6).innerHTML = item.importe ? `<strong style="color:#28a745;">$${parseFloat(item.importe).toFixed(2)}</strong>` : '---';
        
        // Almacén
        row.insertCell(7).innerHTML = item.almacen_nombre ? `<i class="fas fa-warehouse" style="color:#17a2b8; margin-right:4px;"></i>${item.almacen_nombre}` : '---';
        
        // Referencia
        row.insertCell(8).innerHTML = item.referencia_folio 
            ? `<span style="background:#e8f0fe; color:var(--color-primary); padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">${item.referencia_folio}</span>` 
            : '---';
        
        if (tipo === 'salida') {
            // Solicitante
            row.insertCell(9).innerHTML = item.solicitante || '---';
            // Observaciones
            row.insertCell(10).innerHTML = item.observaciones 
                ? `<span title="${item.observaciones}" style="display:inline-block; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${item.observaciones}</span>` 
                : '---';
            // Registrado por
            row.insertCell(11).innerHTML = item.creado_por || '---';
        } else {
            // Observaciones
            row.insertCell(9).innerHTML = item.observaciones 
                ? `<span title="${item.observaciones}" style="display:inline-block; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${item.observaciones}</span>` 
                : '---';
            // Registrado por
            row.insertCell(10).innerHTML = item.creado_por || '---';
        }
        
        // Acciones - Botón mejorado
        const accionesCell = row.insertCell(tipo === 'entrada' ? 11 : 12);
        accionesCell.style.textAlign = 'center';
        accionesCell.innerHTML = `
            <button class="btn-ver-detalle" onclick="verDetalle(${item.id})" title="Ver detalle completo">
                <i class="fas fa-eye"></i> Ver
            </button>
        `;
    });
}

function actualizarPaginacion(tipo, currentPage, lastPage, total) {
    const prefix = tipo === 'entrada' ? 'Entrada' : 'Salida';
    document.getElementById(`paginaActual${prefix}`).textContent = currentPage;
    document.getElementById(`totalPaginas${prefix}`).textContent = lastPage;
    document.getElementById(`btnPrimera${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnAnterior${prefix}`).disabled = currentPage === 1;
    document.getElementById(`btnSiguiente${prefix}`).disabled = currentPage === lastPage;
    document.getElementById(`btnUltima${prefix}`).disabled = currentPage === lastPage;
}

function configurarEventos() {
    // Botón filtrar
    document.getElementById('btnActualizar')?.addEventListener('click', () => {
        currentPageEntrada = 1;
        currentPageSalida = 1;
        cargarMovimientos('entrada');
        cargarMovimientos('salida');
    });
    
    // Botón limpiar filtros
    document.getElementById('btnLimpiarFiltros')?.addEventListener('click', () => {
        document.getElementById('fechaInicio').value = '{{ date('Y-m-01') }}';
        document.getElementById('fechaFin').value = '{{ date('Y-m-d') }}';
        document.getElementById('filtroProyecto').value = '';
        document.getElementById('filtroBusqueda').value = '';
        currentPageEntrada = 1;
        currentPageSalida = 1;
        cargarMovimientos('entrada');
        cargarMovimientos('salida');
    });
    
    // Filtros automáticos al cambiar
    document.getElementById('fechaInicio')?.addEventListener('change', () => { currentPageEntrada = 1; currentPageSalida = 1; cargarMovimientos('entrada'); cargarMovimientos('salida'); });
    document.getElementById('fechaFin')?.addEventListener('change', () => { currentPageEntrada = 1; currentPageSalida = 1; cargarMovimientos('entrada'); cargarMovimientos('salida'); });
    document.getElementById('filtroProyecto')?.addEventListener('change', () => { currentPageEntrada = 1; currentPageSalida = 1; cargarMovimientos('entrada'); cargarMovimientos('salida'); });
    
    // Búsqueda con debounce
    let searchTimeout;
    document.getElementById('filtroBusqueda')?.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPageEntrada = 1;
            currentPageSalida = 1;
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
        }, 400);
    });
    
    // Búsqueda con Enter
    document.getElementById('filtroBusqueda')?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            clearTimeout(searchTimeout);
            currentPageEntrada = 1;
            currentPageSalida = 1;
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
        }
    });
    
    // Paginación entradas
    document.getElementById('btnPrimeraEntrada')?.addEventListener('click', () => { currentPageEntrada = 1; cargarMovimientos('entrada'); });
    document.getElementById('btnAnteriorEntrada')?.addEventListener('click', () => { if (currentPageEntrada > 1) { currentPageEntrada--; cargarMovimientos('entrada'); } });
    document.getElementById('btnSiguienteEntrada')?.addEventListener('click', () => { currentPageEntrada++; cargarMovimientos('entrada'); });
    document.getElementById('btnUltimaEntrada')?.addEventListener('click', () => { currentPageEntrada = 999; cargarMovimientos('entrada'); });
    document.getElementById('porPaginaEntrada')?.addEventListener('change', (e) => { perPageEntrada = parseInt(e.target.value); currentPageEntrada = 1; cargarMovimientos('entrada'); });
    
    // Paginación salidas
    document.getElementById('btnPrimeraSalida')?.addEventListener('click', () => { currentPageSalida = 1; cargarMovimientos('salida'); });
    document.getElementById('btnAnteriorSalida')?.addEventListener('click', () => { if (currentPageSalida > 1) { currentPageSalida--; cargarMovimientos('salida'); } });
    document.getElementById('btnSiguienteSalida')?.addEventListener('click', () => { currentPageSalida++; cargarMovimientos('salida'); });
    document.getElementById('btnUltimaSalida')?.addEventListener('click', () => { currentPageSalida = 999; cargarMovimientos('salida'); });
    document.getElementById('porPaginaSalida')?.addEventListener('change', (e) => { perPageSalida = parseInt(e.target.value); currentPageSalida = 1; cargarMovimientos('salida'); });
    
    // Exportar
    document.getElementById('btnExcelEntradas')?.addEventListener('click', () => {
        const params = new URLSearchParams({
            tipo: 'Entrada',
            fecha_inicio: document.getElementById('fechaInicio').value,
            fecha_fin: document.getElementById('fechaFin').value,
            proyecto_id: document.getElementById('filtroProyecto').value
        });
        window.location.href = '/inventario/api/movimientos/exportar?' + params.toString();
    });
    document.getElementById('btnExcelSalidas')?.addEventListener('click', () => {
        const params = new URLSearchParams({
            tipo: 'Salida',
            fecha_inicio: document.getElementById('fechaInicio').value,
            fecha_fin: document.getElementById('fechaFin').value,
            proyecto_id: document.getElementById('filtroProyecto').value
        });
        window.location.href = '/inventario/api/movimientos/exportar?' + params.toString();
    });
}

async function cargarComprasPendientes() {
    const selectCompra = document.getElementById('modalCompra');
    selectCompra.innerHTML = '<option>Cargando...</option>';
    
    try {
        const response = await fetch('/compras/api/pendientes-recepcion');
        const data = await response.json();
        
        if (data.success && data.data.length > 0) {
            selectCompra.innerHTML = '<option value="">Seleccionar orden de compra</option>';
            data.data.forEach(compra => {
                selectCompra.innerHTML += `<option value="${compra.id}" 
                    data-proyecto-id="${compra.proyecto_id}"
                    data-folio="${compra.folio_requisicion}"
                    data-proveedor="${compra.proveedor_nombre}">
                    📄 ${compra.folio_requisicion} - ${compra.proveedor_nombre} (${compra.total_articulos} artículos, ${compra.total_pendiente} pendientes)
                </option>`;
            });
        } else {
            selectCompra.innerHTML = '<option value="">No hay compras pendientes</option>';
        }
    } catch (error) {
        console.error('Error:', error);
        selectCompra.innerHTML = '<option value="">Error al cargar compras</option>';
    }
}

async function abrirModalArticulosCompra(compraId) {
    const almacenId = document.getElementById('modalAlmacen').value;
    if (!almacenId) {
        alert('⚠️ Primero seleccione el Almacén de destino en el formulario principal');
        return;
    }
    
    const proyectoId = document.getElementById('modalProyecto').value;
    if (!proyectoId) {
        alert('⚠️ Primero seleccione el Proyecto en el formulario principal');
        return;
    }
    
    compraSeleccionadaId = compraId;
    const tbody = document.getElementById('tablaArticulosCompraBody');
    tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>';
    
    try {
        const response = await fetch(`/compras/api/pendientes-recepcion/${compraId}/detalle`);
        const data = await response.json();
        
        if (data.success && data.data.articulos && data.data.articulos.length > 0) {
            articulosCompraData = data.data.articulos;
            const almacenText = document.getElementById('modalAlmacen').options[document.getElementById('modalAlmacen').selectedIndex]?.text || 'No seleccionado';
            document.getElementById('infoCompraResumen').innerHTML = `
                <strong>📄 Folio:</strong> ${data.data.folio_requisicion} | 
                <strong>🏢 Proveedor:</strong> ${data.data.proveedor} | 
                <strong>🏗️ Proyecto:</strong> ${data.data.proyecto_nombre}<br>
                <strong>🏪 Almacén:</strong> ${almacenText}
            `;
            renderizarTablaArticulosCompra(articulosCompraData);
            document.getElementById('modalArticulosCompra').style.display = 'flex';
        } else {
            alert('No se encontraron artículos pendientes para esta compra');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar artículos');
    }
}

function renderizarTablaArticulosCompra(articulos) {
    const tbody = document.getElementById('tablaArticulosCompraBody');
    let totalPendiente = 0;
    let totalImporte = 0;
    
    if (!articulos || !articulos.length) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay artículos pendientes</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    articulos.forEach((art, idx) => {
        const pendiente = parseFloat(art.cantidad_pendiente) || 0;
        const costo = parseFloat(art.costo_unitario) || 0;
        const importe = pendiente * costo;
        totalPendiente += pendiente;
        totalImporte += importe;
        
        const row = tbody.insertRow();
        row.insertCell(0).innerHTML = `<input type="checkbox" class="chk-articulo-compra" data-index="${idx}" checked style="transform: scale(1.2);">`;
        row.insertCell(1).innerHTML = `<strong>${art.articulo_codigo || '---'}</strong>`;
        row.insertCell(2).innerHTML = art.articulo_descripcion || '---';
        row.insertCell(3).innerHTML = art.unidad_medida || 'pza';
        row.insertCell(4).innerHTML = `<span class="badge-pendiente">${pendiente}</span>`;
        row.insertCell(5).innerHTML = `$${costo.toFixed(2)}`;
        row.insertCell(6).innerHTML = `$${importe.toFixed(2)}`;
        row.insertCell(7).innerHTML = `<input type="number" class="cantidad-recibir-compra" data-index="${idx}" data-max="${pendiente}" value="${pendiente}" min="0" max="${pendiente}" step="0.001" style="width: 90px; padding: 5px; text-align: center; border:1px solid #ced4da; border-radius:4px;">`;
        row.insertCell(8).innerHTML = `<input type="text" class="obs-recibir-compra" data-index="${idx}" placeholder="Observación" style="width:100%; padding:5px; border:1px solid #ced4da; border-radius:4px;">`;
        
        const cantidadInput = row.cells[7].querySelector('.cantidad-recibir-compra');
        cantidadInput.addEventListener('change', function() {
            const newCantidad = parseFloat(this.value) || 0;
            const nuevoImporte = newCantidad * costo;
            row.cells[6].innerHTML = `$${nuevoImporte.toFixed(2)}`;
            recalcularTotalesCompra();
        });
    });
    
    document.getElementById('totalPendienteCompra').textContent = totalPendiente;
    document.getElementById('totalImporteCompra').textContent = `$${totalImporte.toFixed(2)}`;
}

function recalcularTotalesCompra() {
    const inputs = document.querySelectorAll('.cantidad-recibir-compra');
    let total = 0;
    let totalImporte = 0;
    inputs.forEach(input => {
        const idx = parseInt(input.dataset.index);
        const cantidad = parseFloat(input.value) || 0;
        const costo = parseFloat(articulosCompraData[idx]?.costo_unitario) || 0;
        total += cantidad;
        totalImporte += cantidad * costo;
    });
    document.getElementById('totalPendienteCompra').textContent = total;
    document.getElementById('totalImporteCompra').textContent = `$${totalImporte.toFixed(2)}`;
}

async function registrarRecepcionMultiple() {
    const checkboxes = document.querySelectorAll('.chk-articulo-compra:checked');
    if (checkboxes.length === 0) {
        alert('⚠️ Seleccione al menos un artículo');
        return;
    }
    
    const items = [];
    let errorArticulos = false;
    let articulosCreados = [];
    
    for (const chk of checkboxes) {
        const idx = parseInt(chk.dataset.index);
        const cantidadInput = document.querySelector(`.cantidad-recibir-compra[data-index="${idx}"]`);
        const obsInput = document.querySelector(`.obs-recibir-compra[data-index="${idx}"]`);
        const cantidad = parseFloat(cantidadInput?.value) || 0;
        
        if (cantidad > 0 && articulosCompraData[idx]) {
            let articuloId = articulosCompraData[idx].articulo_id;
            const articuloCodigo = articulosCompraData[idx].articulo_codigo;
            const articuloDescripcion = articulosCompraData[idx].articulo_descripcion;
            const unidadMedida = articulosCompraData[idx].unidad_medida || 'Pieza';
            
            if (!articuloId || articuloId === 0 || isNaN(articuloId)) {
                try {
                    const createResponse = await fetch('/inventario/api/articulos/crear-temporal', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            codigo: articuloCodigo,
                            descripcion: articuloDescripcion,
                            unidad_medida: unidadMedida
                        })
                    });
                    
                    const createData = await createResponse.json();
                    
                    if (createData.success && createData.data.id) {
                        articuloId = createData.data.id;
                        articulosCreados.push(articuloCodigo);
                    } else {
                        alert(`⚠️ No se pudo crear el artículo "${articuloCodigo}". Por favor, verifique.`);
                        errorArticulos = true;
                        break;
                    }
                } catch (error) {
                    alert(`⚠️ Error al crear el artículo "${articuloCodigo}". Por favor, verifique.`);
                    errorArticulos = true;
                    break;
                }
            }
            
            items.push({
                articulo_id: parseInt(articuloId),
                cantidad: cantidad,
                costo_unitario: parseFloat(articulosCompraData[idx].costo_unitario) || 0,
                observacion: obsInput?.value || ''
            });
        }
    }
    
    if (errorArticulos) return;
    
    if (items.length === 0) {
        alert('No hay cantidades válidas para recibir');
        return;
    }
    
    if (articulosCreados.length > 0) {
        alert(`📦 Se crearon automáticamente los siguientes artículos:\n${articulosCreados.join('\n')}\n\nContinúe con la recepción.`);
    }
    
    const almacenId = document.getElementById('modalAlmacen').value;
    if (!almacenId) {
        alert('⚠️ Seleccione el almacén de destino en el formulario principal');
        cerrarModalArticulos();
        return;
    }
    
    const proyectoId = document.getElementById('modalProyecto').value;
    if (!proyectoId) {
        alert('⚠️ Seleccione el proyecto en el formulario principal');
        cerrarModalArticulos();
        return;
    }
    
    const btn = document.getElementById('btnRegistrarRecepcionMultiple');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    btn.disabled = true;
    
    const dataToSend = {
        compra_id: parseInt(compraSeleccionadaId),
        proyecto_id: parseInt(proyectoId),
        almacen_id: parseInt(almacenId),
        fecha_movimiento: document.getElementById('modalFecha').value,
        items: items
    };
    
    try {
        const response = await fetch('/inventario/api/movimientos/recepcion-multiple', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            let mensaje = `✅ ${data.message}`;
            if (articulosCreados.length > 0) {
                mensaje += `\n\n📦 Artículos creados automáticamente:\n${articulosCreados.join('\n')}`;
            }
            alert(mensaje);
            cerrarModalArticulos();
            cerrarModalMovimiento();
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
            cargarComprasPendientes();
        } else {
            let errorMsg = 'Error: ';
            if (data.errors) {
                errorMsg += JSON.stringify(data.errors);
            } else if (data.message) {
                errorMsg += data.message;
            } else {
                errorMsg += 'Error desconocido';
            }
            alert(errorMsg);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al registrar: ' + error.message);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

window.switchTab = function(tab) {
    const panelEntradas = document.getElementById('panelEntradas');
    const panelSalidas = document.getElementById('panelSalidas');
    const tabEntradas = document.getElementById('tabEntradas');
    const tabSalidas = document.getElementById('tabSalidas');
    
    if (tab === 'entradas') {
        panelEntradas.style.display = 'block';
        panelSalidas.style.display = 'none';
        tabEntradas.style.backgroundColor = 'var(--color-primary)';
        tabEntradas.style.color = 'white';
        tabSalidas.style.backgroundColor = '#e9ecef';
        tabSalidas.style.color = '#495057';
    } else {
        panelEntradas.style.display = 'none';
        panelSalidas.style.display = 'block';
        tabSalidas.style.backgroundColor = 'var(--color-primary)';
        tabSalidas.style.color = 'white';
        tabEntradas.style.backgroundColor = '#e9ecef';
        tabEntradas.style.color = '#495057';
    }
};

window.abrirModalMovimiento = function(tipo) {
    movimientoTipo = tipo;
    const modal = document.getElementById('modalMovimiento');
    const titulo = document.getElementById('modalTituloMovimiento');
    const divOrigen = document.getElementById('divOrigenEntrada');
    const divSolicitante = document.getElementById('divSolicitante');
    const panelCompra = document.getElementById('panelCompra');
    const divCosto = document.getElementById('divCosto');
    const selectArticulo = document.getElementById('modalArticulo');
    const selectProyecto = document.getElementById('modalProyecto');
    
    if (tipo === 'entrada') {
        titulo.textContent = '📥 Nueva Entrada de Material';
        divOrigen.style.display = 'block';
        divSolicitante.style.display = 'none';
        panelCompra.style.display = 'none';
        divCosto.style.display = 'none';
        selectArticulo.disabled = false;
        selectProyecto.disabled = false;
    } else {
        titulo.textContent = '📤 Nueva Salida de Material';
        divOrigen.style.display = 'none';
        divSolicitante.style.display = 'block';
        panelCompra.style.display = 'none';
        divCosto.style.display = 'none';
        selectArticulo.disabled = false;
        selectProyecto.disabled = false;
    }
    
    document.getElementById('movimientoTipo').value = tipo;
    document.getElementById('modalProyecto').value = '';
    document.getElementById('modalFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('modalArticulo').value = '';
    document.getElementById('modalAlmacen').value = '';
    document.getElementById('modalCantidad').value = '';
    document.getElementById('modalCantidad').readOnly = false;
    document.getElementById('modalReferencia').value = '';
    document.getElementById('modalReferencia').readOnly = false;
    document.getElementById('modalSolicitante').value = '';
    document.getElementById('modalObservaciones').value = '';
    document.getElementById('modalCosto').value = '';
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.guardarMovimiento = async function() {
    const tipo = movimientoTipo;
    const proyectoId = document.getElementById('modalProyecto').value;
    const articuloId = document.getElementById('modalArticulo').value;
    const almacenId = document.getElementById('modalAlmacen').value;
    const cantidad = document.getElementById('modalCantidad').value;
    
    if (!proyectoId || !articuloId || !almacenId || !cantidad || cantidad <= 0) {
        alert('⚠️ Complete todos los campos obligatorios');
        return;
    }
    
    if (tipo === 'salida') {
        try {
            const response = await fetch(`/inventario/api/movimientos/verificar-stock?proyecto_id=${proyectoId}&articulo_id=${articuloId}&almacen_id=${almacenId}&cantidad=${cantidad}`);
            const data = await response.json();
            if (!data.success || !data.data.stock_suficiente) {
                alert(data.message || 'Stock insuficiente');
                return;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al verificar stock');
            return;
        }
    }
    
    const data = {
        proyecto_id: proyectoId,
        articulo_id: articuloId,
        almacen_id: almacenId,
        cantidad: parseFloat(cantidad),
        fecha_movimiento: document.getElementById('modalFecha').value,
        observaciones: document.getElementById('modalObservaciones').value
    };
    
    if (tipo === 'entrada') {
        const origen = document.getElementById('modalOrigenEntrada').value;
        data.origen = origen;
        if (origen === 'compra') {
            const compraId = document.getElementById('modalCompra').value;
            if (!compraId) { 
                alert('Seleccione una orden de compra'); 
                return; 
            }
            data.compra_id = compraId;
            data.costo_unitario = document.getElementById('modalCosto').value;
        } else {
            data.referencia_folio = document.getElementById('modalReferencia').value;
        }
    } else {
        data.solicitante = document.getElementById('modalSolicitante').value || '';
        data.referencia_folio = document.getElementById('modalReferencia').value;
    }
    
    const url = tipo === 'entrada' ? '/inventario/api/movimientos/entrada' : '/inventario/api/movimientos/salida';
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btn.disabled = true;
    
    fetch(url, {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' 
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        if (response.success) {
            alert('✅ ' + response.message);
            cerrarModalMovimiento();
            cargarMovimientos('entrada');
            cargarMovimientos('salida');
        } else {
            alert('❌ Error: ' + response.message);
        }
    })
    .catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        console.error('Error:', error);
        alert('❌ Error: ' + error.message);
    });
};

/* ============================================================
   MODAL DE DETALLE MEJORADO
   ============================================================ */
window.verDetalle = async function(id) {
    if (!id) {
        alert('ID no válido');
        return;
    }
    
    try {
        const response = await fetch(`/inventario/api/movimientos/${id}`);
        const data = await response.json();
        
        if (data.success && data.data) {
            movimientoDetalleActual = data.data;
            mostrarModalDetalle(data.data);
        } else {
            alert('❌ No se encontró el movimiento');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al conectar con el servidor');
    }
};

function mostrarModalDetalle(m) {
    const esEntrada = m.tipo_movimiento === 'Entrada';
    const esSalida = m.tipo_movimiento === 'Salida';
    const esTransferencia = m.tipo_movimiento === 'Transferencia';
    const esAjuste = m.tipo_movimiento === 'Ajuste';
    
    // Configurar header según tipo
    const header = document.getElementById('detalleHeader');
    const iconoHeader = document.getElementById('detalleIconoHeader');
    const badgeTipo = document.getElementById('detalleBadgeTipo');
    
    if (esEntrada) {
        header.style.background = 'linear-gradient(135deg, #28a745, #1e7e34)';
        iconoHeader.innerHTML = '<i class="fas fa-arrow-down"></i>';
        badgeTipo.style.backgroundColor = '#d4edda';
        badgeTipo.style.color = '#155724';
        badgeTipo.innerHTML = '<i class="fas fa-arrow-down"></i> ENTRADA';
    } else if (esSalida) {
        header.style.background = 'linear-gradient(135deg, #dc3545, #a71d2a)';
        iconoHeader.innerHTML = '<i class="fas fa-arrow-up"></i>';
        badgeTipo.style.backgroundColor = '#f8d7da';
        badgeTipo.style.color = '#721c24';
        badgeTipo.innerHTML = '<i class="fas fa-arrow-up"></i> SALIDA';
    } else if (esTransferencia) {
        header.style.background = 'linear-gradient(135deg, #17a2b8, #117a8b)';
        iconoHeader.innerHTML = '<i class="fas fa-exchange-alt"></i>';
        badgeTipo.style.backgroundColor = '#d1ecf1';
        badgeTipo.style.color = '#0c5460';
        badgeTipo.innerHTML = '<i class="fas fa-exchange-alt"></i> TRANSFERENCIA';
    } else {
        header.style.background = 'linear-gradient(135deg, #ffc107, #d39e00)';
        iconoHeader.innerHTML = '<i class="fas fa-sliders-h"></i>';
        badgeTipo.style.backgroundColor = '#fff3cd';
        badgeTipo.style.color = '#856404';
        badgeTipo.innerHTML = '<i class="fas fa-sliders-h"></i> AJUSTE';
    }
    
    document.getElementById('detalleTituloTipo').textContent = `Movimiento #${m.id}`;
    document.getElementById('detalleSubtitulo').textContent = `${m.tipo_movimiento} • ${m.fecha_movimiento}`;
    document.getElementById('detalleFecha').textContent = m.fecha_movimiento;
    
    // Datos principales
    document.getElementById('detalleProyecto').textContent = m.proyecto_nombre || 'N/A';
    document.getElementById('detalleAlmacen').textContent = m.almacen_nombre || 
        (m.almacen_origen_nombre && m.almacen_destino_nombre 
            ? `${m.almacen_origen_nombre} → ${m.almacen_destino_nombre}`
            : 'N/A');
    
    // Artículo
    document.getElementById('detalleArticuloCodigo').textContent = m.articulo_codigo || '---';
    document.getElementById('detalleArticuloDescripcion').textContent = m.articulo_descripcion || '---';
    
    // Cantidades y costos
    document.getElementById('detalleCantidad').textContent = m.cantidad;
    document.getElementById('detalleUnidad').textContent = m.unidad_medida || 'unidad';
    document.getElementById('detalleCosto').textContent = m.costo_unitario ? `$${parseFloat(m.costo_unitario).toFixed(2)}` : 'N/A';
    document.getElementById('detalleImporte').textContent = m.importe ? `$${parseFloat(m.importe).toFixed(2)}` : 'N/A';
    
    // Stock antes/después
    const cantidadAntes = parseFloat(m.cantidad_antes) || 0;
    const cantidadDespues = parseFloat(m.cantidad_despues) || 0;
    const diferencia = cantidadDespues - cantidadAntes;
    
    document.getElementById('detalleCantidadAntes').textContent = cantidadAntes;
    document.getElementById('detalleCantidadDespues').textContent = cantidadDespues;
    
    const difElement = document.getElementById('detalleDiferencia');
    difElement.textContent = (diferencia > 0 ? '+' : '') + diferencia.toFixed(2);
    difElement.style.color = diferencia > 0 ? '#28a745' : (diferencia < 0 ? '#dc3545' : '#6c757d');
    
    // Info adicional
    document.getElementById('detalleReferencia').textContent = m.referencia_folio || 'N/A';
    document.getElementById('detalleSolicitante').textContent = m.solicitante || 'N/A';
    document.getElementById('detalleObservaciones').textContent = m.observaciones || 'Sin observaciones';
    document.getElementById('detalleCreadoPor').textContent = m.creado_por || 'N/A';
    document.getElementById('detalleId').textContent = `#${m.id}`;
    
    // Mostrar modal
    document.getElementById('modalDetalle').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

window.cerrarModalDetalle = function() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
};

window.imprimirDetalle = function() {
    if (!movimientoDetalleActual) return;
    
    const m = movimientoDetalleActual;
    const ventana = window.open('', '_blank', 'width=800,height=600');
    ventana.document.write(`
        <html>
        <head>
            <title>Movimiento #${m.id}</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 30px; color: #333; }
                h1 { color: #083CAE; border-bottom: 3px solid #083CAE; padding-bottom: 10px; }
                .info { margin: 15px 0; }
                .info label { font-weight: bold; display: inline-block; width: 180px; color: #555; }
                .info span { color: #000; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
                th { background-color: #083CAE; color: white; }
            </style>
        </head>
        <body>
            <h1>📋 Detalle de Movimiento #${m.id}</h1>
            <div class="info"><label>Tipo:</label> <span>${m.tipo_movimiento}</span></div>
            <div class="info"><label>Fecha:</label> <span>${m.fecha_movimiento}</span></div>
            <div class="info"><label>Proyecto:</label> <span>${m.proyecto_nombre || 'N/A'}</span></div>
            <div class="info"><label>Almacén:</label> <span>${m.almacen_nombre || 'N/A'}</span></div>
            <div class="info"><label>Artículo:</label> <span>${m.articulo_codigo} - ${m.articulo_descripcion}</span></div>
            <table>
                <tr><th>Cantidad</th><th>Costo Unitario</th><th>Importe</th></tr>
                <tr>
                    <td>${m.cantidad} ${m.unidad_medida || ''}</td>
                    <td>${m.costo_unitario ? '$' + parseFloat(m.costo_unitario).toFixed(2) : 'N/A'}</td>
                    <td>${m.importe ? '$' + parseFloat(m.importe).toFixed(2) : 'N/A'}</td>
                </tr>
            </table>
            <div class="info" style="margin-top:20px;"><label>Stock antes:</label> <span>${m.cantidad_antes}</span></div>
            <div class="info"><label>Stock después:</label> <span>${m.cantidad_despues}</span></div>
            <div class="info"><label>Referencia:</label> <span>${m.referencia_folio || 'N/A'}</span></div>
            <div class="info"><label>Solicitante:</label> <span>${m.solicitante || 'N/A'}</span></div>
            <div class="info"><label>Observaciones:</label> <span>${m.observaciones || 'N/A'}</span></div>
            <div class="info"><label>Registrado por:</label> <span>${m.creado_por || 'N/A'}</span></div>
            <p style="margin-top:40px; text-align:center; color:#999; font-size:12px;">Generado el ${new Date().toLocaleString()}</p>
        </body>
        </html>
    `);
    ventana.document.close();
    ventana.print();
};

window.cerrarModalMovimiento = function() {
    document.getElementById('modalMovimiento').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('modalProyecto').disabled = false;
    document.getElementById('modalArticulo').disabled = false;
};

window.cerrarModalArticulos = function() {
    document.getElementById('modalArticulosCompra').style.display = 'none';
};

document.addEventListener('keydown', (e) => { 
    if (e.key === 'Escape') { 
        cerrarModalMovimiento(); 
        cerrarModalArticulos(); 
        cerrarModalDetalle();
    } 
});

document.getElementById('modalMovimiento')?.addEventListener('click', (e) => { 
    if (e.target === document.getElementById('modalMovimiento')) cerrarModalMovimiento(); 
});

document.getElementById('modalArticulosCompra')?.addEventListener('click', (e) => { 
    if (e.target === document.getElementById('modalArticulosCompra')) cerrarModalArticulos(); 
});

document.getElementById('modalDetalle')?.addEventListener('click', (e) => { 
    if (e.target === document.getElementById('modalDetalle')) cerrarModalDetalle(); 
});
</script>
@endsection