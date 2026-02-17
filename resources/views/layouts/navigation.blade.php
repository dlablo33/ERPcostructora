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
        /* ========== VARIABLES DE COLOR ========== */
        :root {
            --color-primary: #083CAE;
            --color-secondary: #2CBF1F;
            --color-accent: #eaf512;
            --color-red: #FF0000;
            --navbar-height: 64px;
            --tabbar-height: 40px;
            --total-header-height: calc(var(--navbar-height) + var(--tabbar-height));
            --sidebar-width: 260px;
        }

        /* ========== RESET ========== */
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

        /* Iconos del menú en color eaf512 */
        nav.bg-construction-dark .desktop-menu button i {
            color: #eaf512 !important;
            transition: all 0.3s ease;
        }

        nav.bg-construction-dark .desktop-menu button:hover i {
            color: white !important;
        }

        /* Texto de las secciones se vuelve negro al pasar el mouse */
        nav.bg-construction-dark .desktop-menu button:hover span {
            color: #000000 !important;
            font-weight: bold !important;
        }

        nav.bg-construction-dark .desktop-menu button {
            transition: all 0.3s ease;
        }

        nav.bg-construction-dark .desktop-menu button:hover {
            background-color: transparent !important;
        }

        nav.bg-construction-dark .desktop-menu button:hover i {
            color: #000000 !important;
        }

        /* Estrella del menú */
        .desktop-menu button i.fa-star {
            color: #eaf512 !important;
            font-size: 1.2rem;
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
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            border-bottom: 2px solid #FF0000 !important;
        }

        .tab-navigation-bar.sidebar-open {
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
        }

        /* Contenedor del botón Cerrar Todo - Fondo rojo completo */
        .close-all-tabs-container {
            background-color: #FF0000 !important;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 20px;
            margin-left: -15px;
            border-right: 2px solid #cc0000;
        }

        .close-all-tabs-btn {
            background-color: transparent !important;
            border: none !important;
            color: white !important;
            font-weight: bold !important;
            padding: 6px 0 !important;
            transition: all 0.3s ease !important;
            text-transform: uppercase !important;
            font-size: 12px !important;
            letter-spacing: 0.5px !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .close-all-tabs-btn:hover {
            transform: translateY(-2px);
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .close-all-tabs-btn i {
            color: white !important;
            font-size: 14px;
        }

        //* ========== ESTILOS DE PESTAÑAS MINIMALISTAS ========== */
.tab-item {
    cursor: pointer;
    max-width: 200px;
    position: relative;
    user-select: none;
    transition: color 0.15s ease;
}

.tab-item .close-tab {
    transition: opacity 0.15s ease;
}

.tab-item:hover .close-tab {
    opacity: 1 !important;
}

.close-tab:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

.tab-context-menu {
    animation: fadeIn 0.15s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.context-menu-item {
    transition: background-color 0.15s ease;
}

.context-menu-item:hover {
    background-color: #f3f4f6;
}

#tabsNavContainer {
    display: flex;
    align-items: center;
    overflow-x: auto;
    overflow-y: hidden;
    flex: 1;
    height: 100%;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.3) rgba(255,255,255,0.1);
    padding-left: 10px;
}

#tabsNavContainer::-webkit-scrollbar {
    height: 3px;
}

#tabsNavContainer::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
}

#tabsNavContainer::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 3px;
}

#tabsNavContainer::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

.new-tab-btn {
    flex-shrink: 0;
    transition: all 0.15s ease;
}

.new-tab-btn:hover {
    transform: scale(1.05);
}

@keyframes fadeIn { 
    from { opacity: 0; transform: translateY(-5px); } 
    to { opacity: 1; transform: translateY(0); } 
}
        /* ========== BARRA LATERAL DE SECCIÓN ========== */
        .section-sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: -380px;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: #083CAE;
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            border-radius: 0 12px 12px 0;
        }

        .section-sidebar.open {
            left: 0;
        }

        .section-sidebar-header {
            background: #083CAE;
            padding: 1.25rem 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .section-sidebar-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-sidebar-title i {
            font-size: 1.5rem;
            color: #ffff00;
        }

        .section-sidebar-title h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .section-sidebar-close {
            background: rgba(255,255,255,0.15);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .section-sidebar-close:hover {
            background: rgba(255,255,255,0.25);
            transform: rotate(90deg);
        }

        .section-sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem;
            background: #083CAE;
        }

        .sidebar-menu-group {
            margin-bottom: 0.0rem;
        }

        .sidebar-menu-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            background: transparent ;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: transparent;
        }

        .sidebar-menu-title span i {
            color: #ffff00;
            margin-right: 8px;
            width: 10px;
        }

        .sidebar-menu-title i:last-child {
            color: #ffff00;
            transition: transform 0.3s ease;
            font-size: 0.85rem;
        }

        .sidebar-menu-title.expanded i:last-child {
            transform: rotate(90deg);
        }

        .sidebar-menu-title:hover {
            background: rgba(255,255,255,0.18);
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            margin-left: 0.5rem;
            padding-left: 0.5rem;
            border-left: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar-submenu.expanded {
            max-height: 800px;
        }

        .sidebar-submenu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1.25rem;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 2px 0;
            font-size: 0.9rem;
            background: transparent;
        }

        .sidebar-submenu-item i:first-child {
            width: 20px;
            margin-right: 12px;
            color: #ffff00;
            font-size: 0.9rem;
        }

        .favorite-star {
            color: rgba(255,255,255,0.5);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .favorite-star.active {
            color: #ffff00;
            text-shadow: 0 0 5px rgba(255,255,0,0.5);
        }

        .favorite-star:hover {
            color: #ffff00;
            transform: scale(1.2);
        }

        .sidebar-submenu-item:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .sidebar-submenu-item:hover .favorite-star {
            color: #ffff00;
        }

        /* ========== BARRA LATERAL DE FAVORITOS ========== */
        .quick-sidebar {
            position: fixed;
            top: var(--navbar-height);
            right: -380px;
            width: 280px;
            height: calc(100vh - var(--navbar-height));
            background: #083CAE;
            box-shadow: -5px 0 15px rgba(0,0,0,0.15);
            z-index: 1001;
            transition: right 0.3s ease-in-out;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            border-radius: 8px 0 0 8px;
        }

        .quick-sidebar.open {
            right: 0;
        }

        .quick-sidebar .bg-construction-dark {
            background: #083CAE !important;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .quick-sidebar h3 {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .quick-sidebar h3 i {
            color: #ffff00;
        }

        .favorite-item {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            border-left: 4px solid #ffff00;
            cursor: pointer;
        }

        .favorite-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(-5px);
        }

        .favorite-item i {
            color: #eaf512;
            margin-right: 12px;
            font-size: 1rem;
        }

        .favorite-item-content {
            flex: 1;
        }

        .favorite-item-title {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .favorite-item-path {
            color: rgba(255,255,255,0.6);
            font-size: 0.7rem;
        }

        .favorite-item-remove {
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            transition: all 0.2s ease;
        }

        .favorite-item-remove:hover {
            color: #ef4444;
            background: rgba(239,68,68,0.2);
        }

        /* BOTÓN FLOTANTE */
        .sidebar-toggle-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #083CAE;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(8, 60, 174, 0.4);
            transition: all 0.3s ease;
            z-index: 1002;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar-toggle-btn i {
            color: #ffff00;
            font-size: 1.4rem;
        }

        .sidebar-toggle-btn:hover {
            background: #0a4ad0;
            transform: scale(1.05);
        }

        #favorite-count {
            background: #f59e0b !important;
            border: 2px solid white;
        }

        /* ========== CONTENIDO PRINCIPAL ========== */
        .main-content-container {
            margin-top: var(--total-header-height);
            min-height: calc(100vh - var(--total-header-height));
            transition: margin-left 0.3s ease, width 0.3s ease;
            padding: 1.5rem;
            width: 100%;
            box-sizing: border-box;
        }

        .main-content-container.sidebar-open {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
        }

        /* ========== MENÚ HAMBURGUESA MÓVIL ========== */
        .mobile-menu-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background: #083CAE;
            z-index: 1100;
            transition: left 0.3s ease;
            overflow-y: auto;
            padding-top: var(--navbar-height);
        }

        .mobile-menu-sidebar.open {
            left: 0;
        }

        .mobile-menu-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-header h3 {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .mobile-menu-header i {
            color: #ffff00;
        }

        .mobile-menu-items {
            padding: 1rem;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: white;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            background: rgba(255,255,255,0.08);
        }

        .mobile-menu-item i {
            width: 24px;
            margin-right: 15px;
            color: #ffff00;
            font-size: 1.1rem;
        }

        .mobile-menu-item span {
            font-weight: 500;
        }

        .mobile-menu-item:hover {
            background: rgba(255,255,255,0.15);
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ========== NOTIFICACIONES ========== */
        .notifications-menu {
            position: absolute;
            right: 0;
            top: 100%;
            width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 1100;
            margin-top: 10px;
            overflow: hidden;
            border: 1px solid rgba(8,60,174,0.1);
        }

        .notifications-header {
            background: #083CAE;
            padding: 1rem 1.25rem;
            color: white;
        }

        .notifications-header h3 i {
            color: #ffff00;
        }

        /* ========== SCROLLBARS ========== */
        .section-sidebar::-webkit-scrollbar,
        .quick-sidebar::-webkit-scrollbar,
        .mobile-menu-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .section-sidebar::-webkit-scrollbar-track,
        .quick-sidebar::-webkit-scrollbar-track,
        .mobile-menu-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }

        .section-sidebar::-webkit-scrollbar-thumb,
        .quick-sidebar::-webkit-scrollbar-thumb,
        .mobile-menu-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }

        .section-sidebar::-webkit-scrollbar-thumb:hover,
        .quick-sidebar::-webkit-scrollbar-thumb:hover,
        .mobile-menu-sidebar::-webkit-scrollbar-thumb:hover {
            background: #ffff00;
        }

        /* Punto de notificación */
        #notification-dot {
            background-color: #eaf512 !important;
            box-shadow: 0 0 5px #eaf512;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 100%;
            }

            .section-sidebar {
                width: 100%;
                left: -100%;
                border-radius: 0;
            }

            .quick-sidebar {
                width: 100%;
                right: -100%;
                border-radius: 0;
            }

            .main-content-container.sidebar-open,
            .tab-navigation-bar.sidebar-open {
                margin-left: 0;
                width: 100%;
                left: 0;
            }

            .desktop-menu {
                display: none !important;
            }
        }

        @media (min-width: 993px) {
            .mobile-menu-sidebar,
            .mobile-overlay {
                display: none !important;
            }
        }
    </style>
    
