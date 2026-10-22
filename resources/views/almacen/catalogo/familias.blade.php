@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Familias y Subfamilias -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid var(--color-primary); padding: 15px 20px;">
                <h2 style="color: var(--color-primary); font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    <i class="fas fa-sitemap" style="margin-right: 10px;"></i> Familias y Subfamilias
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Pestañas de navegación -->
                <div style="display: flex; border-bottom: 2px solid #dee2e6; margin-bottom: 20px;">
                    <button class="tab-familia active" onclick="switchTab('familias')" id="tabFamilias" style="background-color: var(--color-primary); color: white; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; margin-right: 5px; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-folder"></i> Familias
                    </button>
                    <button class="tab-subfamilia" onclick="switchTab('subfamilias')" id="tabSubfamilias" style="background-color: #e9ecef; color: #495057; border: none; padding: 10px 25px; border-radius: 8px 8px 0 0; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-folder-open"></i> Subfamilias
                    </button>
                </div>

                <!-- Panel de Familias -->
                <div id="panelFamilias" style="display: block;">
                    <!-- Barra de herramientas para Familias -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación (izquierda) -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionFamilias">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparFamilias">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasFamilias" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Grupo derecho: botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarFamilia" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar familia"
                                        onclick="abrirModalFamilia()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelFamilias" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasFamilias" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('familias')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Familias -->
                                <div id="columnSelectorFamilias" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 280px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('familias')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaFamilias" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 200px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorFamilias" placeholder="Buscar familia..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Familias -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaFamilias" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 800px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="n_familia">N° Familia</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 20%;" draggable="true" data-columna="tipo">Tipo</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 35%;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyFamilias">
                                <tr><td colspan="6" style="text-align: center; padding: 20px;">Cargando...</td></tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="6" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;" id="totalFamilias">Total Familias: 0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Panel de Subfamilias -->
                <div id="panelSubfamilias" style="display: none;">
                    <!-- Barra de herramientas para Subfamilias -->
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                        <!-- Grupo de agrupación (izquierda) -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;" id="grupoAgrupacionSubfamilias">
                            <i class="fas fa-layer-group" style="color: var(--color-primary); font-size: 14px; cursor: pointer;" title="Arrastrar columnas para agrupar"></i>
                            <span style="color: #6c757d; font-size: 12px; font-style: italic;" id="textoAgruparSubfamilias">arrastra una columna aquí para agrupar</span>
                            <div id="grupoColumnasSubfamilias" style="display: flex; gap: 5px; flex-wrap: wrap;"></div>
                        </div>
                        
                        <!-- Grupo derecho: botones -->
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Botón Agregar (+) -->
                            <div>
                                <button id="btnAgregarSubfamilia" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--color-primary); font-size: 16px;" 
                                        title="Agregar subfamilia"
                                        onclick="abrirModalSubfamilia()">
                                    <i class="fas fa-plus" style="color: var(--color-primary);"></i>
                                </button>
                            </div>

                            <!-- Botón Exportar Excel -->
                            <div>
                                <button id="btnExcelSubfamilias" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);">
                                    <i class="fas fa-file-excel" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Excel</span>
                                </button>
                            </div>

                            <!-- Botón Seleccionar Columnas -->
                            <div style="position: relative;">
                                <button id="btnColumnasSubfamilias" 
                                        style="background-color: white; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 5px; color: var(--color-primary);"
                                        onclick="toggleColumnSelector('subfamilias')">
                                    <i class="fas fa-columns" style="color: var(--color-primary);"></i>
                                    <span class="hide-mobile">Columnas</span>
                                </button>
                                
                                <!-- Selector de columnas para Subfamilias -->
                                <div id="columnSelectorSubfamilias" style="display: none; position: absolute; right: 0; top: 40px; background-color: white; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 9999; min-width: 300px; max-height: 400px; overflow-y: auto;">
                                    <div style="padding: 10px; border-bottom: 1px solid #dee2e6; background-color: #f8f9fa; display: flex; justify-content: space-between;">
                                        <strong style="color: var(--color-primary); font-size: 13px;">Seleccionar Columnas</strong>
                                        <button onclick="cerrarColumnSelector('subfamilias')" style="border: none; background: none; cursor: pointer; font-size: 16px;">✕</button>
                                    </div>
                                    <div id="columnasListaSubfamilias" style="padding: 10px;"></div>
                                </div>
                            </div>

                            <!-- Buscador -->
                            <div style="position: relative; min-width: 200px;">
                                <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-primary); font-size: 12px;"></i>
                                <input type="text" id="buscadorSubfamilias" placeholder="Buscar subfamilia..." style="width: 100%; padding: 8px 8px 8px 30px; border: 1px solid var(--color-primary); border-radius: 4px; font-size: 13px;">
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Subfamilias -->
                    <div class="table-container" style="border: 1px solid #dee2e6; border-radius: 4px; overflow-x: auto; background-color: white; width: 100%;">
                        <table class="table" id="tablaSubfamilias" style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1000px;">
                            <thead style="background-color: var(--color-primary); position: sticky; top: 0; z-index: 20;">
                                <tr>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 8%;" draggable="true" data-columna="estatus">Estatus</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 12%;" draggable="true" data-columna="n_subfamilia">N° Subfamilia</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 15%;" draggable="true" data-columna="familia">Familia</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 20%;" draggable="true" data-columna="tipo_subfamilia">Tipo Subfamilia</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 25%;" draggable="true" data-columna="descripcion">Descripción</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; width: 10%;" draggable="true" data-columna="cuenta_contable">Cuenta Contable</th>
                                    <th style="padding: 12px 8px; border: 1px solid #dee2e6; background-color: var(--color-primary); color: white; text-align: center; position: sticky; right: 0; z-index: 30; box-shadow: -2px 0 5px rgba(0,0,0,0.1); width: 10%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodySubfamilias">
                                <tr><td colspan="7" style="text-align: center; padding: 20px;">Cargando...</td></tr>
                            </tbody>
                            <tfoot style="background-color: #e9ecef; font-weight: bold;">
                                <tr>
                                    <td colspan="7" style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 13px;" id="totalSubfamilias">Total Subfamilias: 0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Botón Crear filtro (común para ambas pestañas) -->
                <div style="margin-top: 15px; display: flex; justify-content: flex-start;">
                    <button id="btnCrearFiltro" style="background: transparent; border: 1px solid var(--color-primary); border-radius: 4px; padding: 8px 25px; cursor: pointer; color: var(--color-primary); font-size: 13px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Crear filtro
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR/EDITAR FAMILIA -->
<div id="modalFamilia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloFamilia">Nueva Familia</h3>
            <button onclick="cerrarModalFamilia()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <input type="hidden" id="modalIdFamilia">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">N° Familia</label>
                    <input type="text" id="modalNumeroFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;" placeholder="Autogenerado" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Nombre / Tipo <span style="color: red;">*</span></label>
                    <input type="text" id="modalTipoFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Herramientas">
                </div>
                {{-- ✅ Cuenta Contable ahora es SELECT --}}
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cuenta Contable</label>
                    <select id="modalCuentaFamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar cuenta contable</option>
                        @isset($cuentasContables)
                            @foreach($cuentasContables as $codigoCuenta => $nombreCuenta)
                                <option value="{{ $codigoCuenta }}">{{ $nombreCuenta }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <textarea id="modalDescripcionFamilia" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción de la familia..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalFamilia()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarFamilia()" id="btnGuardarFamilia" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA AGREGAR/EDITAR SUBFAMILIA -->
<div id="modalSubfamilia" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100000; align-items: center; justify-content: center;">
    <div style="background-color: white; border-radius: 8px; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; position: relative; animation: slideIn 0.3s ease;">
        
        <!-- Header -->
        <div style="background: var(--color-primary); padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="color: white; margin: 0; font-size: 18px;" id="modalTituloSubfamilia">Nueva Subfamilia</h3>
            <button onclick="cerrarModalSubfamilia()" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">✕</button>
        </div>
        
        <!-- Formulario -->
        <div style="padding: 20px;">
            <input type="hidden" id="modalIdSubfamilia">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Estatus</label>
                    <select id="modalEstatusSubfamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">N° Subfamilia</label>
                    <input type="text" id="modalNumeroSubfamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; background-color: #e9ecef;" placeholder="Autogenerado" readonly>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Familia <span style="color: red;">*</span></label>
                    <select id="modalFamiliaSubfamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar familia</option>
                        @isset($familias)
                            @foreach($familias as $familia)
                                <option value="{{ $familia->id }}">{{ $familia->codigo }} - {{ $familia->nombre }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Nombre / Tipo <span style="color: red;">*</span></label>
                    <input type="text" id="modalTipoSubfamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Ej: Eléctricas">
                </div>
                {{-- ✅ Cuenta Contable ahora es SELECT --}}
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Cuenta Contable</label>
                    <select id="modalCuentaSubfamilia" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                        <option value="">Seleccionar cuenta contable</option>
                        @isset($cuentasContables)
                            @foreach($cuentasContables as $codigoCuenta => $nombreCuenta)
                                <option value="{{ $codigoCuenta }}">{{ $nombreCuenta }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <textarea id="modalDescripcionSubfamilia" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" placeholder="Descripción de la subfamilia..."></textarea>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button onclick="cerrarModalSubfamilia()" style="padding: 8px 20px; border: 1px solid #ced4da; border-radius: 4px; background: white; cursor: pointer;">Cancelar</button>
                <button onclick="guardarSubfamilia()" id="btnGuardarSubfamilia" style="padding: 8px 20px; border: none; border-radius: 4px; background: var(--color-primary); color: white; cursor: pointer;">Guardar</button>
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
    
    /* Pestañas */
    .tab-familia, .tab-subfamilia {
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .tab-familia:hover, .tab-subfamilia:hover {
        opacity: 0.9;
        transform: translateY(-1px);
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
        font-size: 12px;
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
        font-size: 12px;
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
    .badge-activo {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    
    .badge-inactivo {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 11px;
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
    #modalFamilia, #modalSubfamilia {
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
            font-size: 11px;
        }
        
        .table td:last-child i {
            margin: 0 3px;
            font-size: 12px;
        }
        
        .tab-familia, .tab-subfamilia {
            padding: 8px 15px !important;
            font-size: 13px;
        }
        
        #modalFamilia > div, #modalSubfamilia > div {
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        #modalFamilia div[style*="grid-template-columns: repeat(2, 1fr)"],
        #modalSubfamilia div[style*="grid-template-columns: repeat(2, 1fr)"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Estado global
let editingFamiliaId = null;
let editingSubfamiliaId = null;
let columnasAgrupadasFamilias = [];
let columnasAgrupadasSubfamilias = [];

document.addEventListener('DOMContentLoaded', function() {
    cargarFamilias();
    cargarSubfamilias();
    configurarEventos();
});

// =========================================
// CARGA DE DATOS
// =========================================

function cargarFamilias() {
    fetch(`{{ route('almacen.api.familias') }}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                renderizarTablaFamilias(res.data);
                document.getElementById('totalFamilias').textContent = `Total Familias: ${res.total}`;
            }
        })
        .catch(error => console.error('Error al cargar familias:', error));
}

function cargarSubfamilias() {
    fetch(`{{ route('almacen.api.subfamilias') }}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                renderizarTablaSubfamilias(res.data);
                document.getElementById('totalSubfamilias').textContent = `Total Subfamilias: ${res.total}`;
            }
        })
        .catch(error => console.error('Error al cargar subfamilias:', error));
}

function renderizarTablaFamilias(data) {
    const tbody = document.getElementById('tablaBodyFamilias');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No hay familias registradas</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const estatusBadge = item.estatus === 'Activo' 
            ? '<span class="badge-activo">Activo</span>' 
            : '<span class="badge-inactivo">Inactivo</span>';
        
        const row = document.createElement('tr');
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        row.innerHTML = `
            <td style="text-align: center;">${estatusBadge}</td>
            <td style="text-align: center; font-weight: 500;">${escapeHtml(item.codigo)}</td>
            <td style="text-align: left;">${escapeHtml(item.nombre)}</td>
            <td style="text-align: left;">${escapeHtml(item.descripcion) || '---'}</td>
            <td style="text-align: center;">${escapeHtml(item.cuenta_contable) || '---'}</td>
            <td style="text-align: center;">
                <i class="fas fa-eye" style="color: var(--color-primary); cursor: pointer;" onclick="verFamilia(${item.id})" title="Ver detalle"></i>
                <i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;" onclick="editarFamilia(${item.id})" title="Editar"></i>
                <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;" onclick="eliminarFamilia(${item.id}, '${escapeHtml(item.codigo)}')" title="Eliminar"></i>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarTablaSubfamilias(data) {
    const tbody = document.getElementById('tablaBodySubfamilias');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;">No hay subfamilias registradas</td></tr>';
        return;
    }
    
    tbody.innerHTML = '';
    data.forEach((item, index) => {
        const estatusBadge = item.estatus === 'Activo' 
            ? '<span class="badge-activo">Activo</span>' 
            : '<span class="badge-inactivo">Inactivo</span>';
        
        const row = document.createElement('tr');
        row.style.backgroundColor = index % 2 === 1 ? '#f8f9fa' : 'white';
        row.innerHTML = `
            <td style="text-align: center;">${estatusBadge}</td>
            <td style="text-align: center; font-weight: 500;">${escapeHtml(item.codigo)}</td>
            <td style="text-align: left;">${escapeHtml(item.familia_codigo)} - ${escapeHtml(item.familia_nombre)}</td>
            <td style="text-align: left;">${escapeHtml(item.nombre)}</td>
            <td style="text-align: left;">${escapeHtml(item.descripcion) || '---'}</td>
            <td style="text-align: center;">${escapeHtml(item.cuenta_contable) || '---'}</td>
            <td style="text-align: center;">
                <i class="fas fa-eye" style="color: var(--color-primary); cursor: pointer;" onclick="verSubfamilia(${item.id})" title="Ver detalle"></i>
                <i class="fas fa-edit" style="color: var(--color-primary); cursor: pointer;" onclick="editarSubfamilia(${item.id})" title="Editar"></i>
                <i class="fas fa-trash" style="color: #dc3545; cursor: pointer;" onclick="eliminarSubfamilia(${item.id}, '${escapeHtml(item.codigo)}')" title="Eliminar"></i>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// =========================================
// HELPER: Cuenta contable en select
// =========================================

/**
 * Asigna el valor al select de cuenta contable.
 * Si el valor no existe en las opciones (valor histórico), lo agrega dinámicamente.
 */
function setCuentaContableSelect(selectId, valor) {
    const sel = document.getElementById(selectId);
    if (!sel) return;
    
    const valorStr = (valor || '').toString();
    
    // Si el valor no está en las opciones, agregarlo (histórico)
    if (valorStr && !Array.from(sel.options).some(o => o.value === valorStr)) {
        const opt = document.createElement('option');
        opt.value = valorStr;
        opt.textContent = valorStr + ' (histórico)';
        sel.appendChild(opt);
    }
    
    sel.value = valorStr;
}

// =========================================
// PESTAÑAS
// =========================================

window.switchTab = function(tab) {
    if (tab === 'familias') {
        document.getElementById('panelFamilias').style.display = 'block';
        document.getElementById('panelSubfamilias').style.display = 'none';
        document.getElementById('tabFamilias').style.backgroundColor = 'var(--color-primary)';
        document.getElementById('tabFamilias').style.color = 'white';
        document.getElementById('tabSubfamilias').style.backgroundColor = '#e9ecef';
        document.getElementById('tabSubfamilias').style.color = '#495057';
    } else {
        document.getElementById('panelFamilias').style.display = 'none';
        document.getElementById('panelSubfamilias').style.display = 'block';
        document.getElementById('tabSubfamilias').style.backgroundColor = 'var(--color-primary)';
        document.getElementById('tabSubfamilias').style.color = 'white';
        document.getElementById('tabFamilias').style.backgroundColor = '#e9ecef';
        document.getElementById('tabFamilias').style.color = '#495057';
    }
};

// =========================================
// FAMILIAS: CRUD
// =========================================

window.abrirModalFamilia = function() {
    editingFamiliaId = null;
    document.getElementById('modalTituloFamilia').textContent = 'Nueva Familia';
    document.getElementById('modalIdFamilia').value = '';
    document.getElementById('modalEstatusFamilia').value = 'Activo';
    document.getElementById('modalNumeroFamilia').value = 'Autogenerado';
    document.getElementById('modalTipoFamilia').value = '';
    document.getElementById('modalDescripcionFamilia').value = '';
    // ✅ Reset del select de cuenta contable
    document.getElementById('modalCuentaFamilia').value = '';
    
    document.getElementById('modalFamilia').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.editarFamilia = function(id) {
    fetch(`{{ route('almacen.api.familias') }}/${id}`)
        .catch(() => {
            // Si no tienes endpoint show para familia, usa la lista
            return fetch(`{{ route('almacen.api.familias') }}`)
                .then(res => res.json())
                .then(res => {
                    const familia = res.data.find(f => f.id === id);
                    return { success: true, data: familia };
                });
        })
        .then(res => {
            if (res && res.success && res.data) {
                const familia = res.data;
                editingFamiliaId = familia.id;
                document.getElementById('modalTituloFamilia').textContent = `Editar Familia ${familia.codigo}`;
                document.getElementById('modalIdFamilia').value = familia.id;
                document.getElementById('modalEstatusFamilia').value = familia.estatus;
                document.getElementById('modalNumeroFamilia').value = familia.codigo;
                document.getElementById('modalTipoFamilia').value = familia.nombre;
                document.getElementById('modalDescripcionFamilia').value = familia.descripcion || '';
                // ✅ Asignar valor al select con fallback
                setCuentaContableSelect('modalCuentaFamilia', familia.cuenta_contable);
                
                document.getElementById('modalFamilia').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => console.error('Error al cargar familia:', error));
};

window.guardarFamilia = function() {
    const nombre = document.getElementById('modalTipoFamilia').value.trim();
    
    if (!nombre) {
        alert('El nombre de la familia es obligatorio');
        return;
    }
    
    const btnGuardar = document.getElementById('btnGuardarFamilia');
    const textoOriginal = btnGuardar.textContent;
    btnGuardar.disabled = true;
    btnGuardar.textContent = 'Guardando...';
    
    const data = {
        nombre: nombre,
        descripcion: document.getElementById('modalDescripcionFamilia').value,
        cuenta_contable: document.getElementById('modalCuentaFamilia').value,
        estatus: document.getElementById('modalEstatusFamilia').value
    };
    
    const url = editingFamiliaId 
        ? `{{ route('almacen.api.familias.update', '') }}/${editingFamiliaId}` 
        : `{{ route('almacen.api.familias.store') }}`;
    const method = editingFamiliaId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json().then(json => ({ status: res.status, body: json })))
    .then(({ status, body }) => {
        if (body.success) {
            alert('✅ ' + body.message);
            cerrarModalFamilia();
            cargarFamilias();
        } else {
            let mensaje = body.message || 'Error desconocido';
            if (body.errors) {
                mensaje = Object.values(body.errors).flat().join('\n');
            }
            alert('❌ Error: ' + mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la familia');
    })
    .finally(() => {
        btnGuardar.disabled = false;
        btnGuardar.textContent = textoOriginal;
    });
};

window.eliminarFamilia = function(id, codigo) {
    if (confirm(`¿Eliminar la familia ${codigo}?`)) {
        fetch(`{{ route('almacen.api.familias.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('✅ ' + res.message);
                cargarFamilias();
            } else {
                alert('❌ Error: ' + res.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la familia');
        });
    }
};

window.verFamilia = function(id) {
    fetch(`{{ route('almacen.api.familias') }}`)
        .then(res => res.json())
        .then(res => {
            const familia = res.data.find(f => f.id === id);
            if (familia) {
                alert(`Familia: ${familia.codigo}\nNombre: ${familia.nombre}\nDescripción: ${familia.descripcion || '---'}\nCuenta Contable: ${familia.cuenta_contable || '---'}\nEstatus: ${familia.estatus}`);
            }
        });
};

window.cerrarModalFamilia = function() {
    document.getElementById('modalFamilia').style.display = 'none';
    document.body.style.overflow = 'auto';
};

// =========================================
// SUBFAMILIAS: CRUD
// =========================================

window.abrirModalSubfamilia = function() {
    editingSubfamiliaId = null;
    document.getElementById('modalTituloSubfamilia').textContent = 'Nueva Subfamilia';
    document.getElementById('modalIdSubfamilia').value = '';
    document.getElementById('modalEstatusSubfamilia').value = 'Activo';
    document.getElementById('modalNumeroSubfamilia').value = 'Autogenerado';
    document.getElementById('modalFamiliaSubfamilia').value = '';
    document.getElementById('modalTipoSubfamilia').value = '';
    document.getElementById('modalDescripcionSubfamilia').value = '';
    // ✅ Reset del select de cuenta contable
    document.getElementById('modalCuentaSubfamilia').value = '';
    
    document.getElementById('modalSubfamilia').style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

window.editarSubfamilia = function(id) {
    fetch(`{{ route('almacen.api.subfamilias') }}`)
        .then(res => res.json())
        .then(res => {
            const subfamilia = res.data.find(s => s.id === id);
            if (subfamilia) {
                editingSubfamiliaId = subfamilia.id;
                document.getElementById('modalTituloSubfamilia').textContent = `Editar Subfamilia ${subfamilia.codigo}`;
                document.getElementById('modalIdSubfamilia').value = subfamilia.id;
                document.getElementById('modalEstatusSubfamilia').value = subfamilia.estatus;
                document.getElementById('modalNumeroSubfamilia').value = subfamilia.codigo;
                document.getElementById('modalFamiliaSubfamilia').value = subfamilia.familia_id;
                document.getElementById('modalTipoSubfamilia').value = subfamilia.nombre;
                document.getElementById('modalDescripcionSubfamilia').value = subfamilia.descripcion || '';
                // ✅ Asignar valor al select con fallback
                setCuentaContableSelect('modalCuentaSubfamilia', subfamilia.cuenta_contable);
                
                document.getElementById('modalSubfamilia').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        })
        .catch(error => console.error('Error al cargar subfamilia:', error));
};

window.guardarSubfamilia = function() {
    const familiaId = document.getElementById('modalFamiliaSubfamilia').value;
    const nombre = document.getElementById('modalTipoSubfamilia').value.trim();
    
    if (!familiaId) {
        alert('Debe seleccionar una familia');
        return;
    }
    if (!nombre) {
        alert('El nombre de la subfamilia es obligatorio');
        return;
    }
    
    const btnGuardar = document.getElementById('btnGuardarSubfamilia');
    const textoOriginal = btnGuardar.textContent;
    btnGuardar.disabled = true;
    btnGuardar.textContent = 'Guardando...';
    
    const data = {
        familia_id: familiaId,
        nombre: nombre,
        descripcion: document.getElementById('modalDescripcionSubfamilia').value,
        cuenta_contable: document.getElementById('modalCuentaSubfamilia').value,
        estatus: document.getElementById('modalEstatusSubfamilia').value
    };
    
    const url = editingSubfamiliaId 
        ? `{{ route('almacen.api.subfamilias.update', '') }}/${editingSubfamiliaId}` 
        : `{{ route('almacen.api.subfamilias.store') }}`;
    const method = editingSubfamiliaId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json().then(json => ({ status: res.status, body: json })))
    .then(({ status, body }) => {
        if (body.success) {
            alert('✅ ' + body.message);
            cerrarModalSubfamilia();
            cargarSubfamilias();
        } else {
            let mensaje = body.message || 'Error desconocido';
            if (body.errors) {
                mensaje = Object.values(body.errors).flat().join('\n');
            }
            alert('❌ Error: ' + mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la subfamilia');
    })
    .finally(() => {
        btnGuardar.disabled = false;
        btnGuardar.textContent = textoOriginal;
    });
};

window.eliminarSubfamilia = function(id, codigo) {
    if (confirm(`¿Eliminar la subfamilia ${codigo}?`)) {
        fetch(`{{ route('almacen.api.subfamilias.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('✅ ' + res.message);
                cargarSubfamilias();
            } else {
                alert('❌ Error: ' + res.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la subfamilia');
        });
    }
};

window.verSubfamilia = function(id) {
    fetch(`{{ route('almacen.api.subfamilias') }}`)
        .then(res => res.json())
        .then(res => {
            const subfamilia = res.data.find(s => s.id === id);
            if (subfamilia) {
                alert(`Subfamilia: ${subfamilia.codigo}\nFamilia: ${subfamilia.familia_codigo} - ${subfamilia.familia_nombre}\nNombre: ${subfamilia.nombre}\nDescripción: ${subfamilia.descripcion || '---'}\nCuenta Contable: ${subfamilia.cuenta_contable || '---'}\nEstatus: ${subfamilia.estatus}`);
            }
        });
};

window.cerrarModalSubfamilia = function() {
    document.getElementById('modalSubfamilia').style.display = 'none';
    document.body.style.overflow = 'auto';
};

// =========================================
// CONFIGURACIÓN DE EVENTOS
// =========================================

function configurarEventos() {
    // Cerrar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalFamilia();
            cerrarModalSubfamilia();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalFamilia').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalFamilia();
    });
    
    document.getElementById('modalSubfamilia').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalSubfamilia();
    });
    
    // Botones
    document.getElementById('btnCrearFiltro').addEventListener('click', () => alert('Funcionalidad de filtro en desarrollo'));
    document.getElementById('btnExcelFamilias').addEventListener('click', () => window.location.href = '{{ route("almacen.api.familias.exportar") }}');
    document.getElementById('btnExcelSubfamilias').addEventListener('click', () => window.location.href = '{{ route("almacen.api.subfamilias.exportar") }}');
    
    // Buscadores
    document.getElementById('buscadorFamilias').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaBodyFamilias tr');
        filas.forEach(fila => {
            fila.style.display = fila.textContent.toLowerCase().includes(termino) ? '' : 'none';
        });
    });
    
    document.getElementById('buscadorSubfamilias').addEventListener('input', function(e) {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaBodySubfamilias tr');
        filas.forEach(fila => {
            fila.style.display = fila.textContent.toLowerCase().includes(termino) ? '' : 'none';
        });
    });
    
    // Drag & drop para agrupación
    configurarDragDrop();
}

function configurarDragDrop() {
    // Familias
    document.getElementById('grupoAgrupacionFamilias').addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionFamilias').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasFamilias.includes(columna)) {
            columnasAgrupadasFamilias.push(columna);
            actualizarGrupoColumnasFamilias();
            alert('Agrupando familias por: ' + columna);
        }
    });
    
    // Subfamilias
    document.getElementById('grupoAgrupacionSubfamilias').addEventListener('dragover', (e) => e.preventDefault());
    document.getElementById('grupoAgrupacionSubfamilias').addEventListener('drop', (e) => {
        e.preventDefault();
        const columna = e.dataTransfer.getData('text/plain');
        if (columna && !columnasAgrupadasSubfamilias.includes(columna)) {
            columnasAgrupadasSubfamilias.push(columna);
            actualizarGrupoColumnasSubfamilias();
            alert('Agrupando subfamilias por: ' + columna);
        }
    });
}

function actualizarGrupoColumnasFamilias() {
    const container = document.getElementById('grupoColumnasFamilias');
    const texto = document.getElementById('textoAgruparFamilias');
    container.innerHTML = '';
    
    if (columnasAgrupadasFamilias.length === 0) {
        texto.style.display = 'inline';
    } else {
        texto.style.display = 'none';
        columnasAgrupadasFamilias.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaFamilias('${col}')">&times;</span>`;
            container.appendChild(chip);
        });
    }
}

window.removerColumnaFamilias = function(columna) {
    columnasAgrupadasFamilias = columnasAgrupadasFamilias.filter(c => c !== columna);
    actualizarGrupoColumnasFamilias();
};

function actualizarGrupoColumnasSubfamilias() {
    const container = document.getElementById('grupoColumnasSubfamilias');
    const texto = document.getElementById('textoAgruparSubfamilias');
    container.innerHTML = '';
    
    if (columnasAgrupadasSubfamilias.length === 0) {
        texto.style.display = 'inline';
    } else {
        texto.style.display = 'none';
        columnasAgrupadasSubfamilias.forEach(col => {
            const chip = document.createElement('span');
            chip.className = 'columna-agrupada';
            chip.innerHTML = `${col} <span class="remover" onclick="removerColumnaSubfamilias('${col}')">&times;</span>`;
            container.appendChild(chip);
        });
    }
}

window.removerColumnaSubfamilias = function(columna) {
    columnasAgrupadasSubfamilias = columnasAgrupadasSubfamilias.filter(c => c !== columna);
    actualizarGrupoColumnasSubfamilias();
};

// =========================================
// SELECTOR DE COLUMNAS
// =========================================

window.toggleColumnSelector = function(tipo) {
    const selector = document.getElementById('columnSelector' + (tipo === 'familias' ? 'Familias' : 'Subfamilias'));
    selector.style.display = selector.style.display === 'none' ? 'block' : 'none';
    
    if (selector.style.display === 'block') {
        const lista = document.getElementById('columnasLista' + (tipo === 'familias' ? 'Familias' : 'Subfamilias'));
        
        let columnas;
        if (tipo === 'familias') {
            columnas = [
                { field: 'estatus', caption: 'Estatus' },
                { field: 'n_familia', caption: 'N° Familia' },
                { field: 'tipo', caption: 'Tipo' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'cuenta_contable', caption: 'Cuenta Contable' }
            ];
        } else {
            columnas = [
                { field: 'estatus', caption: 'Estatus' },
                { field: 'n_subfamilia', caption: 'N° Subfamilia' },
                { field: 'familia', caption: 'Familia' },
                { field: 'tipo_subfamilia', caption: 'Tipo Subfamilia' },
                { field: 'descripcion', caption: 'Descripción' },
                { field: 'cuenta_contable', caption: 'Cuenta Contable' }
            ];
        }
        
        lista.innerHTML = columnas.map(col => `
            <div style="padding: 5px 0; display: flex; align-items: center;">
                <input type="checkbox" 
                       id="chk_${col.field}_${tipo}"
                       data-columna="${col.field}"
                       checked
                       style="margin-right: 8px; accent-color: var(--color-primary);">
                <label for="chk_${col.field}_${tipo}" style="font-size: 12px;">${col.caption}</label>
            </div>
        `).join('');
    }
};

window.cerrarColumnSelector = function(tipo) {
    document.getElementById('columnSelector' + (tipo === 'familias' ? 'Familias' : 'Subfamilias')).style.display = 'none';
};

// Cerrar selectores al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('#btnColumnasFamilias') && !e.target.closest('#columnSelectorFamilias')) {
        document.getElementById('columnSelectorFamilias').style.display = 'none';
    }
    if (!e.target.closest('#btnColumnasSubfamilias') && !e.target.closest('#columnSelectorSubfamilias')) {
        document.getElementById('columnSelectorSubfamilias').style.display = 'none';
    }
});
</script>
@endsection