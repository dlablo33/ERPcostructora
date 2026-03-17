@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Plantilla de Personal RH -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #2378e1; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Plantilla de Personal
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: #2378e1; font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Botón Agregar -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #2378e1; font-size: 18px;" 
                                    title="Agregar empleado"
                                    onclick="abrirModalEmpleado()">
                                <i class="fas fa-plus" style="color: #2378e1;"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;">
                                <i class="fas fa-file-excel" style="color: #2378e1;"></i>
                                
                            </button>
                        </div>

                        <!-- Botón Seleccionar Columnas -->
                        <div style="position: relative;">
                            <button id="btnColumnas" 
                                    style="background-color: white; border: 1px solid #2378e1; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #2378e1;"
                                    onclick="toggleColumnSelector()">
                                <i class="fas fa-columns" style="color: #2378e1;"></i>
                                
                            </button>
                            
                            <!-- Selector de columnas -->
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 45px; background-color: white; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: #2378e1;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 12px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2378e1;"></i>
                            <input type="text" id="buscador" placeholder="Buscar..." style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #2378e1; border-radius: 30px; font-size: 14px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-users" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay empleados registrados</p>
                </div>

                <!-- Tabla con todas las columnas -->
                <div class="table-container" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; overflow-x: auto; background-color: white; max-height: 600px; overflow-y: auto;">
                    <table class="table" id="tablaRH" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 2500px;">
                        <thead style="position: sticky; top: 0; z-index: 10; background-color: #2378e1;">
                            <tr id="encabezadosTabla"></tr>
                        </thead>
                        <tbody id="tablaBody"></tbody>
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 10; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="2" style="padding: 12px 8px; border: 1px solid #dee2e6;">Total: <span id="totalRegistros">0</span></td>
                                <td colspan="29" style="padding: 12px 8px; border: 1px solid #dee2e6;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; gap: 15px; flex-wrap: wrap;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid #2378e1; border-radius: 30px; padding: 8px 20px; cursor: pointer; color: #2378e1;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                    
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid #2378e1; border-radius: 8px; background: transparent; cursor: pointer; color: #2378e1;" id="btnPrimera"><i class="fas fa-angle-double-left"></i></button>
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid #2378e1; border-radius: 8px; background: transparent; cursor: pointer; color: #2378e1;" id="btnAnterior"><i class="fas fa-angle-left"></i></button>
                        <span style="min-width: 40px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: #2378e1; color: white; border-radius: 8px;" id="paginaActual">1</span>
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid #2378e1; border-radius: 8px; background: transparent; cursor: pointer; color: #2378e1;" id="btnSiguiente"><i class="fas fa-angle-right"></i></button>
                        <button class="page-btn" style="width: 36px; height: 36px; border: 1px solid #2378e1; border-radius: 8px; background: transparent; cursor: pointer; color: #2378e1;" id="btnUltima"><i class="fas fa-angle-double-right"></i></button>
                    </div>
                    
                    <span style="color: #2378e1; font-size: 13px;" id="paginacionInfo">Mostrando 0-0 de 0</span>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA NUEVO EMPLEADO -->
