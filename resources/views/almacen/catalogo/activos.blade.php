@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-tools"></i> Catálogo de Activos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Filtros -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Tipo</label>
                        <select id="filtroTipo" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="herramienta"> Herramienta</option>
                            <option value="maquinaria"> Maquinaria</option>
                            <option value="vehiculo">Vehículo</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Estatus</label>
                        <select id="filtroEstatus" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Asignado">Asignado</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                            <option value="Dado de baja">Dado de baja</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 600; color: #6c757d;">Proyecto</label>
                        <select id="filtroProyecto" style="width: 100%; padding: 6px; border: 1px solid #ced4da; border-radius: 4px;">
                            <option value="">Todos</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button id="btnActualizar" style="background-color: var(--color-primary); color: white; border: none; border-radius: 4px; padding: 8px 15px; cursor: pointer; width: 100%;">
                            <i class="fas fa-sync-alt"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
                    <button id="btnNuevoActivo" onclick="abrirModalActivo()" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                        <i class="fas fa-plus"></i> Nuevo Activo
                    </button>
                    <button id="btnExportar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 20px; cursor: pointer; color: var(--color-primary);">
                        <i class="fas fa-file-excel"></i> Exportar
                    </button>
                </div>

                <!-- Tabla -->
                <div class="table-container">
                    <table class="table" id="tablaActivos">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Marca/Modelo</th>
                                <th>Serie</th>
                                <th>Medición</th>
                                <th>Ubicación</th>
                                <th>Proyecto</th>
                                <th>Estado</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <td><td colspan="11" style="text-align: center;">Cargando...<\/td></tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="pagination-container" style="margin-top: 15px; display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                    <button class="page-btn" id="btnPrimera" disabled><i class="fas fa-angle-double-left"></i></button>
                    <button class="page-btn" id="btnAnterior" disabled><i class="fas fa-angle-left"></i></button>
                    <span>Página <span id="paginaActual">1</span> de <span id="totalPaginas">1</span></span>
                    <button class="page-btn" id="btnSiguiente" disabled><i class="fas fa-angle-right"></i></button>
                    <button class="page-btn" id="btnUltima" disabled><i class="fas fa-angle-double-right"></i></button>
                    <select id="porPagina" style="padding: 5px; border-radius: 4px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL NUEVO/EDITAR ACTIVO -->
