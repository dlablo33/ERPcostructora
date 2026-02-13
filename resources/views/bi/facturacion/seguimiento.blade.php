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
        max-width: 1800px;
        margin: 0 auto;
    }
    
    /* Header con título y acciones */
    .page-header {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
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
        font-size: 2.2rem;
        color: var(--dark-bg);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .title-icon {
        font-size: 2rem;
        color: var(--primary-cyan);
    }
    
    .date-range {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    
    .date-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .date-label {
        font-size: 0.9rem;
        color: var(--text-medium);
        font-weight: 600;
    }
    
    .date-input {
        padding: 0.6rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.9rem;
        color: var(--text-dark);
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .date-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
    }
    
    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .btn {
        padding: 0.85rem 1.75rem;
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
    
    .btn-excel {
        background: linear-gradient(135deg, #217346, #2d9558);
        color: white;
        box-shadow: 0 4px 12px rgba(33, 115, 70, 0.3);
    }
    
    .btn-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(33, 115, 70, 0.4);
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #c62828, #e53935);
        color: white;
        box-shadow: 0 4px 12px rgba(198, 40, 40, 0.3);
    }
    
    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(198, 40, 40, 0.4);
    }
    
    .btn-refresh {
        background: linear-gradient(135deg, var(--primary-blue), #1976d2);
        color: white;
        padding: 0.85rem 1.25rem;
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
    }
    
    .btn-refresh:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(21, 101, 192, 0.4);
    }
    
    .btn-filter {
        background: linear-gradient(135deg, var(--primary-cyan), #0097a7);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 131, 143, 0.3);
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 131, 143, 0.4);
    }
    
    /* KPI Cards Grid - Estilo específico para facturación */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .kpi-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid;
        display: flex;
        align-items: center;
        gap: 1.25rem;
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
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    /* Estilos específicos para cada tipo de KPI */
    .kpi-card.remisionado-monto {
        border-color: var(--primary-blue);
        background: linear-gradient(135deg, #e1f5fe 0%, #ffffff 100%);
    }
    
    .kpi-card.remisionado-monto::before {
        background: linear-gradient(90deg, var(--primary-blue), #42a5f5);
    }
    
    .kpi-card.facturado-monto {
        border-color: var(--success);
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
    }
    
    .kpi-card.facturado-monto::before {
        background: linear-gradient(90deg, var(--success), #66bb6a);
    }
    
    .kpi-card.por-facturar-monto {
        border-color: var(--warning);
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }
    
    .kpi-card.por-facturar-monto::before {
        background: linear-gradient(90deg, var(--warning), #ffb74d);
    }
    
    .kpi-card.cobrado-monto {
        border-color: var(--primary-green);
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
    }
    
    .kpi-card.cobrado-monto::before {
        background: linear-gradient(90deg, var(--primary-green), #66bb6a);
    }
    
    .kpi-card.remisionado-count {
        border-color: #5e35b1;
        background: linear-gradient(135deg, #ede7f6 0%, #ffffff 100%);
    }
    
    .kpi-card.remisionado-count::before {
        background: linear-gradient(90deg, #5e35b1, #7e57c2);
    }
    
    .kpi-card.facturado-count {
        border-color: #00838f;
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
    }
    
    .kpi-card.facturado-count::before {
        background: linear-gradient(90deg, #00838f, #00acc1);
    }
    
    .kpi-card.por-facturar-count {
        border-color: #ef6c00;
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }
    
    .kpi-card.por-facturar-count::before {
        background: linear-gradient(90deg, #ef6c00, #fb8c00);
    }
    
    .kpi-card.cobrado-count {
        border-color: #2e7d32;
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
    }
    
    .kpi-card.cobrado-count::before {
        background: linear-gradient(90deg, #2e7d32, #4caf50);
    }
    
    .kpi-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .kpi-icon-box.blue {
        background: linear-gradient(135deg, var(--primary-blue), #42a5f5);
    }
    
    .kpi-icon-box.green {
        background: linear-gradient(135deg, var(--success), #66bb6a);
    }
    
    .kpi-icon-box.orange {
        background: linear-gradient(135deg, var(--warning), #ffb74d);
    }
    
    .kpi-icon-box.purple {
        background: linear-gradient(135deg, #5e35b1, #7e57c2);
    }
    
    .kpi-icon-box.teal {
        background: linear-gradient(135deg, #00838f, #00acc1);
    }
    
    .kpi-icon-box.dark-orange {
        background: linear-gradient(135deg, #ef6c00, #fb8c00);
    }
    
    .kpi-icon-box.dark-green {
        background: linear-gradient(135deg, #2e7d32, #4caf50);
    }
    
    .kpi-info {
        flex: 1;
    }
    
    .kpi-label {
        font-size: 0.8rem;
        color: var(--text-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .kpi-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
        line-height: 1.2;
        white-space: nowrap;
    }
    
    .kpi-subtext {
        font-size: 0.75rem;
        color: var(--text-light);
        margin-top: 0.2rem;
    }
    
    /* Tabla de Datos */
    .table-section {
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
        font-size: 0.8rem;
    }
    
    /* Encabezados agrupados */
    .data-table thead tr:first-child th {
        background: linear-gradient(135deg, #00838f, #00acc1);
        color: white;
        padding: 0.9rem 0.6rem;
        font-weight: 600;
        text-align: center;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .data-table thead tr:nth-child(2) th {
        background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
        color: #006064;
        padding: 0.7rem 0.5rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.75rem;
        border-right: 1px solid var(--border-light);
        border-bottom: 2px solid #00838f;
    }
    
    .header-pedidos {
        background: linear-gradient(135deg, #5e35b1, #7e57c2) !important;
        color: white !important;
    }
    
    .header-viajes {
        background: linear-gradient(135deg, #ef6c00, #fb8c00) !important;
        color: white !important;
    }
    
    .header-facturacion {
        background: linear-gradient(135deg, #2e7d32, #4caf50) !important;
        color: white !important;
    }
    
    .header-cobranza {
        background: linear-gradient(135deg, #c62828, #e53935) !important;
        color: white !important;
    }
    
    /* Cuerpo de la tabla */
    .data-table tbody td {
        padding: 0.7rem 0.5rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.75rem;
        vertical-align: middle;
    }
    
    .data-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
        color: var(--text-dark);
        background-color: #fafafa;
        position: sticky;
        left: 0;
        z-index: 1;
    }
    
    .data-table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .data-table tbody tr:hover td:first-child {
        background-color: #f0f0f0;
    }
    
    /* Montos */
    .amount {
        font-family: 'Roboto Mono', monospace;
        font-weight: 600;
    }
    
    .amount.positive {
        color: var(--success);
    }
    
    .amount.warning {
        color: #ef6c00;
    }
    
    .amount.danger {
        color: #c62828;
    }
    
    .empty-cell {
        color: var(--text-light);
    }
    
    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .badge-success {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    
    .badge-warning {
        background-color: #fff3e0;
        color: #ef6c00;
    }
    
    .badge-info {
        background-color: #e1f5fe;
        color: #0288d1;
    }
    
    /* Resumen cards inferiores */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .summary-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border-left: 5px solid;
        display: flex;
        flex-direction: column;
    }
    
    .summary-card.pedidos {
        border-left-color: #5e35b1;
    }
    
    .summary-card.viajes {
        border-left-color: #ef6c00;
    }
    
    .summary-card.facturas {
        border-left-color: #2e7d32;
    }
    
    .summary-card.cobranza {
        border-left-color: #c62828;
    }
    
    .summary-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .summary-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-medium);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .summary-card-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .summary-card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
    }
    
    .summary-card-sub {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }
    
    /* Columnas específicas */
    .col-cliente {
        min-width: 180px;
    }
    
    .col-pedido {
        min-width: 70px;
    }
    
    .col-fecha {
        min-width: 90px;
    }
    
    .col-operator {
        min-width: 160px;
    }
    
    .col-equipo {
        min-width: 80px;
    }
    
    .col-monto {
        min-width: 100px;
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kpi-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .summary-cards {
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
            padding: 1.5rem;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
            flex-wrap: wrap;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
        }
        
        .date-range {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        
        .date-item {
            width: 100%;
        }
        
        .date-input {
            width: 100%;
        }
        
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .summary-cards {
            grid-template-columns: 1fr;
        }
        
        .data-table tbody td:first-child {
            position: static;
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
                    Seguimiento Facturación
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
                        Aplicar Filtro
                    </button>
                </div>
            </div>
            <div class="header-actions">
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

    <!-- KPIs Grid - Montos -->
    <div class="kpi-grid">
        <div class="kpi-card remisionado-monto">
            <div class="kpi-icon-box blue">
                <i class="fas fa-truck"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Remisionado</div>
                <div class="kpi-value">$ 208,677.00</div>
                <div class="kpi-subtext">Total remisionado</div>
            </div>
        </div>
        
        <div class="kpi-card facturado-monto">
            <div class="kpi-icon-box green">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Facturado</div>
                <div class="kpi-value">$ 109,000.00</div>
                <div class="kpi-subtext">Total facturado</div>
            </div>
        </div>
        
        <div class="kpi-card por-facturar-monto">
            <div class="kpi-icon-box orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Por Facturar</div>
                <div class="kpi-value">$ 99,677.00</div>
                <div class="kpi-subtext">Pendiente de factura</div>
            </div>
        </div>
        
        <div class="kpi-card cobrado-monto">
            <div class="kpi-icon-box dark-green">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Cobrado</div>
                <div class="kpi-value">$ 24,640.00</div>
                <div class="kpi-subtext">Total cobrado</div>
            </div>
        </div>
    </div>

    <!-- KPIs Grid - Cantidades -->
    <div class="kpi-grid">
        <div class="kpi-card remisionado-count">
            <div class="kpi-icon-box purple">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Remisionado</div>
                <div class="kpi-value">7</div>
                <div class="kpi-subtext">Viajes remisionados</div>
            </div>
        </div>
        
        <div class="kpi-card facturado-count">
            <div class="kpi-icon-box teal">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total Facturado</div>
                <div class="kpi-value">4</div>
                <div class="kpi-subtext">Facturas emitidas</div>
            </div>
        </div>
        
        <div class="kpi-card por-facturar-count">
            <div class="kpi-icon-box dark-orange">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Por Facturar</div>
                <div class="kpi-value">3</div>
                <div class="kpi-subtext">Viajes pendientes</div>
            </div>
        </div>
        
        <div class="kpi-card cobrado-count">
            <div class="kpi-icon-box green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Cobrado</div>
                <div class="kpi-value">1</div>
                <div class="kpi-subtext">Facturas cobradas</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Seguimiento -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-cliente">Cliente</th>
                        <th colspan="3" class="header-pedidos">Programación de Pedidos</th>
                        <th colspan="7" class="header-viajes">Viajes</th>
                        <th colspan="3" class="header-facturacion">Facturación</th>
                        <th colspan="3" class="header-cobranza">Cobranza</th>
                    </tr>
                    <tr>
                        <!-- Programación de Pedidos -->
                        <th>Pedido</th>
                        <th>Fecha</th>
                        <th>Viaje</th>
                        <th>Fecha</th>
                        <th>Venta MXN</th>
                        <th>Venta USD</th>
                        <th>Folios Carga</th>
                        <th>Operador</th>
                        <th>Tractor</th>
                        <th>Remolque</th>
                        <!-- Facturación -->
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <!-- Cobranza -->
                        <th>Depósito</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-cliente"><strong>TRANSPORTE DEL NORTE</strong></td>
                        <td>549</td>
                        <td>2026-02-11</td>
                        <td>540</td>
                        <td>2026-02-11</td>
                        <td class="amount">15,375.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>EW-85000</td>
                        <td>EUGENIO PEREZ RAMIREZ</td>
                        <td>T27</td>
                        <td>CST68</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cliente Mty Demo</strong></td>
                        <td>546</td>
                        <td>2026-02-10</td>
                        <td>539</td>
                        <td>2026-02-10</td>
                        <td class="amount">23,200.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>OC-2931381</td>
                        <td>EUGENIO PEREZ RAMIREZ</td>
                        <td>T18</td>
                        <td>CST04</td>
                        <td>CCP21</td>
                        <td>2026-02-10</td>
                        <td class="amount">22,000.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cliente Mty Demo</strong></td>
                        <td>545</td>
                        <td>2026-02-10</td>
                        <td>538</td>
                        <td>2026-02-10</td>
                        <td class="amount">22,000.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>OC-39191</td>
                        <td>CARLOS RAMIREZ GONZALEZ</td>
                        <td>T16</td>
                        <td class="empty-cell">-</td>
                        <td>A79</td>
                        <td>2026-02-10</td>
                        <td class="amount">22,000.00</td>
                        <td class="amount">80</td>
                        <td>2026-02-10</td>
                        <td class="amount positive">24,640.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cartones del Norte Demo</strong></td>
                        <td>544</td>
                        <td>2026-02-09</td>
                        <td>537</td>
                        <td>2026-02-09</td>
                        <td class="amount">45,000.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>S-84728381129</td>
                        <td>ERICK MARTINEZ HERNANDEZ</td>
                        <td>T50</td>
                        <td>CST59</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cartones del Norte Demo</strong></td>
                        <td>543</td>
                        <td>2026-02-06</td>
                        <td>536</td>
                        <td>2026-02-06</td>
                        <td class="amount">49,000.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>S-84381282879</td>
                        <td>EUGENIO PEREZ RAMIREZ</td>
                        <td>T50</td>
                        <td>CST73</td>
                        <td>EKT21</td>
                        <td>2026-02-06</td>
                        <td class="amount">45,000.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cartones del Norte Demo</strong></td>
                        <td>542</td>
                        <td>2026-02-05</td>
                        <td>535</td>
                        <td>2026-02-05</td>
                        <td class="amount">31,800.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>S-8342479</td>
                        <td>GERARDO JAVIER SILVA OLVERA</td>
                        <td>T47</td>
                        <td>CST04</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente"><strong>Cartones del Norte Demo</strong></td>
                        <td>541</td>
                        <td>2026-02-04</td>
                        <td>534</td>
                        <td>2026-02-04</td>
                        <td class="amount">22,302.00</td>
                        <td class="empty-cell">0.00</td>
                        <td>S-847902381029</td>
                        <td>JOSE PEREZ ACUÑA</td>
                        <td>T16</td>
                        <td>RM-CS-001</td>
                        <td>CCP20</td>
                        <td>2026-02-04</td>
                        <td class="amount">20,000.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen de Programación -->
    <div class="summary-cards">
        <div class="summary-card pedidos">
            <div class="summary-card-header">
                <span class="summary-card-title">Programación de Pedidos</span>
                <span class="summary-card-icon" style="background: linear-gradient(135deg, #5e35b1, #7e57c2);">
                    <i class="fas fa-clipboard-list"></i>
                </span>
            </div>
            <div class="summary-card-value">7</div>
            <div class="summary-card-sub">Pedidos programados</div>
        </div>
        
        <div class="summary-card viajes">
            <div class="summary-card-header">
                <span class="summary-card-title">Viajes</span>
                <span class="summary-card-icon" style="background: linear-gradient(135deg, #ef6c00, #fb8c00);">
                    <i class="fas fa-truck"></i>
                </span>
            </div>
            <div class="summary-card-value">7</div>
            <div class="summary-card-sub">Viajes realizados</div>
        </div>
        
        <div class="summary-card facturas">
            <div class="summary-card-header">
                <span class="summary-card-title">Facturación</span>
                <span class="summary-card-icon" style="background: linear-gradient(135deg, #2e7d32, #4caf50);">
                    <i class="fas fa-file-invoice"></i>
                </span>
            </div>
            <div class="summary-card-value">4</div>
            <div class="summary-card-sub">Facturas emitidas</div>
        </div>
        
        <div class="summary-card cobranza">
            <div class="summary-card-header">
                <span class="summary-card-title">Cobranza</span>
                <span class="summary-card-icon" style="background: linear-gradient(135deg, #c62828, #e53935);">
                    <i class="fas fa-hand-holding-usd"></i>
                </span>
            </div>
            <div class="summary-card-value">1</div>
            <div class="summary-card-sub">Facturas cobradas</div>
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
                    showNotification(`Filtro aplicado: ${fechaInicio} al ${fechaFin}`, 'success');
                    this.innerHTML = '<i class="fas fa-filter"></i> Aplicar Filtro';
                    this.disabled = false;
                }, 800);
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
                    showNotification('✅ Excel generado - Seguimiento de Facturación', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1200);
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
                    showNotification('✅ PDF generado - Seguimiento de Facturación', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1200);
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
                    showNotification('✅ Datos actualizados correctamente', 'success');
                }, 800);
            });
        }
        
        // Función de notificaciones
        function showNotification(message, type = 'success') {
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
        }
        
        // Animación de entrada para KPI cards
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