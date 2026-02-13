@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-blue: #1565c0;
        --primary-blue-light: #1e88e5;
        --primary-blue-dark: #0d47a1;
        --primary-green: #2e7d32;
        --primary-green-light: #4caf50;
        --primary-red: #c62828;
        --primary-purple: #6a1b9a;
        --primary-cyan: #00838f;
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
        color: var(--primary-blue);
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
        min-width: 200px;
        cursor: pointer;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
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
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
        color: white;
        box-shadow: 0 3px 8px rgba(21, 101, 192, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(21, 101, 192, 0.4);
    }
    
    .btn-success {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
        color: white;
        box-shadow: 0 3px 8px rgba(46, 125, 50, 0.3);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(46, 125, 50, 0.4);
    }
    
    .btn-excel {
        background: linear-gradient(135deg, #217346, #2d9558);
        color: white;
        box-shadow: 0 3px 8px rgba(33, 115, 70, 0.3);
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #c62828, #e53935);
        color: white;
        box-shadow: 0 3px 8px rgba(198, 40, 40, 0.3);
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
    
    .kpi-card.total {
        border-color: var(--primary-blue);
    }
    
    .kpi-card.total::before {
        background: linear-gradient(90deg, var(--primary-blue), var(--primary-blue-light));
    }
    
    .kpi-card.prospecto {
        border-color: #7e57c2;
    }
    
    .kpi-card.prospecto::before {
        background: linear-gradient(90deg, #7e57c2, #9575cd);
    }
    
    .kpi-card.cotizacion {
        border-color: #ff9800;
    }
    
    .kpi-card.cotizacion::before {
        background: linear-gradient(90deg, #ff9800, #ffb74d);
    }
    
    .kpi-card.negociacion {
        border-color: #26a69a;
    }
    
    .kpi-card.negociacion::before {
        background: linear-gradient(90deg, #26a69a, #4db6ac);
    }
    
    .kpi-card.cierre {
        border-color: #4caf50;
    }
    
    .kpi-card.cierre::before {
        background: linear-gradient(90deg, #4caf50, #66bb6a);
    }
    
    .kpi-card.perdido {
        border-color: #ef5350;
    }
    
    .kpi-card.perdido::before {
        background: linear-gradient(90deg, #ef5350, #e53935);
    }
    
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
    
    .kpi-icon-box.blue {
        background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-light));
    }
    
    .kpi-icon-box.purple {
        background: linear-gradient(135deg, #7e57c2, #9575cd);
    }
    
    .kpi-icon-box.orange {
        background: linear-gradient(135deg, #ff9800, #ffb74d);
    }
    
    .kpi-icon-box.teal {
        background: linear-gradient(135deg, #26a69a, #4db6ac);
    }
    
    .kpi-icon-box.green {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
    }
    
    .kpi-icon-box.red {
        background: linear-gradient(135deg, #ef5350, #e53935);
    }
    
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
    
    /* Pipeline Kanban */
    .pipeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .pipeline-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark-bg);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pipeline-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .view-toggle {
        display: flex;
        background: white;
        border-radius: 6px;
        border: 1px solid var(--border-light);
        overflow: hidden;
    }
    
    .view-btn {
        padding: 0.5rem 1rem;
        background: white;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--text-medium);
    }
    
    .view-btn.active {
        background: var(--primary-blue);
        color: white;
    }
    
    .view-btn i {
        font-size: 0.9rem;
    }
    
    .kanban-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .kanban-column {
        background: #f8f9fc;
        border-radius: 10px;
        border: 1px solid var(--border-light);
        display: flex;
        flex-direction: column;
        height: fit-content;
        min-height: 500px;
    }
    
    .column-header {
        padding: 1rem;
        border-bottom: 3px solid;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .column-header.prospecto {
        background: linear-gradient(135deg, #ede7f6, #f3e5f5);
        border-bottom-color: #7e57c2;
    }
    
    .column-header.cotizacion {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border-bottom-color: #ff9800;
    }
    
    .column-header.negociacion {
        background: linear-gradient(135deg, #e0f2f1, #b2dfdb);
        border-bottom-color: #26a69a;
    }
    
    .column-header.cierre {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-bottom-color: #4caf50;
    }
    
    .column-header.ganado {
        background: linear-gradient(135deg, #e8f5e9, #a5d6a5);
        border-bottom-color: #2e7d32;
    }
    
    .column-header.perdido {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        border-bottom-color: #ef5350;
    }
    
    .column-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
    }
    
    .column-title i {
        font-size: 1rem;
    }
    
    .column-count {
        background: rgba(0, 0, 0, 0.1);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .column-total {
        padding: 0.5rem 1rem;
        background: rgba(0, 0, 0, 0.02);
        border-top: 1px solid var(--border-light);
        font-size: 0.8rem;
        display: flex;
        justify-content: space-between;
        font-weight: 600;
    }
    
    .column-total span:last-child {
        font-family: 'Roboto Mono', monospace;
        color: var(--dark-bg);
    }
    
    .kanban-cards {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        flex: 1;
        overflow-y: auto;
        max-height: 500px;
    }
    
    .pipeline-card {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--border-light);
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .pipeline-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border-color: var(--primary-blue);
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .project-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-dark);
    }
    
    .client-name {
        font-size: 0.75rem;
        color: var(--text-medium);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.2rem;
    }
    
    .project-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .badge-alta {
        background: #ffebee;
        color: #c62828;
    }
    
    .badge-media {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    .badge-baja {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .card-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .project-amount {
        font-family: 'Roboto Mono', monospace;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--dark-bg);
    }
    
    .project-date {
        font-size: 0.7rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .progress-container {
        margin-top: 0.25rem;
    }
    
    .progress-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.65rem;
        margin-bottom: 0.2rem;
    }
    
    .progress-bar {
        height: 6px;
        background: var(--border-light);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 3px;
    }
    
    .progress-fill.prospecto { background: #7e57c2; }
    .progress-fill.cotizacion { background: #ff9800; }
    .progress-fill.negociacion { background: #26a69a; }
    .progress-fill.cierre { background: #4caf50; }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.25rem;
        padding-top: 0.5rem;
        border-top: 1px solid var(--border-light);
    }
    
    .project-manager {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.7rem;
        color: var(--text-medium);
    }
    
    .project-manager i {
        color: var(--primary-blue);
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
        padding: 0.2rem;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .card-actions button:hover {
        background: #f0f0f0;
        color: var(--primary-blue);
    }
    
    /* Tabla de Pipeline (vista alterna) */
    .table-section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
        display: none;
    }
    
    .table-section.active {
        display: block;
    }
    
    .pipeline-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .pipeline-table thead th {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        padding: 0.8rem 0.6rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.75rem;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .pipeline-table tbody td {
        padding: 0.8rem 0.6rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.75rem;
        vertical-align: middle;
    }
    
    .pipeline-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
    }
    
    .stage-badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .stage-prospecto {
        background: #ede7f6;
        color: #5e35b1;
    }
    
    .stage-cotizacion {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    .stage-negociacion {
        background: #e0f2f1;
        color: #00695c;
    }
    
    .stage-cierre {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .stage-ganado {
        background: #c8e6c9;
        color: #1b5e20;
    }
    
    .stage-perdido {
        background: #ffcdd2;
        color: #b71c1c;
    }
    
    .progress-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .progress-bar-small {
        width: 60px;
        height: 6px;
        background: var(--border-light);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill-small {
        height: 100%;
        background: var(--primary-blue);
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kanban-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .kanban-grid {
            grid-template-columns: repeat(2, 1fr);
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
        
        .kanban-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-select {
            width: 100%;
            min-width: auto;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-chart-line title-icon"></i>
                    Pipeline de Proyectos
                </h1>
                <div class="filter-section">
                    <span class="filter-label">Filtrar por:</span>
                    <select class="filter-select" id="sales-filter">
                        <option value="todos">TODOS LOS EJECUTIVOS</option>
                        <option value="carlos">Carlos Rodríguez</option>
                        <option value="maria">María González</option>
                        <option value="juan">Juan Martínez</option>
                        <option value="ana">Ana López</option>
                    </select>
                    <select class="filter-select" id="date-filter">
                        <option value="mes">Este Mes</option>
                        <option value="trimestre">Este Trimestre</option>
                        <option value="semestre">Este Semestre</option>
                        <option value="año">Este Año</option>
                    </select>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" id="new-project">
                    <i class="fas fa-plus-circle"></i>
                    Nuevo Proyecto
                </button>
                <button class="btn btn-success" id="forecast">
                    <i class="fas fa-chart-pie"></i>
                    Forecast
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
        <div class="kpi-card total">
            <div class="kpi-icon-box blue">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Pipeline Total</div>
                <div class="kpi-value">$8,450,000</div>
                <div class="kpi-subtext">18 proyectos activos</div>
            </div>
        </div>
        
        <div class="kpi-card prospecto">
            <div class="kpi-icon-box purple">
                <i class="fas fa-search"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Prospectos</div>
                <div class="kpi-value">$2,150,000</div>
                <div class="kpi-subtext">6 proyectos</div>
            </div>
        </div>
        
        <div class="kpi-card cotizacion">
            <div class="kpi-icon-box orange">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Cotizaciones</div>
                <div class="kpi-value">$2,850,000</div>
                <div class="kpi-subtext">5 proyectos</div>
            </div>
        </div>
        
        <div class="kpi-card negociacion">
            <div class="kpi-icon-box teal">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Negociación</div>
                <div class="kpi-value">$1,950,000</div>
                <div class="kpi-subtext">4 proyectos</div>
            </div>
        </div>
        
        <div class="kpi-card cierre">
            <div class="kpi-icon-box green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Cierre</div>
                <div class="kpi-value">$1,500,000</div>
                <div class="kpi-subtext">3 proyectos</div>
            </div>
        </div>
        
        <div class="kpi-card ganado">
            <div class="kpi-icon-box green">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Ganados</div>
                <div class="kpi-value">$3,250,000</div>
                <div class="kpi-subtext">8 proyectos</div>
            </div>
        </div>
        
        <div class="kpi-card perdido">
            <div class="kpi-icon-box red">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Perdidos</div>
                <div class="kpi-value">$1,120,000</div>
                <div class="kpi-subtext">5 proyectos</div>
            </div>
        </div>
    </div>

    <!-- Pipeline Header con Vista Toggle -->
    <div class="pipeline-header">
        <div class="pipeline-title">
            <i class="fas fa-tasks" style="color: var(--primary-blue);"></i>
            Seguimiento de Ventas
            <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-medium); margin-left: 0.5rem;">
                Última actualización: 11/02/2026
            </span>
        </div>
        <div class="pipeline-actions">
            <div class="view-toggle">
                <button class="view-btn active" id="view-kanban">
                    <i class="fas fa-columns"></i>
                    Kanban
                </button>
                <button class="view-btn" id="view-table">
                    <i class="fas fa-table"></i>
                    Tabla
                </button>
            </div>
        </div>
    </div>

    <!-- Vista Kanban -->
    <div id="kanban-view">
        <div class="kanban-grid">
            <!-- Columna: Prospecto -->
            <div class="kanban-column">
                <div class="column-header prospecto">
                    <div class="column-title">
                        <i class="fas fa-search"></i>
                        Prospecto
                    </div>
                    <span class="column-count">6</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Centro Comercial Plaza Norte</div>
                                <div class="client-name">
                                    <i class="fas fa-building"></i>
                                    Inmobiliaria del Valle
                                </div>
                            </div>
                            <span class="project-badge badge-media">Media</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$450,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 15/03/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">20%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill prospecto" style="width: 20%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Carlos Rodríguez
                            </div>
                            <div class="card-actions">
                                <button title="Editar"><i class="fas fa-edit"></i></button>
                                <button title="Mover"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Hotel Boutique Reforma</div>
                                <div class="client-name">
                                    <i class="fas fa-hotel"></i>
                                    Hoteles Unidos
                                </div>
                            </div>
                            <span class="project-badge badge-alta">Alta</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$780,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 22/04/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">30%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill prospecto" style="width: 30%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                María González
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Nave Industrial Toluca</div>
                                <div class="client-name">
                                    <i class="fas fa-industry"></i>
                                    Logística Integral
                                </div>
                            </div>
                            <span class="project-badge badge-baja">Baja</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$920,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 10/05/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">15%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill prospecto" style="width: 15%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Juan Martínez
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$2,150,000</span>
                </div>
            </div>

            <!-- Columna: Cotización -->
            <div class="kanban-column">
                <div class="column-header cotizacion">
                    <div class="column-title">
                        <i class="fas fa-file-invoice"></i>
                        Cotización
                    </div>
                    <span class="column-count">5</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Complejo Habitacional Bosques</div>
                                <div class="client-name">
                                    <i class="fas fa-home"></i>
                                    Constructora Habita
                                </div>
                            </div>
                            <span class="project-badge badge-alta">Alta</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$650,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 28/02/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">50%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill cotizacion" style="width: 50%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Ana López
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Puente Vehicular Sur</div>
                                <div class="client-name">
                                    <i class="fas fa-road"></i>
                                    Gobierno Estatal
                                </div>
                            </div>
                            <span class="project-badge badge-media">Media</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$1,200,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 15/03/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">45%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill cotizacion" style="width: 45%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Carlos Rodríguez
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Remodelación Aeropuerto</div>
                                <div class="client-name">
                                    <i class="fas fa-plane"></i>
                                    ASA
                                </div>
                            </div>
                            <span class="project-badge badge-alta">Alta</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$1,000,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 05/04/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">60%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill cotizacion" style="width: 60%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                María González
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$2,850,000</span>
                </div>
            </div>

            <!-- Columna: Negociación -->
            <div class="kanban-column">
                <div class="column-header negociacion">
                    <div class="column-title">
                        <i class="fas fa-handshake"></i>
                        Negociación
                    </div>
                    <span class="column-count">4</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Torre Corporativa</div>
                                <div class="client-name">
                                    <i class="fas fa-city"></i>
                                    Grupo Financiero
                                </div>
                            </div>
                            <span class="project-badge badge-alta">Alta</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$850,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 20/02/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">75%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill negociacion" style="width: 75%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Juan Martínez
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Parque Industrial</div>
                                <div class="client-name">
                                    <i class="fas fa-warehouse"></i>
                                    Industrial Park
                                </div>
                            </div>
                            <span class="project-badge badge-media">Media</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$1,100,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 10/03/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">70%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill negociacion" style="width: 70%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Ana López
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$1,950,000</span>
                </div>
            </div>

            <!-- Columna: Cierre -->
            <div class="kanban-column">
                <div class="column-header cierre">
                    <div class="column-title">
                        <i class="fas fa-check-circle"></i>
                        Cierre
                    </div>
                    <span class="column-count">3</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Centro de Distribución</div>
                                <div class="client-name">
                                    <i class="fas fa-truck"></i>
                                    Logística Express
                                </div>
                            </div>
                            <span class="project-badge badge-alta">Alta</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$600,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 18/02/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">90%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill cierre" style="width: 90%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Carlos Rodríguez
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pipeline-card">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Clínica Médica</div>
                                <div class="client-name">
                                    <i class="fas fa-hospital"></i>
                                    Salud Integral
                                </div>
                            </div>
                            <span class="project-badge badge-media">Media</span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$900,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Cierre: 25/02/26
                            </span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header">
                                <span>Probabilidad</span>
                                <span style="font-weight: 600;">85%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill cierre" style="width: 85%;"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                María González
                            </div>
                            <div class="card-actions">
                                <button><i class="fas fa-edit"></i></button>
                                <button><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$1,500,000</span>
                </div>
            </div>

            <!-- Columna: Ganados -->
            <div class="kanban-column">
                <div class="column-header ganado">
                    <div class="column-title">
                        <i class="fas fa-trophy"></i>
                        Ganados
                    </div>
                    <span class="column-count">8</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card" style="border-left: 4px solid #2e7d32;">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Edificio Corporativo</div>
                                <div class="client-name">
                                    <i class="fas fa-building"></i>
                                    Empresas ABC
                                </div>
                            </div>
                            <span style="color: #2e7d32; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> Cerrado
                            </span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$950,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Venta: 05/02/26
                            </span>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Juan Martínez
                            </div>
                            <span style="font-size: 0.7rem; color: #2e7d32;">
                                <i class="fas fa-star"></i> Comisión $47,500
                            </span>
                        </div>
                    </div>
                    
                    <div class="pipeline-card" style="border-left: 4px solid #2e7d32;">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Planta Tratamiento</div>
                                <div class="client-name">
                                    <i class="fas fa-water"></i>
                                    SAPAL
                                </div>
                            </div>
                            <span style="color: #2e7d32; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> Cerrado
                            </span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$780,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Venta: 28/01/26
                            </span>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Ana López
                            </div>
                            <span style="font-size: 0.7rem; color: #2e7d32;">
                                <i class="fas fa-star"></i> Comisión $39,000
                            </span>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$3,250,000</span>
                </div>
            </div>

            <!-- Columna: Perdidos -->
            <div class="kanban-column">
                <div class="column-header perdido">
                    <div class="column-title">
                        <i class="fas fa-times-circle"></i>
                        Perdidos
                    </div>
                    <span class="column-count">5</span>
                </div>
                <div class="kanban-cards">
                    <div class="pipeline-card" style="border-left: 4px solid #c62828; opacity: 0.8;">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Estacionamiento Subterráneo</div>
                                <div class="client-name">
                                    <i class="fas fa-parking"></i>
                                    Municipio
                                </div>
                            </div>
                            <span style="color: #c62828; font-weight: 600;">
                                <i class="fas fa-times"></i> Perdido
                            </span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$520,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Competencia
                            </span>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                Carlos Rodríguez
                            </div>
                            <span style="font-size: 0.7rem; color: #c62828;">
                                Precio
                            </span>
                        </div>
                    </div>
                    
                    <div class="pipeline-card" style="border-left: 4px solid #c62828; opacity: 0.8;">
                        <div class="card-header">
                            <div>
                                <div class="project-name">Gimnasio Municipal</div>
                                <div class="client-name">
                                    <i class="fas fa-dumbbell"></i>
                                    DIF
                                </div>
                            </div>
                            <span style="color: #c62828; font-weight: 600;">
                                <i class="fas fa-times"></i> Perdido
                            </span>
                        </div>
                        <div class="card-details">
                            <span class="project-amount">$600,000</span>
                            <span class="project-date">
                                <i class="fas fa-calendar-alt"></i>
                                Presupuesto
                            </span>
                        </div>
                        <div class="card-footer">
                            <div class="project-manager">
                                <i class="fas fa-user-circle"></i>
                                María González
                            </div>
                            <span style="font-size: 0.7rem; color: #c62828;">
                                Recortado
                            </span>
                        </div>
                    </div>
                </div>
                <div class="column-total">
                    <span>Total</span>
                    <span>$1,120,000</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista Tabla (oculta por defecto) -->
    <div id="table-view" class="table-section">
        <div class="table-responsive">
            <table class="pipeline-table">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Etapa</th>
                        <th>Prob.</th>
                        <th>Ejecutivo</th>
                        <th>Cierre</th>
                        <th>Prioridad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Centro Comercial Plaza Norte</td>
                        <td>Inmobiliaria del Valle</td>
                        <td class="amount">$450,000</td>
                        <td><span class="stage-badge stage-prospecto">Prospecto</span></td>
                        <td>20%</td>
                        <td>Carlos Rodríguez</td>
                        <td>15/03/26</td>
                        <td><span class="badge badge-media">Media</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-arrow-right"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Hotel Boutique Reforma</td>
                        <td>Hoteles Unidos</td>
                        <td class="amount">$780,000</td>
                        <td><span class="stage-badge stage-prospecto">Prospecto</span></td>
                        <td>30%</td>
                        <td>María González</td>
                        <td>22/04/26</td>
                        <td><span class="badge badge-alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-arrow-right"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Complejo Habitacional Bosques</td>
                        <td>Constructora Habita</td>
                        <td class="amount">$650,000</td>
                        <td><span class="stage-badge stage-cotizacion">Cotización</span></td>
                        <td>50%</td>
                        <td>Ana López</td>
                        <td>28/02/26</td>
                        <td><span class="badge badge-alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-arrow-right"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Torre Corporativa</td>
                        <td>Grupo Financiero</td>
                        <td class="amount">$850,000</td>
                        <td><span class="stage-badge stage-negociacion">Negociación</span></td>
                        <td>75%</td>
                        <td>Juan Martínez</td>
                        <td>20/02/26</td>
                        <td><span class="badge badge-alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-arrow-right"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Centro de Distribución</td>
                        <td>Logística Express</td>
                        <td class="amount">$600,000</td>
                        <td><span class="stage-badge stage-cierre">Cierre</span></td>
                        <td>90%</td>
                        <td>Carlos Rodríguez</td>
                        <td>18/02/26</td>
                        <td><span class="badge badge-alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-arrow-right"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Edificio Corporativo</td>
                        <td>Empresas ABC</td>
                        <td class="amount">$950,000</td>
                        <td><span class="stage-badge stage-ganado">Ganado</span></td>
                        <td>100%</td>
                        <td>Juan Martínez</td>
                        <td>05/02/26</td>
                        <td><span class="badge badge-success">Cerrado</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Estacionamiento Subterráneo</td>
                        <td>Municipio</td>
                        <td class="amount">$520,000</td>
                        <td><span class="stage-badge stage-perdido">Perdido</span></td>
                        <td>0%</td>
                        <td>Carlos Rodríguez</td>
                        <td>-</td>
                        <td><span class="badge badge-danger">Perdido</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-blue);"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Forecast y Métricas -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
        <!-- Proyección de Cierre -->
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 3px 12px rgba(0,0,0,0.06);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-chart-line" style="color: var(--primary-blue);"></i>
                    Forecast de Ventas
                </h3>
                <span style="font-size: 0.7rem; color: var(--text-light);">Proyección Q1 2026</span>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px;">
                    <div style="font-size: 0.7rem; color: var(--text-medium); margin-bottom: 0.25rem;">Best Case</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: #2e7d32; font-family: 'Roboto Mono';">$4.8M</div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">+15% vs objetivo</div>
                </div>
                <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px;">
                    <div style="font-size: 0.7rem; color: var(--text-medium); margin-bottom: 0.25rem;">Commit</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: var(--primary-blue); font-family: 'Roboto Mono';">$3.2M</div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Cierre 70% prob.</div>
                </div>
                <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px;">
                    <div style="font-size: 0.7rem; color: var(--text-medium); margin-bottom: 0.25rem;">Pipeline</div>
                    <div style="font-size: 1.3rem; font-weight: 700; color: #ff9800; font-family: 'Roboto Mono';">$8.45M</div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Total oportunidades</div>
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 1.5rem;">
                    <div>
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Tasa de cierre</span>
                        <span style="font-size: 1rem; font-weight: 600; margin-left: 0.5rem;">61.5%</span>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Ciclo promedio</span>
                        <span style="font-size: 1rem; font-weight: 600; margin-left: 0.5rem;">45 días</span>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: var(--text-medium);">Ticket promedio</span>
                        <span style="font-size: 1rem; font-weight: 600; margin-left: 0.5rem;">$469K</span>
                    </div>
                </div>
                <button class="btn btn-primary" style="padding: 0.5rem 1rem;">
                    <i class="fas fa-chart-bar"></i>
                    Ver Detalle
                </button>
            </div>
        </div>
        
        <!-- Actividad Reciente -->
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 3px 12px rgba(0,0,0,0.06);">
            <h3 style="font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <i class="fas fa-history" style="color: var(--primary-blue);"></i>
                Actividad Reciente
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
                    <div style="width: 30px; height: 30px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2e7d32;">
                        <i class="fas fa-check" style="font-size: 0.8rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; font-weight: 600;">Proyecto ganado</div>
                        <div style="font-size: 0.7rem; color: var(--text-medium);">Edificio Corporativo - $950,000</div>
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Hace 2h</div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
                    <div style="width: 30px; height: 30px; background: #fff3e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ef6c00;">
                        <i class="fas fa-file-invoice" style="font-size: 0.8rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; font-weight: 600;">Cotización enviada</div>
                        <div style="font-size: 0.7rem; color: var(--text-medium);">Puente Vehicular Sur - $1.2M</div>
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Hace 5h</div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-light);">
                    <div style="width: 30px; height: 30px; background: #e0f2f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00695c;">
                        <i class="fas fa-handshake" style="font-size: 0.8rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; font-weight: 600;">Reunión de negociación</div>
                        <div style="font-size: 0.7rem; color: var(--text-medium);">Torre Corporativa - Avance 75%</div>
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Ayer</div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 30px; height: 30px; background: #ffebee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #c62828;">
                        <i class="fas fa-times" style="font-size: 0.8rem;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; font-weight: 600;">Oportunidad perdida</div>
                        <div style="font-size: 0.7rem; color: var(--text-medium);">Gimnasio Municipal - Presupuesto</div>
                    </div>
                    <div style="font-size: 0.65rem; color: var(--text-light);">Ayer</div>
                </div>
            </div>
            
            <div style="margin-top: 1rem; text-align: center;">
                <a href="#" style="font-size: 0.75rem; color: var(--primary-blue); text-decoration: none;">Ver toda la actividad →</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle entre vista Kanban y Tabla
        const kanbanView = document.getElementById('kanban-view');
        const tableView = document.getElementById('table-view');
        const btnKanban = document.getElementById('view-kanban');
        const btnTable = document.getElementById('view-table');
        
        btnKanban.addEventListener('click', function() {
            kanbanView.style.display = 'block';
            tableView.classList.remove('active');
            btnKanban.classList.add('active');
            btnTable.classList.remove('active');
        });
        
        btnTable.addEventListener('click', function() {
            kanbanView.style.display = 'none';
            tableView.classList.add('active');
            btnTable.classList.add('active');
            btnKanban.classList.remove('active');
        });
        
        // Filtros
        const salesFilter = document.getElementById('sales-filter');
        if (salesFilter) {
            salesFilter.addEventListener('change', function() {
                showNotification(`Filtrando por: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        const dateFilter = document.getElementById('date-filter');
        if (dateFilter) {
            dateFilter.addEventListener('change', function() {
                showNotification(`Período: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        // Botón Nuevo Proyecto
        const newProject = document.getElementById('new-project');
        if (newProject) {
            newProject.addEventListener('click', function() {
                showNotification('✅ Crear nuevo proyecto - Abriendo formulario', 'success');
            });
        }
        
        // Botón Forecast
        const forecast = document.getElementById('forecast');
        if (forecast) {
            forecast.addEventListener('click', function() {
                showNotification('📊 Generando reporte de Forecast', 'info');
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
                    showNotification('✅ Excel exportado - Pipeline de proyectos', 'success');
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
                    showNotification('✅ PDF exportado - Reporte de ventas', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 800);
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
        
        // Animación de entrada para cards
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