</head>

<body class="bg-gray-50">
    <!-- TOP NAVIGATION BAR -->
    <nav x-data="{ mobileMenuOpen: false }" class="bg-construction-dark text-white shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-8xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Left side: Logo and Hamburger -->
                <div class="flex items-center space-x-4">
                    <!-- Hamburger button for mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-md hover:bg-blue-800">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                            <img src="../img/login/logoblanco.png" alt="Logo" class="h-[180px] w-[180px]" onerror="this.src='https://via.placeholder.com/150x40/083CAE/FFFFFF?text=LOGO'">
                        </a>
                    </div>
                    
                </div>

                <!-- Desktop Menu Buttons -->
                <div class="desktop-menu hidden md:flex items-center justify-center flex-1 space-x-1">
                    <button onclick="toggleSectionSidebar('bi')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-chart-line"></i>
                        <span>BI</span>
                    </button>

                    <button onclick="toggleSectionSidebar('administracion')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Administración</span>
                    </button>

                    <button onclick="toggleSectionSidebar('contabilidad')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-calculator"></i>
                        <span>Contabilidad</span>
                    </button>
                    
                    <button onclick="toggleSectionSidebar('proyectos')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-project-diagram"></i>
                        <span>Proyectos</span>
                    </button>

                    <button onclick="toggleSectionSidebar('rrhh')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-users"></i>
                        <span>RRHH</span>
                    </button>

                    <!-- NUEVOS BOTONES: INVENTARIOS Y COMPRAS -->
                    <button onclick="toggleSectionSidebar('inventarios')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-boxes"></i>
                        <span>Inventarios</span>
                    </button>

                    <button onclick="toggleSectionSidebar('compras')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Compras</span>
                    </button>
                </div>

                <!-- Iconos de estrella, campana y búsqueda -->
                <div class="flex items-center space-x-2 ml-auto">
                    <button onclick="toggleQuickSidebar()" class="px-3 py-2 rounded-lg hover:bg-blue-800 transition relative">
                        <i class="fas fa-star" style="color: #eaf512;"></i>
                        <span id="notification-dot" class="absolute top-1 right-1 w-2 h-2 bg-yellow-400 rounded-full" style="display: none;"></span>
                    </button>

                    <!-- NOTIFICACIONES -->
                    <div x-data="notifications()" x-init="initNotifications()" class="relative">
                        <button @click="toggleNotifications()" class="px-3 py-2 rounded-lg hover:bg-blue-800 transition relative">
                            <i class="fas fa-bell" style="color: #eaf512;"></i>
                            <span x-show="unreadCount > 0" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-2 -right-2 min-w-[20px] h-5 bg-red-500 text-xs rounded-full flex items-center justify-center px-1"></span>
                        </button>
                        
                        <div x-show="isOpen" @click.away="isOpen = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="notifications-menu">
                            
                            <div class="notifications-header">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="font-bold text-lg"><i class="fas fa-bell"></i> Notificaciones</h3>
                                        <p class="text-blue-100 text-xs mt-1">Tus alertas y mensajes</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button @click="markAllAsRead()" class="p-1.5 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-check-double text-white"></i>
                                        </button>
                                        <button @click="clearAll()" class="p-1.5 rounded-lg hover:bg-blue-700 transition">
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                <div x-show="filteredNotifications.length === 0" class="text-center py-10 text-gray-500">
                                    <i class="fas fa-bell-slash text-4xl mb-3 opacity-30"></i>
                                    <p class="font-medium">No hay notificaciones</p>
                                </div>
                                
                                <template x-for="notification in filteredNotifications" :key="notification.id">
                                    <div :class="notification.read ? 'bg-white' : 'bg-blue-50'" class="border-b border-gray-100 p-4 hover:bg-gray-50 cursor-pointer" @click="markAsRead(notification.id)">
                                        <div class="flex items-start space-x-3">
                                            <div :class="notification.type" class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i :class="getTypeIcon(notification.type)"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between">
                                                    <h4 class="font-semibold text-gray-800 text-sm" x-text="notification.title"></h4>
                                                    <span class="text-xs text-gray-500" x-text="formatTime(notification.timestamp)"></span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                            </div>
                                            <div x-show="!notification.read" class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <button class="px-3 py-2 rounded-lg hover:bg-blue-800 transition">
                        <i class="fas fa-search" style="color: #eaf512;"></i>
                    </button>
                </div>

                <!-- User menu -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block text-right">
                        <div class="font-semibold text-sm">{{ Auth::user()->name ?? 'Usuario' }}</div>
                        <div class="text-xs text-blue-100">{{ Auth::user()->email ?? 'usuario@sistema.com' }}</div>
                    </div>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-800">
                            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-sm"></i>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-xl z-50 py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <div class="font-semibold text-sm">{{ Auth::user()->name ?? 'Usuario' }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'usuario@sistema.com' }}</div>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-blue-50"><i class="fas fa-user mr-3 text-blue-600 w-4 text-center"></i> Mi Perfil</a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-blue-50"><i class="fas fa-cog mr-3 text-blue-600 w-4 text-center"></i> Configuración</a>
                            <a href="{{ route('tareas.index') }}" class="block px-4 py-2 text-sm hover:bg-blue-50"><i class="fas fa-book mr-3 text-blue-600 w-4 text-center"></i> Tareas</a>
                            <hr class="my-1 border-gray-200">
                            <button onclick="confirmLogout()" class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-600">
                                <i class="fas fa-sign-out-alt mr-3 w-4 text-center"></i> Cerrar Sesión
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- BARRA DE PESTAÑAS MEJORADA -->
    <div class="tab-navigation-bar" id="tabNavigationBar">
        <div class="close-all-tabs-container">
            <button class="close-all-tabs-btn" onclick="if(window.tabManager) tabManager.closeAllTabs()">
                <i class="fas fa-times-circle"></i> Cerrar
            </button>
        </div>
        
        <div class="tabs-container-nav" id="tabsNavContainer">
            <!-- Las pestañas se generarán dinámicamente -->
        </div>
        
        <button class="new-tab-btn bg-green-600 hover:bg-green-700 text-white rounded-full w-7 h-7 flex items-center justify-center ml-2 flex-shrink-0" 
                onclick="if(window.tabManager) tabManager.createNewTab('Inicio', 'home', 'fa-home', '{{ route('home') }}')"
                title="Nueva pestaña (Ctrl+T)">
            <i class="fas fa-plus text-xs"></i>
        </button>
    </div>

    <!-- ==================== MENÚ HAMBURGUESA MÓVIL ==================== -->
    <div class="mobile-menu-sidebar" id="mobileMenuSidebar">
        <div class="mobile-menu-header">
            <h3><i class="fas fa-star mr-2"></i> MejoraSoft</h3>
            <button onclick="toggleMobileMenu()" class="text-white p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mobile-menu-items">
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('bi')">
                <i class="fas fa-chart-line"></i>
                <span>Business Intelligence</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('administracion')">
                <i class="fas fa-money-bill-wave"></i>
                <span>Administración</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('contabilidad')">
                <i class="fas fa-calculator"></i>
                <span>Contabilidad</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('proyectos')">
                <i class="fas fa-project-diagram"></i>
                <span>Proyectos</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('rrhh')">
                <i class="fas fa-users"></i>
                <span>Recursos Humanos</span>
            </div>
            <!-- NUEVOS ITEMS EN MÓVIL -->
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('inventarios')">
                <i class="fas fa-boxes"></i>
                <span>Inventarios</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('compras')">
                <i class="fas fa-shopping-cart"></i>
                <span>Compras</span>
            </div>
            <div class="mobile-menu-item" onclick="toggleQuickSidebar()">
                <i class="fas fa-star"></i>
                <span>Accesos Rápidos</span>
            </div>
        </div>
    </div>

    <!-- Overlay para móvil -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="toggleMobileMenu()"></div>

    <!-- ==================== SIDEBAR DE BI ==================== -->
    <div id="sidebar-bi" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-chart-line"></i>
                <h2>Business Intelligence</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Dashboard -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-dashboard')">
                    <span><i class="fas fa-tachometer-alt"></i> Dashboard</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="bi-dashboard" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Directivo', 'bi', '{{ route('bi.dashboard') }}', 'fa-user-tie')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-tie"></i>
                            <span>Directivo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Directivo', 'bi', 'fa-user-tie', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Finanzas', 'bi', '{{ route('bi.finanzas') }}', 'fa-chart-pie')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-pie"></i>
                            <span>Finanzas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Finanzas', 'bi', 'fa-chart-pie', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Licitaciones', 'bi', '{{ route('bi.licitaciones') }}', 'fa-gavel')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-gavel"></i>
                            <span>Licitaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Licitaciones', 'bi', 'fa-gavel', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Ventas -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-ventas')">
                    <span><i class="fas fa-chart-bar"></i> Ventas</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="bi-ventas" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Pipeline de Proyectos', 'bi', '{{ route('ventas.papeline') }}', 'fa-filter')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-filter"></i>
                            <span>Pipeline de Proyectos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pipeline de Proyectos', 'bi', 'fa-filter', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Propuestas y Cotizaciones', 'bi', '{{ route('ventas.propuestas') }}', 'fa-file-contract')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-contract"></i>
                            <span>Propuestas y Cotizaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Propuestas y Cotizaciones', 'bi', 'fa-file-contract', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Ventas', 'bi', '{{ route('ventas.analisis') }}', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Análisis de Ventas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Ventas', 'bi', 'fa-chart-line', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Facturación -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-facturacion')">
                    <span><i class="fas fa-file-invoice-dollar"></i> Facturación</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="bi-facturacion" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Seguimiento de Facturación', 'bi', '{{ route('facturacion.seguimiento') }}', 'fa-search-dollar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-search-dollar"></i>
                            <span>Seguimiento de Facturación</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Seguimiento de Facturación', 'bi', 'fa-search-dollar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Pendiente de Facturación', 'bi', '{{ route('facturacion.pendiente') }}', 'fa-clock')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clock"></i>
                            <span>Pendiente de Facturación</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pendiente de Facturación', 'bi', 'fa-clock', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Facturado', 'bi', '{{ route('facturacion.facturacion') }}', 'fa-check-circle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-check-circle"></i>
                            <span>Facturado</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturado', 'bi', 'fa-check-circle', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Cobranza -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-cobranza')">
                    <span><i class="fas fa-hand-holding-usd"></i> Cobranza</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="bi-cobranza" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Proyecciones de Flujo', 'bi', '{{ route('cobranza.proyecciones') }}', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Proyecciones de Flujo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Proyecciones de Flujo', 'bi', 'fa-chart-line', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Historial de Pagos', 'bi', '{{ route('cobranza.historial') }}', 'fa-history')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-history"></i>
                            <span>Historial de Pagos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Historial de Pagos', 'bi', 'fa-history', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE ADMINISTRACIÓN ==================== -->
    <div id="sidebar-administracion" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-money-bill-wave"></i>
                <h2>Administración</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Facturación -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-facturacion')">
                    <span><i class="fas fa-file-invoice-dollar"></i> Facturación</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-facturacion" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Facturación', 'administracion', '{{ route('admin.facturacion') }}', 'fa-file-invoice')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-invoice"></i>
                            <span>Facturación</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturación', 'administracion', 'fa-file-invoice', this)"></i>
                    </div>

                    <div class="sidebar-submenu-item" onclick="navigateTo('CFDI', 'administracion', '{{ route('admin.cfdi') }}', 'fa-solid fa-file-contract')">
                        <div class="flex items-center flex-1">
                            <i class="fa-solid fa-file-contract"></i>
                            <span>CFDI</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('CFDI', 'administracion', 'fa-solid fa-file-contract', this)"></i>
                    </div>

                    <div class="sidebar-submenu-item" onclick="navigateTo('Notas de Crédito', 'administracion', '{{ route('admin.nota') }}', 'fa-undo-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-undo-alt"></i>
                            <span>Notas de Crédito</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Notas de Crédito', 'administracion', 'fa-undo-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Notas de Ventas', 'administracion', '#', 'fa-sticky-note')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-sticky-note"></i>
                            <span>Notas de Ventas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Notas de Ventas', 'administracion', 'fa-sticky-note', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Contrarecibos', 'administracion', '#', 'fa-receipt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-receipt"></i>
                            <span>Contrarecibos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Contrarecibos', 'administracion', 'fa-receipt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Factoraje', 'administracion', '#', 'fa-handshake')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-handshake"></i>
                            <span>Factoraje</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Factoraje', 'administracion', 'fa-handshake', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora', 'administracion', '#', 'fa-book')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book"></i>
                            <span>Bitácora</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora', 'administracion', 'fa-book', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Comisiones', 'administracion', '#', 'fa-percentage')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-percentage"></i>
                            <span>Comisiones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Comisiones', 'administracion', 'fa-percentage', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Cuentas por Cobrar -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cxc')">
                    <span><i class="fas fa-hand-holding-usd"></i> Cuentas por Cobrar</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-cxc" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Antigüedad de Saldos', 'administracion', '{{ route('admin.saldos') }}', 'fa-table')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-table"></i>
                            <span>Vista con tabla de antigüedad</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Antigüedad de Saldos', 'administracion', 'fa-table', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Cuentas por Pagar -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cxp')">
                    <span><i class="fas fa-credit-card"></i> Cuentas por Pagar</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-cxp" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Facturación de Proveedores', 'administracion', '{{ route('admin.pagos') }}', 'fa-truck')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-truck"></i>
                            <span>Facturación de Proveedores</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturación de Proveedores', 'administracion', 'fa-truck', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Tesorería -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-tesoreria')">
                    <span><i class="fas fa-university"></i> Tesorería</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-tesoreria" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Depósitos', 'administracion', '#', 'fa-money-check-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-check-alt"></i>
                            <span>Depósitos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Depósitos', 'administracion', 'fa-money-check-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Transacciones', 'administracion', '#', 'fa-exchange-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transacciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Transacciones', 'administracion', 'fa-exchange-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estados de Cuenta Bancarios', 'administracion', '#', 'fa-file-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-alt"></i>
                            <span>Estados de Cuenta Bancarios</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estados de Cuenta Bancarios', 'administracion', 'fa-file-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Conciliación Bancaria', 'administracion', '#', 'fa-balance-scale')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-balance-scale"></i>
                            <span>Conciliación Bancaria</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Conciliación Bancaria', 'administracion', 'fa-balance-scale', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Flujo de Dinero', 'administracion', '#', 'fa-wave-square')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-wave-square"></i>
                            <span>Flujo de Dinero</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Flujo de Dinero', 'administracion', 'fa-wave-square', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Flujo Mensual', 'administracion', '#', 'fa-calendar-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Flujo Mensual</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Flujo Mensual', 'administracion', 'fa-calendar-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Programación de Pagos', 'administracion', '#', 'fa-calendar-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-check"></i>
                            <span>Programación de Pagos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Programación de Pagos', 'administracion', 'fa-calendar-check', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Presupuestos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-presupuestos')">
                    <span><i class="fas fa-chart-pie"></i> Presupuestos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-presupuestos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Presupuestos Generales', 'administracion', '#', 'fa-chart-pie')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-pie"></i>
                            <span>Presupuestos Generales</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuestos Generales', 'administracion', 'fa-chart-pie', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto Mensual', 'administracion', '#', 'fa-calendar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar"></i>
                            <span>Presupuesto Mensual</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto Mensual', 'administracion', 'fa-calendar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Reasignación de Gastos', 'administracion', '#', 'fa-random')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-random"></i>
                            <span>Reasignación de Gastos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reasignación de Gastos', 'administracion', 'fa-random', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Gastos Fijos', 'administracion', '#', 'fa-home')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-home"></i>
                            <span>Gastos Fijos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Gastos Fijos', 'administracion', 'fa-home', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Operaciones -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-operaciones')">
                    <span><i class="fas fa-exchange-alt"></i> Operaciones</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-operaciones" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Prepago', 'administracion', '#', 'fa-forward')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-forward"></i>
                            <span>Prepago</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Prepago', 'administracion', 'fa-forward', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Anticipos', 'administracion', '#', 'fa-hand-holding-usd')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Anticipos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Anticipos', 'administracion', 'fa-hand-holding-usd', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Crédito', 'administracion', '#', 'fa-credit-card')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-credit-card"></i>
                            <span>Crédito</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Crédito', 'administracion', 'fa-credit-card', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Cuentas Avanzadas -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cuentas-avanzadas')">
                    <span><i class="fas fa-cogs"></i> Cuentas Avanzadas</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="admin-cuentas-avanzadas" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas Avanzadas', 'administracion', '#', 'fa-cogs')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-cogs"></i>
                            <span>Cuentas Avanzadas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas Avanzadas', 'administracion', 'fa-cogs', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE CONTABILIDAD ==================== -->
    <div id="sidebar-contabilidad" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-calculator"></i>
                <h2>Contabilidad</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Estados Financieros -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-estados')">
                    <span><i class="fas fa-chart-line"></i> Estados Financieros</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-estados" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Resultados', 'contabilidad', '#', 'fa-chart-pie')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-pie"></i>
                            <span>Estado de Resultados</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Resultados', 'contabilidad', 'fa-chart-pie', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Balance General', 'contabilidad', '#', 'fa-balance-scale')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-balance-scale"></i>
                            <span>Balance General</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Balance General', 'contabilidad', 'fa-balance-scale', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Balance de Comprobación', 'contabilidad', '#', 'fa-check-double')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-check-double"></i>
                            <span>Balance de Comprobación</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Balance de Comprobación', 'contabilidad', 'fa-check-double', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Flujo de Efectivo', 'contabilidad', '#', 'fa-money-bill-wave')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Estado de Flujo de Efectivo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Flujo de Efectivo', 'contabilidad', 'fa-money-bill-wave', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Cambios en el Capital', 'contabilidad', '#', 'fa-exchange-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Estado de Cambios en el Capital</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Cambios en el Capital', 'contabilidad', 'fa-exchange-alt', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Registro Contable -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-registro')">
                    <span><i class="fas fa-book"></i> Registro Contable</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-registro" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Pólizas Contables', 'contabilidad', '#', 'fa-file-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-alt"></i>
                            <span>Pólizas Contables</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pólizas Contables', 'contabilidad', 'fa-file-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Diario General', 'contabilidad', '#', 'fa-book')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book"></i>
                            <span>Diario General</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Diario General', 'contabilidad', 'fa-book', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Libro Mayor', 'contabilidad', '#', 'fa-book-open')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book-open"></i>
                            <span>Libro Mayor</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Libro Mayor', 'contabilidad', 'fa-book-open', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Auxiliares Contables', 'contabilidad', '#', 'fa-columns')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-columns"></i>
                            <span>Auxiliares Contables</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Auxiliares Contables', 'contabilidad', 'fa-columns', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Ajustes y Reclasificaciones', 'contabilidad', '#', 'fa-adjust')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-adjust"></i>
                            <span>Ajustes y Reclasificaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Ajustes y Reclasificaciones', 'contabilidad', 'fa-adjust', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Catálogo Contable -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-catalogo')">
                    <span><i class="fas fa-list-alt"></i> Catálogo Contable</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-catalogo" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas Contables', 'contabilidad', '#', 'fa-list')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-list"></i>
                            <span>Cuentas Contables</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas Contables', 'contabilidad', 'fa-list', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Auxiliar de Cuentas', 'contabilidad', '#', 'fa-indent')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-indent"></i>
                            <span>Auxiliar de Cuentas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Auxiliar de Cuentas', 'contabilidad', 'fa-indent', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Centros de Costos', 'contabilidad', '#', 'fa-sitemap')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-sitemap"></i>
                            <span>Centros de Costos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Centros de Costos', 'contabilidad', 'fa-sitemap', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Configuración Contable', 'contabilidad', '#', 'fa-cogs')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-cogs"></i>
                            <span>Configuración Contable</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Configuración Contable', 'contabilidad', 'fa-cogs', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Contabilidad por Proyecto -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-proyecto')">
                    <span><i class="fas fa-project-diagram"></i> Contabilidad por Proyecto</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-proyecto" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Costos por Obra', 'contabilidad', '#', 'fa-hard-hat')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-hard-hat"></i>
                            <span>Costos por Obra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos por Obra', 'contabilidad', 'fa-hard-hat', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Gastos Indirectos de Obra', 'contabilidad', '#', 'fa-tools')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tools"></i>
                            <span>Gastos Indirectos de Obra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Gastos Indirectos de Obra', 'contabilidad', 'fa-tools', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Gastos por Proyecto', 'contabilidad', '#', 'fa-project-diagram')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-project-diagram"></i>
                            <span>Asignación de Gastos por Proyecto</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Gastos por Proyecto', 'contabilidad', 'fa-project-diagram', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Rentabilidad por Obra', 'contabilidad', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Rentabilidad por Obra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Rentabilidad por Obra', 'contabilidad', 'fa-chart-line', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cierre de Proyectos', 'contabilidad', '#', 'fa-lock')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-lock"></i>
                            <span>Cierre de Proyectos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cierre de Proyectos', 'contabilidad', 'fa-lock', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Fiscal -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-fiscal')">
                    <span><i class="fas fa-file-contract"></i> Fiscal</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-fiscal" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('DIOT', 'contabilidad', '#', 'fa-file-export')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-export"></i>
                            <span>DIOT</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('DIOT', 'contabilidad', 'fa-file-export', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Declaraciones Mensuales/Anuales', 'contabilidad', '#', 'fa-calendar-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Declaraciones Mensuales/Anuales</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Declaraciones Mensuales/Anuales', 'contabilidad', 'fa-calendar-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Retenciones (ISR, IVA)', 'contabilidad', '#', 'fa-percentage')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-percentage"></i>
                            <span>Retenciones (ISR, IVA)</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Retenciones (ISR, IVA)', 'contabilidad', 'fa-percentage', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Complemento de Pagos', 'contabilidad', '#', 'fa-money-check-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-check-alt"></i>
                            <span>Complemento de Pagos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Complemento de Pagos', 'contabilidad', 'fa-money-check-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Contabilidad Electrónica (XML)', 'contabilidad', '#', 'fa-code')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-code"></i>
                            <span>Contabilidad Electrónica (XML)</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Contabilidad Electrónica (XML)', 'contabilidad', 'fa-code', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Análisis y Reportes -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-analisis')">
                    <span><i class="fas fa-chart-bar"></i> Análisis y Reportes</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-analisis" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Razones Financieras', 'contabilidad', '#', 'fa-chart-bar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-bar"></i>
                            <span>Razones Financieras</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Razones Financieras', 'contabilidad', 'fa-chart-bar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Comparativos Periódicos', 'contabilidad', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Comparativos Periódicos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Comparativos Periódicos', 'contabilidad', 'fa-chart-line', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Variaciones', 'contabilidad', '#', 'fa-chart-area')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-area"></i>
                            <span>Análisis de Variaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Variaciones', 'contabilidad', 'fa-chart-area', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Reportes Personalizados', 'contabilidad', '#', 'fa-edit')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-edit"></i>
                            <span>Reportes Personalizados</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reportes Personalizados', 'contabilidad', 'fa-edit', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Cierre Contable -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-cierre')">
                    <span><i class="fas fa-lock"></i> Cierre Contable</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="contabilidad-cierre" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cierre Mensual', 'contabilidad', '#', 'fa-calendar-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-check"></i>
                            <span>Cierre Mensual</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cierre Mensual', 'contabilidad', 'fa-calendar-check', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cierre Anual', 'contabilidad', '#', 'fa-calendar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar"></i>
                            <span>Cierre Anual</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cierre Anual', 'contabilidad', 'fa-calendar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Depreciaciones', 'contabilidad', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Depreciaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Depreciaciones', 'contabilidad', 'fa-chart-line', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Amortizaciones', 'contabilidad', '#', 'fa-calculator')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calculator"></i>
                            <span>Amortizaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Amortizaciones', 'contabilidad', 'fa-calculator', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE PROYECTOS ==================== -->
    <div id="sidebar-proyectos" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-project-diagram"></i>
                <h2>Proyectos</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Gestión de Proyectos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-gestion')">
                    <span><i class="fas fa-tasks"></i> Gestión de Proyectos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-gestion" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cartera de Proyectos', 'proyectos', '#', 'fa-briefcase')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-briefcase"></i>
                            <span>Cartera de Proyectos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cartera de Proyectos', 'proyectos', 'fa-briefcase', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Alta de Proyecto', 'proyectos', '#', 'fa-plus-circle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-plus-circle"></i>
                            <span>Alta de Proyecto</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Alta de Proyecto', 'proyectos', 'fa-plus-circle', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cronograma y Hitos', 'proyectos', '#', 'fa-calendar-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Cronograma y Hitos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cronograma y Hitos', 'proyectos', 'fa-calendar-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Obra', 'proyectos', '#', 'fa-book')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book"></i>
                            <span>Bitácora de Obra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Obra', 'proyectos', 'fa-book', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estatus y Dashboard', 'proyectos', '#', 'fa-tachometer-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Estatus y Dashboard</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estatus y Dashboard', 'proyectos', 'fa-tachometer-alt', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Licitaciones -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-licitaciones')">
                    <span><i class="fas fa-gavel"></i> Licitaciones</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-licitaciones" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Licitaciones Activas', 'proyectos', '#', 'fa-gavel')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-gavel"></i>
                            <span>Licitaciones Activas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Licitaciones Activas', 'proyectos', 'fa-gavel', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Propuestas y Cotizaciones', 'proyectos', '#', 'fa-file-contract')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-contract"></i>
                            <span>Propuestas y Cotizaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Propuestas y Cotizaciones', 'proyectos', 'fa-file-contract', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Precios Unitarios', 'proyectos', '#', 'fa-calculator')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calculator"></i>
                            <span>Análisis de Precios Unitarios</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Precios Unitarios', 'proyectos', 'fa-calculator', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Histórico de Licitaciones', 'proyectos', '#', 'fa-history')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-history"></i>
                            <span>Histórico</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Histórico de Licitaciones', 'proyectos', 'fa-history', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Presupuestos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-presupuestos')">
                    <span><i class="fas fa-file-invoice-dollar"></i> Presupuestos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-presupuestos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto por Proyecto', 'proyectos', '#', 'fa-file-invoice-dollar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Presupuesto por Proyecto</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto por Proyecto', 'proyectos', 'fa-file-invoice-dollar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto por Partidas', 'proyectos', '#', 'fa-list-ol')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-list-ol"></i>
                            <span>Presupuesto por Partidas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto por Partidas', 'proyectos', 'fa-list-ol', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Control de Cambios', 'proyectos', '#', 'fa-exchange-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Control de Cambios</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Cambios', 'proyectos', 'fa-exchange-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Comparativo Presupuesto vs Real', 'proyectos', '#', 'fa-balance-scale')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-balance-scale"></i>
                            <span>Comparativo Presupuesto vs Real</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Comparativo Presupuesto vs Real', 'proyectos', 'fa-balance-scale', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Costos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-costos')">
                    <span><i class="fas fa-money-bill-wave"></i> Costos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-costos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Costos Directos', 'proyectos', '#', 'fa-money-bill-wave')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Costos Directos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos Directos', 'proyectos', 'fa-money-bill-wave', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Costos Indirectos', 'proyectos', '#', 'fa-tools')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tools"></i>
                            <span>Costos Indirectos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos Indirectos', 'proyectos', 'fa-tools', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Rentabilidad', 'proyectos', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Análisis de Rentabilidad</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Rentabilidad', 'proyectos', 'fa-chart-line', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Avances de Obra -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-avances')">
                    <span><i class="fas fa-hard-hat"></i> Avances de Obra</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-avances" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Avance Físico y Financiero', 'proyectos', '#', 'fa-chart-bar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-bar"></i>
                            <span>Avance Físico y Financiero</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Avance Físico y Financiero', 'proyectos', 'fa-chart-bar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Estimaciones', 'proyectos', '#', 'fa-calculator')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calculator"></i>
                            <span>Estimaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estimaciones', 'proyectos', 'fa-calculator', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Reporte Fotográfico', 'proyectos', '#', 'fa-camera')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-camera"></i>
                            <span>Reporte Fotográfico</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reporte Fotográfico', 'proyectos', 'fa-camera', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Personal -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-personal')">
                    <span><i class="fas fa-users"></i> Personal</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-personal" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asignación a Proyectos', 'proyectos', '#', 'fa-user-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-check"></i>
                            <span>Asignación a Proyectos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación a Proyectos', 'proyectos', 'fa-user-check', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asistencia y Cuadrillas', 'proyectos', '#', 'fa-users')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-users"></i>
                            <span>Asistencia y Cuadrillas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asistencia y Cuadrillas', 'proyectos', 'fa-users', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Rendimientos', 'proyectos', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Rendimientos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Rendimientos', 'proyectos', 'fa-chart-line', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Maquinaria y Equipo -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-maquinaria')">
                    <span><i class="fas fa-tractor"></i> Maquinaria y Equipo</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-maquinaria" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Equipo', 'proyectos', '#', 'fa-tractor')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tractor"></i>
                            <span>Asignación de Equipo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Equipo', 'proyectos', 'fa-tractor', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Control de Maquinaria', 'proyectos', '#', 'fa-cogs')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-cogs"></i>
                            <span>Control de Maquinaria</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Maquinaria', 'proyectos', 'fa-cogs', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Mantenimiento de Equipo', 'proyectos', '#', 'fa-tools')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tools"></i>
                            <span>Mantenimiento de Equipo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Mantenimiento de Equipo', 'proyectos', 'fa-tools', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Uso', 'proyectos', '#', 'fa-book')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book"></i>
                            <span>Bitácora de Uso</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'proyectos', 'fa-book', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Costos de Operación', 'proyectos', '#', 'fa-money-bill-wave')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Costos de Operación</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos de Operación', 'proyectos', 'fa-money-bill-wave', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Control de Riesgos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-riesgos')">
                    <span><i class="fas fa-exclamation-triangle"></i> Control de Riesgos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-riesgos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Desviaciones (Costo y Tiempo)', 'proyectos', '#', 'fa-exclamation-triangle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Desviaciones (Costo y Tiempo)</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Desviaciones (Costo y Tiempo)', 'proyectos', 'fa-exclamation-triangle', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Alertas e Incidencias', 'proyectos', '#', 'fa-bell')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-bell"></i>
                            <span>Alertas e Incidencias</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Alertas e Incidencias', 'proyectos', 'fa-bell', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Control de Calidad', 'proyectos', '#', 'fa-clipboard-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Control de Calidad</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Calidad', 'proyectos', 'fa-clipboard-check', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Documentación -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-documentacion')">
                    <span><i class="fas fa-folder"></i> Documentación</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="proyectos-documentacion" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Contratos y Planos', 'proyectos', '#', 'fa-file-contract')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-contract"></i>
                            <span>Contratos y Planos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Contratos y Planos', 'proyectos', 'fa-file-contract', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Permisos', 'proyectos', '#', 'fa-file-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-alt"></i>
                            <span>Permisos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Permisos', 'proyectos', 'fa-file-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Evidencias (Fotos, Actas)', 'proyectos', '#', 'fa-camera')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-camera"></i>
                            <span>Evidencias (Fotos, Actas)</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Evidencias (Fotos, Actas)', 'proyectos', 'fa-camera', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE RECURSOS HUMANOS ==================== -->
    <div id="sidebar-rrhh" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-users"></i>
                <h2>Recursos Humanos</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Gestión de Personal -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-personal')">
                    <span><i class="fas fa-user-tie"></i> Gestión de Personal</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-personal" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Plantilla de Empleados', 'rrhh', '#', 'fa-users')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-users"></i>
                            <span>Plantilla de Empleados</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Plantilla de Empleados', 'rrhh', 'fa-users', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Alta y Baja de Personal', 'rrhh', '#', 'fa-user-plus')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-plus"></i>
                            <span>Alta y Baja de Personal</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Alta y Baja de Personal', 'rrhh', 'fa-user-plus', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Expediente Digital', 'rrhh', '#', 'fa-folder')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-folder"></i>
                            <span>Expediente Digital</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Expediente Digital', 'rrhh', 'fa-folder', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Semáforo de Documentos', 'rrhh', '#', 'fa-traffic-light')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-traffic-light"></i>
                            <span>Semáforo de Documentos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Semáforo de Documentos', 'rrhh', 'fa-traffic-light', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Historial Laboral', 'rrhh', '#', 'fa-history')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-history"></i>
                            <span>Historial Laboral</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Historial Laboral', 'rrhh', 'fa-history', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Asistencia y Control -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-asistencia')">
                    <span><i class="fas fa-user-clock"></i> Asistencia y Control</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-asistencia" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asistencia', 'rrhh', '#', 'fa-user-clock')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-clock"></i>
                            <span>Asistencia</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asistencia', 'rrhh', 'fa-user-clock', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Lista de Asistencia', 'rrhh', '#', 'fa-list')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-list"></i>
                            <span>Lista de Asistencia</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Lista de Asistencia', 'rrhh', 'fa-list', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Registro de Incidencias', 'rrhh', '#', 'fa-exclamation-circle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Registro de Incidencias</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Registro de Incidencias', 'rrhh', 'fa-exclamation-circle', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Justificantes y Permisos', 'rrhh', '#', 'fa-file-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-alt"></i>
                            <span>Justificantes y Permisos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Justificantes y Permisos', 'rrhh', 'fa-file-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Control de Horarios', 'rrhh', '#', 'fa-clock')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clock"></i>
                            <span>Control de Horarios</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Horarios', 'rrhh', 'fa-clock', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Nómina -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-nomina')">
                    <span><i class="fas fa-money-check-alt"></i> Nómina</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-nomina" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Cálculo de Nómina', 'rrhh', '#', 'fa-calculator')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calculator"></i>
                            <span>Cálculo de Nómina</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cálculo de Nómina', 'rrhh', 'fa-calculator', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Pagos de Nómina', 'rrhh', '#', 'fa-money-check-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-check-alt"></i>
                            <span>Pagos de Nómina</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pagos de Nómina', 'rrhh', 'fa-money-check-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Tabla de Sueldos', 'rrhh', '#', 'fa-table')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-table"></i>
                            <span>Tabla de Sueldos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Tabla de Sueldos', 'rrhh', 'fa-table', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Recibos de Nómina (Timbrado)', 'rrhh', '#', 'fa-file-invoice-dollar')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Recibos de Nómina (Timbrado)</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Recibos de Nómina (Timbrado)', 'rrhh', 'fa-file-invoice-dollar', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Histórico de Pagos', 'rrhh', '#', 'fa-history')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-history"></i>
                            <span>Histórico de Pagos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Histórico de Pagos', 'rrhh', 'fa-history', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Prestaciones y Descuentos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-prestaciones')">
                    <span><i class="fas fa-hand-holding-usd"></i> Prestaciones y Descuentos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-prestaciones" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Préstamos', 'rrhh', '#', 'fa-hand-holding-usd')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Préstamos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Préstamos', 'rrhh', 'fa-hand-holding-usd', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Descuentos', 'rrhh', '#', 'fa-percentage')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-percentage"></i>
                            <span>Descuentos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Descuentos', 'rrhh', 'fa-percentage', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Vacaciones', 'rrhh', '#', 'fa-umbrella-beach')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-umbrella-beach"></i>
                            <span>Vacaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Vacaciones', 'rrhh', 'fa-umbrella-beach', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Vacaciones', 'rrhh', '#', 'fa-calendar-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-calendar-check"></i>
                            <span>Asignación de Vacaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Vacaciones', 'rrhh', 'fa-calendar-check', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Aguinaldo y PTU', 'rrhh', '#', 'fa-gift')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-gift"></i>
                            <span>Aguinaldo y PTU</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Aguinaldo y PTU', 'rrhh', 'fa-gift', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Finiquitos y Liquidaciones', 'rrhh', '#', 'fa-file-contract')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-contract"></i>
                            <span>Finiquitos y Liquidaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Finiquitos y Liquidaciones', 'rrhh', 'fa-file-contract', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Unidades y Flotilla -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-unidades')">
                    <span><i class="fas fa-car"></i> Unidades y Flotilla</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-unidades" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Semáforo de Documentos de Unidades', 'rrhh', '#', 'fa-traffic-light')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-traffic-light"></i>
                            <span>Semáforo de Documentos de Unidades</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Semáforo de Documentos de Unidades', 'rrhh', 'fa-traffic-light', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Flotilla', 'rrhh', '#', 'fa-car')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-car"></i>
                            <span>Asignación de Flotilla</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Flotilla', 'rrhh', 'fa-car', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Control de Vehículos', 'rrhh', '#', 'fa-tachometer-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Control de Vehículos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Vehículos', 'rrhh', 'fa-tachometer-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Uso', 'rrhh', '#', 'fa-book')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-book"></i>
                            <span>Bitácora de Uso</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'rrhh', 'fa-book', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Verificaciones y Seguros', 'rrhh', '#', 'fa-shield-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-shield-alt"></i>
                            <span>Verificaciones y Seguros</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Verificaciones y Seguros', 'rrhh', 'fa-shield-alt', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Catálogos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-catalogos')">
                    <span><i class="fas fa-list"></i> Catálogos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-catalogos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('IMSS', 'rrhh', '#', 'fa-hospital')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-hospital"></i>
                            <span>IMSS</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('IMSS', 'rrhh', 'fa-hospital', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Deducciones', 'rrhh', '#', 'fa-minus-circle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-minus-circle"></i>
                            <span>Deducciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Deducciones', 'rrhh', 'fa-minus-circle', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Percepciones', 'rrhh', '#', 'fa-plus-circle')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-plus-circle"></i>
                            <span>Percepciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Percepciones', 'rrhh', 'fa-plus-circle', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Roles y Puestos', 'rrhh', '#', 'fa-user-tag')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-tag"></i>
                            <span>Roles y Puestos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Roles y Puestos', 'rrhh', 'fa-user-tag', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Áreas y Departamentos', 'rrhh', '#', 'fa-sitemap')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-sitemap"></i>
                            <span>Áreas y Departamentos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Áreas y Departamentos', 'rrhh', 'fa-sitemap', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Turnos', 'rrhh', '#', 'fa-clock')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clock"></i>
                            <span>Turnos</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Turnos', 'rrhh', 'fa-clock', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Evaluación y Desarrollo -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-evaluacion')">
                    <span><i class="fas fa-chart-line"></i> Evaluación y Desarrollo</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-evaluacion" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Evaluación de Desempeño', 'rrhh', '#', 'fa-chart-line')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-chart-line"></i>
                            <span>Evaluación de Desempeño</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Evaluación de Desempeño', 'rrhh', 'fa-chart-line', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Capacitaciones', 'rrhh', '#', 'fa-graduation-cap')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Capacitaciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Capacitaciones', 'rrhh', 'fa-graduation-cap', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Competencias', 'rrhh', '#', 'fa-award')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-award"></i>
                            <span>Competencias</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Competencias', 'rrhh', 'fa-award', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Plan de Carrera', 'rrhh', '#', 'fa-briefcase')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-briefcase"></i>
                            <span>Plan de Carrera</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Plan de Carrera', 'rrhh', 'fa-briefcase', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Reportes -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-reportes')">
                    <span><i class="fas fa-chart-bar"></i> Reportes</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="rrhh-reportes" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Reportes IMSS', 'rrhh', '#', 'fa-file-export')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-export"></i>
                            <span>Reportes IMSS</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reportes IMSS', 'rrhh', 'fa-file-export', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Reportes SAT', 'rrhh', '#', 'fa-file-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-file-alt"></i>
                            <span>Reportes SAT</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reportes SAT', 'rrhh', 'fa-file-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Rotación de Personal', 'rrhh', '#', 'fa-exchange-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Rotación de Personal</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Rotación de Personal', 'rrhh', 'fa-exchange-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Ausentismo', 'rrhh', '#', 'fa-user-times')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-user-times"></i>
                            <span>Ausentismo</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Ausentismo', 'rrhh', 'fa-user-times', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Costos de Nómina por Proyecto', 'rrhh', '#', 'fa-money-bill-wave')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Costos de Nómina por Proyecto</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos de Nómina por Proyecto', 'rrhh', 'fa-money-bill-wave', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE INVENTARIOS ==================== -->
    <div id="sidebar-inventarios" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-boxes"></i>
                <h2>Inventarios</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Catálogos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-catalogos')">
                    <span><i class="fas fa-warehouse"></i> Catálogos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="inventarios-catalogos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Almacenes', 'inventarios', '#', 'fa-warehouse')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-warehouse"></i>
                            <span>Catálogo de Almacenes</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Almacenes', 'inventarios', 'fa-warehouse', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Materiales', 'inventarios', '#', 'fa-box')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-box"></i>
                            <span>Catálogo de Materiales</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Materiales', 'inventarios', 'fa-box', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Existencias -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-existencias')">
                    <span><i class="fas fa-clipboard-list"></i> Existencias</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="inventarios-existencias" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Existencias por Almacén', 'inventarios', '#', 'fa-clipboard-list')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Existencias por Almacén</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Existencias por Almacén', 'inventarios', 'fa-clipboard-list', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Kardex', 'inventarios', '#', 'fa-stream')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-stream"></i>
                            <span>Kardex</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Kardex', 'inventarios', 'fa-stream', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Movimientos -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-movimientos')">
                    <span><i class="fas fa-exchange-alt"></i> Movimientos</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="inventarios-movimientos" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Entradas y Salidas', 'inventarios', '#', 'fa-exchange-alt')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Entradas y Salidas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Entradas y Salidas', 'inventarios', 'fa-exchange-alt', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Traspasos entre Almacenes', 'inventarios', '#', 'fa-truck-moving')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-truck-moving"></i>
                            <span>Traspasos entre Almacenes</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Traspasos entre Almacenes', 'inventarios', 'fa-truck-moving', this)"></i>
                    </div>
                    <div class="sidebar-submenu-item" onclick="navigateTo('Ajustes de Inventario', 'inventarios', '#', 'fa-adjust')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-adjust"></i>
                            <span>Ajustes de Inventario</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Ajustes de Inventario', 'inventarios', 'fa-adjust', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SIDEBAR DE COMPRAS ==================== -->
    <div id="sidebar-compras" class="section-sidebar">
        <div class="section-sidebar-header">
            <div class="section-sidebar-title">
                <i class="fas fa-shopping-cart"></i>
                <h2>Compras</h2>
            </div>
            <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="section-sidebar-content">
            <!-- Requisiciones -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-requisiciones')">
                    <span><i class="fas fa-clipboard-check"></i> Requisiciones</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="compras-requisiciones" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Requisiciones', 'compras', '#', 'fa-clipboard-check')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Requisiciones</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Requisiciones', 'compras', 'fa-clipboard-check', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Órdenes de Compra -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-ordenes')">
                    <span><i class="fas fa-shopping-cart"></i> Órdenes de Compra</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="compras-ordenes" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Órdenes de Compra', 'compras', '#', 'fa-shopping-cart')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Órdenes de Compra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Órdenes de Compra', 'compras', 'fa-shopping-cart', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Subcontratistas -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-subcontratistas')">
                    <span><i class="fas fa-handshake"></i> Subcontratistas</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="compras-subcontratistas" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Gestión de Subcontratistas', 'compras', '#', 'fa-handshake')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-handshake"></i>
                            <span>Gestión de Subcontratistas</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Gestión de Subcontratistas', 'compras', 'fa-handshake', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Almacén por Obra -->
            <div class="sidebar-menu-group">
                <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-almacen')">
                    <span><i class="fas fa-warehouse"></i> Almacén por Obra</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div id="compras-almacen" class="sidebar-submenu">
                    <div class="sidebar-submenu-item" onclick="navigateTo('Almacén por Obra', 'compras', '#', 'fa-warehouse')">
                        <div class="flex items-center flex-1">
                            <i class="fas fa-warehouse"></i>
                            <span>Almacén por Obra</span>
                        </div>
                        <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Almacén por Obra', 'compras', 'fa-warehouse', this)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== BARRA LATERAL DE FAVORITOS ==================== -->
    <div class="quick-sidebar" id="quick-sidebar">
        <div class="bg-construction-dark text-white p-5">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">
                        <i class="fas fa-star mr-2" style="color: #ffff00;"></i> Accesos Rápidos
                    </h3>
                    <p class="text-xs text-blue-100 mt-1">Tus módulos favoritos</p>
                </div>
                <button onclick="toggleQuickSidebar()" class="p-1.5 rounded-lg hover:bg-blue-800 transition">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
        </div>
        
        <div class="p-4 flex-1 overflow-y-auto" id="favorites-container">
            <div id="empty-favorites" class="text-center py-10 text-white opacity-80">
                <i class="fas fa-star text-4xl mb-3 opacity-30" style="color: #ffff00;"></i>
                <p class="font-medium">No tienes accesos rápidos</p>
                <p class="text-xs mt-2 opacity-70">Haz clic en la estrella ⭐ de cualquier menú para agregarlo</p>
            </div>
            <div id="favorites-list" style="display: none;"></div>
        </div>
    </div>

    <!-- BOTÓN FLOTANTE -->
    <button onclick="toggleQuickSidebar()" class="sidebar-toggle-btn" id="sidebar-toggle-btn">
        <i class="fas fa-star"></i>
        <span id="favorite-count" class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-400 text-xs rounded-full flex items-center justify-center font-bold" style="display: none;">0</span>
    </button>

    <!-- CONTENIDO PRINCIPAL -->
    <div id="mainContent" class="main-content-container">
        @yield('content')
    </div>

    <script>
        // ========== VARIABLES GLOBALES ==========
        let currentSection = null;
        let mobileMenuOpen = false;
        
        // Sistema de Accesos Rápidos (Favoritos)
        let quickAccess = JSON.parse(localStorage.getItem('quickAccess')) || [];

        // ========== SISTEMA DE PESTAÑAS - VERSIÓN MINIMALISTA CON COLORES CORREGIDOS ==========
