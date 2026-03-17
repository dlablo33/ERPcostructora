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
        --sidebar-width: 250px;
        --sidebar-collapsed-width: 80px;
    }

    /* Ajuste para el contenido principal considerando el menú lateral */
    .main-content {
        transition: margin-left 0.3s ease;
        margin-left: var(--sidebar-width);
    }

    /* Cuando el menú está contraído */
    .sidebar-collapsed .main-content {
        margin-left: var(--sidebar-collapsed-width);
    }

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

    .sidebar-collapsed .content {
        max-width: calc(100vw - var(--sidebar-collapsed-width) - 3rem);
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

    .kpi-card .sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    /* Botón Agregar Gasto Indirecto con animación */
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
        position: relative;
        overflow: hidden;
    }

    .btn-agregar:hover {
        background-color: #2CBF1F;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
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

    /* Panel de nuevo gasto indirecto */
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

    /* Estilos de tabla - Mejorados para evitar sobreposición */
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
        min-width: 1200px; /* Ancho mínimo para evitar que se compriman las columnas */
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

    /* Estilo para los iconos de acción - Mejorado */
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
        transform: scale(1.2) rotate(5deg);
        background: rgba(8,60,174,0.1);
    }

    .action-btn.delete:hover {
        color: #dc3545;
        background: rgba(220,53,69,0.1);
    }

    .action-btn i {
        font-size: 14px;
    }

    /* Columna de acciones - Mejorada para no sobreponerse */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
        padding: 8px 12px;
        white-space: nowrap;
    }

    /* Badges de tipo */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
        animation: pulseBadge 2s infinite;
        white-space: nowrap;
    }

    @keyframes pulseBadge {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .badge-administrativo {
        background-color: #083CAE;
        color: white;
    }

    .badge-oficina {
        background-color: #1A4F8C;
        color: white;
    }

    .badge-viaticos {
        background-color: #C4540A;
        color: white;
    }

    .badge-servicios {
        background-color: #1A6644;
        color: white;
    }

    .badge-seguros {
        background-color: #8C6A0A;
        color: white;
    }

    .badge-impuestos {
        background-color: #8C1A1A;
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
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
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

    /* Paginación */
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

    /* Proyectos */
    .project-tag {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 140px;
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
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    /* Toast */
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
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
        z-index: 1100;
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
        padding: 0 15px;
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

    /* Responsive */
    @media (max-width: 1200px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .main-content {
            margin-left: 0 !important;
        }
        
        .content {
            max-width: 100vw !important;
            padding: 1rem;
        }
        
        .semaforo.card {
            margin-left: 0;
            margin-right: 0;
        }
    }

    @media (max-width: 768px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }

        .filters-container {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        #tablaBody td:last-child {
            position: static;
            box-shadow: none;
            background-color: transparent;
        }

        .btn-agregar {
            width: 100%;
            justify-content: center;
        }

        .action-buttons {
            justify-content: flex-start;
        }

        .modal-dialog {
            margin: 50px auto;
        }
    }

    /* Scrollbar personalizada */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #083CAE;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #062D8A;
    }

    /* ========== SOLUCIÓN DE EMERGENCIA PARA EL MENÚ LATERAL ========== */
/* Forzar que el menú lateral esté por encima de todo */
.section-sidebar,
.section-sidebar * {
    z-index: 10050 !important;
}

.section-sidebar.open {
    z-index: 10050 !important;
}

/* Reducir drásticamente el z-index de la barra de pestañas */
.tab-navigation-bar {
    z-index: 9000 !important; /* Muy por debajo del menú */
}

.tab-navigation-bar * {
    z-index: 9001 !important;
}

/* Reducir z-index de los elementos problemáticos de la tabla */
.semaforo .table th {
    z-index: 10 !important; /* Mínimo */
}

.semaforo #tablaBody td:last-child {
    z-index: 5 !important; /* Mínimo */
}

.semaforo .tabs-container {
    position: relative;
    z-index: 1 !important; /* Lo más bajo posible */
}

/* Asegurar que el menú móvil también esté arriba */
.mobile-menu-sidebar {
    z-index: 10060 !important;
}

