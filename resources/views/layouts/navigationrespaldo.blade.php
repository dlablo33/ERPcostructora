<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MejoraSoft')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'construction-blue': '#083CAE',
                        'construction-dark': '#083CAE',
                        'construction-light': '#3b82f6',
                        'construction-orange': '#f97316',
                        'construction-green': '#10b981',
                        'construction-purple': '#8b5cf6',
                        'construction-yellow': '#f59e0b',
                        'construction-red': '#ef4444'
                    }
                }
            }
        }
    </script>

<style>
    /* ========== VARIABLES DE COLOR PERSONALIZABLES ========== */
    :root {
        --color-primary: #083CAE;      /* Color azul principal */
        --color-secondary: #2CBF1F;    /* Color verde secundario */
        --color-accent: #ffff00;       /* Color amarillo de acento */
        --navbar-height: 64px;
        --tabbar-height: 45px;
        --total-header-height: calc(var(--navbar-height) + var(--tabbar-height));
    }

    /* Paletas de colores específicas para cada menú - TODAS AZUL #083CAE */
    .color-scheme-bi {
        --menu-primary: #083CAE;      /* Azul para BI */
        --menu-secondary: #083CAE;
        --menu-accent: #facc15;
    }

    .color-scheme-administracion {
        --menu-primary: #083CAE;      /* Azul para Administración */
        --menu-secondary: #083CAE;
        --menu-accent: #fbbf24;
    }

    .color-scheme-contabilidad {
        --menu-primary: #083CAE;      /* Azul para Contabilidad */
        --menu-secondary: #083CAE;
        --menu-accent: #fbbf24;
    }

    .color-scheme-proyectos {
        --menu-primary: #083CAE;      /* Azul para Proyectos */
        --menu-secondary: #083CAE;
        --menu-accent: #facc15;
    }

    .color-scheme-rrhh {
        --menu-primary: #083CAE;      /* Azul para RRHH */
        --menu-secondary: #083CAE;
        --menu-accent: #fca5a5;
    }

    /* Aplicar paleta por defecto */
    .dropdown-container {
        --menu-primary: var(--color-primary);
        --menu-secondary: var(--color-secondary);
        --menu-accent: var(--color-accent);
    }

    /* ========== RESET DE MARGENES Y PADDINGS ========== */
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    }

    /* ========== NAVBAR SUPERIOR ========== */
    nav.bg-construction-dark {
        z-index: 1050 !important;
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        height: var(--navbar-height);
        background-color: #083CAE !important;
    }

    /* ========== BARRA DE PESTAÑAS ========== */
    .tab-navigation-bar {
        background-color: var(--color-secondary) !important;
        height: var(--tabbar-height);
        display: flex;
        align-items: center;
        padding: 0 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        position: fixed;
        top: var(--navbar-height);
        left: 0;
        right: 0;
        z-index: 900;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }

    /* Clase para ocultar la barra de pestañas */
    .tab-navigation-bar.hidden {
        transform: translateY(-100%);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    /* Botón cerrar todo */
    .close-all-tabs-btn {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        margin-right: 15px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .close-all-tabs-btn:hover {
        background-color: rgba(255,255,255,0.3);
    }

    /* Contenedor de pestañas */
    .tabs-container-nav {
        display: flex;
        align-items: center;
        flex: 1;
        overflow-x: auto;
        height: 100%;
        padding: 5px 0;
        gap: 5px;
    }

    /* Pestaña individual */
    .tab-item {
        background-color: rgba(255,255,255,0.9);
        height: 35px;
        min-width: 150px;
        max-width: 200px;
        border-radius: 4px 4px 0 0;
        display: flex;
        align-items: center;
        padding: 0 10px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .tab-item.active {
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transform: translateY(1px);
    }

    .tab-item:hover {
        background-color: #f8f9fa;
    }

    .tab-title {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        color: #333;
    }

    .tab-close-btn {
        background: none;
        border: none;
        color: #666;
        font-size: 16px;
        cursor: pointer;
        padding: 0 5px;
        margin-left: 5px;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tab-close-btn:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    /* Indicador de pestaña activa */
    .active-tab-indicator {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background-color: var(--color-secondary);
        border-radius: 3px 3px 0 0;
    }

    /* Estilos para scrollbar */
    .tabs-container-nav::-webkit-scrollbar {
        height: 4px;
    }

    .tabs-container-nav::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
    }

    .tabs-container-nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 2px;
    }

    /* Botón nueva pestaña */
    .new-tab-btn {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        margin-left: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }

    .new-tab-btn:hover {
        background-color: rgba(255,255,255,0.3);
    }

    /* ========== CONTENIDO PRINCIPAL ========== */
    /* Contenedor principal que se ajusta según la barra de pestañas */
    .main-content-container {
        margin-top: var(--total-header-height);
        min-height: calc(100vh - var(--total-header-height));
        transition: margin-top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    /* Cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .main-content-container {
        margin-top: var(--navbar-height);
        min-height: calc(100vh - var(--navbar-height));
    }

    /* Clase para forzar margen cuando sea necesario */
    .content-with-tabbar {
        margin-top: var(--total-header-height) !important;
        min-height: calc(100vh - var(--total-header-height)) !important;
        transition: margin-top 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .content-no-tabbar {
        margin-top: var(--navbar-height) !important;
        min-height: calc(100vh - var(--navbar-height)) !important;
        transition: margin-top 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* ========== BARRA LATERAL DE ACCESOS RÁPIDOS ========== */
    .quick-sidebar {
        position: fixed;
        top: var(--total-header-height);
        right: -350px;
        width: 350px;
        height: calc(100vh - var(--total-header-height));
        background: white;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: right 0.3s ease-in-out;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }
    
    /* Ajuste cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .quick-sidebar {
        top: var(--navbar-height);
        height: calc(100vh - var(--navbar-height));
    }
    
    .quick-sidebar.open {
        right: 0;
    }

    /* Overlay de la barra lateral */
    .sidebar-overlay {
        position: fixed;
        top: var(--total-header-height);
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 950;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    /* Ajuste cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .sidebar-overlay {
        top: var(--navbar-height);
    }
    
    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Botón flotante de favoritos */
    .sidebar-toggle-btn {
        position: fixed;
        top: calc(var(--total-header-height) + 20px);
        right: 20px;
        z-index: 1005;
        transition: all 0.3s ease;
    }
    
    /* Ajuste cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .sidebar-toggle-btn {
        top: calc(var(--navbar-height) + 20px);
    }
    
    .sidebar-toggle-btn.moved {
        right: 370px;
    }

    /* ========== MENÚS DESPLEGABLES - SIN SOMBRAS NI DEGRADADOS ========== */
    .dropdown-container {
        position: fixed;
        top: var(--total-header-height);
        left: 50%;
        transform: translateX(-50%) translateY(-30px);
        width: 95%;
        max-width: 1400px;
        max-height: calc(90vh - var(--total-header-height));
        background: white;
        border-radius: 8px;
        box-shadow: none !important; /* Eliminada sombra */
        z-index: 1001;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        pointer-events: none;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .dropdown-container {
        top: var(--navbar-height);
        max-height: calc(90vh - var(--navbar-height));
    }

    .dropdown-container.active {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
        pointer-events: auto;
        animation: dropdownSlide 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Animación de despliegue */
    @keyframes dropdownSlide {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    /* Flecha indicadora - AZUL #083CAE SIN SOMBRA NI DEGRADADO */
    .dropdown-container::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid #083CAE !important; /* Azul sólido sin sombra */
        z-index: 1;
    }

    /* ========== ENCABEZADO DEL DROPDOWN - AZUL #083CAE SÓLIDO ========== */
    .dropdown-header {
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        flex-shrink: 0;
        background-color: #2cbf1f !important; /* Azul sólido sin degradado */
        color: white !important;
        border-radius: 8px 8px 0 0;
        min-height: auto;
    }

    /* Texto del encabezado */
    .dropdown-header h2 {
        color: white !important;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .dropdown-header p {
        color: rgba(255,255,255,0.9) !important;
        font-size: 0.95rem;
        margin: 0;
        margin-top: 0.375rem;
        line-height: 1.4;
    }

    /* Botón cerrar dropdown */
    .dropdown-close {
        cursor: pointer;
        transition: all 0.2s ease;
        color: white !important;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 1.25rem;
    }
    
    .dropdown-close:hover {
        transform: rotate(90deg);
        background: rgba(0, 0, 0, 0.2);
        color: white !important;
    }
    
    /* ========== CONTENIDO DEL DROPDOWN ========== */
    .dropdown-content {
        padding: 0;
        overflow-y: auto;
        max-height: calc(90vh - var(--total-header-height) - 90px);
        display: flex;
        flex: 1;
        opacity: 0;
        transition: opacity 0.2s ease 0.1s;
    }

    /* Cuando la barra de pestañas está oculta */
    .tab-navigation-bar.hidden ~ .dropdown-container .dropdown-content {
        max-height: calc(90vh - var(--navbar-height) - 90px);
    }

    .dropdown-container.active .dropdown-content {
        opacity: 1;
    }
    
    /* ========== PANEL IZQUIERDO - AZUL #083CAE SÓLIDO ========== */
    .dropdown-left-panel {
        width: 280px;
        border-right: 1px solid #083CAE !important; /* Borde azul sólido */
        padding: 1.75rem;
        overflow-y: auto;
        flex-shrink: 0;
        background: #083CAE !important; /* Fondo azul sólido sin degradado */
        color: white;
    }

    /* Título del panel izquierdo */
    .dropdown-left-panel h3 {
        color: white !important;
        font-weight: 600;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--menu-accent);
        font-size: 1.125rem;
    }
    
    /* ========== ELEMENTOS DEL MENÚ DEL PANEL IZQUIERDO ========== */
    .menu-title-item {
        padding: 0.875rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        background-color: rgba(255,255,255,0.1);
        color: white;
    }
    
    .menu-title-item:hover {
        background-color: rgba(255,255,255,0.2) !important; /* Sin color-mix */
        transform: translateX(3px);
    }
    
    .menu-title-item.active {
        background-color: rgba(255,255,255,0.15) !important; /* Sin color-mix */
        border-left-color: var(--menu-accent) !important;
        color: white;
    }

    /* Contenedor del ítem del menú */
    .menu-title-item .flex.items-center {
        display: flex;
        align-items: center;
    }

    /* Iconos en el panel izquierdo - SIN FONDO NI BORDE */
    .menu-title-item .w-10.h-10 {
        background-color: transparent !important;
        border: none !important;
        border-radius: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        box-shadow: none !important;
    }

    .menu-title-item i {
        color: var(--menu-accent) !important;
        font-size: 1.125rem;
    }

    /* Texto en el panel izquierdo */
    .menu-title-item .font-medium {
        color: white !important;
        font-weight: 500;
        font-size: 0.95rem;
    }

    /* ========== PANEL DERECHO - AZUL #083CAE SÓLIDO ========== */
    .dropdown-right-panel {
        flex: 1;
        padding: 1.75rem;
        overflow-y: auto;
        background: #083CAE !important; /* Fondo azul sólido sin degradado */
        color: white;
    }
    
    /* ========== TARJETAS DE CONTENIDO EN PANEL DERECHO ========== */
    .content-card {
        padding: 1.25rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid rgba(255,255,255,0.2);
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        color: white;
    }
    
    .content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-color: var(--menu-accent);
        background-color: rgba(255, 255, 255, 0.15);
    }
    
    /* Icono de la tarjeta - SIN FONDO NI BORDE */
    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
        background-color: transparent !important;
        border: none !important;
    }
    
    /* Icono dentro de la tarjeta */
    .card-icon i {
        color: var(--menu-accent) !important;
        font-size: 1.5rem;
    }
    
    .card-content {
        flex: 1;
    }
    
    .card-title {
        font-weight: 600;
        color: white !important;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }
    
    .card-description {
        font-size: 0.875rem;
        color: rgba(255,255,255,0.9) !important;
        line-height: 1.4;
    }
    
    .card-action {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: 1rem;
    }
    
    /* Botón favorito */
    .btn-favorite {
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: rgba(255,255,255,0.7);
        background: none;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-favorite:hover {
        background-color: rgba(255,255,255,0.15); /* Sin color-mix */
        color: var(--menu-accent);
    }
    
    .btn-favorite.active {
        color: var(--menu-accent);
    }
    
    /* Flecha de navegación */
    .card-action i.fa-arrow-right {
        color: var(--menu-accent) !important;
        font-size: 0.875rem;
    }
    
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1rem;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        :root {
            --navbar-height: 64px;
            --tabbar-height: 45px;
        }

        /* Ajustes para móvil del dropdown */
        .dropdown-container {
            top: var(--total-header-height);
            left: 0;
            right: 0;
            transform: translateX(0) translateY(-30px);
            width: 100%;
            max-width: 100%;
            border-radius: 0 0 8px 8px;
            margin: 0;
            border-left: none;
            border-right: none;
            max-height: calc(90vh - var(--total-header-height));
        }
        
        /* Cuando la barra de pestañas está oculta en móvil */
        .tab-navigation-bar.hidden ~ .dropdown-container {
            top: var(--navbar-height);
            max-height: calc(90vh - var(--navbar-height));
        }
        
        .dropdown-container.active {
            transform: translateX(0) translateY(0);
        }
        
        .dropdown-content {
            flex-direction: column;
            max-height: calc(90vh - var(--total-header-height) - 90px);
        }
        
        /* Cuando la barra de pestañas está oculta en móvil */
        .tab-navigation-bar.hidden ~ .dropdown-container .dropdown-content {
            max-height: calc(90vh - var(--navbar-height) - 90px);
        }
        
        .dropdown-left-panel {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #083CAE !important;
            max-height: 200px;
            padding: 1.25rem;
        }
        
        .dropdown-right-panel {
            border-top: 1px solid #083CAE !important;
            padding: 1.25rem;
        }
        
        .cards-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-sidebar {
            width: 100%;
            right: -100%;
        }
        
        .sidebar-toggle-btn.moved {
            right: 20px;
        }

        /* Header más pequeño en móvil */
        .dropdown-header {
            padding: 1rem 1.25rem;
        }

        .dropdown-header h2 {
            font-size: 1.25rem;
        }

        .dropdown-header p {
            font-size: 0.85rem;
        }

        .dropdown-close {
            width: 32px;
            height: 32px;
        }

        /* Ajustes responsive para panel izquierdo */
        .dropdown-left-panel h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .menu-title-item {
            padding: 0.75rem;
            margin-bottom: 0.375rem;
        }

        .menu-title-item .w-10.h-10 {
            width: 28px;
            height: 28px;
            margin-right: 10px;
        }

        .menu-title-item i {
            font-size: 1rem;
        }

        .menu-title-item .font-medium {
            font-size: 0.875rem;
        }

        /* Ajustes para panel derecho en móvil */
        .content-card {
            padding: 1rem;
        }

        .card-icon {
            width: 36px;
            height: 36px;
        }

        .card-icon i {
            font-size: 1.25rem;
        }

        .card-title {
            font-size: 0.95rem;
        }
        
        .card-description {
            font-size: 0.8125rem;
        }
    }

    @media (max-width: 576px) {
        .cards-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .content-card {
            padding: 0.875rem;
        }

        .dropdown-header h2 {
            font-size: 1.125rem;
        }

        .dropdown-header p {
            font-size: 0.8rem;
        }

        .dropdown-left-panel,
        .dropdown-right-panel {
            padding: 1rem;
        }
    }
    
    /* ========== SCROLLBAR PERSONALIZADO ========== */
    .dropdown-left-panel::-webkit-scrollbar,
    .dropdown-right-panel::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-left-panel::-webkit-scrollbar-track,
    .dropdown-right-panel::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .dropdown-left-panel::-webkit-scrollbar-thumb,
    .dropdown-right-panel::-webkit-scrollbar-thumb {
        background: var(--menu-accent);
        border-radius: 3px;
    }

    .dropdown-left-panel::-webkit-scrollbar-thumb:hover,
    .dropdown-right-panel::-webkit-scrollbar-thumb:hover {
        background: color-mix(in srgb, var(--menu-accent) 80%, black);
    }

    /* ========== EFECTO DE SEPARACIÓN ENTRE SECCIONES ========== */
    #bi-content > div,
    #administracion-content > div,
    #contabilidad-content > div,
    #proyectos-content > div,
    #rrhh-content > div {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ========== UTILIDADES PARA AJUSTAR CONTENIDO ========== */
    /* Esta clase se aplicará dinámicamente con JavaScript */
    .page-content-adjust {
        transition: margin-top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== MEJORAS DE TIPOGRAFÍA Y ESPACIADO ========== */
    .dropdown-left-panel,
    .dropdown-right-panel {
        line-height: 1.5;
    }

    /* ========== EFECTOS DE TRANSICIÓN SUAVES ========== */
    .menu-title-item,
    .content-card,
    .btn-favorite,
    .dropdown-close {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* ========== MEJORAS DE ACCESIBILIDAD ========== */
    .menu-title-item:focus-visible,
    .content-card:focus-visible,
    .btn-favorite:focus-visible,
    .dropdown-close:focus-visible {
        outline: 2px solid var(--menu-accent);
        outline-offset: 2px;
    }

    /* ========== ESTADOS DE CARGA Y DISABLED ========== */
    .menu-title-item.disabled,
    .content-card.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ========== SOMBRAS ELIMINADAS COMPLETAMENTE ========== */
    .dropdown-container {
        box-shadow: none !important;
    }

    /* ========== COLORES DE ENFOQUE ========== */
    .menu-title-item:active,
    .content-card:active {
        transform: scale(0.98);
    }
</style>

</head>


<body class="bg-gray-50">
    <!-- Top Navigation Bar , cambia todos los azules  por este azul #0700fa y los verdes por este verde 00ff07 y haz el encabezado del dropdown mas peque;o -->
    <nav x-data="{ mobileMenuOpen: false }" class="bg-construction-dark text-white shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-8xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Left side: Logo and Hamburger -->
                <div class="flex items-center space-x-4">
                    <!-- Hamburger button for mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md hover:bg-blue-800">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                            <img 
                                src="../img/login/logo-canva.png" 
                                alt="Logo Empresa" 
                                class="h-10 w-auto"
                                onerror="this.src='https://via.placeholder.com/150x40/083CAE/FFFFFF?text=LOGO+CONSTRUCCIÓN'"
                            >
                        </a>
                    </div>
                </div>

                <!-- Center: Top Menu Bar -->
                <div class="hidden md:flex items-center space-x-1">
                    <!-- BI -->
                    <div class="relative">
                        <button id="trigger-bi" onclick="toggleDropdown('bi')" 
                                class="dropdown-trigger-btn px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-chart-line"></i>
                            <span>BI</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"></i>
                        </button>
                    </div>

                    <!-- Administración -->
                    <div class="relative">
                        <button id="trigger-administracion" onclick="toggleDropdown('administracion')" 
                                class="dropdown-trigger-btn px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Administración</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"></i>
                        </button>
                    </div>

                    <!-- Contabilidad -->
                    <div class="relative">
                        <button id="trigger-contabilidad" onclick="toggleDropdown('contabilidad')" 
                                class="dropdown-trigger-btn px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-calculator"></i>
                            <span>Contabilidad</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"></i>
                        </button>
                    </div>
                    
                    <!-- Proyectos -->
                    <div class="relative">
                        <button id="trigger-proyectos" onclick="toggleDropdown('proyectos')" 
                                class="dropdown-trigger-btn px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-project-diagram"></i>
                            <span>Proyectos</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"></i>
                        </button>
                    </div>

                    <!-- Recursos Humanos -->
                    <div class="relative">
                        <button id="trigger-rrhh" onclick="toggleDropdown('rrhh')" 
                                class="dropdown-trigger-btn px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-users"></i>
                            <span>Recursos Humanos</span>
                            <i class="fas fa-chevron-down text-xs transition-transform"></i>
                        </button>
                    </div>

                    <!-- Botón para abrir barra lateral -->
                    <button onclick="toggleSidebar()" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition relative" title="Accesos rápidos">
                        <i class="fas fa-star"></i>
                        <span id="notification-dot" class="absolute top-1 right-1 w-2 h-2 bg-yellow-500 rounded-full" style="display: none;"></span>
                    </button>

                    <!-- Sistema de Notificaciones -->
                    <div x-data="notifications()" x-init="initNotifications()" class="relative">
                        <button @click="toggleNotifications()" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition relative">
                            <i class="fas fa-bell"></i>
                            <span x-show="unreadCount > 0" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            <span x-show="unreadCount > 0" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-xs rounded-full flex items-center justify-center" 
                                  x-text="unreadCount > 9 ? '9+' : unreadCount" style="display: none;"></span>
                        </button>
                        
                        <!-- Menú de notificaciones -->
                        <div x-show="isOpen" @click.away="isOpen = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl z-50 border border-gray-200 overflow-hidden">
                            
                            <!-- Encabezado -->
                            <div class="bg-construction-dark text-white p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="font-bold text-lg">
                                            <i class="fas fa-bell mr-2"></i>Notificaciones
                                            <span x-show="unreadCount > 0" class="ml-2 bg-red-500 text-xs px-2 py-1 rounded-full" 
                                                  x-text="unreadCount"></span>
                                        </h3>
                                        <p class="text-blue-100 text-sm mt-1">Tus alertas y mensajes importantes</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button @click="markAllAsRead()" class="p-2 rounded-lg hover:bg-blue-800 transition" title="Marcar todo como leído">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                        <button @click="clearAll()" class="p-2 rounded-lg hover:bg-blue-800 transition" title="Limpiar todo">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Filtros -->
                                <div class="flex space-x-2 mt-3">
                                    <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-blue-500' : 'bg-blue-800/50'"
                                            class="px-3 py-1 rounded-lg text-sm transition">Todas</button>
                                    <button @click="filter = 'unread'" :class="filter === 'unread' ? 'bg-blue-500' : 'bg-blue-800/50'"
                                            class="px-3 py-1 rounded-lg text-sm transition">No leídas</button>
                                    <button @click="filter = 'important'" :class="filter === 'important' ? 'bg-blue-500' : 'bg-blue-800/50'"
                                            class="px-3 py-1 rounded-lg text-sm transition">Importantes</button>
                                </div>
                            </div>
                            
                            <!-- Lista de notificaciones -->
                            <div class="max-h-96 overflow-y-auto">
                                <div x-show="filteredNotifications.length === 0" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-bell-slash text-3xl mb-3 opacity-30"></i>
                                    <p class="font-medium">No hay notificaciones</p>
                                    <p class="text-sm mt-2">Todo está al día</p>
                                </div>
                                
                                <template x-for="(notification, index) in filteredNotifications" :key="notification.id">
                                    <div :class="notification.read ? 'bg-white' : 'bg-blue-50'"
                                         class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="p-4 flex items-start space-x-3 cursor-pointer"
                                             @click="markAsRead(notification.id)">
                                            
                                            <!-- Icono de tipo -->
                                            <div :class="getTypeClass(notification.type)"
                                                 class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink=0">
                                                <i :class="getTypeIcon(notification.type)"></i>
                                            </div>
                                            
                                            <!-- Contenido -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-semibold text-gray-800" x-text="notification.title"></h4>
                                                    <span class="text-xs text-gray-500 ml-2 whitespace-nowrap" 
                                                          x-text="formatTime(notification.timestamp)"></span>
                                                </div>
                                                <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                                                
                                                <!-- Acciones -->
                                                <div class="flex justify-between items-center mt-3">
                                                    <div class="flex items-center space-x-3">
                                                        <template x-if="notification.category">
                                                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600"
                                                                  x-text="notification.category"></span>
                                                        </template>
                                                        <template x-if="notification.priority === 'high'">
                                                            <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>Urgente
                                                            </span>
                                                        </template>
                                                    </div>
                                                    
                                                    <div class="flex items-center space-x-2">
                                                        <button @click.stop="deleteNotification(notification.id)"
                                                                class="text-gray-400 hover:text-red-500 p-1 rounded transition">
                                                            <i class="fas fa-times text-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Indicador de no leído -->
                                            <div x-show="!notification.read" class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Pie -->
                            <div class="bg-gray-50 p-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <a href="#" @click="viewAll()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Ver todas las notificaciones
                                    </a>
                                    <button @click="loadMore()" x-show="hasMore" class="text-gray-600 hover:text-gray-800 text-sm">
                                        Cargar más
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <!-- Right side: User menu -->
                <div class="flex items-center space-x-4">
                    <!-- User info -->
                    <div class="hidden md:block text-right">
                        <div class="font-semibold" id="user-display-name">{{ Auth::user()->name ?? 'Usuario' }}</div>
                        <div class="text-sm text-blue-100" id="user-email">{{ Auth::user()->email ?? 'usuario@sistema.com' }}</div>
                    </div>
                    
                    <!-- User dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-800">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-64 bg-white text-gray-800 rounded-lg shadow-xl z-50 py-2 border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="font-semibold" id="dropdown-user-name">{{ Auth::user()->name ?? 'Usuario' }}</div>
                                <div class="text-sm text-gray-500 truncate" id="dropdown-user-email">{{ Auth::user()->email ?? 'usuario@sistema.com' }}</div>
                            </div>
                            
                            <a href="#" class="block px-4 py-3 hover:bg-blue-50 transition-colors">
                                <i class="fas fa-user mr-3 text-blue-600 w-5 text-center"></i> 
                                <span>Mi Perfil</span>
                            </a>
                            
                            <a href="#" class="block px-4 py-3 hover:bg-blue-50 transition-colors">
                                <i class="fas fa-cog mr-3 text-blue-600 w-5 text-center"></i> 
                                <span>Configuración</span>
                            </a>
                            
                            <a href="{{ route('tareas.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition-colors">
                                <i class="fas fa-book mr-3 text-blue-600 w-5 text-center"></i> 
                                <span>Tareas</span>
                            </a>
                            
                            <hr class="my-2 border-gray-200">
                            
                            <button onclick="confirmLogout()" 
                                    class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-600 transition-colors">
                                <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i> 
                                <span>Cerrar Sesión</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Barra de pestañas de navegación -->
    <div class="tab-navigation-bar">
        <button class="close-all-tabs-btn" id="closeAllTabsBtn">
            <span>×</span> Cerrar Todo
        </button>
        
        <div class="tabs-container-nav" id="tabsNavContainer">
            <!-- Las pestañas se generan dinámicamente aquí -->
        </div>
        
        <button class="new-tab-btn" id="newTabBtn">+</button>
    </div>

    <!-- DROPDOWNS DE MENÚS -->
    
    <!-- Dropdown de BI -->
    <div id="dropdown-bi" class="dropdown-container">
        <div class="dropdown-header bg-blue-600 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-chart-line text-2xl"></i>
                <div>
                    <h2 class="text-2xl font-bold">Business Intelligence</h2>
                    <p class="text-blue-100">Dashboards y análisis de negocio</p>
                </div>
            </div>
            <button onclick="closeDropdown('bi')" class="dropdown-close text-white hover:text-gray-200 p-2">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="dropdown-content">
            <!-- Panel izquierdo - Títulos principales -->
            <div class="dropdown-left-panel">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Secciones</h3>
                <div class="space-y-2">
                    <div class="menu-title-item active" onclick="selectTitle('bi', 'dashboard')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-tachometer-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Dashboard</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('bi', 'ventas')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Ventas</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('bi', 'facturacion')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-file-invoice-dollar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Facturación</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('bi', 'cobranza')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Cobranza</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel derecho - Contenido del título seleccionado -->
            <div class="dropdown-right-panel">
                <div id="bi-content">
                    <!-- Contenido para Dashboard -->
                    <div id="bi-dashboard-content" class="cards-grid">
                        <div class="content-card" onclick="window.location.href='{{ route('bi.dashboard') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-tie text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Directivo</div>
                                <div class="card-description">Dashboard ejecutivo de alto nivel</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Directivo', 'fas fa-user-tie', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="window.location.href='{{ route('bi.finanzas') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-pie text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Finanzas</div>
                                <div class="card-description">Métricas financieras clave</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Finanzas', 'fas fa-chart-pie', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="window.location.href='{{ route('bi.licitaciones') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-gavel text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Licitaciones</div>
                                <div class="card-description">Seguimiento de procesos licitatorios</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Licitaciones', 'fas fa-gavel', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Ventas (oculto inicialmente) -->
                    <div id="bi-ventas-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="window.location.href='{{ route('ventas.papeline') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-filter text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Pipeline de Proyectos</div>
                                <div class="card-description">Seguimiento de oportunidades de venta</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Pipeline de Proyectos', 'fas fa-filter', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="window.location.href='{{ route('ventas.propuestas') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Propuestas y Cotizaciones</div>
                                <div class="card-description">Gestión de propuestas comerciales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Propuestas y Cotizaciones', 'fas fa-file-contract', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="window.location.href='{{ route('ventas.analisis') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Análisis de Ventas</div>
                                <div class="card-description">Reportes y análisis de ventas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Análisis de Ventas', 'fas fa-chart-line', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Facturación (oculto inicialmente) -->
                    <div id="bi-facturacion-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Seguimiento de Facturación')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-search-dollar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Seguimiento de Facturación</div>
                                <div class="card-description">Monitoreo de facturación</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Seguimiento de Facturación', 'fas fa-search-dollar', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Pendiente de Facturación')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Pendiente de Facturación</div>
                                <div class="card-description">Documentos pendientes por facturar</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Pendiente de Facturación', 'fas fa-clock', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Facturado')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-check-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Facturado</div>
                                <div class="card-description">Historial de facturación</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Facturado', 'fas fa-check-circle', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Cobranza (oculto inicialmente) -->
                    <div id="bi-cobranza-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Cuentas por Cobrar')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-check-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cuentas por Cobrar</div>
                                <div class="card-description">Gestión de cuentas por cobrar</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cuentas por Cobrar', 'fas fa-money-check-alt', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Antigüedad de Saldos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Antigüedad de Saldos</div>
                                <div class="card-description">Análisis de antigüedad de saldos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Antigüedad de Saldos', 'fas fa-calendar-alt', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Proyecciones de Flujo')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Proyecciones de Flujo</div>
                                <div class="card-description">Proyecciones de flujo de efectivo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Proyecciones de Flujo', 'fas fa-chart-line', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Historial de Pagos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-history text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Historial de Pagos</div>
                                <div class="card-description">Registro histórico de pagos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Historial de Pagos', 'fas fa-history', 'BI')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown de Administración -->
    <div id="dropdown-administracion" class="dropdown-container">
        <div class="dropdown-header bg-blue-600 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-money-bill-wave text-2xl"></i>
                <div>
                    <h2 class="text-2xl font-bold">Administración</h2>
                    <p class="text-blue-100">Gestión administrativa y financiera</p>
                </div>
            </div>
            <button onclick="closeDropdown('administracion')" class="dropdown-close text-white hover:text-gray-200 p-2">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="dropdown-content">
            <!-- Panel izquierdo - Títulos principales -->
            <div class="dropdown-left-panel">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Secciones</h3>
                <div class="space-y-2">
                    <div class="menu-title-item active" onclick="selectTitle('administracion', 'facturacion')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-file-invoice-dollar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Facturación</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'cuentas-cobrar')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Cuentas por Cobrar</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'cuentas-pagar')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-credit-card text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Cuentas por Pagar</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'tesoreria')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-university text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Tesorería</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'presupuestos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-pie text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Presupuestos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'operaciones')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Operaciones</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('administracion', 'cuentas-avanzadas')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-cogs text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Cuentas Avanzadas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel derecho - Contenido del título seleccionado -->
            <div class="dropdown-right-panel">
                <div id="administracion-content">
                    <!-- Contenido para Facturación -->
                    <div id="administracion-facturacion-content" class="cards-grid">
                        <div class="content-card" onclick="navigateTo('Facturación (CFDI)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-invoice text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Facturación (CFDI)</div>
                                <div class="card-description">Emisión de facturas electrónicas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Facturación (CFDI)', 'fas fa-file-invoice', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Notas de Crédito')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-undo-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Notas de Crédito</div>
                                <div class="card-description">Gestión de notas de crédito</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Notas de Crédito', 'fas fa-undo-alt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Notas de Ventas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-sticky-note text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Notas de Ventas</div>
                                <div class="card-description">Notas de venta y complementarias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Notas de Ventas', 'fas fa-sticky-note', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Contrarecibos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Contrarecibos</div>
                                <div class="card-description">Gestión de contrarecibos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Contrarecibos', 'fas fa-receipt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Factoraje')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-handshake text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Factoraje</div>
                                <div class="card-description">Operaciones de factoraje financiero</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Factoraje', 'fas fa-handshake', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Bitácora')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Bitácora</div>
                                <div class="card-description">Registro de operaciones de facturación</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Bitácora', 'fas fa-book', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Comisiones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-percentage text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Comisiones</div>
                                <div class="card-description">Cálculo y pago de comisiones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Comisiones', 'fas fa-percentage', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Cuentas por Cobrar (oculto inicialmente) -->
                    <div id="administracion-cuentas-cobrar-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="window.location.href='{{  route('admin.saldos') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-table text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Vista con tabla de antigüedad</div>
                                <div class="card-description">Análisis de antigüedad de saldos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Vista con tabla de antigüedad', 'fas fa-table', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Cuentas por Pagar (oculto inicialmente) -->
                    <div id="administracion-cuentas-pagar-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="window.location.href='{{ route('admin.pagos') }}'">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-truck text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Facturación de Proveedores</div>
                                <div class="card-description">Gestión de facturas de proveedores</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Facturación de Proveedores', 'fas fa-truck', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Autorización Orden de Compras')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-check-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Autorización Orden de Compras</div>
                                <div class="card-description">Aprobación de órdenes de compra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Autorización Orden de Compras', 'fas fa-check-circle', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Tesorería (oculto inicialmente) -->
                    <div id="administracion-tesoreria-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Depósitos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-check-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Depósitos</div>
                                <div class="card-description">Registro y control de depósitos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Depósitos', 'fas fa-money-check-alt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Transacciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Transacciones</div>
                                <div class="card-description">Registro de transacciones bancarias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Transacciones', 'fas fa-exchange-alt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Estados de Cuenta Bancarios')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estados de Cuenta Bancarios</div>
                                <div class="card-description">Consulta de estados de cuenta</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estados de Cuenta Bancarios', 'fas fa-file-alt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Conciliación Bancaria')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-balance-scale text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Conciliación Bancaria</div>
                                <div class="card-description">Conciliación de cuentas bancarias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Conciliación Bancaria', 'fas fa-balance-scale', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Flujo de Dinero')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-wave-square text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Flujo de Dinero</div>
                                <div class="card-description">Seguimiento de flujo de efectivo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Flujo de Dinero', 'fas fa-wave-square', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Flujo Mensual')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Flujo Mensual</div>
                                <div class="card-description">Proyecciones de flujo mensual</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Flujo Mensual', 'fas fa-calendar-alt', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Programación de Pagos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Programación de Pagos</div>
                                <div class="card-description">Calendario de pagos programados</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Programación de Pagos', 'fas fa-calendar-check', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Presupuestos (Administración) (oculto inicialmente) -->
                    <div id="administracion-presupuestos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Presupuestos Generales')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-pie text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Presupuestos Generales</div>
                                <div class="card-description">Presupuestos generales de la empresa</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Presupuestos Generales', 'fas fa-chart-pie', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Presupuesto Mensual')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Presupuesto Mensual</div>
                                <div class="card-description">Presupuestos por mes</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Presupuesto Mensual', 'fas fa-calendar', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Reasignación de Gastos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-random text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Reasignación de Gastos</div>
                                <div class="card-description">Reasignación de partidas presupuestales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Reasignación de Gastos', 'fas fa-random', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Gastos Fijos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-home text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Gastos Fijos</div>
                                <div class="card-description">Control de gastos fijos mensuales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Gastos Fijos', 'fas fa-home', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Operaciones (oculto inicialmente) -->
                    <div id="administracion-operaciones-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Prepago')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-forward text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Prepago</div>
                                <div class="card-description">Gestión de prepagos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Prepago', 'fas fa-forward', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Anticipos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Anticipos</div>
                                <div class="card-description">Control de anticipos a proveedores</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Anticipos', 'fas fa-hand-holding-usd', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Crédito')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-credit-card text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Crédito</div>
                                <div class="card-description">Gestión de líneas de crédito</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Crédito', 'fas fa-credit-card', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Cuentas Avanzadas (oculto inicialmente) -->
                    <div id="administracion-cuentas-avanzadas-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Cuentas Avanzadas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-cogs text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cuentas Avanzadas</div>
                                <div class="card-description">Configuración avanzada de cuentas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cuentas Avanzadas', 'fas fa-cogs', 'Administración')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown de Contabilidad -->
    <div id="dropdown-contabilidad" class="dropdown-container">
        <div class="dropdown-header bg-blue-600 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-calculator text-2xl"></i>
                <div>
                    <h2 class="text-2xl font-bold">Contabilidad</h2>
                    <p class="text-blue-100">Contabilidad y estados financieros</p>
                </div>
            </div>
            <button onclick="closeDropdown('contabilidad')" class="dropdown-close text-white hover:text-gray-200 p-2">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="dropdown-content">
            <!-- Panel izquierdo - Títulos principales -->
            <div class="dropdown-left-panel">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Secciones</h3>
                <div class="space-y-2">
                    <div class="menu-title-item active" onclick="selectTitle('contabilidad', 'estados-financieros')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Estados Financieros</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'registro-contable')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Registro Contable</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'catalogo-contable')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-list-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Catálogo Contable</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'contabilidad-proyecto')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-project-diagram text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Contabilidad por Proyecto</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'fiscal')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Fiscal</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'analisis-reportes')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Análisis y Reportes</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('contabilidad', 'cierre-contable')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-lock text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Cierre Contable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel derecho - Contenido del título seleccionado -->
            <div class="dropdown-right-panel">
                <div id="contabilidad-content">
                    <!-- Contenido para Estados Financieros -->
                    <div id="contabilidad-estados-financieros-content" class="cards-grid">
                        <div class="content-card" onclick="navigateTo('Estado de Resultados')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-pie text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estado de Resultados</div>
                                <div class="card-description">Estado de pérdidas y ganancias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estado de Resultados', 'fas fa-chart-pie', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Balance General')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-balance-scale text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Balance General</div>
                                <div class="card-description">Balance de situación patrimonial</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Balance General', 'fas fa-balance-scale', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Balance de Comprobación')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-check-double text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Balance de Comprobación</div>
                                <div class="card-description">Balance de sumas y saldos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Balance de Comprobación', 'fas fa-check-double', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Estado de Flujo de Efectivo')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estado de Flujo de Efectivo</div>
                                <div class="card-description">Flujo de efectivo de operaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estado de Flujo de Efectivo', 'fas fa-money-bill-wave', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Estado de Cambios en el Capital')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estado de Cambios en el Capital</div>
                                <div class="card-description">Variaciones del capital contable</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estado de Cambios en el Capital', 'fas fa-exchange-alt', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Registro Contable (oculto inicialmente) -->
                    <div id="contabilidad-registro-contable-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Pólizas Contables')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Pólizas Contables</div>
                                <div class="card-description">Registro de pólizas contables</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Pólizas Contables', 'fas fa-file-alt', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Diario General')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Diario General</div>
                                <div class="card-description">Libro diario de contabilidad</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Diario General', 'fas fa-book', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Libro Mayor')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book-open text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Libro Mayor</div>
                                <div class="card-description">Libro mayor de cuentas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Libro Mayor', 'fas fa-book-open', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Auxiliares Contables')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-columns text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Auxiliares Contables</div>
                                <div class="card-description">Saldos auxiliares por cuenta</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Auxiliares Contables', 'fas fa-columns', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Ajustes y Reclasificaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-adjust text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Ajustes y Reclasificaciones</div>
                                <div class="card-description">Ajustes contables y reclasificaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Ajustes y Reclasificaciones', 'fas fa-adjust', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Catálogo Contable (oculto inicialmente) -->
                    <div id="contabilidad-catalogo-contable-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Cuentas Contables')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-list text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cuentas Contables</div>
                                <div class="card-description">Catálogo de cuentas contables</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cuentas Contables', 'fas fa-list', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Auxiliar de Cuentas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-indent text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Auxiliar de Cuentas</div>
                                <div class="card-description">Detalle por cuenta contable</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Auxiliar de Cuentas', 'fas fa-indent', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Centros de Costos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-sitemap text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Centros de Costos</div>
                                <div class="card-description">Administración de centros de costo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Centros de Costos', 'fas fa-sitemap', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Configuración Contable')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-cogs text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Configuración Contable</div>
                                <div class="card-description">Configuración del sistema contable</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Configuración Contable', 'fas fa-cogs', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Contabilidad por Proyecto (oculto inicialmente) -->
                    <div id="contabilidad-contabilidad-proyecto-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Costos por Obra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-hard-hat text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Costos por Obra</div>
                                <div class="card-description">Costos directos por proyecto</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Costos por Obra', 'fas fa-hard-hat', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Gastos Indirectos de Obra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tools text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Gastos Indirectos de Obra</div>
                                <div class="card-description">Gastos indirectos de proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Gastos Indirectos de Obra', 'fas fa-tools', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Asignación de Gastos por Proyecto')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-project-diagram text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asignación de Gastos por Proyecto</div>
                                <div class="card-description">Distribución de gastos a proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asignación de Gastos por Proyecto', 'fas fa-project-diagram', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Rentabilidad por Obra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Rentabilidad por Obra</div>
                                <div class="card-description">Análisis de rentabilidad por proyecto</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Rentabilidad por Obra', 'fas fa-chart-line', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Cierre de Proyectos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-lock text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cierre de Proyectos</div>
                                <div class="card-description">Proceso de cierre contable de proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cierre de Proyectos', 'fas fa-lock', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Fiscal (oculto inicialmente) -->
                    <div id="contabilidad-fiscal-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('DIOT')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-export text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">DIOT</div>
                                <div class="card-description">Declaración Informativa de Operaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('DIOT', 'fas fa-file-export', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Declaraciones Mensuales/Anuales')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Declaraciones Mensuales/Anuales</div>
                                <div class="card-description">Declaraciones fiscales periódicas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Declaraciones Mensuales/Anuales', 'fas fa-calendar-alt', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Retenciones (ISR, IVA)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-percentage text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Retenciones (ISR, IVA)</div>
                                <div class="card-description">Cálculo y control de retenciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Retenciones (ISR, IVA)', 'fas fa-percentage', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Complemento de Pagos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-check-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Complemento de Pagos</div>
                                <div class="card-description">Complemento de pago CFDI</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Complemento de Pagos', 'fas fa-money-check-alt', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Contabilidad Electrónica (XML)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-code text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Contabilidad Electrónica (XML)</div>
                                <div class="card-description">Generación de contabilidad electrónica</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Contabilidad Electrónica (XML)', 'fas fa-code', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Análisis y Reportes (oculto inicialmente) -->
                    <div id="contabilidad-analisis-reportes-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Razones Financieras')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Razones Financieras</div>
                                <div class="card-description">Análisis de razones financieras</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Razones Financieras', 'fas fa-chart-bar', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Comparativos Periódicos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Comparativos Periódicos</div>
                                <div class="card-description">Comparación de periodos contables</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Comparativos Periódicos', 'fas fa-chart-line', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Análisis de Variaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-area text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Análisis de Variaciones</div>
                                <div class="card-description">Análisis de variaciones presupuestales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Análisis de Variaciones', 'fas fa-chart-area', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Reportes Personalizados')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-edit text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Reportes Personalizados</div>
                                <div class="card-description">Creación de reportes personalizados</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Reportes Personalizados', 'fas fa-edit', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Cierre Contable (oculto inicialmente) -->
                    <div id="contabilidad-cierre-contable-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Cierre Mensual')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cierre Mensual</div>
                                <div class="card-description">Proceso de cierre contable mensual</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cierre Mensual', 'fas fa-calendar-check', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Cierre Anual')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cierre Anual</div>
                                <div class="card-description">Proceso de cierre contable anual</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cierre Anual', 'fas fa-calendar', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Depreciaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Depreciaciones</div>
                                <div class="card-description">Cálculo de depreciaciones de activos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Depreciaciones', 'fas fa-chart-line', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Amortizaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calculator text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Amortizaciones</div>
                                <div class="card-description">Cálculo de amortizaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Amortizaciones', 'fas fa-calculator', 'Contabilidad')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown de Proyectos -->
    <div id="dropdown-proyectos" class="dropdown-container">
        <div class="dropdown-header bg-blue-600 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-project-diagram text-2xl"></i>
                <div>
                    <h2 class="text-2xl font-bold">Proyectos</h2>
                    <p class="text-blue-100">Gestión integral de proyectos</p>
                </div>
            </div>
            <button onclick="closeDropdown('proyectos')" class="dropdown-close text-white hover:text-gray-200 p-2">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="dropdown-content">
            <!-- Panel izquierdo - Títulos principales -->
            <div class="dropdown-left-panel">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Secciones</h3>
                <div class="space-y-2">
                    <div class="menu-title-item active" onclick="selectTitle('proyectos', 'gestion-proyectos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-tasks text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Gestión de Proyectos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'licitaciones')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-gavel text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Licitaciones</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'presupuestos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-file-invoice-dollar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Presupuestos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'costos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Costos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'avances-obra')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-hard-hat text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Avances de Obra</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'personal')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Personal</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'maquinaria-equipo')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-tractor text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Maquinaria y Equipo</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'inventarios')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-boxes text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Inventarios</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'compras-subcontratos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Compras y Subcontratos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'control-riesgos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-triangle text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Control de Riesgos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('proyectos', 'documentacion')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-folder text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Documentación</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel derecho - Contenido del título seleccionado -->
            <div class="dropdown-right-panel">
                <div id="proyectos-content">
                    <!-- Contenido para Gestión de Proyectos -->
                    <div id="proyectos-gestion-proyectos-content" class="cards-grid">
                        <div class="content-card" onclick="navigateTo('Cartera de Proyectos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-briefcase text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cartera de Proyectos</div>
                                <div class="card-description">Gestión de cartera de proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cartera de Proyectos', 'fas fa-briefcase', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Alta de Proyecto')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-plus-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Alta de Proyecto</div>
                                <div class="card-description">Registro de nuevos proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Alta de Proyecto', 'fas fa-plus-circle', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Cronograma y Hitos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cronograma y Hitos</div>
                                <div class="card-description">Planificación de cronogramas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cronograma y Hitos', 'fas fa-calendar-alt', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Bitácora de Obra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Bitácora de Obra</div>
                                <div class="card-description">Registro diario de actividades</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Obra', 'fas fa-book', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Estatus y Dashboard')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tachometer-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estatus y Dashboard</div>
                                <div class="card-description">Dashboard de seguimiento de proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estatus y Dashboard', 'fas fa-tachometer-alt', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Licitaciones (oculto inicialmente) -->
                    <div id="proyectos-licitaciones-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Licitaciones Activas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-gavel text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Licitaciones Activas</div>
                                <div class="card-description">Seguimiento de licitaciones en curso</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Licitaciones Activas', 'fas fa-gavel', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Propuestas y Cotizaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Propuestas y Cotizaciones</div>
                                <div class="card-description">Elaboración de propuestas técnicas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Propuestas y Cotizaciones', 'fas fa-file-contract', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Análisis de Precios Unitarios')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calculator text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Análisis de Precios Unitarios</div>
                                <div class="card-description">Análisis de precios unitarios (APU)</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Análisis de Precios Unitarios', 'fas fa-calculator', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Histórico')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-history text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Histórico</div>
                                <div class="card-description">Historial de licitaciones participadas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Histórico', 'fas fa-history', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Presupuestos (Proyectos) (oculto inicialmente) -->
                    <div id="proyectos-presupuestos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Presupuesto por Proyecto')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-invoice-dollar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Presupuesto por Proyecto</div>
                                <div class="card-description">Presupuesto detallado por proyecto</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Presupuesto por Proyecto', 'fas fa-file-invoice-dollar', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Presupuesto por Partidas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-list-ol text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Presupuesto por Partidas</div>
                                <div class="card-description">Desglose presupuestal por partidas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Presupuesto por Partidas', 'fas fa-list-ol', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Control de Cambios')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Control de Cambios</div>
                                <div class="card-description">Control de cambios presupuestales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Control de Cambios', 'fas fa-exchange-alt', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Comparativo Presupuesto vs Real')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-balance-scale text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Comparativo Presupuesto vs Real</div>
                                <div class="card-description">Comparación presupuesto vs ejecución</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Comparativo Presupuesto vs Real', 'fas fa-balance-scale', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Costos (oculto inicialmente) -->
                    <div id="proyectos-costos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Costos Directos (Mano de Obra, Materiales, Subcontratos)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Costos Directos</div>
                                <div class="card-description">Costos directos de mano de obra, materiales y subcontratos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Costos Directos', 'fas fa-money-bill-wave', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Costos Indirectos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tools text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Costos Indirectos</div>
                                <div class="card-description">Costos indirectos de obra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Costos Indirectos', 'fas fa-tools', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Análisis de Rentabilidad')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Análisis de Rentabilidad</div>
                                <div class="card-description">Análisis de rentabilidad por proyecto</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Análisis de Rentabilidad', 'fas fa-chart-line', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Avances de Obra (oculto inicialmente) -->
                    <div id="proyectos-avances-obra-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Avance Físico y Financiero')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Avance Físico y Financiero</div>
                                <div class="card-description">Seguimiento de avance físico y financiero</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Avance Físico y Financiero', 'fas fa-chart-bar', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Estimaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calculator text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Estimaciones</div>
                                <div class="card-description">Generación de estimaciones de obra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Estimaciones', 'fas fa-calculator', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Reporte Fotográfico')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-camera text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Reporte Fotográfico</div>
                                <div class="card-description">Reporte fotográfico de avances</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Reporte Fotográfico', 'fas fa-camera', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Personal (oculto inicialmente) -->
                    <div id="proyectos-personal-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Asignación a Proyectos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asignación a Proyectos</div>
                                <div class="card-description">Asignación de personal a proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asignación a Proyectos', 'fas fa-user-check', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Asistencia y Cuadrillas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asistencia y Cuadrillas</div>
                                <div class="card-description">Control de asistencia y cuadrillas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asistencia y Cuadrillas', 'fas fa-users', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Rendimientos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Rendimientos</div>
                                <div class="card-description">Análisis de rendimientos de personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Rendimientos', 'fas fa-chart-line', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Maquinaria y Equipo (oculto inicialmente) -->
                    <div id="proyectos-maquinaria-equipo-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Asignación de Equipo')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tractor text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asignación de Equipo</div>
                                <div class="card-description">Asignación de maquinaria a proyectos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asignación de Equipo', 'fas fa-tractor', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Control de Maquinaria')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-cogs text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Control de Maquinaria</div>
                                <div class="card-description">Control y seguimiento de maquinaria</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Control de Maquinaria', 'fas fa-cogs', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Mantenimiento de Equipo')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tools text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Mantenimiento de Equipo</div>
                                <div class="card-description">Programa de mantenimiento de equipo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Mantenimiento de Equipo', 'fas fa-tools', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Bitácora de Uso')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Bitácora de Uso</div>
                                <div class="card-description">Registro de uso de maquinaria</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'fas fa-book', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Costos de Operación')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Costos de Operación</div>
                                <div class="card-description">Costos de operación de maquinaria</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Costos de Operación', 'fas fa-money-bill-wave', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Inventarios (oculto inicialmente) -->
                    <div id="proyectos-inventarios-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Catálogo de Almacenes')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-warehouse text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Catálogo de Almacenes</div>
                                <div class="card-description">Gestión de almacenes y bodegas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Almacenes', 'fas fa-warehouse', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Catálogo de Materiales')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Catálogo de Materiales</div>
                                <div class="card-description">Catálogo de materiales y suministros</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Materiales', 'fas fa-box', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Existencias por Almacén')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clipboard-list text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Existencias por Almacén</div>
                                <div class="card-description">Consulta de existencias por almacén</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Existencias por Almacén', 'fas fa-clipboard-list', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Entradas y Salidas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Entradas y Salidas</div>
                                <div class="card-description">Control de entradas y salidas de almacén</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Entradas y Salidas', 'fas fa-exchange-alt', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Traspasos entre Almacenes')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-truck-moving text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Traspasos entre Almacenes</div>
                                <div class="card-description">Traspasos de materiales entre almacenes</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Traspasos entre Almacenes', 'fas fa-truck-moving', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Ajustes de Inventario')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-adjust text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Ajustes de Inventario</div>
                                <div class="card-description">Ajustes de inventario físico</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Ajustes de Inventario', 'fas fa-adjust', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Kardex')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-stream text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Kardex</div>
                                <div class="card-description">Sistema de kardex de materiales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Kardex', 'fas fa-stream', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Compras y Subcontratos (oculto inicialmente) -->
                    <div id="proyectos-compras-subcontratos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Requisiciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clipboard-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Requisiciones</div>
                                <div class="card-description">Gestión de requisiciones de materiales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Requisiciones', 'fas fa-clipboard-check', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Órdenes de Compra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Órdenes de Compra</div>
                                <div class="card-description">Gestión de órdenes de compra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Órdenes de Compra', 'fas fa-shopping-cart', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Gestión de Subcontratistas')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-handshake text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Gestión de Subcontratistas</div>
                                <div class="card-description">Administración de subcontratistas</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Gestión de Subcontratistas', 'fas fa-handshake', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Almacén por Obra')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-warehouse text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Almacén por Obra</div>
                                <div class="card-description">Gestión de almacenes por obra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Almacén por Obra', 'fas fa-warehouse', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Control de Riesgos (oculto inicialmente) -->
                    <div id="proyectos-control-riesgos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Desviaciones (Costo y Tiempo)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exclamation-triangle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Desviaciones (Costo y Tiempo)</div>
                                <div class="card-description">Control de desviaciones de costo y tiempo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Desviaciones (Costo y Tiempo)', 'fas fa-exclamation-triangle', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Alertas e Incidencias')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-bell text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Alertas e Incidencias</div>
                                <div class="card-description">Sistema de alertas e incidencias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Alertas e Incidencias', 'fas fa-bell', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Control de Calidad')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clipboard-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Control de Calidad</div>
                                <div class="card-description">Control de calidad en obra</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Control de Calidad', 'fas fa-clipboard-check', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Documentación (oculto inicialmente) -->
                    <div id="proyectos-documentacion-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Contratos y Planos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Contratos y Planos</div>
                                <div class="card-description">Gestión de contratos y planos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Contratos y Planos', 'fas fa-file-contract', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Permisos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Permisos</div>
                                <div class="card-description">Gestión de permisos y autorizaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Permisos', 'fas fa-file-alt', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Evidencias (Fotos, Actas)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-camera text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Evidencias (Fotos, Actas)</div>
                                <div class="card-description">Gestión de evidencias documentales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Evidencias (Fotos, Actas)', 'fas fa-camera', 'Proyectos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown de Recursos Humanos -->
    <div id="dropdown-rrhh" class="dropdown-container">
        <div class="dropdown-header bg-blue-600 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-users text-2xl"></i>
                <div>
                    <h2 class="text-2xl font-bold">Recursos Humanos</h2>
                    <p class="text-blue-100">Gestión de personal y nómina</p>
                </div>
            </div>
            <button onclick="closeDropdown('rrhh')" class="dropdown-close text-white hover:text-gray-200 p-2">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="dropdown-content">
            <!-- Panel izquierdo - Títulos principales -->
            <div class="dropdown-left-panel">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Secciones</h3>
                <div class="space-y-2">
                    <div class="menu-title-item active" onclick="selectTitle('rrhh', 'gestion-personal')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user-tie text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Gestión de Personal</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'asistencia-control')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user-clock text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Asistencia y Control</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'nomina')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-money-check-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Nómina</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'prestaciones-descuentos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Prestaciones y Descuentos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'unidades-flotilla')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-car text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Unidades y Flotilla</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'catalogos')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-list text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Catálogos</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'evaluacion-desarrollo')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Evaluación y Desarrollo</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-title-item" onclick="selectTitle('rrhh', 'reportes')">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Reportes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel derecho - Contenido del título seleccionado -->
            <div class="dropdown-right-panel">
                <div id="rrhh-content">
                    <!-- Contenido para Gestión de Personal -->
                    <div id="rrhh-gestion-personal-content" class="cards-grid">
                        <div class="content-card" onclick="navigateTo('Plantilla de Empleados')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Plantilla de Empleados</div>
                                <div class="card-description">Directorio completo de empleados</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Plantilla de Empleados', 'fas fa-users', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Alta y Baja de Personal')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Alta y Baja de Personal</div>
                                <div class="card-description">Registro de altas y bajas de personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Alta y Baja de Personal', 'fas fa-user-plus', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Expediente Digital')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-folder text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Expediente Digital</div>
                                <div class="card-description">Expediente digital del empleado</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Expediente Digital', 'fas fa-folder', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Semáforo de Documentos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-traffic-light text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Semáforo de Documentos</div>
                                <div class="card-description">Control de documentación del personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Semáforo de Documentos', 'fas fa-traffic-light', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Historial Laboral')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-history text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Historial Laboral</div>
                                <div class="card-description">Historial completo del empleado</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Historial Laboral', 'fas fa-history', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Asistencia y Control (oculto inicialmente) -->
                    <div id="rrhh-asistencia-control-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Asistencia')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-clock text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asistencia</div>
                                <div class="card-description">Control de asistencia del personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asistencia', 'fas fa-user-clock', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Lista de Asistencia')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-list text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Lista de Asistencia</div>
                                <div class="card-description">Listas de asistencia por periodo</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Lista de Asistencia', 'fas fa-list', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Registro de Incidencias')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exclamation-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Registro de Incidencias</div>
                                <div class="card-description">Registro de incidencias de asistencia</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Registro de Incidencias', 'fas fa-exclamation-circle', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Justificantes y Permisos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Justificantes y Permisos</div>
                                <div class="card-description">Gestión de justificantes y permisos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Justificantes y Permisos', 'fas fa-file-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Control de Horarios')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Control de Horarios</div>
                                <div class="card-description">Control de horarios y turnos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Control de Horarios', 'fas fa-clock', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Nómina (oculto inicialmente) -->
                    <div id="rrhh-nomina-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Cálculo de Nómina')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calculator text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Cálculo de Nómina</div>
                                <div class="card-description">Cálculo de nómina quincenal/mensual</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Cálculo de Nómina', 'fas fa-calculator', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Pagos de Nómina')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-check-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Pagos de Nómina</div>
                                <div class="card-description">Proceso de pago de nómina</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Pagos de Nómina', 'fas fa-money-check-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Tabla de Sueldos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-table text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Tabla de Sueldos</div>
                                <div class="card-description">Tabla de sueldos y salarios</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Tabla de Sueldos', 'fas fa-table', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Recibos de Nómina (Timbrado)')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-invoice-dollar text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Recibos de Nómina (Timbrado)</div>
                                <div class="card-description">Generación de recibos de nómina</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Recibos de Nómina (Timbrado)', 'fas fa-file-invoice-dollar', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Histórico de Pagos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-history text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Histórico de Pagos</div>
                                <div class="card-description">Historial de pagos de nómina</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Histórico de Pagos', 'fas fa-history', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Prestaciones y Descuentos (oculto inicialmente) -->
                    <div id="rrhh-prestaciones-descuentos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Préstamos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Préstamos</div>
                                <div class="card-description">Gestión de préstamos al personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Préstamos', 'fas fa-hand-holding-usd', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Descuentos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-percentage text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Descuentos</div>
                                <div class="card-description">Gestión de descuentos al personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Descuentos', 'fas fa-percentage', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Vacaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-umbrella-beach text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Vacaciones</div>
                                <div class="card-description">Control de vacaciones del personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Vacaciones', 'fas fa-umbrella-beach', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Asignación de Vacaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-calendar-check text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asignación de Vacaciones</div>
                                <div class="card-description">Asignación y programación de vacaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asignación de Vacaciones', 'fas fa-calendar-check', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Aguinaldo y PTU')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-gift text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Aguinaldo y PTU</div>
                                <div class="card-description">Cálculo de aguinaldo y PTU</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Aguinaldo y PTU', 'fas fa-gift', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Finiquitos y Liquidaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-contract text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Finiquitos y Liquidaciones</div>
                                <div class="card-description">Cálculo de finiquitos y liquidaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Finiquitos y Liquidaciones', 'fas fa-file-contract', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Unidades y Flotilla (oculto inicialmente) -->
                    <div id="rrhh-unidades-flotilla-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Semáforo de Documentos de Unidades')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-traffic-light text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Semáforo de Documentos de Unidades</div>
                                <div class="card-description">Control de documentación vehicular</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Semáforo de Documentos de Unidades', 'fas fa-traffic-light', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Asignación de Flotilla')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-car text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Asignación de Flotilla</div>
                                <div class="card-description">Asignación de vehículos a personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Asignación de Flotilla', 'fas fa-car', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Control de Vehículos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-tachometer-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Control de Vehículos</div>
                                <div class="card-description">Control y seguimiento de vehículos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Control de Vehículos', 'fas fa-tachometer-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Bitácora de Uso')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-book text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Bitácora de Uso</div>
                                <div class="card-description">Registro de uso de vehículos</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'fas fa-book', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Verificaciones y Seguros')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Verificaciones y Seguros</div>
                                <div class="card-description">Control de verificaciones y seguros</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Verificaciones y Seguros', 'fas fa-shield-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Catálogos (oculto inicialmente) -->
                    <div id="rrhh-catalogos-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('IMSS')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-hospital text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">IMSS</div>
                                <div class="card-description">Catálogo de datos IMSS</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('IMSS', 'fas fa-hospital', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Deducciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-minus-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Deducciones</div>
                                <div class="card-description">Catálogo de deducciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Deducciones', 'fas fa-minus-circle', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Percepciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-plus-circle text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Percepciones</div>
                                <div class="card-description">Catálogo de percepciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Percepciones', 'fas fa-plus-circle', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Roles y Puestos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-tag text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Roles y Puestos</div>
                                <div class="card-description">Catálogo de puestos y responsabilidades</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Roles y Puestos', 'fas fa-user-tag', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Áreas y Departamentos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-sitemap text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Áreas y Departamentos</div>
                                <div class="card-description">Estructura organizacional</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Áreas y Departamentos', 'fas fa-sitemap', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Turnos')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Turnos</div>
                                <div class="card-description">Catálogo de turnos laborales</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Turnos', 'fas fa-clock', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Evaluación y Desarrollo (oculto inicialmente) -->
                    <div id="rrhh-evaluacion-desarrollo-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Evaluación de Desempeño')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-chart-line text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Evaluación de Desempeño</div>
                                <div class="card-description">Sistema de evaluación de desempeño</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Evaluación de Desempeño', 'fas fa-chart-line', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Capacitaciones')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-graduation-cap text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Capacitaciones</div>
                                <div class="card-description">Gestión de capacitaciones</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Capacitaciones', 'fas fa-graduation-cap', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Competencias')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-award text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Competencias</div>
                                <div class="card-description">Gestión por competencias</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Competencias', 'fas fa-award', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Plan de Carrera')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-briefcase text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Plan de Carrera</div>
                                <div class="card-description">Planes de desarrollo y carrera</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Plan de Carrera', 'fas fa-briefcase', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido para Reportes (oculto inicialmente) -->
                    <div id="rrhh-reportes-content" class="cards-grid" style="display: none;">
                        <div class="content-card" onclick="navigateTo('Reportes IMSS')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-export text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Reportes IMSS</div>
                                <div class="card-description">Generación de reportes para IMSS</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Reportes IMSS', 'fas fa-file-export', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Reportes SAT')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Reportes SAT</div>
                                <div class="card-description">Reportes para declaraciones SAT</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Reportes SAT', 'fas fa-file-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Rotación de Personal')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-exchange-alt text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Rotación de Personal</div>
                                <div class="card-description">Reportes de rotación de personal</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Rotación de Personal', 'fas fa-exchange-alt', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Ausentismo')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-user-times text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Ausentismo</div>
                                <div class="card-description">Reportes de ausentismo laboral</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Ausentismo', 'fas fa-user-times', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="content-card" onclick="navigateTo('Costos de Nómina por Proyecto')">
                            <div class="card-icon bg-blue-100">
                                <i class="fas fa-money-bill-wave text-blue-600"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-title">Costos de Nómina por Proyecto</div>
                                <div class="card-description">Distribución de nómina por proyecto</div>
                            </div>
                            <div class="card-action">
                                <button class="btn-favorite" onclick="event.stopPropagation(); toggleFavorite('Costos de Nómina por Proyecto', 'fas fa-money-bill-wave', 'Recursos Humanos')">
                                    <i class="fas fa-star"></i>
                                </button>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra lateral de favoritos -->
    <div class="quick-sidebar" id="quick-sidebar">
        <div class="bg-construction-dark text-white p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">
                        <i class="fas fa-star mr-2"></i>Accesos Rápidos
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">Tus herramientas favoritas</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="openQuickAccessSettings()" class="p-2 rounded-lg hover:bg-blue-800 transition" title="Configurar accesos">
                        <i class="fas fa-cog"></i>
                    </button>
                    <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-blue-800 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-4 flex-1 overflow-y-auto">
            <div id="empty-favorites" class="text-center py-8 text-gray-500">
                <i class="fas fa-star text-4xl mb-4 opacity-20"></i>
                <p class="font-medium">No tienes accesos rápidos configurados</p>
                <p class="text-sm mt-2">Haz clic en cualquier opción del menú y usa el botón <i class="fas fa-star text-yellow-500"></i> para agregarla a favoritos</p>
            </div>
            
            <div id="favorites-list" style="display: none;"></div>
        </div>
        
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <p id="favorites-count">0 acceso(s)</p>
                </div>
                <div>
                    <button onclick="clearFavorites()" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                        <i class="fas fa-trash-alt mr-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay para la barra lateral -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Barra lateral de favoritos -->
    <div class="quick-sidebar" id="quick-sidebar">
        <div class="bg-construction-dark text-white p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">
                        <i class="fas fa-star mr-2"></i>Accesos Rápidos
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">Tus herramientas favoritas</p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="openQuickAccessSettings()" class="p-2 rounded-lg hover:bg-blue-800 transition" title="Configurar accesos">
                        <i class="fas fa-cog"></i>
                    </button>
                    <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-blue-800 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-4 flex-1 overflow-y-auto">
            <div id="empty-favorites" class="text-center py-8 text-gray-500">
                <i class="fas fa-star text-4xl mb-4 opacity-20"></i>
                <p class="font-medium">No tienes accesos rápidos configurados</p>
                <p class="text-sm mt-2">Haz clic en cualquier opción del menú y usa el botón <i class="fas fa-star text-yellow-500"></i> para agregarla a favoritos</p>
            </div>
            
            <div id="favorites-list" style="display: none;"></div>
        </div>
        
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <p id="favorites-count">0 acceso(s)</p>
                </div>
                <div>
                    <button onclick="clearFavorites()" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                        <i class="fas fa-trash-alt mr-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay para la barra lateral -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Botón flotante para barra lateral -->
    <button onclick="toggleSidebar()" class="sidebar-toggle-btn bg-construction-dark text-white p-3 rounded-full shadow-lg hover:bg-blue-800 transition-all duration-300" id="sidebar-toggle-btn">
        <i class="fas fa-star text-xl"></i>
        <span id="favorite-count" class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-500 text-xs rounded-full flex items-center justify-center" style="display: none;"></span>
    </button>

    <!-- Modal de configuración de accesos rápidos -->
    <div id="quickaccess-settings-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[1002] hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="bg-construction-dark text-white p-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-lg">
                        <i class="fas fa-cog mr-2"></i>Configurar Accesos Rápidos
                    </h3>
                    <button onclick="closeQuickAccessSettings()" class="p-2 rounded-lg hover:bg-blue-800 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <div class="flex space-x-6">
                    <!-- Panel izquierdo: Accesos disponibles -->
                    <div class="w-1/2 border-r pr-6">
                        <h4 class="font-bold text-lg mb-4 text-construction-dark">Accesos Disponibles</h4>
                        <p class="text-sm text-gray-600 mb-4">Selecciona los accesos que deseas tener en tu barra lateral</p>
                        
                        <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                            <!-- BI -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                    <h5 class="font-bold text-blue-700 flex items-center">
                                        <i class="fas fa-chart-line mr-2"></i> Business Intelligence
                                    </h5>
                                </div>
                                <div class="p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-user-tie text-blue-600"></i>
                                            </div>
                                            <span>Directivo</span>
                                        </div>
                                        <button onclick="addQuickAccess('Directivo', 'fas fa-user-tie', 'BI')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-chart-pie text-blue-600"></i>
                                            </div>
                                            <span>Finanzas (BI)</span>
                                        </div>
                                        <button onclick="addQuickAccess('Finanzas (BI)', 'fas fa-chart-pie', 'BI')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-gavel text-blue-600"></i>
                                            </div>
                                            <span>Licitaciones</span>
                                        </div>
                                        <button onclick="addQuickAccess('Licitaciones', 'fas fa-gavel', 'BI')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Administración -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                    <h5 class="font-bold text-blue-700 flex items-center">
                                        <i class="fas fa-money-bill-wave mr-2"></i> Administración
                                    </h5>
                                </div>
                                <div class="p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-file-invoice text-blue-600"></i>
                                            </div>
                                            <span>Facturación (CFDI)</span>
                                        </div>
                                        <button onclick="addQuickAccess('Facturación (CFDI)', 'fas fa-file-invoice', 'Administración')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-hand-holding-usd text-blue-600"></i>
                                            </div>
                                            <span>Cuentas por Cobrar</span>
                                        </div>
                                        <button onclick="addQuickAccess('Cuentas por Cobrar', 'fas fa-hand-holding-usd', 'Administración')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar-alt text-blue-600"></i>
                                            </div>
                                            <span>Flujo Mensual</span>
                                        </div>
                                        <button onclick="addQuickAccess('Flujo Mensual', 'fas fa-calendar-alt', 'Administración')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contabilidad -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                    <h5 class="font-bold text-blue-700 flex items-center">
                                        <i class="fas fa-calculator mr-2"></i> Contabilidad
                                    </h5>
                                </div>
                                <div class="p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-chart-pie text-blue-600"></i>
                                            </div>
                                            <span>Estado de Resultados</span>
                                        </div>
                                        <button onclick="addQuickAccess('Estado de Resultados', 'fas fa-chart-pie', 'Contabilidad')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-balance-scale text-blue-600"></i>
                                            </div>
                                            <span>Balance General</span>
                                        </div>
                                        <button onclick="addQuickAccess('Balance General', 'fas fa-balance-scale', 'Contabilidad')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Proyectos -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                    <h5 class="font-bold text-blue-700 flex items-center">
                                        <i class="fas fa-project-diagram mr-2"></i> Proyectos
                                    </h5>
                                </div>
                                <div class="p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-tasks text-blue-600"></i>
                                            </div>
                                            <span>Cartera de Proyectos</span>
                                        </div>
                                        <button onclick="addQuickAccess('Cartera de Proyectos', 'fas fa-tasks', 'Proyectos')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-hard-hat text-blue-600"></i>
                                            </div>
                                            <span>Avance Físico y Financiero</span>
                                        </div>
                                        <button onclick="addQuickAccess('Avance Físico y Financiero', 'fas fa-hard-hat', 'Proyectos')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recursos Humanos -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="bg-blue-50 px-4 py-3 border-b border-gray-200">
                                    <h5 class="font-bold text-blue-700 flex items-center">
                                        <i class="fas fa-users mr-2"></i> Recursos Humanos
                                    </h5>
                                </div>
                                <div class="p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-users text-blue-600"></i>
                                            </div>
                                            <span>Plantilla de Empleados</span>
                                        </div>
                                        <button onclick="addQuickAccess('Plantilla de Empleados', 'fas fa-users', 'Recursos Humanos')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-money-check-alt text-blue-600"></i>
                                            </div>
                                            <span>Cálculo de Nómina</span>
                                        </div>
                                        <button onclick="addQuickAccess('Cálculo de Nómina', 'fas fa-money-check-alt', 'Recursos Humanos')" 
                                                class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Panel derecho: Mis accesos rápidos -->
                    <div class="w-1/2">
                        <h4 class="font-bold text-lg mb-4 text-construction-dark">Mis Accesos Rápidos</h4>
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Arrastra para reorganizar tus accesos rápidos</p>
                                </div>
                            </div>
                            
                            <div id="quickaccess-preview" class="space-y-3 p-4 border border-gray-300 rounded-lg min-h-[400px]">
                                <div id="empty-quickaccess" class="text-center py-12 text-gray-500">
                                    <i class="fas fa-star text-4xl mb-4 opacity-20"></i>
                                    <p class="font-medium">No tienes accesos rápidos configurados</p>
                                    <p class="text-sm mt-2">Agrega accesos desde el panel izquierdo</p>
                                </div>
                                <div id="quickaccess-items" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de cierre de sesión -->
    <div id="logout-confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[1100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden confirmation-modal">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Cerrar Sesión</h3>
                        <p class="text-gray-600">¿Estás seguro de que deseas salir del sistema?</p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button onclick="closeLogoutConfirm()" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit"
        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
        Sí, Cerrar Sesión
    </button>
</form>

                </div>
            </div>
        </div>
    </div>

    <!-- ESPACIO PARA EL CONTENIDO DE LA PÁGINA -->
<div id="pageContentContainer" class="page-content-container" style="margin-top: 64px; min-height: calc(100vh - 64px);">
    @yield('content')
</div>

 <script>
    // Variables globales
    let sidebarOpen = false;
    let currentDropdown = null;
    let draggedItem = null;
    let quickAccess = [];
    let isDropdownTransitioning = false;

    // ==================== FUNCIÓN PARA AJUSTAR EL CONTENIDO DE LA PÁGINA ====================
    function adjustPageContent() {
        const tabBar = document.querySelector('.tab-navigation-bar');
        const pageContainer = document.getElementById('pageContentContainer');
        
        if (tabBar && pageContainer) {
            if (tabBar.classList.contains('hidden')) {
                // Barra oculta
                pageContainer.classList.remove('with-tabbar');
                pageContainer.classList.add('no-tabbar');
                // Aplicar estilos inline como respaldo
                pageContainer.style.marginTop = '64px';
                pageContainer.style.minHeight = 'calc(100vh - 64px)';
            } else {
                // Barra visible
                pageContainer.classList.remove('no-tabbar');
                pageContainer.classList.add('with-tabbar');
                // Aplicar estilos inline como respaldo
                pageContainer.style.marginTop = '109px';
                pageContainer.style.minHeight = 'calc(100vh - 109px)';
            }
        }
    }

    // ==================== FUNCIÓN PARA OCULTAR/MOSTRAR BARRA DE PESTAÑAS ====================
    function toggleTabBarVisibility(show) {
        const tabBar = document.querySelector('.tab-navigation-bar');
        if (!tabBar) return;
        
        if (show) {
            // Mostrar barra de pestañas
            tabBar.classList.remove('hidden');
        } else {
            // Ocultar barra de pestañas
            tabBar.classList.add('hidden');
        }
        
        // Ajustar el contenido de la página
        adjustPageContent();
    }

    // ==================== FUNCIÓN PARA APLICAR PALETA DE COLORES ====================
    function applyColorScheme(dropdownId) {
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        if (!dropdown) return;
        
        // Remover todas las clases de color anteriores
        dropdown.classList.remove('color-scheme-bi');
        dropdown.classList.remove('color-scheme-administracion');
        dropdown.classList.remove('color-scheme-contabilidad');
        dropdown.classList.remove('color-scheme-proyectos');
        dropdown.classList.remove('color-scheme-rrhh');
        
        // Aplicar la clase de color correspondiente
        dropdown.classList.add('color-scheme-' + dropdownId);
    }

    // ==================== FUNCIÓN PARA VERIFICAR DROPDOWNS ABIERTOS ====================
    function isAnyDropdownOpen() {
        const dropdowns = ['bi', 'administracion', 'contabilidad', 'proyectos', 'rrhh'];
        for (const dropdownId of dropdowns) {
            const dropdown = document.getElementById('dropdown-' + dropdownId);
            if (dropdown && dropdown.style.display === 'flex' && dropdown.classList.contains('active')) {
                return true;
            }
        }
        return false;
    }

    // ==================== INICIALIZACIÓN ====================
    function initializePage() {
        loadQuickAccess();
        
        // Verificar si hay tabs guardados para determinar estado inicial
        const savedTabs = localStorage.getItem('userTabs');
        const hasTabs = savedTabs && JSON.parse(savedTabs).length > 0;
        
        const tabBar = document.querySelector('.tab-navigation-bar');
        if (tabBar) {
            // Si hay tabs, la barra debe estar visible por defecto
            if (hasTabs) {
                tabBar.classList.remove('hidden');
            } else {
                // Si no hay tabs, podría estar oculta
                tabBar.classList.add('hidden');
            }
        }
        
        // Ajustar contenido inicial
        setTimeout(() => {
            adjustPageContent();
        }, 100);
        
        // Event listeners
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllDropdowns();
                closeQuickAccessSettings();
                closeLogoutConfirm();
            }
        });
        
        // Cerrar dropdowns al hacer click fuera
        document.addEventListener('click', function(event) {
            const isDropdown = event.target.closest('.dropdown-container');
            const isTrigger = event.target.closest('.dropdown-trigger-btn');
            const isDropdownClose = event.target.closest('.dropdown-close');
            
            if (isDropdownClose) {
                const dropdown = event.target.closest('.dropdown-container');
                if (dropdown) {
                    const dropdownId = dropdown.id.replace('dropdown-', '');
                    closeDropdown(dropdownId);
                }
                return;
            }
            
            if (!isDropdown && !isTrigger) {
                closeAllDropdowns();
            }
        });
        
        initAllDropdowns();
        initTabSystem();
    }

    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePage);
    } else {
        initializePage();
    }

    // ==================== INICIALIZACIÓN DE DROPDOWNS ====================
    function initAllDropdowns() {
        const dropdowns = ['bi', 'administracion', 'contabilidad', 'proyectos', 'rrhh'];
        dropdowns.forEach(dropdownId => {
            const dropdown = document.getElementById('dropdown-' + dropdownId);
            if (dropdown) {
                dropdown.style.display = 'none';
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateX(-50%) translateY(-30px)';
                
                prepareDropdownContent(dropdownId);
            }
        });
    }

    function prepareDropdownContent(dropdownId) {
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        if (!dropdown) return;
        
        const dropdownContent = document.getElementById(dropdownId + '-content');
        if (!dropdownContent) return;
        
        const allContents = dropdownContent.querySelectorAll('div[id*="-content"]');
        if (allContents.length > 0) {
            allContents.forEach((content, index) => {
                if (content.id.startsWith(dropdownId + '-') && index === 0) {
                    content.style.display = 'grid';
                } else {
                    content.style.display = 'none';
                }
            });
        }
        
        const firstTitle = dropdown.querySelector('.menu-title-item');
        const allTitles = dropdown.querySelectorAll('.menu-title-item');
        allTitles.forEach(title => title.classList.remove('active'));
        if (firstTitle) {
            firstTitle.classList.add('active');
        }
    }

    // ==================== FUNCIONES DE DROPDOWN ====================
    function toggleDropdown(dropdownId) {
        if (isDropdownTransitioning) return;
        
        isDropdownTransitioning = true;
        
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        const triggerBtn = document.getElementById('trigger-' + dropdownId);
        
        if (currentDropdown && currentDropdown !== dropdownId) {
            closeDropdown(currentDropdown);
        }
        
        setTimeout(() => {
            if (currentDropdown === dropdownId) {
                closeDropdown(dropdownId);
                currentDropdown = null;
                if (triggerBtn) triggerBtn.classList.remove('active');
            } else {
                currentDropdown = dropdownId;
                
                if (dropdown) {
                    // Aplicar paleta de colores
                    applyColorScheme(dropdownId);
                    
                    dropdown.style.display = 'flex';
                    
                    // Ocultar barra de pestañas
                    toggleTabBarVisibility(false);
                    
                    setTimeout(() => {
                        dropdown.classList.add('active');
                        dropdown.style.opacity = '1';
                        dropdown.style.visibility = 'visible';
                        dropdown.style.transform = 'translateX(-50%) translateY(0)';
                        
                        resetDropdownContent(dropdownId);
                        
                        if (triggerBtn) {
                            triggerBtn.classList.add('active');
                        }
                        
                        setTimeout(updateFavoriteButtons, 100);
                        
                        isDropdownTransitioning = false;
                    }, 20);
                } else {
                    isDropdownTransitioning = false;
                }
            }
        }, 50);
    }

    function closeDropdown(dropdownId) {
        if (isDropdownTransitioning && dropdownId !== currentDropdown) return;
        
        isDropdownTransitioning = true;
        
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        const triggerBtn = document.getElementById('trigger-' + dropdownId);
        
        if (dropdown) {
            dropdown.classList.remove('active');
            setTimeout(() => {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateX(-50%) translateY(-30px)';
                setTimeout(() => {
                    dropdown.style.display = 'none';
                    if (currentDropdown === dropdownId) {
                        currentDropdown = null;
                    }
                    
                    // Solo mostrar la barra si realmente no hay dropdowns abiertos
                    if (!isAnyDropdownOpen()) {
                        toggleTabBarVisibility(true);
                    }
                    
                    isDropdownTransitioning = false;
                }, 300);
            }, 10);
        } else {
            isDropdownTransitioning = false;
        }
        
        if (triggerBtn) {
            triggerBtn.classList.remove('active');
        }
    }

    function closeAllDropdowns() {
        if (isDropdownTransitioning) return;
        
        isDropdownTransitioning = true;
        
        const dropdowns = ['bi', 'administracion', 'contabilidad', 'proyectos', 'rrhh'];
        
        dropdowns.forEach(dropdownId => {
            const dropdown = document.getElementById('dropdown-' + dropdownId);
            const triggerBtn = document.getElementById('trigger-' + dropdownId);
            
            if (dropdown) {
                dropdown.classList.remove('active');
                setTimeout(() => {
                    dropdown.style.opacity = '0';
                    dropdown.style.visibility = 'hidden';
                    dropdown.style.transform = 'translateX(-50%) translateY(-30px)';
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                    }, 300);
                }, 10);
            }
            
            if (triggerBtn) {
                triggerBtn.classList.remove('active');
            }
        });
        
        setTimeout(() => {
            currentDropdown = null;
            
            // Mostrar la barra de pestañas siempre
            toggleTabBarVisibility(true);
            
            isDropdownTransitioning = false;
        }, 350);
    }

    function selectTitle(dropdownId, titleId) {
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        if (!dropdown) return;
        
        const allTitles = dropdown.querySelectorAll('.menu-title-item');
        allTitles.forEach(title => title.classList.remove('active'));
        
        const titleElements = dropdown.querySelectorAll('.menu-title-item');
        let selectedTitle = null;
        
        titleElements.forEach(title => {
            const onclickAttr = title.getAttribute('onclick');
            if (onclickAttr && onclickAttr.includes(`selectTitle('${dropdownId}', '${titleId}')`)) {
                selectedTitle = title;
            }
        });
        
        if (selectedTitle) {
            selectedTitle.classList.add('active');
        }
        
        const dropdownContentContainer = document.getElementById(dropdownId + '-content');
        if (!dropdownContentContainer) return;
        
        const allContents = dropdownContentContainer.querySelectorAll('div[id*="-content"]');
        allContents.forEach(content => {
            if (content.id !== dropdownId + '-content') {
                content.style.display = 'none';
            }
        });
        
        const targetContentId = dropdownId + '-' + titleId + '-content';
        const targetContent = document.getElementById(targetContentId);
        
        if (targetContent) {
            targetContent.style.display = 'grid';
        }
        
        setTimeout(updateFavoriteButtons, 100);
        
        // IMPORTANTE: Mantener la barra de pestañas oculta cuando cambiamos entre secciones
        toggleTabBarVisibility(false);
    }

    function resetDropdownContent(dropdownId) {
        const dropdown = document.getElementById('dropdown-' + dropdownId);
        if (!dropdown) return;
        
        const allTitles = dropdown.querySelectorAll('.menu-title-item');
        allTitles.forEach(title => title.classList.remove('active'));
        
        if (allTitles.length > 0) {
            allTitles[0].classList.add('active');
        }
        
        const dropdownContent = document.getElementById(dropdownId + '-content');
        if (dropdownContent) {
            const allContents = dropdownContent.querySelectorAll('div[id*="-content"]');
            let firstContentFound = false;
            
            allContents.forEach((content, index) => {
                if (content.id !== dropdownId + '-content') {
                    if (!firstContentFound && content.id.startsWith(dropdownId + '-')) {
                        content.style.display = 'grid';
                        firstContentFound = true;
                    } else {
                        content.style.display = 'none';
                    }
                }
            });
        }
    }

    // ==================== ACCESOS RÁPIDOS ====================
    function loadQuickAccess() {
        const userId = {{ Auth::id() ?? 'null' }};
        const storageKey = `quickAccess_${userId}`;
        
        const savedQuickAccess = localStorage.getItem(storageKey);
        if (savedQuickAccess) {
            quickAccess = JSON.parse(savedQuickAccess);
        } else {
            quickAccess = getDefaultQuickAccess();
            saveQuickAccess();
        }
        
        updateFavoritesDisplay();
        updateFavoriteButtons();
    }

    function getDefaultQuickAccess() {
        const userRole = '{{ Auth::user()->role ?? "user" }}';
        
        const defaults = {
            'admin': [
                { name: 'Directivo', icon: 'fas fa-user-tie', category: 'BI', id: 'directivo' },
                { name: 'Facturación (CFDI)', icon: 'fas fa-file-invoice', category: 'Administración', id: 'facturacion-cfdi' },
                { name: 'Cartera de Proyectos', icon: 'fas fa-briefcase', category: 'Proyectos', id: 'cartera-proyectos' },
                { name: 'Plantilla de Empleados', icon: 'fas fa-users', category: 'Recursos Humanos', id: 'plantilla-empleados' }
            ],
            'director': [
                { name: 'Directivo', icon: 'fas fa-user-tie', category: 'BI', id: 'directivo' },
                { name: 'Estado de Resultados', icon: 'fas fa-chart-pie', category: 'Contabilidad', id: 'estado-resultados' },
                { name: 'Balance General', icon: 'fas fa-balance-scale', category: 'Contabilidad', id: 'balance-general' }
            ],
            'user': [
                { name: 'Avance Físico y Financiero', icon: 'fas fa-hard-hat', category: 'Proyectos', id: 'avance-fisico-financiero' },
                { name: 'Cálculo de Nómina', icon: 'fas fa-calculator', category: 'Recursos Humanos', id: 'calculo-nomina' }
            ]
        };
        
        return defaults[userRole] || defaults['user'];
    }

    function saveQuickAccess() {
        const userId = {{ Auth::id() ?? 'null' }};
        const storageKey = `quickAccess_${userId}`;
        localStorage.setItem(storageKey, JSON.stringify(quickAccess));
        updateFavoritesDisplay();
    }

    function addQuickAccess(name, icon, category) {
        const id = name.toLowerCase().replace(/\s+/g, '-');
        
        const exists = quickAccess.some(item => item.id === id);
        if (!exists) {
            quickAccess.push({
                name: name,
                icon: icon,
                category: category,
                id: id,
                userId: {{ Auth::id() ?? 'null' }}
            });
            
            showNotification(`${name} agregado a accesos rápidos`);
            renderQuickAccess();
            saveQuickAccess();
        } else {
            showNotification(`${name} ya está en tus accesos rápidos`);
        }
    }

    function removeQuickAccess(index) {
        const removed = quickAccess.splice(index, 1)[0];
        showNotification(`${removed.name} eliminado de accesos rápidos`);
        renderQuickAccess();
        saveQuickAccess();
    }

    function renderQuickAccess() {
        const container = document.getElementById('quickaccess-items');
        const emptyMessage = document.getElementById('empty-quickaccess');
        
        if (!quickAccess || quickAccess.length === 0) {
            if (container) container.style.display = 'none';
            if (emptyMessage) emptyMessage.style.display = 'block';
            return;
        }
        
        if (container) {
            container.style.display = 'block';
            if (emptyMessage) emptyMessage.style.display = 'none';
            
            let html = '';
            quickAccess.forEach((item, index) => {
                const colorClasses = {
                    'BI': 'bg-blue-100 text-blue-600',
                    'Administración': 'bg-green-100 text-green-600',
                    'Contabilidad': 'bg-purple-100 text-purple-600',
                    'Proyectos': 'bg-orange-100 text-orange-600',
                    'Recursos Humanos': 'bg-red-100 text-red-600'
                };
                
                const bgColor = colorClasses[item.category] || 'bg-gray-100 text-gray-600';
                
                html += `
                    <div class="draggable-item flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200 mb-2"
                         draggable="true" data-index="${index}">
                        <div class="flex items-center">
                            <i class="fas fa-grip-vertical text-gray-400 mr-3 cursor-move" title="Arrastrar para reordenar"></i>
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 ${bgColor}">
                                <i class="${item.icon}"></i>
                            </div>
                            <div>
                                <div class="font-medium">${item.name}</div>
                                    <div class="text-xs text-gray-500">${item.category}</div>
                            </div>
                        </div>
                        <button onclick="removeQuickAccess(${index})" class="text-red-600 hover:text-red-800 p-1">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            initDragAndDrop();
        }
    }

    function saveQuickAccessChanges() {
        saveQuickAccess();
        showNotification('Accesos rápidos guardados correctamente');
        closeQuickAccessSettings();
    }

    function openQuickAccessSettings() {
        renderQuickAccess();
        document.getElementById('quickaccess-settings-modal').classList.remove('hidden');
        document.getElementById('quickaccess-settings-modal').classList.add('flex');
    }

    function closeQuickAccessSettings() {
        document.getElementById('quickaccess-settings-modal').classList.add('hidden');
        document.getElementById('quickaccess-settings-modal').classList.remove('flex');
    }

    // ==================== Notificaciones =======================

    // ==================== SISTEMA DE NOTIFICACIONES CON ALPINE.JS ====================
function notifications() {
    return {
        isOpen: false,
        unreadCount: 0,
        filter: 'all',
        notifications: [],
        hasMore: false,
        
        async initNotifications() {
            // Cargar notificaciones iniciales
            await this.loadNotifications();
            
            // Configurar escuchador de eventos para nuevas notificaciones
            window.addEventListener('new-notification', (e) => {
                this.addNotification(e.detail);
            });
            
            // Simular recepción de notificaciones (conectar con tu backend)
            this.startPolling();
        },
        
        async loadNotifications() {
            try {
                // Aquí cargas desde tu backend
                const response = await fetch('/api/notifications');
                const data = await response.json();
                this.notifications = data.notifications || this.getDemoNotifications();
                this.updateUnreadCount();
            } catch (error) {
                console.log('Usando notificaciones de demostración');
                this.notifications = this.getDemoNotifications();
                this.updateUnreadCount();
            }
        },
        
        getDemoNotifications() {
            return [
                {
                    id: 1,
                    title: 'Bienvenido al sistema',
                    message: 'Has iniciado sesión correctamente en la plataforma.',
                    type: 'info',
                    priority: 'low',
                    read: false,
                    timestamp: new Date().toISOString(),
                    category: 'Sistema'
                },
                {
                    id: 2,
                    title: 'Nuevo proyecto asignado',
                    message: 'Se te ha asignado el proyecto "Edificio Corporativo".',
                    type: 'success',
                    priority: 'high',
                    read: false,
                    timestamp: new Date(Date.now() - 3600000).toISOString(),
                    category: 'Proyectos'
                },
                {
                    id: 3,
                    title: 'Reunión programada',
                    message: 'Reunión de seguimiento mañana a las 10:00 AM.',
                    type: 'warning',
                    priority: 'medium',
                    read: true,
                    timestamp: new Date(Date.now() - 86400000).toISOString(),
                    category: 'Calendario'
                }
            ];
        },
        
        startPolling() {
            // Verificar nuevas notificaciones cada 30 segundos
            setInterval(() => {
                this.checkNewNotifications();
            }, 30000);
        },
        
        async checkNewNotifications() {
            // Aquí verificas si hay nuevas notificaciones en el backend
            // Por ahora solo simulamos
            if (Math.random() > 0.7) {
                this.addNotification({
                    id: Date.now(),
                    title: 'Nueva notificación',
                    message: 'Tienes una nueva actualización en el sistema.',
                    type: 'info',
                    priority: 'medium',
                    read: false,
                    timestamp: new Date().toISOString(),
                    category: 'Sistema'
                });
            }
        },
        
        // MÉTODO PARA AGREGAR NUEVAS NOTIFICACIONES
        addNotification(notification) {
            notification.id = notification.id || Date.now();
            notification.timestamp = notification.timestamp || new Date().toISOString();
            notification.read = false;
            
            this.notifications.unshift(notification);
            this.updateUnreadCount();
            
            // Mostrar notificación toast
            this.showToast(notification);
            
            // Reproducir sonido (opcional)
            // this.playSound();
        },
        
        // MÉTODO PARA MOSTRAR TOAST (NOTIFICACIÓN FLOTANTE)
        showToast(notification) {
            // Crear toast con Alpine.js
            const toast = document.createElement('div');
            toast.className = 'fixed top-20 right-4 z-[9999] transform transition-all duration-500 translate-x-0 opacity-100';
            toast.style.maxWidth = '400px';
            
            const colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                warning: 'bg-yellow-600',
                info: 'bg-blue-600',
                default: 'bg-gray-800'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle',
                default: 'fa-bell'
            };
            
            const bgColor = colors[notification.type] || colors.default;
            const icon = icons[notification.type] || icons.default;
            
            toast.innerHTML = `
                <div class="${bgColor} text-white px-5 py-4 rounded-lg shadow-2xl flex items-start gap-3">
                    <i class="fas ${icon} text-white text-lg mt-0.5"></i>
                    <div class="flex-1">
                        <div class="font-bold text-sm">${notification.title}</div>
                        <div class="text-sm opacity-90">${notification.message}</div>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" class="text-white/80 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto-eliminar después de 5 segundos
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
        },
        
        toggleNotifications() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.markAllAsRead();
            }
        },
        
        get filteredNotifications() {
            if (this.filter === 'unread') {
                return this.notifications.filter(n => !n.read);
            } else if (this.filter === 'important') {
                return this.notifications.filter(n => n.priority === 'high');
            }
            return this.notifications;
        },
        
        markAsRead(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.read = true;
                this.updateUnreadCount();
            }
        },
        
        markAllAsRead() {
            this.notifications.forEach(n => n.read = true);
            this.updateUnreadCount();
        },
        
        deleteNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
            this.updateUnreadCount();
        },
        
        clearAll() {
            this.notifications = [];
            this.updateUnreadCount();
        },
        
        updateUnreadCount() {
            this.unreadCount = this.notifications.filter(n => !n.read).length;
        },
        
        getTypeClass(type) {
            const classes = {
                success: 'bg-green-100 text-green-600',
                error: 'bg-red-100 text-red-600',
                warning: 'bg-yellow-100 text-yellow-600',
                info: 'bg-blue-100 text-blue-600'
            };
            return classes[type] || 'bg-gray-100 text-gray-600';
        },
        
        getTypeIcon(type) {
            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };
            return icons[type] || 'fas fa-bell';
        },
        
        formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);
            
            if (diffMins < 1) return 'Ahora mismo';
            if (diffMins < 60) return `Hace ${diffMins} min`;
            if (diffHours < 24) return `Hace ${diffHours} h`;
            if (diffDays < 7) return `Hace ${diffDays} d`;
            
            return date.toLocaleDateString();
        },
        
        viewAll() {
            window.location.href = '/notificaciones';
            this.isOpen = false;
        },
        
        loadMore() {
            // Implementar paginación
            console.log('Cargar más notificaciones');
        }
    };
}

