@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-blue: #0185a2;
        --primary-blue-light: #4aa3b9;
        --primary-blue-dark: #01647a;
        --primary-green: #2e7d32;
        --primary-green-light: #4caf50;
        --primary-red: #a83434;
        --primary-red-light: #c74b4b;
        --primary-purple: #5e4b8a;
        --primary-purple-light: #7a66a3;
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
    
    /* Header con título y acciones - MÁS SOBRIO */
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
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }
    
    .title-icon {
        font-size: 1.8rem;
        color: var(--primary-blue);
        opacity: 0.9;
    }
    
    .client-selector {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    
    .client-label {
        font-size: 0.85rem;
        color: var(--text-medium);
        font-weight: 500;
    }
    
    .client-select {
        padding: 0.6rem 1rem;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--text-dark);
        background-color: white;
        min-width: 280px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .client-select:focus {
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
    
    .btn-invoice {
        background: var(--primary-blue);
        color: white;
    }
    
    .btn-invoice:hover {
        background: var(--primary-blue-dark);
    }
    
    /* KPI Cards Grid - ESTILO PROFESIONAL */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    
    .kpi-icon-box.purple {
        background: var(--primary-purple);
    }
    
    .kpi-icon-box.blue {
        background: var(--primary-blue);
    }
    
    .kpi-icon-box.green {
        background: var(--primary-green);
    }
    
    .kpi-icon-box.teal {
        background: var(--primary-blue-dark);
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
        font-size: 1.7rem;
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
    
    /* Tabla de Datos - ESTILO LIMPIO */
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
    
    /* Encabezado de tabla - SOBRIO */
    .data-table thead tr th {
        background: #f8fafc;
        color: var(--text-medium);
        padding: 1rem 0.9rem;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid var(--border-medium);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-medium);
    }
    
    /* Cuerpo de la tabla */
    .data-table tbody td {
        padding: 1rem 0.9rem;
        text-align: center;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.8rem;
        vertical-align: middle;
        color: var(--text-dark);
    }
    
    .data-table tbody td:first-child {
        text-align: center;
        font-weight: 500;
        color: var(--text-dark);
        background-color: #fafcfc;
    }
    
    .data-table tbody td:nth-child(2) {
        font-weight: 600;
        color: var(--primary-blue);
    }
    
    .data-table tbody td:nth-child(3) {
        text-align: left;
        font-weight: 500;
    }
    
    .data-table tbody td:nth-child(4) {
        text-align: left;
        max-width: 350px;
        white-space: normal;
        word-wrap: break-word;
        color: var(--text-medium);
        font-size: 0.78rem;
    }
    
    .data-table tbody tr:hover {
        background-color: #fafcfc;
    }
    
    .data-table tbody tr:hover td:first-child {
        background-color: #f1f5f9;
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
        color: var(--text-dark);
        font-weight: 600;
    }
    
    .empty-cell {
        color: var(--text-light);
    }
    
    /* Badges - MÁS SUTILES */
    .badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        background-color: #f1f5f9;
        color: var(--text-medium);
    }
    
    .badge-info {
        background-color: #e6f3f7;
        color: var(--primary-blue);
    }
    
    /* Service description */
    .service-desc {
        font-size: 0.78rem;
        line-height: 1.4;
        color: var(--text-medium);
    }
    
    /* Resumen de Pendientes - ESTILO LIMPIO */
    .summary-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        margin-top: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        border: 1px solid var(--border-light);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .summary-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .summary-title {
        font-size: 0.8rem;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    
    .summary-stats {
        display: flex;
        gap: 2.5rem;
        flex-wrap: wrap;
    }
    
    .summary-stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }
    
    .summary-stat-label {
        font-size: 0.7rem;
        color: var(--text-light);
        font-weight: 500;
    }
    
    .summary-stat-value {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
    }
    
    .summary-actions {
        display: flex;
        gap: 1rem;
    }
    
    /* Nota informativa */
    .info-note {
        margin-top: 1rem;
        padding: 0.9rem 1.25rem;
        background-color: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid var(--primary-blue);
        font-size: 0.8rem;
        color: var(--text-medium);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-note i {
        color: var(--primary-blue);
        font-size: 1rem;
    }
    
    .info-note strong {
        color: var(--text-dark);
        font-weight: 600;
    }
    
    /* Columnas específicas */
    .col-fecha {
        min-width: 100px;
    }
    
    .col-viaje {
        min-width: 70px;
    }
    
    .col-cliente {
        min-width: 200px;
    }
    
    .col-servicio {
        min-width: 350px;
    }
    
    .col-monto {
        min-width: 110px;
    }
    
    /* Fila seleccionada */
    .data-table tbody tr.selected {
        background-color: #f1f9fc;
    }
    
    .data-table tbody tr.selected td:first-child {
        background-color: #e6f3f7;
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kpi-grid {
            grid-template-columns: repeat(4, 1fr);
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
        
        .header-actions {
            width: 100%;
            flex-wrap: wrap;
        }
        
        .btn {
            flex: 1;
            justify-content: center;
            padding: 0.7rem 0.5rem;
        }
        
        .client-select {
            width: 100%;
            min-width: auto;
        }
        
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .kpi-card {
            padding: 1.25rem;
        }
        
        .kpi-value {
            font-size: 1.5rem;
        }
        
        .summary-section {
            flex-direction: column;
            gap: 1.25rem;
            align-items: flex-start;
            padding: 1.25rem;
        }
        
        .summary-stats {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .summary-actions {
            width: 100%;
        }
        
        .col-servicio {
            min-width: 280px;
        }
    }
</style>

<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="fas fa-clock title-icon"></i>
                    Viajes Pendientes de Facturar
                </h1>
                <div class="client-selector">
                    <span class="client-label">Cliente:</span>
                    <select class="client-select" id="client-filter">
                        <option value="todos">Todos los clientes</option>
                        <option value="transporte">TRANSPORTE DEL NORTE</option>
                        <option value="mty">Cliente Mty Demo</option>
                        <option value="cartones">Cartones del Norte Demo</option>
                    </select>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-invoice" id="batch-invoice">
                    <i class="fas fa-file-invoice"></i>
                    Facturar
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

    <!-- KPIs Grid -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon-box purple">
                <i class="fas fa-truck"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Servicios</div>
                <div class="kpi-value">514</div>
                <div class="kpi-subtext">Viajes pendientes</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box blue">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Monto USD</div>
                <div class="kpi-value">$38,190.00</div>
                <div class="kpi-subtext">Total en dólares</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box teal">
                <i class="fas fa-peso-sign"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Monto MXN</div>
                <div class="kpi-value">$10,406,521</div>
                <div class="kpi-subtext">Total en pesos</div>
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-icon-box green">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total MXN</div>
                <div class="kpi-value">$10,879,187</div>
                <div class="kpi-subtext">USD + MXN</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Viajes Pendientes -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-fecha">Fecha</th>
                        <th class="col-viaje">Viaje</th>
                        <th class="col-cliente">Cliente</th>
                        <th class="col-servicio">Servicio</th>
                        <th class="col-monto">USD</th>
                        <th class="col-monto">MXN</th>
                        <th class="col-monto">Total MXN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2026-02-11</td>
                        <td><span class="badge badge-info">540</span></td>
                        <td><strong>TRANSPORTE DEL NORTE</strong></td>
                        <td class="service-desc">Servicios transporte de carga por carretera (en camión) a nivel regional y nacional</td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">15,375.00</td>
                        <td class="amount total">15,375.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-10</td>
                        <td><span class="badge badge-info">539</span></td>
                        <td><strong>Cliente Mty Demo</strong></td>
                        <td class="service-desc">Estadias</td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">1,200.00</td>
                        <td class="amount total">1,200.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-09</td>
                        <td><span class="badge badge-info">537</span></td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td class="service-desc">Servicios transporte de carga por carretera (en camión) a nivel regional y nacional</td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">45,000.00</td>
                        <td class="amount total">45,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-06</td>
                        <td><span class="badge badge-info">536</span></td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td class="service-desc">Estadias</td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">4,000.00</td>
                        <td class="amount total">4,000.00</td>
                    </tr>
                    <tr>
                        <td>2026-02-05</td>
                        <td><span class="badge badge-info">535</span></td>
                        <td><strong>Cartones del Norte Demo</strong></td>
                        <td class="service-desc">Servicios transporte de carga por carretera (en camión) a nivel regional y nacional</td>
                        <td class="amount usd">0.00</td>
                        <td class="amount mxn">23,500.00</td>
                        <td class="amount total">23,500.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen de Pendientes -->
    <div class="summary-section">
        <div class="summary-info">
            <span class="summary-title">Resumen del período</span>
            <div class="summary-stats">
                <div class="summary-stat-item">
                    <span class="summary-stat-label">Viajes mostrados</span>
                    <span class="summary-stat-value">5</span>
                </div>
                <div class="summary-stat-item">
                    <span class="summary-stat-label">Total USD</span>
                    <span class="summary-stat-value">$0.00</span>
                </div>
                <div class="summary-stat-item">
                    <span class="summary-stat-label">Total MXN</span>
                    <span class="summary-stat-value">$89,075</span>
                </div>
            </div>
        </div>
        <div class="summary-actions">
            <button class="btn btn-invoice" style="padding: 0.6rem 1.25rem;" onclick="showNotification('Se facturarán todos los viajes pendientes', 'info')">
                <i class="fas fa-file-invoice"></i>
                Facturar todo
            </button>
        </div>
    </div>

    <!-- Nota informativa -->
    <div class="info-note">
        <i class="fas fa-info-circle"></i>
        <span><strong>514 viajes pendientes</strong> por un total de <strong>$10,879,187.12 MXN</strong>. Se muestran los últimos 5 viajes como referencia.</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro de clientes
        const clientFilter = document.getElementById('client-filter');
        if (clientFilter) {
            clientFilter.addEventListener('change', function() {
                const selectedClient = this.value;
                
                if (selectedClient === 'todos') {
                    showNotification('Mostrando todos los clientes', 'info');
                } else {
                    const clientName = this.options[this.selectedIndex].text;
                    showNotification(`Filtrando por: ${clientName}`, 'info');
                }
            });
        }
        
        // Facturar seleccionados
        const batchInvoice = document.getElementById('batch-invoice');
        if (batchInvoice) {
            batchInvoice.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('Selecciona los viajes para generar factura', 'info');
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
                    showNotification('Reporte exportado a Excel', 'success');
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
                    showNotification('Reporte exportado a PDF', 'success');
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
                    showNotification('Datos actualizados', 'success');
                }, 700);
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
        
        // Selección de filas
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
                this.classList.toggle('selected');
            });
        });
    });
</script>
@endsection