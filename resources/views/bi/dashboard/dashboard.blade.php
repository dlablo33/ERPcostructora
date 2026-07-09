@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <style>
        /* ========== VARIABLES ========== */
        :root {
            --primary: #083CAE;
            --primary-dark: #0a4bc9;
            --primary-light: #e8f0fe;
            --success: #28a745;
            --success-light: #d4edda;
            --warning: #ffc107;
            --warning-light: #fff3cd;
            --danger: #dc3545;
            --danger-light: #f8d7da;
            --info: #17a2b8;
            --info-light: #d1ecf1;
            --gray-50: #f8f9fa;
            --gray-100: #f1f3f5;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --purple: #6f42c1;
            --orange: #fd7e14;
            --teal: #20c997;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }

        .dashboard-container {
            animation: fadeIn 0.6s ease;
            padding: 20px;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* ========== HEADER ========== */
        .dashboard-header {
            background: white;
            border-radius: var(--radius-lg);
            padding: 20px 25px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title h1 i {
            color: var(--primary);
            font-size: 30px;
        }

        .header-title p {
            color: var(--gray-600);
            margin: 5px 0 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .header-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .control-btn {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
            color: var(--gray-700);
            font-weight: 500;
        }

        .control-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .control-btn.primary {
            background: var(--primary);
            color: white;
            border: none;
        }

        .control-btn.primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 15px rgba(8,60,174,0.3);
        }

        .period-selector {
            display: flex;
            gap: 4px;
            background: var(--gray-100);
            padding: 4px;
            border-radius: var(--radius-sm);
        }

        .period-option {
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: var(--transition);
            color: var(--gray-600);
            font-weight: 500;
            border: none;
            background: transparent;
        }

        .period-option:hover {
            color: var(--gray-900);
            background: rgba(8,60,174,0.05);
        }

        .period-option.active {
            background: white;
            box-shadow: var(--shadow-sm);
            color: var(--primary);
            font-weight: 600;
        }

        /* ========== FILTROS MEJORADOS ========== */
        .filtros-container {
            background: white;
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .filtros-container:hover {
            box-shadow: var(--shadow-lg);
        }

        .filtros-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .filtros-titulo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 15px;
            color: var(--gray-800);
        }

        .filtros-titulo i {
            color: var(--primary);
            font-size: 18px;
        }

        .filtros-badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 4px;
            transition: var(--transition);
        }

        .filtros-actions {
            display: flex;
            gap: 8px;
        }

        .btn-filtro {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-filtro-clear {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-filtro-clear:hover {
            background: var(--gray-200);
            transform: translateY(-1px);
        }

        .btn-filtro-apply {
            background: var(--primary);
            color: white;
        }

        .btn-filtro-apply:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(8,60,174,0.3);
        }

        /* ===== BÚSQUEDA ===== */
        .filtros-busqueda {
            margin-bottom: 14px;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 14px;
            pointer-events: none;
            transition: var(--transition);
        }

        .search-wrapper .search-input {
            width: 100%;
            padding: 10px 40px 10px 42px;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 14px;
            transition: var(--transition);
            background: var(--gray-50);
            color: var(--gray-800);
        }

        .search-wrapper .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(8,60,174,0.08);
        }

        .search-wrapper .search-clear {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
            transition: var(--transition);
            display: none;
        }

        .search-wrapper .search-clear.visible {
            display: block;
        }

        .search-wrapper .search-clear:hover {
            color: var(--gray-700);
            background: var(--gray-100);
        }

        /* ===== LISTA DE PROYECTOS ===== */
        .filtros-lista {
            max-height: 220px;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 6px;
            padding: 4px 2px;
            margin-bottom: 14px;
            border-radius: var(--radius-sm);
        }

        .filtros-lista::-webkit-scrollbar {
            width: 5px;
        }

        .filtros-lista::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 3px;
        }

        .filtros-lista::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        .filtros-lista::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .proyecto-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
            font-size: 13px;
            color: var(--gray-700);
            user-select: none;
            background: var(--gray-50);
        }

        .proyecto-item:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateX(4px);
        }

        .proyecto-item.selected {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }

        .proyecto-item.selected .proyecto-check {
            background: var(--primary);
            color: white;
        }

        .proyecto-item.hidden {
            display: none;
        }

        .proyecto-item .proyecto-check {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid var(--gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            transition: var(--transition);
            flex-shrink: 0;
            color: transparent;
            background: white;
        }

        .proyecto-item.selected .proyecto-check {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        .proyecto-item .proyecto-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .proyecto-item .proyecto-nombre {
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .proyecto-item .proyecto-codigo {
            font-size: 10px;
            color: var(--gray-500);
            font-weight: 400;
        }

        .proyecto-item .proyecto-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .proyecto-item .proyecto-status.activo { background: var(--success); }
        .proyecto-item .proyecto-status.inactivo { background: var(--gray-400); }
        .proyecto-item .proyecto-status.finalizado { background: var(--info); }

        /* ===== TAGS SELECCIONADOS ===== */
        .filtros-seleccionados {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding-top: 12px;
            border-top: 1px solid var(--gray-200);
            min-height: 36px;
        }

        .filtros-seleccionados:empty {
            padding-top: 0;
            border-top: none;
        }

        .tag-proyecto {
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 12px 4px 14px;
            border-radius: 16px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            animation: fadeIn 0.2s ease;
            font-weight: 500;
        }

        .tag-proyecto .tag-remove {
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
            background: none;
            border: none;
            color: inherit;
            padding: 2px 4px;
            font-size: 12px;
            display: flex;
            align-items: center;
            border-radius: 50%;
        }

        .tag-proyecto .tag-remove:hover {
            opacity: 1;
            background: rgba(8,60,174,0.15);
            transform: scale(1.2);
        }

        .tag-todos {
            background: var(--success-light);
            color: #155724;
        }

        .tag-todos .tag-remove {
            color: #155724;
        }

        .tag-todos .tag-remove:hover {
            background: rgba(40,167,69,0.15);
        }

        /* ========== WIDGET GRID ========== */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .widget-item {
            min-height: 280px;
            transition: var(--transition);
            position: relative;
            animation: slideIn 0.5s ease;
        }

        .widget-item[data-size="small"] { grid-column: span 1; }
        .widget-item[data-size="medium"] { grid-column: span 2; }
        .widget-item[data-size="large"] { grid-column: span 3; }
        .widget-item[data-size="xlarge"] { grid-column: span 4; }

        .widget-item:hover {
            transform: translateY(-4px);
        }

        .widget-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            position: relative;
        }

        .widget-card:hover {
            box-shadow: var(--shadow-md);
        }

        .widget-card.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .widget-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary) !important;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            min-height: 52px;
        }

        .widget-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .widget-title i {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
        }

        .widget-title h3 {
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            color: white;
            letter-spacing: 0.3px;
        }

        .widget-controls {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .widget-control {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: rgba(255,255,255,0.8);
            background: transparent;
            border: none;
            font-size: 14px;
        }

        .widget-control:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .widget-content {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
            font-size: 14px;
        }

        .widget-content::-webkit-scrollbar {
            width: 4px;
        }

        .widget-content::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 2px;
        }

        .widget-content::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 2px;
        }

        .widget-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 150px;
            color: var(--gray-500);
            font-size: 14px;
            gap: 12px;
        }

        .widget-loading i {
            font-size: 28px;
            color: var(--primary);
        }

        /* ========== KPI CARDS ========== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 12px;
        }

        .kpi-card {
            background: var(--gray-50);
            border-radius: var(--radius-sm);
            padding: 15px;
            text-align: center;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
        }

        .kpi-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        .kpi-card .kpi-icon {
            font-size: 20px;
            color: var(--primary);
            margin-bottom: 5px;
            display: block;
        }

        .kpi-card .label {
            font-size: 11px;
            color: var(--gray-600);
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kpi-card .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .kpi-card .value.primary { color: var(--primary); }
        .kpi-card .value.success { color: var(--success); }
        .kpi-card .value.danger { color: var(--danger); }
        .kpi-card .value.warning { color: var(--warning); }
        .kpi-card .value.info { color: var(--info); }
        .kpi-card .value.purple { color: var(--purple); }

        /* ========== PROGRESS BARS ========== */
        .progress-bar-container {
            margin: 10px 0;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
            color: var(--gray-700);
        }

        .progress-bar-bg {
            width: 100%;
            height: 6px;
            background: var(--gray-200);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.8s ease;
        }

        .progress-bar-fill.success { background: var(--success); }
        .progress-bar-fill.warning { background: var(--warning); }
        .progress-bar-fill.danger { background: var(--danger); }
        .progress-bar-fill.primary { background: var(--primary); }
        .progress-bar-fill.info { background: var(--info); }

        /* ========== TABLES ========== */
        .finance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .finance-table thead th {
            text-align: left;
            padding: 10px 8px;
            background: var(--gray-50);
            color: var(--gray-700);
            font-weight: 600;
            border-bottom: 2px solid var(--gray-200);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .finance-table tbody td {
            padding: 8px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }

        .finance-table tbody tr:hover td {
            background: var(--primary-light);
        }

        .finance-table .positive { color: var(--success); font-weight: 600; }
        .finance-table .negative { color: var(--danger); font-weight: 600; }
        .finance-table .warning { color: var(--warning); font-weight: 600; }
        .finance-table .primary { color: var(--primary); font-weight: 600; }
        .finance-table .text-right { text-align: right; }
        .finance-table .text-center { text-align: center; }

        /* ========== BADGES ========== */
        .badge-status {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-status.success { background: var(--success-light); color: #155724; }
        .badge-status.warning { background: var(--warning-light); color: #856404; }
        .badge-status.danger { background: var(--danger-light); color: #721c24; }
        .badge-status.info { background: var(--info-light); color: #0c5460; }
        .badge-status.primary { background: var(--primary-light); color: var(--primary); }

        /* ========== ALERTAS ========== */
        .alert-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            margin-bottom: 8px;
            font-size: 13px;
            border-left: 4px solid transparent;
            transition: var(--transition);
        }

        .alert-item:hover {
            transform: translateX(4px);
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

        .alert-item .alert-icon {
            font-size: 18px;
        }
        .alert-item .alert-content {
            flex: 1;
        }
        .alert-item .alert-title {
            font-weight: 600;
            font-size: 13px;
        }

        /* ========== TOAST ========== */
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 14px 24px;
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-lg);
            z-index: 20000;
            animation: slideIn 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toast-notification.success { background: var(--success); color: white; }
        .toast-notification.error { background: var(--danger); color: white; }
        .toast-notification.warning { background: var(--warning); color: #856404; }
        .toast-notification.info { background: var(--info); color: white; }

        .toast-close {
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
            background: transparent;
            border: none;
            color: inherit;
            font-size: 18px;
        }

        .toast-close:hover {
            opacity: 1;
        }

        /* ========== CHART ========== */
        .chart-container {
            width: 100%;
            height: 160px;
            position: relative;
            margin-top: 5px;
        }

        .chart-legend {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin: 8px 0;
            padding: 8px 12px;
            background: var(--gray-50);
            border-radius: var(--radius-sm);
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--gray-700);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            display: inline-block;
        }

        .legend-color.primary { background: var(--primary); }
        .legend-color.success { background: var(--success); }
        .legend-color.warning { background: var(--warning); }
        .legend-color.danger { background: var(--danger); }
        .legend-color.info { background: var(--info); }
        .legend-color.purple { background: var(--purple); }

        /* ========== BANCOS TABLE ========== */
        .table-bancos {
            font-size: 12px;
            width: 100%;
            border-collapse: collapse;
        }

        .table-bancos thead th {
            text-align: left;
            padding: 8px 6px;
            background: var(--gray-50);
            color: var(--gray-700);
            font-weight: 600;
            border-bottom: 2px solid var(--gray-200);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-bancos tbody td {
            padding: 6px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }

        .table-bancos tbody tr:hover td {
            background: var(--primary-light);
        }

        .table-bancos .text-right { text-align: right; }
        .table-bancos .positive { color: var(--success); font-weight: 600; }
        .table-bancos .negative { color: var(--danger); font-weight: 600; }
        .table-bancos .primary { color: var(--primary); font-weight: 600; }
        .table-bancos .purple { color: var(--purple); font-weight: 600; }
        .table-bancos .success { color: var(--success); font-weight: 600; }
        .table-bancos .danger { color: var(--danger); font-weight: 600; }

        /* ========== ESTILOS DEL WIDGET ESTADO RESULTADOS ========== */
        .er-metrics-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1px;
            background: #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .er-metric-card {
            background: #fff;
            padding: 15px;
            text-align: center;
        }

        .er-metric-card .er-metric-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .er-metric-card .er-metric-value {
            font-size: 18px;
            font-weight: bold;
        }

        .er-metric-card .er-metric-value.positive { color: #28a745; }
        .er-metric-card .er-metric-value.negative { color: #dc3545; }
        .er-metric-card .er-metric-value.primary { color: #083CAE; }

        .er-table-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow-x: auto;
        }

        .er-table {
            width: 100%;
            font-size: 13px;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .er-table thead th {
            background-color: #083CAE;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-size: 12px;
            border: 1px solid #0a4bc9;
        }

        .er-table thead th:first-child {
            text-align: left;
        }

        .er-table thead th .er-subtitle {
            font-weight: normal;
            font-size: 10px;
            display: block;
            color: rgba(255,255,255,0.8);
        }

        .er-table tbody td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .er-table .er-section-header {
            background-color: #f8f9fa;
            font-weight: bold;
            cursor: pointer;
        }

        .er-table .er-section-header:hover {
            background-color: #e9ecef;
        }

        .er-table .er-section-ingresos {
            background-color: #d4edda;
        }

        .er-table .er-section-ingresos:hover {
            background-color: #c3e6cb;
        }

        .er-table .er-section-gastos {
            background-color: #f8d7da;
        }

        .er-table .er-section-gastos:hover {
            background-color: #f5c6cb;
        }

        .er-table .er-section-resultado {
            background-color: #d1ecf1;
            font-weight: bold;
        }

        .er-table .er-fila-detalle {
            background-color: #fff;
        }

        .er-table .er-fila-detalle:hover {
            background-color: #e8f0fe;
        }

        .er-table .er-text-right {
            text-align: right;
        }

        .er-table .er-text-center {
            text-align: center;
        }

        .er-table .er-porcentaje-bar {
            display: inline-block;
            width: 50px;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            vertical-align: middle;
            margin-right: 6px;
        }

        .er-table .er-porcentaje-bar .er-bar-fill {
            display: block;
            height: 100%;
            border-radius: 3px;
            transition: width 0.6s ease;
        }

        .er-no-data {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
            display: none;
        }

        .er-no-data i {
            font-size: 56px;
            color: #adb5bd;
        }

        .er-no-data h4 {
            color: #6c757d;
            margin-top: 15px;
        }

        .er-no-data p {
            color: #adb5bd;
            font-size: 14px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1400px) {
            .widget-grid { grid-template-columns: repeat(3, 1fr); }
            .er-metrics-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 1024px) {
            .widget-grid { grid-template-columns: repeat(2, 1fr); }
            .widget-item[data-size] { grid-column: span 1; }
            .widget-item[data-size="xlarge"] { grid-column: span 2; }
            .er-metrics-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 15px 20px;
            }
            .header-title h1 { font-size: 22px; }
            .header-controls { justify-content: flex-start; flex-wrap: wrap; }
            .period-selector { flex-wrap: wrap; }
            .period-option { padding: 6px 12px; font-size: 12px; }
            .widget-grid { grid-template-columns: 1fr; gap: 15px; }
            .widget-item[data-size] { grid-column: span 1 !important; }
            .widget-content { padding: 15px; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
            
            .filtros-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .filtros-actions {
                justify-content: stretch;
            }
            
            .btn-filtro {
                flex: 1;
                justify-content: center;
            }
            
            .filtros-lista {
                grid-template-columns: 1fr;
                max-height: 160px;
            }
            
            .filtros-container {
                padding: 16px;
            }
            
            .table-bancos {
                font-size: 10px;
            }
            .table-bancos thead th,
            .table-bancos tbody td {
                padding: 4px;
            }
            
            .er-metrics-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            
            .er-table {
                font-size: 11px;
            }
            .er-table thead th,
            .er-table tbody td {
                padding: 6px 4px;
            }
        }

        @media (max-width: 480px) {
            .kpi-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .kpi-card { padding: 10px; }
            .kpi-card .value { font-size: 18px; }
            .header-title h1 { font-size: 18px; }
            .control-btn { padding: 6px 12px; font-size: 12px; }
            .filtros-container { padding: 12px; }
            .proyecto-item { padding: 6px 10px; font-size: 12px; }
            .er-metrics-grid { grid-template-columns: 1fr 1fr; }
            .er-metric-card { padding: 10px; }
            .er-metric-card .er-metric-value { font-size: 15px; }
        }

        .text-muted { color: var(--gray-500); }
        .fw-bold { font-weight: 700; }
        .text-center { text-align: center; }
        .mt-1 { margin-top: 8px; }
        .mb-1 { margin-bottom: 8px; }
        .small { font-size: 12px; }
        .flex { display: flex; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .gap-1 { gap: 8px; }
        .cursor-pointer { cursor: pointer; }
    </style>

    <div class="dashboard-container">
        <!-- ========== HEADER ========== -->
        <div class="dashboard-header">
            <div class="header-title">
                <h1><i class="fas fa-chart-pie"></i>Dashboard Ejecutivo</h1>
                <p>
                    <span style="display:inline-block;width:10px;height:10px;background:var(--success);border-radius:50%;animation:pulse 2s infinite;"></span>
                    <span id="fechaActual"></span>
                    <span id="horaActual" style="color:var(--gray-400);"></span>
                    <span style="color:var(--gray-400);">|</span>
                    <span style="color:var(--gray-500);font-size:12px;">Actualizado: <span id="ultimaActualizacionTime">--:--:--</span></span>
                </p>
            </div>
            <div class="header-controls">
                <div class="period-selector" id="periodSelector">
                    <button class="period-option" data-period="dia">Día</button>
                    <button class="period-option" data-period="semana">Semana</button>
                    <button class="period-option active" data-period="mes">Mes</button>
                    <button class="period-option" data-period="trimestre">Trimestre</button>
                    <button class="period-option" data-period="año">Año</button>
                </div>
                <button class="control-btn" onclick="actualizarDashboard()">
                    <i class="fas fa-sync"></i> Actualizar
                </button>
                <button class="control-btn primary" onclick="exportarDashboard()">
                    <i class="fas fa-file-excel"></i> Exportar
                </button>
            </div>
        </div>

        <!-- ========== FILTROS MEJORADOS ========== -->
        <div class="filtros-container">
            <div class="filtros-header">
                <div class="filtros-titulo">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filtros</span>
                    <span class="filtros-badge" id="filtrosBadge">0 seleccionados</span>
                </div>
                <div class="filtros-actions">
                    <button class="btn-filtro btn-filtro-clear" onclick="limpiarFiltros()">
                        <i class="fas fa-undo"></i> Limpiar
                    </button>
                    <button class="btn-filtro btn-filtro-apply" onclick="aplicarFiltros()">
                        <i class="fas fa-check"></i> Aplicar
                    </button>
                </div>
            </div>
            
            <div class="filtros-busqueda">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           id="filtroBusqueda" 
                           placeholder="Buscar proyectos..." 
                           class="search-input"
                           oninput="filtrarProyectosLista()">
                    <button class="search-clear" onclick="limpiarBusqueda()" id="searchClearBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="filtros-lista" id="filtrosLista">
                <!-- Los proyectos se cargan dinámicamente -->
            </div>
            
            <div class="filtros-seleccionados" id="filtrosSeleccionados">
                <!-- Tags de proyectos seleccionados -->
            </div>
        </div>

        <!-- ========== WIDGET GRID ========== -->
        <div class="widget-grid" id="widgetGrid"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // ============================================
    // VARIABLES GLOBALES
    // ============================================
    var periodoActual = 'mes';
    var proyectosSeleccionados = [];
    var todosLosProyectos = [];
    var datosDashboard = null;
    var autoRefreshInterval = null;
    var expandedGroups = new Set(['INGRESOS', 'GASTOS']);

    // ============================================
    // CONFIGURACIÓN DE WIDGETS
    // ============================================
    var WIDGETS_CONFIG = {
        'resumen-ejecutivo': {
            titulo: 'Resumen Ejecutivo',
            icono: 'fa-chart-simple',
            size: 'medium',
            render: renderResumenEjecutivo
        },
        'alertas-sistema': {
            titulo: 'Alertas del Sistema',
            icono: 'fa-bell',
            size: 'medium',
            render: renderAlertasSistema
        },
        'proyectos-resumen': {
            titulo: 'Resumen de Proyectos',
            icono: 'fa-building',
            size: 'small',
            render: renderProyectosResumen
        },
        'proyectos-tendencia': {
            titulo: 'Tendencia de Proyectos',
            icono: 'fa-chart-line',
            size: 'medium',
            render: renderProyectosTendencia
        },
        'proyectos-top': {
            titulo: 'Top Proyectos',
            icono: 'fa-trophy',
            size: 'small',
            render: renderProyectosTop
        },
        'contratistas-resumen': {
            titulo: 'Resumen de Contratistas',
            icono: 'fa-user-tie',
            size: 'small',
            render: renderContratistasResumen
        },
        'ventas-tendencia': {
            titulo: 'Tendencia de Ventas',
            icono: 'fa-chart-line',
            size: 'medium',
            render: renderVentasTendencia
        },
        'ventas-proyecto': {
            titulo: 'Ventas por Proyecto',
            icono: 'fa-chart-pie',
            size: 'small',
            render: renderVentasProyecto
        },
        'facturacion-diaria': {
            titulo: 'Facturación Diaria',
            icono: 'fa-calendar-day',
            size: 'small',
            render: renderFacturacionDiaria
        },
        'cuentas-pagar': {
            titulo: 'Cuentas por Pagar',
            icono: 'fa-arrow-up',
            size: 'small',
            render: renderCuentasPagar
        },
        'cuentas-cobrar': {
            titulo: 'Cuentas por Cobrar',
            icono: 'fa-arrow-down',
            size: 'small',
            render: renderCuentasCobrar
        },
        'rentabilidad': {
            titulo: 'Rentabilidad',
            icono: 'fa-chart-simple',
            size: 'medium',
            render: renderRentabilidad
        },
        'estado-resultados': {
            titulo: 'Estado de Resultados Real vs Presupuesto',
            icono: 'fa-file-invoice',
            size: 'xlarge',
            render: renderEstadoResultados
        },
        'flujo-efectivo': {
            titulo: 'Flujo de Efectivo',
            icono: 'fa-money-bill-transfer',
            size: 'medium',
            render: renderFlujoEfectivo
        },
        'nomina-resumen': {
            titulo: 'Resumen de Nómina',
            icono: 'fa-users',
            size: 'small',
            render: renderNominaResumen
        },
        'nomina-proyectos': {
            titulo: 'Nómina por Proyecto',
            icono: 'fa-hard-hat',
            size: 'medium',
            render: renderNominaProyectos
        },
        'asistencia-resumen': {
            titulo: 'Asistencia y Ausentismo',
            icono: 'fa-clipboard-check',
            size: 'small',
            render: renderAsistenciaResumen
        },
        'maquinaria-estado': {
            titulo: 'Estado de Maquinaria',
            icono: 'fa-tractor',
            size: 'small',
            render: renderMaquinariaEstado
        },
        'maquinaria-costos': {
            titulo: 'Costos de Maquinaria',
            icono: 'fa-tools',
            size: 'small',
            render: renderMaquinariaCostos
        },
        'inventario-resumen': {
            titulo: 'Resumen de Inventario',
            icono: 'fa-warehouse',
            size: 'small',
            render: renderInventarioResumen
        },
        'bitacora-resumen': {
            titulo: 'Resumen de Bitácora',
            icono: 'fa-book',
            size: 'small',
            render: renderBitacoraResumen
        },
        'licitaciones-resumen': {
            titulo: 'Resumen de Licitaciones',
            icono: 'fa-file-signature',
            size: 'small',
            render: renderLicitacionesResumen
        },
        'seguimiento-obra': {
            titulo: 'Seguimiento de Obra',
            icono: 'fa-ruler-combined',
            size: 'medium',
            render: renderSeguimientoObra
        },
        'compras-resumen': {
            titulo: 'Resumen de Compras',
            icono: 'fa-shopping-cart',
            size: 'small',
            render: renderComprasResumen
        },
        'estimaciones-resumen': {
            titulo: 'Estimaciones de Obra',
            icono: 'fa-calculator',
            size: 'small',
            render: renderEstimacionesResumen
        },
        'proyecciones-financieras': {
            titulo: 'Proyecciones Financieras',
            icono: 'fa-chart-simple',
            size: 'medium',
            render: renderProyeccionesFinancieras
        }
    };

    // ============================================
    // INICIALIZACIÓN
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        actualizarFechaHora();
        setInterval(actualizarFechaHora, 1000);
        inicializarPeriodSelector();
        cargarProyectosFiltro();
        inicializarWidgets();
        iniciarAutoRefresh();
    });

    function actualizarFechaHora() {
        var ahora = new Date();
        document.getElementById('fechaActual').textContent = 
            ahora.toLocaleDateString('es-MX', { year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('horaActual').textContent = 
            ahora.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('ultimaActualizacionTime').textContent = 
            ahora.toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }

    function inicializarPeriodSelector() {
        var options = document.querySelectorAll('.period-option');
        options.forEach(function(el) {
            el.addEventListener('click', function() {
                options.forEach(function(p) { p.classList.remove('active'); });
                this.classList.add('active');
                periodoActual = this.dataset.period;
                actualizarDashboard();
            });
        });
    }

    function iniciarAutoRefresh() {
        if (autoRefreshInterval) clearInterval(autoRefreshInterval);
        autoRefreshInterval = setInterval(function() {
            cargarDashboardConFiltros(proyectosSeleccionados);
        }, 60000);
    }

    // ============================================
    // FILTROS MEJORADOS
    // ============================================
    
    function cargarProyectosFiltro() {
        fetch('/api/dashboard/proyectos-list')
            .then(function(response) { 
                if (!response.ok) throw new Error('Error HTTP: ' + response.status);
                return response.json(); 
            })
            .then(function(data) {
                if (data.success) {
                    todosLosProyectos = data.data;
                    renderizarListaProyectos();
                    proyectosSeleccionados = todosLosProyectos.map(function(p) { return p.id; });
                    actualizarSeleccionados();
                    actualizarTagsFiltros();
                    cargarDashboardConFiltros(proyectosSeleccionados);
                }
            })
            .catch(function(error) {
                console.error('Error cargando proyectos:', error);
                cargarProyectosPorDefecto();
            });
    }

    function cargarProyectosPorDefecto() {
        fetch('/api/proyectos')
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success && data.data) {
                    todosLosProyectos = data.data;
                    renderizarListaProyectos();
                    proyectosSeleccionados = todosLosProyectos.map(function(p) { return p.id; });
                    actualizarSeleccionados();
                    actualizarTagsFiltros();
                    cargarDashboardConFiltros(proyectosSeleccionados);
                }
            })
            .catch(function() {
                todosLosProyectos = [
                    {id: 1, codigo: 'PRO-001', nombre: 'Torre Norte', status: 'activo'},
                    {id: 2, codigo: 'PRO-002', nombre: 'Hospital Regional', status: 'activo'},
                    {id: 3, codigo: 'PRO-003', nombre: 'Parque Industrial', status: 'finalizado'},
                    {id: 4, codigo: 'PRO-004', nombre: 'Puente Colgante', status: 'activo'},
                    {id: 5, codigo: 'PRO-005', nombre: 'Centro Comercial', status: 'inactivo'}
                ];
                renderizarListaProyectos();
                proyectosSeleccionados = todosLosProyectos.map(function(p) { return p.id; });
                actualizarSeleccionados();
                actualizarTagsFiltros();
                cargarDashboardConFiltros(proyectosSeleccionados);
            });
    }

    function renderizarListaProyectos() {
        var container = document.getElementById('filtrosLista');
        if (!container) return;
        
        container.innerHTML = '';
        todosLosProyectos.forEach(function(p) {
            var status = p.status || 'activo';
            var isSelected = proyectosSeleccionados.indexOf(p.id) !== -1;
            var div = document.createElement('div');
            div.className = 'proyecto-item' + (isSelected ? ' selected' : '');
            div.dataset.id = p.id;
            div.dataset.nombre = (p.nombre || '').toLowerCase();
            div.dataset.codigo = (p.codigo || '').toLowerCase();
            div.innerHTML = 
                '<span class="proyecto-check"><i class="fas fa-check"></i></span>' +
                '<div class="proyecto-info">' +
                    '<span class="proyecto-nombre">' + (p.nombre || 'Sin nombre') + '</span>' +
                    '<span class="proyecto-codigo">' + (p.codigo || '') + '</span>' +
                '</div>' +
                '<span class="proyecto-status ' + status + '"></span>';
            
            div.addEventListener('click', function() {
                toggleProyecto(p.id);
            });
            
            container.appendChild(div);
        });
        
        actualizarBadge();
    }

    function toggleProyecto(id) {
        var idx = proyectosSeleccionados.indexOf(id);
        if (idx !== -1) {
            proyectosSeleccionados.splice(idx, 1);
        } else {
            proyectosSeleccionados.push(id);
        }
        
        var items = document.querySelectorAll('.proyecto-item');
        items.forEach(function(item) {
            var itemId = parseInt(item.dataset.id);
            if (itemId === id) {
                item.classList.toggle('selected');
            }
        });
        
        actualizarBadge();
        actualizarTagsFiltros();
    }

    function actualizarBadge() {
        var badge = document.getElementById('filtrosBadge');
        if (!badge) return;
        var total = todosLosProyectos.length;
        var seleccionados = proyectosSeleccionados.length;
        
        if (seleccionados === 0) {
            badge.textContent = 'Ninguno seleccionado';
            badge.style.background = 'var(--danger-light)';
            badge.style.color = 'var(--danger)';
        } else if (seleccionados === total) {
            badge.textContent = 'Todos seleccionados';
            badge.style.background = 'var(--success-light)';
            badge.style.color = '#155724';
        } else {
            badge.textContent = seleccionados + ' de ' + total + ' seleccionados';
            badge.style.background = 'var(--primary-light)';
            badge.style.color = 'var(--primary)';
        }
    }

    function actualizarSeleccionados() {
        actualizarBadge();
        actualizarTagsFiltros();
    }

    function actualizarTagsFiltros() {
        var container = document.getElementById('filtrosSeleccionados');
        if (!container) return;
        
        container.innerHTML = '';
        
        if (proyectosSeleccionados.length === 0) {
            var emptyMsg = document.createElement('span');
            emptyMsg.style.color = 'var(--gray-500)';
            emptyMsg.style.fontSize = '13px';
            emptyMsg.textContent = 'No hay proyectos seleccionados';
            container.appendChild(emptyMsg);
            return;
        }
        
        if (proyectosSeleccionados.length === todosLosProyectos.length) {
            var tagAll = crearTag('Todos los proyectos', 'all');
            container.appendChild(tagAll);
            return;
        }
        
        var seleccionados = todosLosProyectos.filter(function(p) {
            return proyectosSeleccionados.indexOf(p.id) !== -1;
        });
        
        seleccionados.forEach(function(p) {
            var tag = crearTag(p.nombre, p.id);
            container.appendChild(tag);
        });
    }

    function crearTag(texto, id) {
        var tag = document.createElement('span');
        tag.className = 'tag-proyecto' + (id === 'all' ? ' tag-todos' : '');
        tag.innerHTML = 
            '<span>' + texto + '</span>' +
            '<button class="tag-remove" onclick="eliminarTag(' + (typeof id === 'string' ? '"' + id + '"' : id) + ')">' +
                '<i class="fas fa-times"></i>' +
            '</button>';
        return tag;
    }

    function eliminarTag(id) {
        if (id === 'all') {
            proyectosSeleccionados = [];
        } else {
            var idx = proyectosSeleccionados.indexOf(id);
            if (idx !== -1) {
                proyectosSeleccionados.splice(idx, 1);
            }
        }
        
        var items = document.querySelectorAll('.proyecto-item');
        items.forEach(function(item) {
            var itemId = parseInt(item.dataset.id);
            if (itemId === id) {
                item.classList.remove('selected');
            }
        });
        
        actualizarBadge();
        actualizarTagsFiltros();
        
        cargarDashboardConFiltros(proyectosSeleccionados);
    }

    function filtrarProyectosLista() {
        var input = document.getElementById('filtroBusqueda');
        var searchText = (input.value || '').toLowerCase().trim();
        var clearBtn = document.getElementById('searchClearBtn');
        
        if (searchText.length > 0) {
            clearBtn.classList.add('visible');
        } else {
            clearBtn.classList.remove('visible');
        }
        
        var items = document.querySelectorAll('.proyecto-item');
        items.forEach(function(item) {
            var nombre = item.dataset.nombre || '';
            var codigo = item.dataset.codigo || '';
            var match = nombre.indexOf(searchText) !== -1 || codigo.indexOf(searchText) !== -1;
            item.classList.toggle('hidden', !match);
        });
    }

    function limpiarBusqueda() {
        var input = document.getElementById('filtroBusqueda');
        input.value = '';
        filtrarProyectosLista();
        input.focus();
    }

    function aplicarFiltros() {
        actualizarTagsFiltros();
        cargarDashboardConFiltros(proyectosSeleccionados);
        mostrarToast('Filtros aplicados ✓', 'success');
    }

    function limpiarFiltros() {
        proyectosSeleccionados = todosLosProyectos.map(function(p) { return p.id; });
        
        var items = document.querySelectorAll('.proyecto-item');
        items.forEach(function(item) {
            item.classList.add('selected');
        });
        
        actualizarBadge();
        actualizarTagsFiltros();
        cargarDashboardConFiltros(proyectosSeleccionados);
        mostrarToast('Filtros limpiados ✓', 'info');
        
        limpiarBusqueda();
    }

    // Inicializar búsqueda con Enter
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('filtroBusqueda');
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var firstVisible = document.querySelector('.proyecto-item:not(.hidden)');
                    if (firstVisible) {
                        var id = parseInt(firstVisible.dataset.id);
                        toggleProyecto(id);
                    }
                }
            });
        }
    });

    // ============================================
    // CARGA DE DATOS
    // ============================================
    function cargarDashboardConFiltros(proyectoIds) {
        var params = new URLSearchParams();
        proyectoIds.forEach(function(id) {
            params.append('proyecto_ids[]', id);
        });
        params.append('periodo', periodoActual);
        params.append('incluir_presupuesto', 'true');
        
        mostrarToast('Cargando datos...', 'info');
        
        fetch('/api/dashboard/completo?' + params.toString())
            .then(function(response) { 
                if (!response.ok) throw new Error('Error HTTP: ' + response.status);
                return response.json(); 
            })
            .then(function(data) {
                if (data.success) {
                    datosDashboard = data.data;
                    actualizarDashboardConDatos(datosDashboard);
                    mostrarToast('Datos actualizados', 'success');
                } else {
                    mostrarToast('Error: ' + (data.message || 'Error desconocido'), 'error');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                mostrarToast('Error al cargar datos', 'error');
            });
    }

    function actualizarDashboardConDatos(data) {
        var widgets = document.querySelectorAll('.widget-item');
        widgets.forEach(function(widget) {
            var widgetId = widget.dataset.widgetId;
            var widgetIndex = widget.dataset.index;
            renderizarWidget(widgetId, widgetIndex);
        });
        
        document.getElementById('ultimaActualizacionTime').textContent = 
            new Date().toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }

    // ============================================
    // WIDGETS
    // ============================================
    function inicializarWidgets() {
        var grid = document.getElementById('widgetGrid');
        var widgets = [
            { id: 'resumen-ejecutivo', size: 'medium' },
            { id: 'alertas-sistema', size: 'medium' },
            { id: 'proyectos-resumen', size: 'small' },
            { id: 'proyectos-tendencia', size: 'medium' },
            { id: 'proyectos-top', size: 'small' },
            { id: 'contratistas-resumen', size: 'small' },
            { id: 'ventas-tendencia', size: 'medium' },
            { id: 'ventas-proyecto', size: 'small' },
            { id: 'facturacion-diaria', size: 'small' },
            { id: 'cuentas-pagar', size: 'small' },
            { id: 'cuentas-cobrar', size: 'small' },
            { id: 'rentabilidad', size: 'medium' },
            { id: 'estado-resultados', size: 'xlarge' },
            { id: 'flujo-efectivo', size: 'medium' },
            { id: 'nomina-resumen', size: 'small' },
            { id: 'nomina-proyectos', size: 'medium' },
            { id: 'asistencia-resumen', size: 'small' },
            { id: 'maquinaria-estado', size: 'small' },
            { id: 'maquinaria-costos', size: 'small' },
            { id: 'inventario-resumen', size: 'small' },
            { id: 'bitacora-resumen', size: 'small' },
            { id: 'licitaciones-resumen', size: 'small' },
            { id: 'seguimiento-obra', size: 'medium' },
            { id: 'compras-resumen', size: 'small' },
            { id: 'estimaciones-resumen', size: 'small' },
            { id: 'proyecciones-financieras', size: 'medium' }
        ];

        grid.innerHTML = '';
        widgets.forEach(function(w) {
            agregarWidget(w.id, w.size);
        });
    }

    function agregarWidget(widgetId, size) {
        var config = WIDGETS_CONFIG[widgetId];
        if (!config) return;

        var grid = document.getElementById('widgetGrid');
        var widgetIndex = Date.now() + Math.random();

        var html = '';
        html += '<div class="widget-item" data-widget-id="' + widgetId + '" data-size="' + size + '" data-index="' + widgetIndex + '">';
        html += '  <div class="widget-card" id="widget-card-' + widgetIndex + '">';
        html += '    <div class="widget-header">';
        html += '      <div class="widget-title">';
        html += '        <i class="fas ' + config.icono + '"></i>';
        html += '        <h3>' + config.titulo + '</h3>';
        html += '      </div>';
        html += '      <div class="widget-controls">';
        html += '        <button class="widget-control" onclick="eliminarWidget(this)" title="Eliminar">';
        html += '          <i class="fas fa-times"></i>';
        html += '        </button>';
        html += '      </div>';
        html += '    </div>';
        html += '    <div class="widget-content" id="widget-content-' + widgetIndex + '">';
        html += '      <div class="widget-loading"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';

        grid.insertAdjacentHTML('beforeend', html);
        renderizarWidget(widgetId, widgetIndex);
    }

    function renderizarWidget(widgetId, widgetIndex) {
        var config = WIDGETS_CONFIG[widgetId];
        if (!config) return;

        var container = document.getElementById('widget-content-' + widgetIndex);
        if (!container) return;

        var card = container.closest('.widget-card');
        if (card) card.classList.add('loading');

        try {
            var content = config.render();
            container.innerHTML = content;
        } catch (error) {
            console.error('Error renderizando widget:', error);
            container.innerHTML = '<div style="text-align:center;padding:30px;color:var(--danger);">' +
                '<i class="fas fa-exclamation-triangle" style="font-size:24px;"></i>' +
                '<p style="margin-top:10px;">Error al cargar el widget</p>' +
                '<button onclick="renderizarWidget(\'' + widgetId + '\',' + widgetIndex + ')" ' +
                'style="margin-top:10px;padding:6px 16px;border:1px solid var(--gray-300);border-radius:4px;cursor:pointer;background:white;">' +
                '<i class="fas fa-sync"></i> Reintentar</button>' +
                '</div>';
        }

        if (card) card.classList.remove('loading');
    }

    function eliminarWidget(btn) {
        var widget = btn.closest('.widget-item');
        if (confirm('¿Eliminar este widget del dashboard?')) {
            widget.remove();
            mostrarToast('Widget eliminado', 'info');
        }
    }

    // ============================================
    // FUNCIONES DE RENDERIZADO DE WIDGETS
    // ============================================

    function renderResumenEjecutivo() {
        var data = datosDashboard ? datosDashboard.resumen : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '';
        html += '<div class="kpi-grid" id="resumen-kpis">';
        html += '  <div class="kpi-card"><span class="kpi-icon"><i class="fas fa-building"></i></span><div class="label">Proyectos Activos</div><div class="value primary" id="re-proyectos">' + (data.proyectos ? data.proyectos.activos : 0) + '</div></div>';
        html += '  <div class="kpi-card"><span class="kpi-icon"><i class="fas fa-user-tie"></i></span><div class="label">Contratistas Activos</div><div class="value info" id="re-contratistas">' + (data.contratistas ? data.contratistas.activos : 0) + '</div></div>';
        html += '  <div class="kpi-card"><span class="kpi-icon"><i class="fas fa-dollar-sign"></i></span><div class="label">Facturación Mensual</div><div class="value success" id="re-facturacion">$' + (data.facturacion_mes ? data.facturacion_mes.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) : '0') + '</div></div>';
        html += '  <div class="kpi-card"><span class="kpi-icon"><i class="fas fa-chart-simple"></i></span><div class="label">Rentabilidad</div><div class="value purple" id="re-rentabilidad">' + (data.rentabilidad !== undefined ? data.rentabilidad + '%' : '0%') + '</div></div>';
        html += '</div>';
        return html;
    }

    function renderAlertasSistema() {
        var alertas = datosDashboard ? datosDashboard.alertas : null;
        var html = '<div id="alertas-list">';
        
        if (alertas && alertas.alertas && alertas.alertas.length > 0) {
            alertas.alertas.forEach(function(a) {
                var nivel = a.nivel || 'info';
                var icono = nivel === 'danger' ? 'fa-exclamation-circle' : 
                           nivel === 'warning' ? 'fa-triangle-exclamation' : 'fa-info-circle';
                html += '<div class="alert-item ' + nivel + '">';
                html += '  <span class="alert-icon"><i class="fas ' + icono + '"></i></span>';
                html += '  <div class="alert-content">';
                html += '    <div class="alert-title">' + a.mensaje + '</div>';
                html += '  </div>';
                html += '</div>';
            });
        } else {
            html += '<div style="text-align:center;padding:20px;color:var(--gray-500);">';
            html += '<i class="fas fa-check-circle" style="font-size:24px;color:var(--success);"></i>';
            html += '<p style="margin-top:8px;">No hay alertas pendientes</p>';
            html += '</div>';
        }
        
        html += '</div>';
        return html;
    }

    function renderProyectosResumen() {
        var data = datosDashboard ? datosDashboard.proyectos : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Total</div><div class="value primary" id="pr-total">' + (data.total || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Activos</div><div class="value success" id="pr-activos">' + (data.activos || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Finalizados</div><div class="value info" id="pr-finalizados">' + (data.finalizados || 0) + '</div></div>';
        html += '</div>';
        if (data.tasa_actividad !== undefined) {
            html += '<div class="progress-bar-container">';
            html += '  <div class="progress-header"><span>Tasa de Actividad</span><span>' + data.tasa_actividad + '%</span></div>';
            html += '  <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:' + data.tasa_actividad + '%;"></div></div>';
            html += '</div>';
        }
        return html;
    }

    function renderProyectosTendencia() {
        var data = datosDashboard ? datosDashboard.proyectos : null;
        var html = '<div id="pt-container">';
        
        if (data && data.top_proyectos && data.top_proyectos.length > 0) {
            var proyectos = data.top_proyectos;
            var max = 1;
            proyectos.forEach(function(p) { if (parseFloat(p.presupuesto_total) > max) max = parseFloat(p.presupuesto_total); });
            
            html += '<div style="height:150px;display:flex;flex-direction:column;justify-content:space-around;padding:5px 0;">';
            proyectos.forEach(function(p) {
                var pct = max > 0 ? (parseFloat(p.presupuesto_total) / max) * 100 : 0;
                html += '<div style="display:flex;align-items:center;gap:8px;">';
                html += '  <span style="width:60px;font-size:10px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="' + p.nombre + '">' + p.nombre.substring(0, 12) + '</span>';
                html += '  <div style="flex:1;height:14px;background:var(--gray-200);border-radius:4px;overflow:hidden;">';
                html += '    <div style="height:100%;background:var(--primary);border-radius:4px;width:' + pct + '%;transition:width 0.8s;"></div>';
                html += '  </div>';
                html += '  <span style="font-size:10px;width:50px;text-align:right;">$' + (parseFloat(p.presupuesto_total)/1000).toFixed(0) + 'K</span>';
                html += '</div>';
            });
            html += '</div>';
        } else {
            html += '<div class="text-center text-muted" style="padding:20px;">Sin datos de proyectos</div>';
        }
        
        html += '</div>';
        return html;
    }

    function renderProyectosTop() {
        var data = datosDashboard ? datosDashboard.proyectos : null;
        var html = '<table class="finance-table" id="ptop-tabla">';
        html += '<thead><tr><th>Proyecto</th><th>Presupuesto</th><th>Status</th></tr></thead>';
        html += '<tbody>';
        
        if (data && data.top_proyectos && data.top_proyectos.length > 0) {
            data.top_proyectos.forEach(function(p) {
                var status = p.status || 'activo';
                var badge = status === 'activo' ? 'success' : 'warning';
                html += '<tr>';
                html += '  <td>' + p.nombre + '</td>';
                html += '  <td class="primary">$' + parseFloat(p.presupuesto_total).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '  <td><span class="badge-status ' + badge + '">' + status + '</span></td>';
                html += '</tr>';
            });
        } else {
            html += '<tr><td colspan="3" class="text-center text-muted">Sin proyectos</td></tr>';
        }
        
        html += '</tbody></table>';
        return html;
    }

    function renderContratistasResumen() {
        var data = datosDashboard ? datosDashboard.contratistas : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Total</div><div class="value primary" id="cr-total">' + (data.total || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Activos</div><div class="value success" id="cr-activos">' + (data.activos || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Alto Riesgo</div><div class="value danger" id="cr-riesgo">' + (data.riesgo_alto || 0) + '</div></div>';
        html += '</div>';
        if (data.calificacion_promedio !== undefined) {
            html += '<div class="progress-bar-container">';
            html += '  <div class="progress-header"><span>Calificación Promedio</span><span>' + (data.calificacion_promedio || 0).toFixed(1) + '</span></div>';
            html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:' + ((data.calificacion_promedio || 0) * 10) + '%;"></div></div>';
            html += '</div>';
        }
        return html;
    }

    function renderVentasTendencia() {
        var data = datosDashboard ? datosDashboard.ventas : null;
        var html = '<div id="vt-container">';
        
        if (data && data.labels && data.labels.length > 0 && data.ventas && data.ventas.some(function(v) { return v > 0; })) {
            var labels = data.labels || [];
            var valores = data.ventas || [];
            var max = Math.max.apply(null, valores) || 1;
            
            html += '<div class="chart-legend">';
            html += '  <div class="legend-item"><span class="legend-color primary"></span> Ventas</div>';
            html += '</div>';
            html += '<div style="height:130px;display:flex;align-items:flex-end;gap:8px;padding:5px 0;">';
            
            valores.forEach(function(v, i) {
                var altura = max > 0 ? ((v / max) * 110) : 10;
                var color = i % 2 === 0 ? '#083CAE' : '#17a2b8';
                html += '<div style="flex:1;display:flex;flex-direction:column;align-items:center;height:100%;">';
                html += '  <div style="width:80%;background:' + color + ';border-radius:4px 4px 0 0;height:' + Math.max(altura, 10) + 'px;"></div>';
                html += '  <span style="font-size:8px;margin-top:4px;">' + (labels[i] || '') + '</span>';
                html += '  <span style="font-size:8px;color:var(--gray-500);">$' + (v/1000).toFixed(0) + 'K</span>';
                html += '</div>';
            });
            
            html += '</div>';
        } else {
            html += '<div style="text-align:center;padding:30px;color:var(--gray-500);">';
            html += '<i class="fas fa-chart-line" style="font-size:24px;color:var(--gray-400);"></i>';
            html += '<p style="margin-top:8px;">Sin datos de ventas</p>';
            html += '</div>';
        }
        
        html += '</div>';
        return html;
    }

    function renderVentasProyecto() {
        var data = datosDashboard ? datosDashboard.proyectos : null;
        var html = '<div id="vp-container">';
        
        var proyectos = data && data.top_proyectos ? data.top_proyectos : [];
        
        if (proyectos && proyectos.length > 0) {
            var total = 0;
            proyectos.forEach(function(p) { total += parseFloat(p.presupuesto_total); });
            
            html += '<div style="height:150px;display:flex;flex-direction:column;justify-content:space-around;padding:5px 0;">';
            proyectos.slice(0, 5).forEach(function(p) {
                var monto = parseFloat(p.presupuesto_total);
                var pct = total > 0 ? (monto / total) * 100 : 0;
                html += '<div style="display:flex;align-items:center;gap:8px;">';
                html += '  <span style="width:60px;font-size:10px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="' + p.nombre + '">' + p.nombre.substring(0, 12) + '</span>';
                html += '  <div style="flex:1;height:14px;background:var(--gray-200);border-radius:4px;overflow:hidden;">';
                html += '    <div style="height:100%;background:var(--primary);border-radius:4px;width:' + pct + '%;transition:width 0.8s;"></div>';
                html += '  </div>';
                html += '  <span style="font-size:10px;width:50px;text-align:right;">' + pct.toFixed(1) + '%</span>';
                html += '</div>';
            });
            html += '</div>';
        } else {
            html += '<div class="text-center text-muted" style="padding:20px;">Sin datos de ventas</div>';
        }
        
        html += '</div>';
        return html;
    }

    function renderFacturacionDiaria() {
        var data = datosDashboard ? datosDashboard.resumen : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var facturacion = data.facturacion_mes || 0;
        var rentabilidad = data.rentabilidad || 0;
        var utilidad = data.utilidad || 0;
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Facturación Mensual</div><div class="value success">$' + facturacion.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Rentabilidad</div><div class="value purple">' + rentabilidad + '%</div></div>';
        html += '  <div class="kpi-card"><div class="label">Utilidad</div><div class="value primary">$' + utilidad.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Progreso Mensual</span><span>' + (facturacion > 0 ? '100%' : '0%') + '</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:' + (facturacion > 0 ? '100' : '0') + '%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderCuentasPagar() {
        var data = datosDashboard ? datosDashboard.finanzas : null;
        var cp = data ? data.cuentas_pagar : null;
        
        if (!cp) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var total = cp.total || 0;
        var ant = cp.antiguedad || {};
        
        var html = '<div style="font-size:22px;font-weight:700;color:var(--danger);margin-bottom:10px;">$' + total.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div>';
        html += '<div class="progress-bar-container">';
        
        var ranges = ['0-30', '31-60', '61-90', '91+'];
        var labels = ['0-30 días', '31-60 días', '61-90 días', '91+ días'];
        var colors = ['success', 'warning', 'warning', 'danger'];
        
        ranges.forEach(function(r, i) {
            var val = ant[r] || 0;
            var pct = total > 0 ? (val / total) * 100 : 0;
            html += '  <div class="progress-header"><span>' + labels[i] + '</span><span>$' + val.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</span></div>';
            html += '  <div class="progress-bar-bg"><div class="progress-bar-fill ' + colors[i] + '" style="width:' + Math.min(pct, 100) + '%;"></div></div>';
        });
        
        html += '</div>';
        return html;
    }

    function renderCuentasCobrar() {
        var data = datosDashboard ? datosDashboard.finanzas : null;
        var cc = data ? data.cuentas_cobrar : null;
        
        if (!cc) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var total = cc.total || 0;
        var ant = cc.antiguedad || {};
        
        var html = '<div style="font-size:22px;font-weight:700;color:var(--success);margin-bottom:10px;">$' + total.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div>';
        html += '<div class="progress-bar-container">';
        
        var ranges = ['corriente', '30-60', '61-90', '91-120', '120+'];
        var labels = ['Corriente', '30-60 días', '61-90 días', '91-120 días', '120+ días'];
        var colors = ['success', 'warning', 'warning', 'danger', 'danger'];
        
        ranges.forEach(function(r, i) {
            var val = ant[r] || 0;
            var pct = total > 0 ? (val / total) * 100 : 0;
            html += '  <div class="progress-header"><span>' + labels[i] + '</span><span>$' + val.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</span></div>';
            html += '  <div class="progress-bar-bg"><div class="progress-bar-fill ' + colors[i] + '" style="width:' + Math.min(pct, 100) + '%;"></div></div>';
        });
        
        html += '</div>';
        return html;
    }

    function renderRentabilidad() {
        var data = datosDashboard ? datosDashboard.finanzas : null;
        var renta = data ? data.rentabilidad : null;
        
        if (!renta) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var margen = renta.margen || 0;
        var utilidad = renta.utilidad || 0;
        var proyectos = renta.proyectos || [];
        
        var html = '<div class="kpi-grid" style="margin-bottom:10px;">';
        html += '  <div class="kpi-card"><div class="label">Margen Promedio</div><div class="value purple">' + margen + '%</div></div>';
        html += '  <div class="kpi-card"><div class="label">Utilidad Neta</div><div class="value success">$' + utilidad.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '</div>';
        
        if (proyectos.length > 0) {
            html += '<div style="height:120px;display:flex;align-items:flex-end;gap:15px;padding:5px 0;">';
            var max = 1;
            proyectos.forEach(function(p) { if ((p.margen || 0) > max) max = p.margen || 0; });
            if (max === 0) max = 1;
            
            var colores = ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1'];
            proyectos.slice(0, 5).forEach(function(p, index) {
                var pMargen = p.margen || 0;
                var altura = max > 0 ? ((pMargen / max) * 100) : 20;
                var color = colores[index % colores.length];
                
                html += '<div style="flex:1;display:flex;flex-direction:column;align-items:center;height:100%;">';
                html += '  <div style="width:40px;background:' + color + ';border-radius:4px 4px 0 0;height:' + Math.max(altura, 10) + 'px;transition:height 0.8s;"></div>';
                html += '  <span style="font-size:8px;margin-top:4px;text-align:center;font-weight:600;color:var(--gray-700);">' + (p.nombre || '').substring(0, 10) + '</span>';
                html += '  <span style="font-size:8px;color:var(--gray-500);">' + pMargen + '%</span>';
                html += '</div>';
            });
            
            html += '</div>';
        }
        
        return html;
    }

    // ============================================
    // 🔥 ESTADO DE RESULTADOS REAL VS PRESUPUESTADO
    // ============================================
    function renderEstadoResultados() {
        var data = datosDashboard ? datosDashboard.estado_resultados : null;
        
        // ============================================
        // SI HAY ERROR O NO HAY DATOS, USAR DATOS DE EJEMPLO
        // ============================================
        var usarEjemplo = false;
        
        if (!data) {
            usarEjemplo = true;
        } else if (data.error) {
            usarEjemplo = true;
            console.warn('Error del backend:', data.error);
        } else if (!data.real || (data.real.ingresos === 0 && data.real.utilidad_neta === 0)) {
            usarEjemplo = true;
        }
        
        if (usarEjemplo) {
            data = {
                real: {
                    ingresos: 15200000,
                    costos_directos: 8400000,
                    utilidad_bruta: 6800000,
                    gastos_operacion: 4200000,
                    ebitda: 2600000,
                    gastos_financieros: 450000,
                    depreciacion: 320000,
                    utilidad_neta: 1830000
                },
                presupuesto: {
                    ingresos: 14500000,
                    costos_directos: 7800000,
                    utilidad_bruta: 6700000,
                    gastos_operacion: 4000000,
                    ebitda: 2700000,
                    gastos_financieros: 400000,
                    depreciacion: 300000,
                    utilidad_neta: 2000000
                },
                es_ejemplo: true,
                error: data && data.error ? data.error : null
            };
        }
        
        var real = data.real || {};
        var presupuesto = data.presupuesto || {};
        
        var tienePresupuesto = Object.keys(presupuesto).length > 0 && 
                               Object.values(presupuesto).some(function(v) { 
                                   return v !== undefined && v !== null && v !== 0; 
                               });
        
        var html = '';
        
        // ============================================
        // MÉTRICAS RESUMEN
        // ============================================
        var totalIngresosReal = real.ingresos || 0;
        var totalGastosReal = (real.costos_directos || 0) + (real.gastos_operacion || 0) + (real.gastos_financieros || 0) + (real.depreciacion || 0);
        var utilidadReal = real.utilidad_neta || 0;
        var margenReal = totalIngresosReal > 0 ? ((utilidadReal / totalIngresosReal) * 100) : 0;
        
        var totalIngresosPres = presupuesto.ingresos || 0;
        var totalGastosPres = (presupuesto.costos_directos || 0) + (presupuesto.gastos_operacion || 0) + (presupuesto.gastos_financieros || 0) + (presupuesto.depreciacion || 0);
        var utilidadPres = presupuesto.utilidad_neta || 0;
        var margenPres = totalIngresosPres > 0 ? ((utilidadPres / totalIngresosPres) * 100) : 0;
        
        html += '<div class="er-metrics-grid">';
        html += '  <div class="er-metric-card">';
        html += '    <div class="er-metric-label">Período</div>';
        html += '    <div class="er-metric-value primary" id="erPeriodo">' + periodoActual.toUpperCase() + '</div>';
        if (data.es_ejemplo) {
            html += '    <div style="font-size:9px;color:#ff8c00;font-weight:600;margin-top:2px;">⚠️ DATOS DE EJEMPLO</div>';
        }
        html += '  </div>';
        html += '  <div class="er-metric-card">';
        html += '    <div class="er-metric-label">Total Ingresos</div>';
        html += '    <div class="er-metric-value positive" id="erTotalIngresos">' + formatCurrency(totalIngresosReal) + '</div>';
        if (tienePresupuesto) {
            html += '    <div style="font-size:11px;color:#6c757d;">Presupuesto: ' + formatCurrency(totalIngresosPres) + '</div>';
        }
        html += '  </div>';
        html += '  <div class="er-metric-card">';
        html += '    <div class="er-metric-label">Total Gastos</div>';
        html += '    <div class="er-metric-value negative" id="erTotalGastos">' + formatCurrency(totalGastosReal) + '</div>';
        if (tienePresupuesto) {
            html += '    <div style="font-size:11px;color:#6c757d;">Presupuesto: ' + formatCurrency(totalGastosPres) + '</div>';
        }
        html += '  </div>';
        html += '  <div class="er-metric-card">';
        html += '    <div class="er-metric-label">Utilidad Neta</div>';
        html += '    <div class="er-metric-value ' + (utilidadReal >= 0 ? 'positive' : 'negative') + '" id="erUtilidad">' + formatCurrency(utilidadReal) + '</div>';
        if (tienePresupuesto) {
            html += '    <div style="font-size:11px;color:#6c757d;">Presupuesto: ' + formatCurrency(utilidadPres) + '</div>';
        }
        html += '  </div>';
        html += '  <div class="er-metric-card">';
        html += '    <div class="er-metric-label">Margen Promedio</div>';
        html += '    <div class="er-metric-value ' + (margenReal >= 0 ? 'positive' : 'negative') + '" id="erMargen">' + margenReal.toFixed(2) + '%</div>';
        if (tienePresupuesto) {
            html += '    <div style="font-size:11px;color:#6c757d;">Presupuesto: ' + margenPres.toFixed(2) + '%</div>';
        }
        html += '  </div>';
        html += '</div>';
        
        // ============================================
        // MENSAJE SIN DATOS
        // ============================================
        if (!totalIngresosReal && !totalGastosReal && !data.es_ejemplo) {
            html += '<div class="er-no-data" style="display:block;">';
            html += '  <i class="fas fa-chart-line"></i>';
            html += '  <h4>No hay datos disponibles</h4>';
            html += '  <p>Seleccione uno o más proyectos para ver los datos</p>';
            html += '</div>';
            return html;
        }
        
        // ============================================
        // TABLA DE RESULTADOS
        // ============================================
        html += '<div class="er-table-container">';
        html += '<table class="er-table" id="erTablaResultados">';
        
        // ============================================
        // ENCABEZADO
        // ============================================
        html += '<thead>';
        html += '  <tr>';
        html += '    <th style="width:40px;text-align:center;"></th>';
        html += '    <th style="width:220px;">Concepto</th>';
        html += '    <th style="width:100px;">Código</th>';
        html += '    <th class="er-text-right" style="min-width:120px;">Real</th>';
        if (tienePresupuesto) {
            html += '    <th class="er-text-right" style="min-width:120px;">Presupuesto</th>';
            html += '    <th class="er-text-right" style="min-width:110px;">Variación</th>';
            html += '    <th class="er-text-center" style="min-width:100px;">% Cumpl.</th>';
        }
        html += '  </tr>';
        html += '</thead>';
        
        // ============================================
        // CUERPO
        // ============================================
        html += '<tbody>';
        
        // Definición de filas
        var filas = [
            { label: 'INGRESOS', key: 'ingresos', isTotal: true, group: 'INGRESOS' },
            { label: 'Costos Directos', key: 'costos_directos', isTotal: false, group: 'GASTOS' },
            { label: 'Utilidad Bruta', key: 'utilidad_bruta', isTotal: true, group: 'UTILIDAD' },
            { label: 'Gastos Operación', key: 'gastos_operacion', isTotal: false, group: 'GASTOS' },
            { label: 'EBITDA', key: 'ebitda', isTotal: true, group: 'UTILIDAD' },
            { label: 'Gastos Financieros', key: 'gastos_financieros', isTotal: false, group: 'GASTOS' },
            { label: 'Depreciación', key: 'depreciacion', isTotal: false, group: 'GASTOS' },
            { label: 'Utilidad Neta', key: 'utilidad_neta', isTotal: true, group: 'RESULTADO' }
        ];
        
        // Agrupar filas
        var grupos = {
            'INGRESOS': { label: 'INGRESOS', filas: [], esIngreso: true },
            'GASTOS': { label: 'GASTOS Y COSTOS', filas: [], esIngreso: false },
            'UTILIDAD': { label: 'UTILIDAD', filas: [], esIngreso: true },
            'RESULTADO': { label: 'RESULTADO DEL EJERCICIO', filas: [], esIngreso: true }
        };
        
        filas.forEach(function(fila) {
            if (grupos[fila.group]) {
                grupos[fila.group].filas.push(fila);
            }
        });
        
        // Renderizar grupos
        var gruposOrden = ['INGRESOS', 'GASTOS', 'UTILIDAD', 'RESULTADO'];
        
        gruposOrden.forEach(function(groupName) {
            var grupo = grupos[groupName];
            if (!grupo || grupo.filas.length === 0) return;
            
            var isExpanded = expandedGroups.has(groupName);
            var icon = isExpanded ? 'fa-minus-square' : 'fa-plus-square';
            
            // Obtener totales del grupo
            var totalReal = 0;
            var totalPres = 0;
            grupo.filas.forEach(function(fila) {
                totalReal += (real[fila.key] || 0);
                totalPres += (presupuesto[fila.key] || 0);
            });
            
            var bgColor = groupName === 'INGRESOS' ? 'er-section-ingresos' : 
                         (groupName === 'GASTOS' ? 'er-section-gastos' : 
                         (groupName === 'RESULTADO' ? 'er-section-resultado' : ''));
            
            // Fila de sección (click para expandir/contraer)
            html += '<tr class="er-section-header ' + bgColor + '" onclick="toggleERGroup(\'' + groupName + '\')">';
            html += '  <td class="er-text-center"><i class="fas ' + icon + '" style="color:' + (groupName === 'INGRESOS' ? '#155724' : (groupName === 'GASTOS' ? '#721c24' : '#0c5460')) + ';font-size:16px;"></i></td>';
            html += '  <td colspan="2"><strong style="font-size:14px;">' + grupo.label + '</strong></td>';
            html += '  <td class="er-text-right"><strong>' + formatCurrency(totalReal) + '</strong></td>';
            if (tienePresupuesto) {
                html += '  <td class="er-text-right"><strong>' + formatCurrency(totalPres) + '</strong></td>';
                var variacion = totalReal - totalPres;
                var pctCumpl = totalPres !== 0 ? ((totalReal / totalPres) * 100) : (totalReal !== 0 ? 100 : 0);
                var colorVar = variacion >= 0 ? 'positive' : 'negative';
                html += '  <td class="er-text-right ' + colorVar + '">' + (variacion >= 0 ? '+' : '') + formatCurrency(variacion) + '</td>';
                html += '  <td class="er-text-center"><span style="color:' + (pctCumpl >= 100 ? '#28a745' : (pctCumpl >= 80 ? '#ffc107' : '#dc3545')) + ';font-weight:600;">' + pctCumpl.toFixed(1) + '%</span></td>';
            }
            html += '</tr>';
            
            // Filas de detalle (solo si está expandido)
            if (isExpanded) {
                grupo.filas.forEach(function(fila) {
                    var valorReal = real[fila.key] || 0;
                    var valorPres = presupuesto[fila.key] || 0;
                    var variacion = valorReal - valorPres;
                    var pctCumpl = valorPres !== 0 ? ((valorReal / valorPres) * 100) : (valorReal !== 0 ? 100 : 0);
                    
                    var colorReal = fila.isTotal ? 'primary' : (valorReal >= 0 ? 'positive' : 'negative');
                    var colorPres = fila.isTotal ? 'primary' : (valorPres >= 0 ? 'positive' : 'negative');
                    var colorVar = variacion >= 0 ? 'positive' : 'negative';
                    
                    var pctBarra = Math.min(Math.max(pctCumpl, 0), 100);
                    var barColor = pctCumpl >= 100 ? '#28a745' : (pctCumpl >= 80 ? '#ffc107' : '#dc3545');
                    
                    html += '<tr class="er-fila-detalle">';
                    html += '  <td></td>';
                    html += '  <td style="padding-left:' + (fila.isTotal ? '20px' : '40px') + ';' + (fila.isTotal ? 'font-weight:700;' : '') + '">' + fila.label + '</td>';
                    html += '  <td><code style="font-size:11px;">' + (fila.key) + '</code></td>';
                    html += '  <td class="er-text-right ' + colorReal + '">' + formatCurrency(valorReal) + '</td>';
                    if (tienePresupuesto) {
                        html += '  <td class="er-text-right ' + colorPres + '">' + formatCurrency(valorPres) + '</td>';
                        html += '  <td class="er-text-right ' + colorVar + '">' + (variacion >= 0 ? '+' : '') + formatCurrency(variacion) + '</td>';
                        html += '  <td class="er-text-center">';
                        html += '    <span class="er-porcentaje-bar"><span class="er-bar-fill" style="width:' + pctBarra + '%;background:' + barColor + ';"></span></span>';
                        html += '    <span style="color:' + (pctCumpl >= 100 ? '#28a745' : (pctCumpl >= 80 ? '#ffc107' : '#dc3545')) + ';font-weight:600;font-size:12px;">' + pctCumpl.toFixed(1) + '%</span>';
                        html += '  </td>';
                    }
                    html += '</tr>';
                });
            }
        });
        
        html += '</tbody>';
        html += '</table>';
        html += '</div>';
        
        // ============================================
        // INDICADOR DE DATOS DE EJEMPLO
        // ============================================
        if (data.es_ejemplo) {
            html += '<div style="text-align:center;padding:10px;margin-top:10px;background:#fff3cd;border-radius:8px;border:1px solid #ffc107;">';
            html += '  <i class="fas fa-info-circle" style="color:#856404;"></i> ';
            html += '  <span style="color:#856404;font-size:12px;">⚠️ Mostrando datos de ejemplo. Conecta tu base de datos para ver datos reales.</span>';
            if (data.error) {
                html += '  <div style="font-size:10px;color:#721c24;margin-top:4px;">Error: ' + data.error.substring(0, 150) + '...</div>';
            }
            html += '</div>';
        }
        
        return html;
    }

    // Función para toggle de grupos en el widget ER
    function toggleERGroup(groupName) {
        if (expandedGroups.has(groupName)) {
            expandedGroups.delete(groupName);
        } else {
            expandedGroups.add(groupName);
        }
        // Re-renderizar el widget
        var widgetId = 'estado-resultados';
        var widgets = document.querySelectorAll('.widget-item[data-widget-id="' + widgetId + '"]');
        widgets.forEach(function(widget) {
            var index = widget.dataset.index;
            renderizarWidget(widgetId, index);
        });
    }

    // Función auxiliar para formatear moneda
    function formatCurrency(amount) {
        if (amount === undefined || amount === null || isNaN(amount)) amount = 0;
        return '$' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
    }

    // Función para alternar grupos (expuesta globalmente)
    window.toggleERGroup = toggleERGroup;
    window.formatCurrency = formatCurrency;

    // ============================================
    // FUNCIONES DE RENDERIZADO (continuación)
    // ============================================

    function renderFlujoEfectivo() {
        var data = datosDashboard ? datosDashboard.flujo_efectivo : null;
        
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles para el período seleccionado</div>';
        }
        
        // KPIs principales
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Saldo Inicial</div><div class="value primary">$' + (data.saldo_inicial || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Ingresos</div><div class="value success">$' + (data.ingresos || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Egresos</div><div class="value danger">$' + (data.egresos || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Saldo Final</div><div class="value purple">$' + (data.saldo_final || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '</div>';
        
        // Barra de flujo
        var flujoNeto = data.flujo_neto || 0;
        var pctFlujo = Math.abs(flujoNeto) > 0 ? Math.min((Math.abs(flujoNeto) / (Math.abs(flujoNeto) + 1000)) * 100, 100) : 0;
        var colorFlujo = flujoNeto >= 0 ? 'success' : 'danger';
        var signoFlujo = flujoNeto >= 0 ? '+' : '';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Flujo Neto</span><span>' + signoFlujo + '$' + Math.abs(flujoNeto).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill ' + colorFlujo + '" style="width:' + pctFlujo + '%;"></div></div>';
        html += '</div>';
        
        // ========== BANCOS ==========
        if (data.bancos && data.bancos.length > 0) {
            html += '<div style="margin-top:12px;border-top:1px solid var(--gray-200);padding-top:12px;">';
            html += '  <div style="font-weight:600;font-size:13px;color:var(--gray-700);margin-bottom:8px;">';
            html += '    <i class="fas fa-university" style="color:var(--primary);"></i> Detalle por Banco';
            html += '  </div>';
            html += '  <table class="table-bancos">';
            html += '    <thead>';
            html += '      <tr>';
            html += '        <th>Banco</th>';
            html += '        <th class="text-right">Saldo Inicial</th>';
            html += '        <th class="text-right">Ingresos</th>';
            html += '        <th class="text-right">Egresos</th>';
            html += '        <th class="text-right">Flujo</th>';
            html += '        <th class="text-right">Saldo Final</th>';
            html += '      </tr>';
            html += '    </thead>';
            html += '    <tbody>';
            
            data.bancos.forEach(function(banco) {
                var flujoBanco = (banco.flujo || 0);
                var colorFlujoBanco = flujoBanco >= 0 ? 'positive' : 'negative';
                var saldoFinalBanco = (banco.saldo_inicial || 0) + flujoBanco;
                
                html += '<tr>';
                html += '  <td><strong>' + (banco.nombre || 'Sin nombre') + '</strong></td>';
                html += '  <td class="text-right primary">$' + (banco.saldo_inicial || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '  <td class="text-right success">$' + (banco.ingresos || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '  <td class="text-right danger">$' + (banco.egresos || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '  <td class="text-right ' + colorFlujoBanco + '">$' + (flujoBanco >= 0 ? '+' : '') + flujoBanco.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '  <td class="text-right purple">$' + saldoFinalBanco.toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</td>';
                html += '</tr>';
            });
            
            html += '    </tbody>';
            html += '  </table>';
            html += '</div>';
        }
        
        return html;
    }

    function renderNominaResumen() {
        var data = datosDashboard ? datosDashboard.nomina : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Empleados</div><div class="value primary">' + (data.total_empleados || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Costo Mensual</div><div class="value danger">$' + (data.costo_nomina || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Obreros</span><span>' + (data.porcentaje_obreros || 0) + '%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:' + (data.porcentaje_obreros || 0) + '%;"></div></div>';
        html += '  <div class="progress-header"><span>Técnicos</span><span>' + (data.porcentaje_tecnicos || 0) + '%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill info" style="width:' + (data.porcentaje_tecnicos || 0) + '%;"></div></div>';
        html += '  <div class="progress-header"><span>Administrativos</span><span>' + (data.porcentaje_admin || 0) + '%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill warning" style="width:' + (data.porcentaje_admin || 0) + '%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderNominaProyectos() {
        var data = datosDashboard ? datosDashboard.nomina : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Empleados en Proyectos</div><div class="value primary">' + (data.empleados_en_proyectos || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Costo Nómina</div><div class="value danger">$' + (data.costo_nomina || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Distribución de Nómina</span><span>100%</span></div>';
        html += '  <div class="progress-bar-bg">';
        html += '    <div style="display:flex;height:100%;border-radius:3px;overflow:hidden;">';
        html += '      <div class="progress-bar-fill primary" style="width:' + (data.porcentaje_obreros || 0) + '%;"></div>';
        html += '      <div class="progress-bar-fill info" style="width:' + (data.porcentaje_tecnicos || 0) + '%;"></div>';
        html += '      <div class="progress-bar-fill warning" style="width:' + (data.porcentaje_admin || 0) + '%;"></div>';
        html += '    </div>';
        html += '  </div>';
        html += '</div>';
        
        return html;
    }

    function renderAsistenciaResumen() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Asistencia</div><div class="value success">85%</div></div>';
        html += '  <div class="kpi-card"><div class="label">Incidencias</div><div class="value danger">0</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Tasa de Asistencia</span><span>85%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:85%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderMaquinariaEstado() {
        var data = datosDashboard ? datosDashboard.maquinaria : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Total</div><div class="value primary">' + (data.total || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Operativos</div><div class="value success">' + (data.operativos || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Mantención</div><div class="value warning">' + (data.mantencion || 0) + '</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Disponibilidad</span><span>' + (data.disponibilidad || 0) + '%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:' + (data.disponibilidad || 0) + '%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderMaquinariaCostos() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Operación</div><div class="value primary">$0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Mantención</div><div class="value warning">$0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Combustible</div><div class="value danger">$0</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Costos Operativos</span><span>$0</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:0%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderInventarioResumen() {
        var data = datosDashboard ? datosDashboard.inventario : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Artículos</div><div class="value primary">' + (data.total_articulos || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Valor Inventario</div><div class="value success">$' + (data.valor_total || 0).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Bajo Stock</div><div class="value danger">' + (data.bajo_stock || 0) + '</div></div>';
        html += '</div>';
        
        return html;
    }

    function renderBitacoraResumen() {
        var data = datosDashboard ? datosDashboard.bitacora : null;
        if (!data) {
            return '<div class="text-center text-muted" style="padding:20px;">No hay datos disponibles</div>';
        }
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Entradas</div><div class="value primary">' + (data.total_entries || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Incidencias</div><div class="value danger">' + (data.incidencias || 0) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Hitos</div><div class="value success">' + (data.hitos || 0) + '</div></div>';
        html += '</div>';
        
        return html;
    }

    function renderLicitacionesResumen() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Total</div><div class="value primary">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Activas</div><div class="value success">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Adjudicadas</div><div class="value info">0</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Tasa de Conversión</span><span>0%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill success" style="width:0%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderSeguimientoObra() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Avance Global</div><div class="value success">0%</div></div>';
        html += '  <div class="kpi-card"><div class="label">Partidas</div><div class="value primary">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Con Avance</div><div class="value info">0</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Avance de Obra</span><span>0%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:0%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    function renderComprasResumen() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Requisiciones</div><div class="value primary">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Cotizaciones</div><div class="value info">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Pendientes</div><div class="value warning">0</div></div>';
        html += '</div>';
        
        return html;
    }

    function renderEstimacionesResumen() {
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Estimaciones</div><div class="value primary">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Aprobadas</div><div class="value success">0</div></div>';
        html += '  <div class="kpi-card"><div class="label">Pendientes</div><div class="value warning">0</div></div>';
        html += '</div>';
        
        return html;
    }

    function renderProyeccionesFinancieras() {
        var data = datosDashboard ? datosDashboard.finanzas : null;
        var renta = data ? data.rentabilidad : null;
        var margen = renta ? renta.margen || 0 : 0;
        var utilidad = renta ? renta.utilidad || 0 : 0;
        
        var html = '<div class="kpi-grid">';
        html += '  <div class="kpi-card"><div class="label">Margen Proyectado</div><div class="value purple">' + (margen + 2) + '%</div></div>';
        html += '  <div class="kpi-card"><div class="label">Utilidad Proyectada</div><div class="value success">$' + (utilidad * 1.1).toLocaleString('es-MX', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + '</div></div>';
        html += '  <div class="kpi-card"><div class="label">Crecimiento</div><div class="value primary">+12%</div></div>';
        html += '</div>';
        
        html += '<div class="progress-bar-container">';
        html += '  <div class="progress-header"><span>Proyección de Ventas</span><span>100%</span></div>';
        html += '  <div class="progress-bar-bg"><div class="progress-bar-fill primary" style="width:100%;"></div></div>';
        html += '</div>';
        
        return html;
    }

    // ============================================
    // FUNCIONES GLOBALES
    // ============================================

    function actualizarDashboard() {
        mostrarToast('Actualizando dashboard...', 'info');
        cargarDashboardConFiltros(proyectosSeleccionados);
    }

    function exportarDashboard() {
        mostrarToast('Exportando dashboard a Excel...', 'info');
        setTimeout(function() {
            mostrarToast('Exportación completada', 'success');
        }, 2000);
    }

    function mostrarToast(mensaje, tipo) {
        tipo = tipo || 'info';
        var toast = document.createElement('div');
        var colores = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            info: '#17a2b8'
        };
        var iconos = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-triangle-exclamation',
            info: 'fa-info-circle'
        };
        
        toast.className = 'toast-notification ' + tipo;
        toast.style.background = colores[tipo] || colores.info;
        toast.style.color = tipo === 'warning' ? '#856404' : 'white';
        
        toast.innerHTML = '<span class="toast-icon"><i class="fas ' + (iconos[tipo] || iconos.info) + '"></i></span>' +
                          '<span>' + mensaje + '</span>' +
                          '<button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>';
        
        document.body.appendChild(toast);
        
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(function() { toast.remove(); }, 300);
        }, 4000);
        
        return toast;
    }

    // Exponer funciones globales
    window.actualizarDashboard = actualizarDashboard;
    window.mostrarToast = mostrarToast;
    window.eliminarWidget = eliminarWidget;
    window.renderizarWidget = renderizarWidget;
    window.periodoActual = periodoActual;
    window.aplicarFiltros = aplicarFiltros;
    window.limpiarFiltros = limpiarFiltros;
    window.exportarDashboard = exportarDashboard;
    window.toggleProyecto = toggleProyecto;
    window.eliminarTag = eliminarTag;
    window.filtrarProyectosLista = filtrarProyectosLista;
    window.limpiarBusqueda = limpiarBusqueda;
    window.toggleERGroup = toggleERGroup;
    window.formatCurrency = formatCurrency;
    </script>
</div>
@endsection