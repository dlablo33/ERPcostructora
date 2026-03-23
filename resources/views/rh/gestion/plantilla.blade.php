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
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Agregar empleado" onclick="abrirModalEmpleado()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <div>
                            <button id="btnExcel" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;" onclick="exportarExcel()">
                                <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Excel</span>
                            </button>
                        </div>

                        <div style="position: relative;">
                            <button id="btnColumnas" style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px;" onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                <span class="hide-mobile">Columnas</span>
                            </button>
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

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
                            <tr id="encabezadosTabla">
                        </thead>
                        <tbody id="tablaBody"></tbody>
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

<!-- MODAL PARA AGREGAR/EDITAR EMPLEADO -->
<div id="modalEmpleado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1400px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloEmpleado">
                    <i class="fas fa-user-plus" style="margin-right: 10px;"></i>Nuevo Empleado
                </h3>
                <button onclick="cerrarModalEmpleado()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; font-size: 18px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div style="padding: 0;">
            <div style="display: flex; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 0 20px; gap: 5px; flex-wrap: wrap;">
                <button type="button" class="tab-btn active" onclick="mostrarTab('tab-datos')" style="padding: 12px 20px; background: none; border: none; cursor: pointer; font-weight: 500; color: var(--color-primary); border-bottom: 2px solid var(--color-primary);">Datos del Empleado</button>
                <button type="button" class="tab-btn" onclick="mostrarTab('tab-documentos')" style="padding: 12px 20px; background: none; border: none; cursor: pointer; font-weight: 500; color: #6c757d;">Documentos</button>
            </div>

            <form id="formEmpleado" onsubmit="event.preventDefault(); guardarEmpleado();" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="modalEmpleadoId" value="">

                <!-- TAB 1: DATOS DEL EMPLEADO -->
                <div id="tab-datos" class="tab-content" style="padding: 25px; display: block;">
                    <!-- INFORMACIÓN PERSONAL BÁSICA -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-id-card"></i> Información Personal Básica</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Estatus</label>
                                <select id="modalEstatus" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                    <option value="Vacaciones">Vacaciones</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">No. Interno</label>
                                <input type="text" id="modalNumeroEmpleadoInterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="EMP-001">
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Fecha Ingreso</label>
                                <input type="date" id="modalFechaIngreso" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Reclutador</label>
                                <input type="text" id="modalReclutador" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" placeholder="Reclutador">
                            </div>
                        </div>
                    </div>

                    <!-- NOMBRE COMPLETO -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-user"></i> Nombre Completo</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Nombre(s) *</label>
                                <input type="text" id="modalNombre" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" required>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Apellido Paterno</label>
                                <input type="text" id="modalApellidoPaterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Apellido Materno</label>
                                <input type="text" id="modalApellidoMaterno" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                            </div>
                        </div>
                    </div>

                    <!-- DATOS FISCALES -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-file-invoice"></i> Datos Fiscales</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">RFC</label><input type="text" id="modalRfc" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">CURP</label><input type="text" id="modalCurp" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">NSS</label><input type="text" id="modalNumeroSeguroSocial" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Alias</label><input type="text" id="modalAlias" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                        </div>
                    </div>

                    <!-- DATOS DE CONTACTO -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-phone-alt"></i> Datos de Contacto</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Correo</label><input type="email" id="modalCorreo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Celular</label><input type="tel" id="modalCelular" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Fecha Nacimiento</label><input type="date" id="modalFechaNacimiento" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div style="grid-column: span 2;"><label style="font-size: 12px; font-weight: 600;">Contacto Emergencia</label><input type="text" id="modalContactoEmergencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Tel. Emergencia</label><input type="text" id="modalNumeroEmergencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                        </div>
                    </div>

                    <!-- DIRECCIÓN -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-map-marker-alt"></i> Dirección</h4>
                        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
                            <div style="grid-column: span 2;"><label style="font-size: 12px; font-weight: 600;">Calle</label><input type="text" id="modalCalle" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">No. Exterior</label><input type="text" id="modalNumExterior" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">No. Interior</label><input type="text" id="modalNumInterior" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">C.P.</label><input type="text" id="modalSatcatCodigosPostalesCodigoPostal" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">País</label>
                                <select id="modalSatcatPaisesClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="MEX" selected>México</option>
                                    <option value="USA">Estados Unidos</option>
                                    <option value="CAN">Canadá</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Estado</label><input type="text" id="modalEstado" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Municipio</label><input type="text" id="modalMunicipio" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Colonia</label><input type="text" id="modalSatcatColoniasClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Localidad</label><input type="text" id="modalSatcatLocalidadesClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                        </div>
                    </div>

                    <!-- DATOS LABORALES -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-briefcase"></i> Datos Laborales</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Área</label>
                                <select id="modalCatAreaId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" onchange="cargarPuestosPorArea()">
                                    <option value="">-- Seleccionar área --</option>
                                    @if(isset($areas) && $areas->count() > 0)
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Puesto</label>
                                <select id="modalCatPuestoId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccione un área primero</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Sueldo Mensual</label>
                                <input type="number" id="modalSueldo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" step="0.01" min="0" oninput="calcularMontosIMSS()">
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Coordinador</label>
                                <select id="modalCoordinadorPlantillaId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">-- Seleccionar coordinador --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- DATOS DE OPERADOR -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;">
                            <input type="checkbox" id="modalOperador" style="margin-right: 10px;" onchange="toggleCamposOperador()">
                            <i class="fas fa-truck"></i> ¿Es Operador?
                        </h4>
                        <div id="camposOperador" style="display: none;">
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-top: 15px;">
                                <div><label style="font-size: 12px; font-weight: 600;">Tipo Operador</label>
                                    <select id="modalCatTipoOperadorId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                        <option value="">Seleccionar</option>
                                        @if(isset($tiposOperador) && $tiposOperador->count() > 0)
                                            @foreach($tiposOperador as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div><label style="font-size: 12px; font-weight: 600;">Tipo Licencia</label>
                                    <select id="modalCatTipoLicenciaId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                        <option value="">Seleccionar</option>
                                        @if(isset($tiposLicencia) && $tiposLicencia->count() > 0)
                                            @foreach($tiposLicencia as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div><label style="font-size: 12px; font-weight: 600;">Número Licencia</label><input type="text" id="modalNumeroLicencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                                <div><label style="font-size: 12px; font-weight: 600;">Vencimiento Licencia</label><input type="date" id="modalVencimientoLicencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- DATOS DE NÓMINA SAT -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-calculator"></i> Datos de Nómina SAT</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Tipo Contrato</label>
                                <select id="modalSatcatNominaContratosClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    <option value="01">Tiempo Indeterminado</option>
                                    <option value="02">Obra Determinada</option>
                                    <option value="03">Tiempo Determinado</option>
                                    <option value="04">Temporada</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Tipo Jornada</label>
                                <select id="modalSatcatNominaJornadasClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    <option value="01">Diurna</option>
                                    <option value="02">Nocturna</option>
                                    <option value="03">Mixta</option>
                                    <option value="04">Por Hora</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Periodicidad Pago</label>
                                <select id="modalSatcatNominaPeriodicidadesClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    <option value="01">Diario</option>
                                    <option value="02">Semanal</option>
                                    <option value="03">Catorcenal</option>
                                    <option value="04">Quincenal</option>
                                    <option value="05">Mensual</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Régimen</label>
                                <select id="modalSatcatNominaRegimenesClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
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
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-university"></i> Datos Bancarios</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Banco</label>
                                <select id="modalCatBancosClave" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    @if(isset($bancos) && $bancos->count() > 0)
                                        @foreach($bancos as $banco)
                                            <option value="{{ $banco->clave }}">{{ $banco->nombre_corto }} - {{ $banco->descripcion }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Tipo Cuenta</label>
                                <select id="modalCatTipoCuentaId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    @if(isset($tiposCuenta) && $tiposCuenta->count() > 0)
                                        @foreach($tiposCuenta as $tipo)
                                            <option value="{{ $tipo->cat_tipo_cuenta_id }}">{{ $tipo->descripcion }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Cuenta</label><input type="text" id="modalCuenta" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Propietario</label><input type="text" id="modalPropietario" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Sucursal</label><input type="text" id="modalCuentaSucursal" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                        </div>
                    </div>

                    <!-- PRESTACIONES -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-gift"></i> Prestaciones</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Días Vacaciones</label><input type="number" id="modalDiasVacaciones" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" value="0"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Prima Vacacional %</label><input type="number" id="modalPrimaVacacional" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" value="25" step="0.01"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Aguinaldo (días)</label><input type="number" id="modalAguinaldo" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;" value="15"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Bono Asistencia</label>
                                <select id="modalBonoAsistencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="0">No</option><option value="1">Sí</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Bono Productividad</label>
                                <select id="modalBonoProductividad" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="0">No</option><option value="1">Sí</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Aplica Asistencia</label>
                                <select id="modalAplicaAsistencia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="0">No</option><option value="1">Sí</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">FONACOT</label>
                                <select id="modalFonacot" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="0">No</option><option value="1">Sí</option>
                                </select>
                            </div>
                            <div><label style="font-size: 12px; font-weight: 600;">Pensión Alimenticia</label>
                                <select id="modalPensionAlimenticia" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="0">No</option><option value="1">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- MONTO IMSS -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid var(--color-primary);">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-heartbeat"></i> Montos IMSS e INFONAVIT (Cálculo automático)</h4>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Mensual IMSS</label><input type="number" id="modalMontoMensualImss" style="width:100%; padding:8px; background:#f0fff0; border-radius:4px;" readonly></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Diario IMSS</label><input type="number" id="modalMontoDiarioImss" style="width:100%; padding:8px; background:#f0fff0; border-radius:4px;" readonly></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Mensual INFONAVIT</label><input type="number" id="modalMontoMensualInfonavit" style="width:100%; padding:8px; background:#e6f7ff; border-radius:4px;" readonly></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Diario INFONAVIT</label><input type="number" id="modalMontoDiarioInfonavit" style="width:100%; padding:8px; background:#e6f7ff; border-radius:4px;" readonly></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Mensual ISR</label><input type="number" id="modalMontoMensualIsr" style="width:100%; padding:8px; background:#fff9e6; border-radius:4px;" readonly></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Monto Diario ISR</label><input type="number" id="modalMontoDiarioIsr" style="width:100%; padding:8px; background:#fff9e6; border-radius:4px;" readonly></div>
                        </div>
                    </div>

                    <!-- FECHAS DE BAJA -->
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0; font-size: 16px;"><i class="fas fa-calendar-times"></i> Fechas de Baja</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            <div><label style="font-size: 12px; font-weight: 600;">Fecha Baja</label><input type="date" id="modalFechaBaja" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;"></div>
                            <div><label style="font-size: 12px; font-weight: 600;">Motivo Baja</label>
                                <select id="modalMotivoBajaId" style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:4px;">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Renuncia Voluntaria</option><option value="2">Despido</option>
                                    <option value="3">Jubilación</option><option value="4">Fin de Contrato</option>
                                    <option value="5">Defunción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DOCUMENTOS -->
                <div id="tab-documentos" class="tab-content" style="padding: 25px; display: none;">
                    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                        <h4 style="color: var(--color-primary); margin: 0 0 15px 0;"><i class="fas fa-file-alt"></i> Documentos del Empleado</h4>
                        <p style="font-size: 12px; color: #6c757d; margin-bottom: 20px;">Sube los documentos (PDF, JPG, PNG - Máx 5MB)</p>
                        <div id="listaDocumentos" style="margin-bottom: 20px;"></div>
                        <button type="button" onclick="agregarCampoDocumento()" style="background-color: #e9ecef; border: 1px dashed #6c757d; border-radius: 4px; padding: 10px; width: 100%; cursor: pointer;">
                            <i class="fas fa-plus"></i> Agregar documento
                        </button>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: flex-end; gap: 10px; padding: 20px 25px; border-top: 1px solid #dee2e6;">
                    <button type="button" onclick="cerrarModalEmpleado()" style="padding: 10px 24px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 10px 30px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLE DEL EMPLEADO CON DOCUMENTOS -->
<div id="modalVerEmpleado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1000px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; position: sticky; top: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="color: white; margin: 0;"><i class="fas fa-user"></i> Detalle del Empleado</h3>
                <button onclick="cerrarModalVer()" style="background: rgba(255,255,255,0.2); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div style="padding: 25px;" id="detalleEmpleadoContenido"></div>
    </div>
</div>

<!-- Notificación -->
<div id="notification" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1000000; min-width: 300px; background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: slideInRight 0.3s ease; overflow: hidden;">
    <div id="notificationHeader" style="padding: 15px 20px; font-weight: bold; display: flex; align-items: center; gap: 10px;">
        <i id="notificationIcon" class="fas"></i>
        <span id="notificationTitle"></span>
    </div>
    <div id="notificationBody" style="padding: 15px 20px; border-top: 1px solid #eee;">
        <span id="notificationMessage"></span>
    </div>
</div>

<style>
    :root { --color-primary: #083CAE; }
    
    .table-container { 
        border: 1px solid #dee2e6; 
        border-radius: 4px; 
        overflow-x: auto; 
        background: white;
        position: relative;
    }
    
    .table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 13px;
        min-width: 1200px;
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
    
    tbody tr:nth-child(even) { background-color: #f8f9fa; }
    tbody tr:hover { background-color: #e8f0fe; }
    
    .table th:last-child,
    .table td:last-child {
        position: sticky !important;
        right: 0 !important;
        z-index: 35 !important;
        background-color: white !important;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1) !important;
        min-width: 100px;
    }
    
    .table th:last-child {
        background-color: var(--color-primary) !important;
        color: white;
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
    
    .badge { 
        padding: 4px 8px; 
        border-radius: 3px; 
        font-size: 11px; 
        font-weight: 600; 
        display: inline-block; 
        min-width: 70px; 
        text-align: center; 
    }
    .badge-activo { background-color: #28a745; color: white; }
    .badge-inactivo { background-color: #6c757d; color: white; }
    .badge-vacaciones { background-color: #ffc107; color: #212529; }
    .badge-baja { background-color: #dc3545; color: white; }
    
    .documento-item { 
        background: white; 
        border: 1px solid #dee2e6; 
        border-radius: 6px; 
        padding: 12px; 
        margin-bottom: 10px; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        flex-wrap: wrap; 
        gap: 10px; 
    }
    .documento-info { flex: 1; display: flex; gap: 10px; flex-wrap: wrap; }
    .documento-nombre { flex: 2; min-width: 200px; }
    .documento-archivo { flex: 2; min-width: 200px; }
    .documento-nombre input, .documento-archivo input { width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; }
    
    .detalle-seccion { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .detalle-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 12px; }
    .detalle-item { margin-bottom: 8px; }
    .detalle-item strong { font-size: 12px; color: #6c757d; display: block; }
    
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
    .columna-agrupada .remover { margin-left: 5px; cursor: pointer; font-size: 12px; font-weight: bold; color: var(--color-primary); }
    
    @keyframes slideIn { from { opacity: 0; transform: translateY(-50px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    @media (max-width: 768px) { 
        .hide-mobile { display: none; } 
        .table-container { max-height: 500px; } 
        .detalle-grid { grid-template-columns: 1fr; }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
let areasCache = null;
let documentosLista = [];
let todosLosPuestos = [];
let coordinadoresLista = [];

const TASAS = { IMSS: 0.2125, INFONAVIT: 0.05, ISR: 0.12 };

function calcularMontosIMSS() {
    const sueldo = parseFloat(document.getElementById('modalSueldo').value) || 0;
    if (sueldo <= 0) {
        ['MontoMensualImss', 'MontoDiarioImss', 'MontoMensualInfonavit', 'MontoDiarioInfonavit', 'MontoMensualIsr', 'MontoDiarioIsr'].forEach(id => 
            document.getElementById(`modal${id}`).value = '');
        return;
    }
    const DIAS = 30.4;
    document.getElementById('modalMontoMensualImss').value = (sueldo * TASAS.IMSS).toFixed(2);
    document.getElementById('modalMontoDiarioImss').value = (sueldo * TASAS.IMSS / DIAS).toFixed(2);
    document.getElementById('modalMontoMensualInfonavit').value = (sueldo * TASAS.INFONAVIT).toFixed(2);
    document.getElementById('modalMontoDiarioInfonavit').value = (sueldo * TASAS.INFONAVIT / DIAS).toFixed(2);
    document.getElementById('modalMontoMensualIsr').value = (sueldo * TASAS.ISR).toFixed(2);
    document.getElementById('modalMontoDiarioIsr').value = (sueldo * TASAS.ISR / DIAS).toFixed(2);
}

function toggleCamposOperador() {
    const campos = document.getElementById('camposOperador');
    campos.style.display = document.getElementById('modalOperador').checked ? 'block' : 'none';
}

function mostrarTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';
    document.querySelectorAll('.tab-btn').forEach(btn => { btn.style.color = '#6c757d'; btn.style.borderBottom = 'none'; });
    const activeBtn = document.querySelector(`.tab-btn[onclick="mostrarTab('${tabId}')"]`);
    if (activeBtn) { activeBtn.style.color = 'var(--color-primary)'; activeBtn.style.borderBottom = '2px solid var(--color-primary)'; }
}

function agregarCampoDocumento() {
    const id = Date.now();
    const html = `<div class="documento-item" id="doc-${id}"><div class="documento-info"><div class="documento-nombre"><input type="text" name="doc_nombre[]" placeholder="Nombre del documento"></div><div class="documento-archivo"><input type="file" name="doc_archivo[]" accept=".pdf,.jpg,.jpeg,.png"></div></div><button type="button" onclick="eliminarCampoDocumento(${id})" style="background:none; border:none; color:#dc3545; cursor:pointer;"><i class="fas fa-trash"></i></button></div>`;
    document.getElementById('listaDocumentos').insertAdjacentHTML('beforeend', html);
}

function eliminarCampoDocumento(id) { document.getElementById(`doc-${id}`)?.remove(); }

function recopilarDocumentos() {
    const docs = [];
    const nombres = document.querySelectorAll('input[name="doc_nombre[]"]');
    const archivos = document.querySelectorAll('input[name="doc_archivo[]"]');
    for (let i = 0; i < nombres.length; i++) {
        if (nombres[i].value.trim()) docs.push({ nombre: nombres[i].value.trim(), archivo: archivos[i].files[0] || null });
    }
    return docs;
}

document.addEventListener('DOMContentLoaded', function() {
    const columnas = [
        { field: 'estatus_txt', caption: 'Estatus', visible: true, type: 'badge' },
        { field: 'plantilla_id', caption: 'ID', visible: true, type: 'number' },
        { field: 'numero_empleado_interno', caption: 'No. Interno', visible: true },
        { field: 'nombre_completo', caption: 'Nombre Completo', visible: true },
        { field: 'rfc', caption: 'RFC', visible: true },
        { field: 'curp', caption: 'CURP', visible: false },
        { field: 'numero_seguro_social', caption: 'NSS', visible: false },
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
        { field: 'sueldo', caption: 'Sueldo', visible: true, type: 'currency' },
        { field: 'coordinador', caption: 'Coordinador', visible: true }
    ];

    let datos = [], datosFiltrados = [], columnasVisibles = columnas.filter(c => c.visible).map(c => c.field);
    let columnasAgrupadas = [], paginaActual = 1, registrosPorPagina = 10, totalRegistros = 0, modoAgrupado = false, datosAgrupados = [];

    function cargarDatos() {
        fetch('/api/plantilla/datagrid', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json()).then(data => {
                if (data.success) {
                    datos = data.data || []; datosFiltrados = [...datos]; totalRegistros = datos.length;
                    document.getElementById('totalEmpleados').textContent = data.total || datos.length;
                    document.getElementById('totalActivos').textContent = data.activos || 0;
                    document.getElementById('totalInactivos').textContent = data.inactivos || 0;
                    renderizarTabla(); actualizarPaginacion(); renderizarEncabezados();
                } else mostrarNotificacion('error', 'Error al cargar datos');
            }).catch(() => mostrarNotificacion('error', 'Error de conexión'));
    }

    function cargarAreasDesdeAPI() {
        return new Promise((resolve) => {
            fetch('/api/areas', { headers: { 'Accept': 'application/json' } })
                .then(r => r.json()).then(data => {
                    let areas = [];
                    if (data.success) {
                        if (data.data?.areas && Array.isArray(data.data.areas)) areas = data.data.areas;
                        else if (Array.isArray(data.data)) areas = data.data;
                        else if (data.areas && Array.isArray(data.areas)) areas = data.areas;
                    }
                    if (areas.length) { llenarSelectAreas(areas); resolve(areas); }
                    else { const fallback = [{ id: 1, nombre: 'Administración' }, { id: 2, nombre: 'Recursos Humanos' }, { id: 3, nombre: 'Operaciones' }, { id: 4, nombre: 'Ventas' }, { id: 5, nombre: 'Finanzas' }]; llenarSelectAreas(fallback); resolve(fallback); }
                }).catch(() => { const fallback = [{ id: 1, nombre: 'Administración' }, { id: 2, nombre: 'Recursos Humanos' }, { id: 3, nombre: 'Operaciones' }, { id: 4, nombre: 'Ventas' }, { id: 5, nombre: 'Finanzas' }]; llenarSelectAreas(fallback); resolve(fallback); });
        });
    }

    function cargarCoordinadores() {
        fetch('/api/plantilla/coordinadores', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json()).then(data => {
                if (data.success && data.data) {
                    coordinadoresLista = data.data;
                    const select = document.getElementById('modalCoordinadorPlantillaId');
                    select.innerHTML = '<option value="">-- Seleccionar coordinador --</option>';
                    coordinadoresLista.forEach(c => {
                        const option = document.createElement('option');
                        option.value = c.plantilla_id;
                        option.textContent = c.nombre_completo;
                        select.appendChild(option);
                    });
                }
            }).catch(() => console.log('Error cargando coordinadores'));
    }

    function llenarSelectAreas(areas) {
        const select = document.getElementById('modalCatAreaId');
        if (!select) return;
        while (select.options.length > 1) select.remove(1);
        areas.forEach(a => { const opt = document.createElement('option'); opt.value = a.id; opt.textContent = a.nombre; select.appendChild(opt); });
    }

    window.cargarPuestosPorArea = function() {
        const areaId = document.getElementById('modalCatAreaId').value;
        const selectPuesto = document.getElementById('modalCatPuestoId');
        if (!areaId) { selectPuesto.innerHTML = '<option value="">Seleccione un área primero</option>'; return; }
        selectPuesto.innerHTML = '<option value="">Cargando...</option>';
        fetch(`/api/puestos-por-area?area_id=${areaId}`, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json()).then(data => {
                let puestos = [];
                if (data.success) {
                    if (Array.isArray(data.data)) puestos = data.data;
                    else if (data.data?.puestos && Array.isArray(data.data.puestos)) puestos = data.data.puestos;
                }
                todosLosPuestos = puestos;
                if (puestos.length) {
                    let opts = '<option value="">Seleccionar puesto</option>';
                    puestos.forEach(p => opts += `<option value="${p.id}">${p.nombre}</option>`);
                    selectPuesto.innerHTML = opts;
                } else selectPuesto.innerHTML = '<option value="">No hay puestos</option>';
            }).catch(() => selectPuesto.innerHTML = '<option value="">Error</option>');
    };

    function renderizarEncabezados() {
        const thead = document.getElementById('encabezadosTabla');
        if (!thead) return;
        let html = '';
        columnas.filter(c => columnasVisibles.includes(c.field)).forEach(c => html += `<th draggable="true" data-columna="${c.field}" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white;">${c.caption}</th>`);
        html += '<th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white;">Acciones</th>';
        thead.innerHTML = html;
    }

    window.cambiarRegistrosPorPagina = function() { registrosPorPagina = parseInt(document.getElementById('perPage').value); paginaActual = 1; renderizarTabla(); actualizarPaginacion(); };
    window.cambiarPagina = function(dir) { if (dir === 'prev' && paginaActual > 1) paginaActual--; else if (dir === 'next' && paginaActual < Math.ceil(totalRegistros / registrosPorPagina)) paginaActual++; renderizarTabla(); actualizarPaginacion(); };

    function actualizarPaginacion() {
        const total = Math.ceil(totalRegistros / registrosPorPagina);
        const desde = totalRegistros === 0 ? 0 : (paginaActual - 1) * registrosPorPagina + 1;
        const hasta = Math.min(paginaActual * registrosPorPagina, totalRegistros);
        document.getElementById('desde').textContent = desde;
        document.getElementById('hasta').textContent = hasta;
        document.getElementById('total').textContent = totalRegistros;
        document.getElementById('paginaActual').textContent = paginaActual;
        document.getElementById('prevPage').disabled = paginaActual === 1;
        document.getElementById('nextPage').disabled = paginaActual === total || total === 0;
    }

    function mostrarNotificacion(tipo, msg) {
        const n = document.getElementById('notification');
        const h = document.getElementById('notificationHeader');
        const c = { success: '#28a745', error: '#dc3545', warning: '#ffc107', info: '#17a2b8' };
        h.style.backgroundColor = c[tipo] || c.info;
        h.style.color = tipo === 'warning' ? '#212529' : 'white';
        document.getElementById('notificationIcon').className = `fas fa-${tipo === 'success' ? 'check-circle' : tipo === 'error' ? 'times-circle' : tipo === 'warning' ? 'exclamation-triangle' : 'info-circle'}`;
        document.getElementById('notificationTitle').textContent = { success: 'Éxito', error: 'Error', warning: 'Advertencia', info: 'Información' }[tipo];
        document.getElementById('notificationMessage').textContent = msg;
        n.style.display = 'block';
        setTimeout(() => n.style.display = 'none', 3000);
    }

    function formatearValor(valor, tipo) {
        if (!valor && valor !== 0) return '-';
        
        if (typeof valor === 'object' && valor !== null) {
            if (valor.nombre) return valor.nombre;
            if (valor.descripcion) return valor.descripcion;
            if (valor.nombre_corto) return valor.nombre_corto;
            if (valor.toString && valor.toString() === '[object Object]') return '-';
            return JSON.stringify(valor);
        }
        
        if (tipo === 'badge') {
            const clases = { Activo: 'badge-activo', Vacaciones: 'badge-vacaciones', Baja: 'badge-baja' };
            return `<span class="badge ${clases[valor] || 'badge-inactivo'}">${valor}</span>`;
        }
        if (tipo === 'boolean') return (valor === true || valor === 1 || valor === 'Sí') ? '✓' : '✗';
        if (tipo === 'date' && valor) { 
            try { 
                if (!valor) return '-';
                return new Date(valor).toLocaleDateString('es-MX'); 
            } catch { return valor; }
        }
        if (tipo === 'currency' && valor) return `$${parseFloat(valor).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
        return valor;
    }

    function agruparDatos(col) {
        const grupos = {};
        datosFiltrados.forEach(item => { let v = item[col] || 'Sin especificar'; if (!grupos[v]) grupos[v] = []; grupos[v].push(item); });
        return Object.entries(grupos).map(([v, i]) => ({ valor: v, items: i, count: i.length }));
    }

    function renderizarTabla() {
        const tbody = document.getElementById('tablaBody');
        let datosMostrar = datosFiltrados;
        if (columnasAgrupadas.length) { 
            datosAgrupados = agruparDatos(columnasAgrupadas[0]); 
            datosMostrar = datosAgrupados; 
            modoAgrupado = true; 
            totalRegistros = datosAgrupados.length; 
        } else { 
            modoAgrupado = false; 
            totalRegistros = datosFiltrados.length; 
        }
        const inicio = (paginaActual - 1) * registrosPorPagina;
        const pagina = datosMostrar.slice(inicio, inicio + registrosPorPagina);
        if (!pagina.length) { 
            tbody.innerHTML = `<tr><td colspan="${columnasVisibles.length + 1}" style="text-align:center; padding:30px;"><i class="fas fa-info-circle" style="font-size:24px; margin-bottom:10px; display:block;"></i>No hay empleados registrados</td></tr>`; 
            actualizarPaginacion(); 
            return; 
        }
        let html = '';
        if (modoAgrupado) {
            pagina.forEach(grupo => {
                html += `<tr style="background:#e3f2fd; font-weight:bold;"><td colspan="${columnasVisibles.length + 1}" style="padding:10px 8px;"><i class="fas fa-folder-open"></i> ${columnasAgrupadas[0]}: ${grupo.valor} (${grupo.count} registros)</td></tr>`;
                grupo.items.forEach(item => {
                    html += '<tr>';
                    columnas.filter(c => columnasVisibles.includes(c.field)).forEach(c => {
                        let valor = item[c.field];
                        if ((c.field === 'area' || c.field === 'puesto') && typeof valor === 'object' && valor !== null) {
                            valor = valor.nombre || valor.descripcion || '-';
                        }
                        html += `<td style="padding:10px 8px; ${c.field === columnasAgrupadas[0] ? 'padding-left:30px;' : ''}">${formatearValor(valor, c.type)}</td>`;
                    });
                    html += `<td style="padding:10px 8px; text-align:center;"><i class="fas fa-eye" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="verEmpleado(${item.plantilla_id})" title="Ver detalle"></i> <i class="fas fa-edit" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="editarEmpleado(${item.plantilla_id})" title="Editar"></i> <i class="fas fa-trash" style="color:#dc3545; margin:0 5px; cursor:pointer;" onclick="eliminarEmpleado(${item.plantilla_id})" title="Eliminar"></i>`;
                    html += '';
                });
            });
        } else {
            pagina.forEach(item => {
                html += '<tr>';
                columnas.filter(c => columnasVisibles.includes(c.field)).forEach(c => {
                    let valor = item[c.field];
                    if ((c.field === 'area' || c.field === 'puesto') && typeof valor === 'object' && valor !== null) {
                        valor = valor.nombre || valor.descripcion || '-';
                    }
                    html += `<td style="padding:10px 8px;">${formatearValor(valor, c.type)}`;
                });
                html += `<td style="padding:10px 8px; text-align:center;"><i class="fas fa-eye" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="verEmpleado(${item.plantilla_id})" title="Ver detalle"></i> <i class="fas fa-edit" style="color:var(--color-primary); margin:0 5px; cursor:pointer;" onclick="editarEmpleado(${item.plantilla_id})" title="Editar"></i> <i class="fas fa-trash" style="color:#dc3545; margin:0 5px; cursor:pointer;" onclick="eliminarEmpleado(${item.plantilla_id})" title="Eliminar"></i>`;
                html += '';
            });
        }
        tbody.innerHTML = html;
        actualizarPaginacion();
    }

    document.getElementById('buscador').addEventListener('input', e => {
        const term = e.target.value.toLowerCase();
        datosFiltrados = term ? datos.filter(i => (i.nombre_completo?.toLowerCase().includes(term)) || (i.rfc?.toLowerCase().includes(term)) || (i.curp?.toLowerCase().includes(term)) || (i.numero_empleado_interno?.toLowerCase().includes(term)) || (i.area?.toLowerCase().includes(term)) || (i.puesto?.toLowerCase().includes(term)) || (i.estatus_txt?.toLowerCase().includes(term))) : [...datos];
        paginaActual = 1; renderizarTabla();
    });

    window.abrirModalEmpleado = function(id = null) {
        document.getElementById('formEmpleado').reset();
        document.getElementById('listaDocumentos').innerHTML = '';
        document.getElementById('modalEmpleadoId').value = id || '';
        document.getElementById('modalTituloEmpleado').innerHTML = id ? '<i class="fas fa-user-edit"></i> Editar Empleado' : '<i class="fas fa-user-plus"></i> Nuevo Empleado';
        document.getElementById('camposOperador').style.display = 'none';
        document.getElementById('modalOperador').checked = false;
        const select = document.getElementById('modalCatAreaId');
        select.innerHTML = '<option value="">Cargando áreas...</option>';
        cargarAreasDesdeAPI().then(() => { if (id) cargarDatosEmpleadoParaEdicion(id); });
        cargarCoordinadores();
        mostrarTab('tab-datos');
        document.getElementById('modalEmpleado').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    function cargarDatosEmpleadoParaEdicion(id) {
        fetch(`/api/plantilla/${id}`, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json()).then(data => {
                if (data.success) {
                    const e = data.data;
                    document.getElementById('modalEstatus').value = e.estatus || 'Activo';
                    document.getElementById('modalNumeroEmpleadoInterno').value = e.numero_empleado_interno || '';
                    document.getElementById('modalFechaIngreso').value = e.fecha_ingreso || '';
                    document.getElementById('modalReclutador').value = e.reclutador || '';
                    document.getElementById('modalNombre').value = e.nombre || '';
                    document.getElementById('modalApellidoPaterno').value = e.apellido_paterno || '';
                    document.getElementById('modalApellidoMaterno').value = e.apellido_materno || '';
                    document.getElementById('modalRfc').value = e.rfc || ''; 
                    document.getElementById('modalCurp').value = e.curp || '';
                    document.getElementById('modalNumeroSeguroSocial').value = e.numero_seguro_social || ''; 
                    document.getElementById('modalAlias').value = e.alias || '';
                    document.getElementById('modalFechaNacimiento').value = e.fecha_nacimiento || ''; 
                    document.getElementById('modalCorreo').value = e.correo || '';
                    document.getElementById('modalCelular').value = e.celular || ''; 
                    document.getElementById('modalContactoEmergencia').value = e.contacto_emergencia || '';
                    document.getElementById('modalNumeroEmergencia').value = e.numero_emergencia || ''; 
                    document.getElementById('modalSatcatCodigosPostalesCodigoPostal').value = e.satcat_codigos_postales_codigo_postal || '';
                    document.getElementById('modalCalle').value = e.calle || ''; 
                    document.getElementById('modalNumExterior').value = e.num_exterior || '';
                    document.getElementById('modalNumInterior').value = e.num_interior || ''; 
                    document.getElementById('modalSatcatColoniasClave').value = e.colonia || '';
                    document.getElementById('modalMunicipio').value = e.municipio || ''; 
                    document.getElementById('modalEstado').value = e.estado || '';
                    document.getElementById('modalSatcatPaisesClave').value = e.pais || 'MEX'; 
                    document.getElementById('modalSatcatLocalidadesClave').value = e.localidad || '';
                    if (e.cat_area_id) { 
                        setTimeout(() => { 
                            document.getElementById('modalCatAreaId').value = e.cat_area_id; 
                            window.cargarPuestosPorArea(); 
                            setTimeout(() => { 
                                if (e.cat_puesto_id) document.getElementById('modalCatPuestoId').value = e.cat_puesto_id; 
                            }, 300); 
                        }, 500); 
                    }
                    document.getElementById('modalSueldo').value = e.sueldo || ''; 
                    if (e.sueldo) calcularMontosIMSS();
                    if (e.coordinador_plantilla_id) {
                        setTimeout(() => {
                            document.getElementById('modalCoordinadorPlantillaId').value = e.coordinador_plantilla_id;
                        }, 500);
                    }
                    
                    document.getElementById('modalOperador').checked = e.operador || false;
                    toggleCamposOperador();
                    document.getElementById('modalCatTipoOperadorId').value = e.cat_tipo_operador_id || '';
                    document.getElementById('modalCatTipoLicenciaId').value = e.cat_tipo_licencia_id || '';
                    document.getElementById('modalNumeroLicencia').value = e.numero_licencia || '';
                    document.getElementById('modalVencimientoLicencia').value = e.vencimiento_licencia || '';
                    
                    document.getElementById('modalSatcatNominaContratosClave').value = e.satcat_nomina_contratos_clave || '';
                    document.getElementById('modalSatcatNominaJornadasClave').value = e.satcat_nomina_jornadas_clave || '';
                    document.getElementById('modalSatcatNominaPeriodicidadesClave').value = e.satcat_nomina_periodicidades_clave || '';
                    document.getElementById('modalSatcatNominaRegimenesClave').value = e.satcat_nomina_regimenes_clave || '';
                    document.getElementById('modalCatBancosClave').value = e.cat_bancos_clave || '';
                    document.getElementById('modalCatTipoCuentaId').value = e.cat_tipo_cuenta_id || '';
                    document.getElementById('modalCuenta').value = e.cuenta || '';
                    document.getElementById('modalPropietario').value = e.propietario || '';
                    document.getElementById('modalCuentaSucursal').value = e.cuenta_sucursal || '';
                    document.getElementById('modalDiasVacaciones').value = e.dias_vacaciones || '0';
                    document.getElementById('modalPrimaVacacional').value = e.prima_vacacional || '25';
                    document.getElementById('modalAguinaldo').value = e.aguinaldo || '15';
                    document.getElementById('modalBonoAsistencia').value = e.bono_asistencia ? '1' : '0';
                    document.getElementById('modalBonoProductividad').value = e.bono_productividad ? '1' : '0';
                    document.getElementById('modalAplicaAsistencia').value = e.aplica_asistencia ? '1' : '0';
                    document.getElementById('modalFonacot').value = e.fonacot ? '1' : '0';
                    document.getElementById('modalPensionAlimenticia').value = e.pension_alimenticia ? '1' : '0';
                    document.getElementById('modalFechaBaja').value = e.fecha_baja || '';
                    document.getElementById('modalMotivoBajaId').value = e.motivo_baja_id || '';
                    
                    document.getElementById('modalMontoMensualImss').value = e.monto_mensual_imss || '';
                    document.getElementById('modalMontoDiarioImss').value = e.monto_diario_imss || '';
                    document.getElementById('modalMontoMensualInfonavit').value = e.monto_mensual_infonavit || '';
                    document.getElementById('modalMontoDiarioInfonavit').value = e.monto_diario_infonavit || '';
                    document.getElementById('modalMontoMensualIsr').value = e.monto_mensual_isr || '';
                    document.getElementById('modalMontoDiarioIsr').value = e.monto_diario_isr || '';
                    
                    if (e.documentos && e.documentos.length) {
                        const container = document.getElementById('listaDocumentos');
                        e.documentos.forEach(doc => {
                            const id = Date.now();
                            const html = `<div class="documento-item" id="doc-${id}"><div class="documento-info"><div class="documento-nombre"><input type="text" name="doc_nombre[]" value="${doc.nombre_documento}" placeholder="Nombre del documento"></div><div class="documento-archivo"><input type="file" name="doc_archivo[]" accept=".pdf,.jpg,.jpeg,.png"></div></div><button type="button" onclick="eliminarCampoDocumento(${id})" style="background:none; border:none; color:#dc3545; cursor:pointer;"><i class="fas fa-trash"></i></button></div>`;
                            container.insertAdjacentHTML('beforeend', html);
                            if (doc.archivo) {
                                const link = document.createElement('a');
                                link.href = `/storage/${doc.archivo}`;
                                link.target = '_blank';
                                link.textContent = ' Ver archivo existente';
                                link.style.fontSize = '11px';
                                link.style.marginLeft = '10px';
                                document.querySelector(`#doc-${id} .documento-archivo`).appendChild(link);
                            }
                        });
                    }
                }
            }).catch(() => mostrarNotificacion('error', 'Error al cargar datos del empleado'));
    }

    window.cerrarModalEmpleado = function() { document.getElementById('modalEmpleado').style.display = 'none'; document.body.style.overflow = 'auto'; };
    window.editarEmpleado = function(id) { abrirModalEmpleado(id); };

    window.verEmpleado = function(id) {
        fetch(`/api/plantilla/${id}`, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json()).then(data => {
                if (data.success) {
                    const e = data.data;
                    const f = (v, t = 'text') => {
                        if (!v && v !== 0 && v !== false) return '-';
                        if (t === 'fecha') {
                            try { 
                                if (!v) return '-';
                                return new Date(v).toLocaleDateString('es-MX'); 
                            } catch { return v; }
                        }
                        if (t === 'moneda') return `$${parseFloat(v).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
                        if (t === 'bool') return v === true || v === 1 || v === '1' || v === 'true' ? 'Sí' : 'No';
                        return v;
                    };
                    
                    const areaNombre = e.area?.nombre || e.area_nombre || (typeof e.area === 'string' ? e.area : '-');
                    const puestoNombre = e.puesto?.nombre || e.puesto_nombre || (typeof e.puesto === 'string' ? e.puesto : '-');
                    const tipoOperadorNombre = e.tipo_operador?.nombre || e.tipo_operador_nombre || (typeof e.tipo_operador === 'string' ? e.tipo_operador : '-');
                    const tipoLicenciaNombre = e.tipo_licencia?.nombre || e.tipo_licencia_nombre || (typeof e.tipo_licencia === 'string' ? e.tipo_licencia : '-');
                    const bancoNombre = e.banco?.nombre_corto || e.banco?.nombre || e.banco_nombre || (typeof e.banco === 'string' ? e.banco : '-');
                    const tipoCuentaNombre = e.tipo_cuenta?.descripcion || e.tipo_cuenta_nombre || (typeof e.tipo_cuenta === 'string' ? e.tipo_cuenta : '-');
                    const coordinadorNombre = e.coordinador?.nombre_completo || e.coordinador_nombre || (typeof e.coordinador === 'string' ? e.coordinador : '-');
                    const paisNombre = e.pais?.nombre || e.pais_nombre || (typeof e.pais === 'string' ? e.pais : '-');
                    
                    const formatearTamanio = (b) => { 
                        if (!b) return '-'; 
                        const s = ['Bytes', 'KB', 'MB']; 
                        const i = Math.floor(Math.log(b) / Math.log(1024)); 
                        return `${(b / Math.pow(1024, i)).toFixed(2)} ${s[i]}`; 
                    };
                    
                    let docsHtml = '';
                    if (e.documentos && e.documentos.length) {
                        docsHtml = `<div class="detalle-seccion"><h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-file-alt"></i> Documentos (${e.documentos.length})</h5><div class="detalle-grid">` +
                            e.documentos.map(d => `<div style="border:1px solid #dee2e6; border-radius:6px; padding:10px; margin-bottom:10px;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <i class="fas ${d.tipo_archivo === 'pdf' ? 'fa-file-pdf' : (d.tipo_archivo === 'jpg' || d.tipo_archivo === 'jpeg' ? 'fa-file-image' : 'fa-file-alt')}" style="font-size:24px; color:${d.tipo_archivo === 'pdf' ? '#dc3545' : '#17a2b8'}"></i>
                                    <div style="flex:1;"><strong>${f(d.nombre_documento)}</strong><br><small class="text-muted">${d.tipo_archivo} • ${formatearTamanio(d.tamanio)}</small></div>
                                </div>
                                ${d.archivo ? `<div style="margin-top:8px;"><a href="/api/plantilla/${e.plantilla_id}/documentos/${d.id}/descargar" target="_blank" style="display:inline-flex; align-items:center; gap:5px; padding:5px 10px; background-color:var(--color-primary); color:white; border-radius:4px; text-decoration:none; font-size:12px;"><i class="fas fa-download"></i> Descargar</a></div>` : '<small class="text-warning">Archivo pendiente de subir</small>'}
                            </div>`).join('') + `</div></div>`;
                    } else {
                        docsHtml = `<div class="detalle-seccion"><h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-file-alt"></i> Documentos</h5><p style="text-align:center; padding:20px;"><i class="fas fa-folder-open" style="font-size:48px; margin-bottom:10px; display:block;"></i>No hay documentos registrados para este empleado.</p></div>`;
                    }
                    
                    document.getElementById('detalleEmpleadoContenido').innerHTML = `
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-id-card"></i> Información General</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>ID:</strong> <span>${f(e.plantilla_id)}</span></div>
                                <div class="detalle-item"><strong>Estatus:</strong> <span>${f(e.estatus_txt || e.estatus)}</span></div>
                                <div class="detalle-item"><strong>No. Interno:</strong> <span>${f(e.numero_empleado_interno)}</span></div>
                                <div class="detalle-item"><strong>Nombre:</strong> <span>${f(e.nombre)} ${f(e.apellido_paterno)} ${f(e.apellido_materno)}</span></div>
                                <div class="detalle-item"><strong>RFC:</strong> <span>${f(e.rfc)}</span></div>
                                <div class="detalle-item"><strong>CURP:</strong> <span>${f(e.curp)}</span></div>
                                <div class="detalle-item"><strong>NSS:</strong> <span>${f(e.numero_seguro_social)}</span></div>
                                <div class="detalle-item"><strong>Alias:</strong> <span>${f(e.alias)}</span></div>
                                <div class="detalle-item"><strong>Fecha Ingreso:</strong> <span>${f(e.fecha_ingreso, 'fecha')}</span></div>
                                <div class="detalle-item"><strong>Reclutador:</strong> <span>${f(e.reclutador)}</span></div>
                                <div class="detalle-item"><strong>¿Es Operador?:</strong> <span>${f(e.operador, 'bool')}</span></div>
                            </div>
                        </div>
                        
                        ${e.operador ? `
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-truck"></i> Datos de Operador</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Tipo Operador:</strong> <span>${f(tipoOperadorNombre)}</span></div>
                                <div class="detalle-item"><strong>Tipo Licencia:</strong> <span>${f(tipoLicenciaNombre)}</span></div>
                                <div class="detalle-item"><strong>Número Licencia:</strong> <span>${f(e.numero_licencia)}</span></div>
                                <div class="detalle-item"><strong>Vencimiento Licencia:</strong> <span>${f(e.vencimiento_licencia, 'fecha')}</span></div>
                            </div>
                        </div>
                        ` : ''}
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-phone-alt"></i> Contacto y Dirección</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Correo:</strong> <span>${f(e.correo)}</span></div>
                                <div class="detalle-item"><strong>Celular:</strong> <span>${f(e.celular)}</span></div>
                                <div class="detalle-item"><strong>Fecha Nacimiento:</strong> <span>${f(e.fecha_nacimiento, 'fecha')}</span></div>
                                <div class="detalle-item"><strong>Contacto Emergencia:</strong> <span>${f(e.contacto_emergencia)}</span></div>
                                <div class="detalle-item"><strong>Tel. Emergencia:</strong> <span>${f(e.numero_emergencia)}</span></div>
                                <div class="detalle-item"><strong>Dirección:</strong> <span>${f(e.calle)} ${f(e.num_exterior)} ${f(e.num_interior)}</span></div>
                                <div class="detalle-item"><strong>Colonia:</strong> <span>${f(e.satcat_colonias_clave || e.colonia)}</span></div>
                                <div class="detalle-item"><strong>C.P.:</strong> <span>${f(e.satcat_codigos_postales_codigo_postal)}</span></div>
                                <div class="detalle-item"><strong>Municipio:</strong> <span>${f(e.municipio)}</span></div>
                                <div class="detalle-item"><strong>Estado:</strong> <span>${f(e.estado)}</span></div>
                                <div class="detalle-item"><strong>País:</strong> <span>${f(paisNombre)}</span></div>
                                <div class="detalle-item"><strong>Localidad:</strong> <span>${f(e.satcat_localidades_clave || e.localidad)}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-briefcase"></i> Datos Laborales</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Área:</strong> <span>${f(areaNombre)}</span></div>
                                <div class="detalle-item"><strong>Puesto:</strong> <span>${f(puestoNombre)}</span></div>
                                <div class="detalle-item"><strong>Sueldo Mensual:</strong> <span>${f(e.sueldo, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Coordinador:</strong> <span>${f(coordinadorNombre)}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-calculator"></i> Datos de Nómina SAT</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Tipo Contrato:</strong> <span>${f(e.satcat_nomina_contratos_clave)}</span></div>
                                <div class="detalle-item"><strong>Tipo Jornada:</strong> <span>${f(e.satcat_nomina_jornadas_clave)}</span></div>
                                <div class="detalle-item"><strong>Periodicidad Pago:</strong> <span>${f(e.satcat_nomina_periodicidades_clave)}</span></div>
                                <div class="detalle-item"><strong>Régimen:</strong> <span>${f(e.satcat_nomina_regimenes_clave)}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-gift"></i> Prestaciones</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Días Vacaciones:</strong> <span>${f(e.dias_vacaciones)}</span></div>
                                <div class="detalle-item"><strong>Prima Vacacional:</strong> <span>${f(e.prima_vacacional)}%</span></div>
                                <div class="detalle-item"><strong>Aguinaldo (días):</strong> <span>${f(e.aguinaldo)}</span></div>
                                <div class="detalle-item"><strong>Bono Asistencia:</strong> <span>${f(e.bono_asistencia, 'bool')}</span></div>
                                <div class="detalle-item"><strong>Bono Productividad:</strong> <span>${f(e.bono_productividad, 'bool')}</span></div>
                                <div class="detalle-item"><strong>Aplica Asistencia:</strong> <span>${f(e.aplica_asistencia, 'bool')}</span></div>
                                <div class="detalle-item"><strong>FONACOT:</strong> <span>${f(e.fonacot, 'bool')}</span></div>
                                <div class="detalle-item"><strong>Pensión Alimenticia:</strong> <span>${f(e.pension_alimenticia, 'bool')}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-heartbeat"></i> Contribuciones</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Monto Mensual IMSS:</strong> <span>${f(e.monto_mensual_imss, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Monto Diario IMSS:</strong> <span>${f(e.monto_diario_imss, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Monto Mensual INFONAVIT:</strong> <span>${f(e.monto_mensual_infonavit, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Monto Diario INFONAVIT:</strong> <span>${f(e.monto_diario_infonavit, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Monto Mensual ISR:</strong> <span>${f(e.monto_mensual_isr, 'moneda')}</span></div>
                                <div class="detalle-item"><strong>Monto Diario ISR:</strong> <span>${f(e.monto_diario_isr, 'moneda')}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-university"></i> Datos Bancarios</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Banco:</strong> <span>${f(bancoNombre)}</span></div>
                                <div class="detalle-item"><strong>Tipo Cuenta:</strong> <span>${f(tipoCuentaNombre)}</span></div>
                                <div class="detalle-item"><strong>Cuenta:</strong> <span>${f(e.cuenta)}</span></div>
                                <div class="detalle-item"><strong>Propietario:</strong> <span>${f(e.propietario)}</span></div>
                                <div class="detalle-item"><strong>Sucursal:</strong> <span>${f(e.cuenta_sucursal)}</span></div>
                            </div>
                        </div>
                        
                        <div class="detalle-seccion">
                            <h5 style="color:var(--color-primary); margin:0 0 15px 0;"><i class="fas fa-calendar-times"></i> Fechas de Baja</h5>
                            <div class="detalle-grid">
                                <div class="detalle-item"><strong>Fecha Baja:</strong> <span>${f(e.fecha_baja, 'fecha')}</span></div>
                                <div class="detalle-item"><strong>Motivo Baja:</strong> <span>${f(e.motivo_baja_id)}</span></div>
                            </div>
                        </div>
                        
                        ${docsHtml}`;
                        
                    document.getElementById('modalVerEmpleado').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            }).catch(() => mostrarNotificacion('error', 'Error al cargar datos'));
    };

    window.cerrarModalVer = function() { document.getElementById('modalVerEmpleado').style.display = 'none'; document.body.style.overflow = 'auto'; };

    window.guardarEmpleado = function() {
        const id = document.getElementById('modalEmpleadoId').value;
        const numericId = id ? parseInt(id) : null;
        
        const formData = new FormData();
        
        const token = document.querySelector('input[name="_token"]')?.value || '';
        formData.append('_token', token);
        
        if (numericId) {
            formData.append('_method', 'PUT');
        }
        
        const camposBasicos = {
            'nombre': document.getElementById('modalNombre')?.value || '',
            'apellido_paterno': document.getElementById('modalApellidoPaterno')?.value || '',
            'apellido_materno': document.getElementById('modalApellidoMaterno')?.value || '',
            'estatus': document.getElementById('modalEstatus')?.value || 'Activo',
            'numero_empleado_interno': document.getElementById('modalNumeroEmpleadoInterno')?.value || '',
            'fecha_ingreso': document.getElementById('modalFechaIngreso')?.value || '',
            'reclutador': document.getElementById('modalReclutador')?.value || '',
            'rfc': document.getElementById('modalRfc')?.value || '',
            'curp': document.getElementById('modalCurp')?.value || '',
            'numero_seguro_social': document.getElementById('modalNumeroSeguroSocial')?.value || '',
            'alias': document.getElementById('modalAlias')?.value || '',
            'fecha_nacimiento': document.getElementById('modalFechaNacimiento')?.value || '',
            'correo': document.getElementById('modalCorreo')?.value || '',
            'celular': document.getElementById('modalCelular')?.value || '',
            'contacto_emergencia': document.getElementById('modalContactoEmergencia')?.value || '',
            'numero_emergencia': document.getElementById('modalNumeroEmergencia')?.value || ''
        };
        
        for (const [key, value] of Object.entries(camposBasicos)) {
            if (value !== '') {
                formData.append(key, value);
            }
        }
        
        const camposDireccion = {
            'calle': document.getElementById('modalCalle')?.value || '',
            'num_exterior': document.getElementById('modalNumExterior')?.value || '',
            'num_interior': document.getElementById('modalNumInterior')?.value || '',
            'satcat_codigos_postales_codigo_postal': document.getElementById('modalSatcatCodigosPostalesCodigoPostal')?.value || '',
            'satcat_paises_clave': document.getElementById('modalSatcatPaisesClave')?.value || 'MEX',
            'estado': document.getElementById('modalEstado')?.value || '',
            'municipio': document.getElementById('modalMunicipio')?.value || '',
            'satcat_colonias_clave': document.getElementById('modalSatcatColoniasClave')?.value || '',
            'satcat_localidades_clave': document.getElementById('modalSatcatLocalidadesClave')?.value || ''
        };
        
        for (const [key, value] of Object.entries(camposDireccion)) {
            if (value !== '') {
                formData.append(key, value);
            }
        }
        
        const camposLaborales = {
            'cat_area_id': document.getElementById('modalCatAreaId')?.value || '',
            'cat_puesto_id': document.getElementById('modalCatPuestoId')?.value || '',
            'sueldo': document.getElementById('modalSueldo')?.value || '',
            'coordinador_plantilla_id': document.getElementById('modalCoordinadorPlantillaId')?.value || ''
        };
        
        for (const [key, value] of Object.entries(camposLaborales)) {
            if (value !== '') {
                formData.append(key, value);
            }
        }
        
        const isOperador = document.getElementById('modalOperador')?.checked || false;
        formData.append('operador', isOperador);
        
        if (isOperador) {
            const camposOperador = {
                'cat_tipo_operador_id': document.getElementById('modalCatTipoOperadorId')?.value || '',
                'cat_tipo_licencia_id': document.getElementById('modalCatTipoLicenciaId')?.value || '',
                'numero_licencia': document.getElementById('modalNumeroLicencia')?.value || '',
                'vencimiento_licencia': document.getElementById('modalVencimientoLicencia')?.value || ''
            };
            
            for (const [key, value] of Object.entries(camposOperador)) {
                if (value !== '') {
                    formData.append(key, value);
                }
            }
        }
        
        const camposNomina = {
            'satcat_nomina_contratos_clave': document.getElementById('modalSatcatNominaContratosClave')?.value || '',
            'satcat_nomina_jornadas_clave': document.getElementById('modalSatcatNominaJornadasClave')?.value || '',
            'satcat_nomina_periodicidades_clave': document.getElementById('modalSatcatNominaPeriodicidadesClave')?.value || '',
            'satcat_nomina_regimenes_clave': document.getElementById('modalSatcatNominaRegimenesClave')?.value || ''
        };
        
        for (const [key, value] of Object.entries(camposNomina)) {
            if (value !== '') {
                formData.append(key, value);
            }
        }
        
        const camposBancarios = {
            'cat_bancos_clave': document.getElementById('modalCatBancosClave')?.value || '',
            'cat_tipo_cuenta_id': document.getElementById('modalCatTipoCuentaId')?.value || '',
            'cuenta': document.getElementById('modalCuenta')?.value || '',
            'propietario': document.getElementById('modalPropietario')?.value || '',
            'cuenta_sucursal': document.getElementById('modalCuentaSucursal')?.value || ''
        };
        
        for (const [key, value] of Object.entries(camposBancarios)) {
            if (value !== '') {
                formData.append(key, value);
            }
        }
        
        formData.append('dias_vacaciones', document.getElementById('modalDiasVacaciones')?.value || '0');
        formData.append('prima_vacacional', document.getElementById('modalPrimaVacacional')?.value || '25');
        formData.append('aguinaldo', document.getElementById('modalAguinaldo')?.value || '15');
        
        formData.append('bono_asistencia', document.getElementById('modalBonoAsistencia')?.value === '1');
        formData.append('bono_productividad', document.getElementById('modalBonoProductividad')?.value === '1');
        formData.append('aplica_asistencia', document.getElementById('modalAplicaAsistencia')?.value === '1');
        formData.append('fonacot', document.getElementById('modalFonacot')?.value === '1');
        formData.append('pension_alimenticia', document.getElementById('modalPensionAlimenticia')?.value === '1');
        
        const fechaBaja = document.getElementById('modalFechaBaja')?.value || '';
        if (fechaBaja) formData.append('fecha_baja', fechaBaja);
        
        const motivoBaja = document.getElementById('modalMotivoBajaId')?.value || '';
        if (motivoBaja) formData.append('motivo_baja_id', motivoBaja);
        
        const montoMensualImss = document.getElementById('modalMontoMensualImss')?.value || '';
        if (montoMensualImss) formData.append('monto_mensual_imss', montoMensualImss);
        
        const montoDiarioImss = document.getElementById('modalMontoDiarioImss')?.value || '';
        if (montoDiarioImss) formData.append('monto_diario_imss', montoDiarioImss);
        
        const montoMensualInfonavit = document.getElementById('modalMontoMensualInfonavit')?.value || '';
        if (montoMensualInfonavit) formData.append('monto_mensual_infonavit', montoMensualInfonavit);
        
        const montoDiarioInfonavit = document.getElementById('modalMontoDiarioInfonavit')?.value || '';
        if (montoDiarioInfonavit) formData.append('monto_diario_infonavit', montoDiarioInfonavit);
        
        const montoMensualIsr = document.getElementById('modalMontoMensualIsr')?.value || '';
        if (montoMensualIsr) formData.append('monto_mensual_isr', montoMensualIsr);
        
        const montoDiarioIsr = document.getElementById('modalMontoDiarioIsr')?.value || '';
        if (montoDiarioIsr) formData.append('monto_diario_isr', montoDiarioIsr);
        
        const documentos = recopilarDocumentos();
        const docsInfo = documentos.map(d => ({ 
            nombre: d.nombre, 
            tieneArchivo: !!d.archivo 
        }));
        formData.append('documentos', JSON.stringify(docsInfo));
        
        for (let i = 0; i < documentos.length; i++) {
            if (documentos[i].archivo) {
                formData.append(`documentos_archivo_${i}`, documentos[i].archivo);
            }
        }
        
        const url = numericId ? `/api/plantilla/${numericId}` : '/api/plantilla';
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('success', data.message || 'Empleado guardado exitosamente');
                cerrarModalEmpleado();
                cargarDatos();
            } else {
                console.error('Error del servidor:', data);
                mostrarNotificacion('error', data.message || 'Error al guardar el empleado');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            mostrarNotificacion('error', 'Error de conexión al servidor: ' + error.message);
        });
    };

    window.eliminarEmpleado = function(id) {
        if (confirm('¿Estás seguro de eliminar este empleado?')) {
            fetch(`/api/plantilla/${parseInt(id)}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json()).then(d => { if (d.success) { mostrarNotificacion('success', 'Empleado eliminado'); cargarDatos(); } else mostrarNotificacion('error', d.message); })
            .catch(() => mostrarNotificacion('error', 'Error de conexión'));
        }
    };

    window.exportarExcel = function() {
        mostrarNotificacion('info', 'Generando archivo Excel...');
        fetch('/plantilla/exportar-excel', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: new URLSearchParams({ buscar: document.getElementById('buscador').value })
        })
        .then(r => r.blob()).then(blob => { const url = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = url; a.download = 'plantilla_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.xlsx'; a.click(); URL.revokeObjectURL(url); mostrarNotificacion('success', 'Archivo descargado'); })
        .catch(() => mostrarNotificacion('error', 'Error al descargar'));
    };

    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        container.innerHTML = '';
        if (!columnasAgrupadas.length) texto.style.display = 'inline';
        else { texto.style.display = 'none'; columnasAgrupadas.forEach(c => { const chip = document.createElement('span'); chip.className = 'columna-agrupada'; chip.innerHTML = `${c} <span class="remover" onclick="removerColumna('${c}')">&times;</span>`; container.appendChild(chip); }); }
        paginaActual = 1; renderizarTabla();
    }
    window.removerColumna = function(c) { columnasAgrupadas = columnasAgrupadas.filter(x => x !== c); actualizarGrupoColumnas(); };
    document.addEventListener('dragstart', e => { if (e.target.matches('[draggable="true"]')) e.dataTransfer.setData('text/plain', e.target.dataset.columna); });
    document.getElementById('grupoAgrupacion').addEventListener('dragover', e => e.preventDefault());
    document.getElementById('grupoAgrupacion').addEventListener('drop', e => { e.preventDefault(); const c = e.dataTransfer.getData('text/plain'); if (c && !columnasAgrupadas.includes(c)) { columnasAgrupadas.push(c); actualizarGrupoColumnas(); mostrarNotificacion('info', 'Agrupando por: ' + c); } });
    window.toggleColumnSelector = function() {
        const s = document.getElementById('columnSelector'); s.style.display = s.style.display === 'none' ? 'block' : 'none';
        if (s.style.display === 'block') document.getElementById('columnasLista').innerHTML = columnas.map(c => `<div style="padding:5px 0;"><input type="checkbox" id="chk_${c.field}" data-columna="${c.field}" ${columnasVisibles.includes(c.field) ? 'checked' : ''} onchange="toggleColumna('${c.field}', this.checked)"> <label style="font-size:12px;">${c.caption}</label></div>`).join('');
    };
    window.toggleColumna = function(c, v) { if (v && !columnasVisibles.includes(c)) columnasVisibles.push(c); else if (!v && columnasVisibles.includes(c)) columnasVisibles = columnasVisibles.filter(x => x !== c); renderizarEncabezados(); renderizarTabla(); };
    window.cerrarColumnSelector = () => document.getElementById('columnSelector').style.display = 'none';
    document.addEventListener('click', e => { if (!e.target.closest('#btnColumnas') && !e.target.closest('#columnSelector')) document.getElementById('columnSelector').style.display = 'none'; });
    document.getElementById('btnCrearFiltro').addEventListener('click', () => mostrarNotificacion('info', 'Funcionalidad en desarrollo'));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { cerrarModalEmpleado(); cerrarModalVer(); } });
    document.getElementById('modalEmpleado').addEventListener('click', e => { if (e.target === e.currentTarget) cerrarModalEmpleado(); });
    document.getElementById('modalVerEmpleado').addEventListener('click', e => { if (e.target === e.currentTarget) cerrarModalVer(); });
    
    function inicializarSelectoresColumnas() { 
        const l = document.getElementById('columnasLista'); 
        if (l && !l.children.length) l.innerHTML = columnas.map(c => `<div style="padding:5px 0;"><input type="checkbox" id="chk_${c.field}" ${columnasVisibles.includes(c.field) ? 'checked' : ''} onchange="toggleColumna('${c.field}', this.checked)"> <label>${c.caption}</label></div>`).join(''); 
    }
    inicializarSelectoresColumnas(); 
    renderizarEncabezados();
    document.getElementById('modalSueldo').addEventListener('input', calcularMontosIMSS);
    document.getElementById('modalSueldo').addEventListener('change', calcularMontosIMSS);
    cargarDatos();
});
</script>
@endsection