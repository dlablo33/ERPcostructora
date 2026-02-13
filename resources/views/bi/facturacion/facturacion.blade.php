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
    
    .btn-view {
        background: white;
        color: var(--text-medium);
        border: 1.5px solid var(--border-light);
        padding: 0.7rem 1.25rem;
    }
    
    .btn-view:hover {
        background: #f8fafc;
        border-color: var(--border-medium);
    }
    
    /* KPI Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
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
        font-size: 1.9rem;
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
    
    /* Filtros rápidos */
    .quick-filters {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.4rem;
        border-radius: 10px;
        border: 1px solid var(--border-light);
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border: none;
        background: transparent;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-medium);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .filter-btn:hover {
        background: #f1f5f9;
        color: var(--text-dark);
    }
    
    .filter-btn.active {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        font-weight: 600;
    }
    
    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        flex: 1;
        max-width: 300px;
    }
    
    .search-box i {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }
    
    .search-box input {
        border: none;
        outline: none;
        font-size: 0.85rem;
        width: 100%;
        background: transparent;
    }
    
    .search-box input::placeholder {
        color: var(--text-light);
    }
    
    /* Tabla de Facturas */
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
    
    /* Encabezado principal */
    .data-table thead tr:first-child th {
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
    
    /* Sub-encabezados */
    .data-table thead tr:nth-child(2) th {
        background: white;
        color: var(--text-medium);
        padding: 0.75rem 1rem;
        font-weight: 600;
        text-align: left;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-light);
    }
    
    /* Totales diarios */
    .data-table tbody tr.total-row {
        background-color: var(--primary-blue-soft);
        border-top: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
    }
    
    .data-table tbody tr.total-row td {
        padding: 0.9rem 1rem;
        font-weight: 600;
        color: var(--text-dark);
        background-color: transparent;
    }
    
    .data-table tbody tr.total-row td:first-child {
        font-weight: 700;
        color: var(--primary-blue-dark);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .data-table tbody td {
        padding: 1rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.8rem;
        vertical-align: middle;
        color: var(--text-dark);
    }
    
    .data-table tbody td:first-child {
        font-weight: 500;
        color: var(--text-medium);
    }
    
    .data-table tbody td:nth-child(2) {
        font-weight: 600;
        color: var(--primary-blue-dark);
    }
    
    .data-table tbody tr:not(.total-row):hover {
        background-color: #fafcfc;
    }
    
    /* Estatus */
    .status {
        display: inline-block;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .status.pagada {
        background-color: var(--primary-green-light);
        color: var(--primary-green);
    }
    
    .status.pendiente {
        background-color: var(--primary-amber-light);
        color: var(--primary-amber);
    }
    
    .status.cancelada {
        background-color: #fee9e7;
        color: #b85e5e;
    }
    
    .status.emitida {
        background-color: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
    }
    
    /* Montos */
    .amount {
        font-family: 'Inter', 'Roboto Mono', monospace;
        font-weight: 500;
    }
    
    .amount.usd {
        color: var(--primary-purple);
    }
    
    .amount.mxn {
        color: var(--primary-blue-dark);
    }
    
    .amount.total {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .amount.highlight {
        color: var(--primary-blue);
        font-weight: 600;
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
    
    /* Pie de tabla */
    .data-table tfoot td {
        padding: 1.25rem 1rem;
        text-align: left;
        border-top: 2px solid var(--border-medium);
        background: #f8fafc;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .data-table tfoot td:first-child {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-medium);
    }
    
    .total-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
    }
    
    /* Gráfico de tendencia (simulado) */
    .trend-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-light);
        margin-bottom: 2rem;
    }
    
    .trend-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }
    
    .trend-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .trend-title i {
        color: var(--primary-blue);
    }
    
    .trend-badge {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .chart-placeholder {
        display: flex;
        align-items: flex-end;
        gap: 2rem;
        height: 120px;
        padding: 1rem 0;
    }
    
    .chart-bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
    }
    
    .chart-bar {
        width: 40px;
        background: linear-gradient(to top, var(--primary-blue), var(--primary-blue-light));
        border-radius: 6px 6px 0 0;
        transition: height 0.3s ease;
    }
    
    .chart-label {
        font-size: 0.7rem;
        color: var(--text-light);
        font-weight: 500;
    }
    
    .chart-value {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    /* Columnas específicas */
    .col-fecha {
        min-width: 110px;
    }
    
    .col-factura {
        min-width: 100px;
    }
    
    .col-folio {
        min-width: 140px;
    }
    
    .col-cliente {
        min-width: 200px;
    }
    
    .col-estatus {
        min-width: 100px;
    }
    
    .col-monto {
        min-width: 120px;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
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
        
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .kpi-card {
            padding: 1.25rem;
        }
        
        .kpi-value {
            font-size: 1.6rem;
        }
        
        .quick-filters {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .chart-placeholder {
            gap: 0.5rem;
        }
        
        .chart-bar {
            width: 30px;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-file-invoice title-icon"></i>
                    Facturas - BI
                </h1>
                <div class="date-range">
                    <div class="date-item">
                        <span class="date-label">Fecha inicio:</span>
                        <input type="date" class="date-input" id="fecha-inicio" value="2026-02-01">
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
                <button class="btn btn-view" id="view-chart">
                    <i class="fas fa-chart-line"></i>
                    Ver gráfico
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

    <!-- KPI Principal -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon-box blue">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Facturación Total</div>
                <div class="kpi-value">$109,000.00</div>
                <div class="kpi-subtext">Período: 01/02/2026 - 11/02/2026</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Facturas Pagadas</div>
                <div class="kpi-value">$24,640.00</div>
                <div class="kpi-subtext">1 factura cobrada</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box purple">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Pendiente de Cobro</div>
                <div class="kpi-value">$84,360.00</div>
                <div class="kpi-subtext">3 facturas por cobrar</div>
            </div>
        </div>
    </div>

    <!-- Filtros rápidos y búsqueda -->
    <div class="quick-filters">
        <div class="filter-group">
            <button class="filter-btn active">Todas</button>
            <button class="filter-btn">Emitidas</button>
            <button class="filter-btn">Pagadas</button>
            <button class="filter-btn">Pendientes</button>
            <button class="filter-btn">Canceladas</button>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Buscar factura, cliente o folio..." id="search-input">
        </div>
    </div>

    <!-- Tabla de Facturas -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="4" style="text-align: center; border-bottom: 2px solid var(--border-medium);">Montos</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th class="col-fecha">Fecha</th>
                        <th class="col-factura">Factura</th>
                        <th class="col-folio">Folio de Carga</th>
                        <th class="col-cliente">Cliente</th>
                        <th class="col-estatus">Estatus</th>
                        <th class="col-monto">USD</th>
                        <th class="col-monto">MXN</th>
                        <th class="col-monto">Venta MXN</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Total del Día: 2026-02-10 -->
                    <tr class="total-row">
                        <td colspan="3"><i class="fas fa-calendar-day" style="margin-right: 0.5rem; color: var(--primary-blue);"></i>Total del Día: 10/02/2026</td>
                        <td></td>
                        <td></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">44,000.00</td>
                        <td class="amount total highlight">44,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-10</td>
                        <td><span class="badge badge-blue">CCP21</span></td>
                        <td>OC-2931381</td>
                        <td><strong>Cliente Mty Demo</strong></td>
                        <td><span class="status emitida">Emitida</span></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">22,000.00</td>
                        <td class="amount total">22,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-10</td>
                        <td><span class="badge badge-blue">A79</span></td>
                        <td>OC-39191</td>
                        <td><strong>Cliente Mty Demo</strong></td>
                        <td><span class="status pagada">Pagada</span></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">22,000.00</td>
                        <td class="amount total">22,000.00</td>
                    </tr>
                    
                    <!-- Total del Día: 2026-02-06 -->
                    <tr class="total-row">
                        <td colspan="3"><i class="fas fa-calendar-day" style="margin-right: 0.5rem; color: var(--primary-blue);"></i>Total del Día: 06/02/2026</td>
                        <td></td>
                        <td></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">45,000.00</td>
                        <td class="amount total highlight">45,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-06</td>
                        <td><span class="badge badge-blue">EKT21</span></td>
                        <td>S-84381282879</td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td><span class="status emitida">Emitida</span></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">45,000.00</td>
                        <td class="amount total">45,000.00</td>
                    </tr>
                    
                    <!-- Total del Día: 2026-02-04 -->
                    <tr class="total-row">
                        <td colspan="3"><i class="fas fa-calendar-day" style="margin-right: 0.5rem; color: var(--primary-blue);"></i>Total del Día: 04/02/2026</td>
                        <td></td>
                        <td></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">20,000.00</td>
                        <td class="amount total highlight">20,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-04</td>
                        <td><span class="badge badge-blue">CCP20</span></td>
                        <td>S-847902381029</td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td><span class="status emitida">Emitida</span></td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">20,000.00</td>
                        <td class="amount total">20,000.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; font-size: 0.9rem;">TOTALES DEL PERÍODO:</td>
                        <td class="amount usd" style="font-weight: 700;">$0.00</td>
                        <td class="amount mxn" style="font-weight: 700;">$109,000.00</td>
                        <td style="font-weight: 700;"><span class="total-amount">$109,000.00</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Análisis BI: Tendencia de Facturación -->
    <div class="trend-section">
        <div class="trend-header">
            <div class="trend-title">
                <i class="fas fa-chart-bar"></i>
                Tendencia de Facturación - Últimos 7 días
            </div>
            <span class="trend-badge">
                <i class="fas fa-arrow-up" style="margin-right: 0.3rem;"></i>
                +12% vs período anterior
            </span>
        </div>
        <div class="chart-placeholder">
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 40px;"></div>
                <span class="chart-label">04/02</span>
                <span class="chart-value">$20k</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 50px;"></div>
                <span class="chart-label">05/02</span>
                <span class="chart-value">$0</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 90px;"></div>
                <span class="chart-label">06/02</span>
                <span class="chart-value">$45k</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 30px;"></div>
                <span class="chart-label">07/02</span>
                <span class="chart-value">$0</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 30px;"></div>
                <span class="chart-label">08/02</span>
                <span class="chart-value">$0</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 30px;"></div>
                <span class="chart-label">09/02</span>
                <span class="chart-value">$0</span>
            </div>
            <div class="chart-bar-group">
                <div class="chart-bar" style="height: 88px;"></div>
                <span class="chart-label">10/02</span>
                <span class="chart-value">$44k</span>
            </div>
        </div>
    </div>

    <!-- Resumen BI -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--primary-blue-soft); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Distribución por Cliente</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Facturación del período</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.8rem; font-weight: 500;">Cliente Mty Demo</span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--primary-blue);">$44,000</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #edf2f7; border-radius: 4px;">
                        <div style="width: 40%; height: 8px; background: var(--primary-blue); border-radius: 4px;"></div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; margin-top: 0.2rem;">
                        <span style="font-size: 0.7rem; color: var(--text-light);">40.4%</span>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.8rem; font-weight: 500;">Cartones del Norte Demo</span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--primary-blue);">$65,000</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #edf2f7; border-radius: 4px;">
                        <div style="width: 60%; height: 8px; background: var(--primary-blue); border-radius: 4px;"></div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; margin-top: 0.2rem;">
                        <span style="font-size: 0.7rem; color: var(--text-light);">59.6%</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--primary-green-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-green);">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Días de Crédito Promedio</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Tiempo de pago clientes</div>
                </div>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="font-size: 2rem; font-weight: 700; color: var(--text-dark);">23</span>
                <span style="font-size: 0.9rem; color: var(--text-light);">días</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-light);">
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Cliente Mty Demo</div>
                    <div style="font-size: 0.9rem; font-weight: 600;">15 días</div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Cartones del Norte</div>
                    <div style="font-size: 0.9rem; font-weight: 600;">30 días</div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 1.5rem; border: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #fee9e7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #b85e5e;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">Facturas Vencidas</div>
                    <div style="font-size: 0.7rem; color: var(--text-light);">Mayor a 30 días</div>
                </div>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-bottom: 0.25rem;">
                <span style="font-size: 2rem; font-weight: 700; color: #b85e5e;">0</span>
                <span style="font-size: 0.9rem; color: var(--text-light);">facturas</span>
            </div>
            <div style="font-size: 0.75rem; color: var(--text-light);">Sin facturas vencidas en el período</div>
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
        
        // Ver gráfico
        const viewChart = document.getElementById('view-chart');
        if (viewChart) {
            viewChart.addEventListener('click', function() {
                showNotification('Mostrando análisis gráfico de facturación', 'info');
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
                    showNotification('Reporte de facturas exportado a Excel', 'success');
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
                    showNotification('Reporte de facturas exportado a PDF', 'success');
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
                    showNotification('Datos de facturación actualizados', 'success');
                }, 700);
            });
        }
        
        // Filtros rápidos
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                showNotification(`Filtrando: ${this.textContent}`, 'info');
            });
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