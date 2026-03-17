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

    /* Estilos de tarjeta principal */
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

    /* KPIs - Centrados y texto negro */
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

    /* Botón Agregar Gasto con animación */
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

    .btn-agregar i {
        transition: transform 0.3s ease;
    }

    .btn-agregar:hover i {
        transform: rotate(90deg);
    }

    .btn-agregar::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-agregar:active::after {
        width: 300px;
        height: 300px;
    }

    /* Panel de nuevo gasto */
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

    /* Estilos de tabla */
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

    /* Estilo para las filas */
    #tablaBody tr {
        transition: all 0.3s ease;
        animation: fadeInRow 0.3s ease;
    }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    /* Estilo para los iconos de acción */
    #tablaBody td i {
        transition: all 0.3s ease;
        font-size: 14px;
        color: #083CAE;
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

    /* Columna de acciones fija */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
    }

    /* Badges de estatus */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
        animation: pulseBadge 2s infinite;
    }

    @keyframes pulseBadge {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
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

    /* Filtros y búsqueda */
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
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(8,60,174,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(8,60,174,0); }
        100% { box-shadow: 0 0 0 0 rgba(8,60,174,0); }
    }

    /* Tabs */
    .tabs-container {
        display: flex;
        gap: 2px;
        padding: 0 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
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

    /* Área de agrupación - sin texto */
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
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    .btn-icon {
        background: transparent;
        border: 1px solid #083CAE;
        border-radius: 20px;
        color: #083CAE;
        cursor: pointer;
        padding: 6px 15px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-icon:hover {
        background-color: #083CAE;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
    }

    /* Paginación */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: transparent;
        border-top: 1px solid #e5e7eb;
    }

    .pagination-info {
        color: #000000;
        font-size: 13px;
    }

    .pagination-controls {
        display: flex;
        gap: 5px;
        align-items: center;
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

    /* Proyectos */
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

    /* Progress bar */
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

    /* Toast */
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
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease;
        border-left: 4px solid;
    }

    .toast.success {
        border-left-color: #28a745;
    }

    .toast.success i {
        color: #28a745;
    }

    .toast.warning {
        border-left-color: #ffc107;
    }

    .toast.warning i {
        color: #ffc107;
    }

    .toast.error {
        border-left-color: #dc3545;
    }

    .toast.error i {
        color: #dc3545;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Modal */
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

    .modal.show {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-dialog {
        max-width: 400px;
        margin: 100px auto;
        animation: slideInDown 0.3s ease;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
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
        transition: opacity 0.3s;
    }

    .modal-header.danger-header .close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 20px;
        font-size: 13.5px;
        color: #495057;
    }

    .modal-footer {
        padding: 12px 16px;
        background: #f8f9fa;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-container {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .grupo-agrupacion {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-icon {
            width: 100%;
            justify-content: center;
        }

        #tablaBody td:last-child {
            position: static;
            box-shadow: none;
        }

        .btn-agregar {
            margin-left: 0;
            width: 100%;
            justify-content: center;
        }
    }

    /* Drag and drop */
    [draggable="true"] {
        cursor: grab;
    }
    
    [draggable="true"]:active {
        cursor: grabbing;
        opacity: 0.7;
    }
    
    .drag-over .grupo-columnas {
        background-color: rgba(8,60,174,0.1);
        border-radius: 4px;
        padding: 5px;
    }

    /* Table container */
    .table-container {
        overflow-x: auto;
        max-height: 500px;
        overflow-y: auto;
        width: 100%;
        background: white;
    }

    /* Estilo para el pie de tabla */
    tfoot td {
        font-weight: bold;
        background-color: #e9ecef !important;
        border-top: 2px solid #083CAE;
        color: #000000 !important;
    }

    /* Monospace para números */
    .mono {
        font-family: 'SFMono-Regular', Consolas, monospace;
        font-size: 12px;
        color: #000000;
    }

    /* Texto a la derecha */
    .text-right {
        text-align: right;
    }

    /* Centrar texto */
    .text-center {
        text-align: center;
    }

    /* =========================================================================================== */
    /* ========== SOLUCIÓN: MENÚ LATERAL SOBRE LAS TABS ========== */
