@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-teal: #00838f;
        --primary-teal-light: #0097a7;
        --primary-teal-dark: #006064;
        --primary-blue: #1565c0;
        --primary-blue-light: #1e88e5;
        --primary-green: #2e7d32;
        --primary-green-light: #4caf50;
        --primary-amber: #ff8f00;
        --primary-amber-light: #ffb300;
        --primary-purple: #6a1b9a;
        --primary-red: #c62828;
        --accent-teal: #00695c;
        --dark-bg: #1a237e;
        --light-bg: #f5f7fa;
        --card-bg: #ffffff;
        --text-dark: #263238;
        --text-medium: #546e7a;
        --text-light: #78909c;
        --border-light: #e0e0e0;
        --border-medium: #bdbdbd;
        --success: #4caf50;
        --warning: #ff9800;
        --error: #f44336;
        --info: #2196f3;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', 'Roboto', sans-serif;
    }
    
    body {
        background-color: var(--light-bg);
        color: var(--text-dark);
        font-size: 13px;
    }
    
    .main-content {
        padding: 1.5rem;
        max-width: 1800px;
        margin: 0 auto;
    }
    
    /* Header */
    .page-header {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 10px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-light);
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .title-section {
        flex: 1;
    }
    
    .page-title {
        font-size: 1.6rem;
        color: var(--dark-bg);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.4rem;
    }
    
    .title-icon {
        font-size: 1.5rem;
        color: var(--primary-teal);
    }
    
    .filter-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }
    
    .filter-label {
        font-size: 0.8rem;
        color: var(--text-medium);
        font-weight: 600;
    }
    
    .filter-select {
        padding: 0.5rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 6px;
        font-size: 0.8rem;
        color: var(--text-dark);
        background-color: white;
        min-width: 180px;
        cursor: pointer;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary-teal);
        box-shadow: 0 0 0 3px rgba(0, 131, 143, 0.1);
    }
    
    .date-range {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        border: 2px solid var(--border-light);
    }
    
    .date-range i {
        color: var(--primary-teal);
    }
    
    .date-input {
        border: none;
        padding: 0.25rem;
        font-size: 0.8rem;
        width: 100px;
    }
    
    .date-input:focus {
        outline: none;
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .btn {
        padding: 0.6rem 1.25rem;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        font-size: 0.8rem;
    }
    
    .btn i {
        font-size: 0.9rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-light));
        color: white;
        box-shadow: 0 3px 8px rgba(0, 131, 143, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 131, 143, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
        color: white;
    }
    
    .btn-excel {
        background: linear-gradient(135deg, #217346, #2d9558);
        color: white;
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #c62828, #e53935);
        color: white;
    }
    
    .btn-analytics {
        background: linear-gradient(135deg, #6a1b9a, #8e24aa);
        color: white;
    }
    
    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .kpi-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        border: 1.5px solid;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .kpi-card.compras {
        border-color: var(--primary-teal);
    }
    .kpi-card.compras::before { background: linear-gradient(90deg, #00838f, #0097a7); }
    
    .kpi-card.ahorro {
        border-color: #2e7d32;
    }
    .kpi-card.ahorro::before { background: linear-gradient(90deg, #2e7d32, #4caf50); }
    
    .kpi-card.oc {
        border-color: #ff8f00;
    }
    .kpi-card.oc::before { background: linear-gradient(90deg, #ff8f00, #ffb300); }
    
    .kpi-card.proveedores {
        border-color: #6a1b9a;
    }
    .kpi-card.proveedores::before { background: linear-gradient(90deg, #6a1b9a, #8e24aa); }
    
    .kpi-card.dias {
        border-color: #1565c0;
    }
    .kpi-card.dias::before { background: linear-gradient(90deg, #1565c0, #1e88e5); }
    
    .kpi-card.urgente {
        border-color: #c62828;
    }
    .kpi-card.urgente::before { background: linear-gradient(90deg, #c62828, #e53935); }
    
    .kpi-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }
    
    .kpi-icon-box.teal { background: linear-gradient(135deg, #00838f, #0097a7); }
    .kpi-icon-box.green { background: linear-gradient(135deg, #2e7d32, #4caf50); }
    .kpi-icon-box.amber { background: linear-gradient(135deg, #ff8f00, #ffb300); }
    .kpi-icon-box.purple { background: linear-gradient(135deg, #6a1b9a, #8e24aa); }
    .kpi-icon-box.blue { background: linear-gradient(135deg, #1565c0, #1e88e5); }
    .kpi-icon-box.red { background: linear-gradient(135deg, #c62828, #e53935); }
    
    .kpi-info {
        flex: 1;
        min-width: 0;
    }
    
    .kpi-label {
        font-size: 0.7rem;
        color: var(--text-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.2rem;
    }
    
    .kpi-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: clip;
    }
    
    .kpi-subtext {
        font-size: 0.65rem;
        color: var(--text-light);
        margin-top: 0.15rem;
        white-space: nowrap;
    }
    
    /* Pestañas de análisis */
    .analytics-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-light);
        padding-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    
    .tab-btn {
        padding: 0.6rem 1.25rem;
        background: white;
        border: 1px solid var(--border-light);
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-medium);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }
    
    .tab-btn i {
        font-size: 0.9rem;
    }
    
    .tab-btn.active {
        background: var(--primary-teal);
        color: white;
        border-color: var(--primary-teal);
    }
    
    .tab-btn:hover:not(.active) {
        background: #e0f7fa;
        border-color: var(--primary-teal);
        color: var(--primary-teal);
    }
    
    /* Cards de análisis */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .analytics-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border-light);
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .card-title {
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .card-title i {
        color: var(--primary-teal);
    }
    
    .card-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .card-actions button {
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
    }
    
    .card-actions button:hover {
        background: #f0f0f0;
        color: var(--primary-teal);
    }
    
    /* Gráficos simulados */
    .chart-container {
        margin-top: 0.5rem;
    }
    
    .chart-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .chart-label {
        width: 80px;
        font-size: 0.75rem;
        color: var(--text-medium);
    }
    
    .chart-value {
        flex: 1;
        height: 24px;
        background: #f5f5f5;
        border-radius: 4px;
        position: relative;
        overflow: hidden;
    }
    
    .chart-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-teal), var(--primary-teal-light));
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 0.5rem;
        color: white;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .chart-fill.amber { background: linear-gradient(90deg, #ff8f00, #ffb300); }
    .chart-fill.green { background: linear-gradient(90deg, #2e7d32, #4caf50); }
    .chart-fill.blue { background: linear-gradient(90deg, #1565c0, #1e88e5); }
    .chart-fill.purple { background: linear-gradient(90deg, #6a1b9a, #8e24aa); }
    .chart-fill.red { background: linear-gradient(90deg, #c62828, #e53935); }
    
    .chart-percent {
        width: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    /* Tabla de análisis */
    .table-section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .analysis-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .analysis-table thead th {
        background: linear-gradient(135deg, #00838f, #0097a7);
        color: white;
        padding: 0.8rem 0.6rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.75rem;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .analysis-table thead th:last-child {
        border-right: none;
    }
    
    .analysis-table tbody td {
        padding: 0.8rem 0.6rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.75rem;
        vertical-align: middle;
    }
    
    .analysis-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
    }
    
    .analysis-table tbody tr:hover {
        background-color: #e0f7fa;
    }
    
    .analysis-table tfoot td {
        padding: 0.8rem 0.6rem;
        background: #f5f5f5;
        font-weight: 700;
        border-top: 2px solid var(--primary-teal);
    }
    
    /* Indicadores de rendimiento */
    .metric-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .metric-badge.alta {
        background: #c8e6c9;
        color: #2e7d32;
    }
    
    .metric-badge.media {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    .metric-badge.baja {
        background: #ffebee;
        color: #c62828;
    }
    
    .metric-badge.critico {
        background: #ffebee;
        color: #c62828;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
    
    /* Top proveedores */
    .supplier-ranking {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .supplier-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .supplier-item:hover {
        background: #f5f5f5;
    }
    
    .supplier-rank {
        width: 24px;
        height: 24px;
        background: var(--primary-teal);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
    }
    
    .supplier-info {
        flex: 1;
    }
    
    .supplier-name {
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .supplier-category {
        font-size: 0.65rem;
        color: var(--text-light);
    }
    
    .supplier-amount {
        font-family: 'Roboto Mono', monospace;
        font-weight: 700;
        font-size: 0.85rem;
    }
    
    /* Categorías de compra */
    .category-chart {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    
    .category-item {
        flex: 1 1 calc(50% - 0.75rem);
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .category-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
    }
    
    .category-bar {
        height: 8px;
        background: #f5f5f5;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .category-fill {
        height: 100%;
        border-radius: 4px;
    }
    
    /* Insights */
    .insights-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .insight-card {
        background: #f8f9fc;
        border-radius: 8px;
        padding: 1rem;
        border-left: 4px solid;
    }
    
    .insight-card.teal { border-left-color: var(--primary-teal); }
    .insight-card.green { border-left-color: #2e7d32; }
    .insight-card.amber { border-left-color: #ff8f00; }
    
    .insight-title {
        font-size: 0.7rem;
        color: var(--text-medium);
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    
    .insight-value {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .insight-trend {
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .trend-up { color: #2e7d32; }
    .trend-down { color: #c62828; }
    
    /* Alertas de compras */
    .alerts-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .alert-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #fff8e1;
        border-radius: 6px;
        border-left: 4px solid #ff8f00;
    }
    
    .alert-item.critical {
        background: #ffebee;
        border-left-color: #c62828;
    }
    
    .alert-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 143, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff8f00;
    }
    
    .alert-item.critical .alert-icon {
        background: rgba(198, 40, 40, 0.1);
        color: #c62828;
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-title {
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .alert-desc {
        font-size: 0.7rem;
        color: var(--text-medium);
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .analytics-grid {
            grid-template-columns: 1fr;
        }
        
        .insights-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
        
        .page-header {
            padding: 1.25rem;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .filter-section {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        
        .filter-select {
            width: 100%;
        }
        
        .date-range {
            width: 100%;
        }
        
        .analytics-tabs {
            flex-wrap: wrap;
        }
        
        .tab-btn {
            flex: 1;
        }
        
        .category-item {
            flex: 1 1 100%;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-chart-pie title-icon"></i>
                    Análisis de Compras
                </h1>
                <div class="filter-section">
                    <span class="filter-label">Período:</span>
                    <div class="date-range">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="text" class="date-input" id="fecha-inicio" placeholder="01/01/2026" value="01/01/2026">
                        <span>→</span>
                        <input type="text" class="date-input" id="fecha-fin" placeholder="11/02/2026" value="11/02/2026">
                    </div>
                    <select class="filter-select" id="categoria-filter">
                        <option value="todas">TODAS LAS CATEGORÍAS</option>
                        <option value="materiales">Materiales de Construcción</option>
                        <option value="herramientas">Herramientas y Equipo</option>
                        <option value="servicios">Servicios</option>
                        <option value="transporte">Transporte y Logística</option>
                        <option value="oficina">Papelería y Oficina</option>
                    </select>
                    <select class="filter-select" id="proveedor-filter">
                        <option value="todos">TODOS LOS PROVEEDORES</option>
                        <option value="transportes">Transportes Demo</option>
                        <option value="tracto">Tracto Refacciones</option>
                        <option value="llantera">Llantera Demo</option>
                        <option value="diesel">Proveedor Diesel</option>
                        <option value="allende">Unión de Crédito Allende</option>
                    </select>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" id="aplicar-filtros">
                    <i class="fas fa-filter"></i>
                    Aplicar Filtros
                </button>
                <button class="btn btn-analytics" id="reporte-completo">
                    <i class="fas fa-file-alt"></i>
                    Reporte Completo
                </button>
                <button class="btn btn-excel" id="export-excel">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </button>
                <button class="btn btn-pdf" id="export-pdf">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card compras">
            <div class="kpi-icon-box teal">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Compras Totales</div>
                <div class="kpi-value">$2,345,678</div>
                <div class="kpi-subtext">Período: Ene-Feb 2026</div>
            </div>
        </div>
        
        <div class="kpi-card ahorro">
            <div class="kpi-icon-box green">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Ahorro vs Presupuesto</div>
                <div class="kpi-value">$187,432</div>
                <div class="kpi-subtext">8.2% de ahorro</div>
            </div>
        </div>
        
        <div class="kpi-card oc">
            <div class="kpi-icon-box amber">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Órdenes de Compra</div>
                <div class="kpi-value">156</div>
                <div class="kpi-subtext">12 pendientes</div>
            </div>
        </div>
        
        <div class="kpi-card proveedores">
            <div class="kpi-icon-box purple">
                <i class="fas fa-truck"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Proveedores Activos</div>
                <div class="kpi-value">24</div>
                <div class="kpi-subtext">+3 vs período anterior</div>
            </div>
        </div>
        
        <div class="kpi-card dias">
            <div class="kpi-icon-box blue">
                <i class="fas fa-clock"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Días Promedio Pago</div>
                <div class="kpi-value">32.5</div>
                <div class="kpi-subtext">-2.3 vs meta</div>
            </div>
        </div>
        
        <div class="kpi-card urgente">
            <div class="kpi-icon-box red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Compras Urgentes</div>
                <div class="kpi-value">8</div>
                <div class="kpi-subtext">$234,567</div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Análisis -->
    <div class="analytics-tabs">
        <button class="tab-btn active" id="tab-general">
            <i class="fas fa-chart-pie"></i>
            Vista General
        </button>
        <button class="tab-btn" id="tab-proveedores">
            <i class="fas fa-truck"></i>
            Análisis Proveedores
        </button>
        <button class="tab-btn" id="tab-categorias">
            <i class="fas fa-tags"></i>
            Categorías
        </button>
        <button class="tab-btn" id="tab-tendencias">
            <i class="fas fa-chart-line"></i>
            Tendencias
        </button>
        <button class="tab-btn" id="tab-eficiencia">
            <i class="fas fa-stopwatch"></i>
            Eficiencia
        </button>
    </div>

    <!-- ========== VISTA GENERAL ========== -->
    <div id="view-general" style="display: block;">
        <!-- Analytics Grid -->
        <div class="analytics-grid">
            <!-- Compras por Categoría -->
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-tags"></i>
                        Compras por Categoría
                    </div>
                    <div class="card-actions">
                        <button title="Descargar"><i class="fas fa-download"></i></button>
                        <button title="Expandir"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-bar">
                        <span class="chart-label">Materiales</span>
                        <div class="chart-value">
                            <div class="chart-fill" style="width: 65%;">$845,200</div>
                        </div>
                        <span class="chart-percent">65%</span>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Herramientas</span>
                        <div class="chart-value">
                            <div class="chart-fill amber" style="width: 45%;">$385,400</div>
                        </div>
                        <span class="chart-percent">45%</span>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Servicios</span>
                        <div class="chart-value">
                            <div class="chart-fill green" style="width: 38%;">$298,500</div>
                        </div>
                        <span class="chart-percent">38%</span>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Transporte</span>
                        <div class="chart-value">
                            <div class="chart-fill purple" style="width: 42%;">$456,800</div>
                        </div>
                        <span class="chart-percent">42%</span>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Oficina</span>
                        <div class="chart-value">
                            <div class="chart-fill blue" style="width: 22%;">$89,778</div>
                        </div>
                        <span class="chart-percent">22%</span>
                    </div>
                </div>
                <div style="margin-top: 1rem; font-size: 0.7rem; color: var(--text-light); text-align: right;">
                    Total: $2,345,678 | Materiales representa el 36%
                </div>
            </div>
            
            <!-- Top Proveedores -->
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-trophy"></i>
                        Top 5 Proveedores
                    </div>
                    <div class="card-actions">
                        <button title="Ver todos"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="supplier-ranking">
                    <div class="supplier-item">
                        <div class="supplier-rank">1</div>
                        <div class="supplier-info">
                            <div class="supplier-name">Unión de Crédito Allende</div>
                            <div class="supplier-category">Servicios Financieros</div>
                        </div>
                        <div class="supplier-amount">$694,297</div>
                    </div>
                    <div class="supplier-item">
                        <div class="supplier-rank">2</div>
                        <div class="supplier-info">
                            <div class="supplier-name">Transportes Demo Mexico</div>
                            <div class="supplier-category">Logística</div>
                        </div>
                        <div class="supplier-amount">$476,020</div>
                    </div>
                    <div class="supplier-item">
                        <div class="supplier-rank">3</div>
                        <div class="supplier-info">
                            <div class="supplier-name">Llantera Demo</div>
                            <div class="supplier-category">Refacciones</div>
                        </div>
                        <div class="supplier-amount">$270,180</div>
                    </div>
                    <div class="supplier-item">
                        <div class="supplier-rank">4</div>
                        <div class="supplier-info">
                            <div class="supplier-name">Logística del Golfo</div>
                            <div class="supplier-category">Transporte</div>
                        </div>
                        <div class="supplier-amount">$172,110</div>
                    </div>
                    <div class="supplier-item">
                        <div class="supplier-rank">5</div>
                        <div class="supplier-info">
                            <div class="supplier-name">Tracto Refacciones</div>
                            <div class="supplier-category">Autopartes</div>
                        </div>
                        <div class="supplier-amount">$155,138</div>
                    </div>
                </div>
                <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid var(--border-light);">
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem;">
                        <span>Concentración Top 5:</span>
                        <span style="font-weight: 700; color: var(--primary-teal);">74%</span>
                    </div>
                </div>
            </div>
            
            <!-- Tendencias de Precios -->
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-line"></i>
                        Tendencias de Precios
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-calendar-alt"></i></button>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Cemento</span>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #c62828;">+12.5%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: #f5f5f5; border-radius: 3px;">
                            <div style="width: 85%; height: 100%; background: #c62828; border-radius: 3px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Acero</span>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #c62828;">+8.3%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: #f5f5f5; border-radius: 3px;">
                            <div style="width: 72%; height: 100%; background: #c62828; border-radius: 3px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Diesel</span>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #2e7d32;">-3.2%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: #f5f5f5; border-radius: 3px;">
                            <div style="width: 35%; height: 100%; background: #2e7d32; border-radius: 3px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Varilla</span>
                            <span style="font-size: 0.75rem; font-weight: 600; color: #ef6c00;">+5.7%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: #f5f5f5; border-radius: 3px;">
                            <div style="width: 58%; height: 100%; background: #ef6c00; border-radius: 3px;"></div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 1rem; font-size: 0.7rem; color: var(--text-light);">
                    Índice de inflación compras: +6.8% vs período anterior
                </div>
            </div>
            
            <!-- Alertas y Oportunidades -->
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-bell"></i>
                        Alertas y Oportunidades
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <div class="alerts-list">
                    <div class="alert-item critical">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Stock crítico - Cemento</div>
                            <div class="alert-desc">Nivel por debajo del mínimo. Ordenar esta semana.</div>
                        </div>
                    </div>
                    <div class="alert-item">
                        <div class="alert-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Oportunidad de ahorro</div>
                            <div class="alert-desc">Descuento 15% en compra de herramientas > $50k</div>
                        </div>
                    </div>
                    <div class="alert-item">
                        <div class="alert-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Pagos por vencer</div>
                            <div class="alert-desc">3 facturas vencen en 5 días por $234,567</div>
                        </div>
                    </div>
                    <div class="alert-item critical">
                        <div class="alert-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Proveedor suspendido</div>
                            <div class="alert-desc">Constructora Habita - Incumplimiento</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla de Análisis Detallado -->
        <div class="table-section">
            <div style="padding: 1rem 1.25rem; background: linear-gradient(135deg, #e0f7fa, #e0f2fe); border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-chart-bar" style="color: var(--primary-teal);"></i>
                    Análisis de Compras por Proveedor
                </h3>
                <span style="font-size: 0.7rem; background: white; padding: 0.25rem 0.75rem; border-radius: 20px; border: 1px solid var(--border-light);">
                    <i class="fas fa-sync-alt" style="margin-right: 0.25rem;"></i> Actualizado: 11/02/2026
                </span>
            </div>
            <div class="table-responsive">
                <table class="analysis-table">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Categoría</th>
                            <th>Compras Totales</th>
                            <th>% Participación</th>
                            <th>Órdenes</th>
                            <th>Días Pago</th>
                            <th>Cumplimiento</th>
                            <th>Tendencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Unión de Crédito Allende</td>
                            <td>Servicios Financieros</td>
                            <td class="amount">$694,297</td>
                            <td>29.6%</td>
                            <td>8</td>
                            <td>45</td>
                            <td><span class="metric-badge alta">98%</span></td>
                            <td><i class="fas fa-arrow-up" style="color: #c62828;"></i> +5.2%</td>
                        </tr>
                        <tr>
                            <td>Transportes Demo Mexico</td>
                            <td>Logística</td>
                            <td class="amount">$476,020</td>
                            <td>20.3%</td>
                            <td>12</td>
                            <td>32</td>
                            <td><span class="metric-badge alta">100%</span></td>
                            <td><i class="fas fa-arrow-down" style="color: #2e7d32;"></i> -2.1%</td>
                        </tr>
                        <tr>
                            <td>Llantera Demo</td>
                            <td>Refacciones</td>
                            <td class="amount">$270,180</td>
                            <td>11.5%</td>
                            <td>15</td>
                            <td>30</td>
                            <td><span class="metric-badge media">92%</span></td>
                            <td><i class="fas fa-arrow-up" style="color: #c62828;"></i> +8.3%</td>
                        </tr>
                        <tr>
                            <td>Logística del Golfo</td>
                            <td>Transporte</td>
                            <td class="amount">$172,110</td>
                            <td>7.3%</td>
                            <td>9</td>
                            <td>35</td>
                            <td><span class="metric-badge alta">97%</span></td>
                            <td><i class="fas fa-arrow-down" style="color: #2e7d32;"></i> -1.5%</td>
                        </tr>
                        <tr>
                            <td>Tracto Refacciones</td>
                            <td>Autopartes</td>
                            <td class="amount">$155,138</td>
                            <td>6.6%</td>
                            <td>7</td>
                            <td>28</td>
                            <td><span class="metric-badge media">89%</span></td>
                            <td><i class="fas fa-arrow-up" style="color: #c62828;"></i> +3.7%</td>
                        </tr>
                        <tr>
                            <td>Proveedor Diesel Demo</td>
                            <td>Combustibles</td>
                            <td class="amount">$105,830</td>
                            <td>4.5%</td>
                            <td>6</td>
                            <td>25</td>
                            <td><span class="metric-badge alta">100%</span></td>
                            <td><i class="fas fa-arrow-down" style="color: #2e7d32;"></i> -4.2%</td>
                        </tr>
                        <tr>
                            <td>Sistemas Computacionales</td>
                            <td>Tecnología</td>
                            <td class="amount">$91,900</td>
                            <td>3.9%</td>
                            <td>4</td>
                            <td>40</td>
                            <td><span class="metric-badge baja">75%</span></td>
                            <td><i class="fas fa-arrow-up" style="color: #c62828;"></i> +12.1%</td>
                        </tr>
                        <tr>
                            <td>3R Freightmex</td>
                            <td>Logística</td>
                            <td class="amount">$78,095</td>
                            <td>3.3%</td>
                            <td>5</td>
                            <td>38</td>
                            <td><span class="metric-badge media">86%</span></td>
                            <td><i class="fas fa-arrow-down" style="color: #2e7d32;"></i> -0.8%</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>TOTAL / PROMEDIO</strong></td>
                            <td><strong>$2,345,678</strong></td>
                            <td><strong>100%</strong></td>
                            <td><strong>78</strong></td>
                            <td><strong>32.5</strong></td>
                            <td><strong>93%</strong></td>
                            <td><strong>+5.2%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Insights Rápidos -->
        <div class="insights-grid">
            <div class="insight-card teal">
                <div class="insight-title">Oportunidad de consolidación</div>
                <div class="insight-value">$234,567</div>
                <div class="insight-trend trend-up">
                    <i class="fas fa-arrow-up"></i> 3 proveedores similares
                </div>
                <div style="font-size: 0.65rem; margin-top: 0.5rem;">Compras fragmentadas en refacciones</div>
            </div>
            <div class="insight-card green">
                <div class="insight-title">Ahorro vs presupuesto</div>
                <div class="insight-value">$187,432</div>
                <div class="insight-trend trend-up">
                    <i class="fas fa-check-circle"></i> 8.2% por debajo
                </div>
                <div style="font-size: 0.65rem; margin-top: 0.5rem;">Mejor desempeño en materiales</div>
            </div>
            <div class="insight-card amber">
                <div class="insight-title">Compras sin orden</div>
                <div class="insight-value">$78,234</div>
                <div class="insight-trend trend-down">
                    <i class="fas fa-exclamation-triangle"></i> +15% vs período anterior
                </div>
                <div style="font-size: 0.65rem; margin-top: 0.5rem;">Requiere revisión de políticas</div>
            </div>
        </div>
    </div>

    <!-- ========== VISTA PROVEEDORES (oculta) ========== -->
    <div id="view-proveedores" style="display: none;">
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-pie"></i>
                        Concentración por Proveedor
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-bar">
                        <span class="chart-label">Allende</span>
                        <div class="chart-value">
                            <div class="chart-fill" style="width: 30%;">30%</div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Transportes</span>
                        <div class="chart-value">
                            <div class="chart-fill amber" style="width: 20%;">20%</div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Llantera</span>
                        <div class="chart-value">
                            <div class="chart-fill green" style="width: 12%;">12%</div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Logística</span>
                        <div class="chart-value">
                            <div class="chart-fill purple" style="width: 7%;">7%</div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="chart-label">Otros</span>
                        <div class="chart-value">
                            <div class="chart-fill blue" style="width: 31%;">31%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-clock"></i>
                        Desempeño en Entregas
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="text-align: center;">
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary-teal);">92%</span>
                        <span style="font-size: 0.8rem; margin-left: 0.5rem;">a tiempo</span>
                    </div>
                    <div style="display: flex; justify-content: space-around;">
                        <div style="text-align: center;">
                            <span style="font-size: 1rem; font-weight: 700;">8</span>
                            <div style="font-size: 0.65rem; color: var(--text-light);">Atrasadas</div>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 1rem; font-weight: 700;">3.2</span>
                            <div style="font-size: 0.65rem; color: var(--text-light);;">Días retraso</div>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 1rem; font-weight: 700;">24</span>
                            <div style="font-size: 0.65rem; color: var(--text-light);;">Proveedores</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-section" style="margin-top: 1rem;">
            <div style="padding: 1rem;">
                <h3 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem;">Evaluación de Proveedores</h3>
                <!-- Aquí iría tabla de evaluación -->
                <p style="color: var(--text-light); text-align: center; padding: 2rem;">Vista detallada de proveedores - En construcción</p>
            </div>
        </div>
    </div>

    <!-- ========== VISTA CATEGORÍAS (oculta) ========== -->
    <div id="view-categorias" style="display: none;">
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-tags"></i>
                        Distribución por Categoría
                    </div>
                </div>
                <div class="category-chart">
                    <div class="category-item">
                        <div class="category-header">
                            <span>Materiales</span>
                            <span style="font-weight: 600;">$845,200</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 36%; background: #00838f;"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-header">
                            <span>Transporte</span>
                            <span style="font-weight: 600;">$456,800</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 19%; background: #6a1b9a;"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-header">
                            <span>Herramientas</span>
                            <span style="font-weight: 600;">$385,400</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 16%; background: #ff8f00;"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-header">
                            <span>Servicios</span>
                            <span style="font-weight: 600;">$298,500</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 13%; background: #2e7d32;"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-header">
                            <span>Oficina</span>
                            <span style="font-weight: 600;">$89,778</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 4%; background: #1565c0;"></div>
                        </div>
                    </div>
                    <div class="category-item">
                        <div class="category-header">
                            <span>Otros</span>
                            <span style="font-weight: 600;">$270,000</span>
                        </div>
                        <div class="category-bar">
                            <div class="category-fill" style="width: 12%; background: #757575;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== VISTA TENDENCIAS (oculta) ========== -->
    <div id="view-tendencias" style="display: none;">
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-line"></i>
                        Comportamiento Mensual
                    </div>
                </div>
                <div style="display: flex; justify-content: space-around; padding: 1rem 0;">
                    <div style="text-align: center;">
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Octubre</span>
                        <div style="font-size: 1rem; font-weight: 700;">$412K</div>
                    </div>
                    <div style="text-align: center;">
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Noviembre</span>
                        <div style="font-size: 1rem; font-weight: 700;">$521K</div>
                    </div>
                    <div style="text-align: center;">
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Diciembre</span>
                        <div style="font-size: 1rem; font-weight: 700;">$678K</div>
                    </div>
                    <div style="text-align: center;">
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Enero</span>
                        <div style="font-size: 1rem; font-weight: 700;">$734K</div>
                    </div>
                    <div style="text-align: center;">
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Febrero</span>
                        <div style="font-size: 1rem; font-weight: 700;">$612K</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== VISTA EFICIENCIA (oculta) ========== -->
    <div id="view-eficiencia" style="display: none;">
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-stopwatch"></i>
                        Ciclo de Compra
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem; padding: 0.5rem 0;">
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Requisición → OC</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">2.5 días</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f5f5f5; border-radius: 4px;">
                            <div style="width: 45%; height: 100%; background: #00838f; border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">OC → Entrega</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">4.8 días</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f5f5f5; border-radius: 4px;">
                            <div style="width: 65%; height: 100%; background: #00838f; border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.75rem;">Entrega → Pago</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">32.5 días</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #f5f5f5; border-radius: 4px;">
                            <div style="width: 85%; height: 100%; background: #ff8f00; border-radius: 4px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle entre vistas de análisis
        const tabGeneral = document.getElementById('tab-general');
        const tabProveedores = document.getElementById('tab-proveedores');
        const tabCategorias = document.getElementById('tab-categorias');
        const tabTendencias = document.getElementById('tab-tendencias');
        const tabEficiencia = document.getElementById('tab-eficiencia');
        
        const viewGeneral = document.getElementById('view-general');
        const viewProveedores = document.getElementById('view-proveedores');
        const viewCategorias = document.getElementById('view-categorias');
        const viewTendencias = document.getElementById('view-tendencias');
        const viewEficiencia = document.getElementById('view-eficiencia');
        
        function setActiveAnalysisTab(activeTab, activeView) {
            // Remover active de todos los tabs
            [tabGeneral, tabProveedores, tabCategorias, tabTendencias, tabEficiencia].forEach(t => {
                t.classList.remove('active');
            });
            
            // Ocultar todas las vistas
            viewGeneral.style.display = 'none';
            viewProveedores.style.display = 'none';
            viewCategorias.style.display = 'none';
            viewTendencias.style.display = 'none';
            viewEficiencia.style.display = 'none';
            
            // Activar tab y vista seleccionados
            activeTab.classList.add('active');
            activeView.style.display = 'block';
        }
        
        tabGeneral.addEventListener('click', function() {
            setActiveAnalysisTab(tabGeneral, viewGeneral);
        });
        
        tabProveedores.addEventListener('click', function() {
            setActiveAnalysisTab(tabProveedores, viewProveedores);
        });
        
        tabCategorias.addEventListener('click', function() {
            setActiveAnalysisTab(tabCategorias, viewCategorias);
        });
        
        tabTendencias.addEventListener('click', function() {
            setActiveAnalysisTab(tabTendencias, viewTendencias);
        });
        
        tabEficiencia.addEventListener('click', function() {
            setActiveAnalysisTab(tabEficiencia, viewEficiencia);
        });
        
        // Botón aplicar filtros
        const aplicarFiltros = document.getElementById('aplicar-filtros');
        if (aplicarFiltros) {
            aplicarFiltros.addEventListener('click', function() {
                showNotification('✅ Filtros aplicados: ' + 
                    document.getElementById('fecha-inicio').value + ' - ' + 
                    document.getElementById('fecha-fin').value, 'success');
            });
        }
        
        // Botón reporte completo
        const reporteCompleto = document.getElementById('reporte-completo');
        if (reporteCompleto) {
            reporteCompleto.addEventListener('click', function() {
                showNotification('📊 Generando reporte completo de análisis de compras', 'info');
            });
        }
        
        // Exportar Excel
        const exportExcel = document.getElementById('export-excel');
        if (exportExcel) {
            exportExcel.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('✅ Excel exportado - Análisis de compras', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 800);
            });
        }
        
        // Exportar PDF
        const exportPdf = document.getElementById('export-pdf');
        if (exportPdf) {
            exportPdf.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('✅ PDF exportado - Reporte de compras', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 800);
            });
        }
        
        // Filtros
        const categoriaFilter = document.getElementById('categoria-filter');
        if (categoriaFilter) {
            categoriaFilter.addEventListener('change', function() {
                showNotification(`Filtrando categoría: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        const proveedorFilter = document.getElementById('proveedor-filter');
        if (proveedorFilter) {
            proveedorFilter.addEventListener('change', function() {
                showNotification(`Filtrando proveedor: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        // Función de notificaciones
        function showNotification(message, type = 'success') {
            if (typeof Alpine !== 'undefined' && Alpine.$data) {
                const event = new CustomEvent('new-notification', {
                    detail: {
                        title: type === 'success' ? 'Éxito' : type === 'error' ? 'Error' : 'Información',
                        message: message,
                        type: type
                    }
                });
                window.dispatchEvent(event);
            } else {
                console.log(`🔔 ${message}`);
                alert(message);
            }
        }
        
        // Animación de entrada
        const kpiCards = document.querySelectorAll('.kpi-card');
        kpiCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(15px)';
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 80);
        });
    });
</script>
@endsection