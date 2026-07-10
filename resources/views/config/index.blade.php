@extends('layouts.navigation')

@php
    use App\Models\Config\SystemConfig;
    use App\Models\Config\CompanyInfo;
    use App\Models\Config\EmailConfig;
    use App\Models\Config\SecurityConfig;
    use App\Models\Config\ModuleConfig;
    use App\Models\Config\NotificationTemplate;
    use App\Models\Config\AuditLog;
    use App\Models\Config\SystemBackup;
@endphp

@section('content')
<style>
    /* ============================================
       ESTILOS DE CONFIGURACIÓN
       ============================================ */
    .config-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .config-header {
        background: white;
        border-radius: 16px;
        padding: 24px 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .config-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #212529;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .config-header h1 i {
        color: #083CAE;
    }

    .config-header p {
        color: #6c757d;
        margin: 4px 0 0 0;
        font-size: 14px;
    }

    .config-header .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-config {
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

    .btn-config-primary {
        background: #083CAE;
        color: white;
    }

    .btn-config-primary:hover {
        background: #0a4bc9;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(8,60,174,0.3);
    }

    .btn-config-success {
        background: #28a745;
        color: white;
    }

    .btn-config-success:hover {
        background: #218838;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }

    .btn-config-danger {
        background: #dc3545;
        color: white;
    }

    .btn-config-danger:hover {
        background: #c82333;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220,53,69,0.3);
    }

    .btn-config-outline {
        background: transparent;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .btn-config-outline:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }

    .btn-config-sm {
        padding: 6px 14px;
        font-size: 12px;
    }

    /* ===== LAYOUT ===== */
    .config-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    /* ===== SIDEBAR ===== */
    .config-sidebar {
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

    .config-sidebar .sidebar-title {
        font-size: 11px;
        font-weight: 600;
        color: #adb5bd;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 12px 12px 12px;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 12px;
    }

    .config-sidebar .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: #6c757d;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .config-sidebar .nav-item:hover {
        background: #f8f9fa;
        color: #212529;
    }

    .config-sidebar .nav-item.active {
        background: #e8f0fe;
        color: #083CAE;
    }

    .config-sidebar .nav-item i {
        width: 20px;
        text-align: center;
        font-size: 15px;
        color: #adb5bd;
    }

    .config-sidebar .nav-item.active i {
        color: #083CAE;
    }

    .config-sidebar .nav-item .badge-super {
        margin-left: auto;
        background: #dc3545;
        color: white;
        font-size: 9px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        text-transform: uppercase;
    }

    /* ===== CONTENIDO ===== */
    .config-content {
        flex: 1;
        background: white;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        padding: 28px 32px;
        min-height: 500px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .config-content .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .config-content .section-title i {
        color: #083CAE;
    }

    .config-content .section-description {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 24px;
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

    .form-group .help-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
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

    .form-control-file {
        padding: 8px;
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

    .form-row-4 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 16px;
    }

    /* ===== CHECKBOX TOGGLE ===== */
    .toggle-switch {
        position: relative;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
        display: inline-block;
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

    .toggle-container {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
    }

    .toggle-container .toggle-label {
        font-size: 14px;
        color: #495057;
        cursor: pointer;
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

    /* ===== MÉTRICAS ===== */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .metric-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 18px 20px;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .metric-card .metric-label {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .metric-card .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #212529;
        margin-top: 4px;
    }

    .metric-card .metric-icon {
        float: right;
        font-size: 24px;
        opacity: 0.4;
    }

    .metric-card.blue { background: linear-gradient(135deg, #e8f0fe, #d4e2fc); border-color: #b3cff5; }
    .metric-card.green { background: linear-gradient(135deg, #d4edda, #c3e6cb); border-color: #8fd9a8; }
    .metric-card.orange { background: linear-gradient(135deg, #fff3cd, #ffeaa7); border-color: #ffda6b; }
    .metric-card.purple { background: linear-gradient(135deg, #e8d5f5, #d4b8ed); border-color: #b88fe0; }
    .metric-card.red { background: linear-gradient(135deg, #f8d7da, #f5c6cb); border-color: #eda3ab; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .config-layout {
            flex-direction: column;
        }
        .config-sidebar {
            width: 100%;
            position: static;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 12px 16px;
        }
        .config-sidebar .sidebar-title {
            display: none;
        }
        .config-sidebar .nav-item {
            flex: 1;
            min-width: 100px;
            justify-content: center;
            padding: 8px 12px;
            font-size: 12px;
        }
        .config-content {
            padding: 20px;
        }
        .form-row, .form-row-3, .form-row-4 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .config-header {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
            padding: 20px;
        }
        .config-header .header-actions {
            justify-content: center;
        }
        .metric-grid {
            grid-template-columns: 1fr 1fr;
        }
        .config-content {
            padding: 16px;
        }
    }

    @media (max-width: 480px) {
        .metric-grid {
            grid-template-columns: 1fr;
        }
        .config-sidebar .nav-item {
            min-width: 80px;
            font-size: 11px;
            padding: 6px 10px;
        }
        .config-sidebar .nav-item i {
            font-size: 13px;
        }
    }

    /* ===== SCROLLBAR ===== */
    .config-content::-webkit-scrollbar,
    .table-container::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .config-content::-webkit-scrollbar-track,
    .table-container::-webkit-scrollbar-track {
        background: #f1f3f5;
        border-radius: 3px;
    }
    .config-content::-webkit-scrollbar-thumb,
    .table-container::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 3px;
    }
    .config-content::-webkit-scrollbar-thumb:hover,
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
</style>

<div class="config-container">
    <!-- ==========================================
    HEADER
    ========================================== -->
    <div class="config-header">
        <div>
            <h1><i class="fas fa-cog"></i> Configuración del Sistema</h1>
            <p>Gestiona todos los parámetros y configuraciones del sistema</p>
        </div>
        <div class="header-actions">
            @if($isSuperAdmin ?? false)
                <span class="badge-status active" style="font-size:12px;padding:6px 16px;">
                    <i class="fas fa-shield-alt"></i> Super Admin
                </span>
            @endif
            <button class="btn-config btn-config-primary" onclick="saveAllConfigs()">
                <i class="fas fa-save"></i> Guardar Todo
            </button>
        </div>
    </div>

    <!-- ==========================================
    LAYOUT PRINCIPAL
    ========================================== -->
    <div class="config-layout">
        <!-- SIDEBAR -->
        <div class="config-sidebar">
            <div class="sidebar-title">Menú de Configuración</div>

            <button class="nav-item active" data-tab="general" onclick="showTab('general')">
                <i class="fas fa-sliders-h"></i> General
            </button>
            <button class="nav-item" data-tab="company" onclick="showTab('company')">
                <i class="fas fa-building"></i> Empresa
            </button>
            <button class="nav-item" data-tab="email" onclick="showTab('email')">
                <i class="fas fa-envelope"></i> Correo
            </button>
            <button class="nav-item" data-tab="security" onclick="showTab('security')">
                <i class="fas fa-shield-alt"></i> Seguridad
            </button>
            <button class="nav-item" data-tab="modules" onclick="showTab('modules')">
                <i class="fas fa-cubes"></i> Módulos
            </button>
            <button class="nav-item" data-tab="templates" onclick="showTab('templates')">
                <i class="fas fa-file-alt"></i> Plantillas
            </button>
            <button class="nav-item" data-tab="audit" onclick="showTab('audit')">
                <i class="fas fa-history"></i> Auditoría
            </button>
            <button class="nav-item" data-tab="backups" onclick="showTab('backups')">
                <i class="fas fa-database"></i> Backups
            </button>
        </div>

        <!-- CONTENIDO -->
        <div class="config-content">
            <!-- ==========================================
            TAB: GENERAL
            ========================================== -->
            <div id="tab-general" class="tab-panel active">
                <div class="section-title">
                    <i class="fas fa-sliders-h"></i> Configuración General
                </div>
                <div class="section-description">
                    Configura los parámetros generales del sistema como nombre, zona horaria, moneda, etc.
                </div>

                <div id="generalAlert" style="display:none;"></div>

                <form id="generalForm">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre del Sistema</label>
                            <input type="text" name="configs[app_name][value]" class="form-control"
                                   value="{{ SystemConfig::getValue('app_name', 'Mi ERP') }}">
                        </div>
                        <div class="form-group">
                            <label>Zona Horaria</label>
                            <select name="configs[app_timezone][value]" class="form-control">
                                <option value="America/Mexico_City" {{ SystemConfig::getValue('app_timezone') == 'America/Mexico_City' ? 'selected' : '' }}>Ciudad de México</option>
                                <option value="America/Guatemala" {{ SystemConfig::getValue('app_timezone') == 'America/Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                <option value="America/New_York" {{ SystemConfig::getValue('app_timezone') == 'America/New_York' ? 'selected' : '' }}>Nueva York</option>
                                <option value="America/Los_Angeles" {{ SystemConfig::getValue('app_timezone') == 'America/Los_Angeles' ? 'selected' : '' }}>Los Ángeles</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Idioma Predeterminado</label>
                            <select name="configs[app_locale][value]" class="form-control">
                                <option value="es" {{ SystemConfig::getValue('app_locale') == 'es' ? 'selected' : '' }}>Español</option>
                                <option value="en" {{ SystemConfig::getValue('app_locale') == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moneda Predeterminada</label>
                            <select name="configs[app_currency][value]" class="form-control">
                                <option value="MXN" {{ SystemConfig::getValue('app_currency') == 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                <option value="USD" {{ SystemConfig::getValue('app_currency') == 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                <option value="EUR" {{ SystemConfig::getValue('app_currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="toggle-container">
                        <label class="toggle-switch">
                            <input type="checkbox" name="configs[maintenance_mode][value]" 
                                   value="true" {{ SystemConfig::getValue('maintenance_mode') == 'true' ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span class="toggle-label">Modo Mantenimiento</span> 
                    </div> -->

                    <button type="submit" class="btn-config btn-config-primary" id="saveGeneralBtn">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: EMPRESA
            ========================================== -->
            <div id="tab-company" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-building"></i> Información de la Empresa
                </div>
                <div class="section-description">
                    Configura los datos fiscales y de contacto de la empresa.
                </div>

                <div id="companyAlert" style="display:none;"></div>

                <form id="companyForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php $company = CompanyInfo::first(); @endphp

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Razón Social *</label>
                            <input type="text" name="razon_social" class="form-control" 
                                   value="{{ $company->razon_social ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre Comercial</label>
                            <input type="text" name="nombre_comercial" class="form-control" 
                                   value="{{ $company->nombre_comercial ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>RFC *</label>
                            <input type="text" name="rfc" class="form-control" 
                                   value="{{ $company->rfc ?? '' }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" 
                                   value="{{ $company->telefono ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ $company->email ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email de Facturación</label>
                            <input type="email" name="email_facturacion" class="form-control" 
                                   value="{{ $company->email_facturacion ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Sitio Web</label>
                            <input type="url" name="website" class="form-control" 
                                   value="{{ $company->website ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Calle</label>
                            <input type="text" name="calle" class="form-control" 
                                   value="{{ $company->calle ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Número Exterior</label>
                            <input type="text" name="num_exterior" class="form-control" 
                                   value="{{ $company->num_exterior ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Número Interior</label>
                            <input type="text" name="num_interior" class="form-control" 
                                   value="{{ $company->num_interior ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Colonia</label>
                            <input type="text" name="colonia" class="form-control" 
                                   value="{{ $company->colonia ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input type="text" name="codigo_postal" class="form-control" 
                                   value="{{ $company->codigo_postal ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Municipio</label>
                            <input type="text" name="municipio" class="form-control" 
                                   value="{{ $company->municipio ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control" 
                                   value="{{ $company->estado ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" name="pais" class="form-control" 
                                   value="{{ $company->pais ?? 'México' }}">
                        </div>
                    </div>

                    <div class="form-row">
    <div class="form-group">
        <label>Serie Predeterminada</label>
        <input type="text" name="serie_default" class="form-control" 
               value="{{ $company->serie_default ?? 'A' }}">
    </div>
    <div class="form-group">
        <label>Logo de la Empresa</label>
        <input type="file" name="logo" class="form-control form-control-file" accept="image/*">
        <div class="help-text">Formatos: JPG, PNG, SVG. Máx: 2MB</div>
        @if(isset($company) && $company->logo_path)
            <div style="margin-top:8px;">
                <img src="{{ asset('storage/' . $company->logo_path) }}" 
                     alt="Logo actual" style="max-height:60px; border:1px solid #dee2e6; padding:4px; border-radius:4px;">
            </div>
        @endif
    </div>
</div>

<!-- 🔥 NUEVA SECCIÓN: LOGO DE LOGIN -->
<div class="form-row" style="margin-top:16px; border-top:1px solid #e9ecef; padding-top:16px;">
    <div class="form-group">
        <label>Logo de Login / Pantalla de Inicio</label>
        <input type="file" name="login_logo" class="form-control form-control-file" accept="image/*">
        <div class="help-text">Formatos: JPG, PNG, SVG. Máx: 2MB. Este logo aparecerá en la pantalla de inicio de sesión.</div>
        @if(isset($company) && $company->login_logo_path)
            <div style="margin-top:8px;">
                <img src="{{ asset('storage/' . $company->login_logo_path) }}" 
                     alt="Logo de login actual" style="max-height:80px; border:1px solid #dee2e6; padding:4px; border-radius:4px;">
                <br>
                <small style="color:#6c757d;">Logo actual</small>
            </div>
        @endif
    </div>
</div>

                    <button type="submit" class="btn-config btn-config-primary" id="saveCompanyBtn">
                        <i class="fas fa-save"></i> Guardar Información
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: CORREO
            ========================================== -->
            <div id="tab-email" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-envelope"></i> Configuración de Correo
                </div>
                <div class="section-description">
                    Configura el servidor SMTP para el envío de correos electrónicos.
                </div>

                <div id="emailAlert" style="display:none;"></div>

                <form id="emailForm">
                    @csrf
                    @method('PUT')

                    @php $emailConfig = EmailConfig::first(); @endphp

                    <div class="form-row">
                        <div class="form-group">
                            <label>Servidor SMTP</label>
                            <input type="text" name="host" class="form-control" 
                                   value="{{ $emailConfig->host ?? 'smtp.gmail.com' }}">
                        </div>
                        <div class="form-group">
                            <label>Puerto</label>
                            <input type="number" name="port" class="form-control" 
                                   value="{{ $emailConfig->port ?? 587 }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Cifrado</label>
                            <select name="encryption" class="form-control">
                                <option value="tls" {{ ($emailConfig->encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($emailConfig->encryption ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ ($emailConfig->encryption ?? 'tls') == '' ? 'selected' : '' }}>Sin cifrado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" name="username" class="form-control" 
                                   value="{{ $emailConfig->username ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" 
                                   value="{{ $emailConfig->password ?? '' }}">
                            <div class="help-text">Dejar en blanco para mantener la actual</div>
                        </div>
                        <div class="form-group">
                            <label>Correo de Envío</label>
                            <input type="email" name="from_address" class="form-control" 
                                   value="{{ $emailConfig->from_address ?? '' }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre de Envío</label>
                            <input type="text" name="from_name" class="form-control" 
                                   value="{{ $emailConfig->from_name ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Correo de Respuesta</label>
                            <input type="email" name="reply_to_address" class="form-control" 
                                   value="{{ $emailConfig->reply_to_address ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email para prueba</label>
                            <input type="email" id="testEmailInput" class="form-control" 
                                   placeholder="correo@ejemplo.com" value="{{ auth()->user()->email ?? '' }}">
                        </div>
                        <div class="form-group" style="display:flex;align-items:flex-end;">
                            <button type="button" class="btn-config btn-config-success" onclick="testEmail()">
                                <i class="fas fa-paper-plane"></i> Probar Correo
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-config btn-config-primary" id="saveEmailBtn">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: SEGURIDAD
            ========================================== -->
            <div id="tab-security" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-shield-alt"></i> Configuración de Seguridad
                </div>
                <div class="section-description">
                    Configura las políticas de seguridad del sistema.
                </div>

                <div id="securityAlert" style="display:none;"></div>

                <form id="securityForm">
                    @csrf
                    @method('PUT')

                    @php $securityConfig = SecurityConfig::first(); @endphp

                    <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">Políticas de Contraseña</h4>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Longitud Mínima</label>
                            <input type="number" name="password_min_length" class="form-control" 
                                   value="{{ $securityConfig->password_min_length ?? 8 }}" min="4">
                        </div>
                        <div class="form-group">
                            <label>Días de Expiración</label>
                            <input type="number" name="password_expiration_days" class="form-control" 
                                   value="{{ $securityConfig->password_expiration_days ?? 90 }}" min="0">
                            <div class="help-text">0 = nunca expira</div>
                        </div>
                        <div class="form-group">
                            <label>Historial de Contraseñas</label>
                            <input type="number" name="password_history_count" class="form-control" 
                                   value="{{ $securityConfig->password_history_count ?? 5 }}" min="0" max="20">
                        </div>
                    </div>

                    <div class="form-row" style="margin-bottom:16px;">
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="password_require_uppercase" 
                                       value="true" {{ ($securityConfig->password_require_uppercase ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Requerir Mayúsculas</span>
                        </div>
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="password_require_lowercase" 
                                       value="true" {{ ($securityConfig->password_require_lowercase ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Requerir Minúsculas</span>
                        </div>
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="password_require_numbers" 
                                       value="true" {{ ($securityConfig->password_require_numbers ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Requerir Números</span>
                        </div>
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="password_require_special" 
                                       value="true" {{ ($securityConfig->password_require_special ?? false) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Requerir Caracteres Especiales</span>
                        </div>
                    </div>

                    <hr style="margin:20px 0;border-color:#e9ecef;">

                    <!-- <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">Autenticación y Sesiones</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Intentos Máximos de Login</label>
                            <input type="number" name="max_login_attempts" class="form-control" 
                                   value="{{ $securityConfig->max_login_attempts ?? 5 }}" min="1">
                        </div>
                        <div class="form-group">
                            <label>Tiempo de Bloqueo (minutos)</label>
                            <input type="number" name="lockout_time_minutes" class="form-control" 
                                   value="{{ $securityConfig->lockout_time_minutes ?? 15 }}" min="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="two_factor_enabled" 
                                       value="true" {{ ($securityConfig->two_factor_enabled ?? false) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Autenticación de Dos Factores (2FA)</span>
                        </div>
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="session_timeout_enabled" 
                                       value="true" {{ ($securityConfig->session_timeout_enabled ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Timeout de Sesión</span>
                        </div>
                    </div> -->

                    <hr style="margin:20px 0;border-color:#e9ecef;">

                    <h4 style="font-weight:600;color:#212529;font-size:15px;margin-bottom:12px;">Auditoría</h4>

                    <div class="form-row">
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="audit_enabled" 
                                       value="true" {{ ($securityConfig->audit_enabled ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Auditoría Activada</span>
                        </div>
                        <div class="form-group">
                            <label>Días de Retención</label>
                            <input type="number" name="audit_retention_days" class="form-control" 
                                   value="{{ $securityConfig->audit_retention_days ?? 90 }}" min="1">
                        </div>
                    </div>

                    <button type="submit" class="btn-config btn-config-primary" id="saveSecurityBtn">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>
                </form>
            </div>

            <!-- ==========================================
            TAB: MÓDULOS
            ========================================== -->
            <div id="tab-modules" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-cubes"></i> Módulos del Sistema
                </div>
                <div class="section-description">
                    Activa, desactiva y ordena los módulos del sistema.
                </div>

                <div id="modulesAlert" style="display:none;"></div>

                <div class="table-container" id="modulesList">
                    @php $modules = ModuleConfig::ordered()->get(); @endphp
                    @if($modules->count() > 0)
                        <table class="table-custom" id="modulesTable">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Módulo</th>
                                    <th>Icono</th>
                                    <th>Estado</th>
                                    <th style="width:120px;">Orden</th>
                                    <th style="width:120px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $module)
                                    <tr data-id="{{ $module->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $module->display_name }}</strong>
                                            <div style="font-size:12px;color:#6c757d;">{{ $module->name }}</div>
                                        </td>
                                        <td><i class="fas {{ $module->icon ?? 'fa-cube' }}"></i></td>
                                        <td>
                                            <span class="badge-status {{ $module->is_enabled ? 'active' : 'inactive' }}">
                                                {{ $module->is_enabled ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display:flex;gap:4px;align-items:center;">
                                                <button type="button" class="btn-config btn-config-outline btn-config-sm" onclick="moveModule({{ $module->id }}, 'up')">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <input type="number" class="form-control" style="width:60px;padding:4px 6px;font-size:12px;text-align:center;" 
                                                       value="{{ $module->order }}" min="0" 
                                                       onchange="updateModuleOrder({{ $module->id }}, this.value)">
                                                <button type="button" class="btn-config btn-config-outline btn-config-sm" onclick="moveModule({{ $module->id }}, 'down')">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn-config {{ $module->is_enabled ? 'btn-config-danger' : 'btn-config-success' }} btn-config-sm" 
                                                    onclick="toggleModule({{ $module->id }})">
                                                <i class="fas {{ $module->is_enabled ? 'fa-times' : 'fa-check' }}"></i>
                                                {{ $module->is_enabled ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-cubes" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay módulos configurados</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ==========================================
            TAB: PLANTILLAS
            ========================================== -->
            <div id="tab-templates" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i> Plantillas de Notificaciones
                </div>
                <div class="section-description">
                    Gestiona las plantillas de correo y notificaciones del sistema.
                </div>

                <div id="templatesAlert" style="display:none;"></div>

                @php $templates = NotificationTemplate::active()->get(); @endphp
                @if($templates->count() > 0)
                    @foreach($templates as $template)
                        <div style="border:1px solid #e9ecef;border-radius:10px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                                <div>
                                    <h5 style="font-weight:600;color:#212529;margin:0;font-size:15px;">
                                        {{ $template->name }}
                                        <span class="badge-status {{ $template->is_active ? 'active' : 'inactive' }}" style="font-size:10px;margin-left:8px;">
                                            {{ $template->is_active ? 'Activa' : 'Inactiva' }}
                                        </span>
                                        @if($template->is_default)
                                            <span class="badge-status info" style="font-size:10px;">Predeterminada</span>
                                        @endif
                                    </h5>
                                    <div style="font-size:12px;color:#6c757d;">
                                        Código: <code>{{ $template->code }}</code> | Tipo: {{ $template->type }} | Categoría: {{ $template->category ?? 'General' }}
                                    </div>
                                </div>
                                <button type="button" class="btn-config btn-config-outline btn-config-sm" onclick="editTemplate({{ $template->id }})">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </div>
                            <div id="templateEdit_{{ $template->id }}" style="display:none;margin-top:12px;">
                                <form onsubmit="updateTemplate(event, {{ $template->id }})">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Asunto</label>
                                        <input type="text" name="subject" class="form-control" value="{{ $template->subject ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Cuerpo (HTML)</label>
                                        <textarea name="html_body" class="form-control" rows="4">{{ $template->html_body ?? $template->body ?? '' }}</textarea>
                                    </div>
                                    <div class="form-row" style="margin-top:8px;">
                                        <div class="toggle-container">
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="is_active" value="true" {{ $template->is_active ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <span class="toggle-label">Activa</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-config btn-config-primary btn-config-sm" style="margin-top:8px;">
                                        <i class="fas fa-save"></i> Guardar Plantilla
                                    </button>
                                    <button type="button" class="btn-config btn-config-outline btn-config-sm" style="margin-top:8px;" onclick="cancelEditTemplate({{ $template->id }})">
                                        Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align:center;padding:40px;color:#adb5bd;">
                        <i class="fas fa-file-alt" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                        <p>No hay plantillas configuradas</p>
                    </div>
                @endif
            </div>

            <!-- ==========================================
            TAB: AUDITORÍA
            ========================================== -->
            <div id="tab-audit" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-history"></i> Auditoría del Sistema
                </div>
                <div class="section-description">
                    Registro de todas las acciones realizadas en el sistema.
                </div>

                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px;">
                    <div style="flex:1;min-width:150px;">
                        <select id="auditModule" class="form-control" onchange="filterAudit()">
                            <option value="">Todos los módulos</option>
                            @php $auditModules = AuditLog::distinct()->pluck('module')->filter()->values(); @endphp
                            @foreach($auditModules as $mod)
                                <option value="{{ $mod }}">{{ $mod }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex:1;min-width:150px;">
                        <select id="auditAction" class="form-control" onchange="filterAudit()">
                            <option value="">Todas las acciones</option>
                            @php $auditActions = AuditLog::distinct()->pluck('action')->filter()->values(); @endphp
                            @foreach($auditActions as $action)
                                <option value="{{ $action }}">{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex:1;min-width:150px;">
                        <input type="date" id="auditDateFrom" class="form-control" onchange="filterAudit()">
                    </div>
                    <div style="flex:1;min-width:150px;">
                        <input type="date" id="auditDateTo" class="form-control" onchange="filterAudit()">
                    </div>
                    <div>
                        <button class="btn-config btn-config-danger btn-config-sm" onclick="clearAudit()">
                            <i class="fas fa-trash"></i> Limpiar Antiguos
                        </button>
                    </div>
                </div>

                <div id="auditResults">
                    @php $logs = AuditLog::with('user')->orderBy('created_at', 'desc')->paginate(50); @endphp
                    @if($logs->count() > 0)
                        <div class="table-container">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Módulo</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $log->user->name ?? 'Sistema' }}</td>
                                            <td>
                                                <span style="display:flex;align-items:center;gap:6px;">
                                                    <i class="fas {{ $log->action_icon }}" style="color:{{ $log->action_color }};"></i>
                                                    {{ $log->description }}
                                                </span>
                                            </td>
                                            <td>{{ $log->module ?? '-' }}</td>
                                            <td>{{ $log->ip_address ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $logs->links() }}
                    @else
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-history" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay registros de auditoría</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ==========================================
            TAB: BACKUPS
            ========================================== -->
            <div id="tab-backups" class="tab-panel">
                <div class="section-title">
                    <i class="fas fa-database"></i> Backups del Sistema
                </div>
                <div class="section-description">
                    Gestiona los respaldos de la base de datos y archivos del sistema.
                </div>

                <div style="margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;">
                    <button class="btn-config btn-config-success" onclick="createBackup('database')">
                        <i class="fas fa-database"></i> Backup Base de Datos
                    </button>
                    <button class="btn-config btn-config-primary" onclick="createBackup('full')">
                        <i class="fas fa-archive"></i> Backup Completo
                    </button>
                </div>

                <div id="backupsList">
                    @php $backups = SystemBackup::orderBy('created_at', 'desc')->get(); @endphp
                    @if($backups->count() > 0)
                        <div class="table-container">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Tamaño</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($backups as $backup)
                                        <tr>
                                            <td><strong>{{ $backup->name }}</strong></td>
                                            <td>
                                                <span class="badge-status info">
                                                    {{ $backup->type === 'database' ? 'Base de Datos' : ($backup->type === 'files' ? 'Archivos' : 'Completo') }}
                                                </span>
                                            </td>
                                            <td>{{ $backup->formatted_size }}</td>
                                            <td>
                                                <span class="badge-status {{ $backup->status === 'completed' ? 'active' : ($backup->status === 'failed' ? 'inactive' : 'pending') }}">
                                                    {{ $backup->status === 'completed' ? 'Completado' : ($backup->status === 'failed' ? 'Fallido' : 'Pendiente') }}
                                                </span>
                                            </td>
                                            <td>{{ $backup->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <div style="display:flex;gap:4px;">
                                                    @if($backup->status === 'completed')
                                                        <a href="{{ route('config.backups.download', $backup->id) }}" class="btn-config btn-config-success btn-config-sm">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                    <button class="btn-config btn-config-danger btn-config-sm" onclick="deleteBackup({{ $backup->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align:center;padding:40px;color:#adb5bd;">
                            <i class="fas fa-database" style="font-size:36px;margin-bottom:12px;display:block;"></i>
                            <p>No hay backups disponibles</p>
                        </div>
                    @endif
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
    // Inicializar tab activo
    showTab('general');
});

// ============================================
// NAVEGACIÓN DE TABS
// ============================================
function showTab(tab) {
    // Ocultar todos los tabs
    document.querySelectorAll('.tab-panel').forEach(el => {
        el.classList.remove('active');
    });

    // Mostrar el tab seleccionado
    const tabId = 'tab-' + tab;
    const tabElement = document.getElementById(tabId);
    if (tabElement) {
        tabElement.classList.add('active');
    }

    // Actualizar sidebar
    document.querySelectorAll('.config-sidebar .nav-item').forEach(el => {
        el.classList.remove('active');
        if (el.dataset.tab === tab) {
            el.classList.add('active');
        }
    });
}

// ============================================
// GUARDAR CONFIGURACIÓN GENERAL
// ============================================
$('#generalForm').on('submit', function(e) {
    e.preventDefault();
    const formData = $(this).serializeArray();
    const configs = {};
    
    formData.forEach(item => {
        if (item.name.startsWith('configs[')) {
            const key = item.name.replace('configs[', '').replace('][value]', '');
            configs[key] = item.value;
        }
    });

    $('#saveGeneralBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

    $.ajax({
        url: '{{ route("config.general.update") }}',
        type: 'PUT',
        data: { configs: configs },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('generalAlert', 'success', response.message);
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.message || 'Error al guardar';
            showAlert('generalAlert', 'error', msg);
        },
        complete: function() {
            $('#saveGeneralBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Configuración');
        }
    });
});

// ============================================
// GUARDAR INFORMACIÓN DE EMPRESA
// ============================================
$('#companyForm').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    $('#saveCompanyBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

    $.ajax({
        url: '{{ route("config.company.update") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('companyAlert', 'success', response.message);
        },
        error: function(xhr) {
            const errors = xhr.responseJSON?.errors || {};
            const msg = Object.values(errors).flat()[0] || 'Error al guardar';
            showAlert('companyAlert', 'error', msg);
        },
        complete: function() {
            $('#saveCompanyBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Información');
        }
    });
});

// ============================================
// GUARDAR CONFIGURACIÓN DE CORREO
// ============================================
$('#emailForm').on('submit', function(e) {
    e.preventDefault();

    $('#saveEmailBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

    $.ajax({
        url: '{{ route("config.email.update") }}',
        type: 'PUT',
        data: $(this).serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('emailAlert', 'success', response.message);
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.message || 'Error al guardar';
            showAlert('emailAlert', 'error', msg);
        },
        complete: function() {
            $('#saveEmailBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Configuración');
        }
    });
});

// ============================================
// PROBAR CORREO
// ============================================
function testEmail() {
    const to = document.getElementById('testEmailInput').value;
    
    if (!to) {
        Swal.fire({ icon: 'warning', title: 'Error', text: 'Ingresa un correo para la prueba' });
        return;
    }

    Swal.fire({
        title: 'Probando correo...',
        text: 'Enviando correo de prueba a ' + to,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '{{ route("config.email.test") }}',
        type: 'POST',
        data: { to: to },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            if (response.success) {
                Swal.fire({ icon: 'success', title: '¡Éxito!', text: response.message });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response.message });
            }
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.message || 'Error al enviar correo';
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        }
    });
}

// ============================================
// GUARDAR CONFIGURACIÓN DE SEGURIDAD
// ============================================
$('#securityForm').on('submit', function(e) {
    e.preventDefault();

    $('#saveSecurityBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

    $.ajax({
        url: '{{ route("config.security.update") }}',
        type: 'PUT',
        data: $(this).serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('securityAlert', 'success', response.message);
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.message || 'Error al guardar';
            showAlert('securityAlert', 'error', msg);
        },
        complete: function() {
            $('#saveSecurityBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Configuración');
        }
    });
});

// ============================================
// MÓDULOS - TOGGLE
// ============================================
function toggleModule(id) {
    Swal.fire({
        title: '¿Cambiar estado del módulo?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#083CAE',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("config.modules.toggle", "") }}/' + id,
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: '¡Éxito!', text: response.message, timer: 1500, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error al cambiar el estado del módulo' });
                }
            });
        }
    });
}

// ============================================
// MÓDULOS - ORDEN
// ============================================
function moveModule(id, direction) {
    const rows = document.querySelectorAll('#modulesTable tbody tr');
    let currentIndex = -1;
    
    rows.forEach((row, index) => {
        if (row.dataset.id == id) {
            currentIndex = index;
        }
    });
    
    if (currentIndex === -1) return;
    
    let newIndex = direction === 'up' ? currentIndex - 1 : currentIndex + 1;
    if (newIndex < 0 || newIndex >= rows.length) return;
    
    const parent = rows[currentIndex].parentNode;
    if (direction === 'up') {
        parent.insertBefore(rows[currentIndex], rows[newIndex]);
    } else {
        parent.insertBefore(rows[newIndex + 1], rows[currentIndex]);
    }
    
    updateAllOrders();
}

function updateModuleOrder(id, value) {
    updateAllOrders();
}

function updateAllOrders() {
    const rows = document.querySelectorAll('#modulesTable tbody tr');
    const modules = [];
    
    rows.forEach((row, index) => {
        const id = row.dataset.id;
        const orderInput = row.querySelector('input[type="number"]');
        if (orderInput) {
            orderInput.value = index;
            modules.push({ id: id, order: index });
        }
    });
    
    $.ajax({
        url: '{{ route("config.modules.order") }}',
        type: 'PUT',
        data: { modules: modules },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('modulesAlert', 'success', response.message);
        },
        error: function() {
            showAlert('modulesAlert', 'error', 'Error al actualizar el orden');
        }
    });
}

// ============================================
// PLANTILLAS - EDITAR
// ============================================
function editTemplate(id) {
    document.getElementById('templateEdit_' + id).style.display = 'block';
}

function cancelEditTemplate(id) {
    document.getElementById('templateEdit_' + id).style.display = 'none';
}

function updateTemplate(event, id) {
    event.preventDefault();
    const form = event.target;
    const formData = $(form).serialize();

    $.ajax({
        url: '{{ route("config.templates.update", "") }}/' + id,
        type: 'PUT',
        data: formData,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            showAlert('templatesAlert', 'success', response.message);
            cancelEditTemplate(id);
            setTimeout(() => location.reload(), 1500);
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.message || 'Error al actualizar';
            showAlert('templatesAlert', 'error', msg);
        }
    });
}

// ============================================
// AUDITORÍA - FILTROS
// ============================================
function filterAudit() {
    const module = document.getElementById('auditModule').value;
    const action = document.getElementById('auditAction').value;
    const dateFrom = document.getElementById('auditDateFrom').value;
    const dateTo = document.getElementById('auditDateTo').value;
    
    let url = '{{ route("config.audit") }}?';
    if (module) url += 'module=' + module + '&';
    if (action) url += 'action=' + action + '&';
    if (dateFrom) url += 'date_from=' + dateFrom + '&';
    if (dateTo) url += 'date_to=' + dateTo + '&';
    
    window.location.href = url;
}

function clearAudit() {
    Swal.fire({
        title: '¿Limpiar auditoría antigua?',
        text: 'Se eliminarán todos los registros de auditoría que superen los días de retención configurados',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, limpiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("config.audit.clear") }}',
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: '¡Completado!', text: response.message });
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error al limpiar auditoría' });
                }
            });
        }
    });
}

// ============================================
// BACKUPS
// ============================================
function createBackup(type) {
    const labels = {
        database: 'Base de Datos',
        files: 'Archivos',
        full: 'Completo'
    };

    Swal.fire({
        title: 'Crear Backup',
        text: '¿Deseas crear un backup de ' + labels[type] + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, crear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Creando backup...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("config.backups.create") }}',
                type: 'POST',
                data: { type: type },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: '¡Completado!', text: response.message });
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Error al crear backup';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
        }
    });
}

function deleteBackup(id) {
    Swal.fire({
        title: '¿Eliminar backup?',
        text: 'Esta acción eliminará el archivo de backup permanentemente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("config.backups.delete", "") }}/' + id,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: '¡Eliminado!', text: response.message });
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error al eliminar backup' });
                }
            });
        }
    });
}

// ============================================
// GUARDAR TODO
// ============================================
function saveAllConfigs() {
    Swal.fire({
        title: 'Guardar todas las configuraciones',
        text: '¿Deseas guardar todos los cambios realizados?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#083CAE',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, guardar todo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Disparar todos los submits de formularios
            document.getElementById('generalForm').dispatchEvent(new Event('submit'));
            document.getElementById('companyForm').dispatchEvent(new Event('submit'));
            document.getElementById('emailForm').dispatchEvent(new Event('submit'));
            document.getElementById('securityForm').dispatchEvent(new Event('submit'));
            
            Swal.fire({
                icon: 'success',
                title: 'Guardando...',
                text: 'Todas las configuraciones están siendo guardadas',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}

// ============================================
// UTILIDADES
// ============================================
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
</script>
@endsection