@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Notas de Crédito -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Notas de Crédito
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- 4 CUADROS DE NOTAS DE CRÉDITO CENTRADOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">1</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pagadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagadas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">0</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Timbrado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Timbrado</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">1</div>
                        </div>
                    </div>
                </div>

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


                    <!-- Botón Agregar (+) -->
                    <div>
                        <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;" title="Agregar">
                            <i class="fas fa-plus" style="color: #083CAE;"></i>
                        </button>
                    </div>

                    <!-- Botón Exportar Excel -->
                    <div>
                        <button id="btnExcel" 
                                style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                title="Exportar todo">
                            <i class="fas fa-file-excel" style="color: #083CAE;"></i>
                        </button>
                    </div>

                    <!-- Botón Seleccionar Columnas -->
                    <div>
                        <button id="btnColumnas" 
                                style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: #083CAE;"
                                title="Seleccionar columnas">
                            <i class="fas fa-columns" style="color: #083CAE;"></i>
                        </button>
                    </div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                    </div>
                </div>

                <!-- Mensaje "Sin datos" centrado -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay registros para mostrar</p>
                </div>

                <!-- Tabla de Notas de Crédito -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaNotasCredito" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #083CAE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Estatus</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Creación</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Serie</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cliente</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>RFC</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>R.IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>R.ISR</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Timbrado</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Uso CFDI</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Forma de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método de Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>UUID</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Emisor</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
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
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;" id="paginacionContainer">
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Primera página"><i class="fas fa-angle-double-left"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Página anterior"><i class="fas fa-angle-left"></i></button>
                    <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;">3</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Página siguiente"><i class="fas fa-angle-right"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Última página"><i class="fas fa-angle-double-right"></i></button>
                    <span style="margin-left: 10px; color: #6c757d;" id="paginacionInfo">Mostrando 1-1 de 1 registros</span>
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
        background-color: #083CAE !important;
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
    
    .badge-activa {
        background-color: #28a745;
        color: white;
    }
    
    .badge-pagada {
        background-color: #ffc107;
        color: black;
    }
    
    .badge-cancelada {
        background-color: #dc3545;
        color: white;
    }
    
    /* Números alineados a la derecha */
    .text-right {
        text-align: right;
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
        console.log('DOM completamente cargado - Notas de Crédito');
        
        // Datos de ejemplo para Notas de Crédito
        const datosNotasCredito = [
            {
                estatus: 'Activa',
                created_at: '2026-01-15 10:30:00',
                folio: 1001,
                serie: 'NC',
                cliente: 'Maquiladora Industrial',
                rfc: 'MII880101ABC',
                cat_monedas_clave: 'MXN',
                subtotal: 5000.00,
                iva: 800.00,
                riva: 0.00,
                risr: 0.00,
                total: 5800.00,
                fecha_timbrado: '2026-01-15 10:35:00',
                satcat_uso_cfdi_clave: 'G01',
                satcat_formas_pago_clave: 'Transferencia',
                satcat_metodos_pago_clave: 'PPD',
                uuid: 'ABC123DEF456GHI789',
                empresa_emisor: 'EMPRESA SA DE CV',
                cat_tipos_servicios_descripcion: 'Nota de Crédito por devolución'
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
            return date.toLocaleDateString('es-MX') + ' ' + date.toLocaleTimeString('es-MX', {hour: '2-digit', minute:'2-digit'});
        }
        
        // Función para formatear fecha sin hora
        function formatShortDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('es-MX');
        }
        
        // Función para cargar datos en la tabla
        function cargarTabla(datos) {
            const tablaBody = document.getElementById('tablaBody');
            const sinDatosMensaje = document.getElementById('sinDatosMensaje');
            const paginacionInfo = document.getElementById('paginacionInfo');
            
            if (!tablaBody) return;
            
            // Limpiar tabla
            tablaBody.innerHTML = '';
            
            if (datos.length === 0) {
                // Mostrar mensaje sin datos
                sinDatosMensaje.style.display = 'block';
                
                // Actualizar contadores a 0
                document.querySelectorAll('.custom-card div:last-child').forEach((el, index) => {
                    if (index === 0) el.textContent = '0';
                    else if (index === 1) el.textContent = '0';
                    else if (index === 2) el.textContent = '0';
                    else if (index === 3) el.textContent = '0';
                });
                
                if (paginacionInfo) {
                    paginacionInfo.textContent = 'Mostrando 0-0 de 0 registros';
                }
                return;
            }
            
            // Ocultar mensaje sin datos
            sinDatosMensaje.style.display = 'none';
            
            // Actualizar contadores
            const totalFacturas = datos.length;
            const activas = datos.filter(d => d.estatus === 'Activa').length;
            const pagadas = datos.filter(d => d.estatus === 'Pagada').length;
            const timbradas = datos.filter(d => d.fecha_timbrado).length;
            
            document.querySelectorAll('.custom-card div:last-child').forEach((el, index) => {
                if (index === 0) el.textContent = totalFacturas;
                else if (index === 1) el.textContent = activas;
                else if (index === 2) el.textContent = pagadas;
                else if (index === 3) el.textContent = timbradas;
            });
            
            // Generar filas de la tabla
            datos.forEach(item => {
                const row = document.createElement('tr');
                
                // Determinar clase del badge según estatus
                let badgeClass = 'badge-activa';
                if (item.estatus === 'Pagada') badgeClass = 'badge-pagada';
                else if (item.estatus === 'Cancelada') badgeClass = 'badge-cancelada';
                
                row.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">
                        <span class="badge ${badgeClass}">${item.estatus || '-'}</span>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.created_at ? formatDate(item.created_at) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.folio || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.serie || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.cliente || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.rfc || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.cat_monedas_clave || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.subtotal ? formatCurrency(item.subtotal) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.iva ? formatCurrency(item.iva) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.riva ? formatCurrency(item.riva) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.risr ? formatCurrency(item.risr) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">${item.total ? formatCurrency(item.total) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.fecha_timbrado ? formatDate(item.fecha_timbrado) : '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.satcat_uso_cfdi_clave || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.satcat_formas_pago_clave || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.satcat_metodos_pago_clave || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">${item.uuid || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.empresa_emisor || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">${item.cat_tipos_servicios_descripcion || '-'}</td>
                    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                        </div>
                    </td>
                `;
                
                tablaBody.appendChild(row);
            });
            
            // Actualizar texto de paginación
            if (paginacionInfo) {
                paginacionInfo.textContent = `Mostrando 1-${datos.length} de ${datos.length} registros`;
            }
        }
        
        // Cargar datos iniciales
        cargarTabla(datosNotasCredito);
        
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
            alert('Agregar Nota de Crédito - Funcionalidad en desarrollo');
        });
        
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaNotasCredito', 'NotasCredito');
        });
        
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - Funcionalidad en desarrollo');
        });
        
        document.getElementById('buscador')?.addEventListener('input', function(e) {
            console.log('Buscando:', e.target.value);
            const busqueda = e.target.value.toLowerCase();
            const datosFiltrados = datosNotasCredito.filter(item => 
                item.cliente?.toLowerCase().includes(busqueda) ||
                item.rfc?.toLowerCase().includes(busqueda) ||
                item.serie?.toLowerCase().includes(busqueda) ||
                item.estatus?.toLowerCase().includes(busqueda) ||
                item.uuid?.toLowerCase().includes(busqueda)
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
                alert('Editar Nota de Crédito - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-trash-alt')) {
                if (confirm('¿Está seguro de eliminar esta nota de crédito?')) {
                    alert('Eliminar Nota de Crédito - Funcionalidad en desarrollo');
                }
            } else if (e.target.classList.contains('fa-file-pdf')) {
                alert('Descargar PDF - Funcionalidad en desarrollo');
            } else if (e.target.classList.contains('fa-file-code')) {
                alert('Descargar XML - Funcionalidad en desarrollo');
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