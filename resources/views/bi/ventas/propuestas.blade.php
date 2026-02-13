@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-blue: #1565c0;
        --primary-blue-light: #1e88e5;
        --primary-blue-dark: #0d47a1;
        --primary-green: #2e7d32;
        --primary-green-light: #4caf50;
        --primary-orange: #0185A2;
        --primary-orange-light: #0185A2;
        --primary-purple: #6a1b9a;
        --primary-red: #c62828;
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
        color: var(--primary-orange);
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
        border-color: var(--primary-orange);
        box-shadow: 0 0 0 3px rgba(239, 108, 0, 0.1);
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
        background: linear-gradient(135deg, var(--primary-orange), var(--primary-orange-light));
        color: white;
        box-shadow: 0 3px 8px rgba(239, 108, 0, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(239, 108, 0, 0.4);
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
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #c62828, #e53935);
        color: white;
    }
    
    .btn-template {
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
    
    .kpi-card.total {
        border-color: var(--primary-purple);
    }
    .kpi-card.total::before { background: linear-gradient(90deg, #6a1b9a, #8e24aa); }
    
    .kpi-card.emitidas {
        border-color: var(--primary-blue);
    }
    .kpi-card.emitidas::before { background: linear-gradient(90deg, #1565c0, #1e88e5); }
    
    .kpi-card.aprobadas {
        border-color: #2e7d32;
    }
    .kpi-card.aprobadas::before { background: linear-gradient(90deg, #2e7d32, #4caf50); }
    
    .kpi-card.pendientes {
        border-color: #ff9800;
    }
    .kpi-card.pendientes::before { background: linear-gradient(90deg, #ff9800, #ffb74d); }
    
    .kpi-card.rechazadas {
        border-color: #c62828;
    }
    .kpi-card.rechazadas::before { background: linear-gradient(90deg, #c62828, #e53935); }
    
    .kpi-card.tasa {
        border-color: #26a69a;
    }
    .kpi-card.tasa::before { background: linear-gradient(90deg, #26a69a, #4db6ac); }
    
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
    
    .kpi-icon-box.purple { background: linear-gradient(135deg, #6a1b9a, #8e24aa); }
    .kpi-icon-box.blue { background: linear-gradient(135deg, #1565c0, #1e88e5); }
    .kpi-icon-box.green { background: linear-gradient(135deg, #2e7d32, #4caf50); }
    .kpi-icon-box.orange { background: linear-gradient(135deg, #ff9800, #ffb74d); }
    .kpi-icon-box.red { background: linear-gradient(135deg, #c62828, #e53935); }
    .kpi-icon-box.teal { background: linear-gradient(135deg, #26a69a, #4db6ac); }
    
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
    
    /* Pestañas */
    .tabs-container {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-light);
        padding-bottom: 0.5rem;
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
        background: var(--primary-orange);
        color: white;
        border-color: var(--primary-orange);
    }
    
    .tab-btn:hover:not(.active) {
        background: #fff3e0;
        border-color: var(--primary-orange-light);
        color: var(--primary-orange);
    }
    
    /* Tabla de Propuestas */
    .table-section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .proposals-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    
    .proposals-table thead th {
        background: linear-gradient(135deg, #129094, #129094);
        color: white;
        padding: 0.8rem 0.6rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.75rem;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .proposals-table thead th:last-child {
        border-right: none;
    }
    
    .proposals-table tbody td {
        padding: 0.8rem 0.6rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.75rem;
        vertical-align: middle;
    }
    
    .proposals-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
    }
    
    .proposals-table tbody tr:hover {
        background-color: #fff8e1;
    }
    
    .proposals-table tfoot td {
        padding: 0.8rem 0.6rem;
        background: #f5f5f5;
        font-weight: 700;
        border-top: 2px solid var(--primary-orange);
    }
    
    /* Badges de estado */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-badge.emitida {
        background: #e3f2fd;
        color: #1565c0;
    }
    
    .status-badge.enviada {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    .status-badge.vista {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .status-badge.aprobada {
        background: #c8e6c9;
        color: #1b5e20;
    }
    
    .status-badge.rechazada {
        background: #ffebee;
        color: #c62828;
    }
    
    .status-badge.caducada {
        background: #e0e0e0;
        color: #424242;
    }
    
    .status-badge.borrador {
        background: #e1f5fe;
        color: #0277bd;
    }
    
    /* Badges de prioridad */
    .priority-badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .priority-badge.alta {
        background: #ffebee;
        color: #c62828;
    }
    
    .priority-badge.media {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    .priority-badge.baja {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    /* Cards de propuestas (vista alternativa) */
    .proposals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .proposal-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border-light);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    
    .proposal-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-orange);
    }
    
    .proposal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }
    
    .proposal-card.emitida::before { background: #1565c0; }
    .proposal-card.enviada::before { background: #ef6c00; }
    .proposal-card.vista::before { background: #2e7d32; }
    .proposal-card.aprobada::before { background: #1b5e20; }
    .proposal-card.rechazada::before { background: #c62828; }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }
    
    .proposal-number {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-bottom: 0.2rem;
    }
    
    .proposal-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.75rem 0;
        font-size: 0.8rem;
    }
    
    .client-info i {
        color: var(--primary-orange);
        width: 16px;
    }
    
    .amount-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0.75rem 0;
        padding: 0.5rem 0;
        border-top: 1px dashed var(--border-light);
        border-bottom: 1px dashed var(--border-light);
    }
    
    .amount-label {
        font-size: 0.7rem;
        color: var(--text-medium);
    }
    
    .amount-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-bg);
        font-family: 'Roboto Mono', monospace;
    }
    
    .dates-info {
        display: flex;
        justify-content: space-between;
        margin: 0.75rem 0;
        font-size: 0.7rem;
        color: var(--text-medium);
    }
    
    .validity {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        background: #fff3e0;
        border-radius: 4px;
        font-size: 0.65rem;
        color: #ef6c00;
    }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-light);
    }
    
    .sales-exec {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.7rem;
        color: var(--text-medium);
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
        padding: 0.3rem;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .card-actions button:hover {
        background: #f0f0f0;
        color: var(--primary-orange);
    }
    
    /* Templates Section */
    .templates-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        margin-top: 1.5rem;
    }
    
    .templates-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }
    
    .templates-title {
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .template-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid var(--border-light);
        border-radius: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .template-card:hover {
        border-color: var(--primary-orange);
        background: #fff8e1;
    }
    
    .template-icon {
        width: 48px;
        height: 48px;
        background: #fff3e0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-orange);
        font-size: 1.5rem;
    }
    
    .template-info h4 {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    
    .template-info p {
        font-size: 0.7rem;
        color: var(--text-light);
    }
    
    /* Productos/Servicios */
    .items-tag {
        display: inline-block;
        padding: 0.15rem 0.4rem;
        background: #f5f5f5;
        border-radius: 4px;
        font-size: 0.6rem;
        color: var(--text-medium);
        margin-right: 0.2rem;
    }
    
    /* Responsive */
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
        
        .filter-select {
            width: 100%;
            min-width: auto;
        }
        
        .proposals-grid {
            grid-template-columns: 1fr;
        }
        
        .tabs-container {
            flex-wrap: wrap;
        }
        
        .tab-btn {
            flex: 1;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-file-signature title-icon"></i>
                    Propuestas y Cotizaciones
                </h1>
                <div class="filter-section">
                    <span class="filter-label">Filtrar:</span>
                    <select class="filter-select" id="status-filter">
                        <option value="todas">TODAS LAS PROPUESTAS</option>
                        <option value="emitidas">Emitidas</option>
                        <option value="enviadas">Enviadas</option>
                        <option value="vistas">Vistas</option>
                        <option value="aprobadas">Aprobadas</option>
                        <option value="rechazadas">Rechazadas</option>
                        <option value="caducadas">Caducadas</option>
                    </select>
                    <select class="filter-select" id="client-filter">
                        <option value="todos">TODOS LOS CLIENTES</option>
                        <option value="inmobiliaria">Inmobiliaria del Valle</option>
                        <option value="constructora">Constructora Habita</option>
                        <option value="logistica">Logística Integral</option>
                        <option value="gobierno">Gobierno Estatal</option>
                        <option value="grupo">Grupo Financiero</option>
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
                <button class="btn btn-primary" id="new-proposal">
                    <i class="fas fa-plus-circle"></i>
                    Nueva Propuesta
                </button>
                <button class="btn btn-template" id="templates">
                    <i class="fas fa-copy"></i>
                    Plantillas
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
            <div class="kpi-icon-box purple">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total Propuestas</div>
                <div class="kpi-value">24</div>
                <div class="kpi-subtext">Este mes: 8</div>
            </div>
        </div>
        
        <div class="kpi-card emitidas">
            <div class="kpi-icon-box blue">
                <i class="fas fa-paper-plane"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Emitidas</div>
                <div class="kpi-value">6</div>
                <div class="kpi-subtext">$2,150,000</div>
            </div>
        </div>
        
        <div class="kpi-card pendientes">
            <div class="kpi-icon-box orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Pendientes</div>
                <div class="kpi-value">10</div>
                <div class="kpi-subtext">$3,850,000</div>
            </div>
        </div>
        
        <div class="kpi-card aprobadas">
            <div class="kpi-icon-box green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Aprobadas</div>
                <div class="kpi-value">5</div>
                <div class="kpi-subtext">$1,950,000</div>
            </div>
        </div>
        
        <div class="kpi-card rechazadas">
            <div class="kpi-icon-box red">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Rechazadas</div>
                <div class="kpi-value">3</div>
                <div class="kpi-subtext">$890,000</div>
            </div>
        </div>
        
        <div class="kpi-card tasa">
            <div class="kpi-icon-box teal">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Tasa Éxito</div>
                <div class="kpi-value">32.5%</div>
                <div class="kpi-subtext">+5% vs trimestre</div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Vista -->
    <div class="tabs-container">
        <button class="tab-btn active" id="tab-lista">
            <i class="fas fa-list"></i>
            Lista de Propuestas
        </button>
        <button class="tab-btn" id="tab-grid">
            <i class="fas fa-th-large"></i>
            Vista Tarjetas
        </button>
        <button class="tab-btn" id="tab-seguimiento">
            <i class="fas fa-chart-line"></i>
            Seguimiento
        </button>
        <button class="tab-btn" id="tab-comparativa">
            <i class="fas fa-balance-scale"></i>
            Comparativa
        </button>
    </div>

    <!-- Vista: Tabla de Propuestas (activa por defecto) -->
    <div id="view-table" class="table-section" style="display: block;">
        <div class="table-responsive">
            <table class="proposals-table">
                <thead>
                    <tr>
                        <th># Propuesta</th>
                        <th>Cliente / Proyecto</th>
                        <th>Fecha Emisión</th>
                        <th>Validez</th>
                        <th>Monto</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>COT-2026-001</td>
                        <td style="text-align: left;">
                            <strong>Centro Comercial Plaza Norte</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Inmobiliaria del Valle</span>
                        </td>
                        <td>05/02/2026</td>
                        <td>15/03/2026</td>
                        <td class="amount">$450,000</td>
                        <td>Carlos R.</td>
                        <td><span class="status-badge enviada">Enviada</span></td>
                        <td><span class="priority-badge alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);" title="Ver"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);" title="Editar"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-015</td>
                        <td style="text-align: left;">
                            <strong>Hotel Boutique Reforma</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Hoteles Unidos</span>
                        </td>
                        <td>10/02/2026</td>
                        <td>22/04/2026</td>
                        <td class="amount">$780,000</td>
                        <td>María G.</td>
                        <td><span class="status-badge vista">Vista</span></td>
                        <td><span class="priority-badge alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-028</td>
                        <td style="text-align: left;">
                            <strong>Nave Industrial Toluca</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Logística Integral</span>
                        </td>
                        <td>15/02/2026</td>
                        <td>10/05/2026</td>
                        <td class="amount">$920,000</td>
                        <td>Juan M.</td>
                        <td><span class="status-badge emitida">Emitida</span></td>
                        <td><span class="priority-badge media">Media</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-042</td>
                        <td style="text-align: left;">
                            <strong>Complejo Habitacional Bosques</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Constructora Habita</span>
                        </td>
                        <td>18/02/2026</td>
                        <td>28/03/2026</td>
                        <td class="amount">$650,000</td>
                        <td>Ana L.</td>
                        <td><span class="status-badge aprobada">Aprobada</span></td>
                        <td><span class="priority-badge alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-check-circle"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-051</td>
                        <td style="text-align: left;">
                            <strong>Puente Vehicular Sur</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Gobierno Estatal</span>
                        </td>
                        <td>20/02/2026</td>
                        <td>15/04/2026</td>
                        <td class="amount">$1,200,000</td>
                        <td>Carlos R.</td>
                        <td><span class="status-badge enviada">Enviada</span></td>
                        <td><span class="priority-badge alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-067</td>
                        <td style="text-align: left;">
                            <strong>Torre Corporativa</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Grupo Financiero</span>
                        </td>
                        <td>22/02/2026</td>
                        <td>20/03/2026</td>
                        <td class="amount">$850,000</td>
                        <td>Juan M.</td>
                        <td><span class="status-badge vista">Vista</span></td>
                        <td><span class="priority-badge alta">Alta</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-089</td>
                        <td style="text-align: left;">
                            <strong>Remodelación Aeropuerto</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">ASA</span>
                        </td>
                        <td>25/02/2026</td>
                        <td>05/05/2026</td>
                        <td class="amount">$1,000,000</td>
                        <td>María G.</td>
                        <td><span class="status-badge emitida">Emitida</span></td>
                        <td><span class="priority-badge media">Media</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-edit"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>COT-2026-094</td>
                        <td style="text-align: left;">
                            <strong>Centro de Distribución</strong><br>
                            <span style="font-size: 0.65rem; color: var(--text-light);">Logística Express</span>
                        </td>
                        <td>28/02/2026</td>
                        <td>18/03/2026</td>
                        <td class="amount">$600,000</td>
                        <td>Ana L.</td>
                        <td><span class="status-badge rechazada">Rechazada</span></td>
                        <td><span class="priority-badge baja">Baja</span></td>
                        <td>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-eye"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-redo"></i></button>
                            <button style="background: none; border: none; color: var(--primary-orange);"><i class="fas fa-file-pdf"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>TOTALES:</strong></td>
                        <td><strong>$6,450,000</strong></td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Vista: Tarjetas (oculta por defecto) -->
    <div id="view-grid" style="display: none;">
        <div class="proposals-grid">
            <div class="proposal-card enviada">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-001</div>
                        <div class="proposal-title">Centro Comercial Plaza Norte</div>
                    </div>
                    <span class="status-badge enviada">Enviada</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-building"></i>
                    <span>Inmobiliaria del Valle</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$450,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 05/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 15/03/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Construcción</span>
                    <span class="items-tag">Arquitectura</span>
                    <span class="items-tag">Ingeniería</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        Carlos Rodríguez
                    </div>
                    <div class="card-actions">
                        <button title="Ver"><i class="fas fa-eye"></i></button>
                        <button title="Editar"><i class="fas fa-edit"></i></button>
                        <button title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                        <button title="Enviar"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="proposal-card vista">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-015</div>
                        <div class="proposal-title">Hotel Boutique Reforma</div>
                    </div>
                    <span class="status-badge vista">Vista</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-hotel"></i>
                    <span>Hoteles Unidos</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$780,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 10/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 22/04/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Diseño</span>
                    <span class="items-tag">Interiores</span>
                    <span class="items-tag">Equipamiento</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        María González
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-eye"></i></button>
                        <button><i class="fas fa-edit"></i></button>
                        <button><i class="fas fa-file-pdf"></i></button>
                        <button><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="proposal-card aprobada">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-042</div>
                        <div class="proposal-title">Complejo Habitacional Bosques</div>
                    </div>
                    <span class="status-badge aprobada">Aprobada</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-home"></i>
                    <span>Constructora Habita</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$650,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 18/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 28/03/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Habitacional</span>
                    <span class="items-tag">Urbanización</span>
                    <span class="validity"><i class="fas fa-check-circle"></i> Contrato generado</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        Ana López
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-eye"></i></button>
                        <button><i class="fas fa-file-contract"></i></button>
                        <button><i class="fas fa-file-pdf"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="proposal-card enviada">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-051</div>
                        <div class="proposal-title">Puente Vehicular Sur</div>
                    </div>
                    <span class="status-badge enviada">Enviada</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-road"></i>
                    <span>Gobierno Estatal</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$1,200,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 20/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 15/04/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Infraestructura</span>
                    <span class="items-tag">Vialidades</span>
                    <span class="priority-badge alta" style="margin-left: 0.5rem;">Alta prioridad</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        Carlos Rodríguez
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-eye"></i></button>
                        <button><i class="fas fa-edit"></i></button>
                        <button><i class="fas fa-file-pdf"></i></button>
                        <button><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="proposal-card vista">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-067</div>
                        <div class="proposal-title">Torre Corporativa</div>
                    </div>
                    <span class="status-badge vista">Vista</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-city"></i>
                    <span>Grupo Financiero</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$850,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 22/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 20/03/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Corporativo</span>
                    <span class="items-tag">Oficinas</span>
                    <span class="items-tag">Tecnología</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        Juan Martínez
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-eye"></i></button>
                        <button><i class="fas fa-edit"></i></button>
                        <button><i class="fas fa-file-pdf"></i></button>
                        <button><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="proposal-card rechazada">
                <div class="card-header">
                    <div>
                        <div class="proposal-number">COT-2026-094</div>
                        <div class="proposal-title">Centro de Distribución</div>
                    </div>
                    <span class="status-badge rechazada">Rechazada</span>
                </div>
                <div class="client-info">
                    <i class="fas fa-truck"></i>
                    <span>Logística Express</span>
                </div>
                <div class="amount-info">
                    <span class="amount-label">Monto Total</span>
                    <span class="amount-value">$600,000</span>
                </div>
                <div class="dates-info">
                    <span><i class="fas fa-calendar-alt"></i> Emisión: 28/02/26</span>
                    <span><i class="fas fa-hourglass-half"></i> Validez: 18/03/26</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <span class="items-tag">Logística</span>
                    <span class="items-tag">Almacén</span>
                    <span style="color: #c62828; font-size: 0.65rem; margin-left: 0.5rem;">Motivo: Presupuesto</span>
                </div>
                <div class="card-footer">
                    <div class="sales-exec">
                        <i class="fas fa-user-circle"></i>
                        Ana López
                    </div>
                    <div class="card-actions">
                        <button><i class="fas fa-eye"></i></button>
                        <button><i class="fas fa-redo"></i></button>
                        <button><i class="fas fa-file-pdf"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista: Seguimiento (oculta por defecto) -->
    <div id="view-seguimiento" style="display: none; background: white; border-radius: 10px; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chart-line" style="color: var(--primary-orange);"></i>
                Seguimiento de Propuestas
            </h3>
            <div style="display: flex; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 12px; height: 12px; background: #4caf50; border-radius: 2px;"></span>
                    <span style="font-size: 0.7rem;">Aprobadas</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 12px; height: 12px; background: #ff9800; border-radius: 2px;"></span>
                    <span style="font-size: 0.7rem;">Pendientes</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 12px; height: 12px; background: #f44336; border-radius: 2px;"></span>
                    <span style="font-size: 0.7rem;">Rechazadas</span>
                </div>
            </div>
        </div>
        
        <!-- Timeline de seguimiento -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; gap: 1rem;">
                <div style="width: 120px; font-weight: 600; font-size: 0.8rem;">Esta semana</div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2e7d32; margin-right: 1rem;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 0.8rem;">Propuesta aprobada - COT-2026-042</div>
                            <div style="font-size: 0.7rem; color: var(--text-medium);">Complejo Habitacional Bosques - $650,000</div>
                        </div>
                        <div style="font-size: 0.65rem; color: var(--text-light);">Hace 2h</div>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: #fff3e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ef6c00; margin-right: 1rem;">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 0.8rem;">Propuesta vista por cliente - COT-2026-067</div>
                            <div style="font-size: 0.7rem; color: var(--text-medium);">Torre Corporativa - Cliente abrió el documento</div>
                        </div>
                        <div style="font-size: 0.65rem; color: var(--text-light);">Hace 1d</div>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <div style="width: 120px; font-weight: 600; font-size: 0.8rem;">Semana pasada</div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: #ffebee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #c62828; margin-right: 1rem;">
                            <i class="fas fa-times"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 0.8rem;">Propuesta rechazada - COT-2026-094</div>
                            <div style="font-size: 0.7rem; color: var(--text-medium);">Centro de Distribución - Excede presupuesto</div>
                        </div>
                        <div style="font-size: 0.65rem; color: var(--text-light);;">Hace 5d</div>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 40px; height: 40px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1565c0; margin-right: 1rem;">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; font-size: 0.8rem;">Propuesta enviada - COT-2026-051</div>
                            <div style="font-size: 0.7rem; color: var(--text-medium);">Puente Vehicular Sur - En espera de respuesta</div>
                        </div>
                        <div style="font-size: 0.65rem; color: var(--text-light);">Hace 6d</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; text-align: center;">
            <button class="btn btn-primary" style="display: inline-flex;">
                <i class="fas fa-bell"></i>
                Configurar Alertas
            </button>
        </div>
    </div>

    <!-- Vista: Comparativa (oculta por defecto) -->
    <div id="view-comparativa" style="display: none; background: white; border-radius: 10px; padding: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-balance-scale" style="color: var(--primary-orange);"></i>
            Comparativa de Propuestas por Ejecutivo
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px; text-align: center;">
                <div style="font-size: 0.8rem; color: var(--text-medium); margin-bottom: 0.25rem;">Carlos Rodríguez</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-blue);">$2.05M</div>
                <div style="font-size: 0.65rem; color: var(--text-light);">6 propuestas | 33% éxito</div>
            </div>
            <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px; text-align: center;">
                <div style="font-size: 0.8rem; color: var(--text-medium); margin-bottom: 0.25rem;">María González</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-blue);">$1.78M</div>
                <div style="font-size: 0.65rem; color: var(--text-light);">5 propuestas | 40% éxito</div>
            </div>
            <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px; text-align: center;">
                <div style="font-size: 0.8rem; color: var(--text-medium); margin-bottom: 0.25rem;">Juan Martínez</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-blue);">$1.77M</div>
                <div style="font-size: 0.65rem; color: var(--text-light);">4 propuestas | 50% éxito</div>
            </div>
            <div style="background: #f8f9fc; padding: 1rem; border-radius: 8px; text-align: center;">
                <div style="font-size: 0.8rem; color: var(--text-medium); margin-bottom: 0.25rem;">Ana López</div>
                <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-blue);">$1.25M</div>
                <div style="font-size: 0.65rem; color: var(--text-light);">3 propuestas | 33% éxito</div>
            </div>
        </div>
        
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button class="btn btn-primary">
                <i class="fas fa-chart-bar"></i>
                Ver Reporte Completo
            </button>
            <button class="btn btn-success">
                <i class="fas fa-download"></i>
                Exportar Comparativa
            </button>
        </div>
    </div>

    <!-- Plantillas de Propuestas -->
    <div class="templates-section">
        <div class="templates-header">
            <div class="templates-title">
                <i class="fas fa-copy" style="color: var(--primary-orange);"></i>
                Plantillas de Propuestas
            </div>
            <button class="btn btn-primary" style="padding: 0.5rem 1rem;">
                <i class="fas fa-plus-circle"></i>
                Nueva Plantilla
            </button>
        </div>
        
        <div class="templates-grid">
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="template-info">
                    <h4>Propuesta de Construcción</h4>
                    <p>Obra civil, edificación</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 12 veces</span>
                </div>
            </div>
            
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-hotel"></i>
                </div>
                <div class="template-info">
                    <h4>Desarrollo Inmobiliario</h4>
                    <p>Vivienda, comercial</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 8 veces</span>
                </div>
            </div>
            
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-road"></i>
                </div>
                <div class="template-info">
                    <h4>Infraestructura</h4>
                    <p>Puentes, carreteras</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 6 veces</span>
                </div>
            </div>
            
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="template-info">
                    <h4>Proyectos Industriales</h4>
                    <p>Naves, plantas</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 5 veces</span>
                </div>
            </div>
            
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="template-info">
                    <h4>Servicios Profesionales</h4>
                    <p>Consultoría, supervisión</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 9 veces</span>
                </div>
            </div>
            
            <div class="template-card">
                <div class="template-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <div class="template-info">
                    <h4>Tecnología</h4>
                    <p>Sistemas, software</p>
                    <span style="font-size: 0.6rem; color: var(--text-light);">Usada 4 veces</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle entre vistas
        const tabLista = document.getElementById('tab-lista');
        const tabGrid = document.getElementById('tab-grid');
        const tabSeguimiento = document.getElementById('tab-seguimiento');
        const tabComparativa = document.getElementById('tab-comparativa');
        
        const viewTable = document.getElementById('view-table');
        const viewGrid = document.getElementById('view-grid');
        const viewSeguimiento = document.getElementById('view-seguimiento');
        const viewComparativa = document.getElementById('view-comparativa');
        
        // Función para cambiar vista
        function setActiveView(activeTab, activeView) {
            // Remover active de todos los tabs
            [tabLista, tabGrid, tabSeguimiento, tabComparativa].forEach(t => {
                t.classList.remove('active');
            });
            
            // Ocultar todas las vistas
            viewTable.style.display = 'none';
            viewGrid.style.display = 'none';
            viewSeguimiento.style.display = 'none';
            viewComparativa.style.display = 'none';
            
            // Activar tab y vista seleccionados
            activeTab.classList.add('active');
            activeView.style.display = 'block';
        }
        
        tabLista.addEventListener('click', function() {
            setActiveView(tabLista, viewTable);
        });
        
        tabGrid.addEventListener('click', function() {
            setActiveView(tabGrid, viewGrid);
        });
        
        tabSeguimiento.addEventListener('click', function() {
            setActiveView(tabSeguimiento, viewSeguimiento);
        });
        
        tabComparativa.addEventListener('click', function() {
            setActiveView(tabComparativa, viewComparativa);
        });
        
        // Filtros
        const statusFilter = document.getElementById('status-filter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                showNotification(`Filtrando: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        const clientFilter = document.getElementById('client-filter');
        if (clientFilter) {
            clientFilter.addEventListener('change', function() {
                showNotification(`Cliente: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        const dateFilter = document.getElementById('date-filter');
        if (dateFilter) {
            dateFilter.addEventListener('change', function() {
                showNotification(`Período: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }
        
        // Botón Nueva Propuesta
        const newProposal = document.getElementById('new-proposal');
        if (newProposal) {
            newProposal.addEventListener('click', function() {
                showNotification('✅ Creando nueva propuesta - Abriendo formulario', 'success');
            });
        }
        
        // Botón Plantillas
        const templates = document.getElementById('templates');
        if (templates) {
            templates.addEventListener('click', function() {
                showNotification('📋 Gestor de plantillas de propuestas', 'info');
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
                    showNotification('✅ Excel exportado - Catálogo de propuestas', 'success');
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
                    showNotification('✅ PDF exportado - Reporte de propuestas', 'success');
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