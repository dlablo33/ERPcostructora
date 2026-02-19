@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Comisiones -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Comisiones
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    
                    <!-- Date Inicio -->
                    <div>
                        <input type="date" id="fechaInicio" value="2026-01-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                    </div>

                    <!-- Date Fin -->
                    <div>
                        <input type="date" id="fechaFin" value="2026-02-17" style="padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; width: 140px;">
                    </div>

                    <!-- Botón Crear filtro -->


                    <!-- Botón Agregar (+) -->
                    <div>
                        <button id="btnAgregar" style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar">
                            <i class="fas fa-plus" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Botón Exportar Excel -->
                    <div>
                        <button id="btnExcel" 
                                style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                title="Exportar todo">
                            <i class="fas fa-file-excel" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Botón Seleccionar Columnas -->
                    <div>
                        <button id="btnColumnas" 
                                style="background-color: white; border: 1px solid #6B8ACE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                title="Seleccionar columnas">
                            <i class="fas fa-columns" style="color: #6B8ACE;"></i>
                        </button>
                    </div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #6B8ACE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #6B8ACE; border-radius: 4px; font-size: 14px; width: 200px;">
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Comisiones -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaComisiones" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Proveedor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Monto Comisión</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factura</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Factura</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #6B8ACE; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Acciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <!-- Las filas se insertarán dinámicamente -->
                        </tbody>
                        <!-- Fila de totales (summary) -->
                        <tfoot id="tablaFoot" style="position: sticky; bottom: 0; z-index: 20; background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #e9ecef;" colspan="1">Totales:</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef;" colspan="2"></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumTotal">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #e9ecef;" id="sumComision">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: #e9ecef;" colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;" id="paginacionContainer">
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Primera página"><i class="fas fa-angle-double-left"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Página anterior"><i class="fas fa-angle-left"></i></button>
                    <span style="padding: 5px 10px; background-color: #6B8ACE; color: white; border-radius: 4px;">1</span>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;">2</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;">3</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Página siguiente"><i class="fas fa-angle-right"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #6B8ACE;" title="Última página"><i class="fas fa-angle-double-right"></i></button>
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-0 de 0 registros</span>
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
    
    /* Estilos de tabla */
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #6B8ACE !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 4px;
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
    
    /* Estilo para badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-block;
        border-radius: 3px;
    }
    
    .badge-pendiente {
        background-color: #fd7e14;
        color: white;
    }
    
    .badge-aprobada {
        background-color: #28a745;
        color: white;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-pagada {
        background-color: #28a745;
        color: white;
    }
    
    .badge-proceso {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-rechazada {
        background-color: #dc3545;
        color: white;
    }
    
    /* Estilo para el pie de tabla (totales) */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        div[style*="justify-content: flex-end"] {
            justify-content: center !important;
        }
        
        input[type="date"] {
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
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Comisiones');
        
        // Datos de ejemplo para Comisiones
        const datosComisiones = [
            {
                comision_id: 1001,
                estatus_txt: 'Pendiente',
                fecha: '2026-01-15',
                razon_social: 'Transportes del Bajío',
                total: 50000.00,
                total_comision: 2500.00,
                factura: 'FAC-001',
                fecha_factura: '2026-01-10'
            },
            {
                comision_id: 1002,
                estatus_txt: 'Aprobada',
                fecha: '2026-01-14',
                razon_social: 'Logística Monterrey',
                total: 75000.00,
                total_comision: 3750.00,
                factura: 'FAC-002',
                fecha_factura: '2026-01-09'
            },
            {
                comision_id: 1003,
                estatus_txt: 'Pagada',
                fecha: '2026-01-13',
                razon_social: 'Autotransportes Mexicanos',
                total: 32000.00,
                total_comision: 1600.00,
                factura: 'FAC-003',
                fecha_factura: '2026-01-08'
            },
            {
                comision_id: 1004,
                estatus_txt: 'Proceso',
                fecha: '2026-01-12',
                razon_social: 'Ferrocarriles Nacionales',
                total: 68000.00,
                total_comision: 3400.00,
                factura: 'FAC-004',
                fecha_factura: '2026-01-07'
            },
            {
                comision_id: 1005,
                estatus_txt: 'Rechazada',
                fecha: '2026-01-11',
                razon_social: 'Cervecería del Centro',
                total: 45000.00,
                total_comision: 2250.00,
                factura: 'FAC-005',
                fecha_factura: '2026-01-06'
            },
            {
                comision_id: 1006,
                estatus_txt: 'Aprobada',
                fecha: '2026-01-10',
                razon_social: 'Papelera del Pacífico',
                total: 89000.00,
                total_comision: 4450.00,
                factura: 'FAC-006',
                fecha_factura: '2026-01-05'
            }
        ];
        
        // Función para formatear números como moneda
        function formatCurrency(amount) {
            return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para formatear fecha
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para calcular totales (summary)
        function calcularTotales(datos) {
            let totalGeneral = 0;
            let totalComisionGeneral = 0;
            
            datos.forEach(item => {
                totalGeneral += item.total || 0;
                totalComisionGeneral += item.total_comision || 0;
            });
            
            document.getElementById('sumTotal').textContent = formatCurrency(totalGeneral);
            document.getElementById('sumComision').textContent = formatCurrency(totalComisionGeneral);
            document.getElementById('totalRegistros').textContent = datos.length;
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const tablaContainer = document.getElementById('tablaContainer');
            
            if (!tablaBody) return;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                // Mostrar mensaje sin datos y ocultar tabla
                sinDatosMensaje.style.display = 'block';
                tablaContainer.style.display = 'none';
                
                // Resetear totales
                document.getElementById('sumTotal').textContent = '$0.00';
                document.getElementById('sumComision').textContent = '$0.00';
                document.getElementById('totalRegistros').textContent = '0';
                
                const paginacionInfo = document.getElementById('paginacionInfo');
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            // Ocultar mensaje sin datos y mostrar tabla
            sinDatosMensaje.style.display = 'none';
            tablaContainer.style.display = 'block';
            
            // Generar filas de la tabla
            datos.forEach(item => {
                const row = document.createElement('tr');
                
                // Determinar clase del badge según estatus
                let badgeClass = 'badge-pendiente';
                if (item.estatus_txt === 'Aprobada') badgeClass = 'badge-aprobada';
                else if (item.estatus_txt === 'Pagada') badgeClass = 'badge-pagada';
                else if (item.estatus_txt === 'Rechazada') badgeClass = 'badge-rechazada';
                else if (item.estatus_txt === 'Cancelada') badgeClass = 'badge-cancelada';
                else if (item.estatus_txt === 'Proceso') badgeClass = 'badge-proceso';
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.comision_id || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <span class="badge ${badgeClass}">${item.estatus_txt || '-'}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.fecha ? formatDate(item.fecha) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.razon_social || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.total ? formatCurrency(item.total) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.total_comision ? formatCurrency(item.total_comision) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.factura || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.fecha_factura ? formatDate(item.fecha_factura) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                            <i class="fas fa-eye" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Ver detalles"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            // Calcular y mostrar totales
            calcularTotales(datos);
            
            // Actualizar información de paginación
            const paginacionInfo = document.getElementById('paginacionInfo');
            if (paginacionInfo) {
                paginacionInfo.textContent = `Mostrando 1-${datos.length} de ${datos.length} registros`;
            }
        }
        
        // Cargar datos iniciales
        cargarTabla(datosComisiones);
        
        // Event Listeners
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        document.getElementById('btnCrearFiltro')?.addEventListener('click', function() {
            alert('Crear filtro - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Agregar Comisión - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaComisiones', 'Comisiones');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosComisiones.filter(item => 
                item.razon_social?.toLowerCase().includes(busqueda) ||
                item.factura?.toLowerCase().includes(busqueda) ||
                item.estatus_txt?.toLowerCase().includes(busqueda) ||
                item.comision_id?.toString().includes(busqueda)
            );
            cargarTabla(datosFiltrados);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - Funcionalidad en desarrollo');
            });
        });
        
        // Acciones de los iconos (delegación de eventos)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fa-edit')) {
                alert('Editar Comisión - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar esta comisión?')) {
                    alert('Eliminar Comisión - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-eye')) {
                alert('Ver detalles de Comisión - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            }
        });
        
        // Paginación
        document.querySelectorAll('#paginacionContainer button').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('active') && !this.closest('span')) {
                    alert('Cambiar de página - Funcionalidad en desarrollo');
                }
            });
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
    });
</script>
@endsection