.quick-sidebar {
    z-index: 10055 !important;
}

/* Ajuste para el contenido principal cuando el menú está abierto */
.section-sidebar.open ~ .main-content-container {
    pointer-events: none; /* Deshabilitar interacción con el contenido */
}

.section-sidebar.open ~ .main-content-container .btn-agregar,
.section-sidebar.open ~ .main-content-container .tab-item,
.section-sidebar.open ~ .main-content-container .filter-select,
.section-sidebar.open ~ .main-content-container .search-box input {
    pointer-events: none; /* Deshabilitar elementos interactivos */
    opacity: 0.7; /* Feedback visual de que está deshabilitado */
}
    
</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Gastos Indirectos por Obra -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header">
                <h2>
                    
                    Gastos Indirectos por Obra
                </h2>
            </div>
            
            <!-- KPIs - Centrados y texto negro -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Total Indirectos</div>
                    <div class="value" id="kpiTotal">$1,847,500</div>
                    <div class="sub">vs presupuesto $1.6M</div>
                </div>
                <div class="kpi-card">
                    <div class="label">% Indirectos</div>
                    <div class="value" id="kpiPorcentaje">18.5%</div>
                    <div class="sub">sobre costo directo</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Administración</div>
                    <div class="value" id="kpiAdmin">$845,200</div>
                    <div class="sub">45.7% del total</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Servicios</div>
                    <div class="value" id="kpiServicios">$482,300</div>
                    <div class="sub">26.1% del total</div>
                </div>
            </div>
            
            <!-- Panel de nuevo gasto indirecto -->
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
                            <input type="text" class="form-control" id="fFolio" placeholder="GIN-2025-XXXX">
                        </div>

                        <div class="form-group">
                            <label>Tipo de Gasto <span class="req">*</span></label>
                            <select class="form-control" id="fTipo">
                                <option value="">— Seleccionar —</option>
                                <optgroup label="Administrativos">
                                    <option value="Administrativo">Gastos Administrativos</option>
                                    <option value="Oficina">Gastos de Oficina</option>
                                    <option value="Papeleria">Papelería</option>
                                    <option value="Comunicaciones">Comunicaciones</option>
                                </optgroup>
                                <optgroup label="Viáticos">
                                    <option value="Viaticos">Viáticos</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Alimentacion">Alimentación</option>
                                    <option value="Hospedaje">Hospedaje</option>
                                </optgroup>
                                <optgroup label="Servicios">
                                    <option value="Servicios">Servicios Generales</option>
                                    <option value="Limpieza">Limpieza</option>
                                    <option value="Seguridad">Seguridad</option>
                                </optgroup>
                                <optgroup label="Seguros">
                                    <option value="Seguros">Seguros</option>
                                    <option value="Fianzas">Fianzas</option>
                                </optgroup>
                                <optgroup label="Impuestos">
                                    <option value="Impuestos">Impuestos y Derechos</option>
                                    <option value="Permisos">Permisos</option>
                                    <option value="Licencias">Licencias</option>
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
                            <label>Partida Indirecta</label>
                            <select class="form-control" id="fPartida">
                                <option value="">— Seleccionar —</option>
                                <option value="ADMIN01">ADMIN01 - Gastos Administrativos</option>
                                <option value="VIA01">VIA01 - Viáticos</option>
                                <option value="SER01">SER01 - Servicios</option>
                                <option value="SEG01">SEG01 - Seguros</option>
                                <option value="IMP01">IMP01 - Impuestos</option>
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
            
            <!-- Barra de acciones con botón a la derecha -->
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 10px;">
                <button class="btn-agregar" onclick="togglePanelNuevoGasto()">
                    <i class="fas fa-plus-circle"></i>
                    Agregar Gasto Indirecto
                </button>
            </div>
            
            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list mr-1"></i> Todos los Gastos
                </div>
                <div class="tab-item" onclick="setTab(this, 'administrativos')">
                    <i class="fas fa-briefcase mr-1"></i> Administrativos
                </div>
                <div class="tab-item" onclick="setTab(this, 'viaticos')">
                    <i class="fas fa-plane mr-1"></i> Viáticos
                </div>
                <div class="tab-item" onclick="setTab(this, 'servicios')">
                    <i class="fas fa-cogs mr-1"></i> Servicios
                </div>
                <div class="tab-item" onclick="setTab(this, 'seguros')">
                    <i class="fas fa-shield-alt mr-1"></i> Seguros
                </div>
                <div class="tab-item" onclick="setTab(this, 'impuestos')">
                    <i class="fas fa-file-invoice mr-1"></i> Impuestos
                </div>
            </div>
            
            <!-- Filtros -->
            <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <div class="filters-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Buscar por folio, proyecto, concepto..." oninput="filtrar()">
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
                    
                    <select class="filter-select" id="filterTipo" onchange="filtrar()">
                        <option value="">Todos los tipos</option>
                        <option value="Administrativo">Administrativos</option>
                        <option value="Oficina">Gastos de Oficina</option>
                        <option value="Viaticos">Viáticos</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Seguros">Seguros</option>
                        <option value="Impuestos">Impuestos</option>
                    </select>
                    
                    <span class="filter-badge" id="filterCount">0</span>
                </div>
            </div>
            
            <!-- Tabla - Contenedor con scroll -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th draggable="true" ondragstart="drag(event)" data-columna="folio">Folio <i class="fas fa-sort" onclick="ordenar('folio')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="fecha">Fecha <i class="fas fa-sort" onclick="ordenar('fecha')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proyecto">Proyecto <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="tipo">Tipo Gasto <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proveedor">Proveedor <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="monto">Monto <i class="fas fa-sort" onclick="ordenar('monto')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="partida">Partida <i class="fas fa-filter"></i></th>
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
                ¿Estás seguro de que deseas eliminar este gasto indirecto? Esta acción <strong>no se puede deshacer</strong>.
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
    'TRC001': '#083CAE', 'PAC002': '#1A4F8C',
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

