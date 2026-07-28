import './bootstrap';

// Silenciar advertencias específicas
(function() {
    const originalWarn = console.warn;
    console.warn = function(...args) {
        const message = args.join(' ');
        // Ignora advertencias de Tailwind CDN y Echo
        if (message.includes('cdn.tailwindcss.com') || 
            message.includes('Echo no pudo conectar')) {
            return;
        }
        originalWarn.apply(console, args);
    };
})();

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


