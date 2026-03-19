@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Plantilla de Personal RH -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Plantilla de Personal
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Selector de registros por página -->
                <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label style="font-size: 13px; color: #6c757d;">Mostrar:</label>
                        <select id="perPage" style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px;" onchange="cambiarRegistrosPorPagina()">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span style="font-size: 13px; color: #6c757d;">registros por página</span>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>

                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar"
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;"
                                    title="Agregar empleado"
                                    onclick="abrirModalEmpleado()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel"
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="exportarExcel()">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas"
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>

                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 220px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar empleado..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Plantilla -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaPlantilla" style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 2500px;">
                        <thead style="background-color: var(--color-primary);">
                            <tr id="encabezadosTabla"></tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Los datos se cargarán vía API -->
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="paginacion" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding: 10px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                    <div style="font-size: 13px; color: #6c757d;">
                        Mostrando <span id="desde">0</span> a <span id="hasta">0</span> de <span id="total">0</span> registros
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button id="prevPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPagina('prev')" disabled>Anterior</button>
                        <span id="paginaActual" style="padding: 6px 12px; background-color: var(--color-primary); color: white; border-radius: 4px; font-size: 13px;">1</span>
                        <button id="nextPage" style="padding: 6px 12px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="cambiarPagina('next')">Siguiente</button>
                    </div>
                </div>

                <!-- Totales -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start; gap: 20px; padding: 10px; background-color: #e9ecef; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    <span>Total Empleados: <span id="totalEmpleados" style="color: var(--color-primary);">0</span></span>
                    <span style="color: #28a745;">Activos: <span id="totalActivos">0</span></span>
                    <span style="color: #ffc107;">Inactivos: <span id="totalInactivos">0</span></span>
                    <span style="color: #17a2b8;">Operadores: <span id="totalOperadores">0</span></span>
                </div>

                <!-- Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter" style="font-size: 12px;"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR EMPLEADO - VERSIÓN COMPLETA -->
