@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <style>
        /* ========== VARIABLES ========== */
        :root {
            --primary: #083CAE;
            --primary-dark: #1a5bbf;
            --primary-light: #e8f0fe;
            --success: #28a745;
            --success-light: #d4edda;
            --warning: #ffc107;
            --warning-light: #fff3cd;
            --danger: #dc3545;
            --danger-light: #f8d7da;
            --info: #17a2b8;
            --info-light: #d1ecf1;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-800: #343a40;
        }

        /* ========== ANIMACIONES ========== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ========== ESTILOS DEL DASHBOARD ========== */
        .dashboard-container {
            animation: fadeIn 0.5s ease;
            padding: 20px;
        }

        /* Header con controles */
        .dashboard-header {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-800);
            margin: 0;
        }

        .header-title p {
            color: var(--gray-600);
            margin: 5px 0 0;
            font-size: 14px;
        }

        .header-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .control-btn {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .control-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .control-btn.primary {
            background: var(--primary);
            color: white;
            border: none;
        }

        .control-btn.primary:hover {
            background: var(--primary-dark);
        }

        /* Selector de período */
        .period-selector {
            display: flex;
            gap: 5px;
            background: var(--gray-100);
            padding: 5px;
            border-radius: 8px;
        }

        .period-option {
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .period-option.active {
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: var(--primary);
            font-weight: 600;
        }

        /* ========== WIDGET GRID CON RESIZE ========== */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .widget-item {
            min-height: 250px;
            transition: all 0.3s ease;
            position: relative;
            grid-column: span 1;
        }

        .widget-item[data-size="small"] { grid-column: span 1; }
        .widget-item[data-size="medium"] { grid-column: span 2; }
        .widget-item[data-size="large"] { grid-column: span 3; }
        .widget-item[data-size="xlarge"] { grid-column: span 4; }

        .widget-item.dragging {
            opacity: 0.8;
            transform: scale(0.98);
            cursor: grabbing;
        }

        .widget-item.drag-over {
            border: 2px dashed var(--primary);
        }

        /* ========== WIDGET CARD ========== */
        .widget-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            animation: slideIn 0.5s ease;
            border: 1px solid var(--gray-200);
            position: relative;
        }

        .widget-card.resizing {
            opacity: 0.7;
            pointer-events: none;
        }

        /* ========== ENCABEZADOS AZULES ========== */
        .widget-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: grab;
            background: var(--primary); /* Fondo azul */
            user-select: none;
        }

        .widget-header:active {
            cursor: grabbing;
        }

        .widget-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .widget-title i {
            color: white; /* Iconos en blanco */
            font-size: 18px;
        }

        .widget-title h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: white; /* Texto en blanco */
        }

        .widget-controls {
            display: flex;
            gap: 5px;
        }

        .widget-control {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: rgba(255,255,255,0.8); /* Iconos en blanco semitransparente */
            background: transparent;
            border: none;
        }

        .widget-control:hover {
            background: rgba(255,255,255,0.2); /* Efecto hover más claro */
            color: white;
        }

        /* Selector de tipo de gráfico en el header azul */
        .chart-type-selector {
            display: flex;
            gap: 2px;
            background: rgba(255,255,255,0.15);
            padding: 2px;
            border-radius: 4px;
            margin-right: 5px;
        }

        .chart-type-btn {
            width: 28px;
            height: 28px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.8);
            font-size: 14px;
        }

        .chart-type-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .chart-type-btn.active {
            background: white;
            color: var(--primary);
        }

        /* Resize handle */
        .resize-handle {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 20px;
            height: 20px;
            cursor: se-resize;
            background: linear-gradient(135deg, transparent 50%, var(--gray-400) 50%);
            border-bottom-right-radius: 16px;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .resize-handle:hover {
            opacity: 1;
        }

        .widget-content {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
            font-size: 14px;
        }

        /* ========== KPI CARDS ========== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .kpi-card {
            background: var(--gray-100);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }

        .kpi-card .label {
            font-size: 12px;
            color: var(--gray-600);
            margin-bottom: 5px;
        }

        .kpi-card .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .kpi-card .comparison {
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-top: 5px;
        }

        .comparison.positive { color: var(--success); }
        .comparison.negative { color: var(--danger); }

        /* ========== GRÁFICOS MEJORADOS ========== */
        .chart-container {
            width: 100%;
            height: 220px;
            position: relative;
            margin-top: 10px;
        }

        .chart-legend {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin: 15px 0;
            padding: 10px;
            background: var(--gray-100);
            border-radius: 8px;
            justify-content: center;
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

        /* Barras para gráficos */
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

        /* ========== TABLAS MEJORADAS ========== */
        .finance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .finance-table th {
            text-align: left;
            padding: 12px 10px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            border-bottom: 2px solid var(--primary);
        }

        .finance-table td {
            padding: 10px;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-800);
        }

        .finance-table tr:hover td {
            background: var(--primary-light);
        }

        .finance-table .positive { color: var(--success); font-weight: 500; }
        .finance-table .negative { color: var(--danger); font-weight: 500; }
        .finance-table .warning { color: var(--warning); font-weight: 500; }

        /* ========== PROGRESS BARS ========== */
        .progress-bar-container {
            margin: 15px 0;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 5px;
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

        /* ========== BADGES ========== */
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-success { background: var(--success-light); color: #155724; }
        .badge-warning { background: var(--warning-light); color: #856404; }
        .badge-danger { background: var(--danger-light); color: #721c24; }
        .badge-info { background: var(--info-light); color: #0c5460; }
        .badge-primary { background: var(--primary-light); color: var(--primary); }

        /* ========== SELECTOR DE WIDGETS ========== */
        .widget-selector-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .widget-selector-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .widget-selector-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: var(--primary); /* Header del modal también en azul */
            color: white;
            z-index: 10;
        }

        .widget-selector-header h2 {
            font-size: 20px;
            margin: 0;
            color: white;
        }

        .widget-selector-header .widget-control {
            color: white;
        }

        .widget-selector-header .widget-control:hover {
            background: rgba(255,255,255,0.2);
        }

        .widget-category {
            margin: 20px 0 10px;
            padding: 0 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .widget-list {
            padding: 0 20px 20px;
        }

        .widget-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .widget-option:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .widget-option input[type="checkbox"] {
            margin-right: 15px;
            width: 18px;
            height: 18px;
        }

        .widget-option-info {
            flex: 1;
        }

        .widget-option-info h4 {
            margin: 0 0 5px;
            font-size: 16px;
        }

        .widget-option-info p {
            margin: 0;
            font-size: 12px;
            color: var(--gray-600);
        }

        /* Modal footer */
        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--gray-200);
            text-align: right;
            position: sticky;
            bottom: 0;
            background: white;
        }

        .apply-btn {
            padding: 12px 30px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .apply-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(35,120,225,0.3);
        }

        /* Alertas */
        .alert-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 10px;
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

        /* Responsive */
        @media (max-width: 1200px) {
            .widget-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .widget-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .widget-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Header del Dashboard -->
    <div class="dashboard-header">
        <div class="header-title">
            <h1>Dashboard</h1>
            <p>
                <i class="fas fa-user"></i> 
                Hola, {{ Auth::user()->name }} · 
                <span id="fechaActual"></span>
            </p>
        </div>
        
        <div class="header-controls">
            <div class="period-selector">
                <div class="period-option active" onclick="cambiarPeriodo(this, 'dia')">Día</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'semana')">Semana</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'mes')">Mes</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'trimestre')">Trimestre</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'año')">Año</div>
            </div>
            
            <div class="control-btn" onclick="abrirSelectorWidgets()">
                <i class="fas fa-plus"></i>
                <span>Agregar Widget</span>
            </div>
            
            <div class="control-btn" onclick="guardarConfiguracion()">
                <i class="fas fa-save"></i>
                <span>Guardar Vista</span>
            </div>
            
            <div class="control-btn" onclick="resetearDashboard()">
                <i class="fas fa-undo"></i>
                <span>Resetear</span>
            </div>
            
            <div class="control-btn primary" onclick="exportarDashboard()">
                <i class="fas fa-download"></i>
                <span>Exportar</span>
            </div>
        </div>
    </div>

    <!-- Grid de Widgets -->
    <div class="widget-grid" id="widgetGrid"></div>

    <!-- Modal Selector de Widgets -->
    <div class="widget-selector-modal" id="widgetSelectorModal" onclick="cerrarSelectorWidgets(event)">
        <div class="widget-selector-content">
            <div class="widget-selector-header">
                <h2><i class="fas fa-edit"></i> Personalizar Dashboard</h2>
                <div class="widget-control" onclick="cerrarSelectorWidgets(event)" style="width: 40px; height: 40px;">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            
            <div class="widget-category">📊 VENTAS</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="ventas-tendencia">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Tendencia de Ventas</h4>
                        <p>Ventas diarias, presupuesto y alcance</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="ventas-proyecto">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Ventas por Proyecto</h4>
                        <p>Distribución de ventas por proyecto activo</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="facturacion-diaria">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Facturación por Día</h4>
                        <p>Facturación diaria y rentabilidad</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">💰 FINANZAS</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="cuentas-pagar">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Cuentas por Pagar</h4>
                        <p>Antigüedad de cuentas por pagar</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="cuentas-cobrar">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Cuentas por Cobrar</h4>
                        <p>Antigüedad de cuentas por cobrar</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="rentabilidad">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Rentabilidad</h4>
                        <p>Márgenes y rentabilidad por proyecto</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="estado-resultados">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Estado de Resultados</h4>
                        <p>P&L completo con márgenes</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">👷 NÓMINA</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="nomina-resumen">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Resumen de Nómina</h4>
                        <p>Total empleados, costo mensual y distribución</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="nomina-proyectos">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Costo de Nómina por Proyecto</h4>
                        <p>Distribución de nómina en proyectos</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">🚜 MAQUINARIA</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="maquinaria-estado">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Estado de Flota</h4>
                        <p>Disponibilidad y estatus de equipos</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="maquinaria-costos">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Costos de Maquinaria</h4>
                        <p>Costos operativos y mantenimiento</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="apply-btn" onclick="aplicarCambiosWidgets()">
                    <i class="fas fa-check"></i> Aplicar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Configuración de widgets disponibles con múltiples tipos de visualización
    const widgetsConfig = {
        'ventas-tendencia': {
            titulo: 'Tendencia de Ventas',
            icono: 'fa-chart-line',
            categoria: 'ventas',
            tamanios: ['small', 'medium', 'large'],
            tipos: ['kpi', 'barra', 'linea'],
            contenido: (tipo) => generarVentasTendencia(tipo)
        },
        'ventas-proyecto': {
            titulo: 'Ventas por Proyecto',
            icono: 'fa-chart-pie',
            categoria: 'ventas',
            tamanios: ['small', 'medium', 'large'],
            tipos: ['tabla', 'barra', 'pastel'],
            contenido: (tipo) => generarVentasProyecto(tipo)
        },
        'facturacion-diaria': {
            titulo: 'Facturación por Día',
            icono: 'fa-calendar-alt',
            categoria: 'ventas',
            tamanios: ['small', 'medium', 'large'],
            tipos: ['kpi', 'barra', 'linea'],
            contenido: (tipo) => generarFacturacionDiaria(tipo)
        },
        'cuentas-pagar': {
            titulo: 'Cuentas por Pagar',
            icono: 'fa-arrow-up',
            categoria: 'finanzas',
            tamanios: ['small', 'medium'],
            tipos: ['tabla', 'barra', 'pastel'],
            contenido: (tipo) => generarCuentasPagar(tipo)
        },
        'cuentas-cobrar': {
            titulo: 'Cuentas por Cobrar',
            icono: 'fa-arrow-down',
            categoria: 'finanzas',
            tamanios: ['small', 'medium'],
            tipos: ['tabla', 'barra', 'pastel'],
            contenido: (tipo) => generarCuentasCobrar(tipo)
        },
        'rentabilidad': {
            titulo: 'Rentabilidad',
            icono: 'fa-chart-simple',
            categoria: 'finanzas',
            tamanios: ['small', 'medium', 'large'],
            tipos: ['tabla', 'barra', 'kpi'],
            contenido: (tipo) => generarRentabilidad(tipo)
        },
        'estado-resultados': {
            titulo: 'Estado de Resultados',
            icono: 'fa-file-invoice',
            categoria: 'finanzas',
            tamanios: ['medium', 'large', 'xlarge'],
            tipos: ['tabla', 'barra', 'linea'],
            contenido: (tipo) => generarEstadoResultados(tipo)
        },
        'nomina-resumen': {
            titulo: 'Resumen de Nómina',
            icono: 'fa-users',
            categoria: 'nomina',
            tamanios: ['small', 'medium'],
            tipos: ['kpi', 'tabla', 'barra'],
            contenido: (tipo) => generarNominaResumen(tipo)
        },
        'nomina-proyectos': {
            titulo: 'Nómina por Proyecto',
            icono: 'fa-hard-hat',
            categoria: 'nomina',
            tamanios: ['small', 'medium', 'large'],
            tipos: ['tabla', 'barra'],
            contenido: (tipo) => generarNominaProyectos(tipo)
        },
        'maquinaria-estado': {
            titulo: 'Estado de Maquinaria',
            icono: 'fa-tractor',
            categoria: 'maquinaria',
            tamanios: ['small', 'medium'],
            tipos: ['kpi', 'tabla', 'barra'],
            contenido: (tipo) => generarMaquinariaEstado(tipo)
        },
        'maquinaria-costos': {
            titulo: 'Costos de Maquinaria',
            icono: 'fa-tools',
            categoria: 'maquinaria',
            tamanios: ['small', 'medium'],
            tipos: ['kpi', 'barra', 'tabla'],
            contenido: (tipo) => generarMaquinariaCostos(tipo)
        }
    };

    let draggingItem = null;

    document.addEventListener('DOMContentLoaded', function() {
        actualizarFecha();
        cargarConfiguracion();
        inicializarDragAndDrop();
        inicializarResize();
    });

    function actualizarFecha() {
        const fecha = new Date();
        document.getElementById('fechaActual').textContent = 
            fecha.toLocaleDateString('es-MX', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
    }

    function cambiarPeriodo(elemento, periodo) {
        document.querySelectorAll('.period-option').forEach(el => {
            el.classList.remove('active');
        });
        elemento.classList.add('active');
        
        actualizarDatosWidgets(periodo);
    }

    function actualizarDatosWidgets(periodo) {
        const widgets = document.querySelectorAll('.widget-card');
        widgets.forEach(widget => {
            widget.style.opacity = '0.5';
        });
        
        setTimeout(() => {
            widgets.forEach(widget => {
                widget.style.opacity = '1';
            });
            mostrarNotificacion(`Datos actualizados para período: ${periodo}`, 'success');
        }, 500);
    }

    function abrirSelectorWidgets() {
        document.getElementById('widgetSelectorModal').style.display = 'flex';
        cargarEstadoCheckboxes();
    }

    function cerrarSelectorWidgets(event) {
        if (event.target === document.getElementById('widgetSelectorModal') || 
            event.target.closest('.widget-control')) {
            document.getElementById('widgetSelectorModal').style.display = 'none';
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

    function aplicarCambiosWidgets() {
        const grid = document.getElementById('widgetGrid');
        const seleccionados = [];
        
        document.querySelectorAll('.widget-option').forEach(option => {
            const checkbox = option.querySelector('.widget-checkbox');
            if (checkbox.checked) {
                const widgetId = option.dataset.widget;
                seleccionados.push(widgetId);
            }
        });

        grid.innerHTML = '';

        seleccionados.forEach(widgetId => {
            agregarWidget(widgetId, 'medium', 'tabla');
        });

        document.getElementById('widgetSelectorModal').style.display = 'none';
        guardarConfiguracion();
        mostrarNotificacion('Dashboard actualizado correctamente', 'success');
    }

    function agregarWidget(widgetId, size = 'medium', tipo = null) {
        const config = widgetsConfig[widgetId];
        if (!config) return;
        
        const grid = document.getElementById('widgetGrid');
        const widgetHTML = `
            <div class="widget-item" data-widget-id="${widgetId}" data-size="${size}" data-tipo="${tipo || config.tipos[0]}">
                <div class="widget-card">
                    <div class="widget-header" draggable="true">
                        <div class="widget-title">
                            <i class="fas ${config.icono}"></i>
                            <h3>${config.titulo}</h3>
                        </div>
                        <div style="display: flex; gap: 5px;">
                            <div class="chart-type-selector">
                                ${generarSelectorTipos(widgetId, config.tipos, tipo)}
                            </div>
                            <div class="widget-control" onclick="configurarWidget(this)">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="widget-control" onclick="eliminarWidget(this)">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">
                        ${config.contenido(tipo || config.tipos[0])}
                    </div>
                    <div class="resize-handle" onmousedown="iniciarResize(event, this)"></div>
                </div>
            </div>
        `;
        
        grid.insertAdjacentHTML('beforeend', widgetHTML);
    }

    function generarSelectorTipos(widgetId, tipos, tipoActual) {
        const iconos = {
            'kpi': 'fa-chart-simple',
            'tabla': 'fa-table',
            'barra': 'fa-chart-bar',
            'linea': 'fa-chart-line',
            'pastel': 'fa-chart-pie'
        };
        
        return tipos.map(tipo => `
            <button class="chart-type-btn ${tipo === tipoActual ? 'active' : ''}" 
                    onclick="cambiarTipoWidget(this, '${widgetId}', '${tipo}')">
                <i class="fas ${iconos[tipo]}"></i>
            </button>
        `).join('');
    }

    function cambiarTipoWidget(btn, widgetId, tipo) {
        const widget = btn.closest('.widget-item');
        const config = widgetsConfig[widgetId];
        
        if (widget) {
            widget.dataset.tipo = tipo;
            
            const btns = widget.querySelectorAll('.chart-type-btn');
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const contenido = widget.querySelector('.widget-content');
            contenido.innerHTML = config.contenido(tipo);
        }
    }

    function eliminarWidget(elemento) {
        const widget = elemento.closest('.widget-item');
        if (confirm('¿Eliminar este widget del dashboard?')) {
            widget.remove();
            guardarConfiguracion();
            mostrarNotificacion('Widget eliminado', 'info');
        }
    }

    function configurarWidget(elemento) {
        mostrarNotificacion('Configuración del widget - En desarrollo', 'info');
    }

    function guardarConfiguracion() {
        const config = [];
        document.querySelectorAll('.widget-item').forEach((w, index) => {
            config.push({
                id: w.dataset.widgetId,
                size: w.dataset.size,
                tipo: w.dataset.tipo,
                order: index
            });
        });
        
        localStorage.setItem('dashboardConfig', JSON.stringify(config));
        mostrarNotificacion('Configuración guardada', 'success');
    }

    function cargarConfiguracion() {
        const configGuardada = localStorage.getItem('dashboardConfig');
        const grid = document.getElementById('widgetGrid');
        grid.innerHTML = '';
        
        if (configGuardada) {
            const config = JSON.parse(configGuardada);
            config.sort((a, b) => a.order - b.order).forEach(item => {
                agregarWidget(item.id, item.size, item.tipo);
            });
        } else {
            // Widgets por defecto
            agregarWidget('ventas-tendencia', 'medium', 'kpi');
            agregarWidget('cuentas-pagar', 'small', 'tabla');
            agregarWidget('cuentas-cobrar', 'small', 'tabla');
            agregarWidget('ventas-proyecto', 'medium', 'pastel');
            agregarWidget('nomina-resumen', 'small', 'kpi');
            agregarWidget('maquinaria-estado', 'small', 'kpi');
            agregarWidget('estado-resultados', 'large', 'tabla');
        }
    }

    function resetearDashboard() {
        if (confirm('¿Resetear el dashboard a su estado original?')) {
            localStorage.removeItem('dashboardConfig');
            cargarConfiguracion();
            mostrarNotificacion('Dashboard restaurado', 'success');
        }
    }

    function exportarDashboard() {
        mostrarNotificacion('Exportando dashboard...', 'info');
        setTimeout(() => {
            mostrarNotificacion('Exportación completada', 'success');
        }, 1500);
    }

    function mostrarNotificacion(mensaje, tipo) {
        const notificacion = document.createElement('div');
        notificacion.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: ${tipo === 'success' ? 'var(--success)' : tipo === 'error' ? 'var(--danger)' : 'var(--info)'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 10001;
            animation: slideIn 0.3s ease;
            font-size: 14px;
        `;
        notificacion.textContent = mensaje;
        
        document.body.appendChild(notificacion);
        
        setTimeout(() => {
            notificacion.remove();
        }, 3000);
    }

    // Funciones de Drag & Drop
    function inicializarDragAndDrop() {
        const grid = document.getElementById('widgetGrid');
        
        grid.addEventListener('dragstart', (e) => {
            const header = e.target.closest('.widget-header');
            if (header) {
                draggingItem = header.closest('.widget-item');
                draggingItem.classList.add('dragging');
                e.dataTransfer.setData('text/plain', '');
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
            const afterElement = getDragAfterElement(grid, e.clientY);
            const currentElement = e.target.closest('.widget-item');
            
            if (currentElement && draggingItem && currentElement !== draggingItem) {
                currentElement.classList.add('drag-over');
            }
        });

        grid.addEventListener('dragleave', (e) => {
            const element = e.target.closest('.widget-item');
            if (element) {
                element.classList.remove('drag-over');
            }
        });

        grid.addEventListener('drop', (e) => {
            e.preventDefault();
            
            const target = e.target.closest('.widget-item');
            if (target && draggingItem && target !== draggingItem) {
                const grid = document.getElementById('widgetGrid');
                const items = [...grid.querySelectorAll('.widget-item')];
                const dragIndex = items.indexOf(draggingItem);
                const dropIndex = items.indexOf(target);
                
                if (dragIndex < dropIndex) {
                    target.insertAdjacentElement('afterend', draggingItem);
                } else {
                    target.insertAdjacentElement('beforebegin', draggingItem);
                }
                
                guardarConfiguracion();
            }
            
            document.querySelectorAll('.widget-item').forEach(item => {
                item.classList.remove('drag-over');
            });
        });
    }

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.widget-item:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    // Funciones de Resize
    function inicializarResize() {
        // No necesita inicialización adicional
    }

    function iniciarResize(event, handle) {
        event.preventDefault();
        
        const widget = handle.closest('.widget-item');
        const startX = event.clientX;
        const startSize = widget.dataset.size || 'medium';
        
        const tamaños = ['small', 'medium', 'large', 'xlarge'];
        let startIndex = tamaños.indexOf(startSize);
        
        function resize(e) {
            const diff = e.clientX - startX;
            const sizeChange = Math.floor(diff / 100);
            
            let newIndex = Math.min(Math.max(startIndex + sizeChange, 0), tamaños.length - 1);
            let newSize = tamaños[newIndex];
            
            if (newSize !== widget.dataset.size) {
                widget.dataset.size = newSize;
            }
        }
        
        function stopResize() {
            document.removeEventListener('mousemove', resize);
            document.removeEventListener('mouseup', stopResize);
            guardarConfiguracion();
            mostrarNotificacion(`Tamaño cambiado a ${widget.dataset.size}`, 'info');
        }
        
        document.addEventListener('mousemove', resize);
        document.addEventListener('mouseup', stopResize);
    }

    // ========== FUNCIONES DE RENDERIZADO ==========
    function generarVentasTendencia(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ventas</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Presupuesto</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="180" viewBox="0 0 400 180">
                        <line x1="40" y1="150" x2="360" y2="150" stroke="#ccc"/>
                        <rect x="60" y="70" width="40" height="80" fill="var(--primary)" rx="4"/>
                        <rect x="120" y="90" width="40" height="60" fill="var(--primary)" rx="4"/>
                        <rect x="180" y="50" width="40" height="100" fill="var(--primary)" rx="4"/>
                        <rect x="240" y="30" width="40" height="120" fill="var(--primary)" rx="4"/>
                        <rect x="300" y="70" width="40" height="80" fill="var(--primary)" rx="4"/>
                        
                        <rect x="60" y="50" width="40" height="100" fill="var(--warning)" rx="4" opacity="0.5"/>
                        <rect x="120" y="70" width="40" height="80" fill="var(--warning)" rx="4" opacity="0.5"/>
                        <rect x="180" y="30" width="40" height="120" fill="var(--warning)" rx="4" opacity="0.5"/>
                        <rect x="240" y="10" width="40" height="140" fill="var(--warning)" rx="4" opacity="0.5"/>
                        <rect x="300" y="50" width="40" height="100" fill="var(--warning)" rx="4" opacity="0.5"/>
                        
                        <text x="65" y="160" font-size="10">L</text>
                        <text x="125" y="160" font-size="10">M</text>
                        <text x="185" y="160" font-size="10">M</text>
                        <text x="245" y="160" font-size="10">J</text>
                        <text x="305" y="160" font-size="10">V</text>
                    </svg>
                </div>
                <div class="kpi-grid" style="margin-top: 10px;">
                    <div class="kpi-card"><div class="label">Venta hoy</div><div class="value">$48K</div></div>
                    <div class="kpi-card"><div class="label">Alcance</div><div class="value">100%</div></div>
                </div>
            `;
        } else if (tipo === 'linea') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ventas</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Presupuesto</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="180" viewBox="0 0 400 180">
                        <line x1="40" y1="150" x2="360" y2="150" stroke="#ccc"/>
                        <polyline points="60,100 120,80 180,60 240,40 300,70 340,50" 
                                  fill="none" stroke="var(--primary)" stroke-width="3"/>
                        <polyline points="60,90 120,70 180,50 240,30 300,60 340,40" 
                                  fill="none" stroke="var(--warning)" stroke-width="3" stroke-dasharray="5,5"/>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Venta al día</div>
                    <div class="value">$48,000</div>
                    <div class="comparison positive"><i class="fas fa-arrow-up"></i> +15%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Presupuesto</div>
                    <div class="value">$48,000</div>
                    <div class="comparison">0%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Diferencia</div>
                    <div class="value">$48,000</div>
                    <div class="comparison positive">100%</div>
                </div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-header"><span>Alcance</span><span>100%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:100%"></div></div>
            </div>
        `;
    }

    function generarVentasProyecto(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Torre Norte</div>
                    <div class="legend-item"><span class="legend-color success"></span> Puente Sur</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Parque Ind</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="180" viewBox="0 0 400 180">
                        <line x1="40" y1="150" x2="360" y2="150" stroke="#ccc"/>
                        <rect x="70" y="50" width="50" height="100" fill="var(--primary)" rx="4"/>
                        <rect x="160" y="80" width="50" height="70" fill="var(--success)" rx="4"/>
                        <rect x="250" y="90" width="50" height="60" fill="var(--warning)" rx="4"/>
                        
                        <text x="80" y="40" font-size="11" fill="var(--primary)">$180K</text>
                        <text x="170" y="70" font-size="11" fill="var(--success)">$120K</text>
                        <text x="260" y="80" font-size="11" fill="var(--warning)">$90K</text>
                    </svg>
                </div>
            `;
        } else if (tipo === 'pastel') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Torre Norte 37.5%</div>
                    <div class="legend-item"><span class="legend-color success"></span> Puente Sur 25%</div>
                    <div class="legend-item"><span class="legend-color warning"></span> Parque Ind 18.8%</div>
                    <div class="legend-item"><span class="legend-color info"></span> Hospital 18.8%</div>
                </div>
                <div class="chart-container" style="height: 160px;">
                    <svg width="100%" height="160" viewBox="0 0 200 160">
                        <g transform="translate(80,80)">
                            <path d="M0,0 L60,0 A60,60 0 0,1 18,57 Z" fill="var(--primary)"/>
                            <path d="M0,0 L18,57 A60,60 0 0,1 -47,37 Z" fill="var(--success)"/>
                            <path d="M0,0 L-47,37 A60,60 0 0,1 -38,-46 Z" fill="var(--warning)"/>
                            <path d="M0,0 L-38,-46 A60,60 0 0,1 60,0 Z" fill="var(--info)"/>
                            <circle cx="0" cy="0" r="25" fill="white"/>
                        </g>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead><tr><th>Proyecto</th><th>Ventas</th><th>%</th></tr></thead>
                <tbody>
                    <tr><td>Torre Norte</td><td class="positive">$180,000</td><td>37.5%</td></tr>
                    <tr><td>Puente Sur</td><td class="positive">$120,000</td><td>25.0%</td></tr>
                    <tr><td>Parque Industrial</td><td class="positive">$90,000</td><td>18.8%</td></tr>
                    <tr><td>Hospital Regional</td><td class="positive">$90,000</td><td>18.8%</td></tr>
                </tbody>
            </table>
        `;
    }

    function generarFacturacionDiaria(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="kpi-grid" style="margin-bottom: 15px;">
                    <div class="kpi-card"><div class="label">Hoy</div><div class="value">$48K</div></div>
                    <div class="kpi-card"><div class="label">Rentab.</div><div class="value">32.5%</div></div>
                </div>
                <div class="chart-container" style="height: 150px;">
                    <svg width="100%" height="150" viewBox="0 0 300 150">
                        <line x1="30" y1="120" x2="270" y2="120" stroke="#ccc"/>
                        <rect x="40" y="70" width="30" height="50" fill="var(--primary)" rx="4"/>
                        <rect x="90" y="40" width="30" height="80" fill="var(--primary)" rx="4"/>
                        <rect x="140" y="10" width="30" height="110" fill="var(--primary)" rx="4"/>
                        <rect x="190" y="30" width="30" height="90" fill="var(--primary)" rx="4"/>
                        <rect x="240" y="50" width="30" height="70" fill="var(--primary)" rx="4"/>
                        
                        <text x="45" y="135" font-size="10">L</text>
                        <text x="95" y="135" font-size="10">M</text>
                        <text x="145" y="135" font-size="10">M</text>
                        <text x="195" y="135" font-size="10">J</text>
                        <text x="245" y="135" font-size="10">V</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card"><div class="label">Facturación Hoy</div><div class="value">$48,000</div></div>
                <div class="kpi-card"><div class="label">Rentabilidad</div><div class="value">32.5%</div></div>
                <div class="kpi-card"><div class="label">Semana</div><div class="value">$245K</div></div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-header"><span>Progreso semanal</span><span>68%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:68%"></div></div>
            </div>
        `;
    }

    function generarCuentasPagar(tipo) {
        if (tipo === 'barra') {
            return `
                <div style="font-size: 22px; font-weight: 600; color: var(--danger); margin-bottom: 15px;">$1,123,904</div>
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> 0-30</div>
                    <div class="legend-item"><span class="legend-color warning"></span> 31-60</div>
                    <div class="legend-item"><span class="legend-color danger"></span> +60</div>
                </div>
                <div class="chart-container" style="height: 120px;">
                    <svg width="100%" height="120" viewBox="0 0 400 120">
                        <rect x="120" y="20" width="40" height="20" fill="var(--success)" rx="4"/>
                        <text x="50" y="35" font-size="12">0-30:</text>
                        <text x="170" y="35" class="positive">$49.9K</text>
                        
                        <rect x="120" y="50" width="26" height="20" fill="var(--warning)" rx="4"/>
                        <text x="50" y="65" font-size="12">31-60:</text>
                        <text x="156" y="65" class="warning">$31.8K</text>
                        
                        <rect x="120" y="80" width="85" height="20" fill="var(--danger)" rx="4"/>
                        <text x="50" y="95" font-size="12">+60:</text>
                        <text x="215" y="95" class="negative">$1,042K</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div style="font-size: 24px; font-weight: 600; color: var(--danger); margin-bottom: 15px;">$1,123,904</div>
            <table class="finance-table">
                <tr><td>Al corriente</td><td class="positive">$0</td><td>0%</td></tr>
                <tr><td>1-30 días</td><td class="warning">$49,880</td><td>4.4%</td></tr>
                <tr><td>31-60 días</td><td class="warning">$31,807</td><td>2.8%</td></tr>
                <tr><td>61-90 días</td><td class="warning">$14,500</td><td>1.3%</td></tr>
                <tr><td>+90 días</td><td class="negative">$1,027,717</td><td>91.5%</td></tr>
            </table>
        `;
    }

    function generarCuentasCobrar(tipo) {
        if (tipo === 'barra') {
            return `
                <div style="font-size: 22px; font-weight: 600; color: var(--success); margin-bottom: 15px;">$508,630</div>
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> Al corriente</div>
                    <div class="legend-item"><span class="legend-color danger"></span> +120 días</div>
                </div>
                <div class="chart-container" style="height: 120px;">
                    <svg width="100%" height="120" viewBox="0 0 400 120">
                        <rect x="120" y="20" width="90" height="20" fill="var(--success)" rx="4"/>
                        <text x="50" y="35" font-size="12">Al corriente:</text>
                        <text x="220" y="35" class="positive">$110K</text>
                        
                        <rect x="120" y="50" width="78" height="20" fill="var(--danger)" rx="4"/>
                        <text x="50" y="65" font-size="12">+120 días:</text>
                        <text x="208" y="65" class="negative">$398K</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div style="font-size: 24px; font-weight: 600; color: var(--success); margin-bottom: 15px;">$508,630</div>
            <table class="finance-table">
                <tr><td>Al corriente</td><td class="positive">$110,064</td><td>21.6%</td></tr>
                <tr><td>1-30 días</td><td>$0</td><td>0%</td></tr>
                <tr><td>31-60 días</td><td>$0</td><td>0%</td></tr>
                <tr><td>61-90 días</td><td>$0</td><td>0%</td></tr>
                <tr><td>90-120 días</td><td>$0</td><td>0%</td></tr>
                <tr><td>+120 días</td><td class="negative">$398,566</td><td>78.4%</td></tr>
            </table>
        `;
    }

    function generarRentabilidad(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> Margen</div>
                </div>
                <div class="chart-container" style="height: 150px;">
                    <svg width="100%" height="150" viewBox="0 0 400 150">
                        <line x1="40" y1="120" x2="360" y2="120" stroke="#ccc"/>
                        <rect x="70" y="40" width="50" height="80" fill="var(--success)" rx="4"/>
                        <rect x="160" y="40" width="50" height="80" fill="var(--success)" rx="4"/>
                        <rect x="250" y="70" width="50" height="50" fill="var(--warning)" rx="4"/>
                        
                        <text x="80" y="30" font-size="11" fill="var(--success)">30%</text>
                        <text x="170" y="30" font-size="11" fill="var(--success)">30%</text>
                        <text x="260" y="60" font-size="11" fill="var(--warning)">20%</text>
                        
                        <text x="70" y="135" font-size="10">Torre</text>
                        <text x="160" y="135" font-size="10">Puente</text>
                        <text x="250" y="135" font-size="10">Parque</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid" style="margin-bottom: 15px;">
                <div class="kpi-card"><div class="label">Margen Promedio</div><div class="value">28.5%</div></div>
                <div class="kpi-card"><div class="label">Utilidad Neta</div><div class="value">$845K</div></div>
            </div>
            <table class="finance-table">
                <thead><tr><th>Proyecto</th><th>Ingresos</th><th>Margen</th></tr></thead>
                <tbody>
                    <tr><td>Torre Norte</td><td>$850K</td><td class="positive">30%</td></tr>
                    <tr><td>Puente Sur</td><td>$620K</td><td class="positive">30%</td></tr>
                    <tr><td>Parque Ind</td><td>$410K</td><td class="warning">20%</td></tr>
                </tbody>
            </table>
        `;
    }

    function generarEstadoResultados(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Ingresos</div>
                    <div class="legend-item"><span class="legend-color success"></span> EBITDA</div>
                    <div class="legend-item"><span class="legend-color info"></span> Utilidad Neta</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="180" viewBox="0 0 400 180">
                        <line x1="40" y1="150" x2="360" y2="150" stroke="#ccc"/>
                        <rect x="70" y="20" width="60" height="130" fill="var(--primary)" rx="4"/>
                        <rect x="170" y="80" width="60" height="70" fill="var(--success)" rx="4"/>
                        <rect x="270" y="100" width="60" height="50" fill="var(--info)" rx="4"/>
                        
                        <text x="80" y="10" font-size="12" fill="var(--primary)">$18.5M</text>
                        <text x="180" y="70" font-size="12" fill="var(--success)">$3.5M</text>
                        <text x="280" y="90" font-size="12" fill="var(--info)">$2.4M</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="finance-table">
                <thead><tr><th>Concepto</th><th>Monto</th><th>%</th></tr></thead>
                <tbody>
                    <tr><td><strong>Ingresos</strong></td><td class="positive">$18,500,000</td><td>100%</td></tr>
                    <tr><td>Costos Directos</td><td class="negative">-$13,300,000</td><td>71.9%</td></tr>
                    <tr><td><strong>Utilidad Bruta</strong></td><td class="positive">$5,200,000</td><td>28.1%</td></tr>
                    <tr><td>Gastos Operación</td><td class="negative">-$1,725,000</td><td>9.3%</td></tr>
                    <tr><td><strong>EBITDA</strong></td><td class="positive">$3,475,000</td><td>18.8%</td></tr>
                    <tr><td>Gastos Financieros</td><td class="negative">-$210,000</td><td>1.1%</td></tr>
                    <tr><td><strong>Utilidad Neta</strong></td><td class="positive">$2,416,300</td><td>13.1%</td></tr>
                </tbody>
            </table>
        `;
    }

    function generarNominaResumen(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-container" style="height: 150px;">
                    <svg width="100%" height="150" viewBox="0 0 400 150">
                        <line x1="40" y1="120" x2="360" y2="120" stroke="#ccc"/>
                        <rect x="70" y="30" width="50" height="90" fill="var(--primary)" rx="4"/>
                        <rect x="160" y="60" width="50" height="60" fill="var(--success)" rx="4"/>
                        <rect x="250" y="75" width="50" height="45" fill="var(--warning)" rx="4"/>
                        
                        <text x="75" y="20" font-size="11">84</text>
                        <text x="165" y="50" font-size="11">47</text>
                        <text x="255" y="65" font-size="11">56</text>
                        
                        <text x="70" y="135" font-size="10">Obreros</text>
                        <text x="160" y="135" font-size="10">Técnicos</text>
                        <text x="250" y="135" font-size="10">Admin</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card"><div class="label">Empleados</div><div class="value">187</div></div>
                <div class="kpi-card"><div class="label">Nómina Mensual</div><div class="value">$845K</div></div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-header"><span>Obreros</span><span>45%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:45%"></div></div>
                <div class="progress-header"><span>Técnicos</span><span>25%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:25%"></div></div>
                <div class="progress-header"><span>Administrativos</span><span>30%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill warning" style="width:30%"></div></div>
            </div>
        `;
    }

    function generarNominaProyectos(tipo) {
        return `
            <table class="finance-table">
                <thead><tr><th>Proyecto</th><th>Personal</th><th>Costo</th></tr></thead>
                <tbody>
                    <tr><td>Torre Norte</td><td>42</td><td>$245K</td></tr>
                    <tr><td>Puente Sur</td><td>38</td><td>$198K</td></tr>
                    <tr><td>Parque Ind</td><td>45</td><td>$278K</td></tr>
                    <tr><td>Hospital</td><td>28</td><td>$124K</td></tr>
                </tbody>
            </table>
        `;
    }

    function generarMaquinariaEstado(tipo) {
        return `
            <div class="kpi-grid">
                <div class="kpi-card"><div class="label">Total</div><div class="value">142</div></div>
                <div class="kpi-card"><div class="label">Operativos</div><div class="value" style="color:var(--success)">118</div></div>
                <div class="kpi-card"><div class="label">Mantención</div><div class="value" style="color:var(--warning)">24</div></div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-header"><span>Disponibilidad</span><span>83%</span></div>
                <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:83%"></div></div>
            </div>
        `;
    }

    function generarMaquinariaCostos(tipo) {
        return `
            <div class="kpi-grid">
                <div class="kpi-card"><div class="label">Operación</div><div class="value">$324K</div></div>
                <div class="kpi-card"><div class="label">Mantención</div><div class="value">$89K</div></div>
                <div class="kpi-card"><div class="label">Combustible</div><div class="value">$156K</div></div>
            </div>
        `;
    }
</script>
@endsection