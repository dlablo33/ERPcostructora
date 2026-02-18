@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Facturacion -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Facturación
                </h2>
            </div>

            <!-- ============================================ -->
            <!-- CUADROS DE FACTURACIÓN - AJUSTE DE ALTURA  
            /* CAMBIO DE ALTURA: Modificar el padding (espaciado interno) y el min-height para controlar la altura de los cuadros */
            /* Valores actuales: padding: 12px 20px, min-height: 90px */
            /* Para hacerlos más pequeños: reducir el padding vertical (primer valor) y el min-height */
            /* Para hacerlos más grandes: aumentar el padding vertical y el min-height */
            /* ============================================ -->

            <div class="card-body p-4">
                <!-- 4 CUADROS DE FACTURACIÓN CENTRADOS SIN ICONOS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; justify-content: center;">
                    <!-- Cuadro 1: Facturas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Facturas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">30</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Activas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Activas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">18</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: Pagadas -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Pagadas</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">8</div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: Timbrado -->
                    <div style="flex: 0 1 calc(25% - 15px); min-width: 150px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px 20px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%; min-height: 90px; text-align: center; display: flex; flex-direction: column; justify-content: center;">
                            <div style="color: #6c757d; font-size: 14px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Timbrado</div>
                            <div style="color: #083CAE; font-size: 36px; font-weight: bold; line-height: 1.2;">30</div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas con iconos Font Awesome en azul -->
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
                        <button id="btnAgregar" style="background-color: white; border: 1px solid #083CAE; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #083CAE; font-size: 16px;">
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
            title="Agrupar columnas">
        <i class="fas fa-columns" style="color: #083CAE;"></i>
    </button>
</div>

                    <!-- Buscador -->
                    <div style="position: relative;">
                        <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #083CAE;"></i>
                        <input type="text" id="buscador" placeholder="Buscar..." style="padding: 8px 8px 8px 35px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 200px;">
                    </div>
                </div>

                <!-- ============================================ 
                TABLA DE FACTURACIÓN - AJUSTE DE ALTURA     
                /* CAMBIO DE ALTURA DE FILAS: Modificar el padding de las celdas th y td */
                /* Valores actuales: padding: 10px 4px - Aumentado de 8px a 10px */
                /* CAMBIO DE TAMAÑO DE FUENTE: font-size: 12px - Aumentado de 11px a 12px */
                /* ============================================ -->

                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 600px; overflow-y: auto; position: relative;">
                    <table class="table table-bordered table-striped" id="tablaFacturacion" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
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
                                        <span>Fecha Timbrado</span>
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
                                        <span>Folio</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Viajes</span>
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
                                        <span>Folio Carga</span>
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
                                        <span>Forma Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Método Pago</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Revisión</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Vencimiento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Moneda</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Subtotal</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>IVA</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Retención</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descuento</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Total MXN</span>
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
                                        <span>IdCCP</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Descripción Adicional</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Póliza</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Notas de Crédito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Contra-Recibo</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Ult. Depósito</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Depósitos</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factura Relacionada</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Operador</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>No. Unidad</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Ult. Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Ult. Comentario Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Observaciones</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Prog. Cobro</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Bitácora</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Factoraje</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Cuenta Flujo Dinero</span>
                                        <i class="fas fa-filter" style="font-size: 10px; cursor: pointer; opacity: 0.8; color: white;" title="Filtrar"></i>
                                    </div>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: center; background-color: #083CAE; color: white; position: sticky; top: 0;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span>Fecha Cancelación</span>
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
                        <tbody>
                            <!-- Fila 1 -->
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activa</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15 10:30</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15 10:35</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">A</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">3</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Maquiladora Industrial</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MII880101ABC</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G01</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transferencia</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PPD</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-16</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-14</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$10,000.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$1,600.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$11,600.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$11,600.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">ABC123DEF456GHI789</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Juan Pérez</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-16</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura procesada</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-01</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-001</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                        <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Fila 2 -->
                            <tr>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #ffc107; color: black; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pagada</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-14 09:15</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-14 09:20</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">B</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cartones del Norte</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CND890202XYZ</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G03</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cheque</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PUE</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-14</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-13</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$8,500.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$1,360.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$9,860.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$9,860.00</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">DEF456GHI789JKL012</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">María López</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura pagada</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-002</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
                                        <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
                                        <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
                                        <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
                                        <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Fila 3 a 10 - Mantener el mismo estilo con padding: 10px 4px y badge actualizado -->
                            <!-- ... (el resto de filas mantienen la misma estructura) ... -->
                            <!-- Fila 3 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Cancelada</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-13 14:20</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-13 14:25</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">A</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transportes del Bajío</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">TBA890123XYZ</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G02</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Efectivo</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PUE</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-13</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-14</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-12</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$5,200.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$832.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$6,032.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$6,032.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">GHI789JKL012MNO345</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Carlos Rodríguez</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-14</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura cancelada por error</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-003</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-20</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 4 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activa</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-12 11:45</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-12 11:50</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">B</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">4</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Logística Monterrey</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">LMN890456ABC</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G01</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transferencia</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PPD</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-12</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-13</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-11</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$15,300.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$2,448.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$500.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$17,248.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$17,248.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">JKL012MNO345PQR678</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Ana Martínez</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-13</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura con descuento aplicado</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-05</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-004</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 5 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #ffc107; color: black; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pagada</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-11 09:30</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-11 09:35</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">A</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Comercializadora del Sur</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CDS890123DEF</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G03</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cheque</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PUE</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-11</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-12</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-10</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">USD</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$500.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$80.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$580.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$11,600.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">MNO345PQR678STU901</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Roberto Sánchez</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-12</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura en USD pagada</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-005</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 6 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activa</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-10 16:15</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-10 16:20</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">B</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">3</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Papelera del Pacífico</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PDP890123GHI</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G02</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transferencia</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PPD</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-10</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-11</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-09</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$12,800.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$2,048.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$14,848.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$14,848.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">PQR678STU901VWX234</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Laura Gómez</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-11</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura procesada correctamente</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-08</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-006</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 7 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #ffc107; color: black; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Pagada</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-09 13:40</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-09 13:45</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">A</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Ferrocarriles Nacionales</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">FCN890123JKL</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G01</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Efectivo</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PUE</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-09</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-10</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-08</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$7,200.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$1,152.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$200.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$8,152.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$8,152.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">STU901VWX234YZA567</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Pedro Hernández</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-10</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura pagada con descuento</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-007</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 8 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activa</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-08 10:00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-08 10:05</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">B</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">5</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Minería del Norte</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MDN890123MNO</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G03</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transferencia</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PPD</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-08</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-09</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-07</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$22,500.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$3,600.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$26,100.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$26,100.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">VWX234YZA567BCD890</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Javier Ruiz</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-09</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura de minería procesada</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-10</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-008</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 9 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Cancelada</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-07 12:30</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-07 12:35</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">A</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Autotransportes Mexicanos</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">ATM890123PQR</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G02</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cheque</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PUE</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-07</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-08</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-06</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$9,800.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$1,568.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$11,368.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$11,368.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">YZA567BCD890EFG123</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Sofía Castro</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-08</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cancelada por error en datos</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-009</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-15</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr>

<!-- Fila 10 -->
<tr>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;"><span class="badge" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px;">Activa</span></td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-06 15:45</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-06 15:50</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">B</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">1010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">3</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Cervecería del Centro</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CDC890123STU</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CAR-2026-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">G01</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Transferencia</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">PPD</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-06</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-07</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-05</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">MXN</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$18,200.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$2,912.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$0.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$21,112.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; text-align: right;">$21,112.00</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; font-size: 10px;">BCD890EFG123HIJ456</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CCP-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">POL-2026-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CR-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Miguel Ángel Torres</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">U-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-01-07</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">Factura de cervecería procesada</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">2026-02-15</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">BIT-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">CFD-010</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px;">-</td>
    <td style="border: 1px solid #dee2e6; padding: 10px 4px; background-color: white; position: sticky; right: 0; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">
        <div style="display: flex; gap: 8px; justify-content: center;">
            <i class="fas fa-edit" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Editar"></i>
            <i class="fas fa-trash-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Eliminar"></i>
            <i class="fas fa-file-alt" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="Documentar"></i>
            <i class="fas fa-file-pdf" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="PDF"></i>
            <i class="fas fa-file-code" style="color: #083CAE; cursor: pointer; font-size: 14px;" title="XML"></i>
        </div>
    </td>
</tr> 

                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 15px; gap: 5px;">
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Primera página"><i class="fas fa-angle-double-left"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Página anterior"><i class="fas fa-angle-left"></i></button>
                    <span style="padding: 5px 10px; background-color: #083CAE; color: white; border-radius: 4px;">1</span>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;">2</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;">3</button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Página siguiente"><i class="fas fa-angle-right"></i></button>
                    <button style="padding: 5px 10px; border: 1px solid #dee2e6; background-color: white; border-radius: 4px; cursor: pointer; color: #083CAE;" title="Última página"><i class="fas fa-angle-double-right"></i></button>
                    <span style="margin-left: 10px; color: #6c757d;">Mostrando 1-10 de 30 facturas</span>
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
    
    /* ============================================ */
    /* ESTILOS DE TABLA - AJUSTES DE ALTURA Y FUENTE */
    /* ============================================ */
    
    /* Ajuste de altura de filas - modificar padding de th y td */
    .table th {
        white-space: nowrap;
        font-size: 12px; /* Tamaño de fuente de encabezados - Aumentado de 11px a 12px */
        background-color: #083CAE !important;
        color: white;
        font-weight: 600;
        padding: 10px 4px; /* Padding vertical: 10px, horizontal: 4px - Aumentado de 8px a 10px */
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px; /* Tamaño de fuente de celdas - Aumentado de 11px a 12px */
        padding: 10px 4px; /* Padding vertical: 10px, horizontal: 4px - Aumentado de 8px a 10px */
    }
    
    /* Estilo para los iconos de acción */
    .table td i {
        transition: transform 0.2s;
        font-size: 14px;
        color: #083CAE;
    }
    
    .table td i:hover {
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
    .table td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }
    
    /* Botones de paginación */
    .pagination button {
        color: #083CAE;
    }
    
    .pagination button:hover {
        background-color: #e9ecef;
    }
    
    /* Badges de estatus - Ajustados para mejor legibilidad */
    .badge {
        font-size: 11px; /* Aumentado de 10px a 11px */
        font-weight: 600;
        padding: 4px 8px; /* Aumentado para badges más grandes */
        display: inline-block;
        border-radius: 3px;
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

     table tr:nth-child(odd) {
            background-color: #ffffff; /* Blanco para filas impares */
        }
        
        table tr:nth-child(even) {
            background-color: #f2f2f2; /* Gris claro para filas pares */
        }
        
        /* Opcional: efecto hover */
        table tr:hover {
            background-color: #e0e0e0; /* Gris más oscuro al pasar el mouse */
        }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado - Facturación');
        
        // Date Inicio
        document.getElementById('fechaInicio')?.addEventListener('change', function() {
            console.log('Fecha inicio:', this.value);
        });
        
        // Date Fin
        document.getElementById('fechaFin')?.addEventListener('change', function() {
            console.log('Fecha fin:', this.value);
        });
        
        // Botón Agregar
        document.getElementById('btnAgregar')?.addEventListener('click', function() {
            alert('Funcionalidad de Agregar - En desarrollo');
        });
        
        // Botón Exportar Excel
        document.getElementById('btnExcel')?.addEventListener('click', function() {
            exportTableToExcel('tablaFacturacion', 'Facturacion');
        });
        
        // Botón Seleccionar Columnas
        document.getElementById('btnColumnas')?.addEventListener('click', function() {
            alert('Selector de Columnas - En desarrollo');
        });
        
        // Buscador
        document.getElementById('buscador')?.addEventListener('input', function() {
            console.log('Buscando:', this.value);
        });
        
        // Iconos de filtro en encabezados
        document.querySelectorAll('.table th i.fa-filter').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Filtro de columna - En desarrollo');
            });
        });
        
        // Acciones de los iconos
        document.querySelectorAll('.fa-edit').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Editar factura - En desarrollo');
            });
        });
        
        document.querySelectorAll('.fa-trash-alt').forEach(icon => {
            icon.addEventListener('click', function() {
                if(confirm('¿Está seguro de eliminar esta factura?')) {
                    alert('Eliminar factura - En desarrollo');
                }
            });
        });
        
        document.querySelectorAll('.fa-file-alt').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Documentar factura - En desarrollo');
            });
        });
        
        document.querySelectorAll('.fa-file-pdf').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Descargar PDF - En desarrollo');
            });
        });
        
        document.querySelectorAll('.fa-file-code').forEach(icon => {
            icon.addEventListener('click', function() {
                alert('Descargar XML - En desarrollo');
            });
        });
        
        // Paginación
        document.querySelectorAll('.pagination button, div[style*="justify-content: flex-end"] button').forEach(btn => {
            btn.addEventListener('click', function() {
                if(!this.classList.contains('active') && !this.closest('span')) {
                    alert('Cambiar de página - En desarrollo');
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