/* Asegurar que el menú lateral esté por encima de todo */
.section-sidebar {
    z-index: 10010 !important; /* Mayor que el z-index de la barra de pestañas (10000) */
}

/* Reducir z-index de la barra de pestañas del layout */
.tab-navigation-bar {
    z-index: 9990 !important; /* Por debajo del menú lateral */
}

/* Ajustar elementos internos de la barra de pestañas */
.tabs-container-nav,
.tab-item,
.close-all-tabs-container {
    z-index: 9991 !important;
}

/* Reducir z-index de los elementos de la tabla que estaban interfiriendo */
.semaforo .table th {
    z-index: 15 !important; /* Reducido de 20 a 15 */
}

.semaforo #tablaBody td:last-child {
    z-index: 10 !important; /* Reducido de 15 a 10 */
}

/* Ajuste para el menú de favoritos */
.quick-sidebar {
    z-index: 10009 !important; /* Por debajo del menú principal */
}

/* Ajuste para el menú móvil */
.mobile-menu-sidebar {
    z-index: 10020 !important; /* Mayor en móvil */
}

.mobile-overlay {
    z-index: 10015 !important;
}

/* Cuando el menú está abierto, reducir interacción con el contenido */
.section-sidebar.open ~ .main-content-container {
    pointer-events: none; /* Evita clics en elementos detrás */
}

.section-sidebar.open ~ .main-content-container .semaforo.card {
    pointer-events: auto; /* Permite interacción con la tarjeta si es necesario */
}

/* Ajuste responsive para móvil */
@media (max-width: 992px) {
    .section-sidebar {
        z-index: 10030 !important; /* Aún más alto en móvil */
    }
    
    .tab-navigation-bar {
        z-index: 9995 !important;
    }
    
    .mobile-menu-sidebar {
        z-index: 10040 !important;
    }
}

