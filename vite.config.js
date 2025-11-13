import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // TAMBAHKAN BLOK 'server' INI
    server: {
        host: '0.0.0.0', // Tetap listen di semua interface
        hmr: {
            // 'hmr' (Hot Module Replacement) adalah yang menulis alamat ke browser
            // Kita paksa dia pakai IP yang benar:
            host: '192.168.18.59', // <-- GANTI DENGAN IP LOKAL LAPTOP ANDA
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