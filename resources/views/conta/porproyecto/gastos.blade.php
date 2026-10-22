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
        --radius: 6px;
        --radius-lg: 10px;
        --shadow: 0 2px 8px rgba(8,60,174,.07), 0 1px 3px rgba(0,0,0,.04);
        --shadow-hover: 0 6px 20px rgba(8,60,174,.13);
        --sidebar-width: 250px;
        --sidebar-collapsed-width: 80px;
    }

    .main-content { transition: margin-left 0.3s ease; margin-left: var(--sidebar-width); }
    .sidebar-collapsed .main-content { margin-left: var(--sidebar-collapsed-width); }

    .min-h-screen {
        min-height: 100vh;
        background-color: #f9fafb;
        color: #000000;
        width: 100%;
    }

    .content {
        padding: 1rem 1.5rem;
        max-width: calc(100vw - var(--sidebar-width) - 3rem);
        overflow-x: hidden;
    }
    .sidebar-collapsed .content { max-width: calc(100vw - var(--sidebar-collapsed-width) - 3rem); }

    .container-fluid { width: 100%; max-width: 100%; }
    .py-3 { padding-top: 1rem; padding-bottom: 1rem; }
    .mt-2 { margin-top: 0.5rem; }

    .semaforo.card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
        width: 100%;
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
    }

    .kpi-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #000000;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .kpi-card .sub { font-size: 12px; color: #6b7280; margin-top: 5px; }

    .btn-agregar {
        background-color: #2CBF1F;
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
    .btn-agregar:hover {
        background-color: #26a91b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44,191,31,0.3);
    }
    .btn-agregar:active { transform: translateY(0); }
    .btn-agregar:hover i { transform: rotate(90deg); }
    .btn-agregar i { transition: transform .3s ease; }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 15px;
    }

    .form-group { margin-bottom: 12px; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 4px;
    }
    .form-group label .req { color: #dc3545; }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        font-size: 13px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        transition: all 0.2s;
        color: #000000;
        background: white;
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
    }
    .btn-cancelar:hover { background-color: #5a6268; transform: translateY(-2px); }

    .table-responsive {
        overflow-x: auto;
        max-height: 500px;
        overflow-y: auto;
        width: 100%;
        background: white;
        position: relative;
        border-radius: 0;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 1200px;
    }

    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #083CAE !important;
        color: white !important;
        font-weight: 600;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 20;
        text-align: left;
        cursor: pointer;
        user-select: none;
    }
    .table th i.fa-sort { opacity: .6; margin-left: 4px; }

    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 12px 8px;
        color: #000000 !important;
        border: 1px solid #dee2e6;
        text-align: left;
    }

    .table td.text-right { text-align: right; }

    #tablaBody tr:nth-child(odd) { background-color: #ffffff; }
    #tablaBody tr:nth-child(even) { background-color: #f2f2f2; }
    #tablaBody tr:hover {
        background-color: #e0e0e0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
        justify-content: flex-end;
        min-width: 100px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 4px;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #083CAE;
    }
    .action-btn:hover {
        transform: scale(1.15);
        background: rgba(8,60,174,0.1);
    }
    .action-btn.delete:hover { color: #dc3545; background: rgba(220,53,69,0.1); }
    .action-btn i { font-size: 14px; }

    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
        padding: 8px 12px;
        white-space: nowrap;
    }

    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-administrativo { background-color: #083CAE; color: white; }
    .badge-oficina { background-color: #1A4F8C; color: white; }
    .badge-viaticos { background-color: #C4540A; color: white; }
    .badge-servicios { background-color: #1A6644; color: white; }
    .badge-seguros { background-color: #8C6A0A; color: white; }
    .badge-impuestos { background-color: #8C1A1A; color: white; }

    .filters-container {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .search-box { position: relative; flex: 1; min-width: 250px; }
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
        background: white;
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
    .tab-item:hover { color: #083CAE; background-color: rgba(8,60,174,0.05); }
    .tab-item.active {
        color: #083CAE;
        background-color: white;
        border-color: #dee2e6;
        border-bottom-color: white;
        font-weight: 700;
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
    .pagination-info { color: #000000; font-size: 13px; }
    .pagination-controls { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }

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
    }
    .page-btn.active { background-color: #083CAE; color: white; border-color: #083CAE; }
    .page-btn:disabled { opacity: 0.5; cursor: not-allowed; }

    .project-tag { display: flex; align-items: center; gap: 7px; min-width: 140px; }
    .project-dot { width: 9px; height: 9px; border-radius: 2px; flex-shrink: 0; }
    .project-code { font-weight: 700; font-size: 12px; line-height: 1.2; color: #000000; }
    .project-name {
        font-size: 10.5px;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    /* ============================================================
       TOASTS
    ============================================================ */
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 100000; /* por encima de todo, incluido modal */
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
    .toast.info { border-left-color: #17a2b8; }
    .toast.info i { color: #17a2b8; }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }

    /* ============================================================
       MODAL — CORREGIDO
       z-index altísimo y backdrop independiente para evitar que
       cualquier sticky de la tabla quede por encima.
    ============================================================ */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        overflow-y: auto;
        padding: 20px;
    }
    .modal.show { display: block; }

    /* Backdrop como pseudo-elemento para separarlo del contenido */
    .modal::before {
        content: "";
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 0;
        animation: fadeIn 0.25s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .modal-dialog {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 40px auto;
        animation: slideInDown 0.3s ease;
    }
    .modal-dialog.small { max-width: 450px; }

    @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    .modal-content {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.35);
        position: relative;
    }

    .modal-header {
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-header.brand-header {
        background: linear-gradient(135deg, #083CAE, #1A4F8C);
        color: #fff;
    }
    .modal-header.danger-header {
        background: linear-gradient(135deg, #8C1A1A, #B52020);
        color: #fff;
    }
    .modal-header h5 {
        font-size: 16px;
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #fff;
    }
    .modal-header .close {
        color: #fff;
        opacity: .85;
        background: transparent;
        border: none;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        padding: 0 4px;
    }
    .modal-header .close:hover { opacity: 1; }

    .modal-body { padding: 20px; font-size: 13.5px; color: #495057; }
    .modal-footer {
        padding: 12px 20px;
        background: #f8f9fa;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        border-top: 1px solid #e5e7eb;
    }

    /* Bloquea scroll del fondo cuando hay modal abierto */
    body.modal-open { overflow: hidden !important; }

    /* Detalle (vista de solo lectura) */
    .detalle-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px 25px;
    }
    .detalle-item label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #6b7280;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .detalle-item .val { font-size: 14px; color: #000; font-weight: 500; }
    .detalle-item.full { grid-column: span 2; }

    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }
    .mono { font-family: 'SFMono-Regular', Consolas, monospace; font-size: 12px; color: #000000; }
    .text-right { text-align: right; }

    @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 992px) {
        .main-content, .content { margin-left: 0 !important; max-width: 100vw !important; }
        .modal-dialog { margin: 20px auto; }
    }
    @media (max-width: 768px) {
        .kpi-grid { grid-template-columns: 1fr; }
        .filters-container { flex-direction: column; }
        .search-box, .filter-select { width: 100%; }
        .btn-agregar { width: 100%; justify-content: center; }
        .detalle-grid { grid-template-columns: 1fr; }
        .detalle-item.full { grid-column: span 1; }
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <div class="semaforo card mt-2">

            {{-- HEADER --}}
            <div class="semaforo card-header">
                <h2>Gastos Indirectos por Obra</h2>
            </div>

            {{-- KPIs --}}
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Total Indirectos</div>
                    <div class="value" id="kpiTotal">$0</div>
                    <div class="sub" id="kpiTotalSub">cargando...</div>
                </div>
                <div class="kpi-card">
                    <div class="label">% Indirectos</div>
                    <div class="value" id="kpiPorcentaje">0%</div>
                    <div class="sub">sobre costo directo</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Administración</div>
                    <div class="value" id="kpiAdmin">$0</div>
                    <div class="sub" id="kpiAdminSub">0% del total</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Servicios</div>
                    <div class="value" id="kpiServicios">$0</div>
                    <div class="sub" id="kpiServiciosSub">0% del total</div>
                </div>
            </div>

            {{-- BARRA DE ACCIONES --}}
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 10px;">
                <button class="btn-agregar" onclick="abrirModalNuevoGasto()">
                    <i class="fas fa-plus-circle"></i> Agregar Gasto Indirecto
                </button>
            </div>

            {{-- TABS --}}
            <div class="tabs-container">
                <div class="tab-item active" data-tab="todos" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list"></i> Todos los Gastos
                </div>
                <div class="tab-item" data-tab="administrativos" onclick="setTab(this, 'administrativos')">
                    <i class="fas fa-briefcase"></i> Administrativos
                </div>
                <div class="tab-item" data-tab="viaticos" onclick="setTab(this, 'viaticos')">
                    <i class="fas fa-plane"></i> Viáticos
                </div>
                <div class="tab-item" data-tab="servicios" onclick="setTab(this, 'servicios')">
                    <i class="fas fa-cogs"></i> Servicios
                </div>
                <div class="tab-item" data-tab="seguros" onclick="setTab(this, 'seguros')">
                    <i class="fas fa-shield-alt"></i> Seguros
                </div>
                <div class="tab-item" data-tab="impuestos" onclick="setTab(this, 'impuestos')">
                    <i class="fas fa-file-invoice"></i> Impuestos
                </div>
            </div>

            {{-- FILTROS --}}
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <div class="filters-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Buscar por folio, concepto o proveedor..." oninput="debounceSearch()">
                    </div>
                    <select class="filter-select" id="filterProyecto" onchange="filtrar()">
                        <option value="">Todos los proyectos</option>
                    </select>
                    <select class="filter-select" id="filterProveedor" onchange="filtrar()">
                        <option value="">Todos los proveedores</option>
                    </select>
                    <select class="filter-select" id="filterTipo" onchange="filtrar()">
                        <option value="">Todos los tipos</option>
                        <option value="ADMIN01">Administrativos</option>
                        <option value="VIA01">Viáticos</option>
                        <option value="SER01">Servicios</option>
                        <option value="SEG01">Seguros</option>
                        <option value="IMP01">Impuestos</option>
                    </select>
                    <span class="filter-badge" id="filterCount">0</span>
                </div>
            </div>

            {{-- TABLA --}}
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th onclick="ordenar('folio')">Folio <i class="fas fa-sort"></i></th>
                            <th onclick="ordenar('fecha')">Fecha <i class="fas fa-sort"></i></th>
                            <th>Proyecto</th>
                            <th>Tipo Gasto</th>
                            <th>Proveedor</th>
                            <th onclick="ordenar('monto')">Monto <i class="fas fa-sort"></i></th>
                            <th style="cursor:default;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody">
                        <tr><td colspan="8" style="text-align: center; padding: 40px;">Cargando datos...</td></tr>
                    </tbody>
                    <tfoot id="tablaFoot"></tfoot>
                </table>
            </div>

            {{-- PAGINACIÓN --}}
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

{{-- ============================================================
     MODAL: CREAR / EDITAR GASTO
============================================================ --}}
<div class="modal" id="gastoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header brand-header">
                <h5 id="gastoModalTitle"><i class="fas fa-plus-circle"></i> Nuevo Gasto Indirecto</h5>
                <button type="button" class="close" onclick="cerrarModalGasto()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Proyecto <span class="req">*</span></label>
                        <select class="form-control" id="fProyecto">
                            <option value="">— Seleccionar —</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha <span class="req">*</span></label>
                        <input type="date" class="form-control" id="fFecha">
                    </div>
                    <div class="form-group">
                        <label>Folio</label>
                        <input type="text" class="form-control" id="fFolio" placeholder="Se genera automático" readonly style="background:#f8f9fa;">
                    </div>
                    <div class="form-group">
                        <label>Tipo de Gasto <span class="req">*</span></label>
                        <select class="form-control" id="fTipo">
                            <option value="">— Seleccionar —</option>
                            <option value="Administrativo">Administrativos</option>
                            <option value="Oficina">Gastos de Oficina</option>
                            <option value="Viaticos">Viáticos</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Seguros">Seguros</option>
                            <option value="Impuestos">Impuestos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Monto <span class="req">*</span></label>
                        <input type="number" class="form-control" id="fMonto" placeholder="0.00" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Proveedor</label>
                        <select class="form-control" id="fProveedor">
                            <option value="">— Sin proveedor —</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo Documento</label>
                        <select class="form-control" id="fTipoDoc">
                            <option>Factura</option>
                            <option>Recibo</option>
                            <option>Comprobante</option>
                            <option>Contrato</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Forma de Pago</label>
                        <select class="form-control" id="fPago">
                            <option>Transferencia</option>
                            <option>Cheque</option>
                            <option>Efectivo</option>
                            <option>Tarjeta</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Concepto / Descripción</label>
                        <textarea class="form-control" id="fNotas" rows="2" placeholder="Detalle del gasto indirecto..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" onclick="cerrarModalGasto()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn-guardar" id="btnGuardarGasto" onclick="guardarGasto()">
                    <i class="fas fa-save"></i> Guardar Gasto
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL: VER DETALLE
============================================================ --}}
<div class="modal" id="detalleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header brand-header">
                <h5><i class="fas fa-eye"></i> Detalle del Gasto</h5>
                <button type="button" class="close" onclick="cerrarModalDetalle()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detalle-grid" id="detalleBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" onclick="cerrarModalDetalle()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL: CONFIRMAR ELIMINACIÓN
============================================================ --}}
<div class="modal" id="deleteModal">
    <div class="modal-dialog small">
        <div class="modal-content">
            <div class="modal-header danger-header">
                <h5><i class="fas fa-exclamation-triangle"></i> Confirmar eliminación</h5>
                <button type="button" class="close" onclick="cerrarModalEliminar()">&times;</button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este gasto indirecto? Esta acción <strong>no se puede deshacer</strong>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" onclick="cerrarModalEliminar()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn-guardar" style="background:#dc3545;" onclick="confirmarEliminar()">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>

<script>
/* ============================================================
   ESTADO GLOBAL
============================================================ */
let gastosData     = [];
let currentPage    = 1;
let perPage        = 10;
let totalPages     = 1;
let currentTab     = 'todos';
let sortKey        = 'fecha';
let sortDir        = 'desc';
let searchTimeout;
let deletingId     = null;
let editingId      = null;   // null = crear, id = editar

const API_URL = '/api/gastos-indirectos';
const CSRF    = '{{ csrf_token() }}';

// Catálogos
let proyectosList   = [];
let proveedoresList = [];
let tiposGastoList  = [];

/* ============================================================
   ABRIR / CERRAR MODALES (con bloqueo de scroll)
============================================================ */
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.classList.add('modal-open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    // Solo quitar bloqueo si no queda ningún otro modal abierto
    if (!document.querySelector('.modal.show')) {
        document.body.classList.remove('modal-open');
    }
}

/* ============================================================
   CARGA DE DATOS
============================================================ */
async function cargarDatos() {
    try {
        const params = new URLSearchParams({
            page: currentPage,
            per_page: perPage,
            sort_key: sortKey,
            sort_dir: sortDir,
            search:        document.getElementById('searchInput')?.value    || '',
            proyecto_id:   document.getElementById('filterProyecto')?.value || '',
            proveedor_id:  document.getElementById('filterProveedor')?.value|| '',
            tipo_gasto:    document.getElementById('filterTipo')?.value     || ''
        });

        const response = await fetch(`${API_URL}?${params}`, {
            headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();

        if (result.success) {
            gastosData  = result.data.gastos;
            totalPages  = result.data.pagination.last_page;

            if (proyectosList.length === 0 && result.data.filtros) {
                proyectosList   = result.data.filtros.proyectos   || [];
                proveedoresList = result.data.filtros.proveedores || [];
                tiposGastoList  = result.data.filtros.tipos_gasto || [];
                poblarSelects();
            }

            renderTabla();
            actualizarKPIs(result.data.kpis);
            actualizarPaginacion(result.data.pagination);
        } else {
            mostrarToast('Error al cargar datos', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarToast('Error de conexión', 'error');
    }
}

/* ============================================================
   POBLAR SELECTS
============================================================ */
function poblarSelects() {
    const filterProyecto = document.getElementById('filterProyecto');
    filterProyecto.innerHTML = '<option value="">Todos los proyectos</option>';
    proyectosList.forEach(p => {
        filterProyecto.innerHTML += `<option value="${p.id}">${escapeHtml(p.codigo)} - ${escapeHtml(p.nombre)}</option>`;
    });

    const fProyecto = document.getElementById('fProyecto');
    fProyecto.innerHTML = '<option value="">— Seleccionar —</option>';
    proyectosList.forEach(p => {
        fProyecto.innerHTML += `<option value="${p.id}">${escapeHtml(p.codigo)} - ${escapeHtml(p.nombre)}</option>`;
    });

    const filterProveedor = document.getElementById('filterProveedor');
    filterProveedor.innerHTML = '<option value="">Todos los proveedores</option>';
    proveedoresList.forEach(p => {
        const nombre = p.nombre || p.razon_social || `Proveedor #${p.id}`;
        filterProveedor.innerHTML += `<option value="${p.id}">${escapeHtml(nombre)}</option>`;
    });

    const fProveedor = document.getElementById('fProveedor');
    fProveedor.innerHTML = '<option value="">— Sin proveedor —</option>';
    proveedoresList.forEach(p => {
        const nombre = p.nombre || p.razon_social || `Proveedor #${p.id}`;
        const rfc    = p.rfc ? ` (${p.rfc})` : '';
        fProveedor.innerHTML += `<option value="${p.id}">${escapeHtml(nombre)}${escapeHtml(rfc)}</option>`;
    });
}

/* ============================================================
   RENDER TABLA
============================================================ */
function renderTabla() {
    const body = document.getElementById('tablaBody');

    if (!gastosData.length) {
        body.innerHTML = `<tr><td colspan="8" style="text-align: center; padding: 40px;">
            <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
            <p style="margin-top: 10px;">No se encontraron gastos indirectos</p>
        </td></tr>`;
        document.getElementById('tablaFoot').innerHTML = '';
        document.getElementById('filterCount').textContent = '0';
        document.getElementById('footerInfo').textContent = '0 registros';
        return;
    }

    body.innerHTML = gastosData.map(g => `
        <tr>
            <td><span class="mono">${escapeHtml(g.folio)}</span></td>
            <td>${escapeHtml(g.fecha_lista || g.fecha)}</td>
            <td>
                <div class="project-tag">
                    <div class="project-dot" style="background:${g.proyecto_color || '#083CAE'}"></div>
                    <div>
                        <div class="project-code">${escapeHtml(g.proyecto_codigo || 'N/A')}</div>
                        <div class="project-name">${escapeHtml(g.proyecto_nombre || '')}</div>
                    </div>
                </div>
            </td>
            <td><span class="badge ${g.badge_class}">${escapeHtml(g.tipo)}</span></td>
            <td>${escapeHtml(g.proveedor || '-')}</td>
            <td class="text-right"><span class="mono" style="font-weight:700">${escapeHtml(g.monto_formateado)}</span></td>
            
            <td>
                <div class="action-buttons">
                    <button class="action-btn" onclick="verDetalle(${g.id})" title="Ver detalle"><i class="fas fa-eye"></i></button>
                    <button class="action-btn" onclick="editarGasto(${g.id})" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="action-btn delete" onclick="abrirModalEliminar(${g.id})" title="Eliminar"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('');

    const totalMonto = gastosData.reduce((sum, g) => sum + Number(g.monto || 0), 0);
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="5" style="text-align: right; font-weight:600;">Total filtrado:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${formatMoney(totalMonto)}</span></td>
        <td colspan="2"></td>
    </tr>`;
    document.getElementById('filterCount').textContent = gastosData.length;
}

/* ============================================================
   KPIs
============================================================ */
function actualizarKPIs(kpis) {
    if (!kpis) return;
    document.getElementById('kpiTotal').textContent    = kpis.total_formateado || '$0';
    document.getElementById('kpiTotalSub').textContent = `Total de gastos`;
    document.getElementById('kpiPorcentaje').textContent = kpis.porcentaje_sobre_costo || '0%';
    document.getElementById('kpiAdmin').textContent     = kpis.administrativos_formateado || '$0';
    document.getElementById('kpiServicios').textContent = kpis.servicios_formateado || '$0';

    const total      = Number(kpis.total || 0);
    const admin      = Number(kpis.administrativos || 0);
    const servicios  = Number(kpis.servicios || 0);
    const adminPorc  = total > 0 ? ((admin / total) * 100).toFixed(1) : 0;
    const servPorc   = total > 0 ? ((servicios / total) * 100).toFixed(1) : 0;

    document.getElementById('kpiAdminSub').textContent     = `${adminPorc}% del total`;
    document.getElementById('kpiServiciosSub').textContent = `${servPorc}% del total`;
}

/* ============================================================
   PAGINACIÓN
============================================================ */
function actualizarPaginacion(pagination) {
    if (!pagination) return;
    document.getElementById('footerInfo').textContent    = `${pagination.from || 0}-${pagination.to || 0} de ${pagination.total || 0} registros`;
    document.getElementById('pageNum').textContent       = pagination.current_page || 1;
    document.getElementById('btnAnterior').disabled      = pagination.current_page === 1;
    document.getElementById('btnSiguiente').disabled     = pagination.current_page === pagination.last_page;
    currentPage = pagination.current_page;
    totalPages  = pagination.last_page;
}

/* ============================================================
   FILTROS / TABS / ORDEN
============================================================ */
function filtrar() {
    currentPage = 1;
    cargarDatos();
}

function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => filtrar(), 400);
}

function cambiarPagina(dir) {
    const newPage = currentPage + dir;
    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        cargarDatos();
    }
}

function ordenar(key) {
    if (sortKey === key) {
        sortDir = sortDir === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey = key;
        sortDir = 'asc';
    }
    cargarDatos();
}

function setTab(el, tab) {
    document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    currentTab = tab;

    let tipoGasto = '';
    if (tab === 'administrativos') tipoGasto = 'ADMIN01';
    else if (tab === 'viaticos')   tipoGasto = 'VIA01';
    else if (tab === 'servicios')  tipoGasto = 'SER01';
    else if (tab === 'seguros')    tipoGasto = 'SEG01';
    else if (tab === 'impuestos')  tipoGasto = 'IMP01';

    document.getElementById('filterTipo').value = tipoGasto;
    filtrar();
}

/* ============================================================
   MODAL: CREAR / EDITAR
============================================================ */
function abrirModalNuevoGasto() {
    editingId = null;

    document.getElementById('gastoModalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Nuevo Gasto Indirecto';
    document.getElementById('btnGuardarGasto').innerHTML = '<i class="fas fa-save"></i> Guardar Gasto';

    limpiarFormulario();
    document.getElementById('fFecha').value = new Date().toISOString().split('T')[0];
    document.getElementById('fFolio').value = 'Se genera al guardar';

    openModal('gastoModal');
}

function cerrarModalGasto() {
    closeModal('gastoModal');
    editingId = null;
}

function limpiarFormulario() {
    document.getElementById('fProyecto').value  = '';
    document.getElementById('fFecha').value     = '';
    document.getElementById('fFolio').value     = '';
    document.getElementById('fTipo').value      = '';
    document.getElementById('fMonto').value     = '';
    document.getElementById('fProveedor').value = '';
    document.getElementById('fTipoDoc').value   = 'Factura';
    document.getElementById('fPago').value      = 'Transferencia';
    document.getElementById('fNotas').value     = '';
}

async function guardarGasto() {
    const proyectoId  = document.getElementById('fProyecto').value;
    const fecha       = document.getElementById('fFecha').value;
    const monto       = parseFloat(document.getElementById('fMonto').value);
    const tipo        = document.getElementById('fTipo').value;
    const proveedorId = document.getElementById('fProveedor').value;

    if (!proyectoId || !fecha || !monto || !tipo) {
        mostrarToast('Completa los campos obligatorios', 'warning');
        return;
    }
    if (monto <= 0) {
        mostrarToast('El monto debe ser mayor a cero', 'warning');
        return;
    }

    const payload = {
        proyecto_id:    parseInt(proyectoId),
        fecha:          fecha,
        monto:          monto,
        tipo:           tipo,
        proveedor_id:   proveedorId ? parseInt(proveedorId) : null,
        tipo_documento: document.getElementById('fTipoDoc').value,
        forma_pago:     document.getElementById('fPago').value,
        concepto:       document.getElementById('fNotas').value
    };

    const btn = document.getElementById('btnGuardarGasto');
    btn.disabled = true;
    const original = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

    try {
        const url    = editingId ? `${API_URL}/${editingId}` : API_URL;
        const method = editingId ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify(payload)
        });
        const result = await response.json();

        if (result.success) {
            mostrarToast(editingId ? 'Gasto actualizado correctamente' : 'Gasto registrado correctamente', 'success');
            cerrarModalGasto();
            cargarDatos();
        } else {
            mostrarToast('Error: ' + (result.message || 'desconocido'), 'error');
        }
    } catch (error) {
        console.error(error);
        mostrarToast('Error de conexión', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
}

/* ============================================================
   MODAL: EDITAR
============================================================ */
function editarGasto(id) {
    const gasto = gastosData.find(g => g.id === id);
    if (!gasto) return;

    editingId = id;

    document.getElementById('gastoModalTitle').innerHTML = `<i class="fas fa-edit"></i> Editar Gasto — ${escapeHtml(gasto.folio)}`;
    document.getElementById('btnGuardarGasto').innerHTML = '<i class="fas fa-save"></i> Actualizar Gasto';

    document.getElementById('fProyecto').value  = gasto.proyecto_id || '';
    document.getElementById('fFecha').value     = gasto.fecha || '';
    document.getElementById('fFolio').value     = gasto.folio || '';
    document.getElementById('fTipo').value      = gasto.tipo || '';
    document.getElementById('fMonto').value     = gasto.monto || '';
    document.getElementById('fProveedor').value = gasto.proveedor_id || '';
    document.getElementById('fTipoDoc').value   = gasto.tipo_documento || 'Factura';
    document.getElementById('fPago').value      = gasto.forma_pago || 'Transferencia';
    document.getElementById('fNotas').value     = gasto.concepto || '';

    openModal('gastoModal');
}

/* ============================================================
   MODAL: VER DETALLE
============================================================ */
function verDetalle(id) {
    const g = gastosData.find(x => x.id === id);
    if (!g) return;

    document.getElementById('detalleBody').innerHTML = `
        <div class="detalle-item"><label>Folio</label><div class="val mono">${escapeHtml(g.folio)}</div></div>
        <div class="detalle-item"><label>Fecha</label><div class="val">${escapeHtml(g.fecha_lista || g.fecha)}</div></div>
        <div class="detalle-item"><label>Proyecto</label><div class="val">${escapeHtml(g.proyecto_codigo)} — ${escapeHtml(g.proyecto_nombre)}</div></div>
        <div class="detalle-item"><label>Tipo de Gasto</label><div class="val"><span class="badge ${g.badge_class}">${escapeHtml(g.tipo)}</span></div></div>
        
        <div class="detalle-item"><label>Monto</label><div class="val mono" style="font-weight:700;">${escapeHtml(g.monto_formateado)}</div></div>
        <div class="detalle-item"><label>Proveedor</label><div class="val">${escapeHtml(g.proveedor || 'No especificado')}</div></div>
        <div class="detalle-item"><label>Tipo Documento</label><div class="val">${escapeHtml(g.tipo_documento || '-')}</div></div>
        <div class="detalle-item"><label>Forma de Pago</label><div class="val">${escapeHtml(g.forma_pago || '-')}</div></div>
        <div class="detalle-item"><label>Estatus</label><div class="val">${escapeHtml(g.estatus || '-')}</div></div>
        <div class="detalle-item full"><label>Concepto</label><div class="val">${escapeHtml(g.concepto || '-')}</div></div>
    `;

    openModal('detalleModal');
}
function cerrarModalDetalle() {
    closeModal('detalleModal');
}

/* ============================================================
   MODAL: ELIMINAR
============================================================ */
function abrirModalEliminar(id) {
    deletingId = id;
    openModal('deleteModal');
}
function cerrarModalEliminar() {
    closeModal('deleteModal');
    deletingId = null;
}
async function confirmarEliminar() {
    if (!deletingId) return;
    try {
        const response = await fetch(`${API_URL}/${deletingId}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const result = await response.json();
        if (result.success) {
            mostrarToast('Registro eliminado', 'warning');
            cerrarModalEliminar();
            cargarDatos();
        } else {
            mostrarToast('Error al eliminar', 'error');
        }
    } catch (error) {
        mostrarToast('Error de conexión', 'error');
    }
}

/* ============================================================
   UTILIDADES
============================================================ */
function mostrarToast(msg, tipo = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    const icon = tipo === 'success' ? 'fa-check-circle'
              : tipo === 'warning' ? 'fa-exclamation-triangle'
              : tipo === 'info'    ? 'fa-info-circle'
              : 'fa-times-circle';
    toast.innerHTML = `<i class="fas ${icon}"></i> <span>${escapeHtml(msg)}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function formatMoney(amount) {
    return '$' + Number(amount).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function escapeHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

/* Cerrar modal con ESC */
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal.show').forEach(m => {
            m.classList.remove('show');
        });
        document.body.classList.remove('modal-open');
        deletingId = null;
        editingId  = null;
    }
});

/* Cerrar modal al click en el backdrop (fuera del .modal-dialog) */
document.querySelectorAll('.modal').forEach(m => {
    m.addEventListener('click', (e) => {
        if (e.target === m) {
            m.classList.remove('show');
            if (!document.querySelector('.modal.show')) {
                document.body.classList.remove('modal-open');
            }
            deletingId = null;
            editingId  = null;
        }
    });
});

/* ============================================================
   INICIALIZACIÓN
============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    cargarDatos();
});
</script>
@endsection