// Proveedores de servicios indirectos
const proveedores = [
    'Servicios Administrativos SA', 'Oficina Total', 'Papelería El Lápiz',
    'Viáticos Express', 'Transportes Ejecutivos', 'Hoteles del Norte',
    'Seguros Monterrey', 'Fianzas México', 'Consultoría Integral',
    'Limpieza Profesional', 'Seguridad Privada', 'Vigilancia Especializada',
    'Despacho Contable', 'Servicios de Ingeniería', 'Telecomunicaciones MX',
    'Internet Profesional', 'Capacitación Ejecutiva', 'Software Integral',
    'Gestoría Administrativa', 'Servicios Legales', 'Impuestos y Asesoría'
];

// Generar 100 gastos indirectos
let gastos = [];
let nextId = 1;

for (let i = 0; i < 100; i++) {
    const proyectos = Object.keys(proyectoNames);
    const proyecto = proyectos[Math.floor(Math.random() * proyectos.length)];
    
    const tiposPrincipales = ['Administrativo', 'Oficina', 'Viaticos', 'Servicios', 'Seguros', 'Impuestos'];
    const tipo = tiposPrincipales[Math.floor(Math.random() * tiposPrincipales.length)];
    
    const proveedor = proveedores[Math.floor(Math.random() * proveedores.length)];
    const monto = Math.floor(Math.random() * 50000) + 2000;
    const fecha = new Date(2025, Math.floor(Math.random() * 6), Math.floor(Math.random() * 28) + 1);
    const fechaStr = fecha.toISOString().split('T')[0];
    
    const tiposDoc = ['Factura', 'Recibo', 'Comprobante', 'Contrato'];
    const tipoDoc = tiposDoc[Math.floor(Math.random() * tiposDoc.length)];
    
    const formasPago = ['Transferencia', 'Cheque', 'Efectivo', 'Tarjeta'];
    const formaPago = formasPago[Math.floor(Math.random() * formasPago.length)];
    
    const partidas = ['ADMIN01', 'VIA01', 'SER01', 'SEG01', 'IMP01'];
    const partida = partidas[Math.floor(Math.random() * partidas.length)];
    
    const conceptos = [
        'Gastos administrativos generales',
        'Papelería y útiles de oficina',
        'Viáticos personal de supervisión',
        'Servicio de limpieza mensual',
        'Póliza de seguro de obra',
        'Pago de impuestos y derechos',
        'Servicio de vigilancia',
        'Gastos de transporte',
        'Honorarios profesionales',
        'Renta de equipo de oficina',
        'Servicios de comunicación',
        'Capacitación de personal',
        'Gastos de representación',
        'Mantenimiento de equipo',
        'Servicios de consultoría'
    ];
    const concepto = conceptos[Math.floor(Math.random() * conceptos.length)];
    
    gastos.push({
        id: nextId++,
        folio: `GIN-2025-${String(i + 1).padStart(4, '0')}`,
        fecha: fechaStr,
        proyecto: proyecto,
        tipo: tipo,
        proveedor: proveedor,
        monto: monto,
        partida: partida,
        tipoDoc: tipoDoc,
        formaPago: formaPago,
        concepto: concepto
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

// Detectar si el sidebar está colapsado
function checkSidebarState() {
    const body = document.body;
    if (body.classList.contains('sidebar-collapsed')) {
        document.querySelector('.min-h-screen').classList.add('sidebar-collapsed');
    } else {
        document.querySelector('.min-h-screen').classList.remove('sidebar-collapsed');
    }
}

// Observar cambios en el sidebar
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'class') {
            checkSidebarState();
        }
    });
});

