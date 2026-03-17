@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Personal Asignado a Proyectos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Personal Asignado a Proyectos
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE PERSONAL CENTRADOS CON TEXTO EN NEGRO -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Total Personal -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Personal</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalPersonal">187</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: En Obra -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">En Obra</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalEnObra">142</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Administrativos -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Administrativos</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="totalAdmin">45</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Costo Mensual -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Costo Mensual</div>
                            <div style="color: #000000; font-size: 36px; font-weight: bold; line-height: 1.2;" id="costoMensual">$845K</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Selectores a la izquierda -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <select id="selectorProyecto" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 250px;">
                            <option value="">Todos los proyectos</option>
                            <option value="PRO-2024-001">PRO-2024-001 - Torre Norte Corporativa</option>
                            <option value="PRO-2024-002">PRO-2024-002 - Puente Vehicular Sur</option>
                            <option value="PRO-2024-003">PRO-2024-003 - Parque Industrial Norte</option>
                            <option value="PRO-2024-004">PRO-2024-004 - Hospital Regional</option>
                            <option value="PRO-2024-005">PRO-2024-005 - Planta Tratamiento</option>
                            <option value="PRO-2024-006">PRO-2024-006 - Urbanización Los Álamos</option>
                        </select>

                        <select id="selectorTipo" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; min-width: 150px;">
                            <option value="">Todos los tipos</option>
                            <option value="Obrero">Obreros</option>
                            <option value="Operador">Operadores</option>
                            <option value="Supervisor">Supervisores</option>
                            <option value="Ingeniero">Ingenieros</option>
                            <option value="Administrativo">Administrativos</option>
                        </select>
                    </div>
                    
                    <!-- Grupo de botones derecho -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar Personal">
                                <i class="fas fa-plus" style="color: #083CAE;"></i>
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

                        <!-- Botón Reporte -->
                        <div>
                            <button id="btnReporte" 
                                    style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                    title="Generar reporte">
                                <i class="fas fa-file-pdf" style="color: #083CAE;"></i>
                            </button>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                            <input type="text" id="buscador" placeholder="Buscar personal..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-users" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay personal asignado para mostrar</p>
                </div>

                <!-- Tabla de Personal Asignado -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative; display: block;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaPersonal" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #2378e1; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Empleado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Nombre</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Tipo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proyecto Asignado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Rol</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Ingreso</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Salario Diario</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #2378e1; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Status</span>
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
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="6">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef; color: #000000;" id="sumSalarios">$0</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef; color: #000000;" colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div id="paginacionContainer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; gap: 5px; background: transparent !important; background-color: transparent !important; border: none !important; box-shadow: none !important;">
                    <!-- Botón Ver todos (izquierda) - SIN FONDO -->
                    <button id="btnVerTodos" style="background: transparent !important; background-color: transparent !important; border: none !important; padding: 8px 15px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 8px; color: #2378e1; box-shadow: none !important; outline: none !important; margin: 0;">
                        <i class="fas fa-eye" style="font-size: 16px; color: #2378e1;"></i>
                        <span style="color: #2378e1;">Ver todos</span>
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
                        <span style="margin-left: 5px; color: #2378e1; font-size: 14px;" id="paginacionInfo">Mostrando 1-5 de 187 registros</span>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Página siguiente" id="btnSiguiente">
                            <i class="fas fa-angle-right" style="color: #2378e1;"></i>
                        </button>
                        <button style="padding: 5px 10px; border: none; background: none; border-radius: 4px; cursor: pointer; color: #2378e1; font-size: 14px;" title="Última página" id="btnUltima">
                            <i class="fas fa-angle-double-right" style="color: #2378e1;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    
    /* Estilo para badges de status */
    .badge-status {
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
    
    .badge-inactivo {
        background-color: #f8d7da;
        color: #dc3545;
    }
    
    .badge-vacaciones {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-permiso {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    /* Badges para tipo de personal */
    .badge-tipo {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    
    .badge-obrero {
        background-color: #e8f0fe;
        color: #2378e1;
    }
    
    .badge-operador {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .badge-supervisor {
        background-color: #fff3cd;
        color: #ffc107;
    }
    
    .badge-ingeniero {
        background-color: #cce5ff;
        color: #0d6efd;
    }
    
    .badge-administrativo {
        background-color: #e9ecef;
        color: #6c757d;
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
    
    /* Estilo específico para btnVerTodos */
    #btnVerTodos,
    #btnVerTodos:hover,
    #btnVerTodos:focus,
    #btnVerTodos:active {
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    #btnVerTodos i,
    #btnVerTodos span {
        color: #2378e1 !important;
    }
    
    #paginacionInfo {
        color: #2378e1 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        select {
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
        console.log('DOM completamente cargado - Personal Asignado a Proyectos');
        
        // Variables
        let currentPage = 1;
        let rowsPerPage = 5;
        let datosOriginales = [];
        
        // Elementos del DOM
        const tablaBody = document.getElementById('tablaBody');
        const tablaContainer = document.getElementById('tablaContainer');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');
        const selectorProyecto = document.getElementById('selectorProyecto');
        const selectorTipo = document.getElementById('selectorTipo');
        const buscador = document.getElementById('buscador');
        const btnAgregar = document.getElementById('btnAgregar');
        const btnExcel = document.getElementById('btnExcel');
        const btnReporte = document.getElementById('btnReporte');
        const btnVerTodos = document.getElementById('btnVerTodos');
        const btnPrimera = document.getElementById('btnPrimera');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnUltima = document.getElementById('btnUltima');
        const paginaActualSpan = document.getElementById('paginaActual');
        const paginacionInfo = document.getElementById('paginacionInfo');
        
        // Datos de ejemplo para personal
        const personalData = [
            { id: 'EMP-001', nombre: 'Juan Pérez', tipo: 'Obrero', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte Corporativa', rol: 'Albañil', fechaIngreso: '15/01/2024', salario: 450, status: 'Activo' },
            { id: 'EMP-002', nombre: 'María García', tipo: 'Supervisor', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte Corporativa', rol: 'Supervisor de Obra', fechaIngreso: '10/01/2024', salario: 850, status: 'Activo' },
            { id: 'EMP-003', nombre: 'Carlos Rodríguez', tipo: 'Operador', proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Vehicular Sur', rol: 'Operador de Retroexcavadora', fechaIngreso: '01/02/2024', salario: 650, status: 'Activo' },
            { id: 'EMP-004', nombre: 'Ana Martínez', tipo: 'Ingeniero', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte Corporativa', rol: 'Ingeniero Residente', fechaIngreso: '05/01/2024', salario: 1200, status: 'Activo' },
            { id: 'EMP-005', nombre: 'Luis Ramírez', tipo: 'Obrero', proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial Norte', rol: 'Carpintero', fechaIngreso: '10/03/2024', salario: 480, status: 'Activo' },
            { id: 'EMP-006', nombre: 'Sofía Castro', tipo: 'Administrativo', proyecto: 'PRO-2024-001', proyectoNombre: 'Torre Norte Corporativa', rol: 'Asistente de Proyectos', fechaIngreso: '20/01/2024', salario: 550, status: 'Activo' },
            { id: 'EMP-007', nombre: 'Javier Ruiz', tipo: 'Operador', proyecto: 'PRO-2024-002', proyectoNombre: 'Puente Vehicular Sur', rol: 'Operador de Grúa', fechaIngreso: '05/02/2024', salario: 700, status: 'Vacaciones' },
            { id: 'EMP-008', nombre: 'Laura Gómez', tipo: 'Ingeniero', proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', rol: 'Ingeniero de Costos', fechaIngreso: '01/09/2023', salario: 1100, status: 'Activo' },
            { id: 'EMP-009', nombre: 'Roberto Sánchez', tipo: 'Supervisor', proyecto: 'PRO-2024-005', proyectoNombre: 'Planta Tratamiento', rol: 'Supervisor de Seguridad', fechaIngreso: '15/01/2024', salario: 820, status: 'Activo' },
            { id: 'EMP-010', nombre: 'Diana Flores', tipo: 'Obrero', proyecto: 'PRO-2024-006', proyectoNombre: 'Urbanización Los Álamos', rol: 'Ayudante General', fechaIngreso: '20/02/2024', salario: 420, status: 'Permiso' },
            { id: 'EMP-011', nombre: 'Miguel Torres', tipo: 'Operador', proyecto: 'PRO-2024-003', proyectoNombre: 'Parque Industrial Norte', rol: 'Operador de Bulldozer', fechaIngreso: '15/03/2024', salario: 680, status: 'Activo' },
            { id: 'EMP-012', nombre: 'Pedro Hernández', tipo: 'Obrero', proyecto: 'PRO-2024-004', proyectoNombre: 'Hospital Regional', rol: 'Fierrero', fechaIngreso: '01/09/2023', salario: 460, status: 'Inactivo' }
        ];
        
        // Mapeo de códigos de proyecto a nombres
        const proyectosMap = {
            'PRO-2024-001': 'Torre Norte Corporativa',
            'PRO-2024-002': 'Puente Vehicular Sur',
            'PRO-2024-003': 'Parque Industrial Norte',
            'PRO-2024-004': 'Hospital Regional',
            'PRO-2024-005': 'Planta Tratamiento',
            'PRO-2024-006': 'Urbanización Los Álamos'
        };
        
        datosOriginales = [...personalData];
        
        // Función para formatear moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(0);
        }
        
        // Función para obtener clase de badge según tipo
        function getTipoBadgeClass(tipo) {
            switch(tipo) {
                case 'Obrero': return 'badge-obrero';
                case 'Operador': return 'badge-operador';
                case 'Supervisor': return 'badge-supervisor';
                case 'Ingeniero': return 'badge-ingeniero';
                case 'Administrativo': return 'badge-administrativo';
                default: return 'badge-tipo';
            }
        }
        
        // Función para obtener clase de badge según status
        function getStatusBadgeClass(status) {
            switch(status) {
                case 'Activo': return 'badge-activo';
                case 'Inactivo': return 'badge-inactivo';
                case 'Vacaciones': return 'badge-vacaciones';
                case 'Permiso': return 'badge-permiso';
                default: return 'badge-status';
            }
        }
        
        // Función para actualizar los cuadros de resumen
        function actualizarResumen(datos) {
            const totalPersonal = datos.length;
            const enObra = datos.filter(p => p.status === 'Activo' && (p.tipo === 'Obrero' || p.tipo === 'Operador' || p.tipo === 'Supervisor')).length;
            const administrativos = datos.filter(p => p.tipo === 'Administrativo' || p.tipo === 'Ingeniero').length;
            
            // Calcular costo mensual (considerando 24 días laborales)
            let costoTotal = 0;
            datos.forEach(p => {
                if (p.status === 'Activo') {
                    costoTotal += p.salario * 24;
                }
            });
            
            document.getElementById('totalPersonal').textContent = totalPersonal;
            document.getElementById('totalEnObra').textContent = enObra;
            document.getElementById('totalAdmin').textContent = administrativos;
            document.getElementById('costoMensual').textContent = formatCurrency(costoTotal / 1000) + 'K';
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
            paginaActualSpan.textContent = currentPage;
            paginacionInfo.textContent = `Mostrando ${Math.min((currentPage - 1) * rowsPerPage + 1, total)}-${Math.min(currentPage * rowsPerPage, total)} de ${total} registros`;
        }
        
        // Función para calcular totales
        function calcularTotales(datos) {
            let totalSalarios = 0;
            
            datos.forEach(item => {
                if (item.status === 'Activo') {
                    totalSalarios += item.salario || 0;
                }
            });
            
            document.getElementById('sumSalarios').textContent = formatCurrency(totalSalarios) + '/día';
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            if (!tablaBody) return;
            
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                document.getElementById('sumSalarios').textContent = '$0/día';
                paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                return;
            }
            
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Actualizar resumen
            actualizarResumen(datos);
            
            // Cargar datos paginados
            const pageData = getCurrentPageData(datos);
            
            pageData.forEach(item => {
                const row = document.createElement('tr');
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.id}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.nombre}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-tipo ${getTipoBadgeClass(item.tipo)}">${item.tipo}</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.proyecto} - ${item.proyectoNombre}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.rol}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;">${item.fechaIngreso}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; color: #000000;">${formatCurrency(item.salario)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; color: #000000;"><span class="badge-status ${getStatusBadgeClass(item.status)}">${item.status}</span></td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalle"></i>
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                            <i class="fas fa-exchange-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Reasignar"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            calcularTotales(datos);
            actualizarPaginacion(datos.length);
        }
        
        // Función para filtrar datos
        function filtrarDatos() {
            let datosFiltrados = [...personalData];
            
            // Filtrar por proyecto
            const proyecto = selectorProyecto.value;
            if (proyecto) {
                datosFiltrados = datosFiltrados.filter(p => p.proyecto === proyecto);
            }
            
            // Filtrar por tipo
            const tipo = selectorTipo.value;
            if (tipo) {
                datosFiltrados = datosFiltrados.filter(p => p.tipo === tipo);
            }
            
            // Filtrar por búsqueda
            const busqueda = buscador.value.toLowerCase();
            if (busqueda) {
                datosFiltrados = datosFiltrados.filter(p => 
                    p.nombre.toLowerCase().includes(busqueda) ||
                    p.id.toLowerCase().includes(busqueda) ||
                    p.rol.toLowerCase().includes(busqueda)
                );
            }
            
            datosOriginales = datosFiltrados;
            currentPage = 1;
            cargarTabla(datosFiltrados);
        }
        
        // Event Listeners
        selectorProyecto.addEventListener('change', filtrarDatos);
        selectorTipo.addEventListener('change', filtrarDatos);
        buscador.addEventListener('input', filtrarDatos);
        
        // Paginación
        function cambiarPagina(delta) {
            const totalPages = Math.ceil(datosOriginales.length / rowsPerPage);
            const nuevaPagina = currentPage + delta;
            
            if (nuevaPagina >= 1 && nuevaPagina <= totalPages) {
                currentPage = nuevaPagina;
                cargarTabla(datosOriginales);
            }
        }
        
        btnPrimera.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = 1;
                cargarTabla(datosOriginales);
            }
        });
        
        btnAnterior.addEventListener('click', () => cambiarPagina(-1));
        btnSiguiente.addEventListener('click', () => cambiarPagina(1));
        
        btnUltima.addEventListener('click', () => {
            if (datosOriginales.length > 0) {
                currentPage = Math.ceil(datosOriginales.length / rowsPerPage);
                cargarTabla(datosOriginales);
            }
        });
        
        // Botones de acción
        btnAgregar.addEventListener('click', () => alert('Agregar nuevo personal - Funcionalidad en desarrollo'));
        
        btnExcel.addEventListener('click', () => {
            alert('Exportando a Excel...');
            // Simular exportación
            setTimeout(() => {
                alert('Exportación completada');
            }, 500);
        });
        
        btnReporte.addEventListener('click', () => {
            alert('Generando reporte de personal...');
        });
        
        btnVerTodos.addEventListener('click', () => {
            selectorProyecto.value = '';
            selectorTipo.value = '';
            buscador.value = '';
            datosOriginales = [...personalData];
            currentPage = 1;
            cargarTabla(datosOriginales);
        });
        
        // Acciones de iconos
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-eye')) {
                const fila = e.target.closest('tr');
                const nombre = fila?.cells[1]?.textContent || 'desconocido';
                alert(`Ver detalle de: ${nombre}`);
            } else if (e.target.classList.contains('fa-edit')) {
                alert('Editar información del personal');
            } else if (e.target.classList.contains('fa-exchange-alt')) {
                alert('Reasignar a otro proyecto');
            }
        });
        
        // Filtros en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', () => alert('Filtro de columna - Funcionalidad en desarrollo'));
        });
        
        // Inicializar
        cargarTabla(personalData);
    });
</script>
@endsection