<div id="modalActivo" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;" id="modalTitulo">Nuevo Activo</h3>
            <button onclick="cerrarModalActivo()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div style="padding: 20px;">
            <input type="hidden" id="activoId">
            
            <!-- Campos comunes -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Tipo <span style="color: red;">*</span></label>
                    <select id="activoTipo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" onchange="mostrarCamposPorTipo()">
                        <option value="">Seleccionar</option>
                        <option value="herramienta"> Herramienta</option>
                        <option value="maquinaria"> Maquinaria</option>
                        <option value="vehiculo">Vehículo</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Código</label>
                    <input type="text" id="activoCodigo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" readonly placeholder="Autogenerado">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Nombre <span style="color: red;">*</span></label>
                    <input type="text" id="activoNombre" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Excavadora Caterpillar 320D">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Categoría</label>
                    <input type="text" id="activoCategoria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Excavadora, Camión">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Marca</label>
                    <input type="text" id="activoMarca" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Caterpillar">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Modelo</label>
                    <input type="text" id="activoModelo" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: 320D">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Serie</label>
                    <input type="text" id="activoSerie" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de serie">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Año</label>
                    <input type="number" id="activoAnio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2023">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Color</label>
                    <input type="text" id="activoColor" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Color">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Ubicación</label>
                    <input type="text" id="activoUbicacion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ubicación física">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Estado General</label>
                    <select id="activoEstadoGeneral" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Excelente">Excelente</option>
                        <option value="Bueno" selected>Bueno</option>
                        <option value="Regular">Regular</option>
                        <option value="Malo">Malo</option>
                        <option value="En reparacion">En reparación</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Estatus</label>
                    <select id="activoEstatus" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Disponible">Disponible</option>
                        <option value="Asignado">Asignado</option>
                        <option value="En mantenimiento">En mantenimiento</option>
                        <option value="Dado de baja">Dado de baja</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proyecto</label>
                    <select id="activoProyecto" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Sin asignar</option>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}">{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Cuenta Contable</label>
                    <input type="text" id="activoCuentaContable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="1150-03-001">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Proveedor</label>
                    <select id="activoProveedor" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Factura</label>
                    <input type="text" id="activoFactura" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de factura">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Fecha Adquisición</label>
                    <input type="date" id="activoFechaAdquisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Costo Adquisición</label>
                    <input type="number" step="0.01" id="activoCostoAdquisicion" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="font-size: 13px; font-weight: 600;">Valor Actual</label>
                    <input type="number" step="0.01" id="activoValorActual" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Descripción</label>
                    <textarea id="activoDescripcion" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción detallada..."></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label style="font-size: 13px; font-weight: 600;">Observaciones</label>
                    <textarea id="activoObservaciones" rows="2" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Observaciones..."></textarea>
                </div>
            </div>

            <!-- Campos Herramienta -->
            <div id="camposHerramienta" style="display: none; margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <h4 style="font-size: 14px; color: var(--color-primary);">Datos de Herramienta</h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 10px;">
                    <div><label>Tipo Herramienta</label><input type="text" id="herramientaTipo" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Voltaje</label><input type="text" id="herramientaVoltaje" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Potencia (kW)</label><input type="number" step="0.1" id="herramientaPotencia" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Requiere Calibración</label><select id="herramientaRequiereCalibracion" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="0">No</option><option value="1">Sí</option></select></div>
                    <div><label>N° Inventario</label><input type="text" id="herramientaNumInventario" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                </div>
            </div>

            <!-- Campos Maquinaria -->
            <div id="camposMaquinaria" style="display: none; margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <h4 style="font-size: 14px; color: var(--color-primary);">Datos de Maquinaria</h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 10px;">
                    <div><label>Horómetro (horas)</label><input type="number" step="0.1" id="maquinariaHorometro" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;" value="0"></div>
                    <div><label>Horómetro Compra</label><input type="number" step="0.1" id="maquinariaHorometroCompra" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;" value="0"></div>
                    <div><label>Combustible</label><select id="maquinariaCombustible" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="Diesel">Diesel</option><option value="Gasolina">Gasolina</option><option value="Electrico">Eléctrico</option></select></div>
                    <div><label>Consumo (L/h)</label><input type="number" step="0.1" id="maquinariaConsumo" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Capacidad Tanque (L)</label><input type="number" id="maquinariaCapacidad" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Peso Operativo (Ton)</label><input type="number" step="0.1" id="maquinariaPeso" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Capacidad Carga</label><input type="number" step="0.1" id="maquinariaCapacidadCarga" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Licencia Requerida</label><input type="text" id="maquinariaLicencia" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                </div>
            </div>

            <!-- Campos Vehículo -->
            <div id="camposVehiculo" style="display: none; margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <h4 style="font-size: 14px; color: var(--color-primary);">Datos de Vehículo</h4>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 10px;">
                    <div><label>Placas</label><input type="text" id="vehiculoPlacas" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>N° Económico</label><input type="text" id="vehiculoNumEconomico" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>VIN</label><input type="text" id="vehiculoVin" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Kilometraje (km)</label><input type="number" id="vehiculoKilometraje" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;" value="0"></div>
                    <div><label>Kilometraje Compra</label><input type="number" id="vehiculoKilometrajeCompra" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;" value="0"></div>
                    <div><label>Tipo Vehículo</label><select id="vehiculoTipo" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="Pickup">Pickup</option><option value="Camión">Camión</option><option value="Sedán">Sedán</option><option value="SUV">SUV</option></select></div>
                    <div><label>Tracción</label><select id="vehiculoTraccion" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="4x2">4x2</option><option value="4x4">4x4</option></select></div>
                    <div><label>Transmisión</label><select id="vehiculoTransmision" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="Manual">Manual</option><option value="Automática">Automática</option></select></div>
                    <div><label>Pasajeros</label><input type="number" id="vehiculoPasajeros" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Capacidad Carga (kg)</label><input type="number" id="vehiculoCapacidadCarga" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Combustible</label><select id="vehiculoCombustible" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"><option value="Diesel">Diesel</option><option value="Gasolina">Gasolina</option></select></div>
                    <div><label>Consumo (km/L)</label><input type="number" step="0.1" id="vehiculoConsumo" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Póliza Seguro</label><input type="text" id="vehiculoPolizaSeguro" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Vencimiento Seguro</label><input type="date" id="vehiculoVencimientoSeguro" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                    <div><label>Licencia Requerida</label><input type="text" id="vehiculoLicencia" style="width:100%; padding:6px; border:1px solid #ced4da; border-radius:4px;"></div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalActivo()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarActivo()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETALLE -->