</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Facturacion / Gastos por Proyecto -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header">
                <h2>
                    
                    Asignación de Gastos por Proyecto
                </h2>
            </div>
            
            <!-- KPIs - Centrados y texto negro -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Gasto Total del Mes</div>
                    <div class="value" id="kpiTotal">$4,245,800</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Proyectos Activos</div>
                    <div class="value" id="kpiProyectos">15</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Gastos Aprobados</div>
                    <div class="value" id="kpiAprobados">$2,845,600</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Pendientes</div>
                    <div class="value" id="kpiPendientes">$1,400,200</div>
                </div>
            </div>
            
            <!-- Panel de nuevo gasto -->
            <div class="panel-nuevo-gasto" id="panelNuevoGasto">
                <form id="gastoForm" onsubmit="return false">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Proyecto <span class="req">*</span></label>
                            <select class="form-control" id="fProyecto">
                                <option value="">— Seleccionar —</option>
                                <option value="TRC001">TRC001 - Torre Residencial Cumbres</option>
                                <option value="PAC002">PAC002 - Puente Av. Constitución</option>
                                <option value="CIA003">CIA003 - Complejo Industrial Apodaca</option>
                                <option value="RHR004">RHR004 - Hospital Regional</option>
                                <option value="VPS005">VPS005 - Vialidad Periférico Sur</option>
                                <option value="PGA006">PGA006 - Plaza Galerías Monterrey</option>
                                <option value="CCM007">CCM007 - Centro Comercial Metropolitano</option>
                                <option value="UAN008">UAN008 - Unidad Habitacional Anáhuac</option>
                                <option value="PIR009">PIR009 - Parque Industrial Roble</option>
                                <option value="EST010">EST010 - Estadio Universitario</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fecha <span class="req">*</span></label>
                            <input type="date" class="form-control" id="fFecha" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label>Folio</label>
                            <input type="text" class="form-control" id="fFolio" placeholder="FAC-2025-XXXX">
                        </div>

                        <div class="form-group">
                            <label>Categoría <span class="req">*</span></label>
                            <select class="form-control" id="fCategoria">
                                <option value="">— Seleccionar —</option>
                                <optgroup label="Materiales">
                                    <option value="Concreto">Concreto Premezclado</option>
                                    <option value="Acero">Acero de Refuerzo</option>
                                    <option value="Block">Block y Tabique</option>
                                    <option value="Cemento">Cemento Gris</option>
                                    <option value="Varilla">Varilla Corrugada</option>
                                    <option value="Madera">Madera para Cimbra</option>
                                    <option value="Tuberia">Tubería PVC</option>
                                    <option value="Cable">Cable Eléctrico</option>
                                    <option value="Pintura">Pintura Vinílica</option>
                                </optgroup>
                                <optgroup label="Mano de Obra">
                                    <option value="Albañiles">Cuadrilla de Albañiles</option>
                                    <option value="Electricistas">Electricistas</option>
                                    <option value="Plomeros">Plomeros</option>
                                    <option value="Carpinteros">Carpinteros</option>
                                    <option value="Herreros">Herreros</option>
                                    <option value="Ingenieros">Ingenieros Residentes</option>
                                </optgroup>
                                <optgroup label="Maquinaria">
                                    <option value="Retroexcavadora">Renta de Retroexcavadora</option>
                                    <option value="Grua">Grúa Torre</option>
                                    <option value="Montacargas">Montacargas</option>
                                    <option value="Compactadora">Compactadora</option>
                                    <option value="Revolvedora">Revolvedora de Concreto</option>
                                </optgroup>
                                <optgroup label="Servicios">
                                    <option value="Seguridad">Servicio de Seguridad</option>
                                    <option value="Limpieza">Limpieza de Obra</option>
                                    <option value="RentaBaños">Renta de Baños Portátiles</option>
                                </optgroup>
                                <optgroup label="Administrativo">
                                    <option value="Permisos">Permisos y Licencias</option>
                                    <option value="Seguros">Seguros de Obra</option>
                                    <option value="Honorarios">Honorarios Profesionales</option>
                                    <option value="Combustible">Combustible</option>
                                </optgroup>
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
                                <option>Nómina</option>
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
                </form>
            </div>
            
            <!-- Área de agrupación - sin texto -->
            <div class="grupo-agrupacion" id="grupoAgrupacion">
                <div class="grupo-columnas" id="grupoColumnas"></div>
                <button class="btn-agregar" onclick="togglePanelNuevoGasto()">
                    <i class="fas fa-plus-circle"></i>
                    Agregar Nuevo Gasto
                </button>
            </div>
            
            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list mr-1"></i> Todos los Gastos
                </div>
                <div class="tab-item" onclick="setTab(this, 'pendientes')">
                    <i class="fas fa-hourglass-half mr-1"></i> Pendientes
                </div>
                <div class="tab-item" onclick="setTab(this, 'aprobados')">
                    <i class="fas fa-check-circle mr-1"></i> Aprobados
                </div>
                <div class="tab-item" onclick="setTab(this, 'rechazados')">
                    <i class="fas fa-times-circle mr-1"></i> Rechazados
                </div>
            </div>
            
            <!-- Filtros -->
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <div class="filters-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Buscar por folio, proyecto, proveedor..." oninput="filtrar()">
                    </div>
                    
                    <select class="filter-select" id="filterProyecto" onchange="filtrar()">
                        <option value="">Todos los proyectos</option>
                        <option value="TRC001">TRC001 - Torre Cumbres</option>
                        <option value="PAC002">PAC002 - Puente Constitución</option>
                        <option value="CIA003">CIA003 - Complejo Apodaca</option>
                        <option value="RHR004">RHR004 - Hospital Regional</option>
                        <option value="VPS005">VPS005 - Periférico Sur</option>
                        <option value="PGA006">PGA006 - Plaza Galerías</option>
                        <option value="CCM007">CCM007 - Centro Comercial</option>
                        <option value="UAN008">UAN008 - Unidad Anáhuac</option>
                        <option value="PIR009">PIR009 - Parque Roble</option>
                        <option value="EST010">EST010 - Estadio</option>
                    </select>
                    
                    <select class="filter-select" id="filterCategoria" onchange="filtrar()">
                        <option value="">Todas categorías</option>
                        <option value="Materiales">Materiales</option>
                        <option value="Mano de Obra">Mano de Obra</option>
                        <option value="Maquinaria">Maquinaria</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Administrativo">Administrativo</option>
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
                            <th draggable="true" ondragstart="drag(event)" data-columna="folio">Folio <i class="fas fa-sort" onclick="ordenar('folio')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="fecha">Fecha <i class="fas fa-sort" onclick="ordenar('fecha')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proyecto">Proyecto <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="categoria">Categoría <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proveedor">Proveedor <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="monto">Monto <i class="fas fa-sort" onclick="ordenar('monto')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="avance">Avance <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="estatus">Estatus <i class="fas fa-filter"></i></th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaBody"></tbody>
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
                    <button class="page-btn" onclick="cambiarPagina(1)" id="btnSiguiente">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header danger-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar eliminación
                </h5>
                <button type="button" class="close" onclick="cerrarModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este gasto? Esta acción <strong>no se puede deshacer</strong>.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button type="button" class="btn-guardar" style="background: #dc3545;" onclick="confirmarEliminar()">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Datos de proyectos
