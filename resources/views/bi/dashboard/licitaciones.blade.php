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
            --purple: #6f42c1;
            --purple-light: #e2d9f3;
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
            background: var(--primary);
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
            color: white;
            font-size: 18px;
        }

        .widget-title h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: white;
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
            color: rgba(255,255,255,0.8);
            background: transparent;
            border: none;
        }

        .widget-control:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Selector de tipo de gráfico */
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
            border: 1px solid var(--gray-200);
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

        .kpi-card .badge {
            margin-top: 8px;
        }

        /* ========== TABLAS DE LICITACIONES ========== */
        .tender-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .tender-table th {
            text-align: left;
            padding: 12px 10px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            border-bottom: 2px solid var(--primary);
        }

        .tender-table td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .tender-table tr:hover td {
            background: var(--primary-light);
        }

        .tender-table .positive { color: var(--success); font-weight: 500; }
        .tender-table .negative { color: var(--danger); font-weight: 500; }
        .tender-table .warning { color: var(--warning); font-weight: 500; }

        /* Timeline de licitaciones */
        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: var(--gray-100);
            border-radius: 8px;
            border-left: 4px solid transparent;
        }

        .timeline-item.pending { border-left-color: var(--warning); }
        .timeline-item.won { border-left-color: var(--success); }
        .timeline-item.lost { border-left-color: var(--danger); }
        .timeline-item.draft { border-left-color: var(--info); }

        .timeline-date {
            min-width: 80px;
            font-weight: 600;
            color: var(--gray-600);
        }

        .timeline-content {
            flex: 1;
            padding: 0 15px;
        }

        .timeline-title {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .timeline-amount {
            font-weight: 600;
            color: var(--primary);
        }

        /* Pipeline de licitaciones */
        .pipeline-stage {
            margin-bottom: 20px;
        }

        .stage-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .stage-name {
            font-weight: 600;
            color: var(--primary);
        }

        .stage-count {
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .stage-bar {
            height: 30px;
            background: var(--gray-200);
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            margin-bottom: 5px;
        }

        .stage-bar-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        /* Grid de licitaciones */
        .tender-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .tender-card {
            background: var(--gray-100);
            border-radius: 12px;
            padding: 15px;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .tender-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .tender-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .tender-card-title {
            font-weight: 600;
            font-size: 15px;
        }

        .tender-card-amount {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            margin: 10px 0;
        }

        .tender-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 12px;
        }

        /* ========== BADGES ========== */
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success { background: var(--success-light); color: var(--success); }
        .badge-warning { background: var(--warning-light); color: var(--warning); }
        .badge-danger { background: var(--danger-light); color: var(--danger); }
        .badge-info { background: var(--info-light); color: var(--info); }
        .badge-primary { background: var(--primary-light); color: var(--primary); }
        .badge-purple { background: var(--purple-light); color: var(--purple); }

        /* Estados de licitaciones */
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge.draft { background: var(--gray-200); color: var(--gray-600); }
        .status-badge.sent { background: var(--info-light); color: var(--info); }
        .status-badge.evaluating { background: var(--warning-light); color: var(--warning); }
        .status-badge.won { background: var(--success-light); color: var(--success); }
        .status-badge.lost { background: var(--danger-light); color: var(--danger); }

        /* Progress bars */
        .progress-bar-container {
            margin: 10px 0;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 5px;
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

        /* Modal de personalización */
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
            background: var(--primary);
            color: white;
            z-index: 10;
        }

        .widget-selector-header h2 {
            font-size: 20px;
            margin: 0;
            color: white;
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
            <h1>Licitaciones</h1>
            <p>
                <i class="fas fa-user"></i> 
                Hola, {{ Auth::user()->name }} · 
                <span id="fechaActual"></span>
            </p>
        </div>
        
        <div class="header-controls">
            <div class="period-selector">
                <div class="period-option active" onclick="cambiarPeriodo(this, 'mes')">Este Mes</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'trimestre')">Este Trimestre</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'semestre')">Este Semestre</div>
                <div class="period-option" onclick="cambiarPeriodo(this, 'año')">Este Año</div>
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
            
            <div class="control-btn primary" onclick="crearLicitacion()">
                <i class="fas fa-plus-circle"></i>
                <span>Nueva Licitación</span>
            </div>
        </div>
    </div>

    <!-- Grid de Widgets -->
    <div class="widget-grid" id="widgetGrid"></div>

    <!-- Modal Selector de Widgets -->
    <div class="widget-selector-modal" id="widgetSelectorModal" onclick="cerrarSelectorWidgets(event)">
        <div class="widget-selector-content">
            <div class="widget-selector-header">
                <h2><i class="fas fa-edit"></i> Personalizar Dashboard de Licitaciones</h2>
                <div class="widget-control" onclick="cerrarSelectorWidgets(event)" style="width: 40px; height: 40px;">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            
            <div class="widget-category">📊 KPIs y Métricas</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="kpis-licitaciones">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>KPIs de Licitaciones</h4>
                        <p>Total, monto, tasa de éxito y pipeline</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="tasa-exito">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Tasa de Éxito</h4>
                        <p>Ganadas vs Perdidas vs En Proceso</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">📋 Listados y Tablas</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="licitaciones-activas">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Licitaciones Activas</h4>
                        <p>Listado de licitaciones en curso</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="proximos-cierres">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Próximos Cierres</h4>
                        <p>Licitaciones por cerrar en los próximos días</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="historial-licitaciones">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Historial de Licitaciones</h4>
                        <p>Ganadas y perdidas del período</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">📈 Análisis por Cliente</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="top-clientes">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Top Clientes</h4>
                        <p>Clientes con más licitaciones</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="licitaciones-por-cliente">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Licitaciones por Cliente</h4>
                        <p>Distribución de licitaciones por cliente</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">📅 Timeline y Pipeline</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="timeline-licitaciones">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Timeline de Licitaciones</h4>
                        <p>Línea de tiempo de próximos eventos</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="pipeline-ventas">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Pipeline de Licitaciones</h4>
                        <p>Embudo de ventas por etapa</p>
                    </div>
                </div>
            </div>

            <div class="widget-category">💰 Análisis Financiero</div>
            <div class="widget-list">
                <div class="widget-option" data-widget="montos-por-mes">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Montos por Mes</h4>
                        <p>Evolución de montos licitados</p>
                    </div>
                </div>
                
                <div class="widget-option" data-widget="proyeccion-ingresos">
                    <input type="checkbox" class="widget-checkbox" checked>
                    <div class="widget-option-info">
                        <h4>Proyección de Ingresos</h4>
                        <p>Ingresos proyectados por licitaciones</p>
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
    // Configuración de widgets de licitaciones
    const widgetsConfig = {
        'kpis-licitaciones': {
            titulo: 'KPIs de Licitaciones',
            icono: 'fa-chart-line',
            tipos: ['kpi', 'barra', 'tabla'],
            contenido: (tipo) => generarKPIsLicitaciones(tipo)
        },
        'tasa-exito': {
            titulo: 'Tasa de Éxito',
            icono: 'fa-chart-pie',
            tipos: ['pastel', 'barra', 'kpi'],
            contenido: (tipo) => generarTasaExito(tipo)
        },
        'licitaciones-activas': {
            titulo: 'Licitaciones Activas',
            icono: 'fa-file-signature',
            tipos: ['tabla', 'cards', 'barra'],
            contenido: (tipo) => generarLicitacionesActivas(tipo)
        },
        'proximos-cierres': {
            titulo: 'Próximos Cierres',
            icono: 'fa-clock',
            tipos: ['tabla', 'cards', 'timeline'],
            contenido: (tipo) => generarProximosCierres(tipo)
        },
        'historial-licitaciones': {
            titulo: 'Historial de Licitaciones',
            icono: 'fa-history',
            tipos: ['tabla', 'cards', 'barra'],
            contenido: (tipo) => generarHistorialLicitaciones(tipo)
        },
        'top-clientes': {
            titulo: 'Top Clientes',
            icono: 'fa-trophy',
            tipos: ['tabla', 'barra', 'cards'],
            contenido: (tipo) => generarTopClientes(tipo)
        },
        'licitaciones-por-cliente': {
            titulo: 'Licitaciones por Cliente',
            icono: 'fa-building',
            tipos: ['barra', 'pastel', 'tabla'],
            contenido: (tipo) => generarLicitacionesPorCliente(tipo)
        },
        'timeline-licitaciones': {
            titulo: 'Timeline de Licitaciones',
            icono: 'fa-calendar-alt',
            tipos: ['timeline', 'tabla', 'cards'],
            contenido: (tipo) => generarTimelineLicitaciones(tipo)
        },
        'pipeline-ventas': {
            titulo: 'Pipeline de Licitaciones',
            icono: 'fa-filter',
            tipos: ['embudo', 'barra', 'tabla'],
            contenido: (tipo) => generarPipelineVentas(tipo)
        },
        'montos-por-mes': {
            titulo: 'Montos por Mes',
            icono: 'fa-chart-bar',
            tipos: ['barra', 'linea', 'tabla'],
            contenido: (tipo) => generarMontosPorMes(tipo)
        },
        'proyeccion-ingresos': {
            titulo: 'Proyección de Ingresos',
            icono: 'fa-chart-line',
            tipos: ['linea', 'barra', 'kpi'],
            contenido: (tipo) => generarProyeccionIngresos(tipo)
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
            'pastel': 'fa-chart-pie',
            'cards': 'fa-th-large',
            'timeline': 'fa-clock',
            'embudo': 'fa-filter'
        };
        
        return tipos.map(tipo => `
            <button class="chart-type-btn ${tipo === tipoActual ? 'active' : ''}" 
                    onclick="cambiarTipoWidget(this, '${widgetId}', '${tipo}')">
                <i class="fas ${iconos[tipo] || 'fa-chart-bar'}"></i>
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
        
        localStorage.setItem('tenderDashboardConfig', JSON.stringify(config));
        mostrarNotificacion('Configuración guardada', 'success');
    }

    function cargarConfiguracion() {
        const configGuardada = localStorage.getItem('tenderDashboardConfig');
        const grid = document.getElementById('widgetGrid');
        grid.innerHTML = '';
        
        if (configGuardada) {
            const config = JSON.parse(configGuardada);
            config.sort((a, b) => a.order - b.order).forEach(item => {
                agregarWidget(item.id, item.size, item.tipo);
            });
        } else {
            // Widgets por defecto
            agregarWidget('kpis-licitaciones', 'large', 'kpi');
            agregarWidget('licitaciones-activas', 'medium', 'tabla');
            agregarWidget('proximos-cierres', 'small', 'cards');
            agregarWidget('tasa-exito', 'small', 'pastel');
            agregarWidget('pipeline-ventas', 'medium', 'embudo');
            agregarWidget('montos-por-mes', 'medium', 'barra');
            agregarWidget('top-clientes', 'small', 'tabla');
            agregarWidget('timeline-licitaciones', 'medium', 'timeline');
        }
    }

    function resetearDashboard() {
        if (confirm('¿Resetear el dashboard a su estado original?')) {
            localStorage.removeItem('tenderDashboardConfig');
            cargarConfiguracion();
            mostrarNotificacion('Dashboard restaurado', 'success');
        }
    }

    function crearLicitacion() {
        mostrarNotificacion('Crear nueva licitación - En desarrollo', 'info');
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

    function inicializarResize() {}

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
        }
        
        document.addEventListener('mousemove', resize);
        document.addEventListener('mouseup', stopResize);
    }

    // ========== FUNCIONES DE RENDERIZADO DE LICITACIONES ==========
    function generarKPIsLicitaciones(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-container" style="height: 180px;">
                    <svg width="100%" height="180" viewBox="0 0 400 180">
                        <line x1="40" y1="150" x2="360" y2="150" stroke="#ccc"/>
                        <rect x="70" y="30" width="50" height="120" fill="var(--primary)" rx="4"/>
                        <rect x="160" y="70" width="50" height="80" fill="var(--success)" rx="4"/>
                        <rect x="250" y="90" width="50" height="60" fill="var(--warning)" rx="4"/>
                        
                        <text x="75" y="20" font-size="12" fill="var(--primary)">24</text>
                        <text x="165" y="60" font-size="12" fill="var(--success)">8</text>
                        <text x="255" y="80" font-size="12" fill="var(--warning)">$12.8M</text>
                        
                        <text x="65" y="165" font-size="10">Activas</text>
                        <text x="155" y="165" font-size="10">Ganadas</text>
                        <text x="245" y="165" font-size="10">Monto</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Licitaciones Activas</div>
                    <div class="value">24</div>
                    <div class="comparison positive"><i class="fas fa-arrow-up"></i> +4 vs mes ant</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Monto Total</div>
                    <div class="value">$12.8M</div>
                    <div class="comparison positive"><i class="fas fa-arrow-up"></i> +15.3%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Tasa de Éxito</div>
                    <div class="value">68%</div>
                    <div class="comparison positive"><i class="fas fa-arrow-up"></i> +5%</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Ganadas YTD</div>
                    <div class="value">$8.2M</div>
                    <div class="comparison positive"><i class="fas fa-arrow-up"></i> +22%</div>
                </div>
            </div>
        `;
    }

    function generarTasaExito(tipo) {
        if (tipo === 'pastel') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color success"></span> Ganadas 45%</div>
                    <div class="legend-item"><span class="legend-color warning"></span> En Proceso 35%</div>
                    <div class="legend-item"><span class="legend-color danger"></span> Perdidas 20%</div>
                </div>
                <div class="chart-container" style="height: 160px;">
                    <svg width="100%" height="160" viewBox="0 0 200 160">
                        <g transform="translate(80,80)">
                            <path d="M0,0 L60,0 A60,60 0 0,1 18,57 Z" fill="var(--success)"/>
                            <path d="M0,0 L18,57 A60,60 0 0,1 -47,37 Z" fill="var(--warning)"/>
                            <path d="M0,0 L-47,37 A60,60 0 0,1 0,-60 Z" fill="var(--danger)"/>
                            <circle cx="0" cy="0" r="25" fill="white"/>
                        </g>
                        <text x="140" y="40" fill="var(--success)" font-size="12">8</text>
                        <text x="140" y="60" fill="var(--warning)" font-size="12">12</text>
                        <text x="140" y="80" fill="var(--danger)" font-size="12">4</text>
                    </svg>
                </div>
            `;
        } else if (tipo === 'barra') {
            return `
                <div class="chart-container" style="height: 160px;">
                    <svg width="100%" height="160" viewBox="0 0 300 160">
                        <line x1="40" y1="130" x2="260" y2="130" stroke="#ccc"/>
                        <rect x="70" y="30" width="40" height="100" fill="var(--success)" rx="4"/>
                        <rect x="140" y="60" width="40" height="70" fill="var(--warning)" rx="4"/>
                        <rect x="210" y="90" width="40" height="40" fill="var(--danger)" rx="4"/>
                        
                        <text x="75" y="20" fill="var(--success)">8</text>
                        <text x="145" y="50" fill="var(--warning)">12</text>
                        <text x="215" y="80" fill="var(--danger)">4</text>
                        
                        <text x="65" y="145">Ganadas</text>
                        <text x="135" y="145">Proceso</text>
                        <text x="205" y="145">Perdidas</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Ganadas</div>
                    <div class="value">8</div>
                    <span class="badge badge-success">45%</span>
                </div>
                <div class="kpi-card">
                    <div class="label">En Proceso</div>
                    <div class="value">12</div>
                    <span class="badge badge-warning">35%</span>
                </div>
                <div class="kpi-card">
                    <div class="label">Perdidas</div>
                    <div class="value">4</div>
                    <span class="badge badge-danger">20%</span>
                </div>
            </div>
        `;
    }

    function generarLicitacionesActivas(tipo) {
        if (tipo === 'cards') {
            return `
                <div class="tender-grid">
                    <div class="tender-card">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Puente Norte</span>
                            <span class="badge badge-warning">Evaluando</span>
                        </div>
                        <div class="tender-card-amount">$2,500,000</div>
                        <div class="tender-card-footer">
                            <span>Cliente: MOP</span>
                            <span>Cierre: 15/04</span>
                        </div>
                    </div>
                    <div class="tender-card">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Hospital Sur</span>
                            <span class="badge badge-info">Preparando</span>
                        </div>
                        <div class="tender-card-amount">$5,800,000</div>
                        <div class="tender-card-footer">
                            <span>Cliente: Salud</span>
                            <span>Cierre: 30/04</span>
                        </div>
                    </div>
                    <div class="tender-card">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Parque Industrial</span>
                            <span class="badge badge-warning">Evaluando</span>
                        </div>
                        <div class="tender-card-amount">$3,200,000</div>
                        <div class="tender-card-footer">
                            <span>Cliente: Privado</span>
                            <span>Cierre: 10/05</span>
                        </div>
                    </div>
                    <div class="tender-card">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Colegio Centro</span>
                            <span class="badge badge-info">Preparando</span>
                        </div>
                        <div class="tender-card-amount">$1,300,000</div>
                        <div class="tender-card-footer">
                            <span>Cliente: Educación</span>
                            <span>Cierre: 05/05</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        return `
            <table class="tender-table">
                <thead>
                    <tr>
                        <th>Licitación</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Cierre</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Puente Norte</strong></td>
                        <td>MOP</td>
                        <td class="positive">$2,500,000</td>
                        <td>15/04/2026</td>
                        <td><span class="badge badge-warning">Evaluando</span></td>
                    </tr>
                    <tr>
                        <td><strong>Hospital Regional</strong></td>
                        <td>Salud Pública</td>
                        <td class="positive">$5,800,000</td>
                        <td>30/04/2026</td>
                        <td><span class="badge badge-info">Preparando</span></td>
                    </tr>
                    <tr>
                        <td><strong>Parque Industrial</strong></td>
                        <td>Inversiones ABC</td>
                        <td class="positive">$3,200,000</td>
                        <td>10/05/2026</td>
                        <td><span class="badge badge-warning">Evaluando</span></td>
                    </tr>
                    <tr>
                        <td><strong>Colegio Centro</strong></td>
                        <td>Municipalidad</td>
                        <td class="positive">$1,300,000</td>
                        <td>05/05/2026</td>
                        <td><span class="badge badge-info">Preparando</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function generarProximosCierres(tipo) {
        if (tipo === 'cards') {
            return `
                <div class="tender-grid">
                    <div class="tender-card" style="border-left: 4px solid var(--warning);">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Puente Norte</span>
                            <span class="badge badge-warning">3 días</span>
                        </div>
                        <div class="tender-card-amount">$2,500,000</div>
                        <div class="tender-card-footer">
                            <span>MOP</span>
                            <span>15/04</span>
                        </div>
                    </div>
                    <div class="tender-card" style="border-left: 4px solid var(--info);">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Terminal</span>
                            <span class="badge badge-info">7 días</span>
                        </div>
                        <div class="tender-card-amount">$4,100,000</div>
                        <div class="tender-card-footer">
                            <span>Puertos</span>
                            <span>19/04</span>
                        </div>
                    </div>
                    <div class="tender-card" style="border-left: 4px solid var(--success);">
                        <div class="tender-card-header">
                            <span class="tender-card-title">Hospital</span>
                            <span class="badge badge-success">12 días</span>
                        </div>
                        <div class="tender-card-amount">$5,800,000</div>
                        <div class="tender-card-footer">
                            <span>Salud</span>
                            <span>24/04</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        return `
            <table class="tender-table">
                <thead>
                    <tr>
                        <th>Licitación</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Cierre</th>
                        <th>Días</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Puente Norte</strong></td>
                        <td>MOP</td>
                        <td class="positive">$2,500,000</td>
                        <td>15/04/2026</td>
                        <td><span class="badge badge-warning">3 días</span></td>
                    </tr>
                    <tr>
                        <td><strong>Terminal Puerto</strong></td>
                        <td>Puertos SA</td>
                        <td class="positive">$4,100,000</td>
                        <td>19/04/2026</td>
                        <td><span class="badge badge-info">7 días</span></td>
                    </tr>
                    <tr>
                        <td><strong>Hospital Regional</strong></td>
                        <td>Salud Pública</td>
                        <td class="positive">$5,800,000</td>
                        <td>24/04/2026</td>
                        <td><span class="badge badge-success">12 días</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function generarHistorialLicitaciones(tipo) {
        return `
            <table class="tender-table">
                <thead>
                    <tr>
                        <th>Licitación</th>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Torre Office</strong></td>
                        <td>Inmobiliaria</td>
                        <td class="positive">$3,200,000</td>
                        <td>15/03/2026</td>
                        <td><span class="badge badge-success">Ganada</span></td>
                    </tr>
                    <tr>
                        <td><strong>Puente Sur</strong></td>
                        <td>MOP</td>
                        <td class="positive">$1,800,000</td>
                        <td>10/03/2026</td>
                        <td><span class="badge badge-danger">Perdida</span></td>
                    </tr>
                    <tr>
                        <td><strong>Escuela Rural</strong></td>
                        <td>Municipalidad</td>
                        <td class="positive">$950,000</td>
                        <td>05/03/2026</td>
                        <td><span class="badge badge-success">Ganada</span></td>
                    </tr>
                    <tr>
                        <td><strong>Parque Central</strong></td>
                        <td>Gobierno Regional</td>
                        <td class="positive">$2,500,000</td>
                        <td>28/02/2026</td>
                        <td><span class="badge badge-success">Ganada</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function generarTopClientes(tipo) {
        if (tipo === 'barra') {
            return `
                <div class="chart-container" style="height: 160px;">
                    <svg width="100%" height="160" viewBox="0 0 400 160">
                        <line x1="40" y1="130" x2="360" y2="130" stroke="#ccc"/>
                        <rect x="60" y="30" width="50" height="100" fill="var(--primary)" rx="4"/>
                        <rect x="140" y="50" width="50" height="80" fill="var(--success)" rx="4"/>
                        <rect x="220" y="70" width="50" height="60" fill="var(--warning)" rx="4"/>
                        <rect x="300" y="90" width="50" height="40" fill="var(--info)" rx="4"/>
                        
                        <text x="65" y="20">MOP</text>
                        <text x="145" y="40">Salud</text>
                        <text x="225" y="60">Privado</text>
                        <text x="305" y="80">Muni</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="tender-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Licitaciones</th>
                        <th>Monto Total</th>
                        <th>Ganadas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>MOP</strong></td>
                        <td>8</td>
                        <td class="positive">$4,200,000</td>
                        <td><span class="badge badge-success">5</span></td>
                    </tr>
                    <tr>
                        <td><strong>Salud Pública</strong></td>
                        <td>5</td>
                        <td class="positive">$3,800,000</td>
                        <td><span class="badge badge-success">3</span></td>
                    </tr>
                    <tr>
                        <td><strong>Inversiones Privadas</strong></td>
                        <td>4</td>
                        <td class="positive">$2,500,000</td>
                        <td><span class="badge badge-success">2</span></td>
                    </tr>
                    <tr>
                        <td><strong>Municipalidades</strong></td>
                        <td>3</td>
                        <td class="positive">$1,200,000</td>
                        <td><span class="badge badge-success">1</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function generarLicitacionesPorCliente(tipo) {
        return `
            <div class="chart-legend">
                <div class="legend-item"><span class="legend-color primary"></span> MOP: 8</div>
                <div class="legend-item"><span class="legend-color success"></span> Salud: 5</div>
                <div class="legend-item"><span class="legend-color warning"></span> Privado: 4</div>
            </div>
            <div class="chart-container" style="height: 160px;">
                <svg width="100%" height="160" viewBox="0 0 400 160">
                    <line x1="40" y1="130" x2="360" y2="130" stroke="#ccc"/>
                    <rect x="70" y="50" width="60" height="80" fill="var(--primary)" rx="4"/>
                    <rect x="160" y="70" width="60" height="60" fill="var(--success)" rx="4"/>
                    <rect x="250" y="90" width="60" height="40" fill="var(--warning)" rx="4"/>
                </svg>
            </div>
        `;
    }

    function generarTimelineLicitaciones(tipo) {
        return `
            <div class="timeline">
                <div class="timeline-item pending">
                    <div class="timeline-date">15/04</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Puente Norte</div>
                        <div>Cierre de licitación</div>
                    </div>
                    <div class="timeline-amount">$2.5M</div>
                </div>
                <div class="timeline-item pending">
                    <div class="timeline-date">19/04</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Terminal Puerto</div>
                        <div>Entrega de propuestas</div>
                    </div>
                    <div class="timeline-amount">$4.1M</div>
                </div>
                <div class="timeline-item draft">
                    <div class="timeline-date">24/04</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Hospital Regional</div>
                        <div>Presentación final</div>
                    </div>
                    <div class="timeline-amount">$5.8M</div>
                </div>
                <div class="timeline-item won">
                    <div class="timeline-date">10/04</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Colegio Centro</div>
                        <div>Adjudicada</div>
                    </div>
                    <div class="timeline-amount">$1.3M</div>
                </div>
            </div>
        `;
    }

    function generarPipelineVentas(tipo) {
        return `
            <div class="pipeline-stage">
                <div class="stage-header">
                    <span class="stage-name">Identificadas</span>
                    <span class="stage-count">8</span>
                </div>
                <div class="stage-bar">
                    <div class="stage-bar-fill" style="width: 100%;">$4.2M</div>
                </div>
            </div>
            <div class="pipeline-stage">
                <div class="stage-header">
                    <span class="stage-name">Preparando Propuesta</span>
                    <span class="stage-count">6</span>
                </div>
                <div class="stage-bar">
                    <div class="stage-bar-fill" style="width: 75%; background: var(--warning);">$3.1M</div>
                </div>
            </div>
            <div class="pipeline-stage">
                <div class="stage-header">
                    <span class="stage-name">En Evaluación</span>
                    <span class="stage-count">4</span>
                </div>
                <div class="stage-bar">
                    <div class="stage-bar-fill" style="width: 50%; background: var(--info);">$2.8M</div>
                </div>
            </div>
            <div class="pipeline-stage">
                <div class="stage-header">
                    <span class="stage-name">Negociación</span>
                    <span class="stage-count">2</span>
                </div>
                <div class="stage-bar">
                    <div class="stage-bar-fill" style="width: 25%; background: var(--success);">$1.5M</div>
                </div>
            </div>
            <div style="margin-top: 15px; text-align: center;">
                <strong>Pipeline Total: $11.6M</strong>
            </div>
        `;
    }

    function generarMontosPorMes(tipo) {
        if (tipo === 'linea') {
            return `
                <div class="chart-container">
                    <svg width="100%" height="160" viewBox="0 0 400 160">
                        <line x1="40" y1="130" x2="360" y2="130" stroke="#ccc"/>
                        <polyline points="60,110 120,80 180,50 240,70 300,30 340,40" 
                                  fill="none" stroke="var(--primary)" stroke-width="3"/>
                        <circle cx="60" cy="110" r="4" fill="var(--primary)"/>
                        <circle cx="120" cy="80" r="4" fill="var(--primary)"/>
                        <circle cx="180" cy="50" r="4" fill="var(--primary)"/>
                        <circle cx="240" cy="70" r="4" fill="var(--primary)"/>
                        <circle cx="300" cy="30" r="4" fill="var(--primary)"/>
                        <text x="50" y="145">Ene</text>
                        <text x="110" y="145">Feb</text>
                        <text x="170" y="145">Mar</text>
                        <text x="230" y="145">Abr</text>
                        <text x="290" y="145">May</text>
                    </svg>
                </div>
            `;
        }
        
        return `
            <table class="tender-table">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Licitaciones</th>
                        <th>Monto</th>
                        <th>Ganadas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Enero</strong></td>
                        <td>6</td>
                        <td class="positive">$2.8M</td>
                        <td><span class="badge badge-success">2</span></td>
                    </tr>
                    <tr>
                        <td><strong>Febrero</strong></td>
                        <td>8</td>
                        <td class="positive">$3.5M</td>
                        <td><span class="badge badge-success">3</span></td>
                    </tr>
                    <tr>
                        <td><strong>Marzo</strong></td>
                        <td>7</td>
                        <td class="positive">$4.2M</td>
                        <td><span class="badge badge-success">2</span></td>
                    </tr>
                    <tr>
                        <td><strong>Abril</strong></td>
                        <td>5</td>
                        <td class="positive">$2.3M</td>
                        <td><span class="badge badge-warning">En curso</span></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    function generarProyeccionIngresos(tipo) {
        if (tipo === 'linea') {
            return `
                <div class="chart-legend">
                    <div class="legend-item"><span class="legend-color primary"></span> Proyectado</div>
                    <div class="legend-item"><span class="legend-color success"></span> Real</div>
                </div>
                <div class="chart-container">
                    <svg width="100%" height="160" viewBox="0 0 400 160">
                        <line x1="40" y1="130" x2="360" y2="130" stroke="#ccc"/>
                        <polyline points="60,110 120,90 180,70 240,50 300,40 340,30" 
                                  fill="none" stroke="var(--primary)" stroke-width="3" stroke-dasharray="5,5"/>
                        <polyline points="60,100 120,80 180,60 240,50 300,45 340,35" 
                                  fill="none" stroke="var(--success)" stroke-width="3"/>
                    </svg>
                </div>
            `;
        }
        
        return `
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="label">Proyectado Q2</div>
                    <div class="value">$8.5M</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Pipeline</div>
                    <div class="value">$11.6M</div>
                </div>
                <div class="kpi-card">
                    <div class="label">Probabilidad</div>
                    <div class="value">68%</div>
                </div>
            </div>
            <div class="progress-bar-container">
                <div class="progress-header">
                    <span>Avance vs Meta Q2</span>
                    <span>45%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill primary" style="width:45%"></div>
                </div>
            </div>
        `;
    }
</script>
@endsection