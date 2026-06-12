<!DOCTYPE html>
<html lang="es">
<head>

 <script>
@auth
    window.userId = {{ Auth::id() }};
    window.userName = '{{ Auth::user()->name }}';
    window.isAuthenticated = true;
@else
    window.userId = null;
    window.userName = '';
    window.isAuthenticated = false;
    // Redirigir automáticamente al login si la sesión expiró
    window.location.href = '{{ route("login") }}';
@endauth
window.baseUrl = '{{ url('/') }}';
console.log('Base URL:', window.baseUrl);
console.log('User ID:', window.userId);
</script>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Contenedor principal para footer pegajoso */
    .app-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
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

    nav.bg-construction-dark .desktop-menu button i {
        color: #eaf512 !important;
        transition: all 0.3s ease;
    }

    nav.bg-construction-dark .desktop-menu button:hover i {
        color: white !important;
    }

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
        z-index: 10000 !important;
        transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 2px solid #FF0000 !important;
        pointer-events: auto !important;
        isolation: isolate;
    }

    .tab-navigation-bar.sidebar-open {
        left: var(--sidebar-width);
        width: calc(100% - var(--sidebar-width));
    }

    .close-all-tabs-container {
        background-color: #FF0000 !important;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 0 20px;
        margin-left: -15px;
        border-right: 2px solid #cc0000;
        position: relative !important;
        z-index: 10001 !important;
        pointer-events: auto !important;
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
        position: relative !important;
        z-index: 10002 !important;
        cursor: pointer !important;
        pointer-events: auto !important;
    }

    .close-all-tabs-btn:hover {
        transform: translateY(-2px);
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .close-all-tabs-btn i {
        color: white !important;
        font-size: 14px;
    }

    .tabs-container-nav {
        display: flex;
        align-items: center;
        overflow-x: auto;
        overflow-y: hidden;
        flex: 1;
        height: 100%;
        scrollbar-width: thin;
        padding-left: 10px;
        position: relative !important;
        z-index: 10001 !important;
        pointer-events: auto !important;
    }

    #tabsNavContainer {
        display: flex;
        align-items: center;
        overflow-x: auto;
        overflow-y: hidden;
        flex: 1;
        height: 100%;
        scrollbar-width: thin;
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

    .tab-item {
        cursor: pointer;
        max-width: 200px;
        position: relative !important;
        user-select: none;
        transition: color 0.15s ease;
        z-index: 10001 !important;
        pointer-events: auto !important;
    }

    .tab-item .close-tab {
        transition: opacity 0.15s ease;
        z-index: 10002 !important;
        pointer-events: auto !important;
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
        z-index: 10003 !important;
    }

    .context-menu-item {
        transition: background-color 0.15s ease;
    }

    .context-menu-item:hover {
        background-color: #f3f4f6;
    }

    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(-5px); } 
        to { opacity: 1; transform: translateY(0); } 
    }

    /* ========== LOGO ========== */
    nav.bg-construction-dark .flex.items-center.space-x-3 {
        pointer-events: none;
        position: relative;
        z-index: 1 !important;
    }

    nav.bg-construction-dark .flex.items-center.space-x-3 a {
        pointer-events: auto;
        position: relative;
        z-index: 2 !important;
    }

    nav.bg-construction-dark .flex.items-center.space-x-3 img {
        pointer-events: none !important;
        max-height: 180px !important;
        width: auto !important;
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
        z-index: 9000;
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
        margin-bottom: 0rem;
    }

    .sidebar-menu-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem 1rem;
        background: transparent;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sidebar-menu-title span i {
        color: #ffff00;
        margin-right: 8px;
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
        z-index: 20000 !important; /* Aumentado para estar sobre la barra verde */
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
        flex: 1;
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
        z-index: 1040;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .mobile-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ========== NOTIFICACIONES - Z-index aumentado ========== */
    .notifications-menu {
        position: absolute;
        right: 0;
        top: 100%;
        width: 400px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        z-index: 200000 !important;
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

    /* ========== ESTILOS DEL CHAT - Z-index aumentado ========== */
    .chat-widget-container {
        position: relative;
        z-index: 200000 !important;
    }

    .chat-panel {
        position: fixed !important;
        top: 80px !important;
        right: 20px !important;
        width: 380px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        z-index: 200000 !important;
        overflow: hidden;
        animation: slideIn 0.2s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-header {
        background: linear-gradient(135deg, #083CAE 0%, #0a4ad0 100%);
        padding: 1rem 1.25rem;
        color: white;
    }

    .chat-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }

    .chat-header p {
        font-size: 0.7rem;
        opacity: 0.8;
        margin-top: 2px;
    }

    .chat-users-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .chat-user-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .chat-user-item:hover {
        background-color: #f8fafc;
    }

    .chat-user-item.active {
        background-color: #eef2ff;
        border-left: 3px solid #083CAE;
    }

    .chat-user-avatar {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .chat-user-avatar i {
        font-size: 1.2rem;
        color: #083CAE;
    }

    .chat-user-info {
        flex: 1;
        min-width: 0;
    }

    .chat-user-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .chat-user-email {
        font-size: 0.7rem;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-user-badge {
        background-color: #ef4444;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        border-radius: 20px;
        padding: 2px 8px;
        min-width: 22px;
        text-align: center;
    }

    .chat-conversation {
        display: flex;
        flex-direction: column;
        height: 500px;
    }

    .chat-conversation-header {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-conversation-header h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .chat-conversation-header button {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .chat-conversation-header button:hover {
        background-color: #e5e7eb;
        color: #4b5563;
    }

    .chat-messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background-color: #f9fafb;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .message-bubble {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 18px;
        font-size: 0.85rem;
        line-height: 1.4;
        word-wrap: break-word;
        position: relative;
    }

    .message-own {
        background: linear-gradient(135deg, #083CAE 0%, #1e4bd2 100%);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .message-other {
        background-color: white;
        color: #1f2937;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .message-time {
        font-size: 0.6rem;
        opacity: 0.7;
        margin-top: 4px;
        display: block;
        text-align: right;
    }

    .chat-input-area {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e5e7eb;
        background-color: white;
        display: flex;
        gap: 8px;
    }

    .chat-input {
        flex: 1;
        padding: 0.6rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        font-size: 0.85rem;
        outline: none;
        transition: all 0.2s;
        background-color: white !important;
        color: #1f2937 !important;
    }

    .chat-input::placeholder {
        color: #9ca3af !important;
    }

    .chat-input:focus {
        border-color: #083CAE;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.1);
        background-color: white !important;
        color: #1f2937 !important;
    }

    .chat-send-btn {
        background: linear-gradient(135deg, #083CAE 0%, #1e4bd2 100%);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-send-btn:hover {
        transform: scale(1.05);
    }

    .chat-back-btn {
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.8rem;
    }

    .chat-back-btn:hover {
        background-color: #e5e7eb;
        color: #374151;
    }

    .chat-empty {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }

    .chat-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .chat-messages-area::-webkit-scrollbar,
    .chat-users-list::-webkit-scrollbar {
        width: 5px;
    }

    .chat-messages-area::-webkit-scrollbar-track,
    .chat-users-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-messages-area::-webkit-scrollbar-thumb,
    .chat-users-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Estilos específicos para el input del chat */
    .chat-panel .chat-input-area .chat-input,
    .chat-panel .chat-input-area input.chat-input {
        background-color: #ffffff !important;
        color: #1f2937 !important;
        border: 1px solid #d1d5db !important;
    }

    .chat-panel .chat-input-area .chat-input:focus {
        background-color: #ffffff !important;
        color: #1f2937 !important;
        border-color: #083CAE !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.1) !important;
    }

    .chat-panel .chat-input-area .chat-input::placeholder {
        color: #9ca3af !important;
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

    #notification-dot {
        background-color: #eaf512 !important;
        box-shadow: 0 0 5px #eaf512;
    }

    /* ========== PIE DE PÁGINA ========== */
    .app-footer {
        background-color: #083CAE !important;
        margin-top: auto;
        position: relative;
        z-index: 100;
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
        
        .tab-navigation-bar {
            z-index: 900 !important;
        }
        
        .mobile-menu-sidebar {
            z-index: 1000 !important;
        }
        
        .mobile-overlay {
            z-index: 950 !important;
        }
        
        .main-content-container {
            margin-top: calc(var(--navbar-height) + var(--tabbar-height));
            padding: 1rem;
        }
        
        .tab-navigation-bar.sidebar-open {
            left: 0 !important;
            width: 100% !important;
        }
        
        .close-all-tabs-container {
            padding: 0 10px;
        }
        
        .close-all-tabs-btn span {
            display: none;
        }
        
        .close-all-tabs-btn i {
            margin-right: 0;
        }
        
        .tab-item {
            padding: 0 8px !important;
            font-size: 12px !important;
        }
        
        .tab-item i {
            margin-right: 4px !important;
        }
        
        .tab-item span {
            max-width: 100px !important;
        }
        
        .chat-panel {
            width: 90% !important;
            right: 5% !important;
            left: 5% !important;
            top: 70px !important;
        }
    }

    @media (min-width: 993px) {
        .mobile-menu-sidebar,
        .mobile-overlay {
            display: none !important;
        }
    }

    @media (max-width: 480px) {
        .tab-item span {
            max-width: 70px !important;
        }
        
        .close-all-tabs-container {
            padding: 0 5px;
        }
    }
</style>
    
</head>

<body class="bg-gray-50">
    <div class="app-wrapper">
        @vite(['resources/js/app.js'])
        
        <!-- TOP NAVIGATION BAR -->
        <nav x-data="{ mobileMenuOpen: false }" class="bg-construction-dark text-white shadow-lg fixed top-0 left-0 right-0 z-50">
            <div class="max-w-8xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-md hover:bg-blue-800">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                                <img src="../img/login/logoblanco.png" alt="Logo" class="h-[180px] w-[180px]" onerror="this.src='https://via.placeholder.com/150x40/083CAE/FFFFFF?text=LOGO'">
                            </a>
                        </div>
                    </div>

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
                        <button onclick="toggleSectionSidebar('inventarios')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-boxes"></i>
                            <span>Almacen</span>
                        </button>
                        <button onclick="toggleSectionSidebar('compras')" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition flex items-center space-x-2">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Compras</span>
                        </button>
                    </div>

                    <div class="flex items-center space-x-2 ml-auto">
                        <!-- CHAT WIDGET -->
                        <div x-data="chatWidget()" x-init="initChat()" class="chat-widget-container">
                            <button @click="toggleChat()" class="px-3 py-2 rounded-lg hover:bg-blue-800 transition relative">
                                <i class="fas fa-comments text-xl" style="color: #eaf512;"></i>
                                <span x-show="unreadMessagesCount > 0" 
                                      x-text="unreadMessagesCount" 
                                      class="absolute -top-2 -right-2 min-w-[20px] h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center px-1 font-bold"></span>
                            </button>

                            <div x-show="isOpen" @click.away="closeChat()" class="chat-panel">
                                <div class="chat-header">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3><i class="fas fa-comments mr-2"></i>Chat</h3>
                                            <p>Conversaciones</p>
                                        </div>
                                        <button @click="closeChat()" class="text-white/80 hover:text-white transition">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="!selectedUser" class="chat-users-list">
                                    <template x-for="user in users" :key="user.id">
                                        <div @click="selectUser(user)" 
                                             :class="{'active': selectedUser && selectedUser.id === user.id}"
                                             class="chat-user-item">
                                            <div class="chat-user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="chat-user-info">
                                                <div class="chat-user-name" x-text="user.name"></div>
                                                <div class="chat-user-email" x-text="user.email"></div>
                                            </div>
                                            <div x-show="user.unread > 0" 
                                                 x-text="user.unread" 
                                                 class="chat-user-badge"></div>
                                        </div>
                                    </template>
                                    <div x-show="users.length === 0" class="chat-empty">
                                        <i class="fas fa-users-slash"></i>
                                        <p>No hay otros usuarios</p>
                                    </div>
                                </div>

                                <div x-show="selectedUser" class="chat-conversation">
                                    <div class="chat-conversation-header">
                                        <div class="flex items-center gap-2">
                                            <button @click="backToList()" class="chat-back-btn">
                                                <i class="fas fa-arrow-left"></i>
                                                <span>Volver</span>
                                            </button>
                                            <div>
                                                <h4 x-text="selectedUser.name"></h4>
                                            </div>
                                        </div>
                                        <button @click="closeConversation()" title="Cerrar conversación">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="chat-messages-area" x-ref="messagesContainer">
                                        <template x-for="msg in messages" :key="msg.id">
                                            <div :class="msg.isOwn ? 'message-own' : 'message-other'" class="message-bubble">
                                                <span x-text="msg.text"></span>
                                                <span class="message-time" x-text="formatTime(msg.created_at)"></span>
                                            </div>
                                        </template>
                                        <div x-show="messages.length === 0" class="chat-empty">
                                            <i class="fas fa-comment-dots"></i>
                                            <p>No hay mensajes aún</p>
                                            <p class="text-xs mt-1">Escribe el primer mensaje</p>
                                        </div>
                                    </div>

                                    <div class="chat-input-area">
                                        <input type="text" 
                                               x-model="newMessage" 
                                               @keyup.enter="sendMessage" 
                                               placeholder="Escribe un mensaje..." 
                                               class="chat-input">
                                        <button @click="sendMessage" class="chat-send-btn">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-xl z-[199999999] !important py-2 ">
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
        
        <!-- BARRA DE PESTAÑAS -->
        <div class="tab-navigation-bar" id="tabNavigationBar">
            <div class="close-all-tabs-container">
                <button class="close-all-tabs-btn" onclick="if(window.tabManager) tabManager.closeAllTabs()">
                    <i class="fas fa-times-circle"></i> Cerrar
                </button>
            </div>
            <div class="tabs-container-nav" id="tabsNavContainer"></div>
        </div>

        <!-- MENÚ HAMBURGUESA MÓVIL -->
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
                <div class="mobile-menu-item" onclick="toggleMobileSectionSidebar('inventarios')">
                    <i class="fas fa-boxes"></i>
                    <span>Almacen</span>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-dashboard')">
                        <span><i class="fas fa-tachometer-alt"></i> Dashboard</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="bi-dashboard" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Directivo', 'bi', '{{ route('bi.dashboard') }}', 'fa-user-tie')">
                            <div class="flex items-center flex-1"><i class="fas fa-user-tie"></i><span>Directivo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Directivo', 'bi', 'fa-user-tie', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Finanzas', 'bi', '{{ route('bi.finanzas') }}', 'fa-chart-pie')">
                            <div class="flex items-center flex-1"><i class="fas fa-chart-pie"></i><span>Finanzas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Finanzas', 'bi', 'fa-chart-pie', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Licitaciones', 'bi', '{{ route('bi.licitaciones') }}', 'fa-gavel')">
                            <div class="flex items-center flex-1"><i class="fas fa-gavel"></i><span>Licitaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Licitaciones', 'bi', 'fa-gavel', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-ventas')">
                        <span><i class="fas fa-chart-bar"></i> Ventas</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="bi-ventas" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Propuestas y Cotizaciones', 'bi', '{{ route('ventas.propuestas') }}', 'fa-file-contract')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-contract"></i><span>Propuestas y Cotizaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Propuestas y Cotizaciones', 'bi', 'fa-file-contract', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Ventas', 'bi', '{{ route('ventas.analisis') }}', 'fa-chart-line')">
                            <div class="flex items-center flex-1"><i class="fas fa-chart-line"></i><span>Análisis de Ventas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Ventas', 'bi', 'fa-chart-line', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-facturacion')">
                        <span><i class="fas fa-file-invoice-dollar"></i> Facturación</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="bi-facturacion" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Pendiente de Facturación', 'bi', '{{ route('facturacion.pendiente') }}', 'fa-clock')">
                            <div class="flex items-center flex-1"><i class="fas fa-clock"></i><span>Pendiente de Facturación</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pendiente de Facturación', 'bi', 'fa-clock', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Facturado', 'bi', '{{ route('facturacion.facturacion') }}', 'fa-check-circle')">
                            <div class="flex items-center flex-1"><i class="fas fa-check-circle"></i><span>Facturado</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturado', 'bi', 'fa-check-circle', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('bi-cobranza')">
                        <span><i class="fas fa-hand-holding-usd"></i> Cobranza</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="bi-cobranza" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Proyecciones de Flujo', 'bi', '{{ route('cobranza.proyecciones') }}', 'fa-chart-line')">
                            <div class="flex items-center flex-1"><i class="fas fa-chart-line"></i><span>Proyecciones de Flujo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Proyecciones de Flujo', 'bi', 'fa-chart-line', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Historial de Pagos', 'bi', '{{ route('cobranza.historial') }}', 'fa-history')">
                            <div class="flex items-center flex-1"><i class="fas fa-history"></i><span>Historial de Pagos</span></div>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-facturacion')">
                        <span><i class="fas fa-file-invoice-dollar"></i> Facturación</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-facturacion" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Facturación', 'administracion', '{{ route('admin.facturacion') }}', 'fa-file-invoice')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-invoice"></i><span>Facturación</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturación', 'administracion', 'fa-file-invoice', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('C F D I', 'administracion', '{{ route('admin.cfdi') }}', 'fa-solid fa-file-contract')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-file-contract"></i><span>CFDI</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('C F D I', 'administracion', 'fa-solid fa-file-contract', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Notas de Crédito', 'administracion', '{{ route('admin.nota') }}', 'fa-undo-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-undo-alt"></i><span>Notas de Crédito</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Notas de Crédito', 'administracion', 'fa-undo-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Notas de Ventas', 'administracion', '{{ route('admin.ventas') }}', 'fa-sticky-note')">
                            <div class="flex items-center flex-1"><i class="fas fa-sticky-note"></i><span>Notas de Ventas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Notas de Ventas', 'administracion', 'fa-sticky-note', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Contrarecibos', 'administracion', '{{ route('admin.contrarecibo') }}', 'fa-receipt')">
                            <div class="flex items-center flex-1"><i class="fas fa-receipt"></i><span>Contrarecibos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Contrarecibos', 'administracion', 'fa-receipt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Factoraje', 'administracion', '{{ route('admin.factoraje') }}', 'fa-handshake')">
                            <div class="flex items-center flex-1"><i class="fas fa-handshake"></i><span>Factoraje</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Factoraje', 'administracion', 'fa-handshake', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora', 'administracion', '{{ route('admin.bitacora') }}', 'fa-book')">
                            <div class="flex items-center flex-1"><i class="fas fa-book"></i><span>Bitácora</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora', 'administracion', 'fa-book', this)"></i>
                        </div> -->
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Comisiones', 'administracion', '{{ route('admin.comiciones') }}', 'fa-percentage')">
                            <div class="flex items-center flex-1"><i class="fas fa-percentage"></i><span>Comisiones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Comisiones', 'administracion', 'fa-percentage', this)"></i>
                        </div> -->
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cxc')">
                        <span><i class="fas fa-hand-holding-usd"></i> Cuentas por Cobrar</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-cxc" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas por Cobrar', 'administracion', '{{ route('admin.saldos') }}', 'fa-solid fa-money-bill-trend-up')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-money-bill-trend-up"></i><span>Cuentas por Cobrar</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas por Cobrar', 'administracion', 'fa-solid fa-money-bill-trend-up', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cxp')">
                        <span><i class="fa-solid fa-money-check-dollar"></i> Cuentas por Pagar</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-cxp" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas por Pagar', 'administracion', '{{ route('admin.pagos') }}', 'fa-solid fa-file-invoice-dollar')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-file-invoice-dollar"></i><span>Cuentas por Pagar</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas por Pagar', 'administracion', 'fa-solid fa-file-invoice-dollar', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-tesoreria')">
                        <span><i class="fas fa-university"></i> Tesorería</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-tesoreria" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Depósitos', 'administracion', '{{ route('depositos.index') }}', 'fa-money-check-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-check-alt"></i><span>Depósitos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Depósitos', 'administracion', 'fa-money-check-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Trasferencia', 'administracion', '{{ route('tesoreria.trasferencia') }}', 'fa-money-bill-trend-up')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-money-bill-trend-up"></i><span>Trasferencia</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Trasferencia', 'administracion', 'fa-money-bill-trend-up', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Pagos', 'administracion', '{{ route('pagos.index') }}', 'fa-file-invoice-dollar')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-file-invoice-dollar"></i><span>Pagos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pagos', 'administracion', 'fa-file-invoice-dollar', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Traspasos', 'administracion', '{{ route('traspasos.index') }}', 'fa-exchange-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-exchange-alt"></i><span>Traspasos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Traspasos', 'administracion', 'fa-exchange-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Estados de Cuenta Bancarios', 'administracion', '{{ route('tesoreria.estadosdecuenta') }}', 'fa-file-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-alt"></i><span>Estados de Cuenta Bancarios</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estados de Cuenta Bancarios', 'administracion', 'fa-file-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Conciliación Bancaria', 'administracion', '{{ route('tesoreria.conciliacion') }}', 'fa-balance-scale')">
                            <div class="flex items-center flex-1"><i class="fas fa-balance-scale"></i><span>Conciliación Bancaria</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Conciliación Bancaria', 'administracion', 'fa-balance-scale', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Flujo de Dinero', 'administracion', '{{ route('tesoreria.flujos') }}', 'fa-wave-square')">
                            <div class="flex items-center flex-1"><i class="fas fa-wave-square"></i><span>Flujo de Dinero</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Flujo de Dinero', 'administracion', 'fa-wave-square', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Flujo Mensual', 'administracion', '{{ route('tesoreria.flujomensual') }}', 'fa-calendar-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-calendar-alt"></i><span>Flujo Mensual</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Flujo Mensual', 'administracion', 'fa-calendar-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Programación de Pagos', 'administracion', '{{ route('tesoreria.programacion') }}', 'fa-calendar-check')">
                            <div class="flex items-center flex-1"><i class="fas fa-calendar-check"></i><span>Programación de Pagos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Programación de Pagos', 'administracion', 'fa-calendar-check', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-presupuestos')">
                        <span><i class="fas fa-chart-pie"></i> Presupuestos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-presupuestos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Facturacion Proveedores', 'administracion', '{{ route('presupuestos.facturacion') }}', 'fa-chart-pie')">
                            <div class="flex items-center flex-1"><i class="fas fa-chart-pie"></i><span>Facturacion Proveedores</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Facturacion Proveedores', 'administracion', 'fa-chart-pie', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto Mensual', 'administracion', '{{ route('presupuestos.mensual') }}', 'fa-calendar')">
                            <div class="flex items-center flex-1"><i class="fas fa-calendar"></i><span>Presupuesto Mensual</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto Mensual', 'administracion', 'fa-calendar', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Reasignación de Gastos', 'administracion', '{{ route('presupuestos.reasignacion') }}', 'fa-random')">
                            <div class="flex items-center flex-1"><i class="fas fa-random"></i><span>Reasignación de Gastos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reasignación de Gastos', 'administracion', 'fa-random', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Gastos Fijos', 'administracion', '{{ route('presupuestos.gastos') }}', 'fa-home')">
                            <div class="flex items-center flex-1"><i class="fas fa-home"></i><span>Gastos Fijos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Gastos Fijos', 'administracion', 'fa-home', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-operaciones')">
                        <span><i class="fas fa-exchange-alt"></i> Operaciones</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-operaciones" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Prepago', 'administracion', '{{ route('operaciones.prepago') }}', 'fa-forward')">
                            <div class="flex items-center flex-1"><i class="fas fa-forward"></i><span>Prepago</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Prepago', 'administracion', 'fa-forward', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Anticipos', 'administracion', '{{ route('operaciones.anticipo') }}', 'fa-hand-holding-usd')">
                            <div class="flex items-center flex-1"><i class="fas fa-hand-holding-usd"></i><span>Anticipos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Anticipos', 'administracion', 'fa-hand-holding-usd', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Crédito', 'administracion', '{{ route('operaciones.credito') }}', 'fa-credit-card')">
                            <div class="flex items-center flex-1"><i class="fas fa-credit-card"></i><span>Crédito</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Crédito', 'administracion', 'fa-credit-card', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('admin-cuentas-avanzadas')">
                        <span><i class="fas fa-cogs"></i> Cuentas Avanzadas</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="admin-cuentas-avanzadas" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas Avanzadas', 'administracion', '{{ route('cuentasavanzadas.cuentasavanzadas') }}', 'fa-cogs')">
                            <div class="flex items-center flex-1"><i class="fas fa-cogs"></i><span>Cuentas Avanzadas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas Avanzadas', 'administracion', 'fa-cogs', this)"></i>
                        </div>
                       
                            <div class="sidebar-submenu-item" onclick="navigateTo('Registro de Cuentas Contables', 'administracion', '{{ route('registro.cuentas') }}', 'fa-cogs')">
                            <div class="flex items-center flex-1"><i class="fas fa-cogs"></i><span>Registro de Cuentas Contables</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Registro de Cuentas Contables', 'administracion', 'fa-cogs', this)"></i>
                            </div>

                            <div class="sidebar-submenu-item" onclick="navigateTo('Registro de Cuentas Bancarias', 'administracion', '{{ route('cuentas.bancarias') }}', 'fa-university')">
                            <div class="flex items-center flex-1">
                            <i class="fas fa-university"></i><span>Registro de Cuentas Bancarias</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Registro de Cuentas Bancarias', 'administracion', 'fa-university', this)"></i>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-estados')">
                        <span><i class="fas fa-chart-line"></i> Estados Financieros</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="contabilidad-estados" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Resultados', 'contabilidad', '{{ route('conta.estados') }}', 'fa-chart-pie')">
                            <div class="flex items-center flex-1"><i class="fas fa-chart-pie"></i><span>Estado de Resultados</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Resultados', 'contabilidad', 'fa-chart-pie', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Balance General', 'contabilidad', '{{ route('conta.balance') }}', 'fa-balance-scale')">
                            <div class="flex items-center flex-1"><i class="fas fa-balance-scale"></i><span>Balance General</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Balance General', 'contabilidad', 'fa-balance-scale', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Balance de Comprobación', 'contabilidad', '{{ route('conta.comprobacion') }}', 'fa-check-double')">
                            <div class="flex items-center flex-1"><i class="fas fa-check-double"></i><span>Balance de Comprobación</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Balance de Comprobación', 'contabilidad', 'fa-check-double', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Flujo de Efectivo', 'contabilidad', '{{ route('conta.flujo') }}', 'fa-money-bill-wave')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-bill-wave"></i><span>Estado de Flujo de Efectivo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Flujo de Efectivo', 'contabilidad', 'fa-money-bill-wave', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto', 'contabilidad', '{{ route('conta.capital') }}', 'fa-exchange-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-exchange-alt"></i><span>Presupuesto</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto', 'contabilidad', 'fa-exchange-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Unidad de Negocio', 'contabilidad', '{{ route('conta.unidad') }}', 'fa-chart-column')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-chart-column"></i><span>Estado de Resultado Unidad de Negocio</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Unidad de Negocio', 'contabilidad', 'fa-chart-column', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Resultado Liquidacion', 'contabilidad', '{{ route('conta.liquidacion') }}', 'fa-chart-pie')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-chart-pie"></i><span>Estado de Resultados Liquidacion</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Resultado Liquidacion', 'contabilidad', 'fa-chart-pie', this)"></i>
                        </div> -->
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Estado de Resultado General', 'contabilidad', '{{ route('conta.general') }}', 'fa-newspaper')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-newspaper"></i><span>Estado de Resultado General</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estado de Resultado General', 'contabilidad', 'fa-newspaper', this)"></i>
                        </div> -->
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-registro')">
                        <span><i class="fas fa-book"></i> Registro Contable</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="contabilidad-registro" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Pólizas Contables', 'contabilidad', '{{ route('conta.polizas') }}', 'fa-file-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-alt"></i><span>Pólizas Contables</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pólizas Contables', 'contabilidad', 'fa-file-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Diario General', 'contabilidad', '{{ route('conta.diario') }}', 'fa-book')">
                            <div class="flex items-center flex-1"><i class="fas fa-book"></i><span>Diario General</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Diario General', 'contabilidad', 'fa-book', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cobranza', 'contabilidad', '{{ route('conta.cobranza') }}', 'fa-columns')">
                            <div class="flex items-center flex-1"><i class="fas fa-columns"></i><span>Cobranza</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cobranza', 'contabilidad', 'fa-columns', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-catalogo')">
                        <span><i class="fas fa-list-alt"></i> Catálogo Contable</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="contabilidad-catalogo" class="sidebar-submenu">
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Cuentas Contables', 'contabilidad', '{{ route('conta.cuentas') }}', 'fa-list')">
                            <div class="flex items-center flex-1"><i class="fas fa-list"></i><span>Cuentas Contables</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cuentas Contables', 'contabilidad', 'fa-list', this)"></i>
                        </div> -->
                        <div class="sidebar-submenu-item" onclick="navigateTo('Auxiliar de Cuentas', 'contabilidad', '{{ route('conta.auxiliar') }}', 'fa-indent')">
                            <div class="flex items-center flex-1"><i class="fas fa-indent"></i><span>Auxiliar de Cuentas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Auxiliar de Cuentas', 'contabilidad', 'fa-indent', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Centros de Costos', 'contabilidad', '{{ route('conta.centros') }}', 'fa-sitemap')">
                            <div class="flex items-center flex-1"><i class="fas fa-sitemap"></i><span>Centros de Costos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Centros de Costos', 'contabilidad', 'fa-sitemap', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Configuración Contable', 'contabilidad', '{{ route('conta.configuraciones') }}', 'fa-cogs')">
                            <div class="flex items-center flex-1"><i class="fas fa-cogs"></i><span>Configuración Contable</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Configuración Contable', 'contabilidad', 'fa-cogs', this)"></i>
                        </div> -->
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-proyecto')">
                        <span><i class="fas fa-project-diagram"></i> Contabilidad por Proyecto</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="contabilidad-proyecto" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Costos por Obra', 'contabilidad', '{{ route('conta.costo') }}', 'fa-hard-hat')">
                            <div class="flex items-center flex-1"><i class="fas fa-hard-hat"></i><span>Costos por Obra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos por Obra', 'contabilidad', 'fa-hard-hat', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Gastos Indirectos de Obra', 'contabilidad', '{{ route('conta.gastos') }}', 'fa-tools')">
                            <div class="flex items-center flex-1"><i class="fas fa-tools"></i><span>Gastos Indirectos de Obra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Gastos Indirectos de Obra', 'contabilidad', 'fa-tools', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Gastos por Proyecto', 'contabilidad', '{{ route('conta.asignacion') }}', 'fa-project-diagram')">
                            <div class="flex items-center flex-1"><i class="fas fa-project-diagram"></i><span>Asignación de Gastos por Proyecto</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Gastos por Proyecto', 'contabilidad', 'fa-project-diagram', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Cierre de Proyectos', 'contabilidad', '{{ route('conta.cierre') }}', 'fa-lock')">
                            <div class="flex items-center flex-1"><i class="fas fa-lock"></i><span>Cierre de Proyectos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cierre de Proyectos', 'contabilidad', 'fa-lock', this)"></i>
                        </div> -->
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('contabilidad-fiscal')">
                        <span><i class="fas fa-file-contract"></i> Fiscal</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="contabilidad-fiscal" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('DIOT', 'contabilidad', '{{ route('conta.diot') }}', 'fa-file-export')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-export"></i><span>DIOT</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('DIOT', 'contabilidad', 'fa-file-export', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Declaraciones Mensuales', 'contabilidad', '{{ route('conta.declaraciones') }}', 'fa-calendar-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-calendar-alt"></i><span>Declaraciones Mensuales</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Declaraciones Mensuales', 'contabilidad', 'fa-calendar-alt', this)"></i>
                        </div> -->
                        <div class="sidebar-submenu-item" onclick="navigateTo('Retenciones (ISR, IVA)', 'contabilidad', '{{ route('conta.retenciones') }}', 'fa-percentage')">
                            <div class="flex items-center flex-1"><i class="fas fa-percentage"></i><span>Retenciones (ISR, IVA)</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Retenciones (ISR, IVA)', 'contabilidad', 'fa-percentage', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Complemento de Pagos', 'contabilidad', '{{ route('conta.complemento') }}', 'fa-money-check-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-check-alt"></i><span>Complemento de Pagos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Complemento de Pagos', 'contabilidad', 'fa-money-check-alt', this)"></i>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-gestion')">
                        <span><i class="fas fa-tasks"></i> Gestión de Proyectos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-gestion" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cartera de Proyectos', 'proyectos', '{{ route('proyectos.cartera') }}', 'fa-briefcase')">
                            <div class="flex items-center flex-1"><i class="fas fa-briefcase"></i><span>Cartera de Proyectos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cartera de Proyectos', 'proyectos', 'fa-briefcase', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Alta de Proyecto', 'proyectos', '{{ route('proyectos.alta') }}', 'fa-plus-circle')">
                            <div class="flex items-center flex-1"><i class="fas fa-plus-circle"></i><span>Alta de Proyecto</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Alta de Proyecto', 'proyectos', 'fa-plus-circle', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cronograma y Hitos', 'proyectos', '{{route ('proyectos.hitos') }}', 'fa-calendar-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-calendar-alt"></i><span>Cronograma y Hitos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cronograma y Hitos', 'proyectos', 'fa-calendar-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Obra', 'proyectos', '{{ route('proyectos.bitacora') }}', 'fa-book')">
                            <div class="flex items-center flex-1"><i class="fas fa-book"></i><span>Bitácora de Obra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Obra', 'proyectos', 'fa-book', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-licitaciones')">
                        <span><i class="fas fa-gavel"></i> Licitaciones</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-licitaciones" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Licitaciones Activas', 'proyectos', '{{ route('proyectos.activas') }}', 'fa-gavel')">
                            <div class="flex items-center flex-1"><i class="fas fa-gavel"></i><span>Licitaciones Activas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Licitaciones Activas', 'proyectos', 'fa-gavel', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cotizaciones', 'proyectos', '{{ route('proyectos.presupuestos') }}', 'fa-file-contract')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-contract"></i><span>Cotizaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cotizaciones', 'proyectos', 'fa-file-contract', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Análisis de Precios Unitarios', 'proyectos', '{{ route('proyectos.analisis') }}', 'fa-calculator')">
                            <div class="flex items-center flex-1"><i class="fas fa-calculator"></i><span>Análisis de Precios Unitarios</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Análisis de Precios Unitarios', 'proyectos', 'fa-calculator', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-presupuestos')">
                        <span><i class="fas fa-file-invoice-dollar"></i> Presupuestos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-presupuestos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Presupuesto por Proyecto', 'proyectos', '{{ route('proyectos.presupuesto_proyecto') }}', 'fa-file-invoice-dollar')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-invoice-dollar"></i><span>Presupuesto por Proyecto</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Presupuesto por Proyecto', 'proyectos', 'fa-file-invoice-dollar', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-costos')">
                        <span><i class="fas fa-money-bill-wave"></i> Costos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-costos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Costos Directos', 'proyectos', '{{ route('proyectos.directos') }}', 'fa-money-bill-wave')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-bill-wave"></i><span>Costos Directos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos Directos', 'proyectos', 'fa-money-bill-wave', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Costos Indirectos', 'proyectos', '{{ route('proyectos.indirectos') }}', 'fa-tools')">
                            <div class="flex items-center flex-1"><i class="fas fa-tools"></i><span>Costos Indirectos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Costos Indirectos', 'proyectos', 'fa-tools', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-avances')">
                        <span><i class="fas fa-hard-hat"></i> Avances de Obra</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-avances" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Estimaciones', 'proyectos', '{{ route('proyectos.estimaciones') }}', 'fa-calculator')">
                            <div class="flex items-center flex-1"><i class="fas fa-calculator"></i><span>Estimaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Estimaciones', 'proyectos', 'fa-calculator', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Reporte Fotográfico', 'proyectos', '{{ route('proyectos.reportes') }}', 'fa-camera')">
                            <div class="flex items-center flex-1"><i class="fas fa-camera"></i><span>Reporte Fotográfico</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Reporte Fotográfico', 'proyectos', 'fa-camera', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-personal')">
                        <span><i class="fas fa-users"></i> Personal</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-personal" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asignación a Proyectos', 'proyectos', '{{ route('proyectos.asignada') }}', 'fa-user-check')">
                            <div class="flex items-center flex-1"><i class="fas fa-user-check"></i><span>Asignación a Proyectos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación a Proyectos', 'proyectos', 'fa-user-check', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asistencia y Cuadrillas', 'proyectos', '{{ route('proyectos.flotillas') }}', 'fa-users')">
                            <div class="flex items-center flex-1"><i class="fas fa-users"></i><span>Asistencia y Cuadrillas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asistencia y Cuadrillas', 'proyectos', 'fa-users', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-maquinaria')">
                        <span><i class="fas fa-tractor"></i> Maquinaria y Equipo</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-maquinaria" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Equipo', 'proyectos', '{{ route('proyectos.asignacion') }}', 'fa-tractor')">
                            <div class="flex items-center flex-1"><i class="fas fa-tractor"></i><span>Asignación de Equipo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Equipo', 'proyectos', 'fa-tractor', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Mantenimiento de Equipo', 'proyectos', '{{ route('proyectos.mantenimiento') }}', 'fa-tools')">
                            <div class="flex items-center flex-1"><i class="fas fa-tools"></i><span>Mantenimiento de Equipo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Mantenimiento de Equipo', 'proyectos', 'fa-tools', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Uso', 'proyectos', '{{ route('proyectos.bita') }}', 'fa-book')">
                            <div class="flex items-center flex-1"><i class="fas fa-book"></i><span>Bitácora de Uso</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'proyectos', 'fa-book', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-riesgos')">
                        <span><i class="fas fa-exclamation-triangle"></i> Control de Riesgos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-riesgos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Desviaciones (Costo y Tiempo)', 'proyectos', '{{ route('proyectos.desviaciones') }}', 'fa-exclamation-triangle')">
                            <div class="flex items-center flex-1"><i class="fas fa-exclamation-triangle"></i><span>Desviaciones (Costo y Tiempo)</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Desviaciones (Costo y Tiempo)', 'proyectos', 'fa-exclamation-triangle', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Control de Calidad', 'proyectos', '{{ route('proyectos.control') }}', 'fa-clipboard-check')">
                            <div class="flex items-center flex-1"><i class="fas fa-clipboard-check"></i><span>Control de Calidad</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Calidad', 'proyectos', 'fa-clipboard-check', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('proyectos-documentacion')">
                        <span><i class="fas fa-folder"></i> Documentación</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="proyectos-documentacion" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Contratos y Planos', 'proyectos', '{{ route('proyectos.planos') }}', 'fa-file-contract')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-contract"></i><span>Contratos y Planos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Contratos y Planos', 'proyectos', 'fa-file-contract', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Permisos', 'proyectos', '{{ route('proyectos.permisos') }}', 'fa-file-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-alt"></i><span>Permisos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Permisos', 'proyectos', 'fa-file-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Evidencias (Fotos, Actas)', 'proyectos', '{{ route('proyectos.evidencia') }}', 'fa-camera')">
                            <div class="flex items-center flex-1"><i class="fas fa-camera"></i><span>Evidencias (Fotos, Actas)</span></div>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-personal')">
                        <span><i class="fas fa-user-tie"></i> Gestión de Personal</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-personal" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Plantilla de Empleados', 'rrhh', '{{ route('rh.plantilla') }}', 'fa-users')">
                            <div class="flex items-center flex-1"><i class="fas fa-users"></i><span>Plantilla de Empleados</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Plantilla de Empleados', 'rrhh', 'fa-users', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Expediente Digital', 'rrhh', '{{ route('rh.expediente') }}', 'fa-folder')">
                            <div class="flex items-center flex-1"><i class="fas fa-folder"></i><span>Incidencias</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Expediente Digital', 'rrhh', 'fa-folder', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-asistencia')">
                        <span><i class="fas fa-user-clock"></i> Asistencia y Control</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-asistencia" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asistencia', 'rrhh', '{{ route('rh.asistencia') }}', 'fa-user-clock')">
                            <div class="flex items-center flex-1"><i class="fas fa-user-clock"></i><span>Asistencia</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asistencia', 'rrhh', 'fa-user-clock', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Lista de Asistencia', 'rrhh', '{{ route('rh.lista') }}', 'fa-list')">
                            <div class="flex items-center flex-1"><i class="fas fa-list"></i><span>Lista de Asistencia</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Lista de Asistencia', 'rrhh', 'fa-list', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Justificantes y Permisos', 'rrhh', '{{ route ('rh.justificantes') }}', 'fa-file-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-alt"></i><span>Justificantes y Permisos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Justificantes y Permisos', 'rrhh', 'fa-file-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Control de Horarios', 'rrhh', '{{ route('rh.control') }}', 'fa-clock')">
                            <div class="flex items-center flex-1"><i class="fas fa-clock"></i><span>Control de Horarios</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Horarios', 'rrhh', 'fa-clock', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-nomina')">
                        <span><i class="fas fa-money-check-alt"></i> Nómina</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-nomina" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Cálculo de Nómina', 'rrhh', '{{ route('rh.calculo') }}', 'fa-calculator')">
                            <div class="flex items-center flex-1"><i class="fas fa-calculator"></i><span>Cálculo de Nómina</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Cálculo de Nómina', 'rrhh', 'fa-calculator', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Pagos de Nómina', 'rrhh', '{{ route('rh.pagos') }}', 'fa-money-check-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-check-alt"></i><span>Pagos de Nómina</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Pagos de Nómina', 'rrhh', 'fa-money-check-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Recibos de Nómina (Timbrado)', 'rrhh', '{{ route('rh.recibos') }}', 'fa-file-invoice-dollar')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-invoice-dollar"></i><span>Recibos de Nómina (Timbrado)</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Recibos de Nómina (Timbrado)', 'rrhh', 'fa-file-invoice-dollar', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-prestaciones')">
                        <span><i class="fas fa-hand-holding-usd"></i> Prestaciones y Descuentos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-prestaciones" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Préstamos', 'rrhh', '{{ route('rh.prestamos.index') }}', 'fa-hand-holding-usd')">
                            <div class="flex items-center flex-1"><i class="fas fa-hand-holding-usd"></i><span>Préstamos y Descuentos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Préstamos', 'rrhh', 'fa-hand-holding-usd', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Vacaciones', 'rrhh', '{{ route('rh.vacaciones.index') }}', 'fa-umbrella-beach')">
                            <div class="flex items-center flex-1"><i class="fas fa-umbrella-beach"></i><span>Vacaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Vacaciones', 'rrhh', 'fa-umbrella-beach', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Finiquitos y Liquidaciones', 'rrhh', '{{ route('rh.finiquito.index') }}', 'fa-file-contract')">
                            <div class="flex items-center flex-1"><i class="fas fa-file-contract"></i><span>Finiquitos y Liquidaciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Finiquitos y Liquidaciones', 'rrhh', 'fa-file-contract', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-unidades')">
                        <span><i class="fas fa-car"></i> Unidades y Flotilla</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-unidades" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Semáforo de Documentos de Unidades', 'rrhh', '{{ route('rh.semaforos_unidades') }}', 'fa-traffic-light')">
                            <div class="flex items-center flex-1"><i class="fas fa-traffic-light"></i><span>Semáforo de Documentos de Unidades</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Semáforo de Documentos de Unidades', 'rrhh', 'fa-traffic-light', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Asignación de Flotilla', 'rrhh', '{{ route('rh.flotillas') }}', 'fa-car')">
                            <div class="flex items-center flex-1"><i class="fas fa-car"></i><span>Asignación de Flotilla</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Asignación de Flotilla', 'rrhh', 'fa-car', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Control de Vehículos', 'rrhh', '{{ route('rh.carros') }}', 'fa-tachometer-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-tachometer-alt"></i><span>Control de Vehículos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Control de Vehículos', 'rrhh', 'fa-tachometer-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Bitácora de Uso', 'rrhh', '{{ route('rh.bitacora') }}', 'fa-book')">
                            <div class="flex items-center flex-1"><i class="fas fa-book"></i><span>Bitácora de Uso</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Bitácora de Uso', 'rrhh', 'fa-book', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-catalogos')">
                        <span><i class="fas fa-list"></i> Catálogos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-catalogos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Roles y Puestos', 'rrhh', '{{ route('rh.roles') }}', 'fa-user-tag')">
                            <div class="flex items-center flex-1"><i class="fas fa-user-tag"></i><span>Roles y Puestos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Roles y Puestos', 'rrhh', 'fa-user-tag', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Áreas y Departamentos', 'rrhh', '{{ route('rh.areas') }}', 'fa-sitemap')">
                            <div class="flex items-center flex-1"><i class="fas fa-sitemap"></i><span>Áreas y Departamentos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Áreas y Departamentos', 'rrhh', 'fa-sitemap', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Usuarios', 'rrhh', '{{ route('rh.turnos') }}', 'fa-clock')">
                            <div class="flex items-center flex-1"><i class="fas fa-clock"></i><span>Usuarios</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Usuarios', 'rrhh', 'fa-clock', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('rrhh-reportes')">
                        <span><i class="fas fa-chart-bar"></i> Reportes</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="rrhh-reportes" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Costos de Nómina por Proyecto', 'rrhh', '{{ route ('rh.costos') }}', 'fa-money-bill-wave')">
                            <div class="flex items-center flex-1"><i class="fas fa-money-bill-wave"></i><span>Costos de Nómina por Proyecto</span></div>
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
                    <h2>Almacen</h2>
                </div>
                <button onclick="closeSectionSidebar()" class="section-sidebar-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="section-sidebar-content">
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-catalogos')">
                        <span><i class="fas fa-warehouse"></i> Catálogos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="inventarios-catalogos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Almacenes', 'inventarios', '{{ route('almacen.almacen') }}', 'fa-warehouse')">
                            <div class="flex items-center flex-1"><i class="fas fa-warehouse"></i><span>Catálogo de Almacenes</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Almacenes', 'inventarios', 'fa-warehouse', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Materiales', 'inventarios', '{{ route('almacen.articulo') }}', 'fa-box')">
                            <div class="flex items-center flex-1"><i class="fas fa-box"></i><span>Catálogo de Articulos</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Materiales', 'inventarios', 'fa-box', this)"></i>
                        </div>
                        <!-- ======================================================================================== -->

                        <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Activos', 'almacen', '{{ route('almacen.activos') }}', 'fa-tools')">
                                <div class="flex items-center flex-1"><i class="fas fa-tools"></i><span>Catálogo de Activos</span></div>
                                <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Activos', 'almacen', 'fa-tools', this)"></i>
                        </div>

                        <!-- ========================================================================================== -->
                        <div class="sidebar-submenu-item" onclick="navigateTo('Catálogo de Familias', 'inventarios', '{{ route('almacen.familias') }}', 'fa-book-open-reader')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-book-open-reader"></i><span>Catálogo de Familias</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Catálogo de Familias', 'inventarios', 'fa-book-open-reader', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-existencias')">
                        <span><i class="fas fa-clipboard-list"></i> Existencias</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="inventarios-existencias" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Existencias por Almacén', 'inventarios', '{{ route('almacen.inventario') }}', 'fa-clipboard-list')">
                            <div class="flex items-center flex-1"><i class="fas fa-clipboard-list"></i><span>Existencias por Almacén</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Existencias por Almacén', 'inventarios', 'fa-clipboard-list', this)"></i>
                        </div>
                            <div class="sidebar-submenu-item" onclick="navigateTo('Requisición', 'inventarios', '{{ route('almacen.requisicion') }}', 'fa-truck-fast')">
                                <div class="flex items-center flex-1"><i class="fa-solid fa-truck-fast"></i><span>Requisición</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Requisición', 'inventarios', 'fa-truck-fast', this)"></i>
                        </div>
                        <!-- <div class="sidebar-submenu-item" onclick="navigateTo('Vales de Equipo', 'inventarios', '{{ route('almacen.vales') }}', 'fa-stream')">
                            <div class="flex items-center flex-1"><i class="fas fa-stream"></i><span>Vales de equipo</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Vales de Equipo', 'inventarios', 'fa-stream', this)"></i>
                        </div> -->
                    </div>
                </div>



                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('inventarios-movimientos')">
                        <span><i class="fas fa-exchange-alt"></i> Movimientos</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="inventarios-movimientos" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Entradas y Salidas', 'inventarios', '{{ route('almacen.entrada') }}', 'fa-exchange-alt')">
                            <div class="flex items-center flex-1"><i class="fas fa-exchange-alt"></i><span>Entradas y Salidas</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Entradas y Salidas', 'inventarios', 'fa-exchange-alt', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Traspasos entre Almacenes', 'inventarios', '{{ route('almacen.traspasos') }}', 'fa-truck-moving')">
                            <div class="flex items-center flex-1"><i class="fas fa-truck-moving"></i><span>Traspasos entre Almacenes</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Traspasos entre Almacenes', 'inventarios', 'fa-truck-moving', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Requisiciones y Devoluciones', 'inventarios', '{{ route('almacen.requisiciones_devoluciones_equipo') }}', 'fa-adjust')">
                            <div class="flex items-center flex-1"><i class="fas fa-adjust"></i><span>Requisiciones de equipo y Devoluciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Requisiciones y Devoluciones', 'inventarios', 'fa-adjust', this)"></i>
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
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-requisiciones')">
                        <span><i class="fas fa-clipboard-check"></i> Requisiciones</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="compras-requisiciones" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Requisiciones', 'compras', '{{ route('compras.requisicion') }}', 'fa-clipboard-check')">
                            <div class="flex items-center flex-1"><i class="fas fa-clipboard-check"></i><span>Requisiciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Requisiciones', 'compras', 'fa-clipboard-check', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Autorizacion de Requisiciones', 'compras', '{{ route('compras.autorizacion') }}', 'fa-square-check')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-square-check"></i><span>Autorizacion de Requisiciones</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Autorizacion de Requisiciones', 'compras', 'fa-square-check', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-ordenes')">
                        <span><i class="fas fa-shopping-cart"></i> Órdenes de Compra</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="compras-ordenes" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Órdenes de Compra', 'compras', '{{ route('compras.ordenes') }}', 'fa-shopping-cart')">
                            <div class="flex items-center flex-1"><i class="fas fa-shopping-cart"></i><span>Órdenes de Compra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Órdenes de Compra', 'compras', 'fa-shopping-cart', this)"></i>
                        </div>
                        <div class="sidebar-submenu-item" onclick="navigateTo('Autorizacion de Órdenes de Compra', 'compras', '{{ route('compras.autorizacion-cotizaciones') }}', 'fa-circle-check')">
                            <div class="flex items-center flex-1"><i class="fa-solid fa-circle-check"></i><span>Autorizacion de Órdenes de Compra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Autorizacion de Órdenes de Compra', 'compras', 'fa-circle-check', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-subcontratistas')">
                        <span><i class="fas fa-handshake"></i> Proveedores</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="compras-subcontratistas" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Proveedores', 'compras', '{{ route('compras.gestion') }}', 'fa-handshake')">
                            <div class="flex items-center flex-1"><i class="fas fa-handshake"></i><span>Proveedores</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Proveedores', 'compras', 'fa-handshake', this)"></i>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu-group">
                    <div class="sidebar-menu-title" onclick="toggleSubmenu('compras-almacen')">
                        <span><i class="fas fa-warehouse"></i> Almacén por Obra</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div id="compras-almacen" class="sidebar-submenu">
                        <div class="sidebar-submenu-item" onclick="navigateTo('Almacén por Obra', 'compras', '{{ route('compras.almacen') }}', 'fa-warehouse')">
                            <div class="flex items-center flex-1"><i class="fas fa-warehouse"></i><span>Almacén por Obra</span></div>
                            <i class="fas fa-star favorite-star" onclick="event.stopPropagation(); toggleFavorite('Almacén por Obra', 'compras', 'fa-warehouse', this)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BARRA LATERAL DE FAVORITOS -->
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

        <!-- PIE DE PÁGINA -->
        <footer class="app-footer bg-construction-dark text-white py-6 px-4 mt-8">
            <div class="container mx-auto text-center">
                <p class="text-white text-sm">
                    &copy; {{ date('Y') }} MejoraSoft - Todos los derechos reservados.
                </p>
            </div>
        </footer>
    </div>

    <script>
        // ========== VARIABLES GLOBALES ==========
        let currentSection = null;
        let mobileMenuOpen = false;
        let quickAccess = JSON.parse(localStorage.getItem('quickAccess')) || [];

        // ========== TAB MANAGER ==========
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
                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && e.key === 'w') {
                        e.preventDefault();
                        if (this.activeTabId) this.closeTab(this.activeTabId);
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
                        if (!this.isNavigating) this.navigateToUrl(url);
                        return;
                    }
                }
                const tab = {
                    id: 'tab_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                    title: title, section: section, icon: icon || 'fa-file', url: url,
                    timestamp: new Date().toISOString(),
                    favicon: this.getFaviconForSection(section, icon)
                };
                this.tabs.push(tab);
                this.activateTab(tab.id);
                this.saveTabs();
                this.render();
                if (url && url !== '#' && url !== '{{ route('home') }}' && !this.isNavigating) this.navigateToUrl(url);
            }

            getFaviconForSection(section, icon) {
                const iconMap = {'bi':'fa-chart-line','administracion':'fa-money-bill-wave','contabilidad':'fa-calculator','proyectos':'fa-project-diagram','rrhh':'fa-users','inventarios':'fa-boxes','compras':'fa-shopping-cart','home':'fa-home'};
                return icon || iconMap[section] || 'fa-file';
            }

            activateTab(tabId) { this.activeTabId = tabId; localStorage.setItem('activeTabId', tabId); this.render(); }

            closeTab(tabId) {
                try {
                    const tabIndex = this.tabs.findIndex(t => t && t.id === tabId);
                    if (tabIndex === -1) { this.forceCleanTabs(); return false; }
                    this.tabs.splice(tabIndex, 1);
                    if (this.tabs.length === 0) {
                        this.activeTabId = null;
                        localStorage.removeItem('activeTabId');
                        localStorage.setItem('appTabs', '[]');
                        if (window.location.href !== '{{ route('home') }}') window.location.href = '{{ route('home') }}';
                        this.render();
                        return true;
                    }
                    if (this.activeTabId === tabId) {
                        const newActiveIndex = Math.min(tabIndex, this.tabs.length - 1);
                        const newActiveTab = this.tabs[newActiveIndex];
                        this.activeTabId = newActiveTab.id;
                        if (newActiveTab.url && newActiveTab.url !== '#' && newActiveTab.url !== '{{ route('home') }}') window.location.href = newActiveTab.url;
                    }
                    this.saveTabs();
                    this.render();
                    return true;
                } catch (error) { this.forceCleanTabs(); return false; }
            }

            forceCleanTabs() { this.tabs = []; this.activeTabId = null; localStorage.removeItem('appTabs'); localStorage.removeItem('activeTabId'); const container = document.getElementById('tabsNavContainer'); if(container) container.innerHTML = '<div class="text-white text-sm px-3 opacity-70">No hay pestañas abiertas</div>'; if(window.location.pathname !== '/home' && !window.location.href.includes('home')) window.location.href = '{{ route('home') }}'; }

            closeAllTabs() { if(this.tabs.length===0) return; if(confirm('¿Estás seguro de que deseas cerrar todas las pestañas?')){ this.tabs=[]; this.activeTabId=null; localStorage.removeItem('appTabs'); localStorage.removeItem('activeTabId'); this.render(); window.location.href='{{ route('home') }}'; this.showNotification('Todas las pestañas han sido cerradas','info'); return true; } return false; }

            saveTabs() { localStorage.setItem('appTabs', JSON.stringify(this.tabs)); }

            render() {
                const container = document.getElementById('tabsNavContainer');
                if (!container) return;
                if (!Array.isArray(this.tabs)) this.tabs = [];
                this.tabs = this.tabs.filter(tab => tab && tab.id && tab.title);
                if (this.tabs.length === 0) { container.innerHTML = '<div class="text-white text-sm px-3 opacity-70">No hay pestañas abiertas</div>'; return; }
                let html = '';
                this.tabs.forEach((tab, index) => {
                    if (!tab || !tab.id) return;
                    const isActive = tab.id === this.activeTabId;
                    const icon = tab.favicon || tab.icon || 'fa-file';
                    const title = tab.title || 'Sin título';
                    html += `<div class="tab-item group relative inline-flex items-center px-3 py-1 mr-2 text-sm cursor-pointer transition-colors duration-150 ${isActive ? 'text-gray-900 font-medium' : 'text-white hover:text-gray-200'}" data-tab-id="${tab.id}" data-tab-index="${index}" onclick="tabManager.handleTabClick('${tab.id}', '${tab.url || ''}')" oncontextmenu="tabManager.showTabContextMenu(event, '${tab.id}')"><i class="fas ${icon} mr-2 ${isActive ? 'text-gray-900' : 'text-white'}"></i><span class="max-w-xs truncate">${this.escapeHtml(title)}</span><button class="close-tab ml-2 p-1 rounded-full hover:bg-white hover:bg-opacity-20 transition-colors opacity-0 group-hover:opacity-100" onclick="event.stopPropagation(); tabManager.closeTab('${tab.id}')" title="Cerrar pestaña (Ctrl+W)"><i class="fas fa-times text-xs ${isActive ? 'text-gray-600' : 'text-white'}"></i></button></div>`;
                });
                container.innerHTML = html;
            }

            escapeHtml(text) { if(!text) return ''; const div = document.createElement('div'); div.textContent = text; return div.innerHTML; }
            handleTabClick(tabId, url) { this.activateTab(tabId); if(url && url!=='#' && url!=='{{ route('home') }}' && !this.isNavigating){ const currentUrl=window.location.href; const tabPath=url.split('?')[0].split('#')[0]; const currentPath=currentUrl.split('?')[0].split('#')[0]; if(tabPath!==currentPath) this.navigateToUrl(url); } }
            showTabContextMenu(event, tabId) { event.preventDefault(); const existingMenu=document.querySelector('.tab-context-menu'); if(existingMenu) existingMenu.remove(); const tab=this.tabs.find(t=>t.id===tabId); if(!tab) return; const menu=document.createElement('div'); menu.className='tab-context-menu fixed bg-white rounded-lg shadow-xl py-2 z-[1100] min-w-[200px] text-sm border border-gray-200'; menu.style.left=event.pageX+'px'; menu.style.top=event.pageY+'px'; menu.innerHTML=`<div class="px-4 py-2 border-b border-gray-100 bg-gray-50"><div class="font-semibold text-gray-700">${tab.title}</div><div class="text-xs text-gray-500 mt-1">${new Date(tab.timestamp).toLocaleString()}</div></div><button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.duplicateTab('${tab.id}')"><i class="fas fa-copy w-5 text-gray-500"></i><span class="ml-2">Duplicar pestaña</span></button><button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.closeOtherTabs('${tab.id}')"><i class="fas fa-times-circle w-5 text-gray-500"></i><span class="ml-2">Cerrar otras pestañas</span></button><button class="context-menu-item w-full text-left px-4 py-2 hover:bg-blue-50 flex items-center" onclick="tabManager.closeTabsToTheRight('${tab.id}')"><i class="fas fa-arrow-right w-5 text-gray-500"></i><span class="ml-2">Cerrar pestañas a la derecha</span></button><div class="border-t border-gray-100 my-1"></div><button class="context-menu-item w-full text-left px-4 py-2 hover:bg-red-50 flex items-center text-red-600" onclick="tabManager.closeTab('${tab.id}')"><i class="fas fa-trash-alt w-5"></i><span class="ml-2">Cerrar pestaña</span></button><button class="context-menu-item w-full text-left px-4 py-2 hover:bg-red-50 flex items-center text-red-600" onclick="tabManager.closeAllTabs()"><i class="fas fa-times-circle w-5"></i><span class="ml-2">Cerrar todas las pestañas</span></button>`; document.body.appendChild(menu); const closeMenu=(e)=>{ if(!menu.contains(e.target)){ menu.remove(); document.removeEventListener('click',closeMenu); } }; setTimeout(()=>document.addEventListener('click',closeMenu),100); }
            duplicateTab(tabId) { const originalTab=this.tabs.find(t=>t.id===tabId); if(!originalTab) return; if(this.tabs.length>=this.maxTabs){ this.showNotification(`Límite de ${this.maxTabs} pestañas alcanzado`,'warning'); return; } const duplicate={...originalTab, id:'tab_'+Date.now()+'_'+Math.random().toString(36).substr(2,9), title:`${originalTab.title} (copia)`, timestamp:new Date().toISOString()}; this.tabs.push(duplicate); this.activateTab(duplicate.id); this.saveTabs(); this.render(); if(duplicate.url && duplicate.url!=='#' && duplicate.url!=='{{ route('home') }}' && !this.isNavigating){ const currentUrl=window.location.href; const tabPath=duplicate.url.split('?')[0].split('#')[0]; const currentPath=currentUrl.split('?')[0].split('#')[0]; if(tabPath!==currentPath) this.navigateToUrl(duplicate.url); } }
            closeOtherTabs(tabId) { const tabToKeep=this.tabs.find(t=>t.id===tabId); if(!tabToKeep) return; this.tabs=[tabToKeep]; this.activateTab(tabToKeep.id); this.saveTabs(); this.render(); if(tabToKeep.url && tabToKeep.url!=='#' && tabToKeep.url!=='{{ route('home') }}' && !this.isNavigating){ const currentUrl=window.location.href; const tabPath=tabToKeep.url.split('?')[0].split('#')[0]; const currentPath=currentUrl.split('?')[0].split('#')[0]; if(tabPath!==currentPath) this.navigateToUrl(tabToKeep.url); } this.showNotification('Otras pestañas cerradas','info'); }
            closeTabsToTheRight(tabId) { const tabIndex=this.tabs.findIndex(t=>t.id===tabId); if(tabIndex===-1) return; this.tabs=this.tabs.slice(0,tabIndex+1); this.activateTab(tabId); this.saveTabs(); this.render(); }
            showNotification(message, type='info') { const notification=document.createElement('div'); const bgColor=type==='success'?'bg-green-600':type==='warning'?'bg-yellow-600':type==='error'?'bg-red-600':'bg-blue-600'; notification.className=`fixed top-20 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-[1100] text-sm flex items-center`; notification.innerHTML=`<i class="fas ${type==='success'?'fa-check-circle':type==='warning'?'fa-exclamation-triangle':'fa-info-circle'} mr-2"></i>${message}`; document.body.appendChild(notification); setTimeout(()=>{ notification.style.opacity='0'; setTimeout(()=>notification.remove(),300); },3000); }
        }

        function navigateTo(pageName, module, route, icon) { if(window.tabManager) window.tabManager.createNewTab(pageName, module, icon, route); closeSectionSidebar(); }
        function toggleSectionSidebar(section) { const sidebar=document.getElementById(`sidebar-${section}`); const mainContent=document.getElementById('mainContent'); const tabBar=document.querySelector('.tab-navigation-bar'); if(!sidebar) return; if(currentSection===section && sidebar.classList.contains('open')){ closeSectionSidebar(); return; } closeAllSectionSidebars(); sidebar.classList.add('open'); mainContent.classList.add('sidebar-open'); tabBar.classList.add('sidebar-open'); currentSection=section; if(window.innerWidth<=992) closeMobileMenu(); }
        function closeSectionSidebar() { document.querySelectorAll('.section-sidebar').forEach(s=>s.classList.remove('open')); document.getElementById('mainContent').classList.remove('sidebar-open'); document.querySelector('.tab-navigation-bar').classList.remove('sidebar-open'); currentSection=null; }
        function closeAllSectionSidebars() { document.querySelectorAll('.section-sidebar').forEach(s=>s.classList.remove('open')); }
        function toggleMobileMenu() { const sidebar=document.getElementById('mobileMenuSidebar'); const overlay=document.getElementById('mobileOverlay'); mobileMenuOpen=!mobileMenuOpen; if(mobileMenuOpen){ sidebar.classList.add('open'); overlay.classList.add('active'); document.body.style.overflow='hidden'; }else{ sidebar.classList.remove('open'); overlay.classList.remove('active'); document.body.style.overflow='auto'; } }
        function closeMobileMenu() { document.getElementById('mobileMenuSidebar').classList.remove('open'); document.getElementById('mobileOverlay').classList.remove('active'); document.body.style.overflow='auto'; mobileMenuOpen=false; }
        function toggleMobileSectionSidebar(section) { closeMobileMenu(); toggleSectionSidebar(section); }
        function toggleSubmenu(submenuId) { const submenu=document.getElementById(submenuId); const title=submenu?.previousElementSibling; if(submenu){ submenu.classList.toggle('expanded'); title?.classList.toggle('expanded'); } }
        function toggleQuickSidebar() { document.getElementById('quick-sidebar').classList.toggle('open'); if(window.innerWidth<=992) closeMobileMenu(); }
        function closeQuickSidebar() { document.getElementById('quick-sidebar').classList.remove('open'); }
        function toggleFavorite(title, module, icon, element) { const favorite={id:`${module}-${title}`.replace(/\s+/g,'-').toLowerCase(), title:title, module:module, icon:icon, path:`${module} > ${title}`, timestamp:new Date().toISOString()}; const existingIndex=quickAccess.findIndex(f=>f.id===favorite.id); if(existingIndex===-1){ quickAccess.push(favorite); element.classList.add('active'); showNotification(`⭐ "${title}" agregado a accesos rápidos`,'success'); }else{ quickAccess.splice(existingIndex,1); element.classList.remove('active'); showNotification(`❌ "${title}" eliminado de accesos rápidos`,'info'); } localStorage.setItem('quickAccess',JSON.stringify(quickAccess)); updateFavoritesUI(); updateFavoriteStars(); }
        function updateFavoritesUI() { const favoritesList=document.getElementById('favorites-list'); const emptyFavorites=document.getElementById('empty-favorites'); const favoriteCount=document.getElementById('favorite-count'); const notificationDot=document.getElementById('notification-dot'); if(quickAccess.length===0){ if(favoritesList) favoritesList.style.display='none'; if(emptyFavorites) emptyFavorites.style.display='block'; if(favoriteCount) favoriteCount.style.display='none'; if(notificationDot) notificationDot.style.display='none'; return; } const sortedFavorites=[...quickAccess].sort((a,b)=>new Date(b.timestamp)-new Date(a.timestamp)); let html=''; sortedFavorites.forEach(fav=>{ html+=`<div class="favorite-item" onclick="navigateTo('${fav.title}','${fav.module}','#','${fav.icon}')"><i class="fas ${fav.icon}"></i><div class="favorite-item-content"><div class="favorite-item-title">${fav.title}</div><div class="favorite-item-path">${fav.module}</div></div><div class="favorite-item-remove" onclick="event.stopPropagation(); removeFavorite('${fav.id}')"><i class="fas fa-times"></i></div></div>`; }); if(favoritesList){ favoritesList.innerHTML=html; favoritesList.style.display='block'; } if(emptyFavorites) emptyFavorites.style.display='none'; if(favoriteCount){ favoriteCount.textContent=quickAccess.length; favoriteCount.style.display='flex'; } if(notificationDot) notificationDot.style.display=quickAccess.length>0?'block':'none'; }
        function removeFavorite(favoriteId) { const index=quickAccess.findIndex(f=>f.id===favoriteId); if(index!==-1){ const removedTitle=quickAccess[index].title; quickAccess.splice(index,1); localStorage.setItem('quickAccess',JSON.stringify(quickAccess)); updateFavoritesUI(); updateFavoriteStars(); showNotification(`❌ "${removedTitle}" eliminado de accesos rápidos`,'info'); } }
        function updateFavoriteStars() { const stars=document.querySelectorAll('.favorite-star'); stars.forEach(star=>{ star.classList.remove('active'); const menuItem=star.closest('.sidebar-submenu-item'); if(menuItem){ const title=menuItem.querySelector('span:not(.favorite-star)')?.textContent?.trim()||''; const module=menuItem.closest('.section-sidebar')?.id?.replace('sidebar-','')||''; const favoriteId=`${module}-${title}`.replace(/\s+/g,'-').toLowerCase(); if(quickAccess.some(f=>f.id===favoriteId)) star.classList.add('active'); } }); }
        function showNotification(message, type='info') { const notification=document.createElement('div'); const bgColor=type==='success'?'bg-green-600':type==='error'?'bg-red-600':'bg-blue-600'; notification.className=`fixed top-20 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-[1100] text-sm flex items-center`; notification.innerHTML=`<i class="fas ${type==='success'?'fa-check-circle':'fa-info-circle'} mr-2"></i>${message}`; notification.style.animation='fadeIn 0.3s ease'; document.body.appendChild(notification); setTimeout(()=>{ notification.style.opacity='0'; setTimeout(()=>notification.remove(),300); },3000); }
        function confirmLogout() { const modal=document.getElementById('logout-confirm-modal'); if(modal){ modal.classList.remove('hidden'); modal.classList.add('flex'); }else{ if(confirm('¿Estás seguro de que deseas cerrar sesión?')) document.querySelector('form[action*="logout"]')?.submit(); } }

        function notifications() {
            return {
                isOpen: false, unreadCount: 0, filter: 'all', notifications: [],
                initNotifications() { this.notifications=[{id:1,title:'Bienvenido al sistema',message:'Has iniciado sesión correctamente',type:'info',priority:'low',read:false,timestamp:new Date().toISOString(),category:'Sistema'},{id:2,title:'Nuevo proyecto asignado',message:'Se te ha asignado el proyecto "Edificio Corporativo"',type:'success',priority:'high',read:false,timestamp:new Date(Date.now()-3600000).toISOString(),category:'Proyectos'}]; this.updateUnreadCount(); },
                toggleNotifications() { this.isOpen=!this.isOpen; },
                get filteredNotifications() { if(this.filter==='unread') return this.notifications.filter(n=>!n.read); if(this.filter==='important') return this.notifications.filter(n=>n.priority==='high'); return this.notifications; },
                markAsRead(id) { const notification=this.notifications.find(n=>n.id===id); if(notification){ notification.read=true; this.updateUnreadCount(); } },
                markAllAsRead() { this.notifications.forEach(n=>n.read=true); this.updateUnreadCount(); },
                clearAll() { this.notifications=[]; this.updateUnreadCount(); },
                updateUnreadCount() { this.unreadCount=this.notifications.filter(n=>!n.read).length; },
                getTypeIcon(type) { const icons={success:'fas fa-check-circle',error:'fas fa-exclamation-circle',warning:'fas fa-exclamation-triangle',info:'fas fa-info-circle'}; return icons[type]||'fas fa-bell'; },
                formatTime(timestamp) { const date=new Date(timestamp); const now=new Date(); const diff=Math.floor((now-date)/60000); if(diff<1) return 'Ahora'; if(diff<60) return `Hace ${diff} min`; if(diff<1440) return `Hace ${Math.floor(diff/60)} h`; return date.toLocaleDateString(); }
            };
        }

        function chatWidget() {
            return {
                isOpen: false, 
                users: [], 
                selectedUser: null, 
                messages: [], 
                newMessage: '', 
                unreadMessagesCount: 0, 
                pollingInterval: null,
                
                initChat() { 
                    console.log('🟢 Inicializando chat para usuario:', window.userId); 
                    this.fetchUsers(); 
                    this.pollingInterval = setInterval(() => { 
                        if(this.selectedUser && this.isOpen) this.loadConversation(this.selectedUser.id); 
                        this.fetchUsers(); 
                    }, 3000); 
                    
                    // Actualizar contador global periódicamente
                    this.updateGlobalUnreadCount();
                    setInterval(() => this.updateGlobalUnreadCount(), 5000);
                    
                    if(window.Echo && window.Echo.connector) { 
                        console.log('✅ Configurando listener WebSocket'); 
                        const setupListener = () => { 
                            if(window.Echo.connector.socket && window.Echo.connector.socket.readyState === 1) { 
                                window.Echo.private(`user.${window.userId}`).listen('MessageSent', (e) => { 
                                    console.log('📨 Mensaje en tiempo real:', e); 
                                    this.handleIncomingMessage(e.message, e.fromUser); 
                                }); 
                                console.log('✅ Listener configurado en canal user.' + window.userId); 
                            } else { 
                                setTimeout(setupListener, 500); 
                            } 
                        }; 
                        setupListener(); 
                    } else { 
                        console.warn('⚠️ Echo no disponible, usando solo polling'); 
                    } 
                },
                
                updateGlobalUnreadCount() {
                    fetch('/chat/unread-count', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.unreadMessagesCount = data.total_unread || 0;
                    })
                    .catch(error => console.error('Error fetching unread count:', error));
                },
                
                fetchUsers() { 
                    fetch('/chat/users', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if(!response.ok) throw new Error(`HTTP error! status: ${response.status}`); 
                        return response.json();
                    })
                    .then(data => { 
                        let usersArray = Array.isArray(data) ? data : (data.users || data.data || []); 
                        this.users = usersArray.map(user => ({
                            id: user.id,
                            name: user.name,
                            email: user.email,
                            unread: user.unread_count || 0
                        }));
                        
                        // Actualizar contador global
                        const totalUnread = this.users.reduce((sum, user) => sum + (user.unread || 0), 0);
                        this.unreadMessagesCount = totalUnread;
                    })
                    .catch(error => { 
                        console.error('Error fetching users:', error); 
                        this.users = [];
                    }); 
                },
                
                toggleChat() { 
                    this.isOpen = !this.isOpen; 
                    if(this.isOpen && this.selectedUser) {
                        this.markMessagesAsRead(this.selectedUser.id); 
                    }
                    if(this.isOpen) {
                        this.fetchUsers();
                    }
                },
                
                closeChat() { 
                    this.isOpen = false; 
                },
                
                selectUser(user) { 
                    this.selectedUser = user; 
                    this.loadConversation(user.id); 
                    this.markMessagesAsRead(user.id); 
                },
                
                backToList() { 
                    this.selectedUser = null; 
                    this.messages = []; 
                },
                
                closeConversation() { 
                    this.selectedUser = null; 
                    this.messages = []; 
                    this.newMessage = ''; 
                },
                
                loadConversation(userId) { 
                    fetch(`/chat/messages/${userId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if(!response.ok) throw new Error(`HTTP error! status: ${response.status}`); 
                        return response.json();
                    })
                    .then(data => { 
                        let messagesArray = Array.isArray(data) ? data : (data.messages || data.data || []); 
                        this.messages = messagesArray.map(msg => ({
                            id: msg.id,
                            text: msg.message || msg.text,
                            user_id: msg.user_id,
                            recipient_id: msg.recipient_id,
                            isOwn: msg.user_id === window.userId,
                            created_at: msg.created_at
                        })); 
                        this.$nextTick(() => {
                            const container = this.$refs.messagesContainer; 
                            if(container) container.scrollTop = container.scrollHeight;
                        });
                    })
                    .catch(error => { 
                        console.error('Error loading conversation:', error); 
                        this.messages = [];
                    }); 
                },
                
                sendMessage() { 
    if (!this.newMessage || !this.newMessage.trim() || !this.selectedUser) return;
    
    const messageText = this.newMessage.trim();
    const messageData = {
        recipient_id: this.selectedUser.id,
        message: messageText
    };
    
    // Guardar para posible reintento
    const sentMessage = messageText;
    const recipientId = this.selectedUser.id;
    
    // LIMPIAR INPUT INMEDIATAMENTE
    this.newMessage = '';
    
    // Agregar mensaje localmente (optimista)
    const tempMsg = {
        id: Date.now(),
        text: sentMessage,
        user_id: window.userId,
        recipient_id: recipientId,
        isOwn: true,
        created_at: new Date().toISOString()
    };
    this.messages.push(tempMsg);
    
    this.$nextTick(() => {
        const container = this.$refs.messagesContainer;
        if (container) container.scrollTop = container.scrollHeight;
    });
    
    // Enviar al servidor
    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(messageData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        
        if (data.success) {
            // Actualizar ID del mensaje temporal si existe
            if (data.user_message && data.user_message.id) {
                tempMsg.id = data.user_message.id;
            } else if (data.id) {
                tempMsg.id = data.id;
            }
            
            // SI ES RESPUESTA DE IA: agregar el mensaje de la IA
            if (data.is_ai_response === true && data.ai_response) {
                console.log('✅ Respuesta IA recibida:', data.ai_response.message);
                
                const aiMsg = {
                    id: data.ai_response.id || Date.now() + 1,
                    text: data.ai_response.message,
                    user_id: data.ai_response.user_id,
                    recipient_id: data.ai_response.recipient_id,
                    isOwn: false,
                    created_at: data.ai_response.created_at || new Date().toISOString()
                };
                this.messages.push(aiMsg);
                
                this.$nextTick(() => {
                    const container = this.$refs.messagesContainer;
                    if (container) container.scrollTop = container.scrollHeight;
                });
            }
            
            // Actualizar listas de usuarios y contadores
            this.fetchUsers();
            this.updateGlobalUnreadCount();
        }
    })
    .catch(error => {
        console.error('Error al enviar mensaje:', error);
        // Mensaje de error visible al usuario
        this.showTemporaryError('Error al enviar mensaje: ' + error.message);
    });
},

// Agregar este método helper para mostrar errores
showTemporaryError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed bottom-20 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-[9999] text-sm';
    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + message;
    document.body.appendChild(errorDiv);
    setTimeout(() => errorDiv.remove(), 4000);
},
                
                handleIncomingMessage(message, fromUser) { 
                    // Actualizar contador de no leídos
                    this.updateGlobalUnreadCount();
                    this.fetchUsers();
                    
                    if(this.isOpen && this.selectedUser && this.selectedUser.id === fromUser.id) { 
                        const newMsg = {
                            id: message.id,
                            text: message.message,
                            user_id: fromUser.id,
                            recipient_id: window.userId,
                            isOwn: false,
                            created_at: message.created_at
                        }; 
                        this.messages.push(newMsg); 
                        this.$nextTick(() => {
                            const container = this.$refs.messagesContainer; 
                            if(container) container.scrollTop = container.scrollHeight;
                        });
                        // Marcar como leídos si la conversación está abierta
                        this.markMessagesAsRead(fromUser.id);
                    }
                },
                
                markMessagesAsRead(userId) { 
                    fetch(`/chat/mark-read/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Mensajes marcados como leídos:', data);
                        // Actualizar el contador local
                        const userInList = this.users.find(u => u.id === userId);
                        if (userInList) userInList.unread = 0;
                        this.updateGlobalUnreadCount();
                        this.fetchUsers();
                    })
                    .catch(error => console.error('Error marking messages as read:', error)); 
                },
                
                formatTime(timestamp) { 
                    if(!timestamp) return ''; 
                    const date = new Date(timestamp); 
                    const now = new Date(); 
                    const diff = Math.floor((now - date) / 60000); 
                    if(diff < 1) return 'Ahora'; 
                    if(diff < 60) return `Hace ${diff} min`; 
                    if(diff < 1440) return `Hace ${Math.floor(diff / 60)} h`; 
                    return date.toLocaleDateString(); 
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function() { 
            window.tabManager = new TabManager(); 
            updateFavoritesUI(); 
            updateFavoriteStars(); 
            window.addEventListener('resize', function() { 
                if(window.innerWidth > 992) closeMobileMenu(); 
            }); 
            window.addEventListener('keydown', function(e) { 
                if(e.key === 'Escape') { 
                    const modal = document.getElementById('logout-confirm-modal'); 
                    if(modal && modal.classList.contains('flex')) { 
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
                        <p class="text-sm text-gray-600">¿Estás seguro de que deseas  salir?</p>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button onclick="document.getElementById('logout-confirm-modal').classList.add('hidden'); document.getElementById('logout-confirm-modal').classList.remove('flex');" class="px-4 py-2 text-sm border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancelar</button>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">Sí, Cerrar Sesión</button></form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>