const proyectoColors = {
    'TRC001': '#C4540A', 'PAC002': '#1A4F8C',
    'CIA003': '#1A6644', 'RHR004': '#8C6A0A', 'VPS005': '#6B1A8C',
    'PGA006': '#9C27B0', 'CCM007': '#FF9800', 'UAN008': '#00BCD4',
    'PIR009': '#4CAF50', 'EST010': '#E91E63'
};

const proyectoNames = {
    'TRC001': 'Torre Residencial Cumbres',
    'PAC002': 'Puente Av. Constitución',
    'CIA003': 'Complejo Industrial Apodaca',
    'RHR004': 'Hospital Regional',
    'VPS005': 'Vialidad Periférico Sur',
    'PGA006': 'Plaza Galerías Monterrey',
    'CCM007': 'Centro Comercial Metropolitano',
    'UAN008': 'Unidad Habitacional Anáhuac',
    'PIR009': 'Parque Industrial Roble',
    'EST010': 'Estadio Universitario'
};

// Proveedores
const proveedores = [
    'CEMEX México', 'Grupo Acerero', 'Ferrecarril SA', 'Constructora del Norte',
    'Materiales Monterrey', 'Cementos Mexicanos', 'Aceros Corsa', 'Vibrotech',
    'Maquinaria Pesada SA', 'Rentex', 'Andamios del Norte', 'Rotoplas',
    'Urrea Herramientas', 'Trueper', 'Home Depot Pro', 'Pinturas Berel',
    'Comex', 'Sherwin Williams', 'Interceramic', 'Grupo Lamosa',
    'Daltile México', 'Helvex', 'Iusa', 'Ternium', 'Deacero',
    'Aceros Ocotlán', 'Gerdau Corsa', 'ArcelorMittal', 'Grupo SIMEC',
    'Tubacero', 'Tuberías Procarsa', 'Grupo IUSA', 'Conduit',
    'Voltech', 'Luminis', 'Philips', 'PEMEX', 'Gas LP Monterrey',
    'Servicios de Agua', 'CFE', 'Telcel', 'Telmex', 'Totalplay',
    'Seguros BBVA', 'Seguros Monterrey', 'GNP Seguros', 'Quálitas',
    'Ingeniería Estructural SA', 'Arquitectura Integral', 'Topografía del Norte',
    'Seguridad Privada Profesional', 'Limpieza Industrial', 'Baños Portátiles del Norte',
    'Grúas Monterrey', 'Transportes Especializados', 'Logística Integral'
];

