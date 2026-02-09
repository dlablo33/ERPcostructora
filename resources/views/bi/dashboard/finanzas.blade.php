@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-green: #2e7d32;
        --primary-green-light: #4caf50;
        --primary-green-dark: #1b5e20;
        --primary-red: #c62828;
        --primary-blue: #1565c0;
        --primary-purple: #6a1b9a;
        --primary-cyan: #00838f;
        --secondary-blue: #0277bd;
        --accent-teal: #00695c;
        --accent-amber: #ff8f00;
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
    }
    
    /* Contenido principal */
    .main-content {
        padding: 2rem;
        max-width: 1600px;
        margin: 0 auto;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-light);
    }
    
    .page-title {
        font-size: 2.4rem;
        color: var(--dark-bg);
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
    }
    
    .page-title i {
        color: var(--primary-blue);
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-cyan));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-subtitle {
        font-size: 1rem;
        color: var(--text-medium);
        margin-top: 0.5rem;
        font-weight: 400;
    }
    
    .actions {
        display: flex;
        gap: 1rem;
    }
    
    .btn {
        padding: 0.75rem 1.75rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
        color: white;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(46, 125, 50, 0.3);
        background: linear-gradient(135deg, var(--primary-green-dark), var(--primary-green));
    }
    
    .btn-secondary {
        background-color: white;
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
    }
    
    .btn-secondary:hover {
        background-color: rgba(46, 125, 50, 0.05);
    }
    
    .btn-success {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
        color: white;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(46, 125, 50, 0.3);
    }
    
    /* KPI Cards */
    .kpi-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .kpi-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border-left: 5px solid;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 100%);
    }
    
    .kpi-card.ingresos {
        border-left-color: var(--primary-green);
        background: linear-gradient(135deg, #f1f8e9, #ffffff);
    }
    
    .kpi-card.egresos {
        border-left-color: var(--primary-red);
        background: linear-gradient(135deg, #ffebee, #ffffff);
    }
    
    .kpi-card.rentabilidad {
        border-left-color: var(--primary-blue);
        background: linear-gradient(135deg, #e3f2fd, #ffffff);
    }
    
    .kpi-card.flow {
        border-left-color: var(--accent-teal);
        background: linear-gradient(135deg, #e0f2f1, #ffffff);
    }
    
    .kpi-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .kpi-title {
        font-size: 0.95rem;
        color: var(--text-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .kpi-icon.ingresos {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
    }
    
    .kpi-icon.egresos {
        background: linear-gradient(135deg, var(--primary-red), #ef5350);
    }
    
    .kpi-icon.rentabilidad {
        background: linear-gradient(135deg, var(--primary-blue), #42a5f5);
    }
    
    .kpi-icon.flow {
        background: linear-gradient(135deg, var(--accent-teal), #26a69a);
    }
    
    .kpi-value {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }
    
    .kpi-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .trend-up {
        color: var(--success);
    }
    
    .trend-down {
        color: var(--error);
    }
    
    .trend-neutral {
        color: var(--text-light);
    }
    
    .kpi-period {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }
    
    /* Gráficos y Visualizaciones */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .chart-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        font-size: 1.3rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .chart-period {
        font-size: 0.9rem;
        color: var(--text-light);
        background-color: rgba(0, 0, 0, 0.03);
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
    }
    
    .chart-container {
        height: 300px;
        position: relative;
        margin-top: 1rem;
    }
    
    .chart-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        border: 1px solid var(--border-light);
        background-color: white;
        overflow: hidden;
        position: relative;
    }
    
    /* Gráfico de barras CORREGIDO */
    .bar-chart {
        width: 100%;
        height: 100%;
        padding: 20px 20px 50px 60px;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    
    .chart-y-axis {
        position: absolute;
        left: 10px;
        top: 20px;
        bottom: 50px;
        width: 45px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
        padding-right: 10px;
        font-size: 0.75rem;
        color: var(--text-light);
    }
    
    .chart-grid {
        position: absolute;
        top: 20px;
        left: 60px;
        right: 20px;
        bottom: 50px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
    }
    
    .grid-line {
        border-top: 1px dashed var(--border-light);
        width: 100%;
    }
    
    .bar-chart-container {
        position: absolute;
        left: 60px;
        right: 20px;
        top: 20px;
        bottom: 50px;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        gap: 8px;
    }
    
    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        flex: 1;
        position: relative;
    }
    
    .bar-wrapper {
        display: flex;
        gap: 3px;
        align-items: flex-end;
        height: 100%;
        width: 100%;
        justify-content: center;
    }
    
    .bar-income {
        background: linear-gradient(to top, var(--primary-green), #81c784);
        width: 45%;
        max-width: 25px;
        border-radius: 4px 4px 0 0;
        min-height: 5px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .bar-expense {
        background: linear-gradient(to top, var(--primary-red), #e57373);
        width: 45%;
        max-width: 25px;
        border-radius: 4px 4px 0 0;
        min-height: 5px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .bar-income:hover,
    .bar-expense:hover {
        filter: brightness(1.15);
        cursor: pointer;
    }
    
    .bar-label {
        position: absolute;
        bottom: -35px;
        font-size: 0.7rem;
        color: var(--text-medium);
        text-align: center;
        white-space: nowrap;
        left: 50%;
        transform: translateX(-50%);
    }
    
    /* Gráfico de dona CORREGIDO */
    .doughnut-chart {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .doughnut-container {
        position: relative;
        width: 240px;
        height: 240px;
    }
    
    .doughnut-svg {
        width: 100%;
        height: 100%;
    }
    
    .doughnut-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    
    .doughnut-total {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .doughnut-label {
        font-size: 0.8rem;
        color: var(--text-medium);
        margin-top: 4px;
    }
    
    .chart-legend {
        display: flex;
        gap: 1.5rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-medium);
        padding: 0.25rem 0.75rem;
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: 20px;
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }
    
    .legend-color.ingresos {
        background-color: var(--primary-green);
    }
    
    .legend-color.egresos {
        background-color: var(--primary-red);
    }
    
    .legend-color.materiales {
        background-color: #4caf50;
    }
    
    .legend-color.mano-obra {
        background-color: #2196f3;
    }
    
    .legend-color.operaciones {
        background-color: #ff9800;
    }
    
    .legend-color.administrativo {
        background-color: #9c27b0;
    }
    
    /* Tablas de Transacciones */
    .tables-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .table-card {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .table-title {
        font-size: 1.3rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .table-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }
    
    .financial-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 500px;
    }
    
    .financial-table th {
        background-color: rgba(0, 0, 0, 0.02);
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-medium);
        border-bottom: 2px solid var(--border-light);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .financial-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-light);
        color: var(--text-dark);
    }
    
    .financial-table tr:hover {
        background-color: rgba(0, 0, 0, 0.015);
    }
    
    .financial-table tr:last-child td {
        border-bottom: none;
    }
    
    .amount {
        font-weight: 600;
        font-family: 'Roboto Mono', monospace;
    }
    
    .amount.positive {
        color: var(--primary-green);
    }
    
    .amount.negative {
        color: var(--primary-red);
    }
    
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pagado {
        background-color: rgba(76, 175, 80, 0.1);
        color: var(--primary-green);
    }
    
    .status-pendiente {
        background-color: rgba(255, 152, 0, 0.1);
        color: var(--warning);
    }
    
    .status-vencido {
        background-color: rgba(244, 67, 54, 0.1);
        color: var(--error);
    }
    
    .status-procesado {
        background-color: rgba(33, 150, 243, 0.1);
        color: var(--info);
    }
    
    /* Presupuesto vs Real */
    .budget-section {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 2.5rem;
    }
    
    .budget-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .budget-title {
        font-size: 1.3rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .budget-select {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-light);
        border-radius: 6px;
        background-color: white;
        color: var(--text-dark);
        font-size: 0.9rem;
    }
    
    .budget-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .budget-category {
        background-color: rgba(0, 0, 0, 0.01);
        border-radius: 8px;
        padding: 1.5rem;
        border: 1px solid var(--border-light);
    }
    
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .category-title {
        font-size: 1.1rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .category-amount {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
    }
    
    .progress-bar {
        height: 8px;
        background-color: var(--border-light);
        border-radius: 4px;
        margin: 1rem 0;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    .progress-fill.within {
        background: linear-gradient(90deg, var(--primary-green), var(--primary-green-light));
    }
    
    .progress-fill.over {
        background: linear-gradient(90deg, var(--error), #ef5350);
    }
    
    .progress-fill.under {
        background: linear-gradient(90deg, var(--warning), #ffb74d);
    }
    
    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: var(--text-light);
    }
    
    /* Alertas Financieras */
    .alerts-section {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 2.5rem;
    }
    
    .alerts-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .alerts-title {
        font-size: 1.3rem;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .alerts-count {
        background-color: var(--error);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .alert-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-light);
        transition: background-color 0.3s ease;
    }
    
    .alert-item:hover {
        background-color: rgba(0, 0, 0, 0.015);
    }
    
    .alert-item:last-child {
        border-bottom: none;
    }
    
    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .alert-icon.critical {
        background-color: rgba(244, 67, 54, 0.1);
        color: var(--error);
    }
    
    .alert-icon.warning {
        background-color: rgba(255, 152, 0, 0.1);
        color: var(--warning);
    }
    
    .alert-icon.info {
        background-color: rgba(33, 150, 243, 0.1);
        color: var(--info);
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }
    
    .alert-desc {
        font-size: 0.9rem;
        color: var(--text-medium);
        line-height: 1.4;
    }
    
    .alert-time {
        font-size: 0.8rem;
        color: var(--text-light);
        margin-top: 0.5rem;
    }
    
    /* Filtros Avanzados */
    .filters-section {
        background-color: var(--card-bg);
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 2.5rem;
    }
    
    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        cursor: pointer;
    }
    
    .filters-title {
        font-size: 1.3rem;
        color: var(--text-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .filters-content {
        display: none;
    }
    
    .filters-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filter-label {
        font-size: 0.9rem;
        color: var(--text-medium);
        font-weight: 600;
    }
    
    .filter-select, .filter-input, .filter-date {
        padding: 0.75rem;
        border: 1px solid var(--border-light);
        border-radius: 6px;
        font-size: 0.95rem;
        color: var(--text-dark);
        background-color: white;
        transition: border-color 0.3s ease;
    }
    
    .filter-select:focus, .filter-input:focus, .filter-date:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
    }
    
    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-light);
    }
    
    /* Tooltip */
    .chart-tooltip {
        position: absolute;
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        z-index: 100;
        white-space: nowrap;
        pointer-events: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .charts-section,
        .tables-section {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        
        .actions {
            width: 100%;
            justify-content: flex-start;
        }
        
        .btn {
            padding: 0.65rem 1.25rem;
        }
        
        .kpi-section {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
        
        .chart-card,
        .table-card,
        .budget-section,
        .alerts-section,
        .filters-section {
            padding: 1.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .kpi-section {
            grid-template-columns: 1fr;
        }
        
        .filters-row {
            grid-template-columns: 1fr;
        }
        
        .table-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="main-content">
    <!-- Encabezado de página -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-chart-line"></i> Dashboard Financiero
            </h1>
            <p class="page-subtitle">Análisis integral de la salud financiera de la empresa</p>
        </div>
        <div class="actions">
            <button class="btn btn-secondary" id="export-report-btn">
                <i class="fas fa-file-export"></i> Exportar Reporte
            </button>
            <button class="btn btn-primary" id="generate-report-btn">
                <i class="fas fa-chart-bar"></i> Generar Análisis
            </button>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="kpi-section">
        <div class="kpi-card ingresos">
            <div class="kpi-header">
                <div>
                    <div class="kpi-title">Ingresos Totales</div>
                    <div class="kpi-value">$8.4M</div>
                </div>
                <div class="kpi-icon ingresos">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <div class="kpi-trend trend-up">
                <i class="fas fa-arrow-up"></i>
                <span>12.5% vs mes anterior</span>
            </div>
            <div class="kpi-period">Acumulado anual 2024</div>
        </div>
        
        <div class="kpi-card egresos">
            <div class="kpi-header">
                <div>
                    <div class="kpi-title">Egresos Totales</div>
                    <div class="kpi-value">$5.2M</div>
                </div>
                <div class="kpi-icon egresos">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
            <div class="kpi-trend trend-down">
                <i class="fas fa-arrow-down"></i>
                <span>3.2% vs mes anterior</span>
            </div>
            <div class="kpi-period">Controlado vs presupuesto</div>
        </div>
        
        <div class="kpi-card rentabilidad">
            <div class="kpi-header">
                <div>
                    <div class="kpi-title">Margen de Utilidad</div>
                    <div class="kpi-value">38.1%</div>
                </div>
                <div class="kpi-icon rentabilidad">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
            <div class="kpi-trend trend-up">
                <i class="fas fa-arrow-up"></i>
                <span>2.4% vs mes anterior</span>
            </div>
            <div class="kpi-period">Meta anual: 35%</div>
        </div>
        
        <div class="kpi-card flow">
            <div class="kpi-header">
                <div>
                    <div class="kpi-title">Flujo de Caja</div>
                    <div class="kpi-value">$1.8M</div>
                </div>
                <div class="kpi-icon flow">
                    <i class="fas fa-exchange-alt"></i>
                </div>
            </div>
            <div class="kpi-trend trend-up">
                <i class="fas fa-arrow-up"></i>
                <span>8.7% vs mes anterior</span>
            </div>
            <div class="kpi-period">Neto operacional</div>
        </div>
    </div>

    <!-- Gráficos de Análisis -->
    <div class="charts-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Ingresos vs Egresos Mensuales</h3>
                <span class="chart-period">Últimos 12 meses</span>
            </div>
            <div class="chart-container">
                <div class="chart-placeholder">
                    <div class="bar-chart">
                        <div class="chart-y-axis">
                            <span>$1.4M</span>
                            <span>$1.2M</span>
                            <span>$1.0M</span>
                            <span>$800K</span>
                            <span>$600K</span>
                            <span>$400K</span>
                        </div>
                        <div class="chart-grid">
                            <div class="grid-line"></div>
                            <div class="grid-line"></div>
                            <div class="grid-line"></div>
                            <div class="grid-line"></div>
                            <div class="grid-line"></div>
                        </div>
                        <div class="bar-chart-container">
                            <!-- Enero -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 60%;" data-value="$850,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 46%;" data-value="$650,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Ene</div>
                            </div>
                            <!-- Febrero -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 56%;" data-value="$780,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 44%;" data-value="$620,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Feb</div>
                            </div>
                            <!-- Marzo -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 66%;" data-value="$920,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 50%;" data-value="$700,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Mar</div>
                            </div>
                            <!-- Abril -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 63%;" data-value="$880,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 48%;" data-value="$680,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Abr</div>
                            </div>
                            <!-- Mayo -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 68%;" data-value="$950,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 53%;" data-value="$750,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">May</div>
                            </div>
                            <!-- Junio -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 71%;" data-value="$1,000,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 57%;" data-value="$800,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Jun</div>
                            </div>
                            <!-- Julio -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 75%;" data-value="$1,050,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 61%;" data-value="$850,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Jul</div>
                            </div>
                            <!-- Agosto -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 79%;" data-value="$1,100,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 64%;" data-value="$900,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Ago</div>
                            </div>
                            <!-- Septiembre -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 82%;" data-value="$1,150,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 66%;" data-value="$920,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Sep</div>
                            </div>
                            <!-- Octubre -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 86%;" data-value="$1,200,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 68%;" data-value="$950,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Oct</div>
                            </div>
                            <!-- Noviembre -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 89%;" data-value="$1,250,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 70%;" data-value="$980,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Nov</div>
                            </div>
                            <!-- Diciembre -->
                            <div class="bar-group">
                                <div class="bar-wrapper">
                                    <div class="bar-income" style="height: 93%;" data-value="$1,300,000" data-label="Ingresos"></div>
                                    <div class="bar-expense" style="height: 71%;" data-value="$1,000,000" data-label="Egresos"></div>
                                </div>
                                <div class="bar-label">Dic</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color ingresos"></span>
                    <span>Ingresos</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color egresos"></span>
                    <span>Egresos</span>
                </div>
            </div>
        </div>
        
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Distribución de Egresos</h3>
                <span class="chart-period">Octubre 2024</span>
            </div>
            <div class="chart-container">
                <div class="chart-placeholder">
                    <div class="doughnut-chart">
                        <div class="doughnut-container">
                            <svg class="doughnut-svg" viewBox="0 0 200 200">
                                <!-- Materiales - 42% -->
                                <circle cx="100" cy="100" r="70" fill="none" stroke="#4caf50" stroke-width="35" 
                                    stroke-dasharray="184.6 439.8" stroke-dashoffset="0" 
                                    transform="rotate(-90 100 100)" />
                                <!-- Mano de Obra - 35% -->
                                <circle cx="100" cy="100" r="70" fill="none" stroke="#2196f3" stroke-width="35" 
                                    stroke-dasharray="154.0 439.8" stroke-dashoffset="-184.6" 
                                    transform="rotate(-90 100 100)" />
                                <!-- Operaciones - 15% -->
                                <circle cx="100" cy="100" r="70" fill="none" stroke="#ff9800" stroke-width="35" 
                                    stroke-dasharray="65.97 439.8" stroke-dashoffset="-338.6" 
                                    transform="rotate(-90 100 100)" />
                                <!-- Administrativo - 8% -->
                                <circle cx="100" cy="100" r="70" fill="none" stroke="#9c27b0" stroke-width="35" 
                                    stroke-dasharray="35.18 439.8" stroke-dashoffset="-404.57" 
                                    transform="rotate(-90 100 100)" />
                            </svg>
                            <div class="doughnut-center">
                                <div class="doughnut-total">$1.2M</div>
                                <div class="doughnut-label">Total Egresos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color materiales"></span>
                    <span>Materiales (42%)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color mano-obra"></span>
                    <span>Mano de Obra (35%)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color operaciones"></span>
                    <span>Operaciones (15%)</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color administrativo"></span>
                    <span>Administrativo (8%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de Transacciones -->
    <div class="tables-section">
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Ingresos Recientes</h3>
                <div class="table-actions">
                    <button class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
            </div>
            <div class="table-container">
                <table class="financial-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15/10/2023</td>
                            <td>Edificio Corporativo Alpha</td>
                            <td>Corporación Constructora S.A.</td>
                            <td class="amount positive">$1,250,000</td>
                            <td><span class="status-badge status-pagado">Pagado</span></td>
                        </tr>
                        <tr>
                            <td>12/10/2023</td>
                            <td>Puente Vehicular Norte</td>
                            <td>Ministerio de Obras Públicas</td>
                            <td class="amount positive">$850,000</td>
                            <td><span class="status-badge status-pagado">Pagado</span></td>
                        </tr>
                        <tr>
                            <td>10/10/2023</td>
                            <td>Centro Comercial Plaza</td>
                            <td>Desarrollos Urbanos Ltda.</td>
                            <td class="amount positive">$2,100,000</td>
                            <td><span class="status-badge status-procesado">Procesado</span></td>
                        </tr>
                        <tr>
                            <td>05/10/2023</td>
                            <td>Hospital Regional</td>
                            <td>Servicio de Salud</td>
                            <td class="amount positive">$3,500,000</td>
                            <td><span class="status-badge status-pendiente">Pendiente</span></td>
                        </tr>
                        <tr>
                            <td>01/10/2023</td>
                            <td>Condominio Residencial</td>
                            <td>Inmobiliaria Horizonte</td>
                            <td class="amount positive">$680,000</td>
                            <td><span class="status-badge status-pagado">Pagado</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Egresos Recientes</h3>
                <div class="table-actions">
                    <button class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
            </div>
            <div class="table-container">
                <table class="financial-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Categoría</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>16/10/2023</td>
                            <td>Acme Materials S.A.</td>
                            <td>Materiales de Construcción</td>
                            <td class="amount negative">$245,000</td>
                            <td><span class="status-badge status-pagado">Pagado</span></td>
                        </tr>
                        <tr>
                            <td>14/10/2023</td>
                            <td>Constructores Unidos</td>
                            <td>Subcontratación</td>
                            <td class="amount negative">$180,000</td>
                            <td><span class="status-badge status-pendiente">Pendiente</span></td>
                        </tr>
                        <tr>
                            <td>12/10/2023</td>
                            <td>Energía Nacional</td>
                            <td>Servicios Básicos</td>
                            <td class="amount negative">$15,200</td>
                            <td><span class="status-badge status-pagado">Pagado</span></td>
                        </tr>
                        <tr>
                            <td>10/10/2023</td>
                            <td>Equipos Pesados Ltda.</td>
                            <td>Arriendo de Maquinaria</td>
                            <td class="amount negative">$42,500</td>
                            <td><span class="status-badge status-procesado">Procesado</span></td>
                        </tr>
                        <tr>
                            <td>08/10/2023</td>
                            <td>Seguros Protección</td>
                            <td>Primas de Seguro</td>
                            <td class="amount negative">$28,700</td>
                            <td><span class="status-badge status-vencido">Vencido</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Presupuesto vs Real -->
    <div class="budget-section">
        <div class="budget-header">
            <h3 class="budget-title">Presupuesto vs Real (2024)</h3>
            <select class="budget-select" id="budget-period">
                <option value="q4">Q4 - Octubre a Diciembre</option>
                <option value="q3">Q3 - Julio a Septiembre</option>
                <option value="q2">Q2 - Abril a Junio</option>
                <option value="q1">Q1 - Enero a Marzo</option>
                <option value="annual">Anual Completo</option>
            </select>
        </div>
        <div class="budget-grid">
            <div class="budget-category">
                <div class="category-header">
                    <span class="category-title">Materiales</span>
                    <span class="category-amount">$2.1M / $2.5M</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill within" style="width: 84%"></div>
                </div>
                <div class="progress-labels">
                    <span>Presupuesto: $2.5M</span>
                    <span>Ejecutado: 84%</span>
                </div>
            </div>
            
            <div class="budget-category">
                <div class="category-header">
                    <span class="category-title">Mano de Obra</span>
                    <span class="category-amount">$1.8M / $1.7M</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill over" style="width: 106%"></div>
                </div>
                <div class="progress-labels">
                    <span>Presupuesto: $1.7M</span>
                    <span>Ejecutado: 106%</span>
                </div>
            </div>
            
            <div class="budget-category">
                <div class="category-header">
                    <span class="category-title">Equipos</span>
                    <span class="category-amount">$450K / $600K</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill under" style="width: 75%"></div>
                </div>
                <div class="progress-labels">
                    <span>Presupuesto: $600K</span>
                    <span>Ejecutado: 75%</span>
                </div>
            </div>
            
            <div class="budget-category">
                <div class="category-header">
                    <span class="category-title">Administrativo</span>
                    <span class="category-amount">$320K / $350K</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill within" style="width: 91%"></div>
                </div>
                <div class="progress-labels">
                    <span>Presupuesto: $350K</span>
                    <span>Ejecutado: 91%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas Financieras -->
    <div class="alerts-section">
        <div class="alerts-header">
            <h3 class="alerts-title">Alertas Financieras</h3>
            <span class="alerts-count">3 críticas</span>
        </div>
        <div class="alert-list">
            <div class="alert-item">
                <div class="alert-icon critical">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Exceso en presupuesto de Mano de Obra</div>
                    <div class="alert-desc">El gasto en mano de obra ha superado el presupuesto asignado en un 6%. Revisar contrataciones y horas extras.</div>
                    <div class="alert-time">Hace 2 días • Presupuesto Q4 2024</div>
                </div>
            </div>
            
            <div class="alert-item">
                <div class="alert-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Pago de seguro vencido</div>
                    <div class="alert-desc">El pago de la prima de seguro con Seguros Protección está vencido desde el 08/10/2023.</div>
                    <div class="alert-time">Hace 5 días • Monto: $28,700</div>
                </div>
            </div>
            
            <div class="alert-item">
                <div class="alert-icon info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Tendencia positiva en margen de utilidad</div>
                    <div class="alert-desc">El margen de utilidad ha aumentado un 2.4% este mes, superando la meta anual establecida.</div>
                    <div class="alert-time">Hoy • Meta anual: 35% | Actual: 38.1%</div>
                </div>
            </div>
            
            <div class="alert-item">
                <div class="alert-icon warning">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">Proyecto con retraso en pagos</div>
                    <div class="alert-desc">El pago del Hospital Regional (Servicio de Salud) lleva 5 días en estado pendiente.</div>
                    <div class="alert-time">Hace 3 días • Monto: $3,500,000</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Avanzados -->
    <div class="filters-section">
        <div class="filters-header" id="toggle-filters">
            <h3 class="filters-title">
                <i class="fas fa-sliders-h"></i> Filtros Avanzados
                <i class="fas fa-chevron-down" id="filters-chevron"></i>
            </h3>
        </div>
        <div class="filters-content" id="filters-content">
            <form id="financial-filters">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Período de Tiempo</label>
                        <select class="filter-select" name="period">
                            <option value="current_month">Mes Actual</option>
                            <option value="last_month">Mes Anterior</option>
                            <option value="quarter">Trimestre Actual</option>
                            <option value="year">Año Actual</option>
                            <option value="custom">Personalizado</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Tipo de Transacción</label>
                        <select class="filter-select" name="transaction_type">
                            <option value="all">Todos los tipos</option>
                            <option value="income">Solo Ingresos</option>
                            <option value="expense">Solo Egresos</option>
                            <option value="transfer">Transferencias</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Proyecto</label>
                        <select class="filter-select" name="project">
                            <option value="all">Todos los proyectos</option>
                            <option value="alpha">Edificio Corporativo Alpha</option>
                            <option value="bridge">Puente Vehicular Norte</option>
                            <option value="mall">Centro Comercial Plaza</option>
                            <option value="hospital">Hospital Regional</option>
                            <option value="condo">Condominio Residencial</option>
                        </select>
                    </div>
                </div>
                
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Rango de Monto</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="number" class="filter-input" name="amount_min" placeholder="Mínimo" style="flex: 1;">
                            <input type="number" class="filter-input" name="amount_max" placeholder="Máximo" style="flex: 1;">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select class="filter-select" name="status">
                            <option value="all">Todos los estados</option>
                            <option value="paid">Pagado</option>
                            <option value="pending">Pendiente</option>
                            <option value="processing">Procesando</option>
                            <option value="overdue">Vencido</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Categoría</label>
                        <select class="filter-select" name="category">
                            <option value="all">Todas las categorías</option>
                            <option value="materials">Materiales</option>
                            <option value="labor">Mano de Obra</option>
                            <option value="equipment">Equipos</option>
                            <option value="administrative">Administrativo</option>
                            <option value="services">Servicios</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="button" class="btn btn-secondary" id="clear-filters">
                        <i class="fas fa-times"></i> Limpiar Filtros
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filtros avanzados
        const toggleFilters = document.getElementById('toggle-filters');
        const filtersContent = document.getElementById('filters-content');
        const filtersChevron = document.getElementById('filters-chevron');
        
        toggleFilters.addEventListener('click', function() {
            filtersContent.classList.toggle('active');
            filtersChevron.classList.toggle('fa-chevron-down');
            filtersChevron.classList.toggle('fa-chevron-up');
        });
        
        // Limpiar filtros
        document.getElementById('clear-filters').addEventListener('click', function() {
            const form = document.getElementById('financial-filters');
            form.reset();
            alert('Filtros limpiados correctamente');
        });
        
        // Aplicar filtros
        document.getElementById('financial-filters').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            console.log('Filtros aplicados:', {
                period: formData.get('period'),
                transaction_type: formData.get('transaction_type'),
                project: formData.get('project'),
                amount_min: formData.get('amount_min'),
                amount_max: formData.get('amount_max'),
                status: formData.get('status'),
                category: formData.get('category')
            });
            
            alert('Filtros aplicados correctamente. En una implementación real, se actualizarían los datos y gráficos.');
            
            filtersContent.classList.remove('active');
            filtersChevron.classList.remove('fa-chevron-up');
            filtersChevron.classList.add('fa-chevron-down');
        });
        
        // Cambiar período de presupuesto
        document.getElementById('budget-period').addEventListener('change', function() {
            alert(`Período de presupuesto cambiado a: ${this.options[this.selectedIndex].text}. En una implementación real, se cargarían los datos correspondientes al período seleccionado.`);
        });
        
        // Exportar reporte
        document.getElementById('export-report-btn').addEventListener('click', function() {
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
            this.disabled = true;
            
            setTimeout(() => {
                alert('✅ Reporte financiero generado exitosamente\n\n📊 Formatos disponibles para descarga:\n• PDF - Análisis completo\n• Excel - Datos detallados\n• CSV - Para procesamiento\n\n📁 El archivo se descargará automáticamente.');
                this.innerHTML = originalHTML;
                this.disabled = false;
            }, 1500);
        });
        
        // Generar análisis
        document.getElementById('generate-report-btn').addEventListener('click', function() {
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Analizando...';
            this.disabled = true;
            
            setTimeout(() => {
                alert('📈 Análisis financiero completado\n\n🔍 Hallazgos principales:\n• Margen de utilidad: +2.4% vs mes anterior\n• Flujo de caja: Saludable (+8.7%)\n• Rentabilidad: Supera meta anual (38.1% vs 35%)\n• Alertas: 3 puntos críticos detectados\n\n💡 Recomendaciones:\n1. Controlar gastos en mano de obra\n2. Revisar pagos pendientes\n3. Optimizar compra de materiales');
                this.innerHTML = originalHTML;
                this.disabled = false;
            }, 2000);
        });
        
        // Tooltips para barras
        let currentTooltip = null;
        
        document.querySelectorAll('.bar-income, .bar-expense').forEach(bar => {
            bar.addEventListener('mouseenter', function(e) {
                const value = this.getAttribute('data-value');
                const label = this.getAttribute('data-label');
                
                if (value) {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'chart-tooltip';
                    tooltip.textContent = `${label}: ${value}`;
                    tooltip.style.position = 'fixed';
                    tooltip.style.left = e.clientX + 'px';
                    tooltip.style.top = (e.clientY - 40) + 'px';
                    
                    document.body.appendChild(tooltip);
                    currentTooltip = tooltip;
                }
            });
            
            bar.addEventListener('mousemove', function(e) {
                if (currentTooltip) {
                    currentTooltip.style.left = e.clientX + 'px';
                    currentTooltip.style.top = (e.clientY - 40) + 'px';
                }
            });
            
            bar.addEventListener('mouseleave', function() {
                if (currentTooltip) {
                    document.body.removeChild(currentTooltip);
                    currentTooltip = null;
                }
            });
        });
        
        // Animación inicial de entrada
        setTimeout(() => {
            document.querySelectorAll('.kpi-card').forEach((card, index) => {
                card.style.animation = `fadeIn 0.5s ease ${index * 0.1}s forwards`;
                card.style.opacity = '0';
            });
        }, 100);
    });
</script>
@endsection