@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Proveedores -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Proveedores
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                    <!-- Grupo de agrupación (izquierda) -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacion">
                        <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                        <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgrupar">arrastra una columna aquí para agrupar</span>
                        <div id="grupoColumnas" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                    </div>
                    
                    <!-- Grupo derecho: filtros y botones -->
                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <!-- Filtros de fecha -->
                        <div>
                            <input type="date" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-01') }}" placeholder="Fecha Inicio">
                        </div>
                        <div>
                            <input type="date" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-size: 12px; width: 140px;" value="{{ date('Y-m-d') }}" placeholder="Fecha Fin">
                        </div>
                        
                        <!-- Botón Agregar (+) -->
                        <div>
                            <button id="btnAgregar" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                    title="Agregar proveedor"
                                    onclick="abrirModalProveedor()">
                                <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                            </button>
                        </div>

                        <!-- Botón Exportar Excel -->
                        <div>
                            <button id="btnExcel" 
                                    style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
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
                            <div id="columnSelector" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                    <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                    <button onclick="cerrarColumnSelector()" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                </div>
                                <div id="columnasLista" style="padding: 10px;"></div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div style="position: relative; min-width: 200px;">
                            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                            <input type="text" id="buscador" placeholder="Buscar proveedor..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                        </div>
                    </div>
                </div>

                <!-- Tabla de Proveedores -->
                <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                    <table class="table" id="tablaProveedores" style="width: 100%; border-collapse: collapse; font-size: 11px; min-width: 2500px;">
                        <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                            <tr>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="folio">Folio</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="estatus">Estatus</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="fecha_alta">Fecha Alta</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="alias">Alias</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="razon_social">Razón Social</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="rfc">RFC</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="regimen_fiscal">Régimen Fiscal</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="calle">Calle</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="num_ext">Núm. Ext</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="num_int">Núm. Int</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="codigo_postal">C.P.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="limite_credito">Límite Crédito</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="credito">Crédito</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="forma_pago">Forma Pago</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="metodo_pago">Método Pago</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="uso_cfdi">Uso CFDI</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="banco">Banco</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cuenta_banco">Cuenta Banco</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cuenta_secundaria">Cuenta Contable Sec.</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center;" draggable="true" data-columna="cuenta_resultado">Cuenta Edo. Resultado</th>
                                <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1);">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-001</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CEMEX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">CEMEX México S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CEM850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Av. Constitución</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">123</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66220</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$500,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$250,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en una sola exhibición</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Transferencia</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">BBVA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">0123456789</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-01</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-02</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-01</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-001')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-001')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-002</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">10/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grupo Acerero</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Grupo Acerero del Norte S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">GAN850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Av. Industrias</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">456</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">A</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66230</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$750,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$300,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en una sola exhibición</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Transferencia</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Santander</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">9876543210</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-02</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-03</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-02</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-002')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-002')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-003</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">05/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Ferrecarril</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Ferrecarril del Golfo S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">FEG850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Av. del Ferrocarril</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">789</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66240</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$300,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$120,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en una sola exhibición</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Cheque</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Banamex</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">1122334455</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-03</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-03</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-003')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-003')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-004</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">02/01/2025</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora Norte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Constructora del Norte S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">CON850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Blvd. de las Naciones</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">101</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">B</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66250</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$1,000,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$450,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en parcialidades</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Transferencia</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">BBVA</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5566778899</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-05</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-04</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-004')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-004')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-005</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Inactivo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">20/12/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales MTY</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Materiales Monterrey S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">MAT850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Av. de los Materiales</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">202</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">—</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66260</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$200,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$0</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en una sola exhibición</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Efectivo</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Banorte</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">9988776655</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-05</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-06</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-05</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: white; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-005')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-005')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                    <i class="fas fa-redo-alt" style="color: #ffc107; margin: 0 5px; cursor: pointer;" onclick="alert('Reactivar proveedor')" title="Reactivar"></i>
                                </td>
                            </tr>
                            <tr style="background-color: #f8f9fa;">
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center; font-weight: 500;">PROV-006</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">
                                    <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 3px; font-size: 10px; display: inline-block; min-width: 70px;">Activo</span>
                                </td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">15/12/2024</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Pinturas Comex</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Pinturas Comex S.A. de C.V.</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">PCO850101XXX</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">General de Ley</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Av. de las Pinturas</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">303</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">C</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">66270</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$400,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: right;">$180,000</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Pago en una sola exhibición</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">Transferencia</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">G01 - Adquisición de mercancías</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: left;">Santander</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">4433221100</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-06</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">2010-07</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; text-align: center;">5010-06</td>
                                <td style="padding: 10px 8px; border: 1px solid #dee2e6; position: sticky; right: 0; background-color: #f8f9fa; box-shadow: -2px 0 5px rgba(0,0,0,0.1); text-align: center;">
                                    <i class="fas fa-eye" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="alert('Ver detalle PROV-006')" title="Ver detalle"></i>
                                    <i class="fas fa-edit" style="color: var(--color-primary); margin: 0 5px; cursor: pointer;" onclick="editarProveedor('PROV-006')" title="Editar"></i>
                                    <i class="fas fa-trash" style="color: #dc3545; margin: 0 5px; cursor: pointer;" onclick="if(confirm('¿Eliminar proveedor?')) alert('Proveedor eliminado')" title="Eliminar"></i>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="background-color: #e9ecef; font-weight: bold;">
                            <tr>
                                <td colspan="22" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;">Total Proveedores: 6</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Botón Crear filtro -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR PROVEEDOR -->