// Generar 100 gastos
let gastos = [];
let nextId = 1;

for (let i = 0; i < 100; i++) {
    const proyectos = Object.keys(proyectoNames);
    const proyecto = proyectos[Math.floor(Math.random() * proyectos.length)];
    const categorias = ['Concreto', 'Acero', 'Block', 'Cemento', 'Varilla', 'Madera', 'Tuberia', 'Cable', 'Pintura', 'Albañiles', 'Electricistas', 'Plomeros', 'Retroexcavadora', 'Grua', 'Montacargas', 'Seguridad', 'Limpieza', 'Permisos', 'Seguros', 'Honorarios', 'Combustible'];
    const categoria = categorias[Math.floor(Math.random() * categorias.length)];
    const proveedor = proveedores[Math.floor(Math.random() * proveedores.length)];
    const estatuses = ['Aprobado', 'Pendiente', 'Rechazado', 'En revisión'];
    const estatus = estatuses[Math.floor(Math.random() * estatuses.length)];
    const monto = Math.floor(Math.random() * 200000) + 5000;
    const avance = Math.floor(Math.random() * 101);
    const fecha = new Date(2025, Math.floor(Math.random() * 3), Math.floor(Math.random() * 28) + 1);
    const fechaStr = fecha.toISOString().split('T')[0];
    const tiposDoc = ['Factura', 'Nota de Remisión', 'Recibo', 'Nómina', 'Contrato'];
    const tipoDoc = tiposDoc[Math.floor(Math.random() * tiposDoc.length)];
    const partidas = ['CIMENTACION', 'ESTRUCTURA', 'ALBAÑILERIA', 'ACABADOS', 'INSTALACIONES', 'ELECTRICAS'];
    const partida = partidas[Math.floor(Math.random() * partidas.length)];
    
    gastos.push({
        id: nextId++,
        folio: `FAC-2025-${String(i + 1).padStart(4, '0')}`,
        fecha: fechaStr,
        proyecto: proyecto,
        categoria: categoria,
        proveedor: proveedor,
        monto: monto,
        partida: partida,
        tipoDoc: tipoDoc,
        estatus: estatus,
        avance: avance,
        notas: `Nota del gasto ${i + 1}`
    });
}

// Variables globales
let gastosFiltrados = [...gastos];
let deletingId = null;
let currentTab = 'todos';
let currentPage = 1;
const PER_PAGE = 10;
let sortKey = 'fecha';
let sortDir = -1;
let columnasAgrupadas = [];

// Funciones helper
const fmt = n => '$' + n.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

const fmtFecha = s => { 
    const [y, m, d] = s.split('-'); 
    return `${d} ${['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'][+m-1]} ${y}`; 
};

function catGrupo(c) {
    const materiales = ['Concreto', 'Acero', 'Block', 'Cemento', 'Varilla', 'Madera', 'Tuberia', 'Cable', 'Pintura'];
    const manoObra = ['Albañiles', 'Electricistas', 'Plomeros', 'Carpinteros', 'Herreros', 'Ingenieros'];
    const maquinaria = ['Retroexcavadora', 'Grua', 'Montacargas', 'Compactadora', 'Revolvedora'];
    const servicios = ['Seguridad', 'Limpieza', 'RentaBaños'];
    const administrativo = ['Permisos', 'Seguros', 'Honorarios', 'Combustible'];
    
    if (materiales.includes(c)) return 'Materiales';
    if (manoObra.includes(c)) return 'Mano de Obra';
    if (maquinaria.includes(c)) return 'Maquinaria';
    if (servicios.includes(c)) return 'Servicios';
    return 'Administrativo';
}

