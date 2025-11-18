import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Tetap listen di semua interface
        hmr: {
            
            host: '172.23.171.242', // <-- GANTI DENGAN IP LOKAL LAPTOP ANDA
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