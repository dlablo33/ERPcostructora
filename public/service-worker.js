// service-worker.js - Versión optimizada para iOS
const CACHE_NAME = 'erp-dashboard-v3';
const urlsToCache = [
    '/',
    '/home',
    '/dashboard',
    '/manifest.json',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png'
];

// Instalación
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('✅ Cache abierto');
                return cache.addAll(urlsToCache);
            })
            .then(() => self.skipWaiting())
    );
});

// Activación
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
        .then(() => self.clients.claim())
    );
});

// Interceptar peticiones
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }
                return fetch(event.request).then(response => {
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }
                    const responseToCache = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, responseToCache);
                    });
                    return response;
                });
            })
    );
});

// ===== NOTIFICACIONES PUSH PARA iOS =====
self.addEventListener('push', function(event) {
    try {
        let data = {};
        
        try {
            data = event.data.json();
        } catch (e) {
            data = {
                title: '🔔 Nueva notificación',
                body: event.data ? event.data.text() : 'Tienes una nueva notificación'
            };
        }
        
        console.log('📩 Push recibido en iOS:', data);
        
        const title = data.notification?.title || data.title || '🔔 Nueva notificación';
        const body = data.notification?.message || data.body || data.message || 'Tienes una nueva notificación';
        const icon = data.notification?.icon || '/images/icons/icon-192x192.png';
        const url = data.notification?.url || data.url || '/home';
        const tag = data.notification?.tag || 'notification-' + Date.now();

        const options = {
            body: body,
            icon: icon,
            badge: '/images/icons/icon-72x72.png',
            vibrate: [200, 100, 200],
            data: {
                url: url,
                date: Date.now()
            },
            actions: [
                {
                    action: 'open',
                    title: 'Abrir'
                },
                {
                    action: 'close',
                    title: 'Cerrar'
                }
            ],
            tag: tag,
            renotify: true,
            requireInteraction: true,
            silent: false,
            // 👇 IMPORTANTE PARA iOS - Mostrar en Centro de Notificaciones
            priority: 'high',
            urgency: 'high'
        };

        event.waitUntil(
            self.registration.showNotification(title, options)
                .then(() => {
                    console.log('✅ Notificación mostrada en iOS');
                    // Enviar mensaje a la app para actualizar la UI
                    self.clients.matchAll().then(clients => {
                        clients.forEach(client => {
                            client.postMessage({
                                type: 'NOTIFICATION_RECEIVED',
                                data: data
                            });
                        });
                    });
                })
                .catch(err => console.error('❌ Error mostrando notificación:', err))
        );
        
    } catch (e) {
        console.error('❌ Error en push:', e);
    }
});

// Manejar clic en notificación
self.addEventListener('notificationclick', function(event) {
    console.log('📱 Notificación clickeada en iOS');
    event.notification.close();
    
    const urlToOpen = event.notification.data?.url || '/home';
    
    if (event.action === 'open' || event.action === '') {
        event.waitUntil(
            clients.matchAll({
                type: 'window',
                includeUncontrolled: true
            }).then(function(clientList) {
                // Intentar enfocar una ventana existente
                for (var i = 0; i < clientList.length; i++) {
                    var client = clientList[i];
                    if (client.url === urlToOpen && 'focus' in client) {
                        return client.focus();
                    }
                }
                // Abrir nueva ventana
                if (clients.openWindow) {
                    return clients.openWindow(urlToOpen);
                }
            })
        );
    }
});

// 👇 NUEVO: Recibir mensajes de la app
self.addEventListener('message', function(event) {
    console.log('📩 Mensaje recibido en Service Worker:', event.data);
    if (event.data && event.data.type === 'TEST_NOTIFICATION') {
        // Mostrar notificación de prueba
        self.registration.showNotification('🔔 Notificación de prueba', {
            body: '¡Esta notificación debería aparecer en el Centro de Notificaciones!',
            icon: '/images/icons/icon-192x192.png',
            badge: '/images/icons/icon-72x72.png',
            vibrate: [200, 100, 200],
            requireInteraction: true,
            priority: 'high',
            urgency: 'high'
        });
    }
});