<div id="modalEmpleado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 16px; width: 95%; max-width: 900px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: #2378e1; padding: 20px; border-radius: 16px 16px 0 0; position: sticky; top: 0; z-index: 10;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-user-plus" style="color: white; font-size: 24px;"></i>
                    <h3 style="color: white; margin: 0; font-size: 20px;">Nuevo Empleado</h3>
                </div>
                <button onclick="cerrarModalEmpleado()" style="background: rgba(255,255,255,0.2); border: none; width: 40px; height: 40px; border-radius: 50%; color: white; font-size: 20px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- Formulario (mismo contenido del modal anterior) -->
        <div style="padding: 25px;">
            <!-- Información Personal -->
            <h4 style="color: #2378e1; margin: 0 0 15px; font-size: 16px; border-bottom: 2px solid #2378e1; padding-bottom: 8px;">
                <i class="fas fa-id-card"></i> Información Personal
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
                <div><label>Estatus *</label><select style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"><option>Activo</option><option>Inactivo</option><option>Vacaciones</option><option>Baja</option></select></div>
                <div><label>No. Interno</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="EMP-001"></div>
                <div style="grid-column: span 2;"><label>Nombre Completo *</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Nombre completo"></div>
                <div><label>Alias</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Apodo"></div>
                <div><label>RFC</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="RFC"></div>
                <div><label>CURP</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="CURP"></div>
                <div><label>NSS</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="NSS"></div>
                <div><label>Licencia</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Licencia"></div>
            </div>

            <!-- Datos de Contacto -->
            <h4 style="color: #2378e1; margin: 0 0 15px; font-size: 16px; border-bottom: 2px solid #2378e1; padding-bottom: 8px;">
                <i class="fas fa-phone-alt"></i> Datos de Contacto
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
                <div><label>Fecha Nacimiento</label><input type="date" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"></div>
                <div style="grid-column: span 2;"><label>Correo Electrónico</label><input type="email" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="correo@ejemplo.com"></div>
                <div><label>Celular</label><input type="tel" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="(55) 1234-5678"></div>
            </div>

            <!-- Dirección -->
            <h4 style="color: #2378e1; margin: 0 0 15px; font-size: 16px; border-bottom: 2px solid #2378e1; padding-bottom: 8px;">
                <i class="fas fa-map-marker-alt"></i> Dirección
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px;">
                <div><label>C.P.</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="C.P."></div>
                <div style="grid-column: span 2;"><label>Calle</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Calle"></div>
                <div><label>No. Exterior</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Ext"></div>
                <div><label>No. Interior</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Int"></div>
                <div><label>Colonia</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Colonia"></div>
                <div><label>Municipio</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Municipio"></div>
                <div><label>Estado</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Estado"></div>
                <div><label>País</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="País" value="México"></div>
            </div>

            <!-- Datos Laborales -->
            <h4 style="color: #2378e1; margin: 0 0 15px; font-size: 16px; border-bottom: 2px solid #2378e1; padding-bottom: 8px;">
                <i class="fas fa-briefcase"></i> Datos Laborales
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
                <div><label>Área</label><select style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"><option>Administración</option><option>Operaciones</option><option>RRHH</option><option>Finanzas</option><option>Proyectos</option></select></div>
                <div><label>Puesto</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Puesto"></div>
                <div><label>Coordinador</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="Coordinador"></div>
                <div><label>¿Es Operador?</label><select style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"><option>No</option><option>Sí</option></select></div>
            </div>

            <!-- Datos Bancarios -->
            <h4 style="color: #2378e1; margin: 0 0 15px; font-size: 16px; border-bottom: 2px solid #2378e1; padding-bottom: 8px;">
                <i class="fas fa-university"></i> Datos Bancarios
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div><label>Tipo Cuenta</label><select style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"><option>Débito</option><option>Crédito</option><option>Nómina</option></select></div>
                <div><label>Banco</label><select style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;"><option>BBVA</option><option>Santander</option><option>Banamex</option><option>Banorte</option></select></div>
                <div style="grid-column: span 2;"><label>CLABE</label><input type="text" style="width:100%; padding:10px; border:2px solid #e9ecef; border-radius:8px;" placeholder="CLABE"></div>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="padding: 20px; background-color: #f8f9fa; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
            <button onclick="cerrarModalEmpleado()" style="padding: 12px 24px; border: 2px solid #dee2e6; border-radius: 8px; background: white; cursor: pointer;">Cancelar</button>
            <button style="padding: 12px 30px; border: none; border-radius: 8px; background: #2378e1; color: white; cursor: pointer;">Guardar</button>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .semaforo .card-header h2 {
        color: #083CAE !important;
    }
    
    .table th {
        background-color: #2378e1 !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
        white-space: nowrap;
    }
    
    #tablaBody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    #tablaBody tr:hover {
        background-color: #e8f0fe;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-activo {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .badge-inactivo {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
    
    .badge-vacaciones {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    
    .badge-baja {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
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
        color: #2378e1;
        font-size: 12px;
        border: 1px solid #2378e1;
    }
    
    /* Modal */
    #modalEmpleado {
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .hide-mobile {
            display: none !important;
        }
        
        #modalEmpleado > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table {
            min-width: 2500px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definición de columnas completa (31 columnas)
    const columnasRH = [
        { dataField: 'estatus_txt', caption: 'Estatus', visible: true, type: 'badge' },
        { dataField: 'plantilla_id', caption: 'ID', visible: true, type: 'number' },
        { dataField: 'numero_empleado_interno', caption: 'No. Interno', visible: true },
        { dataField: 'nombre_completo', caption: 'Nombre', visible: true },
        { dataField: 'rfc', caption: 'RFC', visible: true },
        { dataField: 'numero_licencia', caption: 'Licencia', visible: true },
        { dataField: 'cp', caption: 'C.P.', visible: true, dataField: 'satcat_codigos_postales_codigo_postal' },
        { dataField: 'calle', caption: 'Calle', visible: true },
        { dataField: 'num_exterior', caption: 'No. Exterior', visible: true },
        { dataField: 'num_interior', caption: 'No. Interior', visible: true },
        { dataField: 'colonia', caption: 'Colonia', visible: true },
        { dataField: 'localidad', caption: 'Localidad', visible: true },
        { dataField: 'municipio', caption: 'Municipio', visible: true },
        { dataField: 'estado', caption: 'Estado', visible: true },
        { dataField: 'pais', caption: 'País', visible: true },
        { dataField: 'fecha_nacimiento', caption: 'F. Nacimiento', visible: false, type: 'date' },
        { dataField: 'correo', caption: 'Correo', visible: false },
        { dataField: 'celular', caption: 'Celular', visible: false },
        { dataField: 'numero_seguro_social', caption: 'NSS', visible: false },
        { dataField: 'curp', caption: 'CURP', visible: false },
        { dataField: 'alias', caption: 'Alias', visible: false },
        { dataField: 'area', caption: 'Área', visible: true },
        { dataField: 'puesto', caption: 'Puesto', visible: true },
        { dataField: 'cuenta', caption: 'Tipo Cuenta', visible: true },
        { dataField: 'cuenta_clabe', caption: 'CLABE', visible: true },
        { dataField: 'banco', caption: 'Banco', visible: true },
        { dataField: 'alias_bancario', caption: 'Alias Bancario', visible: true, dataField: 'alias' },
        { dataField: 'coordinador', caption: 'Coordinador', visible: true },
        { dataField: 'is_operador', caption: 'Operador', visible: true, type: 'boolean' }
    ];

    // Datos de ejemplo con todas las columnas
    const datosRH = [
        {
            plantilla_id: 1,
            numero_empleado_interno: 'EMP-001',
            nombre_completo: 'Juan Carlos Pérez López',
            rfc: 'PELJ850101',
            curp: 'PELJ850101HDFRRN01',
            numero_licencia: 'LIC-2025-001',
            estatus_txt: 'Activo',
            satcat_codigos_postales_codigo_postal: '66220',
            calle: 'Av. Constitución',
            num_exterior: '123',
            num_interior: 'A',
            colonia: 'Centro',
            localidad: 'Monterrey',
            municipio: 'Monterrey',
            estado: 'Nuevo León',
            pais: 'México',
            fecha_nacimiento: '1985-01-15',
            correo: 'juan.perez@empresa.com',
            celular: '8112345678',
            numero_seguro_social: '12345678901',
            alias: 'Juancho',
            area: 'Operaciones',
            puesto: 'Supervisor de Obra',
            cuenta: 'Débito',
            cuenta_clabe: '012345678901234567',
            banco: 'BBVA',
            coordinador: 'María García',
            is_operador: 'No'
        },
        {
            plantilla_id: 2,
            numero_empleado_interno: 'EMP-002',
            nombre_completo: 'María Guadalupe Rodríguez',
            rfc: 'ROGM900101',
            curp: 'ROGM900101MDFDRR02',
            numero_licencia: 'LIC-2025-002',
            estatus_txt: 'Vacaciones',
            satcat_codigos_postales_codigo_postal: '64000',
            calle: 'Av. Juárez',
            num_exterior: '456',
            num_interior: '',
            colonia: 'Obispado',
            localidad: 'Monterrey',
            municipio: 'Monterrey',
            estado: 'Nuevo León',
            pais: 'México',
            fecha_nacimiento: '1990-02-20',
            correo: 'maria.rodriguez@empresa.com',
            celular: '8123456789',
            numero_seguro_social: '23456789012',
            alias: 'Mary',
            area: 'Recursos Humanos',
            puesto: 'Coordinadora de RH',
            cuenta: 'Nómina',
            cuenta_clabe: '234567890123456789',
            banco: 'Santander',
            coordinador: 'Roberto Sánchez',
            is_operador: 'No'
        },
        {
            plantilla_id: 3,
            numero_empleado_interno: 'EMP-003',
            nombre_completo: 'Pedro Armando García',
            rfc: 'GAPA880315',
            curp: 'GAPA880315HNLGRR03',
            numero_licencia: 'LIC-2025-003',
            estatus_txt: 'Inactivo',
            satcat_codigos_postales_codigo_postal: '66260',
            calle: 'Av. Lázaro Cárdenas',
            num_exterior: '789',
            num_interior: 'B',
            colonia: 'Valle Alto',
            localidad: 'San Pedro',
            municipio: 'San Pedro Garza García',
            estado: 'Nuevo León',
            pais: 'México',
            fecha_nacimiento: '1988-03-15',
            correo: 'pedro.garcia@empresa.com',
            celular: '8134567890',
            numero_seguro_social: '34567890123',
            alias: 'Pedrito',
            area: 'Proyectos',
            puesto: 'Residente de Obra',
            cuenta: 'Débito',
            cuenta_clabe: '345678901234567890',
            banco: 'Banamex',
            coordinador: 'Juan Pérez',
            is_operador: 'No'
        }
    ];

    let columnasVisibles = columnasRH.filter(col => col.visible).map(col => col.dataField || col.dataField);
    let datosFiltrados = [...datosRH];
    let paginaActual = 1;
    const registrosPorPagina = 10;
    let columnasAgrupadas = [];

    // Renderizar encabezados
    function renderizarEncabezados() {
        const thead = document.getElementById('encabezadosTabla');
        if (!thead) return;
        
        let html = '';
        columnasRH.filter(col => columnasVisibles.includes(col.dataField || col.dataField)).forEach(col => {
            html += `<th draggable="true" data-columna="${col.dataField || col.dataField}" style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #2378e1; color: white;">${col.caption}</th>`;
        });
        html += `<th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: #2378e1; color: white;">Acciones</th>`;
        thead.innerHTML = html;
    }

    // Formatear valor
    function formatearValor(valor, tipo) {
        if (valor === null || valor === undefined || valor === '') return '-';
        if (tipo === 'badge') {
            let clase = 'badge-inactivo';
            if (valor === 'Activo') clase = 'badge-activo';
            if (valor === 'Vacaciones') clase = 'badge-vacaciones';
            if (valor === 'Baja') clase = 'badge-baja';
            return `<span class="badge ${clase}">${valor}</span>`;
        }
        if (tipo === 'boolean') {
            return valor === 'Sí' ? '✓' : '✗';
        }
        if (tipo === 'date' && valor) {
            const partes = valor.split('-');
            return partes.length === 3 ? `${partes[2]}/${partes[1]}/${partes[0]}` : valor;
        }
        return valor;
    }

    // Cargar tabla
    function cargarTabla(datos) {
        const tbody = document.getElementById('tablaBody');
        const sinDatos = document.getElementById('sinDatosMensaje');
        const totalReg = document.getElementById('totalRegistros');
        
        if (!tbody) return;

        if (datos.length === 0) {
            sinDatos.style.display = 'block';
            tbody.innerHTML = '';
            totalReg.textContent = '0';
            document.getElementById('paginacionInfo').textContent = 'Mostrando 0-0 de 0';
            return;
        }

        sinDatos.style.display = 'none';
        
        let html = '';
        const start = (paginaActual - 1) * registrosPorPagina;
        const end = start + registrosPorPagina;
        const pageData = datos.slice(start, end);

        pageData.forEach(item => {
            html += '<tr>';
            columnasRH.filter(col => columnasVisibles.includes(col.dataField || col.dataField)).forEach(col => {
                const valor = item[col.dataField || col.dataField];
                html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6;">${formatearValor(valor, col.type)}</td>`;
            });
            html += `<td style="padding: 10px 8px; border: 1px solid #dee2e6;">
                <i class="fas fa-edit" style="color: #083CAE; margin: 0 5px; cursor: pointer;" onclick="alert('Editar')"></i>
                <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar?')) alert('Eliminado')"></i>
                <i class="fas fa-eye" style="color: #083CAE; margin: 0 5px; cursor: pointer;" onclick="alert('Ver')"></i>
            </td>`;
            html += '</tr>';
        });

        tbody.innerHTML = html;
        totalReg.textContent = datos.length;
        
        // Actualizar paginación
        const totalPaginas = Math.ceil(datos.length / registrosPorPagina);
        document.getElementById('paginaActual').textContent = paginaActual;
        const inicio = (paginaActual - 1) * registrosPorPagina + 1;
        const fin = Math.min(paginaActual * registrosPorPagina, datos.length);
        document.getElementById('paginacionInfo').textContent = 
            datos.length > 0 ? `Mostrando ${inicio}-${fin} de ${datos.length}` : 'Mostrando 0-0 de 0';
    }

    // Filtrar por búsqueda
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        if (!termino) {
            datosFiltrados = [...datosRH];
        } else {
            datosFiltrados = datosRH.filter(item => 
                item.nombre_completo?.toLowerCase().includes(termino) ||
                item.rfc?.toLowerCase().includes(termino) ||
                item.area?.toLowerCase().includes(termino) ||
                item.puesto?.toLowerCase().includes(termino) ||
                item.estatus_txt?.toLowerCase().includes(termino)
            );
        }
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    });

    // Paginación
    document.getElementById('btnPrimera').addEventListener('click', () => {
        paginaActual = 1;
        cargarTabla(datosFiltrados);
    });
    
    document.getElementById('btnAnterior').addEventListener('click', () => {
        if (paginaActual > 1) {
            paginaActual--;
            cargarTabla(datosFiltrados);
        }
    });
    
    document.getElementById('btnSiguiente').addEventListener('click', () => {
        const totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);
        if (paginaActual < totalPaginas) {
            paginaActual++;
            cargarTabla(datosFiltrados);
        }
    });
    
    document.getElementById('btnUltima').addEventListener('click', () => {
        paginaActual = Math.ceil(datosFiltrados.length / registrosPorPagina) || 1;
        cargarTabla(datosFiltrados);
    });

    // Drag & drop
    document.addEventListener('dragstart', (e) => {
        if (e.target.tagName === 'TH' && e.target.draggable) {
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
        }
    });

    function actualizarGrupoColumnas() {
        const container = document.getElementById('grupoColumnas');
        const texto = document.getElementById('textoAgrupar');
        
        container.innerHTML = '';
        
        if (columnasAgrupadas.length === 0) {
            texto.style.display = 'inline';
        } else {
            texto.style.display = 'none';
            columnasAgrupadas.forEach(col => {
                const chip = document.createElement('span');
                chip.className = 'columna-agrupada';
                chip.innerHTML = `${col} <span class="remover" style="cursor:pointer; margin-left:5px;" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnasRH.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.dataField || col.dataField}"
                           data-columna="${col.dataField || col.dataField}"
                           ${columnasVisibles.includes(col.dataField || col.dataField) ? 'checked' : ''}
                           ${!col.allowHiding ? 'disabled' : ''}
                           style="margin-right: 8px;">
                    <label for="chk_${col.dataField || col.dataField}" style="font-size: 13px;">${col.caption}</label>
                </div>
            `).join('');
            
            lista.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.addEventListener('change', function() {
                    const columna = this.dataset.columna;
                    if (this.checked && !columnasVisibles.includes(columna)) {
                        columnasVisibles.push(columna);
                    } else if (!this.checked && columnasVisibles.includes(columna)) {
                        columnasVisibles = columnasVisibles.filter(c => c !== columna);
                    }
                    renderizarEncabezados();
                    cargarTabla(datosFiltrados);
                });
            });
        }
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

    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar Excel'));

    // Inicializar
    renderizarEncabezados();
    cargarTabla(datosRH);
});

// Funciones del modal
function abrirModalEmpleado() {
    document.getElementById('modalEmpleado').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalEmpleado() {
    document.getElementById('modalEmpleado').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModalEmpleado();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalEmpleado').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalEmpleado();
    }
});
</script>
@endsection