// Panel de nuevo gasto
function togglePanelNuevoGasto() {
    const panel = document.getElementById('panelNuevoGasto');
    panel.classList.toggle('show');
    if (panel.classList.contains('show')) {
        document.getElementById('fFecha').value = new Date().toISOString().split('T')[0];
    }
}

// Agregar gasto
function agregarGasto() {
    const proyecto = document.getElementById('fProyecto').value;
    const fecha = document.getElementById('fFecha').value;
    const monto = parseFloat(document.getElementById('fMonto').value);
    const categoria = document.getElementById('fCategoria').value;
    
    if (!proyecto || !fecha || !monto || !categoria) { 
        mostrarToast('❌ Completa los campos obligatorios', 'warning'); 
        return; 
    }

    if (monto <= 0) {
        mostrarToast('❌ El monto debe ser mayor a cero', 'warning');
        return;
    }

    const nuevoGasto = {
        id: nextId++,
        folio: document.getElementById('fFolio').value || `FAC-2025-${String(nextId).padStart(4, '0')}`,
        fecha: fecha,
        proyecto: proyecto,
        categoria: categoria,
        proveedor: document.getElementById('fProveedor').value || 'Proveedor no especificado',
        monto: monto,
        partida: document.getElementById('fPartida').value || '—',
        tipoDoc: document.getElementById('fTipoDoc').value,
        estatus: document.getElementById('fEstatus').value,
        avance: Math.floor(Math.random() * 60) + 20,
        notas: document.getElementById('fNotas').value || 'Sin notas',
    };
    
    gastos.unshift(nuevoGasto);
    
    // Limpiar formulario
    document.getElementById('fProyecto').value = '';
    document.getElementById('fFolio').value = '';
    document.getElementById('fMonto').value = '';
    document.getElementById('fCategoria').value = '';
    document.getElementById('fProveedor').value = '';
    document.getElementById('fPartida').value = '';
    document.getElementById('fNotas').value = '';
    document.getElementById('fTipoDoc').value = 'Factura';
    document.getElementById('fEstatus').value = 'Pendiente';
    
    togglePanelNuevoGasto();
    currentPage = 1; 
    filtrar();
    actualizarKPIs();
    mostrarToast('✅ Gasto registrado correctamente', 'success');
}

// Filtrar
function getFiltered() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const fP = document.getElementById('filterProyecto')?.value || '';
    const fC = document.getElementById('filterCategoria')?.value || '';
    const fE = document.getElementById('filterEstatus')?.value || '';
    
    return gastos.filter(g => {
        let tabMatch = true;
        if (currentTab === 'pendientes') {
            tabMatch = g.estatus === 'Pendiente' || g.estatus === 'En revisión';
        } else if (currentTab === 'aprobados') {
            tabMatch = g.estatus === 'Aprobado';
        } else if (currentTab === 'rechazados') {
            tabMatch = g.estatus === 'Rechazado';
        }
        
        const searchStr = [g.folio, g.proyecto, g.categoria, g.proveedor, proyectoNames[g.proyecto] || '', g.estatus].join(' ').toLowerCase();
        const mSrch = !q || searchStr.includes(q);
        const mP = !fP || g.proyecto === fP;
        const mC = !fC || catGrupo(g.categoria) === fC;
        const mE = !fE || g.estatus === fE;
        
        return tabMatch && mSrch && mP && mC && mE;
    }).sort((a, b) => {
        let av = a[sortKey], bv = b[sortKey];
        if (sortKey === 'monto') {
            av = +av;
            bv = +bv;
        }
        if (sortKey === 'fecha') {
            av = new Date(av);
            bv = new Date(bv);
        }
        return av < bv ? -sortDir : av > bv ? sortDir : 0;
    });
}

