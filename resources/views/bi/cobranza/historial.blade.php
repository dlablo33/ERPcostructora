@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-blue: #0185a2;
        --primary-blue-light: #4aa3b9;
        --primary-blue-dark: #01647a;
        --primary-blue-soft: #e6f3f7;
        --primary-green: #1e7e34;
        --primary-green-light: #e8f5e9;
        --primary-purple: #5e4b8a;
        --primary-purple-light: #ede7f6;
        --primary-amber: #b85e00;
        --primary-amber-light: #fff3e0;
        --dark-bg: #1e3a47;
        --light-bg: #f5f7fa;
        --card-bg: #ffffff;
        --text-dark: #2c3e50;
        --text-medium: #5d6d7e;
        --text-light: #7f8c8d;
        --border-light: #e6e9ed;
        --border-medium: #d0d7dd;
        --success: #27ae60;
        --warning: #e67e22;
        --error: #c0392b;
        --info: #0185a2;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    body {
        background-color: var(--light-bg);
        color: var(--text-dark);
    }
    
    /* Contenido principal */
    .main-content {
        padding: 2rem;
        max-width: 1800px;
        margin: 0 auto;
    }
    
    /* Header */
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-light);
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .title-section {
        flex: 1;
    }
    
    .page-title {
        font-size: 1.9rem;
        color: var(--dark-bg);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }
    
    .title-icon {
        font-size: 1.8rem;
        color: var(--primary-blue);
        opacity: 0.9;
    }
    
    .date-range {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .date-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .date-label {
        font-size: 0.85rem;
        color: var(--text-medium);
        font-weight: 500;
    }
    
    .date-input {
        padding: 0.6rem 1rem;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--text-dark);
        background-color: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .date-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 2px rgba(1, 133, 162, 0.1);
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .btn {
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }
    
    .btn-excel {
        background: #1e4b3c;
        color: white;
    }
    
    .btn-excel:hover {
        background: #15382c;
    }
    
    .btn-pdf {
        background: #a83434;
        color: white;
    }
    
    .btn-pdf:hover {
        background: #8f2b2b;
    }
    
    .btn-refresh {
        background: var(--text-medium);
        color: white;
        padding: 0.7rem 1.25rem;
    }
    
    .btn-refresh:hover {
        background: #4a5b6b;
    }
    
    .btn-filter {
        background: var(--primary-blue);
        color: white;
    }
    
    .btn-filter:hover {
        background: var(--primary-blue-dark);
    }
    
    .btn-payment {
        background: var(--primary-green);
        color: white;
    }
    
    .btn-payment:hover {
        background: #16692b;
    }
    
    /* KPI Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .kpi-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: all 0.2s ease;
    }
    
    .kpi-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        border-color: #d0d7dd;
    }
    
    .kpi-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: white;
        flex-shrink: 0;
    }
    
    .kpi-icon-box.blue {
        background: var(--primary-blue);
    }
    
    .kpi-icon-box.green {
        background: var(--primary-green);
    }
    
    .kpi-icon-box.purple {
        background: var(--primary-purple);
    }
    
    .kpi-icon-box.amber {
        background: var(--primary-amber);
    }
    
    .kpi-info {
        flex: 1;
    }
    
    .kpi-label {
        font-size: 0.75rem;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 0.35rem;
    }
    
    .kpi-value {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    
    .kpi-subtext {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-top: 0.2rem;
    }
    
    /* Filtros avanzados */
    .filters-section {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-light);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1.5rem;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .filter-label {
        font-size: 0.8rem;
        color: var(--text-medium);
        font-weight: 500;
    }
    
    .filter-select {
        padding: 0.5rem 1rem;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.8rem;
        color: var(--text-dark);
        background-color: white;
        min-width: 180px;
        cursor: pointer;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary-blue);
    }
    
    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        flex: 1;
        max-width: 280px;
    }
    
    .search-box i {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }
    
    .search-box input {
        border: none;
        outline: none;
        font-size: 0.8rem;
        width: 100%;
        background: transparent;
    }
    
    .search-box input::placeholder {
        color: var(--text-light);
    }
    
    /* Resumen de pagos */
    .payment-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .payment-stat {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid var(--border-light);
        display: flex;
        flex-direction: column;
    }
    
    .payment-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .payment-stat-title {
        font-size: 0.75rem;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .payment-stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }
    
    .payment-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
        margin-bottom: 0.25rem;
    }
    
    .payment-stat-sub {
        font-size: 0.7rem;
        color: var(--text-light);
    }
    
    /* Tabla de Historial de Pagos */
    .table-section {
        background: white;
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-light);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }
    
    .data-table thead tr th {
        background: #f8fafc;
        color: var(--text-medium);
        padding: 1rem 1rem;
        font-weight: 600;
        text-align: left;
        border-bottom: 2px solid var(--border-medium);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    
    .data-table tbody td {
        padding: 1rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.8rem;
        vertical-align: middle;
        color: var(--text-dark);
    }
    
    .data-table tbody tr:hover {
        background-color: #fafcfc;
    }
    
    /* Método de pago */
    .payment-method {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .payment-method i {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    
    .method-transfer i {
        background: var(--primary-blue-soft);
        color: var(--primary-blue);
    }
    
    .method-card i {
        background: var(--primary-purple-light);
        color: var(--primary-purple);
    }
    
    .method-cash i {
        background: var(--primary-green-light);
        color: var(--primary-green);
    }
    
    .method-check i {
        background: var(--primary-amber-light);
        color: var(--primary-amber);
    }
    
    /* Estatus de pago */
    .payment-status {
        display: inline-block;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .status-verified {
        background-color: var(--primary-green-light);
        color: var(--primary-green);
    }
    
    .status-pending {
        background-color: var(--primary-amber-light);
        color: var(--primary-amber);
    }
    
    .status-reconciled {
        background-color: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
    }
    
    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        background-color: #f1f5f9;
        color: var(--text-medium);
    }
    
    .badge-blue {
        background-color: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
    }
    
    .badge-green {
        background-color: var(--primary-green-light);
        color: var(--primary-green);
    }
    
    /* Montos */
    .amount {
        font-family: 'Inter', 'Roboto Mono', monospace;
        font-weight: 600;
    }
    
    .amount.positive {
        color: var(--success);
    }
    
    .amount.mxn {
        color: var(--primary-blue-dark);
    }
    
    /* Pie de tabla */
    .data-table tfoot td {
        padding: 1.25rem 1rem;
        text-align: left;
        border-top: 2px solid var(--border-medium);
        background: #f8fafc;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .total-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
    }
    
    /* Timeline de pagos */
    .timeline-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-light);
        margin-bottom: 2rem;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .timeline-title i {
        color: var(--primary-blue);
    }
    
    .timeline-badge {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-light);
    }
    
    .timeline-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .timeline-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    
    .timeline-content {
        flex: 1;
    }
    
    .timeline-date {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-bottom: 0.25rem;
    }
    
    .timeline-desc {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .timeline-desc strong {
        font-size: 0.9rem;
        color: var(--text-dark);
    }
    
    .timeline-amount {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary-green);
    }
    
    /* Columnas específicas */
    .col-fecha {
        min-width: 110px;
    }
    
    .col-factura {
        min-width: 100px;
    }
    
    .col-cliente {
        min-width: 200px;
    }
    
    .col-metodo {
        min-width: 140px;
    }
    
    .col-estatus {
        min-width: 120px;
    }
    
    .col-monto {
        min-width: 130px;
    }
    
    .col-referencia {
        min-width: 120px;
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kpi-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        .payment-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .kpi-grid {
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
        
        .page-title {
            font-size: 1.6rem;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .date-range {
            width: 100%;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .date-item {
            width: 100%;
        }
        
        .date-input {
            width: 100%;
        }
        
        .header-actions {
            width: 100%;
            flex-wrap: wrap;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
        
        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-select {
            width: 100%;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .payment-summary {
            grid-template-columns: 1fr;
        }
        
        .kpi-card {
            padding: 1.25rem;
        }
        
        .kpi-value {
            font-size: 1.6rem;
        }
        
        .timeline-desc {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-hand-holding-usd title-icon"></i>
                    Historial de Pagos - BI
                </h1>
                <div class="date-range">
                    <div class="date-item">
                        <span class="date-label">Fecha inicio:</span>
                        <input type="date" class="date-input" id="fecha-inicio" value="2026-01-01">
                    </div>
                    <div class="date-item">
                        <span class="date-label">Fecha fin:</span>
                        <input type="date" class="date-input" id="fecha-fin" value="2026-02-11">
                    </div>
                    <button class="btn btn-filter" id="apply-filter">
                        <i class="fas fa-filter"></i>
                        Aplicar
                    </button>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-payment" id="register-payment">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Pago
                </button>
                <button class="btn btn-excel" id="export-excel">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </button>
                <button class="btn btn-pdf" id="export-pdf">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </button>
                <button class="btn btn-refresh" id="refresh-data">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon-box green">
                <i class="fas fa-coins"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total Cobrado</div>
                <div class="kpi-value">$2,847,932.40</div>
                <div class="kpi-subtext">Período: Ene - Feb 2026</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box blue">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Facturas Pagadas</div>
                <div class="kpi-value">124</div>
                <div class="kpi-subtext">Total de facturas cobradas</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box purple">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Días Promedio</div>
                <div class="kpi-value">18.5</div>
                <div class="kpi-subtext">Días para pago</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box amber">
                <i class="fas fa-clock"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Pendientes</div>
                <div class="kpi-value">$1,184,360.00</div>
                <div class="kpi-subtext">8 facturas por cobrar</div>
            </div>
        </div>
    </div>

    <!-- Filtros Avanzados -->
    <div class="filters-section">
        <div class="filter-group">
            <span class="filter-label">Cliente:</span>
            <select class="filter-select" id="client-filter">
                <option value="todos">Todos los clientes</option>
                <option value="transporte">TRANSPORTE DEL NORTE</option>
                <option value="mty">Cliente Mty Demo</option>
                <option value="cartones">Cartones del Norte Demo</option>
                <option value="farmaceutica">Farmaceutica Demo</option>
                <option value="corporativo">Corporativo Monterrey Demo</option>
            </select>
        </div>
        <div class="filter-group">
            <span class="filter-label">Método de pago:</span>
            <select class="filter-select" id="method-filter">
                <option value="todos">Todos</option>
                <option value="transferencia">Transferencia</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="efectivo">Efectivo</option>
                <option value="cheque">Cheque</option>
            </select>
        </div>
        <div class="filter-group">
            <span class="filter-label">Estatus:</span>
            <select class="filter-select" id="status-filter">
                <option value="todos">Todos</option>
                <option value="verificado">Verificado</option>
                <option value="conciliado">Conciliado</option>
                <option value="pendiente">Pendiente</option>
            </select>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Buscar factura, cliente o referencia..." id="search-input">
        </div>
    </div>

    <!-- Resumen de Pagos por Método -->
    <div class="payment-summary">
        <div class="payment-stat">
            <div class="payment-stat-header">
                <span class="payment-stat-title">Transferencia</span>
                <span class="payment-stat-icon" style="background: var(--primary-blue);">
                    <i class="fas fa-exchange-alt"></i>
                </span>
            </div>
            <div class="payment-stat-value">$1,845,290.00</div>
            <div class="payment-stat-sub">82 pagos • 64.8%</div>
        </div>
        <div class="payment-stat">
            <div class="payment-stat-header">
                <span class="payment-stat-title">Tarjeta</span>
                <span class="payment-stat-icon" style="background: var(--primary-purple);">
                    <i class="fas fa-credit-card"></i>
                </span>
            </div>
            <div class="payment-stat-value">$624,380.40</div>
            <div class="payment-stat-sub">28 pagos • 21.9%</div>
        </div>
        <div class="payment-stat">
            <div class="payment-stat-header">
                <span class="payment-stat-title">Efectivo</span>
                <span class="payment-stat-icon" style="background: var(--primary-green);">
                    <i class="fas fa-money-bill-wave"></i>
                </span>
            </div>
            <div class="payment-stat-value">$289,450.00</div>
            <div class="payment-stat-sub">11 pagos • 10.2%</div>
        </div>
        <div class="payment-stat">
            <div class="payment-stat-header">
                <span class="payment-stat-title">Cheque</span>
                <span class="payment-stat-icon" style="background: var(--primary-amber);">
                    <i class="fas fa-file-invoice"></i>
                </span>
            </div>
            <div class="payment-stat-value">$88,812.00</div>
            <div class="payment-stat-sub">3 pagos • 3.1%</div>
        </div>
    </div>

    <!-- Tabla de Historial de Pagos -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-fecha">Fecha Pago</th>
                        <th class="col-factura">Factura</th>
                        <th class="col-cliente">Cliente</th>
                        <th class="col-metodo">Método</th>
                        <th class="col-referencia">Referencia</th>
                        <th class="col-monto">Monto</th>
                        <th class="col-estatus">Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2026-02-10</td>
                        <td><span class="badge badge-blue">A79</span></td>
                        <td><strong>Cliente Mty Demo</strong></td>
                        <td>
                            <div class="payment-method method-transfer">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transferencia</span>
                            </div>
                        </td>
                        <td>REF-2026-02847</td>
                        <td class="amount mxn">$22,000.00</td>
                        <td><span class="payment-status status-verified">Verificado</span></td>
                    </tr>
                    <tr>
                        <td>2026-02-08</td>
                        <td><span class="badge badge-blue">CCP21</span></td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td>
                            <div class="payment-method method-transfer">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transferencia</span>
                            </div>
                        </td>
                        <td>SPEI-28022026-01</td>
                        <td class="amount mxn">$45,000.00</td>
                        <td><span class="payment-status status-reconciled">Conciliado</span></td>
                    </tr>
                    <tr>
                        <td>2026-02-05</td>
                        <td><span class="badge badge-blue">FAC-2026-156</span></td>
                        <td><strong>Transportes del Norte</strong></td>
                        <td>
                            <div class="payment-method method-card">
                                <i class="fas fa-credit-card"></i>
                                <span>Tarjeta</span>
                            </div>
                        </td>
                        <td>VISA •••• 4242</td>
                        <td class="amount mxn">$15,375.00</td>
                        <td><span class="payment-status status-verified">Verificado</span></td>
                    </tr>
                    <tr>
                        <td>2026-02-03</td>
                        <td><span class="badge badge-blue">FAC-2026-142</span></td>
                        <td><strong>Farmaceutica Demo</strong></td>
                        <td>
                            <div class="payment-method method-transfer">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transferencia</span>
                            </div>
                        </td>
                        <td>REF-INTER-28371</td>
                        <td class="amount mxn">$7,920.00</td>
                        <td><span class="payment-status status-verified">Verificado</span></td>
                    </tr>
                    <tr>
                        <td>2026-02-01</td>
                        <td><span class="badge badge-blue">CCP20</span></td>
                        <td><strong>Corporativo Monterrey Demo</strong></td>
                        <td>
                            <div class="payment-method method-check">
                                <i class="fas fa-file-invoice"></i>
                                <span>Cheque</span>
                            </div>
                        </td>
                        <td>CHE-3827</td>
                        <td class="amount mxn">$9,440.00</td>
                        <td><span class="payment-status status-pending">Pendiente</span></td>
                    </tr>
                    <tr>
                        <td>2026-01-28</td>
                        <td><span class="badge badge-blue">FAC-2026-98</span></td>
                        <td><strong>Cliente Mty Demo</strong></td>
                        <td>
                            <div class="payment-method method-cash">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Efectivo</span>
                            </div>
                        </td>
                        <td>CAJA-MTY-01</td>
                        <td class="amount mxn">$22,000.00</td>
                        <td><span class="payment-status status-reconciled">Conciliado</span></td>
                    </tr>
                    <tr>
                        <td>2026-01-25</td>
                        <td><span class="badge badge-blue">FAC-2026-82</span></td>
                        <td><strong>Empresa USA Demo</strong></td>
                        <td>
                            <div class="payment-method method-transfer">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transferencia</span>
                            </div>
                        </td>
                        <td>WIRE-25012026</td>
                        <td class="amount mxn">$5,653.80</td>
                        <td><span class="payment-status status-verified">Verificado</span></td>
                    </tr>
                    <tr>
                        <td>2026-01-20</td>
                        <td><span class="badge badge-blue">FAC-2026-45</span></td>
                        <td><strong>Logistica Demo</strong></td>
                        <td>
                            <div class="payment-method method-transfer">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transferencia</span>
                            </div>
                        </td>
                        <td>SPEI-20012026</td>
                        <td class="amount mxn">$39,600.00</td>
                        <td><span class="payment-status status-verified">Verificado</span></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; font-size: 0.9rem;">TOTALES DEL PERÍODO:</td>
                        <td style="font-weight: 700;"><span class="total-amount">$166,988.80</span></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Timeline de Últimos Pagos -->
    <div class="timeline-section">
        <div class="timeline-header">
            <div class="timeline-title">
                <i class="fas fa-clock-rotate-left"></i>
                Últimos Pagos Registrados
            </div>
            <span class="timeline-badge">
                <i class="fas fa-check-circle" style="margin-right: 0.3rem;"></i>
                8 pagos esta semana
            </span>
        </div>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-icon" style="background: var(--primary-green);">
                    <i class="fas fa-check"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-date">Hace 2 horas • 10/02/2026 14:30</div>
                    <div class="timeline-desc">
                        <div>
                            <strong>Cliente Mty Demo</strong> - Factura A79
                            <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 0.2rem;">Transferencia • REF-2026-02847</div>
                        </div>
                        <span class="timeline-amount">$22,000.00</span>
                    </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-icon" style="background: var(--primary-blue);">
                    <i class="fas fa-check"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-date">Ayer • 09/02/2026 11:15</div>
                    <div class="timeline-desc">
                        <div>
                            <strong>Cartones del Norte Demo</strong> - Factura CCP21
                            <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 0.2rem;">Transferencia • SPEI-28022026-01</div>
                        </div>
                        <span class="timeline-amount">$45,000.00</span>
                    </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-icon" style="background: var(--primary-purple);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-date">Hace 3 días • 07/02/2026 09:45</div>
                    <div class="timeline-desc">
                        <div>
                            <strong>Transportes del Norte</strong> - Factura FAC-2026-156
                            <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 0.2rem;">Tarjeta • VISA •••• 4242</div>
                        </div>
                        <span class="timeline-amount">$15,375.00</span>
                    </div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-icon" style="background: var(--primary-amber);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-date">Hace 5 días • 05/02/2026 16:20</div>
                    <div class="timeline-desc">
                        <div>
                            <strong>Farmaceutica Demo</strong> - Factura FAC-2026-142
                            <div style="font-size: 0.7rem; color: var(--text-light); margin-top: 0.2rem;">Transferencia • REF-INTER-28371</div>
                        </div>
                        <span class="timeline-amount">$7,920.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Análisis BI: Comportamiento de Pagos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--primary-blue-soft); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Top Clientes por Pago</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Mejor comportamiento de pago</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-weight: 700; color: var(--primary-blue);">1.</span>
                        <span style="font-size: 0.85rem; font-weight: 500;">Cliente Mty Demo</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <span style="font-size: 0.9rem; font-weight: 700;">$44,000</span>
                        <span style="font-size: 0.65rem; color: var(--text-light);">3 facturas</span>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-weight: 700; color: var(--primary-blue);">2.</span>
                        <span style="font-size: 0.85rem; font-weight: 500;">Cartones del Norte Demo</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <span style="font-size: 0.9rem; font-weight: 700;">$45,000</span>
                        <span style="font-size: 0.65rem; color: var(--text-light);">1 factura</span>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-weight: 700; color: var(--primary-blue);">3.</span>
                        <span style="font-size: 0.85rem; font-weight: 500;">Transportes del Norte</span>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end;">
                        <span style="font-size: 0.9rem; font-weight: 700;">$15,375</span>
                        <span style="font-size: 0.65rem; color: var(--text-light);">1 factura</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--primary-green-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-green);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Tendencia de Cobranza</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Últimos 6 meses</div>
                </div>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="font-size: 1.8rem; font-weight: 700; color: var(--text-dark);">+12.3%</span>
                <span style="font-size: 0.8rem; color: var(--text-light);">vs período anterior</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-light);">
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Eficiencia de cobro</div>
                    <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-green);">94%</div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Pagos atrasados</div>
                    <div style="font-size: 1.2rem; font-weight: 700; color: var(--warning);">3</div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Tiempo promedio</div>
                    <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary-blue);">18.5d</div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #fee9e7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #b85e5e;">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Próximos Vencimientos</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Próximos 7 días</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.8rem; font-weight: 600;">FAC-2026-245</span>
                        <span style="font-size: 0.65rem; color: var(--text-light); margin-left: 0.5rem;">Cliente Mty Demo</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--warning);">15/02/2026</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.8rem; font-weight: 600;">FAC-2026-248</span>
                        <span style="font-size: 0.65rem; color: var(--text-light); margin-left: 0.5rem;">Cartones del Norte</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--warning);">17/02/2026</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.8rem; font-weight: 600;">FAC-2026-250</span>
                        <span style="font-size: 0.65rem; color: var(--text-light); margin-left: 0.5rem;">Transportes del Norte</span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--warning);">18/02/2026</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar filtro de fechas
        const applyFilter = document.getElementById('apply-filter');
        if (applyFilter) {
            applyFilter.addEventListener('click', function() {
                const fechaInicio = document.getElementById('fecha-inicio').value;
                const fechaFin = document.getElementById('fecha-fin').value;
                
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Aplicando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification(`Filtro aplicado: ${fechaInicio} al ${fechaFin}`, 'info');
                    this.innerHTML = '<i class="fas fa-filter"></i> Aplicar';
                    this.disabled = false;
                }, 600);
            });
        }
        
        // Registrar pago
        const registerPayment = document.getElementById('register-payment');
        if (registerPayment) {
            registerPayment.addEventListener('click', function() {
                showNotification('Módulo de registro de pagos abierto', 'success');
            });
        }
        
        // Exportar a Excel
        const exportExcel = document.getElementById('export-excel');
        if (exportExcel) {
            exportExcel.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('Historial de pagos exportado a Excel', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1000);
            });
        }
        
        // Exportar a PDF
        const exportPdf = document.getElementById('export-pdf');
        if (exportPdf) {
            exportPdf.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('Historial de pagos exportado a PDF', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1000);
            });
        }
        
        // Refrescar datos
        const refreshBtn = document.getElementById('refresh-data');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.add('fa-spin');
                this.disabled = true;
                
                setTimeout(() => {
                    icon.classList.remove('fa-spin');
                    this.disabled = false;
                    showNotification('Datos de pagos actualizados', 'success');
                }, 700);
            });
        }
        
        // Filtros
        const clientFilter = document.getElementById('client-filter');
        const methodFilter = document.getElementById('method-filter');
        const statusFilter = document.getElementById('status-filter');
        
        [clientFilter, methodFilter, statusFilter].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', function() {
                    showNotification(`Filtro aplicado`, 'info');
                });
            }
        });
        
        // Búsqueda
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (this.value.length > 0) {
                        showNotification(`Buscando: ${this.value}`, 'info');
                    }
                }, 500);
            });
        }
        
        // Función global de notificaciones
        window.showNotification = function(message, type = 'success') {
            if (typeof Alpine !== 'undefined') {
                const event = new CustomEvent('new-notification', {
                    detail: {
                        title: type === 'success' ? 'Éxito' : 'Información',
                        message: message,
                        type: type
                    }
                });
                window.dispatchEvent(event);
            } else {
                console.log(`🔔 ${message}`);
            }
        };
    });
</script>
@endsection