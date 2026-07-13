import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Silenciar advertencia de Tailwind CDN en producción
const originalWarn = console.warn;
console.warn = function(...args) {
    if (args[0] && args[0].includes('cdn.tailwindcss.com should not be used in production')) {
        return; // Ignora esta advertencia específica
    }
    originalWarn.apply(console, args);
};