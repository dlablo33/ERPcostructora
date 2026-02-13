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
        color: var(--primary-red);
    }
    
    .client-selector {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .client-label {
        font-size: 1rem;
        color: var(--text-medium);
        font-weight: 600;
    }
    
    .client-select {
        padding: 0.75rem 1.25rem;
        border: 2px solid var(--border-light);
        border-radius: 8px;
        font-size: 1rem;
        color: var(--text-dark);
        background-color: white;
        min-width: 300px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .client-select:focus {
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
    
    .btn-pay {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
        color: white;
        padding: 0.85rem 1.5rem;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }
    
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(46, 125, 50, 0.4);
    }
    
    /* ===== KPI CARDS - NÚMEROS ASEGURADOS ===== */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }
    
    .kpi-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-width: 0; /* IMPORTANTE: Permite que el contenido se encoja */
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
    .kpi-card.total-cxp {
        border-color: var(--primary-purple);
        background: linear-gradient(135deg, #f3e5f5 0%, #ffffff 100%);
    }
    
    .kpi-card.total-cxp::before {
        background: linear-gradient(90deg, var(--primary-purple), #ab47bc);
    }
    
    .kpi-card.corriente {
        border-color: var(--success);
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
    }
    
    .kpi-card.corriente::before {
        background: linear-gradient(90deg, var(--success), #66bb6a);
    }
    
    .kpi-card.rango1-30 {
        border-color: #ff9800;
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }
    
    .kpi-card.rango1-30::before {
        background: linear-gradient(90deg, #ff9800, #ffb74d);
    }
    
    .kpi-card.rango31-60 {
        border-color: #fb8c00;
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }
    
    .kpi-card.rango31-60::before {
        background: linear-gradient(90deg, #fb8c00, #ffa726);
    }
    
    .kpi-card.rango61-90 {
        border-color: #f4511e;
        background: linear-gradient(135deg, #fbe9e7 0%, #ffffff 100%);
    }
    
    .kpi-card.rango61-90::before {
        background: linear-gradient(90deg, #f4511e, #ff7043);
    }
    
    .kpi-card.rango91-120 {
        border-color: #e53935;
        background: linear-gradient(135deg, #ffebee 0%, #ffffff 100%);
    }
    
    .kpi-card.rango91-120::before {
        background: linear-gradient(90deg, #e53935, #ef5350);
    }
    
    .kpi-card.mas120 {
        border-color: #b71c1c;
        background: linear-gradient(135deg, #ffcdd2 0%, #ffffff 100%);
    }
    
    .kpi-card.mas120::before {
        background: linear-gradient(90deg, #b71c1c, #e53935);
    }
    
    .kpi-icon-box {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .kpi-icon-box.purple {
        background: linear-gradient(135deg, var(--primary-purple), #ab47bc);
    }
    
    .kpi-icon-box.green {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
    }
    
    .kpi-icon-box.orange {
        background: linear-gradient(135deg, #fb8c00, #ffa726);
    }
    
    .kpi-icon-box.red {
        background: linear-gradient(135deg, #c62828, #e53935);
    }
    
    .kpi-icon-box.dark-red {
        background: linear-gradient(135deg, #b71c1c, #c62828);
    }
    
    .kpi-info {
        flex: 1;
        min-width: 0; /* IMPORTANTE: Permite que el texto se encoja */
    }
    
    .kpi-label {
        font-size: 0.75rem;
        color: var(--text-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.2rem;
        white-space: nowrap;
    }
    
    .kpi-value {
        font-size: 1.35rem; /* Reducido para que quepa SIEMPRE */
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: clip;
        width: 100%;
    }
    
    /* Responsivo para el número más grande */
    .kpi-card.total-cxp .kpi-value {
        font-size: 1.25rem; /* Aún más pequeño para el número más grande */
    }
    
    .kpi-card.mas120 .kpi-value {
        font-size: 1.25rem; /* También reducir el de 1,030,093.70 */
    }
    
    .kpi-subtext {
        font-size: 0.7rem;
        color: var(--text-light);
        margin-top: 0.15rem;
        white-space: nowrap;
    }
    
    /* Tabla de Datos */
    .table-section {
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2.5rem;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    /* Encabezado principal de la tabla */
    .data-table thead tr:first-child th {
        background: linear-gradient(135deg, #5e35b1, #7e57c2);
        color: white;
        padding: 1.25rem 1rem;
        font-weight: 600;
        text-align: center;
        border-right: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }
    
    .data-table thead tr:first-child th:last-child {
        border-right: none;
    }
    
    /* Sub-encabezados */
    .data-table thead tr:nth-child(2) th {
        padding: 1rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.85rem;
        border-right: 1px solid var(--border-light);
        border-bottom: 2px solid var(--border-medium);
    }
    
    .header-corriente {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
        color: white;
    }
    
    .header-vencido {
        background: linear-gradient(135deg, #ef5350, #f44336);
        color: white;
    }
    
    .header-days {
        background: linear-gradient(135deg, #ff9800, #fb8c00);
        color: white;
    }
    
    .sub-header-light {
        background-color: #e8eaf6;
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .sub-header-orange {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #e65100;
    }
    
    .sub-header-red {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #b71c1c;
    }
    
    /* Cuerpo de la tabla */
    .data-table tbody td {
        padding: 1rem 0.75rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.9rem;
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
    
    .data-table tbody td:nth-child(2),
    .data-table tbody td:nth-child(3) {
        font-size: 0.85rem;
        color: var(--text-medium);
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
    
    .amount.critical {
        color: #b71c1c;
        font-weight: 700;
    }
    
    .empty-cell {
        color: var(--text-light);
    }
    
    /* Proveedor con detalles */
    .supplier-info {
        display: flex;
        flex-direction: column;
    }
    
    .supplier-name {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .supplier-detail {
        font-size: 0.75rem;
        color: var(--text-light);
        margin-top: 0.2rem;
    }
    
    /* Pie de tabla */
    .data-table tfoot td {
        padding: 1.25rem 1rem;
        text-align: center;
        border-right: 1px solid var(--border-medium);
        border-top: 3px solid #5e35b1;
        background: linear-gradient(135deg, #f5f5f5, #fafafa);
        font-weight: 700;
        font-family: 'Roboto Mono', monospace;
        font-size: 1rem;
    }
    
    .data-table tfoot td:first-child {
        text-align: left;
        background: linear-gradient(135deg, #e0e0e0, #eeeeee);
    }
    
    /* Contenedor con scroll horizontal */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Columnas específicas */
    .col-proveedor {
        min-width: 280px;
    }
    
    .col-fecha {
        min-width: 120px;
    }
    
    .col-monto {
        min-width: 130px;
    }
    
    .col-vencido {
        min-width: 100px;
    }
    
    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .badge-warning {
        background-color: #fff3e0;
        color: #e65100;
    }
    
    .badge-danger {
        background-color: #ffebee;
        color: #b71c1c;
    }
    
    .badge-success {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    
    /* Resumen de proveedor */
    .supplier-summary {
        background: linear-gradient(135deg, #ede7f6, #f5f5f5);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        border: 1px solid #d1c4e9;
    }
    
    .summary-item {
        display: flex;
        flex-direction: column;
    }
    
    .summary-label {
        font-size: 0.8rem;
        color: var(--text-medium);
        margin-bottom: 0.25rem;
    }
    
    .summary-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark-bg);
        font-family: 'Roboto Mono', monospace;
    }
    
    .summary-supplier {
        font-weight: 600;
        color: var(--primary-purple);
        font-size: 1.1rem;
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kpi-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
        
        .kpi-value {
            font-size: 1.25rem;
        }
        
        .kpi-card.total-cxp .kpi-value,
        .kpi-card.mas120 .kpi-value {
            font-size: 1.15rem;
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
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .client-select {
            width: 100%;
            min-width: auto;
        }
        
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .kpi-card {
            padding: 1rem;
        }
        
        .kpi-icon-box {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
        
        .kpi-value {
            font-size: 1.2rem;
        }
        
        .kpi-card.total-cxp .kpi-value,
        .kpi-card.mas120 .kpi-value {
            font-size: 1.1rem;
        }
        
        .data-table tbody td:first-child {
            position: static;
        }
    }
    
    @media (max-width: 576px) {
        .page-title {
            font-size: 1.75rem;
        }
        
        .kpi-value {
            font-size: 1.15rem;
        }
        
        .kpi-card.total-cxp .kpi-value,
        .kpi-card.mas120 .kpi-value {
            font-size: 1.05rem;
        }
        
        .data-table {
            font-size: 0.85rem;
        }
        
        .data-table thead tr:first-child th,
        .data-table thead tr:nth-child(2) th,
        .data-table tbody td,
        .data-table tfoot td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-file-invoice-dollar title-icon"></i>
                    Antigüedad de Cuentas Por Pagar
                </h1>
                <div class="client-selector">
                    <label class="client-label">Proveedor:</label>
                    <select class="client-select" id="supplier-filter">
                        <option value="todos">TODOS LOS PROVEEDORES</option>
                        <option value="transportes">Transportes Demo Mexico</option>
                        <option value="tracto">Tracto Refacciones Demo</option>
                        <option value="llantera">Llantera Demo</option>
                        <option value="diesel">Proveedor Diesel Demo</option>
                        <option value="refacciones">Proveedor Refacciones Demo</option>
                        <option value="silva">GERARDO SILVA</option>
                        <option value="allende">UNION DE CREDITO ALLENDE</option>
                        <option value="logistica">PERMISIONARIO LOGISTICA DEL GOLFO</option>
                        <option value="catay">VEHICULOS COMERCIALES CATAY</option>
                        <option value="melendez">MARIA DE LA CRUZ MELENDEZ NAVA</option>
                        <option value="flores">ARELI CITLALLI BAUTISTA FLORES</option>
                        <option value="sistemas">SISTEMAS COMPUTACIONALES DEL NORTE</option>
                        <option value="turbo">TURBO SYSTEM PRODUCTS</option>
                        <option value="dhl">DHL EXPRESS MEXICO</option>
                        <option value="imtor">IMPULSORA DE TORNILLOS IMTOR</option>
                        <option value="viornery">VIORNERY CUAUTITLAN</option>
                        <option value="freightmex">3R FREIGHTMEX</option>
                    </select>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-pay" id="pay-batch">
                    <i class="fas fa-credit-card"></i>
                    Pago Múltiple
                </button>
                <button class="btn btn-excel" id="export-excel">
                    <i class="fas fa-file-excel"></i>
                    Descarga Excel
                </button>
                <button class="btn btn-pdf" id="export-pdf">
                    <i class="fas fa-file-pdf"></i>
                    Descarga PDF
                </button>
                <button class="btn btn-refresh" id="refresh-data">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- KPIs Grid - Con datos reales y números que SIEMPRE caben -->
    <div class="kpi-grid">
        <div class="kpi-card total-cxp">
            <div class="kpi-icon-box purple">
                <i class="fas fa-search-dollar"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total CXP</div>
                <div class="kpi-value">$1,118,884</div>
                <div class="kpi-subtext">Total obligaciones</div>
            </div>
        </div>
        
        <div class="kpi-card corriente">
            <div class="kpi-icon-box green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Corriente</div>
                <div class="kpi-value">$0</div>
                <div class="kpi-subtext">Sin vencimiento</div>
            </div>
        </div>
        
        <div class="kpi-card rango1-30">
            <div class="kpi-icon-box orange">
                <i class="fas fa-hourglass-start"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">1-30 Días</div>
                <div class="kpi-value">$31,575</div>
                <div class="kpi-subtext">Vencimiento próximo</div>
            </div>
        </div>
        
        <div class="kpi-card rango31-60">
            <div class="kpi-icon-box orange">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">31-60 Días</div>
                <div class="kpi-value">$14,732</div>
                <div class="kpi-subtext">Atención requerida</div>
            </div>
        </div>
        
        <div class="kpi-card rango61-90">
            <div class="kpi-icon-box orange">
                <i class="fas fa-hourglass-end"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">61-90 Días</div>
                <div class="kpi-value">$0</div>
                <div class="kpi-subtext">Sin adeudos</div>
            </div>
        </div>
        
        <div class="kpi-card rango91-120">
            <div class="kpi-icon-box red">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">91-120 Días</div>
                <div class="kpi-value">$42,483</div>
                <div class="kpi-subtext">Crédito vencido</div>
            </div>
        </div>
        
        <div class="kpi-card mas120">
            <div class="kpi-icon-box dark-red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">+120 Días</div>
                <div class="kpi-value">$1,030,094</div>
                <div class="kpi-subtext">Crédito castigado</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Antigüedad de Saldos -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-proveedor">Proveedor</th>
                        <th colspan="2" class="header-days">Días de Crédito</th>
                        <th colspan="1" class="header-corriente">Corriente</th>
                        <th colspan="5" class="header-vencido">Días de Vencido</th>
                        <th rowspan="2" class="col-monto">Total</th>
                    </tr>
                    <tr>
                        <th class="sub-header-light">Fecha Venc.</th>
                        <th class="sub-header-light">Días x Vencer</th>
                        <th class="sub-header-orange">Días x Vencer</th>
                        <th class="sub-header-orange">1-30</th>
                        <th class="sub-header-orange">31-60</th>
                        <th class="sub-header-red">61-90</th>
                        <th class="sub-header-red">91-120</th>
                        <th class="sub-header-red">+120</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">Transportes Demo Mexico</span>
                                <span class="supplier-detail">TDM850101 • 30d</span>
                            </div>
                        </td>
                        <td>15/03/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount warning">27,260</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">48,760</td>
                        <td class="amount">76,020</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">Tracto Refacciones Demo</span>
                                <span class="supplier-detail">TRD920505 • 45d</span>
                            </div>
                        </td>
                        <td>10/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount critical">55,138</td>
                        <td class="amount">55,138</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">Llantera Demo</span>
                                <span class="supplier-detail">LLD780912 • 30d</span>
                            </div>
                        </td>
                        <td>05/12/25</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount critical">70,180</td>
                        <td class="amount">70,180</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">Proveedor Diesel Demo</span>
                                <span class="supplier-detail">PDD830225 • 15d</span>
                            </div>
                        </td>
                        <td>20/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">5,830</td>
                        <td class="amount">5,830</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">Proveedor Refacciones Demo</span>
                                <span class="supplier-detail">PRD880718 • 30d</span>
                            </div>
                        </td>
                        <td>28/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount critical">57,973</td>
                        <td class="amount">57,973</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">GERARDO SILVA</span>
                                <span class="supplier-detail">SIGG780101 • 30d</span>
                            </div>
                        </td>
                        <td>25/02/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount warning">3,028</td>
                        <td class="amount warning">232</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount">3,260</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">UNION DE CREDITO ALLENDE</span>
                                <span class="supplier-detail">UCA850101 • 60d</span>
                            </div>
                        </td>
                        <td>15/11/25</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount critical">694,297</td>
                        <td class="amount">694,297</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">LOGISTICA DEL GOLFO</span>
                                <span class="supplier-detail">PLG900520 • 90d</span>
                            </div>
                        </td>
                        <td>10/12/25</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">14,388</td>
                        <td class="amount danger">57,722</td>
                        <td class="amount">72,110</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">VEHICULOS CATAY</span>
                                <span class="supplier-detail">VCC950813 • 30d</span>
                            </div>
                        </td>
                        <td>18/02/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">3,306</td>
                        <td class="amount">3,306</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">MARIA MELENDEZ NAVA</span>
                                <span class="supplier-detail">MENM751215 • 15d</span>
                            </div>
                        </td>
                        <td>10/03/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount warning">1,288</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount">1,288</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">ARELI BAUTISTA FLORES</span>
                                <span class="supplier-detail">BAFA880305 • 30d</span>
                            </div>
                        </td>
                        <td>05/02/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">4,872</td>
                        <td class="amount">4,872</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">SISTEMAS DEL NORTE</span>
                                <span class="supplier-detail">SCN910101 • 60d</span>
                            </div>
                        </td>
                        <td>20/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount warning">14,500</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">17,400</td>
                        <td class="amount">31,900</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">TURBO SYSTEM</span>
                                <span class="supplier-detail">TSP930618 • 30d</span>
                            </div>
                        </td>
                        <td>12/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">9,628</td>
                        <td class="amount">9,628</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">DHL EXPRESS</span>
                                <span class="supplier-detail">DHL820101 • 15d</span>
                            </div>
                        </td>
                        <td>28/02/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">47</td>
                        <td class="amount">47</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">IMPULSORA IMTOR</span>
                                <span class="supplier-detail">ITI890405 • 30d</span>
                            </div>
                        </td>
                        <td>22/01/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">3,317</td>
                        <td class="amount">3,317</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">VIORNERY</span>
                                <span class="supplier-detail">VIC921230 • 30d</span>
                            </div>
                        </td>
                        <td>08/02/26</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">1,624</td>
                        <td class="amount">1,624</td>
                    </tr>
                    <tr>
                        <td class="col-proveedor">
                            <div class="supplier-info">
                                <span class="supplier-name">3R FREIGHTMEX</span>
                                <span class="supplier-detail">FRM950101 • 90d</span>
                            </div>
                        </td>
                        <td>15/11/25</td>
                        <td>-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">28,095</td>
                        <td class="empty-cell">-</td>
                        <td class="amount">28,095</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>TOTAL</strong></td>
                        <td><strong>$0</strong></td>
                        <td><strong>$31,575</strong></td>
                        <td><strong>$14,732</strong></td>
                        <td><strong>$0</strong></td>
                        <td><strong>$42,483</strong></td>
                        <td><strong>$1,030,094</strong></td>
                        <td><strong>$1,118,884</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Resumen de Proveedores Destacados -->
    <div class="supplier-summary">
        <div class="summary-item">
            <span class="summary-label">Mayor adeudo</span>
            <span class="summary-supplier">UNION DE CREDITO ALLENDE</span>
            <span class="summary-value">$694,297</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Más atrasado</span>
            <span class="summary-supplier">UNION DE CREDITO ALLENDE</span>
            <span class="summary-value">+150 días</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Proveedores</span>
            <span class="summary-value">17</span>
            <span class="summary-label" style="margin-top: 0.2rem; font-size: 0.7rem;">Vencido: 14</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">% Vencido</span>
            <span class="summary-value" style="color: #b71c1c;">92.1%</span>
            <span class="summary-label" style="font-size: 0.7rem;">$1,030,094 de $1,118,884</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro de proveedores
        const supplierFilter = document.getElementById('supplier-filter');
        if (supplierFilter) {
            supplierFilter.addEventListener('change', function() {
                const selectedSupplier = this.value;
                if (selectedSupplier === 'todos') {
                    showNotification('Mostrando todos los proveedores', 'info');
                } else {
                    const supplierName = this.options[this.selectedIndex].text;
                    showNotification(`Filtrando: ${supplierName}`, 'info');
                }
            });
        }
        
        // Pago Múltiple
        const payBatch = document.getElementById('pay-batch');
        if (payBatch) {
            payBatch.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('✅ Módulo de pago múltiple abierto', 'success');
                    this.innerHTML = originalHTML;
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
                    showNotification('✅ Excel generado', 'success');
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
                    showNotification('✅ PDF generado', 'success');
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
                    showNotification('✅ Datos actualizados', 'success');
                }, 600);
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
            }
        }
        
        // Tooltip para celdas con montos
        const amountCells = document.querySelectorAll('.amount');
        amountCells.forEach(cell => {
            cell.addEventListener('mouseenter', function() {
                if (this.textContent !== '0' && this.textContent !== '$0' && this.textContent !== '-') {
                    this.style.cursor = 'pointer';
                    this.style.transform = 'scale(1.05)';
                    this.style.transition = 'transform 0.2s ease';
                }
            });
            cell.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection