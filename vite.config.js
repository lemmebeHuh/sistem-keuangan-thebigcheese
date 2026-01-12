import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Tetap listen di semua interface
        hmr: {
            
            host: '192.168.43.111', // <-- GANTI DENGAN IP LOKAL LAPTOP ANDA
        },
        cors: true
    },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});