observer.observe(document.body, { attributes: true });

// Funciones helper
const fmt = n => '$' + n.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

const fmtFecha = s => { 
    const [y, m, d] = s.split('-'); 
    return `${d} ${['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'][+m-1]} ${y}`; 
};

function getBadgeClass(tipo) {
    switch(tipo) {
        case 'Administrativo': return 'badge-administrativo';
        case 'Oficina': return 'badge-oficina';
        case 'Viaticos': return 'badge-viaticos';
        case 'Servicios': return 'badge-servicios';
        case 'Seguros': return 'badge-seguros';
        case 'Impuestos': return 'badge-impuestos';
        default: return 'badge-administrativo';
    }
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
    const tipo = document.getElementById('fTipo').value;
    
    if (!proyecto || !fecha || !monto || !tipo) { 
        mostrarToast('❌ Completa los campos obligatorios', 'warning'); 
        return; 
    }

    if (monto <= 0) {
        mostrarToast('❌ El monto debe ser mayor a cero', 'warning');
        return;
    }

    const nuevoGasto = {
        id: nextId++,
        folio: document.getElementById('fFolio').value || `GIN-2025-${String(nextId).padStart(4, '0')}`,
        fecha: fecha,
        proyecto: proyecto,
        tipo: tipo,
        proveedor: document.getElementById('fProveedor').value || 'Proveedor no especificado',
        monto: monto,
        partida: document.getElementById('fPartida').value || '—',
        tipoDoc: document.getElementById('fTipoDoc').value,
        formaPago: document.getElementById('fPago').value,
        concepto: document.getElementById('fNotas').value || 'Sin concepto',
    };
    
    gastos.unshift(nuevoGasto);
    
    // Limpiar formulario
    document.getElementById('fProyecto').value = '';
    document.getElementById('fFolio').value = '';
    document.getElementById('fMonto').value = '';
    document.getElementById('fTipo').value = '';
    document.getElementById('fProveedor').value = '';
    document.getElementById('fPartida').value = '';
    document.getElementById('fNotas').value = '';
    
    togglePanelNuevoGasto();
    currentPage = 1; 
    filtrar();
    actualizarKPIs();
    mostrarToast('✅ Gasto indirecto registrado correctamente', 'success');
}

