import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // <--- NUEVA IMPORTACIÓN

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(), // <--- AÑADE ESTA LÍNEA
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'e74b-2806-2f0-4a41-e429-bd8d-73de-8d0d-4bfe.ngrok-free.app', // sin https y sin barra final
        },
    },
});