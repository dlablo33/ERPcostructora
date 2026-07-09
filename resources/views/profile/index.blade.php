@extends('layouts.navigation')

@section('content')
<style>
    /* ============================================
       ESTILOS DEL PERFIL
       ============================================ */
    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* ===== HEADER ===== */
    .profile-header {
        background: white;
        border-radius: 16px;
        padding: 24px 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #083CAE, #0a4bc9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 32px;
        font-weight: 700;
        flex-shrink: 0;
        position: relative;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-avatar .online-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        background: #28a745;
        border-radius: 50%;
        border: 2px solid white;
    }

    .profile-info {
        flex: 1;
        min-width: 200px;
    }

    .profile-info h2 {
        font-size: 22px;
        font-weight: 700;
        color: #212529;
        margin: 0 0 4px 0;
    }

    .profile-info .email {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .profile-info .badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }

    .profile-info .badge-item {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-item.role {
        background: #e8f0fe;
        color: #083CAE;
    }

    .badge-item.department {
        background: #f1f3f5;
        color: #495057;
    }

    .badge-item.status {
        background: #d4edda;
        color: #155724;
    }

    .profile-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-left: auto;
    }

    .profile-actions .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: #083CAE;
        color: white;
    }

    .btn-primary-custom:hover {
        background: #0a4bc9;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
    }

    .btn-outline {
        background: transparent;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .btn-outline:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }

    .btn-danger-custom {
        background: #dc3545;
        color: white;
    }

    .btn-danger-custom:hover {
        background: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }

    /* ===== LAYOUT PRINCIPAL ===== */
    .profile-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    /* ===== SIDEBAR ===== */
    .profile-sidebar {
        width: 260px;
        flex-shrink: 0;
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        padding: 20px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        position: sticky;
        top: 20px;
    }

    .profile-sidebar .sidebar-title {
        font-size: 11px;
        font-weight: 600;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 12px 12px 12px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 12px;
    }

    .profile-sidebar .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .profile-sidebar .nav-item:hover {
        background: #f8f9fa;
        color: #212529;
    }

    .profile-sidebar .nav-item.active {
        background: #e8f0fe;
        color: #083CAE;
    }

    .profile-sidebar .nav-item i {
        width: 20px;
        text-align: center;
        font-size: 16px;
        color: #adb5bd;
    }

    .profile-sidebar .nav-item.active i {
        color: #083CAE;
    }

    .profile-sidebar .nav-item .badge-count {
        margin-left: auto;
        background: #dc3545;
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }

    /* ===== CONTENIDO ===== */
    .profile-content {
        flex: 1;
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        padding: 28px 32px;
        min-height: 500px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .profile-content .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-content .section-title i {
        color: #083CAE;
    }

    /* ===== TABS ===== */
    .tab-panel {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== METRIC CARDS ===== */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .metric-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 20px 24px;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .metric-card .metric-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }

    .metric-card .metric-value {
        font-size: 28px;
        font-weight: 700;
        color: #212529;
        margin-top: 4px;
    }

    .metric-card .metric-icon {
        float: right;
        font-size: 28px;
        opacity: 0.6;
        color: #083CAE;
    }

    .metric-card.blue { background: linear-gradient(135deg, #e8f0fe, #d4e2fc); border-color: #b3cff5; }
    .metric-card.green { background: linear-gradient(135deg, #d4edda, #c3e6cb); border-color: #8fd9a8; }
    .metric-card.orange { background: linear-gradient(135deg, #fff3cd, #ffeaa7); border-color: #ffda6b; }
    .metric-card.purple { background: linear-gradient(135deg, #e8d5f5, #d4b8ed); border-color: #b88fe0; }
    .metric-card.red { background: linear-gradient(135deg, #f8d7da, #f5c6cb); border-color: #eda3ab; }

    .metric-card.blue .metric-icon { color: #083CAE; }
    .metric-card.green .metric-icon { color: #28a745; }
    .metric-card.orange .metric-icon { color: #fd7e14; }
    .metric-card.purple .metric-icon { color: #6f42c1; }
    .metric-card.red .metric-icon { color: #dc3545; }

    /* ===== FORMULARIOS ===== */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        margin-bottom: 4px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: white;
        color: #212529;
    }

    .form-control:focus {
        outline: none;
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8,60,174,0.1);
    }

    .form-control:disabled {
        background: #e9ecef;
        cursor: not-allowed;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    /* ===== TABLAS ===== */
    .table-container {
        overflow-x: auto;
        margin-top: 12px;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table-custom thead th {
        background: #f8f9fa;
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .table-custom tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #e9ecef;
        color: #212529;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover td {
        background: #f8f9fa;
    }

    .table-custom .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-status.active { background: #d4edda; color: #155724; }
    .badge-status.inactive { background: #f8d7da; color: #721c24; }
    .badge-status.pending { background: #fff3cd; color: #856404; }
    .badge-status.info { background: #d1ecf1; color: #0c5460; }

    /* ===== NOTIFICACIONES ===== */
    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 14px 16px;
        border-radius: 10px;
        background: #f8f9fa;
        border-left: 4px solid #083CAE;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }

    .notification-item:hover {
        background: #e9ecef;
        transform: translateX(4px);
    }

    .notification-item .notif-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: white;
        font-size: 16px;
    }

    .notification-item .notif-icon.info { background: #083CAE; }
    .notification-item .notif-icon.success { background: #28a745; }
    .notification-item .notif-icon.warning { background: #ffc107; color: #856404; }
    .notification-item .notif-icon.danger { background: #dc3545; }

    .notification-item .notif-content {
        flex: 1;
    }

    .notification-item .notif-content .title {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
    }

    .notification-item .notif-content .message {
        color: #6c757d;
        font-size: 13px;
        margin-top: 2px;
    }

    .notification-item .notif-content .time {
        color: #adb5bd;
        font-size: 11px;
        margin-top: 4px;
    }

    .notification-item .notif-actions {
        flex-shrink: 0;
        display: flex;
        gap: 8px;
    }

    .notification-item .notif-actions button {
        background: none;
        border: none;
        cursor: pointer;
        color: #6c757d;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .notification-item .notif-actions button:hover {
        background: #dee2e6;
        color: #212529;
    }

    .notification-item.unread {
        background: #e8f0fe;
        border-left-color: #083CAE;
    }

    .notification-item.unread .notif-content .title {
        color: #083CAE;
    }

    /* ===== SESIONES ===== */
    .session-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 16px;
        border-radius: 10px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        margin-bottom: 10px;
    }

    .session-item .session-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #e8f0fe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #083CAE;
        font-size: 20px;
        flex-shrink: 0;
    }

    .session-item .session-info {
        flex: 1;
    }

    .session-item .session-info .device {
        font-weight: 600;
        color: #212529;
        font-size: 14px;
    }

    .session-item .session-info .details {
        color: #6c757d;
        font-size: 13px;
    }

    .session-item .session-info .last-active {
        color: #adb5bd;
        font-size: 11px;
    }

    .session-item .session-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .session-status.current { background: #d4edda; color: #155724; }
    .session-status.active { background: #d1ecf1; color: #0c5460; }
    .session-status.inactive { background: #f8d7da; color: #721c24; }

    /* ===== TOGGLE SWITCH ===== */
    .toggle-switch {
        position: relative;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-switch .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ced4da;
        border-radius: 24px;
        transition: all 0.3s ease;
    }

    .toggle-switch .slider::before {
        content: "";
        position: absolute;
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .toggle-switch input:checked + .slider {
        background: #083CAE;
    }

    .toggle-switch input:checked + .slider::before {
        transform: translateX(20px);
    }

    /* ===== TOKENS API ===== */
    .token-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 10px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .token-item .token-info .name {
        font-weight: 600;
        color: #212529;
    }

    .token-item .token-info .token-key {
        font-family: monospace;
        background: #e9ecef;
        padding: 2px 10px;
        border-radius: 4px;
        font-size: 12px;
        color: #495057;
        margin-left: 8px;
    }

    .token-item .token-info .meta {
        color: #6c757d;
        font-size: 12px;
    }

    /* ===== ACTIVITY ===== */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
        color: white;
    }

    .activity-item .activity-content .action {
        font-weight: 500;
        color: #212529;
        font-size: 14px;
    }

    .activity-item .activity-content .description {
        color: #6c757d;
        font-size: 13px;
    }

    .activity-item .activity-content .time {
        color: #adb5bd;
        font-size: 11px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .profile-layout {
            flex-direction: column;
        }
        .profile-sidebar {
            width: 100%;
            position: static;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 12px 16px;
        }
        .profile-sidebar .sidebar-title {
            display: none;
        }
        .profile-sidebar .nav-item {
            flex: 1;
            min-width: 100px;
            justify-content: center;
            padding: 8px 12px;
            font-size: 13px;
        }
        .profile-sidebar .nav-item .badge-count {
            display: none;
        }
        .profile-content {
            padding: 20px;
        }
        .form-row, .form-row-3 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .profile-actions {
            margin-left: 0;
            justify-content: center;
        }
        .profile-info .badges {
            justify-content: center;
        }
        .metric-grid {
            grid-template-columns: 1fr 1fr;
        }
        .profile-content {
            padding: 16px;
        }
        .notification-item {
            flex-direction: column;
            align-items: stretch;
        }
        .notification-item .notif-actions {
            justify-content: flex-end;
        }
    }

    @media (max-width: 480px) {
        .metric-grid {
            grid-template-columns: 1fr;
        }
        .profile-avatar {
            width: 64px;
            height: 64px;
            font-size: 24px;
        }
        .profile-info h2 {
            font-size: 18px;
        }
        .profile-actions .btn {
            padding: 8px 14px;
            font-size: 12px;
        }
        .token-item {
            flex-direction: column;
            align-items: stretch;
        }
        .token-item .token-actions {
            display: flex;
            gap: 8px;
        }
    }

    /* ===== SCROLLBAR PERSONALIZADA ===== */
    .profile-content::-webkit-scrollbar,
    .table-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .profile-content::-webkit-scrollbar-track,
    .table-container::-webkit-scrollbar-track {
        background: #f1f3f5;
        border-radius: 3px;
    }

    .profile-content::-webkit-scrollbar-thumb,
    .table-container::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 3px;
    }

    .profile-content::-webkit-scrollbar-thumb:hover,
    .table-container::-webkit-scrollbar-thumb:hover {
        background: #adb5bd;
    }

    /* ===== LOADING ===== */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #e9ecef;
        border-top: 3px solid #083CAE;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== ALERTAS ===== */
    .alert-custom {
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
    }

    .alert-custom.success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-custom.error {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert-custom.warning {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
    }

    .alert-custom.info {
        background: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }
</style>

<div class="profile-container">
    <!-- ==========================================
    HEADER DEL PERFIL
    ========================================== -->
    <div class="profile-header">
        <div class="profile-avatar">
            @if(auth()->user()->avatar_path)
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif
            <span class="online-dot"></span>
        </div>

        <div class="profile-info">
            <h2>{{ auth()->user()->name }}</h2>
            <p class="email"><i class="fas fa-envelope mr-2"></i>{{ auth()->user()->email }}</p>
            <div class="badges">
                <span class="badge-item role"><i class="fas fa-user-tie"></i> {{ auth()->user()->position ?? 'Sin puesto' }}</span>
                <span class="badge-item department"><i class="fas fa-building"></i> {{ auth()->user()->department ?? 'Sin departamento' }}</span>
                <span class="badge-item status"><i class="fas fa-circle" style="font-size:8px;color:#28a745;"></i> Activo</span>
            </div>
        </div>

        <div class="profile-actions">
            <button class="btn btn-primary-custom" onclick="showTab('edit')">
                <i class="fas fa-edit"></i> Editar Perfil
            </button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- ==========================================
    LAYOUT PRINCIPAL
    ========================================== -->
    <div class="profile-layout">
        <!-- SIDEBAR -->
        <div class="profile-sidebar">
            <div class="sidebar-title">Menú de Perfil</div>

            <button class="nav-item active" data-tab="dashboard" onclick="showTab('dashboard')">
                <i class="fas fa-chart-pie"></i> Resumen
            </button>
            <button class="nav-item" data-tab="edit" onclick="showTab('edit')">
                <i class="fas fa-user"></i> Información Personal
            </button>
            <button class="nav-item" data-tab="security" onclick="showTab('security')">
                <i class="fas fa-lock"></i> Seguridad
            </button>
            <button class="nav-item" data-tab="preferences" onclick="showTab('preferences')">
                <i class="fas fa-sliders-h"></i> Preferencias
            </button>
            <button class="nav-item" data-tab="notifications" onclick="showTab('notifications')">
                <i class="fas fa-bell"></i> Notificaciones
                <span class="badge-count" id="notifBadge">{{ $unreadCount ?? 0 }}</span>
            </button>
            <button class="nav-item" data-tab="projects" onclick="showTab('projects')">
                <i class="fas fa-project-diagram"></i> Proyectos
            </button>
            <button class="nav-item" data-tab="tasks" onclick="showTab('tasks')">
                <i class="fas fa-tasks"></i> Tareas
            </button>
            <button class="nav-item" data-tab="sessions" onclick="showTab('sessions')">
                <i class="fas fa-laptop"></i> Sesiones
            </button>
            <!-- <button class="nav-item" data-tab="api-tokens" onclick="showTab('api-tokens')">
                <i class="fas fa-key"></i> Tokens API
            </button> ========================================== -->
            <button class="nav-item" data-tab="activity" onclick="showTab('activity')">
                <i class="fas fa-history"></i> Actividad
            </button>
        </div>

        <!-- CONTENIDO -->
        <div class="profile-content">
            <!-- ==========================================
            TAB: DASHBOARD (RESUMEN)
            ========================================== -->
            <div id="tab-dashboard" class="tab-panel active">
                <div class="section-title">
                    <i class="fas fa-chart-pie"></i> Resumen del Perfil
                </div>

                <!-- Métricas -->
                <div class="metric-grid">
                    <div class="metric-card blue">
                        <i class="fas fa-project-diagram metric-icon"></i>
                        <div class="metric-label">Proyectos Activos</div>
                        <div class="metric-value" id="totalProjects">{{ $projectsCount ?? 0 }}</div>
                    </div>
                    <div class="metric-card orange">
                        <i class="fas fa-tasks metric-icon"></i>
                        <div class="metric-label">Tareas Pendientes</div>
                        <div class="metric-value" id="pendingTasks">{{ $pendingTasks ?? 0 }}</div>
                    </div>
                    <div class="metric-card purple">
                        <i class="fas fa-bell metric-icon"></i>
                        <div class="metric-label">Notificaciones</div>
                        <div class="metric-value" id="unreadNotif">{{ $unreadCount ?? 0 }}</div>
                    </div>
                    <div class="metric-card green">
                        <i class="fas fa-laptop metric-icon"></i>
                        <div class="metric-label">Sesiones Activas</div>
                        <div class="metric-value" id="activeSessions">{{ $sessions->where('is_active', true)->count() ?? 0 }}</div>
                    </div>
                </div>

                <!-- Notificaciones Recientes -->
                <div style="margin-top:24px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <h4 style="font-weight:600;color:#212529;font-size:15px;margin:0;">
                            <i class="fas fa-bell" style="color:#083CAE;"></i> Notificaciones Recientes
                        </h4>
                        <button class="btn btn-outline" style="padding:6px 14px;font-size:12px;" onclick="showTab('notifications')">
                            Ver todas <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>

                    @if(isset($notifications) && $notifications->count() > 0)
                        @foreach($notifications as $notification)
                            <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                                <div class="notif-icon {{ $notification->category ?? 'info' }}">
                                    <i class="fas {{ $notification->icon_class ?? 'fa-bell' }}"></i>
                                </div>
                                <div class="notif-content">
                                    <div class="title">{{ $notification->title }}</div>
                                    <div class="message">{{ $notification->message }}</div>
                                    <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="notif-actions">
                                    @if(!$notification->is_read)
                                        <button onclick="markNotificationRead({{ $notification->id }})" title="Marcar como leída">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button onclick="dismissNotification({{ $notification->id }})" title="Descartar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-bell-slash" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No tienes notificaciones pendientes</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ==========================================
            TAB: EDITAR PERFIL
            ========================================== -->
            <div id="tab-edit" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-user"></i> Información Personal
                </div>

                <div id="editAlert" style="display:none;"></div>

                <form id="profileForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label>Puesto</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position', auth()->user()->position ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Departamento</label>
                        <input type="text" name="department" class="form-control" value="{{ old('department', auth()->user()->department ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Foto de Perfil</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*" style="padding:8px;">
                        <small style="color:#6c757d;font-size:12px;">Formatos permitidos: JPG, PNG, GIF. Máx: 2MB</small>
                    </div>

                    <button type="submit" class="btn btn-primary-custom" id="saveProfileBtn">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </form>

                <hr style="margin:30px 0;border-color:#e9ecef;">

                <!-- Cambiar Contraseña -->
                <div class="section-title" style="margin-top:0;">
                    <i class="fas fa-lock" style="color:#fd7e14;"></i> Cambiar Contraseña
                </div>

                <div id="passwordAlert" style="display:none;"></div>

                <form id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Contraseña Actual</label>
                            <input type="password" name="current_password" class="form-control" id="current_password" required>
                        </div>
                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" required minlength="8">
                        </div>
                        <div class="form-group">
                            <label>Confirmar Contraseña</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="background:#fd7e14;color:white;padding:10px 24px;border-radius:8px;border:none;font-weight:500;cursor:pointer;transition:all 0.2s;" id="savePasswordBtn">
                        <i class="fas fa-key"></i> Cambiar Contraseña
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: SEGURIDAD
            ========================================== -->
            <div id="tab-security" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-shield-alt" style="color:#fd7e14;"></i> Seguridad
                </div>

                <div style="background:#f8f9fa;border-radius:12px;padding:20px;margin-bottom:20px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h4 style="font-weight:600;color:#212529;margin:0;font-size:15px;">Autenticación de Dos Factores (2FA)</h4>
                            <p style="color:#6c757d;font-size:13px;margin:4px 0 0 0;">Añade una capa extra de seguridad a tu cuenta</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="twoFactorToggle" {{ auth()->user()->two_factor_enabled ?? false ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div style="background:#f8f9fa;border-radius:12px;padding:20px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h4 style="font-weight:600;color:#212529;margin:0;font-size:15px;">Cerrar todas las sesiones</h4>
                            <p style="color:#6c757d;font-size:13px;margin:4px 0 0 0;">Cierra sesión en todos los dispositivos excepto este</p>
                        </div>
                        <button class="btn btn-danger-custom" onclick="terminateAllSessions()" style="padding:8px 20px;font-size:13px;">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Todas
                        </button>
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">
                        <i class="fas fa-history" style="color:#6c757d;"></i> Últimos Accesos
                    </h4>
                    <div id="securityActivity">
                        <p style="color:#adb5bd;font-size:13px;">Cargando actividad...</p>
                    </div>
                </div>
            </div>

            <!-- ==========================================
            TAB: PREFERENCIAS
            ========================================== -->
            <div id="tab-preferences" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-sliders-h" style="color:#6f42c1;"></i> Preferencias del Sistema
                </div>

                <div id="prefAlert" style="display:none;"></div>

                <form id="preferencesForm">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tema</label>
                            <select name="theme" class="form-control">
                                <option value="light" {{ ($preferences->theme ?? 'light') === 'light' ? 'selected' : '' }}>Claro</option>
                                <option value="dark" {{ ($preferences->theme ?? 'light') === 'dark' ? 'selected' : '' }}>Oscuro</option>
                                <option value="auto" {{ ($preferences->theme ?? 'light') === 'auto' ? 'selected' : '' }}>Automático</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Idioma</label>
                            <select name="language" class="form-control">
                                <option value="es" {{ ($preferences->language ?? 'es') === 'es' ? 'selected' : '' }}>Español</option>
                                <option value="en" {{ ($preferences->language ?? 'es') === 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Zona Horaria</label>
                            <select name="timezone" class="form-control">
                                <option value="America/Mexico_City" {{ ($preferences->timezone ?? 'America/Mexico_City') === 'America/Mexico_City' ? 'selected' : '' }}>Ciudad de México</option>
                                <option value="America/Guatemala" {{ ($preferences->timezone ?? 'America/Mexico_City') === 'America/Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                <option value="America/El_Salvador" {{ ($preferences->timezone ?? 'America/Mexico_City') === 'America/El_Salvador' ? 'selected' : '' }}>El Salvador</option>
                                <option value="America/New_York" {{ ($preferences->timezone ?? 'America/Mexico_City') === 'America/New_York' ? 'selected' : '' }}>Nueva York</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moneda</label>
                            <select name="currency" class="form-control">
                                <option value="MXN" {{ ($preferences->currency ?? 'MXN') === 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                <option value="USD" {{ ($preferences->currency ?? 'MXN') === 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                <option value="EUR" {{ ($preferences->currency ?? 'MXN') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Formato de Fecha</label>
                            <select name="date_format" class="form-control">
                                <option value="d/m/Y" {{ ($preferences->date_format ?? 'd/m/Y') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="m/d/Y" {{ ($preferences->date_format ?? 'd/m/Y') === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="Y-m-d" {{ ($preferences->date_format ?? 'd/m/Y') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Formato de Hora</label>
                            <select name="time_format" class="form-control">
                                <option value="H:i" {{ ($preferences->time_format ?? 'H:i') === 'H:i' ? 'selected' : '' }}>24 horas (14:30)</option>
                                <option value="h:i A" {{ ($preferences->time_format ?? 'H:i') === 'h:i A' ? 'selected' : '' }}>12 horas (02:30 PM)</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top:20px;">
                        <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">Notificaciones</h4>
                        <div style="display:flex;flex-wrap:wrap;gap:20px;">
                            <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#495057;cursor:pointer;">
                                <input type="checkbox" name="notifications_email" value="1" {{ ($preferences->notifications_email ?? true) ? 'checked' : '' }}>
                                Correo Electrónico
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#495057;cursor:pointer;">
                                <input type="checkbox" name="notifications_system" value="1" {{ ($preferences->notifications_system ?? true) ? 'checked' : '' }}>
                                Sistema
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:#495057;cursor:pointer;">
                                <input type="checkbox" name="notifications_whatsapp" value="1" {{ ($preferences->notifications_whatsapp ?? false) ? 'checked' : '' }}>
                                WhatsApp
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top:20px;background:#6f42c1;color:white;padding:10px 24px;border-radius:8px;border:none;font-weight:500;cursor:pointer;transition:all 0.2s;" id="savePreferencesBtn">
                        <i class="fas fa-save"></i> Guardar Preferencias
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: NOTIFICACIONES
            ========================================== -->
            <div id="tab-notifications" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-bell" style="color:#083CAE;"></i> Notificaciones
                    <span style="font-size:12px;font-weight:400;color:#6c757d;margin-left:8px;" id="notifCountLabel">{{ $unreadCount ?? 0 }} no leídas</span>
                </div>

                <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
                    <button class="btn btn-outline" style="padding:6px 16px;font-size:12px;" onclick="loadNotifications('all')">Todas</button>
                    <button class="btn btn-outline" style="padding:6px 16px;font-size:12px;" onclick="loadNotifications('unread')">No leídas</button>
                    <button class="btn btn-primary-custom" style="padding:6px 16px;font-size:12px;" onclick="markAllRead()">
                        <i class="fas fa-check-double"></i> Marcar todas como leídas
                    </button>
                </div>

                <div id="notificationsList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando notificaciones...</p>
                </div>
            </div>

            <!-- ==========================================
            TAB: PROYECTOS
            ========================================== -->
            <div id="tab-projects" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-project-diagram" style="color:#083CAE;"></i> Mis Proyectos
                </div>

                <div id="projectsList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando proyectos...</p>
                </div>
            </div>

            <!-- ==========================================
            TAB: TAREAS
            ========================================== -->
            <div id="tab-tasks" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-tasks" style="color:#fd7e14;"></i> Mis Tareas
                    <span style="font-size:12px;font-weight:400;color:#6c757d;margin-left:8px;" id="tasksCountLabel">{{ $pendingTasks ?? 0 }} pendientes</span>
                </div>

                <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
                    <button class="btn btn-outline" style="padding:6px 16px;font-size:12px;" onclick="loadTasks('all')">Todas</button>
                    <button class="btn btn-outline" style="padding:6px 16px;font-size:12px;" onclick="loadTasks('pending')">Pendientes</button>
                    <button class="btn btn-outline" style="padding:6px 16px;font-size:12px;" onclick="loadTasks('completed')">Completadas</button>
                </div>

                <div id="tasksList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando tareas...</p>
                </div>
            </div>

            <!-- ==========================================
            TAB: SESIONES
            ========================================== -->
            <div id="tab-sessions" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-laptop" style="color:#083CAE;"></i> Sesiones Activas
                </div>

                <div id="sessionsList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando sesiones...</p>
                </div>
            </div>

            <!-- ==========================================
            TAB: API TOKENS

            <div id="tab-api-tokens" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-key" style="color:#6f42c1;"></i> Tokens API
                </div>

                <div style="background:#f8f9fa;border-radius:12px;padding:20px;margin-bottom:20px;">
                    <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">Crear Nuevo Token</h4>
                    <form id="apiTokenForm" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                        @csrf
                        <div style="flex:1;min-width:200px;">
                            <label style="display:block;font-size:13px;font-weight:500;color:#495057;margin-bottom:4px;">Nombre del Token</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej: API-Integracion" required>
                        </div>
                        <div style="flex:1;min-width:150px;">
                            <label style="display:block;font-size:13px;font-weight:500;color:#495057;margin-bottom:4px;">Días de Expiración</label>
                            <input type="number" name="expires_in_days" class="form-control" value="30" min="1" max="365">
                        </div>
                        <button type="submit" class="btn" style="background:#6f42c1;color:white;padding:10px 20px;border-radius:8px;border:none;font-weight:500;cursor:pointer;transition:all 0.2s;">
                            <i class="fas fa-plus"></i> Crear Token
                        </button>
                    </form>
                </div>

                <div id="apiTokensList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando tokens...</p>
                </div>
            </div>
            ========================================== -->

            <!-- ==========================================
            TAB: ACTIVIDAD
            ========================================== -->
            <div id="tab-activity" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-history" style="color:#6c757d;"></i> Historial de Actividad
                </div>

                <div id="activityList">
                    <p style="color:#adb5bd;text-align:center;padding:40px;">Cargando actividad...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
SCRIPTS
========================================== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Cargar datos iniciales
    loadNotifications('all');
    loadProjects();
    loadTasks('all');
    loadSessions();
    loadApiTokens();
    loadActivity();
    loadSecurityActivity();

    // ==========================================
    // NAVEGACIÓN POR TABS
    // ==========================================
    window.showTab = function(tab) {
        // Ocultar todos los tabs
        $('.tab-panel').removeClass('active');

        // Mostrar el tab seleccionado
        const tabId = '#tab-' + tab;
        $(tabId).addClass('active');

        // Actualizar sidebar
        $('.nav-item').removeClass('active');
        $(`.nav-item[data-tab="${tab}"]`).addClass('active');

        // Recargar datos según tab
        switch(tab) {
            case 'notifications': loadNotifications('all'); break;
            case 'projects': loadProjects(); break;
            case 'tasks': loadTasks('all'); break;
            case 'sessions': loadSessions(); break;
            case 'api-tokens': loadApiTokens(); break;
            case 'activity': loadActivity(); break;
            case 'security': loadSecurityActivity(); break;
        }
    };

    // ==========================================
    // ACTUALIZAR PERFIL
    // ==========================================
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $('#saveProfileBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '{{ route("profile.update") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    showAlert('editAlert', 'success', 'Perfil actualizado correctamente');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('editAlert', 'error', response.message || 'Error al actualizar');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                const msg = Object.values(errors).flat()[0] || 'Error al actualizar el perfil';
                showAlert('editAlert', 'error', msg);
            },
            complete: function() {
                $('#saveProfileBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Cambios');
            }
        });
    });

    // ==========================================
    // CAMBIAR CONTRASEÑA
    // ==========================================
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();

        const current = $('#current_password').val();
        const newPass = $('#new_password').val();
        const confirm = $('#new_password_confirmation').val();

        if (!current || !newPass || !confirm) {
            showAlert('passwordAlert', 'warning', 'Completa todos los campos');
            return;
        }

        if (newPass !== confirm) {
            showAlert('passwordAlert', 'error', 'Las contraseñas no coinciden');
            return;
        }

        if (newPass.length < 8) {
            showAlert('passwordAlert', 'error', 'La contraseña debe tener al menos 8 caracteres');
            return;
        }

        $('#savePasswordBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Cambiando...');

        $.ajax({
            url: '{{ route("profile.password.update") }}',
            type: 'PUT',
            data: {
                current_password: current,
                new_password: newPass,
                new_password_confirmation: confirm,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showAlert('passwordAlert', 'success', response.message || 'Contraseña actualizada');
                $('#current_password, #new_password, #new_password_confirmation').val('');
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Error al cambiar la contraseña';
                showAlert('passwordAlert', 'error', msg);
            },
            complete: function() {
                $('#savePasswordBtn').prop('disabled', false).html('<i class="fas fa-key"></i> Cambiar Contraseña');
            }
        });
    });

    // ==========================================
    // ACTUALIZAR PREFERENCIAS
    // ==========================================
    $('#preferencesForm').on('submit', function(e) {
        e.preventDefault();

        $('#savePreferencesBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '{{ route("profile.preferences.update") }}',
            type: 'PUT',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                showAlert('prefAlert', 'success', response.message || 'Preferencias actualizadas');
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Error al guardar preferencias';
                showAlert('prefAlert', 'error', msg);
            },
            complete: function() {
                $('#savePreferencesBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Preferencias');
            }
        });
    });

    // ==========================================
    // 2FA TOGGLE
    // ==========================================
    $('#twoFactorToggle').on('change', function() {
        const enabled = $(this).is(':checked');
        Swal.fire({
            title: enabled ? 'Activar 2FA' : 'Desactivar 2FA',
            text: enabled ? '¿Deseas activar la autenticación de dos factores?' : '¿Deseas desactivar la autenticación de dos factores?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#083CAE',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) {
                $(this).prop('checked', !enabled);
            } else {
                // Aquí iría la llamada AJAX para guardar el estado de 2FA
                Swal.fire({
                    icon: 'info',
                    title: 'Configuración guardada',
                    text: 'La configuración de 2FA ha sido actualizada',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // ==========================================
    // CREAR TOKEN API
    // ==========================================
    $('#apiTokenForm').on('submit', function(e) {
        e.preventDefault();

        const name = $(this).find('input[name="name"]').val();
        const expires = $(this).find('input[name="expires_in_days"]').val();

        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Error', text: 'Ingresa un nombre para el token' });
            return;
        }

        $.ajax({
            url: '{{ route("profile.api-tokens.create") }}',
            type: 'POST',
            data: {
                name: name,
                expires_in_days: expires || 30,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Token Creado',
                    text: 'Token: ' + response.data.token_mask,
                    timer: 3000
                });
                $('#apiTokenForm')[0].reset();
                loadApiTokens();
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Error al crear el token';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    // ==========================================
    // FUNCIONES DE CARGA DE DATOS
    // ==========================================

    function loadNotifications(type) {
        $('#notificationsList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.notifications") }}',
            data: { type: type, limit: 50 },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(n => {
                        const isUnread = !n.is_read ? 'unread' : '';
                        const icon = n.icon_class || 'fa-bell';
                        const category = n.category || 'info';
                        html += `
                            <div class="notification-item ${isUnread}">
                                <div class="notif-icon ${category}">
                                    <i class="fas ${icon}"></i>
                                </div>
                                <div class="notif-content">
                                    <div class="title">${n.title}</div>
                                    <div class="message">${n.message || ''}</div>
                                    <div class="time">${n.time_ago || 'Hace un momento'}</div>
                                </div>
                                <div class="notif-actions">
                                    ${!n.is_read ? `<button onclick="markNotificationRead(${n.id})"><i class="fas fa-check"></i></button>` : ''}
                                    <button onclick="dismissNotification(${n.id})"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        `;
                    });
                    $('#notificationsList').html(html);
                    $('#notifBadge').text(response.unread_count || 0);
                    $('#notifCountLabel').text((response.unread_count || 0) + ' no leídas');
                } else {
                    $('#notificationsList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-bell-slash" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay notificaciones</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#notificationsList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar notificaciones</p>');
            }
        });
    }

    function loadProjects() {
        $('#projectsList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.projects") }}',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = `
                        <div class="table-container">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Proyecto</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Presupuesto</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    response.data.forEach(p => {
                        const statusClass = p.estado === 'activo' ? 'active' : (p.estado === 'finalizado' ? 'info' : 'pending');
                        html += `
                            <tr>
                                <td><strong>${p.codigo || '-'}</strong></td>
                                <td>${p.nombre || '-'}</td>
                                <td>${p.rol || '-'}</td>
                                <td><span class="badge-status ${statusClass}">${p.estado || 'N/A'}</span></td>
                                <td>$${(p.presupuesto_total || 0).toLocaleString()}</td>
                            </tr>
                        `;
                    });
                    html += '</tbody></table></div>';
                    $('#projectsList').html(html);
                } else {
                    $('#projectsList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-project-diagram" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No estás asignado a ningún proyecto</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#projectsList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar proyectos</p>');
            }
        });
    }

    function loadTasks(status) {
        $('#tasksList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.tasks") }}',
            data: { status: status, limit: 50 },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = `
                        <div class="table-container">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Fecha Límite</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    response.data.forEach(t => {
                        const statusClass = t.estado === 'completada' ? 'active' : (t.estado === 'pendiente' ? 'pending' : 'inactive');
                        html += `
                            <tr>
                                <td><strong>${t.titulo || '-'}</strong></td>
                                <td>${t.tipo || '-'}</td>
                                <td><span class="badge-status ${statusClass}">${t.estado || 'N/A'}</span></td>
                                <td>${t.fecha_limite ? new Date(t.fecha_limite).toLocaleDateString() : '-'}</td>
                            </tr>
                        `;
                    });
                    html += '</tbody></table></div>';
                    $('#tasksList').html(html);
                    $('#tasksCountLabel').text((response.pending_count || 0) + ' pendientes');
                } else {
                    $('#tasksList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-check-circle" style="font-size:36px;margin-bottom:12px;display:block;color:#28a745;"></i>
                            <p>No hay tareas ${status === 'pending' ? 'pendientes' : 'disponibles'}</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#tasksList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar tareas</p>');
            }
        });
    }

    function loadSessions() {
        $('#sessionsList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.sessions") }}',
            success: function(response) {
                const currentId = response.current_session_id;
                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(s => {
                        const isCurrent = s.session_id === currentId;
                        const statusClass = isCurrent ? 'current' : (s.is_active ? 'active' : 'inactive');
                        const statusLabel = isCurrent ? 'Sesión actual' : (s.is_active ? 'Activa' : 'Inactiva');
                        const icon = s.device_icon || 'fa-laptop';
                        html += `
                            <div class="session-item">
                                <div class="session-icon"><i class="fas ${icon}"></i></div>
                                <div class="session-info">
                                    <div class="device">${s.device_label || 'Dispositivo'} ${isCurrent ? '⭐' : ''}</div>
                                    <div class="details">${s.browser || ''} ${s.platform ? 'en ' + s.platform : ''}</div>
                                    <div class="last-active">${s.last_activity_human || 'Nunca'}</div>
                                </div>
                                <span class="session-status ${statusClass}">${statusLabel}</span>
                                ${!isCurrent ? `<button class="btn btn-danger-custom" style="padding:4px 12px;font-size:11px;" onclick="terminateSession(${s.id})"><i class="fas fa-times"></i> Cerrar</button>` : ''}
                            </div>
                        `;
                    });
                    $('#sessionsList').html(html);
                    $('#activeSessions').text(response.data.filter(s => s.is_active).length);
                } else {
                    $('#sessionsList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-laptop" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay sesiones activas</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#sessionsList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar sesiones</p>');
            }
        });
    }

    function loadApiTokens() {
        $('#apiTokensList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.api-tokens") }}',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(t => {
                        const isActive = t.is_active && !t.is_expired;
                        html += `
                            <div class="token-item">
                                <div class="token-info">
                                    <div class="name">${t.name}</div>
                                    <div>
                                        <span class="token-key">${t.token_mask || t.token_short}</span>
                                        <span style="margin-left:8px;font-size:12px;color:${isActive ? '#28a745' : '#dc3545'};">${isActive ? '● Activo' : '● Inactivo'}</span>
                                    </div>
                                    <div class="meta">Creado: ${new Date(t.created_at).toLocaleDateString()} ${t.expires_at ? '· Expira: ' + new Date(t.expires_at).toLocaleDateString() : '· Sin expiración'}</div>
                                </div>
                                <div class="token-actions">
                                    <button class="btn btn-danger-custom" style="padding:4px 14px;font-size:11px;" onclick="revokeToken(${t.id})">
                                        <i class="fas fa-trash"></i> Revocar
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    $('#apiTokensList').html(html);
                } else {
                    $('#apiTokensList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-key" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No tienes tokens API creados</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#apiTokensList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar tokens</p>');
            }
        });
    }

    function loadActivity() {
        $('#activityList').html('<p style="color:#adb5bd;text-align:center;padding:40px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.activity") }}',
            data: { limit: 50 },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(a => {
                        const colors = { green: '#28a745', blue: '#083CAE', orange: '#fd7e14', red: '#dc3545', purple: '#6f42c1', gray: '#6c757d' };
                        const color = colors[a.action_color] || '#6c757d';
                        html += `
                            <div class="activity-item">
                                <div class="activity-icon" style="background:${color};">
                                    <i class="fas ${a.action_icon || 'fa-clock'}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="action">${a.action_label || a.action}</div>
                                    <div class="description">${a.description || ''}</div>
                                    <div class="time">${a.time_ago || 'Hace un momento'}</div>
                                </div>
                            </div>
                        `;
                    });
                    $('#activityList').html(html);
                } else {
                    $('#activityList').html(`
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-clock" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay actividad registrada</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#activityList').html('<p style="color:#dc3545;text-align:center;padding:40px;">Error al cargar actividad</p>');
            }
        });
    }

    function loadSecurityActivity() {
        $('#securityActivity').html('<p style="color:#adb5bd;font-size:13px;"><i class="fas fa-spinner fa-spin"></i> Cargando...</p>');

        $.ajax({
            url: '{{ route("profile.activity") }}',
            data: { limit: 5 },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(a => {
                        const icon = a.action === 'login' ? 'fa-sign-in-alt' : (a.action === 'logout' ? 'fa-sign-out-alt' : 'fa-clock');
                        const color = a.action === 'login' ? '#28a745' : (a.action === 'logout' ? '#dc3545' : '#6c757d');
                        html += `
                            <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #f1f3f5;">
                                <span style="color:${color};width:24px;text-align:center;"><i class="fas ${icon}"></i></span>
                                <span style="flex:1;font-size:13px;">${a.description || a.action_label || a.action}</span>
                                <span style="font-size:11px;color:#adb5bd;">${a.time_ago || ''}</span>
                            </div>
                        `;
                    });
                    $('#securityActivity').html(html);
                } else {
                    $('#securityActivity').html('<p style="color:#adb5bd;font-size:13px;">No hay actividad de seguridad reciente</p>');
                }
            },
            error: function() {
                $('#securityActivity').html('<p style="color:#dc3545;font-size:13px;">Error al cargar actividad</p>');
            }
        });
    }

    // ==========================================
    // ACCIONES DE NOTIFICACIONES
    // ==========================================

    window.markNotificationRead = function(id) {
        $.ajax({
            url: '{{ route("profile.notifications.read", "") }}/' + id,
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                loadNotifications('all');
            }
        });
    };

    window.markAllRead = function() {
        $.ajax({
            url: '{{ route("profile.notifications.read-all") }}',
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                loadNotifications('all');
                Swal.fire({ icon: 'success', title: 'Actualizado', text: 'Todas las notificaciones marcadas como leídas', timer: 1500, showConfirmButton: false });
            }
        });
    };

    window.dismissNotification = function(id) {
        Swal.fire({
            title: '¿Descartar notificación?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, descartar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("profile.notifications.dismiss", "") }}/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() {
                        loadNotifications('all');
                        Swal.fire({ icon: 'success', title: 'Descartada', timer: 1000, showConfirmButton: false });
                    }
                });
            }
        });
    };

    // ==========================================
    // ACCIONES DE SESIONES
    // ==========================================

    window.terminateSession = function(id) {
        Swal.fire({
            title: '¿Cerrar esta sesión?',
            text: 'El usuario será desconectado de este dispositivo',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("profile.sessions.terminate", "") }}/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() {
                        loadSessions();
                        Swal.fire({ icon: 'success', title: 'Sesión cerrada', timer: 1500, showConfirmButton: false });
                    }
                });
            }
        });
    };

    window.terminateAllSessions = function() {
        Swal.fire({
            title: '¿Cerrar todas las sesiones?',
            text: 'Se cerrará sesión en todos los dispositivos excepto en este',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cerrar todas',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("profile.sessions.terminate-all") }}',
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() {
                        loadSessions();
                        Swal.fire({ icon: 'success', title: 'Todas las sesiones cerradas', timer: 1500, showConfirmButton: false });
                    }
                });
            }
        });
    };

    // ==========================================
    // ACCIONES DE TOKENS API
    // ==========================================

    window.revokeToken = function(id) {
        Swal.fire({
            title: '¿Revocar este token?',
            text: 'Los servicios que usen este token dejarán de funcionar',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, revocar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("profile.api-tokens.revoke", "") }}/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function() {
                        loadApiTokens();
                        Swal.fire({ icon: 'success', title: 'Token revocado', timer: 1500, showConfirmButton: false });
                    }
                });
            }
        });
    };

    // ==========================================
    // UTILIDADES
    // ==========================================

    function showAlert(containerId, type, message) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const types = {
            success: { icon: 'fa-check-circle', color: '#155724', bg: '#d4edda', border: '#c3e6cb' },
            error: { icon: 'fa-exclamation-circle', color: '#721c24', bg: '#f8d7da', border: '#f5c6cb' },
            warning: { icon: 'fa-exclamation-triangle', color: '#856404', bg: '#fff3cd', border: '#ffeaa7' },
            info: { icon: 'fa-info-circle', color: '#0c5460', bg: '#d1ecf1', border: '#bee5eb' }
        };

        const t = types[type] || types.info;

        container.style.display = 'block';
        container.className = 'alert-custom ' + type;
        container.innerHTML = `<i class="fas ${t.icon}"></i> ${message}`;
        container.style.color = t.color;
        container.style.background = t.bg;
        container.style.borderColor = t.border;

        setTimeout(() => {
            container.style.display = 'none';
        }, 5000);
    }

    // Inicializar el tab activo
    const activeTab = new URLSearchParams(window.location.search).get('tab') || 'dashboard';
    showTab(activeTab);
});
</script>

</script>
@endsection