<div id="modalEmpleado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1200px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">

        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloEmpleado">
                    <i class="fas fa-user-plus" style="margin-right: 10px;"></i>Nuevo Empleado
                </h3>
                <button onclick="cerrarModalEmpleado()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Formulario -->
        <div style="padding: 25px;">
            <form id="formEmpleado" onsubmit="event.preventDefault(); guardarEmpleado();">
                @csrf
                <input type="hidden" id="modalEmpleadoId" value="">

                <!-- INFORMACIÓN PERSONAL BÁSICA -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-id-card"></i> Información Personal Básica
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div style="grid-column: span 1;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                            <select id="modalEstatus" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Vacaciones">Vacaciones</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                        <div style="grid-column: span 1;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">No. Interno</label>
                            <input type="text" id="modalNumeroInterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="EMP-001">
                        </div>
                        <div style="grid-column: span 1;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Fecha Ingreso</label>
                            <input type="date" id="modalFechaIngreso" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                        </div>
                        <div style="grid-column: span 1;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Reclutador</label>
                            <input type="text" id="modalReclutador" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Reclutador">
                        </div>
                    </div>
                </div>

                <!-- NOMBRE COMPLETO -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-user"></i> Nombre Completo
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Nombre(s) *</label>
                            <input type="text" id="modalNombre" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Nombre" required>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Apellido Paterno</label>
                            <input type="text" id="modalApellidoPaterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Apellido Paterno">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Apellido Materno</label>
                            <input type="text" id="modalApellidoMaterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Apellido Materno">
                        </div>
                    </div>
                </div>

                <!-- DATOS FISCALES Y SEGURIDAD SOCIAL -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-invoice"></i> Datos Fiscales y Seguridad Social
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">RFC</label>
                            <input type="text" id="modalRfc" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="RFC">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">CURP</label>
                            <input type="text" id="modalCurp" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="CURP">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">NSS</label>
                            <input type="text" id="modalNss" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="NSS">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Alias</label>
                            <input type="text" id="modalAlias" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Alias">
                        </div>
                    </div>
                </div>

                <!-- DATOS DE CONTACTO -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-phone-alt"></i> Datos de Contacto
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Correo Electrónico</label>
                            <input type="email" id="modalCorreo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="correo@ejemplo.com">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Celular</label>
                            <input type="tel" id="modalCelular" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="(55) 1234-5678">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Fecha Nacimiento</label>
                            <input type="date" id="modalFechaNacimiento" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                        </div>
                        <div style="grid-column: span 2;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Contacto Emergencia</label>
                            <input type="text" id="modalContactoEmergencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Nombre del contacto de emergencia">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tel. Emergencia</label>
                            <input type="text" id="modalNumeroEmergencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Teléfono emergencia">
                        </div>
                    </div>
                </div>

                <!-- DIRECCIÓN COMPLETA -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt"></i> Dirección
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
                        <div style="grid-column: span 2;">
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Calle</label>
                            <input type="text" id="modalCalle" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Calle">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">No. Exterior</label>
                            <input type="text" id="modalNumExt" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Ext">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">No. Interior</label>
                            <input type="text" id="modalNumInt" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Int">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">C.P.</label>
                            <input type="text" id="modalCp" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="C.P.">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">País</label>
                            <select id="modalPais" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="MEX" selected>México</option>
                                <option value="USA">Estados Unidos</option>
                                <option value="CAN">Canadá</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Estado</label>
                            <input type="text" id="modalEstado" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Estado">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Municipio</label>
                            <input type="text" id="modalMunicipio" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Municipio">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Colonia</label>
                            <input type="text" id="modalColonia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Colonia">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Localidad</label>
                            <input type="text" id="modalLocalidad" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Localidad">
                        </div>
                    </div>
                </div>

                <!-- DATOS LABORALES (CON SUELDO INCLUIDO Y FILTRO DE PUESTOS POR ÁREA) -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-briefcase"></i> Datos Laborales
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Área</label>
                            <select id="modalArea" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" onchange="cargarPuestosPorArea()">
                                <option value="">Seleccionar área</option>
                                @foreach($areas ?? [] as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Puesto</label>
                            <select id="modalPuesto" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccione un área primero</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Sueldo</label>
                            <input type="number" id="modalSueldo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Coordinador</label>
                            <input type="text" id="modalCoordinador" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Coordinador">
                        </div>
                    </div>
                </div>

                <!-- DATOS DE OPERADOR (si aplica) -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-truck"></i> Datos de Operador
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">¿Es Operador?</label>
                            <select id="modalOperador" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tipo Operador</label>
                            <select id="modalTipoOperador" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="1">Operador de Carga</option>
                                <option value="2">Operador de Pasaje</option>
                                <option value="3">Operador de Maquinaria</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tipo Licencia</label>
                            <select id="modalTipoLicencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="1">A - Automovilista</option>
                                <option value="2">B - Chofer</option>
                                <option value="3">C - Pasajeros</option>
                                <option value="4">D - Carga</option>
                                <option value="5">E - Federal Pasajeros</option>
                                <option value="6">F - Federal Carga</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">No. Licencia</label>
                            <input type="text" id="modalNumeroLicencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Número de licencia">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Vencimiento Licencia</label>
                            <input type="date" id="modalVencimientoLicencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Reconocimiento</label>
                            <input type="text" id="modalLicenciaReconocimiento" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Reconocimiento">
                        </div>
                    </div>
                </div>

                <!-- DATOS DE NÓMINA SAT -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calculator"></i> Datos de Nómina SAT
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tipo Contrato</label>
                            <select id="modalTipoContrato" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="01">Tiempo Indeterminado</option>
                                <option value="02">Obra Determinada</option>
                                <option value="03">Tiempo Determinado</option>
                                <option value="04">Temporada</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tipo Jornada</label>
                            <select id="modalTipoJornada" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="01">Diurna</option>
                                <option value="02">Nocturna</option>
                                <option value="03">Mixta</option>
                                <option value="04">Por Hora</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Periodicidad Pago</label>
                            <select id="modalPeriodicidad" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="01">Diario</option>
                                <option value="02">Semanal</option>
                                <option value="03">Catorcenal</option>
                                <option value="04">Quincenal</option>
                                <option value="05">Mensual</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Régimen</label>
                            <select id="modalRegimen" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="02">Sueldos</option>
                                <option value="05">Asimilados</option>
                                <option value="06">Alimentación</option>
                                <option value="07">Habitación</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATOS BANCARIOS -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-university"></i> Datos Bancarios
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Banco</label>
                            <select id="modalBanco" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="002">BANAMEX</option>
                                <option value="012">BBVA BANCOMER</option>
                                <option value="014">SANTANDER</option>
                                <option value="021">HSBC</option>
                                <option value="022">GE CAPITAL</option>
                                <option value="030">BAJIO</option>
                                <option value="036">INBURSA</option>
                                <option value="042">MIFEL</option>
                                <option value="044">SCOTIABANK</option>
                                <option value="058">BANREGIO</option>
                                <option value="059">INVEX</option>
                                <option value="062">AFIRME</option>
                                <option value="072">BANORTE</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Tipo Cuenta</label>
                            <select id="modalTipoCuenta" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="1">Débito</option>
                                <option value="2">Crédito</option>
                                <option value="3">Nómina</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">CLABE</label>
                            <input type="text" id="modalClabe" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="CLABE">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Cuenta</label>
                            <input type="text" id="modalCuenta" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Número de cuenta">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Propietario</label>
                            <input type="text" id="modalPropietario" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Propietario de la cuenta">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Sucursal</label>
                            <input type="text" id="modalSucursal" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Sucursal">
                        </div>
                    </div>
                </div>

                <!-- PRESTACIONES Y BENEFICIOS -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-gift"></i> Prestaciones y Beneficios
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Días Vacaciones</label>
                            <input type="number" id="modalDiasVacaciones" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0" min="0" value="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Prima Vacacional %</label>
                            <input type="number" id="modalPrimaVacacional" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="25" step="0.01" min="0" max="100" value="25">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Aguinaldo (días)</label>
                            <input type="number" id="modalAguinaldo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="15" min="0" value="15">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Bono Asistencia</label>
                            <select id="modalBonoAsistencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Bono Productividad</label>
                            <select id="modalBonoProductividad" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Aplica Asistencia</label>
                            <select id="modalAplicaAsistencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">FONACOT</label>
                            <select id="modalFonacot" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Pensión Alimenticia</label>
                            <select id="modalPensionAlimenticia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- MONTO IMSS E INFONAVIT -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-heartbeat"></i> Montos IMSS e INFONAVIT
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Mensual IMSS</label>
                            <input type="number" id="modalMontoMensualImss" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Diario IMSS</label>
                            <input type="number" id="modalMontoDiarioImss" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Mensual INFONAVIT</label>
                            <input type="number" id="modalMontoMensualInfonavit" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Diario INFONAVIT</label>
                            <input type="number" id="modalMontoDiarioInfonavit" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Mensual ISR</label>
                            <input type="number" id="modalMontoMensualIsr" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Monto Diario ISR</label>
                            <input type="number" id="modalMontoDiarioIsr" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                <!-- FECHAS DE BAJA -->
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calendar-times"></i> Fechas de Baja
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Fecha Baja</label>
                            <input type="date" id="modalFechaBaja" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Motivo Baja</label>
                            <select id="modalMotivoBaja" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                <option value="">Seleccionar</option>
                                <option value="1">Renuncia Voluntaria</option>
                                <option value="2">Despido</option>
                                <option value="3">Jubilación</option>
                                <option value="4">Fin de Contrato</option>
                                <option value="5">Defunción</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
                    <button type="button" onclick="cerrarModalEmpleado()" style="padding: 10px 24px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 10px 30px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE DEL EMPLEADO -->
<div id="modalVerEmpleado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1000px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0; font-size: 18px;">
                    <i class="fas fa-user" style="margin-right: 10px;"></i>Detalle del Empleado
                </h3>
                <button onclick="cerrarModalVer()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- Contenido -->
        <div style="padding: 25px;" id="detalleEmpleadoContenido">
            <!-- El contenido se llenará dinámicamente con JavaScript -->
        </div>
    </div>
</div>

<!-- Notificación personalizada -->
<div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000000; min-width: 300px; max-width: 400px; background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease; overflow: hidden;">
    <div id="notificationHeader" style="padding: 15px 20px; font-weight: bold; display: flex; align-items: center; gap: 10px;">
        <i id="notificationIcon" class="fas"></i>
        <span id="notificationTitle"></span>
    </div>
    <div id="notificationBody" style="padding: 15px 20px; border-top: 1px solid #eee;">
        <span id="notificationMessage"></span>
    </div>
</div>

<style>
    :root {
        --color-primary: #083CAE;
        --color-secondary: #2CBF1F;
        --color-accent: #eaf512;
        --color-red: #FF0000;
    }

    /* Estilos generales */
    .semaforo .card-header h2 {
        color: var(--color-primary) !important;
    }

    /* Tabla */
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow-x: auto;
        background-color: white;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }

    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 13px;
        vertical-align: middle;
    }

    /* Filas alternadas */
    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tbody tr:hover {
        background-color: #e8f0fe;
    }

    /* Columna de acciones fija */
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
    }

    .table th:last-child {
        background-color: var(--color-primary) !important;
    }

    .table td:last-child {
        background-color: white !important;
        text-align: center !important;
    }

    tbody tr:nth-child(even) td:last-child {
        background-color: #f8f9fa !important;
    }

    tbody tr:hover td:last-child {
        background-color: #e8f0fe !important;
    }

    /* Iconos de acción */
    .table td:last-child i {
        margin: 0 5px;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .table td:last-child i:hover {
        transform: scale(1.2);
    }

    .table td:last-child i.fa-edit,
    .table td:last-child i.fa-eye {
        color: var(--color-primary);
    }

    .table td:last-child i.fa-trash {
        color: #dc3545;
    }

    /* Badges de estatus */
    .badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }

    .badge-activo {
        background-color: #28a745;
        color: white;
    }

    .badge-inactivo {
        background-color: #6c757d;
        color: white;
    }

    .badge-vacaciones {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-baja {
        background-color: #dc3545;
        color: white;
    }

    /* Drag & drop */
    [draggable="true"] {
        cursor: grab;
    }

    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        background-color: #e8f0fe;
        border-radius: 30px;
        color: var(--color-primary);
        font-size: 11px;
        border: 1px solid var(--color-primary);
    }

    .columna-agrupada .remover {
        margin-left: 5px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: var(--color-primary);
    }

    /* Modal */
    #modalEmpleado, #modalVerEmpleado {
        display: none;
        align-items: center;
        justify-content: center;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Tarjetas de detalle */
    .detalle-seccion {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .detalle-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 12px;
    }
    .detalle-item {
        margin-bottom: 8px;
    }
    .detalle-item strong {
        font-size: 12px;
        color: #6c757d;
        display: block;
        margin-bottom: 2px;
    }
    .detalle-item span {
        font-size: 14px;
        font-weight: 500;
        color: #212529;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }

        .table-container {
            max-height: 500px;
        }

        .table td {
            padding: 8px 4px;
            font-size: 12px;
        }

        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }

        #modalEmpleado > div, #modalVerEmpleado > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }

        #notification {
            min-width: auto;
            max-width: 90%;
            right: 5%;
            left: 5%;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables para áreas y puestos
    let todosLosPuestos = [];

    // Definición de columnas
    const columnas = [
        { field: 'estatus_txt', caption: 'Estatus', visible: true, type: 'badge' },
        { field: 'plantilla_id', caption: 'ID', visible: true, type: 'number' },
        { field: 'numero_empleado_interno', caption: 'No. Interno', visible: true },
        { field: 'nombre_completo', caption: 'Nombre Completo', visible: true },
        { field: 'rfc', caption: 'RFC', visible: true },
        { field: 'curp', caption: 'CURP', visible: false },
        { field: 'numero_seguro_social', caption: 'NSS', visible: false },
        { field: 'numero_licencia', caption: 'Licencia', visible: true },
        { field: 'vencimiento_licencia', caption: 'Venc. Licencia', visible: false, type: 'date' },
        { field: 'fecha_nacimiento', caption: 'F. Nacimiento', visible: false, type: 'date' },
        { field: 'fecha_ingreso', caption: 'F. Ingreso', visible: false, type: 'date' },
        { field: 'correo', caption: 'Correo', visible: false },
        { field: 'celular', caption: 'Celular', visible: false },
        { field: 'satcat_codigos_postales_codigo_postal', caption: 'C.P.', visible: true },
        { field: 'calle', caption: 'Calle', visible: true },
        { field: 'num_exterior', caption: 'No. Exterior', visible: true },
        { field: 'num_interior', caption: 'No. Interior', visible: false },
        { field: 'colonia', caption: 'Colonia', visible: true },
        { field: 'municipio', caption: 'Municipio', visible: true },
        { field: 'estado', caption: 'Estado', visible: true },
        { field: 'pais', caption: 'País', visible: true },
        { field: 'area', caption: 'Área', visible: true },
        { field: 'puesto', caption: 'Puesto', visible: true },
        { field: 'sueldo', caption: 'Sueldo', visible: true, type: 'currency' }, // <-- SUELDO AHORA VISIBLE
        { field: 'coordinador', caption: 'Coordinador', visible: true },
        { field: 'is_operador', caption: 'Operador', visible: true, type: 'boolean' },
        { field: 'tipo_operador', caption: 'Tipo Operador', visible: false },
        { field: 'tipo_licencia', caption: 'Tipo Licencia', visible: false },
        { field: 'cuenta', caption: 'Tipo Cuenta', visible: false },
        { field: 'cuenta_clabe', caption: 'CLABE', visible: false },
        { field: 'banco', caption: 'Banco', visible: false }
    ];

    // Variables de estado
    let datos = [];
    let datosFiltrados = [];
    let columnasVisibles = columnas.filter(col => col.visible).map(col => col.field);
    let columnasAgrupadas = [];

    // Variables de paginación
    let paginaActual = 1;
    let registrosPorPagina = 10;
    let totalRegistros = 0;
    let modoAgrupado = false;
    let datosAgrupados = [];

    // Cargar datos iniciales
    cargarDatos();

    // Función para cargar datos desde la API
    function cargarDatos() {
        fetch('/api/plantilla/datagrid', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos de API:', data);

            if (data.success) {
                datos = data.data || [];
                datosFiltrados = [...datos];
                totalRegistros = datos.length;

                // Actualizar contadores
                document.getElementById('totalEmpleados').textContent = data.total || datos.length;
                document.getElementById('totalActivos').textContent = data.activos || 0;
                document.getElementById('totalInactivos').textContent = data.inactivos || 0;
                document.getElementById('totalOperadores').textContent = datos.filter(d => d.operador === true || d.operador === 1 || d.is_operador === 'Sí').length || 0;

                renderizarTabla();
                actualizarPaginacion();
                renderizarEncabezados();
            } else {
                mostrarNotificacion('error', 'Error al cargar los datos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error de conexión al servidor');
        });
    }

    // Función para cargar puestos por área
    window.cargarPuestosPorArea = function() {
        const areaId = document.getElementById('modalArea').value;
        const selectPuesto = document.getElementById('modalPuesto');

        if (!areaId) {
            selectPuesto.innerHTML = '<option value="">Seleccione un área primero</option>';
            return;
        }

        selectPuesto.innerHTML = '<option value="">Cargando puestos...</option>';

        fetch(`/api/puestos-por-area?area_id=${areaId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                todosLosPuestos = data.data;
                llenarSelectPuestos(areaId);
            } else {
                selectPuesto.innerHTML = '<option value="">Error al cargar puestos</option>';
            }
        })
        .catch(error => {
            console.error('Error al cargar puestos:', error);
            selectPuesto.innerHTML = '<option value="">Error al cargar puestos</option>';
        });
    };

    // Función para llenar el select de puestos
    function llenarSelectPuestos(areaId) {
        const selectPuesto = document.getElementById('modalPuesto');
        const puestosFiltrados = todosLosPuestos.filter(p => p.area_id == areaId);

        if (puestosFiltrados.length > 0) {
            let options = '<option value="">Seleccionar puesto</option>';
            puestosFiltrados.forEach(puesto => {
                options += `<option value="${puesto.id}">${puesto.nombre}</option>`;
            });
            selectPuesto.innerHTML = options;
        } else {
            selectPuesto.innerHTML = '<option value="">No hay puestos para esta área</option>';
        }
    }

    // Renderizar encabezados
    function renderizarEncabezados() {
        const thead = document.getElementById('encabezadosTabla');
        if (!thead) return;

        let html = '';
        columnas.filter(col => columnasVisibles.includes(col.field)).forEach(col => {
            html += `<th draggable="true" data-columna="${col.field}" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white;">${col.caption}</th>`;
        });
        html += `<th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white;">Acciones</th>`;
        thead.innerHTML = html;
    }

    // Función para cambiar número de registros por página
    window.cambiarRegistrosPorPagina = function() {
        const perPage = document.getElementById('perPage').value;
        registrosPorPagina = parseInt(perPage);
        paginaActual = 1;
        renderizarTabla();
        actualizarPaginacion();
    };

    // Funciones de paginación
    window.cambiarPagina = function(direccion) {
        if (direccion === 'prev' && paginaActual > 1) {
            paginaActual--;
        } else if (direccion === 'next' && paginaActual < Math.ceil(totalRegistros / registrosPorPagina)) {
            paginaActual++;
        }
        renderizarTabla();
        actualizarPaginacion();
    };

    function actualizarPaginacion() {
        const totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
        const desde = totalRegistros === 0 ? 0 : (paginaActual - 1) * registrosPorPagina + 1;
        const hasta = Math.min(paginaActual * registrosPorPagina, totalRegistros);

        document.getElementById('desde').textContent = desde;
        document.getElementById('hasta').textContent = hasta;
        document.getElementById('total').textContent = totalRegistros;
        document.getElementById('paginaActual').textContent = paginaActual;

        document.getElementById('prevPage').disabled = paginaActual === 1;
        document.getElementById('nextPage').disabled = paginaActual === totalPaginas || totalPaginas === 0;
    }

    // Función para mostrar notificaciones
    function mostrarNotificacion(tipo, mensaje) {
        const notification = document.getElementById('notification');
        const header = document.getElementById('notificationHeader');
        const icon = document.getElementById('notificationIcon');
        const title = document.getElementById('notificationTitle');
        const body = document.getElementById('notificationMessage');

        if (tipo === 'success') {
            header.style.backgroundColor = '#28a745';
            header.style.color = 'white';
            icon.className = 'fas fa-check-circle';
            title.textContent = 'Éxito';
        } else if (tipo === 'error') {
            header.style.backgroundColor = '#dc3545';
            header.style.color = 'white';
            icon.className = 'fas fa-times-circle';
            title.textContent = 'Error';
        } else if (tipo === 'warning') {
            header.style.backgroundColor = '#ffc107';
            header.style.color = '#212529';
            icon.className = 'fas fa-exclamation-triangle';
            title.textContent = 'Advertencia';
        } else {
            header.style.backgroundColor = '#17a2b8';
            header.style.color = 'white';
            icon.className = 'fas fa-info-circle';
            title.textContent = 'Información';
        }

        body.textContent = mensaje;
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Función para agrupar datos
    function agruparDatos(columna) {
        const grupos = {};

        datosFiltrados.forEach(item => {
            let valor = item[columna];
            if (valor === null || valor === undefined || valor === '') valor = 'Sin especificar';

            if (!grupos[valor]) {
                grupos[valor] = [];
            }
            grupos[valor].push(item);
        });

        const resultado = [];
        for (const [valor, items] of Object.entries(grupos)) {
            resultado.push({
                valor: valor,
                items: items,
                count: items.length
            });
        }

        return resultado;
    }

    // Formatear valor según tipo
    function formatearValor(valor, tipo) {
        if (valor === null || valor === undefined || valor === '') return '-';

        if (tipo === 'badge') {
            let clase = 'badge-inactivo';
            if (valor === 'Activo') clase = 'badge-activo';
            else if (valor === 'Vacaciones') clase = 'badge-vacaciones';
            else if (valor === 'Baja') clase = 'badge-baja';
            return `<span class="badge ${clase}">${valor}</span>`;
        }

        if (tipo === 'boolean') {
            return valor === true || valor === 1 || valor === 'Sí' || valor === 'true' ? '✓' : '✗';
        }

        if (tipo === 'date' && valor) {
            const fecha = new Date(valor);
            if (!isNaN(fecha.getTime())) {
                return fecha.toLocaleDateString('es-MX');
            }
            return valor;
        }

        if (tipo === 'currency' && valor) {
            return '$' + parseFloat(valor).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        return valor;
    }

    // Renderizar tabla
    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');

        // Determinar qué datos mostrar
        let datosAMostrar = datosFiltrados;

        if (columnasAgrupadas.length > 0) {
            const columna = columnasAgrupadas[0];
            datosAgrupados = agruparDatos(columna);
            datosAMostrar = datosAgrupados;
            modoAgrupado = true;
            totalRegistros = datosAgrupados.length;
        } else {
            modoAgrupado = false;
            totalRegistros = datosFiltrados.length;
        }

        const inicio = (paginaActual - 1) * registrosPorPagina;
        const fin = inicio + registrosPorPagina;
        const paginaActualDatos = datosAMostrar.slice(inicio, fin);

        if (!paginaActualDatos || paginaActualDatos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${columnasVisibles.length + 1}" style="padding: 30px; text-align: center; color: #6c757d;">
                        <i class="fas fa-info-circle" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        No hay empleados registrados
                    </td>
                </tr>
            `;
            actualizarPaginacion();
            return;
        }

        let html = '';

        if (modoAgrupado) {
            // Vista agrupada
            paginaActualDatos.forEach((grupo, index) => {
                const bgColor = (inicio + index) % 2 === 1 ? 'style="background-color: #f8f9fa;"' : '';

                html += `
                    <tr ${bgColor} style="background-color: #e3f2fd; font-weight: bold;">
                        <td colspan="${columnasVisibles.length + 1}" style="padding: 10px 8px; border: 1px solid #dee2e6;">
                            <i class="fas fa-folder-open" style="color: var(--color-primary); margin-right: 8px;"></i>
                            ${columnasAgrupadas[0]}: ${grupo.valor} (${grupo.count} registros)
                        </td>
                    </tr>
                `;

                grupo.items.forEach(item => {
                    html += '<tr>';
                    columnas.filter(col => columnasVisibles.includes(col.field)).forEach(col => {
                        const valor = item[col.field];
                        html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6; ${col.field === columnasAgrupadas[0] ? 'padding-left: 30px;' : ''}">${formatearValor(valor, col.type)}</td>`;
                    });
                    html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                        <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verEmpleado(${item.plantilla_id})" title="Ver detalle"></i>
                        <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEmpleado(${item.plantilla_id})" title="Editar"></i>
                        <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarEmpleado(${item.plantilla_id})" title="Eliminar"></i>
                    </td>`;
                    html += '</tr>';
                });
            });
        } else {
            // Vista normal
            paginaActualDatos.forEach(item => {
                html += '<tr>';
                columnas.filter(col => columnasVisibles.includes(col.field)).forEach(col => {
                    const valor = item[col.field];
                    html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6;">${formatearValor(valor, col.type)}</td>`;
                });
                html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="verEmpleado(${item.plantilla_id})" title="Ver detalle"></i>
                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarEmpleado(${item.plantilla_id})" title="Editar"></i>
                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="eliminarEmpleado(${item.plantilla_id})" title="Eliminar"></i>
                </td>`;
                html += '</tr>';
            });
        }

        tbody.innerHTML = html;
        actualizarPaginacion();
    }

    // Filtrar por búsqueda
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();

        if (!termino) {
            datosFiltrados = [...datos];
        } else {
            datosFiltrados = datos.filter(item =>
                (item.nombre_completo && item.nombre_completo.toLowerCase().includes(termino)) ||
                (item.rfc && item.rfc.toLowerCase().includes(termino)) ||
                (item.curp && item.curp.toLowerCase().includes(termino)) ||
                (item.numero_empleado_interno && item.numero_empleado_interno.toLowerCase().includes(termino)) ||
                (item.area && item.area.toLowerCase().includes(termino)) ||
                (item.puesto && item.puesto.toLowerCase().includes(termino)) ||
                (item.estatus_txt && item.estatus_txt.toLowerCase().includes(termino))
            );
        }

        paginaActual = 1;
        totalRegistros = datosFiltrados.length;
        renderizarTabla();
        actualizarPaginacion();
    });

    // --- FUNCIONES CRUD ---

    // Abrir modal para crear o editar
    window.abrirModalEmpleado = function(id = null) {
        const modal = document.getElementById('modalEmpleado');
        const titulo = document.getElementById('modalTituloEmpleado');
        const form = document.getElementById('formEmpleado');

        // Reset del formulario
        form.reset();

        // Configurar según sea creación o edición
        if (id) {
            titulo.innerHTML = '<i class="fas fa-user-edit" style="margin-right: 10px;"></i>Editar Empleado';
            document.getElementById('modalEmpleadoId').value = id;

            // Cargar datos del empleado
            fetch(`/api/plantilla/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar los datos');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const emp = data.data;

                    // Información básica
                    document.getElementById('modalEstatus').value = emp.estatus || 'Activo';
                    document.getElementById('modalNumeroInterno').value = emp.numero_empleado_interno || '';
                    document.getElementById('modalFechaIngreso').value = emp.fecha_ingreso || '';
                    document.getElementById('modalReclutador').value = emp.reclutador || '';

                    // Nombre
                    if (emp.nombre_completo) {
                        const partes = emp.nombre_completo.split(' ');
                        document.getElementById('modalNombre').value = partes[0] || '';
                        document.getElementById('modalApellidoPaterno').value = partes[1] || '';
                        document.getElementById('modalApellidoMaterno').value = partes[2] || '';
                    }

                    // Fiscales
                    document.getElementById('modalRfc').value = emp.rfc || '';
                    document.getElementById('modalCurp').value = emp.curp || '';
                    document.getElementById('modalNss').value = emp.numero_seguro_social || '';
                    document.getElementById('modalAlias').value = emp.alias || '';

                    // Contacto
                    document.getElementById('modalFechaNacimiento').value = emp.fecha_nacimiento || '';
                    document.getElementById('modalCorreo').value = emp.correo || '';
                    document.getElementById('modalCelular').value = emp.celular || '';
                    document.getElementById('modalContactoEmergencia').value = emp.contacto_emergencia || '';
                    document.getElementById('modalNumeroEmergencia').value = emp.numero_emergencia || '';

                    // Dirección
                    document.getElementById('modalCp').value = emp.satcat_codigos_postales_codigo_postal || '';
                    document.getElementById('modalCalle').value = emp.calle || '';
                    document.getElementById('modalNumExt').value = emp.num_exterior || '';
                    document.getElementById('modalNumInt').value = emp.num_interior || '';
                    document.getElementById('modalColonia').value = emp.colonia || '';
                    document.getElementById('modalMunicipio').value = emp.municipio || '';
                    document.getElementById('modalEstado').value = emp.estado || '';
                    document.getElementById('modalPais').value = emp.pais || 'MEX';
                    document.getElementById('modalLocalidad').value = emp.localidad || '';

                    // Laboral
                    if (emp.cat_area_id) {
                        document.getElementById('modalArea').value = emp.cat_area_id;
                        // Cargar puestos del área
                        fetch(`/api/puestos-por-area?area_id=${emp.cat_area_id}`)
                        .then(res => res.json())
                        .then(dataPuestos => {
                            if (dataPuestos.success) {
                                todosLosPuestos = dataPuestos.data;
                                llenarSelectPuestos(emp.cat_area_id);
                                // Seleccionar el puesto
                                setTimeout(() => {
                                    if (emp.cat_puesto_id) {
                                        document.getElementById('modalPuesto').value = emp.cat_puesto_id;
                                    }
                                }, 100);
                            }
                        });
                    }
                    document.getElementById('modalSueldo').value = emp.sueldo || '';
                    document.getElementById('modalCoordinador').value = emp.coordinador || '';

                    // Operador
                    document.getElementById('modalOperador').value = emp.operador ? '1' : '0';
                    document.getElementById('modalTipoOperador').value = emp.cat_tipo_operador_id || '';
                    document.getElementById('modalTipoLicencia').value = emp.cat_tipo_licencia_id || '';
                    document.getElementById('modalNumeroLicencia').value = emp.numero_licencia || '';
                    document.getElementById('modalVencimientoLicencia').value = emp.vencimiento_licencia || '';
                    document.getElementById('modalLicenciaReconocimiento').value = emp.licencia_reconocimiento || '';

                    // Nómina SAT
                    document.getElementById('modalTipoContrato').value = emp.satcat_nomina_contratos_clave || '';
                    document.getElementById('modalTipoJornada').value = emp.satcat_nomina_jornadas_clave || '';
                    document.getElementById('modalPeriodicidad').value = emp.satcat_nomina_periodicidades_clave || '';
                    document.getElementById('modalRegimen').value = emp.satcat_nomina_regimenes_clave || '';

                    // Bancario
                    document.getElementById('modalBanco').value = emp.cat_bancos_clave || '';
                    document.getElementById('modalTipoCuenta').value = emp.cat_tipo_cuenta_id || '';
                    document.getElementById('modalClabe').value = emp.cuenta_clabe || '';
                    document.getElementById('modalCuenta').value = emp.cuenta || '';
                    document.getElementById('modalPropietario').value = emp.propietario || '';
                    document.getElementById('modalSucursal').value = emp.cuenta_sucursal || '';

                    // Prestaciones
                    document.getElementById('modalDiasVacaciones').value = emp.dias_vacaciones || '0';
                    document.getElementById('modalPrimaVacacional').value = emp.prima_vacacional || '25';
                    document.getElementById('modalAguinaldo').value = emp.aguinaldo || '15';
                    document.getElementById('modalBonoAsistencia').value = emp.bono_asistencia ? '1' : '0';
                    document.getElementById('modalBonoProductividad').value = emp.bono_productividad ? '1' : '0';
                    document.getElementById('modalAplicaAsistencia').value = emp.aplica_asistencia ? '1' : '0';
                    document.getElementById('modalFonacot').value = emp.fonacot ? '1' : '0';
                    document.getElementById('modalPensionAlimenticia').value = emp.pension_alimenticia ? '1' : '0';

                    // IMSS/INFONAVIT
                    document.getElementById('modalMontoMensualImss').value = emp.monto_mensual_imss || '';
                    document.getElementById('modalMontoDiarioImss').value = emp.monto_diario_imss || '';
                    document.getElementById('modalMontoMensualInfonavit').value = emp.monto_mensual_infonavit || '';
                    document.getElementById('modalMontoDiarioInfonavit').value = emp.monto_diario_infonavit || '';
                    document.getElementById('modalMontoMensualIsr').value = emp.monto_mensual_isr || '';
                    document.getElementById('modalMontoDiarioIsr').value = emp.monto_diario_isr || '';

                    // Baja
                    document.getElementById('modalFechaBaja').value = emp.fecha_baja || '';
                    document.getElementById('modalMotivoBaja').value = emp.motivo_baja_id || '';

                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error al cargar los datos del empleado');
            });
        } else {
            // Modo creación: limpiar todo
            titulo.innerHTML = '<i class="fas fa-user-plus" style="margin-right: 10px;"></i>Nuevo Empleado';
            document.getElementById('modalEmpleadoId').value = '';
            document.getElementById('modalEstatus').value = 'Activo';
            document.getElementById('modalOperador').value = '0';
            document.getElementById('modalPais').value = 'MEX';
            document.getElementById('modalPrimaVacacional').value = '25';
            document.getElementById('modalAguinaldo').value = '15';
            document.getElementById('modalDiasVacaciones').value = '0';
            document.getElementById('modalArea').value = '';
            document.getElementById('modalPuesto').innerHTML = '<option value="">Seleccione un área primero</option>';

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    };

    // Función para cerrar modal de empleado
    window.cerrarModalEmpleado = function() {
        document.getElementById('modalEmpleado').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Función para editar (alias de abrir)
    window.editarEmpleado = function(id) {
        abrirModalEmpleado(id);
    };

    // Función para ver empleado (NUEVA VENTANA DETALLADA)
    window.verEmpleado = function(id) {
        fetch(`/api/plantilla/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const emp = data.data;
                const contenedor = document.getElementById('detalleEmpleadoContenido');
                const modalVer = document.getElementById('modalVerEmpleado');

                // Función auxiliar para formatear valores
                const f = (valor, tipo = 'text') => {
                    if (valor === null || valor === undefined || valor === '') return '<span class="text-muted">-</span>';
                    if (tipo === 'fecha') {
                        try {
                            return new Date(valor).toLocaleDateString('es-MX');
                        } catch {
                            return valor;
                        }
                    }
                    if (tipo === 'moneda') return `$${parseFloat(valor).toFixed(2)}`;
                    if (tipo === 'bool') return valor ? 'Sí' : 'No';
                    return valor;
                };

                // Construir HTML del detalle
                contenedor.innerHTML = `
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-id-card"></i> Información General</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>ID:</strong> <span>${emp.plantilla_id}</span></div>
                            <div class="detalle-item"><strong>Estatus:</strong> <span>${emp.estatus_txt}</span></div>
                            <div class="detalle-item"><strong>No. Interno:</strong> <span>${f(emp.numero_empleado_interno)}</span></div>
                            <div class="detalle-item"><strong>Nombre:</strong> <span>${f(emp.nombre_completo)}</span></div>
                            <div class="detalle-item"><strong>RFC:</strong> <span>${f(emp.rfc)}</span></div>
                            <div class="detalle-item"><strong>CURP:</strong> <span>${f(emp.curp)}</span></div>
                            <div class="detalle-item"><strong>NSS:</strong> <span>${f(emp.numero_seguro_social)}</span></div>
                            <div class="detalle-item"><strong>Alias:</strong> <span>${f(emp.alias)}</span></div>
                            <div class="detalle-item"><strong>Fecha Ingreso:</strong> <span>${f(emp.fecha_ingreso, 'fecha')}</span></div>
                            <div class="detalle-item"><strong>Reclutador:</strong> <span>${f(emp.reclutador)}</span></div>
                        </div>
                    </div>
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-phone-alt"></i> Contacto y Dirección</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>Correo:</strong> <span>${f(emp.correo)}</span></div>
                            <div class="detalle-item"><strong>Celular:</strong> <span>${f(emp.celular)}</span></div>
                            <div class="detalle-item"><strong>Fecha Nacimiento:</strong> <span>${f(emp.fecha_nacimiento, 'fecha')}</span></div>
                            <div class="detalle-item"><strong>Contacto Emergencia:</strong> <span>${f(emp.contacto_emergencia)}</span></div>
                            <div class="detalle-item"><strong>Tel. Emergencia:</strong> <span>${f(emp.numero_emergencia)}</span></div>
                            <div class="detalle-item"><strong>Dirección:</strong> <span>${f(emp.calle)} ${f(emp.num_exterior)} ${f(emp.num_interior)}</span></div>
                            <div class="detalle-item"><strong>Colonia:</strong> <span>${f(emp.colonia)}</span></div>
                            <div class="detalle-item"><strong>C.P.:</strong> <span>${f(emp.satcat_codigos_postales_codigo_postal)}</span></div>
                            <div class="detalle-item"><strong>Municipio/Estado:</strong> <span>${f(emp.municipio)}, ${f(emp.estado)}</span></div>
                            <div class="detalle-item"><strong>País:</strong> <span>${f(emp.pais)}</span></div>
                        </div>
                    </div>
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-briefcase"></i> Datos Laborales</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>Área:</strong> <span>${f(emp.area)}</span></div>
                            <div class="detalle-item"><strong>Puesto:</strong> <span>${f(emp.puesto)}</span></div>
                            <div class="detalle-item"><strong>Sueldo:</strong> <span>${f(emp.sueldo, 'moneda')}</span></div>
                            <div class="detalle-item"><strong>Coordinador:</strong> <span>${f(emp.coordinador)}</span></div>
                        </div>
                    </div>
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-truck"></i> Datos de Operador</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>¿Es Operador?:</strong> <span>${f(emp.operador, 'bool')}</span></div>
                            <div class="detalle-item"><strong>Licencia:</strong> <span>${f(emp.numero_licencia)}</span></div>
                            <div class="detalle-item"><strong>Vencimiento:</strong> <span>${f(emp.vencimiento_licencia, 'fecha')}</span></div>
                        </div>
                    </div>
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-calculator"></i> Nómina y Prestaciones</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>Días Vacaciones:</strong> <span>${f(emp.dias_vacaciones)}</span></div>
                            <div class="detalle-item"><strong>Prima Vacacional:</strong> <span>${f(emp.prima_vacacional)}%</span></div>
                            <div class="detalle-item"><strong>Aguinaldo (días):</strong> <span>${f(emp.aguinaldo)}</span></div>
                            <div class="detalle-item"><strong>Bono Asistencia:</strong> <span>${f(emp.bono_asistencia, 'bool')}</span></div>
                            <div class="detalle-item"><strong>Bono Productividad:</strong> <span>${f(emp.bono_productividad, 'bool')}</span></div>
                            <div class="detalle-item"><strong>Monto Mensual IMSS:</strong> <span>${f(emp.monto_mensual_imss, 'moneda')}</span></div>
                            <div class="detalle-item"><strong>Monto Mensual INFONAVIT:</strong> <span>${f(emp.monto_mensual_infonavit, 'moneda')}</span></div>
                        </div>
                    </div>
                    <div class="detalle-seccion">
                        <h5 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-university"></i> Bancario</h5>
                        <div class="detalle-grid">
                            <div class="detalle-item"><strong>Banco:</strong> <span>${f(emp.banco)}</span></div>
                            <div class="detalle-item"><strong>CLABE:</strong> <span>${f(emp.cuenta_clabe)}</span></div>
                            <div class="detalle-item"><strong>Cuenta:</strong> <span>${f(emp.cuenta)}</span></div>
                        </div>
                    </div>
                `;

                modalVer.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al cargar los datos');
        });
    };

    // Cerrar modal de ver
    window.cerrarModalVer = function() {
        document.getElementById('modalVerEmpleado').style.display = 'none';
        document.body.style.overflow = 'auto';
    };

    // Guardar empleado (crear o actualizar)
    window.guardarEmpleado = function() {
        const id = document.getElementById('modalEmpleadoId').value;
        const numericId = id ? parseInt(id) : null;

        const data = {
            // Información personal básica
            nombre: document.getElementById('modalNombre').value,
            apellido_paterno: document.getElementById('modalApellidoPaterno').value,
            apellido_materno: document.getElementById('modalApellidoMaterno').value,
            estatus: document.getElementById('modalEstatus').value,
            numero_empleado_interno: document.getElementById('modalNumeroInterno').value,
            fecha_ingreso: document.getElementById('modalFechaIngreso').value,
            reclutador: document.getElementById('modalReclutador').value,

            // Datos fiscales
            rfc: document.getElementById('modalRfc').value,
            curp: document.getElementById('modalCurp').value,
            numero_seguro_social: document.getElementById('modalNss').value,
            alias: document.getElementById('modalAlias').value,

            // Contacto
            fecha_nacimiento: document.getElementById('modalFechaNacimiento').value,
            correo: document.getElementById('modalCorreo').value,
            celular: document.getElementById('modalCelular').value,
            contacto_emergencia: document.getElementById('modalContactoEmergencia').value,
            numero_emergencia: document.getElementById('modalNumeroEmergencia').value,

            // Dirección
            satcat_codigos_postales_codigo_postal: document.getElementById('modalCp').value,
            calle: document.getElementById('modalCalle').value,
            num_exterior: document.getElementById('modalNumExt').value,
            num_interior: document.getElementById('modalNumInt').value,
            colonia: document.getElementById('modalColonia').value,
            municipio: document.getElementById('modalMunicipio').value,
            estado: document.getElementById('modalEstado').value,
            pais: document.getElementById('modalPais').value,
            localidad: document.getElementById('modalLocalidad').value,

            // Laboral
            cat_area_id: document.getElementById('modalArea').value ? parseInt(document.getElementById('modalArea').value) : null,
            cat_puesto_id: document.getElementById('modalPuesto').value ? parseInt(document.getElementById('modalPuesto').value) : null,
            sueldo: document.getElementById('modalSueldo').value ? parseFloat(document.getElementById('modalSueldo').value) : null,
            coordinador: document.getElementById('modalCoordinador').value,

            // Operador
            operador: document.getElementById('modalOperador').value === '1',
            cat_tipo_operador_id: document.getElementById('modalTipoOperador').value ? parseInt(document.getElementById('modalTipoOperador').value) : null,
            cat_tipo_licencia_id: document.getElementById('modalTipoLicencia').value ? parseInt(document.getElementById('modalTipoLicencia').value) : null,
            numero_licencia: document.getElementById('modalNumeroLicencia').value,
            vencimiento_licencia: document.getElementById('modalVencimientoLicencia').value,
            licencia_reconocimiento: document.getElementById('modalLicenciaReconocimiento').value,

            // Nómina SAT
            satcat_nomina_contratos_clave: document.getElementById('modalTipoContrato').value,
            satcat_nomina_jornadas_clave: document.getElementById('modalTipoJornada').value,
            satcat_nomina_periodicidades_clave: document.getElementById('modalPeriodicidad').value,
            satcat_nomina_regimenes_clave: document.getElementById('modalRegimen').value,

            // Bancario
            cat_bancos_clave: document.getElementById('modalBanco').value,
            cat_tipo_cuenta_id: document.getElementById('modalTipoCuenta').value ? parseInt(document.getElementById('modalTipoCuenta').value) : null,
            cuenta_clabe: document.getElementById('modalClabe').value,
            cuenta: document.getElementById('modalCuenta').value,
            propietario: document.getElementById('modalPropietario').value,
            cuenta_sucursal: document.getElementById('modalSucursal').value,

            // Prestaciones
            dias_vacaciones: document.getElementById('modalDiasVacaciones').value ? parseInt(document.getElementById('modalDiasVacaciones').value) : 0,
            prima_vacacional: document.getElementById('modalPrimaVacacional').value ? parseFloat(document.getElementById('modalPrimaVacacional').value) : 25,
            aguinaldo: document.getElementById('modalAguinaldo').value ? parseInt(document.getElementById('modalAguinaldo').value) : 15,
            bono_asistencia: document.getElementById('modalBonoAsistencia').value === '1',
            bono_productividad: document.getElementById('modalBonoProductividad').value === '1',
            aplica_asistencia: document.getElementById('modalAplicaAsistencia').value === '1',
            fonacot: document.getElementById('modalFonacot').value === '1',
            pension_alimenticia: document.getElementById('modalPensionAlimenticia').value === '1',

            // IMSS/INFONAVIT
            monto_mensual_imss: document.getElementById('modalMontoMensualImss').value ? parseFloat(document.getElementById('modalMontoMensualImss').value) : null,
            monto_diario_imss: document.getElementById('modalMontoDiarioImss').value ? parseFloat(document.getElementById('modalMontoDiarioImss').value) : null,
            monto_mensual_infonavit: document.getElementById('modalMontoMensualInfonavit').value ? parseFloat(document.getElementById('modalMontoMensualInfonavit').value) : null,
            monto_diario_infonavit: document.getElementById('modalMontoDiarioInfonavit').value ? parseFloat(document.getElementById('modalMontoDiarioInfonavit').value) : null,
            monto_mensual_isr: document.getElementById('modalMontoMensualIsr').value ? parseFloat(document.getElementById('modalMontoMensualIsr').value) : null,
            monto_diario_isr: document.getElementById('modalMontoDiarioIsr').value ? parseFloat(document.getElementById('modalMontoDiarioIsr').value) : null,

            // Baja
            fecha_baja: document.getElementById('modalFechaBaja').value,
            motivo_baja_id: document.getElementById('modalMotivoBaja').value ? parseInt(document.getElementById('modalMotivoBaja').value) : null,
        };

        const url = numericId ? `/api/plantilla/${numericId}` : '/api/plantilla';
        const method = numericId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) throw { status: response.status, data: data };
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', data.message || 'Empleado guardado exitosamente');
                cerrarModalEmpleado();
                cargarDatos();
            } else {
                if (data.errors) {
                    const mensajes = Object.values(data.errors).flat().join('\n');
                    mostrarNotificacion('error', mensajes);
                } else {
                    mostrarNotificacion('error', data.message || 'Error al guardar el empleado');
                }
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            if (error.data?.message) mostrarNotificacion('error', error.data.message);
            else if (error.data?.errors) {
                const mensajes = Object.values(error.data.errors).flat().join('\n');
                mostrarNotificacion('error', mensajes);
            } else {
                mostrarNotificacion('error', 'Error de conexión al servidor');
            }
        });
    };

    // Eliminar empleado
    window.eliminarEmpleado = function(id) {
        if (!id) {
            mostrarNotificacion('error', 'ID de empleado no válido');
            return;
        }

        if (confirm('¿Estás seguro de eliminar este empleado?')) {
            const numericId = parseInt(id);

            fetch(`/api/plantilla/${numericId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarNotificacion('success', data.message || 'Empleado eliminado exitosamente');
                    cargarDatos();
                } else {
                    mostrarNotificacion('error', data.message || 'Error al eliminar el empleado');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarNotificacion('error', 'Error de conexión al servidor');
            });
        }
    };

    // Exportar a Excel
    window.exportarExcel = function() {
        mostrarNotificacion('info', 'Generando archivo Excel...');

        const buscar = document.getElementById('buscador').value;

        fetch('/plantilla/exportar-excel', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            },
            body: new URLSearchParams({
                buscar: buscar
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la descarga');
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'plantilla_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);

            mostrarNotificacion('success', 'Archivo Excel descargado correctamente');
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error al descargar el archivo');
        });
    };

    // Funciones de selector de columnas y agrupación
    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');

        container.innerHTML = '';

        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
            modoAgrupado = false;
        } else {
            texto.style.display = 'none';
            modoAgrupado = true;
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }

        paginaActual = 1;
        renderizarTabla();
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
        mostrarNotificacion('info', 'Desagrupando por: ' + columna);
    };

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.matches('[draggable="true"]')) {
            e.dataTransfer.setData('text/plain', e.target.dataset.columna);
        }
    });

    document.getElementById('grupoAgrupacion').addEventListener('dragover', (e) => e.preventDefault());

    document.getElementById('grupoAgrupacion').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            mostrarNotificacion('info', 'Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';

        if (selector.style.display === 'block') {
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox"
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           ${columnasVisibles.includes(col.field) ? 'checked' : ''}
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('${col.field}', this.checked)">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    };

    window.toggleColumna = function(columna, visible) {
        if (visible && !columnasVisibles.includes(columna)) {
            columnasVisibles.push(columna);
        } else if (!visible && columnasVisibles.includes(columna)) {
            columnasVisibles = columnasVisibles.filter(c => c !== columna);
        }
        renderizarEncabezados();
        renderizarTabla();
    };

    window.cerrarColumnSelector = function() {
        document.getElementById('columnSelector').style.display = 'none';
    };

    // Cerrar selector al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) {
            document.getElementById('columnSelector').style.display = 'none';
        }
    });

    // Botón Crear filtro (placeholder)
    document.getElementById('btnCrearFiltro').addEventListener('click', () => {
        mostrarNotificacion('info', 'Funcionalidad de filtro en desarrollo');
    });

    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalEmpleado();
            cerrarModalVer();
        }
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalEmpleado').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalEmpleado();
    });
    document.getElementById('modalVerEmpleado').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalVer();
    });

    // Inicializar
    function inicializarSelectoresColumnas() {
        const lista = document.getElementById('columnasLista');
        if (lista && lista.children.length === 0) {
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox"
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           ${columnasVisibles.includes(col.field) ? 'checked' : ''}
                           style="margin-right: 8px; accent-color: var(--color-primary);"
                           onchange="toggleColumna('${col.field}', this.checked)">
                    <label for="chk_${col.field}" style="font-size: 12px;">${col.caption}</label>
                </div>
            `).join('');
        }
    }

    inicializarSelectoresColumnas();
    renderizarEncabezados();
});
</script>
@endsection