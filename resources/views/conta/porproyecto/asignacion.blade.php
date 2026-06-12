@extends('layouts.navigation')

@section('content')

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --brand: #083CAE;
        --brand-dark: #062D8A;
        --brand-light: #EAF0FA;
        --border: #DEE2E6;
        --bg: #F4F6F9;
        --surface: #FFFFFF;
        --surface2: #F8F9FA;
        --text: #000000;
        --text-2: #000000;
        --text-3: #000000;
        --radius: 6px;
        --radius-lg: 10px;
        --shadow: 0 2px 8px rgba(8,60,174,.07), 0 1px 3px rgba(0,0,0,.04);
        --shadow-hover: 0 6px 20px rgba(8,60,174,.13);
    }

    .min-h-screen {
        min-height: 100vh;
        background-color: #f9fafb;
        color: #000000;
    }

    .content {
        padding: 1rem 1.5rem;
    }

    .container-fluid {
        width: 100%;
        max-width: 100%;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    .semaforo.card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
        padding: 15px 20px;
        text-align: center;
    }

    .semaforo .card-header h2 {
        color: #083CAE;
        font-weight: bold;
        margin: 0;
        font-size: 24px;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        padding: 20px;
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .kpi-card {
        background: white;
        border-radius: 8px;
        padding: 20px 15px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        text-align: center;
    }

    .kpi-card .label {
        font-size: 14px;
        font-weight: 600;
        color: #000000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        text-align: center;
    }

    .kpi-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 0;
        text-align: center;
        line-height: 1.2;
    }

    .btn-agregar {
        background-color: #1A8C3C;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-left: auto;
    }

    .btn-agregar:hover {
        background-color: #157030;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26,140,60,0.3);
    }

    .btn-agregar:active {
        transform: translateY(0);
    }

    .btn-agregar:hover i {
        transform: rotate(90deg);
    }

    .panel-nuevo-gasto {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .panel-nuevo-gasto.show {
        max-height: 800px;
        padding: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 4px;
    }

    .form-group label .req {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        font-size: 13px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        transition: all 0.2s;
        color: #000000;
    }

    .form-control:focus {
        border-color: #083CAE;
        outline: none;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
    }

    .btn-guardar {
        background-color: #083CAE;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-guardar:hover {
        background-color: #062D8A;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
    }

    .btn-cancelar {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .btn-cancelar:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #2378e1 !important;
        color: white !important;
        font-weight: 600;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 20;
        text-align: left;
    }

    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 12px 8px;
        color: #000000 !important;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .table td.text-right {
        text-align: right;
    }

    #tablaBody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    #tablaBody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #tablaBody tr:hover {
        background-color: #e0e0e0;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    #tablaBody td i {
        transition: all 0.3s ease;
        font-size: 14px;
        cursor: pointer;
        margin: 0 4px;
    }

    #tablaBody td i:hover {
        transform: scale(1.2) rotate(5deg);
        color: #062D8A;
    }

    #tablaBody td i.fa-trash:hover {
        color: #dc3545;
    }

    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }

    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
    }

    .badge-aprobado {
        background-color: #28a745;
        color: white;
    }

    .badge-pendiente {
        background-color: #ffc107;
        color: black;
    }

    .badge-rechazado {
        background-color: #dc3545;
        color: white;
    }

    .badge-revision {
        background-color: #17a2b8;
        color: white;
    }

    .filters-container {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 250px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 14px;
    }

    .search-box input {
        width: 100%;
        padding: 8px 12px 8px 35px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        color: #000000;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
        outline: none;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        min-width: 150px;
        color: #000000;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: #083CAE;
        outline: none;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
    }

    .filter-badge {
        background-color: #083CAE;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .tabs-container {
        display: flex;
        gap: 2px;
        padding: 0 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        overflow-x: auto;
        white-space: nowrap;
    }

    .tab-item {
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        border: 1px solid transparent;
        border-bottom: none;
        border-radius: 6px 6px 0 0;
        margin-bottom: -1px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .tab-item:hover {
        color: #083CAE;
        background-color: rgba(8,60,174,0.05);
    }

    .tab-item.active {
        color: #083CAE;
        background-color: white;
        border-color: #dee2e6;
        border-bottom-color: white;
        font-weight: 700;
    }

    .grupo-agrupacion {
        padding: 12px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .grupo-columnas {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
        flex: 1;
    }

    .columna-agrupada {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background-color: #e0e7ff;
        border-radius: 16px;
        color: #083CAE;
        font-size: 12px;
        margin: 2px;
        border: 1px solid #083CAE;
    }

    .columna-agrupada .remover {
        margin-left: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        color: #083CAE;
    }

    .columna-agrupada .remover:hover {
        opacity: 0.7;
    }

    .progress-wrap {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 100px;
    }
    
    .progress-bar-erp {
        flex: 1;
        height: 5px;
        background: #e5e7eb;
        border-radius: 99px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 99px;
        background: #083CAE;
        transition: width 0.5s ease;
    }
    
    .progress-fill.warn {
        background: #D4A000;
    }
    
    .progress-fill.danger {
        background: #dc3545;
    }
    
    .progress-pct {
        font-size: 11px;
        color: #000000;
        min-width: 32px;
        text-align: right;
    }

    .project-tag {
        display: flex;
        align-items: center;
        gap: 7px;
    }
    
    .project-dot {
        width: 9px;
        height: 9px;
        border-radius: 2px;
        flex-shrink: 0;
    }
    
    .project-code {
        font-weight: 700;
        font-size: 12px;
        line-height: 1.2;
        color: #000000;
    }
    
    .project-name {
        font-size: 10.5px;
        color: #6b7280;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: transparent;
        border-top: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-info {
        color: #000000;
        font-size: 13px;
    }

    .pagination-controls {
        display: flex;
        gap: 5px;
        align-items: center;
        flex-wrap: wrap;
    }

    .page-btn {
        background: transparent;
        border: 1px solid #dee2e6;
        color: #083CAE;
        cursor: pointer;
        padding: 5px 10px;
        font-size: 13px;
        border-radius: 4px;
        transition: all 0.3s ease;
        min-width: 35px;
    }

    .page-btn:hover:not(:disabled) {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.2);
    }

    .page-btn.active {
        background-color: #083CAE;
        color: white;
        border-color: #083CAE;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .toast {
        background: #1A1D23;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease;
        border-left: 4px solid;
    }

    .toast.success { border-left-color: #28a745; }
    .toast.success i { color: #28a745; }
    .toast.warning { border-left-color: #ffc107; }
    .toast.warning i { color: #ffc107; }
    .toast.error { border-left-color: #dc3545; }
    .toast.error i { color: #dc3545; }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1050;
        animation: fadeIn 0.3s ease;
    }

    .modal.show { display: block; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-dialog {
        max-width: 400px;
        margin: 100px auto;
        animation: slideInDown 0.3s ease;
        padding: 0 15px;
    }

    @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-content {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .modal-header.danger-header {
        background: linear-gradient(135deg, #8C1A1A, #B52020);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header.danger-header h5 {
        color: #fff;
        font-size: 14px;
        margin: 0;
    }

    .modal-header.danger-header .close {
        color: #fff;
        opacity: .8;
        background: transparent;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .modal-body { padding: 20px; font-size: 13.5px; color: #495057; }
    .modal-footer { padding: 12px 16px; background: #f8f9fa; display: flex; justify-content: flex-end; gap: 8px; }
    tfoot td { font-weight: bold; background-color: #e9ecef !important; border-top: 2px solid #083CAE; color: #000000 !important; }
    .mono { font-family: 'SFMono-Regular', Consolas, monospace; font-size: 12px; color: #000000; }
    .text-right { text-align: right; }

    @media (max-width: 768px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .filters-container { flex-direction: column; }
        .search-box, .filter-select { width: 100%; }
        .grupo-agrupacion { flex-direction: column; align-items: flex-start; }
        .btn-agregar { margin-left: 0; width: 100%; justify-content: center; }
        #tablaBody td:last-child { position: static; box-shadow: none; }
        .tabs-container { overflow-x: auto; }
        .tab-item { font-size: 11px; padding: 8px 12px; }
    }

    [draggable="true"] { cursor: grab; }
    [draggable="true"]:active { cursor: grabbing; opacity: 0.7; }
    .drag-over .grupo-columnas { background-color: rgba(8,60,174,0.1); border-radius: 4px; padding: 5px; }
    .table-container { overflow-x: auto; max-height: 500px; overflow-y: auto; width: 100%; background: white; }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">
            <div class="semaforo card-header">
                <h2>Asignación de Gastos por Proyecto</h2>
            </div>
            
            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Gasto Total</div>
                    <div class="value" id="kpiTotal">$0</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Proyectos Activos</div>
                    <div class="value" id="kpiProyectos">0</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Gastos Aprobados</div>
                    <div class="value" id="kpiAprobados">$0</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Pendientes</div>
                    <div class="value" id="kpiPendientes">$0</div>
                </div>
            </div>
            
            <!-- Panel nuevo gasto -->
            <div class="panel-nuevo-gasto" id="panelNuevoGasto">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Proyecto <span class="req">*</span></label>
                        <select class="form-control" id="fProyecto">
                            <option value="">— Seleccionar —</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha <span class="req">*</span></label>
                        <input type="date" class="form-control" id="fFecha" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Folio</label>
                        <input type="text" class="form-control" id="fFolio" placeholder="Se genera automático" readonly style="background:#f8f9fa;">
                    </div>
                    <div class="form-group">
                        <label>Categoría <span class="req">*</span></label>
                        <select class="form-control" id="fCategoria">
                            <option value="">— Seleccionar —</option>
                            <option value="Concreto">Concreto Premezclado</option>
                            <option value="Acero">Acero de Refuerzo</option>
                            <option value="Block">Block y Tabique</option>
                            <option value="Cemento">Cemento Gris</option>
                            <option value="Varilla">Varilla Corrugada</option>
                            <option value="Madera">Madera para Cimbra</option>
                            <option value="Albañiles">Cuadrilla de Albañiles</option>
                            <option value="Electricistas">Electricistas</option>
                            <option value="Plomeros">Plomeros</option>
                            <option value="Retroexcavadora">Renta de Retroexcavadora</option>
                            <option value="Grua">Grúa Torre</option>
                            <option value="Seguridad">Servicio de Seguridad</option>
                            <option value="Limpieza">Limpieza de Obra</option>
                            <option value="Permisos">Permisos y Licencias</option>
                            <option value="Seguros">Seguros de Obra</option>
                            <option value="Honorarios">Honorarios Profesionales</option>
                            <option value="Combustible">Combustible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Monto <span class="req">*</span></label>
                        <input type="number" class="form-control" id="fMonto" placeholder="0.00" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Proveedor</label>
                        <input type="text" class="form-control" id="fProveedor" placeholder="Nombre del proveedor">
                    </div>
                    <div class="form-group">
                        <label>Partida</label>
                        <select class="form-control" id="fPartida">
                            <option value="">— Opcional —</option>
                            <option value="CIMENTACION">01 - Cimentación</option>
                            <option value="ESTRUCTURA">02 - Estructura</option>
                            <option value="ALBAÑILERIA">03 - Albañilería</option>
                            <option value="ACABADOS">04 - Acabados</option>
                            <option value="INSTALACIONES">05 - Instalaciones</option>
                            <option value="ELECTRICAS">06 - Eléctricas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo Documento</label>
                        <select class="form-control" id="fTipoDoc">
                            <option>Factura</option>
                            <option>Nota de Remisión</option>
                            <option>Recibo</option>
                            <option>Contrato</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estatus</label>
                        <select class="form-control" id="fEstatus">
                            <option>Pendiente</option>
                            <option>Aprobado</option>
                            <option>Rechazado</option>
                            <option>En revisión</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Avance (%)</label>
                        <input type="number" class="form-control" id="fAvance" placeholder="0" min="0" max="100" value="0">
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Notas</label>
                        <textarea class="form-control" id="fNotas" rows="2" placeholder="Detalles adicionales..."></textarea>
                    </div>
                </div>
                <div style="text-align: right; margin-top: 15px;">
                    <button type="button" class="btn-cancelar" onclick="togglePanelNuevoGasto()">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn-guardar" onclick="agregarGasto()">
                        <i class="fas fa-save"></i> Guardar Gasto
                    </button>
                </div>
            </div>
            
            <!-- Área de agrupación -->
            <div class="grupo-agrupacion" id="grupoAgrupacion">
                <div class="grupo-columnas" id="grupoColumnas"></div>
                <button class="btn-agregar" onclick="togglePanelNuevoGasto()">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Gasto
                </button>
            </div>
            
            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active" data-tab="todos" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list"></i> Todos los Gastos
                </div>
                <div class="tab-item" data-tab="pendientes" onclick="setTab(this, 'pendientes')">
                    <i class="fas fa-hourglass-half"></i> Pendientes
                </div>
                <div class="tab-item" data-tab="aprobados" onclick="setTab(this, 'aprobados')">
                    <i class="fas fa-check-circle"></i> Aprobados
                </div>
                <div class="tab-item" data-tab="rechazados" onclick="setTab(this, 'rechazados')">
                    <i class="fas fa-times-circle"></i> Rechazados
                </div>
            </div>
            
            <!-- Filtros -->
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <div class="filters-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Buscar por folio, proyecto, proveedor..." oninput="debounceSearch()">
                    </div>
                    <select class="filter-select" id="filterProyecto" onchange="filtrar()">
                        <option value="">Todos los proyectos</option>
                    </select>
                    <select class="filter-select" id="filterCategoria" onchange="filtrar()">
                        <option value="">Todas categorías</option>
                    </select>
                    <select class="filter-select" id="filterEstatus" onchange="filtrar()">
                        <option value="">Todos estatus</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Rechazado">Rechazado</option>
                        <option value="En revisión">En revisión</option>
                    </select>
                    <span class="filter-badge" id="filterCount">0</span>
                </div>
            </div>
            
            <!-- Tabla -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th draggable="true" ondragstart="drag(event)" data-columna="folio">Folio</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="fecha">Fecha</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proyecto">Proyecto</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="categoria">Categoría</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proveedor">Proveedor</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="monto">Monto</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="avance">Avance</th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="estatus">Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody">
                        <tr><td colspan="9" style="text-align: center; padding: 40px;">Cargando datos...</td></tr>
                    </tbody>
                    <tfoot id="tablaFoot"></tfoot>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Mostrando <span id="footerInfo">0 registros</span>
                </div>
                <div class="pagination-controls">
                    <button class="page-btn" onclick="cambiarPagina(-1)" id="btnAnterior" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="page-btn active" id="pageNum">1</span>
                    <button class="page-btn" onclick="cambiarPagina(1)" id="btnSiguiente" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="toast-container" id="toastContainer"></div>

<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header danger-header">
                <h5><i class="fas fa-exclamation-triangle"></i> Confirmar eliminación</h5>
                <button type="button" class="close" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este gasto? Esta acción <strong>no se puede deshacer</strong>.
            </div>
            <div class="modal-footer">
                <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-guardar" style="background: #dc3545;" onclick="confirmarEliminar()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Configuración API
const API_URL = '/api/gastos-proyecto';

// Variables globales
let gastosData = [];
let currentPage = 1;
let perPage = 10;
let totalPages = 1;
let currentTab = 'todos';
let sortKey = 'fecha';
let sortDir = 'desc';
let deletingId = null;
let columnasAgrupadas = [];
let searchTimeout;

// Proyectos y categorías
let proyectosList = [];
let categoriasList = [];

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    cargarDatos();
    cargarFiltros();
});

// Cargar datos
async function cargarDatos() {
    try {
        const params = new URLSearchParams({
            page: currentPage,
            per_page: perPage,
            sort_key: sortKey,
            sort_dir: sortDir,
            search: document.getElementById('searchInput')?.value || '',
            proyecto_id: document.getElementById('filterProyecto')?.value || '',
            categoria_id: document.getElementById('filterCategoria')?.value || '',
            estatus: getEstatusFromTab()
        });
        
        const response = await fetch(`${API_URL}?${params}`);
        const result = await response.json();
        
        if (result.success) {
            gastosData = result.data.gastos;
            totalPages = result.data.pagination.last_page;
            actualizarKPIs(result.data.kpis);
            renderTabla();
            actualizarPaginacion(result.data.pagination);
        } else {
            mostrarToast('Error al cargar datos', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarToast('Error de conexión', 'error');
    }
}

// Cargar filtros
async function cargarFiltros() {
    try {
        const response = await fetch(API_URL);
        const result = await response.json();
        
        if (result.success && result.data.filtros) {
            proyectosList = result.data.filtros.proyectos || [];
            categoriasList = result.data.filtros.categorias || [];
            
            const proyectoSelect = document.getElementById('filterProyecto');
            const fProyecto = document.getElementById('fProyecto');
            const categoriaSelect = document.getElementById('filterCategoria');
            const fCategoria = document.getElementById('fCategoria');
            
            proyectoSelect.innerHTML = '<option value="">Todos los proyectos</option>';
            fProyecto.innerHTML = '<option value="">— Seleccionar —</option>';
            
            proyectosList.forEach(p => {
                proyectoSelect.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
                fProyecto.innerHTML += `<option value="${p.id}">${p.codigo} - ${p.nombre}</option>`;
            });
            
            categoriaSelect.innerHTML = '<option value="">Todas categorías</option>';
            fCategoria.innerHTML = '<option value="">— Seleccionar —</option>';
            
            categoriasList.forEach(c => {
                categoriaSelect.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                fCategoria.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando filtros:', error);
    }
}

// Renderizar tabla
function renderTabla() {
    const body = document.getElementById('tablaBody');
    
    if (!gastosData.length) {
        body.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 40px;">
            <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
            <p style="margin-top: 10px;">No se encontraron gastos</p>
        </td></tr>`;
        document.getElementById('tablaFoot').innerHTML = '';
        document.getElementById('filterCount').textContent = '0';
        document.getElementById('footerInfo').textContent = '0 registros';
        return;
    }
    
    body.innerHTML = gastosData.map(g => {
        const fillClass = g.progress_class === 'danger' ? 'danger' : (g.progress_class === 'warn' ? 'warn' : '');
        
        return `<tr>
            <td><span class="mono">${g.folio}</span></td>
            <td>${g.fecha_lista}</td>
            <td>
                <div class="project-tag">
                    <div class="project-dot" style="background:${g.proyecto_color || '#083CAE'}"></div>
                    <div>
                        <div class="project-code">${g.proyecto_codigo}</div>
                        <div class="project-name">${g.proyecto_nombre}</div>
                    </div>
                </div>
            </td>
            <td>${g.categoria}</td>
            <td>${g.proveedor}</td>
            <td class="text-right"><span class="mono" style="font-weight:700">${g.monto_formateado}</span></td>
            <td>
                <div class="progress-wrap">
                    <div class="progress-bar-erp">
                        <div class="progress-fill ${fillClass}" style="width:${g.avance}%"></div>
                    </div>
                    <span class="progress-pct">${g.avance}%</span>
                </div>
            </td>
            <td><span class="badge ${g.badge_class}">${g.estatus}</span></td>
            <td>
                <i class="fas fa-eye" onclick="verDetalle(${g.id})" title="Ver"></i>
                <i class="fas fa-edit" onclick="editarGasto(${g.id})" title="Editar"></i>
                <i class="fas fa-trash" onclick="abrirModal(${g.id})" style="color:#dc3545;" title="Eliminar"></i>
            </td>
        </td>`;
    }).join('');
    
    const totalMonto = gastosData.reduce((sum, g) => sum + g.monto, 0);
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="5" style="text-align: right; font-weight:600;">Total filtrado:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${formatMoney(totalMonto)}</span></td>
        <td colspan="3"></td>
    </tr>`;
    document.getElementById('filterCount').textContent = gastosData.length;
}

// Actualizar KPIs
function actualizarKPIs(kpis) {
    if (!kpis) return;
    document.getElementById('kpiTotal').textContent = kpis.total_formateado || '$0';
    document.getElementById('kpiProyectos').textContent = kpis.proyectos_activos || 0;
    document.getElementById('kpiAprobados').textContent = kpis.aprobados_formateado || '$0';
    document.getElementById('kpiPendientes').textContent = kpis.pendientes_formateado || '$0';
}

// Actualizar paginación
function actualizarPaginacion(pagination) {
    if (!pagination) return;
    document.getElementById('footerInfo').textContent = `${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    document.getElementById('pageNum').textContent = pagination.current_page || 1;
    document.getElementById('btnAnterior').disabled = pagination.current_page === 1;
    document.getElementById('btnSiguiente').disabled = pagination.current_page === pagination.last_page;
    currentPage = pagination.current_page;
    totalPages = pagination.last_page;
}

// Obtener estatus desde el tab actual
function getEstatusFromTab() {
    if (currentTab === 'pendientes') return 'Pendiente';
    if (currentTab === 'aprobados') return 'Aprobado';
    if (currentTab === 'rechazados') return 'Rechazado';
    return '';
}

// Filtrar
function filtrar() {
    currentPage = 1;
    cargarDatos();
}

// Debounce para búsqueda
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => filtrar(), 500);
}

// Cambiar página
function cambiarPagina(dir) {
    const newPage = currentPage + dir;
    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        cargarDatos();
    }
}

// Cambiar tab
function setTab(el, tab) {
    document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    currentTab = tab;
    currentPage = 1;
    cargarDatos();
}

// Panel nuevo gasto
function togglePanelNuevoGasto() {
    const panel = document.getElementById('panelNuevoGasto');
    panel.classList.toggle('show');
    if (panel.classList.contains('show')) {
        document.getElementById('fFecha').value = new Date().toISOString().split('T')[0];
        document.getElementById('fFolio').value = 'Generando...';
        document.getElementById('fAvance').value = '0';
    }
}

// Agregar gasto
async function agregarGasto() {
    const proyectoId = document.getElementById('fProyecto').value;
    const fecha = document.getElementById('fFecha').value;
    const monto = parseFloat(document.getElementById('fMonto').value);
    const categoria = document.getElementById('fCategoria').value;
    
    if (!proyectoId || !fecha || !monto || !categoria) {
        mostrarToast('❌ Completa los campos obligatorios', 'warning');
        return;
    }
    
    if (monto <= 0) {
        mostrarToast('❌ El monto debe ser mayor a cero', 'warning');
        return;
    }
    
    const data = {
        proyecto_id: parseInt(proyectoId),
        fecha: fecha,
        monto: monto,
        categoria: categoria,
        proveedor: document.getElementById('fProveedor').value,
        partida: document.getElementById('fPartida').value,
        tipo_documento: document.getElementById('fTipoDoc').value,
        estatus: document.getElementById('fEstatus').value,
        avance: parseInt(document.getElementById('fAvance').value) || 0,
        notas: document.getElementById('fNotas').value
    };
    
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        
        if (result.success) {
            mostrarToast('✅ Gasto registrado correctamente', 'success');
            togglePanelNuevoGasto();
            limpiarFormulario();
            cargarDatos();
            cargarFiltros();
        } else {
            mostrarToast('❌ Error: ' + result.message, 'error');
        }
    } catch (error) {
        mostrarToast('❌ Error de conexión', 'error');
    }
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('fProyecto').value = '';
    document.getElementById('fMonto').value = '';
    document.getElementById('fCategoria').value = '';
    document.getElementById('fProveedor').value = '';
    document.getElementById('fPartida').value = '';
    document.getElementById('fNotas').value = '';
    document.getElementById('fTipoDoc').value = 'Factura';
    document.getElementById('fEstatus').value = 'Pendiente';
    document.getElementById('fAvance').value = '0';
}

// Ver detalle
function verDetalle(id) {
    const gasto = gastosData.find(g => g.id === id);
    if (gasto) {
        mostrarToast(`${gasto.folio} - ${gasto.categoria} - ${gasto.monto_formateado}`, 'info');
    }
}

// Editar gasto
function editarGasto(id) {
    const gasto = gastosData.find(g => g.id === id);
    if (!gasto) return;
    
    document.getElementById('fProyecto').value = gasto.proyecto_id;
    document.getElementById('fFecha').value = gasto.fecha;
    document.getElementById('fMonto').value = gasto.monto;
    document.getElementById('fCategoria').value = gasto.categoria;
    document.getElementById('fProveedor').value = gasto.proveedor;
    document.getElementById('fPartida').value = gasto.partida !== '—' ? gasto.partida : '';
    document.getElementById('fTipoDoc').value = gasto.tipo_documento;
    document.getElementById('fEstatus').value = gasto.estatus;
    document.getElementById('fAvance').value = gasto.avance;
    document.getElementById('fNotas').value = gasto.notas || '';
    
    const panel = document.getElementById('panelNuevoGasto');
    if (!panel.classList.contains('show')) {
        panel.classList.add('show');
    }
    mostrarToast(`Editando: ${gasto.folio}`, 'info');
    window.scrollTo({ top: 200, behavior: 'smooth' });
}

// Modal
function abrirModal(id) { deletingId = id; document.getElementById('deleteModal').classList.add('show'); }
function cerrarModal() { document.getElementById('deleteModal').classList.remove('show'); deletingId = null; }
async function confirmarEliminar() {
    if (!deletingId) return;
    try {
        const response = await fetch(`${API_URL}/${deletingId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const result = await response.json();
        if (result.success) {
            mostrarToast('Registro eliminado', 'warning');
            cerrarModal();
            cargarDatos();
        } else {
            mostrarToast('Error al eliminar', 'error');
        }
    } catch (error) {
        mostrarToast('Error de conexión', 'error');
    }
}

// Drag and drop
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.getAttribute('data-columna'));
}

const grupoAgrupacion = document.getElementById('grupoAgrupacion');
if (grupoAgrupacion) {
    grupoAgrupacion.addEventListener('dragover', function(ev) {
        ev.preventDefault();
        this.classList.add('drag-over');
    });
    grupoAgrupacion.addEventListener('dragleave', function() {
        this.classList.remove('drag-over');
    });
    grupoAgrupacion.addEventListener('drop', function(ev) {
        ev.preventDefault();
        this.classList.remove('drag-over');
        const columna = ev.dataTransfer.getData("text");
        if (columna && !columnasAgrupadas.includes(columna)) {
            columnasAgrupadas.push(columna);
            actualizarGrupoColumnas();
            mostrarToast(`Columna ${columna} agregada`, 'success');
        }
    });
}

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
    if (!container) return;
    container.innerHTML = columnasAgrupadas.map(col => `
        <span class="columna-agrupada">
            ${col}
            <span class="remover" onclick="removerColumna('${col}')">&times;</span>
        </span>
    `).join('');
}

function removerColumna(columna) {
    columnasAgrupadas = columnasAgrupadas.filter(c => c !== columna);
    actualizarGrupoColumnas();
}

// Toast
function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    const icon = tipo === 'success' ? 'fa-check-circle' : tipo === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> ${msg}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function formatMoney(amount) {
    return '$' + amount.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        cerrarModal();
    }
}
</script>
@endsection