<div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0;">Detalle de Activo</h3>
            <button onclick="cerrarModalDetalle()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        <div id="detalleContenido" style="padding: 20px;"></div>
        <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end;">
            <button onclick="cerrarModalDetalle()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    .table-container { border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; max-height: 500px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .table th { background-color: var(--color-primary) !important; color: white; padding: 12px 8px; border: 1px solid #dee2e6; position: sticky; top: 0; }
    .table td { padding: 10px 8px; border: 1px solid #dee2e6; }
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    .page-btn { padding: 5px 12px; border: 1px solid var(--color-primary); border-radius: 4px; background: white; cursor: pointer; color: var(--color-primary); }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .badge-disponible { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-asignado { background-color: #17a2b8; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-mantenimiento { background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    .badge-baja { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 10px; }
    @media (max-width: 768px) { div[style*="grid-template-columns: repeat(4, 1fr)"] { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let editingId = null;

document.addEventListener('DOMContentLoaded', () => {
    cargarActivos();
    configurarEventos();
});

function cargarActivos() {
    const tipo = document.getElementById('filtroTipo')?.value || '';
    const estatus = document.getElementById('filtroEstatus')?.value || '';
    const proyectoId = document.getElementById('filtroProyecto')?.value || '';
    
    let url = `/almacen/api/activos?page=${currentPage}&per_page=${perPage}`;
    if (tipo) url += `&tipo_activo=${tipo}`;
    if (estatus) url += `&estatus=${estatus}`;
    if (proyectoId) url += `&proyecto_id=${proyectoId}`;
    
    fetch(url)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                renderizarTabla(res.data);
                totalPages = res.last_page;
                actualizarPaginacion(res.current_page, res.last_page);
            }
        })
        .catch(error => console.error('Error:', error));
}

function renderizarTabla(data) {
    const tbody = document.getElementById('tablaBody');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align: center;">No hay activos registrados<\/td><\/tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach(item => {
        let estatusClass = '';
        if (item.estatus === 'Disponible') estatusClass = 'badge-disponible';
        else if (item.estatus === 'Asignado') estatusClass = 'badge-asignado';
        else if (item.estatus === 'En mantenimiento') estatusClass = 'badge-mantenimiento';
        else estatusClass = 'badge-baja';
        
        let tipoIcono = '';
        let marcaModelo = `${item.marca || ''} ${item.modelo || ''}`.trim() || '---';
        let medicion = item.horometro ? `${item.horometro} ${item.unidad_medida || ''}` : '---';
        
        tbody.innerHTML += `
            <tr>
                <td><strong>${item.codigo}</strong></td>
                <td>${item.nombre}</td>
                <td>${tipoIcono} ${item.tipo_activo}</td>
                <td>${marcaModelo}</td>
                <td>${item.serie || '---'}</td>
                <td>${medicion}</td>
                <td>${item.ubicacion_fisica || '---'}</td>
                <td>${item.proyecto_asignado_nombre || 'No asignado'}</td>
                <td>${item.estado_general || '---'}</td>
                <td><span class="${estatusClass}">${item.estatus}</span></td>
                <td>
                    <i class="fas fa-eye" onclick="verDetalle(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;"></i>
                    <i class="fas fa-edit" onclick="editarActivo(${item.id})" style="color: var(--color-primary); cursor: pointer; margin: 0 3px;"></i>
                    <i class="fas fa-trash" onclick="eliminarActivo(${item.id}, '${item.codigo}')" style="color: #dc3545; cursor: pointer; margin: 0 3px;"></i>
                </td>
            </tr>
        `;
    });
}

