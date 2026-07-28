import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// ============================================
// CONFIGURACIÓN DE ECHO CON REVERB (USANDO WS)
// ============================================
try {
    // Obtener el token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST || '147.182.239.195',
        wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
        // 🔥 FORZAR WS (NO WSS) 🔥
        forceTLS: false,
        encrypted: false,
        enabledTransports: ['ws'],  // Solo usar WS
        disableStats: true,
        connectTimeout: 10000,
        reconnectAttempts: 5,
        reconnectDelay: 2000,
        // Autenticación
        auth: {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            }
        },
        // Para depuración
        logToConsole: true,
        // Configuración adicional para forzar WS
        useTLS: false,
        scheme: 'ws'
    });

    console.log('📡 Echo inicializado con Reverb (usando WS)');

    // ============================================
    // EVENTOS DE CONEXIÓN
    // ============================================
    setTimeout(() => {
        if (window.Echo && window.Echo.connector && window.Echo.connector.socket) {
            const socket = window.Echo.connector.socket;
            
            // Conexión exitosa
            socket.on('connect', () => {
                console.log('✅ WebSocket conectado a ws://' + 
                    import.meta.env.VITE_REVERB_HOST + ':' + 
                    import.meta.env.VITE_REVERB_PORT);
            });
            
            // Error de conexión
            socket.on('error', (error) => {
                console.error('❌ WebSocket error:', error);
            });
            
            // Desconexión
            socket.on('disconnect', (reason) => {
                console.log('⚠️ WebSocket desconectado:', reason);
            });
            
            // Reconexión
            socket.on('reconnect', () => {
                console.log('🔄 WebSocket reconectado');
            });
            
            socket.on('reconnecting', (attempt) => {
                console.log(`🔄 Intentando reconectar (${attempt})...`);
            });
        } else {
            console.warn('⚠️ WebSocket no disponible, usando polling');
        }
    }, 1500);

} catch (error) {
    console.error('❌ Error inicializando Echo:', error);
    window.Echo = null;
}

// ============================================
// FUNCIÓN DE UTILIDAD PARA VERIFICAR CONEXIÓN
// ============================================
window.checkWebSocketConnection = function() {
    if (!window.Echo) {
        console.log('❌ Echo no inicializado');
        return false;
    }
    
    const connector = window.Echo.connector;
    if (!connector) {
        console.log('❌ No hay conector');
        return false;
    }
    
    const socket = connector.socket;
    if (!socket) {
        console.log('❌ No hay socket');
        return false;
    }
    
    console.log('📡 Estado del socket:', {
        connected: socket.connected,
        connecting: socket.connecting,
        disconnected: socket.disconnected,
        id: socket.id
    });
    
    return socket.connected;
};

// ============================================
// FUNCIÓN PARA RECONECTAR MANUALMENTE
// ============================================
window.reconnectWebSocket = function() {
    if (window.Echo && window.Echo.connector && window.Echo.connector.socket) {
        console.log('🔄 Reconectando WebSocket...');
        window.Echo.connector.socket.connect();
    } else {
        console.log('❌ No se puede reconectar, Echo no disponible');
    }
};

console.log('🚀 bootstrap.js cargado correctamente (modo WS)');

export default window.Echo;