class TabManager {
    constructor() {
        this.tabs = JSON.parse(localStorage.getItem('appTabs')) || [];
        this.activeTabId = localStorage.getItem('activeTabId') || null;
        this.maxTabs = 15;
        this.isNavigating = false;
        this.init();
    }

    init() {
        this.render();
        this.setupEventListeners();
        
        if (this.activeTabId && !this.isNavigating) {
            const activeTab = this.tabs.find(t => t.id === this.activeTabId);
            if (activeTab) {
                const currentUrl = window.location.href;
                const tabUrl = activeTab.url || '{{ route('home') }}';
                
                const currentPath = currentUrl.split('?')[0].split('#')[0];
                const tabPath = tabUrl.split('?')[0].split('#')[0];
                
                if (tabPath !== currentPath && tabUrl !== '#' && tabUrl !== '{{ route('home') }}') {
                    this.navigateToUrl(tabUrl);
                }
            }
        }
    }

    setupEventListeners() {
        const newTabBtn = document.querySelector('.new-tab-btn');
        if (newTabBtn) {
            newTabBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.createNewTab('Inicio', 'home', 'fa-home', '{{ route('home') }}');
            });
        }

        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'w') {
                e.preventDefault();
                if (this.activeTabId) {
                    this.closeTab(this.activeTabId);
                }
            }
            
            if (e.ctrlKey && e.key === 't') {
                e.preventDefault();
                this.createNewTab('Inicio', 'home', 'fa-home', '{{ route('home') }}');
            }
        });
    }

    navigateToUrl(url) {
        if (!url || url === '#' || url === '{{ route('home') }}' || this.isNavigating) return;
        
        this.isNavigating = true;
        window.location.href = url;
    }

    createNewTab(title, section, icon, url = null) {
        if (this.tabs.length >= this.maxTabs) {
            this.showNotification(`No puedes tener más de ${this.maxTabs} pestañas abiertas`, 'warning');
            return;
        }

        if (url && url !== '#' && url !== '{{ route('home') }}') {
            const existingTab = this.tabs.find(t => t.url === url);
            if (existingTab) {
                this.activateTab(existingTab.id);
                if (!this.isNavigating) {
                    this.navigateToUrl(url);
                }
                return;
            }
        }

        const tab = {
            id: 'tab_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            title: title,
            section: section,
            icon: icon || 'fa-file',
            url: url,
            timestamp: new Date().toISOString(),
            favicon: this.getFaviconForSection(section, icon)
        };

        this.tabs.push(tab);
        this.activateTab(tab.id);
        this.saveTabs();
        this.render();
        
        if (url && url !== '#' && url !== '{{ route('home') }}' && !this.isNavigating) {
            this.navigateToUrl(url);
        }
    }

    getFaviconForSection(section, icon) {
        const iconMap = {
            'bi': 'fa-chart-line',
            'administracion': 'fa-money-bill-wave',
            'contabilidad': 'fa-calculator',
            'proyectos': 'fa-project-diagram',
            'rrhh': 'fa-users',
            'inventarios': 'fa-boxes',
            'compras': 'fa-shopping-cart',
            'home': 'fa-home'
        };
        return icon || iconMap[section] || 'fa-file';
    }

    activateTab(tabId) {
        this.activeTabId = tabId;
        localStorage.setItem('activeTabId', tabId);
        this.render();
    }

    closeTab(tabId) {
        const tabIndex = this.tabs.findIndex(t => t.id === tabId);
        if (tabIndex === -1) return;

        this.tabs.splice(tabIndex, 1);

        if (this.tabs.length > 0) {
            if (tabId === this.activeTabId) {
                const newActiveIndex = Math.max(0, tabIndex - 1);
                const newActiveTab = this.tabs[newActiveIndex];
                this.activateTab(newActiveTab.id);
                
                if (newActiveTab.url && newActiveTab.url !== '#' && newActiveTab.url !== '{{ route('home') }}' && !this.isNavigating) {
                    const currentUrl = window.location.href;
                    const tabPath = newActiveTab.url.split('?')[0].split('#')[0];
                    const currentPath = currentUrl.split('?')[0].split('#')[0];
                    
                    if (tabPath !== currentPath) {
                        this.navigateToUrl(newActiveTab.url);
                    }
                }
            }
        } else {
            this.activeTabId = null;
            localStorage.setItem('activeTabId', '');
            
            const homeUrl = '{{ route('home') }}';
            const currentPath = window.location.href.split('?')[0].split('#')[0];
            const homePath = homeUrl.split('?')[0].split('#')[0];
            
            if (currentPath !== homePath && !this.isNavigating) {
                this.navigateToUrl(homeUrl);
            }
        }

        this.saveTabs();
        this.render();
    }

    closeAllTabs() {
        if (this.tabs.length === 0) return;

        if (confirm('¿Estás seguro de que deseas cerrar todas las pestañas?')) {
            this.tabs = [];
            this.activeTabId = null;
            localStorage.removeItem('appTabs');
            localStorage.removeItem('activeTabId');
            
            this.render();
            
            const homeUrl = '{{ route('home') }}';
            const currentPath = window.location.href.split('?')[0].split('#')[0];
            const homePath = homeUrl.split('?')[0].split('#')[0];
            
            if (currentPath !== homePath && !this.isNavigating) {
                this.navigateToUrl(homeUrl);
            }
            
            this.showNotification('Todas las pestañas han sido cerradas', 'info');
        }
    }

    closeOtherTabs(tabId) {
        const tabToKeep = this.tabs.find(t => t.id === tabId);
        if (!tabToKeep) return;

        this.tabs = [tabToKeep];
        this.activateTab(tabToKeep.id);
        this.saveTabs();
        this.render();
        
        if (tabToKeep.url && tabToKeep.url !== '#' && tabToKeep.url !== '{{ route('home') }}' && !this.isNavigating) {
            const currentUrl = window.location.href;
            const tabPath = tabToKeep.url.split('?')[0].split('#')[0];
            const currentPath = currentUrl.split('?')[0].split('#')[0];
            
            if (tabPath !== currentPath) {
                this.navigateToUrl(tabToKeep.url);
            }
        }
        
        this.showNotification('Otras pestañas cerradas', 'info');
    }

    closeTabsToTheRight(tabId) {
        const tabIndex = this.tabs.findIndex(t => t.id === tabId);
        if (tabIndex === -1) return;

        this.tabs = this.tabs.slice(0, tabIndex + 1);
        this.activateTab(tabId);
        this.saveTabs();
        this.render();
    }

    duplicateTab(tabId) {
        const originalTab = this.tabs.find(t => t.id === tabId);
        if (!originalTab) return;

        if (this.tabs.length >= this.maxTabs) {
            this.showNotification(`Límite de ${this.maxTabs} pestañas alcanzado`, 'warning');
            return;
        }

        const duplicate = {
            ...originalTab,
            id: 'tab_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            title: `${originalTab.title} (copia)`,
            timestamp: new Date().toISOString()
        };

        this.tabs.push(duplicate);
        this.activateTab(duplicate.id);
        this.saveTabs();
        this.render();
        
        if (duplicate.url && duplicate.url !== '#' && duplicate.url !== '{{ route('home') }}' && !this.isNavigating) {
            const currentUrl = window.location.href;
            const tabPath = duplicate.url.split('?')[0].split('#')[0];
            const currentPath = currentUrl.split('?')[0].split('#')[0];
            
            if (tabPath !== currentPath) {
                this.navigateToUrl(duplicate.url);
            }
        }
    }

    saveTabs() {
        localStorage.setItem('appTabs', JSON.stringify(this.tabs));
    }

    render() {
        const container = document.getElementById('tabsNavContainer');
        if (!container) return;

        if (this.tabs.length === 0) {
            container.innerHTML = '<div class="text-white text-sm px-3 opacity-70">No hay pestañas abiertas</div>';
            return;
        }

        let html = '';
        this.tabs.forEach((tab, index) => {
            const isActive = tab.id === this.activeTabId;
            
            html += `
                <div class="tab-item group relative inline-flex items-center px-3 py-1 mr-2 text-sm cursor-pointer transition-colors duration-150 ${isActive ? 'text-gray-900 font-medium' : 'text-white hover:text-gray-200'}" 
                     data-tab-id="${tab.id}" 
                     data-tab-index="${index}"
                     onclick="tabManager.handleTabClick('${tab.id}', '${tab.url}')"
                     oncontextmenu="tabManager.showTabContextMenu(event, '${tab.id}')">
                    
                    <i class="fas ${tab.favicon} mr-2 ${isActive ? 'text-gray-900' : 'text-white'}"></i>
                    
                    <span class="max-w-xs truncate">${tab.title}</span>
                    
                    <button class="close-tab ml-2 p-1 rounded-full hover:bg-white hover:bg-opacity-20 transition-colors opacity-0 group-hover:opacity-100" 
                            onclick="event.stopPropagation(); tabManager.closeTab('${tab.id}')"
                            title="Cerrar pestaña (Ctrl+W)">
                        <i class="fas fa-times text-xs ${isActive ? 'text-gray-600' : 'text-white'}"></i>
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    handleTabClick(tabId, url) {
        this.activateTab(tabId);
        
        if (url && url !== '#' && url !== '{{ route('home') }}' && !this.isNavigating) {
            const currentUrl = window.location.href;
            const tabPath = url.split('?')[0].split('#')[0];
            const currentPath = currentUrl.split('?')[0].split('#')[0];
            
            if (tabPath !== currentPath) {
                this.navigateToUrl(url);
            }
        }
    }

    showTabContextMenu(event, tabId) {
        event.preventDefault();
        
        const existingMenu = document.querySelector('.tab-context-menu');
        if (existingMenu) existingMenu.remove();

        const tab = this.tabs.find(t => t.id === tabId);
        if (!tab) return;

        const menu = document.createElement('div');
        menu.className = 'tab-context-menu fixed bg-white rounded-lg shadow-xl py-2 z-[1100] min-w-[200px] text-sm border border-gray-200';
        menu.style.left = event.pageX + 'px';
        menu.style.top = event.pageY + 'px';

        menu.innerHTML = `
            <div class="px-4 py-2 border-b border-gray-100 bg-gray-50">
                <div class="font-semibold text-gray-700">${tab.title}</div>
                <div class="text-xs text-gray-500 mt-1">${new Date(tab.timestamp).toLocaleString()}</div>
            </div>
            
            <button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.duplicateTab('${tab.id}')">
                <i class="fas fa-copy w-5 text-gray-500"></i>
                <span class="ml-2">Duplicar pestaña</span>
            </button>
            
            <button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.closeOtherTabs('${tab.id}')">
                <i class="fas fa-times-circle w-5 text-gray-500"></i>
                <span class="ml-2">Cerrar otras pestañas</span>
            </button>
            
            <button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.closeTabsToTheRight('${tab.id}')">
                <i class="fas fa-arrow-right w-5 text-gray-500"></i>
                <span class="ml-2">Cerrar pestañas a la derecha</span>
            </button>
            
            <div class="border-t border-gray-100 my-1"></div>
            
            <button class="context-menu-item w-full text-left px-4 py-2 hover:bg-red-50 flex items-center text-red-600" onclick="tabManager.closeTab('${tab.id}')">
                <i class="fas fa-trash-alt w-5"></i>
                <span class="ml-2">Cerrar pestaña</span>
            </button>
            
            <button class="context-menu-item w-full text-left px-4 py-2 hover:bg-red-50 flex items-center text-red-600" onclick="tabManager.closeAllTabs()">
                <i class="fas fa-times-circle w-5"></i>
                <span class="ml-2">Cerrar todas las pestañas</span>
            </button>
        `;

        document.body.appendChild(menu);

        const closeMenu = (e) => {
            if (!menu.contains(e.target)) {
                menu.remove();
                document.removeEventListener('click', closeMenu);
            }
        };
        setTimeout(() => document.addEventListener('click', closeMenu), 100);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-600' : 
                       type === 'warning' ? 'bg-yellow-600' : 
                       type === 'error' ? 'bg-red-600' : 'bg-blue-600';
        
        notification.className = `fixed top-20 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-[1100] text-sm flex items-center`;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} mr-2"></i>${message}`;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

        // ========== FUNCIÓN DE NAVEGACIÓN PRINCIPAL ==========
        function navigateTo(pageName, module, route, icon) {
            console.log(`Navegando a: ${pageName} [${module}]`);
            
            if (window.tabManager) {
                window.tabManager.createNewTab(pageName, module, icon, route);
            }
            
            closeSectionSidebar();
        }

        // ========== FUNCIONES DE SIDEBAR ==========
        function toggleSectionSidebar(section) {
            const sidebar = document.getElementById(`sidebar-${section}`);
            const mainContent = document.getElementById('mainContent');
            const tabBar = document.querySelector('.tab-navigation-bar');
            
            if (!sidebar) return;
            
            if (currentSection === section && sidebar.classList.contains('open')) {
                closeSectionSidebar();
                return;
            }
            
            closeAllSectionSidebars();
            
            sidebar.classList.add('open');
            mainContent.classList.add('sidebar-open');
            tabBar.classList.add('sidebar-open');
            
            currentSection = section;
            
            if (window.innerWidth <= 992) {
                closeMobileMenu();
            }
        }

        function closeSectionSidebar() {
            const sidebars = document.querySelectorAll('.section-sidebar');
            const mainContent = document.getElementById('mainContent');
            const tabBar = document.querySelector('.tab-navigation-bar');
            
            sidebars.forEach(sidebar => sidebar.classList.remove('open'));
            mainContent.classList.remove('sidebar-open');
            tabBar.classList.remove('sidebar-open');
            
            currentSection = null;
        }

        function closeAllSectionSidebars() {
            document.querySelectorAll('.section-sidebar').forEach(s => s.classList.remove('open'));
        }

        function closeAllSidebars() {
            closeSectionSidebar();
            closeQuickSidebar();
        }

        // ========== FUNCIONES DE MENÚ MÓVIL ==========
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobileMenuSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            mobileMenuOpen = !mobileMenuOpen;
            
            if (mobileMenuOpen) {
                sidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('mobileMenuSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            mobileMenuOpen = false;
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function toggleMobileSectionSidebar(section) {
            closeMobileMenu();
            toggleSectionSidebar(section);
        }

        // ========== FUNCIONES DE SUBMENÚ ==========
        function toggleSubmenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            const title = submenu?.previousElementSibling;
            
            if (submenu) {
                submenu.classList.toggle('expanded');
                title?.classList.toggle('expanded');
            }
        }

        // ========== FUNCIONES DE FAVORITOS ==========
        function toggleQuickSidebar() {
            const sidebar = document.getElementById('quick-sidebar');
            sidebar.classList.toggle('open');
            
            if (window.innerWidth <= 992) {
                closeMobileMenu();
            }
        }

        function closeQuickSidebar() {
            document.getElementById('quick-sidebar').classList.remove('open');
        }

        function toggleFavorite(title, module, icon, element) {
            const favorite = {
                id: `${module}-${title}`.replace(/\s+/g, '-').toLowerCase(),
                title: title,
                module: module,
                icon: icon,
                path: `${module} > ${title}`,
                timestamp: new Date().toISOString()
            };

            const existingIndex = quickAccess.findIndex(f => f.id === favorite.id);

            if (existingIndex === -1) {
                quickAccess.push(favorite);
                element.classList.add('active');
                showNotification(`⭐ "${title}" agregado a accesos rápidos`, 'success');
            } else {
                quickAccess.splice(existingIndex, 1);
                element.classList.remove('active');
                showNotification(`❌ "${title}" eliminado de accesos rápidos`, 'info');
            }

            localStorage.setItem('quickAccess', JSON.stringify(quickAccess));
            updateFavoritesUI();
            updateFavoriteStars();
        }

        function updateFavoritesUI() {
            const favoritesList = document.getElementById('favorites-list');
            const emptyFavorites = document.getElementById('empty-favorites');
            const favoriteCount = document.getElementById('favorite-count');
            const notificationDot = document.getElementById('notification-dot');
            
            if (quickAccess.length === 0) {
                if (favoritesList) favoritesList.style.display = 'none';
                if (emptyFavorites) emptyFavorites.style.display = 'block';
                if (favoriteCount) favoriteCount.style.display = 'none';
                if (notificationDot) notificationDot.style.display = 'none';
                return;
            }

            const sortedFavorites = [...quickAccess].sort((a, b) => 
                new Date(b.timestamp) - new Date(a.timestamp)
            );

            let html = '';
            sortedFavorites.forEach(fav => {
                html += `
                    <div class="favorite-item" onclick="navigateTo('${fav.title}', '${fav.module}', '#', '${fav.icon}')">
                        <i class="fas ${fav.icon}"></i>
                        <div class="favorite-item-content">
                            <div class="favorite-item-title">${fav.title}</div>
                            <div class="favorite-item-path">${fav.module}</div>
                        </div>
                        <div class="favorite-item-remove" onclick="event.stopPropagation(); removeFavorite('${fav.id}')">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                `;
            });

            if (favoritesList) {
                favoritesList.innerHTML = html;
                favoritesList.style.display = 'block';
            }
            if (emptyFavorites) emptyFavorites.style.display = 'none';
            
            if (favoriteCount) {
                favoriteCount.textContent = quickAccess.length;
                favoriteCount.style.display = 'flex';
            }
            
            if (notificationDot) notificationDot.style.display = quickAccess.length > 0 ? 'block' : 'none';
        }

        function removeFavorite(favoriteId) {
            const index = quickAccess.findIndex(f => f.id === favoriteId);
            if (index !== -1) {
                const removedTitle = quickAccess[index].title;
                quickAccess.splice(index, 1);
                localStorage.setItem('quickAccess', JSON.stringify(quickAccess));
                updateFavoritesUI();
                updateFavoriteStars();
                showNotification(`❌ "${removedTitle}" eliminado de accesos rápidos`, 'info');
            }
        }

        function updateFavoriteStars() {
            const stars = document.querySelectorAll('.favorite-star');
            stars.forEach(star => {
                star.classList.remove('active');
                const menuItem = star.closest('.sidebar-submenu-item');
                if (menuItem) {
                    const title = menuItem.querySelector('span:not(.favorite-star)')?.textContent?.trim() || '';
                    const module = menuItem.closest('.section-sidebar')?.id?.replace('sidebar-', '') || '';
                    const favoriteId = `${module}-${title}`.replace(/\s+/g, '-').toLowerCase();
                    
                    if (quickAccess.some(f => f.id === favoriteId)) {
                        star.classList.add('active');
                    }
                }
            });
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-600' : 
                          type === 'error' ? 'bg-red-600' : 'bg-blue-600';
            
            notification.className = `fixed top-20 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-[1100] text-sm flex items-center`;
            notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} mr-2"></i>${message}`;
            notification.style.animation = 'fadeIn 0.3s ease';
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // ========== CIERRE DE SESIÓN ==========
        function confirmLogout() {
            const modal = document.getElementById('logout-confirm-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                    document.querySelector('form[action*="logout"]')?.submit();
                }
            }
        }

        // ========== NOTIFICACIONES ==========
        function notifications() {
            return {
                isOpen: false,
                unreadCount: 0,
                filter: 'all',
                notifications: [],
                
                initNotifications() {
                    this.notifications = [
                        {
                            id: 1,
                            title: 'Bienvenido al sistema',
                            message: 'Has iniciado sesión correctamente',
                            type: 'info',
                            priority: 'low',
                            read: false,
                            timestamp: new Date().toISOString(),
                            category: 'Sistema'
                        },
                        {
                            id: 2,
                            title: 'Nuevo proyecto asignado',
                            message: 'Se te ha asignado el proyecto "Edificio Corporativo"',
                            type: 'success',
                            priority: 'high',
                            read: false,
                            timestamp: new Date(Date.now() - 3600000).toISOString(),
                            category: 'Proyectos'
                        }
                    ];
                    this.updateUnreadCount();
                },
                
                toggleNotifications() {
                    this.isOpen = !this.isOpen;
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
                
                clearAll() {
                    this.notifications = [];
                    this.updateUnreadCount();
                },
                
                updateUnreadCount() {
                    this.unreadCount = this.notifications.filter(n => !n.read).length;
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
                    const diff = Math.floor((now - date) / 60000);
                    if (diff < 1) return 'Ahora';
                    if (diff < 60) return `Hace ${diff} min`;
                    if (diff < 1440) return `Hace ${Math.floor(diff / 60)} h`;
                    return date.toLocaleDateString();
                }
            };
        }

        // ========== INICIALIZACIÓN ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar gestor de pestañas
            window.tabManager = new TabManager();
            
            // Inicializar favoritos
            updateFavoritesUI();
            updateFavoriteStars();
            
            // Cerrar menús al redimensionar
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    closeMobileMenu();
                }
            });
            
            // Cerrar modales con Escape
            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('logout-confirm-modal');
                    if (modal && modal.classList.contains('flex')) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                    closeSectionSidebar();
                    closeQuickSidebar();
                    closeMobileMenu();
                }
            });
        });
    </script>
    
    <!-- Modal de confirmación de cierre de sesión -->
    <div id="logout-confirm-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[1100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-5">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-sign-out-alt text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Cerrar Sesión</h3>
                        <p class="text-sm text-gray-600">¿Estás seguro de que deseas salir?</p>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button onclick="document.getElementById('logout-confirm-modal').classList.add('hidden'); document.getElementById('logout-confirm-modal').classList.remove('flex');" 
                            class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Sí, Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
