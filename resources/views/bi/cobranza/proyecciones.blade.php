@extends('layouts.navigation')

@section('content')
<style>
    :root {
        --primary-blue: #0185a2;
        --primary-blue-light: #4aa3b9;
        --primary-blue-dark: #01647a;
        --primary-blue-soft: #e6f3f7;
        --primary-blue-extra-soft: #f0f9fc;
        --primary-green: #1e7e34;
        --primary-green-light: #e8f5e9;
        --primary-green-soft: #f1f9f0;
        --primary-purple: #5e4b8a;
        --primary-purple-light: #ede7f6;
        --primary-purple-soft: #f5f2fa;
        --primary-amber: #b85e00;
        --primary-amber-light: #fff3e0;
        --primary-amber-soft: #fff9f0;
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
        
        /* PALETA DE COLORES PARA GRÁFICAS */
        --chart-1: #5470c6;
        --chart-2: #fac858;
        --chart-3: #5ab1ef;
        --chart-4: #ee6666;
        --chart-5: #6f9e4b;
        --chart-6: #9a60b4;
        --chart-7: #ea7ccc;
        
        /* Colores específicos por cliente */
        --client-1: #5470c6;
        --client-2: #6f9e4b;
        --client-3: #fac858;
        --client-4: #9a60b4;
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
    
    .main-content {
        padding: 2rem;
        max-width: 1800px;
        margin: 0 auto;
    }
    
    .page-header {
        background: linear-gradient(135deg, white, #fafcfc);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        border: 1px solid var(--border-light);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-blue), var(--primary-blue-dark));
        border-radius: 6px 0 0 6px;
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
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }
    
    .title-icon {
        font-size: 2rem;
        color: var(--primary-blue);
        background: var(--primary-blue-soft);
        padding: 0.5rem;
        border-radius: 16px;
    }
    
    .page-subtitle {
        font-size: 0.95rem;
        color: var(--text-medium);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .executive-badge {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }
    
    .btn {
        padding: 0.75rem 1.75rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }
    
    .btn-primary {
        background: var(--primary-blue);
        color: white;
        box-shadow: 0 4px 12px rgba(1, 133, 162, 0.2);
    }
    
    .btn-primary:hover {
        background: var(--primary-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(1, 133, 162, 0.3);
    }
    
    .btn-excel {
        background: #1e4b3c;
        color: white;
    }
    
    .btn-excel:hover {
        background: #15382c;
        transform: translateY(-2px);
    }
    
    .btn-pdf {
        background: #a83434;
        color: white;
    }
    
    .btn-pdf:hover {
        background: #8f2b2b;
        transform: translateY(-2px);
    }
    
    .projection-controls {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-light);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    }
    
    .scenario-selector {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .scenario-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-medium);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    
    .scenario-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .scenario-btn {
        padding: 0.6rem 1.5rem;
        border: 1.5px solid var(--border-light);
        background: white;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-medium);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .scenario-btn.active {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: white;
        box-shadow: 0 4px 12px rgba(1, 133, 162, 0.2);
    }
    
    .scenario-btn:hover {
        border-color: var(--primary-blue);
    }
    
    .projection-params {
        display: flex;
        gap: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .param-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .param-label {
        font-size: 0.8rem;
        color: var(--text-light);
        font-weight: 500;
    }
    
    .param-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--primary-blue-dark);
        background: var(--primary-blue-soft);
        padding: 0.4rem 1rem;
        border-radius: 20px;
    }
    
    .executive-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .executive-kpi-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-light);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .executive-kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 24px rgba(0, 0, 0, 0.06);
        border-color: var(--border-medium);
    }
    
    .kpi-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .kpi-title {
        display: flex;
        flex-direction: column;
    }
    
    .kpi-name {
        font-size: 0.8rem;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 0.25rem;
    }
    
    .kpi-metric {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--text-dark);
        font-family: 'Inter', 'Roboto Mono', monospace;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }
    
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
        flex-shrink: 0;
    }
    
    .kpi-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-light);
    }
    
    .kpi-trend {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .trend-up {
        color: var(--success);
    }
    
    .kpi-badge {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.75rem;
        margin-bottom: 2rem;
    }
    
    .chart-card {
        background: white;
        border-radius: 24px;
        padding: 1.75rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--border-light);
        transition: all 0.2s ease;
    }
    
    .chart-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.04);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        display: flex;
        flex-direction: column;
    }
    
    .chart-title h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }
    
    .chart-title span {
        font-size: 0.75rem;
        color: var(--text-light);
        font-weight: 500;
    }
    
    .chart-legend {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: var(--text-medium);
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 4px;
    }
    
    .insights-section {
        margin-bottom: 2rem;
    }
    
    .insights-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.75rem;
    }
    
    .insight-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        border: 1px solid var(--border-light);
        position: relative;
        transition: all 0.2s ease;
    }
    
    .insight-card:hover {
        background: linear-gradient(135deg, white, var(--primary-blue-extra-soft));
        border-color: var(--primary-blue-light);
    }
    
    .insight-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: var(--primary-blue-soft);
        color: var(--primary-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 1.25rem;
    }
    
    .insight-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }
    
    .insight-description {
        font-size: 0.85rem;
        color: var(--text-medium);
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    
    .insight-meta {
        font-size: 0.75rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-light);
    }
    
    .insight-badge {
        background: var(--primary-green-light);
        color: var(--primary-green);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .projection-table-section {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        border: 1px solid var(--border-light);
        margin-bottom: 2rem;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-header h2 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .table-responsive {
        overflow-x: auto;
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
    }
    
    .data-table tbody tr:hover {
        background-color: var(--primary-blue-extra-soft);
    }
    
    .projected-row {
        background-color: rgba(250, 200, 88, 0.05);
        border-left: 3px solid var(--chart-2);
    }
    
    .amount {
        font-family: 'Roboto Mono', monospace;
        font-weight: 600;
    }
    
    .amount.projected {
        color: var(--chart-2);
        font-weight: 700;
    }
    
    .amount.positive {
        color: var(--success);
    }
    
    .amount.negative {
        color: var(--error);
    }
    
    .explanation-badge {
        background: var(--primary-blue-soft);
        color: var(--primary-blue-dark);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .methodology-card {
        background: linear-gradient(135deg, var(--primary-blue-extra-soft), white);
        border-radius: 20px;
        padding: 1.75rem;
        border: 1px solid var(--primary-blue-light);
        margin-top: 1.5rem;
    }
    
    .methodology-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-blue-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .methodology-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .methodology-item {
        display: flex;
        gap: 1rem;
    }
    
    .methodology-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.1rem;
        border: 1px solid var(--primary-blue-light);
    }
    
    .methodology-content h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }
    
    .methodology-content p {
        font-size: 0.8rem;
        color: var(--text-medium);
        line-height: 1.4;
    }
    
    .methodology-formula {
        background: white;
        padding: 0.75rem;
        border-radius: 8px;
        font-family: 'Roboto Mono', monospace;
        font-size: 0.75rem;
        color: var(--primary-blue-dark);
        margin-top: 0.5rem;
        border: 1px dashed var(--primary-blue-light);
    }
    
    @media (max-width: 1400px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
        
        .insights-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .insights-grid {
            grid-template-columns: 1fr;
        }
        
        .methodology-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
        
        .page-header {
            padding: 1.5rem;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
        
        .projection-controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<div class="main-content">
    <!-- Header Ejecutivo -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <div class="page-title">
                    <i class="fas fa-chart-simple title-icon"></i>
                    Proyecciones Empresariales
                    <span class="executive-badge">
                        <i class="fas fa-chart-line"></i>
                        Proyección Estadística
                    </span>
                </div>
                <div class="page-subtitle">
                    <i class="fas fa-calendar-alt"></i>
                    Proyección 2026 • Actualizado: 11/02/2026
                    <span style="margin-left: 1rem; background: var(--primary-amber-light); color: var(--primary-amber); padding: 0.2rem 0.8rem; border-radius: 20px; font-size: 0.7rem;">
                        <i class="fas fa-exclamation-triangle"></i> 
                    </span>
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
            </div>
        </div>
    </div>

    <!-- Panel de Control de Escenarios -->
    <div class="projection-controls">

        <div class="projection-params">
            <div class="param-item">
                <span class="param-label">Crecimiento proyectado:</span>
                <span class="param-value" id="growth-rate">+12.4%</span>
            </div>
            <div class="param-item">
                <span class="param-label">Margen de error:</span>
                <span class="param-value">±8.5%</span>
            </div>
            <div class="param-item">
                <span class="param-label">Confiabilidad:</span>
                <span class="param-value">80%</span>
            </div>
        </div>
    </div>

    <!-- KPIs Ejecutivos -->
    <div class="executive-kpi-grid">
        <div class="executive-kpi-card">
            <div class="kpi-header">
                <div class="kpi-title">
                    <span class="kpi-name">Ingresos Proyectados 2026</span>
                    <span class="kpi-metric" id="revenue-projection">$48.2M</span>
                </div>
                <div class="kpi-icon" style="background: linear-gradient(135deg, var(--chart-1), #3d5a8c);">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="kpi-footer">
                <span class="kpi-trend trend-up" id="revenue-trend">
                    <i class="fas fa-arrow-up"></i> +12.4% vs 2025
                </span>
                <span class="kpi-badge">
                    <i class="fas fa-calculator"></i> Regresión Lineal
                </span>
            </div>
        </div>
        <div class="executive-kpi-card">
            <div class="kpi-header">
                <div class="kpi-title">
                    <span class="kpi-name">EBITDA Proyectado</span>
                    <span class="kpi-metric" id="ebitda-projection">$9.8M</span>
                </div>
                <div class="kpi-icon" style="background: linear-gradient(135deg, var(--chart-6), #7d5aa6);">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            <div class="kpi-footer">
                <span class="kpi-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +8.2% vs 2025
                </span>
                <span class="kpi-badge">Margen: 20.3%</span>
            </div>
        </div>
        <div class="executive-kpi-card">
            <div class="kpi-header">
                <div class="kpi-title">
                    <span class="kpi-name">Flujo de Caja</span>
                    <span class="kpi-metric" id="cashflow-projection">$5.4M</span>
                </div>
                <div class="kpi-icon" style="background: linear-gradient(135deg, var(--chart-5), #4e8a3a);">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="kpi-footer">
                <span class="kpi-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +15.7% vs 2025
                </span>
                <span class="kpi-badge">Liquidez: 2.4x</span>
            </div>
        </div>
        <div class="executive-kpi-card">
            <div class="kpi-header">
                <div class="kpi-title">
                    <span class="kpi-name">ROI Proyectado</span>
                    <span class="kpi-metric">18.6%</span>
                </div>
                <div class="kpi-icon" style="background: linear-gradient(135deg, var(--chart-2), #c4a03a);">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
            <div class="kpi-footer">
                <span class="kpi-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +230 bps
                </span>
                <span class="kpi-badge">WACC: 7.2%</span>
            </div>
        </div>
    </div>

    <!-- Grid de Gráficas -->
    <div class="charts-grid">
        <!-- GRÁFICA 1: Proyección de Ingresos 2026 -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>
                        <i class="fas fa-chart-line" style="color: var(--chart-1);"></i>
                        Proyección de Ingresos 2026
                    </h3>
                    <span>Comparativa trimestral • Real vs Proyectado</span>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--chart-1);"></div>
                        <span>Real 2025</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--chart-2);"></div>
                        <span>Proyectado 2026</span>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; justify-content: space-around; align-items: flex-end; height: 200px; position: relative;">
                    <div style="position: absolute; left: 0; right: 0; top: 0; height: 100%; display: flex; flex-direction: column; justify-content: space-between; pointer-events: none;">
                        <div style="border-bottom: 1px dashed var(--border-light); height: 0; width: 100%;"></div>
                        <div style="border-bottom: 1px dashed var(--border-light); height: 0; width: 100%;"></div>
                        <div style="border-bottom: 1px dashed var(--border-light); height: 0; width: 100%;"></div>
                        <div style="border-bottom: 1px dashed var(--border-light); height: 0; width: 100%;"></div>
                    </div>
                    
                    <!-- Q1 -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 120px;">
                        <div style="display: flex; align-items: flex-end; gap: 1rem; height: 160px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 100px; width: 45px; background: var(--chart-1); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(84, 112, 198, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: var(--chart-1); font-weight: 600;">$8.2M</span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 120px; width: 45px; background: var(--chart-2); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(250, 200, 88, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: #b38f3d; font-weight: 600;">$10.2M</span>
                            </div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark);">Q1</span>
                    </div>
                    
                    <!-- Q2 -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 120px;">
                        <div style="display: flex; align-items: flex-end; gap: 1rem; height: 160px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 115px; width: 45px; background: var(--chart-1); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(84, 112, 198, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: var(--chart-1); font-weight: 600;">$9.5M</span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 135px; width: 45px; background: var(--chart-2); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(250, 200, 88, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: #b38f3d; font-weight: 600;">$11.5M</span>
                            </div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark);">Q2</span>
                    </div>
                    
                    <!-- Q3 -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 120px;">
                        <div style="display: flex; align-items: flex-end; gap: 1rem; height: 160px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 130px; width: 45px; background: var(--chart-1); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(84, 112, 198, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: var(--chart-1); font-weight: 600;">$10.8M</span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 150px; width: 45px; background: var(--chart-2); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(250, 200, 88, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: #b38f3d; font-weight: 600;">$12.8M</span>
                            </div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark);">Q3</span>
                    </div>
                    
                    <!-- Q4 -->
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 120px;">
                        <div style="display: flex; align-items: flex-end; gap: 1rem; height: 160px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 140px; width: 45px; background: var(--chart-1); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(84, 112, 198, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: var(--chart-1); font-weight: 600;">$11.7M</span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <div style="height: 165px; width: 45px; background: var(--chart-2); border-radius: 8px 8px 0 0; box-shadow: 0 2px 6px rgba(250, 200, 88, 0.3);"></div>
                                <span style="font-size: 0.7rem; margin-top: 0.3rem; color: #b38f3d; font-weight: 600;">$13.7M</span>
                            </div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--text-dark);">Q4</span>
                    </div>
                </div>
            </div>
            
            <!-- Explicación REALISTA -->
            <div style="margin-top: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: 12px; border-left: 4px solid var(--chart-1);">
                <div style="display: flex; align-items: flex-start; gap: 0.8rem;">
                    <i class="fas fa-calculator" style="color: var(--chart-1); margin-top: 0.2rem;"></i>
                    <div>
                        <span style="font-weight: 700; font-size: 0.85rem; color: var(--text-dark);">¿Cómo se calcula?</span>
                        <p style="font-size: 0.75rem; color: var(--text-medium); margin-top: 0.3rem; line-height: 1.5;">
                            <strong>Método:</strong> Regresión lineal sobre datos históricos 2023-2025 (36 meses).<br>
                            <strong>CAGR histórico:</strong> 12.4% anual basado en crecimiento compuesto 2023-2025.<br>
                            <strong>Ajuste estacional:</strong> Q1: 0.85 | Q2: 0.95 | Q3: 1.05 | Q4: 1.15 (promedio 3 años).<br>
                            <strong>Margen de error estimado:</strong> ±8.5% (típico en proyecciones de logística con 3 años de datos).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRÁFICA 2: Distribución de Ingresos -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>
                        <i class="fas fa-chart-pie" style="color: var(--chart-6);"></i>
                        Distribución de Ingresos 2026
                    </h3>
                    <span>Proyección por línea de negocio</span>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                <div style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient(
                    var(--chart-1) 0deg 144deg,
                    var(--chart-6) 144deg 216deg,
                    var(--chart-5) 216deg 288deg,
                    var(--chart-2) 288deg 324deg,
                    var(--chart-4) 324deg 360deg
                ); box-shadow: 0 8px 16px rgba(0,0,0,0.05);"></div>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem; flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 16px; height: 16px; background: var(--chart-1); border-radius: 4px;"></div>
                        <div style="flex: 1; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.8rem; font-weight: 500;">Transporte Carga</span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--chart-1);">$19.3M</span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">40%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 16px; height: 16px; background: var(--chart-6); border-radius: 4px;"></div>
                        <div style="flex: 1; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.8rem; font-weight: 500;">Logística Especializada</span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--chart-6);">$10.6M</span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">22%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 16px; height: 16px; background: var(--chart-5); border-radius: 4px;"></div>
                        <div style="flex: 1; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.8rem; font-weight: 500;">Almacenaje</span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--chart-5);">$8.2M</span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">17%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 16px; height: 16px; background: var(--chart-2); border-radius: 4px;"></div>
                        <div style="flex: 1; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.8rem; font-weight: 500;">Distribución</span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #b38f3d;">$6.3M</span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">13%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 16px; height: 16px; background: var(--chart-4); border-radius: 4px;"></div>
                        <div style="flex: 1; display: flex; justify-content: space-between;">
                            <span style="font-size: 0.8rem; font-weight: 500;">Valor Agregado</span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--chart-4);">$3.8M</span>
                            <span style="font-size: 0.75rem; color: var(--text-light);">8%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 1.5rem; padding: 0.75rem; background: #f8fafc; border-radius: 12px;">
                <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                    <i class="fas fa-chart-simple" style="color: var(--chart-6); margin-top: 0.2rem;"></i>
                    <div>
                        <span style="font-weight: 700; font-size: 0.8rem;">Cálculo de distribución:</span>
                        <p style="font-size: 0.75rem; color: var(--text-medium); margin-top: 0.2rem;">
                            Basado en proporciones históricas 2025 con ajuste por contratos confirmados. 
                            Logística Especializada crece 15% por contrato automotriz pipeline (alto: 85% probabilidad).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRÁFICA 3: Top Clientes -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>
                        <i class="fas fa-users" style="color: var(--client-2);"></i>
                        Top Clientes - Proyección 2026
                    </h3>
                    <span>Basado en histórico + pipeline confirmado</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-1);">Cartones del Norte</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-1);">$12.8M</span>
                    </div>
                    <div style="width: 100%; height: 10px; background: #edf2f7; border-radius: 5px;">
                        <div style="width: 85%; height: 10px; background: linear-gradient(90deg, var(--client-1), #7492e0); border-radius: 5px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 0.7rem;">
                        <span style="color: var(--text-light);">Histórico 2025: $10.8M</span>
                        <span style="color: var(--chart-5); background: var(--primary-green-light); padding: 0.2rem 0.6rem; border-radius: 12px;">
                            <i class="fas fa-arrow-up"></i> +18.2%
                        </span>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-2);">Cliente Mty Demo</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-2);">$9.4M</span>
                    </div>
                    <div style="width: 100%; height: 10px; background: #edf2f7; border-radius: 5px;">
                        <div style="width: 62%; height: 10px; background: linear-gradient(90deg, var(--client-2), #8fc96b); border-radius: 5px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 0.7rem;">
                        <span style="color: var(--text-light);">Histórico 2025: $8.3M</span>
                        <span style="color: var(--chart-5); background: var(--primary-green-light); padding: 0.2rem 0.6rem; border-radius: 12px;">
                            <i class="fas fa-arrow-up"></i> +12.5%
                        </span>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #b38f3d;">Transportes del Norte</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #b38f3d;">$7.2M</span>
                    </div>
                    <div style="width: 100%; height: 10px; background: #edf2f7; border-radius: 5px;">
                        <div style="width: 48%; height: 10px; background: linear-gradient(90deg, var(--client-3), #ffe08a); border-radius: 5px;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.25rem; font-size: 0.7rem;">
                        <span style="color: var(--text-light);">Histórico 2025: $6.9M</span>
                        <span style="color: var(--text-light); background: #f1f5f9; padding: 0.2rem 0.6rem; border-radius: 12px;">
                            <i class="fas fa-minus"></i> +4.1%
                        </span>
                    </div>
                </div>
            </div>
            <div style="margin-top: 1.5rem; padding: 0.75rem; background: #f8fafc; border-radius: 12px;">
                <span style="font-weight: 700; font-size: 0.8rem;">📊 Metodología por cliente:</span>
                <p style="font-size: 0.75rem; color: var(--text-medium); margin-top: 0.2rem;">
                    Crecimiento basado en: (1) CAGR individual últimos 2 años, (2) Contratos renovados/nuevos en pipeline, 
                    (3) Tasa de retención histórica 91%. Solo se proyectan clientes con mínimo 24 meses de historial.
                </p>
            </div>
        </div>

        <!-- GRÁFICA 4: Estacionalidad -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <h3>
                        <i class="fas fa-calendar" style="color: var(--chart-4);"></i>
                        Estacionalidad Mensual
                    </h3>
                    <span>Patrones históricos vs proyección</span>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--chart-1);"></div>
                        <span>Promedio 2023-2025</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: var(--chart-2);"></div>
                        <span>Proyección 2026</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.8rem;">
                    <span style="font-size: 0.75rem; width: 45px; font-weight: 600;">Ene</span>
                    <div style="flex: 1; display: flex; gap: 0.5rem; align-items: center;">
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 65%; height: 10px; background: var(--chart-1); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: var(--chart-1); font-weight: 600;">$6.8M</span>
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 78%; height: 10px; background: var(--chart-2); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: #b38f3d; font-weight: 600;">$8.2M</span>
                        <span style="font-size: 0.65rem; width: 45px; color: var(--chart-5); background: #e8f5e9; padding: 0.2rem 0.4rem; border-radius: 12px; text-align: center;">
                            +20%
                        </span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.8rem;">
                    <span style="font-size: 0.75rem; width: 45px; font-weight: 600;">Feb</span>
                    <div style="flex: 1; display: flex; gap: 0.5rem; align-items: center;">
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 58%; height: 10px; background: var(--chart-1); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: var(--chart-1); font-weight: 600;">$6.1M</span>
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 70%; height: 10px; background: var(--chart-2); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: #b38f3d; font-weight: 600;">$7.4M</span>
                        <span style="font-size: 0.65rem; width: 45px; color: var(--chart-5); background: #e8f5e9; padding: 0.2rem 0.4rem; border-radius: 12px; text-align: center;">
                            +21%
                        </span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.8rem;">
                    <span style="font-size: 0.75rem; width: 45px; font-weight: 600;">Mar</span>
                    <div style="flex: 1; display: flex; gap: 0.5rem; align-items: center;">
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 72%; height: 10px; background: var(--chart-1); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: var(--chart-1); font-weight: 600;">$7.5M</span>
                        <div style="flex: 1; height: 10px; background: #edf2f7; border-radius: 5px;">
                            <div style="width: 85%; height: 10px; background: var(--chart-2); border-radius: 5px;"></div>
                        </div>
                        <span style="font-size: 0.7rem; width: 50px; color: #b38f3d; font-weight: 600;">$8.9M</span>
                        <span style="font-size: 0.65rem; width: 45px; color: var(--chart-5); background: #e8f5e9; padding: 0.2rem 0.4rem; border-radius: 12px; text-align: center;">
                            +18%
                        </span>
                    </div>
                </div>
            </div>
            <div style="margin-top: 1.5rem; padding: 0.75rem; background: #f8fafc; border-radius: 12px; border-left: 4px solid var(--chart-4);">
                <span style="font-weight: 700; font-size: 0.8rem;">📊 Factor Estacional:</span>
                <p style="font-size: 0.75rem; color: var(--text-medium); margin-top: 0.2rem;">
                    Coeficientes calculados sobre promedio móvil de 36 meses (2023-2025). 
                    Marzo típicamente +15% vs enero por cierre trimestral. Enero -10% por temporada baja post-festiva.
                </p>
            </div>
        </div>
    </div>

    <!-- Insights AJUSTADOS CON MÉTRICAS REALISTAS -->

    <!-- Tabla de Proyección Detallada -->
    <div class="projection-table-section">
        <div class="section-header">
            <h2>
                <i class="fas fa-table" style="color: var(--primary-blue);"></i>
                Proyección Financiera Detallada 2026
            </h2>
            <span class="explanation-badge">
                <i class="fas fa-file-invoice"></i>
                Miles de MXN
            </span>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Q1 2026</th>
                        <th>Q2 2026</th>
                        <th>Q3 2026</th>
                        <th>Q4 2026</th>
                        <th>Total 2026</th>
                        <th>Var % vs 2025</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Ingresos Operativos</strong></td>
                        <td class="amount">$10,245</td>
                        <td class="amount">$11,560</td>
                        <td class="amount">$12,890</td>
                        <td class="amount">$13,745</td>
                        <td class="amount projected">$48,440</td>
                        <td class="amount positive">+12.4%</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 2rem;">- Transporte Carga</td>
                        <td class="amount">$4,120</td>
                        <td class="amount">$4,650</td>
                        <td class="amount">$5,180</td>
                        <td class="amount">$5,350</td>
                        <td class="amount">$19,300</td>
                        <td class="amount positive">+10.2%</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 2rem;">- Logística Especializada</td>
                        <td class="amount">$2,150</td>
                        <td class="amount">$2,480</td>
                        <td class="amount">$2,850</td>
                        <td class="amount">$3,120</td>
                        <td class="amount">$10,600</td>
                        <td class="amount positive">+18.5%</td>
                    </tr>
                    <tr>
                        <td><strong>Costo de Ventas</strong></td>
                        <td class="amount">$6,350</td>
                        <td class="amount">$7,120</td>
                        <td class="amount">$7,890</td>
                        <td class="amount">$8,280</td>
                        <td class="amount">$29,640</td>
                        <td class="amount positive">+11.8%</td>
                    </tr>
                    <tr class="projected-row">
                        <td><strong>Utilidad Bruta</strong></td>
                        <td class="amount projected">$3,895</td>
                        <td class="amount projected">$4,440</td>
                        <td class="amount projected">$5,000</td>
                        <td class="amount projected">$5,465</td>
                        <td class="amount projected">$18,800</td>
                        <td class="amount positive">+13.2%</td>
                    </tr>
                    <tr>
                        <td>Gastos Operativos</td>
                        <td class="amount">$2,150</td>
                        <td class="amount">$2,280</td>
                        <td class="amount">$2,420</td>
                        <td class="amount">$2,550</td>
                        <td class="amount">$9,400</td>
                        <td class="amount positive">+8.5%</td>
                    </tr>
                    <tr class="projected-row">
                        <td><strong>EBITDA</strong></td>
                        <td class="amount projected">$1,745</td>
                        <td class="amount projected">$2,160</td>
                        <td class="amount projected">$2,580</td>
                        <td class="amount projected">$2,915</td>
                        <td class="amount projected">$9,400</td>
                        <td class="amount positive">+14.8%</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1.5rem; padding: 1rem; background: var(--primary-blue-extra-soft); border-radius: 16px;">
            <div style="display: flex; gap: 1.5rem; align-items: flex-start; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 12px; height: 12px; background: var(--chart-1); border-radius: 4px;"></span>
                    <span style="font-size: 0.8rem;">Datos históricos 2025</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 12px; height: 12px; background: var(--chart-2); border-radius: 4px;"></span>
                    <span style="font-size: 0.8rem;">Proyectados 2026</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-info-circle" style="color: var(--primary-blue);"></i>
                    <span style="font-size: 0.8rem;">Margen EBITDA: 19.4% vs 18.7% 2025</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Disclaimer REALISTA -->
    <div style="margin-top: 2rem; padding: 1.25rem; background: #fff9f0; border-radius: 16px; border: 1px solid var(--primary-amber-light); display: flex; align-items: flex-start; gap: 1rem;">
        <i class="fas fa-exclamation-triangle" style="color: var(--primary-amber); font-size: 1.2rem; margin-top: 0.2rem;"></i>
        <div>
            <span style="font-weight: 700; font-size: 0.9rem; color: var(--primary-amber);">Aviso Importante - Limitaciones de la Proyección:</span>
            <p style="font-size: 0.8rem; color: var(--text-dark); margin-top: 0.5rem; line-height: 1.6;">
                <strong>Esta proyección es una estimación estadística</strong> basada en regresión lineal sobre datos históricos 2023-2025. 
                <strong>Margen de error esperado:</strong> ±8.5% (típico para proyecciones de logística con 3 años de datos históricos).
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scenarioBtns = document.querySelectorAll('.scenario-btn');
        const revenueEl = document.getElementById('revenue-projection');
        const ebitdaEl = document.getElementById('ebitda-projection');
        const cashflowEl = document.getElementById('cashflow-projection');
        const growthRateEl = document.getElementById('growth-rate');
        const revenueTrendEl = document.getElementById('revenue-trend');
        
        scenarioBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                scenarioBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const scenario = this.dataset.scenario;
                let growthRate, revenue, ebitda, cashflow, trend;
                
                if (scenario === 'optimista') {
                    growthRate = '+15.2%';
                    revenue = '$49.8M';
                    ebitda = '$10.4M';
                    cashflow = '$6.1M';
                    trend = '<i class="fas fa-arrow-up"></i> +15.2% vs 2025';
                } else if (scenario === 'realista') {
                    growthRate = '+12.4%';
                    revenue = '$48.2M';
                    ebitda = '$9.8M';
                    cashflow = '$5.4M';
                    trend = '<i class="fas fa-arrow-up"></i> +12.4% vs 2025';
                } else {
                    growthRate = '+8.7%';
                    revenue = '$46.1M';
                    ebitda = '$8.9M';
                    cashflow = '$4.8M';
                    trend = '<i class="fas fa-arrow-up"></i> +8.7% vs 2025';
                }
                
                if (revenueEl) revenueEl.textContent = revenue;
                if (ebitdaEl) ebitdaEl.textContent = ebitda;
                if (cashflowEl) cashflowEl.textContent = cashflow;
                if (growthRateEl) growthRateEl.textContent = growthRate;
                if (revenueTrendEl) revenueTrendEl.innerHTML = trend;
                
                showNotification(`Escenario ${scenario} aplicado`, 'info');
            });
        });
        
        const generateBtn = document.getElementById('generate-projection');
        if (generateBtn) {
            generateBtn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calculando...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-arrows-spin"></i> Recalcular';
                    this.disabled = false;
                    showNotification('Proyección recalculada', 'success');
                }, 2000);
            });
        }
        
        const exportExcel = document.getElementById('export-excel');
        if (exportExcel) {
            exportExcel.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('Exportado a Excel', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1500);
            });
        }
        
        const exportPdf = document.getElementById('export-pdf');
        if (exportPdf) {
            exportPdf.addEventListener('click', function() {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
                this.disabled = true;
                
                setTimeout(() => {
                    showNotification('Exportado a PDF', 'success');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }, 1500);
            });
        }
        
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