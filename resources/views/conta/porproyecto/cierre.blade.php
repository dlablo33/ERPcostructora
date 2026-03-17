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
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
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

    /* Selector de período */
    .periodo-selector {
        display: flex;
        gap: 15px;
        align-items: center;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        flex-wrap: wrap;
    }

    .periodo-tabs {
        display: flex;
        gap: 5px;
        background: white;
        padding: 4px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .periodo-tab {
        padding: 6px 15px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s ease;
        background: transparent;
        border: none;
    }

    .periodo-tab:hover {
        color: #083CAE;
        background: rgba(8,60,174,0.05);
    }

    .periodo-tab.active {
        background: #083CAE;
        color: white;
    }

    .filtro-fechas {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    .date-input {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        color: #000000;
    }

    .date-input:focus {
        outline: none;
        border-color: #083CAE;
    }

    /* Botones de acción */
    .btn-icon {
        background: transparent;
        border: 1px solid #083CAE;
        border-radius: 20px;
        color: #083CAE;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 13px;
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

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,193,7,0.3);
    }

    /* Panel de cierre */
    .cierre-panel {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
    }

    .cierre-panel.show {
        max-height: 600px;
        padding: 20px;
    }

    .resumen-cierre {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .resumen-item {
        background: white;
        border-radius: 8px;
        padding: 15px;
        border: 1px solid #e5e7eb;
    }

    .resumen-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .resumen-value {
        font-size: 20px;
        font-weight: 700;
        color: #083CAE;
    }

    .resumen-detalle {
        font-size: 11px;
        color: #6b7280;
        margin-top: 5px;
    }

    .checks-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin: 15px 0;
    }

    .check-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        background: white;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .check-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .check-item label {
        font-size: 12px;
        color: #000000;
        cursor: pointer;
        flex: 1;
    }

    /* Tabla de proyectos para cierre */
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
        min-width: 1400px;
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

    /* Badges de estatus de cierre */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-cerrado {
        background-color: #28a745;
        color: white;
    }

    .badge-proceso {
        background-color: #ffc107;
        color: black;
    }

    .badge-pendiente {
        background-color: #dc3545;
        color: white;
    }

    .badge-revision {
        background-color: #17a2b8;
        color: white;
    }

    /* Barra de progreso de cierre */
    .progress-cierre {
        width: 100px;
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        display: inline-block;
        margin-right: 8px;
    }

    .progress-cierre-fill {
        height: 100%;
        background: #083CAE;
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    .progress-cierre-fill.completado {
        background: #28a745;
    }

    .progress-cierre-fill.proceso {
        background: #ffc107;
    }

    .cierre-porcentaje {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
    }

    /* Botones de acción en tabla */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
        justify-content: flex-end;
        min-width: 120px;
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

    .action-btn.cerrar:hover {
        color: #28a745;
        background: rgba(40,167,69,0.1);
    }

    .action-btn.reporte:hover {
        color: #17a2b8;
        background: rgba(23,162,184,0.1);
    }

    .action-btn i {
        font-size: 14px;
    }

    /* Columna de acciones fija */
    #tablaBody td:last-child {
        background-color: white;
        position: sticky;
        right: 0;
        box-shadow: -2px 0 5px rgba(0,0,0,0.1);
        z-index: 15;
        padding: 8px 12px;
        white-space: nowrap;
    }

    /* Filtros */
    .filters-container {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
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
        max-width: 500px;
        margin: 50px auto;
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

    .modal-header {
        background: linear-gradient(135deg, #083CAE, #062D8A);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h5 {
        color: #fff;
        font-size: 16px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-header .close {
        color: #fff;
        opacity: .8;
        background: transparent;
        border: none;
        font-size: 20px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 20px;
        font-size: 13.5px;
        color: #495057;
        max-height: 400px;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 15px 20px;
        background: #f8f9fa;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #dee2e6;
    }

    /* Resumen de cierre en modal */
    .modal-resumen {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .modal-resumen-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-resumen-item:last-child {
        border-bottom: none;
    }

    .modal-resumen-label {
        font-weight: 600;
        color: #6b7280;
    }

    .modal-resumen-value {
        font-weight: 700;
        color: #083CAE;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .resumen-cierre {
            grid-template-columns: 1fr;
        }

        .checks-list {
            grid-template-columns: 1fr;
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

        .periodo-selector {
            flex-direction: column;
            align-items: flex-start;
        }

        .filtro-fechas {
            margin-left: 0;
            width: 100%;
            flex-wrap: wrap;
        }

        .date-input {
            flex: 1;
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

        .action-buttons {
            justify-content: flex-start;
        }

        .modal-dialog {
            margin: 20px auto;
        }

        .periodo-tabs {
            width: 100%;
            justify-content: center;
        }

        .periodo-tab {
            flex: 1;
            text-align: center;
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
</style>

<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Cierre de Proyectos -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header">
                <h2>
                Cierre de Proyectos
                </h2>
            </div>
            
            <!-- Selector de período -->
            <div class="periodo-selector">
                <div class="periodo-tabs">
                    <button class="periodo-tab active" onclick="cambiarPeriodo(this, 'mensual')">Mensual</button>
                    <button class="periodo-tab" onclick="cambiarPeriodo(this, 'trimestral')">Trimestral</button>
                    <button class="periodo-tab" onclick="cambiarPeriodo(this, 'anual')">Anual</button>
                </div>
                <div class="filtro-fechas">
                    <i class="fas fa-calendar-alt" style="color: #6b7280;"></i>
                    <input type="date" class="date-input" id="fechaInicio" value="2025-01-01">
                    <span style="color: #6b7280;">a</span>
                    <input type="date" class="date-input" id="fechaFin" value="2025-12-31">
                    <button class="btn-icon" onclick="actualizarPeriodo()">
                        <i class="fas fa-sync-alt"></i> Aplicar
                    </button>
                </div>
            </div>
            
            <!-- KPIs de cierre -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Proyectos Cerrados</div>
                    <div class="value" id="kpiCerrados">18</div>
                    <div class="sub">del total 42 proyectos</div>
                </div>
                <div class="kpi-card">
                    <div class="label">En Proceso de Cierre</div>
                    <div class="value" id="kpiProceso">12</div>
                    <div class="sub">28.5% del total</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Por Cerrar</div>
                    <div class="value" id="kpiPorCerrar">8</div>
                    <div class="sub">próximos 30 días</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Monto por Liberar</div>
                    <div class="value" id="kpiMontoLiberar">$4.2M</div>
                    <div class="sub">garantías y fondos</div>
                </div>
            </div>
            
            <!-- Panel de cierre rápido (oculto inicialmente) -->
            <div class="cierre-panel" id="cierrePanel">
                <form id="cierreForm" onsubmit="return false">
                    <h4 style="margin-top: 0; margin-bottom: 15px; color: #083CAE;">
                        <i class="fas fa-clipboard-check"></i>
                        Cierre de Proyecto: <span id="proyectoCierre">TRC001 - Torre Cumbres</span>
                    </h4>
                    
                    <div class="resumen-cierre">
                        <div class="resumen-item">
                            <div class="resumen-label">Total Facturado</div>
                            <div class="resumen-value" id="totalFacturado">$12,450,000</div>
                            <div class="resumen-detalle">contra $12.8M presupuestado</div>
                        </div>
                        <div class="resumen-item">
                            <div class="resumen-label">Total Pagado</div>
                            <div class="resumen-value" id="totalPagado">$11,890,000</div>
                            <div class="resumen-detalle">95.5% del facturado</div>
                        </div>
                        <div class="resumen-item">
                            <div class="resumen-label">Por Cobrar</div>
                            <div class="resumen-value" id="porCobrar">$560,000</div>
                            <div class="resumen-detalle">incluye garantías</div>
                        </div>
                    </div>
                    
                    <h5 style="margin: 15px 0 10px; color: #000000;">Lista de Verificación de Cierre</h5>
                    <div class="checks-list">
                        <div class="check-item">
                            <input type="checkbox" id="check1">
                            <label for="check1">Acta de entrega-recepción firmada</label>
                        </div>
                        <div class="check-item">
                            <input type="checkbox" id="check2">
                            <label for="check2">Finiquito de obra</label>
                        </div>
                        <div class="check-item">
                            <input type="checkbox" id="check3">
                            <label for="check3">Garantías liberadas</label>
                        </div>
                        <div class="check-item">
                            <input type="checkbox" id="check4">
                            <label for="check4">Pagos pendientes liquidados</label>
                        </div>
                        <div class="check-item">
                            <input type="checkbox" id="check5">
                            <label for="check5">Documentación completa</label>
                        </div>
                        <div class="check-item">
                            <input type="checkbox" id="check6">
                            <label for="check6">Planos as-built entregados</label>
                        </div>
                    </div>
                    
                    <div style="text-align: right; margin-top: 15px;">
                        <button type="button" class="btn-icon" onclick="toggleCierrePanel()">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="button" class="btn-success" onclick="confirmarCierre()">
                            <i class="fas fa-check-circle"></i> Confirmar Cierre
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active" onclick="setTab(this, 'todos')">
                    <i class="fas fa-list mr-1"></i> Todos los Proyectos
                </div>
                <div class="tab-item" onclick="setTab(this, 'cerrados')">
                    <i class="fas fa-check-circle mr-1"></i> Cerrados
                </div>
                <div class="tab-item" onclick="setTab(this, 'proceso')">
                    <i class="fas fa-spinner mr-1"></i> En Proceso
                </div>
                <div class="tab-item" onclick="setTab(this, 'pendientes')">
                    <i class="fas fa-clock mr-1"></i> Pendientes
                </div>
            </div>
            
            <!-- Filtros -->
            <div class="filters-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Buscar por proyecto, responsable..." oninput="filtrar()">
                </div>
                
                <select class="filter-select" id="filterResponsable" onchange="filtrar()">
                    <option value="">Todos los responsables</option>
                    <option value="Ing. Carlos Ruiz">Ing. Carlos Ruiz</option>
                    <option value="Arq. Laura Martínez">Arq. Laura Martínez</option>
                    <option value="Ing. Pedro Sánchez">Ing. Pedro Sánchez</option>
                    <option value="Lic. Ana Torres">Lic. Ana Torres</option>
                </select>
                
                <select class="filter-select" id="filterTipo" onchange="filtrar()">
                    <option value="">Todos los tipos</option>
                    <option value="Residencial">Residencial</option>
                    <option value="Comercial">Comercial</option>
                    <option value="Industrial">Industrial</option>
                    <option value="Infraestructura">Infraestructura</option>
                </select>
                
                <span class="filter-badge" id="filterCount">0</span>
            </div>
            
            <!-- Tabla de proyectos para cierre -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th draggable="true" ondragstart="drag(event)" data-columna="proyecto">Proyecto <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="responsable">Responsable <i class="fas fa-filter"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="fechaInicio">Inicio <i class="fas fa-sort" onclick="ordenar('fechaInicio')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="fechaFin">Fin <i class="fas fa-sort" onclick="ordenar('fechaFin')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="presupuesto">Presupuesto <i class="fas fa-sort" onclick="ordenar('presupuesto')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="facturado">Facturado <i class="fas fa-sort" onclick="ordenar('facturado')"></i></th>
                            <th draggable="true" ondragstart="drag(event)" data-columna="pendiente">Pendiente <i class="fas fa-sort" onclick="ordenar('pendiente')"></i></th>
                            <th>Avance Cierre</th>
                            <th>Estatus</th>
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

<!-- Modal de confirmación de cierre -->
<div class="modal" id="cierreModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>
                    <i class="fas fa-clipboard-check"></i>
                    Confirmar Cierre de Proyecto
                </h5>
                <button type="button" class="close" onclick="cerrarModalCierre()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-resumen">
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Proyecto:</span>
                        <span class="modal-resumen-value" id="modalProyecto">TRC001 - Torre Cumbres</span>
                    </div>
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Total Facturado:</span>
                        <span class="modal-resumen-value" id="modalFacturado">$12,450,000</span>
                    </div>
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Por Cobrar:</span>
                        <span class="modal-resumen-value" id="modalPorCobrar">$560,000</span>
                    </div>
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Rentabilidad:</span>
                        <span class="modal-resumen-value" style="color:#28a745;" id="modalRentabilidad">$1,850,000</span>
                    </div>
                </div>
                <p style="margin-bottom: 5px;">¿Estás seguro de cerrar este proyecto?</p>
                <p style="font-size: 12px; color: #6b7280;">Una vez cerrado, no podrás registrar nuevos gastos ni modificaciones.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-icon" onclick="cerrarModalCierre()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn-success" onclick="ejecutarCierre()">
                    <i class="fas fa-check-circle"></i> Confirmar Cierre
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

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

const responsables = [
    'Ing. Carlos Ruiz', 'Arq. Laura Martínez', 'Ing. Pedro Sánchez', 
    'Lic. Ana Torres', 'Ing. Miguel Hernández', 'Arq. Sofía Ramírez',
    'Ing. Roberto Flores', 'Lic. Carmen García'
];

const tiposProyecto = ['Residencial', 'Comercial', 'Industrial', 'Infraestructura'];
const estatusCierre = ['Cerrado', 'Proceso', 'Pendiente', 'Revisión'];

// Generar 40 proyectos con datos de cierre
let proyectos = [];
let nextId = 1;

for (let i = 0; i < 40; i++) {
    const proyectoKeys = Object.keys(proyectoNames);
    const proyecto = proyectoKeys[Math.floor(Math.random() * proyectoKeys.length)];
    const responsable = responsables[Math.floor(Math.random() * responsables.length)];
    const tipo = tiposProyecto[Math.floor(Math.random() * tiposProyecto.length)];
    
    // Fechas
    const fechaInicio = new Date(2024, Math.floor(Math.random() * 12), Math.floor(Math.random() * 28) + 1);
    const duracionMeses = Math.floor(Math.random() * 12) + 6; // 6-18 meses
    const fechaFin = new Date(fechaInicio);
    fechaFin.setMonth(fechaFin.getMonth() + duracionMeses);
    
    const presupuesto = Math.floor(Math.random() * 15000000) + 5000000;
    const facturado = Math.floor(presupuesto * (0.8 + Math.random() * 0.19));
    const pendiente = presupuesto - facturado;
    
    // Determinar estatus de cierre basado en fechas
    let estatus;
    let avanceCierre;
    const hoy = new Date();
    
    if (fechaFin < hoy) {
        // Proyecto terminado en fecha
        if (Math.random() > 0.3) {
            estatus = 'Cerrado';
            avanceCierre = 100;
        } else {
            estatus = 'Proceso';
            avanceCierre = Math.floor(Math.random() * 40) + 60;
        }
    } else {
        // Proyecto en curso o por terminar
        const diasParaFin = Math.ceil((fechaFin - hoy) / (1000 * 60 * 60 * 24));
        if (diasParaFin < 30) {
            estatus = 'Proceso';
            avanceCierre = Math.floor(Math.random() * 60) + 40;
        } else {
            estatus = 'Pendiente';
            avanceCierre = Math.floor(Math.random() * 40);
        }
    }
    
    proyectos.push({
        id: nextId++,
        proyecto: proyecto,
        responsable: responsable,
        tipo: tipo,
        fechaInicio: fechaInicio.toISOString().split('T')[0],
        fechaFin: fechaFin.toISOString().split('T')[0],
        presupuesto: presupuesto,
        facturado: facturado,
        pendiente: pendiente,
        estatus: estatus,
        avanceCierre: avanceCierre
    });
}

// Variables globales
let proyectosFiltrados = [...proyectos];
let currentTab = 'todos';
let currentPage = 1;
const PER_PAGE = 10;
let sortKey = 'fechaFin';
let sortDir = 1;
let proyectoSeleccionado = null;

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
const fmtNum = n => n.toLocaleString('es-MX');
const fmtFecha = s => { 
    const [y, m, d] = s.split('-'); 
    return `${d}/${m}/${y}`; 
};

function getBadgeClass(estatus) {
    switch(estatus) {
        case 'Cerrado': return 'badge-cerrado';
        case 'Proceso': return 'badge-proceso';
        case 'Pendiente': return 'badge-pendiente';
        case 'Revisión': return 'badge-revision';
        default: return 'badge-pendiente';
    }
}

// Actualizar KPIs
function actualizarKPIs() {
    const total = proyectos.length;
    const cerrados = proyectos.filter(p => p.estatus === 'Cerrado').length;
    const proceso = proyectos.filter(p => p.estatus === 'Proceso').length;
    const porCerrar = proyectos.filter(p => {
        const hoy = new Date();
        const fin = new Date(p.fechaFin);
        const dias = Math.ceil((fin - hoy) / (1000 * 60 * 60 * 24));
        return dias > 0 && dias < 30;
    }).length;
    
    const montoLiberar = proyectos
        .filter(p => p.estatus === 'Proceso' || p.estatus === 'Cerrado')
        .reduce((sum, p) => sum + p.pendiente * 0.3, 0);
    
    document.getElementById('kpiCerrados').textContent = cerrados;
    document.getElementById('kpiProceso').textContent = proceso;
    document.getElementById('kpiPorCerrar').textContent = porCerrar;
    document.getElementById('kpiMontoLiberar').textContent = fmt(montoLiberar);
}

// Panel de cierre
function toggleCierrePanel() {
    const panel = document.getElementById('cierrePanel');
    panel.classList.toggle('show');
}

function abrirPanelCierre(proyecto) {
    proyectoSeleccionado = proyecto;
    const p = proyectos.find(x => x.proyecto === proyecto);
    if (p) {
        document.getElementById('proyectoCierre').textContent = `${p.proyecto} - ${proyectoNames[p.proyecto]}`;
        document.getElementById('totalFacturado').textContent = fmt(p.facturado);
        document.getElementById('totalPagado').textContent = fmt(p.facturado - p.pendiente * 0.5);
        document.getElementById('porCobrar').textContent = fmt(p.pendiente);
        
        toggleCierrePanel();
    }
}

// Filtrar
function getFiltered() {
    const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    const fR = document.getElementById('filterResponsable')?.value || '';
    const fT = document.getElementById('filterTipo')?.value || '';
    
    return proyectos.filter(p => {
        let tabMatch = true;
        if (currentTab === 'cerrados') {
            tabMatch = p.estatus === 'Cerrado';
        } else if (currentTab === 'proceso') {
            tabMatch = p.estatus === 'Proceso';
        } else if (currentTab === 'pendientes') {
            tabMatch = p.estatus === 'Pendiente';
        }
        
        const searchStr = [p.proyecto, proyectoNames[p.proyecto], p.responsable].join(' ').toLowerCase();
        const mSrch = !q || searchStr.includes(q);
        const mR = !fR || p.responsable === fR;
        const mT = !fT || p.tipo === fT;
        
        return tabMatch && mSrch && mR && mT;
    }).sort((a, b) => {
        let av = a[sortKey], bv = b[sortKey];
        if (sortKey === 'presupuesto' || sortKey === 'facturado' || sortKey === 'pendiente') {
            av = +av;
            bv = +bv;
        }
        if (sortKey === 'fechaInicio' || sortKey === 'fechaFin') {
            av = new Date(av);
            bv = new Date(bv);
        }
        return av < bv ? -sortDir : av > bv ? sortDir : 0;
    });
}

// Renderizar tabla
function renderTabla() {
    proyectosFiltrados = getFiltered();
    const total = proyectosFiltrados.length;
    const pages = Math.ceil(total / PER_PAGE) || 1;
    
    if (currentPage > pages) currentPage = pages;
    if (currentPage < 1) currentPage = 1;
    
    const start = (currentPage - 1) * PER_PAGE;
    const slice = proyectosFiltrados.slice(start, start + PER_PAGE);

    document.getElementById('filterCount').textContent = total;
    document.getElementById('footerInfo').textContent = `${slice.length} de ${total} registros`;
    document.getElementById('pageNum').textContent = currentPage;
    
    document.getElementById('btnAnterior').disabled = currentPage === 1;
    document.getElementById('btnSiguiente').disabled = currentPage === pages;

    const body = document.getElementById('tablaBody');
    
    if (!slice.length) {
        body.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 40px;">
            <div style="padding: 40px 20px; text-align: center;">
                <i class="fas fa-folder-open" style="font-size: 2rem; color: #dee2e6;"></i>
                <p style="font-size: 13px; color: #868e96; margin-top: 10px;">No se encontraron proyectos</p>
            </div>
        </td></tr>`;
    } else {
        body.innerHTML = slice.map(p => {
            const color = proyectoColors[p.proyecto] || '#888';
            const badgeClass = getBadgeClass(p.estatus);
            const progressClass = p.avanceCierre === 100 ? 'completado' : 
                                 p.avanceCierre >= 50 ? 'proceso' : '';
            
            return `<tr>
                <td>
                    <div class="project-tag">
                        <div class="project-dot" style="background:${color}"></div>
                        <div>
                            <div class="project-code">${p.proyecto}</div>
                            <div class="project-name">${proyectoNames[p.proyecto] || ''}</div>
                        </div>
                    </div>
                </td>
                <td>${p.responsable}</td>
                <td>${fmtFecha(p.fechaInicio)}</td>
                <td>${fmtFecha(p.fechaFin)}</td>
                <td class="text-right"><span class="mono">${fmt(p.presupuesto)}</span></td>
                <td class="text-right"><span class="mono">${fmt(p.facturado)}</span></td>
                <td class="text-right"><span class="mono">${fmt(p.pendiente)}</span></td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div class="progress-cierre">
                            <div class="progress-cierre-fill ${progressClass}" style="width: ${p.avanceCierre}%"></div>
                        </div>
                        <span class="cierre-porcentaje">${p.avanceCierre}%</span>
                    </div>
                </td>
                <td><span class="badge ${badgeClass}">${p.estatus}</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn" onclick="verDetalle('${p.proyecto}')" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn cerrar" onclick="abrirModalCierre('${p.proyecto}')" title="Iniciar cierre">
                            <i class="fas fa-clipboard-check"></i>
                        </button>
                        <button class="action-btn reporte" onclick="generarReporte('${p.proyecto}')" title="Generar reporte">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    // Totales
    const totalPresupuesto = proyectosFiltrados.reduce((a, b) => a + b.presupuesto, 0);
    const totalFacturado = proyectosFiltrados.reduce((a, b) => a + b.facturado, 0);
    const totalPendiente = proyectosFiltrados.reduce((a, b) => a + b.pendiente, 0);
    
    document.getElementById('tablaFoot').innerHTML = `<tr>
        <td colspan="4" style="text-align: right; font-weight:600;">Totales filtrados:</td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalPresupuesto)}</span></td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalFacturado)}</span></td>
        <td class="text-right"><span class="mono" style="font-weight:700">${fmt(totalPendiente)}</span></td>
        <td colspan="3"></td>
    </tr>`;
    
    actualizarKPIs();
}

// Funciones de acción
function filtrar() { 
    currentPage = 1; 
    renderTabla(); 
}

function setTab(el, tab) {
    document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    currentTab = tab;
    currentPage = 1;
    renderTabla();
}

function ordenar(key) { 
    if (sortKey === key) {
        sortDir *= -1;
    } else {
        sortKey = key;
        sortDir = 1;
    }
    renderTabla(); 
}

function cambiarPagina(dir) { 
    const pages = Math.ceil(getFiltered().length / PER_PAGE) || 1; 
    currentPage = Math.max(1, Math.min(pages, currentPage + dir)); 
    renderTabla(); 
}

function cambiarPeriodo(btn, periodo) {
    document.querySelectorAll('.periodo-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    const hoy = new Date();
    let inicio, fin;
    
    if (periodo === 'mensual') {
        inicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        fin = new Date(hoy.getFullYear(), hoy.getMonth() + 1, 0);
    } else if (periodo === 'trimestral') {
        const trimestre = Math.floor(hoy.getMonth() / 3);
        inicio = new Date(hoy.getFullYear(), trimestre * 3, 1);
        fin = new Date(hoy.getFullYear(), trimestre * 3 + 3, 0);
    } else {
        inicio = new Date(hoy.getFullYear(), 0, 1);
        fin = new Date(hoy.getFullYear(), 11, 31);
    }
    
    document.getElementById('fechaInicio').value = inicio.toISOString().split('T')[0];
    document.getElementById('fechaFin').value = fin.toISOString().split('T')[0];
    mostrarToast(`Período actualizado: ${periodo}`, 'info');
}

function actualizarPeriodo() {
    mostrarToast('Período actualizado', 'success');
    renderTabla();
}

// Modal de cierre
function abrirModalCierre(proyecto) {
    const p = proyectos.find(x => x.proyecto === proyecto);
    if (p) {
        proyectoSeleccionado = p;
        document.getElementById('modalProyecto').textContent = `${p.proyecto} - ${proyectoNames[p.proyecto]}`;
        document.getElementById('modalFacturado').textContent = fmt(p.facturado);
        document.getElementById('modalPorCobrar').textContent = fmt(p.pendiente);
        document.getElementById('modalRentabilidad').textContent = fmt(p.facturado - p.presupuesto * 0.7);
        
        document.getElementById('cierreModal').classList.add('show');
    }
}

function cerrarModalCierre() {
    document.getElementById('cierreModal').classList.remove('show');
    proyectoSeleccionado = null;
}

function ejecutarCierre() {
    if (proyectoSeleccionado) {
        const index = proyectos.findIndex(p => p.id === proyectoSeleccionado.id);
        if (index !== -1) {
            proyectos[index].estatus = 'Cerrado';
            proyectos[index].avanceCierre = 100;
        }
    }
    
    cerrarModalCierre();
    renderTabla();
    mostrarToast('✅ Proyecto cerrado exitosamente', 'success');
}

function confirmarCierre() {
    const checks = document.querySelectorAll('#cierrePanel input[type="checkbox"]');
    const todosChequeados = Array.from(checks).every(c => c.checked);
    
    if (!todosChequeados) {
        mostrarToast('❌ Completa todos los puntos de verificación', 'warning');
        return;
    }
    
    if (proyectoSeleccionado) {
        const index = proyectos.findIndex(p => p.id === proyectoSeleccionado.id);
        if (index !== -1) {
            proyectos[index].estatus = 'Cerrado';
            proyectos[index].avanceCierre = 100;
        }
    }
    
    toggleCierrePanel();
    renderTabla();
    mostrarToast('✅ Proyecto cerrado exitosamente', 'success');
}

// Otras funciones
function verDetalle(proyecto) {
    const p = proyectos.find(x => x.proyecto === proyecto);
    if (p) {
        mostrarToast(`${p.proyecto} - ${proyectoNames[p.proyecto]} - ${fmt(p.presupuesto)}`, 'info');
    }
}

function generarReporte(proyecto) {
    const p = proyectos.find(x => x.proyecto === proyecto);
    if (p) {
        mostrarToast(`Generando reporte de cierre para ${p.proyecto}`, 'success');
    }
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

// Drag and drop
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.getAttribute('data-columna'));
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