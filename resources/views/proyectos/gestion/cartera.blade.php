@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="card mt-2">
            <div class="card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-project-diagram"></i> Cartera de Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Botón para nuevo proyecto -->
                

                <!-- BARRA DE FILTROS Y BÚSQUEDA -->
                <div class="card mb-3" style="border: 1px solid #dee2e6; border-radius: 8px;">
                    <div class="card-body" style="padding: 15px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; align-items: end;">
                            <!-- Buscador general -->
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #555;">Buscar</label>
                                <input type="text" id="filtroBusqueda" class="form-control" placeholder="Código, proyecto, cliente..." style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <!-- Filtro por estado -->
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #555;">Estado</label>
                                <select id="filtroEstado" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Todos</option>
                                    <option value="activo">Activo</option>
                                    <option value="borrador">Borrador</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="finalizado">Finalizado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                            <!-- Filtro por prioridad -->
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #555;">Prioridad</label>
                                <select id="filtroPrioridad" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Todas</option>
                                    <option value="alta">Alta</option>
                                    <option value="media">Media</option>
                                    <option value="baja">Baja</option>
                                </select>
                            </div>
                            <!-- Rango de fechas -->
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #555;">Fecha Inicio (desde)</label>
                                <input type="date" id="filtroFechaInicio" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; color: #555;">Fecha Inicio (hasta)</label>
                                <input type="date" id="filtroFechaFin" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <!-- Botones -->
                            <div style="display: flex; gap: 8px;">
                                <button onclick="limpiarFiltros()" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; white-space: nowrap;">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>
                                <button onclick="exportarExcel()" class="btn btn-success" style="background-color: #28a745; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; white-space: nowrap;">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORMULARIO DE ALTA/EDICIÓN (oculto por defecto) -->
                <div id="formularioProyecto" style="display: none; background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #083CAE;">
                    <h3 id="formTitle" style="color: #083CAE; margin-bottom: 20px;">Alta de Nuevo Proyecto</h3>
                    
                    <form id="proyectoForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="proyecto_id" name="proyecto_id" value="">
                        <input type="hidden" id="form_method" name="_method" value="POST">
                        
                        <!-- Datos Generales -->
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label>Código del Proyecto</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div style="grid-column: span 2;">
                                <label>Nombre del Proyecto <span style="color: red;">*</span></label>
                                <input type="text" id="nombre_proyecto" name="nombre_proyecto" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label>Tipo de Proyecto</label>
                                <select id="tipo_proyecto" name="tipo_proyecto" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Seleccionar...</option>
                                    <option value="construccion">Construcción</option>
                                    <option value="infraestructura">Infraestructura</option>
                                    <option value="industrial">Industrial</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="residencial">Residencial</option>
                                </select>
                            </div>
                            <div>
                                <label>Prioridad</label>
                                <select id="prioridad" name="prioridad" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="media">Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="baja">Baja</option>
                                </select>
                            </div>
                            <div>
                                <label>Ubicación</label>
                                <input type="text" id="ubicacion" name="ubicacion" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label>Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div>
                                <label>Fecha Fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                        </div>

                        <!-- Datos Cliente -->
                        <h4 style="color: #083CAE; margin: 20px 0 15px;">Datos del Cliente</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label>Cliente</label>
                                <input type="text" id="cliente_nombre" name="cliente_nombre" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div>
                                <label>RFC</label>
                                <input type="text" id="cliente_rfc" name="cliente_rfc" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div>
                                <label>Email</label>
                                <input type="email" id="cliente_email" name="cliente_email" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                        </div>

                        <!-- Datos Contrato -->
                        <h4 style="color: #083CAE; margin: 20px 0 15px;">Datos del Contrato</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label>Número Contrato</label>
                                <input type="text" id="numero_contrato" name="numero_contrato" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                            <div>
                                <label>Responsable</label>
                                <select id="responsable" name="responsable" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Seleccionar...</option>
                                    @foreach($usuarios ?? [] as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label>Presupuesto Total</label>
                                <input type="number" id="presupuesto_total" name="presupuesto_total" class="form-control" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                            </div>
                        </div>

                        <!-- Botones del formulario -->
                        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                            <button type="button" onclick="cerrarFormulario()" class="btn btn-secondary" style="background-color: #6c757d; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                            <button type="submit" class="btn btn-success" style="background-color: #28a745; color: white; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer;">Guardar</button>
                        </div>
                    </form>
                </div>

                <!-- MODAL DE DETALLE (oculto por defecto) -->
                <div id="modalDetalle" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto;">
                    <div style="background-color: white; margin: 50px auto; max-width: 800px; border-radius: 8px; padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #083CAE; padding-bottom: 10px; margin-bottom: 20px;">
                            <h3 style="color: #083CAE; margin: 0;">Detalle del Proyecto</h3>
                            <button onclick="cerrarModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                        </div>
                        <div id="detalleContenido"></div>
                    </div>
                </div>

                <!-- TABLA DE PROYECTOS -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto;">
                    <table class="table table-bordered" id="tablaProyectos" style="width: 100%; font-size: 13px;">
                        <thead style="background-color: #2378e1; color: white;">
                            <tr>
                                <th style="padding: 10px;">Código</th>
                                <th style="padding: 10px;">Proyecto</th>
                                <th style="padding: 10px;">Cliente</th>
                                <th style="padding: 10px;">Responsable</th>
                                <th style="padding: 10px;">Estado</th>
                                <th style="padding: 10px;">Prioridad</th>
                                <th style="padding: 10px;">Fecha Inicio</th>
                                <th style="padding: 10px;">Presupuesto</th>
                                <th style="padding: 10px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            @forelse($proyectos as $proyecto)
                            @php
                                $ejecutado = ($proyecto->costos->materiales ?? 0) + ($proyecto->costos->mano_obra ?? 0) + ($proyecto->costos->maquinaria ?? 0) + ($proyecto->costos->gastos_indirectos ?? 0);
                                // Normalizar fecha a YYYY-MM-DD para el filtro (mismo formato que input type=date)
                                $fechaFiltro = '';
                                if (!empty($proyecto->fecha_inicio)) {
                                    try {
                                        $fechaFiltro = \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('Y-m-d');
                                    } catch (\Exception $e) {
                                        $fechaFiltro = '';
                                    }
                                }
                            @endphp
                            <tr data-codigo="{{ $proyecto->codigo }}" 
                                data-nombre="{{ strtolower($proyecto->nombre) }}" 
                                data-cliente="{{ strtolower($proyecto->cliente_nombre) }}"
                                data-estado="{{ strtolower($proyecto->status ?? 'pendiente') }}"
                                data-prioridad="{{ strtolower($proyecto->prioridad ?? 'media') }}"
                                data-fecha-inicio="{{ $fechaFiltro }}">
                                <td style="padding: 8px;"><strong>{{ $proyecto->codigo }}</strong></td>
                                <td style="padding: 8px;">{{ $proyecto->nombre }}</td>
                                <td style="padding: 8px;">{{ $proyecto->cliente_nombre }}</td>
                                <td style="padding: 8px;">{{ $proyecto->responsable ? $proyecto->responsable->name : ($proyecto->cargo_responsable ?? '-') }}</td>
                                <td style="padding: 8px;">
                                    <span class="badge badge-{{ $proyecto->status === 'activo' ? 'success' : ($proyecto->status === 'borrador' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($proyecto->status ?? 'Pendiente') }}
                                    </span>
                                </td>
                                <td style="padding: 8px;">
                                    <span class="badge badge-{{ $proyecto->prioridad === 'alta' ? 'danger' : ($proyecto->prioridad === 'media' ? 'warning' : 'info') }}">
                                        {{ ucfirst($proyecto->prioridad ?? 'Media') }}
                                    </span>
                                </td>
                                <td style="padding: 8px;">{{ $proyecto->fecha_inicio ? date('d/m/Y', strtotime($proyecto->fecha_inicio)) : '-' }}</td>
                                <td style="padding: 8px; text-align: right;">${{ number_format($proyecto->presupuesto_total, 2) }}</td>
                                <td style="padding: 8px;">
                                    <div style="display: flex; gap: 8px;">
                                        <button onclick="verDetalle({{ $proyecto->id }})" class="btn-action" style="background: none; border: none; color: #17a2b8; cursor: pointer;" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editarProyecto({{ $proyecto->id }})" class="btn-action" style="background: none; border: none; color: #ffc107; cursor: pointer;" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="eliminarProyecto({{ $proyecto->id }})" class="btn-action" style="background: none; border: none; color: #dc3545; cursor: pointer;" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="filaVacia">
                                <td colspan="9" style="text-align: center; padding: 40px;">No hay proyectos registrados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Mensaje cuando no hay resultados de filtro -->
                    <div id="sinResultados" style="display: none; text-align: center; padding: 30px; color: #6c757d;">
                        <i class="fas fa-search" style="font-size: 24px; margin-bottom: 10px;"></i>
                        <p>No se encontraron proyectos con los filtros aplicados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-success { background-color: #28a745; color: white; }
    .badge-danger { background-color: #dc3545; color: white; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-info { background-color: #17a2b8; color: white; }
    .badge-secondary { background-color: #6c757d; color: white; }
    .form-control:focus { outline: none; border-color: #083CAE; box-shadow: 0 0 0 2px rgba(8,60,174,0.1); }
    .btn-action:hover { opacity: 0.7; transform: scale(1.1); }
    #tablaBody tr:hover { background-color: #f5f5f5; cursor: pointer; }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Variables globales
let editMode = false;
let currentProyectoId = null;

// ---------------------------------------------------------
// FUNCIONES DE FILTRO Y BÚSQUEDA
// ---------------------------------------------------------

// Aplicar filtros a la tabla
function aplicarFiltros() {
    const busqueda = document.getElementById('filtroBusqueda').value.toLowerCase().trim();
    const estado = document.getElementById('filtroEstado').value.toLowerCase();
    const prioridad = document.getElementById('filtroPrioridad').value.toLowerCase();
    const fechaInicioDesde = document.getElementById('filtroFechaInicio').value; // YYYY-MM-DD
    const fechaInicioHasta = document.getElementById('filtroFechaFin').value;   // YYYY-MM-DD

    const filas = document.querySelectorAll('#tablaBody tr[data-codigo]');
    let visibles = 0;

    filas.forEach(fila => {
        const codigo = (fila.dataset.codigo || '').toLowerCase();
        const nombre = (fila.dataset.nombre || '').toLowerCase();
        const cliente = (fila.dataset.cliente || '').toLowerCase();
        const estadoFila = (fila.dataset.estado || '').toLowerCase();
        const prioridadFila = (fila.dataset.prioridad || '').toLowerCase();
        const fechaFila = (fila.dataset.fechaInicio || '').trim(); // YYYY-MM-DD

        // Filtro de búsqueda general
        let coincideBusqueda = true;
        if (busqueda) {
            coincideBusqueda = codigo.includes(busqueda) || 
                              nombre.includes(busqueda) || 
                              cliente.includes(busqueda);
        }

        // Filtro de estado
        let coincideEstado = true;
        if (estado) {
            coincideEstado = estadoFila === estado;
        }

        // Filtro de prioridad
        let coincidePrioridad = true;
        if (prioridad) {
            coincidePrioridad = prioridadFila === prioridad;
        }

        // Filtro de rango de fechas (comparación directa de strings YYYY-MM-DD)
        let coincideFecha = true;
        if (fechaInicioDesde || fechaInicioHasta) {
            if (!fechaFila) {
                coincideFecha = false;
            } else {
                if (fechaInicioDesde && fechaFila < fechaInicioDesde) {
                    coincideFecha = false;
                }
                if (fechaInicioHasta && fechaFila > fechaInicioHasta) {
                    coincideFecha = false;
                }
            }
        }

        if (coincideBusqueda && coincideEstado && coincidePrioridad && coincideFecha) {
            fila.style.display = '';
            visibles++;
        } else {
            fila.style.display = 'none';
        }
    });

    // Mostrar mensaje si no hay resultados
    const sinResultados = document.getElementById('sinResultados');
    const filaVacia = document.getElementById('filaVacia');
    if (visibles === 0 && filas.length > 0) {
        sinResultados.style.display = 'block';
        if (filaVacia) filaVacia.style.display = 'none';
    } else {
        sinResultados.style.display = 'none';
        if (filaVacia) filaVacia.style.display = '';
    }
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('filtroBusqueda').value = '';
    document.getElementById('filtroEstado').value = '';
    document.getElementById('filtroPrioridad').value = '';
    document.getElementById('filtroFechaInicio').value = '';
    document.getElementById('filtroFechaFin').value = '';
    aplicarFiltros();
}

// ---------------------------------------------------------
// EXPORTAR A EXCEL (solo filas visibles)
// ---------------------------------------------------------
function exportarExcel() {
    const filas = document.querySelectorAll('#tablaBody tr[data-codigo]');
    const filasVisibles = Array.from(filas).filter(f => f.style.display !== 'none');

    if (filasVisibles.length === 0) {
        mostrarNotificacion('No hay datos para exportar con los filtros actuales', 'error');
        return;
    }

    let html = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" 
              xmlns:x="urn:schemas-microsoft-com:office:excel" 
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="UTF-8">
            <style>
                table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 12px; }
                th { background-color: #2378e1; color: white; padding: 8px; border: 1px solid #ccc; text-align: left; }
                td { padding: 6px; border: 1px solid #ccc; }
            </style>
        </head>
        <body>
            <h3>Cartera de Proyectos</h3>
            <p>Generado: ${new Date().toLocaleString()}</p>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Proyecto</th>
                        <th>Cliente</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha Inicio</th>
                        <th>Presupuesto</th>
                    </tr>
                </thead>
                <tbody>
    `;

    filasVisibles.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        const codigo = celdas[0]?.innerText.trim() || '';
        const proyecto = celdas[1]?.innerText.trim() || '';
        const cliente = celdas[2]?.innerText.trim() || '';
        const responsable = celdas[3]?.innerText.trim() || '';
        const estado = celdas[4]?.innerText.trim() || '';
        const prioridad = celdas[5]?.innerText.trim() || '';
        const fecha = celdas[6]?.innerText.trim() || '';
        const presupuesto = celdas[7]?.innerText.trim() || '';

        html += `
            <tr>
                <td>${codigo}</td>
                <td>${proyecto}</td>
                <td>${cliente}</td>
                <td>${responsable}</td>
                <td>${estado}</td>
                <td>${prioridad}</td>
                <td>${fecha}</td>
                <td>${presupuesto}</td>
            </tr>
        `;
    });

    html += `
                </tbody>
            </table>
        </body>
        </html>
    `;

    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `cartera_proyectos_${new Date().toISOString().slice(0,10)}.xls`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    mostrarNotificacion('Excel exportado correctamente', 'success');
}

// ---------------------------------------------------------
// FUNCIONES EXISTENTES (crear, editar, ver, eliminar)
// ---------------------------------------------------------

// Mostrar formulario de creación
function mostrarFormularioCreacion() {
    editMode = false;
    currentProyectoId = null;
    document.getElementById('formTitle').innerHTML = 'Alta de Nuevo Proyecto';
    document.getElementById('proyectoForm').reset();
    document.getElementById('proyecto_id').value = '';
    document.getElementById('form_method').value = 'POST';
    document.getElementById('proyectoForm').action = '{{ route("proyectos.store") }}';
    document.getElementById('formularioProyecto').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Cerrar formulario
function cerrarFormulario() {
    document.getElementById('formularioProyecto').style.display = 'none';
    editMode = false;
    currentProyectoId = null;
}

// Editar proyecto
function editarProyecto(id) {
    editMode = true;
    currentProyectoId = id;
    
    fetch(`/proyectos/${id}/edit-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('formTitle').innerHTML = 'Editar Proyecto';
                document.getElementById('proyecto_id').value = data.proyecto.id;
                document.getElementById('codigo').value = data.proyecto.codigo;
                document.getElementById('nombre_proyecto').value = data.proyecto.nombre;
                document.getElementById('tipo_proyecto').value = data.proyecto.tipo_proyecto;
                document.getElementById('prioridad').value = data.proyecto.prioridad;
                document.getElementById('ubicacion').value = data.proyecto.ubicacion;
                document.getElementById('fecha_inicio').value = data.proyecto.fecha_inicio;
                document.getElementById('fecha_fin').value = data.proyecto.fecha_fin;
                document.getElementById('cliente_nombre').value = data.proyecto.cliente_nombre;
                document.getElementById('cliente_rfc').value = data.proyecto.cliente_rfc;
                document.getElementById('cliente_email').value = data.proyecto.cliente_email;
                document.getElementById('numero_contrato').value = data.proyecto.numero_contrato;
                document.getElementById('responsable').value = data.proyecto.responsable_id;
                document.getElementById('presupuesto_total').value = data.proyecto.presupuesto_total;
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('proyectoForm').action = `/proyectos/${id}`;
                document.getElementById('formularioProyecto').style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar datos del proyecto', 'error');
        });
}

// Ver detalle del proyecto
function verDetalle(id) {
    fetch(`/proyectos/${id}/detalle`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.proyecto;
                const ejecutado = p.costos ? (p.costos.materiales + p.costos.mano_obra + p.costos.maquinaria + p.costos.gastos_indirectos) : 0;
                const desviacion = p.presupuesto_total > 0 ? ((ejecutado - p.presupuesto_total) / p.presupuesto_total * 100) : 0;
                
                let equipoHtml = '';
                if (p.equipo && p.equipo.length > 0) {
                    equipoHtml = '<h5>Equipo del Proyecto</h5><table class="table table-bordered" style="font-size:12px"><thead><tr><th>Nombre</th><th>Rol</th><th>Dedicación</th></tr></thead><tbody>';
                    p.equipo.forEach(m => {
                        equipoHtml += `<tr><td>${m.nombre}</td><td>${m.rol}</td><td>${m.dedicacion}%</td></tr>`;
                    });
                    equipoHtml += '</tbody></table>';
                }
                
                document.getElementById('detalleContenido').innerHTML = `
                    <div style="display: grid; gap: 15px;">
                        <div><strong>Código:</strong> ${p.codigo}</div>
                        <div><strong>Proyecto:</strong> ${p.nombre}</div>
                        <div><strong>Cliente:</strong> ${p.cliente_nombre}</div>
                        <div><strong>RFC:</strong> ${p.cliente_rfc}</div>
                        <div><strong>Responsable:</strong> ${p.responsable ? p.responsable.name : (p.cargo_responsable || '-')}</div>
                        <div><strong>Estado:</strong> ${p.status || 'Pendiente'}</div>
                        <div><strong>Prioridad:</strong> ${p.prioridad || 'Media'}</div>
                        <div><strong>Fechas:</strong> ${p.fecha_inicio ? new Date(p.fecha_inicio).toLocaleDateString() : '-'} al ${p.fecha_fin ? new Date(p.fecha_fin).toLocaleDateString() : '-'}</div>
                        <div><strong>Ubicación:</strong> ${p.ubicacion || '-'}</div>
                        <div><strong>Presupuesto:</strong> $${Number(p.presupuesto_total).toLocaleString()}</div>
                        <div><strong>Ejecutado:</strong> $${ejecutado.toLocaleString()}</div>
                        <div><strong>Desviación:</strong> <span style="${desviacion >= 0 ? 'color:green' : 'color:red'}">${desviacion.toFixed(1)}%</span></div>
                        <div><strong>Contrato:</strong> ${p.numero_contrato || '-'}</div>
                        ${p.descripcion ? `<div><strong>Descripción:</strong> ${p.descripcion}</div>` : ''}
                        ${equipoHtml}
                    </div>
                `;
                document.getElementById('modalDetalle').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al cargar detalle', 'error');
        });
}

// Eliminar proyecto
function eliminarProyecto(id) {
    if (confirm('¿Está seguro de eliminar este proyecto?')) {
        fetch(`/proyectos/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('Proyecto eliminado', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                mostrarNotificacion(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Error al eliminar', 'error');
        });
    }
}

// Cerrar modal
function cerrarModal() {
    document.getElementById('modalDetalle').style.display = 'none';
}

// Envío del formulario
document.getElementById('proyectoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = this.action;
    const method = document.getElementById('form_method').value;
    
    if (method === 'PUT') {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion(data.message, 'success');
            cerrarFormulario();
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarNotificacion(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al guardar', 'error');
    });
});

// Mostrar notificación
function mostrarNotificacion(mensaje, tipo) {
    const notificacion = document.createElement('div');
    notificacion.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 12px 20px;
        background-color: ${tipo === 'success' ? '#28a745' : tipo === 'error' ? '#dc3545' : '#17a2b8'};
        color: white; border-radius: 4px; z-index: 9999; font-size: 14px;
        animation: fadeIn 0.3s;
    `;
    notificacion.textContent = mensaje;
    document.body.appendChild(notificacion);
    setTimeout(() => notificacion.remove(), 3000);
}

// ---------------------------------------------------------
// INICIALIZACIÓN: Eventos de filtro
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filtroBusqueda').addEventListener('input', aplicarFiltros);
    document.getElementById('filtroEstado').addEventListener('change', aplicarFiltros);
    document.getElementById('filtroPrioridad').addEventListener('change', aplicarFiltros);
    document.getElementById('filtroFechaInicio').addEventListener('change', aplicarFiltros);
    document.getElementById('filtroFechaFin').addEventListener('change', aplicarFiltros);
});
</script>
@endsection