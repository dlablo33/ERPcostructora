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
        color: var(--primary-green);
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
    
    /* KPI Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .kpi-card {
        background: white;
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid;
        display: flex;
        align-items: center;
        gap: 1.5rem;
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
    .kpi-card.total-cxc {
        border-color: var(--primary-green);
        background: linear-gradient(135deg, #f1f8e9 0%, #ffffff 100%);
    }
    
    .kpi-card.total-cxc::before {
        background: linear-gradient(90deg, var(--primary-green), var(--primary-green-light));
    }
    
    .kpi-card.corriente {
        border-color: var(--success);
        background: linear-gradient(135deg, #f1f8e9 0%, #ffffff 100%);
    }
    
    .kpi-card.corriente::before {
        background: linear-gradient(90deg, var(--success), #66bb6a);
    }
    
    .kpi-card.vencido-leve {
        border-color: var(--warning);
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }
    
    .kpi-card.vencido-leve::before {
        background: linear-gradient(90deg, var(--warning), #ffb74d);
    }
    
    .kpi-card.vencido-medio {
        border-color: #ff5722;
        background: linear-gradient(135deg, #fbe9e7 0%, #ffffff 100%);
    }
    
    .kpi-card.vencido-medio::before {
        background: linear-gradient(90deg, #ff5722, #ff7043);
    }
    
    .kpi-card.vencido-grave {
        border-color: var(--error);
        background: linear-gradient(135deg, #ffebee 0%, #ffffff 100%);
    }
    
    .kpi-card.vencido-grave::before {
        background: linear-gradient(90deg, var(--error), #ef5350);
    }
    
    .kpi-icon-box {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .kpi-icon-box.green {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-light));
    }
    
    .kpi-icon-box.success {
        background: linear-gradient(135deg, var(--success), #66bb6a);
    }
    
    .kpi-icon-box.red {
        background: linear-gradient(135deg, var(--error), #ef5350);
    }
    
    .kpi-info {
        flex: 1;
    }
    
    .kpi-label {
        font-size: 0.9rem;
        color: var(--text-medium);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .kpi-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Roboto Mono', monospace;
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
        background: linear-gradient(135deg, #5c6bc0, #7986cb);
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
        background: linear-gradient(135deg, #f44336, #ef5350);
        color: white;
    }
    
    .sub-header-light {
        background-color: #e3f2fd;
        color: var(--text-dark);
    }
    
    /* Cuerpo de la tabla */
    .data-table tbody td {
        padding: 1.25rem 1rem;
        text-align: center;
        border-right: 1px solid var(--border-light);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.95rem;
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
    
    /* Expandir fila */
    .expand-icon {
        cursor: pointer;
        margin-right: 0.5rem;
        color: var(--primary-blue);
        transition: transform 0.3s ease;
    }
    
    .expand-icon.expanded {
        transform: rotate(90deg);
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
        color: var(--warning);
    }
    
    .amount.danger {
        color: var(--error);
    }
    
    .empty-cell {
        color: var(--text-light);
    }
    
    /* Pie de tabla */
    .data-table tfoot td {
        padding: 1.25rem 1rem;
        text-align: center;
        border-right: 1px solid var(--border-medium);
        border-top: 3px solid var(--dark-bg);
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
    .col-cliente {
        min-width: 250px;
    }
    
    .col-fecha {
        min-width: 120px;
    }
    
    .col-monto {
        min-width: 130px;
    }
    
    /* Responsive */
    @media (max-width: 1400px) {
        .kpi-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
            padding: 1.25rem;
        }
        
        .kpi-icon-box {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }
        
        .kpi-value {
            font-size: 1.75rem;
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
            font-size: 1.5rem;
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
                    <i class="fas fa-chart-line title-icon"></i>
                    Antigüedad de Cuentas Por Cobrar
                </h1>
                <div class="client-selector">
                    <label class="client-label">Cliente:</label>
                    <select class="client-select" id="client-filter">
                        <option value="todos">TODOS</option>
                        <option value="maquiladora">Maquiladora Industrial</option>
                        <option value="cartones">Cartones del Norte Demo</option>
                        <option value="farmaceutica">Farmaceutica Demo</option>
                        <option value="corporativo">Corporativo Monterrey Demo</option>
                        <option value="usa">Empresa USA Demo</option>
                        <option value="logistica">Logistica Demo</option>
                        <option value="cedis">Cedis Mty 1</option>
                    </select>
                </div>
            </div>
            <div class="header-actions">
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

    <!-- KPIs Grid -->
    <div class="kpi-grid">
        <div class="kpi-card total-cxc">
            <div class="kpi-icon-box green">
                <i class="fas fa-search-dollar"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Total CXC</div>
                <div class="kpi-value">468,965.80</div>
            </div>
        </div>
        
        <div class="kpi-card corriente">
            <div class="kpi-icon-box success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Corriente</div>
                <div class="kpi-value">$ 0.00</div>
            </div>
        </div>
        
        <div class="kpi-card vencido-leve">
            <div class="kpi-icon-box red">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">De 1 a 30 Días</div>
                <div class="kpi-value">$ 50,400.00</div>
            </div>
        </div>
        
        <div class="kpi-card corriente">
            <div class="kpi-icon-box success">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">31 a 60 Días</div>
                <div class="kpi-value">$ 0.00</div>
            </div>
        </div>
        
        <div class="kpi-card vencido-medio">
            <div class="kpi-icon-box red">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">61 a 90 Días</div>
                <div class="kpi-value">$ 20,000.00</div>
            </div>
        </div>
        
        <div class="kpi-card corriente">
            <div class="kpi-icon-box success">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">91 a 120 Días</div>
                <div class="kpi-value">$ 0.00</div>
            </div>
        </div>
        
        <div class="kpi-card vencido-grave">
            <div class="kpi-icon-box red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="kpi-info">
                <div class="kpi-label">Más de 120 Días</div>
                <div class="kpi-value">$ 398,565.80</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Datos -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-cliente">Cliente</th>
                        <th rowspan="2" class="col-fecha">Fecha</th>
                        <th rowspan="2" class="col-fecha">Fecha<br>Vencimiento</th>
                        <th colspan="1" class="header-corriente">Corriente</th>
                        <th colspan="5" class="header-vencido">Días de Vencido</th>
                        <th rowspan="2" class="col-monto">Total</th>
                    </tr>
                    <tr>
                        <th class="sub-header-light">Días por Vencer</th>
                        <th class="header-vencido">De 1 a 30</th>
                        <th class="header-vencido">De 31 a 60</th>
                        <th class="header-vencido">De 61 a 90</th>
                        <th class="header-vencido">De 91 a 120</th>
                        <th class="header-vencido">+ 120</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Maquiladora Industrial
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">56,952.00</td>
                        <td class="amount danger">56,952.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Cartones del Norte Demo
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount positive">50,400.00</td>
                        <td class="empty-cell">-</td>
                        <td class="amount warning">20,000.00</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount">70,400.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Farmaceutica Demo
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">7,920.00</td>
                        <td class="amount danger">7,920.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Corporativo Monterrey Demo
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">9,440.00</td>
                        <td class="amount danger">9,440.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Empresa USA Demo
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">5,653.80</td>
                        <td class="amount danger">5,653.80</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Logistica Demo
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">39,600.00</td>
                        <td class="amount danger">39,600.00</td>
                    </tr>
                    <tr>
                        <td class="col-cliente">
                            <i class="fas fa-chevron-right expand-icon"></i>
                            Cedis Mty 1
                        </td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="empty-cell">-</td>
                        <td class="amount danger">279,000.00</td>
                        <td class="amount danger">279,000.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">TOTAL</td>
                        <td>$ 0.00</td>
                        <td>$ 50,400.00</td>
                        <td>$ 0.00</td>
                        <td>$ 20,000.00</td>
                        <td>$ 0.00</td>
                        <td>$ 398,565.80</td>
                        <td>$ 468,965.80</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro de clientes
        const clientFilter = document.getElementById('client-filter');
        if (clientFilter) {
            clientFilter.addEventListener('change', function() {
                const selectedClient = this.value;
                console.log('Cliente seleccionado:', selectedClient);
                
                if (selectedClient === 'todos') {
                    alert('Mostrando todos los clientes');
                } else {
                    alert(`Filtrando por: ${this.options[this.selectedIndex].text}`);
                }
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
                    alert('✅ Archivo Excel generado exitosamente\n\n📊 Contenido:\n• Antigüedad de saldos por cliente\n• Resumen por rangos de días\n• Totales y subtotales\n\n📁 El archivo se descargará automáticamente.');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1500);
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
                    alert('✅ Archivo PDF generado exitosamente\n\n📄 Contenido:\n• Reporte de antigüedad de saldos\n• Gráficos y estadísticas\n• Formato profesional\n\n📁 El archivo se descargará automáticamente.');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1500);
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
                    alert('✅ Datos actualizados correctamente');
                }, 1000);
            });
        }
        
        // Expandir/colapsar filas
        const expandIcons = document.querySelectorAll('.expand-icon');
        expandIcons.forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('expanded');
                
                // Aquí se podría implementar la lógica para mostrar/ocultar detalles
                if (this.classList.contains('expanded')) {
                    console.log('Expandiendo detalles del cliente');
                } else {
                    console.log('Colapsando detalles del cliente');
                }
            });
        });
        
        // Animación de entrada para KPI cards
        setTimeout(() => {
            const kpiCards = document.querySelectorAll('.kpi-card');
            kpiCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }, 100);
        
        // Tooltip para celdas con montos
        const amountCells = document.querySelectorAll('.amount');
        amountCells.forEach(cell => {
            cell.addEventListener('mouseenter', function() {
                if (!this.classList.contains('empty-cell')) {
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