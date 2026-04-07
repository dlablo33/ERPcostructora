import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

try {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST || '147.182.239.195',
        wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
        connectTimeout: 5000,
        reconnectAttempts: 3,
        reconnectDelay: 1000,
    });
    
    console.log('✅ Echo initialized');
    
    // Esperar a que la conexión esté lista
    setTimeout(() => {
        if (window.Echo && window.Echo.connector && window.Echo.connector.socket) {
            window.Echo.connector.socket.on('connect', () => {
                console.log('✅ Conectado a Reverb');
            });
            
            window.Echo.connector.socket.on('error', (error) => {
                console.error('❌ WebSocket error:', error);
            });
            
            window.Echo.connector.socket.on('disconnect', (reason) => {
                console.log('❌ Desconectado:', reason);
            });
        } else {
            console.warn('⚠️ Echo no pudo conectar, usando modo polling');
        }
    }, 1000);
    
} catch (error) {
    console.error('❌ Error inicializando Echo:', error);
    window.Echo = null;
}

export default window.Echo;