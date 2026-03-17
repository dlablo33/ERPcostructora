@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <style>
        /* ========== VARIABLES - PALETA CORPORATIVA ========== */
        :root {
            --primary: #083CAE;        /* Azul corporativo específico */
            --primary-light: #e6ecfa;
            --primary-dark: #083CAE;
            --secondary: #083CAE;       /* Azul acero */
            --success: #2e7d32;         /* Verde oscuro profesional */
            --success-light: #e8f5e9;
            --warning: #b85e00;          /* Naranja quemado */
            --warning-light: #fff3e0;
            --danger: #b71c1c;           /* Rojo oscuro */
            --danger-light: #ffebee;
            --info: #006064;             /* Azul petróleo */
            --info-light: #e0f7fa;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --border-color: #e0e0e0;
            --card-shadow: 0 2px 4px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.03);
        }

        /* ========== ANIMACIONES ========== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-10px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ========== ESTILOS BASE ========== */
        .dashboard-container {
            animation: fadeIn 0.3s ease;
            padding: 24px;
        }

        /* Header */
        .dashboard-header {
            background: white;
            border-radius: 8px;
            padding: 16px 24px;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }

        .header-title p {
            color: var(--gray-600);
            margin: 4px 0 0;
            font-size: 13px;
        }

        .header-controls {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .control-btn {
            background: white;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
            color: var(--gray-700);
        }

        .control-btn:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        .control-btn.primary {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .control-btn.primary:hover {
            background: var(--primary-dark);
        }

        .period-selector {
            display: flex;
            gap: 2px;
            background: var(--gray-100);
            padding: 2px;
            border-radius: 6px;
            border: 1px solid var(--gray-200);
        }

        .period-option {
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
            color: var(--gray-600);
        }

        .period-option.active {
            background: white;
            color: var(--primary);
            font-weight: 500;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        /* Grid con soporte para drag & drop */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            min-height: 400px;
            transition: all 0.2s;
        }

        .widget-item {
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            transition: all 0.2s;
            overflow: hidden;
            animation: slideIn 0.3s ease;
            position: relative;
        }

        .widget-item:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.03);
        }

        .widget-item.dragging {
            opacity: 0.5;
            transform: scale(0.98);
            cursor: grabbing;
        }

        .widget-item.drag-over {
            border: 2px dashed var(--primary);
            background: var(--primary-light);
        }

        /* Clases de tamaño */
        .col-span-3 { grid-column: span 3; }
        .col-span-4 { grid-column: span 4; }
        .col-span-5 { grid-column: span 5; }
        .col-span-6 { grid-column: span 6; }
        .col-span-7 { grid-column: span 7; }
        .col-span-8 { grid-column: span 8; }
        .col-span-9 { grid-column: span 9; }
        .col-span-12 { grid-column: span 12; }

        /* Cabecera de widgets - Azul corporativo #083CAE */
        .widget-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary);
            cursor: grab;
            user-select: none;
        }

        .widget-header:active {
            cursor: grabbing;
        }

        .widget-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: white;
            font-size: 15px;
        }

        .widget-title i {
            color: white;
            font-size: 18px;
        }

        .widget-controls {
            display: flex;
            gap: 6px;
        }

        .widget-control {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: rgba(255,255,255,0.8);
            transition: all 0.2s;
            background: transparent;
            border: none;
        }

        .widget-control:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .widget-control.active {
            background: white;
            color: var(--primary);
        }

        /* Selector de tipo de gráfico */
        .chart-type-selector {
            display: flex;
            gap: 2px;
            background: rgba(255,255,255,0.15);
            padding: 2px;
            border-radius: 4px;
            margin-right: 8px;
        }

        .chart-type-btn {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            cursor: pointer;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .chart-type-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .chart-type-btn.active {
            background: white;
            color: var(--primary);
            font-weight: 500;
        }

        .widget-content {
            padding: 20px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        /* Modal de personalización */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modal-header h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .modal-header .widget-control {
            color: white;
        }

        .modal-header .widget-control:hover {
            background: rgba(255,255,255,0.2);
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            text-align: right;
            background: var(--gray-100);
            position: sticky;
            bottom: 0;
        }

        .category-title {
            font-weight: 600;
            color: var(--primary);
            margin: 20px 0 12px;
            padding-bottom: 4px;
            border-bottom: 1px solid var(--border-color);
            font-size: 16px;
        }

        .widget-option {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .widget-option:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .widget-option input[type="checkbox"] {
            margin-right: 12px;
            width: 18px;
            height: 18px;
        }

        .widget-option-info {
            flex: 1;
        }

        .widget-option-info h4 {
            font-size: 15px;
            margin: 0 0 4px;
            color: var(--gray-800);
        }

        .widget-option-info p {
            font-size: 12px;
            color: var(--gray-600);
            margin: 0;
        }

        .size-selector {
            display: flex;
            gap: 6px;
            margin: 0 12px;
        }

        .size-btn {
            padding: 5px 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            background: white;
            color: var(--gray-600);
        }

        .size-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .apply-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            font-size: 14px;
        }

        .apply-btn:hover {
            background: var(--primary-dark);
        }

        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
        }

        .kpi-card {
            background: var(--gray-100);
            border-radius: 6px;
            padding: 16px;
            border: 1px solid var(--border-color);
        }

        .kpi-card .label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: var(--gray-600);
            margin-bottom: 6px;
        }

        .kpi-card .value {
            font-size: 24px;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .kpi-card .trend {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .trend.positive { color: var(--success); }
        .trend.negative { color: var(--danger); }
        .trend.warning { color: var(--warning); }

        /* Tablas */
        .finance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .finance-table th {
            text-align: left;
            padding: 12px 8px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            font-size: 13px;
            border-bottom: 2px solid var(--primary);
        }

        .finance-table td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-800);
        }

        .finance-table tr:hover td {
            background: var(--gray-100);
        }

        .finance-table .positive { color: var(--success); font-weight: 500; }
        .finance-table .negative { color: var(--danger); font-weight: 500; }
        .finance-table .warning { color: var(--warning); font-weight: 500; }

        /* Gráficos SVG mejorados */
        .chart-container {
            width: 100%;
            height: 240px;
            position: relative;
            margin-top: 10px;
        }

        .chart-bar {
            fill: var(--primary);
            transition: fill 0.2s;
        }

        .chart-bar:hover {
            fill: var(--primary-dark);
        }

        .chart-bar-positive { fill: var(--success); }
        .chart-bar-negative { fill: var(--danger); }
        .chart-bar-warning { fill: var(--warning); }

        .chart-line {
            stroke: var(--primary);
            stroke-width: 3;
            fill: none;
        }

        .chart-line-positive { stroke: var(--success); }
        .chart-line-warning { stroke: var(--warning); }

        .chart-axis line, .chart-axis path {
            stroke: var(--gray-400);
        }

        .chart-axis text {
            fill: var(--gray-700);
            font-size: 11px;
        }

        .chart-label {
            font-size: 11px;
            fill: var(--gray-600);
        }

        .chart-value {
            font-size: 10px;
            fill: var(--gray-800);
            font-weight: 500;
        }

        /* Leyendas de gráficos */
        .chart-legend {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin: 15px 0 10px;
            padding: 10px;
            background: var(--gray-100);
            border-radius: 4px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .legend-color.primary { background: var(--primary); }
        .legend-color.success { background: var(--success); }
        .legend-color.warning { background: var(--warning); }
        .legend-color.danger { background: var(--danger); }
        .legend-color.info { background: var(--info); }

        /* Badges con colores */
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success { 
            background: var(--success-light); 
            color: var(--success);
        }
        .badge-warning { 
            background: var(--warning-light); 
            color: var(--warning);
        }
        .badge-danger { 
            background: var(--danger-light); 
            color: var(--danger);
        }
        .badge-info { 
            background: var(--info-light); 
            color: var(--info);
        }
        .badge-primary { 
            background: var(--primary-light); 
            color: var(--primary);
        }

        /* Alertas */
        .alert-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: var(--gray-100);
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 14px;
            border-left: 4px solid transparent;
        }

        .alert-item.warning { 
            border-left-color: var(--warning);
            background: var(--warning-light);
        }
        .alert-item.danger { 
            border-left-color: var(--danger);
            background: var(--danger-light);
        }
        .alert-item.success { 
            border-left-color: var(--success);
            background: var(--success-light);
        }
        .alert-item.info { 
            border-left-color: var(--info);
            background: var(--info-light);
        }

        /* Progress bars */
        .progress-bar-container {
            margin: 12px 0;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
            color: var(--gray-700);
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-bar-fill.success { background: var(--success); }
        .progress-bar-fill.warning { background: var(--warning); }
        .progress-bar-fill.danger { background: var(--danger); }
        .progress-bar-fill.primary { background: var(--primary); }

        /* Responsive */
        @media (max-width: 1200px) {
            .col-span-3, .col-span-4, .col-span-5, .col-span-6, .col-span-7, .col-span-8, .col-span-9 {
                grid-column: span 6;
            }
        }

        @media (max-width: 768px) {
            .col-span-3, .col-span-4, .col-span-5, .col-span-6, .col-span-7, .col-span-8, .col-span-9 {
                grid-column: span 12;
            }
            
            .widget-content {
                padding: 15px;
            }
            
            .kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>Panel de Control</h1>
              <p>
                <i class="fas fa-user"></i> 
                Hola, {{ Auth::user()->name }} · 
                <span id="fechaActual"></span>
            </p>
        </div>
        
        <div class="header-controls">
            <div class="period-selector">
                <div class="period-option active" onclick="cambiarPeriodo(this, 'ene-2026')">Ene 2026</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'feb-2026')">Feb 2026</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'mar-2026')">Mar 2026</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'q1-2026')">Q1 2026</div>
            </div>
            
            <div class="control-btn primary" onclick="abrirPersonalizador()">
                <i class="fas fa-edit"></i>
                <span>Personalizar Dashboard</span>
            </div>
            
            <div class="control-btn" onclick="guardarLayout()">
                <i class="fas fa-save"></i>
                <span>Guardar Vista</span>
            </div>
            
            <div class="control-btn" onclick="resetearDashboard()">
                <i class="fas fa-undo"></i>
                <span>Resetear</span>
            </div>
        </div>
    </div>

    <!-- Grid de Widgets (se llena dinámicamente) -->
    <div class="widget-grid" id="widgetGrid"></div>

    <!-- Modal de Personalización -->
    <div class="modal-overlay" id="modalPersonalizar" onclick="cerrarPersonalizador(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2><i class="fas fa-edit" style="margin-right: 8px;"></i> Personalizar Dashboard</h2>
                <div class="widget-control" onclick="cerrarPersonalizador(event)">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            
            <div class="modal-body">
                <div class="category-title">📊 KPIs y Resúmenes</div>
                <div class="widget-option" data-widget="kpis-principales">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>KPIs Principales</h4>
                        <p>Ingresos, EBITDA, Backlog y márgenes</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn" data-size="3">1/4</span>
                        <span class="size-btn active" data-size="6">1/2</span>
                        <span class="size-btn" data-size="8">2/3</span>
                        <span class="size-btn" data-size="12">Completo</span>
                    </div>
                </div>

                <div class="category-title">📈 Estado de Resultados</div>
                <div class="widget-option" data-widget="estado-resultados">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Estado de Resultados</h4>
                        <p>P&L completo con márgenes y análisis</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn active" data-size="7">Mitad+</span>
                        <span class="size-btn" data-size="12">Completo</span>
                    </div>
                </div>

                <div class="category-title">🏗️ Tipos de Negocio</div>
                <div class="widget-option" data-widget="tipos-negocio">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Análisis por Tipo de Negocio</h4>
                        <p>Residencial, Obra Pública, Industrial, Infraestructura</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn active" data-size="5">Media</span>
                        <span class="size-btn" data-size="8">2/3</span>
                    </div>
                </div>

                <div class="category-title">💰 Cuentas por Cobrar/Pagar</div>
                <div class="widget-option" data-widget="cuentas-cobrar">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Cuentas por Cobrar</h4>
                        <p>Antigüedad de cartera y rotación</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn active" data-size="3">1/4</span>
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn" data-size="6">1/2</span>
                    </div>
                </div>

                <div class="widget-option" data-widget="cuentas-pagar">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Cuentas por Pagar</h4>
                        <p>Antigüedad de obligaciones</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn active" data-size="3">1/4</span>
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn" data-size="6">1/2</span>
                    </div>
                </div>

                <div class="category-title">📊 Ratios Financieros</div>
                <div class="widget-option" data-widget="ratios">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Ratios Financieros</h4>
                        <p>Liquidez, endeudamiento, rentabilidad</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn active" data-size="3">1/4</span>
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn" data-size="6">1/2</span>
                    </div>
                </div>

                <div class="category-title">📋 Proyectos</div>
                <div class="widget-option" data-widget="proyectos">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Rentabilidad por Proyecto</h4>
                        <p>Top proyectos con márgenes y avance</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn" data-size="6">1/2</span>
                        <span class="size-btn active" data-size="8">2/3</span>
                        <span class="size-btn" data-size="12">Completo</span>
                    </div>
                </div>

                <div class="category-title">⚠️ Alertas</div>
                <div class="widget-option" data-widget="alertas">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Alertas y Seguimiento</h4>
                        <p>Notificaciones y vencimientos</p>
                    </div>
                    <div class="size-selector">
                        <span class="size-btn active" data-size="3">1/4</span>
                        <span class="size-btn" data-size="4">1/3</span>
                        <span class="size-btn" data-size="6">1/2</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="apply-btn" onclick="aplicarPersonalizacion()">
                    <i class="fas fa-check"></i> Aplicar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Configuración de widgets disponibles
    const widgetsConfig = {
        'kpis-principales': {
            titulo: 'KPIs Principales',
            icono: 'fa-chart-line',
            tamanios: { '3': '1/4', '6': '1/2', '8': '2/3', '12': 'Completo' },
            tipos: ['kpi', 'tabla', 'barra'],
            render: (tipo, tamaño) => renderKPIs(tipo, tamaño)
        },
        'estado-resultados': {
            titulo: 'Estado de Resultados',
            icono: 'fa-file-invoice',
            tamanios: { '4': '1/3', '7': 'Mitad+', '12': 'Completo' },
            tipos: ['tabla', 'barra', 'linea'],
            render: (tipo, tamaño) => renderEstadoResultados(tipo, tamaño)
        },
        'tipos-negocio': {
            titulo: 'Tipos de Negocio',
            icono: 'fa-chart-pie',
            tamanios: { '4': '1/3', '5': 'Media', '8': '2/3' },
            tipos: ['pastel', 'barra', 'tabla'],
            render: (tipo, tamaño) => renderTiposNegocio(tipo, tamaño)
        },
        'cuentas-cobrar': {
            titulo: 'Cuentas por Cobrar',
            icono: 'fa-arrow-down',
            tamanios: { '3': '1/4', '4': '1/3', '6': '1/2' },
            tipos: ['tabla', 'barra', 'pastel'],
            render: (tipo, tamaño) => renderCuentasCobrar(tipo, tamaño)
        },
        'cuentas-pagar': {
            titulo: 'Cuentas por Pagar',
            icono: 'fa-arrow-up',
            tamanios: { '3': '1/4', '4': '1/3', '6': '1/2' },
            tipos: ['tabla', 'barra', 'pastel'],
            render: (tipo, tamaño) => renderCuentasPagar(tipo, tamaño)
        },
        'ratios': {
            titulo: 'Ratios Financieros',
            icono: 'fa-calculator',
            tamanios: { '3': '1/4', '4': '1/3', '6': '1/2' },
            tipos: ['kpi', 'tabla', 'barra'],
            render: (tipo, tamaño) => renderRatios(tipo, tamaño)
        },
        'proyectos': {
            titulo: 'Rentabilidad por Proyecto',
            icono: 'fa-hard-hat',
            tamanios: { '6': '1/2', '8': '2/3', '12': 'Completo' },
            tipos: ['tabla', 'barra', 'linea'],
            render: (tipo, tamaño) => renderProyectos(tipo, tamaño)
        },
        'alertas': {
            titulo: 'Alertas',
            icono: 'fa-bell',
            tamanios: { '3': '1/4', '4': '1/3', '6': '1/2' },
            tipos: ['lista', 'tabla'],
            render: (tipo, tamaño) => renderAlertas(tipo, tamaño)
        }
    };

    let draggingItem = null;

    document.addEventListener('DOMContentLoaded', function() {
        actualizarFecha();
        cargarConfiguracionGuardada();
        inicializarDragAndDrop();
    });

    // ========== FUNCIONES DE FECHA ==========
    function actualizarFecha() {
        const fecha = new Date();
        document.getElementById('fechaActual').textContent = 
            fecha.toLocaleDateString('es-MX', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
    }

    function cambiarPeriodo(elemento, periodo) {
        document.querySelectorAll('.period-option').forEach(el => {
            el.classList.remove('active');
        });
        elemento.classList.add('active');
        mostrarNotificacion(`Datos actualizados para ${periodo}`);
    }

    // ========== FUNCIONES DE DRAG & DROP ==========
    function inicializarDragAndDrop() {
        const grid = document.getElementById('widgetGrid');

        grid.addEventListener('dragstart', (e) => {
            const header = e.target.closest('.widget-header');
            if (header) {
                draggingItem = header.closest('.widget-item');
                draggingItem.classList.add('dragging');
                e.dataTransfer.setData('text/plain', '');
                e.dataTransfer.effectAllowed = 'move';
            }
        });

        grid.addEventListener('dragend', (e) => {
            if (draggingItem) {
                draggingItem.classList.remove('dragging');
                draggingItem = null;
            }
            document.querySelectorAll('.widget-item').forEach(item => {
                item.classList.remove('drag-over');
            });
        });

        grid.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            
            const target = e.target.closest('.widget-item');
            if (target && target !== draggingItem) {
                target.classList.add('drag-over');
            }
        });

        grid.addEventListener('dragleave', (e) => {
            const target = e.target.closest('.widget-item');
            if (target) {
                target.classList.remove('drag-over');
            }
        });

        grid.addEventListener('drop', (e) => {
            e.preventDefault();
            const target = e.target.closest('.widget-item');
            
            if (target && draggingItem && target !== draggingItem) {
                const items = [...grid.children];
                const dragIndex = items.indexOf(draggingItem);
                const dropIndex = items.indexOf(target);
                
                if (dragIndex < dropIndex) {
                    target.insertAdjacentElement('afterend', draggingItem);
                } else {
                    target.insertAdjacentElement('beforebegin', draggingItem);
                }
            }
            
            document.querySelectorAll('.widget-item').forEach(item => {
                item.classList.remove('drag-over');
            });
        });
    }

    // ========== PERSONALIZACIÓN ==========
    function abrirPersonalizador() {
        document.getElementById('modalPersonalizar').style.display = 'flex';
        cargarEstadoCheckboxes();
    }

    function cerrarPersonalizador(event) {
        if (event.target === document.getElementById('modalPersonalizar')) {
            document.getElementById('modalPersonalizar').style.display = 'none';
        }
    }

    function cargarEstadoCheckboxes() {
        const widgets = document.querySelectorAll('.widget-item');
        const checkboxes = document.querySelectorAll('.widget-checkbox');
        
        checkboxes.forEach(cb => {
            const widgetOption = cb.closest('.widget-option');
            const widgetId = widgetOption.dataset.widget;
            
            const existe = Array.from(widgets).some(w => w.dataset.widgetId === widgetId);
            cb.checked = existe;
        });
    }

    function aplicarPersonalizacion() {
        const grid = document.getElementById('widgetGrid');
        const seleccionados = [];
        
        document.querySelectorAll('.widget-option').forEach(option => {
            const checkbox = option.querySelector('.widget-checkbox');
            if (checkbox.checked) {
                const widgetId = option.dataset.widget;
                const sizeBtn = option.querySelector('.size-btn.active');
                const tamaño = sizeBtn ? sizeBtn.dataset.size : '6';
                seleccionados.push({ id: widgetId, tamaño: tamaño });
            }
        });

        grid.innerHTML = '';

        seleccionados.forEach(widget => {
            const config = widgetsConfig[widget.id];
            if (config) {
                agregarWidget(widget.id, config, widget.tamaño, 'tabla');
            }
        });

        document.getElementById('modalPersonalizar').style.display = 'none';
        guardarLayout();
        mostrarNotificacion('Dashboard personalizado guardado');
    }

    function agregarWidget(widgetId, config, tamaño, tipo) {
        const grid = document.getElementById('widgetGrid');
        const widgetHTML = `
            <div class="widget-item col-span-${tamaño}" data-widget-id="${widgetId}" draggable="false">
                <div class="widget-header" draggable="true">
                    <div class="widget-title">
                        <i class="fas ${config.icono}"></i>
                        ${config.titulo}
                    </div>
                    <div class="widget-controls">
                        <div class="chart-type-selector">
                            ${config.tipos.map(t => `
                                <button class="chart-type-btn ${t === tipo ? 'active' : ''}" 
                                        onclick="cambiarTipoWidget(this, '${widgetId}', '${t}')">
                                    <i class="fas ${getIconoTipo(t)}"></i>
                                </button>
                            `).join('')}
                        </div>
                        <div class="widget-control" onclick="cambiarTamaño(this)">
                            <i class="fas fa-expand-alt"></i>
                        </div>
                        <div class="widget-control" onclick="eliminarWidget(this)">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    ${config.render(tipo, tamaño)}
                </div>
            </div>
        `;
        
        grid.insertAdjacentHTML('beforeend', widgetHTML);
    }

    function getIconoTipo(tipo) {
        const iconos = {
            'tabla': 'fa-table',
            'barra': 'fa-chart-bar',
            'linea': 'fa-chart-line',
            'pastel': 'fa-chart-pie',
            'kpi': 'fa-chart-simple',
            'lista': 'fa-list'
        };
        return iconos[tipo] || 'fa-chart-bar';
    }

    function cambiarTipoWidget(btn, widgetId, tipo) {
        const widget = btn.closest('.widget-item');
        const config = widgetsConfig[widgetId];
        const tamaño = widget.classList.value.match(/col-span-(\d+)/)[1];
        
        const btns = widget.querySelectorAll('.chart-type-btn');
        btns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        const contenido = widget.querySelector('.widget-content');
        contenido.innerHTML = config.render(tipo, tamaño);
    }

    function cambiarTamaño(btn) {
        const widget = btn.closest('.widget-item');
        const tamanios = ['3', '4', '5', '6', '7', '8', '9', '12'];
        const actual = widget.classList.value.match(/col-span-(\d+)/)[1];
        const index = tamanios.indexOf(actual);
        const nuevo = tamanios[(index + 1) % tamanios.length];
        
        widget.classList.remove(`col-span-${actual}`);
        widget.classList.add(`col-span-${nuevo}`);
        
        mostrarNotificacion(`Tamaño cambiado a ${nuevo}/12`);
    }

    function eliminarWidget(btn) {
        if (confirm('¿Eliminar este widget del dashboard?')) {
            btn.closest('.widget-item').remove();
            mostrarNotificacion('Widget eliminado');
        }
    }

    function guardarLayout() {
        const layout = [];
        document.querySelectorAll('.widget-item').forEach((widget, index) => {
            const tamaño = widget.classList.value.match(/col-span-(\d+)/)[1];
            layout.push({
                id: widget.dataset.widgetId,
                tamaño: tamaño,
                order: index
            });
        });
        
        localStorage.setItem('dashboardLayout', JSON.stringify(layout));
        mostrarNotificacion('Layout guardado');
    }

    function cargarConfiguracionGuardada() {
        const guardado = localStorage.getItem('dashboardLayout');
        const grid = document.getElementById('widgetGrid');
        
        if (guardado) {
            const layout = JSON.parse(guardado);
            layout.sort((a, b) => a.order - b.order).forEach(item => {
                const config = widgetsConfig[item.id];
                if (config) {
                    agregarWidget(item.id, config, item.tamaño, 'tabla');
                }
            });
        } else {
            agregarWidget('kpis-principales', widgetsConfig['kpis-principales'], '12', 'kpi');
            agregarWidget('estado-resultados', widgetsConfig['estado-resultados'], '7', 'tabla');
            agregarWidget('tipos-negocio', widgetsConfig['tipos-negocio'], '5', 'pastel');
            agregarWidget('cuentas-cobrar', widgetsConfig['cuentas-cobrar'], '3', 'tabla');
            agregarWidget('cuentas-pagar', widgetsConfig['cuentas-pagar'], '3', 'tabla');
            agregarWidget('ratios', widgetsConfig['ratios'], '3', 'kpi');
            agregarWidget('proyectos', widgetsConfig['proyectos'], '8', 'tabla');
            agregarWidget('alertas', widgetsConfig['alertas'], '4', 'lista');
        }
    }

    function resetearDashboard() {
        if (confirm('¿Resetear al layout original?')) {
            localStorage.removeItem('dashboardLayout');
            location.reload();
        }
    }

    // ========== FUNCIONES DE RENDERIZADO MEJORADAS ==========
    function renderKPIs(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ingresos</div>
                    <div class="legend-item"><span class="legend-color success"></span> EBITDA</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Backlog</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc" stroke-width="1"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc" stroke-width="1"/>
                        
                        <!-- Barras -->
                        <rect x="70" y="70" width="40" height="110" fill="#083CAE" rx="4"/>
                        <rect x="160" y="110" width="40" height="70" fill="#2e7d32" rx="4"/>
                        <rect x="250" y="40" width="40" height="140" fill="#b85e00" rx="4"/>
                        
                        <!-- Valores -->
                        <text x="75" y="60" fill="#083CAE" font-size="12" font-weight="bold">$18.5M</text>
                        <text x="165" y="100" fill="#2e7d32" font-size="12" font-weight="bold">$3.8M</text>
                        <text x="255" y="30" fill="#b85e00" font-size="12" font-weight="bold">$42.3M</text>
                        
                        <!-- Etiquetas -->
                        <text x="70" y="195" fill="#666" font-size="11">Ingresos</text>
                        <text x="160" y="195" fill="#666" font-size="11">EBITDA</text>
                        <text x="250" y="195" fill="#666" font-size="11">Backlog</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Ingresos Totales</div>
                    <div class="value">$18.5M</div>
                    <div class="trend positive"><i class="fas fa-arrow-up"></i> +15.3%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">EBITDA</div>
                    <div class="value">$3.8M</div>
                    <div class="trend positive"><i class="fas fa-arrow-up"></i> +18.2%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Margen EBITDA</div>
                    <div class="value">20.5%</div>
                    <div class="trend positive"><i class="fas fa-arrow-up"></i> +210bps</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Backlog</div>
                    <div class="value">$42.3M</div>
                    <div class="trend positive"><i class="fas fa-arrow-up"></i> +8.7%</div>
                </div>
            </div>
        `;
    }

    function renderEstadoResultados(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ingresos</div>
                    <div class="legend-item"><span class="legend-color success"></span> Utilidad Bruta</div>
                    <div class="legend-item"><span class="legend-color warning"></span> EBITDA</div>
                    <div class="legend-item"><span class="legend-color info"></span> Utilidad Neta</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc"/>
                        
                        <!-- Barras -->
                        <rect x="50" y="40" width="50" height="140" fill="#083CAE" rx="4"/>
                        <rect x="130" y="90" width="50" height="90" fill="#2e7d32" rx="4"/>
                        <rect x="210" y="110" width="50" height="70" fill="#b85e00" rx="4"/>
                        <rect x="290" y="140" width="50" height="40" fill="#006064" rx="4"/>
                        
                        <!-- Valores -->
                        <text x="55" y="30" fill="#083CAE" font-size="12" font-weight="bold">$18.5M</text>
                        <text x="135" y="80" fill="#2e7d32" font-size="12" font-weight="bold">$5.2M</text>
                        <text x="215" y="100" fill="#b85e00" font-size="12" font-weight="bold">$3.8M</text>
                        <text x="295" y="130" fill="#006064" font-size="12" font-weight="bold">$2.4M</text>
                        
                        <!-- Etiquetas -->
                        <text x="50" y="195" fill="#666" font-size="11">Ingresos</text>
                        <text x="130" y="195" fill="#666" font-size="11">U. Bruta</text>
                        <text x="210" y="195" fill="#666" font-size="11">EBITDA</text>
                        <text x="290" y="195" fill="#666" font-size="11">U. Neta</text>
                    </svg>
                </div>
            `;
        } else if (tipo === 'linea') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ingresos</div>
                    <div class="legend-item"><span class="legend-color success"></span> Costos</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Utilidad</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc"/>
                        
                        <!-- Líneas -->
                        <polyline points="60,60 120,70 180,50 240,65 300,40 340,30" 
                                  fill="none" stroke="#083CAE" stroke-width="3"/>
                        <polyline points="60,90 120,100 180,80 240,95 300,70 340,60" 
                                  fill="none" stroke="#2e7d32" stroke-width="3"/>
                        <polyline points="60,120 120,130 180,110 240,125 300,100 340,90" 
                                  fill="none" stroke="#b85e00" stroke-width="3"/>
                        
                        <!-- Puntos -->
                        <circle cx="60" cy="60" r="4" fill="#083CAE"/>
                        <circle cx="120" cy="70" r="4" fill="#083CAE"/>
                        <circle cx="180" cy="50" r="4" fill="#083CAE"/>
                        
                        <!-- Etiquetas -->
                        <text x="50" y="190" fill="#666" font-size="10">Ene</text>
                        <text x="110" y="190" fill="#666" font-size="10">Feb</text>
                        <text x="170" y="190" fill="#666" font-size="10">Mar</text>
                        <text x="230" y="190" fill="#666" font-size="10">Abr</text>
                        <text x="290" y="190" fill="#666" font-size="10">May</text>
                        <text x="330" y="190" fill="#666" font-size="10">Jun</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Ingresos Totales</strong></td>
                        <td class="positive">$18,500,000</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td>Costos Directos</td>
                        <td class="negative">-$13,300,000</td>
                        <td>71.9%</td>
                    </tr>
                    <tr>
                        <td><strong>Utilidad Bruta</strong></td>
                        <td class="positive">$5,200,000</td>
                        <td>28.1%</td>
                    </tr>
                    <tr>
                        <td>Gastos Operacionales</td>
                        <td class="negative">-$1,725,000</td>
                        <td>9.3%</td>
                    </tr>
                    <tr>
                        <td><strong>EBITDA</strong></td>
                        <td class="positive">$3,475,000</td>
                        <td>18.8%</td>
                    </tr>
                    <tr>
                        <td>Gastos Financieros</td>
                        <td class="negative">-$210,000</td>
                        <td>1.1%</td>
                    </tr>
                    <tr>
                        <td><strong>Utilidad Neta</strong></td>
                        <td class="positive">$2,416,300</td>
                        <td>13.1%</td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderTiposNegocio(tipo, tamaño) {
        if (tipo === 'pastel') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color" style="background:#083CAE"></span> Residencial 42%</div>
                    <div class="legend-item"><span class="legend-color" style="background:#2e7d32"></span> Obra Pública 28%</div>
                    <div class="legend-item"><span class="legend-color" style="background:#b85e00"></span> Industrial 20%</div>
                    <div class="legend-item"><span class="legend-color" style="background:#006064"></span> Infraestructura 10%</div>
                </div>
                <div class="chart-container" style="height: 200px;">
                    <svg width="100%" height="200" viewBox="0 0 250 200">
                        <g transform="translate(100,100)">
                            <!-- Segmentos del pastel -->
                            <path d="M0,0 L80,0 A80,80 0 0,1 23,77 Z" fill="#083CAE"/>
                            <path d="M0,0 L23,77 A80,80 0 0,1 -62,51 Z" fill="#2e7d32"/>
                            <path d="M0,0 L-62,51 A80,80 0 0,1 -51,-62 Z" fill="#b85e00"/>
                            <path d="M0,0 L-51,-62 A80,80 0 0,1 80,0 Z" fill="#006064"/>
                            
                            <!-- Centro blanco para efecto donut (opcional) -->
                            <circle cx="0" cy="0" r="30" fill="white"/>
                        </g>
                        
                        <!-- Etiquetas con valores -->
                        <text x="180" y="40" fill="#083CAE" font-size="12">$7.8M</text>
                        <text x="180" y="60" fill="#2e7d32" font-size="12">$5.2M</text>
                        <text x="180" y="80" fill="#b85e00" font-size="12">$3.7M</text>
                        <text x="180" y="100" fill="#006064" font-size="12">$1.8M</text>
                    </svg>
                </div>
            `;
        } else if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color" style="background:#083CAE"></span> Residencial</div>
                    <div class="legend-item"><span class="legend-color" style="background:#2e7d32"></span> Obra Pública</div>
                    <div class="legend-item"><span class="legend-color" style="background:#b85e00"></span> Industrial</div>
                    <div class="legend-item"><span class="legend-color" style="background:#006064"></span> Infraestructura</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc"/>
                        
                        <!-- Barras -->
                        <rect x="60" y="40" width="50" height="140" fill="#083CAE" rx="4"/>
                        <rect x="140" y="80" width="50" height="100" fill="#2e7d32" rx="4"/>
                        <rect x="220" y="100" width="50" height="80" fill="#b85e00" rx="4"/>
                        <rect x="300" y="140" width="50" height="40" fill="#006064" rx="4"/>
                        
                        <!-- Valores -->
                        <text x="70" y="30" fill="#083CAE" font-size="12" font-weight="bold">$7.8M</text>
                        <text x="150" y="70" fill="#2e7d32" font-size="12" font-weight="bold">$5.2M</text>
                        <text x="230" y="90" fill="#b85e00" font-size="12" font-weight="bold">$3.7M</text>
                        <text x="310" y="130" fill="#006064" font-size="12" font-weight="bold">$1.8M</text>
                        
                        <!-- Etiquetas -->
                        <text x="60" y="195" fill="#666" font-size="11">Resid.</text>
                        <text x="140" y="195" fill="#666" font-size="11">O.Pub</text>
                        <text x="220" y="195" fill="#666" font-size="11">Ind.</text>
                        <text x="300" y="195" fill="#666" font-size="11">Infra.</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Tipo de Negocio</th>
                        <th>Ingresos</th>
                        <th>Margen</th>
                        <th>Proyectos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Residencial</strong></td>
                        <td class="positive">$7,800,000</td>
                        <td class="positive">24.5%</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td><strong>Obra Pública</strong></td>
                        <td class="positive">$5,200,000</td>
                        <td class="positive">18.2%</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td><strong>Industrial</strong></td>
                        <td class="positive">$3,700,000</td>
                        <td class="positive">21.8%</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td><strong>Infraestructura</strong></td>
                        <td class="positive">$1,800,000</td>
                        <td class="positive">16.5%</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderCuentasCobrar(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div style="font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 15px;">$4,850,000</div>
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> 0-30 días</div>
                    <div class="legend-item"><span class="legend-color warning"></span> 31-60 días</div>
                    <div class="legend-item"><span class="legend-color" style="background:#b85e00"></span> 61-90 días</div>
                    <div class="legend-item"><span class="legend-color danger"></span> +90 días</div>
                </div>
                <div class="chart-container" style="height: 150px;">
                    <svg width="100%" height="150" viewBox="0 0 400 150">
                        <!-- Barras horizontales -->
                        <rect x="120" y="20" width="180" height="20" fill="#2e7d32" rx="4"/>
                        <text x="110" y="35" fill="#666" font-size="12">0-30:</text>
                        <text x="310" y="35" fill="#2e7d32" font-size="12" font-weight="bold">$2.18M</text>
                        
                        <rect x="120" y="50" width="104" height="20" fill="#b85e00" rx="4"/>
                        <text x="110" y="65" fill="#666" font-size="12">31-60:</text>
                        <text x="234" y="65" fill="#b85e00" font-size="12" font-weight="bold">$1.26M</text>
                        
                        <rect x="120" y="80" width="68" height="20" fill="#ff9800" rx="4"/>
                        <text x="110" y="95" fill="#666" font-size="12">61-90:</text>
                        <text x="198" y="95" fill="#ff9800" font-size="12" font-weight="bold">$820K</text>
                        
                        <rect x="120" y="110" width="48" height="20" fill="#b71c1c" rx="4"/>
                        <text x="110" y="125" fill="#666" font-size="12">+90:</text>
                        <text x="178" y="125" fill="#b71c1c" font-size="12" font-weight="bold">$590K</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div style="font-size: 24px; font-weight: 600; color: var(--primary); margin-bottom: 15px;">$4,850,000</div>
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Monto</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0-30 días</td>
                        <td class="positive">$2,180,000</td>
                        <td>45%</td>
                    </tr>
                    <tr>
                        <td>31-60 días</td>
                        <td class="warning">$1,260,000</td>
                        <td>26%</td>
                    </tr>
                    <tr>
                        <td>61-90 días</td>
                        <td class="warning">$820,000</td>
                        <td>17%</td>
                    </tr>
                    <tr>
                        <td>+90 días</td>
                        <td class="negative">$590,000</td>
                        <td>12%</td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderCuentasPagar(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div style="font-size: 22px; font-weight: 600; color: var(--danger); margin-bottom: 15px;">$3,210,000</div>
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> 0-30 días</div>
                    <div class="legend-item"><span class="legend-color warning"></span> 31-60 días</div>
                    <div class="legend-item"><span class="legend-color" style="background:#b85e00"></span> 61-90 días</div>
                    <div class="legend-item"><span class="legend-color danger"></span> +90 días</div>
                </div>
                <div class="chart-container" style="height: 150px;">
                    <svg width="100%" height="150" viewBox="0 0 400 150">
                        <!-- Barras horizontales -->
                        <rect x="120" y="20" width="116" height="20" fill="#2e7d32" rx="4"/>
                        <text x="110" y="35" fill="#666" font-size="12">0-30:</text>
                        <text x="246" y="35" fill="#2e7d32" font-size="12" font-weight="bold">$1.45M</text>
                        
                        <rect x="120" y="50" width="71" height="20" fill="#b85e00" rx="4"/>
                        <text x="110" y="65" fill="#666" font-size="12">31-60:</text>
                        <text x="201" y="65" fill="#b85e00" font-size="12" font-weight="bold">$890K</text>
                        
                        <rect x="120" y="80" width="42" height="20" fill="#ff9800" rx="4"/>
                        <text x="110" y="95" fill="#666" font-size="12">61-90:</text>
                        <text x="172" y="95" fill="#ff9800" font-size="12" font-weight="bold">$520K</text>
                        
                        <rect x="120" y="110" width="28" height="20" fill="#b71c1c" rx="4"/>
                        <text x="110" y="125" fill="#666" font-size="12">+90:</text>
                        <text x="158" y="125" fill="#b71c1c" font-size="12" font-weight="bold">$350K</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div style="font-size: 24px; font-weight: 600; color: var(--danger); margin-bottom: 15px;">$3,210,000</div>
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Monto</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0-30 días</td>
                        <td class="positive">$1,450,000</td>
                        <td>45%</td>
                    </tr>
                    <tr>
                        <td>31-60 días</td>
                        <td class="warning">$890,000</td>
                        <td>28%</td>
                    </tr>
                    <tr>
                        <td>61-90 días</td>
                        <td class="warning">$520,000</td>
                        <td>16%</td>
                    </tr>
                    <tr>
                        <td>+90 días</td>
                        <td class="negative">$350,000</td>
                        <td>11%</td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderRatios(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div class="chart-container" style="height: 200px;">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc"/>
                        
                        <!-- Barras -->
                        <rect x="60" y="40" width="40" height="140" fill="#083CAE" rx="4"/>
                        <rect x="130" y="70" width="40" height="110" fill="#2e7d32" rx="4"/>
                        <rect x="200" y="110" width="40" height="70" fill="#b85e00" rx="4"/>
                        <rect x="270" y="130" width="40" height="50" fill="#006064" rx="4"/>
                        
                        <!-- Valores -->
                        <text x="65" y="30" fill="#083CAE" font-size="12" font-weight="bold">2.1</text>
                        <text x="135" y="60" fill="#2e7d32" font-size="12" font-weight="bold">1.4</text>
                        <text x="205" y="100" fill="#b85e00" font-size="12" font-weight="bold">48%</text>
                        <text x="275" y="120" fill="#006064" font-size="12" font-weight="bold">18.5%</text>
                        
                        <!-- Etiquetas -->
                        <text x="50" y="195" fill="#666" font-size="11">Liquidez</text>
                        <text x="120" y="195" fill="#666" font-size="11">P.Ácida</text>
                        <text x="190" y="195" fill="#666" font-size="11">Endeud.</text>
                        <text x="260" y="195" fill="#666" font-size="11">ROE</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Ratio</th>
                        <th>Valor</th>
                        <th>Referencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Liquidez Corriente</strong></td>
                        <td class="positive">2.1</td>
                        <td>> 1.5</td>
                    </tr>
                    <tr>
                        <td><strong>Prueba Ácida</strong></td>
                        <td class="positive">1.4</td>
                        <td>> 1.0</td>
                    </tr>
                    <tr>
                        <td><strong>Endeudamiento</strong></td>
                        <td class="warning">48%</td>
                        <td>< 50%</td>
                    </tr>
                    <tr>
                        <td><strong>ROE</strong></td>
                        <td class="positive">18.5%</td>
                        <td>> 15%</td>
                    </tr>
                    <tr>
                        <td><strong>ROA</strong></td>
                        <td class="positive">9.2%</td>
                        <td>> 8%</td>
                    </tr>
                    <tr>
                        <td><strong>Cobertura Intereses</strong></td>
                        <td class="positive">5.8x</td>
                        <td>> 3x</td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderProyectos(tipo, tamaño) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> Margen</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="200" viewBox="0 0 400 200">
                        <!-- Ejes -->
                        <line x1="40" y1="180" x2="360" y2="180" stroke="#ccc"/>
                        <line x1="40" y1="20" x2="40" y2="180" stroke="#ccc"/>
                        
                        <!-- Barras de margen -->
                        <rect x="60" y="60" width="40" height="120" fill="#2e7d32" rx="4"/>
                        <rect x="130" y="100" width="40" height="80" fill="#2e7d32" rx="4"/>
                        <rect x="200" y="80" width="40" height="100" fill="#b85e00" rx="4"/>
                        <rect x="270" y="120" width="40" height="60" fill="#2e7d32" rx="4"/>
                        
                        <!-- Valores de margen -->
                        <text x="65" y="50" fill="#2e7d32" font-size="12" font-weight="bold">28.5%</text>
                        <text x="135" y="90" fill="#2e7d32" font-size="12" font-weight="bold">18.2%</text>
                        <text x="205" y="70" fill="#b85e00" font-size="12" font-weight="bold">22.5%</text>
                        <text x="275" y="110" fill="#2e7d32" font-size="12" font-weight="bold">16.5%</text>
                        
                        <!-- Etiquetas -->
                        <text x="50" y="195" fill="#666" font-size="10">Torre</text>
                        <text x="120" y="195" fill="#666" font-size="10">Puente</text>
                        <text x="190" y="195" fill="#666" font-size="10">Parque</text>
                        <text x="260" y="195" fill="#666" font-size="10">Hosp.</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Avance</th>
                        <th>Margen</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Torre Norte</strong></td>
                        <td>65%</td>
                        <td class="positive">28.5%</td>
                        <td><span class="badge badge-success">On track</span></td>
                    </tr>
                    <tr>
                        <td><strong>Puente Sur</strong></td>
                        <td>42%</td>
                        <td class="positive">18.2%</td>
                        <td><span class="badge badge-success">On track</span></td>
                    </tr>
                    <tr>
                        <td><strong>Parque Industrial</strong></td>
                        <td>78%</td>
                        <td class="warning">22.5%</td>
                        <td><span class="badge badge-warning">Atención</span></td>
                    </tr>
                    <tr>
                        <td><strong>Hospital Regional</strong></td>
                        <td>25%</td>
                        <td class="positive">16.5%</td>
                        <td><span class="badge badge-success">On track</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function renderAlertas(tipo, tamaño) {
        return `
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div class="alert-item warning">
                    <i class="fas fa-exclamation-triangle" style="font-size: 16px;"></i>
                    <div style="flex: 1;">
                        <strong>Parque Industrial</strong>
                        <div style="font-size: 12px; color: var(--gray-600);">Sobre costo en materiales (+8.5%)</div>
                    </div>
                </div>
                
                <div class="alert-item danger">
                    <i class="fas fa-clock" style="font-size: 16px;"></i>
                    <div style="flex: 1;">
                        <strong>Vencimientos próximos</strong>
                        <div style="font-size: 12px; color: var(--gray-600);">3 facturas por $540K vencen en 5 días</div>
                    </div>
                </div>
                
                <div class="alert-item info">
                    <i class="fas fa-chart-line" style="font-size: 16px;"></i>
                    <div style="flex: 1;">
                        <strong>Oportunidad</strong>
                        <div style="font-size: 12px; color: var(--gray-600);">Licitación obra pública por $8.5M</div>
                    </div>
                </div>
                
                <div class="alert-item success">
                    <i class="fas fa-check-circle" style="font-size: 16px;"></i>
                    <div style="flex: 1;">
                        <strong>Hito cumplido</strong>
                        <div style="font-size: 12px; color: var(--gray-600);">Torre Corporativa alcanza 65% de avance</div>
                    </div>
                </div>
                
                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border-color);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Próximos cobros (7 días)</span>
                        <span class="positive">$1,280,000</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Próximos pagos (7 días)</span>
                        <span class="negative">$890,000</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: 600;">
                        <span>Flujo neto</span>
                        <span class="positive">$390,000</span>
                    </div>
                </div>
            </div>
        `;
    }

    function mostrarNotificacion(mensaje) {
        const notificacion = document.createElement('div');
        notificacion.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 10001;
            animation: fadeIn 0.3s ease;
        `;
        notificacion.textContent = mensaje;
        
        document.body.appendChild(notificacion);
        
        setTimeout(() => {
            notificacion.remove();
        }, 3000);
    }
</script>
@endsection