function actualizarPaginacion(currentPage, lastPage) {
    document.getElementById('paginaActual').textContent = currentPage;
    document.getElementById('totalPaginas').textContent = lastPage;
    document.getElementById('btnPrimera').disabled = currentPage === 1;
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === lastPage;
    document.getElementById('btnUltima').disabled = currentPage === lastPage;
}

function configurarEventos() {
    document.getElementById('btnActualizar')?.addEventListener('click', () => { currentPage = 1; cargarActivos(); });
    document.getElementById('btnPrimera')?.addEventListener('click', () => { currentPage = 1; cargarActivos(); });
    document.getElementById('btnAnterior')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; cargarActivos(); } });
    document.getElementById('btnSiguiente')?.addEventListener('click', () => { currentPage++; cargarActivos(); });
    document.getElementById('btnUltima')?.addEventListener('click', () => { currentPage = totalPages; cargarActivos(); });
    document.getElementById('porPagina')?.addEventListener('change', (e) => { perPage = parseInt(e.target.value); currentPage = 1; cargarActivos(); });
    document.getElementById('btnExportar')?.addEventListener('click', () => alert('Exportación en desarrollo'));
}

function mostrarCamposPorTipo() {
    const tipo = document.getElementById('activoTipo').value;
    document.getElementById('camposHerramienta').style.display = tipo === 'herramienta' ? 'block' : 'none';
    document.getElementById('camposMaquinaria').style.display = tipo === 'maquinaria' ? 'block' : 'none';
    document.getElementById('camposVehiculo').style.display = tipo === 'vehiculo' ? 'block' : 'none';
    
    if (tipo === 'herramienta') document.getElementById('activoCodigo').value = generarCodigo('HER');
    else if (tipo === 'maquinaria') document.getElementById('activoCodigo').value = generarCodigo('MAQ');
    else if (tipo === 'vehiculo') document.getElementById('activoCodigo').value = generarCodigo('VEH');
    else document.getElementById('activoCodigo').value = '';
}

function generarCodigo(prefijo) {
    const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    return `${prefijo}-${random}`;
}