<div id="modalProveedor" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 1000px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloProveedor">Nuevo Proveedor</h3>
            <button onclick="cerrarModalProveedor()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                <!-- Columna 1 -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Folio</label>
                    <input type="text" id="modalFolio" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="PROV-007">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatus" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Fecha Alta</label>
                    <input type="date" id="modalFechaAlta" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Alias</label>
                    <input type="text" id="modalAlias" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Nombre corto">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Razón Social</label>
                    <input type="text" id="modalRazonSocial" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Razón social completa">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">RFC</label>
                    <input type="text" id="modalRFC" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="RFC">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Régimen Fiscal</label>
                    <select id="modalRegimenFiscal" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>General de Ley</option>
                        <option>Persona Física</option>
                        <option>Régimen Simplificado</option>
                        <option>Régimen de Incorporación</option>
                    </select>
                </div>
                
                <!-- Dirección -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Calle</label>
                    <input type="text" id="modalCalle" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Calle">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Núm. Exterior</label>
                    <input type="text" id="modalNumExt" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ext">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Núm. Interior</label>
                    <input type="text" id="modalNumInt" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Int">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Código Postal</label>
                    <input type="text" id="modalCP" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="C.P.">
                </div>
                
                <!-- Crédito -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Límite de Crédito</label>
                    <input type="number" id="modalLimiteCredito" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Crédito Actual</label>
                    <input type="number" id="modalCredito" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="0.00">
                </div>
                
                <!-- Pago -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Forma de Pago</label>
                    <select id="modalFormaPago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Pago en una sola exhibición</option>
                        <option>Pago en parcialidades</option>
                        <option>Pago diferido</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Método de Pago</label>
                    <select id="modalMetodoPago" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>Transferencia</option>
                        <option>Cheque</option>
                        <option>Efectivo</option>
                        <option>Tarjeta de crédito</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Uso CFDI</label>
                    <select id="modalUsoCFDI" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>G01 - Adquisición de mercancías</option>
                        <option>G02 - Devoluciones</option>
                        <option>G03 - Gastos en general</option>
                    </select>
                </div>
                
                <!-- Bancario -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Banco</label>
                    <select id="modalBanco" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option>BBVA</option>
                        <option>Santander</option>
                        <option>Banamex</option>
                        <option>Banorte</option>
                        <option>HSBC</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cuenta Banco</label>
                    <input type="text" id="modalCuentaBanco" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Número de cuenta">
                </div>
                
                <!-- Cuentas contables -->
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cuenta Contable</label>
                    <input type="text" id="modalCuentaContable" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2010-01">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cuenta Contable Sec.</label>
                    <input type="text" id="modalCuentaSecundaria" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="2010-02">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #495057; margin-bottom: 5px;">Cuenta Edo. Resultado</label>
                    <input type="text" id="modalCuentaResultado" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="5010-01">
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalProveedor()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarProveedor()" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
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
        max-height: 500px;
        overflow-y: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        scrollbar-width: thin;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .table th {
        background-color: var(--color-primary) !important;
        color: white;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 11px;
        white-space: nowrap;
        text-align: center;
        font-weight: 600;
    }
    
    .table td {
        padding: 10px 8px;
        border: 1px solid #dee2e6;
        font-size: 11px;
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
        font-size: 13px;
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
    
    .table td:last-child i.fa-redo-alt {
        color: #ffc107;
    }
    
    /* Badges de estatus */
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-inactivo {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
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
        border-radius: 4px;
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
    
    /* Scroll personalizado */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }
    
    /* Modal */
    #modalProveedor {
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
        
        .table-container {
            max-height: 400px;
        }
        
        .table td {
            padding: 8px 4px;
            font-size: 10px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 11px;
        }
        
        #modalProveedor > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalProveedor div[style*="grid-template-columns: repeat(3, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    let columnasAgrupadas = [];
    
    // Función para abrir modal de nuevo proveedor
    window.abrirModalProveedor = function() {
        document.getElementById('modalTituloProveedor').textContent = 'Nuevo Proveedor';
        document.getElementById('modalFolio').value = '';
        document.getElementById('modalEstatus').value = 'Activo';
        document.getElementById('modalFechaAlta').value = new Date().toISOString().split('T')[0];
        document.getElementById('modalAlias').value = '';
        document.getElementById('modalRazonSocial').value = '';
        document.getElementById('modalRFC').value = '';
        document.getElementById('modalRegimenFiscal').value = 'General de Ley';
        document.getElementById('modalCalle').value = '';
        document.getElementById('modalNumExt').value = '';
        document.getElementById('modalNumInt').value = '';
        document.getElementById('modalCP').value = '';
        document.getElementById('modalLimiteCredito').value = '';
        document.getElementById('modalCredito').value = '';
        document.getElementById('modalFormaPago').value = 'Pago en una sola exhibición';
        document.getElementById('modalMetodoPago').value = 'Transferencia';
        document.getElementById('modalUsoCFDI').value = 'G01 - Adquisición de mercancías';
        document.getElementById('modalBanco').value = 'BBVA';
        document.getElementById('modalCuentaBanco').value = '';
        document.getElementById('modalCuentaContable').value = '';
        document.getElementById('modalCuentaSecundaria').value = '';
        document.getElementById('modalCuentaResultado').value = '';
        document.getElementById('modalProveedor').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    // Función para editar proveedor
    window.editarProveedor = function(folio) {
        document.getElementById('modalTituloProveedor').textContent = 'Editar Proveedor ' + folio;
        
        // Simular carga de datos según el folio
        if (folio === 'PROV-001') {
            document.getElementById('modalFolio').value = 'PROV-001';
            document.getElementById('modalEstatus').value = 'Activo';
            document.getElementById('modalFechaAlta').value = '2025-01-15';
            document.getElementById('modalAlias').value = 'CEMEX';
            document.getElementById('modalRazonSocial').value = 'CEMEX México S.A. de C.V.';
            document.getElementById('modalRFC').value = 'CEM850101XXX';
            document.getElementById('modalRegimenFiscal').value = 'General de Ley';
            document.getElementById('modalCalle').value = 'Av. Constitución';
            document.getElementById('modalNumExt').value = '123';
            document.getElementById('modalNumInt').value = '';
            document.getElementById('modalCP').value = '66220';
            document.getElementById('modalLimiteCredito').value = '500000';
            document.getElementById('modalCredito').value = '250000';
            document.getElementById('modalFormaPago').value = 'Pago en una sola exhibición';
            document.getElementById('modalMetodoPago').value = 'Transferencia';
            document.getElementById('modalUsoCFDI').value = 'G01 - Adquisición de mercancías';
            document.getElementById('modalBanco').value = 'BBVA';
            document.getElementById('modalCuentaBanco').value = '0123456789';
            document.getElementById('modalCuentaContable').value = '2010-01';
            document.getElementById('modalCuentaSecundaria').value = '2010-02';
            document.getElementById('modalCuentaResultado').value = '5010-01';
        } else if (folio === 'PROV-005') {
            document.getElementById('modalFolio').value = 'PROV-005';
            document.getElementById('modalEstatus').value = 'Inactivo';
            document.getElementById('modalFechaAlta').value = '2024-12-20';
            document.getElementById('modalAlias').value = 'Materiales MTY';
            document.getElementById('modalRazonSocial').value = 'Materiales Monterrey S.A. de C.V.';
            document.getElementById('modalRFC').value = 'MAT850101XXX';
            document.getElementById('modalRegimenFiscal').value = 'General de Ley';
            document.getElementById('modalCalle').value = 'Av. de los Materiales';
            document.getElementById('modalNumExt').value = '202';
            document.getElementById('modalNumInt').value = '';
            document.getElementById('modalCP').value = '66260';
            document.getElementById('modalLimiteCredito').value = '200000';
            document.getElementById('modalCredito').value = '0';
            document.getElementById('modalFormaPago').value = 'Pago en una sola exhibición';
            document.getElementById('modalMetodoPago').value = 'Efectivo';
            document.getElementById('modalUsoCFDI').value = 'G01 - Adquisición de mercancías';
            document.getElementById('modalBanco').value = 'Banorte';
            document.getElementById('modalCuentaBanco').value = '9988776655';
            document.getElementById('modalCuentaContable').value = '2010-05';
            document.getElementById('modalCuentaSecundaria').value = '2010-06';
            document.getElementById('modalCuentaResultado').value = '5010-05';
        } else {
            document.getElementById('modalFolio').value = folio;
            document.getElementById('modalEstatus').value = 'Activo';
            document.getElementById('modalFechaAlta').value = '2025-01-01';
            document.getElementById('modalAlias').value = 'Alias de ejemplo';
            document.getElementById('modalRazonSocial').value = 'Razón social de ejemplo S.A. de C.V.';
            document.getElementById('modalRFC').value = 'RFC123456XXX';
            document.getElementById('modalRegimenFiscal').value = 'General de Ley';
            document.getElementById('modalCalle').value = 'Calle de ejemplo';
            document.getElementById('modalNumExt').value = '123';
            document.getElementById('modalNumInt').value = '';
            document.getElementById('modalCP').value = '66000';
            document.getElementById('modalLimiteCredito').value = '300000';
            document.getElementById('modalCredito').value = '100000';
            document.getElementById('modalFormaPago').value = 'Pago en una sola exhibición';
            document.getElementById('modalMetodoPago').value = 'Transferencia';
            document.getElementById('modalUsoCFDI').value = 'G01 - Adquisición de mercancías';
            document.getElementById('modalBanco').value = 'BBVA';
            document.getElementById('modalCuentaBanco').value = '123456789';
            document.getElementById('modalCuentaContable').value = '2010-00';
            document.getElementById('modalCuentaSecundaria').value = '2010-01';
            document.getElementById('modalCuentaResultado').value = '5010-00';
        }
        
        document.getElementById('modalProveedor').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    
    window.cerrarModalProveedor = function() {
        document.getElementById('modalProveedor').style.display = 'none';
        document.body.style.overflow = 'auto';
    };
    
    window.guardarProveedor = function() {
        const folio = document.getElementById('modalFolio').value;
        const alias = document.getElementById('modalAlias').value;
        
        if (!folio || !alias) {
            alert('Por favor complete los campos obligatorios');
            return;
        }
        
        alert(`Proveedor ${folio} guardado correctamente`);
        cerrarModalProveedor();
    };
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalProveedor();
        }
    });
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalProveedor').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalProveedor();
        }
    });
    
    // Funciones de agrupación y selector de columnas
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
                chip.innerHTML = `${col} <span class="remover" onclick="removerColumna('${col}')">&times;</span>`;
                container.appendChild(chip);
            });
        }
    }

    window.removerColumna = function(columna) {
        columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
        actualizarGrupoColumnas();
    };

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
            alert('Agrupando por: ' + columna);
        }
    });

    // Selector de columnas
    window.toggleColumnSelector = function() {
        const selector = document.getElementById('columnSelector');
        selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
        
        if (selector.style.display === 'block') {
            const columnas = [
                { field: 'folio', caption: 'Folio' },
                { field: 'estatus', caption: 'Estatus' },
                { field: 'fecha_alta', caption: 'Fecha Alta' },
                { field: 'alias', caption: 'Alias' },
                { field: 'razon_social', caption: 'Razón Social' },
                { field: 'rfc', caption: 'RFC' },
                { field: 'regimen_fiscal', caption: 'Régimen Fiscal' },
                { field: 'calle', caption: 'Calle' },
                { field: 'num_ext', caption: 'Núm. Ext' },
                { field: 'num_int', caption: 'Núm. Int' },
                { field: 'codigo_postal', caption: 'C.P.' },
                { field: 'limite_credito', caption: 'Límite Crédito' },
                { field: 'credito', caption: 'Crédito' },
                { field: 'forma_pago', caption: 'Forma Pago' },
                { field: 'metodo_pago', caption: 'Método Pago' },
                { field: 'uso_cfdi', caption: 'Uso CFDI' },
                { field: 'banco', caption: 'Banco' },
                { field: 'cuenta_banco', caption: 'Cuenta Banco' },
                { field: 'cuenta_contable', caption: 'Cuenta Contable' },
                { field: 'cuenta_secundaria', caption: 'Cuenta Secundaria' },
                { field: 'cuenta_resultado', caption: 'Cuenta Resultado' }
            ];
            
            const lista = document.getElementById('columnasLista');
            lista.innerHTML = columnas.map(col => `
                <div style="padding: 5px 0; display: flex; align-items: center;">
                    <input type="checkbox" 
                           id="chk_${col.field}"
                           data-columna="${col.field}"
                           checked
                           style="margin-right: 8px; accent-color: var(--color-primary);">
                    <label for="chk_${col.field}" style="font-size: 11px;">${col.caption}</label>
                </div>
            `).join('');
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
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcel').addEventListener('click', () => alert('Exportar proveedores a Excel'));

    // Buscador
    document.getElementById('buscador').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        console.log('Buscando en proveedores:', termino);
    });
});
</script>
@endsection