// ==================== FUNCIÓN PARA ENVIAR NOTIFICACIONES DESDE CUALQUIER PARTE ====================
function notify(message, title = 'Notificación', type = 'info') {
    const event = new CustomEvent('new-notification', {
        detail: {
            title: title,
            message: message,
            type: type,
            priority: type === 'error' ? 'high' : 'medium',
            category: 'Sistema',
            timestamp: new Date().toISOString()
        }
    });
    window.dispatchEvent(event);
}

// Ejemplos de uso:
// notify('Proyecto guardado correctamente', 'Éxito', 'success');
// notify('Error al cargar los datos', 'Error', 'error');
// notify('Reunión en 5 minutos', 'Recordatorio', 'warning');

    // ==================== ARRASTRAR Y SOLTAR ====================
    function initDragAndDrop() {
        const container = document.getElementById('quickaccess-items');
        if (!container) return;
        
        const draggableItems = container.querySelectorAll('.draggable-item');
        draggableItems.forEach(item => {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('dragenter', handleDragEnter);
            item.addEventListener('dragleave', handleDragLeave);
            item.addEventListener('drop', handleDrop);
            item.addEventListener('dragend', handleDragEnd);
        });
    }

    function handleDragStart(e) {
        draggedItem = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e) {
        e.preventDefault();
        return false;
    }

    function handleDragEnter(e) {
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        this.classList.remove('over');
    }

    function handleDrop(e) {
        e.stopPropagation();
        e.preventDefault();
        
        if (draggedItem !== this) {
            const items = Array.from(document.querySelectorAll('.draggable-item'));
            const draggedIndex = parseInt(draggedItem.getAttribute('data-index'));
            const dropIndex = parseInt(this.getAttribute('data-index'));
            
            if (!isNaN(draggedIndex) && !isNaN(dropIndex)) {
                const [removed] = quickAccess.splice(draggedIndex, 1);
                quickAccess.splice(dropIndex, 0, removed);
                
                renderQuickAccess();
            }
        }
        
        return false;
    }

    function handleDragEnd(e) {
        const items = document.querySelectorAll('.draggable-item');
        items.forEach(item => {
            item.classList.remove('over');
            item.classList.remove('dragging');
        });
        draggedItem = null;
    }

    // ==================== FUNCIONES PARA FAVORITOS ====================
    function updateFavoritesDisplay() {
        const favoritesList = document.getElementById('favorites-list');
        const emptyFavorites = document.getElementById('empty-favorites');
        const favoritesCount = document.getElementById('favorites-count');
        const notificationDot = document.getElementById('notification-dot');
        const favoriteCountBadge = document.getElementById('favorite-count');
        
        const count = quickAccess ? quickAccess.length : 0;
        
        if (favoritesCount) favoritesCount.textContent = `${count} acceso(s)`;
        
        if (count > 0) {
            if (notificationDot) notificationDot.style.display = 'block';
            if (favoriteCountBadge) {
                favoriteCountBadge.textContent = count;
                favoriteCountBadge.style.display = 'flex';
            }
            
            if (favoritesList) {
                favoritesList.style.display = 'block';
                if (emptyFavorites) emptyFavorites.style.display = 'none';
                
                let html = '<div class="space-y-3">';
                quickAccess.forEach((item, index) => {
                    const colorClasses = {
                        'BI': 'bg-blue-100 text-blue-600',
                        'Administración': 'bg-green-100 text-green-600',
                        'Contabilidad': 'bg-purple-100 text-purple-600',
                        'Proyectos': 'bg-orange-100 text-orange-600',
                        'Recursos Humanos': 'bg-red-100 text-red-600'
                    };
                    
                    const bgColor = colorClasses[item.category] || 'bg-gray-100 text-gray-600';
                    
                    html += `
                        <div class="favorite-item bg-white border border-gray-200 rounded-lg p-3 flex items-center justify-between group hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 ${bgColor}">
                                        <i class="${item.icon}"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">${item.name}</div>
                                        <div class="text-xs text-gray-500">${item.category}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="navigateFromFavorite('${item.name}')" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Abrir">
                                    <i class="fas fa-external-link-alt"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                favoritesList.innerHTML = html;
            }
        } else {
            if (notificationDot) notificationDot.style.display = 'none';
            if (favoriteCountBadge) favoriteCountBadge.style.display = 'none';
            if (favoritesList) favoritesList.style.display = 'none';
            if (emptyFavorites) emptyFavorites.style.display = 'block';
        }
    }

    function updateFavoriteButtons() {
        const activeDropdown = currentDropdown ? document.getElementById('dropdown-' + currentDropdown) : null;
        
        if (activeDropdown) {
            const cards = activeDropdown.querySelectorAll('.content-card');
            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent;
                const btn = card.querySelector('.btn-favorite');
                
                if (btn) {
                    const isFavorite = quickAccess && quickAccess.some(item => item.name === title);
                    
                    if (isFavorite) {
                        btn.classList.add('active');
                        btn.innerHTML = '<i class="fas fa-star"></i>';
                    } else {
                        btn.classList.remove('active');
                        btn.innerHTML = '<i class="fas fa-star"></i>';
                    }
                }
            });
        }
    }

    function toggleFavorite(name, icon, category) {
        const id = name.toLowerCase().replace(/\s+/g, '-');
        const existingIndex = quickAccess.findIndex(item => item.id === id);
        
        if (existingIndex !== -1) {
            quickAccess.splice(existingIndex, 1);
            showNotification(`${name} eliminado de accesos rápidos`);
        } else {
            quickAccess.push({
                name: name,
                icon: icon,
                category: category,
                id: id,
                userId: {{ Auth::id() ?? 'null' }}
            });
            showNotification(`${name} agregado a accesos rápidos`);
        }
        
        saveQuickAccess();
        updateFavoriteButtons();
    }

    function clearFavorites() {
        if (quickAccess && quickAccess.length > 0) {
            if (confirm('¿Estás seguro de que deseas eliminar todos los accesos rápidos?')) {
                quickAccess = [];
                saveQuickAccess();
                showNotification('Todos los accesos rápidos han sido eliminados');
            }
        } else {
            showNotification('No hay accesos rápidos para eliminar');
        }
    }

    // ==================== FUNCIONES DE NAVEGACIÓN ====================
    function navigateTo(pageName) {
        closeAllDropdowns();
        showNotification(`Navegando a: ${pageName}`);
    }

    function navigateFromFavorite(pageName) {
        showNotification(`Abriendo: ${pageName}`);
        toggleSidebar();
    }

    // ==================== FUNCIONES DE CERRAR SESIÓN ====================
    function confirmLogout() {
        document.getElementById('logout-confirm-modal').classList.remove('hidden');
        document.getElementById('logout-confirm-modal').classList.add('flex');
    }

    function closeLogoutConfirm() {
        document.getElementById('logout-confirm-modal').classList.add('hidden');
        document.getElementById('logout-confirm-modal').classList.remove('flex');
    }

    // ==================== FUNCIONES DE BARRA LATERAL ====================
    function toggleSidebar() {
        sidebarOpen = !sidebarOpen;
        const sidebar = document.getElementById('quick-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');
        
        if (sidebarOpen) {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            toggleBtn.classList.add('moved');
        } else {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            toggleBtn.classList.remove('moved');
        }
    }

    // ==================== FUNCIÓN DE NOTIFICACIONES ====================
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-20 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = message;
        notification.style.animation = 'fadeInOut 3s ease-in-out forwards';
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // ==================== SISTEMA DE PESTAÑAS ====================
    function initTabSystem() {
        let tabManager;
        
        class TabManager {
            constructor() {
                this.tabs = [];
                this.activeTabId = null;
                this.tabCounter = 1;
                this.currentSection = null;
                this.currentPage = null;
                
                this.init();
            }
            
            init() {
                const savedTabs = localStorage.getItem('userTabs');
                if (savedTabs) {
                    this.tabs = JSON.parse(savedTabs);
                    if (this.tabs.length > 0) {
                        this.activeTabId = this.tabs[0].id;
                        this.renderTabs();
                        this.loadTabContent(this.activeTabId);
                    }
                }
                
                if (this.tabs.length === 0) {
                    this.createNewTab('Inicio', 'dashboard');
                }
                
                // Ajustar contenido después de inicializar pestañas
                setTimeout(() => {
                    adjustPageContent();
                }, 150);
                
                document.getElementById('closeAllTabsBtn').addEventListener('click', () => this.closeAllTabs());
                document.getElementById('newTabBtn').addEventListener('click', () => this.createNewTab('Inicio', 'dashboard'));
                
                this.setupNavigationInterception();
            }
            
            createNewTab(title, section) {
                const tabId = 'tab-' + this.tabCounter++;
                
                const tab = {
                    id: tabId,
                    title: title,
                    section: section,
                    timestamp: new Date().toISOString(),
                    data: {
                        page: title,
                        module: section
                    }
                };
                
                this.tabs.push(tab);
                this.activeTabId = tabId;
                this.currentSection = section;
                this.currentPage = title;
                
                this.saveTabs();
                this.renderTabs();
                this.updateUrl(title, section);
                
                // Ajustar contenido después de crear nueva pestaña
                setTimeout(() => {
                    adjustPageContent();
                }, 100);
                
                return tabId;
            }
            
            switchToTab(tabId) {
                this.activeTabId = tabId;
                const tab = this.tabs.find(t => t.id === tabId);
                if (tab) {
                    this.currentSection = tab.section;
                    this.currentPage = tab.title;
                    this.renderTabs();
                    this.updateUrl(tab.title, tab.section);
                    
                    // Ajustar contenido después de cambiar pestaña
                    setTimeout(() => {
                        adjustPageContent();
                    }, 50);
                }
            }
            
            closeTab(tabId) {
                const tabIndex = this.tabs.findIndex(t => t.id === tabId);
                if (tabIndex !== -1) {
                    this.tabs.splice(tabIndex, 1);
                    
                    if (tabId === this.activeTabId) {
                        if (this.tabs.length > 0) {
                            const newActiveIndex = Math.max(0, tabIndex - 1);
                            this.activeTabId = this.tabs[newActiveIndex].id;
                            const activeTab = this.tabs[newActiveIndex];
                            this.currentSection = activeTab.section;
                            this.currentPage = activeTab.title;
                            this.updateUrl(activeTab.title, activeTab.section);
                        } else {
                            this.createNewTab('Inicio', 'dashboard');
                            return;
                        }
                    }
                    
                    this.saveTabs();
                    this.renderTabs();
                    
                    // Ajustar contenido después de cerrar pestaña
                    setTimeout(() => {
                        adjustPageContent();
                    }, 50);
                }
            }
            
            closeAllTabs() {
                if (this.tabs.length > 0) {
                    this.tabs = [];
                    this.createNewTab('Inicio', 'dashboard');
                    
                    // Ajustar contenido después de cerrar todas las pestañas
                    setTimeout(() => {
                        adjustPageContent();
                    }, 100);
                }
            }
            
            updateTab(tabId, title, section) {
                const tab = this.tabs.find(t => t.id === tabId);
                if (tab) {
                    tab.title = title;
                    tab.section = section;
                    tab.timestamp = new Date().toISOString();
                    tab.data = { page: title, module: section };
                    this.saveTabs();
                    this.renderTabs();
                    
                    // Ajustar contenido después de actualizar pestaña
                    setTimeout(() => {
                        adjustPageContent();
                    }, 50);
                }
            }
            
            renderTabs() {
                const tabsContainer = document.getElementById('tabsNavContainer');
                if (!tabsContainer) return;
                
                tabsContainer.innerHTML = '';
                
                this.tabs.forEach(tab => {
                    const isActive = tab.id === this.activeTabId;
                    
                    const tabElement = document.createElement('div');
                    tabElement.className = `tab-item ${isActive ? 'active' : ''}`;
                    tabElement.innerHTML = `
                        <div class="tab-title">${tab.title}</div>
                        ${this.tabs.length > 1 ? '<button class="tab-close-btn" onclick="tabManager.closeTab(\'' + tab.id + '\')">×</button>' : ''}
                        ${isActive ? '<div class="active-tab-indicator"></div>' : ''}
                    `;
                    
                    tabElement.addEventListener('click', (e) => {
                        if (!e.target.classList.contains('tab-close-btn')) {
                            this.switchToTab(tab.id);
                        }
                    });
                    
                    tabsContainer.appendChild(tabElement);
                });
            }
            
            setupNavigationInterception() {
                document.addEventListener('click', (e) => {
                    const target = e.target;
                    
                    if (target.closest('.content-card') || target.closest('.nav-btn')) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        let pageName = '';
                        let section = '';
                        
                        if (target.closest('.content-card')) {
                            const card = target.closest('.content-card');
                            pageName = card.querySelector('.card-title').textContent;
                            
                            const activeDropdown = document.querySelector('.dropdown-container.active');
                            if (activeDropdown) {
                                if (activeDropdown.id.includes('bi')) section = 'BI';
                                else if (activeDropdown.id.includes('administracion')) section = 'Administración';
                                else if (activeDropdown.id.includes('contabilidad')) section = 'Contabilidad';
                                else if (activeDropdown.id.includes('proyectos')) section = 'Proyectos';
                                else if (activeDropdown.id.includes('rrhh')) section = 'Recursos Humanos';
                            }
                        } else if (target.closest('.nav-btn')) {
                            pageName = target.closest('.nav-btn').textContent.replace('Ir a ', '');
                            section = this.currentSection || 'Dashboard';
                        }
                        
                        if (pageName) {
                            this.navigateToPage(pageName, section);
                        }
                    }
                });
            }
            
            navigateToPage(pageName, section) {
                const existingTab = this.tabs.find(tab => 
                    tab.title === pageName && tab.section === section
                );
                
                if (existingTab) {
                    this.switchToTab(existingTab.id);
                } else {
                    if (this.activeTabId) {
                        this.updateTab(this.activeTabId, pageName, section);
                    } else {
                        this.createNewTab(pageName, section);
                    }
                }
                
                this.closeAllDropdowns();
                this.updatePageContent(pageName, section);
            }
            
            updatePageContent(pageName, section) {
                console.log(`Navegando a: ${pageName} - ${section}`);
                document.title = `${pageName} - ${section} - MejoraSoft`;
            }
            
            updateUrl(pageName, section) {
                const url = new URL(window.location);
                url.searchParams.set('page', encodeURIComponent(pageName));
                url.searchParams.set('section', encodeURIComponent(section));
                window.history.pushState({ page: pageName, section: section }, '', url);
            }
            
            closeAllDropdowns() {
                closeAllDropdowns();
            }
            
            saveTabs() {
                localStorage.setItem('userTabs', JSON.stringify(this.tabs));
            }
            
            loadTabContent(tabId) {
                const tab = this.tabs.find(t => t.id === tabId);
                if (tab) {
                    this.updatePageContent(tab.title, tab.section);
                }
            }
        }
        
        tabManager = new TabManager();
        
        window.addEventListener('popstate', function(event) {
            if (event.state) {
                const { page, section } = event.state;
                tabManager.navigateToPage(page, section);
            }
        });
        
        window.tabManager = tabManager;
    }

    // ==================== FUNCIONES GLOBALES ==================== 
    window.navigateToTab = function(pageName, section = 'Dashboard') {
        if (window.tabManager) {
            window.tabManager.navigateToPage(pageName, section);
        }
    };
    
    window.closeModalAndNavigate = function(pageName, section) {
        closeAllDropdowns();
        if (window.tabManager) {
            window.tabManager.navigateToPage(pageName, section);
        }
    };
</script>

</body>
</html>