function abrirModalActivo() {
    editingId = null;
    document.getElementById('modalTitulo').textContent = 'Nuevo Activo';
    document.getElementById('activoId').value = '';
    document.getElementById('activoTipo').value = '';
    document.getElementById('activoCodigo').value = '';
    document.getElementById('activoNombre').value = '';
    document.getElementById('activoCategoria').value = '';
    document.getElementById('activoMarca').value = '';
    document.getElementById('activoModelo').value = '';
    document.getElementById('activoSerie').value = '';
    document.getElementById('activoAnio').value = '';
    document.getElementById('activoColor').value = '';
    document.getElementById('activoUbicacion').value = '';
    document.getElementById('activoEstadoGeneral').value = 'Bueno';
    document.getElementById('activoEstatus').value = 'Disponible';
    document.getElementById('activoProyecto').value = '';
    document.getElementById('activoCuentaContable').value = '';
    document.getElementById('activoProveedor').value = '';
    document.getElementById('activoFactura').value = '';
    document.getElementById('activoFechaAdquisicion').value = '';
    document.getElementById('activoCostoAdquisicion').value = '';
    document.getElementById('activoValorActual').value = '';
    document.getElementById('activoDescripcion').value = '';
    document.getElementById('activoObservaciones').value = '';
    
    document.getElementById('camposHerramienta').style.display = 'none';
    document.getElementById('camposMaquinaria').style.display = 'none';
    document.getElementById('camposVehiculo').style.display = 'none';
    
    document.getElementById('modalActivo').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function editarActivo(id) {
    fetch(`/almacen/api/activos/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const a = res.data;
                editingId = a.id;
                document.getElementById('modalTitulo').textContent = `Editar ${a.codigo}`;
                document.getElementById('activoId').value = a.id;
                document.getElementById('activoTipo').value = a.tipo_activo;
                document.getElementById('activoCodigo').value = a.codigo;
                document.getElementById('activoNombre').value = a.nombre;
                document.getElementById('activoCategoria').value = a.categoria || '';
                document.getElementById('activoMarca').value = a.marca || '';
                document.getElementById('activoModelo').value = a.modelo || '';
                document.getElementById('activoSerie').value = a.serie || '';
                document.getElementById('activoAnio').value = a.anio || '';
                document.getElementById('activoColor').value = a.color || '';
                document.getElementById('activoUbicacion').value = a.ubicacion_fisica || '';
                document.getElementById('activoEstadoGeneral').value = a.estado_general || 'Bueno';
                document.getElementById('activoEstatus').value = a.estatus || 'Disponible';
                document.getElementById('activoProyecto').value = a.proyecto_asignado_id || '';
                document.getElementById('activoCuentaContable').value = a.cuenta_contable || '';
                document.getElementById('activoProveedor').value = a.proveedor_id || '';
                document.getElementById('activoFactura').value = a.factura || '';
                document.getElementById('activoFechaAdquisicion').value = a.fecha_adquisicion || '';
                document.getElementById('activoCostoAdquisicion').value = a.costo_adquisicion || '';
                document.getElementById('activoValorActual').value = a.valor_actual || '';
                document.getElementById('activoDescripcion').value = a.descripcion || '';
                document.getElementById('activoObservaciones').value = a.observaciones || '';
                
                mostrarCamposPorTipo();
                
                if (a.herramienta) {
                    document.getElementById('herramientaTipo').value = a.herramienta.tipo_herramienta || '';
                    document.getElementById('herramientaVoltaje').value = a.herramienta.voltaje || '';
                    document.getElementById('herramientaPotencia').value = a.herramienta.potencia || '';
                    document.getElementById('herramientaRequiereCalibracion').value = a.herramienta.requiere_calibracion ? '1' : '0';
                    document.getElementById('herramientaNumInventario').value = a.herramienta.numero_inventario || '';
                }
                if (a.maquinaria) {
                    document.getElementById('maquinariaHorometro').value = a.maquinaria.horometro_actual || 0;
                    document.getElementById('maquinariaHorometroCompra').value = a.maquinaria.horometro_compra || 0;
                    document.getElementById('maquinariaCombustible').value = a.maquinaria.tipo_combustible || 'Diesel';
                    document.getElementById('maquinariaConsumo').value = a.maquinaria.consumo_promedio || '';
                    document.getElementById('maquinariaCapacidad').value = a.maquinaria.capacidad_tanque || '';
                    document.getElementById('maquinariaPeso').value = a.maquinaria.peso_operativo || '';
                    document.getElementById('maquinariaCapacidadCarga').value = a.maquinaria.capacidad_carga || '';
                    document.getElementById('maquinariaLicencia').value = a.maquinaria.licencia_requerida || '';
                }
                if (a.vehiculo) {
                    document.getElementById('vehiculoPlacas').value = a.vehiculo.placas || '';
                    document.getElementById('vehiculoNumEconomico').value = a.vehiculo.numero_economico || '';
                    document.getElementById('vehiculoVin').value = a.vehiculo.vin || '';
                    document.getElementById('vehiculoKilometraje').value = a.vehiculo.kilometraje_actual || 0;
                    document.getElementById('vehiculoKilometrajeCompra').value = a.vehiculo.kilometraje_compra || 0;
                    document.getElementById('vehiculoTipo').value = a.vehiculo.tipo_vehiculo || 'Pickup';
                    document.getElementById('vehiculoTraccion').value = a.vehiculo.traccion || '4x2';
                    document.getElementById('vehiculoTransmision').value = a.vehiculo.transmision || 'Manual';
                    document.getElementById('vehiculoPasajeros').value = a.vehiculo.capacidad_pasajeros || '';
                    document.getElementById('vehiculoCapacidadCarga').value = a.vehiculo.capacidad_carga || '';
                    document.getElementById('vehiculoCombustible').value = a.vehiculo.tipo_combustible || 'Diesel';
                    document.getElementById('vehiculoConsumo').value = a.vehiculo.consumo_promedio || '';
                    document.getElementById('vehiculoPolizaSeguro').value = a.vehiculo.poliza_seguro || '';
                    document.getElementById('vehiculoVencimientoSeguro').value = a.vehiculo.vencimiento_seguro || '';
                    document.getElementById('vehiculoLicencia').value = a.vehiculo.licencia_requerida || '';
                }
                
                document.getElementById('modalActivo').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
}

function guardarActivo() {
    const tipo = document.getElementById('activoTipo').value;
    const nombre = document.getElementById('activoNombre').value.trim();
    
    if (!tipo || !nombre) {
        alert('Complete tipo y nombre');
        return;
    }
    
    const data = {
        nombre: nombre,
        tipo_activo: tipo,
        categoria: document.getElementById('activoCategoria').value,
        marca: document.getElementById('activoMarca').value,
        modelo: document.getElementById('activoModelo').value,
        serie: document.getElementById('activoSerie').value,
        anio: document.getElementById('activoAnio').value,
        color: document.getElementById('activoColor').value,
        ubicacion_fisica: document.getElementById('activoUbicacion').value,
        estado_general: document.getElementById('activoEstadoGeneral').value,
        estatus: document.getElementById('activoEstatus').value,
        proyecto_id: document.getElementById('activoProyecto').value || null,
        cuenta_contable: document.getElementById('activoCuentaContable').value,
        proveedor_id: document.getElementById('activoProveedor').value || null,
        factura: document.getElementById('activoFactura').value,
        fecha_adquisicion: document.getElementById('activoFechaAdquisicion').value,
        costo_adquisicion: document.getElementById('activoCostoAdquisicion').value,
        valor_actual: document.getElementById('activoValorActual').value,
        descripcion: document.getElementById('activoDescripcion').value,
        observaciones: document.getElementById('activoObservaciones').value
    };
    
    // Herramienta
    if (tipo === 'herramienta') {
        data.tipo_herramienta = document.getElementById('herramientaTipo').value;
        data.voltaje = document.getElementById('herramientaVoltaje').value;
        data.potencia = document.getElementById('herramientaPotencia').value;
        data.requiere_calibracion = document.getElementById('herramientaRequiereCalibracion').value === '1';
        data.numero_inventario = document.getElementById('herramientaNumInventario').value;
    }
    
    // Maquinaria
    if (tipo === 'maquinaria') {
        data.horometro_actual = document.getElementById('maquinariaHorometro').value;
        data.horometro_compra = document.getElementById('maquinariaHorometroCompra').value;
        data.tipo_combustible = document.getElementById('maquinariaCombustible').value;
        data.consumo_promedio = document.getElementById('maquinariaConsumo').value;
        data.capacidad_tanque = document.getElementById('maquinariaCapacidad').value;
        data.peso_operativo = document.getElementById('maquinariaPeso').value;
        data.capacidad_carga = document.getElementById('maquinariaCapacidadCarga').value;
        data.licencia_requerida = document.getElementById('maquinariaLicencia').value;
    }
    
    // Vehículo
    if (tipo === 'vehiculo') {
        data.placas = document.getElementById('vehiculoPlacas').value;
        data.numero_economico = document.getElementById('vehiculoNumEconomico').value;
        data.vin = document.getElementById('vehiculoVin').value;
        data.kilometraje_actual = document.getElementById('vehiculoKilometraje').value;
        data.kilometraje_compra = document.getElementById('vehiculoKilometrajeCompra').value;
        data.tipo_vehiculo = document.getElementById('vehiculoTipo').value;
        data.traccion = document.getElementById('vehiculoTraccion').value;
        data.transmision = document.getElementById('vehiculoTransmision').value;
        data.capacidad_pasajeros = document.getElementById('vehiculoPasajeros').value;
        data.capacidad_carga = document.getElementById('vehiculoCapacidadCarga').value;
        data.tipo_combustible = document.getElementById('vehiculoCombustible').value;
        data.consumo_promedio = document.getElementById('vehiculoConsumo').value;
        data.poliza_seguro = document.getElementById('vehiculoPolizaSeguro').value;
        data.vencimiento_seguro = document.getElementById('vehiculoVencimientoSeguro').value;
        data.licencia_requerida = document.getElementById('vehiculoLicencia').value;
    }
    
    const url = editingId ? `/almacen/api/activos/${editingId}` : '/almacen/api/activos';
    const method = editingId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert('✅ ' + res.message);
            cerrarModalActivo();
            cargarActivos();
        } else {
            alert('❌ Error: ' + res.message);
        }
    });
}

function verDetalle(id) {
    fetch(`/almacen/api/activos/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const a = res.data;
                let html = `<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div><strong>Código:</strong> ${a.codigo}</div>
                    <div><strong>Nombre:</strong> ${a.nombre}</div>
                    <div><strong>Tipo:</strong> ${a.tipo_activo}</div>
                    <div><strong>Categoría:</strong> ${a.categoria || '---'}</div>
                    <div><strong>Marca/Modelo:</strong> ${a.marca || ''} ${a.modelo || ''}</div>
                    <div><strong>Serie:</strong> ${a.serie || '---'}</div>
                    <div><strong>Año:</strong> ${a.anio || '---'}</div>
                    <div><strong>Color:</strong> ${a.color || '---'}</div>
                    <div><strong>Ubicación:</strong> ${a.ubicacion_fisica || '---'}</div>
                    <div><strong>Estado:</strong> ${a.estado_general}</div>
                    <div><strong>Estatus:</strong> ${a.estatus}</div>
                    <div><strong>Proyecto:</strong> ${a.proyecto_asignado_nombre || 'No asignado'}</div>
                    <div><strong>Cuenta Contable:</strong> ${a.cuenta_contable || '---'}</div>
                    <div><strong>Valor Actual:</strong> ${a.valor_actual ? '$' + a.valor_actual.toLocaleString() : '---'}</div>
                </div>`;
                if (a.descripcion) html += `<hr><strong>Descripción:</strong><br>${a.descripcion}`;
                document.getElementById('detalleContenido').innerHTML = html;
                document.getElementById('modalDetalle').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
}

function eliminarActivo(id, codigo) {
    if (confirm(`¿Eliminar ${codigo}?`)) {
        fetch(`/almacen/api/activos/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('✅ ' + res.message);
                cargarActivos();
            } else {
                alert('❌ Error: ' + res.message);
            }
        });
    }
}

function cerrarModalActivo() {
    document.getElementById('modalActivo').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function cerrarModalDetalle() {
    document.getElementById('modalDetalle').style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { cerrarModalActivo(); cerrarModalDetalle(); } });
document.getElementById('modalActivo')?.addEventListener('click', (e) => { if (e.target === this) cerrarModalActivo(); });
document.getElementById('modalDetalle')?.addEventListener('click', (e) => { if (e.target === this) cerrarModalDetalle(); });
</script>
@endsection