// Filtrar
function getFiltered() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const fP = document.getElementById('filterProyecto')?.value || '';
    const fT = document.getElementById('filterTipo')?.value || '';
    
    return gastos.filter(g => {
        let tabMatch = true;
        if (currentTab === 'administrativos') {
            tabMatch = g.tipo === 'Administrativo' || g.tipo === 'Oficina';
        } else if (currentTab === 'viaticos') {
            tabMatch = g.tipo === 'Viaticos';
        } else if (currentTab === 'servicios') {
            tabMatch = g.tipo === 'Servicios';
        } else if (currentTab === 'seguros') {
            tabMatch = g.tipo === 'Seguros';
        } else if (currentTab === 'impuestos') {
            tabMatch = g.tipo === 'Impuestos';
        }
        
        const searchStr = [g.folio, g.proyecto, g.tipo, g.proveedor, g.concepto, proyectoNames[g.proyecto] || ''].join(' ').toLowerCase();
        const mSrch = !q || searchStr.includes(q);
        const mP = !fP || g.proyecto === fP;
        const mT = !fT || g.tipo === fT;
        
        return tabMatch && mSrch && mP && mT;
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
        body.innerHTML = `<tr><td colspan="8" style="text-align: center; padding: 40px;">
            <div style="padding: 40px 20px; text-align: center;">
                <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
                <p style="font-size: 13px; color: #868e96; margin-top: 10px;">No se encontraron gastos indirectos</p>
            </div>
        </td></tr>`;
    } else {
        body.innerHTML = slice.map(g => {
            const color = proyectoColors[g.proyecto] || '#888';
            const badgeClass = getBadgeClass(g.tipo);
            
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
                <td><span class="badge ${badgeClass}">${g.tipo}</span></td>
                <td>${g.proveedor}</td>
                <td class="text-right"><span class="mono" style="font-weight:700">${fmt(g.monto)}</span></td>
                <td>${g.partida}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn" onclick="verDetalle(${g.id})" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn" onclick="editarGasto(${g.id})" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete" onclick="abrirModal(${g.id})" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    // Totales
    const totalMonto = gastosFiltrados.reduce((a, b) => a + b.monto, 0);
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="5" style="text-align: right; font-weight:600;">Total filtrado:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalMonto)}</span></td>
        <td colspan="2"></td>
    </tr>`;
    
    actualizarKPIs();
}

// Actualizar KPIs
function actualizarKPIs() {
    const total = gastos.reduce((a, b) => a + b.monto, 0);
    const administrativos = gastos.filter(g => g.tipo === 'Administrativo' || g.tipo === 'Oficina').reduce((a, b) => a + b.monto, 0);
    const servicios = gastos.filter(g => g.tipo === 'Servicios').reduce((a, b) => a + b.monto, 0);
    const porcentaje = ((total / 10000000) * 100).toFixed(1);
    
    document.getElementById('kpiTotal').textContent = fmt(total);
    document.getElementById('kpiPorcentaje').textContent = porcentaje + '%';
    document.getElementById('kpiAdmin').textContent = fmt(administrativos);
    document.getElementById('kpiServicios').textContent = fmt(servicios);
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
    if (g) mostrarToast(`${g.folio} - ${g.concepto} - ${fmt(g.monto)}`, 'info'); 
}

// Editar
function editarGasto(id) {
    const g = gastos.find(x => x.id === id); 
    if (!g) return;
    
    document.getElementById('fProyecto').value = g.proyecto;
    document.getElementById('fFolio').value = g.folio;
    document.getElementById('fFecha').value = g.fecha;
    document.getElementById('fMonto').value = g.monto;
    document.getElementById('fTipo').value = g.tipo;
    document.getElementById('fProveedor').value = g.proveedor;
    document.getElementById('fPartida').value = g.partida !== '—' ? g.partida : '';
    document.getElementById('fTipoDoc').value = g.tipoDoc;
    document.getElementById('fPago').value = g.formaPago;
    document.getElementById('fNotas').value = g.concepto;
    
    const panel = document.getElementById('panelNuevoGasto');
    if (!panel.classList.contains('show')) {
        panel.classList.add('show');
    }
    
    mostrarToast(`Editando: ${g.folio}`, 'info');
    window.scrollTo({ top: 200, behavior: 'smooth' });
}

// Drag and drop
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.getAttribute('data-columna'));
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
    checkSidebarState();
    
    // Escuchar cambios en el tamaño de la ventana
    window.addEventListener('resize', checkSidebarState);
});
</script>

@endsection