// Renderizar tabla
function renderTabla() {
    gastosFiltrados = getFiltered();
    const total = gastosFiltrados.length;
    const pages = Math.ceil(total / PER_PAGE) || 1;
    
    if (currentPage > pages) currentPage = pages;
    if (currentPage < 1) currentPage = 1;
    
    const start = (currentPage - 1) * PER_PAGE;
    const slice = gastosFiltrados.slice(start, start + PER_PAGE);

    document.getElementById('filterCount').textContent = total;
    document.getElementById('footerInfo').textContent = `${slice.length} de ${total} registros`;
    document.getElementById('pageNum').textContent = currentPage;
    
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === pages;

    const body = document.getElementById('tablaBody');
    
    if (!slice.length) {
        body.innerHTML = `<tr><td colspan="9" style="text-align: center; padding: 40px;">
            <div style="padding: 40px 20px; text-align: center;">
                <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
                <p style="font-size: 13px; color: #868e96; margin-top: 10px;">No se encontraron gastos</p>
            </div>
        </td></tr>`;
    } else {
        body.innerHTML = slice.map(g => {
            const color = proyectoColors[g.proyecto] || '#888';
            const badgeCls = g.estatus === 'Aprobado' ? 'badge-aprobado' : 
                            g.estatus === 'Rechazado' ? 'badge-rechazado' : 
                            g.estatus === 'En revisión' ? 'badge-revision' : 'badge-pendiente';
            const fillCls = g.avance >= 90 ? 'danger' : g.avance >= 70 ? 'warn' : '';
            
            return `<tr>
                <td><span class="mono">${g.folio}</span></td>
                <td>${fmtFecha(g.fecha)}</td>
                <td>
                    <div class="project-tag">
                        <div class="project-dot" style="background:${color}"></div>
                        <div>
                            <div class="project-code">${g.proyecto}</div>
                            <div class="project-name">${proyectoNames[g.proyecto] || ''}</div>
                        </div>
                    </div>
                </td>
                <td>${g.categoria}</td>
                <td>${g.proveedor}</td>
                <td class="text-right"><span class="mono" style="font-weight:700">${fmt(g.monto)}</span></td>
                <td>
                    <div class="progress-wrap">
                        <div class="progress-bar-erp">
                            <div class="progress-fill ${fillCls}" style="width:${g.avance}%"></div>
                        </div>
                        <span class="progress-pct">${g.avance}%</span>
                    </div>
                </td>
                <td><span class="badge ${badgeCls}">${g.estatus}</span></td>
                <td>
                    <i class="fas fa-eye" title="Ver detalle" onclick="verDetalle(${g.id})"></i>
                    <i class="fas fa-edit" title="Editar" onclick="editarGasto(${g.id})"></i>
                    <i class="fas fa-trash" title="Eliminar" onclick="abrirModal(${g.id})" style="color:#dc3545;"></i>
                </td>
            </tr>`;
        }).join('');
    }

    // Totales
    const totalMonto = gastosFiltrados.reduce((a, b) => a + b.monto, 0);
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="5" style="text-align: right; font-weight:600;">Total filtrado:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalMonto)}</span></td>
        <td colspan="3"></td>
    </tr>`;
    
    actualizarKPIs();
}

// Actualizar KPIs
function actualizarKPIs() {
    const total = gastos.reduce((a, b) => a + b.monto, 0);
    const aprobados = gastos.filter(g => g.estatus === 'Aprobado').reduce((a, b) => a + b.monto, 0);
    const pendientes = gastos.filter(g => g.estatus === 'Pendiente' || g.estatus === 'En revisión').reduce((a, b) => a + b.monto, 0);
    const proyectos = new Set(gastos.map(g => g.proyecto)).size;
    
    document.getElementById('kpiTotal').textContent = fmt(total);
    document.getElementById('kpiProyectos').textContent = proyectos;
    document.getElementById('kpiAprobados').textContent = fmt(aprobados);
    document.getElementById('kpiPendientes').textContent = fmt(pendientes);
}

// Mostrar toast
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

// Filtrar
function filtrar() { 
    currentPage = 1; 
    renderTabla(); 
}

// Cambiar tab
function setTab(el, tab) {
    document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    currentTab = tab;
    currentPage = 1;
    renderTabla();
}

// Ordenar
function ordenar(key) { 
    if (sortKey === key) {
        sortDir *= -1;
    } else {
        sortKey = key;
        sortDir = 1;
    }
    renderTabla(); 
}

// Cambiar página
function cambiarPagina(dir) { 
    const pages = Math.ceil(getFiltered().length / PER_PAGE) || 1; 
    currentPage = Math.max(1, Math.min(pages, currentPage + dir)); 
    renderTabla(); 
}

// Drag and drop
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.getAttribute('data-columna'));
}

document.getElementById('grupoAgrupacion').addEventListener('dragover', function(ev) {
    ev.preventDefault();
    this.classList.add('drag-over');
});

document.getElementById('grupoAgrupacion').addEventListener('dragleave', function(ev) {
    this.classList.remove('drag-over');
});

document.getElementById('grupoAgrupacion').addEventListener('drop', function(ev) {
    ev.preventDefault();
    this.classList.remove('drag-over');
    const columna = ev.dataTransfer.getData("text");
    
    if (columna && !columnasAgrupadas.includes(columna)) {
        columnasAgrupadas.push(columna);
        actualizarGrupoColumnas();
        mostrarToast(`Columna ${columna} agregada`, 'success');
    }
});

function actualizarGrupoColumnas() {
    const container = document.getElementById('grupoColumnas');
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

document.getElementById('btnCrearFiltro').addEventListener('click', function() {
    if (columnasAgrupadas.length > 0) {
        mostrarToast(`Filtro creado por: ${columnasAgrupadas.join(', ')}`, 'success');
    } else {
        mostrarToast('Arrastra columnas primero', 'warning');
    }
});

// Modal
function abrirModal(id) { 
    deletingId = id; 
    document.getElementById('deleteModal').classList.add('show');
}

function cerrarModal() {
    document.getElementById('deleteModal').classList.remove('show');
    deletingId = null;
}

function confirmarEliminar() { 
    gastos = gastos.filter(g => g.id !== deletingId); 
    cerrarModal();
    renderTabla(); 
    mostrarToast('Registro eliminado', 'warning'); 
}

// Ver detalle
function verDetalle(id) { 
    const g = gastos.find(x => x.id === id); 
    if (g) mostrarToast(`${g.folio} - ${fmt(g.monto)} - ${g.estatus}`, 'info'); 
}

// Editar
function editarGasto(id) {
    const g = gastos.find(x => x.id === id); 
    if (!g) return;
    
    document.getElementById('fProyecto').value = g.proyecto;
    document.getElementById('fFolio').value = g.folio;
    document.getElementById('fFecha').value = g.fecha;
    document.getElementById('fMonto').value = g.monto;
    document.getElementById('fCategoria').value = g.categoria;
    document.getElementById('fProveedor').value = g.proveedor;
    document.getElementById('fPartida').value = g.partida !== '—' ? g.partida : '';
    document.getElementById('fTipoDoc').value = g.tipoDoc;
    document.getElementById('fEstatus').value = g.estatus;
    document.getElementById('fNotas').value = g.notas;
    
    const panel = document.getElementById('panelNuevoGasto');
    if (!panel.classList.contains('show')) {
        panel.classList.add('show');
    }
    
    mostrarToast(`Editando: ${g.folio}`, 'info');
    window.scrollTo({ top: 200, behavior: 'smooth' });
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        cerrarModal();
    }
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    renderTabla();
});
</script>

@endsection